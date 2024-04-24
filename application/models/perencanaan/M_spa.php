<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
class M_spa extends CI_Model
{

	private $_table = "SPA";

	public function kotak_keluar($id_pembuat)
	{
		$query = 'SELECT SPA.*, DV."NAMA_DIVISI", S."STATUS" AS "STATUS", S."CSS" AS "CSS", (select count(*) from "PEMERIKSA" p2 where p2."ID_PERENCANAAN" = SPA."ID_SPA" and p2."JENIS_PERENCANAAN"  = ' . "'SPA'" . ' ) as "APPROVER_COUNT",(select count(*) from "PEMERIKSA" p2 where p2."ID_PERENCANAAN" = SPA."ID_SPA" and p2."JENIS_PERENCANAAN" = ' . "'SPA'" . ' and p2."STATUS" = 2) as "APPROVED_COUNT", (select p2."STATUS" from "PEMERIKSA" p2 where p2."ID_PERENCANAAN" = SPA."ID_SPA" and p2."JENIS_PERENCANAAN" = ' . "'SPA'" . ' and p2."ID_USER" = ' . "'$id_pembuat'" . ') as "STATUS_APPROVER" FROM "SPA" SPA LEFT JOIN "TM_DIVISI" DV ON DV."ID_DIVISI" = SPA."AUDITEE" LEFT JOIN "TM_STATUS" S ON S."ID_STATUS" = SPA."ID_STATUS" WHERE SPA."ID_PEMBUAT" = ' . "'$id_pembuat'" . ' order by SPA."CREATED_AT" desc, SPA."ID_SPA" desc';
		// if($id_spa != '') $query .= ' AND SPA."ID_SPA" = '."'$id_spa'";

		$exec  = $this->db->query($query);
		return $exec->result_array();
	}

	public function spa_list()
	{
		$query = $this->db->select('spa.*, s.STATUS as STATUS, s.CSS')
							->from('SPA spa')
							->join('TM_STATUS s', 's.ID_STATUS = spa.ID_STATUS', 'LEFT')
							->where('spa.NOMOR_SURAT IS NOT NULL')
							->where('spa.ID_STATUS', 3)
							->order_by('spa.NOMOR_SURAT', 'ASC')
							->get()->result_array();
		return $query;
	}

	// public function spa_list_unique()
	// {
	// 	$query1 = $this->db->query('SELECT "NOMOR_SPA" FROM "TL_ENTRY" WHERE "STATUS" = 1');
	//   $query1_result = $query1->result();
	//   $room_id= array();
	//   foreach($query1_result as $row){
	//      $room_id[] = $row->rooms;
	//    }
	//   $room = implode(",",$room_id);
	//   $no_surat_arr = explode(",", $room);

	// 	$query = $this->db->select('spa.*, s.STATUS as STATUS, s.CSS')
	// 						->from('SPA spa')
	// 						->join('TM_STATUS s', 's.ID_STATUS = spa.ID_STATUS', 'LEFT')
	// 						->where('spa.NOMOR_SURAT IS NOT NULL')
	// 						->where('spa.ID_STATUS', 3)
	// 						->where_not_in('spa.NOMOR_SURAT', $no_surat_arr)
	// 						->order_by('spa.NOMOR_SURAT', 'ASC')
	// 						->get()->result_array();
	// 	return $query;
	// }

