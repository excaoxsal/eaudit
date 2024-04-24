<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
class M_log extends CI_Model{
	private $_table = 'LOG_PERENCANAAN';

	public function save($id, $jenis, $log)
	{
		$data = [
			'ID_PERENCANAAN' 		=> $id,
			'JENIS_PERENCANAAN' => $jenis,
			'LOG' 							=> $log,
			'TGL_LOG' 					=> date('Y-m-d H:i:s'),
		];
		$this->db->insert($this->_table, $data);
	}

	public function log_by_id($id, $jenis)
	{
		$this->db->where('JENIS_PERENCANAAN', $jenis);
		$this->db->where('ID_PERENCANAAN', $id);
		return $this->db->order_by('TGL_LOG desc')->get($this->_table)->result_array();
	}
}
?>
