<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PHPExcel\PhpSpreadsheet\Spreadsheet;
use PHPExcel\PhpSpreadsheet\Writer\Xlsx;
use PHPExcel\Writer\Pdf\mPDF;
use PHPExcel\PhpSpreadsheet\IOFactory;
class potensi_temuan extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('upload');
		$this->load->library('excel');
		$this->load->library('Pdf');
        $this->load->model('aia/M_potensi_temuan','M_potensi_temuan');
        $this->load->model('aia/M_master_act','master_act');
        $this->load->model('aia/M_res_auditee','m_res_au');
        $this->load->model('aia/M_jadwal','m_jadwal');
		$this->is_login();
    }

    // Get all data
    public function index() {
        $datauser= $_SESSION;
		// var_dump($datauser);die;
		$data['list_status'] 	= $this->master_act->status();
		$data['list_divisi'] 	= $this->m_res_au->get_divisi();
		$data['menu']           = 'potensi-temuan';
        $data['title']          = 'Potensi Temuan';
        $data['subtitle']       = 'Potensi Temuan';
        $data['content']        = 'content/aia/v_potensi_temuan_header';
		$this->show($data);
    }

    // Get single data by ID
    public function get($id) {
        $data = $this->M_potensi_temuan->get_by_id($id);
        echo json_encode($data);
    }

    // Create new data
    public function create() {
        $input = $this->input->post();
        $result = $this->M_potensi_temuan->insert($input);
        echo json_encode(['status' => $result ? 'success' : 'error']);
    }

    // Update existing data
    public function update($id) {
        $input = $this->input->post();
        $result = $this->M_potensi_temuan->update($id, $input);
        echo json_encode(['status' => $result ? 'success' : 'error']);
    }

    // Delete data
    public function delete($id) {
        $result = $this->M_potensi_temuan->delete($id);
        echo json_encode(['status' => $result ? 'success' : 'error']);
    }

    public function generate($id_response_header)
    {
        // Get data from RESPONSE_AUDITEE_D
        $this->db->where('ID_HEADER', $id_response_header);
        $this->db->where('PENILAIAN !=', 4);
        $this->db->where('PENILAIAN IS NOT NULL');
        $response_detail = $this->db->get('RESPONSE_AUDITEE_D')->result_array();

        // Get data from VISIT_LAPANGAN
        $this->db->where('ID_RESPONSE', $id_response_header);
        $visit_temuan = $this->db->get('VISIT_LAPANGAN')->result_array();

        $insert_data = [];

        // Process RESPONSE_AUDITEE_D records
        foreach ($response_detail as $res_d) {
            $hasil_observasi = $this->getHasilObservasi($res_d['PENILAIAN']);
            
            $insert_data[] = [
                'HASIL_OBSERVASI' => $hasil_observasi,
                'FILE' => $res_d['FILE'],
                'KLASIFIKASI' => $res_d['KLASIFIKASI'],
                'ID_PERTANYAAN' => $res_d['ID_MASTER_PERTANYAAN'],
                'ID_RESPONSE' => $id_response_header,
                'ID_RE' => $res_d['ID_RE'] // Make sure this is included
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
                'ID_RE' => $visit['ID'] // Use appropriate ID field from VISIT_LAPANGAN
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
            }
            
            // Insert new data
            $this->db->insert_batch('POTENSI_TEMUAN', $insert_data);
            
            $this->session->set_flashdata('success', 'Data berhasil di-generate');
        } else {
            $this->session->set_flashdata('error', 'Tidak ada data yang cocok untuk digenerate');
        }
        
        redirect(base_url('aia/potensi_temuan/index'));
    }

    private function getHasilObservasi($penilaian)
    {
        switch ($penilaian) {
            case 1: return 'TIDAK DIISI SAMA SEKALI';
            case 2: return 'JAWABAN TIDAK SESUAI';
            case 3: return 'JAWABAN BENAR, LAMPIRAN SALAH';
            default: return '';
        }
    }
   
    function detail_potensi($id) {
        $data['id_response_header'] = $id; // Kirim ID ke view
        $data['menu'] = 'potensi-temuan';
        $data['title'] = 'Detail Potensi Temuan';
        $data['subtitle'] = 'Detail Potensi Temuan';
        $data['content'] = 'content/aia/v_potensi_temuan_detail';
        $this->show($data);
    }
    public function get_potensi_temuan($id_response_header) {
        $data = $this->M_potensi_temuan->get_potensi_temuan($id_response_header);
        // echo "<pre/>";
        // var_dump($data);die;
        if (!empty($data)) {
            echo json_encode(['status' => 'success', 'data' => $data]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Tidak ada data potensi temuan']);
        }
    }

    public function update_group() {
        
        $item_ids = $this->input->post('item_ids');
        $group_id = $this->input->post('group_id');
        
        if (!empty($item_ids)) {
            $result = $this->potensi_temuan_model->update_group($item_ids, $group_id);
            
            if ($result) {
                $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode([
                        'status' => 'success',
                        'message' => 'Group updated successfully'
                    ]));
            } else {
                $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode([
                        'status' => 'error',
                        'message' => 'Failed to update group'
                    ]));
            }
        } else {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => 'error',
                    'message' => 'No items selected'
                ]));
        }
    }

}