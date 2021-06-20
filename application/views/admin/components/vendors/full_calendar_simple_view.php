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
				right: 'month,agendaWeek'
			},
			views: {
				listDay: { buttonText: 'list day' },
				listWeek: { buttonText: 'list week' }
			},
			eventClick: function(event, jsEvent, view) {
				$this = $(this);
				var that = $(jsEvent.target);
				var el = that.is('.fc-event') ? that : that.closest('.fc-event');
				//var event_date = '<div><i class="fa fa-fw fa-calendar-o text-muted"></i> '+moment(event.start).format("dddd D M Y")+'</div>';
				var participant = ''
				$.each(event.participant, function (index, value) {
					participant += '<a href="profile.html" class="avatar w-24 mr-1"><img src="<?php echo base_url();?>'+value+'"></a>';
				});
				var title = 'New Project';
				var description = '<div class="popover-body"><div><i class="fa fa-fw fa-calendar-o text-muted"></i> Monday 2</div><div><i class="fa fa-fw fa-clock-o text-muted"></i> 5:12am</div><div class="d-flex my-2">'+participant+'</div><div class="text-muted mb-2">Tricies neque, quis malesuada augue. Donec eleifend  nisl eu consectetur. </div></div>';
				$this.popover({html:true,title:title,content: description ,placement:'right'}).popover('show');
				//return false;            
			},
			eventRender: function(event, element) {
				element.attr('href', 'javascript:void(0);');
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
			<?php foreach($all_liburan->result() as $libur):?>
				{
					libur_id: '<?php echo $libur->libur_id?>',
					title: '<?php echo $libur->event_name?>',
					start: '<?php echo $libur->start_date?>',
					end: '<?php echo $libur->end_date?>',
					color: '#2D95BF',
					unq: '1',
				},
			<?php endforeach;?>
			<?php foreach($all_calendar_permintaan_cutii->result() as $cuti):?>
				<?php $lvType = $this->Timesheet_model->read_informasi_type_cuti($cuti->type_cuti_id);?>
				<?php $lvUser = $this->Umb_model->read_user_info($cuti->karyawan_id); ?>
				<?php if(!is_null($lvUser)):?><?php $fName = $lvUser[0]->first_name. ' '.$lvUser[0]->last_name;?> <?php else:?><?php echo $fName='';?><?php endif;?> <?php if(!is_null($lvType)):?><?php $cutiType = $lvType[0]->type_name;?>
				<?php else:?><?php echo $cutiType='';?><?php endif;?>
				{
					cuti_id: '<?php echo $cuti->cuti_id?>',
					title: '<?php echo $cutiType.' '.$this->lang->line('umb_hr_calendar_permintaan_cti_oleh').' '.$fName;?>',
					start: '<?php echo $cuti->from_date?>',
					end: '<?php echo $cuti->to_date?>',
					color: '#48CFAE',
					unq: '2',
				},
			<?php endforeach;?>
			<?php foreach($all_upcoming_ulangtahun as $upc_ulangtahun):?>
				{
					title: '<?php echo $upc_ulangtahun->first_name.' '.$upc_ulangtahun->last_name?> - <?php echo $this->lang->line('umb_hr_calendar_upc_ulangtahun');?>',
					start: '<?php echo $upc_ulangtahun->tanggal_lahir?>',
					color: '#FB6E52',
					unq: '3',
				},
			<?php endforeach;?>
			<?php if($system[0]->module_perjalanan=='true'){?>
				<?php foreach($all_permintaan_perjalanan->result() as $perjalanan_request):?>
					<?php $karyawan = $this->Umb_model->read_user_info($perjalanan_request->karyawan_id); ?>
					<?php if(!is_null($karyawan)):?><?php $eName = $karyawan[0]->first_name. ' '.$karyawan[0]->last_name;?><?php else:?><?php echo $eName='';?><?php endif;?>
					{
						perjalanan_id: '<?php echo $perjalanan_request->perjalanan_id?>',
						title: '<?php echo $perjalanan_request->visit_purpose.' '.$this->lang->line('umb_hr_calendar_permintaan_cti_oleh').' '.$eName;?>',
						start: '<?php echo $perjalanan_request->start_date?>',
						end: '<?php echo $perjalanan_request->end_date?>',
						color: '#50C1E9',
						unq: '4',
					},
				<?php endforeach;?>
			<?php } ?>
			<?php if($system[0]->module_training=='true'){?>
				<?php foreach($all_training->result() as $training):?>
					<?php $type = $this->Training_model->read_informasi_type_training($training->type_training_id); ?>
					<?php if(!is_null($type)):?><?php $itype = $type[0]->type;?> <?php else:?><?php echo $itype='';?><?php endif;?>
					{
						training_id: '<?php echo $training->training_id?>',
						title: '<?php echo $itype;?>',
						start: '<?php echo $training->start_date?>',
						end: '<?php echo $training->finish_date?>',
						color: '#ED5564',
						unq: '5',
					},
				<?php endforeach;?>
			<?php } ?>
			<?php foreach($all_projects->result() as $projects):?>
				{
					project_id: '<?php echo $projects->project_id;?>',
					title: '<?php echo $projects->title;?>',
					start: '<?php echo $projects->start_date?>',
					end: '<?php echo $projects->end_date?>',
					color: '#F8B195',
					unq: '6',
				},
			<?php endforeach;?>
			<?php foreach($all_tugass->result() as $tugass):?>
				{
					tugas_id: '<?php echo $tugass->tugas_id;?>',
					title: '<?php echo $tugass->nama_tugas;?>',
					start: '<?php echo $tugass->start_date?>',
					end: '<?php echo $tugass->end_date?>',
					color: '#6C5B7B',
					unq: '7',
				},
			<?php endforeach;?>
			<?php foreach($all_events->result() as $events):?>
				{
					event_id: '<?php echo $events->event_id?>',
					title: '<?php echo $events->event_title?>',
					start: '<?php echo $events->event_date?>T<?php echo $events->event_time?>',
					color: '#355C7D',
					unq: '8',
				},
			<?php endforeach;?>
			<?php foreach($all_meetings->result() as $meetings):?>
				{
					meeting_id: '<?php echo $meetings->meeting_id?>',
					title: '<?php echo $meetings->title_meeting?>',
					start: '<?php echo $meetings->tanggal_meeting?>T<?php echo $meetings->waktu_meeting?>',
					color: '#547A8B',
					unq: '9',
					className: "regular"
				},
			<?php endforeach;?>
			<?php foreach($all_tujuans->result() as $tujuans):?>
				{
					tracking_id: '<?php echo $tujuans->tracking_id?>',
					title: '<?php echo $tujuans->subject?>',
					start: '<?php echo $tujuans->start_date?>',
					end: '<?php echo $tujuans->end_date?>',
					color: '#3EACAB',
					unq: '10',
					participant : ['uploads/profile/default_female.jpg','uploads/profile/default_male.jpg']
				},
			<?php endforeach;?>
			]
		}); 
