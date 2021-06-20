<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Organization extends MY_Controller{

	public function output($Return=array()){
		
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		
		exit(json_encode($Return));
	}
	
	public function __construct() {
		parent::__construct();

		$this->load->model('Perusahaan_model');
		$this->load->model("Department_model");
		$this->load->model("Penunjukan_model");
		$this->load->model('Umb_model');
	}

	public function chart() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$system = $this->Umb_model->read_setting_info(1);
		if($system[0]->module_orgchart!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('umb_title_org_chart').' | '.$this->Umb_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('umb_title_org_chart');
		$data['path_url'] = 'organization_chart';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('96',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/orgchart/orgchart", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
		} else {
			redirect('admin/dashboard');
		}
	}
} 
?>