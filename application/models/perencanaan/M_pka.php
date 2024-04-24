<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
class M_pka extends CI_Model{

	private $_table 	= "PKA";

	public function get_pka($id_pembuat)
	{
		$query = 'SELECT PKA.*, S."STATUS" AS "STATUS", S."CSS" AS "CSS", (select count(*) from "PEMERIKSA" p2 where p2."ID_PERENCANAAN" = PKA."ID_PKA" and p2."JENIS_PERENCANAAN"  = '."'PKA'".' ) as "APPROVER_COUNT",(select count(*) from "PEMERIKSA" p2 where p2."ID_PERENCANAAN" = PKA."ID_PKA" and p2."JENIS_PERENCANAAN" = '."'PKA'".' and p2."STATUS" = 2) as "APPROVED_COUNT", (select p2."STATUS" from "PEMERIKSA" p2 where p2."ID_PERENCANAAN" = PKA."ID_PKA" and p2."JENIS_PERENCANAAN" = '."'PKA'".' and p2."ID_USER" = '."'$id_pembuat'".') as "STATUS_APPROVER" FROM "PKA" PKA LEFT JOIN "TM_STATUS" S ON S."ID_STATUS" = PKA."ID_STATUS" WHERE PKA."ID_PEMBUAT" = '."'$id_pembuat'".' order by PKA."ID_PKA" desc';
		$exec  = $this->db->query($query);
		return $exec->result_array();
	}

	public function pka_detail($id_pka)
	{
		$this->db->select('p.*, ts.STATUS, ts.CSS, pr.KOMENTAR');
		$this->db->from('PKA p'); 
		$this->db->join('TM_STATUS ts', 'ts.ID_STATUS=p.ID_STATUS', 'left');
		$this->db->join('PEMERIKSA pr', 'pr.ID_PERENCANAAN=p.ID_PKA', 'left');
		$this->db->where('p.ID_PKA', $id_pka);
		$this->db->where('pr.JENIS_PERENCANAAN', 'PKA');
		return $this->db->get()->row(); 
	}

	public function kotak_masuk($id_user)
    {
			$query = 'SELECT PKA.*, S."STATUS" AS "STATUS", S."CSS" AS "CSS", (select count(*) from "PEMERIKSA" p2 where p2."ID_PERENCANAAN" = PKA."ID_PKA" and p2."JENIS_PERENCANAAN"  = '."'PKA'".' ) as "APPROVER_COUNT",(select count(*) from "PEMERIKSA" p2 where p2."ID_PERENCANAAN" = PKA."ID_PKA" and p2."JENIS_PERENCANAAN" = '."'PKA'".' and p2."STATUS" = 2) as "APPROVED_COUNT", (select p2."STATUS" from "PEMERIKSA" p2 where p2."ID_PERENCANAAN" = PKA."ID_PKA" and p2."JENIS_PERENCANAAN" = '."'PKA'".' and p2."ID_USER" = '."'$id_user'".') as "STATUS_APPROVER" FROM "PKA" PKA LEFT JOIN "TM_STATUS" S ON S."ID_STATUS" = PKA."ID_STATUS" LEFT JOIN "PEMERIKSA" P ON P."ID_PERENCANAAN" = PKA."ID_PKA" WHERE PKA."ID_STATUS" IN (2, 3, 4) AND  P."STATUS" != 0 AND  P."JENIS_PERENCANAAN" = '."'PKA'".' AND P."ID_USER" = '."'$id_user'".'
				UNION 
				SELECT PKA.*, S."STATUS" AS "STATUS", S."CSS" AS "CSS", (select count(*) from "PEMERIKSA" p2 where p2."ID_PERENCANAAN" = PKA."ID_PKA" and p2."JENIS_PERENCANAAN"  = '."'PKA'".' ) as "APPROVER_COUNT",(select count(*) from "PEMERIKSA" p2 where p2."ID_PERENCANAAN" = PKA."ID_PKA" and p2."JENIS_PERENCANAAN" = '."'PKA'".' and p2."STATUS" = 2) as "APPROVED_COUNT", (select p2."STATUS" from "PEMERIKSA" p2 where p2."ID_PERENCANAAN" = PKA."ID_PKA" and p2."JENIS_PERENCANAAN" = '."'PKA'".' and p2."ID_USER" = '."'$id_user'".') as "STATUS_APPROVER" FROM "PKA" PKA LEFT JOIN "TM_STATUS" S ON S."ID_STATUS" = PKA."ID_STATUS" LEFT JOIN "TIM_AUDIT" P ON P."ID_PERENCANAAN" = PKA."ID_SPA" WHERE PKA."ID_STATUS" IN (2, 3, 4) AND
(select count(*) from "PEMERIKSA" p2 where p2."ID_PERENCANAAN" = PKA."ID_PKA" and p2."JENIS_PERENCANAAN"  = '."'PKA'".' ) = 
(select count(*) from "PEMERIKSA" p2 where p2."ID_PERENCANAAN" = PKA."ID_PKA" and p2."JENIS_PERENCANAAN" = '."'PKA'".' and p2."STATUS" = 2) AND P."ID_USER" = '."'$id_user'"
			 ;

			$exec = $this->db->query($query);
			return $exec->result_array();
		// $this->db->select('p.*, ts.STATUS, ts.CSS, pr.KOMENTAR');
		// $this->db->from('PKA p'); 
		// $this->db->join('TM_STATUS ts', 'ts.ID_STATUS=p.ID_STATUS', 'left');
		// $this->db->join('PEMERIKSA pr', 'pr.ID_PERENCANAAN=p.ID_PKA', 'left');
		// $this->db->where_in('p.ID_STATUS', [2, 3, 4]);
		// $this->db->where('pr.STATUS', 1);
		// $this->db->where('pr.JENIS_PERENCANAAN', 'PKA');
		// $this->db->where('pr.ID_USER', $id_user);
		// return $this->db->get()->result_array(); 
		}
		
