<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Assets extends MY_Controller {

	public function output($Return=array()){
		
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		
		exit(json_encode($Return));
	}
	
	public function __construct() {

		parent::__construct();
		$this->load->model('Umb_model');
		$this->load->model('Karyawans_model');
		$this->load->model('Department_model');
		$this->load->model('Assets_model');
		$this->load->model('Custom_fields_model');
	}

	public function index() {

		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		$system = $this->Umb_model->read_setting_info(1);
		if($system[0]->module_assets!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('umb_assets').' | '.$this->Umb_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('umb_assets');
		$data['path_url'] = 'assets';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		$data['all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		$data['all_kategoris_assets'] = $this->Assets_model->get_all_kategoris_assets();
		if(in_array('25',$role_resources_ids)) {
			$id = $this->uri->segment(4);
			$edata = array(
				'is_notify' => 0,
			);
			$this->Umb_model->update_notification_record($edata,$id,$session['user_id'],'asset');
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/assets/list_assets", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}
	
	public function kategori() {

		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('umb_kategori_assets').' | '.$this->Umb_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('umb_kategori_assets');
		$data['all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$data['path_url'] = 'kategori_assets';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('26',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/assets/list_kategori_assets", $data, TRUE);
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
			$this->load->view("admin/assets/get_karyawans", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}

	public function list_kategori(){

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		if(!empty($session)){ 
			$this->load->view("admin/languages/list_languages", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$kategori_assets = $this->Assets_model->get_kategoris_assets();
		$role_resources_ids = $this->Umb_model->user_role_resource();
		$data = array();
		foreach($kategori_assets->result() as $r) {						
			if(in_array('267',$role_resources_ids)) {
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->kategori_assets_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('268',$role_resources_ids)) {
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->kategori_assets_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}
			$combhr = $edit.$delete;

			$data[] = array($combhr,
				$r->nama_kategori
			);
		}
		$output = array(
			"draw" => $draw,
			"recordsTotal" => $kategori_assets->num_rows(),
			"recordsFiltered" => $kategori_assets->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function list_assets(){

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		if(!empty($session)){ 
			$this->load->view("admin/languages/list_languages", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$role_resources_ids = $this->Umb_model->user_role_resource();
		$user_info = $this->Umb_model->read_user_info($session['user_id']);
		if($user_info[0]->user_role_id==1){
			$assets = $this->Assets_model->get_assets();
		} else {
			if(in_array('265',$role_resources_ids)) {
				$assets = $this->Assets_model->get_perusahaan_assets($user_info[0]->perusahaan_id);
			} else {
				$assets = $this->Assets_model->get_assets_karyawan($session['user_id']);
			}
		}
		$data = array();
		
		foreach($assets->result() as $r) {						
			$perusahaan = $this->Umb_model->read_info_perusahaan($r->perusahaan_id);
			if(!is_null($perusahaan)){
				$prshn_nama = $perusahaan[0]->name;
			} else {
				$prshn_nama = '--';	
			}
			$kategori_assets = $this->Assets_model->read_info_kategori_assets($r->kategori_assets_id);
			if(!is_null($kategori_assets)){
				$kategori = $kategori_assets[0]->nama_kategori;
			} else {
				$kategori = '--';	
			}
			if($r->sedang_bekerja==1){
				$bekerja = $this->lang->line('umb_yes');
			} else {
				$bekerja = $this->lang->line('umb_no');
			}
			$user = $this->Umb_model->read_user_info($r->karyawan_id);
			if(!is_null($user)){
				$full_name = $user[0]->first_name.' '.$user[0]->last_name;
			} else {
				$full_name = '--';	
			}
			if(in_array('263',$role_resources_ids)) { 
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->assets_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('264',$role_resources_ids)) {
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->assets_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}
			if(in_array('265',$role_resources_ids)) {
				$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target="#modals-slide" data-asset_id="'. $r->assets_id . '"><span class="fa fa-eye"></span></button></span>';
			} else {
				$view = '';
			}
			$combhr = $edit.$view.$delete;
			$created_at = $this->Umb_model->set_date_format($r->created_at);
			$iname = $r->name.'<br><small class="text-muted"><i>'.$this->lang->line('umb_created_at').': '.$created_at.'<i></i></i></small>';					 			  				
			$data[] = array($combhr,
				$iname,
				$kategori,
				$r->kode_asset_perusahaan,
				$bekerja,
				$full_name,
				$prshn_nama
			);
		}
		$output = array(
			"draw" => $draw,
			"recordsTotal" => $assets->num_rows(),
			"recordsFiltered" => $assets->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function read_asset(){

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('asset_id');
		$result = $this->Assets_model->read_info_assets($id);
		$data = array(
			'assets_id' => $result[0]->assets_id,
			'kategori_assets_id' => $result[0]->kategori_assets_id,
			'perusahaan_id' => $result[0]->perusahaan_id,
			'karyawan_id' => $result[0]->karyawan_id,
			'kode_asset_perusahaan' => $result[0]->kode_asset_perusahaan,
			'name' => $result[0]->name,
			'tanggal_pembelian' => $result[0]->tanggal_pembelian,
			'nomor_invoice' => $result[0]->nomor_invoice,
			'manufacturer' => $result[0]->manufacturer,
			'serial_number' => $result[0]->serial_number,
			'tanggal_akhir_garansi' => $result[0]->tanggal_akhir_garansi,
			'asset_note' => $result[0]->asset_note,
			'asset_image' => $result[0]->asset_image,
			'sedang_bekerja' => $result[0]->sedang_bekerja,
			'created_at' => $result[0]->created_at,
			'all_karyawans' => $this->Umb_model->all_karyawans(),
			'all_kategoris_assets' => $this->Assets_model->get_all_kategoris_assets(),
			'all_perusahaans' => $this->Umb_model->get_perusahaans()
		);
		if(!empty($session)){ 
			$this->load->view('admin/assets/dialog_asset', $data);
		} else {
			redirect('admin/');
		}
	}

	public function add_kategori() {

		if($this->input->post('add_type')=='add_kategori') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			if($this->input->post('name')==='') {
				$Return['error'] = $this->lang->line('umb_error_field_nama_kat');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$data = array(
				'nama_kategori' => $this->input->post('name'),
				'created_at' => date('d-m-Y h:i:s')
			);
			$result = $this->Assets_model->add_kategori_assets($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_kategori_assets_ditambahkan');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function add_asset() {

		if($this->input->post('add_type')=='add_asset') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			if($this->input->post('kategori_id')==='') {
				$Return['error'] = $this->lang->line('umb_error_field_kategori');
			} else if($this->input->post('nama_asset')==='') {
				$Return['error'] = $this->lang->line('umb_error_field_nama_asset');
			} else if($this->input->post('perusahaan_id')==='') {
				$Return['error'] = $this->lang->line('error_field_perusahaan');
			} else if($this->input->post('karyawan_id')==='') {
				$Return['error'] = $this->lang->line('umb_error_karyawan_id');
			} 
			if($Return['error']!=''){
				$this->output($Return);
			}
			if(is_uploaded_file($_FILES['asset_image']['tmp_name'])) {
				$allowed =  array('png','jpg','jpeg','gif');
				$filename = $_FILES['asset_image']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				if(in_array($ext,$allowed)){
					$tmp_name = $_FILES["asset_image"]["tmp_name"];
					$asset_image = "uploads/asset_image/";
					$lname = basename($_FILES["asset_image"]["name"]);
					$newfilename = 'asset_image_'.round(microtime(true)).'.'.$ext;
					move_uploaded_file($tmp_name, $asset_image.$newfilename);
					$fname = $newfilename;
				} else {
					$Return['error'] = $this->lang->line('umb_error_asset_image_attachment');
				}
			} else {
				$fname = '';
			}
			$module_attributes = $this->Custom_fields_model->assets_hrastral_module_attributes();
			$count_module_attributes = $this->Custom_fields_model->count_assets_module_attributes();	
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
				'kategori_assets_id' => $this->input->post('kategori_id'),
				'name' => $this->input->post('nama_asset'),
				'kode_asset_perusahaan' => $this->input->post('kode_asset_perusahaan'),
				'sedang_bekerja' => $this->input->post('sedang_bekerja'),
				'perusahaan_id' => $this->input->post('perusahaan_id'),
				'karyawan_id' => $this->input->post('karyawan_id'),
				'tanggal_pembelian' => $this->input->post('tanggal_pembelian'),
				'nomor_invoice' => $this->input->post('nomor_invoice'),
				'manufacturer' => $this->input->post('manufacturer'),
				'serial_number' => $this->input->post('serial_number'),
				'tanggal_akhir_garansi' => $this->input->post('tanggal_akhir_garansi'),
				'asset_note' => $this->input->post('asset_note'),
				'asset_image' => $fname,
				'created_at' => date('d-m-Y h:i:s')
			);

			$iresult = $this->Assets_model->add_asset($data);
			if ($iresult) {
				$Return['result'] = $this->lang->line('umb_sukses_asset_ditambahkan');
				$id = $iresult;
				$nticket_data = array(
					'module_name' => 'asset',
					'module_id' => $id,
					'karyawan_id' => $this->input->post('karyawan_id'),
					'is_notify' => '1',
					'created_at' => date('d-m-Y h:i:s'),
				);
				$this->Umb_model->add_notifications($nticket_data);
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


	public function update_asset() {

		if($this->input->post('edit_type')=='update_asset') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');		
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();


			if($this->input->post('kategori_id')==='') {
				$Return['error'] = $this->lang->line('umb_error_field_kategori');
			} else if($this->input->post('nama_asset')==='') {
				$Return['error'] = $this->lang->line('umb_error_field_nama_asset');
			} else if($this->input->post('perusahaan_id')==='') {
				$Return['error'] = $this->lang->line('error_field_perusahaan');
			} else if($this->input->post('karyawan_id')==='') {
				$Return['error'] = $this->lang->line('umb_error_karyawan_id');
			} else if($_FILES['asset_image']['size'] == 0) {
				$module_attributes = $this->Custom_fields_model->assets_hrastral_module_attributes();
				$count_module_attributes = $this->Custom_fields_model->count_assets_module_attributes();$i=1;
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
					'kategori_assets_id' => $this->input->post('kategori_id'),
					'name' => $this->input->post('nama_asset'),
					'kode_asset_perusahaan' => $this->input->post('kode_asset_perusahaan'),
					'sedang_bekerja' => $this->input->post('sedang_bekerja'),
					'perusahaan_id' => $this->input->post('perusahaan_id'),
					'karyawan_id' => $this->input->post('karyawan_id'),
					'tanggal_pembelian' => $this->input->post('tanggal_pembelian'),
					'nomor_invoice' => $this->input->post('nomor_invoice'),
					'manufacturer' => $this->input->post('manufacturer'),
					'serial_number' => $this->input->post('serial_number'),
					'tanggal_akhir_garansi' => $this->input->post('tanggal_akhir_garansi'),
					'asset_note' => $this->input->post('asset_note')
				);

				$result = $this->Assets_model->update_record_assets($data,$id);
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
				$module_attributes = $this->Custom_fields_model->assets_hrastral_module_attributes();
				$count_module_attributes = $this->Custom_fields_model->count_assets_module_attributes();	
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
				if(is_uploaded_file($_FILES['asset_image']['tmp_name'])) {

					$allowed =  array('png','jpg','jpeg','gif');
					$filename = $_FILES['asset_image']['name'];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);

					if(in_array($ext,$allowed)){
						$tmp_name = $_FILES["asset_image"]["tmp_name"];
						$asset_image = "uploads/asset_image/";
						$lname = basename($_FILES["asset_image"]["name"]);
						$newfilename = 'asset_image_'.round(microtime(true)).'.'.$ext;
						move_uploaded_file($tmp_name, $asset_image.$newfilename);
						$fname = $newfilename;
						$data = array(
							'kategori_assets_id' => $this->input->post('kategori_id'),
							'name' => $this->input->post('nama_asset'),
							'kode_asset_perusahaan' => $this->input->post('kode_asset_perusahaan'),
							'sedang_bekerja' => $this->input->post('sedang_bekerja'),
							'perusahaan_id' => $this->input->post('perusahaan_id'),
							'karyawan_id' => $this->input->post('karyawan_id'),
							'tanggal_pembelian' => $this->input->post('tanggal_pembelian'),
							'nomor_invoice' => $this->input->post('nomor_invoice'),
							'manufacturer' => $this->input->post('manufacturer'),
							'serial_number' => $this->input->post('serial_number'),
							'tanggal_akhir_garansi' => $this->input->post('tanggal_akhir_garansi'),
							'asset_note' => $this->input->post('asset_note'),
							'asset_image' => $fname
						);
						$result = $this->Assets_model->update_record_assets($data,$id);
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
						$Return['error'] = $this->lang->line('umb_error_asset_image_attachment');
					}
				}
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_asset_ditambahkan');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}


	public function update_kategori_assets() {

		if($this->input->post('edit_type')=='kategori_assets') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');

			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();


			if($this->input->post('name')==='') {
				$Return['error'] = $this->lang->line('umb_error_field_nama_kat');
			}

			if($Return['error']!=''){
				$this->output($Return);
			}
			$data = array(
				'nama_kategori' => $this->input->post('name')
			);
			$result = $this->Assets_model->update_record_kategori_assets($data,$id);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_kategori_assets_diperbarui');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function read_kategori_assets() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('kategori_assets_id');
		$result = $this->Assets_model->read_info_kategori_assets($id);
		$data = array(
			'kategori_assets_id' => $result[0]->kategori_assets_id,
			'perusahaan_id' => $result[0]->perusahaan_id,
			'nama_kategori' => $result[0]->nama_kategori,
			'created_at' => $result[0]->created_at
		);
		if(!empty($session)){ 
			$this->load->view('admin/assets/dialog_kategori_assets', $data);
		} else {
			redirect('admin/');
		}
	}

	public function delete_asset() {

		if($this->input->post('type')=='delete_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Assets_model->delete_record_assets($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_sukses_asset_dihapus');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}

	public function delete_kategori_assets() {

		if($this->input->post('type')=='delete_record') {

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Assets_model->delete_record_kategori_assets($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_sukses_kategori_assets_dihapus');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}
} 
?>