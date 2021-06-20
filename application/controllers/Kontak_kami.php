<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class kontak_kami extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		
		$this->load->model("Post_pekerjaan_model");
		$this->load->model("Umb_model");
		$this->load->model("Penunjukan_model");
		$this->load->model("Department_model");
		$this->load->model("Recruitment_model");
		$this->load->library('email');
	}
	
	
	public function output($Return=array()){
		
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		
		exit(json_encode($Return));
	}
	
	public function index()
	{
		$system = $this->Umb_model->read_setting_info(1);
		if($system[0]->module_recruitment!='true'){
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('umb_rec_kontak_kami');
		$data['path_url'] = 'kontak_pekerjaan';
		$data['subview'] = $this->load->view("frontend/hrastral/kontak", $data, TRUE);
		$this->load->view('frontend/hrastral/layout_pekerjaan/layout_pekerjaan', $data); 
	}
	
	public function send_mail() {
		
		if($this->input->post('type')=='kontak') {
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
			if($this->input->post('name')==='') {
				$Return['error'] = $this->lang->line('umb_error_field_nama');
			} else if($this->input->post('email')==='') {
				$Return['error'] = $this->lang->line('umb_error_cemail_field');
			} else if(!filter_var($this->input->post('email'), FILTER_VALIDATE_EMAIL)) {
				$Return['error'] = $this->lang->line('umb_karyawan_error_invalid_email');
			} else if($this->input->post('message')==='') {
				$Return['error'] = "Message field is required.";
			}
			$fd_message = $this->input->post('message');	
			$qfd_message = htmlspecialchars(addslashes($fd_message), ENT_QUOTES);
			
			if($Return['error']!=''){
				$this->output($Return);
			}
			
			if($this->input->post('email')) {
				//$this->email->set_mailtype("html");
				$setting = $this->Umb_model->read_setting_info(1);
				$perusahaan = $this->Umb_model->read_info_setting_perusahaan(1);
				if($setting[0]->enable_email_notification == 'yes') {
					$this->email->set_mailtype("html");
					$cinfo = $this->Umb_model->read_info_setting_perusahaan(1);
					$template = $this->Umb_model->read_email_template(8);
					
					$subject = 'Kontak - '.$cinfo[0]->nama_perusahaan;
					$logo = base_url().'uploads/logo/signin/'.$perusahaan[0]->sign_in_logo;
					$full_name = $this->input->post('name');
					$message = '
					<div style="background:#f6f6f6;font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;margin:0;padding:0;padding: 20px;">
					<img src="'.$logo.'" title="'.$cinfo[0]->nama_perusahaan.'"><br>Full Name: '.$this->input->post('name').'<br>Email: '.$this->input->post('email').'<br>Message: '.htmlspecialchars_decode(stripslashes($qfd_message)).'</div>';
					$this->email->from($this->input->post('email'));
					$this->email->to($cinfo[0]->email);
					
					$this->email->subject($subject);
					$this->email->message($message);
					
					$this->email->send();
					$Return['result'] ='Message has been sent.';
					$this->session->set_flashdata('sent_message', 'Message has been sent.');
				}
				$this->output($Return);
				exit;
			}
		}
	}
}
