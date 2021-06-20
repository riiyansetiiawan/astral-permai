<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once('Backup_hrastral.php');

class Settings extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		
		$this->load->model("Karyawan_exit_model");
		$this->load->model("Umb_model");
		$this->load->model("Karyawans_model");
		$this->load->model("Keuangan_model");
		$this->load->helper('string');
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
		$data['title'] = $this->lang->line('left_settings').' | '.$this->Umb_model->site_title();
		$setting = $this->Umb_model->read_setting_info(1);
		$info_perusahaan = $this->Umb_model->read_info_setting_perusahaan(1);
		$email_config = $this->Umb_model->read_email_config_info(1);
		$theme_info = $this->Umb_model->read_theme_info(1);
		$data = array(
			'title' => $this->lang->line('left_settings').' | '.$this->Umb_model->site_title(),
			'info_perusahaan_id' => $info_perusahaan[0]->info_perusahaan_id,
			'logo' => $info_perusahaan[0]->logo,
			'logo_second' => $info_perusahaan[0]->logo_second,
			'favicon' => $info_perusahaan[0]->favicon,
			'sign_in_logo' => $info_perusahaan[0]->sign_in_logo,
			'logo_pekerjaan' => $setting[0]->logo_pekerjaan,
			'logo_payroll' => $setting[0]->logo_payroll,
			'is_generate_password_slipgaji' => $setting[0]->is_generate_password_slipgaji,
			'format_password_slipgaji' => $setting[0]->format_password_slipgaji,
			'nama_perusahaan' => $info_perusahaan[0]->nama_perusahaan,
			'kontak_person' => $info_perusahaan[0]->kontak_person,
			'website_url' => $info_perusahaan[0]->website_url,
			'starting_year' => $info_perusahaan[0]->starting_year,
			'email_perusahaan' => $info_perusahaan[0]->email_perusahaan,
			'kontak_perusahaan' => $info_perusahaan[0]->kontak_perusahaan,
			'email' => $info_perusahaan[0]->email,
			'phone' => $info_perusahaan[0]->phone,
			'alamat_1' => $info_perusahaan[0]->alamat_1,
			'alamat_2' => $info_perusahaan[0]->alamat_2,
			'kota' => $info_perusahaan[0]->kota,
			'provinsi' => $info_perusahaan[0]->provinsi,
			'kode_pos' => $info_perusahaan[0]->kode_pos,
			'negara' => $info_perusahaan[0]->negara,
			'updated_at' => $info_perusahaan[0]->updated_at,
			'application_name' => $setting[0]->application_name,
			'default_currency_symbol' => $setting[0]->default_currency_symbol,
			'show_currency' => $setting[0]->show_currency,
			'currency_position' => $setting[0]->currency_position,
			'date_format_astral' => $setting[0]->date_format_astral,
			'animation_effect' => $setting[0]->animation_effect,
			'animation_effect_topmenu' => $setting[0]->animation_effect_topmenu,
			'animation_effect_modal' => $setting[0]->animation_effect_modal,
			'notification_position' => $setting[0]->notification_position,
			'notification_close_btn' => $setting[0]->notification_close_btn,
			'notification_bar' => $setting[0]->notification_bar,
			'karyawan_manage_own_bank_account' => $setting[0]->karyawan_manage_own_bank_account,
			'karyawan_manage_own_kontak' => $setting[0]->karyawan_manage_own_kontak,
			'karyawan_manage_own_profile' => $setting[0]->karyawan_manage_own_profile,
			'karyawan_manage_own_qualification' => $setting[0]->karyawan_manage_own_qualification,
			'karyawan_manage_own_pengalaman_kerja' => $setting[0]->karyawan_manage_own_pengalaman_kerja,
			'karyawan_manage_own_document' => $setting[0]->karyawan_manage_own_document,
			'karyawan_manage_own_picture' => $setting[0]->karyawan_manage_own_picture,
			'karyawan_manage_own_social' => $setting[0]->karyawan_manage_own_social,
			'enable_kehadiran' => $setting[0]->enable_kehadiran,
			'enable_clock_in_btn' => $setting[0]->enable_clock_in_btn,
			'enable_email_notification' => $setting[0]->enable_email_notification,
			'enable_pekerjaan_application_kandidats' => $setting[0]->enable_pekerjaan_application_kandidats,
			'pekerjaan_application_format' => $setting[0]->pekerjaan_application_format,
			'technical_competencies' => $setting[0]->technical_competencies,
			'organizational_competencies' => $setting[0]->organizational_competencies,
			'footer_text' => $setting[0]->footer_text,
			'email_type' => $email_config[0]->email_type,
			'smtp_host' => $email_config[0]->smtp_host,
			'smtp_username' => $email_config[0]->smtp_username,
			'smtp_password' => $email_config[0]->smtp_password,
			'smtp_port' => $email_config[0]->smtp_port,
			'smtp_secure' => $email_config[0]->smtp_secure,
			'enable_page_rendered' => $setting[0]->enable_page_rendered,
			'enable_current_year' => $setting[0]->enable_current_year,
			'login_karyawan_id' => $setting[0]->login_karyawan_id,
			'enable_auth_background' => $setting[0]->enable_auth_background,
			'system_timezone' => $setting[0]->system_timezone,
			'system_ip_address' => $setting[0]->system_ip_address,
			'google_maps_api_key' => $setting[0]->google_maps_api_key,
			'is_ssl_available' => $setting[0]->is_ssl_available,
			'is_half_monthly' => $setting[0]->is_half_monthly,
			'potong_setengah_bulan' => $setting[0]->potong_setengah_bulan,
			'default_language' => $setting[0]->default_language,
			'show_projects' => $setting[0]->show_projects,
			'show_tugass' => $setting[0]->show_tugass,
			'statutory_fixed' => $setting[0]->statutory_fixed,
			'estimate_terms_condition' => $setting[0]->estimate_terms_condition,
			'invoice_terms_condition' => $setting[0]->invoice_terms_condition,
			'statistics_cards' => $theme_info[0]->statistics_cards,
			'dashboard_option' => $theme_info[0]->dashboard_option,
			'dashboard_calendar' => $theme_info[0]->dashboard_calendar,
			'login_page_options' => $theme_info[0]->login_page_options,
			'export_orgchart' => $theme_info[0]->export_orgchart,
			'export_file_title' => $theme_info[0]->export_file_title,
			'org_chart_layout' => $theme_info[0]->org_chart_layout,
			'org_chart_zoom' => $theme_info[0]->org_chart_zoom,
			'org_chart_pan' => $theme_info[0]->org_chart_pan,
			'text_page_login' => $theme_info[0]->text_page_login,
			'enable_asuransi' => $setting[0]->enable_asuransi,
			'logo' => $info_perusahaan[0]->logo,
			'logo_second' => $info_perusahaan[0]->logo_second,
			'favicon' => $info_perusahaan[0]->favicon,
			'sign_in_logo' => $info_perusahaan[0]->sign_in_logo,
			'logo_pekerjaan' => $setting[0]->logo_pekerjaan,
			'logo_payroll' => $setting[0]->logo_payroll,
			'all_negaraa' => $this->Umb_model->get_negaraa(),
			'module_recruitment' => $setting[0]->module_recruitment,
			'module_perjalanan' => $setting[0]->module_perjalanan,
			'module_performance' => $setting[0]->module_performance,
			'module_files' => $setting[0]->module_files,
			'module_awards' => $setting[0]->module_awards,
			'module_training' => $setting[0]->module_training,
			'module_inquiry' => $setting[0]->module_inquiry,
			'module_language' => $setting[0]->module_language,
			'module_orgchart' => $setting[0]->module_orgchart,
			'module_accounting' => $setting[0]->module_accounting,
			'module_events' => $setting[0]->module_events,
			'module_tujuan_tracking' => $setting[0]->module_tujuan_tracking,
			'module_assets' => $setting[0]->module_assets,
			'module_payroll' => $setting[0]->module_payroll,
			'module_chat_box' => $setting[0]->module_chat_box,
			'is_active_sub_departments' => $setting[0]->is_active_sub_departments,
			'paypal_email' => $setting[0]->paypal_email,
			'paypal_sandbox' => $setting[0]->paypal_sandbox,
			'paypal_active' => $setting[0]->paypal_active,
			'stripe_secret_key' => $setting[0]->stripe_secret_key,
			'stripe_publishable_key' => $setting[0]->stripe_publishable_key,
			'stripe_active' => $setting[0]->stripe_active,
			'online_payment_account' => $setting[0]->online_payment_account,
			'performance_option' => $setting[0]->performance_option,
			'all_bank_cash' => $this->Keuangan_model->all_bank_cash(),
			'all_perusahaans' => $this->Umb_model->get_perusahaans()
		);
$data['breadcrumbs'] = $this->lang->line('left_settings');
$data['path_url'] = 'settings';
$role_resources_ids = $this->Umb_model->user_role_resource();
if(in_array('60',$role_resources_ids)) {
	if(!empty($session)){ 
		$data['subview'] = $this->load->view("admin/settings/settings", $data, TRUE);
		$this->load->view('admin/layout/layout_main', $data); 
	} else {
		redirect('admin/');
	}
} else {
	redirect('admin/dashboard');
}
}