	public function kotak_masuk($id_user, $id_spa = '')
	{
		$query = 'SELECT DISTINCT SPA."NOMOR_SURAT", SPA.*, DV."NAMA_DIVISI", S."STATUS" AS "STATUS", S."CSS" AS "CSS", (select count(*) from "PEMERIKSA" p2 where p2."ID_PERENCANAAN" = SPA."ID_SPA" and p2."JENIS_PERENCANAAN"  = ' . "'SPA'" . ' ) as "APPROVER_COUNT",(select count(*) from "PEMERIKSA" p2 where p2."ID_PERENCANAAN" = SPA."ID_SPA" and p2."JENIS_PERENCANAAN" = ' . "'SPA'" . ' and p2."STATUS" = 2) as "APPROVED_COUNT", (select p2."STATUS" from "PEMERIKSA" p2 where p2."ID_PERENCANAAN" = SPA."ID_SPA" and p2."JENIS_PERENCANAAN" = ' . "'SPA'" . ' and p2."ID_USER" = ' . "'$id_user'" . ') as "STATUS_APPROVER" FROM "SPA" SPA LEFT JOIN "TM_DIVISI" DV ON DV."ID_DIVISI" = SPA."AUDITEE" LEFT JOIN "TM_STATUS" S ON S."ID_STATUS" = SPA."ID_STATUS" LEFT JOIN "PEMERIKSA" P ON P."ID_PERENCANAAN" = SPA."ID_SPA" WHERE SPA."ID_STATUS" IN (2, 3, 4) AND  P."STATUS" != 0 AND  P."JENIS_PERENCANAAN" = ' . "'SPA'" . ' AND P."ID_USER" = ' . "'$id_user'"
			. ' UNION 
				SELECT DISTINCT SPA."NOMOR_SURAT", SPA.*, DV."NAMA_DIVISI", S."STATUS" AS "STATUS", S."CSS" AS "CSS",
(select count(*) from "PEMERIKSA" p2 where p2."ID_PERENCANAAN" = SPA."ID_SPA" and p2."JENIS_PERENCANAAN"  = ' . "'SPA'" . ' ) as "APPROVER_COUNT",
(select count(*) from "PEMERIKSA" p2 where p2."ID_PERENCANAAN" = SPA."ID_SPA" and p2."JENIS_PERENCANAAN" = ' . "'SPA'" . ' and p2."STATUS" = 2) as "APPROVED_COUNT", 
(select p2."STATUS" from "PEMERIKSA" p2 where p2."ID_PERENCANAAN" = SPA."ID_SPA" and p2."JENIS_PERENCANAAN" = ' . "'SPA'" . ' AND p2."ID_USER" = ' . "'$id_user'" . ') as "STATUS_APPROVER" 
FROM "SPA" SPA LEFT JOIN "TM_STATUS" S ON S."ID_STATUS" = SPA."ID_STATUS" 
LEFT JOIN "TM_DIVISI" DV ON DV."ID_DIVISI" = SPA."AUDITEE"
LEFT JOIN "PEMERIKSA" P ON P."ID_PERENCANAAN" = SPA."ID_SPA" 
LEFT JOIN "TIM_AUDIT" TA ON TA."ID_PERENCANAAN" = SPA."ID_SPA"
WHERE SPA."ID_STATUS" IN (3) AND  P."STATUS" != 0 AND
(select count(*) from "PEMERIKSA" p2 where p2."ID_PERENCANAAN" = SPA."ID_SPA" and p2."JENIS_PERENCANAAN"  = ' . "'SPA'" . ' ) = 
(select count(*) from "PEMERIKSA" p2 where p2."ID_PERENCANAAN" = SPA."ID_SPA" and p2."JENIS_PERENCANAAN" = ' . "'SPA'" . ' and p2."STATUS" = 2) AND
  P."JENIS_PERENCANAAN" = ' . "'SPA'" . ' AND TA."ID_USER" = ' . "'$id_user'";
		// print_r($query);die();
		if ($id_spa != '') $query .= ' AND SPA."ID_SPA" = ' . "'$id_spa'" . ' order by SPA."ID_SPA" desc';
		$exec = $this->db->query($query);
		return $exec->result_array();
	}

	public function status_approver($id_user, $id_spa)
	{
		$query  = 'SELECT P."STATUS" AS "STATUS_APPROVER" FROM "PEMERIKSA" P WHERE P."ID_PERENCANAAN" = ' . "'$id_spa'" . ' AND P."ID_USER" = ' . "'$id_user'" . ' AND P."JENIS_PERENCANAAN" = ' . "'SPA'";
		$exec                        = $this->db->query($query);
		return $exec->row();
	}

