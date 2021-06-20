<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Department_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function get_departments() {
		return $this->db->get("umb_departments");
	}

	public function get_sub_departments() {
		return $this->db->get("umb_sub_departments");
	}

	public function read_informasi_department($id) {

		$sql = 'SELECT * FROM umb_departments WHERE department_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	public function get_department_subdepartments($perusahaan_id) {

		$sql = 'SELECT * FROM umb_sub_departments WHERE department_id = ?';
		$binds = array($perusahaan_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	public function get_perusahaan_departments($perusahaan_id) {

		$sql = 'SELECT * FROM umb_departments WHERE perusahaan_id = ?';
		$binds = array($perusahaan_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	public function read_info_sub_department($id) {

		$sql = 'SELECT * FROM umb_sub_departments WHERE sub_department_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function ajax_informasi_location($id) {

		$sql = 'SELECT * FROM umb_location_kantor WHERE perusahaan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function info_location_perusahaan($id) {

		$sql = 'SELECT * FROM umb_location_kantor WHERE perusahaan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function ajax_informasi_location_departments($id) {

		$sql = 'SELECT * FROM umb_departments WHERE location_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function ajax_info_perusahaan_karyawan($id) {

		//$sql = "SELECT * FROM umb_karyawans WHERE perusahaan_id = ? and user_role_id!='1' and is_logged_in='1'";
		$sql = "SELECT * FROM umb_karyawans WHERE perusahaan_id = ? and user_role_id!='1'";
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function add($data){
		$this->db->insert('umb_departments', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function add_sub($data){
		$this->db->insert('umb_sub_departments', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	

	public function delete_record($id){
		$this->db->where('department_id', $id);
		$this->db->delete('umb_departments');
		
	}

	public function delete_record_sub($id){
		$this->db->where('sub_department_id', $id);
		$this->db->delete('umb_sub_departments');
		
	}
	
	public function update_record($data, $id){
		$this->db->where('department_id', $id);
		$data = $this->security->xss_clean($data);
		if( $this->db->update('umb_departments',$data)) {
			return true;
		} else {
			return false;
		}		
	}

	public function update_record_sub($data, $id){
		
		$this->db->where('sub_department_id', $id);
		$data = $this->security->xss_clean($data);
		if( $this->db->update('umb_sub_departments',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function all_departments() {

		$query = $this->db->query("SELECT * from umb_departments");
		return $query->result();
	}
	
	public function is_head_department($id) {

		$condition = "karyawan_id =" . "'" . $id . "'";
		$this->db->select('*');
		$this->db->from('umb_departments');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
}
?>