<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Quotes extends MY_Controller {

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
		$this->load->model("Quotes_model");
		$this->load->model("Clients_model");
		$this->load->model("Department_model");
	}
	
	public function index() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('umb_title_quotes').' | '.$this->Umb_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('umb_title_quotes');
		$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		$data['all_clients'] = $this->Clients_model->get_all_clients();
		$data['all_projects'] = $this->Project_model->get_projects();
		$data['all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$data['all_pajaks'] = $this->Pajak_model->get_all_pajaks();
		$data['path_url'] = 'hrastral_quotes';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('121',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/quotes/list_quotes", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
		} else {
			redirect('admin/dashboard');
		}
	}

	public function create() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$perusahaan = $this->Umb_model->read_info_perusahaan($this->input->get("c"));
		if(is_null($perusahaan)){
			redirect('admin/quotes/');
		}
		$data['title'] = $this->lang->line('umb_create_quote').' | '.$this->Umb_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('umb_create_quote');
		$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		$data['all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$data['all_clients'] = $this->Clients_model->get_all_clients();
		$data['all_projects'] = $this->Project_model->get_projects();
		$data['all_pajaks'] = $this->Pajak_model->get_all_pajaks();
		$data['path_url'] = 'create_hrastral_quote';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('120',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/quotes/create_quote", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
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
			$this->load->view("admin/quotes/get_karyawans", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}
	
	public function get_co_karyawans() {

		$data['title'] = $this->Umb_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'perusahaan_id' => $id
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/quotes/get_co_karyawans", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}
	
	public function edit() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		
		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		
		$quote_id = $this->uri->segment(4);
		$quote_info = $this->Quotes_model->read_info_quote($quote_id);
		if(is_null($quote_info)){
			redirect('admin/quotes');
		}
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(!in_array('328',$role_resources_ids)) {
			redirect('admin/quotes');
		}
		$project = $this->Project_model->read_informasi_project($quote_info[0]->project_id);
		// $negara = $this->Umb_model->read_info_negara($supplier[0]->negara_id);
		$perusahaan = $this->Umb_model->read_info_setting_perusahaan(1);
		$cnegara = $this->Umb_model->read_info_negara($perusahaan[0]->negara);
		if(!is_null($project)){
			$nama_project = $project[0]->title;
		} else {
			$nama_project = '--';	
		}
		$data = array(
			'title' => 'Edit Estimate #'.$quote_info[0]->quote_number,
			'breadcrumbs' => 'Edit Estimate',
			'path_url' => 'create_hrastral_quote',
			'quote_id' => $quote_info[0]->quote_id,
			'project_id' => $project[0]->project_id,
			'status' => $quote_info[0]->status,
			'quote_number' => $quote_info[0]->quote_number,
			'eclient_id' => $quote_info[0]->client_id,
			'eperusahaan_id' => $quote_info[0]->perusahaan_id,
			'quote_tanggal' => $quote_info[0]->quote_tanggal,
			'quote_due_date' => $quote_info[0]->quote_due_date,
			'quote_type' => $quote_info[0]->quote_type,
			'sub_jumlah_total' => $quote_info[0]->sub_jumlah_total,
			'type_discount' => $quote_info[0]->type_discount,
			'angka_discount' => $quote_info[0]->angka_discount,
			'type_pajak' => $quote_info[0]->type_pajak,
			'angka_pajak' => $quote_info[0]->angka_pajak,
			'total_pajak' => $quote_info[0]->total_pajak,
			'total_discount' => $quote_info[0]->total_discount,
			'grand_total' => $quote_info[0]->grand_total,
			'quote_note' => $quote_info[0]->quote_note,
			'nama_perusahaan' => $perusahaan[0]->nama_perusahaan,
			'alamat_perusahaan' => $perusahaan[0]->alamat_1,
			'kode_pos_perusahaan' => $perusahaan[0]->kode_pos,
			'kota_perusahaan' => $perusahaan[0]->kota,
			'phone_perusahaan' => $perusahaan[0]->phone,
			'negara_perusahaan' => $cnegara[0]->nama_negara,
			'all_projects' => $this->Project_model->get_projects(),
			'all_pajaks' => $this->Pajak_model->get_all_pajaks(),
			'all_karyawans' => $this->Umb_model->all_karyawans(),
			'all_perusahaans' => $this->Umb_model->get_perusahaans(),
			'all_clients' => $this->Clients_model->get_all_clients(),
		);
		$role_resources_ids = $this->Umb_model->user_role_resource();
		//if(in_array('3',$role_resources_ids)) {
		$data['subview'] = $this->load->view("admin/quotes/edit_quote", $data, TRUE);
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
		
		$quote_id = $this->uri->segment(4);
		$quote_info = $this->Quotes_model->read_info_quote($quote_id);
		if(is_null($quote_info)){
			redirect('admin/quotes');
		}
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(!in_array('330',$role_resources_ids)) {
			redirect('admin/quotes');
		}
		$project = $this->Project_model->read_informasi_project($quote_info[0]->project_id);
		//$negara = $this->Umb_model->read_info_negara($supplier[0]->negara_id);
		$perusahaan = $this->Perusahaan_model->read_informasi_perusahaan($quote_info[0]->perusahaan_id);
		$cnegara = $this->Umb_model->read_info_negara($perusahaan[0]->negara);
		$clientinfo = $this->Clients_model->read_info_client($quote_info[0]->client_id);
		if(!is_null($clientinfo)){
			$cname = $clientinfo[0]->name;
			$nama_perusahaan_client = $clientinfo[0]->nama_perusahaan;
			$profile_client = $clientinfo[0]->profile_client;
			$email = $clientinfo[0]->email;
			$nomor_kontak = $clientinfo[0]->nomor_kontak;
			$website_url = $clientinfo[0]->website_url;
			$alamat_1 = $clientinfo[0]->alamat_1;
			$alamat_2 = $clientinfo[0]->alamat_2;
			$kota = $clientinfo[0]->kota;
			$provinsi = $clientinfo[0]->provinsi;
			$kode_pos = $clientinfo[0]->kode_pos;
			$negaraid = $clientinfo[0]->negara;
		} else {
			$cname = '';
			$nama_perusahaan_client = '';
			$profile_client = '';
			$nomor_kontak = '';
			$website_url = '';
			$alamat_1 = '';
			$alamat_2 = '';
			$kota = '';
			$provinsi = '';
			$kode_pos = '';
			$negaraid = 0;
		}
		if(!is_null($project)){
			$nama_project = $project[0]->title;
			$no_project = $project[0]->no_pembelian;
		} else {
			$nama_project = '--';	
			$no_project = '--';
		}
		$data = array(
			'title' => 'View Estimate #'.$quote_info[0]->quote_number,
			'breadcrumbs' => 'View Estimate',
			'path_url' => 'view_hrastral_quote',
			'quote_id' => $quote_info[0]->quote_id,
			'status' => $quote_info[0]->status,
			'quote_number' => $quote_info[0]->quote_number,
			'project_id' => $project[0]->project_id,
			'eperusahaan_id' => $quote_info[0]->perusahaan_id,
			'no_project' => $no_project,
			'nama_project' => $nama_project,
			'quote_tanggal' => $quote_info[0]->quote_tanggal,
			'quote_due_date' => $quote_info[0]->quote_due_date,
			'sub_jumlah_total' => $quote_info[0]->sub_jumlah_total,
			'type_discount' => $quote_info[0]->type_discount,
			'angka_discount' => $quote_info[0]->angka_discount,
			'total_pajak' => $quote_info[0]->total_pajak,
			'total_discount' => $quote_info[0]->total_discount,
			'grand_total' => $quote_info[0]->grand_total,
			'quote_note' => $quote_info[0]->quote_note,
			'nama_perusahaan' => $perusahaan[0]->name,
			'alamat_perusahaan' => $perusahaan[0]->alamat_1,
			'alamat_perusahaan2' => $perusahaan[0]->alamat_2,
			'kode_pos_perusahaan' => $perusahaan[0]->kode_pos,
			'kota_perusahaan' => $perusahaan[0]->kota,
			'provinsi_perusahaan' => $perusahaan[0]->provinsi,
			'phone_perusahaan' => $perusahaan[0]->nomor_kontak,
			'negara_perusahaan' => $cnegara[0]->nama_negara,
			'pajak_pemerintah' => $perusahaan[0]->pajak_pemerintah,
			'name' => $cname,
			'nama_perusahaan_client' => $nama_perusahaan_client,
			'profile_client' => $profile_client,
			'email' => $email,
			'nomor_kontak' => $nomor_kontak,
			'website_url' => $website_url,
			'alamat_1' => $alamat_1,
			'alamat_2' => $alamat_2,
			'kota' => $kota,
			'provinsi' => $provinsi,
			'kode_pos' => $kode_pos,
			'negaraid' => $negaraid,
			'all_projects' => $this->Project_model->get_projects(),
			'all_pajaks' => $this->Pajak_model->get_all_pajaks(),
		);
		$role_resources_ids = $this->Umb_model->user_role_resource();
		//if(in_array('3',$role_resources_ids)) {
		$data['subview'] = $this->load->view("admin/quotes/quote_view", $data, TRUE);
		$this->load->view('admin/layout/layout_main', $data); 			
		//} else {
		//	redirect('admin/dashboard/');
		//}		  
	}
	
	public function list_quotes() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/quotes/list_quotes", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$quotes = $this->Quotes_model->get_quotes();
		$role_resources_ids = $this->Umb_model->user_role_resource();
		$data = array();

		foreach($quotes->result() as $r) {
			
			$grand_total = $this->Umb_model->currency_sign($r->grand_total);
			$project = $this->Project_model->read_informasi_project($r->project_id); 
			if(!is_null($project)){
				$nama_project = $project[0]->title;
			} else {
				$nama_project = '--';	
			}
			$quote_tanggal = '<i class="far fa-calendar-alt position-left"></i> '.$this->Umb_model->set_date_format($r->quote_tanggal);
			$quote_due_date = '<i class="far fa-calendar-alt position-left"></i> '.$this->Umb_model->set_date_format($r->quote_due_date);
			$quote_number = '';
			if(in_array('330',$role_resources_ids)) { 
				$quote_number = '<a href="'.site_url().'admin/quotes/view/'.$r->quote_id.'/">'.$r->quote_number.'</a>';
			} else {
				$quote_number = $r->quote_number;
			}
			if(in_array('328',$role_resources_ids)) { 
				$edit = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_edit').'"><a href="'.site_url().'admin/quotes/edit/'.$r->quote_id.'/"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="fas fa-pencil-alt"></span></button></a></span>';
			} else {
				$edit = '';
			}
			if(in_array('329',$role_resources_ids)) {
				$delete = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->quote_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}
			if(in_array('330',$role_resources_ids)) {
				$view = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_view').'"><a href="'.site_url().'admin/quotes/view/'.$r->quote_id.'/"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light""><span class="fa fa-arrow-circle-right"></span></button></a></span>';
			} else {
				$view = '';
			}
			if($r->status == 0){
				$status = '<span class="label label-warning">'.$this->lang->line('umb_quoted_title').'</span>';
			} else {
				$status = '<span class="label label-success">'.$this->lang->line('umb_quote_invoiced').'</span>';
			}
			$record_convert_quote = $this->Quotes_model->read_info_converted_quote($r->quote_id);
			if ($record_convert_quote < 1) {
				$combhr = $edit.$view.$delete;
			} else {
				$combhr = $view.$delete;
			}
			
			$data[] = array(
				$combhr,
				$quote_number,
				$nama_project,
				$grand_total,
				$quote_tanggal,
				$quote_due_date,
				$status,
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $quotes->num_rows(),
			"recordsFiltered" => $quotes->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function read_po_quote() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('quote_id');
		$quote_info = $this->Quotes_model->read_info_quote($id);
		$data = array(
			'quote_id' => $quote_info[0]->quote_id,
			'quote_number' => $quote_info[0]->quote_number,
		);
		$this->load->view('admin/quotes/dialog_po_quote', $data);
	}

	public function convert_ke_project() {
		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		if($this->input->post('po_project')==='') {
			$Return['error'] = "The Project P.O field is required.";
		} else if($this->Quotes_model->check_po_quote($this->input->post('po_project')) > 0) {
			$Return['error'] = "The Project P.O should be unique.";
		}
		if($Return['error']!=''){
			$this->output($Return);
		}
		
		$quote_id = $this->uri->segment(4);
		$quote_info = $this->Quotes_model->read_info_quote($quote_id);
		if(is_null($quote_info)){
			redirect('admin/quotes/view/'.$quote_id);
		}
		// get customer
		//$customer = $this->Customers_model->read_customer_info($quote_info[0]->customer_id); 
		// get perusahaan info
		$perusahaan = $this->Umb_model->read_info_setting_perusahaan(1);
		// get perusahaan > country info
		//$cnegara = $this->Umb_model->read_info_negara($perusahaan[0]->negara);
		$data = array(
			'title' => $quote_info[0]->umb_title,
			'quote_po' => $this->input->post('po_project'),
			'client_id' => $quote_info[0]->client_id,
			'perusahaan_id' => $quote_info[0]->perusahaan_id,
			'quote_id' => $quote_info[0]->quote_id,
			'start_date' => date('Y-m-d'),
			'end_date' => $quote_info[0]->quote_due_date,
			'summary' => $quote_info[0]->quote_note,
			'project_manager' => $quote_info[0]->project_manager,
			'project_coordinator' => $quote_info[0]->project_coordinator,
			'priority' => 4,
			'assigned_to' => 0,
			'description' => $quote_info[0]->quote_note,
			'progress_project' => '0',
			'status' => '0',
			'added_by' => 1,
			'created_at' => date('d-m-Y'),
		);
		$result = $this->Project_model->add($data);
		if ($result == TRUE) {
			$data2 = array(
				'status' => '1',
				'quote_po' => $this->input->post('po_project'),
			);
			$this->Quotes_model->update_record_quote($data2,$quote_id);
		}
		
		$this->session->set_flashdata('response',"Converted to project successfully.");
		$Return['result'] = 'P.O Project Ditambah.';
		$this->output($Return);
		exit;
		//redirect('admin/quotes/view/'.$quote_id);
	}
	
	public function create_new_quote() {
		
		if($this->input->post('add_type')=='create_quote') {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
			if($this->input->post('quote_number')==='') {
				$Return['error'] = "The quote number field is required.";
			} else if($this->Quotes_model->quote_no_check($this->input->post('quote_number')) > 0) {
				$Return['error'] = "The Quote number should be unique.";
			} else if($this->input->post('perusahaan_id')==='') {
				$Return['error'] = "The perusahaan field is required.";
			} else if($this->input->post('client_id')==='') {
				$Return['error'] = "The client field is required.";
			} else if($this->input->post('project')==='') {
				$Return['error'] = "The project title field is required.";
			} else if($this->input->post('quote_tanggal')==='') {
				$Return['error'] = "The quote date field is required.";
			} else if($this->input->post('quote_due_date')==='') {
				$Return['error'] = "The project start date field is required.";
			} else if($this->input->post('unit_price')==='') {
				$Return['error'] = "The unit price field is required.";
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
			$client_id = $this->input->post('client_id');
			$perusahaan_id = $this->input->post('perusahaan_id');
			$clientinfo = $this->Clients_model->read_info_client($client_id);
			$data = array(
				'quote_number' => $this->input->post('quote_number'),
				'perusahaan_id' => $perusahaan_id,
				'project_id' => $this->input->post('project'),
				'quote_tanggal' => $this->input->post('quote_tanggal'),
				'quote_due_date' => $this->input->post('quote_due_date'),
				'client_id' => $client_id,
				'sub_jumlah_total' => $this->input->post('items_sub_total'),
				'type_discount' => $this->input->post('type_discount'),
				'angka_discount' => $this->input->post('angka_discount'),
				'total_discount' => $this->input->post('jumlah_discount'),
				'total_pajak' => $this->input->post('items_pajak_total'),
				'grand_total' => $this->input->post('fgrand_total'),
				'quote_note' => $this->input->post('quote_note'),
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
			$result = $this->Quotes_model->add_quote_record($data);
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
						'quote_id' => $result,
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
					$result_item = $this->Quotes_model->add_record_quote_items($data2);
					
					$key++; 
				}
				$Return['result'] = 'Quote created.';
			} else {
				$Return['error'] = 'Bug. Ada yang tidak beres, coba lagi.';
			}
			$this->output($Return);
			exit;
		}
	}

	public function convert_to_invoice() {
		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$id = $this->uri->segment(4);
		$quote_info = $this->Quotes_model->read_info_quote($id);
		if(is_null($quote_info)){
			redirect('admin/quotes/');
		}
		//$customer = $this->Customers_model->read_customer_info($quote_info[0]->customer_id); 
		$perusahaan = $this->Umb_model->read_info_setting_perusahaan(1);
		//$cnegara = $this->Umb_model->read_info_negara($perusahaan[0]->negara);
		$data = array(
			'nomor_invoice' => $quote_info[0]->quote_number,
			'client_id' => $quote_info[0]->client_id,
			'project_id' => $quote_info[0]->project_id,
			'tanggal_invoice' => $quote_info[0]->quote_tanggal,
			'tanggal_jatoh_tempo_invoice' => $quote_info[0]->quote_due_date,
			'perusahaan_id' => $quote_info[0]->perusahaan_id,
			'sub_jumlah_total' => $quote_info[0]->sub_jumlah_total,
			'type_discount' => $quote_info[0]->type_discount,
			'angka_discount' => $quote_info[0]->angka_discount,
			'total_pajak' => $quote_info[0]->total_pajak,
			//'type_pajak' => $quote_info[0]->type_pajak,
			'angka_pajak' => $quote_info[0]->angka_pajak,
			'total_discount' => $quote_info[0]->total_discount,
			'type_invoice' => $quote_info[0]->quote_type,
			'grand_total' => $quote_info[0]->grand_total,
			'catatan_invoice' => $quote_info[0]->quote_note,
			'name' => $quote_info[0]->name,
			'nama_perusahaan' => $quote_info[0]->nama_perusahaan,
			'profile_client' => $quote_info[0]->profile_client,
			'email' => $quote_info[0]->email,
			'nomor_kontak' => $quote_info[0]->nomor_kontak,
			'website_url' => $quote_info[0]->website_url,
			'alamat_1' => $quote_info[0]->alamat_1,
			'alamat_2' => $quote_info[0]->alamat_2,
			'kota' => $quote_info[0]->kota,
			'provinsi' => $quote_info[0]->provinsi,
			'kode_pos' => $quote_info[0]->kode_pos,
			'negaraid' => $quote_info[0]->negaraid,
			'status' => '0',
			'created_at' => date('d-m-Y H:i:s')
		);
		$result = $this->Invoices_model->add_record_invoice($data);
		if ($result == TRUE) {
			foreach($this->Quotes_model->get_quote_items($quote_info[0]->quote_id) as $_item):
				$data2 = array(
					'invoice_id' => $result,
					'project_id' => $quote_info[0]->project_id,
					'item_name' => $_item->item_name,
					'item_qty' => $_item->item_qty,
					'item_unit_price' => $_item->item_unit_price,
					'item_sub_total' => $_item->item_sub_total,
					'sub_jumlah_total' => $_item->sub_jumlah_total,
					'item_type_pajak' => $_item->item_type_pajak,
					'item_nilai_pajak' => $_item->item_nilai_pajak,
					'total_pajak' => $_item->total_pajak,
					'type_discount' => $_item->type_discount,
					'angka_discount' => $_item->angka_discount,
					'total_discount' => $_item->total_discount,
					'grand_total' => $_item->grand_total,
					'created_at' => date('d-m-Y H:i:s')
				);

				$result_item = $this->Invoices_model->add_record_invoice_items($data2);
			endforeach;
			$data3 = array(
				'status' => 1,
			);
			$eresult = $this->Quotes_model->update_record_quote($data3,$quote_info[0]->quote_id);
		}

		$this->session->set_flashdata('response',"Converted to invoice successfully.");
		redirect('admin/quotes/view/'.$quote_info[0]->quote_id);
	}

	public function update_quote() {

		if($this->input->post('add_type')=='create_quote') {		

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
				$result_item = $this->Quotes_model->update_record_quote_items($data,$eitem_id);

			}
			$proj_info = $this->Project_model->read_informasi_project($this->input->post('project'));	
			$data = array(
				'quote_number' => $this->input->post('quote_number'),
				'project_id' => $this->input->post('project'),
				'quote_tanggal' => $this->input->post('quote_tanggal'),
				'quote_due_date' => $this->input->post('quote_due_date'),
				'client_id' => $this->input->post('client_id'),
				'perusahaan_id' => $this->input->post('perusahaan_id'),
				'sub_jumlah_total' => $this->input->post('items_sub_total'),
				//'type_pajak' => $this->input->post('type_pajak'),
				//'angka_pajak' => $this->input->post('angka_pajak'),
				'total_pajak' => $this->input->post('items_pajak_total'),
				'type_discount' => $this->input->post('type_discount'),
				'angka_discount' => $this->input->post('angka_discount'),
				'total_discount' => $this->input->post('jumlah_discount'),
				'grand_total' => $this->input->post('fgrand_total'),
				'quote_note' => $this->input->post('quote_note'),
			);
			$result = $this->Quotes_model->update_record_quote($data,$id);


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
						'quote_id' => $id,
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
					$result_item = $this->Quotes_model->add_record_quote_items($data2);

					$key++; 
				}
				$Return['result'] = 'Quote diperbarui.';
			} else {
					//$Return['error'] = 'Bug. Ada yang tidak beres, coba lagi.';
			}
			$Return['result'] = 'Quote diperbarui.';
			$this->output($Return);
			exit;
		}
	}

	public function delete_item() {

		if($this->uri->segment(5) == 'isajax') {

			$Return = array('result'=>'', 'error'=>'');
			$id = $this->uri->segment(4);

			$result = $this->Quotes_model->delete_record_quote_items($id);
			if(isset($id)) {
				$Return['result'] = 'Quote Item dihapus.';
			} else {
				$Return['error'] = 'Bug. Ada yang tidak beres, coba lagi.';
			}
			$this->output($Return);
		}
	}

	public function delete() {

		if($this->input->post('is_ajax') == '2') {

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = $this->uri->segment(4);
			$result = $this->Quotes_model->delete_record($id);
			if(isset($id)) {
				$this->Quotes_model->delete_quote_items($id);
				$Return['result'] = 'Quote dihapus.';
			} else {
				$Return['error'] = 'Bug. Ada yang tidak beres, coba lagi.';
			}
			$this->output($Return);
			exit;
		}
	}
	public function get_projects_client() {

		$data['title'] = $this->Umb_model->site_title();
		$id = $this->uri->segment(4);

		$data = array(
			'client_id' => $id
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/quotes/get_projects_client", $data);
		} else {
			redirect('admin/');
		}

		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}
} 
?>