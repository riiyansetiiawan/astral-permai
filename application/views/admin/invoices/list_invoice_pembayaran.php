<?php
/*
* All Transactions - View
*/
$session = $this->session->userdata('client_username');
$currency = $this->Umb_model->currency_sign(0);
?>
<?php $system = $this->Umb_model->read_setting_info(1);?>
<?php //$transaksi = $this->Keuangan_model->get_transaksi();?>
<?php
$saldo2 = 0; $jumlah_total = 0; $transaksi_credit = 0; $transaksi_debit = 0;
?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>
<?php $role_resources_ids = $this->Umb_model->user_role_resource(); ?>
<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('121',$role_resources_ids)) { ?>
      <li class="nav-item done"> <a href="<?php echo site_url('admin/invoices/');?>" data-link-data="<?php echo site_url('admin/invoices/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon fas fa-file-invoice-dollar"></span> <?php echo $this->lang->line('umb_invoices_title');?>
      <div class="text-muted small"><?php echo $this->lang->line('umb_set_up');?> <?php echo $this->lang->line('umb_invoices_title');?></div>
    </a> </li>
  <?php } ?>  
  <?php if(in_array('426',$role_resources_ids)) { ?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/invoices/calendar_invoice/');?>" data-link-data="<?php echo site_url('admin/invoices/calendar_invoice/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon fas fa-calendar-alt"></span> <?php echo $this->lang->line('umb_calendar_invoice');?>
    <div class="text-muted small"><?php echo $this->lang->line('umb_view');?> <?php echo $this->lang->line('umb_acc_calendar');?></div>
  </a> </li>
<?php } ?>
<?php if(in_array('330',$role_resources_ids)) { ?>
  <li class="nav-item active"> <a href="<?php echo site_url('admin/invoices/history_pembayarans/');?>" data-link-data="<?php echo site_url('admin/invoices/history_pembayarans/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon fas fa-file-invoice"></span> <?php echo $this->lang->line('umb_acc_pembayarans_invoice');?>
  <div class="text-muted small"><?php echo $this->lang->line('umb_view');?> <?php echo $this->lang->line('umb_acc_pembayarans_invoice');?></div>
</a> </li>
<?php } ?>
<?php if(in_array('122',$role_resources_ids)) { ?>
  <li class="nav-item done"> <a href="<?php echo site_url('admin/invoices/pajaks/');?>" data-link-data="<?php echo site_url('admin/invoices/pajaks/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon fab fa-typo3"></span> <?php echo $this->lang->line('umb_invoice_type_pajak');?>
  <div class="text-muted small"><?php echo $this->lang->line('umb_add_new');?> <?php echo $this->lang->line('umb_invoice_type_pajak');?></div>
</a> </li>
<?php } ?>
</ul>
</div>
<hr class="border-light m-0 mb-3">
<div class="card <?php echo $get_animate;?>">
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_acc_inv_payments');?></strong></span> </div>
  <div class="card-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="umb_table">
        <input type="hidden" id="current_currency" value="<?php //$curr = explode('0',$currency); echo $curr[0];?>" />
        <thead>
          <tr>
            <th><?php echo $this->lang->line('umb_invoice_no');?></th>
            <th><?php echo $this->lang->line('umb_nama_klien');?></th>
            <th><?php echo $this->lang->line('umb_e_details_tanggal');?></th>
            <th><?php echo $this->lang->line('umb_jumlah');?></th>
            <th><?php echo $this->lang->line('umb_payment_method');?></th>
            <th><?php echo $this->lang->line('umb_description');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>