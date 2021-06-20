<?php $session = $this->session->userdata('username'); ?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>
<?php $role_resources_ids = $this->Umb_model->user_role_resource(); ?>
<?php $user_info = $this->Umb_model->read_user_info($session['user_id']);?>

<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('286',$role_resources_ids) || $user_info[0]->user_role_id==1) { ?>
      <li class="nav-item active"> 
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
      <li class="nav-item clickable"> 
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
<?php if(in_array('75',$role_resources_ids) || in_array('76',$role_resources_ids) || in_array('80',$role_resources_ids) || in_array('81',$role_resources_ids)) { ?>
  <div class="row">
    <div class="d-flex col-xl-12 align-items-stretch"> 
      <div class="card d-flex w-100 mb-4">
        <div class="row no-gutters row-bordered h-100">
          <?php if(in_array('75',$role_resources_ids)) { ?>
            <div class="d-flex col-sm-6 col-md-3 col-lg-3 align-items-center"> 
              <a href="javascript:void(0)" class="card-body media align-items-center text-body"> 
                <i class="ion ion-logo-usd display-4 d-block text-primary"></i> 
                <span class="media-body d-block ml-3"> 
                  <span class="text-big font-weight-bolder"><?php echo $this->Umb_model->currency_sign(dashboard_total_sales());?></span><br>
                  <small class="text-muted"><?php echo $this->lang->line('umb_total_deposit');?></small> 
                </span> 
              </a> 
            </div>
          <?php } ?>
          <?php if(in_array('76',$role_resources_ids)) { ?>
            <div class="d-flex col-sm-6 col-md-3 col-lg-3 align-items-center"> 
              <a href="javascript:void(0)" class="card-body media align-items-center text-body"> 
                <i class="ion ion-ios-cash display-4 d-block text-primary"></i> 
                <span class="media-body d-block ml-3"> 
                  <span class="text-big font-weight-bolder"><?php echo $this->Umb_model->currency_sign(dashboard_total_biaya());?></span><br>
                  <small class="text-muted"><?php echo $this->lang->line('umb_total_biayaa');?></small> 
                </span> 
              </a> 
            </div>
          <?php } ?>
          <?php if(in_array('80',$role_resources_ids)) { ?>
            <div class="d-flex col-sm-6 col-md-3 col-lg-3 align-items-center"> 
              <a href="javascript:void(0)" class="card-body media align-items-center text-body"> 
                <i class="ion ion-ios-person-add display-4 d-block text-primary"></i> 
                <span class="media-body d-block ml-3"> 
                  <span class="text-big font-weight-bolder"><?php echo dashboard_total_penerima_pembayarans();?></span><br>
                  <small class="text-muted"><?php echo $this->lang->line('umb_total_penerima_pembayarans');?></small> 
                </span> 
              </a> 
            </div>
          <?php } ?>
          <?php if(in_array('81',$role_resources_ids)) { ?>
            <div class="d-flex col-sm-6 col-md-3 col-lg-3 align-items-center"> 
              <a href="javascript:void(0)" class="card-body media align-items-center text-body"> 
                <i class="ion ion-ios-person display-4 d-block text-primary"></i> 
                <span class="media-body d-block ml-3"> 
                  <span class="text-big font-weight-bolder"><?php echo dashboard_total_pembayars();?></span><br>
                  <small class="text-muted"><?php echo $this->lang->line('umb_total_pembayars');?></small> 
                </span> 
              </a> 
            </div>
          <?php } ?>  
        </div>
      </div>
    </div>
  </div>
<?php } ?>
<?php if(in_array('121',$role_resources_ids) || in_array('76',$role_resources_ids) || in_array('75',$role_resources_ids)) { ?>
  <div class="row">
    <?php if(in_array('121',$role_resources_ids)) { ?>
      <div class="col-md-8">
        <div class="card mb-4">
          <h6 class="card-header with-elements mb-2">
            <div class="card-header-title"><?php echo $this->lang->line('umb_invoices_summary');?></div>
            <div class="card-header-elements ml-auto"> 
              <a href="<?php echo site_url('admin/invoices/');?>">
                <button type="button" class="btn btn-default btn-xs md-btn-flat"><?php echo $this->lang->line('dashboard_show_more');?></button>
              </a> 
            </div>
          </h6>
          <div class="row">
            <div class="col-xs-6 col-md-6 text-center">
              <input type="text" class="knob" value="<?php echo dashboard_belum_dibayar_invoices();?>" data-skin="tron" data-thickness="0.2" data-width="90" data-height="90" data-fgColor="#f96868" data-readonly="true">
              <div class="knob-label"><?php echo $this->lang->line('umb_payroll_belum_dibayar');?></div>
            </div>
            <div class="col-xs-6 col-md-6 text-center">
              <input type="text" class="knob" value="<?php echo dashboard_bayar_invoices();?>" data-skin="tron" data-thickness="0.2" data-width="90" data-height="90" data-fgColor="#46be8a" data-readonly="true">
              <div class="knob-label"><?php echo $this->lang->line('umb_payment_bayar');?></div>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table card-table">
              <thead>
                <tr>
                  <th><?php echo $this->lang->line('umb_invoice_no');?></th>
                  <th width="130px;"><?php echo $this->lang->line('umb_project');?></th>
                  <th width="100px;"><?php echo $this->lang->line('umb_jumlah');?></th>
                  <th><?php echo $this->lang->line('umb_tanggal_invoice');?></th>
                  <th><?php echo $this->lang->line('umb_tanggal_jatoh_tempo_invoice');?></th>
                  <th width="80px;"><?php echo $this->lang->line('dashboard_umb_status');?></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach(dashboard_dua_invoices_terakhir() as $linvoices){?>
                  <?php
                  $project = $this->Project_model->read_informasi_project($linvoices->project_id); 
                  if(!is_null($project)){
                    $nama_project = $project[0]->title;
                  } else {
                    $nama_project = '--';	
                  }
                  $grand_total = $this->Umb_model->currency_sign($linvoices->grand_total);
                  $tanggal_invoice = '<i class="fa fa-calendar position-left"></i> '.$this->Umb_model->set_date_format($linvoices->tanggal_invoice);
                  $tanggal_jatoh_tempo_invoice = '<i class="fa fa-calendar position-left"></i> '.$this->Umb_model->set_date_format($linvoices->tanggal_jatoh_tempo_invoice);
                  if($linvoices->status == 0){
                    $status = '<span class="badge badge-danger">'.$this->lang->line('umb_payroll_belum_dibayar').'</span>';
                  } else if($linvoices->status == 1) {
                    $status = '<span class="badge badge-success">'.$this->lang->line('umb_payment_bayar').'</span>';
                  } else {
                    $status = '<span class="badge badge-info">'.$this->lang->line('umb_acc_inv_cancelled').'</span>';
                  }
                  ?>
                  <tr>
                    <td>
                      <a href="<?php echo site_url('admin/invoices/view/');?><?php echo $linvoices->invoice_id;?>" target="_blank"> <?php echo $linvoices->nomor_invoice;?> </a>
                    </td>
                    <td><?php echo $nama_project;?></td>
                    <td class="jumlah"><?php echo $grand_total;?></td>
                    <td><?php echo $tanggal_invoice;?></td>
                    <td><?php echo $tanggal_jatoh_tempo_invoice;?></td>
                    <td><?php echo $status;?></td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    <?php } ?>
    <?php if(in_array('76',$role_resources_ids) && in_array('75',$role_resources_ids)) { ?>
      <div class="col-sm-6 col-xl-4">
        <div class="card mb-4">
          <h6 class="card-header with-elements">
            <div class="card-header-title"><?php echo $this->lang->line('umb_deposit_vs_biaya');?></div>
          </h6>
          <div class="card-body pb-0">
            <div class="row">
              <div class="col-md-12">
                <div class="my-1" style="height: 140px;">
                  <canvas id="hrastral_biaya_deposit" width="460" height="146" style="display: block; height: 117px; width: 368px;"></canvas>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer text-center py-3">
            <div class="row">
              <div class="col">
                <div class="text-muted small"><?php echo $this->lang->line('umb_total_deposit');?></div>
                <strong class="text-big"><?php echo $this->Umb_model->currency_sign(dashboard_total_sales());?></strong> 
              </div>
              <div class="col">
                <div class="text-muted small"><?php echo $this->lang->line('umb_total_biayaa');?></div>
                <strong class="text-big"><?php echo $this->Umb_model->currency_sign(dashboard_total_biaya());?></strong> 
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>
<?php } ?>