	public function get_spa($id_pka)
	{
		$this->db->select('s.NOMOR_SURAT');
		$this->db->from('PKA p'); 
		$this->db->join('SPA s', 's.ID_SPA=p.ID_SPA', 'left');
		$this->db->where('p.ID_PKA', $id_pka);
		$data_pka = $this->db->get()->row();
		return $data_pka;
	}

	public function get_pemeriksa($id_pka)
	{
		$where = [
			'ID_PERENCANAAN' 	=> $id_pka,
			'JENIS_PERENCANAAN' => $this->_table,
		];
		$this->db->select('p.*, u.TANDA_TANGAN');
		$this->db->from('PEMERIKSA p'); 
		$this->db->join('TM_USER u', 'p.ID_USER=u.ID_USER', 'left');
		$this->db->where($where);
		$this->db->order_by('p.NO_URUT','ASC');
		$data_pka = $this->db->get()->result_array();
		return $data_pka;
	}

	public function add($data, $table)
    {
        $this->db->insert($table, $data);
    }

    public function update($data, $array_where, $table = 'PKA')
    {
        $this->db->where($array_where);
        $this->db->update($table, $data);
	}

	public function is_exist($no_surat)
	{
		$this->db->where('NOMOR_PKA', $no_surat);
		$this->db->from($this->_table);
		$count = $this->db->count_all_results();
		return $count;
	}
	
	public function save($data)
	{
		$this->db->trans_start();

		if ($this->is_exist($data['NOMOR_PKA']) > 0)
			return 0;
		// insert table pka
		$this->db->insert($this->_table, $data);
		$id_pka = $this->db->insert_id();

		$data_perencanaan = [
      'ID_PERENCANAAN' 	=> $id_pka,
			'JENIS_PERENCANAAN' => $this->_table,
		];

		// insert pemeriksa
		$this->insertorupdate_pemeriksa($data_perencanaan, $data);
	
		$this->db->trans_complete();
		return 1;
	}

	public function send_update($data, $id_pka)
	{
		$this->db->trans_start();
		$this->db->select('ID_SPA');
		$this->db->where('ID_PKA', $id_pka);
		$data_pka = $this->db->get($this->_table)->row();
		
		$this->update($data, ['ID_PKA' => $id_pka]);
		
		$data_perencanaan = [
			'ID_PERENCANAAN' 	=> $id_pka,
			'JENIS_PERENCANAAN' => $this->_table,
		];

		$data['ID_SPA'] = $data_pka->ID_SPA;
		$this->insertorupdate_pemeriksa($data_perencanaan, $data, true);

		$this->db->trans_complete();
	}

	public function approval($data, $pemeriksa, $id_pka)
	{
		$this->db->trans_start();

		$this->db->select('ID_SPA');
		$this->db->where('ID_PKA', $id_pka);
		$data_pka = $this->db->get($this->_table)->row();

		$this->update($data, ['ID_PKA' => $id_pka]);
		
		$atasan = $this->get_atasan($data_pka->ID_SPA);
		if (!empty($atasan)) {
			$atasan1 = $atasan['ATASAN_I'];
			$atasan2 = $atasan['ATASAN_II'];

			$array_where = [
				'ID_PERENCANAAN' => $id_pka,
				'JENIS_PERENCANAAN' => $this->_table,
				'NO_URUT' => 1,
			];

			if (!!$atasan1 && $atasan1 == $pemeriksa['ID_USER']) {				
				if ($data['ID_STATUS'] == 3) {
					$data_pemeriksa = ['STATUS' => 2, 'KOMENTAR' => $pemeriksa['KOMENTAR']];
					$this->update($data_pemeriksa, $array_where, 'PEMERIKSA');
					$array_where['NO_URUT'] = 2;
					$data_pemeriksa['STATUS'] = 1;
					$this->update($data_pemeriksa, $array_where, 'PEMERIKSA');

				}elseif ($data['ID_STATUS'] == 4) {
					$data_pemeriksa = ['STATUS' => 3, 'KOMENTAR' => $pemeriksa['KOMENTAR']];
					$this->update($data_pemeriksa, $array_where, 'PEMERIKSA');
					$array_where['NO_URUT'] = 2;
					$data_pemeriksa['STATUS'] = 0;
					$this->update($data_pemeriksa, $array_where, 'PEMERIKSA');
				}
			}elseif (!!$atasan2 && $atasan2 == $pemeriksa['ID_USER']) {			
				if ($data['ID_STATUS'] == 3) {
					$array_where['NO_URUT'] = 2;
					$data_pemeriksa = ['STATUS' => 2, 'KOMENTAR' => $pemeriksa['KOMENTAR']];
					$this->update($data_pemeriksa, $array_where, 'PEMERIKSA');
				}elseif ($data['ID_STATUS'] == 4) {
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

				if($update) {
					$this->update($data_update, $pemeriksa, 'PEMERIKSA');
				}else {
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
}
