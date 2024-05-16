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

    public function show_iso() {
        $this->db->select('*');
        $this->db->from('M_PERTANYAAN');
        $this->db->join('M_ISO', 'M_PERTANYAAN.ID_ISO = M_ISO.ID_ISO');
        $query=$this->db->get();
        return $query->result_array();
    }

    public function iiso($data){

    $this->db->select('*')->from('M_PERTANYAAN')->where('ID_ISO',$data);
        $query=$this->db->get();
        return $query->result_array();
    }

    public function clean($data){

        $this->db->where('ID_ISO =', $data);
        $this->db->delete('M_PERTANYAAN');
        return;
    }



}
