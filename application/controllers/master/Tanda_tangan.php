<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tanda_tangan extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
        $this->load->library('upload');
		$this->is_login();
        $this->is_auditor();
        if(!$this->is_auditor()) $this->load->view('/errors/html/err_401');
	}

	public function index()
	{
		$data['list_user']	  = $this->master_act->user();
		$data['list_jabatan'] = $this->master_act->jabatan();
		$data['list_role']    = $this->master_act->role();
		$data['menu']         = 'master';
        $data['sub_menu']     = 'tanda_tangan';
		$data['title']        = 'Master Tanda Tangan';
        $data['content']      = 'content/master/v_master_tanda_tangan';
        $this->show($data);
	}

    function user_json() 
    {
        header('Content-Type: application/json');
        if($this->is_auditor() && $this->input->server('REQUEST_METHOD') === 'POST') echo json_encode($this->master_act->user());
    }

    public function edit()
    {
        $id_user                = $this->input->get('id');
        $id_user                = base64_decode($id_user);
        $data['user_detail']    = $this->master_act->user(array('U.ID_USER' => $id_user));
        $data['menu']           = 'master';
        $data['sub_menu']       = 'tanda_tangan';
        $data['title']          = 'Setting Tanda Tangan';
        $data['content']        = 'content/master/v_edit_tanda_tangan';
        $this->show($data);
    }

    function upload($id_user){
        $nipp                       = $this->input->post('nipp');
        $new_name                   = date('Ymdhis').$nipp.'.jpg';
        $config['upload_path']      = './storage/upload/tanda_tangan/';
        $config['allowed_types']    = 'gif|jpg|png|jpeg|bmp'; 
        $config['file_name']        = $new_name;
        $this->upload->initialize($config);

        if(!empty($_FILES['file_tanda_tangan']['name'])){
            if ($this->upload->do_upload('file_tanda_tangan')){
                $gbr = $this->upload->data();
                $config['image_library']    = 'gd2';
                $config['source_image']     = './storage/upload/tanda_tangan/'.$gbr['file_name'];
                $config['create_thumb']     = FALSE;
                $config['maintain_ratio']   = FALSE;
                // $config['width']            = 300;
                // $config['height']           = 300;
                $config['new_image']        = './storage/upload/tanda_tangan/'.$gbr['file_name'];
                $this->load->library('image_lib', $config);
                $this->image_lib->resize();
 
                $gambar                     = $gbr['file_name'];
                $data = array(
                    'TANDA_TANGAN' => $new_name
                );
                $this->db->update('TM_USER', $data, array('ID_USER' => $id_user));
                $success_message = 'Berhasil upload Tanda Tangan.';
                $this->session->set_flashdata('success', $success_message);
            }else{
                $error_message = $this->upload->display_errors();
                $this->session->set_flashdata('error', $error_message);
            }
                      
        }else{
            $error_message = "Gambar yang diupload kosong.";
            $this->session->set_flashdata('error', $error_message);
        }
        redirect(base_url('master/tanda_tangan/edit?id='.base64_encode($id_user)), 'refresh');
                 
    }

}
