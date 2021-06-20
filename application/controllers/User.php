.<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		
		$this->load->model("Post_pekerjaan_model");
		$this->load->model("Umb_model");
		$this->load->model("Login_model");
		$this->load->model("Users_model");
		//$this->load->model("Penunjukan_model");
		//$this->load->model("Department_model");
		$this->load->model("Recruitment_model");
	}
	
	
	public function output($Return=array()){
		
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		
		exit(json_encode($Return));
	}
	
	public function sign_in() {

		$system = $this->Umb_model->read_setting_info(1);
		if($system[0]->module_recruitment!='true'){
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('umb_sign_in_button');
		$session = $this->session->userdata('c_user_id');
		if(!empty($session)){
			redirect('');
		}
		$data['path_url'] = 'user_signin_pekerjaan';
		$data['subview'] = $this->load->view("frontend/hrastral/sign_in", $data, TRUE);
		$this->load->view('frontend/hrastral/layout_pekerjaan/layout_pekerjaan', $data); 
	}

	public function elogin() {

		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
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
		} else {
			$Return['error'] = $this->lang->line('umb_error_invalid_credentials');
		}
		$this->output($Return);
		exit;
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
	
	public function register() {

		$system = $this->Umb_model->read_setting_info(1);
		if($system[0]->module_recruitment!='true'){
			redirect('admin/');
		}
		$data['title'] = 'Sign Up';
		$session = $this->session->userdata('c_user_id');
		if(!empty($session)){
			redirect('');
		}
		$data['path_url'] = 'create_user_pekerjaan';
		$data['subview'] = $this->load->view("frontend/hrastral/register", $data, TRUE);
		$this->load->view('frontend/hrastral/layout_pekerjaan/layout_pekerjaan', $data); 
	}

	public function forgot_password() {

		$system = $this->Umb_model->read_setting_info(1);
		if($system[0]->module_recruitment!='true'){
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('umb_forgot_password_title');
		$data['subview'] = $this->load->view("frontend/hrastral/forgot_password", $data, TRUE);
		$this->load->view('frontend/hrastral/layout_pekerjaan/layout_pekerjaan', $data); 
	}

	public function change_password() {

		$data['title'] = $this->lang->line('header_change_password');
		$data['path_url'] = 'user_password_pekerjaan';
		$session = $this->session->userdata('c_user_id');
		if(empty($session)){
			redirect('user/sign_in/');
		}
		$data['subview'] = $this->load->view("frontend/hrastral/change_password", $data, TRUE);
		$this->load->view('frontend/hrastral/layout_pekerjaan/layout_pekerjaan', $data); 
	}

	public function my_pekerjaans() {

		$system = $this->Umb_model->read_setting_info(1);
		if($system[0]->module_recruitment!='true'){
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('left_applied_pekerjaans');
		$data['path_url'] = 'user_account_pekerjaan';
		$session = $this->session->userdata('c_user_id');
		if(empty($session)){
			redirect('user/sign_in/');
		}
		$data['subview'] = $this->load->view("frontend/hrastral/my_pekerjaans", $data, TRUE);
		$this->load->view('frontend/hrastral/layout_pekerjaan/layout_pekerjaan', $data); 
	}

	public function account() {
		
		$system = $this->Umb_model->read_setting_info(1);
		if($system[0]->module_recruitment!='true'){
			redirect('admin/');
		}
		$session = $this->session->userdata('c_user_id');
		if(empty($session)){
			redirect('user/sign_in/');
		}
		$result = $this->Users_model->read_users_info($session['c_user_id']);
		$data = array(
			'path_url' => 'user_account_pekerjaan',
			'title' => $this->lang->line('umb_rec_my_account'),
			'user_id' => $result[0]->user_id,
			'first_name' => $result[0]->first_name,
			'last_name' => $result[0]->last_name,
			'email' => $result[0]->email,
			'username' => $result[0]->username,
			'password' => $result[0]->password,
			'jenis_kelamin' => $result[0]->jenis_kelamin,
			'profile_photo' => $result[0]->profile_photo,
			'profile_background' => $result[0]->profile_background,
			'nomor_kontak' => $result[0]->nomor_kontak,
			'alamat_1' => $result[0]->alamat_1,
			'alamat_2' => $result[0]->alamat_2,
			'kota' => $result[0]->kota,
			'provinsi' => $result[0]->provinsi,
			'kode_pos' => $result[0]->kode_pos,
			'inegara' => $result[0]->negara,
			'tanggal_terakhir_login' => $result[0]->tanggal_terakhir_login,
			'terakhir_login_ip' => $result[0]->terakhir_login_ip,
			'is_logged_in' => $result[0]->is_logged_in,
			'all_negaraa' => $this->Umb_model->get_negaraa()
		);
		$data['subview'] = $this->load->view("frontend/hrastral/user_account", $data, TRUE);
		$this->load->view('frontend/hrastral/layout_pekerjaan/layout_pekerjaan', $data); 
	}

	
	public function update() {

		if($this->input->post('edit_type')=='user') {

			$session = $this->session->userdata('c_user_id');
			$id = $session['c_user_id'];
			$this->form_validation->set_rules('first_name', 'First Name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
			$file = $_FILES['photo']['tmp_name'];
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			if($this->input->post('first_name')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_first_name');
			} else if( $this->input->post('last_name')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_last_name');
			} else if($this->input->post('email')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_email');
			} else if (!filter_var($this->input->post('email'), FILTER_VALIDATE_EMAIL)) {
				$Return['error'] = $this->lang->line('umb_karyawan_error_invalid_email');
			} else if($this->input->post('kota')==='') {
				$Return['error'] = $this->lang->line('umb_error_fiel_kota');
			} else if($this->input->post('negara')==='') {
				$Return['error'] = $this->lang->line('umb_error_field_negara');
			}		
			else if($_FILES['photo']['size'] == 0) {
				$fname = 'no file';
				$no_logo_data = array(
					'first_name' => $this->input->post('first_name'),
					'last_name' => $this->input->post('last_name'),
					'email' => $this->input->post('email'),
					'jenis_kelamin' => $this->input->post('jenis_kelamin'),
					'nomor_kontak' => $this->input->post('nomor_kontak'),
					'alamat_1' => $this->input->post('alamat_1'),
					'alamat_2' => $this->input->post('alamat_2'),
					'kota' => $this->input->post('kota'),
					'provinsi' => $this->input->post('provinsi'),
					'kode_pos' => $this->input->post('kode_pos'),
					'negara' => $this->input->post('negara')
				);
				$result = $this->Users_model->update_record_no_photo($no_logo_data,$id);
			} else {
				if(is_uploaded_file($_FILES['photo']['tmp_name'])) {

					$allowed =  array('png','jpg','jpeg','gif');
					$filename = $_FILES['photo']['name'];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);

					if(in_array($ext,$allowed)){
						$tmp_name = $_FILES["photo"]["tmp_name"];
						$bill_copy = "uploads/users/";
						$lname = basename($_FILES["photo"]["name"]);
						$newfilename = 'user_'.round(microtime(true)).'.'.$ext;
						move_uploaded_file($tmp_name, $bill_copy.$newfilename);
						$fname = $newfilename;
						$data = array(
							'first_name' => $this->input->post('first_name'),
							'last_name' => $this->input->post('last_name'),
							'email' => $this->input->post('email'),
							'nomor_kontak' => $this->input->post('nomor_kontak'),
							'alamat_1' => $this->input->post('alamat_1'),
							'alamat_2' => $this->input->post('alamat_2'),
							'kota' => $this->input->post('kota'),
							'provinsi' => $this->input->post('provinsi'),
							'kode_pos' => $this->input->post('kode_pos'),
							'negara' => $this->input->post('negara'),
							'profile_photo' => $fname,		
						);
						$result = $this->Users_model->update_record($data,$id);
					} else {
						$Return['error'] = $this->lang->line('umb_error_attatchment_type');
					}
				}
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_user_profile_update');
			} else {
				$Return['error'] = $Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
}
