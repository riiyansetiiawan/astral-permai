<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tickets_model extends CI_Model {
	
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	public function get_tickets() {
		return $this->db->get("umb_support_tickets");
	}
	
	public function read_informasi_ticket($id) {
		
		$sql = 'SELECT * FROM umb_support_tickets WHERE ticket_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	
	public function add($data){
		$this->db->insert('umb_support_tickets', $data);
		if ($this->db->affected_rows() > 0) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}
	
	public function add_comment($data){
		$this->db->insert('umb_tickets_comments', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function add_new_attachment($data){
		$this->db->insert('umb_tickets_attachment', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function delete_record($id){
		$this->db->where('ticket_id', $id);
		$this->db->delete('umb_support_tickets');
	}
	
	public function delete_record_comment($id){
		$this->db->where('comment_id', $id);
		$this->db->delete('umb_tickets_comments');
	}
	
	public function delete_record_attachment($id){
		$this->db->where('ticket_attachment_id', $id);
		$this->db->delete('umb_tickets_attachment');
	}
	
	public function get_tickets_karyawans($id) {
		
		/*$this->db->select('st.*, ste.*');
		$this->db->from('umb_support_tickets as st, umb_support_tickets_karyawans as ste');
		$this->db->where('st.ticket_id=ste.ticket_id');
		$this->db->where('ste.karyawan_id',$id. '|| st.created_by = "'.$id.'"');
		$this->db->group_by('st.ticket_id');*/
		$sql = 'SELECT st.*, ste.* FROM umb_support_tickets as st, umb_support_tickets_karyawans as ste WHERE st.ticket_id=ste.ticket_id and (ste.karyawan_id = ? || st.created_by = ?)';
		$binds = array($id,$id);
		//$this->db->group_by("st.ticket_id");
		//$query = $this->db->get();
		$query = $this->db->query($sql,$binds);
		return $query;
	}

	public function get_tickets_karyawan($id) {		
		$sql = 'SELECT st.*, ste.* FROM umb_support_tickets as st, umb_support_tickets_karyawans as ste WHERE st.ticket_id=ste.ticket_id and (ste.karyawan_id = ? || st.created_by = ?)';
		$binds = array($id,$id);
		//$this->db->group_by("st.ticket_id");
		//$query = $this->db->get();
		$query = $this->db->query($sql,$binds);
		return $query;
	}

	public function get_perusahaan_tickets($id) {
		
		$sql = 'SELECT * FROM umb_support_tickets WHERE perusahaan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	
	public function update_record($data, $id){
		$this->db->where('ticket_id', $id);
		if( $this->db->update('umb_support_tickets',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function assign_ticket_user($data, $id){
		$this->db->where('ticket_id', $id);
		if( $this->db->update('umb_support_tickets',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function update_status($data, $id){
		$this->db->where('ticket_id', $id);
		if( $this->db->update('umb_support_tickets',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function update_note($data, $id){
		$this->db->where('ticket_id', $id);
		if( $this->db->update('umb_support_tickets',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function get_comments($id) {
		
		$sql = 'SELECT * FROM umb_tickets_comments WHERE ticket_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	
	public function get_attachments($id) {
		
		$sql = 'SELECT * FROM umb_tickets_attachment WHERE ticket_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}
	
	public function read_informasi_ticket_users($id) {
		
		$sql = 'SELECT * FROM umb_support_tickets WHERE ticket_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query->result();
	}
	
	public function add_ticket_karyawans($data){
		$this->db->insert('umb_support_tickets_karyawans', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function get_ticket_karyawans($id) {
		
		$sql = 'SELECT * FROM umb_support_tickets_karyawans WHERE ticket_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		return $query->result();
	}
	
	public function update_record_ticket_karyawan($data, $id,$karyawan_id){
		
		$this->db->where('ticket_id', $id);
		$this->db->where('karyawan_id', $karyawan_id);
		if( $this->db->update('umb_support_tickets_karyawans',$data)) {
			return true;
		} else {
			return false;
		}
	}

	public function ajax_info_department_karyawan($id) {
		
		//$sql = "SELECT * FROM umb_karyawans WHERE perusahaan_id = ? and user_role_id!='1' and is_logged_in='1'";
		$sql = "SELECT * FROM umb_karyawans WHERE department_id = ? and user_role_id!='1'";
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
}
?>