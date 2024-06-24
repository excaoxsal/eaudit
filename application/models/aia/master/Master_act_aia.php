<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
class Master_act_aia extends CI_Model{

	public function status()
    {
        $query	= $this->db->get("TM_STATUS");
        return $query->result_array();
    }

    public function role($id='')
    {
        $this->db->from('TM_ROLE');
        $this->db->where('STATUS', 1);
        if($id!='') $this->db->where('ID_ROLE', $id);
        $this->db->order_by('NAMA_ROLE','ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function jabatan($id='')
	{
		$this->db->select('J.*, D.NAMA_DIVISI, E.NAMA_JABATAN as NAMA_ATASAN');
        $this->db->from('TM_JABATAN J');
        $this->db->join("TM_DIVISI D", "D.ID_DIVISI = J.ID_DIVISI", "LEFT");
        $this->db->join("TM_JABATAN E", "J.ID_ATASAN = E.ID_JABATAN", "LEFT");
        $this->db->where('J.STATUS', 1);
        $this->db->where('D.IS_DIVISI', 'Y');
        $this->db->where('J.IS_AIA', 1);
        if($id!='') $this->db->where('J.ID_JABATAN', $id);
        $this->db->order_by('J.NAMA_JABATAN','ASC');
        $query=$this->db->get();
		return $query->result_array();
        //print_r($query->result_array());die();
	}

	public function frekuensi_kontrol($id='')
    {
        $this->db->from('TM_FREKUENSI_KONTROL');
        $this->db->where('STATUS', 1);
        if($id!='') $this->db->where('ID_FREKUENSI_KONTROL', $id);
        $this->db->order_by('FREKUENSI_KONTROL','ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function tipe_kontrol($id='')
    {
        $this->db->from('TM_TIPE_KONTROL');
        $this->db->where('STATUS', 1);
        if($id!='') $this->db->where('ID_TIPE_KONTROL', $id);
        $this->db->order_by('TIPE_KONTROL','ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function jenis_audit($id='')
    {
        $this->db->from('TM_JENIS_AUDIT');
        $this->db->where('STATUS', 1);
        if($id!='') $this->db->where('ID_JENIS_AUDIT', $id);
        $this->db->order_by('JENIS_AUDIT','ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function tingkat_resiko($id='')
    {
        $this->db->from('TM_RESIKO');
        $this->db->where('STATUS', 1);
        if($id!='') $this->db->where('ID_RESIKO', $id);
        $this->db->order_by('RESIKO','ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function resiko_desc($id='')
    {
        $this->db->select('trd.*, td."NAMA_DIVISI", tk."KLASIFIKASI", tr."RESIKO"');
        $this->db->from('TM_RESIKO_DESC trd');
        $this->db->join('TM_DIVISI td', 'td."ID_DIVISI" = trd."DIVISI_ID"', 'left');
        $this->db->join('TM_KLASIFIKASI tk', 'tk."ID" = trd."KLASIFIKASI_ID"', 'left');
        $this->db->join('TM_RESIKO tr', 'tr."ID_RESIKO" = trd."TINGKAT_RESIKO_ID"', 'left');
        $this->db->where('trd.STATUS != ', 2);
        $this->db->order_by('trd.ID', 'DESC');

        if ($id) {
            $this->db->where('trd.ID', $id);
        }

        return $this->db->get()->result_array();
    }

    public function klasifikasi($id = '')
    {
        if ($id) {
            $this->db->where('ID', $id);
        }

        return $this->db->get('TM_KLASIFIKASI')->result_array();
    }

    public function divisi($id='')
    {
        if ($id != '') {
            $where = ' AND d1."ID_DIVISI" = ' . $id;
        }
        $query = 'SELECT d1.*,
            CASE
                WHEN d1."KODE_PARENT" IS NOT NULL THEN d2."NAMA_DIVISI"
                ELSE d1."NAMA_DIVISI"
            END AS nama_divisi,
            CASE
                WHEN d1."KODE_PARENT" IS NOT NULL THEN d1."NAMA_DIVISI"
                ELSE NULL
            END AS nama_sub_divisi
            FROM "TM_DIVISI" d1
            LEFT JOIN "TM_DIVISI" d2 ON d1."KODE_PARENT" = d2."KODE"
            WHERE d1."STATUS" = 1 AND d1."KODE" IS NOT NULL' . $where . '
            ORDER BY d1."NAMA_DIVISI" ASC';
            // echo "<pre>";
            // var_dump($this->db->query($query)->result_array());die();
            return $this->db->query($query)->result_array();
    }

    public function only_divisi($id='')
    {
        $this->db->select('*');
        $this->db->from('TM_DIVISI');
        $this->db->where('IS_DIVISI IS NOT NULL');
        $this->db->where('IS_DIVISI', 'Y');
        if($id!='') $this->db->where('ID_DIVISI', $id);
        $this->db->distinct('IS_DIVISI');
        $this->db->order_by('NAMA_DIVISI','ASC');
        $query=$this->db->get();
        return $query->result_array();
    }

    public function is_divisi($id='')
    {
        $this->db->select('IS_DIVISI');
        $this->db->from('TM_DIVISI');
        $this->db->where('IS_DIVISI IS NOT NULL');
        if($id!='') $this->db->where('ID_DIVISI', $id);
        $this->db->distinct('IS_DIVISI');
        $this->db->order_by('IS_DIVISI','DESC');
        $query=$this->db->get();
        return $query->result_array();
    }

    public function user($array_where='')
	{
		$this->db->select('U.ID_USER AS ID_USER, U.TANDA_TANGAN AS TANDA_TANGAN, U.NIPP AS NIPP, U.NAMA AS NAMA, U.PASSWORD AS PASSWORD, U.EMAIL AS EMAIL, U.STATUS AS STATUS, U.LAST_LOGIN AS LAST_LOGIN, J.ID_JABATAN AS ID_JABATAN, J.NAMA_JABATAN AS NAMA_JABATAN, D.ID_DIVISI AS ID_DIVISI, D.NAMA_DIVISI AS NAMA_DIVISI, R.ID_ROLE AS ID_ROLE, R.NAMA_ROLE AS NAMA_ROLE, U.ATASAN_I AS ID_ATASAN_I, A_I.NAMA AS ATASAN_I, U.ATASAN_II AS ID_ATASAN_II, A_II.NAMA AS ATASAN_II, U.ID_MENU as MENU');
        $this->db->from('TM_USER U');
        $this->db->join("TM_JABATAN J", "J.ID_JABATAN = U.ID_JABATAN", "LEFT");
        $this->db->join("TM_DIVISI D", "D.ID_DIVISI = J.ID_DIVISI", "LEFT");
        $this->db->join("TM_ROLE R", "R.ID_ROLE = U.ID_ROLE", "LEFT");
        $this->db->join("TM_USER A_I", "A_I.ID_USER = U.ATASAN_I", "LEFT");
        $this->db->join("TM_USER A_II", "A_II.ID_USER = U.ATASAN_II", "LEFT");
        // $this->db->where('U.STATUS', 1);
        if($array_where!='') $this->db->where($array_where);
        $this->db->order_by('U.NAMA','ASC');
        $query=$this->db->get();
		return $query->result_array();
	}

    public function menu($array_where='')
    {
        $this->db->select('ID_MENU as MENU');
        $this->db->from('TM_USER');
        if($array_where!='') $this->db->where($array_where);
        $this->db->where('ID_MENU IS NOT NULL');
        $this->db->distinct('ID_MENU');
        $this->db->order_by('ID_MENU','ASC');
        $query=$this->db->get();
        return $query->result_array();
    }
    
    public function auditor($array_where='') {
        $this->db->select('U.ID_USER AS ID_USER, 
                   U.TANDA_TANGAN AS TANDA_TANGAN, 
                   U.NIPP, 
                   U.NAMA AS NAMA, 
                   U.PASSWORD AS PASSWORD, 
                   U.EMAIL AS EMAIL, 
                   U.STATUS AS STATUS, 
                   U.LAST_LOGIN AS LAST_LOGIN, 
                   J.ID_JABATAN AS ID_JABATAN, 
                   J.NAMA_JABATAN AS NAMA_JABATAN, 
                   D.ID_DIVISI AS ID_DIVISI, 
                   D.NAMA_DIVISI AS NAMA_DIVISI, 
                   R.ID_ROLE AS ID_ROLE, 
                   R.NAMA_ROLE AS NAMA_ROLE, 
                   U.ATASAN_I AS ID_ATASAN_I, 
                   A_I.NAMA AS ATASAN_I, 
                   U.ATASAN_II AS ID_ATASAN_II, 
                   A_II.NAMA AS ATASAN_II');
        $this->db->from('TM_USER U');
        $this->db->join("TM_JABATAN J", "J.ID_JABATAN = U.ID_JABATAN", "LEFT");
        $this->db->join("TM_DIVISI D", "D.ID_DIVISI = J.ID_DIVISI", "LEFT");
        $this->db->join("TM_ROLE R", "R.ID_ROLE = U.ID_ROLE", "LEFT");
        $this->db->join("TM_USER A_I", "A_I.ID_USER = U.ATASAN_I", "LEFT");
        $this->db->join("TM_USER A_II", "A_II.ID_USER = U.ATASAN_II", "LEFT");
        if($array_where!='') $this->db->where($array_where);
        $this->db->order_by('U.NAMA','ASC');
        $query = $this->db->get();
        return $query->result_array();

    }
}
?>
