<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Languages_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function get_languages() {
		return $this->db->get("umb_languages");
	}

	public function read_informasi_language($id) {

		$sql = 'SELECT * FROM umb_languages WHERE language_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}	
	
	public function add($data){
		$this->db->insert('umb_languages', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function delete_record($id){
		$this->db->where('language_id', $id);
		$this->db->delete('umb_languages');
		
	}
	
	public function active_lang_record($data, $id){
		$this->db->where('language_id', $id);
		if( $this->db->update('umb_languages',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function update_record($data, $id){
		$this->db->where('language_id', $id);
		if( $this->db->update('umb_languages',$data)) {
			return true;
		} else {
			return false;
		}		
	}
}
?>