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
    function getIso() {
        $query = 'SELECT "ID_ISO","NOMOR_ISO" FROM "TM_ISO"';
        return $this->db->query($query)->result_array();
    }


    public function getTemuanByDivisi()
    {
        $this->db->select('d.NAMA_DIVISI as divisi, 
                           SUM(CASE WHEN t."STATUS" = \'CLOSE\' THEN 1 ELSE 0 END) AS closed,
                           SUM(CASE WHEN t."STATUS" != \'CLOSE\' THEN 1 ELSE 0 END) AS open,
                           i.NOMOR_ISO as ISO, t.SUB_DIVISI');
        $this->db->from('TEMUAN_DETAIL t');
        $this->db->join('RESPONSE_AUDITEE_H h','h.ID_HEADER=t.ID_RESPONSE','left');
        $this->db->join('TM_DIVISI d', 'd.KODE_PARENT = h.DIVISI', 'left');
        $this->db->join('TM_ISO i','i.ID_ISO=h.ID_ISO');
        
        $this->db->group_by('d.NAMA_DIVISI, ISO, t.SUB_DIVISI');
        $query = $this->db->get();
        // var_dump($query->result());die;
        foreach ($query->result() as $row) {
            $results[] = [
                'divisi' => $row->divisi,
                'iso9001' => [
                    'closed' => ($row->ISO == 'ISO 9001') ? $row->sudah_closed : 0,
                    'open' => ($row->ISO == 'ISO 9001') ? $row->belum_closed : 0,
                    'total' => ($row->ISO == 'ISO 9001') ? ($row->sudah_closed + $row->belum_closed) : 0
                ],
                'iso14001' => [
                    'closed' => ($row->ISO == 'ISO 14001') ? $row->sudah_closed : 0,
                    'open' => ($row->ISO == 'ISO 14001') ? $row->belum_closed : 0,
                    'total' => ($row->ISO == 'ISO 14001') ? ($row->sudah_closed + $row->belum_closed) : 0
                ],
                'iso37001' => [
                    'closed' => ($row->ISO == 'ISO 37001') ? $row->sudah_closed : 0,
                    'open' => ($row->ISO == 'ISO 37001') ? $row->belum_closed : 0,
                    'total' => ($row->ISO == 'ISO 37001') ? ($row->sudah_closed + $row->belum_closed) : 0
                ],
                'iso45001' => [
                    'closed' => ($row->ISO == 'ISO 45001') ? $row->sudah_closed : 0,
                    'open' => ($row->ISO == 'ISO 45001') ? $row->belum_closed : 0,
                    'total' => ($row->ISO == 'ISO 45001') ? ($row->sudah_closed + $row->belum_closed) : 0
                ],
                'sub_divisi' => ($row->SUB_DIVISI) ? $this->getSubDivisi($row->divisi, $row->ISO) : []
            ];
        }

        return $results;
    }

    public function getSubDivisi($divisi, $iso)
    {
        $this->db->select('t.SUB_DIVISI');
        $this->db->from('TEMUAN_DETAIL t');
        $this->db->join('RESPONSE_AUDITEE_H h','t.ID_RESPONSE = h.ID_HEADER','left');
        $this->db->join('TM_DIVISI d', 'd.KODE = h.DIVISI', 'left');
        $this->db->join('TM_ISO i','i.ID_ISO=h.ID_ISO','left');
        $this->db->where('d.NAMA_DIVISI', $divisi);
        $this->db->where('i.NOMOR_ISO', $iso);
        $query = $this->db->get();
        
        $sub_divisi = [];
        foreach ($query->result() as $row) {
            $sub_divisi[] = [
                'divisi' => $row->SUB_DIVISI
            ];
        }
        return $sub_divisi;
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
        $query = 'SELECT tt."ID" FROM "TEMUAN_DETAIL" tt WHERE tt."SELESAI" = 0 AND tt."STATUS" = 1 AND tt."ID_TL" = '.$id;
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
