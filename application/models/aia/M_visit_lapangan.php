<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_visit_lapangan extends CI_Model {

    public function save_observasi($data) {
        $this->db->trans_start();
        
        $this->db->insert('"VISIT_LAPANGAN"', $data);
        
        $this->db->trans_complete();
        
        return $this->db->trans_status();
    }
    public function update_observasi($data){


    }

    public function get_visit_lapangan_by_id_response($id_response) {
        $this->db->where('ID_RESPONSE', $id_response);
        $this->db->order_by('ID_VISIT', 'ASC');
        return $this->db->get('VISIT_LAPANGAN')->result_array();
    }

    public function get_kode_klausul($id_header){
        $query = $this->db->query('
            SELECT DISTINCT ON (
                split_part("KLAUSUL", \'.\', 1) || \'.\' || split_part("KLAUSUL", \'.\', 2)
            )
                "ID_MASTER_PERTANYAAN",
                split_part("KLAUSUL", \'.\', 1) || \'.\' || split_part("KLAUSUL", \'.\', 2) AS "KLAUSUL"
            FROM 
                "RESPONSE_AUDITEE_D"
            WHERE 
                "ID_HEADER" = ?
                AND split_part("KLAUSUL", \'.\', 2) <> \'\'
            ORDER BY 
                split_part("KLAUSUL", \'.\', 1) || \'.\' || split_part("KLAUSUL", \'.\', 2)
        ', [$id_header]);
        
        return $query->result_array();
    }
}