	public function spa_detail($id_spa)
	{
		$query  = 'SELECT P."STATUS" AS "STATUS_APPROVER" ,(select count(*) from "PEMERIKSA" p2 where p2."ID_PERENCANAAN" = ' . "'$id_spa'" . ' and p2."JENIS_PERENCANAAN"  = ' . "'SPA'" . ' ) as "APPROVER_COUNT",(select count(*) from "PEMERIKSA" p2 where p2."ID_PERENCANAAN" = ' . "'$id_spa'" . ' and p2."JENIS_PERENCANAAN" = ' . "'SPA'" . ' and p2."STATUS" = 2) as "APPROVED_COUNT", SPA.*, S."STATUS" AS "STATUS", S."CSS" AS "CSS", P."KOMENTAR" AS "KOMENTAR" FROM "SPA" SPA LEFT JOIN "TM_STATUS" S ON S."ID_STATUS" = SPA."ID_STATUS" LEFT JOIN "PEMERIKSA" P ON P."ID_PERENCANAAN" = SPA."ID_SPA" WHERE SPA."ID_SPA" = ' . "'$id_spa'" . ' AND P."JENIS_PERENCANAAN" = ' . "'SPA'";
		// if($id_spa != '') $query .= ' AND SPA."ID_SPA" = '."'$id_spa'";
		$exec                        = $this->db->query($query);
		return $exec->row();
	}

	function cari($id_spa = '')
	{
		$query                       = 'SELECT SPA.*, S."STATUS" AS "STATUS", S."CSS" AS "CSS" FROM "SPA" SPA LEFT JOIN "TM_STATUS" S ON S."ID_STATUS" = SPA."ID_STATUS" WHERE SPA."NOMOR_SURAT" IS NOT NULL AND SPA."ID_STATUS" = 3';
		if ($id_spa != '') $query 	.= ' AND SPA."ID_SPA" = ' . "'$id_spa'";
		$exec                        = $this->db->query($query);
		return $exec;
	}

	public function get_tim($id = false)
	{
		$this->db->select('p.NAMA, l.JABATAN');
		$this->db->from('TIM_AUDIT l');
		$this->db->join('TM_USER p', 'p.ID_USER=l.ID_USER', 'left');
		$this->db->where('l.JENIS_PERENCANAAN', 'SPA');
		$this->db->order_by('l.NO_URUT', 'ASC');
		return $this->db->where('l.ID_PERENCANAAN', $id)->get()->result_array();
	}

	public function get_tembusan($id = false)
	{
		$this->db->select('TEMBUSAN');
		$this->db->from('TEMBUSAN');
		$this->db->where('JENIS_PERENCANAAN', 'SPA');
		return $this->db->where('ID_PERENCANAAN', $id)->get()->result_array();
	}
	public function get_dasar($id = false)
	{
		$this->db->select('DASAR');
		$this->db->from('DASAR_AUDIT');
		$this->db->where('JENIS_PERENCANAAN', 'SPA');
		return $this->db->where('ID_PERENCANAAN', $id)->get()->result_array();
	}
	public function get_perintah($id = false)
	{
		$this->db->select('PERINTAH');
		$this->db->from('PERINTAH_AUDIT');
		$this->db->where('JENIS_PERENCANAAN', 'SPA');
		return $this->db->where('ID_PERENCANAAN', $id)->get()->result_array();
	}

	public function last_id_spa()
	{
		$query  = 'SELECT MAX("ID_SPA") FROM "SPA"';
		$exec   = $this->db->query($query);
		return $exec->row();
	}

	public function add($data, $table)
	{
		$this->db->insert($table, $data);
	}

	public function update($data, $array_where, $table = 'SPA')
	{
		$this->db->where($array_where);
		$this->db->update($table, $data);
	}

	public function is_exist($no_surat)
	{
		$this->db->where('NOMOR_SURAT', $no_surat);
		$this->db->from($this->_table);
		$count = $this->db->count_all_results();
		return $count;
	}

