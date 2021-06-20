<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Timesheet extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		
		$this->load->model("Timesheet_model");
		$this->load->model("Karyawans_model");
		$this->load->model("Umb_model");
		$this->load->library('email');
		$this->load->model("Department_model");
		$this->load->model("Penunjukan_model");
		$this->load->model("Roles_model");
		$this->load->model("Project_model");
		$this->load->model("Location_model");
	}
	
	
	public function output($Return=array()){
		
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		
		exit(json_encode($Return));
	}
	
	public function kehadiran() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('dashboard_kehadiran').' | '.$this->Umb_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('dashboard_kehadiran');
		$data['path_url'] = 'kehadiran';
		$data['all_shifts_kantor'] = $this->Location_model->all_locations_kantor();
		$data['get_all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('28',$role_resources_ids)) {
			if(!empty($session)){
				$data['subview'] = $this->load->view("admin/timesheet/list_kehadiran", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/dashboard/');
			}	
		} else {
			redirect('admin/dashboard');
		}	  
	}

	public function dashboard_kehadiran() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('hr_title_dashboard_timesheet').' | '.$this->Umb_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('hr_title_dashboard_timesheet');
		$data['path_url'] = 'dashboard_kehadiran';
		//$data['get_invoice_pembayarans'] = $this->Keuangan_model->get_invoice_pembayarans();
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('423',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/timesheet/dashboard_kehadiran", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}

	public function tanggal_bijaksana_kehadiran() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('left_tanggal_bijaksana_kehadiran').' | '.$this->Umb_model->site_title();
		$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		$data['get_all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$data['breadcrumbs'] = $this->lang->line('left_tanggal_bijaksana_kehadiran');
		$data['path_url'] = 'tanggal_bijaksana_kehadiran';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('29',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/timesheet/tanggal_bijaksana", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}  
	}
	
	public function update_kehadiran() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('left_update_kehadiran').' | '.$this->Umb_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('left_update_kehadiran');
		$data['path_url'] = 'update_kehadiran';		
		$data['get_all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('30',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/timesheet/update_kehadiran", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}	  
	}
	
	public function import() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('left_import_kehadiran').' | '.$this->Umb_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('left_import_kehadiran');
		$data['path_url'] = 'import_kehadiran';		
		$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('31',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/timesheet/import_kehadiran", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}		  
	}

	public function index() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$month_year = $this->input->post('month_year');
		if(isset($month_year)): $title = date('F Y', strtotime($month_year)); else: $title = date('F Y'); endif;
		$data['title'] = $this->lang->line('left_timesheet').' | '.$title;
		$data['breadcrumbs'] = $this->lang->line('left_timesheet');
		$data['path_url'] = 'timesheet_bulanan';		
		$data['get_all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$data['all_shifts_kantor'] = $this->Location_model->all_locations_kantor();
		$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('10',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/timesheet/timesheet_bulanan", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}		  
	}

	public function timecalendar() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('umb_kehadiran_waktucalendar').' | '.$this->Umb_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('umb_kehadiran_waktucalendar');
		$data['path_url'] = 'timesheet_calendar';
		$data['get_all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('261',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/calendar/timecalendar", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}		  
	}
	
	public function import_kehadiran() {
		
		if($this->input->post('is_ajax')=='3') {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
			if(empty($_FILES['file']['name'])) {
				$Return['error'] = $this->lang->line('umb_kehadiran_allowed_size');
			} else {
				if(in_array($_FILES['file']['type'],$csvMimes)){
					if(is_uploaded_file($_FILES['file']['tmp_name'])){
						if(filesize($_FILES['file']['tmp_name']) > 512000) {
							$Return['error'] = $this->lang->line('umb_error_import_kehadiran_size');
						} else {
							$csvFile = fopen($_FILES['file']['tmp_name'], 'r');
							fgetcsv($csvFile);
							while(($line = fgetcsv($csvFile)) !== FALSE){
								$tanggal_kehadiran = $line[1];
								$clock_in = $line[2];
								$clock_out = $line[3];
								$clock_in2 = $tanggal_kehadiran.' '.$clock_in;
								$clock_out2 = $tanggal_kehadiran.' '.$clock_out;
								$total_kerja_cin =  new DateTime($clock_in2);
								$total_kerja_cout =  new DateTime($clock_out2);
								$interval_cin = $total_kerja_cout->diff($total_kerja_cin);
								$hours_in   = $interval_cin->format('%h');
								$minutes_in = $interval_cin->format('%i');
								$total_kerja = $hours_in .":".$minutes_in;
								$user = $this->Umb_model->read_user_melalui_karyawan_id($line[0]);
								if(!is_null($user)){
									$user_id = $user[0]->user_id;
								} else {
									$user_id = '0';
								}
								$data = array(
									'karyawan_id' => $user_id,
									'tanggal_kehadiran' => $tanggal_kehadiran,
									'clock_in' => $clock_in2,
									'clock_out' => $clock_out2,
									'time_late' => $clock_in2,
									'total_kerja' => $total_kerja,
									'early_leaving' => $clock_out2,
									'lembur' => $clock_out2,
									'status_kehadiran' => 'Present',
									'clock_in_out' => '0'
								);
								$result = $this->Timesheet_model->add_kehadiran_karyawan($data);
							}					
							fclose($csvFile);
							$Return['result'] = $this->lang->line('umb_sukses_import_kehadiran');
						}
					}else{
						$Return['error'] = $this->lang->line('umb_error_tidak_import_kehadiran');
					}
				}else{
					$Return['error'] = $this->lang->line('umb_error_invalid_file');
				}
			} 
			if($Return['error']!=''){
				$this->output($Return);
			}
			$this->output($Return);
			exit;
		}
	}

	public function shift_kantor() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('left_shift_kantor').' | '.$this->Umb_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('left_shift_kantor');
		$data['get_all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$data['path_url'] = 'shift_kantor';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('7',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/timesheet/shift_kantor", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}

	public function liburan() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('left_liburan').' | '.$this->Umb_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('left_liburan');
		$data['get_all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$data['path_url'] = 'liburan';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('8',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/timesheet/liburan", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}

	 // leave > timesheet
	public function cuti() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('left_cuti').' | '.$this->Umb_model->site_title();
		$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		$data['get_all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$data['all_types_cuti'] = $this->Timesheet_model->all_types_cuti();
		$data['breadcrumbs'] = $this->lang->line('left_cuti');
		$role_resources_ids = $this->Umb_model->user_role_resource();
		$data['path_url'] = 'cuti';
		$laporans_to = get_data_laporans_team($session['user_id']);
		if(in_array('46',$role_resources_ids) || $laporans_to > 0) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/timesheet/cuti", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}

	public function details_cuti() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}

		$data['title'] = $this->Umb_model->site_title();
		$cuti_id = $this->uri->segment(5);
		$result = $this->Timesheet_model->read_informasi_cuti($cuti_id);
		if(is_null($result)){
			redirect('admin/timesheet/cuti');
		}
		$edata = array(
			'is_notify' => 0,
		);
		$this->Umb_model->update_notification_record($edata,$cuti_id,$session['user_id'],'cuti');
		$type = $this->Timesheet_model->read_informasi_type_cuti($result[0]->type_cuti_id);
		if(!is_null($type)){
			$type_name = $type[0]->type_name;
		} else {
			$type_name = '--';	
		}
		$user = $this->Umb_model->read_user_info($result[0]->karyawan_id);
		if(!is_null($user)){
			$full_name = $user[0]->first_name. ' '.$user[0]->last_name;
			$u_role_id = $user[0]->user_role_id;
			$department = $this->Department_model->read_informasi_department($user[0]->department_id);
			if(!is_null($department)){
				$nama_department = $department[0]->nama_department;
			} else {
				$nama_department = '--';	
			}
		} else {
			$full_name = '--';	
			$u_role_id = '--';
			$nama_department = '--';
		}
		$data = array(
			'title' => $this->lang->line('umb_cuti_detail').' | '.$this->Umb_model->site_title(),
			'type' => $type_name,
			'role_id' => $u_role_id,
			'full_name' => $full_name,
			'ekaryawan_id' => $result[0]->karyawan_id,
			'nama_department' => $nama_department,
			'cuti_id' => $result[0]->cuti_id,
			'karyawan_id' => $result[0]->karyawan_id,
			'perusahaan_id' => $result[0]->perusahaan_id,
			'type_cuti_id' => $result[0]->type_cuti_id,
			'from_date' => $result[0]->from_date,
			'to_date' => $result[0]->to_date,
			'applied_on' => $result[0]->applied_on,
			'reason' => $result[0]->reason,
			'remarks' => $result[0]->remarks,
			'status' => $result[0]->status,
			'attachment_cuti' => $result[0]->attachment_cuti,
			'is_half_day' => $result[0]->is_half_day,
			'created_at' => $result[0]->created_at,
			'all_karyawans' => $this->Umb_model->all_karyawans(),
			'all_types_cuti' => $this->Timesheet_model->all_types_cuti(),
		);
		$data['breadcrumbs'] = $this->lang->line('umb_cuti_detail');
		$data['path_url'] = 'details_cuti';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		$laporans_to = get_data_laporans_team($session['user_id']);
		if(in_array('46',$role_resources_ids) || $laporans_to > 0) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/timesheet/details_cuti", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}

	}

	public function details_tugas() {

		$session = $this->session->userdata('username');
		$data['title'] = $this->Umb_model->site_title();

		$tugas_id = $this->uri->segment(5);
		$result = $this->Timesheet_model->read_informasi_tugas($tugas_id);
		if(is_null($result)){
			redirect('admin/timesheet/tugass');
		}
		$system = $this->Umb_model->read_setting_info(1);
		if($system[0]->module_projects_tugass!='true'){
			redirect('admin/dashboard');
		}
		$edata = array(
			'is_notify' => 0,
		);
		$this->Umb_model->update_notification_record($edata,$tugas_id,$session['user_id'],'tugass');
		$u_created = $this->Umb_model->read_user_info($result[0]->created_by);

		if(!is_null($u_created)){
			$f_name = $u_created[0]->first_name.' '.$u_created[0]->last_name;
		} else {
			$f_name = '--';	
		}
		$prj_tugas = $this->Project_model->read_informasi_project($result[0]->project_id);
		if(!is_null($prj_tugas)){
			$nama_prj = $prj_tugas[0]->title;
		} else {
			$nama_prj = '--';
		}
		$data = array(
			'title' => $this->lang->line('umb_detail_tugas').' | '.$this->Umb_model->site_title(),
			'tugas_id' => $result[0]->tugas_id,
			'nama_project' => $nama_prj,
			'created_by' => $f_name,
			'nama_tugas' => $result[0]->nama_tugas,
			'assigned_to' => $result[0]->assigned_to,
			'start_date' => $result[0]->start_date,
			'end_date' => $result[0]->end_date,
			'jam_tugas' => $result[0]->jam_tugas,
			'status_tugas' => $result[0]->status_tugas,
			'tugas_note' => $result[0]->tugas_note,
			'progress' => $result[0]->progress_tugas,
			'description' => $result[0]->description,
			'created_at' => $result[0]->created_at,
			'all_karyawans' => $this->Umb_model->all_karyawans()
		);
		$data['breadcrumbs'] = $this->lang->line('umb_detail_tugas');
		$data['path_url'] = 'details_tugas';
		$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		$data['all_types_cuti'] = $this->Timesheet_model->all_types_cuti();
		$session = $this->session->userdata('username');
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('45',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/timesheet/tugass/details_tugas", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}

	}

	public function tugass() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$system = $this->Umb_model->read_setting_info(1);
		if($system[0]->module_projects_tugass!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('left_tugass').' | '.$this->Umb_model->site_title();
		$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		$data['all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$data['all_projects'] = $this->Project_model->get_all_projects();
		$data['breadcrumbs'] = $this->lang->line('left_tugass');
		$data['path_url'] = 'tugass';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('45',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/timesheet/tugass/list_tugas", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}	  
	}

	public function assign_tugas() {

		if($this->input->post('type')=='tugas_user') {		

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
			$id = $this->input->post('tugas_id');
			$result = $this->Timesheet_model->assign_tugas_user($data,$id);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_tugas_assigned');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function tugas_users() {

		$data['title'] = $this->Umb_model->site_title();
		$id = $this->uri->segment(4);

		$data = array(
			'tugas_id' => $id,
			'all_karyawans' => $this->Umb_model->all_karyawans(),
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/timesheet/tugass/get_tugas_users", $data);
		} else {
			redirect('admin/');
		}

		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}

	public function update_status_tugas() {

		if($this->input->post('type')=='update_status') {		
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();		

			$data = array(
				'progress_tugas' => $this->input->post('progres_val'),
				'status_tugas' => $this->input->post('status'),
			);
			$id = $this->input->post('tugas_id');
			$result = $this->Timesheet_model->update_record_tugas($data,$id);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_status_tugas');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function list_tugas() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/timesheet/cuti", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		$role_resources_ids = $this->Umb_model->user_role_resource();
		$user_info = $this->Umb_model->read_user_info($session['user_id']);
		if($user_info[0]->user_role_id==1){
			$tugas = $this->Timesheet_model->get_tugass();
		} else {
			if(in_array('322',$role_resources_ids)) {
				$tugas = $this->Timesheet_model->get_tugass_perusahaan($user_info[0]->perusahaan_id);
			} else {
				$tugas = $this->Timesheet_model->get_tugass_karyawan($session['user_id']);
			}
		}
		$data = array();

		foreach($tugas->result() as $r) {
			$aim = explode(',',$r->assigned_to);

			if($r->assigned_to == '' || $r->assigned_to == 'None') {
				$ol = 'None';
			} else {
				$ol = '';
				foreach(explode(',',$r->assigned_to) as $uid) {
					//$user = $this->Umb_model->read_user_info($uid);
					$assigned_to = $this->Umb_model->read_user_info($uid);
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
				}
				$ol .= '';
			}
			$u_created = $this->Umb_model->read_user_info($r->created_by);
			if(!is_null($u_created)){
				$f_name = $u_created[0]->first_name.' '.$u_created[0]->last_name;
			} else {
				$f_name = '--';	
			}
			$prj_tugas = $this->Project_model->read_informasi_project($r->project_id);
			if(!is_null($prj_tugas)){
				$nama_prj = $prj_tugas[0]->title;
			} else {
				$nama_prj = '--';
			}
			$catnama_tugas = $r->nama_tugas;
			if($r->progress_tugas=='' || $r->progress_tugas==0): $progress = 0; else: $progress = $r->progress_tugas; endif;				
			if($r->progress_tugas <= 20) {
				$progress_class = 'progress-bar-danger';
			} else if($r->progress_tugas > 20 && $r->progress_tugas <= 50){
				$progress_class = 'progress-bar-warning';
			} else if($r->progress_tugas > 50 && $r->progress_tugas <= 75){
				$progress_class = 'progress-bar-info';
			} else {
				$progress_class = 'progress-bar-success';
			}
			$progress_bar = '<p class="m-b-0-5">'.$this->lang->line('umb_completed').' <span class="pull-xs-right">'.$r->progress_tugas.'%</span>
			<div class="progress progress-xs"><div class="progress-bar '.$progress_class.' progress-bar-striped" role="progressbar" aria-valuenow="'.$r->progress_tugas.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$r->progress_tugas.'%"></div></div></p>';
			if($r->status_tugas == 0) {
				$status = '<span class="label label-warning">'.$this->lang->line('umb_not_started').'</span>';
			} else if($r->status_tugas ==1){
				$status = '<span class="label label-primary">'.$this->lang->line('umb_in_progress').'</span>';
			} else if($r->status_tugas ==2){
				$status = '<span class="label label-success">'.$this->lang->line('umb_completed').'</span>';
			} else if($r->status_tugas ==3){
				$status = '<span class="label label-danger">'.$this->lang->line('umb_project_cancelled').'</span>';
			} else {
				$status = '<span class="label label-danger">'.$this->lang->line('umb_project_hold').'</span>';
			}
			$psdate = $this->Umb_model->set_date_format($r->start_date);
			$pedate = $this->Umb_model->set_date_format($r->end_date);
			if(in_array('320',$role_resources_ids)) {
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light edit-data" data-toggle="modal" data-target=".edit-modal-data" data-tugas_id="'. $r->tugas_id.'" data-mname="admin"><span class="fas fa-pencil-alt"></span></button></span>';
				$add_users = ' <a href="javascript:void(0)" class="text-muted" data-toggle="modal" data-target=".edit-modal-data" data-tugas_id="'. $r->tugas_id . '" ><span class="ion ion-md-add" data-placement="top" data-state="primary" data-toggle="tooltip" title="'.$this->lang->line('umb_add_member').'"></span></a> ';
			} else {
				$edit = '';
				$add_users = '';
			}
			if(in_array('321',$role_resources_ids)) {
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->tugas_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}
			if(in_array('322',$role_resources_ids)) {
				$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_view_details').'"><a href="'.site_url().'admin/timesheet/details_tugas/id/'.$r->tugas_id.'/"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span>';
			} else {
				$view = '';
			}
			$combhr = $edit.$view.$delete;
			$ttugas_date = $this->lang->line('umb_start_date').': '.$psdate.'<br>'.$this->lang->line('umb_end_date').': '.$pedate;				
			$data[] = array(
				$combhr,
				$catnama_tugas.'<br>'.$this->lang->line('umb_project').': <a href="'.site_url().'admin/project/detail/'.$r->project_id.'">'.$nama_prj.'</a><br>'.$this->lang->line('umb_hours').': '.$r->jam_tugas,
				$ol.$add_users,
				$ttugas_date,
				$status,
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

	public function list_project_tugas() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
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
							$ol .= '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.base_url().'uploads/profile/'.$assigned_to[0]->profile_picture.'" class="user-image-hr ui-w-30 rounded-circle" alt=""></span></a>';
						} else {
							if($assigned_to[0]->jenis_kelamin=='Pria') { 
								$de_file = base_url().'uploads/profile/default_male.jpg';
							} else {
								$de_file = base_url().'uploads/profile/default_female.jpg';
							}
							$ol .= '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.$de_file.'" class="user-image-hr ui-w-30 rounded-circle" alt=""></span></a>';
						}
					}
				}
				$ol .= '';
			}
			$u_created = $this->Umb_model->read_user_info($r->created_by);
			$f_name = $u_created[0]->first_name.' '.$u_created[0]->last_name;
			$catnama_tugas = $r->nama_tugas;
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
			$progress_bar = '<p class="m-b-0-5">'.$this->lang->line('umb_completed').' <span class="pull-xs-right">'.$r->progress_tugas.'%</span></p><div class="progress" style="height: 7px;"><div class="progress-bar" style="width: '.$r->progress_tugas.'%;"></div></div>';
			if($r->status_tugas == 0) {
				$status = $this->lang->line('umb_not_started');
			} else if($r->status_tugas ==1){
				$status = $this->lang->line('umb_in_progress');
			} else if($r->status_tugas ==2){
				$status = $this->lang->line('umb_completed');
			} else if($r->status_tugas ==3){
				$status = $this->lang->line('umb_project_cancelled');
			} else {
				$status = $this->lang->line('umb_project_hold');
			}

			$tdate = $this->Umb_model->set_date_format($r->end_date);
			$data[] = array(
				'<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_view_details').'"><a href="'.site_url().'admin/timesheet/details_tugas/id/'.$r->tugas_id.'/"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span><span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light edit-data" data-toggle="modal" data-target=".edit-modal-data" data-tugas_id="'. $r->tugas_id.'" data-mname="hr"><span class="fas fa-pencil-alt"></span></button></span><span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete-tugas" data-toggle="modal" data-target=".delete-modal-tugas" data-record-id="'. $r->tugas_id . '"><span class="fas fa-trash-restore"></span></button></span>',
				$catnama_tugas,
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

	public function get_variasi_project() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');

		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$id = $this->uri->segment(4);		
		$tugas = $this->Timesheet_model->get_variasii_project($id);
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
							$ol .= '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.base_url().'uploads/profile/'.$assigned_to[0]->profile_picture.'" class="user-image-hr ui-w-30 rounded-circle" alt=""></span></a>';
						} else {
							if($assigned_to[0]->jenis_kelamin=='Pria') { 
								$de_file = base_url().'uploads/profile/default_male.jpg';
							} else {
								$de_file = base_url().'uploads/profile/default_female.jpg';
							}
							$ol .= '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.$de_file.'" class="user-image-hr ui-w-30 rounded-circle" alt=""></span></a>';
						}
					}
				}
				$ol .= '';
			}
			$u_created = $this->Umb_model->read_user_info($r->created_by);
			$f_name = $u_created[0]->first_name.' '.$u_created[0]->last_name;
			$tugas_cat = $this->Project_model->read_informasi_kategori_tugas($r->nama_variasi);
			if(!is_null($tugas_cat)){
				$catnama_tugas = $tugas_cat[0]->nama_kategori;
			} else {
				$catnama_tugas = '--';
			}											

			if($r->status_variasi == 0) {
				$status = '<span class="label label-warning">'.$this->lang->line('umb_not_started').'</span>';
			} else if($r->status_variasi ==1){
				$status = '<span class="label label-primary">'.$this->lang->line('umb_in_progress').'</span>';
			} else if($r->status_variasi ==2){
				$status = '<span class="label label-success">'.$this->lang->line('umb_completed').'</span>';
			} else if($r->status_variasi ==3){
				$status = '<span class="label label-danger">'.$this->lang->line('umb_project_cancelled').'</span>';
			} else {
				$status = '<span class="label label-danger">'.$this->lang->line('umb_project_hold').'</span>';
			}
			if($r->client_approval == 0) {
				$client_approval = $this->lang->line('umb_client_approval_unclaimed');
			} else {
				$client_approval = $this->lang->line('umb_client_approval_claimed');
			}
			$vsdate = $this->Umb_model->set_date_format($r->start_date);
			$vedate = $this->Umb_model->set_date_format($r->end_date);
			$tanggal_variasi = $this->lang->line('umb_start_date').': '.$vsdate.'<br>'.$this->lang->line('umb_end_date').': '.$vedate;			
			$data[] = array(
				'<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light edit-data" data-toggle="modal" data-target=".edit-modal-data-variasi" data-variasi_id="'. $r->variasi_id.'" data-mname="variation"><span class="fas fa-pencil-alt"></span></button></span><span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete-variasi" data-toggle="modal" data-target=".delete-modal-variasi" data-record-id="'. $r->variasi_id . '"><span class="fas fa-trash-restore"></span></button></span>',
				$catnama_tugas.'<br>'.$status,
				$r->no_variasii,
				$tanggal_variasi,
				$ol,
				$client_approval
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

	public function list_comments() {

		$data['title'] = $this->Umb_model->site_title();
		//$id = $this->input->get('ticket_id');
		$id = $this->uri->segment(4);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/timesheet/tugass/details_tugas", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$comments = $this->Timesheet_model->get_comments($id);
		$data = array();
		foreach($comments->result() as $r) {
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
				$u_file = '--';
			}
			$created_at = date('h:i A', strtotime($r->created_at));
			$_date = explode(' ',$r->created_at);
			$date = $this->Umb_model->set_date_format($_date[0]);
			$link = '<a class="c-user text-black" href="'.site_url().'admin/karyawans/detail/'.$r->user_id.'"><span class="underline">'.$nama_karyawan.' ('.$nama_penunjukan.')</span></a>';
			$dlink = '<div class="media-right">
			<div class="c-rating">
			<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('umb_delete').'">
			<a class="btn icon-btn btn-sm btn-outline-danger delete" href="#" data-toggle="modal" data-target=".delete-modal" data-record-id="'.$r->comment_id.'">
			<span class="fas fa-trash-restore m-r-0-5"></span></a></span>
			</div>
			</div>';

			$function = '<div class="c-item">
			<div class="media">
			<div class="media-left">
			<div class="avatar box-48">
			<img class="user-image-hr-prj ui-w-30 rounded-circle" src="'.$u_file.'">
			</div>
			</div>
			<div class="media-body">
			<div class="mb-0-5">
			'.$link.'
			<span class="font-90 text-muted">'.$date.' '.$created_at.'</span>
			</div>
			<div class="c-text">'.$r->comments_tugas.'</div>
			</div>
			'.$dlink.'
			</div>
			</div>';

			$data[] = array(
				$function
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $comments->num_rows(),
			"recordsFiltered" => $comments->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function set_comment() {

		if($this->input->post('add_type')=='set_comment') {		
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			if($this->input->post('umb_comment')==='') {
				$Return['error'] = $this->lang->line('umb_error_field_comment');
			} 
			$umb_comment = $this->input->post('umb_comment');
			$qt_umb_comment = htmlspecialchars(addslashes($umb_comment), ENT_QUOTES);

			if($Return['error']!=''){
				$this->output($Return);
			}
			$data = array(
				'comments_tugas' => $qt_umb_comment,
				'tugas_id' => $this->input->post('comment_tugas_id'),
				'user_id' => $this->input->post('user_id'),
				'created_at' => date('d-m-Y h:i:s')
			);
			$result = $this->Timesheet_model->add_comment($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_comment_tugas');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function delete_comment() {
		if($this->input->post('data') == 'comment_tugas') {

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Timesheet_model->delete_record_comment($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_sukses_comment_tugas_dihapus');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}

	public function add_attachment() {

		if($this->input->post('add_type')=='dfile_attachment') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			if($this->input->post('file_name')==='') {
				$Return['error'] = $this->lang->line('umb_error_file_tugas_name');
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
				$allowed =  array('png','jpg','jpeg','gif','pdf','doc','docx','xls','xlsx','txt');
				$filename = $_FILES['attachment_file']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				if(in_array($ext,$allowed)){
					$tmp_name = $_FILES["attachment_file"]["tmp_name"];
					$attachment_file = "uploads/tugas/";
					$name = basename($_FILES["attachment_file"]["name"]);
					$newfilename = 'tugas_'.round(microtime(true)).'.'.$ext;
					move_uploaded_file($tmp_name, $attachment_file.$newfilename);
					$fname = $newfilename;
				} else {
					$Return['error'] = $this->lang->line('umb_error_file_attachment_tugas');
				}
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$data = array(
				'tugas_id' => $this->input->post('c_tugas_id'),
				'upload_by' => $this->input->post('user_id'),
				'file_title' => $this->input->post('file_name'),
				'file_description' => $file_description,
				'attachment_file' => $fname,
				'created_at' => date('d-m-Y h:i:s')
			);
			$result = $this->Timesheet_model->add_new_attachment($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_tugas_att_ditambahkan');
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
		if(!empty($session)){ 
			$this->load->view("admin/timesheet/tugass/list_tugas", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$attachments = $this->Timesheet_model->get_attachments($id);
		if($attachments->num_rows() > 0) {
			$data = array();
			foreach($attachments->result() as $r) {
				$data[] = array('<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_download').'"><a href="'.site_url().'admin/download?type=tugas&filename='.$r->attachment_file.'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="oi oi-cloud-download"></span></button></a></span><span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete-file" data-toggle="modal" data-target=".delete-modal-file" data-record-id="'. $r->attachment_tugas_id . '"><span class="fas fa-trash-restore"></span></button></span>',
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
		} else {
			$data[] = array('','','','');


			$output = array(
				"draw" => $draw,
				"recordsTotal" => 0,
				"recordsFiltered" => 0,
				"data" => $data
			);
		}
		echo json_encode($output);
		exit();
	}

	public function delete_attachment() {

		if($this->input->post('data') == 'attachment_tugas') {

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Timesheet_model->delete_record_attachment($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_sukses_tugas_att_dihapus');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}

	public function list_kehadiran() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		$user_info = $this->Umb_model->read_user_info($session['user_id']);
		if(!empty($session)){ 
			$this->load->view("admin/timesheet/list_kehadiran", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$role_resources_ids = $this->Umb_model->user_role_resource();
		$tanggal_kehadiran = $this->input->get("tanggal_kehadiran");
		$ref_location_id = $this->input->get("location_id");
		if($user_info[0]->user_role_id==1){
			if($ref_location_id == 0) {
				$karyawan = $this->Karyawans_model->get_kehadiran_karyawans();
			} else {
				$karyawan = $this->Karyawans_model->get_kehadiran_location_karyawans($ref_location_id);
			}
		} else {
			if(in_array('397',$role_resources_ids)) {
				$karyawan = $this->Umb_model->get_perusahaan_karyawans($user_info[0]->perusahaan_id);
			} else {
				$karyawan = $this->Umb_model->read_info_khdrn_karyawan($session['user_id']);
			}
		}
		$system = $this->Umb_model->read_setting_info(1);
		$data = array();

		foreach($karyawan->result() as $r) {
			if($r->user_role_id!=1){ 			  		
				$full_name = $r->first_name.' '.$r->last_name;	
				$get_day = strtotime($tanggal_kehadiran);
				$day = date('l', $get_day);
				$perusahaan = $this->Umb_model->read_info_perusahaan($r->perusahaan_id);
				if(!is_null($perusahaan)){
					$prshn_nama = $perusahaan[0]->name;
				} else {
					$prshn_nama = '--';	
				}
				$d_date = $this->Umb_model->set_date_format($tanggal_kehadiran);
				$shift_kantor = $this->Timesheet_model->read_informasi_shift_kantor($r->shift_kantor_id);
				if(!is_null($shift_kantor)){
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
					$check = $this->Timesheet_model->check_kehadiran_pertama_masuk($r->user_id,$tanggal_kehadiran);		
					if($check->num_rows() > 0){
						$kehadiran = $this->Timesheet_model->kehadiran_pertama_masuk($r->user_id,$tanggal_kehadiran);
						$clock_in = new DateTime($kehadiran[0]->clock_in);
						$clock_in2 = $clock_in->format('h:i a');
						if($system[0]->is_ssl_available=='yes'){
							$clkInIp = $clock_in2.'<br><button type="button" class="btn btn-xs btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target="#modals-slide" data-ipaddress="'.$kehadiran[0]->clock_in_ip_address.'" data-uid="'.$r->user_id.'" data-att_type="clock_in" data-start_date="'.$tanggal_kehadiran.'"><i class="ft-map-pin"></i> '.$this->lang->line('umb_attend_clkin_ip').'</button>';
						} else {
							$clkInIp = $clock_in2;
						}
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
						$total_hrs = $this->Timesheet_model->total_kehadiran_jam_bekerja($r->user_id,$tanggal_kehadiran);
						$hrs_old_int1 = '';
						$Total = '';
						$Tistrahat = '';
						$total_time_rs = '';
						$hrs_old_int_res1 = '';
						foreach ($total_hrs->result() as $jam_kerja){		
							$timee = $jam_kerja->total_kerja.':00';
							$str_time =$timee;
							$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);
							sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
							$hrs_old_seconds = $hours * 3600 + $minutes * 60 + $seconds;
							$hrs_old_int1 = $hrs_old_seconds;
							$Total = gmdate("H:i", $hrs_old_int1);	
						}
						if($Total=='') {
							$total_kerja = '00:00';
						} else {
							$total_kerja = $Total;
						}

						$total_istirahat = $this->Timesheet_model->total_istirahat_kehadiran($r->user_id,$tanggal_kehadiran);
						foreach ($total_istirahat->result() as $istirahat){			
							$str_time_rs = $istirahat->total_istirahat.':00';
							$str_time_rs = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time_rs);
							sscanf($str_time_rs, "%d:%d:%d", $hours_rs, $minutes_rs, $seconds_rs);
							$hrs_old_seconds_rs = $hours_rs * 3600 + $minutes_rs * 60 + $seconds_rs;
							$hrs_old_int_res1 = $hrs_old_seconds_rs;
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
						$chck_tanggal_cuti = $this->Timesheet_model->chcek_tanggal_cuti($r->user_id,$tanggal_kehadiran);
						$cuti_arr = array();
						if($chck_tanggal_cuti->num_rows() == 1){
							$tanggal_cuti = $this->Timesheet_model->tanggal_cuti($r->user_id,$tanggal_kehadiran);
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
					
					$check_out = $this->Timesheet_model->check_kehadiran_pulang_pertama($r->user_id,$tanggal_kehadiran);		
					if($check_out->num_rows() == 1){
						$early_time =  new DateTime($out_time.' '.$tanggal_kehadiran);
						$first_out = $this->Timesheet_model->kehadiran_pulang_pertama($r->user_id,$tanggal_kehadiran);
						$clock_out = new DateTime($first_out[0]->clock_out);
						if ($first_out[0]->clock_out!='') {
							$clock_out2 = $clock_out->format('h:i a');
							if($system[0]->is_ssl_available=='yes'){
								$clkOutIp = $clock_out2.'<br><button type="button" class="btn btn-xs btn-secondary waves-effect waves-light" data-toggle="modal" data-target="#modals-slide" data-ipaddress="'.$kehadiran[0]->clock_out_ip_address.'" data-uid="'.$r->user_id.'" data-att_type="clock_out" data-start_date="'.$tanggal_kehadiran.'"><i class="ft-map-pin"></i> '.$this->lang->line('umb_attend_clkout_ip').'</button>';
							} else {
								$clkOutIp = $clock_out2;
							}
							
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
					if($user_info[0]->user_role_id==1){
						$fclckIn = $clkInIp;
						$fclckOut = $clkOutIp;
					} else {
						$fclckIn = $clock_in2;
						$fclckOut = $clock_out2;
					}
				} else {
					$d_date = $this->Umb_model->set_date_format($tanggal_kehadiran);
					$status = '<a href="javascript:void(0)" class="badge badge-danger">'.$this->lang->line('umb_shift_kantor_not_assigned').'</a>';
					$fclckIn = '--';
					$fclckOut = '--';
					$total_time_l = '--';
					$total_time_e = '--';
					$lembur2 = '--';
					$total_kerja = '--';
					$Tistrahat = '--';
				}
				$data[] = array(
					$full_name,
					$r->karyawan_id,
					$prshn_nama,
					$d_date,
					$status,
					$fclckIn,
					$fclckOut,
					$total_time_l,
					$total_time_e,
					$lembur2,
					$total_kerja,
					$Tistrahat
				);
			}
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
	
	public function get_karyawans() {

		$data['title'] = $this->Umb_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'perusahaan_id' => $id
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/timesheet/get_karyawans", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	} 
	
	public function get_cuti_karyawans() {

		$data['title'] = $this->Umb_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'perusahaan_id' => $id
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/timesheet/get_cuti_karyawans", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	} 
	
	public function get_karyawans_cuti() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		
		$type_cuti_id = $this->uri->segment(4);
		$karyawan_id = $this->uri->segment(5);
		
		$sisa_cuti = $this->Timesheet_model->count_total_cutii($type_cuti_id,$karyawan_id);
		$type = $this->Timesheet_model->read_informasi_type_cuti($type_cuti_id);
		if(!is_null($type)){
			$type_name = $type[0]->type_name;
			$total = $type[0]->days_per_year;
			$total_sisa_cuti = $total - $sisa_cuti;
		} else {
			$type_name = '--';	
			$total_sisa_cuti = 0;
		}
		ob_start();
		echo $total_sisa_cuti." ".$type_name. ' ' .$this->lang->line('umb_remaining');
		ob_end_flush();
	} 

	public function get_karyawan_tetapkan_types_cuti() {

		$data['title'] = $this->Umb_model->site_title();
		$karyawan_id = $this->uri->segment(4);
		
		$data = array(
			'karyawan_id' => $karyawan_id
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/timesheet/get_karyawan_tetapkan_types_cuti", $data);
		} else {
			redirect('admin/');
		}

		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}

	public function get_project_perusahaan() {

		$data['title'] = $this->Umb_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'perusahaan_id' => $id
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/timesheet/tugass/get_project_perusahaan", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}
	
	
	public function get_perusahaan_karyawans() {

		$data['title'] = $this->Umb_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'perusahaan_id' => $id
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/timesheet/tugass/get_karyawans", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}
	
	public function get_update_karyawans() {

		$data['title'] = $this->Umb_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'perusahaan_id' => $id
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/timesheet/get_update_karyawans", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
	}
	
	public function get_cal_karyawans() {

		$data['title'] = $this->Umb_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'perusahaan_id' => $id
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/timesheet/get_update_karyawans", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
	}
	
	public function get_timesheet_karyawans() {

		$data['title'] = $this->Umb_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'perusahaan_id' => $id
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/timesheet/get_timesheet_karyawans", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
	}

	public function list_tgl_bijaksana_kehadiran() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/timesheet/list_kehadiran", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$karyawan = $this->Umb_model->read_user_info_kehadiran();
		$data = array();
		foreach($karyawan->result() as $r) {
			$data[] = array('','','','','','','','','','','');
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

	public function list_tanggal_bijaksana() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		$user_info = $this->Umb_model->read_user_info($session['user_id']);
		if(!empty($session)){ 
			$this->load->view("admin/timesheet/tanggal_bijaksana", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$role_resources_ids = $this->Umb_model->user_role_resource(); 
		if(in_array('381',$role_resources_ids) && $user_info[0]->user_role_id!=1) {
			$karyawan_id = $this->input->get("user_id");
		} else if($user_info[0]->user_role_id!=1) {
			$karyawan_id = $session['user_id'];
		} else {
			$karyawan_id = $this->input->get("user_id");
		}
		$system = $this->Umb_model->read_setting_info(1);
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
				// get office shift for karyawan
			$get_day = strtotime($tanggal_kehadiran);
			$day = date('l', $get_day);
			$full_name = $karyawan[0]->first_name.' '.$karyawan[0]->last_name;
			$perusahaan = $this->Umb_model->read_info_perusahaan($karyawan[0]->perusahaan_id);
			if(!is_null($perusahaan)){
				$prshn_nama = $perusahaan[0]->name;
			} else {
				$prshn_nama = '--';	
			}
			$shift_kantor = $this->Timesheet_model->read_informasi_shift_kantor($karyawan[0]->shift_kantor_id);
			if(!is_null($shift_kantor)){
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
		// check if clock-in for date
				$status_kehadiran = '';
				$check = $this->Timesheet_model->check_kehadiran_pertama_masuk($karyawan[0]->user_id,$tanggal_kehadiran);		
				if($check->num_rows() > 0){
			// check clock in time
					$kehadiran = $this->Timesheet_model->kehadiran_pertama_masuk($karyawan[0]->user_id,$tanggal_kehadiran);
			// clock in
					$clock_in = new DateTime($kehadiran[0]->clock_in);
					$clock_in2 = $clock_in->format('h:i a');
					if($system[0]->is_ssl_available=='yes'){
						$clkInIp = $clock_in2.'<br><button type="button" class="btn btn-xs btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target="#modals-slide" data-ipaddress="'.$kehadiran[0]->clock_in_ip_address.'" data-uid="'.$karyawan[0]->user_id.'" data-att_type="clock_in" data-start_date="'.$tanggal_kehadiran.'"><i class="ft-map-pin"></i> '.$this->lang->line('umb_attend_clkin_ip').'</button>';
					} else {
						$clkInIp = $clock_in2;
					}		
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
						//$str_time_rs =$timee_rs;
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
						if($system[0]->is_ssl_available=='yes'){
							$clkOutIp = $clock_out2.'<br><button type="button" class="btn btn-xs btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target="#modals-slide" data-ipaddress="'.$kehadiran[0]->clock_out_ip_address.'" data-uid="'.$karyawan[0]->user_id.'" data-att_type="clock_out" data-start_date="'.$tanggal_kehadiran.'"><i class="ft-map-pin"></i> '.$this->lang->line('umb_attend_clkout_ip').'</button>';
						} else {
							$clkOutIp = $clock_out2;
						}			
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
				$tdate = $this->Umb_model->set_date_format($tanggal_kehadiran);
				/*if($user_info[0]->user_role_id==1){
					$fclckIn = $clkInIp;
					$fclckOut = $clkOutIp;
				} else {
					$fclckIn = $clock_in2;
					$fclckOut = $clock_out2;
				}*/
			} else {
				$tdate = $this->Umb_model->set_date_format($tanggal_kehadiran);
				$status = '<a href="javascript:void(0)" class="badge badge-danger">'.$this->lang->line('umb_shift_kantor_not_assigned').'</a>';

				$clkInIp = '--';
				$clkOutIp = '--';
				$total_time_l = '--';
				$total_time_e = '--';
				$lembur2 = '--';
				$total_kerja = '--';
				$Tistrahat = '--';
			}
			$data[] = array(
				$full_name,
				$karyawan[0]->karyawan_id,
				$prshn_nama,
				$status,
				$tdate,
				$clkInIp,
				$clkOutIp,
				$total_time_l,
				$total_time_e,
				$lembur2,
				$total_kerja,
				$Tistrahat
			);
			/*$data[] = array(
				$status,
				$tdate,
				$clock_in2,
				$clock_out2,
				$total_time_l,
				$total_time_e,
				$lembur2,
				$total_kerja,
				$Tistrahat
			);*/
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

	public function list_update_kehadiran() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		$tanggal_kehadiran = $this->input->get("tanggal_kehadiran");
		$karyawan_id = $this->input->get("karyawan_id");
		/*// get user info >
		$user = $this->Umb_model->read_user_info($karyawan_id);
		
		$full_name = $user[0]->first_name.' '.$user[0]->last_name;
		$penunjukan = $this->Penunjukan_model->read_informasi_penunjukan($user[0]->penunjukan_id);
		$department = $this->department_model->read_informasi_department($user[0]->department_id);
		$dept_des = $penunjukan[0]->nama_penunjukan.' in '.$department[0]->nama_department;
		$nama_karyawan = $full_name.' ('.$dept_des.')';
		$data = array(
			'nama_karyawan' => $nama_karyawan,
			//'karyawan_id' => $result[0]->karyawan_id,
		);*/
		if(!empty($session)){ 
			$this->load->view("admin/timesheet/update_kehadiran", $data);
		} else {
			redirect('admin/');
		}

		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$kehadiran_karyawan = $this->Timesheet_model->kehadiran_karyawan_dengan_tanggal($karyawan_id,$tanggal_kehadiran);
		$role_resources_ids = $this->Umb_model->user_role_resource();
		$data = array();
		foreach($kehadiran_karyawan->result() as $r) {

			$in_time = new DateTime($r->clock_in);
			$out_time = new DateTime($r->clock_out);

			$clock_in = $in_time->format('h:i a');			
			$hadir_tanggal_in = explode(' ',$r->clock_in);
			$hadir_tanggal_out = explode(' ',$r->clock_out);
			$cidate = $this->Umb_model->set_date_format($hadir_tanggal_in[0]);
			$cin_date = $cidate.' '.$clock_in;
			if($r->clock_out=='') {
				$cout_date = '-';
				$total_time = '-';
			} else {
				$clock_out = $out_time->format('h:i a');
				$interval = $in_time->diff($out_time);
				$hours  = $interval->format('%h');
				$minutes = $interval->format('%i');			
				$total_time = $hours ."h ".$minutes."m";
				$codate = $this->Umb_model->set_date_format($hadir_tanggal_out[0]);
				$cout_date = $codate.' '.$clock_out;
			}
			if(in_array('278',$role_resources_ids)) { 
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light edit-data" data-toggle="modal" data-target=".edit-modal-data" data-kehadiran_id="'.$r->waktu_kehadiran_id.'"><i class="fas fa-pencil-alt"></i></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('279',$role_resources_ids)) {
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'.$r->waktu_kehadiran_id.'"><i class="fas fa-trash-restore"></i></button></span>';
			} else {
				$delete = '';
			}

			$combhr = $edit.$delete;

			$data[] = array(
				$combhr,
				$cin_date,
				$cout_date,
				$total_time
			);
		}
		$output = array(
			"draw" => $draw,
			"recordsTotal" => $kehadiran_karyawan->num_rows(),
			"recordsFiltered" => $kehadiran_karyawan->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function list_shift_kantor() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/timesheet/shift_kantor", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$role_resources_ids = $this->Umb_model->user_role_resource();
		$user_info = $this->Umb_model->read_user_info($session['user_id']);
		if($user_info[0]->user_role_id==1){
			$shift_kantor = $this->Timesheet_model->get_shifts_kantor();
		} else {
			if(in_array('311',$role_resources_ids)) {
				$shift_kantor = $this->Timesheet_model->get_perusahaan_shifts($user_info[0]->perusahaan_id);
			} else {
				$shift_kantor = $this->Umb_model->get_karyawan_shift_kantor($user_info[0]->shift_kantor_id);
			}
		}
		$data = array();

		foreach($shift_kantor->result() as $r) {
			$senen_waktu_masuk = new DateTime($r->senen_waktu_masuk);
			$senen_waktu_pulang = new DateTime($r->senen_waktu_pulang);
			$selasa_waktu_masuk = new DateTime($r->selasa_waktu_masuk);
			$selasa_waktu_pulang = new DateTime($r->selasa_waktu_pulang);
			$rabu_waktu_masuk = new DateTime($r->rabu_waktu_masuk);
			$rabu_waktu_pulang = new DateTime($r->rabu_waktu_pulang);
			$kamis_waktu_masuk = new DateTime($r->kamis_waktu_masuk);
			$kamis_waktu_pulang = new DateTime($r->kamis_waktu_pulang);
			$jumat_waktu_masuk = new DateTime($r->jumat_waktu_masuk);
			$jumat_waktu_pulang = new DateTime($r->jumat_waktu_pulang);
			$sabtu_waktu_masuk = new DateTime($r->sabtu_waktu_masuk);
			$sabtu_waktu_pulang = new DateTime($r->sabtu_waktu_pulang);
			$minggu_waktu_masuk = new DateTime($r->minggu_waktu_masuk);
			$minggu_waktu_pulang = new DateTime($r->minggu_waktu_pulang);

			if($r->senen_waktu_masuk == '') {
				$monday = '-';
			} else {
				$monday = $senen_waktu_masuk->format('h:i a') .' ' .$this->lang->line('dashboard_to').' ' .$senen_waktu_pulang->format('h:i a');
			}
			if($r->selasa_waktu_masuk == '') {
				$tuesday = '-';
			} else {
				$tuesday = $selasa_waktu_masuk->format('h:i a') .' ' . $this->lang->line('dashboard_to').' '.$selasa_waktu_pulang->format('h:i a');
			}
			if($r->rabu_waktu_masuk == '') {
				$wednesday = '-';
			} else {
				$wednesday = $rabu_waktu_masuk->format('h:i a') .' ' . $this->lang->line('dashboard_to').' ' .$rabu_waktu_pulang->format('h:i a');
			}
			if($r->kamis_waktu_masuk == '') {
				$thursday = '-';
			} else {
				$thursday = $kamis_waktu_masuk->format('h:i a') .' ' . $this->lang->line('dashboard_to').' ' .$kamis_waktu_pulang->format('h:i a');
			}
			if($r->jumat_waktu_masuk == '') {
				$friday = '-';
			} else {
				$friday = $jumat_waktu_masuk->format('h:i a') .' ' . $this->lang->line('dashboard_to').' ' .$jumat_waktu_pulang->format('h:i a');
			}
			if($r->sabtu_waktu_masuk == '') {
				$saturday = '-';
			} else {
				$saturday = $sabtu_waktu_masuk->format('h:i a') .' ' . $this->lang->line('dashboard_to').' ' .$sabtu_waktu_pulang->format('h:i a');
			}
			if($r->minggu_waktu_masuk == '') {
				$sunday = '-';
			} else {
				$sunday = $minggu_waktu_masuk->format('h:i a') .' ' . $this->lang->line('dashboard_to').' ' .$minggu_waktu_pulang->format('h:i a');
			}

			$perusahaan = $this->Umb_model->read_info_perusahaan($r->perusahaan_id);
			if(!is_null($perusahaan)){
				$prshn_nama = $perusahaan[0]->name;
			} else {
				$prshn_nama = '--';	
			}
			if(in_array('281',$role_resources_ids)) { 
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light edit-data" data-toggle="modal" data-target=".edit-modal-data" data-shift_kantor_id="'. $r->shift_kantor_id.'" ><span class="fas fa-pencil-alt"></span></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('282',$role_resources_ids)) {
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->shift_kantor_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}
			$functions = '';
			if($r->default_shift=='' || $r->default_shift==0) {
				if(in_array('2822',$role_resources_ids)) {
					$functions = '<span data-toggle="tooltip" data-state="primary" data-placement="top" title="'.$this->lang->line('umb_make_default').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light default-shift" data-shift_kantor_id="'. $r->shift_kantor_id.'"><span class="ion ion-md-timer"></span></button></span>';
				} else {
					$functions = '';
				}
			} else {
				$functions = '';
			}
			$combhr = $edit.$functions.$delete;

			if($r->default_shift==1){
				$success = '<span class="badge badge-success">'.$this->lang->line('umb_default').'</span>';
			} else {
				$success = '';
			}
			$data[] = array(
				$combhr,
				$prshn_nama,
				$r->nama_shift . ' ' .$success,
				$monday,
				$tuesday,
				$wednesday,
				$thursday,
				$friday,
				$saturday,
				$sunday
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $shift_kantor->num_rows(),
			"recordsFiltered" => $shift_kantor->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function list_liburan() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/timesheet/liburan", $data);
		} else {
			redirect('admin/');
		}

		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		$role_resources_ids = $this->Umb_model->user_role_resource();
		$user_info = $this->Umb_model->read_user_info($session['user_id']);
		if($this->input->get("ihr")=='true'){
			if($this->input->get("perusahaan_id")==0 && $this->input->get("status")=='all'){
				$liburan = $this->Timesheet_model->get_liburan();
			} else if($this->input->get("perusahaan_id")!=0 && $this->input->get("status")=='all'){
				$liburan = $this->Timesheet_model->filter_perusahaan_liburan($this->input->get("perusahaan_id"));
			} else if($this->input->get("perusahaan_id")!=0 && $this->input->get("status")!='all'){
				$liburan = $this->Timesheet_model->filter_perusahaan_publish_liburan($this->input->get("perusahaan_id"),$this->input->get("status"));
			} else if($this->input->get("perusahaan_id")==0 && $this->input->get("status")!='all'){
				$liburan = $this->Timesheet_model->filter_perusahaan_tidak_publish_liburan($this->input->get("status"));
			}
		} else{
			if($user_info[0]->user_role_id==1){
				$liburan = $this->Timesheet_model->get_liburan();
			} else {
				$liburan = $this->Timesheet_model->get_perusahaan_liburan($user_info[0]->perusahaan_id);
			}
		}
		$data = array();

		foreach($liburan->result() as $r) {

			if($r->is_publish==1): $publish = '<span class="badge bg-green">'.$this->lang->line('umb_published').'</span>'; else: $publish = '<span class="badge bg-orange">'.$this->lang->line('umb_unpublished').'</span>'; endif;
			$sdate = $this->Umb_model->set_date_format($r->start_date);
			$edate = $this->Umb_model->set_date_format($r->end_date);
			$perusahaan = $this->Umb_model->read_info_perusahaan($r->perusahaan_id);
			if(!is_null($perusahaan)){
				$prshn_nama = $perusahaan[0]->name;
			} else {
				$prshn_nama = '--';	
			}
			if(in_array('284',$role_resources_ids)) {
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light edit-data" data-toggle="modal" data-target=".edit-modal-data" data-libur_id="'. $r->libur_id.'"><span class="fas fa-pencil-alt"></span></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('285',$role_resources_ids)) {
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->libur_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}
			if(in_array('286',$role_resources_ids)) {
				$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target="#modals-slide" data-libur_id="'. $r->libur_id . '"><span class="fa fa-eye"></span></button></span>';
			} else {
				$view = '';
			}
			$combhr = $edit.$view.$delete;
			$ievent_name = $r->event_name.'<br><small class="text-muted"><i>'.$prshn_nama.'<i></i></i></small><br><small class="text-muted"><i>'.$publish.'<i></i></i></small>';
			$data[] = array(
				$combhr,
				$ievent_name,
				$sdate,
				$edate
			);
		}
		$output = array(
			"draw" => $draw,
			"recordsTotal" => $liburan->num_rows(),
			"recordsFiltered" => $liburan->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}
	
	public function list_cuti() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/timesheet/cuti", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$data = array();
		$role_resources_ids = $this->Umb_model->user_role_resource();
		$user_info = $this->Umb_model->read_user_info($session['user_id']);
		if($this->input->get("ihr")=='true'){
			if($this->input->get("perusahaan_id")==0 && $this->input->get("karyawan_id")==0 && $this->input->get("status")==0){
				$cuti = $this->Timesheet_model->get_cutii();
			} else if($this->input->get("perusahaan_id")!=0 && $this->input->get("karyawan_id")==0 && $this->input->get("status")==0){
				$cuti = $this->Timesheet_model->filter_perusahaan_cutii($this->input->get("perusahaan_id"));
			} else if($this->input->get("perusahaan_id")!=0 && $this->input->get("karyawan_id")!=0 && $this->input->get("status")==0){
				$cuti = $this->Timesheet_model->filter_perusahaan_karyawans_cutii($this->input->get("perusahaan_id"),$this->input->get("karyawan_id"));
			} else if($this->input->get("perusahaan_id")!=0 && $this->input->get("karyawan_id")!=0 && $this->input->get("status")!=0){
				$cuti = $this->Timesheet_model->filter_perusahaan_karyawans_status_cutii($this->input->get("perusahaan_id"),$this->input->get("status"));
			} else if($this->input->get("perusahaan_id")!=0 && $this->input->get("karyawan_id")==0 && $this->input->get("status")!=0){
				$cuti = $this->Timesheet_model->filter_perusahaan_only_status_cutii($this->input->get("perusahaan_id"),$this->input->get("status"));
			}
		} else {
			$view_perusahaans_ids = explode(',',$user_info[0]->view_perusahaans_id);
			if($user_info[0]->user_role_id==1){
				$cuti = $this->Timesheet_model->get_cutii();
			} else {
				if(in_array('290',$role_resources_ids)) {
					$cuti = $this->Timesheet_model->get_perusahaan_cutii($user_info[0]->perusahaan_id);
				} else {
					$cuti = $this->Timesheet_model->get_karyawan_cutii($session['user_id']);
				}
			}
		}
		$laporans_to = get_data_laporans_team($session['user_id']);
		foreach($cuti->result() as $r) {
			
			$user = $this->Umb_model->read_user_info($r->karyawan_id);
			if(!is_null($user)){
				$full_name = $user[0]->first_name. ' '.$user[0]->last_name;
				$department = $this->Department_model->read_informasi_department($user[0]->department_id);
				if(!is_null($department)){
					$nama_department = $department[0]->nama_department;
				} else {
					$nama_department = '--';	
				}
			} else {
				$full_name = '--';	
				$nama_department = '--';
			}
			
			$type_cuti = $this->Timesheet_model->read_informasi_type_cuti($r->type_cuti_id);
			if(!is_null($type_cuti)){
				$type_name = $type_cuti[0]->type_name;
			} else {
				$type_name = '--';	
			}
			
			$perusahaan = $this->Umb_model->read_info_perusahaan($r->perusahaan_id);
			if(!is_null($perusahaan)){
				$prshn_nama = $perusahaan[0]->name;
			} else {
				$prshn_nama = '--';	
			}
			
			$datetime1 = new DateTime($r->from_date);
			$datetime2 = new DateTime($r->to_date);
			$interval = $datetime1->diff($datetime2);
			if(strtotime($r->from_date) == strtotime($r->to_date)){
				$no_of_days =1;
			} else {
				$no_of_days = $interval->format('%a') + 1;
			}
			$applied_on = $this->Umb_model->set_date_format($r->applied_on);
			/*$duration = $this->Umb_model->set_date_format($r->from_date).' '.$this->lang->line('dashboard_to').' '.$this->Umb_model->set_date_format($r->to_date).'<br>'.$this->lang->line('umb_hrastral_total_hari').': '.$no_of_days;*/
			if($r->is_half_day == 1){
				$duration = $this->Umb_model->set_date_format($r->from_date).' '.$this->lang->line('dashboard_to').' '.$this->Umb_model->set_date_format($r->to_date).'<br>'.$this->lang->line('umb_hrastral_total_hari').': '.$this->lang->line('umb_hr_cuti_setenga_hari');
			} else {
				$duration = $this->Umb_model->set_date_format($r->from_date).' '.$this->lang->line('dashboard_to').' '.$this->Umb_model->set_date_format($r->to_date).'<br>'.$this->lang->line('umb_hrastral_total_hari').': '.$no_of_days;
			}
			if($r->status==1): 
				$status = '<span class="badge bg-orange">'.$this->lang->line('umb_pending').'</span>';
			elseif($r->status==2): 
				$status = '<span class="badge bg-green">'.$this->lang->line('umb_approved').'</span>';
			elseif($r->status==4): 
				$status = '<span class="badge bg-green">'.$this->lang->line('umb_role_first_level_approved').'</span>';
			else: 
				$status = '<span class="badge bg-red">'.$this->lang->line('umb_rejected').'</span>'; 
			endif;
			if(in_array('288',$role_resources_ids)) {
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light edit-data" data-toggle="modal" data-target=".edit-modal-data" data-cuti_id="'. $r->cuti_id.'" ><span class="fas fa-pencil-alt"></span></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('289',$role_resources_ids)) {
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->cuti_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}
			if(in_array('290',$role_resources_ids) || $user_info[0]->user_role_id==1 || $laporans_to > 0) {
				$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_view_details').'"><a href="'.site_url().'admin/timesheet/details_cuti/id/'.$r->cuti_id.'/"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span>';
			} else {
				$view = '';
			}
			$combhr = $edit.$view.$delete;
			$itype_name = $type_name.'<br><small class="text-muted"><i>'.$this->lang->line('umb_alasan').': '.$r->reason.'<i></i></i></small><br><small class="text-muted"><i>'.$status.'<i></i></i></small><br><small class="text-muted"><i>'.$this->lang->line('left_perusahaan').': '.$prshn_nama.'<i></i></i></small>';
			
			$data[] = array(
				$combhr,
				$itype_name,
				$nama_department,
				$full_name,
				$duration,
				$applied_on
			);
		}
		$output = array(
			"draw" => $draw,
			// "recordsTotal" => $cuti->num_rows(),
			// "recordsFiltered" => $cuti->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function list_team_saya_cuti() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/timesheet/cuti", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$data = array();
		$role_resources_ids = $this->Umb_model->user_role_resource();
		$user_info = $this->Umb_model->read_user_info($session['user_id']);
		$cuti = $this->Timesheet_model->get_cutii();
		$laporans_to = get_data_laporans_team($session['user_id']);
		foreach($cuti->result() as $r) {
			$user = $this->Umb_model->read_user_info($r->karyawan_id);
			if($user[0]->laporans_to == $session['user_id']) {  
				$user = $this->Umb_model->read_user_info($r->karyawan_id);
				if(!is_null($user)){
					$full_name = $user[0]->first_name. ' '.$user[0]->last_name;
					$department = $this->Department_model->read_informasi_department($user[0]->department_id);
					if(!is_null($department)){
						$nama_department = $department[0]->nama_department;
					} else {
						$nama_department = '--';	
					}
				} else {
					$full_name = '--';	
					$nama_department = '--';
				}
				$type_cuti = $this->Timesheet_model->read_informasi_type_cuti($r->type_cuti_id);
				if(!is_null($type_cuti)){
					$type_name = $type_cuti[0]->type_name;
				} else {
					$type_name = '--';	
				}
				$perusahaan = $this->Umb_model->read_info_perusahaan($r->perusahaan_id);
				if(!is_null($perusahaan)){
					$prshn_nama = $perusahaan[0]->name;
				} else {
					$prshn_nama = '--';	
				}
				$datetime1 = new DateTime($r->from_date);
				$datetime2 = new DateTime($r->to_date);
				$interval = $datetime1->diff($datetime2);
				if(strtotime($r->from_date) == strtotime($r->to_date)){
					$no_of_days =1;
				} else {
					$no_of_days = $interval->format('%a') + 1;
				}
				$applied_on = $this->Umb_model->set_date_format($r->applied_on);
				/*$duration = $this->Umb_model->set_date_format($r->from_date).' '.$this->lang->line('dashboard_to').' '.$this->Umb_model->set_date_format($r->to_date).'<br>'.$this->lang->line('umb_hrastral_total_hari').': '.$no_of_days;*/
				if($r->is_half_day == 1){
					$duration = $this->Umb_model->set_date_format($r->from_date).' '.$this->lang->line('dashboard_to').' '.$this->Umb_model->set_date_format($r->to_date).'<br>'.$this->lang->line('umb_hrastral_total_hari').': '.$this->lang->line('umb_hr_cuti_setenga_hari');
				} else {
					$duration = $this->Umb_model->set_date_format($r->from_date).' '.$this->lang->line('dashboard_to').' '.$this->Umb_model->set_date_format($r->to_date).'<br>'.$this->lang->line('umb_hrastral_total_hari').': '.$no_of_days;
				}
				
				if($r->status==1): 
					$status = '<span class="badge bg-orange">'.$this->lang->line('umb_pending').'</span>';
				elseif($r->status==2): 
					$status = '<span class="badge bg-green">'.$this->lang->line('umb_approved').'</span>';
				elseif($r->status==4): 
					$status = '<span class="badge bg-green">'.$this->lang->line('umb_role_first_level_approved').'</span>';
				else: 
					$status = '<span class="badge bg-red">'.$this->lang->line('umb_rejected').'</span>'; 
				endif;
				if(in_array('288',$role_resources_ids)) {
					$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light edit-data" data-toggle="modal" data-target=".edit-modal-data" data-cuti_id="'. $r->cuti_id.'" ><span class="fas fa-pencil-alt"></span></button></span>';
				} else {
					$edit = '';
				}
				if(in_array('289',$role_resources_ids)) { 
					$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->cuti_id . '"><span class="fas fa-trash-restore"></span></button></span>';
				} else {
					$delete = '';
				}
				if(in_array('290',$role_resources_ids) || $laporans_to > 0) { 
					$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_view_details').'"><a href="'.site_url().'admin/timesheet/details_cuti/id/'.$r->cuti_id.'/"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span>';
				} else {
					$view = '';
				}
				$combhr = $edit.$view.$delete;
				$itype_name = $type_name.'<br><small class="text-muted"><i>'.$this->lang->line('umb_alasan').': '.$r->reason.'<i></i></i></small><br><small class="text-muted"><i>'.$status.'<i></i></i></small><br><small class="text-muted"><i>'.$this->lang->line('left_perusahaan').': '.$prshn_nama.'<i></i></i></small>';
				
				$data[] = array(
					$combhr,
					$itype_name,
					$nama_department,
					$full_name,
					$duration,
					$applied_on
				);
			}
		}
		$output = array(
			"draw" => $draw,
			// "recordsTotal" => $cuti->num_rows(),
			// "recordsFiltered" => $cuti->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}
	
	public function update_add_kehadiran() {
		$data['title'] = $this->Umb_model->site_title();
		$karyawan_id = $this->input->get('karyawan_id');
		$data = array(
			'karyawan_id' => $karyawan_id,
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/timesheet/dialog_kehadiran', $data);
		} else {
			redirect('admin/');
		}
	}
	
	
	public function add_tugas() {
		
		if($this->input->post('add_type')=='tugas') {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$start_date = $this->input->post('start_date');
			$end_date = $this->input->post('end_date');
			$description = $this->input->post('description');
			$st_date = strtotime($start_date);
			$ed_date = strtotime($end_date);
			$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
			if($this->input->post('perusahaan_id')==='') {
				$Return['error'] = $this->lang->line('error_field_perusahaan');
			} else if($this->input->post('nama_tugas')==='') {
				$Return['error'] = $this->lang->line('umb_error_nama_tugas');
			} else if($this->input->post('start_date')==='') {
				$Return['error'] = $this->lang->line('umb_error_start_date');
			} else if($this->input->post('end_date')==='') {
				$Return['error'] = $this->lang->line('umb_error_end_date');
			} else if($st_date > $ed_date) {
				$Return['error'] = $this->lang->line('umb_error_start_end_date');
			} else if($this->input->post('jam_tugas')==='') {
				$Return['error'] = $this->lang->line('umb_error_jam_tugas');
			} else if($this->input->post('project_id')==='') {
				$Return['error'] = $this->lang->line('umb_error_field_project');
			} else if($this->input->post('assigned_to')==='') {
				$Return['error'] = $this->lang->line('umb_error_tugas_assigned_user');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$assigned_ids = implode(',',$this->input->post('assigned_to'));
			$co_info  = $this->Project_model->read_informasi_project($this->input->post('project_id'));
			$data = array(
				'project_id' => $this->input->post('project_id'),
				'perusahaan_id' => $this->input->post('perusahaan_id'),
				'created_by' => $this->input->post('user_id'),
				'nama_tugas' => $this->input->post('nama_tugas'),
				'assigned_to' => $assigned_ids,
				'start_date' => $this->input->post('start_date'),
				'end_date' => $this->input->post('end_date'),
				'jam_tugas' => $this->input->post('jam_tugas'),
				'progress_tugas' => '0',
				'is_notify' => '1',
				'description' => $qt_description,
				'created_at' => date('Y-m-d h:i:s')
			);
			$result = $this->Timesheet_model->add_record_tugas($data);
			if ($result == TRUE) {
				$row = $this->db->select("*")->limit(1)->order_by('tugas_id',"DESC")->get("umb_tugass")->row();
				$Return['result'] = $this->lang->line('umb_sukses_tugas_ditambahkan');	
				$Return['re_last_id'] = $row->tugas_id;
				foreach($this->input->post('assigned_to') as $p_karyawan){
					$nticket_data = array(
						'module_name' => 'tugass',
						'module_id' => $row->tugas_id,
						'karyawan_id' => $p_karyawan,
						'is_notify' => '1',
						'created_at' => date('d-m-Y h:i:s'),
					);
					$this->Umb_model->add_notifications($nticket_data);
				}
				$setting = $this->Umb_model->read_setting_info(1);
				if($setting[0]->enable_email_notification == 'yes') {
					
					$this->email->set_mailtype("html");
					$to_email = array();
					foreach($this->input->post('assigned_to') as $p_karyawan) {
						
						$user_info = $this->Umb_model->read_user_info($this->input->post('user_id'));	
						$full_name = $user_info[0]->first_name.' '.$user_info[0]->last_name;		
						$user_to = $this->Umb_model->read_user_info($p_karyawan);	
						$cinfo = $this->Umb_model->read_info_setting_perusahaan(1);
						$template = $this->Umb_model->read_email_template(14);
						$subject = $template[0]->subject.' - '.$cinfo[0]->nama_perusahaan;
						$logo = base_url().'uploads/logo/signin/'.$cinfo[0]->sign_in_logo;
						$message = '
						<div style="background:#f6f6f6;font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;margin:0;padding:0;padding: 20px;">
						<img src="'.$logo.'" title="'.$cinfo[0]->nama_perusahaan.'"><br>'.str_replace(array("{var site_name}","{var site_url}","{var nama_tugas}","{var tugas_assigned_by}"),array($cinfo[0]->nama_perusahaan,site_url(),$this->input->post('nama_tugas'),$full_name),htmlspecialchars_decode(stripslashes($template[0]->message))).'</div>';
						
						hrastral_mail($cinfo[0]->email,$cinfo[0]->nama_perusahaan,$user_info[0]->email,$subject,$message);
					}
				}		
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function add_variasi_project() {
		
		if($this->input->post('add_type')=='variasi') {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$start_date = $this->input->post('start_date');
			$end_date = $this->input->post('end_date');
			$description = $this->input->post('description');
			$st_date = strtotime($start_date);
			$ed_date = strtotime($end_date);
			$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
			if($this->input->post('perusahaan_id')==='') {
				$Return['error'] = $this->lang->line('error_field_perusahaan');
			} else if($this->input->post('nama_variasi')==='') {
				$Return['error'] = $this->lang->line('umb_field_title_variasi_project_error');
			} else if($this->input->post('no_variasii')==='') {
				$Return['error'] = $this->lang->line('umb_field_variasi_project_error');
			} else if($this->input->post('start_date')==='') {
				$Return['error'] = $this->lang->line('umb_error_start_date');
			} else if($this->input->post('end_date')==='') {
				$Return['error'] = $this->lang->line('umb_error_end_date');
			} else if($st_date > $ed_date) {
				$Return['error'] = $this->lang->line('umb_error_start_end_date');
			} else if($this->input->post('jam_variasi')==='') {
				$Return['error'] = $this->lang->line('umb_field_hrs_variasi_project_error');
			} else if($this->input->post('project_id')==='') {
				$Return['error'] = $this->lang->line('umb_error_field_project');
			} else if($this->input->post('assigned_to')==='') {
				$Return['error'] = $this->lang->line('umb_error_tugas_assigned_user');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$assigned_ids = implode(',',$this->input->post('assigned_to'));
			$co_info  = $this->Project_model->read_informasi_project($this->input->post('project_id'));
			$data = array(
				'project_id' => $this->input->post('project_id'),
				'perusahaan_id' => $this->input->post('perusahaan_id'),
				'created_by' => $this->input->post('user_id'),
				'nama_variasi' => $this->input->post('nama_variasi'),
				'no_variasii' => $this->input->post('no_variasii'),
				'assigned_to' => $assigned_ids,
				'start_date' => $this->input->post('start_date'),
				'end_date' => $this->input->post('end_date'),
				'jam_variasi' => $this->input->post('jam_variasi'),
				'status_variasi' => $this->input->post('status'),
				'client_approval' => $this->input->post('client_approval'),
				'description' => $qt_description,
				'created_at' => date('Y-m-d h:i:s')
			);
			$result = $this->Timesheet_model->add_variasi_projects($data);
			
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_tugas_ditambahkan');	
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	
	public function add_cuti() {
		
		if($this->input->post('add_type')=='cuti') {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$start_date = $this->input->post('start_date');
			$end_date = $this->input->post('end_date');
			$remarks = $this->input->post('remarks');
			$st_date = strtotime($start_date);
			$ed_date = strtotime($end_date);
			$qt_remarks = htmlspecialchars(addslashes($remarks), ENT_QUOTES);
			if($this->input->post('type_cuti')==='') {
				$Return['error'] = $this->lang->line('umb_error_type_cuti_field');
			} else if($this->input->post('start_date')==='') {
				$Return['error'] = $this->lang->line('umb_error_start_date');
			} else if($this->input->post('end_date')==='') {
				$Return['error'] = $this->lang->line('umb_error_end_date');
			} else if($st_date > $ed_date) {
				$Return['error'] = $this->lang->line('umb_error_start_end_date');
			} else if($this->input->post('perusahaan_id')==='') {
				$Return['error'] = $this->lang->line('error_field_perusahaan');
			} else if($this->input->post('karyawan_id')==='') {
				$Return['error'] = $this->lang->line('umb_error_karyawan_id');
			} else if($this->input->post('reason')==='') {
				$Return['error'] = $this->lang->line('umb_error_type_cuti_reason');
			}
			$datetime1 = new DateTime($this->input->post('start_date'));
			$datetime2 = new DateTime($this->input->post('end_date'));
			$interval = $datetime1->diff($datetime2);
			$no_of_days = $interval->format('%a') + 1;
			if($this->input->post('cuti_setengah_hari')==1 && $no_of_days>1) {
				$Return['error'] = $this->lang->line('umb_hr_cant_appply_morethan').' 1 '.$this->lang->line('umb_day');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			
			if($this->input->post('start_date')!=''){	
			//$user_info_all = $this->Karyawans_model->read_informasi_karyawan($this->input->post('karyawan_id'));
				$esisa_cuti = 0;
			//$user_info_all[0]->cuti_days;
				$count_l = 0;
				$cal_cuti_setengahari = karyawan_cal_cuti_setengahari($this->input->post('type_cuti'),$this->input->post('karyawan_id'));
				foreach($cal_cuti_setengahari as $lhalfday):
					$count_l += 0.5;
				endforeach;
				$sisa_cuti = count_info_cutii($this->input->post('type_cuti'),$this->input->post('karyawan_id'));
				$sisa_cuti = $sisa_cuti - $count_l;
				$type = $this->Timesheet_model->read_informasi_type_cuti($this->input->post('type_cuti'));
				if(!is_null($type)){
					$type_name = $type[0]->type_name;
					$total = $type[0]->days_per_year;
					$total_sisa_cuti = $total - $sisa_cuti;
				} else {
					$type_name = '--';	
					$total_sisa_cuti = 0;
				}
				if($this->input->post('type_cuti')==3 || $this->input->post('type_cuti')==5 || $this->input->post('type_cuti')==7) {
					$total_sisa_cuti = $total_sisa_cuti + $esisa_cuti;
				} else {
					$total_sisa_cuti = $total_sisa_cuti;
				}
				if($this->input->post('cuti_setengah_hari')!=1){
					if($no_of_days > $total_sisa_cuti){
						$Return['error'] = $this->lang->line('umb_hr_cant_appply_morethan').' '.$this->lang->line('umb_day');
					}
				} else {
					if(0.5 > $total_sisa_cuti){
						$Return['error'] = $this->lang->line('umb_hr_cant_appply_morethan').' '.$total_sisa_cuti.' '.$this->lang->line('umb_hr_kontrak_days');
					}
				}
				if($total_sisa_cuti < 0.4){
					$Return['error'] = $this->lang->line('umb_cuti_limit_msg').' '.$this->lang->line('umb_hrastral_cuti_quota_completed') .$type_name;
				}
				/*$sisa_cuti = count_info_cutii($this->input->post('type_cuti'),$this->input->post('karyawan_id'));
				$type = $this->Timesheet_model->read_informasi_type_cuti($this->input->post('type_cuti'));
				if(!is_null($type)){
					$type_name = $type[0]->type_name;
					$total = $type[0]->days_per_year;
					$total_sisa_cuti = $total - $sisa_cuti;
				} else {
					$type_name = '--';	
					$total_sisa_cuti = 0;
				}
				if($total_sisa_cuti == 0){
					$Return['error'] = $this->lang->line('umb_cuti_limit_msg').' '.$this->lang->line('umb_hrastral_cuti_quota_completed') .$type_name;
				}*/
			}
			if($Return['error']!=''){
				$Return['csrf_hash'] = $this->security->get_csrf_hash();
				$this->output($Return);
			}	
			if($this->input->post('cuti_setengah_hari')!=1){
				$opt_cuti_setengah_hari = 0;
			} else {
				$opt_cuti_setengah_hari = $this->input->post('cuti_setengah_hari');
			}
			if(is_uploaded_file($_FILES['attachment']['tmp_name'])) {
				$allowed =  array('png','jpg','jpeg','pdf','gif');
				$filename = $_FILES['attachment']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				if(in_array($ext,$allowed)){
					$tmp_name = $_FILES["attachment"]["tmp_name"];
					$profile = "uploads/cuti/";
					$set_img = base_url()."uploads/cuti/";
					$name = basename($_FILES["attachment"]["name"]);
					$newfilename = 'cuti_'.round(microtime(true)).'.'.$ext;
					move_uploaded_file($tmp_name, $profile.$newfilename);
					$fname = $newfilename;			
				} else {
					$Return['error'] = $this->lang->line('umb_error_attatchment_type');
				}
			} else {
				$fname = '';
			}
			$data = array(
				'karyawan_id' => $this->input->post('karyawan_id'),
				'perusahaan_id' => $this->input->post('perusahaan_id'),
				'type_cuti_id' => $this->input->post('type_cuti'),
				'from_date' => $this->input->post('start_date'),
				'to_date' => $this->input->post('end_date'),
				'applied_on' => date('Y-m-d h:i:s'),
				'reason' => $this->input->post('reason'),
				'remarks' => $qt_remarks,
				'attachment_cuti' => $fname,
				'status' => '1',
				'is_notify' => '1',
				'is_half_day' => $opt_cuti_setengah_hari,
				'created_at' => date('Y-m-d h:i:s')
			);
			$result = $this->Timesheet_model->add_record_cuti($data);

			if ($result == TRUE) {
				$row = $this->db->select("*")->limit(1)->order_by('cuti_id',"DESC")->get("umb_applications_cuti")->row();
				$Return['result'] = $this->lang->line('umb_sukses_cuti_ditambahkan');
				$type_cuti = $this->Timesheet_model->read_informasi_type_cuti($row->type_cuti_id);
				if(!is_null($type_cuti)){
					$type_name = $type_cuti[0]->type_name;
				} else {
					$type_name = '--';	
				}
				$Return['re_last_id'] = $row->cuti_id;
				$Return['lv_type_name'] = $type_name;
				$nticket_data = array(
					'module_name' => 'leave',
					'module_id' => $row->cuti_id,
					'karyawan_id' => $this->input->post('karyawan_id'),
					'is_notify' => '1',
					'created_at' => date('d-m-Y h:i:s'),
				);
				$this->Umb_model->add_notifications($nticket_data);
				$setting = $this->Umb_model->read_setting_info(1);
				if($setting[0]->enable_email_notification == 'yes') {
					$this->email->set_mailtype("html");
					$cinfo = $this->Umb_model->read_info_setting_perusahaan(1);
					$template = $this->Umb_model->read_email_template(5);
					$user_info = $this->Umb_model->read_user_info($this->input->post('karyawan_id'));
					$full_name = $user_info[0]->first_name.' '.$user_info[0]->last_name;
					$laporans_to = $this->Umb_model->read_user_info($user_info[0]->laporans_to);
					$subject = $template[0]->subject.' - '.$cinfo[0]->nama_perusahaan;
					$logo = base_url().'uploads/logo/signin/'.$cinfo[0]->sign_in_logo;
					$message = '
					<div style="background:#f6f6f6;font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;margin:0;padding:0;padding: 20px;">
					<img src="'.$logo.'" title="'.$cinfo[0]->nama_perusahaan.'"><br>'.str_replace(array("{var site_name}","{var site_url}","{var nama_karyawan}"),array($cinfo[0]->nama_perusahaan,site_url(),$full_name),htmlspecialchars_decode(stripslashes($template[0]->message))).'</div>';
					if(!is_null($laporans_to)){
						hrastral_mail($user_info[0]->email,$full_name,$laporans_to[0]->email,$subject,$message);
					} else {
						hrastral_mail($user_info[0]->email,$full_name,$cinfo[0]->email,$subject,$message);
					}
				}
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}


	public function add_kehadiran() {

		if($this->input->post('add_type')=='kehadiran') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			if($this->input->post('prmtan_tanggal_kehadiran')==='') {
				$Return['error'] = $this->lang->line('umb_error_tanggal_kehadiran');
			} else if($this->input->post('clock_in_m')==='') {
				$Return['error'] = $this->lang->line('umb_error_kehadiran_in_time');
			} else if($this->input->post('clock_out_m')==='') {
				$Return['error'] = $this->lang->line('umb_error_kehadiran_out_time');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$tanggal_kehadiran = $this->input->post('prmtan_tanggal_kehadiran');
			$clock_in = $this->input->post('clock_in_m');
			$clock_out = $this->input->post('clock_out_m');
			$clock_in2 = $tanggal_kehadiran.' '.$clock_in.':00';
			$clock_out2 = $tanggal_kehadiran.' '.$clock_out.':00';
			$total_kerja_cin =  new DateTime($clock_in2);
			$total_kerja_cout =  new DateTime($clock_out2);
			$interval_cin = $total_kerja_cout->diff($total_kerja_cin);
			$hours_in   = $interval_cin->format('%h');
			$minutes_in = $interval_cin->format('%i');
			$total_kerja = $hours_in .":".$minutes_in;
			$data = array(
				'karyawan_id' => $this->input->post('karyawan_id_m'),
				'tanggal_kehadiran' => $tanggal_kehadiran,
				'clock_in' => $clock_in2,
				'clock_out' => $clock_out2,
				'time_late' => $clock_in2,
				'total_kerja' => $total_kerja,
				'early_leaving' => $clock_out2,
				'lembur' => $clock_out2,
				'status_kehadiran' => 'Present',
				'clock_in_out' => '0'
			);
			$result = $this->Timesheet_model->add_kehadiran_karyawan($data);

			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_kehadiran_ditambahkan');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function add_libur() {

		if($this->input->post('add_type')=='libur') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$start_date = $this->input->post('start_date');
			$end_date = $this->input->post('end_date');
			$description = $this->input->post('description');
			$st_date = strtotime($start_date);
			$ed_date = strtotime($end_date);
			$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
			if($this->input->post('perusahaan_id')==='') {
				$Return['error'] = $this->lang->line('error_field_perusahaan');
			} else if($this->input->post('event_name')==='') {
				$Return['error'] = $this->lang->line('umb_error_event_name');
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
				'event_name' => $this->input->post('event_name'),
				'perusahaan_id' => $this->input->post('perusahaan_id'),
				'description' => $qt_description,
				'start_date' => $this->input->post('start_date'),
				'end_date' => $this->input->post('end_date'),
				'is_publish' => $this->input->post('is_publish'),
				'created_at' => date('Y-m-d')
			);
			$result = $this->Timesheet_model->add_record_libur($data);
			if ($result == TRUE) {
				$row = $this->db->select("*")->limit(1)->order_by('libur_id',"DESC")->get("umb_liburan")->row();
				$Return['result'] = $this->lang->line('umb_libur_ditambahkan');
				$Return['re_last_id'] = $row->libur_id;	
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function edit_libur() {

		if($this->input->post('edit_type')=='libur') {
			$id = $this->uri->segment(4);		
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$start_date = $this->input->post('start_date');
			$end_date = $this->input->post('end_date');
			$description = $this->input->post('description');
			$st_date = strtotime($start_date);
			$ed_date = strtotime($end_date);
			$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
			if($this->input->post('perusahaan_id')==='') {
				$Return['error'] = $this->lang->line('error_field_perusahaan');
			} else if($this->input->post('event_name')==='') {
				$Return['error'] = $this->lang->line('umb_error_event_name');
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
				'event_name' => $this->input->post('event_name'),
				'perusahaan_id' => $this->input->post('perusahaan_id'),
				'description' => $qt_description,
				'start_date' => $this->input->post('start_date'),
				'end_date' => $this->input->post('end_date'),
				'is_publish' => $this->input->post('is_publish')
			);
			$result = $this->Timesheet_model->update_record_libur($data,$id);

			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_libur_diperbarui');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function edit_cuti() {

		if($this->input->post('edit_type')=='cuti') {

			$id = $this->uri->segment(4);		
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$remarks = $this->input->post('remarks');
			$qt_remarks = htmlspecialchars(addslashes($remarks), ENT_QUOTES);
			if($this->input->post('reason')==='') {
				$Return['error'] = $this->lang->line('umb_error_type_cuti_reason');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$data = array(
				'reason' => $this->input->post('reason'),
				'remarks' => $qt_remarks
			);
			$result = $this->Timesheet_model->update_record_cuti($data,$id);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_cuti_diperbarui');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function update_status_cuti() {

		if($this->input->post('update_type')=='cuti') {

			$id = $this->uri->segment(4);		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$remarks = $this->input->post('remarks');
			$qt_remarks = htmlspecialchars(addslashes($remarks), ENT_QUOTES);
			$data = array(
				'status' => $this->input->post('status'),
				'remarks' => $qt_remarks
			);
			$result = $this->Timesheet_model->update_record_cuti($data,$id);

			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_cuti__status_diperbarui');
				$setting = $this->Umb_model->read_setting_info(1);
				if($setting[0]->enable_email_notification == 'yes') {
					if($this->input->post('status') == 2){

						$this->email->set_mailtype("html");

						$timesheet = $this->Timesheet_model->read_informasi_cuti($id);
						$cinfo = $this->Umb_model->read_info_setting_perusahaan(1);
						$template = $this->Umb_model->read_email_template(6);
						$user_info = $this->Umb_model->read_user_info($timesheet[0]->karyawan_id);
						$full_name = $user_info[0]->first_name.' '.$user_info[0]->last_name;
						$from_date = $this->Umb_model->set_date_format($timesheet[0]->from_date);
						$to_date = $this->Umb_model->set_date_format($timesheet[0]->to_date);
						$subject = $template[0]->subject.' - '.$cinfo[0]->nama_perusahaan;
						$logo = base_url().'uploads/logo/signin/'.$cinfo[0]->sign_in_logo;
						$message = '
						<div style="background:#f6f6f6;font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;margin:0;padding:0;padding: 20px;">
						<img src="'.$logo.'" title="'.$cinfo[0]->nama_perusahaan.'"><br>'.str_replace(array("{var site_name}","{var site_url}","{var cuti_start_date}","{var cuti_end_date}"),array($cinfo[0]->nama_perusahaan,site_url(),$from_date,$to_date),htmlspecialchars_decode(stripslashes($template[0]->message))).'</div>';

						hrastral_mail($cinfo[0]->email,$cinfo[0]->nama_perusahaan,$user_info[0]->email,$subject,$message);
					} else if($this->input->post('status') == 3){

						$this->email->set_mailtype("html");
						$timesheet = $this->Timesheet_model->read_informasi_cuti($id);
						$cinfo = $this->Umb_model->read_info_setting_perusahaan(1);
						$template = $this->Umb_model->read_email_template(7);
						$user_info = $this->Umb_model->read_user_info($timesheet[0]->karyawan_id);
						$full_name = $user_info[0]->first_name.' '.$user_info[0]->last_name;
						$from_date = $this->Umb_model->set_date_format($timesheet[0]->from_date);
						$to_date = $this->Umb_model->set_date_format($timesheet[0]->to_date);
						$subject = $template[0]->subject.' - '.$cinfo[0]->nama_perusahaan;
						$logo = base_url().'uploads/logo/signin/'.$cinfo[0]->sign_in_logo;
						$message = '
						<div style="background:#f6f6f6;font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;margin:0;padding:0;padding: 20px;">
						<img src="'.$logo.'" title="'.$cinfo[0]->nama_perusahaan.'"><br>'.str_replace(array("{var site_name}","{var site_url}","{var cuti_start_date}","{var cuti_end_date}"),array($cinfo[0]->nama_perusahaan,site_url(),$from_date,$to_date),htmlspecialchars_decode(stripslashes($template[0]->message))).'</div>';
						hrastral_mail($cinfo[0]->email,$cinfo[0]->nama_perusahaan,$user_info[0]->email,$subject,$message);
					} 
				}
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function edit_tugas() {

		if($this->input->post('edit_type')=='tugas') {

			$id = $this->uri->segment(4);		
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$start_date = $this->input->post('start_date');
			$end_date = $this->input->post('end_date');
			$description = $this->input->post('description');
			$st_date = strtotime($start_date);
			$ed_date = strtotime($end_date);
			$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
			if($this->input->post('project_id')==='') {
				$Return['error'] = $this->lang->line('umb_error_field_project');
			} else if($this->input->post('nama_tugas')==='') {
				$Return['error'] = $this->lang->line('umb_error_nama_tugas');
			} else if($this->input->post('start_date')==='') {
				$Return['error'] = $this->lang->line('umb_error_start_date');
			} else if($this->input->post('end_date')==='') {
				$Return['error'] = $this->lang->line('umb_error_end_date');
			} else if($st_date > $ed_date) {
				$Return['error'] = $this->lang->line('umb_error_start_end_date');
			} else if($this->input->post('jam_tugas')==='') {
				$Return['error'] = $this->lang->line('umb_error_jam_tugas');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			if(null!=$this->input->post('assigned_to')) {
				$assigned_ids = implode(',',$this->input->post('assigned_to'));
			} else {
				$assigned_ids = 'None';
			}
			$data = array(
				'nama_tugas' => $this->input->post('nama_tugas'),
				'project_id' => $this->input->post('project_id'),
				'assigned_to' => $assigned_ids,
				'start_date' => $this->input->post('start_date'),
				'end_date' => $this->input->post('end_date'),
				'jam_tugas' => $this->input->post('jam_tugas'),
				'description' => $qt_description
			);
			$result = $this->Timesheet_model->update_record_tugas($data,$id);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_tugas_diperbarui');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function edit_variasi() {

		if($this->input->post('edit_type')=='variasi') {
			$id = $this->uri->segment(4);		
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$start_date = $this->input->post('start_date');
			$end_date = $this->input->post('end_date');
			$description = $this->input->post('description');
			$st_date = strtotime($start_date);
			$ed_date = strtotime($end_date);
			$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
			if($this->input->post('nama_variasi')==='') {
				$Return['error'] = $this->lang->line('umb_field_title_variasi_project_error');
			} else if($this->input->post('no_variasii')==='') {
				$Return['error'] = $this->lang->line('umb_field_variasi_project_error');
			} else if($this->input->post('start_date')==='') {
				$Return['error'] = $this->lang->line('umb_error_start_date');
			} else if($this->input->post('end_date')==='') {
				$Return['error'] = $this->lang->line('umb_error_end_date');
			} else if($st_date > $ed_date) {
				$Return['error'] = $this->lang->line('umb_error_start_end_date');
			} else if($this->input->post('jam_variasi')==='') {
				$Return['error'] = $this->lang->line('umb_field_hrs_variasi_project_error');
			} else if($this->input->post('assigned_to')==='') {
				$Return['error'] = $this->lang->line('umb_error_tugas_assigned_user');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			if(null!=$this->input->post('assigned_to')) {
				$assigned_ids = implode(',',$this->input->post('assigned_to'));
			} else {
				$assigned_ids = 'None';
			}
			$data = array(
				'nama_variasi' => $this->input->post('nama_variasi'),
				'no_variasii' => $this->input->post('no_variasii'),
				'assigned_to' => $assigned_ids,
				'start_date' => $this->input->post('start_date'),
				'end_date' => $this->input->post('end_date'),
				'jam_variasi' => $this->input->post('jam_variasi'),
				'status_variasi' => $this->input->post('status'),
				'client_approval' => $this->input->post('client_approval'),
				'description' => $qt_description
			);
			$result = $this->Timesheet_model->update_variasii_project($data,$id);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_variasi_project_ditambahkan_diperbarui');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function read_record_tugas() {

		$data['title'] = $this->Umb_model->site_title();
		$tugas_id = $this->input->get('tugas_id');
		$result = $this->Timesheet_model->read_informasi_tugas($tugas_id);
		$data = array(
			'tugas_id' => $result[0]->tugas_id,
			'project_id' => $result[0]->project_id,
			'perusahaan_id' => $result[0]->perusahaan_id,
			'projectid' => $result[0]->project_id,
			'created_by' => $result[0]->created_by,
			'nama_tugas' => $result[0]->nama_tugas,
			'assigned_to' => $result[0]->assigned_to,
			'start_date' => $result[0]->start_date,
			'end_date' => $result[0]->end_date,
			'jam_tugas' => $result[0]->jam_tugas,
			'status_tugas' => $result[0]->status_tugas,
			'progress_tugas' => $result[0]->progress_tugas,
			'description' => $result[0]->description,
			'created_at' => $result[0]->created_at,
			'all_karyawans' => $this->Umb_model->all_karyawans(),
			'all_projects' => $this->Project_model->get_all_projects()
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/timesheet/tugass/dialog_tugas', $data);
		} else {
			redirect('admin/');
		}
	}

	public function read_record_variasi() {

		$data['title'] = $this->Umb_model->site_title();
		$variasi_id = $this->input->get('variasi_id');
		$result = $this->Timesheet_model->read_informasi_variasi($variasi_id);
		$data = array(
			'variasi_id' => $result[0]->variasi_id,
			'project_id' => $result[0]->project_id,
			'perusahaan_id' => $result[0]->perusahaan_id,
			'client_approval' => $result[0]->client_approval,
			'created_by' => $result[0]->created_by,
			'nama_variasi' => $result[0]->nama_variasi,
			'assigned_to' => $result[0]->assigned_to,
			'start_date' => $result[0]->start_date,
			'end_date' => $result[0]->end_date,
			'jam_variasi' => $result[0]->jam_variasi,
			'status_variasi' => $result[0]->status_variasi,
			'no_variasii' => $result[0]->no_variasii,
			'description' => $result[0]->description,
			'created_at' => $result[0]->created_at,
			'all_karyawans' => $this->Umb_model->all_karyawans()
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/timesheet/tugass/dialog_tugas', $data);
		} else {
			redirect('admin/');
		}
	}

	public function read_record_cuti() {

		$data['title'] = $this->Umb_model->site_title();
		$cuti_id = $this->input->get('cuti_id');
		$result = $this->Timesheet_model->read_informasi_cuti($cuti_id);
		$data = array(
			'cuti_id' => $result[0]->cuti_id,
			'perusahaan_id' => $result[0]->perusahaan_id,
			'karyawan_id' => $result[0]->karyawan_id,
			'type_cuti_id' => $result[0]->type_cuti_id,
			'from_date' => $result[0]->from_date,
			'to_date' => $result[0]->to_date,
			'applied_on' => $result[0]->applied_on,
			'is_half_day' => $result[0]->is_half_day,
			'reason' => $result[0]->reason,
			'remarks' => $result[0]->remarks,
			'status' => $result[0]->status,
			'created_at' => $result[0]->created_at,
			'all_karyawans' => $this->Umb_model->all_karyawans(),
			'get_all_perusahaans' => $this->Umb_model->get_perusahaans(),
			'all_types_cuti' => $this->Timesheet_model->all_types_cuti(),
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/timesheet/dialog_cuti', $data);
		} else {
			redirect('admin/');
		}
	}

	public function read() {

		$data['title'] = $this->Umb_model->site_title();
		$kehadiran_id = $this->input->get('kehadiran_id');
		$result = $this->Timesheet_model->read_informasi_kehadiran($kehadiran_id);
		$user = $this->Umb_model->read_user_info($result[0]->karyawan_id);
		$full_name = $user[0]->first_name.' '.$user[0]->last_name;
		$in_time = new DateTime($result[0]->clock_in);
		$out_time = new DateTime($result[0]->clock_out);
		$clock_in = $in_time->format('H:i');
		if($result[0]->clock_out == '') {
			$clock_out = '';
		} else {
			$clock_out = $out_time->format('H:i');
		}
		$data = array(
			'waktu_kehadiran_id' => $result[0]->waktu_kehadiran_id,
			'karyawan_id' => $result[0]->karyawan_id,
			'full_name' => $full_name,
			'tanggal_kehadiran' => $result[0]->tanggal_kehadiran,
			'clock_in' => $clock_in,
			'clock_out' => $clock_out
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/timesheet/dialog_kehadiran', $data);
		} else {
			redirect('admin/');
		}
	}

	public function read_record_libur() {

		$data['title'] = $this->Umb_model->site_title();
		$libur_id = $this->input->get('libur_id');
		$result = $this->Timesheet_model->read_informasi_libur($libur_id);
		$data = array(
			'libur_id' => $result[0]->libur_id,
			'perusahaan_id' => $result[0]->perusahaan_id,
			'event_name' => $result[0]->event_name,
			'start_date' => $result[0]->start_date,
			'end_date' => $result[0]->end_date,
			'is_publish' => $result[0]->is_publish,
			'description' => $result[0]->description,
			'get_all_perusahaans' => $this->Umb_model->get_perusahaans()
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/timesheet/dialog_libur', $data);
		} else {
			redirect('admin/');
		}
	}

	public function read_record_shift() {

		$data['title'] = $this->Umb_model->site_title();
		$shift_kantor_id = $this->input->get('shift_kantor_id');
		$result = $this->Timesheet_model->read_informasi_shift_kantor($shift_kantor_id);
		$data = array(
			'shift_kantor_id' => $result[0]->shift_kantor_id,
			'perusahaan_id' => $result[0]->perusahaan_id,
			'nama_shift' => $result[0]->nama_shift,
			'senen_waktu_masuk' => $result[0]->senen_waktu_masuk,
			'senen_waktu_pulang' => $result[0]->senen_waktu_pulang,
			'selasa_waktu_masuk' => $result[0]->selasa_waktu_masuk,
			'selasa_waktu_pulang' => $result[0]->selasa_waktu_pulang,
			'rabu_waktu_masuk' => $result[0]->rabu_waktu_masuk,
			'rabu_waktu_pulang' => $result[0]->rabu_waktu_pulang,
			'kamis_waktu_masuk' => $result[0]->kamis_waktu_masuk,
			'kamis_waktu_pulang' => $result[0]->kamis_waktu_pulang,
			'jumat_waktu_masuk' => $result[0]->jumat_waktu_masuk,
			'jumat_waktu_pulang' => $result[0]->jumat_waktu_pulang,
			'sabtu_waktu_masuk' => $result[0]->sabtu_waktu_masuk,
			'sabtu_waktu_pulang' => $result[0]->sabtu_waktu_pulang,
			'minggu_waktu_masuk' => $result[0]->minggu_waktu_masuk,
			'get_all_perusahaans' => $this->Umb_model->get_perusahaans(),
			'minggu_waktu_pulang' => $result[0]->minggu_waktu_pulang
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/timesheet/dialog_shift_kantor', $data);
		} else {
			redirect('admin/');
		}
	}

	public function read_map_info() {
		$data['title'] = $this->Umb_model->site_title();
		$shift_kantor_id = $this->input->get('shift_kantor_id');
		$result = $this->Timesheet_model->read_informasi_shift_kantor($shift_kantor_id);
		$data = array(
			'shift_kantor_id' => $result[0]->shift_kantor_id,
			'perusahaan_id' => $result[0]->perusahaan_id
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/timesheet/dialog_read_map', $data);
		} else {
			redirect('admin/');
		}
	}

	public function edit_kehadiran() {

		if($this->input->post('edit_type')=='kehadiran') {
			$id = $this->uri->segment(4);
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			if($this->input->post('tanggal_kehadiran_e')==='') {
				$Return['error'] = $this->lang->line('umb_error_tanggal_kehadiran');
			} else if($this->input->post('clock_in')==='') {
				$Return['error'] = $this->lang->line('umb_error_kehadiran_in_time');
			} /*else if($this->input->post('clock_out')==='') {
				$Return['error'] = "The office Out Time field is required.";
			}*/
			if($Return['error']!=''){
				$this->output($Return);
			}
			$tanggal_kehadiran = $this->input->post('tanggal_kehadiran_e');
			$clock_in = $this->input->post('clock_in');
			$clock_in2 = $tanggal_kehadiran.' '.$clock_in.':00';
			$total_kerja_cin =  new DateTime($clock_in2);

			if($this->input->post('clock_out') ==='') {
				$data = array(
					'karyawan_id' => $this->input->post('emp_att'),
					'tanggal_kehadiran' => $tanggal_kehadiran,
					'clock_in' => $clock_in2,
					'time_late' => $clock_in2,
					'early_leaving' => $clock_in2,
					'lembur' => $clock_in2,
				);
			} else {
				$clock_out = $this->input->post('clock_out');
				$clock_out2 = $tanggal_kehadiran.' '.$clock_out.':00';
				$total_kerja_cout =  new DateTime($clock_out2);
				$interval_cin = $total_kerja_cout->diff($total_kerja_cin);
				$hours_in   = $interval_cin->format('%h');
				$minutes_in = $interval_cin->format('%i');
				$total_kerja = $hours_in .":".$minutes_in;
				$data = array(
					'karyawan_id' => $this->input->post('emp_att'),
					'tanggal_kehadiran' => $tanggal_kehadiran,
					'clock_in' => $clock_in2,
					'clock_out' => $clock_out2,
					'time_late' => $clock_in2,
					'total_kerja' => $total_kerja,
					'early_leaving' => $clock_out2,
					'lembur' => $clock_out2,
					'status_kehadiran' => 'Present',
					'clock_in_out' => '0'
				);
			}

			$result = $this->Timesheet_model->update_record_kehadiran($data,$id);		

			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_kehadiran_update');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function default_shift() {

		if($this->input->get('shift_kantor_id')) {
			$id = $this->input->get('shift_kantor_id');
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$data = array(
				'default_shift' => '0'
			);
			$data2 = array(
				'default_shift' => '1'
			);
			$result = $this->Timesheet_model->update_default_shift_zero($data);
			$result = $this->Timesheet_model->update_record_default_shift($data2,$id);		
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_shift_default_made');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function add_shift_kantor() {

		if($this->input->post('add_type')=='shift_kantor') {		
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			if($this->input->post('perusahaan_id')==='') {
				$Return['error'] = $this->lang->line('error_field_perusahaan');
			} else if($this->input->post('nama_shift')==='') {
				$Return['error'] = $this->lang->line('umb_error_nama_shift_field');
			} else if($this->input->post('senen_waktu_masuk')!='' && $this->input->post('senen_waktu_pulang')==='') {
				$Return['error'] = $this->lang->line('umb_error_shift_monday_timeout');
			} else if($this->input->post('selasa_waktu_masuk')!='' && $this->input->post('selasa_waktu_pulang')==='') {
				$Return['error'] = $this->lang->line('umb_error_shift_tuesday_timeout');
			} else if($this->input->post('rabu_waktu_masuk')!='' && $this->input->post('rabu_waktu_pulang')==='') {
				$Return['error'] = $this->lang->line('umb_error_shift_wednesday_timeout');
			} else if($this->input->post('kamis_waktu_masuk')!='' && $this->input->post('kamis_waktu_pulang')==='') {
				$Return['error'] = $this->lang->line('umb_error_shift_thursday_timeout');
			} else if($this->input->post('jumat_waktu_masuk')!='' && $this->input->post('jumat_waktu_pulang')==='') {
				$Return['error'] = $this->lang->line('umb_error_shift_friday_timeout');
			} else if($this->input->post('sabtu_waktu_masuk')!='' && $this->input->post('sabtu_waktu_pulang')==='') {
				$Return['error'] = $this->lang->line('umb_error_shift_saturday_timeout');
			} else if($this->input->post('minggu_waktu_masuk')!='' && $this->input->post('minggu_waktu_pulang')==='') {
				$Return['error'] = $this->lang->line('umb_error_shift_sunday_timeout');
			} 
			if($Return['error']!=''){
				$this->output($Return);
			}
			$data = array(
				'nama_shift' => $this->input->post('nama_shift'),
				'perusahaan_id' => $this->input->post('perusahaan_id'),
				'senen_waktu_masuk' => $this->input->post('senen_waktu_masuk'),
				'senen_waktu_pulang' => $this->input->post('senen_waktu_pulang'),
				'selasa_waktu_masuk' => $this->input->post('selasa_waktu_masuk'),
				'selasa_waktu_pulang' => $this->input->post('selasa_waktu_pulang'),
				'rabu_waktu_masuk' => $this->input->post('rabu_waktu_masuk'),
				'rabu_waktu_pulang' => $this->input->post('rabu_waktu_pulang'),
				'kamis_waktu_masuk' => $this->input->post('kamis_waktu_masuk'),
				'kamis_waktu_pulang' => $this->input->post('kamis_waktu_pulang'),
				'jumat_waktu_masuk' => $this->input->post('jumat_waktu_masuk'),
				'jumat_waktu_pulang' => $this->input->post('jumat_waktu_pulang'),
				'sabtu_waktu_masuk' => $this->input->post('sabtu_waktu_masuk'),
				'sabtu_waktu_pulang' => $this->input->post('sabtu_waktu_pulang'),
				'minggu_waktu_masuk' => $this->input->post('minggu_waktu_masuk'),
				'minggu_waktu_pulang' => $this->input->post('minggu_waktu_pulang'),
				'created_at' => date('Y-m-d')
			);
			$result = $this->Timesheet_model->add_record_shift_kantor($data);

			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_shift_ditambahkan');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function edit_shift_kantor() {

		if($this->input->post('edit_type')=='shift') {

			$id = $this->uri->segment(4);
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			if($this->input->post('perusahaan_id')==='') {
				$Return['error'] = $this->lang->line('error_field_perusahaan');
			} else if($this->input->post('nama_shift')==='') {
				$Return['error'] = $this->lang->line('umb_error_nama_shift_field');
			} else if($this->input->post('senen_waktu_masuk')!='' && $this->input->post('senen_waktu_pulang')==='') {
				$Return['error'] = $this->lang->line('umb_error_shift_monday_timeout');
			} else if($this->input->post('selasa_waktu_masuk')!='' && $this->input->post('selasa_waktu_pulang')==='') {
				$Return['error'] = $this->lang->line('umb_error_shift_tuesday_timeout');
			} else if($this->input->post('rabu_waktu_masuk')!='' && $this->input->post('rabu_waktu_pulang')==='') {
				$Return['error'] = $this->lang->line('umb_error_shift_wednesday_timeout');
			} else if($this->input->post('kamis_waktu_masuk')!='' && $this->input->post('kamis_waktu_pulang')==='') {
				$Return['error'] = $this->lang->line('umb_error_shift_thursday_timeout');
			} else if($this->input->post('jumat_waktu_masuk')!='' && $this->input->post('jumat_waktu_pulang')==='') {
				$Return['error'] = $this->lang->line('umb_error_shift_friday_timeout');
			} else if($this->input->post('sabtu_waktu_masuk')!='' && $this->input->post('sabtu_waktu_pulang')==='') {
				$Return['error'] = $this->lang->line('umb_error_shift_saturday_timeout');
			} else if($this->input->post('minggu_waktu_masuk')!='' && $this->input->post('minggu_waktu_pulang')==='') {
				$Return['error'] = $this->lang->line('umb_error_shift_sunday_timeout');
			} 

			if($Return['error']!=''){
				$this->output($Return);
			}
			$data = array(
				'nama_shift' => $this->input->post('nama_shift'),
				'perusahaan_id' => $this->input->post('perusahaan_id'),
				'senen_waktu_masuk' => $this->input->post('senen_waktu_masuk'),
				'senen_waktu_pulang' => $this->input->post('senen_waktu_pulang'),
				'selasa_waktu_masuk' => $this->input->post('selasa_waktu_masuk'),
				'selasa_waktu_pulang' => $this->input->post('selasa_waktu_pulang'),
				'rabu_waktu_masuk' => $this->input->post('rabu_waktu_masuk'),
				'rabu_waktu_pulang' => $this->input->post('rabu_waktu_pulang'),
				'kamis_waktu_masuk' => $this->input->post('kamis_waktu_masuk'),
				'kamis_waktu_pulang' => $this->input->post('kamis_waktu_pulang'),
				'jumat_waktu_masuk' => $this->input->post('jumat_waktu_masuk'),
				'jumat_waktu_pulang' => $this->input->post('jumat_waktu_pulang'),
				'sabtu_waktu_masuk' => $this->input->post('sabtu_waktu_masuk'),
				'sabtu_waktu_pulang' => $this->input->post('sabtu_waktu_pulang'),
				'minggu_waktu_masuk' => $this->input->post('minggu_waktu_masuk'),
				'minggu_waktu_pulang' => $this->input->post('minggu_waktu_pulang')
			);
			$result = $this->Timesheet_model->update_record_shift($data,$id);		

			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_shift_diperbarui');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function delete_kehadiran() {

		if($this->input->post('type')=='delete') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Timesheet_model->delete_record_kehadiran($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_sukses_karyawn_kehadiran_dihapus');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}

	public function delete_libur() {

		if($this->input->post('type')=='delete') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Timesheet_model->delete_record_libur($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_sukses_libur_dihapus');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}

	public function delete_shift() {

		if($this->input->post('type')=='delete') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Timesheet_model->delete_record_shift($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_sukses_shift_dihapus');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}

	public function delete_cuti() {

		if($this->input->post('type')=='delete') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Timesheet_model->delete_record_cuti($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_sukses_cuti_dihapus');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}

	public function delete_tugas() {

		if($this->input->post('type')=='delete') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Timesheet_model->delete_record_tugas($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_sukses_tugas_dihapus');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}
	public function delete_variasi() {

		if($this->input->post('type')=='delete') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Timesheet_model->delete_record_variasi($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_variasi_project__ditambahkan_dihapus');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}

	public function add_note() {

		if($this->input->post('type')=='add_note') {		
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();	
			$data = array(
				'tugas_note' => $this->input->post('tugas_note')
			);
			$id = $this->input->post('note_tugas_id');
			$result = $this->Timesheet_model->update_record_tugas($data,$id);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_tugas_note_diperbarui');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function timesheet_bulanan_karyawans() {

		$umb_karyawans = $this->Umb_model->all_karyawans();
		foreach($umb_karyawans as $hr_user) { 

			$full_name = $hr_user->first_name.' '.$hr_user->last_name;	
			$penunjukan = $this->Penunjukan_model->read_informasi_penunjukan($hr_user->penunjukan_id);
			if(!is_null($penunjukan)){
				$nama_penunjukan = $penunjukan[0]->nama_penunjukan;
			} else {
				$nama_penunjukan = '--';	
			}
			$department = $this->Department_model->read_informasi_department($hr_user->department_id);
			if(!is_null($department)){
				$nama_department = $department[0]->nama_department;
			} else {
				$nama_department = '--';
			}
			$user_info = $full_name.' ('.$nama_penunjukan.')';
			$someArray[] = array(
				'id' => $hr_user->user_id,
				'title'   => $user_info,
				'karyawan_present' => $hr_user->user_id
			);
		}
		$this->output($someArray);
		exit;
	}

	public function timesheet_bulanan_resources(){

		$someArray = array();
		$umb_karyawans = $this->Umb_model->all_karyawans();
		/*$date = strtotime(date("Y-m-d"));
		$day = date('d', $date);
		$month = date('m', $date);
		$year = date('Y', $date);
		$month_year = date('Y-m');*/
		$month_year = $this->input->post('month_year');
		if(isset($month_year)){
			$date = strtotime($this->input->post('month_year').'-01');
			$imonth_year = explode('-',$this->input->post('month_year'));
			$day = date('d', $date);
			$month = date($imonth_year[1], $date);
			$year = date($imonth_year[0], $date);
			$month_year = $this->input->get('month_year');
		} else {
			$date = strtotime(date("Y-m-d"));
			//$date = strtotime('2020-05-01');
			$day = date('d', $date);
			$month = date('m', $date);
			$year = date('Y', $date);
			$month_year = date('Y-m');
		}
		$daysInMonth =  date('t');
		$imonth = date('F', $date);
		$j=0;foreach($umb_karyawans as $r) { 
			$full_name = $r->first_name.' '.$r->last_name;
			/*$penunjukan = $this->Penunjukan_model->read_informasi_penunjukan($r->penunjukan_id);
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
			}*/
			//$department_penunjukan = $nama_penunjukan.' ('.$nama_department.')';$pcount=0;
			for($i = 1; $i <= $daysInMonth; $i++):
				$i = str_pad($i, 2, 0, STR_PAD_LEFT);
				$tanggal_kehadiran = $year.'-'.$month.'-'.$i;
				$tdate = $year.'-'.$month.'-'.$i;
				$get_day = strtotime($tanggal_kehadiran);
				$day = date('l', $get_day);
				$user_id = $r->user_id;
				$shift_kantor = $this->Timesheet_model->read_informasi_shift_kantor($r->shift_kantor_id);
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
				//echo '<pre>'; print_r($libur_arr);
				$chck_tanggal_cuti = $this->Timesheet_model->chcek_tanggal_cuti($r->user_id,$tanggal_kehadiran);
				$cuti_arr = array();
				if($chck_tanggal_cuti->num_rows() == 1){
					$tanggal_cuti = $this->Timesheet_model->tanggal_cuti($r->user_id,$tanggal_kehadiran);
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
				$status_kehadiran = '';
				$check = $this->Timesheet_model->check_kehadiran_pertama_masuk($r->user_id,$tanggal_kehadiran);
				if($shift_kantor[0]->senen_waktu_masuk == '' && $day == 'Monday') {
					$status = 'H';	
				} else if($shift_kantor[0]->selasa_waktu_masuk == '' && $day == 'Tuesday') {
					$status = 'H';
				} else if($shift_kantor[0]->rabu_waktu_masuk == '' && $day == 'Wednesday') {
					$status = 'H';
				} else if($shift_kantor[0]->kamis_waktu_masuk == '' && $day == 'Thursday') {
					$status = 'H';
				} else if($shift_kantor[0]->jumat_waktu_masuk == '' && $day == 'Friday') {
					$status = 'H';
				} else if($shift_kantor[0]->sabtu_waktu_masuk == '' && $day == 'Saturday') {
					$status = 'H';
				} else if($shift_kantor[0]->minggu_waktu_masuk == '' && $day == 'Sunday') {
					$status = 'H';
				} else if(in_array($tanggal_kehadiran,$libur_arr)) {
					$status = 'H';
				} else if(in_array($tanggal_kehadiran,$cuti_arr)) {
					$status = 'L';
				} else if($check->num_rows() > 0){
					$kehadiran = $this->Timesheet_model->kehadiran_pertama_masuk($r->user_id,$tanggal_kehadiran);
					$status = 'P';					
				} else {
					$status = 'A';
				//$pcount += 0;
				}
				//$pcount += $check->num_rows();
				$itanggal_kehadiran = strtotime($tanggal_kehadiran);
				//$icurrent_date = strtotime(date('Y-m-d'));
				$status = $status;
				/*if($itanggal_kehadiran <= $icurrent_date){
					$status = $status;
				} else {
					$status = '1';
				}*/
				$itanggal_bergabung = strtotime($r->tanggal_bergabung);
				if($itanggal_bergabung < $itanggal_kehadiran){
					$status = $status;
				} else {
					$status = '';
				}
				$someArray[] = array(
					'title' => $status,
					'resourceIds' => $r->user_id,
					'start'   => $tanggal_kehadiran,
				//  'end'   => $tanggal_kehadiran,
				);
			endfor;	
		}
		$this->output($someArray);
		exit;
	}

	public function set_clocking() {

		if($this->input->post('type')=='set_clocking') {
			$system = $this->Umb_model->read_setting_info(1);
			//if($system[0]->system_ip_restriction == 'yes'){
			$sys_arr = explode(',',$system[0]->system_ip_address);
			//if(in_array($this->input->ip_address(),$sys_arr)) { 
			//if($system[0]->system_ip_address == $this->input->ip_address()){	
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();	
			$session = $this->session->userdata('username');
			$karyawan_id = $session['user_id'];
			$clock_state = $this->input->post('clock_state');
			$latitude = $this->input->post('latitude');
			$longitude = $this->input->post('longitude');
			$time_id = $this->input->post('time_id');
			// set time
			$nowtime = date("Y-m-d H:i:s");
			//$date = date('Y-m-d H:i:s', strtotime($nowtime . ' + 4 hours'));
			$date = date('Y-m-d H:i:s');
			$curtime = $date;
			$today_date = date('Y-m-d');	
			if($clock_state=='clock_in') {
				$query = $this->Timesheet_model->check_user_kehadiran();
				$result = $query->result();
				if($query->num_rows() < 1) {
					$total_istirahat = '';
				} else {
					$cout =  new DateTime($result[0]->clock_out);
					$cin =  new DateTime($curtime);

					$interval_cin = $cin->diff($cout);
					$hours_in   = $interval_cin->format('%h');
					$minutes_in = $interval_cin->format('%i');
					$total_istirahat = $hours_in .":".$minutes_in;
				}
				$data = array(
					'karyawan_id' => $karyawan_id,
					'tanggal_kehadiran' => $today_date,
					'clock_in' => $curtime,
					'clock_in_ip_address' => $this->input->ip_address(),
					'clock_in_latitude' => $latitude,
					'clock_in_longitude' => $longitude,
					'time_late' => $curtime,
					'early_leaving' => $curtime,
					'lembur' => $curtime,
					'total_istirahat' => $total_istirahat,
					'status_kehadiran' => 'Present',
					'clock_in_out' => '1'
				);

				$result = $this->Timesheet_model->add_new_kehadiran($data);
				if ($result == TRUE) {
					$Return['result'] = $this->lang->line('umb_sukses_clocked_in');
				} else {
					$Return['error'] = $this->lang->line('umb_error_msg');
				}
			} else if($clock_state=='clock_out') {
				$query = $this->Timesheet_model->check_user_kehadiran_clockout();
				$clocked_out = $query->result();
				$total_kerja_cin =  new DateTime($clocked_out[0]->clock_in);
				$total_kerja_cout =  new DateTime($curtime);
				$interval_cin = $total_kerja_cout->diff($total_kerja_cin);
				$hours_in   = $interval_cin->format('%h');
				$minutes_in = $interval_cin->format('%i');
				$total_kerja = $hours_in .":".$minutes_in;
				$data = array(
					'karyawan_id' => $karyawan_id,
					'clock_out' => $curtime,
					'clock_out_ip_address' => $this->input->ip_address(),
					'clock_out_latitude' => $latitude,
					'clock_out_longitude' => $longitude,
					'clock_in_out' => '0',
					'early_leaving' => $curtime,
					'lembur' => $curtime,
					'total_kerja' => $total_kerja
				);
				$id = $this->input->post('time_id');
				$resuslt2 = $this->Timesheet_model->update_kehadiran_clockedout($data,$id);
				if ($resuslt2 == TRUE) {
					$Return['result'] = $this->lang->line('umb_sukses_clocked_out');
					$Return['time_id'] = '';
				} else {
					$Return['error'] = $this->lang->line('umb_error_msg');
				}
			}
			$this->output($Return);
			exit;
		}
	}
}
