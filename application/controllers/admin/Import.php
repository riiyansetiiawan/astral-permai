<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Import extends MY_Controller {


	public function output($Return=array()){
		
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		
		exit(json_encode($Return));
	}
	
	public function __construct() {
		parent::__construct();

		$this->load->model("Karyawans_model");
		$this->load->model("Umb_model");
		$this->load->model("Department_model");
		$this->load->model("Penunjukan_model");
		$this->load->model("Roles_model");
		$this->load->model("Location_model");
		$this->load->model("Perusahaan_model");
		$this->load->model("Timesheet_model");
		$this->load->model("Custom_fields_model");
		$this->load->model("Assets_model");
		$this->load->model("Training_model");
		$this->load->model("Trainers_model");
		$this->load->library("pagination");
		$this->load->model("Awards_model");
		$this->load->model("Perjalanan_model");
		$this->load->model("Tickets_model");
		$this->load->model("Transfers_model");
		$this->load->model("Promotion_model");
		$this->load->model("Keluhans_model");
		$this->load->model("Peringatan_model");
		$this->load->model("Project_model");
		$this->load->model("Payroll_model");
		$this->load->model("Events_model");
		$this->load->model("Meetings_model");
		$this->load->model('Eumb_model');
		$this->load->library('Pdf');
		$this->load->helper('string');
	}

	public function index() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('umb_hr_imports').' | '.$this->Umb_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('umb_hr_imports');
		$data['path_url'] = 'hrastral_import';
		$data['all_perusahaans'] = $this->Umb_model->get_perusahaans();
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('111',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/layout/hrastral_import", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 
		} else {
			redirect('admin/dashboard');
		}
	}	 
	
	public function import_karyawans() {

		if($this->input->post('is_ajax')=='3') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
			$csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');

			if($_FILES['file']['name']==='') {
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
									/*'alamat' => $line[10],*/
									'perusahaan_id' => $line[10],
									'location_id' => $line[11],
									'department_id' =>$line[12],
									'sub_department_id' =>$line[13],
									'penunjukan_id' => $line[14],
									'user_role_id' => $line[15],
									'status_perkawinan' => $line[16],
									'is_active' => $line[17],
									'shift_kantor_id' => $line[18],
									'kategoris_cuti' => $line[19],
									'created_at' => date('Y-m-d h:i:s')
								);
								$last_insert_id = $this->Karyawans_model->add($data);
								$immigration_data = array(
									'type_document_id' => $line[20],
									'nomor_document' => $line[21],
									'document_file' => $line[22],
									'tanggal_terbit' => $line[23],
									'tanggal_kaaluarsa' => $line[24],
									'negara_id' => $line[25],
									'tanggal_tinjauan_yang_memenuhi_syarat' => $line[26],
									'karyawan_id' => $last_insert_id,
									'created_at' => date('d-m-Y h:i:s'),
								);
								$iimmigration = $this->Karyawans_model->immigration_info_add($immigration_data);
								$kontak_data = array(
									'relation' => $line[27],
									'email_kerja' => $line[28],
									'is_primary' => $line[29],
									'is_dependent' => $line[30],
									'email_pribadi' => $line[31],
									'kontak_name' => $line[32],
									'alamat_1' => $line[33],
									'phone_kerja' => $line[34],
									'extension_phone_kerja' => $line[35],
									'alamat_2' => $line[36],
									'mobile_phone' => $line[37],
									'kota' => $line[38],
									'provinsi' => $line[39],
									'kode_pos' => $line[40],
									'home_phone' => $line[41],
									'negara' => $line[42],
									'karyawan_id' => $last_insert_id,
									'created_at' => date('d-m-Y'),
								);
								$ikontak = $this->Karyawans_model->add_info_kontak($kontak_data);
								$document_data = array(
									'type_document_id' =>  $line[43],
									'tanggal_kadaluarsa' =>  $line[44],
									'title' =>  $line[45],
									'notification_email' =>  $line[46],
									'description' =>  $line[47],
									'document_file' => $line[48],
									'is_alert' =>  $line[49],
									'karyawan_id' => $last_insert_id,
									'created_at' => date('d-m-Y'),
								);
								$idocument = $this->Karyawans_model->add_info_document($document_data);
								$qualificaton_data = array(
									'name' => $line[50],
									'tingkat_pendidikan_id' => $line[51],
									'from_year' => $line[52],
									'to_year' => $line[53],
									'skill_id' => $line[54],
									'language_id' => $line[55],
									'description' => $line[56],
									'karyawan_id' => $last_insert_id,
									'created_at' => date('d-m-Y'),
								);
								$iqualificaton = $this->Karyawans_model->add_info_qualification($qualificaton_data);
								$pengalaman_data = array(
									'nama_perusahaan' => $line[57],
									'post' => $line[58],
									'from_date' => $line[59],
									'to_date' => $line[60],
									'description' => $line[61],
									'karyawan_id' => $last_insert_id,
									'created_at' => date('d-m-Y'),
								);
								$ipengalaman = $this->Karyawans_model->add_info_pengalaman_kerja($pengalaman_data);
								$bank_account_data = array(
									'account_title' => $line[62],
									'nomor_account' => $line[63],
									'nama_bank' => $line[64],
									'kode_bank' => $line[65],
									'cabang_bank' => $line[66],
									'karyawan_id' => $last_insert_id,
									'created_at' => date('d-m-Y'),
								);
								$ibank_account = $this->Karyawans_model->add_info_bank_account($bank_account_data);
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


	public function import_kehadiran() {

		if($this->input->post('is_ajax')=='3') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();

			$csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');

			if(empty($_FILES['file']['name'])) {
				$Return['error'] = $this->lang->line('umb_kehadiran_allowed_size');
			} else {
				if(in_array($_FILES['file']['type'],$csvMimes)){
					if(is_uploaded_file($_FILES['file']['tmp_name'])){

						if(filesize($_FILES['file']['tmp_name']) > 512000) {
							$Return['error'] = $this->lang->line('umb_error_import_kehadiran_size');
						} else {

							$csvFile = fopen($_FILES['file']['tmp_name'], 'r');

							fgetcsv($csvFile);

							while(($line = fgetcsv($csvFile)) !== FALSE){

								$tanggal_kehadiran = $line[1];
								$clock_in = $line[2];
								$clock_out = $line[3];
								$clock_in2 = $tanggal_kehadiran.' '.$clock_in;
								$clock_out2 = $tanggal_kehadiran.' '.$clock_out;

								$total_kerja_cin =  new DateTime($clock_in2);
								$total_kerja_cout =  new DateTime($clock_out2);

								$interval_cin = $total_kerja_cout->diff($total_kerja_cin);
								$hours_in   = $interval_cin->format('%h');
								$minutes_in = $interval_cin->format('%i');
								$total_kerja = $hours_in .":".$minutes_in;

								$user = $this->Umb_model->read_user_melalui_karyawan_id($line[0]);
								if(!is_null($user)){
									$user_id = $user[0]->user_id;
								} else {
									$user_id = '0';
								}

								$data = array(
									'karyawan_id' => $user_id,
									'tanggal_kehadiran' => $tanggal_kehadiran,
									'clock_in' => $clock_in2,
									'clock_out' => $clock_out2,
									'time_late' => $clock_in2,
									'total_kerja' => $total_kerja,
									'early_leaving' => $clock_out2,
									'lembur' => $clock_out2,
									'status_kehadiran' => 'Present',
									'clock_in_out' => '0'
								);
								$result = $this->Timesheet_model->add_kehadiran_karyawan($data);
							}
							fclose($csvFile);

							$Return['result'] = $this->lang->line('umb_sukses_import_kehadiran');
						}
					}else{
						$Return['error'] = $this->lang->line('umb_error_tidak_import_kehadiran');
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


	public function import_leads() {

		if($this->input->post('is_ajax')=='3') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();

			$csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');

			if($_FILES['file']['name']==='') {
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

								$options = array('cost' => 12);
								$password_hash = password_hash($line[2], PASSWORD_BCRYPT, $options);
								$data = array(
									'name' => $line[0],
									'email' => $line[1],
									'password_client' => $password_hash,
									'nomor_kontak' => $line[3],
									'nama_perusahaan' => $line[4],
									'website_url' => $line[5],
									'alamat_1' => $line[6],
									'alamat_2' => $line[7],
									'kota' => $line[8],
									'provinsi' => $line[9],
									'kode_pos' => $line[10],
									'negara' => $line[11],
									'is_active' => 1,
									'created_at' => date('Y-m-d H:i:s'),
									'is_changed' => '0',
									'profile_client' => '',
								);
								$this->Clients_model->add_lead($data);
							}					
							fclose($csvFile);

							$Return['result'] = $this->lang->line('umb_sukses_import_leads');
						}
					}else{
						$Return['error'] = $this->lang->line('umb_error_not_import_leads');
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
} 
?>