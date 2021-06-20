<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('Login_model');
		$this->load->model('Karyawans_model');
		$this->load->model('Users_model');
		$this->load->library('email');
		$this->load->model("Umb_model");
		$this->load->model("Penunjukan_model");
		$this->load->model("Department_model");
		$this->load->model("Location_model");
		$this->load->model("Clients_model");
	}
	
	public function index() {		
		$data['title'] = 'Software HR ASTRAL';
		$this->load->view('client/auth/login', $data);	
	}
}