<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Application extends MY_Controller{

	public function output($Return=array()){
		
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		exit(json_encode($Return));
	}
	
	public function __construct(){
		parent::__construct();
		$this->load->model('Perusahaan_model');
		$this->load->model('Umb_model');
		$this->load->library('unzip');
	}

	public function update() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$user = $this->Umb_model->read_user_info($session['user_id']);
		$data['title'] = $this->lang->line('umb_hr_update_application');
		$data['breadcrumbs'] = $this->lang->line('umb_hr_update_application');
		$data['path_url'] = 'update_app';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if($user[0]->user_role_id==1) {
			$data['subview'] = $this->load->view("admin/application/update", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
		} else {
			redirect('admin/dashboard');
		}
	}
	
	function file_upload(){
		$local_file = 'http://localhost/hrastral/uploads/csv/';
		$config['upload_path'] = $local_file;
		$config['allowed_types'] = 'zip';
		$config['max_size'] = '';
		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload())
		{
			$Return['error'] = "Doh! I couldn't open ==";
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			$zip = new ZipArchive;
			$file = $data['upload_data']['full_path'];
			chmod($file,0777);
			if ($zip->open($file) === TRUE) {
				$zip->extractTo($local_file);
				$zip->close();
				$Return['result'] =  "WOOT! extracted -- ll";
			} else {
				$Return['error'] = "Doh! I couldn't open 22==";
			}
			$Return['result'] =  "WOOT! extracted -- ll";
		}
	}
	
	public function update_app() {

		if($this->input->post('etype')=='update_application') {
			$session = $this->session->userdata('username');
			if(empty($session)){ 
				redirect('admin/');
			}
			$Return = array('result'=>'', 'error'=>'');
			
			$config['upload_path']          = '../../uploads/csv/';
			$this->load->library('upload', $config);
			if($_FILES['file_zip']['size'] == 0) {
				$Return['error'] = $this->lang->line('umb_hr_error_zip_installation');
			} else {
				$allowed =  array('zip');
				$filename = $_FILES['file_zip']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				if(in_array($ext,$allowed)){
					$zip = new ZipArchive;
					$remote_file_url = 'http://localhost/hrastral/ziptest.zip';
					$local_file = 'http://localhost/hrastral/uploads/csv/';
					if ($zip->open($remote_file_url) === TRUE) {
						$zip->extractTo($local_file);
						$zip->close();
						$Return['result'] =  "WOOT! $remote_file_url extracted to $local_file";
					} else {
						$Return['error'] = "Doh! I couldn't open $remote_file_url";
					}
				} else {
					$Return['error'] = $this->lang->line('umb_error_attatchment_type_zip');
				}
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$this->output($Return);
		}
	}
} 
?>
