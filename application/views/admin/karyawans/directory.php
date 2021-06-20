<?php $session = $this->session->userdata('username');?>
<?php $negaraa = $this->Umb_model->get_negaraa();?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>
<?php $role_resources_ids = $this->Umb_model->user_role_resource();?>
<?php $user_info = $this->Umb_model->read_user_info($session['user_id']);?>
<?php if($user_info[0]->user_role_id==1){ ?>
  <div class="ui-bordered px-4 pt-4 mb-4 mt-3">
    <?php $attributes = array('name' => 'ihr_report', 'id' => 'ihr_report', 'autocomplete' => 'off', 'class' => 'add form-hrm');?>
    <?php $hidden = array('user_id' => $session['user_id']);?>
    <?php echo form_open('admin/karyawans/hr', $attributes, $hidden);?>
    <?php
    $data = array(
      'type'        => 'hidden',
      'name'        => 'hrastral_directory',
      'id'          => 'date_format',
      'value'       => 1,
      'class'       => 'form-control',
    );
    echo form_input($data);
    ?>
    <div class="form-row">
      <div class="col-md mb-3">
        <label class="form-label"><?php echo $this->lang->line('left_perusahaan');?></label>
        <select class="form-control" name="perusahaan_id" id="filter_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_perusahaan');?>">
          <option value="0"><?php echo $this->lang->line('umb_acc_all');?></option>
          <?php foreach($get_all_perusahaans as $perusahaan) {?>
            <option value="<?php echo $perusahaan->perusahaan_id?>"><?php echo $perusahaan->name?></option>
          <?php } ?>
        </select>
      </div>
      <div class="col-md mb-3" id="ajax_flt_location">
        <label class="form-label"><?php echo $this->lang->line('left_location');?></label>
        <select name="location_id" id="filter_location" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_location');?>">
          <option value="0"><?php echo $this->lang->line('umb_acc_all');?></option>
        </select>
      </div>
      <div class="col-md mb-3" id="department_ajaxflt">
        <label class="form-label"><?php echo $this->lang->line('left_department');?></label>
        <select class="form-control" id="filter_department" name="department_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_department');?>" >
          <option value="0"><?php echo $this->lang->line('umb_acc_all');?></option>
        </select>
      </div>
      <div class="col-md mb-3" id="penunjukan_ajaxflt">
        <label class="form-label"><?php echo $this->lang->line('umb_penunjukan');?></label>
        <select class="form-control" name="penunjukan_id" data-plugin="select_hrm"  id="filter_penunjukan" data-placeholder="<?php echo $this->lang->line('umb_penunjukan');?>">
          <option value="0"><?php echo $this->lang->line('umb_acc_all');?></option>
        </select>
      </div>
      <div class="col-md col-xl-2 mb-4">
        <label class="form-label d-none d-md-block">&nbsp;</label>
        <?php echo form_button(array('name' => 'hrastral_form', 'type' => 'submit', 'class' => 'btn btn-secondary btn-block', 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('umb_get'))); ?>
      </div>
    </div>
    <?php echo form_close(); ?>
  </div>
<?php } ?>
<div class="d-flex flex-wrap justify-content-between ui-bordered px-3 pt-3 mb-4">
  <div>
    <div class="btn-group btn-group-toggle mb-3" data-toggle="buttons">
      <label class="btn btn-default icon-btn md-btn-flat active">
        <input type="radio" name="kontaks-view" value="kontaks-col-view" checked>
        <span class="ion ion-md-apps"></span> 
      </label>
      <label class="btn btn-default icon-btn md-btn-flat">
        <input type="radio" name="kontaks-view" value="kontaks-row-view">
        <span class="ion ion-md-menu"></span> 
      </label>
    </div>
    <?php if(in_array('201',$role_resources_ids)) {?>
      <button type="button" class="btn btn-outline-primary mb-3 ml-3" onclick="window.location='<?php echo site_url('admin/karyawans/');?>'"> 
        <span class="ion ion-md-add"></span>&nbsp; 
        <?php echo $this->lang->line('umb_add_new');?>
      </button>
    <?php } ?>
  </div>
</div>
<div class="row kontaks-col-view">
  <?php foreach($results as $karyawan) { ?>
    <?php
    if($karyawan->profile_picture!='' && $karyawan->profile_picture!='no file') {
      $u_file = base_url().'uploads/profile/'.$karyawan->profile_picture;
    } else {
      if($karyawan->jenis_kelamin=='Pria') { 
        $u_file = base_url().'uploads/profile/default_male.jpg';
      } else {
        $u_file = base_url().'uploads/profile/default_female.jpg';
      }
    }
    ?>
    <?php $penunjukan = $this->Penunjukan_model->read_informasi_penunjukan($karyawan->penunjukan_id);?>
    <?php
    if(!is_null($penunjukan)){
      $nama_penunjukan = strtolower($penunjukan[0]->nama_penunjukan);
    } else {
      $nama_penunjukan = '--';	
    }
    ?>
    <div class="kontaks-col col-12">
      <div class="card mb-4">
        <div class="card-body">
          <?php if(in_array('202',$role_resources_ids)) {?>
            <div class="kontaks-dropdown btn-group">
              <button type="button" class="btn btn-sm btn-default icon-btn borderless btn-round md-btn-flat dropdown-toggle hide-arrow" data-toggle="dropdown"> 
                <i class="ion ion-ios-more"></i> 
              </button>
              <div class="kontaks-dropdown-menu dropdown-menu dropdown-menu-right"> 
                <a class="dropdown-item" href="<?php echo site_url('admin/karyawans/detail')?>/<?php echo $karyawan->user_id;?>">Edit</a> 
              </div>
            </div>
          <?php } ?>
          <div class="contact-content"> 
            <img src="<?php echo $u_file;?>" class="contact-content-img rounded-circle" alt="">
            <div class="contact-content-about">
              <h5 class="contact-content-name mb-1"> 
                <?php if(in_array('202',$role_resources_ids)) {?>
                  <a href="<?php echo site_url('admin/karyawans/detail')?>/<?php echo $karyawan->user_id;?>" class="text-dark">
                    <?php echo $karyawan->first_name;?> <?php echo $karyawan->last_name;?></a>
                  <?php } else {?>
                    <a href="javascript:void();" class="text-dark"><?php echo $karyawan->first_name;?> <?php echo $karyawan->last_name;?></a>
                  <?php } ?>
                </h5>
                <div class="contact-content-user text-muted small mb-2"><?php echo $karyawan->email;?></div>
                <div class="small"> 
                  <strong><?php echo ucwords($nama_penunjukan);?></strong><br>
                  <?php echo $karyawan->no_kontak;?> 
                </div>
                <hr class="border-light">
                <div> 
                  <a target="_blank" href="<?php echo $karyawan->twitter_link;?>" class="text-twitter"> 
                    <span class="ion ion-logo-twitter"></span> 
                  </a> &nbsp;&nbsp; 
                  <a target="_blank" href="<?php echo $karyawan->facebook_link;?>" class="text-facebook"> 
                    <span class="ion ion-logo-facebook"></span> 
                  </a> &nbsp;&nbsp; 
                  <a target="_blank" href="<?php echo $karyawan->linkdedin_link;?>" class="text-linkdedin"> 
                    <span class="ion ion-logo-linkedin"></span> 
                  </a> 
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php } ?>
    <?php //} ?>
  </div>
  <?php if (isset($links)) { ?>
    <?php echo $links ?>
  <?php } ?>

