<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengumuman_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
	public function get_pengumumans() {
		return $this->db->get("umb_pengumumans");
	}
	
	public function get_pengumuman_barus() {
		$query = $this->db->query("SELECT * from umb_pengumumans");
		return $query->result();
	}

	public function get_pengumumans_perusahaan($perusahaan_id) {
		
		$sql = 'SELECT * FROM umb_pengumumans WHERE perusahaan_id = ?';
		$binds = array($perusahaan_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	public function get_pengumumans_department($department_id) {
		
		$sql = 'SELECT * FROM umb_pengumumans WHERE department_id = ?';
		$binds = array($department_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	public function read_informasi_pengumuman($id) {
		
		$sql = 'SELECT * FROM umb_pengumumans WHERE pengumuman_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function add($data){
		$this->db->insert('umb_pengumumans', $data);
		if ($this->db->affected_rows() > 0) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}
	
	public function delete_record($id){
		$this->db->where('pengumuman_id', $id);
		$this->db->delete('umb_pengumumans');
		
	}
	
	public function update_record($data, $id){
		$this->db->where('pengumuman_id', $id);
		if( $this->db->update('umb_pengumumans',$data)) {
			return true;
		} else {
			return false;
		}		
	}
}
?>