	public function save($data_spa, $tim_audit, $jabatan_tim, $dasar_audit, $perintah_audit, $tembusan)
	{
		$this->db->trans_start();

		if ($this->is_exist($data_spa['NOMOR_SPA_SEQ']) > 0)
			return 0;
		// insert table spa
		$this->db->insert($this->_table, $data_spa);
		$id_spa = $this->db->insert_id();

		// insert table tim_audit
		$data_perencanaan = [
			'ID_PERENCANAAN' 	=> $id_spa,
			'JENIS_PERENCANAAN' => $this->_table,
		];
		foreach ($dasar_audit as $value) {
			$data = [
				'ID_PERENCANAAN' 	=> $id_spa,
				'JENIS_PERENCANAAN' => $this->_table,
				'DASAR' 	=> $value,
			];
			$this->db->insert('DASAR_AUDIT', $data);
		}
		foreach ($perintah_audit as $value) {
			$data = [
				'ID_PERENCANAAN' 	=> $id_spa,
				'JENIS_PERENCANAAN' => $this->_table,
				'PERINTAH' 	=> $value,
			];
			$this->db->insert('PERINTAH_AUDIT', $data);
		}
		foreach ($tembusan as $value) {
			$data = [
				'ID_PERENCANAAN' 	=> $id_spa,
				'JENIS_PERENCANAAN' => $this->_table,
				'TEMBUSAN' 	=> $value,
			];
			$this->db->insert('TEMBUSAN', $data);
		}
		$data_tim_audit = $data_perencanaan;
		$tmp_tim_audit = [];
		foreach ($tim_audit as $key => $value) {
			$data_tim_audit['ID_USER'] = $value;
			$data_tim_audit['NO_URUT'] = $key + 1;
			$data_tim_audit['JABATAN'] = '';
			$tmp_tim_audit[$key] = $data_tim_audit;
		}
		foreach ($jabatan_tim as $key => $value) {
			$tmp_tim_audit[$key]['JABATAN'] = $value;
		}

		foreach ($tmp_tim_audit as $tim_audit) {
			$this->add($tim_audit, 'TIM_AUDIT');
		}

		//insert init control sheet
		$this->add(['ID_SPA' => $id_spa], 'CONTROL_SHEET');

		// insert pemeriksa
		$this->insertorupdate_pemeriksa($data_perencanaan, $data_spa);

		$this->db->trans_complete();
		return 1;
	}

	public function send_update($data_spa, $tim_audit, $jabatan_tim, $dasar_audit, $perintah_audit, $id_spa, $tembusan)
	{
		$this->db->trans_start();

		$this->update($data_spa, ['ID_SPA' => $id_spa]);
		$data_perencanaan = [
			'ID_PERENCANAAN' 	=> $id_spa,
			'JENIS_PERENCANAAN' => $this->_table,
		];
		$this->db->delete('DASAR_AUDIT', $data_perencanaan);
		foreach ($dasar_audit as $value) {
			$data = [
				'ID_PERENCANAAN' 	=> $id_spa,
				'JENIS_PERENCANAAN' => $this->_table,
				'DASAR' 	=> $value,
			];
			$this->db->insert('DASAR_AUDIT', $data);
		}
		$this->db->delete('PERINTAH_AUDIT', $data_perencanaan);
		foreach ($perintah_audit as $value) {
			$data = [
				'ID_PERENCANAAN' 	=> $id_spa,
				'JENIS_PERENCANAAN' => $this->_table,
				'PERINTAH' 	=> $value,
			];
			$this->db->insert('PERINTAH_AUDIT', $data);
		}
		$this->db->delete('TEMBUSAN', $data_perencanaan);
		foreach ($tembusan as $value) {
			$data = [
				'ID_PERENCANAAN' 	=> $id_spa,
				'JENIS_PERENCANAAN' => $this->_table,
				'TEMBUSAN' 	=> $value,
			];
			$this->db->insert('TEMBUSAN', $data);
		}
		$this->db->delete('TIM_AUDIT', $data_perencanaan);
		$data_tim_audit = $data_perencanaan;
		$tmp_tim_audit = [];
		foreach ($tim_audit as $key => $value) {
			$data_tim_audit['ID_USER'] = $value;
			$data_tim_audit['NO_URUT'] = $key + 1;
			$data_tim_audit['JABATAN'] = '';
			$tmp_tim_audit[$key] = $data_tim_audit;
		}
		foreach ($jabatan_tim as $key => $value) {
			$tmp_tim_audit[$key]['JABATAN'] = $value;
		}

		foreach ($tmp_tim_audit as $tim_audit) {
			$this->add($tim_audit, 'TIM_AUDIT');
		}
		$this->insertorupdate_pemeriksa($data_perencanaan, $data_spa, true);

		$this->db->trans_complete();
	}

