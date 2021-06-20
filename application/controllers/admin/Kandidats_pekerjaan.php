<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Kandidats_pekerjaan extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		
		$this->load->model("Post_pekerjaan_model");
		$this->load->model("Umb_model");
		$this->load->model("Penunjukan_model");
		$this->load->model("Users_model");
	}
	
	
	public function output($Return=array()){
		
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		
		exit(json_encode($Return));
	}
	
	public function index()
	{
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$system = $this->Umb_model->read_setting_info(1);
		if($system[0]->module_recruitment!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('left_kandidats_pekerjaan').' | '.$this->Umb_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('left_kandidats_pekerjaan');
		$data['path_url'] = 'kandidats_pekerjaan';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('51',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/post_pekerjaan/kandidats_pekerjaan", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}		  
	}

	public function candidate_list() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/post_pekerjaan/kandidats_pekerjaan", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('387',$role_resources_ids)) {
			$kandidats = $this->Post_pekerjaan_model->get_karyawan_applied_pekerjaans($session['user_id']);
		} else {
			$kandidats = $this->Post_pekerjaan_model->get_kandidats_pekerjaans();
		}
		
		$data = array();
		foreach($kandidats->result() as $r) {

			$pekerjaan = $this->Post_pekerjaan_model->read_informasi_pekerjaan($r->pekerjaan_id);
			if(!is_null($pekerjaan)){
				$app_row = $this->Post_pekerjaan_model->available_applications_pekerjaan($r->pekerjaan_id);
				if($app_row > 1) {
					$app_available = '<br><a class="badge bg-purple btn-sm" href="'.site_url('admin/kandidats_pekerjaan/').'bedasarkan_pekerjaan/'.$r->pekerjaan_id.'" target="_blank"><i class="fa fa-list"></i> '.$this->lang->line('umb_title_applicants_pekerjaan').'</a>';
				} else {
					$app_available = '';
				}
				$title_pekerjaan = '<a href="'.site_url().'pekerjaans/detail/'.$pekerjaan[0]->url_pekerjaan.'" target="_blank" data-toggle="tooltip" data-placement="top" title="" data-original-title="'.$this->lang->line('umb_view').'">'.$pekerjaan[0]->title_pekerjaan.'</a>';
				$title_pekerjaan = $title_pekerjaan.$app_available;
			} else {
				$title_pekerjaan = '-';	
			}

			$created_at = $this->Umb_model->set_date_format($r->created_at);

			if($r->application_status == 0){
				$status = '<span class="badge bg-yellow">'.$this->lang->line('umb_pending').'</span>';
			} else if($r->application_status == 1){
				$status = '<span class="badge bg-teal">'.$this->lang->line('umb_primary_selected').'</span>';
			} if($r->application_status == 2){
				$status = '<span class="badge bg-primary">'.$this->lang->line('umb_call_for_interview').'</span>';
			} if($r->application_status == 3){
				$status = '<span class="badge bg-green">'.$this->lang->line('umb_confirm_del').'</span>';
			} if($r->application_status == 4){
				$status = '<span class="badge bg-red">'.$this->lang->line('umb_rejected').'</span>';
			}
			if(in_array('294',$role_resources_ids)) {
				$download = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_download').'">
				<a href="'.site_url('admin/download').'?type=resume&filename='.$r->pekerjaan_resume.'"><button type="button" class="btn btn-outline-secondary btn-sm m-b-0-0 waves-effect waves-light"><i class="oi oi-cloud-download"></i></button></a></span>';
			} else {
				$download = '';
			}
			if(in_array('295',$role_resources_ids)) {
				$delete = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn btn-outline-danger btn-sm m-b-0-0 waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->application_id . '"><i class="fas fa-trash-restore"></i></button></span>';
				$edit_status = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_change_status').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".add-modal-data" data-application_id="'. $r->application_id . '"><i class="fas fa-pencil-alt-square-o"></i></button></span>';
			} else {
				$delete = '';
				$edit_status = '';
			}
			$ikode_ticket = $r->full_name.'<br><small class="text-muted"><i>'.$r->email.'<i></i></i></small>';
			$cover_letter = '<a><button class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-application_id="'. $r->application_id . '">'.$this->lang->line('umb_view').' '.$this->lang->line('umb_pekerjaans_cover_letter').'</button></a>';
			$combhr = $download.$edit_status.$delete;

			$data[] = array(
				$combhr,
				$title_pekerjaan,
				$r->full_name,
				$r->email,
				$status,
				$cover_letter,
				$created_at
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $kandidats->num_rows(),
			"recordsFiltered" => $kandidats->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function read_application() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('application_id');
		$result = $this->Post_pekerjaan_model->read_info_application_pekerjaan($id);
		$data = array(
			'application_id' => $result[0]->application_id,
			'user_id' => $result[0]->user_id,
			'pekerjaan_id' => $result[0]->pekerjaan_id,
			'application_status' => $result[0]->application_status,
			'message' => $result[0]->message
		);
		if(!empty($session)){ 
			$this->load->view('admin/post_pekerjaan/dialog_application', $data);
		} else {
			redirect('admin/');
		}
	}

	public function bedasarkan_pekerjaan() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$system = $this->Umb_model->read_setting_info(1);
		if($system[0]->module_recruitment!='true'){
			redirect('admin/dashboard');
		}
		$id = $this->uri->segment(4);
		$pekerjaan = $this->Post_pekerjaan_model->read_informasi_pekerjaan($id);
		if(is_null($pekerjaan)){
			redirect('admin/kandidats_pekerjaan/');	
		}
		$data['title'] = $this->lang->line('umb_title_applicants_pekerjaan').' | '.$this->Umb_model->site_title();
		$data['breadcrumbs'] = $pekerjaan[0]->title_pekerjaan.' '.$this->lang->line('umb_title_applicants_pekerjaan');
		$data['path_url'] = 'pekerjaan_applicants';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('51',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/post_pekerjaan/view_applicants", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}		  
	}

	public function by_employer() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$system = $this->Umb_model->read_setting_info(1);
		if($system[0]->module_recruitment!='true'){
			redirect('admin/dashboard');
		}
		$id = $this->uri->segment(4);
		$employer = $this->Users_model->read_users_info($id);
		if(is_null($employer)){
			redirect('admin/post_pekerjaan/employer/');	
		}

		$data['title'] = $this->lang->line('umb_title_applicants_pekerjaan').' | '.$this->Umb_model->site_title();
		$data['breadcrumbs'] = $employer[0]->first_name.' '.$employer[0]->last_name.' '.$this->lang->line('umb_title_applicants_pekerjaan');
		$data['path_url'] = 'employer_applicants_pekerjaan';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('51',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/post_pekerjaan/view_applicants_employer", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}		  
	}
	
	public function applicants_list() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/post_pekerjaan/view_applicants", $data);
		} else {
			redirect('admin/');
		}

		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$id = $this->uri->segment(4);
		$role_resources_ids = $this->Umb_model->user_role_resource();

		$applicants = $this->Post_pekerjaan_model->get_single_kandidat_pekerjaans($id);

		$data = array();

		foreach($applicants->result() as $r) {
			$pekerjaan = $this->Post_pekerjaan_model->read_informasi_pekerjaan($r->pekerjaan_id);
			if(!is_null($pekerjaan)){
				$title_pekerjaan = $pekerjaan[0]->title_pekerjaan;
			} else {
				$title_pekerjaan = '-';	
			}

			$created_at = $this->Umb_model->set_date_format($r->created_at);

			if($r->application_status == 0){
				$status = '<span class="badge bg-yellow">'.$this->lang->line('umb_pending').'</span>';
			} else if($r->application_status == 1){
				$status = '<span class="badge bg-teal">'.$this->lang->line('umb_primary_selected').'</span>';
			} if($r->application_status == 2){
				$status = '<span class="badge bg-primary">'.$this->lang->line('umb_call_for_interview').'</span>';
			} if($r->application_status == 3){
				$status = '<span class="badge bg-green">'.$this->lang->line('umb_confirm_del').'</span>';
			} if($r->application_status == 4){
				$status = '<span class="badge bg-red">'.$this->lang->line('umb_rejected').'</span>';
			}

			if(in_array('294',$role_resources_ids)) {
				$download = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_download').'">
				<a href="'.site_url('admin/download').'?type=resume&filename='.$r->pekerjaan_resume.'"><button type="button" class="btn btn-outline-secondary btn-sm m-b-0-0 waves-effect waves-light"><i class="oi oi-cloud-download"></i></button></a></span>';
			} else {
				$download = '';
			}
			if(in_array('295',$role_resources_ids)) {
				$delete = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn btn-outline-danger btn-sm m-b-0-0 waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->application_id . '"><i class="fas fa-trash-restore"></i></button></span>';
				$edit_status = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_change_status').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".add-modal-data" data-application_id="'. $r->application_id . '"><i class="fas fa-pencil-alt-square-o"></i></button></span>';
			} else {
				$delete = '';
				$edit_status = '';
			}
			$ikode_ticket = $r->full_name.'<br><small class="text-muted"><i>'.$r->email.'<i></i></i></small>';
			$cover_letter = '<a><button class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-application_id="'. $r->application_id . '" data-user_id="'. $r->user_id . '">'.$this->lang->line('umb_view').' '.$this->lang->line('umb_pekerjaans_cover_letter').'</button></a>';
			$combhr = $download.$edit_status.$delete;

			$data[] = array(
				$combhr,
				$r->full_name,
				$r->email,
				$status,
				$cover_letter,
				$created_at
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $applicants->num_rows(),
			"recordsFiltered" => $applicants->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function list_applicants_employer() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/post_pekerjaan/view_applicants_employer", $data);
		} else {
			redirect('admin/');
		}

		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$id = $this->uri->segment(4);
		$role_resources_ids = $this->Umb_model->user_role_resource();

		$applicants = $this->Post_pekerjaan_model->get_employer_kandidat_pekerjaans($id);

		$data = array();

		foreach($applicants->result() as $r) {

			$pekerjaan = $this->Post_pekerjaan_model->read_informasi_pekerjaan($r->pekerjaan_id);
			if(!is_null($pekerjaan)){
				$title_pekerjaan = $pekerjaan[0]->title_pekerjaan;
			} else {
				$title_pekerjaan = '-';	
			}

			$created_at = $this->Umb_model->set_date_format($r->created_at);

			if($r->application_status == 0){
				$status = '<span class="badge bg-yellow">'.$this->lang->line('umb_pending').'</span>';
			} else if($r->application_status == 1){
				$status = '<span class="badge bg-teal">'.$this->lang->line('umb_primary_selected').'</span>';
			} if($r->application_status == 2){
				$status = '<span class="badge bg-primary">'.$this->lang->line('umb_call_for_interview').'</span>';
			} if($r->application_status == 3){
				$status = '<span class="badge bg-green">'.$this->lang->line('umb_confirm_del').'</span>';
			} if($r->application_status == 4){
				$status = '<span class="badge bg-red">'.$this->lang->line('umb_rejected').'</span>';
			}

			if(in_array('294',$role_resources_ids)) {
				$download = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_download').'">
				<a href="'.site_url('admin/download').'?type=resume&filename='.$r->pekerjaan_resume.'"><button type="button" class="btn btn-outline-secondary btn-sm m-b-0-0 waves-effect waves-light"><i class="oi oi-cloud-download"></i></button></a></span>';
			} else {
				$download = '';
			}
			if(in_array('295',$role_resources_ids)) {
				$delete = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn btn-outline-danger btn-sm m-b-0-0 waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->application_id . '"><i class="fas fa-trash-restore"></i></button></span>';
				$edit_status = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_change_status').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".add-modal-data" data-application_id="'. $r->application_id . '"><i class="fas fa-pencil-alt-square-o"></i></button></span>';
			} else {
				$delete = '';
				$edit_status = '';
			}
			$ikode_ticket = $r->full_name.'<br><small class="text-muted"><i>'.$r->email.'<i></i></i></small>';
			$cover_letter = '<a><button class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-application_id="'. $r->application_id . '">'.$this->lang->line('umb_view').' '.$this->lang->line('umb_pekerjaans_cover_letter').'</button></a>';
			$combhr = $download.$edit_status.$delete;

			$data[] = array(
				$combhr,
				$r->full_name,
				$r->email,
				$status,
				$cover_letter,
				$created_at
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $applicants->num_rows(),
			"recordsFiltered" => $applicants->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function update_status() {

		if($this->input->post('edit_type')=='update_status') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();	

			$data = array(
				'application_status' => $this->input->post('status'),
			);
			$id = $this->input->post('jid');
			$result = $this->Post_pekerjaan_model->update_applicant_status($data,$id);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_applicant_status_diperbarui');
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
		$result = $this->Post_pekerjaan_model->delete_record_application($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('umb_error_application_pekerjaan');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
	}
}
