<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Peringatan_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function get_peringatan() {
		return $this->db->get("umb_peringatans_karyawan");
	}
	
	public function get_peringatan_karyawan($id) {

		$sql = 'SELECT * FROM umb_peringatans_karyawan WHERE peringatan_ke = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	public function get_peringatan_perusahaan($perusahaan_id) {

		$sql = 'SELECT * FROM umb_peringatans_karyawan WHERE perusahaan_id = ?';
		$binds = array($perusahaan_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	public function read_informasi_peringatan($id) {

		$sql = 'SELECT * FROM umb_peringatans_karyawan WHERE peringatan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function read_informasi_type_peringatan($id) {

		$sql = 'SELECT * FROM umb_type_peringatan WHERE type_peringatan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function all_types_peringatan() {
		$query = $this->db->query("SELECT * from umb_type_peringatan");
		return $query->result();
	}
	
	public function add($data){
		$this->db->insert('umb_peringatans_karyawan', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function delete_record($id){
		$this->db->where('peringatan_id', $id);
		$this->db->delete('umb_peringatans_karyawan');
		
	}
	
	public function update_record($data, $id){
		$this->db->where('peringatan_id', $id);
		if( $this->db->update('umb_peringatans_karyawan',$data)) {
			return true;
		} else {
			return false;
		}		
	}
}
?>