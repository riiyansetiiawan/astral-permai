<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Theme extends MY_Controller {

	public function output($Return=array()){
		
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		
		exit(json_encode($Return));
	}
	
	public function __construct() {
		parent::__construct();

		$this->load->model('Perusahaan_model');
		$this->load->model('Umb_model');
	}

	public function index() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('umb_theme_settings').' | '.$this->Umb_model->site_title();
		$setting = $this->Umb_model->read_setting_info(1);
		$info_perusahaan = $this->Umb_model->read_info_setting_perusahaan(1);
		$theme_info = $this->Umb_model->read_theme_info(1);
		$data = array(
			'title' => $this->lang->line('umb_theme_settings').' | '.$this->Umb_model->site_title(),
			'info_perusahaan_id' => $info_perusahaan[0]->info_perusahaan_id,
			'logo' => $info_perusahaan[0]->logo,
			'logo_second' => $info_perusahaan[0]->logo_second,
			'favicon' => $info_perusahaan[0]->favicon,
			'sign_in_logo' => $info_perusahaan[0]->sign_in_logo,
			'logo_pekerjaan' => $setting[0]->logo_pekerjaan,
			'logo_payroll' => $setting[0]->logo_payroll,
			'notification_position' => $setting[0]->notification_position,
			'notification_close_btn' => $setting[0]->notification_close_btn,
			'notification_bar' => $setting[0]->notification_bar,
			//'fixed_layout' => $theme_info[0]->fixed_layout,
			//'fixed_footer' => $theme_info[0]->fixed_footer,
			//'boxed_layout' => $theme_info[0]->boxed_layout,
			'page_header' => $theme_info[0]->page_header,
			'footer_layout' => $theme_info[0]->footer_layout,
			'statistics_cards' => $theme_info[0]->statistics_cards,
			'dashboard_option' => $theme_info[0]->dashboard_option,
			'dashboard_calendar' => $theme_info[0]->dashboard_calendar,
			'login_page_options' => $theme_info[0]->login_page_options,
			//'compact_menu' => $theme_info[0]->compact_menu,
			//'flipped_menu' => $theme_info[0]->flipped_menu,
			//'right_side_icons' => $theme_info[0]->right_side_icons,
			//'bordered_menu' => $theme_info[0]->bordered_menu,
			'form_design' => $theme_info[0]->form_design,
			'astyle' => $theme_info[0]->animation_style,
			'theme_option' => $theme_info[0]->theme_option,
			'sub_menu_icons' => $theme_info[0]->sub_menu_icons,
			//'is_semi_dark' => $theme_info[0]->is_semi_dark,
			'export_orgchart' => $theme_info[0]->export_orgchart,
			'export_file_title' => $theme_info[0]->export_file_title,
			'org_chart_layout' => $theme_info[0]->org_chart_layout,
			'org_chart_zoom' => $theme_info[0]->org_chart_zoom,
			'org_chart_pan' => $theme_info[0]->org_chart_pan,
			'all_negaraa' => $this->Umb_model->get_negaraa()
		);
		$data['breadcrumbs'] = $this->lang->line('umb_theme_settings');
		$data['path_url'] = 'theme_settings';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('94',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/theme/theme_settings", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}
	
	public function page_layouts() {

		if($this->input->post('type')=='info_page_layouts') {

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			if($this->input->post('statistics_cards')==='') {
				$Return['error'] = $this->lang->line('umb_error_thm_statistics_cards');
			} else if($this->input->post('dashboard_option')==='') {
				$Return['error'] = $this->lang->line('umb_hrastral_dashboard_options_error_field');
			} else if($this->input->post('login_page_options')==='') {
				$Return['error'] = $this->lang->line('umb_hrastral_login_page_options_error_field');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$id = 1;
			$data = array(
				'statistics_cards' => $this->input->post('statistics_cards'),
				'dashboard_option' => $this->input->post('dashboard_option'),
				'dashboard_calendar' => $this->input->post('dashboard_calendar'),
				'login_page_options' => $this->input->post('login_page_options'),
				'text_page_login' => $this->input->post('text_page_login'),
			);
			$result = $this->Umb_model->update_record_info_theme($data,$id);		
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_thm_page_layouts_diperbarui');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function nav_menu() {

		if($this->input->post('type')=='nav_menu_info') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = 1;
			$data = array(
				'compact_menu' => $this->input->post('compact_menu'),
				'flipped_menu' => $this->input->post('flipped_menu'),
				'right_side_icons' => $this->input->post('right_side_icons'),
				'bordered_menu' => $this->input->post('bordered_menu')
			);
			$result = $this->Umb_model->update_record_info_theme($data,$id);		
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_thm_nav_menu_diperbarui');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function form_design() {

		if($this->input->post('type')=='form_design_info') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			if($this->input->post('form_design')==='') {
				$Return['error'] = $this->lang->line('umb_error_thm_form_design');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$id = 1;
			
			$data = array(
				'form_design' => $this->input->post('form_design')
			);
			$result = $this->Umb_model->update_record_info_theme($data,$id);		
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_thm_form_design_diperbarui');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function color_system() {

		if($this->input->post('type')=='color_system_info') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			if($this->input->post('nav_sdark_color')==='') {
				$Return['error'] = $this->lang->line('umb_error_thm_select_semi_dark_clr');
			} else if($this->input->post('nav_dark_color')==='') {
				$Return['error'] = $this->lang->line('umb_error_thm_select_dark_clr');
			} else if($this->input->post('menu_color_option')==='') {
				$Return['error'] = $this->lang->line('umb_error_thm_select_menu_clr_opt');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$id = 1;
			
			$data = array(
				'semi_dark_color' => $this->input->post('nav_sdark_color'),
				'top_nav_dark_color' => $this->input->post('nav_dark_color'),
				'menu_color_option' => $this->input->post('menu_color_option'),
				'is_semi_dark' => $this->input->post('is_semi_dark')
			);
			$result = $this->Umb_model->update_record_info_theme($data,$id);		

			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_thm_system_color_diperbarui');
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
	
	public function info_logo() {

		if($this->input->post('type')=='info_logo') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = 1;
			if($_FILES['p_file']['size'] == 0) {
				$Return['error'] = $this->lang->line('umb_error_pilih_logo_pertama');
			} 
			else if($_FILES['favicon']['size'] == 0) {
				$Return['error'] = $this->lang->line('umb_error_pilih_favicon');
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
				'logo' => $fname,
				'favicon' => $fname3
			);
			$result = $this->Umb_model->update_record_info_perusahaan($data,$id);	
			if ($result == TRUE) {
				$Return['img'] = $set_img.$fname;
				$Return['img3'] = $set_img3.$fname3;
				$Return['result'] = $this->lang->line('umb_sukses_system_logo_diperbarui');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function sign_in_logo() {

		if($this->input->post('type')=='singin_logo') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = 1;
			if($_FILES['p_file3']['size'] == 0) {
				$Return['error'] = $this->lang->line('umb_error_select_signin_page_logo');
			} else {
				if(is_uploaded_file($_FILES['p_file3']['tmp_name'])) {
					$allowed =  array('png','jpg','jpeg','pdf','gif');
					$filename = $_FILES['p_file3']['name'];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);
					if(in_array($ext,$allowed)){
						$tmp_name = $_FILES["p_file3"]["tmp_name"];
						$profile = "uploads/logo/signin/";
						$set_img = base_url()."uploads/logo/signin/";
						$name = basename($_FILES["p_file3"]["name"]);
						$newfilename = 'signin_logo_'.round(microtime(true)).'.'.$ext;
						move_uploaded_file($tmp_name, $profile.$newfilename);
						$fname = $newfilename;			
						$data = array(
							'sign_in_logo' => $fname
						);
						$result = $this->Umb_model->update_record_info_perusahaan($data,$id);	
						if ($result == TRUE) {
							$Return['img'] = $set_img.$fname;
							$Return['result'] = $this->lang->line('umb_sukses_signin_page_logo_diperbarui');
						} else {
							$Return['error'] = $this->lang->line('umb_error_msg');
						}
						$this->output($Return);
						exit;	

					} else {
						$Return['error'] = $this->lang->line('umb_error_attatchment_type');
					}
				}
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
		}
	}

	public function logo_payroll() {

		if($this->input->post('type')=='ilogo_payroll') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = 1;
			if($_FILES['p_file5']['size'] == 0) {
				$Return['error'] = $this->lang->line('umb_error_payroll_pdf_logo');
			} else {
				if(is_uploaded_file($_FILES['p_file5']['tmp_name'])) {
					$allowed =  array('png','jpg','jpeg','pdf','gif');
					$filename = $_FILES['p_file5']['name'];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);
					if(in_array($ext,$allowed)){
						$tmp_name = $_FILES["p_file5"]["tmp_name"];
						$profile = "uploads/logo/payroll/";
						$set_img = base_url()."uploads/logo/payroll/";
						$name = basename($_FILES["p_file5"]["name"]);
						$newfilename = 'logo_payroll_'.round(microtime(true)).'.'.$ext;
						move_uploaded_file($tmp_name, $profile.$newfilename);
						$fname = $newfilename;			
						$data = array(
							'logo_payroll' => $fname
						);
						$result = $this->Umb_model->update_record_info_setting($data,$id);	
						if ($result == TRUE) {
							$Return['img'] = $set_img.$fname;
							$Return['result'] = $this->lang->line('umb_sukses_logo_payroll_diperbarui');
						} else {
							$Return['error'] = $this->lang->line('umb_error_msg');
						}
						$this->output($Return);
						exit;	
					} else {
						$Return['error'] = $this->lang->line('umb_error_attatchment_type');
					}
				}
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
		}
	}

	public function logo_pekerjaan() {

		if($this->input->post('type')=='logo_pekerjaan') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = 1;
			if($_FILES['p_file4']['size'] == 0) {
				$Return['error'] = $this->lang->line('umb_error_recruitment_logo');
			} else {
				if(is_uploaded_file($_FILES['p_file4']['tmp_name'])) {
					$allowed =  array('png','jpg','jpeg','gif');
					$filename = $_FILES['p_file4']['name'];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);
					if(in_array($ext,$allowed)){
						$tmp_name = $_FILES["p_file4"]["tmp_name"];
						$profile = "uploads/logo/pekerjaan/";
						$set_img = base_url()."uploads/logo/pekerjaan/";
						$name = basename($_FILES["p_file4"]["name"]);
						$newfilename = 'logo_pekerjaan_'.round(microtime(true)).'.'.$ext;
						move_uploaded_file($tmp_name, $profile.$newfilename);
						$fname = $newfilename;			
						$data = array(
							'logo_pekerjaan' => $fname
						);
						$result = $this->Umb_model->update_record_info_setting($data,$id);	
						if ($result == TRUE) {
							$Return['img'] = $set_img.$fname;
							$Return['result'] = $this->lang->line('umb_recruitment_logo_diperbarui');
						} else {
							$Return['error'] = $this->lang->line('umb_error_msg');
						}
						$this->output($Return);
						exit;
					} else {
						$Return['error'] = $this->lang->line('umb_error_attatchment_type');
					}
				}
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
		}
	}

	public function orgchart() {

		if($this->input->post('type')=='orgchart_info') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			if($this->input->post('export_orgchart')==='') {
				$Return['error'] = $this->lang->line('umb_sukses_thm_export_chart');
			} else if($this->input->post('export_file_title')==='') {
				$Return['error'] = $this->lang->line('umb_error_thm_export_file_title_field');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$id = 1;
			$data = array(
				'org_chart_layout' => $this->input->post('org_chart_layout'),
				'export_orgchart' => $this->input->post('export_orgchart'),
				'org_chart_zoom' => $this->input->post('org_chart_zoom'),
				'org_chart_pan' => $this->input->post('org_chart_pan'),
				'export_file_title' => $this->input->post('export_file_title')
			);
			$result = $this->Umb_model->update_record_info_theme($data,$id);		
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_org_chart_info_diperbarui');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}	
} 
?>