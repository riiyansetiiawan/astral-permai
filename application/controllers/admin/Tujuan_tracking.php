<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tujuan_tracking extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		
		$this->load->model("Umb_model");
		$this->load->model("Tujuan_tracking_model");
		$this->load->model("Penunjukan_model");
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
		if($system[0]->module_tujuan_tracking!='true'){
			redirect('admin/dashboard');
		}
		/*if($system[0]->performance_option!='goal'){
			redirect('admin/performance_appraisal');
		}*/
		$data['title'] = $this->lang->line('umb_hr_tujuan_tracking').' | '.$this->Umb_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('umb_hr_tujuan_tracking');
		$data['path_url'] = 'tujuan_tracking';
		$data['all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$data['all_types_tracking'] = $this->Tujuan_tracking_model->all_types_tracking();
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('107',$role_resources_ids)) {
			if(!empty($session)){
				$data['subview'] = $this->load->view("admin/tujuan_tracking/list_tujuan_tracking", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}

	public function type() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$system = $this->Umb_model->read_setting_info(1);
		if($system[0]->module_tujuan_tracking!='true'){
			redirect('admin/dashboard');
		}
		/*if($system[0]->performance_option!='goal'){
			redirect('admin/performance_appraisal');
		}*/
		$data['title'] = $this->lang->line('umb_hr_type_tujuan_tracking').' | '.$this->Umb_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('umb_hr_type_tujuan_tracking');
		$data['path_url'] = 'type_tujuan_tracking';
		$data['all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('108',$role_resources_ids)) {
			if(!empty($session)){
				$data['subview'] = $this->load->view("admin/tujuan_tracking/type_tujuan_tracking", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/');
			}
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
		if($system[0]->module_tujuan_tracking!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('umb_hr_tujuan_tracking_calendar_se');
		$data['breadcrumbs'] = $this->lang->line('umb_hr_tujuan_tracking_calendar_se');
		$data['all_tujuans_completed'] = $this->Tujuan_tracking_model->all_tujuans_completed();
		$data['all_tujuans_inprogress'] = $this->Tujuan_tracking_model->all_tujuans_inprogress();
		$data['all_tujuans_not_started'] = $this->Tujuan_tracking_model->all_tujuans_not_started();
		$data['path_url'] = 'calendar_event';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('109',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/tujuan_tracking/calendar_tujuan", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
		} else {
			redirect('admin/dashboard');
		}
	}
	
	public function list_type() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/tujuan_tracking/type_tujuan_tracking", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$type_tracking = $this->Tujuan_tracking_model->get_type_tujuan_tracking();
		$role_resources_ids = $this->Umb_model->user_role_resource();
		$data = array();

		foreach($type_tracking->result() as $r) {
			
			if(in_array('339',$role_resources_ids)) {
				$edit = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-type_tracking_id="'. $r->type_tracking_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('340',$role_resources_ids)) {
				$delete = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->type_tracking_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}

			$combhr = $edit.$delete;	
			$data[] = array(
				$combhr,
				$r->type_name
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $type_tracking->num_rows(),
			"recordsFiltered" => $type_tracking->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function list_tujuan_tracking() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/tujuan_tracking/list_tujuan_tracking", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$role_resources_ids = $this->Umb_model->user_role_resource();
		$user_info = $this->Umb_model->read_user_info($session['user_id']);
		if($user_info[0]->user_role_id==1){
			$tracking = $this->Tujuan_tracking_model->get_tujuan_tracking();
		} else {
			$tracking = $this->Tujuan_tracking_model->get_perusahaan_tujuan_tracking($user_info[0]->perusahaan_id);
		}
		$data = array();
		foreach($tracking->result() as $r) {
			$perusahaan = $this->Umb_model->read_info_perusahaan($r->perusahaan_id);
			if(!is_null($perusahaan)){
				$prshn_nama = $perusahaan[0]->name;
			} else {
				$prshn_nama = '--';	
			}
			$type = $this->Tujuan_tracking_model->read_informasi_type_tracking($r->type_tracking_id);
			if(!is_null($type)){
				$itype = $type[0]->type_name;
			} else {
				$itype = '--';	
			}
			$start_date = $this->Umb_model->set_date_format($r->start_date);
			$end_date = $this->Umb_model->set_date_format($r->end_date);
			if($r->tujuan_progress <= 20) {
				$progress_class = 'bg-danger';
			} else if($r->tujuan_progress > 20 && $r->tujuan_progress <= 50){
				$progress_class = 'bg-warning';
			} else if($r->tujuan_progress > 50 && $r->tujuan_progress <= 75){
				$progress_class = 'bg-info';
			} else {
				$progress_class = 'bg-success';
			}
			$pbar = '<p class="mb-1">'.$this->lang->line('umb_completed').' '.$r->tujuan_progress.'%</p><div class="progress"><div class="progress-bar '.$progress_class.' progress-sm" style="width: '.$r->tujuan_progress.'%;"></div></div>';
			//$pbar = '<p class="m-b-0-5">'.$this->lang->line('umb_completed').' <span class="pull-xs-right">'.$r->tujuan_progress.'%</span></p><progress class="progress '.$progress_class.' progress-sm" value="'.$r->tujuan_progress.'" max="100">'.$r->tujuan_progress.'%</progress>';
			if(in_array('335',$role_resources_ids)) {
				$edit = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-tracking_id="'. $r->tracking_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('336',$role_resources_ids)) { 
				$delete = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->tracking_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}
			if(in_array('337',$role_resources_ids)) {
				$view = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-tracking_id="'. $r->tracking_id . '"><span class="fa fa-eye"></span></button></span>';
			} else {
				$view = '';
			}
			$combhr = $edit.$view.$delete;	
			$iitype = $itype.'<br><small class="text-muted"><i>'.$this->lang->line('umb_subject').': '.$r->subject.'<i></i></i></small>';
			$data[] = array(
				$combhr,
				$iitype,
				$prshn_nama,
				$r->target_achiement,
				$start_date,
				$end_date,
				$pbar,
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $tracking->num_rows(),
			"recordsFiltered" => $tracking->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function read_tujuan() {
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('tracking_id');
		$result = $this->Tujuan_tracking_model->read_informasi_tujuan($id);
		$data = array(
			'title' => $this->Umb_model->site_title(),
			'tracking_id' => $result[0]->tracking_id,
			'perusahaan_id' => $result[0]->perusahaan_id,
			'type_tracking_id' => $result[0]->type_tracking_id,
			'subject' => $result[0]->subject,
			'start_date' => $result[0]->start_date,
			'end_date' => $result[0]->end_date,
			'target_achiement' => $result[0]->target_achiement,
			'tujuan_progress' => $result[0]->tujuan_progress,
			'tujuan_status' => $result[0]->tujuan_status,
			'description' => $result[0]->description,
			'all_types_tracking' => $this->Tujuan_tracking_model->all_types_tracking(),
			'all_perusahaans' => $this->Umb_model->get_perusahaans()
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/tujuan_tracking/dialog_tracking_tujuan', $data);
		} else {
			redirect('admin/');
		}
	}
	
	public function read_type() {
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('type_tracking_id');
		$result = $this->Tujuan_tracking_model->read_informasi_type_tracking($id);
		$data = array(
			'type_tracking_id' => $result[0]->type_tracking_id,
			'type_name' => $result[0]->type_name,
			'all_perusahaans' => $this->Umb_model->get_perusahaans()
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/tujuan_tracking/dialog_type_tracking', $data);
		} else {
			redirect('admin/');
		}
	}
	
	public function add_tracking() {

		if($this->input->post('add_type')=='tracking') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$start_date = $this->input->post('start_date');
			$end_date = $this->input->post('end_date');
			$description = $this->input->post('description');
			$st_date = strtotime($start_date);
			$ed_date = strtotime($end_date);
			$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
			if($this->input->post('perusahaan')==='') {
				$Return['error'] = $this->lang->line('error_field_perusahaan');
			} else if($this->input->post('type_tracking')==='') {
				$Return['error'] = $this->lang->line('umb_error_type_tracking_field');
			} else if($this->input->post('subject')==='') {
				$Return['error'] = $this->lang->line('umb_error_subject_field');
			} else if($this->input->post('target_achiement')==='') {
				$Return['error'] = $this->lang->line('umb_error_target_achiement_field');
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
				'type_tracking_id' => $this->input->post('type_tracking'),
				'perusahaan_id' => $this->input->post('perusahaan'),
				'subject' => $this->input->post('subject'),
				'target_achiement' => $this->input->post('target_achiement'),
				'start_date' => $this->input->post('start_date'),
				'end_date' => $this->input->post('end_date'),
				'description' => $qt_description,
				'tujuan_progress' => 0,
				'created_at' => date('d-m-Y h:i:s')
			);
			$result = $this->Tujuan_tracking_model->add_tujuan($data);
			if ($result == TRUE) {
				$row = $this->db->select("*")->limit(1)->order_by('tracking_id',"DESC")->get("umb_tujuan_tracking")->row();
				$Return['result'] = $this->lang->line('umb_sukses_tujuan_ditambahkan');	
				$Return['re_last_id'] = $row->tracking_id;		
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function update_tujuan() {

		if($this->input->post('edit_type')=='tracking') {		
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = $this->uri->segment(4);
			$start_date = $this->input->post('start_date');
			$end_date = $this->input->post('end_date');
			$description = $this->input->post('description');
			$st_date = strtotime($start_date);
			$ed_date = strtotime($end_date);
			$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
			if($this->input->post('perusahaan')==='') {
				$Return['error'] = $this->lang->line('error_field_perusahaan');
			} else if($this->input->post('type_tracking')==='') {
				$Return['error'] = $this->lang->line('umb_error_type_tracking_field');
			} else if($this->input->post('subject')==='') {
				$Return['error'] = $this->lang->line('umb_error_subject_field');
			} else if($this->input->post('target_achiement')==='') {
				$Return['error'] = $this->lang->line('umb_error_target_achiement_field');
			} else if($this->input->post('start_date')==='') {
				$Return['error'] = $this->lang->line('umb_error_start_date');
			} else if($this->input->post('end_date')==='') {
				$Return['error'] = $this->lang->line('umb_error_end_date');
			} else if($st_date >= $ed_date) {
				$Return['error'] = $this->lang->line('umb_error_start_end_date');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$data = array(
				'type_tracking_id' => $this->input->post('type_tracking'),
				'perusahaan_id' => $this->input->post('perusahaan'),
				'subject' => $this->input->post('subject'),
				'target_achiement' => $this->input->post('target_achiement'),
				'start_date' => $this->input->post('start_date'),
				'end_date' => $this->input->post('end_date'),
				'tujuan_progress' => $this->input->post('progres_val'),
				'tujuan_status' => $this->input->post('status'),
				'description' => $qt_description
			);

			$result = $this->Tujuan_tracking_model->update_record_tujuan($data,$id);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_type_tracking_diperbarui');			
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function add_type() {

		if($this->input->post('add_type')=='type_tracking') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			if($this->input->post('type_name')==='') {
				$Return['error'] = $this->lang->line('umb_error_type_tracking_field');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$data = array(
				'type_name' => $this->input->post('type_name'),
				'created_at' => date('d-m-Y h:i:s')
			);
			$result = $this->Tujuan_tracking_model->add_type($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_type_tracking_ditambahkan');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function update_type() {

		if($this->input->post('edit_type')=='type_tracking') {

			$id = $this->uri->segment(4);
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			if($this->input->post('type_name')==='') {
				$Return['error'] = $this->lang->line('umb_error_type_tracking_field');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$data = array(
				'type_name' => $this->input->post('type_name'),
				'created_at' => date('d-m-Y h:i:s')
			);
			$result = $this->Tujuan_tracking_model->update_record_type($data,$id);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_type_tracking_diperbarui');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function delete_tracking() {
		
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$result = $this->Tujuan_tracking_model->delete_record_tracking($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('umb_sukses_type_tracking_dihapus');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
	}
	
	public function delete_type_tracking() {
		
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$result = $this->Tujuan_tracking_model->delete_record_type($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('umb_sukses_type_tracking_dihapus');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
	}
}
