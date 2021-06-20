<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Log extends MY_Controller {

	
	public function output($Return=array()){
		
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		
		exit(json_encode($Return));
	}
	
	public function __construct() {
		
		parent::__construct();
		
		$this->load->model('Perusahaan_model');
		$this->load->model('Umb_model');
	}
	
	public function changelog() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('umb_changelog').' | '.$this->Umb_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('umb_changelog');
		$data['path_url'] = 'log';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('87',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/log/changelog", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
		} else {
			redirect('admin/dashboard');
		}
	}
} 
?>