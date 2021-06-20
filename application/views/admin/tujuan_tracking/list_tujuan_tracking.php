<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>
<?php $role_resources_ids = $this->Umb_model->user_role_resource(); ?>
<?php $user_info = $this->Umb_model->read_user_info($session['user_id']);?>
<?php $system = $this->Umb_model->read_setting_info(1); ?>
<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
   <?php if($system[0]->performance_option == 'both') {?>
    <?php if(in_array('42',$role_resources_ids)) {?>
      <li class="nav-item done">
        <a href="<?php echo site_url('admin/performance_appraisal/');?>" data-link-data="<?php echo site_url('admin/performance_appraisal/');?>" class="mb-3 nav-link hrastral-link">
          <span class="sw-icon oi oi-aperture"></span>
          <?php echo $this->lang->line('left_performance_xappraisal');?>
          <div class="text-muted small"><?php echo $this->lang->line('umb_set_up');?> <?php echo $this->lang->line('left_performance_xappraisal');?></div>
        </a>
      </li>
    <?php } ?>
    <?php if(in_array('41',$role_resources_ids)) {?>
      <li class="nav-item done">
        <a href="<?php echo site_url('admin/performance_indicator/');?>" data-link-data="<?php echo site_url('admin/performance_indicator/');?>" class="mb-3 nav-link hrastral-link">
          <span class="sw-icon ion ion-ios-contract"></span>
          <?php echo $this->lang->line('umb_indicator');?>
          <div class="text-muted small"><?php echo $this->lang->line('umb_set_up');?> <?php echo $this->lang->line('umb_indicator');?></div>
        </a>
      </li>
    <?php } ?>
  <?php } ?>
  <?php if(in_array('107',$role_resources_ids)) {?>
    <li class="nav-item active"> <a href="<?php echo site_url('admin/tujuan_tracking/');?>" data-link-data="<?php echo site_url('admin/tujuan_tracking/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon fas fa-cube"></span> <?php echo $this->lang->line('umb_hr_tujuan_tracking');?>
    <div class="text-muted small"><?php echo $this->lang->line('umb_set_up');?> <?php echo $this->lang->line('umb_hr_tujuan_tracking');?></div>
  </a> </li>
<?php } ?>  
<?php if(in_array('108',$role_resources_ids)) {?>
  <li class="nav-item done"> <a href="<?php echo site_url('admin/tujuan_tracking/type/');?>" data-link-data="<?php echo site_url('admin/tujuan_tracking/type/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon fab fa-typo3"></span> <?php echo $this->lang->line('umb_hr_type_tujuan_tracking_se');?>
  <div class="text-muted small"><?php echo $this->lang->line('umb_role_add');?> <?php echo $this->lang->line('umb_hr_type_tujuan_tracking_se');?></div>
</a> </li>
<?php } ?>  
</ul>
</div>
<hr class="border-light m-0 mb-3">
<?php if(in_array('334',$role_resources_ids)) {?>

  <div class="card mb-4 <?php echo $get_animate;?>">
    <div id="accordion">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_add_new');?></strong> <?php echo $this->lang->line('umb_hr_title_tujuan');?></span>
        <div class="card-header-elements ml-md-auto"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
          <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('umb_add_new');?></button>
        </a> </div>
      </div>
      <div id="add_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
        <div class="card-body">
          <?php $attributes = array('name' => 'add_tracking', 'id' => 'umb-form', 'autocomplete' => 'off');?>
          <?php $hidden = array('_user' => $session['user_id']);?>
          <?php echo form_open('admin/tujuan_tracking/add_tracking', $attributes, $hidden);?>
          <div class="bg-white">
            <div class="box-block">
              <div class="row">
                <div class="col-md-6">
                  <?php if($user_info[0]->user_role_id==1){ ?>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="nama_perusahaan"><?php echo $this->lang->line('module_title_perusahaan');?></label>
                          <select class="form-control" name="perusahaan" id="aj_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_title_perusahaan');?>">
                            <option value=""><?php echo $this->lang->line('umb_select_one');?></option>
                            <?php foreach($all_perusahaans as $perusahaan) {?>
                              <option value="<?php echo $perusahaan->perusahaan_id;?>"> <?php echo $perusahaan->name;?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                    </div>
                  <?php } else {?>
                    <?php $eperusahaan_id = $user_info[0]->perusahaan_id;?>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="nama_perusahaan"><?php echo $this->lang->line('module_title_perusahaan');?></label>
                          <select class="form-control" name="perusahaan" id="aj_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_title_perusahaan');?>">
                            <option value=""><?php echo $this->lang->line('umb_select_one');?></option>
                            <?php foreach($all_perusahaans as $perusahaan) {?>
                             <?php if($eperusahaan_id == $perusahaan->perusahaan_id):?>
                              <option value="<?php echo $perusahaan->perusahaan_id;?>"> <?php echo $perusahaan->name;?></option>
                            <?php endif;?>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                  </div>
                <?php } ?>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="type_tracking"><?php echo $this->lang->line('umb_hr_type_tujuan_tracking_se');?></label>
                      <select class="form-control" name="type_tracking" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_hr_type_tujuan_tracking_se');?>">
                        <option value=""></option>
                        <?php foreach($all_types_tracking as $type_tracking) {?>
                          <option value="<?php echo $type_tracking->type_tracking_id?>"><?php echo $type_tracking->type_name?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="umb_subject"><?php echo $this->lang->line('umb_subject');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('umb_subject');?>" name="subject" type="text" value="">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="target_achiement"><?php echo $this->lang->line('umb_hr_target_achiement');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('umb_hr_target_achiement');?>" name="target_achiement" type="text" value="">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="description"><?php echo $this->lang->line('umb_description');?></label>
                      <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('umb_description');?>" name="description" rows="5" id="description"></textarea>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="start_date"><?php echo $this->lang->line('umb_start_date');?></label>
                      <input class="form-control date" placeholder="<?php echo $this->lang->line('umb_start_date');?>" readonly name="start_date" type="text" value="">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="end_date"><?php echo $this->lang->line('umb_end_date');?></label>
                      <input class="form-control date" placeholder="<?php echo $this->lang->line('umb_end_date');?>" readonly name="end_date" type="text" value="">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-actions box-footer">
              <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('umb_save');?> </button>
            </div>
          </div>
        </div>
        <?php echo form_close(); ?> </div>
      </div>
    </div>
  </div>
<?php } ?>
<div class="card <?php echo $get_animate;?>">
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_list_all');?></strong> <?php echo $this->lang->line('umb_hr_tujuan_tracking');?></span> </div>
  <div class="card-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="umb_table">
        <thead>
          <tr>
            <th><?php echo $this->lang->line('umb_action');?></th>
            <th><?php echo $this->lang->line('umb_hr_type_tujuan_tracking_se');?></th>
            <th><?php echo $this->lang->line('left_perusahaan');?></th>
            <th><?php echo $this->lang->line('umb_hr_target_achiement');?></th>
            <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('umb_start_date');?></th>
            <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('umb_end_date');?></th>
            <th><?php echo $this->lang->line('dashboard_umb_progress');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
