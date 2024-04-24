<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
class M_status_tl extends CI_Model
{

    function cari_divisi($auditee)
    {
        $query                       = 'SELECT * FROM "DIVISI" D WHERE D."ID_STATUS" = 1 AND D."NAMA_DIVISI" = ' . "'$auditee'";
        $exec                        = $this->db->query($query);
        return $exec;
    }

    function rekomendasi($tahun, $id_divisi, $id_jenis_audit, $id_temuan = '')
    {
        // $query  = 'SELECT R.*, D."NAMA_DIVISI" FROM "TL_REKOMENDASI" R LEFT JOIN "TL_TEMUAN" T ON R."ID_TEMUAN" = T."ID" LEFT JOIN "TL_ENTRY" E ON T."ID_TL" = E."ID_TL" LEFT JOIN "SPA" S ON E."ID_SPA" = S."ID_SPA" LEFT JOIN "TM_DIVISI" D ON S."KEPADA" = D."ID_DIVISI" WHERE S."KEPADA" = '. "'$id_divisi'";
        $query  = 'SELECT T."TEMUAN", D."NAMA_DIVISI", JA."JENIS_AUDIT", R."REKOMENDASI", R."BATAS_WAKTU", R."TGL_PENYELESAIAN", R."PIC", R."HASIL_MONITORING", R."TK_PENYELESAIAN", E."TAHUN", E."AUDITEE", E."ID_JENIS_AUDIT" FROM "TL_REKOMENDASI" R LEFT JOIN "TL_TEMUAN" T ON R."ID_TEMUAN" = T."ID" LEFT JOIN "TL_ENTRY" E ON T."ID_TL" = E."ID_TL" LEFT JOIN "TM_DIVISI" D ON E."AUDITEE" = D."ID_DIVISI" LEFT JOIN "TM_JENIS_AUDIT" JA ON E."ID_JENIS_AUDIT" = JA."ID_JENIS_AUDIT" WHERE R."STATUS" = 3 AND E."TAHUN" = ' . "'$tahun'" . ' AND E."AUDITEE" = ' . "'$id_divisi'" . ' AND E."ID_JENIS_AUDIT" = ' . "'$id_jenis_audit'";
        if ($id_temuan != '') $query .= ' AND T."ID" = ' . "'$id_temuan'" . ' order by E."ID_TL" desc';
        $exec   = $this->db->query($query);
        return $exec->result_array();
    }

    function tk_penyelesaian($tahun, $id_divisi, $id_jenis_audit, $tk_penyelesaian = '')
    {
        $query  = 'SELECT T."TEMUAN", D."NAMA_DIVISI", JA."JENIS_AUDIT", R."REKOMENDASI", R."BATAS_WAKTU", R."TGL_PENYELESAIAN", R."PIC", R."HASIL_MONITORING", R."TK_PENYELESAIAN", E."TAHUN", E."AUDITEE", E."ID_JENIS_AUDIT" FROM "TL_REKOMENDASI" R LEFT JOIN "TL_TEMUAN" T ON R."ID_TEMUAN" = T."ID" LEFT JOIN "TL_ENTRY" E ON T."ID_TL" = E."ID_TL" LEFT JOIN "TM_DIVISI" D ON E."AUDITEE" = D."ID_DIVISI" LEFT JOIN "TM_JENIS_AUDIT" JA ON E."ID_JENIS_AUDIT" = JA."ID_JENIS_AUDIT" WHERE R."STATUS" = 3 AND E."TAHUN" = ' . "'$tahun'" . ' AND E."AUDITEE" = ' . "'$id_divisi'" . ' AND E."ID_JENIS_AUDIT" = ' . "'$id_jenis_audit'";
        if ($tk_penyelesaian != '') $query .= ' AND R."TK_PENYELESAIAN" = ' . "'$tk_penyelesaian'" . ' order by E."ID_TL" desc';
        $exec   = $this->db->query($query);
        return $exec->result_array();
    }

    function temuan($tahun, $id_divisi, $id_jenis_audit='', $status='', $div_pic='')
    {
        $this->db->select('T.*')
                    ->from('TL_TEMUAN T')
                    ->join('TL_REKOMENDASI R', 'R.ID_TEMUAN = T.ID', 'LEFT')
                    ->join('PIC_REKOMENDASI PR', 'PR.ID_REKOMENDASI = R.ID', 'LEFT')
                    ->join('TM_JABATAN TJ', 'PR.PIC = TJ.ID_JABATAN', 'LEFT')
                    ->join('TL_ENTRY E', 'T.ID_TL = E.ID_TL')
                    ->where('T.STATUS', 1)
                    ->where('E.STATUS', 1)
                    ->where('E.TAHUN', $tahun)
                    ->where('E.AUDITEE', $id_divisi);
        if($id_jenis_audit != '') 
            $this->db->where('E.ID_JENIS_AUDIT', $id_jenis_audit);
        if($status != '') 
            $this->db->where('R.TK_PENYELESAIAN', $status);
        if($div_pic != '') 
            $this->db->where('TJ.ID_DIVISI', $div_pic);
            // $this->db->where('E.AUDITEE', $id_divisi);
        // else

        $this->db->group_by('T.ID');                 
        $this->db->order_by('T.ID', 'ASC');                 
        return $this->db->get()->result_array();
    }

