<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pengunduran_diri extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		
		$this->load->model("Pengunduran_diri_model");
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
		$data['title'] = $this->lang->line('left_pengundurans_diri').' | '.$this->Umb_model->site_title();
		$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		$data['get_all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$data['breadcrumbs'] = $this->lang->line('left_pengundurans_diri');
		$data['path_url'] = 'pengunduran_iri';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('16',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/pengunduran_diri/list_pengunduran_diri", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}
	
	public function list_pengunduran_diri() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/pengunduran_diri/list_pengunduran_diri", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$role_resources_ids = $this->Umb_model->user_role_resource();
		$user_info = $this->Umb_model->read_user_info($session['user_id']);
		if($user_info[0]->user_role_id==1){
			$pengunduran_diri = $this->Pengunduran_diri_model->get_pengundurans_diri();
		} else {
			if(in_array('234',$role_resources_ids)) {
				$pengunduran_diri = $this->Pengunduran_diri_model->get_perusahaan_pengundurans_diri($user_info[0]->perusahaan_id);
			} else {
				$pengunduran_diri = $this->Pengunduran_diri_model->get_pengunduran_diri_karyawan($session['user_id']);
			}
		}
		$role_resources_ids = $this->Umb_model->user_role_resource();
		$data = array();

		foreach($pengunduran_diri->result() as $r) {
			
			$user = $this->Umb_model->read_user_info($r->added_by);
			if(!is_null($user)){
				$full_name = $user[0]->first_name.' '.$user[0]->last_name;
			} else {
				$full_name = '--';	
			}
			
			$karyawan = $this->Umb_model->read_user_info($r->karyawan_id);
			if(!is_null($karyawan)){
				$nama_karyawan = $karyawan[0]->first_name.' '.$karyawan[0]->last_name;
			} else {
				$nama_karyawan = '--';	
			}
			$tangggal_pemberitahuan = $this->Umb_model->set_date_format($r->tangggal_pemberitahuan);
			$tanggal_pengunduran_diri = $this->Umb_model->set_date_format($r->tanggal_pengunduran_diri);
			$perusahaan = $this->Umb_model->read_info_perusahaan($r->perusahaan_id);
			if(!is_null($perusahaan)){
				$prshn_nama = $perusahaan[0]->name;
			} else {
				$prshn_nama = '--';	
			}
			if(in_array('214',$role_resources_ids)) {
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-pengunduran_diri_id="'. $r->pengunduran_diri_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('215',$role_resources_ids)) {
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->pengunduran_diri_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}
			if(in_array('234',$role_resources_ids)) {
				$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target="#modals-slide" data-pengunduran_diri_id="'. $r->pengunduran_diri_id . '"><span class="fa fa-eye"></span></button></span>';
			} else {
				$view = '';
			}
			$combhr = $edit.$view.$delete;
			if($r->status == 0){
				$app_status = $this->lang->line('umb_not_approve_payroll_title');
			} else if($r->status == 1){
				$app_status = $this->lang->line('umb_manager_level_title');
			} else if($r->status == 2){
				$app_status = $this->lang->line('umb_hrd_level_title');
			} else if($r->status == 3){
				$app_status = $this->lang->line('umb_gm_om_level_title');
			} else {
				$app_status = $this->lang->line('umb_not_approve_payroll_title');
			}
			$inama_karyawan = $nama_karyawan.'<br><small class="text-muted"><i>'.$this->lang->line('umb_alasan').': '.$r->reason.'<i></i></i></small>'.'<br><small class="text-muted"><i>'.$app_status.'<i></i></i></small>';

			$data[] = array(
				$combhr,
				$inama_karyawan,
				$prshn_nama,
				$tangggal_pemberitahuan,
				$tanggal_pengunduran_diri
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $pengunduran_diri->num_rows(),
			"recordsFiltered" => $pengunduran_diri->num_rows(),
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
			$this->load->view("admin/pengunduran_diri/get_karyawans", $data);
		} else {
			redirect('admin/');
		}

		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	} 

	public function read() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('pengunduran_diri_id');
		$result = $this->Pengunduran_diri_model->read_informasi_pengunduran_diri($id);
		$data = array(
			'pengunduran_diri_id' => $result[0]->pengunduran_diri_id,
			'perusahaan_id' => $result[0]->perusahaan_id,
			'karyawan_id' => $result[0]->karyawan_id,
			'approval_status' => $result[0]->status,
			'tangggal_pemberitahuan' => $result[0]->tangggal_pemberitahuan,
			'tanggal_pengunduran_diri' => $result[0]->tanggal_pengunduran_diri,
			'reason' => $result[0]->reason,
			'all_karyawans' => $this->Umb_model->all_karyawans(),
			'get_all_perusahaans' => $this->Umb_model->get_perusahaans()
		);
		if(!empty($session)){ 
			$this->load->view('admin/pengunduran_diri/dialog_pengunduran_diri', $data);
		} else {
			redirect('admin/');
		}
	}


	public function add_pengunduran_diri() {

		if($this->input->post('add_type')=='pengunduran_diri') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();

			$reason = $this->input->post('reason');
			$qt_reason = htmlspecialchars(addslashes($reason), ENT_QUOTES);

			if($this->input->post('perusahaan_id')==='') {
				$Return['error'] = $this->lang->line('error_field_perusahaan');
			} else if($this->input->post('karyawan_id')==='') {
				$Return['error'] = $this->lang->line('umb_error_karyawan_id');
			} else if($this->input->post('tangggal_pemberitahuan')==='') {
				$Return['error'] = $this->lang->line('umb_error_tangggal_pemberitahuan_pengunduran_diri');
			} else if($this->input->post('tanggal_pengunduran_diri')==='') {
				$Return['error'] = $this->lang->line('umb_error_tanggal_pengunduran_diri');
			}

			if($Return['error']!=''){
				$this->output($Return);
			}

			$data = array(
				'karyawan_id' => $this->input->post('karyawan_id'),
				'perusahaan_id' => $this->input->post('perusahaan_id'),
				'tangggal_pemberitahuan' => $this->input->post('tangggal_pemberitahuan'),
				'tanggal_pengunduran_diri' => $this->input->post('tanggal_pengunduran_diri'),
				'reason' => $qt_reason,
				'added_by' => $this->input->post('user_id'),
				'created_at' => date('d-m-Y'),

			);
			$result = $this->Pengunduran_diri_model->add($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_pengunduran_diri_ditambahkan');			
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}


	public function update() {

		if($this->input->post('edit_type')=='pengunduran_diri') {

			$id = $this->uri->segment(4);

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();

			$reason = $this->input->post('reason');
			$qt_reason = htmlspecialchars(addslashes($reason), ENT_QUOTES);

			if($this->input->post('tangggal_pemberitahuan')==='') {
				$Return['error'] = $this->lang->line('umb_error_tangggal_pemberitahuan_pengunduran_diri');
			} else if($this->input->post('tanggal_pengunduran_diri')==='') {
				$Return['error'] = $this->lang->line('umb_error_tanggal_pengunduran_diri');
			} else if($this->input->post('status')==='') {
				$Return['error'] = $this->lang->line('umb_error_template_status');
			}

			if($Return['error']!=''){
				$this->output($Return);
			}

			$data = array(
				'tangggal_pemberitahuan' => $this->input->post('tangggal_pemberitahuan'),
				'tanggal_pengunduran_diri' => $this->input->post('tanggal_pengunduran_diri'),
				'status' => $this->input->post('status'),
				'reason' => $qt_reason,
			);
			$result = $this->Pengunduran_diri_model->update_record($data,$id);		

			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_pengunduran_diri_diperbarui');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function delete() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}

		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$result = $this->Pengunduran_diri_model->delete_record($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('umb_sukses_pengunduran_diri_dihapus');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
	}
}
