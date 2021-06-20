<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Perusahaan extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model("Perusahaan_model");
		$this->load->model("Umb_model");
		$this->load->model("Custom_fields_model");
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
		$data['title'] = $this->lang->line('module_title_perusahaan').' | '.$this->Umb_model->site_title();
		$data['all_negaraa'] = $this->Umb_model->get_negaraa();
		$data['get_types_perusahaan'] = $this->Perusahaan_model->get_types_perusahaan();
		$data['breadcrumbs'] = $this->lang->line('module_title_perusahaan');
		$data['path_url'] = 'perusahaan';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('5',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/perusahaans/list_perusahaan", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
		} else {
			redirect('admin/dashboard');
		}
	}

	public function documents_resmi() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('umb_hr_documents_resmi').' | '.$this->Umb_model->site_title();
		$data['all_negaraa'] = $this->Umb_model->get_negaraa();
		$data['get_types_perusahaan'] = $this->Perusahaan_model->get_types_perusahaan();
		$data['get_all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$data['all_types_document'] = $this->Karyawans_model->all_types_document();
		$data['breadcrumbs'] =$this->lang->line('umb_hr_documents_resmi');
		$data['path_url'] = 'perusahaan_license';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('5',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/perusahaans/list_document_resmi", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
		} else {
			redirect('admin/dashboard');
		}
	}

	public function list_perusahaan(){

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/perusahaans/list_perusahaan", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$role_resources_ids = $this->Umb_model->user_role_resource();
		$user_info = $this->Umb_model->read_user_info($session['user_id']);
		if($user_info[0]->user_role_id==1){
			$perusahaan = $this->Perusahaan_model->get_perusahaans();
		} else {
			$perusahaan = $this->Perusahaan_model->get_single_perusahaan($user_info[0]->perusahaan_id);
		}
		$data = array();
		foreach($perusahaan->result() as $r) {
			$negara = $this->Umb_model->read_info_negara($r->negara);
			if(!is_null($negara)){
				$c_name = $negara[0]->nama_negara;
			} else {
				$c_name = '--';	
			}
			$ctype = $this->Perusahaan_model->read_type_perusahaan($r->type_id);
			if(!is_null($ctype)){
				$type_name = $ctype[0]->name;
			} else {
				$type_name = '--';	
			}

			if(in_array('247',$role_resources_ids)) {
				$edit = '<span data-toggle="tooltip" data-state="primary" data-placement="top" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-perusahaan_id="'. $r->perusahaan_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('248',$role_resources_ids)) {
				$delete = '<span data-toggle="tooltip" data-state="danger" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->perusahaan_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}
			if(in_array('249',$role_resources_ids)) {
				$view = '<span data-toggle="tooltip" data-state="primary" data-placement="top" title="'.$this->lang->line('umb_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target="#modals-slide" data-perusahaan_id="'. $r->perusahaan_id . '"><span class="fa fa-eye"></span></button></span>';
			} else {
				$view = '';
			}
			$combhr = $edit.$view.$delete;
			$icname = $r->name.'<br><small class="text-muted"><i>'.$this->lang->line('umb_type').': '.$type_name.'<i></i></i></small><br><small class="text-muted"><i>'.$this->lang->line('dashboard_kontak').'#: '.$r->nomor_kontak.'<i></i></i></small><br><small class="text-muted"><i>'.$this->lang->line('umb_website').': '.$r->website_url.'<i></i></i></small>';
			$data[] = array(
				$combhr,
				$icname,
				$r->email,
				$r->kota,
				$c_name,
				$r->default_currency,
				$r->default_timezone
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $perusahaan->num_rows(),
			"recordsFiltered" => $perusahaan->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function list_document() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/perusahaans/list_document_resmi", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$role_resources_ids = $this->Umb_model->user_role_resource();
		$user_info = $this->Umb_model->read_user_info($session['user_id']);
		if($user_info[0]->user_role_id==1){
			$perusahaan = $this->Perusahaan_model->get_documents_perusahaan();
		} else {
			$perusahaan = $this->Perusahaan_model->get_single_documents_perusahaan($user_info[0]->perusahaan_id);
		}
		$data = array();
		foreach($perusahaan->result() as $r) {
			$d_type = $this->Karyawans_model->read_informasi_type_document($r->type_document_id);
			if(!is_null($d_type)){
				$document_d = $d_type[0]->type_document;
			} else {
				$document_d = '--';
			}
			if(in_array('247',$role_resources_ids)) {
				$edit = '<span data-toggle="tooltip" data-state="primary" data-placement="top" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-document_id="'. $r->document_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('248',$role_resources_ids)) {
				$delete = '<span data-toggle="tooltip" data-state="danger" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->document_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}
			if(in_array('249',$role_resources_ids)) {
				$view = '<span data-toggle="tooltip" data-state="primary" data-placement="top" title="'.$this->lang->line('umb_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target="#modals-slide" data-document_id="'. $r->document_id . '"><span class="fa fa-eye"></span></button></span>';
			} else {
				$view = '';
			}
			$perusahaan_id = $this->Perusahaan_model->read_informasi_perusahaan($r->perusahaan_id);
			if(!is_null($perusahaan_id)){
				$nama_perusahaan = $perusahaan_id[0]->name;
			} else {
				$nama_perusahaan = '--';	
			}
			if($r->license_notification==0){
				$notification = $this->lang->line('umb_hr_license_no_alarm');
			} else if($r->license_notification==1){
				$notification = $this->lang->line('umb_hr_license_alarm_1');
			} else if($r->license_notification==2){
				$notification = $this->lang->line('umb_hr_license_alarm_3');
			} else {
				$notification = $this->lang->line('umb_hr_license_alarm_6');
			}
			$doc_view='<a href="'.site_url('admin/download?type=perusahaan/documents_resmi&filename=').$r->document.'">'.$this->lang->line('umb_view').'</a>';
			$combhr = $edit.$view.$delete;
			$inama_license = $r->nama_license.'<br><small class="text-muted"><i>'.$this->lang->line('umb_hr_official_nomor_license').': '.$r->nomor_license.'<i></i></i></small><br><small class="text-muted"><i>'.$this->lang->line('umb_hr_view_document').': '.$doc_view.'<i></i></i></small>';
			$data[] = array(
				$combhr,
				$document_d,
				$inama_license,
				$nama_perusahaan,
				$r->tanggal_kaaluarsa,
				$notification
			);
		}
		$output = array(
			"draw" => $draw,
			"recordsTotal" => $perusahaan->num_rows(),
			"recordsFiltered" => $perusahaan->num_rows(),
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
		$id = $this->input->get('perusahaan_id');
		$result = $this->Perusahaan_model->read_informasi_perusahaan($id);
		$data = array(
			'perusahaan_id' => $result[0]->perusahaan_id,
			'name' => $result[0]->name,
			'username' => $result[0]->username,
			'password' => $result[0]->password,
			'type_id' => $result[0]->type_id,
			'pajak_pemerintah' => $result[0]->pajak_pemerintah,
			'nama_trading' => $result[0]->nama_trading,
			'registration_no' => $result[0]->registration_no,
			'email' => $result[0]->email,
			'logo' => $result[0]->logo,
			'nomor_kontak' => $result[0]->nomor_kontak,
			'website_url' => $result[0]->website_url,
			'alamat_1' => $result[0]->alamat_1,
			'alamat_2' => $result[0]->alamat_2,
			'kota' => $result[0]->kota,
			'provinsi' => $result[0]->provinsi,
			'kode_pos' => $result[0]->kode_pos,
			'negaraid' => $result[0]->negara,
			'idefault_currency' => $result[0]->default_currency,
			'idefault_timezone' => $result[0]->default_timezone,
			'all_negaraa' => $this->Umb_model->get_negaraa(),
			'get_types_perusahaan' => $this->Perusahaan_model->get_types_perusahaan()
		);
		$this->load->view('admin/perusahaans/dialog_perusahaan', $data);
	}

	public function read_document() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('document_id');
		$result = $this->Perusahaan_model->read_info_document_perusahaan($id);
		$data = array(
			'document_id' => $result[0]->document_id,
			'nama_license' => $result[0]->nama_license,
			'type_document_id' => $result[0]->type_document_id,
			'perusahaan_id' => $result[0]->perusahaan_id,
			'tanggal_kaaluarsa' => $result[0]->tanggal_kaaluarsa,
			'nomor_license' => $result[0]->nomor_license,
			'license_notification' => $result[0]->license_notification,
			'document' => $result[0]->document,
			'all_negaraa' => $this->Umb_model->get_negaraa(),
			'get_all_perusahaans' => $this->Umb_model->get_perusahaans(),
			'all_types_document' => $this->Karyawans_model->all_types_document(),
			'get_types_perusahaan' => $this->Perusahaan_model->get_types_perusahaan()
		);
		$this->load->view('admin/perusahaans/dialog_document_resmi', $data);
	}

	public function read_info(){
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('perusahaan_id');
		$result = $this->Perusahaan_model->read_informasi_perusahaan($id);
		$data = array(
			'perusahaan_id' => $result[0]->perusahaan_id,
			'name' => $result[0]->name,
			'username' => $result[0]->username,
			'password' => $result[0]->password,
			'type_id' => $result[0]->type_id,
			'pajak_pemerintah' => $result[0]->pajak_pemerintah,
			'nama_trading' => $result[0]->nama_trading,
			'registration_no' => $result[0]->registration_no,
			'email' => $result[0]->email,
			'logo' => $result[0]->logo,
			'nomor_kontak' => $result[0]->nomor_kontak,
			'website_url' => $result[0]->website_url,
			'alamat_1' => $result[0]->alamat_1,
			'alamat_2' => $result[0]->alamat_2,
			'kota' => $result[0]->kota,
			'provinsi' => $result[0]->provinsi,
			'kode_pos' => $result[0]->kode_pos,
			'negaraid' => $result[0]->negara,
			'idefault_currency' => $result[0]->default_currency,
			'idefault_timezone' => $result[0]->default_timezone,
			'all_negaraa' => $this->Umb_model->get_negaraa(),
			'get_types_perusahaan' => $this->Perusahaan_model->get_types_perusahaan()
		);
		$this->load->view('admin/perusahaans/view_perusahaan.php', $data);
	}
	
	
	public function add_perusahaan() {

		if($this->input->post('add_type')=='perusahaan') {
			$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('website', 'Website', 'trim|required|xss_clean');
			$this->form_validation->set_rules('kota', 'Kota', 'trim|required|xss_clean');
			$name = $this->input->post('name');
			$nama_trading = $this->input->post('nama_trading');
			$registration_no = $this->input->post('registration_no');
			$email = $this->input->post('email');
			$nomor_kontak = $this->input->post('nomor_kontak');
			$website = $this->input->post('website');
			$alamat_1 = $this->input->post('alamat_1');
			$alamat_2 = $this->input->post('alamat_2');
			$kota = $this->input->post('kota');
			$provinsi = $this->input->post('provinsi');
			$kode_pos = $this->input->post('kode_pos');
			$negara = $this->input->post('negara');
			$user_id = $this->input->post('user_id');
			$file = $_FILES['logo']['tmp_name'];
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			if($name==='') {
				$Return['error'] = $this->lang->line('umb_error_field_nama');
			} else if( $this->input->post('type_perusahaan')==='') {
				$Return['error'] = $this->lang->line('umb_error_ctype_field');
			} else if($nomor_kontak==='') {
				$Return['error'] = $this->lang->line('umb_error_field_kontak');
			} else if($email==='') {
				$Return['error'] = $this->lang->line('umb_error_cemail_field');
			} else if($website==='') {
				$Return['error'] = $this->lang->line('umb_error_fiel_website');
			}  else if($kota==='') {
				$Return['error'] = $this->lang->line('umb_error_fiel_kota');
			} else if($kode_pos==='') {
				$Return['error'] = $this->lang->line('umb_error_fiel_kode_pos');
			} else if($negara==='') {
				$Return['error'] = $this->lang->line('umb_error_field_negara');
			} else if($this->input->post('username')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_username');
			} else if($this->input->post('password')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_password');
			} else if($this->input->post('default_currency')==='') {
				$Return['error'] = $this->lang->line('umb_default_currency_field_error');
			} else if($this->input->post('default_timezone')==='') {
				$Return['error'] = $this->lang->line('umb_default_timezone_field_error');
			}
			else if($_FILES['logo']['size'] == 0) {
				$fname = 'no file';
				$Return['error'] = $this->lang->line('umb_error_field_logo');
			} else {
				if(is_uploaded_file($_FILES['logo']['tmp_name'])) {

					$allowed =  array('png','jpg','jpeg','gif');
					$filename = $_FILES['logo']['name'];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);

					if(in_array($ext,$allowed)){
						$tmp_name = $_FILES["logo"]["tmp_name"];
						$bill_copy = "uploads/perusahaan/";
						$lname = basename($_FILES["logo"]["name"]);
						$newfilename = 'logo_'.round(microtime(true)).'.'.$ext;
						move_uploaded_file($tmp_name, $bill_copy.$newfilename);
						$fname = $newfilename;
					} else {
						$Return['error'] = $this->lang->line('umb_error_attatchment_type');
					}
				}
			}

			if($Return['error']!=''){
				$this->output($Return);
			}
			$module_attributes = $this->Custom_fields_model->perusahaan_hrastral_module_attributes();
			$count_module_attributes = $this->Custom_fields_model->count_perusahaan_module_attributes();
			$i=1;
			if($count_module_attributes > 0){
				foreach($module_attributes as $mattribute) {
					if($mattribute->validation == 1){
						if($i!=1) {
						} else if($this->input->post($mattribute->attribute)=='') {
							$Return['error'] = $this->lang->line('umb_hrastral_custom_field_the').' '.$mattribute->attribute_label.' '.$this->lang->line('umb_hrastral_custom_field_is_required');
						}
					}
				}		
				if($Return['error']!=''){
					$this->output($Return);
				}	
			}
			$data = array(
				'name' => $this->input->post('name'),
				'type_id' => $this->input->post('type_perusahaan'),
				'username' => $this->input->post('username'),
				'password' => $this->input->post('password'),
				'pajak_pemerintah' => $this->input->post('umb_pjkprmth'),
				'nama_trading' => $this->input->post('nama_trading'),
				'registration_no' => $this->input->post('registration_no'),
				'email' => $this->input->post('email'),
				'nomor_kontak' => $this->input->post('nomor_kontak'),
				'website_url' => $this->input->post('website'),
				'alamat_1' => $this->input->post('alamat_1'),
				'alamat_2' => $this->input->post('alamat_2'),
				'kota' => $this->input->post('kota'),
				'provinsi' => $this->input->post('provinsi'),
				'kode_pos' => $this->input->post('kode_pos'),
				'negara' => $this->input->post('negara'),
				'default_currency' => $this->input->post('default_currency'),
				'default_timezone' => $this->input->post('default_timezone'),
				'added_by' => $this->input->post('user_id'),
				'logo' => $fname,
				'created_at' => date('d-m-Y'),

			);
			
			$iresult = $this->Perusahaan_model->add($data);
			if ($iresult) {
				$Return['result'] = $this->lang->line('umb_sukses_tambah_perusahaan');
				$id = $iresult;
				if($count_module_attributes > 0){
					foreach($module_attributes as $mattribute) {
						if($mattribute->attribute_type == 'fileupload'){
							if($_FILES[$mattribute->attribute]['size'] != 0) {
								if(is_uploaded_file($_FILES[$mattribute->attribute]['tmp_name'])) {

									$allowed =  array('png','jpg','jpeg','pdf','gif','xls','doc','xlsx','docx');
									$filename = $_FILES[$mattribute->attribute]['name'];
									$ext = pathinfo($filename, PATHINFO_EXTENSION);

									if(in_array($ext,$allowed)){
										$tmp_name = $_FILES[$mattribute->attribute]["tmp_name"];
										$profile = "uploads/custom_files/";
										$set_img = base_url()."uploads/custom_files/";


										$name = basename($_FILES[$mattribute->attribute]["name"]);
										$newfilename = 'custom_file_'.round(microtime(true)).'.'.$ext;
										move_uploaded_file($tmp_name, $profile.$newfilename);
										$fname = $newfilename;	
									}
									$iattr_data = array(
										'user_id' => $id,
										'module_attributes_id' => $mattribute->custom_field_id,
										'attribute_value' => $fname,
										'created_at' => date('Y-m-d h:i:s')
									);
									$this->Custom_fields_model->add_values($iattr_data);
								}
							} else {
								$iattr_data = array(
									'user_id' => $id,
									'module_attributes_id' => $mattribute->custom_field_id,
									'attribute_value' => '',
									'created_at' => date('Y-m-d h:i:s')
								);
								$this->Custom_fields_model->add_values($iattr_data);
							}
						} else if($mattribute->attribute_type == 'multiselect') {
							$multisel_val = $this->input->post($mattribute->attribute);
							if(!empty($multisel_val)){
								$newdata = implode(',', $this->input->post($mattribute->attribute));
								$iattr_data = array(
									'user_id' => $id,
									'module_attributes_id' => $mattribute->custom_field_id,
									'attribute_value' => $newdata,
									'created_at' => date('Y-m-d h:i:s')
								);
								$this->Custom_fields_model->add_values($iattr_data);
							}
						} else {
							if($this->input->post($mattribute->attribute) == ''){
								$file_val = '';
							} else {
								$file_val = $this->input->post($mattribute->attribute);
							}
							$iattr_data = array(
								'user_id' => $id,
								'module_attributes_id' => $mattribute->custom_field_id,
								'attribute_value' => $file_val,
								'created_at' => date('Y-m-d h:i:s')
							);
							$this->Custom_fields_model->add_values($iattr_data);
						}
					}
				}
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function add_document_resmi() {

		if($this->input->post('add_type')=='document_resmi') {
			$this->form_validation->set_rules('nama_license', 'Name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('perusahaan_id', 'Perusahaan', 'trim|required|xss_clean');
			$this->form_validation->set_rules('nomor_license', 'Nomor License', 'trim|required|xss_clean');

			$nama_license = $this->input->post('nama_license');
			$perusahaan_id = $this->input->post('perusahaan_id');
			$tanggal_kaaluarsa = $this->input->post('tanggal_kaaluarsa');
			$nomor_license = $this->input->post('nomor_license');
			$license_notification = $this->input->post('license_notification');
			$user_id = $this->input->post('user_id');
			$file = $_FILES['scan_file']['tmp_name'];
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			if($nama_license==='') {
				$Return['error'] = $this->lang->line('umb_co_error_nama_license');
			} else if($this->input->post('type_document_id')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_type_document');
			} else if($nomor_license==='') {
				$Return['error'] = $this->lang->line('umb_co_error_nomor_license');
			} else if( $this->input->post('perusahaan_id')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_nama_perusahaan');
			} else if($tanggal_kaaluarsa==='') {
				$Return['error'] = $this->lang->line('umb_co_error_tgl_license_kldrsa');
			} 		
			else if($_FILES['scan_file']['size'] == 0) {
				$fname = 'no file';
				$Return['error'] = $this->lang->line('umb_co_error_license_off_doc');
			} else {
				if(is_uploaded_file($_FILES['scan_file']['tmp_name'])) {

					$allowed =  array('png','jpg','jpeg','gif','pdf','doc','docx','xls','xlsx');
					$filename = $_FILES['scan_file']['name'];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);

					if(in_array($ext,$allowed)){
						$tmp_name = $_FILES["scan_file"]["tmp_name"];
						$bill_copy = "uploads/perusahaan/documents_resmi/";
						$lname = basename($_FILES["scan_file"]["name"]);
						$newfilename = 'documents_resmi_'.round(microtime(true)).'.'.$ext;
						move_uploaded_file($tmp_name, $bill_copy.$newfilename);
						$fname = $newfilename;
					} else {
						$Return['error'] = $this->lang->line('umb_error_attatchment_type');
					}
				}
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$data = array(
				'type_document_id' => $this->input->post('type_document_id'),
				'nama_license' => $nama_license,
				'perusahaan_id' => $perusahaan_id,
				'tanggal_kaaluarsa' => $tanggal_kaaluarsa,
				'nomor_license' => $nomor_license,
				'license_notification' => $license_notification,
				'added_by' => $this->input->post('user_id'),
				'document' => $fname,
				'created_at' => date('d-m-Y'),
			);
			$result = $this->Perusahaan_model->add_document($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_hr_document_resmi_ditambahkan');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}


	public function update_document_resmi() {

		if($this->input->post('edit_type')=='document') {
			$id = $this->uri->segment(4);
			$this->form_validation->set_rules('nama_license', 'Name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('perusahaan_id', 'Perusahaan', 'trim|required|xss_clean');
			$this->form_validation->set_rules('nomor_license', 'Number', 'trim|required|xss_clean');
			$nama_license = $this->input->post('nama_license');
			$perusahaan_id = $this->input->post('perusahaan_id');
			$tanggal_kaaluarsa = $this->input->post('tanggal_kaaluarsa');
			$nomor_license = $this->input->post('nomor_license');
			$license_notification = $this->input->post('license_notification');
			$user_id = $this->input->post('user_id');
			$file = $_FILES['scan_file']['tmp_name'];
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			if($nama_license==='') {
				$Return['error'] = $this->lang->line('umb_co_error_nama_license');
			} else if($this->input->post('type_document_id')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_type_document');
			} else if($nomor_license==='') {
				$Return['error'] = $this->lang->line('umb_co_error_nomor_license');
			} else if( $this->input->post('perusahaan_id')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_nama_perusahaan');
			} else if($tanggal_kaaluarsa==='') {
				$Return['error'] = $this->lang->line('umb_co_error_tgl_license_kldrsa');
			}		
			else if($_FILES['scan_file']['size'] == 0) {
				$fname = 'no file';
				$no_logo_data = array(
					'type_document_id' => $this->input->post('type_document_id'),
					'nama_license' => $nama_license,
					'perusahaan_id' => $perusahaan_id,
					'tanggal_kaaluarsa' => $tanggal_kaaluarsa,
					'nomor_license' => $nomor_license,
					'license_notification' => $license_notification
				);
				$result = $this->Perusahaan_model->update_record_document_perusahaan($no_logo_data,$id);
			} else {
				if(is_uploaded_file($_FILES['scan_file']['tmp_name'])) {

					$allowed =  array('png','jpg','jpeg','gif','pdf','doc','docx','xls','xlsx');
					$filename = $_FILES['scan_file']['name'];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);

					if(in_array($ext,$allowed)){
						$tmp_name = $_FILES["scan_file"]["tmp_name"];
						$bill_copy = "uploads/perusahaan/documents_resmi/";
						$lname = basename($_FILES["scan_file"]["name"]);
						$newfilename = 'documents_resmi_'.round(microtime(true)).'.'.$ext;
						move_uploaded_file($tmp_name, $bill_copy.$newfilename);
						$fname = $newfilename;
						$data = array(
							'type_document_id' => $this->input->post('type_document_id'),
							'nama_license' => $nama_license,
							'perusahaan_id' => $perusahaan_id,
							'tanggal_kaaluarsa' => $tanggal_kaaluarsa,
							'nomor_license' => $nomor_license,
							'license_notification' => $license_notification,
							'document' => $fname,
						);
						$result = $this->Perusahaan_model->update_record_document_perusahaan($data,$id);
					} else {
						$Return['error'] = $this->lang->line('umb_error_attatchment_type');
					}
				}
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_hr_document_resmi_diperbarui');
			} else {
				$Return['error'] = $Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function update() {

		if($this->input->post('edit_type')=='perusahaan') {
			$id = $this->uri->segment(4);
			$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('website', 'Website', 'trim|required|xss_clean');
			$this->form_validation->set_rules('kota', 'Kota', 'trim|required|xss_clean');
			$name = $this->input->post('name');
			$nama_trading = $this->input->post('nama_trading');
			$registration_no = $this->input->post('registration_no');
			$email = $this->input->post('email');
			$nomor_kontak = $this->input->post('nomor_kontak');
			$website = $this->input->post('website');
			$alamat_1 = $this->input->post('alamat_1');
			$alamat_2 = $this->input->post('alamat_2');
			$kota = $this->input->post('kota');
			$provinsi = $this->input->post('provinsi');
			$kode_pos = $this->input->post('kode_pos');
			$negara = $this->input->post('negara');
			$user_id = $this->input->post('user_id');
			$file = $_FILES['logo']['tmp_name'];
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			if($name==='') {
				$Return['error'] = $this->lang->line('umb_error_field_nama');
			} else if( $this->input->post('type_perusahaan')==='') {
				$Return['error'] = $this->lang->line('umb_error_ctype_field');
			} else if($nomor_kontak==='') {
				$Return['error'] = $this->lang->line('umb_error_field_kontak');
			} else if($email==='') {
				$Return['error'] = $this->lang->line('umb_error_cemail_field');
			} else if($website==='') {
				$Return['error'] = $this->lang->line('umb_error_fiel_website');
			} else if($kota==='') {
				$Return['error'] = $this->lang->line('umb_error_fiel_kota');
			} else if($kode_pos==='') {
				$Return['error'] = $this->lang->line('umb_error_fiel_kode_pos');
			} else if($negara==='') {
				$Return['error'] = $this->lang->line('umb_error_field_negara');
			} else if($this->input->post('username')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_username');
			} else if($this->input->post('default_currency')==='') {
				$Return['error'] = $this->lang->line('umb_default_currency_field_error');
			} else if($this->input->post('default_timezone')==='') {
				$Return['error'] = $this->lang->line('umb_default_timezone_field_error');
			}
			else if($_FILES['logo']['size'] == 0) {
				$fname = 'no file';
				$module_attributes = $this->Custom_fields_model->perusahaan_hrastral_module_attributes();
				$count_module_attributes = $this->Custom_fields_model->count_perusahaan_module_attributes();	
				$i=1;
				if($count_module_attributes > 0){
					foreach($module_attributes as $mattribute) {
						if($mattribute->validation == 1){
							if($i!=1) {
							} else if($this->input->post($mattribute->attribute)=='') {
								$Return['error'] = $this->lang->line('umb_hrastral_custom_field_the').' '.$mattribute->attribute_label.' '.$this->lang->line('umb_hrastral_custom_field_is_required');
							}
						}
					}
					if($Return['error']!=''){
						$this->output($Return);
					}	
				}
				$no_logo_data = array(
					'name' => $this->input->post('name'),
					'type_id' => $this->input->post('type_perusahaan'),
					'username' => $this->input->post('username'),
					'password' => $this->input->post('password'),
					'pajak_pemerintah' => $this->input->post('umb_pjkprmth'),
					'nama_trading' => $this->input->post('nama_trading'),
					'registration_no' => $this->input->post('registration_no'),
					'email' => $this->input->post('email'),
					'nomor_kontak' => $this->input->post('nomor_kontak'),
					'website_url' => $this->input->post('website'),
					'alamat_1' => $this->input->post('alamat_1'),
					'alamat_2' => $this->input->post('alamat_2'),
					'kota' => $this->input->post('kota'),
					'provinsi' => $this->input->post('provinsi'),
					'kode_pos' => $this->input->post('kode_pos'),
					'negara' => $this->input->post('negara'),
					'default_currency' => $this->input->post('default_currency'),
					'default_timezone' => $this->input->post('default_timezone'),
				);
				$result = $this->Perusahaan_model->update_record_no_logo($no_logo_data,$id);
				if($count_module_attributes > 0){
					foreach($module_attributes as $mattribute) {
						$count_exist_values = $this->Custom_fields_model->count_module_attributes_values($id,$mattribute->custom_field_id);
						if($count_exist_values > 0){
							if($mattribute->attribute_type == 'fileupload'){
								if($_FILES[$mattribute->attribute]['size'] != 0) {
									if(is_uploaded_file($_FILES[$mattribute->attribute]['tmp_name'])) {
										$allowed =  array('png','jpg','jpeg','pdf','gif','xls','doc','xlsx','docx');
										$filename = $_FILES[$mattribute->attribute]['name'];
										$ext = pathinfo($filename, PATHINFO_EXTENSION);
										if(in_array($ext,$allowed)){
											$tmp_name = $_FILES[$mattribute->attribute]["tmp_name"];
											$profile = "uploads/custom_files/";
											$set_img = base_url()."uploads/custom_files/";
											$name = basename($_FILES[$mattribute->attribute]["name"]);
											$newfilename = 'custom_file_'.round(microtime(true)).'.'.$ext;
											move_uploaded_file($tmp_name, $profile.$newfilename);
											$fname = $newfilename;	
										}
										$iattr_data = array(
											'attribute_value' => $fname
										);
										$this->Custom_fields_model->update_att_record($iattr_data, $id,$mattribute->custom_field_id);
									}
								} else {
								}
							} else if($mattribute->attribute_type == 'multiselect') {
								$multisel_val = $this->input->post($mattribute->attribute);
								if(!empty($multisel_val)){
									$newdata = implode(',', $this->input->post($mattribute->attribute));
									$iattr_data = array(
										'attribute_value' => $newdata,
									);
									$this->Custom_fields_model->update_att_record($iattr_data, $id,$mattribute->custom_field_id);
								}
							} else {
								$attr_data = array(
									'attribute_value' => $this->input->post($mattribute->attribute),
								);
								$this->Custom_fields_model->update_att_record($attr_data, $id,$mattribute->custom_field_id);
							}
						} else {
							if($mattribute->attribute_type == 'fileupload'){
								if($_FILES[$mattribute->attribute]['size'] != 0) {
									if(is_uploaded_file($_FILES[$mattribute->attribute]['tmp_name'])) {
										$allowed =  array('png','jpg','jpeg','pdf','gif','xls','doc','xlsx','docx');
										$filename = $_FILES[$mattribute->attribute]['name'];
										$ext = pathinfo($filename, PATHINFO_EXTENSION);
										if(in_array($ext,$allowed)){
											$tmp_name = $_FILES[$mattribute->attribute]["tmp_name"];
											$profile = "uploads/custom_files/";
											$set_img = base_url()."uploads/custom_files/";
											$name = basename($_FILES[$mattribute->attribute]["name"]);
											$newfilename = 'custom_file_'.round(microtime(true)).'.'.$ext;
											move_uploaded_file($tmp_name, $profile.$newfilename);
											$fname = $newfilename;	
										}
										$iattr_data = array(
											'user_id' => $id,
											'module_attributes_id' => $mattribute->custom_field_id,
											'attribute_value' => $fname,
											'created_at' => date('Y-m-d h:i:s')
										);
										$this->Custom_fields_model->add_values($iattr_data);
									}
								} else {
									if($this->input->post($mattribute->attribute) == ''){
										$file_val = '';
									} else {
										$file_val = $this->input->post($mattribute->attribute);
									}
									$iattr_data = array(
										'user_id' => $id,
										'module_attributes_id' => $mattribute->custom_field_id,
										'created_at' => date('Y-m-d h:i:s')
									);
									$this->Custom_fields_model->add_values($iattr_data);
								}
							} else if($mattribute->attribute_type == 'multiselect') {
								$multisel_val = $this->input->post($mattribute->attribute);
								if(!empty($multisel_val)){
									$newdata = implode(',', $this->input->post($mattribute->attribute));
									$iattr_data = array(
										'user_id' => $id,
										'module_attributes_id' => $mattribute->custom_field_id,
										'attribute_value' => $newdata,
										'created_at' => date('Y-m-d h:i:s')
									);
									$this->Custom_fields_model->add_values($iattr_data);
								}
							} else {
								if($this->input->post($mattribute->attribute) == ''){
									$file_val = '';
								} else {
									$file_val = $this->input->post($mattribute->attribute);
								}
								$iattr_data = array(
									'user_id' => $id,
									'module_attributes_id' => $mattribute->custom_field_id,
									'attribute_value' => $file_val,
									'created_at' => date('Y-m-d h:i:s')
								);
								$this->Custom_fields_model->add_values($iattr_data);
							}
						}
					}
				}
			} else {
				$module_attributes = $this->Custom_fields_model->perusahaan_hrastral_module_attributes();
				$count_module_attributes = $this->Custom_fields_model->count_perusahaan_module_attributes();	
				$i=1;
				if($count_module_attributes > 0){
					foreach($module_attributes as $mattribute) {
						if($mattribute->validation == 1){
							if($i!=1) {
							} else if($this->input->post($mattribute->attribute)=='') {
								$Return['error'] = $this->lang->line('umb_hrastral_custom_field_the').' '.$mattribute->attribute_label.' '.$this->lang->line('umb_hrastral_custom_field_is_required');
							}
						}
					}		
					if($Return['error']!=''){
						$this->output($Return);
					}	
				}
				if(is_uploaded_file($_FILES['logo']['tmp_name'])) {

					$allowed =  array('png','jpg','jpeg','gif');
					$filename = $_FILES['logo']['name'];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);

					if(in_array($ext,$allowed)){
						$tmp_name = $_FILES["logo"]["tmp_name"];
						$bill_copy = "uploads/perusahaan/";
						$lname = basename($_FILES["logo"]["name"]);
						$newfilename = 'logo_'.round(microtime(true)).'.'.$ext;
						move_uploaded_file($tmp_name, $bill_copy.$newfilename);
						$fname = $newfilename;
						$data = array(
							'name' => $this->input->post('name'),
							'type_id' => $this->input->post('type_perusahaan'),
							'pajak_pemerintah' => $this->input->post('umb_pjkprmth'),
							'nama_trading' => $this->input->post('nama_trading'),
							'registration_no' => $this->input->post('registration_no'),
							'email' => $this->input->post('email'),
							'nomor_kontak' => $this->input->post('nomor_kontak'),
							'website_url' => $this->input->post('website'),
							'alamat_1' => $this->input->post('alamat_1'),
							'alamat_2' => $this->input->post('alamat_2'),
							'kota' => $this->input->post('kota'),
							'provinsi' => $this->input->post('provinsi'),
							'kode_pos' => $this->input->post('kode_pos'),
							'negara' => $this->input->post('negara'),
							'logo' => $fname,		
						);
						$result = $this->Perusahaan_model->update_record($data,$id);
						if($count_module_attributes > 0){
							foreach($module_attributes as $mattribute) {
								$count_exist_values = $this->Custom_fields_model->count_module_attributes_values($id,$mattribute->custom_field_id);
								if($count_exist_values > 0){
									if($mattribute->attribute_type == 'fileupload'){
										if($_FILES[$mattribute->attribute]['size'] != 0) {
											if(is_uploaded_file($_FILES[$mattribute->attribute]['tmp_name'])) {

												$allowed =  array('png','jpg','jpeg','pdf','gif','xls','doc','xlsx','docx');
												$filename = $_FILES[$mattribute->attribute]['name'];
												$ext = pathinfo($filename, PATHINFO_EXTENSION);

												if(in_array($ext,$allowed)){
													$tmp_name = $_FILES[$mattribute->attribute]["tmp_name"];
													$profile = "uploads/custom_files/";
													$set_img = base_url()."uploads/custom_files/";


													$name = basename($_FILES[$mattribute->attribute]["name"]);
													$newfilename = 'custom_file_'.round(microtime(true)).'.'.$ext;
													move_uploaded_file($tmp_name, $profile.$newfilename);
													$fname = $newfilename;	
												}
												$iattr_data = array(
													'attribute_value' => $fname
												);
												$this->Custom_fields_model->update_att_record($iattr_data, $id,$mattribute->custom_field_id);
											}

										} else {
										}
									} else if($mattribute->attribute_type == 'multiselect') {
										$multisel_val = $this->input->post($mattribute->attribute);
										if(!empty($multisel_val)){
											$newdata = implode(',', $this->input->post($mattribute->attribute));
											$iattr_data = array(
												'attribute_value' => $newdata,
											);
											$this->Custom_fields_model->update_att_record($iattr_data, $id,$mattribute->custom_field_id);
										}
									} else {
										$attr_data = array(
											'attribute_value' => $this->input->post($mattribute->attribute),
										);
										$this->Custom_fields_model->update_att_record($attr_data, $id,$mattribute->custom_field_id);
									}

								} else {
									if($mattribute->attribute_type == 'fileupload'){
										if($_FILES[$mattribute->attribute]['size'] != 0) {
											if(is_uploaded_file($_FILES[$mattribute->attribute]['tmp_name'])) {

												$allowed =  array('png','jpg','jpeg','pdf','gif','xls','doc','xlsx','docx');
												$filename = $_FILES[$mattribute->attribute]['name'];
												$ext = pathinfo($filename, PATHINFO_EXTENSION);

												if(in_array($ext,$allowed)){
													$tmp_name = $_FILES[$mattribute->attribute]["tmp_name"];
													$profile = "uploads/custom_files/";
													$set_img = base_url()."uploads/custom_files/";


													$name = basename($_FILES[$mattribute->attribute]["name"]);
													$newfilename = 'custom_file_'.round(microtime(true)).'.'.$ext;
													move_uploaded_file($tmp_name, $profile.$newfilename);
													$fname = $newfilename;	
												}
												$iattr_data = array(
													'user_id' => $id,
													'module_attributes_id' => $mattribute->custom_field_id,
													'attribute_value' => $fname,
													'created_at' => date('Y-m-d h:i:s')
												);
												$this->Custom_fields_model->add_values($iattr_data);
											}
										} else {
											if($this->input->post($mattribute->attribute) == ''){
												$file_val = '';
											} else {
												$file_val = $this->input->post($mattribute->attribute);
											}
											$iattr_data = array(
												'user_id' => $id,
												'module_attributes_id' => $mattribute->custom_field_id,
												'created_at' => date('Y-m-d h:i:s')
											);
											$this->Custom_fields_model->add_values($iattr_data);
										}
									} else if($mattribute->attribute_type == 'multiselect') {
										$multisel_val = $this->input->post($mattribute->attribute);
										if(!empty($multisel_val)){
											$newdata = implode(',', $this->input->post($mattribute->attribute));
											$iattr_data = array(
												'user_id' => $id,
												'module_attributes_id' => $mattribute->custom_field_id,
												'attribute_value' => $newdata,
												'created_at' => date('Y-m-d h:i:s')
											);
											$this->Custom_fields_model->add_values($iattr_data);
										}
									} else {
										if($this->input->post($mattribute->attribute) == ''){
											$file_val = '';
										} else {
											$file_val = $this->input->post($mattribute->attribute);
										}
										$iattr_data = array(
											'user_id' => $id,
											'module_attributes_id' => $mattribute->custom_field_id,
											'attribute_value' => $file_val,
											'created_at' => date('Y-m-d h:i:s')
										);
										$this->Custom_fields_model->add_values($iattr_data);
									}
								}
							}
						}
					} else {
						$Return['error'] = $this->lang->line('umb_error_attatchment_type');
					}
				}
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_perbarui_perusahaan');
			} else {
				$Return['error'] = $Return['error'] = $this->lang->line('umb_error_msg');
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
			$result = $this->Perusahaan_model->delete_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_sukses_hapus_perusahaan');
			} else {
				$Return['error'] = $Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}

	public function delete_document() {

		if($this->input->post('is_ajax')==2) {
			$session = $this->session->userdata('username');
			if(empty($session)){ 
				redirect('admin/');
			}
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Perusahaan_model->delete_record_doc($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_hr_document_resmi_dihapus');
			} else {
				$Return['error'] = $Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}
}
