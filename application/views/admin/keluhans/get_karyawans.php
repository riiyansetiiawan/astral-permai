<?php $result = $this->Department_model->ajax_info_perusahaan_karyawan($perusahaan_id);?>
<?php $role_resources_ids = $this->Umb_model->user_role_resource(); ?>
<?php $session = $this->session->userdata('username');?>
<?php $user_info = $this->Umb_model->read_user_info($session['user_id']);?>
<?php if($user_info[0]->user_role_id==1){ ?>
  <div class="form-group">
    <label for="umb_department_head"><?php echo $this->lang->line('umb_keluhan_dari');?></label>
    <select name="karyawan_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_choose_an_karyawan');?>">
      <option value=""></option>
      <?php foreach($result as $karyawan) {?>
        <option value="<?php echo $karyawan->user_id;?>"> <?php echo $karyawan->first_name.' '.$karyawan->last_name;?></option>
      <?php } ?>
    </select>             
  </div>
<?php } else { ?>
  <div class="form-group">
    <label for="umb_department_head"><?php echo $this->lang->line('umb_keluhan_dari');?></label>
    <select name="karyawan_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_choose_an_karyawan');?>">
      <option value=""></option>
      <?php foreach($result as $karyawan) {?>
        <?php if($session['user_id'] == $karyawan->user_id):?>
        	<option value="<?php echo $karyawan->user_id;?>"> <?php echo $karyawan->first_name.' '.$karyawan->last_name;?></option>
        <?php endif;?>
      <?php } ?>
    </select>             
  </div>
<?php } ?>
<script type="text/javascript">
  $(document).ready(function(){
   $('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
   $('[data-plugin="select_hrm"]').select2({ width:'100%' });
 });
</script>