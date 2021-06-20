<?php $result = $this->Department_model->ajax_info_perusahaan_karyawan($perusahaan_id);?>
<div class="form-group">
	<label for="karyawan_id">
		<?php echo $this->lang->line('umb_assets_assign_to');?>
		<i class="hrastral-asterisk">*</i>
	</label>
	<select name="karyawan_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_choose_an_karyawan');?>">
		<option value=""></option>
		<?php foreach($result as $karyawan) {?>
			<option value="<?php echo $karyawan->user_id;?>"> <?php echo $karyawan->first_name.' '.$karyawan->last_name;?></option>
		<?php } ?>
	</select>             
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
		$('[data-plugin="select_hrm"]').select2({ width:'100%' });
	});
</script>