<?php
$session = $this->session->userdata('username');
$system = $this->Umb_model->read_setting_info(1);
$info_perusahaan = $this->Umb_model->read_info_setting_perusahaan(1);
$user = $this->Umb_model->read_info_karyawan($session['user_id']);
$theme = $this->Umb_model->read_theme_info(1);
?>
<?php $site_lang = $this->load->helper('language');?>
<?php $wz_lang = $site_lang->session->userdata('site_lang');?>
<?php
if(!empty($wz_lang)):
	$lang_code = $this->Umb_model->get_info_language($wz_lang);
	$flg_icn = $lang_code[0]->language_flag;
	$flg_icn = '<img src="'.base_url().'uploads/languages_flag/'.$flg_icn.'">';
elseif($system[0]->default_language!=''):
	$lang_code = $this->Umb_model->get_info_language($system[0]->default_language);
	$flg_icn = $lang_code[0]->language_flag;
	$flg_icn = '<img src="'.base_url().'uploads/languages_flag/'.$flg_icn.'">';
else:
	$flg_icn = '<img src="'.base_url().'uploads/languages_flag/gb.gif">';	
endif;
?>
<?php
$role_user = $this->Umb_model->read_user_role_info($user[0]->user_role_id);
if(!is_null($role_user)){
	$role_resources_ids = explode(',',$role_user[0]->role_resources);
} else {
	$role_resources_ids = explode(',',0);	
}
//$info_penunjukan = $this->Umb_model->read_info_penunjukan($user_info[0]->penunjukan_id);
if($theme[0]->is_semi_dark==1):
	$light_cls = 'navbar-semi-dark navbar-shadow';
	$ext_clr = '';
else:
	$light_cls = 'navbar-dark';
	$ext_clr = $theme[0]->top_nav_dark_color;
endif;
if($theme[0]->boxed_layout=='true'){
	$lay_fixed = 'container boxed-layout';
} else {
	$lay_fixed = '';
}
if($theme[0]->animation_style == '') {
	$animated = 'animated flipInY';
} else {
	$animated = 'animated '.$theme[0]->animation_style;
}
?>

