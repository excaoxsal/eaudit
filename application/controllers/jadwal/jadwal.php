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
		$this->is_login();
		if(!$this->is_auditor()) $this->load->view('/errors/html/err_401');
	}

	public function jadwal_audit()
	{
		$data['list_status'] 	= $this->master_act->status();
		$data['menu']           = 'perencanaan';
		$data['sub_menu']       = 'jadwal_audit';
		$data['title']          = 'List Jadwal Audit ISO';
        $data['content']        = 'content/jadwal/jadwal_audit';
        $this->show($data);
	}

	public function create()
	{
		$id_spa = $this->input->get('id');
		$id_spa = base64_decode($id_spa);
		if (!empty($id_spa) || $id_spa != null) {
			$spa_detail	= $this->m_spa->spa_detail($id_spa);
			if ($spa_detail->ID_STATUS != 1 && $spa_detail->ID_STATUS != 4) {
				$data['disabled'] 	= 'disabled';
				$data['enable'] 	= 0;
				$data['enable_css'] = 'background-color:#F3F6F9;';
			}
			$data['peserta'] 		= $this->m_spa->get_dasar($id_spa);
			$data['perintah'] 		= $this->m_spa->get_perintah($id_spa);
			$data['tembusan'] 		= $this->m_spa->get_tembusan($id_spa);
			$data['spa_detail'] 	= $spa_detail; 
			$data['data_log'] 		= $this->main_act->log_by_id_perencanaan($id_spa, 'SPA');
			$data['tim_audit'] 		= $this->m_tim_audit->get_tim_audit($id_spa, 'SPA');
		}
		$data['list_user'] 			= $this->master_act->user(['U.STATUS' => 1]);
		$data['list_jenis_audit'] 	= $this->master_act->jenis_audit();
		$data['list_divisi'] 		= $this->master_act->divisi();
		$data['menu']           	= 'perencanaan';
		$data['sub_menu']      		= 'jadwal_audit';
		$data['sub_menu_2']     	= 'kotak_keluar_spa';
		$data['title']          	= 'Create Jadwal List ISO';
        $data['content']        	= 'content/jadwal/create';
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
}