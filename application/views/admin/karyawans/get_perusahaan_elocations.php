<?php $result = $this->Department_model->info_location_perusahaan($perusahaan_id);?>
<div class="form-group">
	<label class="form-label"><?php echo $this->lang->line('left_location');?><i class="hrastral-asterisk">*</i></label>
	<select class="form-control" name="location_id" id="aj_location_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_location');?>">
		<option value=""><?php echo $this->lang->line('left_location');?></option>
		<?php foreach($result as $location) {?>
			<option value="<?php echo $location->location_id?>"><?php echo $location->nama_location?></option>
		<?php } ?>
	</select>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
		$('[data-plugin="select_hrm"]').select2({ width:'100%' });
		jQuery("#aj_location_id").change(function(){
			jQuery.get(base_url+"/get_location_departments/"+jQuery(this).val(), function(data, status){
				jQuery('#department_ajax').html(data);
			});
		});
	});
</script>