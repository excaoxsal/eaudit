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
        $user_session = $_SESSION['NAMA_ROLE'];
        if($user_session=="AUDITOR"){
            $sql = '
            SELECT "ID_TEMUAN", "ID_AUDITOR", "ID_LEAD_AUDITOR", "ID_AUDITEE", "ID_ATASAN_AUDITEE", "ID_JADWAL", "ID_RESPONSE", "STATUS", "KLAUSUL", "PERTANYAAN", "TEMUAN", "APPROVAL_COMMITMENT", "APPROVAL_TINDAKLANJUT", "INVESTIGASI", "PERBAIKAN", "KOREKTIF", "TANGGAL", "KOMENTAR_AUDITOR", "KOMENTAR_AUDITEE", "STATUS_KOMEN_AUDITOR" as "STATUS_KOMEN"
            FROM "TEMUAN_DETAIL"
            where 
                "ID_RESPONSE" = ?
            ORDER BY "ID_TEMUAN"
            ';
        }else{
            $sql = '
            SELECT "ID_TEMUAN", "ID_AUDITOR", "ID_LEAD_AUDITOR", "ID_AUDITEE", "ID_ATASAN_AUDITEE", "ID_JADWAL", "ID_RESPONSE", "STATUS", "KLAUSUL", "PERTANYAAN", "TEMUAN", "APPROVAL_COMMITMENT", "APPROVAL_TINDAKLANJUT", "INVESTIGASI", "PERBAIKAN", "KOREKTIF", "TANGGAL", "KOMENTAR_AUDITOR", "KOMENTAR_AUDITEE", "STATUS_KOMEN_AUDITEE" as "STATUS_KOMEN"
            FROM "TEMUAN_DETAIL"
            where 
                "ID_RESPONSE" = ?
            ORDER BY "ID_TEMUAN"
            ';
        }
        $params = array($data);
        $query = $this->db->query($sql, $params);
        return $query->result_array();
    }

    
}