<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Response_auditee extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Pdf');
		$this->load->model('aia/M_res_auditee', 'm_res_au');
		$this->is_login();
		if(!$this->is_auditor()) $this->load->view('/errors/html/err_401');
	}

	public function index()
	{
		$data['list_status'] 	= $this->master_act->status();
		$data['list_divisi'] 	= $this->m_res_au->get_divisi();
		$data['menu']           = 'response_auditee';
        $data['title']          = 'Respon Auditee';
        $data['content']        = 'content/aia/v_response_auditee_header';
		// var_dump($this->m_res_au->get_divisi());
		// die;
        $this->show($data);
	}

	public function detail($data){
		$data['list_divisi'] 	= $this->m_res_au->get_divisi();
		$data['menu']           = 'response_auditee';
        $data['title']          = 'Respon Auditee';
        $data['content']        = 'content/aia/v_response_auditee_detail';
	}

	function jsonResponAuditee() 
	{
        header('Content-Type: application/json');
		// var_dump($this->m_res_au->get_response_auditee());
        echo json_encode($this->m_res_au->get_response_auditee_detail());
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
		$results = $query->result_array();
		$result_divisi = $query_divisi->result_array();
		
		// var_dump($result_divisi['0']['KODE']);
		// die;
		foreach ($results as $row) {
			$data_items = explode(',', $row['AUDITEE']); // Pisahkan data berdasarkan koma
			foreach ($data_items as $item) {
				if(trim($item)==$result_divisi['0']['KODE']){
					$data_to_insert[] = [
						'DIVISI' => trim($item),
						'ID_ISO' => $row['ID_ISO'],
						'ID_MASTER_PERTANYAAN' => $row['ID_MASTER_PERTANYAAN'],
						'ID_JADWAL' => $data,
						
					];
					$query_header = $this->db->select('ID_JADWAL')->from('RESPONSE_AUDITEE_H')->where('DIVISI',trim($item))->get();
					$result_header = $query_header->result_array();
					$insert_header = [
						'DIVISI' => trim($item),
						'ID_ISO' => $row['ID_ISO'],
						'ID_JADWAL' => $data,
					]; 
					// Bersihkan dan siapkan data untuk dimasukkan
				}	
			}
		}
		if (!empty($insert_header)) {
			if(empty($result_header)){
				$this->db->insert('RESPONSE_AUDITEE_H', $insert_header);
			}
		}
		// var_dump($data_to_insert);
		// 	die;
		$querys = $this->db->select('ID_JADWAL')->from('RESPONSE_AUDITEE_D')->where('ID_JADWAL',$data)->get();
		$resultq = $querys->result_array();
		// var_dump($resultq);
		// die;
		$update_data = array(
            'STATUS' => "1"
        );
		if (!empty($data_to_insert)) {
			if(empty($resultq)){
				$this->db->insert_batch('RESPONSE_AUDITEE_D', $data_to_insert);
				$this->db->update('WAKTU_AUDIT',$update_data)->where('ID_JADWAL',$data);
			}
		}
		$this->session->set_flashdata('success', $success_message);
		redirect($_SERVER['HTTP_REFERER']);
		// var_dump($inserteldb);
		// die;
	}

	

	

}
