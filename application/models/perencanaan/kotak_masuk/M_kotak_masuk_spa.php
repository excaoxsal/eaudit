<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
class M_kotak_masuk_spa extends CI_Model{

    public function spa($id_user, $id_spa='')
    {
        $query                       = 'SELECT SPA.*, D."NAMA_DIVISI" AS "NAMA_DIVISI", JA."JENIS_AUDIT" AS "JENIS_AUDIT", S."STATUS" AS "STATUS", S."CSS" AS "CSS" FROM "SPA" SPA LEFT JOIN "TM_DIVISI" D ON D."ID_DIVISI" = SPA."KEPADA" LEFT JOIN "TM_JENIS_AUDIT" JA ON JA."ID_JENIS_AUDIT" = SPA."ID_JENIS_AUDIT" LEFT JOIN "TM_STATUS" S ON S."ID_STATUS" = SPA."ID_STATUS" LEFT JOIN "PEMERIKSA" P ON P."ID_PERENCANAAN" = SPA."ID_SPA" WHERE SPA."ID_STATUS" IN (2, 3) AND P."STATUS" = 1 AND P."ID_USER" = '."'$id_user'";
        if($id_spa != '') $query .= ' AND SPA."ID_SPA" = '."'$id_spa'";
        $exec                        = $this->db->query($query);
        return $exec->result_array();
    }

    public function add($data)
    {
        $this->db->insert('SPA', $data);
    }

    public function update($data, $id_spa)
    {
        $this->db->where('ID_SPA', $id_spa);
        $this->db->update('SPA', $data);
    }
}
?>