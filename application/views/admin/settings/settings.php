<?php $session = $this->session->userdata('username');?>
<?php $file_setting = $this->Umb_model->read_file_setting_info(1);?>
<?php $system = $this->Umb_model->read_setting_info(1); ?>
<?php $info_perusahaan = $this->Umb_model->read_info_setting_perusahaan(1); ?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>
<?php $moduleInfo = $this->Umb_model->read_setting_info(1);?>
<?php $role_resources_ids = $this->Umb_model->user_role_resource(); ?>
<?php //$perusahaan = $this->Umb_model->read_info_setting_perusahaan(1);?>
<?php if($this->session->flashdata('restore_msg')){?>

  <div class="alert alert-success alert-dismissible fade show">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <?php echo $this->session->flashdata('restore_msg'); ?> </div>
  <?php } ?>
  <div id="smarsdstwizard-2" class="smartwizard-example sw-main sw-theme-default">
    <ul class="nav nav-tabs step-anchor">
      <?php if(in_array('60',$role_resources_ids)) { ?>
        <li class="nav-item active"> <a href="<?php echo site_url('admin/settings/');?>" data-link-data="<?php echo site_url('admin/settings/');?>" class="mb-3 nav-link hrastral-link"><span class="sw-icon fas fa-cog"></span> <?php echo $this->lang->line('umb_system');?>
        <div class="text-muted small"><?php echo $this->lang->line('header_configuration');?></div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('61',$role_resources_ids)) { ?>
      <li class="nav-item clickable"> <a href="<?php echo site_url('admin/settings/constants/');?>" data-link-data="<?php echo site_url('admin/settings/constants/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon fas fa-adjust"></span> <?php echo $this->lang->line('left_constants');?>
      <div class="text-muted small"><?php echo $this->lang->line('umb_set_up_all_types');?></div>
    </a> </li>
  <?php } ?>
  <?php if(in_array('93',$role_resources_ids)) { ?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/settings/modules/');?>" data-link-data="<?php echo site_url('admin/settings/modules/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon fas fa-life-ring"></span> <?php echo $this->lang->line('umb_setup_modules');?>
    <div class="text-muted small"><?php echo $this->lang->line('umb_enable_disable_modules');?></div>
  </a> </li>
<?php } ?>
<?php if(in_array('62',$role_resources_ids)) { ?>
  <li class="nav-item clickable"> <a href="<?php echo site_url('admin/settings/database_backup/');?>" data-link-data="<?php echo site_url('admin/settings/database_backup/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon fa fa-database"></span> <?php echo $this->lang->line('header_db_log');?>
  <div class="text-muted small"><?php echo $this->lang->line('umb_database_backup_restore');?></div>
</a> </li>
<?php } ?>
<?php if(in_array('63',$role_resources_ids)) { ?>
  <li class="nav-item clickable"> <a href="<?php echo site_url('admin/settings/email_template/');?>" data-link-data="<?php echo site_url('admin/settings/email_template/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon fas fa-envelope"></span> <?php echo $this->lang->line('left_email_templates');?>
  <div class="text-muted small"><?php echo $this->lang->line('umb_set_up');?> <?php echo $this->lang->line('left_email_templates');?></div>
</a> </li>
<?php } ?>
</ul>
</div>
<hr class="border-light m-0 mb-3">
<?php
$active297 = '';$active431 = '';$active432 = '';$active433 = '';$active434 = '';$active435 = '';$active436 = '';
$active118 = '';$active437 = '';$active438 = '';$active439 = '';$active440 = '';$active441 = '';$active466 = '';
$actshow297 = '';$actshow431 = '';$actshow432 = '';$actshow433 = '';$actshow434 = '';$actshow435 = '';$actshow436 = '';
$actshow118 = '';$actshow437 = '';$actshow438 = '';$actshow439 = '';$actshow440 = '';$actshow441 = '';$actshow466 = '';
$active = '';
$actshow = '';
if(in_array('297',$role_resources_ids)) {
  $active297 = 'active';
  $actshow297 = 'active show';
} else if(in_array('431',$role_resources_ids)) {
  $active431 = 'active';
  $actshow431 = 'active show';
} else if(in_array('432',$role_resources_ids)) {
  $active432 = 'active';
  $actshow432 = 'active show';
} else if(in_array('433',$role_resources_ids)) {
  $active433 = 'active';
  $actshow433 = 'active show';
} else if(in_array('434',$role_resources_ids)) {
  $active434 = 'active';
  $actshow434 = 'active show';
} else if(in_array('435',$role_resources_ids)) {
  $active435 = 'active';
  $actshow435 = 'active show';
} else if(in_array('436',$role_resources_ids)) {
  $active436 = 'active';
  $actshow436 = 'active show';
} else if(in_array('118',$role_resources_ids)) {
  $active118 = 'active';
  $actshow118 = 'active show';
} else if(in_array('437',$role_resources_ids)) {
  $active437 = 'active';
  $actshow437 = 'active show';
} else if(in_array('438',$role_resources_ids)) {
  $active438 = 'active';
  $actshow438 = 'active show';
} else if(in_array('439',$role_resources_ids)) {
  $active439 = 'active';
  $actshow439 = 'active show';
} else if(in_array('441',$role_resources_ids)) {
  $active441 = 'active';
  $actshow441 = 'active show';
} else if(in_array('466',$role_resources_ids)) {
  $active466 = 'active';
  $actshow466 = 'active show';
}
?>
<div class="card overflow-hidden">
  <div class="row no-gutters row-bordered row-border-light">
    <div class="col-md-3 pt-0">
      <div class="list-group list-group-flush account-settings-links">
        <?php if(in_array('297',$role_resources_ids)) { ?>
          <a class="list-group-item list-group-item-action <?php echo $active297;?>" data-toggle="list" href="#account-system"><i class="ion ion-ios-heart text-lightest"></i> &nbsp; <?php echo $this->lang->line('umb_system');?></a>
        <?php } ?>
        <?php if(in_array('431',$role_resources_ids)) { ?>
          <a class="list-group-item list-group-item-action <?php echo $active431;?>" data-toggle="list" href="#account-general"><i class="ion ion-logo-buffer text-lightest"></i> &nbsp; <?php echo $this->lang->line('umb_general');?></a>
        <?php } ?>
        <?php if(in_array('432',$role_resources_ids)) { ?>
          <a class="list-group-item list-group-item-action <?php echo $active432;?>" data-toggle="list" href="#account-role"><i class="fa fa-unlock-alt text-lightest"></i> &nbsp; <?php echo $this->lang->line('umb_karyawan_role');?></a>
        <?php } ?>
        <?php if(in_array('433',$role_resources_ids)) { ?>
          <a class="list-group-item list-group-item-action <?php echo $active433;?>" data-toggle="list" href="#account-payroll"><i class="fa fa-calculator text-lightest"></i> &nbsp; <?php echo $this->lang->line('left_payroll');?></a>
        <?php } ?>
        <?php if($system[0]->module_recruitment=='true' && in_array('434',$role_resources_ids)){?>
          <a class="list-group-item list-group-item-action <?php echo $active434;?>" data-toggle="list" href="#account-recruitment"><i class="fas fa-newspaper text-lightest"></i> &nbsp; <?php echo $this->lang->line('left_recruitment');?></a>
        <?php } ?>
        <?php if($system[0]->module_performance=='yes' && in_array('435',$role_resources_ids)) { ?>
          <a class="list-group-item list-group-item-action <?php echo $active435;?>" data-toggle="list" href="#account-performance"><i class="fa fa-cube text-lightest"></i> &nbsp; <?php echo $this->lang->line('left_performance');?></a>
        <?php } ?>
        <?php if(in_array('436',$role_resources_ids)) { ?>
          <a class="list-group-item list-group-item-action <?php echo $active436;?>" data-toggle="list" href="#account-system_logos"><i class="fa fa-image text-lightest"></i> &nbsp; <?php echo $this->lang->line('umb_system_logos');?></a>
        <?php } ?>
        <?php if(in_array('118',$role_resources_ids)) { ?>
          <a class="list-group-item list-group-item-action <?php echo $active118;?>" data-toggle="list" href="#account-payment_gateway"><i class="fab fa-cc-paypal text-lightest"></i> &nbsp; <?php echo $this->lang->line('umb_acc_payment_gateway');?></a>
        <?php } ?>
        <?php if(in_array('437',$role_resources_ids)) { ?>
          <a class="list-group-item list-group-item-action <?php echo $active437;?>" data-toggle="list" href="#account-email"><i class="fa fa-envelope text-lightest"></i> &nbsp; <?php echo $this->lang->line('umb_email_notifications');?></a>
        <?php } ?>
        <?php if(in_array('438',$role_resources_ids)) { ?>
          <a class="list-group-item list-group-item-action <?php echo $active438;?>" data-toggle="list" href="#account-page_layouts"><i class="fa fa-cubes text-lightest"></i> &nbsp; <?php echo $this->lang->line('umb_page_layouts');?></a>
        <?php } ?>
        <?php if(in_array('439',$role_resources_ids)) { ?>
          <a class="list-group-item list-group-item-action <?php echo $active439;?>" data-toggle="list" href="#account-notification_position"><i class="fa fa-exclamation-circle text-lightest"></i> &nbsp; <?php echo $this->lang->line('umb_notification_position');?></a>
        <?php } ?>
        <?php if($system[0]->module_files=='true' && in_array('440',$role_resources_ids)){?>
          <a class="list-group-item list-group-item-action <?php echo $active440;?>" data-toggle="list" href="#account-files"><i class="fas fa-file-upload text-lightest"></i> &nbsp; <?php echo $this->lang->line('umb_files_manager');?></a>
        <?php } ?>
        <?php if(in_array('441',$role_resources_ids)) { ?>
          <a class="list-group-item list-group-item-action <?php echo $active441;?>" data-toggle="list" href="#account-org_chart"><i class="fa fa-sitemap text-lightest"></i> &nbsp; <?php echo $this->lang->line('umb_title_org_chart');?></a>
        <?php } ?>
        <?php if(in_array('466',$role_resources_ids)) { ?>
          <a class="list-group-item list-group-item-action <?php echo $active466;?>" data-toggle="list" href="#account-topmenu"><i class="fas fa-list-ol text-lightest"></i> &nbsp; <?php echo $this->lang->line('umb_manage_top_menu');?></a>
          <?php } ?> </div>
        </div>
        <div class="col-md-9">
          <div class="tab-content">
            <div class="tab-pane fade <?php echo $actshow297;?>" id="account-system">
              <div class="card-body media align-items-center"> <span class="app-brand-logo demo bg-primary"> <img alt="<?php echo $system[0]->application_name;?>" src="<?php echo base_url();?>uploads/logo/<?php echo $info_perusahaan[0]->logo;?>" class="brand-logo d-block ui-w-30" style="width:32px;"> </span>
                <div class="media-body ml-4"> <?php echo $application_name;?>
                <div class="text-light small mt-1"><?php echo $this->lang->line('umb_change_setting_info');?></div>
              </div>
            </div>
            <hr class="border-light m-0">
            <div class="card-body">
              <div class="card-block">
                <?php $attributes = array('name' => 'system_info', 'id' => 'system_info', 'autocomplete' => 'off');?>
                <?php $hidden = array('u_basic_info' => 'UPDATE');?>
                <?php echo form_open('admin/settings/system_info/'.$info_perusahaan_id, $attributes, $hidden);?>
                <div class="bg-white">
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label class="form-label"><?php echo $this->lang->line('umb_application_name');?></label>
                        <input class="form-control" placeholder="<?php echo $this->lang->line('umb_system_settings');?>" name="application_name" type="text" value="<?php echo $application_name;?>" id="application_name">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label class="form-label"><?php echo $this->lang->line('umb_default_currency');?></label>
                        <select class="form-control" name="default_currency_symbol" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_default_currency_symbol');?>" tabindex="-1" aria-hidden="true">
                          <option value=""><?php echo $this->lang->line('umb_select_one');?></option>
                          <?php foreach($this->Umb_model->get_currencies() as $currency){?>
                            <?php $_currency = $currency->code.' - '.$currency->symbol;?>
                            <option value="<?php echo $_currency;?>" <?php if($default_currency_symbol==$_currency):?> selected <?php endif;?>> <?php echo $_currency;?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label class="form-label"><?php echo $this->lang->line('umb_default_currency_symbol_code');?></label>
                        <select class="form-control" name="show_currency" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_show_currency');?>">
                          <option value=""><?php echo $this->lang->line('umb_select_one');?></option>
                          <option value="code" <?php if($show_currency=='code'){?> selected <?php }?>><?php echo $this->lang->line('umb_currency_code');?></option>
                          <option value="symbol" <?php if($show_currency=='symbol'){?> selected <?php }?>><?php echo $this->lang->line('umb_currency_symbol');?></option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label class="form-label"><?php echo $this->lang->line('umb_currency_position');?></label>
                        <input type="hidden" name="notification_position" value="Bottom Left">
                        <input type="hidden" name="enable_registration" value="no">
                        <input type="hidden" name="login_with" value="username">
                        <select class="form-control" name="currency_position" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_currency_position');?>">
                          <option value=""><?php echo $this->lang->line('umb_select_one');?></option>
                          <option value="Prefix" <?php if($currency_position=='Prefix'){?> selected <?php }?>><?php echo $this->lang->line('umb_prefix');?></option>
                          <option value="Suffix" <?php if($currency_position=='Suffix'){?> selected <?php }?>><?php echo $this->lang->line('umb_suffix');?></option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label class="form-label"><?php echo $this->lang->line('umb_login_karyawan');?></label>
                        <select class="form-control" name="login_karyawan_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_login_karyawan');?>">
                          <option value=""><?php echo $this->lang->line('umb_select_one');?></option>
                          <option value="username" <?php if($login_karyawan_id=='username'){?> selected <?php }?>><?php echo $this->lang->line('umb_login_karyawan_with_username');?></option>
                          <option value="email" <?php if($login_karyawan_id=='email'){?> selected <?php }?>><?php echo $this->lang->line('umb_login_karyawan_with_email');?></option>
                          <option value="pincode" <?php if($login_karyawan_id=='pincode'){?> selected <?php }?>><?php echo $this->lang->line('umb_login_karyawan_with_pincode');?></option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label class="form-label"><?php echo $this->lang->line('umb_date_format');?></label>
                        <select class="form-control" name="date_format" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_date_format');?>">
                          <option value=""><?php echo $this->lang->line('umb_select_one');?></option>
                          <option value="d-m-Y" <?php if($date_format_astral=='d-m-Y'){?> selected <?php }?>>dd-mm-YYYY (<?php echo date('d-m-Y');?>)</option>
                          <option value="m-d-Y" <?php if($date_format_astral=='m-d-Y'){?> selected <?php }?>>mm-dd-YYYY (<?php echo date('m-d-Y');?>)</option>
                          <option value="d-M-Y" <?php if($date_format_astral=='d-M-Y'){?> selected <?php }?>>dd-MM-YYYY (<?php echo date('d-M-Y');?>)</option>
                          <option value="M-d-Y" <?php if($date_format_astral=='M-d-Y'){?> selected <?php }?>>MM-dd-YYYY (<?php echo date('M-d-Y');?>)</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label class="form-label"><?php echo $this->lang->line('umb_footer_text');?></label>
                        <input class="form-control" placeholder="<?php echo $this->lang->line('umb_footer_text');?>" name="footer_text" type="text" value="<?php echo $footer_text;?>">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label class="form-label"><?php echo $this->lang->line('umb_setting_timezone');?></label>
                        <select class="form-control" name="system_timezone" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_setting_timezone');?>">
                          <option value=""><?php echo $this->lang->line('umb_select_one');?></option>
                          <?php foreach($this->Umb_model->all_timezones() as $tval=>$labels):?>
                            <option value="<?php echo $tval;?>" <?php if($system_timezone==$tval):?> selected <?php endif;?>><?php echo $labels;?></option>
                          <?php endforeach;?>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <?php $languages = $this->Umb_model->all_languages();?>
                        <label class="form-label"><?php echo $this->lang->line('umb_hrastral_default_language');?></label>
                        <select class="form-control" name="default_language" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_hrastral_default_language');?>">
                          <?php foreach($languages as $lang):?>
                            <option value="<?php echo $lang->language_code;?>" <?php if($lang->language_code==$default_language):?> selected="selected"<?php endif;?>><?php echo $lang->language_name;?></option>
                          <?php endforeach;?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label class="form-label"><?php echo $this->lang->line('umb_enable_year_on_footer');?> <small>(footer)</small></label>
                        <br>
                        <div class="pull-xs-left m-r-1">
                          <label class="switcher switcher-success">
                            <input data-group-cls="btn-group-sm" type="checkbox" id="enable_current_year" class="js-switch switcher-input" value="yes" <?php if($enable_current_year=='yes'):?> checked="checked" <?php endif;?>/>
                            <span class="switcher-indicator"> <span class="switcher-yes"> <span class="ion ion-md-checkmark"></span> </span> <span class="switcher-no"> <span class="ion ion-md-close"></span> </span> </span> </label>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="form-label"><?php echo $this->lang->line('umb_enable_codeigniter_on_footer');?> <small>(footer)</small></label>
                          <br>
                          <div class="pull-xs-left m-r-1">
                            <label class="switcher switcher-success">
                              <input type="checkbox" id="enable_page_rendered" name="enable_page_rendered" class="js-switch switcher-input" data-group-cls="btn-group-sm"  data-color="#3e70c9" data-secondary-color="#ddd" <?php if($enable_page_rendered=='yes'):?> checked="checked" <?php endif;?> value="yes">
                              <span class="switcher-indicator"> <span class="switcher-yes"> <span class="ion ion-md-checkmark"></span> </span> <span class="switcher-no"> <span class="ion ion-md-close"></span> </span> </span> </label>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-2">
                          <div class="form-group">
                            <label class="form-label"><?php echo $this->lang->line('umb_enable_geolocation_ssl');?>
                            <button type="button" class="btn icon-btn btn-xs btn-default itheme-btn borderless" data-toggle="popover" data-placement="top" data-content="<?php echo $this->lang->line('umb_enable_geolocation_ssl_details');?>" data-trigger="hover" data-original-title="<?php echo $this->lang->line('umb_enable_geolocation_ssl');?>"><span class="fa fa-question-circle"></span></button>
                          </label>
                          <br>
                          <div class="pull-xs-left m-r-1">
                            <label class="switcher switcher-success">
                              <input type="checkbox" name="is_ssl_available" id="is_ssl_available" class="js-switch switcher-input" data-group-cls="btn-group-sm"  data-color="#3e70c9" data-secondary-color="#ddd" <?php if($is_ssl_available=='yes'):?> checked="checked" <?php endif;?> value="yes">
                              <span class="switcher-indicator"> <span class="switcher-yes"> <span class="ion ion-md-checkmark"></span> </span> <span class="switcher-no"> <span class="ion ion-md-close"></span> </span> </span> </label>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label class="form-label"><?php echo $this->lang->line('umb_payroll_statutory_fixed');?></label>
                            <br>
                            <div class="pull-xs-left m-r-1">
                              <label class="switcher switcher-success">
                                <input type="checkbox" id="statutory_fixed" name="statutory_fixed" class="js-switch switcher-input" data-group-cls="btn-group-sm"  data-color="#3e70c9" data-secondary-color="#ddd" <?php if($statutory_fixed=='yes'):?> checked="checked" <?php endif;?> value="yes">
                                <span class="switcher-indicator"> <span class="switcher-yes"> <span class="ion ion-md-checkmark"></span> </span> <span class="switcher-no"> <span class="ion ion-md-close"></span> </span> </span> </label>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="form-label"><?php echo $this->lang->line('umb_setting_google_maps_api_key');?>
                              <button type="button" class="btn icon-btn btn-xs btn-default itheme-btn borderless" data-toggle="popover" data-placement="top" data-content="<?php echo $this->lang->line('umb_setting_google_maps_api_key_details');?>" data-trigger="hover" data-original-title="<?php echo $this->lang->line('umb_setting_google_maps_api_key');?>"><span class="fa fa-question-circle"></span></button>
                            </label>
                            <br />
                            <textarea class="form-control" name="google_maps_api_key" id="google_maps_api_key" rows="1"><?php echo $google_maps_api_key;?></textarea>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label class="form-label"><?php echo $this->lang->line('left_show_projects');?></label>
                            <select class="form-control" name="show_projects" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_show_projects');?>">
                              <option value=""><?php echo $this->lang->line('umb_select_one');?></option>
                              <option value="0" <?php if($show_projects=='0'){?> selected <?php }?>><?php echo $this->lang->line('umb_list_view');?></option>
                              <option value="1" <?php if($show_projects=='1'){?> selected <?php }?>><?php echo $this->lang->line('umb_grid_view');?></option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label class="form-label"><?php echo $this->lang->line('left_show_tugass');?></label>
                            <select class="form-control" name="show_tugass" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_show_tugass');?>">
                              <option value=""><?php echo $this->lang->line('umb_select_one');?></option>
                              <option value="0" <?php if($show_tugass=='0'){?> selected <?php }?>><?php echo $this->lang->line('umb_list_view');?></option>
                              <option value="1" <?php if($show_tugass=='1'){?> selected <?php }?>><?php echo $this->lang->line('umb_grid_view');?></option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="form-label"><?php echo $this->lang->line('umb_estimate_terms_condition');?></label>
                            <textarea class="form-control" name="estimate_terms_condition" rows="5"><?php echo $estimate_terms_condition;?></textarea>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="form-label"><?php echo $this->lang->line('umb_invoice_terms_condition');?></label>
                            <textarea class="form-control" name="invoice_terms_condition" rows="5"><?php echo $invoice_terms_condition;?></textarea>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <div class="form-actions box-footer">
                              <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('umb_save');?> </button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php echo form_close(); ?> </div>
                  </div>
                </div>
                <div class="tab-pane fade <?php echo $actshow431;?>" id="account-general">
                  <div class="card-body">
                    <div class="card-block">
                      <?php $attributes = array('name' => 'info_perusahaan', 'id' => 'info_perusahaan', 'autocomplete' => 'off');?>
                      <?php $hidden = array('u_info_perusahaan' => 'UPDATE');?>
                      <?php echo form_open('admin/settings/info_perusahaan/'.$info_perusahaan_id, $attributes, $hidden);?>
                      <div class="row">
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label class="form-label"><?php echo $this->lang->line('umb_nama_perusahaan');?></label>
                            <input class="form-control" placeholder="<?php echo $this->lang->line('umb_nama_perusahaan');?>" name="nama_perusahaan" type="text" value="<?php echo $nama_perusahaan;?>">
                          </div>
                          <div class="form-group">
                            <label class="form-label"><?php echo $this->lang->line('umb_se_kontak_person');?></label>
                            <input class="form-control" placeholder="<?php echo $this->lang->line('umb_se_kontak_person');?>" name="kontak_person" type="text" value="<?php echo $kontak_person;?>">
                          </div>
                          <div class="form-group">
                            <label class="form-label"><?php echo $this->lang->line('umb_email');?></label>
                            <input class="form-control" placeholder="<?php echo $this->lang->line('umb_email');?>" name="email" type="email" value="<?php echo $email;?>">
                          </div>
                          <div class="form-group">
                            <label class="form-label"><?php echo $this->lang->line('umb_phone');?></label>
                            <input class="form-control" placeholder="<?php echo $this->lang->line('umb_phone');?>" name="phone" type="text" value="<?php echo $phone;?>">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="form-label"><?php echo $this->lang->line('umb_alamat_karyawan');?></label>
                            <input class="form-control" placeholder="<?php echo $this->lang->line('umb_alamat_1');?>" name="alamat_1" type="text" value="<?php echo $alamat_1;?>">
                            <br>
                            <input class="form-control" placeholder="<?php echo $this->lang->line('umb_alamat_2');?>" name="alamat_2" type="text" value="<?php echo $alamat_2;?>">
                            <br>
                            <div class="row">
                              <div class="col-md-5">
                                <input class="form-control" placeholder="<?php echo $this->lang->line('umb_kota');?>" name="kota" type="text" value="<?php echo $kota;?>">
                              </div>
                              <div class="col-md-4">
                                <input class="form-control" placeholder="<?php echo $this->lang->line('umb_provinsi');?>" name="provinsi" type="text" value="<?php echo $provinsi;?>">
                              </div>
                              <div class="col-md-3">
                                <input class="form-control" placeholder="<?php echo $this->lang->line('umb_kode_pos');?>" name="kode_pos" type="text" value="<?php echo $kode_pos;?>">
                              </div>
                            </div>
                            <br>
                            <select class="form-control" name="negara" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_negara');?>">
                              <option value=""><?php echo $this->lang->line('umb_select_one');?></option>
                              <?php foreach($all_negaraa as $snegara) {?>
                                <option value="<?php echo $snegara->negara_id;?>" <?php if($negara==$snegara->negara_id):?> selected <?php endif;?>> <?php echo $snegara->nama_negara;?></option>
                              <?php } ?>
                            </select>
                          </div>
                          <input name="config_type" type="hidden" value="general">
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <div class="form-actions box-footer">
                              <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('umb_save');?> </button>
                            </div>
                          </div>
                        </div>
                      </div>
                      <?php echo form_close(); ?> </div>
                    </div>
                  </div>
                  <div class="tab-pane fade <?php echo $actshow432;?>" id="account-role">
                    <div class="card-body pb-2">
                      <?php $attributes = array('name' => 'role_info', 'id' => 'role_info', 'autocomplete' => 'off');?>
                      <?php $hidden = array('u_basic_info' => 'UPDATE');?>
                      <?php echo form_open('admin/settings/role_info/'.$info_perusahaan_id, $attributes, $hidden);?>
                      <div class="bg-white">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="form-label"><?php echo $this->lang->line('umb_karya_kelolah_info_kontak_sendiri');?></label>
                              <br>
                              <div class="pull-xs-left m-r-1">
                                <label class="switcher switcher-success">
                                  <input type="checkbox" name="kontak_role" id="kontak_role" class="js-switch switch switcher-input" data-group-cls="btn-group-sm"  data-color="#3e70c9" data-secondary-color="#ddd" <?php if($karyawan_manage_own_kontak=='yes'):?> checked="checked" <?php endif;?> value="yes" />
                                  <span class="switcher-indicator"> <span class="switcher-yes"> <span class="ion ion-md-checkmark"></span> </span> <span class="switcher-no"> <span class="ion ion-md-close"></span> </span> </span> </label>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="form-label"><?php echo $this->lang->line('umb_employe_can_manage_bank_account');?></label>
                                <br>
                                <div class="pull-xs-left m-r-1">
                                  <label class="switcher switcher-success">
                                    <input type="checkbox" name="bank_account_role" id="bank_account_role" class="js-switch switch switcher-input" data-group-cls="btn-group-sm"  data-color="#3e70c9" data-secondary-color="#ddd" <?php if($karyawan_manage_own_bank_account=='yes'):?> checked="checked" <?php endif;?> value="yes" />
                                    <span class="switcher-indicator"> <span class="switcher-yes"> <span class="ion ion-md-checkmark"></span> </span> <span class="switcher-no"> <span class="ion ion-md-close"></span> </span> </span> </label>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="form-label"><?php echo $this->lang->line('umb_employe_can_manage_qualification');?></label>
                                  <br>
                                  <div class="pull-xs-left m-r-1">
                                    <label class="switcher switcher-success">
                                      <input type="checkbox" name="edu_role" id="edu_role" class="js-switch switch switcher-input" data-group-cls="btn-group-sm"  data-color="#3e70c9" data-secondary-color="#ddd" <?php if($karyawan_manage_own_qualification=='yes'):?> checked="checked" <?php endif;?> value="yes" />
                                      <span class="switcher-indicator"> <span class="switcher-yes"> <span class="ion ion-md-checkmark"></span> </span> <span class="switcher-no"> <span class="ion ion-md-close"></span> </span> </span> </label>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label class="form-label"><?php echo $this->lang->line('umb_employe_can_manage_pengalaman_kerja');?></label>
                                    <br>
                                    <div class="pull-xs-left m-r-1">
                                      <label class="switcher switcher-success">
                                        <input type="checkbox" name="work_role" id="work_role" class="js-switch switch switcher-input" data-group-cls="btn-group-sm"  data-color="#3e70c9" data-secondary-color="#ddd" <?php if($karyawan_manage_own_pengalaman_kerja=='yes'):?> checked="checked" <?php endif;?> value="yes" />
                                        <span class="switcher-indicator"> <span class="switcher-yes"> <span class="ion ion-md-checkmark"></span> </span> <span class="switcher-no"> <span class="ion ion-md-close"></span> </span> </span> </label>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label class="form-label"><?php echo $this->lang->line('umb_employe_can_manage_documents');?></label>
                                      <br>
                                      <div class="pull-xs-left m-r-1">
                                        <label class="switcher switcher-success">
                                          <input type="checkbox" name="doc_role" id="doc_role" class="js-switch switch switcher-input" data-group-cls="btn-group-sm"  data-color="#3e70c9" data-secondary-color="#ddd" <?php if($karyawan_manage_own_document=='yes'):?> checked="checked" <?php endif;?> value="yes" />
                                          <span class="switcher-indicator"> <span class="switcher-yes"> <span class="ion ion-md-checkmark"></span> </span> <span class="switcher-no"> <span class="ion ion-md-close"></span> </span> </span> </label>
                                        </div>
                                      </div>
                                      <div class="form-group">
                                        <label class="form-label"><?php echo $this->lang->line('umb_employe_can_manage_profile_picture');?></label>
                                        <br>
                                        <div class="pull-xs-left m-r-1">
                                          <label class="switcher switcher-success">
                                            <input type="checkbox" name="pic_role" id="pic_role" class="js-switch switch switcher-input" data-group-cls="btn-group-sm"  data-color="#3e70c9" data-secondary-color="#ddd" <?php if($karyawan_manage_own_picture=='yes'):?> checked="checked" <?php endif;?> value="yes" />
                                            <span class="switcher-indicator"> <span class="switcher-yes"> <span class="ion ion-md-checkmark"></span> </span> <span class="switcher-no"> <span class="ion ion-md-close"></span> </span> </span> </label>
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <label class="form-label"><?php echo $this->lang->line('umb_employe_can_manage_profile_info');?></label>
                                          <br>
                                          <div class="pull-xs-left m-r-1">
                                            <label class="switcher switcher-success">
                                              <input type="checkbox" name="profile_role" id="profile_role" class="js-switch switch switcher-input" data-group-cls="btn-group-sm"  data-color="#3e70c9" data-secondary-color="#ddd" <?php if($karyawan_manage_own_profile=='yes'):?> checked="checked" <?php endif;?> value="yes" />
                                              <span class="switcher-indicator"> <span class="switcher-yes"> <span class="ion ion-md-checkmark"></span> </span> <span class="switcher-no"> <span class="ion ion-md-close"></span> </span> </span> </label>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="form-label"><?php echo $this->lang->line('umb_employe_can_manage_social_info');?></label>
                                            <br>
                                            <div class="pull-xs-left m-r-1">
                                              <label class="switcher switcher-success">
                                                <input type="checkbox" name="social_role" id="social_role" class="js-switch switch switcher-input" data-group-cls="btn-group-sm"  data-color="#3e70c9" data-secondary-color="#ddd" <?php if($karyawan_manage_own_social=='yes'):?> checked="checked" <?php endif;?> value="yes">
                                                <span class="switcher-indicator"> <span class="switcher-yes"> <span class="ion ion-md-checkmark"></span> </span> <span class="switcher-no"> <span class="ion ion-md-close"></span> </span> </span> </label>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="row">
                                          <div class="col-md-12">
                                            <div class="form-group">
                                              <div class="form-actions box-footer">
                                                <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('umb_save');?> </button>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <?php echo form_close(); ?> </div>
                                    </div>
                                    <div class="tab-pane fade <?php echo $actshow433;?>" id="account-payroll">
                                      <div class="card-body pb-2">
                                        <div class="card-block">
                                          <?php $attributes = array('name' => 'payroll_config', 'id' => 'payroll_config', 'autocomplete' => 'off');?>
                                          <?php $hidden = array('u_basic_info' => 'UPDATE');?>
                                          <?php echo form_open('admin/settings/payroll_config/'.$info_perusahaan_id, $attributes, $hidden);?>
                                          <div class="row">
                                            <div class="col-md-7">
                                              <div class="form-group">
                                                <label class="form-label"><?php echo $this->lang->line('umb_format_password_slipgaji');?></label>
                                                <br>
                                                <div class="pull-xs-left m-r-1">
                                                  <select class="form-control" name="format_password_slipgaji" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_select_one');?>">
                                                    <option value=""><?php echo $this->lang->line('umb_select_one');?></option>
                                                    <option value="dateofbirth" <?php if($format_password_slipgaji=='dateofbirth'){?> selected <?php }?>>Tanggal Lahir Karyawan(<?php echo date('dmY');?>)</option>
                                                    <option value="no_kontak" <?php if($format_password_slipgaji=='no_kontak'){?> selected <?php }?>>Nomor Kontak Karyawan. (<?php echo '123456789';?>)</option>
                                                    <option value="full_name" <?php if($format_password_slipgaji=='full_name'){?> selected <?php }?>>Nama Depan dan Nama belakang Karyawan (<?php echo 'JhonDoe';?>)</option>
                                                    <option value="email" <?php if($format_password_slipgaji=='email'){?> selected <?php }?>>alamat emeil karyawan (<?php echo 'karyawan@example.com';?>)</option>
                                                    
                                                    <option value="karyawan_id" <?php if($format_password_slipgaji=='karyawan_id'){?> selected <?php }?>>ID Karyawan (<?php echo 'EMP001WA5';?>)</option>
                                                    
                                                    <option value="nama_tanggal_lahir" <?php if($format_password_slipgaji=='nama_tanggal_lahir'){?> selected <?php }?>>Pilih nama Depan dan tanggal lahir karyawan (<?php echo date('dmY').'JD';?>)</option>
                                                  </select>
                                                </div>
                                              </div>
                                            </div>
                                            <div class="col-md-5">
                                              <div class="form-group">
                                                <label class="form-label"><?php echo $this->lang->line('umb_enable_password_generate_slipgaji');?></label>
                                                <br>
                                                <div class="pull-xs-left m-r-1">
                                                  <label class="switcher switcher-success">
                                                    <input type="checkbox" name="generate_password_slipgaji" id="generate_password_slipgaji" class="js-switch switch switcher-input" data-group-cls="btn-group-sm" <?php if($is_generate_password_slipgaji=='1'):?> checked="checked" <?php endif;?> value="1" />
                                                    <span class="switcher-indicator"> <span class="switcher-yes"> <span class="ion ion-md-checkmark"></span> </span> <span class="switcher-no"> <span class="ion ion-md-close"></span> </span> </span> </label>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                            <div class="row">
                                              <div class="col-md-3">
                                                <div class="form-group">
                                                  <label class="form-label"><?php echo $this->lang->line('umb_enable_asuransi');?></label>
                                                  <select name="enable_asuransi" class="form-control" data-plugin="select_hrm">
                                                    <option value="0" <?php if($enable_asuransi==0 || $enable_asuransi==''):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('umb_no');?></option>
                                                    <option value="5" <?php if($enable_asuransi==5):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('umb_yes');?> - 5%</option>
                                                    <option value="10" <?php if($enable_asuransi==10):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('umb_yes');?> - 10%</option>
                                                    <option value="15" <?php if($enable_asuransi==15):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('umb_yes');?> - 15%</option>
                                                  </select>
                                                </div>
                                              </div>
                                              <div class="col-md-3" id="half_monthly_is">
                                                <div class="form-group">
                                                  <label class="form-label"><?php echo $this->lang->line('umb_is_half_monthly');?></label>
                                                  <select name="is_half_monthly" id="is_half_monthly" class="form-control" data-plugin="select_hrm">
                                                    <option value="0" <?php if($is_half_monthly==0 || $is_half_monthly==''):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('umb_no');?></option>
                                                    <option value="1" <?php if($is_half_monthly==1):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('umb_yes');?></option>
                                                  </select>
                                                </div>
                                              </div>
                                              <?php if($is_half_monthly==1): $stl = 'style="display:block;"';  else: $stl = 'style="display:none;"'; endif;?>
                                              <div class="col-md-3" id="deduct_options"  <?php echo $stl;?>>
                                                <div class="form-group">
                                                  <label class="form-label"><?php echo $this->lang->line('umb_potong_setengah_bulan');?></label>
                                                  <select name="potong_setengah_bulan" id="potong_setengah_bulan" class="form-control" data-plugin="select_hrm">
                                                    <option value="1" <?php if($potong_setengah_bulan==1):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('umb_is_half_monthly_bs_only');?></option>
                                                    <option value="2" <?php if($potong_setengah_bulan==2):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('umb_is_half_monthly_bs_only_both');?></option>
                                                  </select>
                                                </div>
                                              </div>
                                            </div>
                                            <div class="row">
                                              <div class="col-md-12">
                                                <div class="form-actions box-footer">
                                                  <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('umb_save');?> </button>
                                                </div>
                                              </div>
                                            </div>
                                            <?php echo form_close(); ?> </div>
                                          </div>
                                        </div>
                                        <?php if($system[0]->module_recruitment=='true'){?>
                                          <?php if($system[0]->enable_pekerjaan_application_kandidats=='1'){?>
                                            <div class="tab-pane fade <?php echo $actshow434;?>" id="account-recruitment">
                                              <?php if(in_array('50',$role_resources_ids)) { ?>
                                                <div class="card-body"> <a target="_blank" href="<?php echo site_url('pekerjaans');?>">
                                                  <button type="button" class="btn btn-primary"><?php echo $this->lang->line('left_pekerjaans_terbaru');?></button>
                                                </a> </div>
                                              <?php } ?>
                                              <hr class="border-light m-0">
                                              <div class="card-body">
                                                <div class="card-block">
                                                  <?php $attributes = array('name' => 'info_pekerjaan', 'id' => 'info_pekerjaan', 'autocomplete' => 'off');?>
                                                  <?php $hidden = array('u_basic_info' => 'UPDATE');?>
                                                  <?php echo form_open('admin/settings/info_pekerjaan/'.$info_perusahaan_id, $attributes, $hidden);?>
                                                  <div class="row">
                                                    <div class="col-sm-12">
                                                      <div class="form-group">
                                                        <label class="form-label"><?php echo $this->lang->line('umb_enable_pekerjaans_for_karyawans');?></label>
                                                        <br>
                                                        <div class="pull-xs-left m-r-1">
                                                          <label class="switcher switcher-success">
                                                            <input type="checkbox" name="enable_pekerjaan2" id="enable_pekerjaan2" class="js-switch switch switcher-input" <?php if($enable_pekerjaan_application_kandidats=='1'):?> checked="checked" <?php endif;?> value="1" />
                                                            <span class="switcher-indicator"> <span class="switcher-yes"> <span class="ion ion-md-checkmark"></span> </span> <span class="switcher-no"> <span class="ion ion-md-close"></span> </span> </span> </label>
                                                          </div>
                                                        </div>
                                                        <div class="form-group">
                                                          <label class="form-label"><?php echo $this->lang->line('umb_pekerjaan_application_file_format');?></label>
                                                          <br>
                                                          <input type="text" value="<?php echo $pekerjaan_application_format;?>" data-role="tagsinput" name="pekerjaan_application_format">
                                                        </div>
                                                      </div>
                                                    </div>
                                                    <div class="row">
                                                      <div class="col-md-12">
                                                        <div class="form-group">
                                                          <div class="form-actions box-footer">
                                                            <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('umb_save');?> </button>
                                                          </div>
                                                        </div>
                                                      </div>
                                                    </div>
                                                    <?php echo form_close(); ?> </div>
                                                  </div>
                                                </div>
                                              <?php } ?>
                                            <?php } ?>
                                            <div class="tab-pane fade <?php echo $actshow435;?>" id="account-performance">
                                              <div class="card-body pb-2">
                                                <div class="card-block">
                                                  <?php $attributes = array('name' => 'info_performance', 'id' => 'info_performance', 'autocomplete' => 'off');?>
                                                  <?php $hidden = array('u_basic_info' => 'UPDATE');?>
                                                  <?php echo form_open('admin/settings/info_performance/'.$info_perusahaan_id, $attributes, $hidden);?>
                                                  <div class="row">
                                                    <div class="col-sm-12">
                                                      <div class="form-group">
                                                        <label class="form-label"><?php echo $this->lang->line('umb_performance_technical_competencies');?></label>
                                                        <br>
                                                        <div class="pull-xs-left m-r-1">
                                                          <input type="text" value="<?php echo $technical_competencies;?>" data-role="tagsinput" name="technical_competencies">
                                                        </div>
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <div class="row">
                                                    <div class="col-sm-12">
                                                      <div class="form-group">
                                                        <div class="pull-xs-left m-r-1">
                                                          <label class="form-label"><?php echo $this->lang->line('umb_performance_behv_technical_competencies');?></label>
                                                          <br>
                                                          <input type="text" value="<?php echo $organizational_competencies;?>" data-role="tagsinput" name="organizational_competencies">
                                                        </div>
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <div class="row">
                                                    <div class="col-md-4">
                                                      <div class="form-group">
                                                        <label class="form-label"><?php echo $this->lang->line('left_performance');?></label>
                                                        <select class="form-control" name="performance_option" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_performance');?>">
                                                          <option value=""><?php echo $this->lang->line('umb_select_one');?></option>
                                                          <option value="goal" <?php if($performance_option=='goal'){?> selected <?php }?>><?php echo $this->lang->line('umb_hr_title_tujuan');?></option>
                                                          <option value="appraisal" <?php if($performance_option=='appraisal'){?> selected <?php }?>><?php echo $this->lang->line('left_performance_xappraisal');?></option>
                                                          <option value="both" <?php if($performance_option=='both'){?> selected <?php }?>><?php echo $this->lang->line('umb_both_tujuan_appraisal');?></option>
                                                        </select>
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <div class="row">
                                                    <div class="col-md-12">
                                                      <div class="form-group">
                                                        <div class="form-actions box-footer">
                                                          <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('umb_save');?> </button>
                                                        </div>
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <?php echo form_close(); ?> </div>
                                                </div>
                                              </div>
                                              <?php if($system[0]->module_files=='true'){?>
                                                <div class="tab-pane fade <?php echo $actshow440;?>" id="account-files">
                                                  <div class="card-body pb-2">
                                                    <div class="card-block">
                                                      <?php $attributes = array('name' => 'setting_info', 'id' => 'file_setting_info', 'autocomplete' => 'off');?>
                                                      <?php $hidden = array('u_basic_info' => 'UPDATE');?>
                                                      <?php echo form_open('admin/files/setting_info/'.$info_perusahaan_id, $attributes, $hidden);?>
                                                      <div class="row">
                                                        <div class="col-md-3">
                                                          <label class="form-label"><?php echo $this->lang->line('umb_file_maxsize');?></label>
                                                          <br>
                                                          <div class="input-group">
                                                            <input type="text" class="form-control" value="<?php echo $file_setting[0]->maximum_file_size;?>" name="maximum_file_size" placeholder="<?php echo $this->lang->line('umb_file_size_mb');?>" maxlength="2000" min="1">
                                                            <div class="input-group-append"> <span class="input-group-text">MB</span> </div>
                                                          </div>
                                                        </div>
                                                        <div class="col-md-7">
                                                          <div class="form-group">
                                                            <label class="form-label"><?php echo $this->lang->line('umb_allowed_extensions');?></label>
                                                            <br>
                                                            <input type="text" value="<?php echo $file_setting[0]->allowed_extensions;?>" data-role="tagsinput" name="allowed_extensions">
                                                          </div>
                                                        </div>
                                                      </div>
                                                      <div class="row">
                                                        <div class="col-md-6">
                                                          <div class="form-group">
                                                            <label class="form-label"><?php echo $this->lang->line('umb_karyawan_can_view_download_other_files');?></label>
                                                            <br>
                                                            <div class="pull-xs-left m-r-1">
                                                              <label class="switcher switcher-success">
                                                                <input type="checkbox" name="view_all_files" id="view_all_files" class="js-switch switch switcher-input" data-group-cls="btn-group-sm"  <?php if($file_setting[0]->is_enable_all_files=='yes'):?> checked="checked" <?php endif;?> value="yes">
                                                                <span class="switcher-indicator"> <span class="switcher-yes"> <span class="ion ion-md-checkmark"></span> </span> <span class="switcher-no"> <span class="ion ion-md-close"></span> </span> </span> </label>
                                                              </div>
                                                            </div>
                                                          </div>
                                                        </div>
                                                        <div class="row">
                                                          <div class="col-md-12">
                                                            <div class="form-group">
                                                              <div class="form-actions box-footer">
                                                                <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('umb_save');?> </button>
                                                              </div>
                                                            </div>
                                                          </div>
                                                        </div>
                                                        <?php echo form_close(); ?> </div>
                                                      </div>
                                                    </div>
                                                  <?php } ?>
                                                  <div class="tab-pane fade <?php echo $actshow437;?>" id="account-email">
                                                    <div class="card-body pb-2">
                                                      <div class="card-block">
                                                        <?php $attributes = array('name' => 'email_info', 'id' => 'email_info', 'autocomplete' => 'off');?>
                                                        <?php $hidden = array('u_basic_info' => 'UPDATE');?>
                                                        <?php echo form_open('admin/settings/email_info/'.$info_perusahaan_id, $attributes, $hidden);?>
                                                        <div class="bg-white">
                                                          <div class="row">
                                                            <div class="col-md-4">
                                                              <div class="form-group">
                                                                <label class="form-label"><?php echo $this->lang->line('umb_email_notification_enable');?></label>
                                                                <br>
                                                                <div class="pull-xs-left m-r-1">
                                                                  <label class="switcher switcher-success">
                                                                    <input type="checkbox" name="srole_email_notification" id="srole_email_notification" class="js-switch switch switcher-input" data-group-cls="btn-group-sm"  <?php if($enable_email_notification=='yes'):?> checked="checked" <?php endif;?> value="yes" />
                                                                    <span class="switcher-indicator"> <span class="switcher-yes"> <span class="ion ion-md-checkmark"></span> </span> <span class="switcher-no"> <span class="ion ion-md-close"></span> </span> </span> </label>
                                                                  </div>
                                                                </div>
                                                              </div>
                                                              <div class="col-md-4">
                                                                <div class="form-group">
                                                                  <label class="form-label"><?php echo $this->lang->line('umb_mail_type_config');?></label>
                                                                  <select class="form-control" name="email_type" id="email_type" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_mail_type_config');?>">
                                                                    <option value="codeigniter" <?php if($email_type == 'codeigniter'):?> selected="selected"<?php endif;?>>CodeIgniter Mail()</option>
                                                                    <option value="phpmail" <?php if($email_type == 'phpmail'):?> selected="selected"<?php endif;?>>PHP Mail()</option>
                                                                  </select>
                                                                </div>
                                                              </div>
                                                            </div>
                                                            <?php if($email_type == 'smtp'): $sm_opt = 'style="display:block;"';  else: $sm_opt = 'style="display:none;"'; endif;?>
                                                            <div class="row" id="smtp_options" <?php echo $sm_opt;?>>
                                                              <div class="col-md-4">
                                                                <div class="form-group">
                                                                  <label class="form-label"><?php echo $this->lang->line('umb_mail_smtp_host');?></label>
                                                                  <input class="form-control" placeholder="<?php echo $this->lang->line('umb_mail_smtp_host');?>" name="smtp_host" type="text" value="<?php echo $smtp_host;?>">
                                                                </div>
                                                              </div>
                                                              <div class="col-md-4">
                                                                <div class="form-group">
                                                                  <label class="form-label"><?php echo $this->lang->line('umb_mail_smtp_username');?></label>
                                                                  <input class="form-control" placeholder="<?php echo $this->lang->line('umb_mail_smtp_username');?>" name="smtp_username" type="text" value="<?php echo $smtp_username;?>">
                                                                </div>
                                                              </div>
                                                              <div class="col-md-4">
                                                                <div class="form-group">
                                                                  <label class="form-label"><?php echo $this->lang->line('umb_mail_smtp_password');?></label>
                                                                  <input class="form-control" placeholder="<?php echo $this->lang->line('umb_mail_smtp_password');?>" name="smtp_password" type="password" value="<?php echo $smtp_password;?>">
                                                                </div>
                                                              </div>
                                                              <div class="col-md-4">
                                                                <div class="form-group">
                                                                  <label class="form-label"><?php echo $this->lang->line('umb_mail_smtp_port');?></label>
                                                                  <input class="form-control" placeholder="<?php echo $this->lang->line('umb_mail_smtp_port');?>" name="smtp_port" type="text" value="<?php echo $smtp_port;?>">
                                                                </div>
                                                              </div>
                                                              <div class="col-md-4">
                                                                <div class="form-group">
                                                                  <label class="form-label"><?php echo $this->lang->line('umb_mail_smtp_secure');?></label>
                                                                  <select class="form-control" name="smtp_secure" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_mail_smtp_secure');?>">
                                                                    <option value="tls"<?php if($smtp_secure == 'tls'):?> selected="selected"<?php endif;?>>TLS</option>
                                                                    <option value="ssl"<?php if($smtp_secure == 'ssl'):?> selected="selected"<?php endif;?>>SSL</option>
                                                                  </select>
                                                                </div>
                                                              </div>
                                                            </div>
                                                            <div class="row">
                                                              <div class="col-md-12">
                                                                <div class="form-group">
                                                                  <div class="form-actions box-footer">
                                                                    <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('umb_save');?> </button>
                                                                  </div>
                                                                </div>
                                                              </div>
                                                            </div>
                                                          </div>
                                                          <?php echo form_close(); ?> </div>
                                                        </div>
                                                      </div>
                                                      <div class="tab-pane fade <?php echo $actshow438;?>" id="account-page_layouts">
                                                        <div class="card-body pb-2">
                                                          <div class="card-block">
                                                            <?php $attributes = array('name' => 'info_page_layouts', 'id' => 'info_page_layouts', 'autocomplete' => 'off');?>
                                                            <?php $hidden = array('theme_info' => 'UPDATE');?>
                                                            <?php echo form_open('admin/theme/page_layouts/', $attributes, $hidden);?>
                                                            <div class="row">
                                                              <div class="col-md-4">
                                                                <div class="form-group">
                                                                  <label class="form-label"><?php echo $this->lang->line('umb_theme_show_dashboard_cards');?></label>
                                                                  <select class="form-control" name="statistics_cards" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_theme_show_dashboard_cards');?>">
                                                                    <option value=""><?php echo $this->lang->line('umb_select_one');?></option>
                                                                    <option value="4" <?php if($statistics_cards=='4'){?> selected <?php }?>>4</option>
                                                                    <option value="8" <?php if($statistics_cards=='8'){?> selected <?php }?>>8</option>
                                                                  </select>
                                                                  <br />
                                                                  <small class="text-muted"><i class="fas fa-hand-point-up"></i> <?php echo $this->lang->line('umb_theme_set_statistics_cards');?></small> </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                  <div class="form-group">
                                                                    <label class="form-label"> <?php echo $this->lang->line('umb_hrastral_dashboard_options');?></label>
                                                                    <select class="form-control" name="dashboard_option" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_select_one');?>">
                                                                      <option value=""><?php echo $this->lang->line('umb_select_one');?></option>
                                                                      <option value="dashboard_1" <?php if($dashboard_option=='dashboard_1'){?> selected <?php }?>> <?php echo $this->lang->line('umb_hrastral_dashboard_option_1');?></option>
                                                                      <option value="dashboard_light_2" <?php if($dashboard_option=='dashboard_light_2'){?> selected <?php }?>> <?php echo $this->lang->line('umb_hrastral_dashboard_2light');?></option>
                                                                      <option value="dashboard_dark_2" <?php if($dashboard_option=='dashboard_dark_2'){?> selected <?php }?>> <?php echo $this->lang->line('umb_hrastral_dashboard_2dark');?></option>
                                                                      <option value="dashboard_3" <?php if($dashboard_option=='dashboard_3'){?> selected <?php }?>> <?php echo $this->lang->line('umb_hrastral_dashboard_option_3');?></option>
                                                                    </select>
                                                                    <br />
                                                                    <small class="text-muted"><i class="fas fa-hand-point-up"></i> <?php echo $this->lang->line('umb_hrastral_dashboard_options_details');?></small> </div>
                                                                  </div>
                                                                  <div class="col-md-4">
                                                                    <div class="form-group">
                                                                      <label class="form-label"> <?php echo $this->lang->line('umb_sign_in_page_options');?></label>
                                                                      <select class="form-control" name="login_page_options" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_select_one');?>">
                                                                        <option value=""><?php echo $this->lang->line('umb_select_one');?></option>
                                                                        <option value="login_page_1" <?php if($login_page_options=='login_page_1'){?> selected <?php }?>> <?php echo $this->lang->line('umb_hrastral_login_v1');?></option>
                                                                        <option value="login_page_2" <?php if($login_page_options=='login_page_2'){?> selected <?php }?>><?php echo $this->lang->line('umb_hrastral_login_v2');?></option>
                                                                        <option value="login_page_3" <?php if($login_page_options=='login_page_3'){?> selected <?php }?>><?php echo $this->lang->line('umb_hrastral_login_v3');?></option>
                                                                      </select>
                                                                      <br />
                                                                      <small class="text-muted"><i class="fas fa-hand-point-up"></i> <?php echo $this->lang->line('umb_sign_in_page_option_details');?></small> </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                      <div class="form-group">
                                                                        <label class="form-label" data-trigger="hover"> <?php echo $this->lang->line('umb_hrastral_show_calendar_on_dashboard');?> </label>
                                                                        <br>
                                                                        <div class="pull-xs-left m-r-1">
                                                                          <label class="switcher switcher-success">
                                                                            <input type="checkbox" name="dashboard_calendar" class="js-switch switch switcher-input" <?php if($dashboard_calendar=='true'):?> checked="checked" <?php endif;?> value="true" />
                                                                            <span class="switcher-indicator"> <span class="switcher-yes"> <span class="ion ion-md-checkmark"></span> </span> <span class="switcher-no"> <span class="ion ion-md-close"></span> </span> </span> </label>
                                                                          </div>
                                                                        </div>
                                                                      </div>
                                                                      <div class="col-md-12">
                                                                        <div class="form-group">
                                                                          <label class="form-label"><?php echo $this->lang->line('umb_text_page_login');?> </label>
                                                                          <textarea class="form-control" name="text_page_login" id="text_page_login" rows="3"><?php echo $text_page_login;?></textarea>
                                                                          <small class="text-muted"><i class="fas fa-hand-point-up"></i> <?php echo $this->lang->line('umb_text_page_login_desc');?></small> </div>
                                                                        </div>
                                                                      </div>
                                                                      <div class="row">
                                                                        <div class="col-md-12">
                                                                          <div class="form-group">
                                                                            <div class="form-actions box-footer">
                                                                              <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('umb_save');?> </button>
                                                                            </div>
                                                                          </div>
                                                                        </div>
                                                                      </div>
                                                                      <?php echo form_close(); ?> </div>
                                                                    </div>
                                                                  </div>
                                                                  <div class="tab-pane fade <?php echo $actshow439;?>" id="account-notification_position">
                                                                    <div class="card-body pb-2">
                                                                      <div class="card-block">
                                                                        <?php $attributes = array('name' => 'info_notification_position', 'id' => 'info_notification_position', 'autocomplete' => 'off');?>
                                                                        <?php $hidden = array('theme_info' => 'UPDATE');?>
                                                                        <?php echo form_open('admin/theme/info_notification_position/', $attributes, $hidden);?>
                                                                        <div class="row">
                                                                          <div class="col-md-4">
                                                                            <div class="form-group">
                                                                              <label class="form-label"><?php echo $this->lang->line('dashboard_position');?></label>
                                                                              <select class="form-control" name="notification_position" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('dashboard_position');?>">
                                                                                <option value=""><?php echo $this->lang->line('umb_select_one');?></option>
                                                                                <option value="toast-top-right" <?php if($notification_position=='toast-top-right'){?> selected <?php }?>><?php echo $this->lang->line('umb_top_right');?></option>
                                                                                <option value="toast-bottom-right" <?php if($notification_position=='toast-bottom-right'){?> selected <?php }?>><?php echo $this->lang->line('umb_bottom_right');?></option>
                                                                                <option value="toast-bottom-left" <?php if($notification_position=='toast-bottom-left'){?> selected <?php }?>><?php echo $this->lang->line('umb_bottom_left');?></option>
                                                                                <option value="toast-top-left" <?php if($notification_position=='toast-top-left'){?> selected <?php }?>><?php echo $this->lang->line('umb_top_left');?></option>
                                                                                <option value="toast-top-center" <?php if($notification_position=='toast-top-center'){?> selected <?php }?>><?php echo $this->lang->line('umb_top_center');?></option>
                                                                              </select>
                                                                              <br />
                                                                              <small class="text-muted"><i class="ft-arrow-up"></i> <?php echo $this->lang->line('umb_set_position_for_notifications');?></small> </div>
                                                                            </div>
                                                                            <div class="col-md-3">
                                                                              <div class="form-group">
                                                                                <label class="form-label"><?php echo $this->lang->line('umb_close_button');?></label>
                                                                                <br>
                                                                                <div class="pull-xs-left m-r-1">
                                                                                  <label class="switcher switcher-success">
                                                                                    <input type="checkbox" name="sclose_btn" id="sclose_btn" class="js-switch switch switcher-input" <?php if($notification_close_btn=='true'):?> checked="checked" <?php endif;?> value="true">
                                                                                    <span class="switcher-indicator"> <span class="switcher-yes"> <span class="ion ion-md-checkmark"></span> </span> <span class="switcher-no"> <span class="ion ion-md-close"></span> </span> </span> </label>
                                                                                  </div>
                                                                                </div>
                                                                              </div>
                                                                              <div class="col-md-4">
                                                                                <div class="form-group">
                                                                                  <label class="form-label"><?php echo $this->lang->line('umb_progress_bar');?></label>
                                                                                  <br>
                                                                                  <div class="pull-xs-left m-r-1">
                                                                                    <label class="switcher switcher-success">
                                                                                      <input type="checkbox" name="snotification_bar" id="snotification_bar" class="js-switch switch switcher-input" <?php if($notification_bar=='true'):?> checked="checked" <?php endif;?> value="true">
                                                                                      <span class="switcher-indicator"> <span class="switcher-yes"> <span class="ion ion-md-checkmark"></span> </span> <span class="switcher-no"> <span class="ion ion-md-close"></span> </span> </span> </label>
                                                                                    </div>
                                                                                  </div>
                                                                                </div>
                                                                              </div>
                                                                              <div class="row">
                                                                                <div class="col-md-12">
                                                                                  <div class="form-group">
                                                                                    <div class="form-actions box-footer">
                                                                                      <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('umb_save');?> </button>
                                                                                    </div>
                                                                                  </div>
                                                                                </div>
                                                                              </div>
                                                                              <?php echo form_close(); ?> </div>
                                                                            </div>
                                                                          </div>
                                                                          <div class="tab-pane fade <?php echo $actshow118;?>" id="account-system_logos">
                                                                            <div class="row">
                                                                              <div class="col-xl-12">
                                                                                <div class="nav-tabs-top mb-4">
                                                                                  <ul class="nav nav-tabs">
                                                                                    <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#umb_system_logos"><?php echo $this->lang->line('umb_system_logos');?></a> </li>
                                                                                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#umb_theme_signin_page_logo_title"><?php echo $this->lang->line('umb_theme_signin_page_logo_title');?></a> </li>
                                                                                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#umb_theme_pekerjaan_page_logo_title"><?php echo $this->lang->line('umb_theme_pekerjaan_page_logo_title');?></a> </li>
                                                                                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#umb_theme_logo_payroll_title"><?php echo $this->lang->line('umb_theme_logo_payroll_title');?></a> </li>
                                                                                  </ul>
                                                                                  <div class="tab-content">
                                                                                    <div class="tab-pane fade active show" id="umb_system_logos">
                                                                                      <div class="card-body">
                                                                                        <div class="row">
                                                                                          <div class="col-md-6">
                                                                                            <?php $attributes = array('name' => 'info_logo', 'id' => 'info_logo', 'autocomplete' => 'off');?>
                                                                                            <?php $hidden = array('logo_perusahaan' => 'UPDATE');?>
                                                                                            <?php echo form_open_multipart('admin/settings/info_logo/'.$info_perusahaan_id, $attributes, $hidden);?>
                                                                                            <div class='form-group'>
                                                                                              <fieldset class="form-group">
                                                                                                <label class="form-label"><?php echo $this->lang->line('umb_first_logo');?></label>
                                                                                                <?php if($logo!='' && $logo!='no file') {?>
                                                                                                  <input type="file" class="form-control-file" id="p_file" name="p_file" value="<?php echo $logo;?>">
                                                                                                <?php } else {?>
                                                                                                  <input type="file" class="form-control-file" id="p_file" name="p_file">
                                                                                                <?php } ?>
                                                                                              </fieldset>
                                                                                              <?php if($logo!='' && $logo!='no file') {?>
                                                                                                <img src="<?php echo base_url().'uploads/logo/'.$logo;?>" width="70px" style="margin-left:30px;" id="u_file_1">
                                                                                              <?php } else {?>
                                                                                                <img src="<?php echo base_url().'uploads/logo/no_logo.png';?>" width="70px" style="margin-left:30px;" id="u_file_1">
                                                                                              <?php } ?>
                                                                                              <br>
                                                                                              <small>- <?php echo $this->lang->line('umb_logo_files_only');?></small><br />
                                                                                              <small>- <?php echo $this->lang->line('umb_best_main_logo_size');?></small><br />
                                                                                              <small>- <?php echo $this->lang->line('umb_logo_whit_background_light_text');?></small> </div>
                                                                                              <div class="form-actions box-footer">
                                                                                                <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('umb_save');?> </button>
                                                                                              </div>
                                                                                              <?php echo form_close(); ?> </div>
                                                                                              <div class="col-md-6">
                                                                                                <?php $attributes = array('name' => 'logo_favicon', 'id' => 'logo_favicon', 'autocomplete' => 'off');?>
                                                                                                <?php $hidden = array('logo_perusahaan' => 'UPDATE');?>
                                                                                                <?php echo form_open_multipart('admin/settings/logo_favicon/'.$info_perusahaan_id, $attributes, $hidden);?>
                                                                                                <div class='form-group'>
                                                                                                  <fieldset class="form-group">
                                                                                                    <label class="form-label"><?php echo $this->lang->line('umb_favicon');?></label>
                                                                                                    <input type="file" class="form-control-file" id="favicon" name="favicon">
                                                                                                  </fieldset>
                                                                                                  <?php if($favicon!='' && $favicon!='no file') {?>
                                                                                                    <img src="<?php echo base_url().'uploads/logo/favicon/'.$favicon;?>" width="16px" style="margin-left:30px;" id="favicon1">
                                                                                                  <?php } else {?>
                                                                                                    <img src="<?php echo base_url().'uploads/logo/no_logo.png';?>" width="16px" style="margin-left:30px;" id="favicon1">
                                                                                                  <?php } ?>
                                                                                                  <br>
                                                                                                  <small>- <?php echo $this->lang->line('umb_logo_files_only_favicon');?></small><br />
                                                                                                  <small>- <?php echo $this->lang->line('umb_best_logo_size_favicon');?></small></div>
                                                                                                  <div class="form-actions box-footer">
                                                                                                    <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('umb_save');?> </button>
                                                                                                  </div>
                                                                                                  <?php echo form_close(); ?> </div>
                                                                                                </div>
                                                                                              </div>
                                                                                            </div>
                                                                                            <div class="tab-pane fade" id="umb_theme_signin_page_logo_title">
                                                                                              <div class="card-body">
                                                                                                <?php $attributes = array('name' => 'singin_logo', 'id' => 'singin_logo', 'autocomplete' => 'off');?>
                                                                                                <?php $hidden = array('logo_perusahaan' => 'UPDATE');?>
                                                                                                <?php echo form_open_multipart('admin/theme/singin_logo/', $attributes, $hidden);?>
                                                                                                <div class="row">
                                                                                                  <div class="col-md-6">
                                                                                                    <div class='form-group'>
                                                                                                      <fieldset class="form-group">
                                                                                                        <label class="form-label"><?php echo $this->lang->line('umb_logo');?></label>
                                                                                                        <input type="file" class="form-control-file" id="p_file3" name="p_file3">
                                                                                                      </fieldset>
                                                                                                      <?php if($sign_in_logo!='' && $sign_in_logo!='no file') {?>
                                                                                                        <img src="<?php echo base_url().'uploads/logo/signin/'.$sign_in_logo;?>" width="70px" style="margin-left:30px;" id="u_file3">
                                                                                                      <?php } else {?>
                                                                                                        <img src="<?php echo base_url().'uploads/logo/no_logo.png';?>" width="70px" style="margin-left:30px;" id="u_file3">
                                                                                                      <?php } ?>
                                                                                                      <br>
                                                                                                      <small>- <?php echo $this->lang->line('umb_logo_files_only');?></small><br />
                                                                                                      <small>- <?php echo $this->lang->line('umb_best_signlogo_size');?></small></div>
                                                                                                    </div>
                                                                                                  </div>
                                                                                                  <div class="row">
                                                                                                    <div class="col-md-12">
                                                                                                      <div class="form-actions box-footer">
                                                                                                        <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('umb_save');?> </button>
                                                                                                      </div>
                                                                                                    </div>
                                                                                                  </div>
                                                                                                  <?php echo form_close(); ?> </div>
                                                                                                </div>
                                                                                                <div class="tab-pane fade" id="umb_theme_pekerjaan_page_logo_title">
                                                                                                  <div class="card-body">
                                                                                                    <?php $attributes = array('name' => 'logo_pekerjaan', 'id' => 'logo_pekerjaan', 'autocomplete' => 'off');?>
                                                                                                    <?php $hidden = array('logo_pekerjaan' => 'UPDATE');?>
                                                                                                    <?php echo form_open_multipart('admin/settings/logo_pekerjaan/', $attributes, $hidden);?>
                                                                                                    <div class="row">
                                                                                                      <div class="col-md-6">
                                                                                                        <div class='form-group'>
                                                                                                          <fieldset class="form-group">
                                                                                                            <label class="form-label"><?php echo $this->lang->line('umb_logo');?></label>
                                                                                                            <input type="file" class="form-control-file" id="p_file4" name="p_file4">
                                                                                                          </fieldset>
                                                                                                          <?php if($logo_pekerjaan!='' && $logo_pekerjaan!='no file') {?>
                                                                                                            <img src="<?php echo base_url().'uploads/logo/pekerjaan/'.$logo_pekerjaan;?>" width="70px" style="margin-left:30px;" id="u_file4">
                                                                                                          <?php } else {?>
                                                                                                            <img src="<?php echo base_url().'uploads/logo/no_logo.png';?>" width="70px" style="margin-left:30px;" id="u_file4">
                                                                                                          <?php } ?>
                                                                                                          <br>
                                                                                                          <small>- <?php echo $this->lang->line('umb_logo_files_only');?></small><br />
                                                                                                          <small>- <?php echo $this->lang->line('umb_best_signlogo_size');?> </small></div>
                                                                                                        </div>
                                                                                                      </div>
                                                                                                      <div class="row">
                                                                                                        <div class="col-md-12">
                                                                                                          <div class="form-actions box-footer">
                                                                                                            <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('umb_save');?> </button>
                                                                                                          </div>
                                                                                                        </div>
                                                                                                      </div>
                                                                                                      <?php echo form_close(); ?> </div>
                                                                                                    </div>
                                                                                                    <div class="tab-pane fade" id="umb_theme_logo_payroll_title">
                                                                                                      <div class="card-body">
                                                                                                        <?php $attributes = array('name' => 'logo_payroll', 'id' => 'logo_payroll_info', 'autocomplete' => 'off');?>
                                                                                                        <?php $hidden = array('logo_payroll' => 'UPDATE');?>
                                                                                                        <?php echo form_open_multipart('admin/settings/logo_payroll/', $attributes, $hidden);?>
                                                                                                        <div class="row">
                                                                                                          <div class="col-md-6">
                                                                                                            <div class='form-group'>
                                                                                                              <fieldset class="form-group">
                                                                                                                <label class="form-label"><?php echo $this->lang->line('umb_logo');?></label>
                                                                                                                <input type="file" class="form-control-file" id="p_file5" name="p_file5">
                                                                                                              </fieldset>
                                                                                                              <?php if($logo_payroll!='' && $logo_payroll!='no file') {?>
                                                                                                                <img src="<?php echo base_url().'uploads/logo/payroll/'.$logo_payroll;?>" width="70px" style="margin-left:30px;" id="u_file5">
                                                                                                              <?php } else {?>
                                                                                                                <img src="<?php echo base_url().'uploads/logo/no_logo.png';?>" width="70px" style="margin-left:30px;" id="u_file5">
                                                                                                              <?php } ?>
                                                                                                              <br>
                                                                                                              <small>- <?php echo $this->lang->line('umb_logo_files_only');?></small><br />
                                                                                                              <small>- <?php echo $this->lang->line('umb_best_signlogo_size');?></small></div>
                                                                                                            </div>
                                                                                                          </div>
                                                                                                          <div class="row">
                                                                                                            <div class="col-md-12">
                                                                                                              <div class="form-actions box-footer">
                                                                                                                <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('umb_save');?> </button>
                                                                                                              </div>
                                                                                                            </div>
                                                                                                          </div>
                                                                                                          <?php echo form_close(); ?> </div>
                                                                                                        </div>
                                                                                                      </div>
                                                                                                    </div>
                                                                                                  </div>
                                                                                                </div>
                                                                                              </div>
                                                                                              <?php if($system[0]->module_orgchart=='true'){?>
                                                                                                <div class="tab-pane fade <?php echo $actshow441;?>" id="account-org_chart">
                                                                                                  <div class="card-body pb-2">
                                                                                                    <div class="card-block">
                                                                                                      <?php $attributes = array('name' => 'orgchart_info', 'id' => 'orgchart_info', 'autocomplete' => 'off');?>
                                                                                                      <?php $hidden = array('iorgchart_info' => 'UPDATE');?>
                                                                                                      <?php echo form_open('admin/theme/orgchart/', $attributes, $hidden);?>
                                                                                                      <div class="row">
                                                                                                        <div class="col-md-4">
                                                                                                          <div class="form-group">
                                                                                                            <label class="form-label"><?php echo $this->lang->line('umb_org_chart_layout');?></label>
                                                                                                            <select class="form-control" name="org_chart_layout" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_org_chart_layout');?>">
                                                                                                              <option value=""><?php echo $this->lang->line('umb_select_one');?></option>
                                                                                                              <option value="r2l" <?php if($org_chart_layout=='r2l'){?> selected <?php }?>><?php echo $this->lang->line('umb_org_chart_r2l');?></option>
                                                                                                              <option value="l2r" <?php if($org_chart_layout=='l2r'){?> selected <?php }?>><?php echo $this->lang->line('umb_org_chart_l2r');?></option>
                                                                                                              <option value="t2b" <?php if($org_chart_layout=='t2b'){?> selected <?php }?>><?php echo $this->lang->line('umb_org_chart_t2b');?></option>
                                                                                                              <option value="b2t" <?php if($org_chart_layout=='b2t'){?> selected <?php }?>><?php echo $this->lang->line('umb_org_chart_b2t');?></option>
                                                                                                            </select>
                                                                                                            <br />
                                                                                                            <small class="text-muted"><i class="ft-arrow-up"></i> <?php echo $this->lang->line('umb_org_chart_set_layout');?></small> </div>
                                                                                                          </div>
                                                                                                          <div class="col-md-4">
                                                                                                            <div class="form-group">
                                                                                                              <label class="form-label"><?php echo $this->lang->line('umb_org_chart_export_file_title');?></label>
                                                                                                              <input class="form-control" placeholder="<?php echo $this->lang->line('umb_org_chart_export_file_title');?>" name="export_file_title" type="text" value="<?php echo $export_file_title;?>">
                                                                                                              <small class="text-muted"><i class="ft-arrow-up"></i> <?php echo $this->lang->line('umb_org_chart_export_file_title_details');?> </small> </div>
                                                                                                            </div>
                                                                                                            <div class="col-md-4">
                                                                                                              <div class="form-group">
                                                                                                                <label class="form-label" data-trigger="hover"> <?php echo $this->lang->line('umb_org_chart_export');?>
                                                                                                                <button type="button" class="btn icon-btn btn-xs btn-default itheme-btn borderless" data-toggle="popover" data-placement="top" data-content="<?php echo $this->lang->line('umb_org_chart_export_details');?>" data-trigger="hover" data-original-title="<?php echo $this->lang->line('umb_org_chart_export');?>"><span class="fa fa-question-circle"></span></button>
                                                                                                              </label>
                                                                                                              <div class="pull-xs-left m-r-1">
                                                                                                                <label class="switcher switcher-success">
                                                                                                                  <input type="checkbox" name="export_orgchart" id="export_orgchart" class="js-switch switch switcher-input" <?php if($export_orgchart=='true'):?> checked="checked" <?php endif;?> value="true">
                                                                                                                  <span class="switcher-indicator"> <span class="switcher-yes"> <span class="ion ion-md-checkmark"></span> </span> <span class="switcher-no"> <span class="ion ion-md-close"></span> </span> </span> </label>
                                                                                                                </div>
                                                                                                              </div>
                                                                                                            </div>
                                                                                                          </div>
                                                                                                          <div class="row">
                                                                                                            <div class="col-md-3">
                                                                                                              <div class="form-group">
                                                                                                                <label class="form-label" data-trigger="hover"> <?php echo $this->lang->line('umb_org_chart_zoom');?>
                                                                                                                <button type="button" class="btn icon-btn btn-xs btn-default itheme-btn borderless" data-toggle="popover" data-placement="top" data-content="<?php echo $this->lang->line('umb_org_chart_zoom_details');?>" data-trigger="hover" data-original-title="<?php echo $this->lang->line('umb_org_chart_zoom');?>"><span class="fa fa-question-circle"></span></button>
                                                                                                              </label>
                                                                                                              <div class="pull-xs-left m-r-1">
                                                                                                                <label class="switcher switcher-success">
                                                                                                                  <input type="checkbox" name="org_chart_zoom" id="org_chart_zoom" class="js-switch switch switcher-input" <?php if($org_chart_zoom=='true'):?> checked="checked" <?php endif;?> value="true">
                                                                                                                  <span class="switcher-indicator"> <span class="switcher-yes"> <span class="ion ion-md-checkmark"></span> </span> <span class="switcher-no"> <span class="ion ion-md-close"></span> </span> </span> </label>
                                                                                                                </div>
                                                                                                              </div>
                                                                                                            </div>
                                                                                                            <div class="col-md-3">
                                                                                                              <div class="form-group">
                                                                                                                <label class="form-label" data-trigger="hover"> <?php echo $this->lang->line('umb_org_chart_pan');?>
                                                                                                                <button type="button" class="btn icon-btn btn-xs btn-default itheme-btn borderless" data-toggle="popover" data-placement="top" data-content="<?php echo $this->lang->line('umb_org_chart_pan_details');?>" data-trigger="hover" data-original-title="<?php echo $this->lang->line('umb_org_chart_pan');?>"><span class="fa fa-question-circle"></span></button>
                                                                                                              </label>
                                                                                                              <div class="pull-xs-left m-r-1">
                                                                                                                <label class="switcher switcher-success">
                                                                                                                  <input type="checkbox" name="org_chart_pan" id="org_chart_pan" class="js-switch switch switcher-input" <?php if($org_chart_pan=='true'):?> checked="checked" <?php endif;?> value="true">
                                                                                                                  <span class="switcher-indicator"> <span class="switcher-yes"> <span class="ion ion-md-checkmark"></span> </span> <span class="switcher-no"> <span class="ion ion-md-close"></span> </span> </span> </label>
                                                                                                                </div>
                                                                                                              </div>
                                                                                                            </div>
                                                                                                          </div>
                                                                                                          <div class="row">
                                                                                                            <div class="col-md-12">
                                                                                                              <div class="form-group">
                                                                                                                <div class="form-actions box-footer">
                                                                                                                  <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('umb_save');?> </button>
                                                                                                                </div>
                                                                                                              </div>
                                                                                                            </div>
                                                                                                          </div>
                                                                                                          <?php echo form_close(); ?> </div>
                                                                                                        </div>
                                                                                                      </div>
                                                                                                    <?php } ?>
                                                                                                    <div class="tab-pane fade <?php echo $actshow118;?>" id="account-payment_gateway">
                                                                                                      <div class="card-body">
                                                                                                        <?php $attributes = array('name' => 'payment_gateway', 'id' => 'payment_gateway', 'autocomplete' => 'off');?>
                                                                                                        <?php $hidden = array('u_info_perusahaan' => 'UPDATE');?>
                                                                                                        <?php echo form_open('admin/settings/update_payment_gateway/996633', $attributes, $hidden);?>
                                                                                                        <h5><?php echo $this->lang->line('umb_acc_paypal_info');?></h5>
                                                                                                        <div class="row">
                                                                                                          <div class="col-md-12">
                                                                                                            <div class="form-group">
                                                                                                              <label class="form-label"><?php echo $this->lang->line('umb_acc_paypal_email');?></label>
                                                                                                              <input class="form-control" placeholder="<?php echo $this->lang->line('umb_acc_paypal_email');?>" name="paypal_email" type="text" value="<?php echo $paypal_email;?>">
                                                                                                            </div>
                                                                                                            <div class="form-group">
                                                                                                              <div class="row">
                                                                                                                <div class="col-md-6">
                                                                                                                  <label class="form-label"><?php echo $this->lang->line('umb_acc_paypal_sandbox_active');?></label>
                                                                                                                  <select class="form-control" name="paypal_sandbox" data-plugin="umb_select" data-placeholder="<?php echo $this->lang->line('paypal_sandbox_active');?>">
                                                                                                                    <option value=""><?php echo $this->lang->line('umb_select_one');?></option>
                                                                                                                    <option value="yes" <?php if($paypal_sandbox =='yes'):?> selected="selected"<?php endif;?>> <?php echo $this->lang->line('umb_yes');?></option>
                                                                                                                    <option value="no" <?php if($paypal_sandbox =='no'):?> selected="selected"<?php endif;?>> <?php echo $this->lang->line('umb_no');?></option>
                                                                                                                  </select>
                                                                                                                </div>
                                                                                                                <div class="col-md-6">
                                                                                                                  <label class="form-label"><?php echo $this->lang->line('umb_karyawans_active');?></label>
                                                                                                                  <select class="form-control" name="paypal_active" data-plugin="umb_select" data-placeholder="<?php echo $this->lang->line('umb_karyawans_active');?>">
                                                                                                                    <option value=""><?php echo $this->lang->line('umb_select_one');?></option>
                                                                                                                    <option value="yes" <?php if($paypal_active =='yes'):?> selected="selected"<?php endif;?>> <?php echo $this->lang->line('umb_yes');?></option>
                                                                                                                    <option value="no" <?php if($paypal_active =='no'):?> selected="selected"<?php endif;?>> <?php echo $this->lang->line('umb_no');?></option>
                                                                                                                  </select>
                                                                                                                </div>
                                                                                                              </div>
                                                                                                            </div>
                                                                                                            <div class="form-group">
                                                                                                              <label class="form-label"><?php echo $this->lang->line('umb_acc_paypal_ipn_url');?></label>
                                                                                                              <input class="form-control" placeholder="<?php echo $this->lang->line('umb_acc_paypal_ipn_url');?>" name="paypal_ipn_url" type="text" value="<?php echo site_url('admin/gateway/paypal_process/paypal_ipn');?>" readonly="readonly">
                                                                                                            </div>
                                                                                                          </div>
                                                                                                        </div>
                                                                                                      </div>
                                                                                                      <hr class="border-light m-0">
                                                                                                      <div class="card-body">
                                                                                                        <h5 class="pb-2"><?php echo $this->lang->line('umb_acc_stripe_info');?></h5>
                                                                                                        <div class="row">
                                                                                                          <div class="col-md-12">
                                                                                                            <div class="form-group">
                                                                                                              <label class="form-label"><?php echo $this->lang->line('umb_acc_stripe_secret_key');?></label>
                                                                                                              <input class="form-control" placeholder="<?php echo $this->lang->line('umb_acc_stripe_secret_key');?>" name="stripe_secret_key" type="text" value="<?php echo $stripe_secret_key;?>">
                                                                                                            </div>
                                                                                                            <div class="form-group">
                                                                                                              <label class="form-label"><?php echo $this->lang->line('umb_acc_stripe_publlished_key');?></label>
                                                                                                              <input class="form-control" placeholder="<?php echo $this->lang->line('umb_acc_stripe_publlished_key');?>" name="stripe_publishable_key" type="text" value="<?php echo $stripe_publishable_key;?>">
                                                                                                            </div>
                                                                                                            <div class="form-group">
                                                                                                              <label class="form-label"><?php echo $this->lang->line('umb_karyawans_active');?></label>
                                                                                                              <select class="form-control" name="stripe_active" data-plugin="umb_select" data-placeholder="<?php echo $this->lang->line('umb_karyawans_active');?>">
                                                                                                                <option value=""><?php echo $this->lang->line('umb_select_one');?></option>
                                                                                                                <option value="yes" <?php if($stripe_active =='yes'):?> selected="selected"<?php endif;?>> <?php echo $this->lang->line('umb_yes');?></option>
                                                                                                                <option value="no" <?php if($stripe_active =='no'):?> selected="selected"<?php endif;?>> <?php echo $this->lang->line('umb_no');?></option>
                                                                                                              </select>
                                                                                                            </div>
                                                                                                          </div>
                                                                                                        </div>
                                                                                                      </div>
                                                                                                      <hr class="border-light m-0">
                                                                                                      <div class="card-body">
                                                                                                        <h6 class="mb-4"><?php echo $this->lang->line('umb_acc_online_payment_receive_account');?></h6>
                                                                                                        <div class="row">
                                                                                                          <div class="col-md-12">
                                                                                                            <div class="form-group">
                                                                                                              <label class="form-label"><?php echo $this->lang->line('umb_acc_account');?></label>
                                                                                                              <select name="bank_cash_id" class="form-control" data-plugin="umb_select" data-placeholder="<?php echo $this->lang->line('umb_acc_choose_account_type');?>">
                                                                                                                <option value=""></option>
                                                                                                                <?php foreach($all_bank_cash as $bank_cash) {?>
                                                                                                                  <option value="<?php echo $bank_cash->bankcash_id;?>" <?php if($online_payment_account == $bank_cash->bankcash_id):?> selected="selected"<?php endif;?>><?php echo $bank_cash->nama_account;?></option>
                                                                                                                <?php } ?>
                                                                                                              </select>
                                                                                                            </div>
                                                                                                          </div>
                                                                                                        </div>
                                                                                                        <div class="row">
                                                                                                          <div class="col-md-12">
                                                                                                            <div class="form-group">
                                                                                                              <div class="form-actions box-footer">
                                                                                                                <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('umb_save');?> </button>
                                                                                                              </div>
                                                                                                            </div>
                                                                                                          </div>
                                                                                                        </div>
                                                                                                        <?php echo form_close(); ?> </div>
                                                                                                      </div>
                                                                                                      <div class="tab-pane fade <?php echo $actshow466;?>" id="account-topmenu">
                                                                                                        <hr class="border-light m-0">
                                                                                                        <div class="card-body">
                                                                                                          <div class="card-block">
                                                                                                            <?php $attributes = array('name' => 'hrtop_menu', 'id' => 'hrtop_menu', 'autocomplete' => 'off');?>
                                                                                                            <?php $hidden = array('u_basic_info' => 'UPDATE');?>
                                                                                                            <?php echo form_open('admin/settings/hr_top_menu/', $attributes, $hidden);?>
                                                                                                            <div class="card mb-4">
                                                                                                              <div class="card-body">
                                                                                                                <?php $hr_top_menu = explode(',',$system[0]->hr_top_menu);?>
                                                                                                                <input type="hidden" value="0" name="hr_top_menu[]" />
                                                                                                                <select multiple="multiple" name="hr_top_menu[]" size="20" id="duallistbox-example">
                                                                                                                  <?php if($system[0]->module_assets=='true'){?>
                                                                                                                    <?php if(in_array('24',$role_resources_ids) && in_array('25',$role_resources_ids) && in_array('26',$role_resources_ids)) {?>
                                                                                                                      <option value="assets" <?php if(in_array('assets',$hr_top_menu)):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('umb_assets');?></option>
                                                                                                                    <?php } ?>
                                                                                                                    <?php if(!in_array('25',$role_resources_ids) && in_array('26',$role_resources_ids)) {?>
                                                                                                                      <option value="kategori_assets" <?php if(in_array('kategori_assets',$hr_top_menu)):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('umb_kategori_assets');?></option>
                                                                                                                    <?php } ?>
                                                                                                                    <?php if(in_array('25',$role_resources_ids) && !in_array('26',$role_resources_ids)) {?>
                                                                                                                      <option value="assets" <?php if(in_array('assets',$hr_top_menu)):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('umb_assets');?></option>
                                                                                                                    <?php } ?>
                                                                                                                  <?php } ?>
                                                                                                                  <?php if($system[0]->module_inquiry=='true'){?>
                                                                                                                    <?php if(in_array('43',$role_resources_ids)) { ?>
                                                                                                                      <option value="tickets" <?php if(in_array('tickets',$hr_top_menu)):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('left_tickets');?></option>
                                                                                                                    <?php } ?>
                                                                                                                  <?php } ?>
                                                                                                                  <?php if($system[0]->module_training=='true'){?>
                                                                                                                    <?php  if(in_array('54',$role_resources_ids) && in_array('55',$role_resources_ids) && in_array('56',$role_resources_ids)) {?>
                                                                                                                      <option value="training" <?php if(in_array('training',$hr_top_menu)):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('left_training');?></option>
                                                                                                                    <?php } ?>
                                                                                                                    <?php  if(in_array('54',$role_resources_ids) && !in_array('55',$role_resources_ids) && !in_array('56',$role_resources_ids)) {?>
                                                                                                                      <option value="training" <?php if(in_array('training',$hr_top_menu)):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('left_training');?></option>
                                                                                                                    <?php } ?>
                                                                                                                    <?php  if(in_array('54',$role_resources_ids) && in_array('55',$role_resources_ids) && !in_array('56',$role_resources_ids)) {?>
                                                                                                                      <option value="training" <?php if(in_array('training',$hr_top_menu)):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('left_training');?></option>
                                                                                                                    <?php } ?>
                                                                                                                    <?php  if(in_array('54',$role_resources_ids) && !in_array('55',$role_resources_ids) && in_array('56',$role_resources_ids)) {?>
                                                                                                                      <option value="training" <?php if(in_array('training',$hr_top_menu)):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('left_training');?></option>
                                                                                                                    <?php } ?>
                                                                                                                    <?php  if(!in_array('54',$role_resources_ids) && in_array('56',$role_resources_ids) && in_array('55',$role_resources_ids)) {?>
                                                                                                                      <option value="trainers_list" <?php if(in_array('trainers_list',$hr_top_menu)):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('left_list_trainers');?></option>
                                                                                                                    <?php } ?>
                                                                                                                    <?php  if(!in_array('54',$role_resources_ids) && in_array('56',$role_resources_ids) && !in_array('55',$role_resources_ids)) {?>
                                                                                                                      <option value="trainers_list" <?php if(in_array('trainers_list',$hr_top_menu)):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('left_list_trainers');?></option>
                                                                                                                    <?php } ?>
                                                                                                                    <?php  if(!in_array('54',$role_resources_ids) && !in_array('56',$role_resources_ids) && in_array('55',$role_resources_ids)) {?>
                                                                                                                      <option value="type_training" <?php if(in_array('type_training',$hr_top_menu)):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('left_type_training');?></option>
                                                                                                                    <?php } ?>
                                                                                                                  <?php } ?>
                                                                                                                  <?php if(in_array('8',$role_resources_ids)) { ?>
                                                                                                                    <option value="libur" <?php if(in_array('libur',$hr_top_menu)):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('left_liburan');?></option>
                                                                                                                  <?php } ?>
                                                                                                                  <?php  if(in_array('92',$role_resources_ids) || in_array('443',$role_resources_ids) || in_array('444',$role_resources_ids)) { ?>
                                                                                                                    <option value="hr_import" <?php if(in_array('hr_import',$hr_top_menu)):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('umb_hr_imports');?></option>
                                                                                                                  <?php } ?>
                                                                                                                  <?php  if(in_array('110',$role_resources_ids) || in_array('111',$role_resources_ids) || in_array('112',$role_resources_ids) || in_array('113',$role_resources_ids) || in_array('114',$role_resources_ids) || in_array('115',$role_resources_ids) || in_array('116',$role_resources_ids) || in_array('117',$role_resources_ids) || in_array('409',$role_resources_ids) || in_array('83',$role_resources_ids) || in_array('84',$role_resources_ids) || in_array('85',$role_resources_ids) || in_array('86',$role_resources_ids)) { ?>
                                                                                                                    <option value="hr_report" <?php if(in_array('hr_report',$hr_top_menu)):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('umb_hr_title_laporan');?></option>
                                                                                                                  <?php } ?>
                                                                                                                  <?php  if(in_array('393',$role_resources_ids)) { ?>
                                                                                                                    <option value="custom_fields" <?php if(in_array('custom_fields',$hr_top_menu)):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('umb_hrastral_custom_fields');?></option>
                                                                                                                  <?php } ?>
                                                                                                                  <?php  if(in_array('80',$role_resources_ids) && in_array('81',$role_resources_ids)) {?>
                                                                                                                    <option value="hr_penerima_pembayarans_pembayars" <?php if(in_array('hr_penerima_pembayarans_pembayars',$hr_top_menu)):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('umb_hr_penerima_pembayarans_pembayars');?></option>
                                                                                                                  <?php } ?>
                                                                                                                  <?php  if(in_array('80',$role_resources_ids) && !in_array('81',$role_resources_ids)) {?>
                                                                                                                    <option value="acc_penerima_pembayarans" <?php if(in_array('acc_penerima_pembayarans',$hr_top_menu)):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('umb_acc_penerima_pembayarans');?></option>
                                                                                                                  <?php } ?>
                                                                                                                  <?php  if(!in_array('80',$role_resources_ids) && in_array('81',$role_resources_ids)) {?>
                                                                                                                    <option value="acc_pembayars" <?php if(in_array('acc_pembayars',$hr_top_menu)):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('umb_acc_pembayars');?></option>
                                                                                                                  <?php } ?>
                                                                                                                  <?php if($system[0]->is_active_sub_departments=='yes'){?>
                                                                                                                    <?php  if(in_array('3',$role_resources_ids)) { ?>
                                                                                                                      <option value="sub_department" <?php if(in_array('sub_department',$hr_top_menu)):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('umb_hr_sub_departments');?></option>
                                                                                                                    <?php } ?>
                                                                                                                  <?php } ?>
                                                                                                                  <?php if($system[0]->module_events=='true'){?>
                                                                                                                    <?php  if(in_array('98',$role_resources_ids) && in_array('99',$role_resources_ids)) {?>
                                                                                                                      <option value="events_meetings" <?php if(in_array('events_meetings',$hr_top_menu)):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('umb_hr_events_meetings');?></option>
                                                                                                                    <?php } ?>
                                                                                                                    <?php  if(in_array('98',$role_resources_ids) && !in_array('99',$role_resources_ids)) {?>
                                                                                                                      <option value="events" <?php if(in_array('events',$hr_top_menu)):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('umb_hr_events');?></option>
                                                                                                                    <?php } ?>
                                                                                                                    <?php  if(!in_array('98',$role_resources_ids) && in_array('99',$role_resources_ids)) {?>
                                                                                                                      <option value="meetings" <?php if(in_array('meetings',$hr_top_menu)):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('umb_hr_meetings');?></option>
                                                                                                                    <?php } ?>
                                                                                                                  <?php } ?>
                                                                                                                  <?php if($system[0]->module_orgchart=='true'){?>
                                                                                                                    <?php  if(in_array('96',$role_resources_ids)) { ?>
                                                                                                                      <option value="orgchart" <?php if(in_array('orgchart',$hr_top_menu)):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('umb_title_org_chart');?></option>
                                                                                                                    <?php } ?>
                                                                                                                  <?php } ?>
                                                                                                                  <?php  if(in_array('60',$role_resources_ids)) { ?>
                                                                                                                    <option value="settings" <?php if(in_array('settings',$hr_top_menu)):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('header_configuration');?></option>
                                                                                                                  <?php } ?>
                                                                                                                </select>
                                                                                                              </div>
                                                                                                            </div>
                                                                                                            <div class="row">
                                                                                                              <div class="col-md-12">
                                                                                                                <div class="form-group">
                                                                                                                  <div class="form-actions box-footer">
                                                                                                                    <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i> <?php echo $this->lang->line('umb_save');?> </button>
                                                                                                                  </div>
                                                                                                                </div>
                                                                                                              </div>
                                                                                                            </div>
                                                                                                            <?php echo form_close(); ?> </div>
                                                                                                          </div>
                                                                                                        </div>
                                                                                                      </div>
                                                                                                    </div>
                                                                                                  </div>
                                                                                                </div>