$('.fc-icon-x').click(function() {
	$('#module-opt').hide();
});
$('.view-modal-data').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget);
	var ex_date = $('#exact_date').val();
	var recrd =  button.data('record');
	var modal = $(this);
	$.ajax({
		url : site_url+"calendar/add_record_cal/",
		type: "GET",
		data: 'jd=1&is_ajax=1&mode=modal&data=event&event_date='+ex_date+"&record="+recrd,
		success: function (response) {
			if(response) {
				$("#ajax_modal_view").html(response);
			}
		}
	});
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

<div id="module-opt" class="fc-popover fc-more-popover" style="display:none; z-index: 100;">
	<div class="fc-header fc-widget-header"> 
		<span class="fc-close fc-icon fc-icon-x"></span>
		<span class="fc-title"><?php echo $this->lang->line('umb_hr_add_options');?></span>
		<div class="fc-clear"></div>
	</div>
	<div class="fc-body fc-widget-content" style=" overflow: auto; height: 250px;">
		<div class="fc-event-container"> 
			<a data-toggle="modal" data-target=".view-modal-data" data-record="0" class="fc-day-grid-event fc-h-event fc-event fc-start fc-end  fc-draggable">
				<div class="fc-content"> 
					<span class="fc-title"><?php echo $this->lang->line('left_liburan');?></span>
				</div>
			</a> 
			<a data-toggle="modal" data-target=".view-modal-data" data-record="1" class="fc-day-grid-event fc-h-event fc-event fc-start fc-end  fc-draggable">
				<div class="fc-content"> 
					<span class="fc-title"><?php echo $this->lang->line('left_cuti');?></span>
				</div>
			</a>
			<?php if($system[0]->module_perjalanan=='true'){?>
				<a data-toggle="modal" data-target=".view-modal-data" data-record="2" class="fc-day-grid-event fc-h-event fc-event fc-start fc-end  fc-draggable">
					<div class="fc-content"> 
						<span class="fc-title"><?php echo $this->lang->line('umb_perjalanan');?></span>
					</div>
				</a>
			<?php } ?>
			<?php if($system[0]->module_training=='true'){?>
				<a data-toggle="modal" data-target=".view-modal-data" data-record="3" class="fc-day-grid-event fc-h-event fc-event fc-start fc-end  fc-draggable">
					<div class="fc-content"> 
						<span class="fc-title"><?php echo $this->lang->line('umb_hr_calendar_tranings');?></span>
					</div>
				</a>
			<?php } ?>
			<a data-toggle="modal" data-target=".view-modal-data" data-record="4" class="fc-day-grid-event fc-h-event fc-event fc-start fc-end  fc-draggable">
				<div class="fc-content"> 
					<span class="fc-title"><?php echo $this->lang->line('left_projects');?></span>
				</div>
			</a> 
			<a data-toggle="modal" data-target=".view-modal-data" data-record="5" class="fc-day-grid-event fc-h-event fc-event fc-start fc-end  fc-draggable">
				<div class="fc-content"> 
					<span class="fc-title"><?php echo $this->lang->line('left_tugass');?></span>
				</div>
			</a> 
			<a data-toggle="modal" data-target=".view-modal-data" data-record="6" class="fc-day-grid-event fc-h-event fc-event fc-start fc-end  fc-draggable">
				<div class="fc-content"> 
					<span class="fc-title"><?php echo $this->lang->line('umb_hr_events');?></span>
				</div>
			</a> <a data-toggle="modal" data-target=".view-modal-data" data-record="7" class="fc-day-grid-event fc-h-event fc-event fc-start fc-end  fc-draggable">
				<div class="fc-content"> 
					<span class="fc-title"><?php echo $this->lang->line('umb_hr_meetings');?></span>
				</div>
			</a> <a data-toggle="modal" data-target=".view-modal-data" data-record="8" class="fc-day-grid-event fc-h-event fc-event fc-start fc-end  fc-draggable">
				<div class="fc-content"> 
					<span class="fc-title"><?php echo $this->lang->line('umb_hr_set_tujuan');?></span>
				</div>
			</a> 
		</div>
	</div>
</div>
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
