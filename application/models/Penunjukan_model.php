<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Penunjukan_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function get_penunjukans() {

		return $this->db->get("umb_penunjukans");
	}

	public function read_informasi_penunjukan($id) {

		$sql = 'SELECT * FROM umb_penunjukans WHERE penunjukan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function add($data){
		$this->db->insert('umb_penunjukans', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function delete_record($id) {

		$this->db->where('penunjukan_id', $id);
		$this->db->delete('umb_penunjukans');
	}

	public function update_record($data, $id) {

		$this->db->where('penunjukan_id', $id);
		if( $this->db->update('umb_penunjukans',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function all_penunjukans() {

		$query = $this->db->query("SELECT * from umb_penunjukans");
		return $query->result();
	}
	
	public function ajax_informasi_penunjukan($id) {

		$sql = 'SELECT * FROM umb_penunjukans WHERE sub_department_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function ajax_is_informasi_penunjukan($id) {

		$sql = 'SELECT * FROM umb_penunjukans WHERE department_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function ajax_perusahaan_info_penunjukan($id) {

		$sql = 'SELECT * FROM umb_penunjukans WHERE perusahaan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function get_penunjukans_perusahaan($perusahaan_id) {

		$sql = 'SELECT * FROM umb_penunjukans WHERE perusahaan_id = ?';
		$binds = array($perusahaan_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
}
?>