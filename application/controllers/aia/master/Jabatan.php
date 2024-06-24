<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jabatan extends MY_Controller
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
        $data['menu']           = 'master-aia';
        $data['sub_menu']       = 'jabatan';
        $data['title']          = 'Master Jabatan';
        $data['list_divisi']    = $this->aia_master_act->only_divisi();
        $data['list_atasan']    = $this->aia_master_act->jabatan();
        $data['is_aia']         = $this->aia_master_act->is_aia(); 
        //print_r($data['is_aia']);die();
        $data['content']        = 'content/aia/master/v_master_jabatan';
        $this->show($data);
    }

    function jabatan_json()
    {
        $id = $this->input->get('id');
        $id = base64_decode($id);
        if($this->is_auditor() && $this->input->server('REQUEST_METHOD') === 'POST') echo json_encode($this->aia_master_act->jabatan($id));
    }

    public function post()
    {
        $id = $this->input->post('ID');
        $id = base64_decode($id);
        $id_atasan = $this->input->post('id_atasan');
        $id_atasan = $id_atasan === '' ? NULL : $id_atasan;
        
        $data = array(
            'NAMA_JABATAN'  => trim(htmlspecialchars($this->input->post('jabatan', TRUE))),
            'ID_ATASAN'     => $id_atasan,
            'ID_DIVISI'     => $this->input->post('id_divisi'),
            'IS_AIA'        => $this->input->post('is_aia')
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
