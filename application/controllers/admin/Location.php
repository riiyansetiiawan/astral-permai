<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Location extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		
		$this->load->model("Location_model");
		$this->load->model("Department_model");
		$this->load->model("Umb_model");
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
		$data['title'] = $this->lang->line('umb_negaraa').' | '.$this->Umb_model->site_title();
		$data['all_negaraa'] = $this->Umb_model->get_negaraa();
		$data['all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		$data['breadcrumbs'] = $this->lang->line('umb_negaraa');
		$data['path_url'] = 'location';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('6',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/location/list_location", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data);
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}

	public function list_location() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/location/list_location", $data);
		} else {
			redirect('admin/');
		}

		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		$role_resources_ids = $this->Umb_model->user_role_resource();
		$user_info = $this->Umb_model->read_user_info($session['user_id']);
		if($user_info[0]->user_role_id==1){
			$location = $this->Location_model->get_locations();
		} else {
			$location = $this->Location_model->get_perusahaan_location_kantor($user_info[0]->perusahaan_id);
		}
		$data = array();

		foreach($location->result() as $r) {

			$negara = $this->Umb_model->read_info_negara($r->negara);
			if(!is_null($negara)){
				$c_name = $negara[0]->nama_negara;
			} else {
				$c_name = '--';	
			}
			$perusahaan = $this->Umb_model->read_info_perusahaan($r->perusahaan_id);
			if(!is_null($perusahaan)){
				$prshn_nama = $perusahaan[0]->name;
			} else {
				$prshn_nama = '--';	
			}
			$user = $this->Umb_model->read_user_info($r->added_by);

			if(!is_null($user)){
				$full_name = $user[0]->first_name.' '.$user[0]->last_name;
			} else {
				$full_name = '--';	
			}
			$location_head = $this->Umb_model->read_user_info($r->location_head);
			if(!is_null($location_head)){
				$nama_head = $location_head[0]->first_name.' '.$location_head[0]->last_name;
			} else {
				$nama_head = '--';	
			}
			if(in_array('251',$role_resources_ids)) {
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target="#edit-modal-data"  data-location_id="'. $r->location_id . '"><span class="fas fa-pencil-alt"></span></button></span></span>';
			} else {
				$edit = '';
			}
			if(in_array('252',$role_resources_ids)) {
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->location_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}
			if(in_array('253',$role_resources_ids)) {
				$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target="#modals-slide" data-location_id="'. $r->location_id . '"><span class="fa fa-eye"></span></button></span>';
			} else {
				$view = '';
			}
			$nama_ilocation = $r->nama_location.'<br><small class="text-muted"><i>'.$this->lang->line('module_title_perusahaan').': '.$prshn_nama.'<i></i></i></small>';
			$combhr = $edit.$view.$delete;

			$data[] = array(
				$combhr,
				$nama_ilocation,
				$nama_head,
				$r->kota,
				$c_name,
				$full_name
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $location->num_rows(),
			"recordsFiltered" => $location->num_rows(),
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
			$this->load->view("admin/location/get_karyawans", $data);
		} else {
			redirect('admin/');
		}

		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}
	
	public function read() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('location_id');
		// $data['all_negaraa'] = $this->Umb_model->get_negaraa();
		$result = $this->Location_model->read_informasi_location($id);
		$data = array(
			'location_id' => $result[0]->location_id,
			'perusahaan_id' => $result[0]->perusahaan_id,
			'location_head' => $result[0]->location_head,
			'nama_location' => $result[0]->nama_location,
			'email' => $result[0]->email,
			'phone' => $result[0]->phone,
			'fax' => $result[0]->fax,
			'alamat_1' => $result[0]->alamat_1,
			'alamat_2' => $result[0]->alamat_2,
			'kota' => $result[0]->kota,
			'provinsi' => $result[0]->provinsi,
			'kode_pos' => $result[0]->kode_pos,
			'negaraid' => $result[0]->negara,
			'all_negaraa' => $this->Umb_model->get_negaraa(),
			'all_perusahaans' => $this->Umb_model->get_perusahaans(),
			'all_karyawans' => $this->Umb_model->all_karyawans()
		);
		if(!empty($session)){ 
			$this->load->view('admin/location/dialog_location', $data);
		} else {
			redirect('admin/');
		}
	}
	
	public function read_info() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('location_id');
       // $data['all_negaraa'] = $this->Umb_model->get_negaraa();
		$result = $this->Location_model->read_informasi_location($id);
		$data = array(
			'location_id' => $result[0]->location_id,
			'perusahaan_id' => $result[0]->perusahaan_id,
			'location_head' => $result[0]->location_head,
			'nama_location' => $result[0]->nama_location,
			'email' => $result[0]->email,
			'phone' => $result[0]->phone,
			'fax' => $result[0]->fax,
			'alamat_1' => $result[0]->alamat_1,
			'alamat_2' => $result[0]->alamat_2,
			'kota' => $result[0]->kota,
			'provinsi' => $result[0]->provinsi,
			'kode_pos' => $result[0]->kode_pos,
			'negaraid' => $result[0]->negara,
			'all_negaraa' => $this->Umb_model->get_negaraa(),
			'all_perusahaans' => $this->Umb_model->get_perusahaans(),
			'all_karyawans' => $this->Umb_model->all_karyawans()
		);
		if(!empty($session)){ 
			$this->load->view('admin/location/view_location', $data);
		} else {
			redirect('admin/');
		}
	}
	
	public function add_location() {
		
		if($this->input->post('add_type')=='location') {
			$this->form_validation->set_rules('perusahaan', 'Perusahaan', 'trim|required|xss_clean');
			$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
			if($this->input->post('perusahaan')==='') {
				$Return['error'] = $this->lang->line('error_field_perusahaan');
			} else if($this->input->post('name')==='') {
				$Return['error'] = $this->lang->line('umb_error_field_nama');
			} else if($this->input->post('kota')==='') {
				$Return['error'] = $this->lang->line('umb_error_field_kota');
			} else if($this->input->post('negara')==='') {
				$Return['error'] = $this->lang->line('umb_error_field_negara');
			}
			
			if($Return['error']!=''){
				$this->output($Return);
			}
			
			$data = array(
				'perusahaan_id' => $this->input->post('perusahaan'),
				'nama_location' => $this->input->post('name'),
				'location_head' => $this->input->post('location_head'),
				'email' => $this->input->post('email'),
				'phone' => $this->input->post('phone'),
				'fax' => $this->input->post('fax'),
				'alamat_1' => $this->input->post('alamat_1'),
				'alamat_2' => $this->input->post('alamat_2'),
				'kota' => $this->input->post('kota'),
				'provinsi' => $this->input->post('provinsi'),
				'kode_pos' => $this->input->post('kode_pos'),
				'negara' => $this->input->post('negara'),
				'added_by' => $this->input->post('user_id'),
				'created_at' => date('d-m-Y'),
				
			);
			$result = $this->Location_model->add($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_tambah_location');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function update() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		if($this->input->post('edit_type')=='location') {
			
			$id = $this->uri->segment(4);
			
			$this->form_validation->set_rules('perusahaan', 'Perusahaan', 'trim|required|xss_clean');
			$this->form_validation->set_rules('name', 'Nama', 'trim|required|xss_clean');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
			if($this->input->post('perusahaan')==='') {
				$Return['error'] = $this->lang->line('error_field_perusahaan');
			} else if($this->input->post('name')==='') {
				$Return['error'] = $this->lang->line('umb_error_field_nama');
			} else if($this->input->post('kota')==='') {
				$Return['error'] = $this->lang->line('umb_error_field_kota');
			} else if($this->input->post('negara')==='') {
				$Return['error'] = $this->lang->line('umb_error_field_negara');
			}
			
			if($Return['error']!=''){
				$this->output($Return);
			}
			
			$data = array(
				'perusahaan_id' => $this->input->post('perusahaan'),
				'nama_location' => $this->input->post('name'),
				'location_head' => $this->input->post('location_head'),
				'email' => $this->input->post('email'),
				'phone' => $this->input->post('phone'),
				'fax' => $this->input->post('fax'),
				'alamat_1' => $this->input->post('alamat_1'),
				'alamat_2' => $this->input->post('alamat_2'),
				'kota' => $this->input->post('kota'),
				'provinsi' => $this->input->post('provinsi'),
				'kode_pos' => $this->input->post('kode_pos'),
				'negara' => $this->input->post('negara'),		
			);	
			
			$result = $this->Location_model->update_record($data,$id);		
			
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_perbarui_location');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function delete() {

		if($this->input->post('is_ajax')==2) {
			$session = $this->session->userdata('username');
			if(empty($session)){ 
				redirect('admin/');
			}
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Location_model->delete_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_sukses_hapus_location');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}
}
