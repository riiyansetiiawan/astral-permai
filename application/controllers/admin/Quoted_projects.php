<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Quoted_projects extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		
		$this->load->model("Project_model");
		$this->load->model("Umb_model");
		$this->load->model("Perusahaan_model");
		$this->load->model("Department_model");
		$this->load->model("Penunjukan_model");
		$this->load->model("Timesheet_model");
		$this->load->model("Clients_model");
		$this->load->model("Quoted_project_model");
		$this->load->library('email');
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
		if($system[0]->module_projects_tugass!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('umb_quoted_projects').' | '.$this->Umb_model->site_title();
		$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		$data['all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$data['all_clients'] = $this->Clients_model->get_all_clients();
		$data['breadcrumbs'] = $this->lang->line('umb_quoted_projects');
		$data['path_url'] = 'quoted_project';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('428',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/quoted_projects/list_project", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}	  
	}

	public function timelogs() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$system = $this->Umb_model->read_setting_info(1);
		if($system[0]->module_projects_tugass!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('umb_project_timelogs').' | '.$this->Umb_model->site_title();
		$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		$data['all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$data['all_projects'] = $this->Quoted_project_model->get_all_projects();
		$data['all_clients'] = $this->Clients_model->get_all_clients();
		$data['breadcrumbs'] = $this->lang->line('umb_project_timelogs');
		$data['path_url'] = 'quoted_project_timelogs';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('44',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/quoted_projects/list_project_timelogs", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}	  
	}
	
	public function quote_calendar() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('umb_quote_calendar');
		$data['breadcrumbs'] = $this->lang->line('umb_quote_calendar');
		$data['estimates_all'] = $this->Quoted_project_model->get_estimates_all();
		$data['leads_follow_up_all'] = $this->Quoted_project_model->get_leads_follow_up_all();
		$data['path_url'] = 'calendar_projects';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('44',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/quoted_projects/quote_calendar", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
		} else {
			redirect('admin/dashboard');
		}
	}
	
	public function get_karyawans() {

		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get("cid");
		//$this->uri->segment(4);
		
		$data = array(
			'perusahaan_id' => $id
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/quoted_projects/get_karyawans", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	} 

	public function get_project_karyawans() {

		$data['title'] = $this->Umb_model->site_title();
		$id = $this->uri->segment(4);
		$result = $this->Quoted_project_model->read_informasi_project($id);
		if(is_null($result)){
			redirect('admin/quoted_projects/timelogs');
		}
		$data = array(
			'project_id' => $id,
			'assigned_to' => $result[0]->assigned_to,
			'perusahaan_id' => $result[0]->perusahaan_id
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/quoted_projects/get_project_karyawans", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}

	public function detail() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$system = $this->Umb_model->read_setting_info(1);
		/*if($system[0]->module_projects_tugass!='true'){
			redirect('admin/dashboard');
		}*/
		/*$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('318',$role_resources_ids)) { //view
			redirect('admin/project');
		}*/
		$data['title'] = $this->Umb_model->site_title();
		//$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		//$data['all_perusahaans'] = $this->Umb_model->get_perusahaans();
		//$data['breadcrumbs'] = $this->lang->line('umb_project_detail');
		$id = $this->uri->segment(4);
		$result = $this->Quoted_project_model->read_informasi_project($id);
		if(is_null($result)){
			redirect('admin/quoted_projects');
		}
		$edata = array(
			'is_notify' => 0,
		);
		$this->Quoted_project_model->update_record($edata,$id);
		
		$user = $this->Umb_model->read_user_info($result[0]->added_by);
		
		if(!is_null($user)){
			$full_name = $user[0]->first_name.' '.$user[0]->last_name;
		} else {
			$full_name = '--';	
		}
		$result2 = $this->Clients_model->read_info_client($result[0]->client_id);
		if(!is_null($result2)) {
			$name_client = $result2[0]->name;
		} else {
			$name_client = '--';
		}
		
		$data = array(
			'breadcrumbs' => $this->lang->line('umb_quoted_details_project'),
			'project_id' => $result[0]->project_id,
			'title' => $result[0]->title . ' | '. $this->lang->line('umb_quoted_details_project'),
			'catatan_project' => $result[0]->catatan_project,
			'summary' => $result[0]->summary,
			'client_id' => $result[0]->client_id,
			'name_client' => $name_client,
			'estimate_date' => $result[0]->estimate_date,
			'perusahaan_id' => $result[0]->perusahaan_id,
			'assigned_to' => $result[0]->assigned_to,
			'created_at' => $result[0]->created_at,
			'priority' => $result[0]->priority,
			'added_by' => $full_name,
			'description' => $result[0]->description,
			'progress' => $result[0]->progress_project,
			'no_project' => $result[0]->no_project,
			'estimate_hrs' => $result[0]->estimate_hrs,
			'status' => $result[0]->status,
			'path_url' => 'quoted_project_detail',
			'all_clients' => $this->Clients_model->get_all_clients(),
			'all_karyawans' => $this->Umb_model->all_karyawans(),
			'all_perusahaans' => $this->Umb_model->get_perusahaans()
		);

		//$role_resources_ids = $this->Umb_model->user_role_resource();
		//if(in_array('7',$role_resources_ids)) {
		if(!empty($session)){ 
			$data['subview'] = $this->load->view("admin/quoted_projects/details_project", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
		} else {
			redirect('admin/');
		}
		/*} else {
			redirect('dashboard/');
		}*/		  
	}
	
	public function list_project() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/quoted_projects/list_project", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$role_resources_ids = $this->Umb_model->user_role_resource();
		$user_info = $this->Umb_model->read_user_info($session['user_id']);
		if($user_info[0]->user_role_id==1){
			$project = $this->Quoted_project_model->get_projects();
		} else {
			if(in_array('428',$role_resources_ids)) {
				$project = $this->Quoted_project_model->get_project_perusahaans($user_info[0]->perusahaan_id);
			} else {
				$project = $this->Quoted_project_model->get_projects_karyawan($session['user_id']);
			}
		}
		$data = array();

		foreach($project->result() as $r) {
			$aim = explode(',',$r->assigned_to);
			
			$user = $this->Umb_model->read_user_info($r->added_by);
			
			if(!is_null($user)){
				$full_name = $user[0]->first_name.' '.$user[0]->last_name;
			} else {
				$full_name = '--';	
			}

			$estimate_date = $this->Umb_model->set_date_format($r->estimate_date);			

			if($r->progress_project <= 20) {
				$progress_class = 'progress-bar-danger';
			} else if($r->progress_project > 20 && $r->progress_project <= 50){
				$progress_class = 'progress-bar-warning';
			} else if($r->progress_project > 50 && $r->progress_project <= 75){
				$progress_class = 'progress-bar-info';
			} else {
				$progress_class = 'progress-bar-success';
			}
			$pbar = '<p class="m-b-0-5">'.$this->lang->line('umb_completed').' <span class="pull-xs-right">'.$r->progress_project.'%</span>
			<div class="progress progress-xs"><div class="progress-bar '.$progress_class.' progress-bar-striped" role="progressbar" aria-valuenow="'.$r->progress_project.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$r->progress_project.'%"></div></div></p>';
			
			if($r->status == 0) {
				$status = '<span class="label label-warning">'.$this->lang->line('umb_not_started').'</span>';
			} else if($r->status ==1){
				$status = '<span class="label label-primary">'.$this->lang->line('umb_in_progress').'</span>';
			} else if($r->status ==2){
				$status = '<span class="label label-success">'.$this->lang->line('umb_completed').'</span>';
			} else if($r->status ==3){
				$status = '<span class="label label-danger">'.$this->lang->line('umb_project_cancelled').'</span>';
			} else {
				$status = '<span class="label label-danger">'.$this->lang->line('umb_project_hold').'</span>';
			}
			if($r->priority == 1) {
				$priority = '<span class="label label-danger">'.$this->lang->line('umb_highest').'</span>';
			} else if($r->priority ==2){
				$priority = '<span class="label label-danger">'.$this->lang->line('umb_high').'</span>';
			} else if($r->priority ==3){
				$priority = '<span class="label label-primary">'.$this->lang->line('umb_normal').'</span>';
			} else {
				$priority = '<span class="label label-success">'.$this->lang->line('umb_low').'</span>';
			}
			
			if($r->assigned_to == '') {
				$ol = $this->lang->line('umb_not_assigned');
			} else {
				$ol = '';
				foreach(explode(',',$r->assigned_to) as $tunjuk_id) {
					$assigned_to = $this->Umb_model->read_user_info($tunjuk_id);
					if(!is_null($assigned_to)){
						
						$assigned_name = $assigned_to[0]->first_name.' '.$assigned_to[0]->last_name;
						if($assigned_to[0]->profile_picture!='' && $assigned_to[0]->profile_picture!='no file') {
							$ol .= '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.base_url().'uploads/profile/'.$assigned_to[0]->profile_picture.'" class="ui-w-30 rounded-circle" alt=""></span></a>';
						} else {
							if($assigned_to[0]->jenis_kelamin=='Pria') { 
								$de_file = base_url().'uploads/profile/default_male.jpg';
							} else {
								$de_file = base_url().'uploads/profile/default_female.jpg';
							}
							$ol .= '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.$de_file.'" class="ui-w-30 rounded-circle" alt=""></span></a>';
						}
					}
					else {
						$ol .= '';
					}
				}
				$ol .= '';
			}
			
			if(in_array('316',$role_resources_ids)) {
				$edit = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-project_id="'. $r->project_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
				
				$add_users = ' <a href="javascript:void(0)" class="text-muted" data-toggle="modal" data-target=".edit-modal-data"  data-project_id="'. $r->project_id . '"><span class="ion ion-md-add" data-placement="top" data-state="primary" data-toggle="tooltip" title="'.$this->lang->line('umb_add_member').'"></span></a>';
			} else {
				$edit = '';
				$add_users = '';
			}
			if(in_array('317',$role_resources_ids)) { 
				$delete = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->project_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}
			$client = $this->Clients_model->read_info_client($r->client_id);
			if(!is_null($client)) {
				$name_client = $client[0]->name;
			} else {
				$name_client = '--';
			}
			//$new_time = $this->Umb_model->actual_hours_timelog($r->project_id);
			$ringkasan_project = $r->title.'<br><small>'.$this->lang->line('umb_project_client').': '.$name_client.'</small><br><small>'.$this->lang->line('umb_estimate_hrs').': '.$r->estimate_hrs.'</small>';
			
			$progress_project = $pbar.$status;
			$no_project = $r->no_project;
			$combhr = $edit.$delete;
			$data[] = array(
				$combhr,
				$no_project,
				//$r->phase_no,
				$ringkasan_project,
				$priority,
				$ol.$add_users,
				$estimate_date,
				$progress_project,
				
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $project->num_rows(),
			"recordsFiltered" => $project->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function read() {
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('project_id');
		$result = $this->Quoted_project_model->read_informasi_project($id);
		$result2 = $this->Clients_model->read_info_client($result[0]->client_id);
		if(!is_null($result2)) {
			$name_client = $result2[0]->name;
		} else {
			$name_client = '--';
		}
		$data = array(
			'project_id' => $result[0]->project_id,
			'title' => $result[0]->title,
			'client_id' => $result[0]->client_id,
			'name_client' => $name_client,
			'estimate_date' => $result[0]->estimate_date,
			'perusahaan_id' => $result[0]->perusahaan_id,
			'priority' => $result[0]->priority,
			'summary' => $result[0]->summary,
			'no_project' => $result[0]->no_project,
			'phase_no' => $result[0]->phase_no,
			'estimate_hrs' => $result[0]->estimate_hrs,
			'assigned_to' => $result[0]->assigned_to,
			'description' => $result[0]->description,
			'progress_project' => $result[0]->progress_project,
			'status' => $result[0]->status,
			'all_clients' => $this->Clients_model->get_all_clients(),
			'all_karyawans' => $this->Umb_model->all_karyawans(),
			'all_perusahaans' => $this->Umb_model->get_perusahaans()
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/quoted_projects/dialog_project', $data);
		} else {
			redirect('admin/');
		}
	}
	
	public function add_project() {
		
		if($this->input->post('add_type')=='project') {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
			
			$estimate_date = $this->input->post('estimate_date');
			$description = $this->input->post('description');
			
			$qt_description = $description;
			$assigned_to = $this->input->post('assigned_to');
			$multi_perusahaan_id = $this->input->post('perusahaan_id');
			
			if($this->input->post('title')==='') {
				$Return['error'] = $this->lang->line('umb_error_title');
			} else if($this->input->post('no_project')==='') {
				$Return['error'] = $this->lang->line('umb_project_field_noproject_error');
			} else if($this->input->post('client_id')==='') {
				$Return['error'] = $this->lang->line('umb_error_nama_client');
			} else if(empty($multi_perusahaan_id)) {
				$Return['error'] = $this->lang->line('umb_error_perusahaan');
			} else if($this->input->post('estimate_date')==='') {
				$Return['error'] = $this->lang->line('umb_quote_tanggal_field_error');
			} else if($this->input->post('estimate_hrs')==='') {
				$Return['error'] = $this->lang->line('umb_estimate_hrs_field_error');
			} else if(empty($assigned_to)) {
				$Return['error'] = $this->lang->line('umb_error_project_manager');
			} else if($this->input->post('summary')==='') {
				$Return['error'] = $this->lang->line('umb_error_summary');
			}
			
			if($Return['error']!=''){
				$this->output($Return);
			}
			
			$assigned_ids = implode(',',$this->input->post('assigned_to'));
			$karyawan_ids = $assigned_ids;
			$perusahaan_ids = implode(',',$this->input->post('perusahaan_id'));
			$c_ids = $perusahaan_ids;
			
			$data = array(
				'title' => $this->input->post('title'),
				'no_project' => $this->input->post('no_project'),
				'client_id' => $this->input->post('client_id'),
				'perusahaan_id' => $c_ids,
				'estimate_date' => $this->input->post('estimate_date'),
				'summary' => $this->input->post('summary'),
				'estimate_hrs' => $this->input->post('estimate_hrs'),
				'priority' => $this->input->post('priority'),
				//'no_pembelian' => $this->input->post('no_pembelian'),
				'assigned_to' => $karyawan_ids,
				'description' => $qt_description,
				'progress_project' => '0',
				'status' => '0',
				'is_notify' => '1',
				'added_by' => $this->input->post('user_id'),
				'created_at' => date('d-m-Y'),
				
			);
			$result = $this->Quoted_project_model->add($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_tambah_project');	
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function update() {
		
		if($this->input->post('edit_type')=='project') {
			
			$id = $this->uri->segment(4);
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
			
			$estimate_date = $this->input->post('estimate_date');
			$description = $this->input->post('description');
			$qt_description = $description;
			//$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
			$assigned_to = $this->input->post('assigned_to');
			$multi_perusahaan_id = $this->input->post('perusahaan_id');
			
			if($this->input->post('title')==='') {
				$Return['error'] = $this->lang->line('umb_error_title');
			} else if($this->input->post('no_project')==='') {
				$Return['error'] = $this->lang->line('umb_project_field_noproject_error');
			} else if($this->input->post('client_id')==='') {
				$Return['error'] = $this->lang->line('umb_error_nama_client');
			} else if($this->input->post('estimate_date')==='') {
				$Return['error'] = $this->lang->line('umb_quote_tanggal_field_error');
			} else if($this->input->post('estimate_hrs')==='') {
				$Return['error'] = $this->lang->line('umb_estimate_hrs_field_error');
			} else if(empty($multi_perusahaan_id)) {
				$Return['error'] = $this->lang->line('umb_error_perusahaan');
			} else if(empty($assigned_to)) {
				$Return['error'] = $this->lang->line('umb_error_project_manager');
			} else if($this->input->post('summary')==='') {
				$Return['error'] = $this->lang->line('umb_error_summary');
			}
			
			if($Return['error']!=''){
				$this->output($Return);
			}
			
			if(null!=$this->input->post('assigned_to')) {
				$assigned_ids = implode(',',$this->input->post('assigned_to'));
				$karyawan_ids = $assigned_ids;
			} else {
				$karyawan_ids = 'all-karyawans';
			}
			
			$perusahaan_ids = implode(',',$this->input->post('perusahaan_id'));
			$c_ids = $perusahaan_ids;
			
			$data = array(
				'title' => $this->input->post('title'),
				'no_project' => $this->input->post('no_project'),
				'client_id' => $this->input->post('client_id'),
				'estimate_date' => $this->input->post('estimate_date'),
				'summary' => $this->input->post('summary'),
				'priority' => $this->input->post('priority'),
				'perusahaan_id' => $c_ids,
				'estimate_hrs' => $this->input->post('estimate_hrs'),
				'assigned_to' => $karyawan_ids,
				'description' => $qt_description,
				'progress_project' => $this->input->post('progres_val'),
				'status' => $this->input->post('status'),		
			);
			
			$result = $this->Quoted_project_model->update_record($data,$id);		
			
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_perbarui_project');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	
	public function update_status() {
		
		if($this->input->post('type')=='update_status') {
			
			$id = $this->input->post('project_id');
			
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
			
			$data = array(
				'priority' => $this->input->post('priority'),
				'progress_project' => $this->input->post('progres_val'),
				'status' => $this->input->post('status'),		
			);
			
			$result = $this->Quoted_project_model->update_record($data,$id);		
			
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_perbarui_project');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function assign_project() {
		
		if($this->input->post('type')=='project_user') {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();	
			
			if(null!=$this->input->post('assigned_to')) {
				$assigned_ids = implode(',',$this->input->post('assigned_to'));
				$karyawan_ids = $assigned_ids;
			} else {
				$karyawan_ids = '';
			}
			
			$data = array(
				'assigned_to' => $karyawan_ids
			);
			$id = $this->input->post('project_id');
			$result = $this->Quoted_project_model->update_record($data,$id);
			
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_project_karyawans_diperbarui');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function project_users() {

		$data['title'] = $this->Umb_model->site_title();
		$id = $this->uri->segment(3);
		
		$data = array(
			'project_id' => $id,
			'all_karyawans' => $this->Umb_model->all_karyawans(),
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("project/get_project_users", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}

	public function list_diskusi() {

		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		
		$data['title'] = $this->Umb_model->site_title();
		//$id = $this->input->get('ticket_id');
		$id = $this->uri->segment(4);
		
		$ses_user = $this->Umb_model->read_user_info($session['user_id']);
		$this->load->view("admin/quoted_projects/details_project", $data);
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$diskusi = $this->Quoted_project_model->get_diskusi($id);
		
		$data = array();

		foreach($diskusi->result() as $r) {
			
			$karyawan = $this->Umb_model->read_user_info($r->user_id);

			if(!is_null($karyawan)){
				$nama_karyawan = $karyawan[0]->first_name.' '.$karyawan[0]->last_name;
				$_penunjukan = $this->Penunjukan_model->read_informasi_penunjukan($karyawan[0]->penunjukan_id);
				if(!is_null($_penunjukan)){
					$nama_penunjukan = $_penunjukan[0]->nama_penunjukan;
				} else {
					$nama_penunjukan = '--';	
				}
				if($karyawan[0]->profile_picture!='' && $karyawan[0]->profile_picture!='no file') {
					$u_file = base_url().'uploads/profile/'.$karyawan[0]->profile_picture;
				} else {
					if($karyawan[0]->jenis_kelamin=='Pria') { 
						$u_file = base_url().'uploads/profile/default_male.jpg';
					} else {
						$u_file = base_url().'uploads/profile/default_female.jpg';
					}
				} 
			} else {
				$nama_karyawan = '--';
				$nama_penunjukan = '--';
				$u_file = $u_file;
			}
			$created_at = date('h:i A', strtotime($r->created_at));
			$_date = explode(' ',$r->created_at);
			$date = $this->Umb_model->set_date_format($_date[0]);
			if($ses_user[0]->user_role_id==1){
				$link = '<a class="c-user text-black" href="'.site_url().'admin/karyawans/detail/'.$r->user_id.'"><span class="underline">'.$nama_karyawan.' ('.$nama_penunjukan.')</span></a>';
			} else {
				$link = '<span class="underline">'.$nama_karyawan.' ('.$nama_penunjukan.')</span>';
			}
			
			if($r->attachment_file!='' && $r->attachment_file!='no_file'){
				$at_file = '<a data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_download').'" href="'.site_url().'admin/download?type=project/diskusi&filename='.$r->attachment_file.'"> <i class="oi oi-cloud-download"></i> </a>';
			} else {
				$at_file = '';
			}
			
			$function = '<div class="c-item">
			<div class="media">
			<div class="media-left">
			<div class="avatar box-48">
			<img class="user-image-hr-prj d-block ui-w-30 rounded-circle" src="'.$u_file.'">
			</div>
			</div>
			<div class="media-body">
			<div class="mb-0-5">
			'.$link.'
			<span class="font-90 text-muted">'.$date.' '.$created_at.'</span>
			</div>
			<div class="c-text">'.$r->message.'<br> '.$at_file.'</div>
			</div>
			</div>
			</div>';
			
			$data[] = array(
				$function
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $diskusi->num_rows(),
			"recordsFiltered" => $diskusi->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}	 
	
	
	public function set_diskusi() {
		
		if($this->input->post('add_type')=='set_diskusi') {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
			
			if($this->input->post('umb_message')==='') {
				$Return['error'] = $this->lang->line('umb_project_message');
			} 
			$umb_message = $this->input->post('umb_message');
			$qt_umb_message = htmlspecialchars(addslashes($umb_message), ENT_QUOTES);
			
			if($_FILES['attachment_diskusi']['size'] == 0) {
				$fname = 'no_file';
			} else {
			// is file upload
				if(is_uploaded_file($_FILES['attachment_diskusi']['tmp_name'])) {
					
					$allowed =  array('png','jpg','gif','jpeg','pdf','doc','docx','xls','xlsx','txt','zip','rar','gzip','ppt');
					$filename = $_FILES['attachment_diskusi']['name'];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);
					
					if(in_array($ext,$allowed)){
						$tmp_name = $_FILES["attachment_diskusi"]["tmp_name"];
						$attachment_file = "uploads/project/diskusi/";
						
						
						$name = basename($_FILES["attachment_diskusi"]["name"]);
						$newfilename = 'diskusi_'.round(microtime(true)).'.'.$ext;
						move_uploaded_file($tmp_name, $attachment_file.$newfilename);
						$fname = $newfilename;
					} else {
						$Return['error'] = $this->lang->line('umb_error_file_project');
					}
				}
			}
			
			if($Return['error']!=''){
				$this->output($Return);
			}
			
			$data = array(
				'message' => $qt_umb_message,
				'attachment_file' => $fname,
				'project_id' => $this->input->post('diskusi_project_id'),
				'user_id' => $this->input->post('user_id'),
				'created_at' => date('d-m-Y h:i:s')
			);
			$result = $this->Quoted_project_model->add_diskusi($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_project_message_ditambahkan');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	} 
	
	
	public function add_attachment() {
		
		if($this->input->post('add_type')=='dfile_attachment') {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
			
			if($this->input->post('file_name')==='') {
				$Return['error'] = $this->lang->line('umb_error_file_project_title');
			} else if($_FILES['attachment_file']['size'] == 0) {
				$Return['error'] = $this->lang->line('umb_error_file_tugas');
			} else if($this->input->post('file_description')==='') {
				$Return['error'] = $this->lang->line('umb_error_description_file_tugas');
			}
			$description = $this->input->post('file_description');
			$file_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
			
			if($Return['error']!=''){
				$this->output($Return);
			}
			
			if(is_uploaded_file($_FILES['attachment_file']['tmp_name'])) {
				$allowed =  array('png','jpg','gif','jpeg','pdf','doc','docx','xls','xlsx','txt','zip','rar','gzip','ppt');
				$filename = $_FILES['attachment_file']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				
				if(in_array($ext,$allowed)){
					$tmp_name = $_FILES["attachment_file"]["tmp_name"];
					$attachment_file = "uploads/project/files/";
					
					$name = basename($_FILES["attachment_file"]["name"]);
					$newfilename = 'project_'.round(microtime(true)).'.'.$ext;
					move_uploaded_file($tmp_name, $attachment_file.$newfilename);
					$fname = $newfilename;
				} else {
					$Return['error'] = $this->lang->line('umb_error_file_project');
				}
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			
			$data = array(
				'project_id' => $this->input->post('project_id'),
				'upload_by' => $this->input->post('user_id'),
				'file_title' => $this->input->post('file_name'),
				'file_description' => $file_description,
				'attachment_file' => $fname,
				'created_at' => date('d-m-Y h:i:s')
			);
			$result = $this->Quoted_project_model->add_new_attachment($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_project_file_ditambahkan');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function list_attachment() {

		$data['title'] = $this->Umb_model->site_title();
		//$id = $this->input->get('ticket_id');
		$id = $this->uri->segment(4);
		$session = $this->session->userdata('username');
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$attachments = $this->Quoted_project_model->get_attachments($id);

		$data = array();

		foreach($attachments->result() as $r) {
			
			$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_download').'"><a href="'.site_url().'admin/download?type=project/files&filename='.$r->attachment_file.'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="oi oi-cloud-download"></span></button></a></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light fidelete" data-toggle="modal" data-target=".delete-modal-file" data-record-id="'. $r->project_attachment_id . '"><span class="fas fa-trash-restore"></span></button></span>',
				$r->file_title,
				$r->file_description,
				$r->created_at
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $attachments->num_rows(),
			"recordsFiltered" => $attachments->num_rows(),
			"data" => $data
		);

		echo json_encode($output);
		exit();
	}
	
	public function delete_attachment() {
		if($this->input->post('is_ajax') == '8') {
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Quoted_project_model->delete_record_attachment($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_sukses_file_project_dihapus');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}
	
	 // add_note
	public function add_note() {
		
		if($this->input->post('type')=='add_note') {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();		
			
			$data = array(
				'catatan_project' => $this->input->post('catatan_project')
			);
			$id = $this->input->post('catatan_project_id');
			$result = $this->Quoted_project_model->update_record($data,$id);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_catatan_project_diperbarui');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function list_timelogs() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/quoted_projects/list_project_timelogs", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$user_info = $this->Umb_model->read_user_info($session['user_id']);
		if($user_info[0]->user_role_id == '1'){
			$timelogs = $this->Quoted_project_model->get_all_project_timelogs();
		} else {
			$timelogs = $this->Quoted_project_model->get_all_project_karyawan_timelogs($session['user_id']);
		}
		$role_resources_ids = $this->Umb_model->user_role_resource();
		$data = array();

		foreach($timelogs->result() as $r) {
			$user = $this->Umb_model->read_user_info($r->karyawan_id);
			
			if(!is_null($user)){
				$full_name = $user[0]->first_name.' '.$user[0]->last_name;
			} else {
				$full_name = '--';	
			}
			$project = $this->Quoted_project_model->read_informasi_project($r->project_id);
			if(!is_null($project)){
				$nama_project = '<a target="_blank" href="'.site_url('admin/quoted_projects/detail/').$r->project_id.'">'.$project[0]->title.'</a>';
			} else {
				$nama_project = '--';
			}
			$start_date = $this->Umb_model->set_date_format($r->start_date);
			$end_date = $this->Umb_model->set_date_format($r->end_date);
			$edit = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data-timelog"  data-timelogs_id="'. $r->timelogs_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
			$delete = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->timelogs_id . '"><span class="fas fa-trash-restore"></span></button></span>';		
			if($user_info[0]->user_role_id == '1'){
				$combhr = $edit.$delete;
			} else {
				$combhr = $edit;
			}
			
			$data[] = array(
				$combhr,
				$nama_project,
				$full_name,
				$start_date,
				$end_date,
				$r->total_hours,
				$r->timelogs_memo,
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $timelogs->num_rows(),
			"recordsFiltered" => $timelogs->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function list_project_timelogs() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/quoted_projects/details_project", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$id = $this->uri->segment(4);
		$timelogs = $this->Quoted_project_model->get_project_timelogs($id);
		$user_info = $this->Umb_model->read_user_info($session['user_id']);
		$role_resources_ids = $this->Umb_model->user_role_resource();
		$data = array();

		foreach($timelogs->result() as $r) {
			
			$user = $this->Umb_model->read_user_info($r->karyawan_id);
			
			if(!is_null($user)){
				$full_name = $user[0]->first_name.' '.$user[0]->last_name;
			} else {
				$full_name = '--';	
			}
			$start_date = $this->Umb_model->set_date_format($r->start_date);
			$end_date = $this->Umb_model->set_date_format($r->end_date);
			//if(in_array('346',$role_resources_ids)) { //edit
			$edit = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data-timelog"  data-timelogs_id="'. $r->timelogs_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
			//} else {
			//	$edit = '';
			//}
			//if(in_array('347',$role_resources_ids)) { // delete
			$delete = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete-timelog" data-toggle="modal" data-target=".delete-modal-timelogs" data-record-id="'. $r->timelogs_id . '"><span class="fas fa-trash-restore"></span></button></span>';
		//	} else {
		//		$delete = '';
		//	}
			if($user_info[0]->user_role_id == '1'){
				$combhr = $edit.$delete;
			} else {
				$combhr = $edit;
			}
			
			$data[] = array(
				$combhr,
				$full_name,
				$start_date,
				$end_date,
				$r->total_hours,
				$r->timelogs_memo,
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $timelogs->num_rows(),
			"recordsFiltered" => $timelogs->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}
	
	public function add_project_timelog() {
		
		if($this->input->post('add_type')=='timelog') {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
			$start_date = $this->input->post('start_date');
			$end_date = $this->input->post('end_date');
			
			$st_date = strtotime($start_date);
			$ed_date = strtotime($end_date);
			
			if($this->input->post('project_id')==='') {
				$Return['error'] = $this->lang->line('umb_error_field_project');
			} else if($this->input->post('karyawan_id')==='') {
				$Return['error'] = $this->lang->line('umb_error_karyawan_id');
			} else if($this->input->post('start_time')==='') {
				$Return['error'] = $this->lang->line('umb_project_time_start_field_error');
			} else if($this->input->post('end_time')==='') {
				$Return['error'] = $this->lang->line('umb_project_time_end_field_error');
			} else if($this->input->post('start_date')==='') {
				$Return['error'] = $this->lang->line('umb_error_start_date');
			} else if($this->input->post('end_date')==='') {
				$Return['error'] = $this->lang->line('umb_error_end_date');
			} else if($st_date > $ed_date) {
				$Return['error'] = $this->lang->line('umb_error_start_end_date');
			} else if($this->input->post('timelogs_memo')==='') {
				$Return['error'] = $this->lang->line('umb_project_memo_field_error');
			}
			
			if($Return['error']!=''){
				$this->output($Return);
			}
			$project = $this->Quoted_project_model->read_informasi_project($this->input->post('project_id'));	
			if(!is_null($project)){
				$cid = $project[0]->perusahaan_id;
			} else {
				$cid = 0;	
			}
			$data = array(
				'project_id' => $this->input->post('project_id'),
				'perusahaan_id' => $cid,
				'karyawan_id' => $this->input->post('karyawan_id'),
				'start_time' => $this->input->post('start_time'),
				'end_time' => $this->input->post('end_time'),
				'start_date' => $this->input->post('start_date'),
				'end_date' => $this->input->post('end_date'),
				'total_hours' => $this->input->post('total_hours'),
				'timelogs_memo' => $this->input->post('timelogs_memo'),
				'created_at' => date('Y-m-d h:i:s')
			);
			$result = $this->Quoted_project_model->add_project_timelog($data);
			
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_project_timelogs_ditambahkan_success');	
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function update_project_timelog() {
		
		if($this->input->post('edit_type')=='timelog_record') {
			
			$id = $this->uri->segment(4);
			
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$start_date = $this->input->post('start_date');
			$end_date = $this->input->post('end_date');
			
			$st_date = strtotime($start_date);
			$ed_date = strtotime($end_date);
			
			if($this->input->post('start_time')==='') {
				$Return['error'] = $this->lang->line('umb_project_time_start_field_error');
			} else if($this->input->post('end_time')==='') {
				$Return['error'] = $this->lang->line('umb_project_time_end_field_error');
			} else if($this->input->post('start_date')==='') {
				$Return['error'] = $this->lang->line('umb_error_start_date');
			} else if($this->input->post('end_date')==='') {
				$Return['error'] = $this->lang->line('umb_error_end_date');
			} else if($st_date > $ed_date) {
				$Return['error'] = $this->lang->line('umb_error_start_end_date');
			} else if($this->input->post('timelogs_memo')==='') {
				$Return['error'] = $this->lang->line('umb_project_memo_field_error');
			}
			
			if($Return['error']!=''){
				$this->output($Return);
			}
			
			$data = array(
				'start_time' => $this->input->post('start_time'),
				'end_time' => $this->input->post('end_time'),
				'start_date' => $this->input->post('start_date'),
				'end_date' => $this->input->post('end_date'),
				'total_hours' => $this->input->post('total_hours'),
				'timelogs_memo' => $this->input->post('timelogs_memo')
			);
			
			$result = $this->Quoted_project_model->update_record_project_timelog($data,$id);		
			
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_project_timelogs_diperbarui_success');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function read_record_timelog() {
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('timelogs_id');
		$result = $this->Quoted_project_model->read_info_timelog($id);
		$data = array(
			'timelogs_id' => $result[0]->timelogs_id,
			'project_id' => $result[0]->project_id,
			'perusahaan_id' => $result[0]->perusahaan_id,
			'karyawan_id' => $result[0]->karyawan_id,
			'start_time' => $result[0]->start_time,
			'end_time' => $result[0]->end_time,
			'start_date' => $result[0]->start_date,
			'end_date' => $result[0]->end_date,
			'total_hours' => $result[0]->total_hours,
			'timelogs_memo' => $result[0]->timelogs_memo,
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/quoted_projects/dialog_project_timelogs', $data);
		} else {
			redirect('admin/');
		}
	}

	public function read_record_project_timelog() {
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('timelogs_id');
		$result = $this->Quoted_project_model->read_info_timelog($id);
		$data = array(
			'timelogs_id' => $result[0]->timelogs_id,
			'project_id' => $result[0]->project_id,
			'perusahaan_id' => $result[0]->perusahaan_id,
			'karyawan_id' => $result[0]->karyawan_id,
			'start_time' => $result[0]->start_time,
			'end_time' => $result[0]->end_time,
			'start_date' => $result[0]->start_date,
			'end_date' => $result[0]->end_date,
			'total_hours' => $result[0]->total_hours,
			'timelogs_memo' => $result[0]->timelogs_memo,
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/quoted_projects/dialog_record_project_timelogs', $data);
		} else {
			redirect('admin/');
		}
	}
	
	public function delete() {
		
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$result = $this->Quoted_project_model->delete_record($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('umb_sukses_hapus_project');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
	}
	
	public function delete_timelog() {
		
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$result = $this->Quoted_project_model->delete_record_timelog($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('umb_project_timelogs_dihapus_success');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
	}
}
