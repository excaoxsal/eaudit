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
        $this->db->select('
        d.NAMA_DIVISI as divisi,d.KODE,d.KODE_PARENT, 
        SUM(CASE WHEN t."STATUS" = \'CLOSE\' THEN 1 ELSE 0 END) AS closed,
        SUM(CASE WHEN t."STATUS" != \'CLOSE\' THEN 1 ELSE 0 END) AS open,
        i.NOMOR_ISO as ISO');
        $this->db->from('RESPONSE_AUDITEE_H h');
        $this->db->join('TEMUAN_DETAIL t','t.ID_RESPONSE=h.ID_HEADER','left');
        $this->db->join('TM_DIVISI d', 'h.DIVISI = d.KODE');
        $this->db->join('TM_ISO i','i.ID_ISO=h.ID_ISO');
        $this->db->where('d.IS_CABANG','N');
        $this->db->order_by('d.COUNT','ASC');
        $this->db->group_by('d.NAMA_DIVISI,d.COUNT,d.KODE,d.KODE_PARENT, ISO');
        
        $querydivisi = $this->db->get();
        $querysubdivisi=
        $this->db->select('
        t.SUB_DIVISI as subdivisi,d.NAMA_DIVISI as divisi,d.KODE_PARENT,
        SUM(CASE WHEN t."STATUS" = \'CLOSE\' THEN 1 ELSE 0 END) AS closed,
        SUM(CASE WHEN t."STATUS" != \'CLOSE\' THEN 1 ELSE 0 END) AS open,                
        i.NOMOR_ISO as ISO')
       ->from('TEMUAN_DETAIL t')
       ->join('RESPONSE_AUDITEE_H h','t.ID_RESPONSE = h.ID_HEADER','left')
       ->join('TM_DIVISI d', 'd.KODE = t.SUB_DIVISI')
       ->join('TM_ISO i','i.ID_ISO=h.ID_ISO')
       ->where('d.IS_CABANG','N')
       ->group_by('d.KODE_PARENT,d.COUNT,t.SUB_DIVISI,d.NAMA_DIVISI,ISO')
       
       ->having('t.SUB_DIVISI is not null')
       ->get();
        $resultsdivisi = [];
        $n=0;
        // var_dump($querydivisi->result(),$querysubdivisi->result());die;

        foreach ($querydivisi->result() as $row) {
            // Jika divisi belum ada di array $resultsdivisi, tambahkan divisi tersebut
            if (!isset($resultsdivisi[$row->divisi])) {
                $resultsdivisi[$row->divisi] = [
                    'iso9001' => ['closed' => 0, 'open' => 0, 'total' => 0],
                    'iso14001' => ['closed' => 0, 'open' => 0, 'total' => 0],
                    'iso37001' => ['closed' => 0, 'open' => 0, 'total' => 0],
                    'iso45001' => ['closed' => 0, 'open' => 0, 'total' => 0],
                    'kodedivisi'=>$row->KODE,
                    'namadivisi'=>$row->divisi,
                    'tipe' => 'Divisi',
                    
                ];
            }
            // var_dump($row->closed + $row->open);die;
        
            // Memasukkan data ISO ke dalam divisi yang sesuai
            switch ($row->ISO) {
                case 'ISO 9001':
                    $resultsdivisi[$row->divisi]['iso9001']['closed'] = $row->closed;
                    $resultsdivisi[$row->divisi]['iso9001']['open'] = $row->open;
                    $resultsdivisi[$row->divisi]['iso9001']['total'] = $row->closed + $row->open;
                    break;
                case 'ISO 14001':
                    $resultsdivisi[$row->divisi]['iso14001']['closed'] = $row->closed;
                    $resultsdivisi[$row->divisi]['iso14001']['open'] = $row->open;
                    $resultsdivisi[$row->divisi]['iso14001']['total'] = $row->closed + $row->open;
                    break;
                case 'ISO 37001':
                    $resultsdivisi[$row->divisi]['iso37001']['closed'] = $row->closed;
                    $resultsdivisi[$row->divisi]['iso37001']['open'] = $row->open;
                    $resultsdivisi[$row->divisi]['iso37001']['total'] = $row->closed + $row->open;
                    break;
                case 'ISO 45001':
                    $resultsdivisi[$row->divisi]['iso45001']['closed'] = $row->closed;
                    $resultsdivisi[$row->divisi]['iso45001']['open'] = $row->open;
                    $resultsdivisi[$row->divisi]['iso45001']['total'] = $row->closed + $row->open;
                    break;
                
            }
                // var_dump($resultsdivisi);die;    
        }
        foreach ($querysubdivisi->result() as $rowsubdivisi){
            if (!isset($resultsdivisi[$rowsubdivisi->divisi])) {
                $resultsdivisi[$rowsubdivisi->divisi] = [
                    'iso9001' => ['closed' => 0, 'open' => 0, 'total' => 0],
                    'iso14001' => ['closed' => 0, 'open' => 0, 'total' => 0],
                    'iso37001' => ['closed' => 0, 'open' => 0, 'total' => 0],
                    'iso45001' => ['closed' => 0, 'open' => 0, 'total' => 0],
                    'kodedivisi'=>$rowsubdivisi->KODE_PARENT,
                    'namadivisi'=>$rowsubdivisi->divisi,
                    'tipe' =>'Subdivisi',
                    
                    
                ];
            }
            // var_dump($rowsubdivisi);die;
            switch ($rowsubdivisi->ISO) {
            case 'ISO 9001':
                $resultsdivisi[$rowsubdivisi->divisi]['iso9001']['closed'] = $rowsubdivisi->closed;
                $resultsdivisi[$rowsubdivisi->divisi]['iso9001']['open'] = $rowsubdivisi->open;
                $resultsdivisi[$rowsubdivisi->divisi]['iso9001']['total'] = $rowsubdivisi->open + $rowsubdivisi->closed;
                break;
            case 'ISO 14001':
                $resultsdivisi[$rowsubdivisi->divisi]['iso14001']['closed'] = $rowsubdivisi->closed;
                $resultsdivisi[$rowsubdivisi->divisi]['iso14001']['open'] = $rowsubdivisi->open;
                $resultsdivisi[$rowsubdivisi->divisi]['iso14001']['total'] = $rowsubdivisi->open + $rowsubdivisi->closed;
                break;
            case 'ISO 37001':
                $resultsdivisi[$rowsubdivisi->divisi]['iso37001']['closed'] = $rowsubdivisi->closed;
                $resultsdivisi[$rowsubdivisi->divisi]['iso37001']['open'] = $rowsubdivisi->open;
                $resultsdivisi[$rowsubdivisi->divisi]['iso37001']['total'] = $rowsubdivisi->open + $rowsubdivisi->closed;
                break;
            case 'ISO 45001':
                $resultsdivisi[$rowsubdivisi->divisi]['iso45001']['closed'] = $rowsubdivisi->closed;
                $resultsdivisi[$rowsubdivisi->divisi]['iso45001']['open'] = $rowsubdivisi->open;
                $resultsdivisi[$rowsubdivisi->divisi]['iso45001']['total'] = $rowsubdivisi->open + $rowsubdivisi->closed;
                break;
            }
        }
        // var_dump($rowsubdivisi->open);die;  
        // asort($resultsdivisi);
        $result = [];
            foreach ($resultsdivisi as $element) {
                // var_dump($element);die;
                $result[$element['kodedivisi']][] = $element;
            }
        // var_dump($result);die;
        return $result;
    }
    public function getTemuanbyCabang(){
        $this->db->select('
        d.NAMA_DIVISI as divisi,d.KODE,d.KODE_PARENT, 
        SUM(CASE WHEN t."STATUS" = \'CLOSE\' THEN 1 ELSE 0 END) AS closed,
        SUM(CASE WHEN t."STATUS" != \'CLOSE\' THEN 1 ELSE 0 END) AS open,
        i.NOMOR_ISO as ISO');
        $this->db->from('RESPONSE_AUDITEE_H h');
        $this->db->join('TEMUAN_DETAIL t','t.ID_RESPONSE=h.ID_HEADER','left');
        $this->db->join('TM_DIVISI d', 'h.DIVISI = d.KODE');
        $this->db->join('TM_ISO i','i.ID_ISO=h.ID_ISO');
        $this->db->where('d.IS_CABANG','Y');
        $this->db->order_by('d.COUNT','ASC');
        $this->db->group_by('d.NAMA_DIVISI,d.COUNT,d.KODE,d.KODE_PARENT, ISO');
        
        $querydivisi = $this->db->get();
        $querysubdivisi=
        $this->db->select('
        t.SUB_DIVISI as subdivisi,d.NAMA_DIVISI as divisi,d.KODE_PARENT,
        SUM(CASE WHEN t."STATUS" = \'CLOSE\' THEN 1 ELSE 0 END) AS closed,
        SUM(CASE WHEN t."STATUS" != \'CLOSE\' THEN 1 ELSE 0 END) AS open,                
        i.NOMOR_ISO as ISO')
       ->from('TEMUAN_DETAIL t')
       ->join('RESPONSE_AUDITEE_H h','t.ID_RESPONSE = h.ID_HEADER','left')
       ->join('TM_DIVISI d', 'd.KODE = t.SUB_DIVISI')
       ->join('TM_ISO i','i.ID_ISO=h.ID_ISO')
       ->group_by('d.KODE_PARENT,d.COUNT,t.SUB_DIVISI,d.NAMA_DIVISI,ISO')
       
       ->having('t.SUB_DIVISI is not null')
       ->get();
        $resultsdivisi = [];
        $n=0;
        // var_dump($querydivisi->result(),$querysubdivisi->result());die;

        foreach ($querydivisi->result() as $row) {
            // Jika divisi belum ada di array $resultsdivisi, tambahkan divisi tersebut
            if (!isset($resultsdivisi[$row->divisi])) {
                $resultsdivisi[$row->divisi] = [
                    'iso9001' => ['closed' => 0, 'open' => 0, 'total' => 0],
                    'iso14001' => ['closed' => 0, 'open' => 0, 'total' => 0],
                    'iso37001' => ['closed' => 0, 'open' => 0, 'total' => 0],
                    'iso45001' => ['closed' => 0, 'open' => 0, 'total' => 0],
                    'kodedivisi'=>$row->KODE,
                    'namadivisi'=>$row->divisi,
                    'tipe' => 'Divisi',
                    
                ];
            }
            // var_dump($row->closed + $row->open);die;
        
            // Memasukkan data ISO ke dalam divisi yang sesuai
            switch ($row->ISO) {
                case 'ISO 9001':
                    $resultsdivisi[$row->divisi]['iso9001']['closed'] = $row->closed;
                    $resultsdivisi[$row->divisi]['iso9001']['open'] = $row->open;
                    $resultsdivisi[$row->divisi]['iso9001']['total'] = $row->closed + $row->open;
                    break;
                case 'ISO 14001':
                    $resultsdivisi[$row->divisi]['iso14001']['closed'] = $row->closed;
                    $resultsdivisi[$row->divisi]['iso14001']['open'] = $row->open;
                    $resultsdivisi[$row->divisi]['iso14001']['total'] = $row->closed + $row->open;
                    break;
                case 'ISO 37001':
                    $resultsdivisi[$row->divisi]['iso37001']['closed'] = $row->closed;
                    $resultsdivisi[$row->divisi]['iso37001']['open'] = $row->open;
                    $resultsdivisi[$row->divisi]['iso37001']['total'] = $row->closed + $row->open;
                    break;
                case 'ISO 45001':
                    $resultsdivisi[$row->divisi]['iso45001']['closed'] = $row->closed;
                    $resultsdivisi[$row->divisi]['iso45001']['open'] = $row->open;
                    $resultsdivisi[$row->divisi]['iso45001']['total'] = $row->closed + $row->open;
                    break;
                
            }
                // var_dump($resultsdivisi);die;    
        }
        foreach ($querysubdivisi->result() as $rowsubdivisi){
            if (!isset($resultsdivisi[$rowsubdivisi->divisi])) {
                $resultsdivisi[$rowsubdivisi->divisi] = [
                    'iso9001' => ['closed' => 0, 'open' => 0, 'total' => 0],
                    'iso14001' => ['closed' => 0, 'open' => 0, 'total' => 0],
                    'iso37001' => ['closed' => 0, 'open' => 0, 'total' => 0],
                    'iso45001' => ['closed' => 0, 'open' => 0, 'total' => 0],
                    'kodedivisi'=>$rowsubdivisi->KODE_PARENT,
                    'namadivisi'=>$rowsubdivisi->divisi,
                    'tipe' =>'Subdivisi',
                    
                    
                ];
            }
            // var_dump($rowsubdivisi);die;
            switch ($rowsubdivisi->ISO) {
            case 'ISO 9001':
                $resultsdivisi[$rowsubdivisi->divisi]['iso9001']['closed'] = $rowsubdivisi->closed;
                $resultsdivisi[$rowsubdivisi->divisi]['iso9001']['open'] = $rowsubdivisi->open;
                $resultsdivisi[$rowsubdivisi->divisi]['iso9001']['total'] = $rowsubdivisi->open + $rowsubdivisi->closed;
                break;
            case 'ISO 14001':
                $resultsdivisi[$rowsubdivisi->divisi]['iso14001']['closed'] = $rowsubdivisi->closed;
                $resultsdivisi[$rowsubdivisi->divisi]['iso14001']['open'] = $rowsubdivisi->open;
                $resultsdivisi[$rowsubdivisi->divisi]['iso14001']['total'] = $rowsubdivisi->open + $rowsubdivisi->closed;
                break;
            case 'ISO 37001':
                $resultsdivisi[$rowsubdivisi->divisi]['iso37001']['closed'] = $rowsubdivisi->closed;
                $resultsdivisi[$rowsubdivisi->divisi]['iso37001']['open'] = $rowsubdivisi->open;
                $resultsdivisi[$rowsubdivisi->divisi]['iso37001']['total'] = $rowsubdivisi->open + $rowsubdivisi->closed;
                break;
            case 'ISO 45001':
                $resultsdivisi[$rowsubdivisi->divisi]['iso45001']['closed'] = $rowsubdivisi->closed;
                $resultsdivisi[$rowsubdivisi->divisi]['iso45001']['open'] = $rowsubdivisi->open;
                $resultsdivisi[$rowsubdivisi->divisi]['iso45001']['total'] = $rowsubdivisi->open + $rowsubdivisi->closed;
                break;
            }
        }
        // var_dump($rowsubdivisi->open);die;  
        $result = [];
            foreach ($resultsdivisi as $element) {
                // var_dump($element);die;
                $result[$element['kodedivisi']][] = $element;
            }
        // var_dump($result);die;
        return $result;
    }

    public function getSubDivisi($divisi, $iso)
    {
        $this->db->select('t.SUB_DIVISI');
        $this->db->from('TEMUAN_DETAIL t');
        $this->db->join('RESPONSE_AUDITEE_H h','t.ID_RESPONSE = h.ID_HEADER','left');
        $this->db->join('TM_DIVISI d', 'd.KODE = h.DIVISI', 'left');
        $this->db->join('TM_ISO i','i.ID_ISO=h.ID_ISO','left');
        // $this->db->where('d.NAMA_DIVISI', $divisi);
        // $this->db->where('i.NOMOR_ISO', $iso);
        $query = $this->db->get();
        
        $sub_divisi = [];
        foreach ($query->result() as $row) {
            $sub_divisi[] = [
                'divisi' => $row->SUB_DIVISI
            ];
        }
        return $query;
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
