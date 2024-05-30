<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
class M_res_auditee extends CI_Model{

    public function get_response_auditee_header(){
        $this->db->select('
        i.NOMOR_ISO,
        ra.DIVISI KODE,
        d.NAMA_DIVISI ,
        w.WAKTU_AUDIT_AWAL,
        w.WAKTU_AUDIT_SELESAI,
        au.NAMA AUDITOR,
        la.NAMA LEAD_AUDITOR,
        m.PERTANYAAN,
        m.KODE_KLAUSUL,
        string_agg(ra."DIVISI"::text || \'00\' || i."ID_ISO"::text || \'00\' || ra."ID_JADWAL"::text, \'\') as "ELCODING"')
        ->from('RESPONSE_AUDITEE_D ra')
        ->join('WAKTU_AUDIT w','ra.ID_JADWAL=w.ID_JADWAL','left')
        ->join('M_PERTANYAAN m','ra.ID_MASTER_PERTANYAAN=m.ID_MASTER_PERTANYAAN','left')
        ->join('TM_USER au','w.ID_AUDITOR=au.ID_USER')
        ->join('TM_USER la','w.ID_LEAD_AUDITOR=la.ID_USER','left')
        ->join('M_ISO i','m.ID_ISO=i.ID_ISO','left')
        ->join('TM_DIVISI d','d.KODE=ra.DIVISI');
        $this->db->group_by('i."NOMOR_ISO", ra."DIVISI", d."NAMA_DIVISI", w."WAKTU_AUDIT_AWAL", 
                        w."WAKTU_AUDIT_SELESAI", au."NAMA", la."NAMA", m."PERTANYAAN", m."KODE_KLAUSUL"');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_response_auditee_detail($data){
        $elcoding = $data;
		$elcoding_parts = explode('00', $elcoding);
        $divisi = $elcoding_parts[0];
        $id_iso = $elcoding_parts[1];
        $id_jadwal = $elcoding_parts[2];

        $this->db->select('i.NOMOR_ISO,ra.DIVISI KODE,d.NAMA_DIVISI ,w.WAKTU_AUDIT_AWAL,w.WAKTU_AUDIT_SELESAI,au.NAMA AUDITOR,la.NAMA LEAD_AUDITOR,m.PERTANYAAN,m.KODE_KLAUSUL,ra.KOMENTAR_1,ra.KOMENTAR_2')
        ->from('RESPONSE_AUDITEE_D ra')
        ->join('WAKTU_AUDIT w','ra.ID_JADWAL=w.ID_JADWAL','left')
        ->join('M_PERTANYAAN m','ra.ID_MASTER_PERTANYAAN=m.ID_MASTER_PERTANYAAN','left')
        ->join('TM_USER au','w.ID_AUDITOR=au.ID_USER')
        ->join('TM_USER la','w.ID_LEAD_AUDITOR=la.ID_USER','left')
        ->join('M_ISO i','m.ID_ISO=i.ID_ISO','left')
        ->join('TM_DIVISI d','d.KODE=ra.DIVISI');
        
        $this->db->where('ra."DIVISI"', $divisi);
        $this->db->where('i."ID_ISO"', $id_iso);
        $this->db->where('ra."ID_JADWAL"', $id_jadwal);
        $query = $this->db->get();
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