public function constants() {

	$session = $this->session->userdata('username');
	if(empty($session)){ 
		redirect('admin/');
	}
	$data['title'] = $this->lang->line('left_constants').' | '.$this->Umb_model->site_title();
	//$setting = $this->Umb_model->read_setting_info(1);
	$info_perusahaan = $this->Umb_model->read_info_setting_perusahaan(1);
	$data['breadcrumbs'] = $this->lang->line('left_constants');
	$data['all_perusahaans'] = $this->Umb_model->get_perusahaans();
	$data['path_url'] = 'constants';
	$role_resources_ids = $this->Umb_model->user_role_resource();
	if(in_array('61',$role_resources_ids)) {
		if(!empty($session)){ 
			$data['subview'] = $this->load->view("admin/settings/constants", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
		} else {
			redirect('admin/');
		}
	} else {
		redirect('admin/dashboard');
	}
}

public function payment_gateway() {	

	$session = $this->session->userdata('username');
	if(empty($session)){ 
		redirect('admin/');
	}
	$data['title'] = $this->lang->line('umb_acc_payment_gateway').' | '.$this->Umb_model->site_title();
	$setting = $this->Umb_model->read_setting_info(1);
	$data = array(
		'title' => $this->lang->line('umb_acc_payment_gateway').' | '.$this->Umb_model->site_title(),
		'paypal_email' => $setting[0]->paypal_email,
		'paypal_sandbox' => $setting[0]->paypal_sandbox,
		'paypal_active' => $setting[0]->paypal_active,
		'stripe_secret_key' => $setting[0]->stripe_secret_key,
		'stripe_publishable_key' => $setting[0]->stripe_publishable_key,
		'stripe_active' => $setting[0]->stripe_active,
		'online_payment_account' => $setting[0]->online_payment_account,
		'all_bank_cash' => $this->Keuangan_model->all_bank_cash()
	);
	$data['breadcrumbs'] = $this->lang->line('umb_acc_payment_gateway');
	$data['path_url'] = 'umb_payment_gateway';
	$role_resources_ids = $this->Umb_model->user_role_resource();
	if(in_array('118',$role_resources_ids)) {
		if(!empty($session)){ 
			$data['subview'] = $this->load->view("admin/settings/payment_gateway_settings", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
		} else {
			redirect('admin/');
		}
	} else {
		redirect('admin/dashboard');
	}
}

public function database_backup() {

	$session = $this->session->userdata('username');
	if(empty($session)){ 
		redirect('admin/');
	}
	$data['title'] = $this->lang->line('left_db_backup').' | '.$this->Umb_model->site_title();
	$setting = $this->Umb_model->read_setting_info(1);
	$info_perusahaan = $this->Umb_model->read_info_setting_perusahaan(1);
	$data['breadcrumbs'] = $this->lang->line('left_db_backup');
	$data['path_url'] = 'database_backup';
	$role_resources_ids = $this->Umb_model->user_role_resource();
	if(in_array('62',$role_resources_ids)) {
		if(!empty($session)){ 
			$data['subview'] = $this->load->view("admin/settings/database_backup", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
		} else {
			redirect('admin/');
		}
	} else {
		redirect('admin/dashboard');
	}
}

public function modules() {

	$session = $this->session->userdata('username');
	if(empty($session)){ 
		redirect('admin/');
	}
	$setting = $this->Umb_model->read_setting_info(1);
	$data['breadcrumbs'] = $this->lang->line('umb_modules');
	$data['path_url'] = 'modules_setup';
	$data = array(
		'title' => $this->lang->line('umb_modules').' | '.$this->Umb_model->site_title(),
		'path_url' => 'modules_setup',
		'breadcrumbs' => $this->lang->line('umb_modules'),
		'module_recruitment' => $setting[0]->module_recruitment,
		'module_perjalanan' => $setting[0]->module_perjalanan,
		'module_performance' => $setting[0]->module_performance,
		'module_files' => $setting[0]->module_files,
		'module_awards' => $setting[0]->module_awards,
		'module_training' => $setting[0]->module_training,
		'module_inquiry' => $setting[0]->module_inquiry,
		'module_language' => $setting[0]->module_language,
		'module_orgchart' => $setting[0]->module_orgchart,
		'module_accounting' => $setting[0]->module_accounting,
		'module_events' => $setting[0]->module_events,
		'module_tujuan_tracking' => $setting[0]->module_tujuan_tracking,
		'module_assets' => $setting[0]->module_assets,
		'module_payroll' => $setting[0]->module_payroll,
		'module_chat_box' => $setting[0]->module_chat_box,
		'is_active_sub_departments' => $setting[0]->is_active_sub_departments,
	);
	$role_resources_ids = $this->Umb_model->user_role_resource();
	if(in_array('93',$role_resources_ids)) {	
		if(!empty($session)){ 
			$data['subview'] = $this->load->view("admin/settings/modules", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
		} else {
			redirect('admin/');
		}
	} else {
		redirect('admin/dashboard');
	}
}

public function create_database_backup() {

	$data['title'] = $this->Umb_model->site_title();
	if($this->input->post('type')==='backup') {
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		$db = array('default' => array());
		require 'application/config/database.php';
		$hostname = $db['default']['hostname'];
		$username = $db['default']['username'];
		$password = $db['default']['password'];
		$database = $db['default']['database'];
		$dir  = 'uploads/dbbackup/';
		$name = 'hrastral_backup_'.date('d-m-Y').'_'.time();

		$newImport = new Backup_hrastral($hostname,$database,$username,$password);
		$newImport->backup();					

		$fname = $name.'.sql';

		$data = array(
			'backup_file' => $fname,
			'created_at' => date('d-m-Y H:i:s')
		);

		$result = $this->Umb_model->add_backup($data);	

		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('umb_database_backup_generated');

		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
		exit;
	}
}

public function restore_database_backup() {
	$data['title'] = $this->Umb_model->site_title();
	if($this->input->post('type')==='restore') {


		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();

		if($this->input->post('restore_id')==='') {
			$Return['error'] = $this->lang->line('umb_database_backup_field_error');
		}
		if($Return['error']!=''){
			$this->output($Return);
		}
		$dir  = 'uploads/dbbackup/';
		$restore = $this->Umb_model->read_db_backup($this->input->post('restore_id'));
		$filename = $dir.$restore[0]->backup_file;
		$db = array('default' => array());
		require 'application/config/database.php';
		$hostname = $db['default']['hostname'];
		$username = $db['default']['username'];
		$password = $db['default']['password'];
		$database = $db['default']['database'];
		$newImport = new Backup_hrastral($hostname,$database,$username,$password);
		$msg = $newImport->restore($filename);
		if($msg == 1){
			$Return['result'] = $this->lang->line('umb_databse_restored_success');
			$this->session->set_flashdata('restore_msg',$this->lang->line('umb_databse_restored_success'));
		}
		$this->output($Return);
		exit;
	}
}

public function get_database_backup() {

	$data['title'] = $this->Umb_model->site_title();
	$id = $this->uri->segment(4);

	$data = array(
		'restore_id' => $id
	);
	$session = $this->session->userdata('username');
	if(!empty($session)){ 
		$this->load->view("admin/settings/get_database_backup", $data);
	} else {
		redirect('admin/');
	}

	$draw = intval($this->input->get("draw"));
	$start = intval($this->input->get("start"));
	$length = intval($this->input->get("length"));
}

public function delete_db_backup() {

	if($this->input->post('type')==='delete_old_backup') {

		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$result = $this->Umb_model->delete_record_all_backup();
		$baseurl = base_url();
		$files = glob('uploads/dbbackup/*'); 
		foreach($files as $file){
			if(is_file($file))
				unlink($file);
		}
		
		$Return['result'] = $this->lang->line('umb_sukses_database_old_backup_dihapus');
		$this->output($Return);
		exit;
	}
}

public function list_database_backup() {

	$data['title'] = $this->Umb_model->site_title();
	$session = $this->session->userdata('username');
	if(!empty($session)){ 
		$this->load->view("admin/settings/settings", $data);
	} else {
		redirect('admin/');
	}
	
	$draw = intval($this->input->get("draw"));
	$start = intval($this->input->get("start"));
	$length = intval($this->input->get("length"));
	
	$db_backup = $this->Umb_model->all_db_backup();

	$data = array();

	foreach($db_backup->result() as $r) {
		
		$created_at = $this->Umb_model->set_date_format($r->created_at);
		
		$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_download').'"><a href="'.site_url().'admin/download?type=dbbackup&filename='.$r->backup_file.'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="oi oi-cloud-download"></span></button></a></span> <span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light deletedb" data-toggle="modal" data-target=".delete-modal-file" data-record-id="'. $r->backup_id . '"><span class="fas fa-trash-restore"></span></button></span>',
			$r->backup_file,
			$created_at
		);
	}
	$output = array(
		"draw" => $draw,
		"recordsTotal" => $db_backup->num_rows(),
		"recordsFiltered" => $db_backup->num_rows(),
		"data" => $data
	);
	
	echo json_encode($output);
	exit();
}

public function email_template() {
	
	$session = $this->session->userdata('username');
	if(empty($session)){ 
		redirect('admin/');
	}
	$data['title'] = $this->lang->line('left_email_templates').' | '.$this->Umb_model->site_title();
	$data['breadcrumbs'] = $this->lang->line('left_email_templates');
	$data['path_url'] = 'email_template';
	$role_resources_ids = $this->Umb_model->user_role_resource();
	if(in_array('63',$role_resources_ids)) {
		if(!empty($session)){ 
			$data['subview'] = $this->load->view("admin/settings/email_template", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
		} else {
			redirect('admin/');
		}
	} else {
		redirect('admin/dashboard');
	}		  
} 

public function list_email_template(){

	$data['title'] = $this->Umb_model->site_title();
	$session = $this->session->userdata('username');
	if(!empty($session)){ 
		$this->load->view("admin/settings/settings", $data);
	} else {
		redirect('admin/');
	}
	$draw = intval($this->input->get("draw"));
	$start = intval($this->input->get("start"));
	$length = intval($this->input->get("length"));
	$email_template = $this->Umb_model->get_email_templates();
	$data = array();
	foreach($email_template->result() as $r) {
		if($r->status==1){
			$status = '<span class="badge badge-pill badge-success">'.$this->lang->line('umb_karyawans_active').'</span>';
		} else {
			$status = '<span class="badge badge-pill badge-danger">'.$this->lang->line('umb_karyawans_inactive').'</span>';
		}
		$data[] = array('<span data-toggle="tooltip" data-state="primary" data-placement="top" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target="#modals-slide"  data-template_id="'. $r->template_id . '"><span class="fas fa-pencil-alt"></span></button></span>',
			$r->name,
			$r->subject,
			$status
		);
	}
	$output = array(
		"draw" => $draw,
		"recordsTotal" => $email_template->num_rows(),
		"recordsFiltered" => $email_template->num_rows(),
		"data" => $data
	);
	echo json_encode($output);
	exit();
} 

public function list_security_level() {

	$data['title'] = $this->Umb_model->site_title();
	$session = $this->session->userdata('username');
	if(!empty($session)){ 
		$this->load->view("admin/settings/settings", $data);
	} else {
		redirect('admin/');
	}
	
	$draw = intval($this->input->get("draw"));
	$start = intval($this->input->get("start"));
	$length = intval($this->input->get("length"));
	$constant = $this->Umb_model->get_type_security_level();
	$data = array();
	foreach($constant->result() as $r) {
		$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit_setting_datail" data-field_id="'. $r->type_id . '" data-field_type="security_level"><span class="fas fa-pencil-alt"></span></button></span> <span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->type_id . '" data-token_type="security_level"><span class="fas fa-trash-restore"></span></button></span>',
			$r->name
		);
	}
	$output = array(
		"draw" => $draw,
		"recordsTotal" => $constant->num_rows(),
		"recordsFiltered" => $constant->num_rows(),
		"data" => $data
	);
	
	echo json_encode($output);
	exit();
}

public function read_tempalte() {

	$data['title'] = $this->Umb_model->site_title();
	$id = $this->input->get('template_id');
	$result = $this->Umb_model->read_info_email_template($id);
	$data = array(
		'template_id' => $result[0]->template_id,
		'template_code' => $result[0]->template_code,
		'name' => $result[0]->name,
		'subject' => $result[0]->subject,
		'message' => $result[0]->message,
		'status' => $result[0]->status
	);
	$session = $this->session->userdata('username');
	if(!empty($session)){ 
		$this->load->view('admin/settings/dialog_email_template', $data);
	} else {
		redirect('admin/');
	}
} 

public function password_read() {
	$data['title'] = $this->Umb_model->site_title();
	$id = $this->input->get('user_id');
	$result = $this->Umb_model->read_user_info($id);
	$data = array(
		'user_id' => $result[0]->user_id,
	);
	$session = $this->session->userdata('username');
	if(!empty($session)){ 
		$this->load->view('admin/settings/dialog_constants', $data);
	} else {
		redirect('admin/');
	}
} 

public function read_kebijakan()
{
	$data['title'] = $this->Umb_model->site_title();
	$session = $this->session->userdata('username');
	if(!empty($session)){ 
		$this->load->view('admin/settings/dialog_constants', $data);
	} else {
		redirect('admin/');
	}
}

public function update_template() {
	
	if($this->input->post('edit_type')=='update_template') {
		
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		if($this->input->post('name')==='') {
			$Return['error'] = $this->lang->line('umb_error_field_nama');
		} else if($this->input->post('subject')==='') {
			$Return['error'] = $this->lang->line('umb_karyawan_error_subject');
		} else if($this->input->post('status')==='') {
			$Return['error'] = $this->lang->line('umb_error_template_status');
		} else if($this->input->post('message')==='') {
			$Return['error'] = $this->lang->line('umb_project_message');
		}
		
		if($Return['error']!=''){
			$this->output($Return);
		}
		$message = $this->input->post('message');
		//$new_message = mysqli_real_escape_string($message);
		$new_message = $message;
		$data = array(
			'name' => $this->input->post('name'),
			'subject' => $this->input->post('subject'),
			'status' => $this->input->post('status'),
			'message' => $new_message
		);
		$result = $this->Umb_model->delete_record_email_template($data,$id);		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('umb_sukses_email_template_diperbarui');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
		exit;
	}
}


public function hr_top_menu() {
	
	if($this->input->post('type')=='hrtop_menuinfo') {
		
		
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		//$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$id = 1;
		$hr_top_menu = implode(',',$this->input->post('hr_top_menu'));
		$data = array(
			'hr_top_menu' => $hr_top_menu,
		);
		$result = $this->Umb_model->update_record_info_setting($data,$id);	
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('umb_top_menu_diperbarui_success');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
		exit;
	}
}

public function info_perusahaan() {

	if($this->input->post('type')=='info_perusahaan') {

		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$id = 1;

		if($this->input->post('nama_perusahaan')==='') {
			$Return['error'] = $this->lang->line('umb_karyawan_error_nama_perusahaan');
		} else if($this->input->post('website')==='') {
			$Return['error'] = $this->lang->line('umb_error_fiel_website');
		} else if($this->input->post('kontak_person')==='') {
			$Return['error'] = $this->lang->line('umb_error_kontak_person');
		} else if($this->input->post('email')==='') {
			$Return['error'] = $this->lang->line('umb_error_cemail_field');
		} else if (!filter_var($this->input->post('email'), FILTER_VALIDATE_EMAIL)) {
			$Return['error'] = $this->lang->line('umb_karyawan_error_invalid_email');
		} else if($this->input->post('phone')==='') {
			$Return['error'] = $this->lang->line('umb_error_phone_field');
		}

		if($Return['error']!=''){
			$this->output($Return);
		}

		$data = array(
			'nama_perusahaan' => $this->input->post('nama_perusahaan'),
			'kontak_person' => $this->input->post('kontak_person'),
			'website_url' => $this->input->post('website'),
			'starting_year' => $this->input->post('starting_year'),
			'email_perusahaan' => $this->input->post('email_perusahaan'),
			'kontak_perusahaan' => $this->input->post('kontak_perusahaan'),
			'email' => $this->input->post('email'),
			'phone' => $this->input->post('phone'),
			'alamat_1' => $this->input->post('alamat_1'),
			'alamat_2' => $this->input->post('alamat_2'),
			'kota' => $this->input->post('kota'),
			'provinsi' => $this->input->post('provinsi'),
			'kode_pos' => $this->input->post('kode_pos'),
			'negara' => $this->input->post('negara'),
		);

		$result = $this->Umb_model->update_record_info_perusahaan($data,$id);		

		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('umb_sukses_info_perusahaan_diperbarui');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
		exit;
	}
}


public function info_logo() {

	if($this->input->post('type')=='info_logo') {

		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$id = 1;
		if($_FILES['p_file']['size'] == 0) {
			$Return['error'] = $this->lang->line('umb_error_pilih_logo_pertama');
		} 
		if($Return['error']!=''){
			$this->output($Return);
		}
		if(is_uploaded_file($_FILES['p_file']['tmp_name'])) {

			$allowed =  array('png','jpg','jpeg','pdf','gif');
			$filename = $_FILES['p_file']['name'];
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			if(in_array($ext,$allowed)){
				$tmp_name = $_FILES["p_file"]["tmp_name"];
				$profile = "uploads/logo/";
				$set_img = base_url()."uploads/logo/";
				$name = basename($_FILES["p_file"]["name"]);
				$newfilename = 'logo_'.round(microtime(true)).'.'.$ext;
				move_uploaded_file($tmp_name, $profile.$newfilename);
				$fname = $newfilename;			

			} else {
				$Return['error'] = $this->lang->line('umb_error_attachment_logo_pertama');
			}
		}	
		if($Return['error']!=''){
			$this->output($Return);
		}
		$data = array(
			'logo' => $fname,
		);
		$result = $this->Umb_model->update_record_info_perusahaan($data,$id);	
		if ($result == TRUE) {
			$Return['img'] = $set_img.$fname;
			$Return['result'] = $this->lang->line('umb_sukses_system_logo_diperbarui');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
		exit;

	}
}

public function logo_favicon() {

	if($this->input->post('type')=='logo_favicon') {

		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$id = 1;

		if($_FILES['favicon']['size'] == 0) {
			$Return['error'] = $this->lang->line('umb_error_pilih_favicon');
		}
		if($Return['error']!=''){
			$this->output($Return);
		}
		if(is_uploaded_file($_FILES['favicon']['tmp_name'])) {

			$allowed3 =  array('png','jpg','gif','ico');
			$filename3 = $_FILES['favicon']['name'];
			$ext3 = pathinfo($filename3, PATHINFO_EXTENSION);

			if(in_array($ext3,$allowed3)){
				$tmp_name3 = $_FILES["favicon"]["tmp_name"];
				$profile3 = "uploads/logo/favicon/";
				$set_img3 = base_url()."uploads/logo/favicon/";
				$name = basename($_FILES["favicon"]["name"]);
				$newfilename3 = 'favicon_'.round(microtime(true)).'.'.$ext3;
				move_uploaded_file($tmp_name3, $profile3.$newfilename3);
				$fname3 = $newfilename3;			

			} else {
				$Return['error'] = $this->lang->line('umb_error_attachment_logo_favicon');
			}
		}


		$data = array(
			'favicon' => $fname3
		);
		$result = $this->Umb_model->update_record_info_perusahaan($data,$id);	
		if ($result == TRUE) {
			$Return['img3'] = $set_img3.$fname3;
			$Return['result'] = $this->lang->line('umb_sukses_system_logo_diperbarui');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
		exit;

	}
}

public function profile_background() {

	if($this->input->post('type')=='profile_background') {

		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->input->post('user_id');

		if($_FILES['p_file']['size'] == 0) {
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$Return['error'] = $this->lang->line('umb_error_select_profile_cover');
		} else {
			if(is_uploaded_file($_FILES['p_file']['tmp_name'])) {
				$allowed =  array('png','jpg','jpeg','pdf','gif');
				$filename = $_FILES['p_file']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				if(in_array($ext,$allowed)){
					$tmp_name = $_FILES["p_file"]["tmp_name"];
					$profile = "uploads/profile/background/";
					$set_img = base_url()."uploads/profile/background/";
					$name = basename($_FILES["p_file"]["name"]);
					$newfilename = 'profile_background_'.round(microtime(true)).'.'.$ext;
					move_uploaded_file($tmp_name, $profile.$newfilename);
					$fname = $newfilename;			

					$data = array(
						'profile_background' => $fname
					);
					$result = $this->Karyawans_model->basic_info($data,$id);	
					if ($result == TRUE) {
						$Return['profile_background'] = $set_img.$fname;
						$Return['result'] = $this->lang->line('umb_sukses_profile_background_diperbarui');
					} else {
						$Return['error'] = $this->lang->line('umb_error_msg');
					}
					$Return['csrf_hash'] = $this->security->get_csrf_hash();
					$this->output($Return);
					exit;	
				} else {
					$Return['csrf_hash'] = $this->security->get_csrf_hash();
					$Return['error'] = $this->lang->line('umb_error_attatchment_type');
				}
			}
		}
		if($Return['error']!=''){
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$this->output($Return);
		}
	}
}

public function payroll_config() {

	if($this->input->post('type')=='payroll_config') {

		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$id = 1;

		$data = array(
			'is_generate_password_slipgaji' => $this->input->post('generate_password_slipgaji'),
			'format_password_slipgaji' => $this->input->post('format_password_slipgaji'),
			'is_half_monthly' => $this->input->post('is_half_monthly'),
			'potong_setengah_bulan' => $this->input->post('potong_setengah_bulan'),
			'enable_asuransi' => $this->input->post('enable_asuransi')
		);
		$result = $this->Umb_model->update_record_info_setting($data,$id);	
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('umb_sukses_payroll_config_diperbarui');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
		exit;

		if($Return['error']!=''){
			$this->output($Return);
		}
	}
}

public function system_info() {

	if($this->input->post('type')=='system_info') {

		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$id = 1;
		if(trim($this->input->post('application_name'))==='') {
			$Return['error'] = $this->lang->line('umb_error_application_name_field');
		} else if($this->input->post('default_currency_symbol')==='') {
			$Return['error'] = $this->lang->line('umb_error_default_currency_field');
		} else if($this->input->post('show_currency')==='') {
			$Return['error'] = $this->lang->line('umb_error_default_currency_symbol');
		} else if($this->input->post('currency_position')==='') {
			$Return['error'] = $this->lang->line('umb_error_currency_position');
		} else if($this->input->post('date_format')==='') {
			$Return['error'] = $this->lang->line('umb_error_date_format_field');
		} else if($this->input->post('footer_text')==='') {
			$Return['error'] = $this->lang->line('umb_error_footer_text');
		} else if($this->input->post('login_karyawan_id')==='') {
			$Return['error'] = $this->lang->line('umb_error_login_karyawan_id_field');
		} else if($this->input->post('system_timezone')==='') {
			$Return['error'] = $this->lang->line('umb_error_timezone_field');
		} else if($this->input->post('google_maps_api_key')==='') {
			$Return['error'] = $this->lang->line('umb_error_gmap_field');
		}
		if($Return['error']!=''){
			$this->output($Return);
		}
		$data = array(
			'application_name' => $this->input->post('application_name'),
			'default_currency_symbol' => $this->input->post('default_currency_symbol'),
			'default_currency' => $this->input->post('default_currency_symbol'),
			'show_currency' => $this->input->post('show_currency'),
			'currency_position' => $this->input->post('currency_position'),
			'date_format_astral' => $this->input->post('date_format'),
			'footer_text' => $this->input->post('footer_text'),
			'enable_page_rendered' => $this->input->post('enable_page_rendered'),
			'enable_current_year' => $this->input->post('enable_current_year'),
			'login_karyawan_id' => $this->input->post('login_karyawan_id'),
			'system_timezone' => $this->input->post('system_timezone'),
			'google_maps_api_key' => $this->input->post('google_maps_api_key'),
			'is_ssl_available' => $this->input->post('is_ssl_available'),
			'default_language' => $this->input->post('default_language'),
			'statutory_fixed' => $this->input->post('statutory_fixed'),
			'invoice_terms_condition' => $this->input->post('invoice_terms_condition'),
			'estimate_terms_condition' => $this->input->post('estimate_terms_condition'),
			'show_projects' => $this->input->post('show_projects'),
			'show_tugass' => $this->input->post('show_tugass'),
		);

		$result = $this->Umb_model->update_record_info_setting($data,$id);		

		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('umb_sukses_system_configuration_diperbarui');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
		exit;
	}
}

public function modules_info() {

	if($this->input->get('type')=='modules_info') {

		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$id = 1;

		$data = array(
			'module_recruitment' => $this->input->get('mrecruitment'),
			'module_perjalanan' => $this->input->get('mperjalanan'),
			'module_files' => $this->input->get('mfiles'),
			'module_language' => $this->input->get('mlanguage'),
			'module_orgchart' => $this->input->get('morgchart'),
			'module_events' => $this->input->get('mevents'),
			'module_chat_box' => $this->input->get('chatbox'),
			'is_active_sub_departments' => $this->input->get('is_sub_departments'),
			'module_payroll' => $this->input->get('module_payroll'),
			'module_performance' => $this->input->get('module_performance'),
		);
		$result = $this->Umb_model->update_record_info_setting($data,$id);		

		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('umb_sukses_system_modules_diperbarui');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
		exit;
	}
}

public function info_layout_skin() {

	if($this->input->get('type')=='hrastral_info_layout') {

		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$id = $this->input->get('user_session_id');
		$data = array(
			'fixed_header' => $this->input->get('fixed_layout_hrastral'),
			'boxed_wrapper' => $this->input->get('boxed_layout_hrastral'),
			'compact_sidebar' => $this->input->get('sidebar_layout_hrastral')
		);
		$result = $this->Karyawans_model->basic_info($data,$id);	
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('umb_sukses_system_layout_diperbarui');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
		exit;
	}
}

public function role_info() {

	if($this->input->post('type')=='role_info') {

		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$id = 1;
		$data = array(
			'karyawan_manage_own_kontak' => $this->input->post('karyawan_manage_own_kontak'),
			'karyawan_manage_own_social' => $this->input->post('karyawan_manage_own_social'),
			'karyawan_manage_own_bank_account' => $this->input->post('karyawan_manage_own_bank_account'),
			'karyawan_manage_own_qualification' => $this->input->post('karyawan_manage_own_qualification'),
			'karyawan_manage_own_pengalaman_kerja' => $this->input->post('karyawan_manage_own_pengalaman_kerja'),
			'karyawan_manage_own_document' => $this->input->post('karyawan_manage_own_document'),
			'karyawan_manage_own_picture' => $this->input->post('karyawan_manage_own_picture'),
			'karyawan_manage_own_profile' => $this->input->post('karyawan_manage_own_profile'),
		);
		$result = $this->Umb_model->update_record_info_setting($data,$id);		

		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('umb_sukses_role_config_diperbarui');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
		exit;
	}
}


public function sidebar_setting_info() {

	if($this->input->post('type')=='other_settings') {


		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$id = 1;

		$data = array(
			'enable_kehadiran' => $this->input->post('enable_kehadiran'),
			'enable_pekerjaan_application_kandidats' => $this->input->post('enable_pekerjaan'),
			'enable_profile_background' => $this->input->post('enable_profile_background'),
			'enable_email_notification' => $this->input->post('role_email_notification'),
			'notification_close_btn' => $this->input->post('close_btn'),
			'notification_bar' => $this->input->post('notification_bar'),
			'enable_kebijakan_link' => $this->input->post('link_role_kebijakan'),
			'enable_layout' => $this->input->post('enable_layout'),
		);

		$result = $this->Umb_model->update_record_info_setting($data,$id);		

		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('umb_setting_config_diperbarui');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
		exit;
	}
}


public function info_kehadiran() {

	if($this->input->post('type')=='info_kehadiran') {

		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$id = 1;
		$data = array(
			'enable_kehadiran' => $this->input->post('enable_kehadiran'),
			'enable_clock_in_btn' => $this->input->post('enable_clock_in_btn')
		);

		$result = $this->Umb_model->update_record_info_setting($data,$id);		

		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('umb_kehadiran_config_diperbarui');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
		exit;
	}
}

public function email_info() {

	if($this->input->post('type')=='email_info') {

		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$id = 1;

		$data = array(
			'enable_email_notification' => $this->input->post('enable_email_notification')
		);
		$result = $this->Umb_model->update_record_info_setting($data,$id);
		$cdata = array(
			'email_type' => $this->input->post('email_type'),
			'smtp_host' => $this->input->post('smtp_host'),
			'smtp_username' => $this->input->post('smtp_username'),
			'smtp_password' => $this->input->post('smtp_password'),
			'smtp_port' => $this->input->post('smtp_port'),
			'smtp_secure' => $this->input->post('smtp_secure')
		);
		$this->Umb_model->update_email_config_record($cdata,1);		

		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('umb_sukses_email_notify_diperbarui');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
		exit;
	}
}


public function info_pekerjaan() {

	if($this->input->post('type')=='info_pekerjaan') {

		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();

		if($this->input->post('pekerjaan_application_format')==='') {
			$Return['error'] = $this->lang->line('umb_error_pekerjaan_app_format');
		}
		if($Return['error']!=''){
			$hrm_f->output($Return);
		}
		$pekerjaan_format = str_replace(array('php', '', 'js', '','html', ''), '',$this->input->post('pekerjaan_application_format'));
		$id = 1;
		$data = array(
			'enable_pekerjaan_application_kandidats' => $this->input->post('enable_pekerjaan'),
			'pekerjaan_application_format' => $pekerjaan_format
		);

		$result = $this->Umb_model->update_record_info_setting($data,$id);		

		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('umb_sukses_config_pekerjaan_diperbarui');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
		exit;
	}
}


public function info_animation_effect() {

	if($this->input->post('type')=='info_animation_effect') {

		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$id = 1;

		$data = array(
			'animation_effect' => $this->input->post('animation_effect'),
			'animation_effect_topmenu' => $this->input->post('animation_effect_topmenu'),
			'animation_effect_modal' => $this->input->post('animation_effect_modal')
		);

		$result = $this->Umb_model->update_record_info_setting($data,$id);		

		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('umb_sukses_config_animation_diperbarui');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
		exit;
	}
}

public function info_notification_position() {

	if($this->input->post('type')=='info_notification_position') {


		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();

		if($this->input->post('notification_position')==='') {
			$Return['error'] = $this->lang->line('umb_error_notify_position');
		}

		if($Return['error']!=''){
			$hrm_f->output($Return);
		}
		$id = 1;

		$data = array(
			'notification_position' => $this->input->post('notification_position'),
			'notification_close_btn' => $this->input->post('notification_close_btn'),
			'notification_bar' => $this->input->post('notification_bar')
		);

		$result = $this->Umb_model->update_record_info_setting($data,$id);		

		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('umb_sukses_notify_position_config_diperbarui');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
		exit;
	}
}

public function delete_single_backup() {

	$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
	$id = $this->uri->segment(4);
	$Return['csrf_hash'] = $this->security->get_csrf_hash();
	$result = $this->Umb_model->delete_record_single_backup($id);
	if(isset($id)) {
		$Return['result'] = $this->lang->line('umb_sukses_database_backup_dihapus');
	} else {
		$Return['error'] = $this->lang->line('umb_error_msg');
	}
	$this->output($Return);
}


public function list_type_kontrak() {

	$data['title'] = $this->Umb_model->site_title();
	$session = $this->session->userdata('username');
	if(!empty($session)){ 
		$this->load->view("admin/settings/settings", $data);
	} else {
		redirect('admin/');
	}

	$draw = intval($this->input->get("draw"));
	$start = intval($this->input->get("start"));
	$length = intval($this->input->get("length"));
	$type_kontrak = $this->Umb_model->get_types_kontrak();
	$data = array();
	foreach($type_kontrak->result() as $r) {
		$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit_setting_datail" data-field_id="'. $r->type_kontrak_id . '" data-field_type="type_kontrak"><span class="fas fa-pencil-alt"></span></button></span> <span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->type_kontrak_id . '" data-token_type="type_kontrak"><span class="fas fa-trash-restore"></span></button></span>',
			$r->name,
		);
	}

	$output = array(
		"draw" => $draw,
		"recordsTotal" => $type_kontrak->num_rows(),
		"recordsFiltered" => $type_kontrak->num_rows(),
		"data" => $data
	);

	echo json_encode($output);
	exit();
} 

public function list_tingkat_pendidikan() {

	$data['title'] = $this->Umb_model->site_title();
	$session = $this->session->userdata('username');
	if(!empty($session)){ 
		$this->load->view("admin/settings/settings", $data);
	} else {
		redirect('admin/');
	}

	$draw = intval($this->input->get("draw"));
	$start = intval($this->input->get("start"));
	$length = intval($this->input->get("length"));
	$constant = $this->Umb_model->get_qualification_pendidikan();
	$data = array();

	foreach($constant->result() as $r) {

		$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit_setting_datail" data-field_id="'. $r->tingkat_pendidikan_id . '" data-field_type="tingkat_pendidikan"><span class="fas fa-pencil-alt"></span></button></span> <span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->tingkat_pendidikan_id . '" data-token_type="tingkat_pendidikan"><span class="fas fa-trash-restore"></span></button></span>',
			$r->name,
		);
	}

	$output = array(
		"draw" => $draw,
		"recordsTotal" => $constant->num_rows(),
		"recordsFiltered" => $constant->num_rows(),
		"data" => $data
	);

	echo json_encode($output);
	exit();
}

public function list_qualification_language() {

	$data['title'] = $this->Umb_model->site_title();
	$session = $this->session->userdata('username');
	if(!empty($session)){ 
		$this->load->view("admin/settings/settings", $data);
	} else {
		redirect('admin/');
	}
	$draw = intval($this->input->get("draw"));
	$start = intval($this->input->get("start"));
	$length = intval($this->input->get("length"));
	$constant = $this->Umb_model->get_qualification_language();
	$data = array();
	foreach($constant->result() as $r) {

		$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit_setting_datail" data-field_id="'. $r->language_id . '" data-field_type="qualification_language"><span class="fas fa-pencil-alt"></span></button></span> <span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->language_id . '"  data-token_type="qualification_language"><span class="fas fa-trash-restore"></span></button></span>',
			$r->name,
		);
	}

	$output = array(
		"draw" => $draw,
		"recordsTotal" => $constant->num_rows(),
		"recordsFiltered" => $constant->num_rows(),
		"data" => $data
	);

	echo json_encode($output);
	exit();
}

public function list_qualification_skill(){

	$data['title'] = $this->Umb_model->site_title();
	$session = $this->session->userdata('username');
	if(!empty($session)){ 
		$this->load->view("admin/settings/settings", $data);
	} else {
		redirect('admin/');
	}

	$draw = intval($this->input->get("draw"));
	$start = intval($this->input->get("start"));
	$length = intval($this->input->get("length"));
	$constant = $this->Umb_model->get_qualification_skill();
	$data = array();
	foreach($constant->result() as $r) {
		$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit_setting_datail" data-field_id="'. $r->skill_id . '" data-field_type="qualification_skill"><span class="fas fa-pencil-alt"></span></button></span> <span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->skill_id . '" data-token_type="qualification_skill"><span class="fas fa-trash-restore"></span></button></span>',
			$r->name,
		);
	}
	$output = array(
		"draw" => $draw,
		"recordsTotal" => $constant->num_rows(),
		"recordsFiltered" => $constant->num_rows(),
		"data" => $data
	);

	echo json_encode($output);
	exit();
}

public function list_type_document()
{

	$data['title'] = $this->Umb_model->site_title();
	$session = $this->session->userdata('username');
	if(!empty($session)){ 
		$this->load->view("admin/settings/settings", $data);
	} else {
		redirect('admin/');
	}
	$draw = intval($this->input->get("draw"));
	$start = intval($this->input->get("start"));
	$length = intval($this->input->get("length"));
	$constant = $this->Umb_model->get_type_document();
	$data = array();
	foreach($constant->result() as $r) {

		$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit_setting_datail" data-field_id="'. $r->type_document_id . '" data-field_type="type_document"><span class="fas fa-pencil-alt"></span></button></span> <span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->type_document_id . '" data-token_type="type_document"><span class="fas fa-trash-restore"></span></button></span>',
			$r->type_document,
		);
	}

	$output = array(
		"draw" => $draw,
		"recordsTotal" => $constant->num_rows(),
		"recordsFiltered" => $constant->num_rows(),
		"data" => $data
	);

	echo json_encode($output);
	exit();
}

