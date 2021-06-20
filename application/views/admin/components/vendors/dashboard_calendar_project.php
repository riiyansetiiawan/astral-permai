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
		$('#calendar_projects').fullCalendar({
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
			
			<?php foreach($get_projects->result() as $project):?>
				{
					title: '<?php echo $project->title;?>',
					description: '<?php echo $project->title;?>',
					start: '<?php echo $project->start_date?>',
					end: '<?php echo $project->end_date?>',
					urllink: '<?php echo site_url().'admin/project/detail/'.$project->project_id;?>',
					color: '#00a65a'
				},
			<?php endforeach;?>
			<?php foreach($all_tugass->result() as $ctugass):?>
				<?php
				$tugas_cat = $this->Project_model->read_informasi_kategori_tugas($ctugass->nama_tugas);
				if(!is_null($tugas_cat)){
					$tname = $tugas_cat[0]->nama_kategori;
				} else {
					$tname = '';
				}
				?>
				{
					title: '<?php echo $tname;?>',
					description: '<?php echo $tname;?>',
					start: '<?php echo $ctugass->start_date?>',
					end: '<?php echo $ctugass->end_date?>',
					urllink: '<?php echo site_url().'admin/timesheet/details_tugas/id/'.$ctugass->tugas_id;?>',
					color: '#d81b60'
				},
			<?php endforeach;?>
			<?php foreach($get_invoices->result() as $cinvoice):?>
				{
					title: '<?php echo $cinvoice->nomor_invoice;?>',
					description: '<?php echo $cinvoice->nomor_invoice;?>',
					start: '<?php echo $cinvoice->tanggal_invoice?>',
					end: '<?php echo $cinvoice->tanggal_invoice?>',
					urllink: '<?php echo site_url().'admin/invoices/view/'.$cinvoice->invoice_id;?>',
					color: '#001f3f'
				},
			<?php endforeach;?>
			<?php foreach($get_quotes->result() as $pquote):?>
				{
					title: '<?php echo $pquote->quote_number;?>',
					description: '<?php echo $pquote->quote_number;?>',
					start: '<?php echo $pquote->quote_tanggal?>',
					end: '<?php echo $pquote->quote_tanggal?>',
					urllink: '<?php echo site_url().'admin/quotes/view/'.$pquote->quote_id;?>',
					color: '#39cccc'
				},
			<?php endforeach;?>
			<?php foreach($leads_follow_up_all as $follow_up):?>
				<?php
				$lead_info = $this->Clients_model->read_info_lead($follow_up->lead_id);
				if(!is_null($lead_info)) {
					$lead_name = $lead_info[0]->name;
					$urllink = site_url().'admin/leads/followup/'.$follow_up->lead_id;
				} else {
					$lead_name = '--';
					$urllink = '';
				}
				?>
				{
					title: '<?php echo $lead_name;?>',
					description: '<?php echo $follow_up->description?>',
					start: '<?php echo $follow_up->next_followup?>',
					end: '<?php echo $follow_up->next_followup?>',
					urllink: '<?php echo $urllink;?>',
					color: '#00c0ef'
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
					color: '#f39c12'
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