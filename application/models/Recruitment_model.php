<?php

class Recruitment_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
	public function read_info_employer($id) {
		
		$sql = 'SELECT * FROM umb_users WHERE user_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
		
	}

	public function get_all_employers() {
		$query = $this->db->query("SELECT * FROM umb_users where is_active='1'");
		return $query->result();
	}
	
	public function get_all_pekerjaans() {
		$query = $this->db->query("SELECT * FROM umb_pekerjaans where status='1'");
		return $query->num_rows();
	}
	
	public function get_desc_all_pekerjaans() {
		
		$query = $this->db->query("SELECT * FROM umb_pekerjaans where status='1' order by pekerjaan_id desc");
		return $query->result();
	}
	
	public function get_desc_all_pekerjaans_terakhir() {
		
		$query = $this->db->query("SELECT * FROM umb_pekerjaans where status='1' order by pekerjaan_id desc limit 5");
		return $query->result();
	}
	
	public function get_desc_featured_pekerjaans_terakhir() {
		
		$query = $this->db->query("SELECT * FROM umb_pekerjaans where is_featured = '1' and status='1' order by pekerjaan_id desc limit 5");
		return $query->result();
	}
	public function all_kategoris_pekerjaan() {
		//$query = $this->db->query("SELECT jc.*, j.* FROM umb_kategoris_pekerjaan as jc, umb_pekerjaans as j where jc.kategori_id = j.kategori_id group by jc.kategori_id");
		$this->db->query("SET SESSION sql_mode = ''");
		$query = $this->db->query("SELECT * FROM umb_kategoris_pekerjaan");
		return $query->result();
	}
	
	public function first_kategoris_pekerjaan() {
		$this->db->query("SET SESSION sql_mode = ''");
		$query = $this->db->query("SELECT jc.*, j.* FROM umb_kategoris_pekerjaan as jc, umb_pekerjaans as j where jc.kategori_id = j.kategori_id group by jc.kategori_id limit 6");
		 //$query = $this->db->query("SELECT jc.*, j.* FROM umb_kategoris_pekerjaan as jc, umb_pekerjaans as j where jc.kategori_id = j.kategori_id limit 6");
		return $query->result();
	}
	
	function timeAgo($timestamp)  {  
		$time_ago = strtotime($timestamp);  
		$current_time = time();  
		$time_difference = $current_time - $time_ago;  
		$seconds = $time_difference;  
		$minutes = round($seconds / 60 );            
		$hours = round($seconds / 3600);         
		$days = round($seconds / 86400);       
		$weeks = round($seconds / 604800);         
		$months = round($seconds / 2629440);    
		$years  = round($seconds / 31553280);  
		if($seconds <= 60) {  
			return "Just Now";  
		} else if($minutes <=60)  {  
			if($minutes==1) {  
				return "one minute ago";  
			} else {
				return "$minutes minutes ago";  
			}  
		} else if($hours <=24)  {  
			if($hours==1) {  
				return "an hour ago";  
			} else  {  
				return "$hours hrs ago";  
			}  
		} else if($days <= 7) {  
			if($days==1)  {  
				return "yesterday";  
			} else {  
				return "$days days ago";  
			}  
		} else if($weeks <= 4.3) {  
			if($weeks==1) {  
				return "a week ago";  
			} else  {  
				return "$weeks weeks ago";  
			}  
		} else if($months <=12) {  
			if($months==1) {  
				return "a month ago";  
			} else {  
				return "$months months ago";  
			}  
		} else {  
			if($years==1)  {  
				return "one year ago";  
			}  
			else {  
				return "$years years ago";  
			}  
		}  
	}

	public function read_info_kategori($id) {

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

	public function read_info_main_page($url) {

		$condition = "page_url =" . "'" . $url . "'";
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

	public function record_count_pekerjaan() {
		return $this->db->count_all("umb_pekerjaans");
	}

	public function record_count_search_pekerjaan($search) {
		$query = $this->db->query("SELECT * from umb_pekerjaans where title_pekerjaan like '%".$search."%' and status='1'");
		return $query->num_rows();
	}

	public function record_count_kategori_pekerjaan($find) {
		$csql = "SELECT * FROM umb_kategoris_pekerjaan WHERE kategori_url = '".$find."'";
		$cquery = $this->db->query($csql);
		$kategori_info = $cquery->result();
		$query = $this->db->query("SELECT * from umb_pekerjaans where kategori_id = '".$kategori_info[0]->kategori_id."' and status='1'");
		return $query->num_rows();
	}

	public function record_count_type_pekerjaan($find) {
		$csql = "SELECT * FROM umb_type_pekerjaan WHERE type_url = '".$find."'";
		$cquery = $this->db->query($csql);
		$type_info = $cquery->result();
		$query = $this->db->query("SELECT * from umb_pekerjaans where type_pekerjaan = '".$type_info[0]->type_pekerjaan_id."' and status='1'");
		return $query->num_rows();
	}

	public function fetch_all_kategori_pekerjaans($limit, $start, $find) {

		$csql = "SELECT * FROM umb_kategoris_pekerjaan WHERE kategori_url = '".$find."'";
		$cquery = $this->db->query($csql);
		$kategori_info = $cquery->result();

		$condition = "status ='1' and kategori_id = '".$kategori_info[0]->kategori_id."' order by pekerjaan_id desc";
		$this->db->select('*');
		$this->db->from('umb_pekerjaans');
		$this->db->where($condition);
		$this->db->limit($limit, $start);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return false;
	}

	public function fetch_all_type_pekerjaans($limit, $start, $find) {

		$csql = "SELECT * FROM umb_type_pekerjaan WHERE type_url = '".$find."'";
		$cquery = $this->db->query($csql);
		$type_info = $cquery->result();
		$condition = "status ='1' and type_pekerjaan = '".$type_info[0]->type_pekerjaan_id."' order by pekerjaan_id desc";
		$this->db->select('*');
		$this->db->from('umb_pekerjaans');
		$this->db->where($condition);
		$this->db->limit($limit, $start);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return false;
	}

	public function search_fetch_all_pekerjaans($limit, $start, $search) {

		$condition = "title_pekerjaan like '%".$search."%' and status ='1' order by pekerjaan_id desc";
		$this->db->select('*');
		$this->db->from('umb_pekerjaans');
		$this->db->where($condition);
		$this->db->limit($limit, $start);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return false;
	}

	public function fetch_all_pekerjaans($limit, $start) {

		$condition = "status ='1' order by pekerjaan_id desc";
		$this->db->select('*');
		$this->db->from('umb_pekerjaans');
		$this->db->where($condition);
		$this->db->limit($limit, $start);
		$query = $this->db->get();

		return $query->result();
       // return false;
	}

	public function read_info_sub_page($id) {

		$condition = "subpages_id =" . "'" . $id . "'";
		$this->db->select('*');
		$this->db->from('umb_subpages_recruitment');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	public function check_apply_pekerjaan_wlog($pekerjaan_id,$user_id) {

		$sql = 'SELECT * from umb_applications_pekerjaan where pekerjaan_id = ? and email = ?';
		$binds = array($pekerjaan_id,$user_id);
		$query = $this->db->query($sql, $binds);

		return $query;
	}

	public function check_applications_pekerjaans($pekerjaan_id) {
		$query = $this->db->query("SELECT * from umb_applications_pekerjaan where pekerjaan_id = '".$pekerjaan_id."'");
		return $query->num_rows();
	}

	public function get_applied_kandidats_pekerjaans($url) {
		$result = $this->Post_pekerjaan_model->read_info_pekerjaan_melalui_url($url);
		return $query = $this->db->query("SELECT * from umb_applications_pekerjaan where pekerjaan_id = '".$result[0]->pekerjaan_id."'");
	}
	
	public function get_employers() {
		$query = $this->db->query("SELECT * FROM umb_users");
		return $query;
	}
}