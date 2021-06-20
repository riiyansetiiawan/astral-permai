<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quoted_project_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
	public function get_projects() {
		return $this->db->get("umb_quoted_projects");
	}
	
	public function read_informasi_project($id) {
		
		$sql = 'SELECT * FROM umb_quoted_projects WHERE project_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function get_kategoris_tugas() {
		return $this->db->get("umb_kategoris_tugas");
	}

	public function get_project_timelogs($project_id) {
		$sql = "SELECT * FROM umb_quoted_projects_timelogs where project_id = ?";
		$binds = array($project_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	public function get_all_project_timelogs() {
		$sql = "SELECT * FROM umb_quoted_projects_timelogs";
		$query = $this->db->query($sql);
		return $query;
	}

	public function get_leads_follow_up_all() {
		$sql = "SELECT * FROM umb_leads_followup";
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function get_estimates_all() {
		$sql = "SELECT * FROM umb_hrastral_quotes";
		$query = $this->db->query($sql);
		return $query->result();
	}
	public function get_all_project_karyawan_timelogs($user_id) {
		$sql = "SELECT * FROM umb_quoted_projects_timelogs where karyawan_id = ?";
		$binds = array($user_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	
	public function read_informasi_bug($id) {
		
		$sql = 'SELECT * FROM umb_projects_bugs WHERE bug_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows()> 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function add($data){
		$this->db->insert('umb_quoted_projects', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function add_kategoris_tugas($data){
		$this->db->insert('umb_kategoris_tugas', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function add_project_timelog($data){
		$this->db->insert('umb_quoted_projects_timelogs', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function delete_record_kategori_tugas($id){
		$this->db->where('kategori_tugas_id', $id);
		$this->db->delete('umb_kategoris_tugas');
		
	}
	
	public function read_informasi_kategori_tugas($id) {
		
		$sql = 'SELECT * FROM umb_kategoris_tugas WHERE kategori_tugas_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	public function read_info_timelog($id) {
		
		$sql = 'SELECT * FROM umb_quoted_projects_timelogs WHERE timelogs_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function update_record_kategori_tugas($data, $id){
		$this->db->where('kategori_tugas_id', $id);
		if( $this->db->update('umb_kategoris_tugas',$data)) {
			return true;
		} else {
			return false;
		}		
	}

	public function update_record_project_timelog($data, $id){
		$this->db->where('timelogs_id', $id);
		if( $this->db->update('umb_quoted_projects_timelogs',$data)) {
			return true;
		} else {
			return false;
		}		
	}

	public function delete_record($id){
		$this->db->where('project_id', $id);
		$this->db->delete('umb_quoted_projects');
		
	}

	public function delete_record_timelog($id){
		$this->db->where('timelogs_id', $id);
		$this->db->delete('umb_quoted_projects_timelogs');
		
	}
	
	public function get_attachments($id) {
		
		$sql = 'SELECT * FROM umb_quoted_projects_attachment WHERE project_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}
	
	public function get_projects_client($id) {
		
		$sql = 'SELECT * FROM umb_projects WHERE client_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}
	
	public function get_all_projects() {

		$query = $this->db->query("SELECT * from umb_quoted_projects");
		return $query->result();
	}
	
	public function add_new_attachment($data){
		$this->db->insert('umb_quoted_projects_attachment', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function delete_record_attachment($id){
		$this->db->where('project_attachment_id', $id);
		$this->db->delete('umb_quoted_projects_attachment');
		
	}
	
	public function get_diskusi($id) {
		
		$sql = 'SELECT * FROM umb_diskusi_quoted_projects WHERE project_id = ? order by diskusi_id desc';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}
	
	public function get_bug($id) {
		
		$sql = 'SELECT * FROM umb_projects_bugs WHERE project_id = ? order by bug_id desc';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}
	
	public function add_diskusi($data){
		$this->db->insert('umb_diskusi_quoted_projects', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function add_bug($data){
		$this->db->insert('umb_projects_bugs', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function update_bug($data, $id){
		$this->db->where('bug_id', $id);
		if( $this->db->update('umb_projects_bugs',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function update_record($data, $id){
		$this->db->where('project_id', $id);
		if( $this->db->update('umb_quoted_projects',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function ajax_perusahaan_projects($id) {
		
		$sql = 'SELECT * FROM umb_projects WHERE perusahaan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function total_project_tugass($id) {
		
		$sql = 'SELECT * FROM umb_tugass WHERE project_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query->num_rows();
	}
	
	public function total_project_bugs($id) {
		
		$sql = 'SELECT * FROM umb_projects_bugs WHERE project_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query->num_rows();
	}
	
	public function total_files_project($id) {
		
		$sql = 'SELECT * FROM umb_attachment_projects WHERE project_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		return $query->num_rows();
	}
	
	public function cancelled_projects() {
		
		$sql = 'SELECT * FROM umb_projects WHERE status = ?';
		$binds = array(3);
		$query = $this->db->query($sql, $binds);
		
		return $query->num_rows();
	}

	public function calendar_cancelled_projects() {
		
		$sql = 'SELECT * FROM umb_projects WHERE status = ?';
		$binds = array(3);
		$query = $this->db->query($sql, $binds);
		return $query->result();
	}

	public function calendar_cancelled_tugass() {
		
		$sql = 'SELECT * FROM umb_tugass WHERE status_tugas = ?';
		$binds = array(3);
		$query = $this->db->query($sql, $binds);
		return $query->result();
	}
	
	public function complete_projects() {
		
		$sql = 'SELECT * FROM umb_projects WHERE status = ?';
		$binds = array(2);
		$query = $this->db->query($sql, $binds);
		return $query->num_rows();
	}
	
	public function calendar_complete_projects() {
		
		$sql = 'SELECT * FROM umb_projects WHERE status = ?';
		$binds = array(2);
		$query = $this->db->query($sql, $binds);
		
		return $query->result();
	}

	public function calendar_complete_tugass() {
		
		$sql = 'SELECT * FROM umb_tugass WHERE status_tugas = ?';
		$binds = array(2);
		$query = $this->db->query($sql, $binds);
		
		return $query->result();
	}
	
	public function inprogress_projects() {
		
		$sql = 'SELECT * FROM umb_projects WHERE status = ?';
		$binds = array(1);
		$query = $this->db->query($sql, $binds);
		
		return $query->num_rows();
	}
	
	public function calendar_inprogress_projects() {
		
		$sql = 'SELECT * FROM umb_projects WHERE status = ?';
		$binds = array(1);
		$query = $this->db->query($sql, $binds);
		
		return $query->result();
	}

	public function calendar_inprogress_tugass() {
		
		$sql = 'SELECT * FROM umb_tugass WHERE status_tugas = ?';
		$binds = array(1);
		$query = $this->db->query($sql, $binds);
		
		return $query->result();
	}
	
	public function not_started_projects() {
		
		$sql = 'SELECT * FROM umb_projects WHERE status = ?';
		$binds = array(0);
		$query = $this->db->query($sql, $binds);
		
		return $query->num_rows();
	}

	public function calendar_not_started_projects() {
		
		$sql = 'SELECT * FROM umb_projects WHERE status = ?';
		$binds = array(0);
		$query = $this->db->query($sql, $binds);
		
		return $query->result();
	}

	public function calendar_not_started_tugass() {
		
		$sql = 'SELECT * FROM umb_tugass WHERE status_tugas = ?';
		$binds = array(0);
		$query = $this->db->query($sql, $binds);
		
		return $query->result();
	}

	public function hold_projects() {
		
		$sql = 'SELECT * FROM umb_projects WHERE status = ?';
		$binds = array(4);
		$query = $this->db->query($sql, $binds);
		
		return $query->num_rows();
	}

	public function calendar_hold_projects() {
		
		$sql = 'SELECT * FROM umb_projects WHERE status = ?';
		$binds = array(4);
		$query = $this->db->query($sql, $binds);
		
		return $query->result();
	}

	public function calendar_hold_tugass() {
		
		$sql = 'SELECT * FROM umb_tugass WHERE status_tugas = ?';
		$binds = array(4);
		$query = $this->db->query($sql, $binds);
		
		return $query->result();
	}

	public function calendar_user_hold_projects($id) {
		
		$sql = "SELECT * FROM umb_projects WHERE status = ? and (assigned_to like '%$id,%' or assigned_to like '%,$id%' or assigned_to = '$id')";
		$binds = array(4);
		$query = $this->db->query($sql, $binds);
		
		return $query->result();
	}

	public function calendar_user_not_started_projects($id) {
		
		$sql = "SELECT * FROM umb_projects WHERE status = ? and (assigned_to like '%$id,%' or assigned_to like '%,$id%' or assigned_to = '$id')";
		$binds = array(0);
		$query = $this->db->query($sql, $binds);
		
		return $query->result();
	}

	public function calendar_user_complete_projects($id) {
		
		$sql = "SELECT * FROM umb_projects WHERE status = ? and (assigned_to like '%$id,%' or assigned_to like '%,$id%' or assigned_to = '$id')";
		$binds = array(2);
		$query = $this->db->query($sql, $binds);
		
		return $query->result();
	}

	public function calendar_user_inprogress_projects($id) {
		
		$sql = "SELECT * FROM umb_projects WHERE status = ? and (assigned_to like '%$id,%' or assigned_to like '%,$id%' or assigned_to = '$id')";
		$binds = array(1);
		$query = $this->db->query($sql, $binds);
		
		return $query->result();
	}

	public function calendar_user_cancelled_projects($id) {
		
		$sql = "SELECT * FROM umb_projects WHERE status = ? and (assigned_to like '%$id,%' or assigned_to like '%,$id%' or assigned_to = '$id')";
		$binds = array(3);
		$query = $this->db->query($sql, $binds);
		
		return $query->result();
	}

	public function calendar_user_hold_tugass($id) {
		
		$sql = "SELECT * FROM umb_tugass WHERE status_tugas = ? and (assigned_to like '%$id,%' or assigned_to like '%,$id%' or assigned_to = '$id')";
		$binds = array(4);
		$query = $this->db->query($sql, $binds);
		
		return $query->result();
	}

	public function calendar_user_not_started_tugass($id) {
		
		$sql = "SELECT * FROM umb_tugass WHERE status_tugas = ? and (assigned_to like '%$id,%' or assigned_to like '%,$id%' or assigned_to = '$id')";
		$binds = array(0);
		$query = $this->db->query($sql, $binds);
		
		return $query->result();
	}

	public function calendar_user_complete_tugass($id) {
		
		$sql = "SELECT * FROM umb_tugass WHERE status_tugas = ? and (assigned_to like '%$id,%' or assigned_to like '%,$id%' or assigned_to = '$id')";
		$binds = array(2);
		$query = $this->db->query($sql, $binds);
		
		return $query->result();
	}

	public function calendar_user_inprogress_tugass($id) {
		
		$sql = "SELECT * FROM umb_tugass WHERE status_tugas = ? and (assigned_to like '%$id,%' or assigned_to like '%,$id%' or assigned_to = '$id')";
		$binds = array(1);
		$query = $this->db->query($sql, $binds);
		
		return $query->result();
	}

	public function calendar_user_cancelled_tugass($id) {
		
		$sql = "SELECT * FROM umb_tugass WHERE status_tugas = ? and (assigned_to like '%$id,%' or assigned_to like '%,$id%' or assigned_to = '$id')";
		$binds = array(3);
		$query = $this->db->query($sql, $binds);
		
		return $query->result();
	}

	public function deffered_client_projects($id) {
		
		$sql = 'SELECT * FROM umb_projects WHERE status = ? and client_id = ?';
		$binds = array(3,$id);
		$query = $this->db->query($sql, $binds);
		
		return $query->num_rows();
	}
	
	public function complete_client_projects($id) {
		
		$sql = 'SELECT * FROM umb_projects WHERE status = ? and client_id = ?';
		$binds = array(2,$id);
		$query = $this->db->query($sql, $binds);
		
		return $query->num_rows();
	}
	
	public function inprogress_client_projects($id) {
		
		$sql = 'SELECT * FROM umb_projects WHERE status = ? and client_id = ?';
		$binds = array(1,$id);
		$query = $this->db->query($sql, $binds);
		return $query->num_rows();
	}
	
	public function not_started_client_projects($id) {
		
		$sql = 'SELECT * FROM umb_projects WHERE status = ? and client_id = ?';
		$binds = array(0,$id);
		$query = $this->db->query($sql, $binds);
		
		return $query->num_rows();
	}
	
	public function completed_project_bugs($id) {
		
		$sql = 'SELECT * FROM umb_projects_bugs WHERE project_id = ? and status = ?';
		$binds = array($id,1);
		$query = $this->db->query($sql, $binds);
		
		$ctugass = $query->num_rows();
		$pQuery = $this->total_project_bugs($id);
		if($pQuery==0) {
			return $cttugass = 0;
		} else {
			$caltugass = $ctugass / $pQuery * 100;
			$cttugass = round($caltugass);
			return $cttugass;
		}
	}

	public function completed_project_tugass($id) {
		
		$sql = 'SELECT * FROM umb_tugass WHERE project_id = ? and status_tugas = ?';
		$binds = array($id,2);
		$query = $this->db->query($sql, $binds);
		
		$ctugass = $query->num_rows();
		$pQuery = $this->total_project_tugass($id);
		if($pQuery==0) {
			return $cttugass = 0;
		} else {
			$caltugass = $ctugass / $pQuery * 100;
			$cttugass = round($caltugass);
			return $cttugass;
		}
	}

	public function get_project_perusahaans($id) {
		
		$sql = "SELECT * FROM umb_quoted_projects WHERE perusahaan_id like '%$id,%' or perusahaan_id like '%,$id%' or perusahaan_id = '$id'";
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	public function get_projects_karyawan($id) {
		
		$sql = "SELECT * FROM `umb_quoted_projects` where assigned_to like '%$id,%' or assigned_to like '%,$id%' or assigned_to = '$id'";
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
}
?>