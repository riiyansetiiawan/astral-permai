<?php $session = $this->session->userdata('username');?>
<?php $system = $this->Umb_model->read_setting_info(1);?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>
<?php $hrastral_versi = file_get_contents('http://localhost/hrastral_updates/hrastral_update_version.txt');?>
<div class="row <?php echo $get_animate;?>">
  <div class="col-md-6 mt-3 mb-1">
    <?php if($hrastral_versi != $this->Umb_model->hrastral_version()):?>
      <div class="alert alert-success alert-dismissible">
        <i class="icon fa fa-check"></i> 
        <?php echo $this->lang->line('umb_new_version_using_hrastral_available');?> 
        <?php echo $hrastral_versi;?>umb_app_update_new_version
      </div>
    <?php endif;?>
    <div class="alert alert-info alert-dismissible">
      <i class="icon fa fa-check"></i> <?php echo $this->lang->line('');?> <?php echo $this->Umb_model->hrastral_version();?>
    </div>
  </div>
</div>
<div class="row m-b-1 <?php echo $get_animate;?>">
  <?php $role_resources_ids = $this->Umb_model->user_role_resource(); ?>
  <div class="col-md-6">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title"> <?php echo $this->lang->line('umb_upgrade_to_latest_version').' '.$hrastral_versi;?> </h3>
      </div>
      <div class="box-body">
       <?php if($hrastral_versi == $this->Umb_model->hrastral_version()):?> 
         <div class="alert alert-success alert-dismissible">
          <?php echo $this->lang->line('umb_version_using_hrastral');?>
        </div>
      <?php else:?>
        <div class="form-actions box-footer">
          <button type="button" class="btn btn-primary" id="downloadButton"> 
            <i class="fa fa-check-square-o"></i> 
            <?php echo $this->lang->line('umb_update_hrastral').$hrastral_versi;?> 
          </button>
        </div>
      <?php endif;?>
    </div>
    <div id="dialog" title="Perbarui HR-ASTRAL">
      <div class="progress-label">Mulai Pembaruan...</div>
      <div id="progressbar"></div>
    </div>
  </div>
</div>
</div>
<script>
</script>
<style>
#progressbar {
  margin-top: 20px;
}
.progress-label {
  font-weight: bold;
  text-shadow: 1px 1px 0 #fff;
}
.ui-dialog-titlebar-close {
  display: none;
}
</style>