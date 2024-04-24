<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pka extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Pdf');
		$this->load->model('perencanaan/M_pka', 'm_pka');
		$this->load->model('perencanaan/M_spa', 'm_spa');
		$this->load->model('perencanaan/M_tim_audit', 'm_tim_audit');
		$this->is_login();
		if(!$this->is_auditor()) $this->load->view('/errors/html/err_401');
	}

	public function kotak_keluar()
	{
		$data['list_status'] 	= $this->master_act->status();
		$data['menu']           = 'perencanaan';
		$data['sub_menu']       = 'kotak_keluar';
		$data['sub_menu_2']     = 'kotak_keluar_pka';
		$data['title']          = 'Program Kerja Audit';
        $data['content']        = 'content/perencanaan/pka/v_kotak_keluar_pka';
        $this->show($data);
	}

	public function kotak_masuk()
	{
		$data['list_status'] 	= $this->master_act->status();
		$data['menu']           = 'perencanaan';
		$data['sub_menu']       = 'kotak_masuk';
		$data['sub_menu_2']     = 'kotak_masuk_pka';
        $data['title']          = 'Program Kerja Audit';
        $data['content']        = 'content/perencanaan/pka/v_kotak_masuk_pka';
        $this->show($data);
	}

	public function jsonKotakKeluarPka() 
	{
        header('Content-Type: application/json');
        if($this->input->server('REQUEST_METHOD') === 'POST') echo json_encode($this->m_pka->get_pka($this->session->ID_USER));
	}

	public function jsonKotakMasukPka() 
	{
        header('Content-Type: application/json');
        if($this->input->server('REQUEST_METHOD') === 'POST') echo json_encode($this->m_pka->kotak_masuk($this->session->ID_USER));
	}
	
	public function create($id_pka = null)
	{
		if (!empty($id_pka) || $id_pka != null) {
			$data_pka				= $this->m_pka->pka_detail($id_pka);
			$data_spa				= $this->m_pka->get_spa($id_pka);
			$data['data_pka'] 		= $data_pka;
			$data['disabled_edit'] 	= 'disabled';
			$data['nomor_surat'] 	= $data_spa->NOMOR_SURAT;
			if ($data_pka->ID_STATUS != 1 && $data_pka->ID_STATUS != 4){
				$data['disabled'] 	= 'disabled';
				$data['enable'] 	= 0;
				$data['enable_css'] = 'background-color:#F3F6F9;';
			}
		}
		$data['data_log'] 		= $this->main_act->log_by_id_perencanaan($id_pka, 'PKA');
		$data['list_user'] 		= $this->master_act->user();
		$data['list_divisi'] 	= $this->master_act->divisi();
		$data['nomor_spa']  	= $this->m_spa->spa_list();
		$data['menu']           = 'perencanaan';
		$data['sub_menu']      	= 'kotak_keluar';
		$data['sub_menu_2']     = 'kotak_keluar_pka';
        $data['title']          = 'Create PKA';
        $data['content']        = 'content/perencanaan/pka/v_create_pka';
        $this->show($data);
	}

	public function review($id_pka = null)
	{
		if (!empty($id_pka) || $id_pka != null) {
			$data_pka	= $this->m_pka->pka_detail($id_pka);
			$data_pemeriksa = $this->m_pka->get_pemeriksa($id_pka);
			// print_r($data_pemeriksa[1]);die();
			$data_spa	= $this->m_pka->get_spa($id_pka);
			$data['data_pka'] = $data_pka;
			$data['disabled_edit'] = 'disabled';
			$data['nomor_surat'] = $data_spa->NOMOR_SURAT;
			$data['status_pemeriksa'] = $data_pemeriksa[1]['STATUS'];
			if ($data_pemeriksa[1]['STATUS'] == '2'){
				$data['disabled'] 	= 'disabled';
				$data['enable'] 		= 0;
				$data['enable_css'] = 'background-color:#F3F6F9;';
			}
			
		}
		$data['data_log'] 			= $this->main_act->log_by_id_perencanaan($id_pka, 'PKA');
		$data['list_user'] 			= $this->master_act->user();
		$data['list_divisi'] 		= $this->master_act->divisi();
		$data['menu']           	= 'perencanaan';
		$data['sub_menu']      		= 'kotak_masuk';
		$data['sub_menu_2']     	= 'kotak_masuk_pka';
        $data['title']          = 'Review PKA';
        $data['content']        = 'content/perencanaan/pka/v_create_pka';
        $this->show($data);
	}

	public function simpan()
	{
		$request = $this->input->post();
		$id_pka = $request['ID_PKA'];
		$data = [
			'PENDAHULUAN' 				=> $request['PENDAHULUAN'],
			'PENDAHULUAN_DILAKSANAKAN' 	=> $request['PENDAHULUAN_DILAKSANAKAN'],
			'PENDAHULUAN_WAKTU' 		=> $request['PENDAHULUAN_WAKTU'],
			'SASARAN_AUDIT' 			=> $request['SASARAN_AUDIT'],
			'SASARAN_DILAKSANAKAN' 		=> $request['SASARAN_DILAKSANAKAN'],
			'SASARAN_WAKTU' 			=> $request['SASARAN_WAKTU'],
			'TUJUAN_AUDIT' 				=> $request['TUJUAN_AUDIT'],
			'TUJUAN_DILAKSANAKAN' 		=> $request['TUJUAN_DILAKSANAKAN'],
			'TUJUAN_WAKTU' 				=> $request['TUJUAN_WAKTU'],
			'INSTRUKSI_AUDIT' 			=> $request['INSTRUKSI_AUDIT'],
			'INSTRUKSI_DILAKSANAKAN' 	=> $request['INSTRUKSI_DILAKSANAKAN'],
			'INSTRUKSI_WAKTU' 			=> $request['INSTRUKSI_WAKTU'],
			'ID_STATUS' 				=> $request['ACTION'],
			'ID_PEMBUAT' 				=> $this->session->ID_USER,
			'TANGGAL' 					=> $request['TANGGAL'],
			'TEMPAT' 					=> $request['TEMPAT'],
		];

		if (empty($id_pka)) {
			$data['ID_SPA'] = $request['ID_SPA'];
			$data['NOMOR_PKA'] = $request['NOMOR_PKA'];
			$save = $this->m_pka->save($data);
			if ($save) {
				$success_message = 'Data berhasil disimpan.';
				$this->session->set_flashdata('success', $success_message);
				echo base_url('perencanaan/pka/kotak_keluar');
			}else {
				$error_message = 'Nomor sudah terpakai.';
				$this->session->set_flashdata('error', $error_message);
				echo base_url('perencanaan/pka/create');
			}
		}else {
			$this->m_pka->send_update($data, $id_pka);
			$success_message = 'Data berhasil dikirim.';
			$this->session->set_flashdata('success', $success_message);
			echo base_url('perencanaan/pka/kotak_keluar');
		}
	}

	public function cetak_preview($id)
	{
		$data_pka['title'] 				= '';
		// $data_pka['author'] 			= $this->m_user->user($this->session->ID_USER)[0];
		$data_pka['data_pka']			= $this->m_pka->pka_detail($id);
		$data_pka['pka']				= $this->m_pka->get_pka($this->session->ID_USER);
		$data_pka['tim_audit'] 			= $this->m_tim_audit->get_tim_audit($data_pka['data_pka']->ID_SPA, 'SPA');
		$data_pemeriksa 				= $this->m_pka->get_pemeriksa($id);
		$tanggal_atasan1 				= tgl_indo($data_pemeriksa[0]['TANGGAL']);
		$tanggal_atasan2 				= tgl_indo($data_pemeriksa[1]['TANGGAL']);
		$data_pka['tanggal_atasan1'] 	= $tanggal_atasan1;
		$data_pka['tanggal_atasan2'] 	= $tanggal_atasan2;
		$data_pka['status1'] 			= $data_pemeriksa[0]['STATUS'];
		$data_pka['status2'] 			= $data_pemeriksa[1]['STATUS'];
		$data_pka['ttd1'] 				= $data_pemeriksa[0]['TANDA_TANGAN'];
		$data_pka['ttd2'] 				= $data_pemeriksa[1]['TANDA_TANGAN'];
		// print_r($data_pka['data_pka']);die();
		$this->load->view('/content/cetak/pka', $data_pka);
	}

	public function approve_reject($id_pka)
	{
		$request = $this->input->post();
		$data = [
			'PENDAHULUAN' 				=> $request['PENDAHULUAN'],
			'PENDAHULUAN_DILAKSANAKAN' 	=> $request['PENDAHULUAN_DILAKSANAKAN'],
			'PENDAHULUAN_WAKTU' 		=> $request['PENDAHULUAN_WAKTU'],
			'SASARAN_AUDIT' 			=> $request['SASARAN_AUDIT'],
			'SASARAN_DILAKSANAKAN' 		=> $request['SASARAN_DILAKSANAKAN'],
			'SASARAN_WAKTU' 			=> $request['SASARAN_WAKTU'],
			'TUJUAN_AUDIT' 				=> $request['TUJUAN_AUDIT'],
			'TUJUAN_DILAKSANAKAN' 		=> $request['TUJUAN_DILAKSANAKAN'],
			'TUJUAN_WAKTU' 				=> $request['TUJUAN_WAKTU'],
			'INSTRUKSI_AUDIT' 			=> $request['INSTRUKSI_AUDIT'],
			'INSTRUKSI_DILAKSANAKAN' 	=> $request['INSTRUKSI_DILAKSANAKAN'],
			'INSTRUKSI_WAKTU' 			=> $request['INSTRUKSI_WAKTU'],
			'ID_STATUS' 				=> $request['ACTION'],
		];

		$data_pemeriksa = [
			'KOMENTAR' 	=> $request['KOMENTAR'],
			'ID_USER' 	=> $this->session->ID_USER,
		];

		$this->m_pka->approval($data, $data_pemeriksa, $id_pka);
		
		$aksi = $data['ID_STATUS'] == 3 ? 'diapprove' : 'direject';
		$komentar = (!empty( $request['KOMENTAR'])) ? 'dengan Komentar : '.strip_tags( $request['KOMENTAR']) : '';
		$data_user = $this->m_user->user($this->session->ID_USER)[0];
		$log = $data_user['NIPP'].'/'.$data_user['NAMA'].' - '.' Surat '.$aksi.' '.$komentar;
		$this->main_act->save_perencanaan($id_pka, 'PKA', $log);
		$success_message = 'Data berhasil '.$aksi;
		$this->session->set_flashdata('success', $success_message);

		echo base_url('perencanaan/pka/kotak_masuk');

	}
}
