<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->database();
		$this->load->library('form_validation');
		
		$this->load->model("Awards_model");
		$this->load->model("Umb_model");
		$this->load->model("Eumb_model");
		$this->load->model("Transfers_model");
		$this->load->model("Department_model");
		$this->load->model("Location_model");
		$this->load->model("Promotion_model");
		$this->load->model("Keluhans_model");
		$this->load->model("Peringatan_model");
		$this->load->model("Training_model");
		$this->load->model("Trainers_model");
		$this->load->model("Penunjukan_model");
		$this->load->model("Performance_appraisal_model");
		$this->load->model('Files_model');
		$this->load->model("Timesheet_model");
		$this->load->model("Karyawans_model");
		$this->load->model("Roles_model");
		$this->load->model("Tickets_model");
		$this->load->model("Project_model");
		$this->load->model("Post_pekerjaan_model");
		$this->load->model("Pengumuman_model");
		$this->load->model("Perusahaan_model");
		$this->load->model("Biaya_model");
		$this->load->model("Perjalanan_model");
		$this->load->model("Payroll_model");
		$this->load->model("Assets_model");
		$this->load->model("Clients_model");
		$this->load->library('email');
	}
	
	
	public function output($Return=array()){
		
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		
		exit(json_encode($Return));
	}	

	public function awards() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('left_awards').' | '.$this->Umb_model->site_title();
		$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		$data['all_types_award'] = $this->Awards_model->all_types_award();
		$data['breadcrumbs'] = $this->lang->line('left_awards');
		$data['path_url'] = 'user/user_awards';
		if(!empty($session)){ 
			$data['subview'] = $this->load->view("karyawan/user/awards", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
		} else {
			redirect('admin/');
		}
		
	}
	
	public function read() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('award_id');
		$result = $this->Awards_model->read_informasi_award($id);
		$data = array(
			'award_id' => $result[0]->award_id,
			'perusahaan_id' => $result[0]->perusahaan_id,
			'karyawan_id' => $result[0]->karyawan_id,
			'type_award_id' => $result[0]->type_award_id,
			'gift_item' => $result[0]->gift_item,
			'photo_award' => $result[0]->photo_award,
			'cash_price' => $result[0]->cash_price,
			'bulan_tahun_award' => $result[0]->bulan_tahun_award,
			'informasi_award' => $result[0]->informasi_award,
			'description' => $result[0]->description,
			'created_at' => $result[0]->created_at,
			'all_karyawans' => $this->Umb_model->all_karyawans(),
			'all_types_award' => $this->Awards_model->all_types_award(),
			'get_all_perusahaans' => $this->Umb_model->get_perusahaans()
		);
		if(!empty($session)){ 
			$this->load->view('karyawan/user/dialog_award', $data);
		} else {
			redirect('admin/');
		}
	}
	
	public function list_award() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("karyawan/user/awards", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));		
		$award = $this->Awards_model->get_awards_karyawan($session['user_id']);
		$data = array();

		foreach($award->result() as $r) {
			$user = $this->Eumb_model->read_user_info($r->karyawan_id);		
			
			if(!is_null($user)){
				$full_name = $user[0]->first_name.' '.$user[0]->last_name;
				$krywn_id = $user[0]->karyawan_id;
			} else {
				$full_name = '--';	
				$krywn_id = '--';
			}
			$type_award = $this->Awards_model->read_informasi_type_award($r->type_award_id);
			if(!is_null($type_award)){
				$type_award = $type_award[0]->type_award;
			} else {
				$type_award = '--';	
			}
			$d = explode('-',$r->bulan_tahun_award);
			$get_month = date('F', mktime(0, 0, 0, $d[1], 10));
			$tanggal_award = $get_month.', '.$d[0];
			$currency = $this->Umb_model->currency_sign($r->cash_price);
			
			$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-info waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-award_id="'. $r->award_id . '"><span class="fa fa-eye"></span></button></span>',
				$krywn_id,
				$full_name,
				$type_award,
				$r->gift_item,
				$currency,
				$tanggal_award
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $award->num_rows(),
			"recordsFiltered" => $award->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}	 

	public function transfer() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('umb_transfers').' | '.$this->Umb_model->site_title();
		$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		$data['all_locations'] = $this->Umb_model->all_locations();
		$data['all_departments'] = $this->Department_model->all_departments();
		$data['breadcrumbs'] = $this->lang->line('umb_transfers');
		$data['path_url'] = 'user/user_transfer';
		if(!empty($session)){ 
			$data['subview'] = $this->load->view("karyawan/user/list_transfer", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
		} else {
			redirect('admin/');
		}
		
	}
	
	public function assets() {

		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		$system = $this->Umb_model->read_setting_info(1);
		if($system[0]->module_assets!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('umb_assets').' | '.$this->Umb_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('umb_assets');
		$data['path_url'] = 'user/user_assets';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		$data['all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		$data['all_kategoris_assets'] = $this->Assets_model->get_all_kategoris_assets();
		if(!empty($session)){ 
			$data['subview'] = $this->load->view("karyawan/user/assets/list_assets", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
		} else {
			redirect('admin/');
		}
	}

	public function list_assets() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		if(!empty($session)){ 
			$this->load->view("admin/languages/list_languages", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$assets = $this->Assets_model->get_assets_karyawan($session['user_id']);
		$data = array();

		foreach($assets->result() as $r) {						
			$perusahaan = $this->Umb_model->read_info_perusahaan($r->perusahaan_id);
			if(!is_null($perusahaan)){
				$prshn_nama = $perusahaan[0]->name;
			} else {
				$prshn_nama = '--';	
			}
			$kategori_assets = $this->Assets_model->read_info_kategori_assets($r->kategori_assets_id);
			if(!is_null($kategori_assets)){
				$kategori = $kategori_assets[0]->nama_kategori;
			} else {
				$kategori = '--';	
			}
			if($r->sedang_bekerja==1){
				$bekerja = $this->lang->line('umb_yes');
			} else {
				$bekerja = $this->lang->line('umb_no');
			}
			$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-info waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-asset_id="'. $r->assets_id . '"><span class="fa fa-eye"></span></button></span>',
				$r->name,
				$kategori,
				$r->kode_asset_perusahaan,
				$bekerja,
				$prshn_nama
			);
		}
		$output = array(
			"draw" => $draw,
			"recordsTotal" => $assets->num_rows(),
			"recordsFiltered" => $assets->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function list_transfer() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("karyawan/user/list_transfer", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$transfer = $this->Transfers_model->get_karyawan_transfers($session['user_id']);
		$data = array();

		foreach($transfer->result() as $r) {
			$user = $this->Eumb_model->read_user_info($r->added_by);
			if(!is_null($user)){
				$full_name = $user[0]->first_name.' '.$user[0]->last_name;
			} else {
				$full_name = '--';	
			}
			$karyawan = $this->Eumb_model->read_user_info($r->karyawan_id);
			if(!is_null($karyawan)){
				$nama_karyawan = $karyawan[0]->first_name.' '.$karyawan[0]->last_name;
			} else {
				$nama_karyawan = '--';	
			}
			$tanggal_transfer = $this->Umb_model->set_date_format($r->tanggal_transfer);
			$department = $this->Department_model->read_informasi_department($r->transfer_department);
			if(!is_null($department)){
				$nama_department = $department[0]->nama_department;
			} else {
				$nama_department = '--';	
			}
			$location = $this->Location_model->read_informasi_location($r->transfer_location);
			if(!is_null($location)){
				$nama_location = $location[0]->nama_location;
			} else {
				$nama_location = '--';	
			}
			if($r->status==0): 
				$status = $this->lang->line('umb_pending');
			elseif($r->status==1): 
				$status = $this->lang->line('umb_accepted'); 
			else: 
				$status = $this->lang->line('umb_rejected'); 
			endif;

			$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-info waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-transfer_id="'. $r->transfer_id . '"><span class="fa fa-eye"></span></button></span>',
				$nama_karyawan,
				$tanggal_transfer,
				$nama_department,
				$nama_location,
				$status,
				$full_name
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $transfer->num_rows(),
			"recordsFiltered" => $transfer->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function read_transfer() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('transfer_id');
		$result = $this->Transfers_model->read_informasi_transfer($id);
		$data = array(
			'transfer_id' => $result[0]->transfer_id,
			'perusahaan_id' => $result[0]->perusahaan_id,
			'karyawan_id' => $result[0]->karyawan_id,
			'tanggal_transfer' => $result[0]->tanggal_transfer,
			'transfer_department' => $result[0]->transfer_department,
			'transfer_location' => $result[0]->transfer_location,
			'description' => $result[0]->description,
			'status' => $result[0]->status,
			'all_karyawans' => $this->Umb_model->all_karyawans(),
			'all_locations' => $this->Umb_model->all_locations(),
			'get_all_perusahaans' => $this->Umb_model->get_perusahaans(),
			'all_departments' => $this->Department_model->all_departments()
		);
		if(!empty($session)){ 
			$this->load->view('admin/transfers/dialog_transfer', $data);
		} else {
			redirect('admin/');
		}
	}	

	public function promotion() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('left_promotions').' | '.$this->Umb_model->site_title();
		$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		$data['breadcrumbs'] = $this->lang->line('left_promotions');
		$data['path_url'] = 'user/user_promotion';
		if(!empty($session)){ 
			$data['subview'] = $this->load->view("karyawan/user/list_promotion", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
		} else {
			redirect('admin/');
		}
		
	}
	
	public function read_promotion() {
		
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('promotion_id');
		$result = $this->Promotion_model->read_informasi_promotion($id);
		$data = array(
			'promotion_id' => $result[0]->promotion_id,
			'perusahaan_id' => $result[0]->perusahaan_id,
			'karyawan_id' => $result[0]->karyawan_id,
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
	
	public function list_promotion(){

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("karyawan/user/list_promotion", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$promotion = $this->Promotion_model->get_karyawan_promotions($session['user_id']);
		$data = array();
		foreach($promotion->result() as $r) {
			$user = $this->Eumb_model->read_user_info($r->added_by);
			if(!is_null($user)){
				$full_name = $user[0]->first_name.' '.$user[0]->last_name;
			} else {
				$full_name = '--';	
			}
			$karyawan = $this->Eumb_model->read_user_info($r->karyawan_id);
			if(!is_null($karyawan)){
				$nama_karyawan = $karyawan[0]->first_name.' '.$karyawan[0]->last_name;
			} else {
				$nama_karyawan = '--';	
			}
			$tanggal_promotion = $this->Umb_model->set_date_format($r->tanggal_promotion);
			$description =  html_entity_decode($r->description);
			$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-info waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-promotion_id="'. $r->promotion_id . '"><span class="fa fa-eye"></span></button></span>',
				$nama_karyawan,
				$r->title,
				$tanggal_promotion,
				$full_name
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

	public function keluhans() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('left_keluhans').' | '.$this->Umb_model->site_title();
		$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		$data['breadcrumbs'] = $this->lang->line('left_keluhans');
		$data['path_url'] = 'user/user_keluhans';
		if(!empty($session)){ 
			$data['subview'] = $this->load->view("karyawan/user/list_keluhan", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
		} else {
			redirect('admin/');
		}
		
	}
	
	public function read_keluhans() {

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
	
	public function list_keluhan() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("karyawan/user/list_keluhan", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$keluhan = $this->Keluhans_model->get_keluhans();
		$data = array();
		foreach($keluhan->result() as $r) {
			$aim = explode(',',$r->keluhan_terhadap);
			foreach($aim as $dIds) {
				if($session['user_id'] == $dIds) {	
					$user = $this->Eumb_model->read_user_info($r->keluhan_dari);
					if(!is_null($user)){
						$keluhan_dari = $user[0]->first_name.' '.$user[0]->last_name;
					} else {
						$keluhan_dari = '--';	
					}
					$tanggal_keluhan = $this->Umb_model->set_date_format($r->tanggal_keluhan);
					if($r->keluhan_terhadap == '') {
						$ol = '--';
					} else {
						$ol = '<ol class="nl">';
						foreach(explode(',',$r->keluhan_terhadap) as $tunjuk_id) {
							$_prshn_nama = $this->Eumb_model->read_user_info($tunjuk_id);
							if(!is_null($_prshn_nama)){
								$ol .= '<li>'.$_prshn_nama[0]->first_name.' '.$_prshn_nama[0]->last_name.'</li>';
							} else {
								$ol .= '';
							}
						}
						$ol .= '</ol>';
					}
					if($r->status==0): 
						$status = $this->lang->line('umb_pending');
					elseif($r->status==1):
						$status = $this->lang->line('umb_accepted'); 
					else: 
						$status = $this->lang->line('umb_rejected'); 
					endif;
					$description =  html_entity_decode($r->description);
					$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-info waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-keluhan_id="'. $r->keluhan_id . '"><span class="fa fa-eye"></span></button></span>',
						$keluhan_dari,
						$ol,
						$r->title,
						$tanggal_keluhan,
						$status,
						$description
					);
				}
			} 
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

	public function peringatan() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('left_peringatans').' | '.$this->Umb_model->site_title();
		$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		$data['all_types_peringatan'] = $this->Peringatan_model->all_types_peringatan();
		$data['breadcrumbs'] = $this->lang->line('left_peringatans');
		$data['path_url'] = 'user/user_peringatan';
		if(!empty($session)){ 
			$data['subview'] = $this->load->view("karyawan/user/list_peringatan", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
		} else {
			redirect('admin/');
		}
		
	}
	
	public function list_peringatan() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("karyawan/user/list_peringatan", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$peringatan = $this->Peringatan_model->get_peringatan_karyawan($session['user_id']);
		$data = array();

		foreach($peringatan->result() as $r) {
			$user_by = $this->Eumb_model->read_user_info($r->peringatan_oleh);
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
			$description =  html_entity_decode($r->description);

			$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-info waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-peringatan_id="'. $r->peringatan_id . '"><span class="fa fa-eye"></span></button></span>',
				$tanggal_peringatan,
				$r->subject,
				$wtype,
				$status,
				$peringatan_oleh,
				$description
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

	public function read_peringatan() {

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

	public function training() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('left_training').' | '.$this->Umb_model->site_title();
		$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		$data['all_trainers'] = $this->Trainers_model->all_trainers();
		$data['all_types_training'] = $this->Training_model->all_types_training();
		$data['breadcrumbs'] = $this->lang->line('left_training');
		$data['path_url'] = 'user/user_training';
		if(!empty($session)){ 
			$data['subview'] = $this->load->view("karyawan/user/list_training", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
		} else {
			redirect('admin/');
		}
		
	}
	
	public function list_training() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("karyawan/user/list_training", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$training = $this->Training_model->get_training();
		
		$data = array();

		foreach($training->result() as $r) {
			$aim = explode(',',$r->karyawan_id);
			foreach($aim as $dIds) {
				if($session['user_id'] == $dIds) {
					$type = $this->Training_model->read_informasi_type_training($r->type_training_id);
					if(!is_null($type)){
						$itype = $type[0]->type;
					} else {
						$itype = '--';	
					}
					$trainer = $this->Trainers_model->read_informasi_trainer($r->trainer_id);
					if(!is_null($trainer)){
						$nama_trainer = $trainer[0]->first_name.' '.$trainer[0]->last_name;
					} else {
						$nama_trainer = '--';	
					}
					$start_date = $this->Umb_model->set_date_format($r->start_date);
					$finish_date = $this->Umb_model->set_date_format($r->finish_date);
					$tanggal_training = $start_date.' '.$this->lang->line('dashboard_to').' '.$finish_date;
					$biaya_training = $this->Umb_model->currency_sign($r->biaya_training);
					if($r->karyawan_id == '') {
						$ol = '--';
					} else {
						$ol = '<ol class="nl">';
						foreach(explode(',',$r->karyawan_id) as $uid) {
							$user = $this->Eumb_model->read_user_info($uid);
							$ol .= '<li>'.$user[0]->first_name.' '.$user[0]->last_name.'</li>';
						}
						$ol .= '</ol>';
					}
					if($r->status_training==0): 
						$status = $this->lang->line('umb_pending');
					elseif($r->status_training==1): 
						$status = $this->lang->line('umb_started'); 
					elseif($r->status_training==2): 
						$status = $this->lang->line('umb_completed');
					else: 
						$status = $this->lang->line('umb_terminated'); 
					endif;

					$data[] = array(
						'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_view_details').'"><a href="'.site_url().'admin/user/details_training/'.$r->training_id.'/"><button type="button" class="btn icon-btn btn-sm btn-outline-info waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span>',
						$ol,
						$itype,
						$nama_trainer,
						$tanggal_training,
						$biaya_training,
						$status
					);
				}
			} 
		} 
		$output = array(
			"draw" => $draw,
			"recordsTotal" => $training->num_rows(),
			"recordsFiltered" => $training->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function details_training() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title().' | '.$this->Umb_model->site_title();
		$id = $this->uri->segment(4);
		$result = $this->Training_model->read_informasi_training($id);
		if(is_null($result)){
			redirect('admin/user/training');
		}
		$type = $this->Training_model->read_informasi_type_training($result[0]->type_training_id);
		if(!is_null($type)){
			$itype = $type[0]->type;
		} else {
			$itype = '--';	
		}
		$trainer = $this->Trainers_model->read_informasi_trainer($result[0]->trainer_id);
		if(!is_null($trainer)){
			$nama_trainer = $trainer[0]->first_name.' '.$trainer[0]->last_name;
		} else {
			$nama_trainer = '--';	
		}
		$data = array(
			'title' => $this->lang->line('umb_details_training').' | '.$this->Umb_model->site_title(),
			'training_id' => $result[0]->training_id,
			'perusahaan_id' => $result[0]->perusahaan_id,
			'type' => $itype,
			'nama_trainer' => $nama_trainer,
			'biaya_training' => $result[0]->biaya_training,
			'start_date' => $result[0]->start_date,
			'finish_date' => $result[0]->finish_date,
			'created_at' => $result[0]->created_at,
			'description' => $result[0]->description,
			'performance' => $result[0]->performance,
			'status_training' => $result[0]->status_training,
			'remarks' => $result[0]->remarks,
			'karyawan_id' => $result[0]->karyawan_id,
			'all_karyawans' => $this->Umb_model->all_karyawans(),
			'all_perusahaans' => $this->Umb_model->get_perusahaans()
		);
		$data['breadcrumbs'] = $this->lang->line('umb_details_training');
		$data['path_url'] = 'user/user_details_training';
		if(!empty($session)){ 
			$data['subview'] = $this->load->view("karyawan/user/details_training", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
		} else {
			redirect('admin/');
		}		  
	}

	public function shift_kantor() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('left_shift_kantor').' | '.$this->Umb_model->site_title();
		$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		$data['breadcrumbs'] = $this->lang->line('left_shift_kantor');
		$data['path_url'] = 'user/user_shift_kantor';
		if(!empty($session)){
			$data['subview'] = $this->load->view("karyawan/user/shift_kantor", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
		} else {
			redirect('admin/');
		}
		
	}
	
	public function list_shift_kantor() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("karyawan/user/shift_kantor", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));		
		$user = $this->Umb_model->get_karyawan_row($session['user_id']);
		
		$data = array();
		//foreach($user->result() as $r) {
		//$from_date = $this->Umb_model->set_date_format($r->from_date);
		//$to_date = $this->Umb_model->set_date_format($r->to_date);
		//$shift_date = $from_date .' ' . $this->lang->line('dashboard_to').' '.$to_date;
		$shift = $this->Umb_model->get_karyawan_shift_kantor($user[0]->shift_kantor_id);
		if(!is_null($shift)){
			$nama_shift = $shift[0]->nama_shift;
		} else {
			$nama_shift = '--';	
		}
		$data[] = array(
			$nama_shift
		);
		$output = array(
			"draw" => $draw,
			// "recordsTotal" => $user->num_rows(),
			// "recordsFiltered" => $user->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function performance() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('left_performance').' | '.$this->Umb_model->site_title();
		$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		$data['breadcrumbs'] = $this->lang->line('left_performance');
		$data['path_url'] = 'user/user_performance';
		if(!empty($session)){ 
			$data['subview'] = $this->load->view("karyawan/user/list_performance", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
		} else {
			redirect('admin/');
		}
		
	}
	
	public function list_appraisal(){

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("karyawan/user/list_performance", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$appraisal = $this->Performance_appraisal_model->get_karyawan_performance_appraisal($session['user_id']);
		$data = array();
		foreach($appraisal->result() as $r) {
			$user = $this->Eumb_model->read_user_info($r->karyawan_id);
			if(!is_null($user)){
				$full_name = $user[0]->first_name.' '.$user[0]->last_name;
				$department = $this->Department_model->read_informasi_department($user[0]->department_id);
				if(!is_null($department)){
					$nama_department = $department[0]->nama_department;
				} else {
					$nama_department = '--';
				}
				$penunjukan = $this->Penunjukan_model->read_informasi_penunjukan($user[0]->penunjukan_id);
				if(!is_null($penunjukan)){
					$nama_penunjukan = $penunjukan[0]->nama_penunjukan;
				} else {
					$nama_penunjukan = '--';
				}
			} else {
				$full_name = '--';
				$nama_penunjukan = '--';
				$nama_department = '--';
			}
			
			$d = explode('-',$r->appraisal_year_month);
			$get_month = date('F', mktime(0, 0, 0, $d[1], 10));
			$ap_date = $get_month.', '.$d[0];
			$data[] = array(
				'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-info waves-effect waves-light view-data" data-toggle="modal" data-target="#edit-modal-data" data-p_appraisal_id="'. $r->performance_appraisal_id . '"><span class="fa fa-eye"></span></button></span>',
				$full_name,
				$nama_penunjukan,
				$nama_department,
				$ap_date
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $appraisal->num_rows(),
			"recordsFiltered" => $appraisal->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}
	
	public function read_performance() {
		
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('performance_appraisal_id');
		$result = $this->Performance_appraisal_model->read_informasi_appraisal($id);
		$data = array(
			'performance_appraisal_id' => $result[0]->performance_appraisal_id,
			'karyawan_id' => $result[0]->karyawan_id,
			'perusahaan_id' => $result[0]->perusahaan_id,
			'appraisal_year_month' => $result[0]->appraisal_year_month,
			'customer_pengalaman' => $result[0]->customer_pengalaman,
			'marketing' => $result[0]->marketing,
			'management' => $result[0]->management,
			'administration' => $result[0]->administration,
			'presentation_skill' => $result[0]->presentation_skill,
			'quality_of_work' => $result[0]->quality_of_work,
			'efficiency' => $result[0]->efficiency,
			'integrity' => $result[0]->integrity,
			'professionalism' => $result[0]->professionalism,
			'team_work' => $result[0]->team_work,
			'critical_thinking' => $result[0]->critical_thinking,
			'conflict_management' => $result[0]->conflict_management,
			'kehadiran' => $result[0]->kehadiran,
			'ability_to_meet_deadline' => $result[0]->ability_to_meet_deadline,
			'remarks' => $result[0]->remarks,
			'get_all_perusahaans' => $this->Umb_model->get_perusahaans(),
			'all_karyawans' => $this->Umb_model->all_karyawans()
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/performance/dialog_appraisal', $data);
		} else {
			redirect('admin/');
		}
	}

	public function kehadiran() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('dashboard_kehadiran').' | '.$this->Umb_model->site_title();
		$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		$data['breadcrumbs'] = $this->lang->line('dashboard_kehadiran');
		$data['path_url'] = 'user/user_kehadiran';
		if(!empty($session)){ 
			$data['subview'] = $this->load->view("karyawan/user/kehadiran", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
		} else {
			redirect('admin/');
		}
		
	}

	public function list_tanggal_bijaksana() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("karyawan/user/kehadiran", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$karyawan_id = $this->input->get("user_id");
		$karyawan = $this->Eumb_model->read_user_info($karyawan_id);
		$start_date = new DateTime( $this->input->get("start_date"));
		$end_date = new DateTime( $this->input->get("end_date") );
		$end_date = $end_date->modify( '+1 day' ); 
		$interval_re = new DateInterval('P1D');
		$date_range = new DatePeriod($start_date, $interval_re ,$end_date);
		$kehadiran_arr = array();
		$data = array();
		foreach($date_range as $date) {
			$tanggal_kehadiran =  $date->format("Y-m-d");
			//foreach($karyawan->result() as $r) {
			//$full_name = $r->first_name.' '.$r->last_name;
			$get_day = strtotime($tanggal_kehadiran);
			$day = date('l', $get_day);
			$shift_kantor = $this->Timesheet_model->read_informasi_shift_kantor($karyawan[0]->shift_kantor_id);
			if($day == 'Monday') {
				if($shift_kantor[0]->senen_waktu_masuk==''){
					$in_time = '00:00:00';
					$out_time = '00:00:00';
				} else {
					$in_time = $shift_kantor[0]->senen_waktu_masuk;
					$out_time = $shift_kantor[0]->senen_waktu_pulang;
				}
			} else if($day == 'Tuesday') {
				if($shift_kantor[0]->selasa_waktu_masuk==''){
					$in_time = '00:00:00';
					$out_time = '00:00:00';
				} else {
					$in_time = $shift_kantor[0]->selasa_waktu_masuk;
					$out_time = $shift_kantor[0]->selasa_waktu_pulang;
				}
			} else if($day == 'Wednesday') {
				if($shift_kantor[0]->rabu_waktu_masuk==''){
					$in_time = '00:00:00';
					$out_time = '00:00:00';
				} else {
					$in_time = $shift_kantor[0]->rabu_waktu_masuk;
					$out_time = $shift_kantor[0]->rabu_waktu_pulang;
				}
			} else if($day == 'Thursday') {
				if($shift_kantor[0]->kamis_waktu_masuk==''){
					$in_time = '00:00:00';
					$out_time = '00:00:00';
				} else {
					$in_time = $shift_kantor[0]->kamis_waktu_masuk;
					$out_time = $shift_kantor[0]->kamis_waktu_pulang;
				}
			} else if($day == 'Friday') {
				if($shift_kantor[0]->jumat_waktu_masuk==''){
					$in_time = '00:00:00';
					$out_time = '00:00:00';
				} else {
					$in_time = $shift_kantor[0]->jumat_waktu_masuk;
					$out_time = $shift_kantor[0]->jumat_waktu_pulang;
				}
			} else if($day == 'Saturday') {
				if($shift_kantor[0]->sabtu_waktu_masuk==''){
					$in_time = '00:00:00';
					$out_time = '00:00:00';
				} else {
					$in_time = $shift_kantor[0]->sabtu_waktu_masuk;
					$out_time = $shift_kantor[0]->sabtu_waktu_pulang;
				}
			} else if($day == 'Sunday') {
				if($shift_kantor[0]->minggu_waktu_masuk==''){
					$in_time = '00:00:00';
					$out_time = '00:00:00';
				} else {
					$in_time = $shift_kantor[0]->minggu_waktu_masuk;
					$out_time = $shift_kantor[0]->minggu_waktu_pulang;
				}
			}
			$status_kehadiran = '';
			$check = $this->Timesheet_model->check_kehadiran_pertama_masuk($karyawan[0]->user_id,$tanggal_kehadiran);
			if($check->num_rows() > 0){
				$kehadiran = $this->Timesheet_model->kehadiran_pertama_masuk($karyawan[0]->user_id,$tanggal_kehadiran);
				$clock_in = new DateTime($kehadiran[0]->clock_in);
				$clock_in2 = $clock_in->format('h:i a');
				$waktu_kantor =  new DateTime($in_time.' '.$tanggal_kehadiran);
				$waktu_kantor_new = strtotime($in_time.' '.$tanggal_kehadiran);
				$clock_in_time_new = strtotime($kehadiran[0]->clock_in);
				if($clock_in_time_new <= $waktu_kantor_new) {
					$total_time_l = '00:00';
				} else {
					$interval_late = $clock_in->diff($waktu_kantor);
					$hours_l   = $interval_late->format('%h');
					$minutes_l = $interval_late->format('%i');			
					$total_time_l = $hours_l ."h ".$minutes_l."m";
				}
				$total_hrs = $this->Timesheet_model->total_kehadiran_jam_bekerja($karyawan[0]->user_id,$tanggal_kehadiran);
				$hrs_old_int1 = '';
				$Total = '';
				$Tistrahat = '';
				$total_time_rs = '';
				$hrs_old_int_res1 = '';
				foreach ($total_hrs->result() as $jam_kerja){		
					$timee = $jam_kerja->total_kerja.':00';
					$str_time =$timee;
					$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);
					
					sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
					
					$hrs_old_seconds = $hours * 3600 + $minutes * 60 + $seconds;
					
					$hrs_old_int1 += $hrs_old_seconds;
					
					$Total = gmdate("H:i", $hrs_old_int1);	
				}
				if($Total=='') {
					$total_kerja = '00:00';
				} else {
					$total_kerja = $Total;
				}
				$total_istirahat = $this->Timesheet_model->total_istirahat_kehadiran($karyawan[0]->user_id,$tanggal_kehadiran);
				foreach ($total_istirahat->result() as $istirahat){			
					$str_time_rs = $istirahat->total_istirahat.':00';
					//$str_time_rs =$timee_rs;
					$str_time_rs = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time_rs);
					sscanf($str_time_rs, "%d:%d:%d", $hours_rs, $minutes_rs, $seconds_rs);
					$hrs_old_seconds_rs = $hours_rs * 3600 + $minutes_rs * 60 + $seconds_rs;
					$hrs_old_int_res1 += $hrs_old_seconds_rs;
					$total_time_rs = gmdate("H:i", $hrs_old_int_res1);
				}
				$status = $kehadiran[0]->status_kehadiran;
				if($total_time_rs=='') {
					$Tistrahat = '00:00';
				} else {
					$Tistrahat = $total_time_rs;
				}
				
			} else {
				$clock_in2 = '-';
				$total_time_l = '00:00';
				$total_kerja = '00:00';
				$Tistrahat = '00:00';

				$chck_tanggal_lbr = $this->Timesheet_model->check_tanggal_libur($tanggal_kehadiran);
				$libur_arr = array();
				if($chck_tanggal_lbr->num_rows() == 1){
					$h_date = $this->Timesheet_model->tanggal_libur($tanggal_kehadiran);
					$begin = new DateTime( $h_date[0]->start_date );
					$end = new DateTime( $h_date[0]->end_date);
					$end = $end->modify( '+1 day' ); 
					
					$interval = new DateInterval('P1D');
					$daterange = new DatePeriod($begin, $interval ,$end);
					
					foreach($daterange as $date){
						$libur_arr[] =  $date->format("Y-m-d");
					}
				} else {
					$libur_arr[] = '99-99-99';
				}
				
				$chck_tanggal_cuti = $this->Timesheet_model->chcek_tanggal_cuti($karyawan[0]->user_id,$tanggal_kehadiran);
				$cuti_arr = array();
				if($chck_tanggal_cuti->num_rows() == 1){
					$tanggal_cuti = $this->Timesheet_model->tanggal_cuti($karyawan[0]->user_id,$tanggal_kehadiran);
					$begin1 = new DateTime( $tanggal_cuti[0]->from_date );
					$end1 = new DateTime( $tanggal_cuti[0]->to_date);
					$end1 = $end1->modify( '+1 day' ); 
					
					$interval1 = new DateInterval('P1D');
					$daterange1 = new DatePeriod($begin1, $interval1 ,$end1);
					
					foreach($daterange1 as $date1){
						$cuti_arr[] =  $date1->format("Y-m-d");
					}	
				} else {
					$cuti_arr[] = '99-99-99';
				}
				if($shift_kantor[0]->senen_waktu_masuk == '' && $day == 'Monday') {
					$status = $this->lang->line('umb_libur');	
				} else if($shift_kantor[0]->selasa_waktu_masuk == '' && $day == 'Tuesday') {
					$status = $this->lang->line('umb_libur');	
				} else if($shift_kantor[0]->rabu_waktu_masuk == '' && $day == 'Wednesday') {
					$status = $this->lang->line('umb_libur');	
				} else if($shift_kantor[0]->kamis_waktu_masuk == '' && $day == 'Thursday') {
					$status = $this->lang->line('umb_libur');	
				} else if($shift_kantor[0]->jumat_waktu_masuk == '' && $day == 'Friday') {
					$status = $this->lang->line('umb_libur');	
				} else if($shift_kantor[0]->sabtu_waktu_masuk == '' && $day == 'Saturday') {
					$status = $this->lang->line('umb_libur');	
				} else if($shift_kantor[0]->minggu_waktu_masuk == '' && $day == 'Sunday') {
					$status = $this->lang->line('umb_libur');	
				} else if(in_array($tanggal_kehadiran,$libur_arr)) { 
					$status = $this->lang->line('umb_libur');
				} else if(in_array($tanggal_kehadiran,$cuti_arr)) {
					$status = $this->lang->line('umb_on_cuti');
				} 
				else {
					$status = $this->lang->line('umb_absent');
				}
			}

			$check_out = $this->Timesheet_model->check_kehadiran_pulang_pertama($karyawan[0]->user_id,$tanggal_kehadiran);		
			if($check_out->num_rows() == 1){
				$early_time =  new DateTime($out_time.' '.$tanggal_kehadiran);
				$first_out = $this->Timesheet_model->kehadiran_pulang_pertama($karyawan[0]->user_id,$tanggal_kehadiran);
				$clock_out = new DateTime($first_out[0]->clock_out);
				if ($first_out[0]->clock_out!='') {
					$clock_out2 = $clock_out->format('h:i a');
					$early_new_time = strtotime($out_time.' '.$tanggal_kehadiran);
					$clock_out_time_new = strtotime($first_out[0]->clock_out);
					if($early_new_time <= $clock_out_time_new) {
						$total_time_e = '00:00';
					} else {			
						$interval_lateo = $clock_out->diff($early_time);
						$hours_e   = $interval_lateo->format('%h');
						$minutes_e = $interval_lateo->format('%i');			
						$total_time_e = $hours_e ."h ".$minutes_e."m";
					}
					$waktu_lembur =  new DateTime($out_time.' '.$tanggal_kehadiran);
					$lembur2 = $waktu_lembur->format('h:i a');
					$waktu_lembur_baru = strtotime($out_time.' '.$tanggal_kehadiran);
					$clock_out_time_new1 = strtotime($first_out[0]->clock_out);
					if($clock_out_time_new1 <= $waktu_lembur_baru) {
						$lembur2 = '00:00';
					} else {			
						$interval_lateov = $clock_out->diff($waktu_lembur);
						$hours_ov   = $interval_lateov->format('%h');
						$minutes_ov = $interval_lateov->format('%i');			
						$lembur2 = $hours_ov ."h ".$minutes_ov."m";
					}
				} else {
					$clock_out2 =  '-';
					$total_time_e = '00:00';
					$lembur2 = '00:00';
				}
			} else {
				$clock_out2 =  '-';
				$total_time_e = '00:00';
				$lembur2 = '00:00';
			}
			$full_name = $karyawan[0]->first_name.' '.$karyawan[0]->last_name;
			$perusahaan = $this->Umb_model->read_info_perusahaan($karyawan[0]->perusahaan_id);
			if(!is_null($perusahaan)){
				$prshn_nama = $perusahaan[0]->name;
			} else {
				$prshn_nama = '--';	
			}	
			$tdate = $this->Umb_model->set_date_format($tanggal_kehadiran);
			$data[] = array(
				$full_name,
				$prshn_nama,
				$tdate,
				$status,
				$clock_in2,
				$clock_out2,
				$total_time_l,
				$total_time_e,
				$lembur2,
				$total_kerja,
				$Tistrahat
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => count($date_range),
			"recordsFiltered" => count($date_range),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function cuti() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('left_cuti').' | '.$this->Umb_model->site_title();
		$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		$data['all_types_cuti'] = $this->Timesheet_model->all_types_cuti();
		$data['breadcrumbs'] = $this->lang->line('left_cuti');
		$data['path_url'] = 'user/user_cuti';
		if(!empty($session)){ 
			$data['subview'] = $this->load->view("karyawan/user/cuti", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
		} else {
			redirect('hr');
		}
		
	}
	
	public function list_cuti() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("karyawan/user/cuti", $data);
		} else {
			redirect('hr');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));		
		$cuti = $this->Timesheet_model->get_karyawan_cutii($session['user_id']);
		$data = array();
		foreach($cuti->result() as $r) {
			$user = $this->Umb_model->read_user_info($r->karyawan_id);
			if(!is_null($user)){
				$full_name = $user[0]->first_name. ' '.$user[0]->last_name;
			} else {
				$full_name = '--';	
			}
			$type_cuti = $this->Timesheet_model->read_informasi_type_cuti($r->type_cuti_id);
			if(!is_null($type_cuti)){
				$type_name = $type_cuti[0]->type_name;
			} else {
				$type_name = '--';	
			}
			$applied_on = $this->Umb_model->set_date_format($r->applied_on);
			$duration = $this->Umb_model->set_date_format($r->from_date).' '.$this->lang->line('dashboard_to').' '.$this->Umb_model->set_date_format($r->to_date);
			if($r->status==1): $status = $this->lang->line('umb_pending'); elseif($r->status==2): $status = $this->lang->line('umb_approved'); elseif($r->status==3): $status = $this->lang->line('umb_rejected'); endif;
			$data[] = array(
				'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_view_details').'"><a href="'.site_url().'admin/user/details_cuti/id/'.$r->cuti_id.'/"><button type="button" class="btn icon-btn btn-sm btn-outline-info waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span>',
				$full_name,
				$type_name,
				$duration,
				$applied_on,
				$r->reason,
				$status
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
	
	public function add_cuti() {
		
		if($this->input->post('add_type')=='cuti') {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$start_date = $this->input->post('start_date');
			$end_date = $this->input->post('end_date');
			$remarks = $this->input->post('remarks');
			$st_date = strtotime($start_date);
			$ed_date = strtotime($end_date);
			$qt_remarks = htmlspecialchars(addslashes($remarks), ENT_QUOTES);
			if($this->input->post('type_cuti')==='') {
				$Return['error'] = $this->lang->line('umb_error_type_cuti_field');
			} else if($this->input->post('start_date')==='') {
				$Return['error'] = $this->lang->line('umb_error_start_date');
			} else if($this->input->post('end_date')==='') {
				$Return['error'] = $this->lang->line('umb_error_end_date');
			} else if($st_date > $ed_date) {
				$Return['error'] = $this->lang->line('umb_error_start_end_date');
			} /*else if($this->input->post('perusahaan_id')==='') {
				$Return['error'] = $this->lang->line('error_field_perusahaan');
			}*/ else if($this->input->post('karyawan_id')==='') {
				$Return['error'] = $this->lang->line('umb_error_karyawan_id');
			} else if($this->input->post('reason')==='') {
				$Return['error'] = $this->lang->line('umb_error_type_cuti_reason');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$sisa_cuti = $this->Timesheet_model->count_total_cutii($this->input->post('type_cuti'),$this->input->post('karyawan_id'));
			$type = $this->Timesheet_model->read_informasi_type_cuti($this->input->post('type_cuti'));
			if(!is_null($type)){
				$type_name = $type[0]->type_name;
				$total = $type[0]->days_per_year;
				$total_sisa_cuti = $total - $sisa_cuti;
			} else {
				$type_name = '--';	
				$total_sisa_cuti = 0;
			}
			if($total_sisa_cuti == 0){
				$Return['error'] = $this->lang->line('umb_cuti_limit_msg');
			}
			if($Return['error']!=''){
				$Return['csrf_hash'] = $this->security->get_csrf_hash();
				$this->output($Return);
			}
			$user = $this->Umb_model->read_user_info($this->input->post('karyawan_id'));
			if(!is_null($user)){
				$perusahaan_id = $user[0]->perusahaan_id;
			} else {
				$perusahaan_id = 1;	
			}
			$data = array(
				'karyawan_id' => $this->input->post('karyawan_id'),
				'perusahaan_id' => $perusahaan_id,
				'type_cuti_id' => $this->input->post('type_cuti'),
				'from_date' => $this->input->post('start_date'),
				'to_date' => $this->input->post('end_date'),
				'applied_on' => date('Y-m-d h:i:s'),
				'reason' => $this->input->post('reason'),
				'remarks' => $qt_remarks,
				'status' => '1',
				'created_at' => date('Y-m-d h:i:s')
			);
			$result = $this->Timesheet_model->add_record_cuti($data);

			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_cuti_ditambahkan');
				$setting = $this->Umb_model->read_setting_info(1);
				if($setting[0]->enable_email_notification == 'yes') {

					$this->email->set_mailtype("html");
					$cinfo = $this->Umb_model->read_info_setting_perusahaan(1);
					$template = $this->Umb_model->read_email_template(5);
					$user_info = $this->Umb_model->read_user_info($this->input->post('karyawan_id'));
					$full_name = $user_info[0]->first_name.' '.$user_info[0]->last_name;
					$subject = $template[0]->subject.' - '.$cinfo[0]->nama_perusahaan;
					$logo = base_url().'uploads/logo/signin/'.$cinfo[0]->sign_in_logo;
					$message = '
					<div style="background:#f6f6f6;font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;margin:0;padding:0;padding: 20px;">
					<img src="'.$logo.'" title="'.$cinfo[0]->nama_perusahaan.'"><br>'.str_replace(array("{var site_name}","{var site_url}","{var nama_karyawan}"),array($cinfo[0]->nama_perusahaan,site_url(),$full_name),htmlspecialchars_decode(stripslashes($template[0]->message))).'</div>';
					$this->email->from($user_info[0]->email, $full_name);
					$this->email->to($cinfo[0]->email);
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

	public function details_cuti() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}

		$data['title'] = $this->lang->line('umb_cuti_detail').' | '.$this->Umb_model->site_title();
		$cuti_id = $this->uri->segment(5);
		$result = $this->Timesheet_model->read_informasi_cuti($cuti_id);
		if(is_null($result)){
			redirect('admin/user/cuti');
		}
		$type = $this->Timesheet_model->read_informasi_type_cuti($result[0]->type_cuti_id);
		if(!is_null($type)){
			$type_name = $type[0]->type_name;
		} else {
			$type_name = '--';	
		}
		$user = $this->Umb_model->read_user_info($result[0]->karyawan_id);
		if(!is_null($user)){
			$full_name = $user[0]->first_name. ' '.$user[0]->last_name;
			$u_role_id = $user[0]->user_role_id;
		} else {
			$full_name = '--';	
			$u_role_id = '--';
		}
		$data = array(
			'title' => $this->lang->line('umb_cuti_detail').' | '.$this->Umb_model->site_title(),
			'type' => $type_name,
			'role_id' => $u_role_id,
			'full_name' => $full_name,
			'cuti_id' => $result[0]->cuti_id,
			'karyawan_id' => $result[0]->karyawan_id,
			'perusahaan_id' => $result[0]->perusahaan_id,
			'type_cuti_id' => $result[0]->type_cuti_id,
			'from_date' => $result[0]->from_date,
			'to_date' => $result[0]->to_date,
			'applied_on' => $result[0]->applied_on,
			'reason' => $result[0]->reason,
			'remarks' => $result[0]->remarks,
			'status' => $result[0]->status,
			'created_at' => $result[0]->created_at,
			'all_karyawans' => $this->Umb_model->all_karyawans(),
			'all_types_cuti' => $this->Timesheet_model->all_types_cuti(),
		);
		$data['breadcrumbs'] = $this->lang->line('umb_cuti_detail');
		$data['path_url'] = 'user/user_details_cuti';
		if(!empty($session)){ 
			$data['subview'] = $this->load->view("karyawan/user/details_cuti", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
		} else {
			redirect('admin/');
		}

	}

	public function tickets() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('left_tickets').' | '.$this->Umb_model->site_title();
		$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		$data['all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$data['breadcrumbs'] = $this->lang->line('left_tickets');
		$data['path_url'] = 'user/user_tickets';
		if(!empty($session)){ 
			$data['subview'] = $this->load->view("karyawan/user/list_ticket", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
		} else {
			redirect('admin/');
		}		  
	}
	
	public function list_ticket() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("karyawan/user/list_ticket", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$ticket = $this->Tickets_model->get_tickets_karyawan($session['user_id']);
		$data = array();
		foreach($ticket->result() as $r) {
			$karyawan = $this->Umb_model->read_user_info($r->karyawan_id);
			if(!is_null($karyawan)){
				$nama_karyawan = $karyawan[0]->first_name.' '.$karyawan[0]->last_name;
			} else {
				$nama_karyawan = '--';	
			}
			if($r->ticket_priority==1): $priority = $this->lang->line('umb_low'); elseif($r->ticket_priority==2): $priority = $this->lang->line('umb_medium'); elseif($r->ticket_priority==3): $priority = $this->lang->line('umb_high'); elseif($r->ticket_priority==4): $priority = $this->lang->line('umb_critical');  endif;
			if($r->status_ticket==1): $status = $this->lang->line('umb_open'); elseif($r->status_ticket==2): $status = $this->lang->line('umb_closed'); endif;
			$created_at = date('h:i A', strtotime($r->created_at));
			$_date = explode(' ',$r->created_at);
			$edate = $this->Umb_model->set_date_format($_date[0]);
			$_created_at = $edate. ' '. $created_at;
			$p_perusahaan = $this->Umb_model->read_info_perusahaan($r->perusahaan_id);
			if(!is_null($p_perusahaan)){
				$perusahaan = $p_perusahaan[0]->name;
			} else {
				$perusahaan = '--';	
			}
			$data[] = array(
				'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_view_details').'"><a href="'.site_url().'admin/user/details_ticket/'.$r->ticket_id.'"><button type="button" class="btn icon-btn btn-sm btn-outline-info waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->ticket_id . '"><span class="far fa-trash-alt"></span></button></span>',
				$r->kode_ticket,
				$perusahaan,
				$nama_karyawan,
				$r->subject,
				$priority,
				$status,
				$_created_at
			);
		}
		$output = array(
			"draw" => $draw,
			"recordsTotal" => $ticket->num_rows(),
			"recordsFiltered" => $ticket->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}
	
	public function list_comments() {

		$data['title'] = $this->Umb_model->site_title();
		//$id = $this->input->get('ticket_id');
		$id = $this->uri->segment(4);
		$session = $this->session->userdata('username');
		$ses_user = $this->Umb_model->read_user_info($session['user_id']);
		if(!empty($session)){ 
			$this->load->view("karyawan/user/list_ticket", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$comments = $this->Tickets_model->get_comments($id);
		$data = array();
		foreach($comments->result() as $r) {
			$karyawan = $this->Umb_model->read_user_info($r->user_id);
			if(!is_null($karyawan)){
				$nama_karyawan = $karyawan[0]->first_name.' '.$karyawan[0]->last_name;
				$_penunjukan = $this->Penunjukan_model->read_informasi_penunjukan($karyawan[0]->penunjukan_id);
				if(!is_null($_penunjukan)){
					$nama_penunjukan = $_penunjukan[0]->nama_penunjukan;
				} else {
					$nama_penunjukan = '--';	
				}
				if($karyawan[0]->profile_picture!='' && $karyawan[0]->profile_picture!='no file') {
					$u_file = base_url().'uploads/profile/'.$karyawan[0]->profile_picture;
				} else {
					if($karyawan[0]->jenis_kelamin=='Pria') { 
						$u_file = base_url().'uploads/profile/default_male.jpg';
					} else {
						$u_file = base_url().'uploads/profile/default_female.jpg';
					}
				} 
			} else {
				$nama_karyawan = '--';
				$nama_penunjukan = '--';
				$u_file = '--';
			}
			$created_at = date('h:i A', strtotime($r->created_at));
			$_date = explode(' ',$r->created_at);
			$date = $this->Umb_model->set_date_format($_date[0]);
			if($ses_user[0]->user_role_id==1){
				$link = '<span class="underline">'.$nama_karyawan.' ('.$nama_penunjukan.')</span>';
			} else{
				$link = '<span class="underline">'.$nama_karyawan.' ('.$nama_penunjukan.')</span>';
			}
			if($ses_user[0]->user_role_id==1 || $ses_user[0]->user_id==$r->user_id){
				$dlink = '<div class="media-right">
				<div class="c-rating">
				<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'">
				<a class="btn btn-outline-danger btn-sm delete" href="#" data-toggle="modal" data-target=".delete-modal" data-record-id="'.$r->comment_id.'">
				<i class="fas fa-trash-restore m-r-0-5"></i>'.$this->lang->line('umb_delete').'</a></span>
				</div>
				</div>';
			} else {
				$dlink = '';
			}
			$function = '<div class="c-item">
			<div class="media">
			<div class="media-left">
			<div class="avatar box-48">
			<img class="b-a-radius-circle" src="'.$u_file.'">
			</div>
			</div>
			<div class="media-body">
			<div class="mb-0-5">
			'.$link.'
			<span class="font-90 text-muted">'.$date.' '.$created_at.'</span>
			</div>
			<div class="c-text">'.$r->ticket_comments.'</div>
			</div>
			'.$dlink.'
			</div>
			</div>';
			
			$data[] = array(
				$function
			);
		}
		$output = array(
			"draw" => $draw,
			"recordsTotal" => $comments->num_rows(),
			"recordsFiltered" => $comments->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}
	
	public function list_attachment() {

		$data['title'] = $this->Umb_model->site_title();
		//$id = $this->input->get('ticket_id');
		$id = $this->uri->segment(4);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("karyawan/user/list_ticket", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$attachments = $this->Tickets_model->get_attachments($id);
		if($attachments->num_rows() > 0) {
			$data = array();
			foreach($attachments->result() as $r) {
				$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_download').'"><a href="'.site_url().'admin/download?type=ticket&filename='.$r->attachment_file.'"><button type="button" class="btn icon-btn btn-sm btn-outline-success waves-effect waves-light"><span class="oi oi-cloud-download"></span></button></a></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete-file" data-toggle="modal" data-target=".delete-modal-file" data-record-id="'. $r->ticket_attachment_id . '"><span class="far fa-trash-alt"></span></button></span>',
					$r->file_title,
					$r->file_description,
					$r->created_at
				);
			}
			$output = array(
				"draw" => $draw,
				"recordsTotal" => $attachments->num_rows(),
				"recordsFiltered" => $attachments->num_rows(),
				"data" => $data
			);
		} else {
			$data[] = array('','','','');
			$output = array(
				"draw" => $draw,
				"recordsTotal" => 0,
				"recordsFiltered" => 0,
				"data" => $data
			);
		}
		echo json_encode($output);
		exit();
	}
	
	public function add_ticket() {
		
		if($this->input->post('add_type')=='ticket') {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			if($this->input->post('perusahaan')==='') {
				$Return['error'] = $this->lang->line('umb_error_perusahaan');
			} else if($this->input->post('subject')==='') {
				$Return['error'] = $this->lang->line('umb_karyawan_error_subject');
			} else if($this->input->post('karyawan_id')==='') {
				$Return['error'] = $this->lang->line('umb_error_karyawan_id');
			} else if($this->input->post('ticket_priority')==='') {
				$Return['error'] = $this->lang->line('umb_error_ticket_priority');
			}
			$description = $this->input->post('description');
			$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
			
			if($Return['error']!=''){
				$this->output($Return);
			}
			$kode_ticket = $this->Umb_model->generate_random_string();
			$data = array(
				'kode_ticket' => $kode_ticket,
				'subject' => $this->input->post('subject'),
				'perusahaan_id' => $this->input->post('perusahaan'),
				'karyawan_id' => $this->input->post('karyawan_id'),
				'description' => $qt_description,
				'status_ticket' => '1',
				'ticket_priority' => $this->input->post('ticket_priority'),
				'created_at' => date('d-m-Y h:i:s'),
			);
			$result = $this->Tickets_model->add($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_ticket_created');			
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function set_ticket_comment() {
		
		if($this->input->post('add_type')=='set_comment') {		
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			if($this->input->post('umb_comment')==='') {
				$Return['error'] = $this->lang->line('umb_error_field_comment');
			} 
			$umb_comment = $this->input->post('umb_comment');
			$qt_umb_comment = htmlspecialchars(addslashes($umb_comment), ENT_QUOTES);
			if($Return['error']!=''){
				$this->output($Return);
			}
			$data = array(
				'ticket_comments' => $qt_umb_comment,
				'ticket_id' => $this->input->post('comment_ticket_id'),
				'user_id' => $this->input->post('user_id'),
				'created_at' => date('d-m-Y h:i:s')
			);
			$result = $this->Tickets_model->add_comment($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_ticket_comment_ditambahkan');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function add_ticket_attachment() {
		
		if($this->input->post('add_type')=='dfile_attachment') {		
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			if($this->input->post('file_name')==='') {
				$Return['error'] = $this->lang->line('umb_error_file_tugas_name');
			} else if($_FILES['attachment_file']['size'] == 0) {
				$Return['error'] = $this->lang->line('umb_error_file_tugas');
			} else if($this->input->post('file_description')==='') {
				$Return['error'] = $this->lang->line('umb_error_description_file_tugas');
			}
			$description = $this->input->post('file_description');
			$file_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
			if($Return['error']!=''){
				$this->output($Return);
			}
			if(is_uploaded_file($_FILES['attachment_file']['tmp_name'])) {
				$allowed =  array('png','jpg','jpeg','pdf','doc','docx','xls','csv','xlsx','txt');
				$filename = $_FILES['attachment_file']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				if(in_array($ext,$allowed)){
					$tmp_name = $_FILES["attachment_file"]["tmp_name"];
					$attachment_file = "uploads/ticket/";
					$name = basename($_FILES["attachment_file"]["name"]);
					$newfilename = 'ticket_'.round(microtime(true)).'.'.$ext;
					move_uploaded_file($tmp_name, $attachment_file.$newfilename);
					$fname = $newfilename;
				} else {
					$Return['error'] = $this->lang->line('umb_error_file_attachment_tugas');
				}
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$data = array(
				'ticket_id' => $this->input->post('c_ticket_id'),
				'upload_by' => $this->input->post('user_file_id'),
				'file_title' => $this->input->post('file_name'),
				'file_description' => $file_description,
				'attachment_file' => $fname,
				'created_at' => date('d-m-Y h:i:s')
			);
			$result = $this->Tickets_model->add_new_attachment($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_ticket_attachment_ditambahkan');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function details_ticket() {

		$data['title'] = $this->Umb_model->site_title();
		$id = $this->uri->segment(4);
		$result = $this->Tickets_model->read_informasi_ticket($id);
		if(is_null($result)){
			redirect('admin/user/tickets');
		}
		$user = $this->Umb_model->read_user_info($result[0]->karyawan_id);
		if(!is_null($user)){
			$full_name = $user[0]->first_name.' '.$user[0]->last_name;
		} else {
			$full_name = '--';	
		}
		$data = array(
			'title' => $this->lang->line('umb_details_ticket').' | '.$this->Umb_model->site_title(),
			'ticket_id' => $result[0]->ticket_id,
			'subject' => $result[0]->subject,
			'kode_ticket' => $result[0]->kode_ticket,
			'karyawan_id' => $result[0]->karyawan_id,
			'full_name' => $full_name,
			'ticket_priority' => $result[0]->ticket_priority,
			'created_at' => $result[0]->created_at,
			'description' => $result[0]->description,
			'assigned_to' => $result[0]->assigned_to,
			'status_ticket' => $result[0]->status_ticket,
			'ticket_note' => $result[0]->ticket_note,
			'ticket_remarks' => $result[0]->ticket_remarks,
			'message' => $result[0]->message,
			'all_karyawans' => $this->Umb_model->all_karyawans(),
		);
		$data['breadcrumbs'] = $this->lang->line('umb_details_ticket');
		$data['path_url'] = 'user/user_tickets_detail';
		$session = $this->session->userdata('username');
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(!empty($session)){ 
			$data['subview'] = $this->load->view("karyawan/user/details_ticket", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
		} else {
			redirect('admin/');
		}		  
	}
	
	public function update_status_ticket() {
		
		if($this->input->post('type')=='update_status') {		
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();	
			$data = array(
				'status_ticket' => $this->input->post('status'),
				'ticket_remarks' => $this->input->post('remarks'),
			);
			$id = $this->input->post('status_ticket_id');
			$result = $this->Tickets_model->update_status($data,$id);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_status_ticket_diperbarui');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function add_ticket_note() {
		
		if($this->input->post('type')=='add_note') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();	
			$data = array(
				'ticket_note' => $this->input->post('ticket_note')
			);
			$id = $this->input->post('token_note_id');
			$result = $this->Tickets_model->update_note($data,$id);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_ticket_note_diperbarui');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function delete_comment_ticket() {
		if($this->input->post('data') == 'ticket_comment') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Tickets_model->delete_record_comment($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_sukses_ticket_comment_dihapus');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}
	
	public function delete_attachment_ticket() {
		if($this->input->post('data') == 'ticket_attachment') {
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Tickets_model->delete_record_attachment($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_sukses_ticket_attachment_dihapus');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}
	
	public function add_catatan_project() {
		
		if($this->input->post('type')=='add_note') {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();	
			$data = array(
				'catatan_project' => $this->input->post('catatan_project')
			);
			$id = $this->input->post('catatan_project_id');
			$result = $this->Project_model->update_record($data,$id);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_catatan_project_diperbarui');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function delete_attachment_project() {
		if($this->input->post('is_ajax') == '8') {
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Project_model->delete_record_attachment($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_sukses_file_project_dihapus');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}

	public function tugass() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('left_tugass').' | '.$this->Umb_model->site_title();
		$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		$data['breadcrumbs'] = $this->lang->line('left_tugass');
		$data['path_url'] = 'user/user_tugass';
		if(!empty($session)){ 
			$data['subview'] = $this->load->view("karyawan/user/tugass", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
		} else {
			redirect('admin/');
		}
		
	}
	
	public function details_tugas() {
		
		$data['title'] = $this->lang->line('umb_detail_tugas').' | '.$this->Umb_model->site_title();
		$tugas_id = $this->uri->segment(5);
		$result = $this->Timesheet_model->read_informasi_tugas($tugas_id);
		if(is_null($result)){
			redirect('admin/user/tugass');
		}
		$u_created = $this->Umb_model->read_user_info($result[0]->created_by);
		if(!is_null($u_created)){
			$f_name = $u_created[0]->first_name.' '.$u_created[0]->last_name;
		} else {
			$f_name = '--';	
		}
		$prj_tugas = $this->Project_model->read_informasi_project($result[0]->project_id);
		if(!is_null($prj_tugas)){
			$nama_prj = $prj_tugas[0]->title;
		} else {
			$nama_prj = '--';
		}
		$data = array(
			'title' => $this->lang->line('umb_detail_tugas').' | '.$this->Umb_model->site_title(),
			'tugas_id' => $result[0]->tugas_id,
			'nama_project' => $nama_prj,
			'created_by' => $f_name,
			'nama_tugas' => $result[0]->nama_tugas,
			'assigned_to' => $result[0]->assigned_to,
			'start_date' => $result[0]->start_date,
			'end_date' => $result[0]->end_date,
			'jam_tugas' => $result[0]->jam_tugas,
			'status_tugas' => $result[0]->status_tugas,
			'tugas_note' => $result[0]->tugas_note,
			'progress' => $result[0]->progress_tugas,
			'description' => $result[0]->description,
			'created_at' => $result[0]->created_at,
			'all_karyawans' => $this->Umb_model->all_karyawans()
		);
		$data['breadcrumbs'] = $this->lang->line('umb_detail_tugas');
		$data['path_url'] = 'user/user_details_tugas';
		$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		$data['all_types_cuti'] = $this->Timesheet_model->all_types_cuti();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$data['subview'] = $this->load->view("karyawan/user/details_tugas", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
		} else {
			redirect('admin/');
		}
		
	}
	
	public function list_tugas() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("karyawan/user/tugass", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$tugas = $this->Timesheet_model->get_tugass();
		$data = array();
		foreach($tugas->result() as $r) {
			$aim = explode(',',$r->assigned_to);
			foreach($aim as $dIds) {
				if($session['user_id'] == $dIds) {
					if($r->assigned_to == '' || $r->assigned_to == 'None') {
						$ol = 'None';
					} else {
						$ol = '<ol class="nl">';
						foreach(explode(',',$r->assigned_to) as $uid) {
							$user = $this->Eumb_model->read_user_info($uid);
							$ol .= '<li>'.$user[0]->first_name. ' '.$user[0]->last_name.'</li>';
						}
						$ol .= '</ol>';
					}
					$u_created = $this->Eumb_model->read_user_info($r->created_by);
					if(!is_null($u_created)){
						$f_name = $u_created[0]->first_name.' '.$u_created[0]->last_name;
					} else {
						$f_name = '--';	
					}
					$prj_tugas = $this->Project_model->read_informasi_project($r->project_id);
					if(!is_null($prj_tugas)){
						$nama_prj = $prj_tugas[0]->title;
					} else {
						$nama_prj = '--';
					}
					if($r->progress_tugas=='' || $r->progress_tugas==0): $progress = 0; else: $progress = $r->progress_tugas; endif;
					if($r->progress_tugas <= 20) {
						$progress_class = 'progress-danger';
					} else if($r->progress_tugas > 20 && $r->progress_tugas <= 50){
						$progress_class = 'progress-warning';
					} else if($r->progress_tugas > 50 && $r->progress_tugas <= 75){
						$progress_class = 'progress-info';
					} else {
						$progress_class = 'progress-success';
					}
					$progress_bar = '<p class="m-b-0-5">'.$this->lang->line('umb_completed').' <span class="pull-xs-right">'.$r->progress_tugas.'%</span></p><progress class="progress '.$progress_class.' progress-sm" value="'.$r->progress_tugas.'" max="100">'.$r->progress_tugas.'%</progress>';
					if($r->status_tugas == 0) {
						$status = $this->lang->line('umb_not_started');
					} else if($r->status_tugas ==1){
						$status = $this->lang->line('umb_in_progress');
					} else if($r->status_tugas ==2){
						$status = $this->lang->line('umb_completed');
					} else {
						$status = $this->lang->line('umb_deffered');
					}
					$tdate = $this->Umb_model->set_date_format($r->end_date);
					$data[] = array(
						'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_view_details').'"><a href="'.site_url().'admin/user/details_tugas/id/'.$r->tugas_id.'/"><button type="button" class="btn icon-btn btn-sm btn-outline-info waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span>',
						$r->nama_tugas.'<br>'.$this->lang->line('umb_project').': <a href="'.site_url().'admin/user/details_project/'.$r->project_id.'">'.$nama_prj.'</a>',
						$tdate,
						$status,
						$ol,
						$f_name,
						$progress_bar
					);
				}
			} 
		}
		$output = array(
			"draw" => $draw,
			"recordsTotal" => $tugas->num_rows(),
			"recordsFiltered" => $tugas->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
		
	}

	public function list_comments_tugas() {

		$data['title'] = $this->Umb_model->site_title();
		//$id = $this->input->get('ticket_id');
		$id = $this->uri->segment(4);
		$session = $this->session->userdata('username');
		$ses_user = $this->Umb_model->read_user_info($session['user_id']);
		if(!empty($session)){ 
			$this->load->view("karyawan/user/tugass", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$comments = $this->Timesheet_model->get_comments($id);
		$data = array();
		foreach($comments->result() as $r) {
			$karyawan = $this->Umb_model->read_user_info($r->user_id);
			if(!is_null($karyawan)){
				$nama_karyawan = $karyawan[0]->first_name.' '.$karyawan[0]->last_name;
				$_penunjukan = $this->Penunjukan_model->read_informasi_penunjukan($karyawan[0]->penunjukan_id);
				if(!is_null($_penunjukan)){
					$nama_penunjukan = $_penunjukan[0]->nama_penunjukan;
				} else {
					$nama_penunjukan = '--';	
				}
				if($karyawan[0]->profile_picture!='' && $karyawan[0]->profile_picture!='no file') {
					$u_file = base_url().'uploads/profile/'.$karyawan[0]->profile_picture;
				} else {
					if($karyawan[0]->jenis_kelamin=='Pria') { 
						$u_file = base_url().'uploads/profile/default_male.jpg';
					} else {
						$u_file = base_url().'uploads/profile/default_female.jpg';
					}
				} 
			} else {
				$nama_karyawan = '--';
				$nama_penunjukan = '--';
				$u_file = '--';
			}
			$created_at = date('h:i A', strtotime($r->created_at));
			$_date = explode(' ',$r->created_at);
			$date = $this->Umb_model->set_date_format($_date[0]);
			$link = '<span class="underline">'.$nama_karyawan.' ('.$nama_penunjukan.')</span>';
			$dlink = '<div class="media-right">
			<div class="c-rating">
			<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->comment_id . '"><span class="far fa-trash-alt"></span></button></span>
			
			</div>
			</div>';
			$function = '<div class="c-item">
			<div class="media">
			<div class="media-left">
			<div class="avatar box-48">
			<img class="ui-w-30 rounded-circle" src="'.$u_file.'">
			</div>
			</div>
			<div class="media-body">
			<div class="mb-0-5">
			'.$link.'
			<span class="font-90 text-muted">'.$date.' '.$created_at.'</span>
			</div>
			<div class="c-text">'.$r->comments_tugas.'</div>
			</div>
			'.$dlink.'
			</div>
			</div>';
			
			$data[] = array(
				$function
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $comments->num_rows(),
			"recordsFiltered" => $comments->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}
	
	public function set_comment_tugas() {
		
		if($this->input->post('add_type')=='set_comment') {		
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			if($this->input->post('umb_comment')==='') {
				$Return['error'] = $this->lang->line('umb_error_field_comment');
			} 
			$umb_comment = $this->input->post('umb_comment');
			$qt_umb_comment = htmlspecialchars(addslashes($umb_comment), ENT_QUOTES);
			
			if($Return['error']!=''){
				$this->output($Return);
			}
			$data = array(
				'comments_tugas' => $qt_umb_comment,
				'tugas_id' => $this->input->post('comment_tugas_id'),
				'user_id' => $this->input->post('user_id'),
				'created_at' => date('d-m-Y h:i:s')
			);
			$result = $this->Timesheet_model->add_comment($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_comment_tugas');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function add_tugas_note() {
		
		if($this->input->post('type')=='add_note') {		
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();	
			$data = array(
				'tugas_note' => $this->input->post('tugas_note')
			);
			$id = $this->input->post('note_tugas_id');
			$result = $this->Timesheet_model->update_record_tugas($data,$id);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_tugas_note_diperbarui');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function delete_comment_tugas() {
		if($this->input->post('data') == 'comment_tugas') {
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Timesheet_model->delete_record_comment($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_sukses_comment_tugas_dihapus');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}
	
	public function add_attachment_tugas() {
		
		if($this->input->post('add_type')=='dfile_attachment') {		
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			if($this->input->post('file_name')==='') {
				$Return['error'] = $this->lang->line('umb_error_file_tugas_name');
			} else if($_FILES['attachment_file']['size'] == 0) {
				$Return['error'] = $this->lang->line('umb_error_file_tugas');
			} else if($this->input->post('file_description')==='') {
				$Return['error'] = $this->lang->line('umb_error_description_file_tugas');
			}
			$description = $this->input->post('file_description');
			$file_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
			
			if($Return['error']!=''){
				$this->output($Return);
			}
			if(is_uploaded_file($_FILES['attachment_file']['tmp_name'])) {
				$allowed =  array('png','jpg','jpeg','gif','pdf','doc','docx','xls','xlsx','txt');
				$filename = $_FILES['attachment_file']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				if(in_array($ext,$allowed)){
					$tmp_name = $_FILES["attachment_file"]["tmp_name"];
					$attachment_file = "uploads/tugas/";
					$name = basename($_FILES["attachment_file"]["name"]);
					$newfilename = 'tugas_'.round(microtime(true)).'.'.$ext;
					move_uploaded_file($tmp_name, $attachment_file.$newfilename);
					$fname = $newfilename;
				} else {
					$Return['error'] = $this->lang->line('umb_error_file_attachment_tugas');
				}
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$data = array(
				'tugas_id' => $this->input->post('c_tugas_id'),
				'upload_by' => $this->input->post('user_id'),
				'file_title' => $this->input->post('file_name'),
				'file_description' => $file_description,
				'attachment_file' => $fname,
				'created_at' => date('d-m-Y h:i:s')
			);
			$result = $this->Timesheet_model->add_new_attachment($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_tugas_att_ditambahkan');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function list_attachment_tugas() {

		$data['title'] = $this->Umb_model->site_title();
		//$id = $this->input->get('ticket_id');
		$id = $this->uri->segment(4);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("karyawan/user/tugass", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$attachments = $this->Timesheet_model->get_attachments($id);
		if($attachments->num_rows() > 0) {
			$data = array();
			foreach($attachments->result() as $r) {
				
				$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_download').'"><a href="'.site_url().'admin/download?type=tugas&filename='.$r->attachment_file.'"><button type="button" class="btn icon-btn btn-sm btn-outline-success waves-effect waves-light"><span class="oi oi-cloud-download"></span></button></a></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete-file" data-toggle="modal" data-target=".delete-modal-file" data-record-id="'. $r->attachment_tugas_id . '"><span class="far fa-trash-alt"></span></button></span>',
					$r->file_title,
					$r->file_description,
					$r->created_at
				);
			}
			$output = array(
				"draw" => $draw,
				"recordsTotal" => $attachments->num_rows(),
				"recordsFiltered" => $attachments->num_rows(),
				"data" => $data
			);
		} else {
			$data[] = array('','','','');
			$output = array(
				"draw" => $draw,
				"recordsTotal" => 0,
				"recordsFiltered" => 0,
				"data" => $data
			);
		}
		echo json_encode($output);
		exit();
	}
	
	public function delete_attachment_tugas() {

		if($this->input->post('data') == 'attachment_tugas') {
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Timesheet_model->delete_record_attachment($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_sukses_tugas_att_dihapus');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}

	public function projects() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('umb_projects').' | '.$this->Umb_model->site_title();
		$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		$data['all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$data['breadcrumbs'] = $this->lang->line('umb_projects');
		$data['path_url'] = 'user/user_projects';
		if(!empty($session)){ 
			$data['subview'] = $this->load->view("karyawan/user/projects", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
		} else {
			redirect('admin/');
		}
		
	}
	
	public function list_project() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("karyawan/user/projects", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$project = $this->Project_model->get_projects();
		$data = array();
		foreach($project->result() as $r) {
			$aim = explode(',',$r->assigned_to);
			foreach($aim as $dIds) {
				if($session['user_id'] == $dIds) {
					$user = $this->Eumb_model->read_user_info($r->added_by);
					if(!is_null($user)){
						$full_name = $user[0]->first_name.' '.$user[0]->last_name;
					} else {
						$full_name = '--';	
					}
					$pdate = '<i class="fa fa-calendar position-left"></i> '.$this->Umb_model->set_date_format($r->end_date);
					if($r->progress_project <= 20) {
						$progress_class = 'progress-danger';
					} else if($r->progress_project > 20 && $r->progress_project <= 50){
						$progress_class = 'progress-warning';
					} else if($r->progress_project > 50 && $r->progress_project <= 75){
						$progress_class = 'progress-info';
					} else {
						$progress_class = 'progress-success';
					}
					$pbar = '<p class="m-b-0-5">'.$this->lang->line('umb_completed').' <span class="pull-xs-right">'.$r->progress_project.'%</span></p><progress class="progress '.$progress_class.' progress-sm" value="'.$r->progress_project.'" max="100">'.$r->progress_project.'%</progress>';
					if($r->status == 0) {
						$status = $this->lang->line('umb_not_started');
					} else if($r->status ==1){
						$status = $this->lang->line('umb_in_progress');
					} else if($r->status ==2){
						$status = $this->lang->line('umb_completed');
					} else {
						$status = $this->lang->line('umb_deffered');
					}
					if($r->priority == 1) {
						$priority = '<span class="tag tag-danger">'.$this->lang->line('umb_highest').'</span>';
					} else if($r->priority ==2){
						$priority = '<span class="tag tag-danger">'.$this->lang->line('umb_high').'</span>';
					} else if($r->priority ==3){
						$priority = '<span class="tag tag-primary">'.$this->lang->line('umb_normal').'</span>';
					} else {
						$priority = '<span class="tag tag-success">'.$this->lang->line('umb_low').'</span>';
					}
					if($r->assigned_to == '') {
						$ol = $this->lang->line('umb_not_assigned');
					} else {
						$ol = '';
						foreach(explode(',',$r->assigned_to) as $tunjuk_id) {
							$assigned_to = $this->Eumb_model->read_user_info($tunjuk_id);
							if(!is_null($assigned_to)){
								$assigned_name = $assigned_to[0]->first_name.' '.$assigned_to[0]->last_name;
								if($assigned_to[0]->profile_picture!='' && $assigned_to[0]->profile_picture!='no file') {
									$ol .= '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.base_url().'uploads/profile/'.$assigned_to[0]->profile_picture.'" class="ui-w-30 rounded-circle" alt=""></span></a>';
								} else {
									if($assigned_to[0]->jenis_kelamin=='Pria') { 
										$de_file = base_url().'uploads/profile/default_male.jpg';
									} else {
										$de_file = base_url().'uploads/profile/default_female.jpg';
									}
									$ol .= '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.$de_file.'" class="ui-w-30 rounded-circle" alt=""></span></a>';
								}
							}
							else {
								$ol .= '';
							}
						}
						$ol .= '';
					}

					$ringkasan_project = '<div class="text-semibold"><a href="'.site_url().'admin/user/details_project/'.$r->project_id . '">'.$r->title.'</a></div>
					<div class="text-muted">'.$r->summary.'</div>';

					$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_edit').'"><a href="'.site_url().'admin/user/details_project/'.$r->project_id.'"><button type="button" class="btn icon-btn btn-sm btn-outline-info waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span>',
						$ringkasan_project,
						$priority,
						$pdate,
						$pbar,
						$ol
					);
				}
			} 
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $project->num_rows(),
			"recordsFiltered" => $project->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function read_bug() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('hr/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('bug_id');
		$result = $this->Project_model->read_informasi_bug($id);
		$data = array(
			'bug_id' => $result[0]->bug_id,
			'project_id' => $result[0]->project_id,
			'status' => $result[0]->status,
		);
		$this->load->view('karyawan/user/dialog_project_bug', $data);
	}

	public function change_status_bug() {
		if($this->input->post('data') == 'change_status') {

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();

			$data = array(
				'status' => $this->input->post('status'),
			);
			$result = $this->Project_model->update_bug($data,$id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_sukses_project_bug_status_diperbarui');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}

	public function delete_bug() {
		if($this->input->post('data') == 'bug') {

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Project_model->delete_record_bug($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('umb_sukses_project_bug_dihapus');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
		}
	}

	public function details_project()
	{
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		//$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		//$data['all_perusahaans'] = $this->Umb_model->get_perusahaans();
		//$data['breadcrumbs'] = $this->lang->line('umb_project_detail');
		$id = $this->uri->segment(4);
		$result = $this->Project_model->read_informasi_project($id);
		if(is_null($result)){
			redirect('admin/user/projects');
		}
		$user = $this->Umb_model->read_user_info($result[0]->added_by);
		if(!is_null($user)){
			$full_name = $user[0]->first_name.' '.$user[0]->last_name;
		} else {
			$full_name = '--';	
		}
		$result2 = $this->Clients_model->read_info_client($result[0]->client_id);
		if(!is_null($result2)) {
			$name_client = $result2[0]->name;
		} else {
			$name_client = '--';
		}
		$data = array(
			'breadcrumbs' => $this->lang->line('umb_project_detail'),
			'project_id' => $result[0]->project_id,
			'title' => $result[0]->title,
			'catatan_project' => $result[0]->catatan_project,
			'summary' => $result[0]->summary,
			'name_client' => $name_client,
			'start_date' => $result[0]->start_date,
			'end_date' => $result[0]->end_date,
			'perusahaan_id' => $result[0]->perusahaan_id,
			'assigned_to' => $result[0]->assigned_to,
			'created_at' => $result[0]->created_at,
			'priority' => $result[0]->priority,
			'added_by' => $full_name,
			'description' => $result[0]->description,
			'progress' => $result[0]->progress_project,
			'status' => $result[0]->status,
			'path_url' => 'user/user_details_project',
			'all_karyawans' => $this->Umb_model->all_karyawans(),
			'all_perusahaans' => $this->Umb_model->get_perusahaans()
		);
		if(!empty($session)){ 
			$data['subview'] = $this->load->view("karyawan/user/details_project", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
		} else {
			redirect('admin/');
		}		  
	}

	public function update_status_project() {

		if($this->input->post('type')=='update_status') {

			$id = $this->input->post('project_id');


			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();


			$data = array(
				'progress_project' => $this->input->post('progres_val')
			);

			$result = $this->Project_model->update_record($data,$id);		

			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_perbarui_project');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function list_attachment_project() {

		$data['title'] = $this->Umb_model->site_title();
		//$id = $this->input->get('ticket_id');
		$id = $this->uri->segment(4);
		$session = $this->session->userdata('username');
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$attachments = $this->Project_model->get_attachments($id);
		$data = array();
		foreach($attachments->result() as $r) {
			$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_download').'"><a href="'.site_url().'admin/download?type=project/files&filename='.$r->attachment_file.'"><button type="button" class="btn icon-btn btn-sm btn-outline-success waves-effect waves-light"><span class="oi oi-cloud-download"></span></button></a></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light fidelete" data-toggle="modal" data-target=".delete-modal-file" data-record-id="'. $r->project_attachment_id . '"><span class="far fa-trash-alt"></span></button></span>',
				$r->file_title,
				$r->file_description,
				$r->created_at
			);
		}
		$output = array(
			"draw" => $draw,
			"recordsTotal" => $attachments->num_rows(),
			"recordsFiltered" => $attachments->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function list_project_tugas() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');

		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$id = $this->uri->segment(4);		
		$tugas = $this->Timesheet_model->get_project_tugass($id);
		$data = array();
		foreach($tugas->result() as $r) {
			if($r->assigned_to == '' || $r->assigned_to == 'None') {
				$ol = $this->lang->line('umb_performance_none');
			} else {
				$ol = '';
				foreach(explode(',',$r->assigned_to) as $uid) {
					$assigned_to = $this->Umb_model->read_user_info($uid);
					if(!is_null($assigned_to)){
						$assigned_name = $assigned_to[0]->first_name.' '.$assigned_to[0]->last_name;
						if($assigned_to[0]->profile_picture!='' && $assigned_to[0]->profile_picture!='no file') {
							$ol .= '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.base_url().'uploads/profile/'.$assigned_to[0]->profile_picture.'" class="ui-w-30 rounded-circle" alt=""></span></a>';
						} else {
							if($assigned_to[0]->jenis_kelamin=='Pria') { 
								$de_file = base_url().'uploads/profile/default_male.jpg';
							} else {
								$de_file = base_url().'uploads/profile/default_female.jpg';
							}
							$ol .= '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.$de_file.'" class="ui-w-30 rounded-circle" alt=""></span></a>';
						}
					}
				}
				$ol .= '';
			}
			$u_created = $this->Umb_model->read_user_info($r->created_by);
			$f_name = $u_created[0]->first_name.' '.$u_created[0]->last_name;
			if($r->progress_tugas=='' || $r->progress_tugas==0): $progress = 0; else: $progress = $r->progress_tugas; endif;
			if($r->progress_tugas <= 20) {
				$progress_class = 'progress-danger';
			} else if($r->progress_tugas > 20 && $r->progress_tugas <= 50){
				$progress_class = 'progress-warning';
			} else if($r->progress_tugas > 50 && $r->progress_tugas <= 75){
				$progress_class = 'progress-info';
			} else {
				$progress_class = 'progress-success';
			}
			$progress_bar = '<p class="m-b-0-5">'.$this->lang->line('umb_completed').' <span class="pull-xs-right">'.$r->progress_tugas.'%</span></p><progress class="progress '.$progress_class.' progress-sm" value="'.$r->progress_tugas.'" max="100">'.$r->progress_tugas.'%</progress>';
			if($r->status_tugas == 0) {
				$status = $this->lang->line('umb_not_started');
			} else if($r->status_tugas ==1){
				$status = $this->lang->line('umb_in_progress');
			} else if($r->status_tugas ==2){
				$status = $this->lang->line('umb_completed');
			} else {
				$status = $this->lang->line('umb_deffered');
			}
			$tdate = $this->Umb_model->set_date_format($r->end_date);
			$data[] = array(
				'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_view_details').'"><a href="'.site_url().'admin/user/details_tugas/id/'.$r->tugas_id.'/"><button type="button" class="btn icon-btn btn-sm btn-outline-info waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span>',
				$r->nama_tugas,
				$tdate,
				$status,
				$ol,
				$f_name,

				$progress_bar
			);
		}
		$output = array(
			"draw" => $draw,
			"recordsTotal" => $tugas->num_rows(),
			"recordsFiltered" => $tugas->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function list_project_bug() {

		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->uri->segment(4);
		$ses_user = $this->Umb_model->read_user_info($session['user_id']);
		$this->load->view("admin/project/details_project", $data);
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$bug = $this->Project_model->get_bug($id);
		$data = array();
		foreach($bug->result() as $r) {
			$karyawan = $this->Umb_model->read_user_info($r->user_id);
			if(!is_null($karyawan)){
				$nama_karyawan = $karyawan[0]->first_name.' '.$karyawan[0]->last_name;
				$_penunjukan = $this->Penunjukan_model->read_informasi_penunjukan($karyawan[0]->penunjukan_id);
				if(!is_null($_penunjukan)){
					$nama_penunjukan = $_penunjukan[0]->nama_penunjukan;
				} else {
					$nama_penunjukan = '--';	
				}
				if($karyawan[0]->profile_picture!='' && $karyawan[0]->profile_picture!='no file') {
					$u_file = base_url().'uploads/profile/'.$karyawan[0]->profile_picture;
				} else {
					if($karyawan[0]->jenis_kelamin=='Pria') { 
						$u_file = base_url().'uploads/profile/default_male.jpg';
					} else {
						$u_file = base_url().'uploads/profile/default_female.jpg';
					}
				} 
			} else {
				$nama_karyawan = '--';
				$nama_penunjukan = '--';
				$u_file = '--';
			}
			$created_at = date('h:i A', strtotime($r->created_at));
			$_date = explode(' ',$r->created_at);
			$date = $this->Umb_model->set_date_format($_date[0]);
			$link = '<span class="underline">'.$nama_karyawan.' ('.$nama_penunjukan.')</span>';
			if($r->attachment_file!='' && $r->attachment_file!='no_file'){
				$at_file = '<a data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_download').'" href="'.site_url().'admin/download?type=project/bug&filename='.$r->attachment_file.'"> <i class="oi oi-cloud-download"></i> </a>';
			} else {
				$at_file = '';
			}

			$dlink = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_update_status').'"><button type="button" class="btn icon-btn btn-sm btn-outline-info waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-bug_id="'. $r->bug_id . '"><span class="fas fa-pencil-alt"></span></button></span>';

			if($r->status==0) {
				$status = '<select name="status" id="status" class="bug_status" data-bug-id="'.$r->bug_id.'">
				<option value="0" selected="selected">'.$this->lang->line('umb_pending').'</option>
				<option value="1">'.$this->lang->line('umb_project_status_solved').'</option>
				</select>';
				$st_tag = '<span class="badge badge-warning">'.$this->lang->line('umb_pending').'</span>';				
			} else {
				$status = '<select name="status" id="status" class="bug_status" data-bug-id="'.$r->bug_id.'">
				<option value="0">'.$this->lang->line('umb_pending').'</option>
				<option value="1" selected="selected">'.$this->lang->line('umb_project_status_solved').'</option>
				</select>';
				$st_tag = '<span class="badge badge-success">'.$this->lang->line('umb_project_status_solved').'</span>';				
			}
			$function = '<div class="c-item">
			<div class="media">
			<div class="media-left">
			<div class="avatar box-48">
			<img class="d-block ui-w-30" src="'.$u_file.'">
			</div>
			</div>
			<div class="media-body">
			<div class="mb-0-5">
			'.$link.'
			<span class="font-90 text-muted">'.$date.' '.$created_at.' &nbsp; '.$st_tag.'
			</div>
			<div class="c-text">'.$r->title.'<br> '.$at_file.'</div>
			</div>
			'.$dlink.'
			</div>
			</div>
			';

			$data[] = array(
				$function
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $bug->num_rows(),
			"recordsFiltered" => $bug->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function list_diskusi_project() {

		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		//$id = $this->input->get('ticket_id');
		$id = $this->uri->segment(4);
		$ses_user = $this->Umb_model->read_user_info($session['user_id']);
		$this->load->view("admin/project/details_project", $data);
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$diskusi = $this->Project_model->get_diskusi($id);
		$data = array();
		foreach($diskusi->result() as $r) {
			$karyawan = $this->Umb_model->read_user_info($r->user_id);
			if(!is_null($karyawan)){
				$nama_karyawan = $karyawan[0]->first_name.' '.$karyawan[0]->last_name;
				$_penunjukan = $this->Penunjukan_model->read_informasi_penunjukan($karyawan[0]->penunjukan_id);
				if(!is_null($_penunjukan)){
					$nama_penunjukan = $_penunjukan[0]->nama_penunjukan;
				} else {
					$nama_penunjukan = '--';	
				}
				if($karyawan[0]->profile_picture!='' && $karyawan[0]->profile_picture!='no file') {
					$u_file = base_url().'uploads/profile/'.$karyawan[0]->profile_picture;
				} else {
					if($karyawan[0]->jenis_kelamin=='Pria') { 
						$u_file = base_url().'uploads/profile/default_male.jpg';
					} else {
						$u_file = base_url().'uploads/profile/default_female.jpg';
					}
				} 
			} else {
				$nama_karyawan = '--';
				$nama_penunjukan = '--';
				$u_file = '--';
			}
			$created_at = date('h:i A', strtotime($r->created_at));
			$_date = explode(' ',$r->created_at);
			$date = $this->Umb_model->set_date_format($_date[0]);
			$link = '<span class="underline">'.$nama_karyawan.' ('.$nama_penunjukan.')</span>';
			if($r->attachment_file!='' && $r->attachment_file!='no_file'){
				$at_file = '<a data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_download').'" href="'.site_url().'admin/download?type=project/diskusi&filename='.$r->attachment_file.'"> <span class="oi oi-cloud-download"></span> </a>';
			} else {
				$at_file = '';
			}
			$function = '<div class="c-item">
			<div class="media">
			<div class="media-left">
			<div class="avatar box-48">
			<img class="d-block ui-w-30" src="'.$u_file. '">
			</div>
			</div>
			<div class="media-body">
			<div class="mb-0-5">
			'.$link.'
			<span class="font-90 text-muted">'.$date.' '.$created_at.'</span>
			</div>
			<div class="c-text">'.$r->message.'<br> '.$at_file.'</div>
			</div>
			</div>
			</div>';
			$data[] = array(
				$function
			);
		}
		$output = array(
			"draw" => $draw,
			"recordsTotal" => $diskusi->num_rows(),
			"recordsFiltered" => $diskusi->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function applied_pekerjaans() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('left_applied_pekerjaans').' | '.$this->Umb_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('left_applied_pekerjaans');
		$data['path_url'] = 'user/user_pekerjaan_applied';
		if(!empty($session)){ 
			$data['subview'] = $this->load->view("karyawan/user/list_applied_pekerjaan", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
		} else {
			redirect('admin/');
		}
		
	}
	
	public function list_applied_pekerjaans() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("karyawan/user/list_applied_pekerjaan", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$kandidats = $this->Post_pekerjaan_model->get_karyawan_applied_pekerjaans($session['user_id']);
		$data = array();
		foreach($kandidats->result() as $r) {
			$user = $this->Eumb_model->read_user_info($r->user_id);
			if(!is_null($user)){
				$full_name = $user[0]->first_name. ' ' .$user[0]->last_name;
				$uemail = $user[0]->email;
			} else {
				$full_name = '--';	
				$uemail = '--';
			}
			$pekerjaan = $this->Post_pekerjaan_model->read_informasi_pekerjaan($r->pekerjaan_id);
			if(!is_null($pekerjaan)){
				$title_pekerjaan = $pekerjaan[0]->title_pekerjaan;
			} else {
				$title_pekerjaan = '--';	
			}
			$created_at = $this->Umb_model->set_date_format($r->created_at);
			$data[] = array(
				'<span data-toggle="tooltip" data-placement="top" title="Download">
				<a href="'.site_url().'hr/download?type=resume&filename='.$r->pekerjaan_resume.'"><button type="button" class="btn icon-btn btn-sm btn-outline-success waves-effect waves-light" title="Download"><i class="oi oi-cloud-download"></i></button></a></span><a href="'.site_url().'frontend/pekerjaans/detail/'.$r->pekerjaan_id.'/" target="_blank" data-toggle="tooltip" data-placement="top" title="" data-original-title="View"><button type="button" class="btn icon-btn btn-sm btn-outline-info waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a>',
				$title_pekerjaan,
				$full_name,
				$uemail,
				$r->application_status,
				$created_at
			);
		}
		$output = array(
			"draw" => $draw,
			"recordsTotal" => $kandidats->num_rows(),
			"recordsFiltered" => $kandidats->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function interviews_pekerjaans() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('left_interviews_pekerjaan').' | '.$this->Umb_model->site_title();
		$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		$data['all_interview_pekerjaans'] = $this->Post_pekerjaan_model->all_interview_pekerjaans();
		$data['breadcrumbs'] = $this->lang->line('left_interviews_pekerjaan');
		$data['path_url'] = 'user/user_interviews_pekerjaan';
		if(!empty($session)){ 
			$data['subview'] = $this->load->view("karyawan/user/interviews_pekerjaan", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
		} else {
			redirect('admin/');
		}
		
	}
	
	public function list_interview_pekerjaans() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("karyawan/user/interviews_pekerjaan", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$interview = $this->Post_pekerjaan_model->all_interviews();
		$data = array();
		foreach($interview->result() as $r) {
			$aim = explode(',',$r->interviewees_id);
			foreach($aim as $dIds) {
				if($session['user_id'] == $dIds) {
					$pekerjaan = $this->Post_pekerjaan_model->read_informasi_pekerjaan($r->pekerjaan_id);
					if(!is_null($pekerjaan)){
						$title_pekerjaan = $pekerjaan[0]->title_pekerjaan;
					} else {
						$title_pekerjaan = '--';	
					}
					$tanggal_interview = $this->Umb_model->set_date_format($r->tanggal_interview);
					/*if($r->interviewers_id == '') {
						$interviewers = '-';
					} else {
						$interviewers = '<ol class="nl">';
						foreach(explode(',',$r->interviewers_id) as $interviewers_id) {
							$user_intwer = $this->Umb_model->read_user_info($interviewers_id);
							$interviewers .= '<li>'.$user_intwer[0]->first_name. ' '.$user_intwer[0]->last_name.'</li>';
						}
						$interviewers .= '</ol>';
					}*/
					$waktu_interview = $r->tanggal_interview.' '.$r->waktu_interview;
					$interview_ex_waktu =  new DateTime($waktu_interview);
					$int_time = $interview_ex_waktu->format('h:i a');
					$interview_d_t = $tanggal_interview.' '.$int_time;
					$u_ditambahkan = $this->Eumb_model->read_user_info($r->added_by);
					if(!is_null($u_ditambahkan)){
						$int_ditambahkan_oleh = $u_ditambahkan[0]->first_name. ' '.$u_ditambahkan[0]->last_name;
					} else {
						$int_ditambahkan_oleh = '--';	
					}
					$description = html_entity_decode($r->description);
					$data[] = array(
						'<a href="'.site_url().'frontend/pekerjaans/detail/'.$r->pekerjaan_id.'/" target="_blank" data-toggle="tooltip" data-placement="top" title="" data-original-title="View"><button type="button" class="btn icon-btn btn-sm btn-outline-info waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a>',
						$title_pekerjaan,
						$description,
						$r->tempat_interview,
						$interview_d_t,
						$int_ditambahkan_oleh
					);
				}
			} 
		}
		$output = array(
			"draw" => $draw,
			"recordsTotal" => $interview->num_rows(),
			"recordsFiltered" => $interview->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function pengumuman() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('umb_pengumumans').' | '.$this->Umb_model->site_title();
		$data['all_penunjukans'] = $this->Penunjukan_model->all_penunjukans();
		$data['breadcrumbs'] = $this->lang->line('umb_pengumumans');
		$data['path_url'] = 'user/user_pengumuman';
		if(!empty($session)){
			$data['subview'] = $this->load->view("karyawan/user/list_pengumuman", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
		} else {
			redirect('admin/');
		}
		
	}
	
	public function list_pengumuman() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("karyawan/user/list_pengumuman", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$pengumuman = $this->Pengumuman_model->get_pengumumans();
		$data = array();
		foreach($pengumuman->result() as $r) {
			$user = $this->Eumb_model->read_user_info($r->diterbitkan_oleh);
			if(!is_null($user)){
				$full_name = $user[0]->first_name.' '.$user[0]->last_name;
			} else {
				$full_name = '--';	
			}
			$sdate = $this->Umb_model->set_date_format($r->start_date);
			$edate = $this->Umb_model->set_date_format($r->end_date);
			$department = $this->Department_model->read_informasi_department($r->department_id);
			if(!is_null($department)){
				$nama_department = $department[0]->nama_department;
			} else {
				$nama_department = '--';	
			}
			$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-info waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-pengumuman_id="'. $r->pengumuman_id . '"><span class="fa fa-eye"></span></button></span>',
				$r->title,
				$r->summary,
				$nama_department,
				$sdate,
				$edate,
				$full_name
			);
		}
		$output = array(
			"draw" => $draw,
			"recordsTotal" => $pengumuman->num_rows(),
			"recordsFiltered" => $pengumuman->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}
	
	public function read_pengumuman() {
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('pengumuman_id');
		$result = $this->Pengumuman_model->read_informasi_pengumuman($id);
		$data = array(
			'pengumuman_id' => $result[0]->pengumuman_id,
			'title' => $result[0]->title,
			'perusahaan_id' => $result[0]->perusahaan_id,
			'start_date' => $result[0]->start_date,
			'end_date' => $result[0]->end_date,
			'perusahaan_id' => $result[0]->perusahaan_id,
			'department_id' => $result[0]->department_id,
			'diterbitkan_oleh' => $result[0]->diterbitkan_oleh,
			'summary' => $result[0]->summary,
			'description' => $result[0]->description,
			'get_all_perusahaans' => $this->Perusahaan_model->get_all_perusahaans(),
			'all_locations_kantor' => $this->Location_model->all_locations_kantor(),
			'all_departments' => $this->Department_model->all_departments()
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('karyawan/user/dialog_pengumuman', $data);
		} else {
			redirect('admin/');
		}
	}

	public function claims_biaya() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('umb_biayaa').' | '.$this->Umb_model->site_title();
		$data['all_types_biaya'] = $this->Biaya_model->all_types_biaya();
		$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		$data['get_all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$data['breadcrumbs'] = $this->lang->line('umb_biayaa');
		$data['path_url'] = 'user/user_claims_biaya';
		$data['subview'] = $this->load->view("karyawan/user/list_biaya", $data, TRUE);
		$this->load->view('admin/layout/layout_main', $data); 
	}
	
	public function list_biaya() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("karyawan/user/list_biaya", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$biaya = $this->Biaya_model->get_biayaa_karyawan();
		$data = array();
		foreach($biaya->result() as $r) {
			$type_biaya = $this->Biaya_model->read_informasi_type_biaya($r->type_biaya_id);
			if(!is_null($type_biaya)){
				$pengeluaran = $type_biaya[0]->name;
			} else {
				$pengeluaran = '--';	
			}
			$user = $this->Umb_model->read_user_info($r->karyawan_id);
			if(!is_null($user)){
				$full_name = $user[0]->first_name.' '.$user[0]->last_name;
			} else {
				$full_name = '--';	
			}
			$edate = $this->Umb_model->set_date_format($r->tanggal_pembelian);
			$currency = $this->Umb_model->currency_sign($r->jumlah);
			$download = '';
			$perusahaan = $this->Umb_model->read_info_perusahaan($r->perusahaan_id);
			if(!is_null($perusahaan)){
				$prshn_nama = $perusahaan[0]->name;
			} else {
				$prshn_nama = '--';	
			}
			if($r->status==0): 
				$status = $this->lang->line('umb_pending'); 
			elseif($r->status==1): 
				$status = $this->lang->line('umb_approved'); 
			else: 
				$status = $this->lang->line('umb_cancel'); 
			endif;
			if($r->billcopy_file!='' && $r->billcopy_file!='no file') {
				$download = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_download').'"><a href="'.site_url().'hr/download?type=biaya&filename='.$r->billcopy_file.'"><button type="button" class="btn icon-btn btn-sm btn-outline-success waves-effect waves-light" title="'.$this->lang->line('umb_download').'"><span class="oi oi-cloud-download"></span></button></a></span>';
			}
			$data[] = array(
				'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-info waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-biaya_id="'. $r->biaya_id . '"><span class="fas fa-pencil-alt"></span></button></span>'.$download.'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-info waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-biaya_id="'. $r->biaya_id . '"><span class="fa fa-eye"></span></button></span>',
				$prshn_nama,
				$full_name,
				$pengeluaran,
				$currency,
				$edate,
				$status,
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $biaya->num_rows(),
			"recordsFiltered" => $biaya->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function perjalanan() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('left_perjalanans').' | '.$this->Umb_model->site_title();
		$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		$data['types_pengaturan_perjalanan'] = $this->Perjalanan_model->types_pengaturan_perjalanan();
		$data['get_all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$data['breadcrumbs'] = $this->lang->line('left_perjalanans');
		$data['path_url'] = 'user/user_perjalanan';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(!empty($session)){ 
			$data['subview'] = $this->load->view("karyawan/user/list_perjalanan", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
		} else {
			redirect('admin/');
		}
	}
	
	public function list_perjalanan()
	{

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("karyawan/user/list_perjalanan", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$perjalanan = $this->Perjalanan_model->get_karyawan_perjalanan($session['user_id']);
		$data = array();
		foreach($perjalanan->result() as $r) {
			$karyawan = $this->Umb_model->read_user_info($r->karyawan_id);
			if(!is_null($karyawan)){
				$nama_karyawan = $karyawan[0]->first_name.' '.$karyawan[0]->last_name;
			} else {
				$nama_karyawan = '--';	
			}
			$start_date = $this->Umb_model->set_date_format($r->start_date);
			$end_date = $this->Umb_model->set_date_format($r->end_date);
			$perusahaan = $this->Umb_model->read_info_perusahaan($r->perusahaan_id);
			if(!is_null($perusahaan)){
				$prshn_nama = $perusahaan[0]->name;
			} else {
				$prshn_nama = '--';	
			}
			if($r->status==0): 
				$status = $this->lang->line('umb_pending');
			elseif($r->status==1): 
				$status = $this->lang->line('umb_accepted'); 
			else: 
				$status = $this->lang->line('umb_rejected'); 
			endif;
			$data[] = array(
				'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-info waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-perjalanan_id="'. $r->perjalanan_id . '"><span class="fas fa-pencil-alt"></span></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-info waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-perjalanan_id="'. $r->perjalanan_id . '"><span class="fa fa-eye"></span></button></span>',
				$nama_karyawan,
				$prshn_nama,
				$r->visit_purpose,
				$r->visit_place,
				$start_date,
				$end_date,
				$status
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $perjalanan->num_rows(),
			"recordsFiltered" => $perjalanan->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function slipgaji() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('umb_slipgaji').' | '.$this->Umb_model->site_title();
		$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		$data['breadcrumbs'] = $this->lang->line('umb_slipgaji');
		$data['path_url'] = 'user/user_slipgaji';
		if(!empty($session)){ 
			$data['subview'] = $this->load->view("karyawan/user/slipgajii", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
		} else {
			redirect('admin/');
		}
		
	}
	
	public function list_slipgaji_karyawan() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("karyawan/user/slipgajii", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$history = $this->Payroll_model->get_payroll_slip($session['user_id']);
		
		$data = array();

		foreach($history->result() as $r) {

			$user = $this->Eumb_model->read_user_info($r->karyawan_id);
			$full_name = $user[0]->first_name.' '.$user[0]->last_name;
			$month_payment = date("F, Y", strtotime($r->payment_date));
			//$month_payment = $this->Umb_model->set_date_format($r->payment_date);
			$p_jumlah = $this->Umb_model->currency_sign($r->jumlah_pembayaran);
			$created_at = $this->Umb_model->set_date_format($r->created_at);
			$slipgaji = '<a class="text-success" href="'.site_url().'admin/user/uslipgaji/id/'.$r->melakukan_pembayaran_id.'/">'.$this->lang->line('left_generate_slipgaji').'</a>';
			$functions = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-info waves-effect waves-light" data-toggle="modal" data-target=".detail_modal_data" data-karyawan_id="'. $r->karyawan_id . '" data-pay_id="'. $r->melakukan_pembayaran_id . '"><span class="fa fa-arrow-circle-right"></span></button></span>';
			
			if($r->payment_method==1){
				$p_method = 'Online';
			} else if($r->payment_method==2){
				$p_method = 'PayPal';
			} else if($r->payment_method==3) {
				$p_method = 'Payoneer';
			} else if($r->payment_method==4){
				$p_method = 'Bank Transfer';
			} else if($r->payment_method==5) {
				$p_method = 'Cheque';
			} else {
				$p_method = 'Cash';
			}

			$data[] = array(
				$functions,
				'#'.$r->melakukan_pembayaran_id,
				$p_jumlah,
				$month_payment,
				$created_at,
				$p_method,
				$slipgaji
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $history->num_rows(),
			"recordsFiltered" => $history->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function uslipgaji() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$payment_id = $this->uri->segment(5);
		
		$result = $this->Payroll_model->read_informasi_melakukan_pembayaran($payment_id);
		if(is_null($result)){
			redirect('admin/user/slipgaji');
		}
		$p_method = '';
		if($result[0]->payment_method==1){
			$p_method = 'Online';
		} else if($result[0]->payment_method==2){
			$p_method = 'PayPal';
		} else if($result[0]->payment_method==3) {
			$p_method = 'Payoneer';
		} else if($result[0]->payment_method==4){
			$p_method = 'Bank Transfer';
		} else if($result[0]->payment_method==5) {
			$p_method = 'Cheque';
		} else {
			$p_method = 'Cash';
		}
		$user = $this->Umb_model->read_user_info($result[0]->karyawan_id);
		if(!is_null($user)){
			$first_name = $user[0]->first_name;
			$last_name = $user[0]->last_name;
		} else {
			$first_name = '--';
			$last_name = '--';
		}
		$penunjukan = $this->Penunjukan_model->read_informasi_penunjukan($user[0]->penunjukan_id);
		if(!is_null($penunjukan)){
			$nama_penunjukan = $penunjukan[0]->nama_penunjukan;
		} else {
			$nama_penunjukan = '--';	
		}
		$department = $this->Department_model->read_informasi_department($user[0]->department_id);
		if(!is_null($department)){
			$nama_department = $department[0]->nama_department;
		} else {
			$nama_department = '--';	
		}
		//$department_penunjukan = $penunjukan[0]->nama_penunjukan.'('.$department[0]->nama_department.')';
		$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		$data = array(
			'title' => $this->lang->line('umb_payroll_karyawan_slipgaji').' | '.$this->Umb_model->site_title(),
			'first_name' => $first_name,
			'last_name' => $last_name,
			'karyawan_id' => $user[0]->karyawan_id,
			'no_kontak' => $user[0]->no_kontak,
			'tanggal_bergabung' => $user[0]->tanggal_bergabung,
			'nama_department' => $nama_department,
			'nama_penunjukan' => $nama_penunjukan,
			'tanggal_bergabung' => $user[0]->tanggal_bergabung,
			'profile_picture' => $user[0]->profile_picture,
			'jenis_kelamin' => $user[0]->jenis_kelamin,
			'monthly_grade_id' => $user[0]->monthly_grade_id,
			'hourly_grade_id' => $user[0]->hourly_grade_id,
			'melakukan_pembayaran_id' => $result[0]->melakukan_pembayaran_id,
			'gaji_pokok' => $result[0]->gaji_pokok,
			'payment_date' => $result[0]->payment_date,
			'is_potong_advance_gaji' => $result[0]->is_potong_advance_gaji,
			'jumlah_advance_gaji' => $result[0]->jumlah_advance_gaji,
			'jumlah_pembayaran' => $result[0]->jumlah_pembayaran,
			'payment_method' => $p_method,
			'nilai_lembur' => $result[0]->nilai_lembur,
			'nilai_perjam' => $result[0]->nilai_perjam,
			'total_jam_kerja' => $result[0]->total_jam_kerja,
			'is_payment' => $result[0]->is_payment,
			'tunjangan_sewa_rumah' => $result[0]->tunjangan_sewa_rumah,
			'tunjangan_kesehatan' => $result[0]->tunjangan_kesehatan,
			'tunjangan_perjalanan' => $result[0]->tunjangan_perjalanan,
			'tunjangan_jabatan' => $result[0]->tunjangan_jabatan,
			'dana_yang_diberikan' => $result[0]->dana_yang_diberikan,
			'security_deposit' => $result[0]->security_deposit,
			'potongan_pajak' => $result[0]->potongan_pajak,
			'gross_gaji' => $result[0]->gross_gaji,
			'total_tunjanagans' => $result[0]->total_tunjanagans,
			'total_potongans' => $result[0]->total_potongans,
			'gaji_bersih' => $result[0]->gaji_bersih,
			'comments' => $result[0]->comments,
		);
		$data['breadcrumbs'] = $this->lang->line('umb_payroll_karyawan_slipgaji');
		$data['path_url'] = 'slipgaji';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(!empty($session)){ 
			$data['subview'] = $this->load->view("karyawan/user/slipgaji_details", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
		} else {
			redirect('admin/');
		}
	}

	public function add_biaya() {
		
		if($this->input->post('add_type')=='biaya') {
			$file = $_FILES['bill_copy']['tmp_name'];
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$remarks = $this->input->post('remarks');
			$qt_remarks = htmlspecialchars(addslashes($remarks), ENT_QUOTES);	
			if($this->input->post('type_biaya')==='') {
				$Return['error'] = $this->lang->line('umb_error_type_biaya');
			} else if($this->input->post('tanggal_pembelian')==='') {
				$Return['error'] = $this->lang->line('umb_error_tanggal_pembelian');
			} else if($this->input->post('jumlah')==='') {
				$Return['error'] = $this->lang->line('umb_error_jumlah_biaya');
			} else if($this->input->post('perusahaan_id')==='') {
				$Return['error'] = $this->lang->line('error_field_perusahaan');
			} else if($this->input->post('karyawan_id')==='') {
				$Return['error'] = $this->lang->line('umb_error_karyawan_id');
			} 
			else if($_FILES['bill_copy']['size'] == 0) {
				$fname = 'no file';
			} else {
				if(is_uploaded_file($_FILES['bill_copy']['tmp_name'])) {
					$allowed =  array('png','jpg','jpeg','gif');
					$filename = $_FILES['bill_copy']['name'];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);
					if(in_array($ext,$allowed)){
						$tmp_name = $_FILES["bill_copy"]["tmp_name"];
						$bill_copy = "uploads/biaya/";
						$lname = basename($_FILES["bill_copy"]["name"]);
						$newfilename = 'bill_copy_'.round(microtime(true)).'.'.$ext;
						move_uploaded_file($tmp_name, $bill_copy.$newfilename);
						$fname = $newfilename;
					} else {
						$Return['error'] = $this->lang->line('umb_error_type_file_biaya');
					}
				}
			}
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			if($Return['error']!=''){
				$this->output($Return);
			}
			$data = array(
				'type_biaya_id' => $this->input->post('type_biaya'),
				'perusahaan_id' => $this->input->post('perusahaan_id'),
				'tanggal_pembelian' => $this->input->post('tanggal_pembelian'),
				'jumlah' => $this->input->post('jumlah'),
				'karyawan_id' => $this->input->post('karyawan_id'),
				'billcopy_file' => $fname,
				'remarks' => $qt_remarks,
				'created_at' => date('d-m-Y'),
			);
			$result = $this->Biaya_model->add($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_tambah_biaya');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$this->output($Return);
			exit;
		}
	}

	public function read_biaya() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('biaya_id');
		$result = $this->Biaya_model->read_informasi_biaya($id);
		$data = array(
			'biaya_id' => $result[0]->biaya_id,
			'karyawan_id' => $result[0]->karyawan_id,
			'perusahaan_id' => $result[0]->perusahaan_id,
			'type_biaya_id' => $result[0]->type_biaya_id,
			'billcopy_file' => $result[0]->billcopy_file,
			'jumlah' => $result[0]->jumlah,
			'tanggal_pembelian' => $result[0]->tanggal_pembelian,
			'remarks' => $result[0]->remarks,
			'status' => $result[0]->status,
			'all_types_biaya' => $this->Biaya_model->all_types_biaya(),
			'all_karyawans' => $this->Umb_model->all_karyawans(),
			'get_all_perusahaans' => $this->Umb_model->get_perusahaans()
		);
		if(!empty($session)){ 
			$this->load->view('karyawan/user/dialog_biaya', $data);
		} else {
			redirect('admin/');
		}
	}

	public function update_biaya() {
		
		if($this->input->post('edit_type')=='biaya') {
			$id = $this->uri->segment(4);
			$file = $_FILES['bill_copy']['tmp_name'];
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$remarks = $this->input->post('remarks');
			$qt_remarks = htmlspecialchars(addslashes($remarks), ENT_QUOTES);		
			$no_logo_data = array(
				'type_biaya_id' => $this->input->post('type_biaya'),
				'tanggal_pembelian' => $this->input->post('tanggal_pembelian'),
				'jumlah' => $this->input->post('jumlah'),
				'remarks' => $qt_remarks,
			);
			if($this->input->post('type_biaya')==='') {
				$Return['error'] = $this->lang->line('umb_error_type_biaya');
			} else if($this->input->post('tanggal_pembelian')==='') {
				$Return['error'] = $this->lang->line('umb_error_tanggal_pembelian');
			} else if($this->input->post('jumlah')==='') {
				$Return['error'] = $this->lang->line('umb_error_jumlah_biaya');
			}  
			else if($_FILES['bill_copy']['size'] == 0) {
				$fname = 'no file';
				$result = $this->Biaya_model->update_record_no_logo($no_logo_data,$id);
			} else {
				if(is_uploaded_file($_FILES['bill_copy']['tmp_name'])) {
					$allowed =  array('png','jpg','jpeg','gif');
					$filename = $_FILES['bill_copy']['name'];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);
					if(in_array($ext,$allowed)){
						$tmp_name = $_FILES["bill_copy"]["tmp_name"];
						$bill_copy = "uploads/biaya/";
						$lname = basename($_FILES["bill_copy"]["name"]);
						$newfilename = 'bill_copy_'.round(microtime(true)).'.'.$ext;
						move_uploaded_file($tmp_name, $bill_copy.$newfilename);
						$fname = $newfilename;
						$data = array(
							'type_biaya_id' => $this->input->post('type_biaya'),
							'tanggal_pembelian' => $this->input->post('tanggal_pembelian'),
							'jumlah' => $this->input->post('jumlah'),
							'perusahaan_id' => $this->input->post('perusahaan_id'),
							'karyawan_id' => $this->input->post('karyawan_id'),
							'status' => $this->input->post('status'),
							'billcopy_file' => $fname,
							'remarks' => $qt_remarks,		
						);
						$result = $this->Biaya_model->update_record($data,$id);
					} else {
						$Return['error'] = $this->lang->line('umb_error_type_file_biaya');
					}
				}
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_perbarui_biaya');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function read_perjalanan() {
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('perjalanan_id');
		$result = $this->Perjalanan_model->read_informasi_perjalanan($id);
		$data = array(
			'perjalanan_id' => $result[0]->perjalanan_id,
			'perusahaan_id' => $result[0]->perusahaan_id,
			'karyawan_id' => $result[0]->karyawan_id,
			'start_date' => $result[0]->start_date,
			'end_date' => $result[0]->end_date,
			'visit_purpose' => $result[0]->visit_purpose,
			'visit_place' => $result[0]->visit_place,
			'perjalanan_mode' => $result[0]->perjalanan_mode,
			'arrangement_type' => $result[0]->arrangement_type,
			'expected_budget' => $result[0]->expected_budget,
			'actual_budget' => $result[0]->actual_budget,
			'description' => $result[0]->description,
			'status' => $result[0]->status,
			'all_karyawans' => $this->Umb_model->all_karyawans(),
			'get_all_perusahaans' => $this->Umb_model->get_perusahaans(),
			'types_pengaturan_perjalanan' => $this->Perjalanan_model->types_pengaturan_perjalanan(),
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('karyawan/user/dialog_perjalanan', $data);
		} else {
			redirect('karyawan/');
		}
	}

	public function read_awards() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('award_id');
		$result = $this->Awards_model->read_informasi_award($id);
		$data = array(
			'award_id' => $result[0]->award_id,
			'perusahaan_id' => $result[0]->perusahaan_id,
			'karyawan_id' => $result[0]->karyawan_id,
			'type_award_id' => $result[0]->type_award_id,
			'gift_item' => $result[0]->gift_item,
			'photo_award' => $result[0]->photo_award,
			'cash_price' => $result[0]->cash_price,
			'bulan_tahun_award' => $result[0]->bulan_tahun_award,
			'informasi_award' => $result[0]->informasi_award,
			'description' => $result[0]->description,
			'created_at' => $result[0]->created_at,
			'all_karyawans' => $this->Umb_model->all_karyawans(),
			'all_types_award' => $this->Awards_model->all_types_award(),
			'get_all_perusahaans' => $this->Umb_model->get_perusahaans()
		);
		if(!empty($session)){ 
			$this->load->view('admin/awards/dialog_award', $data);
		} else {
			redirect('admin/');
		}
	}
	
	public function add_perjalanan() {
		
		if($this->input->post('add_type')=='perjalanan') {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$start_date = $this->input->post('start_date');
			$end_date = $this->input->post('end_date');
			$description = $this->input->post('description');
			$st_date = strtotime($start_date);
			$ed_date = strtotime($end_date);
			$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
			if($this->input->post('perusahaan_id')==='') {
				$Return['error'] = $this->lang->line('error_field_perusahaan');
			} else if($this->input->post('karyawan_id')==='') {
				$Return['error'] = $this->lang->line('umb_error_karyawan_id');
			} else if($this->input->post('start_date')==='') {
				$Return['error'] = $this->lang->line('umb_error_start_date');
			} else if($this->input->post('end_date')==='') {
				$Return['error'] = $this->lang->line('umb_error_end_date');
			} else if($st_date > $ed_date) {
				$Return['error'] = $this->lang->line('umb_error_start_end_date');
			} else if($this->input->post('visit_purpose')==='') {
				$Return['error'] = $this->lang->line('umb_error_perjalanan_purpose');
			} else if($this->input->post('visit_place')==='') {
				$Return['error'] = $this->lang->line('umb_error_perjalanan_visit_place');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$data = array(
				'karyawan_id' => $this->input->post('karyawan_id'),
				'perusahaan_id' => $this->input->post('perusahaan_id'),
				'start_date' => $this->input->post('start_date'),
				'end_date' => $this->input->post('end_date'),
				'visit_purpose' => $this->input->post('visit_purpose'),
				'visit_place' => $this->input->post('visit_place'),
				'perjalanan_mode' => $this->input->post('perjalanan_mode'),
				'arrangement_type' => $this->input->post('arrangement_type'),
				'expected_budget' => $this->input->post('expected_budget'),
				'actual_budget' => $this->input->post('actual_budget'),
				'description' => $qt_description,
				'added_by' => $this->input->post('user_id'),
				'created_at' => date('d-m-Y'),
				
			);
			$result = $this->Perjalanan_model->add($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_perjalanan_ditambahkan');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function update_perjalanan() {
		
		if($this->input->post('edit_type')=='perjalanan') {
			$id = $this->uri->segment(4);
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$start_date = $this->input->post('start_date');
			$end_date = $this->input->post('end_date');
			$description = $this->input->post('description');
			$st_date = strtotime($start_date);
			$ed_date = strtotime($end_date);
			$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
			if($this->input->post('start_date')==='') {
				$Return['error'] = $this->lang->line('umb_error_start_date');
			} else if($this->input->post('end_date')==='') {
				$Return['error'] = $this->lang->line('umb_error_end_date');
			} else if($st_date > $ed_date) {
				$Return['error'] = $this->lang->line('umb_error_start_end_date');
			} else if($this->input->post('visit_purpose')==='') {
				$Return['error'] = $this->lang->line('umb_error_perjalanan_purpose');
			} else if($this->input->post('visit_place')==='') {
				$Return['error'] = $this->lang->line('umb_error_perjalanan_visit_place');
			}
			
			if($Return['error']!=''){
				$this->output($Return);
			}
			$data = array(
				'start_date' => $this->input->post('start_date'),
				'end_date' => $this->input->post('end_date'),
				'visit_purpose' => $this->input->post('visit_purpose'),
				'visit_place' => $this->input->post('visit_place'),
				'perjalanan_mode' => $this->input->post('perjalanan_mode'),
				'arrangement_type' => $this->input->post('arrangement_type'),
				'expected_budget' => $this->input->post('expected_budget'),
				'actual_budget' => $this->input->post('actual_budget'),
				'description' => $qt_description,
				'status' => $this->input->post('status'),		
			);
			$result = $this->Perjalanan_model->update_record($data,$id);		
			
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_perjalanan_diperbarui');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function advance_gaji() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('umb_advance_gaji').' | '.$this->Umb_model->site_title();
		$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		$data['all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$data['breadcrumbs'] = $this->lang->line('umb_advance_gaji');
		$data['path_url'] = 'user/user_advance_gaji';
		$data['subview'] = $this->load->view("karyawan/user/advance_gaji", $data, TRUE);
		$this->load->view('admin/layout/layout_main', $data); 
	}
	
	public function laporan_advance_gaji() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('umb_laporan_advance_gaji').' | '.$this->Umb_model->site_title();
		$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		$data['all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$data['breadcrumbs'] = $this->lang->line('umb_laporan_advance_gaji');
		$data['path_url'] = 'user/user_laporan_advance_gaji';
		$data['subview'] = $this->load->view("karyawan/user/laporan_advance_gaji", $data, TRUE);
		$this->load->view('admin/layout/layout_main', $data); 
	}
	
	public function add_advance_gaji() {
		
		if($this->input->post('add_type')=='advance_gaji') {		
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$reason = $this->input->post('reason');
			$qt_reason = htmlspecialchars(addslashes($reason), ENT_QUOTES);
			if($this->input->post('perusahaan')==='') {
				$Return['error'] = $this->lang->line('error_field_perusahaan');
			} else if($this->input->post('karyawan_id')==='') {
				$Return['error'] = $this->lang->line('umb_error_karyawan_id');
			} else if($this->input->post('month_year')==='') {
				$Return['error'] = $this->lang->line('umb_error_advance_gaji_bulan_year');
			} else if($this->input->post('jumlah')==='') {
				$Return['error'] = $this->lang->line('umb_error_field_jumlah');
			}
			
			if($Return['error']!=''){
				$this->output($Return);
			}
			if($this->input->post('pengurangan_satu_kali')==1){
				$angsuran_bulanan = 0;
			} else {
				$angsuran_bulanan = $this->input->post('angsuran_bulanan');
			}
			$data = array(
				'karyawan_id' => $this->input->post('karyawan_id'),
				'perusahaan_id' => $this->input->post('perusahaan'),
				'reason' => $qt_reason,
				'month_year' => $this->input->post('month_year'),
				'advance_jumlah' => $this->input->post('jumlah'),
				'angsuran_bulanan' => $angsuran_bulanan,
				'total_yang_dibayarkan' => 0,
				'pengurangan_satu_kali' => $this->input->post('pengurangan_satu_kali'),
				'status' => $this->input->post('status'),
				'created_at' => date('Y-m-d h:i:s')
			);
			$result = $this->Payroll_model->add_payroll_advance_gaji($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_kirim_permintaan_advance_gaji');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function list_advance_gaji() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("karyawan/user/advance_gaji", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$advance_gaji = $this->Payroll_model->get_advance_gajii();
		$data = array();
		foreach($advance_gaji->result() as $r) {
			$user = $this->Umb_model->read_user_info($r->karyawan_id);
			if(!is_null($user)){
				$full_name = $user[0]->first_name.' '.$user[0]->last_name;
			} else {
				$full_name = '--';	
			}
			$d = explode('-',$r->month_year);
			$get_month = date('F', mktime(0, 0, 0, $d[1], 10));
			$month_year = $get_month.', '.$d[0];
			$advance_jumlah = $this->Umb_model->currency_sign($r->advance_jumlah);
			$cdate = $this->Umb_model->set_date_format($r->created_at);
			if($r->status==0): $status = $this->lang->line('umb_pending'); elseif($r->status==1): $status = $this->lang->line('umb_accepted'); else: $status = $this->lang->line('umb_rejected'); endif;
			$angsuran_bulanan = $this->Umb_model->currency_sign($r->angsuran_bulanan);
			if($r->pengurangan_satu_kali==1): $onetime = $this->lang->line('umb_yes'); else: $onetime = $this->lang->line('umb_no'); endif;
			$perusahaan = $this->Umb_model->read_info_perusahaan($r->perusahaan_id);
			if(!is_null($perusahaan)){
				$prshn_nama = $perusahaan[0]->name;
			} else {
				$prshn_nama = '--';	
			}
			$data[] = array(
				'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-info waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-advance_gaji_id="'. $r->advance_gaji_id . '"><span class="fa fa-eye"></span></button></span>',
				$prshn_nama,
				$advance_jumlah,
				$month_year,
				$onetime,
				$angsuran_bulanan,
				$cdate,
				$status
			);
		}
		$output = array(
			"draw" => $draw,
			"recordsTotal" => $advance_gaji->num_rows(),
			"recordsFiltered" => $advance_gaji->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}
	
	public function read_advance_gaji() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('advance_gaji_id');
       // $data['all_negaraa'] = $this->Umb_model->get_negaraa();
		$result = $this->Payroll_model->read_info_advance_gaji($id);
		$data = array(
			'advance_gaji_id' => $result[0]->advance_gaji_id,
			'perusahaan_id' => $result[0]->perusahaan_id,
			'karyawan_id' => $result[0]->karyawan_id,
			'month_year' => $result[0]->month_year,
			'advance_jumlah' => $result[0]->advance_jumlah,
			'pengurangan_satu_kali' => $result[0]->pengurangan_satu_kali,
			'angsuran_bulanan' => $result[0]->angsuran_bulanan,
			'reason' => $result[0]->reason,
			'status' => $result[0]->status,
			'created_at' => $result[0]->created_at,
			'all_karyawans' => $this->Umb_model->all_karyawans(),
			'get_all_perusahaans' => $this->Umb_model->get_perusahaans()
		);
		if(!empty($session)){ 
			$this->load->view('karyawan/user/dialog_advance_gaji', $data);
		} else {
			redirect('admin/');
		}
	}
	
	public function read_laporan_advance_gaji() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('hr/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('karyawan_id');
       // $data['all_negaraa'] = $this->Umb_model->get_negaraa();
		$result = $this->Payroll_model->view_laporan_advance_gaji($id);
		$data = array(
			'advance_gaji_id' => $result[0]->advance_gaji_id,
			'karyawan_id' => $result[0]->karyawan_id,
			'perusahaan_id' => $result[0]->perusahaan_id,
			'month_year' => $result[0]->month_year,
			'advance_jumlah' => $result[0]->advance_jumlah,
			'total_yang_dibayarkan' => $result[0]->total_yang_dibayarkan,
			'pengurangan_satu_kali' => $result[0]->pengurangan_satu_kali,
			'angsuran_bulanan' => $result[0]->angsuran_bulanan,
			'reason' => $result[0]->reason,
			'status' => $result[0]->status,
			'created_at' => $result[0]->created_at,
			'all_karyawans' => $this->Umb_model->all_karyawans(),
			'get_all_perusahaans' => $this->Umb_model->get_perusahaans()
		);
		if(!empty($session)){ 
			$this->load->view('karyawan/user/dialog_advance_gaji', $data);
		} else {
			redirect('hr/');
		}
	}
	
	public function list_laporan_advance_gaji() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("karyawan/user/advance_gaji", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$advance_gaji = $this->Payroll_model->get_laporan_advance_gajii();
		$data = array();
		foreach($advance_gaji->result() as $r) {
			$user = $this->Umb_model->read_user_info($r->karyawan_id);
			if(!is_null($user)){
				$full_name = $user[0]->first_name.' '.$user[0]->last_name;
			} else {
				$full_name = '--';	
			}
			$d = explode('-',$r->month_year);
			$get_month = date('F', mktime(0, 0, 0, $d[1], 10));
			$month_year = $get_month.', '.$d[0];
			$advance_jumlah = $this->Umb_model->currency_sign($r->advance_jumlah);
			$cdate = $this->Umb_model->set_date_format($r->created_at);
			if($r->status==0): 
				$status = $this->lang->line('umb_pending'); 
			elseif($r->status==1): 
				$status = $this->lang->line('umb_accepted'); 
			else: 
				$status = $this->lang->line('umb_rejected'); 
			endif;
			$angsuran_bulanan = $this->Umb_model->currency_sign($r->angsuran_bulanan);
			$remainig_jumlah = $r->advance_jumlah - $r->total_yang_dibayarkan;
			$rjumlah = $this->Umb_model->currency_sign($remainig_jumlah);
			if($r->pengurangan_satu_kali==1): 
				$onetime = $this->lang->line('umb_yes'); 
			else: 
				$onetime = $this->lang->line('umb_no'); 
			endif;
			if($r->advance_jumlah == $r->total_yang_dibayarkan){
				$all_dibayar = '<span class="tag tag-success">'.$this->lang->line('umb_all_dibayar').'</span>';
			} else {
				$all_dibayar = '<span class="tag tag-warning">'.$this->lang->line('umb_remaining').'</span>';
			}
			$total_yang_dibayarkan = $this->Umb_model->currency_sign($r->total_yang_dibayarkan);
			$perusahaan = $this->Umb_model->read_info_perusahaan($r->perusahaan_id);
			if(!is_null($perusahaan)){
				$prshn_nama = $perusahaan[0]->name;
			} else {
				$prshn_nama = '--';	
			}
			$data[] = array(
				'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-info waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-karyawan_id="'. $r->karyawan_id . '"><span class="fa fa-eye"></span></button></span>',
				$prshn_nama,
				$advance_jumlah,
				$total_yang_dibayarkan,
				$rjumlah,
				$all_dibayar,
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $advance_gaji->num_rows(),
			"recordsFiltered" => $advance_gaji->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function read_kebijakan() {
		
		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('karyawan/user/dialog_kebijakan', $data);
		} else {
			redirect('admin/');
		}
	}
}
