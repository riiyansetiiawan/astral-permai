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
		$this->load->model("Timesheet_model");
		$this->load->model("Permintaan_lembur_model");
		$this->load->model("Perusahaan_model");
		$this->load->model("Keuangan_model");
		$this->load->helper('string');
	}
	
	
	public function output($Return=array()){
		
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		
		exit(json_encode($Return));
	}
	
	public function templates() {

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
	
	public function generate_slipgaji() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('left_payroll').' | '.$this->Umb_model->site_title();
		$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		$data['all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$data['breadcrumbs'] = $this->lang->line('left_payroll');
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
	
	public function history_pembayaran() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('umb_history_slipgaji');
		$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		$data['breadcrumbs'] = $this->lang->line('umb_history_slipgaji');
		$data['path_url'] = 'history_pembayaran';
		$data['get_all_perusahaans'] = $this->Umb_model->get_perusahaans();
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

	public function advance_gaji() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('umb_advance_gaji').' | '.$this->Umb_model->site_title();
		$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		$data['all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$data['breadcrumbs'] = $this->lang->line('umb_advance_gaji');
		$data['path_url'] = 'advance_gaji';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('467',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/payroll/advance_gaji", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
		} else {
			redirect('admin/dashboard');
		}
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
		$data['path_url'] = 'laporan_advance_gaji';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('468',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/payroll/laporan_advance_gaji", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
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
		$role_resources_ids = $this->Umb_model->user_role_resource();
		$user_info = $this->Umb_model->read_user_info($session['user_id']);
		if($user_info[0]->user_role_id==1 || in_array('314',$role_resources_ids)){
			if($this->input->get("karyawan_id")==0 && $this->input->get("perusahaan_id")==0) {
				$slipgaji = $this->Karyawans_model->get_karyawans_slipgaji();
			} else if($this->input->get("karyawan_id")==0 && $this->input->get("perusahaan_id")!=0) {
				$slipgaji = $this->Payroll_model->get_template_prsh($this->input->get("perusahaan_id"),0);
			} else if($this->input->get("karyawan_id")!=0 && $this->input->get("perusahaan_id")!=0) {
				$slipgaji = $this->Payroll_model->get_karyawan_template_prsh($this->input->get("perusahaan_id"),$this->input->get("karyawan_id"));
			} else {
				$slipgaji = $this->Karyawans_model->get_karyawans_slipgaji();
			}
		} else {
			$slipgaji = $this->Payroll_model->get_karyawan_template_prsh($user_info[0]->perusahaan_id,$session['user_id']);
		}
		$system = $this->Umb_model->read_setting_info(1);		
		$data = array();

		foreach($slipgaji->result() as $r) {
			
			$nama_krywn = $r->first_name.' '.$r->last_name;
			$full_name = '<a target="_blank" class="text-primary" href="'.site_url().'admin/karyawans/detail/'.$r->user_id.'">'.$nama_krywn.'</a>';
			
			$pay_date = $this->input->get('month_year');

			$lembur_count = $this->Permintaan_lembur_model->get_count_permintaan_lembur($r->user_id,$this->input->get('month_year'));
			$re_hrs_old_int1 = 0;
			$re_hrs_old_seconds =0;
			$re_pcount = 0;
			foreach ($lembur_count as $lembur_hr){
				$request_clock_in =  new DateTime($lembur_hr->request_clock_in);
				$request_clock_out =  new DateTime($lembur_hr->request_clock_out);
				$re_interval_late = $request_clock_in->diff($request_clock_out);
				$re_hours_r  = $re_interval_late->format('%h');
				$re_minutes_r = $re_interval_late->format('%i');			
				$re_total_time = $re_hours_r .":".$re_minutes_r.":".'00';
				
				$re_str_time = $re_total_time;
				
				$re_str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $re_str_time);
				
				sscanf($re_str_time, "%d:%d:%d", $hours, $minutes, $seconds);
				
				$re_hrs_old_seconds = $hours * 3600 + $minutes * 60 + $seconds;
				
				$re_hrs_old_int1 += $re_hrs_old_seconds;
				
				$re_pcount = gmdate("H", $re_hrs_old_int1);			
			}	
			$result = $this->Payroll_model->total_jam_bekerja($r->user_id,$pay_date);
			$hrs_old_int1 = 0;
			$pcount = 0;
			$Tistrahat = 0;
			$total_time_rs = 0;
			$hrs_old_int_res1 = 0;
			foreach ($result->result() as $jam_kerja){

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
				
				$pcount = gmdate("H", $hrs_old_int1);			
			}
			$pcount = $pcount + $re_pcount;
			$perusahaan = $this->Umb_model->read_info_perusahaan($r->perusahaan_id);
			if(!is_null($perusahaan)){
				$prshn_nama = $perusahaan[0]->name;
			} else {
				$prshn_nama = '--';	
			}
			
			if($r->type_upahh==1){
				$type_upahh = $this->lang->line('umb_payroll_gaji_pokok');
				if($system[0]->is_half_monthly==1){
					$gaji_pokok = $r->gaji_pokok / 2;
				} else {
					$gaji_pokok = $r->gaji_pokok;
				}
				$p_class = 'emo_monthly_pay';
				$view_p_class = 'modal_payroll_template';
			} else if($r->type_upahh==2){
				$type_upahh = $this->lang->line('umb_karyawan_upahh_harian');
				if($pcount > 0){
					$gaji_pokok = $pcount * $r->gaji_pokok;
				} else {
					$gaji_pokok = $pcount;
				}
				$p_class = 'emo_hourly_pay';
				$view_p_class = 'modal_template_upahhperjam';
			} else {
				$type_upahh = $this->lang->line('umb_payroll_gaji_pokok');
				if($system[0]->is_half_monthly==1){
					$gaji_pokok = $r->gaji_pokok / 2;
				} else {
					$gaji_pokok = $r->gaji_pokok;
				}
				$p_class = 'emo_monthly_pay';
				$view_p_class = 'modal_payroll_template';
				
			}				

			$gaji_tunjanagans = $this->Karyawans_model->read_gaji_tunjanagans($r->user_id);
			$count_tunjanagans = $this->Karyawans_model->count_karyawan_tunjanagans($r->user_id);
			$jumlah_tunjanagan = 0;
			if($count_tunjanagans > 0) {
				foreach($gaji_tunjanagans as $sl_tunjanagans){
					if($system[0]->is_half_monthly==1){
						if($system[0]->potong_setengah_bulan==2){
							$ejumlah_tunjanagan = $sl_tunjanagans->jumlah_tunjanagan/2;
						} else {
							$ejumlah_tunjanagan = $sl_tunjanagans->jumlah_tunjanagan;
						}
						$jumlah_tunjanagan += $ejumlah_tunjanagan;
					} else {
						//$ejumlah_tunjanagan = $sl_tunjanagans->jumlah_tunjanagan;
						if($sl_tunjanagans->is_tunjanagan_kena_pajak == 1) {
							if($sl_tunjanagans->jumlah_option == 0) {
								$ijumlah_tunjanagan = $sl_tunjanagans->jumlah_tunjanagan;
							} else {
								$ijumlah_tunjanagan = $gaji_pokok / 100 * $sl_tunjanagans->jumlah_tunjanagan;
							}
							$jumlah_tunjanagan -= $ijumlah_tunjanagan; 
						} else if($sl_tunjanagans->is_tunjanagan_kena_pajak == 2) {
							if($sl_tunjanagans->jumlah_option == 0) {
								$ijumlah_tunjanagan = $sl_tunjanagans->jumlah_tunjanagan / 2;
							} else {
								$ijumlah_tunjanagan = ($gaji_pokok / 100) / 2 * $sl_tunjanagans->jumlah_tunjanagan;
							}
							$jumlah_tunjanagan -= $ijumlah_tunjanagan; 
						} else {
							if($sl_tunjanagans->jumlah_option == 0) {
								$ijumlah_tunjanagan = $sl_tunjanagans->jumlah_tunjanagan;
							} else {
								$ijumlah_tunjanagan = $gaji_pokok / 100 * $sl_tunjanagans->jumlah_tunjanagan;
							}
							$jumlah_tunjanagan += $ijumlah_tunjanagan;
						}
					}
					
				}
			} else {
				$jumlah_tunjanagan = 0;
			}
			
			$gaji_pinjaman_potongan = $this->Karyawans_model->read_gaji_pinjaman_potongans($r->user_id);
			$count_pinjaman_potongan = $this->Karyawans_model->count_karyawan_potongans($r->user_id);
			$jumlah_ptng_pinjaman = 0;
			if($count_pinjaman_potongan > 0) {
				foreach($gaji_pinjaman_potongan as $sl_gaji_pinjaman_potongan){
					if($system[0]->is_half_monthly==1){
						if($system[0]->potong_setengah_bulan==2){
							$er_pinjaman = $sl_gaji_pinjaman_potongan->pinjaman_jumlah_potongan/2;
						} else {
							$er_pinjaman = $sl_gaji_pinjaman_potongan->pinjaman_jumlah_potongan;
						}
					} else {
						$er_pinjaman = $sl_gaji_pinjaman_potongan->pinjaman_jumlah_potongan;
					}
					$jumlah_ptng_pinjaman += $er_pinjaman;
				}
			} else {
				$jumlah_ptng_pinjaman = 0;
			}
			
			$count_komissi = $this->Karyawans_model->count_karyawan_komissi($r->user_id);
			$komissi = $this->Karyawans_model->set_komissi_karyawan($r->user_id);
			$jumlah_komissi = 0;
			if($count_komissi > 0) {
				foreach($komissi->result() as $sl_gaji_komissi){
					if($system[0]->is_half_monthly==1){
						if($system[0]->potong_setengah_bulan==2){
							$ejumlah_komissi = $sl_gaji_komissi->jumlah_komisi/2;
						} else {
							$ejumlah_komissi = $sl_gaji_komissi->jumlah_komisi;
						}
						$jumlah_komissi += $ejumlah_komissi;
					} else {
						// $ejumlah_komissi = $sl_gaji_komissi->jumlah_komisi;
						if($sl_gaji_komissi->is_komisi_kena_pajak == 1) {
							if($sl_gaji_komissi->jumlah_option == 0) {
								$ejumlah_komissi = $sl_gaji_komissi->jumlah_komisi;
							} else {
								$ejumlah_komissi = $gaji_pokok / 100 * $sl_gaji_komissi->jumlah_komisi;
							}
							$jumlah_komissi -= $ejumlah_komissi; 
						} else if($sl_gaji_komissi->is_komisi_kena_pajak == 2) {
							if($sl_gaji_komissi->jumlah_option == 0) {
								$ejumlah_komissi = $sl_gaji_komissi->jumlah_komisi / 2;
							} else {
								$ejumlah_komissi = ($gaji_pokok / 100) / 2 * $sl_gaji_komissi->jumlah_komisi;
							}
							$jumlah_komissi -= $ejumlah_komissi; 
						} else {
							if($sl_gaji_komissi->jumlah_option == 0) {
								$ejumlah_komissi = $sl_gaji_komissi->jumlah_komisi;
							} else {
								$ejumlah_komissi = $gaji_pokok / 100 * $sl_gaji_komissi->jumlah_komisi;
							}
							$jumlah_komissi += $ejumlah_komissi;
						}
					}
					
				}
			} else {
				$jumlah_komissi = 0;
			}
			$count_pembayarans_lainnya = $this->Karyawans_model->count_karyawan_pembayarans_lainnya($r->user_id);
			$pembayarans_lainnya = $this->Karyawans_model->set_karyawan_pembayarans_lainnya($r->user_id);
			$jumlah_pembayarans_lainnya = 0;
			if($count_pembayarans_lainnya > 0) {
				foreach($pembayarans_lainnya->result() as $sl_pembayarans_lainnya) {
					if($system[0]->is_half_monthly==1){
						if($system[0]->potong_setengah_bulan==2){
							$ejumlah_pembayarans = $sl_pembayarans_lainnya->jumlah_pembayarans/2;
						} else {
							$ejumlah_pembayarans = $sl_pembayarans_lainnya->jumlah_pembayarans;
						}
						$jumlah_pembayarans_lainnya += $ejumlah_pembayarans;
					} else {
						// $ejumlah_pembayarans = $sl_pembayarans_lainnya->jumlah_pembayarans;
						if($sl_pembayarans_lainnya->ia_pembayaranlainnya_kena_pajak == 1) {
							if($sl_pembayarans_lainnya->jumlah_option == 0) {
								$ejumlah_pembayarans = $sl_pembayarans_lainnya->jumlah_pembayarans;
							} else {
								$ejumlah_pembayarans = $gaji_pokok / 100 * $sl_pembayarans_lainnya->jumlah_pembayarans;
							}
							$jumlah_pembayarans_lainnya -= $ejumlah_pembayarans; 
						} else if($sl_pembayarans_lainnya->ia_pembayaranlainnya_kena_pajak == 2) {
							if($sl_pembayarans_lainnya->jumlah_option == 0) {
								$ejumlah_pembayarans = $sl_pembayarans_lainnya->jumlah_pembayarans / 2;
							} else {
								$ejumlah_pembayarans = ($gaji_pokok / 100) / 2 * $sl_pembayarans_lainnya->jumlah_pembayarans;
							}
							$jumlah_pembayarans_lainnya -= $ejumlah_pembayarans; 
						} else {
							if($sl_pembayarans_lainnya->jumlah_option == 0) {
								$ejumlah_pembayarans = $sl_pembayarans_lainnya->jumlah_pembayarans;
							} else {
								$ejumlah_pembayarans = $gaji_pokok / 100 * $sl_pembayarans_lainnya->jumlah_pembayarans;
							}
							$jumlah_pembayarans_lainnya += $ejumlah_pembayarans;
						}
					}
					
				}
			} else {
				$jumlah_pembayarans_lainnya = 0;
			}

			$count_statutory_potongans = $this->Karyawans_model->count_karyawan_statutory_potongans($r->user_id);
			$statutory_potongans = $this->Karyawans_model->set_karyawan_statutory_potongans($r->user_id);
			$jumlah_statutory_potongans = 0;
			if($count_statutory_potongans > 0) {
				foreach($statutory_potongans->result() as $sl_gaji_statutory_potongans){
					if($system[0]->is_half_monthly==1){
						if($system[0]->potong_setengah_bulan==2){
							$single_sd = $sl_gaji_statutory_potongans->jumlah_potongan/2;
						} else {
							$single_sd = $sl_gaji_statutory_potongans->jumlah_potongan;
						}
						$jumlah_statutory_potongans += $single_sd;
					} else {
						//$single_sd = $sl_gaji_statutory_potongans->jumlah_potongan;
						if($sl_gaji_statutory_potongans->statutory_options == 0) {
							$single_sd = $sl_gaji_statutory_potongans->jumlah_potongan;
						} else {
							$single_sd = $gaji_pokok / 100 * $sl_gaji_statutory_potongans->jumlah_potongan;
						}
						$jumlah_statutory_potongans += $single_sd;
					}
				}
			} else {
				$jumlah_statutory_potongans = 0;
			}				
			
			$gaji_lembur = $this->Karyawans_model->read_gaji_lembur($r->user_id);
			$count_lembur = $this->Karyawans_model->count_karyawan_lembur($r->user_id);
			$jumlah_lembur = 0;
			if($count_lembur > 0) {
				foreach($gaji_lembur as $sl_lembur){
					if($system[0]->is_half_monthly==1){
						if($system[0]->potong_setengah_bulan==2){
							$ejam_lembur = $sl_lembur->jam_lembur/2;
							$enilai_lembur = $sl_lembur->nilai_lembur/2;
						} else {
							$ejam_lembur = $sl_lembur->jam_lembur;
							$enilai_lembur = $sl_lembur->nilai_lembur;
						}
					} else {
						$ejam_lembur = $sl_lembur->jam_lembur;
						$enilai_lembur = $sl_lembur->nilai_lembur;
					}
					$total_lembur = $ejam_lembur * $enilai_lembur;
					//$total_lembur = $sl_lembur->jam_lembur * $sl_lembur->nilai_lembur;
					$jumlah_lembur += $total_lembur;
				}
			} else {
				$jumlah_lembur = 0;
			}
			
			if($system[0]->enable_asuransi != 0){
				$jml_asuransi = $gaji_pokok + $jumlah_tunjanagan;
				$enable_asuransi = $jml_asuransi / 100 * $system[0]->enable_asuransi;
				$asuransi = $enable_asuransi;
			} else {
				$asuransi = 0;
			}
			$total_earning = $gaji_pokok + $jumlah_tunjanagan + $jumlah_lembur + $jumlah_komissi + $jumlah_pembayarans_lainnya + $asuransi;
			$total_potongan = $jumlah_ptng_pinjaman + $jumlah_statutory_potongans;
			$total_gaji_bersih = $total_earning - $total_potongan;
			$gaji_bersih = $total_gaji_bersih;
			$advance_jumlah = 0;
			$advance_gaji = $this->Payroll_model->advance_gaji_melalui_karyawan_id($r->user_id);
			$krywn_value = $this->Payroll_model->get_bayar_gaji_melalui_karyawan_id($r->user_id);
			
			if(!is_null($advance_gaji)){
				$angsuran_bulanan = $advance_gaji[0]->angsuran_bulanan;
				$advance_jumlah = $advance_gaji[0]->advance_jumlah;
				$total_yang_dibayarkan = $advance_gaji[0]->total_yang_dibayarkan;
				$em_advance_jumlah = $advance_gaji[0]->advance_jumlah;
				$em_total_yang_dibayarkan = $advance_gaji[0]->total_yang_dibayarkan;
				
				if($em_advance_jumlah > $em_total_yang_dibayarkan){
					if($angsuran_bulanan=='' || $angsuran_bulanan==0) {
						
						$ntotal_yang_dibayarkan = $krywn_value[0]->total_yang_dibayarkan;
						$nadvance = $krywn_value[0]->advance_jumlah;
						$i_gaji_bersih = $nadvance - $ntotal_yang_dibayarkan;
						//$pay_jumlah = $gaji_bersih - $i_gaji_bersih;
						$advance_jumlah = $i_gaji_bersih;
					} else {
						$re_jumlah = $em_advance_jumlah - $em_total_yang_dibayarkan;
						if($angsuran_bulanan > $re_jumlah){
							$advance_jumlah = $re_jumlah;
							//$total_gaji_bersih = $gaji_bersih - $re_jumlah;
							$pay_jumlah = $gaji_bersih - $re_jumlah;
						} else {
							$advance_jumlah = $angsuran_bulanan;
							//$total_gaji_bersih = $gaji_bersih - $angsuran_bulanan;
							$pay_jumlah = $gaji_bersih - $angsuran_bulanan;
						}
					}
					
				} else {
					$i_gaji_bersih = $gaji_bersih - 0;
					$pay_jumlah = $gaji_bersih - 0;
					$advance_jumlah = 0;
				}
			} else {
				$pay_jumlah = $gaji_bersih - 0;
				$i_gaji_bersih = $gaji_bersih - 0;
				$advance_jumlah = 0;
			}
			$total_gaji_bersih = $total_gaji_bersih - $advance_jumlah;
			//	$gaji_bersih = $fgaji_bersih - $jumlah_ptng_pinjaman;
			//$gaji_pokok_cal = $gaji_pokok * $current_rate; 
			//$allinfo = $gaji_pokok  .' - '.  $jumlah_tunjanagan  .' - '.  $all_pembayaran_lainnya  .' - '.  $jumlah_ptng_pinjaman  .' - '.  $jumlah_lembur  .' - '.  $statutory_potongans; // for testing purpose
			if($system[0]->is_half_monthly==1){
				$check_pembayaran = $this->Payroll_model->read_melakukan_pembayaran_slipgaji_half_month_check($r->user_id,$p_date);
				$pembayaran_terakhir = $this->Payroll_model->read_melakukan_pembayaran_slipgaji_half_month_check_last($r->user_id,$p_date);
				if($check_pembayaran->num_rows() > 1) {
					//foreach($pembayaran_terakhir as $payment_half_last){
					$melakukan_pembayaran = $this->Payroll_model->read_melakukan_pembayaran_slipgaji($r->user_id,$p_date);
					$view_url = site_url().'admin/payroll/slipgaji/id/'.$melakukan_pembayaran[0]->slipgaji_key;
					
					$status = '<span class="label label-success">'.$this->lang->line('umb_payroll_bayar').'</span>';
					//$mpay = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_payroll_melakukan_pembayaran').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".'.$p_class.'" data-karyawan_id="'. $r->user_id . '" data-payment_date="'. $p_date . '" data-perusahaan_id="'.$this->input->get("perusahaan_id").'"><span class="far fa-money-bill-alt"></span></button></span>';
					$mpay = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_payroll_view_slipgaji').'"><a href="'.$view_url.'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="far fa-arrow-alt-circle-right"></span></button></a></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_download').'"><a href="'.site_url().'admin/payroll/pdf_create/p/'.$melakukan_pembayaran[0]->slipgaji_key.'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="oi oi-cloud-download"></span></button></a></span>';
					if(in_array('313',$role_resources_ids)){
						$delete = '<span data-toggle="tooltip" data-state="danger" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $melakukan_pembayaran[0]->slipgaji_id . '"><span class="fas fa-trash-restore"></span></button></span>';
					} else {
						$delete = '';
					}
					$delete = $delete.'<code>'.$this->lang->line('umb_title_first_half').'</code><br>'.'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_payroll_view_slipgaji').'"><a href="'.site_url().'admin/payroll/slipgaji/id/'.$pembayaran_terakhir[0]->slipgaji_key.'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="far fa-arrow-alt-circle-right"></span></button></a></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_download').'"><a href="'.site_url().'admin/payroll/pdf_create/p/'.$pembayaran_terakhir[0]->slipgaji_key.'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="oi oi-cloud-download"></span></button></a></span><span data-toggle="tooltip" data-state="danger" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $pembayaran_terakhir[0]->slipgaji_id . '"><span class="fas fa-trash-restore"></span></button></span><code>'.$this->lang->line('umb_title_second_half').'</code>';
						//}
					$detail = '';
					$total_gaji_bersih = $melakukan_pembayaran[0]->gaji_bersih;
				} else if($check_pembayaran->num_rows() > 0){
					$melakukan_pembayaran = $this->Payroll_model->read_melakukan_pembayaran_slipgaji($r->user_id,$p_date);
					$view_url = site_url().'admin/payroll/slipgaji/id/'.$melakukan_pembayaran[0]->slipgaji_key;
					
					$status = '<span class="label label-success">'.$this->lang->line('umb_payroll_bayar').'</span>';
					$mpay = '<span data-toggle="tooltip" data-state="primary" data-placement="top" title="'.$this->lang->line('umb_payroll_melakukan_pembayaran').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".'.$p_class.'" data-karyawan_id="'. $r->user_id . '" data-payment_date="'. $p_date . '" data-perusahaan_id="'.$this->input->get("perusahaan_id").'"><span class="far fa-money-bill-alt"></span></button></span>';
					$mpay .= '<span data-toggle="tooltip" data-state="primary" data-placement="top" title="'.$this->lang->line('umb_payroll_view_slipgaji').'"><a href="'.$view_url.'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="far fa-arrow-alt-circle-right"></span></button></a></span><span data-toggle="tooltip" data-state="primary" data-placement="top" title="'.$this->lang->line('umb_download').'"><a href="'.site_url().'admin/payroll/pdf_create/p/'.$melakukan_pembayaran[0]->slipgaji_key.'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="oi oi-cloud-download"></span></button></a></span>';
					if(in_array('313',$role_resources_ids)){
						$delete = '<span data-toggle="tooltip" data-state="danger" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $melakukan_pembayaran[0]->slipgaji_id . '"><span class="fas fa-trash-restore"></span></button></span>';
					} else {
						$delete = '';
					}
					$delete  = $delete.'<code>'.$this->lang->line('umb_title_first_half').'</code>';
					$detail = '';
					$total_gaji_bersih = $melakukan_pembayaran[0]->gaji_bersih;
				} else {
					$status = '<span class="label label-danger">'.$this->lang->line('umb_payroll_belum_dibayar').'</span>';
					$mpay = '<span data-toggle="tooltip" data-state="primary" data-placement="top" title="'.$this->lang->line('umb_payroll_melakukan_pembayaran').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".'.$p_class.'" data-karyawan_id="'. $r->user_id . '" data-payment_date="'. $p_date . '" data-perusahaan_id="'.$this->input->get("perusahaan_id").'"><span class="far fa-money-bill-alt"></span></button></span>';
					$delete = '';
					$detail = '<span data-toggle="tooltip" data-state="primary" data-placement="top" title="'.$this->lang->line('umb_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target="#'.$view_p_class.'" data-karyawan_id="'. $r->user_id . '"><span class="fa fa-eye"></span></button></span>';
					$total_gaji_bersih = $total_gaji_bersih;
				}
			} else {
				$check_pembayaran = $this->Payroll_model->read_check_melakukan_pembayaran_slipgaji($r->user_id,$p_date);
				if($check_pembayaran->num_rows() > 0){
					$melakukan_pembayaran = $this->Payroll_model->read_melakukan_pembayaran_slipgaji($r->user_id,$p_date);
					$view_url = site_url().'admin/payroll/slipgaji/id/'.$melakukan_pembayaran[0]->slipgaji_key;
					
					$status = '<span class="label label-success">'.$this->lang->line('umb_payroll_bayar').'</span>';
					$mpay = '<span data-toggle="tooltip" data-state="primary" data-placement="top" title="'.$this->lang->line('umb_payroll_view_slipgaji').'"><a href="'.$view_url.'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="far fa-arrow-alt-circle-right"></span></button></a></span><span data-toggle="tooltip" data-state="primary" data-placement="top" title="'.$this->lang->line('umb_download').'"><a href="'.site_url().'admin/payroll/pdf_create/p/'.$melakukan_pembayaran[0]->slipgaji_key.'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="oi oi-cloud-download"></span></button></a></span>';
					if(in_array('313',$role_resources_ids)){
						$delete = '<span data-toggle="tooltip" data-state="danger" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $melakukan_pembayaran[0]->slipgaji_id . '"><span class="fas fa-trash-restore"></span></button></span>';
					} else {
						$delete = '';
					}
					$total_gaji_bersih = $melakukan_pembayaran[0]->gaji_bersih;
				} else {
					$status = '<span class="label label-danger">'.$this->lang->line('umb_payroll_belum_dibayar').'</span>';
					$mpay = '<span data-toggle="tooltip" data-state="primary" data-placement="top" title="'.$this->lang->line('umb_payroll_melakukan_pembayaran').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".'.$p_class.'" data-karyawan_id="'. $r->user_id . '" data-payment_date="'. $p_date . '" data-perusahaan_id="'.$this->input->get("perusahaan_id").'"><span class="far fa-money-bill-alt"></span></button></span>';
					$delete = '';
					$total_gaji_bersih = $total_gaji_bersih;
				}
				$detail = '<span data-toggle="tooltip" data-state="primary" data-placement="top" title="'.$this->lang->line('umb_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target="#'.$view_p_class.'" data-karyawan_id="'. $r->user_id . '"><span class="fa fa-eye"></span></button></span>';
			}
			
			$gaji_bersih = number_format((float)$total_gaji_bersih, 2, '.', '');
			$gaji_pokok = number_format((float)$gaji_pokok, 2, '.', '');
			if($gaji_pokok == 0 || $gaji_pokok == '') {
				$fmpay = '';
			} else {
				$fmpay = $mpay;
			}
			/*$info_perusahaan = $this->Perusahaan_model->read_informasi_perusahaan($r->perusahaan_id);
			if(!is_null($info_perusahaan)){
				$gaji_pokok = $this->Umb_model->perusahaan_currency_sign($gaji_pokok,$r->perusahaan_id);
				$gaji_bersih = $this->Umb_model->perusahaan_currency_sign($gaji_bersih,$r->perusahaan_id);
			} else {
				$gaji_pokok = $this->Umb_model->currency_sign($gaji_pokok);
				$gaji_bersih = $this->Umb_model->currency_sign($gaji_bersih);	
			}*/
			$gaji_pokok = $this->Umb_model->currency_sign($gaji_pokok);
			$gaji_bersih = $this->Umb_model->currency_sign($gaji_bersih);	

			$inama_krywn = $nama_krywn.'<small class="text-muted"><i> ('.$prshn_nama.')<i></i></i></small>';

			$act = $detail.$fmpay.$delete;
			if($r->type_upahh==1){
				if($system[0]->is_half_monthly==1){
					$payroll_upah_krywn = $type_upahh.'<br><small class="text-muted"><i>'.$this->lang->line('umb_half_monthly').'<i></i></i></small>';
				} else {
					$payroll_upah_krywn = $type_upahh;
				}
			}else {
				$payroll_upah_krywn = $type_upahh;
			}
			if(in_array('351',$role_resources_ids)) {
				$krywn_id = '<a target="_blank" href="'.site_url('admin/karyawans/setup_gaji/').$r->user_id.'" class="text-muted" data-state="primary" data-placement="top" data-toggle="tooltip" title="'.$this->lang->line('umb_karyawan_set_gaji').'">'.$r->karyawan_id.' <i class="fas fa-arrow-circle-right"></i></a>';
			} else {
				$krywn_id = $r->karyawan_id;
			}
			$data[] = array(
				$act,
				$krywn_id,
				$inama_krywn,
				$payroll_upah_krywn,
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

	public function list_advance_gaji() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/payroll/advance_gaji", $data);
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
				'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-xs btn-outline-info waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-advance_gaji_id="'. $r->advance_gaji_id . '"><span class="fas fa-pencil-alt"></span></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_view').'"><button type="button" class="btn icon-btn btn-xs btn-outline-info waves-effect waves-light" data-toggle="modal" data-target="#modals-slide" data-advance_gaji_id="'. $r->advance_gaji_id . '"><span class="fa fa-eye"></span></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-xs btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->advance_gaji_id . '"><span class="far fa-trash-alt"></span></button></span>',
				$prshn_nama,
				$full_name,
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

	public function list_laporan_advance_gaji() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/payroll/advance_gaji", $data);
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
			if($r->status==0): $status = $this->lang->line('umb_pending'); elseif($r->status==1): $status = $this->lang->line('umb_accepted'); else: $status = $this->lang->line('umb_rejected'); endif;
			$angsuran_bulanan = $this->Umb_model->currency_sign($r->angsuran_bulanan);

			$remainig_jumlah = $r->advance_jumlah - $r->total_yang_dibayarkan;
			$rjumlah = $this->Umb_model->currency_sign($remainig_jumlah);

			if($r->pengurangan_satu_kali==1): $onetime = $this->lang->line('umb_yes'); else: $onetime = $this->lang->line('umb_no'); endif;
			if($r->advance_jumlah == $r->total_yang_dibayarkan){
				$all_dibayar = '<span class="badge badge-success">'.$this->lang->line('umb_all_dibayar').'</span>';
			} else {
				$all_dibayar = '<span class="badge badge-warning">'.$this->lang->line('umb_remaining').'</span>';
			}

			$total_yang_dibayarkan = $this->Umb_model->currency_sign($r->total_yang_dibayarkan);

			$perusahaan = $this->Umb_model->read_info_perusahaan($r->perusahaan_id);
			if(!is_null($perusahaan)){
				$prshn_nama = $perusahaan[0]->name;
			} else {
				$prshn_nama = '--';	
			}

			$data[] = array(
				'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_view').'"><button type="button" class="btn icon-btn btn-xs btn-outline-info waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-karyawan_id="'. $r->karyawan_id . '"><span class="fa fa-eye"></span></button></span>',
				$prshn_nama,
				$full_name,
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

	public function read_payroll_template() {
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
			'upahh_harian' => $user[0]->upahh_harian,
		);
		if(!empty($session)){ 
			$this->load->view('admin/payroll/dialog_templates', $data);
		} else {
			redirect('admin/');
		}
	}

	public function read_upahperjam_template()
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
			'euser_id' => $user[0]->user_id,
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


	public function pay_gaji() {
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
			'location_id' => $user[0]->location_id,
			'user_id' => $user[0]->user_id,
			'type_upahh' => $user[0]->type_upahh,
			'gaji_pokok' => $user[0]->gaji_pokok,
			'upahh_harian' => $user[0]->upahh_harian
		);
		if(!empty($session)){ 
			$this->load->view('admin/payroll/dialog_melakukan_pembayaran', $data);
		} else {
			redirect('admin/');
		}
	}

	public function pay_hourly() {

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
			'location_id' => $user[0]->location_id,
			'user_id' => $user[0]->user_id,
			'euser_id' => $user[0]->user_id,
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

	public function add_pay_monthly() {

		if($this->input->post('add_type')=='add_monthly_payment') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			/*if($Return['error']!=''){
				$this->output($Return);
			}*/
			$gaji_pokok = $this->input->post('gaji_pokok');
			$system = $this->Umb_model->read_setting_info(1);
			$euser_info = $this->Umb_model->read_user_info($this->input->post('krywn_id'));
			if($system[0]->is_half_monthly==1){
				$is_half_monthly_payroll = 1;
			} else {
				$is_half_monthly_payroll = 0;
			}

			$advance_gaji = $this->Payroll_model->advance_gaji_melalui_karyawan_id($this->input->post('krywn_id'));

			if(!is_null($advance_gaji)){
				$krywn_value = $this->Payroll_model->get_bayar_gaji_melalui_karyawan_id($this->input->post('krywn_id'));
				$angsuran_bulanan = $advance_gaji[0]->angsuran_bulanan;
				$total_yang_dibayarkan = $advance_gaji[0]->total_yang_dibayarkan;
				$advance_jumlah = $advance_gaji[0]->advance_jumlah;

				$em_advance_jumlah = $krywn_value[0]->advance_jumlah;
				$em_total_yang_dibayarkan = $krywn_value[0]->total_yang_dibayarkan;
				if($em_advance_jumlah > $em_total_yang_dibayarkan){
					if($angsuran_bulanan=='' || $angsuran_bulanan==0) {
						$add_jumlah = $em_total_yang_dibayarkan + $this->input->post('advance_jumlah');
						$adv_data = array('total_yang_dibayarkan' => $add_jumlah);
						$potong_slipgaji = $this->input->post('advance_jumlah');
						$this->Payroll_model->updated_bayar_jumlah_advance_gaji($adv_data,$this->input->post('krywn_id'));
						$potong_gaji = $potong_slipgaji;
						$is_advance_potongan = 1;
					} else {
						$add_jumlah = $em_total_yang_dibayarkan + $this->input->post('advance_jumlah');
						$potong_slipgaji = $this->input->post('advance_jumlah');
						$adv_data = array('total_yang_dibayarkan' => $add_jumlah);
						$this->Payroll_model->updated_bayar_jumlah_advance_gaji($adv_data,$this->input->post('krywn_id'));
						$potong_gaji = $potong_slipgaji;
						$is_advance_potongan = 1;
					}

				}
			} else {
				$potong_gaji = 0;
				$is_advance_potongan = 0;
			}

			$jurl = random_string('alnum', 40);	
			$data = array(
				'karyawan_id' => $this->input->post('krywn_id'),
				'department_id' => $this->input->post('department_id'),
				'perusahaan_id' => $this->input->post('perusahaan_id'),
				'location_id' => $this->input->post('location_id'),
				'penunjukan_id' => $this->input->post('penunjukan_id'),
				'gaji_bulan' => $this->input->post('pay_date'),
				'gaji_pokok' => $gaji_pokok,
				'gaji_bersih' => $this->input->post('gaji_bersih'),
				'type_upahh' => $this->input->post('type_upahh'),
				'is_half_monthly_payroll' => $is_half_monthly_payroll,
				'total_komissi' => $this->input->post('total_komissi'),
				'total_statutory_potongans' => $this->input->post('total_statutory_potongans'),
				'total_pembayarans_lainnya' => $this->input->post('total_pembayarans_lainnya'),
				'total_tunjanagans' => $this->input->post('total_tunjanagans'),
				'total_pinjaman' => $this->input->post('total_pinjaman'),
				'total_lembur' => $this->input->post('total_lembur'),
				'jumlah_asuransi' => $this->input->post('jumlah_asuransi'),
				'asuransi_percent' => $this->input->post('asuransi_percent'),
				'is_potong_advance_gaji' => $is_advance_potongan,
				'jumlah_advance_gaji' => $potong_gaji,
				'is_payment' => '1',
				'status' => '0',
				'type_slipgaji' => 'full_monthly',
				'slipgaji_key' => $jurl,
				'year_to_date' => date('d-m-Y'),
				'created_at' => date('d-m-Y h:i:s')
			);
			$result = $this->Payroll_model->add_gaji_slipgaji($data);

			$system_settings = system_settings_info(1);	
			if($system_settings->online_payment_account == ''){
				$online_payment_account = 0;
			} else {
				$online_payment_account = $system_settings->online_payment_account;
			}

			if ($result) {

				$ivdata = array(
					'jumlah' => $this->input->post('gaji_bersih'),
					'account_id' => $online_payment_account,
					'type_transaksi' => 'biaya',
					'dr_cr' => 'cr',
					'tanggal_transaksi' => date('Y-m-d'),
					'pembayar_penerima_pembayaran_id' => $this->input->post('krywn_id'),
					'payment_method_id' => 3,
					'description' => 'Payroll Pembayaran',
					'reference' => 'Payroll Pembayaran',
					'invoice_id' => $result,
					'client_id' => $this->input->post('krywn_id'),
					'created_at' => date('Y-m-d H:i:s')
				);
				$this->Keuangan_model->add_transaksii($ivdata);
				$account_id = $this->Keuangan_model->read_informasi_bankcash($online_payment_account);
				$acc_saldo = $account_id[0]->saldo_account - $this->input->post('gaji_bersih');

				$data3 = array(
					'saldo_account' => $acc_saldo
				);
				$this->Keuangan_model->update_record_bankcash($data3,$online_payment_account);

				$gaji_tunjanagans = $this->Karyawans_model->read_gaji_tunjanagans($this->input->post('krywn_id'));
				$count_tunjanagans = $this->Karyawans_model->count_karyawan_tunjanagans($this->input->post('krywn_id'));
				$jumlah_tunjanagan = 0;
				if($count_tunjanagans > 0) {
					foreach($gaji_tunjanagans as $sl_tunjanagans){
						$esl_tunjanagans = $sl_tunjanagans->jumlah_tunjanagan;
						if($system[0]->is_half_monthly==1){
							if($system[0]->potong_setengah_bulan==2){
								$ejumlah_tunjanagan = $esl_tunjanagans/2;
							} else {
								$ejumlah_tunjanagan = $esl_tunjanagans;
							}
						} else {
							$ejumlah_tunjanagan = $esl_tunjanagans;
						}
						$tunjanagan_data = array(
							'slipgaji_id' => $result,
							'karyawan_id' => $this->input->post('krywn_id'),
							'gaji_bulan' => $this->input->post('pay_date'),
							'title_tunjanagan' => $sl_tunjanagans->title_tunjanagan,
							'jumlah_tunjanagan' => $ejumlah_tunjanagan,
							'is_tunjanagan_kena_pajak' => $sl_tunjanagans->is_tunjanagan_kena_pajak,
							'jumlah_option' => $sl_tunjanagans->jumlah_option,
							'created_at' => date('d-m-Y h:i:s')
						);
						$_tunjanagan_data = $this->Payroll_model->add_gaji_slipgaji_tunjanagans($tunjanagan_data);
					}
				}

				$gaji_komissi = $this->Karyawans_model->read_gaji_komissi($this->input->post('krywn_id'));
				$count_komisi = $this->Karyawans_model->count_karyawan_komissi($this->input->post('krywn_id'));
				$jumlah_komisi = 0;
				if($count_komisi > 0) {
					foreach($gaji_komissi as $sl_komisi){
						$esl_komisi = $sl_komisi->jumlah_komisi;
						if($system[0]->is_half_monthly==1){
							if($system[0]->potong_setengah_bulan==2){
								$ejumlah_komisi = $esl_komisi/2;
							} else {
								$ejumlah_komisi = $esl_komisi;
							}
						} else {
							$ejumlah_komisi = $esl_komisi;
						}
						$komissi_data = array(
							'slipgaji_id' => $result,
							'karyawan_id' => $this->input->post('krywn_id'),
							'gaji_bulan' => $this->input->post('pay_date'),
							'komisi_title' => $sl_komisi->komisi_title,
							'jumlah_komisi' => $ejumlah_komisi,
							'is_komisi_kena_pajak' => $sl_komisi->is_komisi_kena_pajak,
							'jumlah_option' => $sl_komisi->jumlah_option,
							'created_at' => date('d-m-Y h:i:s')
						);
						$this->Payroll_model->add_gaji_slipgaji_komissi($komissi_data);
					}
				}
				$gaji_pembayarans_lainnya = $this->Karyawans_model->read_gaji_pembayarans_lainnya($this->input->post('krywn_id'));
				$count_pembayaran_lainnya = $this->Karyawans_model->count_karyawan_pembayarans_lainnya($this->input->post('krywn_id'));
				$pembayaran_lainnya_jumlah = 0;
				if($count_pembayaran_lainnya > 0) {
					foreach($gaji_pembayarans_lainnya as $sl_pembayarans_lainnya){
						$esl_pembayarans_lainnya = $sl_pembayarans_lainnya->jumlah_pembayarans;
						if($system[0]->is_half_monthly==1){
							if($system[0]->potong_setengah_bulan==2){
								$ejumlah_pembayarans = $esl_pembayarans_lainnya/2;
							} else {
								$ejumlah_pembayarans = $esl_pembayarans_lainnya;
							}
						} else {
							$ejumlah_pembayarans = $esl_pembayarans_lainnya;
						}
						$pembayarans_lainnya_data = array(
							'slipgaji_id' => $result,
							'karyawan_id' => $this->input->post('krywn_id'),
							'gaji_bulan' => $this->input->post('pay_date'),
							'title_pembayarans' => $sl_pembayarans_lainnya->title_pembayarans,
							'jumlah_pembayarans' => $ejumlah_pembayarans,
							'ia_pembayaranlainnya_kena_pajak' => $sl_pembayarans_lainnya->ia_pembayaranlainnya_kena_pajak,
							'jumlah_option' => $sl_pembayarans_lainnya->jumlah_option,
							'created_at' => date('d-m-Y h:i:s')
						);
						$this->Payroll_model->add_gaji_slipgaji_pembayarans_lainnya($pembayarans_lainnya_data);
					}
				}

				$gaji_statutory_potongans = $this->Karyawans_model->read_gaji_statutory_potongans($this->input->post('krywn_id'));
				$count_statutory_potongans = $this->Karyawans_model->count_karyawan_statutory_potongans($this->input->post('krywn_id'));
				$jumlah_statutory_potongans = 0;
				if($count_statutory_potongans > 0) {
					foreach($gaji_statutory_potongans as $sl_statutory_potongan){
						$esl_statutory_potongan = $sl_statutory_potongan->jumlah_potongan;
						if($system[0]->is_half_monthly==1){
							if($system[0]->potong_setengah_bulan==2){
								$ejumlah_potongan = $esl_statutory_potongan/2;
							} else {
								$ejumlah_potongan = $esl_statutory_potongan;
							}
						} else {
							$ejumlah_potongan = $esl_statutory_potongan;
						}
						$statutory_potongan_data = array(
							'slipgaji_id' => $result,
							'karyawan_id' => $this->input->post('krywn_id'),
							'gaji_bulan' => $this->input->post('pay_date'),
							'title_potongan' => $sl_statutory_potongan->title_potongan,
							'statutory_options' => $sl_statutory_potongan->statutory_options,
							'jumlah_potongan' => $ejumlah_potongan,
							'created_at' => date('d-m-Y h:i:s')
						);
						$this->Payroll_model->add_gaji_slipgaji_statutory_potongans($statutory_potongan_data);
					}
				}

				$gaji_pinjaman_potongan = $this->Karyawans_model->read_gaji_pinjaman_potongans($this->input->post('krywn_id'));
				$count_pinjaman_potongan = $this->Karyawans_model->count_karyawan_potongans($this->input->post('krywn_id'));
				$jumlah_ptng_pinjaman = 0;
				if($count_pinjaman_potongan > 0) {
					foreach($gaji_pinjaman_potongan as $sl_gaji_pinjaman_potongan){
						$esl_gaji_pinjaman_potongan = $sl_gaji_pinjaman_potongan->pinjaman_jumlah_potongan;
						if($system[0]->is_half_monthly==1){
							if($system[0]->potong_setengah_bulan==2){
								$epinjaman_jumlah_potongan = $esl_gaji_pinjaman_potongan/2;
							} else {
								$epinjaman_jumlah_potongan = $esl_gaji_pinjaman_potongan;
							}
						} else {
							$epinjaman_jumlah_potongan = $esl_gaji_pinjaman_potongan;
						}
						$pinjaman_data = array(
							'slipgaji_id' => $result,
							'karyawan_id' => $this->input->post('krywn_id'),
							'gaji_bulan' => $this->input->post('pay_date'),
							'pinjaman_title' => $sl_gaji_pinjaman_potongan->title_potongan_pinjaman,
							'pinjaman_jumlah' => $epinjaman_jumlah_potongan,
							'created_at' => date('d-m-Y h:i:s')
						);
						$_pinjaman_data = $this->Payroll_model->add_gaji_slipgaji_pinjaman($pinjaman_data);
					}
				}

				$gaji_lembur = $this->Karyawans_model->read_gaji_lembur($this->input->post('krywn_id'));
				$count_lembur = $this->Karyawans_model->count_karyawan_lembur($this->input->post('krywn_id'));
				$jumlah_lembur = 0;
				if($count_lembur > 0) {
					foreach($gaji_lembur as $sl_lembur){
						$ejam_lembur = $sl_lembur->jam_lembur;
						$enilai_lembur = $sl_lembur->nilai_lembur;
						if($system[0]->is_half_monthly==1){
							if($system[0]->potong_setengah_bulan==2){
								$esl_lembur_hr = $ejam_lembur/2;
								$esl_nilai_lembur = $enilai_lembur/2;
							} else {
								$esl_lembur_hr = $ejam_lembur;
								$esl_nilai_lembur = $enilai_lembur;
							}
						} else {
							$esl_lembur_hr = $ejam_lembur;
							$esl_nilai_lembur = $enilai_lembur;
						}
						$lembur_data = array(
							'slipgaji_id' => $result,
							'karyawan_id' => $this->input->post('krywn_id'),
							'lembur_gaji_bulan' => $this->input->post('pay_date'),
							'title_lembur' => $sl_lembur->type_lembur,
							'lembur_no_of_days' => $sl_lembur->no_of_days,
							'jam_lembur' => $esl_lembur_hr,
							'nilai_lembur' => $esl_nilai_lembur,
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

	public function add_pay_hourly() {

		if($this->input->post('add_type')=='add_pay_hourly') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			/*if($Return['error']!=''){
				$this->output($Return);
			}*/
			$gaji_pokok = $this->input->post('gaji_pokok');
			$jurl = random_string('alnum', 40);	
			$data = array(
				'karyawan_id' => $this->input->post('krywn_id'),
				'department_id' => $this->input->post('department_id'),
				'perusahaan_id' => $this->input->post('perusahaan_id'),
				'location_id' => $this->input->post('location_id'),
				'penunjukan_id' => $this->input->post('penunjukan_id'),
				'gaji_bulan' => $this->input->post('pay_date'),
				'gaji_pokok' => $gaji_pokok,
				'gaji_bersih' => $this->input->post('gaji_bersih'),
				'type_upahh' => $this->input->post('type_upahh'),
				'is_half_monthly_payroll' => 0,
				'total_komissi' => $this->input->post('total_komissi'),
				'total_statutory_potongans' => $this->input->post('total_statutory_potongans'),
				'total_pembayarans_lainnya' => $this->input->post('total_pembayarans_lainnya'),
				'total_tunjanagans' => $this->input->post('total_tunjanagans'),
				'total_pinjaman' => $this->input->post('total_pinjaman'),
				'total_lembur' => $this->input->post('total_lembur'),
				'jam_bekerja' => $this->input->post('jam_bekerja'),
				'jumlah_asuransi' => $this->input->post('jumlah_asuransi'),
				'asuransi_percent' => $this->input->post('asuransi_percent'),
				'is_payment' => '1',
				'status' => '0',
				'type_slipgaji' => 'perjam',
				'slipgaji_key' => $jurl,
				'year_to_date' => date('d-m-Y'),
				'created_at' => date('d-m-Y h:i:s')
			);
			$result = $this->Payroll_model->add_gaji_slipgaji($data);	
			$system_settings = system_settings_info(1);	
			if($system_settings->online_payment_account == ''){
				$online_payment_account = 0;
			} else {
				$online_payment_account = $system_settings->online_payment_account;
			}
			if ($result) {
				$ivdata = array(
					'jumlah' => $this->input->post('gaji_bersih'),
					'account_id' => $online_payment_account,
					'type_transaksi' => 'biaya',
					'dr_cr' => 'cr',
					'tanggal_transaksi' => date('Y-m-d'),
					'pembayar_penerima_pembayaran_id' => $this->input->post('krywn_id'),
					'payment_method_id' => 3,
					'description' => 'Payroll Pembayaran',
					'reference' => 'Payroll Pembayaran',
					'invoice_id' => $result,
					'client_id' => $this->input->post('krywn_id'),
					'created_at' => date('Y-m-d H:i:s')
				);
				$this->Keuangan_model->add_transaksii($ivdata);

				$account_id = $this->Keuangan_model->read_informasi_bankcash($online_payment_account);
				$acc_saldo = $account_id[0]->saldo_account - $this->input->post('gaji_bersih');

				$data3 = array(
					'saldo_account' => $acc_saldo
				);
				$this->Keuangan_model->update_record_bankcash($data3,$online_payment_account);

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
							'is_tunjanagan_kena_pajak' => $sl_tunjanagans->is_tunjanagan_kena_pajak,
							'jumlah_option' => $sl_tunjanagans->jumlah_option,
							'created_at' => date('d-m-Y h:i:s')
						);
						$_tunjanagan_data = $this->Payroll_model->add_gaji_slipgaji_tunjanagans($tunjanagan_data);
					}
				}

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
							'is_komisi_kena_pajak' => $sl_komisi->is_komisi_kena_pajak,
							'jumlah_option' => $sl_komisi->jumlah_option,
							'created_at' => date('d-m-Y h:i:s')
						);
						$this->Payroll_model->add_gaji_slipgaji_komissi($komissi_data);
					}
				}

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
							'ia_pembayaranlainnya_kena_pajak' => $sl_pembayarans_lainnya->ia_pembayaranlainnya_kena_pajak,
							'jumlah_option' => $sl_pembayarans_lainnya->jumlah_option,
							'created_at' => date('d-m-Y h:i:s')
						);
						$this->Payroll_model->add_gaji_slipgaji_pembayarans_lainnya($pembayarans_lainnya_data);
					}
				}

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
							'statutory_options' => $sl_statutory_potongan->statutory_options,
							'created_at' => date('d-m-Y h:i:s')
						);
						$this->Payroll_model->add_gaji_slipgaji_statutory_potongans($statutory_potongan_data);
					}
				}

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

	public function add_half_pay_to_all() {

		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();

		if($this->input->post('add_type')=='payroll') {	
			if($this->input->post('perusahaan_id')==0 && $this->input->post('location_id')==0 && $this->input->post('department_id')==0) {	
				$result = $this->Umb_model->all_karyawans();
			} else if($this->input->post('perusahaan_id')!=0 && $this->input->post('location_id')==0 && $this->input->post('department_id')==0) {	
				$eresult = $this->Payroll_model->get_perusahaan_payroll_karyawans($this->input->post('perusahaan_id'));
				$result = $eresult->result();
			} else if($this->input->post('perusahaan_id')!=0 && $this->input->post('location_id')!=0 && $this->input->post('department_id')==0) {	
				$eresult = $this->Payroll_model->get_perusahaan_location_payroll_karyawans($this->input->post('perusahaan_id'),$this->input->post('location_id'));
				$result = $eresult->result();
			} else if($this->input->post('perusahaan_id')!=0 && $this->input->post('location_id')!=0 && $this->input->post('department_id')!=0) {	
				$eresult = $this->Payroll_model->get_perusahaan_location_dep_payroll_karyawans($this->input->post('perusahaan_id'),$this->input->post('location_id'),$this->input->post('department_id'));
				$result = $eresult->result();
			} else {
				$Return['error'] = $this->lang->line('umb_record_not_found');
			}
			$system = $this->Umb_model->read_setting_info(1);
			$system_settings = system_settings_info(1);	
			if($system_settings->online_payment_account == ''){
				$online_payment_account = 0;
			} else {
				$online_payment_account = $system_settings->online_payment_account;
			}
			foreach($result as $krywnid) {
				$user_id = $krywnid->user_id;
				$user = $this->Umb_model->read_user_info($user_id);

				if($system[0]->is_half_monthly==1){
					$is_half_monthly_payroll = 1;
				} else {
					$is_half_monthly_payroll = 0;
				}

				if($krywnid->type_upahh==1){
					if($system[0]->is_half_monthly==1){
						$gaji_pokok = $krywnid->gaji_pokok / 2;
					} else {
						$gaji_pokok = $krywnid->gaji_pokok;
					}
				} else {
					$gaji_pokok = $krywnid->upahh_harian;
				}
				if($gaji_pokok > 0) {

					$penunjukan = $this->Penunjukan_model->read_informasi_penunjukan($user[0]->penunjukan_id);
					if(!is_null($penunjukan)){
						$penunjukan_id = $penunjukan[0]->penunjukan_id;
					} else {
						$penunjukan_id = 1;	
					}

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
							if($system[0]->is_half_monthly==1){
								if($system[0]->potong_setengah_bulan==2){
									$ejumlah_tunjanagan = $sl_tunjanagans->jumlah_tunjanagan/2;
								} else {
									$ejumlah_tunjanagan = $sl_tunjanagans->jumlah_tunjanagan;
								}
							} else {
								$ejumlah_tunjanagan = $sl_tunjanagans->jumlah_tunjanagan;
							}
							$jumlah_tunjanagan += $ejumlah_tunjanagan;
							//  $jumlah_tunjanagan += $sl_tunjanagans->jumlah_tunjanagan;
						}
					} else {
						$jumlah_tunjanagan = 0;
					}

					$gaji_pinjaman_potongan = $this->Karyawans_model->read_gaji_pinjaman_potongans($user_id);
					$count_pinjaman_potongan = $this->Karyawans_model->count_karyawan_potongans($user_id);
					$jumlah_ptng_pinjaman = 0;
					if($count_pinjaman_potongan > 0) {
						foreach($gaji_pinjaman_potongan as $sl_gaji_pinjaman_potongan){
							if($system[0]->is_half_monthly==1){
								if($system[0]->potong_setengah_bulan==2){
									$er_pinjaman = $sl_gaji_pinjaman_potongan->pinjaman_jumlah_potongan/2;
								} else {
									$er_pinjaman = $sl_gaji_pinjaman_potongan->pinjaman_jumlah_potongan;
								}
							} else {
								$er_pinjaman = $sl_gaji_pinjaman_potongan->pinjaman_jumlah_potongan;
							}
							$jumlah_ptng_pinjaman += $er_pinjaman;
							// $jumlah_ptng_pinjaman += $sl_gaji_pinjaman_potongan->pinjaman_jumlah_potongan;
						}
					} else {
						$jumlah_ptng_pinjaman = 0;
					}

					$gaji_lembur = $this->Karyawans_model->read_gaji_lembur($user_id);
					$count_lembur = $this->Karyawans_model->count_karyawan_lembur($user_id);
					$jumlah_lembur = 0;
					if($count_lembur > 0) {
						foreach($gaji_lembur as $sl_lembur){
							//$total_lembur = $sl_lembur->jam_lembur * $sl_lembur->nilai_lembur;
							//$jumlah_lembur += $total_lembur;
							if($system[0]->is_half_monthly==1){
								if($system[0]->potong_setengah_bulan==2){
									$ejam_lembur = $sl_lembur->jam_lembur/2;
									$enilai_lembur = $sl_lembur->nilai_lembur/2;
								} else {
									$ejam_lembur = $sl_lembur->jam_lembur;
									$enilai_lembur = $sl_lembur->nilai_lembur;
								}
							} else {
								$ejam_lembur = $sl_lembur->jam_lembur;
								$enilai_lembur = $sl_lembur->nilai_lembur;
							}
							$jumlah_lembur += $ejam_lembur * $enilai_lembur;
						}
					} else {
						$jumlah_lembur = 0;
					}

					$pembayarans_lainnya = $this->Karyawans_model->set_karyawan_pembayarans_lainnya($user_id);
					$jumlah_pembayarans_lainnya = 0;
					if(!is_null($pembayarans_lainnya)):
						foreach($pembayarans_lainnya->result() as $sl_pembayarans_lainnya) {
							//$jumlah_pembayarans_lainnya += $sl_pembayarans_lainnya->jumlah_pembayarans;
							if($system[0]->is_half_monthly==1){
								if($system[0]->potong_setengah_bulan==2){
									$ejumlah_pembayarans = $sl_pembayarans_lainnya->jumlah_pembayarans/2;
								} else {
									$ejumlah_pembayarans = $sl_pembayarans_lainnya->jumlah_pembayarans;
								}
							} else {
								$ejumlah_pembayarans = $sl_pembayarans_lainnya->jumlah_pembayarans;
							}
							$jumlah_pembayarans_lainnya += $ejumlah_pembayarans;
						}
					endif;

					$all_pembayaran_lainnya = $jumlah_pembayarans_lainnya;

					$komissi = $this->Karyawans_model->set_komissi_karyawan($user_id);
					if(!is_null($komissi)):
						$jumlah_komissi = 0;
						foreach($komissi->result() as $sl_komissi) {
							if($system[0]->is_half_monthly==1){
								if($system[0]->potong_setengah_bulan==2){
									$ejumlah_komissi = $sl_komissi->jumlah_komisi/2;
								} else {
									$ejumlah_komissi = $sl_komissi->jumlah_komisi;
								}
							} else {
								$ejumlah_komissi = $sl_komissi->jumlah_komisi;
							}
							$jumlah_komissi += $ejumlah_komissi;
							// $jumlah_komissi += $sl_komissi->jumlah_komisi;
						}
					endif;

					$statutory_potongans = $this->Karyawans_model->set_karyawan_statutory_potongans($user_id);
					if(!is_null($statutory_potongans)):
						$jumlah_statutory_potongans = 0;
						foreach($statutory_potongans->result() as $sl_statutory_potongans) {
							if($system[0]->statutory_fixed!='yes'):
								$sta_gaji = $gaji_pokok;
								$st_jumlah = $sta_gaji / 100 * $sl_statutory_potongans->jumlah_potongan;
								if($system[0]->is_half_monthly==1){
									if($system[0]->potong_setengah_bulan==2){
										$single_sd = $st_jumlah/2;
									} else {
										$single_sd = $st_jumlah;
									}
								} else {
									$single_sd = $st_jumlah;
								}
								$jumlah_statutory_potongans += $single_sd;
							else:
								if($system[0]->is_half_monthly==1){
									if($system[0]->potong_setengah_bulan==2){
										$single_sd = $sl_statutory_potongans->jumlah_potongan/2;
									} else {
										$single_sd = $sl_statutory_potongans->jumlah_potongan;
									}
								} else {
									$single_sd = $sl_statutory_potongans->jumlah_potongan;
								}
								$jumlah_statutory_potongans += $single_sd;
								//$jumlah_statutory_potongans += $sl_statutory_potongans->jumlah_potongan;
							endif;
						}
					endif;

					$add_gaji = $jumlah_tunjanagan + $gaji_pokok + $jumlah_lembur + $jumlah_pembayarans_lainnya + $jumlah_komissi;
					$gaji_bersih_default = $add_gaji - $jumlah_ptng_pinjaman - $jumlah_statutory_potongans;
					$gaji_bersih = $gaji_bersih_default;
					$gaji_bersih = number_format((float)$gaji_bersih, 2, '.', '');
					$jurl = random_string('alnum', 40);		
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
						'is_half_monthly_payroll' => $is_half_monthly_payroll,
						'is_payment' => '1',
						'type_slipgaji' => 'full_monthly',
						'slipgaji_key' => $jurl,
						'year_to_date' => date('d-m-Y'),
						'created_at' => date('d-m-Y h:i:s')
					);
					$result = $this->Payroll_model->add_gaji_slipgaji($data);	

					if ($result) {
						$ivdata = array(
							'jumlah' => $gaji_bersih,
							'account_id' => $online_payment_account,
							'type_transaksi' => 'biaya',
							'dr_cr' => 'cr',
							'tanggal_transaksi' => date('Y-m-d'),
							'pembayar_penerima_pembayaran_id' => $user_id,
							'payment_method_id' => 3,
							'description' => 'Payroll Pembayaran',
							'reference' => 'Payroll Pembayaran',
							'invoice_id' => $result,
							'client_id' => $user_id,
							'created_at' => date('Y-m-d H:i:s')
						);
						$this->Keuangan_model->add_transaksii($ivdata);

						$account_id = $this->Keuangan_model->read_informasi_bankcash($online_payment_account);
						$acc_saldo = $account_id[0]->saldo_account - $gaji_bersih;

						$data3 = array(
							'saldo_account' => $acc_saldo
						);
						$this->Keuangan_model->update_record_bankcash($data3,$online_payment_account);

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
									'is_tunjanagan_kena_pajak' => $sl_tunjanagans->is_tunjanagan_kena_pajak,
									'jumlah_option' => $sl_tunjanagans->jumlah_option,
									'created_at' => date('d-m-Y h:i:s')
								);
								$_tunjanagan_data = $this->Payroll_model->add_gaji_slipgaji_tunjanagans($tunjanagan_data);
							}
						}

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

				}
			}
			$Return['result'] = $this->lang->line('umb_sukses_payment_bayar');
			$this->output($Return);
			exit;
		}
	}

	public function add_pay_to_all() {

		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();

		if($this->input->post('add_type')=='payroll') {	
			if($this->input->post('perusahaan_id')==0 && $this->input->post('location_id')==0 && $this->input->post('department_id')==0) {	
				$eresult = $this->Payroll_model->get_all_karyawans();
				$result = $eresult->result();
			} else if($this->input->post('perusahaan_id')!=0 && $this->input->post('location_id')==0 && $this->input->post('department_id')==0) {	
				$eresult = $this->Payroll_model->get_perusahaan_payroll_karyawans($this->input->post('perusahaan_id'));
				$result = $eresult->result();
			} else if($this->input->post('perusahaan_id')!=0 && $this->input->post('location_id')!=0 && $this->input->post('department_id')==0) {	
				$eresult = $this->Payroll_model->get_perusahaan_location_payroll_karyawans($this->input->post('perusahaan_id'),$this->input->post('location_id'));
				$result = $eresult->result();
			} else if($this->input->post('perusahaan_id')!=0 && $this->input->post('location_id')!=0 && $this->input->post('department_id')!=0) {	
				$eresult = $this->Payroll_model->get_perusahaan_location_dep_payroll_karyawans($this->input->post('perusahaan_id'),$this->input->post('location_id'),$this->input->post('department_id'));
				$result = $eresult->result();
			} else {
				$Return['error'] = $this->lang->line('umb_record_not_found');
			}
			$system = $this->Umb_model->read_setting_info(1);
			$system_settings = system_settings_info(1);	
			if($system_settings->online_payment_account == ''){
				$online_payment_account = 0;
			} else {
				$online_payment_account = $system_settings->online_payment_account;
			}
			foreach($result as $krywnid) {
				$user_id = $krywnid->user_id;
				$user = $this->Umb_model->read_user_info($user_id);			

				if($krywnid->type_upahh==1){
					$gaji_pokok = $krywnid->gaji_pokok;
				} else {
					$gaji_pokok = $krywnid->upahh_harian;
				}
				$pay_count = $this->Payroll_model->read_check_melakukan_pembayaran_slipgaji($user_id,$this->input->post('month_year'));
				if($pay_count->num_rows() > 0){
					$pay_val = $this->Payroll_model->read_melakukan_pembayaran_slipgaji($user_id,$this->input->post('month_year'));
					$this->delete_all_slipgaji($pay_val[0]->slipgaji_id);
				}
				if($gaji_pokok > 0) {

					$penunjukan = $this->Penunjukan_model->read_informasi_penunjukan($user[0]->penunjukan_id);
					if(!is_null($penunjukan)){
						$penunjukan_id = $penunjukan[0]->penunjukan_id;
					} else {
						$penunjukan_id = 1;	
					}
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

					$pembayarans_lainnya = $this->Karyawans_model->set_karyawan_pembayarans_lainnya($user_id);
					$jumlah_pembayarans_lainnya = 0;
					if(!is_null($pembayarans_lainnya)):
						foreach($pembayarans_lainnya->result() as $sl_pembayarans_lainnya) {
							$jumlah_pembayarans_lainnya += $sl_pembayarans_lainnya->jumlah_pembayarans;
						}
					endif;

					$all_pembayaran_lainnya = $jumlah_pembayarans_lainnya;

					$komissi = $this->Karyawans_model->set_komissi_karyawan($user_id);
					if(!is_null($komissi)):
						$jumlah_komissi = 0;
						foreach($komissi->result() as $sl_komissi) {
							$jumlah_komissi += $sl_komissi->jumlah_komisi;
						}
					endif;

					$statutory_potongans = $this->Karyawans_model->set_karyawan_statutory_potongans($user_id);
					if(!is_null($statutory_potongans)):
						$jumlah_statutory_potongans = 0;
						foreach($statutory_potongans->result() as $sl_statutory_potongans) {
							if($system[0]->statutory_fixed!='yes'):
								$sta_gaji = $gaji_pokok;
								$st_jumlah = $sta_gaji / 100 * $sl_statutory_potongans->jumlah_potongan;
								$jumlah_statutory_potongans += $st_jumlah;
							else:
								$jumlah_statutory_potongans += $sl_statutory_potongans->jumlah_potongan;
							endif;
						}
					endif;


					$add_gaji = $jumlah_tunjanagan + $gaji_pokok + $jumlah_lembur + $jumlah_pembayarans_lainnya + $jumlah_komissi;

					$gaji_bersih_default = $add_gaji - $jumlah_ptng_pinjaman - $jumlah_statutory_potongans;
					$gaji_bersih = $gaji_bersih_default;
					$gaji_bersih = number_format((float)$gaji_bersih, 2, '.', '');
					$jurl = random_string('alnum', 40);		
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
						'type_slipgaji' => 'full_monthly',
						'slipgaji_key' => $jurl,
						'year_to_date' => date('d-m-Y'),
						'created_at' => date('d-m-Y h:i:s')
					);
					$result = $this->Payroll_model->add_gaji_slipgaji($data);	

					if ($result) {
						$ivdata = array(
							'jumlah' => $gaji_bersih,
							'account_id' => $online_payment_account,
							'type_transaksi' => 'biaya',
							'dr_cr' => 'cr',
							'tanggal_transaksi' => date('Y-m-d'),
							'pembayar_penerima_pembayaran_id' => $user_id,
							'payment_method_id' => 3,
							'description' => 'Payroll Pembayaran',
							'reference' => 'Payroll Pembayaran',
							'invoice_id' => $result,
							'client_id' => $user_id,
							'created_at' => date('Y-m-d H:i:s')
						);
						$this->Keuangan_model->add_transaksii($ivdata);
						// update data in bank account
						$account_id = $this->Keuangan_model->read_informasi_bankcash($online_payment_account);
						$acc_saldo = $account_id[0]->saldo_account - $gaji_bersih;

						$data3 = array(
							'saldo_account' => $acc_saldo
						);
						$this->Keuangan_model->update_record_bankcash($data3,$online_payment_account);

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
				}
				
			}
			$Return['result'] = $this->lang->line('umb_sukses_payment_bayar');
			$this->output($Return);
			exit;
		}
	}

	public function list_history_pembayaran() {

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
		$user_info = $this->Umb_model->read_user_info($session['user_id']);
		if($this->input->get("ihr")=='true'){
			if($this->input->get("perusahaan_id")==0 && $this->input->get("location_id")==0 && $this->input->get("department_id")==0){
				if($this->input->get("gaji_bulan") == ''){
					$history = $this->Payroll_model->all_karyawans_history_pembayaran();
				} else {
					$history = $this->Payroll_model->all_karyawans_history_pembayaran_bulan($this->input->get("gaji_bulan"));
				}
			} else if($this->input->get("perusahaan_id")!=0 && $this->input->get("location_id")==0 && $this->input->get("department_id")==0){
				if($this->input->get("gaji_bulan") == ''){
					$history = $this->Payroll_model->get_history_slipgaji_perusahaan($this->input->get("perusahaan_id"));
				} else {
					$history = $this->Payroll_model->get_history_slipgaji_perusahaan_bulan($this->input->get("perusahaan_id"),$this->input->get("gaji_bulan"));
				}
			} else if($this->input->get("perusahaan_id")!=0 && $this->input->get("location_id")!=0 && $this->input->get("department_id")==0 ){
				if($this->input->get("gaji_bulan") == ''){
					$history = $this->Payroll_model->get_perusahaan_location_slipgajii($this->input->get("perusahaan_id"),$this->input->get("location_id"));
				} else {
					$history = $this->Payroll_model->get_perusahaan_location_slipgajii_bulan($this->input->get("perusahaan_id"),$this->input->get("location_id"),$this->input->get("gaji_bulan"));
				}

			} else if($this->input->get("perusahaan_id")!=0 && $this->input->get("location_id")!=0 && $this->input->get("department_id")!=0){
				if($this->input->get("gaji_bulan") == ''){
					$history = $this->Payroll_model->get_perusahaan_location_department_slipgajii($this->input->get("perusahaan_id"),$this->input->get("location_id"),$this->input->get("department_id"));
				} else {
					$history = $this->Payroll_model->get_perusahaan_location_department_slipgajii_month($this->input->get("perusahaan_id"),$this->input->get("location_id"),$this->input->get("department_id"),$this->input->get("gaji_bulan"));
				}

			}/**/ /*else if($this->input->get("perusahaan_id")!=0 && $this->input->get("location_id")!=0 && $this->input->get("department_id")!=0 && $this->input->get("penunjukan_id")!=0){
				$history = $this->Payroll_model->get_perusahaan_location_department_penunjukan_slipgajii($this->input->get("perusahaan_id"),$this->input->get("location_id"),$this->input->get("department_id"),$this->input->get("penunjukan_id"));
			}*/
		} else {
			if($user_info[0]->user_role_id==1){
				$history = $this->Payroll_model->karyawans_history_pembayaran();
			} else {
				if(in_array('391',$role_resources_ids)) {
					$history = $this->Payroll_model->get_perusahaan_slipgajii($user_info[0]->perusahaan_id);
				} else {
					$history = $this->Payroll_model->get_payroll_slip($session['user_id']);
				}
			}
		}
		$data = array();

		foreach($history->result() as $r) {

			$user = $this->Umb_model->read_user_info($r->karyawan_id);
			
			if(!is_null($user)){
				$full_name = $user[0]->first_name.' '.$user[0]->last_name;
				$link_krywn = $user[0]->karyawan_id;			  		  
				$month_payment = date("F, Y", strtotime($r->gaji_bulan));
				
				$p_jumlah = $this->Umb_model->currency_sign($r->gaji_bersih);
				
				$created_at = $this->Umb_model->set_date_format($r->created_at);
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
				$department_penunjukan = $nama_penunjukan.' ('.$nama_department.')';
				$perusahaan = $this->Umb_model->read_info_perusahaan($user[0]->perusahaan_id);
				if(!is_null($perusahaan)){
					$prshn_nama = $perusahaan[0]->name;
				} else {
					$prshn_nama = '--';	
				}
				
				$bank_account = $this->Karyawans_model->get_karyawan_bank_account_terakhir($user[0]->user_id);
				if(!is_null($bank_account)){
					$nomor_account = $bank_account[0]->nomor_account;
				} else {
					$nomor_account = '--';	
				}
				$slipgaji = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_view').'"><a href="'.site_url().'admin/payroll/slipgaji/id/'.$r->slipgaji_key.'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="far fa-arrow-alt-circle-right"></span></button></a></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_download').'"><a href="'.site_url().'admin/payroll/pdf_create/p/'.$r->slipgaji_key.'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="oi oi-cloud-download"></span></button></a></span>';
				
				$ifull_name = nl2br ($full_name."\r\n <small class='text-muted'><i>".$this->lang->line('umb_karyawans_id').': '.$link_krywn."<i></i></i></small>\r\n <small class='text-muted'><i>".$department_penunjukan.'<i></i></i></small>');
				$data[] = array(
					$slipgaji,
					$full_name,
					$prshn_nama,
					$nomor_account,
					$p_jumlah,
					$month_payment,
					$created_at,
				);
			}
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

	public function slipgaji() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		//$data['title'] = $this->Umb_model->site_title();
		$key = $this->uri->segment(5);

		$result = $this->Payroll_model->read_gaji_info_slipgaji_key($key);
		if(is_null($result)){
			redirect('admin/payroll/generate_slipgaji');
		}
		$p_method = '';
		/*$payment_method = $this->Umb_model->read_payment_method($result[0]->payment_method);
		if(!is_null($payment_method)){
		  $p_method = $payment_method[0]->method_name;
		} else {
		  $p_method = '--';
		}*/
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
			'euser_id' => $user[0]->user_id,
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
			'year_to_date' => $result[0]->year_to_date,
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
			'slipgaji_key' => $result[0]->slipgaji_key,
			'type_slipgaji' => $result[0]->type_slipgaji,
			'jam_bekerja' => $result[0]->jam_bekerja,
			'pay_comments' => $result[0]->pay_comments,
			'asuransi_percent' => $result[0]->asuransi_percent,
			'jumlah_asuransi' => $result[0]->jumlah_asuransi,
			'is_potong_advance_gaji' => $result[0]->is_potong_advance_gaji,
			'jumlah_advance_gaji' => $result[0]->jumlah_advance_gaji,
			'is_payment' => $result[0]->is_payment,
			'approval_status' => $result[0]->status,
		);
		$data['breadcrumbs'] = $this->lang->line('umb_payroll_karyawan_slipgaji');
		$data['path_url'] = 'slipgaji';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(!empty($session)){ 
			if($result[0]->type_slipgaji=='perjam'){
				$data['subview'] = $this->load->view("admin/payroll/slipgaji_perjam", $data, TRUE);
			} else {
				$data['subview'] = $this->load->view("admin/payroll/slipgaji", $data, TRUE);
			}
			$this->load->view('admin/layout/layout_main', $data); 
		} else {
			redirect('admin/');
		}
	}

	public function pdf_create() {
		
		//$this->load->library('Pdf');
		$system = $this->Umb_model->read_setting_info(1);		
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		$key = $this->uri->segment(5);
		$payment = $this->Payroll_model->read_gaji_info_slipgaji_key($key);
		if(is_null($payment)){
			redirect('admin/payroll/generate_slipgaji');
		}
		$user = $this->Umb_model->read_user_info($payment[0]->karyawan_id);
		
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
			} else if($system[0]->format_password_slipgaji=='karyawan_id') {
				$password_val = $user[0]->karyawan_id;
			} else if($system[0]->format_password_slipgaji=='nama_tanggal_lahir') {
				$dob = date("dmY", strtotime($user[0]->tanggal_lahir));
				$fname = $user[0]->first_name;
				$lname = $user[0]->last_name;
				$password_val = $dob.$fname[0].$lname[0];
			}
			$pdf->SetProtection(array('print', 'copy','modify'), $password_val, $password_val, 0, null);
		}
		$_tunjuk_nama = $this->Penunjukan_model->read_informasi_penunjukan($user[0]->penunjukan_id);
		if(!is_null($_tunjuk_nama)){
			$_nama_penunjukan = $_tunjuk_nama[0]->nama_penunjukan;
		} else {
			$_nama_penunjukan = '';
		}
		$department = $this->Department_model->read_informasi_department($user[0]->department_id);
		if(!is_null($department)){
			$_nama_department = $department[0]->nama_department;
		} else {
			$_nama_department = '';
		}
		//$location = $this->Umb_model->read_info_location($department[0]->location_id);
		$perusahaan = $this->Umb_model->read_info_perusahaan($user[0]->perusahaan_id);
		
		$p_method = '';
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
		//$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
		//$c_info_alamat = $alamat_1.' '.$alamat_2.', '.$kota.' - '.$kode_pos.', '.$nama_negara;
		$c_info_alamat = $alamat_1.' '.$alamat_2.', '.$kota.' - '.$kode_pos;
		//$email_phone_address = "$c_info_alamat \n".$this->lang->line('umb_phone')." : $c_info_phone | ".$this->lang->line('dashboard_email')." : $c_info_email ";
		$email_phone_address = "$c_info_alamat \n".$this->lang->line('umb_phone')." : $c_info_phone | ".$this->lang->line('dashboard_email')." : $c_info_email \n";
		
		$header_string = $email_phone_address;		
		$pdf->SetCreator('HRASTRAL');
		$pdf->SetAuthor('HRASTRAL');
		//$pdf->SetTitle('Workable-Zone - slipgaji');
		//$pdf->SetSubject('TCPDF Tutorial');
		//$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
		$pdf->SetHeaderData('../../../../../uploads/logo/payroll/'.$system[0]->logo_payroll, 15, $nama_perusahaan, $header_string);
		$pdf->setFooterData(array(0,64,0), array(0,64,128));
		
		$pdf->setHeaderFont(Array('helvetica', '', 11.5));
		$pdf->setFooterFont(Array('helvetica', '', 9));
		
		$pdf->SetDefaultMonospacedFont('courier');
		
		$pdf->SetMargins(15, 27, 15);
		$pdf->SetHeaderMargin(5);
		$pdf->SetFooterMargin(10);
		
		$pdf->SetAutoPageBreak(TRUE, 25);
		
		$pdf->setImageScale(1.25);
		$pdf->SetAuthor('HRASTRAL');
		$pdf->SetTitle($nama_perusahaan.' - '.$this->lang->line('umb_print_slipgaji'));
		$pdf->SetSubject($this->lang->line('umb_slipgaji'));
		$pdf->SetKeywords($this->lang->line('umb_slipgaji'));
		$pdf->SetFont('helvetica', 'B', 10);
		
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		$pdf->setFontSubsetting(true);

		$pdf->SetFont('dejavusans', '', 10, '', true);
		
		$pdf->AddPage();		
		$fname = $user[0]->first_name.' '.$user[0]->last_name;
		$created_at = $this->Umb_model->set_date_format($payment[0]->created_at);
		$tanggal_bergabung = $this->Umb_model->set_date_format($user[0]->tanggal_bergabung);
		$gaji_bulan = $this->Umb_model->set_date_format($payment[0]->gaji_bulan);
		$half_title = '';
		if($system[0]->is_half_monthly==1){
			$check_pembayaran1 = $this->Payroll_model->read_melakukan_pembayaran_slipgaji_half_month_check_first($payment[0]->karyawan_id,$payment[0]->gaji_bulan);
			$check_pembayaran2 = $this->Payroll_model->read_melakukan_pembayaran_slipgaji_half_month_check_last($payment[0]->karyawan_id,$payment[0]->gaji_bulan);
			$check_pembayaran = $this->Payroll_model->read_melakukan_pembayaran_slipgaji_half_month_check($payment[0]->karyawan_id,$payment[0]->gaji_bulan);
			if($check_pembayaran->num_rows() > 1) {
				if($check_pembayaran2[0]->slipgaji_key == $this->uri->segment(5)){
					$half_title = '('.$this->lang->line('umb_title_second_half').')';
				} else if($check_pembayaran1[0]->slipgaji_key == $this->uri->segment(5)){
					$half_title = '('.$this->lang->line('umb_title_first_half').')';
				} else {
					$half_title = '';
				}
			} else {
				$half_title = '('.$this->lang->line('umb_title_first_half').')';
			}
			$half_title = $half_title;
		} else {
			$half_title = '';
		}
		$bs=0;
		$bs = $payment[0]->gaji_pokok;

		$count_tunjanagans = $this->Karyawans_model->count_karyawan_tunjanagans_slipgaji($payment[0]->slipgaji_id);
		$tunjanagans = $this->Karyawans_model->set_tunjanagans_karyawan_slipgaji($payment[0]->slipgaji_id);
		$count_komissi = $this->Karyawans_model->count_karyawan_komissi_slipgaji($payment[0]->slipgaji_id);
		$komissi = $this->Karyawans_model->set_komissi_karyawan_slipgaji($payment[0]->slipgaji_id);
		$count_pembayarans_lainnya = $this->Karyawans_model->count_karyawan_pembayarans_lainnya_slipgaji($payment[0]->slipgaji_id);
		$pembayarans_lainnya = $this->Karyawans_model->set_karyawan_pembayarans_lainnya_slipgaji($payment[0]->slipgaji_id);
		$count_statutory_potongans = $this->Karyawans_model->count_karyawan_statutory_potongans_slipgaji($payment[0]->slipgaji_id);
		$statutory_potongans = $this->Karyawans_model->set_karyawan_statutory_potongans_slipgaji($payment[0]->slipgaji_id);
		$count_lembur = $this->Karyawans_model->count_karyawan_lembur_slipgaji($payment[0]->slipgaji_id);
		$lembur = $this->Karyawans_model->set_karyawan_lembur_slipgaji($payment[0]->slipgaji_id);
		$count_pinjaman = $this->Karyawans_model->count_karyawan_potongans_slipgaji($payment[0]->slipgaji_id);
		$loan = $this->Karyawans_model->set_potongans_karyawan_slipgaji($payment[0]->slipgaji_id);
		$jumlah_statutory_potongan = 0; $jumlah_ptng_pinjaman = 0;
		$jumlah_tunjanagan = 0; $dejumlah_tunjanagan = 0; $add_potongan_tunjanagan = 0;
		$jumlah_komissi = 0; $dejumlah_komissi = 0; $add_deduct_jumlah_komissi = 0;
		$jumlah_pembayarans_lainnya = 0; $dejumlah_pembayarans_lainnya = 0; $add_deduct_jumlah_pembayarans_lainnya = 0;
		$jumlah_lembur = 0;
		
		$tbl = '<br><br>
		<table cellpadding="1" cellspacing="1" border="0">
		<tr>
		<td align="center"><h1>'.$this->lang->line('umb_slipgaji').'</h1></td>
		</tr>
		<tr>
		<td align="center">'.$this->lang->line('umb_payroll_year_date').': '.$half_title.' <strong>'.date("F Y", strtotime($payment[0]->gaji_bulan)).'---'.date('t',strtotime($payment[0]->gaji_bulan.'-01')).'</strong></td>
		</tr>
		</table>
		';
		$pdf->writeHTML($tbl, true, false, false, false, '');
		$pdf->setCellPaddings(1, 1, 1, 1);
		$pdf->setCellMargins(0, 0, 0, 0);
		$pdf->SetFillColor(255, 255, 127);
		//$txt = 'Details Karyawan';
		//$pdf->MultiCell(180, 6, $txt, 0, 'L', 11, 0, '', '', true);
		//$pdf->Ln(7);
		$tbl1 = '
		<table cellpadding="3" cellspacing="0" border="1">
		<tr bgcolor="#69e48a">
		<td colspan="4" align="center"><strong>Details Karyawan</strong></td>
		</tr>
		<tr>
		<td>'.$this->lang->line('umb_name').'</td>
		<td>'.$fname.'</td>
		<td>'.$this->lang->line('dashboard_karyawan_id').'</td>
		<td>'.$user[0]->karyawan_id.'</td>
		</tr>
		<tr>
		<td>'.$this->lang->line('left_department').'</td>
		<td>'.$_nama_department.'</td>
		<td>'.$this->lang->line('left_penunjukan').'</td>
		<td>'.$_nama_penunjukan.'</td>
		</tr>';
		$shift_kantor = $this->Timesheet_model->read_informasi_shift_kantor($user[0]->shift_kantor_id);
		if(!is_null($shift_kantor)){
			$shift = $shift_kantor[0]->nama_shift;
		} else {
			$shift = '--';	
		}
		if($payment[0]->type_slipgaji=='perjam'){
			$hcount = $payment[0]->jam_bekerja;
			$tbl1 .= '<tr>
			<td>'.$this->lang->line('umb_karyawan_tgl_gabung').'</td>
			<td>'.$tanggal_bergabung.'</td>
			<td>'.$this->lang->line('umb_payroll_total_jam_bekerja').'</td>
			<td>'.$hcount.'</td>
			</tr>';
			$tbl1 .= '<tr>
			<td>'.$this->lang->line('left_shift_kantor').'</td>
			<td>'.$shift.'</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			</tr>';
		} else {
			$date = strtotime($payment[0]->gaji_bulan);
			$day = date('d', $date);
			$month = date('m', $date);
			$year = date('Y', $date);
			$daysInMonth = date('t',strtotime($payment[0]->gaji_bulan.'-01'));
			$imonth = date('F', $date);
			$r = $this->Umb_model->read_user_info($user[0]->user_id);
			$pcount = 0;
			$acount = 0;
			$lcount = 0;
			for($i = 1; $i <= $daysInMonth; $i++):
				$i = str_pad($i, 2, 0, STR_PAD_LEFT);
				$tanggal_kehadiran = $year.'-'.$month.'-'.$i;
				$get_day = strtotime($tanggal_kehadiran);
				$day = date('l', $get_day);
				$user_id = $r[0]->user_id;
				$shift_kantor_id = $r[0]->shift_kantor_id;
				$status_kehadiran = '';
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
				$chck_tanggal_cuti = $this->Timesheet_model->chcek_tanggal_cuti($user_id,$tanggal_kehadiran);
				$cuti_arr = array();
				if($chck_tanggal_cuti->num_rows() == 1){
					$tanggal_cuti = $this->Timesheet_model->tanggal_cuti($user_id,$tanggal_kehadiran);
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
				$shift_kantor = $this->Timesheet_model->read_informasi_shift_kantor($shift_kantor_id);
				$check = $this->Timesheet_model->check_kehadiran_pertama_masuk($user_id,$tanggal_kehadiran);
					// get libur>events
				if($shift_kantor[0]->senen_waktu_masuk == '' && $day == 'Monday') {
					$status = 'H';	
					$pcount += 0;
						//$lcount += 0;
				} else if($shift_kantor[0]->selasa_waktu_masuk == '' && $day == 'Tuesday') {
					$status = 'H';
					$pcount += 0;
						//$lcount += 0;
				} else if($shift_kantor[0]->rabu_waktu_masuk == '' && $day == 'Wednesday') {
					$status = 'H';
					$pcount += 0;
						//$lcount += 0;
				} else if($shift_kantor[0]->kamis_waktu_masuk == '' && $day == 'Thursday') {
					$status = 'H';
					$pcount += 0;
						//$lcount += 0;
				} else if($shift_kantor[0]->jumat_waktu_masuk == '' && $day == 'Friday') {
					$status = 'H';
					$pcount += 0;
						//$lcount += 0;
				} else if($shift_kantor[0]->sabtu_waktu_masuk == '' && $day == 'Saturday') {
					$status = 'H';
					$pcount += 0;
						//$lcount += 0;
				} else if($shift_kantor[0]->minggu_waktu_masuk == '' && $day == 'Sunday') {
					$status = 'H';
					$pcount += 0;
						//$lcount += 0;
				} else if(in_array($tanggal_kehadiran,$libur_arr)) {
					$status = 'H';
					$pcount += 0;
						//$lcount += 0;
				} else if(in_array($tanggal_kehadiran,$cuti_arr)) {
					$status = 'L';
					$pcount += 0;
						//$lcount += 1;
					//	$acount += 0;
				} else if($check->num_rows() > 0){
					$pcount += 1;
						//$lcount += 0;
				}	else {
					$status = 'A';
					//	$lcount += 0;
					$pcount += 0;
						// set to present date
					$itanggal_kehadiran = strtotime($tanggal_kehadiran);
					$icurrent_date = strtotime(date('Y-m-d'));
					if($itanggal_kehadiran <= $icurrent_date){
						$acount += 1;
					} else {
						$acount += 0;
					}
				}
			endfor;

			$tbl1 .= '<tr>
			<td>'.$this->lang->line('umb_karyawan_tgl_gabung').'</td>
			<td>'.$tanggal_bergabung.'</td>
			<td>'.$this->lang->line('umb_timesheet_workdays').'</td>
			<td>'.$pcount.'</td>
			</tr>';
		}
		$total_cuti = $this->Umb_model->total_cuti_slipgaji($payment[0]->gaji_bulan,$user_id);
		$tbl1 .= '<tr>
		<td>'.$this->lang->line('left_shift_kantor').'</td>
		<td>'.$shift.'</td>
		<td>'.$this->lang->line('umb_kehadiran_total_cuti').'</td>
		<td>'.$total_cuti.'</td>
		</tr>';
		$tbl1 .= '</table>';

		$pdf->writeHTML($tbl1, true, false, true, false, '');
		$count_cuti = $this->Umb_model->count_total_cuti_slipgaji($payment[0]->gaji_bulan,$user_id);
		if($count_cuti > 0) {
			$tbl1_lv = '
			<table cellpadding="3" cellspacing="0" border="1">
			<tr bgcolor="#69e48a">
			<td colspan="4" align="center"><strong>Details Cuti</strong></td>
			</tr>
			<tr bgcolor="#69e48a">
			<td>'.$this->lang->line('umb_type_cuti').'</td>
			<td>'.$this->lang->line('umb_title_from').'</td>
			<td>'.$this->lang->line('umb_title_to').'</td>
			<td>'.$this->lang->line('umb_hrastral_total_hari').'</td>
			</tr>';
			$res_cuti = $this->Umb_model->res_total_cuti_slipgaji($payment[0]->gaji_bulan,$user_id);
			foreach($res_cuti as $rcuti){
				$type_cuti = $this->Timesheet_model->read_informasi_type_cuti($rcuti->type_cuti_id);
				if(!is_null($type_cuti)){
					$type_name = $type_cuti[0]->type_name;
				} else {
					$type_name = '--';	
				}

				$datetime1 = new DateTime($rcuti->from_date);
				$datetime2 = new DateTime($rcuti->to_date);
				$interval = $datetime1->diff($datetime2);
				if(strtotime($rcuti->from_date) == strtotime($rcuti->to_date)){
					$no_of_days =1;
				} else {
					$no_of_days = $interval->format('%a') + 1;
				}
				if($rcuti->is_half_day == 1){
					$tbl1_lv .= '<tr>
					<td>'.$type_name.'</td>
					<td>'.$rcuti->from_date.'</td>
					<td>'.$rcuti->to_date.'</td>
					<td>'.$this->lang->line('umb_hr_cuti_setenga_hari').'</td>
					</tr>';
				} else {
					$tbl1_lv .= '<tr>
					<td>'.$type_name.'</td>
					<td>'.$rcuti->from_date.'</td>
					<td>'.$rcuti->to_date.'</td>
					<td>'.$no_of_days.'</td>
					</tr>';
				}
			}
			$tbl1_lv .= '</table>';	
			$pdf->writeHTML($tbl1_lv, true, false, true, false, '');	
		}

		$pdf->Ln(7);
		$tblbrk = '<table cellpadding="3" cellspacing="0" border="1"><tr bgcolor="#69e48a">
		<td colspan="2" align="center"><strong>'.$this->lang->line('umb_description').'</strong></td>
		<td align="center"><strong>'.$this->lang->line('umb_slipgaji_earning').'</strong></td>	
		<td align="center"><strong>'.$this->lang->line('umb_potongans').'</strong></td>			
		</tr>';
		if($payment[0]->type_slipgaji!='perjam'){
			$tblbrk .= '<tr>
			<td colspan="2">'.$this->lang->line('umb_payroll_gaji_pokok').'</td>
			<td align="center"  valign="bottom">'.$this->Umb_model->currency_sign($bs).'</td>	
			<td>&nbsp;</td>				
			</tr>';
		} else {
			$tblbrk .= '<tr>
			<td colspan="2">'.$this->lang->line('umb_payroll_nilai_perjam').' x '.$this->lang->line('umb_payroll_total_jam_bekerja').'<br> '.$this->Umb_model->currency_sign($bs).' x '.$hcount.'</td>
			<td align="center"  valign="bottom">'.$this->Umb_model->currency_sign($total_count).'</td>	
			<td>&nbsp;</td>				
			</tr>';
		}			
			//tunjanagans
		if($count_tunjanagans > 0) {
			foreach($tunjanagans->result() as $sl_tunjanagans) {
				if($sl_tunjanagans->jumlah_option==0){
					$jumlah_tunjanagan_opt = $this->lang->line('umb_title_fixed_pajak');
				} else {
					$jumlah_tunjanagan_opt = $this->lang->line('umb_title_percent_pajak');
				}
				if($sl_tunjanagans->is_tunjanagan_kena_pajak==0){
					$tunjanagan_opt = $this->lang->line('umb_gaji_tunjanagan_todak_kena_pajak');
				} else if($sl_tunjanagans->is_tunjanagan_kena_pajak==1){
					$tunjanagan_opt = $this->lang->line('umb_fully_kena_pajak');
				} else {
					$tunjanagan_opt = $this->lang->line('umb_partially_kena_pajak');
				}
				if($sl_tunjanagans->is_tunjanagan_kena_pajak == 1) {
					if($sl_tunjanagans->jumlah_option == 0) {
						$ijumlah_tunjanagan = $sl_tunjanagans->jumlah_tunjanagan;
					} else {
						$ijumlah_tunjanagan = $bs / 100 * $sl_tunjanagans->jumlah_tunjanagan;
					}
					$jumlah_tunjanagan += 0;
					$dejumlah_tunjanagan -= $ijumlah_tunjanagan;
					$add_potongan_tunjanagan += $ijumlah_tunjanagan;
					$tblbrk .= '<tr>
					<td colspan="2">'.$sl_tunjanagans->title_tunjanagan.' ('.$jumlah_tunjanagan_opt.') ('.$tunjanagan_opt.')</td>

					<td>&nbsp;</td>			
					<td align="center">'.$this->Umb_model->currency_sign($ijumlah_tunjanagan).'</td>		
					</tr>';
				} else if($sl_tunjanagans->is_tunjanagan_kena_pajak == 2) {
					if($sl_tunjanagans->jumlah_option == 0) {
						$ijumlah_tunjanagan = $sl_tunjanagans->jumlah_tunjanagan / 2;
					} else {
						$ijumlah_tunjanagan = ($bs / 100) / 2 * $sl_tunjanagans->jumlah_tunjanagan;
					}
					$jumlah_tunjanagan += 0;
					$dejumlah_tunjanagan -= $ijumlah_tunjanagan;
					$add_potongan_tunjanagan += $ijumlah_tunjanagan;
					$tblbrk .= '<tr>
					<td colspan="2">'.$sl_tunjanagans->title_tunjanagan.' ('.$jumlah_tunjanagan_opt.') ('.$tunjanagan_opt.')</td>

					<td>&nbsp;</td>			
					<td align="center">'.$this->Umb_model->currency_sign($ijumlah_tunjanagan).'</td>		
					</tr>';
				} else {
					if($sl_tunjanagans->jumlah_option == 0) {
						$ijumlah_tunjanagan = $sl_tunjanagans->jumlah_tunjanagan;
					} else {
						$ijumlah_tunjanagan = $bs / 100 * $sl_tunjanagans->jumlah_tunjanagan;
					}
					$jumlah_tunjanagan += $ijumlah_tunjanagan; 
					$dejumlah_tunjanagan += 0;
					$add_potongan_tunjanagan += 0;
					$tblbrk .= '<tr>
					<td colspan="2">'.$sl_tunjanagans->title_tunjanagan.' ('.$jumlah_tunjanagan_opt.') ('.$tunjanagan_opt.')</td>
					<td align="center">'.$this->Umb_model->currency_sign($ijumlah_tunjanagan).'</td>	
					<td>&nbsp;</td>				
					</tr>';

				}
			}
		}

		if($count_komissi > 0) {
			foreach($komissi->result() as $sl_komissi) {
				if($sl_komissi->jumlah_option==0){
					$opt_jumlah_komisi = $this->lang->line('umb_title_fixed_pajak');
				} else {
					$opt_jumlah_komisi = $this->lang->line('umb_title_percent_pajak');
				}
				if($sl_komissi->is_komisi_kena_pajak==0){
					$opt_komisi = $this->lang->line('umb_gaji_tunjanagan_todak_kena_pajak');
				} else if($sl_komissi->is_komisi_kena_pajak==1){
					$opt_komisi = $this->lang->line('umb_fully_kena_pajak');
				} else {
					$opt_komisi = $this->lang->line('umb_partially_kena_pajak');
				}
				if($sl_komissi->is_komisi_kena_pajak == 1) {
					if($sl_komissi->jumlah_option == 0) {
						$ejumlah_komissi = $sl_komissi->jumlah_komisi;
					} else {
						$ejumlah_komissi = $bs / 100 * $sl_komissi->jumlah_komisi;
					}
					$jumlah_komissi += 0;
					$dejumlah_komissi -= $ejumlah_komissi;
					$add_deduct_jumlah_komissi += $ejumlah_komissi;
					$tblbrk .= '<tr>
					<td colspan="2">'.$sl_komissi->komisi_title.' ('.$opt_jumlah_komisi.') ('.$opt_komisi.')</td>
					<td>&nbsp;</td>				
					<td align="center">'.$this->Umb_model->currency_sign($ejumlah_komissi).'</td>
					</tr>';
				} else if($sl_komissi->is_komisi_kena_pajak == 2) {
					if($sl_komissi->jumlah_option == 0) {
						$ejumlah_komissi = $sl_komissi->jumlah_komisi / 2;
					} else {
						$ejumlah_komissi = ($bs / 100) / 2 * $sl_komissi->jumlah_komisi;
					}
					$jumlah_komissi += 0;
					$dejumlah_komissi -= $ejumlah_komissi; 
					$add_deduct_jumlah_komissi += $ejumlah_komissi;
					$tblbrk .= '<tr>
					<td colspan="2">'.$sl_komissi->komisi_title.' ('.$opt_jumlah_komisi.') ('.$opt_komisi.')</td>	
					<td>&nbsp;</td>
					<td align="center">'.$this->Umb_model->currency_sign($ejumlah_komissi).'</td>
					</tr>';
				} else {
					if($sl_komissi->jumlah_option == 0) {
						$ejumlah_komissi = $sl_komissi->jumlah_komisi;
					} else {
						$ejumlah_komissi = $bs / 100 * $sl_komissi->jumlah_komisi;
					}
					$jumlah_komissi += $ejumlah_komissi;
					$dejumlah_komissi += 0;
					$add_deduct_jumlah_komissi += 0;
					$tblbrk .= '<tr>
					<td colspan="2">'.$sl_komissi->komisi_title.' ('.$opt_jumlah_komisi.') ('.$opt_komisi.')</td>
					<td align="center">'.$this->Umb_model->currency_sign($ejumlah_komissi).'</td>	
					<td>&nbsp;</td>				
					</tr>';
				}


			}
		}

		if($count_pembayarans_lainnya > 0) {
			foreach($pembayarans_lainnya->result() as $sl_pembayarans_lainnya) {
				if($sl_pembayarans_lainnya->jumlah_option==0){
					$opt_jumlah_lainnya = $this->lang->line('umb_title_fixed_pajak');
				} else {
					$opt_jumlah_lainnya = $this->lang->line('umb_title_percent_pajak');
				}
				if($sl_pembayarans_lainnya->ia_pembayaranlainnya_kena_pajak==0){
					$other_opt = $this->lang->line('umb_gaji_tunjanagan_todak_kena_pajak');
				} else if($sl_pembayarans_lainnya->ia_pembayaranlainnya_kena_pajak==1){
					$other_opt = $this->lang->line('umb_fully_kena_pajak');
				} else {
					$other_opt = $this->lang->line('umb_partially_kena_pajak');
				}
				if($sl_pembayarans_lainnya->ia_pembayaranlainnya_kena_pajak == 1) {
					if($sl_pembayarans_lainnya->jumlah_option == 0) {
						$ejumlah_pembayarans = $sl_pembayarans_lainnya->jumlah_pembayarans;
					} else {
						$ejumlah_pembayarans = $bs / 100 * $sl_pembayarans_lainnya->jumlah_pembayarans;
					}
					$dejumlah_pembayarans_lainnya -= $ejumlah_pembayarans; 
					$jumlah_pembayarans_lainnya += 0;
					$add_deduct_jumlah_pembayarans_lainnya += $ejumlah_pembayarans;
					$tblbrk .= '<tr>
					<td colspan="2">'.$sl_pembayarans_lainnya->title_pembayarans.' ('.$opt_jumlah_lainnya.') ('.$other_opt.')</td>	
					<td>&nbsp;</td>				
					<td align="center">'.$this->Umb_model->currency_sign($ejumlah_pembayarans).'</td>
					</tr>';
				} else if($sl_pembayarans_lainnya->ia_pembayaranlainnya_kena_pajak == 2) {
					if($sl_pembayarans_lainnya->jumlah_option == 0) {
						$ejumlah_pembayarans = $sl_pembayarans_lainnya->jumlah_pembayarans / 2;
					} else {
						$ejumlah_pembayarans = ($bs / 100) / 2 * $sl_pembayarans_lainnya->jumlah_pembayarans;
					}
					$dejumlah_pembayarans_lainnya -= $ejumlah_pembayarans; 
					$jumlah_pembayarans_lainnya += 0;
					$add_deduct_jumlah_pembayarans_lainnya += $ejumlah_pembayarans;
					$tblbrk .= '<tr>
					<td colspan="2">'.$sl_pembayarans_lainnya->title_pembayarans.' ('.$opt_jumlah_lainnya.') ('.$other_opt.')</td>
					<td>&nbsp;</td>	
					<td align="center">'.$this->Umb_model->currency_sign($ejumlah_pembayarans).'</td>			
					</tr>';
				} else {
					if($sl_pembayarans_lainnya->jumlah_option == 0) {
						$ejumlah_pembayarans = $sl_pembayarans_lainnya->jumlah_pembayarans;
					} else {
						$ejumlah_pembayarans = $bs / 100 * $sl_pembayarans_lainnya->jumlah_pembayarans;
					}
					$jumlah_pembayarans_lainnya += $ejumlah_pembayarans;
					$dejumlah_pembayarans_lainnya += 0;
					$add_deduct_jumlah_pembayarans_lainnya += 0;
					$tblbrk .= '<tr>
					<td colspan="2">'.$sl_pembayarans_lainnya->title_pembayarans.' ('.$opt_jumlah_lainnya.') ('.$other_opt.')</td>
					<td align="center">'.$this->Umb_model->currency_sign($ejumlah_pembayarans).'</td>	
					<td>&nbsp;</td>				
					</tr>';
				}
			}
		}

		if($count_statutory_potongans > 0) {
			foreach($statutory_potongans->result() as $sl_statutory_potongans) {
				if($sl_statutory_potongans->statutory_options == 0) {
					$st_jumlah = $sl_statutory_potongans->jumlah_potongan;
				} else {
					$st_jumlah = $bs / 100 * $sl_statutory_potongans->jumlah_potongan;
				}
				$jumlah_statutory_potongan += $st_jumlah;
				if($sl_statutory_potongans->statutory_options==0){
					$opt_jumlah_sd = $this->lang->line('umb_title_fixed_pajak');
				} else {
					$opt_jumlah_sd = $this->lang->line('umb_title_percent_pajak');
				}
				$tblbrk .= '<tr>
				<td colspan="2">'.$sl_statutory_potongans->title_potongan.' ('.$opt_jumlah_sd.')</td>
				<td>&nbsp;</td>
				<td align="center">'.$this->Umb_model->currency_sign($st_jumlah).'</td>			
				</tr>';
			}
		}

		if($count_lembur > 0) {
			foreach($lembur->result() as $r_lembur) {
				$total_lembur = $r_lembur->jam_lembur * $r_lembur->nilai_lembur;
				$tblbrk .= '<tr>
				<td colspan="2">'.$r_lembur->title_lembur.'</td>
				<td align="center">'.$this->Umb_model->currency_sign($total_lembur).'</td>	
				<td>&nbsp;</td>				
				</tr>';
			}
		}

		if($count_pinjaman > 0) {
			foreach($loan->result() as $r_pinjaman) {
				$tblbrk .= '<tr>
				<td colspan="2">'.$r_pinjaman->pinjaman_title.'</td>
				<td>&nbsp;</td>	
				<td align="center">'.$this->Umb_model->currency_sign($r_pinjaman->pinjaman_jumlah).'</td>	
				</tr>';
			}
		}
		if($payment[0]->is_potong_advance_gaji==1){
			$tblbrk .= '<tr>
			<td colspan="2">'.$this->lang->line('umb_potongan_advance_gaji').'</td>
			<td>&nbsp;</td>	
			<td align="center">'.$this->Umb_model->currency_sign($payment[0]->jumlah_advance_gaji).'</td>	
			</tr>';
			$advance_gaji_tkn = $payment[0]->jumlah_advance_gaji;
		} else {
			$advance_gaji_tkn = 0;
		}
		if($payment[0]->type_slipgaji=='perjam'){
			$total_earning = $bs + $jumlah_tunjanagan + $jumlah_lembur + $jumlah_komissi + $jumlah_pembayarans_lainnya;
			$total_potongan = $jumlah_ptng_pinjaman + $jumlah_statutory_potongan + $add_deduct_jumlah_pembayarans_lainnya + $add_deduct_jumlah_komissi + $add_potongan_tunjanagan;
			$total_gaji_bersih = $total_earning - $total_potongan;
			$etotal_count = $hcount * $bs;
			$fgaji = $etotal_count + $total_gaji_bersih;
			$etotal_earning = $total_earning + $etotal_count;

			$tblbrk .= '
			<tr><td colspan="2" align="center"><strong>Total</strong></td>
			<td align="center"><strong>'.$this->Umb_model->currency_sign($etotal_earning).'</strong></td>
			<td align="center"><strong>'.$this->Umb_model->currency_sign($total_potongans).'</strong></td>	
			</tr></table>
			<table cellpadding="3" cellspacing="0" border="1">
			<tr><td colspan="2" align="center">&nbsp;</td>
			<td colspan="2" align="center" bgcolor="#69e48a"><strong>NET PAY</strong></td>
			</tr><tr><td colspan="2" align="center">'.ucwords($this->Umb_model->convertNumberToWord($fgaji)).'</td>
			<td colspan="2" align="center"><strong>'.$this->Umb_model->currency_sign($fgaji).'</strong></td>
			</tr></table>';
		} else {
			$total_earning = $bs + $jumlah_tunjanagan + $jumlah_lembur + $jumlah_komissi + $jumlah_pembayarans_lainnya;
			$total_potongan = $jumlah_ptng_pinjaman + $jumlah_statutory_potongan + $add_deduct_jumlah_pembayarans_lainnya + $add_deduct_jumlah_komissi + $add_potongan_tunjanagan + $advance_gaji_tkn;
			$total_gaji_bersih = $total_earning - $total_potongan;
			$tblbrk .= '
			<tr><td colspan="2" align="center"><strong>Total</strong></td>
			<td align="center"><strong>'.$this->Umb_model->currency_sign($total_earning).'</strong></td>
			<td align="center"><strong>'.$this->Umb_model->currency_sign($total_potongan).'</strong></td>	
			</tr></table>
			<table cellpadding="3" cellspacing="0" border="1">
			<tr><td colspan="2" align="center">&nbsp;</td>
			<td colspan="2" align="center" bgcolor="#69e48a"><strong>NET PAY</strong></td>
			</tr><tr><td colspan="2" align="center">'.ucwords($this->Umb_model->convertNumberToWord($total_gaji_bersih)).'</td>
			<td colspan="2" align="center"><strong>'.$this->Umb_model->currency_sign($total_gaji_bersih).'</strong></td>
			</tr></table>';
		}
		$pdf->writeHTML($tblbrk, true, false, true, false, '');
		$tbl = '
		<table cellpadding="5" cellspacing="0" border="0">
		<tr>
		<td align="right" colspan="1">Ini adalah Slip Gaji yang dibuat oleh komputer dan tidak memerlukan tanda tangan.</td>
		</tr>
		</table>';
		$pdf->writeHTML($tbl, true, false, false, false, '');

		$fname = strtolower($fname);
		$pay_month = strtolower(date("F Y", strtotime($payment[0]->year_to_date)));
		ob_start();
		$pdf->Output('slipgaji_'.$fname.'_'.$pay_month.'.pdf', 'I');
		ob_end_flush();
	}

	public function pdf_createv2(){

		//$this->load->library('Pdf');
		$system = $this->Umb_model->read_setting_info(1);		
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$id = $this->uri->segment(5);
		$payment = $this->Payroll_model->read_gaji_info_slipgaji($id);
		$user = $this->Umb_model->read_user_info($payment[0]->karyawan_id);
		if($system[0]->is_generate_password_slipgaji==1) {

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
		if(!is_null($_tunjuk_nama)){
			$_nama_penunjukan = $_tunjuk_nama[0]->nama_penunjukan;
		} else {
			$_nama_penunjukan = '';
		}
		$department = $this->Department_model->read_informasi_department($user[0]->department_id);
		if(!is_null($department)){
			$_nama_department = $department[0]->nama_department;
		} else {
			$_nama_department = '';
		}
		//$location = $this->Umb_model->read_info_location($department[0]->location_id);
		$perusahaan = $this->Umb_model->read_info_perusahaan($user[0]->perusahaan_id);
		$p_method = '';
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
		//$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
		$c_info_alamat = $alamat_1.' '.$alamat_2.', '.$kota.' - '.$kode_pos.', '.$nama_negara;
		$email_phone_address = "".$this->lang->line('dashboard_email')." : $c_info_email | ".$this->lang->line('umb_phone')." : $c_info_phone \n".$this->lang->line('umb_alamat').": $c_info_alamat";
		$header_string = $email_phone_address;		
		$pdf->SetCreator('HRASTRAL');
		$pdf->SetAuthor('HRASTRAL');
		//$pdf->SetTitle('Workable-Zone - slipgaji');
		//$pdf->SetSubject('TCPDF Tutorial');
		//$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
		$pdf->SetHeaderData('../../../uploads/logo/payroll/'.$system[0]->logo_payroll, 40, $nama_perusahaan, $header_string);
		$pdf->setFooterData(array(0,64,0), array(0,64,128));
		$pdf->setHeaderFont(Array('helvetica', '', 11.5));
		$pdf->setFooterFont(Array('helvetica', '', 9));
		$pdf->SetDefaultMonospacedFont('courier');
		
		$pdf->SetMargins(15, 27, 15);
		$pdf->SetHeaderMargin(5);
		$pdf->SetFooterMargin(10);
		
		$pdf->SetAutoPageBreak(TRUE, 25);
		
		$pdf->setImageScale(1.25);
		$pdf->SetAuthor('HRASTRAL');
		$pdf->SetTitle($nama_perusahaan.' - '.$this->lang->line('umb_print_slipgaji'));
		$pdf->SetSubject($this->lang->line('umb_slipgaji'));
		$pdf->SetKeywords($this->lang->line('umb_slipgaji'));
		$pdf->SetFont('helvetica', 'B', 10);
		
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		$pdf->setFontSubsetting(true);
		$pdf->SetFont('dejavusans', '', 10, '', true);
		$pdf->AddPage();		
		$fname = $user[0]->first_name.' '.$user[0]->last_name;
		$created_at = $this->Umb_model->set_date_format($payment[0]->created_at);
		$tanggal_bergabung = $this->Umb_model->set_date_format($user[0]->tanggal_bergabung);
		$gaji_bulan = $this->Umb_model->set_date_format($payment[0]->gaji_bulan);
		$bs=0;
		if($payment[0]->gaji_pokok != '') {
			$bs = $payment[0]->gaji_pokok;
		} else {
			$bs = $payment[0]->upahh_harian;
		}

		$count_tunjanagans = $this->Karyawans_model->count_karyawan_tunjanagans_slipgaji($payment[0]->slipgaji_id);
		$tunjanagans = $this->Karyawans_model->set_tunjanagans_karyawan_slipgaji($payment[0]->slipgaji_id);

		$count_komissi = $this->Karyawans_model->count_karyawan_komissi_slipgaji($payment[0]->slipgaji_id);
		$komissi = $this->Karyawans_model->set_komissi_karyawan_slipgaji($payment[0]->slipgaji_id);

		$count_pembayarans_lainnya = $this->Karyawans_model->count_karyawan_pembayarans_lainnya_slipgaji($payment[0]->slipgaji_id);
		$pembayarans_lainnya = $this->Karyawans_model->set_karyawan_pembayarans_lainnya_slipgaji($payment[0]->slipgaji_id);

		$count_statutory_potongans = $this->Karyawans_model->count_karyawan_statutory_potongans_slipgaji($payment[0]->slipgaji_id);
		$statutory_potongans = $this->Karyawans_model->set_karyawan_statutory_potongans_slipgaji($payment[0]->slipgaji_id);

		$count_lembur = $this->Karyawans_model->count_karyawan_lembur_slipgaji($payment[0]->slipgaji_id);
		$lembur = $this->Karyawans_model->set_karyawan_lembur_slipgaji($payment[0]->slipgaji_id);

		$count_pinjaman = $this->Karyawans_model->count_karyawan_potongans_slipgaji($payment[0]->slipgaji_id);
		$loan = $this->Karyawans_model->set_potongans_karyawan_slipgaji($payment[0]->slipgaji_id);

		$jumlah_statutory_potongan = 0; $jumlah_ptng_pinjaman = 0; $jumlah_tunjanagans = 0;
		$jumlah_komissi = 0; $jumlah_pembayarans_lainnya = 0; $jumlah_lembur = 0;		

		if($count_pinjaman > 0):
			foreach($loan->result() as $r_pinjaman) {
				$jumlah_ptng_pinjaman += $r_pinjaman->pinjaman_jumlah;
			}	
			$jumlah_ptng_pinjaman = $jumlah_ptng_pinjaman;
		else:
			$jumlah_ptng_pinjaman = 0;
		endif;

		$jumlah_tunjanagans = 0; foreach($tunjanagans->result() as $sl_tunjanagans) {
			$jumlah_tunjanagans += $sl_tunjanagans->jumlah_tunjanagan;
		}

		$jumlah_komissi = 0; foreach($komissi->result() as $sl_komissi) {
			$jumlah_komissi += $sl_komissi->jumlah_komisi;
		}

		$jumlah_statutory_potongan = 0; foreach($statutory_potongans->result() as $sl_statutory_potongans) {
			//$jumlah_statutory_potongan += $sl_statutory_potongans->jumlah_potongan;
			if($system[0]->statutory_fixed!='yes'):
				$sta_gaji = $bs;
				$st_jumlah = $sta_gaji / 100 * $sl_statutory_potongans->jumlah_potongan;
				$jumlah_statutory_potongan += $st_jumlah;
			else:
				$jumlah_statutory_potongan += $sl_statutory_potongans->jumlah_potongan;
			endif;
		}

		$jumlah_pembayarans_lainnya = 0; foreach($pembayarans_lainnya->result() as $sl_pembayarans_lainnya) {
			$jumlah_pembayarans_lainnya += $sl_pembayarans_lainnya->jumlah_pembayarans;
		}

		$jumlah_lembur = 0; foreach($lembur->result() as $r_lembur) {
			$total_lembur = $r_lembur->jam_lembur * $r_lembur->nilai_lembur;
			$jumlah_lembur += $total_lembur;
		}
		$tbl = '<br><br>
		<table cellpadding="1" cellspacing="1" border="0">
		<tr>
		<td align="center"><h1>'.$this->lang->line('umb_slipgaji').'</h1></td>
		</tr>
		<tr>
		<td align="center"><strong>'.$this->lang->line('umb_slipgaji_number').':</strong> #'.$payment[0]->slipgaji_id.'</td>
		</tr>
		<tr>
		<td align="center"><strong>'.$this->lang->line('umb_gaji_bulan').':</strong> '.date("F Y", strtotime($payment[0]->year_to_date)).'</td>
		</tr>
		</table>
		';
		$pdf->writeHTML($tbl, true, false, false, false, '');

		$pdf->setCellPaddings(1, 1, 1, 1);
		
		$pdf->setCellMargins(0, 0, 0, 0);
		
		$pdf->SetFillColor(255, 255, 127);
		$txt = 'Details Karyawan';

		$pdf->MultiCell(180, 6, $txt, 0, 'L', 11, 0, '', '', true);
		$pdf->Ln(7);
		$tbl1 = '
		<table cellpadding="3" cellspacing="0" border="1">
		<tr>
		<td>'.$this->lang->line('umb_name').'</td>
		<td>'.$fname.'</td>
		<td>'.$this->lang->line('dashboard_karyawan_id').'</td>
		<td>'.$user[0]->karyawan_id.'</td>
		</tr>
		<tr>
		<td>'.$this->lang->line('left_department').'</td>
		<td>'.$_nama_department.'</td>
		<td>'.$this->lang->line('left_penunjukan').'</td>
		<td>'.$_nama_penunjukan.'</td>
		</tr>
		<tr>
		<td>'.$this->lang->line('umb_e_details_tanggal').'</td>
		<td>'.date("d F, Y").'</td>
		<td>'.$this->lang->line('umb_slipgaji_number').'</td>
		<td>'.$payment[0]->slipgaji_id.'</td>
		</tr>
		</table>
		';
		
		$pdf->writeHTML($tbl1, true, false, true, false, '');
		
		$total_earning = $bs + $jumlah_tunjanagans + $jumlah_komissi + $jumlah_pembayarans_lainnya + $jumlah_lembur;	
		$total_potongans = $jumlah_ptng_pinjaman + $jumlah_statutory_potongan;
		$pdf->Ln(7);
		$tblc = '<table cellpadding="3" cellspacing="0" border="1"><tr>
		<td colspan="2">'.$this->lang->line('umb_payroll_total_earning').'</td>
		<td colspan="2">'.$this->lang->line('umb_payroll_total_potongans').'</td>				
		</tr>
		<tr>
		<td colspan="2">'.$this->Umb_model->currency_sign($total_earning).'</td>
		<td colspan="2">'.$this->Umb_model->currency_sign($total_potongans).'</td>				
		</tr>
		</table>';
		$pdf->writeHTML($tblc, true, false, true, false, '');
		
		if(null!=$this->uri->segment(4) && $this->uri->segment(4)=='p') {
			$tbl2 = '';
			$txt = 'Details Slipgaji';

			$pdf->MultiCell(180, 6, $txt, 0, 'L', 11, 0, '', '', true);
			$pdf->Ln(7);
			$tbl2 .= '
			<table cellpadding="3" cellspacing="0" border="1">';
			if($payment[0]->type_upahh == 1){
				$tbl2 .= ' <tr>
				<td colspan="2">&nbsp;</td>
				<td>'.$this->lang->line('umb_payroll_gaji_pokok').'</td>
				<td align="right">'.$this->Umb_model->currency_sign($payment[0]->gaji_pokok).'</td>
				</tr>';
			} else {
				$tbl2 .= ' <tr>
				<td colspan="2">&nbsp;</td>
				<td>'.$this->lang->line('umb_karyawan_upahh_harian').'</td>
				<td align="right">'.$this->Umb_model->currency_sign($payment[0]->upahh_harian).'</td>
				</tr>';
			}
			if($payment[0]->total_tunjanagans!=0 || $payment[0]->total_tunjanagans!=''):
				$tbl2 .= '<tr>
				<td colspan="2">&nbsp;</td>
				<td>'.$this->lang->line('umb_payroll_total_tunjanagan').'</td>
				<td align="right">'.$this->Umb_model->currency_sign($payment[0]->total_tunjanagans).'</td>
				</tr>';
			endif;
			if($payment[0]->total_komissi!=0 || $payment[0]->total_komissi!=''):
				$tbl2 .= '<tr>
				<td colspan="2">&nbsp;</td>
				<td>'.$this->lang->line('umb_hr_komissi').'</td>
				<td align="right">'.$this->Umb_model->currency_sign($payment[0]->total_komissi).'</td>
				</tr>';
			endif;
			if($payment[0]->total_pinjaman!=0 || $payment[0]->total_pinjaman!=''):
				$tbl2 .= '<tr>
				<td colspan="2">&nbsp;</td>
				<td>'.$this->lang->line('umb_payroll_total_pinjaman').'</td>
				<td align="right">'.$this->Umb_model->currency_sign($payment[0]->total_pinjaman).'</td>
				</tr>';
			endif;
			if($payment[0]->total_lembur!=0 || $payment[0]->total_lembur!=''):
				$tbl2 .= '<tr>
				<td colspan="2">&nbsp;</td>
				<td>'.$this->lang->line('umb_payroll_total_lembur').'</td>
				<td align="right">'.$this->Umb_model->currency_sign($payment[0]->total_lembur).'</td>
				</tr>';
			endif;
			if($payment[0]->total_statutory_potongans!=0 || $payment[0]->total_statutory_potongans!=''):
				$tbl2 .= '<tr>
				<td colspan="2">&nbsp;</td>
				<td>'.$this->lang->line('umb_karyawan_set_statutory_potongans').'</td>
				<td align="right">'.$this->Umb_model->currency_sign($payment[0]->total_statutory_potongans).'</td>
				</tr>';
			endif;
			if($payment[0]->total_pembayarans_lainnya!=0 || $payment[0]->total_pembayarans_lainnya!=''):
				$tbl2 .= '<tr>
				<td colspan="2">&nbsp;</td>
				<td>'.$this->lang->line('umb_karyawan_set_pembayaran_lainnya').'</td>
				<td align="right">'.$this->Umb_model->currency_sign($payment[0]->total_pembayarans_lainnya).'</td>
				</tr>';
			endif;
			/*if($payment[0]->type_upahh == 1){
				$bs = $payment[0]->gaji_pokok;
			} else {
				$bs = $payment[0]->upahh_harian;
			}*/
			$total_earning = $bs + $jumlah_tunjanagans + $jumlah_lembur + $jumlah_komissi + $jumlah_pembayarans_lainnya;
			$total_potongan = $jumlah_ptng_pinjaman + $jumlah_statutory_potongan;
			$total_gaji_bersih = $total_earning - $total_potongan;
			$tbl2 .= '<tr>
			<td colspan="2">&nbsp;</td>
			<td>'.$this->lang->line('umb_payroll_gaji_bersih').'</td>
			<td align="right">'.$this->Umb_model->currency_sign(number_format($total_gaji_bersih, 2, '.', ',')).'</td>
			</tr>
			</table>
			';
			$pdf->writeHTML($tbl2, true, false, false, false, '');
		}		
		$tbl = '
		<table cellpadding="5" cellspacing="0" border="0">
		<tr>
		<td align="right" colspan="1">Ini adalah Slip Gaji yang dibuat oleh komputer dan tidak memerlukan tanda tangan.</td>
		</tr>
		</table>';
		$pdf->writeHTML($tbl, true, false, false, false, '');
		
		$fname = strtolower($fname);
		$pay_month = strtolower(date("F Y", strtotime($payment[0]->year_to_date)));
		ob_start();
		$pdf->Output('slipgaji_'.$fname.'_'.$pay_month.'.pdf', 'I');
		ob_end_flush();
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
	
	public function view_melakukan_pembayaran() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$id = $this->input->get('pay_id');
		// $data['all_negaraa'] = $this->Umb_model->get_negaraa();
		$result = $this->Payroll_model->read_informasi_melakukan_pembayaran($id);

		$user = $this->Umb_model->read_user_info($result[0]->karyawan_id);

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
			'nama_department' => $nama_department,
			'nama_penunjukan' => $nama_penunjukan,
			'tanggal_bergabung' => $user[0]->tanggal_bergabung,
			'profile_picture' => $user[0]->profile_picture,
			'jenis_kelamin' => $user[0]->jenis_kelamin,
			'monthly_grade_id' => $user[0]->monthly_grade_id,
			'hourly_grade_id' => $user[0]->hourly_grade_id,
			'gaji_pokok' => $result[0]->gaji_pokok,
			//'is_half_monthly' => $user[0]->is_half_monthly,
			//'potong_setengah_bulan' => $user[0]->potong_setengah_bulan,
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

	public function delete_all_slipgaji($id) {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $id;
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$this->Payroll_model->delete_record($id);
		$this->Payroll_model->delete_slipgaji_tunjanagans_items($id);
		$this->Payroll_model->delete_slipgaji_komissi_items($id);
		$this->Payroll_model->delete_slipgaji_pembayaran_lainnya_items($id);
		$this->Payroll_model->delete_slipgaji_statutory_potongans_items($id);
		$this->Payroll_model->delete_slipgaji_lembur_items($id);
		$this->Payroll_model->delete_slipgaji_pinjaman_items($id);
	}
	
	public function get_perusahaan_p_locations() {

		$data['title'] = $this->Umb_model->site_title();
		$keywords = preg_split("/[\s,]+/", $this->uri->segment(4));
		if(is_numeric($keywords[0])) {
			$id = $keywords[0];
			
			$data = array(
				'perusahaan_id' => $id
			);
			$session = $this->session->userdata('username');
			if(!empty($session)){ 
				$data = $this->security->xss_clean($data);
				$this->load->view("admin/payroll/get_perusahaan_p_locations", $data);
			} else {
				redirect('admin/');
			}
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}

	public function get_location_pdepartments() {

		$data['title'] = $this->Umb_model->site_title();
		$keywords = preg_split("/[\s,]+/", $this->uri->segment(4));
		if(is_numeric($keywords[0])) {
			$id = $keywords[0];
			
			$data = array(
				'location_id' => $id
			);
			$session = $this->session->userdata('username');
			if(!empty($session)){ 
				$data = $this->security->xss_clean($data);
				$this->load->view("admin/payroll/get_location_pdepartments", $data);
			} else {
				redirect('admin/');
			}
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}

	public function get_departemen_ppenunjukans() {

		$data['title'] = $this->Umb_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'department_id' => $id,
			'all_penunjukans' => $this->Penunjukan_model->all_penunjukans(),
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/payroll/get_departemen_ppenunjukans", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}
	
	
	public function update_status_payroll() {
		
		if($this->input->post('type')=='update_status') {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();	
			if($this->input->post('status')==='') {
				$Return['error'] = $this->lang->line('umb_error_template_status');
			}	
			if($Return['error']!=''){
				$this->output($Return);
			}
			$data = array(
				'status' => $this->input->post('status'),
			);
			$id = $this->input->post('payroll_id');
			$result = $this->Payroll_model->update_status_payroll($data,$id);
			if ($result == TRUE) {
				if($this->input->post('status') == 1){
					$Return['result'] = $this->lang->line('umb_role_first_level_approved');
				} else if($this->input->post('status') == 2) {
					$Return['result'] = $this->lang->line('umb_approved_final_payroll_title');
				} else {
					$Return['result'] = $this->lang->line('umb_disabled_payroll_title');
				}
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function get_advance_karyawans() {

		$data['title'] = $this->Umb_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'perusahaan_id' => $id
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/payroll/get_advance_karyawans", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
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
				'status' => 0,
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
	
	public function update_advance_gaji() {
		
		if($this->input->post('edit_type')=='advance_gaji') {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			
			$reason = $this->input->post('reason');
			$qt_reason = htmlspecialchars(addslashes($reason), ENT_QUOTES);
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
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
				'angsuran_bulanan' => $angsuran_bulanan,
				'pengurangan_satu_kali' => $this->input->post('pengurangan_satu_kali'),
				'advance_jumlah' => $this->input->post('jumlah'),
				'status' => $this->input->post('status')
			);
			
			$result = $this->Payroll_model->updated_payroll_advance_gaji($data,$id);
			
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_sukses_advance_gaji_diperbarui');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function delete_advance_gaji() {
		
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$result = $this->Payroll_model->delete_record_advance_gaji($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('umb_sukses_advance_gaji_dihapus');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');;
		}
		$this->output($Return);
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
			$this->load->view('admin/payroll/dialog_advance_gaji', $data);
		} else {
			redirect('admin/');
		}
	}
	
	public function read_laporan_advance_gaji() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
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
			$this->load->view('admin/payroll/dialog_advance_gaji', $data);
		} else {
			redirect('admin/');
		}
	}
}
