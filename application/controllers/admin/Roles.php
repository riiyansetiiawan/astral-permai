<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Roles extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		
		$this->load->model("Roles_model");
		$this->load->model("Umb_model");
	}
	
	
	public function output($Return=array()){
		
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		
		exit(json_encode($Return));
	}
	
	public function index() {
		$data['title'] = $this->lang->line('umb_role_urole').' | '.$this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['breadcrumbs'] = $this->lang->line('umb_role_urole');
		$data['path_url'] = 'roles';
		$user = $this->Umb_model->read_info_karyawan($session['user_id']);
		if($user[0]->user_role_id==1) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/roles/list_role", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}
	
	public function list_role() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/roles/list_role", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$role = $this->Roles_model->get_user_roles();
		$data = array();

		foreach($role->result() as $r) {
			if($r->role_access==1): 
				$r_access = $this->lang->line('umb_role_all_menu'); 
			elseif($r->role_access==2): 
				$r_access = $this->lang->line('umb_role_cmenu'); 
			endif;
			$created_at = $this->Umb_model->set_date_format($r->created_at);
			if($r->role_id==1){
				$roleAccess = '<span data-toggle="tooltip" data-state="primary" data-placement="top" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-role_id="'. $r->role_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
			} else {
				$roleAccess = '<span data-toggle="tooltip" data-state="primary" data-placement="top" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-role_id="'. $r->role_id . '"><span class="fas fa-pencil-alt"></span></button></span><span data-toggle="tooltip" data-state="danger" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->role_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			}
			$data[] = array(
				$roleAccess,
				$r->role_id,
				$r->role_name,
				$r_access,
				$created_at
			);
		}
		$output = array(
			"draw" => $draw,
			"recordsTotal" => $role->num_rows(),
			"recordsFiltered" => $role->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function read() {
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('role_id');
		$result = $this->Roles_model->read_informasi_role($id);
		$data = array(
			'role_id' => $result[0]->role_id,
			'role_name' => $result[0]->role_name,
			'role_access' => $result[0]->role_access,
			'role_resources' => $result[0]->role_resources,
			'get_all_perusahaans' => $this->Umb_model->get_perusahaans(),
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/roles/dialog_role', $data);
		} else {
			redirect('admin/');
		}
	}

	public function add_role() {

		if($this->input->post('add_type')=='role') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			if($this->input->post('role_name')==='') {
				$Return['error'] = $this->lang->line('umb_role_error_role_name');
			} else if($this->input->post('role_access')==='') {
				$Return['error'] = $this->lang->line('umb_role_error_access');
			}
			$role_resources = implode(',',$this->input->post('role_resources'));

			if($Return['error']!=''){
				$this->output($Return);
			}
			$data = array(
				'role_name' => $this->input->post('role_name'),
				'role_access' => $this->input->post('role_access'),
				'role_resources' => $role_resources,
				'created_at' => date('d-m-Y'),
			);
			$result = $this->Roles_model->add($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_role_sukses_ditambahkan');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function update() {

		if($this->input->post('edit_type')=='role') {

			$id = $this->uri->segment(4);

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();

			if($this->input->post('role_name')==='') {
				$Return['error'] = $this->lang->line('umb_role_error_role_name');
			} else if($this->input->post('role_access')==='') {
				$Return['error'] = $this->lang->line('umb_role_error_access');
			}
			$role_resources = implode(',',$this->input->post('role_resources'));

			if($Return['error']!=''){
				$this->output($Return);
			}
			$data = array(
				'role_name' => $this->input->post('role_name'),
				'role_access' => $this->input->post('role_access'),
				'role_resources' => $role_resources,
			);
			$result = $this->Roles_model->update_record($data,$id);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_role_sukses_diperbarui');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function delete() {
		if($this->input->post('is_ajax')==2) {

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Roles_model->delete_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_role_sukses_dihapus');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}
}
