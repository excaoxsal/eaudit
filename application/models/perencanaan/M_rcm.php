<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
class M_rcm extends CI_Model
{

	private $_table 	= "RCM";

	public function get_rcm($id_pembuat)
	{
		$query = 'SELECT RCM.*, S."STATUS" AS "STATUS", S."CSS" AS "CSS",(select p2."STATUS" from "PEMERIKSA" p2 where p2."ID_PERENCANAAN" = RCM."ID_RCM" and p2."JENIS_PERENCANAAN"  = ' . "'RCM'" . ' and p2."NO_URUT" = 1) as "STATUS_ATASAN_I", (select count(*) from "PEMERIKSA" p2 where p2."ID_PERENCANAAN" = RCM."ID_RCM" and p2."JENIS_PERENCANAAN"  = ' . "'RCM'" . ' ) as "APPROVER_COUNT",(select count(*) from "PEMERIKSA" p2 where p2."ID_PERENCANAAN" = RCM."ID_RCM" and p2."JENIS_PERENCANAAN" = ' . "'RCM'" . ' and p2."STATUS" = 2) as "APPROVED_COUNT", (select p2."STATUS" from "PEMERIKSA" p2 where p2."ID_PERENCANAAN" = RCM."ID_RCM" and p2."JENIS_PERENCANAAN" = ' . "'RCM'" . ' and p2."ID_USER" = ' . "'$id_pembuat'" . ') as "STATUS_APPROVER" FROM "RCM" RCM LEFT JOIN "TM_STATUS" S ON S."ID_STATUS" = RCM."ID_STATUS" WHERE RCM."ID_PEMBUAT" = ' . "'$id_pembuat'" . ' order by RCM."ID_RCM" desc';
		$exec  = $this->db->query($query);
		return $exec->result_array();
	}

	public function rcm_detail($id_rcm)
	{
		$this->db->select('p.*, ts.STATUS, ts.CSS, pr.KOMENTAR');
		$this->db->from('RCM p');
		$this->db->join('TM_STATUS ts', 'ts.ID_STATUS=p.ID_STATUS', 'left');
		$this->db->join('PEMERIKSA pr', 'pr.ID_PERENCANAAN=p.ID_RCM', 'left');
		$this->db->where('p.ID_RCM', $id_rcm);
		$this->db->where('pr.JENIS_PERENCANAAN', 'RCM');
		return $this->db->get()->row();
	}

	public function kotak_masuk($id_user)
	{
		$query = 'SELECT RCM.*, S."STATUS" AS "STATUS", S."CSS" AS "CSS", (select count(*) from "PEMERIKSA" p2 where p2."ID_PERENCANAAN" = RCM."ID_RCM" and p2."JENIS_PERENCANAAN"  = ' . "'RCM'" . ' ) as "APPROVER_COUNT",(select count(*) from "PEMERIKSA" p2 where p2."ID_PERENCANAAN" = RCM."ID_RCM" and p2."JENIS_PERENCANAAN" = ' . "'RCM'" . ' and p2."STATUS" = 2) as "APPROVED_COUNT", (select p2."STATUS" from "PEMERIKSA" p2 where p2."ID_PERENCANAAN" = RCM."ID_RCM" and p2."JENIS_PERENCANAAN" = ' . "'RCM'" . ' and p2."ID_USER" = ' . "'$id_user'" . ') as "STATUS_APPROVER" FROM "RCM" RCM LEFT JOIN "TM_STATUS" S ON S."ID_STATUS" = RCM."ID_STATUS" LEFT JOIN "PEMERIKSA" P ON P."ID_PERENCANAAN" = RCM."ID_RCM" WHERE RCM."ID_STATUS" IN (2, 3, 4) AND  P."STATUS" != 0 AND  P."JENIS_PERENCANAAN" = ' . "'RCM'" . ' AND P."ID_USER" = ' . "'$id_user'" . '
				UNION 
				SELECT RCM.*, S."STATUS" AS "STATUS", S."CSS" AS "CSS", (select count(*) from "PEMERIKSA" p2 where p2."ID_PERENCANAAN" = RCM."ID_RCM" and p2."JENIS_PERENCANAAN"  = ' . "'RCM'" . ' ) as "APPROVER_COUNT",(select count(*) from "PEMERIKSA" p2 where p2."ID_PERENCANAAN" = RCM."ID_RCM" and p2."JENIS_PERENCANAAN" = ' . "'RCM'" . ' and p2."STATUS" = 2) as "APPROVED_COUNT", (select p2."STATUS" from "PEMERIKSA" p2 where p2."ID_PERENCANAAN" = RCM."ID_RCM" and p2."JENIS_PERENCANAAN" = ' . "'RCM'" . ' and p2."ID_USER" = ' . "'$id_user'" . ') as "STATUS_APPROVER" FROM "RCM" RCM LEFT JOIN "TM_STATUS" S ON S."ID_STATUS" = RCM."ID_STATUS" LEFT JOIN "TIM_AUDIT" P ON P."ID_PERENCANAAN" = RCM."ID_SPA" WHERE RCM."ID_STATUS" IN (2, 3, 4) AND
(select count(*) from "PEMERIKSA" p2 where p2."ID_PERENCANAAN" = RCM."ID_RCM" and p2."JENIS_PERENCANAAN"  = ' . "'RCM'" . ' ) = 
(select count(*) from "PEMERIKSA" p2 where p2."ID_PERENCANAAN" = RCM."ID_RCM" and p2."JENIS_PERENCANAAN" = ' . "'RCM'" . ' and p2."STATUS" = 2)  AND P."ID_USER" = ' . "'$id_user'";

		$exec = $this->db->query($query);
		return $exec->result_array();
	}

