<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
class M_control_sheet extends CI_Model{

	private $_table 	= "CONTROL_SHEET";

	public function get_control_sheet($id_spa = false)
	{
		$this->db->select('*');
		$this->db->from('CONTROL_SHEET cs'); 
		$this->db->join('SPA s', 's.ID_SPA=cs.ID_SPA', 'left');
		// $this->db->join('TM_DIVISI td', 'td.ID_DIVISI=s.KEPADA', 'left');
		if(!!$id_spa)
			return $this->db->where('cs.ID_SPA',$id_spa)->get()->row();
		return $this->db->get()->result_array(); 

	}

	public function spa($id_spa='') {
			$query = 'SELECT SPA.*, S."STATUS" AS "STATUS", S."CSS" AS "CSS" FROM "SPA" SPA LEFT JOIN "TM_STATUS" S ON S."ID_STATUS" = SPA."ID_STATUS" WHERE SPA."ID_STATUS" = 3 ';
			if($id_spa != '') $query .= ' AND SPA."ID_SPA" = '."'$id_spa'".' order by SPA."ID_SPA" desc';
			$exec = $this->db->query($query);
			return $exec->result_array();
    }

	public function update($data, $id_spa)
	{
		$this->db->where(['ID_SPA' => $id_spa]);
		$this->db->update($this->_table, $data);
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
