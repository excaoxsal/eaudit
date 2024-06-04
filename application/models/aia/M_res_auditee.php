<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
class M_res_auditee extends CI_Model{

    public function get_response_auditee_header(){
        $datauser = $_SESSION['NAMA_ROLE'];
        if($datauser=="AUDITOR"){
            $query = $this->db->query('
                SELECT
                    i."NOMOR_ISO",
                    ra."DIVISI" AS "KODE",
                    d."NAMA_DIVISI",
                    w."WAKTU_AUDIT_AWAL",
                    w."WAKTU_AUDIT_SELESAI",
                    au."NAMA" AS "AUDITOR",
                    la."NAMA" AS "LEAD_AUDITOR",
                    string_agg(DISTINCT ra."DIVISI"::text || \'00\' || i."ID_ISO"::text || \'00\' || ra."ID_JADWAL"::text, \'\') AS "ELCODING"
                FROM "RESPONSE_AUDITEE_H" ra
                LEFT JOIN "WAKTU_AUDIT" w ON ra."ID_JADWAL" = w."ID_JADWAL"
                JOIN "TM_USER" au ON w."ID_AUDITOR" = au."ID_USER"
                LEFT JOIN "TM_USER" la ON w."ID_LEAD_AUDITOR" = la."ID_USER"
                LEFT JOIN "M_ISO" i ON ra."ID_ISO" = i."ID_ISO"
                JOIN "TM_DIVISI" d ON d."KODE" = ra."DIVISI"
                GROUP BY 
                    i."NOMOR_ISO",
                    ra."DIVISI",
                    d."NAMA_DIVISI",
                    w."WAKTU_AUDIT_AWAL",
                    w."WAKTU_AUDIT_SELESAI",
                    au."NAMA",
                    la."NAMA"
                ORDER BY i."NOMOR_ISO", w."WAKTU_AUDIT_SELESAI" ASC
            ');
            return $query->result_array();
        }else{
            $query = $this->db->query('
                SELECT
                    i."NOMOR_ISO",
                    ra."DIVISI" AS "KODE",
                    d."NAMA_DIVISI",
                    w."WAKTU_AUDIT_AWAL",
                    w."WAKTU_AUDIT_SELESAI",
                    au."NAMA" AS "AUDITOR",
                    la."NAMA" AS "LEAD_AUDITOR",
                    string_agg(DISTINCT ra."DIVISI"::text || \'00\' || i."ID_ISO"::text || \'00\' || ra."ID_JADWAL"::text, \'\') AS "ELCODING"
                FROM "RESPONSE_AUDITEE_H        " ra
                LEFT JOIN "WAKTU_AUDIT" w ON ra."ID_JADWAL" = w."ID_JADWAL"
                JOIN "TM_USER" au ON w."ID_AUDITOR" = au."ID_USER"
                LEFT JOIN "TM_USER" la ON w."ID_LEAD_AUDITOR" = la."ID_USER"
                LEFT JOIN "M_ISO" i ON ra."ID_ISO" = i."ID_ISO"
                JOIN "TM_DIVISI" d ON d."KODE" = ra."DIVISI"
                WHERE d."ID_DIVISI" = ' . $_SESSION['ID_DIVISI'] . '
                AND d."STATUS" = \'1\'
                GROUP BY 
                    i."NOMOR_ISO",
                    ra."DIVISI",
                    d."NAMA_DIVISI",
                    w."WAKTU_AUDIT_AWAL",
                    w."WAKTU_AUDIT_SELESAI",
                    au."NAMA",
                    la."NAMA"
                ORDER BY i."NOMOR_ISO", w."WAKTU_AUDIT_SELESAI" ASC
            ');
            return $query->result_array();
        }    
    }

    public function get_response_auditee_detail($data){
        $elcoding = $data;
        $elcoding_parts = explode('00', $elcoding);
        $divisi = $elcoding_parts[0];
        $id_iso = $elcoding_parts[1];
        $id_jadwal = $elcoding_parts[2];

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
            ra."SUB_DIVISI"
        FROM 
            "RESPONSE_AUDITEE_D" ra
        LEFT JOIN 
            "WAKTU_AUDIT" w ON ra."ID_JADWAL" = w."ID_JADWAL"
        LEFT JOIN 
            "M_PERTANYAAN" m ON ra."ID_MASTER_PERTANYAAN" = m."ID_MASTER_PERTANYAAN"
        JOIN 
            "TM_USER" au ON w."ID_AUDITOR" = au."ID_USER"
        LEFT JOIN 
            "TM_USER" la ON w."ID_LEAD_AUDITOR" = la."ID_USER"
        LEFT JOIN 
            "M_ISO" i ON m."ID_ISO" = i."ID_ISO"
        JOIN 
            "TM_DIVISI" d ON d."KODE" = ra."DIVISI"
        WHERE 
            ra."DIVISI" = ?
            AND i."ID_ISO" = ?
            AND ra."ID_JADWAL" = ?
            AND ra."SUB_DIVISI" IS NOT NULL
        ';
    
        // Menyusun parameter untuk query
        $params = array($divisi, $id_iso, $id_jadwal);
        
        // Menjalankan query dengan parameter
        $query = $this->db->query($sql, $params);
        
        // Mengambil hasil query sebagai array asosiatif
    
        return $query->result_array();
    }

    public function get_response_auditee_detail_id($data){
        $this->db->select('ra.DIVISI KODE')
        ->from('RESPONSE_AUDITEE_D ra')
        ->join('WAKTU_AUDIT w','ra.ID_JADWAL=w.ID_JADWAL','left')
        ->join('M_PERTANYAAN m','ra.ID_MASTER_PERTANYAAN=m.ID_MASTER_PERTANYAAN','left')
        ->join('TM_USER au','w.ID_AUDITOR=au.ID_USER')
        ->join('TM_USER la','w.ID_LEAD_AUDITOR=la.ID_USER','left')
        ->join('M_ISO i','m.ID_ISO=i.ID_ISO','left')
        ->join('TM_DIVISI d','d.KODE=ra.DIVISI')
        ->where('KODE',$data);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_divisi(){
        // $eltrue = "NOT NULL";
        $this->db->select('*')->from('TM_DIVISI')->where('KODE IS NOT NULL');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function update_komen($data,$data_update){
        $elcoding_parts = explode('00', $data);
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