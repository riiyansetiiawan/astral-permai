<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tickets extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		
		$this->load->model("Tickets_model");
		$this->load->model("Umb_model");
		$this->load->library('email');
		$this->load->model("Penunjukan_model");
		$this->load->model("Department_model");
		$this->load->model("Custom_fields_model");
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
		if($system[0]->module_inquiry!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('left_tickets').' | '.$this->Umb_model->site_title();
		$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		$data['all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$data['breadcrumbs'] = $this->lang->line('left_tickets');
		$data['path_url'] = 'tickets';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('43',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/tickets/list_ticket", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}		  
	}
	
	public function get_ticket_departments() {

		$data['title'] = $this->Umb_model->site_title();
		$id = $this->uri->segment(4);
		$data = array(
			'perusahaan_id' => $id
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/tickets/get_ticket_departments", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}
	
	public function get_karyawans() {

		$data['title'] = $this->Umb_model->site_title();
		$id = $this->uri->segment(4);
		$data = array(
			'perusahaan_id' => $id
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/tickets/get_karyawans", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}
	
	public function list_ticket(){

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/tickets/list_ticket", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$role_resources_ids = $this->Umb_model->user_role_resource();
		$user_info = $this->Umb_model->read_user_info($session['user_id']);
		if($user_info[0]->user_role_id==1){
			$ticket = $this->Tickets_model->get_tickets();
		} else {
			if(in_array('309',$role_resources_ids)) {
				$ticket = $this->Tickets_model->get_perusahaan_tickets($user_info[0]->perusahaan_id);
			} else {
				$ticket = $this->Tickets_model->get_tickets_karyawan($session['user_id']);
			}
		}
		$data = array();
		$cdate = strtotime(date('Y-m-d'));
		foreach($ticket->result() as $r) {					
			if($r->ticket_priority==1):
				$priority = $this->lang->line('umb_low');
			elseif($r->ticket_priority==2):
				$priority = $this->lang->line('umb_medium');
			elseif($r->ticket_priority==3):
				$priority = $this->lang->line('umb_high');
			elseif($r->ticket_priority==4):
				$priority = $this->lang->line('umb_critical');
			endif;
			$eend_date = strtotime($r->end_date);
			if($cdate > $eend_date){
				$xpired = '<span class="badge badge-danger">'.$this->lang->line('umb_expired_title').'</span>';
			} else {
				$xpired = '';
			}
			$end_date = $this->Umb_model->set_date_format($r->end_date);
			if($r->status_ticket==1):
				$status = '<span class="badge badge-info">'.$this->lang->line('umb_open').'</span> '.$xpired;
			else:
				$status = '<span class="badge badge-success">'.$this->lang->line('umb_closed').'</span> '.$xpired;
			endif;
			$created_at = date('h:i A', strtotime($r->created_at));
			$_date = explode(' ',$r->created_at);
			$edate = $this->Umb_model->set_date_format($_date[0]);
			$_created_at = $edate. ' '. $created_at;
			$p_perusahaan = $this->Umb_model->read_info_perusahaan($r->perusahaan_id);
			if(!is_null($p_perusahaan)){
				$perusahaan = $p_perusahaan[0]->name;
			} else {
				$perusahaan = '--';	
			}
			$created_by = $this->Umb_model->read_user_info($r->created_by);
			if(!is_null($created_by)){
				$ticket_created_by = $created_by[0]->first_name.' '.$created_by[0]->last_name;
				if($created_by[0]->profile_picture!='' && $created_by[0]->profile_picture!='no file') {
					$eol = '<a href="javascript:void(0);" data-toggle="tooltip" data-state="primary" data-placement="top" title="'.$ticket_created_by.'"><span class="avatar box-32"><img src="'.base_url().'uploads/profile/'.$created_by[0]->profile_picture.'" class="ui-w-30 rounded-circle" alt=""></span></a>';
				} else {
					if($created_by[0]->jenis_kelamin=='Pria') { 
						$ede_file = base_url().'uploads/profile/default_male.jpg';
					} else {
						$ede_file = base_url().'uploads/profile/default_female.jpg';
					}
					$eol = '<a href="javascript:void(0);" data-toggle="tooltip" data-state="primary" data-placement="top" title="'.$ticket_created_by.'"><span class="avatar box-32"><img src="'.$ede_file.'" class="ui-w-30 rounded-circle" alt=""></span></a>';
				}
				$ticket_created_by = $eol;	
			} else {
				$ticket_created_by = '';	
			}
			$department = $this->Department_model->read_informasi_department($r->department_id);
			if(!is_null($department)){
				$nama_department = $department[0]->nama_department;
			} else {
				$nama_department = '--';	
			}
			if($r->ticket_image!='0'){
				$timage = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_download').'"><a href="'.site_url().'admin/download?type=ticket&filename='.$r->ticket_image.'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="oi oi-cloud-download"></span></button></a></span>';
			} else {
				$timage = '';
			}
			
			if(in_array('307',$role_resources_ids)) {
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data"  data-ticket_id="'. $r->ticket_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('308',$role_resources_ids)) {
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->ticket_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}
			// if(in_array('309',$role_resources_ids)) {
			$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_view_details').'"><a href="'.site_url().'admin/tickets/details/'.$r->ticket_id.'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span>';
			$combhr = $timage.$edit.$view.$delete;

			$eticket_info = $this->Tickets_model->get_ticket_karyawans($r->ticket_id);
			$ol = '';
			foreach($eticket_info as $eticket_id) {
				$assigned_to = $this->Umb_model->read_user_info($eticket_id->karyawan_id);
				if(!is_null($assigned_to)){
					$assigned_name = $assigned_to[0]->first_name.' '.$assigned_to[0]->last_name;
					if($assigned_to[0]->profile_picture!='' && $assigned_to[0]->profile_picture!='no file') {
						$ol .= '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.base_url().'uploads/profile/'.$assigned_to[0]->profile_picture.'" class="ui-w-30 rounded-circle" alt=""></span></a>';
					} else {
						if($assigned_to[0]->jenis_kelamin=='Pria') { 
							$de_file = base_url().'uploads/profile/default_male.jpg';
						} else {
							$de_file = base_url().'uploads/profile/default_female.jpg';
						}
						$ol .= '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.$de_file.'" class="ui-w-30 rounded-circle" alt=""></span></a>';
					}
				}
				else {
					$ol .= '';
				}
			}
			$ol .= '';
			$inama_karyawan = $ol.'<br><small class="text-muted"><i>'.$this->lang->line('left_department').': '.$nama_department.'<i></i></i></small>';
			$ikode_ticket = $r->kode_ticket.'<br><small class="text-muted"><i>'.$status.'<i></i></i></small>';
			$ipriority = $priority.'<br><small class="text-muted"><i>'.$end_date.'<i></i></i></small>';
			$data[] = array(
				$combhr,
				$ikode_ticket,
				$inama_karyawan,
				$r->subject,
				$ipriority,
				$_created_at,
				$ticket_created_by
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $ticket->num_rows(),
			"recordsFiltered" => $ticket->num_rows(),
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
			$this->load->view("admin/tickets/list_ticket", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$comments = $this->Tickets_model->get_comments($id);
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
			if($karyawan[0]->user_role_id==1){
				$dlink = '<div class="media-right">
				<div class="c-rating">
				<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'">
				<a class="btn btn-outline-danger btn-xs delete" href="#" data-toggle="modal" data-target=".delete-modal" data-record-id="'.$r->comment_id.'">
				<i class="fas fa-trash-restore m-r-0-5"></i></a></span>
				</div>
				</div>';
			} else {
				$dlink = '';
			}
			$function = '<div class="c-item">
			<div class="media">
			<div class="media-left">
			<div class="avatar box-48">
			<img class="ui-w-30 b-a-radius-circle" src="'.$u_file.'">
			</div>
			</div>
			<div class="media-body">
			<div class="mb-0-5 ml-2">
			'.$link.'
			<span class="font-90 text-muted">'.$date.' '.$created_at.'</span>
			</div>
			<div class="c-text ml-2">'.$r->ticket_comments.'</div>
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
	
	public function list_attachment() {

		$data['title'] = $this->Umb_model->site_title();
		//$id = $this->input->get('ticket_id');
		$id = $this->uri->segment(4);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/tickets/list_ticket", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$attachments = $this->Tickets_model->get_attachments($id);
		if($attachments->num_rows() > 0) {
			$data = array();
			foreach($attachments->result() as $r) {
				$karyawan = $this->Umb_model->read_user_info($r->upload_by);	 			  				
				if($karyawan[0]->user_role_id==1){
					$delopt = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn btn-outline-danger btn-sm m-b-0-0 waves-effect waves-light delete-file" data-toggle="modal" data-target=".delete-modal-file" data-record-id="'. $r->ticket_attachment_id . '"><i class="fas fa-trash-restore-o"></i></button></span>';	
				} else {
					$delopt = '';
				}
				$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_download').'"><a href="'.site_url().'admin/download?type=ticket&filename='.$r->attachment_file.'"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light"><i class="oi oi-cloud-download"></i></button></a></span>'.$delopt,
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
	
	public function read() {

		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('ticket_id');
		$result = $this->Tickets_model->read_informasi_ticket($id);
		$data = array(
			'ticket_id' => $result[0]->ticket_id,
			'perusahaan_id' => $result[0]->perusahaan_id,
			'kode_ticket' => $result[0]->kode_ticket,
			'subject' => $result[0]->subject,
			'karyawan_id' => $result[0]->karyawan_id,
			'ticket_priority' => $result[0]->ticket_priority,
			'all_perusahaans' => $this->Umb_model->get_perusahaans(),
			'description' => $result[0]->description,
			'all_karyawans' => $this->Umb_model->all_karyawans(),
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/tickets/dialog_ticket', $data);
		} else {
			redirect('admin/');
		}
	}
	
	public function add_ticket() {
		
		if($this->input->post('add_type')=='ticket') {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$assigned_to = $this->input->post('karyawan_id');
			if($this->input->post('perusahaan')==='') {
				$Return['error'] = $this->lang->line('umb_error_perusahaan');
			} else if($this->input->post('subject')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_subject');
			} else if($this->input->post('department_id')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_department');
			} else if(empty($assigned_to)) {
				$Return['error'] = $this->lang->line('umb_error_karyawan_id');
			} else if($this->input->post('ticket_priority')==='') {
				$Return['error'] = $this->lang->line('umb_error_ticket_priority');
			} else if($this->input->post('end_date')==='') {
				$Return['error'] = $this->lang->line('umb_error_end_date');
			} 
			$description = $this->input->post('description');
			$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
			if($Return['error']!=''){
				$this->output($Return);
			}
			if($_FILES['attachment']['size'] > 0) {
				if(is_uploaded_file($_FILES['attachment']['tmp_name'])) {
					$allowed =  array('png','jpg','jpeg','pdf','gif');
					$filename = $_FILES['attachment']['name'];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);
					if(in_array($ext,$allowed)){
						$tmp_name = $_FILES["attachment"]["tmp_name"];
						$profile = "uploads/ticket/";
						$set_img = base_url()."uploads/ticket/";
						$name = basename($_FILES["attachment"]["name"]);
						$newfilename = 'ticket_attachment_'.round(microtime(true)).'.'.$ext;
						move_uploaded_file($tmp_name, $profile.$newfilename);
						$fname = $newfilename;			
					} else {
						$Return['error'] = $this->lang->line('umb_error_attatchment_type');
					}
				}
			} else {
				$fname = '0';
			}
			$kode_ticket = $this->Umb_model->generate_random_string();
			$module_attributes = $this->Custom_fields_model->tickets_hrastral_module_attributes();
			$count_module_attributes = $this->Custom_fields_model->count_tickets_module_attributes();	
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
			$assigned_ids = implode(',',$this->input->post('karyawan_id'));
			$karyawan_ids = $assigned_ids;
			$session = $this->session->userdata('username');
			$data = array(
				'kode_ticket' => $kode_ticket,
				'subject' => $this->input->post('subject'),
				'perusahaan_id' => $this->input->post('perusahaan'),
				'department_id' => $this->input->post('department_id'),
				'ticket_image' => $fname,
				'end_date' => $this->input->post('end_date'),
				'description' => $qt_description,
				'status_ticket' => '1',
				'is_notify' => '1',
				'ticket_priority' => $this->input->post('ticket_priority'),
				'created_by' => $session['user_id'],
				'created_at' => date('d-m-Y h:i:s'),
			);
			$iresult = $this->Tickets_model->add($data);
			if ($iresult) {
				$Return['result'] = $this->lang->line('umb_sukses_ticket_created');
				foreach($this->input->post('karyawan_id') as $ticket_emp){
					$eticket_data = array(
						'ticket_id' => $iresult,
						'karyawan_id' => $ticket_emp,
						'is_notify' => '1',
						'created_at' => date('d-m-Y h:i:s'),
					);
					$eresult = $this->Tickets_model->add_ticket_karyawans($eticket_data);
				}
				foreach($this->input->post('karyawan_id') as $ticket_emp){
					$nticket_data = array(
						'module_name' => 'tickets',
						'module_id' => $iresult,
						'karyawan_id' => $ticket_emp,
						'is_notify' => '1',
						'created_at' => date('d-m-Y h:i:s'),
					);
					$this->Umb_model->add_notifications($nticket_data);
				}
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
				if($setting[0]->enable_email_notification == 'yes') {
					$this->email->set_mailtype("html");
					$cinfo = $this->Umb_model->read_info_setting_perusahaan(1);
					$template = $this->Umb_model->read_email_template(15);
					$user_info = $this->Umb_model->read_user_info($this->input->post('karyawan_id'));
					$full_name = $user_info[0]->first_name.' '.$user_info[0]->last_name;
					$subject = str_replace('{var kode_ticket}',$kode_ticket,$template[0]->subject);
					$logo = base_url().'uploads/logo/signin/'.$cinfo[0]->sign_in_logo;
					$message = '
					<div style="background:#f6f6f6;font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;margin:0;padding:0;padding: 20px;">
					<img src="'.$logo.'" title="'.$cinfo[0]->nama_perusahaan.'"><br>'.str_replace(array("{var site_name}","{var site_url}","{var kode_ticket}"),array($cinfo[0]->nama_perusahaan,site_url(),$kode_ticket),htmlspecialchars_decode(stripslashes($template[0]->message))).'</div>';
					hrastral_mail($user_info[0]->email,$full_name,$cinfo[0]->email,$subject,$message);
				}		
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
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
				'ticket_comments' => $qt_umb_comment,
				'ticket_id' => $this->input->post('comment_ticket_id'),
				'user_id' => $this->input->post('user_id'),
				'created_at' => date('d-m-Y h:i:s')
			);
			$result = $this->Tickets_model->add_comment($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_ticket_comment_ditambahkan');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
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

				$allowed =  array('png','jpg','jpeg','pdf','doc','docx','xls','xlsx','txt');
				$filename = $_FILES['attachment_file']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				if(in_array($ext,$allowed)){
					$tmp_name = $_FILES["attachment_file"]["tmp_name"];
					$attachment_file = "uploads/ticket/";
					$name = basename($_FILES["attachment_file"]["name"]);
					$newfilename = 'ticket_'.round(microtime(true)).'.'.$ext;
					move_uploaded_file($tmp_name, $attachment_file.$newfilename);
					$fname = $newfilename;
				} else {
					$Return['error'] = $this->lang->line('umb_error_file_attachment_tugas');
				}
			}
			$data = array(
				'ticket_id' => $this->input->post('c_ticket_id'),
				'upload_by' => $this->input->post('user_file_id'),
				'file_title' => $this->input->post('file_name'),
				'file_description' => $file_description,
				'attachment_file' => $fname,
				'created_at' => date('d-m-Y h:i:s')
			);
			$result = $this->Tickets_model->add_new_attachment($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_ticket_attachment_ditambahkan');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function update() {

		if($this->input->post('edit_type')=='ticket') {

			$id = $this->uri->segment(4);
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			if($this->input->post('subject')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_subject');
			} else if($this->input->post('ticket_priority')==='') {
				$Return['error'] = $this->lang->line('umb_error_ticket_priority');
			}
			$description = $this->input->post('description');
			$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
			if($Return['error']!=''){
				$this->output($Return);
			}
			$module_attributes = $this->Custom_fields_model->tickets_hrastral_module_attributes();
			$count_module_attributes = $this->Custom_fields_model->count_tickets_module_attributes();	
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
				'subject' => $this->input->post('subject'),
				'description' => $qt_description,
				'ticket_priority' => $this->input->post('ticket_priority')
			);
			$result = $this->Tickets_model->update_record($data,$id);		

			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_ticket_diperbarui');
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
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function details() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		$id = $this->uri->segment(4);
		$result = $this->Tickets_model->read_informasi_ticket($id);
		if(is_null($result)){
			redirect('admin/tickets');
		}
		$edata = array(
			'is_notify' => 0,
		);
		$this->Umb_model->update_notification_record($edata,$id,$session['user_id'],'tickets');
		$user = $this->Umb_model->read_user_info($result[0]->created_by);
		if(!is_null($user)){
			$full_name = $user[0]->first_name.' '.$user[0]->last_name;
		} else {
			$full_name = '--';	
		}
		$data = array(
			'title' => $this->Umb_model->site_title(),
			'ticket_id' => $result[0]->ticket_id,
			'subject' => $result[0]->subject,
			'kode_ticket' => $result[0]->kode_ticket,
			'end_date' => $result[0]->end_date,
			'ticket_image' => $result[0]->ticket_image,
			'department_id' => $result[0]->department_id,
			'full_name' => $full_name,
			'ticket_priority' => $result[0]->ticket_priority,
			'created_at' => $result[0]->created_at,
			'description' => $result[0]->description,
			'assigned_to' => $result[0]->assigned_to,
			'status_ticket' => $result[0]->status_ticket,
			'ticket_note' => $result[0]->ticket_note,
			'ticket_remarks' => $result[0]->ticket_remarks,
			'message' => $result[0]->message,
			'all_karyawans' => $this->Umb_model->all_karyawans(),
		);
		$data['breadcrumbs'] = $this->lang->line('umb_details_ticket');
		$data['path_url'] = 'tickets_detail';
		$session = $this->session->userdata('username');
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(!empty($session)){ 
			$data['subview'] = $this->load->view("admin/tickets/details_ticket", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
		} else {
			redirect('admin/');
		}		  
	}

	public function assign_ticket() {

		if($this->input->post('type')=='ticket_user') {		

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
			$id = $this->input->post('ticket_id');
			$result = $this->Tickets_model->assign_ticket_user($data,$id);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_ticket_assigned_karyawan');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function update_status() {

		if($this->input->post('type')=='update_status') {		
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();	
			$data = array(
				'status_ticket' => $this->input->post('status'),
				'ticket_remarks' => $this->input->post('remarks'),
			);
			$id = $this->input->post('status_ticket_id');
			$result = $this->Tickets_model->update_status($data,$id);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_status_ticket_diperbarui');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function add_note() {

		if($this->input->post('type')=='add_note') {		
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();	
			$data = array(
				'ticket_note' => $this->input->post('ticket_note')
			);
			$id = $this->input->post('token_note_id');
			$result = $this->Tickets_model->update_note($data,$id);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_ticket_note_diperbarui');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function ticket_users() {

		$data['title'] = $this->Umb_model->site_title();
		$id = $this->uri->segment(4);
		$data = array(
			'ticket_id' => $id,
			'all_penunjukans' => $this->Penunjukan_model->all_penunjukans(),
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/tickets/get_ticket_users", $data);
		} else {
			redirect('');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}

	public function delete() {
		if($this->input->post('is_ajax') == 2) {

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Tickets_model->delete_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_sukses_ticket_dihapus');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}

	public function delete_comment() {
		
		if($this->input->post('data') == 'ticket_comment') {

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Tickets_model->delete_record_comment($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_sukses_ticket_comment_dihapus');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}

	public function delete_attachment() {
		if($this->input->post('data') == 'ticket_attachment') {

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Tickets_model->delete_record_attachment($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_sukses_ticket_attachment_dihapus');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}
}
