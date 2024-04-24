<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
class M_ba_em extends CI_Model{

	private $_table 	= "BA_EM";

	public function get_ba_em($id_pembuat, $id_ba_em = "")
	{
		$this->db->select('*');
		$this->db->from('BA_EM be'); 
		$this->db->join('TM_DIVISI td', 'td.ID_DIVISI=be.ID_DIVISI', 'left');
		$this->db->join('TM_USER tu', 'tu.ID_USER=be.ID_PEMBUAT', 'left');
		$this->db->join('SPA s', 's.ID_SPA=be.ID_SPA', 'left');
		$this->db->where('be.ID_PEMBUAT', $id_pembuat);
		$this->db->order_by('be.TANGGAL', 'desc');
		if(!empty($id_ba_em))
			return $this->db->where('be.ID_BA_EM',$id_ba_em)->get()->row();
		return $this->db->get()->result_array(); 
	}

	public function get_peserta($id = false)
	{
		$this->db->select('NAMA');
		$this->db->from('PESERTA'); 
		$this->db->where('JENIS_PERENCANAAN','BA_EM');
		return $this->db->where('ID_PERENCANAAN',$id)->get()->result_array();
	}

	public function save($data, $peserta, $tanggal_cs)
	{
		$this->db->trans_start();
		// insert table ba_em
		$this->db->insert($this->_table, $data);
		$id = $this->db->insert_id();

		$this->db->select('ID_SPA');
		$this->db->where('ID_BA_EM', $id);
		$data_ba_em = $this->db->get($this->_table)->row();
		$id_spa = $data_ba_em->ID_SPA;
		$where = [
			'ID_SPA' => $id_spa,
		];
		$this->update($tanggal_cs, $where, 'CONTROL_SHEET');

		// insert table peserta
		$data_perencanaan = [
      'ID_PERENCANAAN' 	=> $id,
			'JENIS_PERENCANAAN' => $this->_table,
		];

		foreach ($peserta as $value) {
			$data_perencanaan['NAMA'] = $value;
			$this->db->insert('PESERTA', $data_perencanaan);
		}

		$this->db->trans_complete();

		return $id;
	}

	public function update($data, $array_where, $table = 'BA_EM')
    {
        $this->db->where($array_where);
        $this->db->update($table, $data);
	}

	public function send_update($data, $peserta, $tanggal_cs, $id_ba_em)
	{
		$this->db->trans_start();

		$this->db->where('ID_BA_EM', $id_ba_em);
		$this->db->update($this->_table, $data);

		$this->db->select('ID_SPA');
		$this->db->where('ID_BA_EM', $id);
		$data_ba_em = $this->db->get($this->_table)->row();
		$id_spa = $data_ba_em->ID_SPA;
		$where = [
			'ID_SPA' => $id_spa,
		];
		$this->update($tanggal_cs, $where, 'CONTROL_SHEET');
		
		$data_perencanaan = [
      'ID_PERENCANAAN' 	=> $id_ba_em,
			'JENIS_PERENCANAAN' => $this->_table,
		];

		$this->db->delete('PESERTA', $data_perencanaan);
		foreach ($peserta as $value) {
			$data_perencanaan['NAMA'] = $value;
			$this->db->insert('PESERTA', $data_perencanaan);
		}

		$this->db->trans_complete();

		return $id_ba_em;
	}
}
