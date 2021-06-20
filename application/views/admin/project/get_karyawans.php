<?php
//$result = $this->Umb_model->get_multi_perusahaan_karyawans($perusahaan_id);
$perusahaan_ids = explode(',',$perusahaan_id)?>
<div class="form-group">
  <label for="umb_project_manager"><?php echo $this->lang->line('umb_project_manager');?></label>
  <select multiple="multiple" name="assigned_to[]" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_project_manager');?>">
    <option value=""><?php echo $this->lang->line('umb_project_manager');?></option>
    <?php foreach($perusahaan_ids as $cid) {?>
      <?php $result = $this->Umb_model->get_multi_perusahaan_karyawans($cid); ?>
      <?php foreach($result as $re) {?>
        <option value="<?php echo $re->user_id;?>"> <?php echo $re->first_name.' '.$re->last_name;?></option>
      <?php } ?>
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