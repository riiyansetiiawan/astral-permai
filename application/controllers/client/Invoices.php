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
	}
	
	public function index() {
		
		$session = $this->session->userdata('client_username');
		if(empty($session)){ 
			redirect('client/');
		}
		$data['title'] = $this->lang->line('umb_invoices_title');
		$data['breadcrumbs'] = $this->lang->line('umb_invoices_title');
		$data['all_projects'] = $this->Project_model->get_projects();
		$data['all_pajaks'] = $this->Pajak_model->get_all_pajaks();
		$data['path_url'] = 'hrastral_invoices';
		$data['subview'] = $this->load->view("client/invoices/list_invoices", $data, TRUE);
		$this->load->view('client/layout/layout_main', $data); 
	}

	public function history_pembayarans() {
		
		$session = $this->session->userdata('client_username');
		if(empty($session)){
			redirect('client/');
		}
		$data['title'] = $this->lang->line('umb_acc_pembayarans_invoice').' | '.$this->Umb_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('umb_acc_pembayarans_invoice');
		$data['path_url'] = 'umb_invoice_pembayaran';
		if(!empty($session)){ 
			$data['subview'] = $this->load->view("client/invoices/list_invoice_pembayaran", $data, TRUE);
			$this->load->view('client/layout/layout_main', $data); 
		} else {
			redirect('client/');
		}
	}
	
	public function view() {
		
		$session = $this->session->userdata('client_username');
		if(empty($session)){ 
			redirect('client/');
		}
		$data['title'] = $this->Umb_model->site_title();
		
		$invoice_id = $this->uri->segment(4);
		$info_invoice = $this->Invoices_model->read_info_invoice($invoice_id);
		if(is_null($info_invoice)){
			redirect('client/invoices');
		}
		$project = $this->Project_model->read_informasi_project($info_invoice[0]->project_id);
		//$negara = $this->Umb_model->read_info_negara($supplier[0]->negara_id);
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
			'title' => 'View Invoice #'.$info_invoice[0]->invoice_id,
			'breadcrumbs' => 'View Invoice',
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
		//if(in_array('3',$role_resources_ids)) {
		$data['subview'] = $this->load->view("client/invoices/view_invoice", $data, TRUE);
		$this->load->view('client/layout/layout_main', $data); 			
		//} else {
		//	redirect('admin/dashboard/');
		//}		  
	}
	
	public function preview() {
		
		$session = $this->session->userdata('client_username');
		if(empty($session)){ 
			redirect('client/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$invoice_id = $this->uri->segment(4);
		$info_invoice = $this->Invoices_model->read_info_invoice($invoice_id);
		if(is_null($info_invoice)){
			redirect('client/invoices');
		}
		$project = $this->Project_model->read_informasi_project($info_invoice[0]->project_id);
		//$negara = $this->Umb_model->read_info_negara($supplier[0]->negara_id);
		$perusahaan = $this->Umb_model->read_info_setting_perusahaan(1);
		$cnegara = $this->Umb_model->read_info_negara($perusahaan[0]->negara);
		if(!is_null($project)){
			$nama_project = $project[0]->title;
			$project_id = $project[0]->project_id;
			$no_project = $project[0]->no_pembelian;
		} else {
			$nama_project = '--';	
			$no_project = '--';
		}
		$data = array(
			'title' => 'View Invoice #'.$info_invoice[0]->invoice_id,
			'breadcrumbs' => 'View Invoice',
			'path_url' => 'log',
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
		//if(in_array('3',$role_resources_ids)) {
		$data['subview'] = $this->load->view("client/invoices/preview_invoice", $data, TRUE);
		$this->load->view('client/layout/pre_layout_main', $data); 			
		//} else {
		//	redirect('admin/dashboard/');
		//}		  
	}
	
	// invoice payment list
	public function list_invoice_pembayaran()
	{

		$session = $this->session->userdata('client_username');
		if(empty($session)){ 
			redirect('client/');
		}
		$data['title'] = $this->Umb_model->site_title();
		if(!empty($session)){ 
			$this->load->view("client/invoices/list_invoice_pembayaran", $data);
		} else {
			redirect('client/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$transaksi = $this->Invoices_model->get_client_pembayaran_invoices($session['client_id']);
		$data = array();
		$saldo2 = 0;
		foreach($transaksi->result() as $r) {
			
			
			$tanggal_transaksi = $this->Umb_model->set_date_format($r->tanggal_transaksi);
			
			$jumlah_total = $this->Umb_model->currency_sign($r->jumlah);
			// credit
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
			$nomor_invoice = '<a href="'.site_url().'client/invoices/view/'.$r->invoice_id.'/">'.$no_inv.'</a>';					
			$data[] = array(
				$nomor_invoice,
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

	public function list_invoices() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('client_username');
		if(!empty($session)){ 
			$this->load->view("client/invoices/list_invoices", $data);
		} else {
			redirect('client/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$client = $this->Invoices_model->get_invoices_client($session['client_id']);
		$data = array();

		foreach($client->result() as $r) {
			$grand_total = $this->Umb_model->currency_sign($r->grand_total);
			$project = $this->Project_model->read_informasi_project($r->project_id); 
			if(!is_null($project)){
				$nama_project = $project[0]->title;
			} else {
				$nama_project = '--';
			}
			if($r->status == 0){
				$istatus = '<span class="label label-danger">'.$this->lang->line('umb_payroll_belum_dibayar').'</span>';
			} else {
				$istatus = '<span class="label label-success">'.$this->lang->line('umb_payment_bayar').'</span>';
			}
			$tanggal_invoice = '<i class="far fa-calendar-alt position-left"></i> '.$this->Umb_model->set_date_format($r->tanggal_invoice);
			$tanggal_jatoh_tempo_invoice = '<i class="far fa-calendar-alt position-left"></i> '.$this->Umb_model->set_date_format($r->tanggal_jatoh_tempo_invoice);
			$nomor_invoice = '<a href="'.site_url().'client/invoices/view/'.$r->invoice_id.'/">'.$r->nomor_invoice.'</a>';
			$data[] = array(
				'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_view').'"><a href="'.site_url().'client/invoices/view/'.$r->invoice_id.'/"><button type="button" class="btn icon-btn btn-xs btn-outline-info waves-effect waves-light""><span class="fa fa-arrow-circle-right"></span></button></a></span>',
				$nomor_invoice,
				$nama_project,
				$grand_total,
				$tanggal_invoice,
				$tanggal_jatoh_tempo_invoice,
				$istatus,
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
} 
?>