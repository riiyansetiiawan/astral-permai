<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
	public function __construct() {
		
		parent::__construct();    
		$ci =& get_instance();
		$ci->load->helper('language');
		$this->load->library('session');
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('url_helper');
		$this->load->helper('html');
		$this->load->database();
		$this->load->helper('security');
		$this->load->library('form_validation');
		$this->load->model("Umb_model");
		$this->load->model("Perusahaan_model");
		
		$system = $this->read_setting_info(1);
		
		$session = $this->session->userdata('username');
		if(empty($session)){
			$default_timezone = $system[0]->system_timezone;
			date_default_timezone_set($default_timezone);
		} else {
			$user_info = $this->Umb_model->read_user_info($session['user_id']);
			$info_perusahaan = $this->Perusahaan_model->read_informasi_perusahaan($user_info[0]->perusahaan_id);
			if(!is_null($info_perusahaan)){
				$default_timezone = $info_perusahaan[0]->default_timezone;
				if($default_timezone == ''){
					$default_timezone = $system[0]->system_timezone;
				} else {
					$default_timezone = $default_timezone;
				}
				date_default_timezone_set($default_timezone);
			} else {
				$default_timezone = $system[0]->system_timezone;
				date_default_timezone_set($default_timezone);	
			}
		}
		
		$siteLang = $ci->session->userdata('site_lang');
		if($system[0]->default_language==''){
			$default_language = 'english';
		} else {
			$default_language = $system[0]->default_language;
		}
		if ($siteLang) {
			$ci->lang->load('hrastral',$siteLang);
		} else {
			$ci->lang->load('hrastral',$default_language);
		} 
	}
	
	public function read_setting_info($id) {
		
		$condition = "setting_id =" . "'" . $id . "'";
		$this->db->select('*');
		$this->db->from('umb_system_setting');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
}
?>