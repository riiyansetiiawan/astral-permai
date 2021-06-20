<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>
<?php $role_resources_ids = $this->Umb_model->user_role_resource(); ?>
<?php $user_info = $this->Umb_model->read_user_info($session['user_id']);?>
<?php $system = $this->Umb_model->read_setting_info(1);?>
<?php $laporans_to = get_data_laporans_team($session['user_id']); ?>
<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('422',$role_resources_ids) && $user_info[0]->user_role_id==1) {?>
      <li class="nav-item clickable"> 
        <a href="<?php echo site_url('admin/karyawans/dashboard_staff/');?>" data-link-data="<?php echo site_url('admin/karyawans/dashboard_staff/');?>" class="mb-3 nav-link hrastral-link"> 
          <span class="sw-done-icon ion ion-md-speedometer"></span> 
          <span class="sw-icon ion ion-md-speedometer"></span> 
          <?php echo $this->lang->line('hr_title_dashboard_staff');?>
          <div class="text-muted small"><?php echo $this->lang->line('hr_title_dashboard_staff');?></div>
        </a> 
      </li>
    <?php } ?>
    <?php if(in_array('13',$role_resources_ids) || $laporans_to>0) {?>
      <li class="nav-item active"> 
        <a href="<?php echo site_url('admin/karyawans/');?>" data-link-data="<?php echo site_url('admin/karyawans/');?>" class="mb-3 nav-link hrastral-link"> 
          <span class="sw-done-icon fas fa-user-friends"></span> 
          <span class="sw-icon fas fa-user-friends"></span> 
          <?php echo $this->lang->line('dashboard_karyawans');?>
          <div class="text-muted small"><?php echo $this->lang->line('umb_set_up');?> <?php echo $this->lang->line('dashboard_karyawans');?></div>
        </a> 
      </li>
    <?php } ?>
    <?php if($user_info[0]->user_role_id==1) {?>
      <li class="nav-item clickable"> 
        <a href="<?php echo site_url('admin/roles/');?>" class="mb-3 nav-link hrastral-link" data-link-data="<?php echo site_url('admin/roles/');?>"> 
          <span class="sw-icon ion ion-md-unlock"></span> 
          <?php echo $this->lang->line('umb_role_urole');?>
          <div class="text-muted small"><?php echo $this->lang->line('left_set_roles');?></div>
        </a> 
      </li>
    <?php } ?>
    <?php if(in_array('7',$role_resources_ids)) { ?>
      <li class="nav-item clickable"> 
        <a href="<?php echo site_url('admin/timesheet/shift_kantor/');?>" data-link-data="<?php echo site_url('admin/timesheet/shift_kantor/');?>" class="mb-3 nav-link hrastral-link"> 
          <span class="sw-icon ion ion-md-clock"></span> 
          <?php echo $this->lang->line('left_shifts_kantor');?>
          <div class="text-muted small"><?php echo $this->lang->line('umb_role_create');?> <?php echo $this->lang->line('left_shifts_kantor');?></div>
        </a> 
      </li>
    <?php } ?>
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<?php $karyawan_id = $this->Umb_model->generate_random_karyawanid();?>
<?php $karyawan_pincode = $this->Umb_model->generate_random_pincode();?>
<?php if($user_info[0]->user_role_id==1){ ?>
  <div id="filter_hrastral" class="collapse add-formd <?php echo $get_animate;?>" data-parent="#accordion" style="">
    <div class="ui-bordered px-4 pt-4 mb-4 mt-3">
      <?php $attributes = array('name' => 'ihr_report', 'id' => 'ihr_report', 'autocomplete' => 'off', 'class' => 'add form-hrm');?>
      <?php $hidden = array('user_id' => $session['user_id']);?>
      <?php echo form_open('admin/karyawans/list_karyawans', $attributes, $hidden);?>
      <?php
      $data = array(
        'type'        => 'hidden',
        'name'        => 'date_format',
        'id'          => 'date_format',
        'value'       => $this->Umb_model->set_date_format(date('Y-m-d')),
        'class'       => 'form-control',
      );
      echo form_input($data);
      ?>
      <div class="form-row">
        <div class="col-md mb-3">
          <label class="form-label"><?php echo $this->lang->line('left_perusahaan');?></label>
          <select class="form-control" name="perusahaan_id" id="filter_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_perusahaan');?>">
            <option value="0"><?php echo $this->lang->line('umb_acc_all');?></option>
            <?php foreach($get_all_perusahaans as $perusahaan) {?>
              <option value="<?php echo $perusahaan->perusahaan_id?>"><?php echo $perusahaan->name?></option>
            <?php } ?>
          </select>
        </div>
        <div class="col-md mb-3" id="ajax_flt_location">
          <label class="form-label"><?php echo $this->lang->line('left_location');?></label>
          <select name="location_id" id="filter_location" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_location');?>">
            <option value="0"><?php echo $this->lang->line('umb_acc_all');?></option>
          </select>
        </div>
        <div class="col-md mb-3" id="department_ajaxflt">
          <label class="form-label"><?php echo $this->lang->line('left_department');?></label>
          <select class="form-control" id="filter_department" name="department_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_department');?>" >
            <option value="0"><?php echo $this->lang->line('umb_acc_all');?></option>
          </select>
        </div>
        <div class="col-md mb-3" id="penunjukan_ajaxflt">
          <label class="form-label"><?php echo $this->lang->line('umb_penunjukan');?></label>
          <select class="form-control" name="penunjukan_id" data-plugin="select_hrm"  id="filter_penunjukan" data-placeholder="<?php echo $this->lang->line('umb_penunjukan');?>">
            <option value="0"><?php echo $this->lang->line('umb_acc_all');?></option>
          </select>
        </div>
        <div class="col-md col-xl-2 mb-4">
          <label class="form-label d-none d-md-block">&nbsp;</label>
          <?php echo form_button(array('name' => 'hrastral_form', 'type' => 'submit', 'class' => 'btn btn-secondary btn-block', 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('umb_get'))); ?> </div>
        </div>
        <?php echo form_close(); ?> 
      </div>
    </div>
  <?php } ?>
  <?php if(in_array('201',$role_resources_ids)) {?>
    <div class="card mb-4">
      <div id="accordion">
        <div class="card-header with-elements"> 
          <span class="card-header-title mr-2">
            <strong><?php echo $this->lang->line('umb_add_new');?></strong> 
            <?php echo $this->lang->line('umb_karyawan');?></span>
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
              <?php $attributes = array('name' => 'add_karyawan', 'id' => 'umb-form', 'autocomplete' => 'off');?>
              <?php $hidden = array('_user' => $session['user_id']);?>
              <?php echo form_open_multipart('admin/karyawans/add_karyawan', $attributes, $hidden);?>
              <div class="form-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="first_name">
                            <?php echo $this->lang->line('umb_karyawan_first_name');?>
                            <i class="hrastral-asterisk">*</i>
                          </label>
                          <input class="form-control" placeholder="<?php echo $this->lang->line('umb_karyawan_first_name');?>" name="first_name" type="text" value="">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="last_name" class="control-label">
                            <?php echo $this->lang->line('umb_karyawan_last_name');?>
                            <i class="hrastral-asterisk">*</i>
                          </label>
                          <input class="form-control" placeholder="<?php echo $this->lang->line('umb_karyawan_last_name');?>" name="last_name" type="text" value="">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <?php if($user_info[0]->user_role_id==1){ ?>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="first_name">
                              <?php echo $this->lang->line('left_perusahaan');?>
                              <i class="hrastral-asterisk">*</i>
                            </label>
                            <select class="form-control" name="perusahaan_id" id="aj_perusahaan_emp" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_perusahaan');?>">
                              <option value=""><?php echo $this->lang->line('left_perusahaan');?></option>
                              <?php foreach($get_all_perusahaans as $perusahaan) {?>
                                <option value="<?php echo $perusahaan->perusahaan_id?>"><?php echo $perusahaan->name?></option>
                              <?php } ?>
                            </select>
                          </div>
                        </div>
                      <?php } else {?>
                        <?php $eperusahaan_id = $user_info[0]->perusahaan_id;?>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="first_name">
                              <?php echo $this->lang->line('left_perusahaan');?>
                              <i class="hrastral-asterisk">*</i>
                            </label>
                            <select class="form-control" name="perusahaan_id" id="aj_perusahaan_emp" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_perusahaan');?>">
                              <option value=""><?php echo $this->lang->line('left_perusahaan');?></option>
                              <?php foreach($get_all_perusahaans as $perusahaan) {?>
                                <?php if($eperusahaan_id == $perusahaan->perusahaan_id):?>
                                  <option value="<?php echo $perusahaan->perusahaan_id?>"><?php echo $perusahaan->name?></option>
                                <?php endif;?>
                              <?php } ?>
                            </select>
                          </div>
                        </div>
                      <?php } ?>
                      <div class="col-md-6" id="ajax_location">
                        <div class="form-group">
                          <label for="name">
                            <?php echo $this->lang->line('left_location');?>
                            <i class="hrastral-asterisk">*</i>
                          </label>
                          <select disabled="disabled" name="location_id" id="location_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_location');?>">
                            <option value=""><?php echo $this->lang->line('left_location');?></option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="username">
                            <?php echo $this->lang->line('dashboard_username');?>
                            <i class="hrastral-asterisk">*</i>
                          </label>
                          <input class="form-control" placeholder="<?php echo $this->lang->line('dashboard_username');?>" name="username" type="text" value="">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="email" class="control-label">
                            <?php echo $this->lang->line('dashboard_email');?>
                            <i class="hrastral-asterisk">*</i>
                          </label>
                          <input class="form-control" placeholder="<?php echo $this->lang->line('dashboard_email');?>" name="email" type="text" value="">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="tanggal_lahir">
                            <?php echo $this->lang->line('umb_karyawan_dob');?>
                            <i class="hrastral-asterisk">*</i>
                          </label>
                          <input class="form-control date" readonly placeholder="<?php echo $this->lang->line('umb_karyawan_dob');?>" name="tanggal_lahir" type="text" value="">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="no_kontak" class="control-label">
                            <?php echo $this->lang->line('umb_nomor_kontak');?>
                            <i class="hrastral-asterisk">*</i>
                          </label>
                          <input class="form-control" placeholder="<?php echo $this->lang->line('umb_nomor_kontak');?>" name="no_kontak" type="text" value="">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="karyawan_id">
                            <?php echo $this->lang->line('dashboard_karyawan_id');?>
                            <i class="hrastral-asterisk">*</i>
                          </label>
                          <input class="form-control" placeholder="<?php echo $this->lang->line('dashboard_karyawan_id');?>" name="karyawan_id" type="text" value="<?php echo $karyawan_id;?>">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="tanggal_bergabung" class="control-label">
                            <?php echo $this->lang->line('umb_karyawan_tgl_gabung');?>
                            <i class="hrastral-asterisk">*</i>
                          </label>
                          <input class="form-control date" readonly placeholder="<?php echo $this->lang->line('umb_karyawan_tgl_gabung');?>" name="tanggal_bergabung" type="text" value="<?php echo date('Y-m-d');?>">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <?php $colmd=4; if($system[0]->is_active_sub_departments=='yes'){ $ncolmd = 4; } else { $ncolmd = 6;}?>
                      <div class="col-md-<?php echo $ncolmd;?>">
                        <div class="form-group" id="department_ajax">
                          <label for="department">
                            <?php echo $this->lang->line('umb_hr_main_department');?>
                            <i class="hrastral-asterisk">*</i>
                          </label>
                          <select class="form-control" name="department_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_karyawan_department');?>" disabled="disabled">
                            <option value=""><?php echo $this->lang->line('umb_karyawan_department');?></option>
                          </select>
                        </div>
                      </div>
                      <?php $colmd=4; if($system[0]->is_active_sub_departments=='yes'){?>
                        <div class="col-md-4" id="subdepartment_ajax">
                          <div class="form-group">
                            <label for="penunjukan">
                              <?php echo $this->lang->line('umb_hr_sub_department');?>
                              <i class="hrastral-asterisk">*</i>
                            </label>
                            <select class="form-control" name="subdepartment_id" data-plugin="select_hrm" disabled="disabled" data-placeholder="<?php echo $this->lang->line('umb_hr_sub_department');?>">
                              <option value=""><?php echo $this->lang->line('umb_hr_sub_department');?></option>
                            </select>
                          </div>
                        </div>
                        <?php $colmd = '4'; } else { $colmd = '6';?>
                        <input type="hidden" name="subdepartment_id" value="YES" />
                      <?php } ?>
                      <div class="col-md-<?php echo $colmd;?>" id="penunjukan_ajax">
                        <div class="form-group">
                          <label for="penunjukan">
                            <?php echo $this->lang->line('umb_penunjukan');?>
                            <i class="hrastral-asterisk">*</i>
                          </label>
                          <select class="form-control" name="penunjukan_id" data-plugin="select_hrm" disabled="disabled" data-placeholder="<?php echo $this->lang->line('umb_penunjukan');?>">
                            <option value=""><?php echo $this->lang->line('umb_penunjukan');?></option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="jenis_kelamin" class="control-label"><?php echo $this->lang->line('umb_jenis_kelamin_karyawan');?></label>
                          <select class="form-control" name="jenis_kelamin" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_jenis_kelamin_karyawan');?>">
                            <option value="Pria"><?php echo $this->lang->line('umb_jenis_kelamin_pria');?></option>
                            <option value="Perempuan"><?php echo $this->lang->line('umb_jenis_kelamin_perempuan');?></option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group" id="ajax_shift_kantor">
                          <label for="shift_kantor_id" class="control-label"><?php echo $this->lang->line('umb_karyawan_shift_kantor');?></label>
                          <select class="form-control" name="shift_kantor_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_karyawan_shift_kantor');?>">
                            <option value=""><?php echo $this->lang->line('umb_karyawan_shift_kantor');?></option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="umb_password_karyawan">
                            <?php echo $this->lang->line('umb_password_karyawan');?>
                            <i class="hrastral-asterisk">*</i>
                          </label>
                          <input class="form-control" placeholder="<?php echo $this->lang->line('umb_password_karyawan');?>" name="password" type="text" value="">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="confirm_password" class="control-label">
                            <?php echo $this->lang->line('umb_karyawan_cpassword');?>
                            <i class="hrastral-asterisk">*</i>
                          </label>
                          <input class="form-control" placeholder="<?php echo $this->lang->line('umb_karyawan_cpassword');?>" name="confirm_password" type="text" value="">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="role">
                        <?php echo $this->lang->line('umb_karyawan_role');?>
                        <i class="hrastral-asterisk">*</i>
                      </label>
                      <select class="form-control" name="role" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_karyawan_role');?>">
                        <option value=""><?php echo $this->lang->line('umb_karyawan_role');?></option>
                        <?php foreach($all_user_roles as $role) {?>
                          <?php if($user_info[0]->user_role_id==1){?>
                            <option value="<?php echo $role->role_id?>"><?php echo $role->role_name?></option>
                          <?php } else {?>
                            <?php if($role->role_id!=1){?>
                              <option value="<?php echo $role->role_id?>"><?php echo $role->role_name?></option>
                            <?php } ?>
                          <?php } ?>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <?php if(!in_array('13',$role_resources_ids)) { ?>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="laporans_to"><?php echo $this->lang->line('umb_laporans_to');?></label>
                        <select name="laporans_to" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_laporans_to');?>">
                          <option value=""><?php echo $this->lang->line('umb_laporans_to');?></option>
                          <?php foreach(get_laporans_to() as $laporans_to) {?>
                            <?php if($laporans_to->user_id == $session['user_id']):?>
                              <option value="<?php echo $laporans_to->user_id?>" <?php if($laporans_to->user_id == $session['user_id']):?> selected="selected"<?php endif;?>><?php echo $laporans_to->first_name.' '.$laporans_to->last_name;?></option>
                            <?php endif;?>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                  <?php } else {?>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="laporans_to"><?php echo $this->lang->line('umb_laporans_to');?></label>
                        <select name="laporans_to" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_laporans_to');?>">
                          <option value=""><?php echo $this->lang->line('umb_laporans_to');?></option>
                          <?php foreach(get_laporans_to() as $laporans_to) {?>
                            <option value="<?php echo $laporans_to->user_id?>"><?php echo $laporans_to->first_name.' '.$laporans_to->last_name;?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                  <?php } ?>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="umb_hr_cuti_cat"><?php echo $this->lang->line('umb_hr_cuti_cat');?></label>
                      <input type="hidden" name="kategoris_cuti[]" value="0" />
                      <select multiple="multiple" class="form-control" name="kategoris_cuti[]" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_hr_cuti_cat');?>">
                        <option value=""><?php echo $this->lang->line('umb_hr_cuti_cat');?></option>
                        <?php foreach($all_types_cuti as $type_cuti) {?>
                          <option value="<?php echo $type_cuti->type_cuti_id?>"><?php echo $type_cuti->type_name?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="umb_pincode">
                        <?php echo $this->lang->line('umb_pincode');?>
                        <i class="hrastral-asterisk">*</i>
                      </label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('umb_pincode');?>" name="pin_code" type="text" value="<?php echo $karyawan_pincode;?>">
                    </div>
                  </div>
                  <div class="col-md-9">
                    <div class="form-group">
                      <label for="alamat"><?php echo $this->lang->line('umb_alamat_karyawan');?></label>
                      <input type="text" class="form-control" placeholder="<?php echo $this->lang->line('umb_alamat_karyawan');?>" name="alamat">
                    </div>
                  </div>
                </div>
              </div>
              <?php $count_module_attributes = $this->Custom_fields_model->count_module_attributes();?>
              <?php $module_attributes = $this->Custom_fields_model->all_hrastral_module_attributes();?>
              <?php if($count_module_attributes > 0):?>
                <div class="row">
                  <?php foreach($module_attributes as $mattribute):?>
                    <?php if($mattribute->attribute_type == 'date'){?>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="<?php echo $mattribute->attribute;?>"><?php echo $mattribute->attribute_label;?></label>
                          <input class="form-control date" placeholder="<?php echo $mattribute->attribute_label;?>" name="<?php echo $mattribute->attribute;?>" type="text">
                        </div>
                      </div>
                    <?php } else if($mattribute->attribute_type == 'select'){?>
                      <div class="col-md-4">
                        <?php $iselc_val = $this->Custom_fields_model->get_attribute_selection_values($mattribute->custom_field_id);?>
                        <div class="form-group">
                          <label for="<?php echo $mattribute->attribute;?>"><?php echo $mattribute->attribute_label;?></label>
                          <select class="form-control" name="<?php echo $mattribute->attribute;?>" data-plugin="select_hrm" data-placeholder="<?php echo $mattribute->attribute_label;?>">
                            <?php foreach($iselc_val as $selc_val) {?>
                              <option value="<?php echo $selc_val->attributes_select_value_id?>"><?php echo $selc_val->select_label?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                    <?php } else if($mattribute->attribute_type == 'multiselect'){?>
                      <div class="col-md-4">
                        <?php $imulti_selc_val = $this->Custom_fields_model->get_attribute_selection_values($mattribute->custom_field_id);?>
                        <div class="form-group">
                          <label for="<?php echo $mattribute->attribute;?>"><?php echo $mattribute->attribute_label;?></label>
                          <select multiple="multiple" class="form-control" name="<?php echo $mattribute->attribute;?>[]" data-plugin="select_hrm" data-placeholder="<?php echo $mattribute->attribute_label;?>">
                            <?php foreach($imulti_selc_val as $multi_selc_val) {?>
                              <option value="<?php echo $multi_selc_val->attributes_select_value_id?>"><?php echo $multi_selc_val->select_label?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                    <?php } else if($mattribute->attribute_type == 'textarea'){?>
                      <div class="col-md-8">
                        <div class="form-group">
                          <label for="<?php echo $mattribute->attribute;?>"><?php echo $mattribute->attribute_label;?></label>
                          <input class="form-control" placeholder="<?php echo $mattribute->attribute_label;?>" name="<?php echo $mattribute->attribute;?>" type="text">
                        </div>
                      </div>
                    <?php } else if($mattribute->attribute_type == 'fileupload'){?>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="<?php echo $mattribute->attribute;?>"><?php echo $mattribute->attribute_label;?></label>
                          <input class="form-control-file" name="<?php echo $mattribute->attribute;?>" type="file">
                        </div>
                      </div>
                    <?php } else { ?>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="<?php echo $mattribute->attribute;?>"><?php echo $mattribute->attribute_label;?></label>
                          <input class="form-control" placeholder="<?php echo $mattribute->attribute_label;?>" name="<?php echo $mattribute->attribute;?>" type="text">
                        </div>
                      </div>
                    <?php }	?>
                  <?php endforeach;?>
                </div>
              <?php endif;?>
              <div class="form-actions box-footer"> 
                <?php echo form_button(array('name' => 'hrastral_form', 'type' => 'submit', 'class' => $this->Umb_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('umb_save'))); ?> 
              </div>
              <?php echo form_close(); ?> 
            </div>
          </div>
        </div>
      </div>
    <?php }?>
    <?php if($user_info[0]->user_role_id==1){ ?>
      <div class="card">
        <div class="card-header with-elements"> 
          <span class="card-header-title mr-2">
            <strong><?php echo $this->lang->line('umb_list_all');?></strong> 
            <?php echo $this->lang->line('umb_karyawans');?></span>
            <div class="card-header-elements ml-md-auto"> 
              <a href="<?php echo site_url('admin/karyawans/hr/');?>" class="text-dark collapsed">
                <button type="button" class="btn btn-xs btn-primary"> 
                  <span class="ion ion-ios-cog"></span> 
                  <?php echo $this->lang->line('left_directory_karyawans');?>
                </button>
              </a> 
              <a class="text-dark collapsed" data-toggle="collapse" href="#filter_hrastral" aria-expanded="false">
                <button type="button" class="btn btn-xs btn-primary"> 
                  <span class="ion ion-ios-color-filter"></span> 
                  <?php echo $this->lang->line('umb_filter');?>
                </button>
              </a> 
              <a href="<?php echo site_url('admin/laporans/karyawans/');?>" class="text-dark collapsed">
                <button type="button" class="btn btn-xs btn-primary"> 
                  <span class="fas fa-chart-bar"></span> 
                  <?php echo $this->lang->line('umb_report');?>
                </button>
              </a> 
            </div>
          </div>
          <div class="card-body">
            <div class="box-datatable table-responsive">
              <table class="datatables-demo table table-striped table-bordered" id="umb_table">
                <thead>
                  <tr>
                    <th style="width:60px;"><?php echo $this->lang->line('umb_action');?></th>
                    <th><?php echo $this->lang->line('umb_karyawans_id');?></th>
                    <th width="200">
                      <i class="fa fa-user"></i> 
                      <?php echo $this->lang->line('umb_karyawans_full_name');?>
                    </th>
                    <th><?php echo $this->lang->line('left_perusahaan');?></th>
                    <th><?php echo $this->lang->line('dashboard_kontak');?></th>
                    <th><?php echo $this->lang->line('umb_laporans_to');?></th>
                    <th><?php echo $this->lang->line('umb_karyawan_role');?></th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      <?php } else {?>
        <div class="row">
          <div class="col-md-12"> 
            <div class="nav-tabs-custom">
              <div class="card">
                <ul class="nav nav-tabs">
                  <?php if(in_array('13',$role_resources_ids)) {?>
                    <li class="nav-item active"> 
                      <a class="nav-link active" data-toggle="tab" aria-controls="tabIcon11" href="#tab_1-1" aria-expanded="true"><?php echo $this->lang->line('umb_list_all');?> <?php echo $this->lang->line('umb_karyawans');?></a> 
                    </li>
                  <?php } ?>
                  <?php
                  if(!in_array('13',$role_resources_ids)) {
                    $act_cls = 'active';
                  } else {
                    $act_cls = '';
                  }
                  ?>
                  <li class="nav-item"> 
                    <a class="nav-link <?php echo $act_cls;?>" data-toggle="tab" aria-controls="tabIcon12" href="#tab_2-2" aria-expanded="false"> <?php echo $this->lang->line('umb_my_team');?></a> 
                  </li>
                </ul>
              </div>
              <div class="tab-content">
                <?php if(in_array('13',$role_resources_ids)) {?>
                  <div class="tab-pane active" id="tab_1-1">
                    <div class="card <?php echo $get_animate;?>">
                      <div class="card-header with-elements"> 
                        <span class="card-header-title mr-2">
                          <strong><?php echo $this->lang->line('umb_list_all');?></strong> 
                          <?php echo $this->lang->line('umb_karyawans');?>
                        </span> 
                        <?php if(in_array('88',$role_resources_ids)) {?>
                          <div class="card-header-elements ml-md-auto"> 
                            <a href="<?php echo site_url('admin/karyawans/hr/');?>" class="text-dark collapsed">
                              <button type="button" class="btn btn-xs btn-primary"> 
                                <span class="ion ion-ios-cog"></span> 
                                <?php echo $this->lang->line('left_directory_karyawans');?>
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
                                <th style="width:60px;"><?php echo $this->lang->line('umb_action');?></th>
                                <th><?php echo $this->lang->line('umb_karyawans_id');?></th>
                                <th width="200">
                                  <i class="fa fa-user"></i> 
                                  <?php echo $this->lang->line('umb_karyawans_full_name');?>
                                </th>
                                <th><?php echo $this->lang->line('left_perusahaan');?></th>
                                <th><?php echo $this->lang->line('dashboard_kontak');?></th>
                                <th><?php echo $this->lang->line('umb_laporans_to');?></th>
                                <th><?php echo $this->lang->line('umb_karyawan_role');?></th>
                              </tr>
                            </thead>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php } ?>
                <div class="tab-pane <?php echo $act_cls;?>" id="tab_2-2">
                  <div class="card <?php echo $get_animate;?>">
                    <div class="card-header with-elements"> 
                      <span class="card-header-title mr-2">
                        <strong><?php echo $this->lang->line('umb_my_team');?></strong>
                      </span>
                      <?php if(in_array('88',$role_resources_ids)) {?>
                        <div class="card-header-elements ml-md-auto"> 
                          <a href="<?php echo site_url('admin/karyawans/hr/');?>" class="text-dark collapsed">
                            <button type="button" class="btn btn-xs btn-primary"> 
                              <span class="ion ion-ios-cog"></span> 
                              <?php echo $this->lang->line('left_directory_karyawans');?>
                            </button>
                          </a> 
                        </div>
                      <?php } ?>
                    </div>
                    <div class="card-body">
                      <div class="box-datatable table-responsive">
                        <table class="datatables-demo table table-striped table-bordered" id="umb_my_team_table" style="width:100%;">
                          <thead>
                            <tr>
                              <th style="width:60px;"><?php echo $this->lang->line('umb_action');?></th>
                              <th><?php echo $this->lang->line('umb_karyawans_id');?></th>
                              <th width="200">
                                <i class="fa fa-user"></i> 
                                <?php echo $this->lang->line('umb_karyawans_full_name');?>
                              </th>
                              <th><?php echo $this->lang->line('left_perusahaan');?></th>
                              <th><?php echo $this->lang->line('dashboard_kontak');?></th>
                              <th><?php echo $this->lang->line('umb_laporans_to');?></th>
                              <th><?php echo $this->lang->line('umb_karyawan_role');?></th>
                            </tr>
                          </thead>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>
