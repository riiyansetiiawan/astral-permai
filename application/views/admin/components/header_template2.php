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
<style type="text/css">
  .main-header .sidebar-toggle-hrastral-chat:before {
   content: "\f0e6";
 }
 .main-header .sidebar-toggle-hrastral-quicklinks:before {
   content: "\f00a";
 }
</style>
<header class="main-header">

  <a href="<?php echo site_url('admin/dashboard/');?>" class="logo">
    <span class="logo-mini">
      <b>
        <img alt="HR ASTRAL" src="<?php echo base_url();?>uploads/logo/<?php echo $info_perusahaan[0]->logo;?>" class="brand-logo" style="width:32px;">
      </b>
    </span>
    <span class="logo-lg">
      <img alt="HR ASTRAL" src="<?php echo base_url();?>uploads/logo/<?php echo $info_perusahaan[0]->logo;?>" class="brand-logo" style="width:32px;"> 
      <b><?php echo $system[0]->application_name;?></b>
    </span>
  </a>
  <nav class="navbar navbar-static-top">
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>
    <?php if($system[0]->module_chat_box=='true'){?>
      <a href="<?php echo site_url('admin/chat');?>" class="sidebar-toggle sidebar-toggle-hrastral-chat" role="button" title="<?php echo $this->lang->line('umb_hr_chat_box');?>">
        <?php $unread_msgs = $this->Umb_model->get_single_unread_message($session['user_id']);?>
        <?php if($unread_msgs > 0) {?>
          <span class="chat-badge label label-aqua" id="msgs_count"><?php echo $unread_msgs;?></span>
        <?php } ?>
      </a>
    <?php } if($user[0]->user_role_id=='1'){?>
      <a href="javascript:void(0);" class="sidebar-toggle sidebar-toggle-hrastral-quicklinks" role="button" data-toggle="modal" data-target=".modal-hrastralapps" title="<?php echo $this->lang->line('umb_quick_links');?>">	
      </a>
    <?php } ?> 
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <?php  if(in_array('90',$role_resources_ids)) { ?>
          <?php $fcount = 0; $cuti_count = 0; $proj_count = 0; $tgs_count = 0;$pgnmmn_count = 0; $tkt_count = 0;
          if($user[0]->user_role_id=='1'){
            $cutiapp = $this->Umb_model->get_notify_applications_cuti();
            $nproject = $this->Umb_model->get_notify_projects();
            $ntugas = $this->Umb_model->get_notify_tugass();
            $npengumumans = $this->Umb_model->get_notify_pengumumans();
            $ntickets = $this->Umb_model->get_notify_tickets();
            $cuti_count = $this->Umb_model->count_notify_cuti_applications();
            $proj_count = $this->Umb_model->count_notify_projects();
            $tgs_count = $this->Umb_model->count_notify_tugass();
            $pgnmmn_count = $this->Umb_model->count_notify_pengumumans();
            $tkt_count = $this->Umb_model->count_notify_tickets();
            //$tgs_count = $this->Umb_model->count_notify_tugass();
            $fcount = $proj_count + $cuti_count + $tgs_count + $pgnmmn_count + $tkt_count;
          } else {
            $cutiapp = $this->Umb_model->get_user_applications_cuti_terakhir($session['user_id']);
            if(in_array('318',$role_resources_ids)) {
              $nproject = $this->Umb_model->get_notify_perusahaan_projects($user[0]->perusahaan_id);
              $proj_count = $this->Umb_model->count_notify_perusahaan_projects($user[0]->perusahaan_id);
            } else {
              $nproject = $this->Umb_model->get_notify_user_projects($session['user_id']);
              $proj_count = $this->Umb_model->count_notify_user_projects($session['user_id']);
            }
            if(in_array('322',$role_resources_ids)) {
              $ntugas = $this->Umb_model->get_notify_perusahaan_tugass($user[0]->perusahaan_id);
              $tgs_count = $this->Umb_model->count_notify_perusahaan_tugass($user[0]->perusahaan_id);
            } else {
              $ntugas = $this->Umb_model->get_notify_user_tugass($session['user_id']);
              $tgs_count = $this->Umb_model->count_notify_user_tugass($session['user_id']);
            }
            if(in_array('257',$role_resources_ids)) {
              $npengumumans = $this->Umb_model->get_notify_perusahaan_pengumumans($user[0]->perusahaan_id);
              $pgnmmn_count = $this->Umb_model->count_notify_perusahaan_pengumumans($user[0]->perusahaan_id);
            } else {
              $npengumumans = $this->Umb_model->get_notify_dept_pengumumans($user[0]->department_id);
              $pgnmmn_count = $this->Umb_model->count_notify_dept_pengumumans($user[0]->department_id);
            }
            if(in_array('309',$role_resources_ids)) {
              $ntickets = $this->Umb_model->get_notify_perusahaan_tickets($user[0]->perusahaan_id);
              $tkt_count = $this->Umb_model->count_notify_perusahaan_tickets($user[0]->perusahaan_id);
            } else {
              $ntickets = $this->Umb_model->get_notify_user_tickets($session['user_id']);
              $tkt_count = $this->Umb_model->count_notify_user_tickets($session['user_id']);
            }
            $cuti_count = $this->Umb_model->count_user_notify_cuti_applications($session['user_id']);
            $fcount = $proj_count + $cuti_count + $tgs_count + $pgnmmn_count + $tkt_count;
          }
          ?>
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
              <i class="fa fa-bell-o"></i>
              <span class="label label-success"><?php echo $fcount;?></span>
            </a>
            <?php if($proj_count > 0 || $cuti_count > 0 || $tgs_count > 0 || $pgnmmn_count > 0 || $tkt_count > 0){?>
              <ul class="dropdown-menu menu <?php echo $animated;?>">
                <li><ul class="menu" style="max-height: 245px;"><li>
                  <?php if($cuti_count > 0){?>
                    <ul class="menu">
                      <li class="header">
                        <a href="javascript:void(0);"><?php echo $this->lang->line('umb_cuti_notifications');?></a>
                      </li>
                      <?php foreach($cutiapp as $cuti_notify){?>
                        <?php $karyawan_info = $this->Umb_model->read_user_info($cuti_notify->karyawan_id);?>
                        <?php
                        if(!is_null($karyawan_info)){
                          $nama_krywn = $karyawan_info[0]->first_name. ' '.$karyawan_info[0]->last_name;
                        } else {
                          $nama_krywn = '--';	
                        }
                        ?>
                        <li>
                          <a href="<?php echo site_url('admin/timesheet/details_cuti/id')?>/<?php echo $cuti_notify->cuti_id;?>/">
                            <div class="pull-left">
                              <?php if($user[0]->profile_picture!='' && $user[0]->profile_picture!='no file') {?>
                                <img src="<?php  echo base_url().'uploads/profile/'.$user[0]->profile_picture;?>" alt="" id="user_avatar" 
                                class="img-circle user_profile_avatar">
                              <?php } else {?>
                                <?php  if($user[0]->jenis_kelamin=='Pria') { ?>
                                  <?php 	$de_file = base_url().'uploads/profile/default_male.jpg';?>
                                <?php } else { ?>
                                  <?php 	$de_file = base_url().'uploads/profile/default_female.jpg';?>
                                <?php } ?>
                                <img src="<?php  echo $de_file;?>" alt="" id="user_avatar" class="img-circle user_profile_avatar">
                              <?php  } ?>
                            </div>
                            <h4>
                              <?php echo $nama_krywn;?>
                              <small>
                                <i class="fa fa-calendar"></i> 
                                <?php echo $this->Umb_model->set_date_format($cuti_notify->applied_on);?>
                              </small>
                            </h4>
                            <p><?php echo $this->lang->line('header_has_applied_for_cuti');?></p>
                          </a>
                        </li>
                      <?php } ?>
                    </ul>
                  <?php } ?>
                  <?php if($proj_count > 0){?>
                    <ul class="menu">
                      <li class="header">
                        <a href="javascript:void(0);"><?php echo $this->lang->line('umb_projects_notifications');?></a>
                      </li>
                      <?php foreach($nproject as $nprj) {?>
                        <li>
                          <a href="<?php echo site_url('admin/project/detail')?>/<?php echo $nprj->project_id;?>/">
                            <div class="pull-left">
                              <i class="fa fa-fw fa-tasks text-green"></i>
                            </div>
                            <h4>
                              <?php echo $nprj->title;?>
                              <small>
                                <i class="fa fa-calendar"></i> 
                                <?php echo $this->Umb_model->set_date_format($nprj->end_date);?>
                              </small>
                            </h4>
                          </a>
                        </li>
                      <?php } ?>
                    </ul>
                  <?php } ?>
                  <?php if($tgs_count > 0){?>
                    <ul class="menu">
                      <li class="header">
                        <a href="javascript:void(0);"><?php echo $this->lang->line('umb_notifikasi_tugass');?></a>
                      </li>
                      <?php foreach($ntugas as $ntgs) {?>
                        <li>
                          <a href="<?php echo site_url('admin/timesheet/details_tugas')?>/id/<?php echo $ntgs->tugas_id;?>/">
                            <div class="pull-left">
                              <i class="fa fa-fw fa-bullhorn text-aqua"></i>
                            </div>
                            <h4>
                              <?php echo $ntgs->nama_tugas;?>
                              <small>
                                <i class="fa fa-calendar"></i> 
                                <?php echo $this->Umb_model->set_date_format($ntgs->end_date);?>
                              </small>
                            </h4>
                          </a>
                        </li>
                      <?php } ?>
                    </ul>
                  <?php } ?>
                  <?php if($pgnmmn_count > 0){?>
                    <ul class="menu">
                      <li class="header">
                        <a href="javascript:void(0);"><?php echo $this->lang->line('dashboard_pengumumans');?></a>
                      </li>
                      <?php foreach($npengumumans as $n_pngmn) {?>
                        <li>
                          <a href="<?php echo site_url('admin/pengumuman')?>/?is_notify=1">
                            <div class="pull-left">
                              <i class="fa fa-warning text-yellow"></i>
                            </div>
                            <h4>
                              <?php echo $n_pngmn->title;?>
                              <small>
                                <i class="fa fa-calendar"></i> 
                                <?php echo $this->Umb_model->set_date_format($n_pngmn->start_date);?>
                              </small>
                            </h4>
                          </a>
                        </li>
                      <?php } ?>
                    </ul>
                  <?php } ?>
                  <?php if($tkt_count > 0){?>
                    <ul class="menu">
                      <li class="header">
                        <a href="javascript:void(0);"><?php echo $this->lang->line('left_tickets');?></a>
                      </li>
                      <?php foreach($ntickets as $n_ticket) {?>
                        <li>
                          <a href="<?php echo site_url('admin/tickets/details')?>/<?php echo $n_ticket->ticket_id;?>">
                            <div class="pull-left">
                              <i class="fa fa-ticket text-red"></i>
                            </div>
                            <h4>
                              <?php echo $n_ticket->subject;?>
                              <small>
                                <i class="fa fa-codepen"></i> 
                                <?php echo $n_ticket->kode_ticket;?>
                              </small>
                            </h4>
                          </a>
                        </li>
                      <?php } ?>
                    </ul>
                  <?php } ?>
                </li>
              </ul>
            </li>
          </ul>
        <?php } ?>
      </li> 
    <?php } ?>
    <?php  if(in_array('61',$role_resources_ids) || in_array('93',$role_resources_ids) || in_array('63',$role_resources_ids) || in_array('92',$role_resources_ids) || in_array('62',$role_resources_ids) || in_array('94',$role_resources_ids) || in_array('96',$role_resources_ids) || in_array('60',$role_resources_ids) || $user[0]->user_role_id==1 || $system[0]->module_recruitment=='true' || $system[0]->enable_pekerjaan_application_kandidats=='1' || in_array('50',$role_resources_ids) || in_array('393',$role_resources_ids)) { ?>
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="true">
          <i class="fa fa-qrcode"></i>
        </a>
        <ul class="dropdown-menu <?php echo $animated;?>">
          <?php if($system[0]->module_recruitment=='true'){?>
            <?php if($system[0]->enable_pekerjaan_application_kandidats=='1'){?>
              <?php  if(in_array('50',$role_resources_ids)) { ?>
                <li role="presentation">
                  <a role="menuitem" tabindex="-1" target="_blank" href="<?php echo site_url();?>frontend/pekerjaans/">
                    <i class="fa fa-newspaper-o"></i>
                    <?php echo $this->lang->line('header_frontend_apply_pekerjaans');?>
                  </a>
                </li>
              <?php  } ?>
            <?php  } ?>
          <?php  } ?>
          <?php  if(in_array('61',$role_resources_ids)) { ?>
            <li role="presentation">
              <a role="menuitem" tabindex="-1" href="<?php echo site_url('admin/settings/constants');?>"> 
                <i class="fa fa-align-justify"></i>
                <?php echo $this->lang->line('left_constants');?>
              </a>
            </li>
          <?php } ?>
          <?php  if(in_array('393',$role_resources_ids)) { ?>
            <li role="presentation">
              <a role="menuitem" tabindex="-1" href="<?php echo site_url('admin/custom_fields');?>"> 
                <i class="fa fa-sliders"></i>
                <?php echo $this->lang->line('umb_hrastral_custom_fields');?>
              </a>
            </li>
          <?php } ?>
          <?php  if($user[0]->user_role_id==1) { ?>
            <li role="presentation">
              <a role="menuitem" tabindex="-1" href="<?php echo site_url('admin/roles');?>"> 
                <i class="fa fa-unlock-alt"></i>
                <?php echo $this->lang->line('umb_role_urole');?>
              </a>
            </li>
          <?php } ?>
          <?php  if(in_array('93',$role_resources_ids)) { ?>
            <li role="presentation">
              <a role="menuitem" tabindex="-1" href="<?php echo site_url('admin/settings/modules');?>"> 
                <i class="fa fa-life-ring"></i>
                <?php echo $this->lang->line('umb_setup_modules');?>
              </a>
            </li>
          <?php } ?>
          <?php  if(in_array('63',$role_resources_ids)) { ?>
            <li role="presentation">
              <a role="menuitem" tabindex="-1" href="<?phpecho site_url('admin/settings/email_template');?>"> 
                <i class="fa fa-envelope"></i>
                <?php echo $this->lang->line('left_email_templates');?>
              </a>
            </li>
          <?php } ?>
          <?php  if(in_array('92',$role_resources_ids)) { ?>
            <li role="presentation">
              <a role="menuitem" tabindex="-1" href="<?php echo site_url('admin/karyawans/import');?>"> 
                <i class="fa fa-users"></i>
                <?php echo $this->lang->line('umb_import_karyawans');?>
              </a>
            </li>
          <?php } ?>
          <?php  if(in_array('62',$role_resources_ids)) { ?>
            <li role="presentation">
              <a role="menuitem" tabindex="-1" href="<?php echo site_url('admin/settings/database_backup');?>"> 
                <i class="fa fa-database"></i>
                <?php echo $this->lang->line('header_db_log');?>
              </a>
            </li>
          <?php } ?>
          <?php  if(in_array('94',$role_resources_ids)) { ?>
            <li role="presentation">
              <a role="menuitem" tabindex="-1" href="<?php echo site_url('admin/theme');?>"> 
                <i class="fa fa-columns"></i>
                <?php echo $this->lang->line('umb_theme_settings');?>
              </a>
            </li>
          <?php } ?>
          <?php if($system[0]->module_orgchart=='true'){?>
           <?php if(in_array('96',$role_resources_ids)) { ?>
            <li role="presentation">
              <a role="menuitem" tabindex="-1" href="<?php echo site_url('admin/organization/chart');?>"> 
                <i class="fa fa-sitemap"></i>
                <?php echo $this->lang->line('umb_title_org_chart');?>
              </a>
            </li>
          <?php } ?>
        <?php } ?>
        <?php if(in_array('60',$role_resources_ids)) { ?>
          <li class="divider"></li>
          <li role="presentation">
            <a role="menuitem" tabindex="-1" href="<?php echo site_url('admin/settings');?>"> 
              <i class="fa fa-cog text-aqua"></i>
              <?php echo $this->lang->line('header_configuration');?>
            </a>
          </li>
        <?php } ?>
      </ul>
    </li>
  <?php } ?>  
  <?php if($system[0]->module_language=='true'){?>
    <li class="dropdown">
      <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="true">
        <?php echo $flg_icn;?>
      </a>
      <ul class="dropdown-menu <?php echo $animated;?>">
        <?php $languages = $this->Umb_model->all_languages();?>
        <?php foreach($languages as $lang):?>
          <?php $flag = '<img src="'.base_url().'uploads/languages_flag/'.$lang->language_flag.'">';?>
          <li role="presentation">
            <a role="menuitem" tabindex="-1" href="<?php echo site_url('admin/dashboard/set_language/').$lang->language_code;?>"><?php echo $flag;?> &nbsp; <?php echo $lang->language_name;?></a>
          </li>
        <?php endforeach;?>
        <?php if($system[0]->module_language=='true'){?>
         <?php  if(in_array('89',$role_resources_ids)) { ?>
          <li class="divider"></li>
          <li role="presentation">
            <a role="menuitem" tabindex="-1" href="<?php echo site_url('admin/languages');?>"> 
              <i class="fa fa-cog text-aqua"></i>
              <?php echo $this->lang->line('left_settings');?>
            </a>
          </li>
        <?php } ?>
      <?php } ?>
    </ul>
  </li>
<?php } ?>
<li class="dropdown user user-menu">
  <?php  if($user[0]->profile_picture!='' && $user[0]->profile_picture!='no file') {?>
    <?php $cpimg = base_url().'uploads/profile/'.$user[0]->profile_picture;?>
    <?php $cimg = '<img src="'.$cpimg.'" alt="" id="user_avatar" class="img-circle rounded-circle user_profile_avatar">';?>
  <?php } else {?>
    <?php  if($user[0]->jenis_kelamin=='Pria') { ?>
      <?php 	$de_file = base_url().'uploads/profile/default_male.jpg';?>
    <?php } else { ?>
      <?php 	$de_file = base_url().'uploads/profile/default_female.jpg';?>
    <?php } ?>
    <?php $cpimg = $de_file;?>
    <?php $cimg = '<img src="'.$de_file.'" alt="" id="user_avatar" class="img-circle rounded-circle user_profile_avatar">';?>
  <?php  } ?>
  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
    <i class="glyphicon glyphicon-user"></i>
  </a>
  <ul class="dropdown-menu <?php echo $animated;?>">
    <li class="user-header">
      <?php echo $cimg;?>
      <p>
        <?php echo $user[0]->first_name.' '.$user[0]->last_name;?>
        <small><?php echo $this->lang->line('umb_krywn_member_since');?> <?php echo date('M. Y',strtotime($user[0]->tanggal_bergabung));?></small>
      </p>
    </li>
    <li class="user-body">
      <div class="row">
        <div class="col-xs-5 text-center">
          <a href="<?php echo site_url('admin/auth/lock')?>"><?php echo $this->lang->line('umb_lock_user');?></a>
        </div>
        <div class="col-xs-3 text-center">
          <a data-toggle="modal" data-target=".kebijakan" href="#">
            <i class="fa fa-flag-o"></i>
          </a>
        </div>
        <div class="col-xs-4 text-center">
          <a href="<?php echo site_url('admin/profile?change_password=true')?>"><?php echo $this->lang->line('umb_password_karyawan');?></a>
        </div>
      </div>
    </li>
    <li class="user-footer">
      <div class="pull-left">
        <a href="<?php echo site_url('admin/profile');?>" class="btn btn-default btn-flat"><?php echo $this->lang->line('header_my_profile');?></a>
      </div>
      <div class="pull-right">
        <a href="<?php echo site_url('admin/logout');?>" class="btn btn-default btn-flat text-red"><?php echo $this->lang->line('header_sign_out');?></a>
      </div>
    </li>
  </ul>
</li>
<li>
  <a href="#" data-toggle="control-sidebar">
    <i class="fa fa-gear fa-spin"></i>
  </a>
</li>
</ul>
</div>
</nav>
</header>
