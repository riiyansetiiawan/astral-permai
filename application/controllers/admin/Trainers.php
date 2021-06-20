<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Trainers extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		
		$this->load->model("Trainers_model");
		$this->load->model("Umb_model");
		$this->load->model("Penunjukan_model");
	}
	
	public function output($Return=array()){
		
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		exit(json_encode($Return));
	}
	
	public function index(){
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$system = $this->Umb_model->read_setting_info(1);
		if($system[0]->module_training!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('umb_trainers').' | '.$this->Umb_model->site_title();
		$data['all_penunjukans'] = $this->Penunjukan_model->all_penunjukans();
		$data['all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$data['breadcrumbs'] = $this->lang->line('umb_trainers');
		$data['path_url'] = 'trainers';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('56',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/trainers/list_trainer", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}	  
	}
	
	public function list_trainer() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/trainers/list_trainer", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$role_resources_ids = $this->Umb_model->user_role_resource();
		$user_info = $this->Umb_model->read_user_info($session['user_id']);
		if($user_info[0]->user_role_id==1){
			$trainers = $this->Trainers_model->get_trainers();
		} else {
			$trainers = $this->Trainers_model->get_perusahaan_trainers($user_info[0]->perusahaan_id);
		}
		$data = array();
		foreach($trainers->result() as $r) {
			$full_name = $r->first_name.' '.$r->last_name;
			$perusahaan = $this->Umb_model->read_info_perusahaan($r->perusahaan_id);
			if(!is_null($perusahaan)){
				$prshn_nama = $perusahaan[0]->name;
			} else {
				$prshn_nama = '--';	
			}
			if(in_array('349',$role_resources_ids)) {
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-trainer_id="'. $r->trainer_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('350',$role_resources_ids)) {
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->trainer_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}
			if(in_array('351',$role_resources_ids)) {
				$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target="#modals-slide" data-trainer_id="'. $r->trainer_id . '"><span class="fa fa-eye"></span></button></span>';
			} else {
				$view = '';
			}
			$combhr = $edit.$view.$delete;
			$ifull_name = $full_name.'<br><small class="text-muted"><i>'.$this->lang->line('umb_expertise').': '.html_entity_decode($r->expertise).'<i></i></i></small><br><small class="text-muted"><i>'.$this->lang->line('umb_alamat').': '.html_entity_decode($r->alamat).'<i></i></i></small>';
			$data[] = array(
				$combhr,
				$ifull_name,
				$prshn_nama,
				$r->nomor_kontak,
				$r->email
			);
		}
		$output = array(
			"draw" => $draw,
			"recordsTotal" => $trainers->num_rows(),
			"recordsFiltered" => $trainers->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}
	
	public function read() {

		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('trainer_id');
		$result = $this->Trainers_model->read_informasi_trainer($id);
		$data = array(
			'trainer_id' => $result[0]->trainer_id,
			'perusahaan_id' => $result[0]->perusahaan_id,
			'first_name' => $result[0]->first_name,
			'last_name' => $result[0]->last_name,
			'nomor_kontak' => $result[0]->nomor_kontak,
			'email' => $result[0]->email,
			'expertise' => $result[0]->expertise,
			'alamat' => $result[0]->alamat,
			'all_perusahaans' => $this->Umb_model->get_perusahaans(),
			'all_penunjukans' => $this->Penunjukan_model->all_penunjukans()
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/trainers/dialog_trainer', $data);
		} else {
			redirect('admin/');
		}
	}
	
	public function add_trainer() {
		
		if($this->input->post('add_type')=='trainer') {		
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$expertise = $this->input->post('expertise');
			$qt_expertise = htmlspecialchars(addslashes($expertise), ENT_QUOTES);
			$alamat = $this->input->post('alamat');
			$qt_address = htmlspecialchars(addslashes($alamat), ENT_QUOTES);
			if($this->input->post('first_name')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_first_name');
			} else if($this->input->post('last_name')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_last_name');
			} else if($this->input->post('nomor_kontak')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_nomor_kontak');
			} else if($this->input->post('email')==='') {
				$Return['error'] = $this->lang->line('umb_error_cemail_field');
			} else if (!filter_var($this->input->post('email'), FILTER_VALIDATE_EMAIL)) {
				$Return['error'] = $this->lang->line('umb_karyawan_error_invalid_email');
			} else if($this->input->post('perusahaan')==='') {
				$Return['error'] = $this->lang->line('error_field_perusahaan');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}				
			$data = array(
				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'perusahaan_id' => $this->input->post('perusahaan'),
				'nomor_kontak' => $this->input->post('nomor_kontak'),
				'expertise' => $qt_expertise,
				'alamat' => $qt_address,
				'email' => $this->input->post('email'),
				'created_at' => date('d-m-Y'),
			);
			$result = $this->Trainers_model->add($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_trainer_ditambahkan');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function update() {
		
		if($this->input->post('edit_type')=='trainer') {
			
			$id = $this->uri->segment(4);
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$expertise = $this->input->post('expertise');
			$qt_expertise = htmlspecialchars(addslashes($expertise), ENT_QUOTES);
			$alamat = $this->input->post('alamat');
			$qt_address = htmlspecialchars(addslashes($alamat), ENT_QUOTES);
			if($this->input->post('first_name')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_first_name');
			} else if($this->input->post('last_name')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_last_name');
			} else if($this->input->post('nomor_kontak')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_nomor_kontak');
			} else if($this->input->post('email')==='') {
				$Return['error'] = $this->lang->line('umb_error_cemail_field');
			} else if (!filter_var($this->input->post('email'), FILTER_VALIDATE_EMAIL)) {
				$Return['error'] = $this->lang->line('umb_karyawan_error_invalid_email');
			} else if($this->input->post('penunjukan_id')==='') {
				$Return['error'] = $this->lang->line('umb_error_field_penunjukan');
			} else if($this->input->post('perusahaan')==='') {
				$Return['error'] = $this->lang->line('error_field_perusahaan');
			}
			
			if($Return['error']!=''){
				$this->output($Return);
			}				
			$data = array(
				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'perusahaan_id' => $this->input->post('perusahaan'),
				'nomor_kontak' => $this->input->post('nomor_kontak'),
				'expertise' => $qt_expertise,
				'alamat' => $qt_address,
				'email' => $this->input->post('email')
			);
			$result = $this->Trainers_model->update_record($data,$id);		
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_trainer_diperbarui');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function delete() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$result = $this->Trainers_model->delete_record($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('umb_sukses_trainer_dihapus');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
	}
}
