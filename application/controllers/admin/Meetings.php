<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Meetings extends MY_Controller {


	public function output($Return=array()){
		
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		
		exit(json_encode($Return));
	}
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('Perusahaan_model');
		$this->load->model('Umb_model');
		$this->load->model('Meetings_model');
		$this->load->model('Events_model');
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
		$data['title'] = $this->lang->line('umb_hr_meetings').' | '.$this->Umb_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('umb_hr_meetings');
		$data['path_url'] = 'meetings';
		$data['get_all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('99',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/events/list_meetings", $data, TRUE);
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
		$data['title'] = $this->lang->line('umb_hrastral_calendar_meetings');
		$data['breadcrumbs'] = $this->lang->line('umb_hrastral_calendar_meetings');
		$data['all_events'] = $this->Events_model->get_events();
		$data['all_meetings'] = $this->Meetings_model->get_meetings();
		$data['get_all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$data['path_url'] = 'calendar_event';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('99',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/events/calendar_meetings", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
		} else {
			redirect('admin/dashboard');
		}
	}	

	public function list_meetings() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/events/list_meetings", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		$role_resources_ids = $this->Umb_model->user_role_resource();
		$user_info = $this->Umb_model->read_user_info($session['user_id']);
		if($user_info[0]->user_role_id==1){
			$meetings = $this->Meetings_model->get_meetings();
		} else {
			if(in_array('276',$role_resources_ids)) {
				$meetings = $this->Meetings_model->get_meetings_perusahaan($user_info[0]->perusahaan_id);
			} else {
				$meetings = $this->Meetings_model->get_meetings_karyawan($session['user_id']);
			}
		}
		$data = array();

		foreach($meetings->result() as $r) {

			$tanggal_meeting = $this->Umb_model->set_date_format($r->tanggal_meeting);

			$waktu_meeting = new DateTime($r->waktu_meeting);

			$perusahaan = $this->Umb_model->read_info_perusahaan($r->perusahaan_id);
			if(!is_null($perusahaan)){
				$prshn_nama = $perusahaan[0]->name;
			} else {
				$prshn_nama = '--';	
			}
			
			/*$user = $this->Umb_model->read_user_info($r->karyawan_id);
			
			if(!is_null($user)){
				$full_name = $user[0]->first_name.' '.$user[0]->last_name;
			} else {
				$full_name = '--';	
			}*/
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
			if(in_array('274',$role_resources_ids)) {
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light edit-data" data-toggle="modal" data-target=".edit-modal-data" data-meeting_id="'. $r->meeting_id.'"><span class="fas fa-pencil-alt"></span></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('275',$role_resources_ids)) { 
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->meeting_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}
			if(in_array('276',$role_resources_ids)) {
				$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target="#modals-slide" data-meeting_id="'. $r->meeting_id . '"><span class="fa fa-eye"></span></button></span>';
			} else {
				$view = '';
			}
			$combhr = $edit.$view.$delete;
			$meeting_info = $prshn_nama.'<br>'.$this->lang->line('umb_meeting_room').': '.$r->meeting_room;
			$title_meeting = '<span class="badge" style="background:'.$r->meeting_color.';color:#fff;">'.$r->title_meeting.'</span>';
			$data[] = array(
				$combhr,
				$meeting_info,
				$title_meeting,
				$tanggal_meeting,
				$waktu_meeting->format('h:i a')
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $meetings->num_rows(),
			"recordsFiltered" => $meetings->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function add_meeting() {

		if($this->input->post('add_type')=='meeting') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();

			$tanggal_meeting = $this->input->post('tanggal_meeting');
			$current_date = date('Y-m-d');
			$meeting_note = $this->input->post('meeting_note');
			$mt_date = strtotime($tanggal_meeting);
			$ct_date = strtotime($current_date);
			$qt_meeting_note = htmlspecialchars(addslashes($meeting_note), ENT_QUOTES);
			$assigned_to = $this->input->post('karyawan_id');
			
			if($this->input->post('perusahaan_id')==='') {
				$Return['error'] = $this->lang->line('error_field_perusahaan');
			} else if(empty($assigned_to)) {
				$Return['error'] = $this->lang->line('umb_error_karyawan_id');
			} else if($this->input->post('title_meeting')==='') {
				$Return['error'] = $this->lang->line('umb_error_title_meeting_field');
			} else if($this->input->post('tanggal_meeting')==='') {
				$Return['error'] = $this->lang->line('umb_error_tanggal_meeting_field');
			} else if($mt_date < $ct_date) {
				$Return['error'] = $this->lang->line('umb_error_tanggal_meeting_current_date');
			} else if($this->input->post('waktu_meeting')==='') {
				$Return['error'] = $this->lang->line('umb_error_waktu_meeting_field');
			} else if($this->input->post('meeting_room')==='') {
				$Return['error'] = $this->lang->line('umb_meeting_room_field_error');
			}

			if($Return['error']!=''){
				$this->output($Return);
			}

			$assigned_ids = implode(',',$this->input->post('karyawan_id'));
			$karyawan_ids = $assigned_ids;
			$data = array(
				'perusahaan_id' => $this->input->post('perusahaan_id'),
				'karyawan_id' => $karyawan_ids,
				'title_meeting' => $this->input->post('title_meeting'),
				'tanggal_meeting' => $this->input->post('tanggal_meeting'),
				'waktu_meeting' => $this->input->post('waktu_meeting'),
				'meeting_room' => $this->input->post('meeting_room'),
				'meeting_color' => $this->input->post('meeting_color'),
				'meeting_note' => $qt_meeting_note,
				'created_at' => date('Y-m-d')
			);
			$result = $this->Meetings_model->add($data);

			if ($result == TRUE) {
				$row = $this->db->select("*")->limit(1)->order_by('meeting_id',"DESC")->get("umb_meetings")->row();
				$Return['result'] = $this->lang->line('umb_hr_sukses_meeting_ditambahkan');
				$Return['re_meeting_id'] = $row->meeting_id;

			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
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
	
	
	public function edit_meeting() {

		if($this->input->post('edit_type')=='meeting') {
			
			$id = $this->uri->segment(4);		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();

			$tanggal_meeting = $this->input->post('tanggal_meeting');
			$current_date = date('Y-m-d');
			$meeting_note = $this->input->post('meeting_note');
			$mt_date = strtotime($tanggal_meeting);
			$ct_date = strtotime($current_date);
			$qt_meeting_note = htmlspecialchars(addslashes($meeting_note), ENT_QUOTES);

			if($this->input->post('title_meeting')==='') {
				$Return['error'] = $this->lang->line('umb_error_title_meeting_field');
			} else if($this->input->post('tanggal_meeting')==='') {
				$Return['error'] = $this->lang->line('umb_error_tanggal_meeting_field');
			} else if($mt_date < $ct_date) {
				$Return['error'] = $this->lang->line('umb_error_tanggal_meeting_current_date');
			} else if($this->input->post('waktu_meeting')==='') {
				$Return['error'] = $this->lang->line('umb_error_waktu_meeting_field');
			} else if($this->input->post('meeting_room')==='') {
				$Return['error'] = $this->lang->line('umb_meeting_room_field_error');
			}

			if($Return['error']!=''){
				$this->output($Return);
			}

			$data = array(
				'title_meeting' => $this->input->post('title_meeting'),
				'tanggal_meeting' => $this->input->post('tanggal_meeting'),
				'waktu_meeting' => $this->input->post('waktu_meeting'),
				'meeting_room' => $this->input->post('meeting_room'),
				'meeting_color' => $this->input->post('meeting_color'),
				'meeting_note' => $qt_meeting_note,
			);
			$result = $this->Meetings_model->update_record($data,$id);

			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_hr_sukses_meeting_diperbarui');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function read_record_meeting() {
		$data['title'] = $this->Umb_model->site_title();
		$meeting_id = $this->input->get('meeting_id');
		$result = $this->Meetings_model->read_informasi_meeting($meeting_id);
		
		$data = array(
			'meeting_id' => $result[0]->meeting_id,
			'karyawan_id' => $result[0]->karyawan_id,
			'perusahaan_id' => $result[0]->perusahaan_id,
			'title_meeting' => $result[0]->title_meeting,
			'tanggal_meeting' => $result[0]->tanggal_meeting,
			'waktu_meeting' => $result[0]->waktu_meeting,
			'meeting_note' => $result[0]->meeting_note,
			'meeting_room' => $result[0]->meeting_room,
			'meeting_color' => $result[0]->meeting_color,
			'all_karyawans' => $this->Umb_model->all_karyawans(),
			'get_all_perusahaans' => $this->Umb_model->get_perusahaans()
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/events/dialog_meetings', $data);
		} else {
			redirect('admin/');
		}
	}
	
	public function delete_meeting() {
		if($this->input->post('type')=='delete') {

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Meetings_model->delete_record_meeting($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_hr_sukses_meeting_dihapus');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}



} 
?>