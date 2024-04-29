<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
class M_jadwal extends CI_Model{

    private $_table 	= "WAKTU_AUDIT";
    public function save($data)
	{
		$this->db->trans_start();
        
		// insert table apm
		$this->db->insert($this->_table, $data);
		$id_apm = $this->db->insert_id();

		$data_jadwal = [
        'ID_JADWAL' 	=> $id_jadwal
		];
        // echo("asw");
        // die();
		// insert pemeriksa
		$this->db->trans_complete();
		return 1;
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

    public function jadwal_list(){
        $this->db->select('w.WAKTU_AUDIT, us.NAMA as NAMA_AUDITOR, ul.NAMA as NAMA_LEAD_AUDITOR');
        $this->db->from('WAKTU_AUDIT w');
        $this->db->join('TM_USER us', 'us.ID_USER = w.ID_AUDITOR');
        $this->db->join('TM_USER ul', 'ul.ID_USER = w.ID_LEAD_AUDITOR');
        $this->db->where('w.ID_AUDITOR', '1');
        $this->db->or_where('w.ID_LEAD_AUDITOR', '12345');
        $query = $this->db->get();
        return $query->result_array();

    }
}