<?php $result = $this->Department_model->info_location_perusahaan($perusahaan_id);?>
<div class="form-group">
	<label class="form-label"><?php echo $this->lang->line('left_location');?></label>
	<select class="form-control" name="location_id" id="filter_location" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_location');?>">
		<option value="0"><?php echo $this->lang->line('umb_acc_all');?></option>
		<?php foreach($result as $location) {?>
			<option value="<?php echo $location->location_id?>"><?php echo $location->nama_location?></option>
		<?php } ?>
	</select>
</div>
<?php
//}
?>
<script type="text/javascript">
	$(document).ready(function(){
		$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
		$('[data-plugin="select_hrm"]').select2({ width:'100%' });
	// get departments
	jQuery("#filter_location").change(function(){
		if(jQuery(this).val() == 0){
			jQuery('#filter_perusahaan').prop('selectedIndex', 0);	
			jQuery('#filter_department').prop('selectedIndex', 0);
			jQuery('#filter_location').prop('selectedIndex', 0);
			jQuery('#filter_penunjukan').prop('selectedIndex', 0);
		}
		jQuery.get(site_url+"karyawans/filter_location_f_departments/"+jQuery(this).val(), function(data, status){
			jQuery('#department_ajaxflt').html(data);
		});
	});
});
</script>