<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Frekuensi_kontrol extends MY_Controller
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
        $data['sub_menu']       = 'frekuensi_kontrol';
        $data['title']          = 'Master Frekuensi Kontrol';
        $data['content']        = 'content/master/v_master_frekuensi_kontrol';
        $this->show($data);
    }

    function frekuensi_kontrol_json()
    {
        $id = $this->input->get('id');
        $id = base64_decode($id);
        if($this->is_auditor() && $this->input->server('REQUEST_METHOD') === 'POST') echo json_encode($this->master_act->frekuensi_kontrol($id));
    }

    public function post()
    {
        $id = $this->input->post('ID');
        $id = base64_decode($id);
        
        $data = array(
            'FREKUENSI_KONTROL'  => trim(htmlspecialchars($this->input->post('frekuensi_kontrol', TRUE)))
        );

        if (!$id) {
            $data['CREATED_BY'] = $this->session->ID_USER;
            $query  = $this->db->insert('TM_FREKUENSI_KONTROL', $data);
            $msg    = 'Data telah ditambahkan.';
        } else {
            $this->db->where('ID_FREKUENSI_KONTROL', $id);
            $query  = $this->db->update('TM_FREKUENSI_KONTROL', $data);
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
            $query  = $this->db->set('STATUS', 2)->where('ID_FREKUENSI_KONTROL', $id)->update('TM_FREKUENSI_KONTROL');
            $msg    = 'Data telah dihapus.';
        }

        if($query) $response['status'] = 'OK';
        $response['msg'] = $msg;
        echo json_encode($response);
    }

}
