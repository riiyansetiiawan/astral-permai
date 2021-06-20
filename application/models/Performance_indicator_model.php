<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Performance_indicator_model extends CI_Model {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
	public function get_performance_indicator()
	{
	  return $this->db->get("umb_performance_indicator");
	}
	 
	 public function read_informasi_performance_indicator($id) {
	
		$sql = 'SELECT * FROM umb_performance_indicator WHERE performance_indicator_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	public function get_penunjukan_performance_indicator($id) {
	 	
		$sql = 'SELECT * FROM umb_performance_indicator WHERE penunjukan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}
	public function get_perusahaan_performance_indicator($id) {
	 	
		$sql = 'SELECT * FROM umb_performance_indicator WHERE perusahaan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}
	
	// Function to add record in table
	public function add($data){
		$this->db->insert('umb_performance_indicator', $data);
		if ($this->db->affected_rows() > 0) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}
	
	// Function to Delete selected record from table
	public function delete_record($id){
		$this->db->where('performance_indicator_id', $id);
		$this->db->delete('umb_performance_indicator');
		
	}
	
	// Function to update record in table
	public function update_record($data, $id){
		$this->db->where('performance_indicator_id', $id);
		if( $this->db->update('umb_performance_indicator',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// Function to add record in table
	public function add_indicator_options($data){
		$this->db->insert('umb_performance_indicator_options', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	
	public function read_indicator_technical_options($ikey,$id) {
	
		$sql = 'SELECT * FROM umb_performance_indicator_options WHERE indicator_type = "technical" and indicator_option_id = ? and indicator_id = ?';
		$binds = array($ikey,$id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	public function read_indicator_organizational_options($ikey,$id) {
	
		$sql = 'SELECT * FROM umb_performance_indicator_options WHERE indicator_type = "organizational" and indicator_option_id = ? and indicator_id = ?';
		$binds = array($ikey,$id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	//check if available
	public function read_indicator_technical_options_available($ikey,$id) {
	
		$sql = 'SELECT * FROM umb_performance_indicator_options WHERE indicator_type = "technical" and indicator_option_id = ? and indicator_id = ?';
		$binds = array($ikey,$id);
		$query = $this->db->query($sql, $binds);
		return $query->num_rows();
	}
	//check if available
	public function read_indicator_organizational_options_available($ikey,$id) {
	
		$sql = 'SELECT * FROM umb_performance_indicator_options WHERE indicator_type = "organizational" and indicator_option_id = ? and indicator_id = ?';
		$binds = array($ikey,$id);
		$query = $this->db->query($sql, $binds);
		return $query->num_rows();
	}
	
	// Function to update record in table
	public function update_indicator_technical_record($key,$data, $id){
		$this->db->where('indicator_id', $id);
		$this->db->where('indicator_option_id', $key);
		$this->db->where('indicator_type', 'technical');
		if( $this->db->update('umb_performance_indicator_options',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	// Function to update record in table
	public function update_record_indicator_organizational($key,$data, $id){
		$this->db->where('indicator_id', $id);
		$this->db->where('indicator_option_id', $key);
		$this->db->where('indicator_type', 'organizational');
		if( $this->db->update('umb_performance_indicator_options',$data)) {
			return true;
		} else {
			return false;
		}		
	}
}
?>