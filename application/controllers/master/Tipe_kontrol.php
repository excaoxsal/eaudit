<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tipe_kontrol extends MY_Controller
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
        $data['sub_menu']       = 'tipe_kontrol';
        $data['title']          = 'Master Tipe Kontrol';
        $data['content']        = 'content/master/v_master_tipe_kontrol';
        $this->show($data);
    }

    function tipe_kontrol_json()
    {
        $id = $this->input->get('id');
        $id = base64_decode($id);
        if($this->is_auditor() && $this->input->server('REQUEST_METHOD') === 'POST') echo json_encode($this->master_act->tipe_kontrol($id));
    }

    public function post()
    {
        $id = $this->input->post('ID');
        $id = base64_decode($id);
        
        $data = array(
            'TIPE_KONTROL'  => trim(htmlspecialchars($this->input->post('tipe_kontrol', TRUE)))
        );

        if (!$id) {
            $data['CREATED_BY'] = $this->session->ID_USER;
            $query  = $this->db->insert('TM_TIPE_KONTROL', $data);
            $msg    = 'Data telah ditambahkan.';
        } else {
            $this->db->where('ID_TIPE_KONTROL', $id);
            $query  = $this->db->update('TM_TIPE_KONTROL', $data);
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
            $query  = $this->db->set('STATUS', 2)->where('ID_TIPE_KONTROL', $id)->update('TM_TIPE_KONTROL');
            $msg    = 'Data telah dihapus.';
        }

        if($query) $response['status'] = 'OK';
        $response['msg'] = $msg;
        echo json_encode($response);
    }

}
