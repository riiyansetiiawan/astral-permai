<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		
		$this->load->model("Karyawans_model");
		$this->load->model("Umb_model");
		$this->load->model("Department_model");
		$this->load->model("Penunjukan_model");
		$this->load->model("Roles_model");
		$this->load->model("Location_model");
		$this->load->model("Clients_model");
	}
	
	public function output($Return=array()){
		
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		exit(json_encode($Return));
	}
	
	public function index() {

		$session = $this->session->userdata('client_username');
		if(empty($session)){ 
			redirect('client/auth/');
		}
		$result = $this->Clients_model->read_info_client($session['client_id']);
		$data = array(
			'name' => $result[0]->name,
			'client_id' => $result[0]->client_id,
			'client_username' => $result[0]->client_username,
			'email' => $result[0]->email,
			'nama_perusahaan' => $result[0]->nama_perusahaan,
			'jenis_kelamin' => $result[0]->jenis_kelamin,
			'website_url' => $result[0]->website_url,
			'nomor_kontak' => $result[0]->nomor_kontak,
			'alamat_1' => $result[0]->alamat_1,
			'alamat_2' => $result[0]->alamat_2,
			'kota' => $result[0]->kota,
			'provinsi' => $result[0]->provinsi,
			'kode_pos' => $result[0]->kode_pos,
			'negaraid' => $result[0]->negara,
			'is_active' => $result[0]->is_active,
			'title' => $this->Umb_model->site_title(),
			'profile_client' => $result[0]->profile_client,
			'tanggal_terakhir_login' => $result[0]->tanggal_terakhir_login,
			'tanggal_terakhir_login' => $result[0]->tanggal_terakhir_login,
			'terakhir_login_ip' => $result[0]->terakhir_login_ip,
			'all_negaraa' => $this->Umb_model->get_negaraa(),
		);
		$data['breadcrumbs'] = $this->lang->line('header_my_profile');
		$data['path_url'] = 'profile_client';
		if(!empty($session)){ 
			$data['subview'] = $this->load->view("client/profile/profile_client", $data, TRUE);
			$this->load->view('client/layout/layout_main', $data); 
		} else {
			redirect('client/auth/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}
	
	public function update() {
		
		if($this->input->post('type')=='client') {
			$id = $this->uri->segment(4);
			$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('website', 'Website', 'trim|required|xss_clean');
			$this->form_validation->set_rules('kota', 'Kota', 'trim|required|xss_clean');
			$name = $this->input->post('name');
			$nama_perusahaan = $this->input->post('nama_perusahaan');
			$email = $this->input->post('email');
			$nomor_kontak = $this->input->post('nomor_kontak');
			$website = $this->input->post('website');
			$alamat_1 = $this->input->post('alamat_1');
			$alamat_2 = $this->input->post('alamat_2');
			$kota = $this->input->post('kota');
			$provinsi = $this->input->post('provinsi');
			$kode_pos = $this->input->post('kode_pos');
			$negara = $this->input->post('negara');
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			if($name==='') {
				$Return['error'] = $this->lang->line('umb_error_field_nama');
			} else if($nama_perusahaan==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_nama_perusahaan');
			} else if($nomor_kontak==='') {
				$Return['error'] = $this->lang->line('umb_error_field_kontak');
			} else if($email==='') {
				$Return['error'] = $this->lang->line('umb_error_cemail_field');
			} else if($website==='') {
				$Return['error'] = $this->lang->line('umb_error_fiel_website');
			}  else if($kota==='') {
				$Return['error'] = $this->lang->line('umb_error_fiel_kota');
			} else if($kode_pos==='') {
				$Return['error'] = $this->lang->line('umb_error_fiel_kode_pos');
			} else if($negara==='') {
				$Return['error'] = $this->lang->line('umb_error_field_negara');
			} else if($this->input->post('username')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_username');
			}
			
			else if($_FILES['photo_client']['size'] == 0) {
				$fname = 'no file';
				$no_logo_data = array(
					'name' => $this->input->post('name'),
					'nama_perusahaan' => $this->input->post('nama_perusahaan'),
					'email' => $this->input->post('email'),
					'nomor_kontak' => $this->input->post('nomor_kontak'),
					'website_url' => $this->input->post('website'),
					'alamat_1' => $this->input->post('alamat_1'),
					'alamat_2' => $this->input->post('alamat_2'),
					'kota' => $this->input->post('kota'),
					'provinsi' => $this->input->post('provinsi'),
					'kode_pos' => $this->input->post('kode_pos'),
					'negara' => $this->input->post('negara'),
				);
				$result = $this->Clients_model->update_record($no_logo_data,$id);
			} else {
				if(is_uploaded_file($_FILES['photo_client']['tmp_name'])) {
					
					$allowed =  array('png','jpg','jpeg','gif');
					$filename = $_FILES['photo_client']['name'];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);
					if(in_array($ext,$allowed)){
						$tmp_name = $_FILES["photo_client"]["tmp_name"];
						$bill_copy = "uploads/clients/";
						$lname = basename($_FILES["photo_client"]["name"]);
						$newfilename = 'photo_client_'.round(microtime(true)).'.'.$ext;
						move_uploaded_file($tmp_name, $bill_copy.$newfilename);
						$fname = $newfilename;
						$data = array(
							'name' => $this->input->post('name'),
							'nama_perusahaan' => $this->input->post('nama_perusahaan'),
							'email' => $this->input->post('email'),
							'profile_client' => $fname,
							'nomor_kontak' => $this->input->post('nomor_kontak'),
							'website_url' => $this->input->post('website'),
							'alamat_1' => $this->input->post('alamat_1'),
							'alamat_2' => $this->input->post('alamat_2'),
							'kota' => $this->input->post('kota'),
							'provinsi' => $this->input->post('provinsi'),
							'kode_pos' => $this->input->post('kode_pos'),
							'negara' => $this->input->post('negara'),		
						);
						$result = $this->Clients_model->update_record($data,$id);
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

	public function change_password() {
		
		if($this->input->post('type')=='change_password') {		
			$session = $this->session->userdata('client_username');
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
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
			$options = array('cost' => 12);
			$password_hash = password_hash($this->input->post('new_password'), PASSWORD_BCRYPT, $options);
			$data = array(
				'password_client' => $password_hash
			);
			$id = $session['client_id'];
			$result = $this->Clients_model->update_record($data,$id);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_password_client_update');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
}