<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Keluhans extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		
		$this->load->model("Keluhans_model");
		$this->load->model("Umb_model");
		$this->load->model("Department_model");
	}
	
	
	public function output($Return=array()){
		
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		
		exit(json_encode($Return));
	}
	
	public function index(){
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('left_keluhans').' | '.$this->Umb_model->site_title();
		$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		$data['get_all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$data['breadcrumbs'] = $this->lang->line('left_keluhans');
		$data['path_url'] = 'keluhans';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('19',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/keluhans/list_keluhan", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}

	public function list_keluhan(){

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/keluhans/list_keluhan", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$role_resources_ids = $this->Umb_model->user_role_resource();
		$user_info = $this->Umb_model->read_user_info($session['user_id']);
		if($user_info[0]->user_role_id==1){
			$keluhan = $this->Keluhans_model->get_keluhans();
		} else {
			if(in_array('237',$role_resources_ids)) {
				$keluhan = $this->Keluhans_model->get_perusahaan_keluhans($user_info[0]->perusahaan_id);
			} else {
				$keluhan = $this->Keluhans_model->get_karyawan_keluhans($session['user_id']);
			}
		}
		$data = array();
		foreach($keluhan->result() as $r) {
			$user = $this->Umb_model->read_user_info($r->keluhan_dari);

			if(!is_null($user)){
				$keluhan_dari = $user[0]->first_name.' '.$user[0]->last_name;
			} else {
				$keluhan_dari = '--';	
			}

			if($r->keluhan_terhadap == '') {
				$ol = '--';
			} else {
				$ol = '<ol class="nl">';
				foreach(explode(',',$r->keluhan_terhadap) as $tunjuk_id) {
					$_prshn_nama = $this->Umb_model->read_user_info($tunjuk_id);
					if(!is_null($_prshn_nama)){
						$ol .= '<li>'.$_prshn_nama[0]->first_name.' '.$_prshn_nama[0]->last_name.'</li>';
					} else {
						$ol .= '';
					}

				}
				$ol .= '</ol>';
			}
			$tanggal_keluhan = $this->Umb_model->set_date_format($r->tanggal_keluhan);

			if(in_array('223',$role_resources_ids)) {
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-keluhan_id="'. $r->keluhan_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('224',$role_resources_ids)) {
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger"" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger" waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->keluhan_id . '">
				<span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}
			if(in_array('237',$role_resources_ids)) {
				$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target="#modals-slide" data-keluhan_id="'. $r->keluhan_id . '"><span class="fa fa-eye"></span></button></span>';
			} else {
				$view = '';
			}
			$perusahaan = $this->Umb_model->read_info_perusahaan($r->perusahaan_id);
			if(!is_null($perusahaan)){
				$prshn_nama = $perusahaan[0]->name;
			} else {
				$prshn_nama = '--';	
			}
			if($r->status==0): 
				$status = '<span class="badge bg-red">'.$this->lang->line('umb_pending').'</span>';
			elseif($r->status==1): 
				$status = '<span class="badge bg-green">'.$this->lang->line('umb_accepted').'</span>'; 
			else: 
				$status = '<span class="badge bg-red">'.$this->lang->line('umb_rejected').'</span>';
			endif;
			$ikeluhan_dari = $keluhan_dari.'<br><small class="text-muted"><i>'.$this->lang->line('umb_description').': '.$r->description.'<i></i></i></small><br><small class="text-muted"><i>'.$status.'<i></i></i></small>';
			$combhr = $edit.$view.$delete;
			$data[] = array(
				$combhr,
				$ikeluhan_dari,
				$ol,
				$prshn_nama,
				$r->title,
				$tanggal_keluhan
			);
		}
		$output = array(
			"draw" => $draw,
			"recordsTotal" => $keluhan->num_rows(),
			"recordsFiltered" => $keluhan->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function read(){
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('keluhan_id');
		$result = $this->Keluhans_model->read_informasi_keluhan($id);
		$data = array(
			'keluhan_id' => $result[0]->keluhan_id,
			'perusahaan_id' => $result[0]->perusahaan_id,
			'keluhan_dari' => $result[0]->keluhan_dari,
			'title' => $result[0]->title,
			'tanggal_keluhan' => $result[0]->tanggal_keluhan,
			'keluhan_terhadap' => $result[0]->keluhan_terhadap,
			'description' => $result[0]->description,
			'status' => $result[0]->status,
			'attachment' => $result[0]->attachment,
			'all_karyawans' => $this->Umb_model->all_karyawans(),
			'get_all_perusahaans' => $this->Umb_model->get_perusahaans()
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/keluhans/dialog_keluhan', $data);
		} else {
			redirect('admin/');
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
			$this->load->view("admin/keluhans/get_karyawans", $data);
		} else {
			redirect('admin/');
		}

		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}


	public function get_keluhan_karyawans() {

		$data['title'] = $this->Umb_model->site_title();
		$id = $this->uri->segment(4);

		$data = array(
			'perusahaan_id' => $id
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/keluhans/get_keluhan_karyawans", $data);
		} else {
			redirect('admin/');
		}

		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}


	public function add_keluhan() {

		if($this->input->post('add_type')=='keluhan') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();


			$description = $this->input->post('description');
			$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);

			if($this->input->post('perusahaan_id')==='') {
				$Return['error'] = $this->lang->line('error_field_perusahaan');
			} else if($this->input->post('karyawan_id')==='') {
				$Return['error'] = $this->lang->line('umb_error_keluhan_dari');
			} else if($this->input->post('title')==='') {
				$Return['error'] = $this->lang->line('umb_error_title_keluhan');
			} else if($this->input->post('tanggal_keluhan')==='') {
				$Return['error'] = $this->lang->line('umb_error_tanggal_keluhan');
			} else if($this->input->post('keluhan_terhadap')==='') {
				$Return['error'] = $this->lang->line('umb_error_keluhan_terhadap');
			}

			if($Return['error']!=''){
				$this->output($Return);
			}
			$keluhan_terhadap_ids = implode(',',$this->input->post('keluhan_terhadap'));

			if(is_uploaded_file($_FILES['attachment']['tmp_name'])) {

				$allowed =  array('png','jpg','jpeg','pdf','gif');
				$filename = $_FILES['attachment']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);

				if(in_array($ext,$allowed)){
					$tmp_name = $_FILES["attachment"]["tmp_name"];
					$profile = "uploads/keluhans/";
					$set_img = base_url()."uploads/keluhans/";


					$name = basename($_FILES["attachment"]["name"]);
					$newfilename = 'keluhans_'.round(microtime(true)).'.'.$ext;
					move_uploaded_file($tmp_name, $profile.$newfilename);
					$fname = $newfilename;			
				} else {
					$Return['error'] = $this->lang->line('umb_error_attatchment_type');
				}
			} else {
				$fname = '';
			}

			$data = array(
				'keluhan_dari' => $this->input->post('karyawan_id'),
				'perusahaan_id' => $this->input->post('perusahaan_id'),
				'title' => $this->input->post('title'),
				'description' => $qt_description,
				'attachment' => $fname,
				'tanggal_keluhan' => $this->input->post('tanggal_keluhan'),
				'keluhan_terhadap' => $keluhan_terhadap_ids,
				'created_at' => date('d-m-Y'),

			);
			$result = $this->Keluhans_model->add($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_keluhan_ditambahkan');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}


	public function update() {

		if($this->input->post('edit_type')=='keluhan') {

			$id = $this->uri->segment(4);

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$description = $this->input->post('description');
			$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);

			if($this->input->post('title')==='') {
				$Return['error'] = $this->lang->line('umb_error_title_keluhan');
			} else if($this->input->post('tanggal_keluhan')==='') {
				$Return['error'] = $this->lang->line('umb_error_tanggal_keluhan');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$data = array(
				'title' => $this->input->post('title'),
				'description' => $qt_description,
				'tanggal_keluhan' => $this->input->post('tanggal_keluhan'),
				'status' => $this->input->post('status'),
			);

			$result = $this->Keluhans_model->update_record($data,$id);		

			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_keluhan_diperbarui');
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
		$result = $this->Keluhans_model->delete_record($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('umb_sukses_keluhan_dihapus');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
	}
}
