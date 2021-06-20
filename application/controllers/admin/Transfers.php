<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Transfers extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		
		$this->load->model("Transfers_model");
		$this->load->model("Umb_model");
		$this->load->library('email');
		$this->load->model("Department_model");
		$this->load->model("Location_model");
		$this->load->model("Perusahaan_model");
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
		$data['title'] = $this->lang->line('umb_transfers').' | '.$this->Umb_model->site_title();
		$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		$data['all_locations'] = $this->Umb_model->all_locations();
		$data['get_all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$data['all_departments'] = $this->Department_model->all_departments();
		$data['breadcrumbs'] = $this->lang->line('umb_transfers');
		$data['path_url'] = 'transfers';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('15',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/transfers/list_transfer", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}
	
	public function list_transfer() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/transfers/list_transfer", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$role_resources_ids = $this->Umb_model->user_role_resource();
		/*if(in_array('373',$role_resources_ids)) {
			$transfer = $this->Transfers_model->get_karyawan_transfers($session['user_id']);
		} else {
			$transfer = $this->Transfers_model->get_transfers();
		}*/
		$user_info = $this->Umb_model->read_user_info($session['user_id']);
		if($user_info[0]->user_role_id==1){
			$transfer = $this->Transfers_model->get_transfers();
		} else {
			if(in_array('233',$role_resources_ids)) {
				$transfer = $this->Transfers_model->get_perusahaan_transfers($user_info[0]->perusahaan_id);
			} else {
				$transfer = $this->Transfers_model->get_karyawan_transfers($session['user_id']);
			}
		}
		$data = array();

		foreach($transfer->result() as $r) {
			$karyawan = $this->Umb_model->read_user_info($r->karyawan_id);
			if(!is_null($karyawan)){
				$nama_karyawan = $karyawan[0]->first_name.' '.$karyawan[0]->last_name;
			} else {
				$nama_karyawan = '--';	
			}
			$tanggal_transfer = $this->Umb_model->set_date_format($r->tanggal_transfer);
			$department = $this->Department_model->read_informasi_department($r->transfer_department);
			if(!is_null($department)){
				$nama_department = $department[0]->nama_department;
			} else {
				$nama_department = '--';	
			}
			$location = $this->Location_model->read_informasi_location($r->transfer_location);
			if(!is_null($location)){
				$nama_location = $location[0]->nama_location;
			} else {
				$nama_location = '--';	
			}
			if($r->status==0): 
				$status = '<span class="badge bg-orange">'.$this->lang->line('umb_pending').'</span>';
			elseif($r->status==1): 
				$status = '<span class="badge bg-green">'.$this->lang->line('umb_accepted').'</span>';
			else: 
				$status = '<span class="badge bg-red">'.$this->lang->line('umb_rejected').'</span>'; 
			endif;

			$perusahaan = $this->Umb_model->read_info_perusahaan($r->perusahaan_id);
			if(!is_null($perusahaan)){
				$prshn_nama = $perusahaan[0]->name;
			} else {
				$prshn_nama = '--';	
			}

			if(in_array('211',$role_resources_ids)) {
				$edit = '<span data-toggle="tooltip" data-placement="top"  data-state="primary" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-transfer_id="'. $r->transfer_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('212',$role_resources_ids)) {
				$delete = '<span data-toggle="tooltip" data-placement="top"  data-state="danger" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->transfer_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}
			if(in_array('233',$role_resources_ids)) {
				$view = '<span data-toggle="tooltip" data-placement="top"  data-state="primary" title="'.$this->lang->line('umb_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target="#modals-slide" data-transfer_id="'. $r->transfer_id . '"><span class="fa fa-eye"></span></button></span>';
			} else {
				$view = '';
			}
			$combhr = $edit.$view.$delete;
			$inama_karyawan = $nama_karyawan.'<br><small class="text-muted"><i>'.$this->lang->line('umb_transfer_to_department').': '.$nama_department.'<i></i></i></small><br><small class="text-muted"><i>'.$this->lang->line('umb_transfer_to_location').': '.$nama_location.'<i></i></i></small>';
			
			$data[] = array(
				$combhr,
				$inama_karyawan,
				$prshn_nama,
				$tanggal_transfer,
				$status
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $transfer->num_rows(),
			"recordsFiltered" => $transfer->num_rows(),
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
		$id = $this->input->get('transfer_id');
		$result = $this->Transfers_model->read_informasi_transfer($id);
		$data = array(
			'transfer_id' => $result[0]->transfer_id,
			'perusahaan_id' => $result[0]->perusahaan_id,
			'karyawan_id' => $result[0]->karyawan_id,
			'tanggal_transfer' => $result[0]->tanggal_transfer,
			'transfer_department' => $result[0]->transfer_department,
			'transfer_location' => $result[0]->transfer_location,
			'description' => $result[0]->description,
			'status' => $result[0]->status,
			'all_karyawans' => $this->Umb_model->all_karyawans(),
			'all_locations' => $this->Umb_model->all_locations(),
			'get_all_perusahaans' => $this->Umb_model->get_perusahaans(),
			'all_departments' => $this->Department_model->all_departments()
		);
		if(!empty($session)){ 
			$this->load->view('admin/transfers/dialog_transfer', $data);
		} else {
			redirect('admin/');
		}
	}
	
	public function get_departments() {

		$data['title'] = $this->Umb_model->site_title();
		$id = $this->uri->segment(4);
		$data = array(
			'perusahaan_id' => $id
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/transfers/get_departments", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}
	
	public function get_locations() {

		$data['title'] = $this->Umb_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'location_id' => $id,
			'all_locations' => $this->Umb_model->all_locations(),
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/transfers/get_locations", $data);
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
			$this->load->view("admin/transfers/get_karyawans", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}
	
	public function add_transfer() {
		
		if($this->input->post('add_type')=='transfer') {		
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$description = $this->input->post('description');
			$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
			if($this->input->post('perusahaan_id')==='') {
				$Return['error'] = $this->lang->line('error_field_perusahaan');
			} else if($this->input->post('karyawan_id')==='') {
				$Return['error'] = $this->lang->line('umb_error_karyawan_id');
			} else if($this->input->post('tanggal_transfer')==='') {
				$Return['error'] = $this->lang->line('umb_transfers_error_date');
			} else if($this->input->post('transfer_department')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_department');
			} else if($this->input->post('transfer_location')==='') {
				$Return['error'] = $this->lang->line('error_field_location_dept');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$data = array(
				'karyawan_id' => $this->input->post('karyawan_id'),
				'perusahaan_id' => $this->input->post('perusahaan_id'),
				'tanggal_transfer' => $this->input->post('tanggal_transfer'),
				'transfer_department' => $this->input->post('transfer_department'),
				'description' => $qt_description,
				'transfer_location' => $this->input->post('transfer_location'),
				'added_by' => $this->input->post('user_id'),
				'created_at' => date('d-m-Y'),
				
			);
			$result = $this->Transfers_model->add($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_transfers_sukses_ditambahkan');
				$setting = $this->Umb_model->read_setting_info(1);
				if($setting[0]->enable_email_notification == 'yes') {
					
					$this->email->set_mailtype("html");
					$cinfo = $this->Umb_model->read_info_setting_perusahaan(1);
					$template = $this->Umb_model->read_email_template(9);
					$user_info = $this->Umb_model->read_user_info($this->input->post('karyawan_id'));
					$full_name = $user_info[0]->first_name.' '.$user_info[0]->last_name;
					$subject = $template[0]->subject.' - '.$cinfo[0]->nama_perusahaan;
					$logo = base_url().'uploads/logo/signin/'.$cinfo[0]->sign_in_logo;
					$message = '
					<div style="background:#f6f6f6;font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;margin:0;padding:0;padding: 20px;">
					<img src="'.$logo.'" title="'.$cinfo[0]->nama_perusahaan.'"><br>'.str_replace(array("{var site_name}","{var site_url}","{var nama_karyawan}"),array($cinfo[0]->nama_perusahaan,site_url(),$full_name),htmlspecialchars_decode(stripslashes($template[0]->message))).'</div>';
					hrastral_mail($cinfo[0]->email,$cinfo[0]->nama_perusahaan,$user_info[0]->email,$subject,$message);
				}
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function update() {
		
		if($this->input->post('edit_type')=='transfer') {
			$id = $this->uri->segment(4);			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();			
			$description = $this->input->post('description');
			$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
			if($this->input->post('tanggal_transfer')==='') {
				$Return['error'] = $this->lang->line('umb_transfers_error_date');
			} else if($this->input->post('transfer_department')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_department');
			} else if($this->input->post('transfer_location')==='') {
				$Return['error'] = $this->lang->line('error_field_location_dept');
			}
			
			if($Return['error']!=''){
				$this->output($Return);
			}
			$data = array(
				'tanggal_transfer' => $this->input->post('tanggal_transfer'),
				'transfer_department' => $this->input->post('transfer_department'),
				'description' => $qt_description,
				'transfer_location' => $this->input->post('transfer_location'),
				'status' => $this->input->post('status'),
			);
			$result = $this->Transfers_model->update_record($data,$id);		
			
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_transfers_sukses_diperbarui');
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
		$result = $this->Transfers_model->delete_record($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('umb_transfers_sukses_dihapus');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
	}
}
