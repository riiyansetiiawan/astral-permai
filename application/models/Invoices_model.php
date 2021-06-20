<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoices_model extends CI_Model {

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function get_invoices(){
		return $this->db->get("umb_hrastral_invoices");
	}
	
	public function get_pajaks() {
		return $this->db->get("umb_types_pajak");
	}

	public function get_invoices_project_karyawan($id) {
		
		$sql = 'SELECT * FROM umb_hrastral_invoices WHERE project_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	public function get_completed_invoices() {
		
		$sql = 'SELECT * FROM umb_hrastral_invoices WHERE status = ?';
		$binds = array(1);
		$query = $this->db->query($sql, $binds);
		return $query->result();
	}

	public function get_pending_invoices() {
		
		$sql = 'SELECT * FROM umb_hrastral_invoices WHERE status = ?';
		$binds = array(0);
		$query = $this->db->query($sql, $binds);
		return $query->result();
	}

	public function read_info_invoice($id) {

		$condition = "invoice_id =" . "'" . $id . "'";
		$this->db->select('*');
		$this->db->from('umb_hrastral_invoices');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function read_info_invoice_items($id) {

		$condition = "invoice_item_id =" . "'" . $id . "'";
		$this->db->select('*');
		$this->db->from('umb_hrastral_invoices_items');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function read_informasi_pajak($id) {

		$condition = "pajak_id =" . "'" . $id . "'";
		$this->db->select('*');
		$this->db->from('umb_types_pajak');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function get_invoice_items($id) {

		$sql = 'SELECT * FROM umb_hrastral_invoices_items WHERE invoice_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds); 
		
		return $query->result();
	}	
	public function get_invoices_client($id) {

		$sql = 'SELECT * FROM umb_hrastral_invoices WHERE client_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds); 
		return $query;
	}
	public function get_client_pembayaran_invoices($id) {

		$sql = 'SELECT * FROM umb_keuangan_transaksi WHERE client_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds); 
		return $query;
	}

	public function get_client_all_pembayarans_invoice() {

		$sql = 'SELECT * FROM umb_keuangan_transaksi WHERE invoice_id != ""';
		$query = $this->db->query($sql); 
		return $query;
	}

	public function lima_invoices_clent_terakhir($id) {
		$sql = 'SELECT * FROM umb_hrastral_invoices where client_id = ? order by invoice_id desc limit ?';
		$binds = array($id,5);
		$query = $this->db->query($sql, $binds); 

		return $query->result();
	}
	
	public function add_record_invoice($data){
		$this->db->insert('umb_hrastral_invoices', $data);
		if ($this->db->affected_rows() > 0) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}
	
	public function add_record_invoice_items($data){
		$this->db->insert('umb_hrastral_invoices_items', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function add_record_pajak($data){
		$this->db->insert('umb_types_pajak', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function update_record_pajak($data, $id){
		$this->db->where('pajak_id', $id);
		if( $this->db->update('umb_types_pajak',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function delete_record($id){
		$this->db->where('invoice_id', $id);
		$this->db->delete('umb_hrastral_invoices');
		
	}
	
	public function delete_invoice_items($id){
		$this->db->where('invoice_id', $id);
		$this->db->delete('umb_hrastral_invoices_items');
		
	}
	
	public function delete_record_invoice_items($id){
		$this->db->where('invoice_item_id', $id);
		$this->db->delete('umb_hrastral_invoices_items');
		
	}
	
	public function delete_record_pajak($id){
		$this->db->where('pajak_id', $id);
		$this->db->delete('umb_types_pajak');
		
	}
	
	public function update_record_invoice($data, $id){
		$this->db->where('invoice_id', $id);
		if( $this->db->update('umb_hrastral_invoices',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function update_record_invoice_items($data, $id){
		$this->db->where('invoice_item_id', $id);
		if( $this->db->update('umb_hrastral_invoices_items',$data)) {
			return true;
		} else {
			return false;
		}		
	}
}
?>