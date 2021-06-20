<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		
		$this->load->model("Post_pekerjaan_model");
		$this->load->model("Umb_model");
		$this->load->model("Penunjukan_model");
		$this->load->model("Department_model");
		$this->load->model("Recruitment_model");
		$this->load->model('Karyawans_model');
	}
	
	
	public function output($Return=array()){
		
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		
		exit(json_encode($Return));
	}
	
	public function index() {
		$system = $this->Umb_model->read_setting_info(1);
		if($system[0]->module_recruitment=='true'){
			$data['title'] = 'HOME';
			$data['path_url'] = 'home_pekerjaan';
			$data['all_pekerjaans'] = $this->Recruitment_model->get_desc_all_pekerjaans_terakhir();
			$data['all_featured_pekerjaans'] = $this->Recruitment_model->get_desc_featured_pekerjaans_terakhir();
			$data['all_kategoris_pekerjaan'] = $this->Recruitment_model->all_kategoris_pekerjaan();
			$data['subview'] = $this->load->view("frontend/hrastral/home-2", $data, TRUE);
			$this->load->view('frontend/hrastral/layout_pekerjaan/layout_pekerjaan', $data); 
		} else {
			$data['title'] = $this->Umb_model->site_title().' | Log in';
			$theme = $this->Umb_model->read_theme_info(1);
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
			
		}
	}
}
