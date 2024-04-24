<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Peminjaman extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Pdf');
		$this->load->model('perencanaan/M_peminjaman', 'm_peminjaman');
		$this->is_login();
		if(!$this->is_auditor()) $this->load->view('/errors/html/err_401');
	}

	public function index()
	{
		$data['list_status'] 	= $this->master_act->status();
		$data['menu']           = 'perencanaan';
		$data['sub_menu']    	= 'peminjaman';
		$data['title']          = 'Peminjaman Dokumen Audit';
        $data['content']        = 'content/perencanaan/peminjaman/v_peminjaman';
        $this->show($data);
	}

	function upload_lampiran($id_peminjaman){
        $config['upload_path']      = './storage/peminjaman/';
        $config['allowed_types']    = 'gif|jpg|png|jpeg|bmp|pdf|docx|doc|xlsx|xls'; 
        $this->load->library('upload', $config);
        $ext = pathinfo($_FILES['LAMPIRAN']['name'], PATHINFO_EXTENSION);
        $file = basename($_FILES['LAMPIRAN']['name'],".".$ext);
        $nama_file = str_replace(".", "_", $file);
        $nama_file = $id_peminjaman.'_'.str_replace(" ", "_", $nama_file).'_'.date('YmdHis').'.'.$ext;

        if(!empty($_FILES['LAMPIRAN']['name'])){
        	$config['file_name'] = $nama_file;
            $this->upload->initialize($config);
            if ($this->upload->do_upload('LAMPIRAN')){
                $this->upload->data();
                $data = array(
                    'FILE_TTD' => $nama_file
                );
                $this->m_peminjaman->update($data, ['ID_PEMINJAMAN' => $id_peminjaman]);
                $success_message = 'File berhasil diupload.';
                $this->session->set_flashdata('success', $success_message);
            }else{
                $error_message = $this->upload->display_errors();
                $this->session->set_flashdata('error', $error_message);
            }
                      
        }else{
            $error_message = "File yang diupload kosong.";
            $this->session->set_flashdata('error', $error_message);
        }
        redirect(base_url('perencanaan/peminjaman/'), 'refresh');
                 
    }

	public function peminjaman_json() 
	{
        header('Content-Type: application/json');
        echo json_encode($this->m_peminjaman->get_peminjaman());
	}

	public function create($id_peminjaman = null)
	{
		if (!empty($id_peminjaman) || $id_peminjaman != null) {
			$data_peminjaman	= $this->m_peminjaman->get_peminjaman($id_peminjaman);
			$data['data_peminjaman']	= $data_peminjaman;
			$lampiran	= $this->m_peminjaman->get_lampiran($id_peminjaman);
			// print_r($lampiran);die();
			$data['lampiran'] 		= $lampiran;	
		}
		$list_divisi			= $this->master_act->divisi();
		$list_user				= $this->master_act->user(['U.STATUS'=>1]);
		$data['list_divisi'] 	= $list_divisi;
		$data['list_user'] 		= $list_user;
		$data['menu']           = 'perencanaan';
		$data['sub_menu']      	= 'peminjaman';
		$data['title']      	= 'Peminjaman';
		$data['content']        = 'content/perencanaan/peminjaman/v_create_peminjaman';
        $this->show($data);
	}

	public function generate($id_peminjaman = null)
	{
		$data = [
			'HEADER_TEXT' 	=> $this->input->post('HEADER_TEXT'),
			'KEPADA' 		=> $this->input->post('KEPADA'),
			'KETUA_TIM' 	=> $this->input->post('KETUA_TIM'),
			'DIKELUARKAN' 	=> $this->input->post('DIKELUARKAN'),
			'TANGGAL' 		=> $this->input->post('TANGGAL'),
		];
		$lampiran = $this->input->post('LAMPIRAN');
		$save = (!empty($id_peminjaman) || $id_peminjaman != null) ? $this->m_peminjaman->send_update($data, $lampiran, $id_peminjaman) : $this->m_peminjaman->save($data, $lampiran);
		echo $save;
	}

	public function cetak_preview($id)
	{
		$data_peminjaman['title'] = 'Peminjaman';
		$peminjaman = $this->m_peminjaman->get_peminjaman($id);
		$data_peminjaman['tempat'] = $peminjaman->DIKELUARKAN;
		$data_peminjaman['tanggal'] = tgl_indo($peminjaman->TANGGAL);
		$data_peminjaman['kepada'] = $peminjaman->NAMA_DIVISI;
		$data_peminjaman['alamat'] = $peminjaman->HEADER_TEXT;
		$data_peminjaman['ketua_tim'] = $peminjaman->NAMA;
		$data_peminjaman['ttd_ketua'] = $peminjaman->TANDA_TANGAN;
		$data_peminjaman['lampiran'] = $this->m_peminjaman->get_lampiran($id);
		$this->load->view('/content/cetak/peminjaman_preview', $data_peminjaman);
	}

}
