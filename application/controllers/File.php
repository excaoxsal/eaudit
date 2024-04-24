<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class File extends MY_Controller {

	var $menu = '';

	public function __construct()
	{
		parent::__construct();
        // $this->load->helper('directory');
        $this->load->helper('file');
		$this->is_login();
        $this->is_auditor();
	}

	public function index()
	{
        $this->menu 		= 'file';
		$total_divisi 		= $this->db->get_where("TM_DIVISI", ["STATUS" => 1])->num_rows();
		$bagidua			= ceil($total_divisi/2);
		$kolom_1 			= $this->_getDivisi($bagidua, 0);
		$kolom_2 			= $this->_getDivisi($bagidua, $bagidua);
		$matrix 			= $this->db->get('TM_MATRIX_FILE')->result_array();
		// print_r($kolom_2);die();
		// foreach ($query as $row) $divisi[$row['ID_DIVISI']] = $row['NAMA_DIVISI'];
        // $data['dir'] 		= 'storage/uploads/';
        // $read_path 			= directory_map($data['dir']);
        // $data['read_path'] 	= $read_path;
        $data['kolom_1'] 	= $kolom_1;
        $data['kolom_2'] 	= $kolom_2;
        $data['matrix'] 	= $matrix;
		$data['menu'] 		= $this->menu;
		$data['title'] 		= 'Browse File';
		$data['content'] 	= 'content/v_file';
		$this->show($data);
	}

	private function _getDivisi($limit, $start)
	{
		return $this->db->select('ID_DIVISI, NAMA_DIVISI')->from('TM_DIVISI')->where("STATUS", 1)->limit($limit, $start)->order_by('NAMA_DIVISI', 'ASC')->get()->result_array();
	}

	public function input()
	{
		$id_divisi 			= base64_decode($this->input->get('id'));
		$id_matrix_file 	= base64_decode($this->input->get('mx'));
		$data['divisi'] 	= $this->db->select('ID_DIVISI, NAMA_DIVISI')->from('TM_DIVISI')->where('ID_DIVISI', $id_divisi)->get()->row();
		$data['mx_file'] 	= $this->db->select('ID, KD_MATRIX, NAMA')->from('TM_MATRIX_FILE')->where('ID', $id_matrix_file)->get()->row();
		$data['title'] 		= 'Input File';
		$data['content'] 	= 'content/v_file_input';
		$this->show($data);
	}

}
