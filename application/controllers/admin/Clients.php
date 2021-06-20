<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Clients extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model("Clients_model");
		$this->load->model("Umb_model");
		$this->load->library('email');
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
		if($system[0]->module_projects_tugass!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('umb_project_clients').' | '.$this->Umb_model->site_title();
		$data['all_negaraa'] = $this->Umb_model->get_negaraa();
		$data['breadcrumbs'] = $this->lang->line('umb_project_clients');
		$data['path_url'] = 'clients';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('119',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/clients/list_clients", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
		} else {
			redirect('admin/dashboard');
		}
	}

	public function list_clients() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/clients/list_clients", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$client = $this->Clients_model->get_clients();
		$role_resources_ids = $this->Umb_model->user_role_resource();
		$data = array();
		foreach($client->result() as $r) {
			$negara = $this->Umb_model->read_info_negara($r->negara);
			if(!is_null($negara)){
				$c_name = $negara[0]->nama_negara;
			} else {
				$c_name = '--';	
			}	  
			if(in_array('324',$role_resources_ids)) {
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-client_id="'. $r->client_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('325',$role_resources_ids)) {
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->client_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}
			if(in_array('326',$role_resources_ids)) {
				$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target="#modals-slide" data-client_id="'. $r->client_id . '"><span class="fa fa-eye"></span></button></span>';
			} else {
				$view = '';
			}
			$combhr = $edit.$view.$delete;

			$data[] = array(
				$combhr,
				$r->name,
				$r->nama_perusahaan,
				$r->email,
				$r->website_url,
				$c_name,
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $client->num_rows(),
			"recordsFiltered" => $client->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function read_client() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('client_id');
		$result = $this->Clients_model->read_info_client($id);
		$data = array(
			'client_id' => $result[0]->client_id,
			'name' => $result[0]->name,
			'nama_perusahaan' => $result[0]->nama_perusahaan,
			'profile_client' => $result[0]->profile_client,
			'email' => $result[0]->email,
			'nomor_kontak' => $result[0]->nomor_kontak,
			'website_url' => $result[0]->website_url,
			'alamat_1' => $result[0]->alamat_1,
			'alamat_2' => $result[0]->alamat_2,
			'kota' => $result[0]->kota,
			'provinsi' => $result[0]->provinsi,
			'kode_pos' => $result[0]->kode_pos,
			'negaraid' => $result[0]->negara,
			'is_active' => $result[0]->is_active,
			'all_negaraa' => $this->Umb_model->get_negaraa(),
		);
		$this->load->view('admin/clients/dialog_clients', $data);
	}
	
	
	public function add_client() {

		if($this->input->post('add_type')=='client') {
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
			$user_id = $this->input->post('user_id');
			$file = $_FILES['photo_client']['tmp_name'];


			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			

			if($name==='') {
				$Return['error'] = $this->lang->line('umb_clkontak_person_field_error');
			} else if($email==='') {
				$Return['error'] = $this->lang->line('umb_error_cemail_field');
			} else if($this->Umb_model->check_email_client($email) > 0) {
				$Return['error'] = $this->lang->line('umb_check_email_client_error');
			}  else if($negara==='') {
				$Return['error'] = $this->lang->line('umb_error_field_negara');
			} else if($_FILES['photo_client']['size'] == 0) {
				$fname = 'no file';
				$options = array('cost' => 12);
				$password_hash = password_hash($this->input->post('password'), PASSWORD_BCRYPT, $options);

				$data = array(
					'name' => $this->input->post('name'),
					'nama_perusahaan' => $this->input->post('nama_perusahaan'),
					'email' => $this->input->post('email'),
					'password_client' => $password_hash,
					'profile_client' => '',
					'nomor_kontak' => $this->input->post('nomor_kontak'),
					'website_url' => $this->input->post('website'),
					'alamat_1' => $this->input->post('alamat_1'),
					'alamat_2' => $this->input->post('alamat_2'),
					'kota' => $this->input->post('kota'),
					'provinsi' => $this->input->post('provinsi'),
					'kode_pos' => $this->input->post('kode_pos'),
					'negara' => $this->input->post('negara'),
					'is_active' => 1,
					'created_at' => date('Y-m-d H:i:s'),
				);
				$result = $this->Clients_model->add($data);
				if ($result == TRUE) {
					$setting = $this->Umb_model->read_setting_info(1);
					$perusahaan = $this->Umb_model->read_info_setting_perusahaan(1);
					if($setting[0]->enable_email_notification == 'yes') {
						$this->email->set_mailtype("html");
						$cinfo = $this->Umb_model->read_info_setting_perusahaan(1);
						$template = $this->Umb_model->read_email_template(16);
						$subject = $template[0]->subject.' - '.$cinfo[0]->nama_perusahaan;
						$logo = base_url().'uploads/logo/signin/'.$perusahaan[0]->sign_in_logo;
						$full_name = $this->input->post('name');
						$message = '
						<div style="background:#f6f6f6;font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;margin:0;padding:0;padding: 20px;">
						<img src="'.$logo.'" title="'.$cinfo[0]->nama_perusahaan.'"><br>'.str_replace(array("{var site_name}","{var site_url}","{var name_client}","{var email}","{var password}"),array($cinfo[0]->nama_perusahaan,site_url(),$full_name,$this->input->post('email'),$this->input->post('password')),htmlspecialchars_decode(stripslashes($template[0]->message))).'</div>';
						hrastral_mail($cinfo[0]->email,$cinfo[0]->nama_perusahaan,$this->input->post('email'),$subject,$message);
					}
				}
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
					} else {
						$Return['error'] = $this->lang->line('umb_error_attatchment_type');
					}
				}
				$options = array('cost' => 12);
				$password_hash = password_hash($this->input->post('password'), PASSWORD_BCRYPT, $options);
				$data = array(
					'name' => $this->input->post('name'),
					'nama_perusahaan' => $this->input->post('nama_perusahaan'),
					'email' => $this->input->post('email'),
					'password_client' => $password_hash,
					'profile_client' => $fname,
					'nomor_kontak' => $this->input->post('nomor_kontak'),
					'website_url' => $this->input->post('website'),
					'alamat_1' => $this->input->post('alamat_1'),
					'alamat_2' => $this->input->post('alamat_2'),
					'kota' => $this->input->post('kota'),
					'provinsi' => $this->input->post('provinsi'),
					'kode_pos' => $this->input->post('kode_pos'),
					'negara' => $this->input->post('negara'),
					'is_active' => 1,
					'created_at' => date('Y-m-d H:i:s'),

				);
				$result = $this->Clients_model->add($data);
				if ($result == TRUE) {
					$setting = $this->Umb_model->read_setting_info(1);
					$perusahaan = $this->Umb_model->read_info_setting_perusahaan(1);
					if($setting[0]->enable_email_notification == 'yes') {
						$this->email->set_mailtype("html");
						$cinfo = $this->Umb_model->read_info_setting_perusahaan(1);
						$template = $this->Umb_model->read_email_template(16);
						$subject = $template[0]->subject.' - '.$cinfo[0]->nama_perusahaan;
						$logo = base_url().'uploads/logo/signin/'.$perusahaan[0]->sign_in_logo;
						$full_name = $this->input->post('name');
						$message = '
						<div style="background:#f6f6f6;font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;margin:0;padding:0;padding: 20px;">
						<img src="'.$logo.'" title="'.$cinfo[0]->nama_perusahaan.'"><br>'.str_replace(array("{var site_name}","{var site_url}","{var username}","{var email}","{var password}"),array($cinfo[0]->nama_perusahaan,site_url(),$this->input->post('username'),$this->input->post('email'),$this->input->post('password')),htmlspecialchars_decode(stripslashes($template[0]->message))).'</div>';

						hrastral_mail($cinfo[0]->email,$cinfo[0]->nama_perusahaan,$this->input->post('email'),$subject,$message);
					}
				}
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_project_client_ditambahkan');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}


	public function update() {

		if($this->input->post('edit_type')=='client') {
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
				$Return['error'] = $this->lang->line('umb_clkontak_person_field_error');
			} else if($email==='') {
				$Return['error'] = $this->lang->line('umb_error_cemail_field');
			} else if($this->Umb_model->check_email_client($email) > 1) {
				$Return['error'] = $this->lang->line('umb_check_email_client_error');
			}  else if($negara==='') {
				$Return['error'] = $this->lang->line('umb_error_field_negara');
			} else if($_FILES['photo_client']['size'] == 0) {
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
					'is_active' => $this->input->post('status'),
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
							'is_active' => $this->input->post('status'),
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
				$Return['result'] = $this->lang->line('umb_project_client_diperbarui');
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

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Clients_model->delete_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_project_client_dihapus');
			} else {
				$Return['error'] = $Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}
}
