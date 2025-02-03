<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

	var $menu = '';

    public function index()
	{
		$this->menu 		= 'home';
		$data['menu'] 		= $this->menu;
		$data['content'] 	= 'content/v_home';
		$this->show($data);
	}
}