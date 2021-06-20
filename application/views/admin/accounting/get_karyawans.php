<?php $result = $this->Department_model->ajax_info_perusahaan_karyawan($perusahaan_id);?>
<div class="form-group">
	<label for="umb_department_head"><?php echo $this->lang->line('umb_acc_penerima_pembayaran');?></label>
	<select name="penerima_pembayaran_id" id="penerima_pembayaran_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_acc_choose_a_penerima_pembayaran');?>">
		<option value=""><?php echo $this->lang->line('umb_acc_penerima_pembayaran');?></option>
		<?php foreach($result as $karyawan) {?>
			<option value="<?php echo $karyawan->user_id;?>"> <?php echo $karyawan->first_name.' '.$karyawan->last_name;?></option>
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