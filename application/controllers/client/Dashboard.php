<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {
	
	public function __construct() {
		parent::__construct();

		$this->load->model('Login_model');
		$this->load->model('Penunjukan_model');
		$this->load->model('Department_model');
		$this->load->model('Karyawans_model');
		$this->load->model('Umb_model');
		$this->load->model('Eumb_model');
		$this->load->model('Biaya_model');
		$this->load->model('Timesheet_model');
		$this->load->model('Perjalanan_model');
		$this->load->model('Training_model');
		$this->load->model('Project_model');
		$this->load->model('Post_pekerjaan_model');
		$this->load->model('Tujuan_tracking_model');
		$this->load->model('Events_model');
		$this->load->model('Meetings_model');
		$this->load->model('Pengumuman_model');
		$this->load->model('Clients_model');
		$this->load->model('Invoices_model');
	}
	
	
	public function output($Return=array()){
		
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		
		exit(json_encode($Return));
	} 
	
	public function index() {
		$session = $this->session->userdata('client_username');
		if(empty($session)){ 
			redirect('client/auth/');
		}
		$clientinfo = $this->Clients_model->read_info_client($session['client_id']);
		$data = array(
			'title' => $this->Umb_model->site_title(),
			'path_url' => 'dashboard',
			'name_client' => $clientinfo[0]->name,
		);
		$data['subview'] = $this->load->view('client/dashboard/index', $data, TRUE);
		$this->load->view('client/layout/layout_main', $data); 
	}
	
	public function set_language($language = "") {
		
		$language = ($language != "") ? $language : "english";
		$this->session->set_userdata('site_lang', $language);
		redirect($_SERVER['HTTP_REFERER']);
	}
}
