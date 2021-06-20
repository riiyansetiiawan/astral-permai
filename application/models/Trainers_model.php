<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Trainers_model extends CI_Model {
	
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	public function get_trainers() {
		return $this->db->get("umb_trainers");
	}
	
	public function all_trainers() {
		$query = $this->db->query("SELECT * from umb_trainers");
		return $query->result();
	}

	public function get_perusahaan_trainers($perusahaan_id) {
		
		$sql = 'SELECT * FROM umb_trainers WHERE perusahaan_id = ?';
		$binds = array($perusahaan_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	
	public function read_informasi_trainer($id) {
		
		$sql = 'SELECT * FROM umb_trainers WHERE trainer_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function add($data){
		$this->db->insert('umb_trainers', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function delete_record($id){
		$this->db->where('trainer_id', $id);
		$this->db->delete('umb_trainers');
		
	}
	
	public function update_record($data, $id){
		$this->db->where('trainer_id', $id);
		if( $this->db->update('umb_trainers',$data)) {
			return true;
		} else {
			return false;
		}		
	}
}
?>