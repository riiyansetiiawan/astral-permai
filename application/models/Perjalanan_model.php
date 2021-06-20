<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perjalanan_model extends CI_Model {

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function get_perjalanan() {
		return $this->db->get("umb_perjalanans_karyawan");
	}
	
	public function get_karyawan_perjalanan($id) {

		$sql = 'SELECT * FROM umb_perjalanans_karyawan WHERE karyawan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	public function get_perusahaan_perjalanan($perusahaan_id) {

		$sql = 'SELECT * FROM umb_perjalanans_karyawan WHERE perusahaan_id = ?';
		$binds = array($perusahaan_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	
	public function read_informasi_perjalanan($id) {

		$sql = 'SELECT * FROM umb_perjalanans_karyawan WHERE perjalanan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function types_pengaturan_perjalanan(){
		$query = $this->db->query("SELECT * from umb_type_pengaturan_perjalanan");
		return $query->result();
	}
	
	public function add($data){
		$this->db->insert('umb_perjalanans_karyawan', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function delete_record($id){
		$this->db->where('perjalanan_id', $id);
		$this->db->delete('umb_perjalanans_karyawan');
		
	}
	
	public function update_record($data, $id){
		$this->db->where('perjalanan_id', $id);
		if( $this->db->update('umb_perjalanans_karyawan',$data)) {
			return true;
		} else {
			return false;
		}		
	}
}
?>