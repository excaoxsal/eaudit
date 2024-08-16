<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PHPExcel\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Response_auditee extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('upload');
		$this->load->library('excel');
		$this->load->library('Pdf');
		$this->load->model('aia/M_res_auditee', 'm_res_au');
		$this->load->model('aia/M_jadwal', 'm_jadwal');
		$this->is_login();
		
	}

	public function index()
	{
		$datauser= $_SESSION;
		// var_dump($datauser);die;
		$data['list_status'] 	= $this->master_act->status();
		$data['list_divisi'] 	= $this->m_res_au->get_divisi();
		$data['menu']           = 'response_auditee';
        $data['title']          = 'Respon Auditee';
        $data['content']        = 'content/aia/v_response_auditee_header';
		
        $this->show($data);
	}

	public function detail($datas){
		
		$data['list_divisi'] 	= $this->m_res_au->get_divisi();
		$data['menu']           = 'response_auditee';
        $data['title']          = 'Respon Auditee';
        $data['content']        = 'content/aia/v_response_auditee_detail';
		$data['kode']			= $datas;
		// var_dump();die;
		$data['role']			= $_SESSION['NAMA_ROLE'];
		$data['detail']			= $this->m_res_au->get_response_auditee_detail($datas);
		$this->show($data);
	}
	public function respon($data){
		
		$request = $this->input->post();
		date_default_timezone_set('Asia/Jakarta');
		$id_re = $_REQUEST['ID_RE'];
        $ext = pathinfo($_FILES['file_excel']['name'], PATHINFO_EXTENSION);
		
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
					$config['file_name']        = "RESPON_AUDITEE".$current_time;
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
					if ( ! $this->upload->do_upload('file_excel'))
	                {
	                	$error_message = 'Gagal Upload File, Karena Batas Ukuran Maksimum Adalah 15 MB, <br>Silakan Di Upload Kembali';
						$this->session->set_flashdata('error', $error_message);
						redirect(base_url('aia/response_auditee/detail/'.$data));
	                }
				}
				
				$data_update = 
					[
					'RESPON'           			=> is_empty_return_null($request['RESPON']),
					'FILE'           			=> is_empty_return_null($file_path)
					];
				
				$this->db->set('FILE', $file_path);
				$this->db->set('RESPONSE_AUDITEE', $data_update['RESPON'][0]);
				$this->db->set('LOG_KIRIM', 'Response');
				$this->db->where('ID_RE', $id_re);
				$update = $this->db->update('RESPONSE_AUDITEE_D');
				
				if ($update){
					$success_message = 'Data Respon Berhasil Disimpan.';
					$this->session->set_flashdata('success', $success_message);
					redirect(base_url('aia/response_auditee/detail/'.$data));
				}
				else{
					$error_message = 'Silahkan coba kembali';
					$this->session->set_flashdata('error', $error_message);
					redirect(base_url('aia/response_auditee/detail/'.$data));
				}
				
			}
			else{
				$error_message = 'Anda sudah melewati batas waktu yang telah ditentukan';
				$this->session->set_flashdata('error', $error_message);
				redirect(base_url('aia/response_auditee/detail/'.$data));
			}
				
		}
		else{
			$error_message = 'Waktu Audit belum dimulai';
			$this->session->set_flashdata('error', $error_message);
			redirect(base_url('aia/response_auditee/detail/'.$data));
		}

		
		
		

	}
	public function deletefile() {
		$query = $this->db->select('FILE')->from('RESPONSE_AUDITEE_D')->where('ID_RE',$_POST['ID_RE'])->get();
		// var_dump($query->result_array());
		$file_path = $query->result_array();
		// var_dump($file_path[0]['FILE']);die;
		unlink($file_path[0]['FILE']);
		$this->db->set('FILE', NULL);
		$this->db->where('ID_RE', $_POST['ID_RE']);
		$update = $this->db->update('RESPONSE_AUDITEE_D');
		
	}

	public function chatbox($data){
		$request = $this->input->post();
		// var_dump($request['KOMENTAR_1']);die;
		$data_update = [
			'KOMENTAR_1'           			=> is_empty_return_null($request['MSG_AUDITOR']),
			'KOMENTAR_2'          			=> is_empty_return_null($request['MSG_AUDITEE']),
		];
		
		$user_session = $_SESSION['NAMA_ROLE'];
        if($user_session=="AUDITOR"){
			$this->db->set('KOMENTAR_1', $request['KOMENTAR_1']);
			$this->db->set('KOMENTAR_2', $request['KOMENTAR_2']);
			$this->db->set('STATUS_AUDITEE', '1');
			$this->db->set('LOG_KIRIM', 'Chat');
			$this->db->where('ID_RE', $request['ID_RE_CHAT']);
			$elupdate = $this->db->update('RESPONSE_AUDITEE_D');
		}else{
			$this->db->set('KOMENTAR_1', $request['KOMENTAR_1']);
			$this->db->set('KOMENTAR_2', $request['KOMENTAR_2']);
			$this->db->set('STATUS_AUDITOR', '1');
			$this->db->set('LOG_KIRIM', 'Chat');
			$this->db->where('ID_RE', $request['ID_RE_CHAT']);
			$elupdate = $this->db->update('RESPONSE_AUDITEE_D');
		}
		// var_dump($elcoding_parts);die; 
        
		if($elupdate){
			$success_message = 'Data Komentar Berhasil Diposting.';
			$this->session->set_flashdata('success', $success_message);
			redirect(base_url('aia/response_auditee/detail/'.$data));
		}else{
			$error_message = 'Gagal Silahakan coba lagi';
			$this->session->set_flashdata('error', $error_message);
			redirect(base_url('aia/response_auditee/detail/'.$data));
		}
		

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

	function jsonResponAuditee() 
	{
        header('Content-Type: application/json');
		// var_dump($this->m_res_au->get_response_auditee_header());
        echo json_encode($this->m_res_au->get_response_auditee_header());
	}

	function updateStatus($data){
		$user_session = $_SESSION['NAMA_ROLE'];
		if($user_session=="AUDITOR"){
			$this->db->set('STATUS_AUDITOR','0');
			$this->db->set('LOG_KIRIM', 'Read_chat');
			$this->db->where('ID_RE', $data);
			$this->db->update('RESPONSE_AUDITEE_D');
		}
		else{
			$this->db->set('STATUS_AUDITEE','0');
			$this->db->set('LOG_KIRIM', 'Read_chat');
			$this->db->where('ID_RE', $data);
			$this->db->update('RESPONSE_AUDITEE_D');
		}
		
	}
	
	public function generate($data){
		$query = $this->db->select('*')->from('TM_PERTANYAAN')->get();
		$query_divisi = $this->db->select('KODE')->from('WAKTU_AUDIT w')->join('TM_DIVISI d','d.ID_DIVISI=w.ID_DIVISI')->where('ID_JADWAL',$data)->get();
		$query_iso = $this->db->select('ID_ISO')->from('TM_ISO')->get();
		$result_iso = $query_iso->result_array();
		$query_bersih_h = $this->db->where('ID_JADWAL =', $data)->delete('RESPONSE_AUDITEE_D');
		$query_bersih_d = $this->db->where('ID_JADWAL =', $data)->delete('RESPONSE_AUDITEE_H');
		$result_divisi = $query_divisi->result_array();
		foreach($result_iso as $iso){
			$insert_header = [
				'DIVISI' => $result_divisi[0]['KODE'],
				'ID_ISO' => $iso['ID_ISO'],
				'ID_JADWAL' => $data,
				'LOG_KIRIM' => 'Generate Jadwal by ID_USER '.$_SESSION['ID_USER']													 
			];
			$sql_header=$this->db->insert('RESPONSE_AUDITEE_H', $insert_header);
		}
		// var_dump($sql_header);die;
		$query_subdiv = $this->db->select('KODE')->from('TM_DIVISI d')->where('KODE_PARENT',$result_divisi[0]['KODE'])->get();
		$result_subdiv = $query_subdiv->result_array();
		$kode_subdiv = array_column($result_subdiv, 'KODE');
		$results = $query->result_array();
		
		foreach ($results as $row) {
			$data_items = explode(',', $row['AUDITEE']); // Pisahkan data berdasarkan koma
			foreach ($data_items as $item) {
				
				if(in_array(trim($item), $kode_subdiv)){
					
					$query_header = $this->db->select('ID_HEADER')->from('RESPONSE_AUDITEE_H')->where('ID_ISO',$row['ID_ISO'])->where('ID_JADWAL',$data)->get();
					$result_header = $query_header->result_array();
					// var_dump($result_header);die;
					$data_to_insert[] = [
						'DIVISI' => $result_divisi[0]['KODE'],
						'ID_ISO' => $row['ID_ISO'],
						'ID_MASTER_PERTANYAAN' => $row['ID_MASTER_PERTANYAAN'],
						'ID_JADWAL' => $data,
						'SUB_DIVISI' => trim($item),
						'ID_HEADER' => $result_header[0]['ID_HEADER'],
						'LOG_KIRIM' =>'Generate Jadwal by ID_USER '.$_SESSION['ID_USER']
						
					];
					// Bersihkan dan siapkan data untuk dimasukkan
				}	
			}
		}
		
		
		
		$querys = $this->db->select('ID_JADWAL')->from('RESPONSE_AUDITEE_D')->where('ID_JADWAL',$data)->get();
		$resultq = $querys->result_array();
		
		
		if (!empty($data_to_insert)) {
			if(empty($resultq)){
				$this->db->insert_batch('RESPONSE_AUDITEE_D', $data_to_insert);
				$this->m_jadwal->update_status($data);
				$success_message = 'Data telah berhasil di-generate.';
				$this->session->set_flashdata('success', $success_message);
				echo base_url('aia/jadwal/jadwal_audit');
				
			}
		}
	}

	public function export_excel($datas){
		$this->load->database();
        $this->load->library('session');
		$this->db->select("
			
            i.\"NOMOR_ISO\",
			ra.\"DIVISI\" AS \"KODE_DIVISI\",
			d.\"NAMA_DIVISI\",
			w.\"WAKTU_AUDIT_AWAL\",
			w.\"WAKTU_AUDIT_SELESAI\",
			au.\"NAMA\" AS \"AUDITOR\",
			la.\"NAMA\" AS \"LEAD_AUDITOR\",
			m.\"PERTANYAAN\",
			m.\"KODE_KLAUSUL\",
			ra.\"RESPONSE_AUDITEE\",
			ra.\"KOMENTAR_1\" as \"KOMENTAR_AUDITOR\",
			ra.\"KOMENTAR_2\" as \"KOMENTAR_AUDITEE\",
			ra.\"FILE\",
            CAST(COALESCE(SPLIT_PART(m.\"KODE_KLAUSUL\", '.', 1), '0') AS DECIMAL) AS a,
            CAST(COALESCE(SPLIT_PART(m.\"KODE_KLAUSUL\", '.', 2), '0') AS DECIMAL) AS b,
            CAST(COALESCE(NULLIF(SPLIT_PART(m.\"KODE_KLAUSUL\", '.', 3), ''), '0') AS DECIMAL) AS c
			
        ", false);
        $this->db->from('"RESPONSE_AUDITEE_D" ra');
        $this->db->join('"WAKTU_AUDIT" w', 'ra."ID_JADWAL" = w."ID_JADWAL"', 'left');
        $this->db->join('"TM_PERTANYAAN" m', 'ra."ID_MASTER_PERTANYAAN" = m."ID_MASTER_PERTANYAAN"', 'left');
        $this->db->join('"TM_USER" au', 'w."ID_AUDITOR" = au."ID_USER"', 'left');
        $this->db->join('"TM_USER" la', 'w."ID_LEAD_AUDITOR" = la."ID_USER"', 'left');
        $this->db->join('"TM_ISO" i', 'm."ID_ISO" = i."ID_ISO"', 'left');
        $this->db->join('"TM_DIVISI" d', 'd."KODE" = ra."SUB_DIVISI"', 'left');
        $this->db->where('ra."ID_HEADER"', $datas);
        $this->db->order_by('a, b, c');

	$query = $this->db->get();
	$data = $query->result_array();
		// var_dump($data);die;
	

	// Create new Spreadsheet object
	$spreadsheet = new PHPExcel();

	// Set document properties
	$spreadsheet->getProperties()->setCreator('Aplikasi Internal Audit')
		->setLastModifiedBy('Aplikasi Internal Audit')
		->setTitle('Export Data')
		->setSubject('Export Data')
		->setDescription('Export data from database to Excel file')
		->setKeywords('export excel php codeigniter phpspreadsheet')
		->setCategory('Export Data');

	// Add header
	$spreadsheet->setActiveSheetIndex(0)
	->setCellValue('A1', 'NO')
	->setCellValue('B1', 'NOMOR_ISO')
	->setCellValue('C1', 'DIVISI')
	->setCellValue('D1', 'SUB DIVISI')
	->setCellValue('E1', 'WAKTU_AUDIT_AWAL')
	->setCellValue('F1', 'WAKTU_AUDIT_SELESAI')
	->setCellValue('G1', 'AUDITOR')
	->setCellValue('H1', 'LEAD_AUDITOR')
	->setCellValue('I1', 'PERTANYAAN')
	->setCellValue('J1', 'KODE_KLAUSUL')
	->setCellValue('K1', 'RESPONSE_AUDITEE')
	->setCellValue('L1', 'KOMENTAR AUDITOR')
	->setCellValue('M1', 'KOMENTAR AUDITEE')
	->setCellValue('N1', 'FILE');


	// Add data
	$row = 2;
	foreach ($data as $datum) {
		$spreadsheet->setActiveSheetIndex(0)
		->setCellValue('A' . $row, $row-1)
		->setCellValue('B' . $row, $datum['NOMOR_ISO'])
		->setCellValue('C' . $row, $datum['KODE_DIVISI'])
		->setCellValue('D' . $row, $datum['NAMA_DIVISI'])
		->setCellValue('E' . $row, $datum['WAKTU_AUDIT_AWAL'])
		->setCellValue('F' . $row, $datum['WAKTU_AUDIT_SELESAI'])
		->setCellValue('G' . $row, $datum['AUDITOR'])
		->setCellValue('H' . $row, $datum['LEAD_AUDITOR'])
		->setCellValue('I' . $row, $datum['PERTANYAAN'])
		->setCellValue('J' . $row, $datum['KODE_KLAUSUL'])
		->setCellValue('K' . $row, $datum['RESPONSE_AUDITEE'])
		->setCellValue('L' . $row, $datum['KOMENTAR_AUDITOR'])
		->setCellValue('M' . $row, $datum['KOMENTAR_AUDITEE']);

		if (!empty($datum['FILE'])) {
			//$url = str_replace('http://', '', $datum['FILE']);
			$url = $datum['FILE'];		 
            $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('N' . $row, 'Download File');
			$spreadsheet->getActiveSheet()->getCell('N' . $row)->getHyperlink()->setUrl(''.$url);
        } else {
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('N' . $row, 'No File');
        }
		

		$row++;
	}

	// Redirect output to a clientâ€™s web browser (Xlsx)
	$filename="export_data".$datum['NOMOR_ISO'].$datum['KODE_DIVISI'].".xlsx";
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="'.$filename. '"');
	header('Cache-Control: max-age=0');
	 // If you're serving to IE 9, set to 1
	// If you're serving to IE over SSL, then the following may be needed
	header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
	header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
	header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
	header ('Pragma: public'); // HTTP/1.0

	$writer = PHPExcel_IOFactory::createWriter($spreadsheet, 'Excel2007');
	$writer->save('php://output');
	exit;
	}
	function is_empty_return_null($value) {
		return empty($value) ? NULL : $value;
	}
}
