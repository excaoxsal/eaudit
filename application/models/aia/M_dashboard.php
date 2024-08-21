<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
class M_dashboard extends CI_Model
{

    public function add($data, $table)
    {
        $this->db->insert($table, $data);
    }

    public function export($bulan, $tahun)
    {
        $query     = 'SELECT E.* FROM "TL_ENTRY" E';
        $exec     = $this->db->query($query);
        return $exec->result_array();
    }

    public function getJenisAudit()
    {
        return $this->db->where('STATUS', 1)->order_by('ID_JENIS_AUDIT', 'ASC')->get('TM_JENIS_AUDIT')->result_array();
    }

    public function getEntry($jenisAudit, $tahun)
    {
        $query = 'select te."TANGGAL_LHA", te."ID_TL", td."NAMA_DIVISI", te."TAHUN"  from "TL_ENTRY" te
        left join "TM_DIVISI" td on td."ID_DIVISI" = te."AUDITEE"
        where te."STATUS" = 1 and te."ID_JENIS_AUDIT" = ' . $jenisAudit . ' and te."TAHUN" <= ' . $tahun . ' order by te."TANGGAL_LHA" ASC';

        return $this->db->query($query)->result_array();
    }

    public function getTemuan($id)
    {
        $query = 'SELECT tt."ID" FROM "TL_TEMUAN" tt LEFT JOIN "TL_ENTRY" te ON te."ID_TL" = tt."ID_TL" WHERE te."SELESAI" = 0 AND tt."STATUS" = 1 AND tt."ID_TL" = '.$id;
        return $this->db->query($query)->result_array();
        // return $this->db->select('ID')->where('STATUS', 1)->where('ID_TL', $id)->get('TL_TEMUAN')->result_array();
    }

    public function getRekom($id)
    {
        $query = 'SELECT tr."ID", tr."TK_PENYELESAIAN" FROM "TL_REKOMENDASI" tr LEFT JOIN "TL_TEMUAN" tt ON tt."ID" = tr."ID_TEMUAN" LEFT JOIN "TL_ENTRY" te ON te."ID_TL" = tt."ID_TL" WHERE te."SELESAI" = 0 AND te."STATUS" = 1 AND tt."STATUS" = 1 AND tr."STATUS" = 1 AND tr."ID_TEMUAN" = '.$id;
        // print_r($query);die();
        return $this->db->query($query)->result_array();
        // return $this->db->select('ID, TK_PENYELESAIAN')->where('ID_TEMUAN', $id)->where('STATUS', 1)->get('TL_REKOMENDASI')->result_array();
    }

    public function getdata($field, $where, $key, $table)
    {
        $field = join(",", $field);
        return $this->db->select($field)->where($where, $key)->get($table)->result_array();
    }

    public function getTotal($field, $key, $table)
    {
        return $this->db->where($field, $key)->from($table)->count_all_results();
    }

    public function getEntryDashboard($tahun, $divisi)
    {
        $filter = "";
        $filter .= ($divisi) ? ' AND te."AUDITEE" =' . $divisi : ' ';
        $filter .= ($tahun) ? ' AND te."TAHUN" =' . $tahun : ' ';

        $query = 'select te."ID_TL", td."NAMA_DIVISI", te."TAHUN"  from "TL_ENTRY" te
        left join "TM_DIVISI" td on td."ID_DIVISI" = te."AUDITEE"
        where (te."SELESAI" IS NULL OR te."SELESAI" = 0) AND te."STATUS" = 1 ' . $filter . ' order by te."TAHUN" ASC';

        return $this->db->query($query)->result_array();
    }
}
