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
				//element.attr('href', 'javascript:void(0);');
				//element.attr('target', '_blank');
				element.click(function() {
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
			events: [
			<?php if(in_array('8',$role_resources_ids)) { ?>
				<?php foreach(record_transaksi_pendapatan() as $pendapatan):?>
					{
						transaksi_id: '<?php $pendapatan->transaksi_id?>',
						title: '<?php echo $pendapatan->description.'\n'.$this->Umb_model->currency_sign($pendapatan->jumlah)?>',
						start: '<?php echo $pendapatan->tanggal_transaksi?>',
						end: '<?php echo $pendapatan->tanggal_transaksi?>',
						color: '#00a65a',
						unq: '1',
					},
				<?php endforeach;?>
			<?php }?>
			<?php foreach(record_transaksi_awards() as $eawards):?>
				<?php
				$type_award = $this->Awards_model->read_informasi_type_award($eawards->type_award_id);
				if(!is_null($type_award)){
					$type_award = $type_award[0]->type_award;
				} else {
					$type_award = '--';	
				}
				?>
				{
					transaksi_id: '<?php echo $eawards->award_id?>',
					title: '<?php echo $type_award.'\n'.$this->Umb_model->currency_sign($eawards->cash_price)?>',
					start: '<?php echo $eawards->created_at?>',
					end: '<?php echo $eawards->created_at?>',
					color: '#d81b60',
					unq: '2',
				},
			<?php endforeach;?>
			<?php foreach(record_transaksi_perjalanan() as $eperjalanan):?>
				{
					transaksi_id: '<?php echo $eperjalanan->perjalanan_id?>',
					title: '<?php echo $eperjalanan->visit_purpose.'\n'.$this->Umb_model->currency_sign($eperjalanan->actual_budget)?>',
					start: '<?php echo $eperjalanan->start_date?>',
					end: '<?php echo $eperjalanan->end_date?>',
					color: '#3c8dbc',
					unq: '3',
				},
			<?php endforeach;?>
			<?php foreach(record_transaksi_payroll() as $epayroll):?>
				<?php
				if($epayroll->type_upahh == 0){
					$type_upahh = $this->lang->line('umb_payroll_gaji_pokok');
				} else {
					$type_upahh = $this->lang->line('umb_karyawan_upahh_harian');
				}
				$pd = date("Y-m-d", strtotime($epayroll->created_at));
				?>
				{
					transaksi_id: '<?php echo $epayroll->slipgaji_id?>',
					title: '<?php echo $type_upahh.'\n'.$this->Umb_model->currency_sign($epayroll->gaji_bersih)?>',
					start: '<?php echo $pd?>',
					end: '<?php echo $pd?>',
					color: '#00c0ef',
					unq: '4',
				},
			<?php endforeach;?>
			<?php foreach(record_transaksi_training() as $etraining):?>
				<?php
				$type = $this->Training_model->read_informasi_type_training($etraining->type_training_id);
				if(!is_null($type)){
					$itype = $type[0]->type;
				} else {
					$itype = '--';	
				}
				?>
				{
					transaksi_id: '<?php echo $etraining->training_id?>',
					title: '<?php echo $itype.'\n'.$this->Umb_model->currency_sign($etraining->biaya_training)?>',
					start: '<?php echo $etraining->start_date?>',
					end: '<?php echo $etraining->finish_date?>',
					color: '#f39c12',
					unq: '5',
				},
			<?php endforeach;?>
			<?php foreach(record_transaksi_pembayarans_invoice() as $pembayarans_invoice):?>
				<?php $jumlah_total = $this->Umb_model->currency_sign($pembayarans_invoice->jumlah);?>
				<?php
				$info_invoice = $this->Invoices_model->read_info_invoice($pembayarans_invoice->invoice_id);
				if(!is_null($info_invoice)){
					$no_inv = $info_invoice[0]->nomor_invoice;
				} else {
					$no_inv = '--';	
				}
				?>
				{
					title: '<?php echo $no_inv;?>',
					description: '<?php echo $no_inv.' ('.$jumlah_total.')';?>',
					start: '<?php echo $pembayarans_invoice->tanggal_transaksi?>',
					end: '<?php echo $pembayarans_invoice->tanggal_transaksi?>',
					urllink: '<?php echo site_url().'admin/invoices/view/'.$pembayarans_invoice->invoice_id;?>',
					color: '#605ca8'
				},
			<?php endforeach;?>
			]
		});
$('.fc-icon-x').click(function() {
	$('#module-opt').hide();
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
	.fc-event { line-height: 2.0 !important; }
</style>
