<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
class M_jadwal extends CI_Model{

    private $_table 	= "WAKTU_AUDIT";

	public function update($data){

		$table = 'WAKTU_AUDIT';
		$update=$this->db->where('ID_JADWAL',$data['ID_JADWAL'])->update($table, $data);
		$lastquery=$this->db->last_query();
		return($lastquery);
        
	}

	public function update_status($data){

		$table = 'WAKTU_AUDIT';
		$nomor = 1;
		$update_data = array(
            'STATUS' => "1"
        );
		$update=$this->db->where('ID_JADWAL',$data)->update('WAKTU_AUDIT', 'STATUS');
		$lastquery=$this->db->last_query();
		return($lastquery);
        
	}


    public function save($data)
	{

		$insertboy=$this->db->insert('WAKTU_AUDIT', $data);
		$query = $insertboy;
		return $query;
		
	
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
	public function get_jadwal($id_jadwal,$id_user){
		$this->db->select('w.ID_JADWAL,w.WAKTU_AUDIT_AWAL,w.WAKTU_AUDIT_SELESAI,us.ID_USER as ID_AUDITOR, us.NAMA as NAMA_AUDITOR, ul.ID_USER as ID_LEAD, ul.NAMA as NAMA_LEAD_AUDITOR, div.NAMA_DIVISI as NAMA_DIVISI,w.ID_DIVISI as ID_DIVISI');
        $this->db->from('WAKTU_AUDIT w');
        $this->db->join('TM_USER us', 'us.ID_USER = w.ID_AUDITOR');
        $this->db->join('TM_USER ul', 'ul.ID_USER = w.ID_LEAD_AUDITOR');
		$this->db->join('TM_DIVISI div','div.ID_DIVISI = w.ID_DIVISI','LEFT');
        $this->db->where('w.ID_JADWAL', $id_jadwal);
        $this->db->or_where('w.ID_LEAD_AUDITOR', $id_user);
		// $elquery = $this->db->select('')->from('RESPON_AUDITEE');
        $query = $this->db->get();
        return $query->result_array();
	}

	
    public function jadwal_list(){

        $this->db->select('w.ID_JADWAL, w.WAKTU_AUDIT_AWAL, w.WAKTU_AUDIT_SELESAI,us.NAMA as NAMA_AUDITOR, ul.NAMA as NAMA_LEAD_AUDITOR, div.NAMA_DIVISI as NAMA_DIVISI');
		$this->db->from('WAKTU_AUDIT w');
		$this->db->join('TM_USER us', 'us.ID_USER = w.ID_AUDITOR','left');
		$this->db->join('TM_USER ul', 'ul.ID_USER = w.ID_LEAD_AUDITOR','left');
		$this->db->join('TM_DIVISI div','div.ID_DIVISI = w.ID_DIVISI','LEFT');
		// $this->db->where('w.ID_AUDITOR', '1');
		// $this->db->or_where('w.ID_LEAD_AUDITOR', '12345');
		$this->db->order_by('w.WAKTU_AUDIT_AWAL', 'DESC'); // Perbaikan disini

        $query = $this->db->get();
        return $query->result_array();

    }
}