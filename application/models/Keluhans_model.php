<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Keluhans_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function get_keluhans() {
		return $this->db->get("umb_keluhans_karyawan");
	}

	public function read_informasi_keluhan($id) {

		$sql = 'SELECT * FROM umb_keluhans_karyawan WHERE keluhan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function get_karyawan_keluhans($id) {
		
		$sql = 'SELECT * FROM umb_keluhans_karyawan WHERE keluhan_dari = ?';
		$binds = array($id);
		$query = $this->db->query($sql,$binds);
		return $query;
	}

	public function get_perusahaan_keluhans($perusahaan_id) {

		$sql = 'SELECT * FROM umb_keluhans_karyawan WHERE perusahaan_id = ?';
		$binds = array($perusahaan_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	

	public function add($data){
		$this->db->insert('umb_keluhans_karyawan', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function delete_record($id){
		$this->db->where('keluhan_id', $id);
		$this->db->delete('umb_keluhans_karyawan');
		
	}
	
	public function update_record($data, $id){
		$this->db->where('keluhan_id', $id);
		if( $this->db->update('umb_keluhans_karyawan',$data)) {
			return true;
		} else {
			return false;
		}		
	}
}
?>