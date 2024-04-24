<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rcm extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Pdf');
		$this->load->model('perencanaan/M_tim_audit', 'm_tim_audit');
		$this->load->model('perencanaan/m_rcm', 'm_rcm');
		$this->load->model('perencanaan/m_spa', 'm_spa');
		$this->is_login();
		if(!$this->is_auditor()) $this->load->view('/errors/html/err_401');
	}

	public function kotak_keluar()
	{
		$data['menu']           = 'perencanaan';
		$data['sub_menu']       = 'kotak_keluar';
		$data['sub_menu_2']     = 'kotak_keluar_rcm';
		$data['title']          = 'Risk and Control Matrix';
        $data['content']        = 'content/perencanaan/rcm/v_kotak_keluar_rcm';
        $this->show($data);
	}

	public function kotak_masuk()
	{
		$data['list_status'] 	= $this->master_act->status();
		$data['menu']           = 'perencanaan';
		$data['sub_menu']       = 'kotak_masuk';
		$data['sub_menu_2']     = 'kotak_masuk_rcm';
		$data['title']          = 'Risk and Control Matrix';
        $data['content']        = 'content/perencanaan/rcm/v_kotak_masuk_rcm';
        $this->show($data);
	}

	function jsonKotakKeluarRcm()
	{
		header('Content-Type: application/json');
		echo json_encode($this->m_rcm->get_rcm($this->session->ID_USER));
	}

	function jsonKotakMasukRcm() 
	{
        header('Content-Type: application/json');
        echo json_encode($this->m_rcm->kotak_masuk($this->session->ID_USER));
	}

	public function cetak_preview($id)
	{
		$data_rcm['data_rcm']			= $this->m_rcm->rcm_detail($id);
		$data_rcm['rcm']				= $this->m_rcm->get_rcm($this->session->ID_USER);
		$data_rcm['tim_audit'] 			= $this->m_tim_audit->get_tim_audit($data_rcm['data_rcm']->ID_SPA, 'SPA');
		$data_rcm['list_add_proses'] 	= $this->m_rcm->get_add_proses(null, null, $id);
		$data_pemeriksa 				= $this->m_rcm->get_pemeriksa($id);
		$data_rcm['tanggal_atasan1'] 	= tgl_indo($data_pemeriksa[0]['TANGGAL']);
		$data_rcm['tanggal_atasan2'] 	= tgl_indo($data_pemeriksa[1]['TANGGAL']);
		$data_rcm['status1'] 		 	= $data_pemeriksa[0]['STATUS'];
		$data_rcm['status2'] 			= $data_pemeriksa[1]['STATUS'];
		$data_rcm['ttd1'] 				= $data_pemeriksa[0]['TANDA_TANGAN'];
		$data_rcm['ttd2'] 				= $data_pemeriksa[1]['TANDA_TANGAN'];;
		$this->load->view('/content/cetak/rcm', $data_rcm);
	}

	public function create($id_rcm = 0)
	{
		if (!empty($id_rcm) || $id_rcm != 0) {
			$data_rcm				= $this->m_rcm->rcm_detail($id_rcm);
			$data_spa				= $this->m_rcm->get_spa($id_rcm);
			$data['data_rcm'] 		= $data_rcm;
			$data['disabled_edit'] 	= 'disabled';
			$data['nomor_surat'] 	= $data_spa->NOMOR_SURAT;
			if ($data_rcm->ID_STATUS != 1 && $data_rcm->ID_STATUS != 4) {
				$data['disabled'] 	= 'disabled';
				$data['enable'] 	= 0;
				$data['enable_css'] = 'background-color:#F3F6F9;';
			}
		} else {
			$this->m_rcm->delete_all_proses($this->session->ID_USER);
		}
		$data_log 						= $this->main_act->log_by_id_perencanaan($id_rcm, 'RCM');
		$data['data_log'] 				= $data_log;
		$data['menu']           		= 'perencanaan';
		$data['sub_menu']      			= 'kotak_keluar';
		$data['sub_menu_2']     		= 'kotak_keluar_rcm';
		$data['nomor_spa']  			= $this->m_spa->spa_list();
		$data['list_divisi'] 			= $this->master_act->divisi();
		$data['list_resiko'] 			= $this->master_act->tingkat_resiko();
		$data['klasifikasi']    		= $this->master_act->klasifikasi();
		$data['list_add_proses'] 		= $this->m_rcm->get_add_proses($this->session->ID_USER, null, $id_rcm);
		$data['list_tipe_kontrol'] 		= $this->master_act->tipe_kontrol();
		$data['list_frekuensi_kontrol']	= $this->master_act->frekuensi_kontrol();
		$data['title']          		= 'Create Tanggapan Pertanyaan Oleh Auditee';
        $data['content']        		= 'content/perencanaan/rcm/v_create_rcm';
        $this->show($data);
	}

	public function review($id_rcm = 0)
	{
		if (!empty($id_rcm) || $id_rcm != 0) {
			$data_rcm				= $this->m_rcm->rcm_detail($id_rcm);
			$data_spa				= $this->m_rcm->get_spa($id_rcm);
			$data['data_rcm'] 		= $data_rcm;
			$data['disabled_edit'] 	= 'disabled';
			$data['nomor_surat'] 	= $data_spa->NOMOR_SURAT;
			if ($_GET['sts-approver'] != '1'){
				$data['disabled'] 	= 'disabled';
				$data['enable'] 	= 0;
				$data['enable_css'] = 'background-color:#F3F6F9;';
			}
		}
		$data['data_log'] 				= $this->main_act->log_by_id_perencanaan($id_rcm, 'RCM');
		$data['menu']           		= 'perencanaan';
		$data['sub_menu']      			= 'kotak_masuk';
		$data['sub_menu_2']     		= 'kotak_masuk_rcm';
		$data['list_divisi'] 			= $this->master_act->divisi();
		$data['list_resiko'] 			= $this->master_act->tingkat_resiko();
		// $data['list_add_proses'] 	= $this->m_rcm->get_add_proses($data_rcm->ID_PEMBUAT, null, $id_rcm);
		$data['list_add_proses'] 		= $this->m_rcm->get_add_proses(null, null, $id_rcm);
		$data['list_tipe_kontrol'] 		= $this->master_act->tipe_kontrol();
		$data['list_frekuensi_kontrol'] = $this->master_act->frekuensi_kontrol();
        $data['title']          		= 'Review RCM';
        $data['content']        		= 'content/perencanaan/rcm/v_create_rcm';
        $this->show($data);
	}

	public function approve_reject($id_rcm)
	{
		$request 	= $this->input->post();
		$data 		= [
			'KEPADA'  				=> $request['KEPADA'],
			'AREA_AUDIT' 			=> $request['AREA_AUDIT'],
			'TGL_PERIODE_MULAI'  	=> $request['TGL_PERIODE_MULAI'],
			'TGL_PERIODE_SELESAI'  	=> $request['TGL_PERIODE_SELESAI'],
			'ID_STATUS'      		=> $request['ACTION'],
		];

		$data_pemeriksa = [
			'KOMENTAR' 	=> $request['KOMENTAR'],
			'TANGGAL' 	=> $request['TANGGAL'],
			'ID_USER' 	=> $this->session->ID_USER,
		];

		$this->m_rcm->approval($data, $data_pemeriksa, $id_rcm);
		
		$aksi 			= $data['ID_STATUS'] == 3 ? 'diapprove' : 'direject';
		$komentar 		= (!empty( $request['KOMENTAR'])) ? 'dengan Komentar : '.strip_tags( $request['KOMENTAR']) : '';
		$data_user 		= $this->master_act->user(['U.ID_USER' => $this->session->ID_USER]);
		$log 			= $data_user['NIPP'].'/'.$data_user['NAMA'].' - '.' Surat '.$aksi.' '.$komentar;
		
		$this->main_act->save_log_perencanaan($id_rcm, 'RCM', $log);
		$success_message = 'Data berhasil '.$aksi;
		$this->session->set_flashdata('success', $success_message);

		echo base_url('perencanaan/rcm/kotak_masuk');

	}

	public function add_proses_save()
	{
		$request = $this->input->post();
		$id_proses_rcm = $request['ID_RCM_ADD_PROSES'];
		$id_rcm = (!empty($request['ID_RCM'])) ? (int)$request['ID_RCM'] : 0;

		$data = [
			'ANGGARAN_MANDAYS'  => $request['ANGGARAN_MANDAYS'],
			'AUDITEE' 		    => $request['AUDITEE'],
			'AUDIT_PROGRAM'     => $request['AUDIT_PROGRAM'],
			'DESKRIPSI_PROSES'  => $request['DESKRIPSI_PROSES'],
			'DESKRIPSI_RESIKO'  => $request['DESKRIPSI_RESIKO'],
			'FREKUENSI_KONTROL' => implode(", ", $request['FREKUENSI_KONTROL']),
			'JML_SAMPLE'        => $request['JML_SAMPLE'],
			'KELEMAHAN'         => $request['KELEMAHAN'],
			'KONTROL_AS_IS'     => $request['KONTROL_AS_IS'],
			'KONTROL_SHOULD_BE' => $request['KONTROL_SHOULD_BE'],
			'KONTROL_STANDAR'   => $request['KONTROL_STANDAR'],
			'PRIORITAS_RESIKO'  => $request['PRIORITAS_RESIKO'],
			'REFERENSI_KKP'     => $request['REFERENSI_KKP'],
			'TIPE_KONTROL'      => implode(", ", $request['TIPE_KONTROL']),
			'ID_PEMBUAT'      	=> $this->session->ID_USER,
			'ID_RCM'      		=> $id_rcm,
		];

		$this->m_rcm->add_proses($data, $id_proses_rcm);

		$list_add_proses = $this->m_rcm->get_add_proses($this->session->ID_USER, null, $id_rcm);
		$contents = '<table id="tableProses" class="table table-bordered">
		<thead>
			<tr>
				<th>No</th>
				<th>Proses</th>
				<th>Risiko</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>';
		foreach ($list_add_proses as $key => $dt) {
			$contents .= '<tr>
				<td>' . ($key + 1) . '</td>
				<td>' . $dt["DESKRIPSI_PROSES"] . '</td>
				<td>' . $dt["DESKRIPSI_RESIKO"] . '</td>
				<td>
				<a onclick="edit_proses(' . $dt["ID_RCM_ADD_PROSES"] . ', ' . $dt["ID_RCM"] . ')" href="#" data-toggle="modal" data-target="#modal_proses" title="Edit">
				<i class="fa fa-edit"></i>
				</a>
				<a onclick="delete_proses(' . $dt["ID_RCM_ADD_PROSES"] . ', ' . $dt["ID_RCM"] . ')" class="btn btn-sm btn-clean btn-icon" title="Hapus"><i class="fa fa-trash"></i></a>
				</td>
			</tr>';
		}
		$contents .= '</tbody> </table>';
		echo $contents;
	}

	public function delete_proses($id_proses)
	{
		$id_rcm = (!empty($this->input->get('ID_RCM'))) ? (int)$this->input->get('ID_RCM') : 0;
		$this->m_rcm->delete_proses($id_proses);
		$list_add_proses = $this->m_rcm->get_add_proses($this->session->ID_USER, null, $id_rcm);
		$contents = '<table id="tableProses" class="table table-bordered">
		<thead>
			<tr>
				<th>No</th>
				<th>Proses</th>
				<th>Risiko</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>';
		foreach ($list_add_proses as $key => $dt) {
			$contents .= '<tr>
				<td>' . ($key + 1) . '</td>
				<td>' . $dt["DESKRIPSI_PROSES"] . '</td>
				<td>' . $dt["DESKRIPSI_RESIKO"] . '</td>
				<td>
				<a onclick="edit_proses(' . $dt["ID_RCM_ADD_PROSES"] . ', ' . $dt["ID_RCM"] . ')" href="#" data-toggle="modal" data-target="#modal_proses" title="Edit">
				<i class="fa fa-edit"></i>
				</a>
				<a onclick="delete_proses(' . $dt["ID_RCM_ADD_PROSES"] . ', ' . $dt["ID_RCM"] . ')" class="btn btn-sm btn-clean btn-icon" title="Hapus"><i class="fa fa-trash"></i></a>
				</td>
			</tr>';
		}
		$contents .= '</tbody> </table>';
		echo $contents;
	}

	public function edit_proses($id_proses)
	{
		$id_rcm 			= (!empty($this->input->get('ID_RCM'))) ? (int)$this->input->get('ID_RCM') : 0;
		$list_add_proses 	= $this->m_rcm->get_add_proses(null, $id_proses, $id_rcm);
		// $list_add_proses = $this->m_rcm->get_add_proses($this->session->ID_USER, $id_proses, $id_rcm);
		echo json_encode($list_add_proses);
	}


	public function simpan()
	{
		$request = $this->input->post();

		$id_rcm = $request['ID_RCM'];

		$data = [
			'KEPADA'  				=> $request['KEPADA'],
			'AREA_AUDIT' 			=> $request['AREA_AUDIT'],
			'TGL_PERIODE_MULAI'  	=> $request['TGL_PERIODE_MULAI'],
			'TGL_PERIODE_SELESAI'  	=> $request['TGL_PERIODE_SELESAI'],
			'ID_PEMBUAT'      		=> $this->session->ID_USER,
			'ID_STATUS'      		=> $request['ACTION'],
		];

		if (empty($id_rcm)) {
			$data['ID_SPA'] = $request['ID_SPA'];
			$save = $this->m_rcm->save($data);
			if ($save) {
				$success_message = 'Data berhasil disimpan.';
				$this->session->set_flashdata('success', $success_message);
				echo base_url('perencanaan/rcm/kotak_keluar');
			} else {
				$error_message = 'Nomor sudah terpakai.';
				$this->session->set_flashdata('error', $error_message);
				echo base_url('perencanaan/rcm/create');
			}
		} else {
			$this->m_rcm->send_update($data, $id_rcm);
			$success_message = 'Data berhasil dikirim.';
			$this->session->set_flashdata('success', $success_message);
			echo base_url('perencanaan/rcm/kotak_keluar');
		}
	}

	public function get_master_proses_json()
	{
		header('Content-Type: application/json');
		echo json_encode($this->m_rcm->get_master_proses());
	}

	public function get_master_resiko_desc_json()
	{
		header('Content-Type: application/json');
		echo json_encode($this->m_rcm->get_master_resiko_desc());
	}
}
