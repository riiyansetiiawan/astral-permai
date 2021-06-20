<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Karyawans extends MY_Controller {
	
	public function __construct() {
		parent::__construct();

		$this->load->model("Karyawans_model");
		$this->load->model("Umb_model");
		$this->load->model("Department_model");
		$this->load->model("Penunjukan_model");
		$this->load->model("Roles_model");
		$this->load->model("Location_model");
		$this->load->model("Perusahaan_model");
		$this->load->model("Timesheet_model");
		$this->load->model("Custom_fields_model");
		$this->load->model("Assets_model");
		$this->load->model("Training_model");
		$this->load->model("Trainers_model");
		$this->load->library("pagination");
		$this->load->model("Awards_model");
		$this->load->model("Perjalanan_model");
		$this->load->model("Tickets_model");
		$this->load->model("Transfers_model");
		$this->load->model("Promotion_model");
		$this->load->model("Keluhans_model");
		$this->load->model("Peringatan_model");
		$this->load->model("Project_model");
		$this->load->model("Payroll_model");
		$this->load->model("Events_model");
		$this->load->model("Meetings_model");
		$this->load->model('Eumb_model');
		$this->load->library('Pdf');
		$this->load->helper('string');
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
		$role_resources_ids = $this->Umb_model->user_role_resource();
		$data['title'] = $this->lang->line('umb_karyawans').' | '.$this->Umb_model->site_title();
		$data['all_departments'] = $this->Department_model->all_departments();
		$data['all_penunjukans'] = $this->Penunjukan_model->all_penunjukans();
		$data['all_user_roles'] = $this->Roles_model->all_user_roles();
		$data['all_shifts_kantor'] = $this->Karyawans_model->all_shifts_kantor();
		$data['get_all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$data['all_types_cuti'] = $this->Timesheet_model->all_types_cuti();
		$data['breadcrumbs'] = $this->lang->line('umb_karyawans');
		if(!in_array('13',$role_resources_ids)) {
			$data['path_url'] = 'myteam_karyawans';
		} else {
			$data['path_url'] = 'karyawans';
		}
		
		$laporans_to = get_data_laporans_team($session['user_id']);
		if(in_array('13',$role_resources_ids) || $laporans_to > 0) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/karyawans/list_karyawans", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}

	public function dashboard_staff() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('hr_title_dashboard_staff').' | '.$this->Umb_model->site_title();
		$data['all_departments'] = $this->Department_model->all_departments();
		$data['all_penunjukans'] = $this->Penunjukan_model->all_penunjukans();
		$data['all_user_roles'] = $this->Roles_model->all_user_roles();
		$data['all_shifts_kantor'] = $this->Karyawans_model->all_shifts_kantor();
		$data['get_all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$data['all_types_cuti'] = $this->Timesheet_model->all_types_cuti();
		$data['breadcrumbs'] = $this->lang->line('hr_title_dashboard_staff');
		$data['path_url'] = 'karyawans';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('422',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/karyawans/dashboard_staff", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}
	
	public function hr() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('umb_directory_karyawans').' | '.$this->Umb_model->site_title();
		$data['all_departments'] = $this->Department_model->all_departments();
		$data['all_penunjukans'] = $this->Penunjukan_model->all_penunjukans();
		$data['all_user_roles'] = $this->Roles_model->all_user_roles();
		$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		$data['get_all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$role_resources_ids = $this->Umb_model->user_role_resource();
		
		if(in_array('88',$role_resources_ids)) {
			$data['breadcrumbs'] = $this->lang->line('umb_directory_karyawans');
		} else {
			$data['breadcrumbs'] = $this->lang->line('umb_directory_karyawans').' - '.$this->lang->line('umb_my_team');
		}
		$data['path_url'] = 'directory_karyawans';
		$config = array();
		$limit_per_page = 40;
		$page = ($this->uri->segment(4)) ? ($this->uri->segment(4) - 1) : 0;
		if($this->input->post("hrastral_directory")==1){
			if($this->input->post("perusahaan_id")==0 && $this->input->post("location_id")==0 && $this->input->post("department_id")==0 && $this->input->post("penunjukan_id")==0){
				$total_records = $this->Karyawans_model->record_count();
				$data["results"] = $this->Karyawans_model->fetch_all_karyawans($limit_per_page, $page*$limit_per_page);
			} else if($this->input->post("perusahaan_id")!=0 && $this->input->post("location_id")==0 && $this->input->post("department_id")==0 && $this->input->post("penunjukan_id")==0){
				$total_records = $this->Karyawans_model->record_count_perusahaan_karyawans($this->input->post("perusahaan_id"));
				$data["results"] = $this->Karyawans_model->fetch_all_flt_perusahaan_karyawans($limit_per_page, $page*$limit_per_page,$this->input->post("perusahaan_id"));
			} else if($this->input->post("perusahaan_id")!=0 && $this->input->post("location_id")!=0 && $this->input->post("department_id")==0 && $this->input->post("penunjukan_id")==0){
				$total_records = $this->Karyawans_model->record_count_perusahaan_location_karyawans($this->input->post("perusahaan_id"),$this->input->post("location_id"));
				$data["results"] = $this->Karyawans_model->fetch_all_flt_perusahaan_location_karyawans($limit_per_page, $page*$limit_per_page,$this->input->post("perusahaan_id"),$this->input->post("location_id"));
			} else if($this->input->post("perusahaan_id")!=0 && $this->input->post("location_id")!=0 && $this->input->post("department_id")!=0 && $this->input->post("penunjukan_id")==0){
				$total_records = $this->Karyawans_model->record_count_perusahaan_location_department_karyawans($this->input->post("perusahaan_id"),$this->input->post("location_id"),$this->input->post("department_id"));
				$data["results"] = $this->Karyawans_model->fetch_all_flt_perusahaan_location_department_karyawans($limit_per_page, $page*$limit_per_page,$this->input->post("perusahaan_id"),$this->input->post("location_id"),$this->input->post("department_id"));
			} else if($this->input->post("perusahaan_id")!=0 && $this->input->post("location_id")!=0 && $this->input->post("department_id")!=0 && $this->input->post("penunjukan_id")!=0){
				$total_records = $this->Karyawans_model->record_count_perusahaan_location_department_penunjukan_karyawans($this->input->post("perusahaan_id"),$this->input->post("location_id"),$this->input->post("department_id"),$this->input->post("penunjukan_id"));
				$data["results"] = $this->Karyawans_model->fetch_all_flt_perusahaan_location_department_penunjukan_karyawans($limit_per_page, $page*$limit_per_page,$this->input->post("perusahaan_id"),$this->input->post("location_id"),$this->input->post("department_id"),$this->input->post("penunjukan_id"));
			}
		} else {
			if(in_array('88',$role_resources_ids)) {
				$total_records = $this->Karyawans_model->record_count();
				$data["results"] = $this->Karyawans_model->fetch_all_karyawans($limit_per_page, $page*$limit_per_page);
			} else {
				$total_records = $this->Karyawans_model->record_count_myteam($session['user_id']);
				$data["results"] = $this->Karyawans_model->fetch_all_team_karyawans($limit_per_page, $page*$limit_per_page);
			}
		}
		$config['base_url'] = site_url() . "admin/karyawans/hr";
		$config['total_rows'] = $total_records;
		$config['per_page'] = $limit_per_page;
		$config["uri_segment"] = 4;
	   // $config['num_links'] = 2;
		$config['use_page_numbers'] = TRUE;
		$config['reuse_query_string'] = FALSE;
		//$config['page_query_string'] = TRUE;
		//$config['use_page_numbers'] = TRUE;
		$config['num_links'] = $total_records;
		$config['cur_tag_open'] = '&nbsp;<a>';
		$config['cur_tag_close'] = '</a>';
		//$config['next_link'] = '»';
		//$config['prev_link'] = '«';
		$this->pagination->initialize($config);
		$data["links"] = $this->pagination->create_links();
		//$str_links = $this->pagination->create_links();
		//$data["links"] = explode('&nbsp;',$str_links );
		$data["total_record"] = $total_records;
		$laporans_to = get_data_laporans_team($session['user_id']);
		if(in_array('88',$role_resources_ids) || $laporans_to > 0) {
			$data['subview'] = $this->load->view("admin/karyawans/directory", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
		} else {
			redirect('admin/dashboard');
		}	  
	} 
	
	public function list_karyawans() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/karyawans/list_karyawans", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$role_resources_ids = $this->Umb_model->user_role_resource();		
		$system = $this->Umb_model->read_setting_info(1);
		$user_info = $this->Umb_model->read_user_info($session['user_id']);
		if($this->input->get("ihr")=='true'){
			if($this->input->get("perusahaan_id")==0 && $this->input->get("location_id")==0 && $this->input->get("department_id")==0 && $this->input->get("penunjukan_id")==0){
				$karyawan = $this->Karyawans_model->get_karyawans();
				
			} else if($this->input->get("perusahaan_id")!=0 && $this->input->get("location_id")==0 && $this->input->get("department_id")==0 && $this->input->get("penunjukan_id")==0){
				$karyawan = $this->Karyawans_model->get_perusahaan_flt_karyawans($this->input->get("perusahaan_id"));
			} else if($this->input->get("perusahaan_id")!=0 && $this->input->get("location_id")!=0 && $this->input->get("department_id")==0 && $this->input->get("penunjukan_id")==0){
				$karyawan = $this->Karyawans_model->get_perusahaan_flt_location_karyawans($this->input->get("perusahaan_id"),$this->input->get("location_id"));
				
			} else if($this->input->get("perusahaan_id")!=0 && $this->input->get("location_id")!=0 && $this->input->get("department_id")!=0 && $this->input->get("penunjukan_id")==0){
				$karyawan = $this->Karyawans_model->get_perusahaan_flt_location_department_karyawans($this->input->get("perusahaan_id"),$this->input->get("location_id"),$this->input->get("department_id"));
				
			} else if($this->input->get("perusahaan_id")!=0 && $this->input->get("location_id")!=0 && $this->input->get("department_id")!=0 && $this->input->get("penunjukan_id")!=0){
				$karyawan = $this->Karyawans_model->get_perusahaan_flt_location_department_penunjukan_karyawans($this->input->get("perusahaan_id"),$this->input->get("location_id"),$this->input->get("department_id"),$this->input->get("penunjukan_id"));
			}
		} else {
			if($user_info[0]->user_role_id==1) {
				$karyawan = $this->Karyawans_model->get_karyawans();
			} else {
				if(in_array('372',$role_resources_ids)) {
					$karyawan = $this->Karyawans_model->get_karyawans_untuk_lainnya($user_info[0]->perusahaan_id);
				} else if(in_array('373',$role_resources_ids)) {
					$karyawan = $this->Karyawans_model->get_karyawans_untuk_location($user_info[0]->location_id);
				} else {
					$karyawan = $this->Karyawans_model->get_karyawans_untuk_location($user_info[0]->location_id);
				}
			}
		}
		
		$data = array();
		foreach($karyawan->result() as $r) {		  
			$perusahaan = $this->Umb_model->read_info_perusahaan($r->perusahaan_id);
			if(!is_null($perusahaan)){
				$prshn_nama = $perusahaan[0]->name;
			} else {
				$prshn_nama = '--';	
			}
			
			$full_name = $r->first_name.' '.$r->last_name;
			$role = $this->Umb_model->read_user_role_info($r->user_role_id);
			if(!is_null($role)){
				$role_name = $role[0]->role_name;
			} else {
				$role_name = '--';	
			}
			$laporans_to = $this->Umb_model->read_user_info($r->laporans_to);
			
			if(!is_null($laporans_to)){
				$manager_name = $laporans_to[0]->first_name.' '.$laporans_to[0]->last_name;
			} else {
				$manager_name = '--';	
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

			$location = $this->Location_model->read_informasi_location($r->location_id);
			if(!is_null($location)){
				$nama_location = $location[0]->nama_location;
			} else {
				$nama_location = '--';	
			}
			
			$department_penunjukan = $nama_penunjukan.' ('.$nama_department.')';
			/*// get status
			if($r->is_active==0): $status = '<span class="badge badge-pill badge-danger">'.$this->lang->line('umb_karyawans_inactive').'</span>';
			elseif($r->is_active==1): $status = '<span class="badge badge-pill badge-success">'.$this->lang->line('umb_karyawans_active').'</span>';endif;*/
			
			if($r->user_id != '1') {
				if(in_array('203',$role_resources_ids)) {
					$del_opt = '<span data-toggle="tooltip" data-state="danger" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->user_id . '"><span class="fas fa-trash-restore"></span></button></span>';
				} else {
					$del_opt = '';
				}
			} else {
				$del_opt = '';
			}
			if(in_array('202',$role_resources_ids)) {
				$view_opt = '<span data-toggle="tooltip" data-state="primary" data-placement="top" title="'.$this->lang->line('umb_view_details').'"><a href="'.site_url().'admin/karyawans/detail/'.$r->user_id.'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="far fa-arrow-alt-circle-right"></span></button></a></span>';
			} else {
				$view_opt = '';
			}
			$function = $view_opt.$del_opt.'';
			if($r->type_upahh == 1){
				$bgaji = $this->Umb_model->currency_sign($r->gaji_pokok);
			} else {
				$bgaji = $this->Umb_model->currency_sign($r->upahh_harian);
			}
			
			if($r->profile_picture!='' && $r->profile_picture!='no file') {
				$ol = '<a href="'.site_url().'admin/karyawans/detail/'.$r->user_id.'"><span class="avatar box-32"><img src="'.base_url().'uploads/profile/'.$r->profile_picture.'" class="d-block ui-w-30 rounded-circle" alt=""></span></a>';
			} else {
				if($r->jenis_kelamin=='Pria') { 
					$de_file = base_url().'uploads/profile/default_male.jpg';
				} else {
					$de_file = base_url().'uploads/profile/default_female.jpg';
				}
				$ol = '<a href="'.site_url().'admin/karyawans/detail/'.$r->user_id.'"><span class="avatar box-32"><img src="'.$de_file.'" class="d-block ui-w-30 rounded-circle" alt=""></span></a>';
			}

			$shift_kantor = $this->Timesheet_model->read_informasi_shift_kantor($r->shift_kantor_id);
			if(!is_null($shift_kantor)){
				$shift = $shift_kantor[0]->nama_shift;
			} else {
				$shift = '<a href="javascript:void(0)" class="badge badge-danger">'.$this->lang->line('umb_shift_kantor_not_assigned').'</a>';	
			}			
			if(in_array('202',$role_resources_ids)) {
				$ename = '<a href="'.site_url().'admin/karyawans/detail/'.$r->user_id.'" class="d-block text-primary">'.$full_name.'</a>'; 
			} else {
				$ename = '<span class="d-block text-primary">'.$full_name.'</span>';
			}

			if($r->type_upahh==1){
				$type_upahh = $this->lang->line('umb_payroll_gaji_pokok');
				if($system[0]->is_half_monthly==1){
					$gaji_pokok = $r->gaji_pokok / 2;
				} else {
					$gaji_pokok = $r->gaji_pokok;
				}
			} else if($r->type_upahh==2){
				$type_upahh = $this->lang->line('umb_karyawan_upahh_harian');
				$gaji_pokok = $r->gaji_pokok;
			} else {
				$type_upahh = $this->lang->line('umb_payroll_gaji_pokok');
				if($system[0]->is_half_monthly==1){
					$gaji_pokok = $r->gaji_pokok / 2;
				} else {
					$gaji_pokok = $r->gaji_pokok;
				}				
			}
			$gaji_pokok = $this->Umb_model->currency_sign($gaji_pokok);
			$nama_karyawan = '<div class="media align-items-center">
			'.$ol.'
			<div class="media-body ml-2">
			'.$ename.'
			<div class="text-muted small text-truncate">'.$this->lang->line('umb_e_details_shift').': '.$shift.'</div>';
			if(in_array('421',$role_resources_ids)) {
				$nama_karyawan .= '<div class="text-muted small text-truncate"><a target="_blank" href="'.site_url('admin/karyawans/download_profile/').$r->user_id.'" class="text-muted" data-state="primary" data-placement="top" data-toggle="tooltip" title="'.$this->lang->line('umb_download_profile_title').'">'.$this->lang->line('umb_download_profile_title').' <i class="fas fa-arrow-circle-right"></i></a></div>';
			}
			if(in_array('351',$role_resources_ids)) {
				$nama_karyawan .= '<div class="text-info small text-truncate"><a href="'.site_url('admin/karyawans/setup_gaji/').$r->user_id.'" class="text-muted" data-state="primary" data-placement="top" data-toggle="tooltip" title="'.$this->lang->line('umb_gaji_title').'">'.$this->lang->line('umb_karyawan_set_gaji').': '.$gaji_pokok.' <i class="fas fa-arrow-circle-right"></i></a></div><div class="text-success small text-truncate"><a href="'.site_url('admin/karyawans/setup_gaji/').$r->user_id.'" class="text-muted" data-state="primary" data-placement="top" data-toggle="tooltip" title="'.$this->lang->line('umb_karyawan_set_gaji').'">'.$this->lang->line('left_payroll').': '.$type_upahh.' <i class="fas fa-arrow-circle-right"></i></a></div>';
			} else {
				$nama_karyawan .= '<div class="text-info small text-truncate">'.$this->lang->line('umb_karyawan_set_gaji').': '.$gaji_pokok.'</div><div class="text-success small text-truncate">'.$this->lang->line('left_payroll').': '.$type_upahh.'</div>';
			}
			$nama_karyawan .= '</div>
			</div>';
			
			$prshn_nama = '<div class="media align-items-center">
			<div class="media-body flex-truncate">
			'.$prshn_nama.'
			<div class="text-muted small text-truncate">'.$this->lang->line('umb_location').': '.$nama_location.'</div>
			<div class="text-muted small text-truncate">'.$this->lang->line('left_department').': '.$nama_department.'</div>
			<div class="text-muted small text-truncate">'.$this->lang->line('left_penunjukan').': '.$nama_penunjukan.'</div>
			</div>
			</div>';			
			$info_kontak = '<i class="fa fa-user text-muted" data-toggle="tooltip" data-state="primary" data-placement="top" title="'.$this->lang->line('dashboard_username').'"></i> '.$r->username.'<br><i class="fa fa-envelope text-muted" data-toggle="tooltip" data-state="primary" data-placement="top" title="'.$this->lang->line('dashboard_email').'"></i> '.$r->email.'<br><i class="text-muted fa fa-phone" data-state="primary" data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_nomor_kontak').'"></i> '.$r->no_kontak;
			

			if($r->is_active==0): 
				$status_btn = 'btn-outline-danger'; $status_title = $this->lang->line('umb_karyawans_inactive');
			elseif($r->is_active==1): 
				$status_btn = 'btn-success'; $status_title = $this->lang->line('umb_karyawans_active'); 
			endif;

			$role_status = $role_name.'<br><div class="btn-group" data-toggle="tooltip" data-state="primary" data-placement="top" title="'.$this->lang->line('umb_change_status').'"><button type="button" class="btn btn-sm md-btn-flat dropdown-toggle '.$status_btn.'" data-toggle="dropdown">'.$status_title.'</button><div class="dropdown-menu"><a class="dropdown-item statusinfo" href="javascript:void(0)" data-status="1" data-user-id="'.$r->user_id.'">'.$this->lang->line('umb_karyawans_active').'</a><a class="dropdown-item statusinfo" href="javascript:void(0)" data-status="2" data-user-id="'.$r->user_id.'">'.$this->lang->line('umb_karyawans_inactive').'</a></div></div>';
			$data[] = array(
				$function,
				$r->karyawan_id,
				$nama_karyawan,
				$prshn_nama,
				$info_kontak,
				$manager_name,
				$role_status,
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

	public function list_myteam_karyawans() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/karyawans/list_karyawans", $data);
		} else {
			redirect('admin/');
		}

		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$role_resources_ids = $this->Umb_model->user_role_resource();		
		$system = $this->Umb_model->read_setting_info(1);
		$user_info = $this->Umb_model->read_user_info($session['user_id']);
		$karyawan = $this->Karyawans_model->get_my_team_karyawans($session['user_id']);

		$data = array();

		foreach($karyawan->result() as $r) {		  

			$perusahaan = $this->Umb_model->read_info_perusahaan($r->perusahaan_id);
			if(!is_null($perusahaan)){
				$prshn_nama = $perusahaan[0]->name;
			} else {
				$prshn_nama = '--';	
			}

			$full_name = $r->first_name.' '.$r->last_name;

			$role = $this->Umb_model->read_user_role_info($r->user_role_id);
			if(!is_null($role)){
				$role_name = $role[0]->role_name;
			} else {
				$role_name = '--';	
			}

			$laporans_to = $this->Umb_model->read_user_info($r->laporans_to);

			if(!is_null($laporans_to)){
				$manager_name = $laporans_to[0]->first_name.' '.$laporans_to[0]->last_name;
			} else {
				$manager_name = '--';	
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

			$location = $this->Location_model->read_informasi_location($r->location_id);
			if(!is_null($location)){
				$nama_location = $location[0]->nama_location;
			} else {
				$nama_location = '--';	
			}

			$department_penunjukan = $nama_penunjukan.' ('.$nama_department.')';

			if($r->is_active==0): 
				$status = '<span class="badge bg-red">'.$this->lang->line('umb_karyawans_inactive').'</span>';
			elseif($r->is_active==1): 
				$status = '<span class="badge bg-green">'.$this->lang->line('umb_karyawans_active').'</span>';
			endif;

			if($r->user_id != '1') {
				if(in_array('203',$role_resources_ids)) {
					$del_opt = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->user_id . '"><span class="fas fa-trash-restore"></span></button></span>';
				} else {
					$del_opt = '';
				}
			} else {
				$del_opt = '';
			}
			if(in_array('202',$role_resources_ids)) {
				$view_opt = ' <span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_view_details').'"><a href="'.site_url().'admin/karyawans/detail/'.$r->user_id.'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span>';
			} else {
				$view_opt = '';
			}
			$function = $view_opt.$del_opt.'';
			if($r->type_upahh == 1){
				$bgaji = $this->Umb_model->currency_sign($r->gaji_pokok);
			} else {
				$bgaji = $this->Umb_model->currency_sign($r->upahh_harian);
			}


			if($r->profile_picture!='' && $r->profile_picture!='no file') {
				$ol = '<a href="javascript:void(0);"><span class="avatar box-32"><img src="'.base_url().'uploads/profile/'.$r->profile_picture.'" class="d-block ui-w-30 rounded-circle" alt=""></span></a>';
			} else {
				if($r->jenis_kelamin=='Pria') { 
					$de_file = base_url().'uploads/profile/default_male.jpg';
				} else {
					$de_file = base_url().'uploads/profile/default_female.jpg';
				}
				$ol = '<a href="javascript:void(0);"><span class="avatar box-32"><img src="'.$de_file.'" class="d-block ui-w-30 rounded-circle" alt=""></span></a>';
			}

			$shift_kantor = $this->Timesheet_model->read_informasi_shift_kantor($r->shift_kantor_id);
			if(!is_null($shift_kantor)){
				$shift = $shift_kantor[0]->nama_shift;
			} else {
				$shift = '--';	
			}
			if(in_array('202',$role_resources_ids)) {
				$ename = '<a href="'.site_url().'admin/karyawans/detail/'.$r->user_id.'" class="d-block text-primary">'.$full_name.'</a>'; 
			} else {
				$ename = '<span class="d-block text-primary">'.$full_name.'</span>';
			}
			$nama_karyawan = '<div class="media align-items-center">
			'.$ol.'
			<div class="media-body ml-2">
			'.$ename.'
			<div class="text-muted small text-truncate">'.$this->lang->line('umb_e_details_shift').': '.$shift.'</div>';
			if(in_array('421',$role_resources_ids)) {
				$nama_karyawan .= '<div class="text-muted small text-truncate"><a target="_blank" href="'.site_url('admin/karyawans/download_profile/').$r->user_id.'" class="text-muted">'.$this->lang->line('umb_download_profile_title').' <i class="fas fa-arrow-circle-right"></i></a></div>';
			}
			$nama_karyawan .= '</div>
			</div>';

			$prshn_nama = '<div class="media align-items-center">
			<div class="media-body flex-truncate">
			'.$prshn_nama.'
			<div class="text-muted small text-truncate">'.$this->lang->line('umb_location').': '.$nama_location.'</div>
			<div class="text-muted small text-truncate">'.$this->lang->line('left_department').': '.$nama_department.'</div>
			<div class="text-muted small text-truncate">'.$this->lang->line('left_penunjukan').': '.$nama_penunjukan.'</div>
			</div>
			</div>';			
			$info_kontak = '<i class="fa fa-user text-muted" data-toggle="tooltip" data-state="primary" data-placement="top" title="'.$this->lang->line('dashboard_username').'"></i> '.$r->username.'<br><i class="fa fa-envelope text-muted" data-toggle="tooltip" data-state="primary" data-placement="top" title="'.$this->lang->line('dashboard_email').'"></i> '.$r->email.'<br><i class="text-muted fa fa-phone" data-state="primary" data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_nomor_kontak').'"></i> '.$r->no_kontak;

			if($r->is_active==0): 
				$status_btn = 'btn-outline-danger'; $status_title = $this->lang->line('umb_karyawans_inactive');
			elseif($r->is_active==1): 
				$status_btn = 'btn-success'; $status_title = $this->lang->line('umb_karyawans_active'); 
			endif;
			$role_status = $role_name.'<br>'.$status_title;
			$data[] = array(
				$function,
				$r->karyawan_id,
				$nama_karyawan,
				$prshn_nama,
				$info_kontak,
				$manager_name,
				$role_status,
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

	public function download_profile(){

		$system = $this->Umb_model->read_setting_info(1);		

		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$role_resources_ids = $this->Umb_model->user_role_resource();
		$key = $this->uri->segment(4);
		$user = $this->Umb_model->read_user_info($key);
		if(is_null($user)){
			redirect('admin/karyawans');
		}
		if(!in_array('421',$role_resources_ids)) {
			redirect('admin/karyawans');
		}

		$_tunjuk_nama = $this->Penunjukan_model->read_informasi_penunjukan($user[0]->penunjukan_id);
		if(!is_null($_tunjuk_nama)){
			$_nama_penunjukan = $_tunjuk_nama[0]->nama_penunjukan;
		} else {
			$_nama_penunjukan = '';
		}
		$department = $this->Department_model->read_informasi_department($user[0]->department_id);
		if(!is_null($department)){
			$_nama_department = $department[0]->nama_department;
		} else {
			$_nama_department = '';
		}
		$fname = $user[0]->first_name.' '.$user[0]->last_name;

		$perusahaan = $this->Umb_model->read_info_perusahaan($user[0]->perusahaan_id);
		if(!is_null($perusahaan)){
			$nama_perusahaan = $perusahaan[0]->name;
			$alamat_1 = $perusahaan[0]->alamat_1;
			$alamat_2 = $perusahaan[0]->alamat_2;
			$kota = $perusahaan[0]->kota;
			$provinsi = $perusahaan[0]->provinsi;
			$kode_pos = $perusahaan[0]->kode_pos;
			$negara = $this->Umb_model->read_info_negara($perusahaan[0]->negara);
			if(!is_null($negara)){
				$nama_negara = $negara[0]->nama_negara;
			} else {
				$nama_negara = '--';
			}
			$c_info_email = $perusahaan[0]->email;
			$c_info_phone = $perusahaan[0]->nomor_kontak;
		} else {
			$nama_perusahaan = '--';
			$alamat_1 = '--';
			$alamat_2 = '--';
			$kota = '--';
			$provinsi = '--';
			$kode_pos = '--';
			$nama_negara = '--';
			$c_info_email = '--';
			$c_info_phone = '--';
		}
		$location = $this->Location_model->read_informasi_location($user[0]->location_id);
		if(!is_null($location)){
			$nama_location = $location[0]->nama_location;
		} else {
			$nama_location = '--';
		}
		$user_role = $this->Roles_model->read_informasi_role($user[0]->user_role_id);
		if(!is_null($user_role)){
			$iuser_role = $user_role[0]->role_name;
		} else {
			$iuser_role = '--';
		}
		// set default header data
		//$c_info_alamat = $alamat_1.' '.$alamat_2.', '.$kota.' - '.$kode_pos.', '.$nama_negara;
		$c_info_alamat = $alamat_1.' '.$alamat_2.', '.$kota.' - '.$kode_pos;
		//$email_phone_address = "$c_info_alamat \n".$this->lang->line('umb_phone')." : $c_info_phone | ".$this->lang->line('dashboard_email')." : $c_info_email ";
		$info_perusahaan = $this->lang->line('left_perusahaan').": $nama_perusahaan | ".$this->lang->line('left_location').": $nama_location \n";
		$info_penunjukan = $this->lang->line('left_department').": $_nama_department | ".$this->lang->line('left_penunjukan').": $_nama_penunjukan \n";

		$header_string = "$info_perusahaan"."$info_penunjukan";
		$pdf->SetCreator('HRASTRAL');
		$pdf->SetAuthor('HRASTRAL');
		//$pdf->SetTitle('Workable-Zone - slipgaji');
		//$pdf->SetSubject('TCPDF Tutorial');
		//$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
		if($user[0]->profile_picture!='' && $user[0]->profile_picture!='no file') {
			$ol = 'uploads/profile/'.$user[0]->profile_picture;
		} else {
			if($user[0]->jenis_kelamin=='Pria') { 
				$de_file = 'uploads/profile/default_male.jpg';
			} else {
				$de_file = 'uploads/profile/default_female.jpg';
			}
			$ol = $de_file;
		}

		$header_namae = $fname.' '.$this->lang->line('umb_profile');
		$pdf->SetHeaderData('../../../'.$ol, 15, $header_namae, $header_string);

		$pdf->setFooterData(array(0,64,0), array(0,64,128));

		$pdf->setHeaderFont(Array('helvetica', '', 11.5));
		$pdf->setFooterFont(Array('helvetica', '', 9));

		$pdf->SetDefaultMonospacedFont('courier');

		$pdf->SetMargins(15, 27, 15);
		$pdf->SetHeaderMargin(5);
		$pdf->SetFooterMargin(10);

		$pdf->SetAutoPageBreak(TRUE, 25);

		$pdf->setImageScale(1.25);
		$pdf->SetAuthor('HRASTRAL');
		$pdf->SetTitle($nama_perusahaan.' - '.$this->lang->line('umb_download_profile_title'));
		$pdf->SetSubject($this->lang->line('umb_download_profile_title'));
		$pdf->SetKeywords($this->lang->line('umb_download_profile_title'));
		$pdf->SetFont('helvetica', 'B', 10);

		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		$pdf->setFontSubsetting(true);

		$pdf->SetFont('dejavusans', '', 10, '', true);
		$pdf->AddPage();
		/*$tbl = '<br>
		<table cellpadding="1" cellspacing="1" border="0">
			<tr>
				<td align="center"><h1>'.$fname.'</h1></td>
			</tr>
		</table>
		';
		$pdf->writeHTML($tbl, true, false, false, false, '');*/
		// -----------------------------------------------------------------------------
		$tanggal_bergabung = $this->Umb_model->set_date_format($user[0]->tanggal_bergabung);
		
		$pdf->setCellPaddings(1, 1, 1, 1);
		
		$pdf->setCellMargins(0, 0, 0, 0);
		
		$pdf->SetFillColor(255, 255, 127);

		if($user[0]->status_perkawinan=='Single') {
			$mstatus = $this->lang->line('umb_status_single');
		} else if($user[0]->status_perkawinan=='Married') {
			$mstatus = $this->lang->line('umb_status_married');
		} else if($user[0]->status_perkawinan=='Widowed') {
			$mstatus = $this->lang->line('umb_status_widowed');
		} else if($user[0]->status_perkawinan=='Divorced or Separated') {
			$mstatus = $this->lang->line('umb_status_divorced_separated');
		} else {
			$mstatus = $this->lang->line('umb_status_single');
		}
		if($user[0]->is_active=='0') {
			$isactive = $this->lang->line('umb_karyawans_inactive');
		} else if($user[0]->is_active=='1') {
			$isactive = $this->lang->line('umb_karyawans_active');
		} else {
			$isactive = $this->lang->line('umb_karyawans_inactive');
		}
		$tbl_2 = '
		<table cellpadding="2" cellspacing="0" border="1">
		<tr bgcolor="#e0e0e0" >
		<td colspan="6"><strong>'.$this->lang->line('umb_e_details_basic').'</strong></td>
		</tr>
		<tr>
		<td>'.$this->lang->line('dashboard_username').'</td>
		<td colspan="2">'.$user[0]->username.'</td>
		<td>'.$this->lang->line('dashboard_email').'</td>
		<td colspan="2">'.$user[0]->email.'</td>
		</tr>
		<tr>
		<td>'.$this->lang->line('dashboard_karyawan_id').'</td>
		<td colspan="2">'.$user[0]->karyawan_id.'</td>
		<td>'.$this->lang->line('umb_karyawan_role').'</td>
		<td colspan="2">'.$iuser_role.'</td>
		</tr>
		<tr>
		<td>'.$this->lang->line('dashboard_umb_status').'</td>
		<td>'.$isactive.'</td>
		<td>'.$this->lang->line('umb_jenis_kelamin_karyawan').'</td>
		<td>'.$user[0]->jenis_kelamin.'</td>
		<td>'.$this->lang->line('umb_karyawan_mstatus').'</td>
		<td>'.$mstatus.'</td>
		</tr>
		<tr>
		<td>'.$this->lang->line('umb_karyawan_tgl_gabung').'</td>
		<td colspan="2">'.$tanggal_bergabung.'</td>
		<td>'.$this->lang->line('dashboard_kontak').'#</td>
		<td colspan="2">'.$user[0]->no_kontak.'</td>
		</tr>
		<tr>
		<td>'.$this->lang->line('umb_provinsi').'</td>
		<td>'.$user[0]->provinsi.'</td>
		<td>'.$this->lang->line('umb_kota').'</td>
		<td>'.$user[0]->kota.'</td>
		<td>'.$this->lang->line('umb_kode_pos').'</td>
		<td>'.$user[0]->kode_pos.'</td>
		</tr>
		<tr>
		<td>'.$this->lang->line('umb_alamat_karyawan').'</td>
		<td colspan="5">'.$user[0]->alamat.'</td>
		</tr>
		</table>';
		$pdf->writeHTML($tbl_2, true, false, false, false, '');

		if($user[0]->type_upahh==1){
			$gaji_opt = $this->lang->line('umb_payroll_gaji_pokok');
		} else {
			$gaji_opt = $this->lang->line('umb_karyawan_upahh_harian');
		}
		$tbl_3 = '
		<table cellpadding="2" cellspacing="0" border="1">
		<tr bgcolor="#e0e0e0">
		<td colspan="4"><strong>'.$this->lang->line('umb_gaji_title').'</strong></td>
		</tr>
		<tr>
		<td>'.$this->lang->line('umb_gaji_title').'</td>
		<td>'.$this->Umb_model->currency_sign($user[0]->gaji_pokok).'</td>
		<td>'.$this->lang->line('umb_karyawan_type_wages').'</td>
		<td>'.$gaji_opt.'</td>
		</tr>
		</table>';
		$pdf->writeHTML($tbl_3, true, false, false, false, '');

		$count_awards = $this->Umb_model->get_count_awards_karyawan($user[0]->user_id);
		if($count_awards > 0) {
			$tbl_4 = '
			<table cellpadding="2" cellspacing="0" border="1">
			<tr bgcolor="#e0e0e0">
			<td colspan="3"><strong>'.$this->lang->line('left_awards').'</strong></td>
			</tr>
			<tr>
			<td>'.$this->lang->line('umb_nama_award').'</td>
			<td>'.$this->lang->line('umb_gift').'</td>
			<td>'.$this->lang->line('umb_bulan_tahun_penghargaan').'</td>
			</tr>';
			$award = $this->Awards_model->get_awards_karyawan($user[0]->user_id);
			foreach($award->result() as $r) {

				$type_award = $this->Awards_model->read_informasi_type_award($r->type_award_id);
				if(!is_null($type_award)){
					$type_award = $type_award[0]->type_award;
				} else {
					$type_award = '--';	
				}
				$d = explode('-',$r->bulan_tahun_award);
				$get_month = date('F', mktime(0, 0, 0, $d[1], 10));
				$tanggal_award = $get_month.', '.$d[0];
				
				if($r->cash_price == '') {
					$currency = $this->Umb_model->currency_sign(0);
				} else {
					$currency = $this->Umb_model->currency_sign($r->cash_price);
				}
				$tbl_4 .= '
				<tr>
				<td>'.$type_award.'</td>
				<td>'.$r->gift_item.'</td>
				<td>'.$tanggal_award.'</td>
				</tr>';
			}
			$tbl_4 .= '</table>';
			$pdf->writeHTML($tbl_4, true, false, false, false, '');
		}

		$count_training = $this->Umb_model->get_count_karyawan_training($user[0]->user_id);
		if($count_training > 0) {
			$tbl_5 = '
			<table cellpadding="2" cellspacing="0" border="1">
			<tr bgcolor="#e0e0e0">
			<td colspan="4"><strong>'.$this->lang->line('left_training').'</strong></td>
			</tr>
			<tr>
			<td>'.$this->lang->line('left_type_training').'</td>
			<td>'.$this->lang->line('umb_trainer').'</td>
			<td>'.$this->lang->line('umb_durasi_training').'</td>
			<td>'.$this->lang->line('umb_cost').'</td>
			</tr>';
			$training = $this->Training_model->get_karyawan_training($user[0]->user_id);
			foreach($training->result() as $tr_in) {

				$type = $this->Training_model->read_informasi_type_training($tr_in->type_training_id);
				if(!is_null($type)){
					$itype = $type[0]->type;
				} else {
					$itype = '--';	
				}

				$trainer = $this->Umb_model->read_user_info($tr_in->trainer_id);

				if(!is_null($trainer)){
					$nama_trainer = $trainer[0]->first_name.' '.$trainer[0]->last_name;
				} else {
					$nama_trainer = '--';	
				}

				$finish_date = $this->Umb_model->set_date_format($tr_in->finish_date);
				if($tr_in->status_training==0):
					$status_training = $this->lang->line('umb_pending');
				elseif($tr_in->status_training==1):
					$status_training = $this->lang->line('umb_started');
				elseif($tr_in->status_training==2):
					$status_training = $this->lang->line('umb_completed');
				else:
					$status_training = $this->lang->line('umb_terminated');
				endif;
				$tbl_5 .= '
				<tr>
				<td>'.$itype.'</td>
				<td>'.$nama_trainer.'</td>
				<td>'.$finish_date.'</td>
				<td>'.$status_training.'</td>
				</tr>';
			}
			$tbl_5 .= '</table>';
			$pdf->writeHTML($tbl_5, true, false, false, false, '');
		}

		$count_peringatan = $this->Umb_model->get_count_peringatan_karyawan($user[0]->user_id);
		if($count_peringatan > 0) {
			$tbl_5 = '
			<table cellpadding="2" cellspacing="0" border="1">
			<tr bgcolor="#e0e0e0">
			<td colspan="4"><strong>'.$this->lang->line('left_peringatans').'</strong></td>
			</tr>
			<tr>
			<td>'.$this->lang->line('umb_subject').'</td>
			<td>'.$this->lang->line('umb_type_peringatan').'</td>
			<td>'.$this->lang->line('umb_tanggal_peringatan').'</td>
			<td>'.$this->lang->line('umb_peringatan_oleh').'</td>
			</tr>';
			$peringatan = $this->Peringatan_model->get_peringatan_karyawan($user[0]->user_id);
			foreach($peringatan->result() as $wr) {

				$tanggal_peringatan = $this->Umb_model->set_date_format($wr->tanggal_peringatan);

				$type_peringatan = $this->Peringatan_model->read_informasi_type_peringatan($wr->type_peringatan_id);
				if(!is_null($type_peringatan)){
					$wtype = $type_peringatan[0]->type;
				} else {
					$wtype = '--';	
				}

				$user_by = $this->Umb_model->read_user_info($wr->peringatan_oleh);
				
				if(!is_null($user_by)){
					$peringatan_oleh = $user_by[0]->first_name.' '.$user_by[0]->last_name;
				} else {
					$peringatan_oleh = '--';	
				}
				$tbl_5 .= '
				<tr>
				<td>'.$wr->subject.'</td>
				<td>'.$wtype.'</td>
				<td>'.$tanggal_peringatan.'</td>
				<td>'.$peringatan_oleh.'</td>
				</tr>';
			}
			$tbl_5 .= '</table>';
			$pdf->writeHTML($tbl_5, true, false, false, false, '');
		}

		$perjalanan_count = $this->Umb_model->get_count_perjalanan_karyawan($user[0]->user_id);
		if($perjalanan_count > 0) {
			$tbl_6 = '
			<table cellpadding="2" cellspacing="0" border="1">
			<tr bgcolor="#e0e0e0">
			<td colspan="5"><strong>'.$this->lang->line('umb_perjalanan').'</strong></td>
			</tr>
			<tr>
			<td>'.$this->lang->line('umb_visit_place').'</td>
			<td colspan="2">'.$this->lang->line('umb_budget_title').'</td>
			<td>'.$this->lang->line('dashboard_umb_status').'</td>
			<td>'.$this->lang->line('umb_end_date').'</td>
			</tr>';
			$perjalanan = $this->Perjalanan_model->get_karyawan_perjalanan($user[0]->user_id);
			foreach($perjalanan->result() as $prjln) {
				//$tanggal_peringatan = $this->Umb_model->set_date_format($prjln->tanggal_peringatan);
				if($prjln->status==0):
					$status = $this->lang->line('umb_pending');
				elseif($prjln->status==1):
					$status = $this->lang->line('umb_accepted');
				else:
					$status = $this->lang->line('umb_rejected');
				endif;
				$expected_budget = $this->Umb_model->currency_sign($prjln->expected_budget);
				$actual_budget = $this->Umb_model->currency_sign($prjln->actual_budget);	
				$t_budget= $this->lang->line('umb_expected_perjalanan_budget').': '.$expected_budget.'<br>'.$this->lang->line('umb_actual_perjalanan_budget').': '.$expected_budget;
				$end_date = $this->Umb_model->set_date_format($prjln->end_date);
				$tbl_6 .= '
				<tr>
				<td>'.$prjln->visit_place.'</td>
				<td colspan="2">'.$t_budget.'</td>
				<td>'.$status.'</td>
				<td>'.$end_date.'</td>
				</tr>';
			}
			$tbl_6 .= '</table>';
			$pdf->writeHTML($tbl_6, true, false, false, false, '');
		}
		
		$tickets_count = $this->Umb_model->get_count_tickets_karyawan($user[0]->user_id);
		if($tickets_count > 0) {
			$tbl_7 = '
			<table cellpadding="2" cellspacing="0" border="1">
			<tr bgcolor="#e0e0e0">
			<td colspan="5"><strong>'.$this->lang->line('left_tickets').'</strong></td>
			</tr>
			<tr>
			<td>'.$this->lang->line('umb_kode_ticket').'</td>
			<td>'.$this->lang->line('umb_subject').'</td>
			<td>'.$this->lang->line('umb_p_priority').'</td>
			<td  colspan="2">'.$this->lang->line('umb_e_details_tanggal').'</td>
			</tr>';
			$ticket = $this->Tickets_model->get_tickets_karyawan($user[0]->user_id);
			foreach($ticket->result() as $tkts) {
				
				if($tkts->ticket_priority==0):
					$ticket_priority = $this->lang->line('umb_low');
				elseif($tkts->ticket_priority==2):
					$ticket_priority = $this->lang->line('umb_medium');
				elseif($tkts->ticket_priority==3):
					$ticket_priority = $this->lang->line('umb_high');
				elseif($tkts->ticket_priority==4):
					$ticket_priority = $this->lang->line('umb_critical');	
				else:
					$ticket_priority = $this->lang->line('umb_low');
				endif;
				if($tkts->status_ticket==1):
					$status = $this->lang->line('umb_open');
				else:
					$status = $this->lang->line('umb_closed');
				endif;			
				
				$ikode_ticket = $tkts->kode_ticket.'<br>'.$status;
				$created_at = date('h:i A', strtotime($tkts->created_at));
				$_date = explode(' ',$tkts->created_at);
				$edate = $this->Umb_model->set_date_format($_date[0]);
				$_created_at = $edate. ' '. $created_at;
				
				$tbl_7 .= '
				<tr>
				<td>'.$ikode_ticket.'</td>
				<td>'.$tkts->subject.'</td>
				<td>'.$ticket_priority.'</td>
				<td colspan="2">'.$_created_at.'</td>
				</tr>';
			}
			$tbl_7 .= '</table>';
			$pdf->writeHTML($tbl_7, true, false, false, false, '');
		}
		
		$projects_count = $this->Umb_model->get_count_projects_karyawan($user[0]->user_id);
		if($projects_count > 0) {
			$tbl_8 = '
			<table cellpadding="2" cellspacing="0" border="1">
			<tr bgcolor="#e0e0e0">
			<td colspan="5"><strong>'.$this->lang->line('left_projects').'</strong></td>
			</tr>
			<tr>
			<td>'.$this->lang->line('dashboard_umb_title').'</td>
			<td>'.$this->lang->line('dashboard_umb_progress').'</td>
			<td>'.$this->lang->line('umb_end_date').'</td>
			<td  colspan="2">'.$this->lang->line('dashboard_umb_status').'</td>
			</tr>';
			$project = $this->Project_model->get_projects_karyawan($user[0]->user_id);
			foreach($project->result() as $prj) {
				
				if($prj->status == 0) {
					$status = $this->lang->line('umb_not_started');
				} else if($prj->status ==1){
					$status = $this->lang->line('umb_in_progress');
				} else if($prj->status ==2){
					$status = $this->lang->line('umb_completed');
				} else {
					$status = $this->lang->line('umb_deffered');
				}	
				
				$pdate = $this->Umb_model->set_date_format($prj->end_date);
				
				$tbl_8 .= '
				<tr>
				<td>'.$prj->title.'</td>
				<td>'.$prj->progress_project.'% '.$this->lang->line('umb_completed').'</td>
				<td>'.$pdate.'</td>
				<td colspan="2">'.$status.'</td>
				</tr>';
			}
			$tbl_8 .= '</table>';
			$pdf->writeHTML($tbl_8, true, false, false, false, '');
		}
		// tugass
		$tugass_count = $this->Umb_model->get_count_tugass_karyawan($user[0]->user_id);
		if($tugass_count > 0) {
			$tbl_9 = '
			<table cellpadding="2" cellspacing="0" border="1">
			<tr bgcolor="#e0e0e0">
			<td colspan="5"><strong>'.$this->lang->line('left_tugass').'</strong></td>
			</tr>
			<tr>
			<td>'.$this->lang->line('dashboard_umb_title').'</td>
			<td>'.$this->lang->line('dashboard_umb_progress').'</td>
			<td>'.$this->lang->line('umb_end_date').'</td>
			<td  colspan="2">'.$this->lang->line('dashboard_umb_status').'</td>
			</tr>';
			$tugas = $this->Timesheet_model->get_tugass_karyawan($user[0]->user_id);
			foreach($tugas->result() as $tgs) {
				
				$tdate = $this->Umb_model->set_date_format($tgs->end_date);							
				if($tgs->status_tugas == 0) {
					$status = $this->lang->line('umb_not_started');
				} else if($tgs->status_tugas ==1){
					$status = $this->lang->line('umb_in_progress');
				} else if($tgs->status_tugas ==2){
					$status = $this->lang->line('umb_completed');
				} else {
					$status = $this->lang->line('umb_deffered');
				}
				
				$tbl_9 .= '
				<tr>
				<td>'.$tgs->nama_tugas.'</td>
				<td>'.$tgs->progress_tugas.'% '.$this->lang->line('umb_completed').'</td>
				<td>'.$tdate.'</td>
				<td colspan="2">'.$status.'</td>
				</tr>';
			}
			$tbl_9 .= '</table>';
			$pdf->writeHTML($tbl_9, true, false, false, false, '');
		}

		$assets_count = $this->Umb_model->get_count_assets_karyawan($user[0]->user_id);
		if($assets_count > 0) {
			$tbl_10 = '
			<table cellpadding="2" cellspacing="0" border="1">
			<tr bgcolor="#e0e0e0">
			<td colspan="5"><strong>'.$this->lang->line('umb_assets').'</strong></td>
			</tr>
			<tr>
			<td>'.$this->lang->line('umb_nama_asset').'</td>
			<td>'.$this->lang->line('umb_acc_kategori').'</td>
			<td colspan="2">'.$this->lang->line('umb_kode_asset_perusahaan').'</td>
			<td>'.$this->lang->line('umb_sedang_bekerja').'</td>
			</tr>';
			$assets = $this->Assets_model->get_assets_karyawan($user[0]->user_id);
			foreach($assets->result() as $asts) {
				
				$kategori_assets = $this->Assets_model->read_info_kategori_assets($asts->kategori_assets_id);
				if(!is_null($kategori_assets)){
					$kategori = $kategori_assets[0]->nama_kategori;
				} else {
					$kategori = '--';	
				}		

				if($asts->sedang_bekerja==1){
					$bekerja = $this->lang->line('umb_yes');
				} else {
					$bekerja = $this->lang->line('umb_no');
				}
				
				$tbl_10 .= '
				<tr>
				<td>'.$asts->name.'</td>
				<td>'.$kategori.'</td>
				<td colspan="2">'.$asts->kode_asset_perusahaan.'</td>
				<td>'.$bekerja.'</td>
				</tr>';
			}
			$tbl_10 .= '</table>';
			$pdf->writeHTML($tbl_10, true, false, false, false, '');
		}
		
		$meetings_count = $this->Umb_model->get_count_meetings_karyawan($user[0]->user_id);
		if($meetings_count > 0) {
			$tbl_11 = '
			<table cellpadding="2" cellspacing="0" border="1">
			<tr bgcolor="#e0e0e0">
			<td colspan="3"><strong>'.$this->lang->line('umb_hr_meetings').'</strong></td>
			</tr>
			<tr>
			<td>'.$this->lang->line('umb_hr_title_meeting').'</td>
			<td>'.$this->lang->line('umb_hr_tanggal_meeting').'</td>
			<td>'.$this->lang->line('umb_hr_waktu_meeting').'</td>
			</tr>';
			$meetings = $this->Meetings_model->get_meetings_karyawan($user[0]->user_id);
			foreach($meetings->result() as $meetings_hr) {
				
				$tanggal_meeting = $this->Umb_model->set_date_format($meetings_hr->tanggal_meeting);	
				$waktu_meeting = new DateTime($meetings_hr->waktu_meeting);
				$metime = $waktu_meeting->format('h:i a');
				
				$tbl_11 .= '
				<tr>
				<td>'.$meetings_hr->title_meeting.'</td>
				<td>'.$tanggal_meeting.'</td>
				<td>'.$metime.'</td>
				</tr>';
			}
			$tbl_11 .= '</table>';
			$pdf->writeHTML($tbl_11, true, false, false, false, '');
		}
		// events
		$events_count = $this->Umb_model->get_count_events_karyawan($user[0]->user_id);
		if($events_count > 0) {
			$tbl_12 = '
			<table cellpadding="2" cellspacing="0" border="1">
			<tr bgcolor="#e0e0e0">
			<td colspan="3"><strong>'.$this->lang->line('umb_hr_events').'</strong></td>
			</tr>
			<tr>
			<td>'.$this->lang->line('umb_hr_event_title').'</td>
			<td>'.$this->lang->line('umb_hr_event_date').'</td>
			<td>'.$this->lang->line('umb_hr_event_time').'</td>
			</tr>';
			$events = $this->Events_model->get_events_karyawan($user[0]->user_id);
			foreach($events->result() as $events_hr) {
				
				$sdate = $this->Umb_model->set_date_format($events_hr->event_date);

				$event_time = new DateTime($events_hr->event_time);
				$etime = $event_time->format('h:i a');
				
				$tbl_12 .= '
				<tr>
				<td>'.$events_hr->event_title.'</td>
				<td>'.$sdate.'</td>
				<td>'.$etime.'</td>
				</tr>';
			}
			$tbl_12 .= '</table>';
			$pdf->writeHTML($tbl_12, true, false, false, false, '');
		}
		
		$fname = strtolower($fname);
		$pay_month = strtolower(date("F Y"));
		ob_start();
		$pdf->Output('slipgaji_'.$fname.'_'.$pay_month.'.pdf', 'I');
		ob_end_flush();
	}
	
	public function list_karyawans_card() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/karyawans/list_karyawans", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$karyawan = $this->Karyawans_model->get_karyawans();
		$negaraa = $this->Umb_model->get_negaraa();
		
		$data = array();
		$function = '<table>';
		foreach (array_chunk($negaraa, 4) as $row) {		  
			$function .= '<tr>';
			foreach ($row as $value) {
				$function .='<td>
				<div class="col-xl-12 col-md-12 col-xs-12">
				<div class="card">
				<div class="text-xs-center">
				<div class="card-block">
				<img src="'.base_url().'skin/app-assets/images/portrait/medium/avatar-m-4.png" class="rounded-circle  height-150" alt="Card image">
				</div>
				<div class="card-block">
				<h4 class="card-title">asddd</h4>
				<h6 class="card-subtitle text-muted">asddd</h6>
				</div>
				<div class="text-xs-center">
				<a href="#" class="btn btn-social-icon mr-1 mb-1 btn-outline-facebook"><span class="fa fa-facebook"></span></a>
				<a href="#" class="btn btn-social-icon mr-1 mb-1 btn-outline-twitter"><span class="fa fa-twitter"></span></a>
				<a href="#" class="btn btn-social-icon mb-1 btn-outline-linkedin"><span class="fa fa-linkedin font-medium-4"></span></a>
				</div>
				</div>
				</div>
				</div>
				</td>';	
				$function .='</tr>';
			}	
			$data[] = array(
				$function
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
	
	public function detail() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$id = $this->uri->segment(4);
		$result = $this->Karyawans_model->read_informasi_karyawan($id);
		if(is_null($result)){
			redirect('admin/karyawans');
		}
		$role_resources_ids = $this->Umb_model->user_role_resource();
		$check_role = $this->Karyawans_model->read_informasi_karyawan($session['user_id']);
		if(!in_array('202',$role_resources_ids)) {
			redirect('admin/karyawans');
		}
		/*if($check_role[0]->user_id!=$result[0]->user_id) {
			redirect('admin/karyawans');
		}*/
		
		//$role_resources_ids = $this->Umb_model->user_role_resource();
		//$data['breadcrumbs'] = $this->lang->line('umb_details_karyawan');
		//$data['path_url'] = 'detail_karyawans';	

		$data = array(
			'breadcrumbs' => $this->lang->line('umb_detail_karyawan'),
			'path_url' => 'detail_karyawans',
			'first_name' => $result[0]->first_name,
			'last_name' => $result[0]->last_name,
			'user_id' => $result[0]->user_id,
			'karyawan_id' => $result[0]->karyawan_id,
			'perusahaan_id' => $result[0]->perusahaan_id,
			'location_id' => $result[0]->location_id,
			'shift_kantor_id' => $result[0]->shift_kantor_id,
			'elaporans_to' => $result[0]->laporans_to,
			'username' => $result[0]->username,
			'email' => $result[0]->email,
			'department_id' => $result[0]->department_id,
			'sub_department_id' => $result[0]->sub_department_id,
			'penunjukan_id' => $result[0]->penunjukan_id,
			'user_role_id' => $result[0]->user_role_id,
			'tanggal_lahir' => $result[0]->tanggal_lahir,
			'date_of_leaving' => $result[0]->date_of_leaving,
			'jenis_kelamin' => $result[0]->jenis_kelamin,
			'status_perkawinan' => $result[0]->status_perkawinan,
			'no_kontak' => $result[0]->no_kontak,
			'provinsi' => $result[0]->provinsi,
			'kota' => $result[0]->kota,
			'kode_pos' => $result[0]->kode_pos,
			'golongan_darah' => $result[0]->golongan_darah,
			'kebangsaan_id' => $result[0]->kebangsaan_id,
			'kewarganegaraan_id' => $result[0]->kewarganegaraan_id,
			'itype_sukubangsa' => $result[0]->type_sukubangsa,
			'alamat' => $result[0]->alamat,
			'type_upahh' => $result[0]->type_upahh,
			'gaji_pokok' => $result[0]->gaji_pokok,
			'is_active' => $result[0]->is_active,
			'tanggal_bergabung' => $result[0]->tanggal_bergabung,
			'all_departments' => $this->Department_model->all_departments(),
			'all_penunjukans' => $this->Penunjukan_model->all_penunjukans(),
			'all_user_roles' => $this->Roles_model->all_user_roles(),
			'title' => $this->lang->line('umb_detail_karyawan').' | '.$this->Umb_model->site_title(),
			'profile_picture' => $result[0]->profile_picture,
			'facebook_link' => $result[0]->facebook_link,
			'twitter_link' => $result[0]->twitter_link,
			'blogger_link' => $result[0]->blogger_link,
			'linkdedin_link' => $result[0]->linkdedin_link,
			'google_plus_link' => $result[0]->google_plus_link,
			'instagram_link' => $result[0]->instagram_link,
			'pinterest_link' => $result[0]->pinterest_link,
			'youtube_link' => $result[0]->youtube_link,
			'kategoris_cuti' => $result[0]->kategoris_cuti,
			'view_perusahaans_id' => $result[0]->view_perusahaans_id,
			'all_negaraa' => $this->Umb_model->get_negaraa(),
			'all_types_document' => $this->Karyawans_model->all_types_document(),
			'all_tingkat_pendidikan' => $this->Karyawans_model->all_tingkat_pendidikan(),
			'all_qualification_language' => $this->Karyawans_model->all_qualification_language(),
			'all_qualification_skill' => $this->Karyawans_model->all_qualification_skill(),
			'all_types_kontrak' => $this->Karyawans_model->all_types_kontrak(),
			'all_kontrakk' => $this->Karyawans_model->all_kontrakk(),
			'all_shifts_kantor' => $this->Karyawans_model->all_shifts_kantor(),
			'get_all_perusahaans' => $this->Umb_model->get_perusahaans(),
			'all_locations_kantor' => $this->Location_model->all_locations_kantor(),
			'all_types_cuti' => $this->Timesheet_model->all_types_cuti(),
			'all_negaraa' => $this->Umb_model->get_negaraa()
		);
		
		$data['subview'] = $this->load->view("admin/karyawans/detail_karyawan", $data, TRUE);
		$this->load->view('admin/layout/layout_main', $data); 
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}

	public function setup_gaji() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$id = $this->uri->segment(4);
		$result = $this->Karyawans_model->read_informasi_karyawan($id);
		if(is_null($result)){
			redirect('admin/karyawans');
		}
		$role_resources_ids = $this->Umb_model->user_role_resource();
		$check_role = $this->Karyawans_model->read_informasi_karyawan($session['user_id']);
		if(!in_array('351',$role_resources_ids)) {
			redirect('admin/karyawans');
		}
		/*if($check_role[0]->user_id!=$result[0]->user_id) {
			redirect('admin/karyawans');
		}*/
		
		//$role_resources_ids = $this->Umb_model->user_role_resource();
		//$data['breadcrumbs'] = $this->lang->line('umb_details_karyawan');
		//$data['path_url'] = 'detail_karyawans';	

		$data = array(
			'breadcrumbs' => $this->lang->line('umb_karyawan_set_gaji'),
			'path_url' => 'setup_gaji',
			'first_name' => $result[0]->first_name,
			'last_name' => $result[0]->last_name,
			'user_id' => $result[0]->user_id,
			'karyawan_id' => $result[0]->karyawan_id,
			'perusahaan_id' => $result[0]->perusahaan_id,
			'location_id' => $result[0]->location_id,
			'shift_kantor_id' => $result[0]->shift_kantor_id,
			'elaporans_to' => $result[0]->laporans_to,
			'username' => $result[0]->username,
			'email' => $result[0]->email,
			'department_id' => $result[0]->department_id,
			'sub_department_id' => $result[0]->sub_department_id,
			'penunjukan_id' => $result[0]->penunjukan_id,
			'user_role_id' => $result[0]->user_role_id,
			'tanggal_lahir' => $result[0]->tanggal_lahir,
			'date_of_leaving' => $result[0]->date_of_leaving,
			'jenis_kelamin' => $result[0]->jenis_kelamin,
			'status_perkawinan' => $result[0]->status_perkawinan,
			'no_kontak' => $result[0]->no_kontak,
			'provinsi' => $result[0]->provinsi,
			'kota' => $result[0]->kota,
			'kode_pos' => $result[0]->kode_pos,
			'golongan_darah' => $result[0]->golongan_darah,
			'kebangsaan_id' => $result[0]->kebangsaan_id,
			'kewarganegaraan_id' => $result[0]->kewarganegaraan_id,
			'itype_sukubangsa' => $result[0]->type_sukubangsa,
			'alamat' => $result[0]->alamat,
			'type_upahh' => $result[0]->type_upahh,
			'gaji_pokok' => $result[0]->gaji_pokok,
			'is_active' => $result[0]->is_active,
			'tanggal_bergabung' => $result[0]->tanggal_bergabung,
			'all_departments' => $this->Department_model->all_departments(),
			'all_penunjukans' => $this->Penunjukan_model->all_penunjukans(),
			'all_user_roles' => $this->Roles_model->all_user_roles(),
			'title' => $this->lang->line('umb_detail_karyawan').' | '.$this->Umb_model->site_title(),
			'profile_picture' => $result[0]->profile_picture,
			'facebook_link' => $result[0]->facebook_link,
			'twitter_link' => $result[0]->twitter_link,
			'blogger_link' => $result[0]->blogger_link,
			'linkdedin_link' => $result[0]->linkdedin_link,
			'google_plus_link' => $result[0]->google_plus_link,
			'instagram_link' => $result[0]->instagram_link,
			'pinterest_link' => $result[0]->pinterest_link,
			'youtube_link' => $result[0]->youtube_link,
			'kategoris_cuti' => $result[0]->kategoris_cuti,
			'view_perusahaans_id' => $result[0]->view_perusahaans_id,
			'all_negaraa' => $this->Umb_model->get_negaraa(),
			'all_types_document' => $this->Karyawans_model->all_types_document(),
			'all_tingkat_pendidikan' => $this->Karyawans_model->all_tingkat_pendidikan(),
			'all_qualification_language' => $this->Karyawans_model->all_qualification_language(),
			'all_qualification_skill' => $this->Karyawans_model->all_qualification_skill(),
			'all_types_kontrak' => $this->Karyawans_model->all_types_kontrak(),
			'all_kontrakk' => $this->Karyawans_model->all_kontrakk(),
			'all_shifts_kantor' => $this->Karyawans_model->all_shifts_kantor(),
			'get_all_perusahaans' => $this->Umb_model->get_perusahaans(),
			'all_locations_kantor' => $this->Location_model->all_locations_kantor(),
			'all_types_cuti' => $this->Timesheet_model->all_types_cuti(),
			'all_negaraa' => $this->Umb_model->get_negaraa()
		);
		
		$data['subview'] = $this->load->view("admin/karyawans/setup_karyawan_gaji", $data, TRUE);
		$this->load->view('admin/layout/layout_main', $data); 
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}
	
	public function get_departments() {

		$data['title'] = $this->Umb_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'perusahaan_id' => $id
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/karyawans/get_departments", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	} 
	
	public function dialog_kontak() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('field_id');
		$result = $this->Karyawans_model->read_informasi_kontak($id);
		$data = array(
			'kontak_id' => $result[0]->kontak_id,
			'karyawan_id' => $result[0]->karyawan_id,
			'relation' => $result[0]->relation,
			'is_primary' => $result[0]->is_primary,
			'is_dependent' => $result[0]->is_dependent,
			'kontak_name' => $result[0]->kontak_name,
			'phone_kerja' => $result[0]->phone_kerja,
			'extension_phone_kerja' => $result[0]->extension_phone_kerja,
			'mobile_phone' => $result[0]->mobile_phone,
			'home_phone' => $result[0]->home_phone,
			'email_kerja' => $result[0]->email_kerja,
			'email_pribadi' => $result[0]->email_pribadi,
			'alamat_1' => $result[0]->alamat_1,
			'alamat_2' => $result[0]->alamat_2,
			'kota' => $result[0]->kota,
			'provinsi' => $result[0]->provinsi,
			'kode_pos' => $result[0]->kode_pos,
			'inegara' => $result[0]->negara,
			'all_negaraa' => $this->Umb_model->get_negaraa()
		);
		if(!empty($session)){ 
			$this->load->view('admin/karyawans/dialog_details_karyawan', $data);
		} else {
			redirect('admin/');
		}
	}

	public function get_perusahaan_elocations() {

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
				$this->load->view("admin/karyawans/get_perusahaan_elocations", $data);
			} else {
				redirect('admin/');
			}
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}

	public function get_perusahaan_shifts_kantor() {

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
				$this->load->view("admin/karyawans/get_perusahaan_shifts_kantor", $data);
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
				'location_id' => $id
			);
			$session = $this->session->userdata('username');
			if(!empty($session)){ 
				$data = $this->security->xss_clean($data);
				$this->load->view("admin/karyawans/get_location_departments", $data);
			} else {
				redirect('admin/');
			}
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}
	public function dialog_document() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('field_id');
		$document = $this->Karyawans_model->read_informasi_document($id);
		$data = array(
			'document_id' => $document[0]->document_id,
			'type_document_id' => $document[0]->type_document_id,
			'd_karyawan_id' => $document[0]->karyawan_id,
			'all_types_document' => $this->Karyawans_model->all_types_document(),
			'tanggal_kadaluarsa' => $document[0]->tanggal_kadaluarsa,
			'title' => $document[0]->title,
				//'is_alert' => $document[0]->is_alert,
			'description' => $document[0]->description,
				//'notification_email' => $document[0]->notification_email,
			'document_file' => $document[0]->document_file
		);
		if(!empty($session)){ 
			$this->load->view('admin/karyawans/dialog_details_karyawan', $data);
		} else {
			redirect('admin/');
		}
	}
	
	public function dialog_imgdocument() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('field_id');
		$document = $this->Karyawans_model->read_informasi_imgdocument($id);
		$data = array(
			'immigration_id' => $document[0]->immigration_id,
			'type_document_id' => $document[0]->type_document_id,
			'd_karyawan_id' => $document[0]->karyawan_id,
			'all_types_document' => $this->Karyawans_model->all_types_document(),
			'all_negaraa' => $this->Umb_model->get_negaraa(),
			'nomor_document' => $document[0]->nomor_document,
			'document_file' => $document[0]->document_file,
			'tanggal_terbit' => $document[0]->tanggal_terbit,
			'tanggal_kaaluarsa' => $document[0]->tanggal_kaaluarsa,
			'negara_id' => $document[0]->negara_id,
			'tanggal_tinjauan_yang_memenuhi_syarat' => $document[0]->tanggal_tinjauan_yang_memenuhi_syarat,
		);
		if(!empty($session)){ 
			$this->load->view('admin/karyawans/dialog_details_karyawan', $data);
		} else {
			redirect('admin/');
		}
	}
	
	public function dialog_qualification() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('field_id');
		$result = $this->Karyawans_model->read_informasi_qualification($id);
		$data = array(
			'qualification_id' => $result[0]->qualification_id,
			'karyawan_id' => $result[0]->karyawan_id,
			'name' => $result[0]->name,
			'tingkat_pendidikan_id' => $result[0]->tingkat_pendidikan_id,
			'from_year' => $result[0]->from_year,
			'language_id' => $result[0]->language_id,
			'to_year' => $result[0]->to_year,
			'skill_id' => $result[0]->skill_id,
			'description' => $result[0]->description,
			'all_tingkat_pendidikan' => $this->Karyawans_model->all_tingkat_pendidikan(),
			'all_qualification_language' => $this->Karyawans_model->all_qualification_language(),
			'all_qualification_skill' => $this->Karyawans_model->all_qualification_skill()
		);
		if(!empty($session)){ 
			$this->load->view('admin/karyawans/dialog_details_karyawan', $data);
		} else {
			redirect('admin/');
		}
	}

	public function dialog_pengalaman_kerja() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('field_id');
		$result = $this->Karyawans_model->read_informasi_pengalaman_kerja($id);
		$data = array(
			'pengalaman_kerja_id' => $result[0]->pengalaman_kerja_id,
			'karyawan_id' => $result[0]->karyawan_id,
			'nama_perusahaan' => $result[0]->nama_perusahaan,
			'from_date' => $result[0]->from_date,
			'to_date' => $result[0]->to_date,
			'post' => $result[0]->post,
			'description' => $result[0]->description
		);
		if(!empty($session)){ 
			$this->load->view('admin/karyawans/dialog_details_karyawan', $data);
		} else {
			redirect('admin/');
		}
	}
	
	public function dialog_bank_account() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('field_id');
		$result = $this->Karyawans_model->read_informasi_bank_account($id);
		$data = array(
			'bankaccount_id' => $result[0]->bankaccount_id,
			'karyawan_id' => $result[0]->karyawan_id,
			'is_primary' => $result[0]->is_primary,
			'account_title' => $result[0]->account_title,
			'nomor_account' => $result[0]->nomor_account,
			'nama_bank' => $result[0]->nama_bank,
			'kode_bank' => $result[0]->kode_bank,
			'cabang_bank' => $result[0]->cabang_bank
		);
		if(!empty($session)){ 
			$this->load->view('admin/karyawans/dialog_details_karyawan', $data);
		} else {
			redirect('admin/');
		}
	}
	
	public function dialog_kontrak() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('field_id');
		$result = $this->Karyawans_model->read_informasi_kontrak($id);
		$data = array(
			'kontrak_id' => $result[0]->kontrak_id,
			'karyawan_id' => $result[0]->karyawan_id,
			'type_kontrak_id' => $result[0]->type_kontrak_id,
			'from_date' => $result[0]->from_date,
			'penunjukan_id' => $result[0]->penunjukan_id,
			'title' => $result[0]->title,
			'to_date' => $result[0]->to_date,
			'description' => $result[0]->description,
			'all_types_kontrak' => $this->Karyawans_model->all_types_kontrak(),
			'all_penunjukans' => $this->Penunjukan_model->all_penunjukans(),
		);
		if(!empty($session)){ 
			$this->load->view('admin/karyawans/dialog_details_karyawan', $data);
		} else {
			redirect('admin/');
		}
	}
	
	public function dialog_cuti() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('field_id');
		$result = $this->Karyawans_model->read_informasi_cuti($id);
		$data = array(
			'cuti_id' => $result[0]->cuti_id,
			'karyawan_id' => $result[0]->karyawan_id,
			'kontrak_id' => $result[0]->kontrak_id,
			'casual_cuti' => $result[0]->casual_cuti,
			'medical_cuti' => $result[0]->medical_cuti
		);
		if(!empty($session)){ 
			$this->load->view('admin/karyawans/dialog_details_karyawan', $data);
		} else {
			redirect('admin/');
		}
	}
	
	public function dialog_shift() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('field_id');
		$result = $this->Karyawans_model->read_informasi_shift_krywn($id);
		$data = array(
			'emp_shift_id' => $result[0]->emp_shift_id,
			'karyawan_id' => $result[0]->karyawan_id,
			'shift_id' => $result[0]->shift_id,
			'from_date' => $result[0]->from_date,
			'to_date' => $result[0]->to_date
		);
		if(!empty($session)){ 
			$this->load->view('admin/karyawans/dialog_details_karyawan', $data);
		} else {
			redirect('admin/');
		}
	}
	
	public function dialog_location() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('field_id');
		$result = $this->Karyawans_model->read_informasi_location($id);
		$data = array(
			'location_kantor_id' => $result[0]->location_kantor_id,
			'karyawan_id' => $result[0]->karyawan_id,
			'location_id' => $result[0]->location_id,
			'from_date' => $result[0]->from_date,
			'to_date' => $result[0]->to_date
		);
		if(!empty($session)){ 
			$this->load->view('admin/karyawans/dialog_details_karyawan', $data);
		} else {
			redirect('admin/');
		}
	}
	
	public function dialog_gaji_tunjanagan() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('field_id');
		$result = $this->Karyawans_model->read_single_gaji_tunjanagan($id);
		$data = array(
			'tunjanagan_id' => $result[0]->tunjanagan_id,
			'karyawan_id' => $result[0]->karyawan_id,
			'is_tunjanagan_kena_pajak' => $result[0]->is_tunjanagan_kena_pajak,
			'jumlah_option' => $result[0]->jumlah_option,
			'title_tunjanagan' => $result[0]->title_tunjanagan,
			'jumlah_tunjanagan' => $result[0]->jumlah_tunjanagan
		);
		if(!empty($session)){ 
			$this->load->view('admin/karyawans/dialog_details_karyawan', $data);
		} else {
			redirect('admin/');
		}
	}
	public function dialog_gaji_komissi() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('field_id');
		$result = $this->Karyawans_model->read_single_gaji_komissi($id);
		$data = array(
			'gaji_komissi_id' => $result[0]->gaji_komissi_id,
			'karyawan_id' => $result[0]->karyawan_id,
			'is_komisi_kena_pajak' => $result[0]->is_komisi_kena_pajak,
			'jumlah_option' => $result[0]->jumlah_option,
			'komisi_title' => $result[0]->komisi_title,
			'jumlah_komisi' => $result[0]->jumlah_komisi
		);
		if(!empty($session)){ 
			$this->load->view('admin/karyawans/dialog_details_karyawan', $data);
		} else {
			redirect('admin/');
		}
	}
	public function dialog_gaji_statutory_potongans() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('field_id');
		$result = $this->Karyawans_model->read_single_gaji_statutory_potongan($id);
		$data = array(
			'statutory_potongans_id' => $result[0]->statutory_potongans_id,
			'karyawan_id' => $result[0]->karyawan_id,
			'title_potongan' => $result[0]->title_potongan,
			'jumlah_potongan' => $result[0]->jumlah_potongan,
			'statutory_options' => $result[0]->statutory_options
		);
		if(!empty($session)){ 
			$this->load->view('admin/karyawans/dialog_details_karyawan', $data);
		} else {
			redirect('admin/');
		}
	}

	public function dialog_gaji_pembayarans_lainnya() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('field_id');
		$result = $this->Karyawans_model->read_single_gaji_pembayaran_lainnya($id);
		$data = array(
			'pembayarans_lainnya_id' => $result[0]->pembayarans_lainnya_id,
			'karyawan_id' => $result[0]->karyawan_id,
			'title_pembayarans' => $result[0]->title_pembayarans,
			'jumlah_pembayarans' => $result[0]->jumlah_pembayarans,
			'ia_pembayaranlainnya_kena_pajak' => $result[0]->ia_pembayaranlainnya_kena_pajak,
			'jumlah_option' => $result[0]->jumlah_option
		);
		if(!empty($session)){ 
			$this->load->view('admin/karyawans/dialog_details_karyawan', $data);
		} else {
			redirect('admin/');
		}
	}
	
	public function dialog_gaji_pinjaman() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('field_id');
		$result = $this->Karyawans_model->read_single_potongans_pinjaman($id);
		$data = array(
			'potongan_pinjaman_id' => $result[0]->potongan_pinjaman_id,
			'karyawan_id' => $result[0]->karyawan_id,
			'title_potongan_pinjaman' => $result[0]->title_potongan_pinjaman,
			'start_date' => $result[0]->start_date,
			'end_date' => $result[0]->end_date,
			'options_pinjaman' => $result[0]->options_pinjaman,
			'angsuran_bulanan' => $result[0]->angsuran_bulanan,
			'reason' => $result[0]->reason,
			'created_at' => $result[0]->created_at
		);
		if(!empty($session)){ 
			$this->load->view('admin/karyawans/dialog_details_karyawan', $data);
		} else {
			redirect('admin/');
		}
	}

	public function dialog_krywn_lembur() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('field_id');
		$result = $this->Karyawans_model->read_record_gaji_lembur($id);
		$data = array(
			'gaji_lembur_id' => $result[0]->gaji_lembur_id,
			'karyawan_id' => $result[0]->karyawan_id,
			'type_lembur' => $result[0]->type_lembur,
			'no_of_days' => $result[0]->no_of_days,
			'jam_lembur' => $result[0]->jam_lembur,
			'nilai_lembur' => $result[0]->nilai_lembur
		);
		if(!empty($session)){ 
			$this->load->view('admin/karyawans/dialog_details_karyawan', $data);
		} else {
			redirect('admin/');
		}
	}
	
	public function penunjukan() {

		$data['title'] = $this->Umb_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'subdepartment_id' => $id,
			'all_penunjukans' => $this->Penunjukan_model->all_penunjukans(),
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/karyawans/get_penunjukans", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}
	
	public function is_penunjukan() {

		$data['title'] = $this->Umb_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'department_id' => $id,
			'all_penunjukans' => $this->Penunjukan_model->all_penunjukans(),
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/karyawans/get_penunjukans", $data);
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
			$this->load->view("admin/karyawans/get_sub_departments", $data);
		} else {
			redirect('admin/');
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
		$id = $this->input->get('peringatan_id');
		$result = $this->Peringatan_model->read_informasi_peringatan($id);
		$data = array(
			'peringatan_id' => $result[0]->peringatan_id,
			'peringatan_ke' => $result[0]->peringatan_ke,
			'peringatan_oleh' => $result[0]->peringatan_oleh,
			'tanggal_peringatan' => $result[0]->tanggal_peringatan,
			'type_peringatan_id' => $result[0]->type_peringatan_id,
			'subject' => $result[0]->subject,
			'description' => $result[0]->description,
			'status' => $result[0]->status,
			'all_karyawans' => $this->Umb_model->all_karyawans(),
			'all_types_peringatan' => $this->Peringatan_model->all_types_peringatan(),
		);
		if(!empty($session)){ 
			$this->load->view('admin/peringatan/dialog_peringatan', $data);
		} else {
			redirect('admin/');
		}
	}
	
	
	public function add_karyawan() {
		
		//$this->CI =& get_instance();
		if($this->input->post('add_type')=='karyawan') {	
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			//$shift_kantor_id = $this->input->post('shift_kantor_id');
			$system = $this->Umb_model->read_setting_info(1);
			
			if($this->input->post('first_name')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_first_name');
			} /*else if(preg_match("/^(\pL{1,}[ ]?)+$/u",$this->input->post('first_name'))!=1) {
				$Return['error'] = $this->lang->line('umb_hr_string_error');
			}*/ else if($this->input->post('last_name')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_last_name');
			} /*else if(preg_match("/^(\pL{1,}[ ]?)+$/u",$this->input->post('last_name'))!=1) {
				$Return['error'] = $this->lang->line('umb_hr_string_error');
			}*/else if($this->input->post('karyawan_id')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_karyawan_id');
			} else if($this->Karyawans_model->check_karyawan_id($this->input->post('karyawan_id')) > 0) {
				$Return['error'] = $this->lang->line('umb_karyawan_id_already_exist');
			} else if($this->input->post('tanggal_bergabung')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_tanggal_bergabung');
			} else if($this->Umb_model->validate_date($this->input->post('tanggal_bergabung'),'Y-m-d') == false) {
				$Return['error'] = $this->lang->line('umb_hr_date_format_error');
			} else if($this->input->post('perusahaan_id')==='') {
				$Return['error'] = $this->lang->line('error_field_perusahaan');
			} else if($this->input->post('department_id')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_department');
			} /*else if($this->input->post('subdepartment_id')==='') {
				$Return['error'] = $this->lang->line('umb_hr_field_sub_department_error');
			}*/ else if($this->input->post('penunjukan_id')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_penunjukan');
			} else if($this->input->post('username')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_username');
			} else if($this->Karyawans_model->check_username_karyawan($this->input->post('username')) > 0) {
				$Return['error'] = $this->lang->line('umb_karyawan_username_already_exist');
			} else if($this->input->post('email')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_email');
			} else if (!filter_var($this->input->post('email'), FILTER_VALIDATE_EMAIL)) {
				$Return['error'] = $this->lang->line('umb_karyawan_error_invalid_email');
			} else if($this->Karyawans_model->check_email_karyawan($this->input->post('email')) > 0) {
				$Return['error'] = $this->lang->line('umb_karyawan_email_already_exist');
			} else if($this->input->post('tanggal_lahir')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_tanggal_lahir');
			} else if($this->Umb_model->validate_date($this->input->post('tanggal_lahir'),'Y-m-d') == false) {
				$Return['error'] = $this->lang->line('umb_hr_date_format_error');
			} else if($this->input->post('no_kontak')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_nomor_kontak');
			} else if(!preg_match('/^([0-9]*)$/', $this->input->post('no_kontak'))) {
				$Return['error'] = $this->lang->line('umb_hr_numeric_error');
			} else if($this->input->post('password')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_password');
			} else if(strlen($this->input->post('password')) < 6) {
				$Return['error'] = $this->lang->line('umb_karyawan_error_password_least');
			} else if($this->input->post('password')!==$this->input->post('confirm_password')) {
				$Return['error'] = $this->lang->line('umb_karyawan_error_password_not_match');
			} else if($this->input->post('role')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_user_role');
			} else if($this->input->post('pin_code')==='') {
				$Return['error'] = $this->lang->line('umb_pincode_field_error');
			} else if(!filter_var($this->input->post('pin_code'), FILTER_VALIDATE_INT)) {
				$Return['error'] = $this->lang->line('umb_pincode_should_be_digits_error');
			} else if(strlen($this->input->post('pin_code')) < 6) {
				$Return['error'] = $this->lang->line('umb_pincode_six_digits_error');
			} else if($this->Karyawans_model->check_pincode_karyawan($this->input->post('pin_code')) > 0) {
				$Return['error'] = $this->lang->line('umb_pincode_already_exist');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			/*if($system[0]->multi_shifts == '1'){
				if(empty($shift_kantor_id)) {
					$Return['error'] = $this->lang->line('umb_shift_kantor_field_error');
				}
			}*/

			if($Return['error']!=''){
				$this->output($Return);
			}

			$module_attributes = $this->Custom_fields_model->all_hrastral_module_attributes();
			$count_module_attributes = $this->Custom_fields_model->count_module_attributes();	
			$i=1;
			if($count_module_attributes > 0){
				foreach($module_attributes as $mattribute) {
					if($mattribute->validation == 1){
						if($i!=1) {
						} else if($this->input->post($mattribute->attribute)=='') {
							$Return['error'] = $this->lang->line('umb_hrastral_custom_field_the').' '.$mattribute->attribute_label.' '.$this->lang->line('umb_hrastral_custom_field_is_required');
						}
					}
				}		
				if($Return['error']!=''){
					$this->output($Return);
				}	
			}

			$first_name = $this->Umb_model->clean_post($this->input->post('first_name'));
			$last_name = $this->Umb_model->clean_post($this->input->post('last_name'));
			$karyawan_id = $this->Umb_model->clean_post($this->input->post('karyawan_id'));
			$tanggal_bergabung = $this->Umb_model->clean_date_post($this->input->post('tanggal_bergabung'));
			$username = $this->Umb_model->clean_post($this->input->post('username'));
			$tanggal_lahir = $this->Umb_model->clean_date_post($this->input->post('tanggal_lahir'));
			$no_kontak = $this->Umb_model->clean_post($this->input->post('no_kontak'));
			$alamat = $this->Umb_model->clean_post($this->input->post('alamat'));

			$options = array('cost' => 12);
			$password_hash = password_hash($this->input->post('password'), PASSWORD_BCRYPT, $options);
			$kategoris_cuti = array($this->input->post('kategoris_cuti'));
			$cat_ids = implode(',',$this->input->post('kategoris_cuti'));

			$data = array(
				'karyawan_id' => $karyawan_id,
				'shift_kantor_id' => $this->input->post('shift_kantor_id'),
				'laporans_to' => $this->input->post('laporans_to'),
				'first_name' => $first_name,
				'last_name' => $last_name,
				'username' => $username,
				'perusahaan_id' => $this->input->post('perusahaan_id'),
				'location_id' => $this->input->post('location_id'),
				'email' => $this->input->post('email'),
				'password' => $password_hash,
				'pincode' => $this->input->post('pin_code'),
				'tanggal_lahir' => $tanggal_lahir,
				'jenis_kelamin' => $this->input->post('jenis_kelamin'),
				'user_role_id' => $this->input->post('role'),
				'department_id' => $this->input->post('department_id'),
				'sub_department_id' => $this->input->post('subdepartment_id'),
				'penunjukan_id' => $this->input->post('penunjukan_id'),
				'tanggal_bergabung' => $tanggal_bergabung,
				'no_kontak' => $no_kontak,
				'alamat' => $alamat,
				'is_active' => 1,
				'kategoris_cuti' => $cat_ids,
				'created_at' => date('Y-m-d h:i:s')
			);
			$iresult = $this->Karyawans_model->add($data);
			if ($iresult) {

				$id = $iresult;
				if($count_module_attributes > 0){
					foreach($module_attributes as $mattribute) {
						/*$attr_data = array(
						'user_id' => $iresult,
						'module_attributes_id' => $mattribute->custom_field_id,
						'attribute_value' => $this->input->post($mattribute->attribute),
						'created_at' => date('Y-m-d h:i:s')
						);
						$this->Custom_fields_model->add_values($attr_data);*/
						if($mattribute->attribute_type == 'fileupload'){
							if($_FILES[$mattribute->attribute]['size'] != 0) {
								if(is_uploaded_file($_FILES[$mattribute->attribute]['tmp_name'])) {

									$allowed =  array('png','jpg','jpeg','pdf','gif','xls','doc','xlsx','docx');
									$filename = $_FILES[$mattribute->attribute]['name'];
									$ext = pathinfo($filename, PATHINFO_EXTENSION);

									if(in_array($ext,$allowed)){
										$tmp_name = $_FILES[$mattribute->attribute]["tmp_name"];
										$profile = "uploads/custom_files/";
										$set_img = base_url()."uploads/custom_files/";

										$name = basename($_FILES[$mattribute->attribute]["name"]);
										$newfilename = 'custom_file_'.round(microtime(true)).'.'.$ext;
										move_uploaded_file($tmp_name, $profile.$newfilename);
										$fname = $newfilename;	
									}
									$iattr_data = array(
										'user_id' => $id,
										'module_attributes_id' => $mattribute->custom_field_id,
										'attribute_value' => $fname,
										'created_at' => date('Y-m-d h:i:s')
									);
									$this->Custom_fields_model->add_values($iattr_data);
								}
							} else {
								$iattr_data = array(
									'user_id' => $id,
									'module_attributes_id' => $mattribute->custom_field_id,
									'attribute_value' => '',
									'created_at' => date('Y-m-d h:i:s')
								);
								$this->Custom_fields_model->add_values($iattr_data);
							}
						} else if($mattribute->attribute_type == 'multiselect') {
							$multisel_val = $this->input->post($mattribute->attribute);
							if(!empty($multisel_val)){
								$newdata = implode(',', $this->input->post($mattribute->attribute));
								$iattr_data = array(
									'user_id' => $id,
									'module_attributes_id' => $mattribute->custom_field_id,
									'attribute_value' => $newdata,
									'created_at' => date('Y-m-d h:i:s')
								);
								$this->Custom_fields_model->add_values($iattr_data);
							}
						} else {
							if($this->input->post($mattribute->attribute) == ''){
								$file_val = '';
							} else {
								$file_val = $this->input->post($mattribute->attribute);
							}
							$iattr_data = array(
								'user_id' => $id,
								'module_attributes_id' => $mattribute->custom_field_id,
								'attribute_value' => $file_val,
								'created_at' => date('Y-m-d h:i:s')
							);
							$this->Custom_fields_model->add_values($iattr_data);
						}
						/*$attr_orig_value = $this->Custom_fields_model->read_hrastral_module_attributes_values($result,$mattribute->custom_field_id);
						if($attr_orig_value->module_attributes_id != $mattribute->custom_field_id) {
							$this->Custom_fields_model->add_values($attr_data);
						}*/
					}
				}

				$setting = $this->Umb_model->read_setting_info(1);
				$perusahaan = $this->Umb_model->read_info_setting_perusahaan(1);
				if($setting[0]->enable_email_notification == 'yes') {
					$this->load->library('email');
					$this->email->set_mailtype("html");

					$cinfo = $this->Umb_model->read_info_setting_perusahaan(1);

					$template = $this->Umb_model->read_email_template(8);

					$subject = $template[0]->subject.' - '.$cinfo[0]->nama_perusahaan;
					$logo = base_url().'uploads/logo/signin/'.$perusahaan[0]->sign_in_logo;

					$full_name = $this->input->post('first_name').' '.$this->input->post('last_name');

					$message = '
					<div style="background:#f6f6f6;font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;margin:0;padding:0;padding: 20px;">
					<img src="'.$logo.'" title="'.$cinfo[0]->nama_perusahaan.'"><br>'.str_replace(array("{var site_name}","{var site_url}","{var username}","{var karyawan_id}","{var nama_karyawan}","{var email}","{var password}"),array($cinfo[0]->nama_perusahaan,site_url(),$this->input->post('username'),$this->input->post('karyawan_id'),$full_name,$this->input->post('email'),$this->input->post('password')),htmlspecialchars_decode(stripslashes($template[0]->message))).'</div>';

					hrastral_mail($cinfo[0]->email,$cinfo[0]->nama_perusahaan,$this->input->post('email'),$subject,$message);				
				}
				$Return['result'] = $this->lang->line('umb_sukses_tambah_karyawan');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function basic_info() {

		if($this->input->post('type')=='basic_info') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			//$shift_kantor_id = $this->input->post('shift_kantor_id');
			$system = $this->Umb_model->read_setting_info(1);


			if($this->input->post('first_name')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_first_name');
			} /*else if(preg_match("/^(\pL{1,}[ ]?)+$/u",$this->input->post('first_name'))!=1) {
				$Return['error'] = $this->lang->line('umb_hr_string_error');
			}*/ else if($this->input->post('last_name')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_last_name');
			} /*else if(preg_match("/^(\pL{1,}[ ]?)+$/u",$this->input->post('last_name'))!=1) {
				$Return['error'] = $this->lang->line('umb_hr_string_error');
			}*/ else if($this->input->post('karyawan_id')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_karyawan_id');
			} else if($this->input->post('username')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_username');
			} else if($this->input->post('email')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_email');
			} else if (!filter_var($this->input->post('email'), FILTER_VALIDATE_EMAIL)) {
				$Return['error'] = $this->lang->line('umb_karyawan_error_invalid_email');
			} else if($this->input->post('perusahaan_id')==='') {
				$Return['error'] = $this->lang->line('error_field_perusahaan');
			} else if($this->input->post('location_id')==='') {
				$Return['error'] = $this->lang->line('umb_field_location_error');
			} else if($this->input->post('department_id')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_department');
			} else if($this->input->post('subdepartment_id')==='') {
				$Return['error'] = $this->lang->line('umb_hr_field_sub_department_error');
			} else if($this->input->post('penunjukan_id')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_penunjukan');
			} else if($this->input->post('tanggal_lahir')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_tanggal_lahir');
			} else if($this->Umb_model->validate_date($this->input->post('tanggal_lahir'),'Y-m-d') == false) {
				$Return['error'] = $this->lang->line('umb_hr_date_format_error');
			} else if($this->input->post('tanggal_bergabung')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_tanggal_bergabung');
			} else if($this->Umb_model->validate_date($this->input->post('tanggal_bergabung'),'Y-m-d') == false) {
				$Return['error'] = $this->lang->line('umb_hr_date_format_error');
			}  else if($this->input->post('role')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_user_role');
			} else if($this->input->post('no_kontak')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_nomor_kontak');
			} else if(!preg_match('/^([0-9]*)$/', $this->input->post('no_kontak'))) {
				$Return['error'] = $this->lang->line('umb_hr_numeric_error');
			}

			if($Return['error']!=''){
				$this->output($Return);
			}
			/*if($system[0]->multi_shifts == '1'){
				if(empty($shift_kantor_id)) {
					$Return['error'] = $this->lang->line('umb_shift_kantor_field_error');
				}
				$shift_kantor_ids = implode(',',$this->input->post('shift_kantor_id'));
				$column_shift = $shift_kantor_ids;
			} else {
				$column_shift = $this->input->post('shift_kantor_id');
			}*/

			if($Return['error']!=''){
				$this->output($Return);
			}

			$first_name = $this->Umb_model->clean_post($this->input->post('first_name'));
			$last_name = $this->Umb_model->clean_post($this->input->post('last_name'));
			$karyawan_id = $this->input->post('karyawan_id');
			$tanggal_bergabung = $this->Umb_model->clean_date_post($this->input->post('tanggal_bergabung'));
			//$username = $this->Umb_model->clean_post($this->input->post('username'));
			$username = $this->input->post('username');
			$tanggal_lahir = $this->Umb_model->clean_date_post($this->input->post('tanggal_lahir'));
			$no_kontak = $this->Umb_model->clean_post($this->input->post('no_kontak'));
			$alamat = $this->input->post('alamat');
			$kategoris_cuti = array($this->input->post('kategoris_cuti'));
			$cat_ids = implode(',',$this->input->post('kategoris_cuti'));
			$view_perusahaans_id = implode(',',$this->input->post('view_perusahaans_id'));

			$module_attributes = $this->Custom_fields_model->all_hrastral_module_attributes();
			$count_module_attributes = $this->Custom_fields_model->count_module_attributes();	
			$i=1;
			if($count_module_attributes > 0){
				foreach($module_attributes as $mattribute) {
					if($mattribute->validation == 1){
						if($i!=1) {
						} else if($this->input->post($mattribute->attribute)=='') {
							$Return['error'] = $this->lang->line('umb_hrastral_custom_field_the').' '.$mattribute->attribute_label.' '.$this->lang->line('umb_hrastral_custom_field_is_required');
						}
					}
				}		
				if($Return['error']!=''){
					$this->output($Return);
				}	
			}

			$data = array(
				'karyawan_id' => $karyawan_id,
				'shift_kantor_id' => $this->input->post('shift_kantor_id'),
				'laporans_to' => $this->input->post('laporans_to'),
				'first_name' => $first_name,
				'last_name' => $last_name,
				'username' => $username,
				'perusahaan_id' => $this->input->post('perusahaan_id'),
				'location_id' => $this->input->post('location_id'),
				'email' => $this->input->post('email'),
				'tanggal_lahir' => $tanggal_lahir,
				'jenis_kelamin' => $this->input->post('jenis_kelamin'),
				'user_role_id' => $this->input->post('role'),
				'department_id' => $this->input->post('department_id'),
				'sub_department_id' => $this->input->post('subdepartment_id'),
				'penunjukan_id' => $this->input->post('penunjukan_id'),
				'tanggal_bergabung' => $tanggal_bergabung,
				'no_kontak' => $no_kontak,
				'alamat' => $alamat,
				'provinsi' => $this->input->post('eprovinsi'),
				'kota' => $this->input->post('ekota'),
				'kode_pos' => $this->input->post('ekode_pos'),
				'type_sukubangsa' => $this->input->post('type_sukubangsa'),
				'kategoris_cuti' => $cat_ids,
				'view_perusahaans_id' => $view_perusahaans_id,
				'date_of_leaving' => $this->input->post('date_of_leaving'),
				'status_perkawinan' => $this->input->post('status_perkawinan'),
				'golongan_darah' => $this->input->post('golongan_darah'),
				'kebangsaan_id' => $this->input->post('kebangsaan_id'),
				'kewarganegaraan_id' => $this->input->post('kewarganegaraan_id'),
				'is_active' => $this->input->post('status'),
			);
			$id = $this->input->post('user_id');
			$result = $this->Karyawans_model->basic_info($data,$id);
			if($count_module_attributes > 0){
				foreach($module_attributes as $mattribute) {

					$count_exist_values = $this->Custom_fields_model->count_module_attributes_values($id,$mattribute->custom_field_id);
					if($count_exist_values > 0){
						if($mattribute->attribute_type == 'fileupload'){
							if($_FILES[$mattribute->attribute]['size'] != 0) {
								if(is_uploaded_file($_FILES[$mattribute->attribute]['tmp_name'])) {

									$allowed =  array('png','jpg','jpeg','pdf','gif','xls','doc','xlsx','docx');
									$filename = $_FILES[$mattribute->attribute]['name'];
									$ext = pathinfo($filename, PATHINFO_EXTENSION);

									if(in_array($ext,$allowed)){
										$tmp_name = $_FILES[$mattribute->attribute]["tmp_name"];
										$profile = "uploads/custom_files/";
										$set_img = base_url()."uploads/custom_files/";

										$name = basename($_FILES[$mattribute->attribute]["name"]);
										$newfilename = 'custom_file_'.round(microtime(true)).'.'.$ext;
										move_uploaded_file($tmp_name, $profile.$newfilename);
										$fname = $newfilename;	
									}
									$iattr_data = array(
										'attribute_value' => $fname
									);
									$this->Custom_fields_model->update_att_record($iattr_data, $id,$mattribute->custom_field_id);
								}

							} else {
							}
						} else if($mattribute->attribute_type == 'multiselect') {
							$multisel_val = $this->input->post($mattribute->attribute);
							if(!empty($multisel_val)){
								$newdata = implode(',', $this->input->post($mattribute->attribute));
								$iattr_data = array(
									'attribute_value' => $newdata,
								);
								$this->Custom_fields_model->update_att_record($iattr_data, $id,$mattribute->custom_field_id);
							}
						} else {
							$attr_data = array(
								'attribute_value' => $this->input->post($mattribute->attribute),
							);
							$this->Custom_fields_model->update_att_record($attr_data, $id,$mattribute->custom_field_id);
						}
					} else {
						if($mattribute->attribute_type == 'fileupload'){
							if($_FILES[$mattribute->attribute]['size'] != 0) {
								if(is_uploaded_file($_FILES[$mattribute->attribute]['tmp_name'])) {

									$allowed =  array('png','jpg','jpeg','pdf','gif','xls','doc','xlsx','docx');
									$filename = $_FILES[$mattribute->attribute]['name'];
									$ext = pathinfo($filename, PATHINFO_EXTENSION);

									if(in_array($ext,$allowed)){
										$tmp_name = $_FILES[$mattribute->attribute]["tmp_name"];
										$profile = "uploads/custom_files/";
										$set_img = base_url()."uploads/custom_files/";

										$name = basename($_FILES[$mattribute->attribute]["name"]);
										$newfilename = 'custom_file_'.round(microtime(true)).'.'.$ext;
										move_uploaded_file($tmp_name, $profile.$newfilename);
										$fname = $newfilename;	
									}
									$iattr_data = array(
										'user_id' => $id,
										'module_attributes_id' => $mattribute->custom_field_id,
										'attribute_value' => $fname,
										'created_at' => date('Y-m-d h:i:s')
									);
									$this->Custom_fields_model->add_values($iattr_data);
								}
							} else {
								if($this->input->post($mattribute->attribute) == ''){
									$file_val = '';
								} else {
									$file_val = $this->input->post($mattribute->attribute);
								}
								$iattr_data = array(
									'user_id' => $id,
									'module_attributes_id' => $mattribute->custom_field_id,
									'created_at' => date('Y-m-d h:i:s')
								);
								$this->Custom_fields_model->add_values($iattr_data);
							}
						} else if($mattribute->attribute_type == 'multiselect') {
							$multisel_val = $this->input->post($mattribute->attribute);
							if(!empty($multisel_val)){
								$newdata = implode(',', $this->input->post($mattribute->attribute));
								$iattr_data = array(
									'user_id' => $id,
									'module_attributes_id' => $mattribute->custom_field_id,
									'attribute_value' => $newdata,
									'created_at' => date('Y-m-d h:i:s')
								);
								$this->Custom_fields_model->add_values($iattr_data);
							}
						} else {
							if($this->input->post($mattribute->attribute) == ''){
								$file_val = '';
							} else {
								$file_val = $this->input->post($mattribute->attribute);
							}
							$iattr_data = array(
								'user_id' => $id,
								'module_attributes_id' => $mattribute->custom_field_id,
								'attribute_value' => $file_val,
								'created_at' => date('Y-m-d h:i:s')
							);
							$this->Custom_fields_model->add_values($iattr_data);
						}
					}
				}
			}
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_karyawan_basic_info_diperbarui');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function update_status_info() {

		$status_id = $this->uri->segment(4);
		if($status_id == 2){
			$status_id = 0;
		}
		$user_id = $this->uri->segment(5);
		$user = $this->Umb_model->read_user_info($user_id);
		$full_name = $user[0]->first_name.' '.$user[0]->last_name;
		$data = array(
			'is_active' => $status_id,
		);
		//$id = $this->input->post('user_id');
		$this->Karyawans_model->basic_info($data,$user_id);
		//$Return['result'] = $this->lang->line('umb_karyawan_basic_info_diperbarui');
		echo $full_name.' '.$this->lang->line('umb_karyawan_status_diperbarui');
		//$this->output($Return);
		//exit;
	}

	public function profile_picture() {

		if($this->input->post('type')=='profile_picture') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = $this->input->post('user_id');

			if($_FILES['p_file']['size'] == 0 && null ==$this->input->post('remove_profile_picture')) {
				$Return['error'] = $this->lang->line('umb_karyawan_select_picture');
			} else {
				if(is_uploaded_file($_FILES['p_file']['tmp_name'])) {

					$allowed =  array('png','jpg','jpeg','pdf','gif');
					$filename = $_FILES['p_file']['name'];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);

					if(in_array($ext,$allowed)){
						$tmp_name = $_FILES["p_file"]["tmp_name"];
						$profile = "uploads/profile/";
						$set_img = base_url()."uploads/profile/";

						$name = basename($_FILES["p_file"]["name"]);
						$newfilename = 'profile_'.round(microtime(true)).'.'.$ext;
						move_uploaded_file($tmp_name, $profile.$newfilename);
						$fname = $newfilename;

						$data = array('profile_picture' => $fname);
						$result = $this->Karyawans_model->profile_picture($data,$id);
						if ($result == TRUE) {
							$Return['result'] = $this->lang->line('umb_karyawan_picture_diperbarui');
							$Return['img'] = $set_img.$fname;
						} else {
							$Return['error'] = $this->lang->line('umb_error_msg');
						}
						$this->output($Return);
						exit;

					} else {
						$Return['error'] = $this->lang->line('umb_karyawan_picture_type');
					}
				}
			}

			if(null!=$this->input->post('remove_profile_picture')) {

				$data = array('profile_picture' => 'no file');				
				$row = $this->Karyawans_model->read_informasi_karyawan($id);
				$profile = base_url()."uploads/profile/";
				$result = $this->Karyawans_model->profile_picture($data,$id);
				if ($result == TRUE) {
					$Return['result'] = $this->lang->line('umb_karyawan_picture_diperbarui');
					if($row[0]->jenis_kelamin=='Pria') {
						$Return['img'] = $profile.'default_male.jpg';
					} else {
						$Return['img'] = $profile.'default_female.jpg';
					}
				} else {
					$Return['error'] = $this->lang->line('umb_error_msg');
				}
				$this->output($Return);
				exit;
			}

			if($Return['error']!=''){
				$this->output($Return);
			}
		}
	}

	public function social_info() {

		if($this->input->post('type')=='social_info') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();	
			if ($this->input->post('facebook_link')!=='' && !filter_var($this->input->post('facebook_link'), FILTER_VALIDATE_URL)) {
				$Return['error'] = $this->lang->line('umb_hr_fb_field_error');
			} else if ($this->input->post('twitter_link')!=='' && !filter_var($this->input->post('twitter_link'), FILTER_VALIDATE_URL)) {
				$Return['error'] = $this->lang->line('umb_hr_twitter_field_error');
			} else if ($this->input->post('blogger_link')!=='' && !filter_var($this->input->post('blogger_link'), FILTER_VALIDATE_URL)) {
				$Return['error'] = $this->lang->line('umb_hr_blogger_field_error');
			} else if ($this->input->post('linkdedin_link')!=='' && !filter_var($this->input->post('linkdedin_link'), FILTER_VALIDATE_URL)) {
				$Return['error'] = $this->lang->line('umb_hr_linkedin_field_error');
			} else if ($this->input->post('google_plus_link')!=='' && !filter_var($this->input->post('google_plus_link'), FILTER_VALIDATE_URL)) {
				$Return['error'] = $this->lang->line('umb_hr_gplus_field_error');
			} else if ($this->input->post('instagram_link')!=='' && !filter_var($this->input->post('instagram_link'), FILTER_VALIDATE_URL)) {
				$Return['error'] = $this->lang->line('umb_hr_instagram_field_error');
			} else if ($this->input->post('pinterest_link')!=='' && !filter_var($this->input->post('pinterest_link'), FILTER_VALIDATE_URL)) {
				$Return['error'] = $this->lang->line('umb_hr_pinterest_field_error');
			} else if ($this->input->post('youtube_link')!=='' && !filter_var($this->input->post('youtube_link'), FILTER_VALIDATE_URL)) {
				$Return['error'] = $this->lang->line('umb_hr_youtube_field_error');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$data = array(
				'facebook_link' => $this->input->post('facebook_link'),
				'twitter_link' => $this->input->post('twitter_link'),
				'blogger_link' => $this->input->post('blogger_link'),
				'linkdedin_link' => $this->input->post('linkdedin_link'),
				'google_plus_link' => $this->input->post('google_plus_link'),
				'instagram_link' => $this->input->post('instagram_link'),
				'pinterest_link' => $this->input->post('pinterest_link'),
				'youtube_link' => $this->input->post('youtube_link')
			);
			$id = $this->input->post('user_id');
			$result = $this->Karyawans_model->social_info($data,$id);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_perbarui_social_info');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}	

	public function update_info_kontaks() {

		if($this->input->post('type')=='info_kontak') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();

			if($this->input->post('salutation')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_salutation');
			} else if($this->input->post('kontak_name')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_kontak_name');
			} else if($this->input->post('relation')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_grp');
			} else if($this->input->post('primary_email')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_pemail');
			} else if($this->input->post('mobile_phone')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_mobile');
			} else if($this->input->post('kota')==='') {
				$Return['error'] = $this->lang->line('umb_error_fiel_kota');
			} else if($this->input->post('negara')==='') {
				$Return['error'] = $this->lang->line('umb_error_field_negara');
			}

			if($Return['error']!=''){
				$this->output($Return);
			}

			$data = array(
				'salutation' => $this->input->post('salutation'),
				'kontak_name' => $this->input->post('kontak_name'),
				'relation' => $this->input->post('relation'),
				'perusahaan' => $this->input->post('perusahaan'),
				'title_pekerjaan' => $this->input->post('title_pekerjaan'),
				'primary_email' => $this->input->post('primary_email'),
				'mobile_phone' => $this->input->post('mobile_phone'),
				'alamat' => $this->input->post('alamat'),
				'kota' => $this->input->post('kota'),
				'provinsi' => $this->input->post('provinsi'),
				'kode_pos' => $this->input->post('kode_pos'),
				'negara' => $this->input->post('negara'),
				'karyawan_id' => $this->input->post('user_id'),
				'type_kontak' => 'permanent'
			);

			$query = $this->Karyawans_model->check_kontak_permanent_karyawan($this->input->post('user_id'));
			if ($query->num_rows() > 0 ) {
				$res = $query->result();
				$e_field_id = $res[0]->kontak_id;
				$result = $this->Karyawans_model->info_kontak_update($data,$e_field_id);
			} else {
				$result = $this->Karyawans_model->add_info_kontak($data);
			}

			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_karyawan_info_kontak_diperbarui');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function update_info_kontak() {

		if($this->input->post('type')=='info_kontak') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			if($this->input->post('salutation')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_salutation');
			} else if($this->input->post('kontak_name')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_kontak_name');
			} else if($this->input->post('relation')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_grp');
			} else if($this->input->post('primary_email')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_pemail');
			} else if($this->input->post('mobile_phone')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_mobile');
			} else if($this->input->post('kota')==='') {
				$Return['error'] = $this->lang->line('umb_error_fiel_kota');
			} else if($this->input->post('negara')==='') {
				$Return['error'] = $this->lang->line('umb_error_field_negara');
			}

			if($Return['error']!=''){
				$this->output($Return);
			}

			$data = array(
				'salutation' => $this->input->post('salutation'),
				'kontak_name' => $this->input->post('kontak_name'),
				'relation' => $this->input->post('relation'),
				'perusahaan' => $this->input->post('perusahaan'),
				'title_pekerjaan' => $this->input->post('title_pekerjaan'),
				'primary_email' => $this->input->post('primary_email'),
				'mobile_phone' => $this->input->post('mobile_phone'),
				'alamat' => $this->input->post('alamat'),
				'kota' => $this->input->post('kota'),
				'provinsi' => $this->input->post('provinsi'),
				'kode_pos' => $this->input->post('kode_pos'),
				'negara' => $this->input->post('negara'),
				'karyawan_id' => $this->input->post('user_id'),
				'type_kontak' => 'current'
			);

			$query = $this->Karyawans_model->check_current_kontak_karyawan($this->input->post('user_id'));
			if ($query->num_rows() > 0 ) {
				$res = $query->result();
				$e_field_id = $res[0]->kontak_id;
				$result = $this->Karyawans_model->info_kontak_update($data,$e_field_id);
			} else {
				$result = $this->Karyawans_model->add_info_kontak($data);
			}
			//$e_field_id = 1;

			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_karyawan_info_kontak_diperbarui');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function info_kontak() {

		if($this->input->post('type')=='info_kontak') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();


			if($this->input->post('relation')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_relation');
			} else if($this->input->post('kontak_name')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_kontak_name');
			} else if(!preg_match("/^(\pL{1,}[ ]?)+$/u",$this->input->post('kontak_name'))) {
				$Return['error'] = $this->lang->line('umb_hr_string_error');
			} else if($this->input->post('no_kontak')!=='' && !preg_match('/^([0-9]*)$/', $this->input->post('no_kontak'))) {
				$Return['error'] = $this->lang->line('umb_hr_numeric_error');
			} else if($this->input->post('phone_kerja')!=='' && !preg_match('/^([0-9]*)$/', $this->input->post('phone_kerja'))) {
				$Return['error'] = $this->lang->line('umb_hr_numeric_error');
			} else if($this->input->post('extension_phone_kerja')!=='' && !preg_match('/^([0-9]*)$/', $this->input->post('extension_phone_kerja'))) {
				$Return['error'] = $this->lang->line('umb_hr_numeric_error');
			} else if($this->input->post('mobile_phone')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_mobile');
			} else if(!preg_match('/^([0-9]*)$/', $this->input->post('mobile_phone'))) {
				$Return['error'] = $this->lang->line('umb_hr_numeric_error');
			} else if($this->input->post('home_phone')!=='' && !preg_match('/^([0-9]*)$/', $this->input->post('home_phone'))) {
				$Return['error'] = $this->lang->line('umb_hr_numeric_error');
			} else if($this->input->post('email_kerja')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_email');
			} else if (!filter_var($this->input->post('email_kerja'), FILTER_VALIDATE_EMAIL)) {
				$Return['error'] = $this->lang->line('umb_karyawan_error_invalid_email');
			} else if ($this->input->post('email_pribadi')!=='' && !filter_var($this->input->post('email_pribadi'), FILTER_VALIDATE_EMAIL)) {
				$Return['error'] = $this->lang->line('umb_karyawan_error_invalid_email');
			} else if($this->input->post('kode_pos')!=='' && !preg_match('/^([0-9]*)$/', $this->input->post('kode_pos'))) {
				$Return['error'] = $this->lang->line('umb_hr_numeric_error');
			}

			if(null!=$this->input->post('is_primary')) {
				$is_primary = $this->input->post('is_primary');
			} else {
				$is_primary = '';
			}
			if(null!=$this->input->post('is_dependent')) {
				$is_dependent = $this->input->post('is_dependent');
			} else {
				$is_dependent = '';
			}

			if($Return['error']!=''){
				$this->output($Return);
			}
			$kontak_name = $this->Umb_model->clean_post($this->input->post('kontak_name'));
			$alamat_1 = $this->Umb_model->clean_post($this->input->post('alamat_1'));
			$alamat_2 = $this->Umb_model->clean_post($this->input->post('alamat_2'));
			$kota = $this->Umb_model->clean_post($this->input->post('kota'));
			$provinsi = $this->Umb_model->clean_post($this->input->post('state'));		

			$data = array(
				'relation' => $this->input->post('relation'),
				'email_kerja' => $this->input->post('email_kerja'),
				'is_primary' => $is_primary,
				'is_dependent' => $is_dependent,
				'email_pribadi' => $this->input->post('email_pribadi'),
				'kontak_name' => $kontak_name,
				'alamat_1' => $alamat_1,
				'phone_kerja' => $this->input->post('phone_kerja'),
				'extension_phone_kerja' => $this->input->post('extension_phone_kerja'),
				'alamat_2' => $alamat_2,
				'mobile_phone' => $this->input->post('mobile_phone'),
				'kota' => $kota,
				'provinsi' => $provinsi,
				'kode_pos' => $this->input->post('kode_pos'),
				'home_phone' => $this->input->post('home_phone'),
				'negara' => $this->input->post('negara'),
				'karyawan_id' => $this->input->post('user_id'),
				'created_at' => date('d-m-Y'),
			);
			$result = $this->Karyawans_model->add_info_kontak($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_karyawan_info_kontak_ditambahkan');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function e_info_kontak() {

		if($this->input->post('type')=='e_info_kontak') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();


			if($this->input->post('relation')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_relation');
			} else if($this->input->post('kontak_name')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_kontak_name');
			} else if($this->input->post('mobile_phone')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_mobile');
			}

			if(null!=$this->input->post('is_primary')) {
				$is_primary = $this->input->post('is_primary');
			} else {
				$is_primary = '';
			}
			if(null!=$this->input->post('is_dependent')) {
				$is_dependent = $this->input->post('is_dependent');
			} else {
				$is_dependent = '';
			}

			if($Return['error']!=''){
				$this->output($Return);
			}

			$data = array(
				'relation' => $this->input->post('relation'),
				'email_kerja' => $this->input->post('email_kerja'),
				'is_primary' => $is_primary,
				'is_dependent' => $is_dependent,
				'email_pribadi' => $this->input->post('email_pribadi'),
				'kontak_name' => $this->input->post('kontak_name'),
				'alamat_1' => $this->input->post('alamat_1'),
				'phone_kerja' => $this->input->post('phone_kerja'),
				'extension_phone_kerja' => $this->input->post('extension_phone_kerja'),
				'alamat_2' => $this->input->post('alamat_2'),
				'mobile_phone' => $this->input->post('mobile_phone'),
				'kota' => $this->input->post('kota'),
				'provinsi' => $this->input->post('provinsi'),
				'kode_pos' => $this->input->post('kode_pos'),
				'home_phone' => $this->input->post('home_phone'),
				'negara' => $this->input->post('negara')
			);

			$e_field_id = $this->input->post('e_field_id');
			$result = $this->Karyawans_model->info_kontak_update($data,$e_field_id);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_karyawan_info_kontak_diperbarui');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function document_info() {

		if($this->input->post('type')=='document_info' && $this->input->post('data')=='document_info') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();


			if($this->input->post('type_document_id')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_type_document');
			} /*else if($this->Umb_model->validate_date($this->input->post('tanggal_kadaluarsa'),'Y-m-d') == false) {
				$Return['error'] = $this->lang->line('umb_hr_date_format_error');
			}*/ else if($this->input->post('title')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_document_title');
			} /*else if(preg_match("/^(\pL{1,}[ ]?)+$/u",$this->input->post('title')) != 1) {
				$Return['error'] = $this->lang->line('umb_hr_string_error');
			} else if($this->input->post('email')==='') {
				$Return['error'] = $this->lang->line('umb_error_notify_email_field');
			} else if(!filter_var($this->input->post('email'), FILTER_VALIDATE_EMAIL)) {
				$Return['error'] = $this->lang->line('umb_karyawan_error_invalid_email');
			} */
			else if($_FILES['document_file']['size'] == 0) {
				$fname = '';
			} else {
				if(is_uploaded_file($_FILES['document_file']['tmp_name'])) {

					$allowed =  array('png','jpg','jpeg','pdf','gif','txt','pdf','xls','xlsx','doc','docx');
					$filename = $_FILES['document_file']['name'];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);

					if(in_array($ext,$allowed)){
						$tmp_name = $_FILES["document_file"]["tmp_name"];
						$documentd = "uploads/document/";

						$name = basename($_FILES["document_file"]["name"]);
						$newfilename = 'document_'.round(microtime(true)).'.'.$ext;
						move_uploaded_file($tmp_name, $documentd.$newfilename);
						$fname = $newfilename;
					} else {
						$Return['error'] = $this->lang->line('umb_karyawan_file_type_document');
					}
				}
			}

			if($Return['error']!=''){
				$this->output($Return);
			}

			$title = $this->Umb_model->clean_post($this->input->post('title'));
			$description = $this->Umb_model->clean_post($this->input->post('description'));

			$tanggal_kadaluarsa = $this->Umb_model->clean_date_post($this->input->post('tanggal_kadaluarsa'));

			$data = array(
				'type_document_id' => $this->input->post('type_document_id'),
				'tanggal_kadaluarsa' => $tanggal_kadaluarsa,
				'document_file' => $fname,
				'title' => $title,
				//'notification_email' => $this->input->post('email'),
				//'is_alert' => $this->input->post('send_mail'),
				'description' => $description,
				'karyawan_id' => $this->input->post('user_id'),
				'created_at' => date('d-m-Y'),
			);
			$result = $this->Karyawans_model->add_info_document($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_karyawan_d_info_ditambahkan');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function immigration_info() {

		if($this->input->post('type')=='immigration_info' && $this->input->post('data')=='immigration_info') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			//preg_match("/^(\pL{1,}[ ]?)+$/u",

			if($this->input->post('type_document_id')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_type_document');
			} else if($this->input->post('nomor_document')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_d_number');
			} else if($this->input->post('tanggal_terbit')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_d_issue');
			} else if($this->Umb_model->validate_date($this->input->post('tanggal_terbit'),'Y-m-d') == false) {
				$Return['error'] = $this->lang->line('umb_hr_date_format_error');
			} else if($this->input->post('tanggal_kaaluarsa')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_tanggal_kaaluarsa');
			} else if($this->Umb_model->validate_date($this->input->post('tanggal_kaaluarsa'),'Y-m-d') == false) {
				$Return['error'] = $this->lang->line('umb_hr_date_format_error');
			}

			else if($_FILES['document_file']['size'] == 0) {
				$Return['error'] = $this->lang->line('umb_karyawan_select_d_file');
			} else {
				if(is_uploaded_file($_FILES['document_file']['tmp_name'])) {

					$allowed =  array('png','jpg','jpeg','pdf','gif','txt','pdf','xls','xlsx','doc','docx');
					$filename = $_FILES['document_file']['name'];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);

					if(in_array($ext,$allowed)){
						$tmp_name = $_FILES["document_file"]["tmp_name"];
						$documentd = "uploads/document/immigration/";

						$name = basename($_FILES["document_file"]["name"]);
						$newfilename = 'document_'.round(microtime(true)).'.'.$ext;
						move_uploaded_file($tmp_name, $documentd.$newfilename);
						$fname = $newfilename;
					} else {
						$Return['error'] = $this->lang->line('umb_karyawan_file_type_document');
					}
				}
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$nomor_document = $this->Umb_model->clean_post($this->input->post('nomor_document'));	
			$tanggal_terbit = $this->Umb_model->clean_date_post($this->input->post('tanggal_terbit'));
			$tanggal_kaaluarsa = $this->Umb_model->clean_date_post($this->input->post('tanggal_kaaluarsa'));
			$tanggal_tinjauan_yang_memenuhi_syarat = $this->Umb_model->clean_date_post($this->input->post('tanggal_tinjauan_yang_memenuhi_syarat'));
			$data = array(
				'type_document_id' => $this->input->post('type_document_id'),
				'nomor_document' => $nomor_document,
				'document_file' => $fname,
				'tanggal_terbit' => $tanggal_terbit,
				'tanggal_kaaluarsa' => $tanggal_kaaluarsa,
				'negara_id' => $this->input->post('negara'),
				'tanggal_tinjauan_yang_memenuhi_syarat' => $tanggal_tinjauan_yang_memenuhi_syarat,
				'karyawan_id' => $this->input->post('user_id'),
				'created_at' => date('d-m-Y h:i:s'),
			);
			$result = $this->Karyawans_model->immigration_info_add($data);

			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_karyawan_img_info_ditambahkan');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function e_info_immigration() {

		if($this->input->post('type')=='e_info_immigration' && $this->input->post('data')=='e_info_immigration') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();


			if($this->input->post('type_document_id')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_type_document');
			} else if($this->input->post('nomor_document')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_d_number');
			} else if($this->input->post('tanggal_terbit')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_d_issue');
			} else if($this->input->post('tanggal_kaaluarsa')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_tanggal_kaaluarsa');
			}

			else if($_FILES['document_file']['size'] == 0) {
				$data = array(
					'type_document_id' => $this->input->post('type_document_id'),
					'nomor_document' => $this->input->post('nomor_document'),
					'tanggal_terbit' => $this->input->post('tanggal_terbit'),
					'tanggal_kaaluarsa' => $this->input->post('tanggal_kaaluarsa'),
					'negara_id' => $this->input->post('negara'),
					'tanggal_tinjauan_yang_memenuhi_syarat' => $this->input->post('tanggal_tinjauan_yang_memenuhi_syarat'),
				);
				$e_field_id = $this->input->post('e_field_id');
				$result = $this->Karyawans_model->img_document_info_update($data,$e_field_id);
				if ($result == TRUE) {
					$Return['result'] = $this->lang->line('umb_karyawan_img_info_diperbarui');
				} else {
					$Return['error'] = $this->lang->line('umb_error_msg');
				}
				$this->output($Return);
				exit;
			} else {
				if(is_uploaded_file($_FILES['document_file']['tmp_name'])) {

					$allowed =  array('png','jpg','jpeg','pdf','gif','txt','pdf','xls','xlsx','doc','docx');
					$filename = $_FILES['document_file']['name'];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);

					if(in_array($ext,$allowed)){
						$tmp_name = $_FILES["document_file"]["tmp_name"];
						$documentd = "uploads/document/immigration/";

						$name = basename($_FILES["document_file"]["name"]);
						$newfilename = 'document_'.round(microtime(true)).'.'.$ext;
						move_uploaded_file($tmp_name, $documentd.$newfilename);
						$fname = $newfilename;
						$data = array(
							'type_document_id' => $this->input->post('type_document_id'),
							'nomor_document' => $this->input->post('nomor_document'),
							'document_file' => $fname,
							'tanggal_terbit' => $this->input->post('tanggal_terbit'),
							'tanggal_kaaluarsa' => $this->input->post('tanggal_kaaluarsa'),
							'negara_id' => $this->input->post('negara'),
							'tanggal_tinjauan_yang_memenuhi_syarat' => $this->input->post('tanggal_tinjauan_yang_memenuhi_syarat'),
						);
						$e_field_id = $this->input->post('e_field_id');
						$result = $this->Karyawans_model->img_document_info_update($data,$e_field_id);
						if ($result == TRUE) {
							$Return['result'] = $this->lang->line('umb_karyawan_d_info_diperbarui');
						} else {
							$Return['error'] = $this->lang->line('umb_error_msg');
						}
						$this->output($Return);
						exit;
					} else {
						$Return['error'] = $this->lang->line('umb_karyawan_file_type_document');
					}
				}
			}

			if($Return['error']!=''){
				$this->output($Return);
			}

			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_karyawan_img_info_ditambahkan');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function e_info_document() {

		if($this->input->post('type')=='e_info_document') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();


			if($this->input->post('type_document_id')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_type_document');
			} else if($this->input->post('title')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_document_title');
			}

			else if($_FILES['document_file']['size'] == 0) {
				$data = array(
					'type_document_id' => $this->input->post('type_document_id'),
					'tanggal_kadaluarsa' => $this->input->post('tanggal_kadaluarsa'),
					'title' => $this->input->post('title'),
				//'notification_email' => $this->input->post('email'),
				//'is_alert' => $this->input->post('send_mail'),
					'description' => $this->input->post('description')
				);
				$e_field_id = $this->input->post('e_field_id');
				$result = $this->Karyawans_model->document_info_update($data,$e_field_id);
				if ($result == TRUE) {
					$Return['result'] = $this->lang->line('umb_karyawan_d_info_diperbarui');
				} else {
					$Return['error'] = $this->lang->line('umb_error_msg');
				}
				$this->output($Return);
				exit;
			} else {
				if(is_uploaded_file($_FILES['document_file']['tmp_name'])) {

					$allowed =  array('png','jpg','jpeg','pdf','gif','txt','pdf','xls','xlsx','doc','docx');
					$filename = $_FILES['document_file']['name'];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);

					if(in_array($ext,$allowed)){
						$tmp_name = $_FILES["document_file"]["tmp_name"];
						$documentd = "uploads/document/";

						$name = basename($_FILES["document_file"]["name"]);
						$newfilename = 'document_'.round(microtime(true)).'.'.$ext;
						move_uploaded_file($tmp_name, $documentd.$newfilename);
						$fname = $newfilename;
						$data = array(
							'type_document_id' => $this->input->post('type_document_id'),
							'tanggal_kadaluarsa' => $this->input->post('tanggal_kadaluarsa'),
							'document_file' => $fname,
							'title' => $this->input->post('title'),
							//'notification_email' => $this->input->post('email'),
							//'is_alert' => $this->input->post('send_mail'),
							'description' => $this->input->post('description')
						);
						$e_field_id = $this->input->post('e_field_id');
						$result = $this->Karyawans_model->document_info_update($data,$e_field_id);
						if ($result == TRUE) {
							$Return['result'] = $this->lang->line('umb_karyawan_d_info_diperbarui');
						} else {
							$Return['error'] = $this->lang->line('umb_error_msg');
						}
						$this->output($Return);
						exit;
					} else {
						$Return['error'] = $this->lang->line('umb_karyawan_file_type_document');
					}
				}
			}
			if($Return['error']!=''){
				$this->output($Return);
			}


		}
	}

	public function info_qualification() {

		if($this->input->post('type')=='info_qualification') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();


			$from_year = $this->input->post('from_year');
			$to_year = $this->input->post('to_year');
			$st_date = strtotime($from_year);
			$ed_date = strtotime($to_year);

			if($this->input->post('name')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_sch_uni');
			} else if(preg_match("/^(\pL{1,}[ ]?)+$/u",$this->input->post('name'))!=1) {
				$Return['error'] = $this->lang->line('umb_hr_string_error');
			} else if($this->input->post('from_year')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_frm_date');
			} else if($this->Umb_model->validate_date($this->input->post('from_year'),'Y-m-d') == false) {
				$Return['error'] = $this->lang->line('umb_hr_date_format_error');
			} else if($this->input->post('to_year')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_to_date');
			} else if($this->Umb_model->validate_date($this->input->post('to_year'),'Y-m-d') == false) {
				$Return['error'] = $this->lang->line('umb_hr_date_format_error');
			} else if($st_date > $ed_date) {
				$Return['error'] = $this->lang->line('umb_karyawan_error_date_shouldbe');
			}

			if($Return['error']!=''){
				$this->output($Return);
			}

			$name = $this->Umb_model->clean_post($this->input->post('name'));
			$from_year = $this->Umb_model->clean_date_post($this->input->post('from_year'));
			$to_year = $this->Umb_model->clean_date_post($this->input->post('to_year'));
			$description = $this->Umb_model->clean_post($this->input->post('description'));
			$data = array(
				'name' => $name,
				'tingkat_pendidikan_id' => $this->input->post('tingkat_pendidikan'),
				'from_year' => $from_year,
				'language_id' => $this->input->post('language'),
				'to_year' => $this->input->post('to_year'),
				'skill_id' => $this->input->post('skill'),
				'description' => $description,
				'karyawan_id' => $this->input->post('user_id'),
				'created_at' => date('d-m-Y'),
			);
			$result = $this->Karyawans_model->add_info_qualification($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_karyawan_error_q_info_ditambahkan');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function e_info_qualification() {

		if($this->input->post('type')=='e_info_qualification') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();

			$from_year = $this->input->post('from_year');
			$to_year = $this->input->post('to_year');
			$st_date = strtotime($from_year);
			$ed_date = strtotime($to_year);

			if($this->input->post('name')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_sch_uni');
			} else if($this->input->post('from_year')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_frm_date');
			} else if($this->input->post('to_year')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_to_date');
			} else if($st_date > $ed_date) {
				$Return['error'] = $this->lang->line('umb_karyawan_error_date_shouldbe');
			}

			if($Return['error']!=''){
				$this->output($Return);
			}

			$data = array(
				'name' => $this->input->post('name'),
				'tingkat_pendidikan_id' => $this->input->post('tingkat_pendidikan'),
				'from_year' => $this->input->post('from_year'),
				'language_id' => $this->input->post('language'),
				'to_year' => $this->input->post('to_year'),
				'skill_id' => $this->input->post('skill'),
				'description' => $this->input->post('description')
			);
			$e_field_id = $this->input->post('e_field_id');
			$result = $this->Karyawans_model->info_qualification_update($data,$e_field_id);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_karyawan_error_q_info_diperbarui');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function info_pengalaman_kerja() {

		if($this->input->post('type')=='info_pengalaman_kerja') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();

			$frm_date = strtotime($this->input->post('from_date'));	
			$to_date = strtotime($this->input->post('to_date'));

			if($this->input->post('nama_perusahaan')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_nama_perusahaan');
			} else if($this->input->post('post')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_post');
			} else if($this->input->post('from_date')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_frm_date');
			} else if($this->input->post('to_date')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_to_date');
			} else if($frm_date > $to_date) {
				$Return['error'] = $this->lang->line('umb_karyawan_error_date_shouldbe');
			} 

			if($Return['error']!=''){
				$this->output($Return);
			}

			$data = array(
				'nama_perusahaan' => $this->input->post('nama_perusahaan'),
				'from_date' => $this->input->post('from_date'),
				'to_date' => $this->input->post('to_date'),
				'post' => $this->input->post('post'),
				'description' => $this->input->post('description'),
				'karyawan_id' => $this->input->post('user_id'),
				'created_at' => date('d-m-Y'),
			);
			$result = $this->Karyawans_model->add_info_pengalaman_kerja($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_karyawan_error_w_exp_ditambahkan');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function e_info_pengalaman_kerja() {

		if($this->input->post('type')=='e_info_pengalaman_kerja') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();

			$frm_date = strtotime($this->input->post('from_date'));	
			$to_date = strtotime($this->input->post('to_date'));

			if($this->input->post('nama_perusahaan')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_nama_perusahaan');
			} else if($this->input->post('from_date')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_frm_date');
			} else if($this->input->post('to_date')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_to_date');
			} else if($frm_date > $to_date) {
				$Return['error'] = $this->lang->line('umb_karyawan_error_date_shouldbe');
			} else if($this->input->post('post')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_post');
			}

			if($Return['error']!=''){
				$this->output($Return);
			}

			$data = array(
				'nama_perusahaan' => $this->input->post('nama_perusahaan'),
				'from_date' => $this->input->post('from_date'),
				'to_date' => $this->input->post('to_date'),
				'post' => $this->input->post('post'),
				'description' => $this->input->post('description')
			);
			$e_field_id = $this->input->post('e_field_id');
			$result = $this->Karyawans_model->info_pengalaman_kerja_update($data,$e_field_id);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_karyawan_error_w_exp_diperbarui');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function info_bank_account() {

		if($this->input->post('type')=='info_bank_account') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();

			if($this->input->post('account_title')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_acc_title');
			} else if(preg_match("/^(\pL{1,}[ ]?)+$/u",$this->input->post('account_title'))!=1) {
				$Return['error'] = $this->lang->line('umb_hr_string_error');
			} else if($this->input->post('nomor_account')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_acc_number');
			} else if($this->input->post('nama_bank')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_nama_bank');
			} else if($this->input->post('kode_bank')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_kode_bank');
			}

			if($Return['error']!=''){
				$this->output($Return);
			}

			$data = array(
				'account_title' => $this->input->post('account_title'),
				'nomor_account' => $this->input->post('nomor_account'),
				'nama_bank' => $this->input->post('nama_bank'),
				'kode_bank' => $this->input->post('kode_bank'),
				'cabang_bank' => $this->input->post('cabang_bank'),
				'karyawan_id' => $this->input->post('user_id'),
				'created_at' => date('d-m-Y'),
			);
			$result = $this->Karyawans_model->add_info_bank_account($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_karyawan_error_bank_info_ditambahkan');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function add_security_level() {

		if($this->input->post('type')=='info_security_level') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();

			if($this->input->post('security_level')==='') {
				$Return['error'] = $this->lang->line('umb_error_security_level_field');
			}

			if($Return['error']!=''){
				$this->output($Return);
			}

			$data = array(
				'security_type' => $this->input->post('security_level'),
				'tanggal_kaaluarsa' => $this->input->post('tanggal_kaaluarsa'),
				'date_of_clearance' => $this->input->post('date_of_clearance'),
				'karyawan_id' => $this->input->post('user_id'),
				'created_at' => date('d-m-Y'),
			);
			$result = $this->Karyawans_model->info_security_level_add($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_security_level_krywn_ditambahkan');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function e_info_security_level() {

		if($this->input->post('type')=='e_info_security_level') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();

			if($this->input->post('security_level')==='') {
				$Return['error'] = $this->lang->line('umb_error_security_level_field');
			}

			if($Return['error']!=''){
				$this->output($Return);
			}

			$data = array(
				'security_type' => $this->input->post('security_level'),
				'tanggal_kaaluarsa' => $this->input->post('tanggal_kaaluarsa'),
				'date_of_clearance' => $this->input->post('date_of_clearance')
			);
			$e_field_id = $this->input->post('e_field_id');
			$result = $this->Karyawans_model->info_security_level_update($data,$e_field_id);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_security_level_krywn_diperbarui');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function delete_security_level() {

		if($this->input->post('data')=='delete_record') {

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = $this->uri->segment(4);
			$result = $this->Karyawans_model->delete_record_security_level($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_security_level_krywn_dihapus');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}

	public function e_info_bank_account() {

		if($this->input->post('type')=='e_info_bank_account') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();

			if($this->input->post('account_title')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_acc_title');
			} else if($this->input->post('nomor_account')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_acc_number');
			} else if($this->input->post('nama_bank')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_nama_bank');
			} else if($this->input->post('kode_bank')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_kode_bank');
			}

			if($Return['error']!=''){
				$this->output($Return);
			}

			$data = array(
				'account_title' => $this->input->post('account_title'),
				'nomor_account' => $this->input->post('nomor_account'),
				'nama_bank' => $this->input->post('nama_bank'),
				'kode_bank' => $this->input->post('kode_bank'),
				'cabang_bank' => $this->input->post('cabang_bank')
			);
			$e_field_id = $this->input->post('e_field_id');
			$result = $this->Karyawans_model->info_bank_account_update($data,$e_field_id);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_karyawan_error_bank_info_diperbarui');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function info_kontrak() {

		if($this->input->post('type')=='info_kontrak') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();

			$frm_date = strtotime($this->input->post('from_date'));	
			$to_date = strtotime($this->input->post('to_date'));

			if($this->input->post('type_kontrak_id')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_type_kontrak');
			} else if($this->input->post('title')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_kontrak_title');
			} else if($this->input->post('from_date')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_frm_date');
			} else if($this->input->post('to_date')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_to_date');
			} else if($frm_date > $to_date) {
				$Return['error'] = $this->lang->line('umb_karyawan_error_frm_to_date');
			} else if($this->input->post('penunjukan_id')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_penunjukan');
			}

			if($Return['error']!=''){
				$this->output($Return);
			}

			$data = array(
				'type_kontrak_id' => $this->input->post('type_kontrak_id'),
				'title' => $this->input->post('title'),
				'from_date' => $this->input->post('from_date'),
				'to_date' => $this->input->post('to_date'),
				'penunjukan_id' => $this->input->post('penunjukan_id'),
				'description' => $this->input->post('description'),
				'karyawan_id' => $this->input->post('user_id'),
				'created_at' => date('d-m-Y'),
			);
			$result = $this->Karyawans_model->info_kontrak_add($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_karyawan_info_kontrak_ditambahkan');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function e_info_kontrak() {

		if($this->input->post('type')=='e_info_kontrak') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();

			$frm_date = strtotime($this->input->post('from_date'));	
			$to_date = strtotime($this->input->post('to_date'));

			if($this->input->post('type_kontrak_id')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_type_kontrak');
			} else if($this->input->post('title')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_kontrak_title');
			} else if($this->input->post('from_date')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_frm_date');
			} else if($this->input->post('to_date')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_to_date');
			} else if($frm_date > $to_date) {
				$Return['error'] = $this->lang->line('umb_karyawan_error_frm_to_date');
			} else if($this->input->post('penunjukan_id')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_penunjukan');
			}

			if($Return['error']!=''){
				$this->output($Return);
			}

			$data = array(
				'type_kontrak_id' => $this->input->post('type_kontrak_id'),
				'title' => $this->input->post('title'),
				'from_date' => $this->input->post('from_date'),
				'to_date' => $this->input->post('to_date'),
				'penunjukan_id' => $this->input->post('penunjukan_id'),
				'description' => $this->input->post('description')
			);
			$e_field_id = $this->input->post('e_field_id');
			$result = $this->Karyawans_model->info_kontrak_update($data,$e_field_id);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_karyawan_info_kontrak_diperbarui');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function info_cuti() {

		if($this->input->post('type')=='info_cuti') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();

			if($this->input->post('kontrak_id')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_kontrak_f');
			}

			if($Return['error']!=''){
				$this->output($Return);
			}

			$data = array(
				'kontrak_id' => $this->input->post('kontrak_id'),
				'casual_cuti' => $this->input->post('casual_cuti'),
				'medical_cuti' => $this->input->post('medical_cuti'),
				'karyawan_id' => $this->input->post('user_id'),
				'created_at' => date('d-m-Y'),
			);
			$result = $this->Karyawans_model->info_cuti_add($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_karyawan_info_cuti_ditambahkan');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function e_info_cuti() {

		if($this->input->post('type')=='e_info_cuti') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();

			if($Return['error']!=''){
				$this->output($Return);
			}

			$data = array(
				'casual_cuti' => $this->input->post('casual_cuti'),
				'medical_cuti' => $this->input->post('medical_cuti')
			);
			$e_field_id = $this->input->post('e_field_id');
			$result = $this->Karyawans_model->info_cuti_update($data,$e_field_id);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_karyawan_info_cuti_diperbarui');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function info_shift() {

		if($this->input->post('type')=='info_shift') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();


			if($this->input->post('from_date')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_frm_date');
			} else if($this->input->post('shift_id')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_field_shift');
			}

			if($Return['error']!=''){
				$this->output($Return);
			}

			$data = array(
				'from_date' => $this->input->post('from_date'),
				'to_date' => $this->input->post('to_date'),
				'shift_id' => $this->input->post('shift_id'),
				'karyawan_id' => $this->input->post('user_id'),
				'created_at' => date('d-m-Y'),
			);
			$result = $this->Karyawans_model->info_shift_add($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_karyawan_info_shift_ditambahkan');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function e_info_shift() {

		if($this->input->post('type')=='e_info_shift') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();

			if($this->input->post('from_date')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_frm_date');
			}

			$data = array(
				'from_date' => $this->input->post('from_date'),
				'to_date' => $this->input->post('to_date')
			);
			$e_field_id = $this->input->post('e_field_id');
			$result = $this->Karyawans_model->info_shift_update($data,$e_field_id);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_karyawan_info_shift_diperbarui');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function info_location() {

		if($this->input->post('type')=='info_location') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();

			if($this->input->post('from_date')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_frm_date');
			} else if($this->input->post('location_id')==='') {
				$Return['error'] = $this->lang->line('error_field_location_dept');
			}

			if($Return['error']!=''){
				$this->output($Return);
			}

			$data = array(
				'from_date' => $this->input->post('from_date'),
				'to_date' => $this->input->post('to_date'),
				'location_id' => $this->input->post('location_id'),
				'karyawan_id' => $this->input->post('user_id'),
				'created_at' => date('d-m-Y'),
			);
			$result = $this->Karyawans_model->info_location_add($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_info_location_karyawan_ditambahkan');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function e_info_location() {

		if($this->input->post('type')=='e_info_location') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();


			if($this->input->post('from_date')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_frm_date');
			} else if($this->input->post('location_id')==='') {
				$Return['error'] = $this->lang->line('error_field_location_dept');
			}

			if($Return['error']!=''){
				$this->output($Return);
			}

			$data = array(
				'from_date' => $this->input->post('from_date'),
				'to_date' => $this->input->post('to_date')
			);
			$e_field_id = $this->input->post('e_field_id');
			$result = $this->Karyawans_model->info_location_update($data,$e_field_id);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_info_location_karyawan_diperbarui');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function info_update_tunjanagan() {

		if($this->input->post('type')=='e_info_tunjanagan') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();


			if($this->input->post('title_tunjanagan')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_set_title_tunjanagan_error');
			} else if($this->input->post('jumlah_tunjanagan')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_set_jumlah_tunjanagan_error');
			}

			if($Return['error']!=''){
				$this->output($Return);
			}

			$data = array(
				'title_tunjanagan' => $this->input->post('title_tunjanagan'),
				'jumlah_tunjanagan' => $this->input->post('jumlah_tunjanagan'),
				'is_tunjanagan_kena_pajak' => $this->input->post('is_tunjanagan_kena_pajak'),
				'jumlah_option' => $this->input->post('jumlah_option')
			);
			$e_field_id = $this->input->post('e_field_id');
			$result = $this->Karyawans_model->update_record_gaji_tunjanagan($data,$e_field_id);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_karyawan_diperbarui_tunjanagan_success');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function info_update_komissi() {

		if($this->input->post('type')=='e_gaji_info_komissi') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();


			if($this->input->post('title')==='') {
				$Return['error'] = $this->lang->line('umb_error_title');
			} else if($this->input->post('jumlah')==='') {
				$Return['error'] = $this->lang->line('umb_error_field_jumlah');
			}

			if($Return['error']!=''){
				$this->output($Return);
			}

			$data = array(
				'komisi_title' => $this->input->post('title'),
				'jumlah_komisi' => $this->input->post('jumlah'),
				'is_komisi_kena_pajak' => $this->input->post('is_komisi_kena_pajak'),
				'jumlah_option' => $this->input->post('jumlah_option')
			);
			$e_field_id = $this->input->post('e_field_id');
			$result = $this->Karyawans_model->update_record_gaji_komissi($data,$e_field_id);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_karyawan_update_komisi_success');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function update_info_statutory_potongans() {

		if($this->input->post('type')=='e_gaji_info_statutory_potongans') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();

			if($this->input->post('title')==='') {
				$Return['error'] = $this->lang->line('umb_error_title');
			} else if($this->input->post('jumlah')==='') {
				$Return['error'] = $this->lang->line('umb_error_field_jumlah');
			}

			if($Return['error']!=''){
				$this->output($Return);
			}

			$data = array(
				'title_potongan' => $this->input->post('title'),
				'jumlah_potongan' => $this->input->post('jumlah'),
				'statutory_options' => $this->input->post('statutory_options'),
				'jumlah_option' => $this->input->post('jumlah_option')
			);
			$e_field_id = $this->input->post('e_field_id');
			$result = $this->Karyawans_model->update_record_gaji_statutory_potongan($data,$e_field_id);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_karyawan_update_statutory_potongan_success');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function update_info_pembayaran_lainnya() {

		if($this->input->post('type')=='e_gaji_info_pembayarans_lainnya') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();

			if($this->input->post('title')==='') {
				$Return['error'] = $this->lang->line('umb_error_title');
			} else if($this->input->post('jumlah')==='') {
				$Return['error'] = $this->lang->line('umb_error_field_jumlah');
			}

			if($Return['error']!=''){
				$this->output($Return);
			}

			$data = array(
				'title_pembayarans' => $this->input->post('title'),
				'jumlah_pembayarans' => $this->input->post('jumlah'),
				'ia_pembayaranlainnya_kena_pajak' => $this->input->post('ia_pembayaranlainnya_kena_pajak'),
				'jumlah_option' => $this->input->post('jumlah_option')
			);
			$e_field_id = $this->input->post('e_field_id');
			$result = $this->Karyawans_model->update_record_gaji_pembayaran_lainnya($data,$e_field_id);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_karyawan_update_otherpayments_success');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function change_password() {

		if($this->input->post('type')=='change_password') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();

			if(trim($this->input->post('old_password'))==='') {
				$Return['error'] = $this->lang->line('umb_old_password_error_field');
			} else if($this->Karyawans_model->check_old_password($this->input->post('old_password'),$this->input->post('user_id'))!= 1) {
				$Return['error'] = $this->lang->line('umb_old_password_does_not_match');
			} else if(trim($this->input->post('new_password'))==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_newpassword');
			} else if(strlen($this->input->post('new_password')) < 6) {
				$Return['error'] = $this->lang->line('umb_karyawan_error_password_least');
			} else if(trim($this->input->post('new_password_confirm'))==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_new_cpassword');
			} else if($this->input->post('new_password')!=$this->input->post('new_password_confirm')) {
				$Return['error'] = $this->lang->line('umb_karyawan_error_old_new_cpassword');
			}

			if($Return['error']!=''){
				$this->output($Return);
			}
			$options = array('cost' => 12);
			$password_hash = password_hash($this->input->post('new_password'), PASSWORD_BCRYPT, $options);

			$data = array(
				'password' => $password_hash
			);
			$id = $this->input->post('user_id');
			$result = $this->Karyawans_model->change_password($data,$id);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_update_password_karyawan');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}


	public function list_security_level() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/karyawans/detail_karyawan", $data);
		} else {
			redirect('admin/');
		}

		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		$id = $this->uri->segment(4);
		$security_level = $this->Karyawans_model->set_karyawan_security_level($id);

		$data = array();

		foreach($security_level->result() as $r) {			
			$security_type = $this->Umb_model->read_security_level($r->security_type);
			if(!is_null($security_type)){
				$sc_type = $security_type[0]->name;
			} else {
				$sc_type = '--';
			}
			$data[] = array(
				'<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->security_level_id . '" data-field_type="security_level"><i class="fas fa-pencil-alt"></i></button></span><span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->security_level_id . '" data-token_type="security_level"><i class="fas fa-trash-restore"></i></button></span>',
				$sc_type,
				$r->tanggal_kaaluarsa,
				$r->date_of_clearance
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $security_level->num_rows(),
			"recordsFiltered" => $security_level->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function kontaks() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/karyawans/detail_karyawan", $data);
		} else {
			redirect('admin/');
		}

		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		$id = $this->uri->segment(4);
		$kontaks = $this->Karyawans_model->set_kontaks_karyawan($id);

		$data = array();

		foreach($kontaks->result() as $r) {

			if($r->is_primary==1){
				$primary = '<span class="tag tag-success">'.$this->lang->line('umb_karyawan_primary').'</span>';
			} else {
				$primary = '';
			}
			if($r->is_dependent==2){
				$dependent = '<span class="tag tag-danger">'.$this->lang->line('umb_karyawan_dependent').'</span>';
			} else {
				$dependent = '';
			}

			$data[] = array(
				'<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->kontak_id . '" data-field_type="kontak"><i class="fas fa-pencil-alt"></i></button></span><span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->kontak_id . '" data-token_type="kontak"><i class="fas fa-trash-restore"></i></button></span>',
				$r->kontak_name . ' ' .$primary . ' '.$dependent,
				$r->relation,
				$r->email_kerja,
				$r->mobile_phone
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $kontaks->num_rows(),
			"recordsFiltered" => $kontaks->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function documents() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/karyawans/detail_karyawan", $data);
		} else {
			redirect('admin/');
		}

		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		$id = $this->uri->segment(4);
		$documents = $this->Karyawans_model->set_documents_karyawan($id);

		$data = array();

		foreach($documents->result() as $r) {

			$d_type = $this->Karyawans_model->read_informasi_type_document($r->type_document_id);
			if(!is_null($d_type)){
				$document_d = $d_type[0]->type_document;
			} else {
				$document_d = '--';
			}
			if($r->tanggal_kadaluarsa == ''){
				$tanggal_kadaluarsa = '';
			} else {
				$tanggal_kadaluarsa = $this->Umb_model->set_date_format($r->tanggal_kadaluarsa);
			}
			if($r->document_file!='' && $r->document_file!='no file') {
				$functions = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="Download"><a href="'.site_url().'admin/download?type=document&filename='.$r->document_file.'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" title="'.$this->lang->line('umb_download').'"><i class="oi oi-cloud-download"></i></button></a></span>';
			} else {
				$functions ='';
			}
			/*if($r->is_alert==1){
			 	$alert = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_e_details_alert_notifyemail').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><i class="fa fa-bell"></i></button></span>';
			} else {
				$alert = '';
			}*/
			$data[] = array(
				$functions.'<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->document_id . '" data-field_type="document"><i class="fas fa-pencil-alt"></i></button></span><span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->document_id . '" data-token_type="document"><i class="fas fa-trash-restore"></i></button></span>',
				$document_d,
				$r->title,
				$tanggal_kadaluarsa
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $documents->num_rows(),
			"recordsFiltered" => $documents->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function immigration() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/karyawans/detail_karyawan", $data);
		} else {
			redirect('admin/');
		}

		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		$id = $this->uri->segment(4);
		$immigration = $this->Karyawans_model->set_karyawan_immigration($id);

		$data = array();

		foreach($immigration->result() as $r) {

			$tanggal_terbit = $this->Umb_model->set_date_format($r->tanggal_terbit);
			$tanggal_kaaluarsa = $this->Umb_model->set_date_format($r->tanggal_kaaluarsa);
			$tanggal_tinjauan_yang_memenuhi_syarat = $this->Umb_model->set_date_format($r->tanggal_tinjauan_yang_memenuhi_syarat);
			$d_type = $this->Karyawans_model->read_informasi_type_document($r->type_document_id);
			if(!is_null($d_type)){
				$document_d = $d_type[0]->type_document.'<br>'.$r->nomor_document;
			} else {
				$document_d = $r->nomor_document;
			}
			$negara = $this->Umb_model->read_info_negara($r->negara_id);
			if(!is_null($negara)){
				$c_name = $negara[0]->nama_negara;
			} else {
				$c_name = '--';	
			}

			$data[] = array(
				'<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->immigration_id . '" data-field_type="imgdocument"><i class="fas fa-pencil-alt"></i></button></span><span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->immigration_id . '" data-token_type="imgdocument"><i class="fas fa-trash-restore"></i></button></span>',
				$document_d,
				$tanggal_terbit,
				$tanggal_kaaluarsa,
				$c_name,
				$tanggal_tinjauan_yang_memenuhi_syarat,
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $immigration->num_rows(),
			"recordsFiltered" => $immigration->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function qualification() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/karyawans/detail_karyawan", $data);
		} else {
			redirect('admin/');
		}

		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		$id = $this->uri->segment(4);
		$qualification = $this->Karyawans_model->set_qualification_karyawan($id);

		$data = array();

		foreach($qualification->result() as $r) {

			$pendidikan = $this->Karyawans_model->read_informasi_pendidikan($r->tingkat_pendidikan_id);
			if(!is_null($pendidikan)){
				$nama_pddkn = $pendidikan[0]->name;
			} else {
				$nama_pddkn = '--';
			}
			//	$language = $this->Karyawans_model->read_informasi_qualification_language($r->language_id);

			/*if($r->skill_id == 'no course') {
				$ol = 'No Course';
			} else {
				$ol = '<ol class="nl">';
				foreach(explode(',',$r->skill_id) as $tunjuk_id) {
					$skill = $this->Karyawans_model->read_informasi_qualification_skill($tunjuk_id);
					$ol .= '<li>'.$skill[0]->name.'</li>';
				}
				$ol .= '</ol>';
			}*/
			$sdate = $this->Umb_model->set_date_format($r->from_year);
			$edate = $this->Umb_model->set_date_format($r->to_year);	
			$time_period = $sdate.' - '.$edate;
			// get date
			$pdate = $time_period;
			$data[] = array(
				'<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->qualification_id . '" data-field_type="qualification"><i class="fas fa-pencil-alt"></i></button></span><span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->qualification_id . '" data-token_type="qualification"><i class="fas fa-trash-restore"></i></button></span>',
				$r->name,
				$pdate,
				$nama_pddkn
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $qualification->num_rows(),
			"recordsFiltered" => $qualification->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function pengalaman() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/karyawans/detail_karyawan", $data);
		} else {
			redirect('admin/');
		}

		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		$id = $this->uri->segment(4);
		$pengalaman = $this->Karyawans_model->set_pengalaman_karyawan($id);

		$data = array();

		foreach($pengalaman->result() as $r) {

			$from_date = $this->Umb_model->set_date_format($r->from_date);
			$to_date = $this->Umb_model->set_date_format($r->to_date);

			$data[] = array(
				'<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->pengalaman_kerja_id . '" data-field_type="pengalaman_kerja"><i class="fas fa-pencil-alt"></i></button></span><span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->pengalaman_kerja_id . '" data-token_type="pengalaman_kerja"><i class="fas fa-trash-restore"></i></button></span>',
				$r->nama_perusahaan,
				$from_date,
				$to_date,
				$r->post,
				$r->description
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $pengalaman->num_rows(),
			"recordsFiltered" => $pengalaman->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function bank_account() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/karyawans/detail_karyawan", $data);
		} else {
			redirect('admin/');
		}

		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		$id = $this->uri->segment(4);
		$bank_account = $this->Karyawans_model->set_bank_account_karyawan($id);

		$data = array();

		foreach($bank_account->result() as $r) {			

			$data[] = array(
				'<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->bankaccount_id . '" data-field_type="bank_account"><i class="fas fa-pencil-alt"></i></button></span><span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->bankaccount_id . '" data-token_type="bank_account"><i class="fas fa-trash-restore"></i></button></span>',
				$r->account_title,
				$r->nomor_account,
				$r->nama_bank,
				$r->kode_bank,
				$r->cabang_bank
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $bank_account->num_rows(),
			"recordsFiltered" => $bank_account->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function kontrak() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/karyawans/detail_karyawan", $data);
		} else {
			redirect('admin/');
		}

		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		$id = $this->uri->segment(4);
		$kontrak = $this->Karyawans_model->set_kontrak_karyawan($id);

		$data = array();

		foreach($kontrak->result() as $r) {			

			$penunjukan = $this->Penunjukan_model->read_informasi_penunjukan($r->penunjukan_id);
			if(!is_null($penunjukan)){
				$nama_penunjukan = $penunjukan[0]->nama_penunjukan;
			} else {
				$nama_penunjukan = '--';
			}

			$type_kontrak = $this->Karyawans_model->read_informasi_type_kontrak($r->type_kontrak_id);
			if(!is_null($type_kontrak)){
				$ctype = $type_kontrak[0]->name;
			} else {
				$ctype = '--';
			}

			$duration = $this->Umb_model->set_date_format($r->from_date).' '.$this->lang->line('dashboard_to').' '.$this->Umb_model->set_date_format($r->to_date);

			$data[] = array(
				'<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->kontrak_id . '" data-field_type="kontrak"><i class="fas fa-pencil-alt"></i></button></span><span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->kontrak_id . '" data-token_type="kontrak"><i class="fas fa-trash-restore"></i></button></span>',
				$duration,
				$nama_penunjukan,
				$ctype,
				$r->title
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $kontrak->num_rows(),
			"recordsFiltered" => $kontrak->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}


	public function cuti() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/karyawans/detail_karyawan", $data);
		} else {
			redirect('admin/');
		}

		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		$id = $this->uri->segment(4);
		$cuti = $this->Karyawans_model->set_karyawan_cuti($id);

		$data = array();

		foreach($cuti->result() as $r) {

			$kontrak = $this->Karyawans_model->read_informasi_kontrak($r->kontrak_id);
			if(!is_null($kontrak)){

				$duration = $this->Umb_model->set_date_format($kontrak[0]->from_date).' '.$this->lang->line('dashboard_to').' '.$this->Umb_model->set_date_format($kontrak[0]->to_date);
				$ctitle = $kontrak[0]->title.' '.$duration;
			} else {
				$ctitle = '--';
			}

			$kontraki = $ctitle;

			$data[] = array(
				'<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->cuti_id . '" data-field_type="cuti"><i class="fas fa-pencil-alt"></i></button></span><span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->cuti_id . '" data-token_type="cuti"><i class="fas fa-trash-restore"></i></button></span>',
				$kontraki,
				$r->casual_cuti,
				$r->medical_cuti
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $cuti->num_rows(),
			"recordsFiltered" => $cuti->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function shift() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/karyawans/detail_karyawan", $data);
		} else {
			redirect('admin/');
		}

		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		$id = $this->uri->segment(4);
		$shift = $this->Karyawans_model->set_shift_karyawan($id);

		$data = array();

		foreach($shift->result() as $r) {			

			$info_shift = $this->Karyawans_model->read_infomasi_shift($r->shift_id);

			$duration = $this->Umb_model->set_date_format($r->from_date).' '.$this->lang->line('dashboard_to').' '.$this->Umb_model->set_date_format($r->to_date);

			if(!is_null($info_shift)){
				$nama_shift = $info_shift[0]->nama_shift;
			} else {
				$nama_shift = '--';
			}

			$data[] = array(
				'<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->emp_shift_id . '" data-field_type="shift"><i class="fas fa-pencil-alt"></i></button></span><span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->emp_shift_id . '" data-token_type="shift"><i class="fas fa-trash-restore"></i></button></span>',
				$duration,
				$nama_shift
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $shift->num_rows(),
			"recordsFiltered" => $shift->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function location() {
		//set data
		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/karyawans/detail_karyawan", $data);
		} else {
			redirect('admin/');
		}

		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		$id = $this->uri->segment(4);
		$location = $this->Karyawans_model->set_location_karyawan($id);

		$data = array();

		foreach($location->result() as $r) {			

			$location_kntr = $this->Location_model->read_informasi_location($r->location_id);

			$duration = $this->Umb_model->set_date_format($r->from_date).' '.$this->lang->line('dashboard_to').' '.$this->Umb_model->set_date_format($r->to_date);
			if(!is_null($location_kntr)){
				$nama_location = $location_kntr[0]->nama_location;
			} else {
				$nama_location = '--';
			}

			$data[] = array(
				'<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->location_kantor_id . '" data-field_type="location"><i class="fas fa-pencil-alt"></i></button></span><span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->location_kantor_id . '" data-token_type="location"><i class="fas fa-trash-restore"></i></button></span>',
				$duration,
				$nama_location
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $location->num_rows(),
			"recordsFiltered" => $location->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function update() {

		if($this->input->post('edit_type')=='peringatan') {

			$id = $this->uri->segment(4);

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();

			$description = $this->input->post('description');
			$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);

			if($this->input->post('peringatan_ke')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_peringatan');
			} else if($this->input->post('type')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_type_peringatan');
			} else if($this->input->post('subject')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_subject');
			} else if($this->input->post('peringatan_oleh')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_peringatan_oleh');
			} else if($this->input->post('tanggal_peringatan')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_tanggal_peringatan');
			}

			if($Return['error']!=''){
				$this->output($Return);
			}

			$data = array(
				'peringatan_ke' => $this->input->post('peringatan_ke'),
				'type_peringatan_id' => $this->input->post('type'),
				'description' => $qt_description,
				'subject' => $this->input->post('subject'),
				'peringatan_oleh' => $this->input->post('peringatan_oleh'),
				'tanggal_peringatan' => $this->input->post('tanggal_peringatan'),
				'status' => $this->input->post('status'),
			);

			$result = $this->Peringatan_model->update_record($data,$id);		

			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_peringatan_karyawan_diperbarui');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function import() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('umb_import_karyawans').' | '.$this->Umb_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('umb_import_karyawans');
		$data['path_url'] = 'import_karyawans';		
		$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		$data['all_departments'] = $this->Department_model->all_departments();
		$data['all_penunjukans'] = $this->Penunjukan_model->all_penunjukans();
		$data['all_user_roles'] = $this->Roles_model->all_user_roles();
		$data['all_shifts_kantor'] = $this->Karyawans_model->all_shifts_kantor();
		$data['get_all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('92',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/karyawans/import_karyawans", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}		  
	}

	public function delete_kontak() {

		if($this->input->post('data')=='delete_record') {

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$result = $this->Karyawans_model->delete_record_kontak($id);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_karyawan_kontak_dihapus');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}

	public function delete_document() {

		if($this->input->post('data')=='delete_record') {

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Karyawans_model->delete_record_document($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_karyawan_document_dihapus');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}

	public function delete_imgdocument() {

		if($this->input->post('data')=='delete_record') {

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');

			$id = $this->uri->segment(4);
			$result = $this->Karyawans_model->delete_record_imgdocument($id);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_karyawan_img_document_dihapus');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}

	public function delete_qualification() {

		if($this->input->post('data')=='delete_record') {

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = $this->uri->segment(4);
			$result = $this->Karyawans_model->delete_record_qualification($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_karyawan_qualification_dihapus');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}

	public function delete_pengalaman_kerja() {

		if($this->input->post('data')=='delete_record') {

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = $this->uri->segment(4);
			$result = $this->Karyawans_model->delete_record_pengalaman_kerja($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_karyawan_work_dihapus');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}

	public function delete_bank_account() {

		if($this->input->post('data')=='delete_record') {

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = $this->uri->segment(4);
			$result = $this->Karyawans_model->delete_record_bank_account($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_karyawan_bankaccount_dihapus');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}

	public function delete_kontrak() {

		if($this->input->post('data')=='delete_record') {

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = $this->uri->segment(4);
			$result = $this->Karyawans_model->delete_record_kontrak($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_karyawan_kontrak_dihapus');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}

	public function delete_cuti() {

		if($this->input->post('data')=='delete_record') {

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = $this->uri->segment(4);
			$result = $this->Karyawans_model->delete_record_cuti($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_karyawan_cuti_dihapus');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}

	public function delete_shift() {

		if($this->input->post('data')=='delete_record') {

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = $this->uri->segment(4);
			$result = $this->Karyawans_model->delete_record_shift($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_karyawan_shift_dihapus');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}

	public function delete_location() {

		if($this->input->post('data')=='delete_record') {

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = $this->uri->segment(4);
			$result = $this->Karyawans_model->delete_record_location($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_location_karyawan_dihapus');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}

	public function delete() {

		if($this->input->post('is_ajax')=='2') {

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = $this->uri->segment(4);
			$result = $this->Karyawans_model->delete_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_karyawan_current_dihapus');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}

	public function update_option_gaji() {

		if($this->input->post('type')=='karyawan_update_gaji') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();	
			if($this->input->post('gaji_pokok')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_gaji_error_basic');
			}

			if($Return['error']!=''){
				$this->output($Return);
			}
			$data = array(
				'type_upahh' => $this->input->post('type_upahh'),
				'gaji_pokok' => $this->input->post('gaji_pokok')
			);
			$id = $this->input->post('user_id');
			$result = $this->Karyawans_model->basic_info($data,$id);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_karyawan_diperbarui_gaji_success');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function set_lembur() {

		if($this->input->post('type')=='krywn_lembur') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();	
			if($this->input->post('type_lembur')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_set_title_lembur_error');
			} else if($this->input->post('no_of_days')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_set_lembur_no_of_days_error');
			} else if($this->input->post('jam_lembur')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_set_jam_lembur_error');
			} else if($this->input->post('nilai_lembur')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_set_nilai_lembur_error');
			}

			if($Return['error']!=''){
				$this->output($Return);
			}
			$data = array(
				'karyawan_id' => $this->input->post('user_id'),
				'type_lembur' => $this->input->post('type_lembur'),
				'no_of_days' => $this->input->post('no_of_days'),
				'jam_lembur' => $this->input->post('jam_lembur'),
				'nilai_lembur' => $this->input->post('nilai_lembur')
			);
			$id = $this->input->post('user_id');
			$result = $this->Karyawans_model->add_gaji_lembur($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_karyawan_ditambahkan_lembur_success');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function update_info_lembur() {

		if($this->input->post('type')=='e_lembur_info') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();	
			if($this->input->post('type_lembur')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_set_title_lembur_error');
			} else if($this->input->post('no_of_days')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_set_lembur_no_of_days_error');
			} else if($this->input->post('jam_lembur')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_set_jam_lembur_error');
			} else if($this->input->post('nilai_lembur')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_set_nilai_lembur_error');
			}

			if($Return['error']!=''){
				$this->output($Return);
			}
			$id = $this->input->post('e_field_id');
			$data = array(
				'type_lembur' => $this->input->post('type_lembur'),
				'no_of_days' => $this->input->post('no_of_days'),
				'jam_lembur' => $this->input->post('jam_lembur'),
				'nilai_lembur' => $this->input->post('nilai_lembur')
			);
			//$id = $this->input->post('user_id');
			$result = $this->Karyawans_model->update_record_gaji_lembur($data,$id);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_karyawan_diperbarui_lembur_success');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function option_tunjangan_karyawan() {

		if($this->input->post('type')=='karyawan_update_tunjanagan') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();	
			if($this->input->post('title_tunjanagan')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_set_title_tunjanagan_error');
			} else if($this->input->post('jumlah_tunjanagan')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_set_jumlah_tunjanagan_error');
			}

			if($Return['error']!=''){
				$this->output($Return);
			}
			$data = array(
				'title_tunjanagan' => $this->input->post('title_tunjanagan'),
				'jumlah_tunjanagan' => $this->input->post('jumlah_tunjanagan'),
				'karyawan_id' => $this->input->post('user_id'),
				'is_tunjanagan_kena_pajak' => $this->input->post('is_tunjanagan_kena_pajak'),
				'jumlah_option' => $this->input->post('jumlah_option')
			);
			$result = $this->Karyawans_model->add_gaji_tunjanagans($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_karyawan_set_tunjanagan_success');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function option_komissi_karyawan() {

		if($this->input->post('type')=='karyawan_update_komissi') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();	
			if($this->input->post('title')==='') {
				$Return['error'] = $this->lang->line('umb_error_title');
			} else if($this->input->post('jumlah')==='') {
				$Return['error'] = $this->lang->line('umb_error_field_jumlah');
			}

			if($Return['error']!=''){
				$this->output($Return);
			}
			$data = array(
				'komisi_title' => $this->input->post('title'),
				'jumlah_komisi' => $this->input->post('jumlah'),
				'karyawan_id' => $this->input->post('user_id'),
				'is_komisi_kena_pajak' => $this->input->post('is_komisi_kena_pajak'),
				'jumlah_option' => $this->input->post('jumlah_option')
			);
			$result = $this->Karyawans_model->add_gaji_komissi($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_karyawan_set_komisi_success');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function set_statutory_potongans() {

		if($this->input->post('type')=='statutory_potongans_info') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();	
			if($this->input->post('title')==='') {
				$Return['error'] = $this->lang->line('umb_error_title');
			} else if($this->input->post('jumlah')==='') {
				$Return['error'] = $this->lang->line('umb_error_field_jumlah');
			}

			if($Return['error']!=''){
				$this->output($Return);
			}
			$data = array(
				'title_potongan' => $this->input->post('title'),
				'jumlah_potongan' => $this->input->post('jumlah'),
				'statutory_options' => $this->input->post('statutory_options'),
				'karyawan_id' => $this->input->post('user_id')
			);
			$result = $this->Karyawans_model->add_gaji_statutory_potongans($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_karyawan_set_statutory_potongan_success');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function set_pembayarans_lainnya() {

		if($this->input->post('type')=='pembayarans_lainnya_info') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();	
			if($this->input->post('title')==='') {
				$Return['error'] = $this->lang->line('umb_error_title');
			} else if($this->input->post('jumlah')==='') {
				$Return['error'] = $this->lang->line('umb_error_field_jumlah');
			}

			if($Return['error']!=''){
				$this->output($Return);
			}
			$data = array(
				'title_pembayarans' => $this->input->post('title'),
				'jumlah_pembayarans' => $this->input->post('jumlah'),
				'karyawan_id' => $this->input->post('user_id'),
				'ia_pembayaranlainnya_kena_pajak' => $this->input->post('ia_pembayaranlainnya_kena_pajak'),
				'jumlah_option' => $this->input->post('jumlah_option')
			);
			$result = $this->Karyawans_model->add_gaji_pembayarans_lainnya($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_karyawan_set_otherpayments_success');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function delete_all_tunjanagans() {

		if($this->input->post('data')=='delete_record') {

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = $this->uri->segment(4);
			$result = $this->Karyawans_model->delete_record_tunjanagan($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_karyawan_delete_tunjanagan_success');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}

	public function delete_all_komissi() {

		if($this->input->post('data')=='delete_record') {

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = $this->uri->segment(4);
			$result = $this->Karyawans_model->delete_record_komisi($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_karyawan_delete_komisi_success');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}

	public function delete_all_statutory_potongans() {

		if($this->input->post('data')=='delete_record') {

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = $this->uri->segment(4);
			$result = $this->Karyawans_model->delete_record_statutory_potongans($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_karyawan_delete_statutory_potongan_success');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}

	public function pembayaran_lainnya() {

		if($this->input->post('data')=='delete_record') {

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = $this->uri->segment(4);
			$result = $this->Karyawans_model->delete_record_pembayaran_lainnya($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_karyawan_delete_otherpayments_success');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}

	public function delete_all_potongans() {

		if($this->input->post('data')=='delete_record') {

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = $this->uri->segment(4);
			$result = $this->Karyawans_model->delete_record_pinajaman($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_karyawan_delete_pinajaman_success');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}

	public function delete_krywn_lembur() {

		if($this->input->post('data')=='delete_record') {

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = $this->uri->segment(4);
			$result = $this->Karyawans_model->delete_record_lembur($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_karyawan_delete_lembur_success');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}

	public function gaji_all_tunjanagans() {
		//set data
		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/karyawans/detail_karyawan", $data);
		} else {
			redirect('admin/');
		}

		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		$id = $this->uri->segment(4);
		$tunjanagans = $this->Karyawans_model->set_tunjanagans_karyawan($id);

		$data = array();
		/*$system = $this->Umb_model->read_setting_info(1);
		$default_currency = $this->Umb_model->read_currency_con_info($system[0]->default_currency_id);
		if(!is_null($default_currency)) {
			$current_rate = $default_currency[0]->to_currency_rate;
			$current_title = $default_currency[0]->to_currency_title;
		} else {
			$current_rate = 1;
			$current_title = 'USD';
		}*/
		foreach($tunjanagans->result() as $r) {			
		//$current_jumlah = $r->jumlah_tunjanagan * $current_rate;
			if($r->jumlah_option==0){
				$jumlah_tunjanagan_opt = $this->lang->line('umb_title_fixed_pajak');
			} else {
				$jumlah_tunjanagan_opt = $this->lang->line('umb_title_percent_pajak');
			}
			if($r->is_tunjanagan_kena_pajak==0){
				$tunjanagan_opt = $this->lang->line('umb_gaji_tunjanagan_todak_kena_pajak');
			} else if($r->is_tunjanagan_kena_pajak==1){
				$tunjanagan_opt = $this->lang->line('umb_fully_kena_pajak');
			} else {
				$tunjanagan_opt = $this->lang->line('umb_partially_kena_pajak');
			}
			$data[] = array(
				'<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->tunjanagan_id . '" data-field_type="gaji_tunjanagan"><span class="fas fa-pencil-alt"></span></button></span><span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->tunjanagan_id . '" data-token_type="all_tunjanagans"><span class="fas fa-trash-restore"></span></button></span>',
				$r->title_tunjanagan,
				$r->jumlah_tunjanagan,
				$tunjanagan_opt,
				$jumlah_tunjanagan_opt,
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $tunjanagans->num_rows(),
			"recordsFiltered" => $tunjanagans->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function gaji_all_komissi() {
		//set data
		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/karyawans/detail_karyawan", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$id = $this->uri->segment(4);
		$komissi = $this->Karyawans_model->set_komissi_karyawan($id);
		
		$data = array();

		foreach($komissi->result() as $r) {			
			if($r->jumlah_option==0){
				$opt_jumlah_komisi = $this->lang->line('umb_title_fixed_pajak');
			} else {
				$opt_jumlah_komisi = $this->lang->line('umb_title_percent_pajak');
			}
			if($r->is_komisi_kena_pajak==0){
				$opt_komisi = $this->lang->line('umb_gaji_tunjanagan_todak_kena_pajak');
			} else if($r->is_komisi_kena_pajak==1){
				$opt_komisi = $this->lang->line('umb_fully_kena_pajak');
			} else {
				$opt_komisi = $this->lang->line('umb_partially_kena_pajak');
			}
			$data[] = array(
				'<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->gaji_komissi_id . '" data-field_type="gaji_komissi"><span class="fas fa-pencil-alt"></span></button></span><span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->gaji_komissi_id . '" data-token_type="all_komissi"><span class="fas fa-trash-restore"></span></button></span>',
				$r->komisi_title,
				$r->jumlah_komisi,
				$opt_komisi,
				$opt_jumlah_komisi
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $komissi->num_rows(),
			"recordsFiltered" => $komissi->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function gaji_all_statutory_potongans() {
		//set data
		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/karyawans/detail_karyawan", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$id = $this->uri->segment(4);
		$statutory_potongans = $this->Karyawans_model->set_karyawan_statutory_potongans($id);
		
		$data = array();

		foreach($statutory_potongans->result() as $r) {			
			
			if($r->statutory_options==0){
				$opt_jumlah_sd = $this->lang->line('umb_title_fixed_pajak');
			} else {
				$opt_jumlah_sd = $this->lang->line('umb_title_percent_pajak');
			}
			$data[] = array(
				'<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->statutory_potongans_id . '" data-field_type="gaji_statutory_potongans"><span class="fas fa-pencil-alt"></span></button></span><span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->statutory_potongans_id . '" data-token_type="all_statutory_potongans"><span class="fas fa-trash-restore"></span></button></span>',
				$r->title_potongan,
				$r->jumlah_potongan,
				$opt_jumlah_sd
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $statutory_potongans->num_rows(),
			"recordsFiltered" => $statutory_potongans->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function gaji_all_pembayarans_lainnya() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/karyawans/detail_karyawan", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$id = $this->uri->segment(4);
		$pembayaran_lainnya = $this->Karyawans_model->set_karyawan_pembayarans_lainnya($id);
		
		$data = array();

		foreach($pembayaran_lainnya->result() as $r) {			
			if($r->jumlah_option==0){
				$opt_jumlah_lainnya = $this->lang->line('umb_title_fixed_pajak');
			} else {
				$opt_jumlah_lainnya = $this->lang->line('umb_title_percent_pajak');
			}
			if($r->ia_pembayaranlainnya_kena_pajak==0){
				$other_opt = $this->lang->line('umb_gaji_tunjanagan_todak_kena_pajak');
			} else if($r->ia_pembayaranlainnya_kena_pajak==1){
				$other_opt = $this->lang->line('umb_fully_kena_pajak');
			} else {
				$other_opt = $this->lang->line('umb_partially_kena_pajak');
			}
			$data[] = array(
				'<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->pembayarans_lainnya_id . '" data-field_type="gaji_pembayarans_lainnya"><span class="fas fa-pencil-alt"></span></button></span><span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->pembayarans_lainnya_id . '" data-token_type="all_pembayarans_lainnya"><span class="fas fa-trash-restore"></span></button></span>',
				$r->title_pembayarans,
				$r->jumlah_pembayarans,
				$other_opt,
				$opt_jumlah_lainnya
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $pembayaran_lainnya->num_rows(),
			"recordsFiltered" => $pembayaran_lainnya->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}
	
	public function gaji_lembur() {
		//set data
		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/karyawans/detail_karyawan", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$id = $this->uri->segment(4);
		$lembur = $this->Karyawans_model->set_karyawan_lembur($id);
		$system = $this->Umb_model->read_setting_info(1);
		$data = array();

		foreach($lembur->result() as $r) {			
			$current_jumlah = $r->nilai_lembur;
			$data[] = array(
				'<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->gaji_lembur_id . '" data-field_type="krywn_lembur"><span class="fas fa-pencil-alt"></span></button></span><span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->gaji_lembur_id . '" data-token_type="krywn_lembur"><span class="fas fa-trash-restore"></span></button></span>',
				$r->type_lembur,
				$r->no_of_days,
				$r->jam_lembur,
				$current_jumlah
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $lembur->num_rows(),
			"recordsFiltered" => $lembur->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}
	
	public function gaji_all_potongans() {
		//set data
		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/karyawans/detail_karyawan", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$id = $this->uri->segment(4);
		$potongans = $this->Karyawans_model->set_potongans_karyawan($id);
		/*$system = $this->Umb_model->read_setting_info(1);
		$default_currency = $this->Umb_model->read_currency_con_info($system[0]->default_currency_id);
		if(!is_null($default_currency)) {
			$current_rate = $default_currency[0]->to_currency_rate;
			$current_title = $default_currency[0]->to_currency_title;
		} else {
			$current_rate = 1;
			$current_title = 'USD';
		}*/
		$data = array();

		foreach($potongans->result() as $r) {		
			
			$sdate = $this->Umb_model->set_date_format($r->start_date);
			$edate = $this->Umb_model->set_date_format($r->end_date);	
		// loan time
			if($r->waktu_pinjaman < 2) {
				$waktu_pinjaman = $r->waktu_pinjaman. ' '.$this->lang->line('umb_karyawan_waktu_pinjaman_single_month');
			} else {
				$waktu_pinjaman = $r->waktu_pinjaman. ' '.$this->lang->line('umb_karyawan_waktu_pinjaman_more_months');
			}
			if($r->options_pinjaman == 1) {
				$options_pinjaman = $this->lang->line('umb_pinjaman_ssc_title');
			} else if($r->options_pinjaman == 2) {
				$options_pinjaman = $this->lang->line('umb_pinjaman_hdmf_title');
			} else {
				$options_pinjaman = $this->lang->line('umb_pinjaman_other_sd_title');
			}
			$details_pinjaman = '<div class="text-semibold">'.$this->lang->line('dashboard_umb_title').': '.$r->title_potongan_pinjaman.'</div>
			<div class="text-muted">'.$this->lang->line('umb_gaji_options_pinjaman').': '.$options_pinjaman.'</div><div class="text-muted">'.$this->lang->line('umb_start_date').': '.$sdate.'</div><div class="text-muted">'.$this->lang->line('umb_end_date').': '.$edate.'</div><div class="text-muted">'.$this->lang->line('umb_alasan').': '.$r->reason.'</div>';
			//$eoption_removed = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-info waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->potongan_pinjaman_id . '" data-field_type="gaji_pinjaman"><span class="fas fa-pencil-alt"></span></button></span>';
			$data[] = array(
				'<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->potongan_pinjaman_id . '" data-token_type="all_potongans"><span class="fas fa-trash-restore"></span></button></span>',
				$details_pinjaman,
				$r->angsuran_bulanan,
				$waktu_pinjaman
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $potongans->num_rows(),
			"recordsFiltered" => $potongans->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}
	
	public function info_update_pinjaman() {
		
		if($this->input->post('type')=='pinjaman_info') {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$reason = $this->input->post('reason');
			$qt_reason = htmlspecialchars(addslashes($reason), ENT_QUOTES);
			$start_date = $this->input->post('start_date');
			$end_date = $this->input->post('end_date');
			$st_date = strtotime($start_date);
			$ed_date = strtotime($end_date);
			
			$id = $this->input->post('e_field_id');
			
			if($this->input->post('title_potongan_pinjaman')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_set_pinjaman_title_error');
			} else if($this->input->post('angsuran_bulanan')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_set_mins_title_error');
			} else if($this->input->post('start_date')==='') {
				$Return['error'] = $this->lang->line('umb_error_start_date');
			} else if($this->input->post('end_date')==='') {
				$Return['error'] = $this->lang->line('umb_error_end_date');
			} else if($st_date > $ed_date) {
				$Return['error'] = $this->lang->line('umb_error_start_end_date');
			}
			
			if($Return['error']!=''){
				$this->output($Return);
			}
			
			$data = array(
				'title_potongan_pinjaman' => $this->input->post('title_potongan_pinjaman'),
				'reason' => $qt_reason,
				'angsuran_bulanan' => $this->input->post('angsuran_bulanan'),
				'start_date' => $this->input->post('start_date'),
				'end_date' => $this->input->post('end_date'),
				'options_pinjaman' => $this->input->post('options_pinjaman')
			);
			
			$result = $this->Karyawans_model->update_record_gaji_pinjaman($data,$id);
			
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_karyawan_update_pinjaman_success');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function info_pinjaman_karyawan() {
		
		if($this->input->post('type')=='pinjaman_info') {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$reason = $this->input->post('reason');
			$qt_reason = htmlspecialchars(addslashes($reason), ENT_QUOTES);
			$start_date = $this->input->post('start_date');
			$end_date = $this->input->post('end_date');
			$st_date = strtotime($start_date);
			$ed_date = strtotime($end_date);
			
			$user_id = $this->input->post('user_id');
			
			if($this->input->post('title_potongan_pinjaman')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_set_pinjaman_title_error');
			} else if($this->input->post('angsuran_bulanan')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_set_mins_title_error');
			} else if($this->input->post('start_date')==='') {
				$Return['error'] = $this->lang->line('umb_error_start_date');
			} else if($this->input->post('end_date')==='') {
				$Return['error'] = $this->lang->line('umb_error_end_date');
			} else if($st_date > $ed_date) {
				$Return['error'] = $this->lang->line('umb_error_start_end_date');
			}
			
			if($Return['error']!=''){
				$this->output($Return);
			}
			
			$tm = $this->Karyawans_model->get_month_diff($this->input->post('start_date'),$this->input->post('end_date'));
			if($tm < 1) {
				$m_ins = $this->input->post('angsuran_bulanan');
			} else {
				$m_ins = $this->input->post('angsuran_bulanan')/$tm;
			}
			
			$data = array(
				'title_potongan_pinjaman' => $this->input->post('title_potongan_pinjaman'),
				'reason' => $qt_reason,
				'angsuran_bulanan' => $this->input->post('angsuran_bulanan'),
				'start_date' => $this->input->post('start_date'),
				'end_date' => $this->input->post('end_date'),
				'options_pinjaman' => $this->input->post('options_pinjaman'),
				'waktu_pinjaman' => $tm,
				'pinjaman_jumlah_potongan' => $m_ins,
				'karyawan_id' => $user_id
			);
			
			$result = $this->Karyawans_model->add_gaji_pinjaman($data);
			
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_karyawan_add_pinjaman_success');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function filter_perusahaan_f_locations() {

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
				$this->load->view("admin/filter/filter_perusahaan_f_locations", $data);
			} else {
				redirect('admin/');
			}
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}

	public function filter_location_f_departments() {

		$data['title'] = $this->Umb_model->site_title();
		$keywords = preg_split("/[\s,]+/", $this->uri->segment(4));
		if(is_numeric($keywords[0])) {
			$id = $keywords[0];
			
			$data = array(
				'location_id' => $id
			);
			$session = $this->session->userdata('username');
			if(!empty($session)){ 
				$data = $this->security->xss_clean($data);
				$this->load->view("admin/filter/filter_location_f_departments", $data);
			} else {
				redirect('admin/');
			}
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}
	public function filter_location_f_penunjukan() {

		$data['title'] = $this->Umb_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'department_id' => $id,
			'all_penunjukans' => $this->Penunjukan_model->all_penunjukans(),
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/filter/filter_location_f_penunjukan", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}
	
	public function documents_kadaluarsa() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('umb_e_details_exp_documents').' | '.$this->Umb_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('umb_e_details_exp_documents');
		$data['path_url'] = 'documents_karyawans_kadaluarsa';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('400',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/karyawans/list_documents_kadaluarsa", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
		} else {
			redirect('admin/dashboard');
		}
	}
	
	public function list_documents_kadaluarsa() {
		//set data
		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/karyawans/list_documents_kadaluarsa", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$user_info = $this->Umb_model->read_user_info($session['user_id']);
		if($user_info[0]->user_role_id==1){
			$documents = $this->Karyawans_model->get_all_documents_kadaluarsa();
		} else {
			$documents = $this->Karyawans_model->get_user_all_documents_kadaluarsa($session['user_id']);
		}
		
		$data = array();

		foreach($documents->result() as $r) {
			
			$d_type = $this->Karyawans_model->read_informasi_type_document($r->type_document_id);
			if(!is_null($d_type)){
				$document_d = $d_type[0]->type_document;
			} else {
				$document_d = '--';
			}
			$tanggal_kadaluarsa = $this->Umb_model->set_date_format($r->tanggal_kadaluarsa);
			if($r->document_file!='' && $r->document_file!='no file') {
				$functions = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="Download"><a href="'.site_url().'admin/download?type=document&filename='.$r->document_file.'"><button type="button" class="btn icon-btn btn-outline-secondary btn-sm waves-effect waves-light" title="'.$this->lang->line('umb_download').'"><i class="oi oi-cloud-download"></i></button></a></span>';
			} else {
				$functions ='';
			}

			$xuser_info = $this->Umb_model->read_user_info($r->karyawan_id);	
			if(!is_null($xuser_info)){
				if($user_info[0]->user_role_id==1){
					$fc_name = '<a target="_blank" href="'.site_url('admin/karyawans/detail/').$r->karyawan_id.'">'.$xuser_info[0]->first_name.' '.$xuser_info[0]->last_name.'</a>';
				} else {
					$fc_name = $xuser_info[0]->first_name.' '.$xuser_info[0]->last_name;
				}
			} else {
				$fc_name = '--';	
			}
			$data[] = array(
				$functions.'<span data-toggle="tooltip" data-placement="top" data-state="primary"  title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-outline-secondary btn-sm waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->document_id . '" data-field_type="document"><i class="fas fa-pencil-alt"></i></button></span>',
				$fc_name,
				$document_d,
				$r->title,
				$tanggal_kadaluarsa
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $documents->num_rows(),
			"recordsFiltered" => $documents->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}
	
	public function list_immigration_kadaluarsa() {
		//set data
		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/karyawans/list_documents_kadaluarsa", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		//	$id = $this->uri->segment(4);
		$user_info = $this->Umb_model->read_user_info($session['user_id']);
		if($user_info[0]->user_role_id==1){
			$immigration = $this->Karyawans_model->get_all_img_documents_kadaluarsa();
		} else {
			$immigration = $this->Karyawans_model->get_user_all_img_documents_kadaluarsa($session['user_id']);
		}
		
		$data = array();

		foreach($immigration->result() as $r) {
			
			$tanggal_terbit = $this->Umb_model->set_date_format($r->tanggal_terbit);
			$tanggal_kaaluarsa = $this->Umb_model->set_date_format($r->tanggal_kaaluarsa);
			$tanggal_tinjauan_yang_memenuhi_syarat = $this->Umb_model->set_date_format($r->tanggal_tinjauan_yang_memenuhi_syarat);
			$d_type = $this->Karyawans_model->read_informasi_type_document($r->type_document_id);
			if(!is_null($d_type)){
				$document_d = $d_type[0]->type_document.'<br>'.$r->nomor_document;
			} else {
				$document_d = $r->nomor_document;
			}
			$negara = $this->Umb_model->read_info_negara($r->negara_id);
			if(!is_null($negara)){
				$c_name = $negara[0]->nama_negara;
			} else {
				$c_name = '--';	
			}

			$xuser_info = $this->Umb_model->read_user_info($r->karyawan_id);	
			if(!is_null($xuser_info)){
				if($user_info[0]->user_role_id==1){
					$fc_name = '<a target="_blank" href="'.site_url('admin/karyawans/detail/').$r->karyawan_id.'">'.$xuser_info[0]->first_name.' '.$xuser_info[0]->last_name.'</a>';
				} else {
					$fc_name = $xuser_info[0]->first_name.' '.$xuser_info[0]->last_name;
				}
			} else {
				$fc_name = '--';	
			}
			if($r->document_file!='' && $r->document_file!='no file') {
				$functions = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="Download"><a href="'.site_url().'admin/download?type=document/immigration&filename='.$r->document_file.'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" title="'.$this->lang->line('umb_download').'"><i class="oi oi-cloud-download"></i></button></a></span>';
			} else {
				$functions ='';
			}
			$data[] = array(
				$functions.'<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->immigration_id . '" data-field_type="imgdocument"><i class="fas fa-pencil-alt"></i></button></span>',
				$fc_name,
				$document_d,
				$tanggal_terbit,
				$tanggal_kaaluarsa,
				$c_name,
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $immigration->num_rows(),
			"recordsFiltered" => $immigration->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}
	public function list_licence_perusahaan_exp() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/karyawans/list_documents_kadaluarsa", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$role_resources_ids = $this->Umb_model->user_role_resource();
		$user_info = $this->Umb_model->read_user_info($session['user_id']);
		if($user_info[0]->user_role_id==1){
			$perusahaan = $this->Karyawans_model->all_licence_perusahaan_kadaluarsa();
		} else {
			$perusahaan = $this->Karyawans_model->get_licence_perusahaan_kadaluarsa($user_info[0]->perusahaan_id);
		}
		$data = array();

		foreach($perusahaan->result() as $r) {
			
			if(in_array('247',$role_resources_ids)) {
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-field_id="'. $r->document_id . '" data-field_type="license_perusahaans_kadaluarsaa"><i class="fas fa-pencil-alt"></i></button></span>';
			} else {
				$edit = '';
			}
			$perusahaan_id = $this->Perusahaan_model->read_informasi_perusahaan($r->perusahaan_id);
			if(!is_null($perusahaan_id)){
				$nama_perusahaan = $perusahaan_id[0]->name;
			} else {
				$nama_perusahaan = '--';	
			}

			if($r->document!='' && $r->document!='no file') {
				$doc_view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_download').'"><a href="'.base_url().'admin/download?type=perusahaan/documents_resmi&filename='.$r->document.'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" title="'.$this->lang->line('umb_download').'"><i class="oi oi-cloud-download"></i></button></a></span>';
			} else {
				$doc_view ='';
			}
			$combhr = $doc_view.$edit;
			$inama_license = $r->nama_license.'<br><small class="text-muted"><i>'.$this->lang->line('umb_hr_official_nomor_license').': '.$r->nomor_license.'<i></i></i></small>';
			$data[] = array(
				$combhr,
				$inama_license,
				$nama_perusahaan,
				$r->tanggal_kaaluarsa
			);
		}
		$output = array(
			"draw" => $draw,
			"recordsTotal" => $perusahaan->num_rows(),
			"recordsFiltered" => $perusahaan->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function list_garansi_assets() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		if(!empty($session)){ 
			$this->load->view("admin/karyawans/list_documents_kadaluarsa", $data);
		} else {
			redirect('admin/');
		}

		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		$role_resources_ids = $this->Umb_model->user_role_resource();
		$user_info = $this->Umb_model->read_user_info($session['user_id']);
		if($user_info[0]->user_role_id==1){
			$assets = $this->Karyawans_model->all_garansi_assets_kadaluarsa();
		} else {
			if(in_array('265',$role_resources_ids)) {
				$assets = $this->Karyawans_model->all_garansi_assets_perusahaan_kadaluarsa($user_info[0]->perusahaan_id);
			} else {
				$assets = $this->Karyawans_model->user_all_garansi_assets_kadaluarsa($session['user_id']);
			}
		}
		$data = array();

		foreach($assets->result() as $r) {						

			$kategori_assets = $this->Assets_model->read_info_kategori_assets($r->kategori_assets_id);
			if(!is_null($kategori_assets)){
				$kategori = $kategori_assets[0]->nama_kategori;
			} else {
				$kategori = '--';	
			}

			if($r->sedang_bekerja==1){
				$bekerja = $this->lang->line('umb_yes');
			} else {
				$bekerja = $this->lang->line('umb_no');
			}

			$user = $this->Umb_model->read_user_info($r->karyawan_id);

			if(!is_null($user)){
				$full_name = $user[0]->first_name.' '.$user[0]->last_name;
			} else {
				$full_name = '--';	
			}

			if(in_array('263',$role_resources_ids)) { 
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->assets_id . '" data-field_type="garansi_assets_kadaluarsa"><i class="fas fa-pencil-alt"></i></button></span>';
			} else {
				$edit = '';
			}
			
			if(in_array('265',$role_resources_ids)) { 
				$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-asset_id="'. $r->assets_id . '"><span class="fa fa-eye"></span></button></span>';
			} else {
				$view = '';
			}
			$combhr = $edit;
			$created_at = $this->Umb_model->set_date_format($r->created_at);
			$iname = $r->name.'<br><small class="text-muted"><i>'.$this->lang->line('umb_created_at').': '.$created_at.'<i></i></i></small>';					 			  				
			$data[] = array($combhr,
				$iname,
				$kategori,
				$r->kode_asset_perusahaan,
				$bekerja,
				$full_name
			);
		}
		$output = array(
			"draw" => $draw,
			"recordsTotal" => $assets->num_rows(),
			"recordsFiltered" => $assets->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function dialog_document_exp() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('field_id');
		$document = $this->Karyawans_model->read_informasi_document($id);
		$data = array(
			'document_id' => $document[0]->document_id,
			'type_document_id' => $document[0]->type_document_id,
			'd_karyawan_id' => $document[0]->karyawan_id,
			'all_types_document' => $this->Karyawans_model->all_types_document(),
			'tanggal_kadaluarsa' => $document[0]->tanggal_kadaluarsa,
			'title' => $document[0]->title,
			'is_alert' => $document[0]->is_alert,
			'description' => $document[0]->description,
			'notification_email' => $document[0]->notification_email,
			'document_file' => $document[0]->document_file
		);
		if(!empty($session)){ 
			$this->load->view('admin/karyawans/dialog_details_karyawan_exp', $data);
		} else {
			redirect('admin/');
		}
	}
	
	public function dialog_imgdocument_exp() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('field_id');
		$document = $this->Karyawans_model->read_informasi_imgdocument($id);
		$data = array(
			'immigration_id' => $document[0]->immigration_id,
			'type_document_id' => $document[0]->type_document_id,
			'd_karyawan_id' => $document[0]->karyawan_id,
			'all_types_document' => $this->Karyawans_model->all_types_document(),
			'all_negaraa' => $this->Umb_model->get_negaraa(),
			'nomor_document' => $document[0]->nomor_document,
			'document_file' => $document[0]->document_file,
			'tanggal_terbit' => $document[0]->tanggal_terbit,
			'tanggal_kaaluarsa' => $document[0]->tanggal_kaaluarsa,
			'negara_id' => $document[0]->negara_id,
			'tanggal_tinjauan_yang_memenuhi_syarat' => $document[0]->tanggal_tinjauan_yang_memenuhi_syarat,
		);
		if(!empty($session)){ 
			$this->load->view('admin/karyawans/dialog_details_karyawan_exp', $data);
		} else {
			redirect('admin/');
		}
	}
	
	public function dialog_exp_license_perusahaan_kadaluarsa() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('field_id');
       // $data['all_negaraa'] = $this->Umb_model->get_negaraa();
		$result = $this->Perusahaan_model->read_info_document_perusahaan($id);
		$data = array(
			'document_id' => $result[0]->document_id,
			'nama_license' => $result[0]->nama_license,
			'perusahaan_id' => $result[0]->perusahaan_id,
			'tanggal_kaaluarsa' => $result[0]->tanggal_kaaluarsa,
			'nomor_license' => $result[0]->nomor_license,
			'license_notification' => $result[0]->license_notification,
			'document' => $result[0]->document,
			'all_negaraa' => $this->Umb_model->get_negaraa(),
			'get_all_perusahaans' => $this->Umb_model->get_perusahaans(),
			'get_types_perusahaan' => $this->Perusahaan_model->get_types_perusahaan()
		);
		$this->load->view('admin/karyawans/dialog_details_karyawan_exp', $data);
	}

	public function dialog_exp_garansi_assets_kadaluarsa() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('field_id');
		$result = $this->Assets_model->read_info_assets($id);
		$data = array(
			'assets_id' => $result[0]->assets_id,
			'kategori_assets_id' => $result[0]->kategori_assets_id,
			'perusahaan_id' => $result[0]->perusahaan_id,
			'karyawan_id' => $result[0]->karyawan_id,
			'kode_asset_perusahaan' => $result[0]->kode_asset_perusahaan,
			'name' => $result[0]->name,
			'tanggal_pembelian' => $result[0]->tanggal_pembelian,
			'nomor_invoice' => $result[0]->nomor_invoice,
			'manufacturer' => $result[0]->manufacturer,
			'serial_number' => $result[0]->serial_number,
			'tanggal_akhir_garansi' => $result[0]->tanggal_akhir_garansi,
			'asset_note' => $result[0]->asset_note,
			'asset_image' => $result[0]->asset_image,
			'sedang_bekerja' => $result[0]->sedang_bekerja,
			'created_at' => $result[0]->created_at,
			'all_karyawans' => $this->Umb_model->all_karyawans(),
			'all_kategoris_assets' => $this->Assets_model->get_all_kategoris_assets(),
			'all_perusahaans' => $this->Umb_model->get_perusahaans()
		);
		$this->load->view('admin/karyawans/dialog_details_karyawan_exp', $data);
	}
	
	public function dialog_security_level() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('field_id');
		$result = $this->Karyawans_model->read_infomasi_security_level($id);
		$data = array(
			'security_level_id' => $result[0]->security_level_id,
			'karyawan_id' => $result[0]->karyawan_id,
			'security_type' => $result[0]->security_type,
			'date_of_clearance' => $result[0]->date_of_clearance,
			'tanggal_kaaluarsa' => $result[0]->tanggal_kaaluarsa
		);
		if(!empty($session)){ 
			$this->load->view('admin/karyawans/dialog_details_karyawan', $data);
		} else {
			redirect('admin/');
		}
	}
}
