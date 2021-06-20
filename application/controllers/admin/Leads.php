<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Leads extends MY_Controller {
	
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
		$data['title'] = $this->lang->line('umb_leads').' | '.$this->Umb_model->site_title();
		$data['all_negaraa'] = $this->Umb_model->get_negaraa();
		$data['breadcrumbs'] = $this->lang->line('umb_leads');
		$data['path_url'] = 'leads';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('411',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/clients/list_leads", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
		} else {
			redirect('admin/dashboard');
		}
	}

	public function import() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('umb_import_leads').' | '.$this->Umb_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('umb_import_leads');
		$data['path_url'] = 'import_leads';		
		$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		//$data['all_departments'] = $this->Department_model->all_departments();
		//$data['all_penunjukans'] = $this->Penunjukan_model->all_penunjukans();
		//$data['all_user_roles'] = $this->Roles_model->all_user_roles();
		//$data['all_shifts_kantor'] = $this->Karyawans_model->all_shifts_kantor();
		$data['get_all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('92',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/clients/import_leads", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}		  
	}

	public function import_leads() {

		if($this->input->post('is_ajax')=='3') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
			$csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');

			if($_FILES['file']['name']==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_imp_allowed_size');
			} else {
				if(in_array($_FILES['file']['type'],$csvMimes)){
					if(is_uploaded_file($_FILES['file']['tmp_name'])){

						if(filesize($_FILES['file']['tmp_name']) > 2000000) {
							$Return['error'] = $this->lang->line('umb_error_karyawans_import_size');
						} else {

							$csvFile = fopen($_FILES['file']['tmp_name'], 'r');

							fgetcsv($csvFile);
							while(($line = fgetcsv($csvFile)) !== FALSE){

								$options = array('cost' => 12);
								$password_hash = password_hash($line[2], PASSWORD_BCRYPT, $options);
								$data = array(
									'name' => $line[0],
									'email' => $line[1],
									'password_client' => $password_hash,
									'nomor_kontak' => $line[3],
									'nama_perusahaan' => $line[4],
									'website_url' => $line[5],
									'alamat_1' => $line[6],
									'alamat_2' => $line[7],
									'kota' => $line[8],
									'provinsi' => $line[9],
									'kode_pos' => $line[10],
									'negara' => $line[11],
									'is_active' => 1,
									'created_at' => date('Y-m-d H:i:s'),
									'is_changed' => '0',
									'profile_client' => '',
								);
								$this->Clients_model->add_lead($data);
							}					

							fclose($csvFile);

							$Return['result'] = $this->lang->line('umb_sukses_import_leads');
						}
					}else{
						$Return['error'] = $this->lang->line('umb_error_not_import_leads');
					}
				}else{
					$Return['error'] = $this->lang->line('umb_error_invalid_file');
				}
			}

			if($Return['error']!=''){
				$this->output($Return);
			}

			$this->output($Return);
			exit;
		}
	}

	public function list_leads() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/clients/list_leads", $data);
		} else {
			redirect('admin/');
		}

		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		$leads = $this->Clients_model->get_leads();
		$role_resources_ids = $this->Umb_model->user_role_resource();
		$data = array();

		foreach($leads->result() as $r) {

			$negara = $this->Umb_model->read_info_negara($r->negara);
			if(!is_null($negara)){
				$c_name = $negara[0]->nama_negara;
			} else {
				$c_name = '--';	
			}	  

			if(in_array('413',$role_resources_ids)) {
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data-timelog"  data-client_id="'. $r->client_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('414',$role_resources_ids)) { 
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->client_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}
			if(in_array('420',$role_resources_ids)) {
				$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target="#modals-slide" data-client_id="'. $r->client_id . '"><span class="fa fa-eye"></span></button></span>';
			} else {
				$view = '';
			}

			if($r->is_changed == '0'){
				$change = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_change_to_client').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".add-modal-data" data-lead_id="'. $r->client_id . '"><span class="fas fa-exchange-alt"></span></button></span>';
				$opt = '<span class="badge badge-info">'.$this->lang->line('umb_lead').'</span>';
			} else {
				$change = '';
				$opt = '<span class="badge badge-success">'.$this->lang->line('umb_kontak_person').'</span>';
			}
			$lead_flup = $this->Clients_model->get_total_lead_followup($r->client_id);
			if($lead_flup > 0){
				if($r->is_changed == '0'){
					$ldflp_opt = '<span class="badge badge-danger">'.$this->lang->line('umb_lead_followup').'</span>';
				} else {
					$ldflp_opt = '';
				}
			} else {
				$ldflp_opt = '';
			}
			
			if($r->is_changed == 0){
				$dview = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_lead_add_followup').'"><a href="'.site_url().'admin/leads/followup/'.$r->client_id.'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span>';
			} else {
				$dview = '';
			}
			$combhr = $edit.$view.$dview.$change.$delete;

			$data[] = array(
				$combhr,
				$r->name.'<br>'.$opt.'<br>'.$ldflp_opt,
				$r->nama_perusahaan,
				$r->email,
				$r->website_url,
				$c_name,
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $leads->num_rows(),
			"recordsFiltered" => $leads->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function list_leads_followup() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/clients/leads_followup", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$id = $this->uri->segment(4);
		$followup = $this->Clients_model->get_lead_followup($id);
		$role_resources_ids = $this->Umb_model->user_role_resource();
		$data = array();

		foreach($followup->result() as $r) {

			$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->leads_followup_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data-timelog"  data-leads_followup_id="'. $r->leads_followup_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
			$combhr = $edit.$delete;

			$data[] = array(
				$combhr,
				$r->next_followup,
				$r->description,
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $followup->num_rows(),
			"recordsFiltered" => $followup->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function read_lead() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('client_id');
		$result = $this->Clients_model->read_info_lead($id);
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
			'is_changed' => $result[0]->is_changed,
			'kota' => $result[0]->kota,
			'provinsi' => $result[0]->provinsi,
			'kode_pos' => $result[0]->kode_pos,
			'negaraid' => $result[0]->negara,
			'is_active' => $result[0]->is_active,
			'all_negaraa' => $this->Umb_model->get_negaraa(),
		);
		$this->load->view('admin/clients/dialog_leads', $data);
	}

	public function read_leads_followup() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('leads_followup_id');
		$result = $this->Clients_model->read_info_lead_followup($id);
		$data = array(
			'leads_followup_id' => $result[0]->leads_followup_id,
			'lead_id' => $result[0]->lead_id,
			'next_followup' => $result[0]->next_followup,
			'description' => $result[0]->description,
		);
		$this->load->view('admin/clients/dialog_leads', $data);
	}
	
	public function add_followup() {

		if($this->input->post('type')=='followup_info') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
			if($this->input->post('next_followup')==='') {
				$Return['error'] = $this->lang->line('umb_lead_next_followup_field_error');
			} else if($this->input->post('description')==='') {
				$Return['error'] = $this->lang->line('umb_error_description_file_tugas');
			}

			if($Return['error']!=''){
				$this->output($Return);
			}

			$data = array(
				'next_followup' => $this->input->post('next_followup'),
				'description' => $this->input->post('description'),
				'lead_id' => $this->input->post('client_id'),
			);
			$result = $this->Clients_model->add_lead_followup($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_lead_followup_ditambahkan');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function update_lead_followup() {

		if($this->input->post('data')=='edit_info_followup') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();

			$id = $this->uri->segment(4);	

			if($this->input->post('next_followup')==='') {
				$Return['error'] = $this->lang->line('umb_lead_next_followup_field_error');
			} else if($this->input->post('description')==='') {
				$Return['error'] = $this->lang->line('umb_error_description_file_tugas');
			}

			if($Return['error']!=''){
				$this->output($Return);
			}

			$data = array(
				'next_followup' => $this->input->post('next_followup'),
				'description' => $this->input->post('description'),
			);
			$result = $this->Clients_model->update_record_lead_followup($data,$id);	
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_lead_followup_diperbarui');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function add_lead() {

		if($this->input->post('add_type')=='lead') {

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
			} /*else if($nama_perusahaan==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_nama_perusahaan');
			} else if($nomor_kontak==='') {
				$Return['error'] = $this->lang->line('umb_error_field_kontak');
			}*/ else if($email==='') {
				$Return['error'] = $this->lang->line('umb_error_cemail_field');
			} else if($this->Umb_model->check_email_client($email) > 0) {
				$Return['error'] = $this->lang->line('umb_check_email_client_error');
			}  /*else if($kota==='') {
				$Return['error'] = $this->lang->line('umb_error_fiel_kota');
			} else if($kode_pos==='') {
				$Return['error'] = $this->lang->line('umb_error_fiel_kode_pos');
			}*/ else if($negara==='') {
				$Return['error'] = $this->lang->line('umb_error_field_negara');
			} /*else if($this->input->post('username')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_username');
			} else if($this->input->post('password')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_password');
			}*/

			else if($_FILES['photo_client']['size'] == 0) {
				$fname = 'no file';
				$options = array('cost' => 12);
				$password_hash = password_hash($this->input->post('password'), PASSWORD_BCRYPT, $options);

				$data = array(
					'name' => $this->input->post('name'),
					'nama_perusahaan' => $this->input->post('nama_perusahaan'),
					'email' => $this->input->post('email'),
					'is_changed' => '0',
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
				$result = $this->Clients_model->add_lead($data);
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
					'is_changed' => '0',
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
				$result = $this->Clients_model->add_lead($data);
			}

			if($Return['error']!=''){
				$this->output($Return);
			}

			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_project_lead_ditambahkan');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function update_lead() {

		if($this->input->post('edit_type')=='lead') {
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
			} /*else if($nama_perusahaan==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_nama_perusahaan');
			} else if($nomor_kontak==='') {
				$Return['error'] = $this->lang->line('umb_error_field_kontak');
			}*/ else if($email==='') {
				$Return['error'] = $this->lang->line('umb_error_cemail_field');
			} else if($this->Umb_model->check_email_client($email) > 1) {
				$Return['error'] = $this->lang->line('umb_check_email_client_error');
			}  /*else if($kota==='') {
				$Return['error'] = $this->lang->line('umb_error_fiel_kota');
			} else if($kode_pos==='') {
				$Return['error'] = $this->lang->line('umb_error_fiel_kode_pos');
			}*/ else if($negara==='') {
				$Return['error'] = $this->lang->line('umb_error_field_negara');
			} /*else if($this->input->post('username')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_username');
			}*/

			else if($_FILES['photo_client']['size'] == 0) {
				//$fname = 'no file';
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
				$result = $this->Clients_model->update_record_lead($no_logo_data,$id);
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
							//'client_username' => $this->input->post('username'),
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

						$result = $this->Clients_model->update_record_lead($data,$id);
					} else {
						$Return['error'] = $this->lang->line('umb_error_attatchment_type');
					}
				}
			}

			if($Return['error']!=''){
				$this->output($Return);
			}		

			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_project_lead_diperbarui');
			} else {
				$Return['error'] = $Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function change_to_client() {

		if($this->input->post('edit_type')=='change_lead') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();	

			$data = array(
				'is_changed' => '1',
			);
			$id = $this->uri->segment(4);
			$result = $this->Clients_model->update_record_lead($data,$id);
			$lead_info = $this->Clients_model->read_info_lead($id);
			$data_lead = array(
				'name' => $lead_info[0]->name,
				'nama_perusahaan' => $lead_info[0]->nama_perusahaan,
				'email' => $lead_info[0]->email,
				'password_client' => $lead_info[0]->password_client,
				'profile_client' => $lead_info[0]->profile_client,
				'nomor_kontak' => $lead_info[0]->nomor_kontak,
				'website_url' => $lead_info[0]->website_url,
				'alamat_1' => $lead_info[0]->alamat_1,
				'alamat_2' => $lead_info[0]->alamat_2,
				'kota' => $lead_info[0]->kota,
				'provinsi' => $lead_info[0]->provinsi,
				'kode_pos' => $lead_info[0]->kode_pos,
				'negara' => $lead_info[0]->negara,
				'is_active' => 1,
				'created_at' => date('Y-m-d H:i:s'),
			);
			$this->Clients_model->add($data_lead);
			//$this->Clients_model->delete_record_lead($id);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_lead_has_been_converted');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	} 

	public function followup() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->uri->segment(4);
		$result = $this->Clients_model->read_info_lead($id);
		if(is_null($result)){
			redirect('admin/leads');
		}

		$data = array(
			'title' => $this->lang->line('umb_details_lead').' | '.$this->Umb_model->site_title(),
			'client_id' => $result[0]->client_id,
			'name' => $result[0]->name,
			'nama_perusahaan' => $result[0]->nama_perusahaan,
			'profile_client' => $result[0]->profile_client,
			'email' => $result[0]->email,
			'nomor_kontak' => $result[0]->nomor_kontak,
			'website_url' => $result[0]->website_url,
			'alamat_1' => $result[0]->alamat_1,
			'alamat_2' => $result[0]->alamat_2,
			'is_changed' => $result[0]->is_changed,
			'kota' => $result[0]->kota,
			'provinsi' => $result[0]->provinsi,
			'kode_pos' => $result[0]->kode_pos,
			'negaraid' => $result[0]->negara,
			'is_active' => $result[0]->is_active,
			'all_negaraa' => $this->Umb_model->get_negaraa(),
		);
		$data['breadcrumbs'] = $this->lang->line('umb_lead').'#'.$result[0]->client_id.' - '.$result[0]->nama_perusahaan;
		$data['path_url'] = 'details_lead';
		if(!empty($session)){ 
			$data['subview'] = $this->load->view("admin/clients/leads_followup", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
		} else {
			redirect('admin/');
		}		  
	}
	public function delete_lead() {

		if($this->input->post('is_ajax')==2) {
			$session = $this->session->userdata('username');
			if(empty($session)){ 
				redirect('admin/');
			}

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Clients_model->delete_record_lead($id);
			$result = $this->Clients_model->delete_main_lead_followup($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_project_lead_dihapus');
			} else {
				$Return['error'] = $Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}
	public function delete_lead_followup() {

		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$result = $this->Clients_model->delete_lead_followup($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('umb_lead_followup_dihapus');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
	}
}
