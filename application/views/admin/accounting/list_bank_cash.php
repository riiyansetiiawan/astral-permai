<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>
<?php $role_resources_ids = $this->Umb_model->user_role_resource(); ?>
<?php $user_info = $this->Umb_model->read_user_info($session['user_id']);?>
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
      <li class="nav-item active"> 
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
<div class="row m-b-1 <?php echo $get_animate;?>">
  <?php if(in_array('4',$role_resources_ids)) {?>
    <div class="col-md-4 mt-3">
      <div class="card">
        <div class="card-header with-elements"> 
          <span class="card-header-title mr-2">
            <strong><?php echo $this->lang->line('umb_add_new');?></strong> 
            <?php echo $this->lang->line('umb_acc_account');?>
          </span> 
        </div>
        <div class="card-body">
          <?php $attributes = array('name' => 'add_bankcash', 'id' => 'umb-form', 'autocomplete' => 'off');?>
          <?php $hidden = array('user_id' => $session['user_id']);?>
          <?php echo form_open('admin/accounting/add_bankcash', $attributes, $hidden);?>
          <div class="form-group">
            <label for="nama_account"><?php echo $this->lang->line('umb_acc_nama_account');?></label>
            <input type="text" class="form-control" name="nama_account" placeholder="<?php echo $this->lang->line('umb_acc_nama_account');?>">
          </div>
          <div class="form-group">
            <label for="saldo_account"><?php echo $this->lang->line('umb_acc_initial_saldo');?></label>
            <input type="text" class="form-control" name="saldo_account" placeholder="<?php echo $this->lang->line('umb_acc_initial_saldo');?>">
          </div>
          <div class="form-group">
            <label for="nomor_account"><?php echo $this->lang->line('umb_e_details_acc_number');?></label>
            <input type="text" class="form-control" name="nomor_account" placeholder="<?php echo $this->lang->line('umb_e_details_acc_number');?>">
          </div>
          <div class="form-group">
            <label for="kode_cabang"><?php echo $this->lang->line('umb_acc_kode_cabang');?></label>
            <input type="text" class="form-control" name="kode_cabang" placeholder="<?php echo $this->lang->line('umb_acc_kode_cabang');?>">
          </div>
          <div class="form-group">
            <label for="description"><?php echo $this->lang->line('umb_e_details_cabang_bank');?></label>
            <textarea class="form-control" name="cabang_bank" placeholder="<?php echo $this->lang->line('umb_e_details_cabang_bank');?>" rows="5"></textarea>
          </div>
          <div class="form-actions box-footer">
            <button type="submit" class="btn btn-primary"> 
              <i class="fas fa-check-square"></i> 
              <?php echo $this->lang->line('umb_save');?> 
            </button>
          </div>
          <?php echo form_close(); ?> 
        </div>
      </div>
    </div>
    <?php $colmdval = 'col-md-8';?>
  <?php } else {?>
    <?php $colmdval = 'col-md-12';?>
  <?php } ?>
  <div class="<?php echo $colmdval;?> mt-3">
    <div class="card">
      <div class="card-header with-elements"> 
        <span class="card-header-title mr-2">
          <strong><?php echo $this->lang->line('umb_list_all');?></strong> 
          <?php echo $this->lang->line('umb_acc_accounts');?>
        </span>
        <?php if(in_array('73',$role_resources_ids)) { ?>
          <div class="card-header-elements ml-md-auto"> 
            <a class="text-dark" href="<?php echo site_url('admin/accounting/saldo_accounts');?>">
              <button type="button" class="btn btn-xs btn-primary"> 
                <span class="ion ion-md-add"></span> 
                <?php echo $this->lang->line('umb_acc_saldo_accounts');?>
              </button>
            </a> 
          </div>
        <?php } ?>
      </div>
      <div class="card-body">
        <div class="box-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="umb_table">
            <thead>
              <tr>
                <th><?php echo $this->lang->line('umb_action');?></th>
                <th><?php echo $this->lang->line('umb_acc_accounts');?></th>
                <th><?php echo $this->lang->line('umb_acc_account_no');?></th>
                <th><?php echo $this->lang->line('umb_acc_kode_cabang');?></th>
                <th><?php echo $this->lang->line('umb_acc_saldo');?></th>
                <th><?php echo $this->lang->line('umb_e_details_cabang_bank');?></th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
