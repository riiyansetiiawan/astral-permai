<?php $session = $this->session->userdata('username');?>
<?php $moduleInfo = $this->Umb_model->read_setting_info(1);?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>
<?php $role_resources_ids = $this->Umb_model->user_role_resource(); ?>
<div id="smarsdstwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/settings/');?>" data-link-data="<?php echo site_url('admin/settings/');?>" class="mb-3 nav-link hrastral-link"><span class="sw-icon fas fa-cog"></span> <?php echo $this->lang->line('umb_system');?>
    <div class="text-muted small"><?php echo $this->lang->line('header_configuration');?></div>
  </a> </li>
  <li class="nav-item active"> <a href="<?php echo site_url('admin/settings/constants/');?>" data-link-data="<?php echo site_url('admin/settings/constants/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon fas fa-adjust"></span> <?php echo $this->lang->line('left_constants');?>
  <div class="text-muted small"><?php echo $this->lang->line('umb_set_up_all_types');?></div>
</a> </li>
<li class="nav-item clickable"> <a href="<?php echo site_url('admin/settings/modules/');?>" data-link-data="<?php echo site_url('admin/settings/modules/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon fas fa-life-ring"></span> <?php echo $this->lang->line('umb_setup_modules');?>
<div class="text-muted small"><?php echo $this->lang->line('umb_enable_disable_modules');?></div>
</a> </li>
<li class="nav-item clickable"> <a href="<?php echo site_url('admin/settings/database_backup/');?>" data-link-data="<?php echo site_url('admin/settings/database_backup/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon fa fa-database"></span> <?php echo $this->lang->line('header_db_log');?>
<div class="text-muted small"><?php echo $this->lang->line('umb_database_backup_restore');?></div>
</a> </li>
<li class="nav-item clickable"> <a href="<?php echo site_url('admin/settings/email_template/');?>" data-link-data="<?php echo site_url('admin/settings/email_template/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon fas fa-envelope"></span> <?php echo $this->lang->line('left_email_templates');?>
<div class="text-muted small"><?php echo $this->lang->line('umb_set_up');?> <?php echo $this->lang->line('left_email_templates');?></div>
</a> </li>
</ul>
</div>   
<hr class="border-light m-0 mb-3">
<?php
$active448 = '';$active449 = '';$active450 = '';$active451 = '';$active452 = '';$active453 = '';$active454 = '';$active455 = '';
$active456 = '';$active457 = '';$active458 = '';$active459 = '';$active460 = '';$active461 = '';$active462 = '';$active463 = '';$active464 = '';

