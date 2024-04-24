<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
class M_tl_entry extends CI_Model
{

	function tl_entry($id_spa)
	{
		$query 	= 'SELECT E.* FROM "TL_ENTRY" E WHERE E."ID_SPA" = ' . "'$id_spa'";
		$exec 	= $this->db->query($query);
		return $exec->row();
	}

	public function lha($id_tl = '')
	{
		$this->db->select('E.*, D.ID_DIVISI, D.NAMA_DIVISI, JA.JENIS_AUDIT')
							->from('TL_ENTRY E')
							->join('TM_DIVISI D', 'D.ID_DIVISI = E.AUDITEE', 'LEFT')
							->join('TM_JENIS_AUDIT JA', 'JA.ID_JENIS_AUDIT = E.ID_JENIS_AUDIT', 'LEFT')
							->where('E.STATUS', 1);
		if($id_tl != '') $this->db->where('E.ID_TL', $id_tl);
		$this->db->order_by('E.TANGGAL_LHA DESC', 'E.MASA_AUDIT_AWAL DESC');					
		return $this->db->get()->result_array();
	}

	public function getTotalRekomendasi($id_tl='',$tk_penyelesaian='')
	{
		$query 	= 'SELECT R."ID" FROM "TL_REKOMENDASI" R 
			LEFT JOIN "TL_TEMUAN" T ON T."ID" = R."ID_TEMUAN"
			WHERE R."STATUS"=1
			AND T."STATUS" =1
			AND T."ID_TL"= '.$id_tl;
		if($tk_penyelesaian!='') 
			$query .= ' AND R."TK_PENYELESAIAN"= ' . "'" . $tk_penyelesaian . "'";
		$exec 	= $this->db->query($query);
		return $exec->num_rows();
	}

	function cek_lha($id_jenis_audit, $auditee, $tahun_audit)
	{
		$query 	= 'SELECT E.* FROM "TL_ENTRY" E WHERE E."STATUS" = 1 AND E."ID_JENIS_AUDIT" = ' . "'$id_jenis_audit'" . ' AND E."AUDITEE" = ' . "'$auditee'" . ' AND E."TAHUN" = ' . "'$tahun_audit'";
		$exec 	= $this->db->query($query);
		return $exec->row();
	}

	function cari($nomor_spa)
	{
		$query                       = 'SELECT SPA.* FROM "SPA" SPA WHERE SPA."ID_STATUS" = 3 AND SPA."NOMOR_SURAT" = ' . "'$nomor_spa'";
		$exec                        = $this->db->query($query);
		return $exec;
	}

	public function spa($id_spa = '')
	{
		$query 	= 'SELECT SPA.* FROM "SPA" SPA WHERE SPA."ID_STATUS" = 3 ';
		if ($id_spa != '') $query 	.= ' AND SPA."ID_SPA" = ' . "'$id_spa'";
		$exec 	= $this->db->query($query);
		return $exec->result_array();
	}

	public function temuan($id_tl)
	{
		$query 	= 'SELECT T.*, U."NAMA" AS "PEMBUAT", replace(T."TEMUAN",\'<img src=\',\'<img width="300" src=\') "TEMUAN2" FROM "TL_TEMUAN" T LEFT JOIN "TM_USER" U ON T."ID_PEMBUAT" = U."ID_USER" WHERE T."STATUS" = 1 AND T."ID_TL" = ' . $id_tl . ' ORDER BY T."NO_URUT" ASC';
		$exec 	= $this->db->query($query);
		return $exec->result_array();
	}

	public function temuan_auditee($id_jab)
	{
		$query 	= 'SELECT T."ID", T."NO_URUT", T."JUDUL_TEMUAN", E."TAHUN", D."NAMA_DIVISI" FROM "TL_TEMUAN" T
LEFT JOIN "TL_REKOMENDASI" R ON R."ID_TEMUAN" = T."ID"
LEFT JOIN "PIC_REKOMENDASI" P ON P."ID_REKOMENDASI" = R."ID"
LEFT JOIN "TL_ENTRY" E ON E."ID_TL" = T."ID_TL"
LEFT JOIN "TM_DIVISI" D ON D."ID_DIVISI" = E."AUDITEE"
WHERE P."PIC"='.$id_jab.'
AND T."STATUS" = 1
AND R."STATUS" = 1
AND E."STATUS" = 1
GROUP BY T."ID", D."NAMA_DIVISI", E."TAHUN" ORDER BY E."TAHUN" DESC, T."NO_URUT" ASC';
		$exec 	= $this->db->query($query);
		return $exec->result_array();
	}

