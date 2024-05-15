<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Divisi extends MY_Controller
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
        $data['menu']           = 'master';
        $data['sub_menu']       = 'divisi';
        $data['title']          = 'Master Divisi';
        $data['content']        = 'content/aia/master/v_master_divisi';
        $this->show($data);
    }

    function divisi_json()
    {
        $id = $this->input->get('id');
        $id = base64_decode($id);
        if($this->is_auditor() && $this->input->server('REQUEST_METHOD') === 'POST') echo json_encode($this->aia_master_act->divisi($id));
    }

    public function post()
    {
        $id = $this->input->post('ID');
        $id = base64_decode($id);
        $is_divisi = $this->input->post('is_divisi');
        $is_cabang = $this->input->post('is_cabang');
        //var_dump($is_divisi);die();
        if($is_divisi == 'on') 
            $is_divisi = 'Y';
        else 
            $is_divisi = 'N';

        if($is_cabang == 'on') 
            $is_cabang = 'Y';
        else 
            $is_cabang = 'N';
        
        $data = array(
            'NAMA_DIVISI'  => trim(htmlspecialchars($this->input->post('divisi', TRUE))),
            'NAMA_SUB_DIVISI'  => trim(htmlspecialchars($this->input->post('sub_divisi', TRUE))),
            'KODE_SUB_DIVISI'  => trim(htmlspecialchars($this->input->post('kode_sub_divisi', TRUE))),
            'IS_DIVISI'    => $is_divisi,
            'IS_CABANG'    => $is_cabang
        );

        if (!$id) {
            $data['CREATED_BY'] = $this->session->ID_USER;
            $query  = $this->db->insert('TM_DIVISI', $data);
            $msg    = 'Data telah ditambahkan.';
        } else {
            $this->db->where('ID_DIVISI', $id);
            $query  = $this->db->update('TM_DIVISI', $data);
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
            $query  = $this->db->set('STATUS', 2)->where('ID_DIVISI', $id)->update('TM_DIVISI');
            $msg    = 'Data telah dihapus.';
        }

        if($query) $response['status'] = 'OK';
        $response['msg'] = $msg;
        echo json_encode($response);
    }

}