public function list_type_award() {

	$data['title'] = $this->Umb_model->site_title();
	$session = $this->session->userdata('username');
	if(!empty($session)){ 
		$this->load->view("admin/settings/settings", $data);
	} else {
		redirect('admin/');
	}
	$draw = intval($this->input->get("draw"));
	$start = intval($this->input->get("start"));
	$length = intval($this->input->get("length"));
	$constant = $this->Umb_model->get_type_award();
	$data = array();
	foreach($constant->result() as $r) {
		$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit_setting_datail" data-field_id="'. $r->type_award_id . '" data-field_type="type_award"><span class="fas fa-pencil-alt"></span></button></span> <span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->type_award_id . '" data-token_type="type_award"><span class="fas fa-trash-restore"></span></button></span>',
			$r->type_award,
		);
	}

	$output = array(
		"draw" => $draw,
		"recordsTotal" => $constant->num_rows(),
		"recordsFiltered" => $constant->num_rows(),
		"data" => $data
	);

	echo json_encode($output);
	exit();
}

public function list_type_cuti() {

	$data['title'] = $this->Umb_model->site_title();
	$session = $this->session->userdata('username');
	if(!empty($session)){ 
		$this->load->view("admin/settings/settings", $data);
	} else {
		redirect('admin/');
	}
	$draw = intval($this->input->get("draw"));
	$start = intval($this->input->get("start"));
	$length = intval($this->input->get("length"));
	$constant = $this->Umb_model->get_type_cuti();
	$data = array();
	foreach($constant->result() as $r) {
		$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit_setting_datail" data-field_id="'. $r->type_cuti_id . '" data-field_type="type_cuti"><span class="fas fa-pencil-alt"></span></button></span> <span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->type_cuti_id . '" data-token_type="type_cuti"><span class="fas fa-trash-restore"></span></button></span>',
			$r->type_name,
			$r->days_per_year
		);
	}
	$output = array(
		"draw" => $draw,
		"recordsTotal" => $constant->num_rows(),
		"recordsFiltered" => $constant->num_rows(),
		"data" => $data
	);
	echo json_encode($output);
	exit();
}

