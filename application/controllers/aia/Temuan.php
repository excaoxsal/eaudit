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

	public function detail($id_response){
		
		$data['list_divisi'] 		= $this->m_res_au->get_divisi();
		$data['list_temuan_header'] = $this->m_temuan->getAuditor_Lead($id_response);
		$data['menu']           	= 'temuan-aia';
        $data['title']          	= 'Temuan';
        $data['content']        	= 'content/aia/v_temuan_detail';
		$data['kode']				= $id_response;
		$data['role']				= $_SESSION['NAMA_ROLE'];
		//print_r($detail_temuan);die();
		
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

    public function getLog($data) {
        $this->m_temuan->getLog($data);
        //print_r($this->m_temuan->getLog($data));die();
    }

	public function proses_upload() { 
		$this->db->select('FILE'); // Sesuaikan dengan nama kolom yang menyimpan nama file
		$this->db->from('TEMUAN_DETAIL');
		$this->db->where('ID_RESPONSE', $_POST['ID_RE']);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->row();
			// Hapus file fisik jika ada
			if (file_exists($result->FILE)) {
				unlink($file_path);
			}
		}
		
		// Hapus data dari database
		$this->db->where('ID_RESPONSE', $_POST['ID_RE']);
		$this->db->delete('TEMUAN_DETAIL');
        
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
		
		$query_lain = $this->db->select('la."ID_USER" as ID_LEAD_AUDITOR, a."ID_USER" as ID_AUDITOR,w."ID_JADWAL"')->from('"WAKTU_AUDIT" w')
		->join('"TM_USER" la','la.ID_USER=w.ID_LEAD_AUDITOR')
		->join('"TM_USER" a','a.ID_USER=w.ID_AUDITOR')
		->join('"RESPONSE_AUDITEE_H" reh','reh."ID_JADWAL"=w."ID_JADWAL"')
		->where('reh."ID_HEADER"',$_POST['ID_RE'])->get();
		$data_lain=$query_lain->result_array();
		// $upload_data = $this->upload->data();
		// 	unlink($upload_data['full_path']);
		// var_dump($data_lain);die;
		
		$data = [];
			for ($row = 0; $row <= $highestRow; $row++) {
			
				$kode_klausul = $worksheet->getCellByColumnAndRow(0, $row+2)->getValue();
				$temuan = $worksheet->getCellByColumnAndRow(1, $row+2)->getValue();
				$kategori = $worksheet->getCellByColumnAndRow(2, $row+2)->getValue();
				if($kategori=="OBSERVASI"){
					$status="CLOSE";
				}else{
					$status="OPEN";
				}
				
				if($kode_klausul!=""){
					
						$data[] = array(
							'KLAUSUL'	=> is_empty_return_null($kode_klausul),
							'TEMUAN'		=> is_empty_return_null($temuan),
							'PERTANYAAN'	=> is_empty_return_null($pertanyaan),
							'ID_ISO'=>is_empty_return_null($_POST['ID_ISO']),
							'ID_MASTER_PERTANYAAN' => is_empty_return_null(''),
							'ID_AUDITOR'=>is_empty_return_null($data_lain[0]['ID_AUDITOR']),
							'ID_LEAD_AUDITOR'=>is_empty_return_null($data_lain[0]['ID_LEAD_AUDITOR']),
							'ID_JADWAL'=>is_empty_return_null($data_lain[0]['ID_JADWAL']),
							'STATUS' =>is_empty_return_null($status),
							'KATEGORI' =>is_empty_return_null($kategori)
						);	
					
					$eldata = [
									'KLAUSUL'	=> is_empty_return_null($data[$row]['KLAUSUL']),
									'TEMUAN'			=> is_empty_return_null($data[$row]['TEMUAN']),
									'ID_RESPONSE'		=> is_empty_return_null($_POST['ID_RE']),
									'ID_AUDITOR'=>is_empty_return_null($data_lain[0]['ID_AUDITOR']),
									'ID_LEAD_AUDITOR'=>is_empty_return_null($data_lain[0]['ID_LEAD_AUDITOR']),
									'ID_JADWAL'=>is_empty_return_null($data_lain[0]['ID_JADWAL']),
									'STATUS' =>is_empty_return_null($status),
									'KATEGORI'	=> is_empty_return_null($data[$row]['KATEGORI'])
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

	public function commitment($id_response) {
		$request = $this->input->post();
		$atasan_result = $this->m_temuan->getAtasan($_SESSION['ID_JABATAN']);
		$atasan = json_decode($atasan_result, true);
		date_default_timezone_set('Asia/Jakarta');
		// $status = $this->m_temuan->getStatus($request['ID_TEMUAN']);
		// $respObject = json_decode($status);
		$temuan_detail = $this->m_temuan->get_temuan_detail($id_response);
		// $temuan_header= $this->m_res_au->get_response_auditee_detail($id_response);
		// print_r($this->m_res_au->get_response_auditee_detail($id_response));die();
    	

		$data_update = 
			[
			'INVESTIGASI'           			=> is_empty_return_null($request['INVESTIGASI']),
			'PERBAIKAN'           				=> is_empty_return_null($request['PERBAIKAN']),
			'KOREKTIF'           				=> is_empty_return_null($request['KOREKTIF']),
			'TANGGAL'           				=> is_empty_return_null($request['TANGGAL']),
			'ID_ATASAN_AUDITEE' 				=> isset($atasan['ID_ATASAN']) ? $atasan['ID_ATASAN'] : null,
			'ID_AUDITEE'						=> is_empty_return_null($_SESSION['ID_USER']),
			'LOG_KIRIM'							=> 'Commitment Auditee'
			];
		// var_dump($data_update);die;
		$this->db->set('TANGGAL', $data_update['TANGGAL']);
		$this->db->set('KOREKTIF', $data_update['KOREKTIF'][0]);
		$this->db->set('PERBAIKAN', $data_update['PERBAIKAN'][0]);
		$this->db->set('INVESTIGASI', $data_update['INVESTIGASI'][0]);
		$this->db->set('STATUS', 'Commitment');
		$this->db->set('ID_ATASAN_AUDITEE', $data_update['ID_ATASAN_AUDITEE']);
		$this->db->set('ID_AUDITEE', $data_update['ID_AUDITEE']);
		$this->db->where('ID_TEMUAN', $request['ID_TEMUAN']);
		$update = $this->db->update('TEMUAN_DETAIL');
		if ($update){
			$this->m_temuan->insert_pemeriksa($temuan_detail[0]['ID_TEMUAN'], $temuan_detail[0]);
			$success_message = 'Data Commitment Berhasil Disimpan.';
			$this->session->set_flashdata('success', $success_message);
			redirect(base_url('aia/temuan/detail/'.$id_response));
		}
		else{
			$error_message = 'Silahkan coba kembali';
			$this->session->set_flashdata('error', $error_message);
			redirect(base_url('aia/temuan/detail/'.$id_response));
		}
	}

	public function tindakLanjut($data) {
		$request = $this->input->post();
		$temuan_detail = $this->m_temuan->get_temuan_detail($data);
		$array_where = [
			'ID_PERENCANAAN' => $request['ID_TEMUAN'],
			'JENIS_PERENCANAAN' => 'TEMUAN DETAIL',
			'ID_USER' => $_SESSION['ID_ATASAN_I']
		];
		date_default_timezone_set('Asia/Jakarta');
		$id_temuan = $_REQUEST['ID_TEMUAN'];
        $ext = pathinfo($_FILES['upload_file']['name'], PATHINFO_EXTENSION);
		
		$current_date = date('Y-m-d');
		$current_time = date('YmdHis');

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
				
		$data_update = 
			[
			'KETERANGAN_TL'           			=> is_empty_return_null($request['KETERANGAN_TL']),
			'FILE'           					=> is_empty_return_null($file_path),
			'LOG_KIRIM'							=> 'Tindak Lanjut Auditee'
			];
		
		$this->db->set('FILE', $file_path);
		$this->db->set('KETERANGAN_TL', $data_update['KETERANGAN_TL'][0]);
		$this->db->set('STATUS', 'Tindak Lanjut');
		$this->db->where('ID_TEMUAN', $id_temuan);
		$update = $this->db->update('TEMUAN_DETAIL');
		
		if ($update){
			$data_pemeriksa = ['STATUS_TINDAKLANJUT' => 1, 'TANGGAL' => date('Y-m-d')];
			$this->m_temuan->update($data_pemeriksa, $array_where, 'PEMERIKSA');
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

	public function approval($id_response) {
	    $request = $this->input->post();
	    $array_where = [
			'ID_PERENCANAAN' => $request['ID_TEMUAN'],
			'JENIS_PERENCANAAN' => 'TEMUAN DETAIL',
			'ID_USER' => $_SESSION['ID_USER']
		];
		$detail_temuan= $this->m_temuan->get_detail_temuan($id_response);
	    if ($request['APPROVAL_COMMITMENT'] == 1){
	    	$this->db->select('APPROVAL_COMMITMENT');
		    $this->db->from('TEMUAN_DETAIL');
		    $this->db->where('ID_TEMUAN', $request['ID_TEMUAN']);
		    $current_value = $this->db->get()->row()->APPROVAL_COMMITMENT;
		    
		    // Tambahkan nilai baru ke nilai yang ada
		    $new_value = $current_value + $request['APPROVAL_COMMITMENT'];
			if ($new_value==3){
				if($this->is_lead_auditor()){
					$data_update = [
						'APPROVAL_COMMITMENT' 		=> $new_value,
						'KETERANGAN_LEAD_AUDITOR' => is_empty_return_null($request['KETERANGAN_ATASAN_AUDITEE']),
						'STATUS'					=> 'Commitment Approved',
						'LOG_KIRIM'					=> 'Approval Commitment Lead Auditor'
					];
					$data_pemeriksa = ['STATUS_COMMITMENT' => 2, 'TANGGAL' => date('Y-m-d')];
					$this->m_temuan->update($data_pemeriksa, $array_where, 'PEMERIKSA');
				}
				else{
					$new_value = $current_value;
					$error_message = 'Gagal Approve dikarenakan Anda bukan Lead Auditor ';
	        		$this->session->set_flashdata('error', $error_message);
					redirect(base_url('aia/temuan/detail/'.$id_response));
				}
				
			}
			else if ($new_value==2){
				if($this->is_auditor()){
					$data_update = [
						'APPROVAL_COMMITMENT' 		=> $new_value,
						'KETERANGAN_AUDITOR' => is_empty_return_null($request['KETERANGAN_ATASAN_AUDITEE']),
						'LOG_KIRIM'					=> 'Approval Commitment Auditor'
					];
					$data_pemeriksa = ['STATUS_COMMITMENT' => 2, 'TANGGAL' => date('Y-m-d')];
					$this->m_temuan->update($data_pemeriksa, $array_where, 'PEMERIKSA');
				}
				else{
					$new_value = $current_value;
					$error_message = 'Gagal Approve dikarenakan Anda bukan Auditor ';
	        		$this->session->set_flashdata('error', $error_message);
					redirect(base_url('aia/temuan/detail/'.$id_response));
				}
				
			}
			else{
				if($this->is_atasan_auditee()){
					$data_update = [
						'APPROVAL_COMMITMENT' 		=> $new_value,
						'KETERANGAN_ATASAN_AUDITEE' => is_empty_return_null($request['KETERANGAN_ATASAN_AUDITEE']),
						'LOG_KIRIM'					=> 'Approval Commitment Atasan Auditee'
					];
					$data_pemeriksa = ['STATUS_COMMITMENT' => 2, 'TANGGAL' => date('Y-m-d')];
					$this->m_temuan->update($data_pemeriksa, $array_where, 'PEMERIKSA');
				}
				else{
					$new_value = $current_value;
					$error_message = 'Gagal Approve dikarenakan Anda bukan Atasan Auditee ';
	        		$this->session->set_flashdata('error', $error_message);
					redirect(base_url('aia/temuan/detail/'.$id_response));
				}
				
			}
		    
	    } else {
	    	// Reject
	    	$data_update = [
		        'APPROVAL_COMMITMENT' 		=> $request['APPROVAL_COMMITMENT'],
		        'STATUS' 					=> 'OPEN',
		        'KETERANGAN_ATASAN_AUDITEE' => is_empty_return_null($request['KETERANGAN_ATASAN_AUDITEE']),
				'LOG_KIRIM'					=> 'Reject'
		    ];
	    	//$new_value = $request['APPROVAL_COMMITMENT'];
	    	$array_where = [
				'ID_PERENCANAAN' => $request['ID_TEMUAN'],
				'JENIS_PERENCANAAN' => 'TEMUAN DETAIL'
			];
	    	$data_pemeriksa = ['STATUS_COMMITMENT' => 0, 'TANGGAL' => date('Y-m-d')];
			$this->m_temuan->update($data_pemeriksa, $array_where, 'PEMERIKSA');
	    }

	    $this->db->set($data_update);
	    $this->db->where('ID_TEMUAN', $request['ID_TEMUAN']);
	    $update = $this->db->update('TEMUAN_DETAIL');

	    if ($update) {
	    	$this->m_temuan->insert_pemeriksa($request['ID_TEMUAN'], $detail_temuan[0]);
	        $success_message = 'Status Sudah Berhasil Di Approve';
	        $this->session->set_flashdata('success', $success_message);
	    } else {
	        $error_message = 'Status Gagal Di Approve ';
	        $this->session->set_flashdata('error', $error_message);
	    }

	    redirect(base_url('aia/temuan/detail/'.$id_response));
	}

	public function approvalTL($id_response) {
	    $request = $this->input->post();
	    $detail_temuan= $this->m_temuan->get_detail_temuan($id_response);
	    $array_where = [
			'ID_PERENCANAAN' => $request['ID_TEMUAN'],
			'JENIS_PERENCANAAN' => 'TEMUAN DETAIL',
			'ID_USER' => $_SESSION['ID_USER']
		];
		//var_dump($_SESSION['ID_AUDITOR']);die();

	    if ($request['APPROVAL_TINDAKLANJUT'] == 1){
	    	$this->db->select('APPROVAL_TINDAKLANJUT');
		    $this->db->from('TEMUAN_DETAIL');
		    $this->db->where('ID_TEMUAN', $request['ID_TEMUAN']);
		    $current_value = $this->db->get()->row()->APPROVAL_TINDAKLANJUT;
		    
		    // Tambahkan nilai baru ke nilai yang ada
		    $new_value = $current_value + $request['APPROVAL_TINDAKLANJUT'];
			if ($new_value==3){
				$data_update = [
					'APPROVAL_TINDAKLANJUT'			=> $new_value,
					'KETERANGAN_TL_LEAD_AUDITOR' 	=> is_empty_return_null($request['KETERANGAN_TL_ATASAN']),
					'STATUS'						=> 'CLOSE',
					'LOG_KIRIM'						=> 'Approval Tindak Lanjut Lead Auditor'
				];
				$data_pemeriksa = ['STATUS_TINDAKLANJUT' => 2, 'TANGGAL' => date('Y-m-d')];
				$this->m_temuan->update($data_pemeriksa, $array_where, 'PEMERIKSA');
			}else if ($new_value==2){
				$data_update = [
					'APPROVAL_TINDAKLANJUT' 		=> $new_value,
					'KETERANGAN_TL_AUDITOR' 		=> is_empty_return_null($request['KETERANGAN_TL_ATASAN']),
					'LOG_KIRIM'						=> 'Approval Tindak Lanjut Auditor'
				];
				$data_pemeriksa1 = ['STATUS_TINDAKLANJUT' => 2, 'TANGGAL' => date('Y-m-d')];
				$this->m_temuan->update($data_pemeriksa1, $array_where, 'PEMERIKSA');

				$array_whereNext = [
					'ID_PERENCANAAN' => $request['ID_TEMUAN'],
					'JENIS_PERENCANAAN' => 'TEMUAN DETAIL',
					'ID_USER' => $detail_temuan[0]['ID_LEAD_AUDITOR']
				];

				$data_pemeriksa2 = ['STATUS_TINDAKLANJUT' => 1, 'TANGGAL' => date('Y-m-d')];
				$this->m_temuan->update($data_pemeriksa2, $array_whereNext, 'PEMERIKSA');
			}else{
				$data_update = [
					'APPROVAL_TINDAKLANJUT' 		=> $new_value,
					'KETERANGAN_TL_ATASAN' 			=> is_empty_return_null($request['KETERANGAN_TL_ATASAN']),
					'LOG_KIRIM'						=> 'Approval Tindak Lanjut Atasan Auditee'
				];
				$data_pemeriksa1 = ['STATUS_TINDAKLANJUT' => 2, 'TANGGAL' => date('Y-m-d')];
				$this->m_temuan->update($data_pemeriksa1, $array_where, 'PEMERIKSA');

				$array_whereNext = [
					'ID_PERENCANAAN' => $request['ID_TEMUAN'],
					'JENIS_PERENCANAAN' => 'TEMUAN DETAIL',
					'ID_USER' => $detail_temuan[0]['ID_AUDITOR']
				];

				$data_pemeriksa2 = ['STATUS_TINDAKLANJUT' => 1, 'TANGGAL' => date('Y-m-d')];
				$this->m_temuan->update($data_pemeriksa2, $array_whereNext, 'PEMERIKSA');

			}
		    
	    }else{
	    	// Reject
	    	$data_update = [
		        'APPROVAL_TINDAKLANJUT' 			=> $request['APPROVAL_TINDAKLANJUT'],
		        'STATUS' 							=> 'Commitment Approved',
		        'KETERANGAN_TL_ATASAN' 				=> is_empty_return_null($request['KETERANGAN_TL_ATASAN'])
		    ];
	    	//$new_value = $request['APPROVAL_TINDAKLANJUT'];
	    	$array_where = [
				'ID_PERENCANAAN' => $request['ID_TEMUAN'],
				'JENIS_PERENCANAAN' => 'TEMUAN DETAIL'
			];
	    	$data_pemeriksa = ['STATUS_TINDAKLANJUT' => 0, 'TANGGAL' => date('Y-m-d')];
			$this->m_temuan->update($data_pemeriksa, $array_where, 'PEMERIKSA');
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

	    redirect(base_url('aia/temuan/detail/'.$id_response));
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
        $data['content']        = 'template/v_export_lkha';

		$query = $this->db->select('la.NAMA as NAMA_LEAD_AUDITOR, a.NAMA as NAMA_AUDITOR,aud.NAMA as AUDITEE,aaud.NAMA as ATASAN_AUDITEE, 
		w.WAKTU_AUDIT_AWAL,w.WAKTU_AUDIT_SELESAI,
		td.KATEGORI,td.TANGGAL,td.INVESTIGASI,td.PERBAIKAN,td.KOREKTIF,td.ID_TEMUAN,td.POINT,td.KETERANGAN_TL_LEAD_AUDITOR,EXTRACT(YEAR FROM "CREATED_AT") as "WAKTU",
		d.NAMA_DIVISI,d.KODE,
		i.NOMOR_ISO,i.ID_ISO')
		->from('TEMUAN_DETAIL td')
		->join('TM_USER la','la.ID_USER=td.ID_LEAD_AUDITOR')
		->join('TM_USER a','a.ID_USER=td.ID_AUDITOR')
		->join('TM_USER aaud','td.ID_ATASAN_AUDITEE=aaud.ID_JABATAN','left')
		->join('TM_USER aud','aud.ID_USER=td.ID_AUDITEE','left')
		->join('WAKTU_AUDIT w','w.ID_JADWAL=td.ID_JADWAL')
		->join('RESPONSE_AUDITEE_H reh','reh.ID_HEADER=td.ID_RESPONSE')
		->join('TM_ISO i','i.ID_ISO=reh.ID_ISO')
		->join('TM_PERTANYAAN p','i.ID_ISO=p.ID_ISO','left')
		->join('TM_DIVISI d','d.KODE=reh.DIVISI','left')
		->where('ID_TEMUAN',$id)->get();
		$data_respon = $query->result_array();
		$data['id'] = $data_respon[0]['ID_TEMUAN'];
		$data['auditor'] = $data_respon[0]['NAMA_AUDITOR'];
		$data['lead_auditor'] = $data_respon[0]['NAMA_LEAD_AUDITOR'];
		$data['investigasi']=$data_respon[0]['INVESTIGASI'];
		$data['perbaikan']=$data_respon[0]['PERBAIKAN'];
		$data['korektif']=$data_respon[0]['KOREKTIF'];
		$data['tanggal']=$data_respon[0]['TANGGAL'];
		$data['auditee']=$data_respon[0]['NAMA_USER'];
		$data['atasan_auditee']=$data_respon[0]['ATASAN_AUDITEE'];
		$data['nomor_iso']=$data_respon[0]['NOMOR_ISO'];
		$data['kategori']=$data_respon[0]['KATEGORI'];
		$data['divisi']=$data_respon[0]['NAMA_DIVISI'];
		$data['kode_divisi']=$data_respon[0]['KODE'];
		$data['id_temuan']=$data_respon[0]['ID_TEMUAN'];
		$data['point']=$data_respon[0]['POINT'];
		$data['tahun']=$data_respon[0]['WAKTU'];
		$data['komen_lead']=$data_respon[0]["KETERANGAN_TL_LEAD_AUDITOR"];
		$data['komen_au']=$data_respon[0]["KETERANGAN_TL_AUDITOR"];
		$data['']=$data_respon[0][''];
		if($data_respon[0]['ID_ISO']==1){
			$data['kode_lks']="M";
		}else if($data_respon[0]['ID_ISO']==2){
			$data['kode_lks']="L";
		}else if($data_respon[0]['ID_ISO']==3){
			$data['kode_lks']="S";
		}else if($data_respon[0]['ID_ISO']==4){
			$data['kode_lks']="K3";
		}

        $pdf = new PDF('P', 'mm', 'A4', true, 'UTF-8', false);
		// var_dump($data);die;
		// return $this->load->view('template/v_export_lkha',$data);
        // Setel informasi dokumen
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('PT. PELABUHAN TANJUNG PRIOK');
        $pdf->SetTitle('Laporan Ketidaksesuaian Hasil Audit');
        $pdf->SetSubject('Laporan Audit');

        // Setel margin
        $pdf->SetMargins(15, 20, 15);
        $pdf->SetHeaderMargin(5);
        $pdf->SetFooterMargin(5);

        // Setel auto page breaks
        $pdf->SetAutoPageBreak(TRUE, 15);

        // // Tambah halaman baru
        $pdf->AddPage();

        // Setel font
        $pdf->SetFont('helvetica', '', 10);

        // // Isi konten HTML
        $html = $this->load->view('template/v_export_lkha', $data, true);
        // // $html = $this->load->view('cetakpdf', $data, true);

        // Cetak HTML ke dalam PDF
        $pdf->writeHTML($html, true, false, true, false, '');

        $pdf->Output('LKHA.pdf', 'I');
	}

}