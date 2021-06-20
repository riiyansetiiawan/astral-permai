<?php $result = $this->Perusahaan_model->ajax_perusahaan_info_departments($perusahaan_id);?>

<div class="form-group">
  <label for="penunjukan"><?php echo $this->lang->line('umb_department');?></label>
  <select class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_select_department');?>" name="department_id" id="aj_department" >
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
jQuery("#aj_department").change(function(){
	jQuery.get(base_url+"/penunjukan/"+jQuery(this).val(), function(data, status){
		jQuery('#penunjukan_ajax').html(data);
	});
});
$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
$('[data-plugin="select_hrm"]').select2({ width:'100%' });
});
</script>