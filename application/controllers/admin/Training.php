<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Training extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		
		$this->load->model("Training_model");
		$this->load->model("Umb_model");
		$this->load->model("Trainers_model");
		$this->load->model("Penunjukan_model");
		$this->load->model("Department_model");
		$this->load->model("Custom_fields_model");
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
		if($system[0]->module_training!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('left_training').' | '.$this->Umb_model->site_title();
		$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		$data['all_trainers'] = $this->Trainers_model->all_trainers();
		$data['all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$data['breadcrumbs'] = $this->lang->line('left_training');
		$data['path_url'] = 'training';
		$data['all_types_training'] = $this->Training_model->all_types_training();
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('54',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/training/list_training", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}
	
	public function list_training() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/training/list_training", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$role_resources_ids = $this->Umb_model->user_role_resource();
		$user_info = $this->Umb_model->read_user_info($session['user_id']);
		if($user_info[0]->user_role_id==1){
			$training = $this->Training_model->get_training();
		} else {
			if(in_array('344',$role_resources_ids)) {
				$training = $this->Training_model->get_perusahaan_training($user_info[0]->perusahaan_id);
			} else {
				$training = $this->Training_model->get_karyawan_training($session['user_id']);
			}
		}
		$data = array();

		foreach($training->result() as $r) {
			$aim = explode(',',$r->karyawan_id);
			$type = $this->Training_model->read_informasi_type_training($r->type_training_id);
			if(!is_null($type)){
				$itype = $type[0]->type;
			} else {
				$itype = '--';	
			}
			if($r->trainer_option == 2){
				$trainer = $this->Trainers_model->read_informasi_trainer($r->trainer_id);
				if(!is_null($trainer)){
					$nama_trainer = $trainer[0]->first_name.' '.$trainer[0]->last_name;
				} else {
					$nama_trainer = '--';	
				}
			} elseif($r->trainer_option == 1){
				$trainer = $this->Umb_model->read_user_info($r->trainer_id);
				if(!is_null($trainer)){
					$nama_trainer = $trainer[0]->first_name.' '.$trainer[0]->last_name;
				} else {
					$nama_trainer = '--';	
				}
			} else {
				$nama_trainer = '--';
			}
			$start_date = $this->Umb_model->set_date_format($r->start_date);
			$finish_date = $this->Umb_model->set_date_format($r->finish_date);
			$tanggal_training = $start_date.' '.$this->lang->line('dashboard_to').' '.$finish_date;
			$biaya_training = $this->Umb_model->currency_sign($r->biaya_training);
			if($r->karyawan_id == '') {
				$ol = '--';
			} else {
				$ol = '<ol class="nl">';
				foreach(explode(',',$r->karyawan_id) as $uid) {
					$user = $this->Umb_model->read_user_info($uid);
					if(!is_null($user)){
						$ol .= '<li>'.$user[0]->first_name.' '.$user[0]->last_name.'</li>';
					} else {
						$ol .= '--';
					}
				}
				$ol .= '</ol>';
			}
			//if($r->status_training==0): $status = $this->lang->line('umb_pending');
			//elseif($r->status_training==1): $status = $this->lang->line('umb_started'); elseif($r->status_training==2): $status = $this->lang->line('umb_completed');
			//else: $status = $this->lang->line('umb_terminated'); endif;
			if($r->status_training==0): 
				$status = '<span class="badge badge-warning">'.$this->lang->line('umb_pending').'</span>';
			elseif($r->status_training==1): 
				$status = '<span class="badge badge-info">'.$this->lang->line('umb_started').'</span>'; 
			elseif($r->status_training==2): 
				$status = '<span class="badge badge-success">'.$this->lang->line('umb_completed').'</span>';
			else: 
				$status = '<span class="badge badge-danger">'.$this->lang->line('umb_terminated').'</span>'; 
			endif;
			$perusahaan = $this->Umb_model->read_info_perusahaan($r->perusahaan_id);
			if(!is_null($perusahaan)){
				$prshn_nama = $perusahaan[0]->name;
			} else {
				$prshn_nama = '--';	
			}
			if(in_array('342',$role_resources_ids)) {
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-training_id="'. $r->training_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('343',$role_resources_ids)) {
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->training_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}
			if(in_array('344',$role_resources_ids)) {
				$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_view_details').'"><a href="'.site_url().'admin/training/details/'.$r->training_id.'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span>';
			} else {
				$view = '';
			}
			$combhr = $edit.$view.$delete;
			$iitype = $itype.'<br><small class="text-muted"><i>'.$status.'<i></i></i></small>';
			$data[] = array(
				$combhr,
				$iitype,
				$ol,
				$prshn_nama,
				$nama_trainer,
				$tanggal_training,
				$biaya_training,
			);		
		}
		$output = array(
			"draw" => $draw,
			"recordsTotal" => $training->num_rows(),
			"recordsFiltered" => $training->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}
	
	public function get_karyawans() {

		$data['title'] = $this->Umb_model->site_title();
		$id = $this->uri->segment(4);
		$data = array(
			'perusahaan_id' => $id
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/training/get_karyawans", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}
	
	public function read() {

		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('training_id');
		$result = $this->Training_model->read_informasi_training($id);
		$data = array(
			'title' => $this->Umb_model->site_title(),
			'perusahaan_id' => $result[0]->perusahaan_id,
			'training_id' => $result[0]->training_id,
			'karyawan_id' => $result[0]->karyawan_id,
			'type_training_id' => $result[0]->type_training_id,
			'trainer_id' => $result[0]->trainer_id,
			'trainer_option' => $result[0]->trainer_option,
			'start_date' => $result[0]->start_date,
			'finish_date' => $result[0]->finish_date,
			'biaya_training' => $result[0]->biaya_training,
			'status_training' => $result[0]->status_training,
			'description' => $result[0]->description,
			'performance' => $result[0]->performance,
			'remarks' => $result[0]->remarks,
			'all_karyawans' => $this->Umb_model->all_karyawans(),
			'all_types_training' => $this->Training_model->all_types_training(),
			'all_trainers' => $this->Trainers_model->all_trainers(),
			'all_perusahaans' => $this->Umb_model->get_perusahaans()
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/training/dialog_training', $data);
		} else {
			redirect('admin/');
		}
	}
	
	
	public function add_training() {
		
		if($this->input->post('add_type')=='training') {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$start_date = $this->input->post('start_date');
			$end_date = $this->input->post('end_date');
			$description = $this->input->post('description');
			$st_date = strtotime($start_date);
			$ed_date = strtotime($end_date);
			$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
			if($this->input->post('perusahaan')==='') {
				$Return['error'] = $this->lang->line('error_field_perusahaan');
			} else if($this->input->post('trainer_option')==='') {
				$Return['error'] = $this->lang->line('umb_trainer_opt_error_field');
			} else if($this->input->post('type_training')==='') {
				$Return['error'] = $this->lang->line('umb_error_type_training');
			} else if($this->input->post('trainer')==='') {
				$Return['error'] = $this->lang->line('umb_error_trainer_field');
			} else if($this->input->post('start_date')==='') {
				$Return['error'] = $this->lang->line('umb_error_start_date');
			} else if($this->input->post('end_date')==='') {
				$Return['error'] = $this->lang->line('umb_error_end_date');
			} else if($st_date > $ed_date) {
				$Return['error'] = $this->lang->line('umb_error_start_end_date');
			} else if($this->input->post('karyawan_id')==='') {
				$Return['error'] = $this->lang->line('umb_error_karyawan_id');
			} 
			if($Return['error']!=''){
				$this->output($Return);
			}
			$karyawan_ids = implode(',',$_POST['karyawan_id']);
			$karyawan_id = $karyawan_ids;
			$module_attributes = $this->Custom_fields_model->training_hrastral_module_attributes();
			$count_module_attributes = $this->Custom_fields_model->count_training_module_attributes();	
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
				'type_training_id' => $this->input->post('type_training'),
				'perusahaan_id' => $this->input->post('perusahaan'),
				'trainer_id' => $this->input->post('trainer'),
				'trainer_option' => $this->input->post('trainer_option'),
				'biaya_training' => $this->input->post('biaya_training'),
				'start_date' => $this->input->post('start_date'),
				'finish_date' => $this->input->post('end_date'),
				'karyawan_id' => $karyawan_id,
				'description' => $qt_description,
				'created_at' => date('d-m-Y h:i:s')
			);
			$iresult = $this->Training_model->add($data);
			if ($iresult) {
				$row = $this->db->select("*")->limit(1)->order_by('training_id',"DESC")->get("umb_training")->row();
				$Return['result'] = $this->lang->line('umb_sukses_training_ditambahkan');	
				$type = $this->Training_model->read_informasi_type_training($row->type_training_id);
				if(!is_null($type)){
					$itype = $type[0]->type;
				} else {
					$itype = '--';	
				}
				$Return['re_last_id'] = $row->training_id;
				$Return['re_type'] = $itype;	
				$id = $iresult;
				if($count_module_attributes > 0){
					foreach($module_attributes as $mattribute) {
						/*$attr_data = array(
							'user_id' => $iresult,
							'module_attributes_id' => $mattribute->custom_field_id,
							'attribute_value' => $this->input->post($mattribute->attribute),
							'created_at' => date('Y-m-d h:i:s')
						);
						$this->Custom_fields_model->add_values($attr_data);*/
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
						/*$attr_orig_value = $this->Custom_fields_model->read_hrastral_module_attributes_values($result,$mattribute->custom_field_id);
						if($attr_orig_value->module_attributes_id != $mattribute->custom_field_id) {
							$this->Custom_fields_model->add_values($attr_data);
						}*/
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

		if($this->input->post('edit_type')=='training') {

			$id = $this->uri->segment(4);
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$start_date = $this->input->post('start_date');
			$end_date = $this->input->post('end_date');
			$description = $this->input->post('description');
			$st_date = strtotime($start_date);
			$ed_date = strtotime($end_date);
			$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
			if($this->input->post('perusahaan')==='') {
				$Return['error'] = $this->lang->line('error_field_perusahaan');
			} else if($this->input->post('type_training')==='') {
				$Return['error'] = $this->lang->line('umb_error_type_training');
			} else if($this->input->post('trainer')==='') {
				$Return['error'] = $this->lang->line('umb_error_trainer_field');
			} else if($this->input->post('start_date')==='') {
				$Return['error'] = $this->lang->line('umb_error_start_date');
			} else if($this->input->post('end_date')==='') {
				$Return['error'] = $this->lang->line('umb_error_end_date');
			} else if($st_date > $ed_date) {
				$Return['error'] = $this->lang->line('umb_error_start_end_date');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			if(isset($_POST['karyawan_id'])) {
				$karyawan_ids = implode(',',$_POST['karyawan_id']);
				$karyawan_id = $karyawan_ids;
			} else {
				$karyawan_id = '';
			}
			$module_attributes = $this->Custom_fields_model->training_hrastral_module_attributes();
			$count_module_attributes = $this->Custom_fields_model->count_training_module_attributes();	
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
				'type_training_id' => $this->input->post('type_training'),
				'perusahaan_id' => $this->input->post('perusahaan'),
				'trainer_id' => $this->input->post('trainer'),
				'biaya_training' => $this->input->post('biaya_training'),
				'start_date' => $this->input->post('start_date'),
				'finish_date' => $this->input->post('end_date'),
				'karyawan_id' => $karyawan_id,
				'description' => $qt_description
			);
			$result = $this->Training_model->update_record($data,$id);		

			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_training_diperbarui');
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

	public function details() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->uri->segment(4);
		$result = $this->Training_model->read_informasi_training($id);
		if(is_null($result)){
			redirect('admin/training');
		}
		$type = $this->Training_model->read_informasi_type_training($result[0]->type_training_id);
		if(!is_null($type)){
			$itype = $type[0]->type;
		} else {
			$itype = '--';	
		}
		if($result[0]->trainer_option == 2){
			$trainer = $this->Trainers_model->read_informasi_trainer($result[0]->trainer_id);
			if(!is_null($trainer)){
				$nama_trainer = $trainer[0]->first_name.' '.$trainer[0]->last_name;
			} else {
				$nama_trainer = '--';	
			}
		} elseif($result[0]->trainer_option == 1){
			$trainer = $this->Umb_model->read_user_info($result[0]->trainer_id);
			if(!is_null($trainer)){
				$nama_trainer = $trainer[0]->first_name.' '.$trainer[0]->last_name;
			} else {
				$nama_trainer = '--';	
			}
		} else {
			$nama_trainer = '--';
		}
		$data = array(
			'title' => $this->Umb_model->site_title(),
			'training_id' => $result[0]->training_id,
			'perusahaan_id' => $result[0]->perusahaan_id,
			'type' => $itype,
			'nama_trainer' => $nama_trainer,
			'biaya_training' => $result[0]->biaya_training,
			'start_date' => $result[0]->start_date,
			'finish_date' => $result[0]->finish_date,
			'created_at' => $result[0]->created_at,
			'description' => $result[0]->description,
			'performance' => $result[0]->performance,
			'status_training' => $result[0]->status_training,
			'remarks' => $result[0]->remarks,
			'karyawan_id' => $result[0]->karyawan_id,
			'all_karyawans' => $this->Umb_model->all_karyawans(),
			'all_perusahaans' => $this->Umb_model->get_perusahaans()
		);
		$data['breadcrumbs'] = $this->lang->line('umb_details_training');
		$data['path_url'] = 'details_training';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('54',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/training/details_training", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}		  
	}

	public function update_status() {

		if($this->input->post('edit_type')=='update_status') {

			$id = $this->input->post('token_status');
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$data = array(
				'performance' => $this->input->post('performance'),
				'status_training' => $this->input->post('status'),
				'remarks' => $this->input->post('remarks')
			);

			$result = $this->Training_model->update_status($data,$id);		
			if($this->input->post('status') == 2){
				$system_settings = system_settings_info(1);	
				if($system_settings->online_payment_account == ''){
					$online_payment_account = 0;
				} else {
					$online_payment_account = $system_settings->online_payment_account;
				}
				$tr_info = $this->Training_model->read_informasi_training($id);
				$ivdata = array(
					'jumlah' => $tr_info[0]->biaya_training,
					'account_id' => $online_payment_account,
					'type_transaksi' => 'biaya',
					'dr_cr' => 'cr',
					'tanggal_transaksi' => date('Y-m-d'),
					'pembayar_penerima_pembayaran_id' => $tr_info[0]->karyawan_id,
					'payment_method_id' => 3,
					'description' => 'Training Cost',
					'reference' => 'Training Cost',
					'invoice_id' => $id,
					'client_id' => $tr_info[0]->karyawan_id,
					'created_at' => date('Y-m-d H:i:s')
				);
				$this->Keuangan_model->add_transaksii($ivdata);
				$account_id = $this->Keuangan_model->read_informasi_bankcash($online_payment_account);
				$acc_saldo = $account_id[0]->saldo_account - $tr_info[0]->biaya_training;
				$data3 = array(
					'saldo_account' => $acc_saldo
				);
				$this->Keuangan_model->update_record_bankcash($data3,$online_payment_account);	
			}

			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_status_training_diperbarui');
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
		$result = $this->Training_model->delete_record($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('umb_sukses_training_dihapus');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
	}

	public function get_all_trainers() {

		$data['title'] = $this->Umb_model->site_title();
		$id = 1;		
		$data = array(
			'hrastral' => $id
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$data = $this->security->xss_clean($data);
			$this->load->view("admin/training/get_all_trainers", $data);
		} else {
			redirect('admin/');
		}

		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}

	public function get_internal_karyawan() {

		$data['title'] = $this->Umb_model->site_title();
		$id = $this->uri->segment(4);

		$data = array(
			'perusahaan_id' => $id
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/training/get_internal_karyawan", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}
}
