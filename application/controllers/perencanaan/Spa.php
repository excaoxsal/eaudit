<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Spa extends MY_Controller
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

	public function kotak_keluar()
	{
		$data['list_status'] 	= $this->master_act->status();
		$data['menu']           = 'perencanaan';
		$data['sub_menu']       = 'kotak_keluar';
		$data['sub_menu_2']     = 'kotak_keluar_spa';
		$data['title']          = 'Surat Perintah Audit';
        $data['content']        = 'content/perencanaan/spa/v_kotak_keluar_spa';
        $this->show($data);
	}

	public function kotak_masuk()
	{
		$data['list_status'] 	= $this->master_act->status();
		$data['menu']           = 'perencanaan';
		$data['sub_menu']       = 'kotak_masuk';
		$data['sub_menu_2']     = 'kotak_masuk_spa';
		$data['title']          = 'Surat Perintah Audit';
        $data['content']        = 'content/perencanaan/spa/v_kotak_masuk_spa';
        $this->show($data);
	}

	function jsonKotakKeluarSpa()
	{
		if($this->input->server('REQUEST_METHOD') === 'POST') echo json_encode($this->m_spa->kotak_keluar($this->session->ID_USER));
	}

	function jsonKotakMasukSpa() 
	{
        if($this->input->server('REQUEST_METHOD') === 'POST') echo json_encode($this->m_spa->kotak_masuk($this->session->ID_USER));
    }

	function getTimAudit()
	{
		$id_spa		= $_GET['id_spa'];
		$cari 		= $this->m_spa->get_tim($id_spa);
		echo json_encode($cari);
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
		$data['sub_menu']      		= 'kotak_keluar';
		$data['sub_menu_2']     	= 'kotak_keluar_spa';
		$data['title']          	= 'Create SPA';
        $data['content']        	= 'content/perencanaan/spa/v_create_spa';
        $this->show($data);
	}

	public function review()
	{
		$id_spa = $this->input->get('id');
		$id_spa = base64_decode($id_spa);
		$peserta			= $this->m_spa->get_dasar($id_spa);
		$data['peserta'] 	= $peserta;
		$perintah			= $this->m_spa->get_perintah($id_spa);
		$data['perintah'] 	= $perintah;
		$tembusan			= $this->m_spa->get_tembusan($id_spa);
		$data['tembusan'] 	= $tembusan;
		$spa_detail			= $this->m_spa->spa_detail($id_spa);

		if($spa_detail->APPROVED_COUNT == '2' AND $spa_detail->APPROVER_COUNT == '2' && $spa_detail->ID_STATUS == '3')
			$data['disabled'] = 'disabled';
		
		$data['data_log'] 			= $this->main_act->log_by_id_perencanaan($id_spa, 'SPA');
		$data['spa_detail'] 		= $spa_detail;
		$data['status_approver'] 	= $this->m_spa->status_approver($this->session->ID_USER, $id_spa);
		$data['list_jenis_audit'] 	= $this->master_act->jenis_audit();
		$data['list_divisi'] 		= $this->master_act->divisi();
		$data['list_user']			= $this->master_act->user(['U.STATUS' => 1]);
		$data['tim_audit'] 			= $this->m_tim_audit->get_tim_audit($id_spa, 'SPA');
		$data['menu']           	= 'perencanaan';
		$data['sub_menu']      		= 'kotak_masuk';
		$data['sub_menu_2']     	= 'kotak_masuk_spa';
        $data['title']          	= 'Review SPA';
        $data['content']        	= 'content/perencanaan/spa/v_review_spa';
        $this->show($data);
	}

	public function preview()
	{
		$id_perencanaan 	= $this->m_spa->last_id_spa();
		$id_perencanaan		= $id_perencanaan->max + 1;
		$data = array(
			'ID_SPA'  			=> $id_perencanaan,
			'NOMOR_SURAT'  		=> $this->input->post('nomor_surat'),
			'ID_STATUS'  		=> 1,
			'ID_PEMBUAT'  		=> $this->session->ID_USER,
			'KEPADA'  			=> $this->input->post('id_divisi'),
			'ID_JENIS_AUDIT'  	=> $this->input->post('id_jenis_audit'),
			'PERIODE_AUDIT_AWAL'  		=> is_empty_return_null($this->input->post('PERIODE_AUDIT_AWAL')),
			'PERIODE_AUDIT_AKHIR'  		=> is_empty_return_null($this->input->post('PERIODE_AUDIT_AKHIR')),
			'MASA_AUDIT_AWAL'  			=> is_empty_return_null($this->input->post('MASA_AUDIT_AWAL')),
			'MASA_AUDIT_AKHIR'  		=> is_empty_return_null($this->input->post('MASA_AUDIT_AKHIR')),
			'TOTAL_HARI_AUDIT'  		=> is_empty_return_null($this->input->post('TOTAL_HARI_AUDIT')),
			'TOTAL_HARI_AUDIT_KET'  	=> is_empty_return_null($this->input->post('TOTAL_HARI_AUDIT_KET'))
		);
		$this->m_spa->add($data, 'SPA');
		if ($this->db->affected_rows() != 1) {
			echo "error";
			die();
		}

		$user_detail	= $this->master_act->user(['U.ID_USER'=>$this->session->ID_USER]);
		$atasan_i 		= $user_detail[0]['ID_ATASAN_I'];
		$atasan_ii 		= $user_detail[0]['ID_ATASAN_II'];
		if ($atasan_i != 0 || $atasan_i != null || $atasan_i != '') {
			$data = array(
				'ID_PERENCANAAN'	  	=> $id_perencanaan,
				'JENIS_PERENCANAAN'  	=> 'SPA',
				'ID_USER'  				=> $atasan_i,
				'NO_URUT'			  	=> 1,
				'STATUS'			  	=> 1
			);
			$this->m_spa->add($data, 'PEMERIKSA');
		}
		if ($atasan_ii != 0 || $atasan_ii != null || $atasan_ii != '') {
			$data = array(
				'ID_PERENCANAAN'	  	=> $id_perencanaan,
				'JENIS_PERENCANAAN'  	=> 'SPA',
				'ID_USER'  				=> $atasan_ii,
				'NO_URUT'			  	=> 2,
				'STATUS'			  	=> 0
			);
			$this->m_spa->add($data, 'PEMERIKSA');
		}

		$total_tim 	= count($this->input->post('tim_audit'));
		$no_urut 	= 1;
		for ($i = 0; $i < $total_tim; $i++) {
			if (trim($this->input->post('tim_audit')[$i]) != '') {
				$data = array(
					'ID_PERENCANAAN'	  	=> $id_perencanaan,
					'JENIS_PERENCANAAN'  	=> 'SPA',
					'ID_USER'  				=> $this->input->post('tim_audit')[$i],
					'JABATAN'  				=> $this->input->post('jabatan_tim')[$i],
					'NO_URUT'			  	=> $no_urut
				);
				$this->m_spa->add($data, 'TIM_AUDIT');
				$no_urut++;
			}
		}
		// echo $nomor_surat;
	}

	public function kirim($id_spa)
	{
		$data_spa = [
			'AUDITEE' 				=> $this->input->post('AUDITEE'),
			'TAHUN_AUDIT' 			=> $this->input->post('TAHUN_AUDIT'),
			'DASAR_AUDIT' 			=> $this->input->post('DASAR_AUDIT'),
			'ISI_PERINTAH' 			=> $this->input->post('ISI_PERINTAH'),
			'ID_STATUS' 			=> $this->input->post('STATUS'),
			'DIKELUARKAN' 			=> $this->input->post('DIKELUARKAN'),
			'PADA_TANGGAL' 			=> $this->input->post('PADA_TANGGAL'),
			'PERIODE_AUDIT_AWAL'  		=> is_empty_return_null($this->input->post('PERIODE_AUDIT_AWAL')),
			'PERIODE_AUDIT_AKHIR'  		=> is_empty_return_null($this->input->post('PERIODE_AUDIT_AKHIR')),
			'MASA_AUDIT_AWAL'  			=> is_empty_return_null($this->input->post('MASA_AUDIT_AWAL')),
			'MASA_AUDIT_AKHIR'  		=> is_empty_return_null($this->input->post('MASA_AUDIT_AKHIR')),
			'TOTAL_HARI_AUDIT'  		=> is_empty_return_null($this->input->post('TOTAL_HARI_AUDIT')),
			'TOTAL_HARI_AUDIT_KET'  	=> is_empty_return_null($this->input->post('TOTAL_HARI_AUDIT_KET'))
		];
		$data_pemeriksa = [
			'KOMENTAR' 	=> $this->input->post('KOMENTAR'),
			'ID_USER' 	=> $this->session->ID_USER,
		];
		$dasar_audit 	= $this->input->post('PESERTA');
		$perintah_audit = $this->input->post('PERINTAH');
		$tim_audit 		= $this->input->post('TIM_AUDIT');
		$jabatan_tim 	= $this->input->post('JABATAN_TIM');
		$tembusan 		= $this->input->post('TEMBUSAN');

		$this->m_spa->approval($data_spa, $data_pemeriksa, $id_spa, $dasar_audit, $perintah_audit, $tim_audit, $jabatan_tim, $tembusan);
		
		$aksi 		= $data_spa['ID_STATUS'] == 3 ? 'Diapprove' : 'Direject';
		$komentar 	= (!empty($this->input->post('KOMENTAR'))) ? 'dengan Komentar : '.strip_tags($this->input->post('KOMENTAR')) : '';
		$data_user 	= $this->master_act->user(['U.ID_USER' => $this->session->ID_USER])[0];
		$log 		= $data_user['NIPP'].'/'.$data_user['NAMA'].' - '.' Surat '.$aksi.' '.$komentar;
		$this->main_act->save_log_perencanaan($id_spa, 'SPA', $log);

		$success_message = 'Data berhasil '.$aksi;
		$this->session->set_flashdata('success', $success_message);

		echo base_url('perencanaan/spa/kotak_masuk');

	}

	public function simpan()
	{
		//generate spa id
		// $d = strtotime($this->input->post('PADA_TANGGAL'));
		$tgl 		= date('dmY');
		$last_spa 	= $this->m_spa->get_last_spa_no();
		$arrNo 		= explode("/", $last_spa['NOMOR_SPA_SEQ']);

		if (!empty($arrNo)) {
			$noUrut = $arrNo[2] + 1;
			$noUrut =  sprintf("%03s", $noUrut);
			$SPA_ID = 'SPA/' . $tgl . '/' . $noUrut;
		} else {
			$SPA_ID = 'SPA/' . $tgl . '/001';
		}

		$data_spa = [
			'AUDITEE' 				=> $this->input->post('AUDITEE'),
			'TAHUN_AUDIT' 			=> $this->input->post('TAHUN_AUDIT'),
			'DASAR_AUDIT' 			=> $this->input->post('DASAR_AUDIT'),
			'ISI_PERINTAH' 			=> $this->input->post('ISI_PERINTAH'),
			'ID_STATUS' 			=> 1,
			'DIKELUARKAN' 			=> $this->input->post('DIKELUARKAN'),
			'PADA_TANGGAL' 			=> $this->input->post('PADA_TANGGAL'),
			'ID_PEMBUAT' 			=> $this->session->ID_USER,
			'PERIODE_AUDIT_AWAL'  		=> is_empty_return_null($this->input->post('PERIODE_AUDIT_AWAL')),
			'PERIODE_AUDIT_AKHIR'  		=> is_empty_return_null($this->input->post('PERIODE_AUDIT_AKHIR')),
			'MASA_AUDIT_AWAL'  			=> is_empty_return_null($this->input->post('MASA_AUDIT_AWAL')),
			'MASA_AUDIT_AKHIR'  		=> is_empty_return_null($this->input->post('MASA_AUDIT_AKHIR')),
			'TOTAL_HARI_AUDIT'  		=> is_empty_return_null($this->input->post('TOTAL_HARI_AUDIT')),
			'TOTAL_HARI_AUDIT_KET'  	=> is_empty_return_null($this->input->post('TOTAL_HARI_AUDIT_KET'))
		];

		if ($this->input->post('ACTION') == 3)
			$data_spa['ID_STATUS'] = 2;

		$tim_audit 		= $this->input->post('TIM_AUDIT');
		$jabatan_tim 	= $this->input->post('JABATAN_TIM');
		$dasar_audit 	= $this->input->post('PESERTA');
		$tembusan 		= $this->input->post('TEMBUSAN');
		$perintah_audit = $this->input->post('PERINTAH');

		if (empty($this->input->post('ID_SPA'))) {
			$data_spa['NOMOR_SPA_SEQ'] = $SPA_ID;
			$save = $this->m_spa->save($data_spa, $tim_audit, $jabatan_tim, $dasar_audit, $perintah_audit, $tembusan);
			if ($save) {
				$success_message = 'Data berhasil disimpan.';
				$this->session->set_flashdata('success', $success_message);
				echo base_url('perencanaan/spa/kotak_keluar');
			} else {
				$error_message = 'Nomor surat sudah terpakai.';
				$this->session->set_flashdata('error', $error_message);
				echo base_url('perencanaan/spa/create');
			}
		} else {
			$this->m_spa->send_update($data_spa, $tim_audit, $jabatan_tim, $dasar_audit, $perintah_audit, $this->input->post('ID_SPA'), $tembusan);
			$success_message = 'Data berhasil dikirim.';
			$this->session->set_flashdata('success', $success_message);
			echo base_url('perencanaan/spa/kotak_keluar');
		}
	}

	public function cetak_preview()
	{
		$id = $this->input->get('id');
		$id = base64_decode($id);
		$data_spa['title'] 		= 'Surat Perintah';
		$data_spa['spa']		= $this->m_spa->spa_detail($id);
		$data_spa['ttd_spa']	= $this->db->get('TTD_SPA')->result_array();
		$data_spa['tim_audit'] 	= $this->m_spa->get_tim($id);
		$data_spa['dasar'] 		= $this->m_spa->get_dasar($id);
		$data_spa['tembusan'] 	= $this->m_spa->get_tembusan($id);
		$data_spa['perintah'] 	= $this->m_spa->get_perintah($id);
		// print_r($data_spa['tim_audit']);die();
		// $data_spa['author'] 	=  $this->m_user->user(USER_DIRUT_ID)[0];
		$this->load->view('/content/cetak/spa', $data_spa);
	}

	function upload_lampiran()
	{
		$id_spa = $this->input->get('id');
		$id_spa = base64_decode($id_spa);
		$config['upload_path']      = './storage/spa/';
		$config['allowed_types']    = 'gif|jpg|png|jpeg|bmp|pdf|docx|doc|xlsx|xls';
		$this->load->library('upload', $config);
		$ext = pathinfo($_FILES['LAMPIRAN']['name'], PATHINFO_EXTENSION);
		$file = basename($_FILES['LAMPIRAN']['name'], "." . $ext);
		$nama_file = str_replace(".", "_", $file);
		$nama_file = $id_spa . '_' . str_replace(" ", "_", $nama_file) . '_' . date('YmdHis') . '.' . $ext;
		// print_r($nama_file);die();
		if (!empty($_FILES['LAMPIRAN']['name'])) {
			$config['file_name'] = $nama_file;
			$this->upload->initialize($config);
			if ($this->upload->do_upload('LAMPIRAN')) {
				$this->upload->data();
				$data = array(
					'NOMOR_SURAT'   => $this->input->post('NOMOR_SURAT'),
					'PADA_TANGGAL'  => is_empty_return_null($this->input->post('PADA_TANGGAL')),
					'FILE_TTD' 		=> $nama_file
				);
				$this->m_spa->update($data, ['ID_SPA' => $id_spa]);
				$success_message = 'File berhasil diupload.';
				$this->session->set_flashdata('success', $success_message);
			} else {
				$error_message = $this->upload->display_errors();
				$this->session->set_flashdata('error', $error_message);
			}
		} else {
			$error_message = "File yang diupload kosong.";
			$this->session->set_flashdata('error', $error_message);
		}
		redirect(base_url('perencanaan/spa/create?id=' . base64_encode($id_spa)), 'refresh');
	}
}
