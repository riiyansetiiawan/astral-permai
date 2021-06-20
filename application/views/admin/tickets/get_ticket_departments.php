<?php $result = $this->Department_model->get_perusahaan_departments($perusahaan_id);?>
<?php $system = $this->Umb_model->read_setting_info(1);?>
<div class="form-group" id="department_ajaxflt">
  <label for="penunjukan"><?php echo $this->lang->line('umb_hr_main_department');?></label>
  <select class="select2" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_select_department');?>" name="department_id" id="department_idx" >
    <option value=""></option>
    <?php foreach($result->result() as $deparment) {?>
    <option value="<?php echo $deparment->department_id?>"><?php echo $deparment->nama_department?></option>
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
	// get sub departments
	jQuery("#department_idx").change(function(){
		jQuery.get(base_url+"/get_karyawans/"+jQuery(this).val(), function(data, status){
			jQuery('#ajax_karyawan').html(data);
		})
	});
});
</script>