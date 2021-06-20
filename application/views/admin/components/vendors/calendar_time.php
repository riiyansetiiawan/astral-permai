<?php
$session = $this->session->userdata('username');
$system = $this->Umb_model->read_setting_info(1);
$user_info = $this->Umb_model->read_user_info($session['user_id']);
$month_year = $this->input->post('month_year');
$karyawan_id = $this->input->post('karyawan_id');
$perusahaan_id = $this->input->post('perusahaan_id');
if($user_info[0]->user_role_id==1){
	$month_year = $this->input->post('month_year');
	$karyawan_id = $this->input->post('karyawan_id');
	$perusahaan_id = $this->input->post('perusahaan_id');
	//if(isset($perusahaan_id)){
	if(isset($perusahaan_id)){
		$date = strtotime(date("Y-m-d"));
		
		$imonth_year = explode('-',$month_year);
		$day = date('d', $date);
		$month = date($imonth_year[1], $date);
		$year = date($imonth_year[0], $date);
		if($karyawan_id == ''){
			$r = $this->Umb_model->read_user_info($session['user_id']);
		} else {
			$r = $this->Umb_model->read_user_info($karyawan_id);
		}
		$fdate = $month_year;
	} else {
		$date = strtotime(date("Y-m-d"));
		$day = date('d', $date);
		$month = date('m', $date);
		$year = date('Y', $date);
		$fdate = strtotime(date("Y-m-d"));
	}
	//$fdate = strtotime(date("Y-m"));
} else {
	if(isset($month_year)){
		$date = strtotime(date("Y-m-d"));
		$imonth_year = explode('-',$month_year);
		$day = date('d', $date);
		$month = date($imonth_year[1], $date);
		$year = date($imonth_year[0], $date);
		$r = $this->Umb_model->read_user_info($session['user_id']);
		$fdate = $month_year;
	} else {
		$date = strtotime(date("Y-m-d"));
		$day = date('d', $date);
		$month = date('m', $date);
		$year = date('Y', $date);
		$fdate = date("Y-m-d");
		$month_year = date("Y-m");
		$r = $this->Umb_model->read_user_info($session['user_id']);
	}
}
$daysInMonth =  date('t');
?>
<script type="text/javascript">
	var newEvent;
	var editEvent;
	$(document).ready(function() {
		var calendar = $('#calendar_hr').fullCalendar({
			eventRender: function(event, element, view) {
				var displayEventDate;    
				if(event.etitle == 'Present'){
					element.popover({
            title:'<div class="popoverTitleCalendar" style="background-color:'+ event.backgroundColor +'; color:'+ event.textColor +'">'+ event.title +'</div>',
            :  '<div class="popoverInfoCalendar">' +
            '<p><strong>Clock In:</strong> ' + event.clock_in + '</p>' +
            '<p><strong>Clock Out:</strong> ' + event.clock_out + '</p>' +
            '<p><strong>Total Work:</strong> ' + event.total_kerja + '</p>' +
            '</div>',
            delay: { 
              show: "400", 
              hide: "50"
            },
            trigger: 'hover',
            placement: 'top',
            html: true,
            container: 'body'
          }); 
				} 
			},
			header: {
        //left: 'today, prevYear, nextYear, printButton',
        //center: 'prev, title, next',
        right: 'month'
      },
      themeSystem: 'bootstrap4',
      eventAfterAllRender: function(view) {
        if(view.name == "month"){
          $(".fc-content").css('height','auto');
        } else {
          $(".fc-content").css('height','auto');
        }
      },
      eventResize: function(event, delta, revertFunc, jsEvent, ui, view) {
        $('.popover.fade.top').remove();
      },
      locale: 'en-GB',
      allDaySlot: false,
      firstDay: 1,
      weekNumbers: false,
      selectable: false,
      weekNumberCalculation: "ISO",
      eventLimit: true,
      eventLimitClick: 'week',
      navLinks: true,
      defaultDate: moment('<?php echo $fdate;?>'),
      timeFormat: 'HH:mm',
      editable: false,
      weekends: true,
      nowIndicator: true,
      dayPopoverFormat: 'dddd DD/MM', 
      longPressDelay : 0,
      eventLongPressDelay : 0,
      selectLongPressDelay : 0,

      events: [
      <?php
      for($i = 1; $i <= $daysInMonth; $i++):
        $i = str_pad($i, 2, 0, STR_PAD_LEFT);
        $tanggal_kehadiran = $year.'-'.$month.'-'.$i;
        $get_day = strtotime($tanggal_kehadiran);
        $day = date('l', $get_day);
        $user_id = $r[0]->user_id;
        $shift_kantor_id = $r[0]->shift_kantor_id;
        $status_kehadiran = '';
        $shift_kantor = $this->Timesheet_model->read_informasi_shift_kantor($shift_kantor_id);
        $check = $this->Timesheet_model->check_kehadiran_pertama_masuk($user_id,$tanggal_kehadiran);
        if($shift_kantor[0]->senen_waktu_masuk == '' && $day == 'Monday') {
          $status = 'off day';	
          $bgcolor = '';
          $total_kerja = '';
          $clockout = '';
          $event_name = '';
          $estatus = '';
        } else if($shift_kantor[0]->selasa_waktu_masuk == '' && $day == 'Tuesday') {
          $status = 'off day';	
          $bgcolor = '';
          $total_kerja = '';
          $event_name = '';
          $estatus = '';
        } else if($shift_kantor[0]->rabu_waktu_masuk == '' && $day == 'Wednesday') {
          $status = 'off day';	
          $bgcolor = '';
          $total_kerja = '';
          $clockout = '';
          $event_name = '';
          $estatus = '';
        } else if($shift_kantor[0]->kamis_waktu_masuk == '' && $day == 'Thursday') {
          $status = 'off day';	
          $bgcolor = '';
          $total_kerja = '';
          $event_name = '';
          $clockout = '';
          $estatus = '';
        } else if($shift_kantor[0]->jumat_waktu_masuk == '' && $day == 'Friday') {
          $status = 'off day';	
          $bgcolor = '';
          $total_kerja = '';
          $clockout = '';
          $estatus = '';
        } else if($shift_kantor[0]->sabtu_waktu_masuk == '' && $day == 'Saturday') {
          $status = 'off day';	
          $bgcolor = '';
          $estatus = '';
          $total_kerja = '';
          $event_name = '';
          $clockout = '';
        } else if($shift_kantor[0]->minggu_waktu_masuk == '' && $day == 'Sunday') {
          $status = 'off day';
          $bgcolor = '';
          $total_kerja = '';
          $clockout = '';
          $event_name = '';
          $estatus = '';
        } else if($check->num_rows() > 0){
          $kehadiran = $this->Timesheet_model->kehadiran_pertama_masuk($user_id,$tanggal_kehadiran);
          $status = $this->lang->line('umb_krywn_bekerja');
          $estatus = 'Present';
          $bgcolor = '#00a65a';
          $tanggal_kehadiran = $tanggal_kehadiran;
          $iclock_in = new DateTime($kehadiran[0]->clock_in);
          $fclockin = $iclock_in->format('h:i a');
          $iclock_out = new DateTime($kehadiran[0]->clock_out);
          $fclockout = $iclock_out->format('h:i a');
          $clockin = '<i class="fa fa-clock-o"></i>'.$fclockin;
          $clockout = '<i class="fa fa-clock-o"></i>'.$fclockout;
          $total_hrs = $this->Timesheet_model->total_kehadiran_jam_bekerja($user_id,$tanggal_kehadiran);
          $hrs_old_int1 = 0;
          $Total = '';
          $Tistrahat = '';
          $event_name = '';
          $hrs_old_seconds = 0;
          $hrs_old_seconds_rs = 0;
          $total_time_rs = '';
          $hrs_old_int_res1 = 0;
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
            $total_kerja = '';
          } else {
            $total_kerja = $Total;
          }
        } else {	
          $event_name = '';	
          $status = $this->lang->line('umb_absent');
          $estatus = 'Absent';
          $bgcolor = '#dd4b39';
          $tanggal_kehadiran = $tanggal_kehadiran;
          $clockin = '';
          $clockout = '';
          $total_kerja = '';
        }
        $itanggal_kehadiran = strtotime($tanggal_kehadiran);
        $icurrent_date = strtotime(date('Y-m-d'));
        if($itanggal_kehadiran <= $icurrent_date){
          $status = $status;
          $bgcolor = $bgcolor;
          $tanggal_kehadiran = $tanggal_kehadiran;
        } else {
          $status = '';
          $bgcolor = '';
          $tanggal_kehadiran = '';
        }
        $itanggal_bergabung = strtotime($r[0]->tanggal_bergabung);
        if($itanggal_bergabung < $itanggal_kehadiran){
          $status = $status;
        } else {
          $status = '';
        }
        if($status==1){
          $tanggal_kehadiran = '';
        }
        if($estatus == 'Present'){
          ?>
          {
           _id: '<?php echo $i;?>',
           title: '<?php echo $status;?>',
           etitle: '<?php echo $estatus;?>',
           start: '<?php echo $tanggal_kehadiran;?>',
           end: '<?php echo $tanggal_kehadiran;?>',
           clock_in: '<?php echo $clockin;?>',
           clock_out: '<?php echo $clockout;?>',
           total_kerja: '<?php echo $total_kerja;?>',
           backgroundColor: "<?php echo $bgcolor;?>",
           textColor: "#000000",
         },
       <?php } else { ?>
        {
          _id: '<?php echo $i;?>',
          title: '<?php echo $status;?>',
          etitle: '<?php echo $estatus;?>',
          start: '<?php echo $tanggal_kehadiran;?>',
          end: '<?php echo $tanggal_kehadiran;?>',
          backgroundColor: "<?php echo $bgcolor;?>",
          textColor: "#000000",
        },
      <?php }	?>   
    <?php endfor;?>
    ]
  }); 
});
</script>