<?php $result = get_sub_departments($department_id);?>
<div class="form-group" id="subdepartment_ajax">
  <label class="form-label">
    <?php echo $this->lang->line('umb_hr_sub_department');?>
    <i class="hrastral-asterisk">*</i>
  </label>
  <select class="select2" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_select_department');?>" name="subdepartment_id" id="aj_subdepartment" >
    <option value=""><?php echo $this->lang->line('umb_hr_sub_department');?></option>
    <?php foreach($result as $deparment) {?>
      <option value="<?php echo $deparment->sub_department_id?>"><?php echo $deparment->nama_department?></option>
    <?php } ?>
  </select>
</div>
<script type="text/javascript">
  $(document).ready(function(){
    jQuery("#aj_subdepartment").change(function(){
      jQuery.get(base_url+"/penunjukan/"+jQuery(this).val(), function(data, status){
        jQuery('#penunjukan_ajax').html(data);
      });
    });
    $('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
    $('[data-plugin="select_hrm"]').select2({ width:'100%' });
  });
</script>