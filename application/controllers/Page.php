<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends MY_Controller {
	
	 public function __construct() {
        parent::__construct();
		
		$this->load->model("Post_pekerjaan_model");
		$this->load->model("Umb_model");
		$this->load->model("Penunjukan_model");
		$this->load->model("Department_model");
		$this->load->model("Recruitment_model");
	}
	
	public function output($Return=array()){
		
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		
		exit(json_encode($Return));
	}

	public function view() {
		$system = $this->Umb_model->read_setting_info(1);
		if($system[0]->module_recruitment!='true'){
			redirect('admin/');
		}
		$url = $this->uri->segment(3);
		$result = $this->Recruitment_model->read_info_main_page($url);
		if(is_null($result)){ 
			redirect('pekerjaans/');
		}
		$data = array(
			'title' => $result[0]->page_title,
			'path_url' => '',
			'page_title' => $result[0]->page_title,
			'page_id' => $result[0]->page_id,
			'page_url' => $result[0]->page_url,
			'page_details' => $result[0]->page_details
		);
		$data['subview'] = $this->load->view("frontend/hrastral/pages", $data, TRUE);
		$this->load->view('frontend/hrastral/layout_pekerjaan/layout_pekerjaan', $data); 
     }	 
}
