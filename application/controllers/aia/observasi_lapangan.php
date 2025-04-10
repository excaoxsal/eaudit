<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PHPExcel\PhpSpreadsheet\Spreadsheet;
use PHPExcel\PhpSpreadsheet\Writer\Xlsx;
use PHPExcel\Writer\Pdf\mPDF;
use PHPExcel\PhpSpreadsheet\IOFactory;
class observasi_lapangan extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('upload');
		$this->load->library('excel');
		$this->load->library('Pdf');
		$this->load->model('aia/M_res_auditee', 'm_res_au');
		$this->load->model('aia/M_jadwal', 'm_jadwal');
		$this->load->model('aia/M_Observasi', 'm_observasi');
		//$this->load->model('DynamicForm_model');
		$this->is_login();
	}

	// public function index() {
	// 	$datauser= $_SESSION;
	// 	// var_dump($datauser);die;
	// 	$data['list_status'] 	= $this->master_act->status();
	// 	$data['list_divisi'] 	= $this->m_res_au->get_divisi();
	// 	$data['menu']           = 'observasi_lapangan'; // Set the menu variable
    //     $data['title']          = 'Observasi Lapangan';
    //     $data['content']        = 'content/aia/v_observasi_lapangan_detail';
		
    //     $this->show($data);
    // }

	public function index()
	{
		$datauser= $_SESSION;
		// var_dump($datauser);die;
		$data['list_status'] 	= $this->master_act->status();
		$data['list_divisi'] 	= $this->m_res_au->get_divisi();
		$data['menu']           = 'observasi_lapangan';
        $data['title']          = 'Observasi Lapangan';
        $data['content']        = 'content/aia/v_observasi_lapangan_header.php';
		
        $this->show($data);
	}

	public function detail($datas){
		
		$data['list_divisi'] 	= $this->m_res_au->get_divisi();
		$data['menu']           = 'observasi_lapangan';
        $data['title']          = 'Observasi Lapangan';
        $data['content']        = 'content/aia/v_observasi_lapangan_detail';
		$data['kode']			= $datas;
		$data['role']			= $_SESSION['NAMA_ROLE'];
		$data['detail']			= $this->m_res_au->get_response_auditee_detail($datas);
		$data['observasi']			= $this->m_observasi->get_observasi_by_id_response($datas);
		$data['klausul']	= $this->m_observasi->get_kode_klausul($data['detail'][0]['ID_HEADER']);
		// var_dump($data['detail']);die;
		$this->show($data);
	}

	// public function save()
    // {
    //     $row_id = $this->input->post('row_id');
    //     $column = $this->input->post('column');
    //     $value = $this->input->post('value');
	// 	var_dump($this->input->post('klausul'));die;
	// 	// Contoh query untuk menyimpan data ke database
    //     $this->db->where('id', $row_id)->update('your_table', [$column => $value]);

    //     echo json_encode(['status' => 'success']);
    // }

    // public function save() {
    //     $data = [
    //         'field_name' => $this->input->post('field_name'),
    //         'field_value' => $this->input->post('field_value')
    //     ];
    //     $id = $this->input->post('id');
        
    //     if ($id) {
    //         $this->DynamicForm_model->update_form_data($id, $data);
    //     } else {
    //         $this->DynamicForm_model->save_form_data($data);
    //     }

    //     echo json_encode(['status' => 'success']);
    // }

	public function save() {
        $this->load->library('form_validation');
        // var_dump($this->input->post('klausul'));die;
        // Validasi input
        $this->form_validation->set_rules('hasil_observasi', 'Hasil Observasi', 'required');
        $this->form_validation->set_rules('klausul', 'Klausul', 'required');
        $this->form_validation->set_rules('klasifikasi', 'Klasifikasi', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            echo json_encode([
                'status' => 'error',
                'message' => validation_errors()
            ]);
            return;
        }
		if($ext==""||$ext==null){
			$file_name = null;
		}else 
		{
		$current_time = date('YmdHis');
        $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
		$config['file_name']        = "File_Observasi".$current_time;
        $config['upload_path'] = './storage/aia/observasi/';
        $config['allowed_types'] = 'jpg|jpeg|png|pdf|doc|docx';
        $config['max_size'] = 2048; // 2MB
		$this->upload->initialize($config);
        // $this->load->library('upload', $config);
		$file_path = base_url().'storage/aia/observasi/'.$config['file_name'].'.'.$ext;
        $file_name = $file_path;

		}

        // Konfigurasi upload file
		
        if (!empty($_FILES['file']['name'])) {
            if ($this->upload->do_upload('file')) {
                $file_data = $this->upload->data();
                // $file_name = $file_path;
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => $this->upload->display_errors()
                ]);
                return;
            }
        }

        // Data untuk disimpan
        $data = [
            'HASIL_OBSERVASI' => $this->input->post('hasil_observasi'),
            'KLAUSUL' => $this->input->post('klausul'),
            'FILE' => $file_name,
            'KLASIFIKASI' => $this->input->post('klasifikasi'),
			'COUNT' => $this->input->post('count'),
			'ID_RESPONSE' => $this->input->post('id_response')
        ];

        // Simpan ke database
        $result = $this->m_observasi->save_observasi($data);

        if ($result) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Data observasi berhasil disimpan'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Gagal menyimpan data observasi'
            ]);
        }
    }

    public function get_observasi_by_iso_kode($nomor_iso, $kode) {
        return $this->db->get_where('observasi_lapangan', [
            'nomor_iso' => $nomor_iso,
            'kode' => $kode
        ])->result_array();
    }

	function jsonResponAuditee() 
	{
        header('Content-Type: application/json');
		// var_dump($this->m_res_au->get_response_auditee_header());
		$getquery = $this->m_res_au->get_response_auditee_header();
		// var_dump($_SESSION['ID_DIVISI']);die;
        echo json_encode($getquery);
	}

	function jsonResponAuditeeDetail($data) 
	{
        header('Content-Type: application/json');
		// var_dump($this->m_res_au->get_response_auditee_detail($data));
		// die;
		$query = $this->m_res_au->get_response_auditee_detail($data);
        echo json_encode($query);
	}

	function getdatadetail($id_tl) 
	{
		$user_session = $_SESSION['NAMA_ROLE'];
		$user_divisi = $_SESSION['ID_DIVISI'];
        if($user_session=="AUDITOR"){
			$query = $this->db->select('ID_RE,KOMENTAR_1,KOMENTAR_2')->from('RESPONSE_AUDITEE_D')->where('ID_RE', $id_tl)->get()->row();
		}else{
			$query = $this->db->select('ID_RE,KOMENTAR_1,KOMENTAR_2')->from('RESPONSE_AUDITEE_D')->where('ID_RE', $id_tl)->get()->row();
		}
		// var_dump($query);die;
        echo json_encode($query);
	}
	function getFileUpload($id_tl)
    {
            $query = $this->db->select('ID_RE, FILE, RESPONSE_AUDITEE')->from('RESPONSE_AUDITEE_D')
                        ->where('ID_RE', $id_tl)->get()->row();
            echo json_encode($query);   
    }
	
}
