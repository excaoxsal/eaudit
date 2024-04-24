<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Resiko_desc extends MY_Controller
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
        $data['sub_menu']       = 'resiko_desc';
        $data['tingkat_resiko'] = $this->master_act->tingkat_resiko();
        $data['klasifikasi']    = $this->master_act->klasifikasi();
        $data['divisi']         = $this->master_act->divisi();
        $data['title']          = 'Master Resiko';
        $data['content']        = 'content/master/v_master_resiko_desc';
        $this->show($data);
    }

    function resiko_desc_json()
    {
        $id = $this->input->get('id');
        $id = base64_decode($id);
        if($this->is_auditor() && $this->input->server('REQUEST_METHOD') === 'POST') echo json_encode($this->master_act->resiko_desc($id));
    }

    function post()
    {

        $this->db->set('DIVISI_ID', $this->input->post('DIVISI'));
        $this->db->set('KLASIFIKASI_ID', $this->input->post('KLASIFIKASI'));
        $this->db->set('DESC', $this->input->post('DESKRIPSI'));
        $this->db->set('TINGKAT_RESIKO_ID', $this->input->post('TINGKAT_RESIKO'));
        $this->db->set('KONTROL_STANDAR', $this->input->post('KONTROL_STANDAR'));
        $this->db->set('RENCANA_KERJA', $this->input->post('RENCANA_KERJA'));
        $this->db->set('STATUS', 1);

        $id = $this->input->post('ID');
        $id = base64_decode($id);

        if (!$id) {
            $this->db->set('CREATED_AT', date('Y-m-d'));
            $this->db->set('CREATED_BY', $this->session->ID_USER);
            $query  = $this->db->insert('TM_RESIKO_DESC');
            $msg    = 'Data telah ditambahkan.';
        } else {
            $this->db->where('ID', $id);
            $query = $this->db->update('TM_RESIKO_DESC');
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
            $query  = $this->db->set('STATUS', 2)->where('ID', $id)->update('TM_RESIKO_DESC');
            $msg    = 'Data telah dihapus.';
        }

        if($query) $response['status'] = 'OK';
        $response['msg'] = $msg;
        echo json_encode($response);
    }
}
