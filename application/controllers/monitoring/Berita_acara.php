<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Berita_acara extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Pdf');
		$this->load->model('monitoring/m_status_tl', 'm_status_tl');
		$this->load->model('Master_act', 'master_act');
		$this->is_login();
		// if(!$this->is_auditor()) $this->load->view('/errors/html/err_401');
	}

	public function index()
    {
        $data['menu']           = 'monitoring';
        $data['sub_menu']       = 'berita_acara';
        $data['list_ja']        = $this->master_act->jenis_audit();
        $data['list_divisi']    = $this->master_act->divisi();
        $data['title']          = 'Berita Acara';
        $data['content']        = 'content/monitoring/berita_acara/v_list_ba';
        $this->show($data);
    }

    public function create()
    {
    	$id 					= base64_decode($this->input->get('id'));
    	if($id!='')
    	{
    		$data_ba 				= $this->db->get_where('BERITA_ACARA', array('ID' => $id, 'is_deleted' => 0))->row();
    		if($data_ba)
	    	{
	    		$data['data_ba']	= $data_ba;
	    	}
    	}
    	// print_r($data);die();
        $data['menu']           = 'monitoring';
        $data['sub_menu']       = 'berita_acara';
        $data['list_jabatan']   = $this->master_act->jabatan();
        $data['list_jabatan_pj']   = $this->db->select('u.NAMA, j.NAMA_JABATAN, u.NIPP', 'j.ID_JABATAN')
        									->from('TM_JABATAN j')
        									->join('TM_USER u', 'u.ID_JABATAN = j.ID_JABATAN', 'left')
        									->where_in('j.ID_JABATAN', [54519, 54506])->get()->result_array();
        $data['list_divisi']    = $this->master_act->divisi();
        $data['title']          = 'Create Berita Acara';
        $data['content']        = 'content/monitoring/berita_acara/v_create_ba';
        if($this->is_auditor() && $this->input->server('REQUEST_METHOD') === 'POST')
        {
        	$this->_post();
        }
    	else
    	{
        	$this->show($data);
    	}
    }

    private function _post()
    {
    	$id 		= base64_decode($this->input->post('ID_BA'));
    	$id_jabatan = $this->input->post('PIC');
    	$pic 		= $this->db->select('u.NAMA, j.NAMA_JABATAN')->from('TM_USER u')
    					->join('TM_JABATAN j', 'u.ID_JABATAN = j.ID_JABATAN', 'LEFT')
    					->where('j.ID_JABATAN', $id_jabatan)
    					->get()->row();
    	$pj 		= $this->input->post('PJ');
    	$pj 		= explode("||", $pj);
    	$nama_pj 	= $pj[0];
    	$jab_pj 	= $pj[1];
    	$nipp_pj 	= $pj[2];
    	$this->db->trans_start();
    	$data 	= array(
    				'NOMOR' 		=> trim($this->input->post('NOMOR')),
    				'AUDITEE' 		=> trim($this->input->post('AUDITEE')),
    				'PIC' 			=> $id_jabatan,
    				// 'NAMA_PIC' 		=> $pic->NAMA,
    				// 'JABATAN_PIC' 	=> $pic->NAMA_JABATAN,
    				'NAMA_SPI' 		=> trim($nama_pj),
    				'JABATAN_SPI' 	=> trim($jab_pj),
    				'NIPP_SPI' 		=> trim($nipp_pj),
    				'TANGGAL' 		=> is_empty_return_null($this->input->post('TANGGAL')),
    				'TAHUN_AUDIT' 	=> is_empty_return_null($this->input->post('TAHUN_AUDIT'))
    			);
    	if($id!='')
    	{
    		$data['updated_by'] = $this->session->ID_USER;
    		$this->db->set('"updated_at"', 'CURRENT_TIMESTAMP', FALSE);
    		$this->db->update('BERITA_ACARA', $data, array('ID' => $id));
    	}
    	else
    	{
    		$data['created_by'] 	= $this->session->ID_USER;
    		$data['NAMA_PIC'] 		= $pic->NAMA;
    		$data['JABATAN_PIC'] 	= $pic->NAMA_JABATAN;
    		$this->db->insert('BERITA_ACARA', $data);
    	}
    	if($this->db->trans_status() === FALSE){
		   $this->db->trans_rollback();
		}else{
		   $this->db->trans_complete();
		   echo "OK";
		}
    }

    public function hapus()
    {
    	$id 	= base64_decode($this->input->post('id'));
    	$this->db->trans_start();
    	$data 	= array(
    				'is_deleted' 	=> 1,
    				'deleted_by' 	=> $this->session->ID_USER
    			);
    	$this->db->set('"deleted_at"', 'CURRENT_TIMESTAMP', FALSE);
    	$this->db->update('BERITA_ACARA', $data, array('ID' => $id));
    	if($this->db->trans_status() === FALSE){
		   $this->db->trans_rollback();
		}else{
		   $this->db->trans_complete();
		   echo "OK";
		}
    }

    public function ba_json()
    {
        header('Content-Type: application/json');
        if($this->is_auditor()){

        	$get_ba = $this->db->select('ba.ID, ba.NOMOR, ba.AUDITEE, ba.PIC, ba.TAHUN_AUDIT, ba.TANGGAL, d.NAMA_DIVISI,ba.FILE_TTD, j.NAMA_JABATAN')
        			->from('BERITA_ACARA ba')
        			->join('TM_DIVISI d', 'd.ID_DIVISI = ba.AUDITEE', 'LEFT')
        			->join('TM_JABATAN j', 'j.ID_JABATAN = ba.PIC', 'LEFT')
        			->where('ba.is_deleted', 0)
        			->get()->result_array();
        }else{
        	$get_ba = $this->db->select('ba.ID, ba.NOMOR, ba.AUDITEE, ba.PIC, ba.TAHUN_AUDIT, ba.TANGGAL, d.NAMA_DIVISI,ba.FILE_TTD, j.NAMA_JABATAN')
        			->from('BERITA_ACARA ba')
        			->join('TM_DIVISI d', 'd.ID_DIVISI = ba.AUDITEE', 'LEFT')
        			->join('TM_JABATAN j', 'j.ID_JABATAN = ba.PIC', 'LEFT')
        			->where('ba.is_deleted', 0)
        			->where('ba.AUDITEE', $this->session->ID_DIVISI)
        			->get()->result_array();
        }
        if($this->input->server('REQUEST_METHOD') === 'POST') 
        	echo json_encode($get_ba);
    }

	public function cetak()
	{
		$id 					= base64_decode($this->input->get('id'));
		$get_ba 				= $this->db->get_where('BERITA_ACARA', array('ID' => $id))->row();
		$tahun 					= $get_ba->TAHUN_AUDIT;
		$id_divisi 				= $get_ba->AUDITEE;
		$pic 					= $this->master_act->user(array('U.ID_JABATAN' => $get_ba->PIC));
		// print_r($pic);die();

		$temuan 				= $this->m_status_tl->temuan($tahun, $id_divisi, '', '', '');
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

		if($get_ba)
		{
			$data['data_ba'] 				= $get_ba;
			$data['pic'] 					= $pic[0];
			$data['rekomendasi'] 			= $laporan;
			$data['total_rekom'] 			= $total_rekom;
			$data['temuan'] 				= $temuan;
			$data['divisi']					= $this->master_act->divisi($id_divisi);
			$data['jenis_audit'] 			= $jenis_audit;
			$data['tahun'] 					= $tahun;
			$data['tk_penyelesaian'] 		= $tk_penyelesaian;
			$data['tk_penyelesaian_rekom'] 	= $tk_penyelesaian_rekom;
			$data['sm_spi'] 				= $this->master_act->user(array('U.NIPP' => $get_ba->NIPP_SPI));
		}
		// print_r($data['sm_spi']);die();
		if($id_divisi==19)
			$this->load->view('/content/cetak/berita_acara_pusat', $data);
		else
			$this->load->view('/content/cetak/berita_acara', $data);
	}

	function upload_lampiran()
    {
        $id_ba = $this->input->post('id_ba');
        $config['upload_path']      = './storage/berita_acara/';
        $config['allowed_types']    = 'gif|jpg|png|jpeg|bmp|pdf|docx|doc|xlsx|xls';
        $this->load->library('upload', $config);
        $ext = pathinfo($_FILES['LAMPIRAN']['name'], PATHINFO_EXTENSION);
        $file = basename($_FILES['LAMPIRAN']['name'], "." . $ext);
        $nama_file = str_replace(".", "_", $file);
        $nama_file = $id_ba . '_' . str_replace(" ", "_", $nama_file) . '_' . date('YmdHis') . '.' . $ext;
        // print_r($nama_file);die();
        // $data = array(
        //     'NOMOR_LHA'     => $this->input->post('NOMOR_LHA'),
        //     'TANGGAL_LHA'   => is_empty_return_null($this->input->post('TANGGAL_LHA'))
        // );
        if (!empty($_FILES['LAMPIRAN']['name'])) {
            $config['file_name'] = $nama_file;
            $this->upload->initialize($config);
            if ($this->upload->do_upload('LAMPIRAN')) {
                $this->upload->data();
                $data['FILE_TTD'] = $nama_file;
            } else {
                $error_message = $this->upload->display_errors();
                $this->session->set_flashdata('error', $error_message);
                die();
            }
        } 
        $this->db->update('BERITA_ACARA', $data, ['ID' => $id_ba],);
        $success_message = 'Berhasil.';
        $this->session->set_flashdata('success', $success_message);
        // else {
        //     $error_message = "File yang diupload kosong.";
        //     $this->session->set_flashdata('error', $error_message);
        // }
        redirect(base_url('monitoring/berita_acara'), 'refresh');
    }
}
