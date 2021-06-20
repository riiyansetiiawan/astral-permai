<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Karyawans extends MY_Controller {

	public function __construct() {
		parent::__construct();
		s
		$this->load->model("Karyawans_model");
		$this->load->model("Umb_model");
		$this->load->model("Department_model");
		$this->load->model("Penunjukan_model");
		$this->load->model("Roles_model");
		$this->load->model("Location_model");
		$this->load->model("Perusahaan_model");
		$this->load->model("Timesheet_model");
		$this->load->library("pagination");
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
		$data['title'] = $this->lang->line('umb_karyawans').' | '.$this->Umb_model->site_title();
		$data['all_departments'] = $this->Department_model->all_departments();
		$data['all_penunjukans'] = $this->Penunjukan_model->all_penunjukans();
		$data['all_user_roles'] = $this->Roles_model->all_user_roles();
		$data['all_shifts_kantor'] = $this->Karyawans_model->all_shifts_kantor();
		$data['get_all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$data['all_types_cuti'] = $this->Timesheet_model->all_types_cuti();
		$data['breadcrumbs'] = $this->lang->line('umb_karyawans');
		$data['path_url'] = 'karyawans';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('13',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/karyawans/list_karyawans", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}
	
	public function hr() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('umb_directory_karyawans').' | '.$this->Umb_model->site_title();
		$data['all_departments'] = $this->Department_model->all_departments();
		$data['all_penunjukans'] = $this->Penunjukan_model->all_penunjukans();
		$data['all_user_roles'] = $this->Roles_model->all_user_roles();
		$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		$data['breadcrumbs'] = $this->lang->line('umb_directory_karyawans');
		$data['path_url'] = 'directory_karyawans';
		
		$config = array();
		$limit_per_page = 20;
		$page = ($this->uri->segment(4)) ? ($this->uri->segment(4) - 1) : 0;
		$total_records = $this->Karyawans_model->record_count();

		$data["results"] = $this->Karyawans_model->fetch_all_karyawans($limit_per_page, $page*$limit_per_page);
		
		$config['base_url'] = site_url() . "admin/karyawans/hr";
		$config['total_rows'] = $total_records;
		$config['per_page'] = $limit_per_page;
		$config["uri_segment"] = 4;
		// $config['num_links'] = 2;
		$config['use_page_numbers'] = TRUE;
		$config['reuse_query_string'] = FALSE;
		//$config['page_query_string'] = TRUE;
		//$config['use_page_numbers'] = TRUE;
		$config['num_links'] = $total_records;
		$config['cur_tag_open'] = '&nbsp;<a>';
		$config['cur_tag_close'] = '</a>';
		$config['next_link'] = '»';
		$config['prev_link'] = '«';
		
		$this->pagination->initialize($config);
		//$data["links"] = $this->pagination->create_links();
		$str_links = $this->pagination->create_links();
		$data["links"] = explode('&nbsp;',$str_links );
		
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('88',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/karyawans/directory", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
		} else {
			redirect('admin/dashboard');
		}	  
	} 
	
	public function list_karyawans() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/karyawans/list_karyawans", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$role_resources_ids = $this->Umb_model->user_role_resource();		
		
		$karyawan = $this->Karyawans_model->get_karyawans();
		
		$data = array();

		foreach($karyawan->result() as $r) {		  
			
			$perusahaan = $this->Umb_model->read_info_perusahaan($r->perusahaan_id);
			if(!is_null($perusahaan)){
				$prshn_nama = $perusahaan[0]->name;
			} else {
				$prshn_nama = '--';	
			}
			
			$full_name = $r->first_name.' '.$r->last_name;				

			if($r->is_active==0): 
				$status = $this->lang->line('umb_karyawans_inactive');
			elseif($r->is_active==1): 
				$status = $this->lang->line('umb_karyawans_active'); 
			endif;

			$role = $this->Umb_model->read_user_role_info($r->user_role_id);
			if(!is_null($role)){
				$role_name = $role[0]->role_name;
			} else {
				$role_name = '--';	
			}

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

			if($r->user_id != '1') {
				if(in_array('203',$role_resources_ids)) {
					$del_opt = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->user_id . '"><span class="fas fa-trash-restore"></span></button></span>';
				} else {
					$del_opt = '';
				}
			} else {
				$del_opt = '';
			}
			if(in_array('202',$role_resources_ids)) {
				$view_opt = ' <span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_view_details').'"><a href="'.site_url().'admin/karyawans/detail/'.$r->user_id.'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span>';
			} else {
				$view_opt = '';
			}
			$function = $view_opt.$del_opt.'';

			$data[] = array(
				$function,
				$r->karyawan_id,
				$full_name,
				$prshn_nama,
				$r->username,
				$r->email,
				$role_name,
				$department_penunjukan,
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

	public function list_karyawans_card() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/karyawans/list_karyawans", $data);
		} else {
			redirect('admin/');
		}

		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		$karyawan = $this->Karyawans_model->get_karyawans();
		$negaraa = $this->Umb_model->get_negaraa();

		$data = array();
		$function = '<table>';
		foreach (array_chunk($negaraa, 4) as $row) {		  
			$function .= '<tr>';
			foreach ($row as $value) {
				$function .='<td>
				<div class="col-xl-12 col-md-12 col-xs-12">
				<div class="card">
				<div class="text-xs-center">
				<div class="card-block">
				<img src="'.base_url().'skin/app-assets/images/portrait/medium/avatar-m-4.png" class="rounded-circle  height-150" alt="Card image">
				</div>
				<div class="card-block">
				<h4 class="card-title">asddd</h4>
				<h6 class="card-subtitle text-muted">asddd</h6>
				</div>
				<div class="text-xs-center">
				<a href="#" class="btn btn-social-icon mr-1 mb-1 btn-outline-facebook"><span class="fa fa-facebook"></span></a>
				<a href="#" class="btn btn-social-icon mr-1 mb-1 btn-outline-twitter"><span class="fa fa-twitter"></span></a>
				<a href="#" class="btn btn-social-icon mb-1 btn-outline-linkedin"><span class="fa fa-linkedin font-medium-4"></span></a>
				</div>
				</div>
				</div>
				</div>
				</td>';	
				$function .='</tr>';
			}	
			$data[] = array(
				$function
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

	public function detail() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$id = $this->uri->segment(4);
		$result = $this->Karyawans_model->read_informasi_karyawan($id);
		if(is_null($result)){
			redirect('admin/karyawans');
		}
		$role_resources_ids = $this->Umb_model->user_role_resource();
		$check_role = $this->Karyawans_model->read_informasi_karyawan($session['user_id']);
		if(!in_array('202',$role_resources_ids)) {
			redirect('admin/karyawans');
		}
		/*if($check_role[0]->user_id!=$result[0]->user_id) {
			redirect('admin/karyawans');
		}*/
		$role_resources_ids = $this->Umb_model->user_role_resource();
		$data['breadcrumbs'] = $this->lang->line('umb_details_karyawan');
		$data['path_url'] = 'detail_karyawans';	

		$data = array(
			'breadcrumbs' => $this->lang->line('umb_detail_karyawan'),
			'path_url' => 'detail_karyawans',
			'first_name' => $result[0]->first_name,
			'last_name' => $result[0]->last_name,
			'user_id' => $result[0]->user_id,
			'karyawan_id' => $result[0]->karyawan_id,
			'perusahaan_id' => $result[0]->perusahaan_id,
			'shift_kantor_id' => $result[0]->shift_kantor_id,
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
			'alamat' => $result[0]->alamat,
			'type_upahh' => $result[0]->type_upahh,
			'gaji_pokok' => $result[0]->gaji_pokok,
			'upahh_harian' => $result[0]->upahh_harian,
			'gaji_ssempee' => $result[0]->gaji_ssempee,
			'gaji_ssempeer' => $result[0]->gaji_ssempeer,
			'gaji_pajak_pendapatan' => $result[0]->gaji_pajak_pendapatan,
			'gaji_lembur' => $result[0]->gaji_lembur,
			'gaji_komisi' => $result[0]->gaji_komisi,
			'claims_gaji' => $result[0]->claims_gaji,
			'gaji_bayar_cuti' => $result[0]->gaji_bayar_cuti,
			'gaji_director_fees' => $result[0]->gaji_director_fees,
			'gaji_bonus' => $result[0]->gaji_bonus,
			'bayar_gaji_advance' => $result[0]->bayar_gaji_advance,
			'is_active' => $result[0]->is_active,
			'tanggal_bergabung' => $result[0]->tanggal_bergabung,
			'all_departments' => $this->Department_model->all_departments(),
			'all_penunjukans' => $this->Penunjukan_model->all_penunjukans(),
			'all_user_roles' => $this->Roles_model->all_user_roles(),
			'title' => $this->lang->line('umb_detail_karyawan').' | '.$this->Umb_model->site_title(),
			'profile_picture' => $result[0]->profile_picture,
			'facebook_link' => $result[0]->facebook_link,
			'twitter_link' => $result[0]->twitter_link,
			'blogger_link' => $result[0]->blogger_link,
			'linkdedin_link' => $result[0]->linkdedin_link,
			'google_plus_link' => $result[0]->google_plus_link,
			'instagram_link' => $result[0]->instagram_link,
			'pinterest_link' => $result[0]->pinterest_link,
			'youtube_link' => $result[0]->youtube_link,
			'kategoris_cuti' => $result[0]->kategoris_cuti,
			'all_negaraa' => $this->Umb_model->get_negaraa(),
			'all_types_document' => $this->Karyawans_model->all_types_document(),
			'all_tingkat_pendidikan' => $this->Karyawans_model->all_tingkat_pendidikan(),
			'all_qualification_language' => $this->Karyawans_model->all_qualification_language(),
			'all_qualification_skill' => $this->Karyawans_model->all_qualification_skill(),
			'all_types_kontrak' => $this->Karyawans_model->all_types_kontrak(),
			'all_kontrakk' => $this->Karyawans_model->all_kontrakk(),
			'all_shifts_kantor' => $this->Karyawans_model->all_shifts_kantor(),
			'get_all_perusahaans' => $this->Umb_model->get_perusahaans(),
			'all_locations_kantor' => $this->Location_model->all_locations_kantor(),
			'all_types_cuti' => $this->Timesheet_model->all_types_cuti(),
		);
		
		$data['subview'] = $this->load->view("admin/karyawans/detail_karyawan", $data, TRUE);
		$this->load->view('admin/layout/layout_main', $data); 
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}
	
	public function get_departments() {

		$data['title'] = $this->Umb_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'perusahaan_id' => $id
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/karyawans/get_departments", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	} 
	
	public function dialog_kontak() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
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
			'inegara' => $result[0]->negara,
			'all_negaraa' => $this->Umb_model->get_negaraa()
		);
		if(!empty($session)){ 
			$this->load->view('admin/karyawans/dialog_details_karyawan', $data);
		} else {
			redirect('admin/');
		}
	}
	
	public function dialog_document() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('field_id');
		$document = $this->Karyawans_model->read_informasi_document($id);
		$data = array(
			'document_id' => $document[0]->document_id,
			'type_document_id' => $document[0]->type_document_id,
			'd_karyawan_id' => $document[0]->karyawan_id,
			'all_types_document' => $this->Karyawans_model->all_types_document(),
			'tanggal_kadaluarsa' => $document[0]->tanggal_kadaluarsa,
			'title' => $document[0]->title,
			'is_alert' => $document[0]->is_alert,
			'description' => $document[0]->description,
			'notification_email' => $document[0]->notification_email,
			'document_file' => $document[0]->document_file
		);
		if(!empty($session)){ 
			$this->load->view('admin/karyawans/dialog_details_karyawan', $data);
		} else {
			redirect('admin/');
		}
	}
	
	public function dialog_imgdocument() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('field_id');
		$document = $this->Karyawans_model->read_informasi_imgdocument($id);
		$data = array(
			'immigration_id' => $document[0]->immigration_id,
			'type_document_id' => $document[0]->type_document_id,
			'd_karyawan_id' => $document[0]->karyawan_id,
			'all_types_document' => $this->Karyawans_model->all_types_document(),
			'all_negaraa' => $this->Umb_model->get_negaraa(),
			'nomor_document' => $document[0]->nomor_document,
			'document_file' => $document[0]->document_file,
			'tanggal_terbit' => $document[0]->tanggal_terbit,
			'tanggal_kaaluarsa' => $document[0]->tanggal_kaaluarsa,
			'negara_id' => $document[0]->negara_id,
			'tanggal_tinjauan_yang_memenuhi_syarat' => $document[0]->tanggal_tinjauan_yang_memenuhi_syarat,
		);
		if(!empty($session)){ 
			$this->load->view('admin/karyawans/dialog_details_karyawan', $data);
		} else {
			redirect('admin/');
		}
	}
	
	public function dialog_qualification() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('field_id');
		$result = $this->Karyawans_model->read_informasi_qualification($id);
		$data = array(
			'qualification_id' => $result[0]->qualification_id,
			'karyawan_id' => $result[0]->karyawan_id,
			'name' => $result[0]->name,
			'tingkat_pendidikan_id' => $result[0]->tingkat_pendidikan_id,
			'from_year' => $result[0]->from_year,
			'language_id' => $result[0]->language_id,
			'to_year' => $result[0]->to_year,
			'skill_id' => $result[0]->skill_id,
			'description' => $result[0]->description,
			'all_tingkat_pendidikan' => $this->Karyawans_model->all_tingkat_pendidikan(),
			'all_qualification_language' => $this->Karyawans_model->all_qualification_language(),
			'all_qualification_skill' => $this->Karyawans_model->all_qualification_skill()
		);
		if(!empty($session)){ 
			$this->load->view('admin/karyawans/dialog_details_karyawan', $data);
		} else {
			redirect('admin/');
		}
	}

	public function dialog_pengalaman_kerja() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('field_id');
		$result = $this->Karyawans_model->read_informasi_pengalaman_kerja($id);
		$data = array(
			'pengalaman_kerja_id' => $result[0]->pengalaman_kerja_id,
			'karyawan_id' => $result[0]->karyawan_id,
			'nama_perusahaan' => $result[0]->nama_perusahaan,
			'from_date' => $result[0]->from_date,
			'to_date' => $result[0]->to_date,
			'post' => $result[0]->post,
			'description' => $result[0]->description
		);
		if(!empty($session)){ 
			$this->load->view('admin/karyawans/dialog_details_karyawan', $data);
		} else {
			redirect('admin/');
		}
	}
	
	public function dialog_bank_account() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('field_id');
		$result = $this->Karyawans_model->read_informasi_bank_account($id);
		$data = array(
			'bankaccount_id' => $result[0]->bankaccount_id,
			'karyawan_id' => $result[0]->karyawan_id,
			'is_primary' => $result[0]->is_primary,
			'account_title' => $result[0]->account_title,
			'nomor_account' => $result[0]->nomor_account,
			'nama_bank' => $result[0]->nama_bank,
			'kode_bank' => $result[0]->kode_bank,
			'cabang_bank' => $result[0]->cabang_bank
		);
		if(!empty($session)){ 
			$this->load->view('admin/karyawans/dialog_details_karyawan', $data);
		} else {
			redirect('admin/');
		}
	}
	
	public function dialog_kontrak() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('field_id');
		$result = $this->Karyawans_model->read_informasi_kontrak($id);
		$data = array(
			'kontrak_id' => $result[0]->kontrak_id,
			'karyawan_id' => $result[0]->karyawan_id,
			'type_kontrak_id' => $result[0]->type_kontrak_id,
			'from_date' => $result[0]->from_date,
			'penunjukan_id' => $result[0]->penunjukan_id,
			'title' => $result[0]->title,
			'to_date' => $result[0]->to_date,
			'description' => $result[0]->description,
			'all_types_kontrak' => $this->Karyawans_model->all_types_kontrak(),
			'all_penunjukans' => $this->Penunjukan_model->all_penunjukans(),
		);
		if(!empty($session)){ 
			$this->load->view('admin/karyawans/dialog_details_karyawan', $data);
		} else {
			redirect('admin/');
		}
	}
	
	public function dialog_cuti() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('field_id');
		$result = $this->Karyawans_model->read_informasi_cuti($id);
		$data = array(
			'cuti_id' => $result[0]->cuti_id,
			'karyawan_id' => $result[0]->karyawan_id,
			'kontrak_id' => $result[0]->kontrak_id,
			'casual_cuti' => $result[0]->casual_cuti,
			'medical_cuti' => $result[0]->medical_cuti
		);
		if(!empty($session)){ 
			$this->load->view('admin/karyawans/dialog_details_karyawan', $data);
		} else {
			redirect('admin/');
		}
	}
	
	public function dialog_shift() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('field_id');
		$result = $this->Karyawans_model->read_informasi_shift_krywn($id);
		$data = array(
			'emp_shift_id' => $result[0]->emp_shift_id,
			'karyawan_id' => $result[0]->karyawan_id,
			'shift_id' => $result[0]->shift_id,
			'from_date' => $result[0]->from_date,
			'to_date' => $result[0]->to_date
		);
		if(!empty($session)){ 
			$this->load->view('admin/karyawans/dialog_details_karyawan', $data);
		} else {
			redirect('admin/');
		}
	}
	
	public function dialog_location() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('field_id');
		$result = $this->Karyawans_model->read_informasi_location($id);
		$data = array(
			'location_kantor_id' => $result[0]->location_kantor_id,
			'karyawan_id' => $result[0]->karyawan_id,
			'location_id' => $result[0]->location_id,
			'from_date' => $result[0]->from_date,
			'to_date' => $result[0]->to_date
		);
		if(!empty($session)){ 
			$this->load->view('admin/karyawans/dialog_details_karyawan', $data);
		} else {
			redirect('admin/');
		}
	}
	
	public function dialog_gaji_tunjanagan() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('field_id');
		$result = $this->Karyawans_model->read_single_gaji_tunjanagan($id);
		$data = array(
			'tunjanagan_id' => $result[0]->tunjanagan_id,
			'karyawan_id' => $result[0]->karyawan_id,
			'title_tunjanagan' => $result[0]->title_tunjanagan,
			'jumlah_tunjanagan' => $result[0]->jumlah_tunjanagan
		);
		if(!empty($session)){ 
			$this->load->view('admin/karyawans/dialog_details_karyawan', $data);
		} else {
			redirect('admin/');
		}
	}
	
	public function dialog_gaji_pinjaman() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('field_id');
		$result = $this->Karyawans_model->read_single_potongans_pinjaman($id);
		$data = array(
			'potongan_pinjaman_id' => $result[0]->potongan_pinjaman_id,
			'karyawan_id' => $result[0]->karyawan_id,
			'title_potongan_pinjaman' => $result[0]->title_potongan_pinjaman,
			'start_date' => $result[0]->start_date,
			'end_date' => $result[0]->end_date,
			'angsuran_bulanan' => $result[0]->angsuran_bulanan,
			'reason' => $result[0]->reason,
			'created_at' => $result[0]->created_at
		);
		if(!empty($session)){ 
			$this->load->view('admin/karyawans/dialog_details_karyawan', $data);
		} else {
			redirect('admin/');
		}
	}

	public function dialog_krywn_lembur() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('field_id');
		$result = $this->Karyawans_model->read_record_gaji_lembur($id);
		$data = array(
			'gaji_lembur_id' => $result[0]->gaji_lembur_id,
			'karyawan_id' => $result[0]->karyawan_id,
			'type_lembur' => $result[0]->type_lembur,
			'no_of_days' => $result[0]->no_of_days,
			'jam_lembur' => $result[0]->jam_lembur,
			'nilai_lembur' => $result[0]->nilai_lembur
		);
		if(!empty($session)){ 
			$this->load->view('admin/karyawans/dialog_details_karyawan', $data);
		} else {
			redirect('admin/');
		}
	}
	
	public function penunjukan() {

		$data['title'] = $this->Umb_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'department_id' => $id,
			'all_penunjukans' => $this->Penunjukan_model->all_penunjukans(),
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/karyawans/get_penunjukans", $data);
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
		$id = $this->input->get('peringatan_id');
		$result = $this->Peringatan_model->read_informasi_peringatan($id);
		$data = array(
			'peringatan_id' => $result[0]->peringatan_id,
			'peringatan_ke' => $result[0]->peringatan_ke,
			'peringatan_oleh' => $result[0]->peringatan_oleh,
			'tanggal_peringatan' => $result[0]->tanggal_peringatan,
			'type_peringatan_id' => $result[0]->type_peringatan_id,
			'subject' => $result[0]->subject,
			'description' => $result[0]->description,
			'status' => $result[0]->status,
			'all_karyawans' => $this->Umb_model->all_karyawans(),
			'all_types_peringatan' => $this->Peringatan_model->all_types_peringatan(),
		);
		if(!empty($session)){ 
			$this->load->view('admin/peringatan/dialog_peringatan', $data);
		} else {
			redirect('admin/');
		}
	}
	
	
	public function add_karyawan() {
		
		if($this->input->post('add_type')=='karyawan') {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();		
			

			if($this->input->post('first_name')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_first_name');
			} else if(preg_match("/^(\pL{1,}[ ]?)+$/u",$this->input->post('first_name'))!=1) {
				$Return['error'] = $this->lang->line('umb_hr_string_error');
			} else if($this->input->post('last_name')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_last_name');
			} else if(preg_match("/^(\pL{1,}[ ]?)+$/u",$this->input->post('last_name'))!=1) {
				$Return['error'] = $this->lang->line('umb_hr_string_error');
			}else if($this->input->post('karyawan_id')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_karyawan_id');
			} else if($this->input->post('tanggal_bergabung')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_tanggal_bergabung');
			} else if($this->Umb_model->validate_date($this->input->post('tanggal_bergabung'),'Y-m-d') == false) {
				$Return['error'] = $this->lang->line('umb_hr_date_format_error');
			} else if($this->input->post('perusahaan_id')==='') {
				$Return['error'] = $this->lang->line('error_field_perusahaan');
			} else if($this->input->post('department_id')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_department');
			} else if($this->input->post('penunjukan_id')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_penunjukan');
			} else if($this->input->post('role')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_user_role');
			} else if($this->input->post('username')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_username');
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
			} else if(!preg_match('/^([0-9]*)$/', $this->input->post('no_kontak'))) {
				$Return['error'] = $this->lang->line('umb_hr_numeric_error');
			} else if($this->input->post('password')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_password');
			} else if(strlen($this->input->post('password')) < 6) {
				$Return['error'] = $this->lang->line('umb_karyawan_error_password_least');
			} else if($this->input->post('password')!==$this->input->post('confirm_password')) {
				$Return['error'] = $this->lang->line('umb_karyawan_error_password_not_match');
			}
			
			if($Return['error']!=''){
				$this->output($Return);
			}
			$first_name = $this->Umb_model->clean_post($this->input->post('first_name'));
			$last_name = $this->Umb_model->clean_post($this->input->post('last_name'));
			$karyawan_id = $this->Umb_model->clean_post($this->input->post('karyawan_id'));
			$tanggal_bergabung = $this->Umb_model->clean_date_post($this->input->post('tanggal_bergabung'));
			$username = $this->Umb_model->clean_post($this->input->post('username'));
			$tanggal_lahir = $this->Umb_model->clean_date_post($this->input->post('tanggal_lahir'));
			$no_kontak = $this->Umb_model->clean_post($this->input->post('no_kontak'));
			$alamat = $this->Umb_model->clean_post($this->input->post('alamat'));
			
			$options = array('cost' => 12);
			$password_hash = password_hash($this->input->post('password'), PASSWORD_BCRYPT, $options);
			$kategoris_cuti = array($this->input->post('kategoris_cuti'));
			$cat_ids = implode(',',$this->input->post('kategoris_cuti'));
			$Return['error'] = $cat_ids;
			$data = array(
				'karyawan_id' => $karyawan_id,
				'shift_kantor_id' => $this->input->post('shift_kantor_id'),
				'first_name' => $first_name,
				'last_name' => $last_name,
				'username' => $username,
				'perusahaan_id' => $this->input->post('perusahaan_id'),
				'email' => $this->input->post('email'),
				'password' => $password_hash,
				'tanggal_lahir' => $tanggal_lahir,
				'jenis_kelamin' => $this->input->post('jenis_kelamin'),
				'user_role_id' => $this->input->post('role'),
				'department_id' => $this->input->post('department_id'),
				'penunjukan_id' => $this->input->post('penunjukan_id'),
				'tanggal_bergabung' => $tanggal_bergabung,
				'no_kontak' => $no_kontak,
				'alamat' => $alamat,
				'is_active' => 1,
				'kategoris_cuti' => $cat_ids,
				'created_at' => date('Y-m-d h:i:s')
			);
			$result = $this->Karyawans_model->add($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_tambah_karyawan');

				$setting = $this->Umb_model->read_setting_info(1);
				$perusahaan = $this->Umb_model->read_info_setting_perusahaan(1);
				if($setting[0]->enable_email_notification == 'yes') {

					$this->load->library('email');
					$this->email->set_mailtype("html");
					
					$cinfo = $this->Umb_model->read_info_setting_perusahaan(1);

					$template = $this->Umb_model->read_email_template(8);
					
					$subject = $template[0]->subject.' - '.$cinfo[0]->nama_perusahaan;
					$logo = base_url().'uploads/logo/signin/'.$perusahaan[0]->sign_in_logo;
					
					$full_name = $this->input->post('first_name').' '.$this->input->post('last_name');
					$message = '
					<div style="background:#f6f6f6;font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;margin:0;padding:0;padding: 20px;">
					<img src="'.$logo.'" title="'.$cinfo[0]->nama_perusahaan.'"><br>'.str_replace(array("{var site_name}","{var site_url}","{var username}","{var karyawan_id}","{var nama_karyawan}","{var email}","{var password}"),array($cinfo[0]->nama_perusahaan,site_url(),$this->input->post('username'),$this->input->post('karyawan_id'),$full_name,$this->input->post('email'),$this->input->post('password')),htmlspecialchars_decode(stripslashes($template[0]->message))).'</div>';
					$this->email->from($cinfo[0]->email, $cinfo[0]->nama_perusahaan);
					$this->email->to($this->input->post('email'));
					
					$this->email->subject($subject);
					$this->email->message($message);
					
					$this->email->send();
				}
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function basic_info() {
		
		if($this->input->post('type')=='basic_info') {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			

			if($this->input->post('first_name')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_first_name');
			} else if(preg_match("/^(\pL{1,}[ ]?)+$/u",$this->input->post('first_name'))!=1) {
				$Return['error'] = $this->lang->line('umb_hr_string_error');
			} else if($this->input->post('last_name')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_last_name');
			} else if(preg_match("/^(\pL{1,}[ ]?)+$/u",$this->input->post('last_name'))!=1) {
				$Return['error'] = $this->lang->line('umb_hr_string_error');
			} else if($this->input->post('karyawan_id')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_karyawan_id');
			} else if($this->input->post('username')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_username');
			} else if($this->input->post('email')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_email');
			} else if (!filter_var($this->input->post('email'), FILTER_VALIDATE_EMAIL)) {
				$Return['error'] = $this->lang->line('umb_karyawan_error_invalid_email');
			} else if($this->input->post('perusahaan_id')==='') {
				$Return['error'] = $this->lang->line('error_field_perusahaan');
			} else if($this->input->post('department_id')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_department');
			} else if($this->input->post('penunjukan_id')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_penunjukan');
			} else if($this->input->post('tanggal_lahir')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_tanggal_lahir');
			} else if($this->Umb_model->validate_date($this->input->post('tanggal_lahir'),'Y-m-d') == false) {
				$Return['error'] = $this->lang->line('umb_hr_date_format_error');
			} else if($this->input->post('tanggal_bergabung')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_tanggal_bergabung');
			} else if($this->Umb_model->validate_date($this->input->post('tanggal_bergabung'),'Y-m-d') == false) {
				$Return['error'] = $this->lang->line('umb_hr_date_format_error');
			}  else if($this->input->post('role')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_user_role');
			} else if($this->input->post('no_kontak')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_nomor_kontak');
			} else if(!preg_match('/^([0-9]*)$/', $this->input->post('no_kontak'))) {
				$Return['error'] = $this->lang->line('umb_hr_numeric_error');
			}
			
			if($Return['error']!=''){
				$this->output($Return);
			}
			
			$first_name = $this->Umb_model->clean_post($this->input->post('first_name'));
			$last_name = $this->Umb_model->clean_post($this->input->post('last_name'));
			$karyawan_id = $this->input->post('karyawan_id');
			$tanggal_bergabung = $this->Umb_model->clean_date_post($this->input->post('tanggal_bergabung'));
			//$username = $this->Umb_model->clean_post($this->input->post('username'));
			$username = $this->input->post('username');
			$tanggal_lahir = $this->Umb_model->clean_date_post($this->input->post('tanggal_lahir'));
			$no_kontak = $this->Umb_model->clean_post($this->input->post('no_kontak'));
			$alamat = $this->Umb_model->clean_post($this->input->post('alamat'));
			$kategoris_cuti = array($this->input->post('kategoris_cuti'));
			$cat_ids = implode(',',$this->input->post('kategoris_cuti'));
			
			$data = array(
				'karyawan_id' => $karyawan_id,
				'shift_kantor_id' => $this->input->post('shift_kantor_id'),
				'first_name' => $first_name,
				'last_name' => $last_name,
				'username' => $username,
				'perusahaan_id' => $this->input->post('perusahaan_id'),
				'email' => $this->input->post('email'),
				'tanggal_lahir' => $tanggal_lahir,
				'jenis_kelamin' => $this->input->post('jenis_kelamin'),
				'user_role_id' => $this->input->post('role'),
				'department_id' => $this->input->post('department_id'),
				'penunjukan_id' => $this->input->post('penunjukan_id'),
				'tanggal_bergabung' => $tanggal_bergabung,
				'no_kontak' => $no_kontak,
				'alamat' => $alamat,
				'kategoris_cuti' => $cat_ids,
				'date_of_leaving' => $this->input->post('date_of_leaving'),
				'status_perkawinan' => $this->input->post('status_perkawinan'),
				'is_active' => $this->input->post('status'),
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
	
	public function profile_picture() {
		
		if($this->input->post('type')=='profile_picture') {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = $this->input->post('user_id');
			
			if($_FILES['p_file']['size'] == 0 && null ==$this->input->post('remove_profile_picture')) {
				$Return['error'] = $this->lang->line('umb_karyawan_select_picture');
			} else {
				if(is_uploaded_file($_FILES['p_file']['tmp_name'])) {

					$allowed =  array('png','jpg','jpeg','pdf','gif');
					$filename = $_FILES['p_file']['name'];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);
					
					if(in_array($ext,$allowed)){
						$tmp_name = $_FILES["p_file"]["tmp_name"];
						$profile = "uploads/profile/";
						$set_img = base_url()."uploads/profile/";

						$name = basename($_FILES["p_file"]["name"]);
						$newfilename = 'profile_'.round(microtime(true)).'.'.$ext;
						move_uploaded_file($tmp_name, $profile.$newfilename);
						$fname = $newfilename;
						
						$data = array('profile_picture' => $fname);
						$result = $this->Karyawans_model->profile_picture($data,$id);
						if ($result == TRUE) {
							$Return['result'] = $this->lang->line('umb_karyawan_picture_diperbarui');
							$Return['img'] = $set_img.$fname;
						} else {
							$Return['error'] = $this->lang->line('umb_error_msg');
						}
						$this->output($Return);
						exit;
						
					} else {
						$Return['error'] = $this->lang->line('umb_karyawan_picture_type');
					}
				}
			}
			
			if(null!=$this->input->post('remove_profile_picture')) {

				$data = array('profile_picture' => 'no file');				
				$row = $this->Karyawans_model->read_informasi_karyawan($id);
				$profile = base_url()."uploads/profile/";
				$result = $this->Karyawans_model->profile_picture($data,$id);
				if ($result == TRUE) {
					$Return['result'] = $this->lang->line('umb_karyawan_picture_diperbarui');
					if($row[0]->jenis_kelamin=='Pria') {
						$Return['img'] = $profile.'default_male.jpg';
					} else {
						$Return['img'] = $profile.'default_female.jpg';
					}
				} else {
					$Return['error'] = $this->lang->line('umb_error_msg');
				}
				$this->output($Return);
				exit;
				
			}
			
			if($Return['error']!=''){
				$this->output($Return);
			}
		}
	}
	
	public function social_info() {
		
		if($this->input->post('type')=='social_info') {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();	
			if ($this->input->post('facebook_link')!=='' && !filter_var($this->input->post('facebook_link'), FILTER_VALIDATE_URL)) {
				$Return['error'] = $this->lang->line('umb_hr_fb_field_error');
			} else if ($this->input->post('twitter_link')!=='' && !filter_var($this->input->post('twitter_link'), FILTER_VALIDATE_URL)) {
				$Return['error'] = $this->lang->line('umb_hr_twitter_field_error');
			} else if ($this->input->post('blogger_link')!=='' && !filter_var($this->input->post('blogger_link'), FILTER_VALIDATE_URL)) {
				$Return['error'] = $this->lang->line('umb_hr_blogger_field_error');
			} else if ($this->input->post('linkdedin_link')!=='' && !filter_var($this->input->post('linkdedin_link'), FILTER_VALIDATE_URL)) {
				$Return['error'] = $this->lang->line('umb_hr_linkedin_field_error');
			} else if ($this->input->post('google_plus_link')!=='' && !filter_var($this->input->post('google_plus_link'), FILTER_VALIDATE_URL)) {
				$Return['error'] = $this->lang->line('umb_hr_gplus_field_error');
			} else if ($this->input->post('instagram_link')!=='' && !filter_var($this->input->post('instagram_link'), FILTER_VALIDATE_URL)) {
				$Return['error'] = $this->lang->line('umb_hr_instagram_field_error');
			} else if ($this->input->post('pinterest_link')!=='' && !filter_var($this->input->post('pinterest_link'), FILTER_VALIDATE_URL)) {
				$Return['error'] = $this->lang->line('umb_hr_pinterest_field_error');
			} else if ($this->input->post('youtube_link')!=='' && !filter_var($this->input->post('youtube_link'), FILTER_VALIDATE_URL)) {
				$Return['error'] = $this->lang->line('umb_hr_youtube_field_error');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$data = array(
				'facebook_link' => $this->input->post('facebook_link'),
				'twitter_link' => $this->input->post('twitter_link'),
				'blogger_link' => $this->input->post('blogger_link'),
				'linkdedin_link' => $this->input->post('linkdedin_link'),
				'google_plus_link' => $this->input->post('google_plus_link'),
				'instagram_link' => $this->input->post('instagram_link'),
				'pinterest_link' => $this->input->post('pinterest_link'),
				'youtube_link' => $this->input->post('youtube_link')
			);
			$id = $this->input->post('user_id');
			$result = $this->Karyawans_model->social_info($data,$id);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_perbarui_social_info');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}	
	
	public function update_info_kontaks() {
		
		if($this->input->post('type')=='info_kontak') {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			


			if($this->input->post('salutation')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_salutation');
			} else if($this->input->post('kontak_name')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_kontak_name');
			} else if($this->input->post('relation')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_grp');
			} else if($this->input->post('primary_email')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_pemail');
			} else if($this->input->post('mobile_phone')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_mobile');
			} else if($this->input->post('kota')==='') {
				$Return['error'] = $this->lang->line('umb_error_fiel_kota');
			} else if($this->input->post('negara')==='') {
				$Return['error'] = $this->lang->line('umb_error_field_negara');
			}
			
			if($Return['error']!=''){
				$this->output($Return);
			}
			
			$data = array(
				'salutation' => $this->input->post('salutation'),
				'kontak_name' => $this->input->post('kontak_name'),
				'relation' => $this->input->post('relation'),
				'perusahaan' => $this->input->post('perusahaan'),
				'title_pekerjaan' => $this->input->post('title_pekerjaan'),
				'primary_email' => $this->input->post('primary_email'),
				'mobile_phone' => $this->input->post('mobile_phone'),
				'alamat' => $this->input->post('alamat'),
				'kota' => $this->input->post('kota'),
				'provinsi' => $this->input->post('provinsi'),
				'kode_pos' => $this->input->post('kode_pos'),
				'negara' => $this->input->post('negara'),
				'karyawan_id' => $this->input->post('user_id'),
				'type_kontak' => 'permanent'
			);
			
			$query = $this->Karyawans_model->check_kontak_permanent_karyawan($this->input->post('user_id'));
			if ($query->num_rows() > 0 ) {
				$res = $query->result();
				$e_field_id = $res[0]->kontak_id;
				$result = $this->Karyawans_model->info_kontak_update($data,$e_field_id);
			} else {
				$result = $this->Karyawans_model->add_info_kontak($data);
			}

			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_karyawan_info_kontak_diperbarui');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function update_info_kontak() {
		
		if($this->input->post('type')=='info_kontak') {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			


			if($this->input->post('salutation')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_salutation');
			} else if($this->input->post('kontak_name')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_kontak_name');
			} else if($this->input->post('relation')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_grp');
			} else if($this->input->post('primary_email')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_pemail');
			} else if($this->input->post('mobile_phone')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_mobile');
			} else if($this->input->post('kota')==='') {
				$Return['error'] = $this->lang->line('umb_error_fiel_kota');
			} else if($this->input->post('negara')==='') {
				$Return['error'] = $this->lang->line('umb_error_field_negara');
			}
			
			if($Return['error']!=''){
				$this->output($Return);
			}
			
			$data = array(
				'salutation' => $this->input->post('salutation'),
				'kontak_name' => $this->input->post('kontak_name'),
				'relation' => $this->input->post('relation'),
				'perusahaan' => $this->input->post('perusahaan'),
				'title_pekerjaan' => $this->input->post('title_pekerjaan'),
				'primary_email' => $this->input->post('primary_email'),
				'mobile_phone' => $this->input->post('mobile_phone'),
				'alamat' => $this->input->post('alamat'),
				'kota' => $this->input->post('kota'),
				'provinsi' => $this->input->post('provinsi'),
				'kode_pos' => $this->input->post('kode_pos'),
				'negara' => $this->input->post('negara'),
				'karyawan_id' => $this->input->post('user_id'),
				'type_kontak' => 'current'
			);
			
			$query = $this->Karyawans_model->check_current_kontak_karyawan($this->input->post('user_id'));
			if ($query->num_rows() > 0 ) {
				$res = $query->result();
				$e_field_id = $res[0]->kontak_id;
				$result = $this->Karyawans_model->info_kontak_update($data,$e_field_id);
			} else {
				$result = $this->Karyawans_model->add_info_kontak($data);
			}
			//$e_field_id = 1;
			
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_karyawan_info_kontak_diperbarui');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function info_kontak() {
		
		if($this->input->post('type')=='info_kontak') {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			

			if($this->input->post('relation')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_relation');
			} else if($this->input->post('kontak_name')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_kontak_name');
			} else if(!preg_match("/^(\pL{1,}[ ]?)+$/u",$this->input->post('kontak_name'))) {
				$Return['error'] = $this->lang->line('umb_hr_string_error');
			} else if($this->input->post('no_kontak')!=='' && !preg_match('/^([0-9]*)$/', $this->input->post('no_kontak'))) {
				$Return['error'] = $this->lang->line('umb_hr_numeric_error');
			} else if($this->input->post('phone_kerja')!=='' && !preg_match('/^([0-9]*)$/', $this->input->post('phone_kerja'))) {
				$Return['error'] = $this->lang->line('umb_hr_numeric_error');
			} else if($this->input->post('extension_phone_kerja')!=='' && !preg_match('/^([0-9]*)$/', $this->input->post('extension_phone_kerja'))) {
				$Return['error'] = $this->lang->line('umb_hr_numeric_error');
			} else if($this->input->post('mobile_phone')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_mobile');
			} else if(!preg_match('/^([0-9]*)$/', $this->input->post('mobile_phone'))) {
				$Return['error'] = $this->lang->line('umb_hr_numeric_error');
			} else if($this->input->post('home_phone')!=='' && !preg_match('/^([0-9]*)$/', $this->input->post('home_phone'))) {
				$Return['error'] = $this->lang->line('umb_hr_numeric_error');
			} else if($this->input->post('email_kerja')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_email');
			} else if (!filter_var($this->input->post('email_kerja'), FILTER_VALIDATE_EMAIL)) {
				$Return['error'] = $this->lang->line('umb_karyawan_error_invalid_email');
			} else if ($this->input->post('email_pribadi')!=='' && !filter_var($this->input->post('email_pribadi'), FILTER_VALIDATE_EMAIL)) {
				$Return['error'] = $this->lang->line('umb_karyawan_error_invalid_email');
			} else if($this->input->post('kode_pos')!=='' && !preg_match('/^([0-9]*)$/', $this->input->post('kode_pos'))) {
				$Return['error'] = $this->lang->line('umb_hr_numeric_error');
			}
			
			if(null!=$this->input->post('is_primary')) {
				$is_primary = $this->input->post('is_primary');
			} else {
				$is_primary = '';
			}
			if(null!=$this->input->post('is_dependent')) {
				$is_dependent = $this->input->post('is_dependent');
			} else {
				$is_dependent = '';
			}
			
			if($Return['error']!=''){
				$this->output($Return);
			}
			$kontak_name = $this->Umb_model->clean_post($this->input->post('kontak_name'));
			$alamat_1 = $this->Umb_model->clean_post($this->input->post('alamat_1'));
			$alamat_2 = $this->Umb_model->clean_post($this->input->post('alamat_2'));
			$kota = $this->Umb_model->clean_post($this->input->post('kota'));
			$provinsi = $this->Umb_model->clean_post($this->input->post('state'));		
			
			$data = array(
				'relation' => $this->input->post('relation'),
				'email_kerja' => $this->input->post('email_kerja'),
				'is_primary' => $is_primary,
				'is_dependent' => $is_dependent,
				'email_pribadi' => $this->input->post('email_pribadi'),
				'kontak_name' => $kontak_name,
				'alamat_1' => $alamat_1,
				'phone_kerja' => $this->input->post('phone_kerja'),
				'extension_phone_kerja' => $this->input->post('extension_phone_kerja'),
				'alamat_2' => $alamat_2,
				'mobile_phone' => $this->input->post('mobile_phone'),
				'kota' => $kota,
				'provinsi' => $provinsi,
				'kode_pos' => $this->input->post('kode_pos'),
				'home_phone' => $this->input->post('home_phone'),
				'negara' => $this->input->post('negara'),
				'karyawan_id' => $this->input->post('user_id'),
				'created_at' => date('d-m-Y'),
			);
			$result = $this->Karyawans_model->add_info_kontak($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_karyawan_info_kontak_ditambahkan');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function e_info_kontak() {
		
		if($this->input->post('type')=='e_info_kontak') {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			

			if($this->input->post('relation')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_relation');
			} else if($this->input->post('kontak_name')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_kontak_name');
			} else if($this->input->post('mobile_phone')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_mobile');
			}
			
			if(null!=$this->input->post('is_primary')) {
				$is_primary = $this->input->post('is_primary');
			} else {
				$is_primary = '';
			}
			if(null!=$this->input->post('is_dependent')) {
				$is_dependent = $this->input->post('is_dependent');
			} else {
				$is_dependent = '';
			}
			
			if($Return['error']!=''){
				$this->output($Return);
			}
			
			$data = array(
				'relation' => $this->input->post('relation'),
				'email_kerja' => $this->input->post('email_kerja'),
				'is_primary' => $is_primary,
				'is_dependent' => $is_dependent,
				'email_pribadi' => $this->input->post('email_pribadi'),
				'kontak_name' => $this->input->post('kontak_name'),
				'alamat_1' => $this->input->post('alamat_1'),
				'phone_kerja' => $this->input->post('phone_kerja'),
				'extension_phone_kerja' => $this->input->post('extension_phone_kerja'),
				'alamat_2' => $this->input->post('alamat_2'),
				'mobile_phone' => $this->input->post('mobile_phone'),
				'kota' => $this->input->post('kota'),
				'provinsi' => $this->input->post('provinsi'),
				'kode_pos' => $this->input->post('kode_pos'),
				'home_phone' => $this->input->post('home_phone'),
				'negara' => $this->input->post('negara')
			);
			
			$e_field_id = $this->input->post('e_field_id');
			$result = $this->Karyawans_model->info_kontak_update($data,$e_field_id);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_karyawan_info_kontak_diperbarui');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function document_info() {
		
		if($this->input->post('type')=='document_info' && $this->input->post('data')=='document_info') {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			

			if($this->input->post('type_document_id')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_type_document');
			} else if($this->Umb_model->validate_date($this->input->post('tanggal_kadaluarsa'),'Y-m-d') == false) {
				$Return['error'] = $this->lang->line('umb_hr_date_format_error');
			} else if($this->input->post('title')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_document_title');
			} else if(preg_match("/^(\pL{1,}[ ]?)+$/u",$this->input->post('title')) != 1) {
				$Return['error'] = $this->lang->line('umb_hr_string_error');
			} else if($this->input->post('email')==='') {
				$Return['error'] = $this->lang->line('umb_error_notify_email_field');
			} else if(!filter_var($this->input->post('email'), FILTER_VALIDATE_EMAIL)) {
				$Return['error'] = $this->lang->line('umb_karyawan_error_invalid_email');
			} 
			
			else if($_FILES['document_file']['size'] == 0) {
				$Return['error'] = $this->lang->line('umb_karyawan_select_d_file');
			} else {
				if(is_uploaded_file($_FILES['document_file']['tmp_name'])) {

					$allowed =  array('png','jpg','jpeg','pdf','gif','txt','pdf','xls','xlsx','doc','docx');
					$filename = $_FILES['document_file']['name'];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);
					
					if(in_array($ext,$allowed)){
						$tmp_name = $_FILES["document_file"]["tmp_name"];
						$documentd = "uploads/document/";


						$name = basename($_FILES["document_file"]["name"]);
						$newfilename = 'document_'.round(microtime(true)).'.'.$ext;
						move_uploaded_file($tmp_name, $documentd.$newfilename);
						$fname = $newfilename;
					} else {
						$Return['error'] = $this->lang->line('umb_karyawan_file_type_document');
					}
				}
			}
			
			if($Return['error']!=''){
				$this->output($Return);
			}
			
			$title = $this->Umb_model->clean_post($this->input->post('title'));
			$description = $this->Umb_model->clean_post($this->input->post('description'));

			$tanggal_kadaluarsa = $this->Umb_model->clean_date_post($this->input->post('tanggal_kadaluarsa'));
			
			$data = array(
				'type_document_id' => $this->input->post('type_document_id'),
				'tanggal_kadaluarsa' => $tanggal_kadaluarsa,
				'document_file' => $fname,
				'title' => $title,
				'notification_email' => $this->input->post('email'),
				'is_alert' => $this->input->post('send_mail'),
				'description' => $description,
				'karyawan_id' => $this->input->post('user_id'),
				'created_at' => date('d-m-Y'),
			);
			$result = $this->Karyawans_model->add_info_document($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_karyawan_d_info_ditambahkan');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function immigration_info() {
		
		if($this->input->post('type')=='immigration_info' && $this->input->post('data')=='immigration_info') {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			//preg_match("/^(\pL{1,}[ ]?)+$/u",
			if($this->input->post('type_document_id')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_type_document');
			} else if($this->input->post('nomor_document')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_d_number');
			} else if($this->input->post('tanggal_terbit')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_d_issue');
			} else if($this->Umb_model->validate_date($this->input->post('tanggal_terbit'),'Y-m-d') == false) {
				$Return['error'] = $this->lang->line('umb_hr_date_format_error');
			} else if($this->input->post('tanggal_kaaluarsa')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_tanggal_kaaluarsa');
			} else if($this->Umb_model->validate_date($this->input->post('tanggal_kaaluarsa'),'Y-m-d') == false) {
				$Return['error'] = $this->lang->line('umb_hr_date_format_error');
			}
			
			else if($_FILES['document_file']['size'] == 0) {
				$Return['error'] = $this->lang->line('umb_karyawan_select_d_file');
			} else {
				if(is_uploaded_file($_FILES['document_file']['tmp_name'])) {

					$allowed =  array('png','jpg','jpeg','pdf','gif','txt','pdf','xls','xlsx','doc','docx');
					$filename = $_FILES['document_file']['name'];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);
					
					if(in_array($ext,$allowed)){
						$tmp_name = $_FILES["document_file"]["tmp_name"];
						$documentd = "uploads/document/immigration/";

						$name = basename($_FILES["document_file"]["name"]);
						$newfilename = 'document_'.round(microtime(true)).'.'.$ext;
						move_uploaded_file($tmp_name, $documentd.$newfilename);
						$fname = $newfilename;
					} else {
						$Return['error'] = $this->lang->line('umb_karyawan_file_type_document');
					}
				}
			}
			
			if($Return['error']!=''){
				$this->output($Return);
			}
			$nomor_document = $this->Umb_model->clean_post($this->input->post('nomor_document'));	
			$tanggal_terbit = $this->Umb_model->clean_date_post($this->input->post('tanggal_terbit'));
			$tanggal_kaaluarsa = $this->Umb_model->clean_date_post($this->input->post('tanggal_kaaluarsa'));
			$tanggal_tinjauan_yang_memenuhi_syarat = $this->Umb_model->clean_date_post($this->input->post('tanggal_tinjauan_yang_memenuhi_syarat'));
			$data = array(
				'type_document_id' => $this->input->post('type_document_id'),
				'nomor_document' => $nomor_document,
				'document_file' => $fname,
				'tanggal_terbit' => $tanggal_terbit,
				'tanggal_kaaluarsa' => $tanggal_kaaluarsa,
				'negara_id' => $this->input->post('negara'),
				'tanggal_tinjauan_yang_memenuhi_syarat' => $tanggal_tinjauan_yang_memenuhi_syarat,
				'karyawan_id' => $this->input->post('user_id'),
				'created_at' => date('d-m-Y h:i:s'),
			);
			$result = $this->Karyawans_model->immigration_info_add($data);
			
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_karyawan_img_info_ditambahkan');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function e_info_immigration() {
		
		if($this->input->post('type')=='e_info_immigration' && $this->input->post('data')=='e_info_immigration') {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			

			if($this->input->post('type_document_id')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_type_document');
			} else if($this->input->post('nomor_document')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_d_number');
			} else if($this->input->post('tanggal_terbit')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_d_issue');
			} else if($this->input->post('tanggal_kaaluarsa')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_tanggal_kaaluarsa');
			}
			
			else if($_FILES['document_file']['size'] == 0) {
				$data = array(
					'type_document_id' => $this->input->post('type_document_id'),
					'nomor_document' => $this->input->post('nomor_document'),
					'tanggal_terbit' => $this->input->post('tanggal_terbit'),
					'tanggal_kaaluarsa' => $this->input->post('tanggal_kaaluarsa'),
					'negara_id' => $this->input->post('negara'),
					'tanggal_tinjauan_yang_memenuhi_syarat' => $this->input->post('tanggal_tinjauan_yang_memenuhi_syarat'),
				);
				$e_field_id = $this->input->post('e_field_id');
				$result = $this->Karyawans_model->img_document_info_update($data,$e_field_id);
				if ($result == TRUE) {
					$Return['result'] = $this->lang->line('umb_karyawan_img_info_diperbarui');
				} else {
					$Return['error'] = $this->lang->line('umb_error_msg');
				}
				$this->output($Return);
				exit;
			} else {
				if(is_uploaded_file($_FILES['document_file']['tmp_name'])) {

					$allowed =  array('png','jpg','jpeg','pdf','gif','txt','pdf','xls','xlsx','doc','docx');
					$filename = $_FILES['document_file']['name'];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);
					
					if(in_array($ext,$allowed)){
						$tmp_name = $_FILES["document_file"]["tmp_name"];
						$documentd = "uploads/document/immigration/";

						$name = basename($_FILES["document_file"]["name"]);
						$newfilename = 'document_'.round(microtime(true)).'.'.$ext;
						move_uploaded_file($tmp_name, $documentd.$newfilename);
						$fname = $newfilename;
						$data = array(
							'type_document_id' => $this->input->post('type_document_id'),
							'nomor_document' => $this->input->post('nomor_document'),
							'document_file' => $fname,
							'tanggal_terbit' => $this->input->post('tanggal_terbit'),
							'tanggal_kaaluarsa' => $this->input->post('tanggal_kaaluarsa'),
							'negara_id' => $this->input->post('negara'),
							'tanggal_tinjauan_yang_memenuhi_syarat' => $this->input->post('tanggal_tinjauan_yang_memenuhi_syarat'),
						);
						$e_field_id = $this->input->post('e_field_id');
						$result = $this->Karyawans_model->img_document_info_update($data,$e_field_id);
						if ($result == TRUE) {
							$Return['result'] = $this->lang->line('umb_karyawan_d_info_diperbarui');
						} else {
							$Return['error'] = $this->lang->line('umb_error_msg');
						}
						$this->output($Return);
						exit;
					} else {
						$Return['error'] = $this->lang->line('umb_karyawan_file_type_document');
					}
				}
			}
			
			if($Return['error']!=''){
				$this->output($Return);
			}
			
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_karyawan_img_info_ditambahkan');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function e_info_document() {
		
		if($this->input->post('type')=='e_info_document') {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			

			if($this->input->post('type_document_id')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_type_document');
			} else if($this->input->post('title')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_document_title');
			} else if($this->input->post('email')==='') {
				$Return['error'] = $this->lang->line('umb_error_notify_email_field');
			}
			
			else if($_FILES['document_file']['size'] == 0) {
				$data = array(
					'type_document_id' => $this->input->post('type_document_id'),
					'tanggal_kadaluarsa' => $this->input->post('tanggal_kadaluarsa'),
					'title' => $this->input->post('title'),
					'notification_email' => $this->input->post('email'),
					'is_alert' => $this->input->post('send_mail'),
					'description' => $this->input->post('description')
				);
				$e_field_id = $this->input->post('e_field_id');
				$result = $this->Karyawans_model->document_info_update($data,$e_field_id);
				if ($result == TRUE) {
					$Return['result'] = $this->lang->line('umb_karyawan_d_info_diperbarui');
				} else {
					$Return['error'] = $this->lang->line('umb_error_msg');
				}
				$this->output($Return);
				exit;
			} else {
				if(is_uploaded_file($_FILES['document_file']['tmp_name'])) {

					$allowed =  array('png','jpg','jpeg','pdf','gif','txt','pdf','xls','xlsx','doc','docx');
					$filename = $_FILES['document_file']['name'];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);
					
					if(in_array($ext,$allowed)){
						$tmp_name = $_FILES["document_file"]["tmp_name"];
						$documentd = "uploads/document/";


						$name = basename($_FILES["document_file"]["name"]);
						$newfilename = 'document_'.round(microtime(true)).'.'.$ext;
						move_uploaded_file($tmp_name, $documentd.$newfilename);
						$fname = $newfilename;
						$data = array(
							'type_document_id' => $this->input->post('type_document_id'),
							'tanggal_kadaluarsa' => $this->input->post('tanggal_kadaluarsa'),
							'document_file' => $fname,
							'title' => $this->input->post('title'),
							'notification_email' => $this->input->post('email'),
							'is_alert' => $this->input->post('send_mail'),
							'description' => $this->input->post('description')
						);
						$e_field_id = $this->input->post('e_field_id');
						$result = $this->Karyawans_model->document_info_update($data,$e_field_id);
						if ($result == TRUE) {
							$Return['result'] = $this->lang->line('umb_karyawan_d_info_diperbarui');
						} else {
							$Return['error'] = $this->lang->line('umb_error_msg');
						}
						$this->output($Return);
						exit;
					} else {
						$Return['error'] = $this->lang->line('umb_karyawan_file_type_document');
					}
				}
			}
			
			if($Return['error']!=''){
				$this->output($Return);
			}
			
			
		}
	}
	
	public function info_qualification() {
		
		if($this->input->post('type')=='info_qualification') {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			

			$from_year = $this->input->post('from_year');
			$to_year = $this->input->post('to_year');
			$st_date = strtotime($from_year);
			$ed_date = strtotime($to_year);
			
			if($this->input->post('name')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_sch_uni');
			} else if(preg_match("/^(\pL{1,}[ ]?)+$/u",$this->input->post('name'))!=1) {
				$Return['error'] = $this->lang->line('umb_hr_string_error');
			} else if($this->input->post('from_year')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_frm_date');
			} else if($this->Umb_model->validate_date($this->input->post('from_year'),'Y-m-d') == false) {
				$Return['error'] = $this->lang->line('umb_hr_date_format_error');
			} else if($this->input->post('to_year')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_to_date');
			} else if($this->Umb_model->validate_date($this->input->post('to_year'),'Y-m-d') == false) {
				$Return['error'] = $this->lang->line('umb_hr_date_format_error');
			} else if($st_date > $ed_date) {
				$Return['error'] = $this->lang->line('umb_karyawan_error_date_shouldbe');
			}
			
			if($Return['error']!=''){
				$this->output($Return);
			}
			
			$name = $this->Umb_model->clean_post($this->input->post('name'));
			$from_year = $this->Umb_model->clean_date_post($this->input->post('from_year'));
			$to_year = $this->Umb_model->clean_date_post($this->input->post('to_year'));
			$description = $this->Umb_model->clean_post($this->input->post('description'));
			$data = array(
				'name' => $name,
				'tingkat_pendidikan_id' => $this->input->post('tingkat_pendidikan'),
				'from_year' => $from_year,
				'language_id' => $this->input->post('language'),
				'to_year' => $this->input->post('to_year'),
				'skill_id' => $this->input->post('skill'),
				'description' => $description,
				'karyawan_id' => $this->input->post('user_id'),
				'created_at' => date('d-m-Y'),
			);
			$result = $this->Karyawans_model->add_info_qualification($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_karyawan_error_q_info_ditambahkan');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function e_info_qualification() {
		
		if($this->input->post('type')=='e_info_qualification') {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			

			$from_year = $this->input->post('from_year');
			$to_year = $this->input->post('to_year');
			$st_date = strtotime($from_year);
			$ed_date = strtotime($to_year);
			
			if($this->input->post('name')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_sch_uni');
			} else if($this->input->post('from_year')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_frm_date');
			} else if($this->input->post('to_year')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_to_date');
			} else if($st_date > $ed_date) {
				$Return['error'] = $this->lang->line('umb_karyawan_error_date_shouldbe');
			}
			
			if($Return['error']!=''){
				$this->output($Return);
			}
			
			$data = array(
				'name' => $this->input->post('name'),
				'tingkat_pendidikan_id' => $this->input->post('tingkat_pendidikan'),
				'from_year' => $this->input->post('from_year'),
				'language_id' => $this->input->post('language'),
				'to_year' => $this->input->post('to_year'),
				'skill_id' => $this->input->post('skill'),
				'description' => $this->input->post('description')
			);
			$e_field_id = $this->input->post('e_field_id');
			$result = $this->Karyawans_model->info_qualification_update($data,$e_field_id);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_karyawan_error_q_info_diperbarui');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function info_pengalaman_kerja() {
		
		if($this->input->post('type')=='info_pengalaman_kerja') {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
			$frm_date = strtotime($this->input->post('from_date'));	
			$to_date = strtotime($this->input->post('to_date'));

			if($this->input->post('nama_perusahaan')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_nama_perusahaan');
			} else if($this->input->post('post')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_post');
			} else if($this->input->post('from_date')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_frm_date');
			} else if($this->input->post('to_date')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_to_date');
			} else if($frm_date > $to_date) {
				$Return['error'] = $this->lang->line('umb_karyawan_error_date_shouldbe');
			} 
			
			if($Return['error']!=''){
				$this->output($Return);
			}
			
			$data = array(
				'nama_perusahaan' => $this->input->post('nama_perusahaan'),
				'from_date' => $this->input->post('from_date'),
				'to_date' => $this->input->post('to_date'),
				'post' => $this->input->post('post'),
				'description' => $this->input->post('description'),
				'karyawan_id' => $this->input->post('user_id'),
				'created_at' => date('d-m-Y'),
			);
			$result = $this->Karyawans_model->add_info_pengalaman_kerja($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_karyawan_error_w_exp_ditambahkan');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function e_info_pengalaman_kerja() {
		
		if($this->input->post('type')=='e_info_pengalaman_kerja') {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
			$frm_date = strtotime($this->input->post('from_date'));	
			$to_date = strtotime($this->input->post('to_date'));

			if($this->input->post('nama_perusahaan')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_nama_perusahaan');
			} else if($this->input->post('from_date')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_frm_date');
			} else if($this->input->post('to_date')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_to_date');
			} else if($frm_date > $to_date) {
				$Return['error'] = $this->lang->line('umb_karyawan_error_date_shouldbe');
			} else if($this->input->post('post')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_post');
			}
			
			if($Return['error']!=''){
				$this->output($Return);
			}
			
			$data = array(
				'nama_perusahaan' => $this->input->post('nama_perusahaan'),
				'from_date' => $this->input->post('from_date'),
				'to_date' => $this->input->post('to_date'),
				'post' => $this->input->post('post'),
				'description' => $this->input->post('description')
			);
			$e_field_id = $this->input->post('e_field_id');
			$result = $this->Karyawans_model->info_pengalaman_kerja_update($data,$e_field_id);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_karyawan_error_w_exp_diperbarui');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function info_bank_account() {
		
		if($this->input->post('type')=='info_bank_account') {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();

			if($this->input->post('account_title')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_acc_title');
			} else if(preg_match("/^(\pL{1,}[ ]?)+$/u",$this->input->post('account_title'))!=1) {
				$Return['error'] = $this->lang->line('umb_hr_string_error');
			} else if($this->input->post('nomor_account')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_acc_number');
			} else if($this->input->post('nama_bank')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_nama_bank');
			} else if($this->input->post('kode_bank')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_kode_bank');
			}
			
			if($Return['error']!=''){
				$this->output($Return);
			}
			
			$data = array(
				'account_title' => $this->input->post('account_title'),
				'nomor_account' => $this->input->post('nomor_account'),
				'nama_bank' => $this->input->post('nama_bank'),
				'kode_bank' => $this->input->post('kode_bank'),
				'cabang_bank' => $this->input->post('cabang_bank'),
				'karyawan_id' => $this->input->post('user_id'),
				'created_at' => date('d-m-Y'),
			);
			$result = $this->Karyawans_model->add_info_bank_account($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_karyawan_error_bank_info_ditambahkan');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function e_info_bank_account() {
		
		if($this->input->post('type')=='e_info_bank_account') {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();

			if($this->input->post('account_title')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_acc_title');
			} else if($this->input->post('nomor_account')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_acc_number');
			} else if($this->input->post('nama_bank')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_nama_bank');
			} else if($this->input->post('kode_bank')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_kode_bank');
			}
			
			if($Return['error']!=''){
				$this->output($Return);
			}
			
			$data = array(
				'account_title' => $this->input->post('account_title'),
				'nomor_account' => $this->input->post('nomor_account'),
				'nama_bank' => $this->input->post('nama_bank'),
				'kode_bank' => $this->input->post('kode_bank'),
				'cabang_bank' => $this->input->post('cabang_bank')
			);
			$e_field_id = $this->input->post('e_field_id');
			$result = $this->Karyawans_model->info_bank_account_update($data,$e_field_id);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_karyawan_error_bank_info_diperbarui');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function info_kontrak() {
		
		if($this->input->post('type')=='info_kontrak') {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
			$frm_date = strtotime($this->input->post('from_date'));	
			$to_date = strtotime($this->input->post('to_date'));

			if($this->input->post('type_kontrak_id')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_type_kontrak');
			} else if($this->input->post('title')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_kontrak_title');
			} else if($this->input->post('from_date')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_frm_date');
			} else if($this->input->post('to_date')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_to_date');
			} else if($frm_date > $to_date) {
				$Return['error'] = $this->lang->line('umb_karyawan_error_frm_to_date');
			} else if($this->input->post('penunjukan_id')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_penunjukan');
			}
			
			if($Return['error']!=''){
				$this->output($Return);
			}
			
			$data = array(
				'type_kontrak_id' => $this->input->post('type_kontrak_id'),
				'title' => $this->input->post('title'),
				'from_date' => $this->input->post('from_date'),
				'to_date' => $this->input->post('to_date'),
				'penunjukan_id' => $this->input->post('penunjukan_id'),
				'description' => $this->input->post('description'),
				'karyawan_id' => $this->input->post('user_id'),
				'created_at' => date('d-m-Y'),
			);
			$result = $this->Karyawans_model->info_kontrak_add($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_karyawan_info_kontrak_ditambahkan');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function e_info_kontrak() {
		
		if($this->input->post('type')=='e_info_kontrak') {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
			$frm_date = strtotime($this->input->post('from_date'));	
			$to_date = strtotime($this->input->post('to_date'));

			if($this->input->post('type_kontrak_id')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_type_kontrak');
			} else if($this->input->post('title')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_kontrak_title');
			} else if($this->input->post('from_date')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_frm_date');
			} else if($this->input->post('to_date')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_to_date');
			} else if($frm_date > $to_date) {
				$Return['error'] = $this->lang->line('umb_karyawan_error_frm_to_date');
			} else if($this->input->post('penunjukan_id')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_penunjukan');
			}
			
			if($Return['error']!=''){
				$this->output($Return);
			}
			
			$data = array(
				'type_kontrak_id' => $this->input->post('type_kontrak_id'),
				'title' => $this->input->post('title'),
				'from_date' => $this->input->post('from_date'),
				'to_date' => $this->input->post('to_date'),
				'penunjukan_id' => $this->input->post('penunjukan_id'),
				'description' => $this->input->post('description')
			);
			$e_field_id = $this->input->post('e_field_id');
			$result = $this->Karyawans_model->info_kontrak_update($data,$e_field_id);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_karyawan_info_kontrak_diperbarui');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function info_cuti() {
		
		if($this->input->post('type')=='info_cuti') {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();

			if($this->input->post('kontrak_id')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_kontrak_f');
			}
			
			if($Return['error']!=''){
				$this->output($Return);
			}
			
			$data = array(
				'kontrak_id' => $this->input->post('kontrak_id'),
				'casual_cuti' => $this->input->post('casual_cuti'),
				'medical_cuti' => $this->input->post('medical_cuti'),
				'karyawan_id' => $this->input->post('user_id'),
				'created_at' => date('d-m-Y'),
			);
			$result = $this->Karyawans_model->info_cuti_add($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_karyawan_info_cuti_ditambahkan');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function e_info_cuti() {
		
		if($this->input->post('type')=='e_info_cuti') {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
			if($Return['error']!=''){
				$this->output($Return);
			}
			
			$data = array(
				'casual_cuti' => $this->input->post('casual_cuti'),
				'medical_cuti' => $this->input->post('medical_cuti')
			);
			$e_field_id = $this->input->post('e_field_id');
			$result = $this->Karyawans_model->info_cuti_update($data,$e_field_id);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_karyawan_info_cuti_diperbarui');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function info_shift() {
		
		if($this->input->post('type')=='info_shift') {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();

			if($this->input->post('from_date')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_frm_date');
			} else if($this->input->post('shift_id')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_field_shift');
			}
			
			if($Return['error']!=''){
				$this->output($Return);
			}
			
			$data = array(
				'from_date' => $this->input->post('from_date'),
				'to_date' => $this->input->post('to_date'),
				'shift_id' => $this->input->post('shift_id'),
				'karyawan_id' => $this->input->post('user_id'),
				'created_at' => date('d-m-Y'),
			);
			$result = $this->Karyawans_model->info_shift_add($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_karyawan_info_shift_ditambahkan');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function e_info_shift() {
		
		if($this->input->post('type')=='e_info_shift') {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
			if($this->input->post('from_date')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_frm_date');
			}
			
			$data = array(
				'from_date' => $this->input->post('from_date'),
				'to_date' => $this->input->post('to_date')
			);
			$e_field_id = $this->input->post('e_field_id');
			$result = $this->Karyawans_model->info_shift_update($data,$e_field_id);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_karyawan_info_shift_diperbarui');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function info_location() {
		
		if($this->input->post('type')=='info_location') {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();

			if($this->input->post('from_date')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_frm_date');
			} else if($this->input->post('location_id')==='') {
				$Return['error'] = $this->lang->line('error_field_location_dept');
			}
			
			if($Return['error']!=''){
				$this->output($Return);
			}
			
			$data = array(
				'from_date' => $this->input->post('from_date'),
				'to_date' => $this->input->post('to_date'),
				'location_id' => $this->input->post('location_id'),
				'karyawan_id' => $this->input->post('user_id'),
				'created_at' => date('d-m-Y'),
			);
			$result = $this->Karyawans_model->info_location_add($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_info_location_karyawan_ditambahkan');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function e_info_location() {
		
		if($this->input->post('type')=='e_info_location') {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();

			if($this->input->post('from_date')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_frm_date');
			} else if($this->input->post('location_id')==='') {
				$Return['error'] = $this->lang->line('error_field_location_dept');
			}
			
			if($Return['error']!=''){
				$this->output($Return);
			}
			
			$data = array(
				'from_date' => $this->input->post('from_date'),
				'to_date' => $this->input->post('to_date')
			);
			$e_field_id = $this->input->post('e_field_id');
			$result = $this->Karyawans_model->info_location_update($data,$e_field_id);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_info_location_karyawan_diperbarui');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function info_update_tunjanagan() {
		
		if($this->input->post('type')=='e_info_tunjanagan') {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();

			if($this->input->post('title_tunjanagan')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_set_title_tunjanagan_error');
			} else if($this->input->post('jumlah_tunjanagan')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_set_jumlah_tunjanagan_error');
			}
			
			if($Return['error']!=''){
				$this->output($Return);
			}
			
			$data = array(
				'title_tunjanagan' => $this->input->post('title_tunjanagan'),
				'jumlah_tunjanagan' => $this->input->post('jumlah_tunjanagan')
			);
			$e_field_id = $this->input->post('e_field_id');
			$result = $this->Karyawans_model->update_record_gaji_tunjanagan($data,$e_field_id);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_karyawan_diperbarui_tunjanagan_success');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function change_password() {
		
		if($this->input->post('type')=='change_password') {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			

			if(trim($this->input->post('new_password'))==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_newpassword');
			} else if(strlen($this->input->post('new_password')) < 6) {
				$Return['error'] = $this->lang->line('umb_karyawan_error_password_least');
			} else if(trim($this->input->post('new_password_confirm'))==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_new_cpassword');
			} else if($this->input->post('new_password')!=$this->input->post('new_password_confirm')) {
				$Return['error'] = $this->lang->line('umb_karyawan_error_old_new_cpassword');
			}
			
			if($Return['error']!=''){
				$this->output($Return);
			}
			$options = array('cost' => 12);
			$password_hash = password_hash($this->input->post('new_password'), PASSWORD_BCRYPT, $options);
			
			$data = array(
				'password' => $password_hash
			);
			$id = $this->input->post('user_id');
			$result = $this->Karyawans_model->change_password($data,$id);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_update_password_karyawan');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
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
				$primary = '<span class="tag tag-success">'.$this->lang->line('umb_karyawan_primary').'</span>';
			} else {
				$primary = '';
			}
			if($r->is_dependent==2){
				$dependent = '<span class="tag tag-danger">'.$this->lang->line('umb_karyawan_dependent').'</span>';
			} else {
				$dependent = '';
			}

			$data[] = array(
				'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->kontak_id . '" data-field_type="kontak"><i class="fas fa-pencil-alt-square-o"></i></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn btn-outline-danger btn-sm m-b-0-0 waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->kontak_id . '" data-token_type="kontak"><i class="fas fa-trash-restore-o"></i></button></span>',
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
		//set data
		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/karyawans/detail_karyawan", $data);
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
				$functions = '<span data-toggle="tooltip" data-placement="top" title="Download"><a href="'.site_url().'admin/download?type=document&filename='.$r->document_file.'"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light" title="'.$this->lang->line('umb_download').'"><i class="oi oi-cloud-download"></i></button></a></span>';
			} else {
				$functions ='';
			}

			if($r->is_alert==1){
				$alert = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_e_details_alert_notifyemail').'"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light"><i class="fa fa-bell"></i></button></span>';
			} else {
				$alert = '';
			}

			$data[] = array(
				$alert.$functions.'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->document_id . '" data-field_type="document"><i class="fas fa-pencil-alt-square-o"></i></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn btn-outline-danger btn-sm m-b-0-0 waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->document_id . '" data-token_type="document"><i class="fas fa-trash-restore-o"></i></button></span>',
				$document_d,
				$r->title,
				$r->notification_email,
				$tanggal_kadaluarsa
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

	public function immigration() {
		//set data
		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/karyawans/detail_karyawan", $data);
		} else {
			redirect('admin/');
		}

		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		$id = $this->uri->segment(4);
		$immigration = $this->Karyawans_model->set_karyawan_immigration($id);

		$data = array();

		foreach($immigration->result() as $r) {

			$tanggal_terbit = $this->Umb_model->set_date_format($r->tanggal_terbit);
			$tanggal_kaaluarsa = $this->Umb_model->set_date_format($r->tanggal_kaaluarsa);
			$tanggal_tinjauan_yang_memenuhi_syarat = $this->Umb_model->set_date_format($r->tanggal_tinjauan_yang_memenuhi_syarat);
			$d_type = $this->Karyawans_model->read_informasi_type_document($r->type_document_id);
			if(!is_null($d_type)){
				$document_d = $d_type[0]->type_document.'<br>'.$r->nomor_document;
			} else {
				$document_d = $r->nomor_document;
			}
			$negara = $this->Umb_model->read_info_negara($r->negara_id);
			if(!is_null($negara)){
				$c_name = $negara[0]->nama_negara;
			} else {
				$c_name = '--';	
			}

			$data[] = array(
				'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->immigration_id . '" data-field_type="imgdocument"><i class="fas fa-pencil-alt-square-o"></i></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn btn-outline-danger btn-sm m-b-0-0 waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->immigration_id . '" data-token_type="imgdocument"><i class="fas fa-trash-restore-o"></i></button></span>',
				$document_d,
				$tanggal_terbit,
				$tanggal_kaaluarsa,
				$c_name,
				$tanggal_tinjauan_yang_memenuhi_syarat,
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $immigration->num_rows(),
			"recordsFiltered" => $immigration->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function qualification() {
		//set data
		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/karyawans/detail_karyawan", $data);
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
			$sdate = $this->Umb_model->set_date_format($r->from_year);
			$edate = $this->Umb_model->set_date_format($r->to_year);	

			$time_period = $sdate.' - '.$edate;

			$pdate = $time_period;
			$data[] = array(
				'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->qualification_id . '" data-field_type="qualification"><i class="fas fa-pencil-alt-square-o"></i></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn btn-outline-danger btn-sm m-b-0-0 waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->qualification_id . '" data-token_type="qualification"><i class="fas fa-trash-restore-o"></i></button></span>',
				$r->name,
				$pdate,
				$nama_pddkn
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
			$this->load->view("admin/karyawans/detail_karyawan", $data);
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
			$this->load->view("admin/karyawans/detail_karyawan", $data);
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
			$this->load->view("admin/karyawans/detail_karyawan", $data);
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

			$type_kontrak = $this->Karyawans_model->read_informasi_type_kontrak($r->type_kontrak_id);
			if(!is_null($type_kontrak)){
				$ctype = $type_kontrak[0]->name;
			} else {
				$ctype = '--';
			}

			$duration = $this->Umb_model->set_date_format($r->from_date).' '.$this->lang->line('dashboard_to').' '.$this->Umb_model->set_date_format($r->to_date);

			$data[] = array(
				'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->kontrak_id . '" data-field_type="kontrak"><i class="fas fa-pencil-alt-square-o"></i></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn btn-outline-danger btn-sm m-b-0-0 waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->kontrak_id . '" data-token_type="kontrak"><i class="fas fa-trash-restore-o"></i></button></span>',
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

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/karyawans/detail_karyawan", $data);
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
				'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->cuti_id . '" data-field_type="cuti"><i class="fas fa-pencil-alt-square-o"></i></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn btn-outline-danger btn-sm m-b-0-0 waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->cuti_id . '" data-token_type="cuti"><i class="fas fa-trash-restore-o"></i></button></span>',
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
			$this->load->view("admin/karyawans/detail_karyawan", $data);
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
				'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->emp_shift_id . '" data-field_type="shift"><i class="fas fa-pencil-alt-square-o"></i></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn btn-outline-danger btn-sm m-b-0-0 waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->emp_shift_id . '" data-token_type="shift"><i class="fas fa-trash-restore-o"></i></button></span>',
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

	public function location() {
		//set data
		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/karyawans/detail_karyawan", $data);
		} else {
			redirect('admin/');
		}

		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		$id = $this->uri->segment(4);
		$location = $this->Karyawans_model->set_location_karyawan($id);

		$data = array();

		foreach($location->result() as $r) {			
			$location_kntr = $this->Location_model->read_informasi_location($r->location_id);

			$duration = $this->Umb_model->set_date_format($r->from_date).' '.$this->lang->line('dashboard_to').' '.$this->Umb_model->set_date_format($r->to_date);
			if(!is_null($location_kntr)){
				$nama_location = $location_kntr[0]->nama_location;
			} else {
				$nama_location = '--';
			}

			$data[] = array(
				'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->location_kantor_id . '" data-field_type="location"><i class="fas fa-pencil-alt-square-o"></i></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn btn-outline-danger btn-sm m-b-0-0 waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->location_kantor_id . '" data-token_type="location"><i class="fas fa-trash-restore-o"></i></button></span>',
				$duration,
				$nama_location
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


	public function update() {

		if($this->input->post('edit_type')=='peringatan') {

			$id = $this->uri->segment(4);

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();

			$description = $this->input->post('description');
			$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);

			if($this->input->post('peringatan_ke')==='') {
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

			$data = array(
				'peringatan_ke' => $this->input->post('peringatan_ke'),
				'type_peringatan_id' => $this->input->post('type'),
				'description' => $qt_description,
				'subject' => $this->input->post('subject'),
				'peringatan_oleh' => $this->input->post('peringatan_oleh'),
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

	public function import() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('umb_import_karyawans').' | '.$this->Umb_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('umb_import_karyawans');
		$data['path_url'] = 'import_karyawans';		
		$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		$data['all_departments'] = $this->Department_model->all_departments();
		$data['all_penunjukans'] = $this->Penunjukan_model->all_penunjukans();
		$data['all_user_roles'] = $this->Roles_model->all_user_roles();
		$data['all_shifts_kantor'] = $this->Karyawans_model->all_shifts_kantor();
		$data['get_all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('92',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/karyawans/import_karyawans", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}		  
	}


	public function import_karyawans() {

		if($this->input->post('is_ajax')=='3') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();

			$csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');

			if($this->input->post('perusahaan_id')==='') {
				$Return['error'] = $this->lang->line('error_field_perusahaan');
			} else if($this->input->post('department_id')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_department');
			} else if($this->input->post('penunjukan_id')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_penunjukan');
			} else if($this->input->post('role')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_user_role');
			} else if($_FILES['file']['name']==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_imp_allowed_size');
			} else {
				if(in_array($_FILES['file']['type'],$csvMimes)){
					if(is_uploaded_file($_FILES['file']['tmp_name'])){

						if(filesize($_FILES['file']['tmp_name']) > 2000000) {
							$Return['error'] = $this->lang->line('umb_error_karyawans_import_size');
						} else {

							$csvFile = fopen($_FILES['file']['tmp_name'], 'r');

							fgetcsv($csvFile);

							while(($line = fgetcsv($csvFile)) !== FALSE){

								$data = array(
									'perusahaan_id' => $this->input->post('perusahaan_id'),
									'department_id' =>$this->input->post('department_id'),
									'penunjukan_id' => $this->input->post('penunjukan_id'),
									'user_role_id' => $this->input->post('role'),
									'shift_kantor_id' => 1,
									'is_active' => 1,
									'first_name' => $line[0],
									'last_name' => $line[1],
									'username' => $line[2],
									'email' => $line[3],
									'password' => $line[4],
									'karyawan_id' => $line[5],
									'tanggal_bergabung' => $line[6],
									'jenis_kelamin' => $line[7],
									'tanggal_lahir' => $line[8],
									'no_kontak' => $line[9],
									'alamat' => $line[10],
									'created_at' => date('Y-m-d h:i:s')
								);
								$result = $this->Karyawans_model->add($data);
							}					
							fclose($csvFile);

							$Return['result'] = $this->lang->line('umb_sukses_import_kehadiran');
						}
					}else{
						$Return['error'] = $this->lang->line('umb_error_tidak_import_karyawan');
					}
				}else{
					$Return['error'] = $this->lang->line('umb_error_invalid_file');
				}
			} 
			if($Return['error']!=''){
				$this->output($Return);
			}
			$this->output($Return);
			exit;
		}
	}

	public function delete_kontak() {

		if($this->input->post('data')=='delete_record') {

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$result = $this->Karyawans_model->delete_record_kontak($id);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_karyawan_kontak_dihapus');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}

	public function delete_document() {

		if($this->input->post('data')=='delete_record') {

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Karyawans_model->delete_record_document($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_karyawan_document_dihapus');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}

	public function delete_imgdocument() {

		if($this->input->post('data')=='delete_record') {

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');

			$id = $this->uri->segment(4);
			$result = $this->Karyawans_model->delete_record_imgdocument($id);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_karyawan_img_document_dihapus');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}

	public function delete_qualification() {

		if($this->input->post('data')=='delete_record') {

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = $this->uri->segment(4);
			$result = $this->Karyawans_model->delete_record_qualification($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_karyawan_qualification_dihapus');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}

	public function delete_pengalaman_kerja() {

		if($this->input->post('data')=='delete_record') {

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = $this->uri->segment(4);
			$result = $this->Karyawans_model->delete_record_pengalaman_kerja($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_karyawan_work_dihapus');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}

	public function delete_bank_account() {

		if($this->input->post('data')=='delete_record') {

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = $this->uri->segment(4);
			$result = $this->Karyawans_model->delete_record_bank_account($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_karyawan_bankaccount_dihapus');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}

	public function delete_kontrak() {

		if($this->input->post('data')=='delete_record') {

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = $this->uri->segment(4);
			$result = $this->Karyawans_model->delete_record_kontrak($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_karyawan_kontrak_dihapus');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}

	public function delete_cuti() {

		if($this->input->post('data')=='delete_record') {

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = $this->uri->segment(4);
			$result = $this->Karyawans_model->delete_record_cuti($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_karyawan_cuti_dihapus');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}

	public function delete_shift() {

		if($this->input->post('data')=='delete_record') {

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = $this->uri->segment(4);
			$result = $this->Karyawans_model->delete_record_shift($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_karyawan_shift_dihapus');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}

	public function delete_location() {

		if($this->input->post('data')=='delete_record') {

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = $this->uri->segment(4);
			$result = $this->Karyawans_model->delete_record_location($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_location_karyawan_dihapus');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}

	public function delete() {

		if($this->input->post('is_ajax')=='2') {

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = $this->uri->segment(4);
			$result = $this->Karyawans_model->delete_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_karyawan_current_dihapus');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}

	public function update_option_gaji() {

		if($this->input->post('type')=='karyawan_update_gaji') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();	
			if($this->input->post('type_upahh')=='1') {
				if($this->input->post('gaji_pokok')==='') {
					$Return['error'] = $this->lang->line('umb_karyawan_gaji_error_basic');
				}
			} else if($this->input->post('type_upahh')=='2') {
				if($this->input->post('upahh_harian')==='') {
					$Return['error'] = $this->lang->line('umb_karyawan_gaji_error_daily');
				}
			}

			if($Return['error']!=''){
				$this->output($Return);
			}
			$data = array(
				'type_upahh' => $this->input->post('type_upahh'),
				'gaji_pokok' => $this->input->post('gaji_pokok'),
				'upahh_harian' => $this->input->post('upahh_harian')
			);
			$id = $this->input->post('user_id');
			$result = $this->Karyawans_model->basic_info($data,$id);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_karyawan_diperbarui_gaji_success');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function set_lembur() {

		if($this->input->post('type')=='krywn_lembur') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();	
			if($this->input->post('type_lembur')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_set_title_lembur_error');
			} else if($this->input->post('no_of_days')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_set_lembur_no_of_days_error');
			} else if($this->input->post('jam_lembur')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_set_jam_lembur_error');
			} else if($this->input->post('nilai_lembur')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_set_nilai_lembur_error');
			}

			if($Return['error']!=''){
				$this->output($Return);
			}
			$data = array(
				'karyawan_id' => $this->input->post('user_id'),
				'type_lembur' => $this->input->post('type_lembur'),
				'no_of_days' => $this->input->post('no_of_days'),
				'jam_lembur' => $this->input->post('jam_lembur'),
				'nilai_lembur' => $this->input->post('nilai_lembur')
			);
			$id = $this->input->post('user_id');
			$result = $this->Karyawans_model->add_gaji_lembur($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_karyawan_ditambahkan_lembur_success');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function update_info_lembur() {

		if($this->input->post('type')=='e_lembur_info') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();	
			if($this->input->post('type_lembur')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_set_title_lembur_error');
			} else if($this->input->post('no_of_days')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_set_lembur_no_of_days_error');
			} else if($this->input->post('jam_lembur')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_set_jam_lembur_error');
			} else if($this->input->post('nilai_lembur')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_set_nilai_lembur_error');
			}

			if($Return['error']!=''){
				$this->output($Return);
			}
			$id = $this->input->post('e_field_id');
			$data = array(
				'type_lembur' => $this->input->post('type_lembur'),
				'no_of_days' => $this->input->post('no_of_days'),
				'jam_lembur' => $this->input->post('jam_lembur'),
				'nilai_lembur' => $this->input->post('nilai_lembur')
			);
			$result = $this->Karyawans_model->update_record_gaji_lembur($data,$id);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_karyawan_diperbarui_lembur_success');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function option_tunjangan_karyawan() {

		if($this->input->post('type')=='karyawan_update_tunjanagan') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();	
			if($this->input->post('title_tunjanagan')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_set_title_tunjanagan_error');
			} else if($this->input->post('jumlah_tunjanagan')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_set_jumlah_tunjanagan_error');
			}

			if($Return['error']!=''){
				$this->output($Return);
			}
			$data = array(
				'title_tunjanagan' => $this->input->post('title_tunjanagan'),
				'jumlah_tunjanagan' => $this->input->post('jumlah_tunjanagan'),
				'karyawan_id' => $this->input->post('user_id')
			);
			$result = $this->Karyawans_model->add_alary_tunjanagans($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_karyawan_set_tunjanagan_success');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function delete_all_tunjanagans() {

		if($this->input->post('data')=='delete_record') {

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = $this->uri->segment(4);
			$result = $this->Karyawans_model->delete_record_tunjanagan($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_karyawan_delete_tunjanagan_success');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}

	public function delete_all_potongans() {

		if($this->input->post('data')=='delete_record') {

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = $this->uri->segment(4);
			$result = $this->Karyawans_model->delete_record_pinajaman($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_karyawan_delete_pinajaman_success');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}

	public function delete_krywn_lembur() {

		if($this->input->post('data')=='delete_record') {

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = $this->uri->segment(4);
			$result = $this->Karyawans_model->delete_record_lembur($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_karyawan_delete_lembur_success');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}

	public function gaji_all_tunjanagans() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/karyawans/detail_karyawan", $data);
		} else {
			redirect('admin/');
		}

		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		$id = $this->uri->segment(4);
		$tunjanagans = $this->Karyawans_model->set_tunjanagans_karyawan($id);

		$data = array();
		/*$system = $this->Umb_model->read_setting_info(1);
		$default_currency = $this->Umb_model->read_currency_con_info($system[0]->default_currency_id);
		if(!is_null($default_currency)) {
			$current_rate = $default_currency[0]->to_currency_rate;
			$current_title = $default_currency[0]->to_currency_title;
		} else {
			$current_rate = 1;
			$current_title = 'IDR';
		}*/

		foreach($tunjanagans->result() as $r) {			
		//$current_jumlah = $r->jumlah_tunjanagan * $current_rate;
			$data[] = array(
				'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->tunjanagan_id . '" data-field_type="gaji_tunjanagan"><span class="fas fa-pencil-alt"></span></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->tunjanagan_id . '" data-token_type="all_tunjanagans"><span class="fas fa-trash-restore"></span></button></span>',
				$r->title_tunjanagan,
				$r->jumlah_tunjanagan
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $tunjanagans->num_rows(),
			"recordsFiltered" => $tunjanagans->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}
	
	public function gaji_lembur() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/karyawans/detail_karyawan", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$id = $this->uri->segment(4);
		$lembur = $this->Karyawans_model->set_karyawan_lembur($id);
		$system = $this->Umb_model->read_setting_info(1);
		$data = array();

		foreach($lembur->result() as $r) {			
			$current_jumlah = $r->nilai_lembur;
			$data[] = array(
				'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->gaji_lembur_id . '" data-field_type="krywn_lembur"><span class="fas fa-pencil-alt"></span></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->gaji_lembur_id . '" data-token_type="krywn_lembur"><span class="fas fa-trash-restore"></span></button></span>',
				$r->type_lembur,
				$r->no_of_days,
				$r->jam_lembur,
				$current_jumlah
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $lembur->num_rows(),
			"recordsFiltered" => $lembur->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}
	
	public function gaji_all_potongans() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/karyawans/detail_karyawan", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$id = $this->uri->segment(4);
		$potongans = $this->Karyawans_model->set_potongans_karyawan($id);
		/*$system = $this->Umb_model->read_setting_info(1);
		$default_currency = $this->Umb_model->read_currency_con_info($system[0]->default_currency_id);
		if(!is_null($default_currency)) {
			$current_rate = $default_currency[0]->to_currency_rate;
			$current_title = $default_currency[0]->to_currency_title;
		} else {
			$current_rate = 1;
			$current_title = 'USD';
		}*/
		$data = array();

		foreach($potongans->result() as $r) {		
			
			$sdate = $this->Umb_model->set_date_format($r->start_date);
			$edate = $this->Umb_model->set_date_format($r->end_date);	
		// loan time
			if($r->waktu_pinjaman < 2) {
				$waktu_pinjaman = $r->waktu_pinjaman. ' '.$this->lang->line('umb_karyawan_waktu_pinjaman_single_month');
			} else {
				$waktu_pinjaman = $r->waktu_pinjaman. ' '.$this->lang->line('umb_karyawan_waktu_pinjaman_more_months');
			}
		//$current_jumlah = $r->angsuran_bulanan * $current_rate;
		//$eoption_removed = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-info waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->potongan_pinjaman_id . '" data-field_type="gaji_pinjaman"><span class="fas fa-pencil-alt"></span></button></span>';
			$data[] = array(
				'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->potongan_pinjaman_id . '" data-token_type="all_potongans"><span class="fas fa-trash-restore"></span></button></span>',
				$r->title_potongan_pinjaman,
				$r->angsuran_bulanan,
				$sdate,
				$edate,
				$waktu_pinjaman
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $potongans->num_rows(),
			"recordsFiltered" => $potongans->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}
	

	public function info_update_pinjaman() {
		
		if($this->input->post('type')=='pinjaman_info') {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$reason = $this->input->post('reason');
			$qt_reason = htmlspecialchars(addslashes($reason), ENT_QUOTES);
			$start_date = $this->input->post('start_date');
			$end_date = $this->input->post('end_date');
			$st_date = strtotime($start_date);
			$ed_date = strtotime($end_date);
			
			$id = $this->input->post('e_field_id');
			

			if($this->input->post('title_potongan_pinjaman')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_set_pinjaman_title_error');
			} else if($this->input->post('angsuran_bulanan')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_set_mins_title_error');
			} else if($this->input->post('start_date')==='') {
				$Return['error'] = $this->lang->line('umb_error_start_date');
			} else if($this->input->post('end_date')==='') {
				$Return['error'] = $this->lang->line('umb_error_end_date');
			} else if($st_date > $ed_date) {
				$Return['error'] = $this->lang->line('umb_error_start_end_date');
			}
			
			if($Return['error']!=''){
				$this->output($Return);
			}
			
			$data = array(
				'title_potongan_pinjaman' => $this->input->post('title_potongan_pinjaman'),
				'reason' => $qt_reason,
				'angsuran_bulanan' => $this->input->post('angsuran_bulanan'),
				'start_date' => $this->input->post('start_date'),
				'end_date' => $this->input->post('end_date')
			);
			
			$result = $this->Karyawans_model->update_record_gaji_pinjaman($data,$id);
			
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_karyawan_update_pinjaman_success');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function info_pinjaman_karyawan() {
		
		if($this->input->post('type')=='pinjaman_info') {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$reason = $this->input->post('reason');
			$qt_reason = htmlspecialchars(addslashes($reason), ENT_QUOTES);
			$start_date = $this->input->post('start_date');
			$end_date = $this->input->post('end_date');
			$st_date = strtotime($start_date);
			$ed_date = strtotime($end_date);
			
			$user_id = $this->input->post('user_id');
			

			if($this->input->post('title_potongan_pinjaman')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_set_pinjaman_title_error');
			} else if($this->input->post('angsuran_bulanan')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_set_mins_title_error');
			} else if($this->input->post('start_date')==='') {
				$Return['error'] = $this->lang->line('umb_error_start_date');
			} else if($this->input->post('end_date')==='') {
				$Return['error'] = $this->lang->line('umb_error_end_date');
			} else if($st_date > $ed_date) {
				$Return['error'] = $this->lang->line('umb_error_start_end_date');
			}
			
			if($Return['error']!=''){
				$this->output($Return);
			}
			
			$tm = $this->Karyawans_model->get_month_diff($this->input->post('start_date'),$this->input->post('end_date'));
			if($tm < 1) {
				$m_ins = $this->input->post('angsuran_bulanan');
			} else {
				$m_ins = $this->input->post('angsuran_bulanan')/$tm;
			}
			
			$data = array(
				'title_potongan_pinjaman' => $this->input->post('title_potongan_pinjaman'),
				'reason' => $qt_reason,
				'angsuran_bulanan' => $this->input->post('angsuran_bulanan'),
				'start_date' => $this->input->post('start_date'),
				'end_date' => $this->input->post('end_date'),
				'waktu_pinjaman' => $tm,
				'pinjaman_jumlah_potongan' => $m_ins,
				'karyawan_id' => $user_id
			);
			
			$result = $this->Karyawans_model->add_gaji_pinjaman($data);
			
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_karyawan_add_pinjaman_success');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function set_statutory_potongans() {
		
		if($this->input->post('type')=='statutory_info') {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();	
			
			$data = array(
				'gaji_ssempee' => $this->input->post('gaji_ssempee'),
				'gaji_ssempeer' => $this->input->post('gaji_ssempeer'),
				'gaji_pajak_pendapatan' => $this->input->post('gaji_pajak_pendapatan')
			);
			$id = $this->input->post('user_id');
			$result = $this->Karyawans_model->basic_info($data,$id);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_karyawan_diperbarui_statutory_potongans');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function set_pembayarans_lainnya() {
		
		if($this->input->post('type')=='pembayarans_lainnya') {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();	
			
			$data = array(
				'gaji_komisi' => $this->input->post('gaji_komisi'),
				'claims_gaji' => $this->input->post('claims_gaji'),
				'gaji_bayar_cuti' => $this->input->post('gaji_bayar_cuti'),
				'gaji_director_fees' => $this->input->post('gaji_director_fees'),
				'bayar_gaji_advance' => $this->input->post('bayar_gaji_advance')
			);
			$id = $this->input->post('user_id');
			$result = $this->Karyawans_model->basic_info($data,$id);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_karyawan_diperbarui_other_pay');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
}
