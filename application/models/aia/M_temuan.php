<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
class M_Temuan extends CI_Model{

    private $_table 	= "TEMUAN_DETAIL";
    

    public function save($data){
        $this->db->insert('TEMUAN_DETAIL', $data);
		
		$lastquery=$this->db->last_query();
		return $lastquery;
    }

    public function get_temuan_detail($data){
        $elcoding = $data;


        
            $sql = '
        SELECT 
           *
        FROM 
            "TEMUAN_DETAIL" ra
        where 
            "ID_RESPONSE" = ?
        ';
        $params = array($data);
        // Menyusun parameter untuk query
        
        
        // Menjalankan query dengan parameter
        $query = $this->db->query($sql, $params);
        // var_dump($query);die;
        
        // Mengambil hasil query sebagai array asosiatif
    
        return $query->result_array();
    }
}