	public function get_spa($id_rcm)
	{
		$this->db->select('s.NOMOR_SURAT');
		$this->db->from('RCM p');
		$this->db->join('SPA s', 's.ID_SPA=p.ID_SPA', 'left');
		$this->db->where('p.ID_RCM', $id_rcm);
		$data_rcm = $this->db->get()->row();
		return $data_rcm;
	}

	public function get_pemeriksa($id_rcm)
	{
		$where = [
			'ID_PERENCANAAN' 	=> $id_rcm,
			'JENIS_PERENCANAAN' => $this->_table,
		];
		$this->db->select('p.*, u.TANDA_TANGAN');
		$this->db->from('PEMERIKSA p');
		$this->db->join('TM_USER u', 'p.ID_USER=u.ID_USER', 'left');
		$this->db->where($where);
		$this->db->order_by('p.NO_URUT', 'ASC');
		$data_rcm = $this->db->get()->result_array();
		return $data_rcm;
	}

	public function add($data, $table)
	{
		$this->db->insert($table, $data);
	}

	public function update($data, $array_where, $table = 'RCM')
	{
		$this->db->where($array_where);
		$this->db->update($table, $data);
	}

	public function add_proses($data, $id_peroses)
	{
		if (empty($id_peroses))
			$this->add($data, 'RCM_ADD_PROSES');
		else
			$this->update($data, ['ID_RCM_ADD_PROSES' => $id_peroses], 'RCM_ADD_PROSES');
	}

	public function delete_proses($id)
	{
		$this->db->where('ID_RCM_ADD_PROSES', $id);
		$this->db->delete('RCM_ADD_PROSES');
	}

	public function delete_all_proses($id_pembuat)
	{
		$this->db->where('ID_PEMBUAT', $id_pembuat);
		$this->db->where('ID_RCM', 0);
		$this->db->delete('RCM_ADD_PROSES');
	}

	public function get_add_proses($id_pembuat, $id_peroses, $id_rcm = '')
	{
		$this->db->select('rap.*, tr.RESIKO as "TR_RESIKO"');
		$this->db->from('RCM_ADD_PROSES rap');
		$this->db->join('TM_RESIKO tr', 'tr.ID_RESIKO=rap.PRIORITAS_RESIKO', 'left');
		// if ($id_pembuat != null)
		// 	$this->db->where('rap.ID_PEMBUAT', $id_pembuat);
		if ($id_peroses != null)
			$this->db->where('rap.ID_RCM_ADD_PROSES', $id_peroses);
		$this->db->where('rap.ID_RCM', $id_rcm);
		$this->db->order_by('rap.ID_RCM_ADD_PROSES');
		if ($id_peroses != null)
			$data_add_proses = $this->db->get()->row();
		else
			$data_add_proses = $this->db->get()->result_array();
		return $data_add_proses;
	}

	public function save($data)
	{
		$this->db->trans_start();

		// insert table rcm
		$this->db->insert($this->_table, $data);
		$id_rcm = $this->db->insert_id();

		$data_perencanaan = [
			'ID_PERENCANAAN' 	=> $id_rcm,
			'JENIS_PERENCANAAN' => $this->_table,
		];

		$this->update(['ID_RCM' => $id_rcm], ['ID_RCM' => 0, 'ID_PEMBUAT' => $data['ID_PEMBUAT']], 'RCM_ADD_PROSES');

		// insert pemeriksa
		$this->insertorupdate_pemeriksa($data_perencanaan, $data);

		$this->db->trans_complete();
		return 1;
	}

	public function send_update($data, $id_rcm)
	{
		$this->db->trans_start();
		$this->db->select('ID_SPA');
		$this->db->where('ID_RCM', $id_rcm);
		$data_rcm = $this->db->get($this->_table)->row();

		$this->update($data, ['ID_RCM' => $id_rcm]);

		$data_perencanaan = [
			'ID_PERENCANAAN' 	=> $id_rcm,
			'JENIS_PERENCANAAN' => $this->_table,
		];

		$data['ID_SPA'] = $data_rcm->ID_SPA;
		$this->insertorupdate_pemeriksa($data_perencanaan, $data, true);

		$this->db->trans_complete();
	}

