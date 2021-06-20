<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Files extends MY_Controller {


	public function output($Return=array()) {
		
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		
		exit(json_encode($Return));
	}
	
	public function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->database();
		$this->load->library('form_validation');
		$this->load->model('Umb_model');
		$this->load->model('Karyawans_model');
		$this->load->model('Department_model');
		$this->load->model('Files_model');
		$this->load->model("Perusahaan_model");
	}

	public function index() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$system = $this->Umb_model->read_setting_info(1);
		$data['title'] = $this->lang->line('umb_files_manager').' | '.$this->Umb_model->site_title();
		$data['all_departments'] = $this->Department_model->all_departments();
		$data['breadcrumbs'] = $this->lang->line('umb_files_manager');
		$data['path_url'] = 'files_manager';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		$data['get_types_perusahaan'] = $this->Perusahaan_model->get_types_perusahaan();
		$data['get_all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$data['all_types_document'] = $this->Karyawans_model->all_types_document();
		if($system[0]->module_files=='true'){
			if(in_array('47',$role_resources_ids)) {
				if(!empty($session)){ 
					$data['subview'] = $this->load->view("admin/file_manager/file_manager", $data, TRUE);
					$this->load->view('admin/layout/layout_main', $data); 
				} else {
					redirect('admin/');
				}
			} else {
				redirect('admin/dashboard/');
			}
		} else {
			redirect('admin/dashboard/');
		}
	}
	
	public function add_files() {

		if($this->input->post('type')=='file_info') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();

			$file_setting = $this->Umb_model->read_file_setting_info(1);
			$ifilesize = 1000000 * $file_setting[0]->maximum_file_size;
			$countfiles = count($_FILES['umb_file']['name']);
			//$files_img = $_FILES['umb_file']['name'];
			$fileNames = array_filter($_FILES['umb_file']['name']);
			//$files_img = implode(',',$this->input->post('umb_file'));
			if($this->input->post('department_id') === ''){
				$Return['error'] = $this->lang->line('umb_karyawan_error_department');
			} else if(empty($fileNames)){ 
				$Return['error'] = $this->lang->line('umb_upload_file_only_for_resume').' '.$file_setting[0]->allowed_extensions;
			} else {
			//if(is_uploaded_file($_FILES['umb_file']['tmp_name'])) {
				$allowed =  explode( ',',$file_setting[0]->allowed_extensions);
				//if(count($_FILES['umb_file']['name']) > 0){
				//if(filesize($_FILES['umb_file']['tmp_name']) > 0) {
				//if(in_array($ext,$allowed)){
				for($i=0;$i<$countfiles;$i++){
					if(filesize($_FILES['umb_file']['tmp_name'][$i]) > 0) {
						$filename = $_FILES['umb_file']['name'][$i];
						$ext = pathinfo($filename, PATHINFO_EXTENSION);
						$tmp_name = $_FILES['umb_file']["tmp_name"][$i];
						$profile = "uploads/files/";
						$set_img = base_url()."uploads/files/";
						$name = basename($_FILES['umb_file']["name"][$i]);
						$newfilename = 'file_'.round(microtime(true)).$i.'.'.$ext;
						move_uploaded_file($tmp_name, $profile.$newfilename);
						$fname = $newfilename;
						$fsize = $_FILES['umb_file']['size'][$i];
						$fext = $ext;
						$data = array(
							'department_id' => $this->input->post('department_id'),
							'user_id' => $this->input->post('user_id'),
							'file_name' => $fname,
							'file_size' => $fsize,
							'file_extension' => $fext,
							'created_at' => date('Y-m-d h:i:s')
						);

						$result = $this->Files_model->add($data);
					}
					else {
						$Return['error'] = 'File size is greater than .'.$file_setting[0]->maximum_file_size.'MB';
					}
				}
				/*} else {
					$Return['error'] = $this->lang->line('umb_error_msg');
				}*/
				if ($result == TRUE) {
					$Return['result'] = $this->lang->line('umb_sukses_file_uploaded');
				} else {
					$Return['error'] = $this->lang->line('umb_error_msg');
				}
				$this->output($Return);
				exit;
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
		}
	}

	public function list_files() {
		
		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/file_manager/file_manager", $data);
		} else {
			redirect('');
		}

		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		$id = $this->uri->segment(5);
		if($id=='0'){
			$file = $this->Files_model->get_files();
		} else {
			$file = $this->Files_model->files_department($id);
		}

		$data = array();

		foreach($file->result() as $r) {

			$department = $this->Department_model->read_informasi_department($r->department_id);
			if(!is_null($department)){
				$nama_department = $department[0]->nama_department;
			} else {
				$nama_department = '--';	
			}
			$fsize = $this->Files_model->format_size_units($r->file_size);

			$created_at = $this->Umb_model->set_date_time_format($r->created_at);
			if($r->file_name!='' && $r->file_name!='no file') {
				$functions = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_download').'"><a href="'.site_url().'admin/download?type=files&filename='.$r->file_name.'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="oi oi-cloud-download"></span></button></a></span>';
			} else {
				$functions ='';
			}

			$data[] = array(
				$functions.'<span data-toggle="tooltip" data-state="primary" data-placement="top" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".modal_payroll_template" data-file_id="'. $r->file_id . '" data-field_type="file_manager"><span class="fas fa-pencil-alt"></span></button></span><span data-toggle="tooltip" data-state="danger" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger btn-sm m-b-0-0 waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->file_id . '" data-token_type="document"><span class="fas fa-trash-restore"></span></button></span>',
				$r->file_name,
				$nama_department,
				$fsize,
				$r->file_extension,
				$created_at
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $file->num_rows(),
			"recordsFiltered" => $file->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}
	public function list_document()
	{

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/file_manager/file_manager", $data);
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

			if(in_array('247',$role_resources_ids)) { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-info waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-document_id="'. $r->document_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('248',$role_resources_ids)) { // delete
				$delete = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete-file" data-toggle="modal" data-target=".delete-modal-file" data-document-id="'. $r->document_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}
			if(in_array('249',$role_resources_ids)) { //view
				$view = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-success waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-document_id="'. $r->document_id . '"><span class="fa fa-eye"></span></button></span>';
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

		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('file_id');
		$result = $this->Files_model->read_informasi_file($id);
		$data = array(
			'file_id' => $result[0]->file_id,
			'department_id' => $result[0]->department_id,
			'file_name' => $result[0]->file_name
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/file_manager/dialog_file', $data);
		} else {
			redirect('');
		}
	}

	public function read_document() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('document_id');
		// $data['all_negaraa'] = $this->Umb_model->get_negaraa();
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
		$this->load->view('admin/file_manager/dialog_document_resmi', $data);
	}
	
	public function update() {

		if($this->input->post('edit_type')=='file') {
			
			$id = $this->input->post('file_id');


			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			

			if($this->input->post('file_name')==='') {
				$Return['error'] = $this->lang->line('umb_error_file_tugas_name');
			}

			if($Return['error']!=''){
				$this->output($Return);
			}

			$fname = $this->input->post('file_name').'.'.$this->input->post('ext_name');
			$directory = "uploads/files/";
			
			rename($directory.$this->input->post('oldfname'), $directory.$fname);

			$data = array(
				'file_name' => $fname
			);

			$result = $this->Files_model->update_record($data,$id);		

			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_file_name_diperbarui');
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
	
	public function setting_info() {

		if($this->input->post('type')=='setting_info') {
			
			$id = 1;

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
			if($this->input->post('maximum_file_size')==='') {
				$Return['error'] = $this->lang->line('umb_error_max_file_size_required');
			} else if($this->input->post('allowed_extensions')==='') {
				$Return['error'] = $this->lang->line('umb_error_file_extension_required');
			}

			if($Return['error']!=''){
				$this->output($Return);
			}
			$allowed_extensions = str_replace(array('php', '', 'js', '','html', ''), '',$this->input->post('allowed_extensions'));

			$data = array(
				'maximum_file_size' => $this->input->post('maximum_file_size'),
				'allowed_extensions' => $allowed_extensions,
				'is_enable_all_files' => $this->input->post('view_all_files'),
				'updated_at' => date('Y-m-d h:i:s')
			);

			$result = $this->Files_model->update_record_file($data,$id);		

			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_file_settings_diperbarui');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function delete() {
		
		if($this->input->post('is_ajax')=='2') {
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Files_model->delete_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_sukses_file_dihapus');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
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
?>