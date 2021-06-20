<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Awards_model extends CI_Model {

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function get_awards(){
		return $this->db->get("umb_awards");
	}

	public function read_informasi_type_award($id) {

		$sql = 'SELECT * FROM umb_type_award WHERE type_award_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return null;
		}
	}

	public function get_awards_perusahaan($perusahaan_id) {

		$sql = 'SELECT * FROM umb_awards WHERE perusahaan_id = ?';
		$binds = array($perusahaan_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	
	public function all_types_award() {
		$query = $this->db->query("SELECT * from umb_type_award");
		return $query->result();
	}
	
	public function get_awards_karyawan($id) {
		
		$sql = 'SELECT * FROM umb_awards WHERE karyawan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	
	public function read_informasi_award($id) {

		$sql = 'SELECT * FROM umb_awards WHERE award_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function add($data){
		$this->db->insert('umb_awards', $data);
		if ($this->db->affected_rows() > 0) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}
	
	public function delete_record($id){
		$this->db->where('award_id', $id);
		$this->db->delete('umb_awards');
		
	}
	
	public function update_record($data, $id){
		$this->db->where('award_id', $id);
		if( $this->db->update('umb_awards',$data)) {
			return true;
		} else {
			return false;
		}		
	}
}
?>