<nav class="layout-navbar navbar navbar-expand-lg align-items-lg-center bg-white container-p-x" id="layout-navbar"> 
  <a href="<?php echo site_url('admin/dashboard');?>" class="navbar-brand app-brand demo d-lg-none py-0 mr-4"> 
    <span class="app-brand-logo demo bg-primary"> 
      <img alt="<?php echo $system[0]->application_name;?>" src="<?php echo base_url();?>uploads/logo/<?php echo $info_perusahaan[0]->logo;?>" class="brand-logo" style="width:32px;"> 
    </span> 
    <span class="app-brand-text demo font-weight-normal ml-2"><?php echo $system[0]->application_name;?></span> 
  </a> 
  <div class="layout-sidenav-toggle navbar-nav d-lg-none align-items-lg-center mr-auto"> 
    <a class="nav-item nav-link px-0 mr-lg-4" href="javascript:void(0)"> 
      <i class="ion ion-md-menu text-large align-middle"></i> 
    </a> 
  </div>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#layout-navbar-collapse"> 
    <span class="navbar-toggler-icon"></span> 
  </button>
  <div class="navbar-collapse collapse" id="layout-navbar-collapse"> 
    <hr class="d-lg-none w-100 my-2">
    <?php  if(in_array('446',$role_resources_ids)) { ?>
      <div class="navbar-nav align-items-lg-center"> 
        <a class="nav-link" href="<?php echo site_url('admin/chat')?>">
          <i class="ion ion-md-chatbubbles"></i> &nbsp; <?php echo $this->lang->line('umb_hr_chat_box');?>
        </a> 
      </div>
    <?php } ?>
    <div class="navbar-nav align-items-lg-center ml-auto">
      <?php if($system[0]->module_language=='true'){?>
        <div class="demo-navbar-user nav-item dropdown" id="navbar-example-1"> 
          <a class="nav-link dropdown-toggle" href="#" data-trigger="hover" data-toggle="dropdown"> 
            <span class="d-inline-flex flex-lg-row-reverse align-items-center align-middle"> <?php echo $flg_icn;?> </span> 
            <span class="d-lg-none align-middle"> &nbsp; <?php echo $this->lang->line('umb_languages');?></span> 
          </a>
          <div class="dropdown-menu dropdown-menu-right">
            <?php $languages = $this->Umb_model->all_languages();?>
            <?php foreach($languages as $lang):?>
              <?php $flag = '<img src="'.base_url().'uploads/languages_flag/'.$lang->language_flag.'">';?>
              <a href="<?php echo site_url('admin/dashboard/set_language/').$lang->language_code;?>" class="dropdown-item"> 
                <i class="flag-icon"><?php echo $flag;?></i> &nbsp; <?php echo $lang->language_name;?>
              </a>
            <?php endforeach;?>
            <?php if($system[0]->module_language=='true'){?>
              <?php  if(in_array('89',$role_resources_ids)) { ?>
                <div class="dropdown-divider"></div>
                <a href="<?php echo site_url('admin/languages')?>" class="dropdown-item">
                  <i class="fa fa-cog text-primary"></i> &nbsp; 
                  <?php echo $this->lang->line('left_settings');?>
                </a>
              <?php } ?>
            <?php } ?>
          </div>
        </div>
      <?php } ?>
      <?php $hr_top_menu = explode(',',$system[0]->hr_top_menu);?>
      <?php $cn_menu = count($hr_top_menu);?>
      <?php if($cn_menu > 11):?>
        <?php else:?>
          <?php if(in_array('24',$role_resources_ids) || in_array('25',$role_resources_ids) || in_array('26',$role_resources_ids) || in_array('43',$role_resources_ids) || in_array('54',$role_resources_ids) || in_array('55',$role_resources_ids) || in_array('56',$role_resources_ids) || in_array('8',$role_resources_ids) || in_array('92',$role_resources_ids) || in_array('60',$role_resources_ids) || in_array('96',$role_resources_ids) || in_array('98',$role_resources_ids) || in_array('3',$role_resources_ids) || in_array('99',$role_resources_ids) || in_array('393',$role_resources_ids) || in_array('80',$role_resources_ids) || in_array('81',$role_resources_ids) || in_array('110',$role_resources_ids) || in_array('111',$role_resources_ids) || in_array('112',$role_resources_ids) || in_array('113',$role_resources_ids) || in_array('114',$role_resources_ids) || in_array('115',$role_resources_ids) || in_array('116',$role_resources_ids) || in_array('117',$role_resources_ids) || in_array('409',$role_resources_ids) || in_array('83',$role_resources_ids) || in_array('84',$role_resources_ids) || in_array('85',$role_resources_ids) || in_array('86',$role_resources_ids) || $user[0]->user_role_id==1) { ?>
            <div class="demo-navbar-user nav-item dropdown" id="navbar-example-1"> 
              <a class="nav-link dropdown-toggle" href="#" data-trigger="hover" data-toggle="dropdown"> 
                <span class="d-inline-flex flex-lg-row-reverse align-items-center align-middle"> 
                  <i class="ion ion-md-settings"></i> 
                </span> 
                <span class="d-lg-none align-middle"> &nbsp; <?php echo $this->lang->line('header_configuration');?></span> 
              </a>
              <div class="dropdown-menu dropdown-menu-right">
                <?php if($system[0]->module_assets=='true'){?>
                 <?php if(!in_array('assets',$hr_top_menu)):?>
                   <?php if(in_array('24',$role_resources_ids) && in_array('25',$role_resources_ids) && in_array('26',$role_resources_ids)) {?>
                    <a class="dropdown-item" href="<?php echo site_url('admin/assets');?>">
                      <i class="ion ion-md-today text-lightest"></i> &nbsp; <?php echo $this->lang->line('umb_assets');?>
                    </a>
                  <?php } ?>
                <?php endif;?>
                <?php if(!in_array('kategori_assets',$hr_top_menu)):?>
                  <?php if(!in_array('25',$role_resources_ids) && in_array('26',$role_resources_ids)) {?>
                    <a class="dropdown-item" href="<?php echo site_url('admin/assets/kategori');?>">
                      <i class="ion ion-md-today text-lightest"></i> &nbsp; 
                      <?php echo $this->lang->line('umb_kategori_assets');?>
                    </a>
                  <?php } ?>
                <?php endif;?>
                <?php if(!in_array('assets',$hr_top_menu)):?>
                  <?php if(in_array('25',$role_resources_ids) && !in_array('26',$role_resources_ids)) {?>
                    <a class="dropdown-item" href="<?php echo site_url('admin/assets/');?>">
                      <i class="ion ion-md-today text-lightest"></i> &nbsp; 
                      <?php echo $this->lang->line('umb_assets');?>
                    </a>
                  <?php } ?>
                <?php endif;?>
              <?php } ?>
              <?php if($system[0]->module_inquiry=='true'){?>
                <?php if(!in_array('tickets',$hr_top_menu)):?>
                  <?php if(in_array('43',$role_resources_ids)) { ?>
                    <a class="dropdown-item" href="<?php echo site_url('admin/tickets');?>">
                      <i class="fab fa-critical-role text-lightest"></i> &nbsp; 
                      <?php echo $this->lang->line('left_tickets');?>
                    </a>
                  <?php } ?>
                <?php endif;?>
              <?php } ?>
              <?php if($system[0]->module_training=='true'){?>
                <?php if(!in_array('training',$hr_top_menu)):?>
                  <?php  if(in_array('54',$role_resources_ids) && in_array('55',$role_resources_ids) && in_array('56',$role_resources_ids)) {?>
                    <a href="<?php echo site_url('admin/training')?>" class="dropdown-item">
                      <i class="fas fa-portrait text-lightest"></i> &nbsp; 
                      <?php echo $this->lang->line('left_training');?>
                    </a>
                  <?php } ?>
                <?php endif;?>
                <?php if(!in_array('training',$hr_top_menu)):?>
                  <?php  if(in_array('54',$role_resources_ids) && !in_array('55',$role_resources_ids) && !in_array('56',$role_resources_ids)) {?>
                    <a href="<?php echo site_url('admin/training')?>" class="dropdown-item">
                      <i class="fas fa-portrait text-lightest"></i> &nbsp; 
                      <?php echo $this->lang->line('left_training');?>
                    </a>
                  <?php } ?>
                <?php endif;?>
                <?php if(!in_array('training',$hr_top_menu)):?>
                  <?php  if(in_array('54',$role_resources_ids) && in_array('55',$role_resources_ids) && !in_array('56',$role_resources_ids)) {?>
                    <a href="<?php echo site_url('admin/training')?>" class="dropdown-item">
                      <i class="fas fa-portrait text-lightest"></i> &nbsp; 
                      <?php echo $this->lang->line('left_training');?>
                    </a>
                  <?php } ?>
                <?php endif;?>
                <?php if(!in_array('training',$hr_top_menu)):?>
                  <?php  if(in_array('54',$role_resources_ids) && !in_array('55',$role_resources_ids) && in_array('56',$role_resources_ids)) {?>
                    <a href="<?php echo site_url('admin/training')?>" class="dropdown-item">
                      <i class="fas fa-portrait text-lightest"></i> &nbsp; 
                      <?php echo $this->lang->line('left_training');?>
                    </a>
                  <?php } ?>
                <?php endif;?>
                <?php if(!in_array('trainers_list',$hr_top_menu)):?>
                  <?php  if(!in_array('54',$role_resources_ids) && in_array('56',$role_resources_ids) && in_array('55',$role_resources_ids)) {?>
                    <a href="<?php echo site_url('admin/trainers')?>" class="dropdown-item">
                      <i class="fas fa-portrait text-lightest"></i> &nbsp; 
                      <?php echo $this->lang->line('left_list_trainers');?>
                    </a>
                  <?php } ?>
                <?php endif;?>
                <?php if(!in_array('trainers_list',$hr_top_menu)):?>
                  <?php  if(!in_array('54',$role_resources_ids) && in_array('56',$role_resources_ids) && !in_array('55',$role_resources_ids)) {?>
                    <a href="<?php echo site_url('admin/trainers')?>" class="dropdown-item">
                      <i class="fas fa-portrait text-lightest"></i> &nbsp; 
                      <?php echo $this->lang->line('left_list_trainers');?>
                    </a>
                  <?php } ?>
                <?php endif;?>
                <?php if(!in_array('type_training',$hr_top_menu)):?>
                  <?php  if(!in_array('54',$role_resources_ids) && !in_array('56',$role_resources_ids) && in_array('55',$role_resources_ids)) {?>
                    <a href="<?php echo site_url('admin/type_training')?>" class="dropdown-item">
                      <i class="fas fa-portrait text-lightest"></i> &nbsp; 
                      <?php echo $this->lang->line('left_type_training');?>
                    </a>
                  <?php } ?>
                <?php endif;?>
              <?php } ?>
              <?php if(!in_array('libur',$hr_top_menu)):?>
                <?php if(in_array('8',$role_resources_ids)) { ?>
                  <a class="dropdown-item" href="<?php echo site_url('admin/timesheet/liburan');?>">
                    <i class="ion ion-ios-paper-plane text-lightest"></i> &nbsp; 
                    <?php echo $this->lang->line('left_liburan');?>
                  </a>
                <?php } ?>
              <?php endif;?>
              <?php if(!in_array('hr_import',$hr_top_menu)):?>
                <?php  if(in_array('92',$role_resources_ids) || in_array('443',$role_resources_ids) || in_array('444',$role_resources_ids)) { ?>
                  <a class="dropdown-item" href="<?php echo site_url('admin/import');?>">
                    <i class="fas fa-file-upload text-lightest"></i> &nbsp; 
                    <?php echo $this->lang->line('umb_hr_imports');?>
                  </a>
                <?php } ?>
              <?php endif;?>
              <?php if(!in_array('hr_report',$hr_top_menu)):?>
                <?php  if(in_array('110',$role_resources_ids) || in_array('111',$role_resources_ids) || in_array('112',$role_resources_ids) || in_array('113',$role_resources_ids) || in_array('114',$role_resources_ids) || in_array('115',$role_resources_ids) || in_array('116',$role_resources_ids) || in_array('117',$role_resources_ids) || in_array('409',$role_resources_ids) || in_array('83',$role_resources_ids) || in_array('84',$role_resources_ids) || in_array('85',$role_resources_ids) || in_array('86',$role_resources_ids)) { ?>
                  <a href="<?php echo site_url('admin/laporans')?>" class="dropdown-item">
                    <i class="fas fa-chart-bar text-lightest"></i> &nbsp; <?php echo $this->lang->line('umb_hr_title_laporan');?>
                  </a>
                <?php } ?>
              <?php endif;?>
              <?php if(!in_array('custom_fields',$hr_top_menu)):?>
                <?php  if(in_array('393',$role_resources_ids)) { ?>
                  <a class="dropdown-item" href="<?php echo site_url('admin/custom_fields');?>">
                    <i class="fas fa-sliders-h text-lightest"></i> &nbsp; 
                    <?php echo $this->lang->line('umb_hrastral_custom_fields');?>
                  </a>
                <?php } ?>
              <?php endif;?>
              <?php if(!in_array('hr_penerima_pembayarans_pembayars',$hr_top_menu)):?>
                <?php  if(in_array('80',$role_resources_ids) && in_array('81',$role_resources_ids)) {?>
                  <a href="<?php echo site_url('admin/accounting/penerima_pembayarans')?>" class="dropdown-item">
                    <i class="ion ion-md-contacts text-lightest"></i> &nbsp; 
                    <?php echo $this->lang->line('umb_hr_penerima_pembayarans_pembayars');?>
                  </a>
                <?php } ?>
              <?php endif;?>
              <?php if(!in_array('acc_penerima_pembayarans',$hr_top_menu)):?>
                <?php  if(in_array('80',$role_resources_ids) && !in_array('81',$role_resources_ids)) {?>
                  <a href="<?php echo site_url('admin/accounting/penerima_pembayarans')?>" class="dropdown-item">
                    <i class="ion ion-md-contacts text-lightest"></i> &nbsp; 
                    <?php echo $this->lang->line('umb_acc_penerima_pembayarans');?>
                  </a>
                <?php } ?>
              <?php endif;?>
              <?php if(!in_array('acc_pembayars',$hr_top_menu)):?>
                <?php  if(!in_array('80',$role_resources_ids) && in_array('81',$role_resources_ids)) {?>
                  <a href="<?php echo site_url('admin/accounting/pembayars')?>" class="dropdown-item">
                    <i class="ion ion-md-contacts text-lightest"></i> &nbsp; 
                    <?php echo $this->lang->line('umb_acc_pembayars');?>
                  </a>
                <?php } ?>
              <?php endif;?>
              <?php if($system[0]->is_active_sub_departments=='yes'){?>
               <?php if(!in_array('sub_department',$hr_top_menu)):?>
                <?php  if(in_array('3',$role_resources_ids)) { ?>
                  <a href="<?php echo site_url('admin/department/sub_departments')?>" class="dropdown-item">
                    <i class="far fa-building text-lightest"></i> &nbsp; 
                    <?php echo $this->lang->line('umb_hr_sub_departments');?>
                  </a>
                <?php } ?>
              <?php endif;?>
            <?php } ?>
            <?php if($system[0]->module_events=='true'){?>
              <?php if(!in_array('events_meetings',$hr_top_menu)):?>
                <?php  if(in_array('98',$role_resources_ids) && in_array('99',$role_resources_ids)) {?>
                  <a href="<?php echo site_url('admin/events')?>" class="dropdown-item">
                    <i class="fas fa-calendar-alt text-lightest"></i> &nbsp; 
                    <?php echo $this->lang->line('umb_hr_events_meetings');?>
                  </a>
                <?php } ?>
              <?php endif;?>
              <?php if(!in_array('events',$hr_top_menu)):?>
                <?php  if(in_array('98',$role_resources_ids) && !in_array('99',$role_resources_ids)) {?>
                  <a href="<?php echo site_url('admin/events')?>" class="dropdown-item">
                    <i class="fas fa-calendar-alt text-lightest"></i> &nbsp; 
                    <?php echo $this->lang->line('umb_hr_events');?>
                  </a>
                <?php } ?>
              <?php endif;?>
              <?php if(!in_array('meetings',$hr_top_menu)):?>
                <?php  if(!in_array('98',$role_resources_ids) && in_array('99',$role_resources_ids)) {?>
                  <a href="<?php echo site_url('admin/meetings')?>" class="dropdown-item">
                    <i class="fas fa-calendar-alt text-lightest"></i> &nbsp; 
                    <?php echo $this->lang->line('umb_hr_meetings');?>
                  </a>
                <?php } ?>
              <?php endif;?>
            <?php } ?>
            <?php if($system[0]->module_orgchart=='true'){?>
             <?php if(!in_array('orgchart',$hr_top_menu)):?>
              <?php  if(in_array('96',$role_resources_ids)) { ?>
               <a href="<?php echo site_url('admin/organization/chart')?>" class="dropdown-item">
                <i class="ion ion-ios-map text-lightest"></i> &nbsp; 
                <?php echo $this->lang->line('umb_title_org_chart');?>
              </a>
            <?php } ?>
          <?php endif;?>
        <?php } ?>
        <?php if(!in_array('settings',$hr_top_menu)):?>
          <?php  if(in_array('60',$role_resources_ids)) { ?>
            <div class="dropdown-divider"></div>
            <a href="<?php echo site_url('admin/settings')?>" class="dropdown-item">
              <i class="fas fa-cog text-primary"></i> &nbsp; 
              <?php echo $this->lang->line('header_configuration');?>
            </a>
          <?php } ?>
        <?php endif;?>
      </div>
    </div>
  <?php } ?>
