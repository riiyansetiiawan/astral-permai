<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Meetings_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
	public function get_meetings() {
		return $this->db->get("umb_meetings");
	}
	
	public function read_informasi_meeting($id) {
		
		$sql = 'SELECT * FROM umb_meetings WHERE meeting_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	public function get_meetings_perusahaan($perusahaan_id) {
		
		$sql = 'SELECT * FROM umb_meetings WHERE perusahaan_id = ?';
		$binds = array($perusahaan_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	public function get_meetings_karyawan($id) {
		
		$sql = "SELECT * FROM umb_meetings WHERE karyawan_id like '%$id,%' or karyawan_id like '%,$id%' or karyawan_id = '$id'";
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	
	public function add($data){
		$this->db->insert('umb_meetings', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function delete_record_meeting($id){
		$this->db->where('meeting_id', $id);
		$this->db->delete('umb_meetings');
		
	}
	
	public function update_record($data, $id){
		$this->db->where('meeting_id', $id);
		if( $this->db->update('umb_meetings',$data)) {
			return true;
		} else {
			return false;
		}		
	}
}
?>