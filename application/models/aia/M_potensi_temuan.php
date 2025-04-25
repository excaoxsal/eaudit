<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_potensi_temuan extends CI_Model {

    private $table = 'POTENSI_TEMUAN'; // Ganti dengan nama tabel sesuai database kamu

    public function __construct() {
        parent::__construct();
    }

    // Get all data
    public function get_all() {
        return $this->db->get($this->table)->result();
    }

    // Get data by ID
    public function get_potensi_temuan($id_response_header) {
        $this->db->select('
            pt.ID_POTENSI_TEMUAN,
            mp.PERTANYAAN,
            mp.KODE_KLAUSUL,
            ra.RESPONSE_AUDITEE,
            pt.HASIL_OBSERVASI,
            pt.KLASIFIKASI,
            pt.FILE,
            ra.PENILAIAN AS STATUS,
            ra.KOMENTAR_1,
            ra.KOMENTAR_2
        ');
        $this->db->from('POTENSI_TEMUAN pt');
        $this->db->join('TM_PERTANYAAN mp', 'pt.ID_PERTANYAAN = mp.ID_MASTER_PERTANYAAN', 'left');
        $this->db->join(
            'RESPONSE_AUDITEE_D ra',
            'pt.ID_RESPONSE = ra.ID_HEADER 
             AND pt.ID_PERTANYAAN = ra.ID_MASTER_PERTANYAAN 
             AND ra.ID_RE = pt.ID_RE',
            'left'
        );
        $this->db->where('pt.ID_RESPONSE', $id_response_header);
        $this->db->order_by('pt.ID_POTENSI_TEMUAN', 'ASC');
        return $this->db->get()->result();
    }

    public function update_group($item_ids, $group_id) {
        $this->db->where_in('ID_RE', $item_ids);
        return $this->db->update('potensi_temuan', ['GROUP_ID' => $group_id]);
    }

    // Insert new data
    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    // Update data by ID
    public function update($id, $data) {
        return $this->db->where('ID', $id)
                        ->update($this->table, $data);
    }

    // Delete data by ID
    public function delete($id) {
        return $this->db->where('ID', $id)
                        ->delete($this->table);
    }
}
