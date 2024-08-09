<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
class Main_act extends CI_Model{

	public function total_notif($id_user)
	{
		$query = $this->db->get_where('PEMERIKSA', array('STATUS_COMMITMENT' => 1, 'ID_USER' => $id_user));					
		return $query->result_array();

	}

	public function notif_atasanAuditee($id_user)
	{
		$query = $this->db->select('*')
							->from('PEMERIKSA P')
							->join('TEMUAN_DETAIL', 'TEMUAN_DETAIL.ID_TEMUAN = P.ID_PERENCANAAN', 'LEFT')
							->where(array('P.STATUS_COMMITMENT' => 1, 'P.JENIS_PERENCANAAN' => 'TEMUAN DETAIL', 'P.ID_USER' => $id_user))
				 			// ->order_by('', 'DESC')
				 			->get();					
		return $query->result_array();
	}

	public function notif_apm($id_user)
	{
		$query = $this->db->select('A.NAMA_AUDIT, A.ID_APM, A.TGL_PERIODE_MULAI, A.TGL_PERIODE_SELESAI')
							->from('PEMERIKSA P')
							->join('APM A', 'A.ID_APM = P.ID_PERENCANAAN', 'LEFT')
							->where(array('P.STATUS' => 1, 'P.JENIS_PERENCANAAN' => 'APM', 'P.ID_USER' => $id_user))
				 			->get();					
		return $query->result_array();
	}

	public function notif_rcm($id_user)
	{
		$query = $this->db->select('*')
							->from('PEMERIKSA P')
							->join('RCM', 'RCM.ID_RCM = P.ID_PERENCANAAN', 'LEFT')
							->join('SPA', 'RCM.ID_SPA = SPA.ID_SPA', 'LEFT')
							->where(array('P.STATUS' => 1, 'P.JENIS_PERENCANAAN' => 'RCM', 'P.ID_USER' => $id_user))
				 			->get();					
		return $query->result_array();
	}

	public function notif_pka($id_user)
	{
		$query = $this->db->select('PKA.ID_PKA, PKA.NOMOR_PKA, PKA.TANGGAL')
							->from('PEMERIKSA P')
							->join('PKA', 'PKA.ID_PKA = P.ID_PERENCANAAN', 'LEFT')
							->where(array('P.STATUS' => 1, 'P.JENIS_PERENCANAAN' => 'PKA', 'P.ID_USER' => $id_user))
				 			->get();					
		return $query->result_array();
	}

	public function notif_lainnya()
	{
		$query = $this->db->select('td.NAMA_DIVISI, tr.updated_at, tr.ID as ID_REKOMENDASI, te.ID_TL')
							->from('TL_REKOMENDASI tr')
							->join('TL_TEMUAN tt', 'tr.ID_TEMUAN = tt.ID', 'LEFT')
							->join('TL_ENTRY te', 'tt.ID_TL = te.ID_TL', 'LEFT')
							->join('TM_DIVISI td', 'te.AUDITEE = td.ID_DIVISI', 'LEFT')
							->where('tr.IS_APPROVE !=', 1)
							->where('tr.HASIL_MONITORING !=', NULL)
				 			->order_by('tr.updated_at', 'DESC')->get();					
		return $query->result_array();
	}

	public function notif_rekom()
	{
		$query = $this->db->select('td.NAMA_DIVISI, tr.updated_at, tr.ID as ID_REKOMENDASI, te.ID_TL')
							->from('TL_REKOMENDASI tr')
							->join('TL_TEMUAN tt', 'tr.ID_TEMUAN = tt.ID', 'LEFT')
							->join('TL_ENTRY te', 'tt.ID_TL = te.ID_TL', 'LEFT')
							->join('TM_DIVISI td', 'te.AUDITEE = td.ID_DIVISI', 'LEFT')
							->join('PIC_REKOMENDASI pic', 'pic.ID_REKOMENDASI = tr.ID', 'LEFT')
							->where('tr.STATUS', 1)
							->where('tt.STATUS', 1)
							->where('pic.PIC', $this->session->ID_JABATAN)
							->where('tr.TK_PENYELESAIAN !=', 'Selesai')
							->where('tr.TK_PENYELESAIAN !=', 'TPTD')
							// ->where('pic.READ_AT', NULL)
				 			->order_by('tr.updated_at', 'DESC')->get();			
				 			// print_r($this->db->last_query());		die();
		return $query->result_array();
	}

	public function last_login($username)
	{
		$this->db->set('"LAST_LOGIN"', 'CURRENT_TIMESTAMP', FALSE);
		$this->db->where('NIPP', $username);
		$this->db->update('TM_USER');
	}

	public function save_log_perencanaan($id, $jenis, $log)
	{
		$data = [
			'ID_PERENCANAAN' 	=> $id,
			'JENIS_PERENCANAAN' => $jenis,
			'LOG' 				=> $log,
			'TGL_LOG' 			=> date('Y-m-d H:i:s'),
		];
		$this->db->insert('LOG_PERENCANAAN', $data);
	}

	public function log_by_id_perencanaan($id, $jenis)
	{
		$this->db->where('JENIS_PERENCANAAN', $jenis);
		$this->db->where('ID_PERENCANAAN', $id);
		return $this->db->order_by('TGL_LOG desc')->get('LOG_PERENCANAAN')->result_array();
	}

}
?>