<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Training_model extends CI_Model {
	
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	public function get_training() {
		return $this->db->get("umb_training");
	}
	
	public function get_type_training(){
		return $this->db->get("umb_types_training");
	}
	
	public function all_types_training() {
		$query = $this->db->query("SELECT * from umb_types_training");
		return $query->result();
	}
	
	public function read_informasi_training($id) {
		
		$sql = 'SELECT * FROM umb_training WHERE training_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	public function read_informasi_type_training($id) {
		
		$sql = 'SELECT * FROM umb_types_training WHERE type_training_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function add($data){
		$this->db->insert('umb_training', $data);
		if ($this->db->affected_rows() > 0) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}
	
	public function add_type($data){
		$this->db->insert('umb_types_training', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function delete_record($id){
		$this->db->where('training_id', $id);
		$this->db->delete('umb_training');
		
	}
	
	public function delete_record_type($id){
		$this->db->where('type_training_id', $id);
		$this->db->delete('umb_types_training');
		
	}
	
	public function update_record($data, $id){
		$this->db->where('training_id', $id);
		if( $this->db->update('umb_training',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function update_status($data, $id){
		$this->db->where('training_id', $id);
		if( $this->db->update('umb_training',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function update_record_type($data, $id){
		$this->db->where('type_training_id', $id);
		if( $this->db->update('umb_types_training',$data)) {
			return true;
		} else {
			return false;
		}		
	}

	public function get_perusahaan_training($perusahaan_id) {
		
		$sql = 'SELECT * FROM umb_training WHERE perusahaan_id = ?';
		$binds = array($perusahaan_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	public function get_karyawan_training($id) {
		
		$sql = "SELECT * FROM `umb_training` where karyawan_id like '%$id,%' or karyawan_id like '%,$id%' or karyawan_id = '$id'";
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
}
?>