<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jadwal extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Pdf');
		$this->load->model('perencanaan/M_spa', 'm_spa');
		$this->load->model('perencanaan/M_tim_audit', 'm_tim_audit');
		$this->load->model('perencanaan/M_jadwal', 'm_jadwal');
		$this->is_login();
		if(!$this->is_auditor()) $this->load->view('/errors/html/err_401');
	}

	public function jadwal_audit()
	{
		$data['list_status'] 	= $this->master_act->status();
		// print_r($data);
		// die();
		$data['menu']           = 'perencanaan';
		$data['sub_menu']       = 'jadwal_audit';
		$data['title']          = 'List Jadwal Audit ISO';
        $data['content']        = 'content/jadwal/jadwal_audit';
		$data['jadwal_list'] 	= $this->m_jadwal->jadwal_list();
        $this->show($data);
	}
	function jsonJadwalList() 
	{
        header('Content-Type: application/json');
        echo json_encode($this->m_jadwal->jadwal_list());
	}

	public function create()
	{
		
		$data['list_user'] 			= $this->master_act->user(['U.STATUS' => 1]);
		
		
		
		$data_auditor 				= $this->master_act->auditor(['R.ID_ROLE' => 1]);
		$data_lead_auditor			= $this->master_act->auditor(['R.ID_ROLE' => 5]);
		$data['data_auditor'] 		= $data_auditor;
		$data['data_lead_auditor'] 	= $data_lead_auditor;

		$data['list_jenis_audit'] 	= $this->master_act->jenis_audit();
		$data['list_divisi'] 		= $this->master_act->divisi();
		$data['menu']           	= 'perencanaan';
		$data['sub_menu']      		= 'jadwal_audit';
		
		$data['title']          	= 'Create Jadwal Audit';
        $data['content']        	= 'content/jadwal/create';
		// print_r($data_lead_auditor);
		// die();
        $this->show($data);
	}

    public function index()
	{
		if (isset($this->session->login)) {
			redirect(base_url('home'));
		}
		$data = array(
            'widget' => $this->recaptcha->getWidget(),
            'script' => $this->recaptcha->getScriptTag()
        );
		$this->load->view('/content/v_home', $data);
	}


	public function simpan()
	{
		$request = $this->input->post();
		// $id_apm = $request['ID_APM'];
		// print_r($request);
		// die();
		$data = [
				    'ID_AUDITOR'           			=> is_empty_return_null($request['ID_AUDITOR']),
				    'ID_LEAD_AUDITOR'          		=> is_empty_return_null($request['ID_LEAD_AUDITOR']),
				    'WAKTU_AUDIT' 					=> is_empty_return_null($request['WAKTU_AUDIT']),
				    'ID_REG'    					=> is_empty_return_null($request['ID_REG']),
		];
		$save = $this->m_jadwal->save($data);
		if($save==true){
			$success_message = 'Data berhasil disimpan.';
			echo base_url('perencanaan/apm/kotak_keluar');
		}
		else{
			
			$this->session->set_flashdata('error', $error_message);
		}
		
		
		// if (empty($id_apm)) {
		// 	$data['ID_SPA'] = $request['ID_SPA'];
		// 	$save = $this->m_apm->save($data);
		// 	if ($save) {
		// 		$success_message = 'Data berhasil disimpan.';
		// 		$this->session->set_flashdata('success', $success_message);
		// 		echo base_url('perencanaan/apm/kotak_keluar');
		// 	}else {
		// 		$error_message = 'Nomor sudah terpakai.';
		// 		$this->session->set_flashdata('error', $error_message);
		// 		echo base_url('perencanaan/apm/create');
		// 	}
		// }else {
		// 	$this->m_apm->send_update($data, $id_apm);
		// 	$success_message = 'Data berhasil dikirim.';
		// 	$this->session->set_flashdata('success', $success_message);
		// 	echo base_url('perencanaan/apm/kotak_keluar');
		// }
	}
}