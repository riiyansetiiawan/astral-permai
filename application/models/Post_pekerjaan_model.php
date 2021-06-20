<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Post_pekerjaan_model extends CI_Model {
	
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	public function get_pekerjaans() {
		return $this->db->get("umb_pekerjaans");
	}

	public function get_cms_pages() {
		return $this->db->get("umb_pages_pekerjaan");
	}
	
	public function get_kandidats_pekerjaans() {
		return $this->db->get("umb_applications_pekerjaan");
	}
	
	public function get_karyawan_applied_pekerjaans($id) {
		return $query = $this->db->query("SELECT * from umb_applications_pekerjaan where user_id = '".$id."'");
	}

	public function get_single_kandidat_pekerjaans($id) {
		return $query = $this->db->query("SELECT * from umb_applications_pekerjaan where pekerjaan_id = '".$id."'");
	}

	public function get_employer_kandidat_pekerjaans($user_id) {
		return $query = $this->db->query("SELECT * from umb_applications_pekerjaan where user_id = '".$user_id."'");
	}
	
	public function get_employer_pekerjaans($id) {
		return $query = $this->db->query("SELECT * from umb_pekerjaans where employer_id = '".$id."' order by pekerjaan_id desc");
	}

	public function get_user_applied_pekerjaans($id) {
		return $query = $this->db->query("SELECT j.*, a.* from umb_applications_pekerjaan as a, umb_pekerjaans as j where a.pekerjaan_id=j.pekerjaan_id and a.user_id = '".$id."'");
	}

	public function read_informasi_pekerjaan($id) {
		
		$condition = "pekerjaan_id =" . "'" . $id . "'";
		$this->db->select('*');
		$this->db->from('umb_pekerjaans');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	public function read_info_application_pekerjaan($id) {
		
		$condition = "application_id =" . "'" . $id . "'";
		$this->db->select('*');
		$this->db->from('umb_applications_pekerjaan');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	public function read_cms_pages($id) {
		
		$condition = "page_id =" . "'" . $id . "'";
		$this->db->select('*');
		$this->db->from('umb_pages_pekerjaan');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	public function lima_pekerjaans_terbaru() {
		$query = $this->db->query("SELECT * from umb_pekerjaans limit 5");
		return $query->result();
	}
	
	public function read_info_pekerjaan_melalui_url($url) {
		
		$condition = "url_pekerjaan =" . "'" . $url . "'";
		$this->db->select('*');
		$this->db->from('umb_pekerjaans');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function read_info_kategori_pekerjaan($id) {
		
		$condition = "kategori_id =" . "'" . $id . "'";
		$this->db->select('*');
		$this->db->from('umb_kategoris_pekerjaan');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function read_all_pekerjaans_by_type() {
		
		
		$this->db->query("SET SESSION sql_mode = ''");
		$condition = "type_pekerjaan !='' group by type_pekerjaan";
		$this->db->select('*');
		$this->db->from('umb_pekerjaans');
		$this->db->where($condition);
		$this->db->limit(1000);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function all_types_pekerjaan() {
		
		$this->db->query("SET SESSION sql_mode = ''");
		$query = $this->db->query("SELECT jt.*, j.* from umb_type_pekerjaan as jt, umb_pekerjaans as j where jt.type_url = j.type_url group by jt.type_pekerjaan_id");
		//$query = $this->db->query("SELECT jt.*, j.* from umb_type_pekerjaan as jt, umb_pekerjaans as j where jt.type_url = j.type_url");
		return $query->result();
	}
	
	public function read_all_pekerjaans_melalui_penunjukan() {
		
		$this->db->query("SET SESSION sql_mode = ''");
		$condition = "penunjukan_id !='' group by penunjukan_id";
		$this->db->select('*');
		$this->db->from('umb_pekerjaans');
		$this->db->where($condition);
		$this->db->limit(1000);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function check_apply_pekerjaan($pekerjaan_id,$user_id) {
		
		$condition = "pekerjaan_id='".$pekerjaan_id."' and user_id='".$user_id."'";
		$this->db->select('*');
		$this->db->from('umb_applications_pekerjaan');
		$this->db->where($condition);
		$this->db->limit(1);
		return $query = $this->db->get();
		// $query->result();
	}
	
	public function all_interview_pekerjaans(){
		$this->db->query("SET SESSION sql_mode = ''");
		$query = $this->db->query("SELECT j.*, jap.* FROM umb_pekerjaans as j, umb_applications_pekerjaan as jap where j.pekerjaan_id = jap.pekerjaan_id group by j.pekerjaan_id");
		//$query = $this->db->query("SELECT j.*, jap.* FROM umb_pekerjaans as j, umb_applications_pekerjaan as jap where j.pekerjaan_id = jap.pekerjaan_id");
		return $query->result();
	}
	
	public function read_informasi_type_pekerjaan($id) {
		
		$condition = "type_pekerjaan_id =" . "'" . $id . "'";
		$this->db->select('*');
		$this->db->from('umb_type_pekerjaan');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function all_interviews() {
		return $this->db->get("umb_interviews_pekerjaan");
	}
	
	
	public function add($data){
		$this->db->insert('umb_pekerjaans', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function add_resume($data){
		$this->db->insert('umb_applications_pekerjaan', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function all_pekerjaans() {
		$query = $this->db->query("SELECT * from umb_pekerjaans");
		return $query->result();
	}
	
	public function all_active_pekerjaans() {
		$query = $this->db->query("SELECT * from umb_pekerjaans where status='1'");
		return $query->num_rows();
	}

	public function available_applications_pekerjaan($pekerjaan_id) {
		$query = $this->db->query("SELECT * from umb_applications_pekerjaan where pekerjaan_id='".$pekerjaan_id."'");
		return $query->num_rows();
	}

	public function available_applications_employer($user_id) {
		$query = $this->db->query("SELECT * from umb_applications_pekerjaan where user_id='".$user_id."'");
		return $query->num_rows();
	}
	
	public function delete_record($id){
		$this->db->where('pekerjaan_id', $id);
		$this->db->delete('umb_pekerjaans');
		
	}
	
	public function delete_record_employer($id){
		$this->db->where('user_id', $id);
		$this->db->delete('umb_users');
		
	}
	
	public function delete_record_application($id){
		$this->db->where('application_id', $id);
		$this->db->delete('umb_applications_pekerjaan');
		
	}
	
	public function delete_record_interview($id){
		$this->db->where('pekerjaan_interview_id', $id);
		$this->db->delete('umb_interviews_pekerjaan');
		
	}
	
	public function ajax_informasi_pekerjaan_user($id) {
		
		$condition = "pekerjaan_id =" . "'" . $id . "'";
		$this->db->select('*');
		$this->db->from('umb_applications_pekerjaan');
		$this->db->where($condition);
		$this->db->limit(100);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function add_interview($data){
		$this->db->insert('umb_interviews_pekerjaan', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function update_record($data, $id){
		$this->db->where('pekerjaan_id', $id);
		if( $this->db->update('umb_pekerjaans',$data)) {
			return true;
		} else {
			return false;
		}		
	}

	public function update_record_page($data, $id){
		$this->db->where('page_id', $id);
		if( $this->db->update('umb_pages_pekerjaan',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function update_applicant_status($data, $id){
		$this->db->where('application_id', $id);
		if( $this->db->update('umb_applications_pekerjaan',$data)) {
			return true;
		} else {
			return false;
		}		
	}
}
?>