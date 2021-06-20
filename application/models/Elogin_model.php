<?php

class Elogin_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	public function read_setting_info($id) {

		$sql = 'SELECT * FROM umb_system_setting WHERE setting_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	public function login($data) {

		$system = $this->read_setting_info(1);
		if($system[0]->login_karyawan_id=='username'):		
			
			$sql = 'SELECT * FROM umb_karyawans WHERE username = ? and password = ? and is_active = ?';
			$binds = array($data['username'],$data['password'],1);
			$query = $this->db->query($sql, $binds);

		else:
			$sql = 'SELECT * FROM umb_karyawans WHERE email = ? and password = ? and is_active = ?';
			$binds = array($data['username'],$data['password'],1);
			$query = $this->db->query($sql, $binds);
			
		endif;

		if ($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function read_em_info($username) {

		$sql = 'SELECT * FROM umb_karyawans WHERE username = ? OR email = ?';
		$binds = array($username,$username);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function read_user_info_session_id($user_id) {

		$sql = 'SELECT * FROM umb_perusahaans WHERE perusahaan_id = ?';
		$binds = array($user_id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
}
?>