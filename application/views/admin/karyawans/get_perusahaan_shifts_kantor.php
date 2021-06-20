<?php $result = $this->Karyawans_model->ajax_perusahaan_informasi_shift_kantor($perusahaan_id);?>
<div class="form-group">
	<label class="form-label">
		<?php echo $this->lang->line('umb_karyawan_shift_kantor');?>
		<i class="hrastral-asterisk">*</i>
	</label>
	<select class="form-control" name="shift_kantor_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_karyawan_shift_kantor');?>">
		<option value=""><?php echo $this->lang->line('umb_karyawan_shift_kantor');?></option>
		<?php foreach($result as $shift) {?>
			<option value="<?php echo $shift->shift_kantor_id?>"><?php echo $shift->nama_shift?></option>
		<?php } ?>
	</select>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
		$('[data-plugin="select_hrm"]').select2({ width:'100%' });
	});
</script>