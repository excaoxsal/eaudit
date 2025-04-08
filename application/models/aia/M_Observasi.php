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

    public function get_kode_klausul($id_iso,$kode){
        $query = $this->db->query('
            SELECT
                mp."ID_MASTER_PERTANYAAN",
                mp."PERTANYAAN",
                mp."KODE_KLAUSUL"
            FROM "TM_PERTANYAAN" mp
            JOIN "TM_ISO" i ON mp."ID_ISO" = i."ID_ISO"
            WHERE i."ID_ISO" = ?
            AND (mp."LV3" IS NULL)
            AND mp."AUDITEE" like ?
        ', [$id_iso, '%' . $kode . '%']);
        return $query->result_array();
    }
}