	public function approval($data_spa, $pemeriksa, $id_spa, $dasar_audit, $perintah_audit, $tim_audit, $jabatan_tim, $tembusan)
	{
		$this->db->trans_start();

		$this->db->where('ID_SPA', $id_spa);
		$this->db->update($this->_table, $data_spa);

		$where_dasar_perintah = [
			'ID_PERENCANAAN' 	=> $id_spa,
			'JENIS_PERENCANAAN' => $this->_table,
		];
		$this->db->delete('DASAR_AUDIT', $where_dasar_perintah);
		foreach ($dasar_audit as $value) {
			$data = [
				'ID_PERENCANAAN' 	=> $id_spa,
				'JENIS_PERENCANAAN' => $this->_table,
				'DASAR' 	=> $value,
			];
			$this->db->insert('DASAR_AUDIT', $data);
		}
		$this->db->delete('PERINTAH_AUDIT', $where_dasar_perintah);
		foreach ($perintah_audit as $value) {
			$data = [
				'ID_PERENCANAAN' 	=> $id_spa,
				'JENIS_PERENCANAAN' => $this->_table,
				'PERINTAH' 	=> $value,
			];
			$this->db->insert('PERINTAH_AUDIT', $data);
		}
		$this->db->delete('TEMBUSAN', $where_dasar_perintah);
		foreach ($tembusan as $value) {
			$data = [
				'ID_PERENCANAAN' 	=> $id_spa,
				'JENIS_PERENCANAAN' => $this->_table,
				'TEMBUSAN' 	=> $value,
			];
			$this->db->insert('TEMBUSAN', $data);
		}
		$this->db->delete('TIM_AUDIT', $where_dasar_perintah);
		$data_tim_audit = $data_perencanaan;
		$tmp_tim_audit = [];
		foreach ($tim_audit as $key => $value) {
			$data_tim_audit['ID_PERENCANAAN'] = $id_spa;
			$data_tim_audit['JENIS_PERENCANAAN'] = $this->_table;
			$data_tim_audit['ID_USER'] = $value;
			$data_tim_audit['NO_URUT'] = $key + 1;
			$data_tim_audit['JABATAN'] = '';
			$tmp_tim_audit[$key] = $data_tim_audit;
		}
		foreach ($jabatan_tim as $key => $value) {
			$tmp_tim_audit[$key]['JABATAN'] = $value;
		}

		foreach ($tmp_tim_audit as $tim_audit) {
			$this->add($tim_audit, 'TIM_AUDIT');
		}
		$this->db->select('ID_PEMBUAT');
		$this->db->where('ID_SPA', $id_spa);
		$data_user = $this->db->get($this->_table)->row();
		$atasan = $this->get_atasan($data_user->ID_PEMBUAT);
		if (!empty($atasan)) {
			$atasan1 = $atasan->ATASAN_I;
			$atasan2 = $atasan->ATASAN_II;

			$array_where = [
				'ID_PERENCANAAN' => $id_spa,
				'JENIS_PERENCANAAN' => $this->_table,
				'NO_URUT' => 1,
			];

			if (!!$atasan1 && $atasan1 == $pemeriksa['ID_USER']) {
				if ($data_spa['ID_STATUS'] == 3) {
					$data_pemeriksa = ['STATUS' => 2, 'KOMENTAR' => $pemeriksa['KOMENTAR']];
					$this->update($data_pemeriksa, $array_where, 'PEMERIKSA');
					$data_tanggal = ['TANGGAL' => date('Y-m-d')];
					$this->update($data_tanggal, $array_where, 'PEMERIKSA');
					$array_where['NO_URUT'] = 2;
					$data_pemeriksa['STATUS'] = 1;
					$this->update($data_pemeriksa, $array_where, 'PEMERIKSA');
				} elseif ($data_spa['ID_STATUS'] == 4) {
					$data_pemeriksa = ['STATUS' => 3, 'KOMENTAR' => $pemeriksa['KOMENTAR']];
					$this->update($data_pemeriksa, $array_where, 'PEMERIKSA');
					$data_tanggal = ['TANGGAL' => date('Y-m-d')];
					$this->update($data_tanggal, $array_where, 'PEMERIKSA');
					$array_where['NO_URUT'] = 2;
					$data_pemeriksa['STATUS'] = 0;
					$this->update($data_pemeriksa, $array_where, 'PEMERIKSA');
				}
			} elseif (!!$atasan2 && $atasan2 == $pemeriksa['ID_USER']) {
				if ($data_spa['ID_STATUS'] == 3) {
					$array_where['NO_URUT'] = 2;
					$data_pemeriksa = ['STATUS' => 2, 'KOMENTAR' => $pemeriksa['KOMENTAR'], 'TANGGAL' => date('Y-m-d')];
					$this->update($data_pemeriksa, $array_where, 'PEMERIKSA');
					$data_cs = ['TGL_DISETUJUI' => date('Y-m-d')];
					$where = [
						'ID_SPA' => $id_spa,
					];
					$this->update($data_cs, $where, 'CONTROL_SHEET');
				} elseif ($data_spa['ID_STATUS'] == 4) {
					$data_pemeriksa = ['STATUS' => 1, 'KOMENTAR' => $pemeriksa['KOMENTAR']];
					$this->update($data_pemeriksa, $array_where, 'PEMERIKSA');
					$array_where['NO_URUT'] = 2;
					$data_pemeriksa['STATUS'] = 3;
					$this->update($data_pemeriksa, $array_where, 'PEMERIKSA');
					$data_tanggal = ['TANGGAL' => date('Y-m-d')];
					$this->update($data_tanggal, $array_where, 'PEMERIKSA');
				}
			}
		}
		$this->db->trans_complete();
	}


