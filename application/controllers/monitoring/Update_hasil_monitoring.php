<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Update_hasil_monitoring extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('upload');
        $this->load->model('monitoring/m_tl_entry', 'm_tl_entry');
        $this->is_login();
    }

    public function index()
    {
        $data['menu']           = 'monitoring';
        $data['sub_menu']       = 'update_hasil_monitoring';
        $data['list_ja']        = $this->master_act->jenis_audit();
        $data['list_divisi']    = $this->master_act->divisi();
        $data['title']          = 'Update Hasil Monitoring';
        if($this->is_auditor())
            $data['content']        = 'content/monitoring/update_hasil_monitoring/v_lha';
        else
            $data['content']        = 'content/monitoring/update_hasil_monitoring/v_update_hasil_monitoring_auditee';
        $this->show($data);
    }

    public function lha()
    {
        $menu['menu']           = 'monitoring';
        $menu['sub_menu']       = 'update_hasil_monitoring';
        $data['list_ja']        = $this->master_act->jenis_audit();
        $data['list_divisi']    = $this->master_act->divisi();
        $this->load->view('/template/header', $menu);
        $this->load->view('/content/monitoring/update_hasil_monitoring/v_entry', $data);
        $this->load->view('/template/footer');
    }

    public function lha_json()
    {
        if($this->is_auditor() && $this->input->server('REQUEST_METHOD') === 'POST') 
            echo json_encode($this->m_tl_entry->lha());
    }

    public function list_rekomendasi_json()
    {
        if($this->is_auditee() && $this->input->server('REQUEST_METHOD') === 'POST') 
            echo json_encode($this->m_tl_entry->list_rekomendasi_json());
    }

    public function temuan_json_auditee()
    {
        header('Content-Type: application/json');
        if($this->is_auditee() && $this->input->server('REQUEST_METHOD') === 'POST')
            echo json_encode($this->m_tl_entry->temuan_auditee($this->session->ID_JABATAN));
    }

    public function rekomendasi_json_auditee($id_tl = '')
    {
        header('Content-Type: application/json');
        if($this->is_auditee() && $this->input->server('REQUEST_METHOD') === 'POST')
            echo json_encode($this->m_tl_entry->_rekomendasi_auditee($id_tl, 1));
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
                'STATUS'                => 1,
                'ID_PEMBUAT'            => $this->session->ID_USER,
                'created_at'            => date('Y-m-d H:i:s')
            );
            $this->m_tl_entry->add($data, 'TL_ENTRY');
            $success_message = 'Data berhasil disimpan.';
            $this->session->set_flashdata('success', $success_message);
            echo base_url('monitoring/update_hasil_monitoring/');
        } else {
            echo "ERR";
        }
    }

    public function tindak_lanjut($id_tl)
    {
        $data['menu']           = 'monitoring';
        $data['sub_menu']       = 'update_hasil_monitoring';
        $data['detail_lha']     = $this->m_tl_entry->lha($id_tl);
        $data['title']          = 'Tindak Lanjut Laporan Hasil Audit';
        $data['content']        = 'content/monitoring/update_hasil_monitoring/v_tindak_lanjut';
        $this->show($data);
    }

    public function hasil_monitoring($id_tl, $id_rekomendasi)
    {
        $id_jabatan                 = $this->session->userdata('ID_JABATAN');
        $data['menu']               = 'monitoring';
        $data['sub_menu']           = 'update_hasil_monitoring';
        $data['list_pic']           = $this->db->select('j.NAMA_JABATAN')
                                        ->from('PIC_REKOMENDASI p')
                                        ->join('TM_JABATAN j', 'p.PIC = j.ID_JABATAN', 'LEFT')
                                        ->where('p.ID_REKOMENDASI', $id_rekomendasi)
                                        ->get()->result_array();
        $data['pic']                = $this->m_tl_entry->chcek_pic_type($id_rekomendasi, $id_jabatan);
        // print_r($data['pic']);die();
        if($data['pic'] || $this->is_auditor()){
            $this->db->set('"READ_AT"', 'CURRENT_TIMESTAMP', FALSE);
            $this->db->where(array('ID_REKOMENDASI' => $id_rekomendasi, 'PIC' => $this->session->ID_JABATAN));
            $this->db->update('PIC_REKOMENDASI');
            $data['detail_rekomendasi'] = $this->m_tl_entry->hasil_monitoring_($id_rekomendasi);
            if($data['detail_rekomendasi']['TK_PENYELESAIAN'] == 'Selesai')
            {
                $data['readonly']       = 'readonly';
                $data['disabled']       = 'disabled';
            }
            $data['id_tl']              = $id_tl;
            $data['title']              = 'Tindak Lanjut Laporan Hasil Audit';
            $data['content']            = 'content/monitoring/update_hasil_monitoring/v_update_hasil_monitoring';
            $this->show($data);
        }else{
            if(!$this->is_auditor()) $this->load->view('/errors/html/err_401');
        }
        
    }

    function cetak($id_tl, $id_rekomendasi)
    {
        if($this->is_auditor())
        {
            $this->load->library('Pdf');
            $data['detail_rekomendasi'] = $this->m_tl_entry->hasil_monitoring_($id_rekomendasi);
            $data['pic_rekomendasi']    = $this->db->select('u.NAMA, j.NAMA_JABATAN, u.TANDA_TANGAN')
                                        ->from('PIC_REKOMENDASI pic')
                                        ->join('TM_JABATAN j', 'pic.PIC = j.ID_JABATAN', 'left')
                                        ->join('TM_USER u', 'j.ID_JABATAN = u.ID_JABATAN', 'left')
                                        ->where(array('PRIMARY' => 'Y', 'ID_REKOMENDASI' => $id_rekomendasi))
                                        ->get()->row();
                                        // print_r($data);die();
            $this->load->view('/content/cetak/tindak_lanjut', $data);
        }else{
            $this->load->view('/errors/html/err_401');
        }
    }


    public function update_hasil_monitoring($id_tl, $id_rekomendasi)
    {
        $files = $_FILES['lampiran'];
        if (!empty($files['name'][0])) {
            $config['upload_path']      = './storage/upload/lampiran/hasil_monitoring/';
            $config['allowed_types']    = '*';
            $this->load->library('upload', $config);
            $lampiran = array();
            $urut = 1;
            foreach ($files['name'] as $key => $image) {
                $_FILES['lampiran[]']['name']       = $files['name'][$key];
                $_FILES['lampiran[]']['type']       = $files['type'][$key];
                $_FILES['lampiran[]']['tmp_name']   = $files['tmp_name'][$key];
                $_FILES['lampiran[]']['error']      = $files['error'][$key];
                $_FILES['lampiran[]']['size']       = $files['size'][$key];

                $fileName = $id_rekomendasi . '_' . date('YmdHis') . '_' . $urut . '_' . $image;
                $fileName = str_replace(" ", "_", $fileName);

                $lampiran[] = $fileName;

                $config['file_name'] = $fileName;

                $this->upload->initialize($config);

                if ($this->upload->do_upload('lampiran[]')) {
                    $this->upload->data();
                    $data = array(
                        'ID_REKOMENDASI'    => $id_rekomendasi,
                        'ATTACHMENT'        => $fileName,
                        'FILE_NAME'         => $image
                    );
                    $this->m_tl_entry->add($data, 'ATT_HASIL_MONITORING');
                } else {
                    $error_message = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error_message);
                }
                $urut++;
            }
        }

        $data = array(
            'HASIL_MONITORING'  => is_empty_return_null($this->input->post('HASIL_MONITORING')),
            'DOKUMEN_PENDUKUNG' => is_empty_return_null($this->input->post('DOKUMEN_PENDUKUNG')),
            'UPDATED_BY'        => $this->session->ID_USER,
            'updated_at'        => date('Y-m-d H:i:s')
        );

        if($this->is_closing_audit()) 
        {
            $data['IS_APPROVE'] = 1;
            $data['TK_PENYELESAIAN'] = is_empty_return_null($this->input->post('TK_PENYELESAIAN'));
            $data['TGL_PENYELESAIAN'] = is_empty_return_null($this->input->post('TGL_PENYELESAIAN'));
        }
        else{
            $data['IS_APPROVE'] = 0;
        } 

        // print_r($data);die();
        // if($this->is_auditor()) 
        //     $data['IS_APPROVE'] = 1;
        // else 
        //     $data['IS_APPROVE'] = 0;

        $this->m_tl_entry->update_rekomendasi($data, $id_rekomendasi);

        $total_rekom    = $this->m_tl_entry->getTotalRekomendasi($id_tl);
        $total_selesai  = $this->m_tl_entry->getTotalRekomendasi($id_tl, 'Selesai');
        $total_tptd     = $this->m_tl_entry->getTotalRekomendasi($id_tl, 'TPTD');
        $selesai        = (int)$total_tptd+(int)$total_selesai;
        if($selesai==(int)$total_rekom)
        {
            $this->db->where('ID_TL', $id_tl);
            $this->db->update('TL_ENTRY', array('SELESAI'=>1));
        }

        $this->m_tl_entry->update_rekomendasi($data, $id_rekomendasi);
        $success_message = 'Data berhasil diupdate.';
        $this->session->set_flashdata('success', $success_message);

        //redirect(base_url('monitoring/update_hasil_monitoring/hasil_monitoring/' . $id_tl. '/'.$id_rekomendasi));//dicomand by Irwan 15/12/22 Req Reza
		redirect(base_url('monitoring/update_hasil_monitoring/tindak_lanjut/' . $id_tl));
    }

    public function approve($id)
    {
        $data = array(
            'STATUS'        => '3',
            'updated_at'    => date('Y-m-d H:i:s')
        );

        $this->m_tl_entry->update_rekomendasi($data, $id);
        // $success_message = 'Data berhasil diapprove.';
        // $this->session->set_flashdata('success', $success_message);

        redirect(base_url('monitoring/update_hasil_monitoring/'));
    }

    public function reject($id)
    {
        $data = array(
            'STATUS'        => '4',
            'updated_at'    => date('Y-m-d H:i:s')
        );

        $this->m_tl_entry->update_rekomendasi($data, $id);
        // $success_message = 'Data berhasil diapprove.';
        // $this->session->set_flashdata('success', $success_message);

        redirect(base_url('monitoring/update_hasil_monitoring/'));
    }

    public function temuan($id_temuan)
    {
        $data['menu']           = 'monitoring';
        $data['sub_menu']       = 'update_hasil_monitoring';
        $detail_temuan          = $this->m_tl_entry->temuan_detail($id_temuan);
        $list_jabatan           = $this->m_jabatan->jabatan();
        $data['detail_temuan']  = $detail_temuan;
        $data['list_jabatan']   = $list_jabatan;
        $this->load->view('/template/header', $menu);
        $this->load->view('/content/monitoring/update_hasil_monitoring/v_temuan', $data);
        $this->load->view('/template/footer');
    }

    public function temuan_json($id_tl = '')
    {
        header('Content-Type: application/json');
        if($this->is_auditor() && $this->input->server('REQUEST_METHOD') === 'POST')
            echo json_encode($this->m_tl_entry->temuan($id_tl));
    }

    public function rekomendasi_json($id_tl = '')
    {
        header('Content-Type: application/json');
        if($this->is_auditor() && $this->input->server('REQUEST_METHOD') === 'POST')
            echo json_encode($this->m_tl_entry->rekomendasi($id_tl, '2'));
    }

    public function add_temuan($id_spa)
    {
        // print_r($_FILES['lampiran']['name']);die();
        $id_temuan     = $this->m_tl_entry->last_id('TL_TEMUAN');
        $id_temuan     = $id_temuan->max + 1;
        $config['upload_path']      = './storage/upload/lampiran/temuan/';
        $config['allowed_types']    = '*';
        $this->load->library('upload', $config);
        // $this->upload->initialize($config);
        $lampiran   = array();
        $files      = $_FILES['lampiran'];
        $urut       = 1;
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
                    'ID_TEMUAN'     => $id_temuan,
                    'ATTACHMENT'    => $fileName
                );
                $this->m_tl_entry->add($data, 'ATT_TEMUAN');
            } else {
                $error_message = $this->upload->display_errors();
                $this->session->set_flashdata('error', $error_message);
            }
            $urut++;
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
            'ID'            => $id_temuan,
            'ID_TL'         => $this->input->post('id_tl'),
            'TEMUAN'        => $this->input->post('temuan'),
            'JUDUL_TEMUAN'  => $this->input->post('JUDUL_TEMUAN'),
            'ID_PEMBUAT'    => $this->session->ID_USER,
            // 'LAMPIRAN'           => $gambar,
            'created_at'    => date('Y-m-d H:i:s')
        );
        $this->m_tl_entry->add($data, 'TL_TEMUAN');
        $success_message = 'Data berhasil ditambah.';
        $this->session->set_flashdata('success', $success_message);

        redirect(base_url('monitoring/update_hasil_monitoring/tindak_lanjut/' . $id_spa));
    }

    public function add_rekomendasi($id_tl)
    {
        // print_r($data);die();
        $id_rekomendasi             = $this->m_tl_entry->last_id('TL_REKOMENDASI');
        $id_rekomendasi             = $id_rekomendasi->max + 1;
        $config['upload_path']      = './storage/upload/lampiran/rekomendasi/';
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
                    'ID_REKOMENDASI'    => $id_rekomendasi,
                    'ATTACHMENT'        => $fileName
                );
                $this->m_tl_entry->add($data, 'ATT_REKOMENDASI');
            } else {
                $error_message = $this->upload->display_errors();
                $this->session->set_flashdata('error', $error_message);
            }
            $urut++;
        }

        $data = array(
            'ID'                => $id_rekomendasi,
            'ID_TEMUAN'         => is_empty_return_null($this->input->post('ID_TEMUAN')),
            'BATAS_WAKTU'       => is_empty_return_null($this->input->post('BATAS_WAKTU')),
            'TGL_PENYELESAIAN'  => is_empty_return_null($this->input->post('TGL_PENYELESAIAN')),
            // 'PIC'  					=>is_empty_return_null( $this->input->post('PIC')),
            'REKOMENDASI'       => is_empty_return_null($this->input->post('REKOMENDASI')),
            // 'LAMPIRAN'  			=> $gambar,
            'created_at'        => date('Y-m-d H:i:s'),
            'ID_PEMBUAT'        => $this->session->ID_USER
        );
        if($this->is_auditor()) 
            $data['IS_APPROVE'] = 1;
        else 
            $data['IS_APPROVE'] = 0;
        $this->m_tl_entry->add($data, 'TL_REKOMENDASI');
        $total_pic  = count($this->input->post('pic'));
        for ($i = 0; $i < $total_pic; $i++) {
            if (trim($this->input->post('pic')[$i]) != '') {
                $data = array(
                    'ID_REKOMENDASI'    => $id_rekomendasi,
                    'PIC'               => $this->input->post('pic')[$i]
                );
                $this->m_tl_entry->add($data, 'PIC_REKOMENDASI');
            }
        }

        $success_message = 'Data berhasil ditambah.';
        $this->session->set_flashdata('success', $success_message);

        redirect(base_url('monitoring/update_hasil_monitoring/tindak_lanjut/' . $id_tl));
    }

    public function list_update_hasil_monitoring_json()
    {
        $id_jabatan = $this->session->userdata('ID_JABATAN');
        $data = $this->m_tl_entry->list_update_hasil_monitoring($id_jabatan);

        header('Content-Type: application/json');
        if($this->is_auditor() && $this->input->server('REQUEST_METHOD') === 'POST')
            echo json_encode($data);
    }

    public function rekomendasi_update_hasil_monitoring_json($id_rekomendasi)
    {
        header('Content-Type: application/json');
        if($this->is_auditor() && $this->input->server('REQUEST_METHOD') === 'POST')
            echo json_encode($this->m_tl_entry->rekomendasi_update_hasil_monitoring_json($id_rekomendasi));
    }

    public function get_lampiran_hasil_monitoring_json($id_rekomendasi)
    {
        header('Content-Type: application/json');
        if($this->input->server('REQUEST_METHOD') === 'POST')
            echo json_encode($this->m_tl_entry->get_lampiran_hasil_monitoring_json($id_rekomendasi));
    }
}
