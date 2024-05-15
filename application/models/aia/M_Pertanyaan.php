<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
class M_Pertanyaan extends CI_Model{

    private $_table 	= "M_PERTANYAAN";
    

    // public function get_iso(){
    //     $this->db->select('*')->from('M_PERTANYAAN');
    //     $query = $this->db->get();
    //     return $query->result_array();
    // }

    public function save($data){
        $this->db->insert('M_PERTANYAAN', $data);
		
		$lastquery=$this->db->last_query();
		return $lastquery;
    }

    public function clean(){
        $this->db->where('ID_MASTER_PERTANYAAN !=', '1');
        $this->db->delete('M_PERTANYAAN');
        return;
    }



}
