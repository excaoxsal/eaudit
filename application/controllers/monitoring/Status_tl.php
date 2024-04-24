<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Status_tl extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Pdf');
		$this->load->model('monitoring/m_status_tl', 'm_status_tl');
		$this->is_login();
		if(!$this->is_auditor()) $this->load->view('/errors/html/err_401');
	}

	public function index()
	{
		$data['menu']           = 'monitoring';
		$data['sub_menu']       = 'rekap';
		$data['sub_menu_2']     = 'auditee';
		$data['list_ja']        = $this->master_act->jenis_audit();
		$data['list_divisi']    = $this->master_act->divisi();
		$data['div_pusat']   	= $this->db->get_where('TM_DIVISI', array('IS_CABANG' => 'N', 'STATUS' => 1, 'ID_DIVISI !=' => 19))->result_array();
		$data['title']          = 'Rekap Monitoring Hasil Audit';
        $data['content']        = 'content/monitoring/v_status_tl';
        $this->show($data);
	}

	public function export($tahun, $id_divisi, $id_jenis_audit)
	{
		print_r($tahun);
		die();
	}

	public function cetak($tahun = '', $id_divisi = '', $id_jenis_audit = '')
	{
		$status 				= base64_decode($this->input->get('s'));
		$div_pic				= base64_decode($this->input->get('p'));

		// $temuan 				= $this->m_status_tl->temuan($tahun, $id_divisi, $id_jenis_audit, $status);
		$temuan 				= $this->m_status_tl->temuan($tahun, $id_divisi, $id_jenis_audit, $status, $div_pic);
		$laporan 				= array();
		$total_rekom 			= 0;
		$tk_penyelesaian 		= array('selesai' => 0, 'stl' => 0, 'btl' => 0, 'tptd' => 0);
		$tk_penyelesaian_rekom 	= array();
		$selesai 				= 0;
		$stl 					= 0;
		$btl 					= 0;
		$tptd 					= 0;
		foreach ($temuan as $data) {
			$rekomendasi	= $this->m_status_tl->rekomendasi_($data['ID'], $status, $div_pic);
			$add_form = array(
				'REKOMEN' => $rekomendasi,
			);
			$add_attributes = array_merge($data, $add_form);
			array_push($laporan, $add_attributes);
			$total_rekom 	= $total_rekom +  count($rekomendasi);

			//generate count tk_penyelesaian
			$s 	= 0;
			$st = 0;
			$bt = 0;
			$tp = 0;
			$tk_penyelesaian_rekom[$data['ID']]['selesai'] 	= $s;
			$tk_penyelesaian_rekom[$data['ID']]['stl'] 		= $st;
			$tk_penyelesaian_rekom[$data['ID']]['btl'] 		= $bt;
			$tk_penyelesaian_rekom[$data['ID']]['tptd'] 	= $tp;

			foreach ($rekomendasi as $rekom) {
				if ($rekom['TK_PENYELESAIAN'] == 'Selesai') {
					$selesai++;
					$s++;
					$tk_penyelesaian['selesai'] = $selesai;
					$tk_penyelesaian_rekom[$data['ID']]['selesai'] = $s;
				}
				if ($rekom['TK_PENYELESAIAN'] == 'STL') {
					$stl++;
					$st++;
					$tk_penyelesaian['stl'] = $stl;
					$tk_penyelesaian_rekom[$data['ID']]['stl'] = $st;
				}
				if ($rekom['TK_PENYELESAIAN'] == 'BTL') {
					$btl++;
					$bt++;
					$tk_penyelesaian['btl'] = $btl;
					$tk_penyelesaian_rekom[$data['ID']]['btl'] = $bt;
				}
				if ($rekom['TK_PENYELESAIAN'] == 'TPTD') {
					$tptd++;
					$tp++;
					$tk_penyelesaian['tptd'] = $tptd;
					$tk_penyelesaian_rekom[$data['ID']]['tptd'] = $tp;
				}
			}
		}

		$jenis_audit = $this->master_act->jenis_audit($id_jenis_audit);
		$jenis_audit = strpos(strtoupper($jenis_audit[0]['JENIS_AUDIT']), 'INTERNAL') !== false ? 'INTERNAL' : 'EXTERNAL';

		$data['rekomendasi'] 			= $laporan;
		$data['total_rekom'] 			= $total_rekom;
		$data['temuan'] 				= $temuan;
		$data['divisi']					= $this->master_act->divisi($id_divisi);
		$data['jenis_audit'] 			= $jenis_audit;
		$data['tahun'] 					= $tahun;
		$data['tk_penyelesaian'] 		= $tk_penyelesaian;
		$data['tk_penyelesaian_rekom'] 	= $tk_penyelesaian_rekom;
		$data['asm_spi'] 				= $this->master_act->user(array('J.ID_JABATAN' => ID_JAB_ASM_SPI));
		$pic_ttd 						= $div_pic != '' ? $div_pic : $id_divisi;
		$data['pic_div'] 				= $this->master_act->user(array('J.IS_PIC' => 'Y', 'J.ID_DIVISI' => $pic_ttd))[0];
		// print_r($data['pic']);die();

		$this->load->view('/content/cetak/status_tl', $data);
	}
}
