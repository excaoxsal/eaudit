<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->is_login();
        $this->is_auditor();
        $this->load->model('aia/master/Master_act_aia','aia_master_act');
        if(!$this->is_auditor()) $this->load->view('/errors/html/err_401');
    }

    public function index()
    {
        $data['list_user']      = $this->aia_master_act->user(['U.STATUS'=>1]);
        $data['list_jabatan']   = $this->aia_master_act->jabatan();
        $data['list_divisi']    = $this->aia_master_act->divisi();
        $data['list_role']      = $this->aia_master_act->role();
        $data['list_menu']      = $this->aia_master_act->menu();
        $data['menu']           = 'master';
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
        
        $data = array(
            'NAMA'              => trim(htmlspecialchars($this->input->post('nama', TRUE))),
            'ID_JABATAN'        => $this->input->post('id_jabatan'),
            'EMAIL'             => trim(htmlspecialchars($this->input->post('email', TRUE))),
            'ID_ROLE'           => $this->input->post('id_role'),
            'ID_MENU'           => $this->input->post('id_menu'),
            'ATASAN_I'          => $this->input->post('atasan_i'),
            'ATASAN_II'         => $this->input->post('atasan_ii')
        );

        if (!$id) {
            $data['NIPP']       = $nipp; 
            $data['PASSWORD']   = password_hash('123456', PASSWORD_DEFAULT); //default password 123456
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
