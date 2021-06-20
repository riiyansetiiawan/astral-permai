<?php 
$karyawan = $this->Umb_model->read_user_info($karyawan_id);
$result = $this->Penunjukan_model->ajax_is_informasi_penunjukan($karyawan[0]->department_id);
?>
<div class="form-group" id="ajx_penunjukan">
  <label for="penunjukan"><?php echo $this->lang->line('umb_penunjukan');?></label>
  <select class="form-control" name="penunjukan_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_penunjukan');?>">
    <option value=""></option>
    <?php foreach($result as $penunjukan) {?>
      <?php if($karyawan[0]->penunjukan_id!=$penunjukan->penunjukan_id):?>
       <option value="<?php echo $penunjukan->penunjukan_id?>"><?php echo $penunjukan->nama_penunjukan?></option>
     <?php endif;?>
   <?php } ?>
 </select>
</div>
<script type="text/javascript">
  $(document).ready(function(){	
   $('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
   $('[data-plugin="select_hrm"]').select2({ width:'100%' });
 });
</script>