public function list_type_peringatan() {

	$data['title'] = $this->Umb_model->site_title();
	$session = $this->session->userdata('username');
	if(!empty($session)){ 
		$this->load->view("admin/settings/settings", $data);
	} else {
		redirect('admin/');
	}
	$draw = intval($this->input->get("draw"));
	$start = intval($this->input->get("start"));
	$length = intval($this->input->get("length"));
	$constant = $this->Umb_model->get_type_peringatan();
	$data = array();
	foreach($constant->result() as $r) {
		$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit_setting_datail" data-field_id="'. $r->type_peringatan_id . '" data-field_type="type_peringatan"><span class="fas fa-pencil-alt"></span></button></span> <span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->type_peringatan_id . '" data-token_type="type_peringatan"><span class="fas fa-trash-restore"></span></button></span>',
			$r->type
		);
	}
	$output = array(
		"draw" => $draw,
		"recordsTotal" => $constant->num_rows(),
		"recordsFiltered" => $constant->num_rows(),
		"data" => $data
	);
	echo json_encode($output);
	exit();
}

public function list_type_sukubangsa(){

	$data['title'] = $this->Umb_model->site_title();
	$session = $this->session->userdata('username');
	if(!empty($session)){ 
		$this->load->view("admin/settings/settings", $data);
	} else {
		redirect('admin/');
	}
	$draw = intval($this->input->get("draw"));
	$start = intval($this->input->get("start"));
	$length = intval($this->input->get("length"));
	$constant = $this->Umb_model->get_type_sukubangsa();
	$data = array();
	foreach($constant->result() as $r) {
		$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit_setting_datail" data-field_id="'. $r->type_sukubangsa_id . '" data-field_type="type_sukubangsa"><span class="fas fa-pencil-alt"></span></button></span> <span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->type_sukubangsa_id . '" data-token_type="type_sukubangsa"><span class="fas fa-trash-restore"></span></button></span>',
			$r->type
		);
	}
	$output = array(
		"draw" => $draw,
		"recordsTotal" => $constant->num_rows(),
		"recordsFiltered" => $constant->num_rows(),
		"data" => $data
	);
	echo json_encode($output);
	exit();
}

