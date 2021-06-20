<?php $system = $this->Umb_model->read_setting_info(1); ?>
<?php
/*if(isset($_POST['set_date'])){
	$tanggal_cuti = $_POST['set_date'];
} else {
	$tanggal_cuti = date('Y-m-d');
}*/
$r = $this->Umb_model->read_user_info(5);
$date = strtotime(date("Y-m-d"));
$day = date('d', $date);
$month = date('m', $date);
$year = date('Y', $date);
$daysInMonth =  date('t');
$imonth = date('F', $date);
?>
<script type="text/javascript">
	var newEvent;
	var editEvent;
	$(document).ready(function() {
		var calendar = $('#calendar_hr').fullCalendar({
			eventRender: function(event, element, view) {
				var displayEventDate;    
				if(event.title == 'Present'){
					element.popover({
						title:    '<div class="popoverTitleCalendar" style="background-color:'+ event.backgroundColor +'; color:'+ event.textColor +'">'+ event.title +'</div>',
						content:  '<div class="popoverInfoCalendar">' +
						'<p><strong>Clock In:</strong> ' + event.clock_in + '</p>' +
						'<p><strong>Clock Out:</strong> ' + event.clock_out + '</p>' +
						'<p><strong>Total Kerja:</strong> ' + event.total_kerja + '</p>' +
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
				}   else if(event.title == 'libur'){
					element.popover({
						title:    '<div class="popoverTitleCalendar" style="background-color:'+ event.backgroundColor +'; color:'+ event.textColor +'">'+ event.title +'</div>',
						content:  '<div class="popoverInfoCalendar">' +
						'<p><strong>Event Name:</strong> ' + event.event_name + '</p>' +
						'<p><strong>Start Date:</strong> ' + event.estart + '</p>' +
						'<p><strong>End Date:</strong> ' + event.eend + '</p>' +
						'<div class="popoverDescCalendar"><strong>Description:</strong> '+ event.description +'</div>' +
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
			/*customButtons: {
				printButton: {
					icon: 'print',
					click: function() {
						window.print();
					}
				}
			},*/
			header: {
				left: 'today, prevYear, nextYear, printButton',
				center: 'prev, title, next',
				right: 'month,agendaWeek,agendaDay,listWeek'
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
			defaultDate: moment('<?php echo date('Y-m-d');?>'),
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
				if($shift_kantor[0]->senen_waktu_masuk == '' && $day == 'Monday') {
					$status = '1';	
					$bgcolor = '';
					$total_kerja = '';
					$clockout = '';
					$event_name = '';
				} else if($shift_kantor[0]->selasa_waktu_masuk == '' && $day == 'Tuesday') {
					$status = '1';	
					$bgcolor = '';
					$total_kerja = '';
					$event_name = '';
				} else if($shift_kantor[0]->rabu_waktu_masuk == '' && $day == 'Wednesday') {
					$status = '1';	
					$bgcolor = '';
					$total_kerja = '';
					$clockout = '';
					$event_name = '';
				} else if($shift_kantor[0]->kamis_waktu_masuk == '' && $day == 'Thursday') {
					$status = '1';	
					$bgcolor = '';
					$total_kerja = '';
					$event_name = '';
					$clockout = '';
				} else if($shift_kantor[0]->jumat_waktu_masuk == '' && $day == 'Friday') {
					$status = '1';	
					$bgcolor = '';
					$total_kerja = '';
					$clockout = '';
				} else if($shift_kantor[0]->sabtu_waktu_masuk == '' && $day == 'Saturday') {
					$status = '1';	
					$bgcolor = '';
					$total_kerja = '';
					$event_name = '';
					$clockout = '';
				} else if($shift_kantor[0]->minggu_waktu_masuk == '' && $day == 'Sunday') {
					$status = '1';
					$bgcolor = '';
					$total_kerja = '';
					$clockout = '';
					$event_name = '';
				} else if(in_array($tanggal_kehadiran,$libur_arr)) {
					$status = 'Libur';
					$bgcolor = '#f39c12';
					$clockin = '';
					$total_kerja = '';
					$clockout = '';
					$chck_tanggal_lbr = $this->Timesheet_model->check_tanggal_libur($tanggal_kehadiran);
					$event_name = '';
					if($chck_tanggal_lbr->num_rows() > 0){
						$h_date = $this->Timesheet_model->tanggal_libur($tanggal_kehadiran);
						foreach($h_date as $hevent){
							$event_name = $hevent->event_name;
							$description = $hevent->description;
						}
					}
				} else if(in_array($tanggal_kehadiran,$cuti_arr)) {
					$status = 'Cuti';
					$clockin = '';
					$total_kerja = '';
					$clockout = '';
					$event_name = '';
				} else if($check->num_rows() > 0){
					$kehadiran = $this->Timesheet_model->kehadiran_pertama_masuk($user_id,$tanggal_kehadiran);
					$status = $kehadiran[0]->status_kehadiran;
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
					$status = 'Absent';
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
				if($status==1){
					$tanggal_kehadiran = '';
				}
				if($status == 'Present'){
					?>
					{
						_id: '<?php echo $i;?>',
						title: '<?php echo $status;?>',
						start: '<?php echo $tanggal_kehadiran;?>',
						end: '<?php echo $tanggal_kehadiran;?>',
						clock_in: '<?php echo $clockin;?>',
						clock_out: '<?php echo $clockout;?>',
						total_kerja: '<?php echo $total_kerja;?>',
						backgroundColor: "<?php echo $bgcolor;?>",
						textColor: "#ffffff",
					},
				<?php } 
				else if($status == 'libur'){
					?>
					{
						_id: '<?php echo $i;?>',
						title: '<?php echo $status;?>',
						event_name: '<?php echo $event_name;?>',
						estart: '<?php echo $tanggal_kehadiran;?>',
						eend: '<?php echo $tanggal_kehadiran;?>',
						start: '<?php echo $tanggal_kehadiran;?>',
						end: '<?php echo $tanggal_kehadiran;?>',
						description: '<?php echo $description;?>',
						backgroundColor: "<?php echo $bgcolor;?>",
						textColor: "#ffffff",
					},
				<?php } else { ?>
					{
						_id: '<?php echo $i;?>',
						title: '<?php echo $status;?>',
						start: '<?php echo $tanggal_kehadiran;?>',
						end: '<?php echo $tanggal_kehadiran;?>',
						clock_in: '',
						clock_out: '',
						total_kerja: '',
						backgroundColor: "<?php echo $bgcolor;?>",
						textColor: "#ffffff",
					},
				<?php }	?>   
			<?php endfor;?>
			]
		});
});
$(document).ready(function(){

	$('#calendar_hr1').fullCalendar({
		header: {
			left: 'prev,next today,printButton',
			center: 'prev, title, next',
			right: 'month,agendaWeek,agendaDay,listWeek'
		},
		views: {
			month: {
				columnFormat:'dddd'
			},
			agendaWeek:{
				columnFormat:'ddd D/M',
				eventLimit: false
			},
			agendaDay:{
				columnFormat:'dddd',
				eventLimit: false
			},
			listWeek:{
				columnFormat:''
			}
		},
		eventRender: function(event, element) {
			element.attr('title',event.titlepopup).tooltip();
			element.find('.fc-title').append(event.clockin);
			element.find('.fc-title').append(event.total_kerja);

		},
		defaultDate: '<?php echo date('Y-m-d');?>',
		eventLimit: false, 
		navLinks: true,
		events: [
		<?php
		for($i = 1; $i <= $daysInMonth; $i++):
			$i = str_pad($i, 2, 0, STR_PAD_LEFT);
				// get date <
			$tanggal_kehadiran = $year.'-'.$month.'-'.$i;
			$get_day = strtotime($tanggal_kehadiran);
			$day = date('l', $get_day);
			$user_id = $r[0]->user_id;
			$shift_kantor_id = $r[0]->shift_kantor_id;
			$status_kehadiran = '';
			$shift_kantor = $this->Timesheet_model->read_informasi_shift_kantor($shift_kantor_id);
			$check = $this->Timesheet_model->check_kehadiran_pertama_masuk($user_id,$tanggal_kehadiran);
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
			if($shift_kantor[0]->senen_waktu_masuk == '' && $day == 'Monday') {
				$status = '1';	
				$bgcolor = '';
				$total_kerja = '';
			} else if($shift_kantor[0]->selasa_waktu_masuk == '' && $day == 'Tuesday') {
				$status = '1';	
				$bgcolor = '';
				$total_kerja = '';
			} else if($shift_kantor[0]->rabu_waktu_masuk == '' && $day == 'Wednesday') {
				$status = '1';	
				$bgcolor = '';
				$total_kerja = '';
			} else if($shift_kantor[0]->kamis_waktu_masuk == '' && $day == 'Thursday') {
				$status = '1';	
				$bgcolor = '';
				$total_kerja = '';
			} else if($shift_kantor[0]->jumat_waktu_masuk == '' && $day == 'Friday') {
				$status = '1';	
				$bgcolor = '';
				$total_kerja = '';
			} else if($shift_kantor[0]->sabtu_waktu_masuk == '' && $day == 'Saturday') {
				$status = '1';	
				$bgcolor = '';
				$total_kerja = '';
			} else if($shift_kantor[0]->minggu_waktu_masuk == '' && $day == 'Sunday') {
				$status = '1';
				$bgcolor = '';
				$total_kerja = '';
			} else if(in_array($tanggal_kehadiran,$libur_arr)) {
				$status = 'Libur';
				$bgcolor = '#f39c12';
				$clockin = '';
				$total_kerja = '';
			} else if(in_array($tanggal_kehadiran,$cuti_arr)) {
				$status = 'Cuti';
				$clockin = '';
				$total_kerja = '';
			} else if($check->num_rows() > 0){
				$kehadiran = $this->Timesheet_model->kehadiran_pertama_masuk($user_id,$tanggal_kehadiran);
				$status = $kehadiran[0]->status_kehadiran;
				$bgcolor = '#00a65a';
				$tanggal_kehadiran = $tanggal_kehadiran;
				$iclock_in = new DateTime($kehadiran[0]->clock_in);
				$fclockin = $iclock_in->format('h:i a');
				$iclock_out = new DateTime($kehadiran[0]->clock_out);
				$fclockout = $iclock_out->format('h:i a');
				$clockin = '<br><br><i class="fa fa-clock-o"></i> '.$fclockin.' - <i class="fa fa-clock-o"></i> '.$fclockout;
				$total_hrs = $this->Timesheet_model->total_kehadiran_jam_bekerja($user_id,$tanggal_kehadiran);
				$hrs_old_int1 = 0;
				$Total = '';
				$Tistrahat = '';
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
					$total_kerja = '<br/>Total: '.$Total;
				}
			} else {		
				$status = 'Absent';
				$bgcolor = '#dd4b39';
				$tanggal_kehadiran = $tanggal_kehadiran;
				$clockin = '';
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
			if($status==1){
				$tanggal_kehadiran = '';
			}
			?>
			{
				title: '<?php echo $status;?>',
				clockin: '<?php echo $clockin;?>',
				total_kerja: '<?php echo $total_kerja;?>',
				start: '<?php echo $tanggal_kehadiran;?>',
				end: '<?php echo $tanggal_kehadiran;?>',
				color: '<?php echo $bgcolor;?>',
			},		
		<?php endfor; ?>	
		]
	});

$('#external-events .fc-event').each(function() {
	$(this).css({'backgroundColor': $(this).data('color'), 'borderColor': $(this).data('color')});
	$(this).data('event', {
		title: $.trim($(this).text()),
		color: $(this).data('color'),
		stick: true
	});

});


});
</script>