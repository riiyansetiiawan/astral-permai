<?php $result = $this->Penunjukan_model->ajax_informasi_penunjukan($department_id);?>
<?php
?>

<div class="form-group">
  <label for="penunjukan"><?php echo $this->lang->line('umb_penunjukan');?></label>
  <select class="form-control" name="penunjukan_id" id="penunjukan_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_penunjukan');?>">
    <option value="0"><?php echo $this->lang->line('umb_acc_all');?></option>
    <?php foreach($result as $penunjukan) {?>
    <option value="<?php echo $penunjukan->penunjukan_id?>"><?php echo $penunjukan->nama_penunjukan?></option>
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