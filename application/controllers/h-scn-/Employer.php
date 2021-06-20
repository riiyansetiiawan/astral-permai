<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Employer extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('Umb_model');
		$this->load->model("Post_pekerjaan_model");
		$this->load->model("Penunjukan_model");
		$this->load->model("Department_model");
		$this->load->model("umb_recruitment_model");
	}

	public function post_a_pekerjaan() {		
		$data['title'] = $this->Umb_model->site_title();
		$data['subview'] = $this->load->view("frontend/employer_post_new", $data, TRUE);
		$this->load->view('frontend/hrastral/layout_pekerjaan/layout_pekerjaan', $data); 
	}

	public function manage_pekerjaans() {		
		$data['title'] = $this->Umb_model->site_title();
		$data['subview'] = $this->load->view("frontend/employer_manage_pekerjaans", $data, TRUE);
		$this->load->view('frontend/hrastral/layout_pekerjaan/layout_pekerjaan', $data); 
	}

	public function kandidats_resumes() {		
		$data['title'] = $this->Umb_model->site_title();
		$data['subview'] = $this->load->view("frontend/employer_resume", $data, TRUE);
		$this->load->view('frontend/hrastral/layout_pekerjaan/layout_pekerjaan', $data); 
	}

	public function change_password() {		
		$data['title'] = $this->Umb_model->site_title();
		$data['subview'] = $this->load->view("frontend/employer_change_password", $data, TRUE);
		$this->load->view('frontend/hrastral/layout_pekerjaan/layout_pekerjaan', $data); 
	}
}