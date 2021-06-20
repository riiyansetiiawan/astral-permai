<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Perjalanan extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		
		$this->load->model("Perjalanan_model");
		$this->load->model("Umb_model");
		$this->load->model("Department_model");
		$this->load->model("Keuangan_model");
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
		if($system[0]->module_perjalanan!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('left_perjalanans').' | '.$this->Umb_model->site_title();
		$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		$data['types_pengaturan_perjalanan'] = $this->Perjalanan_model->types_pengaturan_perjalanan();
		$data['get_all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$data['breadcrumbs'] = $this->lang->line('left_perjalanans');
		$data['path_url'] = 'perjalanan';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('17',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/perjalanan/list_perjalanan", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}
	
	public function get_karyawans() {

		$data['title'] = $this->Umb_model->site_title();
		$id = $this->uri->segment(4);
		$data = array(
			'perusahaan_id' => $id
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/perjalanan/get_karyawans", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	} 
	
	public function list_perjalanan(){

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/perjalanan/list_perjalanan", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$role_resources_ids = $this->Umb_model->user_role_resource();
		$user_info = $this->Umb_model->read_user_info($session['user_id']);
		if($user_info[0]->user_role_id==1){
			$perjalanan = $this->Perjalanan_model->get_perjalanan();
		} else {
			if(in_array('235',$role_resources_ids)) {
				$perjalanan = $this->Perjalanan_model->get_perusahaan_perjalanan($user_info[0]->perusahaan_id);
			} else {
				$perjalanan = $this->Perjalanan_model->get_karyawan_perjalanan($session['user_id']);
			}
		}
		$data = array();

		foreach($perjalanan->result() as $r) {
			$karyawan = $this->Umb_model->read_user_info($r->karyawan_id);
			if(!is_null($karyawan)){
				$nama_karyawan = $karyawan[0]->first_name.' '.$karyawan[0]->last_name;
			} else {
				$nama_karyawan = '--';	
			}
			$start_date = $this->Umb_model->set_date_format($r->start_date);
			$end_date = $this->Umb_model->set_date_format($r->end_date);
			$perusahaan = $this->Umb_model->read_info_perusahaan($r->perusahaan_id);
			if(!is_null($perusahaan)){
				$prshn_nama = $perusahaan[0]->name;
			} else {
				$prshn_nama = '--';	
			}
		//if($r->status==0): $status = $this->lang->line('umb_pending');
		//elseif($r->status==1): $status = $this->lang->line('umb_accepted'); else: $status = $this->lang->line('umb_rejected'); endif;
			if($r->status==0): 
				$status = '<span class="badge bg-orange">'.$this->lang->line('umb_pending').'</span>';
			elseif($r->status==1): 
				$status = '<span class="badge bg-green">'.$this->lang->line('umb_accepted').'</span>';
			else: 
				$status = '<span class="badge bg-red">'.$this->lang->line('umb_rejected'); 
			endif;

			if(in_array('217',$role_resources_ids)) {
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-perjalanan_id="'. $r->perjalanan_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('218',$role_resources_ids)) {
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->perjalanan_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}
			if(in_array('235',$role_resources_ids)) { 
				$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target="#modals-slide" data-perjalanan_id="'. $r->perjalanan_id . '"><span class="fa fa-eye"></span></button></span>';
			} else {
				$view = '';
			}
			if($r->status==1) {
				$combhr = $view;
			} else {
				$combhr = $edit.$view.$delete;
			}
			$expected_budget = $this->Umb_model->currency_sign($r->expected_budget);
			$actual_budget = $this->Umb_model->currency_sign($r->actual_budget);
			$inama_karyawan = $nama_karyawan.'<br><small class="text-muted"><i>'.$r->visit_purpose.'<i></i></i></small><br><small class="text-muted"><i>'.$this->lang->line('umb_expected_perjalanan_budget').': '.$expected_budget.'<i></i></i></small><br><small class="text-muted"><i>'.$this->lang->line('umb_actual_perjalanan_budget').': '.$actual_budget.'<i></i></i></small><br><small class="text-muted"><i>'.$status.'<i></i></i></small>';

			$data[] = array(
				$combhr,
				$inama_karyawan,
				$prshn_nama,
				$r->visit_place,
				$start_date,
				$end_date
			);
		}
		$output = array(
			"draw" => $draw,
			"recordsTotal" => $perjalanan->num_rows(),
			"recordsFiltered" => $perjalanan->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function read() {

		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('perjalanan_id');
		$result = $this->Perjalanan_model->read_informasi_perjalanan($id);
		$data = array(
			'perjalanan_id' => $result[0]->perjalanan_id,
			'perusahaan_id' => $result[0]->perusahaan_id,
			'karyawan_id' => $result[0]->karyawan_id,
			'start_date' => $result[0]->start_date,
			'end_date' => $result[0]->end_date,
			'visit_purpose' => $result[0]->visit_purpose,
			'visit_place' => $result[0]->visit_place,
			'perjalanan_mode' => $result[0]->perjalanan_mode,
			'arrangement_type' => $result[0]->arrangement_type,
			'expected_budget' => $result[0]->expected_budget,
			'actual_budget' => $result[0]->actual_budget,
			'description' => $result[0]->description,
			'status' => $result[0]->status,
			'all_karyawans' => $this->Umb_model->all_karyawans(),
			'get_all_perusahaans' => $this->Umb_model->get_perusahaans(),
			'types_pengaturan_perjalanan' => $this->Perjalanan_model->types_pengaturan_perjalanan(),
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/perjalanan/dialog_perjalanan', $data);
		} else {
			redirect('admin/');
		}
	}

	public function add_perjalanan() {

		if($this->input->post('add_type')=='perjalanan') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$start_date = $this->input->post('start_date');
			$end_date = $this->input->post('end_date');
			$description = $this->input->post('description');
			$st_date = strtotime($start_date);
			$ed_date = strtotime($end_date);
			$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
			if($this->input->post('perusahaan_id')==='') {
				$Return['error'] = $this->lang->line('error_field_perusahaan');
			} else if($this->input->post('karyawan_id')==='') {
				$Return['error'] = $this->lang->line('umb_error_karyawan_id');
			} else if($this->input->post('start_date')==='') {
				$Return['error'] = $this->lang->line('umb_error_start_date');
			} else if($this->input->post('end_date')==='') {
				$Return['error'] = $this->lang->line('umb_error_end_date');
			} else if($st_date > $ed_date) {
				$Return['error'] = $this->lang->line('umb_error_start_end_date');
			} else if($this->input->post('visit_purpose')==='') {
				$Return['error'] = $this->lang->line('umb_error_perjalanan_purpose');
			} else if($this->input->post('visit_place')==='') {
				$Return['error'] = $this->lang->line('umb_error_perjalanan_visit_place');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$data = array(
				'karyawan_id' => $this->input->post('karyawan_id'),
				'perusahaan_id' => $this->input->post('perusahaan_id'),
				'start_date' => $this->input->post('start_date'),
				'end_date' => $this->input->post('end_date'),
				'visit_purpose' => $this->input->post('visit_purpose'),
				'visit_place' => $this->input->post('visit_place'),
				'perjalanan_mode' => $this->input->post('perjalanan_mode'),
				'arrangement_type' => $this->input->post('arrangement_type'),
				'expected_budget' => $this->input->post('expected_budget'),
				'actual_budget' => $this->input->post('actual_budget'),
				'description' => $qt_description,
				'added_by' => $this->input->post('user_id'),
				'created_at' => date('d-m-Y'),
			);
			$result = $this->Perjalanan_model->add($data);
			if ($result == TRUE) {
				$row = $this->db->select("*")->limit(1)->order_by('perjalanan_id',"DESC")->get("umb_perjalanans_karyawan")->row();
				$Return['result'] = $this->lang->line('umb_sukses_perjalanan_ditambahkan');	
				$Return['re_last_id'] = $row->perjalanan_id;
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function update() {

		if($this->input->post('edit_type')=='perjalanan') {
			$id = $this->uri->segment(4);
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$start_date = $this->input->post('start_date');
			$end_date = $this->input->post('end_date');
			$description = $this->input->post('description');
			$st_date = strtotime($start_date);
			$ed_date = strtotime($end_date);
			$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
			if($this->input->post('start_date')==='') {
				$Return['error'] = $this->lang->line('umb_error_start_date');
			} else if($this->input->post('end_date')==='') {
				$Return['error'] = $this->lang->line('umb_error_end_date');
			} else if($st_date > $ed_date) {
				$Return['error'] = $this->lang->line('umb_error_start_end_date');
			} else if($this->input->post('visit_purpose')==='') {
				$Return['error'] = $this->lang->line('umb_error_perjalanan_purpose');
			} else if($this->input->post('visit_place')==='') {
				$Return['error'] = $this->lang->line('umb_error_perjalanan_visit_place');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$data = array(
				'start_date' => $this->input->post('start_date'),
				'end_date' => $this->input->post('end_date'),
				'visit_purpose' => $this->input->post('visit_purpose'),
				'visit_place' => $this->input->post('visit_place'),
				'perjalanan_mode' => $this->input->post('perjalanan_mode'),
				'arrangement_type' => $this->input->post('arrangement_type'),
				'expected_budget' => $this->input->post('expected_budget'),
				'actual_budget' => $this->input->post('actual_budget'),
				'description' => $qt_description,
				'status' => $this->input->post('status'),		
			);
			$result = $this->Perjalanan_model->update_record($data,$id);	
			if($this->input->post('status') == 1){
				$system_settings = system_settings_info(1);	
				if($system_settings->online_payment_account == ''){
					$online_payment_account = 0;
				} else {
					$online_payment_account = $system_settings->online_payment_account;
				}
				$prjln_info = $this->Perjalanan_model->read_informasi_perjalanan($id);
				$ivdata = array(
					'jumlah' => $this->input->post('actual_budget'),
					'account_id' => $online_payment_account,
					'type_transaksi' => 'biaya',
					'dr_cr' => 'cr',
					'tanggal_transaksi' => date('Y-m-d'),
					'pembayar_penerima_pembayaran_id' => $prjln_info[0]->karyawan_id,
					'payment_method_id' => 3,
					'description' => 'Travel Expense',
					'reference' => 'Travel Expense',
					'invoice_id' => $id,
					'client_id' => $prjln_info[0]->karyawan_id,
					'created_at' => date('Y-m-d H:i:s')
				);
				$this->Keuangan_model->add_transaksii($ivdata);
				$account_id = $this->Keuangan_model->read_informasi_bankcash($online_payment_account);
				$acc_saldo = $account_id[0]->saldo_account - $this->input->post('actual_budget');
				$data3 = array(
					'saldo_account' => $acc_saldo
				);
				$this->Keuangan_model->update_record_bankcash($data3,$online_payment_account);	
			}
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_perjalanan_diperbarui');
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
		$result = $this->Perjalanan_model->delete_record($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('umb_sukses_perjalanan_dihapus');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
	}
}
