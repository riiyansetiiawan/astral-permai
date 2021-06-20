<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Biaya extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		
		$this->load->model("Biaya_model");
		$this->load->model("Department_model");
		$this->load->model("Umb_model");
	}
	
	
	public function output($Return=array()) {
		
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		
		exit(json_encode($Return));
	}
	
	public function index() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('umb_biayaa').' | '.$this->Umb_model->site_title();
		$data['all_types_biaya'] = $this->Biaya_model->all_types_biaya();
		$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		$data['get_all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$data['breadcrumbs'] = $this->lang->line('umb_biayaa');
		$data['path_url'] = 'expense';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('10',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/biaya/list_biaya", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
		} else {
			redirect('admin/dashboard');
		}
	}

	public function list_biaya() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/biaya/list_biaya", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('389',$role_resources_ids)) {
			$biaya = $this->Biaya_model->get_biayaa_karyawan();
		} else {
			$biaya = $this->Biaya_model->get_biayaa();
		}
		$data = array();

		foreach($biaya->result() as $r) {

			$type_biaya = $this->Biaya_model->read_informasi_type_biaya($r->type_biaya_id);
			if(!is_null($type_biaya)){
				$pengeluaran = $type_biaya[0]->name;
			} else {
				$pengeluaran = '--';	
			}

			$user = $this->Umb_model->read_user_info($r->karyawan_id);
			
			if(!is_null($user)){
				$full_name = $user[0]->first_name.' '.$user[0]->last_name;
			} else {
				$full_name = '--';	
			}

			$edate = $this->Umb_model->set_date_format($r->tanggal_pembelian);
			
			$currency = $this->Umb_model->currency_sign($r->jumlah);

			$download = '';

			$perusahaan = $this->Umb_model->read_info_perusahaan($r->perusahaan_id);
			if(!is_null($perusahaan)){
				$prshn_nama = $perusahaan[0]->name;
			} else {
				$prshn_nama = '--';	
			}

			if($r->status==0): 
				$status = '<span class="badge bg-orange">'.$this->lang->line('umb_pending').'</span>';
			elseif($r->status==1): 
				$status = '<span class="badge bg-green">'.$this->lang->line('umb_approved').'</span>';
			else: 
				$status = '<span class="badge bg-red">'.$this->lang->line('umb_cancel').'</span>'; 
			endif;

			if(in_array('311',$role_resources_ids)) { 
				$edit = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-biaya_id="'. $r->biaya_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('312',$role_resources_ids)) { 
				$delete = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->biaya_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}
			if(in_array('313',$role_resources_ids)) {
				$view = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-biaya_id="'. $r->biaya_id . '"><span class="fa fa-eye"></span></button></span>';
			} else {
				$view = '';
			}
			if(in_array('314',$role_resources_ids)) {
				if($r->billcopy_file!='' && $r->billcopy_file!='no file') {
					$download = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_download').'"><a href="download?type=biaya&filename='.$r->billcopy_file.'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" title="'.$this->lang->line('umb_download').'"><span class="oi oi-cloud-download"></span></button></a></span>';
				} else {
					$download = '';
				}
			} else {
				$download = '';
			}
			$combhr = $edit.$download.$view.$delete;
			$ipengeluaran = $pengeluaran.'<br><small class="text-muted"><i>'.$this->lang->line('umb_dibeli_oleh').': '.$full_name.'<i></i></i></small><br><small class="text-muted"><i>'.$status.'<i></i></i></small>';
			$data[] = array(
				$combhr,
				$ipengeluaran,
				$prshn_nama,                    
				$currency,
				$edate,
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

	public function read() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('biaya_id');
		$result = $this->Biaya_model->read_informasi_biaya($id);
		$data = array(
			'biaya_id' => $result[0]->biaya_id,
			'karyawan_id' => $result[0]->karyawan_id,
			'perusahaan_id' => $result[0]->perusahaan_id,
			'type_biaya_id' => $result[0]->type_biaya_id,
			'billcopy_file' => $result[0]->billcopy_file,
			'jumlah' => $result[0]->jumlah,
			'tanggal_pembelian' => $result[0]->tanggal_pembelian,
			'remarks' => $result[0]->remarks,
			'status' => $result[0]->status,
			'all_types_biaya' => $this->Biaya_model->all_types_biaya(),
			'all_karyawans' => $this->Umb_model->all_karyawans(),
			'get_all_perusahaans' => $this->Umb_model->get_perusahaans()
		);
		if(!empty($session)){ 
			$this->load->view('admin/biaya/dialog_biaya', $data);
		} else {
			redirect('admin/');
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
			$this->load->view("admin/biaya/get_karyawans", $data);
		} else {
			redirect('admin/');
		}

		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}


	public function add_biaya() {

		if($this->input->post('add_type')=='biaya') {

			$file = $_FILES['bill_copy']['tmp_name'];

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();

			$remarks = $this->input->post('remarks');
			$qt_remarks = htmlspecialchars(addslashes($remarks), ENT_QUOTES);	

			if($this->input->post('type_biaya')==='') {
				$Return['error'] = $this->lang->line('umb_error_type_biaya');
			} else if($this->input->post('tanggal_pembelian')==='') {
				$Return['error'] = $this->lang->line('umb_error_tanggal_pembelian');
			} else if($this->input->post('jumlah')==='') {
				$Return['error'] = $this->lang->line('umb_error_jumlah_biaya');
			} else if($this->input->post('perusahaan_id')==='') {
				$Return['error'] = $this->lang->line('error_field_perusahaan');
			} else if($this->input->post('karyawan_id')==='') {
				$Return['error'] = $this->lang->line('umb_error_karyawan_id');
			} 

			else if($_FILES['bill_copy']['size'] == 0) {
				$fname = 'no file';
			} else {
				if(is_uploaded_file($_FILES['bill_copy']['tmp_name'])) {

					$allowed =  array('png','jpg','jpeg','gif');
					$filename = $_FILES['bill_copy']['name'];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);

					if(in_array($ext,$allowed)){
						$tmp_name = $_FILES["bill_copy"]["tmp_name"];
						$bill_copy = "uploads/biaya/";


						$lname = basename($_FILES["bill_copy"]["name"]);
						$newfilename = 'bill_copy_'.round(microtime(true)).'.'.$ext;
						move_uploaded_file($tmp_name, $bill_copy.$newfilename);
						$fname = $newfilename;
					} else {
						$Return['error'] = $this->lang->line('umb_error_type_file_biaya');
					}
				}
			}

			if($Return['error']!=''){
				$this->output($Return);
			}
			$data = array(
				'type_biaya_id' => $this->input->post('type_biaya'),
				'perusahaan_id' => $this->input->post('perusahaan_id'),
				'tanggal_pembelian' => $this->input->post('tanggal_pembelian'),
				'jumlah' => $this->input->post('jumlah'),
				'karyawan_id' => $this->input->post('karyawan_id'),
				'billcopy_file' => $fname,
				'remarks' => $qt_remarks,
				'created_at' => date('d-m-Y'),
			);
			$result = $this->Biaya_model->add($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_tambah_biaya');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}


	public function update() {

		if($this->input->post('edit_type')=='biaya') {
			$id = $this->uri->segment(4);

			$file = $_FILES['bill_copy']['tmp_name'];

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();

			$remarks = $this->input->post('remarks');
			$qt_remarks = htmlspecialchars(addslashes($remarks), ENT_QUOTES);		

			$no_logo_data = array(
				'type_biaya_id' => $this->input->post('type_biaya'),
				'tanggal_pembelian' => $this->input->post('tanggal_pembelian'),
				'perusahaan_id' => $this->input->post('perusahaan_id'),
				'jumlah' => $this->input->post('jumlah'),
				'karyawan_id' => $this->input->post('karyawan_id'),
				'status' => $this->input->post('status'),
				'remarks' => $qt_remarks,
			);

			if($this->input->post('type_biaya')==='') {
				$Return['error'] = $this->lang->line('umb_error_type_biaya');
			} else if($this->input->post('tanggal_pembelian')==='') {
				$Return['error'] = $this->lang->line('umb_error_tanggal_pembelian');
			} else if($this->input->post('jumlah')==='') {
				$Return['error'] = $this->lang->line('umb_error_jumlah_biaya');
			} else if($this->input->post('perusahaan_id')==='') {
				$Return['error'] = $this->lang->line('error_field_perusahaan');
			} else if($this->input->post('karyawan_id')==='') {
				$Return['error'] = $this->lang->line('umb_error_karyawan_id');
			}  

			else if($_FILES['bill_copy']['size'] == 0) {
				$fname = 'no file';
				$result = $this->Biaya_model->update_record_no_logo($no_logo_data,$id);
			} else {
				if(is_uploaded_file($_FILES['bill_copy']['tmp_name'])) {

					$allowed =  array('png','jpg','jpeg','gif');
					$filename = $_FILES['bill_copy']['name'];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);

					if(in_array($ext,$allowed)){
						$tmp_name = $_FILES["bill_copy"]["tmp_name"];
						$bill_copy = "uploads/biaya/";

						$lname = basename($_FILES["bill_copy"]["name"]);
						$newfilename = 'bill_copy_'.round(microtime(true)).'.'.$ext;
						move_uploaded_file($tmp_name, $bill_copy.$newfilename);
						$fname = $newfilename;
						$data = array(
							'type_biaya_id' => $this->input->post('type_biaya'),
							'tanggal_pembelian' => $this->input->post('tanggal_pembelian'),
							'jumlah' => $this->input->post('jumlah'),
							'perusahaan_id' => $this->input->post('perusahaan_id'),
							'karyawan_id' => $this->input->post('karyawan_id'),
							'status' => $this->input->post('status'),
							'billcopy_file' => $fname,
							'remarks' => $qt_remarks,		
						);
						
						$result = $this->Biaya_model->update_record($data,$id);
					} else {
						$Return['error'] = $this->lang->line('umb_error_type_file_biaya');
					}
				}
			}

			if($Return['error']!=''){
				$this->output($Return);
			}


			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_perbarui_biaya');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function delete() {

		if($this->input->post('is_ajax')==2) {
			$session = $this->session->userdata('username');
			if(empty($session)){ 
				redirect('admin/');
			}

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Biaya_model->delete_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_sukses_hapus_biaya');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}
}