	public function hal($id_tl)
	{
		$query 	= 'SELECT T.*, U."NAMA" AS "PEMBUAT", replace(T."OBSERVASI",\'<img src=\',\'<img width="300" src=\') "TEMUAN2" FROM "TL_PERHATIAN" T LEFT JOIN "TM_USER" U ON T."ID_PEMBUAT" = U."ID_USER" WHERE T."STATUS" = 1 AND T."ID_TL" = ' . $id_tl . ' ORDER BY T."NO_URUT" ASC';
		$exec 	= $this->db->query($query);
		return $exec->result_array();
	}

	public function last_id($tabel)
	{
		$query  = 'SELECT MAX("ID") FROM "' . $tabel . '"';
		$exec   = $this->db->query($query);
		return $exec->row();
	}

	public function temuan_detail($id_temuan)
	{
		$query 	= 'SELECT T.*, E."ID_TL" FROM "TL_TEMUAN" T LEFT JOIN "TL_ENTRY" E ON T."ID_TL" = E."ID_TL" WHERE T."ID" = ' . "'$id_temuan'";
		$exec 	= $this->db->query($query);
		return $exec->row();
	}

	public function rekomendasi($id_tl, $status = '')
	{
		$query 	= 'SELECT R.*, U."NAMA" AS "PEMBUAT", T."JUDUL_TEMUAN" FROM "TL_REKOMENDASI" R LEFT JOIN "TM_USER" U ON R."ID_PEMBUAT" = U."ID_USER" LEFT JOIN "TL_TEMUAN" T ON T."ID" = R."ID_TEMUAN" WHERE T."ID_TL" = ' . "'$id_tl'";
		if ($status != '') $query .= ' AND R."STATUS" = ' . "'$status'";
		$exec 	= $this->db->query($query);
		return $exec->result_array();
	}

