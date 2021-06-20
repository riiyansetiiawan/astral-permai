<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Promotion_model extends CI_Model {
	
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	public function get_promotions() {
		return $this->db->get("umb_promotions_karyawan");
	}
	
	public function get_karyawan_promotions($id) {
		
		$sql = 'SELECT * FROM umb_promotions_karyawan WHERE karyawan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}

	public function get_perusahaan_promotions($perusahaan_id) {
		
		$sql = 'SELECT * FROM umb_promotions_karyawan WHERE perusahaan_id = ?';
		$binds = array($perusahaan_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	
	public function read_informasi_promotion($id) {
		
		$sql = 'SELECT * FROM umb_promotions_karyawan WHERE promotion_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function add($data){
		$this->db->insert('umb_promotions_karyawan', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function delete_record($id){
		$this->db->where('promotion_id', $id);
		$this->db->delete('umb_promotions_karyawan');
		
	}
	
	public function update_record($data, $id){
		$this->db->where('promotion_id', $id);
		if( $this->db->update('umb_promotions_karyawan',$data)) {
			return true;
		} else {
			return false;
		}		
	}
}
?>