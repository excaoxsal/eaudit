<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jabatan extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->is_login();
        $this->is_auditor();
        if(!$this->is_auditor()) $this->load->view('/errors/html/err_401');
    }

    public function index()
    {
        $data['menu']           = 'master';
        $data['sub_menu']       = 'jabatan';
        $data['title']          = 'Master Jabatan';
        $data['list_divisi']    = $this->master_act->divisi();
        $data['content']        = 'content/master/v_master_jabatan';
        $this->show($data);
    }

    function jabatan_json()
    {
        $id = $this->input->get('id');
        $id = base64_decode($id);
        if($this->is_auditor() && $this->input->server('REQUEST_METHOD') === 'POST') echo json_encode($this->master_act->jabatan($id));
    }

    public function post()
    {
        $id = $this->input->post('ID');
        $id = base64_decode($id);
        
        $data = array(
            'NAMA_JABATAN'  => trim(htmlspecialchars($this->input->post('jabatan', TRUE))),
            'ID_DIVISI'     => $this->input->post('id_divisi')
        );

        if (!$id) {
            $data['CREATED_BY'] = $this->session->ID_USER;
            $query  = $this->db->insert('TM_JABATAN', $data);
            $msg    = 'Data telah ditambahkan.';
        } else {
            $this->db->where('ID_JABATAN', $id);
            $query  = $this->db->update('TM_JABATAN', $data);
            $msg    = 'Data telah diubah.';
        }
        if($query) $response['status'] = 'OK';
        $response['msg'] = $msg;
        echo json_encode($response);
    }

    public function hapus()
    {
        $id = $this->input->get('id');
        $id = base64_decode($id);
        if ($id) {
            $query  = $this->db->set('STATUS', 2)->where('ID_JABATAN', $id)->update('TM_JABATAN');
            $msg    = 'Data telah dihapus.';
        }

        if($query) $response['status'] = 'OK';
        $response['msg'] = $msg;
        echo json_encode($response);
    }

}
