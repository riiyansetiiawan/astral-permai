<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tujuan_tracking_model extends CI_Model {

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function get_type_tujuan_tracking() {
		return $this->db->get("umb_type_tujuan_tracking");
	}
	
	public function get_tujuan_tracking() {
		return $this->db->get("umb_tujuan_tracking");
	}

	public function get_perusahaan_tujuan_tracking($id) {
		
		$sql = 'SELECT * FROM umb_tujuan_tracking WHERE perusahaan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}	

	public function all_types_tracking() {
		$query = $this->db->query("SELECT * from umb_type_tujuan_tracking");
		return $query->result();
	}
	
	public function all_tujuans_completed() {
		return $this->db->query("SELECT * from umb_tujuan_tracking where tujuan_status=2");
	}
	
	public function all_tujuans_inprogress() {
		return $this->db->query("SELECT * from umb_tujuan_tracking where tujuan_status=1");
	}
	
	public function all_tujuans_not_started() {
		return $this->db->query("SELECT * from umb_tujuan_tracking where tujuan_status=0");
	}

	public function read_informasi_tujuan($id) {

		$sql = 'SELECT * FROM umb_tujuan_tracking WHERE tracking_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function read_informasi_type_tracking($id) {

		$sql = 'SELECT * FROM umb_type_tujuan_tracking WHERE type_tracking_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function add_tujuan($data){
		$this->db->insert('umb_tujuan_tracking', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function add_type($data){
		$this->db->insert('umb_type_tujuan_tracking', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function delete_record_tracking($id){
		$this->db->where('tracking_id', $id);
		$this->db->delete('umb_tujuan_tracking');
		
	}
	
	public function delete_record_type($id){
		$this->db->where('type_tracking_id', $id);
		$this->db->delete('umb_type_tujuan_tracking');
		
	}
	
	public function update_record_tujuan($data, $id){
		$this->db->where('tracking_id', $id);
		if( $this->db->update('umb_tujuan_tracking',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function update_record_type($data, $id){
		$this->db->where('type_tracking_id', $id);
		if( $this->db->update('umb_type_tujuan_tracking',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
}
?>