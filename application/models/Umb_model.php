<?php

class Umb_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	
	public function read_info_location($id) {

		$sql = 'SELECT * FROM umb_location_kantor WHERE location_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function is_logged_in($id) {
		$CI =& get_instance();
		$is_logged_in = $CI->session->userdata($id);
		return $is_logged_in;       
	}
	
	public function generate_random_string($length = 7) {
		$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
	
	public function generate_random_karyawanid($length = 6) {
		$characters = '0123456789';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}

	public function generate_random_pincode($length = 6) {
		$characters = '0123456789';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
	
	public function get_negaraa(){
		$query = $this->db->query("SELECT * from umb_negaraa");
		return $query->result();
	}
	
	public function clean_post($post_name) {
		$name = trim($post_name);
		$Evalue = array('-','alert','<script>','</script>','</php>','<php>','<p>','\r\n','\n','\r','=',"'",'/','cmd','!',"('","')", '|');
		$post_name = str_replace($Evalue, '', $name); 
		$post_name = preg_replace('/^(\d{1,2}[^0-9])/m', '', $post_name);
	  // $post_name = htmlspecialchars(trim($post_name), ENT_QUOTES, "UTF-8");
		return $post_name;
	}
	
	public function clean_date_post($post_name) {
		$name = trim($post_name);
		$Evalue = array('alert','<script>','</script>','</php>','<php>','<p>','\r\n','\n','\r','=',"'",'/','cmd','!',"('","')", '|');
		$post_name = str_replace($Evalue, '', $name); 
		$post_name = preg_replace('/^(\d{1,2}[^0-9])/m', '', $post_name);
		$post_name = htmlspecialchars(trim($post_name), ENT_QUOTES, "UTF-8");
		return $post_name;
	}

	public function form_button_class() {
		return 'btn btn-primary';
	}

	public function validate_date($dateStr, $format){
		date_default_timezone_set('UTC');
		$date = DateTime::createFromFormat($format, $dateStr);
		return $date && ($date->format($format) === $dateStr);
	}

	private function validate_numbers_only($value) {
		return preg_match('/^([0-9]*)$/', $value);
	}

	public function select_module_class($mClass,$mMethod) {
		$arr = array();
		// dashboard
		if($mClass=='dashboard') {
			$arr['active'] = 'active';
			$arr['open'] = '';
			return $arr;
		} else if($mClass=='department' && $mMethod=='sub_departments') {
			$arr['sub_departments_active'] = 'active';
			$arr['adm_open'] = 'open';
			return $arr;
		} else if($mClass=='department') {
			$arr['dep_active'] = 'active';
			$arr['adm_open'] = 'open';
			return $arr;
		} else if($mClass=='penunjukan') {
			$arr['des_active'] = 'active';
			$arr['adm_open'] = 'open';
			return $arr;
		} else if($mClass=='perusahaan' && $mMethod=='documents_resmi') {
			$arr['documents_resmi_active'] = 'active';
			$arr['files_open'] = 'open';
			return $arr;
		} else if($mClass=='perusahaan') {
			$arr['prshn_active'] = 'active';
			$arr['adm_open'] = 'open';
			return $arr;
		} else if($mClass=='location') {
			$arr['lok_active'] = 'active';
			$arr['adm_open'] = 'open';
			return $arr;
		} else if($mClass=='kebijakan') {
			$arr['kbjk_active'] = 'active';
			$arr['adm_open'] = 'open';
			return $arr;
		} else if($mClass=='biaya') {
			$arr['exp_active'] = 'active';
			$arr['adm_open'] = 'open';
			return $arr;
		} else if($mClass=='pengumuman') {
			$arr['pngmmn_active'] = 'active';
			$arr['adm_open'] = 'open';
			return $arr;
		} else if($mClass=='karyawans' && $mMethod=='dashboard_staff') {
			$arr['staff_active'] = 'active';
			$arr['stff_open'] = 'open';
			return $arr;
		} else if($mClass=='karyawans' && $mMethod=='hr') {
			$arr['hrkrywn_active'] = 'active';
			$arr['stff_open'] = 'open';
			return $arr;
		} else if($mClass=='karyawans' && $mMethod=='documents_kadaluarsa') {
			$arr['documents_kadaluarsa_active'] = 'active';
			$arr['files_open'] = 'open';
			return $arr;
		} else if($mClass=='karyawans' && $mMethod=='import') {
			$arr['importkrywn_active'] = 'active';
			$arr['stff_open'] = 'open';
			return $arr;
		} else if($mClass=='karyawans') {
			$arr['hrkrywn_active'] = 'active';
			$arr['stff_open'] = 'open';
			return $arr;
		} /*else if($mClass=='custom_fields') {
			$arr['custom_fields_active'] = 'active';
			$arr['stff_open'] = 'active';
			return $arr;
		}*/ else if($mClass=='awards') {
			$arr['award_active'] = 'active';
			$arr['krywn_open'] = 'open';
			return $arr;
		} else if($mClass=='transfers') {
			$arr['tra_active'] = 'active';
			$arr['krywn_open'] = 'open';
			return $arr;
		} else if($mClass=='pengunduran_diri') {
			$arr['pngndr_dr_active'] = 'active';
			$arr['krywn_open'] = 'open';
			return $arr;
		} else if($mClass=='perjalanan') {
			$arr['prjln_active'] = 'active';
			$arr['krywn_open'] = 'open';
			return $arr;
		} else if($mClass=='promotion') {
			$arr['pro_active'] = 'active';
			$arr['krywn_open'] = 'open';
			return $arr;
		} else if($mClass=='keluhans') {
			$arr['keluh_active'] = 'active';
			$arr['krywn_open'] = 'open';
			return $arr;
		} else if($mClass=='peringatan') {
			$arr['prgtn_active'] = 'active';
			$arr['krywn_open'] = 'open';
			return $arr;
		} else if($mClass=='penghentian') {
			$arr['term_active'] = 'active';
			$arr['krywn_open'] = 'open';
			return $arr;
		} else if($mClass=='karyawans_terakhir_login') {
			$arr['krywn_ter_lgn_active'] = 'active';
			$arr['krywn_open'] = 'open';
			return $arr;
		} else if($mClass=='karyawan_exit') {
			$arr['krywn_ex_active'] = 'active';
			$arr['krywn_open'] = 'open';
			return $arr;
		} else if($mMethod=='kategori' && $mClass=='assets') {
			$arr['kat_asst_active'] = 'active';
			$arr['asst_open'] = 'open';
			return $arr;
		} else if($mClass=='assets') {
			$arr['asst_active'] = 'active';
			$arr['asst_open'] = 'open';
			return $arr;
		} else if($mClass=='chat') {
			$arr['chat_active'] = 'active';
			return $arr;
		} else if($mClass=='timesheet' && $mMethod=='kehadiran') {
			$arr['attnd_active'] = 'active';
			$arr['attnd_open'] = 'open';
			return $arr;
		} else if($mClass=='timesheet' && $mMethod=='timecalendar') {
			$arr['timecalendar_active'] = 'active';
			$arr['attnd_open'] = 'open';
			return $arr;
		} else if($mMethod=='tanggal_bijaksana_kehadiran') {
			$arr['attnd_active'] = 'active';
			$arr['attnd_open'] = 'open';
			return $arr;
		} else if($mMethod=='update_kehadiran') {
			$arr['upd_attnd_active'] = 'active';
			$arr['attnd_open'] = 'open';
			return $arr;
		} else if($mClass=='permintaan_lembur') {
			$arr['permintaan_lembur_act'] = 'active';
			$arr['attnd_open'] = 'open';
			return $arr;
		} else if($mClass=='timesheet' && $mMethod=='dashboard_kehadiran') {
			$arr['dashboard_kehadiran_active'] = 'active';
			$arr['attnd_open'] = 'open';
			return $arr;
		} else if($mClass=='timesheet' && $mMethod=='import') {
			$arr['import_khdrn_active'] = 'active';
			$arr['attnd_open'] = 'open';
			return $arr;
		} else if($mMethod=='shift_kantor' && $mClass=='timesheet') {
			$arr['shift_active'] = 'active';
			$arr['stff_open'] = 'open';
			return $arr;
		} else if($mMethod=='liburan' && $mClass=='timesheet') {
			$arr['lbr_active'] = 'active';
			//$arr['attnd_open'] = 'open';
			return $arr;
		} else if($mMethod=='leave' && $mClass=='timesheet') {
			$arr['cuti_active'] = 'active';
			//$arr['attnd_open'] = 'open';
			return $arr;
		} else if($mMethod=='details_cuti' && $mClass=='timesheet') {
			$arr['cuti_active'] = 'active';
			//$arr['attnd_open'] = 'open';
			return $arr;
		} else if($mClass=='timesheet' && $mMethod=='index') {
			$arr['timesheet_active'] = 'active';
			$arr['attnd_open'] = 'open';
			return $arr;
		} else if($mClass=='calendar' && $mMethod=='kehadiran') {
			$arr['cal_khdrn_active'] = 'active';
			$arr['attnd_open'] = 'open';
			return $arr;
		} else if($mMethod=='upahh_perjam') {
			$arr['pay_hourly_active'] = 'active';
			$arr['payrl_open'] = 'open';
			return $arr;
		} else if($mMethod=='templates') {
			$arr['pay_temp_active'] = 'active';
			$arr['payrl_open'] = 'open';
			return $arr;
		} else if($mMethod=='manage_gaji') {
			$arr['pay_mang_active'] = 'active';
			$arr['payrl_open'] = 'open';
			return $arr;
		} else if($mClass=='payroll' && $mMethod=='slipgaji') {
			$arr['pay_generate_active'] = 'active';
			$arr['payrl_open'] = 'open';
			return $arr;
		} else if($mMethod=='generate_slipgaji') {
			$arr['pay_generate_active'] = 'active';
			$arr['payrl_open'] = 'open';
			return $arr;
		} else if($mMethod=='history_pembayaran') {
			$arr['pay_generate_active'] = 'active';
			//$arr['hr_acc_open'] = 'open';
			return $arr;
		} else if($mMethod=='currency_converter') {
			$arr['curren_conv_active'] = 'active';
			$arr['payrl_open'] = 'open';
			return $arr;
		} else if($mMethod=='advance_gaji') {
			$arr['pay_advn_active'] = 'active';
			$arr['payrl_open'] = 'open';
			return $arr;
		} else if($mMethod=='laporan_advance_gaji') {
			$arr['pay_advn_rpt_active'] = 'active';
			$arr['payrl_open'] = 'open';
			return $arr;
		} else if($mClass=='performance_indicator') {
			$arr['performance_active'] = 'active';
			$arr['performance_open'] = 'open';
			return $arr;
		} else if($mClass=='performance_report') {
			$arr['performance_active'] = 'active';
			$arr['performance_open'] = 'open';
			return $arr;
		} else if($mClass=='performance_maingoals') {
			$arr['performance_active'] = 'active';
			$arr['performance_open'] = 'open';
			return $arr;
		} else if($mClass=='performance_appraisal') {
			$arr['performance_active'] = 'active';
			$arr['performance_open'] = 'open';
			return $arr;
		} else if($mClass=='organization' && $mMethod=='chart') {
			$arr['org_chart_active'] = 'active';
			$arr['adm_open'] = 'open';
			return $arr;
		} else if($mClass=='calendar' && $mMethod=='hr') {
			$arr['calendar_hr_active'] = 'active';
			return $arr;
		} else if($mClass=='tickets') {
			$arr['ticket_active'] = 'active';
			return $arr;
		} else if($mMethod=='calendar' && $mClass=='cuti') {
			$arr['cuti_cal_active'] = 'active';
			$arr['cuti_open'] = 'open';
			return $arr;
		} else if($mClass=='project' && $mMethod=='dashboard_projects') {
			$arr['dashboard_projects_active'] = 'active';
			$arr['project_open'] = 'open';
			return $arr;
		} else if($mMethod=='scrum_board_projects' && $mClass=='project') {
			$arr['scrum_board_projects_active'] = 'active';
			$arr['project_open'] = 'open';
			return $arr;
		} else if($mMethod=='scrum_board_tugass' && $mClass=='project') {
			$arr['scrum_board_tugass_active'] = 'active';
			$arr['tugas_open'] = 'open';
			return $arr;
		} else if($mMethod=='calendar_tugass' && $mClass=='project') {
			$arr['calendar_tugass_active'] = 'active';
			$arr['tugas_open'] = 'open';
			return $arr;
		} else if($mMethod=='calendar_projects' && $mClass=='project') {
			$arr['calendar_projects_active'] = 'active';
			$arr['project_open'] = 'open';
			return $arr;
		} else if($mMethod=='timelogs' && $mClass=='project') {
			$arr['project_timelogs_active'] = 'active';
			$arr['project_open'] = 'open';
			return $arr;
		} else if($mMethod=='timelogs' && $mClass=='quoted_projects') {
			$arr['timelogs_quotes_active'] = 'active';
			$arr['hr_quote_manager_open'] = 'open';
			return $arr;
		} else if($mMethod=='quote_calendar' && $mClass=='quoted_projects') {
			$arr['quote_calendar_active'] = 'active';
			$arr['hr_quote_manager_open'] = 'open';
			return $arr;
		} else if($mMethod=='kategoris_tugas' && $mClass=='project') {
			$arr['tugas_cat_active'] = 'active';
			$arr['project_open'] = 'open';
			return $arr;
		}  else if($mClass=='project') {
			$arr['project_active'] = 'active';
			$arr['project_open'] = 'open';
			return $arr;
		} else if($mClass=='projects') {
			$arr['projects_active'] = 'active';
			$arr['projects_active'] = 'open';
			return $arr;
		} else if($mMethod=='tugass' && $mClass=='timesheet') {
			$arr['tugas_active'] = 'active';
			$arr['tugas_open'] = 'open';
			return $arr;
		} else if($mMethod=='details_tugas') {
			$arr['tugas_active'] = 'active';
			$arr['tugas_open'] = 'open';
			return $arr;
		} else if($mClass=='clients') {
			$arr['clients_active'] = 'active';
			$arr['project_open'] = 'open';
			return $arr;
		} else if($mMethod=='import' && $mClass=='leads') {
			$arr['hr_import_leads_active'] = 'active';
			$arr['hr_quote_manager_open'] = 'open';
			return $arr;
		} else if($mClass=='leads') {
			$arr['leadsl_quotes_active'] = 'active';
			$arr['hr_quote_manager_open'] = 'open';
			return $arr;
		} else if($mMethod=='create' && $mClass=='invoices') {
			$arr['hr_create_inv_active'] = 'active';
			$arr['invoices_open'] = 'open';
			return $arr;
		} else if($mMethod=='create' && $mClass=='quotes') {
			$arr['all_quotes_active'] = 'active';
			$arr['hr_quote_manager_open'] = 'open';
			return $arr;
		} else if($mMethod=='pajaks' && $mClass=='invoices') {
			$arr['pajaks_inv_active'] = 'active';
			$arr['invoices_open'] = 'open';
			return $arr;
		} else if($mMethod=='history_pembayarans' && $mClass=='invoices') {
			$arr['history_pembayarans_inv_active'] = 'active';
			$arr['invoices_open'] = 'open';
			return $arr;
		} else if($mClass=='quoted_projects') {
			$arr['quoted_projects_active'] = 'active';
			$arr['hr_quote_manager_open'] = 'open';
			return $arr;
		} else if($mMethod=='calendar_invoice' && $mClass=='invoices') {
			$arr['calendar_invoice_active'] = 'active';
			$arr['invoices_open'] = 'open';
			return $arr;
		} else if($mClass=='invoices') {
			$arr['invoices_inv_active'] = 'active';
			$arr['invoices_open'] = 'open';
			return $arr;
		} else if($mClass=='quotes') {
			$arr['all_quotes_active'] = 'active';
			$arr['hr_quote_manager_open'] = 'open';
			return $arr;
		} else if($mClass=='files') {
			$arr['file_active'] = 'active';
			$arr['files_open'] = 'open';
			return $arr;
		} else if($mClass=='import') {
			$arr['import_active'] = 'active';
			return $arr;
		}  else if($mClass=='post_pekerjaan' && $mMethod=='pages') {
			$arr['pages_pkrj_active'] = 'active';
			$arr['recruit_open'] = 'open';
			return $arr;
		} else if($mClass=='post_pekerjaan' && $mMethod=='employer') {
			$arr['jb_employer_active'] = 'active';
			$arr['recruit_open'] = 'open';
			return $arr;
		} else if($mClass=='post_pekerjaan') {
			$arr['post_pkrj_active'] = 'active';
			$arr['recruit_open'] = 'open';
			return $arr;
		} else if($mClass=='kandidats_pekerjaan') {
			$arr['kandidats_pekerjaan_active'] = 'active';
			$arr['recruit_open'] = 'open';
			return $arr;
		} else if($mClass=='interviews_pekerjaan') {
			$arr['post_pkrj_active'] = 'active';
			$arr['recruit_open'] = 'open';
			return $arr;
		} else if($mClass=='training') {
			$arr['training_active'] = 'active';
			$arr['training_open'] = 'open';
			return $arr;
		} else if($mClass=='type_training') {
			$arr['type_training_active'] = 'active';
			$arr['training_open'] = 'open';
			return $arr;
		} else if($mClass=='trainers') {
			$arr['trainers_active'] = 'active';
			$arr['training_open'] = 'open';
			return $arr;
		} else if($mClass=='users') {
			$arr['users_active'] = 'active';
			$arr['system_open'] = 'open';
			return $arr;
		} else if($mClass=='roles') {
			$arr['roles_active'] = 'active';
			$arr['stff_open'] = 'open';
			return $arr;
		} else if($mMethod=='constants' && $mClass=='settings') {
			$arr['constants_active'] = 'active';
			$arr['system_open'] = 'open';
			return $arr;
		} else if($mMethod=='database_backup' && $mClass=='settings') {
			$arr['db_active'] = 'active';
			$arr['system_open'] = 'open';
			return $arr;
		} else if($mMethod=='email_template' && $mClass=='settings') {
			$arr['email_template_active'] = 'active';
			$arr['system_open'] = 'open';
			return $arr;
		} else if($mMethod=='modules' && $mClass=='settings') {
			$arr['modules_active'] = 'active';
			$arr['system_open'] = 'open';
			return $arr;
		} else if($mClass=='theme') {
			$arr['theme_active'] = 'active';
			$arr['system_open'] = 'open';
			return $arr;
		} else if($mClass=='settings') {
			$arr['settings_active'] = 'active';
			$arr['system_open'] = 'open';
			return $arr;
		} else if($mMethod=='changelog') {
			$arr['changelog_active'] = 'active';
			return $arr;
		} else if($mClass=='languages') {
			$arr['languages_active'] = 'active';
			$arr['system_open'] = 'open';
			return $arr;
		} else if($mClass=='events' && $mMethod=='calendar') {
			$arr['hr_ecalendar_active'] = 'active';
			$arr['hr_events_open'] = 'open';
			return $arr;
		} else if($mClass=='meetings') {
			$arr['hr_meetings_active'] = 'active';
			$arr['hr_events_open'] = 'open';
			return $arr;
		} else if($mClass=='events') {
			$arr['hr_events_active'] = 'active';
			$arr['hr_events_open'] = 'open';
			return $arr;
		} else if($mClass=='tujuan_tracking' && $mMethod=='calendar') {
			$arr['performance_active'] = 'active';
			$arr['performance_open'] = 'open';
			return $arr;
		} else if($mClass=='tujuan_tracking' && $mMethod=='type') {
			$arr['performance_active'] = 'active';
			$arr['performance_open'] = 'open';
			return $arr;
		} else if($mClass=='tujuan_tracking') {
			$arr['performance_active'] = 'active';
			$arr['performance_open'] = 'open';
			return $arr;
		} else if($mClass=='laporans'   && $mMethod=='karyawan_cuti') {
			$arr['cuti_active'] = 'active';
			//$arr['attnd_open'] = 'open';
			return $arr;
		} else if($mClass=='laporans'   && $mMethod=='slipgaji') {
			$arr['laporans_active'] = 'active';
			$arr['laporans_open'] = 'open';
			return $arr;
		} else if($mClass=='laporans'   && $mMethod=='kehadiran_karyawan') {
			$arr['laporans_active'] = 'active';
			$arr['laporans_open'] = 'open';
			return $arr;
		} else if($mClass=='laporans'   && $mMethod=='karyawan_training') {
			$arr['laporans_active'] = 'active';
			$arr['laporans_open'] = 'open';
			return $arr;
		} else if($mClass=='laporans'   && $mMethod=='projects') {
			$arr['laporans_active'] = 'active';
			$arr['laporans_open'] = 'open';
			return $arr;
		} else if($mClass=='laporans'   && $mMethod=='tugass') {
			$arr['laporans_active'] = 'active';
			$arr['laporans_open'] = 'open';
			return $arr;
		} else if($mClass=='laporans'   && $mMethod=='roles') {
			$arr['laporans_active'] = 'active';
			$arr['laporans_open'] = 'open';
			return $arr;
		} else if($mClass=='laporans'   && $mMethod=='karyawans') {
			$arr['laporans_active'] = 'active';
			$arr['laporans_open'] = 'open';
			return $arr;
		} else if($mClass=='laporans' ) {
			$arr['laporans_active'] = 'active';
			return $arr;
		} else if($mClass=='user' && $mMethod=='awards') {
			$arr['hr_awards_active'] = 'active';
			$arr['mylink_open'] = 'open';
			return $arr;
		} else if($mClass=='user' && $mMethod=='transfer') {
			$arr['hr_transfer_active'] = 'active';
			$arr['mylink_open'] = 'open';
			return $arr;
		} else if($mClass=='user' && $mMethod=='promotion') {
			$arr['hr_promotion_active'] = 'active';
			$arr['mylink_open'] = 'open';
			return $arr;
		} else if($mClass=='user' && $mMethod=='keluhans') {
			$arr['hr_keluhans_active'] = 'active';
			$arr['mylink_open'] = 'open';
			return $arr;
		} else if($mClass=='user' && $mMethod=='peringatan') {
			$arr['hr_peringatan_active'] = 'active';
			$arr['mylink_open'] = 'open';
			return $arr;
		} else if($mClass=='user' && $mMethod=='perjalanan') {
			$arr['hr_perjalanan_active'] = 'active';
			return $arr;
		} else if($mClass=='accounting' && $mMethod=='dashboard_accounting') {
			$arr['dashboard_accounting_active'] = 'active';
			$arr['hr_acc_open'] = 'open';
			return $arr;
		} else if($mClass=='accounting' && $mMethod=='bank_cash') {
			$arr['bank_cash_act'] = 'active';
			$arr['hr_acc_open'] = 'open';
			return $arr;
		} else if($mClass=='accounting' && $mMethod=='saldo_accounts') {
			$arr['dashboard_accounting_active'] = 'active';
			$arr['hr_acc_open'] = 'open';
			return $arr;
		} else if($mClass=='accounting' && $mMethod=='transfer') {
			$arr['transfer_active'] = 'active';
			$arr['hr_acc_open'] = 'open';
			return $arr;
		} else if($mClass=='accounting' && $mMethod=='deposit') {
			$arr['deposit_active'] = 'active';
			$arr['hr_acc_open'] = 'open';
			return $arr;
		} else if($mClass=='accounting' && $mMethod=='biaya') {
			$arr['biaya_active'] = 'active';
			$arr['hr_acc_open'] = 'open';
			return $arr;
		} else if($mClass=='accounting' && $mMethod=='transaksii') {
			$arr['transaksii_active'] = 'active';
			$arr['hr_acc_open'] = 'open';
			return $arr;
		} else if($mClass=='accounting' && $mMethod=='transaksii_bijaksanabank') {
			$arr['dashboard_accounting_active'] = 'active';
			$arr['hr_acc_open'] = 'open';
			return $arr;
		} else if($mClass=='accounting' && $mMethod=='accounts_ledger') {
			$arr['dashboard_accounting_active'] = 'active';
			$arr['hr_acc_open'] = 'open';
			return $arr;
		} else if($mClass=='accounting' && $mMethod=='penerima_pembayarans') {
			$arr['hr_penerima_pembayarans_active'] = 'active';
			//$arr['hr_acc_open'] = 'open';
			return $arr;
		} else if($mClass=='accounting' && $mMethod=='pembayars') {
			$arr['hr_pembayars_active'] = 'active';
			//$arr['hr_acc_open'] = 'open';
			return $arr;
		} else if($mClass=='accounting' && $mMethod=='account_statement') {
			$arr['laporans_active'] = 'active';
			$arr['hr_acc_open'] = 'open';
			$arr['hr_acc_laporan_open'] = 'open';
			return $arr;
		} else if($mClass=='accounting' && $mMethod=='biaya_laporan') {
			$arr['laporans_active'] = 'active';
			$arr['hr_acc_open'] = 'open';
			$arr['hr_acc_laporan_open'] = 'open';
			return $arr;
		} else if($mClass=='accounting' && $mMethod=='pendapatan_laporan') {
			$arr['laporans_active'] = 'active';
			$arr['hr_acc_open'] = 'open';
			$arr['hr_acc_laporan_open'] = 'open';
			return $arr;
		} else if($mClass=='accounting' && $mMethod=='transfer_laporan') {
			$arr['laporans_active'] = 'active';
			$arr['hr_acc_open'] = 'open';
			$arr['hr_acc_laporan_open'] = 'open';
			return $arr;
		} else if($mClass=='profile' && isset($_GET['change_password'])=='true') {
			$arr['hr_password_active'] = 'active';
			return $arr;
		} else if($mClass=='invoices' && $mClass=='history_pembayarans') {
			$arr['hr_all_inv_active'] = 'active';
			return $arr;
		} else if($mClass=='invoices') {
			$arr['hr_client_invoices_active'] = 'active';
			return $arr;
		}
	}

	public function read_info_negara($id) {

		$sql = 'SELECT * FROM umb_negaraa WHERE negara_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function update_record_login($data, $id){
		$this->db->where('user_id', $id);
		if( $this->db->update('umb_karyawans',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function read_user_info($id) {

		$sql = 'SELECT * FROM umb_karyawans WHERE user_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	public function read_user_xuinfo($id) {

		$sql = 'SELECT * FROM umb_users WHERE user_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
		
	}
	
	public function read_user_info_kehadiran() {
		
		$sql = 'SELECT * FROM umb_karyawans WHERE user_id = ?';
		$binds = array('000');
		$query = $this->db->query($sql, $binds);
		
		return $query;	
	}
	
	public function read_user_melalui_karyawan_id($id) {

		$sql = 'SELECT * FROM umb_karyawans WHERE karyawan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
		
	}
	
	public function read_user_info_melalui_email($email) {

		$sql = 'SELECT * FROM umb_karyawans WHERE email = ?';
		$binds = array($email);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}

	public function read_user_pekerjaans_melalui_email($email) {

		$sql = 'SELECT * FROM umb_users WHERE email = ?';
		$binds = array($email);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}
	
	public function read_info_karyawan($id) {

		$sql = 'SELECT * FROM umb_karyawans WHERE user_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
		
	}

	public function read_info_karyawan_melalui_email($email) {

		$sql = 'SELECT * FROM umb_karyawans WHERE email = ?';
		$binds = array($email);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	
	public function checks_waktu_kehadiran($id) {

		$session = $this->session->userdata('username');
		$sql = 'SELECT * FROM umb_kehadiran_waktu WHERE karyawan_id = ?, clock_out = ? order by waktu_kehadiran_id desc limit 1';
		$binds = array($id, '');
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	
	public function read_user_info_melalui_penunjukan($email) {

		$sql = 'SELECT * FROM umb_karyawans WHERE penunjukan_id = ?';
		$binds = array($email);
		$query = $this->db->query($sql, $binds);
		return $query->result();
	}
	
	public function read_theme_info($id) {

		$sql = 'SELECT * FROM umb_theme_settings WHERE theme_settings_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	public function read_info_perusahaan($id) {

		$sql = 'SELECT * FROM umb_perusahaans WHERE perusahaan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function get_karyawan_shiftkantor($id) {

		$sql = 'SELECT * FROM umb_karyawan_shift WHERE karyawan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}
	
	public function get_karyawan_row($id) {

		$sql = 'SELECT * FROM umb_karyawans WHERE user_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function get_karyawan_shift_kantor($id) {

		$sql = 'SELECT * FROM umb_shift_kantor WHERE shift_kantor_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query;
		} else {
			return null;
		}
	}
	
	public function read_user_role_info($id) {

		$sql = 'SELECT * FROM umb_user_roles WHERE role_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function read_setting_info($id) {

		$sql = 'SELECT * FROM umb_system_setting WHERE setting_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function read_currency_con_info($id) {

		$sql = 'SELECT * FROM umb_currency_converter WHERE currency_converter_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function read_file_setting_info($id) {

		$sql = 'SELECT * FROM umb_file_manager_settings WHERE setting_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function system_layout() {

		$system = $this->read_setting_info(1);
		if($system[0]->compact_sidebar!=''){
			$compact_sidebar = 'compact-sidebar';
		} else {
			$compact_sidebar = '';
		}
		if($system[0]->fixed_header!=''){
			$fixed_header = 'fixed-header';
		} else {
			$fixed_header = '';
		}
		if($system[0]->fixed_sidebar!=''){
			$fixed_sidebar = 'fixed-sidebar';
		} else {
			$fixed_sidebar = '';
		}
		if($system[0]->boxed_wrapper!=''){
			$boxed_wrapper = 'boxed-wrapper';
		} else {
			$boxed_wrapper = '';
		}
		if($system[0]->layout_static!=''){
			$static = 'static';
		} else {
			$static = '';
		}
		return $layout = $compact_sidebar.' '.$fixed_header.' '.$fixed_sidebar.' '.$boxed_wrapper.' '.$static;
	}
	
	public function read_info_setting_perusahaan($id) {

		$sql = 'SELECT * FROM umb_info_perusahaan WHERE info_perusahaan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function site_title() {
		$system = $this->read_setting_info(1);
		return $system[0]->application_name;
	}
	
	public function get_perusahaans(){
		$query = $this->db->query("SELECT * from umb_perusahaans");
		return $query->result();
	}
	
	public function get_applications_cuti(){
		$query = $this->db->query("SELECT * from umb_applications_cuti");
		return $query->result();
	}
	
	public function get_notify_applications_cuti() {
		$query = $this->db->query("SELECT * from umb_applications_cuti where is_notify = '1' order by cuti_id desc");
		return $query->result();
	}

	public function get_user_applications_cuti_terakhir($user_id) {
		$query = $this->db->query("SELECT * from umb_applications_cuti where karyawan_id = '".$user_id."' and is_notify = '1' order by cuti_id desc");
		return $query->result();
	}

	public function get_notify_projects() {
		$query = $this->db->query("SELECT * from umb_projects where is_notify = '1' order by project_id desc");
		return $query->result();
	}

	public function get_notify_perusahaan_projects($perusahaan_id) {
		$query = $this->db->query("SELECT * from umb_projects where perusahaan_id = '".$perusahaan_id."' and is_notify = '1' order by project_id desc");
		return $query->result();
	}
	public function get_notify_user_projects($id) {
		$query = $this->db->query("SELECT * from umb_projects where is_notify = '1' and assigned_to like '%$id,%' or assigned_to like '%,$id%' or assigned_to = '$id' order by project_id desc");
		return $query->result();
	}

	public function get_notify_tugass() {
		$query = $this->db->query("SELECT * from umb_tugass where is_notify = '1' order by tugas_id desc");
		return $query->result();
	}

	public function get_notify_perusahaan_tugass($perusahaan_id) {
		$query = $this->db->query("SELECT * from umb_tugass where is_notify = '1' and perusahaan_id = '".$perusahaan_id."' order by tugas_id desc");
		return $query->result();
	}

	public function get_notify_user_tugass($id) {
		$query = $this->db->query("SELECT * from umb_tugass where is_notify = '1' and assigned_to like '%$id,%' or assigned_to like '%,$id%' or assigned_to = '$id' order by tugas_id desc");
		return $query->result();
	}

	public function get_notify_pengumumans() {
		$query = $this->db->query("SELECT * from umb_pengumumans where is_notify = '1' order by pengumuman_id desc");
		return $query->result();
	}

	public function get_notify_perusahaan_pengumumans($perusahaan_id) {
		$query = $this->db->query("SELECT * from umb_pengumumans where is_notify = '1' and perusahaan_id = '".$perusahaan_id."' order by pengumuman_id desc");
		return $query->result();
	}

	public function get_notify_dept_pengumumans($department_id) {
		$query = $this->db->query("SELECT * from umb_pengumumans where is_notify = '1' and department_id = '$department_id' order by pengumuman_id desc");
		return $query->result();
	}

	public function get_notify_tickets() {
		$query = $this->db->query("SELECT * from umb_support_tickets_karyawans where is_notify = '1' order by ticket_id desc");
		return $query->result();
	}

	public function get_notify_perusahaan_tickets($perusahaan_id) {
		$query = $this->db->query("SELECT * from umb_support_tickets_karyawans where is_notify = '1' and perusahaan_id = '".$perusahaan_id."' order by ticket_id desc");
		return $query->result();
	}

	public function count_notify_user_tickets($karyawan_id) {
		$query = $this->db->query("SELECT st.*, ste.* FROM umb_support_tickets as st, umb_support_tickets_karyawans as ste WHERE st.ticket_id=ste.ticket_id and ste.karyawan_id = $karyawan_id");
		//$this->db->group_by("st.ticket_id");
		return $query->num_rows();
	}
	
	public function get_notify_user_tickets($karyawan_id) {
		$query = $this->db->query("SELECT st.*, ste.* FROM umb_support_tickets as st, umb_support_tickets_karyawans as ste WHERE st.ticket_id=ste.ticket_id and ste.karyawan_id = $karyawan_id");
	   //$this->db->group_by("st.ticket_id");
		return $query->result();
	}

	public function count_total_perusahaans() {
		$query = $this->db->query("SELECT * from umb_perusahaans");
		return $query->num_rows();
	}
	
	public function count_user_notify_cuti_applications($user_id) {
		$query = $this->db->query("SELECT * from umb_applications_cuti where karyawan_id = '".$user_id."' and is_notify = '1'");
		return $query->num_rows();
	}

	public function count_notify_cuti_applications(){
		$query = $this->db->query("SELECT * from umb_applications_cuti where is_notify = '1'");
		return $query->num_rows();
	}

	public function count_notify_projects() {
		$query = $this->db->query("SELECT * from umb_projects where is_notify = '1'");
		return $query->num_rows();
	}

	public function count_notify_perusahaan_projects($perusahaan_id) {
		$query = $this->db->query("SELECT * from umb_projects where is_notify = '1' and perusahaan_id = '".$perusahaan_id."'");
		return $query->num_rows();
	}

	public function count_notify_user_projects($id) {
		$query = $this->db->query("SELECT * from umb_projects where is_notify = '1' and assigned_to like '%$id,%' or assigned_to like '%,$id%' or assigned_to = '$id'");
		return $query->num_rows();
	}

	public function count_notify_tugass() {
		$query = $this->db->query("SELECT * from umb_tugass where is_notify = '1'");
		return $query->num_rows();
	}

	public function count_notify_perusahaan_tugass($perusahaan_id) {
		$query = $this->db->query("SELECT * from umb_tugass where is_notify = '1' and perusahaan_id = '".$perusahaan_id."'");
		return $query->num_rows();
	}

	public function count_notify_user_tugass($id) {
		$query = $this->db->query("SELECT * from umb_tugass where is_notify = '1' and assigned_to like '%$id,%' or assigned_to like '%,$id%' or assigned_to = '$id'");
		return $query->num_rows();
	}

	public function count_notify_pengumumans() {
		$query = $this->db->query("SELECT * from umb_pengumumans where is_notify = '1'");
		return $query->num_rows();
	}

	public function count_notify_perusahaan_pengumumans($perusahaan_id) {
		$query = $this->db->query("SELECT * from umb_pengumumans where is_notify = '1' and perusahaan_id = '".$perusahaan_id."'");
		return $query->num_rows();
	}
	public function count_notify_dept_pengumumans($department_id) {
		$query = $this->db->query("SELECT * from umb_pengumumans where is_notify = '1' and department_id = '$department_id' order by pengumuman_id desc");
		return $query->num_rows();
	}

	public function count_notify_tickets() {
		$query = $this->db->query("SELECT * from umb_support_tickets where is_notify = '1' order by ticket_id desc");
		return $query->num_rows();
	}
	public function count_notify_perusahaan_tickets($perusahaan_id) {
		$query = $this->db->query("SELECT * from umb_support_tickets where is_notify = '1' and perusahaan_id = '".$perusahaan_id."' order by ticket_id desc");
		return $query->num_rows();
	}
	
	public function update_record_pengumumans($data){
		$sql = 'UPDATE umb_pengumumans SET is_notify = ?';
		$binds = array(0);
		$query = $this->db->query($sql, $binds);		
	}

	public function money_format($format, $number) { 
		$regex  = '/%((?:[\^!\-]|\+|\(|\=.)*)([0-9]+)?'. 
		'(?:#([0-9]+))?(?:\.([0-9]+))?([in%])/'; 
		if (setlocale(LC_MONETARY, 0) == 'C') { 
			setlocale(LC_MONETARY, ''); 
		} 
		$locale = localeconv(); 
		preg_match_all($regex, $format, $matches, PREG_SET_ORDER); 
		foreach ($matches as $fmatch) { 
			$value = floatval($number); 
			$flags = array( 
				'fillchar'  => preg_match('/\=(.)/', $fmatch[1], $match) ? 
				$match[1] : ' ', 
				'nogroup'   => preg_match('/\^/', $fmatch[1]) > 0, 
				'usesignal' => preg_match('/\+|\(/', $fmatch[1], $match) ? 
				$match[0] : '+', 
				'nosimbol'  => preg_match('/\!/', $fmatch[1]) > 0, 
				'isleft'    => preg_match('/\-/', $fmatch[1]) > 0 
			); 
			$width      = trim($fmatch[2]) ? (int)$fmatch[2] : 0; 
			$left       = trim($fmatch[3]) ? (int)$fmatch[3] : 0; 
			$right      = trim($fmatch[4]) ? (int)$fmatch[4] : $locale['int_frac_digits']; 
			$conversion = $fmatch[5]; 
			$positive = true; 
			if ($value < 0) { 
				$positive = false; 
				$value  *= -1; 
			} 
			$letter = $positive ? 'p' : 'n'; 
			$prefix = $suffix = $cprefix = $csuffix = $signal = ''; 
			$signal = $positive ? $locale['positive_sign'] : $locale['negative_sign']; 
			switch (true) { 
				case $locale["{$letter}_sign_posn"] == 1 && $flags['usesignal'] == '+': 
				$prefix = $signal; 
				break; 
				case $locale["{$letter}_sign_posn"] == 2 && $flags['usesignal'] == '+': 
				$suffix = $signal; 
				break; 
				case $locale["{$letter}_sign_posn"] == 3 && $flags['usesignal'] == '+': 
				$cprefix = $signal; 
				break; 
				case $locale["{$letter}_sign_posn"] == 4 && $flags['usesignal'] == '+': 
				$csuffix = $signal; 
				break; 
				case $flags['usesignal'] == '(': 
				case $locale["{$letter}_sign_posn"] == 0: 
				$prefix = '('; 
				$suffix = ')'; 
				break; 
			} 
			if (!$flags['nosimbol']) { 
				$currency = $cprefix . 
				($conversion == 'i' ? $locale['int_curr_symbol'] : $locale['currency_symbol']) . 
				$csuffix; 
			} else { 
				$currency = ''; 
			} 
			$space  = $locale["{$letter}_sep_by_space"] ? ' ' : ''; 
			$value = number_format($value, $right, $locale['mon_decimal_point'], 
				$flags['nogroup'] ? '' : $locale['mon_thousands_sep']); 
			$value = @explode($locale['mon_decimal_point'], $value); 
			$n = strlen($prefix) + strlen($currency) + strlen($value[0]); 
			if ($left > 0 && $left > $n) { 
				$value[0] = str_repeat($flags['fillchar'], $left - $n) . $value[0]; 
			} 
			$value = @implode($locale['mon_decimal_point'], $value); 
			if ($locale["{$letter}_cs_precedes"]) { 
				$value = $value; 
			} else { 
				$value = $value; 
			} 
			if ($width > 0) { 
				$value = str_pad($value, $width, $flags['fillchar'], $flags['isleft'] ? 
					STR_PAD_RIGHT : STR_PAD_LEFT); 
			} 
			$format = str_replace($fmatch[0], $value, $format); 
		} 
		return $format; 
	}

	public function convertNumberToWord($num = false) {
		$num = str_replace(array(',', ' '), '' , trim($num));
		if(! $num) {
			return false;
		}
		$num = (int) $num;
		$words = array();
		$list1 = array('', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas',
			'dusbelas', 'tigabelas', 'emapatbelas', 'limabelas', 'enambelas', 'tujuhbelas', 'delapanbelas', 'sembilanbelas'
		);
		$list2 = array('', 'sepuluh', 'duapuluh', 'tigapuluh', 'empatpuluh', 'limapuluh', 'enampuluh', 'tujuhpuluh', 'delapanpuluh', 'sembilanpuluh', 'ratus');
		$list3 = array('', 'ribu', 'juta', 'milyar', 'triliun', 'quadrillion', 'quintillion', 'sextillion', 'septillion',
			'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion',
			'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion'
		);
		$num_length = strlen($num);
		$levels = (int) (($num_length + 2) / 3);
		$max_length = $levels * 3;
		$num = substr('00' . $num, -$max_length);
		$num_levels = str_split($num, 3);
		for ($i = 0; $i < count($num_levels); $i++) {
			$levels--;
			$hundreds = (int) ($num_levels[$i] / 100);
			$hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' hundred' . ' ' : '');
			$tens = (int) ($num_levels[$i] % 100);
			$singles = '';
			if ( $tens < 20 ) {
				$tens = ($tens ? ' ' . $list1[$tens] . ' ' : '' );
			} else {
				$tens = (int)($tens / 10);
				$tens = ' ' . $list2[$tens] . ' ';
				$singles = (int) ($num_levels[$i] % 10);
				$singles = ' ' . $list1[$singles] . ' ';
			}
			$words[] = $hundreds . $tens . $singles . ( ( $levels && ( int ) ( $num_levels[$i] ) ) ? ' ' . $list3[$levels] . ' ' : '' );
		}
		$commas = count($words);
		if ($commas > 1) {
			$commas = $commas - 1;
		}
		return implode(' ', $words);
	}

	public function currency_sign($number) {
		
		$system_setting = $this->read_setting_info(1);
		$default_locale = 'id_ID';
		/*if($system_setting[0]->default_currency_locale == ''){
			$default_locale = 'id_ID';
		} else {
			$default_locale = $system_setting[0]->default_currency_locale;
		}*/
		setlocale(LC_MONETARY, $default_locale);
		if($system_setting[0]->show_currency=='code'){
			$ar_sc = explode(' -',$system_setting[0]->default_currency_symbol);
			$sc_show = $ar_sc[0];
		} else {
			$ar_sc = explode('- ',$system_setting[0]->default_currency_symbol);
			$sc_show = $ar_sc[1];
		}
		if($system_setting[0]->currency_position=='Prefix'){
			$number = $this->money_format('%i', $number);
			$sign_value = $sc_show.''.$number;
		} else {
			$number = $this->money_format('%i', $number);
			$sign_value = $number.''.$sc_show;
		}
		
		return $sign_value;
	}
	//set perusahaan currency sign
	public function perusahaan_currency_sign($number,$perusahaan_id) {
		
		
		// get details
		$system_setting = $this->read_setting_info(1);
		$default_locale = 'id_ID';
		/*if($system_setting[0]->default_currency_locale == ''){
			$default_locale = 'id_ID';
		} else {
			$default_locale = $system_setting[0]->default_currency_locale;
		}*/
		$info_perusahaan = $this->Perusahaan_model->read_informasi_perusahaan($perusahaan_id);
		if(!is_null($info_perusahaan)){
			$default_currency = $info_perusahaan[0]->default_currency;
			//date_default_timezone_set($default_timezone);
		} else {
			$default_currency = $system[0]->default_currency_symbol;
			//date_default_timezone_set($default_timezone);	
		}

		setlocale(LC_MONETARY, $default_locale);
		// currency code/symbol
		if($system_setting[0]->show_currency=='code'){
			$ar_sc = explode(' -',$default_currency);
			$sc_show = $ar_sc[0];
		} else {
			$ar_sc = explode('- ',$default_currency);
			$sc_show = $ar_sc[1];
		}
		if($system_setting[0]->currency_position=='Prefix'){
			$number = $this->money_format('%i', $number);
			$sign_value = $sc_show.''.$number;
		} else {
			$number = $this->money_format('%i', $number);
			$sign_value = $number.''.$sc_show;
		}
		
		return $sign_value;
	}

	public function set_percentage($number){
		if(is_int($number)) {
			$inumber = $number;
		} else {
			$inumber = number_format((float)$number, 2, '.', '');
		}
		return $inumber;
		
	}

	public function all_locations(){

		$query = $this->db->query("SELECT * from umb_location_kantor");
		return $query->result();
	}
	
	public function dash_all_perusahaans(){
		$query = $this->db->query("SELECT * from umb_perusahaans");
		return $query->result();
	}
	
	public function set_date_format_js() {
		
		$system_setting = $this->read_setting_info(1);
		if($system_setting[0]->date_format_astral=='d-m-Y'){
			$d_format = 'dd-mm-yy';
		} else if($system_setting[0]->date_format_astral=='m-d-Y'){
			$d_format = 'mm-dd-yy';
		} else if($system_setting[0]->date_format_astral=='d-M-Y'){
			$d_format = 'dd-M-yy';
		} else if($system_setting[0]->date_format_astral=='M-d-Y'){
			$d_format = 'M-dd-yy';;
		}
		return $d_format;
	}
	
	public function read_info_penunjukan($id) {

		$sql = 'SELECT * FROM umb_penunjukans WHERE penunjukan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	public function read_low_penunjukans($id) {

		$sql = 'SELECT * FROM umb_penunjukans WHERE penunjukan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		return $query->result();
	}

	public function read_top_penunjukans($id) {

		$sql = 'SELECT * FROM umb_penunjukans WHERE top_penunjukan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		return $query->result();
	}
	
	public function read_dep_penunjukans($id) {

		$sql = 'SELECT * FROM umb_penunjukans WHERE department_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		return $query->result();
	}
	
	public function read_penunjukan_karyawans($id) {

		$sql = 'SELECT * FROM umb_karyawans WHERE penunjukan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		return $query->result();
	}
	
	public function all_status_karyawans(){
		$query = $this->db->query("SELECT * from umb_karyawans");
		return $query;
	}

	public function calendar_kehadiran_all_karyawans(){
		$query = $this->db->query("SELECT * from umb_karyawans");
		return $query;
	}
	
	public function current_hari_bulan_kehadiran($current_month) {
		
		$session = $this->session->userdata('username');
		$this->db->query("SET SESSION sql_mode = ''");
		$sql = 'SELECT karyawan_id,tanggal_kehadiran FROM umb_kehadiran_waktu WHERE tanggal_kehadiran = ? group by karyawan_id';
		$binds = array($current_month);
		$query = $this->db->query($sql, $binds);
		return $query->num_rows();
	}
	
	public function current_calendar_absent_karyawan($current_month) {
		
		$session = $this->session->userdata('username');		
		$sql = "SELECT at.*,e.*,la.* from umb_kehadiran_waktu as at, umb_karyawans as e, umb_applications_cuti as la where at.tanggal_kehadiran = ? and e.user_id!=at.karyawan_id and e.user_id!=la.karyawan_id";
		$binds = array($current_month);
		$query = $this->db->query($sql, $binds);
		
		
		return $query->result();
	}

	public function current_count_calendar_absent_karyawan($current_month) {
		
		$session = $this->session->userdata('username');
		$sql = "SELECT at.*,e.*,la.* from umb_kehadiran_waktu as at, umb_karyawans as e, umb_applications_cuti as la where at.tanggal_kehadiran = ? and e.user_id!=at.karyawan_id and e.user_id!=la.karyawan_id";
		$binds = array($current_month);
		$query = $this->db->query($sql, $binds);
		return $query->num_rows();
	}
	
	public function calendar_tanggal_karyawan_cuti($current_date) {

		$this->db->query("SET SESSION sql_mode = ''");
		$sql = "SELECT la.*,e.user_id,e.first_name,e.last_name from umb_applications_cuti as la, umb_karyawans as e where (la.from_date between la.from_date and la.to_date) or la.from_date = ? and la.to_date = ? and e.user_id=la.karyawan_id and la.status=2 group by la.karyawan_id";
		$binds = array($current_date,$current_date);
		$query = $this->db->query($sql, $binds);
		return $query->result();
	}
	
	public function count_calendar_tanggal_karyawan_cuti($current_date) {

		$this->db->query("SET SESSION sql_mode = ''");
		$sql = "SELECT la.*,e.user_id,e.first_name,e.last_name from umb_applications_cuti as la, umb_karyawans as e where (la.from_date between la.from_date and la.to_date) or la.from_date = ? and la.to_date = ? and e.user_id=la.karyawan_id and la.status=2 group by la.karyawan_id";
		$binds = array($current_date,$current_date);
		$query = $this->db->query($sql, $binds);
		return $query->num_rows();
	}

	public function current_calendar_karyawan_cuti() {
		
		$session = $this->session->userdata('username');
		$query = $this->db->query("SELECT la.*,e.* from umb_applications_cuti as la, umb_karyawans as e where e.user_id=la.karyawan_id");
		return $query->result();
	}
	
	public function current_calendar_kerja_karyawan($current_date) {
		
		$this->db->query("SET SESSION sql_mode = ''");
		$sql = 'SELECT * FROM umb_kehadiran_waktu WHERE tanggal_kehadiran = ? group by karyawan_id';
		$binds = array($current_date);
		$query = $this->db->query($sql, $binds);
		return $query->result();
	}

	public function all_karyawans(){
		$query = $this->db->query("SELECT * from umb_karyawans where user_role_id!=1 and is_active=1");
		return $query->result();
	}
	
	public function all_active_karyawans(){
		$session = $this->session->userdata('username');
		$sql = 'SELECT * FROM umb_karyawans WHERE is_active = ? and user_id!=?';
		$binds = array(1,$session['user_id']);
		$query = $this->db->query($sql, $binds);
		return $query->result();
	}
	
	public function karyawans_pria(){
		$sql = 'SELECT * FROM umb_karyawans WHERE jenis_kelamin = ?';
		$binds = array('Pria');
		$query = $this->db->query($sql, $binds);
		
		$krywn_pria = $query->num_rows();
		$stquery = $this->all_status_karyawans();
		$st_total = $stquery->num_rows();
		if($krywn_pria==0) {
			return $karyawans_pria = 0;
		} else {
			$rd_krywn = round($krywn_pria / ($st_total / 100),2);
			return $rd_krywn;
		}
	}

	public function karyawans_perempuan() {
		$sql = 'SELECT * FROM umb_karyawans WHERE jenis_kelamin = ?';
		$binds = array('Perempuan');
		$query = $this->db->query($sql, $binds);
		$krywn_perempuan = $query->num_rows();
		$stquery = $this->all_status_karyawans();
		$st_total = $stquery->num_rows();
		if($krywn_perempuan==0) {
			return $karyawans_perempuan = 0;
		} else {
			$rd_krywn = round($krywn_perempuan / ($st_total / 100),2);
			return $rd_krywn;
		}
	}
	
	public function all_customers(){
		$query = $this->db->query("SELECT * from umb_customers");
		return $query->result();
	}
	
	public function all_suppliers(){
		$query = $this->db->query("SELECT * from umb_suppliers");
		return $query->result();
	}
	
	public function all_agents(){
		$query = $this->db->query("SELECT * from umb_agents");
		return $query->result();
	}

	public function set_date_format($date) {
		
		$system_setting = $this->read_setting_info(1);
		// date formate
		if($system_setting[0]->date_format_astral=='d-m-Y'){
			$d_format = date("d-m-Y", strtotime($date));
		} else if($system_setting[0]->date_format_astral=='m-d-Y'){
			$d_format = date("m-d-Y", strtotime($date));
		} else if($system_setting[0]->date_format_astral=='d-M-Y'){
			$d_format = date("d-M-Y", strtotime($date));
		} else if($system_setting[0]->date_format_astral=='M-d-Y'){
			$d_format = date("M-d-Y", strtotime($date));
		} else if($system_setting[0]->date_format_astral=='F-j-Y'){
			$d_format = date("F-j-Y", strtotime($date));
		} else if($system_setting[0]->date_format_astral=='j-F-Y'){
			$d_format = date("j-F-Y", strtotime($date));
		} else if($system_setting[0]->date_format_astral=='m.d.y'){
			$d_format = date("m.d.y", strtotime($date));
		} else if($system_setting[0]->date_format_astral=='d.m.y'){
			$d_format = date("d.m.y", strtotime($date));
		} else {
			$d_format = $system_setting[0]->date_format_astral;
		}
		
		return $d_format;
	}
	
	public function set_date_time_format($date) {
		
		// get details
		$system_setting = $this->read_setting_info(1);
		// date formate
		if($system_setting[0]->date_format_astral=='d-m-Y'){
			$d_format = date("d-m-Y h:i a", strtotime($date));
		} else if($system_setting[0]->date_format_astral=='m-d-Y'){
			$d_format = date("m-d-Y h:i a", strtotime($date));
		} else if($system_setting[0]->date_format_astral=='d-M-Y'){
			$d_format = date("d-M-Y h:i a", strtotime($date));
		} else if($system_setting[0]->date_format_astral=='M-d-Y'){
			$d_format = date("M-d-Y h:i a", strtotime($date));
		} else if($system_setting[0]->date_format_astral=='F-j-Y'){
			$d_format = date("F-j-Y h:i a", strtotime($date));
		} else if($system_setting[0]->date_format_astral=='j-F-Y'){
			$d_format = date("j-F-Y h:i a", strtotime($date));
		} else if($system_setting[0]->date_format_astral=='m.d.y'){
			$d_format = date("m.d.y h:i a", strtotime($date));
		} else if($system_setting[0]->date_format_astral=='d.m.y'){
			$d_format = date("d.m.y h:i a", strtotime($date));
		} else {
			$d_format = $system_setting[0]->date_format_astral;
		}
		
		return $d_format;
	}
	
	public function all_kebijakans() {
		$query = $this->db->query("SELECT * from umb_kebijakan_perusahaan");
		return $query->result();
	}
	
	public function update_record_info_perusahaan($data, $id){
		$this->db->where('info_perusahaan_id', $id);
		if( $this->db->update('umb_info_perusahaan',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function update_record_info_setting($data, $id){
		$this->db->where('setting_id', $id);
		if( $this->db->update('umb_system_setting',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function update_email_config_record($data, $id){
		$this->db->where('email_config_id', $id);
		if( $this->db->update('umb_email_configuration',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function update_record_info_theme($data, $id){
		$this->db->where('theme_settings_id', $id);
		if( $this->db->update('umb_theme_settings',$data)) {
			return true;
		} else {
			return false;
		}		
	}

	public function add_backup($data){
		$this->db->insert('umb_database_backup', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function all_db_backup() {
		return  $query = $this->db->query("SELECT * from umb_database_backup");
	}
	
	public function read_db_backup($backup_id) {

		$sql = 'SELECT * FROM umb_database_backup WHERE backup_id = ?';
		$binds = array($backup_id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function delete_record_single_backup($id){
		$this->db->where('backup_id', $id);
		$this->db->delete('umb_database_backup');
		
	}

	public function delete_record_all_backup(){
		$this->db->empty_table('umb_database_backup');
		
	}
	
	public function get_email_templates() {
		return  $query = $this->db->query("SELECT * from umb_email_template");
	}
	
	public function read_info_email_template($id) {

		$sql = 'SELECT * FROM umb_email_template WHERE template_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function delete_record_email_template($data, $id){
		$this->db->where('template_id', $id);
		if( $this->db->update('umb_email_template',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function get_types_kontrak() {
		return  $query = $this->db->query("SELECT * from umb_type_kontrak");
	}
	
	public function get_qualification_pendidikan() {
		return  $query = $this->db->query("SELECT * from umb_qualification_tingakat_pendidikan");
	}
	
	public function get_qualification_language() {
		return  $query = $this->db->query("SELECT * from umb_qualification_language");
	}
	
	public function get_qualification_skill() {
		return  $query = $this->db->query("SELECT * from umb_qualification_skill");
	}
	
	public function get_type_document() {
		return  $query = $this->db->query("SELECT * from umb_type_document");
	}
	
	public function get_type_award() {
		return  $query = $this->db->query("SELECT * from umb_type_award");
	}
	
	public function get_type_perusahaan() {
		return  $query = $this->db->query("SELECT * from umb_type_perusahaan");
	}
	
	public function get_type_cuti() {
		return  $query = $this->db->query("SELECT * from umb_type_cuti");
	}
	
	public function get_type_peringatan() {
		return  $query = $this->db->query("SELECT * from umb_type_peringatan");
	}
	
	public function get_type_penghentian() {
		return  $query = $this->db->query("SELECT * from umb_type_penghentian");
	}
	
	public function get_type_biaya() {
		return  $query = $this->db->query("SELECT * from umb_type_biaya");
	}
	
	public function get_type_pekerjaan() {
		return  $query = $this->db->query("SELECT * from umb_type_pekerjaan");
	}

	public function get_kategoris_pekerjaan() {
		return  $query = $this->db->query("SELECT * from umb_kategoris_pekerjaan");
	}
	
	public function get_type_exit() {
		return  $query = $this->db->query("SELECT * from umb_karyawan_type_exit");
	}
	
	public function get_type_perjalanan() {
		return  $query = $this->db->query("SELECT * from umb_type_pengaturan_perjalanan");
	}
	
	public function get_payment_method() {
		return  $query = $this->db->query("SELECT * from umb_payment_method");
	}
	
	public function get_types_currency() {
		return  $query = $this->db->query("SELECT * from umb_currencies");
	}
	
	public function add_type_kontrak($data){
		$this->db->insert('umb_type_kontrak', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function add_type_document($data){
		$this->db->insert('umb_type_document', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function add_tingkat_pddkn($data){
		$this->db->insert('umb_qualification_tingakat_pendidikan', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function add_edu_language($data){
		$this->db->insert('umb_qualification_language', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function add_edu_skill($data){
		$this->db->insert('umb_qualification_skill', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function add_payment_method($data){
		$this->db->insert('umb_payment_method', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function add_type_award($data){
		$this->db->insert('umb_type_award', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function add_type_cuti($data){
		$this->db->insert('umb_type_cuti', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function add_type_peringatan($data){
		$this->db->insert('umb_type_peringatan', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function add_type_penghentian($data){
		$this->db->insert('umb_type_penghentian', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function add_type_biaya($data){
		$this->db->insert('umb_type_biaya', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function add_type_pekerjaan($data){
		$this->db->insert('umb_type_pekerjaan', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function add_kategori_pekerjaan($data){
		$this->db->insert('umb_kategoris_pekerjaan', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function add_type_exit($data){
		$this->db->insert('umb_karyawan_type_exit', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function add_type_perusahaan($data){
		$this->db->insert('umb_type_perusahaan', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function add_type_pngtrn_perjalanan($data){
		$this->db->insert('umb_type_pengaturan_perjalanan', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function add_type_currency($data){
		$this->db->insert('umb_currencies', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function delete_record_type_kontrak($id){
		$this->db->where('type_kontrak_id', $id);
		$this->db->delete('umb_type_kontrak');
		
	}

	public function delete_record_type_document($id){
		$this->db->where('type_document_id', $id);
		$this->db->delete('umb_type_document');
		
	}

	public function delete_record_payment_method($id){
		$this->db->where('payment_method_id', $id);
		$this->db->delete('umb_payment_method');
		
	}

	public function delete_record_tingkat_pendidikan($id){
		$this->db->where('tingkat_pendidikan_id', $id);
		$this->db->delete('umb_qualification_tingakat_pendidikan');
		
	}

	public function delete_record_qualification_language($id){
		$this->db->where('language_id', $id);
		$this->db->delete('umb_qualification_language');
		
	}

	public function delete_record_qualification_skill($id){
		$this->db->where('skill_id', $id);
		$this->db->delete('umb_qualification_skill');
		
	}

	public function delete_record_type_award($id){
		$this->db->where('type_award_id', $id);
		$this->db->delete('umb_type_award');
		
	}

	public function delete_record_type_cuti($id){
		$this->db->where('type_cuti_id', $id);
		$this->db->delete('umb_type_cuti');
		
	}

	public function delete_record_type_peringatan($id){
		$this->db->where('type_peringatan_id', $id);
		$this->db->delete('umb_type_peringatan');
		
	}

	public function delete_record_type_penghentian($id){
		$this->db->where('type_penghentian_id', $id);
		$this->db->delete('umb_type_penghentian');
		
	}

	public function delete_record_type_biaya($id){
		$this->db->where('type_biaya_id', $id);
		$this->db->delete('umb_type_biaya');
		
	}

	public function delete_record_type_pekerjaan($id){
		$this->db->where('type_pekerjaan_id', $id);
		$this->db->delete('umb_type_pekerjaan');
		
	}

	public function delete_record_kategori_pekerjaan($id){
		$this->db->where('kategori_id', $id);
		$this->db->delete('umb_kategoris_pekerjaan');
		
	}

	public function delete_record_type_exit($id){
		$this->db->where('type_exit_id', $id);
		$this->db->delete('umb_karyawan_type_exit');
		
	}

	public function delete_record_type_pngtrn_perjalanan($id){
		$this->db->where('type_pengaturan_id', $id);
		$this->db->delete('umb_type_pengaturan_perjalanan');
		
	}
	

	public function delete_record_type_currency($id){
		$this->db->where('currency_id', $id);
		$this->db->delete('umb_currencies');
		
	}
	
	public function delete_record_type_perusahaan($id){
		$this->db->where('type_id', $id);
		$this->db->delete('umb_type_perusahaan');
		
	}

	public function empat_karyawan_terakhir(){
		$query = $this->db->query("SELECT * from umb_karyawans order by user_id desc limit 4");
		return $query->result();
	}
	
	public function pekerjaans_terakhir() {
		$query = $this->db->query("SELECT * FROM umb_applications_pekerjaan order by application_id desc limit 4");
		return $query->result();
	}
	
	public function get_total_bayar_gajii() {
		$query = $this->db->query("SELECT SUM(jumlah_pembayaran) as paid_jumlah FROM umb_melakukan_pembayaran");
		return $query->result();
	}
	
	public function all_perusahaans_chart(){
		$this->db->query("SET SESSION sql_mode = ''");
		$query = $this->db->query("SELECT m.*, c.* FROM umb_melakukan_pembayaran as m, umb_perusahaans as c where m.perusahaan_id = c.perusahaan_id group by m.perusahaan_id");
		return $query->result();
	}
	
	public function get_perusahaan_melakukan_pembayaran($id) {

		$sql = 'SELECT SUM(jumlah_pembayaran) as bayar_jumlah FROM umb_melakukan_pembayaran where perusahaan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query->result();
	}
	
	public function get_currencies() {

		$query = $this->db->query("SELECT * from umb_currencies");
		return $query->result();
	}
	
	public function all_location_chart(){

		$this->db->query("SET SESSION sql_mode = ''");
		$query = $this->db->query("SELECT m.*, l.* FROM umb_melakukan_pembayaran as m, umb_location_kantor as l where m.location_id = l.location_id group by m.location_id");
		return $query->result();
	}
	
	public function get_location_melakukan_pembayaran($id) {

		$sql = 'SELECT SUM(jumlah_pembayaran) as bayar_jumlah FROM umb_melakukan_pembayaran where location_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		return $query->result();
	}
	
	public function all_chart_departments(){

		$this->db->query("SET SESSION sql_mode = ''");
		$query = $this->db->query("SELECT m.*, d.* FROM umb_gaji_slipgajii as m, umb_departments as d where m.department_id = d.department_id group by m.department_id");
		return $query->result();
	}
	
	public function get_department_melakukan_pembayaran($id) {

		$query = $this->db->query("SELECT SUM(gaji_bersih) as bayar_jumlah FROM umb_gaji_slipgajii where department_id='".$id."'");
		return $query->result();
	}
	
	public function all_penunjukans_chart(){
		$query = $this->db->query("SELECT m.*, d.* FROM umb_gaji_slipgajii as m, umb_penunjukans as d where m.penunjukan_id = d.penunjukan_id group by m.penunjukan_id");
		return $query->result();
	}
	
	public function get_penunjukan_melakukan_pembayaran($id) {

		$query = $this->db->query("SELECT SUM(gaji_bersih) as bayar_jumlah FROM umb_gaji_slipgajii where penunjukan_id='".$id."'");
		return $query->result();
	}
	
	public function get_all_pekerjaans() {
		$query = $this->db->get("umb_pekerjaans");
		return $query->num_rows();
	}
	
	public function get_all_departments() {
		$query = $this->db->get("umb_departments");
		return $query->num_rows();
	}
	
	public function get_all_users() {
		$query = $this->db->get("umb_users");
		return $query->num_rows();
	}
	
	public function get_all_tugass() {
		$query = $this->db->get("umb_tugass");
		return $query->num_rows();
	}
	
	public function get_all_tickets() {
		$query = $this->db->get("umb_support_tickets");
		return $query->num_rows();
	}
	
	public function get_all_projects() {
		$query = $this->db->get("umb_projects");
		return $query->num_rows();
	}
	
	public function get_all_locations() {
		$query = $this->db->get("umb_location_kantor");
		return $query->num_rows();
	}
	
	public function get_all_perusahaans() {
		$query = $this->db->get("umb_perusahaans");
		return $query->num_rows();
	}
	
	public function get_history_pembayaran_terakhir() {
		$query = $this->db->query("SELECT * from umb_gaji_slipgajii order by slipgaji_id desc limit 7");
		return $query->result();
	}
	
	public function read_type_kontrak($id) {

		$sql = 'SELECT * FROM umb_type_kontrak where type_kontrak_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function read_type_document($id) {

		$sql = 'SELECT * FROM umb_type_document where type_document_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function read_payment_method($id) {

		$sql = 'SELECT * FROM umb_payment_method where payment_method_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function read_tingkat_pendidikan($id) {

		$sql = 'SELECT * FROM umb_qualification_tingakat_pendidikan where tingkat_pendidikan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function read_qualification_language($id) {

		$sql = 'SELECT * FROM umb_qualification_language where language_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function read_qualification_skill($id) {

		$sql = 'SELECT * FROM umb_qualification_skill where skill_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function read_type_award($id) {

		$sql = 'SELECT * FROM umb_type_award where type_award_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	public function read_type_cuti($id) {

		$sql = 'SELECT * FROM umb_type_cuti where type_cuti_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function read_type_peringatan($id) {

		$sql = 'SELECT * FROM umb_type_peringatan where type_peringatan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function read_type_penghentian($id) {

		$sql = 'SELECT * FROM umb_type_penghentian where type_penghentian_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function read_type_biaya($id) {

		$sql = 'SELECT * FROM umb_type_biaya where type_biaya_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function read_type_pekerjaan($id) {

		$sql = 'SELECT * FROM umb_type_pekerjaan where type_pekerjaan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	public function read_kategori_pekerjaan($id) {

		$sql = 'SELECT * FROM umb_kategoris_pekerjaan where kategori_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function read_type_exit($id) {

		$sql = 'SELECT * FROM umb_karyawan_type_exit where type_exit_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function read_type_pngtrn_perjalanan($id) {

		$sql = 'SELECT * FROM umb_type_pengaturan_perjalanan where type_pengaturan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function read_type_perusahaan($id) {

		$sql = 'SELECT * FROM umb_type_perusahaan where type_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function read_types_currency($id) {

		$sql = 'SELECT * FROM umb_currencies where currency_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function update_record_type_document($data, $id){
		$this->db->where('type_document_id', $id);
		if( $this->db->update('umb_type_document',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function update_record_type_kontrak($data, $id){
		$this->db->where('type_kontrak_id', $id);
		if( $this->db->update('umb_type_kontrak',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function update_record_payment_method($data, $id){
		$this->db->where('payment_method_id', $id);
		if( $this->db->update('umb_payment_method',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function update_record_tingkat_pendidikan($data, $id){
		$this->db->where('tingkat_pendidikan_id', $id);
		if( $this->db->update('umb_qualification_tingakat_pendidikan',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function update_record_qualification_language($data, $id){
		$this->db->where('language_id', $id);
		if( $this->db->update('umb_qualification_language',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function update_record_qualification_skill($data, $id){
		$this->db->where('skill_id', $id);
		if( $this->db->update('umb_qualification_skill',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function update_record_type_award($data, $id){
		$this->db->where('type_award_id', $id);
		if( $this->db->update('umb_type_award',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function update_record_type_cuti($data, $id){
		$this->db->where('type_cuti_id', $id);
		if( $this->db->update('umb_type_cuti',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function update_record_type_peringatan($data, $id){
		$this->db->where('type_peringatan_id', $id);
		if( $this->db->update('umb_type_peringatan',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function update_record_type_penghentian($data, $id){
		$this->db->where('type_penghentian_id', $id);
		if( $this->db->update('umb_type_penghentian',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function update_record_type_biaya($data, $id){
		$this->db->where('type_biaya_id', $id);
		if( $this->db->update('umb_type_biaya',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function update_record_type_currency($data, $id){
		$this->db->where('currency_id', $id);
		if( $this->db->update('umb_currencies',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function single_email_template($id){
		
		$sql = 'SELECT * FROM umb_email_template where template_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		return $query->result();
	}
	
	public function update_record_type_pekerjaan($data, $id){
		$this->db->where('type_pekerjaan_id', $id);
		if( $this->db->update('umb_type_pekerjaan',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	public function update_record_kategori_pekerjaan($data, $id){
		$this->db->where('kategori_id', $id);
		if( $this->db->update('umb_kategoris_pekerjaan',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function read_email_template($id) {

		$sql = 'SELECT * FROM umb_email_template where template_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function update_record_type_exit($data, $id){
		$this->db->where('type_exit_id', $id);
		if( $this->db->update('umb_karyawan_type_exit',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function update_record_pngtrn_perjalanan($data, $id){
		$this->db->where('type_pengaturan_id', $id);
		if( $this->db->update('umb_type_pengaturan_perjalanan',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function update_record_type_perusahaan($data, $id){
		$this->db->where('type_id', $id);
		if( $this->db->update('umb_type_perusahaan',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function current_bulan_kehadiran() {
		$current_month = date('Y-m');
		$session = $this->session->userdata('username');
		$sql = 'SELECT * from umb_kehadiran_waktu where tanggal_kehadiran like ? and karyawan_id = ?  group by tanggal_kehadiran';
		$binds = array('%'.$current_month.'%',$session['user_id']);
		$query = $this->db->query($sql, $binds);
		return $query->num_rows();
	}
	
	public function total_awards_karyawan() {
		$session = $this->session->userdata('username');
		$id = $session['user_id'];
		$query = $this->db->query("SELECT * FROM umb_awards where karyawan_id IN($id) order by award_id desc");
		return $query->num_rows();
	}
	
	public function get_awards_karyawan() {
		$session = $this->session->userdata('username');
		$id = $session['user_id'];
		$query = $this->db->query("SELECT * FROM umb_awards where karyawan_id IN($id) order by award_id desc");
		return $query->result();
	}
	
	public function user_role_resource(){
		
		$session = $this->session->userdata('username');
		$user = $this->read_user_info($session['user_id']);
		$role_user = $this->read_user_role_info($user[0]->user_role_id);
		$role_resources_ids = explode(',',$role_user[0]->role_resources);
		return $role_resources_ids;
	}
	
	public function all_open_tickets() {
		
		$sql = 'SELECT * FROM umb_support_tickets WHERE status_ticket = ?';
		$binds = array(1);
		$query = $this->db->query($sql, $binds);
		return $query->num_rows();
	}
	
	public function all_closed_tickets() {

		$sql = 'SELECT * FROM umb_support_tickets WHERE status_ticket = ?';
		$binds = array(2);
		$query = $this->db->query($sql, $binds); 
		return $query->num_rows();
	}
	
	public function get_selected_language_name($site_lang) {
		//english
		if($site_lang=='english'){
			$name = 'English';
		} else if($site_lang=='chineese'){
			$name = 'Chineese';
		} else if($site_lang=='danish'){
			$name = 'Danish';
		} else if($site_lang=='french'){
			$name = 'French';
		} else if($site_lang=='german'){
			$name = 'German';
		} else if($site_lang=='greek'){
			$name = 'Greek';
		} else if($site_lang=='indonesian'){
			$name = 'Indonesian';
		} else if($site_lang=='italian'){
			$name = 'Italian';
		} else if($site_lang=='japanese'){
			$name = 'Japanese';
		} else if($site_lang=='polish'){
			$name = 'Polish';
		} else if($site_lang=='portuguese'){
			$name = 'Portuguese';
		} else if($site_lang=='romanian'){
			$name = 'Romanian';
		} else if($site_lang=='russian'){
			$name = 'Russian';
		} else if($site_lang=='spanish'){
			$name = 'Spanish';
		} else if($site_lang=='turkish'){
			$name = 'Turkish';
		} else if($site_lang=='vietnamese'){
			$name = 'Vietnamese';
		} else {
			$name = 'English';
		}
		return $name;
	}
	
	public function get_selected_language_flag($site_lang) {
		//english
		if($site_lang=='english'){
			$flag = 'flag-icon-gb';
		} else if($site_lang=='chineese'){
			$flag = 'flag-icon-cn';
		} else if($site_lang=='danish'){
			$flag = 'dk.gif';
		} else if($site_lang=='french'){
			$flag = 'flag-icon-fr';
		} else if($site_lang=='german'){
			$flag = 'flag-icon-de';
		} else if($site_lang=='greek'){
			$flag = 'gr.gif';
		} else if($site_lang=='indonesian'){
			$flag = 'id.gif';
		} else if($site_lang=='italian'){
			$flag = 'ie.gif';
		} else if($site_lang=='japanese'){
			$flag = 'jp.gif';
		} else if($site_lang=='polish'){
			$flag = 'pl.gif';
		} else if($site_lang=='portuguese'){
			$flag = 'pt.gif';
		} else if($site_lang=='romanian'){
			$flag = 'ro.gif';
		} else if($site_lang=='russian'){
			$flag = 'ru.gif';
		} else if($site_lang=='spanish'){
			$flag = 'es.gif';
		} else if($site_lang=='turkish'){
			$flag = 'tr.gif';
		} else if($site_lang=='vietnamese'){
			$flag = 'vn.gif';
		} else {
			$flag = 'flag-icon-gb';
		}
		return $flag;
	}
	
	public function all_languages(){
		$sql = 'SELECT * FROM umb_languages WHERE is_active = ? order by language_name asc';
		$binds = array(1);
		$query = $this->db->query($sql, $binds); 

		return $query->result();
	}
	
	public function last_four_projects(){
		$sql = 'SELECT * FROM umb_projects order by project_id desc limit ?';
		$binds = array(4);
		$query = $this->db->query($sql, $binds); 

		return $query->result();
	}
	
	public function lima_projects_client_terakhir($id){
		$sql = 'SELECT * FROM umb_projects where client_id = ? order by project_id desc limit ?';
		$binds = array($id,5);
		$query = $this->db->query($sql, $binds); 

		return $query->result();
	}
	
	public function all_head_count_chart(){
		$query = $this->db->query("SELECT * from umb_karyawans group by created_at");
		return $query->result();
	}
	
	public function get_info_language($code) {

		$sql = 'SELECT * FROM umb_languages WHERE language_code = ?';
		$binds = array($code);
		$query = $this->db->query($sql, $binds); 
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function karyawans_upcoming_ulangtahun() {

		//$query = $this->db->query("SELECT * FROM umb_karyawans WHERE tanggal_lahir BETWEEN DATE_ADD(NOW(), INTERVAL 1 DAY) AND DATE_ADD( NOW() , INTERVAL 1 MONTH)");
		$query = $this->db->query("SELECT `user_id`, `first_name`, `last_name`, `tanggal_lahir`,
			DATE_ADD(
			tanggal_lahir, 
			INTERVAL IF(DAYOFYEAR(tanggal_lahir) >= DAYOFYEAR(CURDATE()),
			YEAR(CURDATE())-YEAR(tanggal_lahir),
			YEAR(CURDATE())-YEAR(tanggal_lahir)+1
			) YEAR
			) AS `next_ulangtahun`
			FROM `umb_karyawans` 
			WHERE 
			`tanggal_lahir` IS NOT NULL
			HAVING 
			`next_ulangtahun` BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 1 MONTH)
			ORDER BY `next_ulangtahun`");
		return $query->result();
	}
	
	public function all_timezones() {
		$timezones = array(
			'Pacific/Midway'       => "(GMT-11:00) Midway Island",
			'US/Samoa'             => "(GMT-11:00) Samoa",
			'US/Hawaii'            => "(GMT-10:00) Hawaii",
			'US/Alaska'            => "(GMT-09:00) Alaska",
			'US/Pacific'           => "(GMT-08:00) Pacific Time (US &amp; Canada)",
			'America/Tijuana'      => "(GMT-08:00) Tijuana",
			'US/Arizona'           => "(GMT-07:00) Arizona",
			'US/Mountain'          => "(GMT-07:00) Mountain Time (US &amp; Canada)",
			'America/Chihuahua'    => "(GMT-07:00) Chihuahua",
			'America/Mazatlan'     => "(GMT-07:00) Mazatlan",
			'America/Mexico_City'  => "(GMT-06:00) Mexico City",
			'America/Monterrey'    => "(GMT-06:00) Monterrey",
			'Canada/Saskatchewan'  => "(GMT-06:00) Saskatchewan",
			'US/Central'           => "(GMT-06:00) Central Time (US &amp; Canada)",
			'US/Eastern'           => "(GMT-05:00) Eastern Time (US &amp; Canada)",
			'US/East-Indiana'      => "(GMT-05:00) Indiana (East)",
			'America/Bogota'       => "(GMT-05:00) Bogota",
			'America/Lima'         => "(GMT-05:00) Lima",
			'America/Caracas'      => "(GMT-04:30) Caracas",
			'Canada/Atlantic'      => "(GMT-04:00) Atlantic Time (Canada)",
			'America/La_Paz'       => "(GMT-04:00) La Paz",
			'America/Santiago'     => "(GMT-04:00) Santiago",
			'Canada/Newfoundland'  => "(GMT-03:30) Newfoundland",
			'America/Buenos_Aires' => "(GMT-03:00) Buenos Aires",
			'Greenland'            => "(GMT-03:00) Greenland",
			'Atlantic/Stanley'     => "(GMT-02:00) Stanley",
			'Atlantic/Azores'      => "(GMT-01:00) Azores",
			'Atlantic/Cape_Verde'  => "(GMT-01:00) Cape Verde Is.",
			'Africa/Casablanca'    => "(GMT) Casablanca",
			'Europe/Dublin'        => "(GMT) Dublin",
			'Europe/Lisbon'        => "(GMT) Lisbon",
			'Europe/London'        => "(GMT) London",
			'Africa/Monrovia'      => "(GMT) Monrovia",
			'Europe/Amsterdam'     => "(GMT+01:00) Amsterdam",
			'Europe/Belgrade'      => "(GMT+01:00) Belgrade",
			'Europe/Berlin'        => "(GMT+01:00) Berlin",
			'Europe/Bratislava'    => "(GMT+01:00) Bratislava",
			'Europe/Brussels'      => "(GMT+01:00) Brussels",
			'Europe/Budapest'      => "(GMT+01:00) Budapest",
			'Europe/Copenhagen'    => "(GMT+01:00) Copenhagen",
			'Europe/Ljubljana'     => "(GMT+01:00) Ljubljana",
			'Europe/Madrid'        => "(GMT+01:00) Madrid",
			'Europe/Paris'         => "(GMT+01:00) Paris",
			'Europe/Prague'        => "(GMT+01:00) Prague",
			'Europe/Rome'          => "(GMT+01:00) Rome",
			'Europe/Sarajevo'      => "(GMT+01:00) Sarajevo",
			'Europe/Skopje'        => "(GMT+01:00) Skopje",
			'Europe/Stockholm'     => "(GMT+01:00) Stockholm",
			'Europe/Vienna'        => "(GMT+01:00) Vienna",
			'Europe/Warsaw'        => "(GMT+01:00) Warsaw",
			'Europe/Zagreb'        => "(GMT+01:00) Zagreb",
			'Europe/Athens'        => "(GMT+02:00) Athens",
			'Europe/Bucharest'     => "(GMT+02:00) Bucharest",
			'Africa/Cairo'         => "(GMT+02:00) Cairo",
			'Africa/Harare'        => "(GMT+02:00) Harare",
			'Europe/Helsinki'      => "(GMT+02:00) Helsinki",
			'Europe/Istanbul'      => "(GMT+02:00) Istanbul",
			'Asia/Jerusalem'       => "(GMT+02:00) Jerusalem",
			'Europe/Kiev'          => "(GMT+02:00) Kyiv",
			'Europe/Minsk'         => "(GMT+02:00) Minsk",
			'Europe/Riga'          => "(GMT+02:00) Riga",
			'Europe/Sofia'         => "(GMT+02:00) Sofia",
			'Europe/Tallinn'       => "(GMT+02:00) Tallinn",
			'Europe/Vilnius'       => "(GMT+02:00) Vilnius",
			'Asia/Baghdad'         => "(GMT+03:00) Baghdad",
			'Asia/Kuwait'          => "(GMT+03:00) Kuwait",
			'Africa/Nairobi'       => "(GMT+03:00) Nairobi",
			'Asia/Riyadh'          => "(GMT+03:00) Riyadh",
			'Europe/Moscow'        => "(GMT+03:00) Moscow",
			'Asia/Tehran'          => "(GMT+03:30) Tehran",
			'Asia/Baku'            => "(GMT+04:00) Baku",
			'Europe/Volgograd'     => "(GMT+04:00) Volgograd",
			'Asia/Muscat'          => "(GMT+04:00) Muscat",
			'Asia/Tbilisi'         => "(GMT+04:00) Tbilisi",
			'Asia/Yerevan'         => "(GMT+04:00) Yerevan",
			'Asia/Kabul'           => "(GMT+04:30) Kabul",
			'Asia/Karachi'         => "(GMT+05:00) Karachi",
			'Asia/Tashkent'        => "(GMT+05:00) Tashkent",
			'Asia/Kolkata'         => "(GMT+05:30) Kolkata",
			'Asia/Kathmandu'       => "(GMT+05:45) Kathmandu",
			'Asia/Yekaterinburg'   => "(GMT+06:00) Ekaterinburg",
			'Asia/Almaty'          => "(GMT+06:00) Almaty",
			'Asia/Dhaka'           => "(GMT+06:00) Dhaka",
			'Asia/Novosibirsk'     => "(GMT+07:00) Novosibirsk",
			'Asia/Bangkok'         => "(GMT+07:00) Bangkok",
			'Asia/Jakarta'         => "(GMT+07:00) Jakarta",
			'Asia/Krasnoyarsk'     => "(GMT+08:00) Krasnoyarsk",
			'Asia/Chongqing'       => "(GMT+08:00) Chongqing",
			'Asia/Hong_Kong'       => "(GMT+08:00) Hong Kong",
			'Asia/Kuala_Lumpur'    => "(GMT+08:00) Kuala Lumpur",
			'Australia/Perth'      => "(GMT+08:00) Perth",
			'Asia/Singapore'       => "(GMT+08:00) Singapore",
			'Asia/Taipei'          => "(GMT+08:00) Taipei",
			'Asia/Ulaanbaatar'     => "(GMT+08:00) Ulaan Bataar",
			'Asia/Urumqi'          => "(GMT+08:00) Urumqi",
			'Asia/Irkutsk'         => "(GMT+09:00) Irkutsk",
			'Asia/Seoul'           => "(GMT+09:00) Seoul",
			'Asia/Tokyo'           => "(GMT+09:00) Tokyo",
			'Australia/Adelaide'   => "(GMT+09:30) Adelaide",
			'Australia/Darwin'     => "(GMT+09:30) Darwin",
			'Asia/Yakutsk'         => "(GMT+10:00) Yakutsk",
			'Australia/Brisbane'   => "(GMT+10:00) Brisbane",
			'Australia/Canberra'   => "(GMT+10:00) Canberra",
			'Pacific/Guam'         => "(GMT+10:00) Guam",
			'Australia/Hobart'     => "(GMT+10:00) Hobart",
			'Australia/Melbourne'  => "(GMT+10:00) Melbourne",
			'Pacific/Port_Moresby' => "(GMT+10:00) Port Moresby",
			'Australia/Sydney'     => "(GMT+10:00) Sydney",
			'Asia/Vladivostok'     => "(GMT+11:00) Vladivostok",
			'Asia/Magadan'         => "(GMT+12:00) Magadan",
			'Pacific/Auckland'     => "(GMT+12:00) Auckland",
			'Pacific/Fiji'         => "(GMT+12:00) Fiji",
		);
return $timezones;
}

public function get_single_unread_message($to_id) {

	$sql = 'SELECT * FROM umb_chat_messages WHERE to_id = ? and is_read = ?';
	$binds = array($to_id,0);
	$query = $this->db->query($sql, $binds); 
	return $query->num_rows();
}

public function check_email_client($client_email) {

	$sql = 'SELECT * FROM umb_clients WHERE email = ?';
	$binds = array($client_email);
	$query = $this->db->query($sql, $binds); 
	return $query->num_rows();
}	

public function get_department_karyawans($to_id) {

	$sql = 'SELECT * FROM umb_karyawans WHERE department_id = ? and user_role_id!=1';
	$binds = array($to_id);
	$query = $this->db->query($sql, $binds); 
	return $query->result();
}

public function get_department_karyawans_cutii($karyawan_id) {

	$sql = 'SELECT * FROM umb_applications_cuti WHERE karyawan_id = ?';
	$binds = array($karyawan_id);
	$query = $this->db->query($sql, $binds);

	if ($query->num_rows() > 0) {
		return $query->result();
	} else {
		return null;
	}
}

public function get_perusahaan_department_karyawans($to_id) {

	$sql = 'SELECT * FROM umb_departments WHERE perusahaan_id = ?';
	$binds = array($to_id);
	$query = $this->db->query($sql, $binds); 
	if ($query->num_rows() > 0) {
		return $query->result();
	} else {
		return null;
	}
}
public function tanggal_ke_tahun_pajak_pendapatan($gaji_bulan,$user_id) {

	$st_date = date('Y').'-01-01';
	$gaji_bulan = $gaji_bulan.'-01';
	$sql = "SELECT * FROM umb_gaji_slipgajii WHERE (gaji_bulan BETWEEN ? AND ?) and karyawan_id = ?";
	$binds = array($st_date,$gaji_bulan,$user_id);
	$query = $this->db->query($sql, $binds); 
	if ($query->num_rows() > 0) {
		return $query->result();
	} else {
		return null;
	}
}
public function tanggal_ke_tahun_ssempee($gaji_bulan,$user_id) {
		//SELECT * FROM `umb_gaji_slipgajii` WHERE  (gaji_bulan BETWEEN '2018-01-01' AND '2018-08-01')
	$st_date = date('Y').'-01-01';
	$gaji_bulan = $gaji_bulan.'-01';
	$sql = "SELECT * FROM umb_gaji_slipgajii WHERE (gaji_bulan BETWEEN ? AND ?) and karyawan_id = ?";
	$binds = array($st_date,$gaji_bulan,$user_id);
	$query = $this->db->query($sql, $binds); 
	if ($query->num_rows() > 0) {
		return $query->result();
	} else {
		return null;
	}
}
public function tanggal_ke_tahun_ssempeer($gaji_bulan,$user_id) {

	$st_date = date('Y').'-01-01';
	$gaji_bulan = $gaji_bulan.'-01';
	$sql = "SELECT * FROM umb_gaji_slipgajii WHERE (gaji_bulan BETWEEN ? AND ?) and karyawan_id = ?";
	$binds = array($st_date,$gaji_bulan,$user_id);
	$query = $this->db->query($sql, $binds); 
	if ($query->num_rows() > 0) {
		return $query->result();
	} else {
		return null;
	}
}

public function get_location_kehadiran_karyawan($karyawan_id,$tanggal_kehadiran) {

	$sql = 'SELECT * FROM umb_kehadiran_waktu WHERE karyawan_id = ? and tanggal_kehadiran = ? order by waktu_kehadiran_id desc limit 1';
	$binds = array($karyawan_id,$tanggal_kehadiran);
	$query = $this->db->query($sql, $binds); 
	if ($query->num_rows() > 0) {
		return $query->result();
	} else {
		return null;
	}
}

public function get_content_animate(){
	$val = 'animated fadeInRight';
	return $val;
}

public function hrastral_version() {
	$current_version = 'v1.0.1';
	return $current_version;
}

public function license_perusahaan_kadaluarsa() {
	$query = $this->db->query("SELECT `document_id`, `tanggal_kaaluarsa`, `nama_license`, `nomor_license`,
		DATE_ADD(
		tanggal_kaaluarsa, 
		INTERVAL IF(DAYOFYEAR(tanggal_kaaluarsa) >= DAYOFYEAR(CURDATE()),
		YEAR(CURDATE())-YEAR(tanggal_kaaluarsa),
		YEAR(CURDATE())-YEAR(tanggal_kaaluarsa)+1
		) YEAR
		) AS `etanggal_kaaluarsa`
		FROM `umb_documents_perusahaan` 
		WHERE 
		`tanggal_kaaluarsa` IS NOT NULL
		HAVING 
		`tanggal_kaaluarsa` BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 1 MONTH)
		ORDER BY `tanggal_kaaluarsa`");
	return $query->result();
}

public function license_perusahaans_kadaluarsaa() {
	$curr_date = date('Y-m-d');
	$query = $this->db->query("SELECT * from umb_documents_perusahaan where tanggal_kaaluarsa < '".$curr_date."' ORDER BY `tanggal_kaaluarsa` asc");
	return $query->result();
}

public function read_info_khdrn_karyawan($id) {
	
	$sql = 'SELECT * FROM umb_karyawans WHERE user_id = ?';
	$binds = array($id);
	$query = $this->db->query($sql, $binds);
	return $query;
}

public function get_perusahaan_karyawans($perusahaan_id) {

	$sql = 'SELECT * FROM umb_karyawans WHERE perusahaan_id = ?';
	$binds = array($perusahaan_id);
	$query = $this->db->query($sql, $binds); 
	return $query;
}

public function count_all_licence_perusahaan_kadaluarsa() {
	$curr_date = date('Y-m-d');
	$query = $this->db->query("SELECT * from umb_documents_perusahaan where tanggal_kaaluarsa < '".$curr_date."' ORDER BY `tanggal_kaaluarsa` asc");
	return $query;
}

public function count_get_all_documents_kadaluarsa() {

	$curr_date = date('Y-m-d');
	$query = $this->db->query("SELECT * from umb_documents_karyawan where tanggal_kadaluarsa < '".$curr_date."' ORDER BY `tanggal_kadaluarsa` asc");
	return $query->num_rows();
}

public function count_get_user_all_documents_kadaluarsa($karyawan_id) {

	$curr_date = date('Y-m-d');
	$query = $this->db->query("SELECT * from umb_documents_karyawan where karyawan_id = '".$karyawan_id."' and tanggal_kadaluarsa < '".$curr_date."' ORDER BY `tanggal_kadaluarsa` asc");
	return $query->num_rows();
}


public function count_get_all_img_documents_kadaluarsa() {

	$curr_date = date('Y-m-d');
	$query = $this->db->query("SELECT * from umb_karyawan_immigration where tanggal_kaaluarsa < '".$curr_date."' ORDER BY `tanggal_kaaluarsa` asc");
	return $query->num_rows();
}

public function count_get_user_all_img_documents_kadaluarsa($karyawan_id) {

	$curr_date = date('Y-m-d');
	$query = $this->db->query("SELECT * from umb_karyawan_immigration where karyawan_id = '".$karyawan_id."' and tanggal_kaaluarsa < '".$curr_date."' ORDER BY `tanggal_kaaluarsa` asc");
	return $query->num_rows();
}

public function iicount_all_licence_perusahaan_kadaluarsa() {
	$curr_date = date('Y-m-d');
	$query = $this->db->query("SELECT * from umb_documents_perusahaan where tanggal_kaaluarsa < '".$curr_date."' ORDER BY `tanggal_kaaluarsa` asc");
	return $query->num_rows();
}

public function count_get_licence_perusahaan_kadaluarsa($perusahaan_id) {
	
	$curr_date = date('Y-m-d');
	$sql = "SELECT * FROM umb_documents_perusahaan WHERE tanggal_kaaluarsa < '".$curr_date."' and perusahaan_id = ?";
	$binds = array($perusahaan_id);
	$query = $this->db->query($sql, $binds);
	return $query->num_rows();
}

public function count_all_garansi_assets_kadaluarsa() {
	$curr_date = date('Y-m-d');
	$query = $this->db->query("SELECT * from umb_assets where tanggal_akhir_garansi < '".$curr_date."' ORDER BY `tanggal_akhir_garansi` asc");
	return $query->num_rows();
}

public function count_user_all_garansi_assets_kadaluarsa($karyawan_id) {
	$curr_date = date('Y-m-d');
	$query = $this->db->query("SELECT * from umb_assets where karyawan_id = '".$karyawan_id."' and tanggal_akhir_garansi < '".$curr_date."' ORDER BY `tanggal_akhir_garansi` asc");
	return $query->num_rows();
}

public function count_all_garansi_assets_perusahaan_kadaluarsa($perusahaan_id) {
	$curr_date = date('Y-m-d');
	$query = $this->db->query("SELECT * from umb_assets where perusahaan_id = '".$perusahaan_id."' and tanggal_akhir_garansi < '".$curr_date."' ORDER BY `tanggal_akhir_garansi` asc");
	return $query->num_rows();
}

public function get_panel_projects_client($client_id) {

	$sql = 'SELECT * FROM umb_projects WHERE client_id = ?';
	$binds = array($client_id);
	$query = $this->db->query($sql, $binds); 
	return $query->result();
}

public function get_panel_project_tugass_client($project_id) {

	$sql = 'SELECT * FROM umb_tugass WHERE project_id = ?';
	$binds = array($project_id);
	$query = $this->db->query($sql, $binds); 
	return $query;
}

public function read_email_config_info($id) {
	
	$sql = 'SELECT * FROM umb_email_configuration WHERE email_config_id = ?';
	$binds = array($id);
	$query = $this->db->query($sql, $binds);

	if ($query->num_rows() > 0) {
		return $query->result();
	} else {
		return null;
	}
}

public function get_type_security_level() {
	return  $query = $this->db->query("SELECT * from umb_security_level");
}

public function add_security_level($data){
	$this->db->insert('umb_security_level', $data);
	if ($this->db->affected_rows() > 0) {
		return true;
	} else {
		return false;
	}
}

public function read_security_level($id) {
	
	$sql = 'SELECT * FROM umb_security_level where type_id = ?';
	$binds = array($id);
	$query = $this->db->query($sql, $binds);

	if ($query->num_rows() > 0) {
		return $query->result();
	} else {
		return null;
	}
}

public function update_record_security_level($data, $id){
	$this->db->where('type_id', $id);
	if( $this->db->update('umb_security_level',$data)) {
		return true;
	} else {
		return false;
	}		
}

public function delete_record_security_level($id){
	$this->db->where('type_id', $id);
	$this->db->delete('umb_security_level');

}

public function get_type_sukubangsa() {
	return  $query = $this->db->query("SELECT * from umb_type_sukubangsa");
}

public function add_type_sukubangsa($data){
	$this->db->insert('umb_type_sukubangsa', $data);
	if ($this->db->affected_rows() > 0) {
		return true;
	} else {
		return false;
	}
}

public function delete_record_type_sukubangsa($id){
	$this->db->where('type_sukubangsa_id', $id);
	$this->db->delete('umb_type_sukubangsa');
}

public function read_type_sukubangsa($id) {
	
	$sql = 'SELECT * FROM umb_type_sukubangsa where type_sukubangsa_id = ?';
	$binds = array($id);
	$query = $this->db->query($sql, $binds);

	if ($query->num_rows() > 0) {
		return $query->result();
	} else {
		return null;
	}
}

public function update_record_type_sukubangsa($data, $id){
	$this->db->where('type_sukubangsa_id', $id);
	if( $this->db->update('umb_type_sukubangsa',$data)) {
		return true;
	} else {
		return false;
	}		
}

public function get_kategoris_pendapatan() {
	return  $query = $this->db->query("SELECT * from umb_kategoris_pendapatan");
}

public function add_type_pendapatan($data){
	$this->db->insert('umb_kategoris_pendapatan', $data);
	if ($this->db->affected_rows() > 0) {
		return true;
	} else {
		return false;
	}
}

public function read_type_pendapatan($id) {
	
	$sql = 'SELECT * FROM umb_kategoris_pendapatan where kategori_id = ?';
	$binds = array($id);
	$query = $this->db->query($sql, $binds);

	if ($query->num_rows() > 0) {
		return $query->result();
	} else {
		return null;
	}
}

public function update_record_type_pendapatan($data, $id){
	$this->db->where('kategori_id', $id);
	if( $this->db->update('umb_kategoris_pendapatan',$data)) {
		return true;
	} else {
		return false;
	}		
}

public function delete_record_type_pendapatan($id){
	$this->db->where('kategori_id', $id);
	$this->db->delete('umb_kategoris_pendapatan');
}

public function get_count_awards_karyawan($id) {

	$sql = 'SELECT * FROM umb_awards WHERE karyawan_id = ?';
	$binds = array($id);
	$query = $this->db->query($sql, $binds);
	return $query->num_rows();
}

public function get_count_karyawan_training($id) {
	
	$sql = "SELECT * FROM `umb_training` where karyawan_id like '%$id,%' or karyawan_id like '%,$id%' or karyawan_id = '$id'";
	$binds = array($id);
	$query = $this->db->query($sql, $binds);
	return $query->num_rows();
}

public function get_count_peringatan_karyawan($id) {

	$sql = 'SELECT * FROM umb_peringatans_karyawan WHERE peringatan_ke = ?';
	$binds = array($id);
	$query = $this->db->query($sql, $binds);
	return $query->num_rows();
}

public function get_count_perjalanan_karyawan($id) {

	$sql = 'SELECT * FROM umb_perjalanans_karyawan WHERE karyawan_id = ?';
	$binds = array($id);
	$query = $this->db->query($sql, $binds);
	return $query->num_rows();
}

public function get_count_tickets_karyawan($id) {

	$sql = 'SELECT st.*, ste.* FROM umb_support_tickets as st, umb_support_tickets_karyawans as ste WHERE st.ticket_id=ste.ticket_id and (ste.karyawan_id = ? || st.created_by = ?)';
	$binds = array($id,$id);
	$this->db->group_by("st.ticket_id");
	$query = $this->db->query($sql, $binds);
	return $query->num_rows();
}

public function get_count_projects_karyawan($id) {
	
	$sql = "SELECT * FROM `umb_projects` where assigned_to like '%$id,%' or assigned_to like '%,$id%' or assigned_to = '$id'";
	$binds = array($id);
	$query = $this->db->query($sql, $binds);
	return $query->num_rows();
}

public function get_count_tugass_karyawan($id) {
	
	$sql = "SELECT * FROM `umb_tugass` where assigned_to like '%$id,%' or assigned_to like '%,$id%' or assigned_to = '$id'";
	$binds = array($id);
	$query = $this->db->query($sql, $binds);
	return $query->num_rows();
}

public function get_count_assets_karyawan($id) {
	//$id = $this->db->escape($id);
	$sql = 'SELECT * FROM umb_assets WHERE karyawan_id = ?';
	$binds = array($id);
	$query = $this->db->query($sql, $binds);

	return $query->num_rows();
}

public function get_count_meetings_karyawan($id) {

	$sql = "SELECT * FROM umb_meetings WHERE karyawan_id like '%$id,%' or karyawan_id like '%,$id%' or karyawan_id = '$id'";
	$binds = array($id);
	$query = $this->db->query($sql, $binds);
	return $query->num_rows();
}

public function get_count_events_karyawan($id) {

	$sql = "SELECT * FROM umb_events WHERE karyawan_id like '%$id,%' or karyawan_id like '%,$id%' or karyawan_id = '$id'";
	$binds = array($id);
	$query = $this->db->query($sql, $binds);
	return $query->num_rows();
}

public function all_active_departments_karyawans(){
	$session = $this->session->userdata('username');
	$euser_info = $this->read_user_info($session['user_id']);
	$sql = 'SELECT * FROM umb_karyawans WHERE is_active = ? and department_id = ?';
	$binds = array(1,$euser_info[0]->department_id);
	$query = $this->db->query($sql, $binds);
	return $query->result();
}

public function get_group_chat() {
	$query = $this->db->query('SELECT * FROM umb_chat_groups');
	return $query->result();
}

public function sum_the_time($time1, $time2) {
	$times = array($time1, $time2);
	$seconds = 0;
	foreach ($times as $time)
	{
		list($hour,$minute,$second) = explode(':', $time);
		$seconds += $hour*3600;
		$seconds += $minute*60;
		$seconds += $second;
	}
	$hours = floor($seconds/3600);
	$seconds -= $hours*3600;
	$minutes  = floor($seconds/60);
	$seconds -= $minutes*60;
	if($seconds < 9)
	{
		$seconds = "0".$seconds;
	}
	if($minutes < 9)
	{
		$minutes = "0".$minutes;
	}
	if($hours < 9)
	{
		$hours = "0".$hours;
	}
	return "{$hours}:{$minutes}:{$seconds}";
}

public function actual_hours_timelog($project_id) {
	$sql = 'SELECT * FROM umb_projects_timelogs WHERE project_id = ?';
	$binds = array($project_id);
	$query = $this->db->query($sql, $binds);
	$qry_ac = $query->result();
	$total_hrs = 0;
	$hrs_old_seconds = 0;
	$hrs_old_int1 = 0;
	$Total = 0;
	foreach($qry_ac as $r){
			// total work			
		$timee = $r->total_hours.':00';
		$str_time =$timee;

		$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);

		sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);

		$hrs_old_seconds = $hours * 3600 + $minutes * 60 + $seconds;

		$hrs_old_int1 += $hrs_old_seconds;

		$Total = gmdate("H:i", $hrs_old_int1);
	}
	return $Total;
}

public function get_multi_perusahaan_karyawans($id) {

	$sql = "SELECT * FROM umb_karyawans WHERE perusahaan_id like '%$id,%' or perusahaan_id like '%,$id%' or perusahaan_id = '$id' and user_role_id!=1";
	$binds = array($id);
	$query = $this->db->query($sql, $binds);
	return $query->result();
}

public function get_perusahaan_clients($id) {

	$sql = "SELECT * FROM umb_projects WHERE perusahaan_id like '%$id,%' or perusahaan_id like '%,$id%' or perusahaan_id = '$id'";
	$binds = array($id);
	$query = $this->db->query($sql, $binds);
	return $query->result();
}

public function read_info_kategori_tugas($id) {
	
	$sql = 'SELECT * FROM umb_kategoris_tugas WHERE kategori_tugas_id = ?';
	$binds = array($id);
	$query = $this->db->query($sql, $binds);

	if ($query->num_rows() > 0) {
		return $query->result();
	} else {
		return null;
	}
}

public function hrastral_notifications($module_name,$karyawan_id) {
	
	$sql = 'SELECT * FROM umb_hrastral_notificaions WHERE module_name = ? and karyawan_id = ? and is_notify = ?';
	$binds = array($module_name,$karyawan_id,1);
	$query = $this->db->query($sql, $binds);
	return $query->result();
}

public function hrastral_notifications_count($module_name,$karyawan_id) {
	
	$sql = 'SELECT * FROM umb_hrastral_notificaions WHERE module_name = ? and karyawan_id = ? and is_notify = ?';
	$binds = array($module_name,$karyawan_id,1);
	$query = $this->db->query($sql, $binds);
	return $query->num_rows();
}

public function add_notifications($data){
	$this->db->insert('umb_hrastral_notificaions', $data);
	if ($this->db->affected_rows() > 0) {
		return true;
	} else {
		return false;
	}
}

public function update_notification_record($data, $id,$karyawan_id,$module_name){
	
	$this->db->where('module_id', $id);
	$this->db->where('karyawan_id', $karyawan_id);
	$this->db->where('module_name', $module_name);
	if( $this->db->update('umb_hrastral_notificaions',$data)) {
		return true;
	} else {
		return false;
	}
}

public function total_cuti_slipgaji($from_date,$user_id) {
	
	$sql = "SELECT * FROM umb_applications_cuti WHERE from_date LIKE '%$from_date%' and status = 2 and karyawan_id = '$user_id'";
	$query = $this->db->query($sql);
	$res = $query->result();
	if ($query->num_rows() > 0) {
		$no_of_days = 0;
		foreach($res as $r){
			$datetime1 = new DateTime($r->from_date);
			$datetime2 = new DateTime($r->to_date);
			$interval = $datetime1->diff($datetime2);
			if($r->is_half_day == 1){
				$no_of_days += 0.5;
			} else {
				if(strtotime($r->from_date) == strtotime($r->to_date)){
					$no_of_days += 1;
				} else {
					$no_of_days += $interval->format('%a') + 1;
				}
			}
		}
		return $no_of_days;
	} else {
		return $no_of_days = 0;
	}
}

public function count_total_cuti_slipgaji($from_date,$user_id) {
	
	$sql = "SELECT * FROM umb_applications_cuti WHERE from_date LIKE '%$from_date%' and status = 2 and karyawan_id = '$user_id'";
	$query = $this->db->query($sql);
	return $query->num_rows();
}

public function res_total_cuti_slipgaji($from_date,$user_id) {
	
	$sql = "SELECT * FROM umb_applications_cuti WHERE from_date LIKE '%$from_date%' and status = 2 and karyawan_id = '$user_id'";
	$query = $this->db->query($sql);
	$res = $query->result();
	return $res;
}

}
?>