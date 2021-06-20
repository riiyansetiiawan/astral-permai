<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payroll_model extends CI_Model{

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function get_templates() {
		return $this->db->get("umb_gaji_templates");
	}
	
	public function get_template_prsh($cid,$id) {
		
		$sql = 'SELECT * FROM umb_karyawans WHERE perusahaan_id = ? and user_role_id!=?';
		$binds = array($cid,1);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	public function get_karyawan_template_prsh($cid,$id) {
		
		$sql = 'SELECT * FROM umb_karyawans WHERE perusahaan_id = ? and user_id = ?';
		$binds = array($cid,$id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	
	public function total_jam_bekerja($id,$tanggal_kehadiran) {
		
		$sql = 'SELECT * FROM umb_kehadiran_waktu WHERE karyawan_id = ? and tanggal_kehadiran like ?';
		$binds = array($id, '%'.$tanggal_kehadiran.'%');
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	
	public function total_slipgaji_jam_bekerja($id,$tanggal_kehadiran) {
		$sql = 'SELECT * FROM umb_kehadiran_waktu WHERE karyawan_id = ? and tanggal_kehadiran like ?';
		$binds = array($id, '%'.$tanggal_kehadiran.'%');
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	
	public function get_advance_gajii() {
		return $this->db->get("umb_advance_gajii");
	}
	
	public function get_advance_gajii_single($id) {

		$sql = 'SELECT * FROM umb_advance_gajii WHERE karyawan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	
	public function get_laporan_advance_gajii() {
		$this->db->query("SET SESSION sql_mode = ''");
		$return  = $this->db->query("SELECT advance_gaji_id,karyawan_id,perusahaan_id,month_year,pengurangan_satu_kali,angsuran_bulanan,reason,status,total_yang_dibayarkan,is_dipotong_dari_gaji,created_at,SUM(`umb_advance_gajii`.advance_jumlah) AS advance_jumlah FROM `umb_advance_gajii` where status=1 group by karyawan_id");
		return $return ;
	}
	
	public function single_laporan_advance_gajii($id) {

		$this->db->query("SET SESSION sql_mode = ''");
		$sql = 'SELECT advance_gaji_id,karyawan_id,perusahaan_id,month_year,pengurangan_satu_kali,angsuran_bulanan,reason,status,total_yang_dibayarkan,is_dipotong_dari_gaji,created_at,SUM(`umb_advance_gajii`.advance_jumlah) AS advance_jumlah FROM `umb_advance_gajii` where status=1 and karyawan_id = ? group by karyawan_id';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	
	public function all_history_pembayaran() {
		return $this->db->get("umb_melakukan_pembayaran");
	}

	public function karyawans_history_pembayaran() {
		return $this->db->get("umb_gaji_slipgajii");
	}

	public function get_currency_converter() {
		return $this->db->get("umb_currency_converter");
	}
	
	public function get_payroll_slip($id) {
		
		$sql = 'SELECT * FROM umb_gaji_slipgajii WHERE karyawan_id = ? and status = ?';
		$binds = array($id,2);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	public function get_perusahaan_slipgajii($id) {
		
		$sql = 'SELECT * FROM umb_gaji_slipgajii WHERE perusahaan_id = ? and status = ?';
		$binds = array($id,2);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	public function all_karyawans_history_pembayaran() {
		$sql = 'SELECT * FROM umb_gaji_slipgajii';
		$query = $this->db->query($sql);
		return $query;
	}

	public function all_karyawans_history_pembayaran_bulan($gaji_bulan) {
		$sql = 'SELECT * FROM umb_gaji_slipgajii WHERE gaji_bulan = ?';
		$binds = array($gaji_bulan);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	public function get_history_slipgaji_perusahaan($perusahaan_id) {
		
		$sql = 'SELECT * FROM umb_gaji_slipgajii WHERE perusahaan_id = ?';
		$binds = array($perusahaan_id,$gaji_bulan);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	public function get_history_slipgaji_perusahaan_bulan($perusahaan_id,$gaji_bulan) {
		
		$sql = 'SELECT * FROM umb_gaji_slipgajii WHERE perusahaan_id = ? and gaji_bulan = ?';
		$binds = array($perusahaan_id,$gaji_bulan);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	public function get_perusahaan_location_slipgajii($perusahaan_id,$location_id) {
		
		$sql = 'SELECT * FROM umb_gaji_slipgajii WHERE perusahaan_id = ? and location_id = ?';
		$binds = array($perusahaan_id,$location_id,$gaji_bulan);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	public function get_perusahaan_location_slipgajii_bulan($perusahaan_id,$location_id,$gaji_bulan) {
		
		$sql = 'SELECT * FROM umb_gaji_slipgajii WHERE perusahaan_id = ? and location_id = ? and gaji_bulan = ?';
		$binds = array($perusahaan_id,$location_id,$gaji_bulan);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	public function get_perusahaan_location_department_slipgajii($perusahaan_id,$location_id,$department_id) {
		
		$sql = 'SELECT * FROM umb_gaji_slipgajii WHERE perusahaan_id = ? and location_id = ? and department_id = ?';
		$binds = array($perusahaan_id,$location_id,$department_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	public function get_perusahaan_location_department_slipgajii_month($perusahaan_id,$location_id,$department_id,$gaji_bulan) {
		
		$sql = 'SELECT * FROM umb_gaji_slipgajii WHERE perusahaan_id = ? and location_id = ? and department_id = ? and gaji_bulan = ?';
		$binds = array($perusahaan_id,$location_id,$department_id,$gaji_bulan);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	public function get_perusahaan_location_department_penunjukan_slipgajii($perusahaan_id,$location_id,$department_id,$penunjukan_id) {
		
		$sql = 'SELECT * FROM umb_gaji_slipgajii WHERE perusahaan_id = ? and location_id = ? and department_id = ? and penunjukan_id = ?';
		$binds = array($perusahaan_id,$location_id,$department_id,$penunjukan_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	
	public function get_all_karyawans() {
		$sql = 'SELECT * FROM umb_karyawans WHERE user_role_id!=?';
		$binds = array(1);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	public function get_perusahaan_payroll_karyawans($perusahaan_id) {
		
		$sql = 'SELECT * FROM umb_karyawans WHERE user_role_id!=1 and perusahaan_id = ?';
		$binds = array($perusahaan_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	public function get_perusahaan_location_payroll_karyawans($perusahaan_id,$location_id) {
		
		$sql = 'SELECT * FROM umb_karyawans WHERE user_role_id!=1 and perusahaan_id = ? and location_id = ?';
		$binds = array($perusahaan_id,$location_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	public function get_perusahaan_location_dep_payroll_karyawans($perusahaan_id,$location_id,$department_id) {
		
		$sql = 'SELECT * FROM umb_karyawans WHERE user_role_id!=1 and perusahaan_id = ? and location_id = ? and department_id = ?';
		$binds = array($perusahaan_id,$location_id,$department_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	public function get_upahh_perjam()
	{
		return $this->db->get("umb_templates_perjam");
	}

	public function read_template_information($id) {

		$sql = 'SELECT * FROM umb_gaji_templates WHERE gaji_template_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function requested_date_details($id) {
		
		$sql = 'SELECT * FROM `umb_advance_gajii` WHERE karyawan_id = ? and status = ?';
		$binds = array($id,1);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}
	
	public function read_informasi_upah_perjam($id) {

		$sql = 'SELECT * FROM umb_templates_perjam WHERE nilai_perjam_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function read_currency_converter_information($id) {

		$sql = 'SELECT * FROM umb_currency_converter WHERE currency_converter_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function view_laporan_advance_gaji($id) {

		$this->db->query("SET SESSION sql_mode = ''");
		$sql = 'SELECT advance_gaji_id,perusahaan_id,karyawan_id,month_year,pengurangan_satu_kali,angsuran_bulanan,reason,status,total_yang_dibayarkan,is_dipotong_dari_gaji,created_at,SUM(`umb_advance_gajii`.advance_jumlah) AS advance_jumlah FROM `umb_advance_gajii` where status=1 and karyawan_id= ? group by karyawan_id';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		return $query->result();
	}
	
	public function read_informasi_melakukan_pembayaran($id) {

		$sql = 'SELECT * FROM umb_melakukan_pembayaran WHERE melakukan_pembayaran_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function read_informasi_slipgaji($id) {

		$sql = 'SELECT * FROM umb_gaji_slipgajii WHERE slipgaji_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	public function delete_record($id){
		$this->db->where('slipgaji_id', $id);
		$this->db->delete('umb_gaji_slipgajii');
		
	}

	public function delete_slipgaji_tunjanagans_items($id){
		$this->db->where('slipgaji_id', $id);
		$this->db->delete('umb_gaji_slipgaji_tunjanagans');
		
	}

	public function delete_slipgaji_komissi_items($id){
		$this->db->where('slipgaji_id', $id);
		$this->db->delete('umb_gaji_slipgaji_komissi');
		
	}

	public function delete_slipgaji_pinjaman_items($id){
		$this->db->where('slipgaji_id', $id);
		$this->db->delete('umb_gaji_slipgaji_pinjaman');
		
	}

	public function delete_slipgaji_pembayaran_lainnya_items($id){
		$this->db->where('slipgaji_id', $id);
		$this->db->delete('umb_gaji_slipgaji_pembayarans_lainnya');
		
	}

	public function delete_slipgaji_lembur_items($id){
		$this->db->where('slipgaji_id', $id);
		$this->db->delete('umb_gaji_slipgaji_lembur');
		
	}

	public function delete_slipgaji_statutory_potongans_items($id){
		$this->db->where('slipgaji_id', $id);
		$this->db->delete('umb_gaji_slipgaji_statutory_potongans');
		
	}

	public function read_info_advance_gaji($id) {

		$sql = 'SELECT * FROM umb_advance_gajii WHERE advance_gaji_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function get_bayar_gaji_melalui_karyawan_id($id) {

		$this->db->query("SET SESSION sql_mode = ''");
		$sql = 'SELECT advance_gaji_id,karyawan_id,month_year,pengurangan_satu_kali,angsuran_bulanan,reason,status,total_yang_dibayarkan,is_dipotong_dari_gaji,created_at,SUM(`umb_advance_gajii`.advance_jumlah) AS advance_jumlah FROM `umb_advance_gajii` where status=1 and karyawan_id=? group by karyawan_id';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		return $query->result();
	}
	
	public function advance_gaji_melalui_karyawan_id($id) {

		$sql = 'SELECT * FROM umb_advance_gajii WHERE karyawan_id = ? and status = ? order by advance_gaji_id desc';
		$binds = array($id,1);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	
	public function add_template($data){
		$this->db->insert('umb_gaji_templates', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function add_payroll_advance_gaji($data){
		$this->db->insert('umb_advance_gajii', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function add_upahh_perjam($data){
		$this->db->insert('umb_templates_perjam', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function add_currency_converter($data){
		$this->db->insert('umb_currency_converter', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function add_slipgaji_permbayaran_bulanan($data){
		$this->db->insert('umb_melakukan_pembayaran', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function add_slipgaji_permbayaran_perjam($data){
		$this->db->insert('umb_melakukan_pembayaran', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function delete_template_record($id){
		$this->db->where('gaji_template_id', $id);
		$this->db->delete('umb_gaji_templates');
		
	}
	
	public function delete_record_upah_perjam($id){
		$this->db->where('nilai_perjam_id', $id);
		$this->db->delete('umb_templates_perjam');
		
	}
	
	public function delete_record_currency_converter($id){
		$this->db->where('currency_converter_id', $id);
		$this->db->delete('umb_currency_converter');
		
	}
	
	public function delete_record_advance_gaji($id){
		$this->db->where('advance_gaji_id', $id);
		$this->db->delete('umb_advance_gajii');
		
	}
	
	public function update_template_record($data, $id){
		$this->db->where('gaji_template_id', $id);
		if( $this->db->update('umb_gaji_templates',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function all_templates_perjam()
	{
		$query = $this->db->query("SELECT * from umb_templates_perjam");
		return $query->result();
	}
	
	public function all_templates_gaji() {
		$query = $this->db->query("SELECT * from umb_gaji_templates");
		return $query->result();
	}
	
	public function update_record_upahh_perjam($data, $id){
		$this->db->where('nilai_perjam_id', $id);
		if( $this->db->update('umb_templates_perjam',$data)) {
			return true;
		} else {
			return false;
		}		
	}	
	
	public function update_record_currency_converter($data, $id){
		$this->db->where('currency_converter_id', $id);
		if( $this->db->update('umb_currency_converter',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function update_template_gaji($data, $id){
		$this->db->where('user_id', $id);
		if( $this->db->update('umb_karyawans',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function updated_bayar_jumlah_advance_gaji($data, $id){
		$this->db->where('karyawan_id', $id);
		if( $this->db->update('umb_advance_gajii',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function updated_payroll_advance_gaji($data, $id){
		$this->db->where('advance_gaji_id', $id);
		if( $this->db->update('umb_advance_gajii',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function update_empty_gaji_template($data, $id){
		$this->db->where('user_id', $id);
		if( $this->db->update('umb_karyawans',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function update_hourlygrade_gaji_template($data, $id){
		$this->db->where('user_id', $id);
		if( $this->db->update('umb_karyawans',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function update_monthlygrade_gaji_template($data, $id){
		$this->db->where('user_id', $id);
		if( $this->db->update('umb_karyawans',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function update_hourlygrade_zero($data, $id){
		$this->db->where('user_id', $id);
		if( $this->db->update('umb_karyawans',$data)) {
			return true;
		} else {
			return false;
		}		
	}

	public function update_monthlygrade_zero($data, $id){
		$this->db->where('user_id', $id);
		if( $this->db->update('umb_karyawans',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function read_check_melakukan_pembayaran_slipgaji($karyawan_id,$p_date) {

		$sql = 'SELECT * FROM umb_gaji_slipgajii WHERE karyawan_id = ? and gaji_bulan = ?';
		$binds = array($karyawan_id,$p_date);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	public function read_melakukan_pembayaran_slipgaji_half_month_check($karyawan_id,$p_date) {

		$sql = "SELECT * FROM umb_gaji_slipgajii WHERE is_half_monthly_payroll = '1' and karyawan_id = ? and gaji_bulan = ?";
		$binds = array($karyawan_id,$p_date);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	
	public function read_melakukan_pembayaran_slipgaji_half_month_check_last($karyawan_id,$p_date) {

		$sql = "SELECT * FROM umb_gaji_slipgajii WHERE is_half_monthly_payroll = '1' and karyawan_id = ? and gaji_bulan = ? order by slipgaji_id desc";
		$binds = array($karyawan_id,$p_date);
		$query = $this->db->query($sql, $binds);
		return $query->result();
	}
	public function read_melakukan_pembayaran_slipgaji_half_month_check_first($karyawan_id,$p_date) {

		$sql = "SELECT * FROM umb_gaji_slipgajii WHERE is_half_monthly_payroll = '1' and karyawan_id = ? and gaji_bulan = ? order by slipgaji_id asc";
		$binds = array($karyawan_id,$p_date);
		$query = $this->db->query($sql, $binds);
		return $query->result();
	}
	
	public function read_melakukan_pembayaran_slipgaji($karyawan_id,$p_date) {

		$sql = 'SELECT * FROM umb_gaji_slipgajii WHERE karyawan_id = ? and gaji_bulan = ?';
		$binds = array($karyawan_id,$p_date);
		$query = $this->db->query($sql, $binds);
		
		return $query->result();
	}

	public function read_count_melakukan_pembayaran_slipgaji($karyawan_id,$p_date) {

		$sql = 'SELECT * FROM umb_gaji_slipgajii WHERE karyawan_id = ? and gaji_bulan = ?';
		$binds = array($karyawan_id,$p_date);
		$query = $this->db->query($sql, $binds);
		
		return $query->num_rows();
	}

	public function add_gaji_slipgaji($data){
		$this->db->insert('umb_gaji_slipgajii', $data);
		if ($this->db->affected_rows() > 0) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}

	public function add_gaji_slipgaji_tunjanagans($data){
		$this->db->insert('umb_gaji_slipgaji_tunjanagans', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function add_gaji_slipgaji_komissi($data){
		$this->db->insert('umb_gaji_slipgaji_komissi', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function add_gaji_slipgaji_pembayarans_lainnya($data){
		$this->db->insert('umb_gaji_slipgaji_pembayarans_lainnya', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function add_gaji_slipgaji_statutory_potongans($data){
		$this->db->insert('umb_gaji_slipgaji_statutory_potongans', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function add_gaji_slipgaji_pinjaman($data){
		$this->db->insert('umb_gaji_slipgaji_pinjaman', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function add_gaji_slipgaji_lembur($data){
		$this->db->insert('umb_gaji_slipgaji_lembur', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function read_gaji_info_slipgaji($id) {

		$sql = 'SELECT * FROM umb_gaji_slipgajii WHERE slipgaji_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	public function read_gaji_info_slipgaji_key($id) {

		$sql = 'SELECT * FROM umb_gaji_slipgajii WHERE slipgaji_key = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function update_status_payroll($data, $id){
		$this->db->where('slipgaji_key', $id);
		if( $this->db->update('umb_gaji_slipgajii',$data)) {
			return true;
		} else {
			return false;
		}		
	}
}
?>