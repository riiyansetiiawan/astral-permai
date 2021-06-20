<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Department extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->database();
		$this->load->library('form_validation');
		
		$this->load->model("Department_model");
		$this->load->model("Location_model");
		$this->load->model("Umb_model");
	}
	
	public function output($Return=array()){
		
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		exit(json_encode($Return));
	}
	
	public function index() {
		$session = $this->session->userdata('username');
		if(!$session){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('umb_departments').' | '.$this->Umb_model->site_title();
		$data['all_locations'] = $this->Umb_model->all_locations();
		$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		$data['get_all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$session = $this->session->userdata('username');
		$data['breadcrumbs'] = $this->lang->line('umb_departments');
		$data['path_url'] = 'department';
		$role_resources_ids = $this->Umb_model->user_role_resource();

		if(in_array('3',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/department/list_department", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}

	public function sub_departments() {
		$session = $this->session->userdata('username');
		if(!$session){ 
			redirect('admin/');
		}
		$system = $this->Umb_model->read_setting_info(1);
		if($system[0]->is_active_sub_departments!='yes'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('umb_hr_sub_departments').' | '.$this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		$data['breadcrumbs'] = $this->lang->line('umb_hr_sub_departments');
		$data['all_departments'] = $this->Department_model->all_departments();
		$data['path_url'] = 'sub_department';
		$role_resources_ids = $this->Umb_model->user_role_resource();

		if(in_array('3',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/department/list_sub_department", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}

	public function list_sub_department() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/department/list_sub_department", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$role_resources_ids = $this->Umb_model->user_role_resource();
		$user_info = $this->Umb_model->read_user_info($session['user_id']);
		if($user_info[0]->user_role_id==1){
			$department = $this->Department_model->get_sub_departments();
		} else {
			$department = $this->Department_model->get_department_subdepartments($user_info[0]->department_id);
		}
		$data = array();

		foreach($department->result() as $r) {

			$dep = $this->Department_model->read_informasi_department($r->department_id);
			if(!is_null($dep)){
				$d_name = $dep[0]->nama_department;
			} else {
				$d_name = '--';	
			}
			
			if(in_array('241',$role_resources_ids)) {
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target="#edit-modal-data"  data-department_id="'. $r->sub_department_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('242',$role_resources_ids)) {
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->sub_department_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}
			$created_at = $this->Umb_model->set_date_format($r->created_at);
			$combhr = $edit.$delete;

			$data[] = array(
				$combhr,
				$r->nama_department,
				$d_name,
				$created_at
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $department->num_rows(),
			"recordsFiltered" => $department->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function list_department() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/department/list_department", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$role_resources_ids = $this->Umb_model->user_role_resource();
		$user_info = $this->Umb_model->read_user_info($session['user_id']);
		if($user_info[0]->user_role_id==1){
			$department = $this->Department_model->get_departments();
		} else {
			$department = $this->Department_model->get_perusahaan_departments($user_info[0]->perusahaan_id);
		}
		$data = array();

		foreach($department->result() as $r) {

			$head_user = $this->Umb_model->read_user_info($r->karyawan_id);
			
			if(!is_null($head_user)){
				$dep_head = $head_user[0]->first_name.' '.$head_user[0]->last_name;
			} else {
				$dep_head = '--';	
			}
			
			$perusahaan = $this->Umb_model->read_info_perusahaan($r->perusahaan_id);
			if(!is_null($perusahaan)){
				$prshn_nama = $perusahaan[0]->name;
			} else {
				$prshn_nama = '--';	
			}
			
			$location = $this->Location_model->read_informasi_location($r->location_id);
			if(!is_null($location)){
				$nama_location = $location[0]->nama_location;
			} else {
				$nama_location = '--';	
			}
			
			if(in_array('241',$role_resources_ids)) {
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target="#edit-modal-data"  data-department_id="'. $r->department_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('242',$role_resources_ids)) {
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->department_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}
			$ititle = $r->nama_department.'<br><small class="text-muted"><i>'.$this->lang->line('umb_department_head').': '.$dep_head.'<i></i></i></small>';
			$combhr = $edit.$delete;

			$data[] = array(
				$combhr,
				$ititle,
				$nama_location,
				$this->security->xss_clean($prshn_nama)
			);
		}
		$output = array(
			"draw" => $draw,
			"recordsTotal" => $department->num_rows(),
			"recordsFiltered" => $department->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}


	public function get_karyawans() {

		$data['title'] = $this->Umb_model->site_title();
		$keywords = preg_split("/[\s,]+/", $this->uri->segment(4));
		if(is_numeric($keywords[0])) {
			$id = $keywords[0];

			$data = array(
				'perusahaan_id' => $id
			);
			$session = $this->session->userdata('username');
			if(!empty($session)){ 
				$data = $this->security->xss_clean($data);
				$this->load->view("admin/department/get_karyawans", $data);
			} else {
				redirect('admin/');
			}
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}


	public function get_locations_perusahaan() {

		$data['title'] = $this->Umb_model->site_title();
		$keywords = preg_split("/[\s,]+/", $this->uri->segment(4));
		if(is_numeric($keywords[0])) {
			$id = $keywords[0];

			$data = array(
				'perusahaan_id' => $id
			);
			$session = $this->session->userdata('username');
			if(!empty($session)){ 
				$data = $this->security->xss_clean($data);
				$this->load->view("admin/department/get_locations_perusahaan", $data);
			} else {
				redirect('admin/');
			}
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}

	public function get_location_departments() {

		$data['title'] = $this->Umb_model->site_title();
		$keywords = preg_split("/[\s,]+/", $this->uri->segment(4));
		if(is_numeric($keywords[0])) {
			$id = $keywords[0];

			$data = array(
				'perusahaan_id' => $id
			);
			$session = $this->session->userdata('username');
			if(!empty($session)){ 
				$data = $this->security->xss_clean($data);
				$this->load->view("admin/department/get_locations_perusahaan", $data);
			} else {
				redirect('admin/');
			}
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}

	public function read() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$keywords = preg_split("/[\s,]+/", $this->input->get('department_id'));
		if(is_numeric($keywords[0])) {
			$id = $keywords[0];
			$id = $this->security->xss_clean($id);
			$result = $this->Department_model->read_informasi_department($id);
			$data = array(
				'department_id' => $result[0]->department_id,
				'location_id' => $result[0]->location_id,
				'nama_department' => $result[0]->nama_department,
				'perusahaan_id' => $result[0]->perusahaan_id,
				'karyawan_id' => $result[0]->karyawan_id,
				'all_locations' => $this->Umb_model->all_locations(),
				'all_karyawans' => $this->Umb_model->all_karyawans(),
				'get_all_perusahaans' => $this->Umb_model->get_perusahaans()
			);
			$session = $this->session->userdata('username');
			
			if(!empty($session)){ 
				$this->load->view('admin/department/dialog_department', $data);
			} else {
				redirect('admin/');
			}
		}
	}
	
	public function read_sub_record() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$keywords = preg_split("/[\s,]+/", $this->input->get('department_id'));
		if(is_numeric($keywords[0])) {
			$id = $keywords[0];
			$id = $this->security->xss_clean($id);
			$result = $this->Department_model->read_info_sub_department($id);
			$data = array(
				'sub_department_id' => $result[0]->sub_department_id,
				'department_id' => $result[0]->department_id,
				'nama_department' => $result[0]->nama_department,
			);
			$data['all_departments'] = $this->Department_model->all_departments();
			$session = $this->session->userdata('username');
			if(!empty($session)){ 
				$this->load->view('admin/department/dialog_sub_department', $data);
			} else {
				redirect('admin/');
			}
		}
	}

	
	public function add_sub_department() {

		if($this->input->post('add_type')=='department') {

			$session = $this->session->userdata('username');

			$this->form_validation->set_rules('nama_department', 'Nama Department', 'trim|required|xss_clean');

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();

			if($this->input->post('nama_department')==='') {
				$Return['error'] = $this->lang->line('umb_error_field_nama');
			} else if($this->input->post('department_id')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_department');
			}
			if($Return['error']!=''){

				$this->output($Return);
			}

			$data = array(
				'nama_department' => $this->input->post('nama_department'),
				'department_id' => $this->input->post('department_id'),
				'created_at' => date('Y-m-d H:i:s'),
			);

			$data = $this->security->xss_clean($data);
			$result = $this->Department_model->add_sub($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_hr_sub_department_ditambahkan');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	
	public function add_department() {

		if($this->input->post('add_type')=='department') {

			$session = $this->session->userdata('username');

			$this->form_validation->set_rules('nama_department', 'Nama Department', 'trim|required|xss_clean');
			$this->form_validation->set_rules('perusahaan_id', 'Perusahaan', 'trim|required|xss_clean');

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			//if($this->form_validation->run() == FALSE) {
				//$Return['error'] = 'validation error.';
			//}

			if($this->input->post('nama_department')==='') {
				$Return['error'] = $this->lang->line('error_field_department');
			} else if($this->input->post('perusahaan_id')==='') {
				$Return['error'] = $this->lang->line('error_field_perusahaan');
			} else if($this->input->post('location_id')==='') {
				$Return['error'] = $this->lang->line('umb_field_location_error');
			} 
			if($Return['error']!=''){

				$this->output($Return);
			}
			$data = array(
				'nama_department' => $this->input->post('nama_department'),
				'perusahaan_id' => $this->input->post('perusahaan_id'),
				'location_id' => $this->input->post('location_id'),
				'karyawan_id' => $this->input->post('karyawan_id'),
				'added_by' => $this->input->post('user_id'),
				'created_at' => date('Y-m-d H:i:s'),
			);

			$data = $this->security->xss_clean($data);
			$result = $this->Department_model->add($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_tambah_department');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	
	public function update() {

		if($this->input->post('edit_type')=='department') {
			
			$keywords = preg_split("/[\s,]+/", $this->uri->segment(4));
			if(is_numeric($keywords[0])) {
				$id = $keywords[0];
				// Check validation for user input
				$this->form_validation->set_rules('nama_department', 'Nama Department', 'trim|required|xss_clean');
				$this->form_validation->set_rules('location_id', 'location', 'trim|required|xss_clean');
				$this->form_validation->set_rules('karyawan_id', 'Karyawan', 'trim|required|xss_clean');

				$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
				$Return['csrf_hash'] = $this->security->get_csrf_hash();	

				if($this->input->post('nama_department')==='') {
					$Return['error'] = $this->lang->line('error_field_department');
				} else if($this->input->post('perusahaan_id')==='') {
					$Return['error'] = $this->lang->line('error_field_perusahaan');
				} else if($this->input->post('location_id')==='') {
					$Return['error'] = $this->lang->line('umb_field_location_error');
				} 

				if($Return['error']!=''){
					$this->output($Return);
				}

				$data = array(
					'nama_department' => $this->input->post('nama_department'),
					'perusahaan_id' => $this->input->post('perusahaan_id'),
					'location_id' => $this->input->post('location_id'),
					'karyawan_id' => $this->input->post('karyawan_id'),
				);
				$data = $this->security->xss_clean($data);
				$result = $this->Department_model->update_record($data,$id);		

				if ($result == TRUE) {
					$Return['result'] = $this->lang->line('umb_sukses_perbarui_department');
				} else {
					$Return['error'] = $this->lang->line('umb_error_msg');
				}
				$this->output($Return);
				exit;
			}
		}
	}
	
	
	public function update_record_sub() {

		if($this->input->post('edit_type')=='department') {
			

			$keywords = preg_split("/[\s,]+/", $this->uri->segment(4));
			if(is_numeric($keywords[0])) {
				$id = $keywords[0];

				$this->form_validation->set_rules('nama_department', 'Nama Department', 'trim|required|xss_clean');

				$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
				$Return['csrf_hash'] = $this->security->get_csrf_hash();	

				if($this->input->post('nama_department')==='') {
					$Return['error'] = $this->lang->line('error_field_department');
				} else if($this->input->post('department_id')==='') {
					$Return['error'] = $this->lang->line('umb_karyawan_error_department');
				}

				if($Return['error']!=''){
					$this->output($Return);
				}

				$data = array(
					'nama_department' => $this->input->post('nama_department'),
					'department_id' => $this->input->post('department_id'),
				);
				$data = $this->security->xss_clean($data);
				$result = $this->Department_model->update_record_sub($data,$id);		

				if ($result == TRUE) {
					$Return['result'] = $this->lang->line('umb_hr_sub_department_diperbarui');
				} else {
					$Return['error'] = $this->lang->line('umb_error_msg');
				}
				$this->output($Return);
				exit;
			}
		}
	}
	
	public function delete() {
		
		if($this->input->post('is_ajax')==2) {
			$session = $this->session->userdata('username');
			if(empty($session)){ 
				redirect('');
			}
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$keywords = preg_split("/[\s,]+/", $this->uri->segment(4));
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			if(is_numeric($keywords[0])) {
				$id = $keywords[0];
				$id = $this->security->xss_clean($id);
				$result = $this->Department_model->delete_record($id);
				if(isset($id)) {
					$Return['result'] = $this->lang->line('umb_sukses_hapus_department');
				} else {
					$Return['error'] = $this->lang->line('umb_error_msg');
				}
				$this->output($Return);
			}
		}
	}
	
	public function sub_delete() {
		
		if($this->input->post('is_ajax')==2) {
			$session = $this->session->userdata('username');
			if(empty($session)){ 
				redirect('');
			}
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$keywords = preg_split("/[\s,]+/", $this->uri->segment(4));
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			if(is_numeric($keywords[0])) {
				$id = $keywords[0];
				$id = $this->security->xss_clean($id);
				$result = $this->Department_model->delete_record_sub($id);
				if(isset($id)) {
					$Return['result'] = $this->lang->line('umb_hr_sub_department_dihapus');
				} else {
					$Return['error'] = $this->lang->line('umb_error_msg');
				}
				$this->output($Return);
			}
		}
	}
}
