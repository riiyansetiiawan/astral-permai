<?php $penerima_pembayaran = $this->Keuangan_model->get_penerima_pembayarans();?>
<div class="form-group">
	<label for="penerima_pembayaran_id"><?php echo $this->lang->line('umb_acc_penerima_pembayaran');?></label>
	<select name="penerima_pembayaran_id" id="penerima_pembayaran_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_acc_penerima_pembayaran');?>">
		<option value=""></option>
		<?php foreach($penerima_pembayaran->result() as $paye) {?>
			<option value="<?php echo $paye->penerima_pembayaran_id?>"><?php echo $paye->nama_penerima_pembayaran;?></option>
		<?php } ?>
	</select>             
</div>
<?php
?>
<script type="text/javascript">
	$(document).ready(function(){
		$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
		$('[data-plugin="select_hrm"]').select2({ width:'100%' });
	});
</script>