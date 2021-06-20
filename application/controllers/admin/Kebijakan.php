<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Kebijakan extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		
		$this->load->model("Kebijakan_model");
		$this->load->model("Umb_model");
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
		$data['title'] = $this->lang->line('umb_kebijakans').' | '.$this->Umb_model->site_title();
		$data['all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$data['breadcrumbs'] = $this->lang->line('umb_kebijakans');
		$data['path_url'] = 'kebijakan';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('9',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/kebijakan/list_kebijakan", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 		
		} else {
			redirect('admin/dashboard');
		}
	}

	public function view_all() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('umb_kebijakans').' | '.$this->Umb_model->site_title();
		$data['all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$data['breadcrumbs'] = $this->lang->line('umb_kebijakans');
		$data['path_url'] = 'kebijakan';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('9',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/kebijakan/view_kebijakan", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 		
		} else {
			redirect('admin/dashboard');
		}
	}
	
	public function list_kebijakan() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/kebijakan/list_kebijakan", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$role_resources_ids = $this->Umb_model->user_role_resource();
		$user_info = $this->Umb_model->read_user_info($session['user_id']);
		if($user_info[0]->user_role_id==1){
			$kebijakan = $this->Kebijakan_model->get_kebijakans();
		} else {
			$kebijakan = $this->Kebijakan_model->get_kebijakans_perusahaan($user_info[0]->perusahaan_id);
		}
		$data = array();

		foreach($kebijakan->result() as $r) {
			
			$user = $this->Umb_model->read_user_info($r->added_by);
			
			if(!is_null($user)){
				$full_name = $user[0]->first_name.' '.$user[0]->last_name;
			} else {
				$full_name = '--';	
			}

			$pdate = $this->Umb_model->set_date_format($r->created_at);

			if($r->perusahaan_id=='0'){
				$perusahaan = $this->lang->line('umb_all_perusahaans');
			} else {
				$p_perusahaan = $this->Umb_model->read_info_perusahaan($r->perusahaan_id);
				if(!is_null($p_perusahaan)){
					$perusahaan = $p_perusahaan[0]->name;
				} else {
					$perusahaan = '--';	
				}
			}
			if(in_array('259',$role_resources_ids)) {
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-kebijakan_id="'. $r->kebijakan_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('260',$role_resources_ids)) {
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->kebijakan_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}
			if(in_array('261',$role_resources_ids)) {
				$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target="#modals-slide" data-kebijakan_id="'. $r->kebijakan_id . '"><span class="fa fa-eye"></span></button></span>';
			} else {
				$view = '';
			}
			$combhr = $edit.$view.$delete;
			$ititle = $r->title.'<br><small class="text-muted"><i>'.$this->lang->line('module_title_perusahaan').': '.$perusahaan.'<i></i></i></small>';
			$data[] = array(
				$combhr,
				$ititle,
				$pdate,
				$full_name
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $kebijakan->num_rows(),
			"recordsFiltered" => $kebijakan->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function read() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('kebijakan_id');
		$result = $this->Kebijakan_model->read_informasi_kebijakan($id);
		$data = array(
			'kebijakan_id' => $result[0]->kebijakan_id,
			'perusahaan_id' => $result[0]->perusahaan_id,
			'title' => $result[0]->title,
			'attachment' => $result[0]->attachment,
			'description' => $result[0]->description,
			'all_perusahaans' => $this->Umb_model->get_perusahaans()
		);
		if(!empty($session)){ 
			$this->load->view('admin/kebijakan/dialog_kebijakan', $data);
		} else {
			redirect('admin/');
		}
	}

	public function add_kebijakan() {

		if($this->input->post('add_type')=='kebijakan') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();

			$description = $this->input->post('description');
			$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);

			if($this->input->post('perusahaan')==='') {
				$Return['error'] = $this->lang->line('umb_error_perusahaan');
			} else if($this->input->post('title')==='') {
				$Return['error'] = $this->lang->line('umb_error_title');
			}

			if($Return['error']!=''){
				$this->output($Return);
			}

			if(is_uploaded_file($_FILES['attachment']['tmp_name'])) {

				$allowed =  array('png','jpg','jpeg','pdf','gif');
				$filename = $_FILES['attachment']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);

				if(in_array($ext,$allowed)){
					$tmp_name = $_FILES["attachment"]["tmp_name"];
					$profile = "uploads/kebijakan_perusahaan/";
					$set_img = base_url()."uploads/kebijakan_perusahaan/";

					$name = basename($_FILES["attachment"]["name"]);
					$newfilename = 'kebijakan_perusahaan_'.round(microtime(true)).'.'.$ext;
					move_uploaded_file($tmp_name, $profile.$newfilename);
					$fname = $newfilename;			
				} else {
					$Return['error'] = $this->lang->line('umb_error_attatchment_type');
				}
			} else {
				$fname = '';
			}

			$data = array(
				'perusahaan_id' => $this->input->post('perusahaan'),
				'title' => $this->input->post('title'),
				'description' => $qt_description,
				'attachment' => $fname,
				'added_by' => $this->input->post('user_id'),
				'created_at' => date('d-m-Y'),

			);
			$result = $this->Kebijakan_model->add($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_tambah_kebijakan');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function update() {

		if($this->input->post('edit_type')=='kebijakan') {

			$id = $this->uri->segment(4);

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();

			$description = $this->input->post('description');
			$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);

			if($this->input->post('title')==='') {
				$Return['error'] = $this->lang->line('umb_error_title');
			}

			if($Return['error']!=''){
				$this->output($Return);
			}

			$data = array(
				'title' => $this->input->post('title'),
				'description' => $qt_description,		
			);

			$result = $this->Kebijakan_model->update_record($data,$id);		

			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_perbarui_kebijakan');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function delete() {

		if($this->input->post('is_ajax')==2) {
			$session = $this->session->userdata('username');
			if(empty($session)){ 
				redirect('admin/');
			}

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Kebijakan_model->delete_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_sukses_hapus_kebijakan');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}
}