	// derian update
	public function _rekomendasi($id, $status = '')
	{
		$filter = "";

		if ($status != '') $filter = ' AND R."STATUS" = ' . "'$status'";

		$query 	= 'SELECT T."ID_TL", R."ID", R."BATAS_WAKTU", R."REKOMENDASI", R."TGL_PENYELESAIAN", R."TK_PENYELESAIAN", U."NAMA" AS "PEMBUAT", T."JUDUL_TEMUAN", 
		STRING_AGG(\'<li>\' || tj."NAMA_JABATAN" || \'</li>\' , \'\' order by pr."PRIMARY") AS PIC, R."STATUS", R."ID_TEMUAN",
		replace(R."REKOMENDASI",\'<img src=\',\'<img width="300" src=\') "REKOMENDASI2"
		FROM "TL_REKOMENDASI" R 
		LEFT JOIN "TM_USER" U ON R."ID_PEMBUAT" = U."ID_USER" 
		LEFT JOIN "TL_TEMUAN" T ON T."ID" = R."ID_TEMUAN"
		left join "PIC_REKOMENDASI" pr  on pr."ID_REKOMENDASI"  = R."ID"
		left join "TM_JABATAN" tj on tj."ID_JABATAN"  = pr."PIC" 
		WHERE T."ID" = ' . $id . $filter . '
		group by T."ID_TL", R."ID", R."BATAS_WAKTU", R."REKOMENDASI", R."TGL_PENYELESAIAN", R."TK_PENYELESAIAN", U."NAMA", T."JUDUL_TEMUAN"
		ORDER BY R."ID" ASC';

		$exec 	= $this->db->query($query);
		return $exec->result_array();
	}

	public function _rekomendasi_auditee($id, $status = '')
	{
		$filter = "";

		if ($status != '') $filter = ' AND R."STATUS" = ' . "'$status'";

		$query 	= 'SELECT T."ID_TL", R."ID", R."BATAS_WAKTU", R."REKOMENDASI", R."TGL_PENYELESAIAN", R."TK_PENYELESAIAN", U."NAMA" AS "PEMBUAT", T."JUDUL_TEMUAN", 
		STRING_AGG(\'<li>\' || tj."NAMA_JABATAN" || \'</li>\' , \'\' order by pr."PRIMARY") AS PIC, R."STATUS", R."ID_TEMUAN",
		replace(R."REKOMENDASI",\'<img src=\',\'<img width="300" src=\') "REKOMENDASI2"
		FROM "TL_REKOMENDASI" R 
		LEFT JOIN "TM_USER" U ON R."ID_PEMBUAT" = U."ID_USER" 
		LEFT JOIN "TL_TEMUAN" T ON T."ID" = R."ID_TEMUAN"
		left join "PIC_REKOMENDASI" pr  on pr."ID_REKOMENDASI"  = R."ID"
		left join "TM_JABATAN" tj on tj."ID_JABATAN"  = pr."PIC" 
		WHERE pr."PIC" = '.$this->session->ID_JABATAN.' AND
		T."ID" = ' . $id . $filter . '
		group by T."ID_TL", R."ID", R."BATAS_WAKTU", R."REKOMENDASI", R."TGL_PENYELESAIAN", R."TK_PENYELESAIAN", U."NAMA", T."JUDUL_TEMUAN"
		ORDER BY R."ID" ASC';

		$exec 	= $this->db->query($query);
		return $exec->result_array();
	}

	public function get_recomendasi_byId($id)
	{
		$rekomendasi = $this->db->where('ID', $id)->get('TL_REKOMENDASI')->row_array();
		$pic = $this->db->where('ID_REKOMENDASI', $id)->get('PIC_REKOMENDASI')->result_array();
		$lampiran = $this->db->where('ID_REKOMENDASI', $id)->get('ATT_REKOMENDASI')->result_array();
		return array('rekomendasi' => $rekomendasi, 'pic' => $pic, 'lampiran' => $lampiran);
	}
	//end derian update

	public function hasil_monitoring($id)
	{
		$query 	= 'SELECT R.*, U."NAMA" AS "PEMBUAT", T."JUDUL_TEMUAN" FROM "TL_REKOMENDASI" R LEFT JOIN "TM_USER" U ON R."ID_PEMBUAT" = U."ID_USER" LEFT JOIN "TL_TEMUAN" T ON T."ID" = R."ID_TEMUAN" WHERE R."ID" = ' . "'$id'";
		$exec 	= $this->db->query($query);
		return $exec->row();
	}

	public function add($data, $table)
	{
		$this->db->insert($table, $data);
	}

	public function update($data, $id_tl)
	{
		$this->db->where('ID_TL', $id_tl);
		$this->db->update('TL_ENTRY', $data);
	}

	public function update_rekomendasi($data, $id_rekomendasi)
	{
		$this->db->where('ID', $id_rekomendasi);
		$this->db->update('TL_REKOMENDASI', $data);
	}

	//UPDATE DERIAN
	public function update_temuan($data, $id)
	{
		$this->db->where('ID', $id);
		$this->db->update('TL_TEMUAN', $data);
	}

	public function get_lampiran_temuan($id)
	{
		return $this->db->where('ID_TEMUAN', $id)->order_by('ID', 'ASC')->get('ATT_TEMUAN')->result_array();
	}

	public function delete($table, $key, $id)
	{
		$this->db->where($key, $id)->delete($table);
	}

	// update hasil monitoring
	public function list_update_hasil_monitoring($id_jabatan)
	{
		$query = 'select te."ID_TL" ,te."STATUS", td."ID_DIVISI", td."NAMA_DIVISI", tja."ID_JENIS_AUDIT", tja."JENIS_AUDIT", tt."JUDUL_TEMUAN", tt."TEMUAN", tr."ID" AS "ID_REKOMENDASI", tr."REKOMENDASI", tr."BATAS_WAKTU", tr."TGL_PENYELESAIAN", tr."STATUS", tr."TK_PENYELESAIAN", te."TAHUN" from "TL_REKOMENDASI" tr
		left join "TL_TEMUAN" tt on tt."ID" = tr."ID_TEMUAN"
		left join "TL_ENTRY" te on te."ID_TL" = tt."ID_TL"
		left join "TM_DIVISI" td on td."ID_DIVISI" = te."AUDITEE"
		left join "TM_JENIS_AUDIT" tja on tja."ID_JENIS_AUDIT"  = te."ID_JENIS_AUDIT"
		where te."STATUS" = 1 and tr."ID" in (select pr."ID_REKOMENDASI" from "PIC_REKOMENDASI" pr where pr."PIC" = ' . $id_jabatan . ')
		order by tr."ID" DESC';
		$exec 	= $this->db->query($query);
		return $exec->result_array();
	}

	public function hasil_monitoring_($id)
	{
		$query = $this->db->select('te.ID_TL, te.STATUS, tt.NO_URUT, td.NAMA_DIVISI, tja.JENIS_AUDIT, te.TAHUN, tt.JUDUL_TEMUAN, tt.TEMUAN, tr.ID as ID_REKOMENDASI, tr.REKOMENDASI, tr.DOKUMEN_PENDUKUNG, tr.BATAS_WAKTU, tr.TGL_PENYELESAIAN, tr.STATUS, tr.TK_PENYELESAIAN, tr.HASIL_MONITORING, tr.ID_PEMBUAT as ID_PEMBUAT_REKOM, upd.NAMA as UPDATE_OLEH')
							->from('TL_REKOMENDASI tr')
							->join('TL_TEMUAN tt', 'tt.ID = tr.ID_TEMUAN', 'LEFT')
							->join('TL_ENTRY te', 'te.ID_TL = tt.ID_TL', 'LEFT')
							->join('TM_DIVISI td', 'td.ID_DIVISI = te.AUDITEE', 'LEFT')
							->join('TM_USER upd', 'tr.UPDATED_BY = upd.ID_USER', 'LEFT')
							->join('TM_JENIS_AUDIT tja', 'tja.ID_JENIS_AUDIT  = te.ID_JENIS_AUDIT', 'LEFT')
							->where('te.STATUS', 1)
							->where('tr.ID', $id);				
		return $query->get()->row_array();
	}

	public function get_lampiran_hasil_monitoring_json($id)
	{
		return $this->db->where('ID_REKOMENDASI', $id)->order_by('ID', 'ASC')->get('ATT_HASIL_MONITORING')->result_array();
	}

	public function chcek_pic_type($id_rekomendasi, $pic)
	{
		return $this->db->where('ID_REKOMENDASI', $id_rekomendasi)->where('PIC', $pic)->get('PIC_REKOMENDASI')->row_array();
	}

	public function get_temuan_by_id($id)
	{
		return $this->db->where('ID', $id)->get('TL_TEMUAN')->row_array();
	}

	public function get_hal_by_id($id)
	{
		return $this->db->where('ID', $id)->get('TL_PERHATIAN')->row_array();
	}

	public function list_rekomendasi_json()
	{
		$query = $this->db->select('PR.ID, PR.ID_REKOMENDASI, TR.REKOMENDASI, TR.BATAS_WAKTU, TK_PENYELESAIAN, TT.NO_URUT, TT.JUDUL_TEMUAN, TE.ID_TL')
					->from('PIC_REKOMENDASI PR')
					->join('TL_REKOMENDASI TR', 'PR.ID_REKOMENDASI  = TR.ID', 'LEFT')
					->join('TL_TEMUAN TT', 'TR.ID_TEMUAN  = TT.ID', 'LEFT')
					->join('TL_ENTRY TE', 'TT.ID_TL  = TE.ID_TL', 'LEFT')
					->where(array('PR.PIC' => $this->session->ID_JABATAN))
					->where('TT.STATUS', 1)
					->where('TR.STATUS', 1)
					->get();
		return $query->result_array();
	}
}
