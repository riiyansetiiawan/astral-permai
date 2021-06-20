<?php
$session = $this->session->userdata('username');
$theme = $this->Umb_model->read_theme_info(1);
if($theme[0]->right_side_icons=='true') {
	$icons_right = 'expanded menu-icon-right';
} else {
	$icons_right = '';
}
if($theme[0]->bordered_menu=='true') {
	$menu_bordered = 'menu-bordered';
} else {
	$menu_bordered = '';
}
$user_info = $this->Umb_model->read_user_info($session['user_id']);
if($user_info[0]->is_active!=1) {
	redirect('admin/');
}
$role_user = $this->Umb_model->read_user_role_info($user_info[0]->user_role_id);
if(!is_null($role_user)){
	$role_resources_ids = explode(',',$role_user[0]->role_resources);
} else {
	$role_resources_ids = explode(',',0);	
}
?>
<?php $system = $this->Umb_model->read_setting_info(1);?>
<?php $arr_mod = $this->Umb_model->select_module_class($this->router->fetch_class(),$this->router->fetch_method()); ?>
<?php 
if($theme[0]->sub_menu_icons != ''){
	$submenuicon = $theme[0]->sub_menu_icons;
} else {
	$submenuicon = 'fa-circle-o';
}
$laporans_to = get_data_laporans_team($session['user_id']);
?>
<?php  if($user_info[0]->profile_picture!='' && $user_info[0]->profile_picture!='no file') {?>
  <?php $cpimg = base_url().'uploads/profile/'.$user_info[0]->profile_picture;?>
<?php } else {?>
  <?php  if($user_info[0]->jenis_kelamin=='Pria') { ?>
    <?php 	$de_file = base_url().'uploads/profile/default_male.jpg';?>
  <?php } else { ?>
    <?php 	$de_file = base_url().'uploads/profile/default_female.jpg';?>
  <?php } ?>
  <?php $cpimg = $de_file;?>
<?php  } ?>
<ul class="sidenav-inner py-1">
  <li class="sidenav-item <?php if(!empty($arr_mod['active']))echo $arr_mod['active'];?>"> 
    <a href="<?php echo site_url('admin/dashboard');?>" class="sidenav-link"> 
      <i class="sidenav-icon ion ion-md-speedometer"></i> 
      <div><?php echo $this->lang->line('dashboard_title');?></div>
    </a> 
  </li>
  <?php if(in_array('13',$role_resources_ids) || in_array('7',$role_resources_ids) || in_array('422',$role_resources_ids) || $laporans_to>0 || $user_info[0]->user_role_id==1){?>
    <li class="<?php if(!empty($arr_mod['stff_open']))echo $arr_mod['stff_open'];?> sidenav-item"> 
      <a href="#" class="sidenav-link sidenav-toggle"> 
        <i class="sidenav-icon fas fa-user-friends"></i> 
        <div><?php echo $this->lang->line('dashboard_karyawans');?></div>
      </a>
      <ul class="sidenav-menu">
        <?php if($user_info[0]->user_role_id==1){?>
          <?php if(in_array('422',$role_resources_ids)) { ?>
            <li class="sidenav-item <?php if(!empty($arr_mod['staff_active']))echo $arr_mod['staff_active'];?>"> 
              <a class="sidenav-link" href="<?php echo site_url('admin/karyawans/dashboard_staff/');?>" > <?php echo $this->lang->line('hr_title_dashboard_staff');?> </a> 
            </li>
          <?php } ?>
        <?php } ?>
        <?php if(in_array('13',$role_resources_ids) || $laporans_to>0) { ?>
          <li class="sidenav-item <?php if(!empty($arr_mod['hrkrywn_active']))echo $arr_mod['hrkrywn_active'];?>"> 
            <a class="sidenav-link" href="<?php echo site_url('admin/karyawans/');?>" > 
              <?php echo $this->lang->line('dashboard_karyawans');?> 
            </a> 
          </li>
        <?php } ?>
        <?php if($user_info[0]->user_role_id==1){?>
          <li class="sidenav-item <?php if(!empty($arr_mod['roles_active']))echo $arr_mod['roles_active'];?>"> 
            <a class="sidenav-link" href="<?php echo site_url('admin/roles/');?>" > 
              <?php echo $this->lang->line('left_set_roles');?> 
            </a> 
          </li>
        <?php } ?>
        <?php if(in_array('7',$role_resources_ids)) { ?>
          <li class="sidenav-item <?php if(!empty($arr_mod['shift_active']))echo $arr_mod['shift_active'];?>"> 
            <a class="sidenav-link" href="<?php echo site_url('admin/timesheet/shift_kantor/');?>"> 
              <?php echo $this->lang->line('left_shifts_kantor');?> 
            </a> 
          </li>
        <?php } ?>
      </ul>
    </li>
  <?php } ?>
  <?php if($system[0]->module_payroll=='yes'){?>
    <?php if(in_array('36',$role_resources_ids) && in_array('37',$role_resources_ids)){?>
      <li class="sidenav-item <?php if(!empty($arr_mod['pay_generate_active']))echo $arr_mod['pay_generate_active'];?>"> 
        <a href="<?php echo site_url('admin/payroll/generate_slipgaji/');?>" class="sidenav-link"> 
          <i class="sidenav-icon fa fa-calculator"></i>
          <div><?php echo $this->lang->line('left_payroll');?></div>
        </a> 
      </li>
    <?php } ?>
    <?php if(in_array('36',$role_resources_ids) && !in_array('37',$role_resources_ids)){?>
      <li class="sidenav-item <?php if(!empty($arr_mod['pay_generate_active']))echo $arr_mod['pay_generate_active'];?>"> 
        <a href="<?php echo site_url('admin/payroll/generate_slipgaji/');?>" class="sidenav-link"> 
          <i class="sidenav-icon fa fa-calculator"></i>
          <div><?php echo $this->lang->line('left_payroll');?></div>
        </a> 
      </li>
    <?php } ?>
  <?php } ?>
  <?php if($system[0]->module_accounting=='true'){?>
    <?php if(in_array('286',$role_resources_ids) || in_array('72',$role_resources_ids) || in_array('75',$role_resources_ids) || in_array('76',$role_resources_ids) || in_array('77',$role_resources_ids) || in_array('78',$role_resources_ids)){?>
      <li class="<?php if(!empty($arr_mod['hr_acc_open']))echo $arr_mod['hr_acc_open'];?> sidenav-item"> 
        <a href="#" class="sidenav-link sidenav-toggle"> 
          <i class="sidenav-icon ion ion-md-cash"></i>
          <div><?php echo $this->lang->line('umb_hr_keuangan');?></div>
        </a>
        <ul class="sidenav-menu">
          <?php if(in_array('286',$role_resources_ids)) { ?>
            <li class="sidenav-item <?php if(!empty($arr_mod['dashboard_accounting_active']))echo $arr_mod['dashboard_accounting_active'];?>"> 
              <a class="sidenav-link" href="<?php echo site_url('admin/accounting/dashboard_accounting/');?>" > 
                <?php echo $this->lang->line('hr_title_dashboard_accounting');?> 
              </a> 
            </li>
          <?php } ?>
          <?php if(in_array('72',$role_resources_ids)) { ?>
            <li class="sidenav-item <?php if(!empty($arr_mod['bank_cash_act']))echo $arr_mod['bank_cash_act'];?>"> 
              <a class="sidenav-link" href="<?php echo site_url('admin/accounting/bank_cash/');?>" > 
                <?php echo $this->lang->line('umb_acc_list_account');?> 
              </a> 
            </li>
          <?php } ?>
          <?php if(in_array('75',$role_resources_ids)) { ?>
            <li class="sidenav-item <?php if(!empty($arr_mod['deposit_active']))echo $arr_mod['deposit_active'];?>"> 
              <a class="sidenav-link" href="<?php echo site_url('admin/accounting/deposit/');?>" > 
                <?php echo $this->lang->line('umb_acc_deposit');?> 
              </a> 
            </li>
          <?php } ?>
          <?php if(in_array('76',$role_resources_ids)) { ?>
            <li class="sidenav-item <?php if(!empty($arr_mod['biaya_active']))echo $arr_mod['biaya_active'];?>"> 
              <a class="sidenav-link" href="<?php echo site_url('admin/accounting/biaya/');?>" > 
                <?php echo $this->lang->line('umb_acc_biaya');?> 
              </a> 
            </li>
          <?php } ?>
          <?php if(in_array('77',$role_resources_ids)) { ?>
            <li class="sidenav-item <?php if(!empty($arr_mod['transfer_active']))echo $arr_mod['transfer_active'];?>"> 
              <a class="sidenav-link" href="<?php echo site_url('admin/accounting/transfer/');?>" > 
                <?php echo $this->lang->line('umb_acc_transfer');?> 
              </a> 
            </li>
          <?php } ?>
          <?php if(in_array('78',$role_resources_ids)) { ?>
            <li class="sidenav-item <?php if(!empty($arr_mod['transaksii_active']))echo $arr_mod['transaksii_active'];?>"> 
              <a class="sidenav-link" href="<?php echo site_url('admin/accounting/transaksii/');?>" > 
                <?php echo $this->lang->line('umb_acc_transaksii');?> 
              </a> 
            </li>
          <?php } ?>
        </ul>
      </li>
    <?php } ?>
  <?php } ?>
  <?php  if(in_array('12',$role_resources_ids) || in_array('14',$role_resources_ids) || in_array('15',$role_resources_ids) || in_array('16',$role_resources_ids) || in_array('17',$role_resources_ids) || in_array('18',$role_resources_ids) || in_array('19',$role_resources_ids) || in_array('20',$role_resources_ids) || in_array('21',$role_resources_ids) || in_array('22',$role_resources_ids) || in_array('23',$role_resources_ids)){?>
    <li class="<?php if(!empty($arr_mod['krywn_open']))echo $arr_mod['krywn_open'];?> sidenav-item"> 
      <a href="#" class="sidenav-link sidenav-toggle"> 
        <i class="sidenav-icon ion ion-ios-globe"></i>
        <div><?php echo $this->lang->line('umb_hr');?></div>
      </a>
      <ul class="sidenav-menu">
        <?php if($system[0]->module_awards=='true'){?>
          <?php if(in_array('14',$role_resources_ids)) { ?>
            <li class="sidenav-item <?php if(!empty($arr_mod['award_active']))echo $arr_mod['award_active'];?>">
              <a class="sidenav-link" href="<?php echo site_url('admin/awards');?>" > 
                <?php echo $this->lang->line('left_awards');?> 
              </a> 
            </li>
          <?php } ?>
        <?php } ?>
        <?php if(in_array('15',$role_resources_ids)) { ?>
          <li class="sidenav-item <?php if(!empty($arr_mod['tra_active']))echo $arr_mod['tra_active'];?>">
            <a class="sidenav-link" href="<?php echo site_url('admin/transfers');?>" > 
              <?php echo $this->lang->line('left_transfers');?> 
            </a> 
          </li>
        <?php } ?>
        <?php if(in_array('16',$role_resources_ids)) { ?>
          <li class="sidenav-item <?php if(!empty($arr_mod['pngndr_dr_active']))echo $arr_mod['pngndr_dr_active'];?>"> 
            <a class="sidenav-link" href="<?php echo site_url('admin/pengunduran_diri');?>" > 
              <?php echo $this->lang->line('left_pengundurans_diri');?> 
            </a> 
          </li>
        <?php } ?>
        <?php if($system[0]->module_perjalanan=='true'){?>
          <?php if(in_array('17',$role_resources_ids)) { ?>
            <li class="sidenav-item <?php if(!empty($arr_mod['prjln_active']))echo $arr_mod['prjln_active'];?>"> 
              <a class="sidenav-link" href="<?php echo site_url('admin/perjalanan');?>"> 
                <?php echo $this->lang->line('left_perjalanans');?> 
              </a> 
            </li>
          <?php } ?>
        <?php } ?>
        <?php if(in_array('18',$role_resources_ids)) { ?>
          <li class="sidenav-item <?php if(!empty($arr_mod['pro_active']))echo $arr_mod['pro_active'];?>">
            <a class="sidenav-link" href="<?php echo site_url('admin/promotion');?>"> 
              <?php echo $this->lang->line('left_promotions');?> 
            </a> 
          </li>
        <?php } ?>
        <?php if(in_array('19',$role_resources_ids)) { ?>
          <li class="sidenav-item <?php if(!empty($arr_mod['keluh_active']))echo $arr_mod['keluh_active'];?>"> 
            <a class="sidenav-link" href="<?php echo site_url('admin/keluhans');?>"> 
              <?php echo $this->lang->line('left_keluhans');?> 
            </a> 
          </li>
        <?php } ?>
        <?php if(in_array('20',$role_resources_ids)) { ?>
          <li class="sidenav-item <?php if(!empty($arr_mod['prgtn_active']))echo $arr_mod['prgtn_active'];?>"> 
            <a class="sidenav-link" href="<?php echo site_url('admin/peringatan');?>"> 
              <?php echo $this->lang->line('left_peringatans');?> 
            </a> 
          </li>
        <?php } ?>
        <?php if(in_array('21',$role_resources_ids)) { ?>
          <li class="sidenav-item <?php if(!empty($arr_mod['term_active']))echo $arr_mod['term_active'];?>"> 
            <a class="sidenav-link" href="<?php echo site_url('admin/penghentian');?>"> 
              <?php echo $this->lang->line('left_penghentians');?> 
            </a> 
          </li>
        <?php } ?>
        <?php if(in_array('23',$role_resources_ids)) { ?>
          <li class="<?php if(!empty($arr_mod['krywn_ex_active']))echo $arr_mod['krywn_ex_active'];?> sidenav-item">
            <a href="<?php echo site_url('admin/karyawan_exit');?>" class="sidenav-link"> 
              <?php echo $this->lang->line('left_karyawans_exit');?> 
            </a>
          </li>
        <?php } ?>
        <?php if(in_array('22',$role_resources_ids) || $laporans_to > 0) { ?>
          <li class="<?php if(!empty($arr_mod['krywn_ter_lgn_active']))echo $arr_mod['krywn_ter_lgn_active'];?> sidenav-item">
            <a href="<?php echo site_url('admin/karyawans_terakhir_login');?>" class="sidenav-link"> 
              <?php echo $this->lang->line('left_karyawans_terakhir_login');?>
            </a>
          </li>
        <?php } ?>
      </ul>
    </li>
  <?php } ?>
  <?php if(in_array('2',$role_resources_ids) || in_array('3',$role_resources_ids) || in_array('4',$role_resources_ids) || in_array('5',$role_resources_ids) || in_array('6',$role_resources_ids) || in_array('11',$role_resources_ids) || in_array('9',$role_resources_ids)){?>
    <li class="<?php if(!empty($arr_mod['adm_open']))echo $arr_mod['adm_open'];?> sidenav-item"> 
      <a href="#" class="sidenav-link sidenav-toggle"> 
        <i class="sidenav-icon ion ion-md-business"></i>
        <div><?php echo $this->lang->line('left_organization');?></div>
      </a>
      <ul class="sidenav-menu">
        <?php if(in_array('5',$role_resources_ids)) { ?>
          <li class="sidenav-item <?php if(!empty($arr_mod['prshn_active']))echo $arr_mod['prshn_active'];?>"> 
            <a class="sidenav-link" href="<?php echo site_url('admin/perusahaan/');?>" > 
              <?php echo $this->lang->line('umb_perusahaans');?> 
            </a> 
          </li>
        <?php } ?>
        <?php if(in_array('6',$role_resources_ids)) { ?>
          <li class="sidenav-item <?php if(!empty($arr_mod['lok_active']))echo $arr_mod['lok_active'];?>">
            <a class="sidenav-link" href="<?php echo site_url('admin/location/');?>" > 
              <?php echo $this->lang->line('umb_locations');?>
            </a> 
          </li>
        <?php } ?>
        <?php if(in_array('3',$role_resources_ids)) { ?>
          <li class="sidenav-item <?php if(!empty($arr_mod['dep_active']))echo $arr_mod['dep_active'];?>">
            <a class="sidenav-link" href="<?php echo site_url('admin/department/');?>" > 
              <?php echo $this->lang->line('left_department');?> 
            </a> 
          </li>
        <?php } ?>
        <?php if(in_array('4',$role_resources_ids)) { ?>
          <li class="sidenav-item <?php if(!empty($arr_mod['des_active']))echo $arr_mod['des_active'];?>">
            <a class="sidenav-link" href="<?php echo site_url('admin/penunjukan/');?>" > 
              <?php echo $this->lang->line('left_penunjukan');?> 
            </a> 
          </li>
        <?php } ?>
        <?php if(in_array('11',$role_resources_ids)) { ?>
          <li class="sidenav-item <?php if(!empty($arr_mod['pngmmn_active']))echo $arr_mod['pngmmn_active'];?>"> 
            <a class="sidenav-link" href="<?php echo site_url('admin/pengumuman/');?>" > 
              <?php echo $this->lang->line('left_pengumumans');?> 
            </a> 
          </li>
        <?php } ?>
        <?php if(in_array('9',$role_resources_ids)) { ?>
          <li class="sidenav-item <?php if(!empty($arr_mod['kbjk_active']))echo $arr_mod['kbjk_active'];?>">
            <a class="sidenav-link" href="<?php echo site_url('admin/kebijakan/');?>" > 
              <?php echo $this->lang->line('header_kebijakans');?> 
            </a> 
          </li>
        <?php } ?>
      </ul>
    </li>
  <?php } ?>
  <?php if(in_array('27',$role_resources_ids) || in_array('423',$role_resources_ids) || in_array('10',$role_resources_ids) || in_array('30',$role_resources_ids) || in_array('401',$role_resources_ids) || in_array('261',$role_resources_ids) || in_array('28',$role_resources_ids)){?>
    <li class="<?php if(!empty($arr_mod['attnd_open']))echo $arr_mod['attnd_open'];?> sidenav-item"> 
      <a href="#" class="sidenav-link sidenav-toggle"> 
        <i class="sidenav-icon ion ion-md-clock"></i>
        <div><?php echo $this->lang->line('left_timesheet');?></div>
      </a>
      <ul class="sidenav-menu">
        <?php if(in_array('423',$role_resources_ids)) { ?>
          <li class="sidenav-item <?php if(!empty($arr_mod['dashboard_kehadiran_active']))echo $arr_mod['dashboard_kehadiran_active'];?>"> 
            <a class="sidenav-link" href="<?php echo site_url('admin/timesheet/dashboard_kehadiran/');?>" > 
              <?php echo $this->lang->line('hr_title_dashboard_timesheet');?> 
            </a> 
          </li>
        <?php } ?>
        <?php if(in_array('28',$role_resources_ids)) { ?>
          <li class="sidenav-item <?php if(!empty($arr_mod['attnd_active']))echo $arr_mod['attnd_active'];?>"> 
            <a class="sidenav-link" href="<?php echo site_url('admin/timesheet/kehadiran/');?>" > 
              <?php echo $this->lang->line('left_kehadiran');?> 
            </a> 
          </li>
        <?php } ?>
        <?php if(in_array('30',$role_resources_ids)) { ?>
          <li class="sidenav-item <?php if(!empty($arr_mod['upd_attnd_active']))echo $arr_mod['upd_attnd_active'];?>"> 
            <a class="sidenav-link" href="<?php echo site_url('admin/timesheet/update_kehadiran/');?>" > 
              <?php echo $this->lang->line('left_update_kehadiran');?> 
            </a> 
          </li>
        <?php } ?>
        <?php if(in_array('10',$role_resources_ids)) { ?>
          <li class="sidenav-item <?php if(!empty($arr_mod['timesheet_active']))echo $arr_mod['timesheet_active'];?>"> 
            <a class="sidenav-link" href="<?php echo site_url('admin/timesheet/');?>" > 
              <?php echo $this->lang->line('umb_month_timesheet_title');?> 
            </a> 
          </li>
        <?php } ?>
        <?php if(in_array('261',$role_resources_ids)) { ?>
          <li class="sidenav-item <?php if(!empty($arr_mod['timecalendar_active']))echo $arr_mod['timecalendar_active'];?>">
            <a class="sidenav-link" href="<?php echo site_url('admin/timesheet/timecalendar/');?>" > 
              <?php echo $this->lang->line('umb_acc_calendar');?> 
            </a> 
          </li>
        <?php } ?>
        <?php if(in_array('401',$role_resources_ids)) { ?>
          <li class="sidenav-item <?php if(!empty($arr_mod['permintaan_lembur_act']))echo $arr_mod['permintaan_lembur_act'];?>"> 
            <a class="sidenav-link" href="<?php echo site_url('admin/permintaan_lembur/');?>" > 
              <?php echo $this->lang->line('umb_permintaan_lembur');?> 
            </a> 
          </li>
        <?php } ?>
      </ul>
    </li>
  <?php } ?>
  <?php if(in_array('95',$role_resources_ids)) { ?>
    <li class="sidenav-item <?php if(!empty($arr_mod['calendar_hr_active']))echo $arr_mod['calendar_hr_active'];?>"> 
      <a href="<?php echo site_url('admin/calendar/hr/');?>" class="sidenav-link"> 
        <i class="sidenav-icon oi oi-calendar"></i>
        <div><?php echo $this->lang->line('umb_hr_calendar_title');?></div>
      </a> 
    </li>
  <?php } ?>
  <?php if($system[0]->module_payroll=='yes'){?>
    <?php if(!in_array('36',$role_resources_ids) && in_array('37',$role_resources_ids)){?>
      <li class="sidenav-item <?php if(!empty($arr_mod['pay_generate_active']))echo $arr_mod['pay_generate_active'];?>"> 
        <a href="<?php echo site_url('admin/payroll/history_pembayaran/');?>" class="sidenav-link"> 
          <i class="sidenav-icon fa fa-calculator"></i>
          <div><?php echo $this->lang->line('umb_history_slipgaji');?></div>
        </a> 
      </li>
    <?php } ?>
  <?php } ?>
  <?php if(in_array('45',$role_resources_ids) || in_array('90',$role_resources_ids) || in_array('91',$role_resources_ids)){?>
    <li class="<?php if(!empty($arr_mod['tugas_open']))echo $arr_mod['tugas_open'];?> sidenav-item"> 
      <a href="#" class="sidenav-link sidenav-toggle"> <i class="sidenav-icon fab fa-fantasy-flight-games"></i> <div><?php echo $this->lang->line('left_tugass');?></div>
      </a>
      <ul class="sidenav-menu">
        <?php if(in_array('45',$role_resources_ids)) { ?>
          <li class="sidenav-item <?php if(!empty($arr_mod['tugas_active']))echo $arr_mod['tugas_active'];?>"> 
            <a class="sidenav-link" href="<?php echo site_url('admin/timesheet/tugass/');?>" > 
              <?php echo $this->lang->line('left_tugass');?> 
            </a> 
          </li>
        <?php } ?>
        <?php if(in_array('90',$role_resources_ids)) { ?>
          <li class="sidenav-item <?php if(!empty($arr_mod['calendar_tugass_active']))echo $arr_mod['calendar_tugass_active'];?>"> 
            <a class="sidenav-link" href="<?php echo site_url('admin/project/calendar_tugass/');?>" > 
              <?php echo $this->lang->line('umb_calendar_tugass');?> 
            </a> 
          </li>
        <?php } ?>
        <?php if(in_array('91',$role_resources_ids)) { ?>
          <li class="sidenav-item <?php if(!empty($arr_mod['scrum_board_tugass_active']))echo $arr_mod['scrum_board_tugass_active'];?>"> 
            <a class="sidenav-link" href="<?php echo site_url('admin/project/scrum_board_tugass/');?>" > 
              <?php echo $this->lang->line('umb_tugass_sboard');?> 
            </a> 
          </li>
        <?php } ?>
      </ul>
    </li>
  <?php } ?>
  <?php if(in_array('47',$role_resources_ids) || in_array('400',$role_resources_ids) || in_array('442',$role_resources_ids)){?>
    <li class="<?php if(!empty($arr_mod['files_open']))echo $arr_mod['files_open'];?> sidenav-item"> 
      <a href="#" class="sidenav-link sidenav-toggle"> 
        <i class="sidenav-icon fas fa-file-signature"></i>
        <div><?php echo $this->lang->line('umb_files');?></div>
      </a>
      <ul class="sidenav-menu">
        <?php if(in_array('47',$role_resources_ids)) { ?>
          <li class="sidenav-item <?php if(!empty($arr_mod['file_active']))echo $arr_mod['file_active'];?>">
            <a class="sidenav-link" href="<?php echo site_url('admin/files/');?>" > 
              <?php echo $this->lang->line('umb_files');?> 
            </a> 
          </li>
        <?php } ?>
        <?php if(in_array('442',$role_resources_ids)) { ?>
          <li class="sidenav-item <?php if(!empty($arr_mod['documents_resmi_active']))echo $arr_mod['documents_resmi_active'];?>"> 
            <a class="sidenav-link" href="<?php echo site_url('admin/perusahaan/documents_resmi/');?>" > 
              <?php echo $this->lang->line('umb_hr_documents_resmi');?> 
            </a> 
          </li>
        <?php } ?>
        <?php if(in_array('400',$role_resources_ids)) { ?>
          <li class="sidenav-item <?php if(!empty($arr_mod['documents_kadaluarsa_active']))echo $arr_mod['documents_kadaluarsa_active'];?>"> 
            <a class="sidenav-link" href="<?php echo site_url('admin/karyawans/documents_kadaluarsa/');?>" > 
              <?php echo $this->lang->line('umb_e_details_exp_documents');?> 
            </a> 
          </li>
        <?php } ?>
      </ul>
    </li>
  <?php } ?>
  <?php if(in_array('121',$role_resources_ids) || in_array('330',$role_resources_ids) || in_array('122',$role_resources_ids) || in_array('426',$role_resources_ids)){?>
    <li class="<?php if(!empty($arr_mod['invoices_open']))echo $arr_mod['invoices_open'];?> sidenav-item"> 
      <a href="#" class="sidenav-link sidenav-toggle"> 
        <i class="sidenav-icon fas fa-file-invoice-dollar"></i>
        <div><?php echo $this->lang->line('umb_invoices_title');?></div>
      </a>
      <ul class="sidenav-menu">
        <?php if(in_array('121',$role_resources_ids)) { ?>
          <li class="sidenav-item <?php if(!empty($arr_mod['invoices_inv_active']))echo $arr_mod['invoices_inv_active'];?>"> 
            <a class="sidenav-link" href="<?php echo site_url('admin/invoices/');?>" > <?php echo $this->lang->line('umb_invoices_title');?> </a> 
          </li>
        <?php } ?>
        <?php if(in_array('426',$role_resources_ids)) { ?>
          <li class="sidenav-item <?php if(!empty($arr_mod['calendar_invoice_active']))echo $arr_mod['calendar_invoice_active'];?>"> 
            <a class="sidenav-link" href="<?php echo site_url('admin/invoices/calendar_invoice/');?>" > <?php echo $this->lang->line('umb_calendar_invoice');?> </a> 
          </li>
        <?php } ?>
        <?php if(in_array('330',$role_resources_ids)) { ?>
          <li class="sidenav-item <?php if(!empty($arr_mod['history_pembayarans_inv_active']))echo $arr_mod['history_pembayarans_inv_active'];?>">
            <a class="sidenav-link" href="<?php echo site_url('admin/invoices/history_pembayarans/');?>" > <?php echo $this->lang->line('umb_acc_pembayarans_invoice');?> </a> 
          </li>
        <?php } ?>
        <?php if(in_array('122',$role_resources_ids)) { ?>
          <li class="sidenav-item <?php if(!empty($arr_mod['pajaks_inv_active']))echo $arr_mod['pajaks_inv_active'];?>"> 
            <a class="sidenav-link" href="<?php echo site_url('admin/invoices/pajaks/');?>" > <?php echo $this->lang->line('umb_invoice_type_pajak');?> </a> 
          </li>
        <?php } ?>
      </ul>
    </li>
  <?php } ?>
  <?php if(in_array('46',$role_resources_ids) && in_array('409',$role_resources_ids)){?>
    <li class="sidenav-item <?php if(!empty($arr_mod['cuti_active']))echo $arr_mod['cuti_active'];?>"> 
      <a href="<?php echo site_url('admin/timesheet/cuti/');?>" class="sidenav-link"> 
        <i class="sidenav-icon fas fa-calendar-alt"></i>
        <div><?php echo $this->lang->line('umb_manage_cutii');?></div>
      </a> 
    </li>
  <?php } ?>
  <?php if(in_array('46',$role_resources_ids) && !in_array('409',$role_resources_ids)){?>
    <li class="sidenav-item <?php if(!empty($arr_mod['cuti_active']))echo $arr_mod['cuti_active'];?>"> 
      <a href="<?php echo site_url('admin/timesheet/cuti/');?>" class="sidenav-link"> 
        <i class="sidenav-icon fas fa-calendar-alt"></i>
        <div><?php echo $this->lang->line('umb_manage_cutii');?></div>
      </a> 
    </li>
  <?php } ?>
  <?php if(!in_array('46',$role_resources_ids) && in_array('409',$role_resources_ids)){?>
    <li class="sidenav-item <?php if(!empty($arr_mod['cuti_active']))echo $arr_mod['cuti_active'];?>"> 
      <a href="<?php echo site_url('admin/laporans/karyawan_cuti/');?>" class="sidenav-link"> 
        <i class="sidenav-icon fas fa-calendar-alt"></i>
        <div><?php echo $this->lang->line('umb_status_cuti');?></div>
      </a> 
    </li>
  <?php } ?>
  <?php if(in_array('44',$role_resources_ids) || in_array('312',$role_resources_ids) || in_array('119',$role_resources_ids) || in_array('94',$role_resources_ids) || in_array('424',$role_resources_ids) || in_array('425',$role_resources_ids)){?>
    <li class="<?php if(!empty($arr_mod['project_open']))echo $arr_mod['project_open'];?> sidenav-item"> 
      <a href="#" class="sidenav-link sidenav-toggle"> 
        <i class="sidenav-icon ion ion-logo-buffer"></i>
        <div><?php echo $this->lang->line('umb_projects_manager_title');?></div>
      </a>
      <ul class="sidenav-menu">
        <?php if(in_array('312',$role_resources_ids)) { ?>
          <li class="sidenav-item <?php if(!empty($arr_mod['dashboard_projects_active']))echo $arr_mod['dashboard_projects_active'];?>"> 
            <a class="sidenav-link" href="<?php echo site_url('admin/project/dashboard_projects/');?>" > <?php echo $this->lang->line('dashboard_title');?> </a> 
          </li>
        <?php } ?>
        <?php if(in_array('44',$role_resources_ids)) { ?>
          <li class="sidenav-item <?php if(!empty($arr_mod['project_active']))echo $arr_mod['project_active'];?>"> 
            <a class="sidenav-link" href="<?php echo site_url('admin/project/');?>" > 
              <?php echo $this->lang->line('left_projects');?> 
            </a> 
          </li>
        <?php } ?>
        <?php if(in_array('119',$role_resources_ids)) { ?>
          <li class="sidenav-item <?php if(!empty($arr_mod['clients_active']))echo $arr_mod['clients_active'];?>"> 
            <a class="sidenav-link" href="<?php echo site_url('admin/clients/');?>" > 
              <?php echo $this->lang->line('umb_project_clients');?> 
            </a> 
          </li>
        <?php } ?>
        <?php if(in_array('94',$role_resources_ids)) { ?>
          <li class="sidenav-item <?php if(!empty($arr_mod['project_timelogs_active']))echo $arr_mod['project_timelogs_active'];?>"> 
            <a class="sidenav-link" href="<?php echo site_url('admin/project/timelogs/');?>" > 
              <?php echo $this->lang->line('umb_project_timelogs');?> 
            </a> 
          </li>
        <?php } ?>
        <?php if(in_array('424',$role_resources_ids)) { ?>
          <li class="sidenav-item <?php if(!empty($arr_mod['calendar_projects_active']))echo $arr_mod['calendar_projects_active'];?>"> 
            <a class="sidenav-link" href="<?php echo site_url('admin/project/calendar_projects/');?>" > 
              <?php echo $this->lang->line('umb_acc_calendar');?> 
            </a> 
          </li>
        <?php } ?>
        <?php if(in_array('425',$role_resources_ids)) { ?>
          <li class="sidenav-item <?php if(!empty($arr_mod['scrum_board_projects_active']))echo $arr_mod['scrum_board_projects_active'];?>"> 
            <a class="sidenav-link" href="<?php echo site_url('admin/project/scrum_board_projects/');?>" > 
              <?php echo $this->lang->line('umb_projects_scrm_board');?> 
            </a> 
          </li>
        <?php } ?>
      </ul>
    </li>
  <?php } ?>
  <?php if(in_array('415',$role_resources_ids) || in_array('410',$role_resources_ids) || in_array('427',$role_resources_ids) || in_array('428',$role_resources_ids) || in_array('429',$role_resources_ids) || in_array('430',$role_resources_ids)){?>
    <li class="<?php if(!empty($arr_mod['hr_quote_manager_open']))echo $arr_mod['hr_quote_manager_open'];?> sidenav-item"> 
      <a href="#" class="sidenav-link sidenav-toggle"> 
        <i class="sidenav-icon fa fa-tasks"></i>
        <div><?php echo $this->lang->line('umb_estimates');?></div>
      </a>
      <ul class="sidenav-menu">
        <?php if(in_array('415',$role_resources_ids)) { ?>
          <li class="sidenav-item <?php if(!empty($arr_mod['all_quotes_active']))echo $arr_mod['all_quotes_active'];?>"> 
            <a class="sidenav-link" href="<?php echo site_url('admin/quotes/');?>" > 
              <?php echo $this->lang->line('umb_estimates');?> 
            </a> 
          </li>
        <?php } ?>
        <?php if(in_array('427',$role_resources_ids)) { ?>
          <li class="sidenav-item <?php if(!empty($arr_mod['quote_calendar_active']))echo $arr_mod['quote_calendar_active'];?>"> 
            <a class="sidenav-link" href="<?php echo site_url('admin/quoted_projects/quote_calendar/');?>" > 
              <?php echo $this->lang->line('umb_quote_calendar');?> 
            </a> 
          </li>
        <?php } ?>
        <?php if(in_array('429',$role_resources_ids)) { ?>
          <li class="sidenav-item <?php if(!empty($arr_mod['leadsl_quotes_active']))echo $arr_mod['leadsl_quotes_active'];?>"> 
            <a class="sidenav-link" href="<?php echo site_url('admin/leads/');?>" > 
              <?php echo $this->lang->line('umb_leads');?> 
            </a> 
          </li>
        <?php } ?>
        <?php if(in_array('430',$role_resources_ids)) { ?>
          <li class="sidenav-item <?php if(!empty($arr_mod['timelogs_quotes_active']))echo $arr_mod['timelogs_quotes_active'];?>"> 
            <a class="sidenav-link" href="<?php echo site_url('admin/quoted_projects/timelogs/');?>" > 
              <?php echo $this->lang->line('umb_project_timelogs');?> 
            </a> 
          </li>
        <?php } ?>
        <?php if(in_array('428',$role_resources_ids)) { ?>
          <li class="sidenav-item <?php if(!empty($arr_mod['quoted_projects_active']))echo $arr_mod['quoted_projects_active'];?>"> 
            <a class="sidenav-link" href="<?php echo site_url('admin/quoted_projects/');?>" > 
              <?php echo $this->lang->line('umb_quoted_projects');?> 
            </a> 
          </li>
        <?php } ?>
      </ul>
    </li>
  <?php } //297?>
  <?php if($system[0]->module_recruitment=='true'){?>
    <?php  if(in_array('49',$role_resources_ids) || in_array('51',$role_resources_ids) || in_array('52',$role_resources_ids) || in_array('296',$role_resources_ids)) {?>
      <li class="<?php if(!empty($arr_mod['recruit_open']))echo $arr_mod['recruit_open'];?> sidenav-item"> 
        <a href="#" class="sidenav-link sidenav-toggle"> 
          <i class="sidenav-icon fas fa-newspaper"></i>
          <div><?php echo $this->lang->line('left_recruitment');?></div>
        </a>
        <ul class="sidenav-menu">
          <?php if(in_array('49',$role_resources_ids)) { ?>
            <li class="sidenav-item <?php if(!empty($arr_mod['post_pkrj_active']))echo $arr_mod['post_pkrj_active'];?>"> 
              <a class="sidenav-link" href="<?php echo site_url('admin/post_pekerjaan/');?>" > 
                <?php echo $this->lang->line('left_post_pekerjaan');?> 
              </a> 
            </li>
          <?php } ?>
          <?php if(in_array('51',$role_resources_ids)) { ?>
            <li class="sidenav-item <?php if(!empty($arr_mod['kandidats_pekerjaan_active']))echo $arr_mod['kandidats_pekerjaan_active'];?>">
              <a class="sidenav-link" href="<?php echo site_url('admin/kandidats_pekerjaan/');?>"> 
                <?php echo $this->lang->line('left_kandidats_pekerjaan');?> 
              </a> 
            </li>
          <?php } ?>
          <?php if(in_array('52',$role_resources_ids)) { ?>
            <li class="sidenav-item <?php if(!empty($arr_mod['jb_employer_active']))echo $arr_mod['jb_employer_active'];?>">
              <a class="sidenav-link" href="<?php echo site_url('admin/post_pekerjaan/employer/');?>" > 
                <?php echo $this->lang->line('umb_employer_pekerjaans');?> 
              </a> 
            </li>
          <?php } ?>
          <?php if(in_array('296',$role_resources_ids)) { ?>
            <li class="sidenav-item <?php if(!empty($arr_mod['pages_pkrj_active']))echo $arr_mod['pages_pkrj_active'];?>"> 
              <a class="sidenav-link" href="<?php echo site_url('admin/post_pekerjaan/pages/');?>" > 
                <?php echo $this->lang->line('umb_cms_pages_pekerjaans');?> 
              </a> 
            </li>
          <?php } ?>
        </ul>
      </li>
    <?php } ?>
  <?php } ?>
  <?php if($system[0]->module_performance=='yes'){?>
    <?php if($system[0]->performance_option == 'goal'): ?>
      <?php if(in_array('106',$role_resources_ids) || in_array('107',$role_resources_ids) || in_array('108',$role_resources_ids)){?>
        <?php if(in_array('107',$role_resources_ids) && in_array('108',$role_resources_ids)) {?>
          <li class="sidenav-item <?php if(!empty($arr_mod['performance_active']))echo $arr_mod['performance_active'];?>"> 
            <a href="<?php echo site_url('admin/tujuan_tracking/');?>" class="sidenav-link"> 
              <i class="sidenav-icon fas fa-cube"></i>
              <div><?php echo $this->lang->line('left_performance');?></div>
            </a> 
          </li>
        <?php } ?>
        <?php if(in_array('107',$role_resources_ids) && !in_array('108',$role_resources_ids)) {?>
          <li class="sidenav-item <?php if(!empty($arr_mod['performance_active']))echo $arr_mod['performance_active'];?>"> 
            <a href="<?php echo site_url('admin/tujuan_tracking/');?>" class="sidenav-link"> 
              <i class="sidenav-icon fas fa-cube"></i>
              <div><?php echo $this->lang->line('left_performance');?></div>
            </a> 
          </li>
        <?php } ?>
        <?php if(!in_array('107',$role_resources_ids) && in_array('108',$role_resources_ids)) {?>
          <li class="sidenav-item <?php if(!empty($arr_mod['performance_active']))echo $arr_mod['performance_active'];?>"> 
            <a href="<?php echo site_url('admin/tujuan_tracking/type/');?>" class="sidenav-link"> 
              <i class="sidenav-icon fas fa-cube"></i>
              <div><?php echo $this->lang->line('umb_hr_type_tujuan_tracking_se');?></div>
            </a> 
          </li>
        <?php } ?>
      <?php } ?>
      <?php elseif($system[0]->performance_option == 'appraisal'): ?>
        <?php if(in_array('40',$role_resources_ids) || in_array('41',$role_resources_ids) || in_array('42',$role_resources_ids)) {?>
          <?php if(in_array('41',$role_resources_ids) && in_array('42',$role_resources_ids)) {?>
            <li class="sidenav-item <?php if(!empty($arr_mod['performance_active']))echo $arr_mod['performance_active'];?>"> 
              <a href="<?php echo site_url('admin/performance_appraisal/');?>" class="sidenav-link"> <i class="sidenav-icon fas fa-cube"></i>
                <div><?php echo $this->lang->line('left_performance');?></div>
              </a> 
            </li>
          <?php } ?>
          <?php if(!in_array('41',$role_resources_ids) && in_array('42',$role_resources_ids)) {?>
            <li class="sidenav-item <?php if(!empty($arr_mod['performance_active']))echo $arr_mod['performance_active'];?>"> 
              <a href="<?php echo site_url('admin/performance_appraisal/');?>" class="sidenav-link"> <i class="sidenav-icon fas fa-cube"></i>
                <div><?php echo $this->lang->line('left_performance');?></div>
              </a> 
            </li>
          <?php } ?>
          <?php if(in_array('41',$role_resources_ids) && !in_array('42',$role_resources_ids)) {?>
            <li class="sidenav-item <?php if(!empty($arr_mod['performance_active']))echo $arr_mod['performance_active'];?>">
              <a href="<?php echo site_url('admin/performance_indicator/');?>" class="sidenav-link"> 
                <i class="sidenav-icon fas fa-cube"></i>
                <div><?php echo $this->lang->line('left_performance');?></div>
              </a> 
            </li>
          <?php } ?>
        <?php } ?>
        <?php else:?>
          <?php if(in_array('40',$role_resources_ids) || in_array('41',$role_resources_ids) || in_array('42',$role_resources_ids)) {?>
            <?php if(in_array('41',$role_resources_ids) && in_array('42',$role_resources_ids)) {?>
              <li class="sidenav-item <?php if(!empty($arr_mod['performance_active']))echo $arr_mod['performance_active'];?>">
                <a href="<?php echo site_url('admin/performance_appraisal/');?>" class="sidenav-link"> 
                  <i class="sidenav-icon fas fa-cube"></i>
                  <div><?php echo $this->lang->line('left_performance');?></div>
                </a> 
              </li>
            <?php } ?>
            <?php if(!in_array('41',$role_resources_ids) && in_array('42',$role_resources_ids)) {?>
              <li class="sidenav-item <?php if(!empty($arr_mod['performance_active']))echo $arr_mod['performance_active'];?>"> 
                <a href="<?php echo site_url('admin/performance_appraisal/');?>" class="sidenav-link"> 
                  <i class="sidenav-icon fas fa-cube"></i>
                  <div><?php echo $this->lang->line('left_performance');?></div>
                </a> 
              </li>
            <?php } ?>
            <?php if(in_array('41',$role_resources_ids) && !in_array('42',$role_resources_ids)) {?>
              <li class="sidenav-item <?php if(!empty($arr_mod['performance_active']))echo $arr_mod['performance_active'];?>"> 
                <a href="<?php echo site_url('admin/performance_indicator/');?>" class="sidenav-link"> 
                  <i class="sidenav-icon fas fa-cube"></i>
                  <div><?php echo $this->lang->line('left_performance');?></div>
                </a> 
              </li>
            <?php } ?>
          <?php } ?>
        <?php endif;?>
      <?php } ?>
      <?php $hr_top_menu = explode(',',$system[0]->hr_top_menu);?>
      <?php if($system[0]->module_assets=='true'){?>
        <?php if(in_array('assets',$hr_top_menu)):?>
          <?php if(in_array('24',$role_resources_ids) && in_array('25',$role_resources_ids) && in_array('26',$role_resources_ids)) {?>
            <li class="sidenav-item">
              <a class="sidenav-link" href="<?php echo site_url('admin/assets');?>"> 
                <i class="ion ion-md-today sidenav-icon"></i>
                <div><?php echo $this->lang->line('umb_assets');?></div>
              </a>
            </li>
          <?php } ?>
        <?php endif;?>
        <?php if(in_array('kategori_assets',$hr_top_menu)):?>
          <?php if(!in_array('25',$role_resources_ids) && in_array('26',$role_resources_ids)) {?>
            <li class="sidenav-item">
              <a class="sidenav-link" href="<?php echo site_url('admin/assets/kategori');?>"> 
                <i class="ion ion-md-today sidenav-icon"></i>
                <div><?php echo $this->lang->line('umb_kategori_assets');?></div>
              </a>
            </li>
          <?php } ?>
        <?php endif;?>
        <?php if(in_array('assets',$hr_top_menu)):?>
          <?php if(in_array('25',$role_resources_ids) && !in_array('26',$role_resources_ids)) {?>
            <li class="sidenav-item">
              <a class="sidenav-link" href="<?php echo site_url('admin/assets/');?>"> 
                <i class="ion ion-md-today sidenav-icon"></i>
                <div><?php echo $this->lang->line('umb_assets');?></div>
              </a>
            </li>
          <?php } ?>
        <?php endif;?>
      <?php } ?>
      <?php if($system[0]->module_inquiry=='true'){?>
       <?php if(in_array('tickets',$hr_top_menu)):?>
        <?php if(in_array('43',$role_resources_ids)) { ?>
          <li class="sidenav-item">
            <a class="sidenav-link" href="<?php echo site_url('admin/tickets');?>"> 
              <i class="fab fa-critical-role sidenav-icon"></i>
              <div><?php echo $this->lang->line('left_tickets');?></div>
            </a>
          </li>
        <?php } ?>
      <?php endif;?>
    <?php } ?>
    <?php if($system[0]->module_training=='true'){?>
      <?php if(in_array('training',$hr_top_menu)):?>
        <?php  if(in_array('54',$role_resources_ids) && in_array('55',$role_resources_ids) && in_array('56',$role_resources_ids)) {?>
          <li class="sidenav-item">
            <a href="<?php echo site_url('admin/training')?>" class="sidenav-link"> 
              <i class="fas fa-portrait sidenav-icon"></i>
              <div><?php echo $this->lang->line('left_training');?></div>
            </a>
          </li>
        <?php } ?>
      <?php endif;?>
      <?php if(in_array('training',$hr_top_menu)):?>
        <?php  if(in_array('54',$role_resources_ids) && !in_array('55',$role_resources_ids) && !in_array('56',$role_resources_ids)) {?>
          <li class="sidenav-item">
            <a href="<?php echo site_url('admin/training')?>" class="sidenav-link"> 
              <i class="fas fa-portrait sidenav-icon"></i>
              <div><?php echo $this->lang->line('left_training');?></div>
            </a>
          </li>
        <?php } ?>
      <?php endif;?>
      <?php if(in_array('training',$hr_top_menu)):?>
        <?php  if(in_array('54',$role_resources_ids) && in_array('55',$role_resources_ids) && !in_array('56',$role_resources_ids)) {?>
          <li class="sidenav-item">
            <a href="<?php echo site_url('admin/training')?>" class="sidenav-link"> 
              <i class="fas fa-portrait sidenav-icon"></i>
              <div><?php echo $this->lang->line('left_training');?></div>
            </a>
          </li>
        <?php } ?>
      <?php endif;?>
      <?php if(in_array('training',$hr_top_menu)):?>
        <?php  if(in_array('54',$role_resources_ids) && !in_array('55',$role_resources_ids) && in_array('56',$role_resources_ids)) {?>
          <li class="sidenav-item">
            <a href="<?php echo site_url('admin/training')?>" class="sidenav-link"> 
              <i class="fas fa-portrait sidenav-icon"></i>
              <div><?php echo $this->lang->line('left_training');?></div>
            </a>
          </li>
        <?php } ?>
      <?php endif;?>
      <?php if(in_array('trainers_list',$hr_top_menu)):?>
        <?php  if(!in_array('54',$role_resources_ids) && in_array('56',$role_resources_ids) && in_array('55',$role_resources_ids)) {?>
         <li class="sidenav-item">
          <a href="<?php echo site_url('admin/trainers')?>" class="sidenav-link"> 
            <i class="fas fa-portrait sidenav-icon"></i>
            <div><?php echo $this->lang->line('left_list_trainers');?></div>
          </a>
        </li>
      <?php } ?>
    <?php endif;?>
    <?php if(in_array('trainers_list',$hr_top_menu)):?>
      <?php  if(!in_array('54',$role_resources_ids) && in_array('56',$role_resources_ids) && !in_array('55',$role_resources_ids)) {?>
        <li class="sidenav-item">
          <a href="<?php echo site_url('admin/trainers')?>" class="sidenav-link"> 
            <i class="fas fa-portrait sidenav-icon"></i>
            <div><?php echo $this->lang->line('left_list_trainers');?></div>
          </a>
        </li>
      <?php } ?>
    <?php endif;?>
    <?php if(in_array('type_training',$hr_top_menu)):?>
      <?php  if(!in_array('54',$role_resources_ids) && !in_array('56',$role_resources_ids) && in_array('55',$role_resources_ids)) {?>
        <li class="sidenav-item">
          <a href="<?php echo site_url('admin/type_training')?>" class="sidenav-link"> 
            <i class="fas fa-portrait sidenav-icon"></i>
            <div><?php echo $this->lang->line('left_type_training');?></div>
          </a>
        </li>
      <?php } ?>
    <?php endif;?>
  <?php } ?>
  <?php if(in_array('libur',$hr_top_menu)):?>
    <?php if(in_array('8',$role_resources_ids)) { ?>
      <li class="sidenav-item">
        <a class="sidenav-link" href="<?php echo site_url('admin/timesheet/liburan');?>"> 
          <i class="ion ion-ios-paper-plane sidenav-icon"></i>
          <div><?php echo $this->lang->line('left_liburan');?></div>
        </a>
      </li>
    <?php } ?>
  <?php endif;?>
  <?php if(in_array('hr_import',$hr_top_menu)):?>
    <?php  if(in_array('92',$role_resources_ids) || in_array('443',$role_resources_ids) || in_array('444',$role_resources_ids)) { ?>
      <li class="sidenav-item">
        <a class="sidenav-link" href="<?php echo site_url('admin/import');?>"> 
          <i class="fas fa-file-upload sidenav-icon"></i>
          <div><?php echo $this->lang->line('umb_hr_imports');?></div>
        </a>
      </li>
    <?php } ?>
  <?php endif;?>
  <?php if(in_array('hr_report',$hr_top_menu)):?>
    <?php  if(in_array('110',$role_resources_ids) || in_array('111',$role_resources_ids) || in_array('112',$role_resources_ids) || in_array('113',$role_resources_ids) || in_array('114',$role_resources_ids) || in_array('115',$role_resources_ids) || in_array('116',$role_resources_ids) || in_array('117',$role_resources_ids) || in_array('409',$role_resources_ids) || in_array('83',$role_resources_ids) || in_array('84',$role_resources_ids) || in_array('85',$role_resources_ids) || in_array('86',$role_resources_ids)) { ?>
      <li class="sidenav-item">
        <a href="<?php echo site_url('admin/laporans')?>" class="sidenav-link"> 
          <i class="fas fa-chart-bar sidenav-icon"></i>
          <div><?php echo $this->lang->line('umb_hr_title_laporan');?></div>
        </a>
      </li>
    <?php } ?>
  <?php endif;?>
  <?php if(in_array('custom_fields',$hr_top_menu)):?>
    <?php  if(in_array('393',$role_resources_ids)) { ?>
      <li class="sidenav-item">
        <a class="sidenav-link" href="<?php echo site_url('admin/custom_fields');?>"> 
          <i class="fas fa-sliders-h sidenav-icon"></i>
          <div><?php echo $this->lang->line('umb_hrastral_custom_fields');?></div>
        </a>
      </li>
    <?php } ?>
  <?php endif;?>
  <?php if(in_array('hr_penerima_pembayarans_pembayars',$hr_top_menu)):?>
    <?php  if(in_array('80',$role_resources_ids) && in_array('81',$role_resources_ids)) {?>
      <li class="sidenav-item">
        <a href="<?php echo site_url('admin/accounting/penerima_pembayarans')?>" class="sidenav-link"> 
          <i class="ion ion-md-contacts sidenav-icon"></i>
          <div><?php echo $this->lang->line('umb_hr_penerima_pembayarans_pembayars');?></div>
        </a>
      </li>
    <?php } ?>
  <?php endif;?>
  <?php if(in_array('acc_penerima_pembayarans',$hr_top_menu)):?>
    <?php  if(in_array('80',$role_resources_ids) && !in_array('81',$role_resources_ids)) {?>
      <li class="sidenav-item">
        <a href="<?php echo site_url('admin/accounting/penerima_pembayarans')?>" class="sidenav-link"> 
          <i class="ion ion-md-contacts sidenav-icon"></i>
          <div><?php echo $this->lang->line('umb_acc_penerima_pembayarans');?></div>
        </a>
      </li>
    <?php } ?>
  <?php endif;?>
  <?php if(in_array('acc_pembayars',$hr_top_menu)):?>
    <?php  if(!in_array('80',$role_resources_ids) && in_array('81',$role_resources_ids)) {?>
      <li class="sidenav-item">
        <a href="<?php echo site_url('admin/accounting/pembayars')?>" class="sidenav-link"> 
          <i class="ion ion-md-contacts sidenav-icon"></i>
          <div><?php echo $this->lang->line('umb_acc_pembayars');?></div>
        </a>
      </li>
    <?php } ?>
  <?php endif;?>
  <?php if($system[0]->is_active_sub_departments=='yes'){?>
    <?php if(in_array('sub_department',$hr_top_menu)):?>
      <?php  if(in_array('3',$role_resources_ids)) { ?>
        <li class="sidenav-item">
          <a href="<?php echo site_url('admin/department/sub_departments')?>" class="sidenav-link"> 
            <i class="far fa-building sidenav-icon"></i>
            <div><?php echo $this->lang->line('umb_hr_sub_departments');?></div>
          </a>
        </li>
      <?php } ?>
    <?php endif;?>
  <?php } ?>
  <?php if($system[0]->module_events=='true'){?>
    <?php if(in_array('events_meetings',$hr_top_menu)):?>
      <?php  if(in_array('98',$role_resources_ids) && in_array('99',$role_resources_ids)) {?>
        <li class="sidenav-item">
          <a href="<?php echo site_url('admin/events')?>" class="sidenav-link"> 
            <i class="fas fa-calendar-alt sidenav-icon"></i>
            <div><?php echo $this->lang->line('umb_hr_events_meetings');?></div>
          </a>
        </li>
      <?php } ?>
    <?php endif;?>
    <?php if(in_array('events',$hr_top_menu)):?>
      <?php  if(in_array('98',$role_resources_ids) && !in_array('99',$role_resources_ids)) {?>
        <li class="sidenav-item">
          <a href="<?php echo site_url('admin/events')?>" class="sidenav-link"> 
            <i class="fas fa-calendar-alt sidenav-icon"></i>
            <div><?php echo $this->lang->line('umb_hr_events');?></div>
          </a>
        </li>
      <?php } ?>
    <?php endif;?>
    <?php if(in_array('meetings',$hr_top_menu)):?>
      <?php  if(!in_array('98',$role_resources_ids) && in_array('99',$role_resources_ids)) {?>
        <li class="sidenav-item">
          <a href="<?php echo site_url('admin/meetings')?>" class="sidenav-link"> 
            <i class="fas fa-calendar-alt sidenav-icon"></i>
            <div><?php echo $this->lang->line('umb_hr_meetings');?></div>
          </a>
        </li>
      <?php } ?>
    <?php endif;?>
  <?php } ?>
  <?php if($system[0]->module_orgchart=='true'){?>
    <?php if(in_array('orgchart',$hr_top_menu)):?>
      <?php  if(in_array('96',$role_resources_ids)) { ?>
        <li class="sidenav-item">
          <a href="<?php echo site_url('admin/organization/chart')?>" class="sidenav-link"> 
            <i class="ion ion-ios-map sidenav-icon"></i>
            <div><?php echo $this->lang->line('umb_title_org_chart');?></div>
          </a>
        </li>
      <?php } ?>
    <?php endif;?>
  <?php } ?>
  <?php if(in_array('settings',$hr_top_menu)):?>
    <?php  if(in_array('60',$role_resources_ids)) { ?>
      <li class="sidenav-item">
        <a href="<?php echo site_url('admin/settings')?>" class="sidenav-link"> 
          <i class="fas fa-cog sidenav-icon"></i>
          <div><?php echo $this->lang->line('header_configuration');?></div>
        </a>
      </li>
    <?php } ?>
  <?php endif;?>
</ul>
