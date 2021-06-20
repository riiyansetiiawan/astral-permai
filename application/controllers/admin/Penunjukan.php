<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Penunjukan extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		
		$this->load->model("Penunjukan_model");
		$this->load->model("Umb_model");
		$this->load->model("Department_model");
		$this->load->model("Perusahaan_model");
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
		$data['title'] = $this->lang->line('umb_penunjukans').' | '.$this->Umb_model->site_title();
		$data['all_departments'] = $this->Department_model->all_departments();
		$data['get_all_perusahaans'] = $this->Umb_model->get_perusahaans();
		//$data['all_penunjukans'] = $this->Penunjukan_model->all_penunjukans();
		$data['breadcrumbs'] = $this->lang->line('umb_penunjukans');
		$data['path_url'] = 'penunjukan';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('4',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/penunjukan/list_penunjukan", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 		  
		} else {
			redirect('admin/dashboard');
		}
	}

	public function list_penunjukan() {

		$session = $this->session->userdata('username');
		$data['title'] = $this->Umb_model->site_title();
		if(!empty($session)){ 
			$this->load->view("admin/penunjukan/list_penunjukan", $data);
		} else {
			redirect('admin/');
		}
		$system = $this->Umb_model->read_setting_info(1);
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$role_resources_ids = $this->Umb_model->user_role_resource();
		$user_info = $this->Umb_model->read_user_info($session['user_id']);
		if($user_info[0]->user_role_id==1){
			$penunjukan = $this->Penunjukan_model->get_penunjukans();
		} else {
			$penunjukan = $this->Penunjukan_model->get_penunjukans_perusahaan($user_info[0]->perusahaan_id);
		}
		$data = array();

		foreach($penunjukan->result() as $r) {

			$department = $this->Department_model->read_informasi_department($r->department_id);
			if(!is_null($department)){
				$nama_department = $department[0]->nama_department;
			} else {
				$nama_department = '--';	
			}
			if($system[0]->is_active_sub_departments=='yes'){
				$subdepartment = $this->Department_model->read_info_sub_department($r->sub_department_id);
				if(!is_null($subdepartment)){
					$nama_subdep = $subdepartment[0]->nama_department;
					$nama_subdep = '<br><small class="text-muted"><i>'.$this->lang->line('umb_hr_sub_department').': '.$nama_subdep.'<i></i></i></small>';
				} else {
					$nama_subdep = '<br><small class="text-muted"><i>'.$this->lang->line('umb_hr_sub_department').': --<i></i></i></small>';	
				}
			} else {
				$nama_subdep ='';
			}
			$perusahaan = $this->Umb_model->read_info_perusahaan($r->perusahaan_id);
			if(!is_null($perusahaan)){
				$prshn_nama = $perusahaan[0]->name;
			} else {
				$prshn_nama = '--';	
			}
			if(in_array('244',$role_resources_ids)) {
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target="#edit-modal-data"  data-penunjukan_id="'. $r->penunjukan_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('245',$role_resources_ids)) {
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->penunjukan_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}
			
			$combhr = $edit.$delete;
			$inama_penunjukan = $r->nama_penunjukan.'<br><small class="text-muted"><i>'.$this->lang->line('umb_department').': '.$nama_department.'<i></i></i></small>'.$nama_subdep.'';

			$data[] = array(
				$combhr,
				$inama_penunjukan,
				$prshn_nama
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $penunjukan->num_rows(),
			"recordsFiltered" => $penunjukan->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function read() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('penunjukan_id');
		$result = $this->Penunjukan_model->read_informasi_penunjukan($id);
		$data = array(
			'penunjukan_id' => $result[0]->penunjukan_id,
			'perusahaan_id' => $result[0]->perusahaan_id,
			'department_id' => $result[0]->department_id,
			'sub_department_id' => $result[0]->sub_department_id,
			'nama_penunjukan' => $result[0]->nama_penunjukan,
			'description' => $result[0]->description,
			'get_all_perusahaans' => $this->Umb_model->get_perusahaans(),
			'all_departments' => $this->Department_model->all_departments()
		);
		if(!empty($session)){ 
			$this->load->view('admin/penunjukan/dialog_penunjukan', $data);
		} else {
			redirect('admin/');
		}
	}
	
	public function get_departments() {

		$data['title'] = $this->Umb_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'perusahaan_id' => $id
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/penunjukan/get_departments", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}

	public function get_model_departments() {

		$data['title'] = $this->Umb_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'perusahaan_id' => $id
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/penunjukan/get_model_departments", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}

	public function get_sub_departments() {

		$data['title'] = $this->Umb_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'department_id' => $id
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/penunjukan/get_subdepartments", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}

	public function get_modal_sub_departments() {

		$data['title'] = $this->Umb_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'department_id' => $id
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/penunjukan/get_subdepartments", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}

	public function top_penunjukan() {

		$data['title'] = $this->Umb_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'department_id' => $id,
			'all_penunjukans' => $this->Penunjukan_model->all_penunjukans(),
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/penunjukan/get_penunjukans", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}
	
	public function add_penunjukan() {

		if($this->input->post('add_type')=='penunjukan') {
			// Check validation for user input
			$this->form_validation->set_rules('department_id', 'Department', 'trim|required|xss_clean');
			$this->form_validation->set_rules('nama_penunjukan', 'Penunjukan', 'trim|required|xss_clean');

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$system = $this->Umb_model->read_setting_info(1);

			if($this->input->post('perusahaan_id')==='') {
				$Return['error'] = $this->lang->line('error_field_perusahaan');
			} else if($this->input->post('department_id')==='') {
				$Return['error'] = $this->lang->line('error_field_department');
			} else if($this->input->post('subdepartment_id')==='') {
				$Return['error'] = $this->lang->line('umb_hr_field_sub_department_error');
			} else if($this->input->post('nama_penunjukan')==='') {
				$Return['error'] = $this->lang->line('error_field_penunjukan');
			} else if($this->input->post('description')==='') {
				$Return['error'] = $this->lang->line('umb_error_description_file_tugas');
			}

			if($Return['error']!=''){
				$this->output($Return);
			}
			$data = array(
				'department_id' => $this->input->post('department_id'),
				'sub_department_id' => $this->input->post('subdepartment_id'),
				'perusahaan_id' => $this->input->post('perusahaan_id'),
				'nama_penunjukan' => $this->input->post('nama_penunjukan'),
				'description' => $this->input->post('description'),
				'added_by' => $this->input->post('user_id'),
				'created_at' => date('d-m-Y'),
			);
			$result = $this->Penunjukan_model->add($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_tambah_penunjukan');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	
	public function update() {

		if($this->input->post('edit_type')=='penunjukan') {
			
			$id = $this->uri->segment(4);

			$this->form_validation->set_rules('department_id', 'Department', 'trim|required|xss_clean');
			$this->form_validation->set_rules('nama_penunjukan', 'Penunjukan', 'trim|required|xss_clean');

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$system = $this->Umb_model->read_setting_info(1);

			if($this->input->post('perusahaan_id')==='') {
				$Return['error'] = $this->lang->line('error_field_perusahaan');
			} else if($this->input->post('department_id')==='') {
				$Return['error'] = $this->lang->line('error_field_department');
			} else if($this->input->post('subdepartment_id')==='') {
				$Return['error'] = $this->lang->line('umb_hr_field_sub_department_error');
			} else if($this->input->post('nama_penunjukan')==='') {
				$Return['error'] = $this->lang->line('error_field_penunjukan');
			} else if($this->input->post('description')==='') {
				$Return['error'] = $this->lang->line('umb_error_description_file_tugas');
			} 

			if($Return['error']!=''){
				$this->output($Return);
			}
			$data = array(
				'department_id' => $this->input->post('department_id'),
				'sub_department_id' => $this->input->post('subdepartment_id'),
				'perusahaan_id' => $this->input->post('perusahaan_id'),
				'nama_penunjukan' => $this->input->post('nama_penunjukan'),
				'description' => $this->input->post('description'),		
			);
			$result = $this->Penunjukan_model->update_record($data,$id);		

			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_perbarui_penunjukan');
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
			$result = $this->Penunjukan_model->delete_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_sukses_hapus_penunjukan');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}
}
