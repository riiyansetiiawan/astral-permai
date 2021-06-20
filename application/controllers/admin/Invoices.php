<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Invoices extends MY_Controller {


	public function output($Return=array()){
		
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		
		exit(json_encode($Return));
	}
	
	public function __construct() {

		parent::__construct();

		$this->load->model('Perusahaan_model');
		$this->load->model('Umb_model');
		$this->load->model("Project_model");
		$this->load->model("Pajak_model");
		$this->load->model("Invoices_model");
		$this->load->model("Clients_model");
		$this->load->model("Keuangan_model");
	}

	public function index() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('umb_invoices_title').' | '.$this->Umb_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('umb_invoices_title');
		$data['all_projects'] = $this->Project_model->get_projects();
		$data['all_pajaks'] = $this->Pajak_model->get_all_pajaks();
		$data['path_url'] = 'hrastral_invoices';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('121',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/invoices/list_invoices", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
		} else {
			redirect('admin/dashboard');
		}
	}

	public function history_pembayarans() {

		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('umb_acc_pembayarans_invoice').' | '.$this->Umb_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('umb_acc_pembayarans_invoice');
		$data['path_url'] = 'umb_invoice_pembayaran';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('121',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/invoices/list_invoice_pembayaran", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/');
			}
		}
	}

	public function create() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('umb_create_invoice').' | '.$this->Umb_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('umb_create_invoice');
		$data['all_projects'] = $this->Project_model->get_projects();
		$data['all_pajaks'] = $this->Pajak_model->get_all_pajaks();
		$data['path_url'] = 'create_hrastral_invoice';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('120',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/invoices/create_invoice", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
		} else {
			redirect('admin/dashboard');
		}
	}
	
	public function pajaks() {
		$data['title'] = $this->lang->line('umb_invoice_types_pajak').' | '.$this->Umb_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('umb_invoice_types_pajak');
		$data['path_url'] = 'invoice_pajaks';
		$session = $this->session->userdata('username');
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('122',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/invoices/invoice_pajaks", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}

	public function calendar_invoice() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('umb_calendar_invoice');
		$data['breadcrumbs'] = $this->lang->line('umb_calendar_invoice');
		$data['completed_invoices'] = $this->Invoices_model->get_completed_invoices();
		$data['pending_invoices'] = $this->Invoices_model->get_pending_invoices();
		$data['path_url'] = 'calendar_invoice';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('121',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/invoices/calendar_invoice", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
		} else {
			redirect('admin/dashboard');
		}
	}

	public function list_invoice_pembayaran() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		if(!empty($session)){ 
			$this->load->view("client/invoices/list_invoice_pembayaran", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$role_resources_ids = $this->Umb_model->user_role_resource();
		$user_info = $this->Umb_model->read_user_info($session['user_id']);
		$transaksi = $this->Invoices_model->get_client_all_pembayarans_invoice();
		
		$data = array();
		$saldo2 = 0;
		foreach($transaksi->result() as $r) {
			
			$tanggal_transaksi = $this->Umb_model->set_date_format($r->tanggal_transaksi);
			
			$jumlah_total = $this->Umb_model->currency_sign($r->jumlah);
			$cr_dr = $r->dr_cr=="dr" ? "Debit" : "Credit";
			$info_invoice = $this->Invoices_model->read_info_invoice($r->invoice_id);
			if(!is_null($info_invoice)){
				$no_inv = $info_invoice[0]->nomor_invoice;
			} else {
				$no_inv = '--';	
			}

			$payment_method = $this->Umb_model->read_payment_method($r->payment_method_id);
			if(!is_null($payment_method)){
				$method_name = $payment_method[0]->method_name;
			} else {
				$method_name = '--';	
			}	

			$clientinfo = $this->Clients_model->read_info_client($r->client_id);
			if(!is_null($clientinfo)){
				$name_name = $clientinfo[0]->name;
			} else {
				$name_name = '--';	
			}
			
			$nomor_invoice = '<a href="'.site_url().'admin/invoices/view/'.$r->invoice_id.'/">'.$no_inv.'</a>';					
			$data[] = array(
				$nomor_invoice,
				$name_name,
				$tanggal_transaksi,
				$jumlah_total,
				$method_name,
				$r->description
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

	public function list_pajaks() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/invoices/invoice_pajaks", $data);
		} else {
			redirect('admin/dashboard');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$pajaks = $this->Invoices_model->get_pajaks();
		$role_resources_ids = $this->Umb_model->user_role_resource();
		$data = array();

		foreach($pajaks->result() as $r) {
			
			if($r->type == 'fixed'): 
				$type = $this->lang->line('umb_title_fixed_pajak'); 
			else: 
				$type = $this->lang->line('umb_title_percent_pajak'); 
			endif;
			if(in_array('332',$role_resources_ids)) {
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="Edit"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-pajak_id="'. $r->pajak_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('333',$role_resources_ids)) { 
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="Delete"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->pajak_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}

			$combhr = $edit.$delete;
			$data[] = array(
				$combhr,
				$r->name,
				$r->rate,
				$type
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $pajaks->num_rows(),
			"recordsFiltered" => $pajaks->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function read_pajak() {

		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('pajak_id');
		$result = $this->Invoices_model->read_informasi_pajak($id);
		$data = array(
			'pajak_id' => $result[0]->pajak_id,
			'name' => $result[0]->name,
			'rate' => $result[0]->rate,
			'type' => $result[0]->type,
			'description' => $result[0]->description
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/invoices/dialog_pajak', $data);
		} else {
			redirect('admin/');
		}
	}


	public function add_pajak() {

		if($this->input->post('add_type')=='pajak') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();


			$description = $this->input->post('description');
			$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);

			if($this->input->post('nama_pajak')==='') {
				$Return['error'] = "Bidang nama pajak harus diisi.";
			} else if($this->input->post('nilai_pajak')==='') {
				$Return['error'] = "Bidang nilai pajak harus diisi.";
			} else if($this->input->post('type_pajak')==='') {
				$Return['error'] = "Bidang jenis pajak harus diisi.";
			}

			if($Return['error']!=''){
				$this->output($Return);
			}

			$data = array(
				'name' => $this->input->post('nama_pajak'),
				'rate' => $this->input->post('nilai_pajak'),
				'type' => $this->input->post('type_pajak'),
				'description' => $qt_description,
				'created_at' => date('d-m-Y h:i:s'),

			);
			$result = $this->Invoices_model->add_record_pajak($data);

			if ($result == TRUE) {
				$Return['result'] = 'Pajak Produk ditambahkan.';
			} else {
				$Return['error'] = 'Bug. Ada yang tidak beres, coba lagi.';
			}
			$this->output($Return);
			exit;
		}
	}

	public function update_pajak() {

		if($this->input->post('edit_type')=='pajak') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();

			$id = $this->uri->segment(4);

			$description = $this->input->post('description');
			$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);

			if($this->input->post('nama_pajak')==='') {
				$Return['error'] = "Bidang nama pajak harus diisi.";
			} else if($this->input->post('nilai_pajak')==='') {
				$Return['error'] = "Bidang nilai pajak harus diisi.";
			} else if($this->input->post('type_pajak')==='') {
				$Return['error'] = "Bidang jenis pajak harus diisi.";
			}

			if($Return['error']!=''){
				$this->output($Return);
			}

			$data = array(
				'name' => $this->input->post('nama_pajak'),
				'rate' => $this->input->post('nilai_pajak'),
				'type' => $this->input->post('type_pajak'),
				'description' => $qt_description		
			);
			$result = $this->Invoices_model->update_record_pajak($data,$id);

			if ($result == TRUE) {
				$Return['result'] = 'Pajak Produk diperbarui.';
			} else {
				$Return['error'] = 'Bug. Ada yang tidak beres, coba lagi.';
			}
			$this->output($Return);
			exit;
		}
	}

	public function edit() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');

		$invoice_id = $this->uri->segment(4);
		$info_invoice = $this->Invoices_model->read_info_invoice($invoice_id);
		if(is_null($info_invoice)){
			redirect('admin/invoices');
		}
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(!in_array('328',$role_resources_ids)) {
			redirect('admin/invoices');
		}

		$project = $this->Project_model->read_informasi_project($info_invoice[0]->project_id);
		//	$negara = $this->Umb_model->read_info_negara($supplier[0]->negara_id);
		$perusahaan = $this->Umb_model->read_info_setting_perusahaan(1);
		$cnegara = $this->Umb_model->read_info_negara($perusahaan[0]->negara);
		$data = array(
			'title' => $this->lang->line('umb_title_edit_invoice').' '.$info_invoice[0]->invoice_id,
			'breadcrumbs' => $this->lang->line('umb_title_edit_invoice'),
			'path_url' => 'create_hrastral_invoice',
			'invoice_id' => $info_invoice[0]->invoice_id,
			'nomor_invoice' => $info_invoice[0]->nomor_invoice,
			'project_id' => $project[0]->project_id,
			'tanggal_invoice' => $info_invoice[0]->tanggal_invoice,
			'tanggal_jatoh_tempo_invoice' => $info_invoice[0]->tanggal_jatoh_tempo_invoice,
			'sub_jumlah_total' => $info_invoice[0]->sub_jumlah_total,
			'type_discount' => $info_invoice[0]->type_discount,
			'angka_discount' => $info_invoice[0]->angka_discount,
			'total_pajak' => $info_invoice[0]->total_pajak,
			'total_discount' => $info_invoice[0]->total_discount,
			'grand_total' => $info_invoice[0]->grand_total,
			'catatan_invoice' => $info_invoice[0]->catatan_invoice,
			'all_projects' => $this->Project_model->get_projects(),
			'all_pajaks' => $this->Pajak_model->get_all_pajaks(),
		);
		$role_resources_ids = $this->Umb_model->user_role_resource();
		//if(in_array('3',$role_resources_ids)) {
		$data['subview'] = $this->load->view("admin/invoices/edit_invoice", $data, TRUE);
		$this->load->view('admin/layout/layout_main', $data); 			
		//} else {
		//	redirect('admin/dashboard/');
		//}		  
	}
	
	public function view() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		
		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		
		$invoice_id = $this->uri->segment(4);
		$info_invoice = $this->Invoices_model->read_info_invoice($invoice_id);
		if(is_null($info_invoice)){
			redirect('admin/invoices');
		}
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(!in_array('330',$role_resources_ids)) {
			redirect('admin/invoices');
		}

		$project = $this->Project_model->read_informasi_project($info_invoice[0]->project_id);
		//	$negara = $this->Umb_model->read_info_negara($supplier[0]->negara_id);
		$perusahaan = $this->Umb_model->read_info_setting_perusahaan(1);
		$cnegara = $this->Umb_model->read_info_negara($perusahaan[0]->negara);
		if(!is_null($project)){
			$nama_project = $project[0]->title;
			$project_id = $project[0]->project_id;
			$no_project = $project[0]->no_pembelian;
		} else {
			$nama_project = '--';	
			$no_project = '--';
			$project_id = '--';
		}
		$data = array(
			'title' => $this->lang->line('umb_view_invoice').' ' .$info_invoice[0]->invoice_id,
			'breadcrumbs' => $this->lang->line('umb_view_invoice'),
			'path_url' => 'create_hrastral_invoice',
			'invoice_id' => $info_invoice[0]->invoice_id,
			'status' => $info_invoice[0]->status,
			'nomor_invoice' => $info_invoice[0]->nomor_invoice,
			'project_id' => $project_id,
			'no_project' => $no_project,
			'nama_project' => $nama_project,
			'tanggal_invoice' => $info_invoice[0]->tanggal_invoice,
			'tanggal_jatoh_tempo_invoice' => $info_invoice[0]->tanggal_jatoh_tempo_invoice,
			'sub_jumlah_total' => $info_invoice[0]->sub_jumlah_total,
			'type_discount' => $info_invoice[0]->type_discount,
			'angka_discount' => $info_invoice[0]->angka_discount,
			'total_pajak' => $info_invoice[0]->total_pajak,
			'total_discount' => $info_invoice[0]->total_discount,
			'grand_total' => $info_invoice[0]->grand_total,
			'catatan_invoice' => $info_invoice[0]->catatan_invoice,
			'nama_perusahaan' => $perusahaan[0]->nama_perusahaan,
			'alamat_perusahaan' => $perusahaan[0]->alamat_1,
			'kode_pos_perusahaan' => $perusahaan[0]->kode_pos,
			'kota_perusahaan' => $perusahaan[0]->kota,
			'phone_perusahaan' => $perusahaan[0]->phone,
			'negara_perusahaan' => $cnegara[0]->nama_negara,
			//'negara_perusahaan' => $cnegara[0]->nama_negara,
			'name' => $info_invoice[0]->name,
			'nama_perusahaan_client' => $info_invoice[0]->nama_perusahaan,
			'profile_client' => $info_invoice[0]->profile_client,
			'email' => $info_invoice[0]->email,
			'nomor_kontak' => $info_invoice[0]->nomor_kontak,
			'website_url' => $info_invoice[0]->website_url,
			'alamat_1' => $info_invoice[0]->alamat_1,
			'alamat_2' => $info_invoice[0]->alamat_2,
			'kota' => $info_invoice[0]->kota,
			'provinsi' => $info_invoice[0]->provinsi,
			'kode_pos' => $info_invoice[0]->kode_pos,
			'negaraid' => $info_invoice[0]->negaraid,
			'all_projects' => $this->Project_model->get_projects(),
			'all_pajaks' => $this->Pajak_model->get_all_pajaks(),
		);
		$role_resources_ids = $this->Umb_model->user_role_resource();
		//if(in_array('3',$role_resources_ids)) {
		$data['subview'] = $this->load->view("admin/invoices/view_invoice", $data, TRUE);
		$this->load->view('admin/layout/layout_main', $data); 			
		//} else {
		//	redirect('admin/dashboard/');
		//}		  
	}

	public function read_data_invoice() {

		$data['title'] = $this->Umb_model->site_title();
		$invoice_id = $this->input->get('invoice_id');
		$info_invoice = $this->Invoices_model->read_info_invoice($invoice_id);
		$data = array(
			'invoice_id' => $info_invoice[0]->invoice_id,
			'invoice_status' => $info_invoice[0]->status,
			'nomor_invoice' => $info_invoice[0]->nomor_invoice,
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/invoices/dialog_invoice', $data);
		} else {
			redirect('admin/');
		}

		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));				  
	}
	
	public function update_status_invoice() {

		if($this->input->post('edit_type')=='update_status') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();	
			
			$data = array(
				'status' => $this->input->post('status'),
			);
			$id = $this->input->post('invoice_id');
			if($this->input->post('status') == 1){
				$system_settings = system_settings_info(1);	
				if($system_settings->online_payment_account == ''){
					$online_payment_account = 0;
				} else {
					$online_payment_account = $system_settings->online_payment_account;
				}
				$invoice = $this->Invoices_model->read_info_invoice($id);
				$jumlah = $invoice[0]->grand_total;
				$result = $this->Invoices_model->update_record_invoice($data,$id);
				$ivdata = array(
					'jumlah' => $jumlah,
					'account_id' => $online_payment_account,
					'type_transaksi' => 'pendapatan',
					'dr_cr' => 'dr',
					'tanggal_transaksi' => date('Y-m-d'),
					'pembayar_penerima_pembayaran_id' => $invoice[0]->client_id,
					'payment_method_id' => 3,
					'description' => 'Invoice Pembayaran',
					'reference' => 'Invoice Pembayaran',
					'invoice_id' => $id,
					'client_id' => $invoice[0]->client_id,
					'created_at' => date('Y-m-d H:i:s')
				);
				$this->Keuangan_model->add_transaksii($ivdata);
				if ($result == TRUE) {

					$account_id = $this->Keuangan_model->read_informasi_bankcash($online_payment_account);
					$acc_saldo = $account_id[0]->saldo_account - $jumlah;

					$data3 = array(
						'saldo_account' => $acc_saldo
					);
					$this->Keuangan_model->update_record_bankcash($data3,$online_payment_account);
					$Return['result'] = $this->lang->line('umb_invoice_has_been_bayar');
					$this->session->set_flashdata('response',$this->lang->line('umb_invoice_has_been_bayar'));
				} else {
					$Return['error'] = $this->lang->line('umb_error_msg');
				}
			} else {
				$Return['result'] = $this->lang->line('umb_invoice_still_un_bayar');
				$this->session->set_flashdata('response',$this->lang->line('umb_invoice_still_un_bayar'));
			}

			$this->output($Return);
			exit;
		}
	}

	public function list_invoices() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/invoices/list_invoices", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$client = $this->Invoices_model->get_invoices();
		$role_resources_ids = $this->Umb_model->user_role_resource();
		$data = array();

		foreach($client->result() as $r) {

			$grand_total = $this->Umb_model->currency_sign($r->grand_total);

			$project = $this->Project_model->read_informasi_project($r->project_id); 
			if(!is_null($project)){
				$nama_project = $project[0]->title;
			} else {
				$nama_project = '--';	
			}
			$tanggal_invoice = '<i class="far fa-calendar-alt position-left"></i> '.$this->Umb_model->set_date_format($r->tanggal_invoice);
			$tanggal_jatoh_tempo_invoice = '<i class="far fa-calendar-alt position-left"></i> '.$this->Umb_model->set_date_format($r->tanggal_jatoh_tempo_invoice);

			$nomor_invoice = '';
			if(in_array('330',$role_resources_ids)) {
				$nomor_invoice = '<a href="'.site_url().'admin/invoices/view/'.$r->invoice_id.'/">'.$r->nomor_invoice.'</a>';
			} else {
				$nomor_invoice = $r->nomor_invoice;
			}
			if(in_array('328',$role_resources_ids)) {
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_edit').'"><a href="'.site_url().'admin/invoices/edit/'.$r->invoice_id.'/"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="fas fa-pencil-alt"></span></button></a></span>';
			} else {
				$edit = '';
			}
			if(in_array('329',$role_resources_ids)) {
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->invoice_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}
			if(in_array('330',$role_resources_ids)) {
				$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_view').'"><a href="'.site_url().'admin/invoices/view/'.$r->invoice_id.'/"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light""><span class="fa fa-arrow-circle-right"></span></button></a></span>';
			} else {
				$view = '';
			}
			if(in_array('330',$role_resources_ids)) {
				$qstatus = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_change_status').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light delete" data-toggle="modal" data-target=".add-modal-data" data-invoice_id="'. $r->invoice_id . '"><span class="fas fa-exchange-alt"></span></button></span>';
			} else {
				$qstatus = '';
			}
			if($r->status == 0){
				$status = '<span class="label label-danger">'.$this->lang->line('umb_payroll_belum_dibayar').'</span>';
				$combhr = $edit.$view.$qstatus.$delete;
			} else if($r->status == 1) {
				$status = '<span class="label label-success">'.$this->lang->line('umb_payment_bayar').'</span>';
				$combhr = $view.$delete;
			} else {
				$status = '<span class="label label-info">'.$this->lang->line('umb_acc_inv_cancelled').'</span>';
				$combhr = $edit.$view.$qstatus.$delete;
			}
			
			$data[] = array(
				$combhr,
				$nomor_invoice,
				$nama_project,
				$grand_total,
				$tanggal_invoice,
				$tanggal_jatoh_tempo_invoice,
				$status,
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $client->num_rows(),
			"recordsFiltered" => $client->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}
	
	
	public function create_new_invoice() {

		if($this->input->post('add_type')=='create_invoice') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
			if($this->input->post('nomor_invoice')==='') {
				$Return['error'] = "Bidang nomor faktur harus diisi.";
			} else if($this->input->post('tanggal_invoice')==='') {
				$Return['error'] = "Bidang tanggal faktur harus diisi.";
			} else if($this->input->post('tanggal_jatoh_tempo_invoice')==='') {
				$Return['error'] = "Bidang tanggal jatuh tempo faktur harus diisi.";
			} else if($this->input->post('unit_price')==='') {
				$Return['error'] = "Bidang tanggal jatuh tempo faktur harus diisi.";
			}

			if($Return['error']!=''){
				$this->output($Return);
			}

			$j=0; foreach($this->input->post('item_name') as $items){
				$item_name = $this->input->post('item_name');
				$iname = $item_name[$j];

				$qty = $this->input->post('qty_hrs');
				$qtyhrs = $qty[$j];

				$unit_price = $this->input->post('unit_price');
				$price = $unit_price[$j];
				
				if($iname==='') {
					$Return['error'] = "Bidang Item harus diisi.";
				} else if($qty==='') {
					$Return['error'] = "Bidang Jumlah / jam harus diisi.";
				} else if($price==='' || $price===0) {
					$Return['error'] = $j. " Bidang Harga harus diisi.";
				}
				$j++;
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$proj_info = $this->Project_model->read_informasi_project($this->input->post('project'));		
			$clientinfo = $this->Clients_model->read_info_client($proj_info[0]->client_id);
			$data = array(
				'project_id' => $this->input->post('project'),
				'client_id' => $proj_info[0]->client_id,
				'nomor_invoice' => $this->input->post('nomor_invoice'),
				'tanggal_invoice' => $this->input->post('tanggal_invoice'),
				'tanggal_jatoh_tempo_invoice' => $this->input->post('tanggal_jatoh_tempo_invoice'),
				'sub_jumlah_total' => $this->input->post('items_sub_total'),
				'total_pajak' => $this->input->post('items_pajak_total'),
				'type_discount' => $this->input->post('type_discount'),
				'angka_discount' => $this->input->post('angka_discount'),
				'total_discount' => $this->input->post('jumlah_discount'),
				'grand_total' => $this->input->post('fgrand_total'),
				'catatan_invoice' => $this->input->post('catatan_invoice'),
				'name' => $clientinfo[0]->name,
				'nama_perusahaan' => $clientinfo[0]->nama_perusahaan,
				'profile_client' => $clientinfo[0]->profile_client,
				'email' => $clientinfo[0]->email,
				'nomor_kontak' => $clientinfo[0]->nomor_kontak,
				'website_url' => $clientinfo[0]->website_url,
				'alamat_1' => $clientinfo[0]->alamat_1,
				'alamat_2' => $clientinfo[0]->alamat_2,
				'kota' => $clientinfo[0]->kota,
				'provinsi' => $clientinfo[0]->provinsi,
				'kode_pos' => $clientinfo[0]->kode_pos,
				'negaraid' => $clientinfo[0]->negara,
				'status' => '0',
				'created_at' => date('d-m-Y H:i:s')
			);
			$result = $this->Invoices_model->add_record_invoice($data);
			if ($result) {
				$key=0;
				foreach($this->input->post('item_name') as $items){
					//$iname = $items['item_name']; 
					$item_name = $this->input->post('item_name');
					$iname = $item_name[$key]; 

					$qty = $this->input->post('qty_hrs');
					$qtyhrs = $qty[$key]; 

					$unit_price = $this->input->post('unit_price');
					$price = $unit_price[$key]; 
					$typpajak = $this->input->post('type_pajak');
					$type_pajak = $typpajak[$key]; 

					$nilai_pajak_item = $this->input->post('nilai_pajak_item');
					$nilai_pajak = $nilai_pajak_item[$key];

					$sub_total_item = $this->input->post('sub_total_item');
					$item_sub_total = $sub_total_item[$key];
					$data2 = array(
						'invoice_id' => $result,
						'project_id' => $this->input->post('project'),
						'item_name' => $iname,
						'item_qty' => $qtyhrs,
						'item_unit_price' => $price,
						'item_type_pajak' => $type_pajak,
						'item_nilai_pajak' => $nilai_pajak,
						'item_sub_total' => $item_sub_total,
						'sub_jumlah_total' => $this->input->post('items_sub_total'),
						'total_pajak' => $this->input->post('items_pajak_total'),
						'type_discount' => $this->input->post('type_discount'),
						'angka_discount' => $this->input->post('angka_discount'),
						'total_discount' => $this->input->post('jumlah_discount'),
						'grand_total' => $this->input->post('fgrand_total'),
						'created_at' => date('d-m-Y H:i:s')
					);
					$result_item = $this->Invoices_model->add_record_invoice_items($data2);
					$key++; 
				}
				$Return['result'] = 'Invoice created.';
			} else {
				$Return['error'] = 'Bug. Ada yang tidak beres, coba lagi.';
			}
			$this->output($Return);
			exit;
		}
	}

	public function update_invoice() {

		if($this->input->post('add_type')=='create_invoice') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = $this->uri->segment(4);

			foreach($this->input->post('item') as $eitem_id=>$key_val){

				$item_name = $this->input->post('eitem_name');
				$iname = $item_name[$key_val]; 

				$qty = $this->input->post('eqty_hrs');
				$qtyhrs = $qty[$key_val]; 
				$unit_price = $this->input->post('eunit_price');
				$price = $unit_price[$key_val]; 
				$typpajak = $this->input->post('etype_pajak');
				$type_pajak = $typpajak[$key_val]; 
				$nilai_pajak_item = $this->input->post('enilai_pajak_item');
				$nilai_pajak = $nilai_pajak_item[$key_val];
				$sub_total_item = $this->input->post('esub_total_item');
				$item_sub_total = $sub_total_item[$key_val];
				$data = array(
					'item_name' => $iname,
					'item_qty' => $qtyhrs,
					'item_unit_price' => $price,
					'item_type_pajak' => $type_pajak,
					'item_nilai_pajak' => $nilai_pajak,
					'item_sub_total' => $item_sub_total,
					'sub_jumlah_total' => $this->input->post('items_sub_total'),
					'total_pajak' => $this->input->post('items_pajak_total'),
					'type_discount' => $this->input->post('type_discount'),
					'angka_discount' => $this->input->post('angka_discount'),
					'total_discount' => $this->input->post('jumlah_discount'),
					'grand_total' => $this->input->post('fgrand_total'),
				);
				$result_item = $this->Invoices_model->update_record_invoice_items($data,$eitem_id);
			}

			$data = array(
				'project_id' => $this->input->post('project'),
				'sub_jumlah_total' => $this->input->post('items_sub_total'),
				'total_pajak' => $this->input->post('items_pajak_total'),
				'type_discount' => $this->input->post('type_discount'),
				'angka_discount' => $this->input->post('angka_discount'),
				'total_discount' => $this->input->post('jumlah_discount'),
				'grand_total' => $this->input->post('fgrand_total'),
				'catatan_invoice' => $this->input->post('catatan_invoice'),
			);
			$result = $this->Invoices_model->update_record_invoice($data,$id);

			if($this->input->post('item_name')) {
				$key=0;
				foreach($this->input->post('item_name') as $items){

					$item_name = $this->input->post('item_name');
					$iname = $item_name[$key]; 

					$qty = $this->input->post('qty_hrs');
					$qtyhrs = $qty[$key]; 

					$unit_price = $this->input->post('unit_price');
					$price = $unit_price[$key]; 
					$typpajak = $this->input->post('type_pajak');
					$type_pajak = $typpajak[$key]; 
					$nilai_pajak_item = $this->input->post('nilai_pajak_item');
					$nilai_pajak = $nilai_pajak_item[$key];

					$sub_total_item = $this->input->post('sub_total_item');
					$item_sub_total = $sub_total_item[$key];
					$data2 = array(
						'invoice_id' => $id,
						'project_id' => $this->input->post('project'),
						'item_name' => $iname,
						'item_qty' => $qtyhrs,
						'item_unit_price' => $price,
						'item_type_pajak' => $type_pajak,
						'item_nilai_pajak' => $nilai_pajak,
						'item_sub_total' => $item_sub_total,
						'sub_jumlah_total' => $this->input->post('items_sub_total'),
						'total_pajak' => $this->input->post('items_pajak_total'),
						'type_discount' => $this->input->post('type_discount'),
						'angka_discount' => $this->input->post('angka_discount'),
						'total_discount' => $this->input->post('jumlah_discount'),
						'grand_total' => $this->input->post('fgrand_total'),
						'created_at' => date('d-m-Y H:i:s')
					);
					$result_item = $this->Invoices_model->add_record_invoice_items($data2);

					$key++; 
				}
				$Return['result'] = 'Invoice updated.';
			} else {
				//$Return['error'] = 'Bug. Ada yang tidak beres, coba lagi.';
			}
			$Return['result'] = 'Invoice updated.';
			$this->output($Return);
			exit;
		}
	}

	public function delete_item() {

		if($this->uri->segment(5) == 'isajax') {

			$Return = array('result'=>'', 'error'=>'');
			$id = $this->uri->segment(4);

			$result = $this->Invoices_model->delete_record_invoice_items($id);
			if(isset($id)) {
				$Return['result'] = 'Invoice Item deleted.';
			} else {
				$Return['error'] = 'Bug. Ada yang tidak beres, coba lagi.';
			}
			$this->output($Return);
		}
	}

	public function delete() {

		if($this->input->post('is_ajax') == '2') {

			$Return = array('result'=>'', 'error'=>'');
			$id = $this->uri->segment(4);

			$result = $this->Invoices_model->delete_record($id);
			if(isset($id)) {
				$result_item = $this->Invoices_model->delete_invoice_items($id);
				$Return['result'] = 'Invoice deleted.';
			} else {
				$Return['error'] = 'Bug. Ada yang tidak beres, coba lagi.';
			}
			$this->output($Return);
		}
	}

	public function delete_pajak() {
		if($this->input->post('is_ajax')==='2') {

			$Return = array('result'=>'', 'error'=>'');
			$id = $this->uri->segment(4);
			$result = $this->Invoices_model->delete_record_pajak($id);
			if(isset($id)) {
				$Return['result'] = 'Pajak Dihapus.';
			} else {
				$Return['error'] = 'Bug. Ada yang tidak beres, coba lagi.';
			}
			$this->output($Return);
		}
	}
} 
?>