<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Events_model extends CI_Model {
	
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	public function get_events(){
		return $this->db->get("umb_events");
	}
	
	public function read_informasi_event($id) {
		
		$sql = 'SELECT * FROM umb_events WHERE event_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	public function get_events_perusahaan($perusahaan_id) {
		
		$sql = 'SELECT * FROM umb_events WHERE perusahaan_id = ?';
		$binds = array($perusahaan_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	public function get_events_karyawan($id) {
		
		$sql = "SELECT * FROM umb_events WHERE karyawan_id like '%$id,%' or karyawan_id like '%,$id%' or karyawan_id = '$id'";
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	public function add($data){
		$this->db->insert('umb_events', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function delete_record_event($id){
		$this->db->where('event_id', $id);
		$this->db->delete('umb_events');
	}
	
	public function update_record($data, $id){
		$this->db->where('event_id', $id);
		if( $this->db->update('umb_events',$data)) {
			return true;
		} else {
			return false;
		}		
	}
}
?>