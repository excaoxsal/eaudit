<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Response_auditee extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Pdf');
		$this->load->model('aia/M_res_auditee', 'm_res_au');
		$this->load->model('aia/M_jadwal', 'm_jadwal');
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
		// var_dump($this->jsonResponAuditee());
		// die;
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

		// var_dump($this->m_res_au->get_response_auditee_detail($datas));
		// // var_dump($elcoding_parts);
		// die;
		$this->show($data);
	}

	public function chatbox($data){
		$request = $this->input->post();
		
		$data_update = [
			'KOMENTAR_1'           			=> is_empty_return_null($request['MSG_AUDITOR']),
			'KOMENTAR_2'          			=> is_empty_return_null($request['MSG_AUDITEE']),
		];
		
		$elcoding_parts = explode('00', $data);
        $divisi = $elcoding_parts[0];
        $id_iso = $elcoding_parts[1];
        $id_jadwal = $elcoding_parts[2];
        $this->db->set('KOMENTAR_1', $data_update['KOMENTAR_1'][0]);
        $this->db->set('KOMENTAR_2', $data_update['KOMENTAR_2'][0]);
        $this->db->where('DIVISI', $divisi);
        $this->db->where('ID_ISO', $id_iso);
        $this->db->where('ID_JADWAL', $id_jadwal);
        $this->db->update('RESPONSE_AUDITEE_D');
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
		$results = $query->result_array();
		$result_divisi = $query_divisi->result_array();
		
		// var_dump($result_divisi['0']['KODE']);
		// die;
		foreach ($results as $row) {
			$data_items = explode(',', $row['AUDITEE']); // Pisahkan data berdasarkan koma
			foreach ($data_items as $item) {
				$query_bersih_h = $this->db->where('DIVISI =', $result_divisi['0']['KODE'])->delete('RESPONSE_AUDITEE_D');
				$query_bersih_d = $this->db->where('DIVISI =', $result_divisi['0']['KODE'])->delete('RESPONSE_AUDITEE_H');
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
		
		if (!empty($data_to_insert)) {
			if(empty($resultq)){
				$this->db->insert_batch('RESPONSE_AUDITEE_D', $data_to_insert);
				$this->m_jadwal->update_status($data);
				
			}
		}
		$this->session->set_flashdata('success', $success_message);
		redirect($_SERVER['HTTP_REFERER']);
		// var_dump($inserteldb);
		// die;
	}

	

	

}
