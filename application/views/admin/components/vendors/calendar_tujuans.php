<?php $system = $this->Umb_model->read_setting_info(1); ?>
<?php
if(isset($_POST['calendar_tanggal_tujuan'])){
	$tanggal_tujuan = $_POST['calendar_tanggal_tujuan'];
} else {
	$tanggal_tujuan = date('Y-m');
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
				element.attr('title',event.title).tooltip();
				element.attr('href', 'javascript:void(0);');
				element.click(function() {
					$.ajax({
						url : site_url+"tujuan_tracking/read_tujuan/",
						type: "GET",
						data: 'jd=1&is_ajax=1&mode=modal&data=view_tracking&tracking_id='+event.tracking_id,
						success: function (response) {
							if(response) {
								$('.view-modal-data').modal('show')
								$("#ajax_modal_view").html(response);
							}
						}
					});
				});
			},
			defaultDate: '<?php echo $tanggal_tujuan;?>',
			eventLimit: false,
			navLinks: true,
			events: [
			<?php foreach($all_tujuans_completed->result() as $tujuans_completed):?>
				{
					tracking_id: '<?php echo $tujuans_completed->tracking_id?>',
					title: '<?php echo $tujuans_completed->subject?>',
					start: '<?php echo $tujuans_completed->start_date?>',
					end: '<?php echo $tujuans_completed->end_date?>',
					color: '#ED5564'
				},
			<?php endforeach;?>
			<?php foreach($all_tujuans_inprogress->result() as $tujuans_inprogress):?>
				{
					tracking_id: '<?php echo $tujuans_inprogress->tracking_id?>',
					title: '<?php echo $tujuans_inprogress->subject?>',
					start: '<?php echo $tujuans_inprogress->start_date?>',
					end: '<?php echo $tujuans_inprogress->end_date?>',
					color: '#F6BB42'
				},
			<?php endforeach;?>
			<?php foreach($all_tujuans_not_started->result() as $tujuans_not_started):?>
				{
					tracking_id: '<?php echo $tujuans_not_started->tracking_id?>',
					title: '<?php echo $tujuans_not_started->subject?>',
					start: '<?php echo $tujuans_not_started->start_date?>',
					end: '<?php echo $tujuans_not_started->end_date?>',
					color: '#ED5564'
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
<style type="text/css">
	.hide-calendar .ui-datepicker-calendar { display:none !important; }
	.hide-calendar .ui-priority-secondary { display:none !important; }
</style>