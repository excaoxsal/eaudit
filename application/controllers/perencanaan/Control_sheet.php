<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Control_sheet extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('perencanaan/M_tim_audit', 'm_tim_audit');
		$this->load->model('perencanaan/M_control_sheet', 'm_control_sheet');
		$this->load->library('Pdf');
		$this->is_login();
		if(!$this->is_auditor()) $this->load->view('/errors/html/err_401');
	}

	public function index()
	{
		$data['menu']           = 'perencanaan';
		$data['sub_menu']       = 'control_sheet';
		$data['title']          = 'Control Sheet';
        $data['content']        = 'content/perencanaan/control_sheet/v_control_sheet';
        $this->show($data);
	}

	function control_sheet_json() 
	{
        header('Content-Type: application/json');
        echo json_encode($this->m_control_sheet->get_control_sheet());
	}

	function spa_json() 
	{
        header('Content-Type: application/json');
        if($this->input->server('REQUEST_METHOD') === 'POST') echo json_encode($this->m_control_sheet->spa());
    }

	public function cetak_preview($id)
	{
		$data_control_sheet['title'] 	= 'Surat Perintah';
		// $data_control_sheet['control_sheet']				= $this->m_control_sheet->control_sheet_detail($id);
		// $data_control_sheet['tim_audit'] = $this->m_control_sheet->get_tim($id);
		// $data_control_sheet['author'] 	= $this->m_user->user($this->session->ID_USER)[0];
		$data_control_sheet['data_cs'] 	= $this->m_control_sheet->get_control_sheet($id);
		$this->load->view('/content/cetak/control_sheet', $data_control_sheet);
	}

	function create()
	{
		$id = $this->input->get('id');
		$id = base64_decode($id);
		$data['data_cs'] 	= $this->m_control_sheet->get_control_sheet($id);
		$tim_audit 			= $this->m_tim_audit->get_tim_audit($data['data_cs']->ID_SPA, 'SPA');
		foreach ($tim_audit as $key => $item) {
			if($item['JABATAN'] == 1) 
				$data['ketua_tim'] 	= $item['NAMA'];
		}
		// print_r($data['tim_audit']);die();
		$data['list_divisi'] 	= $this->master_act->divisi();
		$data['menu']       	= 'perencanaan';
		$data['sub_menu']   	= 'control_sheet';
        $data['title']          = 'Update Control Sheet';
        $data['content']        = 'content/perencanaan/control_sheet/v_create_control_sheet';
        $this->show($data);
	}

	function update()
	{
		$id = $this->input->get('id');
		$id = base64_decode($id);
		$request = $this->input->post();
		$data = [
			'PIC_APM_DISUSUN' 		=> is_empty_return_null($request['PIC_APM_DISUSUN']),
			'PIC_DIDISTRIBUSI' 		=> is_empty_return_null($request['PIC_DIDISTRIBUSI']),
			'PIC_DISETUJUI' 		=> is_empty_return_null($request['PIC_DISETUJUI']),
			'PIC_ENTRANCE_DISUSUN' 	=> is_empty_return_null($request['PIC_ENTRANCE_DISUSUN']),
			'PIC_RCM_DISUSUN' 		=> is_empty_return_null($request['PIC_RCM_DISUSUN']),
			'TGL_APM_DISUSUN' 		=> is_empty_return_null($request['TGL_APM_DISUSUN']),
			'TGL_DIDISTRIBUSI' 		=> is_empty_return_null($request['TGL_DIDISTRIBUSI']),
			'TGL_DISETUJUI' 		=> is_empty_return_null($request['TGL_DISETUJUI']),
			'TGL_ENTRANCE_DISUSUN' 	=> is_empty_return_null($request['TGL_ENTRANCE_DISUSUN']),
			'TGL_RCM_DISUSUN' 		=> is_empty_return_null($request['TGL_RCM_DISUSUN']),
			'NAMA_AUDIT' 			=> is_empty_return_null($request['NAMA_AUDIT']),
			'AUDITEE' 				=> is_empty_return_null($request['AUDITEE']),
			'TGL_PERIODE_MULAI' 	=> is_empty_return_null($request['TGL_PERIODE_MULAI']),
			'TGL_PERIODE_SELESAI' 	=> is_empty_return_null($request['TGL_PERIODE_SELESAI']),
			'UPDATED_BY' 			=> $this->session->ID_USER,
			'UPDATED_AT' 			=> date('Y-m-d H:i:s')
		];
		// print_r($data);die();
		$this->m_control_sheet->update($data, $id);
		$success_message = 'Data berhasil diupdate.';
		$this->session->set_flashdata('success', $success_message);
		echo base_url('perencanaan/control_sheet/');
	}

}
