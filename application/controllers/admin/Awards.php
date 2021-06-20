<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Awards extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		
		$this->load->model("Awards_model");
		$this->load->model("Umb_model");
		$this->load->library('email');
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
		if($system[0]->module_awards!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('left_awards').' | '.$this->Umb_model->site_title();
		$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		$data['all_types_award'] = $this->Awards_model->all_types_award();
		$data['get_all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$data['breadcrumbs'] = $this->lang->line('left_awards');
		$data['path_url'] = 'awards';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('14',$role_resources_ids)) {
			$id = $this->uri->segment(4);
			$edata = array(
				'is_notify' => 0,
			);
			$this->Umb_model->update_notification_record($edata,$id,$session['user_id'],'awards');
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/awards/list_award", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}

	public function list_award(){

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/awards/list_award", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$role_resources_ids = $this->Umb_model->user_role_resource();
		$user_info = $this->Umb_model->read_user_info($session['user_id']);
		if($user_info[0]->user_role_id==1){
			$award = $this->Awards_model->get_awards();
		} else {
			if(in_array('232',$role_resources_ids)) {
				$award = $this->Awards_model->get_awards_perusahaan($user_info[0]->perusahaan_id);
			} else {
				$award = $this->Awards_model->get_awards_karyawan($session['user_id']);
			}
		}			
		$data = array();
		foreach($award->result() as $r) {
			$user = $this->Umb_model->read_user_info($r->karyawan_id);
			if(!is_null($user)){
				$full_name = $user[0]->first_name.' '.$user[0]->last_name;
			} else {
				$full_name = '--';	
			}
			$type_award = $this->Awards_model->read_informasi_type_award($r->type_award_id);
			if(!is_null($type_award)){
				$type_award = $type_award[0]->type_award;
			} else {
				$type_award = '--';	
			}

			$d = explode('-',$r->bulan_tahun_award);
			$get_month = date('F', mktime(0, 0, 0, $d[1], 10));
			$tanggal_award = $get_month.', '.$d[0];

			if($r->cash_price == '') {
				$currency = $this->Umb_model->currency_sign(0);
			} else {
				$currency = $this->Umb_model->currency_sign($r->cash_price);
			}		
			$perusahaan = $this->Umb_model->read_info_perusahaan($r->perusahaan_id);
			if(!is_null($perusahaan)){
				$prshn_nama = $perusahaan[0]->name;
			} else {
				$prshn_nama = '--';	
			}

			if(in_array('208',$role_resources_ids)) {
				$edit = '<span data-toggle="tooltip" data-state="primary" data-placement="top" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-award_id="'. $r->award_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('209',$role_resources_ids)) {
				$delete = '<span data-toggle="tooltip" data-state="danger" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->award_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}
			if(in_array('232',$role_resources_ids)) {
				$view = '<span data-toggle="tooltip" data-state="primary" data-placement="top" title="'.$this->lang->line('umb_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target="#modals-slide" data-award_id="'. $r->award_id . '"><span class="fa fa-eye"></span></button></span>';
			} else {
				$view = '';
			}
			$info_award = $type_award.'<br><small class="text-muted"><i>'.$r->description.'<i></i></i></small><br><small class="text-muted"><i>'.$this->lang->line('umb_cash_price').': '.$currency.'<i></i></i></small>';
			$combhr = $edit.$view.$delete;

			$data[] = array(
				$combhr,
				$info_award,
				$full_name,
				$prshn_nama,
				$r->gift_item,
				$tanggal_award
			);
		}
		$output = array(
			"draw" => $draw,
			"recordsTotal" => $award->num_rows(),
			"recordsFiltered" => $award->num_rows(),
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
			$this->load->view("admin/awards/get_karyawans", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}

	public function read() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('award_id');
		$result = $this->Awards_model->read_informasi_award($id);
		$data = array(
			'award_id' => $result[0]->award_id,
			'perusahaan_id' => $result[0]->perusahaan_id,
			'karyawan_id' => $result[0]->karyawan_id,
			'type_award_id' => $result[0]->type_award_id,
			'gift_item' => $result[0]->gift_item,
			'photo_award' => $result[0]->photo_award,
			'cash_price' => $result[0]->cash_price,
			'bulan_tahun_award' => $result[0]->bulan_tahun_award,
			'informasi_award' => $result[0]->informasi_award,
			'description' => $result[0]->description,
			'created_at' => $result[0]->created_at,
			'all_karyawans' => $this->Umb_model->all_karyawans(),
			'all_types_award' => $this->Awards_model->all_types_award(),
			'get_all_perusahaans' => $this->Umb_model->get_perusahaans()
		);
		if(!empty($session)){ 
			$this->load->view('admin/awards/dialog_award', $data);
		} else {
			redirect('admin/');
		}
	}

	public function add_award() {

		if($this->input->post('add_type')=='award') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$description = $this->input->post('description');
			$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
			if($this->input->post('perusahaan_id')==='') {
				$Return['error'] = $this->lang->line('error_field_perusahaan');
			} else if($this->input->post('karyawan_id')==='') {
				$Return['error'] = $this->lang->line('umb_error_karyawan_id');
			} else if($this->input->post('type_award_id')==='') {
				$Return['error'] = $this->lang->line('umb_award_error_type_award');
			} else if($this->input->post('tanggal_award')==='') {
				$Return['error'] = $this->lang->line('umb_award_error_tanggal_award');
			} else if($this->input->post('month_year')==='') {
				$Return['error'] = $this->lang->line('umb_award_error_month_award');
			}  else if($this->input->post('cash')!='' && $_FILES['picture_award']['size'] == 0) {
				$Return['error'] = $this->lang->line('umb_award_error_photo_award');
			} else {
				if(is_uploaded_file($_FILES['picture_award']['tmp_name'])) {
					$allowed =  array('png','jpg','jpeg','pdf','gif');
					$filename = $_FILES['picture_award']['name'];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);
					if(in_array($ext,$allowed)){
						$tmp_name = $_FILES["picture_award"]["tmp_name"];
						$profile = "uploads/award/";
						$set_img = base_url()."uploads/award/";
						$name = basename($_FILES["picture_award"]["name"]);
						$newfilename = 'award_'.round(microtime(true)).'.'.$ext;
						move_uploaded_file($tmp_name, $profile.$newfilename);
						$fname = $newfilename;			
					} else {
						$Return['error'] = $this->lang->line('umb_error_attatchment_type');
					}
				} else {
					$fname = '';
				}
			}	
			if($Return['error']!=''){
				$this->output($Return);
			}
			$module_attributes = $this->Custom_fields_model->awards_hrastral_module_attributes();
			$count_module_attributes = $this->Custom_fields_model->count_awards_module_attributes();	
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
			$system_settings = system_settings_info(1);	
			if($system_settings->online_payment_account == ''){
				$online_payment_account = 0;
			} else {
				$online_payment_account = $system_settings->online_payment_account;
			}		
			$data = array(
				'karyawan_id' => $this->input->post('karyawan_id'),
				'perusahaan_id' => $this->input->post('perusahaan_id'),
				'type_award_id' => $this->input->post('type_award_id'),
				'created_at' => $this->input->post('tanggal_award'),
				'photo_award' => $fname,
				'bulan_tahun_award' => $this->input->post('month_year'),
				'gift_item' => $this->input->post('gift'),
				'cash_price' => $this->input->post('cash'),
				'description' => $qt_description,
				'informasi_award' => $this->input->post('informasi_award'),		
			);
			$iresult = $this->Awards_model->add($data);
			if ($iresult) {
				$Return['result'] = $this->lang->line('umb_award_sukses_ditambahkan');
				$id = $iresult;
				$nticket_data = array(
					'module_name' => 'awards',
					'module_id' => $id,
					'karyawan_id' => $this->input->post('karyawan_id'),
					'is_notify' => '1',
					'created_at' => date('d-m-Y h:i:s'),
				);
				$this->Umb_model->add_notifications($nticket_data);
				$ivdata = array(
					'jumlah' => $this->input->post('cash'),
					'account_id' => $online_payment_account,
					'type_transaksi' => 'biaya',
					'dr_cr' => 'cr',
					'tanggal_transaksi' => date('Y-m-d'),
					'pembayar_penerima_pembayaran_id' => $this->input->post('karyawan_id'),
					'payment_method_id' => 3,
					'description' => 'Pembayaran award',
					'reference' => 'Pembayaran award',
					'invoice_id' => $id,
					'client_id' => $this->input->post('karyawan_id'),
					'created_at' => date('Y-m-d H:i:s')
				);
				$this->Keuangan_model->add_transaksii($ivdata);
				$account_id = $this->Keuangan_model->read_informasi_bankcash($online_payment_account);
				$acc_saldo = $account_id[0]->saldo_account - $this->input->post('cash');
				$data3 = array(
					'saldo_account' => $acc_saldo
				);
				$this->Keuangan_model->update_record_bankcash($data3,$online_payment_account);

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
				$setting = $this->Umb_model->read_setting_info(1);
				if($setting[0]->enable_email_notification == 'yes') {

					$this->email->set_mailtype("html");
					$cinfo = $this->Umb_model->read_info_setting_perusahaan(1);
					$template = $this->Umb_model->read_email_template(10);
					$user_info = $this->Umb_model->read_user_info($this->input->post('karyawan_id'));

					$full_name = $user_info[0]->first_name.' '.$user_info[0]->last_name;
					$type_award = $this->Awards_model->read_informasi_type_award($this->input->post('type_award_id'));
					$subject = $template[0]->subject.' - '.$cinfo[0]->nama_perusahaan;
					$logo = base_url().'uploads/logo/signin/'.$cinfo[0]->sign_in_logo;
					$d = explode('-',$this->input->post('month_year'));
					$get_month = date('F', mktime(0, 0, 0, $d[1], 10));
					$tanggal_award = $get_month.', '.$d[0];
					$message = '
					<div style="background:#f6f6f6;font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;margin:0;padding:0;padding: 20px;">
					<img src="'.$logo.'" title="'.$cinfo[0]->nama_perusahaan.'"><br>'.str_replace(array("{var site_name}","{var site_url}","{var nama_karyawan}","{var nama_award}","{var month_award}"),array($cinfo[0]->nama_perusahaan,site_url(),$full_name,$type_award[0]->type_award,$tanggal_award),htmlspecialchars_decode(stripslashes($template[0]->message))).'</div>';
					hrastral_mail($cinfo[0]->email,$cinfo[0]->nama_perusahaan,$user_info[0]->email,$subject,$message);
				}
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;

		}
	}

	public function update() {

		if($this->input->post('edit_type')=='award') {

			$id = $this->uri->segment(4);
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$description = $this->input->post('description');
			$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
			if($this->input->post('type_award_id')==='') {
				$Return['error'] = $this->lang->line('umb_award_error_type_award');
			} else if($this->input->post('tanggal_award')==='') {
				$Return['error'] = $this->lang->line('umb_award_error_tanggal_award');
			} else if($this->input->post('month_year')==='') {
				$Return['error'] = $this->lang->line('umb_award_error_month_award');
			}  		
			else if($_FILES['picture_award']['size'] == 0) {
				$module_attributes = $this->Custom_fields_model->awards_hrastral_module_attributes();
				$count_module_attributes = $this->Custom_fields_model->count_awards_module_attributes();
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
				$fname = '';
				$data = array(
					'type_award_id' => $this->input->post('type_award_id'),
					'created_at' => $this->input->post('tanggal_award'),
					'bulan_tahun_award' => $this->input->post('month_year'),
					'gift_item' => $this->input->post('gift'),
					'cash_price' => $this->input->post('cash'),
					'description' => $qt_description,
					'informasi_award' => $this->input->post('informasi_award'),		
				);
				$result = $this->Awards_model->update_record($data,$id);
			} else {
				$module_attributes = $this->Custom_fields_model->awards_hrastral_module_attributes();
				$count_module_attributes = $this->Custom_fields_model->count_awards_module_attributes();	
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
				if(is_uploaded_file($_FILES['picture_award']['tmp_name'])) {
					$allowed =  array('png','jpg','jpeg','gif');
					$filename = $_FILES['picture_award']['name'];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);
					if(in_array($ext,$allowed)){
						$tmp_name = $_FILES["picture_award"]["tmp_name"];
						$bill_copy = "uploads/award/";
						$lname = basename($_FILES["picture_award"]["name"]);
						$newfilename = 'award_'.round(microtime(true)).'.'.$ext;
						move_uploaded_file($tmp_name, $bill_copy.$newfilename);
						$fname = $newfilename;
						$data = array(
							'karyawan_id' => $this->input->post('karyawan_id'),
							'perusahaan_id' => $this->input->post('perusahaan_id'),
							'type_award_id' => $this->input->post('type_award_id'),
							'created_at' => $this->input->post('tanggal_award'),
							'photo_award' => $fname,
							'bulan_tahun_award' => $this->input->post('month_year'),
							'gift_item' => $this->input->post('gift'),
							'cash_price' => $this->input->post('cash'),
							'description' => $qt_description,
							'informasi_award' => $this->input->post('informasi_award'),		
						);
						$result = $this->Awards_model->update_record($data,$id);
					} else {
						$Return['error'] = $this->lang->line('umb_error_attatchment_type');
					}
				}
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_award_sukses_diperbarui');
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
								if(!empty($this->input->post($mattribute->attribute))){
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

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$result = $this->Awards_model->delete_record($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('umb_award_sukses_diperbarui');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
	}
}