    function temuan_data($tahun, $id_divisi, $id_jenis_audit='', $status='', $div_pic='')
    {
        if($id_jenis_audit!='') 
            $jns_audit = ' AND E."ID_JENIS_AUDIT" = $id_jenis_audit ';
        if($status!='') 
            $tk_penyelesaian = ' AND R."TK_PENYELESAIAN" = ' . "'$status'";
        // if($id_jenis_audit!='') 
        //     $jns_audit = ' AND E."ID_JENIS_AUDIT" = $id_jenis_audit ';
        $query = 'SELECT T."KRITERIA", T."ROOT_CAUSE", T."IMPLIKASI", T."KOMENTAR_AUDITI", T."JUDUL_TEMUAN" , T."TEMUAN", T."PRIORITAS" ,T."ID" AS ID_TEMUAN, array_to_json(ARRAY_AGG(R."REKOMENDASI" order by R."ID" ASC)) AS REKOMENDASI, array_to_json(ARRAY_AGG(R."BATAS_WAKTU" order by R."ID" ASC)) AS BATAS_WAKTU, array_to_json(ARRAY_AGG(J."NAMA_JABATAN")) AS PIC
            FROM "TL_REKOMENDASI" R LEFT JOIN "TL_TEMUAN" T ON R."ID_TEMUAN" = T."ID" LEFT JOIN "TL_ENTRY" E ON T."ID_TL" = E."ID_TL" LEFT JOIN "PIC_REKOMENDASI" PIC ON PIC."ID_REKOMENDASI" = R."ID" LEFT JOIN "TM_JABATAN" J ON J."ID_JABATAN" = PIC."PIC" WHERE T."STATUS" = 1 AND R."STATUS" = 1 AND E."TAHUN" = ' .$tahun .' AND E."AUDITEE" = '. $id_divisi . ' ' .$jns_audit.' GROUP BY T."ID" ORDER BY T."NO_URUT" ASC';
            // print_r($query);die();
        $exec   = $this->db->query($query);
        return $exec->result_array();
    }

    public function add($data, $table)
    {
        $this->db->insert($table, $data);
    }

    // derian
    public function rekomendasi_($id_temuan, $status='', $div_pic='')
    {
        if($status!='') $where_status = ' AND R."TK_PENYELESAIAN" = '."'".$status."' ";
        if($div_pic!='') $where_pic = ' AND tj."ID_DIVISI" = '."'".$div_pic."' ";
        $query = 'select
        R."ID_TEMUAN",
        R."ID" AS "ID_REKOMENDASI",
        R."REKOMENDASI",
        R."BATAS_WAKTU",
        R."TGL_PENYELESAIAN",
        R."HASIL_MONITORING",
        R."TK_PENYELESAIAN",
        R."STATUS",
        array_to_json(ARRAY_AGG(tj."NAMA_JABATAN" order by pr."PRIMARY")) as "PIC"
    from
        "TL_REKOMENDASI" R
        left join "PIC_REKOMENDASI" pr on pr."ID_REKOMENDASI"  = R."ID"
        left join "TM_JABATAN" tj  on tj."ID_JABATAN" = pr."PIC" 
    where
        R."STATUS" = 1 
        '. $where_status.'
        '. $where_pic.'
        AND 
        R."ID_TEMUAN" = ' . $id_temuan . '
        group by 
        R."ID_TEMUAN",
        R."ID",
        R."REKOMENDASI",
        R."BATAS_WAKTU",
        R."TGL_PENYELESAIAN",
        R."PIC",
        R."HASIL_MONITORING",
        R."TK_PENYELESAIAN",
        R."STATUS"';
        // print_r($query);die();
        $exec   = $this->db->query($query);
        return $exec->result_array();
    }