$actshow448 = '';$actshow449 = '';$actshow450 = '';$actshow451 = '';$actshow452 = '';$actshow453 = '';$actshow454 = '';$actshow455 = '';
$actshow456 = '';$actshow457 = '';$actshow458 = '';$actshow459 = '';$actshow460 = '';$actshow461 = '';$actshow462 = '';$actshow463 = '';$actshow464 = '';
$active = '';
$actshow = '';
if(in_array('448',$role_resources_ids)) {
  $active448 = 'active';
  $actshow448 = 'active show';
} else if(in_array('449',$role_resources_ids)) {
  $active449 = 'active';
  $actshow449 = 'active show';
} else if(in_array('450',$role_resources_ids)) {
  $active450 = 'active';
  $actshow450 = 'active show';
} else if(in_array('451',$role_resources_ids)) {
  $active451 = 'active';
  $actshow451 = 'active show';
} else if(in_array('452',$role_resources_ids)) {
  $active452 = 'active';
  $actshow452 = 'active show';
} else if(in_array('453',$role_resources_ids)) {
  $active453 = 'active';
  $actshow453 = 'active show';
} else if(in_array('454',$role_resources_ids)) {
  $active454 = 'active';
  $actshow454 = 'active show';
} else if(in_array('455',$role_resources_ids)) {
  $active455 = 'active';
  $actshow455 = 'active show';
} else if(in_array('456',$role_resources_ids)) {
  $active456 = 'active';
  $actshow456 = 'active show';
} else if(in_array('457',$role_resources_ids)) {
  $active457 = 'active';
  $actshow457 = 'active show';
} else if(in_array('458',$role_resources_ids)) {
  $active458 = 'active';
  $actshow458 = 'active show';
} else if(in_array('459',$role_resources_ids)) {
  $active459 = 'active';
  $actshow459 = 'active show';
} else if(in_array('460',$role_resources_ids)) {
  $active460 = 'active';
  $actshow460 = 'active show';
} else if(in_array('461',$role_resources_ids)) {
  $active461 = 'active';
  $actshow461 = 'active show';
} else if(in_array('462',$role_resources_ids)) {
  $active462 = 'active';
  $actshow462 = 'active show';
} else if(in_array('463',$role_resources_ids)) {
  $active463 = 'active';
  $actshow463 = 'active show';
} else if(in_array('464',$role_resources_ids)) {
  $active464 = 'active';
  $actshow464 = 'active show';
}
?>
<div class="card overflow-hidden">
  <div class="row no-gutters row-bordered row-border-light">
    <div class="col-md-3 pt-0">
      <div class="list-group list-group-flush account-settings-links">
        <?php if(in_array('448',$role_resources_ids)) { ?>
          <a class="list-group-item list-group-item-action <?php echo $active448;?>" data-toggle="list" href="#account-type_kontrak"><i class="lnr lnr-pencil text-lightest"></i> &nbsp; <?php echo $this->lang->line('umb_e_details_type_kontrak');?></a>
        <?php } ?>
        <?php if(in_array('449',$role_resources_ids)) { ?>
          <a class="list-group-item list-group-item-action <?php echo $active449;?>" data-toggle="list" href="#account-qualification"><i class="lnr lnr-coffee-cup text-lightest"></i> &nbsp; <?php echo $this->lang->line('umb_e_details_qualification');?></a>
        <?php } ?>
        <?php if(in_array('450',$role_resources_ids)) { ?>
          <a class="list-group-item list-group-item-action <?php echo $active450;?>" data-toggle="list" href="#account-dtype"><i class="lnr lnr-file-add text-lightest"></i> &nbsp; <?php echo $this->lang->line('umb_e_details_dtype');?></a>
        <?php } ?>
        <?php if($moduleInfo[0]->module_awards=='true' && in_array('451',$role_resources_ids)){?>
          <a class="list-group-item list-group-item-action <?php echo $active451;?>" data-toggle="list" href="#account-type_award"><i class="lnr lnr-strikethrough text-lightest"></i> &nbsp; <?php echo $this->lang->line('umb_type_award');?></a>
        <?php } ?>
        <?php if(in_array('452',$role_resources_ids)) { ?>
          <a class="list-group-item list-group-item-action <?php echo $active452;?>" data-toggle="list" href="#account-type_sukubangsa"><i class="lnr lnr-funnel text-lightest"></i> &nbsp; <?php echo $this->lang->line('umb_type_sukubangsa_title');?></a>
        <?php } ?>
        <?php if(in_array('453',$role_resources_ids)) { ?>
          <a class="list-group-item list-group-item-action <?php echo $active453;?>" data-toggle="list" href="#account-type_cuti"><i class="lnr lnr-rocket text-lightest"></i> &nbsp; <?php echo $this->lang->line('umb_type_cuti');?></a>
        <?php } ?>
        <?php if(in_array('454',$role_resources_ids)) { ?>
          <a class="list-group-item list-group-item-action <?php echo $active454;?>" data-toggle="list" href="#account-type_peringatan"><i class="lnr lnr-warning text-lightest"></i> &nbsp; <?php echo $this->lang->line('umb_type_peringatan');?></a>
        <?php } ?>
        <?php if(in_array('455',$role_resources_ids)) { ?>
          <a class="list-group-item list-group-item-action <?php echo $active455;?>" data-toggle="list" href="#account-type_biaya"><i class="pe-7s-door-lock text-lightest"></i> &nbsp; <?php echo $this->lang->line('umb_type_biaya');?></a>
        <?php } ?>
        <?php if(in_array('456',$role_resources_ids)) { ?>
          <a class="list-group-item list-group-item-action <?php echo $active456;?>" data-toggle="list" href="#account-type_pendapatan"><i class="lnr lnr-lighter text-lightest"></i> &nbsp; <?php echo $this->lang->line('umb_type_pendapatan');?></a>
        <?php } ?>
        <?php if($moduleInfo[0]->module_recruitment=='true'){?>
         <?php if(in_array('457',$role_resources_ids)) { ?>
          <a class="list-group-item list-group-item-action <?php echo $active457;?>" data-toggle="list" href="#account-type_pekerjaan"><i class="lnr lnr-line-spacing text-lightest"></i> &nbsp; <?php echo $this->lang->line('umb_type_pekerjaan');?></a>
        <?php } ?>
        <?php if(in_array('458',$role_resources_ids)) { ?>
          <a class="list-group-item list-group-item-action <?php echo $active458;?>" data-toggle="list" href="#account-kategoris_pekerjaan"><i class="lnr lnr-highlight text-lightest"></i> &nbsp; <?php echo $this->lang->line('umb_rec_kategoris_pekerjaan');?></a>
        <?php } ?>
      <?php } ?>
      <?php if(in_array('459',$role_resources_ids)) { ?>
        <a class="list-group-item list-group-item-action <?php echo $active459;?>" data-toggle="list" href="#account-type_currency"><i class="pe-7s-cash text-lightest"></i> &nbsp; <?php echo $this->lang->line('umb_type_currency');?></a>
      <?php } ?>
      <?php if(in_array('460',$role_resources_ids)) { ?>
        <a class="list-group-item list-group-item-action <?php echo $active460;?>" data-toggle="list" href="#account-type_perusahaan"><i class="lnr lnr-apartment text-lightest"></i> &nbsp; <?php echo $this->lang->line('umb_type_perusahaan');?></a>
      <?php } ?>
      <?php if(in_array('461',$role_resources_ids)) { ?>
        <a class="list-group-item list-group-item-action <?php echo $active461;?>" data-toggle="list" href="#account-security_level"><i class="lnr lnr-linearicons text-lightest"></i> &nbsp; <?php echo $this->lang->line('umb_security_level');?></a>
      <?php } ?>
      <?php if(in_array('462',$role_resources_ids)) { ?>
        <a class="list-group-item list-group-item-action <?php echo $active462;?>" data-toggle="list" href="#account-type_penghentian"><i class="lnr lnr-users text-lightest"></i> &nbsp; <?php echo $this->lang->line('umb_type_penghentian');?></a>
      <?php } ?>
      <?php if(in_array('463',$role_resources_ids)) { ?>
        <a class="list-group-item list-group-item-action <?php echo $active463;?>" data-toggle="list" href="#account-type_exit"><i class="lnr lnr-exit text-lightest"></i> &nbsp; <?php echo $this->lang->line('umb_karyawan_type_exit');?></a>
      <?php } ?>
      <?php if(in_array('464',$role_resources_ids)) { ?>
        <a class="list-group-item list-group-item-action <?php echo $active464;?>" data-toggle="list" href="#account-arrangement_type"><i class="lnr lnr-car text-lightest"></i> &nbsp; <?php echo $this->lang->line('umb_type_pengaturan_perjalanan');?></a>
      <?php } ?>
    </div>
  </div>
  <div class="col-md-9">
    <div class="tab-content">
      <div class="tab-pane fade <?php echo $actshow448;?>" id="account-type_kontrak">
        <div class="row">
          <div class="col-md-12">
            <div class="box">
              <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong><?php echo $this->lang->line('umb_add_new');?></strong> <?php echo $this->lang->line('umb_e_details_type_kontrak');?></span> </div>
              <div class="card-body">
                <?php $attributes = array('name' => 'info_type_kontrak', 'id' => 'info_type_kontrak', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
                <?php $hidden = array('set_type_kontrak' => 'UPDATE');?>
                <?php echo form_open('admin/settings/info_type_kontrak/', $attributes, $hidden);?>
                <div class="form-group">
                  <label class="form-label"><?php echo $this->lang->line('umb_e_details_type_kontrak');?></label>
                  <input type="text" class="form-control" name="type_kontrak" placeholder="<?php echo $this->lang->line('umb_e_details_type_kontrak');?>">
                </div>
                <div class="form-actions box-footer">
                  <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('umb_save');?> </button>
                </div>
                <?php echo form_close(); ?> </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="box">
                <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong><?php echo $this->lang->line('umb_list_all');?></strong> <?php echo $this->lang->line('umb_e_details_type_kontrak');?></span> </div>
                <div class="card-body">
                  <div class="card-datatable table-responsive">
                    <table class="datatables-demo table table-striped table-bordered" id="umb_table_type_kontrak">
                      <thead>
                        <tr>
                          <th><?php echo $this->lang->line('umb_action');?></th>
                          <th><?php echo $this->lang->line('umb_e_details_type_kontrak');?></th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane fade <?php echo $actshow449;?>" id="account-qualification">
          <div class="row">
            <div class="col-xl-12">

              <div class="nav-tabs-top mb-4">
                <ul class="nav nav-tabs">
                  <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#umb_e_details_edu_level"><?php echo $this->lang->line('umb_e_details_edu_level');?></a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#umb_e_details_language"><?php echo $this->lang->line('umb_e_details_language');?></a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#umb_skill"><?php echo $this->lang->line('umb_skill');?></a>
                  </li>
                </ul>
                <div class="tab-content">
                  <div class="tab-pane fade show active" id="umb_e_details_edu_level">
                    <div class="card-body">
                      <div class="row mb-4">
                        <div class="col-md-12">
                          <div class="box">
                            <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong><?php echo $this->lang->line('umb_add_new');?></strong> <?php echo $this->lang->line('umb_e_details_edu_level');?></span> </div>
                            <div class="card-body">
                              <?php $attributes = array('name' => 'info_tingkat_pddkn', 'id' => 'info_tingkat_pddkn', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
                              <?php $hidden = array('set_type_document' => 'UPDATE');?>
                              <?php echo form_open('admin/settings/info_tingkat_pddkn/', $attributes, $hidden);?>
                              <div class="form-group">
                                <label class="form-label"><?php echo $this->lang->line('umb_e_details_edu_level');?></label>
                                <input type="text" class="form-control" name="name" placeholder="<?php echo $this->lang->line('umb_e_details_edu_level');?>">
                              </div>
                              <div class="form-actions box-footer">
                                <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('umb_save');?> </button>
                              </div>
                              <?php echo form_close(); ?> </div>
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="box">
                              <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong><?php echo $this->lang->line('umb_list_all');?></strong> <?php echo $this->lang->line('umb_e_details_edu_level');?></span> </div>
                              <div class="card-body">
                                <div class="card-datatable table-responsive">
                                  <table class="datatables-demo table table-striped table-bordered" id="umb_table_tingkat_pendidikan">
                                    <thead>
                                      <tr>
                                        <th><?php echo $this->lang->line('umb_action');?></th>
                                        <th><?php echo $this->lang->line('umb_e_details_edu_level');?></th>
                                      </tr>
                                    </thead>
                                  </table>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="umb_e_details_language">
                      <div class="card-body">
                        <div class="row mb-4">
                          <div class="col-md-12">
                            <div class="box">
                              <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong><?php echo $this->lang->line('umb_add_new');?></strong> <?php echo $this->lang->line('umb_e_details_language');?></span> </div>
                              <div class="card-body">
                                <?php $attributes = array('name' => 'info_edu_language', 'id' => 'info_edu_language', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
                                <?php $hidden = array('set_edu_language' => 'UPDATE');?>
                                <?php echo form_open('admin/settings/info_edu_language/', $attributes, $hidden);?>
                                <div class="form-group">
                                  <label class="form-label"><?php echo $this->lang->line('umb_e_details_language');?></label>
                                  <input type="text" class="form-control" name="name" placeholder="<?php echo $this->lang->line('umb_e_details_language');?>">
                                </div>
                                <div class="form-actions box-footer">
                                  <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('umb_save');?> </button>
                                </div>
                                <?php echo form_close(); ?> </div>
                              </div>
                            </div>
                            <div class="col-md-12">
                              <div class="box">
                                <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong><?php echo $this->lang->line('umb_list_all');?></strong> <?php echo $this->lang->line('umb_e_details_language');?></span> </div>
                                <div class="card-body">
                                  <div class="card-datatable table-responsive">
                                    <table class="datatables-demo table table-striped table-bordered" id="umb_table_qualification_language">
                                      <thead>
                                        <tr>
                                          <th><?php echo $this->lang->line('umb_action');?></th>
                                          <th><?php echo $this->lang->line('umb_e_details_language');?></th>
                                        </tr>
                                      </thead>
                                    </table>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="tab-pane fade" id="umb_skill">
                        <div class="card-body">
                          <div class="row">
                            <div class="col-md-12">
                              <div class="box">
                                <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong><?php echo $this->lang->line('umb_add_new');?></strong> <?php echo $this->lang->line('umb_skill');?></span> </div>
                                <div class="card-body">
                                  <?php $attributes = array('name' => 'info_edu_skill', 'id' => 'info_edu_skill', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
                                  <?php $hidden = array('set_edu_skill' => 'UPDATE');?>
                                  <?php echo form_open('admin/settings/info_edu_skill/', $attributes, $hidden);?>
                                  <div class="form-group">
                                    <label class="form-label"><?php echo $this->lang->line('umb_skill');?></label>
                                    <input type="text" class="form-control" name="name" placeholder="<?php echo $this->lang->line('umb_skill');?>">
                                  </div>
                                  <div class="form-actions box-footer">
                                    <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('umb_save');?> </button>
                                  </div>
                                  <?php echo form_close(); ?> </div>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="box">
                                  <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong><?php echo $this->lang->line('umb_list_all');?></strong> <?php echo $this->lang->line('umb_skill');?></span> </div>
                                  <div class="card-body">
                                    <div class="card-datatable table-responsive">
                                      <table class="datatables-demo table table-striped table-bordered" id="umb_table_qualification_skill">
                                        <thead>
                                          <tr>
                                            <th><?php echo $this->lang->line('umb_action');?></th>
                                            <th><?php echo $this->lang->line('umb_skill');?></th>
                                          </tr>
                                        </thead>
                                      </table>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>             
                </div>
              </div>
              <div class="tab-pane fade <?php echo $actshow450;?>" id="account-dtype">
                <div class="row">
                  <div class="col-md-12">
                    <div class="box">
                      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('umb_add_new');?></strong> <?php echo $this->lang->line('umb_e_details_dtype');?> </span> </div>
                      <div class="card-body">
                        <?php $attributes = array('name' => 'info_type_document', 'id' => 'info_type_document', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
                        <?php $hidden = array('set_type_document' => 'UPDATE');?>
                        <?php echo form_open('admin/settings/info_type_document/', $attributes, $hidden);?>
                        <div class="form-group">
                          <label class="form-label"><?php echo $this->lang->line('umb_e_details_dtype');?></label>
                          <input type="text" class="form-control" name="type_document" placeholder="<?php echo $this->lang->line('umb_e_details_dtype');?>">
                        </div>
                        <div class="form-actions box-footer">
                          <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('umb_save');?> </button>
                        </div>
                        <?php echo form_close(); ?> </div>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="box">
                        <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('umb_list_all');?></strong> <?php echo $this->lang->line('umb_e_details_dtype');?> </span> </div>
                        <div class="card-body">
                          <div class="card-datatable table-responsive">
                            <table class="datatables-demo table table-striped table-bordered" id="umb_table_type_document">
                              <thead>
                                <tr>
                                  <th><?php echo $this->lang->line('umb_action');?></th>
                                  <th><?php echo $this->lang->line('umb_e_details_dtype');?></th>
                                </tr>
                              </thead>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="tab-pane fade <?php echo $actshow451;?>" id="account-type_award">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="box">
                        <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('umb_add_new');?></strong> <?php echo $this->lang->line('umb_type_award');?> </span> </div>
                        <div class="card-body">
                          <?php $attributes = array('name' => 'info_type_award', 'id' => 'info_type_award', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
                          <?php $hidden = array('set_type_award' => 'UPDATE');?>
                          <?php echo form_open('admin/settings/info_type_award/', $attributes, $hidden);?>
                          <div class="form-group">
                            <label class="form-label"><?php echo $this->lang->line('umb_type_award');?></label>
                            <input type="text" class="form-control" name="type_award" placeholder="<?php echo $this->lang->line('umb_type_award');?>">
                          </div>
                          <div class="form-actions box-footer">
                            <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('umb_save');?> </button>
                          </div>
                          <?php echo form_close(); ?> 
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="box">
                        <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('umb_list_all');?></strong> <?php echo $this->lang->line('umb_type_award');?> </span> </div>
                        <div class="card-body">
                          <div class="card-datatable table-responsive">
                            <table class="datatables-demo table table-striped table-bordered" id="umb_table_type_award">
                              <thead>
                                <tr>
                                  <th><?php echo $this->lang->line('umb_action');?></th>
                                  <th><?php echo $this->lang->line('umb_type_award');?></th>
                                </tr>
                              </thead>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="tab-pane fade <?php echo $actshow452;?>" id="account-type_sukubangsa">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="box">
                        <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('umb_add_new');?></strong> <?php echo $this->lang->line('umb_type_sukubangsa_title');?> </span> </div>
                        <div class="card-body">
                          <?php $attributes = array('name' => 'info_type_sukubangsa', 'id' => 'info_type_sukubangsa', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
                          <?php $hidden = array('set_type_sukubangsa' => 'UPDATE');?>
                          <?php echo form_open('admin/settings/info_type_sukubangsa/', $attributes, $hidden);?>
                          <div class="form-group">
                            <label class="form-label"><?php echo $this->lang->line('umb_type_sukubangsa_title');?></label>
                            <input type="text" class="form-control" name="type_sukubangsa" placeholder="<?php echo $this->lang->line('umb_type_sukubangsa_title');?>">
                          </div>
                          <div class="form-actions box-footer">
                            <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('umb_save');?> </button>
                          </div>
                          <?php echo form_close(); ?> </div>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="box">
                          <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('umb_list_all');?></strong> <?php echo $this->lang->line('umb_type_sukubangsa_title');?> </span> </div>
                          <div class="card-body">
                            <div class="card-datatable table-responsive">
                              <table class="datatables-demo table table-striped table-bordered" id="umb_table_type_sukubangsa">
                                <thead>
                                  <tr>
                                    <th><?php echo $this->lang->line('umb_action');?></th>
                                    <th><?php echo $this->lang->line('umb_type_sukubangsa_title');?></th>
                                  </tr>
                                </thead>
                              </table>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade <?php echo $actshow453;?>" id="account-type_cuti">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="box">
                          <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('umb_add_new');?></strong> <?php echo $this->lang->line('umb_type_cuti');?> </span> </div>
                          <div class="card-body">
                            <?php $attributes = array('name' => 'info_type_cuti', 'id' => 'info_type_cuti', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
                            <?php $hidden = array('set_type_cuti' => 'UPDATE');?>
                            <?php echo form_open('admin/settings/info_type_cuti/', $attributes, $hidden);?>
                            <div class="form-group">
                              <label class="form-label"><?php echo $this->lang->line('umb_type_cuti');?></label>
                              <input type="text" class="form-control" name="type_cuti" placeholder="<?php echo $this->lang->line('umb_type_cuti');?>">
                            </div>
                            <div class="form-group">
                              <label for="name"><?php echo $this->lang->line('umb_days_per_year');?></label>
                              <input type="text" class="form-control" name="days_per_year" placeholder="<?php echo $this->lang->line('umb_days_per_year');?>">
                            </div>
                            <div class="form-actions box-footer">
                              <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('umb_save');?> </button>
                            </div>
                            <?php echo form_close(); ?> </div>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="box">
                            <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('umb_list_all');?></strong> <?php echo $this->lang->line('umb_type_cuti');?> </span> </div>
                            <div class="card-body">
                              <div class="card-datatable table-responsive">
                                <table class="datatables-demo table table-striped table-bordered" id="umb_table_type_cuti">
                                  <thead>
                                    <tr>
                                      <th><?php echo $this->lang->line('umb_action');?></th>
                                      <th><?php echo $this->lang->line('umb_type_cuti');?></th>
                                      <th><?php echo $this->lang->line('umb_days_per_year');?></th>
                                    </tr>
                                  </thead>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane fade <?php echo $actshow454;?>" id="account-type_peringatan">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="box">
                            <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('umb_add_new');?></strong> <?php echo $this->lang->line('umb_type_peringatan');?> </span> </div>
                            <div class="card-body">
                              <?php $attributes = array('name' => 'info_type_peringatan', 'id' => 'info_type_peringatan', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
                              <?php $hidden = array('set_type_peringatan' => 'UPDATE');?>
                              <?php echo form_open('admin/settings/info_type_peringatan/', $attributes, $hidden);?>
                              <div class="form-group">
                                <label class="form-label"><?php echo $this->lang->line('umb_type_peringatan');?></label>
                                <input type="text" class="form-control" name="type_peringatan" placeholder="<?php echo $this->lang->line('umb_type_peringatan');?>">
                              </div>
                              <div class="form-actions box-footer">
                                <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('umb_save');?> </button>
                              </div>
                              <?php echo form_close(); ?> </div>
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="box">
                              <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('umb_list_all');?></strong> <?php echo $this->lang->line('umb_type_peringatan');?> </span> </div>
                              <div class="card-body">
                                <div class="card-datatable table-responsive">
                                  <table class="datatables-demo table table-striped table-bordered" id="umb_table_type_peringatan">
                                    <thead>
                                      <tr>
                                        <th><?php echo $this->lang->line('umb_action');?></th>
                                        <th><?php echo $this->lang->line('umb_type_peringatan');?></th>
                                      </tr>
                                    </thead>
                                  </table>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="tab-pane fade <?php echo $actshow462;?>" id="account-type_penghentian">
                        <div class="row">
                          <div class="col-md-12">
                            <div class="box">
                              <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('umb_add_new');?></strong> <?php echo $this->lang->line('umb_type_penghentian');?> </span> </div>
                              <div class="card-body">
                                <?php $attributes = array('name' => 'info_type_penghentian', 'id' => 'info_type_penghentian', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
                                <?php $hidden = array('set_type_penghentian' => 'UPDATE');?>
                                <?php echo form_open('admin/settings/info_type_penghentian/', $attributes, $hidden);?>
                                <div class="form-group">
                                  <label class="form-label"><?php echo $this->lang->line('umb_type_penghentian');?></label>
                                  <input type="text" class="form-control" name="type_penghentian" placeholder="<?php echo $this->lang->line('umb_type_penghentian');?>">
                                </div>
                                <div class="form-actions box-footer">
                                  <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('umb_save');?> </button>
                                </div>
                                <?php echo form_close(); ?> </div>
                              </div>
                            </div>
                            <div class="col-md-12">
                              <div class="box">
                                <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('umb_list_all');?></strong> <?php echo $this->lang->line('umb_type_penghentian');?> </span> </div>
                                <div class="card-body">
                                  <div class="card-datatable table-responsive">
                                    <table class="datatables-demo table table-striped table-bordered" id="umb_table_type_penghentian">
                                      <thead>
                                        <tr>
                                          <th><?php echo $this->lang->line('umb_action');?></th>
                                          <th><?php echo $this->lang->line('umb_type_penghentian');?></th>
                                        </tr>
                                      </thead>
                                    </table>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="tab-pane fade <?php echo $actshow455;?>" id="account-type_biaya">
                          <div class="row">
                            <div class="col-md-12">
                              <div class="box">
                                <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('umb_add_new');?></strong> <?php echo $this->lang->line('umb_type_biaya');?> </span> </div>
                                <div class="card-body">
                                  <?php $attributes = array('name' => 'info_type_biaya', 'id' => 'info_type_biaya', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
                                  <?php $hidden = array('set_type_biaya' => 'UPDATE');?>
                                  <?php echo form_open('admin/settings/info_type_biaya/', $attributes, $hidden);?>
                                  <div class="form-group">
                                    <label class="form-label"><?php echo $this->lang->line('module_title_perusahaan');?></label>
                                    <select class="form-control" name="perusahaan" id="aj_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_title_perusahaan');?>">
                                      <option value=""><?php echo $this->lang->line('umb_select_one');?></option>
                                      <?php foreach($all_perusahaans as $perusahaan) {?>
                                        <option value="<?php echo $perusahaan->perusahaan_id;?>"> <?php echo $perusahaan->name;?></option>
                                      <?php } ?>
                                    </select>
                                  </div>
                                  <div class="form-group">
                                    <label class="form-label"><?php echo $this->lang->line('umb_type_biaya');?></label>
                                    <input type="text" class="form-control" name="type_biaya" placeholder="<?php echo $this->lang->line('umb_type_biaya');?>">
                                  </div>
                                  <div class="form-actions box-footer">
                                    <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('umb_save');?> </button>
                                  </div>
                                  <?php echo form_close(); ?> </div>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="box">
                                  <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('umb_list_all');?></strong> <?php echo $this->lang->line('umb_type_biaya');?> </span> </div>
                                  <div class="card-body">
                                    <div class="card-datatable table-responsive">
                                      <table class="datatables-demo table table-striped table-bordered" id="umb_table_type_biaya">
                                        <thead>
                                          <tr>
                                            <th><?php echo $this->lang->line('umb_action');?></th>
                                            <th><?php echo $this->lang->line('left_perusahaan');?></th>
                                            <th><?php echo $this->lang->line('umb_type_biaya');?></th>
                                          </tr>
                                        </thead>
                                      </table>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="tab-pane fade <?php echo $actshow456;?>" id="account-type_pendapatan">
                            <div class="row">
                              <div class="col-md-12">
                                <div class="box">
                                  <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('umb_add_new');?></strong> <?php echo $this->lang->line('umb_type_pendapatan');?> </span> </div>
                                  <div class="card-body">
                                    <?php $attributes = array('name' => 'info_type_pendapatan', 'id' => 'info_type_pendapatan', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
                                    <?php $hidden = array('set_type_sukubangsa' => 'UPDATE');?>
                                    <?php echo form_open('admin/settings/info_type_pendapatan/', $attributes, $hidden);?>
                                    <div class="form-group">
                                      <label class="form-label"><?php echo $this->lang->line('umb_type_pendapatan');?></label>
                                      <input type="text" class="form-control" name="type_pendapatan" placeholder="<?php echo $this->lang->line('umb_type_pendapatan');?>">
                                    </div>
                                    <div class="form-actions box-footer">
                                      <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('umb_save');?> </button>
                                    </div>
                                    <?php echo form_close(); ?> </div>
                                  </div>
                                </div>
                                <div class="col-md-12">
                                  <div class="box">
                                    <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('umb_list_all');?></strong> <?php echo $this->lang->line('umb_type_pendapatan');?> </span> </div>
                                    <div class="card-body">
                                      <div class="card-datatable table-responsive">
                                        <table class="datatables-demo table table-striped table-bordered" id="umb_table_type_pendapatan">
                                          <thead>
                                            <tr>
                                              <th><?php echo $this->lang->line('umb_action');?></th>
                                              <th><?php echo $this->lang->line('umb_type_pendapatan');?></th>
                                            </tr>
                                          </thead>
                                        </table>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <?php if($moduleInfo[0]->module_recruitment=='true'){?>
                              <div class="tab-pane fade <?php echo $actshow457;?>" id="account-type_pekerjaan">
                                <div class="row">
                                  <div class="col-md-12">
                                    <div class="box">
                                      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('umb_add_new');?></strong> <?php echo $this->lang->line('umb_type_pekerjaan');?> </span> </div>
                                      <div class="card-body">
                                        <?php $attributes = array('name' => 'info_type_pekerjaan', 'id' => 'info_type_pekerjaan', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
                                        <?php $hidden = array('set_type_pekerjaan' => 'UPDATE');?>
                                        <?php echo form_open('admin/settings/info_type_pekerjaan/', $attributes, $hidden);?>
                                        <div class="form-group">
                                          <label class="form-label"><?php echo $this->lang->line('umb_type_pekerjaan');?></label>
                                          <input type="text" class="form-control" name="type_pekerjaan" placeholder="<?php echo $this->lang->line('umb_type_pekerjaan');?>">
                                        </div>
                                        <div class="form-actions box-footer">
                                          <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('umb_save');?> </button>
                                        </div>
                                        <?php echo form_close(); ?> </div>
                                      </div>
                                    </div>
                                    <div class="col-md-12">
                                      <div class="box">
                                        <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('umb_list_all');?></strong> <?php echo $this->lang->line('umb_type_pekerjaan');?> </span> </div>
                                        <div class="card-body">
                                          <div class="card-datatable table-responsive">
                                            <table class="datatables-demo table table-striped table-bordered" id="umb_table_type_pekerjaan">
                                              <thead>
                                                <tr>
                                                  <th><?php echo $this->lang->line('umb_action');?></th>
                                                  <th><?php echo $this->lang->line('umb_type_pekerjaan');?></th>
                                                </tr>
                                              </thead>
                                            </table>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="tab-pane fade <?php echo $actshow458;?>" id="account-kategoris_pekerjaan">
                                  <div class="row">
                                    <div class="col-md-12">
                                      <div class="box">
                                        <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('umb_add_new');?></strong> <?php echo $this->lang->line('umb_rec_kategori_pekerjaan');?> </span> </div>
                                        <div class="card-body">
                                          <?php $attributes = array('name' => 'info_kategori_pekerjaan', 'id' => 'info_kategori_pekerjaan', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
                                          <?php $hidden = array('set_type_pekerjaan' => 'UPDATE');?>
                                          <?php echo form_open('admin/settings/info_kategori_pekerjaan/', $attributes, $hidden);?>
                                          <div class="form-group">
                                            <label class="form-label"><?php echo $this->lang->line('umb_rec_kategori_pekerjaan');?></label>
                                            <input type="text" class="form-control" name="kategori_pekerjaan" placeholder="<?php echo $this->lang->line('umb_rec_kategori_pekerjaan');?>">
                                          </div>
                                          <div class="form-actions box-footer">
                                            <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('umb_save');?> </button>
                                          </div>
                                          <?php echo form_close(); ?> </div>
                                        </div>
                                      </div>
                                      <div class="col-md-12">
                                        <div class="box">
                                          <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('umb_list_all');?></strong> <?php echo $this->lang->line('umb_rec_kategoris_pekerjaan');?> </span> </div>
                                          <div class="card-body">
                                            <div class="card-datatable table-responsive">
                                              <table class="datatables-demo table table-striped table-bordered" id="umb_table_kategori_pekerjaan">
                                                <thead>
                                                  <tr>
                                                    <th><?php echo $this->lang->line('umb_action');?></th>
                                                    <th><?php echo $this->lang->line('umb_rec_kategori_pekerjaan');?></th>
                                                  </tr>
                                                </thead>
                                              </table>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                <?php } ?>
                                <div class="tab-pane fade <?php echo $actshow463;?>" id="account-type_exit">
                                  <div class="row">
                                    <div class="col-md-12">
                                      <div class="box">
                                        <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('umb_add_new');?></strong> <?php echo $this->lang->line('umb_type_exit');?> </span> </div>
                                        <div class="card-body">
                                          <?php $attributes = array('name' => 'info_type_exit', 'id' => 'info_type_exit', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
                                          <?php $hidden = array('set_type_exit' => 'UPDATE');?>
                                          <?php echo form_open('admin/settings/info_type_exit/', $attributes, $hidden);?>
                                          <div class="form-group">
                                            <label class="form-label"><?php echo $this->lang->line('umb_karyawan_type_exit');?></label>
                                            <input type="text" class="form-control" name="type_exit" placeholder="<?php echo $this->lang->line('umb_type_exit');?>">
                                          </div>
                                          <div class="form-actions box-footer">
                                            <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('umb_save');?> </button>
                                          </div>
                                          <?php echo form_close(); ?> </div>
                                        </div>
                                      </div>
                                      <div class="col-md-12">
                                        <div class="box">
                                          <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('umb_list_all');?></strong> <?php echo $this->lang->line('umb_type_exit');?> </span> </div>
                                          <div class="card-body">
                                            <div class="card-datatable table-responsive">
                                              <table class="datatables-demo table table-striped table-bordered" id="umb_table_type_exit">
                                                <thead>
                                                  <tr>
                                                    <th><?php echo $this->lang->line('umb_action');?></th>
                                                    <th><?php echo $this->lang->line('umb_karyawan_type_exit');?></th>
                                                  </tr>
                                                </thead>
                                              </table>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="tab-pane fade <?php echo $actshow464;?>" id="account-arrangement_type">
                                    <div class="row">
                                      <div class="col-md-12">
                                        <div class="box">
                                          <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('umb_add_new');?></strong> <?php echo $this->lang->line('umb_type_pengaturan_perjalanan');?> </span> </div>
                                          <div class="card-body">
                                            <?php $attributes = array('name' => 'info_type_pngtrn_perjalanan', 'id' => 'info_type_pngtrn_perjalanan', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
                                            <?php $hidden = array('set_type_pngtrn_perjalanan' => 'UPDATE');?>
                                            <?php echo form_open('admin/settings/info_type_pngtrn_perjalanan/', $attributes, $hidden);?>
                                            <div class="form-group">
                                              <label class="form-label"><?php echo $this->lang->line('umb_type_pengaturan_perjalanan');?></label>
                                              <input type="text" class="form-control" name="type_pngtrn_perjalanan" placeholder="<?php echo $this->lang->line('umb_type_pengaturan_perjalanan');?>">
                                            </div>
                                            <div class="form-actions box-footer">
                                              <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('umb_save');?> </button>
                                            </div>
                                            <?php echo form_close(); ?> </div>
                                          </div>
                                        </div>
                                        <div class="col-md-12">
                                          <div class="box">
                                            <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('umb_list_all');?></strong> <?php echo $this->lang->line('umb_type_pengaturan_perjalanan');?> </span> </div>
                                            <div class="card-body">
                                              <div class="card-datatable table-responsive">
                                                <table class="datatables-demo table table-striped table-bordered" id="umb_table_type_pngtrn_perjalanan">
                                                  <thead>
                                                    <tr>
                                                      <th><?php echo $this->lang->line('umb_action');?></th>
                                                      <th><?php echo $this->lang->line('umb_type_pengaturan_perjalanan');?></th>
                                                    </tr>
                                                  </thead>
                                                </table>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="tab-pane fade <?php echo $actshow459;?>" id="account-type_currency">
                                      <div class="row">
                                        <div class="col-md-12">
                                          <div class="box">
                                            <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('umb_add_new');?></strong> <?php echo $this->lang->line('umb_type_currency');?> </span> </div>
                                            <div class="card-body">
                                              <?php $attributes = array('name' => 'info_type_currency', 'id' => 'info_type_currency', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
                                              <?php $hidden = array('set_type_currency' => 'UPDATE');?>
                                              <?php echo form_open('admin/settings/info_type_currency/', $attributes, $hidden);?>
                                              <div class="form-group">
                                                <label class="form-label"><?php echo $this->lang->line('umb_currency_name');?></label>
                                                <input type="text" class="form-control" name="name" placeholder="<?php echo $this->lang->line('umb_currency_name');?>">
                                              </div>
                                              <div class="form-group">
                                                <label class="form-label"><?php echo $this->lang->line('umb_currency_code');?></label>
                                                <input type="text" class="form-control" name="code" placeholder="<?php echo $this->lang->line('umb_currency_code');?>">
                                              </div>
                                              <div class="form-group">
                                                <label class="form-label"><?php echo $this->lang->line('umb_currency_symbol');?></label>
                                                <input type="text" class="form-control" name="symbol" placeholder="<?php echo $this->lang->line('umb_currency_symbol');?>">
                                              </div>
                                              <div class="form-actions box-footer">
                                                <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('umb_save');?> </button>
                                              </div>
                                              <?php echo form_close(); ?> </div>
                                            </div>
                                          </div>
                                          <div class="col-md-12">
                                            <div class="box">
                                              <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('umb_list_all');?></strong> <?php echo $this->lang->line('umb_currencies');?> </span> </div>
                                              <div class="card-body">
                                                <div class="card-datatable table-responsive">
                                                  <table class="datatables-demo table table-striped table-bordered" id="umb_table_type_currency">
                                                    <thead>
                                                      <tr>
                                                        <th><?php echo $this->lang->line('umb_action');?></th>
                                                        <th><?php echo $this->lang->line('umb_name');?></th>
                                                        <th><?php echo $this->lang->line('umb_code');?></th>
                                                        <th><?php echo $this->lang->line('umb_symbol');?></th>
                                                      </tr>
                                                    </thead>
                                                  </table>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="tab-pane fade <?php echo $actshow460;?>" id="account-type_perusahaan">
                                        <div class="row">
                                          <div class="col-md-12">
                                            <div class="box">
                                              <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('umb_add_new');?></strong> <?php echo $this->lang->line('umb_type_perusahaan');?> </span> </div>
                                              <div class="card-body">
                                                <?php $attributes = array('name' => 'info_type_perusahaan', 'id' => 'info_type_perusahaan', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
                                                <?php $hidden = array('set_type_perusahaan' => 'UPDATE');?>
                                                <?php echo form_open('admin/settings/info_type_perusahaan/', $attributes, $hidden);?>
                                                <div class="form-group">
                                                  <label class="form-label"><?php echo $this->lang->line('umb_type_perusahaan');?></label>
                                                  <input type="text" class="form-control" name="type_perusahaan" placeholder="<?php echo $this->lang->line('umb_type_perusahaan');?>">
                                                </div>
                                                <div class="form-actions box-footer">
                                                  <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('umb_save');?> </button>
                                                </div>
                                                <?php echo form_close(); ?> </div>
                                              </div>
                                            </div>
                                            <div class="col-md-12">
                                              <div class="box">
                                                <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('umb_list_all');?></strong> <?php echo $this->lang->line('umb_type_perusahaan');?> </span> </div>
                                                <div class="card-body">
                                                  <div class="card-datatable table-responsive">
                                                    <table class="datatables-demo table table-striped table-bordered" id="umb_table_type_perusahaan">
                                                      <thead>
                                                        <tr>
                                                          <th><?php echo $this->lang->line('umb_action');?></th>
                                                          <th><?php echo $this->lang->line('umb_type_perusahaan');?></th>
                                                        </tr>
                                                      </thead>
                                                    </table>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="tab-pane fade <?php echo $actshow461;?>" id="account-security_level">
                                          <div class="row">
                                            <div class="col-md-12">
                                              <div class="box">
                                                <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('umb_add_new');?></strong> <?php echo $this->lang->line('umb_security_level');?> </span> </div>
                                                <div class="card-body">
                                                  <?php $attributes = array('name' => 'info_security_level', 'id' => 'info_security_level', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
                                                  <?php $hidden = array('set_security_level' => 'UPDATE');?>
                                                  <?php echo form_open('admin/settings/info_security_level/', $attributes, $hidden);?>
                                                  <div class="form-group">
                                                    <label class="form-label"><?php echo $this->lang->line('umb_security_level');?></label>
                                                    <input type="text" class="form-control" name="security_level" placeholder="<?php echo $this->lang->line('umb_security_level');?>">
                                                  </div>
                                                  <div class="form-actions box-footer">
                                                    <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('umb_save');?> </button>
                                                  </div>
                                                  <?php echo form_close(); ?> </div>
                                                </div>
                                              </div>
                                              <div class="col-md-12">
                                                <div class="box">
                                                  <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('umb_list_all');?></strong> <?php echo $this->lang->line('umb_security_level');?> </span> </div>
                                                  <div class="card-body">
                                                    <div class="card-datatable table-responsive">
                                                      <table class="datatables-demo table table-striped table-bordered" id="umb_table_security_level">
                                                        <thead>
                                                          <tr>
                                                            <th><?php echo $this->lang->line('umb_action');?></th>
                                                            <th><?php echo $this->lang->line('umb_security_level');?></th>
                                                          </tr>
                                                        </thead>
                                                      </table>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="modal fade edit_setting_datail" id="edit_setting_datail" tabindex="-1" role="dialog" aria-labelledby="edit-modal-data" aria-hidden="true">
                                    <div class="modal-dialog">
                                      <div class="modal-content" id="ajax_setting_info"></div>
                                    </div>
                                  </div>
                                  <style type="text/css">
                                    .table-striped { width:100% !important; }
                                  </style>