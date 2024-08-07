<?php defined('BASEPATH') or exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    protected $data         = array();
    protected $main_layout  = "template/main";
    protected $auth_layout  = "template/auth";

    function __construct()
    {
        parent::__construct();
        $this->load->model('main_act');
    }

    protected function show($data = array())
    {
        $result               = $this->main_act->total_notif($this->session->userdata('ID_USER'));
        $data['notif_atasanAuditee']    = $this->main_act->notif_atasanAuditee($this->session->userdata('ID_USER'));
        $data['notif_apm']    = $this->main_act->notif_apm($this->session->userdata('ID_USER'));
        $data['notif_rcm']    = $this->main_act->notif_rcm($this->session->userdata('ID_USER'));
        $data['notif_pka']    = $this->main_act->notif_pka($this->session->userdata('ID_USER'));
        $data['total_atasanAuditee']    = count($data['notif_atasanAuditee']);
        $data['total_apm']    = count($data['notif_apm']);
        $data['total_rcm']    = count($data['notif_rcm']);
        $data['total_pka']    = count($data['notif_pka']);
        if($this->is_closing_audit())
        {
            $data['notif_lainnya']= $this->main_act->notif_lainnya();
        }else{
            $data['notif_lainnya']= $this->main_act->notif_rekom();
        }
        $data['tnotif_lain']        = count($data['notif_lainnya']);
        $data['total_notif']        = count($result)+(int)$data['tnotif_lain'];
        $data['is_auditor']         = $this->is_auditor();
        $data['is_auditee']         = $this->is_auditee();
        $data['is_atasan_auditee']  = $this->is_atasan_auditee();
        $data['is_lead_auditor']    = $this->is_lead_auditor();
        $data['is_user']            = $this->is_user();
        $data['is_aia']             = $this->is_aia();
        $data['is_closing_audit']   = $this->is_closing_audit();
        $this->data = $data;


        return $this->load->view($this->main_layout, $this->data);
    }

    protected function is_login()
    {
        if($this->session->login!=true) redirect(base_url());
    }

    protected function is_auditor()
    {
        if(($this->session->ID_ROLE==1)  && $this->session->STATUS==1 && $this->session->ID_USER!=NULL && $this->session->NIPP!=NULL) return TRUE;
        else return FALSE;
    }

    protected function is_auditee()
    {
        if(($this->session->ID_ROLE==2) && $this->session->STATUS==1 && $this->session->ID_USER!=NULL && $this->session->NIPP!=NULL) return TRUE;
        else return FALSE;
    }

    protected function is_atasan_auditee()
    {
        $query = $this->db->select('ID_ATASAN')
                      ->from('TM_JABATAN')
                      ->where('ID_JABATAN', $this->session->ID_JABATAN)
                      ->where('ID_DIVISI', $this->session->ID_DIVISI)
                      ->get()
                      ->row();
        //print_r($query);die();
        if ($query->ID_ATASAN === null) {
            return true;
        } else {
            return false;
        }
    }

    protected function is_lead_auditor()
    {
        if(($this->session->ID_JABATAN==2035) && $this->session->STATUS==1 && $this->session->ID_USER!=NULL && $this->session->NIPP!=NULL) return TRUE;
        else return FALSE;
    }


    protected function is_aia(){
        if(($this->session->MENU==2||$this->session->MENU==3) && $this->session->STATUS==1 && $this->session->ID_USER!=NULL && $this->session->NIPP!=NULL) return TRUE;
        else return FALSE;
    }

    protected function is_user()
    {
        if($this->session->ID_ROLE==3 && $this->session->STATUS==1 && $this->session->ID_USER!=NULL && $this->session->NIPP!=NULL) return TRUE;
        else return FALSE;
    }

    protected function is_closing_audit()
    {
        // asm spi & senior officer spi
        if(($this->session->ID_JABATAN==54519 || $this->session->ID_JABATAN==54573 || $this->session->ID_JABATAN==10001087) && $this->session->STATUS==1 && $this->session->ID_USER!=NULL && $this->session->NIPP!=NULL) return TRUE;
        else return FALSE;
    }
    
    protected function mail_config()
    {
        $config = array(
                    'protocol'  => 'smtp',
                    'smtp_host' => 'ssl://smtp.googlemail.com',
                    'smtp_user' => 'smtpbelajar@gmail.com',
                    'smtp_pass' => 'fahmiganz123',
                    'smtp_port' => 465,
                    'mailtype'  => 'html',
                    'charset'   => 'utf-8',
                    'newline'   => "\r\n",
                );
        $this->load->library('email', $config);
        $this->email->initialize($config);
    }

}
