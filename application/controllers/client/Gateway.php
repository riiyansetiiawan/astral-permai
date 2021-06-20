<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gateway extends MY_Controller {

	
	public function output($Return=array()){
		
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		
		exit(json_encode($Return));
	}
	
	public function __construct() {
		parent::__construct();
		$this->load->model('Invoices_model');
		$this->load->model('Umb_model');
		$this->load->model('Keuangan_model');
		/*cash control*/
		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		$this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

	}

	public function pay(){
		
		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		
		$invoice_id = $this->input->post("invoice_id");
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		// $token = $this->input->post("token"); 
		// $data['gateway'] = $this->input->post("gateway");
		$info_invoice = $this->Invoices_model->read_info_invoice($invoice_id);
		$data = array(
			'invoice_id' => $info_invoice[0]->invoice_id,
			'nomor_invoice' => $info_invoice[0]->nomor_invoice,
			'tanggal_invoice' => $info_invoice[0]->tanggal_invoice,
			'tanggal_jatoh_tempo_invoice' => $info_invoice[0]->tanggal_jatoh_tempo_invoice,
			'sub_jumlah_total' => $info_invoice[0]->sub_jumlah_total,
			'type_discount' => $info_invoice[0]->type_discount,
			'angka_discount' => $info_invoice[0]->angka_discount,
			'total_pajak' => $info_invoice[0]->total_pajak,
			'total_discount' => $info_invoice[0]->total_discount,
			'grand_total' => $info_invoice[0]->grand_total,
			'catatan_invoice' => $info_invoice[0]->catatan_invoice,
			'gateway' => $this->input->post("gateway")
		);
		//if(varify_invoice($invoice_id,$token)){
			//$data['invoice']=$this->Invoice_model->get_by($invoice_id);
			//$this->load->view("admin/gateway/".$data['gateway'],$data);
		$this->load->view("client/gateway/".$data['gateway'],$data);
	}
	
	public function paypal_process($param1 = '',$param2='') {
		$ipaypal = $this->uri->segment(4);
		$ipaypal_invid = $this->uri->segment(5);
		if ($param1 == '') {
			$invoice_id=$this->input->post('invoice_id');
			$token=$this->input->post('token');
			$invoice = read_record_invoice($invoice_id);
			$system_settings = system_settings_info(1);
			$this->paypal->add_field('rm', 1);
			$this->paypal->add_field('no_note', 0);
			$this->paypal->add_field('item_name', "Invoice: #".$invoice->nomor_invoice);
			$this->paypal->add_field('jumlah',$invoice->grand_total);
			$this->paypal->add_field('custom',$invoice->invoice_id);
			$this->paypal->add_field('business', $system_settings->paypal_email);
			$this->paypal->add_field('notify_url', site_url() . 'client/gateway/paypal_process/paypal_ipn');
			$this->paypal->add_field('cancel_return', site_url() . 'client/gateway/paypal_process/paypal_cancel/'.$invoice->invoice_id);
			$this->paypal->add_field('return', site_url() . 'client/gateway/paypal_process/paypal_success/'.$invoice->invoice_id);
			$this->paypal->submit_paypal_post();
		}
		if ($param1 == 'paypal_ipn') {
			if ($this->paypal->validate_ipn() == true) {			       
			}
		}
		if ($param1 == 'paypal_cancel') {
			$this->session->set_flashdata('error', 'Sorry Could not complete the process, Please try again');
			redirect('client/invoices/view/'.$param2, 'refresh');
		}
		//redirect('admin/invoices/view/'.$param2, 'refresh');
		if ($param1 == 'paypal_success') {
			$this->session->set_flashdata('success', 'Thank you payment has done sucessfully.');
			$invoice = $this->Invoices_model->read_info_invoice($param2);
			$system_settings = system_settings_info(1);	
			if($system_settings->online_payment_account == ''){
				$online_payment_account = 0;
			} else {
				$online_payment_account = $system_settings->online_payment_account;
			}
			
			$jumlah = $invoice[0]->grand_total;
			$ivdata = array(
				'jumlah' => $jumlah,
				'account_id' => $online_payment_account,
				'type_transaksi' => 'pendapatan',
				'dr_cr' => 'cr',
				'tanggal_transaksi' => date('Y-m-d'),
				'pembayar_penerima_pembayaran_id' => $invoice[0]->client_id,
				'payment_method_id' => 1,
				'description' => 'Invoice Pembayaran',
				'reference' => 'Invoice Pembayaran',
				'invoice_id' => $param2,
				'client_id' => $invoice[0]->client_id,
				'created_at' => date('Y-m-d H:i:s')
			);
			$iresult = $this->Keuangan_model->add_transaksii($ivdata);
			if ($iresult == TRUE) {			
				$data = array(
					'status' => 1,
				);
				$result = $this->Invoices_model->update_record_invoice($data,$param2);
			}
			redirect('client/invoices/view/'.$param2, 'refresh');

		}
	}

	public function stripe_charge($id){

		if($this->input->post('stripeToken')) {
			$invoice_id=$this->input->post('invoice_id');
			$token=$this->input->post('token');
			
			/*if(!varify_invoice($invoice_id,$token)){
			  show_404();
			}  */  
			$system_settings = system_settings_info(1);
			$invoice = $this->Invoices_model->read_info_invoice($invoice_id);
			$stripe_api_key = $system_settings->stripe_secret_key;
			require_once(APPPATH . 'libraries/stripe-php/init.php');
			\Stripe\Stripe::setApiKey($stripe_api_key);
			$customer_email = $invoice[0]->email;
			
			$vendora = \Stripe\Customer::create(array(
				'email' => $customer_email,
				'card'  => $_POST['stripeToken']
			));
			
			$charge = \Stripe\Charge::create(array(
				'customer'  => $vendora->id,
				'jumlah'    => ($invoice[0]->grand_total-0)*100,
				'currency'  => 'IDR'
			));

			if($charge->paid == true){
				$vendora = (array) $vendora;
				$charge = (array) $charge;
				if($system_settings->online_payment_account == ''){
					$online_payment_account = 0;
				} else {
					$online_payment_account = $system_settings->online_payment_account;
				}	
				$jumlah = $invoice[0]->grand_total;
				$ivdata = array(
					'jumlah' => $jumlah,
					'account_id' => $online_payment_account,
					'type_transaksi' => 'pendapatan',
					'dr_cr' => 'cr',
					'tanggal_transaksi' => date('Y-m-d'),
					'pembayar_penerima_pembayaran_id' => $invoice[0]->client_id,
					'payment_method_id' => 2,
					'description' => 'Invoice Pembayaran',
					'reference' => 'Invoice Pembayaran',
					'invoice_id' => $invoice_id,
					'client_id' => $invoice[0]->client_id,
					'created_at' => date('Y-m-d H:i:s')
				);
				$iresult = $this->Keuangan_model->add_transaksii($ivdata);
				if ($iresult == TRUE) {			
					$data = array(
						'status' => 1,
					);
					$result = $this->Invoices_model->update_record_invoice($data,$invoice_id);
				}		
				$this->session->set_flashdata('success', 'Thank you payment has done sucessfully.');
				redirect('client/invoices/view/'.$id.'/', 'refresh');
				
			} else {
				$this->session->set_flashdata('error', 'Sorry Could not complete the process, Please try again');
				redirect('client/invoices/view/'.$id.'/', 'refresh');
			}

		} else{
			$this->session->set_flashdata('error', 'Something went wrong please try again.');
			redirect('client/invoices/view/'.$id.'/', 'refresh');
		}
		
	}
}