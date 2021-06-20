<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class View_applicants extends MY_Controller {
	
	 public function __construct() {
        parent::__construct();
		
		$this->load->model("Post_pekerjaan_model");
		$this->load->model("Umb_model");
		$this->load->model("Penunjukan_model");
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
 
    public function candidate_list()
     {

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
		// get job title
		$pekerjaan = $this->Post_pekerjaan_model->read_informasi_pekerjaan($r->pekerjaan_id);
		if(!is_null($pekerjaan)){
			$title_pekerjaan = $pekerjaan[0]->title_pekerjaan;
		} else {
			$title_pekerjaan = '-';	
		}
		// get date
		$created_at = $this->Umb_model->set_date_format($r->created_at);
		
		if(in_array('294',$role_resources_ids)) { //download
			$download = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_download').'">
			<a href="'.site_url('admin/download').'?type=resume&filename='.$r->pekerjaan_resume.'"><button type="button" class="btn btn-outline-secondary btn-sm m-b-0-0 waves-effect waves-light"><i class="oi oi-cloud-download"></i></button></a></span>';
		} else {
			$download = '';
		}
		if(in_array('295',$role_resources_ids)) { // delete
			$delete = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn btn-outline-danger btn-sm m-b-0-0 waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->application_id . '"><i class="fas fa-trash-restore"></i></button></span>';
		} else {
			$delete = '';
		}
		$ikode_ticket = $r->full_name.'<br><small class="text-muted"><i>'.$r->email.'<i></i></i></small>';
		$cover_letter = '<a><button class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-application_id="'. $r->application_id . '">'.$this->lang->line('umb_view').'</button></a>';
		$combhr = $download.$delete;
		
		$data[] = array(
			$combhr,
			$title_pekerjaan,
			$r->full_name,
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
	 
	 public function read_application()
	{
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('application_id');
		$result = $this->Post_pekerjaan_model->read_info_application_pekerjaan($id);
		$data = array(
				'application_id' => $result[0]->application_id,
				'pekerjaan_id' => $result[0]->pekerjaan_id,
				'message' => $result[0]->message
				);
		if(!empty($session)){ 
			$this->load->view('admin/post_pekerjaan/dialog_application', $data);
		} else {
			redirect('admin/');
		}
	}
	 	
	// delete job candidate / job application	
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
