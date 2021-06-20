<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Peringatan extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		
		$this->load->model("Peringatan_model");
		$this->load->model("Umb_model");
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
		$data['title'] = $this->lang->line('left_peringatans').' | '.$this->Umb_model->site_title();
		$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		$data['get_all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$data['all_types_peringatan'] = $this->Peringatan_model->all_types_peringatan();
		$data['breadcrumbs'] = $this->lang->line('left_peringatans');
		$data['path_url'] = 'peringatan';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('20',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/peringatan/list_peringatan", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}

	public function get_karyawans() {

		$data['title'] = $this->Umb_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'perusahaan_id' => $id
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/peringatan/get_karyawans", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}


	public function get_peringatan_karyawans() {

		$data['title'] = $this->Umb_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'perusahaan_id' => $id
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/peringatan/get_peringatan_karyawans", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}

	public function list_peringatan() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/peringatan/list_peringatan", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$role_resources_ids = $this->Umb_model->user_role_resource();
		$user_info = $this->Umb_model->read_user_info($session['user_id']);
		if($user_info[0]->user_role_id==1){
			$peringatan = $this->Peringatan_model->get_peringatan();
		} else {
			if(in_array('238',$role_resources_ids)) {
				$peringatan = $this->Peringatan_model->get_peringatan_perusahaan($user_info[0]->perusahaan_id);
			} else {
				$peringatan = $this->Peringatan_model->get_peringatan_karyawan($session['user_id']);
			}
		}		
		$data = array();

		foreach($peringatan->result() as $r) {

			$user = $this->Umb_model->read_user_info($r->peringatan_ke);

			if(!is_null($user)){
				$peringatan_ke = $user[0]->first_name.' '.$user[0]->last_name;
			} else {
				$peringatan_ke = '--';	
			}

			$user_by = $this->Umb_model->read_user_info($r->peringatan_oleh);

			if(!is_null($user_by)){
				$peringatan_oleh = $user_by[0]->first_name.' '.$user_by[0]->last_name;
			} else {
				$peringatan_oleh = '--';	
			}

			$tanggal_peringatan = $this->Umb_model->set_date_format($r->tanggal_peringatan);

			if($r->status==0): 
				$status = $this->lang->line('umb_pending');
			elseif($r->status==1): 
				$status = $this->lang->line('umb_accepted'); 
			else: 
				$status = $this->lang->line('umb_rejected'); 
			endif;
			$type_peringatan = $this->Peringatan_model->read_informasi_type_peringatan($r->type_peringatan_id);
			if(!is_null($type_peringatan)){
				$wtype = $type_peringatan[0]->type;
			} else {
				$wtype = '--';	
			}
			$perusahaan = $this->Umb_model->read_info_perusahaan($r->perusahaan_id);
			if(!is_null($perusahaan)){
				$prshn_nama = $perusahaan[0]->name;
			} else {
				$prshn_nama = '--';	
			}

			if(in_array('226',$role_resources_ids)) {
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-peringatan_id="'. $r->peringatan_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('227',$role_resources_ids)) {
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger"" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger" waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->peringatan_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}
			if(in_array('238',$role_resources_ids)) {
				$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target="#modals-slide" data-peringatan_id="'. $r->peringatan_id . '"><span class="fa fa-eye"></span></button></span>';
			} else {
				$view = '';
			}
			if($r->status==0): 
				$status = '<span class="badge bg-orange">'.$this->lang->line('umb_pending').'</span>';
			elseif($r->status==1): 
				$status = '<span class="badge bg-green">'.$this->lang->line('umb_accepted').'</span>';
			else: 
				$status = '<span class="badge bg-red">'.$this->lang->line('umb_rejected').'</span>'; 
			endif;

			$combhr = $edit.$view.$delete;

			$iperingatan_ke = $peringatan_ke.'<br><small class="text-muted"><i>'.$wtype.'<i></i></i></small><br><small class="text-muted"><i>'.$status.'<i></i></i></small>';

			$data[] = array(
				$combhr,
				$iperingatan_ke,
				$prshn_nama,
				$tanggal_peringatan,
				$r->subject,
				$peringatan_oleh
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $peringatan->num_rows(),
			"recordsFiltered" => $peringatan->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function read() {

		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('peringatan_id');
		$result = $this->Peringatan_model->read_informasi_peringatan($id);
		$data = array(
			'peringatan_id' => $result[0]->peringatan_id,
			'perusahaan_id' => $result[0]->perusahaan_id,
			'peringatan_ke' => $result[0]->peringatan_ke,
			'peringatan_oleh' => $result[0]->peringatan_oleh,
			'tanggal_peringatan' => $result[0]->tanggal_peringatan,
			'type_peringatan_id' => $result[0]->type_peringatan_id,
			'subject' => $result[0]->subject,
			'description' => $result[0]->description,
			'status' => $result[0]->status,
			'attachment' => $result[0]->attachment,
			'all_karyawans' => $this->Umb_model->all_karyawans(),
			'get_all_perusahaans' => $this->Umb_model->get_perusahaans(),
			'all_types_peringatan' => $this->Peringatan_model->all_types_peringatan(),
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/peringatan/dialog_peringatan', $data);
		} else {
			redirect('admin/');
		}
	}

	public function add_peringatan() {

		if($this->input->post('add_type')=='peringatan') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();

			$description = $this->input->post('description');
			$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);

			if($this->input->post('perusahaan_id')==='') {
				$Return['error'] = $this->lang->line('error_field_perusahaan');
			} else if($this->input->post('peringatan_ke')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_peringatan');
			} else if($this->input->post('type')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_type_peringatan');
			} else if($this->input->post('subject')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_subject');
			} else if($this->input->post('peringatan_oleh')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_peringatan_oleh');
			} else if($this->input->post('tanggal_peringatan')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_tanggal_peringatan');
			}

			if($Return['error']!=''){
				$this->output($Return);
			}
			if(is_uploaded_file($_FILES['attachment']['tmp_name'])) {

				$allowed =  array('png','jpg','jpeg','pdf','gif');
				$filename = $_FILES['attachment']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);

				if(in_array($ext,$allowed)){
					$tmp_name = $_FILES["attachment"]["tmp_name"];
					$profile = "uploads/warning/";
					$set_img = base_url()."uploads/warning/";

					$name = basename($_FILES["attachment"]["name"]);
					$newfilename = 'peringatan_'.round(microtime(true)).'.'.$ext;
					move_uploaded_file($tmp_name, $profile.$newfilename);
					$fname = $newfilename;			
				} else {
					$Return['error'] = $this->lang->line('umb_error_attatchment_type');
				}
			} else {
				$fname = '';
			}

			$data = array(
				'peringatan_ke' => $this->input->post('peringatan_ke'),
				'perusahaan_id' => $this->input->post('perusahaan_id'),
				'type_peringatan_id' => $this->input->post('type'),
				'description' => $qt_description,
				'attachment' => $fname,
				'subject' => $this->input->post('subject'),
				'peringatan_oleh' => $this->input->post('peringatan_oleh'),
				'tanggal_peringatan' => $this->input->post('tanggal_peringatan'),
				'status' => '0',
				'created_at' => date('d-m-Y'),
			);
			$result = $this->Peringatan_model->add($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_peringatan_karyawan_ditambahkan');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}


	public function update() {

		if($this->input->post('edit_type')=='peringatan') {

			$id = $this->uri->segment(4);

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();

			$description = $this->input->post('description');
			$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);

			if($this->input->post('type')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_type_peringatan');
			} else if($this->input->post('subject')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_subject');
			} else if($this->input->post('tanggal_peringatan')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_tanggal_peringatan');
			}

			if($Return['error']!=''){
				$this->output($Return);
			}

			$data = array(
				'type_peringatan_id' => $this->input->post('type'),
				'description' => $qt_description,
				'subject' => $this->input->post('subject'),
				'tanggal_peringatan' => $this->input->post('tanggal_peringatan'),
				'status' => $this->input->post('status'),
			);

			$result = $this->Peringatan_model->update_record($data,$id);		

			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_peringatan_karyawan_diperbarui');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function delete() {

		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$result = $this->Peringatan_model->delete_record($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('umb_peringatan_karyawan_dihapus');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
	}
}
