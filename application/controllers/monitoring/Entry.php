<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Entry extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('perencanaan/M_spa', 'm_spa');
        $this->load->model('monitoring/m_tl_entry', 'm_tl_entry');
        $this->is_login();
        if(!$this->is_auditor()) $this->load->view('/errors/html/err_401');
    }

    public function index()
    {
        $data['menu']           = 'pelaksanaan';
        $data['sub_menu']       = 'entry';
        $data['list_ja']        = $this->master_act->jenis_audit();
        $data['list_divisi']    = $this->master_act->divisi();
        $data['title']          = 'Laporan Hasil Audit';
        $data['content']        = 'content/monitoring/entry/v_lha';
        $this->show($data);
    }

    function getFileUpload($id_tl)
    {

        if($this->is_auditor() && $this->input->server('REQUEST_METHOD') === 'GET') 
        {
            $query = $this->db->select('NOMOR_LHA, FILE_LHA, TANGGAL_LHA')->from('TL_ENTRY')
                        ->where('ID_TL', $id_tl)->get()->row();
            echo json_encode($query);
        }
    }

    public function lha()
    {
        $data['menu']           = 'pelaksanaan';
        $data['sub_menu']       = 'entry';
        $data['list_ja']        = $this->master_act->jenis_audit();
        $data['list_divisi']    = $this->master_act->divisi();
        $data['nomor_spa']      = $this->m_spa->spa_list();
        $data['title']          = 'Entry Laporan Hasil Audit';
        $data['content']        = 'content/monitoring/entry/v_entry';
        $this->show($data);
    }

    function get_detil_spa()
    {
        $nomor = $this->input->post('nomor');
        $query = $this->db->get_where('SPA', ['NOMOR_SURAT' => $nomor])->row();
        print_r(json_encode($query));
    }

    public function lha_json()
    {
        header('Content-Type: application/json');
        if($this->is_auditor() && $this->input->server('REQUEST_METHOD') === 'POST') echo json_encode($this->m_tl_entry->lha());
    }

    public function simpan()
    {
        $request                = $this->input->post();
        $NOMOR_SPA              = $request['NOMOR_SPA'];
        $ID_JENIS_AUDIT         = $request['ID_JENIS_AUDIT'];
        $AUDITEE                = $request['AUDITEE'];
        $TAHUN                  = $request['TAHUN'];
        $TGL_PERIODE_MULAI      = $request['TGL_PERIODE_MULAI'];
        $TGL_PERIODE_SELESAI    = $request['TGL_PERIODE_SELESAI'];
        $MASA_AUDIT_AWAL        = $request['MASA_AUDIT_AWAL'];
        $MASA_AUDIT_AKHIR       = $request['MASA_AUDIT_AKHIR'];
        $cek_lha                = $this->m_tl_entry->cek_lha($ID_JENIS_AUDIT, $AUDITEE, $TAHUN);
        // echo $cek_lha;
        if ($cek_lha == '') {
            $data = array(
                'NOMOR_SPA'             => is_empty_return_null($NOMOR_SPA),
                'ID_JENIS_AUDIT'        => is_empty_return_null($ID_JENIS_AUDIT),
                'AUDITEE'               => is_empty_return_null($AUDITEE),
                'TAHUN'                 => is_empty_return_null($TAHUN),
                'TGL_PERIODE_MULAI'     => is_empty_return_null($TGL_PERIODE_MULAI),
                'TGL_PERIODE_SELESAI'   => is_empty_return_null($TGL_PERIODE_SELESAI),
                'MASA_AUDIT_AWAL'       => is_empty_return_null($MASA_AUDIT_AWAL),
                'MASA_AUDIT_AKHIR'      => is_empty_return_null($MASA_AUDIT_AKHIR),
                'STATUS'                => 1,
                'ID_PEMBUAT'            => $this->session->ID_USER,
                'created_at'            => date('Y-m-d H:i:s')
            );
            $this->m_tl_entry->add($data, 'TL_ENTRY');
            $success_message = 'Data berhasil disimpan.';
            $this->session->set_flashdata('success', $success_message);
            echo base_url('monitoring/entry/');
        } else {
            echo "ERR";
        }
    }

    public function tindak_lanjut($id_tl)
    {
        $data['menu']           = 'pelaksanaan';
        $data['sub_menu']       = 'entry';
        $data['detail_lha']     = $this->m_tl_entry->lha($id_tl);
        $data['list_jabatan']   = $this->master_act->jabatan();
        $data['title']          = 'Tindak Lanjut LHA';
        $data['content']        = 'content/monitoring/entry/v_tindak_lanjut';
        $this->show($data);
    }

    function cek_no_urut($id_tl, $no_urut)
    {  
        $cek = $this->db->get_where('TL_TEMUAN', array('ID_TL' => $id_tl, 'STATUS' => 1, 'NO_URUT' => $no_urut))->num_rows();
        echo $cek;
    }

    public function hasil_monitoring($id_rekomendasi)
    {
        $menu['menu']               = 'pelaksanaan';
        $menu['sub_menu']           = 'entry';
        $data['detail_rekomendasi'] = $this->m_tl_entry->hasil_monitoring($id_rekomendasi);
        $this->load->view('/template/header', $menu);
        $this->load->view('/content/monitoring/entry/v_update_hasil_monitoring', $data);
        $this->load->view('/template/footer');
    }

    function upload_lampiran()
    {
        $id_tl = $this->input->post('id_tl');
        $config['upload_path']      = './storage/file_final/';
        $config['allowed_types']    = 'gif|jpg|png|jpeg|bmp|pdf|docx|doc|xlsx|xls';
        $this->load->library('upload', $config);
        $ext = pathinfo($_FILES['LAMPIRAN']['name'], PATHINFO_EXTENSION);
        $file = basename($_FILES['LAMPIRAN']['name'], "." . $ext);
        $nama_file = str_replace(".", "_", $file);
        $nama_file = $id_tl . '_' . str_replace(" ", "_", $nama_file) . '_' . date('YmdHis') . '.' . $ext;
        // print_r($nama_file);die();
        $data = array(
            'NOMOR_LHA'     => $this->input->post('NOMOR_LHA'),
            'TANGGAL_LHA'   => is_empty_return_null($this->input->post('TANGGAL_LHA'))
        );
        if (!empty($_FILES['LAMPIRAN']['name'])) {
            $config['file_name'] = $nama_file;
            $this->upload->initialize($config);
            if ($this->upload->do_upload('LAMPIRAN')) {
                $this->upload->data();
                $data['FILE_LHA'] = $nama_file;
            } else {
                $error_message = $this->upload->display_errors();
                $this->session->set_flashdata('error', $error_message);
                die();
            }
        } 
        $this->db->update('TL_ENTRY', $data, ['ID_TL' => $id_tl],);
        $success_message = 'Berhasil.';
        $this->session->set_flashdata('success', $success_message);
        // else {
        //     $error_message = "File yang diupload kosong.";
        //     $this->session->set_flashdata('error', $error_message);
        // }
        redirect(base_url('monitoring/entry'), 'refresh');
    }

    public function update_hasil_monitoring($id_rekomendasi)
    {
        $config['upload_path']      = './storage/upload/lampiran/hasil_monitoring/';
        $config['allowed_types']    = '*';
        $this->load->library('upload', $config);
        // $this->upload->initialize($config);
        $lampiran = array();
        $files = $_FILES['lampiran'];
        $urut = 1;
        foreach ($files['name'] as $key => $image) {
            $_FILES['lampiran[]']['name'] = $files['name'][$key];
            $_FILES['lampiran[]']['type'] = $files['type'][$key];
            $_FILES['lampiran[]']['tmp_name'] = $files['tmp_name'][$key];
            $_FILES['lampiran[]']['error'] = $files['error'][$key];
            $_FILES['lampiran[]']['size'] = $files['size'][$key];

            $fileName = $id_rekomendasi . '_' . date('YmdHis') . '_' . $urut . '_' . $image;
            $fileName = str_replace(" ", "_", $fileName);

            $lampiran[] = $fileName;

            $config['file_name'] = $fileName;

            $this->upload->initialize($config);

            if ($this->upload->do_upload('lampiran[]')) {
                $this->upload->data();
                $data = array(
                    'ID_REKOMENDASI'          => $id_rekomendasi,
                    'ATTACHMENT'          => $fileName
                );
                $this->m_tl_entry->add($data, 'ATT_HASIL_MONITORING');
            } else {
                $error_message = $this->upload->display_errors();
                $this->session->set_flashdata('error', $error_message);
            }
            $urut++;
        }
        $data = array(
            'HASIL_MONITORING'         => $this->input->post('HASIL_MONITORING'),
            'TK_PENYELESAIAN'        => $this->input->post('TK_PENYELESAIAN'),
            'UPDATED_BY'    => $this->session->ID_USER,
            // 'LAMPIRAN'           => $gambar,
            'STATUS'           => '2',
            'updated_at'    => date('Y-m-d H:i:s')
        );
        // print_r($data);die();

        $this->m_tl_entry->update_rekomendasi($data, $id_rekomendasi);
        $success_message = 'Data berhasil diupdate.';
        $this->session->set_flashdata('success', $success_message);

        redirect(base_url('monitoring/entry/'));
    }

    public function hapus_lha($id_tl)
    {
        $data = array(
            'STATUS'        => '2',
            'updated_at'    => date('Y-m-d H:i:s')
        );

        $this->m_tl_entry->update($data, $id_tl);
        $success_message = 'Data berhasil dihapus.';
        $this->session->set_flashdata('success', $success_message);

        redirect(base_url('monitoring/entry/'));
    }

    public function temuan($id_temuan)
    {
        $data['menu']           = 'pelaksanaan';
        $data['sub_menu']       = 'entry';
        $data['detail_temuan']  = $this->m_tl_entry->temuan_detail($id_temuan);
        $data['list_jabatan']   = $this->master_act->jabatan();
        $data['title']          = 'Entry Rekomendasi';
        $data['content']        = 'content/monitoring/entry/v_temuan';
        $this->show($data);
    }

    public function temuan_json($id_tl = '')
    {
        header('Content-Type: application/json');
        if($this->is_auditor() && $this->input->server('REQUEST_METHOD') === 'POST')
            echo json_encode($this->m_tl_entry->temuan($id_tl));
    }

    public function hal_json($id_tl = '')
    {
        header('Content-Type: application/json');
        if($this->is_auditor() && $this->input->server('REQUEST_METHOD') === 'POST')
            echo json_encode($this->m_tl_entry->hal($id_tl));
    }

    public function rekomendasi_json($id_tl = '')
    {
        header('Content-Type: application/json');
        if($this->is_auditor() && $this->input->server('REQUEST_METHOD') === 'POST')
            echo json_encode($this->m_tl_entry->rekomendasi($id_tl));
    }

    // Derian update
    public function rekomendasi_json_($id_tl = '')
    {
        header('Content-Type: application/json');
        if($this->is_auditor() && $this->input->server('REQUEST_METHOD') === 'POST')
            echo json_encode($this->m_tl_entry->_rekomendasi($id_tl, 1));
    }

    public function add_temuan($id_spa)
    {
        // print_r($_FILES['lampiran']['name']);die();
        $id_temuan     = $this->m_tl_entry->last_id('TL_TEMUAN');
        $id_temuan     = $id_temuan->max + 1;
        $this->db->trans_start();
        $files = $_FILES['lampiran'];
        if (!empty($files['name'][0])) {
            $config['upload_path']      = './storage/upload/lampiran/temuan/';
            $config['allowed_types']    = '*';
            $this->load->library('upload', $config);
            $lampiran = array();
            $urut = 1;
            foreach ($files['name'] as $key => $image) {
                $_FILES['lampiran[]']['name'] = $files['name'][$key];
                $_FILES['lampiran[]']['type'] = $files['type'][$key];
                $_FILES['lampiran[]']['tmp_name'] = $files['tmp_name'][$key];
                $_FILES['lampiran[]']['error'] = $files['error'][$key];
                $_FILES['lampiran[]']['size'] = $files['size'][$key];

                $fileName = $id_temuan . '_' . date('YmdHis') . '_' . $urut . '_' . $image;
                $fileName = str_replace(" ", "_", $fileName);

                $lampiran[] = $fileName;

                $config['file_name'] = $fileName;

                $this->upload->initialize($config);

                if ($this->upload->do_upload('lampiran[]')) {
                    $this->upload->data();
                    $data = array(
                        'ID_TEMUAN'          => $id_temuan,
                        'ATTACHMENT'          => $fileName,
                        'FILE_NAME'             => $image
                    );
                    $this->m_tl_entry->add($data, 'ATT_TEMUAN');
                } else {
                    $error_message = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error_message);
                }
                $urut++;
            }
        }
        // $this->upload->do_upload('lampiran[]');
        // $gbr = $this->upload->data();
        // $config['image_library']    = 'gd2';
        // $config['source_image']     = './storage/upload/lampiran/temuan/'.$gbr['file_name'];
        // $config['create_thumb']     = FALSE;
        // $config['maintain_ratio']   = FALSE;
        // $config['new_image']        = './storage/upload/lampiran/temuan/'.$gbr['file_name'];
        // $this->image_lib->resize();

        // $gambar                     = $gbr['file_name'];
        $data = array(
            'ID'         => $id_temuan,
            'ID_TL'          => $this->input->post('id_tl'),
            'TEMUAN'        => $this->input->post('temuan'),
            'JUDUL_TEMUAN'  => $this->input->post('JUDUL_TEMUAN'),
            'NO_URUT'       => $this->input->post('NO_URUT'),
            'KRITERIA'       => $this->input->post('kriteria'),
            'ROOT_CAUSE'       => $this->input->post('root_cause'),
            'IMPLIKASI'       => $this->input->post('implikasi'),
            'KOMENTAR_AUDITI'       => $this->input->post('komentar_auditi'),
            'PRIORITAS'       => $this->input->post('PRIORITAS_TEMUAN'),
            'ID_PEMBUAT'    => $this->session->ID_USER,
            // 'LAMPIRAN'           => $gambar,
            'created_at'    => date('Y-m-d H:i:s'),
            'STATUS'        => 1
        );
        $this->m_tl_entry->add($data, 'TL_TEMUAN');
        $this->db->trans_complete();
        $success_message = 'Data berhasil ditambah.';
        $this->session->set_flashdata('success', $success_message);

        redirect(base_url('monitoring/entry/tindak_lanjut/' . $id_spa));
    }

    public function add_hal($id_spa)
    {
        $this->db->trans_start();
        $data = array(
            'ID_TL'             => $this->input->post('id_tl_hal'),
            'OBSERVASI'         => $this->input->post('OBSERVASI'),
            'ID_PEMBUAT'        => $this->session->ID_USER,
            'JUDUL_OBSERVASI'   => $this->input->post('JUDUL_OBSERVASI'),
            'created_at'        => date('Y-m-d H:i:s'),
            'NO_URUT'           => $this->input->post('NO_URUT_HAL'),
            'REKOMENDASI'       => $this->input->post('REKOMENDASI'),
            'PIC'               => $this->input->post('PIC'),
            'BATAS_WAKTU'       => $this->input->post('BATAS_WAKTU'),
            'PRIORITAS'         => $this->input->post('PRIORITAS'),
            'STATUS'            => 1
        );
        $this->db->insert('TL_PERHATIAN', $data);
        $this->db->trans_complete();
        $success_message = 'Data berhasil ditambah.';
        $this->session->set_flashdata('success', $success_message);

        redirect(base_url('monitoring/entry/tindak_lanjut/' . $id_spa));
    }

    public function get_lampiran_temuan($id)
    {
        header('Content-Type: application/json');
        if($this->is_auditor() && $this->input->server('REQUEST_METHOD') === 'POST')
            echo json_encode($this->m_tl_entry->get_lampiran_temuan($id));
    }

    public function update_temuan($id_temuan)
    {
        $files = $_FILES['lampiran'];
        if (!empty($files['name'][0])) {
            $config['upload_path']      = './storage/upload/lampiran/temuan/';
            $config['allowed_types']    = '*';
            $this->load->library('upload', $config);
            $lampiran = array();
            $urut = 1;
            foreach ($files['name'] as $key => $image) {
                $_FILES['lampiran[]']['name'] = $files['name'][$key];
                $_FILES['lampiran[]']['type'] = $files['type'][$key];
                $_FILES['lampiran[]']['tmp_name'] = $files['tmp_name'][$key];
                $_FILES['lampiran[]']['error'] = $files['error'][$key];
                $_FILES['lampiran[]']['size'] = $files['size'][$key];

                $fileName = $id_temuan . '_' . date('YmdHis') . '_' . $urut . '_' . $image;
                $fileName = str_replace(" ", "_", $fileName);

                $lampiran[] = $fileName;

                $config['file_name'] = $fileName;

                $this->upload->initialize($config);

                if ($this->upload->do_upload('lampiran[]')) {
                    $this->upload->data();
                    $data = array(
                        'ID_TEMUAN'          => $id_temuan,
                        'ATTACHMENT'          => $fileName,
                        'FILE_NAME'             => $image
                    );
                    $this->m_tl_entry->add($data, 'ATT_TEMUAN');
                } else {
                    $error_message = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error_message);
                }
                $urut++;
            }
        }

        $data = array(
            'TEMUAN'        => $this->input->post('temuan'),
            'KRITERIA'       => $this->input->post('kriteria'),
            'ROOT_CAUSE'       => $this->input->post('root_cause'),
            'IMPLIKASI'       => $this->input->post('implikasi'),
            'KOMENTAR_AUDITI'       => $this->input->post('komentar_auditi'),
            'PRIORITAS'       => $this->input->post('PRIORITAS_TEMUAN'),
            'JUDUL_TEMUAN'  => $this->input->post('JUDUL_TEMUAN'),
            'NO_URUT'       => $this->input->post('NO_URUT'),
            'ID_PEMBUAT'    => $this->session->ID_USER,
            'updated_at'    => date('Y-m-d H:i:s')
        );
        $this->m_tl_entry->update_temuan($data, $id_temuan);
        $success_message = 'Data berhasil diupdate.';
        $this->session->set_flashdata('success', $success_message);

        redirect(base_url('monitoring/entry/tindak_lanjut/' . $this->input->post('id_tl')));
    }

    public function update_hal($id)
    {
        $data = array(
            'OBSERVASI'         => $this->input->post('OBSERVASI'),
            'JUDUL_OBSERVASI'   => $this->input->post('JUDUL_OBSERVASI'),
            'NO_URUT'           => $this->input->post('NO_URUT_HAL'),
            'REKOMENDASI'       => $this->input->post('REKOMENDASI'),
            'PIC'               => $this->input->post('PIC'),
            'BATAS_WAKTU'       => $this->input->post('BATAS_WAKTU'),
            'PRIORITAS'         => $this->input->post('PRIORITAS'),
            'updated_at'    => date('Y-m-d H:i:s')
        );
        $this->db->update('TL_PERHATIAN', $data, ['ID'=>$id]);
        $success_message = 'Data berhasil diupdate.';
        $this->session->set_flashdata('success', $success_message);

        redirect(base_url('monitoring/entry/tindak_lanjut/' . $this->input->post('id_tl_hal')));
    }

    public function add_rekomendasi($id_tl)
    {
        $id_rekomendasi     = $this->m_tl_entry->last_id('TL_REKOMENDASI');
        $id_rekomendasi     = $id_rekomendasi->max + 1;

        $files = $_FILES['lampiran'];
        if (!empty($files['name'][0])) {
            $config['upload_path']      = './storage/upload/lampiran/rekomendasi/';
            $config['allowed_types']    = '*';
            $this->load->library('upload', $config);
            $lampiran = array();
            $urut = 1;
            foreach ($files['name'] as $key => $image) {
                $_FILES['lampiran[]']['name'] = $files['name'][$key];
                $_FILES['lampiran[]']['type'] = $files['type'][$key];
                $_FILES['lampiran[]']['tmp_name'] = $files['tmp_name'][$key];
                $_FILES['lampiran[]']['error'] = $files['error'][$key];
                $_FILES['lampiran[]']['size'] = $files['size'][$key];

                $fileName = $id_rekomendasi . '_' . date('YmdHis') . '_' . $urut . '_' . $image;
                $fileName = str_replace(" ", "_", $fileName);

                $lampiran[] = $fileName;

                $config['file_name'] = $fileName;

                $this->upload->initialize($config);

                if ($this->upload->do_upload('lampiran[]')) {
                    $this->upload->data();
                    $data = array(
                        'ID_REKOMENDASI'          => $id_rekomendasi,
                        'ATTACHMENT'          => $fileName,
                        'FILE_NAME'         => $image
                    );
                    $this->m_tl_entry->add($data, 'ATT_REKOMENDASI');
                } else {
                    $error_message = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error_message);
                }
                $urut++;
            }
        }

        $data = array(
            'ID'             => $id_rekomendasi,
            'ID_TEMUAN'              => is_empty_return_null($this->input->post('ID_TEMUAN')),
            'BATAS_WAKTU'              => is_empty_return_null($this->input->post('BATAS_WAKTU')),
            // 'TGL_PENYELESAIAN'      => is_empty_return_null($this->input->post('TGL_PENYELESAIAN')),
            // 'PIC'  					=>is_empty_return_null( $this->input->post('PIC')),
            'REKOMENDASI'      => is_empty_return_null($this->input->post('REKOMENDASI')),
            // 'LAMPIRAN'  			=> $gambar,
            'STATUS'    => $this->input->post('STATUS'),
            'created_at'    => date('Y-m-d H:i:s'),
            'ID_PEMBUAT'            => $this->session->ID_USER
        );
        $this->m_tl_entry->add($data, 'TL_REKOMENDASI');
        $total_pic  = count($this->input->post('pic'));
        for ($i = 0; $i < $total_pic; $i++) {
            if (trim($this->input->post('pic')[$i]) != '') {
                $data = array(
                    'ID_REKOMENDASI'        => $id_rekomendasi,
                    'PIC'               => $this->input->post('pic')[$i]
                );
                $this->m_tl_entry->add($data, 'PIC_REKOMENDASI');
            }
        }

        // insert data IPC utama
        $data = array(
            'ID_REKOMENDASI'        => $id_rekomendasi,
            'PIC'               => $this->input->post('pic_utama'),
            'PRIMARY'           => 'Y'
        );
        $this->m_tl_entry->add($data, 'PIC_REKOMENDASI');

        $success_message = 'Data berhasil ditambah.';
        $this->session->set_flashdata('success', $success_message);

        redirect(base_url('monitoring/entry/tindak_lanjut/' . $id_tl));
    }

    public function edit_rekomendasi($id_temuan, $id_rekomendasi)
    {
        $data['menu']           = 'pelaksanaan';
        $data['sub_menu']       = 'entry';
        $data['detail_temuan']  = $this->m_tl_entry->temuan_detail($id_temuan);
        $data['list_jabatan']   = $this->master_act->jabatan();
        $data['id_rekomendasi'] = $id_rekomendasi;
        $data['title']          = 'Edit Rekomendasi';
        $data['content']        = 'content/monitoring/entry/v_update_rekomendasi';
        $this->show($data);
    }

    public function get_rekomendasi_byId($id)
    {
        header('Content-Type: application/json');
        if($this->is_auditor() && $this->input->server('REQUEST_METHOD') === 'POST')
            echo json_encode($this->m_tl_entry->get_recomendasi_byId($id));
    }

    public function update_rekomendasi($id_tl, $id_rekomendasi)
    {
        $files = $_FILES['lampiran'];

        if (!empty($files['name'][0])) {
            $config['upload_path']      = './storage/upload/lampiran/rekomendasi/';
            $config['allowed_types']    = '*';
            $this->load->library('upload', $config);
            $lampiran = array();
            $urut = 1;
            foreach ($files['name'] as $key => $image) {
                $_FILES['lampiran[]']['name'] = $files['name'][$key];
                $_FILES['lampiran[]']['type'] = $files['type'][$key];
                $_FILES['lampiran[]']['tmp_name'] = $files['tmp_name'][$key];
                $_FILES['lampiran[]']['error'] = $files['error'][$key];
                $_FILES['lampiran[]']['size'] = $files['size'][$key];

                $fileName = $id_rekomendasi . '_' . date('YmdHis') . '_' . $urut . '_' . $image;
                $fileName = str_replace(" ", "_", $fileName);

                $lampiran[] = $fileName;

                $config['file_name'] = $fileName;

                $this->upload->initialize($config);

                if ($this->upload->do_upload('lampiran[]')) {
                    $this->upload->data();
                    $data = array(
                        'ID_REKOMENDASI'          => $id_rekomendasi,
                        'ATTACHMENT'          => $fileName,
                        'FILE_NAME'           => $image
                    );
                    $this->m_tl_entry->add($data, 'ATT_REKOMENDASI');
                } else {
                    $error_message = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error_message);
                }
                $urut++;
            }
        }

        $data = array(
            'ID_TEMUAN'              => is_empty_return_null($this->input->post('ID_TEMUAN')),
            'BATAS_WAKTU'              => is_empty_return_null($this->input->post('BATAS_WAKTU')),
            // 'TGL_PENYELESAIAN'      => is_empty_return_null($this->input->post('TGL_PENYELESAIAN')),
            'REKOMENDASI'      => is_empty_return_null($this->input->post('REKOMENDASI')),
            'STATUS'    => $this->input->post('STATUS'),
            'updated_at'    => date('Y-m-d H:i:s'),
            'ID_PEMBUAT'            => $this->session->ID_USER
        );
        $this->m_tl_entry->update_rekomendasi($data, $id_rekomendasi);

        // delete data pic existing
        $this->m_tl_entry->delete('PIC_REKOMENDASI', 'ID_REKOMENDASI', $id_rekomendasi);

        $total_pic  = count($this->input->post('pic'));
        for ($i = 0; $i < $total_pic; $i++) {
            if (trim($this->input->post('pic')[$i]) != '') {
                $data = array(
                    'ID_REKOMENDASI'        => $id_rekomendasi,
                    'PIC'               => $this->input->post('pic')[$i]
                );
                $this->m_tl_entry->add($data, 'PIC_REKOMENDASI');
            }
        }

        // insert data IPC utama
        $data = array(
            'ID_REKOMENDASI'        => $id_rekomendasi,
            'PIC'               => $this->input->post('pic_utama'),
            'PRIMARY'           => 'Y'
        );
        $this->m_tl_entry->add($data, 'PIC_REKOMENDASI');

        $success_message = 'Data berhasil diupdate.';
        $this->session->set_flashdata('success', $success_message);

        redirect(base_url('monitoring/entry/tindak_lanjut/' . $id_tl));
    }

    public function delete_att_temuan($id)
    {
        $this->m_tl_entry->delete('ATT_TEMUAN', 'ID', $id);
    }

    public function delete_att_rekom($id)
    {
        $this->m_tl_entry->delete('ATT_REKOMENDASI', 'ID', $id);
    }

    public function delete_att_hasil_rekom($id)
    {
        $this->m_tl_entry->delete('ATT_HASIL_MONITORING', 'ID', $id);
    }

    public function delete_temuan_rekom($type, $id)
    {

        $data = array(
            'STATUS'         => '2',
            'updated_at'    => date('Y-m-d H:i:s')
        );

        if ($type == 'TEMUAN') {
            $this->m_tl_entry->update_temuan($data, $id);
        } else {
            $this->m_tl_entry->update_rekomendasi($data, $id);
        }

        $success_message = 'Data berhasil dihapus.';
        $this->session->set_flashdata('success', $success_message);
    }

    public function delete_hal($id)
    {

        $data = array(
            'STATUS'         => '2',
            'updated_at'    => date('Y-m-d H:i:s')
        );
        $this->db->where('ID', $id);
        $this->db->update('TL_PERHATIAN', $data);

        $success_message = 'Data berhasil dihapus.';
        $this->session->set_flashdata('success', $success_message);
    }

    public function get_temuan_by_id($id)
    {
        header('Content-Type: application/json');
        if($this->is_auditor() && $this->input->server('REQUEST_METHOD') === 'POST')
            echo json_encode($this->m_tl_entry->get_temuan_by_id($id));
    }

    public function get_hal_by_id($id)
    {
        header('Content-Type: application/json');
        if($this->is_auditor() && $this->input->server('REQUEST_METHOD') === 'POST')
            echo json_encode($this->m_tl_entry->get_hal_by_id($id));
    }
}
