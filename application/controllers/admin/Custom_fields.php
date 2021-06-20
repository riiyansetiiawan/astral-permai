<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Custom_fields extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		
		$this->load->model("Custom_fields_model");
		$this->load->model("Department_model");
		$this->load->model("Umb_model");
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
		$data['title'] = $this->lang->line('umb_hrastral_custom_fields').' | '.$this->Umb_model->site_title();
		$data['all_negaraa'] = $this->Umb_model->get_negaraa();
		$data['all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		$data['breadcrumbs'] = $this->lang->line('umb_hrastral_custom_fields');
		$data['path_url'] = 'custom_fields';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('393',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/custom_fields/list_custom_fields", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}
	
	public function list_custom_fields() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/custom_fields/list_custom_fields", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$custom_fields = $this->Custom_fields_model->get_hrastral_module_attributes();
		$role_resources_ids = $this->Umb_model->user_role_resource();
		$data = array();

		foreach($custom_fields->result() as $r) {
			
			if(in_array('395',$role_resources_ids)) {
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target="#edit-modal-data"  data-custom_field_id="'. $r->custom_field_id . '"><span class="fas fa-pencil-alt"></span></button></span></span>';
			} else {
				$edit = '';
			}
			if(in_array('396',$role_resources_ids)) {
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->custom_field_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}
			if($r->validation == 0){
				$validation = $this->lang->line('umb_no');
			} else {
				$validation = $this->lang->line('umb_yes');
			}
			if($r->module_id == 1){
				$module = $this->lang->line('dashboard_karyawans');
			} else if($r->module_id == 2){
				$module = $this->lang->line('left_awards');
			} else if($r->module_id == 3){
				$module = $this->lang->line('dashboard_pengumumans');
			} else if($r->module_id == 4){
				$module = $this->lang->line('left_perusahaan');
			} else if($r->module_id == 5){
				$module = $this->lang->line('left_training');
			} else if($r->module_id == 6){
				$module = $this->lang->line('left_tickets');
			} else if($r->module_id == 7){
				$module = $this->lang->line('umb_assets');
			} else if($r->module_id == 8){
				$module = $this->lang->line('left_cuti');
			} else {
				$module = $this->lang->line('left_training');
			}
			
			$combhr = $edit.$delete;

			$data[] = array(
				$combhr,
				$module,
				$r->attribute,
				$r->attribute_label,
				$r->attribute_type,
				$validation,
				$r->priority
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $custom_fields->num_rows(),
			"recordsFiltered" => $custom_fields->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}
	
	public function read_info()
	{
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('custom_field_id');
		// $data['all_negaraa'] = $this->Umb_model->get_negaraa();
		$result = $this->Custom_fields_model->read_hrastral_module_attributes($id);
		$data = array(
			'custom_field_id' => $result[0]->custom_field_id,
			'attribute' => $result[0]->attribute,
			'attribute_label' => $result[0]->attribute_label,
			'attribute_type' => $result[0]->attribute_type,
			'validation' => $result[0]->validation,
			'module_id' => $result[0]->module_id,
			'priority' => $result[0]->priority
		);
		if(!empty($session)){ 
			$this->load->view('admin/custom_fields/dialog_custom_fields', $data);
		} else {
			redirect('admin/');
		}
	}
	
	
	public function add_custom_field() {
		
		if($this->input->post('add_type')=='custom_field') {
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
			if($this->input->post('module_id')==='') {
				$Return['error'] = $this->lang->line('umb_error_modules_field');
			} else if($this->input->post('attribute')==='') {
				$Return['error'] = $this->lang->line('umb_error_field_nama_kat');
			} else if (!ctype_alnum($this->input->post('attribute'))) {
				$Return['error'] = $this->lang->line('umb_field_name_lowercase_error');
			} else if($this->input->post('attribute_label')==='') {
				$Return['error'] = $this->lang->line('umb_hrastral_field_label_error');
			} else if($this->input->post('priority')==='') {
				$Return['error'] = $this->lang->line('umb_hrastral_field_priority_error');
			}
			
			if($Return['error']!=''){
				$this->output($Return);
			}
			
			$data = array(
				'module_id' => $this->input->post('module_id'),
				'attribute' => $this->input->post('attribute'),
				'attribute_label' => $this->input->post('attribute_label'),
				'attribute_type' => $this->input->post('attribute_type'),
				'validation' => $this->input->post('validation'),
				'priority' => $this->input->post('priority'),
				'created_at' => date('d-m-Y'),
			);
			$result = $this->Custom_fields_model->add($data);
			if ($result) {
				foreach($this->input->post('select_value') as $items){
					if($items !=''){
						$select_val = array(
							'custom_field_id' => $result,
							'select_label' => $items,
						);
						$this->Custom_fields_model->add_select_value($select_val);
					}
				}
				$Return['result'] = $this->lang->line('umb_hrastral_field_ditambahkan_success');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	
	public function update() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		if($this->input->post('edit_type')=='custom_field') {
			
			$id = $this->uri->segment(4);
			
		// Check validation for user input		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
			
			if($this->input->post('module_id')==='') {
				$Return['error'] = $this->lang->line('umb_error_modules_field');
			} else if($this->input->post('attribute')==='') {
				$Return['error'] = $this->lang->line('umb_error_field_nama_kat');
			} else if($this->input->post('attribute_label')==='') {
				$Return['error'] = $this->lang->line('umb_hrastral_field_label_error');
			} else if($this->input->post('priority')==='') {
				$Return['error'] = $this->lang->line('umb_hrastral_field_priority_error');
			}
			
			if($Return['error']!=''){
				$this->output($Return);
			}
			
			$data = array(
				'module_id' => $this->input->post('module_id'),
				'attribute_label' => $this->input->post('attribute_label'),
				'validation' => $this->input->post('validation'),
				'priority' => $this->input->post('priority'),	
			);	
			
			$result = $this->Custom_fields_model->update_record($data,$id);		
			
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_hrastral_field_diperbarui_success');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
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
			$result = $this->Custom_fields_model->delete_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_hrastral_field_dihapus_success');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}
}
