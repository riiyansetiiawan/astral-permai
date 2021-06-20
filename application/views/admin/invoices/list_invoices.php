<?php
/* Invoices view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>
<?php $role_resources_ids = $this->Umb_model->user_role_resource(); ?>

<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('121',$role_resources_ids)) { ?>
      <li class="nav-item active"> <a href="<?php echo site_url('admin/invoices/');?>" data-link-data="<?php echo site_url('admin/invoices/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon fas fa-file-invoice-dollar"></span> <?php echo $this->lang->line('umb_invoices_title');?>
      <div class="text-muted small"><?php echo $this->lang->line('umb_set_up');?> <?php echo $this->lang->line('umb_invoices_title');?></div>
    </a> </li>
  <?php } ?>  
  <?php if(in_array('426',$role_resources_ids)) { ?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/invoices/calendar_invoice/');?>" data-link-data="<?php echo site_url('admin/invoices/calendar_invoice/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon fas fa-calendar-alt"></span> <?php echo $this->lang->line('umb_calendar_invoice');?>
    <div class="text-muted small"><?php echo $this->lang->line('umb_view');?> <?php echo $this->lang->line('umb_acc_calendar');?></div>
  </a> </li>
<?php } ?>
<?php if(in_array('330',$role_resources_ids)) { ?>
  <li class="nav-item done"> <a href="<?php echo site_url('admin/invoices/history_pembayarans/');?>" data-link-data="<?php echo site_url('admin/invoices/history_pembayarans/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon fas fa-file-invoice"></span> <?php echo $this->lang->line('umb_acc_pembayarans_invoice');?>
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
<div class="row">
  <div class="col-sm-6 col-xl-3"> <a href="<?php echo site_url('admin/invoices/');?>">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="lnr lnr-cart display-4 text-success"></div>
          <div class="ml-3">
            <div class="text-muted small"><?php echo $this->lang->line('umb_invoice_bayar_client');?></div>
            <div class="text-large"><?php echo count_all_bayar_invoice();?></div>
          </div>
        </div>
      </div>
    </div>
  </a> </div>
  <div class="col-sm-6 col-xl-3"> <a href="<?php echo site_url('admin/invoices/');?>">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="lnr lnr-earth display-4 text-info"></div>
          <div class="ml-3">
            <div class="text-muted small"><?php echo $this->lang->line('umb_bayar_jumlah');?></div>
            <div class="text-large"><?php echo $this->Umb_model->currency_sign(all_jumlah_bayar_invoice());?></div>
          </div>
        </div>
      </div>
    </div>
  </a> </div>
  <div class="col-sm-6 col-xl-3"> <a href="<?php echo site_url('admin/invoices/');?>">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="lnr lnr-gift display-4 text-danger"></div>
          <div class="ml-3">
            <div class="text-muted small"><?php echo $this->lang->line('umb_invoice_belum_dibayar_client');?></div>
            <div class="text-large"><?php echo count_all_invoice_belum_dibayar();?></div>
          </div>
        </div>
      </div>
    </div>
  </a> </div>
  <div class="col-sm-6 col-xl-3"> <a href="<?php echo site_url('admin/invoices/');?>">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="lnr lnr-users display-4 text-warning"></div>
          <div class="ml-3">
            <div class="text-muted small"><?php echo $this->lang->line('umb_invoice_due_jumlah');?></div>
            <div class="text-large"><?php echo $this->Umb_model->currency_sign(all_jumlah_invoice_belum_dibayar());?></div>
          </div>
        </div>
      </div>
    </div>
  </a> </div>
</div>
<div class="card <?php echo $get_animate;?>">
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_list_all');?></strong> <?php echo $this->lang->line('umb_invoices_title');?></span>
    <?php if(in_array('120',$role_resources_ids)) {?>
      <div class="card-header-elements ml-md-auto"> <a class="text-dark"href="<?php echo site_url('admin/invoices/create/')?>">
        <button type="button" class="btn btn-xs btn-primary" onclick="window.location='<?php echo site_url('admin/invoices/create/')?>'"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('umb_create_invoice');?></button>
      </a> </div>
    <?php } ?>
  </div>
  <div class="card-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="umb_table">
        <thead>
          <tr>
            <th><?php echo $this->lang->line('umb_action');?></th>
            <th><?php echo $this->lang->line('umb_invoice_no');?></th>
            <th><?php echo $this->lang->line('umb_project');?></th>
            <th><?php echo $this->lang->line('umb_acc_total');?></th>
            <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('umb_tanggal_invoice');?></th>
            <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('umb_tanggal_jatoh_tempo_invoice');?></th>
            <th><?php echo $this->lang->line('kpi_status');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
<style type="text/css">
  .info-box-number {
   font-size:15px !important;
   font-weight:300 !important;
 }
</style>
