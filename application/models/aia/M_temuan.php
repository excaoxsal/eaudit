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

    public function insert_pemeriksa($id_temuan, $data)
    {
        $data_notif = [];
        $data_notif['ID_PERENCANAAN'] = $id_temuan;
        $data_notif['JENIS_PERENCANAAN'] = 'TEMUAN DETAIL';

        if ($data['STATUS'] == 'OPEN' && $data['APPROVAL_COMMITMENT'] == 0) {
            $data_notif['STATUS_COMMITMENT'] = 1;
            $data_notif['ID_USER'] = $_SESSION['ID_ATASAN_I'];
            // print_r($data_notif);die();
        } else if ($data['STATUS'] == 'Commitment' && $data['APPROVAL_COMMITMENT'] == 0) {
            $data_notif['STATUS_COMMITMENT'] = 1;
            $data_notif['ID_USER'] = $data['ID_AUDITOR'];
            // print_r('b');die();
        } else if ($data['STATUS'] == 'Commitment' && $data['APPROVAL_COMMITMENT'] == 1) {
            $data_notif['STATUS_COMMITMENT'] = 1;
            $data_notif['ID_USER'] = $data['ID_LEAD_AUDITOR'];
            // print_r('c');die();
        } else {
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
            t."STATUS",
            t."APPROVAL_COMMITMENT",
            t."APPROVAL_TINDAKLANJUT"
        FROM
            "TEMUAN_DETAIL" t
            INNER JOIN "RESPONSE_AUDITEE_D" ra ON ra."ID_HEADER" = t."ID_RESPONSE"
            INNER JOIN "WAKTU_AUDIT" wa ON ra."ID_JADWAL" = wa."ID_JADWAL"
        WHERE
            t."ID_RESPONSE" = ?
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