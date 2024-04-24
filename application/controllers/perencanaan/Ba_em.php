<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ba_em extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Pdf');
		$this->load->model('perencanaan/M_ba_em', 'm_ba_em');
		$this->load->model('perencanaan/M_spa', 'm_spa');
		$this->is_login();
		if(!$this->is_auditor()) $this->load->view('/errors/html/err_401');
	}

	public function index()
	{
		$data['list_status'] 	= $this->master_act->status();
		$data['menu']           = 'perencanaan';
		$data['sub_menu']       = 'ba_em';
        $data['title']          = 'Notulen Entrance Meeting';
        $data['content']        = 'content/perencanaan/ba_em/v_ba_em';
        $this->show($data);
	}

	public function ba_em_json() 
	{
        header('Content-Type: application/json');
        if($this->input->server('REQUEST_METHOD') === 'POST') echo json_encode($this->m_ba_em->get_ba_em($this->session->ID_USER));
	}
	
	public function create()
	{
		$id_ba_em = $this->input->get('id');
		$id_ba_em = base64_decode($id_ba_em);
		if (!empty($id_ba_em) || $id_ba_em != null) {
			$data_ba_em				= $this->m_ba_em->get_ba_em($this->session->ID_USER, $id_ba_em);
			$peserta				= $this->m_ba_em->get_peserta($id_ba_em);
			$data['nomor_surat'] 	= $data_ba_em->NOMOR_SURAT;
			$data['id_spa'] 		= $data_ba_em->ID_SPA;
			$data['data_ba_em']		= $data_ba_em;
			$data['peserta'] 		= $peserta;
			$data['disabled'] 		= 'disabled';
		}
		$data['list_user'] 			= $this->master_act->user();
		$data['list_divisi'] 		= $this->master_act->divisi();
		$data['menu']         		= 'perencanaan';
		$data['sub_menu']     		= 'ba_em';
		$data['sub_menu_2']   		= 'kotak_keluar_ba_em';
		$data['nomor_spa']  		= $this->m_spa->spa_list();
        $data['title']          	= 'Create Notulen Entrance Meeting';
        $data['content']        	= 'content/perencanaan/ba_em/v_create_ba_em';
        $this->show($data);
  }
  
  public function generate()
  {
  		$id_ba_em = $this->input->get('id');
		$id_ba_em = base64_decode($id_ba_em);
    	$request = $this->input->post();
		$data = [
			'DETAIL_A'		=> $request['DETAIL_A'],
			'ID_DIVISI'		=> $request['ID_DIVISI'],
			'ID_SPA'		=> $request['ID_SPA'],
			'JUDUL'			=> trim(htmlspecialchars($this->input->post('JUDUL', TRUE))),
			'TANGGAL'		=> $request['TANGGAL'],
			'TEMPAT'		=> trim(htmlspecialchars($this->input->post('TEMPAT', TRUE))),
			'WAKTU'			=> trim(htmlspecialchars($this->input->post('WAKTU', TRUE))),
			'ID_PEMBUAT' 	=> $this->session->ID_USER
		];
		if (!empty($id_ba_em) || $id_ba_em != null) 
			unset($data['ID_SPA']);
		$tanggal_cs = [
			'TGL_ENTRANCE_DISUSUN'	=> $request['TANGGAL'],
		];
		$peserta = $this->input->post('PESERTA');
		$save = (!empty($id_ba_em) || $id_ba_em != null) ? $this->m_ba_em->send_update($data, $peserta, $tanggal_cs, $id_ba_em) : $this->m_ba_em->save($data, $peserta, $tanggal_cs);
		echo $save;
  }

	public function cetak_preview()
	{
		$id = $this->input->get('id');
		$id = base64_decode($id);
		$get_baem 				= $this->m_ba_em->get_ba_em($this->session->ID_USER, $id);
		$data_baem['hari'] 		= hari_indo($get_baem->TANGGAL);
		$data_baem['tanggal'] 	= tgl_indo($get_baem->TANGGAL);
		$data_baem['tahun'] 	= substr(($get_baem->TANGGAL),0,4);
		$data_baem['data_baem'] = $get_baem;
		$data_baem['peserta']	= $this->m_ba_em->get_peserta($id);
		$data_baem['title'] 	= '';
		// $data_baem['author'] 		=  $this->m_user->user($this->session->ID_USER)[0];
		$this->load->view('/content/cetak/ba_em', $data_baem);
	}

	public function cetak_preview_mpdf($id)
	{
		$get_baem 			= $this->m_ba_em->get_ba_em($this->session->ID_USER, $id);
		$data['hari'] 		= hari_indo($get_baem->TANGGAL);
		$data['tanggal'] 	= tgl_indo($get_baem->TANGGAL);
		$data['data'] 		= $get_baem;
		$data['peserta']	= $this->m_ba_em->get_peserta($id);
		$data['title'] 		= '';
		if($get_baem->TANDA_TANGAN != '') 
			$data['ttd'] 	= '<img height="100" src="'.base_url().'storage/upload/tanda_tangan/'.$get_baem->TANDA_TANGAN.'">';
		else 
			$data['ttd'] 	= '<br><br><br><br>';
		$html = $this->load->view('content/cetak/ba_em', $data, true);
        require_once FCPATH . 'vendor/autoload.php';
		$mpdf = new \Mpdf\Mpdf([
							'default_font_size' => 7,
							'default_font' => 'dejavusans',
							'format' => 'A4-P'
						]);
		$mpdf->AddPageByArray(['margin-left' => 15, 'margin-right' => 15, 'margin-top' => 15, 'margin-bottom' => 15, ]);
		$mpdf->list_auto_mode = 'mpdf';
		$mpdf->SetHTMLFooter('<table border="0" width="100%" style="text-align:left;"><tr><td>'.APK_NAME.' - '.COMPANY.'</td><td style="text-align:right;">Halaman {PAGENO} / {nb}</td></tr></table>');
		$mpdf->WriteHTML($html);
		$mpdf->Output();
	}

}
