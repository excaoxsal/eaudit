<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
class M_Temuan extends CI_Model{

    private $_table 	= "TEMUAN_DETAIL";

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session'); // Load session library
    }

    public function save($data){
        $this->db->insert('TEMUAN_DETAIL', $data);
		
		$lastquery=$this->db->last_query();
		return $lastquery;
    }

    public function add($table, $data)
    {
        // Debug information to ensure data structure is correct
        log_message('debug', 'Data to insert: ' . print_r($data, true));
        log_message('debug', 'Table name: ' . $table);

        // Perform the insertion
        if ($this->db->insert($table, $data)) {
            log_message('debug', 'Insert successful');
        } else {
            log_message('error', 'Insert failed: ' . $this->db->_error_message());
        }
    }

    public function update($data, $array_where, $table)
    {
        $this->db->where($array_where);
        $this->db->update($table, $data);
    }

    public function delete($table, $key, $id)
    {
        $this->db->where($key, $id)->delete($table);
    }

    public function insert_pemeriksa($id_temuan, $data)
    {
        $data_notif = [];
        $data_notif['ID_PERENCANAAN'] = $id_temuan;
        $data_notif['JENIS_PERENCANAAN'] = 'TEMUAN DETAIL';
        //print_r($data);die();

        if ($data[0]['STATUS'] == 'OPEN' && $data[0]['APPROVAL_COMMITMENT'] == 0) {
            $atasanAuditee = $this->getAtasan($_SESSION['ID_JABATAN']);
            $atasanAuditeeArray = json_decode($atasanAuditee, true);
            $atasanAuditee1 = $this->getAtasanAuditee($atasanAuditeeArray['ID_ATASAN']);
            $atasanAuditeeArray1 = json_decode($atasanAuditee1, true);
            $data_notif['STATUS_COMMITMENT'] = 1;
            $data_notif['ID_USER'] = $atasanAuditeeArray1['ID_USER'];
        } else if ($data[0]['STATUS'] == 'Commitment' && $data[0]['APPROVAL_COMMITMENT'] == 0) {
            //print_r($data['ID_AUDITOR']);die();
            $data_notif['STATUS_COMMITMENT'] = 1;
            $data_notif['ID_USER'] = $data[0]['ID_AUDITOR'];
            //print_r('B');die();
        } else if ($data[0]['STATUS'] == 'Commitment' && $data[0]['APPROVAL_COMMITMENT'] == 1) {
            $data_notif['STATUS_COMMITMENT'] = 1;
            $data_notif['ID_USER'] = $data[0]['ID_LEAD_AUDITOR'];
            //print_r('C');die();
        } else {
            //print_r('D');die();
            return False;
        }
            $this->db->insert('PEMERIKSA',$data_notif);
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

    public function getAtasanAuditee($id_jabatan)
    {
        $query = $this->db->select('ID_USER')
                      ->from('TM_USER')
                      ->where('ID_JABATAN', $id_jabatan)
                      ->where('STATUS', 1)
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
                    ( \'(\'|| (SELECT COUNT("ID_TEMUAN") FROM "TEMUAN_DETAIL" where "ID_RESPONSE" = ra."ID_HEADER" and "STATUS" =\'CLOSE\' ) || \'/\' || (SELECT COUNT("ID_TEMUAN") FROM "TEMUAN_DETAIL" where "ID_RESPONSE" = ra."ID_HEADER" )||\')\' ) AS "TOTAL"
                FROM "RESPONSE_AUDITEE_H" ra
                LEFT JOIN "WAKTU_AUDIT" w ON ra."ID_JADWAL" = w."ID_JADWAL"
                JOIN "TM_USER" au ON w."ID_AUDITOR" = au."ID_USER"
                LEFT JOIN "TM_USER" la ON w."ID_LEAD_AUDITOR" = la."ID_USER"
                LEFT JOIN "TM_ISO" i ON ra."ID_ISO" = i."ID_ISO"
                JOIN "TM_DIVISI" d ON d."KODE" = ra."DIVISI"
                
                ORDER BY w."WAKTU_AUDIT_SELESAI" ,i."ID_ISO"  DESC
            ');
            // echo $query;die;
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
                    ( \'(\'|| (SELECT COUNT("ID_TEMUAN") FROM "TEMUAN_DETAIL" where "ID_RESPONSE" = ra."ID_HEADER" and "STATUS" =\'CLOSE\' ) || \'/\' || (SELECT COUNT("ID_TEMUAN") FROM "TEMUAN_DETAIL" where "ID_RESPONSE" = ra."ID_HEADER" )||\')\' ) AS "TOTAL"
                FROM "RESPONSE_AUDITEE_H" ra
                LEFT JOIN "WAKTU_AUDIT" w ON ra."ID_JADWAL" = w."ID_JADWAL"
                JOIN "TM_USER" au ON w."ID_AUDITOR" = au."ID_USER"
                LEFT JOIN "TM_USER" la ON w."ID_LEAD_AUDITOR" = la."ID_USER"
                LEFT JOIN "TM_ISO" i ON ra."ID_ISO" = i."ID_ISO"
                JOIN "TM_DIVISI" d ON d."KODE" = ra."DIVISI"
                WHERE d."ID_DIVISI" =' . $_SESSION['ID_DIVISI'] . ' 
                AND d."STATUS" = \'1\'
                
                ORDER BY i."NOMOR_ISO", w."WAKTU_AUDIT_SELESAI" ASC
            ');
            return $query->result_array();
        }    
    }

    public function get_temuan_detail($data){
        $user_session = $_SESSION['NAMA_ROLE'];
        if($user_session=="AUDITOR"){
            $sql = '
            SELECT "ID_TEMUAN", "ID_AUDITOR", "ID_LEAD_AUDITOR", "ID_AUDITEE", "ID_ATASAN_AUDITEE", "ID_JADWAL", "ID_RESPONSE", "STATUS", "KLAUSUL", "PERTANYAAN", "TEMUAN", "APPROVAL_COMMITMENT", "APPROVAL_TINDAKLANJUT", "INVESTIGASI", "PERBAIKAN", "KOREKTIF", "TANGGAL", "KOMENTAR_AUDITOR", "KOMENTAR_AUDITEE", "STATUS_KOMEN_AUDITOR" as "STATUS_KOMEN","KATEGORI","POINT" as "NO","NOMOR_LKHA"
            FROM "TEMUAN_DETAIL"
            where 
                "ID_RESPONSE" = ?
            ORDER BY "ID_TEMUAN"
            ';
        }else{
            $sql = '
            SELECT "ID_TEMUAN", "ID_AUDITOR", "ID_LEAD_AUDITOR", "ID_AUDITEE", "ID_ATASAN_AUDITEE", "ID_JADWAL", "ID_RESPONSE", "STATUS", "KLAUSUL", "PERTANYAAN", "TEMUAN", "APPROVAL_COMMITMENT", "APPROVAL_TINDAKLANJUT", "INVESTIGASI", "PERBAIKAN", "KOREKTIF", "TANGGAL", "KOMENTAR_AUDITOR", "KOMENTAR_AUDITEE", "STATUS_KOMEN_AUDITEE" as "STATUS_KOMEN","KATEGORI","POINT" as "NO","NOMOR_LKHA"
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

    public function get_detail_temuan($data){
        $sql = '
        SELECT DISTINCT
            wa."ID_AUDITOR",
            wa."ID_LEAD_AUDITOR",
            t."ID_TEMUAN",
            t."STATUS",
            t."APPROVAL_COMMITMENT",
            t."APPROVAL_TINDAKLANJUT"
        FROM
            "TEMUAN_DETAIL" t
            INNER JOIN "RESPONSE_AUDITEE_D" ra ON ra."ID_HEADER" = t."ID_RESPONSE"
            INNER JOIN "WAKTU_AUDIT" wa ON ra."ID_JADWAL" = wa."ID_JADWAL"
        WHERE
            t."ID_RESPONSE" = ?
        ORDER BY t."ID_TEMUAN" ASC
        ';
        $params = array($data);
        $query = $this->db->query($sql, $params);
        return $query->result_array();
    }
    
    public function getLog($id_target) {
        $query = $this->db->select("LOG_KIRIM, to_char(\"WAKTU\", 'YYYY-MM-DD HH24:MI:SS') AS formatted_timestamp")
         ->from('LOG_TEMUAN')
         ->where('ID_TARGET', $id_target)
         ->where('LOG_KIRIM IS NOT NULL')
         ->get();
         

         if ($query->num_rows() > 0) {
            echo json_encode($query->result_array()); // Mengembalikan data sebagai array dan meng-encode ke JSON
        } else {
            echo json_encode([]); // Mengembalikan array kosong jika tidak ada hasil 
        }
    }

    
}