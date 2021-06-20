<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kebijakan_model extends CI_Model {

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function get_kebijakans(){
		return $this->db->get("umb_kebijakan_perusahaan");
	}

	public function read_informasi_kebijakan($id) {

		$sql = 'SELECT * FROM umb_kebijakan_perusahaan WHERE kebijakan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function get_kebijakans_perusahaan($perusahaan_id) {

		$sql = 'SELECT * FROM umb_kebijakan_perusahaan WHERE perusahaan_id = ?';
		$binds = array($perusahaan_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	
	public function add($data){
		$this->db->insert('umb_kebijakan_perusahaan', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function delete_record($id){
		$this->db->where('kebijakan_id', $id);
		$this->db->delete('umb_kebijakan_perusahaan');
		
	}
	
	public function update_record($data, $id){
		$this->db->where('kebijakan_id', $id);
		if( $this->db->update('umb_kebijakan_perusahaan',$data)) {
			return true;
		} else {
			return false;
		}		
	}
}
?>