    public function rekomDashboard($tahun = "", $divisi = "")
    {
        $filter = "";
        $filter .= ($divisi) ? ' AND te."AUDITEE" =' . $divisi : ' ';
        $filter .= ($tahun) ? ' AND te."TAHUN" =' . $tahun : ' ';
        $query = 'select
        td."NAMA_DIVISI",
            R."ID_TEMUAN",
            tt."TEMUAN", 
            R."ID" AS "ID_REKOMENDASI",
            R."REKOMENDASI",
            R."BATAS_WAKTU",
            R."TGL_PENYELESAIAN",
            R."HASIL_MONITORING",
            R."TK_PENYELESAIAN",
            R."STATUS",
            array_to_json(ARRAY_AGG(tj."NAMA_JABATAN" order by pr."PRIMARY")) as "PIC",
            te.created_at
        from
            "TL_REKOMENDASI" R
            left join "PIC_REKOMENDASI" pr on pr."ID_REKOMENDASI"  = R."ID"
            left join "TM_JABATAN" tj  on tj."ID_JABATAN" = pr."PIC" 
            left join "TL_TEMUAN" tt on tt."ID" = R."ID_TEMUAN" 
            left join "TL_ENTRY" te on te."ID_TL" = tt."ID_TL" 
            left join "TM_DIVISI" td on td."ID_DIVISI" = te."AUDITEE" 
        where
            R."STATUS" = 1 ' . $filter . '
            group by 
            td."NAMA_DIVISI",
            R."ID_TEMUAN",
            R."ID",
            R."REKOMENDASI",
            R."BATAS_WAKTU",
            R."TGL_PENYELESAIAN",
            R."PIC",
            R."HASIL_MONITORING",
            R."TK_PENYELESAIAN",
            R."STATUS",
            tt."TEMUAN",
            te.created_at
            order by te.created_at';

        return $this->db->query($query)->result_array();
    }

    public function getYearTl()
    {
        return $this->db->query('SELECT DISTINCT A."TAHUN" FROM "TL_ENTRY" A WHERE A."STATUS" = 1 order by A."TAHUN" DESC')->result_array();
    }

    public function getAuditeeTl($tahun)
    {
        return $this->db->query('SELECT DISTINCT B."ID_DIVISI", B."NAMA_DIVISI"  FROM "TL_ENTRY" A left join "TM_DIVISI" B on B."ID_DIVISI" = A."AUDITEE"  WHERE (A."SELESAI" IS NULL OR A."SELESAI" = 0) AND A."STATUS" = 1 AND A."TAHUN" = ' . $tahun . ' order by B."NAMA_DIVISI" DESC')->result_array();
    }

    public function temuanDashboard($tahun = "", $divisi = "")
    {
        $filter = "";
        $filter .= ($divisi) ? ' AND te."AUDITEE" =' . $divisi : ' ';
        $filter .= ($tahun) ? ' AND te."TAHUN" =' . $tahun : ' ';

        $temuan = $this->db->query('select tt."ID" "ID_TEMUAN", tt."JUDUL_TEMUAN", tt."TEMUAN", td."NAMA_DIVISI" "AUDITEE" from "TL_TEMUAN" tt
        left join "TL_ENTRY" te  on te."ID_TL"  = tt."ID_TL" 
        left join "TM_DIVISI" td on td."ID_DIVISI" = te."AUDITEE" 
        where (te."SELESAI" IS NULL OR te."SELESAI" = 0) AND te."STATUS" = 1 ' . $filter . ' order by tt."ID" ASC')->result_array();

        $arrTemuan = array();
        $dataTemuan = array();
        foreach ($temuan as $item_temuan) {
            $rekomendasi = $this->db->query('select
            R."ID_TEMUAN",
                R."ID" as "ID_REKOMENDASI",
                R."REKOMENDASI",
                R."BATAS_WAKTU",
                R."TGL_PENYELESAIAN",
                R."HASIL_MONITORING",
                R."TK_PENYELESAIAN",
                R."STATUS",
                array_to_json(ARRAY_AGG(tj."NAMA_JABATAN" order by pr."PRIMARY")) as "PIC"
            from
                "TL_REKOMENDASI" R
            left join "PIC_REKOMENDASI" pr on
                pr."ID_REKOMENDASI" = R."ID"
            left join "TM_JABATAN" tj on
                tj."ID_JABATAN" = pr."PIC"
            where R."STATUS" = 1 and R."ID_TEMUAN" = ' . $item_temuan['ID_TEMUAN'] . '
            group by
                R."ID_TEMUAN",
                R."ID",
                R."REKOMENDASI",
                R."BATAS_WAKTU",
                R."TGL_PENYELESAIAN",
                R."PIC",
                R."HASIL_MONITORING",
                R."TK_PENYELESAIAN",
                R."STATUS"
                order by R."ID" ')->result_array();

            $arrTemuan['ID_TEMUAN'] = $item_temuan['ID_TEMUAN'];
            $arrTemuan['JUDUL_TEMUAN'] = $item_temuan['JUDUL_TEMUAN'];
            $arrTemuan['TEMUAN'] = $item_temuan['TEMUAN'];
            $arrTemuan['AUDITEE'] = $item_temuan['AUDITEE'];
            $arrTemuan['TOTAL_REKOMENDASI'] = count($rekomendasi);
            $arrTemuan['REKOMENDASI'] = $rekomendasi;

            array_push($dataTemuan, $arrTemuan);
        }
        return $dataTemuan;
    }
}
