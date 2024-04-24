<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting_ttd_spa extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->is_login();
        $this->is_auditor();
        if(!$this->is_auditor()) $this->load->view('/errors/html/err_401');
	}

	public function index()
	{
        $data['data']           = $this->db->get('TTD_SPA')->row();
        $data['menu']           = 'setting_ttd_spa';
        $data['sub_menu']       = 'setting_ttd_spa';
        $data['title']          = 'Setting Tanda Tangan Surat Perintah Audit (SPA)';
        $data['content']        = 'content/v_setting_ttd_spa';
        $this->show($data);
	}

	public function ubah_ttd()
    {
        $nama  	    = trim(htmlspecialchars($this->input->post('nama', TRUE)));
        $jabatan  	= trim($this->input->post('jabatan'));
        $jabatan    = str_replace("<p>","",$jabatan);
        $jabatan    = str_replace("</p>","",$jabatan);

        $data = array(
            'NAMA'          => $nama,
            'JABATAN'       => $jabatan
        );
        $query = $this->db->update('TTD_SPA', $data);
        if($query) echo 'OK';
    }

}
