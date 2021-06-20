<?php $role_resources_ids = $this->Umb_model->user_role_resource();?>
<?php
$session = $this->session->userdata('username');
$theme = $this->Umb_model->read_theme_info(1);
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
<div class="container-m-nx container-m-ny mb-3 mt-2">

  <div class="file-manager-actions container-p-x py-2">
    <div>
      <div class="btn-group btn-group-toggle" data-toggle="buttons">
        <label class="btn btn-default icon-btn md-btn-flat active">
          <input type="radio" name="file-manager-view" value="file-manager-col-view" checked> <span class="ion ion-md-apps"></span>
        </label>
        <label class="btn btn-default icon-btn md-btn-flat">
          <input type="radio" name="file-manager-view" value="file-manager-row-view"> <span class="ion ion-md-menu"></span>
        </label>
      </div>
    </div>
  </div>
  <hr class="m-0">
</div>
<div class="file-manager-container file-manager-col-view">

  <div class="file-manager-row-header">
    <div class="file-item-name pb-2">Laporan</div>
  </div>
  <?php if(in_array('111',$role_resources_ids)) { ?>
    <div class="file-item">
      <div class="file-item-icon file-item-level-up ion ion-md-calculator text-secondary"></div>
      <a href="<?php echo site_url('admin/laporans/slipgaji');?>" class="file-item-name">
        <strong><?php echo $this->lang->line('umb_hr_laporans_slipgaji');?></strong>
      </a>
    </div>
  <?php } ?>
  <?php if(in_array('112',$role_resources_ids)) { ?>
    <div class="file-item">
      <div class="file-item-icon file-item-level-up ion ion-md-clock text-secondary"></div>
      <a href="<?php echo site_url('admin/laporans/kehadiran_karyawan');?>" class="file-item-name">
        <strong><?php echo $this->lang->line('umb_hr_laporans_kehadiran_karyawan');?></strong>
      </a>
    </div>
  <?php } ?>
  <?php if(in_array('113',$role_resources_ids)) { ?>
    <div class="file-item">
      <div class="file-item-icon file-item-level-up fas fa-portrait text-secondary"></div>
      <a href="<?php echo site_url('admin/laporans/karyawan_training');?>" class="file-item-name">
        <strong><?php echo $this->lang->line('umb_hr_laporans_training');?></strong>
      </a>
    </div>
  <?php } ?> 
  <?php if(in_array('114',$role_resources_ids)) { ?>
    <div class="file-item">
      <div class="file-item-icon file-item-level-up ion ion-logo-buffer text-secondary"></div>
      <a href="<?php echo site_url('admin/laporans/projects');?>" class="file-item-name">
        <strong><?php echo $this->lang->line('umb_hr_laporans_projects');?></strong>
      </a>
    </div>
  <?php } ?>
  <?php if(in_array('115',$role_resources_ids)) { ?>
    <div class="file-item">
      <div class="file-item-icon file-item-level-up fas fa-file-signature text-secondary"></div>
      <a href="<?php echo site_url('admin/laporans/tugass');?>" class="file-item-name">
        <strong><?php echo $this->lang->line('umb_hr_laporans_tugass');?></strong>
      </a>
    </div>
  <?php } ?> 
  <?php if(in_array('116',$role_resources_ids)) { ?>
    <div class="file-item">
      <div class="file-item-icon file-item-level-up fas fa-user-lock text-secondary"></div>
      <a href="<?php echo site_url('admin/laporans/roles');?>" class="file-item-name">
        <strong><?php echo $this->lang->line('umb_hr_laporan_user_roles_laporan');?></strong>
      </a>
    </div>
  <?php } ?>
  <?php if(in_array('117',$role_resources_ids)) { ?>
    <div class="file-item">
      <div class="file-item-icon file-item-level-up fas fa-user-friends text-secondary"></div>
      <a href="<?php echo site_url('admin/laporans/karyawans');?>" class="file-item-name">
        <strong><?php echo $this->lang->line('umb_hr_laporan_karyawans');?></strong>
      </a>
    </div>
  <?php } ?>
  <?php if(in_array('83',$role_resources_ids)) { ?>
    <div class="file-item">
      <div class="file-item-icon file-item-level-up fas fa-money-bill-alt text-secondary"></div>
      <a href="<?php echo site_url('admin/accounting/account_statement');?>" class="file-item-name">
        <strong><?php echo $this->lang->line('umb_acc_account_statement');?></strong>
      </a>
    </div>
  <?php } ?>
  <?php if(in_array('84',$role_resources_ids)) { ?>
    <div class="file-item">
      <div class="file-item-icon file-item-level-up ion ion-md-cash text-secondary"></div>
      <a href="<?php echo site_url('admin/accounting/biaya_laporan');?>" class="file-item-name">
        <strong><?php echo $this->lang->line('umb_acc_laporans_biaya');?></strong>
      </a>
    </div>
  <?php } ?>
  <?php if(in_array('85',$role_resources_ids)) { ?>
    <div class="file-item">
      <div class="file-item-icon file-item-level-up fas fa-money-check-alt text-secondary"></div>
      <a href="<?php echo site_url('admin/accounting/pendapatan_laporan');?>" class="file-item-name">
        <strong><?php echo $this->lang->line('umb_acc_laporans_pendapatan');?></strong>
      </a>
    </div>
  <?php } ?>
  <?php if(in_array('86',$role_resources_ids)) { ?>
    <div class="file-item">
      <div class="file-item-icon file-item-level-up fas fa-exchange-alt text-secondary"></div>
      <a href="<?php echo site_url('admin/accounting/transfer_laporan');?>" class="file-item-name">
        <strong><?php echo $this->lang->line('umb_acc_laporan_transfer');?></strong>
      </a>
    </div>
  <?php } ?>
  <?php if(in_array('86',$role_resources_ids)) { ?>
    <div class="file-item">
      <div class="file-item-icon file-item-level-up fa fa-graduation-cap text-secondary"></div>
      <a href="<?php echo site_url('admin/accounting/transfer_laporan');?>" class="file-item-name">
        <?php echo $this->lang->line('umb_awards_report');?>
      </a>
    </div>
  <?php } ?>
  <?php if(in_array('86',$role_resources_ids)) { ?>
    <div class="file-item">
      <div class="file-item-icon file-item-level-up fas fa-user-times text-secondary"></div>
      <a href="<?php echo site_url('admin/accounting/transfer_laporan');?>" class="file-item-name">
        <?php echo $this->lang->line('umb_penghentian_report');?>
      </a>
    </div>
  <?php } ?>
  <?php if(in_array('86',$role_resources_ids)) { ?>
    <div class="file-item">
      <div class="file-item-icon file-item-level-up ion ion-ios-airplane text-secondary"></div>
      <a href="<?php echo site_url('admin/accounting/transfer_laporan');?>" class="file-item-name">
        <?php echo $this->lang->line('umb_perjalanan_report');?>
      </a>
    </div>
  <?php } ?>
  <?php if(in_array('86',$role_resources_ids)) { ?>
    <div class="file-item">
      <div class="file-item-icon file-item-level-up fas fa-calendar-alt text-secondary"></div>
      <a href="<?php echo site_url('admin/accounting/transfer_laporan');?>" class="file-item-name">
        <?php echo $this->lang->line('umb_hr_report_cuti_report');?>
      </a>
    </div>
  <?php } ?>
  <?php if(in_array('86',$role_resources_ids)) { ?>
    <div class="file-item">
      <div class="file-item-icon file-item-level-up ion ion-ios-paper-plane text-secondary"></div>
      <a href="<?php echo site_url('admin/accounting/transfer_laporan');?>" class="file-item-name">
        <?php echo $this->lang->line('umb_liburan_report');?>
      </a>
    </div>
  <?php } ?>
  <?php if(in_array('86',$role_resources_ids)) { ?>
    <div class="file-item">
      <div class="file-item-icon file-item-level-up fas fa-edit text-secondary"></div>
      <a href="<?php echo site_url('admin/accounting/transfer_laporan');?>" class="file-item-name">
        <?php echo $this->lang->line('umb_keluhans_report');?>
      </a>
    </div>
  <?php } ?>
  <?php if(in_array('86',$role_resources_ids)) { ?>
    <div class="file-item">
      <div class="file-item-icon file-item-level-up fas fa-exclamation-triangle text-secondary"></div>
      <a href="<?php echo site_url('admin/accounting/transfer_laporan');?>" class="file-item-name">
        <?php echo $this->lang->line('umb_peringatan_report');?>
      </a>
    </div>
  <?php } ?>
  <?php if(in_array('86',$role_resources_ids)) { ?>
    <div class="file-item">
      <div class="file-item-icon file-item-level-up fas fa-user-alt-slash text-secondary"></div>
      <a href="<?php echo site_url('admin/accounting/transfer_laporan');?>" class="file-item-name">
        <?php echo $this->lang->line('umb_karyawans_exit_report');?>
      </a>
    </div>
  <?php } ?>
  <?php if(in_array('86',$role_resources_ids)) { ?>
    <div class="file-item">
      <div class="file-item-icon file-item-level-up ion ion-md-trending-up text-secondary"></div>
      <a href="<?php echo site_url('admin/accounting/transfer_laporan');?>" class="file-item-name">
        <?php echo $this->lang->line('umb_laporan_promotion');?>
      </a>
    </div>
  <?php } ?>
  <?php if(in_array('86',$role_resources_ids)) { ?>
    <div class="file-item">
      <div class="file-item-icon file-item-level-up fas fa-user-edit text-secondary"></div>
      <a href="<?php echo site_url('admin/accounting/transfer_laporan');?>" class="file-item-name">
        <?php echo $this->lang->line('umb_pengunduran_diri_report');?>
      </a>
    </div>
  <?php } ?>
  <?php if(in_array('86',$role_resources_ids)) { ?>
    <div class="file-item">
      <div class="file-item-icon file-item-level-up ion ion-md-today text-secondary"></div>
      <a href="<?php echo site_url('admin/accounting/transfer_laporan');?>" class="file-item-name">
        <?php echo $this->lang->line('umb_assets_report');?>
      </a>
    </div>
  <?php } ?>  
</div>
<hr class="m-0">