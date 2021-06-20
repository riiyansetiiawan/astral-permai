<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {
	
	public function __construct() {

		parent::__construct();
		
		$this->load->model('Login_model');
		$this->load->model('Penunjukan_model');
		$this->load->model('Department_model');
		$this->load->model('Karyawans_model');
		$this->load->model('Umb_model');
		$this->load->model('Eumb_model');
		$this->load->model('Biaya_model');
		$this->load->model('Timesheet_model');
		$this->load->model('Perjalanan_model');
		$this->load->model('Training_model');
		$this->load->model('Project_model');
		$this->load->model('Post_pekerjaan_model');
		$this->load->model('Tujuan_tracking_model');
		$this->load->model('Events_model');
		$this->load->model('Meetings_model');
		$this->load->model('Pengumuman_model');
		$this->load->model('Clients_model');
		$this->load->model("Recruitment_model");
		$this->load->model('Tickets_model');
		$this->load->model('Assets_model');
		$this->load->model('Awards_model');
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
		$system = $this->Umb_model->read_setting_info(1);
		if($system[0]->module_projects_tugass=='true'){
			
			$user = $this->Umb_model->read_user_info($session['user_id']);
			
			$penunjukan = $this->Penunjukan_model->read_informasi_penunjukan($user[0]->penunjukan_id);
			if(!is_null($penunjukan)){
				$tunjuk_krywn = $penunjukan[0]->nama_penunjukan;
			} else {
				$tunjuk_krywn = '--';
			}
			$department = $this->Department_model->read_informasi_department($user[0]->department_id);
			if(!is_null($department)){
				$dep_krywn = $department[0]->nama_department;
			} else {
				$dep_krywn = '--';
			}
			$data = array(
				'title' => $this->lang->line('dashboard_title').' | '.$this->Umb_model->site_title(),
				'path_url' => 'dashboard',
				'first_name' => $user[0]->first_name,
				'last_name' => $user[0]->last_name,
				'karyawan_id' => $user[0]->karyawan_id,
				'username' => $user[0]->username,
				'email' => $user[0]->email,
				'nama_penunjukan' => $tunjuk_krywn,
				'nama_department' => $dep_krywn,
				'tanggal_lahir' => $user[0]->tanggal_lahir,
				'tanggal_bergabung' => $user[0]->tanggal_bergabung,
				'no_kontak' => $user[0]->no_kontak,
				'empat_karyawan_terakhir' => $this->Umb_model->empat_karyawan_terakhir(),
				'get_history_pembayaran_terakhir' => $this->Umb_model->get_history_pembayaran_terakhir(),
				'all_liburan' => $this->Timesheet_model->get_calendar_liburan(),
				'all_calendar_permintaan_cutii' => $this->Timesheet_model->get_calendar_permintaan_cutii(),
				'all_upcoming_ulangtahun' => $this->Umb_model->karyawans_upcoming_ulangtahun(),
				'all_permintaan_perjalanan' => $this->Perjalanan_model->get_perjalanan(),
				'all_training' => $this->Training_model->get_training(),
				'all_projects' => $this->Project_model->get_projects(),
				'all_tugass' => $this->Timesheet_model->get_tugass(),
				'all_tujuans' => $this->Tujuan_tracking_model->get_tujuan_tracking(),
				'all_events' => $this->Events_model->get_events(),
				'all_meetings' => $this->Meetings_model->get_meetings(),
				'all_pekerjaansx' => $this->Post_pekerjaan_model->lima_pekerjaans_terbaru(),
				'all_pekerjaans' => $this->Recruitment_model->get_desc_all_pekerjaans_terakhir()
			);
			$data['subview'] = $this->load->view('admin/dashboard/index', $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
		} else {

			$user = $this->Umb_model->read_user_info($session['user_id']);
			$penunjukan = $this->Penunjukan_model->read_informasi_penunjukan($user[0]->penunjukan_id);
			$department = $this->Department_model->read_informasi_department($user[0]->department_id);
			$data = array(
				'title' => $this->Umb_model->site_title(),
				'path_url' => 'dashboard',
				'first_name' => $user[0]->first_name,
				'last_name' => $user[0]->last_name,
				'karyawan_id' => $user[0]->karyawan_id,
				'username' => $user[0]->username,
				'email' => $user[0]->email,
				'nama_penunjukan' => $penunjukan[0]->nama_penunjukan,
				'nama_department' => $department[0]->nama_department,
				'tanggal_lahir' => $user[0]->tanggal_lahir,
				'tanggal_bergabung' => $user[0]->tanggal_bergabung,
				'no_kontak' => $user[0]->no_kontak,
				'empat_karyawan_terakhir' => $this->Umb_model->empat_karyawan_terakhir(),
				'get_history_pembayaran_terakhir' => $this->Umb_model->get_history_pembayaran_terakhir(),
				'all_liburan' => $this->Timesheet_model->get_calendar_liburan(),
				'all_calendar_permintaan_cutii' => $this->Timesheet_model->get_calendar_permintaan_cutii(),
				'all_upcoming_ulangtahun' => $this->Umb_model->karyawans_upcoming_ulangtahun(),
				'all_permintaan_perjalanan' => $this->Perjalanan_model->get_perjalanan(),
				'all_training' => $this->Training_model->get_training(),
				'all_projects' => $this->Project_model->get_projects(),
				'all_tugass' => $this->Timesheet_model->get_tugass(),
				'all_tujuans' => $this->Tujuan_tracking_model->get_tujuan_tracking(),
				'all_events' => $this->Events_model->get_events(),
				'all_meetings' => $this->Meetings_model->get_meetings(),
				'all_pekerjaansx' => $this->Post_pekerjaan_model->all_pekerjaans(),
				'all_pekerjaans' => $this->Recruitment_model->get_desc_all_pekerjaans_terakhir()
			);
			$data['subview'] = $this->load->view('admin/dashboard/index', $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
		}
	}
	
	public function status_kerja_karyawan() {
		
		$Return = array('absent'=>'', 'bekerja'=>'','absent_label'=>'', 'bekerja_label'=>'');
		
		$current_month = date('Y-m-d');
		
		$query = $this->Umb_model->all_status_karyawans();
		$total = $query->num_rows();
		
		$bekerja = $this->Umb_model->current_hari_bulan_kehadiran($current_month);
		
		$karyawan_w = $bekerja / $total * 100;
		$abs = $total - $bekerja;
		$Return['absent'] = $abs;
		$Return['absent_label'] = $this->lang->line('umb_absent');
		$Return['bekerja_label'] = $this->lang->line('umb_krywn_bekerja');
		$Return['working'] = $bekerja;
		$this->output($Return);
		exit;
	}
	
	public function status_karyawan_cuti(){
		
		$Return = array('accepted'=>'', 'accepted_count'=>'','pending'=>'', 'pending_count'=>'','rejected'=>'', 'rejected_count'=>'');
		
		$Return['accepted'] = $this->lang->line('umb_approved');
		$Return['accepted_count'] = accepted_permintaan_cuti();
		$Return['pending'] = $this->lang->line('umb_pending');
		$Return['pending_count'] = pending_permintaan_cuti();
		$Return['rejected'] = $this->lang->line('umb_rejected');
		$Return['rejected_count'] = rejected_permintaan_cuti();
		$this->output($Return);
		exit;
	}

	public function karyawan_department() {
		
		$Return = array('chart_data'=>'', 'c_name'=>'', 'd_rows'=>'','c_color'=>'');
		$c_name = array();
		$c_am = array();	
		$c_color = array('#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b');
		$someArray = array();
		$j=0;
		foreach($this->Department_model->all_departments() as $department) {

			$condition = "department_id =" . "'" . $department->department_id . "'";
			$this->db->select('*');
			$this->db->from('umb_karyawans');
			$this->db->where($condition);
			//$this->db->group_by('location_id');
			$query = $this->db->get();
			$checke  = $query->result();
			// check if department available
			if ($query->num_rows() > 0) {
				$row = $query->num_rows();
				$d_rows [] = $row;	
				$c_name[] = htmlspecialchars_decode($department->nama_department);

				$someArray[] = array(
					'label'   => htmlspecialchars_decode($department->nama_department),
					'value' => $row,
					'bgcolor' => $c_color[$j]
				);
				$j++;
			}
		}
		$Return['c_name'] = $c_name;
		$Return['d_rows'] = $d_rows;
		$Return['chart_data'] = $someArray;
		$this->output($Return);
		exit;
	}
	

	public function karyawan_penunjukan() {
		
		$Return = array('chart_data'=>'', 'c_name'=>'', 'd_rows'=>'','c_color'=>'');
		$c_name = array();
		$c_am = array();	
		$c_color = array('#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b');
		$someArray = array();
		$j=0;
		foreach($this->Penunjukan_model->all_penunjukans() as $penunjukan) {

			$condition = "penunjukan_id =" . "'" . $penunjukan->penunjukan_id . "'";
			$this->db->select('*');
			$this->db->from('umb_karyawans');
			$this->db->where($condition);
			//$this->db->group_by('location_id');
			$query = $this->db->get();
			$checke  = $query->result();
			// check if department available
			if ($query->num_rows() > 0) {
				$row = $query->num_rows();
				$d_rows [] = $row;	
				$c_name[] = htmlspecialchars_decode($penunjukan->nama_penunjukan);
				$someArray[] = array(
					'label'   => htmlspecialchars_decode($penunjukan->nama_penunjukan),
					'value' => $row,
					'bgcolor' => $c_color[$j]
				);
				$j++;
			}
		}
		$Return['c_name'] = $c_name;
		$Return['d_rows'] = $row;
		$Return['chart_data'] = $someArray;
		$this->output($Return);
		exit;
	}
	
	public function location_karyawan(){
		
		$Return = array('chart_data'=>'', 'c_name'=>'', 'd_rows'=>'','c_color'=>'');
		$c_name = array();
		$c_am = array();	
		$c_color = array('#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b');
		$someArray = array();
		$j=0;
		foreach($this->Umb_model->all_locations() as $location) {

			$condition = "location_id =" . "'" . $location->location_id . "'";
			$this->db->select('*');
			$this->db->from('umb_karyawans');
			$this->db->where($condition);
			$query = $this->db->get();
			$checke  = $query->result();
			
			if ($query->num_rows() > 0) {
				$row = $query->num_rows();
				$d_rows [] = $row;	
				$c_name[] = htmlspecialchars_decode($location->nama_location);

				$someArray[] = array(
					'label'   => htmlspecialchars_decode($location->nama_location),
					'value' => $row,
					'bgcolor' => $c_color[$j]
				);
				$j++;
			}
		}
		$Return['c_name'] = $c_name;
		$Return['d_rows'] = $d_rows;
		$Return['chart_data'] = $someArray;
		$this->output($Return);
		exit;
	}
	
	public function karyawan_perusahaan() {
		
		$Return = array('chart_data'=>'', 'c_name'=>'', 'd_rows'=>'','c_color'=>'');
		$c_name = array();
		$c_am = array();	
		$c_color = array('#975df3','#001f3f','#39cccc','#3c8dbc','#006400','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b');
		$someArray = array();
		$j=0;
		foreach($this->Umb_model->dash_all_perusahaans() as $eperusahaan) {

			$condition = "perusahaan_id =" . "'" . $eperusahaan->perusahaan_id . "'";
			$this->db->select('*');
			$this->db->from('umb_karyawans');
			$this->db->where($condition);
			$query = $this->db->get();
			$checke  = $query->result();
			if ($query->num_rows() > 0) {
				$row = $query->num_rows();
				$d_rows [] = $row;	
				$c_name[] = htmlspecialchars_decode($eperusahaan->name);

				$someArray[] = array(
					'label'   => htmlspecialchars_decode($eperusahaan->name),
					'value' => $row,
					'bgcolor' => $c_color[$j]
				);
				$j++;
			}
		}
		$Return['c_name'] = $c_name;
		$Return['d_rows'] = $d_rows;
		$Return['chart_data'] = $someArray;
		$this->output($Return);
		exit;
	}

	public function hrastral_roles() {
		
		$Return = array('chart_data'=>'', 'c_name'=>'', 'd_rows'=>'','c_color'=>'');
		$c_name = array();
		$c_am = array();	
		$c_color = array('#66456e','#b26fc2','#a98852','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e');
		$someArray = array();
		$j=0;
		foreach(hrastral_roles() as $hr_roles) { 

			$condition = "user_role_id =" . "'" . $hr_roles->role_id . "'";
			$this->db->select('*');
			$this->db->from('umb_karyawans');
			$this->db->where($condition);
			$query = $this->db->get();
			$row = $query->num_rows();
			$d_rows [] = $row;	
			$c_name[] = htmlspecialchars_decode($hr_roles->role_name);

			$someArray[] = array(
				'label'   => htmlspecialchars_decode($hr_roles->role_name),
				'value' => $row,
				'bgcolor' => $c_color[$j]
			);
			$j++;
		}
		$Return['c_name'] = $c_name;
		$Return['d_rows'] = $d_rows;
		$Return['chart_data'] = $someArray;
		$this->output($Return);
		exit;
	}
	
	public function hrastral_shifts_kantor() {
		
		$Return = array('chart_data'=>'', 'c_name'=>'', 'd_rows'=>'','c_color'=>'');
		$c_name = array();
		$c_am = array();	
		$c_color = array('#647c8a','#2196f3','#02bc77','#d3733b','#673AB7','#66456e','#b26fc2','#a98852','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e');
		$someArray = array();
		$j=0;
		foreach(hrastral_shift_kantor() as $hrastral_shift_kantor) { 

			$condition = "shift_kantor_id =" . "'" . $hr_shift_kantor->shift_kantor_id . "'";
			$this->db->select('*');
			$this->db->from('umb_karyawans');
			$this->db->where($condition);
			$query = $this->db->get();
			$row = $query->num_rows();
			$d_rows [] = $row;	
			$c_name[] = htmlspecialchars_decode($hr_shift_kantor->nama_shift);

			$someArray[] = array(
				'label'   => htmlspecialchars_decode($hr_shift_kantor->nama_shift),
				'value' => $row,
				'bgcolor' => $c_color[$j]
			);
			$j++;
		}
		$Return['c_name'] = $c_name;
		$Return['d_rows'] = $d_rows;
		$Return['chart_data'] = $someArray;
		$this->output($Return);
		exit;
	}
	
	public function status_projects() {
		
		$Return = array('chart_data'=>'', 'c_name'=>'', 'd_rows'=>'','c_color'=>'');
		$c_name = array();
		$c_am = array();	
		$c_color = array('#647c8a','#2196f3','#02bc77','#d3733b','#673AB7');
		$someArray = array();
		$j=0;
		$projects = get_status_projects();
		foreach($projects->result() as $eproject) {
				//$d_rows = array();	
			$row = total_status_projects($eproject->status);
			$d_rows [] = $row;
			if($eproject->status==0){
				$csname = htmlspecialchars_decode($this->lang->line('umb_not_started'));
			} else if($eproject->status==1){
				$csname = htmlspecialchars_decode($this->lang->line('umb_in_progress'));
			} else if($eproject->status==2){
				$csname = htmlspecialchars_decode($this->lang->line('umb_completed'));
			} else if($eproject->status==3){
				$csname = htmlspecialchars_decode($this->lang->line('umb_project_cancelled'));
			} else if($eproject->status==4){
				$csname = htmlspecialchars_decode($this->lang->line('umb_project_hold'));
			}				
			$c_name [] = $csname;
			$someArray[] = array(
				'label'   => $csname,
				'value' => $row,
				'bgcolor' => $c_color[$j]
			);
			$j++;
			//}
		}
		$Return['c_name'] = $c_name;
		$Return['d_rows'] = $d_rows;
		$Return['chart_data'] = $someArray;
		$this->output($Return);
		exit;
	}

	public function user_status_projects() {
		
		$Return = array('chart_data'=>'', 'c_name'=>'', 'd_rows'=>'','c_color'=>'');
		$c_name = array();
		$c_am = array();	
		//$c_color = array('#647c8a','#2196f3','#02bc77','#d3733b','#673AB7');
		$someArray = array();
		$j=0;
		$session = $this->session->userdata('username');
		$projects = get_user_status_projects($session['user_id']);
		foreach($projects->result() as $eproject) {
			if($eproject->status==0){
				$csname = htmlspecialchars_decode($this->lang->line('umb_not_started'));
				$row = total_user_status_projects($eproject->status,$session['user_id']);
				$bdcolor = '#647c8a';
			} else if($eproject->status==1){
				$csname = htmlspecialchars_decode($this->lang->line('umb_in_progress'));
				$row = total_user_status_projects($eproject->status,$session['user_id']);
				$bdcolor = '#2196f3';
			} else if($eproject->status==2){
				$csname = htmlspecialchars_decode($this->lang->line('umb_completed'));
				$row = total_user_status_projects($eproject->status,$session['user_id']);
				$bdcolor = '#02bc77';
			} else if($eproject->status==3){
				$csname = htmlspecialchars_decode($this->lang->line('umb_project_cancelled'));
				$row = total_user_status_projects($eproject->status,$session['user_id']);
				$bdcolor = '#d3733b';
			} else if($eproject->status==4){
				$csname = htmlspecialchars_decode($this->lang->line('umb_project_hold'));
				$row = total_user_status_projects($eproject->status,$session['user_id']);
				$bdcolor = '#673AB7';
			}				
			$c_name [] = $csname;
			$d_rows [] = $row;
			$someArray[] = array(
				'label'   => $csname,
				'value' => $row,
				'bgcolor' => $bdcolor
			);
			$j++;
		}
		$Return['c_name'] = $c_name;
		$Return['d_rows'] = $d_rows;
		$Return['chart_data'] = $someArray;
		$this->output($Return);
		exit;
	}

	public function user_status_tugass() {
		
		$Return = array('chart_data'=>'', 'c_name'=>'', 'd_rows'=>'','c_color'=>'');
		$c_name = array();
		$c_am = array();	
		//$c_color = array('#647c8a','#2196f3','#02bc77','#d3733b','#673AB7');
		$someArray = array();
		$j=0;
		$session = $this->session->userdata('username');
		$tugass = get_user_status_tugass($session['user_id']);
		foreach($tugass->result() as $etugas) {
				//$d_rows = array();	
				//$row = total_user_status_tugass($etugas->status_tugas,$session['user_id']);
			if($etugas->status_tugas==0){
				$sname = htmlspecialchars_decode($this->lang->line('umb_not_started'));
				$trow = total_user_status_tugass($etugas->status_tugas,$session['user_id']);
				$tbdcolor = '#647c8a';
			} else if($etugas->status_tugas==1){
				$sname = htmlspecialchars_decode($this->lang->line('umb_in_progress'));
				$trow = total_user_status_tugass($etugas->status_tugas,$session['user_id']);
				$tbdcolor = '#2196f3';
			} else if($etugas->status_tugas==2){
				$sname = htmlspecialchars_decode($this->lang->line('umb_completed'));
				$trow = total_user_status_tugass($etugas->status_tugas,$session['user_id']);
				$tbdcolor = '#02bc77';
			} else if($etugas->status_tugas==3){
				$sname = htmlspecialchars_decode($this->lang->line('umb_project_cancelled'));
				$trow = total_user_status_tugass($etugas->status_tugas,$session['user_id']);
				$tbdcolor = '#d3733b';
			} else if($etugas->status_tugas==4){
				$sname = htmlspecialchars_decode($this->lang->line('umb_project_hold'));
				$trow = total_user_status_tugass($etugas->status_tugas,$session['user_id']);
				$tbdcolor = '#673AB7';
			}				
			$c_name [] = $sname;
			$d_rows [] = $trow;
			$someArray[] = array(
				'label'   => $sname,
				'value' => $trow,
				'bgcolor' => $tbdcolor
			);
			$j++;
			//}
		}
		$Return['c_name'] = $c_name;
		$Return['d_rows'] = $d_rows;
		$Return['chart_data'] = $someArray;
		$this->output($Return);
		exit;
	}

	public function status_tugass() {
		
		$Return = array('chart_data'=>'', 'c_name'=>'', 'd_rows'=>'','c_color'=>'');
		$c_name = array();
		$c_am = array();	
		$c_color = array('#647c8a','#2196f3','#02bc77','#d3733b','#673AB7');
		$someArray = array();
		$j=0;
		$tugass = get_status_tugass();
		foreach($tugass->result() as $etugas) {
				//$d_rows = array();	
			$row = total_status_tugass($etugas->status_tugas);
			$d_rows [] = $row;
			if($etugas->status_tugas==0){
				$csname = htmlspecialchars_decode($this->lang->line('umb_not_started'));
			} else if($etugas->status_tugas==1){
				$csname = htmlspecialchars_decode($this->lang->line('umb_in_progress'));
			} else if($etugas->status_tugas==2){
				$csname = htmlspecialchars_decode($this->lang->line('umb_completed'));
			} else if($etugas->status_tugas==3){
				$csname = htmlspecialchars_decode($this->lang->line('umb_project_cancelled'));
			} else if($etugas->status_tugas==4){
				$csname = htmlspecialchars_decode($this->lang->line('umb_project_hold'));
			}				
			$c_name [] = $csname;
			$someArray[] = array(
				'label'   => $csname,
				'value' => $row,
				'bgcolor' => $c_color[$j]
			);
			$j++;
		}
		$Return['c_name'] = $c_name;
		$Return['d_rows'] = $d_rows;
		$Return['chart_data'] = $someArray;
		$this->output($Return);
		exit;
	}

	public function status_kehadiran() {
		
		$Return = array('chart_data'=>'', 'c_name'=>'', 'd_rows'=>'','c_color'=>'');
		$c_name = array();
		$c_am = array();
		$current_month = date('Y-m-d');
		$bekerja = $this->Umb_model->current_hari_bulan_kehadiran($current_month);
		$query = $this->Umb_model->all_status_karyawans();
		$total = $query->num_rows();
		// absent
		$abs = $total - $bekerja;	
		
		$c_color = array('#666EE8','#9793d7');
		$someArray = array();
		$j=0;
		//$att_data = array('bekerja_label'=>$this->lang->line('umb_krywn_bekerja'), 'att_total'=>$bekerja,'absent_label'=>$this->lang->line('umb_krywn_bekerja'),'att_total'=>$abs);
	    //	$projects = get_status_projects();
		//foreach($att_data as $kehadiran) {
				//$d_rows = array();	
				///$row[] = $bekerja;
		$row = 345;
		//$csname[] = $this->lang->line('umb_krywn_bekerja');
		//$csname[] = $this->lang->line('umb_absent');
		$csname = 'asdasd';	
		$d_rows [] = 123;
		//$c_name [] = 'test';
		$someArray[] = array(
			'label'   => $csname,
			'value' => $row,
			'bgcolor' => $c_color
		);
		$j++;

		$Return['c_name'] = $c_name;
		$Return['d_rows'] = $d_rows;
		$Return['chart_data'] = $someArray;
		$this->output($Return);
		exit;
	}

	public function count_head_karyawans() {
		
		$date = date('Y');
		$query = $this->db->query("SELECT * from umb_karyawans WHERE created_at like '%".$date."-01%'");
		$row1 = $query->num_rows();
		$Return['january'] = $row1;
		
		$query = $this->db->query("SELECT * from umb_karyawans WHERE created_at like '%".$date."-02%'");
		$row2 = $query->num_rows();
		$Return['february'] = $row2;
		
		$query = $this->db->query("SELECT * from umb_karyawans WHERE created_at like '%".$date."-03%'");
		$row3 = $query->num_rows();
		$Return['march'] = $row3;
		
		$query = $this->db->query("SELECT * from umb_karyawans WHERE created_at like '%".$date."-04%'");
		$row4 = $query->num_rows();
		$Return['april'] = $row4;
		
		$query = $this->db->query("SELECT * from umb_karyawans WHERE created_at like '%".$date."-05%'");
		$row5 = $query->num_rows();
		$Return['may'] = $row5;
		
		$query = $this->db->query("SELECT * from umb_karyawans WHERE created_at like '%".$date."-06%'");
		$row6 = $query->num_rows();
		$Return['june'] = $row6;
		
		$query = $this->db->query("SELECT * from umb_karyawans WHERE created_at like '%".$date."-07%'");
		$row7 = $query->num_rows();
		$Return['july'] = $row7;
		
		$query = $this->db->query("SELECT * from umb_karyawans WHERE created_at like '%".$date."-08%'");
		$row8 = $query->num_rows();
		$Return['august'] = $row8;
		
		$query = $this->db->query("SELECT * from umb_karyawans WHERE created_at like '%".$date."-09%'");
		$row9 = $query->num_rows();
		$Return['september'] = $row9;
		
		$query = $this->db->query("SELECT * from umb_karyawans WHERE created_at like '%".$date."-10%'");
		$row10 = $query->num_rows();
		$Return['october'] = $row10;
		
		$query = $this->db->query("SELECT * from umb_karyawans WHERE created_at like '%".$date."-11%'");
		$row11 = $query->num_rows();
		$Return['november'] = $row11;
		
		$query = $this->db->query("SELECT * from umb_karyawans WHERE created_at like '%".$date."-12%'");
		$row12 = $query->num_rows();
		$Return['december'] = $row12;
		
		$Return['current_year'] = date('Y');
		$this->output($Return);
		exit;
	}

	public function payroll_department_bijaksana() {
		
		$Return = array('chart_data'=>'', 'c_name'=>'', 'c_am'=>'','c_color'=>'');
		$c_name = array();
		$c_am = array();	
		$c_color = array('#3e70c9','#f59345','#f44236','#8A2BE2','#D2691E','#6495ED','#DC143C','#006400','#556B2F','#9932CC');
		$someArray = array();
		$j=0;
		foreach($this->Umb_model->all_chart_departments() as $department) {
			$department_pay = $this->Umb_model->get_department_melakukan_pembayaran($department->department_id);
			$c_name[] = htmlspecialchars_decode($department->nama_department);
			$c_am[] = $department_pay[0]->bayar_jumlah;
			$someArray[] = array(
				'label'   => htmlspecialchars_decode($department->nama_department),
				'value' => $department_pay[0]->bayar_jumlah,
				'bgcolor' => $c_color[$j]
			);
			$j++;
		}
		$Return['c_name'] = $c_name;
		$Return['c_am'] = $c_am;
		$Return['chart_data'] = $someArray;
		$this->output($Return);
		exit;
	}

	public function hrastral_payroll(){
		
		$Return = array('chart_data'=>'', 'c_name'=>'', 'c_am'=>'');
		$c_name = array();
		$c_am = array();
		$someArray = array();
		$j=0;
		for ($i = 0; $i <= 5; $i++) 
		{
			$months = date("Y-m", strtotime( date( 'Y-m-01' )." -$i months"));
			$jumlah = hrastral_payroll($months);
			$payroll_jumlah = $jumlah;
			$c_name[] = $months;
			$someArray[] = array(
				'label'   => $months,
				'value' => $payroll_jumlah,
			);

		}
		$Return['c_name'] = $c_name;
		$Return['col_name'] = 'Payroll';
		$Return['chart_data'] = $someArray;
		$this->output($Return);
		exit;
	}

	public function hrastral_user_payroll(){
		
		$Return = array('chart_data'=>'', 'c_name'=>'', 'c_am'=>'');
		$c_name = array();
		$c_am = array();
		$someArray = array();
		$session = $this->session->userdata('username');
		$j=0;
		for ($i = 0; $i <= 5; $i++) 
		{
			$months = date("Y-m", strtotime( date( 'Y-m-01' )." -$i months"));
			$jumlah = ihrastral_user_payroll($months,$session['user_id']);
			$payroll_jumlah = $jumlah;
			$c_name[] = $months;
			$someArray[] = array(
				'label'   => $months,
				'value' => $payroll_jumlah,
			);

		}
		$Return['c_name'] = $c_name;
		$Return['col_name'] = 'Payroll';
		$Return['chart_data'] = $someArray;
		$this->output($Return);
		exit;
	}
	
	public function hrastral_biaya_deposit() {
		
		$Return = array('deposit'=>'', 'deposit_label'=>'', 'biaya'=>'', 'biaya_label'=>'',);
		
		$Return['deposit'] = dashboard_total_sales();
		$Return['deposit_label'] = $this->lang->line('umb_total_deposit');
		$Return['biaya'] = dashboard_total_biaya();
		$Return['biaya_label'] = $this->lang->line('umb_total_biayaa');
		$this->output($Return);
		exit;
	}
	
	public function hrastral_permintaan_lembur() {
		
		$Return = array('lembur_approved'=>'', 'lembur_pending'=>'', 'lembur_rejected'=>'', 'approved'=>'', 'pending'=>'','rejected'=>'');
		
		$Return['approved'] = karyawan_approved_permintaan_lembur();
		$Return['lembur_approved'] = $this->lang->line('umb_approved');
		// working
		$Return['pending'] = karyawan_pending_permintaan_lembur();
		$Return['lembur_pending'] = $this->lang->line('umb_pending');
		
		$Return['rejected'] = karyawan_rejected_permintaan_lembur();
		$Return['lembur_rejected'] = $this->lang->line('umb_rejected');
		$this->output($Return);
		exit;
	}
	
	public function hrastral_clients_leads() {
		
		$Return = array('clients_label'=>'', 'leads_label'=>'', 'total_leads'=>'','total_clients'=>'');
		
		$Return['total_clients'] = total_clients();
		$Return['clients_label'] = $this->lang->line('umb_project_clients');
		// working
		$Return['total_leads'] = total_leads();
		$Return['leads_label'] = $this->lang->line('umb_leads');
		
		$this->output($Return);
		exit;
	}
	
	public function payroll_penunjukan_bijaksana() {
		
		$Return = array('chart_data'=>'', 'c_name'=>'', 'c_am'=>'','c_color'=>'');
		$c_name = array();
		$c_am = array();	
		$c_color = array('#1AAF5D','#F2C500','#F45B00','#8E0000','#0E948C','#6495ED','#DC143C','#006400','#556B2F','#9932CC');
		$someArray = array();
		$j=0;
		foreach($this->Umb_model->all_penunjukans_chart() as $penunjukan) {
			$result = $this->Umb_model->get_penunjukan_melakukan_pembayaran($penunjukan->penunjukan_id);
			$c_name[] = htmlspecialchars_decode($penunjukan->nama_penunjukan);
			$c_am[] = $result[0]->bayar_jumlah;
			$someArray[] = array(
				'label'   => htmlspecialchars_decode($penunjukan->nama_penunjukan),
				'value' => $result[0]->bayar_jumlah,
				'bgcolor' => $c_color[$j]
			);
			$j++;
		}
		$Return['c_name'] = $c_name;
		$Return['c_am'] = $c_am;
		$Return['chart_data'] = $someArray;
		$this->output($Return);
		exit;
	}
	
	public function notifications() {
		
		$data['title'] = $this->lang->line('header_notifications').' | '.$this->Umb_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('header_notifications');
		//$this->load->view('admin/settings/hrastral_notifications', $data);
		$data['subview'] = $this->load->view("admin/settings/hrastral_notifications", $data, TRUE);
		$this->load->view('admin/layout/layout_main', $data);
	}
	
	public function set_language($language = "") {

		$language = ($language != "") ? $language : "english";
		$this->session->set_userdata('site_lang', $language);
		redirect($_SERVER['HTTP_REFERER']);
	}
}
