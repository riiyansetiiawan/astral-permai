<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>
<div class="box <?php echo $get_animate;?>">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $this->lang->line('umb_import_kehadiran_csv_file');?></h3>
  </div>
  <div class="box-body">
    <p class="card-text"><?php echo $this->lang->line('umb_kehadiran_description_line1');?></p>
    <p class="card-text"><?php echo $this->lang->line('umb_kehadiran_description_line2');?></p>
    <h6>
      <a href="<?php echo base_url();?>uploads/csv/sample-csv-kehadiran.csv" class="btn btn-info"> 
        <i class="fa fa-download"></i> <?php echo $this->lang->line('umb_kehadiran_download_sample');?> 
      </a>
    </h6>
    <?php $attributes = array('name' => 'import_kehadiran', 'id' => 'umb-form', 'autocomplete' => 'off');?>
    <?php $hidden = array('user_id' => $session['user_id']);?>
    <?php echo form_open_multipart('admin/timesheet/import_kehadiran', $attributes, $hidden);?>
    <fieldset class="form-group">
      <label for="logo"><?php echo $this->lang->line('umb_kehadiran_upload_file');?></label>
      <input type="file" class="form-control-file" id="file" name="file">
      <small><?php echo $this->lang->line('umb_kehadiran_allowed_size');?></small>
    </fieldset>
    <div class="mt-1">
      <div class="form-actions box-footer">
        <button type="submit" class="btn btn-primary"> 
          <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('umb_import_kehadiran');?> 
        </button>
      </div>
    </div>
    <?php echo form_close(); ?>
  </div>
</div>
