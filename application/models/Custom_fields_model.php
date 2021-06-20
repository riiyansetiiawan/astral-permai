<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Custom_fields_model extends CI_Model {

	public function __construct() {

		parent::__construct();
		$this->load->database();
	}

	public function get_hrastral_module_attributes() {
		return $this->db->get("umb_hrastral_module_attributes");
	}

	public function read_hrastral_module_attributes($id) {

		$sql = 'SELECT * FROM umb_hrastral_module_attributes WHERE custom_field_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	public function get_attribute_selection_values($id) {

		$sql = 'SELECT * FROM umb_hrastral_module_attributes_select_value WHERE custom_field_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		return $query->result();
	}
	
	public function add($data){
		$this->db->insert('umb_hrastral_module_attributes', $data);
		if ($this->db->affected_rows() > 0) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}

	public function add_select_value($data){
		$this->db->insert('umb_hrastral_module_attributes_select_value', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function add_values($data){
		$this->db->insert('umb_hrastral_module_attributes_values', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function read_hrastral_module_attributes_values($user_id,$id) {

		$sql = 'SELECT * FROM umb_hrastral_module_attributes_values WHERE module_attributes_id = ? and user_id = ?';
		$binds = array($id,$user_id);
		$query = $this->db->query($sql, $binds)->row();
		return $query;
	}

	public function get_data_custom_karyawan($user_id,$module_attributes_id) {

		$this->db->select('*');
		$this->db->from('umb_hrastral_module_attributes_values');
		$this->db->where('module_attributes_id', $module_attributes_id);
		$this->db->where('user_id', $user_id);
		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			return $result->row();
		} else {
			return null;
		}
	}
	
	public function delete_record($id){
		$this->db->where('custom_field_id', $id);
		$this->db->delete('umb_hrastral_module_attributes');
		
	}
	
	public function update_record($data, $id){
		$this->db->where('custom_field_id', $id);
		if( $this->db->update('umb_hrastral_module_attributes',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function update_att_record($data, $user_id,$module_attributes_id){
		$this->db->where('module_attributes_id', $module_attributes_id);
		$this->db->where('user_id', $user_id);
		if( $this->db->update('umb_hrastral_module_attributes_values',$data)) {
			return true;
		} else {
			return false;
		}		
	}

	public function count_module_attributes_values($user_id,$module_attributes_id){
		$query = $this->db->query("SELECT * from umb_hrastral_module_attributes_values where module_attributes_id = '".$module_attributes_id."' and user_id = '".$user_id."'");
		return $query->num_rows();
	}
	
	public function all_hrastral_module_attributes() {
		$query = $this->db->query("SELECT * from umb_hrastral_module_attributes where `module_id` = '1' order by priority asc");
		return $query->result();
	}

	public function count_module_attributes() {
		$query = $this->db->query("SELECT * from umb_hrastral_module_attributes where `module_id` = '1'");
		return $query->num_rows();
	}

	public function awards_hrastral_module_attributes() {
		$query = $this->db->query("SELECT * from umb_hrastral_module_attributes where `module_id` = '2' order by priority asc");
		return $query->result();
	}

	public function count_awards_module_attributes() {
		$query = $this->db->query("SELECT * from umb_hrastral_module_attributes where `module_id` = '2'");
		return $query->num_rows();
	}

	public function pengumumans_hrastral_module_attributes() {
		$query = $this->db->query("SELECT * from umb_hrastral_module_attributes where `module_id` = '3' order by priority asc");
		return $query->result();
	}

	public function count_pengumumans_module_attributes() {
		$query = $this->db->query("SELECT * from umb_hrastral_module_attributes where `module_id` = '3'");
		return $query->num_rows();
	}

	public function perusahaan_hrastral_module_attributes() {
		$query = $this->db->query("SELECT * from umb_hrastral_module_attributes where `module_id` = '4' order by priority asc");
		return $query->result();
	}

	public function count_perusahaan_module_attributes() {
		$query = $this->db->query("SELECT * from umb_hrastral_module_attributes where `module_id` = '4'");
		return $query->num_rows();
	}

	public function training_hrastral_module_attributes() {
		$query = $this->db->query("SELECT * from umb_hrastral_module_attributes where `module_id` = '5' order by priority asc");
		return $query->result();
	}

	public function count_training_module_attributes() {
		$query = $this->db->query("SELECT * from umb_hrastral_module_attributes where `module_id` = '5'");
		return $query->num_rows();
	}

	public function tickets_hrastral_module_attributes() {
		$query = $this->db->query("SELECT * from umb_hrastral_module_attributes where `module_id` = '6' order by priority asc");
		return $query->result();
	}

	public function count_tickets_module_attributes() {
		$query = $this->db->query("SELECT * from umb_hrastral_module_attributes where `module_id` = '6'");
		return $query->num_rows();
	}

	public function assets_hrastral_module_attributes() {
		$query = $this->db->query("SELECT * from umb_hrastral_module_attributes where `module_id` = '7' order by priority asc");
		return $query->result();
	}

	public function count_assets_module_attributes() {
		$query = $this->db->query("SELECT * from umb_hrastral_module_attributes where `module_id` = '7'");
		return $query->num_rows();
	}
}
?>