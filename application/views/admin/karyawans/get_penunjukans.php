<?php $system = $this->Umb_model->read_setting_info(1);?>
<?php if($system[0]->is_active_sub_departments=='yes'){?>
	<?php $result = $this->Penunjukan_model->ajax_informasi_penunjukan($subdepartment_id);?>
<?php } else {?>
	<?php $result = $this->Penunjukan_model->ajax_is_informasi_penunjukan($department_id);?>
<?php } ?>
<div class="form-group" id="penunjukan_ajax">
  <label class="form-label">
    <?php echo $this->lang->line('umb_penunjukan');?>
    <i class="hrastral-asterisk">*</i>
  </label>
  <select class="form-control" name="penunjukan_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_penunjukan');?>">
    <option value=""><?php echo $this->lang->line('umb_penunjukan');?></option>
    <?php foreach($result as $penunjukan) {?>
      <option value="<?php echo $penunjukan->penunjukan_id?>"><?php echo $penunjukan->nama_penunjukan?></option>
    <?php } ?>
  </select>
</div>
<script type="text/javascript">
  $(document).ready(function(){	
   $('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
   $('[data-plugin="select_hrm"]').select2({ width:'100%' });
 });
</script>