public function list_type_pendapatan(){

	$data['title'] = $this->Umb_model->site_title();
	$session = $this->session->userdata('username');
	if(!empty($session)){ 
		$this->load->view("admin/settings/settings", $data);
	} else {
		redirect('admin/');
	}
	$draw = intval($this->input->get("draw"));
	$start = intval($this->input->get("start"));
	$length = intval($this->input->get("length"));
	$constant = $this->Umb_model->get_kategoris_pendapatan();
	$data = array();
	foreach($constant->result() as $r) {
		$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit_setting_datail" data-field_id="'. $r->kategori_id . '" data-field_type="type_pendapatan"><span class="fas fa-pencil-alt"></span></button></span> <span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->kategori_id . '" data-token_type="type_pendapatan"><span class="fas fa-trash-restore"></span></button></span>',
			$r->name
		);
	}

	$output = array(
		"draw" => $draw,
		"recordsTotal" => $constant->num_rows(),
		"recordsFiltered" => $constant->num_rows(),
		"data" => $data
	);

	echo json_encode($output);
	exit();
}

public function list_type_penghentian()
{

	$data['title'] = $this->Umb_model->site_title();
	$session = $this->session->userdata('username');
	if(!empty($session)){ 
		$this->load->view("admin/settings/settings", $data);
	} else {
		redirect('admin/');
	}
	$draw = intval($this->input->get("draw"));
	$start = intval($this->input->get("start"));
	$length = intval($this->input->get("length"));
	$constant = $this->Umb_model->get_type_penghentian();
	$data = array();
	foreach($constant->result() as $r) {

		$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit_setting_datail" data-field_id="'. $r->type_penghentian_id . '" data-field_type="type_penghentian"><span class="fas fa-pencil-alt"></span></button></span> <span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->type_penghentian_id . '" data-token_type="type_penghentian"><span class="fas fa-trash-restore"></span></button></span>',
			$r->type
		);
	}

	$output = array(
		"draw" => $draw,
		"recordsTotal" => $constant->num_rows(),
		"recordsFiltered" => $constant->num_rows(),
		"data" => $data
	);

	echo json_encode($output);
	exit();
}

public function list_type_biaya() {

	$data['title'] = $this->Umb_model->site_title();
	$session = $this->session->userdata('username');
	if(!empty($session)){ 
		$this->load->view("admin/settings/settings", $data);
	} else {
		redirect('admin/');
	}
	$draw = intval($this->input->get("draw"));
	$start = intval($this->input->get("start"));
	$length = intval($this->input->get("length"));
	$constant = $this->Umb_model->get_type_biaya();
	$data = array();

	foreach($constant->result() as $r) {
		$perusahaan = $this->Umb_model->read_info_perusahaan($r->perusahaan_id);
		if(!is_null($perusahaan)){
			$prshn_nama = $perusahaan[0]->name;
		} else {
			$prshn_nama = '--';	
		}
		$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit_setting_datail" data-field_id="'. $r->type_biaya_id . '" data-field_type="type_biaya"><span class="fas fa-pencil-alt"></span></button></span> <span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->type_biaya_id . '" data-token_type="type_biaya"><span class="fas fa-trash-restore"></span></button></span>',
			$prshn_nama,
			$r->name
		);
	}

	$output = array(
		"draw" => $draw,
		"recordsTotal" => $constant->num_rows(),
		"recordsFiltered" => $constant->num_rows(),
		"data" => $data
	);

	echo json_encode($output);
	exit();
}

public function list_type_pekerjaan() {

	$data['title'] = $this->Umb_model->site_title();
	$session = $this->session->userdata('username');
	if(!empty($session)){ 
		$this->load->view("admin/settings/settings", $data);
	} else {
		redirect('admin/');
	}
	$draw = intval($this->input->get("draw"));
	$start = intval($this->input->get("start"));
	$length = intval($this->input->get("length"));
	$constant = $this->Umb_model->get_type_pekerjaan();
	$data = array();
	foreach($constant->result() as $r) {
		$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit_setting_datail" data-field_id="'. $r->type_pekerjaan_id . '" data-field_type="type_pekerjaan"><span class="fas fa-pencil-alt"></span></button></span> <span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->type_pekerjaan_id . '" data-token_type="type_pekerjaan"><span class="fas fa-trash-restore"></span></button></span>',
			$r->type
		);
	}
	$output = array(
		"draw" => $draw,
		"recordsTotal" => $constant->num_rows(),
		"recordsFiltered" => $constant->num_rows(),
		"data" => $data
	);

	echo json_encode($output);
	exit();
}

public function list_kategori_pekerjaan() {

	$data['title'] = $this->Umb_model->site_title();
	$session = $this->session->userdata('username');
	if(!empty($session)){ 
		$this->load->view("admin/settings/settings", $data);
	} else {
		redirect('admin/');
	}
	$draw = intval($this->input->get("draw"));
	$start = intval($this->input->get("start"));
	$length = intval($this->input->get("length"));
	$constant = $this->Umb_model->get_kategoris_pekerjaan();
	$data = array();
	foreach($constant->result() as $r) {
		$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit_setting_datail" data-field_id="'. $r->kategori_id . '" data-field_type="kategori_pekerjaan"><span class="fas fa-pencil-alt"></span></button></span> <span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->kategori_id . '" data-token_type="kategori_pekerjaan"><span class="fas fa-trash-restore"></span></button></span>',
			$r->nama_kategori
		);
	}
	$output = array(
		"draw" => $draw,
		"recordsTotal" => $constant->num_rows(),
		"recordsFiltered" => $constant->num_rows(),
		"data" => $data
	);

	echo json_encode($output);
	exit();
}

public function list_type_exit(){

	$data['title'] = $this->Umb_model->site_title();
	$session = $this->session->userdata('username');
	if(!empty($session)){ 
		$this->load->view("admin/settings/settings", $data);
	} else {
		redirect('admin/');
	}
	$draw = intval($this->input->get("draw"));
	$start = intval($this->input->get("start"));
	$length = intval($this->input->get("length"));
	$constant = $this->Umb_model->get_type_exit();
	$data = array();
	foreach($constant->result() as $r) {
		$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit_setting_datail" data-field_id="'. $r->type_exit_id . '" data-field_type="type_exit"><span class="fas fa-pencil-alt"></span></button></span> <span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->type_exit_id . '" data-token_type="type_exit"><span class="fas fa-trash-restore"></span></button></span>',
			$r->type
		);
	}
	$output = array(
		"draw" => $draw,
		"recordsTotal" => $constant->num_rows(),
		"recordsFiltered" => $constant->num_rows(),
		"data" => $data
	);
	echo json_encode($output);
	exit();
}

