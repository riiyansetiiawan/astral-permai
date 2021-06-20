<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['pekerjaan_id']) && $_GET['data']=='apply_pekerjaan'){
  $session = $this->session->userdata('username');
  $user = $this->Umb_model->read_user_info($session['user_id']);
  ?>

  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
    <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_aplikasi_untuk_pekerjaan');?> <?php echo $title_pekerjaan;?></h4>
  </div>
  <?php $attributes = array('name' => 'apply_pekerjaan', 'id' => 'apply_pekerjaan', 'autocomplete' => 'off');?>
  <?php $hidden = array('_method' => 'Apply', 'pekerjaan_id' => $pekerjaan_id, 'user_id' => $session['user_id']);?>
  <?php echo form_open_multipart('frontend/pekerjaans/apply_pekerjaan/'.$pekerjaan_id, $attributes, $hidden);?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="name"><?php echo $this->lang->line('umb_karyawan_id');?></label>
              <input type="text" readonly="readonly" class="form-control" value="<?php echo $user[0]->karyawan_id;?>">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="email"><?php echo $this->lang->line('dashboard_fullname');?></label>
              <input type="text" readonly="readonly" class="form-control" value="<?php echo $user[0]->first_name. ' ' .$user[0]->last_name;?>">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="kontak"><?php echo $this->lang->line('dashboard_email');?></label>
              <input type="text" readonly="readonly" class="form-control" value="<?php echo $user[0]->email;?>">
            </div>
          </div>
        </div>
        <?php $system_setting = $this->Umb_model->read_setting_info(1);?>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="resume"><?php echo $this->lang->line('umb_upload_resume_from_pc');?></label>
              <span class="btn btn-primary btn-file"> <?php echo $this->lang->line('umb_browse');?>
              <input type="file" name="resume" id="resume">
            </span>
            <?php if($system_setting[0]->pekerjaan_application_format!=''){?>
              <br>
              <small><?php echo $this->lang->line('umb_upload_file_only_for_resume');?>: <?php echo $system_setting[0]->pekerjaan_application_format;?></small>
            <?php } ?>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label for="message"><?php echo $this->lang->line('umb_your_covering_message_for');?> <?php echo $title_pekerjaan;?></label>
            <textarea class="form-control" name="message" id="message" rows="5"></textarea>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('umb_close');?></button>
  <button type="submit" class="btn btn-primary"><?php echo $this->lang->line('umb_apply');?></button>
</div>
<?php echo form_close(); ?> 
<script type="text/javascript">
 $(document).ready(function(){		

  /* Edit data */
  $("#apply_pekerjaan").submit(function(e){
    var fd = new FormData(this);
    var obj = $(this), action = obj.attr('name');
    fd.append("is_ajax", 6);
    fd.append("add_type", 'apply_pekerjaan');
    fd.append("data", 'apply_pekerjaan');
    fd.append("form", action);
    e.preventDefault();
    $('.save').prop('disabled', true);
    $.ajax({
     url: e.target.action,
     type: "POST",
     data:  fd,
     contentType: false,
     cache: false,
     processData:false,
     success: function(JSON)
     {
      if (JSON.error != '') {
       toastr.error(JSON.error);
       $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
       $('.save').prop('disabled', false);
     } else {
       $('.apply-pekerjaan').modal('toggle');
       toastr.success(JSON.result);
       $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
       $('#apply_pekerjaan')[0].reset(); 
       $('.save').prop('disabled', false);
     }
   },
   error: function() 
   {
    toastr.error(JSON.error);
    $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
    $('.save').prop('disabled', false);
  } 	        
});
  });
});	
</script>
<?php }
?>
