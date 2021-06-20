<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Performance_indicator extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		
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
	
	public function index() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$system = $this->Umb_model->read_setting_info(1);
		if($system[0]->module_performance!='yes'){
			redirect('admin/dashboard');
		}
		/*if($system[0]->performance_option!='appraisal'){
			redirect('admin/tujuan_tracking');
		}*/
		$data['title'] = $this->lang->line('left_performance_indicator').' | '.$this->Umb_model->site_title();
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
		
		$role_resources_ids = $this->Umb_model->user_role_resource();
		$user_info = $this->Umb_model->read_user_info($session['user_id']);
		if($user_info[0]->user_role_id==1){
			$performance = $this->Performance_indicator_model->get_performance_indicator();
		} else {
			if(in_array('301',$role_resources_ids)) {
				$performance = $this->Performance_indicator_model->get_perusahaan_performance_indicator($user_info[0]->perusahaan_id);
			} else {
				$performance = $this->Performance_indicator_model->get_penunjukan_performance_indicator($user_info[0]->penunjukan_id);
			}
		}
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
			if(in_array('299',$role_resources_ids)) {
				$edit = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-performance_indicator_id="'. $r->performance_indicator_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('300',$role_resources_ids)) {
				$delete = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->performance_indicator_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}
			if(in_array('301',$role_resources_ids)) {
				$view = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light view-data" data-toggle="modal" data-target=".view-modal-data-bg" data-p_indicator_id="'. $r->performance_indicator_id . '"><span class="fa fa-eye"></span></button></span>';
			} else {
				$view = '';
			}
			$combhr = $edit.$view.$delete;

			$data[] = array(
				$combhr,
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

	public function read() {

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

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();

			if($this->input->post('perusahaan_id')==='') {
				$Return['error'] = $this->lang->line('error_field_perusahaan');
			} else if($this->input->post('penunjukan_id')==='') {
				$Return['error'] = $this->lang->line('umb_error_field_penunjukan');
			}

			if($Return['error']!=''){
				$this->output($Return);
			}

			$data = array(
				'perusahaan_id' => $this->input->post('perusahaan_id'),
				'penunjukan_id' => $this->input->post('penunjukan_id'),
				'added_by' => $this->input->post('user_id'),
				'created_at' => date('d-m-Y'),

			);
			$result = $this->Performance_indicator_model->add($data);
			if ($result) {
				foreach($this->input->post('technical_competencies_value') as $key=>$tech_value){
					$data_opt = array(
						'indicator_id' => $result,
						'indicator_type' => 'technical',
						'indicator_option_id' => $key,
						'indicator_option_value' => $tech_value,
					);
					$this->Performance_indicator_model->add_indicator_options($data_opt);
				}
				foreach($this->input->post('organizational_competencies_value') as $ikey=>$org_value){
					$data_opt2 = array(
						'indicator_id' => $result,
						'indicator_type' => 'organizational',
						'indicator_option_id' => $ikey,
						'indicator_option_value' => $org_value,
					);
					$this->Performance_indicator_model->add_indicator_options($data_opt2);
				}
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

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();

			if($this->input->post('perusahaan_id')==='') {
				$Return['error'] = $this->lang->line('error_field_perusahaan');
			} else if($this->input->post('penunjukan_id')==='') {
				$Return['error'] = $this->lang->line('umb_error_field_penunjukan');
			}

			if($Return['error']!=''){
				$this->output($Return);
			}

			$data = array(
				'perusahaan_id' => $this->input->post('perusahaan_id'),
				'penunjukan_id' => $this->input->post('penunjukan_id'),
			);

			$result = $this->Performance_indicator_model->update_record($data,$id);		

			if ($result == TRUE) {
				foreach($this->input->post('technical_competencies_value') as $key=>$tech_value){
					$row_technical = $this->Performance_indicator_model->read_indicator_technical_options_available($key,$id);
					if($row_technical > 0){
						$data_opt = array(
							'indicator_option_value' => $tech_value,
						);
						$this->Performance_indicator_model->update_indicator_technical_record($key,$data_opt,$id);
					} else {
						$data_opt = array(
							'indicator_id' => $id,
							'indicator_type' => 'technical',
							'indicator_option_id' => $key,
							'indicator_option_value' => $tech_value,
						);
						$this->Performance_indicator_model->add_indicator_options($data_opt);
					}
				}
				foreach($this->input->post('organizational_competencies_value') as $ikey=>$org_value){
					$row_organization = $this->Performance_indicator_model->read_indicator_organizational_options_available($ikey,$id);
					if($row_organization > 0){
						$data_org = array(
							'indicator_option_value' => $org_value,
						);
						$this->Performance_indicator_model->update_record_indicator_organizational($ikey,$data_org,$id);
					} else {
						$data_org = array(
							'indicator_id' => $id,
							'indicator_type' => 'organizational',
							'indicator_option_id' => $ikey,
							'indicator_option_value' => $org_value,
						);
						$this->Performance_indicator_model->add_indicator_options($data_org);
					}

				}
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

		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$result = $this->Performance_indicator_model->delete_record($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('umb_sukses_performance_dihapus');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
	}
}
