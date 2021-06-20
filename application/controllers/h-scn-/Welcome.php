<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Umb_model');
		$this->load->model("Post_pekerjaan_model");
		$this->load->model("Penunjukan_model");
		$this->load->model("Department_model");
		$this->load->model("Recruitment_model");
	}
	
	public function index()
	{		
		$data['title'] = $this->Umb_model->site_title().' | Log in';
		$data['all_pekerjaans'] = $this->Recruitment_model->get_desc_all_pekerjaans_terakhir();
		$data['subview'] = $this->load->view("frontend/home", $data, TRUE);
		$this->load->view('frontend/hrastral/layout_pekerjaan/layout_pekerjaan', $data); 
	}
}