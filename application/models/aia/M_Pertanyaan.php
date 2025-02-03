<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
class M_Pertanyaan extends CI_Model{

    private $_table 	= "TM_PERTANYAAN";
    

    // public function get_iso(){
    //     $this->db->select('*')->from('TM_PERTANYAAN');
    //     $query = $this->db->get();
    //     return $query->result_array();
    // }

    public function save($data){
        $this->db->insert('TM_PERTANYAAN', $data);
		
		$lastquery=$this->db->last_query();
		return $lastquery;
    }

    public function show_iso($iso) {
        $this->db->select('*');
        $this->db->from('TM_PERTANYAAN');
        $this->db->join('TM_ISO', 'TM_PERTANYAAN.ID_ISO = TM_ISO.ID_ISO')->where('TM_ISO.ID_ISO',$iso);
        $this->db->order_by('ID_MASTER_PERTANYAAN','ASC');
        $query=$this->db->get();
        return $query->result_array();
    }

    public function iiso($data){

    $this->db->select('*')->from('TM_PERTANYAAN')->where('ID_ISO',$data);
        $query=$this->db->get();
        return $query->result_array();
    }

    public function clean($data){

        $this->db->where('ID_ISO =', $data);
        $this->db->delete('TM_PERTANYAAN');
        return;
    }



}
