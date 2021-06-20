<?php $session = $this->session->userdata('username');?>
<?php $user_info = $this->Umb_model->read_user_info($session['user_id']);?>
<?php $system = $this->Umb_model->read_setting_info(1); ?>
<?php
if(isset($_POST['set_date'])){
	$set_date = $_POST['set_date'];
} else {
	$set_date = date('Y-m-d');
}
?>
<?php
if($user_info[0]->user_role_id == '1'){
	$completed_tugas = $this->Project_model->calendar_complete_tugass();
	$cancelled_tugas = $this->Project_model->calendar_cancelled_tugass();
	$inprogress_tugas = $this->Project_model->calendar_inprogress_tugass();
	$not_started_tugas = $this->Project_model->calendar_not_started_tugass();
	$hold_tugas = $this->Project_model->calendar_hold_tugass();
} else {
	$completed_tugas = $this->Project_model->calendar_user_complete_tugass($session['user_id']);
	$cancelled_tugas = $this->Project_model->calendar_user_cancelled_tugass($session['user_id']);
	$inprogress_tugas = $this->Project_model->calendar_user_inprogress_tugass($session['user_id']);
	$not_started_tugas = $this->Project_model->calendar_user_not_started_tugass($session['user_id']);
	$hold_tugas = $this->Project_model->calendar_user_hold_tugass($session['user_id']);
}
?>
<script type="text/javascript">
	$(document).ready(function(){
		$('#calendar_hr').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek'
			},
			views: {
				listDay: { buttonText: 'list day' },
				listWeek: { buttonText: 'list week' }
			},
			eventRender: function(event, element) {
				element.attr('title',event.title).tooltip();
				element.attr('href', event.urllink);
			},
			defaultDate: '<?php echo $set_date;?>',
			eventLimit: false,
			navLinks: true,
			events: [
			<?php foreach($completed_tugas as $ctugass):?>
				{
					title: '<?php echo $ctugass->nama_tugas;?>',
					start: '<?php echo $ctugass->start_date?>',
					end: '<?php echo $ctugass->end_date?>',
					urllink: '<?php echo site_url().'admin/timesheet/details_tugas/id/'.$ctugass->tugas_id;?>',
					color: '#02BC77 !important'
				},
			<?php endforeach;?>
			<?php foreach($inprogress_tugas as $intugass):?>
				{
					title: '<?php echo $intugass->nama_tugas;?>',
					start: '<?php echo $intugass->start_date?>',
					end: '<?php echo $intugass->end_date?>',
					urllink: '<?php echo site_url().'admin/timesheet/details_tugas/id/'.$intugass->tugas_id;?>',
					color: '#7b83ff !important'
				},
			<?php endforeach;?>
			<?php foreach($not_started_tugas as $nttugass):?>
				{
					title: '<?php echo $nttugass->nama_tugas;?>',
					start: '<?php echo $nttugass->start_date?>',
					end: '<?php echo $nttugass->end_date?>',
					urllink: '<?php echo site_url().'admin/timesheet/details_tugas/id/'.$nttugass->tugas_id;?>',
					color: '#28c3d7 !important'
				},
			<?php endforeach;?>
			<?php foreach($cancelled_tugas as $cntugass):?>
				{
					title: '<?php echo $cntugass->nama_tugas;?>',
					start: '<?php echo $cntugass->start_date?>',
					end: '<?php echo $cntugass->end_date?>',
					urllink: '<?php echo site_url().'admin/timesheet/details_tugas/id/'.$cntugass->tugas_id;?>',
					color: '#d9534f !important'
				},
			<?php endforeach;?>
			<?php foreach($hold_tugas as $hltugass):?>
				{
					title: '<?php echo $hltugass->nama_tugas;?>',
					start: '<?php echo $hltugass->start_date?>',
					end: '<?php echo $hltugass->end_date?>',
					urllink: '<?php echo site_url().'admin/timesheet/details_tugas/id/'.$hltugass->tugas_id;?>',
					color: '#FFD950 !important'
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