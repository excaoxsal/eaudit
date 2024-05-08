<?php
defined('BASEPATH') or exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Iso extends MY_Controller
{


    public function __construct()
	{
		parent::__construct();
		$this->load->library('upload');
		$this->load->model('perencanaan/M_tim_audit', 'm_tim_audit');
		$this->load->model('perencanaan/M_jadwal', 'm_jadwal');
        $this->load->model('aia/M_iso','m_iso');
		$this->is_login();
		if(!$this->is_auditor()) $this->load->view('/errors/html/err_401');
	}
    function jsonIsoList() 
	{
        header('Content-Type: application/json');
        echo json_encode($this->m_iso->get_iso());
	}


    public function index(){
        $data['list_status'] 	= $this->master_act->status();
		$dataiso = $this->m_iso->get_iso();
		$data['menu']           = 'perencanaan';
		$data['sub_menu']       = 'm_iso';
		$data['title']          = 'Master Pertanyaan';
        $data['content']        = 'content/aia/v_m_iso';
		$data['id_user']		= $this->session->ID_USER;
		$id_user = $data['id_user'];
		$data['jadwal_list'] 	= $this->m_jadwal->jadwal_list($id_user);
        $data['data_iso'] = $dataiso;
		// var_dump($dataiso);
		// die();
        $this->show($data);
    }

	public function proses_upload() {
		
		$nipp                       = $this->input->post('nipp');
		$config['file_name']        = "asd";
		
		$config['upload_path'] = './storage/upload/lampiran/aia'; // Lokasi penyimpanan file
		$config['allowed_types'] = 'xls|xlsx'; // Jenis file yang diizinkan
		$config['max_size'] = 2048; // Ukuran maksimum file (dalam KB)
		
		$this->load->library('upload', $config);
	
		if (!$this->upload->do_upload('LAMPIRAN')) {
			// Jika upload gagal, tampilkan pesan error
			$error = $this->upload->display_errors();
			echo $error;
		} else {
			// Jika upload berhasil, baca file Excel
			
			$file_data = $this->upload->data();
			
			$file_path = './storage/upload/lampiran/aia' . $file_data['file_name'];
	
			// Load library PHPExcel
			$this->load->library('PHPExcel');
			$excel_reader = PHPExcel_IOFactory::createReaderForFile($file_path);
			$excel_reader->setReadDataOnly(true);
			$excel_obj = $excel_reader->load($file_path);
			$worksheet = $excel_obj->getActiveSheet();
			
			// Lakukan sesuatu dengan data dari file Excel
			// Contoh: Baca data dari setiap sel pada worksheet
			foreach ($worksheet->getRowIterator() as $row) {
				$cellIterator = $row->getCellIterator();
				$cellIterator->setIterateOnlyExistingCells(false);
				foreach ($cellIterator as $cell) {
					$cell_value = $cell->getValue();
					echo $cell_value . ' ';
				}
				echo '<br>';
			}
			
	
			// Hapus file setelah selesai membaca
			unlink($file_path);
		}
	}


}