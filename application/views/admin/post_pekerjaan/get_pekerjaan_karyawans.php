<?php $result = $this->Post_pekerjaan_model->ajax_informasi_pekerjaan_user($pekerjaan_id);?>
<?php
?>

<div class="form-group">
  <label for="interviewees"><?php echo $this->lang->line('umb_interviewees_kandidats_selected');?></label>
  <select multiple class="form-control" name="interviewees[]" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_kandidats');?>">
    <option value=""></option>
    <?php foreach($result as $karyawan_id) {?>
      <?php $user = $this->Umb_model->read_user_info($karyawan_id->user_id);?>
      <option value="<?php echo $user[0]->user_id;?>"><?php echo $user[0]->first_name. ' ' .$user[0]->last_name;?></option>
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