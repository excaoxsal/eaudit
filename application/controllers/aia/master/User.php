<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('upload');
        $this->is_login();
        $this->is_auditor();
        $this->load->model('aia/master/Master_act_aia','aia_master_act');
        if(!$this->is_auditor()) $this->load->view('/errors/html/err_401');
    }

    public function index()
    {
        $data['list_user']      = $this->aia_master_act->user(['U.STATUS'=>1]);
        $data['list_jabatan']   = $this->aia_master_act->jabatan();
        $data['list_divisi']    = $this->aia_master_act->only_divisi();
        $data['list_role']      = $this->aia_master_act->role();
        $data['list_menu']      = $this->aia_master_act->menu();
        $data['menu']           = 'master-aia';
        $data['sub_menu']       = 'user';
        $data['title']          = 'Master User';
        $data['content']        = 'content/aia/master/v_master_user';
        $this->show($data);
    }

    function user_json()
    {
        $id     = $this->input->get('id');
        $id     = base64_decode($id);
        $where  = $id != '' ? ['U.ID_USER'=>$id] : '' ;
        if($this->is_auditor() && $this->input->server('REQUEST_METHOD') === 'POST') echo json_encode($this->aia_master_act->user($where));
    }

    public function post()
    {
        $id     = $this->input->post('ID');
        $id     = base64_decode($id);
        $nipp   = $this->input->post('nipp');
        $atasan_i = $this->input->post('atasan_i');
        if (empty($atasan_i)) {
            $atasan_i = NULL;
        }

        // Use the user ID in the file name to ensure it remains consistent
        $file_name = 'Tanda_Tangan'.'-'.date('Ymd').'-'.$id;
        $config['file_name'] = $file_name;
        $config['upload_path'] = 'storage/aia/';
        $config['allowed_types'] = 'jpg|png';
        $config['max_size'] = 1024; // 1 MB in KB
        $ext = pathinfo($_FILES['tanda_tangan']['name'], PATHINFO_EXTENSION);

        $this->upload->initialize($config);
        
        $file_path = null;
        if (!$this->upload->do_upload('tanda_tangan')) {
            $error = array('error' => $this->upload->display_errors());
            // Handle the error if needed
        } else {
            // First, retrieve the old file path from the database
            if ($id) {
                $old_data = $this->db->get_where('TM_USER', ['ID_USER' => $id])->row();
                $old_file_path = str_replace(base_url(), '', $old_data->FILE);

                // Check if the old file exists and delete it
                if (file_exists($old_file_path)) {
                    unlink($old_file_path);
                }
            }

            // Upload the new file
            $file_data = $this->upload->data();     
            $file_path = base_url().$config['upload_path'].$file_name.'.'.$ext;

            // Move the uploaded file to the correct location with the consistent file name
            rename($file_data['full_path'], $config['upload_path'].$file_name.'.'.$ext);
        }

        $data = array(
            'NAMA'              => trim(htmlspecialchars($this->input->post('nama', TRUE))),
            'ID_JABATAN'        => $this->input->post('id_jabatan'),
            'EMAIL'             => trim(htmlspecialchars($this->input->post('email', TRUE))),
            'ID_ROLE'           => $this->input->post('id_role'),
            'ATASAN_I'          => $atasan_i,
            'FILE'              => is_empty_return_null($file_path)
        );

        if (!$id) {
            $data['NIPP']       = $nipp;
            $data['PASSWORD']   = password_hash('AIA@2024', PASSWORD_DEFAULT); //default password AIA2024 
            $data['CREATED_BY'] = $this->session->ID_USER;
            $cek_user           = $this->db->get_where('TM_USER', ['NIPP' => $nipp])->result();
            if($cek_user) $response['status'] = 'exists';
            $query  = $this->db->insert('TM_USER', $data);
            $msg    = 'Data telah ditambahkan.';
        } else {
            $this->db->where('ID_USER', $id);
            $query  = $this->db->update('TM_USER', $data);
            $msg    = 'Data telah diubah.';
        }
        if($query) $response['status'] = 'OK';
        $response['msg'] = $msg;
        echo json_encode($response);
    }

    public function action($act)
    {
        $id = $this->input->get('id');
        $id = base64_decode($id);
        if ($id) {
            if($act=='aktif') {
                $data['STATUS'] = 1;
                $msg            = 'User telah diaktifkan.';
            }
            elseif($act=='nonaktif') {
                $data['STATUS'] = 2;
                $msg            = 'User telah dinon-aktifkan.';
            }
            elseif($act=='reset_password') {
                $random_int         = random_int(100000, 999999);
                $data['RANDOM_INT'] = $random_int;
                $data['PASSWORD'] = password_hash('123456', PASSWORD_DEFAULT);
                $msg            = 'Password telah direset.';
            }

            $this->db->where('ID_USER', $id);
            $update  = $this->db->update('TM_USER', $data);
        }

        if($update) $response['status'] = 'OK';
        $response['msg'] = $msg;
        echo json_encode($response);
    }

}
