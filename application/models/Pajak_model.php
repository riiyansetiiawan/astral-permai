<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pajak_model extends CI_Model {

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function get_pajaks() {
		return $this->db->get("umb_types_pajak");
	}
	
	public function read_informasi_pajak($id) {

		$condition = "pajak_id =" . "'" . $id . "'";
		$this->db->select('*');
		$this->db->from('umb_types_pajak');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function add_record_pajak($data){
		$this->db->insert('umb_types_pajak', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function get_all_pajaks() {
		$query = $this->db->query("SELECT * from umb_types_pajak");
		return $query->result();
	}
	
	public function delete_record_pajak($id){
		$this->db->where('pajak_id', $id);
		$this->db->delete('umb_types_pajak');
		
	}
	
	public function update_record_pajak($data, $id){
		$this->db->where('pajak_id', $id);
		if( $this->db->update('umb_types_pajak',$data)) {
			return true;
		} else {
			return false;
		}		
	}
}
?>