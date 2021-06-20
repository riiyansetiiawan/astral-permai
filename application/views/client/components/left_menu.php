<?php
$session = $this->session->userdata('client_username');
$theme = $this->Umb_model->read_theme_info(1);
// set layout / fixed or static
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
$user_info = $this->Clients_model->read_info_client($session['client_id']);
if($user_info[0]->is_active!=1) {
	redirect('client/auth/');
}

?>
<?php $system = $this->Umb_model->read_setting_info(1);?>
<?php $arr_mod = $this->Umb_model->select_module_class($this->router->fetch_class(),$this->router->fetch_method()); ?>
<?php  if($user_info[0]->profile_client!='' && $user_info[0]->profile_client!='no file') {?>
	<?php $cpimg = base_url().'uploads/clients/'.$user_info[0]->profile_client;?>
<?php } else {?>
<?php  if($user_info[0]->jenis_kelamin=='Pria') { ?>
<?php 	$de_file = base_url().'uploads/clients/default_male.jpg';?>
<?php } else { ?>
<?php 	$de_file = base_url().'uploads/clients/default_female.jpg';?>
<?php } ?>
    <?php $cpimg = $de_file;?>
<?php  } ?>
<ul class="sidenav-inner py-1">
  <!-- Dashboards -->
  
  <li class="sidenav-item <?php if(!empty($arr_mod['active']))echo $arr_mod['active'];?>">
    <a href="<?php echo site_url('client/dashboard');?>" class="sidenav-link">
      <i class="sidenav-icon ion ion-md-speedometer"></i>
      <div><?php echo $this->lang->line('dashboard_title');?></div>
    </a>
  </li>
  <li class="sidenav-item <?php if(!empty($arr_mod['projects_active']))echo $arr_mod['projects_active'];?>">
    <a href="<?php echo site_url('client/projects');?>" class="sidenav-link">
      <i class="sidenav-icon ion ion-logo-buffer"></i>
      <div><?php echo $this->lang->line('left_projects');?></div>
    </a>
  </li>
  <li class="sidenav-item <?php if(!empty($arr_mod['tugas_active']))echo $arr_mod['tugas_active'];?>">
    <a href="<?php echo site_url('client/tugass');?>" class="sidenav-link">
      <i class="sidenav-icon fab fa-fantasy-flight-games"></i>
      <div><?php echo $this->lang->line('left_tugass');?></div>
    </a>
  </li>
  <li class="sidenav-item <?php if(!empty($arr_mod['hr_all_inv_active']))echo $arr_mod['hr_all_inv_active'];?>">
    <a href="<?php echo site_url('client/invoices');?>" class="sidenav-link">
      <i class="sidenav-icon fas fa-file-invoice-dollar"></i>
      <div><?php echo $this->lang->line('umb_invoices_title');?></div>
    </a>
  </li>
  <li class="sidenav-item <?php if(!empty($arr_mod['hr_client_invoices_pay_active']))echo $arr_mod['hr_client_invoices_pay_active'];?>">
    <a href="<?php echo site_url('client/invoices/history_pembayarans');?>" class="sidenav-link">
      <i class="sidenav-icon ion ion-md-cash"></i>
      <div><?php echo $this->lang->line('umb_acc_pembayarans_invoice');?></div>
    </a>
  </li>
  <li class="sidenav-item <?php if(!empty($arr_mod['hr_client_invoices_pay_active']))echo $arr_mod['hr_client_invoices_pay_active'];?>">
    <a href="<?php echo site_url('client/logout');?>" class="sidenav-link">
      <i class="sidenav-icon ion ion-ios-log-out"></i>
      <div><?php echo $this->lang->line('left_logout');?></div>
    </a>
  </li>
</ul>