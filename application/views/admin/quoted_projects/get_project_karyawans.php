<?php $assigned_ids = explode(',',$assigned_to);?>
<?php $result = $this->Umb_model->all_karyawans();?>
<div class="form-group">
  <label for="umb_department_head"><?php echo $this->lang->line('umb_karyawan');?></label>
   <select name="karyawan_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_karyawan');?>">
    <option value=""></option>
    <?php foreach($result as $e_karyawan) {?>
	  <?php if(in_array($e_karyawan->user_id,$assigned_ids)){ ?>
      <option value="<?php echo $e_karyawan->user_id?>"> <?php echo $e_karyawan->first_name.' '.$e_karyawan->last_name;?></option>
      <?php } ?>
      <?php } ?>
  </select>             
</div>
<?php
//}
?>
<input type="hidden" value="<?php echo $perusahaan_id;?>" name="perusahaan_id" />
<script type="text/javascript">
$(document).ready(function(){
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
});
</script>