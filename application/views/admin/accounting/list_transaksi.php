<?php
$session = $this->session->userdata('username');
$currency = $this->Umb_model->currency_sign(0);
?>
<?php $system = $this->Umb_model->read_setting_info(1);?>
<?php $transaksi = $this->Keuangan_model->get_transaksi();?>
<?php $role_resources_ids = $this->Umb_model->user_role_resource(); ?>
<?php $user_info = $this->Umb_model->read_user_info($session['user_id']);?>
<?php $saldo2 = 0; $jumlah_total = 0; $transaksi_credit = 0; $transaksi_debit = 0;?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>
<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('286',$role_resources_ids) || $user_info[0]->user_role_id==1) { ?>
      <li class="nav-item clickable"> 
        <a href="<?php echo site_url('admin/accounting/dashboard_accounting/');?>" data-link-data="<?php echo site_url('admin/accounting/dashboard_accounting/');?>" class="mb-3 nav-link hrastral-link"> 
          <span class="sw-icon ion ion-md-speedometer"></span> 
          <?php echo $this->lang->line('umb_hr_keuangan');?>
          <div class="text-muted small"><?php echo $this->lang->line('hr_title_dashboard_accounting');?></div>
        </a> 
      </li>
    <?php } ?>
    <?php if(in_array('72',$role_resources_ids)) { ?>
      <li class="nav-item clickable"> 
        <a href="<?php echo site_url('admin/accounting/bank_cash/');?>" data-link-data="<?php echo site_url('admin/accounting/bank_cash/');?>" class="mb-3 nav-link hrastral-link"> 
          <span class="sw-icon ion ion-ios-cash"></span> 
          <?php echo $this->lang->line('umb_acc_list_account');?>
          <div class="text-muted small"><?php echo $this->lang->line('umb_add_new');?> <?php echo $this->lang->line('umb_acc_accounts');?></div>
        </a> 
      </li>
    <?php } ?>
    <?php if(in_array('75',$role_resources_ids)) { ?>
      <li class="nav-item clickable"> 
        <a href="<?php echo site_url('admin/accounting/deposit/');?>" data-link-data="<?php echo site_url('admin/accounting/deposit/');?>" class="mb-3 nav-link hrastral-link"> 
          <span class="sw-icon ion ion-logo-usd"></span> 
          <?php echo $this->lang->line('umb_acc_deposit');?>
          <div class="text-muted small"><?php echo $this->lang->line('umb_add_new');?> <?php echo $this->lang->line('umb_acc_deposit');?></div>
        </a> 
      </li>
    <?php } ?>
    <?php if(in_array('76',$role_resources_ids)) { ?>
      <li class="nav-item clickable"> 
        <a href="<?php echo site_url('admin/accounting/biaya/');?>" data-link-data="<?php echo site_url('admin/accounting/biaya/');?>" class="mb-3 nav-link hrastral-link"> 
          <span class="sw-icon fas fa-money-check-alt"></span> 
          <?php echo $this->lang->line('umb_acc_biaya');?>
          <div class="text-muted small"><?php echo $this->lang->line('umb_add_new');?> <?php echo $this->lang->line('umb_acc_biaya');?></div>
        </a> 
      </li>
    <?php } ?>
    <?php if(in_array('77',$role_resources_ids)) { ?>
      <li class="nav-item clickable"> 
        <a href="<?php echo site_url('admin/accounting/transfer/');?>" data-link-data="<?php echo site_url('admin/accounting/transfer/');?>" class="mb-3 nav-link hrastral-link"> 
          <span class="sw-icon ion ion-md-swap"></span> 
          <?php echo $this->lang->line('umb_acc_transfer');?>
          <div class="text-muted small"><?php echo $this->lang->line('umb_transfer_funds');?></div>
        </a> 
      </li>
    <?php } ?>
    <?php if(in_array('78',$role_resources_ids)) { ?>
      <li class="nav-item active"> 
        <a href="<?php echo site_url('admin/accounting/transaksii/');?>" data-link-data="<?php echo site_url('admin/accounting/transaksii/');?>" class="mb-3 nav-link hrastral-link"> 
          <span class="sw-icon fas fa-cube"></span> 
          <?php echo $this->lang->line('umb_acc_transaksii');?>
          <div class="text-muted small"><?php echo $this->lang->line('umb_view_all');?> <?php echo $this->lang->line('umb_acc_transaksii');?></div>
        </a> 
      </li>
    <?php } ?>  
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<div class="card <?php echo $get_animate;?>">
  <div class="card-header with-elements"> 
    <span class="card-header-title mr-2">
      <strong><?php echo $this->lang->line('umb_list_all');?></strong> 
      <?php echo $this->lang->line('umb_acc_transaksii');?>
    </span> 
  </div>
  <div class="card-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="umb_table">
        <input type="hidden" id="current_currency" value="<?php $curr = explode('0',$currency); echo $curr[0];?>" />
        <thead>
          <tr>
            <th><?php echo $this->lang->line('umb_e_details_tanggal');?></th>
            <th><?php echo $this->lang->line('umb_acc_accounts');?></th>
            <th><?php echo $this->lang->line('umb_acc_dr_cr');?></th>
            <th><?php echo $this->lang->line('umb_type');?></th>
            <th><?php echo $this->lang->line('umb_jumlah');?></th>
            <th><?php echo $this->lang->line('umb_acc_ref_no');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>