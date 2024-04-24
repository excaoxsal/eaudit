<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
class M_kotak_keluar_spa extends CI_Model{

    public function spa($id_pembuat)
    {
        $query                       = 'SELECT SPA.*, D."NAMA_DIVISI" AS "NAMA_DIVISI", JA."JENIS_AUDIT" AS "JENIS_AUDIT", S."STATUS" AS "STATUS", S."CSS" AS "CSS" FROM "SPA" SPA LEFT JOIN "TM_DIVISI" D ON D."ID_DIVISI" = SPA."KEPADA" LEFT JOIN "TM_JENIS_AUDIT" JA ON JA."ID_JENIS_AUDIT" = SPA."ID_JENIS_AUDIT" LEFT JOIN "TM_STATUS" S ON S."ID_STATUS" = SPA."ID_STATUS" WHERE SPA."ID_PEMBUAT" = '. "'$id_pembuat'";
        // if($id_spa != '') $query .= ' AND SPA."ID_SPA" = '."'$id_spa'";
        $exec                        = $this->db->query($query);
        return $exec->result_array();
    }

    public function spa_detail($id_spa)
    {
        $query                       = 'SELECT SPA.*, D."NAMA_DIVISI" AS "NAMA_DIVISI", JA."JENIS_AUDIT" AS "JENIS_AUDIT", S."STATUS" AS "STATUS", S."CSS" AS "CSS" FROM "SPA" SPA LEFT JOIN "TM_DIVISI" D ON D."ID_DIVISI" = SPA."KEPADA" LEFT JOIN "TM_JENIS_AUDIT" JA ON JA."ID_JENIS_AUDIT" = SPA."ID_JENIS_AUDIT" LEFT JOIN "TM_STATUS" S ON S."ID_STATUS" = SPA."ID_STATUS" WHERE SPA."ID_SPA" = '. "'$id_spa'";
        // if($id_spa != '') $query .= ' AND SPA."ID_SPA" = '."'$id_spa'";
        $exec                        = $this->db->query($query);
        return $exec->row();
    }

    public function last_id_spa()
    {
        $query  = 'SELECT MAX("ID_SPA") FROM "SPA"';
        $exec   = $this->db->query($query);
        return $exec->row();
    }

    public function add($data, $table)
    {
        $this->db->insert($table, $data);
    }

    public function update($data, $id_spa)
    {
        $this->db->where('ID_SPA', $id_spa);
        $this->db->update('SPA', $data);
    }
}
?>