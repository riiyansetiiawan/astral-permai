<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Clients_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function get_clients() {
		return $query = $this->db->query("SELECT * from umb_clients");
	}

	public function get_all_clients() {
		$query = $this->db->query("SELECT * from umb_clients");
		return $query->result();
	}

	public function read_info_client($id) {

		$sql = "SELECT * FROM umb_clients WHERE client_id = ?";
		$binds = array($id);
		$query = $this->db->query($sql, $binds);		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function login($data) {

		$sql = "SELECT * FROM umb_clients WHERE email = ? AND is_active = ?";
		$binds = array($data['username'],1);
		$query = $this->db->query($sql, $binds);		
		
		$options = array('cost' => 12);
		$password_hash = password_hash($data['password'], PASSWORD_BCRYPT, $options);
		if ($query->num_rows() > 0) {
			$rw_password = $query->result();
			if(password_verify($data['password'],$rw_password[0]->password_client)){
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	public function read_info_client_melalui_email($email) {

		$sql = "SELECT * FROM umb_clients WHERE email = ?";
		$binds = array($email);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}
	
	public function read_infomasi_client($username) {

		$sql = "SELECT * FROM umb_clients WHERE email = ?";
		$binds = array($username);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function add($data){
		$this->db->insert('umb_clients', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function delete_record($id){
		$this->db->where('client_id', $id);
		$this->db->delete('umb_clients');
		
	}
	
	public function update_record($data, $id){
		$this->db->where('client_id', $id);
		if( $this->db->update('umb_clients',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function get_leads() {

		return $query = $this->db->query("SELECT * from umb_leads");
	}

	public function get_lead_followup($lead_id) {

		$sql = "SELECT * FROM umb_leads_followup WHERE lead_id = ?";
		$binds = array($lead_id);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}

	public function get_all_leads() {
		$query = $this->db->query("SELECT * from umb_leads");
		return $query->result();
	}

	public function read_info_lead($id) {

		$sql = "SELECT * FROM umb_leads WHERE client_id = ?";
		$binds = array($id);
		$query = $this->db->query($sql, $binds);		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function read_info_lead_melalui_email($email) {

		$sql = "SELECT * FROM umb_leads WHERE email = ?";
		$binds = array($email);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}
	
	public function read_infomasi_lead($username) {

		$sql = "SELECT * FROM umb_leads WHERE email = ?";
		$binds = array($username);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	public function read_info_lead_followup($leads_followup_id) {

		$sql = "SELECT * FROM umb_leads_followup WHERE leads_followup_id = ?";
		$binds = array($leads_followup_id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function add_lead($data){
		$this->db->insert('umb_leads', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function add_lead_followup($data){
		$this->db->insert('umb_leads_followup', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function delete_record_lead($id){
		$this->db->where('client_id', $id);
		$this->db->delete('umb_leads');
		
	}

	public function delete_lead_followup($id){
		$this->db->where('leads_followup_id', $id);
		$this->db->delete('umb_leads_followup');
		
	}

	public function delete_main_lead_followup($id){
		$this->db->where('lead_id', $id);
		$this->db->delete('umb_leads_followup');
		
	}
	
	public function update_record_lead($data, $id){
		$this->db->where('client_id', $id);
		if( $this->db->update('umb_leads',$data)) {
			return true;
		} else {
			return false;
		}		
	}

	public function update_record_lead_followup($data, $id){
		$this->db->where('leads_followup_id', $id);
		if( $this->db->update('umb_leads_followup',$data)) {
			return true;
		} else {
			return false;
		}		
	}

	public function get_total_leads() {

		$sql = "SELECT * FROM umb_leads";
		$query = $this->db->query($sql);		
		return $query->num_rows();
	}

	public function get_total_clients() {

		$sql = "SELECT * FROM umb_clients";
		$query = $this->db->query($sql);		
		return $query->num_rows();
	}

	public function get_total_client_convert() {

		$sql = "SELECT * FROM umb_leads WHERE is_changed = ?";
		$binds = array(1);
		$query = $this->db->query($sql, $binds);
		return $query->num_rows();
	}

	public function get_total_pending_followup() {

		$query = $this->db
		->select('lead_id')
		->group_by('lead_id')
		->get('umb_leads_followup');
		return $query->num_rows();
	}

	public function get_total_lead_followup($lead_id) {

		$sql = "SELECT * FROM umb_leads_followup WHERE lead_id = ?";
		$binds = array($lead_id);
		$query = $this->db->query($sql, $binds);
		return $query->num_rows();
	}
}
?>