<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengunduran_diri_model extends CI_Model {

	public function __construct() {
		
		parent::__construct();
		$this->load->database();
	}

	public function get_pengundurans_diri() {

		return $this->db->get("umb_pengundurans_diri_karyawan");
	}

	public function read_informasi_pengunduran_diri($id) {

		$sql = 'SELECT * FROM umb_pengundurans_diri_karyawan WHERE pengunduran_diri_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function get_perusahaan_pengundurans_diri($perusahaan_id) {

		$sql = 'SELECT * FROM umb_pengundurans_diri_karyawan WHERE perusahaan_id = ?';
		$binds = array($perusahaan_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	public function get_pengunduran_diri_karyawan($id) {
		
		$sql = 'SELECT * FROM umb_pengundurans_diri_karyawan WHERE karyawan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	
	public function add($data){
		$this->db->insert('umb_pengundurans_diri_karyawan', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function delete_record($id){
		$this->db->where('pengunduran_diri_id', $id);
		$this->db->delete('umb_pengundurans_diri_karyawan');
		
	}
	
	public function update_record($data, $id){
		$this->db->where('pengunduran_diri_id', $id);
		if( $this->db->update('umb_pengundurans_diri_karyawan',$data)) {
			return true;
		} else {
			return false;
		}		
	}
}
?>