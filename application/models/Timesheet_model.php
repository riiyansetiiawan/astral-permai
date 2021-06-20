<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Timesheet_model extends CI_Model {

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function get_shifts_kantor() {
		return $this->db->get("umb_shift_kantor");
	}
	
	public function get_tugass() {
		return $this->db->get("umb_tugass");
	}
	
	public function get_project_tugass($id) {
		$sql = 'SELECT * FROM umb_tugass WHERE project_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}
	
	public function get_variasii_project($id) {
		$sql = 'SELECT * FROM umb_variasii_project WHERE project_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}

	public function check_kehadiran_pertama_masuk($karyawan_id,$tanggal_kehadiran) {

		$sql = 'SELECT * FROM umb_kehadiran_waktu WHERE karyawan_id = ? and tanggal_kehadiran = ? limit 1';
		$binds = array($karyawan_id,$tanggal_kehadiran);
		$query = $this->db->query($sql, $binds);

		return $query;
	}
	
	public function check_waktu_kehadiran($karyawan_id) {

		$sql = 'SELECT * FROM umb_kehadiran_waktu WHERE karyawan_id = ?';
		$binds = array($karyawan_id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function kehadiran_pertama_masuk($karyawan_id,$tanggal_kehadiran) {

		$sql = 'SELECT * FROM umb_kehadiran_waktu WHERE karyawan_id = ? and tanggal_kehadiran = ?';
		$binds = array($karyawan_id,$tanggal_kehadiran);
		$query = $this->db->query($sql, $binds);
		
		return $query->result();
	}
	
	public function check_kehadiran_pulang_pertama($karyawan_id,$tanggal_kehadiran) {

		$sql = 'SELECT * FROM umb_kehadiran_waktu WHERE karyawan_id = ? and tanggal_kehadiran = ? order by waktu_kehadiran_id desc limit 1';
		$binds = array($karyawan_id,$tanggal_kehadiran);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}
	
	public function all_types_cuti() {
		$query = $this->db->get("umb_type_cuti");
		return $query->result();
	}

	public function get_perusahaan_shifts($perusahaan_id) {

		$sql = 'SELECT * FROM umb_shift_kantor WHERE perusahaan_id = ?';
		$binds = array($perusahaan_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	public function get_perusahaan_liburan($perusahaan_id) {

		$sql = 'SELECT * FROM umb_liburan WHERE perusahaan_id = ?';
		$binds = array($perusahaan_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	public function filter_perusahaan_liburan($perusahaan_id) {

		$sql = 'SELECT * FROM umb_liburan WHERE perusahaan_id = ?';
		$binds = array($perusahaan_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	public function filter_perusahaan_publish_liburan($perusahaan_id,$is_publish) {

		$sql = 'SELECT * FROM umb_liburan WHERE perusahaan_id = ? and is_publish = ?';
		$binds = array($perusahaan_id,$is_publish);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	public function filter_perusahaan_tidak_publish_liburan($is_publish) {

		$sql = 'SELECT * FROM umb_liburan WHERE is_publish = ?';
		$binds = array($is_publish);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	public function get_perusahaan_cutii($perusahaan_id) {

		$sql = 'SELECT * FROM umb_applications_cuti WHERE perusahaan_id = ?';
		$binds = array($perusahaan_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	public function get_multi_perusahaan_cutii($perusahaan_ids) {

		$sql = 'SELECT * FROM umb_applications_cuti where perusahaan_id IN ?';
		$binds = array($perusahaan_ids);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	public function get_tugass_perusahaan($perusahaan_id) {

		$sql = 'SELECT * FROM umb_tugass WHERE perusahaan_id = ?';
		$binds = array($perusahaan_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	public function get_tugass_karyawan($id) {

		$sql = "SELECT * FROM `umb_tugass` where assigned_to like '%$id,%' or assigned_to like '%,$id%' or assigned_to = '$id'";
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	public function kehadiran_pulang_pertama($karyawan_id,$tanggal_kehadiran) {

		$sql = 'SELECT * FROM umb_kehadiran_waktu WHERE karyawan_id = ? and tanggal_kehadiran = ? order by waktu_kehadiran_id desc limit 1';
		$binds = array($karyawan_id,$tanggal_kehadiran);
		$query = $this->db->query($sql, $binds);
		
		return $query->result();
	}
	

	public function total_kehadiran_jam_bekerja($id,$tanggal_kehadiran) {
		
		$sql = 'SELECT * FROM umb_kehadiran_waktu WHERE karyawan_id = ? and tanggal_kehadiran = ? and total_kerja != ""';
		$binds = array($id,$tanggal_kehadiran);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}
	
	public function total_istirahat_kehadiran($id,$tanggal_kehadiran) {
		
		$sql = 'SELECT * FROM umb_kehadiran_waktu WHERE karyawan_id = ? and tanggal_kehadiran = ? and total_istirahat != ""';
		$binds = array($id,$tanggal_kehadiran);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}
	
	public function check_tanggal_libur($tanggal_kehadiran) {

		$sql = 'SELECT * FROM umb_liburan WHERE (start_date between start_date and end_date) or (start_date = ? or end_date = ?) limit 1';
		$binds = array($tanggal_kehadiran,$tanggal_kehadiran);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}
	
	public function get_cutii() {
		return $this->db->get("umb_applications_cuti");
	}

	public function filter_perusahaan_cutii($perusahaan_id) {

		$sql = 'SELECT * FROM umb_applications_cuti WHERE perusahaan_id = ?';
		$binds = array($perusahaan_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	public function filter_perusahaan_karyawans_cutii($perusahaan_id,$karyawan_id) {

		$sql = 'SELECT * FROM umb_applications_cuti WHERE perusahaan_id = ? and karyawan_id = ?';
		$binds = array($perusahaan_id,$karyawan_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	public function filter_perusahaan_karyawans_status_cutii($perusahaan_id,$karyawan_id,$status) {

		$sql = 'SELECT * FROM umb_applications_cuti WHERE perusahaan_id = ? and karyawan_id = ? and status = ?';
		$binds = array($perusahaan_id,$karyawan_id,$status);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	public function filter_perusahaan_only_status_cutii($perusahaan_id,$status) {

		$sql = 'SELECT * FROM umb_applications_cuti WHERE perusahaan_id = ? and status = ?';
		$binds = array($perusahaan_id,$status);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	

	public function get_karyawan_cutii($id) {
		
		$sql = 'SELECT * FROM umb_applications_cuti WHERE karyawan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	
	public function tanggal_libur($tanggal_kehadiran) {

		$sql = 'SELECT * FROM umb_liburan WHERE (start_date between start_date and end_date) or (start_date = ? or end_date = ?) limit 1';
		$binds = array($tanggal_kehadiran,$tanggal_kehadiran);
		$query = $this->db->query($sql, $binds);
		
		return $query->result();
	}
	
	public function get_liburan() {
		return $this->db->get("umb_liburan");
	}
	
	public function get_calendar_liburan() {

		$sql = 'SELECT * FROM umb_liburan WHERE is_publish = ?';
		$binds = array(1);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}
	
	public function get_calendar_permintaan_cutii() {
		return $query = $this->db->query("SELECT * from umb_applications_cuti");
	}
	
	public function chcek_tanggal_cuti($krywn_id,$tanggal_kehadiran) {

		$sql = 'SELECT * from umb_applications_cuti where (from_date between from_date and to_date) and karyawan_id = ? or from_date = ? and to_date = ? limit 1';
		$binds = array($krywn_id,$tanggal_kehadiran,$tanggal_kehadiran);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}
	
	public function tanggal_cuti($krywn_id,$tanggal_kehadiran) {

		$sql = 'SELECT * from umb_applications_cuti where (from_date between from_date and to_date) and karyawan_id = ? or from_date = ? and to_date = ? limit 1';
		$binds = array($krywn_id,$tanggal_kehadiran,$tanggal_kehadiran);
		$query = $this->db->query($sql, $binds);
		
		return $query->result();
	}
	
	public function count_total_cutii($type_cuti_id,$karyawan_id) {
		
		//$sql = 'SELECT * FROM umb_applications_cuti WHERE karyawan_id = ? and type_cuti_id = ? and status = ? and created_at >= DATE_SUB(NOW(),INTERVAL 1 YEAR)';
		$sql = 'SELECT * FROM umb_applications_cuti WHERE karyawan_id = ? and type_cuti_id = ? and status = ?';
		$binds = array($karyawan_id,$type_cuti_id,2);
		$query = $this->db->query($sql, $binds);

		return $query->result();
	}
	
	public function kehadiran_karyawan_dengan_tanggal($krywn_id,$tanggal_kehadiran) {
		
		$sql = 'SELECT * FROM umb_kehadiran_waktu where tanggal_kehadiran = ? and karyawan_id = ?';
		$binds = array($tanggal_kehadiran,$krywn_id);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}

	public function read_informasi_shift_kantor($id) {

		$sql = 'SELECT * FROM umb_shift_kantor WHERE shift_kantor_id = ? limit 1';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function read_informasi_cuti($id) {

		$sql = 'SELECT * FROM umb_applications_cuti WHERE cuti_id = ? limit 1';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function read_informasi_type_cuti($id) {

		$sql = 'SELECT * FROM umb_type_cuti WHERE type_cuti_id = ? limit 1';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function add_kehadiran_karyawan($data){
		$this->db->insert('umb_kehadiran_waktu', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function add_record_cuti($data){
		$this->db->insert('umb_applications_cuti', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function add_record_tugas($data){
		$this->db->insert('umb_tugass', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function add_variasi_projects($data){
		$this->db->insert('umb_variasii_project', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function add_record_shift_kantor($data){
		$this->db->insert('umb_shift_kantor', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function add_record_libur($data){
		$this->db->insert('umb_liburan', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function read_informasi_tugas($id) {

		$sql = 'SELECT * FROM umb_tugass WHERE tugas_id = ? limit 1';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	public function read_informasi_variasi($id) {

		$sql = 'SELECT * FROM umb_variasii_project WHERE variasi_id = ? limit 1';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function read_informasi_libur($id) {

		$sql = 'SELECT * FROM umb_liburan WHERE libur_id = ? limit 1';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function read_informasi_kehadiran($id) {

		$sql = 'SELECT * FROM umb_kehadiran_waktu WHERE waktu_kehadiran_id = ? limit 1';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function delete_record_kehadiran($id){ 
		$this->db->where('waktu_kehadiran_id', $id);
		$this->db->delete('umb_kehadiran_waktu');
	}
	
	public function delete_record_tugas($id){ 
		$this->db->where('tugas_id', $id);
		$this->db->delete('umb_tugass');
	}

	public function delete_record_variasi($id){ 
		$this->db->where('variasi_id', $id);
		$this->db->delete('umb_variasii_project');
		
	}
	
	public function delete_record_libur($id){ 
		$this->db->where('libur_id', $id);
		$this->db->delete('umb_liburan');
		
	}
	
	public function delete_record_shift($id){ 
		$this->db->where('shift_kantor_id', $id);
		$this->db->delete('umb_shift_kantor');
		
	}
	
	public function delete_record_cuti($id){ 
		$this->db->where('cuti_id', $id);
		$this->db->delete('umb_applications_cuti');
		
	}
	
	public function update_record_tugas($data, $id){
		$this->db->where('tugas_id', $id);
		if( $this->db->update('umb_tugass',$data)) {
			return true;
		} else {
			return false;
		}		
	}

	public function update_variasii_project($data, $id){
		$this->db->where('variasi_id', $id);
		if( $this->db->update('umb_variasii_project',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function update_record_cuti($data, $id){
		$this->db->where('cuti_id', $id);
		if( $this->db->update('umb_applications_cuti',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function update_record_libur($data, $id){
		$this->db->where('libur_id', $id);
		if( $this->db->update('umb_liburan',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function update_record_kehadiran($data, $id){
		$this->db->where('waktu_kehadiran_id', $id);
		if( $this->db->update('umb_kehadiran_waktu',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function update_record_shift($data, $id){
		$this->db->where('shift_kantor_id', $id);
		if( $this->db->update('umb_shift_kantor',$data)) {
			return true;
		} else {
			return false;
		}		
	}	
	
	public function update_record_default_shift($data, $id){
		$this->db->where('shift_kantor_id', $id);
		if( $this->db->update('umb_shift_kantor',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function update_default_shift_zero($data){
		$this->db->where("shift_kantor_id!=''");
		if( $this->db->update('umb_shift_kantor',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function assign_tugas_user($data, $id){
		$this->db->where('tugas_id', $id);
		if( $this->db->update('umb_tugass',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function get_comments($id) {
		
		$sql = 'SELECT * FROM umb_tugass_comments WHERE tugas_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}
	
	public function get_attachments($id) {
		
		$sql = 'SELECT * FROM umb_tugass_attachment WHERE tugas_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}
	
	public function add_comment($data){
		$this->db->insert('umb_tugass_comments', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function delete_record_comment($id){
		$this->db->where('comment_id', $id);
		$this->db->delete('umb_tugass_comments');
		
	}
	
	public function delete_record_attachment($id){
		$this->db->where('attachment_tugas_id', $id);
		$this->db->delete('umb_tugass_attachment');
		
	}
	
	public function add_new_attachment($data){
		$this->db->insert('umb_tugass_attachment', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function check_user_kehadiran() {
		$today_date = date('Y-m-d');
		$session = $this->session->userdata('username');
		$sql = 'SELECT * FROM umb_kehadiran_waktu where `karyawan_id` = ? and `tanggal_kehadiran` = ? order by waktu_kehadiran_id desc limit 1';
		$binds = array($session['user_id'],$today_date);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}
	
	public function check_user_kehadiran_clockout() {
		$today_date = date('Y-m-d');
		$session = $this->session->userdata('username');
		$sql = 'SELECT * FROM umb_kehadiran_waktu where `karyawan_id` = ? and `tanggal_kehadiran` = ? and clock_out = ? order by waktu_kehadiran_id desc limit 1';
		$binds = array($session['user_id'],$today_date,'');
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}
	
	public function add_new_kehadiran($data){
		$this->db->insert('umb_kehadiran_waktu', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function get_user_kehadiran_terakhir() {

		$session = $this->session->userdata('username');
		$sql = 'SELECT * FROM umb_kehadiran_waktu where `karyawan_id` = ? order by waktu_kehadiran_id desc limit 1';
		$binds = array($session['user_id']);
		$query = $this->db->query($sql, $binds);

		return $query->result();
	}
	
	public function checks_waktu_kehadiran($id) {

		$session = $this->session->userdata('username');
		$sql = 'SELECT * FROM umb_kehadiran_waktu where `karyawan_id` = ? and clock_out = ? order by waktu_kehadiran_id desc limit 1';
		$binds = array($id,'');
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}
	
	public function update_kehadiran_clockedout($data,$id){
		//$this->db->where("waktu_kehadiran_id!=''");
		$this->db->where('waktu_kehadiran_id', $id);
		if( $this->db->update('umb_kehadiran_waktu',$data)) {
			return true;
		} else {
			return false;
		}		
	}

	public function get_umb_karyawans() {
		
		$sql = 'SELECT * FROM umb_karyawans WHERE is_active = ? and user_role_id!=1';
		$binds = array(1);
		$query = $this->db->query($sql, $binds);
		return $query->result();
	}
	
	public function get_karyawan_cutii_department_bijaksana($department_id) {
		
		$sql = 'SELECT * FROM umb_applications_cuti WHERE department_id = ?';
		$binds = array($department_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	
	public function count_total_karyawan_cutii($type_cuti_id,$karyawan_id) {
		
		//$sql = 'SELECT * FROM umb_applications_cuti WHERE karyawan_id = ? and type_cuti_id = ? and status = ? and created_at >= DATE_SUB(NOW(),INTERVAL 1 YEAR)';
		$sql = 'SELECT * FROM umb_applications_cuti WHERE karyawan_id = ? and type_cuti_id = ? and status = ?';
		$binds = array($karyawan_id,$type_cuti_id,2);
		$query = $this->db->query($sql, $binds);
		return $query->num_rows();
	}
	

	public function show_karyawan_cuti_terakhir($karyawan_id,$cuti_id) {
		$sql = "SELECT * FROM umb_applications_cuti WHERE cuti_id != '".$cuti_id."' and karyawan_id = ? order by cuti_id desc limit 1";
		$binds = array($karyawan_id);
		$query = $this->db->query($sql, $binds);
		return $query->result();
	}
}
?>