<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporans_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function get_list_slipgaji($cid,$eid,$re_date) {
		if($eid=='' || $eid==0){
			
			$sql = 'SELECT * from umb_gaji_slipgajii where gaji_bulan = ? and perusahaan_id = ?';
			$binds = array($re_date,$cid);
			$query = $this->db->query($sql, $binds);
			
			return $query;
		} else {
			
			$sql = 'SELECT * from umb_gaji_slipgajii where karyawan_id = ? and gaji_bulan = ? and perusahaan_id = ?';
			$binds = array($eid,$re_date,$cid);
			$query = $this->db->query($sql, $binds);
			
			return $query;
		}
	}

	public function get_list_training($cid,$sdate,$edate) {
		
		$sql = 'SELECT * from `umb_training` where perusahaan_id = ? and start_date >= ? and finish_date <= ?';
		$binds = array($cid,$sdate,$edate);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}

	public function get_list_application_cuti() {
		
		$this->db->query("SET SESSION sql_mode = ''");
		$sql = 'SELECT * from `umb_applications_cuti` group by karyawan_id';
		$query = $this->db->query($sql);
		return $query;
	}

	public function get_list_filter_application_cuti($sd,$ed,$user_id,$perusahaan_id) {
		
		$this->db->query("SET SESSION sql_mode = ''");
		$sql = 'SELECT * from `umb_applications_cuti` where perusahaan_id = ? and karyawan_id = ? and from_date >= ? and to_date <= ? group by karyawan_id';
		$binds = array($perusahaan_id,$user_id,$sd,$ed);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	
	public function get_pending_list_application_cuti($karyawan_id) {
		
		$sql = 'SELECT * from `umb_applications_cuti` where karyawan_id = ? and status = ?';
		$binds = array($karyawan_id,1);
		$query = $this->db->query($sql, $binds);
		return $query->num_rows();
	}

	public function get_approved_list_application_cuti($karyawan_id) {
		
		$sql = 'SELECT * from `umb_applications_cuti` where karyawan_id = ? and status = ?';
		$binds = array($karyawan_id,2);
		$query = $this->db->query($sql, $binds);
		return $query->num_rows();
	}

	public function get_upcoming_cuti_application_list($karyawan_id) {
		
		$sql = 'SELECT * from `umb_applications_cuti` where karyawan_id = ? and status = ?';
		$binds = array($karyawan_id,4);
		$query = $this->db->query($sql, $binds);
		return $query->num_rows();
	}

	public function get_rejected_list_application_cuti($karyawan_id) {
		
		$sql = 'SELECT * from `umb_applications_cuti` where karyawan_id = ? and status = ?';
		$binds = array($karyawan_id,3);
		$query = $this->db->query($sql, $binds);
		return $query->num_rows();
	}

	public function get_pending_list_cuti($karyawan_id,$status) {
		
		$sql = 'SELECT * from `umb_applications_cuti` where karyawan_id = ? and status = ?';
		$binds = array($karyawan_id,$status);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	public function get_list_project($projId,$projStatus) {
		
		if($projId==0 && $projStatus=='all') {
			return $query = $this->db->query("SELECT * FROM `umb_projects`");
		} else if($projId==0 && $projStatus!='all') {
			$sql = 'SELECT * from `umb_projects` where status = ?';
			$binds = array($projStatus);
			$query = $this->db->query($sql, $binds);
			return $query;
		} else if($projId!=0 && $projStatus=='all') {
			$sql = 'SELECT * from `umb_projects` where project_id = ?';
			$binds = array($projId);
			$query = $this->db->query($sql, $binds);
			return $query;
		} else if($projId!=0 && $projStatus!='all') {
			$sql = 'SELECT * from `umb_projects` where project_id = ? and status = ?';
			$binds = array($projId,$projStatus);
			$query = $this->db->query($sql, $binds);
			return $query;
		}
	}

	public function get_projects_karyawanx($id) {
		
		$sql = "SELECT * FROM `umb_projects` where assigned_to like '%$id,%' or assigned_to like '%,$id%' or assigned_to = '$id'";
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	
	public function get_list_tugas($tugasId,$tugasstatus) {
		
		if($tugasId==0 && $tugasstatus==4) {
			return $query = $this->db->query("SELECT * FROM umb_tugass");
		} else if($tugasId==0 && $tugasstatus!=4) {
			$sql = 'SELECT * from umb_tugass where status_tugas = ?';
			$binds = array($tugasstatus);
			$query = $this->db->query($sql, $binds);
			return $query;
		} else if($tugasId!=0 && $tugasstatus==4) {
			$sql = 'SELECT * from umb_tugass where tugas_id = ?';
			$binds = array($tugasId);
			$query = $this->db->query($sql, $binds);
			return $query;
		} else if($tugasId!=0 && $tugasstatus!=4) {
			$sql = 'SELECT * from umb_tugass where tugas_id = ? and status_tugas = ?';
			$binds = array($tugasId,$tugasstatus);
			$query = $this->db->query($sql, $binds);
			return $query;
		}
	}
	
	public function get_roles_karyawans($role_id) {
		if($role_id==0) {
			return $query = $this->db->query("SELECT * FROM umb_karyawans");
		} else {
			$sql = 'SELECT * from umb_karyawans where user_role_id = ?';
			$binds = array($role_id);
			$query = $this->db->query($sql, $binds);
			return $query;
		}
	}
	
	public function get_laporans_karyawans($perusahaan_id,$department_id,$penunjukan_id) {
		if($perusahaan_id==0 && $department_id==0 && $penunjukan_id==0) {
			return $query = $this->db->query("SELECT * FROM umb_karyawans");
		} else if($perusahaan_id!=0 && $department_id==0 && $penunjukan_id==0) {
			$sql = 'SELECT * from umb_karyawans where perusahaan_id = ?';
			$binds = array($perusahaan_id);
			$query = $this->db->query($sql, $binds);
			return $query;
		} else if($perusahaan_id!=0 && $department_id!=0 && $penunjukan_id==0) {
			$sql = 'SELECT * from umb_karyawans where perusahaan_id = ? and department_id = ?';
			$binds = array($perusahaan_id,$department_id);
			$query = $this->db->query($sql, $binds);
			return $query;
		} else if($perusahaan_id!=0 && $department_id!=0 && $penunjukan_id!=0) {
			$sql = 'SELECT * from umb_karyawans where perusahaan_id = ? and department_id = ? and penunjukan_id = ?';
			$binds = array($perusahaan_id,$department_id,$penunjukan_id);
			$query = $this->db->query($sql, $binds);
			return $query;
		} else {
			return $query = $this->db->query("SELECT * FROM umb_karyawans");
		}
	}
	
}
?>