<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends MY_Controller {

	public function __construct() {
		
		parent::__construct();
		$this->load->model('Karyawans_model');
		$this->load->model('Umb_model');
	}
	
	public function index() {		
		$data['title'] = $this->Umb_model->site_title().' | Log in';
		$system = $this->Umb_model->read_setting_info(1);
		$theme = $this->Umb_model->read_theme_info(1);
		if($system[0]->login_karyawan_id != 'pincode') {
			if($theme[0]->login_page_options == 'login_page_1'):
				$this->load->view('admin/auth/login-1', $data);
			elseif($theme[0]->login_page_options == 'login_page_2'):
				$this->load->view('admin/auth/login-2', $data);
			elseif($theme[0]->login_page_options == 'login_page_3'):
				$this->load->view('admin/auth/login-3', $data);
			elseif($theme[0]->login_page_options == 'login_page_4'):
				$this->load->view('admin/auth/login-4', $data);
			elseif($theme[0]->login_page_options == 'login_page_5'):
				$this->load->view('admin/auth/login-5', $data);				
			else:
				$this->load->view('admin/auth/login-1', $data);	
			endif;
		} else {
			$this->load->view('admin/auth/login_pincode', $data);
		}
	}
}