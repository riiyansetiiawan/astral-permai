<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>
<?php $role_resources_ids = $this->Umb_model->user_role_resource(); ?>
<?php $user_info = $this->Umb_model->read_user_info($session['user_id']);?>
<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('286',$role_resources_ids) || $user_info[0]->user_role_id==1) { ?>
      <li class="nav-item clickable"> 
        <a href="<?php echo site_url('admin/accounting/dashboard_accounting/');?>" data-link-data="<?php echo site_url('admin/accounting/dashboard_accounting/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon ion ion-md-speedometer"></span> 
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
      <li class="nav-item active"> 
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
<?php if(in_array('358',$role_resources_ids)) {?>
  <div class="card mb-4 <?php echo $get_animate;?>">
    <div id="accordion">
      <div class="card-header with-elements"> 
        <span class="card-header-title mr-2">
          <strong><?php echo $this->lang->line('umb_add_new');?></strong> 
          <?php echo $this->lang->line('umb_acc_biaya');?>
        </span>
        <div class="card-header-elements ml-md-auto"> 
          <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
            <button type="button" class="btn btn-xs btn-primary"> 
              <span class="ion ion-md-add"></span> 
              <?php echo $this->lang->line('umb_add_new');?>
            </button>
          </a> 
        </div>
      </div>
      <div id="add_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
        <div class="card-body">
          <?php $attributes = array('name' => 'add_biaya', 'id' => 'umb-form', 'autocomplete' => 'off');?>
          <?php $hidden = array('_user' => $session['user_id']);?>
          <?php echo form_open('admin/accounting/add_biaya', $attributes, $hidden);?>
          <div class="bg-white">
            <div class="box-block">
              <div class="row">
                <div class="col-md-7">
                  <div class="form-group">
                    <label for="bank_cash_id"><?php echo $this->lang->line('umb_acc_account');?> <span id="acc_saldo" style="display:none; font-weight:600; color:#F00;"></span></label>
                    <select name="bank_cash_id" class="from-account form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_acc_choose_account_type');?>">
                      <option value=""></option>
                      <?php foreach($all_bank_cash as $bank_cash) {?>
                        <option value="<?php echo $bank_cash->bankcash_id;?>" saldo-account="<?php echo $bank_cash->saldo_account;?>"><?php echo $bank_cash->nama_account;?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="month_year"><?php echo $this->lang->line('umb_jumlah');?></label>
                        <input class="form-control" name="jumlah" type="text" placeholder="<?php echo $this->lang->line('umb_jumlah');?>">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="tanggal_biaya"><?php echo $this->lang->line('umb_e_details_tanggal');?></label>
                        <input class="form-control date" placeholder="<?php echo date('Y-m-d');?>" readonly name="tanggal_biaya" type="text">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <?php if($user_info[0]->user_role_id==1 || in_array('314',$role_resources_ids)){ ?>
                      <div class="col-md-4">
                        <?php if($user_info[0]->user_role_id==1){ ?>
                          <div class="form-group">
                            <label for="department"><?php echo $this->lang->line('module_title_perusahaan');?></label>
                            <select class="form-control" name="perusahaan" id="aj_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_title_perusahaan');?>" required>
                              <option value=""><?php echo $this->lang->line('module_title_perusahaan');?></option>
                              <?php foreach($all_perusahaans as $perusahaan) {?>
                                <option value="<?php echo $perusahaan->perusahaan_id;?>"> <?php echo $perusahaan->name;?></option>
                              <?php } ?>
                            </select>
                          </div>
                        <?php } else {?>
                          <?php $eperusahaan_id = $user_info[0]->perusahaan_id;?>
                          <div class="form-group">
                            <label for="department"><?php echo $this->lang->line('module_title_perusahaan');?></label>
                            <select class="form-control" name="perusahaan" id="aj_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_title_perusahaan');?>" required>
                              <option value=""><?php echo $this->lang->line('module_title_perusahaan');?></option>
                              <?php foreach($all_perusahaans as $perusahaan) {?>
                                <?php if($eperusahaan_id == $perusahaan->perusahaan_id):?>
                                  <option value="<?php echo $perusahaan->perusahaan_id;?>"> <?php echo $perusahaan->name;?></option>
                                <?php endif;?>
                              <?php } ?>
                            </select>
                          </div>
                        <?php } ?>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="trainer_option"><?php echo $this->lang->line('umb_option_penerima_pembayaran');?></label>
                          <select disabled="disabled" class="form-control" name="option_penerima_pembayaran" id="option_penerima_pembayaran" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_option_penerima_pembayaran');?>">
                            <option value="1"><?php echo $this->lang->line('umb_internal_title');?></option>
                            <option value="2"><?php echo $this->lang->line('umb_external_title');?></option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group" id="data_penerima_pembayaran">
                          <label for="department"><?php echo $this->lang->line('umb_acc_penerima_pembayaran');?></label>
                          <select id="penerima_pembayaran_id" name="penerima_pembayaran_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_acc_choose_a_penerima_pembayaran');?>">
                            <option value=""><?php echo $this->lang->line('umb_acc_penerima_pembayaran');?></option>
                          </select>
                        </div>
                      </div>
                    <?php } else {?>
                      <input type="hidden" name="penerima_pembayaran_id" id="penerima_pembayaran_id" value="<?php echo $session['user_id'];?>" />
                      <input type="hidden" name="option_penerima_pembayaran" id="option_penerima_pembayaran" value="1" />
                      <input type="hidden" name="perusahaan" id="perusahaan" value="<?php echo $user_info[0]->perusahaan_id;?>" />
                    <?php } ?>
                    
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <label for="description"><?php echo $this->lang->line('umb_description');?></label>
                    <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('umb_description');?>" name="description" cols="30" rows="5" id="description"></textarea>
                  </div>
                  <div class='form-group'>
                    <fieldset class="form-group">
                      <label for="logo"><?php echo $this->lang->line('umb_acc_attach_file');?></label>
                      <input type="file" class="form-control-file" id="file_biaya" name="file_biaya">
                    </fieldset>
                  </div>
                </div>
              </div>
              <div class="row">
                <?php if($user_info[0]->user_role_id==1){ ?>
                 <div class="col-md-3">
                  <div class="form-group" id="ajax_kategori">
                    <input type="hidden" name="saldo_account" id="saldo_account" value="" />
                    <label for="karyawan"><?php echo $this->lang->line('umb_acc_kategori');?></label>
                    <select name="kategori_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_acc_choose_kategori');?>">
                      <option value=""></option>
                    </select>
                  </div>
                </div>
              <?php } else {?>
                <?php $eeperusahaan_id = $user_info[0]->perusahaan_id;?>
                <?php $types_biaya = $this->Keuangan_model->ajax_info_types_biaya_perusahaan($eeperusahaan_id);?>
                <div class="col-md-3">
                  <div class="form-group" id="ajax_kategori">
                    <input type="hidden" name="saldo_account" id="saldo_account" value="" />
                    <label for="karyawan"><?php echo $this->lang->line('umb_acc_kategori');?></label>
                    <select name="kategori_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_acc_choose_kategori');?>">
                      <option value=""></option>
                      <?php foreach($types_biaya as $type_biaya) {?>
                        <option value="<?php echo $type_biaya->type_biaya_id;?>"> <?php echo $type_biaya->name;?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              <?php } ?>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="payment_method"><?php echo $this->lang->line('umb_payment_method');?></label>
                  <select name="payment_method" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_choose_payment_method');?>">
                    <option value=""></option>
                    <?php foreach($get_all_payment_method as $payment_method) {?>
                      <option value="<?php echo $payment_method->payment_method_id;?>"> <?php echo $payment_method->method_name;?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="reference_biaya"><?php echo $this->lang->line('umb_acc_ref_no');?></label>
                  <input class="form-control" placeholder="<?php echo $this->lang->line('umb_acc_ref_example');?>" name="reference_biaya" type="text">
                  <br />
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
<div class="card <?php echo $get_animate;?>">
  <div class="card-header with-elements"> 
    <span class="card-header-title mr-2">
      <strong><?php echo $this->lang->line('umb_list_all');?></strong> 
      <?php echo $this->lang->line('umb_acc_biaya');?>
    </span> 
  </div>
  <div class="card-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="umb_table">
        <thead>
          <tr>
            <th><?php echo $this->lang->line('umb_action');?></th>
            <th><?php echo $this->lang->line('umb_acc_account');?></th>
            <th><?php echo $this->lang->line('umb_acc_penerima_pembayaran');?></th>
            <th><?php echo $this->lang->line('umb_jumlah');?></th>
            <th><?php echo $this->lang->line('umb_acc_kategori');?></th>
            <th><?php echo $this->lang->line('umb_acc_ref_no');?></th>
            <th><?php echo $this->lang->line('umb_acc_payment');?></th>
            <th><?php echo $this->lang->line('umb_e_details_tanggal');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
