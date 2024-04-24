<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jenis_audit extends MY_Controller
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
        $data['sub_menu']       = 'jenis_audit';
        $data['title']          = 'Master Jenis Audit';
        $data['content']        = 'content/master/v_master_jenis_audit';
        $this->show($data);
    }

    function jenis_audit_json()
    {
        $id = $this->input->get('id');
        $id = base64_decode($id);
        if($this->is_auditor() && $this->input->server('REQUEST_METHOD') === 'POST') echo json_encode($this->master_act->jenis_audit($id));
    }

    public function post()
    {
        $id = $this->input->post('ID');
        $id = base64_decode($id);
        
        $data = array(
            'JENIS_AUDIT'  => trim(htmlspecialchars($this->input->post('jenis_audit', TRUE)))
        );

        if (!$id) {
            $data['CREATED_BY'] = $this->session->ID_USER;
            $query  = $this->db->insert('TM_JENIS_AUDIT', $data);
            $msg    = 'Data telah ditambahkan.';
        } else {
            $this->db->where('ID_JENIS_AUDIT', $id);
            $query  = $this->db->update('TM_JENIS_AUDIT', $data);
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
            $query  = $this->db->set('STATUS', 2)->where('ID_JENIS_AUDIT', $id)->update('TM_JENIS_AUDIT');
            $msg    = 'Data telah dihapus.';
        }

        if($query) $response['status'] = 'OK';
        $response['msg'] = $msg;
        echo json_encode($response);
    }

}
