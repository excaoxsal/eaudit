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
    public function get_by_id($id) {
        return $this->db->where('ID', $id)
                        ->get($this->table)
                        ->row();
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
