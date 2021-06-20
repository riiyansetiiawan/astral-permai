<?php $result = $this->Department_model->ajax_info_perusahaan_karyawan($perusahaan_id);?>
<div class="form-group">
	<label class="form-label"><?php echo $this->lang->line('umb_karyawan');?></label>
	<select name="karyawan_id" id="cal_karyawan_id" class="form-control custom-select" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_choose_an_karyawan');?>" required>
		<option value=""></option>
		<?php foreach($result as $karyawan) {?>
			<option value="<?php echo $karyawan->user_id;?>"> <?php echo $karyawan->first_name.' '.$karyawan->last_name;?></option>
		<?php } ?>
	</select>                
</div>
<?php
//}
?>
<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
		jQuery('[data-plugin="select_hrm"]').select2({ width:'100%' });
	});
</script>