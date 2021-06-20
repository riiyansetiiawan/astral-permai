<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Permintaan_lembur extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		
		$this->load->model("Permintaan_lembur_model");
		$this->load->model("Karyawans_model");
		$this->load->model("Umb_model");
		$this->load->library('email');
		$this->load->model("Department_model");
		$this->load->model("Penunjukan_model");
		$this->load->model("Roles_model");
		$this->load->model("Project_model");
		$this->load->model("Location_model");
		$this->load->model("Project_model");
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
		$data['title'] = $this->lang->line('umb_permintaan_lembur').' | '.$this->Umb_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('umb_permintaan_lembur');
		$data['path_url'] = 'permintaan_lembur';		
		$data['get_all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('401',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/timesheet/permintaans_lembur", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}	  
	}	 

	public function list_permintaan_lembur() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		$tanggal_kehadiran = $this->input->get("tanggal_kehadiran");
		$karyawan_id = $session['user_id'];
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$user_info = $this->Umb_model->read_user_info($session['user_id']);
		if($user_info[0]->user_role_id==1){
			$kehadiran_karyawan = $this->Permintaan_lembur_model->all_pemintaans_lembur_karyawan();
		} else {
			$kehadiran_karyawan = $this->Permintaan_lembur_model->permintaans_lembur_karyawan($karyawan_id);
		}
		$role_resources_ids = $this->Umb_model->user_role_resource();
		$data = array();

		foreach($kehadiran_karyawan->result() as $r) {

			$in_time = new DateTime($r->request_clock_in);
			$out_time = new DateTime($r->request_clock_out);
			
			$karyawan_id = $this->Umb_model->read_user_info($r->karyawan_id);	
			if(!is_null($karyawan_id)) {
				$full_name = $karyawan_id[0]->karyawan_id;
			} else {
				$full_name = '';
			}
			
			$clock_in = $in_time->format('h:i a');			
			$hadir_tanggal_in = explode(' ',$r->request_clock_in);
			$hadir_tanggal_out = explode(' ',$r->request_clock_out);
			$tanggal_permintaan = $this->Umb_model->set_date_format($r->tanggal_permintaan);
			$cin_date = $clock_in;
			if($r->request_clock_out=='') {
				$cout_date = '-';
				$total_time = '-';
			} else {
				$clock_out = $out_time->format('h:i a');
				$interval = $in_time->diff($out_time);
				$hours  = $interval->format('%h');
				$minutes = $interval->format('%i');			
				$total_time = $hours ."h ".$minutes."m";
				$cout_date = $clock_out;
			}
			if($user_info[0]->user_role_id==1){
				if(in_array('402',$role_resources_ids)) {
					$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light edit-data" data-toggle="modal" data-target=".edit-modal-data" data-permintaan_waktu_id="'.$r->permintaan_waktu_id.'"><i class="fas fa-pencil-alt"></i></button></span>';
				} else {
					$edit = '';
				}
				if(in_array('403',$role_resources_ids)) {
					$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'.$r->permintaan_waktu_id.'"><i class="fas fa-trash-restore"></i></button></span>';
				} else {
					$delete = '';
				}
			} else {
				if($r->is_approved == '2'){
					if(in_array('402',$role_resources_ids)) {
						$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light edit-data" disabled data-toggle="modal" data-target=".edit-modal-data" ><i class="fas fa-pencil-alt"></i></button></span>';
					} else {
						$edit = '';
					}
					if(in_array('403',$role_resources_ids)) {
						$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" disabled data-toggle="modal" data-target=".delete-modal" ><i class="fas fa-trash-restore"></i></button></span>';
					} else {
						$delete = '';
					}
				} else {
					if(in_array('402',$role_resources_ids)) {
						$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light edit-data" data-toggle="modal" data-target=".edit-modal-data" data-permintaan_waktu_id="'.$r->permintaan_waktu_id.'"><i class="fas fa-pencil-alt"></i></button></span>';
					} else {
						$edit = '';
					}
					if(in_array('403',$role_resources_ids)) {
						$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'.$r->permintaan_waktu_id.'"><i class="fas fa-trash-restore"></i></button></span>';
					} else {
						$delete = '';
					}
				}
			}
			if($r->is_approved == '1'){
				$status = $this->lang->line('umb_pending');
			} else if($r->is_approved == '2'){
				$status = $this->lang->line('umb_accepted');
			} else {
				$status = $this->lang->line('umb_rejected');
			}
			
			$combhr = $edit.$delete;

			$data[] = array(
				$combhr,
				$full_name,
				$r->no_project,
				$r->no_pembelian,
				$tanggal_permintaan,
				$cin_date,
				$cout_date,
				$total_time,
				$status
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $kehadiran_karyawan->num_rows(),
			"recordsFiltered" => $kehadiran_karyawan->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function update_add_kehadiran() {
		$data['title'] = $this->Umb_model->site_title();
		//$karyawan_id = $this->input->get('karyawan_id');
		//$user = $this->Umb_model->read_user_info($karyawan_id);
		$data = array(
			'get_all_perusahaans' => $this->Umb_model->get_perusahaans(),
			'all_karyawans' => $this->Umb_model->all_karyawans(),
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/timesheet/dialog_permintaan_lembur', $data);
		} else {
			redirect('admin/');
		}
	}
	
	public function add_permintaan_kehadiran() {

		if($this->input->post('add_type')=='kehadiran') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();

			if($this->input->post('perusahaan_id')==='') {
				$Return['error'] = $this->lang->line('umb_error_perusahaan');
			} else if($this->input->post('karyawan_id')==='') {
				$Return['error'] = $this->lang->line('umb_error_karyawan_id');
			} else if($this->input->post('prmtan_tanggal_kehadiran')==='') {
				$Return['error'] = $this->lang->line('umb_error_permintaan_tanggal_kehadiran');
			} else if($this->input->post('clock_in_m')==='') {
				$Return['error'] = $this->lang->line('umb_error_permintaan_kehadiran_waktu_masuk');
			} else if($this->input->post('clock_out_m')==='') {
				$Return['error'] = $this->lang->line('umb_error_permintaan_kehadiran_waktu_pulang');
			} else if($this->input->post('no_project')==='') {
				$Return['error'] = $this->lang->line('umb_project_field_noproject_error');
			} else if($this->input->post('nama_tugas')==='') {
				$Return['error'] = $this->lang->line('umb_field_title_tugas_error');
			}

			if($Return['error']!=''){
				$this->output($Return);
			}

			$tanggal_kehadiran = $this->input->post('prmtan_tanggal_kehadiran');
			$clock_in = $this->input->post('clock_in_m');
			$clock_out = $this->input->post('clock_out_m');

			$clock_in2 = $tanggal_kehadiran.' '.$clock_in.':00';
			$clock_out2 = $tanggal_kehadiran.' '.$clock_out.':00';

			$total_kerja_cin =  new DateTime($clock_in2);
			$total_kerja_cout =  new DateTime($clock_out2);

			$interval_cin = $total_kerja_cout->diff($total_kerja_cin);
			$hours_in   = $interval_cin->format('%h');
			$minutes_in = $interval_cin->format('%i');
			$total_kerja = $hours_in .":".$minutes_in;

			$hadir_tanggal = strtotime($tanggal_kehadiran);
			$rq_date = date('Y-m',$hadir_tanggal);

			$data = array(
				'perusahaan_id' => $this->input->post('perusahaan_id'),
				'karyawan_id' => $this->input->post('karyawan_id'),
				'tanggal_permintaan' => $tanggal_kehadiran,
				'tanggal_permintaan_request' => $rq_date,
				'request_clock_in' => $clock_in2,
				'request_clock_out' => $clock_out2,
				'total_hours' => $total_kerja,
				'no_project' => $this->input->post('no_project'),
				'no_pembelian' => $this->input->post('no_pembelian'),
				'nama_tugas' => $this->input->post('nama_tugas'),
				'alasan_permintaan' => $this->input->post('umb_alasan'),
				'is_approved' => 1
			);
			$result = $this->Permintaan_lembur_model->add_permintaan_lembur_karyawan($data);

			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_permintaan_kehadiran_ditambahkan');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function read() {

		$data['title'] = $this->Umb_model->site_title();
		$permintaan_waktu_id = $this->input->get('permintaan_waktu_id');
		$result = $this->Permintaan_lembur_model->read_info_permintaan_lembur($permintaan_waktu_id);
		$user = $this->Umb_model->read_user_info($result[0]->karyawan_id);
		
		$full_name = $user[0]->first_name.' '.$user[0]->last_name;
		
		$in_time = new DateTime($result[0]->request_clock_in);
		$out_time = new DateTime($result[0]->request_clock_out);
		
		$clock_in = $in_time->format('H:i');
		if($result[0]->request_clock_out == '') {
			$clock_out = '';
		} else {
			$clock_out = $out_time->format('H:i');
		}
		$data = array(
			'permintaan_waktu_id' => $result[0]->permintaan_waktu_id,
			'perusahaan_id' => $result[0]->perusahaan_id,
			'karyawan_id' => $result[0]->karyawan_id,
			'full_name' => $full_name,
			'tanggal_permintaan' => $result[0]->tanggal_permintaan,
			'request_clock_in' => $clock_in,
			'request_clock_out' => $clock_out,
			'alasan_permintaan' => $result[0]->alasan_permintaan,
			'is_approved' => $result[0]->is_approved,
			'get_all_perusahaans' => $this->Umb_model->get_perusahaans(),
			'all_karyawans' => $this->Umb_model->all_karyawans(),
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/timesheet/dialog_permintaan_lembur', $data);
		} else {
			redirect('admin/');
		}
	}
	
	public function edit_kehadiran() {

		if($this->input->post('edit_type')=='kehadiran') {
			
			$id = $this->uri->segment(4);

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$session = $this->session->userdata('username');
			$user = $this->Umb_model->read_user_info($session['user_id']);	

			if($this->input->post('perusahaan_id')==='') {
				$Return['error'] = $this->lang->line('umb_error_perusahaan');
			} else if($this->input->post('karyawan_id')==='') {
				$Return['error'] = $this->lang->line('umb_error_karyawan_id');
			} else if($this->input->post('tanggal_kehadiran_e')==='') {
				$Return['error'] = $this->lang->line('umb_error_permintaan_tanggal_kehadiran');
			} else if($this->input->post('clock_in')==='') {
				$Return['error'] = $this->lang->line('umb_error_permintaan_kehadiran_waktu_masuk');
			} else if($this->input->post('clock_out')==='') {
				$Return['error'] = $this->lang->line('umb_error_permintaan_kehadiran_waktu_pulang');
			}

			if($Return['error']!=''){
				$this->output($Return);
			}

			$tanggal_kehadiran = $this->input->post('tanggal_kehadiran_e');
			$clock_in = $this->input->post('clock_in');

			$clock_in2 = $tanggal_kehadiran.' '.$clock_in.':00';

			$total_kerja_cin =  new DateTime($clock_in2);

			$clock_out = $this->input->post('clock_out');
			$clock_out2 = $tanggal_kehadiran.' '.$clock_out.':00';
			$total_kerja_cout =  new DateTime($clock_out2);

			$interval_cin = $total_kerja_cout->diff($total_kerja_cin);
			$hours_in   = $interval_cin->format('%h');
			$minutes_in = $interval_cin->format('%i');
			$total_kerja = $hours_in .":".$minutes_in;
			if($user[0]->user_role_id == 1) {
				$data = array(
					'perusahaan_id' => $this->input->post('perusahaan_id'),
					'karyawan_id' => $this->input->post('karyawan_id'),
					'tanggal_permintaan' => $tanggal_kehadiran,
					'request_clock_in' => $clock_in2,
					'request_clock_out' => $clock_out2,
					'total_hours' => $total_kerja,
					'alasan_permintaan' => $this->input->post('umb_alasan'),
					'is_approved' => $this->input->post('status'),
				);
			} else {
				$data = array(
					'tanggal_permintaan' => $tanggal_kehadiran,
					'request_clock_in' => $clock_in2,
					'request_clock_out' => $clock_out2,
					'total_hours' => $total_kerja,
					'alasan_permintaan' => $this->input->post('umb_alasan'),
				);
			}

			$result = $this->Permintaan_lembur_model->update_record_permintaan($data,$id);		

			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_permintaan_kehadiran_update');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function delete_kehadiran() {

		if($this->input->post('type')=='delete') {

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Permintaan_lembur_model->delete_record_permintaan_lembur($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_sukses_karyawn_kehadiran_dihapus');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}

	public function get_update_karyawans() {

		$data['title'] = $this->Umb_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'perusahaan_id' => $id
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/timesheet/get_permintaan_karyawans", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}
}
