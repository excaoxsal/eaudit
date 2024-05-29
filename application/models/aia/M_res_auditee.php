<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
class M_res_auditee extends CI_Model{

    public function get_response_auditee_detail(){
        $this->db->select('i.NOMOR_ISO,ra.DIVISI KODE,d.NAMA_DIVISI ,w.WAKTU_AUDIT_AWAL,w.WAKTU_AUDIT_SELESAI,au.NAMA AUDITOR,la.NAMA LEAD_AUDITOR,m.PERTANYAAN')
        ->from('RESPONSE_AUDITEE_D ra')
        ->join('WAKTU_AUDIT w','ra.ID_JADWAL=w.ID_JADWAL','left')
        ->join('M_PERTANYAAN m','ra.ID_MASTER_PERTANYAAN=m.ID_MASTER_PERTANYAAN','left')
        ->join('TM_USER au','w.ID_AUDITOR=au.ID_USER')
        ->join('TM_USER la','w.ID_LEAD_AUDITOR=la.ID_USER','left')
        ->join('M_ISO i','m.ID_ISO=i.ID_ISO','left')
        ->join('TM_DIVISI d','d.KODE=ra.DIVISI');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_divisi(){
        // $eltrue = "NOT NULL";
        $this->db->select('*')->from('TM_DIVISI')->where('KODE IS NOT NULL');
        $query = $this->db->get();
        return $query->result_array();
    }
}