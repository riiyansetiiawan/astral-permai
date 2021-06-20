<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Laporans extends MY_Controller{

	public function output($Return=array()){
		
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		
		exit(json_encode($Return));
	}
	
	public function __construct() {
		parent::__construct();
		
		$this->load->model('Perusahaan_model');
		$this->load->model('Umb_model');
		$this->load->model('Eumb_model');
		$this->load->model('Department_model');
		$this->load->model('Payroll_model');
		$this->load->model('Laporans_model');
		$this->load->model('Timesheet_model');
		$this->load->model('Training_model');
		$this->load->model('Trainers_model');
		$this->load->model("Project_model");
		$this->load->model("Roles_model");
		$this->load->model("Karyawans_model");
		$this->load->model("Penunjukan_model");
	}
	
	public function index() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('umb_hr_title_laporan').' | '.$this->Umb_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('umb_hr_title_laporan');
		$data['path_url'] = 'hrastral_laporans';
		$data['all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('110',$role_resources_ids) || in_array('111',$role_resources_ids) || in_array('112',$role_resources_ids) || in_array('113',$role_resources_ids) || in_array('114',$role_resources_ids) || in_array('115',$role_resources_ids) || in_array('116',$role_resources_ids) || in_array('117',$role_resources_ids) || in_array('409',$role_resources_ids) || in_array('83',$role_resources_ids) || in_array('84',$role_resources_ids) || in_array('85',$role_resources_ids) || in_array('86',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/layout/hrastral_laporans", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
		} else {
			redirect('admin/dashboard');
		}
	}
	
	public function slipgaji() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('umb_hr_laporans_slipgaji').' | '.$this->Umb_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('umb_hr_laporans_slipgaji');
		$data['path_url'] = 'laporans_slipgaji';
		$data['all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('111',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/laporans/slipgaji", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
		} else {
			redirect('admin/dashboard');
		}
	}
	
	public function projects() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('umb_hr_laporans_projects').' | '.$this->Umb_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('umb_hr_laporans_projects');
		$data['path_url'] = 'laporans_project';
		$data['all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('114',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/laporans/projects", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
		} else {
			redirect('admin/dashboard');
		}
	}
	
	public function tugass() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('umb_hr_laporans_tugass').' | '.$this->Umb_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('umb_hr_laporans_tugass');
		$data['path_url'] = 'laporans_tugas';
		$data['all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('115',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/laporans/tugass", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
		} else {
			redirect('admin/dashboard');
		}
	}
	
	public function roles() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('umb_hr_laporan_user_roles_laporan').' | '.$this->Umb_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('umb_hr_laporan_user_roles_laporan');
		$data['path_url'] = 'laporans_roles';
		$data['all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$data['all_user_roles'] = $this->Roles_model->all_user_roles();
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('116',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/laporans/roles", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
		} else {
			redirect('admin/dashboard');
		}
	}
	
	public function karyawans() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('umb_hr_laporan_karyawans').' | '.$this->Umb_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('umb_hr_laporan_karyawans');
		$data['path_url'] = 'laporans_karyawans';
		$data['all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$data['all_departments'] = $this->Department_model->all_departments();
		$data['all_penunjukans'] = $this->Penunjukan_model->all_penunjukans();
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('117',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/laporans/karyawans", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
		} else {
			redirect('admin/dashboard');
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
			$this->load->view("admin/laporans/laporan_get_departments", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	} 
	
	public function penunjukan() {

		$data['title'] = $this->Umb_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'department_id' => $id,
			'all_penunjukans' => $this->Penunjukan_model->all_penunjukans(),
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/laporans/laporan_get_penunjukans", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}
	
	public function kehadiran_karyawan() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('umb_hr_laporans_kehadiran_karyawan').' | '.$this->Umb_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('umb_hr_laporans_kehadiran_karyawan');
		$data['path_url'] = 'laporans_kehadiran_karyawan';
		$data['get_all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('112',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/laporans/kehadiran_karyawan", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
		} else {
			redirect('admin/dashboard');
		}
	}
	public function karyawan_cuti() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('umb_status_cuti').' | '.$this->Umb_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('umb_status_cuti');
		$data['path_url'] = 'laporans_karyawan_cuti';
		$data['get_all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('31',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/laporans/karyawan_cuti", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
		} else {
			redirect('admin/dashboard');
		}
	}
	
	public function karyawan_training() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('umb_hr_laporans_training').' | '.$this->Umb_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('umb_hr_laporans_training');
		$data['path_url'] = 'laporans_karyawan_training';
		$data['get_all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('113',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/laporans/karyawan_training", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
		} else {
			redirect('admin/dashboard');
		}
	}
	
	
	public function laporan_slipgaji() {
		
		if($this->input->post('type')=='laporan_slipgaji') {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
			
			if($this->input->post('perusahaan_id')==='') {
				$Return['error'] = $this->lang->line('error_field_perusahaan');
			} else if($this->input->post('karyawan_id')==='') {
				$Return['error'] = $this->lang->line('umb_error_karyawan_id');
			} else if($this->input->post('month_year')==='') {
				$Return['error'] = $this->lang->line('umb_hr_report_error_month_field');
			} 
			
			if($Return['error']!=''){
				$this->output($Return);
			}
			$Return['result'] = $this->lang->line('umb_hr_permintaan_submitted');
			$this->output($Return);
		}
	}
	
	public function list_role_karyawans() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/laporans/roles", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$roleId = $this->uri->segment(4);
		$karyawan = $this->Laporans_model->get_roles_karyawans($roleId);
		
		$data = array();

		foreach($karyawan->result() as $r) {		  
			
			$perusahaan = $this->Umb_model->read_info_perusahaan($r->perusahaan_id);
			if(!is_null($perusahaan)){
				$prshn_nama = $perusahaan[0]->name;
			} else {
				$prshn_nama = '--';	
			}
			
			$full_name = $r->first_name.' '.$r->last_name;				
			if($r->is_active==0): 
				$status = $this->lang->line('umb_karyawans_inactive');
			elseif($r->is_active==1): 
				$status = $this->lang->line('umb_karyawans_active'); 
			endif;
			$role = $this->Umb_model->read_user_role_info($r->user_role_id);
			if(!is_null($role)){
				$role_name = $role[0]->role_name;
			} else {
				$role_name = '--';	
			}
			$penunjukan = $this->Penunjukan_model->read_informasi_penunjukan($r->penunjukan_id);
			if(!is_null($penunjukan)){
				$nama_penunjukan = $penunjukan[0]->nama_penunjukan;
			} else {
				$nama_penunjukan = '--';	
			}
			$department = $this->Department_model->read_informasi_department($r->department_id);
			if(!is_null($department)){
				$nama_department = $department[0]->nama_department;
			} else {
				$nama_department = '--';	
			}
			$department_penunjukan = $nama_penunjukan.' ('.$nama_department.')';

			$data[] = array(
				$r->karyawan_id,
				$full_name,
				$prshn_nama,
				$r->email,
				$role_name,
				$department_penunjukan,
				$status
			);
		}
		$output = array(
			"draw" => $draw,
			"recordsTotal" => $karyawan->num_rows(),
			"recordsFiltered" => $karyawan->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function list_laporan_karyawans() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/laporans/karyawans", $data);
		} else {
			redirect('admin/');
		}

		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		$perusahaan_id = $this->uri->segment(4);
		$department_id = $this->uri->segment(5);
		$penunjukan_id = $this->uri->segment(6);
		$karyawan = $this->Laporans_model->get_laporans_karyawans($perusahaan_id,$department_id,$penunjukan_id);

		$data = array();
		foreach($karyawan->result() as $r) {		  
			$perusahaan = $this->Umb_model->read_info_perusahaan($r->perusahaan_id);
			if(!is_null($perusahaan)){
				$prshn_nama = $perusahaan[0]->name;
			} else {
				$prshn_nama = '--';	
			}
			$full_name = $r->first_name.' '.$r->last_name;				
			if($r->is_active==0): 
				$status = $this->lang->line('umb_karyawans_inactive');
			elseif($r->is_active==1): 
				$status = $this->lang->line('umb_karyawans_active'); 
			endif;
			$penunjukan = $this->Penunjukan_model->read_informasi_penunjukan($r->penunjukan_id);
			if(!is_null($penunjukan)){
				$nama_penunjukan = $penunjukan[0]->nama_penunjukan;
			} else {
				$nama_penunjukan = '--';	
			}
			$department = $this->Department_model->read_informasi_department($r->department_id);
			if(!is_null($department)){
				$nama_department = $department[0]->nama_department;
			} else {
				$nama_department = '--';	
			}
			$data[] = array(
				$r->karyawan_id,
				$full_name,
				$prshn_nama,
				$r->email,
				$nama_department,
				$nama_penunjukan,
				$status
			);
		}
		$output = array(
			"draw" => $draw,
			"recordsTotal" => $karyawan->num_rows(),
			"recordsFiltered" => $karyawan->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function list_tugas() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/laporans/tugass", $data);
		} else {
			redirect('admin/');
		}

		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		$tugasId = $this->uri->segment(4);
		$tugasstatus = $this->uri->segment(5);
		$user_info = $this->Umb_model->read_user_info($session['user_id']);
		if($user_info[0]->user_role_id==1){
			$tugass = $this->Laporans_model->get_list_tugas($tugasId,$tugasstatus);
		} else {
			$tugass = $this->Timesheet_model->get_tugass_karyawan($session['user_id']);
		}		
		$data = array();

		foreach($tugass->result() as $r) {
			$start_date = $this->Umb_model->set_date_format($r->start_date);
			$end_date = $this->Umb_model->set_date_format($r->end_date);
			if($r->status_tugas == 0) {
				$status = $this->lang->line('umb_not_started');
			} else if($r->status_tugas ==1){
				$status = $this->lang->line('umb_in_progress');
			} else if($r->status_tugas ==2){
				$status = $this->lang->line('umb_completed');
			} else {
				$status = $this->lang->line('umb_deffered');
			}
			if($r->assigned_to == '') {
				$ol = $this->lang->line('umb_not_assigned');
			} else {
				$ol = '<ol class="nl">';
				foreach(explode(',',$r->assigned_to) as $tunjuk_id) {
					$assigned_to = $this->Umb_model->read_user_info($tunjuk_id);
					if(!is_null($assigned_to)){

						$assigned_name = $assigned_to[0]->first_name.' '.$assigned_to[0]->last_name;
						$ol .= '<li>'.$assigned_name.'</li>';
					}
				}
				$ol .= '</ol>';
			}
			$catnama_tugas = $r->nama_tugas;
			$data[] = array(
				$catnama_tugas,$start_date,$end_date,$ol,$status,
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $tugass->num_rows(),
			"recordsFiltered" => $tugass->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}


	public function list_project() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/laporans/projects", $data);
		} else {
			redirect('admin/');
		}

		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		$projId = $this->uri->segment(4);
		$projStatus = $this->uri->segment(5);
		$role_resources_ids = $this->Umb_model->user_role_resource();
		$user_info = $this->Umb_model->read_user_info($session['user_id']);
		if($user_info[0]->user_role_id==1){
			$project = $this->Laporans_model->get_list_project($projId,$projStatus);
		} else {
			$project = $this->Project_model->get_projects_karyawan($session['user_id']);
		}		
		$data = array();

		foreach($project->result() as $r) {
			$start_date = $this->Umb_model->set_date_format($r->start_date);
			$end_date = $this->Umb_model->set_date_format($r->end_date);
			$pbar = '<p class="m-b-0-5">'.$this->lang->line('umb_completed').' '.$r->progress_project.'%</p>';
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
				$priority = '<span class="tag tag-danger">'.$this->lang->line('umb_highest').'</span>';
			} else if($r->priority ==2){
				$priority = '<span class="tag tag-danger">'.$this->lang->line('umb_high').'</span>';
			} else if($r->priority ==3){
				$priority = '<span class="tag tag-primary">'.$this->lang->line('umb_normal').'</span>';
			} else {
				$priority = '<span class="tag tag-success">'.$this->lang->line('umb_low').'</span>';
			}
			if($r->assigned_to == '') {
				$ol = $this->lang->line('umb_not_assigned');
			} else {
				$ol = '';
				foreach(explode(',',$r->assigned_to) as $tunjuk_id) {
					$assigned_to = $this->Umb_model->read_user_info($tunjuk_id);
					if(!is_null($assigned_to)){

						$assigned_name = $assigned_to[0]->first_name.' '.$assigned_to[0]->last_name;
						$ol .= $assigned_name."<br>";
					}
				}
				$ol .= '';
			}
			$new_time = $this->Umb_model->actual_hours_timelog($r->project_id);
			$ringkasan_project = '<div class="text-semibold"><a href="'.site_url().'admin/project/detail/'.$r->project_id . '">'.$r->title.'</a></div>';
			$data[] = array(
				$ringkasan_project,
				$priority,
				$start_date,
				$end_date,
				$status,
				$pbar,
				$ol,
				$r->jam_anggaran,
				$new_time,

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

	public function list_training() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/laporans/karyawan_training", $data);
		} else {
			redirect('admin/');
		}

		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		$start_date = $this->uri->segment(4);
		$end_date = $this->uri->segment(5);
		$uid = $this->uri->segment(6);
		$cid = $this->uri->segment(7);

		$training = $this->Laporans_model->get_list_training($cid,$start_date,$end_date);

		$data = array();

		foreach($training->result() as $r) {

			$aim = explode(',',$r->karyawan_id);
			foreach($aim as $dIds) {
				if($uid == $dIds) {
					$type = $this->Training_model->read_informasi_type_training($r->type_training_id);
					if(!is_null($type)){
						$itype = $type[0]->type;
					} else {
						$itype = '--';	
					}
					if($r->trainer_option == 2){
						$trainer = $this->Trainers_model->read_informasi_trainer($r->trainer_id);
						if(!is_null($trainer)){
							$nama_trainer = $trainer[0]->first_name.' '.$trainer[0]->last_name;
						} else {
							$nama_trainer = '--';	
						}
					} elseif($r->trainer_option == 1){
						$trainer = $this->Umb_model->read_user_info($r->trainer_id);
						if(!is_null($trainer)){
							$nama_trainer = $trainer[0]->first_name.' '.$trainer[0]->last_name;
						} else {
							$nama_trainer = '--';	
						}
					} else {
						$nama_trainer = '--';
					}
					$start_date = $this->Umb_model->set_date_format($r->start_date);
					$finish_date = $this->Umb_model->set_date_format($r->finish_date);
					$tanggal_training = $start_date.' '.$this->lang->line('dashboard_to').' '.$finish_date;
					$biaya_training = $this->Umb_model->currency_sign($r->biaya_training);
					if($uid == '') {
						$ol = '--';
					} else {
						$user = $this->Eumb_model->read_user_info($uid);
						$fname = $user[0]->first_name.' '.$user[0]->last_name;				
					}
					if($r->status_training==0): 
						$status = $this->lang->line('umb_pending');
					elseif($r->status_training==1): 
						$status = $this->lang->line('umb_started'); 
					elseif($r->status_training==2): 
						$status = $this->lang->line('umb_completed');
					else: 
						$status = $this->lang->line('umb_terminated'); 
					endif;
					$perusahaan = $this->Umb_model->read_info_perusahaan($r->perusahaan_id);
					if(!is_null($perusahaan)){
						$prshn_nama = $perusahaan[0]->name;
					} else {
						$prshn_nama = '--';	
					}

					$data[] = array(
						$prshn_nama,
						$fname,
						$itype,
						$nama_trainer,
						$tanggal_training,
						$biaya_training,
						$status
					);
				}
			} 
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $training->num_rows(),
			"recordsFiltered" => $training->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function list_laporan_slipgaji() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/laporans/slipgaji", $data);
		} else {
			redirect('admin/');
		}

		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		$cid = $this->uri->segment(4);
		$eid = $this->uri->segment(5);
		$re_date = $this->uri->segment(6);

		$slipgaji_re = $this->Laporans_model->get_list_slipgaji($cid,$eid,$re_date);

		$data = array();

		foreach($slipgaji_re->result() as $r) {

			  // get addd by > template
			$user = $this->Umb_model->read_user_info($r->karyawan_id);

			if(!is_null($user)){
				$full_name = $user[0]->first_name.' '.$user[0]->last_name;
				$link_krywn = $user[0]->karyawan_id;				  
				$month_payment = date("F, Y", strtotime($r->gaji_bulan));

				$p_jumlah = $this->Umb_model->currency_sign($r->gaji_bersih);
				if($r->type_upahh==1){
					$type_payroll = $this->lang->line('umb_payroll_gaji_pokok');
				} else {
					$type_payroll = $this->lang->line('umb_karyawan_upahh_harian');
				}
				$created_at = $this->Umb_model->set_date_format($r->created_at);

				$data[] = array(
					$link_krywn,
					$full_name,
					$p_jumlah,
					$month_payment,
					$created_at,
					$type_payroll
				);
			}
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $slipgaji_re->num_rows(),
			"recordsFiltered" => $slipgaji_re->num_rows(),
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
			$this->load->view("admin/laporans/get_karyawans", $data);
		} else {
			redirect('admin/');
		}

		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}

	public function get_khdrn_karyawan() {

		$data['title'] = $this->Umb_model->site_title();
		$id = $this->uri->segment(4);

		$data = array(
			'perusahaan_id' => $id
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/laporans/get_khdrn_karyawan", $data);
		} else {
			redirect('admin/');
		}

		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}

	public function list_kehadiran_krywn_tgl_bijaksana()
	{

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/laporans/kehadiran_karyawan", $data);
		} else {
			redirect('admin/');
		}

		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$karyawan = $this->Umb_model->read_user_info_kehadiran();
		$data = array();
		foreach($karyawan->result() as $r) {
			$data[] = array('','','','','','','','');
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $karyawan->num_rows(),
			"recordsFiltered" => $karyawan->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function list_karyawan_tanggal_bijaksana() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		$user_info = $this->Umb_model->read_user_info($session['user_id']);
		if(!empty($session)){ 
			$this->load->view("admin/laporans/kehadiran_karyawan", $data);
		} else {
			redirect('admin/');
		}

		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		$karyawan_id = $this->input->get("user_id");
		//$karyawan = $this->Umb_model->read_user_info($karyawan_id);
		$karyawan = $this->Umb_model->read_user_info($karyawan_id);
		$start_date = new DateTime( $this->input->get("start_date"));
		$end_date = new DateTime( $this->input->get("end_date") );
		$end_date = $end_date->modify( '+1 day' ); 
		$interval_re = new DateInterval('P1D');
		$date_range = new DatePeriod($start_date, $interval_re ,$end_date);
		$kehadiran_arr = array();
		$data = array();
		foreach($date_range as $date) {
			$tanggal_kehadiran =  $date->format("Y-m-d");
			// foreach($karyawan->result() as $r) {
				//	$full_name = $r->first_name.' '.$r->last_name;	
			$get_day = strtotime($tanggal_kehadiran);
			$day = date('l', $get_day);

			$shift_kantor = $this->Timesheet_model->read_informasi_shift_kantor($karyawan[0]->shift_kantor_id);

			if($day == 'Monday') {
				if($shift_kantor[0]->senen_waktu_masuk==''){
					$in_time = '00:00:00';
					$out_time = '00:00:00';
				} else {
					$in_time = $shift_kantor[0]->senen_waktu_masuk;
					$out_time = $shift_kantor[0]->senen_waktu_pulang;
				}
			} else if($day == 'Tuesday') {
				if($shift_kantor[0]->selasa_waktu_masuk==''){
					$in_time = '00:00:00';
					$out_time = '00:00:00';
				} else {
					$in_time = $shift_kantor[0]->selasa_waktu_masuk;
					$out_time = $shift_kantor[0]->selasa_waktu_pulang;
				}
			} else if($day == 'Wednesday') {
				if($shift_kantor[0]->rabu_waktu_masuk==''){
					$in_time = '00:00:00';
					$out_time = '00:00:00';
				} else {
					$in_time = $shift_kantor[0]->rabu_waktu_masuk;
					$out_time = $shift_kantor[0]->rabu_waktu_pulang;
				}
			} else if($day == 'Thursday') {
				if($shift_kantor[0]->kamis_waktu_masuk==''){
					$in_time = '00:00:00';
					$out_time = '00:00:00';
				} else {
					$in_time = $shift_kantor[0]->kamis_waktu_masuk;
					$out_time = $shift_kantor[0]->kamis_waktu_pulang;
				}
			} else if($day == 'Friday') {
				if($shift_kantor[0]->jumat_waktu_masuk==''){
					$in_time = '00:00:00';
					$out_time = '00:00:00';
				} else {
					$in_time = $shift_kantor[0]->jumat_waktu_masuk;
					$out_time = $shift_kantor[0]->jumat_waktu_pulang;
				}
			} else if($day == 'Saturday') {
				if($shift_kantor[0]->sabtu_waktu_masuk==''){
					$in_time = '00:00:00';
					$out_time = '00:00:00';
				} else {
					$in_time = $shift_kantor[0]->sabtu_waktu_masuk;
					$out_time = $shift_kantor[0]->sabtu_waktu_pulang;
				}
			} else if($day == 'Sunday') {
				if($shift_kantor[0]->minggu_waktu_masuk==''){
					$in_time = '00:00:00';
					$out_time = '00:00:00';
				} else {
					$in_time = $shift_kantor[0]->minggu_waktu_masuk;
					$out_time = $shift_kantor[0]->minggu_waktu_pulang;
				}
			}
			$status_kehadiran = '';
			$check = $this->Timesheet_model->check_kehadiran_pertama_masuk($karyawan[0]->user_id,$tanggal_kehadiran);		
			if($check->num_rows() > 0){
				$kehadiran = $this->Timesheet_model->kehadiran_pertama_masuk($karyawan[0]->user_id,$tanggal_kehadiran);
				$clock_in = new DateTime($kehadiran[0]->clock_in);
				$clock_in2 = $clock_in->format('h:i a');
				$clkInIp = $clock_in2.'<br><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-ipaddress="'.$kehadiran[0]->clock_in_ip_address.'" data-uid="'.$karyawan[0]->user_id.'" data-att_type="clock_in" data-start_date="'.$tanggal_kehadiran.'"><i class="ft-map-pin"></i> '.$this->lang->line('umb_attend_clkin_ip').'</button>';

				$waktu_kantor =  new DateTime($in_time.' '.$tanggal_kehadiran);
				$waktu_kantor_new = strtotime($in_time.' '.$tanggal_kehadiran);
				$clock_in_time_new = strtotime($kehadiran[0]->clock_in);
				if($clock_in_time_new <= $waktu_kantor_new) {
					$total_time_l = '00:00';
				} else {
					$interval_late = $clock_in->diff($waktu_kantor);
					$hours_l   = $interval_late->format('%h');
					$minutes_l = $interval_late->format('%i');			
					$total_time_l = $hours_l ."h ".$minutes_l."m";
				}

				$total_hrs = $this->Timesheet_model->total_kehadiran_jam_bekerja($karyawan[0]->user_id,$tanggal_kehadiran);
				$hrs_old_int1 = 0;
				$Total = '';
				$Tistrahat = '';
				$hrs_old_seconds = 0;
				$hrs_old_seconds_rs = 0;
				$total_time_rs = '';
				$hrs_old_int_res1 = 0;
				foreach ($total_hrs->result() as $jam_kerja){		
					$timee = $jam_kerja->total_kerja.':00';
					$str_time =$timee;
					$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);
					sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
					$hrs_old_seconds = $hours * 3600 + $minutes * 60 + $seconds;
					$hrs_old_int1 += $hrs_old_seconds;
					$Total = gmdate("H:i", $hrs_old_int1);	
				}
				if($Total=='') {
					$total_kerja = '00:00';
				} else {
					$total_kerja = $Total;
				}

				$total_istirahat = $this->Timesheet_model->total_istirahat_kehadiran($karyawan[0]->user_id,$tanggal_kehadiran);
				foreach ($total_istirahat->result() as $istirahat){			
					$str_time_rs = $istirahat->total_istirahat.':00';
					$str_time_rs = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time_rs);
					sscanf($str_time_rs, "%d:%d:%d", $hours_rs, $minutes_rs, $seconds_rs);
					$hrs_old_seconds_rs = $hours_rs * 3600 + $minutes_rs * 60 + $seconds_rs;
					$hrs_old_int_res1 += $hrs_old_seconds_rs;
					$total_time_rs = gmdate("H:i", $hrs_old_int_res1);
				}
				$status = $kehadiran[0]->status_kehadiran;
				if($total_time_rs=='') {
					$Tistrahat = '00:00';
				} else {
					$Tistrahat = $total_time_rs;
				}
			} else {
				$clock_in2 = '-';
				$total_time_l = '00:00';
				$total_kerja = '00:00';
				$Tistrahat = '00:00';
				$clkInIp = $clock_in2;

				$chck_tanggal_lbr = $this->Timesheet_model->check_tanggal_libur($tanggal_kehadiran);
				$libur_arr = array();
				if($chck_tanggal_lbr->num_rows() == 1){
					$h_date = $this->Timesheet_model->tanggal_libur($tanggal_kehadiran);
					$begin = new DateTime( $h_date[0]->start_date );
					$end = new DateTime( $h_date[0]->end_date);
					$end = $end->modify( '+1 day' ); 

					$interval = new DateInterval('P1D');
					$daterange = new DatePeriod($begin, $interval ,$end);

					foreach($daterange as $date){
						$libur_arr[] =  $date->format("Y-m-d");
					}
				} else {
					$libur_arr[] = '99-99-99';
				}

				$chck_tanggal_cuti = $this->Timesheet_model->chcek_tanggal_cuti($karyawan[0]->user_id,$tanggal_kehadiran);
				$cuti_arr = array();
				if($chck_tanggal_cuti->num_rows() == 1){
					$tanggal_cuti = $this->Timesheet_model->tanggal_cuti($karyawan[0]->user_id,$tanggal_kehadiran);
					$begin1 = new DateTime( $tanggal_cuti[0]->from_date );
					$end1 = new DateTime( $tanggal_cuti[0]->to_date);
					$end1 = $end1->modify( '+1 day' ); 

					$interval1 = new DateInterval('P1D');
					$daterange1 = new DatePeriod($begin1, $interval1 ,$end1);

					foreach($daterange1 as $date1){
						$cuti_arr[] =  $date1->format("Y-m-d");
					}	
				} else {
					$cuti_arr[] = '99-99-99';
				}

				if($shift_kantor[0]->senen_waktu_masuk == '' && $day == 'Monday') {
					$status = $this->lang->line('umb_libur');	
				} else if($shift_kantor[0]->selasa_waktu_masuk == '' && $day == 'Tuesday') {
					$status = $this->lang->line('umb_libur');	
				} else if($shift_kantor[0]->rabu_waktu_masuk == '' && $day == 'Wednesday') {
					$status = $this->lang->line('umb_libur');	
				} else if($shift_kantor[0]->kamis_waktu_masuk == '' && $day == 'Thursday') {
					$status = $this->lang->line('umb_libur');	
				} else if($shift_kantor[0]->jumat_waktu_masuk == '' && $day == 'Friday') {
					$status = $this->lang->line('umb_libur');	
				} else if($shift_kantor[0]->sabtu_waktu_masuk == '' && $day == 'Saturday') {
					$status = $this->lang->line('umb_libur');	
				} else if($shift_kantor[0]->minggu_waktu_masuk == '' && $day == 'Sunday') {
					$status = $this->lang->line('umb_libur');	
				} else if(in_array($tanggal_kehadiran,$libur_arr)) {
					$status = $this->lang->line('umb_libur');
				} else if(in_array($tanggal_kehadiran,$cuti_arr)) {
					$status = $this->lang->line('umb_on_cuti');
				} 
				else {
					$status = $this->lang->line('umb_absent');
				}
			}

			$check_out = $this->Timesheet_model->check_kehadiran_pulang_pertama($karyawan[0]->user_id,$tanggal_kehadiran);		
			if($check_out->num_rows() == 1){
				$early_time =  new DateTime($out_time.' '.$tanggal_kehadiran);
				$first_out = $this->Timesheet_model->kehadiran_pulang_pertama($karyawan[0]->user_id,$tanggal_kehadiran);
				$clock_out = new DateTime($first_out[0]->clock_out);
				if ($first_out[0]->clock_out!='') {
					$clock_out2 = $clock_out->format('h:i a');
					$clkOutIp = $clock_out2.'<br><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-ipaddress="'.$kehadiran[0]->clock_out_ip_address.'" data-uid="'.$karyawan[0]->user_id.'" data-att_type="clock_out" data-start_date="'.$tanggal_kehadiran.'"><i class="ft-map-pin"></i> '.$this->lang->line('umb_attend_clkout_ip').'</button>';
					$early_new_time = strtotime($out_time.' '.$tanggal_kehadiran);
					$clock_out_time_new = strtotime($first_out[0]->clock_out);
					if($early_new_time <= $clock_out_time_new) {
						$total_time_e = '00:00';
					} else {			
						$interval_lateo = $clock_out->diff($early_time);
						$hours_e   = $interval_lateo->format('%h');
						$minutes_e = $interval_lateo->format('%i');			
						$total_time_e = $hours_e ."h ".$minutes_e."m";
					}

					$waktu_lembur =  new DateTime($out_time.' '.$tanggal_kehadiran);
					$lembur2 = $waktu_lembur->format('h:i a');
					$waktu_lembur_baru = strtotime($out_time.' '.$tanggal_kehadiran);
					$clock_out_time_new1 = strtotime($first_out[0]->clock_out);

					if($clock_out_time_new1 <= $waktu_lembur_baru) {
						$lembur2 = '00:00';
					} else {			
						$interval_lateov = $clock_out->diff($waktu_lembur);
						$hours_ov   = $interval_lateov->format('%h');
						$minutes_ov = $interval_lateov->format('%i');			
						$lembur2 = $hours_ov ."h ".$minutes_ov."m";
					}				

				} else {
					$clock_out2 =  '-';
					$total_time_e = '00:00';
					$lembur2 = '00:00';
					$clkOutIp = $clock_out2;
				}

			} else {
				$clock_out2 =  '-';
				$total_time_e = '00:00';
				$lembur2 = '00:00';
				$clkOutIp = $clock_out2;
			}		

			$full_name = $karyawan[0]->first_name.' '.$karyawan[0]->last_name;
			$perusahaan = $this->Umb_model->read_info_perusahaan($karyawan[0]->perusahaan_id);
			if(!is_null($perusahaan)){
				$prshn_nama = $perusahaan[0]->name;
			} else {
				$prshn_nama = '--';	
			}	
			$tdate = $this->Umb_model->set_date_format($tanggal_kehadiran);
			/*if($user_info[0]->user_role_id==1){
				$fclckIn = $clkInIp;
				$fclckOut = $clkOutIp;
			} else {
				$fclckIn = $clock_in2;
				$fclckOut = $clock_out2;
			}*/	
			//$tdate = $this->Umb_model->set_date_format($tanggal_kehadiran);
			$data[] = array(
				$full_name,
				$prshn_nama,
				$status,
				$tdate,
				$clock_in2,
				$clock_out2,
				$total_kerja
			);
		}
		$output = array(
			"draw" => $draw,
			 //"recordsTotal" => count($date_range),
			 //"recordsFiltered" => count($date_range),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}
	
	public function list_karyawan_cuti() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/laporans/karyawan_cuti", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$sd = $this->uri->segment(4);
		$ed = $this->uri->segment(5);
		$user_id = $this->uri->segment(6);
		$perusahaan_id = $this->uri->segment(7);
		if($user_id == '') {
			$karyawan = $this->Laporans_model->get_list_application_cuti();
		} else {
			$karyawan = $this->Laporans_model->get_list_filter_application_cuti($sd,$ed,$user_id,$perusahaan_id);
		}
		$data = array();

		foreach($karyawan->result() as $r) {		  
			
			$perusahaan = $this->Umb_model->read_info_perusahaan($r->perusahaan_id);
			if(!is_null($perusahaan)){
				$prshn_nama = $perusahaan[0]->name;
			} else {
				$prshn_nama = '--';	
			}
			$karyawan = $this->Umb_model->read_user_info($r->karyawan_id);
			
			if(!is_null($karyawan)){
				$full_name = $karyawan[0]->first_name.' '.$karyawan[0]->last_name;
			} else {
				$full_name = '--';
			}
			$rapproved = $this->Laporans_model->get_approved_list_application_cuti($r->karyawan_id);
			$approved = '<a style="cursor:pointer" data-toggle="modal" data-target=".edit-modal-data" data-opt_cuti="Approved" data-karyawan_id="'. $r->karyawan_id . '">'.$rapproved.' '.$this->lang->line('umb_view').'</a>';
			$rpending = $this->Laporans_model->get_pending_list_application_cuti($r->karyawan_id);
			$pending = '<a style="cursor:pointer" data-toggle="modal" data-target=".edit-modal-data" data-opt_cuti="Pending" data-karyawan_id="'. $r->karyawan_id . '">'.$rpending.' '.$this->lang->line('umb_view').'</a>';
			$rupcoming = $this->Laporans_model->get_upcoming_cuti_application_list($r->karyawan_id);
			$upcoming = '<a style="cursor:pointer" data-toggle="modal" data-target=".edit-modal-data" data-opt_cuti="Upcoming" data-karyawan_id="'. $r->karyawan_id . '">'.$rupcoming.' '.$this->lang->line('umb_view').'</a>';
			$rrejected = $this->Laporans_model->get_rejected_list_application_cuti($r->karyawan_id);
			$rejected = '<a style="cursor:pointer" data-toggle="modal" data-target=".edit-modal-data" data-opt_cuti="Rejected" data-karyawan_id="'. $r->karyawan_id . '">'.$rrejected.' '.$this->lang->line('umb_view').'</a>';			
			
			$data[] = array(
				$prshn_nama,
				$full_name,
				$approved,
				$pending,
				$upcoming,
				$rejected,
			);
			
		}
		$output = array(
			"draw" => $draw,
			 //"recordsTotal" => $karyawan->num_rows(),
			 //"recordsFiltered" => $karyawan->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function read_details_cuti() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('karyawan_id');
		//$result = $this->Post_pekerjaan_model->read_info_application_pekerjaan($id);
		$data = 'A';
		if(!empty($session)){ 
			$this->load->view('admin/laporans/dialog_details_cuti', $data);
		} else {
			redirect('admin/');
		}
	}
} 
?>