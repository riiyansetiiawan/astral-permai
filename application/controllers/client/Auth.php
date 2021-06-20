<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends MY_Controller {
	
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
	
	public function output($Return=array()){
		
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		exit(json_encode($Return));
	}
	
	public function index() {		
		$data['title'] = 'Software HR ASTRAL';
		$this->load->view('client/auth/login', $data);	
	}
	
	public function login() {
		
		$this->form_validation->set_rules('iusername', 'Username', 'trim|required|xss_clean');
		$this->form_validation->set_rules('ipassword', 'Password', 'trim|required|xss_clean');
		//$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		/*if ($this->form_validation->run() == FALSE) {
			//$this->load->view('myform');
		}*/
		$username = $this->input->post('iusername');
		$password = $this->input->post('ipassword');
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		if($username==='') {
			$Return['error'] = $this->lang->line('umb_karyawan_error_email');
		} elseif($password===''){
			$Return['error'] = $this->lang->line('umb_karyawan_error_password');
		}
		if($Return['error']!=''){
			$this->output($Return);
		}
		$data = array(
			'username' => $username,
			'password' => $password
		);
		$result = $this->Clients_model->login($data);	
		if ($result == TRUE) {
			
			$result1 = $this->Clients_model->read_infomasi_client($username);
			$session_data = array(
				'client_id' => $result1[0]->client_id,
				'client_username' => $result1[0]->client_username,
				'client_email' => $result1[0]->email
			);
			$this->session->set_userdata('client_username', $session_data);
			$this->session->set_userdata('client_id', $session_data);
			$this->session->set_userdata('client_email', $session_data);
			$Return['result'] = $this->lang->line('umb_sukses_logged_in');
			$ipaddress = $this->input->ip_address();
			$last_data = array(
				'tanggal_terakhir_login' => date('d-m-Y H:i:s'),
				'terakhir_login_ip' => $ipaddress,
				'is_logged_in' => '1'
			); 
			$id = $result1[0]->client_id;
			$this->Clients_model->update_record($last_data, $id);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$this->output($Return);

		} else {
			$Return['error'] = $this->lang->line('umb_error_invalid_credentials');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$this->output($Return);
		}
	}

	public function forgot_password() {
		$data['title'] = $this->lang->line('umb_link_forgot_password');
		$this->load->view('client/auth/forgot_password', $data);
	}

	public static function AlphaNumeric($length) {
		$chars = "1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
		$clen   = strlen( $chars )-1;
		$id  = '';
		for ($i = 0; $i < $length; $i++) {
			$id .= $chars[mt_rand(0,$clen)];
		}
		return ($id);
	}

	public function send_mail() {

		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		if($this->input->post('iemail')==='') {
			$Return['error'] = $this->lang->line('umb_error_enter_email_address');
		} else if(!filter_var($this->input->post('iemail'), FILTER_VALIDATE_EMAIL)) {
			$Return['error'] = $this->lang->line('umb_karyawan_error_invalid_email');
		}
		if($Return['error']!=''){
			$this->output($Return);
		}
		if($this->input->post('iemail')) {

			$this->email->set_mailtype("html");
			$cinfo = $this->Umb_model->read_info_setting_perusahaan(1);
			$template = $this->Umb_model->read_email_template(2);
			$query = $this->Clients_model->read_info_client_melalui_email($this->input->post('iemail'));
			$user = $query->num_rows();
			if($user > 0) {
				$user_info = $query->result();
				$full_name = $user_info[0]->name;
				$subject = $template[0]->subject.' - '.$cinfo[0]->nama_perusahaan;
				$logo = base_url().'uploads/logo/signin/'.$cinfo[0]->sign_in_logo;
				//$cid = $this->email->attachment_cid($logo);
				$password = $this->AlphaNumeric(15);
				$options = array('cost' => 12);
				$password_hash = password_hash($password, PASSWORD_BCRYPT, $options);
				$last_data = array(
					'password_client' => $password_hash,
				); 
				$id = $user_info[0]->client_id;
				$this->Clients_model->update_record($last_data, $id);
				$message = '
				<div style="background:#f6f6f6;font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;margin:0;padding:0;padding: 20px;">
				<img src="'.$logo.'" title="'.$cinfo[0]->nama_perusahaan.'"><br>'.str_replace(array("{var site_name}","{var username}","{var email}","{var password}"),array($cinfo[0]->nama_perusahaan,$user_info[0]->name,$user_info[0]->email,$password),htmlspecialchars_decode(stripslashes($template[0]->message))).'</div>';
				$this->email->from($cinfo[0]->email, $cinfo[0]->nama_perusahaan);
				$this->email->to($this->input->post('iemail'));
				$this->email->subject($subject);
				$this->email->message($message);
				$this->email->send();
				$Return['result'] = $this->lang->line('umb_sukses_sent_forgot_password');
			} else {
				$Return['error'] = $this->lang->line('umb_error_email_addres_not_exist');
			}
			$this->output($Return);
			exit;
		}
	}
} 
?>