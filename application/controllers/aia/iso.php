<?php
defined('BASEPATH') or exit('No direct script access allowed');
use PHPExcel\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Iso extends MY_Controller
{


    public function __construct()
	{
		parent::__construct();
		$this->load->library('upload');
		$this->load->library('excel');
		$this->load->model('perencanaan/M_tim_audit', 'm_tim_audit');
		$this->load->model('aia/M_jadwal', 'm_jadwal');
        $this->load->model('aia/M_iso','m_iso');
        $this->load->model('aia/M_pertanyaan','m_pertanyaan');
		$this->is_login();
		if(!$this->is_auditor()) $this->load->view('/errors/html/err_401');
	}

    function jsonIsoList() 
	{
        header('Content-Type: application/json');
		// echo $this->m_iso->get_iso();
		// die();
        echo json_encode($this->m_iso->iiso());
	}

	function jsonPertanyaanList($id_iso) 
	{
        header('Content-Type: application/json');
		// echo $this->m_pertanyaan->show_iso($data);
		// die();
        echo json_encode($this->m_pertanyaan->show_iso($id_iso));
	}


    public function index(){
        $data['list_status'] 	= $this->master_act->status();
		$dataiso = $this->m_iso->get_iso();
		$data['menu']           = 'master-aia';
		$data['sub_menu']       = 'm_iso';
		$data['title']          = 'Master Pertanyaan';
        $data['content']        = 'content/aia/v_m_iso';
		$data['id_user']		= $this->session->ID_USER;
		$id_user = $data['id_user'];
		$data['jadwal_list'] 	= $this->m_jadwal->jadwal_list($id_user);
        $data['data_iso'] = $dataiso;
		// print_r( $this->jsonIsoList() );
		// die;
		// var_dump($dataiso);
		// die();
        $this->show($data);
    }

	public function show_iso($iso){
		// var_dump($iso);
		// die;
		$datapertanyaan = $this->m_pertanyaan->show_iso($iso);
		$eljson = json_encode($datapertanyaan);
		$data['id_iso'] = $iso;
		$data['pertanyaan']=$datapertanyaan;
		$data['list_status'] 	= $this->master_act->status();
		$dataiso = $this->m_iso->get_iso();
		$data['menu']           = 'master-aia';
		$data['sub_menu']       = 'm_pertanyaan';
		$data['title']          = 'Master Pertanyaan';
        $data['content']        = 'content/aia/v_m_pertanyaan';
		$data['id_user']		= $this->session->ID_USER;
		$id_user = $data['id_user'];
		$data['jadwal_list'] 	= $this->m_jadwal->jadwal_list($id_user);
        $data['data_iso'] = $dataiso;
		$data['data_pertanyaan'] = $eljson;
		// print_r( $this->jsonIsoList() );
		// die;
		// var_dump($dataiso);
		// die();
		// var_dump($_POST);
		// die;
		// $jsoncode =  $this->jsonPertanyaanList($iso);
		
        $this->show($data);
	}

	public function proses_upload() {
		// var_dump($_POST['ID_ISO']);
		// die;
		// $nipp                       = $this->input->post('nipp');
		$config['file_name']        = "upload_master_pertanyaan";
		$config['upload_path'] = './storage/aia/'; // Lokasi penyimpanan file
		$config['allowed_types'] = 'xls|xlsx'; // Jenis file yang diizinkan
		$config['max_size'] = 1280000; // Ukuran maksimum file (dalam KB)\
		$upload_path = './storage/aia/';
		// if (!is_dir($upload_path)) {
		// 	// die('The upload path does not exist: ' . $upload_path);
		// }
		// else{
		// 	echo 'sukses';
		// }
		$eltype= $config['allowed_types'];
		$loadupload = $config['upload_path'];
		$this->upload->upload_path = $loadupload;
		$this->upload->allowed_types = $eltype;
		// $this->load->library('upload', $config);
		$this->upload->initialize($config);
		$elupload = $this->upload->do_upload('file_excel');
		if (!$elupload) {
			// Jika upload gagal, tampilkan pesan error
			$error = $this->upload->display_errors();
			// var_dump($this->upload->allowed_types);
			// echo $error;
			// die();
			// echo "test";
		} else {
			// Jika upload berhasil, baca file Excel
			// echo'rest';
			$file_data = $this->upload->data();		
			$file_path = './storage/aia/'.$file_data['file_name'];
			// Hapus file setelah selesai membaca
		}

		$base_url = base_url();
		$this->m_pertanyaan->clean($_POST['ID_ISO']);
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

		// Loop through each row and column to read the data
		$data = [];
		for ($col = 0; $col < $highestRow-1; $col++) {
			for ($row = 0; $row <= $highestRow; $row++) {
			
				$kode_klausul = $worksheet->getCellByColumnAndRow(0, $row+2)->getValue();
				$lv1 = $worksheet->getCellByColumnAndRow(1, $row+2)->getValue();
				$lv2 = $worksheet->getCellByColumnAndRow(2, $row+2)->getValue();
				$lv3 = $worksheet->getCellByColumnAndRow(3, $row+2)->getValue();
				$lv4 = $worksheet->getCellByColumnAndRow(4, $row+2)->getValue();
				$auditee = $worksheet->getCellByColumnAndRow(5, $row+2)->getValue();
				$pertanyaan = $worksheet->getCellByColumnAndRow(6, $row+2)->getValue();
				
				// if($auditee=="ALL"){
				// 	$query_all_divisi = $this->db->select('KODE')->from('TM_DIVISI')->get();
				// 	$result_divisi = $query_all_divisi->result_array();
				// 	// var_dump($result_divisi);die;
					
				// 	foreach($result_divisi as $divisi){
				// 		$cols+=1;
				// 		$rows=0;
				// 		// var_dump($divisi['KODE']);die;
				// 		// $a+=1;
				// 		$data_all[] = array(
				// 			'KODE_KLAUSUL'	=> is_empty_return_null($kode_klausul),
				// 			'LV1'			=> is_empty_return_null($lv1),
				// 			'LV2'			=> is_empty_return_null($lv2),
				// 			'LV3'			=> is_empty_return_null($lv3),
				// 			'LV4'			=> is_empty_return_null($lv4),
				// 			'AUDITEE'		=> is_empty_return_null($divisi['KODE']),
				// 			'PERTANYAAN'	=> is_empty_return_null($pertanyaan),
				// 			'ID_ISO'=>is_empty_return_null($_POST['ID_ISO']),
				// 			'ID_MASTER_PERTANYAAN' => is_empty_return_null('')
				// 		);
				// 	$values = $worksheet->getCellByColumnAndRow($cols-1, $rows-1)->getValue();
				// 	$data_all[$rows-1][$cols-1] =$values;
				// 	// $saves = $this->m_pertanyaan->save($data_all[$a-1]);
						
				// 	}
					
				// }else{
					$data[] = array(
						'KODE_KLAUSUL'	=> is_empty_return_null($kode_klausul),
						'LV1'			=> is_empty_return_null($lv1),
						'LV2'			=> is_empty_return_null($lv2),
						'LV3'			=> is_empty_return_null($lv3),
						'LV4'			=> is_empty_return_null($lv4),
						'AUDITEE'		=> is_empty_return_null($auditee),
						'PERTANYAAN'	=> is_empty_return_null($pertanyaan),
						'ID_ISO'=>is_empty_return_null($_POST['ID_ISO']),
						'ID_MASTER_PERTANYAAN' => is_empty_return_null('')
					);
					
					
				// }
				$value = $worksheet->getCellByColumnAndRow($col, $row)->getValue();
					
					$data[$row][$col] = $value;
				
				

			}	
			// var_dump($data[$col]);die;

			$eldata = [
				'KODE_KLAUSUL'	=> is_empty_return_null($data[$col]['KODE_KLAUSUL']),
				'LV1'			=> is_empty_return_null($data[$col]['LV1']),
				'LV2'			=> is_empty_return_null($data[$col]['LV2']),
				'LV3'			=> is_empty_return_null($data[$col]['LV3']),
				'LV4'			=> is_empty_return_null($data[$col]['LV4']),
				'AUDITEE'		=> is_empty_return_null($data[$col]['AUDITEE']),
				'PERTANYAAN'	=> is_empty_return_null($data[$col]['PERTANYAAN']),
				'ID_ISO'		=> is_empty_return_null($_POST['ID_ISO']),
				
			];
			
				
				// var_dump($data[$col]['LV1']);
				// var_dump($eldata);die;
				$save = $this->m_pertanyaan->save($eldata);
				
				
		}
				// var_dump($eldata);
				// die;
				$upload_data = $this->upload->data();
				unlink($upload_data['full_path']);
			if($save==true){
				$update = $this->m_iso->update($_POST['ID_ISO']);
				$success_message = 'Data berhasil disimpan.';
				$this->session->set_flashdata('success', $success_message);
				redirect($_SERVER['HTTP_REFERER']);
			}
			else{
				$error_message = 'Silahkan cek kembali datanya';
				$this->session->set_flashdata('error', $error_message);
			}
	}


}