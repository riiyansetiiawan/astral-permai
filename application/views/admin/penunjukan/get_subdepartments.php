<?php $result = get_sub_departments($department_id);?>

<div class="form-group" id="ajx_department">
  <label for="penunjukan"><?php echo $this->lang->line('umb_hr_sub_department');?></label>
  <select class="select2" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_select_department');?>" name="subdepartment_id" id="aj_departments">
    <option value=""></option>
    <?php foreach($result as $deparment) {?>
    <option value="<?php echo $deparment->sub_department_id;?>"><?php echo $deparment->nama_department;?></option>
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
});
</script>