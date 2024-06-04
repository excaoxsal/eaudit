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
		$data['detail']			= $this->m_res_au->get_response_auditee_detail($datas);
		$elcoding = $datas;
		$elcoding_parts = explode('00', $elcoding); // Pisahkan data berdasarkan koma




		$elcoding = $datas;
        $elcoding_parts = explode('00', $elcoding);
        $divisi = $elcoding_parts[0];
        $id_iso = $elcoding_parts[1];
        $id_jadwal = $elcoding_parts[2];

        $sql = '
        SELECT 
            i."NOMOR_ISO",
            ra."DIVISI" AS "KODE",
            d."NAMA_DIVISI",
            w."WAKTU_AUDIT_AWAL",
            w."WAKTU_AUDIT_SELESAI",
            au."NAMA" AS "AUDITOR",
            la."NAMA" AS "LEAD_AUDITOR",
            m."PERTANYAAN",
            m."KODE_KLAUSUL",
            ra."KOMENTAR_1",
            ra."KOMENTAR_2",
            ra."ID_MASTER_PERTANYAAN",
            ra."SUB_DIVISI"
        FROM 
            "RESPONSE_AUDITEE_D" ra
        LEFT JOIN 
            "WAKTU_AUDIT" w ON ra."ID_JADWAL" = w."ID_JADWAL"
        LEFT JOIN 
            "M_PERTANYAAN" m ON ra."ID_MASTER_PERTANYAAN" = m."ID_MASTER_PERTANYAAN"
        JOIN 
            "TM_USER" au ON w."ID_AUDITOR" = au."ID_USER"
        LEFT JOIN 
            "TM_USER" la ON w."ID_LEAD_AUDITOR" = la."ID_USER"
        LEFT JOIN 
            "M_ISO" i ON m."ID_ISO" = i."ID_ISO"
        JOIN 
            "TM_DIVISI" d ON d."KODE" = ra."DIVISI"
        WHERE 
            ra."DIVISI" = ?
            AND i."ID_ISO" = ?
            AND ra."ID_JADWAL" = ?
            AND ra."SUB_DIVISI" IS NOT NULL
        ';
    
        // Menyusun parameter untuk query
        $params = array($divisi, $id_iso, $id_jadwal);
        
        // Menjalankan query dengan parameter
        $query = $this->db->query($sql, $params);
		// var_dump($query->result_array());die;

		$this->show($data);
	}
	public function respon($data){
		$request = $this->input->post();
		date_default_timezone_set('Asia/Jakarta');
		// // echo "Waktu server saat ini: " . date('Y-m-d H:i:s');
		echo date('Y-m-d');
		// $aswd=date('Y-m-d H:i:s');echo $asw;
		// die;
		$query_waktu=$this->db->select('WAKTU_AUDIT_AWAL,WAKTU_AUDIT_SELESAI')->from('WAKTU_AUDIT')->get();
		$result_waktu= $query_waktu->result_array();
		if($result_waktu['0']['WAKTU_AUDIT_AWAL']<=date('Y-m-d')){
			if($result_waktu['0']['WAKTU_AUDIT_SELESAI']>=date('Y-m-d')){
				// echo"SUSKES";
				// var_dump($result_waktu['0']['WAKTU_AUDIT_AWAL']);die;
				$elcoding_parts = explode('00', $data);
				$divisi = $elcoding_parts[0];
				$id_iso = $elcoding_parts[1];
				$id_jadwal = $elcoding_parts[2];
				$config['file_name']        = "RESPON_AUDITEE";
				$config['upload_path'] = './storage/aia/'; // Lokasi penyimpanan file
				$config['allowed_types'] = 'xls|xlsx'; // Jenis file yang diizinkan
				$config['max_size'] = 1280000; // Ukuran maksimum file (dalam KB)\
				$upload_path = './storage/aia/';
				$eltype= $config['allowed_types'];
				$loadupload = $config['upload_path'];
				$this->upload->upload_path = $loadupload;
				$this->upload->allowed_types = $eltype;
				// $this->load->library('upload', $config);
				$this->upload->initialize($config);
				$file_path = './storage/aia/'.$config['file_name'];
				$elupload = $this->upload->do_upload('file_excel');
				$upload_data = $this->upload->data();
				// echo($upload_data['full_path']);
				$data_update = 
					[
					'RESPON'           			=> is_empty_return_null($request['RESPON']),
					'FILE'           			=> is_empty_return_null($file_path)
					];
				$this->db->set('FILE', $data_update['FILE']);
				$this->db->set('RESPONSE_AUDITEE', $data_update['RESPON'][0]);
				$this->db->where('DIVISI', $divisi);
				$this->db->where('ID_ISO', $id_iso);
				$this->db->where('ID_JADWAL', $id_jadwal);
				$this->db->update('RESPONSE_AUDITEE_D');
				$success_message = 'Data Respon Berhasil Disimpan.';
				$this->session->set_flashdata('success', $success_message);
				redirect(base_url('aia/response_auditee/detail/'.$data));
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
		
		// var_dump($elupload);
		// die;
		
		// unlink($file_path);
		// var_dump($elupload);
		// die;
		// if(!unlink($upload_data['full_path'])){
		// 	echo "SUKSES'nt";
		// }
		// else{
		// 	echo "!!!!!!!!!!!!!!!!!!!!";
		// }

	}

	public function chatbox($data){
		$request = $this->input->post();
		// var_dump($request);die;
		$data_update = [
			'KOMENTAR_1'           			=> is_empty_return_null($request['MSG_AUDITOR']),
			'KOMENTAR_2'          			=> is_empty_return_null($request['MSG_AUDITEE']),
		];
		
		$elcoding_parts = explode('00', $data);
        $divisi = $elcoding_parts[0];
        $id_iso = $elcoding_parts[1];
        $id_jadwal = $elcoding_parts[2];
		$id_master_pertanyaan = $request['ID_MASTER_PERTANYAAN'];
		$sub_divisi = $request['SUB_DIVISI'];

		// var_dump($elcoding_parts);die; 
        $this->db->set('KOMENTAR_1', $data_update['KOMENTAR_1'][0]);
        $this->db->set('KOMENTAR_2', $data_update['KOMENTAR_2'][0]);
        $this->db->where('DIVISI', $divisi);
        $this->db->where('ID_ISO', $id_iso);
        $this->db->where('ID_JADWAL', $id_jadwal);
        $this->db->where('ID_MASTER_PERTANYAAN', $id_master_pertanyaan);
        $this->db->where('SUB_DIVISI', $sub_divisi);
        $elupdate = $this->db->update('RESPONSE_AUDITEE_D');
		// var_dump($elupdate);die;
		$success_message = 'Data Komentar Berhasil Diposting.';
		$this->session->set_flashdata('success', $success_message);
		redirect(base_url('aia/response_auditee/detail/'.$data));
		// $update = $this->m_res_au->update_komen($data,$data_update);

	}
	public function response_submit($data){
		
	}


	function jsonResponAuditeeDetail($data) 
	{
        header('Content-Type: application/json');
		// var_dump($this->m_res_au->get_response_auditee_detail($data));
		// die;
        echo json_encode($this->m_res_au->get_response_auditee_detail($data));
	}

	function jsonResponAuditee() 
	{
        header('Content-Type: application/json');
		// var_dump($this->m_res_au->get_response_auditee());
        echo json_encode($this->m_res_au->get_response_auditee_header());
	}

	function jsonKotakMasukApm() 
	{
        header('Content-Type: application/json');
        echo json_encode($this->m_apm->kotak_masuk($this->session->ID_USER));
	}
	
	public function generate($data){
		// echo($data);
		// die;
		$query = $this->db->select('*')->from('M_PERTANYAAN')->get();
		$query_divisi = $this->db->select('KODE')->from('WAKTU_AUDIT w')->join('TM_DIVISI d','d.ID_DIVISI=w.ID_DIVISI')->where('ID_JADWAL',$data)->get();
		$query_iso = $this->db->select('ID_ISO')->from('M_ISO')->get();
		$result_iso = $query_iso->result_array();
		$query_bersih_h = $this->db->where('ID_JADWAL =', $data)->delete('RESPONSE_AUDITEE_D');
		$query_bersih_d = $this->db->where('ID_JADWAL =', $data)->delete('RESPONSE_AUDITEE_H');
		$result_divisi = $query_divisi->result_array();
		foreach($result_iso as $iso){
			$insert_header = [
				'DIVISI' => $result_divisi[0]['KODE'],
				'ID_ISO' => $iso['ID_ISO'],
				'ID_JADWAL' => $data,
			];
			$sql_header=$this->db->insert('RESPONSE_AUDITEE_H', $insert_header);
		}
		// var_dump($sql_header);die;
		$query_subdiv = $this->db->select('KODE')->from('TM_DIVISI d')->where('KODE_PARENT',$result_divisi[0]['KODE'])->get();
		$result_subdiv = $query_subdiv->result_array();
		$kode_subdiv = array_column($result_subdiv, 'KODE');
		$results = $query->result_array();
		
		
		// var_dump($result_subdiv);die;
		
		// die;
		
		foreach ($results as $row) {
			$data_items = explode(',', $row['AUDITEE']); // Pisahkan data berdasarkan koma
			foreach ($data_items as $item) {
				
				
				if(in_array(trim($item), $kode_subdiv)){
					
					// $query_header = $this->db->select('ID_JADWAL')->from('RESPONSE_AUDITEE_H')->where('DIVISI',trim($item))->get();
					// $result_header = $query_header->result_array();
					$data_to_insert[] = [
						'DIVISI' => $result_divisi[0]['KODE'],
						'ID_ISO' => $row['ID_ISO'],
						'ID_MASTER_PERTANYAAN' => $row['ID_MASTER_PERTANYAAN'],
						'ID_JADWAL' => $data,
						'SUB_DIVISI' => trim($item)
						
					];
					
					
					
					// Bersihkan dan siapkan data untuk dimasukkan
				}	
			}
		}
		
		// var_dump($data_to_insert);
		// 	die;
		
		$querys = $this->db->select('ID_JADWAL')->from('RESPONSE_AUDITEE_D')->where('ID_JADWAL',$data)->get();
		$resultq = $querys->result_array();
		// var_dump($resultq);
		// die;
		
		if (!empty($data_to_insert)) {
			if(empty($resultq)){
				$this->db->insert_batch('RESPONSE_AUDITEE_D', $data_to_insert);
				$this->m_jadwal->update_status($data);
				$success_message = 'Data telah berhasil di-generate.';
				$this->session->set_flashdata('success', $success_message);
				echo base_url('aia/jadwal/jadwal_audit');
				
			}
		}
		
		// var_dump($inserteldb);
		// die;
	}

	public function export_excel($data){
		$this->load->database();
        $this->load->library('session');
		$elcoding = $data;
		$elcoding_parts = explode('00', $elcoding);
        $divisi = $elcoding_parts[0];
        $id_iso = $elcoding_parts[1];
        $id_jadwal = $elcoding_parts[2];
		$this->db->select('
		i."NOMOR_ISO",
		ra."DIVISI" AS "DIVISI",
		d."NAMA_DIVISI",
		w."WAKTU_AUDIT_AWAL",
		w."WAKTU_AUDIT_SELESAI",
		au."NAMA" AS "AUDITOR",
		la."NAMA" AS "LEAD_AUDITOR",
		m."PERTANYAAN",
		m."KODE_KLAUSUL",
		ra.RESPONSE_AUDITEE,
		ra.KOMENTAR_1 as "KOMENTAR AUDITOR",
		ra.KOMENTAR_2 as "KOMENTAR AUDITEE",
		string_agg(ra."DIVISI"::text || \'00\' || i."ID_ISO"::text || \'00\' || ra."ID_JADWAL"::text, \'\') AS "ELCODING"'
		)
		->from('RESPONSE_AUDITEE_D ra')
		->join('WAKTU_AUDIT w', 'ra."ID_JADWAL" = w."ID_JADWAL"', 'left')
		->join('M_PERTANYAAN m', 'ra."ID_MASTER_PERTANYAAN" = m."ID_MASTER_PERTANYAAN"', 'left')
		->join('TM_USER au', 'w."ID_AUDITOR" = au."ID_USER"')
		->join('TM_USER la', 'w."ID_LEAD_AUDITOR" = la."ID_USER"', 'left')
		->join('M_ISO i', 'm."ID_ISO" = i."ID_ISO"', 'left')
		->join('TM_DIVISI d', 'd."KODE" = ra."DIVISI"')
		->where('ra."DIVISI"', $divisi)
		->where('i."ID_ISO"', $id_iso)
		->where('w."ID_JADWAL"', $id_jadwal)
		->group_by('i."NOMOR_ISO", ra."DIVISI", d."NAMA_DIVISI", w."WAKTU_AUDIT_AWAL", 
					w."WAKTU_AUDIT_SELESAI", au."NAMA", la."NAMA", m."PERTANYAAN", m."KODE_KLAUSUL",ra.RESPONSE_AUDITEE,ra.KOMENTAR_1,ra.KOMENTAR_2');

	$query = $this->db->get();
	$data = $query->result_array();
	var_dump($data);die;

	// Create new Spreadsheet object
	$spreadsheet = new PHPExcel();

	// Set document properties
	$spreadsheet->getProperties()->setCreator('Your Name')
		->setLastModifiedBy('Your Name')
		->setTitle('Export Data')
		->setSubject('Export Data')
		->setDescription('Export data from database to Excel file')
		->setKeywords('export excel php codeigniter phpspreadsheet')
		->setCategory('Export Data');

	// Add header
	$sheet = $spreadsheet->getActiveSheet();
	$sheet->setCellValue('A1', 'NOMOR_ISO');
	$sheet->setCellValue('B1', 'DIVISI');
	$sheet->setCellValue('C1', 'NAMA_DIVISI');
	$sheet->setCellValue('D1', 'WAKTU_AUDIT_AWAL');
	$sheet->setCellValue('E1', 'WAKTU_AUDIT_SELESAI');
	$sheet->setCellValue('F1', 'AUDITOR');
	$sheet->setCellValue('G1', 'LEAD_AUDITOR');
	$sheet->setCellValue('H1', 'PERTANYAAN');
	$sheet->setCellValue('I1', 'KODE_KLAUSUL');
	$sheet->setCellValue('J1', 'ELCODING');
	$sheet->setCellValue('K1', 'RESPONSE_AUDITEE');
	$sheet->setCellValue('L1', 'KOMENTAR AUDITOR');
	$sheet->setCellValue('M1', 'KOMENTAR AUDITEE');


	// Add data
	$row = 2;
	foreach ($data as $datum) {
		$sheet->setCellValue('A' . $row, $datum['NOMOR_ISO']);
		$sheet->setCellValue('B' . $row, $datum['KODE']);
		$sheet->setCellValue('C' . $row, $datum['NAMA_DIVISI']);
		$sheet->setCellValue('D' . $row, $datum['WAKTU_AUDIT_AWAL']);
		$sheet->setCellValue('E' . $row, $datum['WAKTU_AUDIT_SELESAI']);
		$sheet->setCellValue('F' . $row, $datum['AUDITOR']);
		$sheet->setCellValue('G' . $row, $datum['LEAD_AUDITOR']);
		$sheet->setCellValue('H' . $row, $datum['PERTANYAAN']);
		$sheet->setCellValue('I' . $row, $datum['KODE_KLAUSUL']);
		$sheet->setCellValue('J' . $row, $datum['ELCODING']);
		$sheet->setCellValue('K' . $row, $datum['RESPONSE_AUDITEE']);
		$row++;
	}

	// Redirect output to a client’s web browser (Xlsx)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="export_data.xlsx"');
	header('Cache-Control: max-age=0');
	header('Cache-Control: max-age=1'); // If you're serving to IE 9, set to 1

	$writer = PHPExcel_IOFactory::createWriter($spreadsheet, 'Excel5');;
	$writer->save('php://output');
	exit;
	}
	function is_empty_return_null($value) {
		return empty($value) ? NULL : $value;
	}

	

	

}
