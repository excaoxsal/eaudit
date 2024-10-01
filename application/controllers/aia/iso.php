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
        $this->load->model('aia/M_Pertanyaan','m_pertanyaan');
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
		
        $this->show($data);
    }

	public function show_iso($iso){
		
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
		// var_dump($datapertanyaan[0]['NOMOR_ISO']);die;
		
		
        $this->show($data);
	}

	public function getdataiso($id){
		$query = $this->db->select('ID_ISO,NOMOR_ISO')->from('TM_ISO')
                        ->where('ID_ISO', $id)->get()->row();
		// var_dump($query);die;
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
				 // Pisahkan data berdasarkan koma
				$kode_klausul = $worksheet->getCellByColumnAndRow(0, $row+2)->getValue();
				$lv1 = $worksheet->getCellByColumnAndRow(1, $row+2)->getValue();
				$lv2 = $worksheet->getCellByColumnAndRow(2, $row+2)->getValue();
				$lv3 = $worksheet->getCellByColumnAndRow(3, $row+2)->getValue();
				$lv4 = $worksheet->getCellByColumnAndRow(4, $row+2)->getValue();
				$auditee = $worksheet->getCellByColumnAndRow(5, $row+2)->getValue();
				$pertanyaan = $worksheet->getCellByColumnAndRow(6, $row+2)->getValue();
				// var_dump($data);die;
				
				if($kode_klausul!=""&&$auditee!=""){
					$data_items = explode(',', $auditee);
					$data_divisi="";
					foreach ($data_items as $item){
						if($data_divisi!=""){
						$data_divisi.=",";
						}
						if (stripos(trim($item), "alldiv") !== false){
						

							$query_all_divisi = $this->db->select('KODE')->from('TM_DIVISI')->where('IS_DIVISI','N')->where('IS_CABANG','N')->get();
							$result_divisi = $query_all_divisi->result_array();
							
							
							for($i=0;$i<sizeof($result_divisi);$i++){
								
								
								$data_divisi .=$result_divisi[$i]['KODE'];
								if ($i < sizeof($result_divisi)-1){
									$data_divisi.=",";	
								}
								
							}
							
							
							
						}
						else if (stripos($item, "allbm") !== false){
							$query_all_divisi = $this->db->select('KODE')->from('TM_DIVISI')->where('IS_DIVISI','N')->where('IS_CABANG','Y')->get();
							$result_divisi = $query_all_divisi->result_array();
							
							
							for($i=0;$i<sizeof($result_divisi);$i++){
								
								
								$data_divisi .=$result_divisi[$i]['KODE'];
								if ($i < sizeof($result_divisi)-1){
									$data_divisi.=",";	
								}
							}
							
							
						}else{
							$query_all_divisi = $this->db->select('KODE')->from('TM_DIVISI')->where('KODE_PARENT',$item)->get();
							$result_divisi = $query_all_divisi->result_array();
							// var_dump($result_divisi);die;
							
							for($i=0;$i<sizeof($result_divisi);$i++){
								
								
								$data_divisi .=$result_divisi[$i]['KODE'];
								if ($i < sizeof($result_divisi)-1){
									$data_divisi.=",";	
								}
							}
							// var_dump($data_divisi);die;
							
							
						}
					}
					$data_auditee = $data_divisi;
					$eldata = [
									'KODE_KLAUSUL'	=> is_empty_return_null($kode_klausul),
									'LV1'			=> is_empty_return_null($lv1),
									'LV2'			=> is_empty_return_null($lv2),
									'LV3'			=> is_empty_return_null($lv3),
									'LV4'			=> is_empty_return_null($lv4),
									'AUDITEE'		=> is_empty_return_null($data_auditee),
									'PERTANYAAN'	=> is_empty_return_null($pertanyaan),
									'ID_ISO'=>is_empty_return_null($_POST['ID_ISO']),
									
									
								];
					// var_dump($eldata);die;
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

	public function insertPertanyaan() {
		
		$eldata = [
						'KODE_KLAUSUL'	=> is_empty_return_null($_POST['KLAUSUL']),
						'LV1'			=> is_empty_return_null($_POST['LV1']),
						'LV2'			=> is_empty_return_null($_POST['LV2']),
						'LV3'			=> is_empty_return_null($_POST['LV3']),
						'LV4'			=> is_empty_return_null($_POST['LV4']),
						'AUDITEE'		=> is_empty_return_null($_POST['AUDITEE']),
						'PERTANYAAN'	=> is_empty_return_null($_POST['PERTANYAAN']),
						'ID_ISO'=>is_empty_return_null($_POST['ID_ISO'])		
						
					];
		// var_dump($eldata);die;
		$save = $this->m_pertanyaan->save($eldata);
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

	public function getdatapertanyaan($id) {
		$query = $this->db->select('*')->from('TM_PERTANYAAN')->where('ID_MASTER_PERTANYAAN', $id)->get()->row();
        echo json_encode($query);
	}

	public function updatePertanyaan() {
		// var_dump($_POST);die;
		$this->db->set('KODE_KLAUSUL', $_POST['KLAUSUL_EDIT']);
		$this->db->set('LV1', $_POST['LV1_EDIT']);
		$this->db->set('LV2', $_POST['LV2_EDIT']);
		$this->db->set('LV3', $_POST['LV3_EDIT']);
		$this->db->set('LV4', $_POST['LV4_EDIT']);
		$this->db->set('AUDITEE', $_POST['AUDITEE_EDIT']);
		$this->db->set('PERTANYAAN', $_POST['PERTANYAAN_EDIT']);
		$this->db->set('ID_ISO', $_POST['ID_ISO']);
		$this->db->where('ID_MASTER_PERTANYAAN', $_POST['ID_MASTER_PERTANYAAN']);
		$elupdate = $this->db->update('TM_PERTANYAAN');

		if ($elupdate) {
			$success_message = 'Pertanyaan Berhasil Diperbarui';
	        $this->session->set_flashdata('success', $success_message);
		}
		else{
			$error_message = 'Pertanyaan Gagal Diperbarui';
	        $this->session->set_flashdata('error', $error_message);
		}
		redirect(base_url('aia/Iso/show_iso/'.$_POST['ID_ISO']));
		
	}
}