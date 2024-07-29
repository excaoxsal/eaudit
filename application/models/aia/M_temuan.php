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

    public function getStatus($id_tl)
    {
            $query = $this->db->select('STATUS')->from('TEMUAN_DETAIL')
                        ->where('ID_TEMUAN', $id_tl)->get()->row();
            return json_encode($query); 
    }

    public function getAtasan($id_jabatan)
    {
        $query = $this->db->select('ID_ATASAN')
                      ->from('TM_JABATAN')
                      ->where('ID_JABATAN', $id_jabatan)
                      ->get()
                      ->row();
    return json_encode($query);     
    }

    public function getAuditor_Lead($data){
        $sql = '
            SELECT DISTINCT
                td."ID_TEMUAN",
                td."ID_RESPONSE",
                w."ID_JADWAL",
                w."ID_AUDITOR",
                au."NAMA" AS "AUDITOR", 
                w."ID_LEAD_AUDITOR",
                la."NAMA" AS "LEAD_AUDITOR"
            FROM 
                "TEMUAN_DETAIL" td 
            LEFT JOIN 
                "RESPONSE_AUDITEE_D" ra ON td."ID_RESPONSE" = ra."ID_HEADER" 
            LEFT JOIN 
                "WAKTU_AUDIT" w ON ra."ID_JADWAL" = w."ID_JADWAL" 
            JOIN 
                "TM_USER" au ON w."ID_AUDITOR" = au."ID_USER" 
            LEFT JOIN 
                "TM_USER" la ON w."ID_LEAD_AUDITOR" = la."ID_USER" 
            WHERE 
                td."ID_RESPONSE" = ?
            ORDER BY 
                td."ID_TEMUAN";
        ';
        $params = array($data);
        $query = $this->db->query($sql, $params);
        return $query->result_array();
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