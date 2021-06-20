<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quotes_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
	public function get_quotes(){
		return $this->db->get("umb_hrastral_quotes");
	}
	
	public function read_info_quote($id) {
		
		$condition = "quote_id =" . "'" . $id . "'";
		$this->db->select('*');
		$this->db->from('umb_hrastral_quotes');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function read_info_converted_quote($id) {
		
		$sql = 'SELECT * FROM umb_hrastral_quotes WHERE quote_id = ? and status = ?';
		$binds = array($id,1);
		$query = $this->db->query($sql, $binds);
		return $query->num_rows();
	}
	
	public function check_po_quote($quote_po) {
		
		$condition = "quote_po =" . "'" . $quote_po . "'";
		$this->db->select('*');
		$this->db->from('umb_hrastral_quotes');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		
		return $query->num_rows();
	}

	public function quote_no_check($quote_number) {
		
		$condition = "quote_number =" . "'" . $quote_number . "'";
		$this->db->select('*');
		$this->db->from('umb_hrastral_quotes');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		
		return $query->num_rows();
	}
	
	public function read_info_invoice_items($id) {
		
		$condition = "quote_item_id =" . "'" . $id . "'";
		$this->db->select('*');
		$this->db->from('umb_hrastral_quotes_items');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function get_quote_items($id) {
		
		$sql = 'SELECT * FROM umb_hrastral_quotes_items WHERE quote_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds); 
		
		return $query->result();
	}	
	
	public function add_quote_record($data){
		$this->db->insert('umb_hrastral_quotes', $data);
		if ($this->db->affected_rows() > 0) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}
	
	public function add_record_quote_items($data){
		$this->db->insert('umb_hrastral_quotes_items', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function delete_record($id){
		$this->db->where('quote_id', $id);
		$this->db->delete('umb_hrastral_quotes');
		
	}

	public function delete_quote_items($id){
		$this->db->where('quote_id', $id);
		$this->db->delete('umb_hrastral_quotes_items');
		
	}

	public function delete_qinvoice_record($id){
		$this->db->where('quote_id', $id);
		$this->db->delete('umb_hrastral_invoices');
		
	}
	
	public function delete_quotes_items($id){
		$this->db->where('quote_item_id', $id);
		$this->db->delete('umb_hrastral_quotes_items');
		
	}
	
	public function delete_record_quote_items($id){
		$this->db->where('quote_item_id', $id);
		$this->db->delete('umb_hrastral_quotes_items');
		
	}	
	
	public function update_record_quote($data, $id){
		$this->db->where('quote_id', $id);
		if( $this->db->update('umb_hrastral_quotes',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function update_record_quote_items($data, $id){
		$this->db->where('quote_item_id', $id);
		if( $this->db->update('umb_hrastral_quotes_items',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
}
?>