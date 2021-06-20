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
				element.attr('title',event.description).tooltip();
				element.attr('href', event.urllink);
			},
			defaultDate: '<?php echo $set_date;?>',
			eventLimit: true,
			navLinks: true,
			events: [
			<?php foreach($completed_invoices as $cinvoice):?>
				{
					title: '<?php echo $cinvoice->nomor_invoice;?>',
					description: '<?php echo $cinvoice->nomor_invoice;?>',
					start: '<?php echo $cinvoice->tanggal_invoice?>',
					end: '<?php echo $cinvoice->tanggal_invoice?>',
					urllink: '<?php echo site_url().'admin/invoices/view/'.$cinvoice->invoice_id;?>',
					color: '#02BC77 !important'
				},
			<?php endforeach;?>
			<?php foreach($pending_invoices as $pinvoice):?>
				{
					title: '<?php echo $pinvoice->nomor_invoice;?>',
					description: '<?php echo $pinvoice->nomor_invoice;?>',
					start: '<?php echo $pinvoice->tanggal_invoice?>',
					end: '<?php echo $pinvoice->tanggal_invoice?>',
					urllink: '<?php echo site_url().'admin/invoices/view/'.$pinvoice->invoice_id;?>',
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