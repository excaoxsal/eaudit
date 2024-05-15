<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
class M_Iso extends CI_Model{

    private $_table 	= "M_ISO";
    

    public function get_iso(){
        $this->db->select('*')->from('M_ISO');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function show($data) {
        
    }

    public function save($data){
        $insertboy=$this->db->insert('M_ISO', $data);
		$query = $insertboy;
		return $query;
    }



}
