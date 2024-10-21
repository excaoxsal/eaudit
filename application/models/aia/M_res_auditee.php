<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
class M_res_auditee extends CI_Model{

    public function get_response_auditee_header(){
        $datauser = $_SESSION['NAMA_ROLE'];
        if($datauser=="AUDITOR"){
            $query = $this->db->query('
                SELECT
                    ra."ID_HEADER",
                    i."NOMOR_ISO",
                    ra."DIVISI" AS "KODE",
                    d."NAMA_DIVISI",
                    w."WAKTU_AUDIT_AWAL",
                    w."WAKTU_AUDIT_SELESAI",
                    au."NAMA" AS "AUDITOR",
                    la."NAMA" AS "LEAD_AUDITOR",
                    COUNT(rd."RESPONSE_AUDITEE") AS "JUMLAH_RESPONSE_AUDITEE_NOT_NULL",
                    COUNT(rd."ID_MASTER_PERTANYAAN") AS "JUMLAH_TOTAL_PERTANYAAN"
                FROM "RESPONSE_AUDITEE_H" ra
                LEFT JOIN "WAKTU_AUDIT" w ON ra."ID_JADWAL" = w."ID_JADWAL"
                JOIN "TM_USER" au ON w."ID_AUDITOR" = au."ID_USER"
                LEFT JOIN "TM_USER" la ON w."ID_LEAD_AUDITOR" = la."ID_USER"
                LEFT JOIN "TM_ISO" i ON ra."ID_ISO" = i."ID_ISO"
                LEFT JOIN "RESPONSE_AUDITEE_D" rd ON ra."ID_HEADER" = rd."ID_HEADER"
                JOIN "TM_DIVISI" d ON d."KODE" = ra."DIVISI"

                GROUP BY ra."ID_HEADER", i."NOMOR_ISO", ra."DIVISI", d."NAMA_DIVISI", w."WAKTU_AUDIT_AWAL", 
                 w."WAKTU_AUDIT_SELESAI", au."NAMA", la."NAMA"
                
                ORDER BY w."WAKTU_AUDIT_SELESAI" ,i."ID_ISO"  DESC
            ');
            return $query->result_array();
        }else{
            $query = $this->db->query('
                SELECT
                    ra."ID_HEADER",
                    i."NOMOR_ISO",
                    ra."DIVISI" AS "KODE",
                    d."NAMA_DIVISI",
                    w."WAKTU_AUDIT_AWAL",
                    w."WAKTU_AUDIT_SELESAI",
                    au."NAMA" AS "AUDITOR",
                    la."NAMA" AS "LEAD_AUDITOR",
                    COUNT(rd."RESPONSE_AUDITEE") AS "JUMLAH_RESPONSE_AUDITEE_NOT_NULL",
                    COUNT(rd."ID_MASTER_PERTANYAAN") AS "JUMLAH_TOTAL_PERTANYAAN"
                    
                FROM "RESPONSE_AUDITEE_H" ra
                LEFT JOIN "WAKTU_AUDIT" w ON ra."ID_JADWAL" = w."ID_JADWAL"
                JOIN "TM_USER" au ON w."ID_AUDITOR" = au."ID_USER"
                LEFT JOIN "TM_USER" la ON w."ID_LEAD_AUDITOR" = la."ID_USER"
                LEFT JOIN "TM_ISO" i ON ra."ID_ISO" = i."ID_ISO"
                LEFT JOIN "RESPONSE_AUDITEE_D" rd ON ra."ID_HEADER" = rd."ID_HEADER"
                JOIN "TM_DIVISI" d ON d."KODE" = ra."DIVISI"
                WHERE d."ID_DIVISI" =' . $_SESSION['ID_DIVISI'] . ' 
                AND d."STATUS" = \'1\'

                GROUP BY ra."ID_HEADER", i."NOMOR_ISO", ra."DIVISI", d."NAMA_DIVISI", w."WAKTU_AUDIT_AWAL", 
                 w."WAKTU_AUDIT_SELESAI", au."NAMA", la."NAMA"
                
                ORDER BY i."NOMOR_ISO", w."WAKTU_AUDIT_SELESAI" DESC
            ');
            return $query->result_array();
        }    
    }

    public function get_response_auditee_detail($data){
		$user_session = $_SESSION['NAMA_ROLE'];
        if($user_session=="AUDITOR"){
            $sql = '
        SELECT 
            i."NOMOR_ISO",
            ra."DIVISI" AS "KODE",
            d."NAMA_DIVISI",
            w."WAKTU_AUDIT_AWAL",
            w."WAKTU_AUDIT_SELESAI",
            au."NAMA" AS "AUDITOR",
            la."NAMA" AS "LEAD_AUDITOR",
            m."PERTANYAAN",
            m."KODE_KLAUSUL",
            ra."KOMENTAR_1",
            ra."KOMENTAR_2",
            ra."ID_MASTER_PERTANYAAN",
            ra."SUB_DIVISI",
            ra."ID_RE",
            ra."RESPONSE_AUDITEE",
            ra."STATUS_AUDITOR" as "STATUS"
            
        FROM 
            "RESPONSE_AUDITEE_D" ra
        LEFT JOIN 
            "WAKTU_AUDIT" w ON ra."ID_JADWAL" = w."ID_JADWAL"
        LEFT JOIN 
            "TM_PERTANYAAN" m ON ra."ID_MASTER_PERTANYAAN" = m."ID_MASTER_PERTANYAAN"
        JOIN 
            "TM_USER" au ON w."ID_AUDITOR" = au."ID_USER"
        LEFT JOIN 
            "TM_USER" la ON w."ID_LEAD_AUDITOR" = la."ID_USER"
        LEFT JOIN 
            "TM_ISO" i ON m."ID_ISO" = i."ID_ISO"
        JOIN 
            "TM_DIVISI" d ON d."KODE" = ra."SUB_DIVISI"
        WHERE 
            ra."ID_HEADER" = ?
        ORDER BY
            ra."ID_RE" ASC
        ';
        $params = array($data);
        }
        else{
            $sql = '
        SELECT 
            i."NOMOR_ISO",
            ra."DIVISI" AS "KODE",
            d."NAMA_DIVISI",
            w."WAKTU_AUDIT_AWAL",
            w."WAKTU_AUDIT_SELESAI",
            au."NAMA" AS "AUDITOR",
            la."NAMA" AS "LEAD_AUDITOR",
            m."PERTANYAAN",
            m."KODE_KLAUSUL",
            ra."KOMENTAR_1",
            ra."KOMENTAR_2",
            ra."ID_MASTER_PERTANYAAN",
            ra."SUB_DIVISI",
            ra."ID_RE",
            ra."STATUS_AUDITEE" as "STATUS",
            ra."RESPONSE_AUDITEE"
            
        FROM 
            "RESPONSE_AUDITEE_D" ra
        LEFT JOIN 
            "WAKTU_AUDIT" w ON ra."ID_JADWAL" = w."ID_JADWAL"
        LEFT JOIN 
            "TM_PERTANYAAN" m ON ra."ID_MASTER_PERTANYAAN" = m."ID_MASTER_PERTANYAAN"
        JOIN 
            "TM_USER" au ON w."ID_AUDITOR" = au."ID_USER"
        LEFT JOIN 
            "TM_USER" la ON w."ID_LEAD_AUDITOR" = la."ID_USER"
        LEFT JOIN 
            "TM_ISO" i ON m."ID_ISO" = i."ID_ISO"
        JOIN 
            "TM_DIVISI" d ON d."KODE" = ra."SUB_DIVISI"
        WHERE 
            ra."ID_HEADER" = ?
        ORDER BY
            ra."ID_MASTER_PERTANYAAN" ASC
        ';
        $params = array($data);
        }
        $query = $this->db->query($sql, $params);
        return $query->result_array();
    }

    public function get_response_auditee_detail_id($data){
        $this->db->select('ra.DIVISI KODE')
        ->from('RESPONSE_AUDITEE_D ra')
        ->join('WAKTU_AUDIT w','ra.ID_JADWAL=w.ID_JADWAL','left')
        ->join('TM_PERTANYAAN m','ra.ID_MASTER_PERTANYAAN=m.ID_MASTER_PERTANYAAN','left')
        ->join('TM_USER au','w.ID_AUDITOR=au.ID_USER')
        ->join('TM_USER la','w.ID_LEAD_AUDITOR=la.ID_USER','left')
        ->join('TM_ISO i','m.ID_ISO=i.ID_ISO','left')
        ->join('TM_DIVISI d','d.KODE=ra.DIVISI')
        ->where('KODE',$data);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_divisi(){
        // $eltrue = "NOT NULL";
        $this->db->select('*')->from('TM_DIVISI')->where('IS_DIVISI','Y');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function update_komen($data,$data_update){
        $elcoding_parts = explode('01', $data);
        $divisi = $elcoding_parts[0];
        $id_iso = $elcoding_parts[1];
        $id_jadwal = $elcoding_parts[2];
        $this->db->set('KOMENTAR_1', $data_update['KOMENTAR_1']);
        $this->db->set('KOMENTAR_2', $data_update['KOMENTAR_2']);
        $this->db->where('DIVISI', $divisi);
        $this->db->where('ID_ISO', $id_iso);
        $this->db->where('ID_JADWAL', $id_jadwal);
        $this->db->update('RESPONSE_AUDITEE_D', $data_update);
        $lastquery=$this->db->last_query();
        
    }
}