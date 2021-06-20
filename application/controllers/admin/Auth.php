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
	}


	public function output($Return=array()){

		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");

		exit(json_encode($Return));
	}

	public function login() {

		$this->form_validation->set_rules('iusername', 'Username', 'trim|required|xss_clean');
		$this->form_validation->set_rules('ipassword', 'Password', 'trim|required|xss_clean');
		$username = $this->input->post('iusername');
		$password = $this->input->post('ipassword');
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		if($username==='') {
			$Return['error'] = $this->lang->line('umb_karyawan_error_username');
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
		$result = $this->Login_model->login($data);	
		if ($result == TRUE) {
			$result = $this->Login_model->read_informasi_user($username);
			$session_data = array(
				'user_id' => $result[0]->user_id,
				'username' => $result[0]->username,
				'email' => $result[0]->email,
			);
			$this->session->set_userdata('username', $session_data);
			$this->session->set_userdata('user_id', $session_data);
			$Return['result'] = $this->lang->line('umb_sukses_logged_in');
			$ipaddress = $this->input->ip_address();
			$last_data = array(
				'tanggal_terakhir_login' => date('d-m-Y H:i:s'),
				'terakhir_login_ip' => $ipaddress,
				'is_logged_in' => '1'
			);
			$id = $result[0]->user_id;
			$this->Umb_model->update_record_login($last_data, $id);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$this->session->set_flashdata('kadaluarsa_document_resmi', 'kadaluarsa_document_resmi');
			$this->output($Return);

		} else {
			$Return['error'] = $this->lang->line('umb_error_invalid_credentials');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$this->output($Return);
		}
	}

	public function login_pincode() {

		$this->form_validation->set_rules('iusername', 'Username', 'trim|required|xss_clean');
		$this->form_validation->set_rules('ipassword', 'Password', 'trim|required|xss_clean');
		$pincode = $this->input->post('ipincode');
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		if($pincode==='') {
			$Return['error'] = $this->lang->line('umb_enter_pincode');
		}
		if($Return['error']!=''){
			$this->output($Return);
		}
		$data = array(
			'pincode' => $pincode,
		);
		$result = $this->Login_model->pincode_login($data);
		if ($result == TRUE) {

			$result = $this->Login_model->read_user_info_pin($pincode);
			$session_data = array(
				'user_id' => $result[0]->user_id,
				'username' => $result[0]->username,
				'email' => $result[0]->email,
			);
			$this->session->set_userdata('username', $session_data);
			$this->session->set_userdata('user_id', $session_data);
			$Return['result'] = $this->lang->line('umb_sukses_logged_in');
			$ipaddress = $this->input->ip_address();
			$last_data = array(
				'tanggal_terakhir_login' => date('d-m-Y H:i:s'),
				'terakhir_login_ip' => $ipaddress,
				'is_logged_in' => '1'
			); 
			$id = $result[0]->user_id;
			$this->Umb_model->update_record_login($last_data, $id);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$this->session->set_flashdata('kadaluarsa_document_resmi', 'kadaluarsa_document_resmi');
			$this->output($Return);
		} else {
			$Return['error'] = $this->lang->line('umb_invalid_pincode');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$this->output($Return);
		}
	}

	public function forgot_password() {

		$data['title'] = $this->lang->line('umb_link_forgot_password');
		$this->load->view('admin/auth/forgot_password', $data);
	}

	public function lock() {

		$data['title'] = $this->lang->line('umb_lock_user');

		$session = $this->session->userdata('username');
		$this->session->unset_userdata('username');
		$Return['result'] = 'Locked User.';
		$this->load->view('admin/auth/user_lock', $data);
	}

	public function unlock() {

		$this->form_validation->set_rules('ipassword', 'Password', 'trim|required|xss_clean');
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();

		$password = $this->input->post('ipassword');
		$session_id = $this->session->userdata('user_id');
		$iresult = $this->Login_model->read_user_info_session_id($session_id['user_id']);
		if($password===''){
			$Return['error'] = $this->lang->line('umb_karyawan_error_password');
		}
		if($Return['error']!=''){
			$this->output($Return);
		}
		$system = $this->read_setting_info(1);
		if($system[0]->login_karyawan_id=='username'):
			$username = $iresult[0]->username;
		else:
			$username = $iresult[0]->email;
		endif;
		$data = array(
			'username' => $username,
			'password' => $password
		);
		$result = $this->Login_model->login($data);	
		if ($result == TRUE) {
			$session_data = array(
				'user_id' => $iresult[0]->user_id,
				'username' => $iresult[0]->username,
				'email' => $iresult[0]->email,
			);
			$this->session->set_userdata('username', $session_data);
			$this->session->set_userdata('user_id', $session_data);
			$Return['result'] = $this->lang->line('umb_sukses_logged_in');
			$ipaddress = $this->input->ip_address();

			$last_data = array(
				'tanggal_terakhir_login' => date('d-m-Y H:i:s'),
				'terakhir_login_ip' => $ipaddress,
				'is_logged_in' => '1'
			); 

			$id = $iresult[0]->user_id;

			$this->Umb_model->update_record_login($last_data, $id);
			$this->output($Return);

		} else {
			$Return['error'] = $this->lang->line('umb_error_invalid_credentials');
			$this->output($Return);
		}
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
			$query = $this->Umb_model->read_user_info_melalui_email($this->input->post('iemail'));
			$user = $query->num_rows();
			if($user > 0) {
				$user_info = $query->result();
				$full_name = $user_info[0]->first_name.' '.$user_info[0]->last_name;
				$subject = $template[0]->subject.' - '.$cinfo[0]->nama_perusahaan;
				$logo = base_url().'uploads/logo/signin/'.$cinfo[0]->sign_in_logo;				
				$body = '
				<div style="background:#f6f6f6;font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;margin:0;padding:0;padding: 20px;">
				<img src="'.$logo.'" title="'.$cinfo[0]->nama_perusahaan.'"><br>'.str_replace(array("{var site_name}","{var site_url}","{var email}"),array($cinfo[0]->nama_perusahaan,site_url(),$user_info[0]->email),htmlspecialchars_decode(stripslashes($template[0]->message))).'</div>';

				hrastral_mail($cinfo[0]->email,$cinfo[0]->nama_perusahaan,$this->input->post('iemail'),$subject,$body);			
				$Return['result'] = $this->lang->line('umb_link_reset_password_sukses_sent_email');
			} else {
				$Return['error'] = $this->lang->line('umb_error_email_addres_not_exist');
			}
			$this->output($Return);
			exit;
		}
	}

	public function reset_password() {

		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		if($this->input->get('change') == 'true'){
			if($this->input->get('email')) {
				$this->email->set_mailtype("html");
				$cinfo = $this->Umb_model->read_info_setting_perusahaan(1);
				$template = $this->Umb_model->read_email_template(17);
				$query = $this->Umb_model->read_user_info_melalui_email($this->input->get('email'));
				$user = $query->num_rows();
				if($user > 0) {
					$user_info = $query->result();
					$full_name = $user_info[0]->first_name.' '.$user_info[0]->last_name;
					$subject = $template[0]->subject.' - '.$cinfo[0]->nama_perusahaan;
					$logo = base_url().'uploads/logo/signin/'.$cinfo[0]->sign_in_logo;
					$password = $this->AlphaNumeric(15);
					$options = array('cost' => 12);
					$password_hash = password_hash($password, PASSWORD_BCRYPT, $options);
					$last_data = array(
						'password' => $password_hash,
					); 
					$id = $user_info[0]->user_id;
					$this->Umb_model->update_record_login($last_data, $id);
					$body = '<div style="background:#f6f6f6;font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;margin:0;padding:0;padding: 20px;"><img src="'.$logo.'" title="'.$cinfo[0]->nama_perusahaan.'"><br>'.str_replace(array("{var site_name}","{var username}","{var email}","{var password}"),array($cinfo[0]->nama_perusahaan,$user_info[0]->username,$user_info[0]->pincode,$user_info[0]->email,$password),htmlspecialchars_decode(stripslashes($template[0]->message))).'</div>';
					hrastral_mail($cinfo[0]->email,$cinfo[0]->nama_perusahaan,$this->input->get('email'),$subject,$body);				
					$this->session->set_flashdata('reset_password_success', 'reset_password_success');
					redirect(site_url('admin/'));
				} else {
				}
				
			}
		}
	}
} 
?>