	public function approval($data, $pemeriksa, $id_rcm)
	{
		$this->db->trans_start();

		$this->db->select('ID_SPA');
		$this->db->where('ID_RCM', $id_rcm);
		$data_rcm = $this->db->get($this->_table)->row();
		$id_spa = $data_rcm->ID_SPA;;

		$this->update($data, ['ID_RCM' => $id_rcm]);

		$atasan = $this->get_atasan($data_rcm->ID_SPA);
		if (!empty($atasan)) {
			$atasan1 = $atasan['ATASAN_I'];
			$atasan2 = $atasan['ATASAN_II'];

			$array_where = [
				'ID_PERENCANAAN' => $id_rcm,
				'JENIS_PERENCANAAN' => $this->_table,
				'NO_URUT' => 1,
			];

			if (!!$atasan1 && $atasan1 == $pemeriksa['ID_USER']) {
				if ($data['ID_STATUS'] == 3) {
					$data_pemeriksa = ['STATUS' => 2, 'KOMENTAR' => $pemeriksa['KOMENTAR'], 'TANGGAL' => $pemeriksa['TANGGAL']];
					$this->update($data_pemeriksa, $array_where, 'PEMERIKSA');
					$array_where['NO_URUT'] = 2;
					$data_pemeriksa['STATUS'] = 1;
					$data_pemeriksa['TANGGAL'] = null;
					$data_pemeriksa['KOMENTAR'] = null;
					$this->update($data_pemeriksa, $array_where, 'PEMERIKSA');
				} elseif ($data['ID_STATUS'] == 4) {
					$data_pemeriksa = ['STATUS' => 3, 'KOMENTAR' => $pemeriksa['KOMENTAR']];
					$this->update($data_pemeriksa, $array_where, 'PEMERIKSA');
					$array_where['NO_URUT'] = 2;
					$data_pemeriksa['STATUS'] = 0;
					$this->update($data_pemeriksa, $array_where, 'PEMERIKSA');
				}
			} elseif (!!$atasan2 && $atasan2 == $pemeriksa['ID_USER']) {
				if ($data['ID_STATUS'] == 3) {
					$array_where['NO_URUT'] = 2;
					$data_pemeriksa = ['STATUS' => 2, 'KOMENTAR' => $pemeriksa['KOMENTAR'], 'TANGGAL' => $pemeriksa['TANGGAL']];
					$this->update($data_pemeriksa, $array_where, 'PEMERIKSA');
					$data_cs = ['TGL_RCM_DISUSUN' => date('Y-m-d')];
					$where = [
						'ID_SPA' => $id_spa,
					];
					$this->update($data_cs, $where, 'CONTROL_SHEET');
				} elseif ($data['ID_STATUS'] == 4) {
					$data_pemeriksa = ['STATUS' => 1, 'KOMENTAR' => $pemeriksa['KOMENTAR']];
					$this->update($data_pemeriksa, $array_where, 'PEMERIKSA');
					$array_where['NO_URUT'] = 2;
					$data_pemeriksa['STATUS'] = 3;
					$this->update($data_pemeriksa, $array_where, 'PEMERIKSA');
				}
			}
		}
		$this->db->trans_complete();
	}


	public function insertorupdate_pemeriksa($data_perencanaan, $data, $update = false)
	{
		$pemeriksa = $data_perencanaan;
		$atasan = $this->get_atasan($data['ID_SPA']);
		foreach ($atasan as $key => $item) {
			if (!!$item) {
				$data_update['STATUS'] = 0;
				if ($key == 'ATASAN_I' && $data['ID_STATUS'] != 1)
					$data_update['STATUS'] = 1;

				$pemeriksa['ID_USER'] = $item;
				if ($key == 'ATASAN_I')
					$pemeriksa['NO_URUT'] = 1;
				if ($key == 'ATASAN_II')
					$pemeriksa['NO_URUT'] = 2;

				if ($update) {
					$this->update($data_update, $pemeriksa, 'PEMERIKSA');
				} else {
					$pemeriksa['STATUS'] = $data_update['STATUS'];
					$this->add($pemeriksa, 'PEMERIKSA');
				}
			}
		}
	}



	public function get_atasan($id_spa)
	{
		$where = [
			'ID_PERENCANAAN' 	=> $id_spa,
			'JENIS_PERENCANAAN' => 'SPA',
		];
		$jabatan = array('1', '2');
		$this->db->select('*');
		$this->db->from('TIM_AUDIT');
		$this->db->where($where);
		$this->db->where_in('JABATAN', $jabatan);
		$query = $this->db->get()->result_array();

		$transform_atasan = [];
		foreach ($query as $key => $value) {
			$id_user = $value['ID_USER'];
			if ($value['JABATAN'] == '1')
				$transform_atasan['ATASAN_I'] = $id_user;
			else if ($value['JABATAN'] == '2')
				$transform_atasan['ATASAN_II'] = $id_user;
		}
		return $transform_atasan;
	}

	public function get_master_proses()
	{
		return $this->db->order_by('ID', 'DESC')->get('TM_PROSES')->result_array();
	}

	public function get_master_resiko_desc()
	{
		return $this->db->order_by('ID', 'DESC')->get('TM_RESIKO_DESC')->result_array();
	}
}
