<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
class M_Iso extends CI_Model{

    private $_table 	= "TM_ISO";
    

    public function get_iso(){
        
        $this->db->select('*')->from('TM_ISO')->order_by('NOMOR_ISO', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function iiso(){
        $this->db->select('*')->from('TM_ISO')->where('IS_ANY','1')->order_by('ID_ISO', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function update($data){
        $table = "TM_ISO";
        $this->db->set('IS_ANY', 1);
        $this->db->where('ID_ISO', $data);
        $update = $this->db->update($table);

        return $query ;
    }

    

    public function save($data){
        $insertboy=$this->db->insert('TM_ISO', $data);
		$query = $insertboy;
		return $query;
    }



}
