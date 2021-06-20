<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Type_training extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		
		$this->load->model("Training_model");
		$this->load->model("Umb_model");
		$this->load->model("Trainers_model");
		$this->load->model("Penunjukan_model");
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
		if($system[0]->module_training!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('left_type_training').' | '.$this->Umb_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('left_type_training');
		$data['path_url'] = 'type_training';
		$data['all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('55',$role_resources_ids)) {
			if(!empty($session)){
				$data['subview'] = $this->load->view("admin/training/type_training", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}
	
	public function list_type() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/training/type_training", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$type_training = $this->Training_model->get_type_training();
		$role_resources_ids = $this->Umb_model->user_role_resource();
		$data = array();
		foreach($type_training->result() as $r) {
			if(in_array('346',$role_resources_ids)) {
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-type_training_id="'. $r->type_training_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('347',$role_resources_ids)) {
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->type_training_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}
			$combhr = $edit.$delete;
			
			$data[] = array(
				$combhr,
				$r->type
			);
		}
		$output = array(
			"draw" => $draw,
			"recordsTotal" => $type_training->num_rows(),
			"recordsFiltered" => $type_training->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}
	
	public function read() {

		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('type_training_id');
		$result = $this->Training_model->read_informasi_type_training($id);
		$data = array(
			'type_training_id' => $result[0]->type_training_id,
			'type' => $result[0]->type,
			'all_perusahaans' => $this->Umb_model->get_perusahaans()
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/training/dialog_type_training', $data);
		} else {
			redirect('admin/');
		}
	}
	
	public function add_type() {
		
		if($this->input->post('add_type')=='training') {		
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			if($this->input->post('type_name')==='') {
				$Return['error'] = $this->lang->line('umb_error_type_training_name');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$data = array(
				'type' => $this->input->post('type_name'),
				'created_at' => date('d-m-Y h:i:s')
			);
			$result = $this->Training_model->add_type($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_type_training_ditambahkan');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function update() {
		
		if($this->input->post('edit_type')=='training') {
			$id = $this->uri->segment(4);
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			if($this->input->post('type_name')==='') {
				$Return['error'] = $this->lang->line('umb_error_type_training_name');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$data = array(
				'type' => $this->input->post('type_name')
			);
			$result = $this->Training_model->update_record_type($data,$id);		
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_type_training_diperbarui');
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
		$result = $this->Training_model->delete_record_type($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('umb_sukses_type_training_dihapus');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
	}
}
