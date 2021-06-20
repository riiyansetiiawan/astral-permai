<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Performance_appraisal extends MY_Controller {
	
	public function __construct() {
		Parent::__construct();
		
		$this->load->model("Performance_appraisal_model");
		$this->load->model("Umb_model");
		$this->load->model("Penunjukan_model");
		$this->load->model("Department_model");
	}
	
	
	public function output($Return=array()){
		
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		
		exit(json_encode($Return));
	}
	
	public function index()
	{
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$system = $this->Umb_model->read_setting_info(1);
		if($system[0]->module_performance!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('left_performance_appraisal');
		$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		$data['get_all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$data['breadcrumbs'] = $this->lang->line('left_performance_appraisal');
		$data['path_url'] = 'performance_appraisal';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('42',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/performance/list_performance_appraisal", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}
	
	public function list_appraisal()
	{

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/performance/list_performance_appraisal", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$appraisal = $this->Performance_appraisal_model->get_performance_appraisal();
		
		$data = array();

		foreach($appraisal->result() as $r) {
			
			
			$user = $this->Umb_model->read_user_info($r->karyawan_id);
			
			if(!is_null($user)){
				
				$full_name = $user[0]->first_name.' '.$user[0]->last_name;
				// department
				$department = $this->Department_model->read_informasi_department($user[0]->department_id);
				if(!is_null($department)){
					$nama_department = $department[0]->nama_department;
				} else {
					$nama_department = '--';
				}
				// get designation
				$penunjukan = $this->Penunjukan_model->read_informasi_penunjukan($user[0]->penunjukan_id);
				if(!is_null($penunjukan)){
					$nama_penunjukan = $penunjukan[0]->nama_penunjukan;
				} else {
					$nama_penunjukan = '--';
				}
			} else {
				$full_name = '--';
				$nama_penunjukan = '--';
				$nama_department = '--';
			}		
			
		 // appraisal month/year
			$d = explode('-',$r->appraisal_year_month);
			$get_month = date('F', mktime(0, 0, 0, $d[1], 10));
			$ap_date = $get_month.', '.$d[0];
		// get perusahaan
			$perusahaan = $this->Umb_model->read_info_perusahaan($r->perusahaan_id);
			if(!is_null($perusahaan)){
				$prshn_nama = $perusahaan[0]->name;
			} else {
				$prshn_nama = '--';	
			}
			
			$data[] = array(
				'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_view').'"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light view-data" data-toggle="modal" data-target=".view-modal-data-bg" data-p_appraisal_id="'. $r->performance_appraisal_id . '"><i class="fa fa-eye"></i></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-performance_appraisal_id="'. $r->performance_appraisal_id . '"><i class="fa fa-pencil-square-o"></i></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn btn-danger btn-sm m-b-0-0 waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->performance_appraisal_id . '"><i class="fa fa-trash-o"></i></button></span>',
				$prshn_nama,
				$full_name,
				$nama_penunjukan,
				$nama_department,
				$ap_date
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $appraisal->num_rows(),
			"recordsFiltered" => $appraisal->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}
	
	
	public function get_karyawans() {

		$data['title'] = $this->Umb_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'perusahaan_id' => $id
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/performance/get_karyawans", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}
	
	public function read() {
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('performance_appraisal_id');
		$result = $this->Performance_appraisal_model->read_informasi_appraisal($id);
		$data = array(
			'performance_appraisal_id' => $result[0]->performance_appraisal_id,
			'karyawan_id' => $result[0]->karyawan_id,
			'perusahaan_id' => $result[0]->perusahaan_id,
			'appraisal_year_month' => $result[0]->appraisal_year_month,
			'customer_pengalaman' => $result[0]->customer_pengalaman,
			'marketing' => $result[0]->marketing,
			'management' => $result[0]->management,
			'administration' => $result[0]->administration,
			'presentation_skill' => $result[0]->presentation_skill,
			'quality_of_work' => $result[0]->quality_of_work,
			'efficiency' => $result[0]->efficiency,
			'integrity' => $result[0]->integrity,
			'professionalism' => $result[0]->professionalism,
			'team_work' => $result[0]->team_work,
			'critical_thinking' => $result[0]->critical_thinking,
			'conflict_management' => $result[0]->conflict_management,
			'kehadiran' => $result[0]->kehadiran,
			'ability_to_meet_deadline' => $result[0]->ability_to_meet_deadline,
			'remarks' => $result[0]->remarks,
			'get_all_perusahaans' => $this->Umb_model->get_perusahaans(),
			'all_karyawans' => $this->Umb_model->all_karyawans()
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/performance/dialog_appraisal', $data);
		} else {
			redirect('admin/');
		}
	}
	
	
	public function add_appraisal() {
		
		if($this->input->post('add_type')=='appraisal') {		
			
			$Return = array('result'=>'', 'error'=>'');
			
			
			$remarks = $this->input->post('remarks');
			$qt_remarks = htmlspecialchars(addslashes($remarks), ENT_QUOTES);
			
			if($this->input->post('perusahaan_id')==='') {
				$Return['error'] = $this->lang->line('error_field_perusahaan');
			} else if($this->input->post('karyawan_id')==='') {
				$Return['error'] = $this->lang->line('umb_error_karyawan_id');
			} else if($this->input->post('month_year')==='') {
				$Return['error'] = $this->lang->line('umb_error_performance_app_month_year');
			}
			
			if($Return['error']!=''){
				$this->output($Return);
			}
			
			$data = array(
				'karyawan_id' => $this->input->post('karyawan_id'),
				'perusahaan_id' => $this->input->post('perusahaan_id'),
				'appraisal_year_month' => $this->input->post('month_year'),
				'customer_pengalaman' => $this->input->post('customer_pengalaman'),
				'remarks' => $qt_remarks,
				'marketing' => $this->input->post('marketing'),
				'management' => $this->input->post('management'),
				'administration' => $this->input->post('administration'),
				'presentation_skill' => $this->input->post('presentation_skill'),
				'quality_of_work' => $this->input->post('quality_of_work'),
				'efficiency' => $this->input->post('efficiency'),
				'integrity' => $this->input->post('integrity'),
				'professionalism' => $this->input->post('professionalism'),
				'team_work' => $this->input->post('team_work'),
				'critical_thinking' => $this->input->post('critical_thinking'),
				'conflict_management' => $this->input->post('conflict_management'),
				'kehadiran' => $this->input->post('kehadiran'),
				'ability_to_meet_deadline' => $this->input->post('ability_to_meet_deadline'),
				'added_by' => $this->input->post('user_id'),
				'created_at' => date('d-m-Y'),
			);
			$result = $this->Performance_appraisal_model->add($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_performance_app_ditambahkan');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	
	public function update() {
		
		if($this->input->post('edit_type')=='appraisal') {
			
			$id = $this->uri->segment(4);
			
			
			$Return = array('result'=>'', 'error'=>'');
			
			
			$remarks = $this->input->post('remarks');
			$qt_remarks = htmlspecialchars(addslashes($remarks), ENT_QUOTES);
			
			if($this->input->post('perusahaan_id')==='') {
				$Return['error'] = $this->lang->line('error_field_perusahaan');
			} else if($this->input->post('karyawan_id')==='') {
				$Return['error'] = $this->lang->line('umb_error_karyawan_id');
			} else if($this->input->post('month_year')==='') {
				$Return['error'] = $this->lang->line('umb_error_performance_app_month_year');
			}
			
			if($Return['error']!=''){
				$this->output($Return);
			}
			
			$data = array(
				'karyawan_id' => $this->input->post('karyawan_id'),
				'perusahaan_id' => $this->input->post('perusahaan_id'),
				'appraisal_year_month' => $this->input->post('month_year'),
				'customer_pengalaman' => $this->input->post('customer_pengalaman'),
				'remarks' => $qt_remarks,
				'marketing' => $this->input->post('marketing'),
				'management' => $this->input->post('management'),
				'administration' => $this->input->post('administration'),
				'presentation_skill' => $this->input->post('presentation_skill'),
				'quality_of_work' => $this->input->post('quality_of_work'),
				'efficiency' => $this->input->post('efficiency'),
				'integrity' => $this->input->post('integrity'),
				'professionalism' => $this->input->post('professionalism'),
				'team_work' => $this->input->post('team_work'),
				'critical_thinking' => $this->input->post('critical_thinking'),
				'conflict_management' => $this->input->post('conflict_management'),
				'kehadiran' => $this->input->post('kehadiran'),
				'ability_to_meet_deadline' => $this->input->post('ability_to_meet_deadline')
			);
			
			$result = $this->Performance_appraisal_model->update_record($data,$id);		
			
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_performance_app_diperbarui');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function delete() {
		
		$Return = array('result'=>'', 'error'=>'');
		$id = $this->uri->segment(4);
		$result = $this->Performance_appraisal_model->delete_record($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('umb_sukses_performance_app_dihapus');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
	}
}
