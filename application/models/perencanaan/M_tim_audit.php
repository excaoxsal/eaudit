<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
class M_tim_audit extends CI_Model{

	private $_table 	= "TIM_AUDIT";
	private $_tbl_user 	= "TM_USER";

	public function get_tim_audit($id, $jenis)
	{
		$joinIndicator 	= $this->_tbl_user.'.ID_USER = '.$this->_table.'.ID_USER';
		$arrayWhere 	= ['ID_PERENCANAAN' => $id, 'JENIS_PERENCANAAN' => $jenis];

		$this->db->select('NAMA, JABATAN, NO_URUT, TM_USER.ID_USER, TM_USER.TANDA_TANGAN');
		$this->db->from($this->_table);
		$this->db->join($this->_tbl_user, $joinIndicator);
		$this->db->where($arrayWhere);
		$this->db->order_by('NO_URUT', 'ASC');
		$query = $this->db->get()->result_array();
		return $query;
	}
}
