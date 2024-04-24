<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
class M_peminjaman extends CI_Model{

	private $_table 	= "PEMINJAMAN";

	public function get_peminjaman($id_peminjaman = "")
	{
		$this->db->select('*');
		$this->db->from('PEMINJAMAN p'); 
		// $this->db->join('LAMPIRAN l', 'p.ID_PEMINJAMAN=l.ID_PERENCANAAN', 'left');
		$this->db->join('TM_DIVISI td', 'td.ID_DIVISI=p.KEPADA', 'left');
		$this->db->join('TM_USER tu', 'tu.ID_USER=p.KETUA_TIM', 'left');
		// $this->db->where('l.JENIS_PERENCANAAN','PEMINJAMAN');
		if(!empty($id_peminjaman))
			return $this->db->where('p.ID_PEMINJAMAN',$id_peminjaman)->get()->row();
		return $this->db->get()->result_array(); 

	}

	public function get_lampiran($id = false)
	{
		$this->db->select('LAMPIRAN');
		$this->db->from('LAMPIRAN l'); 
		$this->db->join('PEMINJAMAN p', 'p.ID_PEMINJAMAN=l.ID_PERENCANAAN', 'left');
		$this->db->where('l.JENIS_PERENCANAAN','PEMINJAMAN');
		return $this->db->where('p.ID_PEMINJAMAN',$id)->get()->result_array();
	}
	
	public function update($data, $array_where, $table = 'PEMINJAMAN')
    {
        $this->db->where($array_where);
        $this->db->update($table, $data);
	}

	public function save($data, $lampiran)
	{
		$this->db->trans_start();

		// insert table peminjaman
		$this->db->insert($this->_table, $data);
		$id = $this->db->insert_id();

		// insert table lampiran
		$data_perencanaan = [
            'ID_PERENCANAAN' 	=> $id,
			'JENIS_PERENCANAAN' => $this->_table,
		];

		foreach ($lampiran as $value) {
			$data_perencanaan['LAMPIRAN'] = $value;
			$this->db->insert('LAMPIRAN', $data_perencanaan);
		}

		$this->db->trans_complete();

		return $id;
	}

	public function send_update($data, $lampiran, $id_peminjaman)
	{
		$this->db->trans_start();

		$this->db->where('ID_PEMINJAMAN', $id_peminjaman);
		$this->db->update($this->_table, $data);
		
		$data_perencanaan = [
      'ID_PERENCANAAN' 	=> $id_peminjaman,
			'JENIS_PERENCANAAN' => $this->_table,
		];

		$this->db->delete('LAMPIRAN', $data_perencanaan);
		foreach ($lampiran as $value) {
			$data_perencanaan['LAMPIRAN'] = $value;
			$this->db->insert('LAMPIRAN', $data_perencanaan);
		}

		$this->db->trans_complete();

		return $id_peminjaman;
	}
}
