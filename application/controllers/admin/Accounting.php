<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Accounting extends MY_Controller {

	public function output($Return=array()){
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		exit(json_encode($Return));
	}
	
	public function __construct() {
		parent::__construct();

		$this->load->model('Umb_model');
		$this->load->model('Keuangan_model');
		$this->load->model('Biaya_model');
		$this->load->model('Invoices_model');
		$this->load->model('Karyawans_model');
		$this->load->model('Department_model');
		$this->load->model('Project_model');
		$this->load->model('Awards_model');
		$this->load->model('Training_model');
	}

	public function index() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('umb_hr_keuangan').' | '.$this->Umb_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('umb_hr_keuangan');
		$data['path_url'] = 'accounting';
		$data['get_invoice_pembayarans'] = $this->Keuangan_model->get_invoice_pembayarans();
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('72',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/accounting/keuangan", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}

	public function dashboard_accounting() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('hr_title_dashboard_accounting').' | '.$this->Umb_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('hr_title_dashboard_accounting');
		$data['path_url'] = 'dashboard_projects';
		$data['get_invoice_pembayarans'] = $this->Keuangan_model->get_invoice_pembayarans();
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('286',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/accounting/dashboard_accounting", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}
	
	public function deposit() {

		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		$system = $this->Umb_model->read_setting_info(1);
		if($system[0]->module_accounting!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('umb_acc_deposit').' | '.$this->Umb_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('umb_acc_deposit');
		$data['path_url'] = 'accounting_deposit';
		$data['all_pembayars'] = $this->Keuangan_model->all_pembayars();
		$data['all_bank_cash'] = $this->Keuangan_model->all_bank_cash();
		$data['all_list_kategoris_pendapatan'] = $this->Keuangan_model->all_list_kategoris_pendapatan();
		$data['get_all_payment_method'] = $this->Keuangan_model->get_all_payment_method();
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('75',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/accounting/list_deposit", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}
	
	public function transfer() {

		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		$system = $this->Umb_model->read_setting_info(1);
		if($system[0]->module_accounting!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('umb_acc_transfer').' | '.$this->Umb_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('umb_acc_transfer');
		$data['path_url'] = 'accounting_transfer';
		$data['all_bank_cash'] = $this->Keuangan_model->all_bank_cash();
		$data['all_list_kategoris_pendapatan'] = $this->Keuangan_model->all_list_kategoris_pendapatan();
		$data['get_all_payment_method'] = $this->Keuangan_model->get_all_payment_method();
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('77',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/accounting/list_transfer", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}
	
	public function biaya() {

		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		$system = $this->Umb_model->read_setting_info(1);
		if($system[0]->module_accounting!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('umb_acc_biaya').' | '.$this->Umb_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('umb_acc_biaya');
		$data['path_url'] = 'accounting_biaya';
		$data['all_penerima_pembayarans'] = $this->Keuangan_model->all_penerima_pembayarans();
		$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		$data['all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$data['all_types_biaya'] = $this->Biaya_model->all_types_biaya();
		$data['all_bank_cash'] = $this->Keuangan_model->all_bank_cash();
		$data['all_list_kategoris_pendapatan'] = $this->Keuangan_model->all_list_kategoris_pendapatan();
		$data['get_all_payment_method'] = $this->Keuangan_model->get_all_payment_method();
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('76',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/accounting/list_biaya", $data, TRUE);
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
			$this->load->view("admin/accounting/get_karyawans", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}

	public function get_perusahaan_types_biaya() {

		$data['title'] = $this->Umb_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'perusahaan_id' => $id
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/accounting/get_perusahaan_types_biaya", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}

	public function get_types_biaya() {

		$data['title'] = $this->Umb_model->site_title();
		$id = $this->uri->segment(4);
		$data = array(
			'perusahaan_id' => $id
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/accounting/get_types_biaya", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}

	public function get_laporans_type_biaya() {

		$data['title'] = $this->Umb_model->site_title();
		$id = $this->uri->segment(4);
		$data = array(
			'perusahaan_id' => $id
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/accounting/get_laporans_type_biaya", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}
	
	public function pembayars() {

		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		$system = $this->Umb_model->read_setting_info(1);
		if($system[0]->module_accounting!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('umb_acc_pembayars').' | '.$this->Umb_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('umb_acc_pembayars');
		$data['path_url'] = 'accounting_pembayars';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('81',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/accounting/list_pembayars", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}
	
	public function penerima_pembayarans() {

		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		$system = $this->Umb_model->read_setting_info(1);
		if($system[0]->module_accounting!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('umb_acc_penerima_pembayarans').' | '.$this->Umb_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('umb_acc_penerima_pembayarans');
		$data['path_url'] = 'accounting_penerima_pembayarans';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('80',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/accounting/list_penerima_pembayarans", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}

	public function bank_cash() {

		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		$system = $this->Umb_model->read_setting_info(1);
		if($system[0]->module_accounting!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('umb_acc_accounts').' | '.$this->Umb_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('umb_acc_accounts');
		$data['path_url'] = 'accounting_bank_cash';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('72',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/accounting/list_bank_cash", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}
	
	public function saldo_accounts() {

		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		$system = $this->Umb_model->read_setting_info(1);
		if($system[0]->module_accounting!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('umb_acc_saldo_accounts').' | '.$this->Umb_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('umb_acc_saldo_accounts');
		$data['path_url'] = 'accounting_saldo_accounts';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('73',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/accounting/saldo_accounts", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}
	
	public function transaksii() {

		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		$system = $this->Umb_model->read_setting_info(1);
		if($system[0]->module_accounting!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('umb_acc_view_transaksi').' | '.$this->Umb_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('umb_acc_view_transaksi');
		$data['path_url'] = 'accounting_transaksii';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('78',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/accounting/list_transaksi", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}

	public function read() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('bankcash_id');
		$result = $this->Keuangan_model->read_informasi_bankcash($id);
		$data = array(
			'bankcash_id' => $result[0]->bankcash_id,
			'nama_account' => $result[0]->nama_account,
			'saldo_account' => $result[0]->saldo_account,
			'nomor_account' => $result[0]->nomor_account,
			'kode_cabang' => $result[0]->kode_cabang,
			'cabang_bank' => $result[0]->cabang_bank,
			'created_at' => $result[0]->created_at
		);
		if(!empty($session)){ 
			$this->load->view('admin/accounting/dialog_accounting', $data);
		} else {
			redirect('admin/');
		}
	}
	
	public function read_pembayar() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('pembayar_id');
		$result = $this->Keuangan_model->read_info_pembayar($id);
		$data = array(
			'pembayar_id' => $result[0]->pembayar_id,
			'nama_pembayar' => $result[0]->nama_pembayar,
			'nomor_kontak' => $result[0]->nomor_kontak,
			'created_at' => $result[0]->created_at
		);
		if(!empty($session)){ 
			$this->load->view('admin/accounting/dialog_accounting', $data);
		} else {
			redirect('admin/');
		}
	}
	
	public function read_penerima_pembayaran() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('penerima_pembayaran_id');
		$result = $this->Keuangan_model->read_info_penerima_pembayaran($id);
		$data = array(
			'penerima_pembayaran_id' => $result[0]->penerima_pembayaran_id,
			'nama_penerima_pembayaran' => $result[0]->nama_penerima_pembayaran,
			'nomor_kontak' => $result[0]->nomor_kontak,
			'created_at' => $result[0]->created_at
		);
		if(!empty($session)){ 
			$this->load->view('admin/accounting/dialog_accounting', $data);
		} else {
			redirect('admin/');
		}
	}
	
	public function list_pembayars(){

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		if(!empty($session)){ 
			$this->load->view("admin/accounting/list_pembayars", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$pembayar = $this->Keuangan_model->get_pembayars();
		$role_resources_ids = $this->Umb_model->user_role_resource();
		$data = array();
		foreach($pembayar->result() as $r) {
			$created_at = $this->Umb_model->set_date_format($r->created_at);
			if(in_array('368',$role_resources_ids)) {
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target=".add-modal-data"  data-pembayar_id="'. $r->pembayar_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('369',$role_resources_ids)) {
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->pembayar_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}
			
			$combhr = $edit.$delete;
			$data[] = array(
				$combhr,
				$r->nama_pembayar,
				$r->nomor_kontak,
				$created_at
			);
		}
		$output = array(
			"draw" => $draw,
			"recordsTotal" => $pembayar->num_rows(),
			"recordsFiltered" => $pembayar->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function list_penerima_pembayarans(){

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		if(!empty($session)){ 
			$this->load->view("admin/accounting/list_penerima_pembayarans", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$penerima_pembayaran = $this->Keuangan_model->get_penerima_pembayarans();
		$role_resources_ids = $this->Umb_model->user_role_resource();
		$data = array();
		foreach($penerima_pembayaran->result() as $r) {
			$created_at = $this->Umb_model->set_date_format($r->created_at);
			if(in_array('365',$role_resources_ids)) {
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target=".add-modal-data"  data-penerima_pembayaran_id="'. $r->penerima_pembayaran_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('366',$role_resources_ids)) {
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->penerima_pembayaran_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}
			$combhr = $edit.$delete;
			$data[] = array(
				$combhr,
				$r->nama_penerima_pembayaran,
				$r->nomor_kontak,
				$created_at
			);
		}
		$output = array(
			"draw" => $draw,
			"recordsTotal" => $penerima_pembayaran->num_rows(),
			"recordsFiltered" => $penerima_pembayaran->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function list_bank_cash(){

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		if(!empty($session)){ 
			$this->load->view("admin/accounting/list_bank_cash", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$bankcash = $this->Keuangan_model->get_bankcash();
		$role_resources_ids = $this->Umb_model->user_role_resource();
		$data = array();
		foreach($bankcash->result() as $r) {
			$saldo_account = $this->Umb_model->currency_sign($r->saldo_account);
			$bank_cash = $this->Keuangan_model->read_info_transaksi_melalui_bank($r->bankcash_id);
			if(!is_null($bank_cash)){
				$account = '<a data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_acc_ledger_view').'" href="'.site_url('admin/accounting/accounts_ledger/'.$r->bankcash_id.'').'" target="_blank">'.$r->nama_account.'</a>';
			} else {
				$account = $r->nama_account;
			}
			$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target="#edit-modal-data"  data-bankcash_id="'. $r->bankcash_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
			$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->bankcash_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			
			$combhr = $edit.$delete;
			$data[] = array(
				$combhr,
				$account,
				$r->nomor_account,
				$r->kode_cabang,
				$saldo_account,
				$r->cabang_bank
			);
		}
		$output = array(
			"draw" => $draw,
			"recordsTotal" => $bankcash->num_rows(),
			"recordsFiltered" => $bankcash->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function list_saldo_accounts(){

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		if(!empty($session)){ 
			$this->load->view("admin/accounting/saldo_accounts", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$bankcash = $this->Keuangan_model->get_bankcash();
		$data = array();
		foreach($bankcash->result() as $r) {
			$saldo_account = $this->Umb_model->currency_sign($r->saldo_account);
			$bank_cash = $this->Keuangan_model->read_info_transaksi_melalui_bank($r->bankcash_id);
			if(!is_null($bank_cash)){
				$account = '<a data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_acc_ledger_view').'" href="'.site_url('admin/accounting/accounts_ledger/'.$r->bankcash_id.'').'" target="_blank">'.$r->nama_account.'</a>';
			} else {
				$account = $r->nama_account;
			}

			$data[] = array(
				$account,
				$saldo_account
			);
		}
		$output = array(
			"draw" => $draw,
			"recordsTotal" => $bankcash->num_rows(),
			"recordsFiltered" => $bankcash->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function list_deposit() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		if(!empty($session)){ 
			$this->load->view("admin/accounting/list_deposit", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$deposit = $this->Keuangan_model->get_deposit();
		$role_resources_ids = $this->Umb_model->user_role_resource();
		$data = array();
		foreach($deposit->result() as $r) {
			$jumlah = $this->Umb_model->currency_sign($r->jumlah);
			$acc_type = $this->Keuangan_model->read_informasi_bankcash($r->account_id);
			if(!is_null($acc_type)){
				$account = $acc_type[0]->nama_account;
			} else {
				$account = '--';	
			}
			$pembayar = $this->Keuangan_model->read_info_pembayar($r->pembayar_penerima_pembayaran_id);
			if(!is_null($pembayar)){
				$full_name = $pembayar[0]->nama_pembayar;
			} else {
				$full_name = '--';	
			}
			$deposit_tanggal = $this->Umb_model->set_date_format($r->tanggal_transaksi);
			
			$kategori_id = $this->Keuangan_model->read_kategori_pendapatan($r->kat_transaksi_id);
			if(!is_null($kategori_id)){
				$kategori = $kategori_id[0]->name;
			} else {
				$kategori = '--';	
			}
			$payment_method = $this->Umb_model->read_payment_method($r->payment_method_id);
			if(!is_null($payment_method)){
				$method_name = $payment_method[0]->method_name;
			} else {
				$method_name = '--';	
			}
			$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-deposit_id="'. $r->transaksi_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
			$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->transaksi_id . '"><span class="fas fa-trash-restore"></span></button></span>';			
			$combhr = $edit.$delete;
			$data[] = array(
				$combhr,
				$account,
				$full_name,
				$jumlah,
				$kategori,
				$r->reference,
				$method_name,
				$deposit_tanggal
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $deposit->num_rows(),
			"recordsFiltered" => $deposit->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function list_biaya(){

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		if(!empty($session)){ 
			$this->load->view("admin/accounting/list_biaya", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$biaya = $this->Keuangan_model->get_biaya();
		$role_resources_ids = $this->Umb_model->user_role_resource();
		$data = array();
		foreach($biaya->result() as $r) {
			$jumlah = $this->Umb_model->currency_sign($r->jumlah);
			$acc_type = $this->Keuangan_model->read_informasi_bankcash($r->account_id);
			if(!is_null($acc_type)){
				$account = $acc_type[0]->nama_account;
			} else {
				$account = '--';	
			}
			if($r->option_penerima_pembayaran == 1){
				$penerima_pembayaran = $this->Umb_model->read_user_info($r->pembayar_penerima_pembayaran_id);
				if(!is_null($penerima_pembayaran)){
					$full_name = $penerima_pembayaran[0]->first_name.' '.$penerima_pembayaran[0]->last_name;
				} else {
					$full_name = '--';	
				}
			} else {
				$penerima_pembayaran = $this->Keuangan_model->read_info_penerima_pembayaran($r->pembayar_penerima_pembayaran_id);
				
				if(!is_null($penerima_pembayaran)){
					$full_name = $penerima_pembayaran[0]->nama_penerima_pembayaran;
				} else {
					$full_name = '--';	
				}
			}
			$tanggal_biaya = $this->Umb_model->set_date_format($r->tanggal_transaksi);
			$type_biaya = $this->Biaya_model->read_informasi_type_biaya($r->kat_transaksi_id);
			if(!is_null($type_biaya)){
				$kategori = $type_biaya[0]->name;
			} else {
				$kategori = '--';	
			}
			$payment_method = $this->Umb_model->read_payment_method($r->payment_method_id);
			if(!is_null($payment_method)){
				$method_name = $payment_method[0]->method_name;
			} else {
				$method_name = '--';	
			}
			$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-biaya_id="'. $r->transaksi_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
			$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->transaksi_id . '"><span class="fas fa-trash-restore"></span></button></span>';			
			$combhr = $edit.$delete;

			$data[] = array(
				$combhr,
				$account,
				$full_name,
				$jumlah,
				$kategori,
				$r->reference,
				$method_name,
				$tanggal_biaya
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $biaya->num_rows(),
			"recordsFiltered" => $biaya->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}	 

	public function list_transaksi(){

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		if(!empty($session)){ 
			$this->load->view("admin/accounting/list_transaksi", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$transaksi = $this->Keuangan_model->get_transaksi();
		$role_resources_ids = $this->Umb_model->user_role_resource();
		$data = array();
		$saldo2 = 0;
		foreach($transaksi->result() as $r) {
			$tanggal_transaksi = $this->Umb_model->set_date_format($r->tanggal_transaksi);
			$jumlah_total = $this->Umb_model->currency_sign($r->jumlah);
			$cr_dr = $r->dr_cr=="dr" ? "Debit" : "Credit";
			$acc_type = $this->Keuangan_model->read_informasi_bankcash($r->account_id);
			if(!is_null($acc_type)){
				$account = '<a href="'.site_url('admin/accounting/accounts_ledger/'.$r->account_id.'').'" title="'.$this->lang->line('umb_acc_ledger_view').'" target="_blank">'.$acc_type[0]->nama_account.'</a>';
			} else {
				$account = '--';	
			}
			if($r->dr_cr=="cr"){
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target=".view-modal-data-bg"  data-deposit_id="'. $r->transaksi_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
			} else {
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-biaya_id="'. $r->transaksi_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
			}
			$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->transaksi_id . '"><span class="fas fa-trash-restore"></span></button></span>';			
			$combhr = $edit.$delete;
			
			$data[] = array(
				$tanggal_transaksi,
				$account,
				$cr_dr,
				$r->type_transaksi,
				$jumlah_total,
				$r->reference
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $transaksi->num_rows(),
			"recordsFiltered" => $transaksi->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function add_deposit() {

		if($this->input->post('add_type')=='deposit') {		
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$description = $this->input->post('description');
			$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);

			if($this->input->post('bank_cash_id')==='') {
				$Return['error'] = $this->lang->line('umb_acc_error_field_account');
			} else if($this->input->post('jumlah')==='') {
				$Return['error'] = $this->lang->line('umb_error_field_jumlah');
			} else if($this->input->post('deposit_tanggal')==='') {
				$Return['error'] = $this->lang->line('umb_acc_error_deposit_tanggal');
			}
			else if($_FILES['file_deposit']['size'] == 0) {
				$fname = 'no_file';
			}
			else if(is_uploaded_file($_FILES['file_deposit']['tmp_name'])) {
				$allowed =  array('PNG','JPG','JPEG','PDF','GIF','png','jpg','jpeg','pdf','gif','txt','doc','docx','xls','xlsx');
				$filename = $_FILES['file_deposit']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);

				if(in_array($ext,$allowed)){
					$tmp_name = $_FILES["file_deposit"]["tmp_name"];
					$profile = "uploads/accounting/deposit/";
					$set_img = base_url()."uploads/accounting/deposit/";
					$name = basename($_FILES["file_deposit"]["name"]);
					$newfilename = 'deposit_'.round(microtime(true)).'.'.$ext;
					move_uploaded_file($tmp_name, $profile.$newfilename);
					$fname = $newfilename;					
				} else {
					$Return['error'] = $this->lang->line('umb_acc_error_attachment');
				}
			}

			if($Return['error']!=''){
				$this->output($Return);
			}
			$data = array(
				'account_id' => $this->input->post('bank_cash_id'),
				'jumlah' => $this->input->post('jumlah'),
				'type_transaksi' => 'pendapatan',
				'dr_cr' => 'dr',
				'tanggal_transaksi' => $this->input->post('deposit_tanggal'),
				'attachment_file' => $fname,
				'kat_transaksi_id' => $this->input->post('kategori_id'),
				'pembayar_penerima_pembayaran_id' => $this->input->post('pembayar_id'),
				'payment_method_id' => $this->input->post('payment_method'),
				'description' => 'Deposit Amount',
				'reference' => $this->input->post('reference_deposit'),
				'invoice_id' => 0,
				'created_at' => date('Y-m-d H:i:s')
			);
			$result = $this->Keuangan_model->add_transaksii($data);
			if ($result == TRUE) {			
				$account_id = $this->Keuangan_model->read_informasi_bankcash($this->input->post('bank_cash_id'));
				$acc_saldo = $account_id[0]->saldo_account + $this->input->post('jumlah');

				$data3 = array(
					'saldo_account' => $acc_saldo
				);
				$this->Keuangan_model->update_record_bankcash($data3,$this->input->post('bank_cash_id'));
				$Return['result'] = $this->lang->line('umb_acc_sukses_deposit_ditambahkan');
			} else {
				$Return['error'] = $this->lang->line('umb_error');
			}
			$this->output($Return);
			exit;


		}
	} 
	
	public function add_biaya() {

		if($this->input->post('add_type')=='biaya') {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
			
			$description = $this->input->post('description');
			$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
			$bank_cash = $this->Keuangan_model->read_informasi_bankcash($this->input->post('bank_cash_id'));
			if($this->input->post('bank_cash_id')==='') {
				$Return['error'] = $this->lang->line('umb_acc_error_field_account');
			} else if($this->input->post('jumlah')==='') {
				$Return['error'] = $this->lang->line('umb_error_field_jumlah');
			} else if($this->input->post('jumlah') > $bank_cash[0]->saldo_account) {
				$Return['error'] = $this->lang->line('umb_acc_error_jumlah_should_be_less_than_current');
			} else if($this->input->post('tanggal_biaya')==='') {
				$Return['error'] = $this->lang->line('umb_acc_error_tanggal_biaya');
			} else if($this->input->post('perusahaan')==='') {
				$Return['error'] = $this->lang->line('error_field_perusahaan');
			} else if($this->input->post('penerima_pembayaran_id')==='') {
				$Return['error'] = $this->lang->line('umb_acc_error_nama_penerima_pembayaran');
			}
			else if($_FILES['file_biaya']['size'] == 0) {
				$fname = 'no_file';
			}
			else if(is_uploaded_file($_FILES['file_biaya']['tmp_name'])) {

				$allowed =  array('png','jpg','jpeg','pdf','gif','txt','doc','docx','xls','xlsx');
				$filename = $_FILES['file_biaya']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);

				if(in_array($ext,$allowed)){
					$tmp_name = $_FILES["file_biaya"]["tmp_name"];
					$profile = "uploads/accounting/biaya/";
					$set_img = base_url()."uploads/accounting/biaya/";
					$name = basename($_FILES["file_biaya"]["name"]);
					$newfilename = 'biaya_'.round(microtime(true)).'.'.$ext;
					move_uploaded_file($tmp_name, $profile.$newfilename);
					$fname = $newfilename;					
				} else {
					$Return['error'] = $this->lang->line('umb_acc_error_attachment');
				}
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$data = array(
				'account_id' => $this->input->post('bank_cash_id'),
				'jumlah' => $this->input->post('jumlah'),
				'type_transaksi' => 'biaya',
				'dr_cr' => 'cr',
				'tanggal_transaksi' => $this->input->post('tanggal_biaya'),
				'attachment_file' => $fname,
				'kat_transaksi_id' => $this->input->post('kategori_id'),
				'pembayar_penerima_pembayaran_id' => $this->input->post('penerima_pembayaran_id'),
				'option_penerima_pembayaran' => $this->input->post('option_penerima_pembayaran'),
				'perusahaan_id' => $this->input->post('perusahaan'),
				'payment_method_id' => $this->input->post('payment_method'),
				'description' => $qt_description,
				'reference' => $this->input->post('reference_biaya'),
				'invoice_id' => 0,
				'created_at' => date('Y-m-d H:i:s')
			);
			$result = $this->Keuangan_model->add_transaksii($data);
			if ($result == TRUE) {
				$account_id = $this->Keuangan_model->read_informasi_bankcash($this->input->post('bank_cash_id'));
				$acc_saldo = $account_id[0]->saldo_account - $this->input->post('jumlah');
				$data3 = array(
					'saldo_account' => $acc_saldo
				);
				$this->Keuangan_model->update_record_bankcash($data3,$this->input->post('bank_cash_id'));
				$Return['result'] = $this->lang->line('umb_acc_sukses_biaya_ditambahkan');
			} else {
				$Return['error'] = $this->lang->line('umb_error');
			}
			$this->output($Return);
			exit;


		}
	} 
	
	public function add_invoice_pembayaran() {

		if($this->input->post('add_type')=='invoice_pembayaran') {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$description = $this->input->post('description');
			$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
			$invoice_tr = $this->Keuangan_model->read_transaksi_invoice($this->input->post('invoice_id'));
			if ($invoice_tr->num_rows() > 0) {
				$Return['error'] = $this->lang->line('umb_acc_inv_bayar_already');
			} 
			if($Return['error']!=''){
				$this->output($Return);
			}
			if($this->input->post('bank_cash_id')==='') {
				$Return['error'] = $this->lang->line('umb_acc_error_field_account');
			} else if($this->input->post('jumlah')==='') {
				$Return['error'] = $this->lang->line('umb_error_field_jumlah');
			} else if($this->input->post('add_invoice_tanggal')==='') {
				$Return['error'] = $this->lang->line('umb_acc_error_deposit_tanggal');
			} else if($this->input->post('payment_method')==='') {
				$Return['error'] = $this->lang->line('umb_error_melakukanpembayaran_payment_method');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$invoice_id = $this->input->post('invoice_id');
			$data = array(
				'account_id' => $this->input->post('bank_cash_id'),
				'jumlah' => $this->input->post('jumlah'),
				'type_transaksi' => 'pendapatan',
				'type_invoice' => 'customer',
				'dr_cr' => 'dr',
				'tanggal_transaksi' => $this->input->post('add_invoice_tanggal'),
				'attachment_file' => '',
				'kat_transaksi_id' => $this->input->post('kategori_id'),
				'pembayar_penerima_pembayaran_id' => $this->input->post('pembayar_id'),
				'payment_method_id' => $this->input->post('payment_method'),
				'description' => $qt_description,
				'reference' => $this->input->post('reference'),
				'invoice_id' => $invoice_id,
				'created_at' => date('Y-m-d H:i:s')
			);
			$result = $this->Keuangan_model->add_transaksii($data);
			if ($result == TRUE) {			

				$account_id = $this->Keuangan_model->read_informasi_bankcash($this->input->post('bank_cash_id'));
				$acc_saldo = $account_id[0]->saldo_account + $this->input->post('jumlah');

				$data3 = array(
					'saldo_account' => $acc_saldo
				);
				$this->Keuangan_model->update_record_bankcash($data3,$this->input->post('bank_cash_id'));
				$data = array(
					'status' => 1,
				);
				$result = $this->Invoices_model->update_record_invoice($data,$invoice_id);

				$Return['result'] = $this->lang->line('umb_acc_sukses_deposit_ditambahkan');
			} else {
				$Return['error'] = $this->lang->line('umb_error');
			}
			$this->output($Return);
			exit;


		}
	}
	
	public function add_direct_invoice_pembayaran() {

		if($this->input->post('add_type')=='invoice_pembayaran') {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$description = $this->input->post('description');
			$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
			$invoice_tr = $this->Keuangan_model->read_transaksi_invoice($this->input->post('invoice_id'));
			if ($invoice_tr->num_rows() > 0) {
				$Return['error'] = $this->lang->line('umb_acc_inv_bayar_already');
			} 
			if($Return['error']!=''){
				$this->output($Return);
			}
			if($this->input->post('bank_cash_id')==='') {
				$Return['error'] = $this->lang->line('umb_acc_error_field_account');
			} else if($this->input->post('jumlah')==='') {
				$Return['error'] = $this->lang->line('umb_error_field_jumlah');
			} else if($this->input->post('add_invoice_tanggal')==='') {
				$Return['error'] = $this->lang->line('umb_acc_error_deposit_tanggal');
			} else if($this->input->post('payment_method')==='') {
				$Return['error'] = $this->lang->line('umb_error_melakukanpembayaran_payment_method');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$invoice_id = $this->input->post('invoice_id');
			$data = array(
				'account_id' => $this->input->post('bank_cash_id'),
				'jumlah' => $this->input->post('jumlah'),
				'type_transaksi' => 'pendapatan',
				'type_invoice' => 'direct',
				'dr_cr' => 'dr',
				'tanggal_transaksi' => $this->input->post('add_invoice_tanggal'),
				'attachment_file' => '',
				'kat_transaksi_id' => $this->input->post('kategori_id'),
				'pembayar_penerima_pembayaran_id' => $this->input->post('pembayar_id'),
				'payment_method_id' => $this->input->post('payment_method'),
				'description' => $qt_description,
				'reference' => $this->input->post('reference'),
				'invoice_id' => $invoice_id,
				'created_at' => date('Y-m-d H:i:s')
			);
			$result = $this->Keuangan_model->add_transaksii($data);
			if ($result == TRUE) {			

				$account_id = $this->Keuangan_model->read_informasi_bankcash($this->input->post('bank_cash_id'));
				$acc_saldo = $account_id[0]->saldo_account + $this->input->post('jumlah');

				$data3 = array(
					'saldo_account' => $acc_saldo
				);
				$this->Keuangan_model->update_record_bankcash($data3,$this->input->post('bank_cash_id'));
				$data = array(
					'status' => 1,
				);
				$result = $this->Invoices_model->update_record_direct_invoice($data,$invoice_id);

				$Return['result'] = $this->lang->line('umb_acc_sukses_deposit_ditambahkan');
			} else {
				$Return['error'] = $this->lang->line('umb_error');
			}
			$this->output($Return);
			exit;


		}
	}
	
	
	public function add_transfer() {

		if($this->input->post('add_type')=='transfer') {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$description = $this->input->post('description');
			$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);

			if($this->input->post('from_bank_cash_id')==='') {
				$Return['error'] = $this->lang->line('umb_acc_error_from_account');
			} else if($this->input->post('to_bank_cash_id')==='') {
				$Return['error'] = $this->lang->line('umb_acc_error_to_account');
			} else if($this->input->post('from_bank_cash_id')== $this->input->post('to_bank_cash_id')) {
				$Return['error'] = $this->lang->line('umb_acc_error_transfer_atara_acount_yang_sama');
			} else if($this->input->post('tanggal_transfer')==='') {
				$Return['error'] = $this->lang->line('umb_acc_error_tanggal_transfer');
			} else if($this->input->post('jumlah')==='') {
				$Return['error'] = $this->lang->line('umb_error_field_jumlah');
			} else if($this->input->post('jumlah') > $this->input->post('saldo_account')) {
				$Return['error'] = $this->lang->line('umb_acc_error_jumlah_should_be_less_than_current');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$from_account_id = $this->Keuangan_model->read_informasi_bankcash($this->input->post('from_bank_cash_id'));
			$frm_acc = $from_account_id[0]->saldo_account - $this->input->post('jumlah');

			$to_bank_cash_id = $this->Keuangan_model->read_informasi_bankcash($this->input->post('to_bank_cash_id'));
			$to_acc = $to_bank_cash_id[0]->saldo_account + $this->input->post('jumlah');
			$data = array(
				'account_id' => $this->input->post('from_bank_cash_id'),
				'jumlah' => $this->input->post('jumlah'),
				'type_transaksi' => 'transfer',
				'dr_cr' => 'cr',
				'tanggal_transaksi' => $this->input->post('tanggal_transfer'),
				'attachment_file' => '',
				'kat_transaksi_id' => 0,
				'pembayar_penerima_pembayaran_id' => 0,
				'payment_method_id' => $this->input->post('payment_method'),
				'description' => $qt_description,
				'reference' => $this->input->post('reference_transfer'),
				'invoice_id' => 0,
				'created_at' => date('Y-m-d H:i:s')
			);
			$result = $this->Keuangan_model->add_transaksii($data);
			$data2 = array(
				'saldo_account' => $frm_acc
			);
			$result2 = $this->Keuangan_model->update_record_bankcash($data2,$this->input->post('from_bank_cash_id'));
			$data3 = array(
				'saldo_account' => $to_acc
			);
			$result3 = $this->Keuangan_model->update_record_bankcash($data3,$this->input->post('to_bank_cash_id'));
			if ($result == TRUE) {
				$data4 = array(
					'account_id' => $this->input->post('to_bank_cash_id'),
					'jumlah' => $this->input->post('jumlah'),
					'type_transaksi' => 'transfer',
					'dr_cr' => 'dr',
					'tanggal_transaksi' => $this->input->post('tanggal_transfer'),
					'attachment_file' => '',
					'kat_transaksi_id' => 0,
					'pembayar_penerima_pembayaran_id' => 0,
					'payment_method_id' => $this->input->post('payment_method'),
					'description' => $qt_description,
					'reference' => $this->input->post('reference_transfer'),
					'invoice_id' => 0,
					'created_at' => date('Y-m-d H:i:s')
				);
				$result4 = $this->Keuangan_model->add_transaksii($data4);

				$Return['result'] = $this->lang->line('umb_acc_sukses_transfer_ditambahkan');
			} else {
				$Return['error'] = $this->lang->line('umb_error');
			}
			$this->output($Return);
			exit;
		}
	}

	public function add_bankcash() {

		if($this->input->post('add_type')=='bankcash') {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$cabang_bank = $this->input->post('cabang_bank');
			$qt_cabang_bank = htmlspecialchars(addslashes($cabang_bank), ENT_QUOTES);
			if($this->input->post('nama_account')==='') {
				$Return['error'] = $this->lang->line('umb_acc_error_field_nama_account');
			} else if($this->input->post('saldo_account')==='') {
				$Return['error'] = $this->lang->line('umb_acc_error_field_saldo_account');
			} else if($this->input->post('nomor_account')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_acc_number');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$data = array(
				'nama_account' => $this->input->post('nama_account'),
				'saldo_account' => $this->input->post('saldo_account'),
				'pembukanaan_saldo_account' => $this->input->post('saldo_account'),
				'nomor_account' => $this->input->post('nomor_account'),
				'kode_cabang' => $this->input->post('kode_cabang'),
				'cabang_bank' => $qt_cabang_bank,
				'created_at' => date('d-m-Y h:i:s'),

			);
			$result = $this->Keuangan_model->add_bankcash($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_acc_sukses_bank_cash_ditambahkan');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	} 
	
	public function update_bankcash() {

		if($this->input->post('edit_type')=='bankcash') {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$cabang_bank = $this->input->post('cabang_bank');
			$qt_cabang_bank = htmlspecialchars(addslashes($cabang_bank), ENT_QUOTES);
			if($this->input->post('nama_account')==='') {
				$Return['error'] = $this->lang->line('umb_acc_error_field_nama_account');
			} else if($this->input->post('saldo_account')==='') {
				$Return['error'] = $this->lang->line('umb_acc_error_field_saldo_account');
			} else if($this->input->post('nomor_account')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_acc_number');
			} 
			if($Return['error']!=''){
				$this->output($Return);
			}
			$data = array(
				'nama_account' => $this->input->post('nama_account'),
				'saldo_account' => $this->input->post('saldo_account'),
				'nomor_account' => $this->input->post('nomor_account'),
				'kode_cabang' => $this->input->post('kode_cabang'),
				'cabang_bank' => $qt_cabang_bank,
			);
			$result = $this->Keuangan_model->update_record_bankcash($data,$id);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_acc_sukses_bank_cash_diperbarui');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function delete() {
		
		if($this->input->post('is_ajax')=='2') {
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Keuangan_model->delete_record_bankcash($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_acc_sukses_bank_cash_dihapus');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}
	
	
	public function delete_deposit_transaksi() {
		
		if($this->input->post('is_ajax')=='2') {
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Keuangan_model->delete_record_transaksi($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_acc_sukses_deposit_dihapus');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}
	
	public function delete_biaya() {
		
		if($this->input->post('is_ajax')=='2') {
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Keuangan_model->delete_record_transaksi($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_acc_sukses_biaya_dihapus');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}
	
	public function delete_transaksi() {
		
		if($this->input->post('is_ajax')=='2') {
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Keuangan_model->delete_record_transaksi($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_acc_transaksi_dihapus');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}
	
	public function read_invoice() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$invoice_id = $this->input->get('invoice_id');
		$type_invoice = $this->input->get('data');
		if($type_invoice == 'customer'){
			$result = $this->Invoices_model->read_info_invoice($invoice_id);
		} else {
			$result = $this->Invoices_model->read_info_direct_invoice($invoice_id);
		}
		$data = array(
			'invoice_id' => $result[0]->invoice_id,
			'nomor_invoice' => $result[0]->nomor_invoice,
			'grand_total' => $result[0]->grand_total,
			'all_pembayars' => $this->Customers_model->get_all_customers(),
			'all_bank_cash' => $this->Keuangan_model->all_bank_cash(),
			'all_list_kategoris_pendapatan' => $this->Keuangan_model->all_list_kategoris_pendapatan(),
			'get_all_payment_method' => $this->Keuangan_model->get_all_payment_method()
		);
		if(!empty($session)){ 
			$this->load->view('admin/accounting/dialog_accounting', $data);
		} else {
			redirect('admin/');
		}
	}
	
	public function read_deposit() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('deposit_id');
		$result = $this->Keuangan_model->read_informasi_transaksi($id);
		$data = array(
			'deposit_id' => $result[0]->transaksi_id,
			'type_account_id' => $result[0]->account_id,
			'jumlah' => $result[0]->jumlah,
			'deposit_tanggal' => $result[0]->tanggal_transaksi,
			'kategoriid' => $result[0]->kat_transaksi_id,
			'pembayar_id' => $result[0]->pembayar_penerima_pembayaran_id,
			'payment_method_id' => $result[0]->payment_method_id,
			'reference_deposit' => $result[0]->reference,
			'file_deposit' => $result[0]->attachment_file,
			'description' => $result[0]->description,
			'created_at' => $result[0]->created_at,
			'all_pembayars' => $this->Keuangan_model->all_pembayars(),
			'all_bank_cash' => $this->Keuangan_model->all_bank_cash(),
			'all_list_kategoris_pendapatan' => $this->Keuangan_model->all_list_kategoris_pendapatan(),
			'get_all_payment_method' => $this->Keuangan_model->get_all_payment_method()
		);
		if(!empty($session)){ 
			$this->load->view('admin/accounting/dialog_accounting', $data);
		} else {
			redirect('admin/');
		}
	}
	
	
	public function update_deposit() {

		if($this->input->post('edit_type')=='deposit') {
			$id = $this->uri->segment(4);
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$description = $this->input->post('description');
			$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
			if($this->input->post('bank_cash_id')==='') {
				$Return['error'] = $this->lang->line('umb_acc_error_field_account');
			} else if($this->input->post('jumlah')==='') {
				$Return['error'] = $this->lang->line('umb_error_field_jumlah');
			} else if($this->input->post('deposit_tanggal')==='') {
				$Return['error'] = $this->lang->line('umb_acc_error_deposit_tanggal');
			}		
			else if($_FILES['file_deposit']['size'] == 0) {
				$fname = 'no_file';
				$data = array(
					'account_id' => $this->input->post('bank_cash_id'),
					'jumlah' => $this->input->post('jumlah'),
					'tanggal_transaksi' => $this->input->post('deposit_tanggal'),
					'kat_transaksi_id' => $this->input->post('kategori_id'),
					'pembayar_penerima_pembayaran_id' => $this->input->post('pembayar_id'),
					'payment_method_id' => $this->input->post('payment_method'),
					'description' => $qt_description,
					'reference' => $this->input->post('reference_deposit'),		
				);
				$result = $this->Keuangan_model->update_record_transaksi($data,$id);
			} else {
				if(is_uploaded_file($_FILES['file_deposit']['tmp_name'])) {

					$allowed =  array('png','jpg','jpeg','gif');
					$filename = $_FILES['file_deposit']['name'];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);

					if(in_array($ext,$allowed)){
						$tmp_name = $_FILES["file_deposit"]["tmp_name"];
						$bill_copy = "uploads/accounting/deposit/";
						$lname = basename($_FILES["file_deposit"]["name"]);
						$newfilename = 'deposit_'.round(microtime(true)).'.'.$ext;
						move_uploaded_file($tmp_name, $bill_copy.$newfilename);
						$fname = $newfilename;
						$data = array(
							'account_id' => $this->input->post('bank_cash_id'),
							'jumlah' => $this->input->post('jumlah'),
							'tanggal_transaksi' => $this->input->post('deposit_tanggal'),
							'attachment_file' => $fname,
							'kat_transaksi_id' => $this->input->post('kategori_id'),
							'pembayar_penerima_pembayaran_id' => $this->input->post('pembayar_id'),
							'payment_method_id' => $this->input->post('payment_method'),
							'description' => $qt_description,
							'reference' => $this->input->post('reference_deposit'),	
						);
						$result = $this->Keuangan_model->update_record_transaksi($data,$id);
					} else {
						$Return['error'] = $this->lang->line('umb_error_attatchment_type');
					}
				}
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_acc_sukses_deposit_diperbarui');
			} else {
				$Return['error'] = $this->lang->line('umb_error');
			}
			$this->output($Return);
			exit;
		}
	}
	
	
	public function update_transaksi() {

		if($this->input->post('edit_type')=='deposit') {
			
			$id = $this->uri->segment(4);
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$description = $this->input->post('description');
			$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);

			if($this->input->post('deposit_tanggal')==='') {
				$Return['error'] = $this->lang->line('umb_acc_error_deposit_tanggal');
			}		
			else if($_FILES['file_deposit']['size'] == 0) {
				$fname = 'no_file';
				$data = array(
					'tanggal_transaksi' => $this->input->post('deposit_tanggal'),
					'kat_transaksi_id' => $this->input->post('kategori_id'),
					'pembayar_penerima_pembayaran_id' => $this->input->post('pembayar_id'),
					'payment_method_id' => $this->input->post('payment_method'),
					'description' => $qt_description,
					'reference' => $this->input->post('reference_deposit'),		
				);
				$result = $this->Keuangan_model->update_record_transaksi($data,$id);
			} else {
				if(is_uploaded_file($_FILES['file_deposit']['tmp_name'])) {

					$allowed =  array('png','jpg','jpeg','gif');
					$filename = $_FILES['file_deposit']['name'];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);

					if(in_array($ext,$allowed)){
						$tmp_name = $_FILES["file_deposit"]["tmp_name"];
						$bill_copy = "uploads/accounting/deposit/";
						$lname = basename($_FILES["file_deposit"]["name"]);
						$newfilename = 'deposit_'.round(microtime(true)).'.'.$ext;
						move_uploaded_file($tmp_name, $bill_copy.$newfilename);
						$fname = $newfilename;
						$data = array(
							'tanggal_transaksi' => $this->input->post('deposit_tanggal'),
							'attachment_file' => $fname,
							'kat_transaksi_id' => $this->input->post('kategori_id'),
							'pembayar_penerima_pembayaran_id' => $this->input->post('pembayar_id'),
							'payment_method_id' => $this->input->post('payment_method'),
							'description' => $qt_description,
							'reference' => $this->input->post('reference_deposit'),	
						);
						$result = $this->Keuangan_model->update_record_transaksi($data,$id);
					} else {
						$Return['error'] = $this->lang->line('umb_error_attatchment_type');
					}
				}
			}

			if($Return['error']!=''){
				$this->output($Return);
			}
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_inv_transksi_berhasil_diedit');
			} else {
				$Return['error'] = $this->lang->line('umb_error');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function read_biaya() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('biaya_id');
		$result = $this->Keuangan_model->read_informasi_transaksi($id);
		$data = array(
			'biaya_id' => $result[0]->transaksi_id,
			'type_account_id' => $result[0]->account_id,
			'jumlah' => $result[0]->jumlah,
			'tanggal_biaya' => $result[0]->tanggal_transaksi,
			'kategoriid' => $result[0]->kat_transaksi_id,
			'penerima_pembayaran_id' => $result[0]->pembayar_penerima_pembayaran_id,
			'option_penerima_pembayaran' => $result[0]->option_penerima_pembayaran,
			'perusahaan_id' => $result[0]->perusahaan_id,
			'payment_method_id' => $result[0]->payment_method_id,
			'reference_biaya' => $result[0]->reference,
			'file_biaya' => $result[0]->attachment_file,
			'description' => $result[0]->description,
			'created_at' => $result[0]->created_at,
			'all_penerima_pembayarans' => $this->Keuangan_model->all_penerima_pembayarans(),
			'all_bank_cash' => $this->Keuangan_model->all_bank_cash(),
			'all_types_biaya' => $this->Biaya_model->all_types_biaya(),
			'all_list_kategoris_pendapatan' => $this->Keuangan_model->all_list_kategoris_pendapatan(),
			'get_all_payment_method' => $this->Keuangan_model->get_all_payment_method(),
			'all_karyawans' => $this->Umb_model->all_karyawans(),
			'all_perusahaans' => $this->Umb_model->get_perusahaans()
		);
		if(!empty($session)){ 
			$this->load->view('admin/accounting/dialog_accounting', $data);
		} else {
			redirect('admin/');
		}
	}
	public function update_biaya() {

		if($this->input->post('edit_type')=='biaya') {
			$id = $this->uri->segment(4);
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$description = $this->input->post('description');
			$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
			if($this->input->post('bank_cash_id')==='') {
				$Return['error'] = $this->lang->line('umb_acc_error_field_account');
			} else if($this->input->post('jumlah')==='') {
				$Return['error'] = $this->lang->line('umb_error_field_jumlah');
			} else if($this->input->post('tanggal_biaya')==='') {
				$Return['error'] = $this->lang->line('umb_acc_error_tanggal_biaya');
			} else if($this->input->post('perusahaan')==='') {
				$Return['error'] = $this->lang->line('error_field_perusahaan');
			} else if($this->input->post('karyawan_id')==='') {
				$Return['error'] = $this->lang->line('umb_error_karyawan_id');
			}
			else if($_FILES['file_biaya']['size'] == 0) {
				$fname = 'no_file';
				$data = array(
					'account_id' => $this->input->post('bank_cash_id'),
					'jumlah' => $this->input->post('jumlah'),
					'tanggal_transaksi' => $this->input->post('tanggal_biaya'),
					'kat_transaksi_id' => $this->input->post('kategori_id'),
					'pembayar_penerima_pembayaran_id' => $this->input->post('penerima_pembayaran_id'),
					'perusahaan_id' => $this->input->post('perusahaan'),
					'payment_method_id' => $this->input->post('payment_method'),
					'description' => $qt_description,
					'reference' => $this->input->post('reference_biaya'),		
				);
				$result = $this->Keuangan_model->update_record_transaksi($data,$id);
			} else {
				if(is_uploaded_file($_FILES['file_biaya']['tmp_name'])) {

					$allowed =  array('png','jpg','jpeg','gif');
					$filename = $_FILES['file_biaya']['name'];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);

					if(in_array($ext,$allowed)){
						$tmp_name = $_FILES["file_biaya"]["tmp_name"];
						$bill_copy = "uploads/accounting/deposit/";						
						$lname = basename($_FILES["file_biaya"]["name"]);
						$newfilename = 'biaya_'.round(microtime(true)).'.'.$ext;
						move_uploaded_file($tmp_name, $bill_copy.$newfilename);
						$fname = $newfilename;
						$data = array(
							'account_id' => $this->input->post('bank_cash_id'),
							'jumlah' => $this->input->post('jumlah'),
							'tanggal_transaksi' => $this->input->post('tanggal_biaya'),
							'attachment_file' => $fname,
							'kat_transaksi_id' => $this->input->post('kategori_id'),
							'pembayar_penerima_pembayaran_id' => $this->input->post('penerima_pembayaran_id'),
							'perusahaan_id' => $this->input->post('perusahaan'),
							'payment_method_id' => $this->input->post('payment_method'),
							'description' => $qt_description,
							'reference' => $this->input->post('reference_biaya'),	
						);
						$result = $this->Keuangan_model->update_record_transaksi($data,$id);
					} else {
						$Return['error'] = $this->lang->line('umb_error_attatchment_type');
					}
				}
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_acc_sukses_biaya_diperbarui');
			} else {
				$Return['error'] = $this->lang->line('umb_error');
			}
			$this->output($Return);
			exit;
		}
	}

	public function accounts_ledger() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$id = $this->uri->segment(4);
		$bac_id = $this->Keuangan_model->read_info_transaksi_melalui_bank($id);
		$acc_bal = $this->Keuangan_model->read_informasi_bankcash($id);
		if(is_null($bac_id)){
			redirect('admin/accounting/transaksii');
		}
		$system = $this->Umb_model->read_setting_info(1);
		$data['title'] = $this->lang->line('umb_acc_ledger_account_of').' '.$acc_bal[0]->nama_account;
		$data['breadcrumbs'] = $this->lang->line('umb_acc_ledger_account');
		$data['path_url'] = 'accounting_transaksii_bijaksanabank';
		
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(!empty($session)){ 
			if(in_array('4',$role_resources_ids)) {
				$data['subview'] = $this->load->view("admin/accounting/list_ledger_account", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/dashboard');
			}
		} else {
			redirect('admin/');
		}
	}
	
	public function ledger_accounts() {

		$system = $this->Umb_model->read_setting_info(1);
		$data['title'] = $this->lang->line('umb_acc_ledger_account').' | '.$this->Umb_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('umb_acc_ledger_account');
		$data['path_url'] = 'umb_ledger_accounts';
		$session = $this->session->userdata('username');
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(!empty($session)){ 
			if(in_array('4',$role_resources_ids)) {
				$data['subview'] = $this->load->view("admin/accounting/full_list_ledger_account", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/dashboard');
			}
		} else {
			redirect('admin/');
		}
	}
	
	public function account_statement() {

		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		$system = $this->Umb_model->read_setting_info(1);
		if($system[0]->module_accounting!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('umb_acc_account_statement').' | '.$this->Umb_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('umb_acc_account_statement');
		$data['path_url'] = 'accounting_laporan_statement';
		$data['all_bank_cash'] = $this->Keuangan_model->all_bank_cash();
		$data['all_list_kategoris_pendapatan'] = $this->Keuangan_model->all_list_kategoris_pendapatan();
		$data['get_all_payment_method'] = $this->Keuangan_model->get_all_payment_method();
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('83',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/accounting/laporan_account_statement", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}
	
	public function biaya_laporan() {

		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		$system = $this->Umb_model->read_setting_info(1);
		if($system[0]->module_accounting!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('umb_acc_laporans_biaya').' | '.$this->Umb_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('umb_acc_laporans_biaya');
		$data['path_url'] = 'accounting_laporan_biaya';
		$data['all_bank_cash'] = $this->Keuangan_model->all_bank_cash();
		$data['all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$data['all_types_biaya'] = $this->Biaya_model->all_types_biaya();
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('84',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/accounting/laporan_biaya", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}
	
	public function pendapatan_laporan() {

		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		$system = $this->Umb_model->read_setting_info(1);
		if($system[0]->module_accounting!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('umb_acc_laporans_pendapatan').' | '.$this->Umb_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('umb_acc_laporans_pendapatan');
		$data['path_url'] = 'accounting_laporan_pendapatan';
		$data['all_bank_cash'] = $this->Keuangan_model->all_bank_cash();
		$data['all_list_kategoris_pendapatan'] = $this->Keuangan_model->all_list_kategoris_pendapatan();
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('85',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/accounting/laporan_pendapatan", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}
	
	public function transfer_laporan() {

		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		$system = $this->Umb_model->read_setting_info(1);
		if($system[0]->module_accounting!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('umb_acc_laporan_transfer').' | '.$this->Umb_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('umb_acc_laporan_transfer');
		$data['path_url'] = 'accounting_laporan_transfer';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('86',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/accounting/laporan_transfer", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}

	public function read_transfer(){
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('transfer_id');
		$result = $this->Keuangan_model->read_informasi_transfer($id);
		$data = array(
			'transfer_id' => $result[0]->transfer_id,
			'from_account_id' => $result[0]->from_account_id,
			'to_account_id' => $result[0]->to_account_id,
			'tanggal_transfer' => $result[0]->tanggal_transfer,
			'jumlah_transfer' => $result[0]->jumlah_transfer,
			'payment_method_id' => $result[0]->payment_method,
			'reference_transfer' => $result[0]->reference_transfer,
			'description' => $result[0]->description,
			'created_at' => $result[0]->created_at,
			'all_bank_cash' => $this->Keuangan_model->all_bank_cash(),
			'get_all_payment_method' => $this->Keuangan_model->get_all_payment_method()
		);
		if(!empty($session)){ 
			$this->load->view('admin/accounting/dialog_accounting', $data);
		} else {
			redirect('admin/');
		}
	}

	public function list_laporan_statement() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		if(!empty($session)){ 
			$this->load->view("admin/accounting/laporan_account_statement", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$transaksii = $this->Keuangan_model->search_account_statement($this->input->get('from_date'),$this->input->get('to_date'),$this->input->get('account_id'));
		$data = array();
		$crd_total = 0; $deb_total = 0;$saldo=0; $saldo2 = 0;
		foreach($transaksii->result() as $r) {
			$tanggal_transaksi = $this->Umb_model->set_date_format($r->tanggal_transaksi);
			$jumlah_total = $this->Umb_model->currency_sign($r->jumlah);
			$acc_type = $this->Keuangan_model->read_informasi_bankcash($r->account_id);
			if(!is_null($acc_type)){
				$saldo_account = $acc_type[0]->pembukanaan_saldo_account;
			} else {
				$saldo_account = 0;	
			}
			if($r->dr_cr == 'cr') {
				$saldo2 = $saldo2 - $r->jumlah;
			} else {
				$saldo2 = $saldo2 + $r->jumlah;
			}
			if($r->credit!=0):
				$crd = $r->credit;
				$crd_total += $crd;
			else:
				$crd = 0;	
				$crd_total += $crd;
			endif;
			if($r->debit!=0):
				$deb = $r->debit;
				$deb_total += $deb;
			else:
				$deb = 0;	
				$deb_total += $deb;
			endif;
			$data[] = array(
				$tanggal_transaksi,
				$r->type_transaksi,
				$r->description,
				$this->Umb_model->currency_sign($crd),
				$this->Umb_model->currency_sign($deb)
			);
		}
		$output = array(
			"draw" => $draw,
			"recordsTotal" => $transaksii->num_rows(),
			"recordsFiltered" => $transaksii->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}
	
	public function get_footer_statement() {

		$data['title'] = $this->Umb_model->site_title();
		
		$data = array(
			'from_date' => $this->input->get('from_date'),
			'to_date' => $this->input->get('to_date'),
			'account_id' => $this->input->get('account_id')
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/accounting/footer/get_footer_statement", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}

	public function list_laporan_biaya(){

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		if(!empty($session)){ 
			$this->load->view("admin/accounting/laporan_biaya", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$biaya = $this->Keuangan_model->get_search_biaya($this->input->get('from_date'),$this->input->get('to_date'),$this->input->get('type_id'),$this->input->get('perusahaan_id'));
		$data = array();
		foreach($biaya->result() as $r) {
			$jumlah = $this->Umb_model->currency_sign($r->jumlah);
			$acc_type = $this->Keuangan_model->read_informasi_bankcash($r->account_id);
			if(!is_null($acc_type)){
				$account = $acc_type[0]->nama_account;
			} else {
				$account = '--';	
			}
			$penerima_pembayaran = $this->Umb_model->read_user_info($r->pembayar_penerima_pembayaran_id);
			if(!is_null($penerima_pembayaran)){
				$full_name = $penerima_pembayaran[0]->first_name.' '.$penerima_pembayaran[0]->last_name;
			} else {
				$full_name = '--';	
			}
			$tanggal_biaya = $this->Umb_model->set_date_format($r->tanggal_transaksi);
			
			$type_biaya = $this->Biaya_model->read_informasi_type_biaya($r->kat_transaksi_id);
			if(!is_null($type_biaya)){
				$kategori = $type_biaya[0]->name;
			} else {
				$kategori = '--';	
			}
			
			$data[] = array(
				$tanggal_biaya,
				$account,
				$kategori,
				$full_name,
				$jumlah,
			);
		}
		$output = array(
			"draw" => $draw,
			"recordsTotal" => $biaya->num_rows(),
			"recordsFiltered" => $biaya->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function get_footer_biaya() {

		$data['title'] = $this->Umb_model->site_title();
		
		$data = array(
			'from_date' => $this->input->get('from_date'),
			'to_date' => $this->input->get('to_date'),
			'type_id' => $this->input->get('type_id'),
			'perusahaan_id' => $this->input->get('perusahaan_id')
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/accounting/footer/get_footer_biaya", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}

	public function list_laporan_pendapatan() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		if(!empty($session)){ 
			$this->load->view("admin/accounting/laporan_pendapatan", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$deposit = $this->Keuangan_model->get_search_deposit($this->input->get('from_date'),$this->input->get('to_date'),$this->input->get('type_id'));
		$data = array();
		foreach($deposit->result() as $r) {
			$acc_type = $this->Keuangan_model->read_informasi_bankcash($r->account_id);
			if(!is_null($acc_type)){
				$account = $acc_type[0]->nama_account;
			} else {
				$account = '--';	
			}
			$pembayar = $this->Keuangan_model->read_info_pembayar($r->pembayar_penerima_pembayaran_id);
			if(!is_null($pembayar)){
				$full_name = $pembayar[0]->nama_pembayar;
			} else {
				$full_name = '--';	
			}
			$deposit_tanggal = $this->Umb_model->set_date_format($r->tanggal_transaksi);
			$kategori_id = $this->Keuangan_model->read_kategori_pendapatan($r->kat_transaksi_id);
			if(!is_null($kategori_id)){
				$kategori = $kategori_id[0]->name;
			} else {
				$kategori = '--';	
			}
			$jumlah = $this->Umb_model->currency_sign($r->jumlah);
			$data[] = array(
				$deposit_tanggal,
				$account,
				$kategori,
				$full_name,
				$jumlah		
			);
		}
		$output = array(
			"draw" => $draw,
			"recordsTotal" => $deposit->num_rows(),
			"recordsFiltered" => $deposit->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	} 

	public function list_laporan_transfer() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		if(!empty($session)){ 
			$this->load->view("admin/accounting/laporan_transfer", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$transfer = $this->Keuangan_model->get_search_transfer($this->input->get('from_date'),$this->input->get('to_date'));
		$data = array();
		foreach($transfer->result() as $r) {
			$jumlah = $this->Umb_model->currency_sign($r->jumlah);
			if($r->dr_cr == 'cr') {
				$umb_acc = $this->lang->line('umb_acc_credit');
			} else {
				$umb_acc = $this->lang->line('umb_acc_debit');
			}			
			$tanggal_transfer = $this->Umb_model->set_date_format($r->tanggal_transaksi);
			$payment_method = $this->Umb_model->read_payment_method($r->payment_method_id);
			if(!is_null($payment_method)){
				$method_name = $payment_method[0]->method_name;
			} else {
				$method_name = '--';	
			}
			$r->dr_cr=="dr" ? $this->lang->line('umb_acc_debit') : $this->lang->line('umb_acc_credit');
			$r->debit!=NULL ? $db_am = "- ".$this->Umb_model->currency_sign($r->debit) : $db_am ="";
			$r->credit!=NULL ? $cr_am = "+ ".$this->Umb_model->currency_sign($r->credit) : $cr_am ="";
			$acc_type = $this->Keuangan_model->read_informasi_bankcash($r->account_id);
			if(!is_null($acc_type)){
				$account = $acc_type[0]->nama_account;
			} else {
				$account = '--';	
			}
			$data[] = array(
				$tanggal_transfer,
				$r->description,
				$account,
				$umb_acc,
				$db_am,
				$cr_am
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

	public function list_laporan_pendapatan_biaya() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$account_statement = $this->Keuangan_model->get_search_pendapatan_biaya($this->input->get('from_date'),$this->input->get('to_date'));
		$data = array();
		$debit="";
		$debit_total=0;
		$credit="";
		$credit_total=0;
		foreach($account_statement->result() as $r) {
			if($r->transaksi_credit!=0.00 && $r->transaksi_credit > 0){
				$credit_total=$credit_total+$r->transaksi_credit;
			}
			else if($r->transaksi_debit!=0.00 && $r->transaksi_debit > 0){
				$debit_total = $debit_total+$r->transaksi_debit;
			}
		}
		$totalD = "<b class='pull-right'>".$this->lang->line('umb_acc_total_credit').": ".$this->Umb_model->currency_sign($debit_total)."</b>";
		$totalC = "<b class='pull-right'>".$this->lang->line('umb_acc_total_debit').": ".$this->Umb_model->currency_sign($credit_total)."</b>";
		$data[] = array(
			$totalC.' '.$totalC,
			$totalD.' '.$totalD
		);
		$output = array(
			"draw" => $draw,
			"recordsTotal" => $account_statement->num_rows(),
			"recordsFiltered" => $account_statement->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function list_accounts_ledger() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		if(!empty($session)){ 
			$this->load->view("admin/accounting/full_list_ledger_account", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$acc_ledger = $this->Keuangan_model->get_ledger_accounts($this->input->get('from_date'),$this->input->get('to_date'));
		$data = array();
		$crd_total = 0; $deb_total = 0;$saldo=0; $saldo2 = 0;
		foreach($acc_ledger->result() as $r) {
			$tanggal_transaksi = $this->Umb_model->set_date_format($r->tanggal_transaksi);
			$jumlah_total = $this->Umb_model->currency_sign($r->jumlah);
			$acc_type = $this->Keuangan_model->read_informasi_bankcash($r->account_id);
			if(!is_null($acc_type)){
				$saldo_account = $acc_type[0]->pembukanaan_saldo_account;
			} else {
				$saldo_account = 0;	
			}
			if($r->dr_cr == 'cr') {
				$saldo2 = $saldo2 - $r->jumlah;
			} else {
				$saldo2 = $saldo2 + $r->jumlah;
			}
			if($r->credit!=0):
				$crd = $r->credit;
				$crd_total += $crd;
			else:
				$crd = 0;	
				$crd_total += $crd;
			endif;
			if($r->debit!=0):
				$deb = $r->debit;
				$deb_total += $deb;
			else:
				$deb = 0;	
				$deb_total += $deb;
			endif;
			$fsaldo = $saldo_account + $saldo2;
			$data[] = array(
				$tanggal_transaksi,
				$r->type_transaksi,
				$r->description,
				$this->Umb_model->currency_sign($crd),
				$this->Umb_model->currency_sign($deb),
				$this->Umb_model->currency_sign($fsaldo)
			);
		}
		$output = array(
			"draw" => $draw,
			"recordsTotal" => $acc_ledger->num_rows(),
			"recordsFiltered" => $acc_ledger->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	} 

	public function get_footer_accounts_ledger() {

		$data['title'] = $this->Umb_model->site_title();
		
		$data = array(
			'from_date' => $this->input->get('from_date'),
			'to_date' => $this->input->get('to_date')
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/accounting/footer/get_footer_ledger_accounts", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}

	public function add_pembayar() {

		if($this->input->post('add_type')=='add_pembayar') {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			if($this->input->post('nama_pembayar')==='') {
				$Return['error'] = $this->lang->line('umb_acc_error_nama_pembayar');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$data = array(
				'nama_pembayar' => $this->input->post('nama_pembayar'),
				'nomor_kontak' => $this->input->post('nomor_kontak'),
				'created_at' => date('d-m-Y h:i:s')
			);
			$result = $this->Keuangan_model->add_record_pembayar($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_acc_sukses_pembayar_ditambahkan');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function add_penerima_pembayaran() {

		if($this->input->post('add_type')=='add_penerima_pembayaran') {		
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			if($this->input->post('nama_penerima_pembayaran')==='') {
				$Return['error'] = $this->lang->line('umb_acc_error_nama_penerima_pembayaran');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$data = array(
				'nama_penerima_pembayaran' => $this->input->post('nama_penerima_pembayaran'),
				'nomor_kontak' => $this->input->post('nomor_kontak'),
				'created_at' => date('d-m-Y h:i:s')
			);
			$result = $this->Keuangan_model->add_record_penerima_pembayaran($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_acc_sukses_penerima_pembayaran_ditambahkan');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	
	public function update_pembayar() {

		if($this->input->post('edit_type')=='pembayar') {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			if($this->input->post('nama_pembayar')==='') {
				$Return['error'] = $this->lang->line('umb_acc_error_nama_pembayar');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$data = array(
				'nama_pembayar' => $this->input->post('nama_pembayar'),
				'nomor_kontak' => $this->input->post('nomor_kontak'),
			);
			$result = $this->Keuangan_model->update_record_pembayar($data,$id);
			if ($id) {
				$Return['result'] = $this->lang->line('umb_acc_sukses_pembayar_diperbarui');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function update_penerima_pembayaran() {

		if($this->input->post('edit_type')=='penerima_pembayaran') {		
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			if($this->input->post('nama_penerima_pembayaran')==='') {
				$Return['error'] = $this->lang->line('umb_acc_error_nama_penerima_pembayaran');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$data = array(
				'nama_penerima_pembayaran' => $this->input->post('nama_penerima_pembayaran'),
				'nomor_kontak' => $this->input->post('nomor_kontak'),
			);
			$result = $this->Keuangan_model->update_record_penerima_pembayaran($data,$id);
			if ($id) {
				$Return['result'] = $this->lang->line('umb_acc_sukses_penerima_pembayaran_diperbarui');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function delete_pembayar() {
		
		if($this->input->post('is_ajax')=='2') {
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Keuangan_model->delete_record_pembayar($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_acc_sukses_pembayar_dihapus');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}
	
	
	public function delete_penerima_pembayaran() {
		
		if($this->input->post('is_ajax')=='2') {
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Keuangan_model->delete_record_penerima_pembayaran($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_acc_sukses_penerima_pembayaran_dihapus');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}

	public function list_transaksii_bijaksanabank() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		if(!empty($session)){ 
			$this->load->view("admin/accounting/full_list_ledger_account", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$ac_id = $this->uri->segment(4);
		$transaksii = $this->Keuangan_model->get_transaksii_bijaksanabank($ac_id);
		$data = array();
		$saldo2 = 0;
		foreach($transaksii->result() as $r) {
			$tanggal_transaksi = $this->Umb_model->set_date_format($r->tanggal_transaksi);
			$jumlah_total = $this->Umb_model->currency_sign($r->jumlah);
			$baccount = $this->Keuangan_model->read_informasi_bankcash($r->account_id);
			if(!is_null($baccount)) {
				$saldo_account = 0;
				$saldo_account = $baccount[0]->pembukanaan_saldo_account;
				if($saldo_account == ''){
					$saldo_account = 0;
				} else {
					$saldo_account = $saldo_account;
				}
				if($r->dr_cr == 'cr') {
					$dr_jumlah = $this->Umb_model->currency_sign(0);
					$cr_jumlah = $this->Umb_model->currency_sign($r->jumlah);
					$saldo2 = $saldo2 - $r->credit;
				} else {
					$dr_jumlah = $this->Umb_model->currency_sign($r->jumlah);
					$cr_jumlah = $this->Umb_model->currency_sign(0);
					$saldo2 = $saldo2 + $r->debit;
				}
				$fsaldo = $saldo_account + $saldo2;
				$fsaldo = $this->Umb_model->currency_sign($fsaldo);
				$data[] = array(
					$tanggal_transaksi,
					$r->type_transaksi,
					$r->description,
					$cr_jumlah,
					$dr_jumlah,
					$fsaldo
				);
			}
		}
		$output = array(
			"draw" => $draw,
			"recordsTotal" => $transaksii->num_rows(),
			"recordsFiltered" => $transaksii->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	} 	
	
	public function get_footer_pendapatan() {

		$data['title'] = $this->Umb_model->site_title();
		
		$data = array(
			'from_date' => $this->input->get('from_date'),
			'to_date' => $this->input->get('to_date'),
			'type_id' => $this->input->get('type_id')
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/accounting/footer/get_footer_pendapatan", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}

	public function get_footer_transfer() {

		$data['title'] = $this->Umb_model->site_title();
		
		$data = array(
			'from_date' => $this->input->get('from_date'),
			'to_date' => $this->input->get('to_date')
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/accounting/footer/get_footer_transfer", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}

	public function get_all_penerima_pembayaran() {

		$data['title'] = $this->Umb_model->site_title();
		$id = 1;		
		$data = array(
			'hrastral' => $id
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$data = $this->security->xss_clean($data);
			$this->load->view("admin/accounting/get_all_penerima_pembayaran", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}
} 
?>