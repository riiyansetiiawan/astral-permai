<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Karyawan_exit extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		
		$this->load->model("Karyawan_exit_model");
		$this->load->model("Umb_model");
		$this->load->model("Department_model");
		$this->load->model("Karyawans_model");
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
		$data['title'] = $this->lang->line('left_karyawans_exit').' | '.$this->Umb_model->site_title();
		$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		$data['all_types_exit'] = $this->Karyawan_exit_model->all_types_exit();
		$data['get_all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$data['breadcrumbs'] = $this->lang->line('left_karyawans_exit');
		$data['path_url'] = 'karyawan_exit';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('23',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/exit/list_exit", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}

	public function list_exit() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/exit/list_exit", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		if($this->input->get("ihr")=='true'){
			if($this->input->get("perusahaan_id")==0 && $this->input->get("karyawan_id")==0 && $this->input->get("status")=='all'){
				$exit = $this->Karyawan_exit_model->get_exit();
			} else if($this->input->get("perusahaan_id")!=0 && $this->input->get("karyawan_id")==0 && $this->input->get("status")=='all'){
				$exit = $this->Karyawan_exit_model->filter_perusahaan_exit($this->input->get("perusahaan_id"));
			} else if($this->input->get("perusahaan_id")!=0 && $this->input->get("karyawan_id")!=0 && $this->input->get("status")=='all'){
				$exit = $this->Karyawan_exit_model->filter_perusahaan_karyawan_exit($this->input->get("perusahaan_id"),$this->input->get("karyawan_id"));
			} else if($this->input->get("perusahaan_id")!=0 && $this->input->get("karyawan_id")!=0 && $this->input->get("status")!='all'){
				$exit = $this->Karyawan_exit_model->filter_perusahaan_status_karyawan_exit($this->input->get("perusahaan_id"),$this->input->get("karyawan_id"),$this->input->get("status"));
			} else if($this->input->get("perusahaan_id")!=0 && $this->input->get("karyawan_id")==0 && $this->input->get("status")!='all'){
				$exit = $this->Karyawan_exit_model->filter_perusahaan_status_karyawan_tidak_exit($this->input->get("perusahaan_id"),$this->input->get("status"));
			}
		} else {
			$exit = $this->Karyawan_exit_model->get_exit();
		}
		$data = array();

		$role_resources_ids = $this->Umb_model->user_role_resource();
		foreach($exit->result() as $r) {

			$user = $this->Umb_model->read_user_info($r->karyawan_id);

			if(!is_null($user)){
				$full_name = $user[0]->first_name.' '.$user[0]->last_name;
			} else {
				$full_name = '--';	
			}

			$user_by = $this->Umb_model->read_user_info($r->added_by);

			if(!is_null($user_by)){
				$added_by = $user_by[0]->first_name.' '.$user_by[0]->last_name;
			} else {
				$added_by = '--';	
			}

			$exit_tanggal = $this->Umb_model->set_date_format($r->exit_tanggal);

			$type_exit = $this->Karyawan_exit_model->read_informasi_type_exit($r->type_exit_id);
			if(!is_null($type_exit)){
				$etype = $type_exit[0]->type;
			} else {
				$etype = '--';	
			}

			$perusahaan = $this->Umb_model->read_info_perusahaan($r->perusahaan_id);
			if(!is_null($perusahaan)){
				$prshn_nama = $perusahaan[0]->name;
			} else {
				$prshn_nama = '--';	
			}
			if($r->exit_interview==0): $exit_interview = $this->lang->line('umb_no'); else: $exit_interview = $this->lang->line('umb_yes'); endif;
		//if($r->is_inactivate_account==0): $account = $this->lang->line('umb_no'); else: $account = $this->lang->line('umb_yes'); endif;

			if(in_array('205',$role_resources_ids)) {
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-exit_id="'. $r->exit_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('206',$role_resources_ids)) {
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->exit_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}
			if(in_array('231',$role_resources_ids)) {
				$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target="#modals-slide" data-exit_id="'. $r->exit_id . '"><span class="fa fa-eye"></span></button></span>';
			} else {
				$view = '';
			}
			$iful_name = $full_name.'<br><small class="text-muted"><i>'.$r->reason.'<i></i></i></small>';
			$combhr = $edit.$view.$delete;
			$data[] = array(
				$combhr,
				$iful_name,
				$prshn_nama,
				$etype,
				$exit_tanggal,
				$exit_interview
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $exit->num_rows(),
			"recordsFiltered" => $exit->num_rows(),
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
			$this->load->view("admin/exit/get_karyawans", $data);
		} else {
			redirect('admin/');
		}

		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}

	public function read()
	{
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('exit_id');
		$result = $this->Karyawan_exit_model->read_informasi_exit($id);
		$data = array(
			'exit_id' => $result[0]->exit_id,
			'karyawan_id' => $result[0]->karyawan_id,
			'perusahaan_id' => $result[0]->perusahaan_id,
			'exit_tanggal' => $result[0]->exit_tanggal,
			'type_exit_id' => $result[0]->type_exit_id,
			'exit_interview' => $result[0]->exit_interview,
			'is_inactivate_account' => $result[0]->is_inactivate_account,
			'reason' => $result[0]->reason,
			'all_karyawans' => $this->Umb_model->all_karyawans(),
			'all_types_exit' => $this->Karyawan_exit_model->all_types_exit(),
			'get_all_perusahaans' => $this->Umb_model->get_perusahaans()
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/exit/dialog_exit', $data);
		} else {
			redirect('admin/');
		}
	}


	public function add_exit() {

		if($this->input->post('add_type')=='exit') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();

			$reason = $this->input->post('reason');
			$qt_reason = htmlspecialchars(addslashes($reason), ENT_QUOTES);

			if($this->input->post('perusahaan_id')==='') {
				$Return['error'] = $this->lang->line('error_field_perusahaan');
			} else if($this->input->post('karyawan_id')==='') {
				$Return['error'] = $this->lang->line('umb_error_karyawan_id');
			} else if($this->input->post('exit_tanggal')==='') {
				$Return['error'] = $this->lang->line('umb_error_exit_tanggal');
			} else if($this->input->post('type')==='') {
				$Return['error'] = $this->lang->line('umb_error_type_exit');
			}

			if($Return['error']!=''){
				$this->output($Return);
			}

			$data = array(
				'karyawan_id' => $this->input->post('karyawan_id'),
				'perusahaan_id' => $this->input->post('perusahaan_id'),
				'exit_tanggal' => $this->input->post('exit_tanggal'),
				'reason' => $qt_reason,
				'type_exit_id' => $this->input->post('type'),
				'exit_interview' => $this->input->post('exit_interview'),
				'is_inactivate_account' => $this->input->post('is_inactivate_account'),
				'added_by' => $this->input->post('user_id'),
				'created_at' => date('d-m-Y'),
			);
			$result = $this->Karyawan_exit_model->add($data);
			if ($result == TRUE) {
				if($this->input->post('is_inactivate_account') == 1){
					$icdata = array(
						'is_active' => 0,
					);
					$this->Karyawans_model->basic_info($icdata,$this->input->post('karyawan_id'));
				} else {
					$icdata = array(
						'is_active' => 1,
					);
					$this->Karyawans_model->basic_info($icdata,$this->input->post('karyawan_id'));
				}

				$Return['result'] = $this->lang->line('umb_sukses_karyawan_exit_ditambahkan');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}


	public function update() {

		if($this->input->post('edit_type')=='exit') {

			$id = $this->uri->segment(4);

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();

			$reason = $this->input->post('reason');
			$qt_reason = htmlspecialchars(addslashes($reason), ENT_QUOTES);

			if($this->input->post('exit_tanggal')==='') {
				$Return['error'] = $this->lang->line('umb_error_exit_tanggal');
			} else if($this->input->post('type')==='') {
				$Return['error'] = $this->lang->line('umb_error_type_exit');
			}

			if($Return['error']!=''){
				$this->output($Return);
			}

			$data = array(
				'exit_tanggal' => $this->input->post('exit_tanggal'),
				'reason' => $qt_reason,
				'type_exit_id' => $this->input->post('type'),
				'exit_interview' => $this->input->post('exit_interview'),
				'is_inactivate_account' => $this->input->post('is_inactivate_account'),
			);

			$result = $this->Karyawan_exit_model->update_record($data,$id);		

			if ($result == TRUE) {
				if($this->input->post('is_inactivate_account') == 1){
					$icdata = array(
						'is_active' => 0,
					);
					$this->Karyawans_model->basic_info($icdata,$this->input->post('karyawan_id'));
				} else {
					$icdata = array(
						'is_active' => 1,
					);
					$this->Karyawans_model->basic_info($icdata,$this->input->post('karyawan_id'));
				}
				$Return['result'] = $this->lang->line('umb_sukses_karyawan_exit_diperbarui');
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
		$result = $this->Karyawan_exit_model->delete_record($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('umb_sukses_karyawan_exit_dihapus');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
	}
}
