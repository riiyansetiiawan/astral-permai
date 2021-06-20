<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pekerjaans extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Umb_model');
		$this->load->model("Post_pekerjaan_model");
		$this->load->model("Penunjukan_model");
		$this->load->model("Department_model");
		$this->load->model("umb_recruitment_model");
	}
	
	public function index() {		
		$data['title'] = $this->Umb_model->site_title().' | Log in';
		$data['subview'] = $this->load->view("frontend/pekerjaans", $data, TRUE);
		$this->load->view('frontend/hrastral/layout_pekerjaan/layout_pekerjaan', $data); 
	}
	public function details() {		
		$data['title'] = $this->Umb_model->site_title().' | Log in';
		$data['subview'] = $this->load->view("frontend/details_pekerjaans", $data, TRUE);
		$this->load->view('frontend/hrastral/layout_pekerjaan/layout_pekerjaan', $data); 
	}
}