<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transfers_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function get_transfers() {
		return $this->db->get("umb_karyawan_transfer");
	}
	
	public function get_karyawan_transfers($id) {

		$sql = 'SELECT * FROM umb_karyawan_transfer WHERE karyawan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}

	public function get_perusahaan_transfers($perusahaan_id) {

		$sql = 'SELECT * FROM umb_karyawan_transfer WHERE perusahaan_id = ?';
		$binds = array($perusahaan_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	public function read_informasi_transfer($id) {

		$sql = 'SELECT * FROM umb_karyawan_transfer WHERE transfer_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function add($data){
		$this->db->insert('umb_karyawan_transfer', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function delete_record($id){
		$this->db->where('transfer_id', $id);
		$this->db->delete('umb_karyawan_transfer');
		
	}
	
	public function update_record($data, $id){
		$this->db->where('transfer_id', $id);
		if( $this->db->update('umb_karyawan_transfer',$data)) {
			return true;
		} else {
			return false;
		}		
	}
}
?>