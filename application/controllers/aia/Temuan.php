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
		
		$data['list_divisi'] 	= $this->m_res_au->get_divisi();
		$data['menu']           = 'response_auditee';
        $data['title']          = 'Respon Auditee';
        $data['content']        = 'content/aia/v_temuan_detail';
		$data['kode']			= $datas;
		// var_dump();die;
		$data['role']			= $_SESSION['NAMA_ROLE'];
		$data['detail']			= $this->m_res_au->get_response_auditee_detail($datas);
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

		// Loop through each row to read the data
		$data = [];
			for ($row = 0; $row <= $highestRow; $row++) {
			
				$kode_klausul = $worksheet->getCellByColumnAndRow(0, $row+2)->getValue();
				$lv1 = $worksheet->getCellByColumnAndRow(1, $row+2)->getValue();
				$lv2 = $worksheet->getCellByColumnAndRow(2, $row+2)->getValue();
				$lv3 = $worksheet->getCellByColumnAndRow(3, $row+2)->getValue();
				$lv4 = $worksheet->getCellByColumnAndRow(4, $row+2)->getValue();
				$auditee = $worksheet->getCellByColumnAndRow(5, $row+2)->getValue();
				$pertanyaan = $worksheet->getCellByColumnAndRow(6, $row+2)->getValue();
				if($kode_klausul!=""){
					if (stripos($auditee, "all") !== false){
						$query_all_divisi = $this->db->select('KODE')->from('TM_DIVISI')->where('IS_DIVISI','N')->get();
						$result_divisi = $query_all_divisi->result_array();
						// var_dump($result_divisi);die;
						$data_divisi="";
						for($i=0;$i<sizeof($result_divisi);$i++){
							
							
							$data_divisi .=$result_divisi[$i]['KODE'];
							if ($i < sizeof($result_divisi)-1){
								$data_divisi.=",";	
							}
						}
						// var_dump($data_divisi);die;
						$auditee = $data_divisi;
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
						
					}else{
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
					}
					$eldata = [
									'KODE_KLAUSUL'	=> is_empty_return_null($data[$row]['KODE_KLAUSUL']),
									'LV1'			=> is_empty_return_null($data[$row]['LV1']),
									'LV2'			=> is_empty_return_null($data[$row]['LV2']),
									'LV3'			=> is_empty_return_null($data[$row]['LV3']),
									'LV4'			=> is_empty_return_null($data[$row]['LV4']),
									'AUDITEE'		=> is_empty_return_null($data[$row]['AUDITEE']),
									'PERTANYAAN'	=> is_empty_return_null($data[$row]['PERTANYAAN']),
									'ID_ISO'		=> is_empty_return_null($_POST['ID_ISO']),
									
								];
					$save = $this->m_pertanyaan->save($eldata);
				}

			}
			
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