<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Promotion extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		
		$this->load->model("Promotion_model");
		$this->load->model("Umb_model");
		$this->load->model("Department_model");
		$this->load->model("Penunjukan_model");
		$this->load->model("Karyawans_model");
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
		$data['title'] = $this->lang->line('left_promotions').' | '.$this->Umb_model->site_title();
		$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		$data['get_all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$data['breadcrumbs'] = $this->lang->line('left_promotions');
		$data['path_url'] = 'promotion';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('18',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/promotion/list_promotion", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}
	
	public function list_promotion() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/promotion/list_promotion", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$role_resources_ids = $this->Umb_model->user_role_resource();
		$user_info = $this->Umb_model->read_user_info($session['user_id']);
		if($user_info[0]->user_role_id==1){
			$promotion = $this->Promotion_model->get_promotions();
		} else {
			if(in_array('236',$role_resources_ids)) {
				$promotion = $this->Promotion_model->get_perusahaan_promotions($user_info[0]->perusahaan_id);
			} else {
				$promotion = $this->Promotion_model->get_karyawan_promotions($session['user_id']);
			}
		}
		$data = array();

		foreach($promotion->result() as $r) {
			
			$karyawan = $this->Umb_model->read_user_info($r->karyawan_id);

			if(!is_null($karyawan)){
				$nama_karyawan = $karyawan[0]->first_name.' '.$karyawan[0]->last_name;
			} else {
				$nama_karyawan = '--';	
			}

			$perusahaan = $this->Umb_model->read_info_perusahaan($r->perusahaan_id);
			if(!is_null($perusahaan)){
				$prshn_nama = $perusahaan[0]->name;
			} else {
				$prshn_nama = '--';	
			}

			$penunjukan = $this->Penunjukan_model->read_informasi_penunjukan($r->penunjukan_id);
			if(!is_null($penunjukan)){
				$nama_penunjukan = $penunjukan[0]->nama_penunjukan;
			} else {
				$nama_penunjukan = '--';	
			}

			$tanggal_promotion = $this->Umb_model->set_date_format($r->tanggal_promotion);
			if(in_array('220',$role_resources_ids)) {
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-promotion_id="'. $r->promotion_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('221',$role_resources_ids)) {
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->promotion_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}
			if(in_array('236',$role_resources_ids)) {
				$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target="#modals-slide" data-promotion_id="'. $r->promotion_id . '"><span class="fa fa-eye"></span></button></span>';
			} else {
				$view = '';
			}
			$combhr = $edit.$view.$delete;
			$pro_desc = $nama_karyawan.'<br><small class="text-muted"><i>'.$this->lang->line('umb_description').': '.$r->description.'<i></i></i></small>';
			$promoted_to = $r->title.'<br><small class="text-muted"><i>'.$this->lang->line('umb_promoted_to_title').': '.$nama_penunjukan.'<i></i></i></small>';
			$data[] = array(
				$combhr,
				$pro_desc,
				$prshn_nama,
				$promoted_to,
				$tanggal_promotion
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $promotion->num_rows(),
			"recordsFiltered" => $promotion->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}
	
	public function get_karyawans() {

		$data['title'] = $this->Umb_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'perusahaan_id' => $id
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/promotion/get_karyawans", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}

	public function get_karyawan_penunjukans() {

		$data['title'] = $this->Umb_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'karyawan_id' => $id
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/promotion/get_penunjukans", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}
	
	public function read() {
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('promotion_id');
		$result = $this->Promotion_model->read_informasi_promotion($id);

		$penunjukan = $this->Penunjukan_model->read_informasi_penunjukan($result[0]->penunjukan_id);
		if(!is_null($penunjukan)){
			$nama_penunjukan = $penunjukan[0]->nama_penunjukan;
		} else {
			$nama_penunjukan = '--';	
		}
		$data = array(
			'promotion_id' => $result[0]->promotion_id,
			'perusahaan_id' => $result[0]->perusahaan_id,
			'karyawan_id' => $result[0]->karyawan_id,
			'nama_penunjukan' => $nama_penunjukan,
			'title' => $result[0]->title,
			'tanggal_promotion' => $result[0]->tanggal_promotion,
			'description' => $result[0]->description,
			'get_all_perusahaans' => $this->Umb_model->get_perusahaans(),
			'all_karyawans' => $this->Umb_model->all_karyawans()
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/promotion/dialog_promotion', $data);
		} else {
			redirect('admin/');
		}
	}
	
	public function add_promotion() {
		
		if($this->input->post('add_type')=='promotion') {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
			$description = $this->input->post('description');
			$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
			
			if($this->input->post('perusahaan_id')==='') {
				$Return['error'] = $this->lang->line('error_field_perusahaan');
			} else if($this->input->post('karyawan_id')==='') {
				$Return['error'] = $this->lang->line('umb_error_karyawan_id');
			} else if($this->input->post('penunjukan_id')==='') {
				$Return['error'] = $this->lang->line('umb_error_field_penunjukan');
			} else if($this->input->post('title')==='') {
				$Return['error'] = $this->lang->line('umb_error_title');
			} else if($this->input->post('tanggal_promotion')==='') {
				$Return['error'] = $this->lang->line('umb_error_tanggal_promotion');
			}
			
			if($Return['error']!=''){
				$this->output($Return);
			}
			
			$data = array(
				'karyawan_id' => $this->input->post('karyawan_id'),
				'perusahaan_id' => $this->input->post('perusahaan_id'),
				'penunjukan_id' => $this->input->post('penunjukan_id'),
				'title' => $this->input->post('title'),
				'tanggal_promotion' => $this->input->post('tanggal_promotion'),
				'description' => $qt_description,
				'added_by' => $this->input->post('user_id'),
				'created_at' => date('d-m-Y'),
			);
			$result = $this->Promotion_model->add($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_promotion_ditambahkan');
				$user_data = array(
					'penunjukan_id' => $this->input->post('penunjukan_id'),
				);
				$user_info = $this->Karyawans_model->basic_info($user_data,$this->input->post('karyawan_id'));
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function update() {
		
		if($this->input->post('edit_type')=='promotion') {
			
			$id = $this->uri->segment(4);
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
			$description = $this->input->post('description');
			$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
			
			if($this->input->post('title')==='') {
				$Return['error'] = $this->lang->line('umb_error_title');
			} else if($this->input->post('tanggal_promotion')==='') {
				$Return['error'] = $this->lang->line('umb_error_tanggal_promotion');
			}
			
			if($Return['error']!=''){
				$this->output($Return);
			}
			
			$data = array(
				'title' => $this->input->post('title'),
				'tanggal_promotion' => $this->input->post('tanggal_promotion'),
				'description' => $qt_description,		
			);
			
			$result = $this->Promotion_model->update_record($data,$id);		
			
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_promotion_diperbarui');
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
		$result = $this->Promotion_model->delete_record($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('umb_promotion_dihapus');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
	}
}
