<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permintaan_lembur_model extends CI_Model {

	public function __construct() {

		parent::__construct();
		$this->load->database();
	}


	public function add_permintaan_lembur_karyawan($data){
		$this->db->insert('umb_permintaan_waktu_kehadiran', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function update_record_permintaan($data, $id){
		$this->db->where('permintaan_waktu_id', $id);
		if( $this->db->update('umb_permintaan_waktu_kehadiran',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function read_info_permintaan_lembur($id) {

		$sql = 'SELECT * FROM umb_permintaan_waktu_kehadiran WHERE permintaan_waktu_id = ? limit 1';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function delete_record_permintaan_lembur($id){ 
		$this->db->where('permintaan_waktu_id', $id);
		$this->db->delete('umb_permintaan_waktu_kehadiran');
		
	}
	
	public function permintaans_lembur_karyawan($krywn_id) {
		
		$sql = 'SELECT * FROM umb_permintaan_waktu_kehadiran where karyawan_id = ?';
		$binds = array($krywn_id);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}
	
	public function all_pemintaans_lembur_karyawan() {
		
		$sql = 'SELECT * FROM umb_permintaan_waktu_kehadiran';
		$query = $this->db->query($sql);
		
		return $query;
	}

	public function get_count_permintaan_lembur($karyawan_id,$pay_date) {
		
		$sql = 'SELECT * FROM `umb_permintaan_waktu_kehadiran` where karyawan_id = ? and is_approved = ? and tanggal_permintaan_request = ?';
		$binds = array($karyawan_id,2,$pay_date);
		$query = $this->db->query($sql, $binds);
		$result = $query->result();
		return $result;
	}
}
?>