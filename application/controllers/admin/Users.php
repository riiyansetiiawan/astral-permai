<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		
		$this->load->model("Users_model");
		$this->load->model("Umb_model");
		$this->load->model("Penunjukan_model");
		$this->load->model("Department_model");
		$this->load->model("Roles_model");		
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
		$data['title'] = $this->lang->line('umb_users');
		$data['all_negaraa'] = $this->Umb_model->get_negaraa();
		$data['all_user_roles'] = $this->Roles_model->all_user_roles();
		$data['breadcrumbs'] = $this->lang->line('umb_users');
		$data['path_url'] = 'users';
		$data['subview'] = $this->load->view("admin/users/list_users", $data, TRUE);
		$this->load->view('admin/layout/layout_main', $data); 
	}

	public function list_users() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/users/list_users", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$users = $this->Users_model->get_users();
		$data = array();
		foreach($users->result() as $r) {
			$negara = $this->Umb_model->read_info_negara($r->negara);
			if(!is_null($negara)){
				$c_name = $negara[0]->nama_negara;
			} else {
				$c_name = '--';	
			}
			$full_name = $r->first_name . ' ' .$r->first_name;
			if($r->user_id!=1):
				$opt = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn btn-outline-danger btn-sm m-b-0-0 waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->user_id . '"><i class="fas fa-trash-restore-o"></i></button></span>';
			else:
				$opt = '';	
			endif;
			$data[] = array(
				'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-user_id="'. $r->user_id . '"><i class="fas fa-pencil-alt-square-o"></i></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_view').'"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-user_id="'. $r->user_id . '"><i class="fa fa-eye"></i></button></span>'.$opt.'',
				$full_name,
				$r->email,
				$r->username,
				$r->password,
				$c_name
			);
		}
		$output = array(
			"draw" => $draw,
			"recordsTotal" => $users->num_rows(),
			"recordsFiltered" => $users->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function profile() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$result = $this->Users_model->read_users_info($session['user_id']);
		$data = array(
			'path_url' => 'user_profile',
			'title' => $this->lang->line('umb_user_profile'),
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
			'all_negaraa' => $this->Umb_model->get_negaraa(),
			'all_user_roles' => $this->Roles_model->all_user_roles()
		);
		$data['subview'] = $this->load->view("admin/users/user_profile", $data, TRUE);
		$this->load->view('admin/layout/layout_main', $data); 
	}

	public function profile_background() {

		if($this->input->post('type')=='profile_background') {
			$Return = array('result'=>'', 'error'=>'');
			$session = $this->session->userdata('username');
			$id = $session['user_id'];
			if($_FILES['p_file']['size'] == 0) {
				$Return['error'] = $this->lang->line('umb_error_select_profile_cover');
			} else {
				if(is_uploaded_file($_FILES['p_file']['tmp_name'])) {
					$allowed =  array('png','jpg','jpeg','pdf','gif');
					$filename = $_FILES['p_file']['name'];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);
					if(in_array($ext,$allowed)){
						$tmp_name = $_FILES["p_file"]["tmp_name"];
						$profile = "uploads/users/background/";
						$set_img = base_url()."uploads/users/background/";
						$name = basename($_FILES["p_file"]["name"]);
						$newfilename = 'profile_background_'.round(microtime(true)).'.'.$ext;
						move_uploaded_file($tmp_name, $profile.$newfilename);
						$fname = $newfilename;			
						$data = array(
							'profile_background' => $fname
						);
						$result = $this->Users_model->update_record($data,$id);	
						if ($result == TRUE) {
							$Return['profile_background'] = $set_img.$fname;
							$Return['result'] = $this->lang->line('umb_sukses_profile_background_diperbarui');
						} else {
							$Return['error'] = $this->lang->line('umb_error_msg');
						}
						$this->output($Return);
						exit;	
					} else {
						$Return['error'] = $this->lang->line('umb_error_attatchment_type');
					}
				}
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
		}
	}

	public function read() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('user_id');
		// $data['all_negaraa'] = $this->Umb_model->get_negaraa();
		$result = $this->Users_model->read_users_info($id);
		$data = array(
			'user_id' => $result[0]->user_id,
			'first_name' => $result[0]->first_name,
			'last_name' => $result[0]->last_name,
			'email' => $result[0]->email,
			'username' => $result[0]->username,
			'password' => $result[0]->password,
			'jenis_kelamin' => $result[0]->jenis_kelamin,
			'profile_photo' => $result[0]->profile_photo,
			'nomor_kontak' => $result[0]->nomor_kontak,
			'alamat_1' => $result[0]->alamat_1,
			'alamat_2' => $result[0]->alamat_2,
			'kota' => $result[0]->kota,
			'provinsi' => $result[0]->provinsi,
			'kode_pos' => $result[0]->kode_pos,
			'inegara' => $result[0]->negara,
			'all_negaraa' => $this->Umb_model->get_negaraa(),
			'all_user_roles' => $this->Roles_model->all_user_roles()
		);
		$this->load->view('admin/users/dialog_users', $data);
	}
	
	public function add_user() {

		if($this->input->post('add_type')=='user') {
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
			} else if($this->input->post('username')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_username');
			} else if($this->input->post('password')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_password');
			} else if($this->input->post('kota')==='') {
				$Return['error'] = $this->lang->line('umb_error_fiel_kota');
			} else if($this->input->post('negara')==='') {
				$Return['error'] = $this->lang->line('umb_error_field_negara');
			}		
			else if($_FILES['photo']['size'] == 0) {
				$fname = 'no file';
				$Return['error'] = $this->lang->line('umb_user_photo_field');
			} else {
				if(is_uploaded_file($_FILES['photo']['tmp_name'])) {
					$allowed =  array('png','jpg','jpeg','gif');
					$filename = $_FILES['photo']['name'];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);
					if(in_array($ext,$allowed)){
						$tmp_name = $_FILES["photo"]["tmp_name"];
						$user_photo = "uploads/users/";
						$lname = basename($_FILES["photo"]["name"]);
						$newfilename = 'user_'.round(microtime(true)).'.'.$ext;
						move_uploaded_file($tmp_name, $user_photo.$newfilename);
						$fname = $newfilename;
					} else {
						$Return['error'] = $this->lang->line('umb_error_attatchment_type');
					}
				}
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$data = array(
				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'email' => $this->input->post('email'),
				'username' => $this->input->post('username'),
				'password' => $this->input->post('password'),
				'jenis_kelamin' => $this->input->post('jenis_kelamin'),
				'nomor_kontak' => $this->input->post('nomor_kontak'),
				'alamat_1' => $this->input->post('alamat_1'),
				'alamat_2' => $this->input->post('alamat_2'),
				'kota' => $this->input->post('kota'),
				'provinsi' => $this->input->post('provinsi'),
				'kode_pos' => $this->input->post('kode_pos'),
				'negara' => $this->input->post('negara'),
				'profile_photo' => $fname,
				'created_at' => date('d-m-Y h:i:s')
			);
			$result = $this->Users_model->add($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_user_ditambahkan');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function update() {

		if($this->input->post('edit_type')=='user') {
			$id = $this->uri->segment(4);
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
			} else if($this->input->post('username')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_username');
			} else if($this->input->post('password')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_password');
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
					'username' => $this->input->post('username'),
					'password' => $this->input->post('password'),
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
							'username' => $this->input->post('username'),
							'password' => $this->input->post('password'),
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
				$Return['result'] = $this->lang->line('umb_sukses_user_diperbarui');
			} else {
				$Return['error'] = $Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function delete() {
		
		if($this->input->post('is_ajax')==2) {
			$session = $this->session->userdata('username');
			if(empty($session)){ 
				redirect('admin/');
			}
			$Return = array('result'=>'', 'error'=>'');
			$id = $this->uri->segment(4);
			$result = $this->Users_model->delete_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_sukses_hapus_perusahaan');
			} else {
				$Return['error'] = $Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}
}
