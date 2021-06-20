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
      <li class="nav-item active"> 
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
<?php if(in_array('77',$role_resources_ids)) {?>
  <div class="card mb-4 <?php echo $get_animate;?>">
    <div id="accordion">
      <div class="card-header with-elements">
        <span class="card-header-title mr-2">
          <strong><?php echo $this->lang->line('umb_add_new');?></strong> 
          <?php echo $this->lang->line('umb_acc_transfer');?>
        </span>
      </div>
      <div id="add_form" class="collapse show add-form" data-parent="#accordion" style="">
        <div class="card-body">
          <?php $attributes = array('name' => 'add_transfer', 'id' => 'umb-form', 'autocomplete' => 'off');?>
          <?php $hidden = array('_user' => $session['user_id']);?>
          <?php echo form_open('admin/accounting/add_transfer', $attributes, $hidden);?>
          <div class="bg-white">
            <div class="box-block">
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="bank_cash_id">
                      <?php echo $this->lang->line('umb_acc_from_account');?> 
                      <span id="acc_saldo" style="display:none; font-weight:600; color:#F00;"></span>
                    </label>
                    <select name="from_bank_cash_id" class="from-account form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_acc_choose_account_type');?>">
                      <option value=""></option>
                      <?php foreach($all_bank_cash as $bank_cash) {?>
                        <option value="<?php echo $bank_cash->bankcash_id;?>" saldo-account="<?php echo $bank_cash->saldo_account;?>"><?php echo $bank_cash->nama_account;?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="tanggal_transfer"><?php echo $this->lang->line('umb_e_details_tanggal');?></label>
                    <input class="form-control date" placeholder="<?php echo date('Y-m-d');?>" readonly name="tanggal_transfer" type="text">
                  </div>
                  <div class="form-group">
                    <label for="payment_method"><?php echo $this->lang->line('umb_payment_method');?></label>
                    <select name="payment_method" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_choose_payment_method');?>">
                      <option value=""></option>
                      <?php foreach($get_all_payment_method as $payment_method) {?>
                        <option value="<?php echo $payment_method->payment_method_id;?>"> <?php echo $payment_method->method_name;?></option>
                      <?php } ?>
                    </select>
                    <input type="hidden" name="saldo_account" id="saldo_account" value="" />
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="bank_cash_id"><?php echo $this->lang->line('umb_acc_to_account');?></label>
                    <select name="to_bank_cash_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_acc_choose_account_type');?>">
                      <option value=""></option>
                      <?php foreach($all_bank_cash as $bank_cash) {?>
                        <option value="<?php echo $bank_cash->bankcash_id;?>"><?php echo $bank_cash->nama_account;?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="month_year"><?php echo $this->lang->line('umb_jumlah');?></label>
                    <input class="form-control" name="jumlah" type="text" placeholder="<?php echo $this->lang->line('umb_jumlah');?>">
                  </div>
                  <div class="form-group">
                    <label for="reference_transfer"><?php echo $this->lang->line('umb_acc_ref_no');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('umb_acc_ref_example');?>" name="reference_transfer" type="text">
                    <br />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="description"><?php echo $this->lang->line('umb_description');?></label>
                    <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('umb_description');?>" name="description" cols="30" rows="5" id="description"></textarea>
                  </div>
                </div>
              </div>
              <div class="form-actions box-footer">
                <button type="submit" class="btn btn-primary"> 
                  <i class="fas fa-check-square"></i> 
                  <?php echo $this->lang->line('umb_save');?> 
                </button>
              </div>
            </div>
          </div>
          <?php echo form_close(); ?> 
        </div>
      </div>
    </div>
  </div>
<?php } ?>
