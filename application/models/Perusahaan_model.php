<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perusahaan_model extends CI_Model{

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function get_perusahaans() {
		return $this->db->get("umb_perusahaans");
	}
	
	public function get_documents_perusahaan() {
		return $this->db->get("umb_documents_perusahaan");
	}
	
	public function get_types_perusahaan() {
		$query = $this->db->get("umb_type_perusahaan");
		return $query->result();
	}

	public function get_single_perusahaan($perusahaan_id) {

		$sql = 'SELECT * FROM umb_perusahaans WHERE perusahaan_id = ?';
		$binds = array($perusahaan_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	public function get_single_documents_perusahaan($perusahaan_id) {

		$sql = 'SELECT * FROM umb_documents_perusahaan WHERE perusahaan_id = ?';
		$binds = array($perusahaan_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	
	public function get_all_perusahaans() {
		$query = $this->db->get("umb_perusahaans");
		return $query->result();
	}

	public function read_informasi_perusahaan($id) {

		$sql = 'SELECT * FROM umb_perusahaans WHERE perusahaan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	public function read_type_perusahaan($id) {

		$sql = 'SELECT * FROM umb_type_perusahaan WHERE type_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function read_info_document_perusahaan($id) {

		$sql = 'SELECT * FROM umb_documents_perusahaan WHERE document_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function add($data){
		$this->db->insert('umb_perusahaans', $data);
		if ($this->db->affected_rows() > 0) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}
	
	public function add_document($data){
		$this->db->insert('umb_documents_perusahaan', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function delete_record($id){
		$this->db->where('perusahaan_id', $id);
		$this->db->delete('umb_perusahaans');
		
	}
	
	public function delete_record_doc($id){
		$this->db->where('document_id', $id);
		$this->db->delete('umb_documents_perusahaan');
		
	}
	
	public function update_record($data, $id){
		$this->db->where('perusahaan_id', $id);
		if( $this->db->update('umb_perusahaans',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function update_record_no_logo($data, $id){
		$this->db->where('perusahaan_id', $id);
		if( $this->db->update('umb_perusahaans',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function update_record_document_perusahaan($data, $id){
		$this->db->where('document_id', $id);
		if( $this->db->update('umb_documents_perusahaan',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function ajax_perusahaan_info_departments($id) {

		$condition = "perusahaan_id =" . "'" . $id . "'";
		$this->db->select('*');
		$this->db->from('umb_departments');
		$this->db->where($condition);
		$this->db->limit(100);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
}
?>