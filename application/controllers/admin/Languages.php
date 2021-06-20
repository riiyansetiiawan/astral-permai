<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Languages extends MY_Controller {


	public function output($Return=array()){
		
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		
		exit(json_encode($Return));
	}
	
	public function __construct() {
		parent::__construct();

		$this->load->model('Umb_model');
		$this->load->model('Karyawans_model');
		$this->load->model('Keuangan_model');
		$this->load->model('Biaya_model');
		$this->load->model('Languages_model');
	}

	public function index() {

		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		$system = $this->Umb_model->read_setting_info(1);
		if($system[0]->module_language!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('umb_languages').' | '.$this->Umb_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('umb_languages');
		$data['path_url'] = 'languages';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('89',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/languages/list_languages", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}

	public function list_languages() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		if(!empty($session)){ 
			$this->load->view("admin/languages/list_languages", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$language = $this->Languages_model->get_languages();
		
		$data = array();
		
		foreach($language->result() as $r) {

			$site_lang = $this->load->helper('language');
			$wz_lang = $site_lang->session->userdata('site_lang');
			$flag = '<img src="'.base_url().'uploads/languages_flag/'.$r->language_flag.'">';
			$name_flg = $flag.' '.$r->language_name;
			
			if($r->language_id=='1' ){
				$del = '';
				$success = $this->lang->line('umb_selected');
			} else {
				
				if($r->is_active==1){
					$success = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_karyawans_inactive').'"><button type="button" class="btn icon-btn btn-sm btn-success active-lang mr-1" data-language_id="'. $r->language_id . '" data-is_active="0"><span class="fa fa-check-circle"></span></button></span>';
				} else {
					$success = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_karyawans_active').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary active-lang mr-1" data-language_id="'. $r->language_id . '" data-is_active="1"><span class="fa fa-times-circle"></span></button></span>';
				}
				$del = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->language_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			}  			
			$data[] = array(
				$del,
				$name_flg,
				$r->language_code,
				$success,
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $language->num_rows(),
			"recordsFiltered" => $language->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function active_language() {

		if($this->input->get('language_id')) {
			
			$id = $this->input->get('language_id');
			$is_active = $this->input->get('is_active');

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();

			if($is_active == 1) {
				$data = array(
					'is_active' => '1'
				);
				$msg = $this->lang->line('umb_sukses_lang_activated');
			} else {
				$data = array(
					'is_active' => '0'
				);
				$msg = $this->lang->line('umb_sukses_lang_deactivated');
			}

			$result = $this->Languages_model->active_lang_record($data,$id);		

			if ($result == TRUE) {
				$Return['result'] = $msg;
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function add_language() {

		if($this->input->post('add_type')=='add_language') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');

			if($this->input->post('language_name')==='') {
				$Return['error'] = $this->lang->line('umb_error_lang_name');
			} else if($this->input->post('language_code')==='') {
				$Return['error'] = $this->lang->line('umb_error_lang_code');
			}

			else if($_FILES['language_flag']['size'] == 0) {
				$Return['error'] = $this->lang->line('umb_error_lang_flag');
			} else {
				if(is_uploaded_file($_FILES['language_flag']['tmp_name'])) {

					$allowed =  array('png','jpg','jpeg','gif');
					$filename = $_FILES['language_flag']['name'];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);

					if(in_array($ext,$allowed)){
						$tmp_name = $_FILES["language_flag"]["tmp_name"];
						$language_flag = "uploads/languages_flag/";

						$lname = basename($_FILES["language_flag"]["name"]);
						$newfilename = 'language_flag_'.round(microtime(true)).'.'.$ext;
						move_uploaded_file($tmp_name, $language_flag.$newfilename);
						$fname = $newfilename;
					} else {
						$Return['error'] = $this->lang->line('umb_error_flag_allow_files');
					}
				}
			}
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			if($Return['error']!=''){
				$this->output($Return);
			}
			//	$directoryName = 'images';
			$new_dir 	= 'application/language/'.$this->input->post('language_code');
			$directoryName 	= $new_dir.'/hrastral_lang.php';
			$directoryName2 	= $new_dir.'/index.html';
			if(!is_dir($directoryName)){
				mkdir(dirname($directoryName), 0777, true);
			}
			$fp = fopen('hrastral_lang.php','w');
			fwrite($fp, 'data to be written');
			fclose($fp);
			$fp1 = fopen('index.html','w');
			fwrite($fp1, 'data to be written');
			fclose($fp1);

			$srcfile 	= 'application/language/english/hrastral_lang.php';
			$srcfile2 	= 'application/language/english/index.html';
			copy($srcfile2, $directoryName2);
			copy($srcfile, $directoryName);
			$data = array(
				'language_name' => $this->input->post('language_name'),
				'language_code' => $this->input->post('language_code'),
				'language_flag' => $fname,
				'is_active' => 1,
				'created_at' => date('d-m-Y h:i:s')
			);
			$result = $this->Languages_model->add($data);
			if ($result == TRUE) {
				//$Return['csrf_hash'] = $this->security->get_csrf_hash();
				$Return['result'] = $this->lang->line('umb_sukses_lang_ditambahkan');
			} else {
				//$Return['csrf_hash'] = $this->security->get_csrf_hash();
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			//$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$this->output($Return);
			exit;
		}
	}

	public function delete_language() {
		
		if($this->input->post('is_ajax')=='2') {
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$lang = $this->Languages_model->read_informasi_language($id);
			$new_dir 	= 'application/language/'.$lang[0]->language_code.'/';
			
			$files = glob($new_dir.'*');
			foreach($files as $file){
				if(is_file($file))
					unlink($file);
			}
			rmdir($new_dir);

			$language_flag = "uploads/languages_flag/";
			$filename = $language_flag.$lang[0]->language_flag;
			unlink($filename);
			$result = $this->Languages_model->delete_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_sukses_lang_dihapus');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}
} 
?>