<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Forgot_password extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('email');
		
		$this->load->model("Umb_model");
		$this->load->model("Karyawans_model");
		$this->load->model("Penunjukan_model");
		$this->load->model("Department_model");
		$this->load->model("Location_model");
	}
	
	public function output($Return=array()){
		
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		
		exit(json_encode($Return));
	}
	
	public function index() {
		$data['title'] = $this->lang->line('umb_link_forgot_password');
		$this->load->view('admin/auth/forgot_password', $data);
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
			//$this->email->set_mailtype("html");
			$cinfo = $this->Umb_model->read_info_setting_perusahaan(1);

			$template = $this->Umb_model->read_email_template(2);
			$query = $this->Umb_model->read_user_info_melalui_email($this->input->post('iemail'));
			
			$user = $query->num_rows();
			if($user > 0) {
				
				$user_info = $query->result();
				$full_name = $user_info[0]->first_name.' '.$user_info[0]->last_name;
				
				$subject = $template[0]->subject.' - '.$cinfo[0]->nama_perusahaan;
				$logo = base_url().'uploads/logo/'.$cinfo[0]->logo;
				//$cid = $this->email->attachment_cid($logo);
				$message = '
				<div style="background:#f6f6f6;font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;margin:0;padding:0;padding: 20px;">
				<img src="'.$logo.'" title="'.$cinfo[0]->nama_perusahaan.'"><br>'.str_replace(array("{var site_name}","{var username}","{var email}","{var password}"),array($cinfo[0]->nama_perusahaan,$user_info[0]->username,$user_info[0]->email,$user_info[0]->password),htmlspecialchars_decode(stripslashes($template[0]->message))).'</div>';
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
