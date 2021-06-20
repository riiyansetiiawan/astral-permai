<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class My_pekerjaans extends MY_Controller {
	
	 public function __construct() {
        parent::__construct();
		
		$this->load->model("Post_pekerjaan_model");
		$this->load->model("Umb_model");
		$this->load->model("Penunjukan_model");
		$this->load->model("Department_model");
	}
	
	
	public function output($Return=array()){
		
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		
		exit(json_encode($Return));
	}
	
	 public function index() {
		$data['title'] = $this->Umb_model->site_title();
		$data['all_penunjukans'] = $this->Penunjukan_model->all_penunjukans();
		$data['all_types_pekerjaan'] = $this->Post_pekerjaan_model->all_types_pekerjaan();
		$data['all_pekerjaans'] = $this->Post_pekerjaan_model->all_pekerjaans();
		$data['all_pekerjaans_by_penunjukan'] = $this->Post_pekerjaan_model->read_all_pekerjaans_melalui_penunjukan();
		$session = $this->session->userdata('c_user_id');
		$data['subview'] = $this->load->view("frontend/hrastral/my_pekerjaans", $data, TRUE);
		$this->load->view('frontend/hrastral/layout_pekerjaan/layout_pekerjaan', $data); 
     }
}
