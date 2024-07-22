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
		$data['menu']           = 'temuan-aia';
        $data['title']          = 'Temuan';
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

	public function commitment() {
		$data_update = 
			[
			'INVESTIGASI'           			=> is_empty_return_null($request['INVESTIGASI']),
			'PERBAIKAN'           				=> is_empty_return_null($request['PERBAIKAN']),
			'KOREKTIF'           				=> is_empty_return_null($request['KOREKTIF']),
			'TANGGAL'           				=> is_empty_return_null($request['TANGGAL']),
			'FILE'           					=> is_empty_return_null($file_path)
			];
		var_dump($data_update);die;
		$this->db->set('TANGGAL', $data_update['TANGGAL'][0]);
		$this->db->set('KOREKTIF', $data_update['KOREKTIF'][0]);
		$this->db->set('PERBAIKAN', $data_update['PERBAIKAN'][0]);
		$this->db->set('INVESTIGASI', $data_update['INVESTIGASI'][0]);
		$this->db->where('ID_RESPONSE', $request['ID_HEADER']);
		$update = $this->db->update('TEMUAN_DETAIL');
		if ($update){
			$success_message = 'Data Respon Berhasil Disimpan.';
			$this->session->set_flashdata('success', $success_message);
			redirect(base_url('aia/temuan/detail/'.$request['ID_HEADER']));
		}
		else{
			$error_message = 'Silahkan coba kembali';
			$this->session->set_flashdata('error', $error_message);
			redirect(base_url('aia/temuan/detail/'.$request['ID_HEADER']));
		}
		
	}

}