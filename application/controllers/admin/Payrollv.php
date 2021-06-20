<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Payroll extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->library('Pdf');
		
		$this->load->model("Payroll_model");
		$this->load->model("Umb_model");
		$this->load->model("Karyawans_model");
		$this->load->model("Penunjukan_model");
		$this->load->model("Department_model");
		$this->load->model("Location_model");
	}
	
	public function output($Return=array()){
		
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		
		exit(json_encode($Return));
	}
	
	public function templates()
	{
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('left_payroll_templates').' | '.$this->Umb_model->site_title();
		$data['all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$data['breadcrumbs'] = $this->lang->line('left_payroll_templates');
		$data['path_url'] = 'payroll_templates';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('34',$role_resources_ids)) {
			if(!empty($session)){
				$data['subview'] = $this->load->view("admin/payroll/templates", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}		  
	}
	
	public function generate_slipgaji()
	{
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('left_generate_slipgaji').' | '.$this->Umb_model->site_title();
		$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		$data['all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$data['breadcrumbs'] = $this->lang->line('left_generate_slipgaji');
		$data['path_url'] = 'generate_slipgaji';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('36',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/payroll/generate_slipgaji", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}
	
	public function history_pembayaran()
	{
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('left_history_pembayaran').' | '.$this->Umb_model->site_title();
		$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		$data['breadcrumbs'] = $this->lang->line('left_history_pembayaran');
		$data['path_url'] = 'history_pembayaran';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('37',$role_resources_ids)) {
			if(!empty($session)){
				$data['subview'] = $this->load->view("admin/payroll/history_pembayaran", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}		  
	}
	
	public function list_slipgaji() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/payroll/generate_slipgaji", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$p_date = $this->input->get("month_year");
		if($this->input->get("karyawan_id")==0 && $this->input->get("perusahaan_id")==0) {
			$slipgaji = $this->Karyawans_model->get_karyawans();
		} else if($this->input->get("karyawan_id")==0 && $this->input->get("perusahaan_id")!=0) {
			$slipgaji = $this->Payroll_model->get_template_prsh($this->input->get("perusahaan_id"),0);
		} else if($this->input->get("karyawan_id")!=0 && $this->input->get("perusahaan_id")!=0) {
			$slipgaji = $this->Payroll_model->get_karyawan_template_prsh($this->input->get("perusahaan_id"),$this->input->get("karyawan_id"));
		} else {
			$slipgaji = $this->Karyawans_model->get_karyawans();
		}
		
		$system = $this->Umb_model->read_setting_info(1);
		/*$default_currency = $this->Umb_model->read_currency_con_info($system[0]->default_currency_id);
		if(!is_null($default_currency)) {
			$current_rate = $default_currency[0]->to_currency_rate;
			$current_title = $default_currency[0]->to_currency_title;
		} else {
			$current_rate = 1;
			$current_title = 'USD';
		}*/
		$data = array();

		foreach($slipgaji->result() as $r) {
			
			$nama_krywn = $r->first_name.' '.$r->last_name;
			$full_name = '<a target="_blank" class="text-primary" href="'.site_url().'admin/karyawans/detail/'.$r->user_id.'">'.$nama_krywn.'</a>';
			
			$result = $this->Payroll_model->total_slipgaji_jam_bekerja($r->user_id,$this->input->get('month_year'));
			$hrs_old_int1 = 0;//'';
			$Total = 0;
			$Tistrahat = 0;
			$total_time_rs = 0;
			$hrs_old_int_res1 = 0;
			foreach ($result->result() as $jam_kerja){
				// total work			
				$clock_in =  new DateTime($jam_kerja->clock_in);
				$clock_out =  new DateTime($jam_kerja->clock_out);
				$interval_late = $clock_in->diff($clock_out);
				$hours_r  = $interval_late->format('%h');
				$minutes_r = $interval_late->format('%i');			
				$total_time = $hours_r .":".$minutes_r.":".'00';
				
				$str_time = $total_time;
				
				$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);
				
				sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
				
				$hrs_old_seconds = $hours * 3600 + $minutes * 60 + $seconds;
				
				$hrs_old_int1 += $hrs_old_seconds;
				
				$Total = gmdate("H", $hrs_old_int1);			
			}
				// get perusahaan
			$perusahaan = $this->Umb_model->read_info_perusahaan($r->perusahaan_id);
			if(!is_null($perusahaan)){
				$prshn_nama = $perusahaan[0]->name;
			} else {
				$prshn_nama = '--';	
			}
			
			if($r->type_upahh==1){
				$type_upahh = $this->lang->line('umb_payroll_gaji_pokok');
				$gaji_pokok = $r->gaji_pokok;
				$p_class = 'emo_monthly_pay';
			} else {
				$type_upahh = $this->lang->line('umb_karyawan_upahh_harian');
				$gaji_pokok = $r->upahh_harian;
				$p_class = 'emo_monthly_pay';
			}
			
			$gaji_tunjanagans = $this->Karyawans_model->read_gaji_tunjanagans($r->user_id);
			$count_tunjanagans = $this->Karyawans_model->count_karyawan_tunjanagans($r->user_id);
			$jumlah_tunjanagan = 0;
			if($count_tunjanagans > 0) {
				foreach($gaji_tunjanagans as $sl_tunjanagans){
					$jumlah_tunjanagan += $sl_tunjanagans->jumlah_tunjanagan;
				}
			} else {
				$jumlah_tunjanagan = 0;
			}
			
			$gaji_pinjaman_potongan = $this->Karyawans_model->read_gaji_pinjaman_potongans($r->user_id);
			$count_pinjaman_potongan = $this->Karyawans_model->count_karyawan_potongans($r->user_id);
			$jumlah_ptng_pinjaman = 0;
			if($count_pinjaman_potongan > 0) {
				foreach($gaji_pinjaman_potongan as $sl_gaji_pinjaman_potongan){
					$jumlah_ptng_pinjaman += $sl_gaji_pinjaman_potongan->pinjaman_jumlah_potongan;
				}
			} else {
				$jumlah_ptng_pinjaman = 0;
			}
			
			$count_komissi = $this->Karyawans_model->count_karyawan_komissi($r->user_id);
			$komissi = $this->Karyawans_model->set_komissi_karyawan($r->user_id);
			$jumlah_komissi = 0;
			if($count_komissi > 0) {
				foreach($komissi->result() as $sl_gaji_komissi){
					$jumlah_komissi += $sl_gaji_komissi->jumlah_komisi;
				}
			} else {
				$jumlah_komissi = 0;
			}

			$count_pembayarans_lainnya = $this->Karyawans_model->count_karyawan_pembayarans_lainnya($r->user_id);
			$pembayarans_lainnya = $this->Karyawans_model->set_karyawan_pembayarans_lainnya($r->user_id);
			$jumlah_pembayarans_lainnya = 0;
			if($count_pembayarans_lainnya > 0) {
				foreach($pembayarans_lainnya->result() as $sl_pembayarans_lainnya) {
					$jumlah_pembayarans_lainnya += $sl_pembayarans_lainnya->jumlah_pembayarans;
				}
			} else {
				$jumlah_pembayarans_lainnya = 0;
			}

			$count_statutory_potongans = $this->Karyawans_model->count_karyawan_statutory_potongans($r->user_id);
			$statutory_potongans = $this->Karyawans_model->set_karyawan_statutory_potongans($r->user_id);
			$jumlah_statutory_potongans = 0;
			if($count_statutory_potongans > 0) {
				foreach($statutory_potongans->result() as $sl_gaji_statutory_potongans){
					//$sta_gaji = $jumlah_tunjanagan + $gaji_pokok;
					//$st_jumlah = $sta_gaji / 100 * $sl_statutory_potongans->jumlah_potongan;
					$jumlah_statutory_potongans += $sl_gaji_statutory_potongans->jumlah_potongan;
				}
			} else {
				$jumlah_statutory_potongans = 0;
			}				
			
			$gaji_lembur = $this->Karyawans_model->read_gaji_lembur($r->user_id);
			$count_lembur = $this->Karyawans_model->count_karyawan_lembur($r->user_id);
			$jumlah_lembur = 0;
			if($count_lembur > 0) {
				foreach($gaji_lembur as $sl_lembur){
					$total_lembur = $sl_lembur->jam_lembur * $sl_lembur->nilai_lembur;
					$jumlah_lembur += $total_lembur;
				}
			} else {
				$jumlah_lembur = 0;
			}
			
			$total_earning = $gaji_pokok + $jumlah_tunjanagan + $jumlah_lembur + $jumlah_komissi + $jumlah_pembayarans_lainnya;
			$total_potongan = $jumlah_ptng_pinjaman + $jumlah_statutory_potongans;
			$total_gaji_bersih = $total_earning - $total_potongan;
			//if($r->bayar_gaji_advance == ''){
				//$data1 = $add_gaji. ' - ' .$jumlah_ptng_pinjaman. ' - ' .$gaji_bersih . ' - ' .$gaji_ssempee . ' - ' .$statutory_potongans;
				//$fgaji_bersih = $gaji_bersih_default + $statutory_potongans;
			//	$gaji_bersih = $fgaji_bersih - $jumlah_ptng_pinjaman;
			$gaji_bersih = number_format((float)$total_gaji_bersih, 2, '.', '');
			//$allinfo = $gaji_pokok  .' - '.  $jumlah_tunjanagan  .' - '.  $all_pembayaran_lainnya  .' - '.  $jumlah_ptng_pinjaman  .' - '.  $jumlah_lembur  .' - '.  $statutory_potongans; // for testing purpose
			$check_pembayaran = $this->Payroll_model->read_check_melakukan_pembayaran_slipgaji($r->user_id,$p_date);
			if($check_pembayaran->num_rows() > 0){
				$melakukan_pembayaran = $this->Payroll_model->read_melakukan_pembayaran_slipgaji($r->user_id,$p_date);
				$status = '<span class="label label-success">'.$this->lang->line('umb_payroll_bayar').'</span>';
				$mpay = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_payroll_view_slipgaji').'"><a href="'.site_url().'admin/payroll/slipgaji/id/'.$melakukan_pembayaran[0]->slipgaji_id.'"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_download').'"><a href="'.site_url().'admin/payroll/pdf_create/p/'.$melakukan_pembayaran[0]->slipgaji_id.'"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light"><span class="fa fa-download"></span></button></a></span>';
				$delete = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-xs btn-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $melakukan_pembayaran[0]->slipgaji_id . '"><span class="fa fa-trash"></span></button></span>';
			} else {
				$status = '<span class="label label-danger">'.$this->lang->line('umb_payroll_belum_dibayar').'</span>';
				$mpay = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_payroll_melakukan_pembayaran').'"><button type="button" class="btn icon-btn btn-xs btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".'.$p_class.'" data-karyawan_id="'. $r->user_id . '" data-payment_date="'. $p_date . '" data-perusahaan_id="'.$this->input->get("perusahaan_id").'"><span class="fa fas fa-money"></span></button></span>';
				$delete = '';
			}
			//$gaji_pokok_cal = $gaji_pokok * $current_rate; 
			//	$gaji_bersih_cal = $gaji_bersih * $current_rate; 
			if($gaji_pokok == 0 || $gaji_pokok == '') {
				$fmpay = '';
			} else {
				$fmpay = $mpay;
			}
			$gaji_pokok = number_format((float)$gaji_pokok, 2, '.', '');
			$gaji_pokok = $this->Umb_model->currency_sign($gaji_pokok);
			$gaji_bersih = $this->Umb_model->currency_sign($gaji_bersih);
			
			$detail = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_view').'"><button type="button" class="btn icon-btn btn-xs btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".modal_payroll_template" data-karyawan_id="'. $r->user_id . '"><span class="fa fa-eye"></span></button></span>';
			$inama_krywn = $nama_krywn.'<small class="text-muted"><i> ('.$prshn_nama.')<i></i></i></small><br><small class="text-muted"><i>'.$this->lang->line('umb_karyawans_id').': '.$r->karyawan_id.'<i></i></i></small>';
			
			$act = $detail.$fmpay.$delete;
			$data[] = array(
				$act,
				$inama_krywn,
				$type_upahh,
				$gaji_pokok,
				$gaji_bersih,
				$status
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $slipgaji->num_rows(),
			"recordsFiltered" => $slipgaji->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}
	
	public function read_payroll_template()
	{
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('karyawan_id');

		$user = $this->Umb_model->read_user_info($id);
		
		$full_name = $user[0]->first_name.' '.$user[0]->last_name;

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
		$data = array(
			'first_name' => $user[0]->first_name,
			'last_name' => $user[0]->last_name,
			'karyawan_id' => $user[0]->karyawan_id,
			'user_id' => $user[0]->user_id,
			'nama_department' => $nama_department,
			'nama_penunjukan' => $nama_penunjukan,
			'tanggal_bergabung' => $user[0]->tanggal_bergabung,
			'profile_picture' => $user[0]->profile_picture,
			'jenis_kelamin' => $user[0]->jenis_kelamin,
			'type_upahh' => $user[0]->type_upahh,
			'gaji_pokok' => $user[0]->gaji_pokok,
			'upahh_harian' => $user[0]->upahh_harian
		);
		if(!empty($session)){ 
			$this->load->view('admin/payroll/dialog_templates', $data);
		} else {
			redirect('admin/');
		}
	}
	

	public function pay_gaji()
	{
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('karyawan_id');
		$user = $this->Umb_model->read_user_info($id);
		$result = $this->Payroll_model->read_template_information($user[0]->monthly_grade_id);
		//$department = $this->Department_model->read_informasi_department($user[0]->department_id);
		$penunjukan = $this->Penunjukan_model->read_informasi_penunjukan($user[0]->penunjukan_id);
		if(!is_null($penunjukan)){
			$penunjukan_id = $penunjukan[0]->penunjukan_id;
		} else {
			$penunjukan_id = 1;	
		}
		// department
		$department = $this->Department_model->read_informasi_department($user[0]->department_id);
		if(!is_null($department)){
			$department_id = $department[0]->department_id;
		} else {
			$department_id = 1;	
		}
		//$location = $this->Location_model->read_informasi_location($department[0]->location_id);
		$data = array(
			'department_id' => $department_id,
			'penunjukan_id' => $penunjukan_id,
			'perusahaan_id' => $user[0]->perusahaan_id,
			'user_id' => $user[0]->user_id,
			'type_upahh' => $user[0]->type_upahh,
			'gaji_pokok' => $user[0]->gaji_pokok,
			'upahh_harian' => $user[0]->upahh_harian,
		);
		if(!empty($session)){ 
			$this->load->view('admin/payroll/dialog_melakukan_pembayaran', $data);
		} else {
			redirect('admin/');
		}
	}
	
	> add monthly payment
	public function add_pay_monthly() {
		
		if($this->input->post('add_type')=='add_monthly_payment') {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
			
			
		/*if($Return['error']!=''){
       		$this->output($Return);
       	}*/
       	$gaji_pokok = $this->input->post('gaji_pokok');
       	
       	$data = array(
       		'karyawan_id' => $this->input->post('krywn_id'),
       		'department_id' => $this->input->post('department_id'),
       		'perusahaan_id' => $this->input->post('perusahaan_id'),
       		'penunjukan_id' => $this->input->post('penunjukan_id'),
       		'gaji_bulan' => $this->input->post('pay_date'),
       		'gaji_pokok' => $gaji_pokok,
       		'gaji_bersih' => $this->input->post('gaji_bersih'),
       		'type_upahh' => $this->input->post('type_upahh'),
       		'total_komissi' => $this->input->post('total_komissi'),
       		'total_statutory_potongans' => $this->input->post('total_statutory_potongans'),
       		'total_pembayarans_lainnya' => $this->input->post('total_pembayarans_lainnya'),
       		'total_tunjanagans' => $this->input->post('total_tunjanagans'),
       		'total_pinjaman' => $this->input->post('total_pinjaman'),
       		'total_lembur' => $this->input->post('total_lembur'),
       		'is_payment' => '1',
       		'year_to_date' => date('d-m-Y'),
       		'created_at' => date('d-m-Y h:i:s')
       	);
       	$result = $this->Payroll_model->add_gaji_slipgaji($data);	
       	
       	if ($result) {
			// set tunjanagan
       		$gaji_tunjanagans = $this->Karyawans_model->read_gaji_tunjanagans($this->input->post('krywn_id'));
       		$count_tunjanagans = $this->Karyawans_model->count_karyawan_tunjanagans($this->input->post('krywn_id'));
       		$jumlah_tunjanagan = 0;
       		if($count_tunjanagans > 0) {
       			foreach($gaji_tunjanagans as $sl_tunjanagans){
       				$tunjanagan_data = array(
       					'slipgaji_id' => $result,
       					'karyawan_id' => $this->input->post('krywn_id'),
       					'gaji_bulan' => $this->input->post('pay_date'),
       					'title_tunjanagan' => $sl_tunjanagans->title_tunjanagan,
       					'jumlah_tunjanagan' => $sl_tunjanagans->jumlah_tunjanagan,
       					'created_at' => date('d-m-Y h:i:s')
       				);
       				$_tunjanagan_data = $this->Payroll_model->add_gaji_slipgaji_tunjanagans($tunjanagan_data);
       			}
       		}
			// set komissi
       		$gaji_komissi = $this->Karyawans_model->read_gaji_komissi($this->input->post('krywn_id'));
       		$count_komisi = $this->Karyawans_model->count_karyawan_komissi($this->input->post('krywn_id'));
       		$jumlah_komisi = 0;
       		if($count_komisi > 0) {
       			foreach($gaji_komissi as $sl_komisi){
       				$komissi_data = array(
       					'slipgaji_id' => $result,
       					'karyawan_id' => $this->input->post('krywn_id'),
       					'gaji_bulan' => $this->input->post('pay_date'),
       					'komisi_title' => $sl_komisi->komisi_title,
       					'jumlah_komisi' => $sl_komisi->jumlah_komisi,
       					'created_at' => date('d-m-Y h:i:s')
       				);
       				$this->Payroll_model->add_gaji_slipgaji_komissi($komissi_data);
       			}
       		}
			// set other payments
       		$gaji_pembayarans_lainnya = $this->Karyawans_model->read_gaji_pembayarans_lainnya($this->input->post('krywn_id'));
       		$count_pembayaran_lainnya = $this->Karyawans_model->count_karyawan_pembayarans_lainnya($this->input->post('krywn_id'));
       		$pembayaran_lainnya_jumlah = 0;
       		if($count_pembayaran_lainnya > 0) {
       			foreach($gaji_pembayarans_lainnya as $sl_pembayarans_lainnya){
       				$pembayarans_lainnya_data = array(
       					'slipgaji_id' => $result,
       					'karyawan_id' => $this->input->post('krywn_id'),
       					'gaji_bulan' => $this->input->post('pay_date'),
       					'title_pembayarans' => $sl_pembayarans_lainnya->title_pembayarans,
       					'jumlah_pembayarans' => $sl_pembayarans_lainnya->jumlah_pembayarans,
       					'created_at' => date('d-m-Y h:i:s')
       				);
       				$this->Payroll_model->add_gaji_slipgaji_pembayarans_lainnya($pembayarans_lainnya_data);
       			}
       		}
			// set statutory_potongans
       		$gaji_statutory_potongans = $this->Karyawans_model->read_gaji_statutory_potongans($this->input->post('krywn_id'));
       		$count_statutory_potongans = $this->Karyawans_model->count_karyawan_statutory_potongans($this->input->post('krywn_id'));
       		$jumlah_statutory_potongans = 0;
       		if($count_statutory_potongans > 0) {
       			foreach($gaji_statutory_potongans as $sl_statutory_potongan){
       				$statutory_potongan_data = array(
       					'slipgaji_id' => $result,
       					'karyawan_id' => $this->input->post('krywn_id'),
       					'gaji_bulan' => $this->input->post('pay_date'),
       					'title_potongan' => $sl_statutory_potongan->title_potongan,
       					'jumlah_potongan' => $sl_statutory_potongan->jumlah_potongan,
       					'created_at' => date('d-m-Y h:i:s')
       				);
       				$this->Payroll_model->add_gaji_slipgaji_statutory_potongans($statutory_potongan_data);
       			}
       		}
			// set loan
       		$gaji_pinjaman_potongan = $this->Karyawans_model->read_gaji_pinjaman_potongans($this->input->post('krywn_id'));
       		$count_pinjaman_potongan = $this->Karyawans_model->count_karyawan_potongans($this->input->post('krywn_id'));
       		$jumlah_ptng_pinjaman = 0;
       		if($count_pinjaman_potongan > 0) {
       			foreach($gaji_pinjaman_potongan as $sl_gaji_pinjaman_potongan){
       				$pinjaman_data = array(
       					'slipgaji_id' => $result,
       					'karyawan_id' => $this->input->post('krywn_id'),
       					'gaji_bulan' => $this->input->post('pay_date'),
       					'pinjaman_title' => $sl_gaji_pinjaman_potongan->title_potongan_pinjaman,
       					'pinjaman_jumlah' => $sl_gaji_pinjaman_potongan->pinjaman_jumlah_potongan,
       					'created_at' => date('d-m-Y h:i:s')
       				);
       				$_pinjaman_data = $this->Payroll_model->add_gaji_slipgaji_pinjaman($pinjaman_data);
       			}
       		}
			// set lembur
       		$gaji_lembur = $this->Karyawans_model->read_gaji_lembur($this->input->post('krywn_id'));
       		$count_lembur = $this->Karyawans_model->count_karyawan_lembur($this->input->post('krywn_id'));
       		$jumlah_lembur = 0;
       		if($count_lembur > 0) {
       			foreach($gaji_lembur as $sl_lembur){
					//$total_lembur = $sl_lembur->jam_lembur * $sl_lembur->nilai_lembur;
       				$lembur_data = array(
       					'slipgaji_id' => $result,
       					'karyawan_id' => $this->input->post('krywn_id'),
       					'lembur_gaji_bulan' => $this->input->post('pay_date'),
       					'title_lembur' => $sl_lembur->type_lembur,
       					'lembur_no_of_days' => $sl_lembur->no_of_days,
       					'jam_lembur' => $sl_lembur->jam_lembur,
       					'nilai_lembur' => $sl_lembur->nilai_lembur,
       					'created_at' => date('d-m-Y h:i:s')
       				);
       				$_lembur_data = $this->Payroll_model->add_gaji_slipgaji_lembur($lembur_data);
       			}
       		}
       		
       		$Return['result'] = $this->lang->line('umb_sukses_payment_bayar');
       	} else {
       		$Return['error'] = $this->lang->line('umb_error_msg');
       	}
       	$this->output($Return);
       	exit;
       }
   }
   
   > add monthly payment
   public function add_pay_to_all() {
   	
   	if($this->input->post('add_type')=='payroll') {		
   		$result = $this->Umb_model->all_karyawans();
   		foreach($result as $krywnid) {
   			$user_id = $krywnid->user_id;
   			$user = $this->Umb_model->read_user_info($user_id);
   			
   			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
   			$Return['csrf_hash'] = $this->security->get_csrf_hash();
   			
   			
   			if($krywnid->type_upahh==1){
   				$gaji_pokok = $krywnid->gaji_pokok;
   			} else {
   				$gaji_pokok = $krywnid->upahh_harian;
   			}
   			if($gaji_pokok > 0) {
		// get designation
   				$penunjukan = $this->Penunjukan_model->read_informasi_penunjukan($user[0]->penunjukan_id);
   				if(!is_null($penunjukan)){
   					$penunjukan_id = $penunjukan[0]->penunjukan_id;
   				} else {
   					$penunjukan_id = 1;	
   				}
		// department
   				$department = $this->Department_model->read_informasi_department($user[0]->department_id);
   				if(!is_null($department)){
   					$department_id = $department[0]->department_id;
   				} else {
   					$department_id = 1;	
   				}
   				
   				$gaji_tunjanagans = $this->Karyawans_model->read_gaji_tunjanagans($user_id);
   				$count_tunjanagans = $this->Karyawans_model->count_karyawan_tunjanagans($user_id);
   				$jumlah_tunjanagan = 0;
   				if($count_tunjanagans > 0) {
   					foreach($gaji_tunjanagans as $sl_tunjanagans){
   						$jumlah_tunjanagan += $sl_tunjanagans->jumlah_tunjanagan;
   					}
   				} else {
   					$jumlah_tunjanagan = 0;
   				}
		// 3: all loan/potongans
   				$gaji_pinjaman_potongan = $this->Karyawans_model->read_gaji_pinjaman_potongans($user_id);
   				$count_pinjaman_potongan = $this->Karyawans_model->count_karyawan_potongans($user_id);
   				$jumlah_ptng_pinjaman = 0;
   				if($count_pinjaman_potongan > 0) {
   					foreach($gaji_pinjaman_potongan as $sl_gaji_pinjaman_potongan){
   						$jumlah_ptng_pinjaman += $sl_gaji_pinjaman_potongan->pinjaman_jumlah_potongan;
   					}
   				} else {
   					$jumlah_ptng_pinjaman = 0;
   				}
   				
   				
		// 5: lembur
   				$gaji_lembur = $this->Karyawans_model->read_gaji_lembur($user_id);
   				$count_lembur = $this->Karyawans_model->count_karyawan_lembur($user_id);
   				$jumlah_lembur = 0;
   				if($count_lembur > 0) {
   					foreach($gaji_lembur as $sl_lembur){
   						$total_lembur = $sl_lembur->jam_lembur * $sl_lembur->nilai_lembur;
   						$jumlah_lembur += $total_lembur;
   					}
   				} else {
   					$jumlah_lembur = 0;
   				}
   				
   				
   				
		// 6: statutory potongans
		// 4: other payment
   				$pembayarans_lainnya = $this->Karyawans_model->set_karyawan_pembayarans_lainnya($user_id);
   				$jumlah_pembayarans_lainnya = 0;
   				if(!is_null($pembayarans_lainnya)):
   					foreach($pembayarans_lainnya->result() as $sl_pembayarans_lainnya) {
   						$jumlah_pembayarans_lainnya += $sl_pembayarans_lainnya->jumlah_pembayarans;
   					}
   				endif;
		// all other payment
   				$all_pembayaran_lainnya = $jumlah_pembayarans_lainnya;
		// 5: komissi
   				$komissi = $this->Karyawans_model->set_komissi_karyawan($user_id);
   				if(!is_null($komissi)):
   					$jumlah_komissi = 0;
   					foreach($komissi->result() as $sl_komissi) {
   						$jumlah_komissi += $sl_komissi->jumlah_komisi;
   					}
   				endif;
		// 6: statutory potongans
   				$statutory_potongans = $this->Karyawans_model->set_karyawan_statutory_potongans($user_id);
   				if(!is_null($statutory_potongans)):
   					$jumlah_statutory_potongans = 0;
   					foreach($statutory_potongans->result() as $sl_statutory_potongans) {
				//$sta_gaji = $jumlah_tunjanagan + $gaji_pokok;
   						$st_jumlah = $sl_statutory_potongans->jumlah_potongan;
   						$jumlah_statutory_potongans += $sl_statutory_potongans->jumlah_potongan;
   					}
   				endif;
   				
		// add amount
   				$add_gaji = $jumlah_tunjanagan + $gaji_pokok + $jumlah_lembur + $jumlah_pembayarans_lainnya + $jumlah_komissi;
		// add amount
   				$gaji_bersih_default = $add_gaji - $jumlah_ptng_pinjaman - $jumlah_statutory_potongans;
   				$gaji_bersih = $gaji_bersih_default;
   				$gaji_bersih = number_format((float)$gaji_bersih, 2, '.', '');
   				
   				$data = array(
   					'karyawan_id' => $user_id,
   					'department_id' => $department_id,
   					'perusahaan_id' => $user[0]->perusahaan_id,
   					'penunjukan_id' => $penunjukan_id,
   					'gaji_bulan' => $this->input->post('month_year'),
   					'gaji_pokok' => $gaji_pokok,
   					'gaji_bersih' => $gaji_bersih,
   					'type_upahh' => $krywnid->type_upahh,
   					
   					'total_tunjanagans' => $jumlah_tunjanagan,
   					'total_pinjaman' => $jumlah_ptng_pinjaman,
   					'total_lembur' => $jumlah_lembur,
   					'total_komissi' => $jumlah_komissi,
   					'total_statutory_potongans' => $jumlah_statutory_potongans,
   					'total_pembayarans_lainnya' => $jumlah_pembayarans_lainnya,
   					'is_payment' => '1',
   					'year_to_date' => date('d-m-Y'),
   					'created_at' => date('d-m-Y h:i:s')
   				);
   				$result = $this->Payroll_model->add_gaji_slipgaji($data);	
   				
   				if ($result) {
   					$gaji_tunjanagans = $this->Karyawans_model->read_gaji_tunjanagans($user_id);
   					$count_tunjanagans = $this->Karyawans_model->count_karyawan_tunjanagans($user_id);
   					$jumlah_tunjanagan = 0;
   					if($count_tunjanagans > 0) {
   						foreach($gaji_tunjanagans as $sl_tunjanagans){
   							$tunjanagan_data = array(
   								'slipgaji_id' => $result,
   								'karyawan_id' => $user_id,
   								'gaji_bulan' => $this->input->post('month_year'),
   								'title_tunjanagan' => $sl_tunjanagans->title_tunjanagan,
   								'jumlah_tunjanagan' => $sl_tunjanagans->jumlah_tunjanagan,
   								'created_at' => date('d-m-Y h:i:s')
   							);
   							$_tunjanagan_data = $this->Payroll_model->add_gaji_slipgaji_tunjanagans($tunjanagan_data);
   						}
   					}
			// set komissi
   					$gaji_komissi = $this->Karyawans_model->read_gaji_komissi($user_id);
   					$count_komisi = $this->Karyawans_model->count_karyawan_komissi($user_id);
   					$jumlah_komisi = 0;
   					if($count_komisi > 0) {
   						foreach($gaji_komissi as $sl_komisi){
   							$komissi_data = array(
   								'slipgaji_id' => $result,
   								'karyawan_id' => $user_id,
   								'gaji_bulan' => $this->input->post('month_year'),
   								'komisi_title' => $sl_komisi->komisi_title,
   								'jumlah_komisi' => $sl_komisi->jumlah_komisi,
   								'created_at' => date('d-m-Y h:i:s')
   							);
   							$this->Payroll_model->add_gaji_slipgaji_komissi($komissi_data);
   						}
   					}
		// set other payments
   					$gaji_pembayarans_lainnya = $this->Karyawans_model->read_gaji_pembayarans_lainnya($user_id);
   					$count_pembayaran_lainnya = $this->Karyawans_model->count_karyawan_pembayarans_lainnya($user_id);
   					$pembayaran_lainnya_jumlah = 0;
   					if($count_pembayaran_lainnya > 0) {
   						foreach($gaji_pembayarans_lainnya as $sl_pembayarans_lainnya){
   							$pembayarans_lainnya_data = array(
   								'slipgaji_id' => $result,
   								'karyawan_id' => $user_id,
   								'gaji_bulan' => $this->input->post('month_year'),
   								'title_pembayarans' => $sl_pembayarans_lainnya->title_pembayarans,
   								'jumlah_pembayarans' => $sl_pembayarans_lainnya->jumlah_pembayarans,
   								'created_at' => date('d-m-Y h:i:s')
   							);
   							$this->Payroll_model->add_gaji_slipgaji_pembayarans_lainnya($pembayarans_lainnya_data);
   						}
   					}
		// set statutory_potongans
   					$gaji_statutory_potongans = $this->Karyawans_model->read_gaji_statutory_potongans($user_id);
   					$count_statutory_potongans = $this->Karyawans_model->count_karyawan_statutory_potongans($user_id);
   					$jumlah_statutory_potongans = 0;
   					if($count_statutory_potongans > 0) {
   						foreach($gaji_statutory_potongans as $sl_statutory_potongan){
   							$statutory_potongan_data = array(
   								'slipgaji_id' => $result,
   								'karyawan_id' => $user_id,
   								'gaji_bulan' => $this->input->post('month_year'),
   								'title_potongan' => $sl_statutory_potongan->title_potongan,
   								'jumlah_potongan' => $sl_statutory_potongan->jumlah_potongan,
   								'created_at' => date('d-m-Y h:i:s')
   							);
   							$this->Payroll_model->add_gaji_slipgaji_statutory_potongans($statutory_potongan_data);
   						}
   					}
   					$gaji_pinjaman_potongan = $this->Karyawans_model->read_gaji_pinjaman_potongans($user_id);
   					$count_pinjaman_potongan = $this->Karyawans_model->count_karyawan_potongans($user_id);
   					$jumlah_ptng_pinjaman = 0;
   					if($count_pinjaman_potongan > 0) {
   						foreach($gaji_pinjaman_potongan as $sl_gaji_pinjaman_potongan){
   							$pinjaman_data = array(
   								'slipgaji_id' => $result,
   								'karyawan_id' => $user_id,
   								'gaji_bulan' => $this->input->post('month_year'),
   								'pinjaman_title' => $sl_gaji_pinjaman_potongan->title_potongan_pinjaman,
   								'pinjaman_jumlah' => $sl_gaji_pinjaman_potongan->pinjaman_jumlah_potongan,
   								'created_at' => date('d-m-Y h:i:s')
   							);
   							$_pinjaman_data = $this->Payroll_model->add_gaji_slipgaji_pinjaman($pinjaman_data);
   						}
   					}
   					$gaji_lembur = $this->Karyawans_model->read_gaji_lembur($user_id);
   					$count_lembur = $this->Karyawans_model->count_karyawan_lembur($user_id);
   					$jumlah_lembur = 0;
   					if($count_lembur > 0) {
   						foreach($gaji_lembur as $sl_lembur){
					//$total_lembur = $sl_lembur->jam_lembur * $sl_lembur->nilai_lembur;
   							$lembur_data = array(
   								'slipgaji_id' => $result,
   								'karyawan_id' => $user_id,
   								'lembur_gaji_bulan' => $this->input->post('month_year'),
   								'title_lembur' => $sl_lembur->type_lembur,
   								'lembur_no_of_days' => $sl_lembur->no_of_days,
   								'jam_lembur' => $sl_lembur->jam_lembur,
   								'nilai_lembur' => $sl_lembur->nilai_lembur,
   								'created_at' => date('d-m-Y h:i:s')
   							);
   							$_lembur_data = $this->Payroll_model->add_gaji_slipgaji_lembur($lembur_data);
   						}
   					}
   					
   					$Return['result'] = $this->lang->line('umb_sukses_payment_bayar');
   				} else {
   					$Return['error'] = $this->lang->line('umb_error_msg');
   				}
   				
		} // if basic gaji
	}
	$Return['result'] = $this->lang->line('umb_sukses_payment_bayar');
	$this->output($Return);
	exit;
		} // f
	}
	
	// list_perjam > templates
	public function list_history_pembayaran()
	{

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/payroll/history_pembayaran", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('391',$role_resources_ids)) {
			$history = $this->Payroll_model->karyawans_history_pembayaran();
		} else {
			$history = $this->Payroll_model->get_payroll_slip($session['user_id']);
		}
		$data = array();

		foreach($history->result() as $r) {

			// get addd by > template
			$user = $this->Umb_model->read_user_info($r->karyawan_id);
			
			if(!is_null($user)){
				$full_name = $user[0]->first_name.' '.$user[0]->last_name;
				$link_krywn = $user[0]->karyawan_id;			  		  
				$month_payment = date("F, Y", strtotime($r->gaji_bulan));
				
				$p_jumlah = $this->Umb_model->currency_sign($r->gaji_bersih);
				
			// get date > created at > and format
				$created_at = $this->Umb_model->set_date_format($r->created_at);
				
				$slipgaji = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_view').'"><a href="'.site_url().'admin/payroll/slipgaji/id/'.$r->slipgaji_id.'"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_download').'"><a href="'.site_url().'admin/payroll/pdf_create/p/'.$r->slipgaji_id.'"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light"><span class="fa fa-download"></span></button></a></span>';
				
				$ifull_name = $full_name.'<br><small class="text-muted"><i>'.$this->lang->line('umb_karyawans_id').': '.$link_krywn.'<i></i></i></small>';
				$data[] = array(
					$slipgaji,
					$ifull_name,
					$p_jumlah,
					$month_payment,
					$created_at,
				);
			}
		  } // if karyawan available

		  $output = array(
		  	"draw" => $draw,
		  	"recordsTotal" => $history->num_rows(),
		  	"recordsFiltered" => $history->num_rows(),
		  	"data" => $data
		  );
		  echo json_encode($output);
		  exit();
		}
		
	// payment history
		public function slipgaji()
		{
			$session = $this->session->userdata('username');
			if(empty($session)){ 
				redirect('admin/');
			}
		//$data['title'] = $this->Umb_model->site_title();
			$payment_id = $this->uri->segment(5);
			
			$result = $this->Payroll_model->read_gaji_info_slipgaji($payment_id);
		/*if(is_null($result)){
			redirect('admin/payroll/history_pembayaran');
		}*/
		$p_method = '';
		$payment_method = $this->Umb_model->read_payment_method($result[0]->payment_method);
		if(!is_null($payment_method)){
			$p_method = $payment_method[0]->method_name;
		} else {
			$p_method = '--';
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
			'melakukan_pembayaran_id' => $result[0]->slipgaji_id,
			'type_upahh' => $result[0]->type_upahh,
			'payment_date' => $result[0]->gaji_bulan,
			'gaji_pokok' => $result[0]->gaji_pokok,
			'upahh_harian' => $result[0]->upahh_harian,
			'payment_method' => $p_method,				
			'total_tunjanagans' => $result[0]->total_tunjanagans,
			'total_pinjaman' => $result[0]->total_pinjaman,
			'total_lembur' => $result[0]->total_lembur,
			'total_komissi' => $result[0]->total_komissi,
			'total_statutory_potongans' => $result[0]->total_statutory_potongans,
			'total_pembayarans_lainnya' => $result[0]->total_pembayarans_lainnya,
			'gaji_bersih' => $result[0]->gaji_bersih,
			'pembayaran_lainnya' => $result[0]->pembayaran_lainnya,
			'pay_comments' => $result[0]->pay_comments,
			'is_payment' => $result[0]->is_payment,
		);
		$data['breadcrumbs'] = $this->lang->line('umb_payroll_karyawan_slipgaji');
		$data['path_url'] = 'slipgaji';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(!empty($session)){ 
			$data['subview'] = $this->load->view("admin/payroll/slipgaji", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
		} else {
			redirect('admin/');
		}
	}
	
	public function pddf_create() {
		
		//$this->load->library('Pdf');
		$system = $this->Umb_model->read_setting_info(1);
		
		
		
		 // create new PDF document
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		$id = $this->uri->segment(5);
		$payment = $this->Payroll_model->read_informasi_slipgaji($id);
		$user = $this->Umb_model->read_user_info($payment[0]->karyawan_id);
		
		// if password generate option enable
		if($system[0]->is_generate_password_slipgaji==1) {
			/**
			* Protect PDF from being printed, copied or modified. In order to being viewed, the user needs
			* to provide password as selected format in settings module.
			*/
			if($system[0]->format_password_slipgaji=='dateofbirth') {
				$password_val = date("dmY", strtotime($user[0]->tanggal_lahir));
			} else if($system[0]->format_password_slipgaji=='no_kontak') {
				$password_val = $user[0]->no_kontak;
			} else if($system[0]->format_password_slipgaji=='full_name') {
				$password_val = $user[0]->first_name.$user[0]->last_name;
			} else if($system[0]->format_password_slipgaji=='email') {
				$password_val = $user[0]->email;
			} else if($system[0]->format_password_slipgaji=='password') {
				$password_val = $user[0]->password;
			} else if($system[0]->format_password_slipgaji=='user_password') {
				$password_val = $user[0]->username.$user[0]->password;
			} else if($system[0]->format_password_slipgaji=='karyawan_id') {
				$password_val = $user[0]->karyawan_id;
			} else if($system[0]->format_password_slipgaji=='karyawan_id_password') {
				$password_val = $user[0]->karyawan_id.$user[0]->password;
			} else if($system[0]->format_password_slipgaji=='nama_tanggal_lahir') {
				$dob = date("dmY", strtotime($user[0]->tanggal_lahir));
				$fname = $user[0]->first_name;
				$lname = $user[0]->last_name;
				$password_val = $dob.$fname[0].$lname[0];
			}
			$pdf->SetProtection(array('print', 'copy','modify'), $password_val, $password_val, 0, null);
		}
		
		
		$_tunjuk_nama = $this->Penunjukan_model->read_informasi_penunjukan($user[0]->penunjukan_id);
		$department = $this->Department_model->read_informasi_department($user[0]->department_id);
		//$location = $this->Umb_model->read_info_location($department[0]->location_id);
		// perusahaan info
		$perusahaan = $this->Umb_model->read_info_perusahaan($user[0]->perusahaan_id);
		
		
		$p_method = '';
		/*$payment_method = $this->Umb_model->read_payment_method($payment[0]->payment_method);
		if(!is_null($payment_method)){
		  $p_method = $payment_method[0]->method_name;
		} else {
		  $p_method = '--';
		}*/
		//$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
		if(!is_null($perusahaan)){
			$nama_perusahaan = $perusahaan[0]->name;
			$alamat_1 = $perusahaan[0]->alamat_1;
			$alamat_2 = $perusahaan[0]->alamat_2;
			$kota = $perusahaan[0]->kota;
			$provinsi = $perusahaan[0]->provinsi;
			$kode_pos = $perusahaan[0]->kode_pos;
			$negara = $this->Umb_model->read_info_negara($perusahaan[0]->negara);
			if(!is_null($negara)){
				$nama_negara = $negara[0]->nama_negara;
			} else {
				$nama_negara = '--';
			}
			$c_info_email = $perusahaan[0]->email;
			$c_info_phone = $perusahaan[0]->nomor_kontak;
		} else {
			$nama_perusahaan = '--';
			$alamat_1 = '--';
			$alamat_2 = '--';
			$kota = '--';
			$provinsi = '--';
			$kode_pos = '--';
			$nama_negara = '--';
			$c_info_email = '--';
			$c_info_phone = '--';
		}
		
		// set default header data
		
		
		
		$c_info_alamat = $alamat_1.' '.$alamat_2.', '.$kota.' - '.$kode_pos.', '.$nama_negara;
		$email_phone_address = "".$this->lang->line('dashboard_email')." : $c_info_email | ".$this->lang->line('umb_phone')." : $c_info_phone \n".$this->lang->line('umb_alamat').": $c_info_alamat";
		$header_string = $email_phone_address;
		
		
		// set document information
		$pdf->SetCreator('HRASTRAL');
		$pdf->SetAuthor('HRASTRAL');
		//$pdf->SetTitle('Workable-Zone - slipgaji');
		//$pdf->SetSubject('TCPDF Tutorial');
		//$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
		//$pdf->SetHeaderData('../../../uploads/logo/payroll/'.$system[0]->logo_payroll, 40, $nama_perusahaan, $header_string);
		
		$pdf->setFooterData(array(0,64,0), array(0,64,128));
		
		// set header and footer fonts
		$pdf->setHeaderFont(Array('helvetica', '', 11.5));
		$pdf->setFooterFont(Array('helvetica', '', 9));
		
		// set default monospaced font
		$pdf->SetDefaultMonospacedFont('courier');
		
		// set margins
		$pdf->SetMargins(15, 27, 15);
		$pdf->SetHeaderMargin(5);
		$pdf->SetFooterMargin(10);
		
		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, 25);
		
		// set image scale factor
		$pdf->setImageScale(1.25);
		$pdf->SetAuthor($nama_perusahaan);
		$pdf->SetTitle($nama_perusahaan.' - '.$this->lang->line('umb_print_slipgaji'));
		$pdf->SetSubject($this->lang->line('umb_slipgaji'));
		$pdf->SetKeywords($this->lang->line('umb_slipgaji'));
		// set font
		$pdf->SetFont('helvetica', 'B', 10);
		
		// set header and footer fonts
	//	$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		
		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		
		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		
		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		
		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		
		// ---------------------------------------------------------
		
		// set default font subsetting mode
		$pdf->setFontSubsetting(true);
		
		// Set font
		// dejavusans is a UTF-8 Unicode font, if you only need to
		// print standard ASCII chars, you can use core fonts like
		// helvetica or times to reduce file size.
		$pdf->SetFont('dejavusans', '', 8, '', true);
		
		// Add a page
		// This method has several options, check the source code documentation for more information.
		$pdf->AddPage();
		
		// set text shadow effect
		$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));
		
		// -----------------------------------------------------------------------------
		$clogo = base_url().'uploads/logo/payroll/'.$system[0]->logo_payroll;
		$fname = $user[0]->first_name.' '.$user[0]->last_name;
		$created_at = $this->Umb_model->set_date_format($payment[0]->created_at);
		$tanggal_bergabung = $this->Umb_model->set_date_format($user[0]->tanggal_bergabung);
		$gaji_bulan = $this->Umb_model->set_date_format($payment[0]->gaji_bulan);
		// basic gaji
		$bs=0;
		if($payment[0]->gaji_pokok != '') {
			$bs = $payment[0]->gaji_pokok;
		} else {
			$bs = $payment[0]->upahh_harian;
		}
		//
		$tbl = '<div style="border:1px solid #ccc; padding:2px; border-bottom: 2px solid #000;"><table cellpadding="5" cellspacing="0" border="0">
		<tr>
		<td rowspan="5" valign="middle"><img src="'.$clogo.'" width="80" height="80" /></td>
		<td valign="top"><strong>'.$this->lang->line('umb_payroll_pdf_co_name').'</strong><br /><br /><br /> <strong>'.$this->lang->line('umb_payroll_pdf_krywn_code').'</strong> <br /> <strong>'.$this->lang->line('umb_payroll_pdf_krywn_name').'</strong> <br /> <strong>'.$this->lang->line('umb_payroll_pdf_alamat_krywn').'</strong></td>
		<td valign="top">'.$nama_perusahaan.' <br/> <br /><br />'.$user[0]->karyawan_id.' <br />'.$fname.' <br />'.$user[0]->alamat.'</td>
		
		<td valign="top"><strong>'.$this->lang->line('umb_payroll_pdf_pay_date').'</strong><br /><br /> <br /><strong>'.$this->lang->line('umb_payroll_pdf_dt_engage').'</strong> <br /><strong>'.$this->lang->line('umb_payroll_pdf_krywn_gaji_bulan').'</strong></td>
		<td valign="top">'.$created_at.' <br/> <br /><br />'.$tanggal_bergabung.' <br />'.$gaji_bulan.'</td>
		</tr>
		</table></div>
		<br /><br />';
		// tunjanagans
		$count_tunjanagans = $this->Karyawans_model->count_karyawan_tunjanagans_slipgaji($payment[0]->slipgaji_id);
		$tunjanagans = $this->Karyawans_model->set_tunjanagans_karyawan_slipgaji($payment[0]->slipgaji_id);
		// komissi
		$count_komissi = $this->Karyawans_model->count_karyawan_komissi_slipgaji($payment[0]->slipgaji_id);
		$komissi = $this->Karyawans_model->set_komissi_karyawan_slipgaji($payment[0]->slipgaji_id);
		// otherpayments
		$count_pembayarans_lainnya = $this->Karyawans_model->count_karyawan_pembayarans_lainnya_slipgaji($payment[0]->slipgaji_id);
		$pembayarans_lainnya = $this->Karyawans_model->set_karyawan_pembayarans_lainnya_slipgaji($payment[0]->slipgaji_id);
		// statutory_potongans
		$count_statutory_potongans = $this->Karyawans_model->count_karyawan_statutory_potongans_slipgaji($payment[0]->slipgaji_id);
		$statutory_potongans = $this->Karyawans_model->set_karyawan_statutory_potongans_slipgaji($payment[0]->slipgaji_id);
		// lembur
		$count_lembur = $this->Karyawans_model->count_karyawan_lembur_slipgaji($payment[0]->slipgaji_id);
		$lembur = $this->Karyawans_model->set_karyawan_lembur_slipgaji($payment[0]->slipgaji_id);
		// loan
		$count_pinjaman = $this->Karyawans_model->count_karyawan_potongans_slipgaji($payment[0]->slipgaji_id);
		$loan = $this->Karyawans_model->set_potongans_karyawan_slipgaji($payment[0]->slipgaji_id);
		$jumlah_statutory_potongan = 0; $jumlah_ptng_pinjaman = 0; $jumlah_tunjanagans = 0;
		$jumlah_komissi = 0; $jumlah_pembayarans_lainnya = 0; $jumlah_lembur = 0;
		$tbl .= '<table cellpadding="5" cellspacing="0" border="0">
		<tr style="height:17px;">
		<td style="font-family:Calibri;font-size:10px;color:#000000;font-weight:bold;text-decoration:underline;min-width:50px">
		<nobr>EARNINGS</nobr>
		</td>
		<td style="font-family:Calibri;font-size:10px;color:#000000;text-decoration:underline;min-width:50px">
		<nobr>&nbsp;</nobr>
		</td>
		<td style="font-family:Calibri;font-size:10px;color:#000000;text-decoration:underline;min-width:50px">
		<nobr>&nbsp;</nobr>
		</td>
		<td style="min-width:50px">
		<nobr>&nbsp;</nobr>
		</td>
		<td colspan="2" style="font-family:Calibri;font-size:10px;color:#000000;font-weight:bold;text-decoration:underline;min-width:50px">
		<nobr>potongans</nobr>
		</td>
		<td style="min-width:50px">
		<nobr>&nbsp;</nobr>
		</td>
		<td style="min-width:50px">
		<nobr>&nbsp;</nobr>
		</td>
		</tr>
		<tr style="height:17px;">
		<td colspan="2" style="font-family:Calibri;font-size:10px;color:#000000;font-weight:bold;min-width:50px">
		<nobr>'.$this->lang->line('umb_payroll_gross_gaji').'</nobr>
		</td>
		<td style="min-width:50px">
		<nobr>&nbsp;</nobr>
		</td>
		<td style="font-family:Calibri;text-align:right;font-size:10px;color:#000000;min-width:50px">
		<nobr>'.number_format($bs, 2, '.', ',').'</nobr>
		</td>
		<td colspan="2" style="font-family:Calibri;font-size:10px;color:#000000;font-weight:bold;min-width:50px">
		';
		if($count_pinjaman > 0):
			$tbl .= '<nobr>'.$this->lang->line('umb_karyawan_set_pinjaman_potongans').'</nobr>';
		endif;
		$tbl .= '</td>
		<td style="min-width:50px">
		<nobr>&nbsp;</nobr>
		</td>
		<td style="font-family:Calibri;text-align:right;font-size:10px;color:#000000;min-width:50px">';
		if($count_pinjaman > 0):
			foreach($loan->result() as $r_pinjaman) {
				$jumlah_ptng_pinjaman += $r_pinjaman->pinjaman_jumlah;
			}	
			$tbl .= '<nobr>('.number_format($jumlah_ptng_pinjaman, 2, '.', ',').')</nobr>';
		else:
			$jumlah_ptng_pinjaman = 0;
		endif;
		$tbl .= '
		</td>
		</tr>
		<tr style="height:17px;">
		<td colspan="2" style="font-family:Calibri;font-size:10px;color:#000000;font-weight:bold;min-width:50px">';
		if($count_tunjanagans > 0):
			$tbl .= '<nobr>'.$this->lang->line('umb_karyawan_set_tunjanagans').'</nobr>';
		endif;
		$tbl .= '	
		</td>
		<td style="min-width:50px">
		<nobr>&nbsp;</nobr>
		</td>
		<td style="font-family:Calibri;text-align:right;font-size:10px;color:#000000;min-width:50px">
		';
		if($count_tunjanagans > 0):
			foreach($tunjanagans->result() as $r_tunjanagans) {
				$jumlah_tunjanagans += $r_tunjanagans->jumlah_tunjanagan;
			}	
			$tbl .= '<nobr>('.number_format($jumlah_tunjanagans, 2, '.', ',').')</nobr>';
		else:
			$jumlah_tunjanagans = 0;
		endif;
		$tbl .= '</td>
		<td colspan="2" style="font-family:Calibri;font-size:10px;color:#000000;font-weight:bold;min-width:50px">
		';
		if($count_statutory_potongans > 0):
			$tbl .= '<nobr>'.$this->lang->line('umb_karyawan_set_statutory_potongans').'</nobr>';
		endif;
		$tbl .= '</td>
		<td style="min-width:50px">
		<nobr>&nbsp;</nobr>
		</td>
		<td style="font-family:Calibri;text-align:right;font-size:10px;color:#000000;min-width:50px">';
		if($count_statutory_potongans > 0):
			foreach($statutory_potongans->result() as $r_statutory_potongans) {
									//$sta_gaji = $jumlah_tunjanagans + $bs;
				$st_jumlah = $r_statutory_potongans->jumlah_potongan;
				$jumlah_statutory_potongan += $r_statutory_potongans->jumlah_potongan;
			}	
			$tbl .= '<nobr>('.number_format($jumlah_statutory_potongan, 2, '.', ',').')</nobr>';
		else:
			$jumlah_statutory_potongan = 0;
		endif;
		$tbl .= '
		</td>
		</tr>
		<tr style="height:17px;">
		<td colspan="2" style="font-family:Calibri;font-size:10px;color:#000000;font-weight:bold;min-width:50px">';
		if($count_komissi > 0):
			$tbl .= '<nobr>'.$this->lang->line('umb_hr_komissi').'</nobr>';
		endif;
		$tbl .= '</td>
		<td style="min-width:50px">
		<nobr>&nbsp;</nobr>
		</td>
		<td style="font-family:Calibri;text-align:right;font-size:10px;color:#000000;min-width:50px">';
		if($count_komissi > 0):
			foreach($komissi->result() as $r_komissi) {
				$jumlah_komissi += $r_komissi->jumlah_komisi;
			}	
			$tbl .= '<nobr>('.number_format($jumlah_komissi, 2, '.', ',').')</nobr>';
		else:
			$jumlah_komissi = 0;
		endif;
		$tbl .= '</td>
		<td colspan="2" style="font-family:Calibri;font-size:10px;color:#000000;font-weight:bold;min-width:50px">
		';
		$tbl .= '</td>
		<td style="min-width:50px">
		<nobr>&nbsp;</nobr>
		</td>
		<td style="font-family:Calibri;text-align:right;font-size:10px;color:#000000;min-width:50px">';								
		$tbl .= '
		</td>
		</tr>
		<tr style="height:17px;">
		<td colspan="2" style="font-family:Calibri;font-size:10px;color:#000000;font-weight:bold;min-width:50px">';
		if($count_pembayarans_lainnya > 0):
			$tbl .= '<nobr>'.$this->lang->line('umb_karyawan_set_pembayaran_lainnya').'</nobr>';
		endif;
		$tbl .= '</td>
		<td style="min-width:50px">
		<nobr>&nbsp;</nobr>
		</td>
		<td style="font-family:Calibri;text-align:right;font-size:10px;color:#000000;min-width:50px">
		';
		if($count_pembayarans_lainnya > 0):
			foreach($pembayarans_lainnya->result() as $r_pembayarans_lainnya) {
				$jumlah_pembayarans_lainnya += $r_pembayarans_lainnya->jumlah_pembayarans;
			}	
			$tbl .= '<nobr>('.number_format($jumlah_pembayarans_lainnya, 2, '.', ',').')</nobr>';
		else:
			$jumlah_pembayarans_lainnya = 0;
		endif;
		$tbl .= '</td>
		<td colspan="2" style="font-family:Calibri;font-size:10px;color:#000000;font-weight:bold;min-width:50px">
		';
		$tbl .= '</td>
		<td style="min-width:50px">
		<nobr>&nbsp;</nobr>
		</td>
		<td style="font-family:Calibri;text-align:right;font-size:10px;color:#000000;min-width:50px">';								
		$tbl .= '
		</td>
		</tr>
		<tr style="height:17px;">
		<td colspan="2" style="font-family:Calibri;font-size:10px;color:#000000;font-weight:bold;min-width:50px">';
		if($count_lembur > 0):
			$tbl .= '<nobr>'.$this->lang->line('dashboard_lembur').'</nobr>';
		endif;
		$tbl .= '</td>
		<td style="min-width:50px">
		<nobr>&nbsp;</nobr>
		</td>
		<td style="font-family:Calibri;text-align:right;font-size:10px;color:#000000;min-width:50px">
		';
		if($count_lembur > 0):
			foreach($lembur->result() as $r_lembur) {
				$total_lembur = $r_lembur->jam_lembur * $r_lembur->nilai_lembur;
				$jumlah_lembur += $total_lembur;
			}	
			$tbl .= '<nobr>('.number_format($jumlah_lembur, 2, '.', ',').')</nobr>';
		else:
			$jumlah_lembur = 0;
		endif;
		$tbl .= '</td>
		<td colspan="2" style="font-family:Calibri;font-size:10px;color:#000000;font-weight:bold;min-width:50px">
		';
		$tbl .= '</td>
		<td style="min-width:50px">
		<nobr>&nbsp;</nobr>
		</td>
		<td style="font-family:Calibri;text-align:right;font-size:10px;color:#000000;min-width:50px">';								
		$tbl .= '
		</td>
		</tr>
		<tr style="height:17px;">
		<td colspan="2" style="font-family:Calibri;font-size:10px;color:#000000;min-width:50px">';
		$tbl .= '	
		</td>
		<td style="min-width:50px">
		<nobr>&nbsp;</nobr>
		</td>
		<td style="font-family:Calibri;text-align:right;font-size:10px;color:#000000;min-width:50px">';								
		$i=1;								
		$total_earning = $bs + $jumlah_tunjanagans + $jumlah_lembur + $jumlah_komissi + $jumlah_pembayarans_lainnya;
		$total_potongan = $jumlah_ptng_pinjaman + $jumlah_statutory_potongan;
		$total_gaji_bersih = $total_earning - $total_potongan;
		$tbl .= '</td>
		<td colspan="2" style="font-family:Calibri;font-size:10px;color:#000000;font-weight:bold;min-width:50px">
		</td>
		<td style="min-width:50px">
		<nobr>&nbsp;</nobr>
		</td>
		<td style="min-width:50px">
		<nobr>&nbsp;</nobr>
		</td>
		</tr>
		<tr style="height:17px;">
		<td style="min-width:50px">
		<nobr>&nbsp;</nobr>
		</td>
		<td style="min-width:50px">
		<nobr>&nbsp;</nobr>
		</td>
		<td style="min-width:50px">
		<nobr>&nbsp;</nobr>
		</td>
		<td style="min-width:50px">
		<nobr>&nbsp;</nobr>
		</td>
		<td style="min-width:50px">
		<nobr>&nbsp;</nobr>
		</td>
		<td style="min-width:50px">
		<nobr>&nbsp;</nobr>
		</td>
		<td style="min-width:50px">
		<nobr>&nbsp;</nobr>
		</td>
		<td style="min-width:50px">
		<nobr>&nbsp;</nobr>
		</td>
		</tr>
		<tr style="height:18px;">
		<td style="font-family:Calibri;font-size:10px;color:#000000;border-bottom:1px solid #000000;min-width:50px">
		<nobr>&nbsp;</nobr>
		</td>
		<td style="font-family:Calibri;font-size:10px;color:#000000;border-bottom:1px solid #000000;min-width:50px">
		<nobr>&nbsp;</nobr>
		</td>
		<td style="font-family:Calibri;font-size:10px;color:#000000;border-bottom:1px solid #000000;min-width:50px">
		<nobr>&nbsp;</nobr>
		</td>
		<td style="font-family:Calibri;font-size:10px;color:#000000;border-bottom:1px solid #000000;min-width:50px">
		<nobr>&nbsp;</nobr>
		</td>
		<td style="font-family:Calibri;font-size:10px;color:#000000;border-bottom:1px solid #000000;min-width:50px">
		<nobr>&nbsp;</nobr>
		</td>
		<td style="font-family:Calibri;font-size:10px;color:#000000;border-bottom:1px solid #000000;min-width:50px">
		<nobr>&nbsp;</nobr>
		</td>
		<td style="font-family:Calibri;font-size:10px;color:#000000;border-bottom:1px solid #000000;min-width:50px">
		<nobr>&nbsp;</nobr>
		</td>
		<td style="font-family:Calibri;font-size:10px;color:#000000;border-bottom:1px solid #000000;min-width:50px">
		<nobr>&nbsp;</nobr>
		</td>
		</tr>
		
		<tr style="height:18px;">
		<td colspan="2" style="font-family:Calibri;font-size:10px;color:#000000;font-weight:bold;border-top:1px solid #000000;border-bottom:1px solid #000000;min-width:50px">
		<nobr>TOTAL EARNING</nobr>
		</td>
		<td style="font-family:Calibri;font-size:10px;color:#000000;font-weight:bold;border-top:1px solid #000000;border-bottom:1px solid #000000;min-width:50px">
		<nobr>&nbsp;</nobr>
		</td>
		<td style="text-align:right;font-family:Calibri;font-size:10px;color:#000000;font-weight:bold;border-top:1px solid #000000;border-bottom:1px solid #000000;min-width:50px">
		<nobr>'.number_format($total_earning, 2, '.', ',').'</nobr>
		</td>
		<td colspan="2" style="font-family:Calibri;font-size:10px;color:#000000;font-weight:bold;border-top:1px solid #000000;border-bottom:1px solid #000000;min-width:50px">
		<nobr>TOTAL potongans</nobr>
		</td>
		<td style="font-family:Calibri;font-size:10px;border-top:1px solid #000000;border-bottom:1px solid #000000;min-width:50px">
		<nobr>&nbsp;</nobr>
		</td>
		<td style="text-align:right;font-family:Calibri;font-size:10px;border-top:1px solid #000000;border-bottom:1px solid #000000;min-width:50px">
		<nobr>'.number_format($total_potongan, 2, '.', ',').'</nobr>
		</td>
		</tr>
		<tr style="height:17px;">
		<td style="min-width:50px">
		<nobr>&nbsp;</nobr>
		</td>
		<td style="min-width:50px">
		<nobr>&nbsp;</nobr>
		</td>
		<td style="min-width:50px">
		<nobr>&nbsp;</nobr>
		</td>
		<td style="min-width:50px">
		<nobr>&nbsp;</nobr>
		</td>
		<td style="min-width:50px">
		<nobr>&nbsp;</nobr>
		</td>
		<td style="min-width:50px">
		<nobr>&nbsp;</nobr>
		</td>
		<td style="min-width:50px">
		<nobr>&nbsp;</nobr>
		</td>
		<td style="min-width:50px">
		<nobr>&nbsp;</nobr>
		</td>
		</tr>
		<tr style="height:22px;">
		<td style="font-family:Arial;font-size:12px;font-weight:bold;min-width:50px">
		<nobr>&nbsp;</nobr>
		</td>
		<td style="font-family:Arial;font-size:12px;font-weight:bold;min-width:50px">
		<nobr>&nbsp;</nobr>
		</td>
		<td style="font-family:Arial;font-size:12px;font-weight:bold;min-width:50px">
		<nobr>&nbsp;</nobr>
		</td>
		<td style="font-family:Arial;font-size:12px;font-weight:bold;min-width:50px">
		<nobr>&nbsp;</nobr>
		</td>
		<td colspan="3" style="font-family:Arial;font-size:12px;font-weight:bold;border-bottom:1px solid #000000;border-top:1px solid #000000;min-width:50px">
		<nobr>TOTAL NETT gaji</nobr>
		</td>
		<td style="text-align:right;font-family:Arial;font-size:12px;font-weight:bold;border-bottom:1px solid #000000;border-top:1px solid #000000;min-width:50px">
		<nobr>'.number_format($total_gaji_bersih, 2, '.', ',').'</nobr>
		</td>
		</tr>
		<tr style="height:17px;">
		<td style="min-width:50px">
		<nobr>&nbsp;</nobr>
		</td>
		<td style="min-width:50px">
		<nobr>&nbsp;</nobr>
		</td>
		<td style="min-width:50px">
		<nobr>&nbsp;</nobr>
		</td>
		<td style="min-width:50px">
		<nobr>&nbsp;</nobr>
		</td>
		<td style="min-width:50px">
		<nobr>&nbsp;</nobr>
		</td>
		<td style="min-width:50px">
		<nobr>&nbsp;</nobr>
		</td>
		<td style="min-width:50px">
		<nobr>&nbsp;</nobr>
		</td>
		<td style="min-width:50px">
		<nobr>&nbsp;</nobr>
		</td>
		</tr>
		</table>';
		$pdf->writeHTML($tbl, true, false, false, false, '');		
		// Close and output PDF document
		// This method has several options, check the source code documentation for more information.
		$fname = strtolower($fname);
		$pay_month = strtolower(date("F Y", strtotime($payment[0]->gaji_bulan)));
		//Close and output PDF document
		ob_start();
		$pdf->Output('slipgaji_'.$fname.'_'.$pay_month.'.pdf', 'I');
		ob_end_flush();
		//$pdf->Output('slipgaji_'.$fname.'_'.$pay_month.'.pdf', 'D');
		
	}
	
	
	public function get_karyawans() {

		$data['title'] = $this->Umb_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'perusahaan_id' => $id
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/payroll/get_karyawans", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}  
	
	// make payment info by id
	public function view_melakukan_pembayaran()
	{
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('pay_id');
       // $data['all_negaraa'] = $this->Umb_model->get_negaraa();
		$result = $this->Payroll_model->read_informasi_melakukan_pembayaran($id);
		// get addd by > template
		$user = $this->Umb_model->read_user_info($result[0]->karyawan_id);
		// get designation
		$penunjukan = $this->Penunjukan_model->read_informasi_penunjukan($user[0]->penunjukan_id);
		if(!is_null($penunjukan)){
			$nama_penunjukan = $penunjukan[0]->nama_penunjukan;
		} else {
			$nama_penunjukan = '--';	
		}
		// department
		$department = $this->Department_model->read_informasi_department($user[0]->department_id);
		if(!is_null($department)){
			$nama_department = $department[0]->nama_department;
		} else {
			$nama_department = '--';	
		}
		
		$data = array(
			'first_name' => $user[0]->first_name,
			'last_name' => $user[0]->last_name,
			'karyawan_id' => $user[0]->karyawan_id,
			'nama_department' => $nama_department,
			'nama_penunjukan' => $nama_penunjukan,
			'tanggal_bergabung' => $user[0]->tanggal_bergabung,
			'profile_picture' => $user[0]->profile_picture,
			'jenis_kelamin' => $user[0]->jenis_kelamin,
			'monthly_grade_id' => $user[0]->monthly_grade_id,
			'hourly_grade_id' => $user[0]->hourly_grade_id,
			'gaji_pokok' => $result[0]->gaji_pokok,
			'payment_date' => $result[0]->payment_date,
			'payment_method' => $result[0]->payment_method,
			'nilai_lembur' => $result[0]->nilai_lembur,
			'nilai_perjam' => $result[0]->nilai_perjam,
			'total_jam_kerja' => $result[0]->total_jam_kerja,
			'is_payment' => $result[0]->is_payment,
			'is_potong_advance_gaji' => $result[0]->is_potong_advance_gaji,
			'jumlah_advance_gaji' => $result[0]->jumlah_advance_gaji,
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
			'jumlah_pembayaran' => $result[0]->jumlah_pembayaran,
			'comments' => $result[0]->comments,
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/payroll/dialog_slipgaji', $data);
		} else {
			redirect('admin/');
		}
	}
	public function delete_slipgaji() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$result = $this->Payroll_model->delete_record($id);
		if(isset($id)) {
			$this->Payroll_model->delete_slipgaji_tunjanagans_items($id);
			$this->Payroll_model->delete_slipgaji_komissi_items($id);
			$this->Payroll_model->delete_slipgaji_pembayaran_lainnya_items($id);
			$this->Payroll_model->delete_slipgaji_statutory_potongans_items($id);
			$this->Payroll_model->delete_slipgaji_lembur_items($id);
			$this->Payroll_model->delete_slipgaji_pinjaman_items($id);
			$Return['result'] = $this->lang->line('umb_hr_slipgaji_dihapus');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
	}
}
