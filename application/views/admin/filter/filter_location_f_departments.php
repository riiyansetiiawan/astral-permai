<?php $result = $this->Department_model->ajax_informasi_location_departments($location_id);?>
<?php $system = $this->Umb_model->read_setting_info(1);?>
<div class="form-group" id="ajx_department">
	<label class="form-label"><?php echo $this->lang->line('left_department');?></label>
	<select class="select2" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_department');?>" name="department_id" id="filter_department" >
		<option value="0"><?php echo $this->lang->line('umb_acc_all');?></option>
		<?php foreach($result as $deparment) {?>
			<option value="<?php echo $deparment->department_id?>"><?php echo $deparment->nama_department?></option>
		<?php } ?>
	</select>
</div>
<?php
//}
?>
<script type="text/javascript">
	$(document).ready(function(){
// get designations
jQuery("#filter_department").change(function(){
	if(jQuery(this).val() == 0){
		jQuery('#filter_perusahaan').prop('selectedIndex', 0);	
		jQuery('#filter_department').prop('selectedIndex', 0);
		jQuery('#filter_location').prop('selectedIndex', 0);
		jQuery('#filter_penunjukan').prop('selectedIndex', 0);
	}
	jQuery.get(site_url+"karyawans/filter_location_f_penunjukan/"+jQuery(this).val(), function(data, status){
		jQuery('#penunjukan_ajaxflt').html(data);
	});
});
$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
$('[data-plugin="select_hrm"]').select2({ width:'100%' });
});
</script>
<?php /*?><?php } ?><?php */?>