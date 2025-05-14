<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_potensi_temuan extends CI_Model {
    private $table = 'POTENSI_TEMUAN';
    private $group_table = 'TM_GROUP';
    private $group_potensi_table = 'GROUP_POTENSI_TEMUAN';

    public function __construct() {
        parent::__construct();
    }

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
            ra.KOMENTAR_2,
            pt.REFERENSI_KLAUSUL
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
        // Show only ungrouped items
        if (is_null($group_id)) {
            $this->db->where('pt.GROUP_ID IS NULL');
        } else {
            $this->db->where('pt.GROUP_ID', $group_id);
        }
        $this->db->order_by('mp.KODE_KLAUSUL', 'ASC');
        $this->db->order_by('pt.ID_POTENSI_TEMUAN', 'ASC');
        return $this->db->get()->result();
    }

    public function getItemsByGroupId($group_id)
    {
        // Query to fetch items assigned to the given group ID
        $this->db->select('*');
        $this->db->from('POTENSI_TEMUAN pt');
        $this->db->join('TM_PERTANYAAN mp', 'pt.ID_PERTANYAAN = mp.ID_MASTER_PERTANYAAN', 'left');
        $this->db->where('GROUP_ID', $group_id);
        $this->db->order_by('mp.KODE_KLAUSUL', 'ASC');
        $this->db->order_by('pt.ID_POTENSI_TEMUAN', 'ASC');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function get_master_groups() {
        return $this->db->get_where($this->group_table, ['DELETED_AT' => null])->result_array();
    }
    
    public function add_group($group_name) {
        $data = [
            'NAME' => $group_name,
            'CREATED_AT' => date('Y-m-d H:i:s')
        ];
        return $this->db->insert($this->group_table, $data);
    }

    public function update_group($item_ids, $group_id) {
        // Pastikan $item_ids adalah array
        if (!is_array($item_ids) || empty($item_ids)) {
            return false;
        }

        // Update GROUP_ID berdasarkan ID_POTENSI_TEMUAN
        $this->db->where_in('ID_POTENSI_TEMUAN', $item_ids); // Ganti ID_RE ke ID_POTENSI_TEMUAN
        return $this->db->update('POTENSI_TEMUAN', ['GROUP_ID' => $group_id]);
    }

    public function delete_group($group_id) {
        $this->db->trans_start();
        
        // Reset items in this group
        $this->db->where('GROUP_ID', $group_id)
                 ->update($this->table, ['GROUP_ID' => NULL]);
                 
        // Delete group
        $this->db->where('ID', $group_id)
                 ->delete($this->group_table);
        
        $this->db->trans_complete();
        return $this->db->trans_status();
    }


    // public function resetGroupItems($group_id, $item_ids)
    // {
    //     // Update items to remove their group association
    //     $this->db->where('GROUP_ID', $group_id);
    //     $this->db->where_in('ID_POTENSI_TEMUAN', $item_ids);
    //     $this->db->update('POTENSI_TEMUAN', ['GROUP_ID' => NULL]);

    //     // Check if rows were affected
    //     return $this->db->affected_rows() > 0;
    // }
    
    // public function get_group_potensi_temuan() {
    //     $this->db->select('
    //         G.ID, 
    //         G.NAME as GROUP_NAME, 
    //         GP.URAIAN_TEMUAN, 
    //         GP.KLASIFIKASI, 
    //         GP.REFERENSI_KLAUSUL,
    //         COUNT(PT.ID_RE) as ITEM_COUNT
    //     ');
    //     $this->db->from($this->group_table.' G');
    //     $this->db->join($this->group_potensi_table.' GP', 'GP.GROUP_ID = G.ID', 'left');
    //     $this->db->join($this->table.' PT', 'PT.GROUP_ID = G.ID', 'left');
    //     $this->db->where('G.DELETED_AT', null);
    //     $this->db->group_by('G.ID');
    //     return $this->db->get()->result_array();
    // }
    
    // public function update_group_potensi_temuan($changes) {
    //     $this->db->trans_start();
        
    //     foreach ($changes as $change) {
    //         $data = [
    //             'GROUP_ID' => $change['ID'],
    //             'URAIAN_TEMUAN' => $change['URAIAN_TEMUAN'] ?? null,
    //             'KLASIFIKASI' => $change['KLASIFIKASI'] ?? null,
    //             'REFERENSI_KLAUSUL' => $change['REFERENSI_KLAUSUL'] ?? null,
    //             'UPDATED_AT' => date('Y-m-d H:i:s')
    //         ];
            
    //         $exists = $this->db->where('GROUP_ID', $change['ID'])
    //                           ->get($this->group_potensi_table)
    //                           ->row();
            
    //         if ($exists) {
    //             $this->db->where('GROUP_ID', $change['ID'])
    //                      ->update($this->group_potensi_table, $data);
    //         } else {
    //             $data['CREATED_AT'] = date('Y-m-d H:i:s');
    //             $this->db->insert($this->group_potensi_table, $data);
    //         }
    //     }
        
    //     $this->db->trans_complete();
    //     return $this->db->trans_status();
    // }
}