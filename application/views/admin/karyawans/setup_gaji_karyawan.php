<?php $session = $this->session->userdata('username');?>
<?php $system = $this->Umb_model->read_setting_info(1);?>
<?php //$default_currency = $this->Umb_model->read_currency_con_info($system[0]->default_currency_id);?>
<?php
$eid = $this->uri->segment(4);
$eresult = $this->Karyawans_model->read_informasi_karyawan($eid);
?>
<?php
$ar_sc = explode('- ',$system[0]->default_currency_symbol);
$sc_show = $ar_sc[1];
$cuti_user = $this->Umb_model->read_user_info($eid);
?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>
<?php $kategoris_cuti_ids = explode(',',$kategoris_cuti);?>
<?php $view_perusahaans_ids = explode(',',$view_perusahaans_id);?>
<?php $user_info = $this->Umb_model->read_user_info($session['user_id']);?>
<?php $role_resources_ids = $this->Umb_model->user_role_resource(); ?>
<?php $laporans_to = get_data_laporans_team($session['user_id']); ?>
<div class="mb-3 sw-container tab-content">
  <div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
    <ul class="nav nav-tabs step-anchor">
     <?php if(in_array('351',$role_resources_ids)) { ?>  
      <li class="nav-item active"> 
        <a href="<?php echo site_url('admin/karyawans/setup_gaji/').$eid.'/';?>" class="mb-3 nav-link"> 
          <span class="sw-done-icon lnr lnr-highlight"></span> 
          <span class="sw-icon lnr lnr-highlight"></span> 
          <?php echo $this->lang->line('umb_karyawan_set_gaji');?>
          <div class="text-muted small"><?php echo $this->lang->line('umb_set_up').' '. $this->lang->line('umb_karyawan_set_gaji');?></div>
        </a> 
      </li>
    <?php } ?>
    <?php if(in_array('13',$role_resources_ids) || $laporans_to>0) {?>
      <li class="nav-item done"> 
        <a href="<?php echo site_url('admin/karyawans/');?>" data-link-data="<?php echo site_url('admin/karyawans/');?>" class="mb-3 nav-link hrastral-link"> 
          <span class="sw-done-icon fas fa-user-friends"></span> 
          <span class="sw-icon fas fa-user-friends"></span> 
          <?php echo $this->lang->line('dashboard_karyawans');?>
          <div class="text-muted small"><?php echo $this->lang->line('umb_set_up');?> <?php echo $this->lang->line('dashboard_karyawans');?></div>
        </a> 
      </li>
    <?php } ?>
  </ul>
  <hr class="border-light m-0">
  <div class="mb-3 sw-container tab-content">
    <?php if(in_array('351',$role_resources_ids)) { ?> 
      <div id="smartwizard-2-step-2" class="animated fadeIn tab-pane step-content mt-3" style="display: block;">
        <div class="cards-body">
          <div class="card overflow-hidden">
            <div class="row no-gutters row-bordered row-border-light">
              <div class="col-md-3 pt-0">
                <div class="list-group list-group-flush account-settings-links"> 
                  <a class="list-group-item list-group-item-action active" data-toggle="list" href="#account-update_gaji"> 
                    <i class="lnr lnr-strikethrough text-lightest"></i> &nbsp; <?php echo $this->lang->line('umb_karyawan_update_gaji');?>
                  </a> 
                  <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-tunjanagans"> 
                    <i class="lnr lnr-car text-lightest"></i> &nbsp; <?php echo $this->lang->line('umb_karyawan_set_tunjanagans');?>
                  </a> 
                  <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-komissi"> 
                    <i class="lnr lnr-graduation-hat text-lightest"></i> &nbsp; <?php echo $this->lang->line('umb_hr_komissi');?>
                  </a>  
                  <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-statutory_potongans">
                    <i class="lnr lnr-store text-lightest"></i> &nbsp; <?php echo $this->lang->line('umb_karyawan_set_statutory_potongans');?>
                  </a> 
                  <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-pembayaran_lainnya"> 
                    <i class="lnr lnr-tag text-lightest"></i> &nbsp; <?php echo $this->lang->line('umb_karyawan_set_pembayaran_lainnya');?>
                  </a> 
                  <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-lembur"> 
                    <i class="lnr lnr-tag text-lightest"></i> &nbsp; <?php echo $this->lang->line('dashboard_lembur');?>
                  </a> 
                  <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-pinjaman_potongans"> 
                    <i class="lnr lnr-location text-lightest"></i> &nbsp; <?php echo $this->lang->line('umb_karyawan_set_pinjaman_potongans');?>
                  </a>
                </div>
              </div>
              <div class="col-md-9">
                <div class="tab-content">
                  <div class="tab-pane fade show active" id="account-update_gaji">
                    <div class="card-body pb-2">
                      <?php $attributes = array('name' => 'karyawan_update_gaji', 'id' => 'karyawan_update_gaji', 'autocomplete' => 'off');?>
                      <?php $hidden = array('user_id' => $user_id, 'u_basic_info' => 'UPDATE');?>
                      <?php echo form_open('admin/karyawans/update_option_gaji', $attributes, $hidden);?>
                      <?php
                      $data_usr = array(
                        'type'  => 'hidden',
                        'name'  => 'user_id',
                        'id'    => 'user_id',
                        'value' => $user_id,
                      );
                      echo form_input($data_usr);
                      ?>
                      <div class="bg-white">
                        <div class="row">
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="type_upahh">
                                <?php echo $this->lang->line('umb_karyawan_type_wages');?>
                                <i class="hrastral-asterisk">*</i>
                              </label>
                              <select name="type_upahh" id="type_upahh" class="form-control" data-plugin="select_hrm">
                                <option value="1" <?php if($type_upahh==1):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('umb_payroll_gaji_pokok');?></option>
                                <option value="2" <?php if($type_upahh==2):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('umb_karyawan_upahh_harian');?></option>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="gaji_pokok">
                                <?php echo $this->lang->line('umb_gaji_title');?>
                                <i class="hrastral-asterisk">*</i>
                              </label>
                              <input class="form-control gaji_pokok" placeholder="<?php echo $this->lang->line('umb_gaji_title');?>" name="gaji_pokok" type="text" value="<?php echo $gaji_pokok;?>">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrastral_form', 'type' => 'submit', 'class' => $this->Umb_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('umb_save'))); ?> </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <?php echo form_close(); ?> 
                    </div>
                  </div>
                  <div class="tab-pane fade" id="account-tunjanagans">
                    <div class="box">
                      <div class="card-header with-elements"> 
                        <span class="card-header-title mr-2"> 
                          <strong> <?php echo $this->lang->line('umb_list_all');?></strong> 
                          <?php echo $this->lang->line('umb_karyawan_set_tunjanagans');?> 
                        </span> 
                      </div>
                      <div class="card-body">
                        <div class="box-datatable table-responsive">
                          <table class="table table-striped table-bordered dataTable" id="umb_table_all_tunjanagans" style="width:100%;">
                            <thead>
                              <tr>
                                <th><?php echo $this->lang->line('umb_action');?></th>
                                <th><?php echo $this->lang->line('dashboard_umb_title');?></th>
                                <th><?php echo $this->lang->line('umb_jumlah');?></th>
                                <th><?php echo $this->lang->line('umb_gaji_tunjanagan_options');?></th>
                                <th><?php echo $this->lang->line('umb_jumlah_option');?></th>
                              </tr>
                            </thead>
                          </table>
                        </div>
                      </div>
                    </div>
                    <div class="card-header with-elements"> 
                      <span class="card-header-title mr-2"> 
                        <strong> <?php echo $this->lang->line('umb_karyawan_set_tunjanagans');?></strong> 
                      </span> 
                    </div>
                    <div class="card-body pb-2">
                      <?php $attributes = array('name' => 'karyawan_update_tunjanagan', 'id' => 'karyawan_update_tunjanagan', 'autocomplete' => 'off');?>
                      <?php $hidden = array('u_basic_info' => 'UPDATE');?>
                      <?php echo form_open('admin/karyawans/option_tunjangan_karyawan', $attributes, $hidden);?>
                      <?php
                      $data_usr4 = array(
                        'type'  => 'hidden',
                        'name'  => 'user_id',
                        'value' => $user_id,
                      );
                      echo form_input($data_usr4);
                      ?>
                      <div class="row">
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="is_tunjanagan_kena_pajak">
                              <?php echo $this->lang->line('umb_gaji_tunjanagan_options');?>
                              <i class="hrastral-asterisk">*</i>
                            </label>
                            <select name="is_tunjanagan_kena_pajak" class="form-control" data-plugin="select_hrm">
                              <option value="0"><?php echo $this->lang->line('umb_gaji_tunjanagan_todak_kena_pajak');?></option>
                              <option value="1"><?php echo $this->lang->line('umb_fully_kena_pajak');?></option>
                              <option value="2"><?php echo $this->lang->line('umb_partially_kena_pajak');?></option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="jumlah_option">
                              <?php echo $this->lang->line('umb_jumlah_option');?>
                              <i class="hrastral-asterisk">*</i>
                            </label>
                            <select name="jumlah_option" class="form-control" data-plugin="select_hrm">
                              <option value="0"><?php echo $this->lang->line('umb_title_fixed_pajak');?></option>
                              <option value="1"><?php echo $this->lang->line('umb_title_percent_pajak');?></option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="account_title">
                              <?php echo $this->lang->line('dashboard_umb_title');?>
                              <i class="hrastral-asterisk">*</i>
                            </label>
                            <input class="form-control" placeholder="<?php echo $this->lang->line('dashboard_umb_title');?>" name="title_tunjanagan" type="text" value="" id="title_tunjanagan">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="nomor_account">
                              <?php echo $this->lang->line('umb_jumlah');?>
                              <i class="hrastral-asterisk">*</i>
                            </label>
                            <input class="form-control" placeholder="<?php echo $this->lang->line('umb_jumlah');?>" name="jumlah_tunjanagan" type="text" value="" id="jumlah_tunjanagan">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrastral_form', 'type' => 'submit', 'class' => $this->Umb_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('umb_save'))); ?> </div>
                          </div>
                        </div>
                      </div>
                      <?php echo form_close(); ?> 
                    </div>
                  </div>
                  <div class="tab-pane fade" id="account-komissi">
                    <div class="box">
                      <div class="card-header with-elements"> 
                        <span class="card-header-title mr-2"> 
                          <strong> <?php echo $this->lang->line('umb_list_all');?></strong> 
                          <?php echo $this->lang->line('umb_hr_komissi');?> 
                        </span> 
                      </div>
                      <div class="card-body">
                        <div class="box-datatable table-responsive">
                          <table class="table table-striped table-bordered dataTable" id="umb_table_all_komissi" style="width:100%;">
                            <thead>
                              <tr>
                                <th><?php echo $this->lang->line('umb_action');?></th>
                                <th><?php echo $this->lang->line('dashboard_umb_title');?></th>
                                <th><?php echo $this->lang->line('umb_jumlah');?></th>
                                <th><?php echo $this->lang->line('umb_gaji_opt_komisiions');?></th>
                                <th><?php echo $this->lang->line('umb_jumlah_option');?></th>
                              </tr>
                            </thead>
                          </table>
                        </div>
                      </div>
                    </div>
                    <div class="card-header with-elements"> 
                      <span class="card-header-title mr-2"> 
                        <strong> <?php echo $this->lang->line('umb_hr_komissi');?></strong> 
                      </span> 
                    </div>
                    <div class="card-body pb-2">
                      <?php $attributes = array('name' => 'karyawan_update_komissi', 'id' => 'karyawan_update_komissi', 'autocomplete' => 'off');?>
                      <?php $hidden = array('u_basic_info' => 'UPDATE');?>
                      <?php echo form_open('admin/karyawans/option_komissi_karyawan', $attributes, $hidden);?>
                      <?php
                      $data_usr4 = array(
                        'type'  => 'hidden',
                        'name'  => 'user_id',
                        'value' => $user_id,
                      );
                      echo form_input($data_usr4);
                      ?>
                      <div class="row">
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="is_komisi_kena_pajak">
                              <?php echo $this->lang->line('umb_gaji_opt_komisiions');?>
                              <i class="hrastral-asterisk">*</i>
                            </label>
                            <select name="is_komisi_kena_pajak" class="form-control" data-plugin="select_hrm">
                              <option value="0"><?php echo $this->lang->line('umb_gaji_tunjanagan_todak_kena_pajak');?></option>
                              <option value="1"><?php echo $this->lang->line('umb_fully_kena_pajak');?></option>
                              <option value="2"><?php echo $this->lang->line('umb_partially_kena_pajak');?></option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="jumlah_option">
                              <?php echo $this->lang->line('umb_jumlah_option');?>
                              <i class="hrastral-asterisk">*</i>
                            </label>
                            <select name="jumlah_option" class="form-control" data-plugin="select_hrm">
                              <option value="0"><?php echo $this->lang->line('umb_title_fixed_pajak');?></option>
                              <option value="1"><?php echo $this->lang->line('umb_title_percent_pajak');?></option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="title">
                              <?php echo $this->lang->line('dashboard_umb_title');?>
                              <i class="hrastral-asterisk">*</i>
                            </label>
                            <input class="form-control" placeholder="<?php echo $this->lang->line('dashboard_umb_title');?>" name="title" type="text" value="" id="title">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="jumlah">
                              <?php echo $this->lang->line('umb_jumlah');?>
                              <i class="hrastral-asterisk">*</i>
                            </label>
                            <input class="form-control" placeholder="<?php echo $this->lang->line('umb_jumlah');?>" name="jumlah" type="text" value="" id="jumlah">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrastral_form', 'type' => 'submit', 'class' => $this->Umb_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('umb_save'))); ?> </div>
                          </div>
                        </div>
                      </div>
                      <?php echo form_close(); ?> 
                    </div>
                  </div>
                  <div class="tab-pane fade" id="account-pinjaman_potongans">
                    <div class="box">
                      <div class="card-header with-elements"> 
                        <span class="card-header-title mr-2"> 
                          <strong> <?php echo $this->lang->line('umb_list_all');?></strong> 
                          <?php echo $this->lang->line('umb_karyawan_set_pinjaman_potongans');?> 
                        </span> 
                      </div>
                      <div class="card-body">
                        <div class="box-datatable table-responsive">
                          <table class="table table-striped table-bordered dataTable" id="umb_table_all_potongans" style="width:100%;">
                            <thead>
                              <tr>
                                <th><?php echo $this->lang->line('umb_action');?></th>
                                <th><?php echo $this->lang->line('umb_karyawan_set_pinjaman_potongans');?></th>
                                <th><?php echo $this->lang->line('umb_karyawan_angsuran_bulanan_title');?></th>
                                <th><?php echo $this->lang->line('umb_karyawan_waktu_pinjaman');?></th>
                              </tr>
                            </thead>
                          </table>
                        </div>
                      </div>
                    </div>
                    <div class="card-header with-elements"> 
                      <span class="card-header-title mr-2"> 
                        <strong> <?php echo $this->lang->line('umb_karyawan_set_pinjaman_potongans');?></strong> 
                      </span> 
                    </div>
                    <div class="card-body pb-2">
                      <?php $attributes = array('name' => 'add_pinjaman_info', 'id' => 'add_pinjaman_info', 'autocomplete' => 'off');?>
                      <?php $hidden = array('u_basic_info' => 'UPDATE');?>
                      <?php echo form_open('admin/karyawans/info_pinjaman_karyawan', $attributes, $hidden);?>
                      <?php
                      $data_usr4 = array(
                       'type'  => 'hidden',
                       'name'  => 'user_id',
                       'value' => $user_id,
                     );
                      echo form_input($data_usr4);
                      ?>
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="options_pinjaman">
                              <?php echo $this->lang->line('umb_gaji_options_pinjaman');?>
                              <i class="hrastral-asterisk">*</i>
                            </label>
                            <select name="options_pinjaman" id="options_pinjaman" class="form-control" data-plugin="select_hrm">
                              <option value="1"><?php echo $this->lang->line('umb_pinjaman_ssc_title');?></option>
                              <option value="2"><?php echo $this->lang->line('umb_pinjaman_hdmf_title');?></option>
                              <option value="0"><?php echo $this->lang->line('umb_pinjaman_other_sd_title');?></option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="month_year">
                              <?php echo $this->lang->line('dashboard_umb_title');?>
                              <i class="hrastral-asterisk">*</i>
                            </label>
                            <input class="form-control" placeholder="<?php echo $this->lang->line('dashboard_umb_title');?>" name="title_potongan_pinjaman" type="text">
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="edu_role">
                              <?php echo $this->lang->line('umb_karyawan_angsuran_bulanan_title');?>
                              <i class="hrastral-asterisk">*</i>
                            </label>
                            <input class="form-control" placeholder="<?php echo $this->lang->line('umb_karyawan_angsuran_bulanan_title');?>" name="angsuran_bulanan" type="text" id="m_angsuran_bulanan">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="month_year">
                              <?php echo $this->lang->line('umb_start_date');?>
                              <i class="hrastral-asterisk">*</i>
                            </label>
                            <input class="form-control date" placeholder="<?php echo $this->lang->line('umb_start_date');?>" readonly="readonly" name="start_date" type="text">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="end_date">
                              <?php echo $this->lang->line('umb_end_date');?>
                              <i class="hrastral-asterisk">*</i>
                            </label>
                            <input class="form-control date" readonly="readonly" placeholder="<?php echo $this->lang->line('umb_end_date');?>" name="end_date" type="text">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="description"><?php echo $this->lang->line('umb_alasan');?></label>
                            <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('umb_alasan');?>" name="reason" cols="30" rows="2" id="reason2"></textarea>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrastral_form', 'type' => 'submit', 'class' => $this->Umb_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('umb_save'))); ?> </div>
                          </div>
                        </div>
                      </div>
                      <?php echo form_close(); ?> 
                    </div>
                  </div>
                  <div class="tab-pane fade" id="account-statutory_potongans">
                    <div class="box">
                      <div class="card-header with-elements"> 
                        <span class="card-header-title mr-2"> 
                          <strong> <?php echo $this->lang->line('umb_list_all');?></strong> 
                          <?php echo $this->lang->line('umb_karyawan_set_statutory_potongans');?> 
                        </span> 
                      </div>
                      <div class="card-body">
                        <div class="box-datatable table-responsive">
                          <table class="table table-striped table-bordered dataTable" id="umb_table_all_statutory_potongans" style="width:100%;">
                            <thead>
                              <tr>
                                <th><?php echo $this->lang->line('umb_action');?></th>
                                <th><?php echo $this->lang->line('dashboard_umb_title');?></th>
                                <th><?php echo $this->lang->line('umb_jumlah');?></th>
                                <th><?php echo $this->lang->line('umb_gaji_sd_options');?></th>
                              </tr>
                            </thead>
                          </table>
                        </div>
                      </div>
                    </div>
                    <div class="card-header with-elements"> 
                      <span class="card-header-title mr-2"> 
                        <strong> <?php echo $this->lang->line('umb_karyawan_set_statutory_potongans');?></strong> 
                      </span> 
                    </div>
                    <div class="card-body pb-2">
                      <?php $attributes = array('name' => 'statutory_potongans_info', 'id' => 'statutory_potongans_info', 'autocomplete' => 'off');?>
                      <?php $hidden = array('u_basic_info' => 'UPDATE');?>
                      <?php echo form_open('admin/karyawans/set_statutory_potongans', $attributes, $hidden);?>
                      <?php
                      $data_usr4 = array(
                        'type'  => 'hidden',
                        'name'  => 'user_id',
                        'value' => $user_id,
                      );
                      echo form_input($data_usr4);
                      ?>
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="statutory_options">
                              <?php echo $this->lang->line('umb_gaji_sd_options');?>
                              <i class="hrastral-asterisk">*</i>
                            </label>
                            <select name="statutory_options" class="form-control" data-plugin="select_hrm">
                              <option value="0"><?php echo $this->lang->line('umb_title_fixed_pajak');?></option>
                              <option value="1"><?php echo $this->lang->line('umb_title_percent_pajak');?></option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-5">
                          <div class="form-group">
                            <label for="title">
                              <?php echo $this->lang->line('dashboard_umb_title');?>
                              <i class="hrastral-asterisk">*</i>
                            </label>
                            <input class="form-control" placeholder="<?php echo $this->lang->line('dashboard_umb_title');?>" name="title" type="text" value="" id="title">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="jumlah">
                              <?php echo $this->lang->line('umb_jumlah');?>
                              <i class="hrastral-asterisk">*</i> 
                            </label>
                            <input class="form-control" placeholder="<?php echo $this->lang->line('umb_jumlah');?>" name="jumlah" type="text" value="" id="jumlah">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrastral_form', 'type' => 'submit', 'class' => $this->Umb_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('umb_save'))); ?> </div>
                          </div>
                        </div>
                      </div>
                      <?php echo form_close(); ?> 
                    </div>
                  </div>
                  <div class="tab-pane fade" id="account-pembayaran_lainnya">
                    <div class="box">
                      <div class="card-header with-elements"> 
                        <span class="card-header-title mr-2"> 
                          <strong> <?php echo $this->lang->line('umb_list_all');?></strong> 
                          <?php echo $this->lang->line('umb_karyawan_set_pembayaran_lainnya');?> 
                        </span> 
                      </div>
                      <div class="card-body">
                        <div class="box-datatable table-responsive">
                          <table class="table table-striped table-bordered dataTable" id="umb_table_all_pembayarans_lainnya" style="width:100%;">
                            <thead>
                              <tr>
                                <th><?php echo $this->lang->line('umb_action');?></th>
                                <th><?php echo $this->lang->line('dashboard_umb_title');?></th>
                                <th><?php echo $this->lang->line('umb_jumlah');?></th>
                                <th><?php echo $this->lang->line('umb_gaji_otherpayment_options');?></th>
                                <th><?php echo $this->lang->line('umb_jumlah_option');?></th>
                              </tr>
                            </thead>
                          </table>
                        </div>
                      </div>
                    </div>
                    <div class="card-header with-elements"> 
                      <span class="card-header-title mr-2"> 
                        <strong> <?php echo $this->lang->line('umb_karyawan_set_pembayaran_lainnya');?></strong> 
                      </span> 
                    </div>
                    <div class="card-body pb-2">
                      <?php $attributes = array('name' => 'pembayarans_lainnya_info', 'id' => 'pembayarans_lainnya_info', 'autocomplete' => 'off');?>
                      <?php $hidden = array('u_basic_info' => 'UPDATE');?>
                      <?php echo form_open('admin/karyawans/set_pembayarans_lainnya', $attributes, $hidden);?>
                      <?php
                      $data_usr4 = array(
                        'type'  => 'hidden',
                        'name'  => 'user_id',
                        'value' => $user_id,
                      );
                      echo form_input($data_usr4);
                      ?>
                      <div class="row">
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="ia_pembayaranlainnya_kena_pajak">
                              <?php echo $this->lang->line('umb_gaji_otherpayment_options');?>
                              <i class="hrastral-asterisk">*</i>
                            </label>
                            <select name="ia_pembayaranlainnya_kena_pajak" class="form-control" data-plugin="select_hrm">
                              <option value="0"><?php echo $this->lang->line('umb_gaji_tunjanagan_todak_kena_pajak');?></option>
                              <option value="1"><?php echo $this->lang->line('umb_fully_kena_pajak');?></option>
                              <option value="2"><?php echo $this->lang->line('umb_partially_kena_pajak');?></option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="jumlah_option">
                              <?php echo $this->lang->line('umb_jumlah_option');?>
                              <i class="hrastral-asterisk">*</i>
                            </label>
                            <select name="jumlah_option" class="form-control" data-plugin="select_hrm">
                              <option value="0"><?php echo $this->lang->line('umb_title_fixed_pajak');?></option>
                              <option value="1"><?php echo $this->lang->line('umb_title_percent_pajak');?></option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="title">
                              <?php echo $this->lang->line('dashboard_umb_title');?>
                              <i class="hrastral-asterisk">*</i>
                            </label>
                            <input class="form-control" placeholder="<?php echo $this->lang->line('dashboard_umb_title');?>" name="title" type="text" value="" id="title">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="jumlah">
                              <?php echo $this->lang->line('umb_jumlah');?>
                              <i class="hrastral-asterisk">*</i>
                            </label>
                            <input class="form-control" placeholder="<?php echo $this->lang->line('umb_jumlah');?>" name="jumlah" type="text" value="" id="jumlah">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrastral_form', 'type' => 'submit', 'class' => $this->Umb_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('umb_save'))); ?> </div>
                          </div>
                        </div>
                      </div>
                      <?php echo form_close(); ?> 
                    </div>
                  </div>
                  <div class="tab-pane fade" id="account-lembur">
                    <div class="box">
                      <div class="card-header with-elements"> 
                        <span class="card-header-title mr-2"> 
                          <strong> <?php echo $this->lang->line('umb_list_all');?></strong> 
                          <?php echo $this->lang->line('dashboard_lembur');?> 
                        </span> 
                      </div>
                      <div class="card-body">
                        <div class="box-datatable table-responsive">
                          <table class="table table-striped table-bordered dataTable" id="umb_table_krywn_lembur" style="width:100%;">
                            <thead>
                              <tr>
                                <th><?php echo $this->lang->line('umb_action');?></th>
                                <th><?php echo $this->lang->line('umb_karyawan_title_lembur');?></th>
                                <th><?php echo $this->lang->line('umb_karyawan_lembur_no_of_days');?></th>
                                <th><?php echo $this->lang->line('umb_karyawan_jam_lembur');?></th>
                                <th><?php echo $this->lang->line('umb_karyawan_nilai_lembur');?></th>
                              </tr>
                            </thead>
                          </table>
                        </div>
                      </div>
                    </div>
                    <div class="card-header with-elements"> 
                      <span class="card-header-title mr-2"> 
                        <strong> <?php echo $this->lang->line('dashboard_lembur');?></strong> 
                      </span> 
                    </div>
                    <div class="card-body pb-2">
                      <?php $attributes = array('name' => 'lembur_info', 'id' => 'lembur_info', 'autocomplete' => 'off');?>
                      <?php $hidden = array('u_basic_info' => 'UPDATE');?>
                      <?php echo form_open('admin/karyawans/set_lembur', $attributes, $hidden);?>
                      <?php
                      $data_usr4 = array(
                        'type'  => 'hidden',
                        'name'  => 'user_id',
                        'value' => $user_id,
                      );
                      echo form_input($data_usr4);
                      ?>
                      <div class="row">
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="type_lembur">
                              <?php echo $this->lang->line('umb_karyawan_title_lembur');?>
                              <i class="hrastral-asterisk">*</i>
                            </label>
                            <input class="form-control" placeholder="<?php echo $this->lang->line('umb_karyawan_title_lembur');?>" name="type_lembur" type="text" value="" id="type_lembur">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="no_of_days">
                              <?php echo $this->lang->line('umb_karyawan_lembur_no_of_days');?>
                              <i class="hrastral-asterisk">*</i>
                            </label>
                            <input class="form-control" placeholder="<?php echo $this->lang->line('umb_karyawan_lembur_no_of_days');?>" name="no_of_days" type="text" value="" id="no_of_days">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="jam_lembur">
                              <?php echo $this->lang->line('umb_karyawan_jam_lembur');?>
                              <i class="hrastral-asterisk">*</i>
                            </label>
                            <input class="form-control" placeholder="<?php echo $this->lang->line('umb_karyawan_jam_lembur');?>" name="jam_lembur" type="text" value="" id="jam_lembur">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="nilai_lembur">
                              <?php echo $this->lang->line('umb_karyawan_nilai_lembur');?>
                              <i class="hrastral-asterisk">*</i>
                            </label>
                            <input class="form-control" placeholder="<?php echo $this->lang->line('umb_karyawan_nilai_lembur');?>" name="nilai_lembur" type="text" value="" id="nilai_lembur">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrastral_form', 'type' => 'submit', 'class' => $this->Umb_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('umb_save'))); ?> </div>
                          </div>
                        </div>
                      </div>
                      <?php echo form_close(); ?> 
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php }?>
  </div>
</div>
</div>
