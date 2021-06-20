<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Calendar extends MY_Controller {


	public function output($Return=array()){

		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");

		exit(json_encode($Return));
	}

	public function __construct() {

		parent::__construct();

		$this->load->model('Perusahaan_model');
		$this->load->model('Umb_model');
		$this->load->model('Timesheet_model');
		$this->load->model('Perjalanan_model');
		$this->load->model('Training_model');
		$this->load->model('Project_model');
		$this->load->model('Tujuan_tracking_model');
		$this->load->model('Events_model');
		$this->load->model('Meetings_model');
		$this->load->model('Trainers_model');
		$this->load->model('Department_model');
		$this->load->model('Clients_model');
	}

	public function hr() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('umb_hr_calendar_title').' | '.$this->Umb_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('umb_hr_calendar_title');
		$data['path_url'] = 'log';
		$data['all_liburan'] = $this->Timesheet_model->get_calendar_liburan();
		$data['all_calendar_permintaan_cutii'] = $this->Timesheet_model->get_calendar_permintaan_cutii();
		$data['all_upcoming_ulangtahun'] = $this->Umb_model->karyawans_upcoming_ulangtahun();
		$data['all_permintaan_perjalanan'] = $this->Perjalanan_model->get_perjalanan();
		$data['all_training'] = $this->Training_model->get_training();
		$data['all_projects'] = $this->Project_model->get_projects();
		$data['all_tugass'] = $this->Timesheet_model->get_tugass();
		$data['all_tujuans'] = $this->Tujuan_tracking_model->get_tujuan_tracking();
		$data['all_events'] = $this->Events_model->get_events();
		$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		$data['all_meetings'] = $this->Meetings_model->get_meetings();
		$data['get_all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$data['all_clients'] = $this->Clients_model->get_all_clients();
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('95',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/calendar/calendar_hr", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
		} else {
			redirect('admin/dashboard');
		}
	}
	
	public function add_record_cal() {
		
		$data['title'] = $this->Umb_model->site_title();
		$record = $this->input->get('record');
		$data = array(
			'all_perusahaans' => $this->Umb_model->get_perusahaans(),
			'get_all_perusahaans' => $this->Umb_model->get_perusahaans(),
			'all_karyawans' => $this->Umb_model->all_karyawans(),
			'all_types_tracking' => $this->Tujuan_tracking_model->all_types_tracking(),
			'all_types_cuti' => $this->Timesheet_model->all_types_cuti(),
			'types_pengaturan_perjalanan' => $this->Perjalanan_model->types_pengaturan_perjalanan(),
			'all_trainers' => $this->Trainers_model->all_trainers(),
			'all_types_training' => $this->Training_model->all_types_training(),
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			if($record == 0){
				$this->load->view('admin/calendar/options/dialog_add_libur', $data);
			} else if($record == 1){
				$this->load->view('admin/calendar/options/dialog_add_cuti', $data);
			} else if($record == 2){
				$this->load->view('admin/calendar/options/dialog_add_perjalanan', $data);
			} else if($record == 3){
				$this->load->view('admin/calendar/options/dialog_add_training', $data);
			} else if($record == 4){
				$this->load->view('admin/calendar/options/dialog_add_project', $data);
			} else if($record == 5){
				$this->load->view('admin/calendar/options/dialog_add_tugas', $data);
			} else if($record == 6){
				$this->load->view('admin/calendar/options/dialog_add_events', $data);
			} else if($record == 7){
				$this->load->view('admin/calendar/options/dialog_add_meetings', $data);
			} else if($record == 8){
				$this->load->view('admin/calendar/options/dialog_add_tujuan', $data);
			} else if($record == 9){
				$this->load->view('admin/calendar/options/dialog_add_events', $data);
			} else if($record == 10){
				$this->load->view('admin/calendar/options/dialog_add_events', $data);
			} else if($record == 11){
				$this->load->view('admin/calendar/options/dialog_add_meetings', $data);
			}
		} else {
			redirect('admin/');
		}
	}
} 
?>