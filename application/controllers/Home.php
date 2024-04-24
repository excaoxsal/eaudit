<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

	var $menu = '';

	public function __construct()
	{
		parent::__construct();
		$this->is_login();
	}

	public function index()
	{
		$this->menu 		= 'home';
		$data['menu'] 		= $this->menu;
		$data['content'] 	= 'content/v_home';
		$this->show($data);
	}

	public function err_404()
	{
		$this->load->view('/errors/html/err_404');
	}

	public function logout()
	{
		session_destroy();
        redirect(base_url(), 'refresh');
	}

	public function test_send_email()
	{
		$this->mail_config();

		$from = 'smtpbelajar@gmail.com';
		$to = $this->input->post('email');
		$isi = 'Email Masuk fahmiganz';
		$this->email->from($from, 'fahmiganz');
		$this->email->to($to);
		$this->email->subject(APK_NAME);
		$this->email->message($isi);

		if($this->email->send())
		{
			$log_email = ["TO"=> $to, "FROM"=> $from, "ISI"=>$isi];
			$this->db->insert('LOG_EMAIL', $log_email);
			echo "<script>location.href='".base_url('home')."'</script>";
		}else{
			echo $this->email->print_debugger();
			die();
		}
	}

}