<?php endif;?>
<?php  //if(in_array('90',$role_resources_ids)) { ?>
  <?php
  $fcount = 0; $proj_count = 0; $cuti_count = 0; $tgs_count = 0;
  $pgnmmn_count = 0; $tkt_count = 0; $asset_count = 0; $award_count = 0;
  if(in_array('46',$role_resources_ids)) {
    $cuti_count = $this->Umb_model->hrastral_notifications_count('leave',$session['user_id']);
  }
  if(in_array('44',$role_resources_ids)) {
    $proj_count = $this->Umb_model->hrastral_notifications_count('projects',$session['user_id']);
  }
  if(in_array('45',$role_resources_ids)) {
    $tgs_count = $this->Umb_model->hrastral_notifications_count('tugass',$session['user_id']);
  }
  if(in_array('11',$role_resources_ids)) {
    $pgnmmn_count = $this->Umb_model->hrastral_notifications_count('pengumuman',$session['user_id']);
  }
  if($system[0]->module_inquiry=='true'){
    if(in_array('43',$role_resources_ids)) {
      $tkt_count = $this->Umb_model->hrastral_notifications_count('tickets',$session['user_id']);
    }
  }
  if(in_array('25',$role_resources_ids)) {
    $asset_count = $this->Umb_model->hrastral_notifications_count('asset',$session['user_id']);
  }
  if(in_array('14',$role_resources_ids)) {
    $award_count = $this->Umb_model->hrastral_notifications_count('awards',$session['user_id']);
  }
	// count);
  $fcount = $proj_count + $cuti_count + $tgs_count + $pgnmmn_count + $tkt_count + $asset_count + $award_count;
  ?>
  <div class="demo-navbar-notifications nav-item dropdown mr-lg-3" id="navbar-example-1"> 
    <a class="nav-link dropdown-toggle hide-arrow" href="<?php echo site_url('admin/dashboard/notifications/');?>"> 
      <i class="ion ion-md-notifications-outline navbar-icon align-middle"></i> 
      <span class="d-lg-none align-middle">&nbsp; <?php echo $this->lang->line('header_notifications');?></span> 
      <span class="badge badge-primary indicator"><?php echo $fcount;?></span>
    </a>
  </div>
  <?php //} ?>
  <div class="nav-item d-none d-lg-block text-big font-weight-light line-height-1 opacity-25 mr-3 ml-1">|</div>
  <div class="demo-navbar-user nav-item dropdown" id="navbar-example-1"> 
    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" data-trigger="hover"> 
      <span class="d-inline-flex flex-lg-row-reverse align-items-center align-middle">
        <?php  if($user[0]->profile_picture!='' && $user[0]->profile_picture!='no file') {?>
          <?php $cpimg = base_url().'uploads/profile/'.$user[0]->profile_picture;?>
          <?php $cimg = '<img src="'.$cpimg.'" alt="" id="user_avatar" class="d-block ui-w-30 rounded-circle">';?>
        <?php } else {?>
          <?php  if($user[0]->jenis_kelamin=='Pria') { ?>
            <?php 	$de_file = base_url().'uploads/profile/default_male.jpg';?>
          <?php } else { ?>
            <?php 	$de_file = base_url().'uploads/profile/default_female.jpg';?>
          <?php } ?>
          <?php $cpimg = $de_file;?>
          <?php $cimg = '<img src="'.$de_file.'" alt="" id="user_avatar" class="d-block ui-w-30 rounded-circle">';?>
        <?php  } ?>
        <?php echo $cimg;?> 
        <span class="px-1 mr-lg-2 ml-2 ml-lg-0"><?php echo $user[0]->first_name.' '.$user[0]->last_name;?></span> 
      </span> 
    </a>
    <div class="dropdown-menu dropdown-menu-right">
      <?php if(in_array('445',$role_resources_ids)) { ?>
        <a class="dropdown-item" href="<?php echo site_url('admin/profile');?>"> 
          <i class="ion ion-ios-person text-lightest"></i> &nbsp; 
          <?php echo $this->lang->line('header_my_profile');?>
        </a>
      <?php } ?>
      <?php if(in_array('9',$role_resources_ids)) { ?>
        <a class="dropdown-item" href="<?php echo site_url('admin/kebijakan/view_all');?>"> 
          <i class="lnr lnr-select text-lightest"></i> &nbsp; 
          <?php echo $this->lang->line('header_kebijakans');?>
        </a>
      <?php } ?>
      <?php if(in_array('465',$role_resources_ids)) { ?>
        <a class="dropdown-item" href="<?php echo site_url('admin/auth/lock');?>"> 
          <i class="fa fa-lock text-lightest"></i> &nbsp; 
          <?php echo $this->lang->line('umb_lock_user');?>
        </a>
      <?php } ?>
      <?php if($system[0]->module_recruitment=='true'){?>
        <?php if($system[0]->enable_pekerjaan_application_kandidats=='1'){?>
          <?php  if(in_array('50',$role_resources_ids)) { ?>
            <a class="dropdown-item" target="_blank" href="<?php echo site_url('pekerjaans');?>">
              <i class="ion ion-md-paper text-lightest"></i> &nbsp; 
              <?php echo $this->lang->line('left_pekerjaans_terbaru');?> 
            </a>
          <?php  } ?>
        <?php  } ?>
      <?php  } ?>
      <div class="dropdown-divider"></div>
      <a href="<?php echo site_url('admin/logout');?>" class="dropdown-item">
        <i class="ion ion-ios-log-out text-primary"></i> &nbsp; 
        <?php echo $this->lang->line('header_sign_out');?>
      </a> 
    </div>
  </div>
</div>
</div>
</nav>