public function list_type_pngtrn_perjalanan() {

	$data['title'] = $this->Umb_model->site_title();
	$session = $this->session->userdata('username');
	if(!empty($session)){ 
		$this->load->view("admin/settings/settings", $data);
	} else {
		redirect('admin/');
	}
	$draw = intval($this->input->get("draw"));
	$start = intval($this->input->get("start"));
	$length = intval($this->input->get("length"));
	$constant = $this->Umb_model->get_type_perjalanan();
	$data = array();
	foreach($constant->result() as $r) {

		$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit_setting_datail" data-field_id="'. $r->type_pengaturan_id . '" data-field_type="type_pngtrn_perjalanan"><span class="fas fa-pencil-alt"></span></button></span> <span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->type_pengaturan_id . '" data-token_type="type_pngtrn_perjalanan"><span class="fas fa-trash-restore"></span></button></span>',
			$r->type
		);
	}
	$output = array(
		"draw" => $draw,
		"recordsTotal" => $constant->num_rows(),
		"recordsFiltered" => $constant->num_rows(),
		"data" => $data
	);
	echo json_encode($output);
	exit();
}

public function list_payment_method() {

	$data['title'] = $this->Umb_model->site_title();
	$session = $this->session->userdata('username');
	if(!empty($session)){ 
		$this->load->view("admin/settings/settings", $data);
	} else {
		redirect('admin/');
	}
	$draw = intval($this->input->get("draw"));
	$start = intval($this->input->get("start"));
	$length = intval($this->input->get("length"));
	$constant = $this->Umb_model->get_payment_method();
	$data = array();
	foreach($constant->result() as $r) {
		$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit_setting_datail" data-field_id="'. $r->payment_method_id . '" data-field_type="payment_method"><span class="fas fa-pencil-alt"></span></button></span> <span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->payment_method_id . '" data-token_type="payment_method"><span class="fas fa-trash-restore"></span></button></span>',
			$r->method_name,
			$r->payment_percentage.'%',
			$r->nomor_account
		);
	}
	$output = array(
		"draw" => $draw,
		"recordsTotal" => $constant->num_rows(),
		"recordsFiltered" => $constant->num_rows(),
		"data" => $data
	);
	echo json_encode($output);
	exit();
}

public function list_type_currency(){

	$data['title'] = $this->Umb_model->site_title();
	$session = $this->session->userdata('username');
	if(!empty($session)){ 
		$this->load->view("admin/settings/settings", $data);
	} else {
		redirect('admin/');
	}
	$draw = intval($this->input->get("draw"));
	$start = intval($this->input->get("start"));
	$length = intval($this->input->get("length"));
	$constant = $this->Umb_model->get_types_currency();
	$data = array();
	foreach($constant->result() as $r) {
		$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit_setting_datail" data-field_id="'. $r->currency_id . '" data-field_type="type_currency"><span class="fas fa-pencil-alt"></span></button></span> <span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->currency_id . '" data-token_type="type_currency"><span class="fas fa-trash-restore"></span></button></span>',
			$r->name,
			$r->code,
			$r->symbol
		);
	}
	$output = array(
		"draw" => $draw,
		"recordsTotal" => $constant->num_rows(),
		"recordsFiltered" => $constant->num_rows(),
		"data" => $data
	);
	echo json_encode($output);
	exit();
}

public function list_type_perusahaan() {

	$data['title'] = $this->Umb_model->site_title();
	$session = $this->session->userdata('username');
	if(!empty($session)){ 
		$this->load->view("admin/settings/settings", $data);
	} else {
		redirect('admin/');
	}
	$draw = intval($this->input->get("draw"));
	$start = intval($this->input->get("start"));
	$length = intval($this->input->get("length"));
	$constant = $this->Umb_model->get_type_perusahaan();
	$data = array();
	foreach($constant->result() as $r) {
		$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit_setting_datail" data-field_id="'. $r->type_id . '" data-field_type="type_perusahaan"><span class="fas fa-pencil-alt"></span></button></span> <span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->type_id . '" data-token_type="type_perusahaan"><span class="fas fa-trash-restore"></span></button></span>',
			$r->name
		);
	}
	$output = array(
		"draw" => $draw,
		"recordsTotal" => $constant->num_rows(),
		"recordsFiltered" => $constant->num_rows(),
		"data" => $data
	);
	echo json_encode($output);
	exit();
}

