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
        $data['menu']           = 'master-aia';
        $data['sub_menu']       = 'divisi';
        $data['title']          = 'Master Divisi';
        $data['list_divisi']      = $this->aia_master_act->only_divisi();
        $data['is_divisi']      = $this->aia_master_act->is_divisi();
        // var_dump($data);die();
        $data['content']        = 'content/aia/master/v_master_divisi';
        $this->show($data);
    }

    function divisi_json()
    {
        $id = $this->input->get('id');
        $id = base64_decode($id);
        if($this->is_auditor() && $this->input->server('REQUEST_METHOD') === 'POST')
        {
            // var_dump($this->aia_master_act->divisi($id));die;
            echo json_encode($this->aia_master_act->divisi($id));

        }
    }

    public function post()
    {
        $id = $this->input->post('ID');
        $id = base64_decode($id);
        $is_divisi = $this->input->post('is_divisi');
        $is_cabang = $this->input->post('is_cabang');
        // print_r($is_cabang);die;
        if(!isset($_POST['is_cabang'])){
            $is_cabang = 'N';
        }
        else {
            $is_cabang = 'Y';
        }
        if($is_divisi == 'Y'){
            $data = array(
                'NAMA_DIVISI'  => trim(htmlspecialchars($this->input->post('divisi1', TRUE))),
                'KODE'         => trim(htmlspecialchars($this->input->post('kode_divisi', TRUE))),
                'IS_DIVISI'    => $is_divisi,
                'IS_CABANG'    => $is_cabang 
            );
        }else{
            $data = array(
                'NAMA_DIVISI'  => trim(htmlspecialchars($this->input->post('sub_divisi', TRUE))),
                'KODE_PARENT'  => trim(htmlspecialchars($this->input->post('id_divisi', TRUE))),
                'KODE'         => trim(htmlspecialchars($this->input->post('kode_sub_divisi', TRUE))),
                'IS_DIVISI'    => $is_divisi,
                'IS_CABANG'    => $is_cabang 
            );
        }
        //print_r($data);die();
        // var_dump($data);die();
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
