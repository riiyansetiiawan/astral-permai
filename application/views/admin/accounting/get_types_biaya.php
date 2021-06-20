<?php $types_biaya = $this->Keuangan_model->ajax_info_types_biaya_perusahaan($perusahaan_id);?>
<div class="form-group">
	<select required name="type_id" id="type_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_acc_select_type_biaya');?>">
		<option value="0"><?php echo $this->lang->line('umb_acc_all_types');?></option>
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