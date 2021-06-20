<?php

$someArray = array();
$someArrayEmp = array();
if($this->input->post('karyawan_id')==0){
	$umb_karyawans = $this->Umb_model->all_karyawans();
} else {
	$umb_karyawans = $this->Umb_model->read_user_info($this->input->post('karyawan_id'));
}

$month_year = $this->input->post('month_year');
if(isset($month_year)){
	$default_date = $month_year;
} else {
	$default_date = date("Y-m-d");
}

if(isset($month_year)){
	$date = strtotime($this->input->post('month_year').'-01');
	$imonth_year = explode('-',$this->input->post('month_year'));
	$day = date('d', $date);
	$month = date($imonth_year[1], $date);
	$year = date($imonth_year[0], $date);
	$month_year = $this->input->post('month_year');
} else {
	$date = strtotime(date("Y-m-d"));
	//$date = strtotime('2020-05-01');
	$day = date('d', $date);
	$month = date('m', $date);
	$year = date('Y', $date);
	$month_year = date('Y-m');
}
$daysInMonth =  date('t');
$imonth = date('F', $date);
?>
<script type="text/javascript">
	$(function() {
		$('#calendar').fullCalendar({
			defaultView: 'timelineMonth',
			header: {
				right: 'timelineMonth'
			},
			defaultDate: moment('<?php echo $default_date;?>'),
			resourceColumns: [
			{
				labelText: 'karyawan',
				field: 'title'
			},
			{
				labelText: 'Present',
				field: 'karyawan_present'
			}
			],
			resources: <?php
			if($this->input->post('karyawan_id')==0){
				$umb_karyawans = $this->Umb_model->all_karyawans();
			} else {
				$umb_karyawans = $this->Umb_model->read_user_info($this->input->post('karyawan_id'));
			}
			foreach($umb_karyawans as $hr_user) { 
				
				$full_name = $hr_user->first_name.' '.$hr_user->last_name;	
				$penunjukan = $this->Penunjukan_model->read_informasi_penunjukan($hr_user->penunjukan_id);
				if(!is_null($penunjukan)){
					$nama_penunjukan = $penunjukan[0]->nama_penunjukan;
				} else {
					$nama_penunjukan = '--';	
				}
				$department = $this->Department_model->read_informasi_department($hr_user->department_id);
				if(!is_null($department)){
					$nama_department = $department[0]->nama_department;
				} else {
					$nama_department = '--';
				}
				$user_info = $full_name;
				$pcount = 0;
				for($i = 1; $i <= $daysInMonth; $i++):
					$i = str_pad($i, 2, 0, STR_PAD_LEFT);
					$etanggal_kehadiran = $year.'-'.$month.'-'.$i;
					$check = $this->Timesheet_model->check_kehadiran_pertama_masuk($hr_user->user_id,$etanggal_kehadiran);
					if($check->num_rows() > 0) {
						$pcount += $check->num_rows();
					} else {
						$pcount += 0;
					}
				endfor;
				if($pcount == 0){
					$pcount = '0';
				}
				$someArrayEmp[] = array(
					'id' => $hr_user->user_id,
					'title'   => $user_info,
					'karyawan_present' => $pcount
				);
			}
			echo json_encode($someArrayEmp);
			?>,
			events: <?php
			$j=0;
			foreach($umb_karyawans as $r) { 
				for($i = 1; $i <= $daysInMonth; $i++):
					$i = str_pad($i, 2, 0, STR_PAD_LEFT);
					$tanggal_kehadiran = $year.'-'.$month.'-'.$i;
					$tdate = $year.'-'.$month.'-'.$i;
					$get_day = strtotime($tanggal_kehadiran);
					$day = date('l', $get_day);
					$user_id = $r->user_id;
					$shift_kantor = $this->Timesheet_model->read_informasi_shift_kantor($r->shift_kantor_id);
					if(!is_null($shift_kantor)){
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
						//echo '<pre>'; print_r($libur_arr);
						$chck_tanggal_cuti = $this->Timesheet_model->chcek_tanggal_cuti($r->user_id,$tanggal_kehadiran);
						$cuti_arr = array();
						if($chck_tanggal_cuti->num_rows() == 1){
							$tanggal_cuti = $this->Timesheet_model->tanggal_cuti($r->user_id,$tanggal_kehadiran);
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
						$status_kehadiran = '';
						$check = $this->Timesheet_model->check_kehadiran_pertama_masuk($r->user_id,$tanggal_kehadiran);
						if($shift_kantor[0]->senen_waktu_masuk == '' && $day == 'Monday') {
							$status = 'H';	
						} else if($shift_kantor[0]->selasa_waktu_masuk == '' && $day == 'Tuesday') {
							$status = 'H';
						} else if($shift_kantor[0]->rabu_waktu_masuk == '' && $day == 'Wednesday') {
							$status = 'H';
						} else if($shift_kantor[0]->kamis_waktu_masuk == '' && $day == 'Thursday') {
							$status = 'H';
						} else if($shift_kantor[0]->jumat_waktu_masuk == '' && $day == 'Friday') {
							$status = 'H';
						} else if($shift_kantor[0]->sabtu_waktu_masuk == '' && $day == 'Saturday') {
							$status = 'H';
						} else if($shift_kantor[0]->minggu_waktu_masuk == '' && $day == 'Sunday') {
							$status = 'H';
						} else if(in_array($tanggal_kehadiran,$libur_arr)) {
							$status = 'H';
						} else if(in_array($tanggal_kehadiran,$cuti_arr)) {
							$status = 'L';
						} else if($check->num_rows() > 0){
							$kehadiran = $this->Timesheet_model->kehadiran_pertama_masuk($r->user_id,$tanggal_kehadiran);
							$status = 'P';					
						} else {
							$status = 'A';
							//$pcount += 0;
						}
						//$pcount += $check->num_rows();
						// set to present date
						$itanggal_kehadiran = strtotime($tanggal_kehadiran);
						$icurrent_date = strtotime(date('Y-m-d'));
						$status = $status;
						if($itanggal_kehadiran <= $icurrent_date){
							$status = $status;
						} else {
							$status = '--';
						}
						$itanggal_bergabung = strtotime($r->tanggal_bergabung);
						if($itanggal_bergabung < $itanggal_kehadiran){
							$status = $status;
						} else {
							$status = '--';
						}
					} else {
						$status = '<a href="javascript:void(0)" class="badge badge-danger">'.$this->lang->line('umb_shift_kantor_not_assigned').'</a>';
						$tanggal_kehadiran = '';
						$tanggal_kehadiran = '';
					}
					$someArray[] = array(
						'title' => $status,
						'resourceId' => $r->user_id,
						'start'   => $tanggal_kehadiran,
						'end'   => $tanggal_kehadiran,
					);
				endfor;	
			}
			echo json_encode($someArray);
			?>,
		});
});	
</script>
<style>
	#calendar {
		width: 100%;
		height: 100%;
	}
</style>