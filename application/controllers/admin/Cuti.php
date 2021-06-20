<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cuti extends MY_Controller {

	
	public function output($Return=array()){
		
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		
		exit(json_encode($Return));
	}
	
	public function __construct() {

		parent::__construct();
		
		$this->load->model('Perusahaan_model');
		$this->load->model('Umb_model');
		$this->load->model('Timesheet_model');
	}
	
	public function calendar() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('umb_hr_calendar_cuti');
		$data['breadcrumbs'] = $this->lang->line('umb_hr_calendar_cuti');
		$data['path_url'] = 'calendar_cuti';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('102',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/cuti/calendar_cuti", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
		} else {
			redirect('admin/dashboard');
		}
	}
} 
?>