<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Performance_indicator extends MY_Controller {

	public function __construct() {

		Parent::__construct();

		$this->load->model("Performance_indicator_model");
		$this->load->model("Umb_model");
		$this->load->model("Penunjukan_model");
		$this->load->model("Department_model");
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
		if($system[0]->module_performance!='true'){
			redirect('admin/dashboard');

		}
		$data['title'] = $this->lang->line('left_performance_indicator');
		$data['all_penunjukans'] = $this->Penunjukan_model->all_penunjukans();
		$data['get_all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$data['breadcrumbs'] = $this->lang->line('left_performance_indicator');
		$data['path_url'] = 'performance_indicator';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('41',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/performance/list_performance_indicator", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}

	public function get_penunjukans() {

		$data['title'] = $this->Umb_model->site_title();
		$id = $this->uri->segment(4);
		$data = array(
			'perusahaan_id' => $id
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/performance/get_penunjukans", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}

	public function list_performance_indicator() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/performance/list_performance_indicator", $data);
		} else {
			redirect('admin/');
		}

		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$performance = $this->Performance_indicator_model->get_performance_indicator();
		$data = array();
		foreach($performance->result() as $r) {
			$created_at = $this->Umb_model->set_date_format($r->created_at);
			$user = $this->Umb_model->read_user_info($r->added_by);
			if(!is_null($user)){
				$full_name = $user[0]->first_name.' '.$user[0]->last_name;
			} else {
				$full_name = '--';	
			}
			$perusahaan = $this->Umb_model->read_info_perusahaan($r->perusahaan_id);
			if(!is_null($perusahaan)){
				$prshn_nama = $perusahaan[0]->name;
			} else {
				$prshn_nama = '--';	

			}
			$penunjukan = $this->Penunjukan_model->read_informasi_penunjukan($r->penunjukan_id);
			if(!is_null($penunjukan)){
				$ides = $penunjukan[0]->nama_penunjukan;
				$idepartment = $this->Department_model->read_informasi_department($penunjukan[0]->department_id);
				if(!is_null($idepartment)){
					$department = $idepartment[0]->nama_department;
				} else {
					$department = '--';

				}
			} else {
				$department = '--';	
				$ides = '--';

			}
			if(!is_null($user)){
				$full_name = $user[0]->first_name.' '.$user[0]->last_name;
			} else {
				$full_name = '--';	

			}
			$data[] = array(
				'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_view').'"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light view-data" data-toggle="modal" data-target=".view-modal-data-bg" data-p_indicator_id="'. $r->performance_indicator_id . '"><i class="fa fa-eye"></i></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-performance_indicator_id="'. $r->performance_indicator_id . '"><i class="fa fa-pencil-square-o"></i></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn btn-danger btn-sm m-b-0-0 waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->performance_indicator_id . '"><i class="fa fa-trash-o"></i></button></span>',

				$ides,
				$prshn_nama,
				$department,
				$full_name,
				$created_at
			);
		}
		$output = array(
			"draw" => $draw,
			"recordsTotal" => $performance->num_rows(),
			"recordsFiltered" => $performance->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function read(){

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('performance_indicator_id');
		$result = $this->Performance_indicator_model->read_informasi_performance_indicator($id);
		$data = array(
			'performance_indicator_id' => $result[0]->performance_indicator_id,
			'perusahaan_id' => $result[0]->perusahaan_id,
			'penunjukan_id' => $result[0]->penunjukan_id,
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
			'all_penunjukans' => $this->Penunjukan_model->all_penunjukans(),
			'get_all_perusahaans' => $this->Umb_model->get_perusahaans()
		);

		if(!empty($session)){ 
			$this->load->view('admin/performance/dialog_indicator', $data);
		} else {
			redirect('admin/');
		}
	}

	public function add_indicator() {

		if($this->input->post('add_type')=='indicator') {
			$Return = array('result'=>'', 'error'=>'');
			if($this->input->post('perusahaan_id')==='') {
				$Return['error'] = $this->lang->line('error_field_perusahaan');
			} else if($this->input->post('penunjukan_id')==='') {
				$Return['error'] = $this->lang->line('umb_error_field_penunjukan');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$data = array(
				'customer_pengalaman' => $this->input->post('customer_pengalaman'),
				'perusahaan_id' => $this->input->post('perusahaan_id'),
				'marketing' => $this->input->post('marketing'),
				'penunjukan_id' => $this->input->post('penunjukan_id'),
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
			$result = $this->Performance_indicator_model->add($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_performance_ditambahkan');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function update() {

		if($this->input->post('edit_type')=='indicator') {
			$id = $this->uri->segment(4);
			$Return = array('result'=>'', 'error'=>'');
			if($this->input->post('perusahaan_id')==='') {
				$Return['error'] = $this->lang->line('error_field_perusahaan');
			} else if($this->input->post('penunjukan_id')==='') {
				$Return['error'] = $this->lang->line('umb_error_field_penunjukan');

			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$data = array(
				'customer_pengalaman' => $this->input->post('customer_pengalaman'),
				'perusahaan_id' => $this->input->post('perusahaan_id'),
				'marketing' => $this->input->post('marketing'),
				'penunjukan_id' => $this->input->post('penunjukan_id'),
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
			$result = $this->Performance_indicator_model->update_record($data,$id);		
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_performance_diperbarui');
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
		$Return = array('result'=>'', 'error'=>'');
		$id = $this->uri->segment(4);
		$result = $this->Performance_indicator_model->delete_record($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('umb_sukses_performance_dihapus');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);

	}

}

