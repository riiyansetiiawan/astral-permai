.<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		
		$this->load->model("Post_pekerjaan_model");
		$this->load->model("Umb_model");
		$this->load->model("Login_model");
		$this->load->model("Users_model");
		$this->load->model("Penunjukan_model");
		$this->load->model("Department_model");
		$this->load->model("Recruitment_model");
	}
	
	public function output($Return=array()){
		
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		
		exit(json_encode($Return));
	}

	public function login() {
		
		$Return = array('result'=>'', 'error'=>'', 'user_type'=>'', 'csrf_hash'=>'');
		//$Return['csrf_hash'] = $this->security->get_csrf_hash();
		if($this->input->post('email')==='') {
			$Return['error'] = $this->lang->line('umb_karyawan_error_email');
		} else if (!filter_var($this->input->post('email'), FILTER_VALIDATE_EMAIL)) {
			$Return['error'] = $this->lang->line('umb_karyawan_error_invalid_email');
		} elseif($this->input->post('password')===''){
			$Return['error'] = $this->lang->line('umb_karyawan_error_password');
		}
		if($Return['error']!=''){
			$this->output($Return);
		}
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		
		$data = array(
			'email' => $email,
			'password' => $password
		);
		$result = $this->Login_model->frontend_user_login($data);	
		if ($result == TRUE) {
			
			$result = $this->Login_model->read_frontend_user_info_session($email);
			$session_data = array(
				'c_user_id' => $result[0]->user_id,
				'c_email' => $result[0]->email,
				'user_type' => $result[0]->user_type
			);
			$this->session->set_userdata('c_email', $session_data);
			$this->session->set_userdata('c_user_id', $session_data);
			$this->session->set_userdata('user_type', $session_data);
			$Return['result'] = $this->lang->line('umb_sukses_logged_in');
			/*if($result[0]->user_type == 1){
				$Return['user_type'] = 'employer/account';
			} else {
				$Return['user_type'] = 'user/account';
			}*/
			$ipaddress = $this->input->ip_address();

			$last_data = array(
				'tanggal_terakhir_login' => date('d-m-Y H:i:s'),
				'terakhir_login_ip' => $ipaddress,
				'is_logged_in' => '1'
			); 
			$id = $result[0]->user_id;
			$this->Users_model->update_record($last_data, $id);
			$this->output($Return);
		} else {
			$Return['error'] = $this->lang->line('umb_error_invalid_credentials');
			$this->output($Return);
		}
	}

	public function logout() {

		$session = $this->session->userdata('c_user_id');
		$last_data = array(
			'is_logged_in' => '0'
		); 
		$this->Users_model->update_record($last_data, $session['c_user_id']);
		$data['title'] = 'Software HR ASTRAL';
		$sess_array = array('c_user_id' => '','c_email' => '');
		$this->session->sess_destroy();
		$Return['result'] = 'Successfully Logout.';
		redirect('user/sign_in/', 'refresh');
	}
}
