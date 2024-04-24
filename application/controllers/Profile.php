<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->is_login();
	}

	public function index()
	{
        $data['user_detail']    = $this->master_act->user(['U.ID_USER'=>$this->session->ID_USER]);
        $data['content']        = 'content/v_profile';
        $this->show($data);
	}

	public function ubah_password()
    {
        $password_lama  	= $this->input->post('password_lama');
        $password_baru  	= $this->input->post('password_baru');
        $konfirm_password	= $this->input->post('konfirm_password');
        $detail         	= $this->master_act->user(['U.ID_USER'=>$this->session->ID_USER]);

        if(password_verify($password_lama, $detail[0]['PASSWORD'])){
            // if ($password_baru == $konfirm_password) {
                $data = array(
                    'UPDATE_PSW'      => 1,
                    'PASSWORD'        => password_hash($password_baru, PASSWORD_DEFAULT)
                );
                $query = $this->db->update('TM_USER', $data, ['ID_USER'=>$this->session->ID_USER]);
                if($query) {
                    echo "OK";
                    // $success_message    = 'Password berhasil diubah.';
                    // $aktifitas          = $success_message;
                    // $this->session->set_flashdata('success', $success_message);
                }else{
                    echo "db_error";
                }
            // } else {
            //     $error_message = 'Password tidak sesuai.';
            //     $aktifitas = $error_message;
            //     $this->session->set_flashdata('error', $error_message);
            // }
        }else{
            echo "wrong_password";
            // $error_message = 'Password lama salah.';
            // $aktifitas = $error_message;
            // $this->session->set_flashdata('error', $error_message);
        }
    }

}
