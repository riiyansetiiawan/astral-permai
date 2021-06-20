<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Karyawans_terakhir_login extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		
		$this->load->model("Karyawans_model");
		$this->load->model("Umb_model");
		$this->load->model("Penunjukan_model");
		$this->load->model("Department_model");
	}
	
	
	public function output($Return=array()){
		
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		
		exit(json_encode($Return));
	}
	
	public function index() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('left_karyawans_terakhir_login').' | '.$this->Umb_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('left_karyawans_terakhir_login');
		$data['get_all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$data['path_url'] = 'karyawans_terakhir_login';
		$role_resources_ids = $this->Umb_model->user_role_resource();

		$laporans_to = get_data_laporans_team($session['user_id']);
		if(in_array('22',$role_resources_ids) || $laporans_to > 0) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/terakhir_login/list_terakhir_login", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}		  
	}

	public function list_terakhir_login() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/terakhir_login/list_terakhir_login", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		$laporans_to = get_data_laporans_team($session['user_id']);
		
		if($this->input->get("ihr")=='true'){
			if($this->input->get("perusahaan_id")==0 && $this->input->get("location_id")==0 && $this->input->get("department_id")==0 && $this->input->get("penunjukan_id")==0){
				$karyawan = $this->Karyawans_model->get_karyawans();
				
			} else if($this->input->get("perusahaan_id")!=0 && $this->input->get("location_id")==0 && $this->input->get("department_id")==0 && $this->input->get("penunjukan_id")==0){
				$karyawan = $this->Karyawans_model->get_perusahaan_flt_karyawans($this->input->get("perusahaan_id"));
			} else if($this->input->get("perusahaan_id")!=0 && $this->input->get("location_id")!=0 && $this->input->get("department_id")==0 && $this->input->get("penunjukan_id")==0){
				$karyawan = $this->Karyawans_model->get_perusahaan_flt_location_karyawans($this->input->get("perusahaan_id"),$this->input->get("location_id"));
				
			} else if($this->input->get("perusahaan_id")!=0 && $this->input->get("location_id")!=0 && $this->input->get("department_id")!=0 && $this->input->get("penunjukan_id")==0){
				$karyawan = $this->Karyawans_model->get_perusahaan_flt_location_department_karyawans($this->input->get("perusahaan_id"),$this->input->get("location_id"),$this->input->get("department_id"));
				
			} else if($this->input->get("perusahaan_id")!=0 && $this->input->get("location_id")!=0 && $this->input->get("department_id")!=0 && $this->input->get("penunjukan_id")!=0){
				$karyawan = $this->Karyawans_model->get_perusahaan_flt_location_department_penunjukan_karyawans($this->input->get("perusahaan_id"),$this->input->get("location_id"),$this->input->get("department_id"),$this->input->get("penunjukan_id"));
			}
		} else {
			$user_info = $this->Umb_model->read_user_info($session['user_id']);
			if($user_info[0]->user_role_id==1) {
				$karyawan = $this->Karyawans_model->get_karyawans();
			} else if($laporans_to > 0) {
				$karyawan = $this->Karyawans_model->get_karyawans_team_saya($session['user_id']);
			} else {
				$karyawan = $this->Karyawans_model->get_karyawans_untuk_lainnya($user_info[0]->perusahaan_id);
			}
			
		}
		$role_resources_ids = $this->Umb_model->user_role_resource();
		
		$data = array();
		
		foreach($karyawan->result() as $r) {

			if($r->tanggal_terakhir_login==''){
				$edate = '-';
				$etime = '-';
			} else {
				$edate = $this->Umb_model->set_date_format($r->tanggal_terakhir_login);
				$terakhir_login =  new DateTime($r->tanggal_terakhir_login);
				$etime = $terakhir_login->format('h:i a');
			}
			//$role_resources_ids = $this->Umb_model->user_role_resource();
			if(in_array('202',$role_resources_ids)) {
				$link_krywn = '<a href="'.site_url().'admin/karyawans/detail/'.$r->user_id.'" data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_view').'">'.$r->karyawan_id.'</a>';
			} else {
				$link_krywn = $r->karyawan_id;
			}

			$full_name = $r->first_name.' '.$r->last_name;

			$role = $this->Umb_model->read_user_role_info($r->user_role_id);
			if(!is_null($role)){
				$role_name = $role[0]->role_name;
			} else {
				$role_name = '--';	
			}

			$perusahaan = $this->Umb_model->read_info_perusahaan($r->perusahaan_id);
			if(!is_null($perusahaan)){
				$prshn_nama = $perusahaan[0]->name;
			} else {
				$prshn_nama = '--';	
			}

			if($r->is_active==0): 
				$status = '<span class="badge bg-red">'.$this->lang->line('umb_karyawans_inactive').'</span>';
			elseif($r->is_active==1): 
				$status = '<span class="badge bg-green">'.$this->lang->line('umb_karyawans_active').'</span>';
			endif;

			$penunjukan = $this->Penunjukan_model->read_informasi_penunjukan($r->penunjukan_id);
			if(!is_null($penunjukan)){
				$nama_penunjukan = $penunjukan[0]->nama_penunjukan;
			} else {
				$nama_penunjukan = '--';	
			}

			$department = $this->Department_model->read_informasi_department($r->department_id);
			if(!is_null($department)){
				$nama_department = $department[0]->nama_department;
			} else {
				$nama_department = '--';	
			}
			$department_penunjukan = $nama_penunjukan.' ('.$nama_department.')';
			$nama_karyawan = $full_name.'<br><small class="text-muted"><i>'.$department_penunjukan.'<i></i></i></small><br><small class="text-muted"><i>'.$this->lang->line('umb_karyawans_id').': '.$link_krywn.'<i></i></i></small>';

			$eterakhir_login = $edate.' '.$etime;
			$data[] = array(
				$nama_karyawan,
				$r->username,
				$prshn_nama,
				$eterakhir_login,
				$role_name,
				$status
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $karyawan->num_rows(),
			"recordsFiltered" => $karyawan->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}
}
