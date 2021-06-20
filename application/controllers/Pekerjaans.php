<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pekerjaans extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		
		$this->load->model("Post_pekerjaan_model");
		$this->load->model("Umb_model");
		$this->load->model("Penunjukan_model");
		$this->load->model("Department_model");
		$this->load->model("Recruitment_model");
		$this->load->library("pagination");
		$this->load->library('email');
		$this->load->model("Users_model");
	}
	
	
	public function output($Return=array()){
		
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		
		exit(json_encode($Return));
	}
	
	public function index() {
		
		$system = $this->Umb_model->read_setting_info(1);
		if($system[0]->module_recruitment!='true'){
			redirect('admin/');
		}
		$data['title'] = 'Pekerjaan | '.$this->Umb_model->site_title();
		$data['all_penunjukans'] = $this->Penunjukan_model->all_penunjukans();
		$data['all_types_pekerjaan'] = $this->Umb_model->get_type_pekerjaan();
		$data['all_pekerjaans'] = $this->Recruitment_model->get_desc_all_pekerjaans();
		$data['all_featured_pekerjaans'] = $this->Recruitment_model->get_desc_featured_pekerjaans_terakhir();
		$data['all_kategoris_pekerjaan'] = $this->Recruitment_model->all_kategoris_pekerjaan();
		$data['count_search_pekerjaans'] = '';
		$session = $this->session->userdata('c_user_id');
		if($this->input->get("search")) {
			$type_record_count = $this->Recruitment_model->record_count_search_pekerjaan($this->input->get("search"));
			$data['count_search_pekerjaans'] = $this->Recruitment_model->record_count_search_pekerjaan($this->input->get("search"));
			$baseUrl = site_url() . "pekerjaans/?search=".$this->input->get("search");
		} else {
			$type_record_count = $this->Recruitment_model->record_count_pekerjaan();
			$data['count_search_pekerjaans'] = $this->Recruitment_model->record_count_pekerjaan();
			$baseUrl = site_url() . "pekerjaans/";
		}

		$config = array(
			'base_url'          => $baseUrl,
			'total_rows'        => $type_record_count,
			'per_page'          => 10,
			'num_links'         => 10,
			'use_page_numbers'  => true,
			'page_query_string' => true,
			'uri_segment'       => $this->input->get("per_page"),
			'full_tag_open'     => '<ul>',
			'full_tag_close'    => '</ul>',
			'first_link'        => '<<',
			'first_tag_open'    => '<li>',
			'first_tag_close'   => '</li>',
			'last_link'         => '>>',
			'last_tag_open'     => '<li>',
			'last_tag_close'    => '</li>',
			'next_link'         => '>',
			'next_tag_open'     => '<li>',
			'next_tag_close'    => '</li>',
			'prev_link'         => '<',
			'prev_tag_open'     => '<li>',
			'prev_tag_close'    => '</li>',
			'cur_tag_open'      => '<li><a href="#" class="current-page">',
			'cur_tag_close'     => '</a></li>',
			'num_tag_open'      => '<li>',
			'num_tag_close'     => '</li>'
		);

		$this->pagination->initialize($config);

		$page = ($this->input->get("per_page")) ? $this->input->get("per_page") : 0;
       // $data["results"] = $this->umb_recruitment_model->fetch_all_pekerjaans($config["per_page"], $page);
		if($this->input->get("search")) {
			$data["results"] = $this->Recruitment_model->search_fetch_all_pekerjaans($config["per_page"], $page, $this->input->get("search"));
		} else {
			$data["results"] = $this->Recruitment_model->fetch_all_pekerjaans($config["per_page"], $page);
		}
		$str_links = $this->pagination->create_links();
		$data["links"] = explode('&nbsp;',$str_links );
		
		$data['subview'] = $this->load->view("frontend/hrastral/list_pekerjaans", $data, TRUE);
		$this->load->view('frontend/hrastral/layout_pekerjaan/layout_pekerjaan', $data); 
	}

	public function search() {
		
		$system = $this->Umb_model->read_setting_info(1);
		if($system[0]->module_recruitment!='true'){
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$this->uri->segment(3);
		$data['all_penunjukans'] = $this->Penunjukan_model->all_penunjukans();
		$data['all_types_pekerjaan'] = $this->Umb_model->get_type_pekerjaan();
		$data['all_pekerjaans'] = $this->Recruitment_model->get_desc_all_pekerjaans();
		$data['all_featured_pekerjaans'] = $this->Recruitment_model->get_desc_featured_pekerjaans_terakhir();
		$data['all_kategoris_pekerjaan'] = $this->Recruitment_model->all_kategoris_pekerjaan();
		$session = $this->session->userdata('c_user_id');
		if($this->uri->segment(3) == 'kategori') {
			$type_record_count = $this->Recruitment_model->record_count_kategori_pekerjaan($this->uri->segment(4));
			if($type_record_count < 1){
				redirect('pekerjaans/');
			}
			$data['count_search_pekerjaans'] = $this->Recruitment_model->record_count_kategori_pekerjaan($this->uri->segment(4));
		} else {
			$type_record_count = $this->Recruitment_model->record_count_type_pekerjaan($this->uri->segment(4));
			if($type_record_count < 1){
				redirect('pekerjaans/');
			}
			$data['count_search_pekerjaans'] = $this->Recruitment_model->record_count_type_pekerjaan($this->uri->segment(4));
		}
		$config = array(
			'base_url'          => site_url() . "pekerjaans/search/".$this->uri->segment(3).'/'.$this->uri->segment(4).'/',
			'total_rows'        => $type_record_count,
			'per_page'          => 10,
			'num_links'         => 10,
			'use_page_numbers'  => true,
			'page_query_string' => false,
			'uri_segment'       => 5,
			'full_tag_open'     => '<ul>',
			'full_tag_close'    => '</ul>',
			'first_link'        => '<<',
			'first_tag_open'    => '<li>',
			'first_tag_close'   => '</li>',
			'last_link'         => '>>',
			'last_tag_open'     => '<li>',
			'last_tag_close'    => '</li>',
			'next_link'         => '>',
			'next_tag_open'     => '<li>',
			'next_tag_close'    => '</li>',
			'prev_link'         => '<',
			'prev_tag_open'     => '<li>',
			'prev_tag_close'    => '</li>',
			'cur_tag_open'      => '<li><a href="#" class="current-page">',
			'cur_tag_close'     => '</a></li>',
			'num_tag_open'      => '<li>',
			'num_tag_close'     => '</li>'
		);

		$this->pagination->initialize($config);

		$page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
		if($this->uri->segment(3) == 'kategori') {
			$data["results"] = $this->Recruitment_model->fetch_all_kategori_pekerjaans($config["per_page"], $page, $this->uri->segment(4));
		} else {
			$data["results"] = $this->Recruitment_model->fetch_all_type_pekerjaans($config["per_page"], $page, $this->uri->segment(4));
		}
		$str_links = $this->pagination->create_links();
		$data["links"] = explode('&nbsp;',$str_links );
		
		$data['subview'] = $this->load->view("frontend/hrastral/search_pekerjaans", $data, TRUE);
		$this->load->view('frontend/hrastral/layout_pekerjaan/layout_pekerjaan', $data); 
	}	 

	public function kategoris() {
		$system = $this->Umb_model->read_setting_info(1);
		if($system[0]->module_recruitment!='true'){
			redirect('admin/');
		}
		$data['title'] = 'Browser Kategori Pekerjaan';
		$data['path_url'] = 'create_pekerjaan';
		$session = $this->session->userdata('c_user_id');
		
		//$data['all_types_pekerjaan'] = $this->Post_pekerjaan_model->all_types_pekerjaan();
		$data['all_kategoris_pekerjaan'] = $this->Recruitment_model->all_kategoris_pekerjaan();
		$data['subview'] = $this->load->view("frontend/hrastral/kategoris_pekerjaan", $data, TRUE);
		$this->load->view('frontend/hrastral/layout_pekerjaan/layout_pekerjaan', $data); 
	}

	public function detail()
	{
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->uri->segment(3);
		$result = $this->Post_pekerjaan_model->read_info_pekerjaan_melalui_url($id);
		if(is_null($result)){
			redirect('pekerjaans');
		}
		$data = array(
			'path_url' => 'pekerjaan_detail',
			'pekerjaan_id' => $result[0]->pekerjaan_id,
			'title' => $this->Umb_model->site_title(),
			'title_pekerjaan' => $result[0]->title_pekerjaan,
			'employer_id' => $result[0]->employer_id,
			'kategori_id' => $result[0]->kategori_id,
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
		$session = $this->session->userdata('c_user_id');
		//$role_resources_ids = $this->Umb_model->user_role_resource();
		$data['subview'] = $this->load->view("frontend/hrastral/detail_pekerjaans", $data, TRUE);
		$this->load->view('frontend/hrastral/layout_pekerjaan/layout_pekerjaan', $data); 
	}
	
	public function apply()
	{
		$system = $this->Umb_model->read_setting_info(1);
		if($system[0]->module_recruitment!='true'){
			redirect('admin/');
		}
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
			redirect('home');
		}
	}
	
	
	public function apply_pekerjaan() {

		if($this->input->post('add_type')=='apply_pekerjaan') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();

			$user_id = $this->input->post('user_id');
			$pekerjaan_id = $this->input->post('pekerjaan_id');
			$message = $this->input->post('message');	

		// settting
			$system_setting = $this->Umb_model->read_setting_info(1);

			$result = $this->Recruitment_model->check_apply_pekerjaan_wlog($pekerjaan_id,$this->input->post('email'));
			if($result->num_rows() > 0) {
				$Return['error'] = $this->lang->line('umb_already_applied_for_this_pekerjaan');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}

			if($this->input->post('full_name')==='') {
				$Return['error'] = $this->lang->line('umb_full_name_field_error');
			} else if($this->input->post('email')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_email');
			} else if (!filter_var($this->input->post('email'), FILTER_VALIDATE_EMAIL)) {
				$Return['error'] = $this->lang->line('umb_karyawan_error_invalid_email');
			} else if($message === '') {
				$Return['error'] = $this->lang->line('umb_error_recovering_message');
			} else if($_FILES['resume']['size'] == 0) {
				$Return['error'] = $this->lang->line('umb_upload_your_resume');
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
			$pekerjaan = $this->Post_pekerjaan_model->read_informasi_pekerjaan($pekerjaan_id);
			if(!is_null($pekerjaan)){
				$employer_id = $pekerjaan[0]->employer_id;
			} else {
				$employer_id = 0;	
			}
			$data = array(
				'pekerjaan_id' => $pekerjaan_id,
				'user_id' => $employer_id,
				'full_name' => $this->input->post('full_name'),
				'email' => $this->input->post('email'),
				'message' => $message,
				'pekerjaan_resume' => $fname,
				'application_status' => 'Applied',
				'created_at' => date('Y-m-d h:i:s')
			);
			$result = $this->Post_pekerjaan_model->add_resume($data);
			if ($result == TRUE) {			
			//get setting info 
				$setting = $this->Umb_model->read_setting_info(1);
			/*if($setting[0]->enable_email_notification == 'yes') {
			
				$this->email->set_mailtype("html");
				//get perusahaan info
				$cinfo = $this->Umb_model->read_info_setting_perusahaan(1);
				//get email template
				$template = $this->Umb_model->read_email_template(11);
				
				$full_name = $this->input->post('full_name');
				// get job title
				$result = $this->Post_pekerjaan_model->read_informasi_pekerjaan($pekerjaan_id);
						
				$subject = $template[0]->subject.' - '.$cinfo[0]->nama_perusahaan;
				$logo = base_url().'uploads/logo/'.$cinfo[0]->logo;
							
				$message = '
			<div style="background:#f6f6f6;font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;margin:0;padding:0;padding: 20px;">
			<img src="'.$logo.'" title="'.$cinfo[0]->nama_perusahaan.'"><br>'.str_replace(array("{var site_name}","{var site_url}","{var nama_karyawan}","{var title_pekerjaan}"),array($cinfo[0]->nama_perusahaan,site_url(),$full_name,$result[0]->title_pekerjaan),htmlspecialchars_decode(stripslashes($template[0]->message))).'</div>';
				
				$this->email->from($this->input->post('email'), $full_name);
				$this->email->to($cinfo[0]->email);
				
				$this->email->subject($subject);
				$this->email->message($message);
				
				$this->email->send();
			}*/
			$Return['result'] = $this->lang->line('umb_resume_submitted_success');			
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
		exit;
	}
}
}
