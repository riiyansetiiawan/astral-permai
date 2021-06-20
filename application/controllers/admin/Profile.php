<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		
		$this->load->model("Karyawans_model");
		$this->load->model("Umb_model");
		$this->load->model("Department_model");
		$this->load->model("Penunjukan_model");
		$this->load->model("Roles_model");
		$this->load->model("Location_model");
		$this->load->model("Timesheet_model");
		$this->load->model("Awards_model");
		$this->load->model("Perjalanan_model");
		$this->load->model("Tickets_model");
		$this->load->model("Transfers_model");
		$this->load->model("Promotion_model");
		$this->load->model("Keluhans_model");
		$this->load->model("Peringatan_model");
		$this->load->model("Project_model");
		$this->load->model("Payroll_model");
		$this->load->model("Training_model");
		$this->load->model("Trainers_model");
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
		$result = $this->Karyawans_model->read_informasi_karyawan($session['user_id']);

		$penunjukan = $this->Penunjukan_model->read_informasi_penunjukan($result[0]->penunjukan_id);
		if(!is_null($penunjukan)){
			$enama_penunjukan = $penunjukan[0]->nama_penunjukan;
		} else {
			$enama_penunjukan = '--';	
		}
		$data = array(
			'first_name' => $result[0]->first_name,
			'last_name' => $result[0]->last_name,
			'penunjukan' => $enama_penunjukan,
			'user_id' => $result[0]->user_id,
			'karyawan_id' => $result[0]->karyawan_id,
			'username' => $result[0]->username,
			'email' => $result[0]->email,
			'department_id' => $result[0]->department_id,
			'penunjukan_id' => $result[0]->penunjukan_id,
			'user_role_id' => $result[0]->user_role_id,
			'tanggal_lahir' => $result[0]->tanggal_lahir,
			'date_of_leaving' => $result[0]->date_of_leaving,
			'jenis_kelamin' => $result[0]->jenis_kelamin,
			'status_perkawinan' => $result[0]->status_perkawinan,
			'no_kontak' => $result[0]->no_kontak,
			'type_upahh' => $result[0]->type_upahh,
			'gaji_pokok' => $result[0]->gaji_pokok,
			'alamat' => $result[0]->alamat,
			'is_active' => $result[0]->is_active,
			'tanggal_bergabung' => $result[0]->tanggal_bergabung,
			'all_departments' => $this->Department_model->all_departments(),
			'all_penunjukans' => $this->Penunjukan_model->all_penunjukans(),
			'all_user_roles' => $this->Roles_model->all_user_roles(),
			'title' => $this->lang->line('header_my_profile').' | '.$this->Umb_model->site_title(),
			'profile_picture' => $result[0]->profile_picture,
			'facebook_link' => $result[0]->facebook_link,
			'twitter_link' => $result[0]->twitter_link,
			'blogger_link' => $result[0]->blogger_link,
			'linkdedin_link' => $result[0]->linkdedin_link,
			'google_plus_link' => $result[0]->google_plus_link,
			'instagram_link' => $result[0]->instagram_link,
			'pinterest_link' => $result[0]->pinterest_link,
			'youtube_link' => $result[0]->youtube_link,
			'tanggal_terakhir_login' => $result[0]->tanggal_terakhir_login,
			'tanggal_terakhir_login' => $result[0]->tanggal_terakhir_login,
			'terakhir_login_ip' => $result[0]->terakhir_login_ip,
			'all_negaraa' => $this->Umb_model->get_negaraa(),
			'all_types_document' => $this->Karyawans_model->all_types_document(),
			'all_tingkat_pendidikan' => $this->Karyawans_model->all_tingkat_pendidikan(),
			'all_qualification_language' => $this->Karyawans_model->all_qualification_language(),
			'all_qualification_skill' => $this->Karyawans_model->all_qualification_skill(),
			'all_types_kontrak' => $this->Karyawans_model->all_types_kontrak(),
			'all_kontrakk' => $this->Karyawans_model->all_kontrakk(),
			'all_shifts_kantor' => $this->Karyawans_model->all_shifts_kantor(),
			'all_locations_kantor' => $this->Location_model->all_locations_kantor(),
			'all_types_cuti' => $this->Timesheet_model->all_types_cuti()
		);
		$data['breadcrumbs'] = $this->lang->line('header_my_profile');
		$data['path_url'] = 'profile';
		if(!empty($session)){ 
			$data['subview'] = $this->load->view("admin/karyawans/profile", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
		} else {
			redirect('hr/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}
	
	public function user_basic_info() {
		
		if($this->input->post('type')=='basic_info') {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
			$first_name = $this->Umb_model->clean_post($this->input->post('first_name'));
			$last_name = $this->Umb_model->clean_post($this->input->post('last_name'));
			$tanggal_lahir = $this->Umb_model->clean_date_post($this->input->post('tanggal_lahir'));
			$no_kontak = $this->Umb_model->clean_date_post($this->input->post('no_kontak'));
			$alamat = $this->Umb_model->clean_date_post($this->input->post('alamat'));
			
			
			if($this->input->post('first_name')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_first_name');
			} else if($first_name==='') {
				$Return['error'] = $this->lang->line('umb_hr_special_charactors_not_allowed');
			} /*else if(!preg_match("/^[a-zA-Z ]*$/",$first_name)) {
				$Return['error'] = $this->lang->line('umb_hr_string_error');
			}*/ else if($this->input->post('last_name')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_last_name');
			} else if($last_name==='') {
				$Return['error'] = $this->lang->line('umb_hr_special_charactors_not_allowed');
			} /*else if(!preg_match("/^[a-zA-Z ]*$/",$last_name)) {
				$Return['error'] = $this->lang->line('umb_hr_string_error');
			}*/ else if($this->input->post('tanggal_lahir')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_tanggal_bergabung');
			} else if($this->Umb_model->validate_date($this->input->post('tanggal_lahir'),'Y-m-d') == false) {
				$Return['error'] = $this->lang->line('umb_hr_date_format_error');
			} else if($this->input->post('email')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_email');
			} else if (!filter_var($this->input->post('email'), FILTER_VALIDATE_EMAIL)) {
				$Return['error'] = $this->lang->line('umb_karyawan_error_invalid_email');
			} else if($this->input->post('tanggal_lahir')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_tanggal_lahir');
			} else if($this->Umb_model->validate_date($this->input->post('tanggal_lahir'),'Y-m-d') == false) {
				$Return['error'] = $this->lang->line('umb_hr_date_format_error');
			} else if($this->input->post('no_kontak')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_nomor_kontak');
			} /*else if(!preg_match('/^([0-9]*)$/', $this->input->post('no_kontak'))) {
				$Return['error'] = $this->lang->line('umb_hr_numeric_error');
			}*/
			
			if($Return['error']!=''){
				$this->output($Return);
			}
			
			$data = array(
				'first_name' => $first_name,
				'last_name' => $last_name,
				'email' => $this->input->post('email'),
				'tanggal_lahir' => $tanggal_lahir,
				'jenis_kelamin' => $this->input->post('jenis_kelamin'),
				'status_perkawinan' => $this->input->post('status_perkawinan'),
				'no_kontak' => $no_kontak,
				'alamat' => $alamat
			);
			$id = $this->input->post('user_id');
			$result = $this->Karyawans_model->basic_info($data,$id);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_karyawan_basic_info_diperbarui');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function dialog_kontak() {
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('field_id');
		$result = $this->Karyawans_model->read_informasi_kontak($id);
		$data = array(
			'kontak_id' => $result[0]->kontak_id,
			'karyawan_id' => $result[0]->karyawan_id,
			'relation' => $result[0]->relation,
			'is_primary' => $result[0]->is_primary,
			'is_dependent' => $result[0]->is_dependent,
			'kontak_name' => $result[0]->kontak_name,
			'phone_kerja' => $result[0]->phone_kerja,
			'extension_phone_kerja' => $result[0]->extension_phone_kerja,
			'mobile_phone' => $result[0]->mobile_phone,
			'home_phone' => $result[0]->home_phone,
			'email_kerja' => $result[0]->email_kerja,
			'email_pribadi' => $result[0]->email_pribadi,
			'alamat_1' => $result[0]->alamat_1,
			'alamat_2' => $result[0]->alamat_2,
			'kota' => $result[0]->kota,
			'provinsi' => $result[0]->provinsi,
			'kode_pos' => $result[0]->kode_pos,
			'negara' => $result[0]->negara,
			'all_negaraa' => $this->Umb_model->get_negaraa()
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/karyawans/dialog_details_karyawan', $data);
		} else {
			redirect('admin/');
		}
	}
	
	public function kontaks() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/karyawans/profile", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$id = $this->uri->segment(4);
		$kontaks = $this->Karyawans_model->set_kontaks_karyawan($id);
		
		$data = array();

		foreach($kontaks->result() as $r) {
			
			if($r->is_primary==1){
				$primary = '<span class="badge badge-success">'.$this->lang->line('umb_karyawan_primary').'</span>';
			} else {
				$primary = '';
			}
			if($r->is_dependent==2){
				$dependent = '<span class="badge badge-red">'.$this->lang->line('umb_karyawan_dependent').'</span>';
			} else {
				$dependent = '';
			}
			
			$data[] = array(
				'<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->kontak_id . '" data-field_type="kontak"><i class="fas fa-pencil-alt"></i></button></span><span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->kontak_id . '" data-token_type="kontak"><i class="fas fa-trash-restore"></i></button></span>',
				$r->kontak_name . ' ' .$primary . ' '.$dependent,
				$r->relation,
				$r->email_kerja,
				$r->mobile_phone
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $kontaks->num_rows(),
			"recordsFiltered" => $kontaks->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}
	
	public function documents() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/karyawans/profile", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$id = $this->uri->segment(4);
		$documents = $this->Karyawans_model->set_documents_karyawan($id);
		
		$data = array();

		foreach($documents->result() as $r) {
			
			$d_type = $this->Karyawans_model->read_informasi_type_document($r->type_document_id);
			if(!is_null($d_type)){
				$document_d = $d_type[0]->type_document;
			} else {
				$document_d = '--';
			}
			$tanggal_kadaluarsa = $this->Umb_model->set_date_format($r->tanggal_kadaluarsa);
			if($r->document_file!='' && $r->document_file!='no file') {
				$functions = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_download').'"><a href="'.site_url().'download?type=document&filename='.$r->document_file.'"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light"><i class="oi oi-cloud-download"></i></button></a></span>';
			} else {
				$functions ='';
			}
			
			$data[] = array(
				$functions.'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->document_id . '" data-field_type="document"><i class="fas fa-pencil-alt-square-o"></i></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn btn-outline-danger btn-sm m-b-0-0 waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->document_id . '" data-token_type="document"><i class="fas fa-trash-restore-o"></i></button></span>',
				$document_d,
				$r->title,
				$tanggal_kadaluarsa,
				$r->description
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $documents->num_rows(),
			"recordsFiltered" => $documents->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}
	
	public function qualification() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/karyawans/profile", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$id = $this->uri->segment(4);
		$qualification = $this->Karyawans_model->set_qualification_karyawan($id);
		
		$data = array();

		foreach($qualification->result() as $r) {
			
			$pendidikan = $this->Karyawans_model->read_informasi_pendidikan($r->tingkat_pendidikan_id);
			if(!is_null($pendidikan)){
				$nama_pddkn = $pendidikan[0]->name;
			} else {
				$nama_pddkn = '--';	
			}
			$language = $this->Karyawans_model->read_informasi_qualification_language($r->language_id);
			if(!is_null($language)){
				$language_name = $language[0]->name;
			} else {
				$language_name = '--';	
			}
			$skill = $this->Karyawans_model->read_informasi_qualification_skill($r->skill_id);
			if(!is_null($skill)){
				$skill_name = $skill[0]->name;
			} else {
				$skill_name = '--';	
			}
			
			$data[] = array(
				'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->qualification_id . '" data-field_type="qualification"><i class="fas fa-pencil-alt-square-o"></i></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn btn-outline-danger btn-sm m-b-0-0 waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->qualification_id . '" data-token_type="qualification"><i class="fas fa-trash-restore-o"></i></button></span>',
				$r->name,
				$r->from_year,
				$r->to_year,
				$nama_pddkn,
				$language_name,
				$skill_name
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $qualification->num_rows(),
			"recordsFiltered" => $qualification->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}
	
	public function pengalaman() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/karyawans/profile", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$id = $this->uri->segment(4);
		$pengalaman = $this->Karyawans_model->set_pengalaman_karyawan($id);
		
		$data = array();

		foreach($pengalaman->result() as $r) {
			
			$from_date = $this->Umb_model->set_date_format($r->from_date);
			$to_date = $this->Umb_model->set_date_format($r->to_date);
			
			$data[] = array(
				'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->pengalaman_kerja_id . '" data-field_type="pengalaman_kerja"><i class="fas fa-pencil-alt-square-o"></i></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn btn-outline-danger btn-sm m-b-0-0 waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->pengalaman_kerja_id . '" data-token_type="pengalaman_kerja"><i class="fas fa-trash-restore-o"></i></button></span>',
				$r->nama_perusahaan,
				$from_date,
				$to_date,
				$r->post,
				$r->description
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $pengalaman->num_rows(),
			"recordsFiltered" => $pengalaman->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}
	

	public function bank_account() {
		//set data
		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/karyawans/profile", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$id = $this->uri->segment(4);
		$bank_account = $this->Karyawans_model->set_bank_account_karyawan($id);
		
		$data = array();

		foreach($bank_account->result() as $r) {			
			
			$data[] = array(
				'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->bankaccount_id . '" data-field_type="bank_account"><i class="fas fa-pencil-alt-square-o"></i></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn btn-outline-danger btn-sm m-b-0-0 waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->bankaccount_id . '" data-token_type="bank_account"><i class="fas fa-trash-restore-o"></i></button></span>',
				$r->account_title,
				$r->nomor_account,
				$r->nama_bank,
				$r->kode_bank,
				$r->cabang_bank
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $bank_account->num_rows(),
			"recordsFiltered" => $bank_account->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}
	

	public function kontrak() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/karyawans/profile", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$id = $this->uri->segment(4);
		$kontrak = $this->Karyawans_model->set_kontrak_karyawan($id);
		
		$data = array();

		foreach($kontrak->result() as $r) {			

			$penunjukan = $this->Penunjukan_model->read_informasi_penunjukan($r->penunjukan_id);
			if(!is_null($penunjukan)){
				$nama_penunjukan = $penunjukan[0]->nama_penunjukan;
			} else {
				$nama_penunjukan = '--';
			}
			//contract type
			$type_kontrak = $this->Karyawans_model->read_informasi_type_kontrak($r->type_kontrak_id);
			if(!is_null($type_kontrak)){
				$ctype = $type_kontrak[0]->name;
			} else {
				$ctype = '--';
			}
			$duration = $this->Umb_model->set_date_format($r->from_date).' '.$this->lang->line('dashboard_to').' '.$this->Umb_model->set_date_format($r->to_date);
			
			$data[] = array(
				$duration,
				$nama_penunjukan,
				$ctype,
				$r->title
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $kontrak->num_rows(),
			"recordsFiltered" => $kontrak->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}
	
	public function cuti() {
		//set data
		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/karyawans/profile", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$id = $this->uri->segment(4);
		$cuti = $this->Karyawans_model->set_karyawan_cuti($id);
		
		$data = array();

		foreach($cuti->result() as $r) {			

			$kontrak = $this->Karyawans_model->read_informasi_kontrak($r->kontrak_id);
			if(!is_null($kontrak)){
				$duration = $this->Umb_model->set_date_format($kontrak[0]->from_date).' '.$this->lang->line('dashboard_to').' '.$this->Umb_model->set_date_format($kontrak[0]->to_date);
				$ctitle = $kontrak[0]->title.' '.$duration;
			} else {
				$ctitle = '--';
			}
			
			$kontraki = $ctitle;
			
			
			$data[] = array(
				$kontraki,
				$r->casual_cuti,
				$r->medical_cuti
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $cuti->num_rows(),
			"recordsFiltered" => $cuti->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}
	
	public function shift() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/karyawans/profile", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$id = $this->uri->segment(4);
		$shift = $this->Karyawans_model->set_shift_karyawan($id);
		
		$data = array();

		foreach($shift->result() as $r) {			

			$info_shift = $this->Karyawans_model->read_infomasi_shift($r->shift_id);

			$duration = $this->Umb_model->set_date_format($r->from_date).' '.$this->lang->line('dashboard_to').' '.$this->Umb_model->set_date_format($r->to_date);
			if(!is_null($info_shift)){
				$nama_shift = $info_shift[0]->nama_shift;
			} else {
				$nama_shift = '--';
			}
			
			$data[] = array(
				$duration,
				$nama_shift
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $shift->num_rows(),
			"recordsFiltered" => $shift->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}
}