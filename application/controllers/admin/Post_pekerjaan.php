<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Post_pekerjaan extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		
		$this->load->model("Post_pekerjaan_model");
		$this->load->model("Umb_model");
		$this->load->library('email');
		$this->load->helper('string');
		$this->load->model('Users_model');
		$this->load->model("Penunjukan_model");
		$this->load->model("Recruitment_model");
	}

	public function output($Return=array()){
		
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		
		exit(json_encode($Return));
	}
	
	public function index() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$system = $this->Umb_model->read_setting_info(1);
		if($system[0]->module_recruitment!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('left_post_pekerjaan').' | '.$this->Umb_model->site_title();
		
		$data['breadcrumbs'] = $this->lang->line('left_post_pekerjaan');
		$data['path_url'] = 'post_pekerjaan';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('49',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/post_pekerjaan/list_pekerjaan", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}
	
	public function employer() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('umb_employers_pekerjaans').' | '.$this->Umb_model->site_title();
		$data['all_negaraa'] = $this->Umb_model->get_negaraa();
		//$data['get_types_perusahaan'] = $this->Perusahaan_model->get_types_perusahaan();
		$data['breadcrumbs'] = $this->lang->line('umb_employers_pekerjaans');
		$data['path_url'] = 'employer_pekerjaans';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('5',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/post_pekerjaan/list_employer", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
		} else {
			redirect('admin/dashboard');
		}
	}

	public function read_employer() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		$user_id= $this->input->get('user_id');
		$result = $this->Users_model->read_users_info($user_id);
		$data = array(
			'user_id' => $result[0]->user_id,
			'first_name' => $result[0]->first_name,
			'last_name' => $result[0]->last_name,
			'nama_perusahaan' => $result[0]->nama_perusahaan,
			'email' => $result[0]->email,
			'password' => $result[0]->password,
			'jenis_kelamin' => $result[0]->jenis_kelamin,
			'is_active' => $result[0]->is_active,
			'profile_photo' => $result[0]->profile_photo,
			'profile_background' => $result[0]->profile_background,
			'nomor_kontak' => $result[0]->nomor_kontak
		);
		if(!empty($session)){ 
			$this->load->view('admin/post_pekerjaan/dialog_employer', $data);
		} else {
			redirect('admin/');
		}
	}

	public function list_employer() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/post_pekerjaan/list_employer", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$role_resources_ids = $this->Umb_model->user_role_resource();
		$user_info = $this->Umb_model->read_user_info($session['user_id']);
		$all_employers = $this->Recruitment_model->get_employers();
		$data = array();

		foreach($all_employers->result() as $r) {

			if(in_array('247',$role_resources_ids)) {
				$edit = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-user_id="'. $r->user_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('248',$role_resources_ids)) {
				$delete = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->user_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}
			$combhr = $edit.$delete;
			
			$app_row = $this->Post_pekerjaan_model->available_applications_employer($r->user_id);
			if($app_row > 0) {
				$app_available = '<a class="badge bg-purple btn-sm" href="'.site_url('admin/kandidats_pekerjaan/').'by_employer/'.$r->user_id.'" target="_blank"><i class="fa fa-list"></i> '.$this->lang->line('umb_view_applicants_pekerjaan').'</a>';
			} else {
				$app_available = '0';
			}
			$fname = $r->first_name.' '.$r->last_name;
			if($r->is_active == 1){
				$is_active = $fname.'<br><span class="badge badge-success">'.$this->lang->line('umb_karyawans_active').'</span>';
			} else {
				$is_active = $fname.'<br><span class="badge badge-danger">'.$this->lang->line('umb_karyawans_inactive').'</span>';
			}
			//$icname = $r->name.'<br><small class="text-muted"><i>'.$this->lang->line('umb_type').': '.$type_name.'<i></i></i></small><br><small class="text-muted"><i>'.$this->lang->line('dashboard_kontak').'#: '.$r->nomor_kontak.'<i></i></i></small><br><small class="text-muted"><i>'.$this->lang->line('umb_website').': '.$r->website_url.'<i></i></i></small>';
			$data[] = array(
				$combhr,
				$is_active,
				$r->nama_perusahaan,
				$r->email,
				$r->nomor_kontak,
				$app_available
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $all_employers->num_rows(),
			"recordsFiltered" => $all_employers->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function list_pekerjaan() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/post_pekerjaan/list_pekerjaan", $data, TRUE);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$role_resources_ids = $this->Umb_model->user_role_resource();
		$pekerjaans = $this->Post_pekerjaan_model->get_pekerjaans();
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

			if($r->status==1): $status = '<span class="badge bg-green">'.$this->lang->line('umb_published').'</span>'; else: $status = '<span class="badge bg-orange">'.$this->lang->line('umb_unpublished').'</span>'; endif;
			$employer = $this->Recruitment_model->read_info_employer($r->employer_id);
			if(!is_null($employer)){
				$nama_employer = $employer[0]->nama_perusahaan;
			} else {
				$nama_employer = '--';	
			}

			if(in_array('292',$role_resources_ids)) {
				$edit = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-pekerjaan_id="'. $r->pekerjaan_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('293',$role_resources_ids)) {
				$delete = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->pekerjaan_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}
			//if(in_array('293',$role_resources_ids)) { //view
			$view = '<a href="'.site_url().'pekerjaans/detail/'.$r->url_pekerjaan.'" target="_blank" data-toggle="tooltip" data-placement="top" title="" data-original-title="'.$this->lang->line('umb_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="fa fa-eye"></span></button></a>';
			//} else {
				//$view = '';
			//}
			$combhr = $edit.$view.$delete;
			$app_row = $this->Post_pekerjaan_model->available_applications_pekerjaan($r->pekerjaan_id);
			if($app_row > 0) {
				$app_available = '<br><a class="badge bg-purple btn-sm" href="'.site_url('admin/kandidats_pekerjaan/').'bedasarkan_pekerjaan/'.$r->pekerjaan_id.'" target="_blank"><i class="fa fa-list"></i> '.$this->lang->line('umb_title_applicants_pekerjaan').'</a>';
			} else {
				$app_available = '';
			}
			//	$ititle_pekerjaan = $r->title_pekerjaan.'<br><small class="text-muted"><i>'.$status.' '.$jtype.'<i></i></i></small><br><small class="text-muted"><i>'.$this->lang->line('umb_role_ditambahkan_date').': '.$created_at.'<i></i></i></small><br><small class="text-muted"><i>'.$this->lang->line('umb_hr_jb_positions').': '.$r->lowongan_pekerjaan.'<i></i></i></small>';
			$ititle_pekerjaan = $r->title_pekerjaan.'<br><small class="text-muted">'.$nama_kategori.'</small>'.$app_available;
			$data[] = array(
				$combhr,
				$ititle_pekerjaan,
				$nama_employer,
				$created_at,
				$status,
				$tanggal_penutupan
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


	public function add_employer() {

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
				$Return['result'] = $this->lang->line('umb_employer_pekerjaans_ditambahkan_success');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function update_employer() {

		if($this->input->post('edit_type')=='employer') {
			$session = $this->session->userdata('username');
			//$file = $_FILES['logo_perusahaan']['tmp_name'];
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = $this->input->post('_token');

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
			}

			else if($_FILES['logo_perusahaan']['size'] == 0) {

				$no_logo_data = array(
					'nama_perusahaan' => $this->input->post('nama_perusahaan'),
					'first_name' => $this->input->post('first_name'),
					'last_name' => $this->input->post('last_name'),
					'email' => $this->input->post('email'),
					'is_active' => $this->input->post('is_active'),
					'nomor_kontak' => $this->input->post('nomor_kontak'),
				);
				$Return['csrf_hash'] = $this->security->get_csrf_hash();
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
							'is_active' => $this->input->post('is_active'),
							'nomor_kontak' => $this->input->post('nomor_kontak'),
							'logo_perusahaan' => $fname,		
						);

						$Return['csrf_hash'] = $this->security->get_csrf_hash();
						$result = $this->Users_model->update_record($data,$id);
					} else {
						$Return['csrf_hash'] = $this->security->get_csrf_hash();
						$Return['error'] = $this->lang->line('umb_error_attatchment_type');
					}
				}
			}

			if($Return['error']!=''){
				$this->output($Return);
			}

			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_employer_pekerjaans_diperbarui_success');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$this->output($Return);
			exit;
		}
	}

	public function get_penunjukans() {

		$data['title'] = $this->Umb_model->site_title();
		$id = $this->uri->segment(4);

		$data = array(
			'perusahaan_id' => $id
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/post_pekerjaan/get_penunjukans", $data);
		} else {
			redirect('admin/');
		}

		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}

	public function read() {

		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('pekerjaan_id');
		$result = $this->Post_pekerjaan_model->read_informasi_pekerjaan($id);
		$data = array(
			'pekerjaan_id' => $result[0]->pekerjaan_id,
			'employer_id' => $result[0]->employer_id,
			'title_pekerjaan' => $result[0]->title_pekerjaan,
			'kategori_id' => $result[0]->kategori_id,
			'type_pekerjaan_id' => $result[0]->type_pekerjaan,
			'lowongan_pekerjaan' => $result[0]->lowongan_pekerjaan,
			'is_featured' => $result[0]->is_featured,
			'jenis_kelamin' => $result[0]->jenis_kelamin,
			'minimum_pengalaman' => $result[0]->minimum_pengalaman,
			'tanggal_penutupan' => $result[0]->tanggal_penutupan,
			'short_description' => $result[0]->short_description,
			'long_description' => $result[0]->long_description,
			'status' => $result[0]->status,
			'all_penunjukans' => $this->Penunjukan_model->all_penunjukans(),
			'all_types_pekerjaan' => $this->Post_pekerjaan_model->all_types_pekerjaan(),
			'all_perusahaans' => $this->Umb_model->get_perusahaans()
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/post_pekerjaan/dialog_post_pekerjaan', $data);
		} else {
			redirect('admin/');
		}
	}


	public function add_pekerjaan() {

		if($this->input->post('add_type')=='pekerjaan') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();

			$long_description = $_POST['long_description'];	
			$short_description = $_POST['short_description'];	
			$qt_short_description = htmlspecialchars(addslashes($short_description), ENT_QUOTES);
			$qt_description = htmlspecialchars(addslashes($long_description), ENT_QUOTES);

			if($this->input->post('perusahaan')==='') {
				$Return['error'] = $this->lang->line('umb_error_perusahaan');
			} else if($this->input->post('title_pekerjaan')==='') {
				$Return['error'] = $this->lang->line('umb_error_title_postpekerjaan');
			} else if($this->input->post('type_pekerjaan')==='') {
				$Return['error'] = $this->lang->line('umb_error_post_type_pekerjaan');
			} else if($this->input->post('penunjukan_id')==='') {
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
				'employer_id' => $this->input->post('user_id'),
				'type_pekerjaan' => $this->input->post('type_pekerjaan'),
				'kategori_id' => $this->input->post('kategori_id'),
				'url_pekerjaan' => $jurl,
				'short_description' => $qt_short_description,
				'long_description' => $qt_description,
				'status' => $this->input->post('status'),
				'is_featured' => $this->input->post('is_featured'),
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

	public function update() {

		if($this->input->post('edit_type')=='pekerjaan') {

			$id = $this->uri->segment(4);

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();

			$long_description = $_POST['long_description'];	
			$short_description = $_POST['short_description'];	
			$qt_short_description = htmlspecialchars(addslashes($short_description), ENT_QUOTES);
			$qt_description = htmlspecialchars(addslashes($long_description), ENT_QUOTES);

			if($this->input->post('perusahaan')==='') {
				$Return['error'] = $this->lang->line('umb_error_perusahaan');
			} else if($this->input->post('title_pekerjaan')==='') {
				$Return['error'] = $this->lang->line('umb_error_title_postpekerjaan');
			} else if($this->input->post('type_pekerjaan')==='') {
				$Return['error'] = $this->lang->line('umb_error_post_type_pekerjaan');
			} else if($this->input->post('penunjukan_id')==='') {
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
				'employer_id' => $this->input->post('user_id'),
				'type_pekerjaan' => $this->input->post('type_pekerjaan'),
				'kategori_id' => $this->input->post('kategori_id'),
				'short_description' => $qt_short_description,
				'long_description' => $qt_description,
				'status' => $this->input->post('status'),
				'is_featured' => $this->input->post('is_featured'),
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


	public function delete() {

		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$result = $this->Post_pekerjaan_model->delete_record($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('umb_sukses_pekerjaan_dihapus');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
	}

	public function delete_employer() {

		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$result = $this->Post_pekerjaan_model->delete_record_employer($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('umb_employer_pekerjaans_dihapus_success');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
	}

	public function pages() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('umb_cms_pages_pekerjaans').' | '.$this->Umb_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('umb_cms_pages_pekerjaans');
		$data['path_url'] = 'cms_pages_pekerjaans';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('63',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/post_pekerjaan/list_pages", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}		  
	} 

	public function list_pages() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/post_pekerjaan/list_pages", $data);
		} else {
			redirect('admin/');
		}

		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		$pages = $this->Post_pekerjaan_model->get_cms_pages();

		$data = array();

		foreach($pages->result() as $r) {

			$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-page_id="'. $r->page_id . '"><span class="fas fa-pencil-alt"></span></button></span>',
				$r->page_title,
				$r->page_url
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $pages->num_rows(),
			"recordsFiltered" => $pages->num_rows(),
			"data" => $data
		);

		echo json_encode($output);
		exit();
	} 

	public function read_pages() {

		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('page_id');
		$result = $this->Post_pekerjaan_model->read_cms_pages($id);
		$data = array(
			'page_id' => $result[0]->page_id,
			'page_title' => $result[0]->page_title,
			'page_url' => $result[0]->page_url,
			'page_details' => $result[0]->page_details,
			'created_at' => $result[0]->created_at,
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/post_pekerjaan/dialog_pages', $data);
		} else {
			redirect('admin/');
		}
	} 

	public function update_pages() {

		if($this->input->post('edit_type')=='update_page') {

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();

			if($this->input->post('page_details')==='') {
				$Return['error'] = $this->lang->line('umb_field_page_content_pekerjaans_error');
			}

			if($Return['error']!=''){
				$this->output($Return);
			}

			$page_details = $this->input->post('page_details');
			$new_page_details = htmlspecialchars(addslashes($page_details), ENT_QUOTES);

			$data = array(
				'page_details' => $new_page_details
			);

			$result = $this->Post_pekerjaan_model->update_record_page($data,$id);		

			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_page_pekerjaans_diperbarui_sukses');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
}
