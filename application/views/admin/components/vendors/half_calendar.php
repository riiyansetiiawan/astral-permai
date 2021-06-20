<?php 
$session = $this->session->userdata('username');
$user_info = $this->Umb_model->read_user_info($session['user_id']);
$role_user = $this->Umb_model->read_user_role_info($user_info[0]->user_role_id);
if(!is_null($role_user)){
	$role_resources_ids = explode(',',$role_user[0]->role_resources);
} else {
	$role_resources_ids = explode(',',0);	
}
?>
<?php $system = $this->Umb_model->read_setting_info(1); ?>
<style type="text/css">
	.popover-title {
		font-size: .9rem !important;
		border-color: rgba(0,0,0,.05) !important;
		background-color: #fff !important;
		font-weight:bold !important;
	}
	.popover-title {
		padding: .5rem .75rem !important;
		margin-bottom: 0 !important;
		color: inherit !important;
		border-bottom: 1px solid #ebebeb !important;
		border-top-left-radius: calc(.3rem - 1px) !important;
		border-top-right-radius: calc(.3rem - 1px) !important;
	}
	.popover {
		border-color: rgba(0,0,0,.1) !important;
	}
	.popover {
		color: rgba(70,90,110,.85) !important;
	}
	.popover .arrow {
		position: absolute !important;
		display: block !important;
	}
	.popover-content {
		font-size: .8rem !important;
		color: rgba(70,90,110,.85) !important;
	}

	.popover-content {
		padding: .5rem .75rem !important;
	}
</style>
<script type="text/javascript">
	$(document).ready(function(){
		$('#calendar_hr').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay',
			},
			themeSystem: 'bootstrap4',
			bootstrapFontAwesome: {
				close: ' ion ion-md-close',
				prev: ' ion ion-ios-arrow-back scaleX--1-rtl',
				next: ' ion ion-ios-arrow-forward scaleX--1-rtl',
				prevYear: ' ion ion-ios-arrow-dropleft-circle scaleX--1-rtl',
				nextYear: ' ion ion-ios-arrow-dropright-circle scaleX--1-rtl'
			}, 
			views: {
				listDay: { buttonText: 'list day' },
				listWeek: { buttonText: 'list week' }
			},
			eventRender: function(event, element) {
				element.attr('title',event.title).tooltip();
				element.attr('href', 'javascript:void(0);');
				element.click(function() {
					if(event.unq==1){
						$.ajax({
							url : site_url+"timesheet/read_record_libur/",
							type: "GET",
							data: 'jd=1&is_ajax=1&mode=modal&data=view_libur&libur_id='+event.libur_id,
							success: function (response) {
								if(response) {
									$('.modal_payroll_template').modal('show')
									$("#ajax_modal_payroll").html(response);
								}
							}
						});
					} else if(event.unq==8){
						$.ajax({
							url : site_url+"events/read_record_event/",
							type: "GET",
							data: 'jd=1&is_ajax=1&mode=modal&data=view_event&event_id='+event.event_id,
							success: function (response) {
								if(response) {
									$('.modal_payroll_template').modal('show')
									$("#ajax_modal_payroll").html(response);
								}
							}
						});
					} else if(event.unq==9){
						$.ajax({
							url : site_url+"meetings/read_record_meeting/",
							type: "GET",
							data: 'jd=1&is_ajax=1&mode=modal&data=view_meeting&meeting_id='+event.meeting_id,
							success: function (response) {
								if(response) {
									$('.modal_payroll_template').modal('show');
									$("#ajax_modal_payroll").html(response);
								}
							}
						});
					}
				});

			},
			dayClick: function(date, jsEvent, view) {
				date_last_clicked = $(this);
				var event_date = date.format();
				$('#exact_date').val(event_date);
				var eventInfo = $("#module-opt");
				var mousex = jsEvent.pageX + 20;
				var mousey = jsEvent.pageY + 20;
				var tipWidth = eventInfo.width();
				var tipHeight = eventInfo.height(); 
				var tipVisX = $(window).width() - (mousex + tipWidth);
				var tipVisY = $(window).height() - (mousey + tipHeight);

				if (tipVisX < 20) {
					mousex = jsEvent.pageX - tipWidth - 20;
				} if (tipVisY < 20) {
					mousey = jsEvent.pageY - tipHeight - 0;
				}
				eventInfo.css({ top: mousey, left: mousex });
				eventInfo.show();
			},
			theme:true,
			defaultDate: '<?php echo date('Y-m-d');?>',
			eventLimit: false,
			navLinks: true,
			events: [
			<?php if(in_array('8',$role_resources_ids)) { ?>
				<?php foreach($all_liburan->result() as $libur):?>
					{
						libur_id: '<?php echo $libur->libur_id?>',
						title: '<?php echo $libur->event_name?>',
						start: '<?php echo $libur->start_date?>',
						end: '<?php echo $libur->end_date?>',
						color: '#1fffac !important',
						unq: '1',
					},
				<?php endforeach;?>
			<?php } ?>
			<?php if($system[0]->module_events=='true'){?>
				<?php if(in_array('98',$role_resources_ids)) { ?>
					<?php foreach($all_events->result() as $events):?>
						{
							event_id: '<?php echo $events->event_id?>',
							title: '<?php echo $events->event_title?>',
							start: '<?php echo $events->event_date?>T<?php echo $events->event_time?>',
							color: '#ffaddf !important',
							unq: '8',
						},
					<?php endforeach;?>
				<?php } ?>
				<?php if(in_array('99',$role_resources_ids)) { ?>
					<?php foreach($all_meetings->result() as $meetings):?>
						{
							meeting_id: '<?php echo $meetings->meeting_id?>',
							title: '<?php echo $meetings->title_meeting?>',
							start: '<?php echo $meetings->tanggal_meeting?>T<?php echo $meetings->waktu_meeting?>',
							color: '#ccf9ff !important',
							unq: '9',
							className: "regular"
						},
					<?php endforeach;?>
				<?php } ?>
			<?php } ?>
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
	.trumbowyg-box.trumbowyg-editor-visible {
		min-height: 90px !important;
	}
	.fc-day-grid-event {
		padding: 0px 5px !important;
	}
	.fc-events-container .fc-event {
		padding: 2px !important;
	}
	.trumbowyg-editor {
		min-height: 90px !important;
	}
	.fc-day:hover, .fc-day-number:hover, .fc-content:hover{cursor: pointer;}

	.fc-close {
		font-size: .9em !important;
		margin-top: 2px !important;
	}
	.fc-close {
		float: right !important;
	}

	.fc-close {
		color: #666 !important;
	}
	.fc-event.fc-draggable, .fc-event[href], .fc-popover .fc-header .fc-close {
		cursor: pointer;
	}
	.fc-widget-header {
		background: #E4EBF1 !important;
	}
	.fc-widget-content {
		background: #FFFFFF;
	}

	.hide-calendar .ui-datepicker-calendar { display:none !important; }
	.hide-calendar .ui-priority-secondary { display:none !important; }
</style>
