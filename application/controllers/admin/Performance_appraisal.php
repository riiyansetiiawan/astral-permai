<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Performance_appraisal extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		
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
		$data['title'] = $this->lang->line('left_performance_appraisal').' | '.$this->Umb_model->site_title();
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
	
	public function list_appraisal() {

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
		
		$role_resources_ids = $this->Umb_model->user_role_resource();
		$user_info = $this->Umb_model->read_user_info($session['user_id']);
		if($user_info[0]->user_role_id==1){
			$appraisal = $this->Performance_appraisal_model->get_performance_appraisal();
		} else {
			if(in_array('305',$role_resources_ids)) {
				$appraisal = $this->Performance_appraisal_model->get_perusahaan_performance_appraisal($user_info[0]->perusahaan_id);
			} else {
				$appraisal = $this->Performance_appraisal_model->get_karyawan_performance_appraisal($session['user_id']);
			}
		}
		$data = array();

		foreach($appraisal->result() as $r) {
			
			
			$user = $this->Umb_model->read_user_info($r->karyawan_id);
			
			if(!is_null($user)){
				
				$full_name = $user[0]->first_name.' '.$user[0]->last_name;

				$department = $this->Department_model->read_informasi_department($user[0]->department_id);
				if(!is_null($department)){
					$nama_department = $department[0]->nama_department;
				} else {
					$nama_department = '--';
				}
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
			$d = explode('-',$r->appraisal_year_month);
			$get_month = date('F', mktime(0, 0, 0, $d[1], 10));
			$ap_date = $get_month.', '.$d[0];
			$perusahaan = $this->Umb_model->read_info_perusahaan($r->perusahaan_id);
			if(!is_null($perusahaan)){
				$prshn_nama = $perusahaan[0]->name;
			} else {
				$prshn_nama = '--';	
			}
			
			if(in_array('303',$role_resources_ids)) {
				$edit = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-performance_appraisal_id="'. $r->performance_appraisal_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('304',$role_resources_ids)) { 
				$delete = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->performance_appraisal_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}
			if(in_array('305',$role_resources_ids)) {
				$view = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light view-data" data-toggle="modal" data-target=".view-modal-data-bg" data-p_appraisal_id="'. $r->performance_appraisal_id . '"><span class="fa fa-eye"></span></button></span>';
			} else {
				$view = '';
			}
			$combhr = $edit.$view.$delete;

			$data[] = array(
				$combhr,
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

		/*echo '<pre>'; print_r($this->input->post('technical_competencies_value'));
		echo '<pre>'; print_r($this->input->post('organizational_competencies_value'));
		exit;*/
		if($this->input->post('add_type')=='appraisal') {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
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
				'remarks' => $qt_remarks,
				'added_by' => $this->input->post('user_id'),
				'created_at' => date('d-m-Y'),
			);
			$result = $this->Performance_appraisal_model->add($data);
			if ($result) {
				foreach($this->input->post('technical_competencies_value') as $key=>$tech_value){
					$data_opt = array(
						'appraisal_id' => $result,
						'appraisal_type' => 'technical',
						'appraisal_option_id' => $key,
						'appraisal_option_value' => $tech_value,
					);
					$this->Performance_appraisal_model->add_appraisal_options($data_opt);
				}
				foreach($this->input->post('organizational_competencies_value') as $ikey=>$org_value){
					$data_opt2 = array(
						'appraisal_id' => $result,
						'appraisal_type' => 'organizational',
						'appraisal_option_id' => $ikey,
						'appraisal_option_value' => $org_value,
					);
					$this->Performance_appraisal_model->add_appraisal_options($data_opt2);
				}
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
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
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
				'remarks' => $qt_remarks,
			);
			
			$result = $this->Performance_appraisal_model->update_record($data,$id);		
			
			if ($result == TRUE) {
				foreach($this->input->post('technical_competencies_value') as $key=>$tech_value){
					$row_technical = $this->Performance_appraisal_model->read_appraisal_technical_options_available($key,$id);
					if($row_technical > 0){
						$data_opt = array(
							'appraisal_option_value' => $tech_value,
						);
						$this->Performance_appraisal_model->update_record_appraisal_technical($key,$data_opt,$id);
					} else {
						$data_opt = array(
							'appraisal_id' => $id,
							'appraisal_type' => 'technical',
							'appraisal_option_id' => $key,
							'appraisal_option_value' => $tech_value,
						);
						$this->Performance_appraisal_model->add_appraisal_options($data_opt);
					}
				}
				foreach($this->input->post('organizational_competencies_value') as $ikey=>$org_value){
					$row_organization = $this->Performance_appraisal_model->read_appraisal_organizational_options_available($ikey,$id);
					if($row_organization > 0){
						$data_org = array(
							'appraisal_option_value' => $org_value,
						);
						$this->Performance_appraisal_model->update_record_appraisal_organizational($ikey,$data_org,$id);
					} else {
						$data_org = array(
							'appraisal_id' => $id,
							'appraisal_type' => 'organizational',
							'appraisal_option_id' => $ikey,
							'appraisal_option_value' => $org_value,
						);
						$this->Performance_appraisal_model->add_appraisal_options($data_org);
					}
				}
				$Return['result'] = $this->lang->line('umb_sukses_performance_app_diperbarui');
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
		$result = $this->Performance_appraisal_model->delete_record($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('umb_sukses_performance_app_dihapus');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
	}
}
