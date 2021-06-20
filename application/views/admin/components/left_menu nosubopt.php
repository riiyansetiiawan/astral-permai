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
  <?php if(in_array('13',$role_resources_ids) || in_array('7',$role_resources_ids) || $laporans_to>0 || $user_info[0]->user_role_id==1){ ?>
    <li class="sidenav-item <?php if(!empty($arr_mod['emp_active']))echo $arr_mod['emp_active'];?>">
      <?php if(!in_array('13',$role_resources_ids) && in_array('7',$role_resources_ids)) { ?>
        <a href="<?php echo site_url('admin/timesheet/shift_kantor');?>" class="sidenav-link">
          <i class="sidenav-icon ion ion-md-clock"></i>
          <div><?php echo $this->lang->line('left_shifts_kantor');?></div>
        </a>
      <?php } ?>
      <?php if(in_array('13',$role_resources_ids) || in_array('422',$role_resources_ids) || in_array('7',$role_resources_ids) || $user_info[0]->user_role_id==1){?>
        <a href="<?php echo site_url('admin/karyawans');?>" class="sidenav-link">
          <i class="sidenav-icon fas fa-user-friends"></i>
          <div><?php echo $this->lang->line('dashboard_karyawans');?></div>
        </a>
      <?php } ?>
    </li>
  <?php } ?>
  <?php if($system[0]->module_payroll=='yes'){?>
    <?php if(in_array('36',$role_resources_ids)) { ?>
      <li class="<?php if(!empty($arr_mod['pay_generate_active']))echo $arr_mod['pay_generate_active'];?> sidenav-item"> 
        <a class="sidenav-link" href="<?php echo site_url('admin/payroll/generate_slipgaji');?>">
          <i class="sidenav-icon fa fa-calculator"></i>
          <div><?php echo $this->lang->line('left_payroll');?></div> 
        </a> 
      </li>
    <?php } ?>
    <?php if(!in_array('36',$role_resources_ids) && in_array('37',$role_resources_ids)) { ?>
      <li class="<?php if(!empty($arr_mod['pay_generate_active']))echo $arr_mod['pay_generate_active'];?> sidenav-item"> 
        <a class="sidenav-link" href="<?php echo site_url('admin/payroll/history_pembayaran');?>"> 
          <i class="sidenav-icon ion ion-ios-cash"></i> 
          <div><?php echo $this->lang->line('umb_history_slipgaji');?></div> 
        </a> 
      </li>
    <?php } ?>
  <?php } ?>
  <?php if($system[0]->module_accounting=='true'){?>
    <?php if(in_array('71',$role_resources_ids) || in_array('72',$role_resources_ids) || in_array('73',$role_resources_ids) || in_array('74',$role_resources_ids) || in_array('75',$role_resources_ids) || in_array('76',$role_resources_ids) || in_array('77',$role_resources_ids) || in_array('78',$role_resources_ids) || in_array('286',$role_resources_ids) || $user_info[0]->user_role_id==1){?>
      <li class="sidenav-item <?php if(!empty($arr_mod['dashboard_accounting_active']))echo $arr_mod['dashboard_accounting_active'];?>">
        <a href="<?php echo site_url('admin/accounting/dashboard_accounting/');?>" class="sidenav-link">
          <i class="sidenav-icon ion ion-md-cash"></i>
          <div><?php echo $this->lang->line('umb_hr_keuangan');?></div>
        </a>
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
  <?php  if(in_array('2',$role_resources_ids) || in_array('3',$role_resources_ids) || in_array('5',$role_resources_ids) || in_array('6',$role_resources_ids) || in_array('4',$role_resources_ids) || in_array('11',$role_resources_ids) || in_array('9',$role_resources_ids) || in_array('96',$role_resources_ids)){?>
   <li class="sidenav-item <?php if(!empty($arr_mod['prshn_active']))echo $arr_mod['prshn_active'];?>">
    <a href="<?php echo site_url('admin/perusahaan/');?>" class="sidenav-link">
      <i class="sidenav-icon ion ion-md-business"></i>
      <div><?php echo $this->lang->line('left_organization');?></div>
    </a>
  </li>
<?php } ?>   
<?php  if(in_array('27',$role_resources_ids) || in_array('28',$role_resources_ids) || in_array('29',$role_resources_ids) || in_array('30',$role_resources_ids) || in_array('31',$role_resources_ids) || in_array('8',$role_resources_ids) || in_array('423',$role_resources_ids) || in_array('46',$role_resources_ids) || in_array('401',$role_resources_ids)) {?>
  <li class="sidenav-item <?php if(!empty($arr_mod['attnd_active']))echo $arr_mod['attnd_active'];?>">
    <a href="<?php echo site_url('admin/timesheet/dashboard_kehadiran');?>" class="sidenav-link">
      <i class="sidenav-icon ion ion-md-clock"></i>
      <div><?php echo $this->lang->line('left_timesheet');?></div>
    </a>
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
<?php if(in_array('45',$role_resources_ids)) { ?>
  <li class="sidenav-item <?php if(!empty($arr_mod['tugas_active']))echo $arr_mod['tugas_active'];?>">
    <a href="<?php echo site_url('admin/timesheet/tugass');?>" class="sidenav-link">
      <i class="sidenav-icon fab fa-fantasy-flight-games"></i>
      <div><?php echo $this->lang->line('left_tugass');?></div>
    </a>
  </li>
<?php } ?>
<?php if(in_array('47',$role_resources_ids)) { ?>
 <li class="sidenav-item <?php if(!empty($arr_mod['file_active']))echo $arr_mod['file_active'];?>">
  <a href="<?php echo site_url('admin/files/');?>" class="sidenav-link">
    <i class="sidenav-icon fas fa-file-signature"></i>
    <div><?php echo $this->lang->line('umb_files');?></div>
  </a>
</li>
<?php } ?>  
<?php  if(in_array('44',$role_resources_ids) || in_array('45',$role_resources_ids) || in_array('104',$role_resources_ids) || in_array('122',$role_resources_ids) || in_array('121',$role_resources_ids) || in_array('330',$role_resources_ids) || in_array('312',$role_resources_ids)) {?>
  <li class="sidenav-item <?php if(!empty($arr_mod['hr_all_inv_active']))echo $arr_mod['hr_all_inv_active'];?>">
    <a href="<?php echo site_url('admin/invoices');?>" class="sidenav-link">
      <i class="sidenav-icon fas fa-file-invoice-dollar"></i>
      <div><?php echo $this->lang->line('umb_invoices_title');?></div>
    </a>
  </li>
<?php } ?>
<?php if(in_array('46',$role_resources_ids)) { ?>
  <li class="sidenav-item <?php if(!empty($arr_mod['cuti_active']))echo $arr_mod['cuti_active'];?>">
    <a href="<?php echo site_url('admin/timesheet/cuti');?>" class="sidenav-link">
      <i class="sidenav-icon fas fa-calendar-alt"></i>
      <div><?php echo $this->lang->line('umb_manage_cutii');?></div>
    </a>
  </li>
<?php } ?>

<?php if(in_array('44',$role_resources_ids)) { ?>
  <li class="sidenav-item <?php if(!empty($arr_mod['project_active']))echo $arr_mod['project_active'];?>">
    <a href="<?php echo site_url('admin/project/dashboard_projects');?>" class="sidenav-link">
      <i class="sidenav-icon ion ion-logo-buffer"></i>
      <div><?php echo $this->lang->line('umb_projects_manager_title');?></div>
    </a>
  </li>
<?php } ?>
<?php  if(in_array('87',$role_resources_ids) || in_array('119',$role_resources_ids) || in_array('410',$role_resources_ids) || in_array('415',$role_resources_ids) || in_array('121',$role_resources_ids) || in_array('330',$role_resources_ids)) {?>
  <li class="sidenav-item <?php if(!empty($arr_mod['hr_all_quotes_active']))echo $arr_mod['hr_all_quotes_active'];?>">
    <a href="<?php echo site_url('admin/quotes');?>" class="sidenav-link">
      <i class="sidenav-icon fa fa-tasks"></i>
      <div><?php echo $this->lang->line('umb_estimates');?></div>
    </a>
  </li>
<?php } ?>

<?php if($system[0]->module_recruitment=='true'){?>
  <?php  if(in_array('48',$role_resources_ids) || in_array('49',$role_resources_ids) || in_array('51',$role_resources_ids) || in_array('52',$role_resources_ids)) {?>
    <li class="sidenav-item <?php if(!empty($arr_mod['post_pkrj_active']))echo $arr_mod['post_pkrj_active'];?>">
      <a href="<?php echo site_url('admin/post_pekerjaan');?>" class="sidenav-link">
        <i class="sidenav-icon fas fa-newspaper"></i>
        <div><?php echo $this->lang->line('left_recruitment');?></div>
      </a>
    </li>
  <?php } ?> 
<?php } ?> 
<?php if($system[0]->module_performance=='yes'){?>
  <?php if($system[0]->performance_option == 'goal'): ?>
   <?php  if(in_array('106',$role_resources_ids) || in_array('107',$role_resources_ids) || in_array('108',$role_resources_ids)) {?>
    <li class="sidenav-item <?php if(!empty($arr_mod['performance_active']))echo $arr_mod['performance_active'];?>">
      <a href="<?php echo site_url('admin/tujuan_tracking/');?>" class="sidenav-link">
        <i class="sidenav-icon fas fa-cube"></i>
        <div><?php echo $this->lang->line('left_performance');?></div>
      </a>
    </li>
  <?php } ?>
  <?php else:?>
    <?php  if(in_array('40',$role_resources_ids) || in_array('41',$role_resources_ids) || in_array('42',$role_resources_ids)) {?>
      <li class="sidenav-item <?php if(!empty($arr_mod['performance_active']))echo $arr_mod['performance_active'];?>">
        <a href="<?php echo site_url('admin/performance_appraisal/');?>" class="sidenav-link">
          <i class="sidenav-icon fas fa-cube"></i>
          <div><?php echo $this->lang->line('left_performance');?></div>
        </a>
      </li>
    <?php } ?>
  <?php endif;?>
<?php } ?>
</ul>

