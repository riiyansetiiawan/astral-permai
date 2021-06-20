<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends MY_Controller {


	public function output($Return=array()){
		
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		
		exit(json_encode($Return));
	}
	
	public function __construct() {
		parent::__construct();

		$this->load->model('Login_model');
		$this->load->model('Clients_model');
		date_default_timezone_set("Asia/Jakarta");
	}

	public function index() {

		$session = $this->session->userdata('client_username');
		$last_data = array(
			'is_logged_in' => '0',
			'terakhir_logout_tanggal' => date('d-m-Y H:i:s')
		); 
		$this->Clients_model->update_record($last_data, $session['client_id']);
		$data['title'] = 'Software HR ASTRAL';
		$sess_array = array('username' => '');
		$this->session->sess_destroy();
		$Return['result'] = 'Successfully Logout.';
		redirect('client/auth/', 'refresh');
	}
} 
?>