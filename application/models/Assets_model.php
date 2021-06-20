<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assets_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function get_kategoris_assets() {

		return $this->db->get("umb_kategoris_assets");
	}
	
	public function get_assets() {

		return $this->db->get("umb_assets");
	}
	
	public function get_assets_karyawan($id) {
		
		//$id = $this->db->escape($id);
		$sql = 'SELECT * FROM umb_assets WHERE karyawan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}

	public function get_perusahaan_assets($perusahaan_id) {

		$sql = 'SELECT * FROM umb_assets WHERE perusahaan_id = ?';
		$binds = array($perusahaan_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	public function get_all_kategoris_assets() {

		$query = $this->db->get("umb_kategoris_assets");
		return $query->result();
	}

	public function read_info_assets($id) {

		$sql = 'SELECT * FROM umb_assets WHERE assets_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function read_info_kategori_assets($id) {

		$sql = 'SELECT * FROM umb_kategoris_assets WHERE kategori_assets_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function add_asset($data){
		$this->db->insert('umb_assets', $data);
		if ($this->db->affected_rows() > 0) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}
	
	public function add_kategori_assets($data){
		$this->db->insert('umb_kategoris_assets', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function delete_record_assets($id){
		$this->db->where('assets_id', $id);
		$this->db->delete('umb_assets');
	}
	
	public function delete_record_kategori_assets($id){
		$this->db->where('kategori_assets_id', $id);
		$this->db->delete('umb_kategoris_assets');
		
	}
	
	public function update_record_assets($data, $id){

		$this->db->where('assets_id', $id);
		if( $this->db->update('umb_assets',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function update_record_kategori_assets($data, $id){
		$this->db->where('kategori_assets_id', $id);
		if( $this->db->update('umb_kategoris_assets',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function update_record_no_photo($data, $id){
		$this->db->where('user_id', $id);
		if( $this->db->update('umb_users',$data)) {
			return true;
		} else {
			return false;
		}		
	}
}
?>