public function info_type_kontrak() {

	if($this->input->post('type')=='info_type_kontrak') {		

		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		if($this->input->post('type_kontrak')==='') {
			$Return['error'] = $this->lang->line('umb_karyawan_error_type_kontrak');
		}
		if($Return['error']!=''){
			$this->output($Return);
		}
		$data = array(
			'name' => $this->input->post('type_kontrak'),
			'created_at' => date('d-m-Y h:i:s')
		);
		$result = $this->Umb_model->add_type_kontrak($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('umb_sukses_type_kontrak_ditambahkan');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
		exit;
	}
}

public function info_type_document() {

	if($this->input->post('type')=='info_type_document') {		

		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		if($this->input->post('type_document')==='') {
			$Return['error'] = $this->lang->line('umb_karyawan_error_type_document');
		}
		if($Return['error']!=''){
			$this->output($Return);
		}
		$data = array(
			'type_document' => $this->input->post('type_document'),
			'created_at' => date('d-m-Y h:i:s')
		);
		$result = $this->Umb_model->add_type_document($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('umb_sukses_type_document_ditambahkan');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
		exit;
	}
}


public function info_tingkat_pddkn() {

	if($this->input->post('type')=='info_tingkat_pddkn') {		
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		if($this->input->post('name')==='') {
			$Return['error'] = $this->lang->line('umb_error_tingkat_pendidikan');
		}
		if($Return['error']!=''){
			$this->output($Return);
		}
		$data = array(
			'name' => $this->input->post('name'),
			'created_at' => date('d-m-Y h:i:s')
		);
		$result = $this->Umb_model->add_tingkat_pddkn($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('umb_sukses_tingkat_pendidikan_ditambahkan');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
		exit;
	}
}

public function info_edu_language() {

	if($this->input->post('type')=='info_edu_language') {		

		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		if($this->input->post('name')==='') {
			$Return['error'] = $this->lang->line('umb_error_education_language');
		}
		if($Return['error']!=''){
			$this->output($Return);
		}
		$data = array(
			'name' => $this->input->post('name'),
			'created_at' => date('d-m-Y h:i:s')
		);
		$result = $this->Umb_model->add_edu_language($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('umb_sukses_education_language_ditambahkan');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
		exit;
	}
}


public function info_edu_skill() {

	if($this->input->post('type')=='info_edu_skill') {		

		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		if($this->input->post('name')==='') {
			$Return['error'] = $this->lang->line('umb_error_education_skill');
		}
		if($Return['error']!=''){
			$this->output($Return);
		}
		$data = array(
			'name' => $this->input->post('name'),
			'created_at' => date('d-m-Y h:i:s')
		);
		$result = $this->Umb_model->add_edu_skill($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('umb_sukses_education_skill_ditambahkan');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
		exit;
	}
}

public function info_payment_method() {

	if($this->input->post('type')=='info_payment_method') {		

		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		if($this->input->post('payment_method')==='') {
			$Return['error'] = $this->lang->line('umb_error_payment_method');
		}

		if($Return['error']!=''){
			$this->output($Return);
		}
		$data = array(
			'method_name' => $this->input->post('payment_method'),
			'payment_percentage' => $this->input->post('payment_percentage'),
			'nomor_account' => $this->input->post('nomor_account'),
			'created_at' => date('d-m-Y h:i:s')
		);
		$result = $this->Umb_model->add_payment_method($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('umb_sukses_payment_method_ditambahkan');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
		exit;
	}
}

public function info_type_award() {

	if($this->input->post('type')=='info_type_award') {		
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		if($this->input->post('type_award')==='') {
			$Return['error'] = $this->lang->line('umb_award_error_type_award');
		}
		if($Return['error']!=''){
			$this->output($Return);
		}
		$data = array(
			'type_award' => $this->input->post('type_award'),
			'created_at' => date('d-m-Y h:i:s')
		);
		$result = $this->Umb_model->add_type_award($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('umb_sukses_type_award_ditambahkan');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
		exit;
	}
}


public function info_type_cuti() {

	if($this->input->post('type')=='info_type_cuti') {		

		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		if($this->input->post('type_cuti')==='') {
			$Return['error'] = $this->lang->line('umb_error_type_cuti_field');
		} else if($this->input->post('days_per_year')==='') {
			$Return['error'] = $this->lang->line('umb_error_days_per_year');
		}
		if($Return['error']!=''){
			$this->output($Return);
		}
		$data = array(
			'type_name' => $this->input->post('type_cuti'),
			'days_per_year' => $this->input->post('days_per_year'),
			'created_at' => date('d-m-Y h:i:s')
		);
		$result = $this->Umb_model->add_type_cuti($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('umb_sukses_type_cuti_ditambahkan');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
		exit;
	}
}

public function info_type_peringatan() {

	if($this->input->post('type')=='info_type_peringatan') {		

		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		if($this->input->post('type_peringatan')==='') {
			$Return['error'] = $this->lang->line('umb_karyawan_error_type_peringatan');
		}
		if($Return['error']!=''){
			$this->output($Return);
		}
		$data = array(
			'type' => $this->input->post('type_peringatan'),
			'created_at' => date('d-m-Y h:i:s')
		);
		$result = $this->Umb_model->add_type_peringatan($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('umb_sukses_type_peringatan_ditambahkan');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
		exit;
	}
}

public function info_type_penghentian() {

	if($this->input->post('type')=='info_type_penghentian') {		

		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		if($this->input->post('type_penghentian')==='') {
			$Return['error'] = $this->lang->line('umb_error_type_penghentian');
		}
		if($Return['error']!=''){
			$this->output($Return);
		}
		$data = array(
			'type' => $this->input->post('type_penghentian'),
			'created_at' => date('d-m-Y h:i:s')
		);
		$result = $this->Umb_model->add_type_penghentian($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('umb_sukses_type_penghentian_ditambahkan');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
		exit;
	}
}

public function info_type_biaya() {

	if($this->input->post('type')=='info_type_biaya') {		

		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		if($this->input->post('perusahaan')==='') {
			$Return['error'] = $this->lang->line('error_field_perusahaan');
		} else if($this->input->post('type_biaya')==='') {
			$Return['error'] = $this->lang->line('umb_error_type_biaya');
		}
		if($Return['error']!=''){
			$this->output($Return);
		}
		$data = array(
			'name' => $this->input->post('type_biaya'),
			'perusahaan_id' => $this->input->post('perusahaan'),
			'created_at' => date('d-m-Y h:i:s')
		);
		$result = $this->Umb_model->add_type_biaya($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('umb_sukses_type_biaya_ditambahkan');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
		exit;
	}
}

public function info_type_pekerjaan() {

	if($this->input->post('type')=='info_type_pekerjaan') {		

		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		if($this->input->post('type_pekerjaan')==='') {
			$Return['error'] = $this->lang->line('umb_error_post_type_pekerjaan');
		}
		if($Return['error']!=''){
			$this->output($Return);
		}
		$jurl = random_string('alnum', 40);
		$data = array(
			'type' => $this->input->post('type_pekerjaan'),
			'type_url' => $jurl,
			'perusahaan_id' => 1,
			'created_at' => date('d-m-Y h:i:s')
		);
		$result = $this->Umb_model->add_type_pekerjaan($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('umb_sukses_type_pekerjaan_ditambahkan');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
		exit;
	}
}

public function info_kategori_pekerjaan() {

	if($this->input->post('type')=='info_kategori_pekerjaan') {		
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		if($this->input->post('kategori_pekerjaan')==='') {
			$Return['error'] = $this->lang->line('umb_error_kategori_pekerjaan');
		}
		if($Return['error']!=''){
			$this->output($Return);
		}
		$jurl = random_string('alnum', 40);
		$data = array(
			'nama_kategori' => $this->input->post('kategori_pekerjaan'),
			'kategori_url' => $jurl,
			'created_at' => date('d-m-Y h:i:s')
		);
		$result = $this->Umb_model->add_kategori_pekerjaan($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('umb_sukses_kategori_pekerjaan_ditambahkan');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
		exit;
	}
}

public function info_type_exit() {

	if($this->input->post('type')=='info_type_exit') {		
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		if($this->input->post('type_exit')==='') {
			$Return['error'] = $this->lang->line('umb_error_type_exit');
		}
		if($Return['error']!=''){
			$this->output($Return);
		}
		$data = array(
			'type' => $this->input->post('type_exit'),
			'created_at' => date('d-m-Y h:i:s')
		);
		$result = $this->Umb_model->add_type_exit($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('umb_error_tingkat_pendidikan');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
		exit;
	}
}

public function info_type_pngtrn_perjalanan() {

	if($this->input->post('type')=='info_type_pngtrn_perjalanan') {		

		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		if($this->input->post('type_pngtrn_perjalanan')==='') {
			$Return['error'] = $this->lang->line('umb_error_type_pengaturan_perjalanan');
		}
		if($Return['error']!=''){
			$this->output($Return);
		}
		$data = array(
			'type' => $this->input->post('type_pngtrn_perjalanan'),
			'created_at' => date('d-m-Y h:i:s')
		);
		$result = $this->Umb_model->add_type_pngtrn_perjalanan($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('umb_sukses_type_pengaturan_perjalanan_ditambahkan');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
		exit;
	}
}

public function info_type_perusahaan() {

	if($this->input->post('type')=='info_type_perusahaan') {		
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		if($this->input->post('type_perusahaan')==='') {
			$Return['error'] = $this->lang->line('umb_error_ctype_field');
		}
		if($Return['error']!=''){
			$this->output($Return);
		}
		$data = array(
			'name' => $this->input->post('type_perusahaan'),
			'created_at' => date('d-m-Y h:i:s')
		);
		$result = $this->Umb_model->add_type_perusahaan($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('umb_type_perusahaan_ditambahkan');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
		exit;
	}
}

public function info_type_sukubangsa() {

	if($this->input->post('type')=='info_type_sukubangsa') {		

		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		if($this->input->post('type_sukubangsa')==='') {
			$Return['error'] = $this->lang->line('umb_type_sukubangsa_error_field');
		}
		if($Return['error']!=''){
			$this->output($Return);
		}
		$data = array(
			'type' => $this->input->post('type_sukubangsa'),
			'created_at' => date('d-m-Y h:i:s')
		);
		$result = $this->Umb_model->add_type_sukubangsa($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('umb_type_sukubangsa_sukses_ditambahkan');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
		exit;
	}
}

public function info_security_level() {

	if($this->input->post('type')=='info_security_level') {		

		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		if($this->input->post('security_level')==='') {
			$Return['error'] = $this->lang->line('umb_error_security_level_field');
		}
		if($Return['error']!=''){
			$this->output($Return);
		}
		$data = array(
			'name' => $this->input->post('security_level'),
			'created_at' => date('d-m-Y h:i:s')
		);
		$result = $this->Umb_model->add_security_level($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('umb_security_level_ditambahkan');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
		exit;
	}
}

public function info_type_pendapatan() {

	if($this->input->post('type')=='info_type_pendapatan') {		

		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		if($this->input->post('type_pendapatan')==='') {
			$Return['error'] = $this->lang->line('umb_field_type_pendapatan_error');
		}
		if($Return['error']!=''){
			$this->output($Return);
		}
		$data = array(
			'name' => $this->input->post('type_pendapatan'),
			'created_at' => date('d-m-Y h:i:s')
		);
		$result = $this->Umb_model->add_type_pendapatan($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('umb_type_pendapatan_sukses_ditambahkan');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
		exit;
	}
}

public function info_type_currency() {

	if($this->input->post('type')=='info_type_currency') {		

		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		if($this->input->post('name')==='') {
			$Return['error'] = $this->lang->line('umb_error_field_nama_currency');
		} else if($this->input->post('code')==='') {
			$Return['error'] = $this->lang->line('umb_error_field_code_currency');
		} else if($this->input->post('symbol')==='') {
			$Return['error'] = $this->lang->line('umb_error_field_symbol_currency');
		}
		if($Return['error']!=''){
			$this->output($Return);
		}
		$data = array(
			'name' => $this->input->post('name'),
			'code' => $this->input->post('code'),
			'symbol' => $this->input->post('symbol')
		);
		$result = $this->Umb_model->add_type_currency($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('umb_sukses_type_currency_ditambahkan');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
		exit;
	}
}

public function delete_type_kontrak() {

	if($this->input->post('type')=='delete_record') {

		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$result = $this->Umb_model->delete_record_type_kontrak($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('umb_sukses_type_kontrak_dihapus');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
	}
}

public function delete_type_document() {

	if($this->input->post('type')=='delete_record') {

		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$result = $this->Umb_model->delete_record_type_document($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('umb_sukses_type_document_dihapus');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
	}
}

public function delete_payment_method() {

	if($this->input->post('type')=='delete_record') {

		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$result = $this->Umb_model->delete_record_payment_method($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('umb_sukses_payment_method_dihapus');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
	}
}

public function delete_tingkat_pendidikan() {

	if($this->input->post('type')=='delete_record') {

		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$result = $this->Umb_model->delete_record_tingkat_pendidikan($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('umb_sukses_tingkat_pendidikan_dihapus');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
	}
}

public function delete_qualification_language() {

	if($this->input->post('type')=='delete_record') {

		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$result = $this->Umb_model->delete_record_qualification_language($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('umb_sukses_qualification_lang_dihapus');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
	}
}

public function delete_qualification_skill() {

	if($this->input->post('type')=='delete_record') {

		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$result = $this->Umb_model->delete_record_qualification_skill($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('umb_sukses_qualification_skill_dihapus');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
	}
}

public function delete_type_award() {

	if($this->input->post('type')=='delete_record') {

		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$result = $this->Umb_model->delete_record_type_award($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('umb_sukses_type_award_dihapus');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
	}
}

public function delete_type_cuti() {

	if($this->input->post('type')=='delete_record') {

		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$result = $this->Umb_model->delete_record_type_cuti($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('umb_sukses_type_cuti_dihapus');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
	}
}

public function delete_type_peringatan() {

	if($this->input->post('type')=='delete_record') {

		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$result = $this->Umb_model->delete_record_type_peringatan($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('umb_sukses_type_peringatan_dihapus');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
	}
}

public function delete_type_penghentian() {

	if($this->input->post('type')=='delete_record') {

		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$result = $this->Umb_model->delete_record_type_penghentian($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('umb_sukses_type_penghentian_dihapus');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
	}
}

public function delete_type_biaya() {

	if($this->input->post('type')=='delete_record') {

		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$result = $this->Umb_model->delete_record_type_biaya($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('umb_sukses_type_biaya_dihapus');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
	}
}

public function delete_type_pekerjaan() {

	if($this->input->post('type')=='delete_record') {
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$result = $this->Umb_model->delete_record_type_pekerjaan($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('umb_sukses_type_pekerjaan_dihapus');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
	}
}

public function delete_kategori_pekerjaan() {

	if($this->input->post('type')=='delete_record') {

		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$result = $this->Umb_model->delete_record_kategori_pekerjaan($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('umb_sukses_kategori_pekerjaan_dihapus');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
	}
}

public function delete_type_exit() {

	if($this->input->post('type')=='delete_record') {

		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$result = $this->Umb_model->delete_record_type_exit($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('umb_sukses_type_exit_dihapus');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
	}
}

public function delete_type_pngtrn_perjalanan() {

	if($this->input->post('type')=='delete_record') {

		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$result = $this->Umb_model->delete_record_type_pngtrn_perjalanan($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('umb_sukses_type_pngtrn_perjalanan_dihapus');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
	}
}

	// delete constant record > table
public function delete_type_sukubangsa() {

	if($this->input->post('type')=='delete_record') {

		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$result = $this->Umb_model->delete_record_type_sukubangsa($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('umb_type_sukubangsa_sukses_dihapus');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
	}
}

public function delete_type_pendapatan() {

	if($this->input->post('type')=='delete_record') {

		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$result = $this->Umb_model->delete_record_type_pendapatan($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('umb_type_pendapatan_sukses_dihapus');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
	}
}

public function delete_type_currency() {

	if($this->input->post('type')=='delete_record') {

		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$result = $this->Umb_model->delete_record_type_currency($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('umb_sukses_type_currency_dihapus');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
	}
}

public function delete_type_perusahaan() {

	if($this->input->post('type')=='delete_record') {

		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$result = $this->Umb_model->delete_record_type_perusahaan($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('umb_type_perusahaan_dihapus');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
	}
}

public function delete_security_level() {

	if($this->input->post('type')=='delete_record') {

		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$result = $this->Umb_model->delete_record_security_level($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('umb_security_level_dihapus');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
	}
}
public function read_constants() {

	$data['title'] = $this->Umb_model->site_title();
	$session = $this->session->userdata('username');
	if(!empty($session)){ 
		$this->load->view('admin/settings/dialog_constants', $data);
	} else {
		redirect('admin/');
	}
}

public function update_type_document() {

	if($this->input->post('type')=='edit_record') {
		$id = $this->uri->segment(4);
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		if($this->input->post('name')==='') {
			$Return['error'] = $this->lang->line('umb_karyawan_error_type_document');
		}
		if($Return['error']!=''){
			$this->output($Return);
		}
		$data = array(
			'type_document' => $this->input->post('name'),
			'perusahaan_id' => $this->input->post('perusahaan')
		);
		$result = $this->Umb_model->update_record_type_document($data,$id);		

		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('umb_sukses_type_document_diperbarui');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
		exit;
	}
}

public function update_type_sukubangsa() {

	if($this->input->post('type')=='edit_record') {
		$id = $this->uri->segment(4);
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		if($this->input->post('type_sukubangsa')==='') {
			$Return['error'] = $this->lang->line('umb_type_sukubangsa_error_field');
		}
		if($Return['error']!=''){
			$this->output($Return);
		}
		$data = array(
			'type' => $this->input->post('type_sukubangsa'),
		);
		$result = $this->Umb_model->update_record_type_sukubangsa($data,$id);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('umb_type_sukubangsa_sukses_diperbarui');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
		exit;
	}
}

public function update_type_pendapatan() {

	if($this->input->post('type')=='edit_record') {
		$id = $this->uri->segment(4);
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		if($this->input->post('type_pendapatan')==='') {
			$Return['error'] = $this->lang->line('umb_field_type_pendapatan_error');
		}
		if($Return['error']!=''){
			$this->output($Return);
		}
		$data = array(
			'name' => $this->input->post('type_pendapatan'),
		);
		$result = $this->Umb_model->update_record_type_pendapatan($data,$id);		

		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('umb_type_pendapatan_sukses_diperbarui');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
		exit;
	}
}

public function update_type_kontrak() {

	if($this->input->post('type')=='edit_record') {

		$id = $this->uri->segment(4);
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		if($this->input->post('name')==='') {
			$Return['error'] =$this->lang->line('umb_karyawan_error_type_kontrak');
		}
		if($Return['error']!=''){
			$this->output($Return);
		}
		$data = array(
			'name' => $this->input->post('name')
		);
		$result = $this->Umb_model->update_record_type_kontrak($data,$id);		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('umb_sukses_type_kontrak_diperbarui');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
		exit;
	}
}

public function update_payment_method() {

	if($this->input->post('type')=='edit_record') {
		$id = $this->uri->segment(4);
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		if($this->input->post('name')==='') {
			$Return['error'] = $this->lang->line('umb_error_payment_method');
		}
		if($Return['error']!=''){
			$this->output($Return);
		}
		$data = array(
			'method_name' => $this->input->post('name'),
			'payment_percentage' => $this->input->post('payment_percentage'),
			'nomor_account' => $this->input->post('nomor_account')
		);
		$result = $this->Umb_model->update_record_payment_method($data,$id);		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('umb_sukses_payment_method_diperbarui');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
		exit;
	}
}

public function update_tingkat_pendidikan() {

	if($this->input->post('type')=='edit_record') {

		$id = $this->uri->segment(4);
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		if($this->input->post('name')==='') {
			$Return['error'] = $this->lang->line('umb_error_tingkat_pendidikan');
		}
		if($Return['error']!=''){
			$this->output($Return);
		}
		$data = array(
			'name' => $this->input->post('name')
		);
		$result = $this->Umb_model->update_record_tingkat_pendidikan($data,$id);		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('umb_sukses_tingkat_pendidikan_diperbarui');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
		exit;
	}
}

public function update_qualification_language() {

	if($this->input->post('type')=='edit_record') {
		$id = $this->uri->segment(4);
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		if($this->input->post('name')==='') {
			$Return['error'] = $this->lang->line('umb_error_education_language');
		}
		if($Return['error']!=''){
			$this->output($Return);
		}
		$data = array(
			'name' => $this->input->post('name')
		);
		$result = $this->Umb_model->update_record_qualification_language($data,$id);		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('umb_error_tingkat_pendidikan');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
		exit;
	}
}

public function update_qualification_skill() {

	if($this->input->post('type')=='edit_record') {
		$id = $this->uri->segment(4);
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		if($this->input->post('name')==='') {
			$Return['error'] = $this->lang->line('umb_error_education_skill');
		}
		if($Return['error']!=''){
			$this->output($Return);
		}
		$data = array(
			'name' => $this->input->post('name')
		);
		$result = $this->Umb_model->update_record_qualification_skill($data,$id);		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('umb_sukses_qualification_skill_diperbarui');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
		exit;
	}
}

public function update_type_award() {

	if($this->input->post('type')=='edit_record') {
		$id = $this->uri->segment(4);
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		if($this->input->post('name')==='') {
			$Return['error'] = $this->lang->line('umb_award_error_type_award');
		}
		if($Return['error']!=''){
			$this->output($Return);
		}
		$data = array(
			'type_award' => $this->input->post('name')
		);
		$result = $this->Umb_model->update_record_type_award($data,$id);		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('umb_sukses_type_award_diperbarui');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
		exit;
	}
}

public function update_type_cuti() {

	if($this->input->post('type')=='edit_record') {
		$id = $this->uri->segment(4);
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		if($this->input->post('name')==='') {
			$Return['error'] = $this->lang->line('umb_error_type_cuti_field');
		} else if($this->input->post('days_per_year')==='') {
			$Return['error'] = $this->lang->line('umb_error_days_per_year');
		}
		if($Return['error']!=''){
			$this->output($Return);
		}
		$data = array(
			'type_name' => $this->input->post('name'),
			'days_per_year' => $this->input->post('days_per_year')
		);
		$result = $this->Umb_model->update_record_type_cuti($data,$id);		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('umb_sukses_type_cuti_diperbarui');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
		exit;
	}
}

public function update_type_peringatan() {

	if($this->input->post('type')=='edit_record') {

		$id = $this->uri->segment(4);
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		if($this->input->post('name')==='') {
			$Return['error'] = $this->lang->line('umb_karyawan_error_type_peringatan');
		}
		if($Return['error']!=''){
			$this->output($Return);
		}
		$data = array(
			'type' => $this->input->post('name')
		);
		$result = $this->Umb_model->update_record_type_peringatan($data,$id);		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('umb_sukses_type_peringatan_diperbarui');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
		exit;
	}
}

public function update_type_penghentian() {

	if($this->input->post('type')=='edit_record') {
		$id = $this->uri->segment(4);
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		if($this->input->post('name')==='') {
			$Return['error'] = $this->lang->line('umb_error_type_penghentian');
		}
		if($Return['error']!=''){
			$this->output($Return);
		}
		$data = array(
			'type' => $this->input->post('name')
		);
		$result = $this->Umb_model->update_record_type_penghentian($data,$id);		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('umb_sukses_type_penghentian_diperbarui');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
		exit;
	}
}

public function update_type_biaya() {

	if($this->input->post('type')=='edit_record') {
		$id = $this->uri->segment(4);
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		if($this->input->post('perusahaan')==='') {
			$Return['error'] = $this->lang->line('error_field_perusahaan');
		} else if($this->input->post('name')==='') {
			$Return['error'] = $this->lang->line('umb_error_type_biaya');
		}
		if($Return['error']!=''){
			$this->output($Return);
		}
		$data = array(
			'perusahaan_id' => $this->input->post('perusahaan'),
			'name' => $this->input->post('name')
		);
		$result = $this->Umb_model->update_record_type_biaya($data,$id);		

		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('umb_sukses_type_biaya_diperbarui');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
		exit;
	}
}

public function update_type_pekerjaan() {
	if($this->input->post('type')=='edit_record') {
		$id = $this->uri->segment(4);
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		if($this->input->post('name')==='') {
			$Return['error'] = $this->lang->line('umb_error_post_type_pekerjaan');
		}
		if($Return['error']!=''){
			$this->output($Return);
		}
		$data = array(
			'type' => $this->input->post('name')
		);
		$result = $this->Umb_model->update_record_type_pekerjaan($data,$id);		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('umb_sukses_type_pekerjaan_diperbarui');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
		exit;
	}
}


public function update_kategori_pekerjaan() {

	if($this->input->post('type')=='edit_record') {

		$id = $this->uri->segment(4);
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		if($this->input->post('kategori_pekerjaan')==='') {
			$Return['error'] = $this->lang->line('umb_error_kategori_pekerjaan');
		}
		if($Return['error']!=''){
			$this->output($Return);
		}
		$data = array(
			'nama_kategori' => $this->input->post('kategori_pekerjaan')
		);
		$result = $this->Umb_model->update_record_kategori_pekerjaan($data,$id);		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('umb_sukses_kategori_pekerjaan_diperbarui');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
		exit;
	}
}

public function update_type_exit() {

	if($this->input->post('type')=='edit_record') {

		$id = $this->uri->segment(4);
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		if($this->input->post('name')==='') {
			$Return['error'] = $this->lang->line('umb_error_type_exit');
		}
		if($Return['error']!=''){
			$this->output($Return);
		}
		$data = array(

			'type' => $this->input->post('name')
		);
		$result = $this->Umb_model->update_record_type_exit($data,$id);		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('umb_sukses_type_exit_diperbarui');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
		exit;
	}
}


public function update_type_pngtrn_perjalanan() {

	if($this->input->post('type')=='edit_record') {

		$id = $this->uri->segment(4);
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		if($this->input->post('name')==='') {
			$Return['error'] = $this->lang->line('umb_error_type_pengaturan_perjalanan');
		}
		if($Return['error']!=''){
			$this->output($Return);
		}
		$data = array(
			'type' => $this->input->post('name')
		);
		$result = $this->Umb_model->update_record_pngtrn_perjalanan($data,$id);		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('umb_sukses_perjalanan_arrtype_diperbarui');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
		exit;
	}
}

public function update_type_perusahaan() {

	if($this->input->post('type')=='edit_record') {

		$id = $this->uri->segment(4);
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		if($this->input->post('name')==='') {
			$Return['error'] = $this->lang->line('umb_error_ctype_field');
		}
		if($Return['error']!=''){
			$this->output($Return);
		}
		$data = array(
			'name' => $this->input->post('name')
		);
		$result = $this->Umb_model->update_record_type_perusahaan($data,$id);		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('umb_type_perusahaan_diperbarui');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
		exit;
	}
}

public function update_type_currency() {

	if($this->input->post('type')=='edit_record') {

		$id = $this->uri->segment(4);
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		if($this->input->post('name')==='') {
			$Return['error'] = $this->lang->line('umb_error_field_nama_currency');
		} else if($this->input->post('code')==='') {
			$Return['error'] = $this->lang->line('umb_error_field_code_currency');
		} else if($this->input->post('symbol')==='') {
			$Return['error'] = $this->lang->line('umb_error_field_symbol_currency');
		}
		if($Return['error']!=''){
			$this->output($Return);
		}
		$data = array(
			'name' => $this->input->post('name'),
			'code' => $this->input->post('code'),
			'symbol' => $this->input->post('symbol')
		);
		$result = $this->Umb_model->update_record_type_currency($data,$id);		

		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('umb_sukses_type_currency_diperbarui');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
		exit;
	}
}

public function update_payment_gateway() {

	if($this->input->post('type')=='payment_gateway') {
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$id = 1;
		$data = array(
			'paypal_email' => $this->input->post('paypal_email'),
			'paypal_sandbox' => $this->input->post('paypal_sandbox'),
			'paypal_active' => $this->input->post('paypal_active'),
			'stripe_secret_key' => $this->input->post('stripe_secret_key'),
			'stripe_publishable_key' => $this->input->post('stripe_publishable_key'),
			'stripe_active' => $this->input->post('stripe_active'),
			'online_payment_account' => $this->input->post('bank_cash_id'),
		);
		$result = $this->Umb_model->update_record_info_setting($data,$id);		

		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('umb_acc_info_payment_gateway_diperbarui');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
		exit;
	}
}	

public function update_security_level() {

	if($this->input->post('type')=='edit_record') {
		$id = $this->uri->segment(4);
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		if($this->input->post('security_level')==='') {
			$Return['error'] = $this->lang->line('umb_error_security_level_field');
		}
		if($Return['error']!=''){
			$this->output($Return);
		}
		$data = array(
			'name' => $this->input->post('security_level')
		);
		$result = $this->Umb_model->update_record_security_level($data,$id);		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('umb_security_level_diperbarui');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
		exit;
	}
}

public function info_performance() {

	if($this->input->post('type')=='info_performance') {


		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();

		if($this->input->post('technical_competencies')==='') {
			$Return['error'] = $this->lang->line('umb_performance_technical_error_field');
		} else if($this->input->post('organizational_competencies')==='') {
			$Return['error'] = $this->lang->line('umb_performance_org_error_field');
		}

		if($Return['error']!=''){
			$hrm_f->output($Return);
		}
		$technical_competencies = str_replace(array('php', '', 'js', '','html', ''), '',$this->input->post('technical_competencies'));
		$organizational_competencies = str_replace(array('php', '', 'js', '','html', ''), '',$this->input->post('organizational_competencies'));
		$id = 1;
		$data = array(
			'technical_competencies' => $technical_competencies,
			'organizational_competencies' => $organizational_competencies,
			'performance_option' => $this->input->post('performance_option')
		);
		$result = $this->Umb_model->update_record_info_setting($data,$id);		

		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('umb_sukses_performance_config_diperbarui');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
		exit;
	}
}
}
