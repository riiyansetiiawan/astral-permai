<?php $system = $this->Umb_model->read_setting_info(1); ?>
<?php
if(isset($_POST['set_date'])){
	$tanggal_cuti = $_POST['set_date'];
} else {
	$tanggal_cuti = date('Y-m-d');
}
?>
<script type="text/javascript">
	$(document).ready(function(){
		$('#calendar_hr').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			views: {
				listDay: { buttonText: 'list day' },
				listWeek: { buttonText: 'list week' }
			},
			eventRender: function(event, element) {
				element.attr('title',event.titlepopup).tooltip();
				element.attr('href', event.urllink);

			},
			defaultDate: '<?php echo $tanggal_cuti;?>',
			eventLimit: false,
			navLinks: true,
			events: [
			<?php foreach($this->Umb_model->get_applications_cuti() as $cuti_app):?>
				<?php
				$type_cuti = $this->Timesheet_model->read_informasi_type_cuti($cuti_app->type_cuti_id);
				if(!is_null($type_cuti)){
					$type_name = $type_cuti[0]->type_name;
				} else {
					$type_name = '--';	
				}
				$user = $this->Umb_model->read_user_info($cuti_app->karyawan_id);
				if(!is_null($user)){
					$full_name = $user[0]->first_name.' '.$user[0]->last_name;
				} else { $full_name = '--'; }
				?>
				{
					title: '<?php echo $type_name;?>',
					titlepopup: '<?php echo $this->lang->line('umb_hr_calendar_permintaan_cti_oleh').': '.$full_name;?>',
					start: '<?php echo $cuti_app->from_date;?>',
					end: '<?php echo $cuti_app->to_date;?>',
					urllink: '<?php echo site_url().'admin/timesheet/details_cuti/id/'.$cuti_app->cuti_id;?>',
					color: '#F6BB42'
				},
			<?php endforeach;?>
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