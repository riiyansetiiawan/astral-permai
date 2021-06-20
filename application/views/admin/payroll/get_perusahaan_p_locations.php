<?php $result = $this->Department_model->info_location_perusahaan($perusahaan_id);?>
<div class="form-group">
	<label for="penunjukan"><?php echo $this->lang->line('left_location');?></label>
	<select class="form-control" name="location_id" id="aj_location_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_location');?>">
		<option value="0"><?php echo $this->lang->line('umb_acc_all');?></option>
		<?php foreach($result as $location) {?>
			<option value="<?php echo $location->location_id?>"><?php echo $location->nama_location?></option>
		<?php } ?>
	</select>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
		jQuery("#aj_location_id").change(function(){
			jQuery.get(base_url+"/get_location_pdepartments/"+jQuery(this).val(), function(data, status){
				jQuery('#department_ajax').html(data);
			});
		});
	});
</script>