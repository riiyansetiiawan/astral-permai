<?php $session = $this->session->userdata('username'); ?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>
<?php $role_resources_ids = $this->Umb_model->user_role_resource(); ?>
<?php $user_info = $this->Umb_model->read_user_info($session['user_id']);?>
<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <li class="nav-item active">
      <a href="#smartwizard-2-step-1" class="mb-3 nav-link">
        <span class="sw-done-icon ion ion-md-checkmark"></span>
        <span class="sw-icon ion ion-ios-keypad"></span>
        <?php echo $this->lang->line('hr_title_dashboard_accounting');?>
        <div class="text-muted small">Set up</div>
      </a>
    </li>
    <li class="nav-item done">
      <a href="#smartwizard-2-step-2" class="mb-3 nav-link">
        <span class="sw-done-icon ion ion-md-checkmark"></span>
        <span class="sw-icon ion ion-ios-color-wand"></span>
        <?php echo $this->lang->line('umb_acc_list_account');?>
        <div class="text-muted small">Add</div>
      </a>
    </li>
    <li class="nav-item done">
      <a href="#smartwizard-2-step-3" class="mb-3 nav-link">
        <span class="sw-done-icon ion ion-md-checkmark"></span>
        <span class="sw-icon ion ion-md-copy"></span>
        <?php echo $this->lang->line('umb_hr_new_deposit');?>
        <div class="text-muted small">Select pager options</div>
      </a>
    </li>
    <li class="nav-item done">
      <a href="#smartwizard-2-step-4" class="mb-3 nav-link">
        <span class="sw-done-icon ion ion-md-checkmark"></span>
        <span class="sw-icon ion ion-md-notifications-outline"></span>
        <?php echo $this->lang->line('umb_hr_new_biaya');?>
        <div class="text-muted small">Set up notifications</div>
      </a>
    </li>
    <li class="nav-item done">
      <a href="#smartwizard-2-step-5" class="mb-3 nav-link">
        <span class="sw-done-icon ion ion-md-checkmark"></span>
        <span class="sw-icon ion ion-md-notifications-outline"></span>
        <?php echo $this->lang->line('umb_acc_transfer');?>
        <div class="text-muted small">Set up notifications</div>
      </a>
    </li>
  </ul>
  <hr class="border-light m-0">
  <div class="mb-3 sw-container tab-content">
    <div id="smartwizard-2-step-1" class="animated fadeIn tab-pane step-content mt-3" style="display: block;">
      <div class="row">
        <div class="d-flex col-xl-12 align-items-stretch">
          <div class="card d-flex w-100 mb-4">
            <div class="row no-gutters row-bordered h-100">
              <div class="d-flex col-sm-6 col-md-3 col-lg-3 align-items-center">
                <a href="javascript:void(0)" class="card-body media align-items-center text-body">
                  <i class="lnr lnr-chart-bars display-4 d-block text-primary"></i>
                  <span class="media-body d-block ml-3">
                    <span class="text-big font-weight-bolder"><?php echo $this->Umb_model->currency_sign(dashboard_total_sales());?></span><br>
                    <small class="text-muted"><?php echo $this->lang->line('umb_total_deposit');?></small>
                  </span>
                </a>
                
              </div>
              <div class="d-flex col-sm-6 col-md-3 col-lg-3 align-items-center">
                <a href="javascript:void(0)" class="card-body media align-items-center text-body">
                  <i class="lnr lnr-hourglass display-4 d-block text-primary"></i>
                  <span class="media-body d-block ml-3">
                    <span class="text-big font-weight-bolder"><?php echo $this->Umb_model->currency_sign(dashboard_total_biaya());?></span><br>
                    <small class="text-muted"><?php echo $this->lang->line('umb_total_biayaa');?></small>
                  </span>
                </a>
              </div>
              <div class="d-flex col-sm-6 col-md-3 col-lg-3 align-items-center">
                <a href="javascript:void(0)" class="card-body media align-items-center text-body">
                  <i class="lnr lnr-checkmark-circle display-4 d-block text-primary"></i>
                  <span class="media-body d-block ml-3">
                    <span class="text-big font-weight-bolder"><?php echo dashboard_total_penerima_pembayarans();?></span><br>
                    <small class="text-muted"><?php echo $this->lang->line('umb_total_penerima_pembayarans');?></small>
                  </span>
                </a>
              </div>
              <div class="d-flex col-sm-6 col-md-3 col-lg-3 align-items-center">
                <a href="javascript:void(0)" class="card-body media align-items-center text-body">
                  <i class="lnr lnr-license display-4 d-block text-primary"></i>
                  <span class="media-body d-block ml-3">
                    <span class="text-big font-weight-bolder"><?php echo dashboard_total_pembayars();?></span><br>
                    <small class="text-muted"><?php echo $this->lang->line('umb_total_pembayars');?></small>
                  </span>
                </a>
                
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-8">
          <div class="card mb-4">
            <h6 class="card-header with-elements mb-2">
              <div class="card-header-title"><?php echo $this->lang->line('umb_invoices_summary');?></div>
              <div class="card-header-elements ml-auto">
                <a href="<?php echo site_url('admin/invoices/');?>"><button type="button" class="btn btn-default btn-xs md-btn-flat"><?php echo $this->lang->line('dashboard_show_more');?></button></a>
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
                    <td><a href="<?php echo site_url('admin/invoices/view/');?><?php echo $linvoices->invoice_id;?>" target="_blank"> <?php echo $linvoices->nomor_invoice;?> </a></td>
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
    </div>
  </div>
  <div id="smartwizard-2-step-2" class="animated fadeIn tab-pane step-content mt-3">
    <div class="row m-b-1">
      <?php if(in_array('4',$role_resources_ids)) {?>
        <div class="col-md-4">
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
                  <i class="fa fa-check-square-o"></i> 
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
      <div class="<?php echo $colmdval;?>">
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
              <table class="datatables-demo table table-striped table-bordered" id="umb_bank_cash_table">
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

  </div>
  <div id="smartwizard-2-step-3" class="animated fadeIn tab-pane step-content mt-3">
    <?php if(in_array('15',$role_resources_ids)) {?>
      <div class="card mb-4">
        <div id="accordion">
          <div class="card-header with-elements"> 
            <span class="card-header-title mr-2">
              <strong><?php echo $this->lang->line('umb_add_new');?></strong> 
              <?php echo $this->lang->line('umb_acc_deposit');?>
            </span>
            <div class="card-header-elements ml-md-auto">
              <a class="text-dark collapsed" data-toggle="collapse" href="#add_deposit_form" aria-expanded="false">
                <button type="button" class="btn btn-xs btn-primary"> 
                  <span class="ion ion-md-add"></span> 
                  <?php echo $this->lang->line('umb_add_new');?>
                </button>
              </a> 
            </div>
          </div>
          <div id="add_deposit_form" class="collapse add-form" data-parent="#accordion" style="">
            <div class="card-body">
              <?php $attributes = array('name' => 'add_deposit', 'id' => 'umb-form', 'autocomplete' => 'off');?>
              <?php $hidden = array('_user' => $session['user_id']);?>
              <?php echo form_open('admin/accounting/add_deposit', $attributes, $hidden);?>
              <div class="bg-white">
                <div class="box-block">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="type_award"><?php echo $this->lang->line('umb_acc_account');?></label>
                        <select name="bank_cash_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_acc_choose_account_type');?>">
                          <option value=""></option>
                          <?php foreach($all_bank_cash as $bank_cash) {?>
                            <option value="<?php echo $bank_cash->bankcash_id;?>"><?php echo $bank_cash->nama_account;?></option>
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
                            <label for="deposit_tanggal"><?php echo $this->lang->line('umb_e_details_tanggal');?></label>
                            <input class="form-control date" placeholder="<?php echo date('Y-m-d');?>" readonly name="deposit_tanggal" type="text">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="karyawan"><?php echo $this->lang->line('umb_acc_kategori');?></label>
                            <select name="kategori_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_acc_choose_kategori');?>">
                              <option value=""></option>
                              <?php foreach($all_list_kategoris_pendapatan as $kategori_pendapatan) {?>
                                <option value="<?php echo $kategori_pendapatan->kategori_id;?>"> <?php echo $kategori_pendapatan->name;?></option>
                              <?php } ?>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="karyawan"><?php echo $this->lang->line('umb_acc_pembayar');?></label>
                            <select name="pembayar_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_acc_choose_a_pembayar');?>">
                              <option value=""></option>
                              <?php foreach($all_pembayars as $pembayar) {?>
                                <option value="<?php echo $pembayar->pembayar_id;?>"> <?php echo $pembayar->nama_pembayar;?></option>
                              <?php } ?>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="description"><?php echo $this->lang->line('umb_description');?></label>
                        <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('umb_description');?>" name="description" cols="30" rows="5" id="description"></textarea>
                      </div>
                      <div class='form-group'>
                        <fieldset class="form-group">
                          <label for="logo"><?php echo $this->lang->line('umb_acc_attach_file');?></label>
                          <input type="file" class="form-control-file" id="file_deposit" name="file_deposit">
                        </fieldset>
                      </div>
                    </div>
                  </div>
                  <div class="row">
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
                        <label for="karyawan"><?php echo $this->lang->line('umb_acc_ref_no');?></label>
                        <input class="form-control" placeholder="<?php echo $this->lang->line('umb_acc_ref_example');?>" name="reference_deposit" type="text">
                        <br />
                      </div>
                    </div>
                  </div>
                  <div class="form-actions box-footer">
                    <button type="submit" class="btn btn-primary"> 
                      <i class="fa fa-check-square-o"></i> 
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
    <div class="card">
      <div class="card-header with-elements"> 
        <span class="card-header-title mr-2">
          <strong><?php echo $this->lang->line('umb_list_all');?></strong> 
          <?php echo $this->lang->line('umb_acc_deposit');?>
        </span>
      </div>
      <div class="card-body">
        <div class="box-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="umb_deposit_table">
            <thead>
              <tr>
                <th><?php echo $this->lang->line('umb_action');?></th>
                <th><?php echo $this->lang->line('umb_acc_account');?></th>
                <th><?php echo $this->lang->line('umb_acc_pembayar');?></th>
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
  </div>
  <div id="smartwizard-2-step-4" class="animated fadeIn tab-pane step-content mt-3">
    <?php if(in_array('358',$role_resources_ids)) {?>
      <div class="card mb-4">
        <div id="accordion">
          <div class="card-header with-elements"> 
            <span class="card-header-title mr-2">
              <strong><?php echo $this->lang->line('umb_add_new');?></strong> 
              <?php echo $this->lang->line('umb_acc_biaya');?>
            </span>
            <div class="card-header-elements ml-md-auto">
              <a class="text-dark collapsed" data-toggle="collapse" href="#add_biaya_form" aria-expanded="false">
                <button type="button" class="btn btn-xs btn-primary"> 
                  <span class="ion ion-md-add"></span> 
                  <?php echo $this->lang->line('umb_add_new');?>
                </button>
              </a> 
            </div>
          </div>
          <div id="add_biaya_form" class="collapse add-form" data-parent="#accordion" style="">
            <div class="card-body">
              <?php $attributes = array('name' => 'add_biaya', 'id' => 'umb-form', 'autocomplete' => 'off');?>
              <?php $hidden = array('_user' => $session['user_id']);?>
              <?php echo form_open('admin/accounting/add_biaya', $attributes, $hidden);?>
              <div class="bg-white">
                <div class="box-block">
                  <div class="row">
                    <div class="col-md-7">
                      <div class="form-group">
                        <label for="bank_cash_id">
                          <?php echo $this->lang->line('umb_acc_account');?>
                          <span id="acc_saldo" style="display:none; font-weight:600; color:#F00;"></span>
                        </label>
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
                    <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('umb_save');?> </button>
                  </div>
                </div>
              </div>
              <?php echo form_close(); ?> 
            </div>
          </div>
        </div>
      </div>
    <?php } ?>
    <div class="card">
      <div class="card-header with-elements"> 
        <span class="card-header-title mr-2">
          <strong><?php echo $this->lang->line('umb_list_all');?></strong> 
          <?php echo $this->lang->line('umb_acc_biaya');?>
        </span>
      </div>
      <div class="card-body">
        <div class="box-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="umb_biaya_table">
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
  </div>
  <div id="smartwizard-2-step-5" class="animated fadeIn tab-pane step-content mt-3">
    <?php if(in_array('17',$role_resources_ids)) {?>
      <div class="card mb-4">
        <div class="card-header with-elements"> 
          <span class="card-header-title mr-2">
            <strong><?php echo $this->lang->line('umb_add_new');?></strong> 
            <?php echo $this->lang->line('umb_acc_transfer');?>
          </span>
        </div>
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
                  <i class="fa fa-check-square-o"></i> 
                  <?php echo $this->lang->line('umb_save');?> 
                </button>
              </div>
            </div>
          </div>
          <?php echo form_close(); ?> 
        </div>
      </div>
    <?php } ?>
  </div>
</div>
</div>