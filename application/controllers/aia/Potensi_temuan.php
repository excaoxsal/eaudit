<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Potensi_temuan extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('aia/M_potensi_temuan', 'M_potensi_temuan');
        $this->load->model('aia/M_master_act', 'master_act');
        $this->load->model('aia/M_res_auditee', 'm_res_au');
        $this->is_login();
    }

    public function index() {
        $data = [
            'list_status' => $this->master_act->status(),
            'list_divisi' => $this->m_res_au->get_divisi(),
            'menu' => 'potensi-temuan',
            'title' => 'Potensi Temuan',
            'subtitle' => 'Potensi Temuan',
            'content' => 'content/aia/v_potensi_temuan_header'
        ];
        $this->show($data);
    }

    function jsonPotensiTemuan() 
	{
        header('Content-Type: application/json');
		$getquery = $this->M_potensi_temuan->get_potensi_temuan_header();
        echo json_encode($getquery);
	}

    public function get_status_generate($id_response_header){
        $id_response_header = $this->input->get('id_response_header');
        $this->db->select('*');
        $this->db->where('ID_RESPONSE', $id_response_header);
        $this->db->where('STATUS', 'NOT NULL');
        $this->db->where('STATUS', '1');
        $result = $this->db->get('GROUP_POTENSI_TEMUAN')->row();
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function detail_potensi($id) {
        if($this->is_auditor()||$this->is_lead_auditor()){
            $id_jadwal = $this->db->select('ID_JADWAL')
                ->where('ID_RESPONSE', $id)
                ->get('POTENSI_TEMUAN')
                ->row()
                ->ID_JADWAL;
            $data = [
                'id_response_header' => $id,
                'id_jadwal' => $id_jadwal,
                'menu' => 'potensi-temuan',
                'title' => 'Detail Potensi Temuan',
                'subtitle' => 'Detail Potensi Temuan',
                'content' => 'content/aia/v_potensi_temuan_detail'
            ];
        }
        else{
            $id_jadwal = $this->db->select('ID_JADWAL')
                ->where('ID_RESPONSE', $id)
                ->get('POTENSI_TEMUAN')
                ->row()
                ->ID_JADWAL;
            $data = [
                'id_response_header' => $id,
                'id_jadwal' => $id_jadwal,
                'menu' => 'potensi-temuan',
                'title' => 'Detail Potensi Temuan',
                'subtitle' => 'Detail Potensi Temuan',
                'content' => 'content/aia/v_potensi_temuan_approval'
            ];
        }
        
        // echo '<pre>';
        // print_r($this->session->userdata());
        // echo '</pre>';
        // exit;
        $this->show($data);
    }

    public function get_potensi_temuan($id_response_header) {
        $data = $this->M_potensi_temuan->get_potensi_temuan($id_response_header);
        $this->output_json(['status' => 'success', 'data' => $data]);
    }

    public function generate($id_response_header) {
        if(!($this->is_auditor()||$this->is_lead_auditor())) $this->load->view('/errors/html/err_401');
        // Ambil ID_JADWAL dari header response
        $this->db->select('ID_JADWAL');
        $this->db->where('ID_HEADER', $id_response_header);
        $header_data = $this->db->get('RESPONSE_AUDITEE_H')->row_array();
        $id_jadwal = $header_data['ID_JADWAL'];
        
        $this->db->select("
            concat(
                'Kode Klausul : ',
                tp.\"KODE_KLAUSUL\",
                ' | Lv1 : ',
                tp.\"LV1\",
                ' | Lv2 : ',
                tp.\"LV2\",
                ' '
            ) AS \"KODE_KLAUSUL\"
        ");
        $this->db->select('
            rad.RESPONSE_AUDITEE,
            rad.FILE,
            rad.KLASIFIKASI,
            rad.ID_MASTER_PERTANYAAN,
            rad.ID_HEADER,
            rad.ID_JADWAL,
            rad.ID_RE
        ');
        $this->db->from('RESPONSE_AUDITEE_D rad');
        $this->db->join(
            'TM_PERTANYAAN tp',
            'rad.ID_MASTER_PERTANYAAN = tp.ID_MASTER_PERTANYAAN',
            'inner'
        );
        $this->db->where('rad.ID_HEADER', $id_response_header);
        $this->db->where('rad.PENILAIAN !=', 4);
        $this->db->where('rad.PENILAIAN IS NOT NULL', NULL);
        $response_detail = $this->db->get()->result_array();
        $this->db->select("
            concat(
                'Kode Klausul : ',
                tp.\"KODE_KLAUSUL\",
                ' | Lv1 : ',
                tp.\"LV1\",
                ' | Lv2 : ',
                tp.\"LV2\",
                ' '
            ) AS \"KODE_KLAUSUL\"
        ");
        $this->db->select('
            vl.HASIL_OBSERVASI,
            vl.FILE,
            vl.KLASIFIKASI,
            vl.ID_MASTER_PERTANYAAN,
            rah.ID_HEADER,
            rah.ID_JADWAL,
            vl.ID_VISIT
        ');
        $this->db->from('VISIT_LAPANGAN vl');
        $this->db->join(
            'TM_PERTANYAAN tp',
            'vl.ID_MASTER_PERTANYAAN = tp.ID_MASTER_PERTANYAAN',
            'inner'
        );
        $this->db->join(
            'RESPONSE_AUDITEE_H rah',
            'vl.ID_RESPONSE = rah.ID_HEADER',
            'inner'
        );
        $this->db->where('rah.ID_HEADER', $id_response_header);
        $visit_temuan = $this->db->get()->result_array();
        // var_dump($visit_temuan);die; 
        // $id_divisi = $this->session->userdata('ID_DIVISI'); // Ambil ID_DIVISI dari session
        // $this->db->where('ID_DIVISI', $id_divisi);

        $insert_data = [];

        // Process RESPONSE_AUDITEE_D records
        foreach ($response_detail as $res_d) {
            $insert_data[] = [
                'HASIL_OBSERVASI' => $res_d['RESPONSE_AUDITEE'],
                'FILE' => $res_d['FILE'],
                'KLASIFIKASI' => $res_d['KLASIFIKASI'],
                'ID_PERTANYAAN' => $res_d['ID_MASTER_PERTANYAAN'],
                'ID_RESPONSE' => $id_response_header,
                'ID_JADWAL' => $id_jadwal,
                'ID_RE' => $res_d['ID_RE'], // Make sure this is included
                'KODE_KLAUSUL' => $res_d['KODE_KLAUSUL']
            ];
        }

        // Process VISIT_LAPANGAN records
        foreach ($visit_temuan as $visit) {
            $insert_data[] = [
                'HASIL_OBSERVASI' => $visit['HASIL_OBSERVASI'],
                'FILE' => $visit['FILE'],
                'KLASIFIKASI' => $visit['KLASIFIKASI'],
                'ID_PERTANYAAN' => $visit['ID_MASTER_PERTANYAAN'],
                'ID_RESPONSE' => $id_response_header,
                'ID_JADWAL' => $id_jadwal,
                'ID_RE' => $visit['ID'], // Use appropriate ID field from VISIT_LAPANGAN
                'KODE_KLAUSUL' => $visit['KODE_KLAUSUL']
            ];
        }

        // Check if data exists
        $this->db->where('ID_RESPONSE', $id_response_header);
        $existing_data = $this->db->get('POTENSI_TEMUAN')->result_array();

        if (!empty($insert_data)) {
            // Delete existing data if any
            if (!empty($existing_data)) {
                $this->db->where('ID_RESPONSE', $id_response_header);
                $this->db->delete('POTENSI_TEMUAN');

                // $this->db->where('ID_RESPONSE', $id_response_header);
                // $this->db->delete('GROUP_POTENSI_TEMUAN');
            }
            $this->db->insert_batch('POTENSI_TEMUAN', $insert_data);
            
            $this->session->set_flashdata('success', 'Data berhasil di-generate');
        } else {
            $this->session->set_flashdata('error', 'Tidak ada data yang cocok untuk digenerate');
        }
        
        redirect(base_url('aia/potensi_temuan/index'));
    }

    public function update_group() {
        // header('Content-Type: application/json');
        if(!$this->is_auditor()) $this->load->view('/errors/html/err_401');
        try {
            $item_ids = $this->input->post('item_ids');
            $group_id = $this->input->post('group_id');
            $id_jadwal = $this->input->post('id_jadwal'); // Tambahkan ini
            
            if (empty($item_ids) || empty($group_id)) {
                throw new Exception("Parameter tidak lengkap");
            }

            
            // Ambil data klasifikasi dari item yang akan diassign
            $this->db->select('
                pt."ID_POTENSI_TEMUAN",
                pt."KLASIFIKASI" AS "KLASIFIKASI",
                pt."HASIL_OBSERVASI",
                pt."ID_RESPONSE",
                pt."KODE_KLAUSUL",
                CONCAT(split_part(mp."KODE_KLAUSUL", \'.\', 1), \'.\', split_part(mp."KODE_KLAUSUL", \'.\', 2)) AS "REFERENSI_KLAUSUL",
                tn."PENILAIAN" AS "STATUS"
            ', FALSE); // FALSE agar CONCAT dan split_part tidak di-escape oleh CodeIgniter // Memberikan alias langsung di from
            $this->db->join('"TM_PERTANYAAN" mp', 'pt."ID_PERTANYAAN" = mp."ID_MASTER_PERTANYAAN"', 'inner');
            $this->db->join('"RESPONSE_AUDITEE_D" ra', 'pt."ID_RE" = ra."ID_RE"', 'left');
            $this->db->join('"TM_PENILAIAN" tn', 'ra."PENILAIAN" = tn."ID_PENILAIAN"', 'left');

            $this->db->where_in('pt."ID_POTENSI_TEMUAN"', $item_ids);
            $items = $this->db->get('POTENSI_TEMUAN pt')->result_array();
            
            if (empty($items)) {
                throw new Exception("Item tidak ditemukan");
            }
            // var_dump($items);die;
            // Tentukan klasifikasi tertinggi
            $klasifikasi_values = array_column($items, 'KLASIFIKASI');
            $referensi_klausul_values = implode("\n", array_column($items, 'REFERENSI_KLAUSUL'));
            $klausul_values = implode("\n", array_column($items, 'KODE_KLAUSUL'));
            $highest_klasifikasi = $this->getHighestKlasifikasi($klasifikasi_values);
            $idresponse = $items[0]['ID_RESPONSE'];
            // var_dump($klasifikasi_values,$referensi_klausul_values);die;
            
            // Ambil kode klausul (ambil yang pertama saja atau sesuaikan kebutuhan)
            // $kode_klausul = $items[0]['KODE_KLAUSUL'];

            // Gabungkan semua HASIL_OBSERVASI dengan pemisah
            $combined_observasi = implode("\n", array_column($items, 'STATUS'));
            //print_r($combined_observasi);die();
            
            $this->db->trans_begin();
            
            // 1. Update POTENSI_TEMUAN untuk set GROUP_ID
            $this->db->where_in('ID_POTENSI_TEMUAN', $item_ids);
            $this->db->update('POTENSI_TEMUAN', ['GROUP_ID' => $group_id]);
            
            // 2. Insert atau Update ke GROUP_POTENSI_TEMUAN
            $existing_group = $this->db->get_where('GROUP_POTENSI_TEMUAN', ['GROUP_ID' => $group_id])->row();

            if ($existing_group) {
                // Update jika group sudah ada
                $this->db->where('GROUP_ID', $group_id);
                $this->db->update('GROUP_POTENSI_TEMUAN', [
                    'KLASIFIKASI' => $highest_klasifikasi,
                    'URAIAN_TEMUAN' => $combined_observasi,
                    'UPDATED_AT' => date('Y-m-d H:i:s'),
                    'ID_RESPONSE' => $idresponse,
                    'REFERENSI_KLAUSUL' => $referensi_klausul_values,
                    'KODE_KLAUSUL' => $klausul_values
                ]);
            } else {
                // Insert baru jika group belum ada
                $this->db->insert('GROUP_POTENSI_TEMUAN', [
                    'GROUP_ID' => $group_id,
                    'KLASIFIKASI' => $highest_klasifikasi,
                    'URAIAN_TEMUAN' => $combined_observasi,
                    'CREATED_AT' => date('Y-m-d H:i:s'),
                    'ID_JADWAL' => $id_jadwal,
                    'ID_RESPONSE' => $idresponse,
                    'REFERENSI_KLAUSUL' => $referensi_klausul_values,
                    'KODE_KLAUSUL' => $klausul_values
                ]);
            }
            // 3. Update GROUP_ID di TM_GROUP
            $this->db->where('ID', $group_id);
            $this->db->update('TM_GROUP', [
                'ID_RESPONSE' => $idresponse
            ]);
            
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                throw new Exception("Gagal menyimpan data");
            }
            
            $this->db->trans_commit();
            
            echo json_encode([
                'status' => 'success',
                'message' => 'Item berhasil diassign ke group',
                'highest_klasifikasi' => $highest_klasifikasi
            ]);
            
        } catch (Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
    
    public function getHighestKlasifikasi($klasifikasi_values) {
        $priority = [
            'MAJOR' => 3,
            'MINOR' => 2,
            'OBSERVASI' => 1
        ];
        
        $highest = 'OBSERVASI'; // Default
        
        foreach ($klasifikasi_values as $klasifikasi) {
            if (!empty($klasifikasi)) {
                // Periksa apakah prioritas klasifikasi saat ini lebih tinggi dari $highest
                if ($priority[strtoupper($klasifikasi)] > $priority[$highest]) {
                    $highest = strtoupper($klasifikasi);
                }
            }
        }
        
        return $highest;
    }

    public function get_groups() {
        // $groups = $this->M_potensi_temuan->get_master_groups();
        $this->db->where('DELETED_AT', null);
        $this->db->where('ID_RESPONSE', $this->input->get('id_response_header'));
        $groups = $this->db->get('TM_GROUP')->result_array();
        $this->output_json(['status' => 'success', 'data' => $groups]);
    }

    public function get_grouped_items() {
        header('Content-Type: application/json');
        
        try {
            $this->db->select('gpt.*, g.NAME as GROUP_NAME');
            $this->db->from('GROUP_POTENSI_TEMUAN gpt');
            $this->db->join('TM_GROUP g', 'g.ID = gpt.GROUP_ID', 'left');
            $this->db->where('gpt.ID_JADWAL', $this->input->get('id_jadwal'));
            $query = $this->db->get();
            
            $groups['ITEMS'] = $query->result_array();
            echo json_encode([
                'status' => 'success',
                'data' => $groups
            ]);
            
        } catch (Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function add_group() {
        $group_name = $this->input->post('group_name');
        $id_response_header = $this->input->post('id_response_header');
        if (empty($group_name)) {
            $this->output_json(['status' => 'error', 'message' => 'Group name cannot be empty']);
            return;
        }
        
        $result = $this->M_potensi_temuan->add_group($group_name, $id_response_header);
        $this->output_json($result ? ['status' => 'success', 'message' => 'Group added successfully']
                                   : ['status' => 'error', 'message' => 'Failed to add group']);
    }

    public function reset_selected_items() {
        $item_ids = $this->input->post('item_ids');
        $group_id = $this->input->post('group_id');
        
            // Update all selected items to have GROUP_ID = NULL
            $this->db->where_in('ID_POTENSI_TEMUAN', $item_ids)
                    ->update('POTENSI_TEMUAN', ['GROUP_ID' => NULL]);
        
        echo json_encode([
            'status' => 'success',
            'message' => 'Selected items reset successfully'
        ]);
    }

    public function reset_group() {
        header('Content-Type: application/json');
        
        try {
            $group_id = $this->input->post('group_id');
    
            if (empty($group_id)) {
                throw new Exception("Group ID tidak boleh kosong");
            }
    
            $this->db->trans_begin();
    
            // 1. Update GROUP_ID menjadi NULL di POTENSI_TEMUAN
            $this->db->where('GROUP_ID', $group_id);
            $this->db->update('POTENSI_TEMUAN', ['GROUP_ID' => null]);
    
            // 2. Hapus dari GROUP_POTENSI_TEMUAN
            $this->db->where('GROUP_ID', $group_id);
            $this->db->delete('GROUP_POTENSI_TEMUAN');
    
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                throw new Exception("Gagal mereset group");
            }
    
            $this->db->trans_commit();
    
            echo json_encode([
                'status' => 'success',
                'message' => 'Group berhasil direset',
                'data' => [
                    'group_id' => $group_id,
                    'affected_rows' => $this->db->affected_rows()
                ]
            ]);
    
        } catch (Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage(),
                'data' => []
            ]);
        }
    }

    public function save_group() {
        // header('Content-Type: application/json');
        $data = $this->input->post('data');
        try {
            $group_id = $data['0']['GROUP_ID'];
    
            if (empty($group_id)) {
                throw new Exception("Group ID tidak boleh kosong");
            }
            $this->db->trans_begin();
            // 1. Update GROUP_ID menjadi NULL di POTENSI_TEMUAN
            
            // 2. Hapus dari GROUP_POTENSI_TEMUAN
            $this->db->where('GROUP_ID', $group_id);
            $this->db->update('GROUP_POTENSI_TEMUAN',[
                'STATUS' => 0,
                'UPDATED_AT' => date('Y-m-d H:i:s'),
                'URAIAN_TEMUAN' => $data['uraianTemuan'],
                'KODE_KLAUSUL' => $data['0']['KODE_KLAUSUL'],
                'REFERENSI_KLAUSUL' => $data['option_clause'],
                'KLASIFIKASI' => $data['0']['KLASIFIKASI']]);
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                throw new Exception("Gagal simpan group");
            }
    
            $this->db->trans_commit();
    
            echo json_encode([
                'status' => 'success',
                'message' => 'Group berhasil disimpan',
                'data' => [
                    'group_id' => $group_id,
                    'affected_rows' => $this->db->affected_rows()
                ]
            ]);
    
        } catch (Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage(),
                'data' => []
            ]);
        }
    }

    public function submit_group() {
        // header('Content-Type: application/json');
        
        try {
            $id_response_header = $this->input->post('group_id');
            // var_dump($id_response_header);die;
    
            if (empty($id_response_header)) {
                throw new Exception("Group ID tidak boleh kosong");
            }
            $this->db->trans_begin();
            $insert_data[] = [
                'ID_RESPONSE' => $id_response_header,
                'STATUS' => 0,
            ];
            $this->db->insert_batch('POTENSI_TEMUAN_STATUS', $insert_data);

            $this->db->where('ID_RESPONSE', $id_response_header);
            $this->db->update('GROUP_POTENSI_TEMUAN',['STATUS' => 1]);
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                throw new Exception("Gagal kirim data");
            }
    
            $this->db->trans_commit();
    
            echo json_encode([
                'status' => 'success',
                'message' => 'Data berhasil dikirim',
                'data' => [
                    'group_id' => $group_id,
                    'affected_rows' => $this->db->affected_rows()
                ]
            ]);
    
        } catch (Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage(),
                'data' => []
            ]);
        }
    }

    public function delete_group() {
        header('Content-Type: application/json');
        
        try {
            $group_id = $this->input->post('group_id');
    
            if (empty($group_id)) {
                throw new Exception("Group ID tidak boleh kosong");
            }
    
            $this->db->trans_begin();
    
            // 1. Reset GROUP_ID di POTENSI_TEMUAN
            $this->db->where('GROUP_ID', $group_id);
            $this->db->update('POTENSI_TEMUAN', ['GROUP_ID' => null]);
    
            // 2. Hapus dari GROUP_POTENSI_TEMUAN
            $this->db->where('GROUP_ID', $group_id);
            $this->db->delete('GROUP_POTENSI_TEMUAN');
    
            // 3. Hapus dari TM_GROUP
            $this->db->where('ID', $group_id);
            $this->db->delete('TM_GROUP');
    
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                throw new Exception("Gagal menghapus group");
            }
    
            $this->db->trans_commit();
    
            echo json_encode([
                'status' => 'success',
                'message' => 'Group berhasil dihapus',
                'data' => [] // Pastikan ada property data
            ]);
    
        } catch (Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage(),
                'data' => [] // Pastikan ada property data
            ]);
        }
    }

    public function approve($id) {
        if(!($this->is_atasan_auditee()||$this->is_lead_auditor())) $this->load->view('/errors/html/err_401');
        
        $data = [
            'STATUS' => 2,
            'APPROVED_SM_BY' => $this->session->userdata('ID_USER'),
            'APPROVED_SM_AT' => date('Y-m-d H:i:s')
        ];
        $this->db->where('ID_RESPONSE', $id);
        $this->db->update('GROUP_POTENSI_TEMUAN', $data);
        $this->session->set_flashdata('success', $success_message);
				redirect(base_url('aia/Potensi_temuan/detail_potensi/'.$id));
    }

    private function output_json($data) {
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
}