<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Events extends MY_Controller {

	public function output($Return=array()){
		
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		exit(json_encode($Return));
	}
	
	public function __construct() {
		parent::__construct();

		$this->load->model('Perusahaan_model');
		$this->load->model('Umb_model');
		$this->load->model('Events_model');
		$this->load->model('Meetings_model');
		$this->load->model('Department_model');
	}

	public function index() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$system = $this->Umb_model->read_setting_info(1);
		if($system[0]->module_events!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('umb_hr_events').' | '.$this->Umb_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('umb_hr_events');
		$data['path_url'] = 'events';
		$data['get_all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('98',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/events/list_events", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
		} else {
			redirect('admin/dashboard');
		}
	}
	
	public function calendar() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$system = $this->Umb_model->read_setting_info(1);
		/*if($system[0]->module_events!='true'){
			redirect('admin/dashboard');
		}*/
		$data['title'] = $this->lang->line('umb_hrastral_calendar_events');
		$data['breadcrumbs'] = $this->lang->line('umb_hrastral_calendar_events');
		$data['all_events'] = $this->Events_model->get_events();
		$data['all_meetings'] = $this->Meetings_model->get_meetings();
		$data['get_all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$data['path_url'] = 'calendar_event';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('98',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/events/calendar_events", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
		} else {
			redirect('admin/dashboard');
		}
	}
	
	
	public function get_karyawans() {

		$data['title'] = $this->Umb_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'perusahaan_id' => $id
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/events/get_karyawans", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}
	
	public function list_events() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/events/list_events", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		
		$role_resources_ids = $this->Umb_model->user_role_resource();
		$user_info = $this->Umb_model->read_user_info($session['user_id']);
		if($user_info[0]->user_role_id==1){
			$events = $this->Events_model->get_events();
		} else {
			if(in_array('272',$role_resources_ids)) {
				$events = $this->Events_model->get_events_perusahaan($user_info[0]->perusahaan_id);
			} else {
				$events = $this->Events_model->get_events_karyawan($session['user_id']);
			}
		}
		$data = array();

		foreach($events->result() as $r) {

			$sdate = $this->Umb_model->set_date_format($r->event_date);

			$event_time = new DateTime($r->event_time);

			$perusahaan = $this->Umb_model->read_info_perusahaan($r->perusahaan_id);
			if(!is_null($perusahaan)){
				$prshn_nama = $perusahaan[0]->name;
			} else {
				$prshn_nama = '--';	
			}
			
			if($r->karyawan_id == '') {
				$ol = $this->lang->line('umb_not_assigned');
			} else {
				$ol = '';
				foreach(explode(',',$r->karyawan_id) as $tunjuk_id) {
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
			$full_name = $ol;
			if(in_array('270',$role_resources_ids)) {
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light edit-data" data-toggle="modal" data-target=".edit-modal-data" data-event_id="'. $r->event_id.'"><span class="fas fa-pencil-alt"></span></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('271',$role_resources_ids)) { 
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->event_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}
			if(in_array('272',$role_resources_ids)) {
				$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target="#modals-slide" data-event_id="'. $r->event_id . '"><span class="fa fa-eye"></span></button></span>';
			} else {
				$view = '';
			}
			$combhr = $edit.$view.$delete;
			$event_title = '<span class="badge" style="background:'.$r->event_color.';color:#fff;">'.$r->event_title.'</span>';
			$data[] = array(
				$combhr,
				$prshn_nama,
				$full_name,
				$event_title,
				$sdate,
				$event_time->format('h:i a')
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $events->num_rows(),
			"recordsFiltered" => $events->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function add_event() {

		if($this->input->post('add_type')=='event') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();

			$event_date = $this->input->post('event_date');
			$current_date = date('Y-m-d');
			$event_note = $this->input->post('event_note');
			$ev_date = strtotime($event_date);
			$ct_date = strtotime($current_date);
			$qt_event_note = htmlspecialchars(addslashes($event_note), ENT_QUOTES);
			$assigned_to = $this->input->post('karyawan_id');

			if($this->input->post('perusahaan_id')==='') {
				$Return['error'] = $this->lang->line('error_field_perusahaan');
			} else if(empty($assigned_to)) {
				$Return['error'] = $this->lang->line('umb_error_karyawan_id');
			} else if($this->input->post('event_title')==='') {
				$Return['error'] = $this->lang->line('umb_error_field_title_event');
			} else if($this->input->post('event_date')==='') {
				$Return['error'] = $this->lang->line('umb_error_field_tanggal_event');
			} else if($ev_date < $ct_date) {
				$Return['error'] = $this->lang->line('umb_error_tanggal_event_tanggal_current');
			} else if($this->input->post('event_time')==='') {
				$Return['error'] = $this->lang->line('umb_error_field_waktu_event');
			}

			if($Return['error']!=''){
				$this->output($Return);
			}
			$assigned_ids = implode(',',$this->input->post('karyawan_id'));
			$karyawan_ids = $assigned_ids;
			$data = array(
				'perusahaan_id' => $this->input->post('perusahaan_id'),
				'karyawan_id' => $karyawan_ids,
				'event_title' => $this->input->post('event_title'),
				'event_date' => $this->input->post('event_date'),
				'event_time' => $this->input->post('event_time'),
				'event_color' => $this->input->post('event_color'),
				'event_note' => $qt_event_note,
				'created_at' => date('Y-m-d')
			);
			$result = $this->Events_model->add($data);

			if ($result == TRUE) {
				$row = $this->db->select("*")->limit(1)->order_by('event_id',"DESC")->get("umb_events")->row();
				$Return['result'] = $this->lang->line('umb_hr_sukses_event_ditambahkan');
				$Return['re_event_id'] = $row->event_id;
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	
	public function edit_event() {

		if($this->input->post('edit_type')=='event') {
			
			$id = $this->uri->segment(4);		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();

			$event_date = $this->input->post('event_date');
			$current_date = date('Y-m-d');
			$event_note = $this->input->post('event_note');
			$ev_date = strtotime($event_date);
			$ct_date = strtotime($current_date);
			$qt_event_note = htmlspecialchars(addslashes($event_note), ENT_QUOTES);
			

			if($this->input->post('event_title')==='') {
				$Return['error'] = $this->lang->line('umb_error_field_title_event');
			} else if($this->input->post('event_date')==='') {
				$Return['error'] = $this->lang->line('umb_error_field_tanggal_event');
			} else if($ev_date < $ct_date) {
				$Return['error'] = $this->lang->line('umb_error_tanggal_event_tanggal_current');
			} else if($this->input->post('event_time')==='') {
				$Return['error'] = $this->lang->line('umb_error_field_waktu_event');
			}

			if($Return['error']!=''){
				$this->output($Return);
			}

			$data = array(
				'event_title' => $this->input->post('event_title'),
				'event_date' => $this->input->post('event_date'),
				'event_time' => $this->input->post('event_time'),
				'event_color' => $this->input->post('event_color'),
				'event_note' => $qt_event_note
			);
			$result = $this->Events_model->update_record($data,$id);

			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_hr_sukses_event_diperbarui');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function read_record_event() {

		$data['title'] = $this->Umb_model->site_title();
		$event_id = $this->input->get('event_id');
		$result = $this->Events_model->read_informasi_event($event_id);
		
		$data = array(
			'event_id' => $result[0]->event_id,
			'karyawan_id' => $result[0]->karyawan_id,
			'perusahaan_id' => $result[0]->perusahaan_id,
			'event_title' => $result[0]->event_title,
			'event_date' => $result[0]->event_date,
			'event_time' => $result[0]->event_time,
			'event_note' => $result[0]->event_note,
			'event_color' => $result[0]->event_color,
			'all_karyawans' => $this->Umb_model->all_karyawans(),
			'get_all_perusahaans' => $this->Umb_model->get_perusahaans()
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/events/dialog_events', $data);
		} else {
			redirect('admin/');
		}
	}

	public function delete_event() {
		
		if($this->input->post('type')=='delete') {

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Events_model->delete_record_event($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_hr_sukses_event_dihapus');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}
} 
?>