<?php $types_biaya = $this->Keuangan_model->ajax_info_types_biaya_perusahaan($perusahaan_id);?>
<div class="form-group">
	<label for="karyawan"><?php echo $this->lang->line('umb_acc_kategori');?></label>
	<select required name="kategori_id" id="kategori_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_acc_kategori');?>">
		<option value=""><?php echo $this->lang->line('umb_acc_kategori');?></option>
		<?php foreach($types_biaya as $type_biaya) {?>
			<option value="<?php echo $type_biaya->type_biaya_id;?>"> <?php echo $type_biaya->name;?></option>
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