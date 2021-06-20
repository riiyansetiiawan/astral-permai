<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Biaya_model extends CI_Model {

	public function __construct() {

		parent::__construct();
		$this->load->database();
	}

	public function get_biayaa() {

		return $this->db->get("umb_biayaa");
	}
	
	public function get_biayaa_karyawan() {

		$session = $this->session->userdata('username');
		$sql = 'SELECT * FROM umb_biayaa WHERE karyawan_id = ?';
		$binds = array($session['user_id']);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}
	
	public function get_total_biayaa() {

		$query = $this->db->query("SELECT SUM(jumlah) as exp_jumlah FROM umb_biayaa");
		return $query->result();
	}
	
	public function get_totan_keuangan_biayaa() {

		$query = $this->db->query("SELECT SUM(jumlah) as exp_jumlah FROM umb_keuangan_transaksi where type_transaksi = 'biaya'");
		return $query->result();
	}

	public function read_informasi_biaya($id) {

		$sql = 'SELECT * FROM umb_biayaa WHERE biaya_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query->result();
	}
	
	public function read_informasi_type_biaya($id) {

		$sql = 'SELECT * FROM umb_type_biaya WHERE type_biaya_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function all_types_biaya() {

		$query = $this->db->query("SELECT * from umb_type_biaya");
		return $query->result();
	}
	
	public function add($data) {

		$this->db->insert('umb_biayaa', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function delete_record($id) {

		$this->db->where('biaya_id', $id);
		$this->db->delete('umb_biayaa');
	}
	
	public function update_record($data, $id) {

		$this->db->where('biaya_id', $id);
		if( $this->db->update('umb_biayaa',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function update_record_no_logo($data, $id) {

		$this->db->where('biaya_id', $id);
		if( $this->db->update('umb_biayaa',$data)) {
			return true;
		} else {
			return false;
		}		
	}
}
?>