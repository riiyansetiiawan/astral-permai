<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Projects extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		
		$this->load->model("Project_model");
		$this->load->model("Umb_model");
		$this->load->model("Perusahaan_model");
		$this->load->model("Department_model");
		$this->load->model("Penunjukan_model");
		$this->load->model("Timesheet_model");
		$this->load->model("Clients_model");
		$this->load->library('email');
	}
	
	
	public function output($Return=array()){
		
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		
		exit(json_encode($Return));
	}
	
	public function index() {

		$session = $this->session->userdata('client_username');
		if(empty($session)){ 
			redirect('client/auth/');
		}
		$system = $this->Umb_model->read_setting_info(1);
		if($system[0]->module_projects_tugass!='true'){
			redirect('client/dashboard');
		}
		$data['title'] = $this->Umb_model->site_title();
		$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		$data['all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$data['all_clients'] = $this->Clients_model->get_all_clients();
		$data['breadcrumbs'] = $this->lang->line('umb_projects');
		$data['path_url'] = 'project_client';
		$data['subview'] = $this->load->view("client/project/list_project", $data, TRUE);
		$this->load->view('client/layout/layout_main', $data); 	  
	}

	public function detail() {

		$session = $this->session->userdata('client_username');
		if(empty($session)){ 
			redirect('client/auth/');
		}
		$system = $this->Umb_model->read_setting_info(1);
		if($system[0]->module_projects_tugass!='true'){
			redirect('client/dashboard');
		}
		$data['title'] = $this->Umb_model->site_title();
		//$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		//$data['all_perusahaans'] = $this->Umb_model->get_perusahaans();
		//$data['breadcrumbs'] = $this->lang->line('umb_project_detail');
		$id = $this->uri->segment(4);
		$result = $this->Project_model->read_informasi_project($id);
		if(is_null($result)){
			redirect('client/projects');
		}
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
			'breadcrumbs' => $this->lang->line('umb_project_detail'),
			'project_id' => $result[0]->project_id,
			'title' => $result[0]->title,
			'catatan_project' => $result[0]->catatan_project,
			'summary' => $result[0]->summary,
			'client_id' => $result[0]->client_id,
			'name_client' => $name_client,
			'start_date' => $result[0]->start_date,
			'end_date' => $result[0]->end_date,
			'perusahaan_id' => $result[0]->perusahaan_id,
			'assigned_to' => $result[0]->assigned_to,
			'created_at' => $result[0]->created_at,
			'priority' => $result[0]->priority,
			'added_by' => $full_name,
			'description' => $result[0]->description,
			'progress' => $result[0]->progress_project,
			'status' => $result[0]->status,
			'path_url' => 'project_detail_client',
			'all_clients' => $this->Clients_model->get_all_clients(),
			'all_karyawans' => $this->Umb_model->all_karyawans(),
			'all_perusahaans' => $this->Umb_model->get_perusahaans()
		);
		$data['subview'] = $this->load->view("client/project/details_project", $data, TRUE);
		$this->load->view('client/layout/layout_main', $data); 		  
	}

	public function list_project() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('client_username');
		if(!empty($session)){ 
			$this->load->view("client/project/list_project", $data);
		} else {
			redirect('client/auth/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$project = $this->Project_model->get_projects_client($session['client_id']);
		$data = array();
		foreach($project->result() as $r) {
			$user = $this->Umb_model->read_user_info($r->added_by);
			if(!is_null($user)){
				$full_name = $user[0]->first_name.' '.$user[0]->last_name;
			} else {
				$full_name = '--';	
			}
			$pdate = '<i class="far fa-calendar-alt position-left"></i> '.$this->Umb_model->set_date_format($r->end_date);
			if($r->progress_project <= 20) {
				$progress_class = 'progress-danger';
			} else if($r->progress_project > 20 && $r->progress_project <= 50){
				$progress_class = 'progress-warning';
			} else if($r->progress_project > 50 && $r->progress_project <= 75){
				$progress_class = 'progress-info';
			} else {
				$progress_class = 'progress-success';
			}
			$pbar = '<p class="m-b-0-5">'.$this->lang->line('umb_completed').' <span class="pull-xs-right">'.$r->progress_project.'%</span></p><div class="progress" style="height: 7px;"><div class="progress-bar '.$progress_class.'" style="width: '.$r->progress_project.'%"></div></div>';
			if($r->status == 0) {
				$status = $this->lang->line('umb_not_started');
			} else if($r->status ==1){
				$status = $this->lang->line('umb_in_progress');
			} else if($r->status ==2){
				$status = $this->lang->line('umb_completed');
			} else {
				$status = $this->lang->line('umb_deffered');
			}
			if($r->priority == 1) {
				$priority = '<span class="badge badge-danger">'.$this->lang->line('umb_highest').'</span>';
			} else if($r->priority ==2){
				$priority = '<span class="badge badge-danger">'.$this->lang->line('umb_high').'</span>';
			} else if($r->priority ==3){
				$priority = '<span class="badge badge-primary">'.$this->lang->line('umb_normal').'</span>';
			} else {
				$priority = '<span class="badge badge-success">'.$this->lang->line('umb_low').'</span>';
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
			$ringkasan_project = '<div class="text-semibold"><a href="'.site_url('client/projects/detail/').$r->project_id . '">'.$r->title.'</a></div>
			<div class="text-muted">'.$r->summary.'</div>';
			$data[] = array(		
				$ringkasan_project,
				$priority,
				$pdate,
				$pbar,
				$ol
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

	public function list_project_tugas() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('client_username');
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$id = $this->uri->segment(4);		
		$tugas = $this->Timesheet_model->get_project_tugass($id);
		$data = array();
		foreach($tugas->result() as $r) {
			if($r->assigned_to == '' || $r->assigned_to == 'None') {
				$ol = $this->lang->line('umb_performance_none');
			} else {
				$ol = '';
				foreach(explode(',',$r->assigned_to) as $uid) {
					$assigned_to = $this->Umb_model->read_user_info($uid);
					if(!is_null($assigned_to)){
						$assigned_name = $assigned_to[0]->first_name.' '.$assigned_to[0]->last_name;
						if($assigned_to[0]->profile_picture!='' && $assigned_to[0]->profile_picture!='no file') {
							$ol .= '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.base_url().'uploads/profile/'.$assigned_to[0]->profile_picture.'" class="b-a-radius-circle" alt=""></span></a>';
						} else {
							if($assigned_to[0]->jenis_kelamin=='Pria') { 
								$de_file = base_url().'uploads/profile/default_male.jpg';
							} else {
								$de_file = base_url().'uploads/profile/default_female.jpg';
							}
							$ol .= '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.$de_file.'" class="b-a-radius-circle" alt=""></span></a>';
						}
					}
				}
				$ol .= '';
			}
			//$ol = 'A';
			$u_created = $this->Umb_model->read_user_info($r->created_by);
			$f_name = $u_created[0]->first_name.' '.$u_created[0]->last_name;
			if($r->progress_tugas=='' || $r->progress_tugas==0): $progress = 0; else: $progress = $r->progress_tugas; endif;
			if($r->progress_tugas <= 20) {
				$progress_class = 'progress-danger';
			} else if($r->progress_tugas > 20 && $r->progress_tugas <= 50){
				$progress_class = 'progress-warning';
			} else if($r->progress_tugas > 50 && $r->progress_tugas <= 75){
				$progress_class = 'progress-info';
			} else {
				$progress_class = 'progress-success';
			}
			$progress_bar = '<p class="m-b-0-5">'.$this->lang->line('umb_completed').' <span class="pull-xs-right">'.$r->progress_tugas.'%</span></p><progress class="progress '.$progress_class.' progress-sm" value="'.$r->progress_tugas.'" max="100">'.$r->progress_tugas.'%</progress>';
			if($r->status_tugas == 0) {
				$status = $this->lang->line('umb_not_started');
			} else if($r->status_tugas ==1){
				$status = $this->lang->line('umb_in_progress');
			} else if($r->status_tugas ==2){
				$status = $this->lang->line('umb_completed');
			} else {
				$status = $this->lang->line('umb_deffered');
			}
			$tdate = $this->Umb_model->set_date_format($r->end_date);
			$data[] = array(
				'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_view_details').'"><a href="'.site_url().'client/tugass/details/id/'.$r->tugas_id.'/"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light"><i class="fa fa-arrow-circle-right"></i></button></a></span>',
				$r->nama_tugas,
				$tdate,
				$status,
				$ol,
				$f_name,
				$progress_bar
			);
		}
		$output = array(
			"draw" => $draw,
			"recordsTotal" => $tugas->num_rows(),
			"recordsFiltered" => $tugas->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function read() {
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('project_id');
		$result = $this->Project_model->read_informasi_project($id);
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
			'start_date' => $result[0]->start_date,
			'end_date' => $result[0]->end_date,
			'perusahaan_id' => $result[0]->perusahaan_id,
			'priority' => $result[0]->priority,
			'summary' => $result[0]->summary,
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
			$this->load->view('client/project/dialog_project', $data);
		} else {
			redirect('client/auth/');
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
		$attachments = $this->Project_model->get_attachments($id);
		$data = array();
		foreach($attachments->result() as $r) {
			$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_download').'"><a href="'.site_url().'admin/download?type=project/files&filename='.$r->attachment_file.'"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light"><i class="fa fa-download"></i></button></a></span>',
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
}
