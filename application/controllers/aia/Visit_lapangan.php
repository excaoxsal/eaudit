<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PHPExcel\PhpSpreadsheet\Spreadsheet;
use PHPExcel\PhpSpreadsheet\Writer\Xlsx;
use PHPExcel\Writer\Pdf\mPDF;
use PHPExcel\PhpSpreadsheet\IOFactory;
class visit_lapangan extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('upload');
		$this->load->library('excel');
		$this->load->library('Pdf');
		$this->load->model('aia/M_res_auditee', 'm_res_au');
		$this->load->model('aia/M_jadwal', 'm_jadwal');
		$this->load->model('aia/M_visit_lapangan', 'm_visit_lapangan');
		//$this->load->model('DynamicForm_model');
        if(!$this->is_auditor()) $this->load->view('/errors/html/err_401');
		$this->is_login();
	}

	// public function index() {
	// 	$datauser= $_SESSION;
	// 	// var_dump($datauser);die;
	// 	$data['list_status'] 	= $this->master_act->status();
	// 	$data['list_divisi'] 	= $this->m_res_au->get_divisi();
	// 	$data['menu']           = 'visit_lapangan'; // Set the menu variable
    //     $data['title']          = 'Observasi Lapangan';
    //     $data['content']        = 'content/aia/v_visit_lapangan_detail';
		
    //     $this->show($data);
    // }

	public function index()
	{
		$datauser= $_SESSION;
		// var_dump($datauser);die;
		$data['list_status'] 	= $this->master_act->status();
		$data['list_divisi'] 	= $this->m_res_au->get_divisi();
		$data['menu']           = 'visit_lapangan';
        $data['title']          = 'Observasi Lapangan';
        $data['content']        = 'content/aia/v_visit_lapangan_header.php';
		
        $this->show($data);
	}

	public function detail($datas){
		
		$data['list_divisi'] 	= $this->m_res_au->get_divisi();
		$data['menu']           = 'visit_lapangan';
        $data['title']          = 'Observasi Lapangan';
        $data['content']        = 'content/aia/v_visit_lapangan_detail';
		$data['kode']			= $datas;
		$data['role']			= $_SESSION['NAMA_ROLE'];
		$data['detail']			= $this->m_res_au->get_response_auditee_detail($datas);
		$data['observasi']			= $this->m_visit_lapangan->get_visit_lapangan_by_id_response($datas);
		$data['klausul']	= $this->m_visit_lapangan->get_kode_klausul($data['detail'][0]['ID_HEADER']);
		// var_dump($data['klausul']);die;
		$this->show($data);
	}


	public function save() {
    $this->load->library('form_validation');
    $this->load->library('upload');
    
    // Validasi input
    $this->form_validation->set_rules('hasil_observasi', 'Hasil Observasi', 'required');
    $this->form_validation->set_rules('klasifikasi', 'Klasifikasi', 'required|in_list[MAJOR,MINOR,OBSERVASI]');
    
    if ($this->form_validation->run() == FALSE) {
        echo json_encode([
            'status' => 'error',
            'message' => validation_errors()
        ]);
        return;
    }

    // Data dasar
    $data = [
        'HASIL_OBSERVASI' => $this->input->post('hasil_observasi'),
        'ID_MASTER_PERTANYAAN' => $this->input->post('id_master_pertanyaan'),
        'KLASIFIKASI' => $this->input->post('klasifikasi'),
        'ID_RESPONSE' => $this->input->post('id_response')
    ];

    // Handle file upload
    if (!empty($_FILES['file']['name'])) {
        $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
        $current_time = date('YmdHis');
        $config = [
            'upload_path' => './storage/aia/visit_lapangan/',
            'allowed_types' => 'jpg|jpeg|png|pdf|doc|docx',
            'max_size' => 2048,
            'file_name' => "File_Visit_Lapangan_".$current_time,
            'overwrite' => false
        ];
        
        $this->upload->initialize($config);
        
        if ($this->upload->do_upload('file')) {
            $file_data = $this->upload->data();
            $data['FILE'] = 'storage/aia/visit_lapangan/'.$file_data['file_name'];
            
            // Hapus file lama jika ada
            if ($this->input->post('id')) {
                $old_file = $this->db->select('FILE')
                                  ->where('ID_VISIT', $this->input->post('id'))
                                  ->get('VISIT_LAPANGAN')
                                  ->row()->FILE;
                if ($old_file && file_exists($old_file)) {
                    unlink($old_file);
                }
            }
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => $this->upload->display_errors()
            ]);
            return;
        }
    } elseif ($this->input->post('existing_file')) {
        $data['FILE'] = $this->input->post('existing_file');
    }

    // Simpan ke database
    $id_visit = $this->input->post('id');
    if ($id_visit) {
        $this->db->where('ID_VISIT', $id_visit);
        $result = $this->db->update('VISIT_LAPANGAN', $data);
    } else {
        $result = $this->db->insert('VISIT_LAPANGAN', $data);
        $id_visit = $this->db->insert_id();
    }

    if ($result) {
        // Ambil data terbaru termasuk klasifikasi
        $updated_data = $this->db->where('ID_VISIT', $id_visit)
                              ->get('VISIT_LAPANGAN')
                              ->row_array();
        
        // Pastikan URL file lengkap
        if (!empty($updated_data['FILE']) && strpos($updated_data['FILE'], 'http') !== 0) {
            $updated_data['FILE'] = base_url($updated_data['FILE']);
        }
        
        echo json_encode([
            'status' => 'success',
            'message' => 'Data observasi berhasil disimpan',
            'data' => $updated_data
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Gagal menyimpan data observasi'
        ]);
    }
}

    public function get_observasi_by_iso_kode($nomor_iso, $kode) {
        return $this->db->get_where('visit_lapangan', [
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


    

    public function delete_visit($id_visit)
    {
        // Validate parameter
        if (empty($id_visit) || !is_numeric($id_visit)) {
            echo json_encode(['status' => 'error', 'message' => 'ID tidak valid']);
            return;
        }

        // Retrieve file path from the database
        $query = $this->db->select('FILE')->from('VISIT_LAPANGAN')->where('ID_VISIT', $id_visit)->get();
        $file_data = $query->row();

        if ($file_data && !empty($file_data->FILE)) {
            $file_path = str_replace(base_url(), './', $file_data->FILE); // Convert URL to local path
            if (file_exists($file_path)) {
                unlink($file_path); // Delete the file from the folder
            }
        }

        // Delete data from the database
        $this->db->where('ID_VISIT', $id_visit);
        $deleted = $this->db->delete('VISIT_LAPANGAN');

        // Response
        if ($deleted) {
            echo json_encode(['status' => 'success', 'message' => 'Data berhasil dihapus']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus data']);
        }
    }
	
}
