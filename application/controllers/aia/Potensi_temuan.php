<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PHPExcel\PhpSpreadsheet\Spreadsheet;
use PHPExcel\PhpSpreadsheet\Writer\Xlsx;
use PHPExcel\Writer\Pdf\mPDF;
use PHPExcel\PhpSpreadsheet\IOFactory;
class Potensi_temuan extends MY_Controller {

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
        // Ambil data dari response_auditee_d yang memiliki ID_HEADER sesuai
        $this->db->where('ID_HEADER', $id_response_header);
        $this->db->where('PENILAIAN !=', 5);
        $this->db->where('PENILAIAN !=', NULL);
        $response_detail = $this->db->get('RESPONSE_AUDITEE_D')->result_array();
        // var_dump($response_detail);die;
        // Ambil data dari visit_temuan yang memiliki ID_HEADER sesuai
        $this->db->where('ID_RESPONSE', $id_response_header);
        $visit_temuan = $this->db->get('VISIT_LAPANGAN')->result_array();
        // var_dump($visit_temuan);die;
        // Ambil data dari response_auditee_h yang penilaiannya TIDAK sama dengan 5
        // $this->db->where('ID_HEADER', $id_response_header);
        // $response_header = $this->db->get('RESPONSE_AUDITEE_')->result_array();

        // Simulasi proses penggabungan dan insert ke tabel potensi_temuan
        $insert_data_response = [];
        $insert_data_visit = [];

        foreach ($response_detail as $res_d) {
            
                // Contoh struktur data
                if ($res_d['PENILAIAN']== 1 ) {
                    $hasil_observasi = 'TIDAK DIISI SAMA SEKALI';
                } elseif ($res_d['PENILAIAN'] == 2) {   
                    $hasil_observasi = 'JAWABAN TIDAK SESUAI';
                } elseif ($res_d['PENILAIAN'] == 3) {
                    $hasil_observasi = 'JAWABAN SESUAI DAN LAMPIRAN BELUM SESUAI';
                } elseif ($res_d['PENILAIAN'] == 4) {
                    $hasil_observasi = 'JAWABAN BELUM SESUAI DAN LAMPIRAN BELUM SESUAI';
                }
                $insert_data_response[] = [
                    'HASIL_OBSERVASI'=> $hasil_observasi,
                    'FILE'=> $res_d['FILE'],
                    'KLASIFIKASI'=> $res_d['KLASIFIKASI'],
                    'ID_PERTANYAAN'=> $res_d['ID_MASTER_PERTANYAAN'],
                    'ID_RESPONSE'=> $id_response_header,
                ];
        }
        foreach($visit_temuan as $visit_temuan){
            $insert_data_visit[] = [
                'HASIL_OBSERVASI'=> $visit_temuan['HASIL_OBSERVASI'],
                'FILE'=> $visit_temuan['FILE'],
                'KLASIFIKASI'=> $visit_temuan['KLASIFIKASI'],
                'ID_PERTANYAAN'=> $visit_temuan['ID_MASTER_PERTANYAAN'],
                'ID_RESPONSE'=> $id_response_header,
            ];
        }
        // var_dump($insert_data_response);
        // var_dump($insert_data_visit);die;

        // Insert batch jika ada data
        $this->db->where('ID_RESPONSE', $id_response_header);
        $cek_potensi_temuan = $this->db->get('POTENSI_TEMUAN')->result_array();
        // var_dump($cek_potensi_temuan);die;
        if (!empty($insert_data_response)) {
            if(!$cek_potensi_temuan){
                $this->db->insert_batch('POTENSI_TEMUAN', $insert_data_response);
                $this->db->insert_batch('POTENSI_TEMUAN', $insert_data_visit);
                echo json_encode(['status' => 'success', 'message' => 'Data berhasil di-generate']);
            }else{
                $this->db->where('ID_RESPONSE', $id_response_header);
                $this->db->delete('POTENSI_TEMUAN');
                $this->db->insert_batch('POTENSI_TEMUAN', $insert_data_response);
                $this->db->insert_batch('POTENSI_TEMUAN', $insert_data_visit);
                echo json_encode(['status' => 'success', 'message' => 'Data berhasil di-generate']);
            }
            
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Tidak ada data yang cocok untuk digenerate']);
        }
    }
    function detail_potensi($id){
        $data['list_potensi'] = $this->M_potensi_temuan->get_by_id($id);
        $data['menu']         = 'potensi-temuan';
        $data['title']        = 'Detail Potensi Temuan';
        $data['subtitle']     = 'Detail Potensi Temuan';
        $data['content']      = 'content/aia/v_potensi_temuan_detail';
        $this->show($data);
    }

}