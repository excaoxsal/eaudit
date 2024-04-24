<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Apm extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Pdf');
		$this->load->model('perencanaan/M_apm', 'm_apm');
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
		$data['sub_menu_2']     = 'kotak_keluar_apm';
		$data['title']          = 'Audit Planning Memorandum';
        $data['content']        = 'content/perencanaan/apm/v_kotak_keluar_apm';
        $this->show($data);
	}

	public function kotak_masuk()
	{
		$data['list_status'] 	= $this->master_act->status();
		$data['menu']           = 'perencanaan';
		$data['sub_menu']       = 'kotak_masuk';
		$data['sub_menu_2']     = 'kotak_masuk_apm';
        $data['title']          = 'Audit Planning Memorandum';
        $data['content']        = 'content/perencanaan/apm/v_kotak_masuk_apm';
        $this->show($data);
	}

	function jsonKotakKeluarApm() 
	{
        header('Content-Type: application/json');
        echo json_encode($this->m_apm->get_apm($this->session->ID_USER));
	}

	function jsonKotakMasukApm() 
	{
        header('Content-Type: application/json');
        echo json_encode($this->m_apm->kotak_masuk($this->session->ID_USER));
	}
	
	public function create($id_apm = null)
	{
		if (!empty($id_apm) || $id_apm != null) {
			$data_apm				= $this->m_apm->apm_detail($id_apm);
			$data_spa				= $this->m_apm->get_spa($id_apm);
			$data['data_apm'] 		= $data_apm;
			$data['disabled_edit'] 	= 'disabled';
			$data['tim_audit'] 		= $this->m_tim_audit->get_tim_audit($data_apm->ID_SPA, 'SPA');
			// print_r($data['tim_audit']);die();
			$data['nomor_surat'] 	= $data_spa->NOMOR_SURAT;
			if ($data_apm->ID_STATUS != 1 && $data_apm->ID_STATUS != 4){
				$data['disabled'] 	= 'disabled';
				$data['enable'] 	= 0;
				$data['enable_css'] = 'background-color:#F3F6F9;';
			}
		}
		$data['data_log'] 		= $this->main_act->log_by_id_perencanaan($id_apm, 'APM');
		$data['list_user'] 		= $this->master_act->user();
		$data['list_divisi'] 	= $this->master_act->divisi();
		$data['nomor_spa']  	= $this->m_spa->spa_list();
		$data['menu']           = 'perencanaan';
		$data['sub_menu']      	= 'kotak_keluar';
		$data['sub_menu_2']     = 'kotak_keluar_apm';
        $data['title']          = 'Create APM';
        $data['content']        = 'content/perencanaan/apm/v_create_apm';
        $this->show($data);
	}

	public function review($id_apm = null)
	{
		if (!empty($id_apm) || $id_apm != null) {
			$data_apm				= $this->m_apm->apm_detail($id_apm);
			$data_spa				= $this->m_apm->get_spa($id_apm);
			$data['tim_audit'] 		= $this->m_tim_audit->get_tim_audit($data_apm->ID_SPA, 'SPA');
			$data['data_apm'] 		= $data_apm;
			$data['disabled_edit'] 	= 'disabled';
			$data['nomor_surat'] 	= $data_spa->NOMOR_SURAT;
			if ($_GET['sts-approver'] != '1'){
				$data['disabled'] 	= 'disabled';
				$data['enable'] 	= 0;
				$data['enable_css'] = 'background-color:#F3F6F9;';
			}
		}
		$data['data_log'] 		= $this->main_act->log_by_id_perencanaan($id_apm, 'APM');
		$data['list_user'] 		= $this->master_act->user();
		$data['list_divisi'] 	= $this->master_act->divisi();
		$data['menu']           = 'perencanaan';
		$data['sub_menu']      	= 'kotak_masuk';
		$data['sub_menu_2']     = 'kotak_masuk_apm';
        $data['title']          = 'Review APM';
        $data['content']        = 'content/perencanaan/apm/v_create_apm';
        $this->show($data);
	}

	public function simpan()
	{
		$request = $this->input->post();
		$id_apm = $request['ID_APM'];
		$data = [
				    'BERITA_ATURAN'           		=> is_empty_return_null($request['BERITA_ATURAN']),
				    'CATATAN'                 		=> is_empty_return_null($request['CATATAN']),
				    'DAFTAR_DOKUMEN'          		=> is_empty_return_null($request['DAFTAR_DOKUMEN']),
				    'DAFTAR_RESIKO_POTENSIAL' 		=> is_empty_return_null($request['DAFTAR_RESIKO_POTENSIAL']),
				    'DESKRIPSI_TEXT'          		=> is_empty_return_null($request['DESKRIPSI_TEXT']),
				    'JADWAL_DRAFT_LAPORAN'    		=> is_empty_return_null($request['JADWAL_DRAFT_LAPORAN']),
				    'JADWAL_ENTRANCE_MEETING' 		=> is_empty_return_null($request['JADWAL_ENTRANCE_MEETING']),
				    'JADWAL_EXIT_MEETING'     		=> is_empty_return_null($request['JADWAL_EXIT_MEETING']),
				    'JADWAL_LAPORAN_HASIL'    		=> is_empty_return_null($request['JADWAL_LAPORAN_HASIL']),
				    'JADWAL_PELAKSANAAN'        	=> is_empty_return_null($request['JADWAL_PELAKSANAAN']),
				    'JADWAL_PELAKSANAAN_SELESAI'	=> is_empty_return_null($request['JADWAL_PELAKSANAAN_SELESAI']),
				    'JADWAL_PERENCANAAN'      		=> is_empty_return_null($request['JADWAL_PERENCANAAN']),
				    'NAMA_AUDIT'              		=> is_empty_return_null($request['NAMA_AUDIT']),
				    'PROSES_BISNIS_TEXT'      		=> is_empty_return_null($request['PROSES_BISNIS_TEXT']),
				    'RESIKO'                  		=> is_empty_return_null($request['RESIKO']),
				    'REVIEW_ANALISIS'         		=> is_empty_return_null($request['REVIEW_ANALISIS']),
				    'RUANG_LINGKUP'           		=> is_empty_return_null($request['RUANG_LINGKUP']),
				    'PERIODE_AUDIT'                 => is_empty_return_null($request['PERIODE_AUDIT']),
				    'TGL_PERIODE_MULAI'       		=> is_empty_return_null($request['TGL_PERIODE_MULAI']),
			      	'TGL_PERIODE_SELESAI'     		=> is_empty_return_null($request['TGL_PERIODE_SELESAI']),
			      	'TUJUAN'                  		=> is_empty_return_null($request['TUJUAN']),
			      	'ID_STATUS' 				    => is_empty_return_null($request['ACTION']),
					'ID_PEMBUAT' 				    => $this->session->ID_USER,
		];

		if (empty($id_apm)) {
			$data['ID_SPA'] = $request['ID_SPA'];
			$save = $this->m_apm->save($data);
			if ($save) {
				$success_message = 'Data berhasil disimpan.';
				$this->session->set_flashdata('success', $success_message);
				echo base_url('perencanaan/apm/kotak_keluar');
			}else {
				$error_message = 'Nomor sudah terpakai.';
				$this->session->set_flashdata('error', $error_message);
				echo base_url('perencanaan/apm/create');
			}
		}else {
			$this->m_apm->send_update($data, $id_apm);
			$success_message = 'Data berhasil dikirim.';
			$this->session->set_flashdata('success', $success_message);
			echo base_url('perencanaan/apm/kotak_keluar');
		}
	}

	public function approve_reject($id_apm)
	{
		$request 	= $this->input->post();
		$data 		= [
			'BERITA_ATURAN'           => $request['BERITA_ATURAN'],
			'CATATAN'                 => $request['CATATAN'],
			'DAFTAR_DOKUMEN'          => $request['DAFTAR_DOKUMEN'],
			'DAFTAR_RESIKO_POTENSIAL' => $request['DAFTAR_RESIKO_POTENSIAL'],
			'DESKRIPSI_TEXT'          => $request['DESKRIPSI_TEXT'],
			'JADWAL_DRAFT_LAPORAN'    => $request['JADWAL_DRAFT_LAPORAN'],
			'JADWAL_ENTRANCE_MEETING' => $request['JADWAL_ENTRANCE_MEETING'],
			'JADWAL_EXIT_MEETING'     => $request['JADWAL_EXIT_MEETING'],
			'JADWAL_LAPORAN_HASIL'    => $request['JADWAL_LAPORAN_HASIL'],
			'JADWAL_PELAKSANAAN'      => $request['JADWAL_PELAKSANAAN'],
			'JADWAL_PERENCANAAN'      => $request['JADWAL_PERENCANAAN'],
			'NAMA_AUDIT'              => $request['NAMA_AUDIT'],
			'PROSES_BISNIS_TEXT'      => $request['PROSES_BISNIS_TEXT'],
			'RESIKO'                  => $request['RESIKO'],
			'REVIEW_ANALISIS'         => $request['REVIEW_ANALISIS'],
			'RUANG_LINGKUP'           => $request['RUANG_LINGKUP'],
			'PERIODE_AUDIT'           => $request['PERIODE_AUDIT'],
			'TGL_PERIODE_MULAI'       => $request['TGL_PERIODE_MULAI'],
			'TGL_PERIODE_SELESAI'     => $request['TGL_PERIODE_SELESAI'],
			'TUJUAN'                  => $request['TUJUAN'],
			'ID_STATUS' 			  => $request['ACTION'],
		];

		$data_pemeriksa = [
			'KOMENTAR' 	=> $request['KOMENTAR'],
			'TANGGAL' 	=> $request['TANGGAL'],
			'ID_USER' 	=> $this->session->ID_USER,
		];

		$this->m_apm->approval($data, $data_pemeriksa, $id_apm);
		
		$aksi 		= $data['ID_STATUS'] == 3 ? 'diapprove' : 'direject';
		$komentar 	= (!empty( $request['KOMENTAR'])) ? 'dengan Komentar : '.strip_tags( $request['KOMENTAR']) : '';
		$data_user 	= $this->m_user->user($this->session->ID_USER)[0];
		$log 		= $data_user['NIPP'].'/'.$data_user['NAMA'].' - '.' Surat '.$aksi.' '.$komentar;
		$this->main_act->save_log_perencanaan($id_apm, 'APM', $log);
		$success_message = 'Data berhasil '.$aksi;
		$this->session->set_flashdata('success', $success_message);

		echo base_url('perencanaan/apm/kotak_masuk');

	}

	public function cetak_preview($id)
	{
		$data_apm['title'] = '';
		// $data_apm['author'] =  $this->m_user->user($this->session->ID_USER)[0];
		$data_apm['data_apm'] = $this->m_apm->apm_detail($id);
		$data_apm['apm'] = $this->m_apm->get_apm($this->session->ID_USER);
		$data_pemeriksa = $this->m_apm->get_pemeriksa($id);
		// print_r($data_pemeriksa);die();
		$tanggal_atasan1 = tgl_indo($data_pemeriksa[0]['TANGGAL']);
		$tanggal_atasan2 = tgl_indo($data_pemeriksa[1]['TANGGAL']);
		$data_apm['tanggal_atasan1'] = $tanggal_atasan1;
		$data_apm['tanggal_atasan2'] = $tanggal_atasan2;
		$data_apm['status1'] = $data_pemeriksa[0]['STATUS'];
		$data_apm['status2'] = $data_pemeriksa[1]['STATUS'];
		$data_apm['ttd1'] = $data_pemeriksa[0]['TANDA_TANGAN'];
		$data_apm['ttd2'] = $data_pemeriksa[1]['TANDA_TANGAN'];
		$data_apm['tim_audit'] = $this->m_tim_audit->get_tim_audit($data_apm['data_apm']->ID_SPA, 'SPA');
		$this->load->view('/content/cetak/apm', $data_apm);
	}

}
