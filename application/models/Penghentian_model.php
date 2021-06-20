<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penghentian_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function get_penghentians() {

		return $this->db->get("umb_penghentians_karyawan");
	}

	public function read_informasi_penghentian($id) {

		$sql = 'SELECT * FROM umb_penghentians_karyawan WHERE penghentian_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	public function get_penghentians_perusahaan($perusahaan_id) {

		$sql = 'SELECT * FROM umb_penghentians_karyawan WHERE perusahaan_id = ?';
		$binds = array($perusahaan_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	public function get_penghentian_karyawan($id) {
		
		$sql = 'SELECT * FROM umb_penghentians_karyawan WHERE karyawan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	
	public function read_infomasi_type_penghentian($id) {

		$sql = 'SELECT * FROM umb_type_penghentian WHERE type_penghentian_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function all_types_penghentian() {

		$query = $this->db->query("SELECT * from umb_type_penghentian");
		return $query->result();
	}
	
	public function add($data){
		$this->db->insert('umb_penghentians_karyawan', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function delete_record($id){

		$this->db->where('penghentian_id', $id);
		$this->db->delete('umb_penghentians_karyawan');
	}
	
	public function update_record($data, $id){
		
		$this->db->where('penghentian_id', $id);
		if( $this->db->update('umb_penghentians_karyawan',$data)) {
			return true;
		} else {
			return false;
		}		
	}
}
?>