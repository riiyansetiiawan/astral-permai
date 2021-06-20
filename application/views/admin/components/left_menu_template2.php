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
<section class="sidebar">
  <!-- Sidebar user panel -->
  
  <div class="user-panel">
    <div class="pull-left image"> <img src="<?php echo $cpimg;?>" class="img-circle" alt="User Image"> </div>
    <div class="pull-left info">
      <p><?php echo $user_info[0]->first_name. ' '.$user_info[0]->last_name;?></p>
      <a href="#"><i class="fa fa-circle text-success"></i> Online</a> </div>
  </div>
  <!-- sidebar menu: : style can be found in sidebar.less -->
  <ul class="sidebar-menu" data-widget="tree">
    <li class="header nav-small-cap"><?php echo $this->lang->line('dashboard_main');?></li>
    <li class="<?php if(!empty($arr_mod['active']))echo $arr_mod['active'];?>"> 
        <a href="<?php echo site_url('admin/dashboard');?>"> 
            <i class="fa fa-dashboard"></i> 
            <span><?php echo $this->lang->line('dashboard_title');?></span> 
        </a> 
    </li>
    <?php if(in_array('13',$role_resources_ids) || in_array('88',$role_resources_ids) || in_array('92',$role_resources_ids) || in_array('22',$role_resources_ids) || in_array('23',$role_resources_ids) || in_array('393',$role_resources_ids)  || in_array('400',$role_resources_ids) || $user_info[0]->user_role_id==1){?>
        <li class="<?php if(!empty($arr_mod['stff_open']))echo $arr_mod['stff_open'];?> treeview"> 
            <a href="#"> 
                <i class="fa fa-user"></i> 
                <span><?php echo $this->lang->line('let_staff');?></span> 
                <span class="pull-right-container"> 
                    <i class="fa fa-angle-left pull-right"></i> 
                </span> 
            </a>
            <ul class="treeview-menu">
                <?php if(in_array('13',$role_resources_ids)) { ?>
                    <li class="<?php if(!empty($arr_mod['emp_active']))echo $arr_mod['emp_active'];?>">
                        <a href="<?php echo site_url('admin/karyawans');?>">
                            <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('dashboard_karyawans');?>
                        </a>
                    </li>
                <?php } ?>
                <?php if($user_info[0]->user_role_id==1) { ?>
                    <li class="<?php if(!empty($arr_mod['roles_active']))echo $arr_mod['roles_active'];?>">
                        <a href="<?php echo site_url('admin/roles');?>">
                            <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('umb_role_urole');?>
                        </a>
                    </li>
                <?php } ?>
                <?php if(in_array('393',$role_resources_ids)) { ?>
                    <li class="<?php if(!empty($arr_mod['custom_fields_active']))echo $arr_mod['custom_fields_active'];?>">
                        <a href="<?php echo site_url('admin/custom_fields');?>">
                            <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('umb_hrastral_custom_fields');?>
                        </a>
                    </li>
                <?php } ?>
                <?php if(in_array('88',$role_resources_ids)) { ?>
                    <li class="<?php if(!empty($arr_mod['hrkrywn_active']))echo $arr_mod['hrkrywn_active'];?>">
                        <a href="<?php echo site_url('admin/karyawans/hr');?>">
                            <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('left_directory_karyawans');?>
                        </a>
                    </li>
                <?php } ?>
                <?php if(in_array('92',$role_resources_ids)) { ?>
                    <li class="<?php if(!empty($arr_mod['importkrywn_active']))echo $arr_mod['importkrywn_active'];?>">
                        <a href="<?php echo site_url('admin/karyawans/import');?>">
                            <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('umb_import_karyawans');?>
                        </a>
                    </li>
                <?php } ?>
                <?php if(in_array('23',$role_resources_ids)) { ?>
                    <li class="<?php if(!empty($arr_mod['krywn_ex_active']))echo $arr_mod['krywn_ex_active'];?>">
                        <a href="<?php echo site_url('admin/karyawan_exit');?>">
                            <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('left_karyawans_exit');?>
                        </a>
                    </li>
                <?php } ?>
                <?php if(in_array('400',$role_resources_ids)) { ?>
                    <li class="<?php if(!empty($arr_mod['exp_doc_active']))echo $arr_mod['exp_doc_active'];?>">
                        <a href="<?php echo site_url('admin/karyawans/documents_kadaluarsa');?>">
                            <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('umb_e_details_exp_documents');?>
                        </a>
                    </li>
                <?php } ?>
                <?php if(in_array('22',$role_resources_ids)) { ?>
                    <li class="<?php if(!empty($arr_mod['krywn_ter_lgn_active']))echo $arr_mod['krywn_ter_lgn_active'];?>">
                        <a href="<?php echo site_url('admin/karyawans_terakhir_login');?>">
                            <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('left_karyawans_terakhir_login');?>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </li>
    <?php } ?>
    <?php  if(in_array('12',$role_resources_ids) || in_array('14',$role_resources_ids) || in_array('15',$role_resources_ids) || in_array('16',$role_resources_ids) || in_array('17',$role_resources_ids) || in_array('18',$role_resources_ids) || in_array('19',$role_resources_ids) || in_array('20',$role_resources_ids) || in_array('21',$role_resources_ids)){?>
        <li class="<?php if(!empty($arr_mod['krywn_open']))echo $arr_mod['krywn_open'];?> treeview"> 
            <a href="#"> 
                <i class="fa fa-futbol-o"></i> 
                <span><?php echo $this->lang->line('umb_hr');?></span> 
                <span class="pull-right-container"> 
                    <i class="fa fa-angle-left pull-right"></i> 
                </span> 
            </a>
            <ul class="treeview-menu">
                <?php if($system[0]->module_awards=='true'){?>
                    <?php if(in_array('14',$role_resources_ids)) { ?>
                        <li class="sidenav-link <?php if(!empty($arr_mod['award_active']))echo $arr_mod['award_active'];?>"> 
                            <a href="<?php echo site_url('admin/awards');?>" > 
                                <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('left_awards');?> 
                            </a> 
                        </li>
                    <?php } ?>
                <?php } ?>
                <?php if(in_array('15',$role_resources_ids)) { ?>
                    <li class="sidenav-link <?php if(!empty($arr_mod['tra_active']))echo $arr_mod['tra_active'];?>"> 
                        <a href="<?php echo site_url('admin/transfers');?>" > 
                            <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('left_transfers');?> 
                        </a> 
                    </li>
                <?php } ?>
                <?php if(in_array('16',$role_resources_ids)) { ?>
                    <li class="sidenav-link <?php if(!empty($arr_mod['pngndr_dr_active']))echo $arr_mod['pngndr_dr_active'];?>"> 
                        <a href="<?php echo site_url('admin/pengunduran_diri');?>" > 
                            <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('left_pengundurans_diri');?> 
                        </a> 
                    </li>
                <?php } ?>
                <?php if($system[0]->module_perjalanan=='true'){?>
                    <?php if(in_array('17',$role_resources_ids)) { ?>
                        <li class="sidenav-link <?php if(!empty($arr_mod['prjln_active']))echo $arr_mod['prjln_active'];?>"> 
                            <a href="<?php echo site_url('admin/perjalanan');?>"> 
                                <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('left_perjalanans');?> 
                            </a> 
                        </li>
                    <?php } ?>
                <?php } ?>
                <?php if(in_array('18',$role_resources_ids)) { ?>
                    <li class="sidenav-link <?php if(!empty($arr_mod['pro_active']))echo $arr_mod['pro_active'];?>"> 
                        <a href="<?php echo site_url('admin/promotion');?>"> 
                            <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('left_promotions');?> 
                        </a> 
                    </li>
                <?php } ?>
                <?php if(in_array('19',$role_resources_ids)) { ?>
                    <li class="sidenav-link <?php if(!empty($arr_mod['keluh_active']))echo $arr_mod['keluh_active'];?>"> 
                        <a href="<?php echo site_url('admin/keluhans');?>"> 
                            <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('left_keluhans');?> 
                        </a> 
                    </li>
                <?php } ?>
                <?php if(in_array('20',$role_resources_ids)) { ?>
                    <li class="sidenav-link <?php if(!empty($arr_mod['prgtn_active']))echo $arr_mod['prgtn_active'];?>"> 
                        <a href="<?php echo site_url('admin/peringatan');?>"> 
                            <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('left_peringatans');?> 
                        </a> 
                    </li>
                <?php } ?>
                <?php if(in_array('21',$role_resources_ids)) { ?>
                    <li class="sidenav-link <?php if(!empty($arr_mod['term_active']))echo $arr_mod['term_active'];?>"> 
                        <a href="<?php echo site_url('admin/penghentian');?>"> 
                            <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('left_penghentians');?> 
                        </a> 
                    </li>
                <?php } ?>
            </ul>
        </li>
    <?php } ?>
    <?php  if(in_array('2',$role_resources_ids) || in_array('3',$role_resources_ids) || in_array('5',$role_resources_ids) || in_array('6',$role_resources_ids) || in_array('4',$role_resources_ids) || in_array('11',$role_resources_ids) || in_array('9',$role_resources_ids) || in_array('96',$role_resources_ids)){?>
        <li class="<?php if(!empty($arr_mod['adm_open']))echo $arr_mod['adm_open'];?> treeview"> 
            <a href="#"> 
                <i class="fa fa-building"></i> 
                <span><?php echo $this->lang->line('left_organization');?></span> 
                <span class="pull-right-container"> 
                    <i class="fa fa-angle-left pull-right"></i> 
                </span> 
            </a>
            <ul class="treeview-menu">
                <?php if(in_array('5',$role_resources_ids)) { ?>
                    <li class="sidenav-link <?php if(!empty($arr_mod['prshn_active']))echo $arr_mod['prshn_active'];?>">
                        <a href="<?php echo site_url('admin/perusahaan')?>">
                            <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('left_perusahaan');?>
                        </a>
                    </li>
                    <li class="sidenav-link <?php if(!empty($arr_mod['documents_resmi_active']))echo $arr_mod['documents_resmi_active'];?>">
                        <a href="<?php echo site_url('admin/perusahaan/documents_resmi')?>">
                            <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('umb_hr_documents_resmi');?>
                        </a>
                    </li>
                <?php } ?>
                <?php if(in_array('6',$role_resources_ids)) { ?>
                    <li class="sidenav-link <?php if(!empty($arr_mod['lok_active']))echo $arr_mod['lok_active'];?>">
                        <a href="<?php echo site_url('admin/location');?>">
                            <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('left_location');?>
                        </a>
                    </li>
                <?php } ?>
                <?php if(in_array('3',$role_resources_ids)) { ?>
                    <li class="sidenav-link <?php if(!empty($arr_mod['dep_active']))echo $arr_mod['dep_active'];?>">
                        <a href="<?php echo site_url('admin/department');?>">
                            <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('left_department');?>
                        </a>
                    </li>
                <?php } ?>
                <?php if(in_array('3',$role_resources_ids)) { ?>
                    <li class="sidenav-link <?php if(!empty($arr_mod['sub_departments_active']))echo $arr_mod['sub_departments_active'];?>">
                        <a href="<?php echo site_url('admin/department/sub_departments');?>">
                            <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('umb_hr_sub_departments');?>
                        </a>
                    </li>
                <?php } ?>
                <?php if(in_array('4',$role_resources_ids)) { ?>
                    <li class="sidenav-link <?php if(!empty($arr_mod['des_active']))echo $arr_mod['des_active'];?>">
                        <a href="<?php echo site_url('admin/penunjukan');?>">
                            <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('left_penunjukan');?>
                        </a>
                    </li>
                <?php } ?>
                <?php if(in_array('11',$role_resources_ids)) { ?>
                    <li class="sidenav-link <?php if(!empty($arr_mod['pngmmn_active']))echo $arr_mod['pngmmn_active'];?>">
                        <a href="<?php echo site_url('admin/pengumuman');?>">
                            <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('left_pengumumans');?>
                        </a>
                    </li>
                <?php } ?>
                <?php if(in_array('9',$role_resources_ids)) { ?>
                    <li class="sidenav-link <?php if(!empty($arr_mod['kbjk_active']))echo $arr_mod['kbjk_active'];?>">
                        <a href="<?php echo site_url('admin/kebijakan');?>">
                            <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('left_kebijakans');?>
                        </a>
                    </li>
                <?php } ?>
                <?php if($system[0]->module_orgchart=='true'){?>
                    <?php if(in_array('96',$role_resources_ids)) { ?>
                        <li class="sidenav-link <?php if(!empty($arr_mod['org_chart_active']))echo $arr_mod['org_chart_active'];?>">
                            <a href="<?php echo site_url('admin/organization/chart');?>">
                                <i class="fa <?php echo $submenuicon;?>"></i><?php echo $this->lang->line('umb_org_chart_lnk');?>
                            </a>
                        </li>
                    <?php } ?>
                <?php } ?>
            </ul>
        </li>
    <?php } ?>
    <?php  if(in_array('27',$role_resources_ids) || in_array('28',$role_resources_ids) || in_array('29',$role_resources_ids) || in_array('30',$role_resources_ids) || in_array('31',$role_resources_ids) || in_array('7',$role_resources_ids) || in_array('8',$role_resources_ids) || in_array('46',$role_resources_ids) || in_array('401',$role_resources_ids)) {?>
        <li class="<?php if(!empty($arr_mod['attnd_open']))echo $arr_mod['attnd_open'];?> treeview"> 
            <a href="#"> 
                <i class="fa fa-clock-o"></i> 
                <span><?php echo $this->lang->line('left_timesheet');?></span> 
                <span class="pull-right-container"> 
                    <i class="fa fa-angle-left pull-right"></i> 
                </span> 
            </a>
            <ul class="treeview-menu">
                <?php if(in_array('28',$role_resources_ids)) { ?>
                    <li class="sidenav-link <?php if(!empty($arr_mod['attnd_active']))echo $arr_mod['attnd_active'];?>"> 
                        <a href="<?php echo site_url('admin/timesheet/kehadiran');?>"> 
                            <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('left_kehadiran');?> 
                        </a> 
                    </li>
                <?php } ?>
                <?php if(in_array('10',$role_resources_ids)) { ?>
                    <li class="sidenav-link <?php if(!empty($arr_mod['timesheet_active']))echo $arr_mod['timesheet_active'];?>"> 
                        <a href="<?php echo site_url('admin/timesheet/');?>"> 
                            <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('umb_month_timesheet_title');?> 
                        </a> 
                    </li>
                <?php } ?>
                <?php if(in_array('261',$role_resources_ids)) { ?>
                    <li class="sidenav-link <?php if(!empty($arr_mod['timecalendar_active']))echo $arr_mod['timecalendar_active'];?>"> 
                        <a href="<?php echo site_url('admin/timesheet/timecalendar/');?>"> 
                            <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('umb_kehadiran_waktucalendar');?> 
                        </a> 
                    </li>
                <?php } ?>
                <?php if(in_array('29',$role_resources_ids)) { ?>
                    <li class="sidenav-link <?php if(!empty($arr_mod['dtwise_attnd_active']))echo $arr_mod['dtwise_attnd_active'];?>"> 
                        <a href="<?php echo site_url('admin/timesheet/tanggal_bijaksana_kehadiran');?>"> 
                            <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('left_tanggal_bijaksana_kehadiran');?> 
                        </a> 
                    </li>
                <?php } ?>
                <?php if(in_array('30',$role_resources_ids)) { ?>
                    <li class="sidenav-link <?php if(!empty($arr_mod['upd_attnd_active']))echo $arr_mod['upd_attnd_active'];?>"> 
                        <a href="<?php echo site_url('admin/timesheet/update_kehadiran');?>"> 
                            <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('left_update_kehadiran');?> 
                        </a> 
                    </li>
                <?php } ?>
                <?php if(in_array('401',$role_resources_ids)) { ?>
                    <li class="<?php if(!empty($arr_mod['permintaan_lembur_act']))echo $arr_mod['permintaan_lembur_act'];?>">
                        <a href="<?php echo site_url('admin/permintaan_lembur');?>">
                            <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('umb_permintaan_lembur');?>
                        </a>
                    </li>
                <?php } ?>
                <?php if(in_array('31',$role_resources_ids)) { ?>
                    <li class="sidenav-link <?php if(!empty($arr_mod['import_khdrn_active']))echo $arr_mod['import_khdrn_active'];?>"> 
                        <a href="<?php echo site_url('admin/timesheet/import');?>"> 
                            <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('left_import_kehadiran');?> 
                        </a> 
                    </li>
                <?php } ?>
                <?php if(in_array('7',$role_resources_ids)) { ?>
                    <li class="sidenav-link <?php if(!empty($arr_mod['offsh_active']))echo $arr_mod['offsh_active'];?>"> 
                        <a href="<?php echo site_url('admin/timesheet/shift_kantor');?>"> 
                            <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('left_shifts_kantor');?> 
                        </a> 
                    </li>
                <?php } ?>
                <?php if(in_array('8',$role_resources_ids)) { ?>
                    <li class="sidenav-link <?php if(!empty($arr_mod['lbr_active']))echo $arr_mod['lbr_active'];?>"> 
                        <a href="<?php echo site_url('admin/timesheet/liburan');?>"> 
                            <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('umb_manage_liburan');?> 
                        </a> 
                    </li>
                <?php } ?>
                <?php if(in_array('46',$role_resources_ids)) { ?>
                    <li class="sidenav-link <?php if(!empty($arr_mod['cuti_active']))echo $arr_mod['cuti_active'];?>"> 
                        <a href="<?php echo site_url('admin/timesheet/cuti');?>"> 
                            <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('umb_manage_cutii');?> 
                        </a> 
                    </li>
                <?php } ?>
            </ul>
        </li>
    <?php } ?>
    <?php if($system[0]->module_payroll=='yes'){?>
        <?php  if(in_array('32',$role_resources_ids) || in_array('33',$role_resources_ids) || in_array('34',$role_resources_ids) || in_array('35',$role_resources_ids) || in_array('36',$role_resources_ids) || in_array('37',$role_resources_ids) || in_array('38',$role_resources_ids) || in_array('39',$role_resources_ids)) {?>
            <li class="<?php if(!empty($arr_mod['payrl_open']))echo $arr_mod['payrl_open'];?> treeview"> 
                <a href="#"> 
                    <i class="fa fa-calculator"></i> 
                    <span><?php echo $this->lang->line('left_payroll');?></span> 
                    <span class="pull-right-container"> 
                        <i class="fa fa-angle-left pull-right"></i> 
                    </span> 
                </a>
                <ul class="treeview-menu">
                    <?php if(in_array('36',$role_resources_ids)) { ?>
                        <li class="sidenav-link <?php if(!empty($arr_mod['pay_generate_active']))echo $arr_mod['pay_generate_active'];?>"> 
                            <a href="<?php echo site_url('admin/payroll/generate_slipgaji');?>"> 
                                <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('left_generate_slipgaji');?> 
                            </a> 
                        </li>
                    <?php } ?>
                    <?php if(in_array('37',$role_resources_ids)) { ?>
                        <li class="sidenav-link <?php if(!empty($arr_mod['pay_his_active']))echo $arr_mod['pay_his_active'];?>"> 
                            <a href="<?php echo site_url('admin/payroll/history_pembayaran');?>"> 
                                <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('left_history_pembayaran');?> 
                            </a> 
                        </li>
                    <?php } ?>
                </ul>
            </li>
        <?php } ?>
    <?php } ?>
    <?php if($system[0]->module_training=='true'){?>
        <?php  if(in_array('53',$role_resources_ids) || in_array('54',$role_resources_ids) || in_array('55',$role_resources_ids) || in_array('56',$role_resources_ids)) {?>
            <li class="<?php if(!empty($arr_mod['training_open']))echo $arr_mod['training_open'];?> treeview"> 
                <a href="#"> 
                    <i class="fa fa-graduation-cap"></i> 
                    <span><?php echo $this->lang->line('left_training');?></span> 
                    <span class="pull-right-container"> 
                        <i class="fa fa-angle-left pull-right"></i> 
                    </span> 
                </a>
                <ul class="treeview-menu">
                    <?php if(in_array('54',$role_resources_ids)) { ?>
                        <li class="sidenav-link <?php if(!empty($arr_mod['training_active']))echo $arr_mod['training_active'];?>"> 
                            <a href="<?php echo site_url('admin/training');?>"> 
                                <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('left_list_training');?> 
                            </a> 
                        </li>
                    <?php } ?>
                    <?php if(in_array('55',$role_resources_ids)) { ?>
                        <li class="sidenav-link <?php if(!empty($arr_mod['type_training_active']))echo $arr_mod['type_training_active'];?>"> 
                            <a href="<?php echo site_url('admin/type_training');?>"> 
                                <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('left_type_training');?> 
                            </a> 
                        </li>
                    <?php } ?>
                    <?php if(in_array('56',$role_resources_ids)) { ?>
                        <li class="sidenav-link <?php if(!empty($arr_mod['trainers_active']))echo $arr_mod['trainers_active'];?>"> 
                            <a href="<?php echo site_url('admin/trainers');?>"> 
                                <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('left_list_trainers');?> 
                            </a> 
                        </li>
                    <?php } ?>
                </ul>
            </li>
        <?php } ?>
    <?php } ?>
    <?php if($system[0]->module_performance=='yes'){?>
        <?php  if(in_array('40',$role_resources_ids) || in_array('41',$role_resources_ids) || in_array('42',$role_resources_ids) || in_array('107',$role_resources_ids) || in_array('108',$role_resources_ids) || in_array('372',$role_resources_ids) || in_array('373',$role_resources_ids)) {?>
            <li class="<?php if(!empty($arr_mod['performance_open']))echo $arr_mod['performance_open'];?> treeview"> 
                <a href="#"> 
                    <i class="fa fa-cube"></i> 
                    <span><?php echo $this->lang->line('left_performance');?></span> 
                    <span class="pull-right-container"> 
                        <i class="fa fa-angle-left pull-right"></i> 
                    </span> 
                </a>
                <ul class="treeview-menu">
                    <?php if(in_array('41',$role_resources_ids)) { ?>
                        <li class="sidenav-link <?php if(!empty($arr_mod['per_indi_active']))echo $arr_mod['per_indi_active'];?>"> 
                            <a href="<?php echo site_url('admin/performance_indicator');?>"> 
                                <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('left_performance_xindicator');?> 
                            </a> 
                        </li>
                    <?php } ?>
                    <?php if(in_array('42',$role_resources_ids)) { ?>
                        <li class="sidenav-link <?php if(!empty($arr_mod['per_app_active']))echo $arr_mod['per_app_active'];?>"> 
                            <a href="<?php echo site_url('admin/performance_appraisal');?>"> 
                                <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('left_performance_xappraisal');?> 
                            </a> 
                        </li>
                    <?php } ?>
                    <?php if(in_array('107',$role_resources_ids)) { ?>
                        <li class="sidenav-link <?php if(!empty($arr_mod['tujuan_tracking_active']))echo $arr_mod['tujuan_tracking_active'];?>"> 
                            <a href="<?php echo site_url('admin/tujuan_tracking');?>"> 
                                <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('umb_hr_tujuan_tracking');?> 
                            </a> 
                        </li>
                    <?php } ?>
                    <?php if(in_array('108',$role_resources_ids)) { ?>
                        <li class="sidenav-link <?php if(!empty($arr_mod['type_tujuan_tracking_active']))echo $arr_mod['type_tujuan_tracking_active'];?>"> 
                            <a href="<?php echo site_url('admin/tujuan_tracking/type');?>"> 
                                <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('umb_hr_type_tujuan_tracking_se');?> 
                            </a> 
                        </li>
                    <?php } ?>
                </ul>
            </li>
        <?php } ?>
    <?php } ?>
    <?php if(in_array('95',$role_resources_ids)) { ?>
        <li class="<?php if(!empty($arr_mod['calendar_hr_active']))echo $arr_mod['calendar_hr_active'];?>"> 
            <a href="<?php echo site_url('admin/calendar/hr');?>"> 
                <i class="fa fa-calendar"></i> 
                <span><?php echo $this->lang->line('umb_hr_calendar_title');?></span> 
            </a> 
        </li>
    <?php } ?>
    <?php if($system[0]->module_inquiry=='true'){?>
        <?php if(in_array('43',$role_resources_ids)) { ?>
            <li class="<?php if(!empty($arr_mod['ticket_active']))echo $arr_mod['ticket_active'];?>"> 
                <a href="<?php echo site_url('admin/tickets');?>"> 
                    <i class="fa fa-ticket"></i> 
                    <span><?php echo $this->lang->line('left_tickets');?></span> 
                </a> 
            </li>
        <?php } ?>
    <?php } ?>
    <?php if($system[0]->module_recruitment=='true'){?>
        <?php  if(in_array('48',$role_resources_ids) || in_array('49',$role_resources_ids) || in_array('51',$role_resources_ids) || in_array('52',$role_resources_ids)) {?>
            <li class="<?php if(!empty($arr_mod['recruit_open']))echo $arr_mod['recruit_open'];?> treeview"> 
                <a href="#"> 
                    <i class="fa fa-newspaper-o"></i> 
                    <span><?php echo $this->lang->line('left_recruitment');?></span> 
                    <span class="pull-right-container"> 
                        <i class="fa fa-angle-left pull-right"></i> 
                    </span> 
                </a>
                <ul class="treeview-menu">
                    <?php if(in_array('49',$role_resources_ids)) { ?>
                        <li class="sidenav-link <?php if(!empty($arr_mod['post_pkrj_active']))echo $arr_mod['post_pkrj_active'];?>"> 
                            <a href="<?php echo site_url('admin/post_pekerjaan');?>"> 
                                <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('left_post_pekerjaan');?> 
                            </a> 
                        </li>
                    <?php } ?>
                    <?php if(in_array('51',$role_resources_ids)) { ?>
                        <li class="sidenav-link <?php if(!empty($arr_mod['knddt_pkrj_active']))echo $arr_mod['knddt_pkrj_active'];?>"> 
                            <a href="<?php echo site_url('admin/kandidats_pekerjaan');?>"> 
                                <i class="fa <?php echo $submenuicon;?>"></i>
                                <?php if(in_array('387',$role_resources_ids)) { ?>
                                    <?php echo $this->lang->line('left_applied_pekerjaans');?>
                                <?php } else {?>
                                    <?php echo $this->lang->line('left_kandidats_pekerjaan');?>
                                <?php } ?>
                            </a> 
                        </li>
                    <?php } ?>
                    <?php if(in_array('52',$role_resources_ids)) { ?>
                        <li class="sidenav-link <?php if(!empty($arr_mod['jb_int_active']))echo $arr_mod['jb_int_active'];?>"> 
                            <a href="<?php echo site_url('admin/interviews_pekerjaan');?>"> 
                                <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('left_interviews_pekerjaan');?> 
                            </a> 
                        </li>
                    <?php } ?>
                    <li class="sidenav-link <?php if(!empty($arr_mod['jb_krywn_active']))echo $arr_mod['jb_krywn_active'];?>"> 
                        <a href="<?php echo site_url('admin/post_pekerjaan/employer');?>"> 
                            <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('umb_employer_pekerjaans');?> 
                        </a> 
                    </li>
                    <li class="sidenav-link <?php if(!empty($arr_mod['pages_pkrj_active']))echo $arr_mod['pages_pkrj_active'];?>"> 
                        <a href="<?php echo site_url('admin/post_pekerjaan/pages');?>"> 
                            <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('umb_cms_pages_pekerjaans');?> 
                        </a> 
                    </li>
                </ul>
            </li>
        <?php } ?>
    <?php } ?>
    <?php if($system[0]->module_files=='true'){?>
        <?php if(in_array('47',$role_resources_ids)) { ?>
            <li class="<?php if(!empty($arr_mod['file_active']))echo $arr_mod['file_active'];?>"> 
                <a href="<?php echo site_url('admin/files');?>"> 
                    <i class="fa fa-file-text-o"></i> 
                    <span><?php echo $this->lang->line('umb_files_manager');?></span> 
                </a> 
            </li>
        <?php } ?>
    <?php } ?>
    <?php //if($system[0]->module_projects_tugass=='true'){?>
        <?php  if(in_array('44',$role_resources_ids) || in_array('45',$role_resources_ids) || in_array('104',$role_resources_ids) || in_array('119',$role_resources_ids) || in_array('120',$role_resources_ids) || in_array('121',$role_resources_ids) || in_array('122',$role_resources_ids) || in_array('330',$role_resources_ids)) {?>
            <li class="<?php if(!empty($arr_mod['project_open']))echo $arr_mod['project_open'];?> treeview"> 
                <a href="#"> 
                    <i class="fa fa-tasks"></i> 
                    <span><?php echo $this->lang->line('umb_project_manager_title');?></span> 
                    <span class="pull-right-container"> 
                        <i class="fa fa-angle-left pull-right"></i> 
                    </span> 
                </a>
                <ul class="treeview-menu">
                    <?php if(in_array('44',$role_resources_ids)) { ?>
                        <li class="sidenav-link <?php if(!empty($arr_mod['project_active']))echo $arr_mod['project_active'];?>"> 
                            <a href="<?php echo site_url('admin/project');?>"> 
                                <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('left_projects');?> 
                            </a> 
                        </li>
                    <?php } ?>
                    <?php if(in_array('45',$role_resources_ids)) { ?>
                        <li class="sidenav-link <?php if(!empty($arr_mod['tugas_active']))echo $arr_mod['tugas_active'];?>"> 
                            <a href="<?php echo site_url('admin/timesheet/tugass');?>"> 
                                <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('left_tugass');?> 
                            </a> 
                        </li>
                    <?php } ?>
                    <?php if(in_array('119',$role_resources_ids)) { ?>
                        <li class="sidenav-link <?php if(!empty($arr_mod['hr_clients_active']))echo $arr_mod['hr_clients_active'];?>"> 
                            <a href="<?php echo site_url('admin/clients');?>"> 
                                <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('umb_project_clients');?> 
                            </a> 
                        </li>
                    <?php } ?>
                    <?php if(in_array('121',$role_resources_ids)) { ?>
                        <li class="sidenav-link <?php if(!empty($arr_mod['hr_all_inv_active']))echo $arr_mod['hr_all_inv_active'];?>"> 
                            <a href="<?php echo site_url('admin/invoices/');?>"> 
                                <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('umb_invoices_title');?> 
                            </a> 
                        </li>
                    <?php } ?>
                    <?php if(in_array('330',$role_resources_ids)) { ?>
                        <li class="sidenav-link <?php if(!empty($arr_mod['hr_client_invoices_pay_active']))echo $arr_mod['hr_client_invoices_pay_active'];?>"> 
                            <a href="<?php echo site_url('admin/invoices/history_pembayarans');?>"> 
                                <i class="fa <?php echo $submenuicon;?>"></i><?php echo $this->lang->line('umb_acc_pembayarans_invoice');?> 
                            </a> 
                        </li>
                    <?php } ?>
                    <?php if(in_array('122',$role_resources_ids)) { ?>
                        <li class="sidenav-link <?php if(!empty($arr_mod['hr_pajaks_inv_active']))echo $arr_mod['hr_pajaks_inv_active'];?>"> 
                            <a href="<?php echo site_url('admin/invoices/pajaks/');?>"> 
                                <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('umb_invoice_type_pajak');?> 
                            </a> 
                        </li>
                    <?php } ?>
                </ul>
            </li>
            <?php //} ?>
        <?php } ?>
        <?php if(in_array('71',$role_resources_ids) || in_array('72',$role_resources_ids) || in_array('73',$role_resources_ids) || in_array('74',$role_resources_ids) || in_array('75',$role_resources_ids) || in_array('76',$role_resources_ids) || in_array('77',$role_resources_ids) || in_array('78',$role_resources_ids) || in_array('79',$role_resources_ids) || in_array('80',$role_resources_ids) || in_array('81',$role_resources_ids) || in_array('82',$role_resources_ids) || in_array('83',$role_resources_ids) || in_array('84',$role_resources_ids) || in_array('85',$role_resources_ids) || in_array('86',$role_resources_ids)){?>
            <li class="<?php if(!empty($arr_mod['hr_acc_open']))echo $arr_mod['hr_acc_open'];?> treeview">
                <a href="#"> 
                    <i class="fa fa-money"></i> 
                    <span><?php echo $this->lang->line('umb_hr_keuangan');?></span> 
                    <span class="pull-right-container"> 
                        <i class="fa fa-angle-left pull-right"></i> 
                    </span> 
                </a>
                <ul class="treeview-menu">
                    <?php if(in_array('72',$role_resources_ids)) { ?>
                        <li class="sidenav-link <?php if(!empty($arr_mod['hr_bank_cash_active']))echo $arr_mod['hr_bank_cash_active'];?>"> 
                            <a href="<?php echo site_url('admin/accounting/bank_cash');?>"> 
                                <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('umb_acc_list_account');?> 
                            </a> 
                        </li>
                    <?php } ?>
                    <?php if(in_array('73',$role_resources_ids)) { ?>
                        <li class="sidenav-link <?php if(!empty($arr_mod['hr_saldo_accounts_active']))echo $arr_mod['hr_saldo_accounts_active'];?>"> 
                            <a href="<?php echo site_url('admin/accounting/saldo_accounts');?>"> 
                                <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('umb_acc_saldo_accounts');?> 
                            </a> 
                        </li>
                    <?php } ?>
                    <?php if(in_array('80',$role_resources_ids)) { ?>
                        <li class="sidenav-link <?php if(!empty($arr_mod['hr_penerima_pembayarans_active']))echo $arr_mod['hr_penerima_pembayarans_active'];?>"> 
                            <a href="<?php echo site_url('admin/accounting/penerima_pembayarans');?>"> 
                                <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('umb_acc_penerima_pembayarans');?> 
                            </a> 
                        </li>
                    <?php } ?>
                    <?php if(in_array('81',$role_resources_ids)) { ?>
                        <li class="sidenav-link <?php if(!empty($arr_mod['hr_pembayars_active']))echo $arr_mod['hr_pembayars_active'];?>"> 
                            <a href="<?php echo site_url('admin/accounting/pembayars');?>"> 
                                <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('umb_acc_pembayars');?> 
                            </a> 
                        </li>
                    <?php } ?>
                    <?php if(in_array('75',$role_resources_ids)) { ?>
                        <li class="sidenav-link <?php if(!empty($arr_mod['hr_deposit_active']))echo $arr_mod['hr_deposit_active'];?>"> 
                            <a href="<?php echo site_url('admin/accounting/deposit');?>"> 
                                <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('umb_hr_new_deposit');?> 
                            </a> 
                        </li>
                    <?php } ?>
                    <?php if(in_array('76',$role_resources_ids)) { ?>
                        <li class="sidenav-link <?php if(!empty($arr_mod['hr_account_biaya_active']))echo $arr_mod['hr_account_biaya_active'];?>"> 
                            <a href="<?php echo site_url('admin/accounting/biaya');?>"> 
                                <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('umb_hr_new_biaya');?> 
                            </a> 
                        </li>
                    <?php } ?>
                    <?php if(in_array('77',$role_resources_ids)) { ?>
                        <li class="sidenav-link <?php if(!empty($arr_mod['hr_account_transfer_active']))echo $arr_mod['hr_account_transfer_active'];?>"> 
                            <a href="<?php echo site_url('admin/accounting/transfer');?>"> 
                                <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('umb_acc_transfer');?> 
                            </a> 
                        </li>
                    <?php } ?>
                    <?php if(in_array('78',$role_resources_ids)) { ?>
                        <li class="sidenav-link <?php if(!empty($arr_mod['hr_account_transaksii_active']))echo $arr_mod['hr_account_transaksii_active'];?>"> 
                            <a href="<?php echo site_url('admin/accounting/transaksii');?>" > 
                                <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('umb_acc_view_transaksi');?> 
                            </a> 
                        </li>
                    <?php } ?>
                    <?php if(in_array('83',$role_resources_ids)) { ?>
                        <li class="sidenav-link <?php if(!empty($arr_mod['hr_account_statement_active']))echo $arr_mod['hr_account_statement_active'];?>"> 
                            <a href="<?php echo site_url('admin/accounting/account_statement');?>"> 
                                <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('umb_acc_account_statement');?> 
                            </a> 
                        </li>
                    <?php } ?>
                    <?php if(in_array('82',$role_resources_ids) || in_array('83',$role_resources_ids) || in_array('84',$role_resources_ids) || in_array('85',$role_resources_ids) || in_array('86',$role_resources_ids)){?>
                        <li class="treeview"> 
                            <a href="#">
                                <i class="fa fa-circle-o"></i> <?php echo $this->lang->line('umb_acc_laporans');?> 
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i> 
                                </span> 
                            </a>
                            <ul class="treeview-menu" style="display: none;">
                                <?php if(in_array('84',$role_resources_ids)) { ?>
                                    <li class="sidenav-link <?php if(!empty($arr_mod['hr_biaya_laporan_active']))echo $arr_mod['hr_biaya_laporan_active'];?>"> 
                                        <a href="<?php echo site_url('admin/accounting/biaya_laporan');?>"> 
                                            <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('umb_acc_laporans_biaya');?> 
                                        </a> 
                                    </li>
                                <?php } ?>
                                <?php if(in_array('85',$role_resources_ids)) { ?>
                                    <li class="sidenav-link <?php if(!empty($arr_mod['hr_pendapatan_laporan_active']))echo $arr_mod['hr_pendapatan_laporan_active'];?>"> 
                                        <a href="<?php echo site_url('admin/accounting/pendapatan_laporan');?>"> 
                                            <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('umb_acc_laporans_pendapatan');?> 
                                        </a> 
                                    </li>
                                <?php } ?>
                                <?php if(in_array('86',$role_resources_ids)) { ?>
                                    <li class="sidenav-link <?php if(!empty($arr_mod['hr_transfer_laporan_active']))echo $arr_mod['hr_transfer_laporan_active'];?>"> 
                                        <a href="<?php echo site_url('admin/accounting/transfer_laporan');?>">
                                            <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('umb_acc_laporan_transfer');?> 
                                        </a> 
                                    </li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>
                </ul>
            </li>
        <?php } ?>
        <?php if($system[0]->module_assets=='true'){?>
            <?php  if(in_array('24',$role_resources_ids) || in_array('25',$role_resources_ids) || in_array('26',$role_resources_ids)) {?>
                <li class="<?php if(!empty($arr_mod['asst_open']))echo $arr_mod['asst_open'];?> treeview">
                    <a href="#"> 
                        <i class="fa fa-flask"></i> 
                        <span><?php echo $this->lang->line('umb_assets');?></span> 
                        <span class="pull-right-container"> 
                            <i class="fa fa-angle-left pull-right"></i> 
                        </span> 
                    </a>
                    <ul class="treeview-menu">
                        <?php if(in_array('25',$role_resources_ids)) { ?>
                            <li class="sidenav-link <?php if(!empty($arr_mod['asst_active']))echo $arr_mod['asst_active'];?>"> 
                                <a href="<?php echo site_url('admin/assets');?>"> 
                                    <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('umb_assets');?> 
                                </a> 
                            </li>
                        <?php } ?>
                        <?php if(in_array('26',$role_resources_ids)) { ?>
                            <li class="sidenav-link <?php if(!empty($arr_mod['kat_asst_active']))echo $arr_mod['kat_asst_active'];?>"> 
                                <a href="<?php echo site_url('admin/assets/kategori');?>"> 
                                    <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('umb_acc_kategori');?> 
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </li>
            <?php } ?>
        <?php } ?>
        <?php if($system[0]->module_events=='true'){?>
            <?php  if(in_array('97',$role_resources_ids) || in_array('98',$role_resources_ids) || in_array('99',$role_resources_ids)) {?>
                <li class="<?php if(!empty($arr_mod['hr_events_open']))echo $arr_mod['hr_events_open'];?> treeview"> 
                    <a href="#"> 
                        <i class="fa fa-calendar-plus-o"></i> 
                        <span><?php echo $this->lang->line('umb_hr_events_meetings');?></span> 
                        <span class="pull-right-container"> 
                            <i class="fa fa-angle-left pull-right"></i> 
                        </span> 
                    </a>
                    <ul class="treeview-menu">
                        <?php if(in_array('98',$role_resources_ids)) { ?>
                            <li class="sidenav-link <?php if(!empty($arr_mod['hr_events_active']))echo $arr_mod['hr_events_active'];?>"> 
                                <a href="<?php echo site_url('admin/events');?>"> 
                                    <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('umb_hr_events');?> 
                                </a> 
                            </li>
                        <?php } ?>
                        <?php if(in_array('99',$role_resources_ids)) { ?>
                            <li class="sidenav-link <?php if(!empty($arr_mod['hr_meetings_active']))echo $arr_mod['hr_meetings_active'];?>"> 
                                <a href="<?php echo site_url('admin/meetings');?>"> 
                                    <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('umb_hr_meetings');?> 
                                </a> 
                            </li>
                        <?php } ?>
                    </ul>
                </li>
            <?php } ?>
        <?php } ?>
        <?php  if(in_array('110',$role_resources_ids) || in_array('111',$role_resources_ids) || in_array('112',$role_resources_ids) || in_array('113',$role_resources_ids) || in_array('114',$role_resources_ids) || in_array('115',$role_resources_ids)) {?>
            <li class="<?php if(!empty($arr_mod['laporans_open']))echo $arr_mod['laporans_open'];?> treeview">
                <a href="#"> 
                    <i class="fa fa-bar-chart"></i> 
                    <span><?php echo $this->lang->line('umb_hr_title_laporan');?></span> 
                    <span class="pull-right-container"> 
                        <i class="fa fa-angle-left pull-right"></i> 
                    </span> 
                </a>
                <ul class="treeview-menu">
                    <?php if(in_array('111',$role_resources_ids)) { ?>
                        <li class="sidenav-link <?php if(!empty($arr_mod['laporans_slipgaji_active']))echo $arr_mod['laporans_slipgaji_active'];?>"> 
                            <a href="<?php echo site_url('admin/laporans/slipgaji');?>"> 
                                <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('umb_hr_laporans_slipgaji');?> 
                            </a> 
                        </li>
                    <?php } ?>
                    <?php if(in_array('112',$role_resources_ids)) { ?>
                        <li class="sidenav-link <?php if(!empty($arr_mod['laporans_kehadiran_karyawan_active']))echo $arr_mod['laporans_kehadiran_karyawan_active'];?>"> 
                            <a href="<?php echo site_url('admin/laporans/kehadiran_karyawan');?>"> 
                                <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('umb_hr_laporans_kehadiran_karyawan');?> 
                            </a> 
                        </li>
                    <?php } ?>
                    <?php if($system[0]->module_training=='true'){?>
                        <?php if(in_array('113',$role_resources_ids)) { ?>
                            <li class="sidenav-link <?php if(!empty($arr_mod['laporans_karyawan_training_active']))echo $arr_mod['laporans_karyawan_training_active'];?>"> 
                                <a href="<?php echo site_url('admin/laporans/karyawan_training');?>"> 
                                    <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('umb_hr_laporans_training');?> 
                                </a> 
                            </li>
                        <?php } ?>
                    <?php } ?>
                    <?php if($system[0]->module_projects_tugass=='true'){?>
                        <?php if(in_array('114',$role_resources_ids)) { ?>
                            <li class="sidenav-link <?php if(!empty($arr_mod['laporans_projects_active']))echo $arr_mod['laporans_projects_active'];?>"> 
                                <a href="<?php echo site_url('admin/laporans/projects');?>"> 
                                    <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('umb_hr_laporans_projects');?> 
                                </a> 
                            </li>
                        <?php } ?>
                        <?php if(in_array('115',$role_resources_ids)) { ?>
                            <li class="sidenav-link <?php if(!empty($arr_mod['laporans_tugass_active']))echo $arr_mod['laporans_tugass_active'];?>"> 
                                <a href="<?php echo site_url('admin/laporans/tugass');?>"> 
                                    <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('umb_hr_laporans_tugass');?> 
                                </a> 
                            </li>
                        <?php } ?>
                    <?php } ?>
                    <?php if(in_array('116',$role_resources_ids)) { ?>
                        <li class="sidenav-link <?php if(!empty($arr_mod['laporans_roles_active']))echo $arr_mod['laporans_roles_active'];?>"> 
                            <a href="<?php echo site_url('admin/laporans/roles');?>"> 
                                <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('umb_hr_laporan_user_roles_laporan');?> 
                            </a> 
                        </li>
                    <?php } ?>
                    <?php if(in_array('117',$role_resources_ids)) { ?>
                        <li class="sidenav-link <?php if(!empty($arr_mod['laporans_karyawans_active']))echo $arr_mod['laporans_karyawans_active'];?>"> 
                            <a href="<?php echo site_url('admin/laporans/karyawans');?>"> 
                                <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('umb_hr_laporan_karyawans');?> 
                            </a> 
                        </li>
                    <?php } ?>
                </ul>
            </li>
        <?php } ?>
        <?php  if(in_array('57',$role_resources_ids) || in_array('60',$role_resources_ids) || in_array('61',$role_resources_ids) || in_array('61',$role_resources_ids) || in_array('62',$role_resources_ids) || in_array('63',$role_resources_ids) || in_array('89',$role_resources_ids) || in_array('93',$role_resources_ids)) {?>
            <li class="<?php if(!empty($arr_mod['system_open']))echo $arr_mod['system_open'];?> treeview">
                <a href="#"> 
                    <i class="fa fa-cog"></i> 
                    <span><?php echo $this->lang->line('umb_system');?></span> 
                    <span class="pull-right-container"> 
                        <i class="fa fa-angle-left pull-right"></i> 
                    </span> 
                </a>
                <ul class="treeview-menu">
                    <?php if($system[0]->module_language=='true'){?>
                        <?php if(in_array('89',$role_resources_ids)) { ?>
                            <li class="sidenav-link <?php if(!empty($arr_mod['languages_active']))echo $arr_mod['languages_active'];?>"> 
                                <a href="<?php echo site_url('admin/languages');?>"> 
                                    <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('umb_multi_language');?> 
                                </a> 
                            </li>
                        <?php } ?>
                    <?php } ?>
                    <?php if(in_array('60',$role_resources_ids)) { ?>
                        <li class="sidenav-link <?php if(!empty($arr_mod['settings_active']))echo $arr_mod['settings_active'];?>"> 
                            <a href="<?php echo site_url('admin/settings');?>"> 
                                <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('left_settings');?> 
                            </a> 
                        </li>
                    <?php } ?>
                    <?php if(in_array('93',$role_resources_ids)) { ?>
                        <li class="sidenav-link <?php if(!empty($arr_mod['modules_active']))echo $arr_mod['modules_active'];?>"> 
                            <a href="<?php echo site_url('admin/settings/modules');?>"> 
                                <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('umb_setup_modules');?> 
                            </a> 
                        </li>
                    <?php } ?>
                    <?php if(in_array('94',$role_resources_ids)) { ?>
                        <li class="sidenav-link <?php if(!empty($arr_mod['theme_active']))echo $arr_mod['theme_active'];?>"> 
                            <a href="<?php echo site_url('admin/theme');?>"> 
                                <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('umb_theme_settings');?> 
                            </a> 
                        </li>
                    <?php } ?>
                    <?php if(in_array('61',$role_resources_ids)) { ?>
                        <li class="sidenav-link <?php if(!empty($arr_mod['constants_active']))echo $arr_mod['constants_active'];?>"> 
                            <a href="<?php echo site_url('admin/settings/constants');?>"> 
                                <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('left_constants');?> 
                            </a> 
                        </li>
                    <?php } ?>
                    <?php if(in_array('62',$role_resources_ids)) { ?>
                        <li class="sidenav-link <?php if(!empty($arr_mod['db_active']))echo $arr_mod['db_active'];?>"> 
                            <a href="<?php echo site_url('admin/settings/database_backup');?>"> 
                                <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('left_db_backup');?> 
                            </a> 
                        </li>
                    <?php } ?>
                    <?php if(in_array('63',$role_resources_ids)) { ?>
                        <li class="sidenav-link <?php if(!empty($arr_mod['email_template_active']))echo $arr_mod['email_template_active'];?>"> 
                            <a href="<?php echo site_url('admin/settings/email_template');?>"> 
                                <i class="fa <?php echo $submenuicon;?>"></i> <?php echo $this->lang->line('left_email_templates');?> 
                            </a> 
                        </li>
                    <?php } ?>
                </ul>
            </li>
        <?php } ?>
        <li> &nbsp; </li>
    </ul>
</section>
