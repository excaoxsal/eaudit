<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jadwal extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Pdf');
		
		$this->load->model('perencanaan/M_tim_audit', 'm_tim_audit');
		$this->load->model('aia/M_jadwal', 'm_jadwal');
                $this->load->model('aia/master/Master_act_aia','aia_master_act');
		$this->is_login();
		if(!$this->is_auditor()) $this->load->view('/errors/html/err_401');
	}

	public function jadwal_audit()
	{
		$data['list_status'] 	= $this->master_act->status();
		
		$data['menu']           = 'perencanaan-aia';
		$data['sub_menu']       = 'jadwal_audit';
		$data['title']          = 'List Jadwal Audit ISO';
        $data['content']        = 'content/jadwal/jadwal_audit';
		$data['id_user']		= $this->session->ID_USER;
		$id_user = $data['id_user'];
		$data['jadwal_list'] 	= $this->m_jadwal->jadwal_list($id_user);
		// var_dump($data);
		// die();
        $this->show($data);
	}
	function jsonJadwalList() 
	{
        header('Content-Type: application/json');
        echo json_encode($this->m_jadwal->jadwal_list());
	}

	public function create($id_jadwal = null)
	{
		
		$data['list_user'] 			= $this->master_act->user(['U.STATUS' => 1]);
		$data_auditor 				= $this->master_act->auditor(['R.ID_ROLE' => 1]);
		$data_lead_auditor			= $this->master_act->auditor(['J.ID_JABATAN' => 2132]);
		$data['data_auditor'] 		= $data_auditor;
		$data['data_lead_auditor'] 	= $data_lead_auditor;
		// $data['id_jadwal']			= $this->m_jadwal->get_jadwal($id);
		$data['list_jenis_audit'] 	= $this->master_act->jenis_audit();
		// $listdiv=$this->master_act->divisi();
        $listdiv=$this->aia_master_act->only_divisi();
		$data['list_divisi'] 		= $listdiv;
		$data['menu']           	= 'perencanaan-aia';
		$data['sub_menu']      		= 'jadwal_audit';
		
		$data['title']          	= 'Create Jadwal Audit';
        $data['content']        	= 'content/jadwal/create';
        $this->show($data);
	}

	public function update($id_jadwal)
	{
		
		$data['list_user'] 			= $this->master_act->user(['U.STATUS' => 1]);
		$data_auditor 				= $this->master_act->auditor(['R.ID_ROLE' => 1]);
		$data_lead_auditor			= $this->master_act->auditor(['J.ID_JABATAN' => 2132]);
		$data_jadwal				= $this->m_jadwal->get_jadwal($id_jadwal,$_SESSION->ID_USER);
		$data['data_auditor'] 		= $data_auditor;
		$data['data_lead_auditor'] 	= $data_lead_auditor;
		$data['data_jadwal']		= $data_jadwal;
		// $nama = $data_jadwal[0]['NAMA_AUDITOR'];
		// var_dump($data_jadwal);
		// die();
		$data['list_jenis_audit'] 	= $this->master_act->jenis_audit();
		$data['list_divisi'] 		= $this->master_act->divisi();
		$data['menu']           	= 'perencanaan';
		$data['sub_menu']      		= 'jadwal_audit';
		
		$data['title']          	= 'Update Jadwal Audit';
        $data['content']        	= 'content/jadwal/create';
		// print_r($data['data_jadwal']);
		// die();
        $this->show($data);
	}

    public function index()
	{
		if (isset($this->session->login)) {
			redirect(base_url('aia'));
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
		$idjadwal = $request['ID_JADWAL'];
		if($idjadwal!=null){
			$data = [
				'ID_AUDITOR'           			=> is_empty_return_null($request['ID_AUDITOR']),
				'ID_LEAD_AUDITOR'          		=> is_empty_return_null($request['ID_LEAD_AUDITOR']),
				'WAKTU_AUDIT_AWAL' 				=> is_empty_return_null($request['WAKTU_AUDIT_AWAL']),
				'WAKTU_AUDIT_SELESAI' 			=> is_empty_return_null($request['WAKTU_AUDIT_SELESAI']),
				'ID_DIVISI'    					=> is_empty_return_null($request['ID_DIVISI']),
				'ID_JADWAL'						=> is_empty_return_null($request['ID_JADWAL']),
			];
			
			$update = $this->m_jadwal->update($data);
			if($update==true){
				$success_message = 'Data berhasil diupdate.';
				$this->session->set_flashdata('success', $success_message);
				echo base_url('aia/jadwal/jadwal_audit');
			}
			else{
				$error_message = 'Data tidak berhasil diupdate';
				$this->session->set_flashdata('error', $error_message);
			}
		}
		else{
			$data = [
						'ID_AUDITOR'           			=> is_empty_return_null($request['ID_AUDITOR']),
						'ID_LEAD_AUDITOR'          		=> is_empty_return_null($request['ID_LEAD_AUDITOR']),
						'WAKTU_AUDIT_AWAL' 				=> is_empty_return_null($request['WAKTU_AUDIT_AWAL']),
						'WAKTU_AUDIT_SELESAI' 			=> is_empty_return_null($request['WAKTU_AUDIT_SELESAI']),
						'ID_DIVISI'    					=> is_empty_return_null($request['ID_DIVISI'])
						// 'ID_JADWAL'						=> is_empty_return_null($request['ID_JADWAL'])
			];
			$save = $this->m_jadwal->save($data);
			if($save==true){
				$success_message = 'Data berhasil disimpan.';
				$this->session->set_flashdata('success', $success_message);
				echo base_url('aia/jadwal/jadwal_audit');
			}
			else{
				$error_message = 'Silahkan cek kembali datanya';
				$this->session->set_flashdata('error', $error_message);
			}
		}
		
		
	}

	

	public function hapus($data){
		
		$this->db->trans_start();
		$hapus = $this->db->where('ID_JADWAL',$data)->delete('WAKTU_AUDIT');

		if($hapus==false){
			$this->db->trans_rollback();
			$error_message = 'Data belum berhasil dihapus.';
			$this->session->set_flashdata('error', $error_message);
			
		}
		else{
			$this->db->trans_complete();
			$success_message = 'Data berhasil dihapus.';
			$this->session->set_flashdata('success', $success_message);
			echo base_url('aia/jadwal/jadwal_audit');
		}
		
	}
}