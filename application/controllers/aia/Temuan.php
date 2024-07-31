<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PHPExcel\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Temuan extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('upload');
		$this->load->library('excel');
		$this->load->library('Pdf');
		$this->load->model('aia/M_temuan', 'm_temuan');
		$this->load->model('aia/M_res_auditee', 'm_res_au');
		$this->load->model('aia/M_jadwal', 'm_jadwal');
		$this->load->model('aia/master/Master_act_aia','aia_master_act');
		$this->is_login();
}


public function index()
	{
		$datauser= $_SESSION;
		// var_dump($datauser);die;
		$data['list_status'] 	= $this->master_act->status();
		$data['list_divisi'] 	= $this->m_res_au->get_divisi();
		$data['menu']           = 'temuan-aia';
        $data['title']          = 'Hasil Temuan';
        $data['content']        = 'content/aia/v_temuan';
		
        $this->show($data);
	}

	public function detail($datas){
		
		$data['list_divisi'] 		= $this->m_res_au->get_divisi();

		$data['list_temuan_header'] = $this->m_temuan->getAuditor_Lead($datas);
		//print_r($data['list_temuan_header']);die();
		$data['menu']           	= 'temuan-aia';
        $data['title']          	= 'Temuan';
        $data['content']        	= 'content/aia/v_temuan_detail';
		$data['kode']				= $datas;
		// var_dump();die;
		$data['role']				= $_SESSION['NAMA_ROLE'];
		
		$this->show($data);
	}

	function jsonTemuanDetail($data) 
	{
        header('Content-Type: application/json');
		// var_dump($this->m_res_au->get_response_auditee_detail($data));
		// die;
		$query = $this->m_temuan->get_temuan_detail($data);
        echo json_encode($query);
	}

	public function proses_upload() { 
		$config['file_name']        = "upload_master_pertanyaan";
		$config['upload_path'] = './storage/aia/'; // Lokasi penyimpanan file
		$config['allowed_types'] = 'xls|xlsx'; // Jenis file yang diizinkan
		$this->load->library('upload', $config);
		$config['max_size'] = 1280000; // Ukuran maksimum file (dalam KB)
		
		$this->upload->initialize($config);
		$elupload = $this->upload->do_upload('file_excel');
		// var_dump($_POST);die;
		if (!$elupload) {
			// Jika upload gagal, tampilkan pesan error
			$error = $this->upload->display_errors();
			
			echo $error;die;
		}else{
			// Jika upload berhasil, baca file Excel
			
			$file_data = $this->upload->data();		
			$file_path = $base_url."./storage/aia/".$file_data['file_name'];
			// Hapus file setelah selesai membaca
		}
		$inputFileName = $file_path;
		$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
		$reader = PHPExcel_IOFactory::createReader($inputFileType);
		$excel = $reader->load($inputFileName);

		// Select the first worksheet
		$worksheet = $excel->getActiveSheet();

		// Get the highest row and column numbers
		$highestRow = $worksheet->getHighestRow();
		$highestColumn = $worksheet->getHighestColumn();

		// Convert the column letter to a numeric index
		$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);

		// Loop through each row to read the data
		$data = [];
			for ($row = 0; $row <= $highestRow; $row++) {
			
				$kode_klausul = $worksheet->getCellByColumnAndRow(0, $row+2)->getValue();
				$temuan = $worksheet->getCellByColumnAndRow(1, $row+2)->getValue();
				
				if($kode_klausul!=""){
					
						$data[] = array(
							'KLAUSUL'	=> is_empty_return_null($kode_klausul),
							'TEMUAN'		=> is_empty_return_null($temuan),
							'PERTANYAAN'	=> is_empty_return_null($pertanyaan),
							'ID_ISO'=>is_empty_return_null($_POST['ID_ISO']),
							'ID_MASTER_PERTANYAAN' => is_empty_return_null('')
						);	
					
					$eldata = [
									'KLAUSUL'	=> is_empty_return_null($data[$row]['KLAUSUL']),
									'TEMUAN'			=> is_empty_return_null($data[$row]['TEMUAN']),
									'ID_RESPONSE'		=> is_empty_return_null($_POST['ID_RE']),
									
								];
					$save = $this->m_temuan->save($eldata);
				}

			}
			
			$upload_data = $this->upload->data();
			unlink($upload_data['full_path']);
			if($save==true){
				$success_message = 'Data berhasil disimpan.';
				$this->session->set_flashdata('success', $success_message);
				redirect($_SERVER['HTTP_REFERER']);
			}
			else{
				$error_message = 'Silahkan cek kembali datanya';
				$this->session->set_flashdata('error', $error_message);
			}
	}

	function getCommitment($id_tl)
    {
            $query = $this->db->select('*')->from('TEMUAN_DETAIL')
                        ->where('ID_TEMUAN', $id_tl)->get()->row();
            echo json_encode($query);
    }

	public function commitment($data) {
		$request = $this->input->post();
		$atasan_result = $this->m_temuan->getAtasan($_SESSION['ID_JABATAN']);
		$atasan = json_decode($atasan_result, true);
		date_default_timezone_set('Asia/Jakarta');
		$status = $this->m_temuan->getStatus($request['ID_TEMUAN']);
		$respObject = json_decode($status);
    	// var_dump($respObject->STATUS);
		// die();

		$data_update = 
			[
			'INVESTIGASI'           			=> is_empty_return_null($request['INVESTIGASI']),
			'PERBAIKAN'           				=> is_empty_return_null($request['PERBAIKAN']),
			'KOREKTIF'           				=> is_empty_return_null($request['KOREKTIF']),
			'TANGGAL'           				=> is_empty_return_null($request['TANGGAL']),
			'ID_ATASAN_AUDITEE' 				=> isset($atasan['ID_ATASAN']) ? $atasan['ID_ATASAN'] : null
			];
		// if($respObject->STATUS === 'AC'){
		// 	$this->db->set('STATUS', 'TL');
		// 	echo('a');die();
		// }else{
		// 	$this->db->set('STATUS', 'Commitment');
		// 	echo('b');die();
		// }
		$this->db->set('TANGGAL', $data_update['TANGGAL']);
		$this->db->set('KOREKTIF', $data_update['KOREKTIF'][0]);
		$this->db->set('PERBAIKAN', $data_update['PERBAIKAN'][0]);
		$this->db->set('INVESTIGASI', $data_update['INVESTIGASI'][0]);
		$this->db->set('STATUS', 'Commitment');
		$this->db->set('ID_ATASAN_AUDITEE', $data_update['ID_ATASAN_AUDITEE']);
		$this->db->where('ID_TEMUAN', $request['ID_TEMUAN']);
		$update = $this->db->update('TEMUAN_DETAIL');
		if ($update){
			$success_message = 'Data Commitment Berhasil Disimpan.';
			$this->session->set_flashdata('success', $success_message);
			redirect(base_url('aia/temuan/detail/'.$data));
		}
		else{
			$error_message = 'Silahkan coba kembali';
			$this->session->set_flashdata('error', $error_message);
			redirect(base_url('aia/temuan/detail/'.$data));
		}
	}

	public function tindakLanjut($data) {
		$request = $this->input->post();
		date_default_timezone_set('Asia/Jakarta');
		$id_temuan = $_REQUEST['ID_TEMUAN'];
        $ext = pathinfo($_FILES['upload_file']['name'], PATHINFO_EXTENSION);
		
		$current_date = date('Y-m-d');
		$current_time = date('YmdHis');
		$query_waktu=$this->db->select('WAKTU_AUDIT_AWAL,WAKTU_AUDIT_SELESAI')->from('WAKTU_AUDIT W')
		->join('RESPONSE_AUDITEE_H RE','W.ID_JADWAL=RE.ID_JADWAL')->where('RE.ID_HEADER',$data)
		->get();
		$result_waktu= $query_waktu->result_array();
		// var_dump($current_date<=$result_waktu['0']['WAKTU_AUDIT_SELESAI']);var_dump($current_date,$result_waktu);var_dump($data);die;
		if($current_date>=$result_waktu['0']['WAKTU_AUDIT_AWAL']){
			if($current_date<=$result_waktu['0']['WAKTU_AUDIT_SELESAI']){
				if($ext==""||$ext==null){
					$file_path = null;
				}else{	
					$config['file_name']        = "KETERANGAN_TL".$current_time;
					$config['upload_path'] = './storage/aia/'; // Lokasi penyimpanan file
					$config['allowed_types'] = 'xls|xlsx|pdf|doc|docx|ppt|pptx|jpg|jpeg|png|zip|rar'; // Jenis file yang diizinkan
					$config['max_size'] = 15000; // Ukuran maksimum file (dalam KB)\
					$upload_path = './storage/aia/';
					$eltype= $config['allowed_types'];
					$loadupload = $config['upload_path'];
					$this->upload->upload_path = $loadupload;
					$this->upload->allowed_types = $eltype;
					$this->upload->initialize($config);
					$file_path = base_url().'storage/aia/'.$config['file_name'].'.'.$ext;
					
					$elupload = $this->upload->do_upload('upload_file');
					$upload_data = $this->upload->data();
					// echo($file_path);
				}
				
				$data_update = 
					[
					'KETERANGAN_TL'           			=> is_empty_return_null($request['KETERANGAN_TL']),
					'FILE'           					=> is_empty_return_null($file_path)
					];
				
				$this->db->set('FILE', $file_path);
				$this->db->set('KETERANGAN_TL', $data_update['KETERANGAN_TL'][0]);
				$this->db->set('STATUS', 'TL');
				$this->db->where('ID_TEMUAN', $id_temuan);
				$update = $this->db->update('TEMUAN_DETAIL');
				
				if ($update){
					$success_message = 'Data Respon Berhasil Disimpan.';
					$this->session->set_flashdata('success', $success_message);
					redirect(base_url('aia/temuan/detail/'.$data));
				}
				else{
					$error_message = 'Silahkan coba kembali';
					$this->session->set_flashdata('error', $error_message);
					redirect(base_url('aia/temuan/detail/'.$data));
				}
				
			}
			else{
				$error_message = 'Anda sudah melewati batas waktu yang telah ditentukan';
				$this->session->set_flashdata('error', $error_message);
				redirect(base_url('aia/temuan/detail/'.$data));
			}
				
		}
		else{
			$error_message = 'Waktu Audit belum dimulai';
			$this->session->set_flashdata('error', $error_message);
			redirect(base_url('aia/temuan/detail/'.$data));
		}
		
	}

	public function approval($data) {
	    $request = $this->input->post();
		// $current_date = date('Y-m-d H:i:s');
		// var_dump($current_date);die;

	    if ($request['APPROVAL_COMMITMENT'] == 1){
	    	$this->db->select('APPROVAL_COMMITMENT');
		    $this->db->from('TEMUAN_DETAIL');
		    $this->db->where('ID_TEMUAN', $request['ID_TEMUAN']);
		    $current_value = $this->db->get()->row()->APPROVAL_COMMITMENT;
		    
		    // Tambahkan nilai baru ke nilai yang ada
		    $new_value = $current_value + $request['APPROVAL_COMMITMENT'];
			if ($new_value==3){
				$data_update = [
					'APPROVAL_COMMITMENT' 		=> $new_value,
					'KETERANGAN_LEAD_AUDITOR' => is_empty_return_null($request['KETERANGAN_ATASAN_AUDITEE']),
					'STATUS'					=> 'AC'
				];
			}
			else if ($new_value==2){
				$data_update = [
					'APPROVAL_COMMITMENT' 		=> $new_value,
					'KETERANGAN_AUDITOR' => is_empty_return_null($request['KETERANGAN_ATASAN_AUDITEE']),
					
				];
			}
			else{
				$data_update = [
					'APPROVAL_COMMITMENT' 		=> $new_value,
					'KETERANGAN_ATASAN_AUDITEE' => is_empty_return_null($request['KETERANGAN_ATASAN_AUDITEE'])
				];
			}
		    
	    } else {
	    	// Reject
	    	$data_update = [
		        'APPROVAL_COMMITMENT' 		=> $request['APPROVAL_COMMITMENT'],
		        'STATUS' 					=> 'OPEN',
		        'KETERANGAN_ATASAN_AUDITEE' => is_empty_return_null($request['KETERANGAN_ATASAN_AUDITEE'])
		    ];
	    	$new_value = $request['APPROVAL_COMMITMENT'];
	    }

	    $this->db->set($data_update);
	    $this->db->where('ID_TEMUAN', $request['ID_TEMUAN']);
	    $update = $this->db->update('TEMUAN_DETAIL');

	    if ($update) {
	        $success_message = 'Status Sudah Berhasil Di Approve';
	        $this->session->set_flashdata('success', $success_message);
	    } else {
	        $error_message = 'Status Gagal Di Approve ';
	        $this->session->set_flashdata('error', $error_message);
	    }

	    redirect(base_url('aia/temuan/detail/'.$data));
	}

	public function approvalTL($data) {
	    $request = $this->input->post();

	    if ($request['APPROVAL_TINDAKLANJUT'] == 1){
	    	$this->db->select('APPROVAL_TINDAKLANJUT');
		    $this->db->from('TEMUAN_DETAIL');
		    $this->db->where('ID_TEMUAN', $request['ID_TEMUAN']);
		    $current_value = $this->db->get()->row()->APPROVAL_TINDAKLANJUT;
		    
		    // Tambahkan nilai baru ke nilai yang ada
		    $new_value = $current_value + $request['APPROVAL_TINDAKLANJUT'];
			if ($new_value==3){
				$data_update = [
					'APPROVAL_TINDAKLANJUT' 	=> $new_value,
					'KETERANGAN_TL_LEAD_AUDITOR' => is_empty_return_null($request['KETERANGAN_TL_ATASAN']),
					'STATUS'					=> 'CLOSE'
				];
			}else if ($new_value==2){
				$data_update = [
					'APPROVAL_TINDAKLANJUT' 	=> $new_value,
					'KETERANGAN_TL_AUDITOR' => is_empty_return_null($request['KETERANGAN_TL_ATASAN']),
					
				];
			}
			else{
				$data_update = [
					'APPROVAL_TINDAKLANJUT' 	=> $new_value,
					'KETERANGAN_TL_ATASAN' => is_empty_return_null($request['KETERANGAN_TL_ATASAN'])
				];
			}
		    
	    } else {
	    	// Reject
	    	$data_update = [
		        'APPROVAL_TINDAKLANJUT' 		=> $request['APPROVAL_TINDAKLANJUT'],
		        'STATUS' 						=> 'AC',
		        'KETERANGAN_TL_ATASAN' 	=> is_empty_return_null($request['KETERANGAN_TL_ATASAN'])
		    ];
	    	$new_value = $request['APPROVAL_TINDAKLANJUT'];
	    }

	    $this->db->set($data_update);
	    $this->db->where('ID_TEMUAN', $request['ID_TEMUAN']);
	    $update = $this->db->update('TEMUAN_DETAIL');

	    if ($update) {
	        $success_message = 'Status Sudah Berhasil Di Approve';
	        $this->session->set_flashdata('success', $success_message);
	    } else {
	        $error_message = 'Status Gagal Di Approve ';
	        $this->session->set_flashdata('error', $error_message);
	    }

	    redirect(base_url('aia/temuan/detail/'.$data));
	}

	function getFileEntry($id_tl)
    {
            $query = $this->db->select('ID_TEMUAN, FILE, KETERANGAN_TL')->from('TEMUAN_DETAIL')
                        ->where('ID_TEMUAN', $id_tl)->get()->row();
            echo json_encode($query);   
    }

	public function chatbox($data){
		$request = $this->input->post();
		// var_dump($request['KOMENTAR_AUDITOR']);die;
		$data_update = [
			'KOMENTAR_AUDITOR'           			=> is_empty_return_null($request['KOMENTAR_AUDITOR']),
			'KOMENTAR_AUDITEE'          			=> is_empty_return_null($request['KOMENTAR_AUDITEE']),
		];
		// var_dump($request);die;	
		$user_session = $_SESSION['NAMA_ROLE'];
        if($user_session=="AUDITOR"){
			$this->db->set('KOMENTAR_AUDITOR', $request['KOMENTAR_AUDITOR']);
			$this->db->set('KOMENTAR_AUDITEE', $request['KOMENTAR_AUDITEE']);
			$this->db->set('STATUS_KOMEN_AUDITEE', '1');
			$this->db->where('ID_TEMUAN', $request['ID_TEMUAN']);
			$elupdate = $this->db->update('TEMUAN_DETAIL');
		}else{
			$this->db->set('KOMENTAR_AUDITOR', $request['KOMENTAR_AUDITOR']);
			$this->db->set('KOMENTAR_AUDITEE', $request['KOMENTAR_AUDITEE']);
			$this->db->set('STATUS_KOMEN_AUDITOR', '1');
			$this->db->where('ID_TEMUAN', $request['ID_TEMUAN']);
			$elupdate = $this->db->update('TEMUAN_DETAIL');
		}
		 
        
		if($elupdate){
			$success_message = 'Data Komentar Berhasil Diposting.';
			$this->session->set_flashdata('success', $success_message);
			redirect(base_url('aia/temuan/detail/'.$data));
		}else{
			$error_message = 'Gagal Silahakan coba lagi';
			$this->session->set_flashdata('error', $error_message);
			redirect(base_url('aia/temuan/detail/'.$data));
		}
		

	}
	function getdatadetail($id_tl) 
	{
		$user_session = $_SESSION['NAMA_ROLE'];
		$user_divisi = $_SESSION['ID_DIVISI'];
        if($user_session=="AUDITOR"){
			$query = $this->db->select('ID_TEMUAN,KOMENTAR_AUDITOR,KOMENTAR_AUDITEE')->from('TEMUAN_DETAIL')->where('ID_TEMUAN', $id_tl)->get()->row();
		}else{
			$query = $this->db->select('ID_TEMUAN,KOMENTAR_AUDITOR,KOMENTAR_AUDITEE')->from('TEMUAN_DETAIL')->where('ID_TEMUAN', $id_tl)->get()->row();
		}
		// var_dump($query);die;
        echo json_encode($query);
	}
	function updateStatus($data){
		$user_session = $_SESSION['NAMA_ROLE'];
		if($user_session=="AUDITOR"){
			$this->db->set('"STATUS_KOMEN_AUDITOR"','0');
			$this->db->where('ID_TEMUAN', $data);
			$this->db->update('TEMUAN_DETAIL');
		}
		else{
			$this->db->set('"STATUS_KOMEN_AUDITEE"','0');
			$this->db->where('ID_TEMUAN', $data);
			$this->db->update('TEMUAN_DETAIL');
		}
		
	}

	function export_pdf($id) {
		$data['title']          = 'Print LKHA';
        $data['content']        	= 'template/v_export_lkha';
		$this->load->view('template/v_export_lkha',$data);
		// redirect('template/v_export_lkha');
	}

}