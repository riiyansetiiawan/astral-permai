<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Location_model extends CI_Model {
	
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	public function get_locations(){
		return $this->db->get("umb_location_kantor");
	}
	
	public function read_informasi_location($id) {
		
		$sql = 'SELECT * FROM umb_location_kantor WHERE location_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	public function get_perusahaan_location_kantor($perusahaan_id) {
		
		$sql = 'SELECT * FROM umb_location_kantor WHERE perusahaan_id = ?';
		$binds = array($perusahaan_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	
	public function add($data){
		$this->db->insert('umb_location_kantor', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function delete_record($id){
		$this->db->where('location_id', $id);
		$this->db->delete('umb_location_kantor');
		
	}
	
	public function update_record($data, $id){
		$this->db->where('location_id', $id);
		if( $this->db->update('umb_location_kantor',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function update_record_no_logo($data, $id){
		$this->db->where('location_id', $id);
		if( $this->db->update('umb_location_kantor',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function all_locations_kantor() {
		$query = $this->db->query("SELECT * from umb_location_kantor");
		return $query->result();
	}
}
?>