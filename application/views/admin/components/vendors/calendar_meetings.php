<?php $system = $this->Umb_model->read_setting_info(1); ?>
<?php
$events_date = date('Y-m');
?>
<script type="text/javascript">
	$(document).ready(function(){
		$('#calendar_hr').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay,listWeek'
			},
			//defaultView: 'agendaWeek',
			views: {
				listDay: { buttonText: 'list day' },
				listWeek: { buttonText: 'list week' }
			},
			themeSystem: 'bootstrap4',
			bootstrapFontAwesome: {
				close: ' ion ion-md-close',
				prev: ' ion ion-ios-arrow-back scaleX--1-rtl',
				next: ' ion ion-ios-arrow-forward scaleX--1-rtl',
				prevYear: ' ion ion-ios-arrow-dropleft-circle scaleX--1-rtl',
				nextYear: ' ion ion-ios-arrow-dropright-circle scaleX--1-rtl'
			},
			eventRender: function(event, element) {
				element.attr('title',event.title).tooltip();
				element.attr('href', 'javascript:void(0);');
				element.click(function() {
					$.ajax({
						url : site_url+"meetings/read_record_meeting/",
						type: "GET",
						data: 'jd=1&is_ajax=1&mode=modal&data=view_meeting&meeting_id='+event.meeting_id,
						success: function (response) {
							if(response) {
								$('#modals-slide').modal('show')
								$("#ajax_modal_view").html(response);
							}
						}
					});
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
					mousey = jsEvent.pageY - tipHeight - 20;
				}
				eventInfo.css({ top: mousey, left: mousex });
				eventInfo.show();
			},
			defaultDate: '<?php echo $events_date;?>',
			eventLimit: true, 
			navLinks: true,
			selectable: true,
			events: [
			<?php foreach($all_meetings->result() as $meetings):?>
				{
					meeting_id: '<?php echo $meetings->meeting_id?>',
					unq: '1',
					title: '<?php echo $meetings->title_meeting?>',
					start: '<?php echo $meetings->tanggal_meeting?>T<?php echo $meetings->waktu_meeting?>',
					color: '<?php echo $meetings->meeting_color?> !important'
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