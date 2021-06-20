<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pengumuman extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		
		$this->load->model("Pengumuman_model");
		$this->load->model("Umb_model");
		$this->load->model("Perusahaan_model");
		$this->load->model("Location_model");
		$this->load->model("Department_model");
		$this->load->model("Custom_fields_model");
	}
	
	
	public function output($Return=array()){
		
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		
		exit(json_encode($Return));
	}
	
	public function index(){
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}		
		$data['title'] = $this->lang->line('umb_pengumumans').' | '.$this->Umb_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('umb_pengumumans');
		$data['path_url'] = 'pengumumans';
		$data['get_all_perusahaans'] = $this->Perusahaan_model->get_all_perusahaans();
		$data['all_locations_kantor'] = $this->Location_model->all_locations_kantor();
		$data['all_departments'] = $this->Department_model->all_departments();
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('11',$role_resources_ids)) {
			$id = $this->uri->segment(4);
			$edata = array(
				'is_notify' => 0,
			);
			$this->Umb_model->update_notification_record($edata,$id,$session['user_id'],'pengumuman');
			$data['subview'] = $this->load->view("admin/pengumuman/list_pengumuman", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 	
		} else {
			redirect('admin/dashboard');
		}
	}

	public function list_pengumuman(){

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		$this->load->view("admin/pengumuman/list_pengumuman", $data);
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$role_resources_ids = $this->Umb_model->user_role_resource();
		$user_info = $this->Umb_model->read_user_info($session['user_id']);
		if($user_info[0]->user_role_id==1){
			$pengumuman = $this->Pengumuman_model->get_pengumumans();
		} else {
			if(in_array('257',$role_resources_ids)) {
				$pengumuman = $this->Pengumuman_model->get_pengumumans_perusahaan($user_info[0]->perusahaan_id);
			} else {
				$pengumuman = $this->Pengumuman_model->get_pengumumans_department($user_info[0]->department_id);
			}
		}
		$data = array();
		foreach($pengumuman->result() as $r) {
			$sdate = $this->Umb_model->set_date_format($r->start_date);
			$edate = $this->Umb_model->set_date_format($r->end_date);
			$department = $this->Department_model->read_informasi_department($r->department_id);
			if(!is_null($department)){
				$nama_department = $department[0]->nama_department;
			} else {
				$nama_department = '--';	
			}
			$perusahaan = $this->Umb_model->read_info_perusahaan($r->perusahaan_id);
			if(!is_null($perusahaan)){
				$prshn_nama = $perusahaan[0]->name;
			} else {
				$prshn_nama = '--';	
			}
			$location = $this->Umb_model->read_info_location($r->location_id);
			if(!is_null($location)){
				$nama_location = $location[0]->nama_location;
			} else {
				$nama_location = '--';	
			}
			if(in_array('255',$role_resources_ids)) {
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-pengumuman_id="'. $r->pengumuman_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('256',$role_resources_ids)) {
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->pengumuman_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}
			if(in_array('257',$role_resources_ids)) {
				$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target="#modals-slide" data-pengumuman_id="'. $r->pengumuman_id . '"><span class="fa fa-eye"></span></button></span>';
			} else {
				$view = '';
			}
			$combhr = $edit.$view.$delete;
			$ititle = $r->title.'<br><small class="text-muted"><i>'.$this->lang->line('umb_published_for').': '.$nama_location.'('.$nama_department.')'.'<i></i></i></small>';
			$data[] = array(
				$combhr,
				$ititle,
				$prshn_nama,
				$sdate,
				$edate
			);
		}
		$output = array(
			"draw" => $draw,
			"recordsTotal" => $pengumuman->num_rows(),
			"recordsFiltered" => $pengumuman->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function read() {
		
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('pengumuman_id');
		$result = $this->Pengumuman_model->read_informasi_pengumuman($id);
		$data = array(
			'pengumuman_id' => $result[0]->pengumuman_id,
			'title' => $result[0]->title,
			'perusahaan_id' => $result[0]->perusahaan_id,
			'start_date' => $result[0]->start_date,
			'end_date' => $result[0]->end_date,
			'perusahaan_id' => $result[0]->perusahaan_id,
			'location_id' => $result[0]->location_id,
			'department_id' => $result[0]->department_id,
			'diterbitkan_oleh' => $result[0]->diterbitkan_oleh,
			'summary' => $result[0]->summary,
			'description' => $result[0]->description,
			'get_all_perusahaans' => $this->Perusahaan_model->get_all_perusahaans(),
			'all_locations_kantor' => $this->Location_model->all_locations_kantor(),
			'all_departments' => $this->Department_model->all_departments()
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/pengumuman/dialog_pengumuman', $data);
		} else {
			redirect('admin/');
		}
	}

	public function get_perusahaan_dialog_elocations() {

		$data['title'] = $this->Umb_model->site_title();
		$keywords = preg_split("/[\s,]+/", $this->uri->segment(4));
		if(is_numeric($keywords[0])) {
			$id = $keywords[0];
			$data = array(
				'perusahaan_id' => $id
			);
			$session = $this->session->userdata('username');
			if(!empty($session)){ 
				$data = $this->security->xss_clean($data);
				$this->load->view("admin/pengumuman/get_perusahaan_dialog_elocations", $data);
			} else {
				redirect('admin/');
			}
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}

	public function get_dialog_location_departments() {

		$data['title'] = $this->Umb_model->site_title();
		$keywords = preg_split("/[\s,]+/", $this->uri->segment(4));
		if(is_numeric($keywords[0])) {
			$id = $keywords[0];

			$data = array(
				'location_id' => $id
			);
			$session = $this->session->userdata('username');
			if(!empty($session)){ 
				$data = $this->security->xss_clean($data);
				$this->load->view("admin/pengumuman/get_dialog_location_departments", $data);
			} else {
				redirect('admin/');
			}
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}

	public function get_location_departments() {

		$data['title'] = $this->Umb_model->site_title();
		$keywords = preg_split("/[\s,]+/", $this->uri->segment(4));
		if(is_numeric($keywords[0])) {
			$id = $keywords[0];

			$data = array(
				'location_id' => $id
			);
			$session = $this->session->userdata('username');
			if(!empty($session)){ 
				$data = $this->security->xss_clean($data);
				$this->load->view("admin/karyawans/get_location_departments", $data);
			} else {
				redirect('admin/');
			}
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}

	public function get_departments() {

		$data['title'] = $this->Umb_model->site_title();
		$id = $this->uri->segment(4);
		$data = array(
			'perusahaan_id' => $id
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/pengumuman/get_departments", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}

	public function add_pengumuman() {

		if($this->input->post('add_type')=='pengumuman') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$start_date = $this->input->post('start_date');
			$end_date = $this->input->post('end_date');
			$description = $this->input->post('description');
			$st_date = strtotime($start_date);
			$ed_date = strtotime($end_date);
			$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
			if($this->input->post('title')==='') {
				$Return['error'] = $this->lang->line('umb_error_title');
			} else if($this->input->post('start_date')==='') {
				$Return['error'] = $this->lang->line('umb_error_start_date');
			} else if($this->input->post('end_date')==='') {
				$Return['error'] = $this->lang->line('umb_error_end_date');
			} else if($st_date > $ed_date) {
				$Return['error'] = $this->lang->line('umb_error_start_end_date');
			} else if($this->input->post('perusahaan_id')==='') {
				$Return['error'] = $this->lang->line('error_field_perusahaan');
			} else if($this->input->post('location_id')==='') {
				$Return['error'] = $this->lang->line('error_field_location_dept');
			} else if($this->input->post('department_id')==='') {
				$Return['error'] = $this->lang->line('error_field_department');
			} else if($this->input->post('summary')==='') {
				$Return['error'] = $this->lang->line('umb_error_field_summary');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$module_attributes = $this->Custom_fields_model->pengumumans_hrastral_module_attributes();
			$count_module_attributes = $this->Custom_fields_model->count_pengumumans_module_attributes();	
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
				'title' => $this->input->post('title'),
				'start_date' => $this->input->post('start_date'),
				'end_date' => $this->input->post('end_date'),
				'perusahaan_id' => $this->input->post('perusahaan_id'),
				'location_id' => $this->input->post('location_id'),
				'department_id' => $this->input->post('department_id'),
				'description' => $qt_description,
				'summary' => $this->input->post('summary'),
				'is_notify' => 1,
				'diterbitkan_oleh' => $this->input->post('user_id'),
				'created_at' => date('d-m-Y'),

			);
			$iresult = $this->Pengumuman_model->add($data);
			if ($iresult) {
				$Return['result'] = $this->lang->line('umb_sukses_tambah_pengumuman');
				$id = $iresult;
				$dep_karyawans = $this->Umb_model->get_department_karyawans($this->input->post('department_id'));
				foreach($dep_karyawans as $dkaryawans){
					$nticket_data = array(
						'module_name' => 'pengumuman',
						'module_id' => $id,
						'karyawan_id' => $dkaryawans->user_id,
						'is_notify' => '1',
						'created_at' => date('d-m-Y h:i:s'),
					);
					$this->Umb_model->add_notifications($nticket_data);
				}
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

	public function update() {

		if($this->input->post('edit_type')=='pengumuman') {

			$id = $this->uri->segment(4);
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$start_date = $this->input->post('start_date_modal');
			$end_date = $this->input->post('end_date_modal');
			$description = $this->input->post('description');
			$st_date = strtotime($start_date);
			$ed_date = strtotime($end_date);
			$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
			if($this->input->post('title')==='') {
				$Return['error'] = $this->lang->line('umb_error_title');
			} else if($this->input->post('start_date')==='') {
				$Return['error'] = $this->lang->line('umb_error_start_date');
			} else if($this->input->post('end_date')==='') {
				$Return['error'] = $this->lang->line('umb_error_end_date');
			} else if($st_date > $ed_date) {
				$Return['error'] = $this->lang->line('umb_error_start_end_date');
			} else if($this->input->post('summary')==='') {
				$Return['error'] = $this->lang->line('umb_error_field_summary');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$module_attributes = $this->Custom_fields_model->pengumumans_hrastral_module_attributes();
			$count_module_attributes = $this->Custom_fields_model->count_pengumumans_module_attributes();	
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
				'title' => $this->input->post('title'),
				'start_date' => $this->input->post('start_date_modal'),
				'end_date' => $this->input->post('end_date_modal'),
				'description' => $qt_description,
				'summary' => $this->input->post('summary')		
			);
			$result = $this->Pengumuman_model->update_record($data,$id);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_perbarui_pengumuman');
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
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function delete() {

		if($this->input->post('is_ajax')==2) {

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Pengumuman_model->delete_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_sukses_hapus_pengumuman');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}
}
