<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tugass extends MY_Controller {
	
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
		$this->load->model("Clients_model");
	}
	
	public function output($Return=array()){
		
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		
		exit(json_encode($Return));
	}

	public function index() {
		
		$session = $this->session->userdata('client_username');
		if(empty($session)){ 
			redirect('client/');
		}
		$system = $this->Umb_model->read_setting_info(1);
		/*if($system[0]->module_projects_tugass!='true'){
			redirect('client/dashboard');
		}*/
		$data['title'] = $this->lang->line('left_tugass').' | '.$this->Umb_model->site_title();
		$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		$data['all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$data['all_projects'] = $this->Project_model->get_all_projects();
		$data['breadcrumbs'] = $this->lang->line('left_tugass');
		$data['path_url'] = 'tugass_clients';
		if(!empty($session)){ 
			$data['subview'] = $this->load->view("client/tugass/list_tugas", $data, TRUE);
			$this->load->view('client/layout/layout_main', $data); 
		} else {
			redirect('client/');
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
			if($this->input->post('nama_tugas')==='') {
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
			}
			
			if($Return['error']!=''){
				$this->output($Return);
			}
			$cproject = $this->Project_model->read_informasi_project($this->input->post('project_id'));
			//$result2 = $this->Clients_model->read_info_client($result[0]->client_id);
			if(!is_null($cproject)) {
				$perusahaan_id = $cproject[0]->perusahaan_id;
			} else {
				$perusahaan_id = 0;
			}
			$assigned_ids = 0;
			// implode(',',$this->input->post('assigned_to'));
			$co_info  = $this->Project_model->read_informasi_project($this->input->post('project_id'));
			$data = array(
				'project_id' => $this->input->post('project_id'),
				'perusahaan_id' => $perusahaan_id,
				'created_by' => 0,
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
				$Return['result'] = $this->lang->line('umb_sukses_tugas_ditambahkan');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function list_tugas() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('client_username');
		if(!empty($session)){ 
			$this->load->view("admin/timesheet/cuti", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$cproject = $this->Umb_model->get_panel_projects_client($session['client_id']);
		//$result2 = $this->Clients_model->read_info_client($result[0]->client_id);
		if(!is_null($cproject)) {
			$tugas = $this->Umb_model->get_panel_project_tugass_client($cproject[0]->project_id);
			if(!is_null($tugas)) {
				$data = array();
				foreach($tugas->result() as $r) {				  
					$prj_tugas = $this->Project_model->read_informasi_project($r->project_id);
					if(!is_null($prj_tugas)){
						$nama_prj = $prj_tugas[0]->title;
					} else {
						$nama_prj = '--';
					}
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
					//if(in_array('320',$role_resources_ids)) { //edit
					$edit = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light edit-data" data-toggle="modal" data-target=".edit-modal-data" data-tugas_id="'. $r->tugas_id.'" data-mname="admin"><span class="fa fa-pencil"></span></button></span>';
					$delete = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-xs btn-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->tugas_id . '"><span class="fa fa-trash"></span></button></span>';
					$view = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_view_details').'"><a href="'.site_url().'admin/timesheet/details_tugas/id/'.$r->tugas_id.'/"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span>';
					$combhr = $edit.$view.$delete;
					$pname = '<a href="'.site_url().'client/projects/detail/'.$r->project_id.'">'.$nama_prj.'</a>';
					$data[] = array(
						$r->nama_tugas,
						$pname,
						$tdate,
						$status,
						$progress_bar
					);
				} 
			} 
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

	public function details_tugas() {
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
		$this->Timesheet_model->update_record_tugas($edata,$tugas_id);
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
		$session = $this->session->userdata('client_username');
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
		$session = $this->session->userdata('client_username');
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

	public function list_comments() {

		$data['title'] = $this->Umb_model->site_title();
		//$id = $this->input->get('ticket_id');
		$id = $this->uri->segment(4);
		$session = $this->session->userdata('client_username');
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
			<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'">
			<a class="btn icon-btn btn-xs btn-danger delete" href="#" data-toggle="modal" data-target=".delete-modal" data-record-id="'.$r->comment_id.'">
			<span class="fa fa-trash m-r-0-5"></span></a></span>
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
		$session = $this->session->userdata('client_username');
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
				$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_download').'"><a href="'.site_url().'admin/download?type=tugas&filename='.$r->attachment_file.'"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light"><span class="fa fa-download"></span></button></a></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-xs btn-danger waves-effect waves-light delete-file" data-toggle="modal" data-target=".delete-modal-file" data-record-id="'. $r->attachment_tugas_id . '"><span class="fa fa-trash"></span></button></span>',
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
		$session = $this->session->userdata('client_username');
		if(!empty($session)){ 
			$this->load->view('admin/timesheet/tugass/dialog_tugas', $data);
		} else {
			redirect('admin/');
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
}
