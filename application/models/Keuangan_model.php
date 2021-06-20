<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Keuangan_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
	public function get_bankcash() {

		return $this->db->get("umb_keuangan_bankcash");
	}
	
	public function get_deposit() {

		return $this->db->query("SELECT * from umb_keuangan_transaksi where type_transaksi = 'pendapatan'");
	}
	
	public function get_biaya() {

		return $this->db->query("SELECT * from umb_keuangan_transaksi where type_transaksi = 'biaya'");
	}
	
	public function get_invoice_pembayarans() {

		return $this->db->query("SELECT * from umb_keuangan_transaksi where invoice_id != ''");
	}
	
	public function get_transfer() {
		return $this->db->get("umb_keuangan_transfer");
	}
	
	public function get_transaksi() {
		
		return $this->db->query("SELECT * from umb_keuangan_transaksi order by transaksi_id desc");
	}
	

	public function get_transaksii_bijaksanabank($id) {
		$sql = "SELECT tanggal_transaksi,dr_cr,jumlah,account_id,type_transaksi,description,IF(dr_cr='dr',jumlah,NULL) as debit,IF(dr_cr='cr',jumlah,NULL) as credit FROM umb_keuangan_transaksi WHERE account_id='$id'";
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	
	public function read_informasi_bankcash($id) {
		
		$sql = 'SELECT * FROM umb_keuangan_bankcash WHERE bankcash_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function read_informasi_transaksi($id) {
		
		$sql = 'SELECT * FROM umb_keuangan_transaksi WHERE transaksi_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	public function ajax_info_types_biaya_perusahaan($id) {
		
		$sql = 'SELECT * FROM umb_type_biaya WHERE perusahaan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function read_transaksi_invoice($id) {
		
		$sql = 'SELECT * FROM umb_keuangan_transaksi WHERE type_invoice = ? and invoice_id = ?';
		$binds = array('customer',$id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	public function read_direct_invoice_transaction($id) {
		
		$sql = 'SELECT * FROM umb_keuangan_transaksi WHERE type_invoice = ? and invoice_id = ?';
		$binds = array('direct',$id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	
	public function read_info_transaksi_melalui_bank($id) {
		
		$sql = 'SELECT * FROM umb_keuangan_transaksi WHERE account_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function delete_record_pembayar($id){
		$this->db->where('pembayar_id', $id);
		$this->db->delete('umb_keuangan_pembayars');
		
	}
	
	public function delete_record_penerima_pembayaran($id){
		$this->db->where('penerima_pembayaran_id', $id);
		$this->db->delete('umb_keuangan_penerima_pembayarans');
		
	}
	
	public function read_informasi_biaya($id) {
		
		$sql = 'SELECT * FROM umb_keuangan_biaya WHERE biaya_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function read_informasi_transfer($id) {
		
		$sql = 'SELECT * FROM umb_keuangan_transfer WHERE transfer_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function get_pembayars()
	{
		return $this->db->get("umb_keuangan_pembayars");
	}
	
	public function get_penerima_pembayarans()
	{
		return $this->db->get("umb_keuangan_penerima_pembayarans");
	}
	
	public function add_record_pembayar($data){
		$this->db->insert('umb_keuangan_pembayars', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function add_record_penerima_pembayaran($data){
		$this->db->insert('umb_keuangan_penerima_pembayarans', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function update_record_pembayar($data, $id){
		$this->db->where('pembayar_id', $id);
		if( $this->db->update('umb_keuangan_pembayars',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function read_info_pembayar($id) {
		
		$sql = 'SELECT * FROM umb_keuangan_pembayars WHERE pembayar_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function update_record_penerima_pembayaran($data, $id){
		$this->db->where('penerima_pembayaran_id', $id);
		if( $this->db->update('umb_keuangan_penerima_pembayarans',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function read_info_penerima_pembayaran($id) {
		
		$sql = 'SELECT * FROM umb_keuangan_penerima_pembayarans WHERE penerima_pembayaran_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function add_bankcash($data){
		$this->db->insert('umb_keuangan_bankcash', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function add_deposit($data){
		$this->db->insert('umb_keuangan_deposit', $data);
		if ($this->db->affected_rows() > 0) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}
	
	public function add_biaya($data){
		$this->db->insert('umb_keuangan_biaya', $data);
		if ($this->db->affected_rows() > 0) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}
	
	public function add_transfer($data){
		$this->db->insert('umb_keuangan_transfer', $data);
		if ($this->db->affected_rows() > 0) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}
	
	public function all_list_kategoris_pendapatan() {

		$query = $this->db->query("SELECT * from umb_kategoris_pendapatan");
		return $query->result();
	}
	
	public function get_all_payment_method() {
		$query = $this->db->query("SELECT * from umb_payment_method");
		return $query->result();
	}
	
	public function read_kategori_pendapatan($id) {
		
		$sql = 'SELECT * FROM umb_kategoris_pendapatan WHERE kategori_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function add_transaksii($data){
		$this->db->insert('umb_keuangan_transaksi', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function delete_record_bankcash($id){
		$this->db->where('bankcash_id', $id);
		$this->db->delete('umb_keuangan_bankcash');
		
	}
	
	public function delete_record_transaksi($id){
		$this->db->where('transaksi_id', $id);
		$this->db->delete('umb_keuangan_transaksi');
		
	}
	
	public function delete_record_biaya($id){
		$this->db->where('biaya_id', $id);
		$this->db->delete('umb_keuangan_biaya');
		
	}
	
	public function delete_record_transfer($id){
		$this->db->where('transfer_id', $id);
		$this->db->delete('umb_keuangan_transfer');
		
	}
	
	public function delete_record_transaksi_deposit($id){
		$this->db->where('deposit_id', $id);
		$this->db->delete('umb_keuangan_transaksii');
		
	}
	
	public function delete_record_transaksi_biaya($id){
		$this->db->where('biaya_id', $id);
		$this->db->delete('umb_keuangan_transaksii');
		
	}
	
	public function delete_record_transaksi_transfer($id){
		$this->db->where('transfer_id', $id);
		$this->db->delete('umb_keuangan_transaksii');
		
	}
	
	public function update_record_bankcash($data, $id){
		$this->db->where('bankcash_id', $id);
		if( $this->db->update('umb_keuangan_bankcash',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function all_penerima_pembayarans()
	{
		$query = $this->db->query("SELECT * from umb_keuangan_penerima_pembayarans");
		return $query->result();
	}
	
	public function update_record_transaksi($data, $id){
		$this->db->where('transaksi_id', $id);
		if( $this->db->update('umb_keuangan_transaksi',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function update_record_biaya($data, $id){
		$this->db->where('biaya_id', $id);
		if( $this->db->update('umb_keuangan_biaya',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function update_record_transfer($data, $id){
		$this->db->where('transfer_id', $id);
		if( $this->db->update('umb_keuangan_transfer',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function all_bank_cash() {
		$query = $this->db->query("SELECT * from umb_keuangan_bankcash");
		return $query->result();
	}

	public function all_pembayars()
	{
		$query = $this->db->query("SELECT * from umb_keuangan_pembayars");
		return $query->result();
	}
	
	public function search_account_statement($start_date,$end_date,$account_id){
		//		
		if($account_id!=0) {
			$sql = "SELECT tanggal_transaksi,dr_cr,jumlah,account_id,type_transaksi,description,IF(dr_cr='dr',jumlah,NULL) as debit,IF(dr_cr='cr',jumlah,NULL) as credit FROM umb_keuangan_transaksi WHERE account_id=? AND DATE(tanggal_transaksi) BETWEEN ? AND ? order by transaksi_id asc";
			
			$binds = array($account_id,$start_date,$end_date);
			$query = $this->db->query($sql, $binds);
			return $query;		
		} else {
			$sql = "SELECT tanggal_transaksi,dr_cr,jumlah,account_id,type_transaksi,description,IF(dr_cr='dr',jumlah,NULL) as debit,IF(dr_cr='cr',jumlah,NULL) as credit FROM umb_keuangan_transaksi WHERE account_id=? AND DATE(tanggal_transaksi) BETWEEN ? AND ? order by transaksi_id asc";
			$binds = array('AA',$start_date,$end_date);
			$query = $this->db->query($sql, $binds);
			return $query;
		}
	}
	
	public function get_search_biaya($start_date,$end_date,$type_id,$perusahaan_id){
		if($type_id=='none') {
			
			$sql = 'SELECT * FROM `umb_keuangan_transaksi` where type_transaksi = "ebiaya" and DATE(tanggal_transaksi) BETWEEN ? AND ?';
			$binds = array($start_date,$end_date);
			$query = $this->db->query($sql, $binds);
			return $query;
			
		} else if($type_id==0 && $perusahaan_id ==0) {
			
			$sql = 'SELECT * FROM `umb_keuangan_transaksi` where type_transaksi = "biaya" and DATE(tanggal_transaksi) BETWEEN ? AND ?';
			$binds = array($start_date,$end_date);
			$query = $this->db->query($sql, $binds);
			return $query;
			
		} else if($perusahaan_id!=0 && $type_id==0) {
			
			$sql = 'SELECT * FROM `umb_keuangan_transaksi` where type_transaksi = "biaya" and perusahaan_id = ? and DATE(tanggal_transaksi) BETWEEN ? AND ?';
			$binds = array($perusahaan_id,$start_date,$end_date);
			$query = $this->db->query($sql, $binds);
			return $query;
		} else if($perusahaan_id!=0 && $type_id!=0) {
			
			$sql = 'SELECT * FROM `umb_keuangan_transaksi` where type_transaksi = "biaya" and perusahaan_id = ? and kat_transaksi_id = ? and DATE(tanggal_transaksi) BETWEEN ? AND ?';
			$binds = array($perusahaan_id,$type_id,$start_date,$end_date);
			$query = $this->db->query($sql, $binds);
			return $query;
		}
	}
	
	public function get_search_deposit($start_date,$end_date,$type_id){
		if($type_id=='none') {
			
			$sql = 'SELECT * FROM `umb_keuangan_transaksi` where type_transaksi = "iipendapatan" and DATE(tanggal_transaksi) BETWEEN ? AND ?';
			$binds = array($start_date,$end_date);
			$query = $this->db->query($sql, $binds);
			return $query;
			
		} else if($type_id=='all_types') {
			
			$sql = 'SELECT * FROM `umb_keuangan_transaksi` where type_transaksi = "pendapatan" and DATE(tanggal_transaksi) BETWEEN ? AND ?';
			$binds = array($start_date,$end_date);
			$query = $this->db->query($sql, $binds);
			return $query;
			
		} else if($type_id!=0 || $type_id!='all_types') {
			
			$sql = 'SELECT * FROM `umb_keuangan_transaksi` where type_transaksi = "pendapatan" and kat_transaksi_id = ? and DATE(tanggal_transaksi) BETWEEN ? AND ?';
			$binds = array($type_id, $start_date,$end_date);
			$query = $this->db->query($sql, $binds);
			return $query;
		}
	}
	
	public function get_search_transfer($start_date,$end_date){
		
		$sql = "SELECT tanggal_transaksi,dr_cr,jumlah,account_id,payment_method_id,reference,type_transaksi,description,IF(dr_cr='dr',jumlah,NULL) as debit,IF(dr_cr='cr',jumlah,NULL) as credit FROM umb_keuangan_transaksi where type_transaksi = 'transfer' and DATE(tanggal_transaksi) BETWEEN ? AND ?";
		$binds = array($start_date,$end_date);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	
	public function get_sales_report($start_date,$end_date){
		$sql = "SELECT tanggal_transaksi,dr_cr,invoice_id,jumlah,account_id,payment_method_id,pembayar_penerima_pembayaran_id,reference,type_transaksi,description,IF(dr_cr='dr',jumlah,NULL) as debit,IF(dr_cr='cr',jumlah,NULL) as credit FROM umb_keuangan_transaksi where type_transaksi = 'pendapatan' and invoice_id>0 and DATE(tanggal_transaksi) BETWEEN ? AND ?";
		$binds = array($start_date,$end_date);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	
	public function get_ledger_accounts($start_date,$end_date) {
		$sql = "SELECT tanggal_transaksi,dr_cr,jumlah,account_id,type_transaksi,description,IF(dr_cr='dr',jumlah,NULL) as debit,IF(dr_cr='cr',jumlah,NULL) as credit FROM umb_keuangan_transaksi where DATE(tanggal_transaksi) BETWEEN ? AND ?";
		$binds = array($start_date,$end_date);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	
	public function get_search_pendapatan_biaya($start_date,$end_date){
		
		$sql = 'SELECT * FROM `umb_keuangan_transaksi` where DATE(tanggal_transaksi) BETWEEN ? AND ?';
		$binds = array($start_date,$end_date);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
}
?>