	public function insertorupdate_pemeriksa($data_perencanaan, $data, $update = false)
	{
		$pemeriksa = $data_perencanaan;
		$atasan = $this->get_atasan($data['ID_PEMBUAT']);
		$no_urut = 1;
		foreach ($atasan as $key => $item) {
			if (!!$item) {
				$data_update['STATUS'] = 0;
				if ($key == 'ATASAN_I' && $data['ID_STATUS'] != 1)
					$data_update['STATUS'] = 1;

				$pemeriksa['ID_USER'] = $item;
				$pemeriksa['NO_URUT'] = $no_urut++;

				if ($update) {
					$this->update($data_update, $pemeriksa, 'PEMERIKSA');
				} else {
					$pemeriksa['STATUS'] = $data_update['STATUS'];
					$this->add($pemeriksa, 'PEMERIKSA');
				}
			}
		}
	}

	public function get_atasan($id_user)
	{
		$this->db->select('ATASAN_I, ATASAN_II');
		$this->db->where('ID_USER', $id_user);
		$query = $this->db->get('TM_USER')->row();
		return $query;
	}

	public function get_last_spa_no()
	{
		$query  = 'select  s."ID_SPA", s."NOMOR_SPA_SEQ" from "SPA" s where TO_CHAR(s."CREATED_AT",\'YYYY\')::integer = ' . date('Y') . ' order by s."ID_SPA" desc limit 1';
		return $this->db->query($query)->row_array();
	}
}
