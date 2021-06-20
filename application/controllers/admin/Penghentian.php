<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Penghentian extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		
		$this->load->model("Penghentian_model");
		$this->load->model("Department_model");
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
		$data['title'] = $this->lang->line('left_penghentians').' | '.$this->Umb_model->site_title();
		$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		$data['get_all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$data['all_types_penghentian'] = $this->Penghentian_model->all_types_penghentian();
		$data['breadcrumbs'] = $this->lang->line('left_penghentians');
		$data['path_url'] = 'penghentian';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('21',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/penghentian/list_penghentian", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}	
	}
	
	public function list_penghentian() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/penghentian/list_penghentian", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$role_resources_ids = $this->Umb_model->user_role_resource();
		$user_info = $this->Umb_model->read_user_info($session['user_id']);
		if($user_info[0]->user_role_id==1){
			$penghentian = $this->Penghentian_model->get_penghentians();
		} else {
			if(in_array('239',$role_resources_ids)) {
				$penghentian = $this->Penghentian_model->get_penghentians_perusahaan($user_info[0]->perusahaan_id);
			} else {
				$penghentian = $this->Penghentian_model->get_penghentian_karyawan($session['user_id']);
			}
		}
		$data = array();

		foreach($penghentian->result() as $r) {
			$euser = $this->Umb_model->read_user_info($r->karyawan_id);
			if(!is_null($euser)){
				$ful_name = $euser[0]->first_name.' '.$euser[0]->last_name;
			} else {
				$ful_name = '--';	
			}
			$tangggal_pemberitahuan = $this->Umb_model->set_date_format($r->tangggal_pemberitahuan);
			$tanggal_penghentian = $this->Umb_model->set_date_format($r->tanggal_penghentian);
			if($r->status==0): 
				$status = '<span class="badge bg-orange">'.$this->lang->line('umb_pending').'</span>';
			elseif($r->status==1): 
				$status = '<span class="badge bg-green">'.$this->lang->line('umb_accepted').'</span>';
			else: 
				$status = '<span class="badge bg-red">'.$this->lang->line('umb_rejected').'</span>'; 
			endif;
			$type_penghentian = $this->Penghentian_model->read_infomasi_type_penghentian($r->type_penghentian_id);
			if(!is_null($type_penghentian)){
				$ttype = $type_penghentian[0]->type;
			} else {
				$ttype = '--';	
			}
			$perusahaan = $this->Umb_model->read_info_perusahaan($r->perusahaan_id);
			if(!is_null($perusahaan)){
				$prshn_nama = $perusahaan[0]->name;
			} else {
				$prshn_nama = '--';	
			}
			if(in_array('229',$role_resources_ids)) {
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-penghentian_id="'. $r->penghentian_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('230',$role_resources_ids)) {
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger"" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger" waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->penghentian_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}
			if(in_array('239',$role_resources_ids)) {
				$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target="#modals-slide" data-penghentian_id="'. $r->penghentian_id . '"><span class="fa fa-eye"></span></button></span>';
			} else {
				$view = '';
			}
			$iful_name = $ful_name.'<br><small class="text-muted"><i>'.$ttype.'<i></i></i></small><br><small class="text-muted"><i>'.$status.'<i></i></i></small>';
			$combhr = $edit.$view.$delete;
			$data[] = array(
				$combhr,
				$iful_name,
				$prshn_nama,
				$tangggal_pemberitahuan,
				$tanggal_penghentian
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $penghentian->num_rows(),
			"recordsFiltered" => $penghentian->num_rows(),
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
			$this->load->view("admin/penghentian/get_karyawans", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	} 

	public function read() {

		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('penghentian_id');
		$result = $this->Penghentian_model->read_informasi_penghentian($id);
		$data = array(
			'penghentian_id' => $result[0]->penghentian_id,
			'karyawan_id' => $result[0]->karyawan_id,
			'perusahaan_id' => $result[0]->perusahaan_id,
			'diberhentikan_oleh' => $result[0]->diberhentikan_oleh,
			'type_penghentian_id' => $result[0]->type_penghentian_id,
			'tanggal_penghentian' => $result[0]->tanggal_penghentian,
			'tangggal_pemberitahuan' => $result[0]->tangggal_pemberitahuan,
			'description' => $result[0]->description,
			'status' => $result[0]->status,
			'attachment' => $result[0]->attachment,
			'all_karyawans' => $this->Umb_model->all_karyawans(),
			'get_all_perusahaans' => $this->Umb_model->get_perusahaans(),
			'all_types_penghentian' => $this->Penghentian_model->all_types_penghentian()
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/penghentian/dialog_penghentian', $data);
		} else {
			redirect('admin/');
		}
	}

	public function add_penghentian() {

		if($this->input->post('add_type')=='penghentian') {		
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$tangggal_pemberitahuan = $this->input->post('tangggal_pemberitahuan');
			$tanggal_penghentian = $this->input->post('tanggal_penghentian');
			$nt_date = strtotime($tangggal_pemberitahuan);
			$tt_date = strtotime($tanggal_penghentian);
			$description = $this->input->post('description');
			$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
			if($this->input->post('perusahaan_id')==='') {
				$Return['error'] = $this->lang->line('error_field_perusahaan');
			} else if($this->input->post('karyawan_id')==='') {
				$Return['error'] = $this->lang->line('umb_error_karyawan_id');
			} else if($this->input->post('tangggal_pemberitahuan')==='') {
				$Return['error'] = $this->lang->line('umb_error_tangggal_pemberitahuan_pengunduran_diri');
			} else if($this->input->post('tanggal_penghentian')==='') {
				$Return['error'] = $this->lang->line('umb_error_tanggal_penghentian');
			} else if($nt_date > $tt_date) {
				$Return['error'] = $this->lang->line('umb_error_penghentian_tangggal_pemberitahuan_less');
			} else if($this->input->post('type')==='') {
				$Return['error'] = $this->lang->line('umb_error_type_penghentian');
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
					$profile = "uploads/penghentian/";
					$set_img = base_url()."uploads/penghentian/";
					$name = basename($_FILES["attachment"]["name"]);
					$newfilename = 'penghentian_'.round(microtime(true)).'.'.$ext;
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
				'tangggal_pemberitahuan' => $this->input->post('tangggal_pemberitahuan'),
				'description' => $qt_description,
				'attachment' => $fname,
				'tanggal_penghentian' => $this->input->post('tanggal_penghentian'),
				'type_penghentian_id' => $this->input->post('type'),
				'diberhentikan_oleh' => $this->input->post('user_id'),
				'status' => '0',
				'created_at' => date('d-m-Y'),
			);
			$result = $this->Penghentian_model->add($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_penghentian_ditambahkan');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function update() {

		if($this->input->post('edit_type')=='penghentian') {

			$id = $this->uri->segment(4);
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$tangggal_pemberitahuan = $this->input->post('tangggal_pemberitahuan');
			$tanggal_penghentian = $this->input->post('tanggal_penghentian');
			$nt_date = strtotime($tangggal_pemberitahuan);
			$tt_date = strtotime($tanggal_penghentian);
			$description = $this->input->post('description');
			$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
			if($this->input->post('tangggal_pemberitahuan')==='') {
				$Return['error'] = $this->lang->line('umb_error_tangggal_pemberitahuan_pengunduran_diri');
			} else if($this->input->post('tanggal_penghentian')==='') {
				$Return['error'] = $this->lang->line('umb_error_tanggal_penghentian');
			} else if($nt_date > $tt_date) {
				$Return['error'] = $this->lang->line('umb_error_penghentian_tangggal_pemberitahuan_less');
			} else if($this->input->post('type')==='') {
				$Return['error'] = $this->lang->line('umb_error_type_penghentian');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$data = array(
				'tangggal_pemberitahuan' => $this->input->post('tangggal_pemberitahuan'),
				'description' => $qt_description,
				'tanggal_penghentian' => $this->input->post('tanggal_penghentian'),
				'type_penghentian_id' => $this->input->post('type'),
				'status' => $this->input->post('status'),
			);
			$result = $this->Penghentian_model->update_record($data,$id);		

			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_penghentian_diperbarui');
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
		$result = $this->Penghentian_model->delete_record($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('umb_sukses_penghentian_dihapus');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
	}
}
