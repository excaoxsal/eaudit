<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Observasi extends CI_Model {

    public function save_observasi($data) {
        $this->db->trans_start();
        
        $this->db->insert('"OBSERVASI_LAPANGAN_DETAIL"', $data);
        
        $this->db->trans_complete();
        
        return $this->db->trans_status();
    }

    public function get_observasi_by_id_response($id_response) {
        return $this->db->get_where('"OBSERVASI_LAPANGAN_DETAIL"', [
            'ID_RESPONSE' => $id_response
        ])->result_array();
    }

    public function get_kode_klausul($id_header){
        $query = $this->db->query('
            SELECT distinct "KLAUSUL"
            FROM "RESPONSE_AUDITEE_D" 
            WHERE "ID_HEADER" = ? 
            AND "KLAUSUL" NOT LIKE ?
        ', [$id_header, '%.%%.%']);
        return $query->result_array();
    }
}