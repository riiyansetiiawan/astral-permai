<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pekerjaans extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		
		$this->load->model("Post_pekerjaan_model");
		$this->load->model("Umb_model");
		$this->load->model("Penunjukan_model");
		$this->load->model("Department_model");
	}
	
	public function output($Return=array()){
		
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		
		exit(json_encode($Return));
	}
	
	public function index() {

		$data['title'] = $this->Umb_model->site_title();
		$data['all_penunjukans'] = $this->Penunjukan_model->all_penunjukans();
		$data['all_types_pekerjaan'] = $this->Post_pekerjaan_model->all_types_pekerjaan();
		$data['all_pekerjaans'] = $this->Post_pekerjaan_model->all_pekerjaans();
		$data['all_pekerjaans_by_penunjukan'] = $this->Post_pekerjaan_model->read_all_pekerjaans_melalui_penunjukan();
		$session = $this->session->userdata('username');
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(!empty($session)){ 
			$this->load->view("frontend/pekerjaans", $data);
		} else {
			redirect('admin/');
		}
	}
	
	public function detail() {

		$data['title'] = $this->Umb_model->site_title();
		$id = $this->uri->segment(4);
		$result = $this->Post_pekerjaan_model->read_informasi_pekerjaan($id);
		if(is_null($result)){
			redirect('admin/post_pekerjaan');
		}
		$data = array(
			'pekerjaan_id' => $result[0]->pekerjaan_id,
			'title' => $this->Umb_model->site_title(),
			'title_pekerjaan' => $result[0]->title_pekerjaan,
			'penunjukan_id' => $result[0]->penunjukan_id,
			'type_pekerjaan_id' => $result[0]->type_pekerjaan,
			'lowongan_pekerjaan' => $result[0]->lowongan_pekerjaan,
			'jenis_kelamin' => $result[0]->jenis_kelamin,
			'minimum_pengalaman' => $result[0]->minimum_pengalaman,
			'tanggal_penutupan' => $result[0]->tanggal_penutupan,
			'short_description' => $result[0]->short_description,
			'long_description' => $result[0]->long_description,
			'status' => $result[0]->status,
			'created_at' => $result[0]->created_at,
			'all_penunjukans' => $this->Penunjukan_model->all_penunjukans(),
			'all_types_pekerjaan' => $this->Post_pekerjaan_model->all_types_pekerjaan()
		);
		$session = $this->session->userdata('username');
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(!empty($session)){ 
			$this->load->view('frontend/details_pekerjaan', $data);
		} else {	
			redirect('admin/');
		}
	}
	
	public function apply() {

		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('pekerjaan_id');
		$result = $this->Post_pekerjaan_model->read_informasi_pekerjaan($id);
		$data = array(
			'pekerjaan_id' => $result[0]->pekerjaan_id,
			'title_pekerjaan' => $result[0]->title_pekerjaan,
			'penunjukan_id' => $result[0]->penunjukan_id,
			'type_pekerjaan_id' => $result[0]->type_pekerjaan,
			'lowongan_pekerjaan' => $result[0]->lowongan_pekerjaan,
			'jenis_kelamin' => $result[0]->jenis_kelamin,
			'minimum_pengalaman' => $result[0]->minimum_pengalaman,
			'tanggal_penutupan' => $result[0]->tanggal_penutupan,
			'short_description' => $result[0]->short_description,
			'long_description' => $result[0]->long_description,
			'status' => $result[0]->status,
			'all_penunjukans' => $this->Penunjukan_model->all_penunjukans(),
			'all_types_pekerjaan' => $this->Post_pekerjaan_model->all_types_pekerjaan()
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('frontend/dialog_apply_pekerjaan', $data);
		} else {
			redirect('');
		}
	}
	
	public function apply_pekerjaan() {
		
		if($this->input->post('add_type')=='apply_pekerjaan') {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			
			$user_id = $this->input->post('user_id');
			$pekerjaan_id = $this->uri->segment(4);
			$message = $this->input->post('message');	
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$system_setting = $this->Umb_model->read_setting_info(1);
			$result = $this->Post_pekerjaan_model->check_apply_pekerjaan($pekerjaan_id,$user_id);
			if($result->num_rows() > 0) {
				$Return['error'] = $this->lang->line('umb_already_applied_for_this_pekerjaan');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			if($_FILES['resume']['size'] == 0) {
				$Return['error'] = $this->lang->line('umb_upload_your_resume');
			} else if($message == '') {
				$Return['error'] = $this->lang->line('umb_error_recovering_message');
			} else {
				if(is_uploaded_file($_FILES['resume']['tmp_name'])) {
					$allowed =  explode( ',',$system_setting[0]->pekerjaan_application_format);
					$filename = $_FILES['resume']['name'];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);
					if(in_array($ext,$allowed)){
						$tmp_name = $_FILES["resume"]["tmp_name"];
						$resume = "uploads/resume/";
						$name = basename($_FILES["resume"]["name"]);
						$newfilename = 'resume_'.round(microtime(true)).'.'.$ext;
						move_uploaded_file($tmp_name, $resume.$newfilename);
						$fname = $newfilename;
					} else {
						$Return['error'] = $this->lang->line('umb_resume_attachment_must_be').': '.$system_setting[0]->pekerjaan_application_format;
					}
				}
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$data = array(
				'pekerjaan_id' => $pekerjaan_id,
				'user_id' => $user_id,
				'message' => $message,
				'pekerjaan_resume' => $fname,
				'application_status' => 'Applied',
				'created_at' => date('Y-m-d h:i:s')
			);
			$result = $this->Post_pekerjaan_model->add_resume($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_resume_submitted');
				$setting = $this->Umb_model->read_setting_info(1);
				if($setting[0]->enable_email_notification == 'yes') {
					$this->email->set_mailtype("html");
					$cinfo = $this->Umb_model->read_info_setting_perusahaan(1);
					$template = $this->Umb_model->read_email_template(11);
					$user_info = $this->Umb_model->read_user_info($this->input->post('user_id'));
					$full_name = $user_info[0]->first_name.' '.$user_info[0]->last_name;
					$result = $this->Post_pekerjaan_model->read_informasi_pekerjaan($pekerjaan_id);
					$subject = $template[0]->subject.' - '.$cinfo[0]->nama_perusahaan;
					$logo = base_url().'uploads/logo/'.$cinfo[0]->logo;
					$message = '
					<div style="background:#f6f6f6;font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;margin:0;padding:0;padding: 20px;">
					<img src="'.$logo.'" title="'.$cinfo[0]->nama_perusahaan.'"><br>'.str_replace(array("{var site_name}","{var site_url}","{var nama_karyawan}","{var title_pekerjaan}"),array($cinfo[0]->nama_perusahaan,site_url(),$full_name,$result[0]->title_pekerjaan),htmlspecialchars_decode(stripslashes($template[0]->message))).'</div>';
					$this->email->from($user_info[0]->email, $full_name);
					$this->email->to($cinfo[0]->email);
					$this->email->subject($subject);
					$this->email->message($message);
					$this->email->send();
				}
				
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
}
