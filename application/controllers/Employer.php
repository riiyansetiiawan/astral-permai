<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Employer extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		
		$this->load->model("Post_pekerjaan_model");
		$this->load->model("Umb_model");
		$this->load->model("Login_model");
		$this->load->model("Users_model");
		$this->load->model("Karyawans_model");
		$this->load->model("Penunjukan_model");
		$this->load->model("Department_model");
		$this->load->model("Recruitment_model");
		$this->load->helper('string');
		$this->load->library('email');
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

	public function signup() {
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
		redirect('employer/sign_in/', 'refresh');
	}

	public function forgot_password() {
		$system = $this->Umb_model->read_setting_info(1);
		if($system[0]->module_recruitment!='true'){
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('umb_link_forgot_password');
		$data['path_url'] = 'forgot_password_pekerjaan';
		$data['subview'] = $this->load->view("frontend/hrastral/forgot_password", $data, TRUE);
		$this->load->view('frontend/hrastral/layout_pekerjaan/layout_pekerjaan', $data); 
	}

	public function change_password() {
		$system = $this->Umb_model->read_setting_info(1);
		if($system[0]->module_recruitment!='true'){
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('header_change_password');
		$data['path_url'] = 'user_password_pekerjaan';
		$session = $this->session->userdata('c_user_id');
		if(empty($session)){
			redirect('employer/sign_in/');
		}
		$data['subview'] = $this->load->view("frontend/hrastral/change_password", $data, TRUE);
		$this->load->view('frontend/hrastral/layout_pekerjaan/layout_pekerjaan', $data); 
	}
	
	public function post_pekerjaan() {
		$system = $this->Umb_model->read_setting_info(1);
		if($system[0]->module_recruitment!='true'){
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('umb_add_new').' '.$this->lang->line('umb_pekerjaan');
		$data['path_url'] = 'create_pekerjaan';
		$session = $this->session->userdata('c_user_id');
		if(empty($session)){
			redirect('employer/sign_in/');
		}
		$data['all_types_pekerjaan'] = $this->Umb_model->get_type_pekerjaan();
		$data['all_kategoris_pekerjaan'] = $this->Recruitment_model->all_kategoris_pekerjaan();
		$data['subview'] = $this->load->view("frontend/hrastral/post_pekerjaan", $data, TRUE);
		$this->load->view('frontend/hrastral/layout_pekerjaan/layout_pekerjaan', $data); 
	}

	public function dashboard() {

		$system = $this->Umb_model->read_setting_info(1);
		if($system[0]->module_recruitment!='true'){
			redirect('admin/');
		}
		$session = $this->session->userdata('c_user_id');
		if(empty($session)){
			redirect('employer/sign_in/');
		}
		$data['title'] = 'Dashboard';
		$data['path_url'] = 'home_pekerjaan';
		$data['subview'] = $this->load->view("frontend/hrastral/dashboard", $data, TRUE);
		$this->load->view('frontend/hrastral/layout_pekerjaan/layout_pekerjaan', $data); 
	}

	public function login() {
		
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
	
	public function create_account() {
		
		if($this->input->post('add_type')=='employer') {

			$this->form_validation->set_rules('first_name', 'First Name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
			//$file = $_FILES['photo']['tmp_name'];
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$valid_email = $this->Users_model->check_user_email($this->input->post('email'));
			$options = array('cost' => 12);
			$password_hash = password_hash($this->input->post('password'), PASSWORD_BCRYPT, $options);
			
			if($this->input->post('nama_perusahaan')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_nama_perusahaan');
			} else if($this->input->post('first_name')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_first_name');
			} else if( $this->input->post('last_name')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_last_name');
			} else if($this->input->post('email')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_email');
			} else if (!filter_var($this->input->post('email'), FILTER_VALIDATE_EMAIL)) {
				$Return['error'] = $this->lang->line('umb_karyawan_error_invalid_email');
			} else if($valid_email->num_rows() > 0) {
				$Return['error'] = $this->lang->line('umb_rec_email_exists');
			} else if($this->input->post('password')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_password');
			} else if($this->input->post('nomor_kontak')==='') {
				$Return['error'] = $this->lang->line('umb_error_field_kontak');
			} else if($_FILES['logo_perusahaan']['size'] == 0) {
				$Return['error'] = $this->lang->line('umb_rec_error_logo_perusahaan_field');
			} else {
				if(is_uploaded_file($_FILES['logo_perusahaan']['tmp_name'])) {
					$allowed =  array('png','jpg','jpeg','gif');
					$filename = $_FILES['logo_perusahaan']['name'];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);
					if(in_array($ext,$allowed)){
						$tmp_name = $_FILES["logo_perusahaan"]["tmp_name"];
						$bill_copy = "uploads/employers/";
						$lname = basename($_FILES["logo_perusahaan"]["name"]);
						$newfilename = 'employer_'.round(microtime(true)).'.'.$ext;
						move_uploaded_file($tmp_name, $bill_copy.$newfilename);
						$fname = $newfilename;
						$data = array(
							'nama_perusahaan' => $this->input->post('nama_perusahaan'),
							'first_name' => $this->input->post('first_name'),
							'last_name' => $this->input->post('last_name'),
							'email' => $this->input->post('email'),
							'password' => $password_hash,
							'nomor_kontak' => $this->input->post('nomor_kontak'),
							'is_active' => 0,
							'user_type' => 1,
							'logo_perusahaan' => $fname,		
							'created_at' => date('d-m-Y h:i:s')
						);
						$result = $this->Users_model->add($data);
					} else {
						$Return['error'] = $this->lang->line('umb_error_attatchment_type');
					}
				}
			}
			if($Return['error']!=''){
				$this->output($Return);
			}	
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_hr_sukses_register_user');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function edit_pekerjaan() {

		$id = $this->uri->segment(3);
		$session = $this->session->userdata('c_user_id');
		if(empty($session)){
			redirect('employer/sign_in/');
		}
		$result = $this->Post_pekerjaan_model->read_info_pekerjaan_melalui_url($id);
		if(is_null($result)){
			redirect('employer/manage_pekerjaans/');
		}
		$data = array(
			'path_url' => 'edit_pekerjaan',
			'title' => $this->lang->line('umb_edit_pekerjaan'),
			'pekerjaan_id' => $result[0]->pekerjaan_id,
			'employer_id' => $result[0]->employer_id,
			'title_pekerjaan' => $result[0]->title_pekerjaan,
			'kategori_id' => $result[0]->kategori_id,
			'type_pekerjaan_id' => $result[0]->type_pekerjaan,
			'lowongan_pekerjaan' => $result[0]->lowongan_pekerjaan,
			'jenis_kelamin' => $result[0]->jenis_kelamin,
			'minimum_pengalaman' => $result[0]->minimum_pengalaman,
			'tanggal_penutupan' => $result[0]->tanggal_penutupan,
			'short_description' => $result[0]->short_description,
			'long_description' => $result[0]->long_description,
			'all_types_pekerjaan' => $this->Umb_model->get_type_pekerjaan(),
			'all_kategoris_pekerjaan' => $this->Recruitment_model->all_kategoris_pekerjaan()
		);
		
		$data['subview'] = $this->load->view("frontend/hrastral/edit_pekerjaan", $data, TRUE);
		$this->load->view('frontend/hrastral/layout_pekerjaan/layout_pekerjaan', $data); 
	}
	
	public function manage_pekerjaans() {
		
		$system = $this->Umb_model->read_setting_info(1);
		if($system[0]->module_recruitment!='true'){
			redirect('admin/');
		}
		$data['title'] = 'Manage Pekerjaan';
		$data['path_url'] = 'manage_pekerjaans';
		$session = $this->session->userdata('c_user_id');
		if(empty($session)){
			redirect('employer/sign_in/');
		}
		$data['all_kategoris_pekerjaan'] = $this->Recruitment_model->all_kategoris_pekerjaan();
		$data['subview'] = $this->load->view("frontend/hrastral/manage_pekerjaans", $data, TRUE);
		$this->load->view('frontend/hrastral/layout_pekerjaan/layout_pekerjaan', $data); 
	}
	
	public function manage_applications() {

		$system = $this->Umb_model->read_setting_info(1);
		if($system[0]->module_recruitment!='true'){
			redirect('admin/');
		}
		$data['title'] = 'Manage Applications';
		$data['path_url'] = 'applications_pekerjaans';
		$session = $this->session->userdata('c_user_id');
		if(empty($session)){
			redirect('employer/sign_in/');
		}
		$data['all_kategoris_pekerjaan'] = $this->Recruitment_model->all_kategoris_pekerjaan();
		$data['subview'] = $this->load->view("frontend/hrastral/manage_applications", $data, TRUE);
		$this->load->view('frontend/hrastral/layout_pekerjaan/layout_pekerjaan', $data); 
	}
	
	public function list_applications_pekerjaans() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('c_user_id');
		if(!empty($session)){ 
			$this->load->view("frontend/hrastral/manage_applications", $data);
		} else {
			redirect('');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$kandidats = $this->Post_pekerjaan_model->get_karyawan_applied_pekerjaans($session['c_user_id']);		
		$data = array();
		foreach($kandidats->result() as $r) {
			$pekerjaan = $this->Post_pekerjaan_model->read_informasi_pekerjaan($r->pekerjaan_id);
			if(!is_null($pekerjaan)){
				$title_pekerjaan = $pekerjaan[0]->title_pekerjaan;
			} else {
				$title_pekerjaan = '--';	
			}
			$created_at = $this->Umb_model->set_date_format($r->created_at);
			$data[] = array(
				'',
				$title_pekerjaan,
				'',
				'',
				'',
				$created_at
			);
		}
		$output = array(
			"draw" => $draw,
			"recordsTotal" => $kandidats->num_rows(),
			"recordsFiltered" => $kandidats->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}
	
	public function list_employer_pekerjaan() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('c_user_id');
		if(!empty($session)){ 
			$this->load->view("frontend/hrastral/manage_pekerjaans", $data);
		} else {
			redirect('');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$pekerjaans = $this->Post_pekerjaan_model->get_employer_pekerjaans($session['c_user_id']);
		$data = array();
		foreach($pekerjaans->result() as $r) {
			$kategori = $this->Post_pekerjaan_model->read_info_kategori_pekerjaan($r->kategori_id);
			if(!is_null($kategori)){
				$nama_kategori = $kategori[0]->nama_kategori;
			} else {
				$nama_kategori = '--';
			}
			$type_pekerjaan = $this->Post_pekerjaan_model->read_informasi_type_pekerjaan($r->type_pekerjaan);
			if(!is_null($type_pekerjaan)){
				$jtype = $type_pekerjaan[0]->type;
			} else {
				$jtype = '--';
			}
			$tanggal_penutupan = $this->Umb_model->set_date_format($r->tanggal_penutupan);
			$created_at = $this->Umb_model->set_date_format($r->created_at);
			if($r->status==1): $status = $this->lang->line('umb_published'); elseif($r->status==2): $status = $this->lang->line('umb_unpublished'); endif;
			$employer = $this->Recruitment_model->read_info_employer($r->employer_id);
			if(!is_null($employer)){
				$nama_employer = $employer[0]->nama_perusahaan;
			} else {
				$nama_employer = '--';	
			}
			$data[] = array(
				'<span title="'.$this->lang->line('umb_edit').'"><button data-record-id="'. $r->url_pekerjaan . '" type="button" class="btn btn-default btn-sm m-b-0-0 waves-effect waves-light edit-pekerjaan"><i class="fa fa-pencil-square-o"></i></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_view').'"><button data-record-id="'. $r->url_pekerjaan . '" type="button" class="btn btn-default btn-sm m-b-0-0 waves-effect waves-light view-pekerjaan"><i class="fa fa-eye"></i></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn btn-danger btn-sm m-b-0-0 waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->pekerjaan_id . '"><i class="fa fa-trash-o"></i></button></span>',
				$r->title_pekerjaan,
				$nama_kategori,
				$jtype,
				$r->lowongan_pekerjaan,
				$tanggal_penutupan,
				$status,
				$created_at
			);
		}
		$output = array(
			"draw" => $draw,
			"recordsTotal" => $pekerjaans->num_rows(),
			"recordsFiltered" => $pekerjaans->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}
	
	public function add_pekerjaan() {
		
		if($this->input->post('add_type')=='pekerjaan') {		
			$Return = array('result'=>'', 'error'=>'');
			$session = $this->session->userdata('c_user_id');
			$long_description = $_POST['long_description'];	
			$short_description = $_POST['short_description'];	
			$qt_short_description = htmlspecialchars(addslashes($short_description), ENT_QUOTES);
			$qt_description = htmlspecialchars(addslashes($long_description), ENT_QUOTES);
			if($this->input->post('title_pekerjaan')==='') {
				$Return['error'] = $this->lang->line('umb_error_title_postpekerjaan');
			} else if($this->input->post('type_pekerjaan')==='') {
				$Return['error'] = $this->lang->line('umb_error_post_type_pekerjaan');
			} else if($this->input->post('kategori_id')==='') {
				$Return['error'] = $this->lang->line('umb_error_postpekerjaan_penunjukan');
			} else if($this->input->post('vacancy')==='') {
				$Return['error'] = $this->lang->line('umb_error_postpekerjaan_positions');
			} else if($this->input->post('tanggal_penutupan')==='') {
				$Return['error'] = $this->lang->line('umb_error_postpekerjaan_tanggal_penutupan');
			} else if($qt_short_description==='') {
				$Return['error'] = $this->lang->line('umb_error_postpekerjaan_short_description');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$jurl = random_string('alnum', 40);
			$data = array(
				'title_pekerjaan' => $this->input->post('title_pekerjaan'),
				'employer_id' => $session['c_user_id'],
				'type_pekerjaan' => $this->input->post('type_pekerjaan'),
				'url_pekerjaan' => $jurl,
				'kategori_id' => $this->input->post('kategori_id'),
				'long_description' => $qt_description,
				'short_description' => $qt_short_description,
				'long_description' => $qt_description,
				'status' => 2,
				'lowongan_pekerjaan' => $this->input->post('vacancy'),
				'tanggal_penutupan' => $this->input->post('tanggal_penutupan'),
				'jenis_kelamin' => $this->input->post('jenis_kelamin'),
				'minimum_pengalaman' => $this->input->post('pengalaman'),
				'created_at' => date('Y-m-d h:i:s'),
			);
			$result = $this->Post_pekerjaan_model->add($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_pekerjaan_ditambahkan');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function update_pekerjaan() {
		
		if($this->input->post('edit_type')=='pekerjaan') {		
			
			$Return = array('result'=>'', 'error'=>'');
			$session = $this->session->userdata('c_user_id');
			$long_description = $_POST['long_description'];	
			$short_description = $_POST['short_description'];	
			$qt_short_description = htmlspecialchars(addslashes($short_description), ENT_QUOTES);
			$qt_description = htmlspecialchars(addslashes($long_description), ENT_QUOTES);
			$id = $this->input->post('jbid');
			if($this->input->post('title_pekerjaan')==='') {
				$Return['error'] = $this->lang->line('umb_error_title_postpekerjaan');
			} else if($this->input->post('type_pekerjaan')==='') {
				$Return['error'] = $this->lang->line('umb_error_post_type_pekerjaan');
			} else if($this->input->post('kategori_id')==='') {
				$Return['error'] = $this->lang->line('umb_error_postpekerjaan_penunjukan');
			} else if($this->input->post('vacancy')==='') {
				$Return['error'] = $this->lang->line('umb_error_postpekerjaan_positions');
			} else if($this->input->post('tanggal_penutupan')==='') {
				$Return['error'] = $this->lang->line('umb_error_postpekerjaan_tanggal_penutupan');
			} else if($qt_short_description==='') {
				$Return['error'] = $this->lang->line('umb_error_postpekerjaan_short_description');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$data = array(
				'title_pekerjaan' => $this->input->post('title_pekerjaan'),
				'type_pekerjaan' => $this->input->post('type_pekerjaan'),
				'kategori_id' => $this->input->post('kategori_id'),
				'short_description' => $qt_short_description,
				'long_description' => $qt_description,
				'lowongan_pekerjaan' => $this->input->post('vacancy'),
				'tanggal_penutupan' => $this->input->post('tanggal_penutupan'),
				'jenis_kelamin' => $this->input->post('jenis_kelamin'),
				'minimum_pengalaman' => $this->input->post('pengalaman')
			);
			$result = $this->Post_pekerjaan_model->update_record($data,$id);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_pekerjaan_diperbarui');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function account() {
		
		$session = $this->session->userdata('c_user_id');
		if(empty($session)){
			redirect('employer/sign_in/');
		}
		$result = $this->Users_model->read_users_info($session['c_user_id']);
		$data = array(
			'path_url' => 'user_account_pekerjaan',
			'title' => $this->lang->line('umb_rec_my_account'),
			'user_id' => $result[0]->user_id,
			'nama_perusahaan' => $result[0]->nama_perusahaan,
			'first_name' => $result[0]->first_name,
			'last_name' => $result[0]->last_name,
			'email' => $result[0]->email,
			'username' => $result[0]->username,
			'password' => $result[0]->password,
			'jenis_kelamin' => $result[0]->jenis_kelamin,
			'logo_perusahaan' => $result[0]->logo_perusahaan,
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
		$data['subview'] = $this->load->view("frontend/hrastral/employer_account", $data, TRUE);
		$this->load->view('frontend/hrastral/layout_pekerjaan/layout_pekerjaan', $data); 
	}
	
	public function update_account() {
		
		if($this->input->post('edit_type')=='user') {
			
			$session = $this->session->userdata('c_user_id');
			$id = $session['c_user_id'];
			$this->form_validation->set_rules('first_name', 'First Name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
			$file = $_FILES['logo_perusahaan']['tmp_name'];
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			if($this->input->post('nama_perusahaan')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_nama_perusahaan');
			} else if($this->input->post('first_name')==='') {
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
			else if($_FILES['logo_perusahaan']['size'] == 0) {
				$fname = 'no file';
				$no_logo_data = array(
					'nama_perusahaan' => $this->input->post('nama_perusahaan'),
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
				if(is_uploaded_file($_FILES['logo_perusahaan']['tmp_name'])) {
					
					$allowed =  array('png','jpg','jpeg','gif');
					$filename = $_FILES['logo_perusahaan']['name'];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);
					
					if(in_array($ext,$allowed)){
						$tmp_name = $_FILES["logo_perusahaan"]["tmp_name"];
						$bill_copy = "uploads/employers/";
						
						$lname = basename($_FILES["logo_perusahaan"]["name"]);
						$newfilename = 'employer_'.round(microtime(true)).'.'.$ext;
						move_uploaded_file($tmp_name, $bill_copy.$newfilename);
						$fname = $newfilename;
						$data = array(
							'nama_perusahaan' => $this->input->post('nama_perusahaan'),
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
							'logo_perusahaan' => $fname,		
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
				$Return['result'] = $this->lang->line('umb_profile_client_update');
			} else {
				$Return['error'] = $Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}	 
	
	public function add_employer() {
		
		if($this->input->post('add_type')=='employer') {

			$this->form_validation->set_rules('first_name', 'First Name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
			//$file = $_FILES['photo']['tmp_name'];
			$Return = array('result'=>'', 'error'=>'');
			$valid_email = $this->Users_model->check_user_email($this->input->post('email'));
			if($this->input->post('nama_perusahaan')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_nama_perusahaan');
			} else if($this->input->post('first_name')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_first_name');
			} else if( $this->input->post('last_name')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_last_name');
			} else if($this->input->post('email')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_email');
			} else if (!filter_var($this->input->post('email'), FILTER_VALIDATE_EMAIL)) {
				$Return['error'] = $this->lang->line('umb_karyawan_error_invalid_email');
			} else if($valid_email->num_rows() > 0) {
				$Return['error'] = $this->lang->line('umb_rec_email_exists');
			} else if($this->input->post('password')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_password');
			} else if($this->input->post('nomor_kontak')==='') {
				$Return['error'] = $this->lang->line('umb_error_field_kontak');
			} else if($_FILES['logo_perusahaan']['size'] == 0) {
				$Return['error'] = $this->lang->line('umb_rec_error_logo_perusahaan_field');
			} else {
				if(is_uploaded_file($_FILES['logo_perusahaan']['tmp_name'])) {
					$allowed =  array('png','jpg','jpeg','gif');
					$filename = $_FILES['logo_perusahaan']['name'];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);
					if(in_array($ext,$allowed)){
						$tmp_name = $_FILES["logo_perusahaan"]["tmp_name"];
						$bill_copy = "uploads/employers/";
						$lname = basename($_FILES["logo_perusahaan"]["name"]);
						$newfilename = 'employer_'.round(microtime(true)).'.'.$ext;
						move_uploaded_file($tmp_name, $bill_copy.$newfilename);
						$fname = $newfilename;
						$data = array(
							'nama_perusahaan' => $this->input->post('nama_perusahaan'),
							'first_name' => $this->input->post('first_name'),
							'last_name' => $this->input->post('last_name'),
							'email' => $this->input->post('email'),
							'password' => $this->input->post('password'),
							'nomor_kontak' => $this->input->post('nomor_kontak'),
							'is_active' => 1,
							'user_type' => 1,
							'logo_perusahaan' => $fname,		
							'created_at' => date('d-m-Y h:i:s')
						);

						$result = $this->Users_model->add($data);
					} else {
						$Return['error'] = $this->lang->line('umb_error_attatchment_type');
					}
				}
			}
			if($Return['error']!=''){
				$this->output($Return);
			}	
			
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_hr_sukses_register_user');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function update() {
		
		if($this->input->post('edit_type')=='user') {
			
			$session = $this->session->userdata('c_user_id');
			$id = $session['c_user_id'];
			$this->form_validation->set_rules('first_name', 'First Name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
			$file = $_FILES['photo']['tmp_name'];
			$Return = array('result'=>'', 'error'=>'');
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
	
	public function delete_pekerjaan() {
		
		$Return = array('result'=>'', 'error'=>'');
		if($this->input->post('type')=='delete_record') {
			$id = $this->uri->segment(3);
			$result = $this->Post_pekerjaan_model->delete_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_sukses_pekerjaan_dihapus');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}
	
	public function update_password() {
		
		if($this->input->post('type')=='change_password') {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$session = $this->session->userdata('c_user_id');
			$id = $session['c_user_id'];
			if(trim($this->input->post('new_password'))==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_newpassword');
			} else if(strlen($this->input->post('new_password')) < 6) {
				$Return['error'] = $this->lang->line('umb_karyawan_error_password_least');
			} else if(trim($this->input->post('new_password_confirm'))==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_new_cpassword');
			} else if($this->input->post('new_password')!=$this->input->post('new_password_confirm')) {
				$Return['error'] = $this->lang->line('umb_karyawan_error_old_new_cpassword');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$data = array(
				'password' => $this->input->post('new_password')
			);
			$result = $this->Users_model->update_record($data,$id);
			if ($result == TRUE) {
				$Return['result'] = 'Password has been updated.';
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}	
	
	public function send_mail() {
		
		if($this->input->post('type')=='fpassword') {
			
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
				$query = $this->Umb_model->read_user_pekerjaans_melalui_email($this->input->post('iemail'));
				$user = $query->num_rows();
				if($user > 0) {
					$user_info = $query->result();
					$full_name = $user_info[0]->first_name.' '.$user_info[0]->last_name;
					$subject = $template[0]->subject.' - '.$cinfo[0]->nama_perusahaan;
					$logo = base_url().'uploads/logo/'.$cinfo[0]->logo;
					//$cid = $this->email->attachment_cid($logo);
					$message = '<div style="background:#f6f6f6;font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;margin:0;padding:0;padding: 20px;">
					<img src="'.$logo.'" title="'.$cinfo[0]->nama_perusahaan.'"><br>'.str_replace(array("{var site_name}","{var email}","{var password}"),array($cinfo[0]->nama_perusahaan,$user_info[0]->email,$user_info[0]->password),htmlspecialchars_decode(stripslashes($template[0]->message))).'</div>';
					
					$this->email->from($cinfo[0]->email, $cinfo[0]->nama_perusahaan);
					$this->email->to($this->input->post('iemail'));
					$this->email->subject($subject);
					$this->email->message($message);
					$this->email->send();
					$Return['result'] = $this->lang->line('umb_sukses_sent_forgot_password');
					$this->session->set_flashdata('sent_message', $this->lang->line('umb_sukses_sent_forgot_password'));
				} else {
					$Return['error'] = $this->lang->line('umb_error_email_addres_not_exist');
				}
				$this->output($Return);
				exit;
			}
		}
	}
}
