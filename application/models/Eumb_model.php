<?php

class Eumb_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
	
	public function read_info_location($id) {
		
		$sql = 'SELECT * FROM umb_departments WHERE department_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		$condition = "location_id =" . "'" . $id . "'";
		$this->db->select('*');
		$this->db->from('umb_location_kantor');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function read_info_karyawan($id) {
		
		$sql = 'SELECT * FROM umb_departments WHERE department_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		$condition = "user_id =" . "'" . $id . "'";
		$this->db->select('*');
		$this->db->from('umb_karyawans');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		
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
		
		$sql = 'SELECT * FROM umb_departments WHERE department_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		$condition = "user_id =" . "'" . $id . "'";
		$this->db->select('*');
		$this->db->from('umb_karyawans');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		
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
	

	public function dash_total_awards_karyawan() {
		
		$session = $this->session->userdata('username');
		$sql = 'SELECT * FROM umb_awards WHERE karyawan_id = ?';
		$binds = array($session['user_id']);
		$query = $this->db->query($sql, $binds);
		
		return $query->num_rows();
	}
	
	public function dash_total_biaya_karyawan() {
		
		$session = $this->session->userdata('username');
		$sql = 'SELECT * FROM umb_biayaa WHERE karyawan_id = ?';
		$binds = array($session['user_id']);
		$query = $this->db->query($sql, $binds);
		
		return $query->num_rows();
	}
	
	public function dash_total_perjalanan_karyawan() {
		
		$session = $this->session->userdata('username');
		$sql = 'SELECT * FROM umb_perjalanans_karyawan WHERE karyawan_id = ?';
		$binds = array($session['user_id']);
		$query = $this->db->query($sql, $binds);

		return $query->num_rows();
	}
	
	public function get_completed_tugass($tugas_id) {
		
		$sql = 'SELECT * FROM umb_tugass WHERE tugas_id = ? and status_tugas = ?';
		$binds = array($tugas_id,2);
		$query = $this->db->query($sql, $binds);
		
		return $query->num_rows();
	}

	public function get_overdue_tugass($tugas_id) {
		
		$date = date('Y-m-d');
		$sql = 'SELECT * FROM umb_tugass WHERE tugas_id = ? and end_date < ? and status_tugas != ?';
		$binds = array($tugas_id,$date,2);
		$query = $this->db->query($sql, $binds);
		
		return $query->num_rows();
	}

	public function get_todo_tugass($tugas_id) {
		
		$date = date('Y-m-d');
		$sql = 'SELECT * FROM umb_tugass WHERE tugas_id = ?  and end_date > ? and status_tugas != ?';
		$binds = array($tugas_id,$date,2);
		$query = $this->db->query($sql, $binds);
		
		return $query->num_rows();
	}
	
	public function get_negaraa() {
		$query = $this->db->query("SELECT * from umb_negaraa");
		return $query->result();
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
	
	public function read_sx_info_perusahaan($id) {
		
		$sql = 'SELECT * FROM umb_perusahaans WHERE perusahaan_id = ?';
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
		$binds = array(0000);
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
		
		$sql = 'SELECT * FROM umb_users WHERE email = ?';
		$binds = array($email);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}
	
	public function checks_waktu_kehadiran($id) {

		$session = $this->session->userdata('username');
		$sql = 'SELECT * FROM umb_kehadiran_waktu WHERE `karyawan_id` = ? and clock_out = ? order by waktu_kehadiran_id desc limit 1';
		$binds = array($id, '');
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}
	
	public function read_user_info_melalui_penunjukan($id) {
		
		$sql = 'SELECT * FROM umb_karyawans WHERE penunjukan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query->result();
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
		return 'Software HR ASTRAL | Astral Permai';
	}
	
	public function get_perusahaans() {
		$query = $this->db->query("SELECT * from umb_perusahaans");
		return $query->result();
	}
	
	public function get_applications_cuti()
	{
		$query = $this->db->query("SELECT * from umb_applications_cuti");
		return $query->result();
	}
	
	public function get_applications_cuti_terakhir()
	{
		$query = $this->db->query("SELECT * from umb_applications_cuti order by cuti_id desc limit 5");
		return $query->result();
	}
	
	public function currency_sign($number) {
		
		$system_setting = $this->read_setting_info(1);
		if($system_setting[0]->show_currency=='code'){
			$ar_sc = explode(' -',$system_setting[0]->default_currency_symbol);
			$sc_show = $ar_sc[0];
		} else {
			$ar_sc = explode('- ',$system_setting[0]->default_currency_symbol);
			$sc_show = $ar_sc[1];
		}
		if($system_setting[0]->currency_position=='Prefix'){
			$sign_value = $sc_show.''.$number;
		} else {
			$sign_value = $number.''.$sc_show;
		}
		return $sign_value;
	}
	
	public function all_locations()
	{
		$query = $this->db->query("SELECT * from umb_location_kantor");
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
	
	public function all_karyawans()
	{
		$query = $this->db->query("SELECT * from umb_karyawans");
		return $query->result();
	}
	
	public function all_customers()
	{
		$query = $this->db->query("SELECT * from umb_customers");
		return $query->result();
	}
	
	public function all_suppliers()
	{
		$query = $this->db->query("SELECT * from umb_suppliers");
		return $query->result();
	}
	
	public function all_agents()
	{
		$query = $this->db->query("SELECT * from umb_agents");
		return $query->result();
	}
	
	public function set_date_format($date) {
		
		$system_setting = $this->read_setting_info(1);
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
		
		$system_setting = $this->read_setting_info(1);
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
	
	public function add_type_exit($data){
		$this->db->insert('umb_karyawan_type_exit', $data);
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
	
	public function empat_karyawan_terakhir() {
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

	public function all_perusahaans_chart() {
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
	
	public function all_location_chart() {
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
	
	public function all_chart_departments()
	{
		$this->db->query("SET SESSION sql_mode = ''");
		$query = $this->db->query("SELECT m.*, d.* FROM umb_melakukan_pembayaran as m, umb_departments as d where m.department_id = d.department_id group by m.department_id");
		return $query->result();
	}
	
	public function get_department_melakukan_pembayaran($id) {
		
		$sql = 'SELECT SUM(jumlah_pembayaran) as bayar_jumlah FROM umb_melakukan_pembayaran where department_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query->result();
	}
	
	public function all_penunjukans_chart()
	{
		$this->db->query("SET SESSION sql_mode = ''");
		$query = $this->db->query("SELECT m.*, d.* FROM umb_melakukan_pembayaran as m, umb_penunjukans as d where m.penunjukan_id = d.penunjukan_id group by m.penunjukan_id");
		return $query->result();
	}
	
	public function get_penunjukan_melakukan_pembayaran($id) {
		
		$sql = 'SELECT SUM(jumlah_pembayaran) as bayar_jumlah FROM umb_melakukan_pembayaran where penunjukan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
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
		
		$sql = 'SELECT * FROM umb_type_biaya where type_biaya_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		$condition = "type_pekerjaan_id =" . "'" . $id . "'";
		$this->db->select('*');
		$this->db->from('umb_type_pekerjaan');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		
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
	
	public function current_bulan_kehadiran() {
		$current_month = date('Y-m');
		$session = $this->session->userdata('username');
		$this->db->query("SET SESSION sql_mode = ''");
		$sql = 'SELECT * FROM umb_kehadiran_waktu where tanggal_kehadiran like ? and `karyawan_id` = ? group by tanggal_kehadiran';
		$binds = array('%'.$current_month.'%', $session['user_id']);
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
		
		$sql = 'SELECT * FROM umb_support_tickets where status_ticket = ?';
		$binds = array(1);
		$query = $this->db->query($sql, $binds);
		
		return $query->num_rows();
	}
	
	public function all_closed_tickets() {
		
		$sql = 'SELECT * FROM umb_support_tickets where status_ticket = ?';
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
}
?>