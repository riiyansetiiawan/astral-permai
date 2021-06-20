<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Karyawan_exit_model extends CI_Model {

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function get_exit(){
		return $this->db->get("umb_karyawan_exit");
	}

	public function read_informasi_exit($id) {

		$sql = 'SELECT * FROM umb_karyawan_exit WHERE exit_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function filter_perusahaan_exit($perusahaan_id) {

		$sql = 'SELECT * FROM umb_karyawan_exit WHERE perusahaan_id = ?';
		$binds = array($perusahaan_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	public function filter_perusahaan_karyawan_exit($perusahaan_id,$karyawan_id) {

		$sql = 'SELECT * FROM umb_karyawan_exit WHERE perusahaan_id = ? and karyawan_id = ?';
		$binds = array($perusahaan_id,$karyawan_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	public function filter_perusahaan_status_karyawan_exit($perusahaan_id,$karyawan_id,$exit_interview) {

		$sql = 'SELECT * FROM umb_karyawan_exit WHERE perusahaan_id = ? and karyawan_id = ? and exit_interview = ?';
		$binds = array($perusahaan_id,$karyawan_id,$exit_interview);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	public function filter_perusahaan_status_karyawan_tidak_exit($perusahaan_id,$exit_interview) {

		$sql = 'SELECT * FROM umb_karyawan_exit WHERE perusahaan_id = ? and exit_interview = ?';
		$binds = array($perusahaan_id,$exit_interview);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	
	public function read_informasi_type_exit($id) {

		$sql = 'SELECT * FROM umb_karyawan_type_exit WHERE type_exit_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function all_types_exit() {
		$query = $this->db->query("SELECT * from umb_karyawan_type_exit");
		return $query->result();
	}
	
	public function add($data){
		$this->db->insert('umb_karyawan_exit', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function delete_record($id){
		$this->db->where('exit_id', $id);
		$this->db->delete('umb_karyawan_exit');
		
	}
	
	public function update_record($data, $id){
		$this->db->where('exit_id', $id);
		if( $this->db->update('umb_karyawan_exit',$data)) {
			return true;
		} else {
			return false;
		}		
	}
}
?>