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
<div class="mb-3 sw-container tab-content">
  <div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
    <ul class="nav nav-tabs step-anchor">
      <li class="nav-item active"> 
        <a href="#smartwizard-2-step-1" class="mb-3 nav-link"> 
          <span class="sw-done-icon ion lnr lnr-users"></span> 
          <span class="sw-icon lnr lnr-users"></span> 
          <?php echo $this->lang->line('umb_general');?>
          <div class="text-muted small"><?php echo $this->lang->line('umb_e_details_basic');?></div>
        </a> 
      </li>
      <?php if(in_array('351',$role_resources_ids)) { ?>  
        <li class="nav-item done"> 
          <a href="#smartwizard-2-step-2" class="mb-3 nav-link"> 
            <span class="sw-done-icon lnr lnr-highlight"></span> 
            <span class="sw-icon lnr lnr-highlight"></span> 
            <?php echo $this->lang->line('umb_karyawan_set_gaji');?>
            <div class="text-muted small">
              <?php echo $this->lang->line('umb_set_up').' '. $this->lang->line('umb_karyawan_set_gaji');?></div>
            </a> 
          </li>
        <?php } ?>
        <li class="nav-item done"> 
          <a href="#smartwizard-2-step-3" class="mb-3 nav-link"> 
            <span class="sw-done-icon lnr lnr-calendar-full"></span> 
            <span class="sw-icon lnr lnr-calendar-full"></span> 
            <?php echo $this->lang->line('left_cutii');?>
            <div class="text-muted small"><?php echo $this->lang->line('umb_view_cuti_all');?></div>
          </a> 
        </li>
        <li class="nav-item done"> 
          <a href="#smartwizard-2-step-4" class="mb-3 nav-link"> 
            <span class="sw-done-icon lnr lnr-earth"></span> 
            <span class="sw-icon lnr lnr-earth"></span> 
            <?php echo $this->lang->line('umb_hr');?>
            <div class="text-muted small"><?php echo $this->lang->line('umb_view_core_hr_modules');?></div>
          </a> 
        </li>
        <li class="nav-item done"> 
          <a href="#smartwizard-2-step-5" class="mb-3 nav-link"> 
            <span class="sw-done-icon lnr lnr-layers"></span> 
            <span class="sw-icon lnr lnr-layers"></span> 
            <?php echo $this->lang->line('umb_hr_m_project_tugas');?>
            <div class="text-muted small"><?php echo $this->lang->line('umb_view_all_projects');?></div>
          </a> 
        </li>
        <li class="nav-item done"> 
          <a href="#smartwizard-2-step-6" class="mb-3 nav-link"> 
            <span class="sw-done-icon lnr lnr-keyboard"></span> 
            <span class="sw-icon lnr lnr-keyboard"></span> 
            <?php echo $this->lang->line('left_slipgajii');?>
            <div class="text-muted small"><?php echo $this->lang->line('umb_view_slipgajii_all');?></div>
          </a> 
        </li>
      </ul>
      <hr class="border-light m-0">
      <div class="mb-3 sw-container tab-content">
        <div id="smartwizard-2-step-1" class="card animated fadeIn tab-pane step-content mt-3" style="display: block;">
          <div class="cards-body">
            <div class="card overflow-hidden">
              <div class="row no-gutters row-bordered row-border-light">
                <div class="col-md-3 pt-0">
                  <div class="list-group list-group-flush account-settings-links"> 
                    <a class="list-group-item list-group-item-action active" data-toggle="list" href="#account-basic_info">
                      <i class="lnr lnr-user text-lightest"></i> &nbsp; 
                      <?php echo $this->lang->line('umb_e_details_basic');?>
                    </a> 
                    <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-profile_picture"> 
                      <i class="lnr lnr-picture text-lightest"></i> &nbsp; 
                      <?php echo $this->lang->line('umb_e_details_profile_picture');?>
                    </a> 
                    <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-immigration">
                      <i class="lnr lnr-rocket text-lightest"></i> &nbsp; 
                      <?php echo $this->lang->line('umb_karyawan_immigration');?>
                    </a> 
                    <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-kontaks"> 
                      <i class="lnr lnr-phone-handset text-lightest"></i> &nbsp; 
                      <?php echo $this->lang->line('umb_karyawan_emergency_kontaks');?>
                    </a> 
                    <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-social"> 
                      <i class="lnr lnr-earth text-lightest"></i> &nbsp; 
                      <?php echo $this->lang->line('umb_e_details_social');?>
                    </a> 
                    <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-document"> 
                      <i class="lnr lnr-file-add text-lightest"></i> &nbsp; 
                      <?php echo $this->lang->line('umb_e_details_document');?>
                    </a> 
                    <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-qualification"> 
                      <i class="lnr lnr-file-empty text-lightest"></i> &nbsp; 
                      <?php echo $this->lang->line('umb_e_details_qualification');?>
                    </a> 
                    <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-pengalaman">
                      <i class="lnr lnr-hourglass text-lightest"></i> &nbsp; 
                      <?php echo $this->lang->line('umb_e_details_pengalaman_krj');?>
                    </a> 
                    <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-baccount"> 
                      <i class="lnr lnr-apartment text-lightest"></i> &nbsp; 
                      <?php echo $this->lang->line('umb_e_details_baccount');?>
                    </a> 
                    <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-cpassword">
                      <i class="lnr lnr-lock text-lightest"></i> &nbsp; 
                      <?php echo $this->lang->line('umb_e_details_cpassword');?>
                    </a> 
                    <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-security_level"> 
                      <i class="lnr lnr-link text-lightest"></i> &nbsp; 
                      <?php echo $this->lang->line('umb_esecurity_level_title');?>
                    </a> 
                    <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-kontrak"> 
                      <i class="lnr lnr-pencil text-lightest"></i> &nbsp; 
                      <?php echo $this->lang->line('umb_e_details_kontrak');?>
                    </a> 
                  </div>
                </div>
                <div class="col-md-9">
                  <div class="tab-content">
                    <div class="tab-pane fade show active" id="account-basic_info">
                      <div class="card-body media align-items-center">
                        <?php if($profile_picture!='' && $profile_picture!='no file') {?>
                          <img src="<?php echo base_url().'uploads/profile/'.$profile_picture;?>" class="d-block ui-w-80" id="u_file">
                        <?php } else {?>
                          <?php if($jenis_kelamin=='Pria') { ?>
                            <?php $de_file = base_url().'uploads/profile/default_male.jpg';?>
                          <?php } else { ?>
                            <?php $de_file = base_url().'uploads/profile/default_female.jpg';?>
                          <?php } ?>
                          <img src="<?php echo $de_file;?>" class="d-block ui-w-80" id="u_file">
                        <?php } ?>
                        <div class="media-body ml-4"> 
                          <a target="_blank" href="<?php echo site_url('admin/karyawans/download_profile/').$user_id;?>">
                            <label class="btn btn-outline-primary"> 
                              <?php echo $this->lang->line('umb_download_profile_title');?> 
                            </label>
                          </a>
                          <div class="text-light  mt-1"><?php echo $first_name;?> <?php echo $last_name;?></div>
                          <?php $info_shift = $this->Karyawans_model->read_infomasi_shift($shift_kantor_id); ?>
                          <?php
                          if(!is_null($info_shift)){
                            $nama_shift = $info_shift[0]->nama_shift;
                          } else {
                            $nama_shift = '--';
                          }
                          ?>
                          <div class="text-light  mt-1"><?php echo $this->lang->line('umb_e_details_shift');?> - <?php echo $nama_shift;?></div>
                        </div>
                      </div>
                      <hr class="border-light m-0">
                      <div class="card-body">
                        <?php $attributes = array('name' => 'basic_info', 'id' => 'basic_info', 'autocomplete' => 'off');?>
                        <?php $hidden = array('user_id' => $user_id, 'u_basic_info' => 'UPDATE');?>
                        <?php echo form_open_multipart('admin/karyawans/basic_info', $attributes, $hidden);?>
                        <div class="bg-white">
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="first_name">
                                  <?php echo $this->lang->line('umb_karyawan_first_name');?>
                                  <i class="hrastral-asterisk">*</i>
                                </label>
                                <input class="form-control" placeholder="<?php echo $this->lang->line('umb_karyawan_first_name');?>" name="first_name" type="text" value="<?php echo $first_name;?>">
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="last_name" class="control-label">
                                  <?php echo $this->lang->line('umb_karyawan_last_name');?>
                                  <i class="hrastral-asterisk">*</i>
                                </label>
                                <input class="form-control" placeholder="<?php echo $this->lang->line('umb_karyawan_last_name');?>" name="last_name" type="text" value="<?php echo $last_name;?>">
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="karyawan_id">
                                  <?php echo $this->lang->line('dashboard_karyawan_id');?>
                                  <i class="hrastral-asterisk">*</i>
                                </label>
                                <input class="form-control" placeholder="<?php echo $this->lang->line('dashboard_karyawan_id');?>" name="karyawan_id" type="text" value="<?php echo $karyawan_id;?>">
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="username">
                                  <?php echo $this->lang->line('dashboard_username');?>
                                  <i class="hrastral-asterisk">*</i>
                                </label>
                                <input class="form-control" placeholder="<?php echo $this->lang->line('dashboard_username');?>" name="username" type="text" value="<?php echo $username;?>">
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="email" class="control-label">
                                  <?php echo $this->lang->line('dashboard_email');?>
                                  <i class="hrastral-asterisk">*</i>
                                </label>
                                <input class="form-control" placeholder="<?php echo $this->lang->line('dashboard_email');?>" name="email" type="text" value="<?php echo $email;?>">
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <?php if($user_info[0]->user_role_id==1){ ?>
                              <div class="col-md-4">
                                <div class="form-group">
                                  <label for="first_name">
                                    <?php echo $this->lang->line('left_perusahaan');?>
                                    <i class="hrastral-asterisk">*</i>
                                  </label>
                                  <select class="form-control" name="perusahaan_id" id="aj_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_perusahaan');?>">
                                    <option value=""></option>
                                    <?php foreach($get_all_perusahaans as $perusahaan) {?>
                                      <option value="<?php echo $perusahaan->perusahaan_id?>" <?php if($perusahaan_id==$perusahaan->perusahaan_id):?> selected="selected"<?php endif;?>><?php echo $perusahaan->name?></option>
                                    <?php } ?>
                                  </select>
                                </div>
                              </div>
                            <?php } 
                            else { ?>
                              <?php $eperusahaan_id = $user_info[0]->perusahaan_id;?>
                              <div class="col-md-4">
                                <div class="form-group">
                                  <label for="first_name">
                                    <?php echo $this->lang->line('left_perusahaan');?>
                                    <i class="hrastral-asterisk">*</i>
                                  </label>
                                  <select class="form-control" name="perusahaan_id" id="aj_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_perusahaan');?>">
                                    <option value=""></option>
                                    <?php foreach($get_all_perusahaans as $perusahaan) {?>
                                      <?php if($eperusahaan_id == $perusahaan->perusahaan_id):?>
                                        <option value="<?php echo $perusahaan->perusahaan_id?>" <?php if($perusahaan_id==$perusahaan->perusahaan_id):?> selected="selected"<?php endif;?>><?php echo $perusahaan->name?></option>
                                      <?php endif; ?>
                                    <?php } ?>
                                  </select>
                                </div>
                              </div>
                            <?php } ?>
                            <?php $colmd=4;
                            if($system[0]->is_active_sub_departments=='yes'){
                              $colmd=4;
                              $is_id= 'aj_subdepartments';
                            } else {
                              $colmd=4;
                              $is_id= 'is_aj_subdepartments';
                            }?>
                            <?php //$eall_departments = $this->Perusahaan_model->ajax_perusahaan_info_departments($perusahaan_id);?>
                            <?php $el_result = $this->Department_model->info_location_perusahaan($perusahaan_id);?>
                            <?php $eall_departments = $this->Department_model->ajax_informasi_location_departments($location_id);?>
                            <div class="col-md-4" id="ajax_location">
                              <div class="form-group">
                                <label for="name">
                                  <?php echo $this->lang->line('left_location');?>
                                  <i class="hrastral-asterisk">*</i>
                                </label>
                                <select name="location_id" id="location_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_location');?>">
                                  <?php foreach($el_result as $location) {?>
                                    <option value="<?php echo $location->location_id?>" <?php if($location_id == $location->location_id):?> selected="selected"<?php endif;?>><?php echo $location->nama_location?></option>
                                  <?php } ?>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-<?php echo $colmd;?>">
                              <div class="form-group" id="department_ajax">
                                <label for="department">
                                  <?php echo $this->lang->line('umb_karyawan_department');?>
                                  <i class="hrastral-asterisk">*</i>
                                </label>
                                <select class="form-control" name="department_id" id="<?php echo $is_id;?>" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_karyawan_department');?>">
                                  <option value=""></option>
                                  <?php foreach($eall_departments as $department) {?>
                                    <option value="<?php echo $department->department_id?>" <?php if($department_id==$department->department_id):?> selected <?php endif;?>><?php echo $department->nama_department?></option>
                                  <?php } ?>
                                </select>
                              </div>
                            </div>
                          </div>
                          <?php if($system[0]->is_active_sub_departments=='yes'){?>
                            <?php $eall_penunjukans = $this->Penunjukan_model->ajax_informasi_penunjukan($sub_department_id);?>
                          <?php } else {?>
                            <?php $eall_penunjukans = $this->Penunjukan_model->ajax_is_informasi_penunjukan($department_id);?>
                          <?php } ?>
                          <div class="row">
                            <?php $colmd=3; if($system[0]->is_active_sub_departments=='yes'){ $ncolmd = 3; } else { $ncolmd = 4;}?>
                            <?php if($system[0]->is_active_sub_departments=='yes'){?>
                              <div class="col-md-<?php echo $ncolmd;?>" id="subdepartment_ajax">
                                <?php $depid = $eresult[0]->department_id; ?>
                                <?php if(!isset($depid)): $depid = 1; else: $depid = $depid; endif;?>
                                <?php $subresult = get_sub_departments($depid);?>
                                <div class="form-group">
                                  <label for="penunjukan">
                                    <?php echo $this->lang->line('umb_hr_sub_department');?>
                                    <i class="hrastral-asterisk">*</i>
                                  </label>
                                  <select class="form-control" name="subdepartment_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_karyawan_department');?>" id="aj_subdepartment">
                                    <option value=""></option>
                                    <?php foreach($subresult as $sbdeparment) {?>
                                      <option value="<?php echo $sbdeparment->sub_department_id;?>" <?php if($sub_department_id==$sbdeparment->sub_department_id):?> selected <?php endif;?>><?php echo $sbdeparment->nama_department;?></option>
                                    <?php } ?>
                                  </select>
                                </div>
                              </div>
                            <?php } else {?>
                              <input type="hidden" name="subdepartment_id" value="0" />
                            <?php } ?>
                            <div class="col-md-<?php echo $ncolmd;?>">
                              <div class="form-group" id="penunjukan_ajax">
                                <label for="penunjukan">
                                  <?php echo $this->lang->line('umb_penunjukan');?>
                                  <i class="hrastral-asterisk">*</i>
                                </label>
                                <select class="form-control" name="penunjukan_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_penunjukan');?>">
                                  <option value=""></option>
                                  <?php foreach($eall_penunjukans as $penunjukan) {?>
                                    <option value="<?php echo $penunjukan->penunjukan_id?>" <?php if($penunjukan_id==$penunjukan->penunjukan_id):?> selected <?php endif;?>><?php echo $penunjukan->nama_penunjukan?></option>
                                  <?php } ?>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-<?php echo $ncolmd;?>">
                              <div class="form-group">
                                <label for="tanggal_bergabung" class="control-label">
                                  <?php echo $this->lang->line('umb_karyawan_tgl_gabung');?>
                                  <i class="hrastral-asterisk">*</i>
                                </label>
                                <input class="form-control date" readonly placeholder="<?php echo $this->lang->line('umb_karyawan_tgl_gabung');?>" name="tanggal_bergabung" type="text" value="<?php echo $tanggal_bergabung;?>">
                              </div>
                            </div>
                            <div class="col-md-<?php echo $ncolmd;?>">
                              <div class="form-group">
                                <label for="date_of_leaving" class="control-label"><?php echo $this->lang->line('umb_karyawan_dol');?></label>
                                <input class="form-control date" readonly placeholder="<?php echo $this->lang->line('umb_karyawan_dol');?>" name="date_of_leaving" type="text" value="<?php echo $date_of_leaving;?>">
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="role">
                                  <?php echo $this->lang->line('umb_karyawan_role');?>
                                  <i class="hrastral-asterisk">*</i>
                                </label>
                                <select class="form-control" name="role" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_karyawan_role');?>">
                                  <option value=""></option>
                                  <?php foreach($all_user_roles as $role) {?>
                                    <?php if($user_info[0]->user_role_id==1){?>
                                      <option value="<?php echo $role->role_id?>" <?php if($user_role_id==$role->role_id):?> selected <?php endif;?>><?php echo $role->role_name?></option>
                                    <?php } else {?>
                                      <?php if($role->role_id!=1){?>
                                        <option value="<?php echo $role->role_id?>" <?php if($user_role_id==$role->role_id):?> selected <?php endif;?>><?php echo $role->role_name?></option>
                                      <?php } ?>
                                    <?php } ?>
                                  <?php } ?>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="jenis_kelamin" class="control-label"><?php echo $this->lang->line('umb_jenis_kelamin_karyawan');?></label>
                                <select class="form-control" name="jenis_kelamin" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_jenis_kelamin_karyawan');?>">
                                  <option value="Pria" <?php if($jenis_kelamin=='Pria'):?> selected <?php endif; ?>>Pria</option>
                                  <option value="Perempuan" <?php if($jenis_kelamin=='Perempuan'):?> selected <?php endif; ?>>Perempuan</option>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="status_perkawinan" class="control-label"><?php echo $this->lang->line('umb_karyawan_mstatus');?></label>
                                <select class="form-control" name="status_perkawinan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_karyawan_mstatus');?>">
                                  <option value="Single" <?php if($status_perkawinan=='Single'):?> selected <?php endif; ?>><?php echo $this->lang->line('umb_status_single');?></option>
                                  <option value="Married" <?php if($status_perkawinan=='Married'):?> selected <?php endif; ?>><?php echo $this->lang->line('umb_status_married');?></option>
                                  <option value="Widowed" <?php if($status_perkawinan=='Widowed'):?> selected <?php endif; ?>><?php echo $this->lang->line('umb_status_widowed');?></option>
                                  <option value="Divorced or Separated" <?php if($status_perkawinan=='Divorced or Separated'):?> selected <?php endif; ?>><?php echo $this->lang->line('umb_status_divorced_separated');?></option>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="no_kontak" class="control-label">
                                  <?php echo $this->lang->line('umb_nomor_kontak');?>
                                  <i class="hrastral-asterisk">*</i>
                                </label>
                                <input class="form-control" placeholder="<?php echo $this->lang->line('umb_nomor_kontak');?>" name="no_kontak" type="text" value="<?php echo $no_kontak;?>">
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="status" class="control-label"><?php echo $this->lang->line('dashboard_umb_status');?></label>
                                <select class="form-control" name="status" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('dashboard_umb_status');?>">
                                  <option value="0" <?php if($is_active=='0'):?> selected <?php endif; ?>><?php echo $this->lang->line('umb_karyawans_inactive');?></option>
                                  <option value="1" <?php if($is_active=='1'):?> selected <?php endif; ?>><?php echo $this->lang->line('umb_karyawans_active');?></option>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group" id="ajax_shift_kantor">
                                <?php $e_shifts_kantor = $this->Karyawans_model->ajax_perusahaan_informasi_shift_kantor($perusahaan_id);?>
                                <label for="shift_kantor_id" class="control-label"><?php echo $this->lang->line('umb_karyawan_shift_kantor');?></label>
                                <select class="form-control" name="shift_kantor_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_karyawan_shift_kantor');?>">
                                  <?php foreach($e_shifts_kantor as $shift) {?>
                                    <option value="<?php echo $shift->shift_kantor_id?>" <?php if($shift_kantor_id == $shift->shift_kantor_id):?> selected="selected" <?php endif; ?>><?php echo $shift->nama_shift?></option>
                                  <?php } ?>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="tanggal_lahir">
                                  <?php echo $this->lang->line('umb_karyawan_dob');?>
                                  <i class="hrastral-asterisk">*</i>
                                </label>
                                <input class="form-control date" readonly placeholder="<?php echo $this->lang->line('umb_karyawan_dob');?>" name="tanggal_lahir" type="text" value="<?php echo $tanggal_lahir;?>">
                              </div>
                            </div>
                            <div class="col-md-8">
                              <div class="form-group">
                                <label for="umb_hr_cuti_cat"><?php echo $this->lang->line('umb_hr_cuti_cat');?></label>
                                <input type="hidden" name="kategoris_cuti[]" value="0" />
                                <select multiple="multiple" class="form-control" name="kategoris_cuti[]" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_hr_cuti_cat');?>">
                                  <?php foreach($all_types_cuti as $type_cuti) {?>
                                    <option value="<?php echo $type_cuti->type_cuti_id?>" <?php if(isset($_GET)) { if(in_array($type_cuti->type_cuti_id,$kategoris_cuti_ids)):?> selected <?php endif; }?>><?php echo $type_cuti->type_name?></option>
                                  <?php } ?>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-3">
                              <div class="form-group">
                                <label for="laporans_to"><?php echo $this->lang->line('umb_laporans_to');?></label>
                                <select name="laporans_to" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_laporans_to');?>">
                                  <option value=""></option>
                                  <?php foreach(get_laporans_to() as $laporans_to) {?>
                                    <option value="<?php echo $laporans_to->user_id?>" <?php if($laporans_to->user_id==$elaporans_to):?> selected="selected"<?php endif;?>><?php echo $laporans_to->first_name.' '.$laporans_to->last_name;?></option>
                                  <?php } ?>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-9">
                              <div class="form-group">
                                <input type="hidden" value="0" name="view_perusahaans_id[]" />
                                <label for="first_name"><?php echo $this->lang->line('umb_view_data_perusahaans');?></label>
                                <select multiple="multiple" class="form-control" name="view_perusahaans_id[]" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_view_data_perusahaans');?>">
                                  <option value=""></option>
                                  <?php foreach($get_all_perusahaans as $perusahaan) {?>
                                    <option value="<?php echo $perusahaan->perusahaan_id?>" <?php if(isset($_GET)) { if(in_array($perusahaan->perusahaan_id,$view_perusahaans_ids)):?> selected <?php endif; }?>><?php echo $perusahaan->name?></option>
                                  <?php } ?>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="eprovinsi"><?php echo $this->lang->line('umb_provinsi');?></label>
                                <input class="form-control" placeholder="<?php echo $this->lang->line('umb_provinsi');?>" name="eprovinsi" type="text" value="<?php echo $provinsi;?>">
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="ekota"><?php echo $this->lang->line('umb_kota');?></label>
                                <input class="form-control" placeholder="<?php echo $this->lang->line('umb_kota');?>" name="ekota" type="text" value="<?php echo $kota;?>">
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="ekode_pos" class="control-label"><?php echo $this->lang->line('umb_kode_pos');?></label>
                                <input class="form-control" placeholder="<?php echo $this->lang->line('umb_kode_pos');?>" name="ekode_pos" type="text" value="<?php echo $kode_pos;?>">
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <?php $type_sukubangsa = $this->Umb_model->get_type_sukubangsa();?>
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="email" class="control-label"><?php echo $this->lang->line('umb_type_sukubangsa_title');?></label>
                                <select class="form-control" name="type_sukubangsa" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_type_sukubangsa_title');?>">
                                  <option value=""></option>
                                  <?php foreach($type_sukubangsa->result() as $itype) {?>
                                    <option value="<?php echo $itype->type_sukubangsa_id?>" <?php if($itype->type_sukubangsa_id==$itype_sukubangsa):?> selected="selected"<?php endif;?>><?php echo $itype->type?></option>
                                  <?php } ?>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-8">
                              <div class="form-group">
                                <label for="alamat"><?php echo $this->lang->line('umb_alamat_karyawan');?></label>
                                <input type="text" class="form-control" placeholder="<?php echo $this->lang->line('umb_alamat_karyawan');?>" name="alamat" value="<?php echo $alamat;?>" />
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="golongan_darah"><?php echo $this->lang->line('umb_golongan_darah');?></label>
                                <select class="form-control" name="golongan_darah" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_golongan_darah');?>">
                                  <option value=""></option>
                                  <option value="A+" <?php if($golongan_darah == 'A+'):?> selected="selected"<?php endif;?>>A+</option>
                                  <option value="A-" <?php if($golongan_darah == 'A-'):?> selected="selected"<?php endif;?>>A-</option>
                                  <option value="B+" <?php if($golongan_darah == 'B+'):?> selected="selected"<?php endif;?>>B+</option>
                                  <option value="B-" <?php if($golongan_darah == 'B-'):?> selected="selected"<?php endif;?>>B-</option>
                                  <option value="AB+" <?php if($golongan_darah == 'AB+'):?> selected="selected"<?php endif;?>>AB+</option>
                                  <option value="AB-" <?php if($golongan_darah == 'AB-'):?> selected="selected"<?php endif;?>>AB-</option>
                                  <option value="O+" <?php if($golongan_darah == 'O+'):?> selected="selected"<?php endif;?>>O+</option>
                                  <option value="O-" <?php if($golongan_darah == 'O-'):?> selected="selected"<?php endif;?>>O-</option>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="kewarganegaraan_id"><?php echo $this->lang->line('umb_nationality');?></label>
                                <select class="form-control" name="kewarganegaraan_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_nationality');?>">
                                  <option value=""><?php echo $this->lang->line('umb_select_one');?></option>
                                  <?php foreach($all_negaraa as $negara) {?>
                                    <option value="<?php echo $negara->negara_id;?>" <?php if($negara->negara_id == $kewarganegaraan_id):?> selected="selected"<?php endif;?>> <?php echo $negara->nama_negara;?></option>
                                  <?php } ?>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="kebangsaan_id" class="control-label"><?php echo $this->lang->line('umb_citizenship');?></label>
                                <select class="form-control" name="kebangsaan_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_citizenship');?>">
                                  <option value=""><?php echo $this->lang->line('umb_select_one');?></option>
                                  <?php foreach($all_negaraa as $negara) {?>
                                    <option value="<?php echo $negara->negara_id;?>" <?php if($negara->negara_id == $kebangsaan_id):?> selected="selected"<?php endif;?>> <?php echo $negara->nama_negara;?></option>
                                  <?php } ?>
                                </select>
                              </div>
                            </div>
                          </div>
                        </div>
                        <?php $module_attributes = $this->Custom_fields_model->all_hrastral_module_attributes();?>
                        <div class="row">
                          <?php foreach($module_attributes as $mattribute):?>
                            <?php $attribute_info = $this->Custom_fields_model->get_data_custom_karyawan($user_id,$mattribute->custom_field_id);?>
                            <?php
                            if(!is_null($attribute_info)){
                              $attr_val = $attribute_info->attribute_value;
                            } else {
                              $attr_val = '';
                            }
                            ?>
                            <?php if($mattribute->attribute_type == 'date'){?>
                              <div class="col-md-4">
                                <div class="form-group">
                                  <label for="<?php echo $mattribute->attribute;?>"><?php echo $mattribute->attribute_label;?></label>
                                  <input class="form-control date" placeholder="<?php echo $mattribute->attribute_label;?>" name="<?php echo $mattribute->attribute;?>" type="text" value="<?php echo $attr_val;?>">
                                </div>
                              </div>
                            <?php } else if($mattribute->attribute_type == 'select'){ ?>
                              <div class="col-md-4">
                                <?php $iselc_val = $this->Custom_fields_model->get_attribute_selection_values($mattribute->custom_field_id);?>
                                <div class="form-group">
                                  <label for="<?php echo $mattribute->attribute;?>"><?php echo $mattribute->attribute_label;?></label>
                                  <select class="form-control" name="<?php echo $mattribute->attribute;?>" data-plugin="select_hrm" data-placeholder="<?php echo $mattribute->attribute_label;?>">
                                    <?php foreach($iselc_val as $selc_val) {?>
                                      <option value="<?php echo $selc_val->attributes_select_value_id?>" <?php if(isset($attribute_info->attribute_value)) {if($attribute_info->attribute_value==$selc_val->attributes_select_value_id):?> selected="selected"<?php endif; }?>><?php echo $selc_val->select_label?></option>
                                    <?php } ?>
                                  </select>
                                </div>
                              </div>
                            <?php } else if($mattribute->attribute_type == 'multiselect'){?>
                              <?php $multiselect_values = explode(',',$attribute_info->attribute_value);?>
                              <div class="col-md-4">
                                <?php $imulti_selc_val = $this->Custom_fields_model->get_attribute_selection_values($mattribute->custom_field_id);?>
                                <div class="form-group">
                                  <label for="<?php echo $mattribute->attribute;?>"><?php echo $mattribute->attribute_label;?></label>
                                  <select multiple="multiple" class="form-control" name="<?php echo $mattribute->attribute;?>[]" data-plugin="select_hrm" data-placeholder="<?php echo $mattribute->attribute_label;?>">
                                    <?php foreach($imulti_selc_val as $multi_selc_val) {?>
                                      <option value="<?php echo $multi_selc_val->attributes_select_value_id?>" <?php if(in_array($multi_selc_val->attributes_select_value_id,$multiselect_values)):?> selected <?php endif;?>><?php echo $multi_selc_val->select_label?></option>
                                    <?php } ?>
                                  </select>
                                </div>
                              </div>
                            <?php } else if($mattribute->attribute_type == 'textarea'){?>
                              <div class="col-md-8">
                                <div class="form-group">
                                  <label for="<?php echo $mattribute->attribute;?>"><?php echo $mattribute->attribute_label;?></label>
                                  <input class="form-control" placeholder="<?php echo $mattribute->attribute_label;?>" name="<?php echo $mattribute->attribute;?>" type="text" value="<?php echo $attr_val;?>">
                                </div>
                              </div>
                            <?php } else if($mattribute->attribute_type == 'fileupload'){?>
                              <div class="col-md-4">
                                <div class="form-group">
                                  <label for="<?php echo $mattribute->attribute;?>"><?php echo $mattribute->attribute_label;?>
                                  <?php if($attr_val!=''):?>
                                    <a href="<?php echo site_url('admin/download');?>?type=custom_files&filename=<?php echo $attr_val;?>"><?php echo $this->lang->line('umb_download');?></a>
                                  <?php endif;?>
                                </label>
                                <input class="form-control-file" name="<?php echo $mattribute->attribute;?>" type="file">
                              </div>
                            </div>
                          <?php } else { ?>
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="<?php echo $mattribute->attribute;?>"><?php echo $mattribute->attribute_label;?></label>
                                <input class="form-control" placeholder="<?php echo $mattribute->attribute_label;?>" name="<?php echo $mattribute->attribute;?>" type="text" value="<?php echo $attr_val;?>">
                              </div>
                            </div>
                          <?php }	?>
                        <?php endforeach;?>
                      </div>
                      <div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrastral_form', 'type' => 'submit', 'class' => $this->Umb_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('umb_save'))); ?> </div>
                      <?php echo form_close(); ?> </div>
                    </div>
                    <div class="tab-pane fade" id="account-profile_picture">
                      <div class="card-body pb-2">
                        <?php $attributes = array('name' => 'profile_picture', 'id' => 'f_profile_picture', 'autocomplete' => 'off');?>
                        <?php $hidden = array('u_profile_picture' => 'UPDATE');?>
                        <?php echo form_open_multipart('admin/karyawans/profile_picture', $attributes, $hidden);?>
                        <?php
                        $data_usr = array(
                          'type'  => 'hidden',
                          'name'  => 'user_id',
                          'id'    => 'user_id',
                          'value' => $user_id,
                        );
                        echo form_input($data_usr);
                        ?>
                        <?php
                        $data_usr = array(
                          'type'  => 'hidden',
                          'name'  => 'session_id',
                          'id'    => 'session_id',
                          'value' => $session['user_id'],
                        );
                        echo form_input($data_usr);
                        ?>
                        <div class="bg-white">
                          <div class="row">
                            <div class="col-md-12">
                              <div class='form-group'>
                                <fieldset class="form-group">
                                  <label for="logo">
                                    <?php echo $this->lang->line('umb_browse');?>
                                    <i class="hrastral-asterisk">*</i>
                                  </label>
                                  <input type="file" class="form-control-file" id="p_file" name="p_file">
                                  <small><?php echo $this->lang->line('umb_e_details_picture_type');?></small>
                                </fieldset>
                                <?php if($profile_picture!='' && $profile_picture!='no file') {?>
                                  <img src="<?php echo base_url().'uploads/profile/'.$profile_picture;?>" width="50px" style="margin-left:20px;" id="u_file">
                                <?php } else {?>
                                  <?php if($jenis_kelamin=='Pria') { ?>
                                    <?php $de_file = base_url().'uploads/profile/default_male.jpg';?>
                                  <?php } else { ?>
                                    <?php $de_file = base_url().'uploads/profile/default_female.jpg';?>
                                  <?php } ?>
                                  <img src="<?php echo $de_file;?>" width="50px" style="margin-left:20px;" id="u_file">
                                <?php } ?>
                                <?php if($profile_picture!='' && $profile_picture!='no file') {?>
                                  <br />
                                  <label>
                                    <input type="checkbox" class="minimal" value="1" id="remove_profile_picture" name="remove_profile_picture">
                                    <?php echo $this->lang->line('umb_e_details_remove_pic');?></span> </label>
                                  <?php } else {?>
                                    <div id="remove_file" style="display:none;">
                                      <label>
                                        <input type="checkbox" class="minimal" value="1" id="remove_profile_picture" name="remove_profile_picture">
                                        <?php echo $this->lang->line('umb_e_details_remove_pic');?></span> </label>
                                      </div>
                                    <?php } ?>
                                  </div>
                                </div>
                              </div>
                              <div class="form-action box-footer"> <?php echo form_button(array('name' => 'hrastral_form', 'type' => 'submit', 'class' => $this->Umb_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('umb_save'))); ?> </div>
                            </div>
                            <?php echo form_close(); ?> 
                          </div>
                        </div>
                        <div class="tab-pane fade" id="account-immigration">
                          <div class="box">
                            <div class="card-header with-elements"> 
                              <span class="card-header-title mr-2"> 
                                <strong><?php echo $this->lang->line('umb_assigned_immigration');?></strong> 
                                <?php echo $this->lang->line('umb_records');?>
                              </span> 
                            </div>
                            <div class="card-body">
                              <div class="box-datatable table-responsive">
                                <table class="table table-striped table-bordered dataTable" id="umb_table_imgdocument" style="width:100%;">
                                  <thead>
                                    <tr>
                                      <th><?php echo $this->lang->line('umb_action');?></th>
                                      <th><?php echo $this->lang->line('umb_e_details_document');?></th>
                                      <th><?php echo $this->lang->line('umb_tanggal_terbit');?></th>
                                      <th><?php echo $this->lang->line('umb_tanggal_kaaluarsa');?></th>
                                      <th><?php echo $this->lang->line('umb_issued_by');?></th>
                                      <th><?php echo $this->lang->line('umb_tanggal_tinjauan_yang_memenuhi_syarat');?></th>
                                    </tr>
                                  </thead>
                                </table>
                              </div>
                            </div>
                          </div>
                          <div class="card-header with-elements"> 
                            <span class="card-header-title mr-2"> 
                              <strong><?php echo $this->lang->line('umb_add_new');?></strong> 
                              <?php echo $this->lang->line('umb_karyawan_immigration');?>
                            </span> 
                          </div>
                          <div class="card-body pb-2">
                            <?php $attributes = array('name' => 'immigration_info', 'id' => 'immigration_info', 'autocomplete' => 'off');?>
                            <?php $hidden = array('user_id' => $user_id, 'u_document_info' => 'UPDATE');?>
                            <?php echo form_open_multipart('admin/karyawans/immigration_info', $attributes, $hidden);?>
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="relation">
                                    <?php echo $this->lang->line('umb_e_details_document');?>
                                    <i class="hrastral-asterisk">*</i>
                                  </label>
                                  <select name="type_document_id" id="type_document_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_e_details_choose_dtype');?>">
                                    <option value=""></option>
                                    <?php foreach($all_types_document as $type_document) {?>
                                      <option value="<?php echo $type_document->type_document_id;?>"> <?php echo $type_document->type_document;?></option>
                                    <?php } ?>
                                  </select>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="nomor_document" class="control-label">
                                    <?php echo $this->lang->line('umb_karyawan_nomor_document');?>
                                    <i class="hrastral-asterisk">*</i>
                                  </label>
                                  <input class="form-control" placeholder="<?php echo $this->lang->line('umb_karyawan_nomor_document');?>" name="nomor_document" type="text">
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label for="tanggal_terbit" class="control-label">
                                    <?php echo $this->lang->line('umb_tanggal_terbit');?>
                                    <i class="hrastral-asterisk">*</i>
                                  </label>
                                  <input class="form-control date" readonly="readonly" placeholder="Issue Date" name="tanggal_terbit" type="text">
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label for="tanggal_kaaluarsa" class="control-label">
                                    <?php echo $this->lang->line('umb_e_details_doe');?>
                                    <i class="hrastral-asterisk">*</i>
                                  </label>
                                  <input class="form-control date" readonly="readonly" placeholder="<?php echo $this->lang->line('umb_e_details_doe');?>" name="tanggal_kaaluarsa" type="text">
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <fieldset class="form-group">
                                    <label for="logo">
                                      <?php echo $this->lang->line('umb_e_details_document_file');?>
                                      <i class="hrastral-asterisk">*</i>
                                    </label>
                                    <input type="file" class="form-control-file" id="p_file2" name="document_file">
                                    <small><?php echo $this->lang->line('umb_e_details_d_type_file');?></small>
                                  </fieldset>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="tanggal_tinjauan_yang_memenuhi_syarat" class="control-label"><?php echo $this->lang->line('umb_tanggal_tinjauan_yang_memenuhi_syarat');?></label>
                                  <input class="form-control date" readonly="readonly" placeholder="<?php echo $this->lang->line('umb_tanggal_tinjauan_yang_memenuhi_syarat');?>" name="tanggal_tinjauan_yang_memenuhi_syarat" type="text">
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="send_mail"><?php echo $this->lang->line('umb_negara');?></label>
                                  <select class="form-control" name="negara" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_negara');?>">
                                    <option value=""><?php echo $this->lang->line('umb_select_one');?></option>
                                    <?php foreach($all_negaraa as $snegara) {?>
                                      <option value="<?php echo $snegara->negara_id;?>"> <?php echo $snegara->nama_negara;?></option>
                                    <?php } ?>
                                  </select>
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
                        <div class="tab-pane fade" id="account-kontaks">
                          <div class="box">
                            <div class="card-header with-elements"> 
                              <span class="card-header-title mr-2"> 
                                <strong> <?php echo $this->lang->line('umb_list_all');?></strong> 
                                <?php echo $this->lang->line('umb_e_details_kontaks');?> 
                              </span> 
                            </div>
                            <div class="card-body">
                              <div class="box-datatable table-responsive">
                                <table class="table table-striped table-bordered dataTable" id="umb_table_kontak" style="width:100%;">
                                  <thead>
                                    <tr>
                                      <th><?php echo $this->lang->line('umb_action');?></th>
                                      <th><?php echo $this->lang->line('umb_karyawans_full_name');?></th>
                                      <th><?php echo $this->lang->line('umb_e_details_relation');?></th>
                                      <th><?php echo $this->lang->line('dashboard_email');?></th>
                                      <th><?php echo $this->lang->line('umb_e_details_mobile');?></th>
                                    </tr>
                                  </thead>
                                </table>
                              </div>
                            </div>
                          </div>
                          <div class="card-header with-elements"> 
                            <span class="card-header-title mr-2"> 
                              <strong> <?php echo $this->lang->line('umb_add_new');?></strong> 
                              <?php echo $this->lang->line('umb_e_details_kontak');?> 
                            </span> 
                          </div>
                          <div class="card-body pb-2">
                            <?php $attributes = array('name' => 'info_kontak', 'id' => 'info_kontak', 'autocomplete' => 'off');?>
                            <?php $hidden = array('u_basic_info' => 'ADD');?>
                            <?php echo form_open('admin/karyawans/info_kontak', $attributes, $hidden);?>
                            <?php
                            $data_usr1 = array(
                              'type'  => 'hidden',
                              'name'  => 'user_id',
                              'id'    => 'user_id',
                              'value' => $user_id,
                            );
                            echo form_input($data_usr1);
                            ?>
                            <div class="row">
                              <div class="col-md-5">
                                <div class="form-group">
                                  <label for="relation">
                                    <?php echo $this->lang->line('umb_e_details_relation');?>
                                    <i class="hrastral-asterisk">*</i>
                                  </label>
                                  <select class="form-control" name="relation" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_select_one');?>">
                                    <option value=""><?php echo $this->lang->line('umb_select_one');?></option>
                                    <option value="Self"><?php echo $this->lang->line('umb_self');?></option>
                                    <option value="Parent"><?php echo $this->lang->line('umb_parent');?></option>
                                    <option value="Spouse"><?php echo $this->lang->line('umb_spouse');?></option>
                                    <option value="Child"><?php echo $this->lang->line('umb_child');?></option>
                                    <option value="Sibling"><?php echo $this->lang->line('umb_sibling');?></option>
                                    <option value="In Laws"><?php echo $this->lang->line('umb_in_laws');?></option>
                                  </select>
                                </div>
                              </div>
                              <div class="col-md-7">
                                <div class="form-group">
                                  <label for="email_kerja" class="control-label">
                                    <?php echo $this->lang->line('dashboard_email');?>
                                    <i class="hrastral-asterisk">*</i>
                                  </label>
                                  <input class="form-control" placeholder="<?php echo $this->lang->line('umb_e_details_work');?>" name="email_kerja" type="text">
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-5">
                                <div class="row">
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="is_primary" value="1" name="is_primary">
                                        <span class="custom-control-label"><?php echo $this->lang->line('umb_e_details_pcontact');?></span> 
                                      </label>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <label class="custom-control custom-checkbox">
                                      <input type="checkbox" class="custom-control-input" id="is_dependent" value="2" name="is_dependent">
                                      <span class="custom-control-label"><?php echo $this->lang->line('umb_e_details_dependent');?></span> 
                                    </label>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-7">
                                <div class="form-group">
                                  <input class="form-control" placeholder="<?php echo $this->lang->line('umb_e_details_personal');?>" name="email_pribadi" type="text">
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-5">
                                <div class="form-group">
                                  <label for="name" class="control-label"><?php echo $this->lang->line('umb_name');?><i class="hrastral-asterisk">*</i></label>
                                  <input class="form-control" placeholder="<?php echo $this->lang->line('umb_name');?>" name="kontak_name" type="text">
                                </div>
                              </div>
                              <div class="col-md-7">
                                <div class="form-group" id="penunjukan_ajax">
                                  <label for="alamat_1" class="control-label"><?php echo $this->lang->line('umb_alamat');?></label>
                                  <input class="form-control" placeholder="<?php echo $this->lang->line('umb_alamat_1');?>" name="alamat_1" type="text">
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-5">
                                <div class="form-group">
                                  <label for="phone_kerja">
                                    <?php echo $this->lang->line('umb_phone');?>
                                    <i class="hrastral-asterisk">*</i>
                                  </label>
                                  <div class="row">
                                    <div class="col-md-8">
                                      <input class="form-control" placeholder="<?php echo $this->lang->line('umb_e_details_work');?>" name="phone_kerja" type="text">
                                    </div>
                                    <div class="col-md-4">
                                      <input class="form-control" placeholder="<?php echo $this->lang->line('umb_e_details_phone_ext');?>" name="extension_phone_kerja" type="text">
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-7">
                                <div class="form-group">
                                  <input class="form-control" placeholder="<?php echo $this->lang->line('umb_alamat_2');?>" name="alamat_2" type="text">
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-5">
                                <div class="form-group">
                                  <input class="form-control" placeholder="<?php echo $this->lang->line('umb_e_details_mobile');?>" name="mobile_phone" type="text">
                                </div>
                              </div>
                              <div class="col-md-7">
                                <div class="form-group">
                                  <div class="row">
                                    <div class="col-md-5">
                                      <input class="form-control" placeholder="<?php echo $this->lang->line('umb_kota');?>" name="kota" type="text">
                                    </div>
                                    <div class="col-md-4">
                                      <input class="form-control" placeholder="<?php echo $this->lang->line('umb_provinsi');?>" name="provinsi" type="text">
                                    </div>
                                    <div class="col-md-3">
                                      <input class="form-control" placeholder="<?php echo $this->lang->line('umb_kode_pos');?>" name="kode_pos" type="text">
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-5">
                                <div class="form-group">
                                  <input class="form-control" placeholder="<?php echo $this->lang->line('umb_e_details_home');?>" name="home_phone" type="text">
                                </div>
                              </div>
                              <div class="col-md-7">
                                <div class="form-group">
                                  <select name="negara" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_negara');?>">
                                    <option value=""></option>
                                    <?php foreach($all_negaraa as $negara) {?>
                                      <option value="<?php echo $negara->negara_id;?>"> <?php echo $negara->nama_negara;?></option>
                                    <?php } ?>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrastral_form', 'type' => 'submit', 'class' => $this->Umb_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('umb_save'))); ?> </div>
                            <?php echo form_close(); ?> 
                          </div>
                        </div>
                        <div class="tab-pane fade" id="account-social">
                          <div class="card-body pb-2">
                            <?php $attributes = array('name' => 'social_networking', 'id' => 'f_social_networking', 'autocomplete' => 'off');?>
                            <?php $hidden = array('user_id' => $user_id, 'u_basic_info' => 'UPDATE');?>
                            <?php echo form_open('admin/karyawans/social_info', $attributes, $hidden);?>
                            <div class="bg-white">
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label for="facebook_profile"><?php echo $this->lang->line('umb_e_details_fb_profile');?></label>
                                    <input class="form-control" placeholder="<?php echo $this->lang->line('umb_e_details_fb_profile');?>" name="facebook_link" type="text" value="<?php echo $facebook_link;?>">
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label for="facebook_profile"><?php echo $this->lang->line('umb_e_details_twit_profile');?></label>
                                    <input class="form-control" placeholder="<?php echo $this->lang->line('umb_e_details_twit_profile');?>" name="twitter_link" type="text" value="<?php echo $twitter_link;?>">
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-12">
                                  <div class="form-group">
                                    <label for="twitter_profile"><?php echo $this->lang->line('umb_e_details_blogr_profile');?></label>
                                    <input class="form-control" placeholder="<?php echo $this->lang->line('umb_e_details_blogr_profile');?>" name="blogger_link" type="text" value="<?php echo $blogger_link;?>">
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label for="blogger_profile"><?php echo $this->lang->line('umb_e_details_linkd_profile');?></label>
                                    <input class="form-control" placeholder="<?php echo $this->lang->line('umb_e_details_linkd_profile');?>" name="linkdedin_link" type="text" value="<?php echo $linkdedin_link;?>">
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label for="blogger_profile"><?php echo $this->lang->line('umb_e_details_gplus_profile');?></label>
                                    <input class="form-control" placeholder="<?php echo $this->lang->line('umb_e_details_gplus_profile');?>" name="google_plus_link" type="text" value="<?php echo $google_plus_link;?>">
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label for="linkdedin_profile"><?php echo $this->lang->line('umb_e_details_insta_profile');?></label>
                                    <input class="form-control" placeholder="<?php echo $this->lang->line('umb_e_details_insta_profile');?>" name="instagram_link" type="text" value="<?php echo $instagram_link;?>">
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label for="linkdedin_profile"><?php echo $this->lang->line('umb_e_details_pintrst_profile');?></label>
                                    <input class="form-control" placeholder="<?php echo $this->lang->line('umb_e_details_pintrst_profile');?>" name="pinterest_link" type="text" value="<?php echo $pinterest_link;?>">
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-12">
                                  <div class="form-group">
                                    <label for="linkdedin_profile"><?php echo $this->lang->line('umb_e_details_utube_profile');?></label>
                                    <input class="form-control" placeholder="<?php echo $this->lang->line('umb_e_details_utube_profile');?>" name="youtube_link" type="text" value="<?php echo $youtube_link;?>">
                                  </div>
                                </div>
                              </div>
                              <div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrastral_form', 'type' => 'submit', 'class' => $this->Umb_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('umb_save'))); ?> </div>
                            </div>
                            <?php echo form_close(); ?> 
                          </div>
                        </div>
                        <div class="tab-pane fade" id="account-qualification">
                          <div class="box">
                            <div class="card-header with-elements"> 
                              <span class="card-header-title mr-2"> 
                                <strong> <?php echo $this->lang->line('umb_list_all');?></strong> 
                                <?php echo $this->lang->line('umb_e_details_qualification');?> 
                              </span> 
                            </div>
                            <div class="card-body">
                              <div class="box-datatable table-responsive">
                                <table class="table table-striped table-bordered dataTable" id="umb_table_qualification" style="width:100%;">
                                  <thead>
                                    <tr>
                                      <th><?php echo $this->lang->line('umb_action');?></th>
                                      <th><?php echo $this->lang->line('umb_e_details_inst_name');?></th>
                                      <th><?php echo $this->lang->line('umb_e_details_timeperiod');?></th>
                                      <th><?php echo $this->lang->line('umb_e_details_edu_level');?></th>
                                    </tr>
                                  </thead>
                                </table>
                              </div>
                            </div>
                          </div>
                          <div class="card-header with-elements"> 
                            <span class="card-header-title mr-2"> 
                              <strong> <?php echo $this->lang->line('umb_add_new');?></strong> 
                              <?php echo $this->lang->line('umb_e_details_qualification');?> 
                            </span> 
                          </div>
                          <div class="card-body pb-2">
                            <?php $attributes = array('name' => 'info_qualification', 'id' => 'info_qualification', 'autocomplete' => 'off');?>
                            <?php $hidden = array('u_basic_info' => 'UPDATE');?>
                            <?php echo form_open('admin/karyawans/info_qualification', $attributes, $hidden);?>
                            <?php
                            $data_usr3 = array(
                              'type'  => 'hidden',
                              'name'  => 'user_id',
                              'value' => $user_id,
                            );
                            echo form_input($data_usr3);
                            ?>
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="name">
                                    <?php echo $this->lang->line('umb_e_details_inst_name');?>
                                    <i class="hrastral-asterisk">*</i>
                                  </label>
                                  <input class="form-control" placeholder="<?php echo $this->lang->line('umb_e_details_inst_name');?>" name="name" type="text">
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="tingkat_pendidikan" class="control-label"><?php echo $this->lang->line('umb_e_details_edu_level');?></label>
                                  <select class="form-control" name="tingkat_pendidikan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_e_details_edu_level');?>">
                                    <?php foreach($all_tingkat_pendidikan as $tingkat_pendidikan) {?>
                                      <option value="<?php echo $tingkat_pendidikan->tingkat_pendidikan_id?>"><?php echo $tingkat_pendidikan->name?></option>
                                    <?php } ?>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-12">
                                <div class="form-group">
                                  <label for="from_year" class="control-label">
                                    <?php echo $this->lang->line('umb_e_details_timeperiod');?>
                                    <i class="hrastral-asterisk">*</i>
                                  </label>
                                  <div class="row">
                                    <div class="col-md-6">
                                      <input class="form-control date" readonly="readonly" placeholder="<?php echo $this->lang->line('umb_e_details_from');?>" name="from_year" type="text">
                                    </div>
                                    <div class="col-md-6">
                                      <input class="form-control date" readonly="readonly" placeholder="<?php echo $this->lang->line('dashboard_to');?>" name="to_year" type="text">
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="language" class="control-label"><?php echo $this->lang->line('umb_e_details_authority');?></label>
                                  <select class="form-control" name="language" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_e_details_authority');?>">
                                    <?php foreach($all_qualification_language as $qualification_language) {?>
                                      <option value="<?php echo $qualification_language->language_id?>"><?php echo $qualification_language->name?></option>
                                    <?php } ?>
                                  </select>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="skill" class="control-label"><?php echo $this->lang->line('umb_e_details_skill');?></label>
                                  <select class="form-control" name="skill" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_e_details_skill');?>">
                                    <option value=""></option>
                                    <?php foreach($all_qualification_skill as $qualification_skill) {?>
                                      <option value="<?php echo $qualification_skill->skill_id?>"><?php echo $qualification_skill->name?></option>
                                    <?php } ?>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-12">
                                <div class="form-group">
                                  <label for="to_year" class="control-label"><?php echo $this->lang->line('umb_description');?></label>
                                  <textarea class="form-control" placeholder="<?php echo $this->lang->line('umb_description');?>" data-show-counter="1" data-limit="300" name="description" cols="30" rows="3" id="d_description"></textarea>
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
                        <div class="tab-pane fade" id="account-pengalaman">
                          <div class="box">
                            <div class="card-header with-elements"> 
                              <span class="card-header-title mr-2"> 
                                <strong> <?php echo $this->lang->line('umb_list_all');?></strong> 
                                <?php echo $this->lang->line('umb_e_details_pengalaman_krj');?> 
                              </span> 
                            </div>
                            <div class="card-body">
                              <div class="box-datatable table-responsive">
                                <table class="table table-striped table-bordered dataTable" id="umb_table_pengalaman_kerja" style="width:100%;">
                                  <thead>
                                    <tr>
                                      <th><?php echo $this->lang->line('umb_action');?></th>
                                      <th><?php echo $this->lang->line('umb_nama_perusahaan');?></th>
                                      <th><?php echo $this->lang->line('umb_e_details_frm_date');?></th>
                                      <th><?php echo $this->lang->line('umb_e_details_to_date');?></th>
                                      <th><?php echo $this->lang->line('umb_e_details_post');?></th>
                                      <th><?php echo $this->lang->line('umb_description');?></th>
                                    </tr>
                                  </thead>
                                </table>
                              </div>
                            </div>
                          </div>
                          <div class="card-header with-elements"> 
                            <span class="card-header-title mr-2"> 
                              <strong> <?php echo $this->lang->line('umb_add_new');?></strong> 
                              <?php echo $this->lang->line('umb_e_details_pengalaman_krj');?> 
                            </span> 
                          </div>
                          <div class="card-body pb-2">
                            <?php $attributes = array('name' => 'info_pengalaman_kerja', 'id' => 'info_pengalaman_kerja', 'autocomplete' => 'off');?>
                            <?php $hidden = array('u_basic_info' => 'UPDATE');?>
                            <?php echo form_open('admin/karyawans/info_pengalaman_kerja', $attributes, $hidden);?>
                            <?php
                            $data_usr4 = array(
                              'type'  => 'hidden',
                              'name'  => 'user_id',
                              'value' => $user_id,
                            );
                            echo form_input($data_usr4);
                            ?>
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="nama_perusahaan">
                                    <?php echo $this->lang->line('umb_nama_perusahaan');?>
                                    <i class="hrastral-asterisk">*</i>
                                  </label>
                                  <input class="form-control" placeholder="<?php echo $this->lang->line('umb_nama_perusahaan');?>" name="nama_perusahaan" type="text" value="" id="nama_perusahaan">
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="post">
                                    <?php echo $this->lang->line('umb_e_details_post');?>
                                    <i class="hrastral-asterisk">*</i>
                                  </label>
                                  <input class="form-control" placeholder="<?php echo $this->lang->line('umb_e_details_post');?>" name="post" type="text" value="" id="post">
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-12">
                                <div class="form-group">
                                  <label for="from_year" class="control-label">
                                    <?php echo $this->lang->line('umb_e_details_timeperiod');?>
                                    <i class="hrastral-asterisk">*</i>
                                  </label>
                                  <div class="row">
                                    <div class="col-md-6">
                                      <input class="form-control date" readonly="readonly" placeholder="<?php echo $this->lang->line('umb_e_details_from');?>" name="from_date" type="text">
                                    </div>
                                    <div class="col-md-6">
                                      <input class="form-control date" readonly="readonly" placeholder="<?php echo $this->lang->line('dashboard_to');?>" name="to_date" type="text">
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-12">
                                <div class="form-group">
                                  <label for="description"><?php echo $this->lang->line('umb_description');?></label>
                                  <textarea class="form-control" placeholder="<?php echo $this->lang->line('umb_description');?>" data-show-counter="1" data-limit="300" name="description" cols="30" rows="4" id="description"></textarea>
                                  <span class="countdown"></span> 
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
                        <div class="tab-pane fade" id="account-document">
                          <div class="box">
                            <div class="card-header with-elements"> 
                              <span class="card-header-title mr-2"> 
                                <strong> <?php echo $this->lang->line('umb_list_all');?></strong> 
                                <?php echo $this->lang->line('umb_e_details_documents');?> 
                              </span> 
                            </div>
                            <div class="card-body">
                              <div class="box-datatable table-responsive">
                                <table class="table table-striped table-bordered dataTable" id="umb_table_document" style="width:100%;">
                                  <thead>
                                    <tr>
                                      <th><?php echo $this->lang->line('umb_action');?></th>
                                      <th><?php echo $this->lang->line('umb_e_details_dtype');?></th>
                                      <th><?php echo $this->lang->line('dashboard_umb_title');?></th>
                                      <th><?php echo $this->lang->line('umb_e_details_doe');?></th>
                                    </tr>
                                  </thead>
                                </table>
                              </div>
                            </div>
                          </div>
                          <div class="card-header with-elements"> 
                            <span class="card-header-title mr-2"> 
                              <strong> <?php echo $this->lang->line('umb_add_new');?></strong> 
                              <?php echo $this->lang->line('umb_e_details_document');?> 
                            </span> 
                          </div>
                          <div class="card-body pb-2">
                            <?php $attributes = array('name' => 'document_info', 'id' => 'document_info', 'autocomplete' => 'off');?>
                            <?php $hidden = array('u_document_info' => 'UPDATE');?>
                            <?php echo form_open_multipart('admin/karyawans/document_info', $attributes, $hidden);?>
                            <?php
                            $data_usr2 = array(
                              'type'  => 'hidden',
                              'name'  => 'user_id',
                              'value' => $user_id,
                            );
                            echo form_input($data_usr2);
                            ?>
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="relation">
                                    <?php echo $this->lang->line('umb_e_details_dtype');?>
                                    <i class="hrastral-asterisk">*</i>
                                  </label>
                                  <select name="type_document_id" id="type_document_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_e_details_choose_dtype');?>">
                                    <option value=""></option>
                                    <?php foreach($all_types_document as $type_document) {?>
                                      <option value="<?php echo $type_document->type_document_id;?>"> <?php echo $type_document->type_document;?></option>
                                    <?php } ?>
                                  </select>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="tanggal_kadaluarsa" class="control-label">
                                    <?php echo $this->lang->line('umb_e_details_doe');?>
                                    <i class="hrastral-asterisk">*</i>
                                  </label>
                                  <input class="form-control date" readonly placeholder="<?php echo $this->lang->line('umb_e_details_doe');?>" name="tanggal_kadaluarsa" type="text">
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-12">
                                <div class="form-group">
                                  <label for="title" class="control-label">
                                    <?php echo $this->lang->line('umb_e_details_dtitle');?>
                                    <i class="hrastral-asterisk">*</i>
                                  </label>
                                  <input class="form-control" placeholder="<?php echo $this->lang->line('umb_e_details_dtitle');?>" name="title" type="text">
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="description" class="control-label"><?php echo $this->lang->line('umb_description');?></label>
                                  <textarea class="form-control" placeholder="<?php echo $this->lang->line('umb_description');?>" data-show-counter="1" data-limit="300" name="description" cols="30" rows="3" id="d_description"></textarea>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <fieldset class="form-group">
                                    <label for="logo"><?php echo $this->lang->line('umb_e_details_document_file');?></label>
                                    <input type="file" class="form-control-file" id="document_file" name="document_file">
                                    <small><?php echo $this->lang->line('umb_e_details_d_type_file');?></small>
                                  </fieldset>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-12">
                                <div class="form-group">
                                  <div class="form-actions"> <?php echo form_button(array('name' => 'hrastral_form', 'type' => 'submit', 'class' => $this->Umb_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('umb_save'))); ?> </div>
                                </div>
                              </div>
                            </div>
                            <?php echo form_close(); ?> 
                          </div>
                        </div>
                        <div class="tab-pane fade" id="account-baccount">
                          <div class="box">
                            <div class="card-header with-elements"> 
                              <span class="card-header-title mr-2"> 
                                <strong> <?php echo $this->lang->line('umb_list_all');?></strong> 
                                <?php echo $this->lang->line('umb_e_details_baccount');?> 
                              </span> 
                            </div>
                            <div class="card-body">
                              <div class="box-datatable table-responsive">
                                <table class="table table-striped table-bordered dataTable" id="umb_table_bank_account" style="width:100%;">
                                  <thead>
                                    <tr>
                                      <th><?php echo $this->lang->line('umb_action');?></th>
                                      <th><?php echo $this->lang->line('umb_e_details_acc_title');?></th>
                                      <th><?php echo $this->lang->line('umb_e_details_acc_number');?></th>
                                      <th><?php echo $this->lang->line('umb_e_details_nama_bank');?></th>
                                      <th><?php echo $this->lang->line('umb_e_details_kode_bank');?></th>
                                      <th><?php echo $this->lang->line('umb_e_details_cabang_bank');?></th>
                                    </tr>
                                  </thead>
                                </table>
                              </div>
                            </div>
                          </div>
                          <div class="card-header with-elements"> 
                            <span class="card-header-title mr-2"> 
                              <strong> <?php echo $this->lang->line('umb_add_new');?></strong> 
                              <?php echo $this->lang->line('umb_e_details_baccount');?> 
                            </span> 
                          </div>
                          <div class="card-body pb-2">
                            <?php $attributes = array('name' => 'info_bank_account', 'id' => 'info_bank_account', 'autocomplete' => 'off');?>
                            <?php $hidden = array('u_basic_info' => 'UPDATE');?>
                            <?php echo form_open('admin/karyawans/info_bank_account', $attributes, $hidden);?>
                            <?php
                            $data_usr4 = array(
                              'type'  => 'hidden',
                              'name'  => 'user_id',
                              'value' => $user_id,
                            );
                            echo form_input($data_usr4);
                            ?>
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="account_title">
                                    <?php echo $this->lang->line('umb_e_details_acc_title');?>
                                    <i class="hrastral-asterisk">*</i>
                                  </label>
                                  <input class="form-control" placeholder="<?php echo $this->lang->line('umb_e_details_acc_title');?>" name="account_title" type="text" value="" id="nama_account">
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="nomor_account">
                                    <?php echo $this->lang->line('umb_e_details_acc_number');?>
                                    <i class="hrastral-asterisk">*</i>
                                  </label>
                                  <input class="form-control" placeholder="<?php echo $this->lang->line('umb_e_details_acc_number');?>" name="nomor_account" type="text" value="" id="nomor_account">
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="nama_bank">
                                    <?php echo $this->lang->line('umb_e_details_nama_bank');?>
                                    <i class="hrastral-asterisk">*</i>
                                  </label>
                                  <input class="form-control" placeholder="<?php echo $this->lang->line('umb_e_details_nama_bank');?>" name="nama_bank" type="text" value="" id="nama_bank">
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="kode_bank">
                                    <?php echo $this->lang->line('umb_e_details_kode_bank');?>
                                    <i class="hrastral-asterisk">*</i>
                                  </label>
                                  <input class="form-control" placeholder="<?php echo $this->lang->line('umb_e_details_kode_bank');?>" name="kode_bank" type="text" value="" id="kode_bank">
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-12">
                                <div class="form-group">
                                  <label for="cabang_bank"><?php echo $this->lang->line('umb_e_details_cabang_bank');?></label>
                                  <input class="form-control" placeholder="<?php echo $this->lang->line('umb_e_details_cabang_bank');?>" name="cabang_bank" type="text" value="" id="cabang_bank">
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
                        <div class="tab-pane fade" id="account-cpassword">
                          <div class="card-body pb-2">
                            <?php $attributes = array('name' => 'e_change_password', 'id' => 'e_change_password', 'autocomplete' => 'off');?>
                            <?php $hidden = array('u_basic_info' => 'UPDATE');?>
                            <?php echo form_open('admin/karyawans/change_password', $attributes, $hidden);?>
                            <?php
                            $data_usr5 = array(
                              'type'  => 'hidden',
                              'name'  => 'user_id',
                              'value' => $user_id,
                            );
                            echo form_input($data_usr5);
                            ?>
                            <div class="row">
                              <div class="col-md-4">
                                <div class="form-group">
                                  <label for="old_password"><?php echo $this->lang->line('umb_old_password');?></label>
                                  <input class="form-control" placeholder="<?php echo $this->lang->line('umb_old_password');?>" name="old_password" type="password">
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="form-group">
                                  <label for="new_password">
                                    <?php echo $this->lang->line('umb_e_details_enpassword');?>
                                    <i class="hrastral-asterisk">*</i>
                                  </label>
                                  <input class="form-control" placeholder="<?php echo $this->lang->line('umb_e_details_enpassword');?>" name="new_password" type="password">
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="form-group">
                                  <label for="new_password_confirm" class="control-label">
                                    <?php echo $this->lang->line('umb_e_details_ecnpassword');?>
                                    <i class="hrastral-asterisk">*</i>
                                  </label>
                                  <input class="form-control" placeholder="<?php echo $this->lang->line('umb_e_details_ecnpassword');?>" name="new_password_confirm" type="password">
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-12">
                                <div class="form-group">
                                  <div class="form-actions"> <?php echo form_button(array('name' => 'hrastral_form', 'type' => 'submit', 'class' => $this->Umb_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('umb_save'))); ?> </div>
                                </div>
                              </div>
                            </div>
                            <?php echo form_close(); ?> 
                          </div>
                        </div>
                        <div class="tab-pane fade" id="account-security_level">
                          <div class="box">
                            <div class="card-header with-elements"> 
                              <span class="card-header-title mr-2"> 
                                <strong> <?php echo $this->lang->line('umb_list_all');?></strong> 
                                <?php echo $this->lang->line('umb_esecurity_level_title');?> 
                              </span> 
                            </div>
                            <div class="card-body">
                              <div class="box-datatable table-responsive">
                                <table class="table table-striped table-bordered dataTable" id="umb_table_security_level" style="width:100%;">
                                  <thead>
                                    <tr>
                                      <th><?php echo $this->lang->line('umb_action');?></th>
                                      <th><?php echo $this->lang->line('umb_esecurity_level_title');?></th>
                                      <th><?php echo $this->lang->line('umb_e_details_doe');?></th>
                                      <th><?php echo $this->lang->line('umb_e_details_do_clearance');?></th>
                                    </tr>
                                  </thead>
                                </table>
                              </div>
                            </div>
                          </div>
                          <div class="card-header with-elements"> 
                            <span class="card-header-title mr-2"> 
                              <strong> <?php echo $this->lang->line('umb_add_new');?></strong> 
                              <?php echo $this->lang->line('umb_esecurity_level_title');?> 
                            </span> 
                          </div>
                          <div class="card-body pb-2">
                            <?php $attributes = array('name' => 'info_security_level', 'id' => 'info_security_level', 'autocomplete' => 'off');?>
                            <?php $hidden = array('u_basic_info' => 'UPDATE');?>
                            <?php echo form_open('admin/karyawans/add_security_level', $attributes, $hidden);?>
                            <?php
                            $data_usr4 = array(
                              'type'  => 'hidden',
                              'name'  => 'user_id',
                              'value' => $user_id,
                            );
                            echo form_input($data_usr4);
                            ?>
                            <?php $list_security_level = $this->Umb_model->get_type_security_level();?>
                            <div class="row">
                              <div class="col-md-4">
                                <div class="form-group">
                                  <label for="account_title">
                                    <?php echo $this->lang->line('umb_esecurity_level_title');?>
                                    <i class="hrastral-asterisk">*</i>
                                  </label>
                                  <select class="form-control" name="security_level" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_esecurity_level_title');?>">
                                    <option value=""><?php echo $this->lang->line('umb_esecurity_level_title');?></option>
                                    <?php foreach($list_security_level->result() as $sc_level) {?>
                                      <option value="<?php echo $sc_level->type_id?>"><?php echo $sc_level->name?></option>
                                    <?php } ?>
                                  </select>
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="form-group">
                                  <label for="nomor_account"><?php echo $this->lang->line('umb_e_details_doe');?></label>
                                  <input class="form-control date" placeholder="<?php echo $this->lang->line('umb_e_details_doe');?>" name="tanggal_kaaluarsa" type="text" value="" id="tanggal_kaaluarsa">
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="form-group">
                                  <label for="nomor_account"><?php echo $this->lang->line('umb_e_details_do_clearance');?></label>
                                  <input class="form-control date" placeholder="<?php echo $this->lang->line('umb_e_details_do_clearance');?>" name="date_of_clearance" type="text" value="" id="date_of_clearance">
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
                        <div class="tab-pane fade" id="account-kontrak">
                          <div class="box">
                            <div class="card-header with-elements"> 
                              <span class="card-header-title mr-2"> 
                                <strong> <?php echo $this->lang->line('umb_list_all');?></strong> 
                                <?php echo $this->lang->line('umb_e_details_kontrakk');?> 
                              </span> 
                            </div>
                            <div class="card-body">
                              <div class="box-datatable table-responsive">
                                <table class="table table-striped table-bordered dataTable" id="umb_table_kontrak" style="width:100%;">
                                  <thead>
                                    <tr>
                                      <th><?php echo $this->lang->line('umb_action');?></th>
                                      <th><?php echo $this->lang->line('umb_e_details_duration');?></th>
                                      <th><?php echo $this->lang->line('dashboard_penunjukan');?></th>
                                      <th><?php echo $this->lang->line('umb_e_details_type_kontrak');?></th>
                                      <th><?php echo $this->lang->line('dashboard_umb_title');?></th>
                                    </tr>
                                  </thead>
                                </table>
                              </div>
                            </div>
                          </div>
                          <div class="card-header with-elements"> 
                            <span class="card-header-title mr-2"> 
                              <strong> <?php echo $this->lang->line('umb_add_new');?></strong> 
                              <?php echo $this->lang->line('umb_e_details_kontrak');?> 
                            </span> 
                          </div>
                          <div class="card-body pb-2">
                            <?php $attributes = array('name' => 'info_kontrak', 'id' => 'info_kontrak', 'autocomplete' => 'off');?>
                            <?php $hidden = array('u_basic_info' => 'UPDATE');?>
                            <?php echo form_open('admin/karyawans/info_kontrak', $attributes, $hidden);?>
                            <?php
                            $data_usr4 = array(
                              'type'  => 'hidden',
                              'name'  => 'user_id',
                              'value' => $user_id,
                            );
                            echo form_input($data_usr4);
                            ?>
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="type_kontrak_id" class=""><?php echo $this->lang->line('umb_e_details_type_kontrak');?></label>
                                  <select class="form-control" name="type_kontrak_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_select_one');?>">
                                    <option value=""><?php echo $this->lang->line('umb_select_one');?></option>
                                    <?php foreach($all_types_kontrak as $type_kontrak) {?>
                                      <option value="<?php echo $type_kontrak->type_kontrak_id;?>"> <?php echo $type_kontrak->name;?></option>
                                    <?php } ?>
                                  </select>
                                </div>
                                <div class="form-group">
                                  <label class="" for="from_date"><?php echo $this->lang->line('umb_e_details_frm_date');?></label>
                                  <input type="text" class="form-control date" name="from_date" placeholder="<?php echo $this->lang->line('umb_e_details_frm_date');?>" readonly value="">
                                </div>
                                <div class="form-group">
                                  <label for="penunjukan_id" class=""><?php echo $this->lang->line('dashboard_penunjukan');?></label>
                                  <select class="form-control" name="penunjukan_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_select_one');?>">
                                    <option value=""><?php echo $this->lang->line('umb_select_one');?></option>
                                    <?php foreach($all_penunjukans as $penunjukan) {?>
                                      <?php if($penunjukan_id==$penunjukan->penunjukan_id):?>
                                        <option value="<?php echo $penunjukan->penunjukan_id?>" <?php if($penunjukan_id==$penunjukan->penunjukan_id):?> selected <?php endif;?>><?php echo $penunjukan->nama_penunjukan?></option>
                                      <?php endif;?>
                                    <?php } ?>
                                  </select>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="title" class=""><?php echo $this->lang->line('umb_e_details_kontrak_title');?></label>
                                  <input class="form-control" placeholder="<?php echo $this->lang->line('umb_e_details_kontrak_title');?>" name="title" type="text" value="" id="title">
                                </div>
                                <div class="form-group">
                                  <label for="to_date"><?php echo $this->lang->line('umb_e_details_to_date');?></label>
                                  <input type="text" class="form-control date" name="to_date" placeholder="<?php echo $this->lang->line('umb_e_details_to_date');?>" readonly value="">
                                </div>
                                <div class="form-group">
                                  <label for="description"><?php echo $this->lang->line('umb_description');?></label>
                                  <textarea class="form-control" placeholder="<?php echo $this->lang->line('umb_description');?>" data-show-counter="1" data-limit="300" name="description" cols="30" rows="3" id="description"></textarea>
                                  <span class="countdown"></span> 
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
            <?php if(in_array('351',$role_resources_ids)) { ?> 
              <div id="smartwizard-2-step-2" class="animated fadeIn tab-pane step-content mt-3" style="display: none;">
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
            <div id="smartwizard-2-step-3" class="animated fadeIn tab-pane step-content mt-3" style="display: none;">
              <div class="box-body">
                <div class="row no-gutters row-bordered row-border-light">
                  <div class="col-md-12">
                    <div class="tab-content">
                      <div class="box-body pb-2">
                        <div class="row">
                          <?php $kategoris_cuti_ids = explode(',',$cuti_user[0]->kategoris_cuti); ?>
                          <?php foreach($all_types_cuti as $type) {
                            if(in_array($type->type_cuti_id,$kategoris_cuti_ids)){?>
                              <?php
                              $hlfcount =0;
                              //$count_l =0;
                              $cal_cuti_setengahari = karyawan_cal_cuti_setengahari($type->type_cuti_id,$this->uri->segment(4));
                              foreach($cal_cuti_setengahari as $lhalfday):
                                $hlfcount += 0.5;
                              endforeach;
                              $count_l = count_info_cutii($type->type_cuti_id,$this->uri->segment(4));
                              $count_l = $count_l - $hlfcount;
                              ?>
                              <?php
                              $edays_per_year = $type->days_per_year;
                              if($count_l == 0){
                                $progress_class = '';
                                $count_data = 0;
                              } else {
                                if($edays_per_year > 0){
                                  $count_data = $count_l / $edays_per_year * 100;
                                } else {
                                  $count_data = 0;
                                }
                                    // progress
                                if($count_data <= 20) {
                                  $progress_class = 'progress-success';
                                } else if($count_data > 20 && $count_data <= 50){
                                  $progress_class = 'progress-info';
                                } else if($count_data > 50 && $count_data <= 75){
                                  $progress_class = 'progress-warning';
                                } else {
                                  $progress_class = 'progress-danger';
                                }
                              }
                              ?>
                              <div class="col-md-3">
                                <div class="card mb-4">
                                  <div class="card-body">
                                    <div class="d-flex align-items-center">
                                      <div class="fas fa-calendar-alt display-4 text-success"></div>
                                      <div class="ml-3">
                                        <div class="text-muted small">
                                          <?php echo $type->type_name;?> (<?php echo $count_l;?>/<?php echo $edays_per_year;?>)
                                        </div>
                                        <div class="text-large">
                                          <div class="progress" style="height: 6px;">
                                            <div class="progress-bar" style="width: <?php echo $count_data;?>%;"></div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            <?php }
                          }?>
                        </div>
                      </div>
                      <?php $cuti = $this->Timesheet_model->get_karyawan_cutii($user_id); ?>
                      <div class="card <?php echo $get_animate;?>">
                        <div class="card-header with-elements"> 
                          <span class="card-header-title mr-2"> 
                            <strong><?php echo $this->lang->line('umb_list_all');?></strong> 
                            <?php echo $this->lang->line('left_cuti');?>
                          </span> 
                        </div>
                        <div class="card-body">
                          <div class="box-datatable table-responsive">
                            <table class="datatables-demo table table-striped table-bordered umb_hrastral_table" id="umb_hr_table">
                              <thead>
                                <tr>
                                  <th><?php echo $this->lang->line('umb_view');?></th>
                                  <th width="250"><?php echo $this->lang->line('umb_type_cuti');?></th>
                                  <th><?php echo $this->lang->line('left_department');?></th>
                                  <th>
                                    <i class="fa fa-calendar"></i> 
                                    <?php echo $this->lang->line('umb_cuti_duration');?>
                                  </th>
                                  <th>
                                    <i class="fa fa-calendar"></i> 
                                    <?php echo $this->lang->line('umb_applied_on');?>
                                  </th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php foreach($cuti->result() as $r) { ?>
                                  <?php
                                  $user = $this->Umb_model->read_user_info($r->karyawan_id);
                                  if(!is_null($user)){
                                    $full_name = $user[0]->first_name. ' '.$user[0]->last_name;
                                    $department = $this->Department_model->read_informasi_department($user[0]->department_id);
                                    if(!is_null($department)){
                                      $nama_department = $department[0]->nama_department;
                                    } else {
                                      $nama_department = '--';	
                                    }
                                  } else {
                                    $full_name = '--';	
                                    $nama_department = '--';
                                  }
                                  $type_cuti = $this->Timesheet_model->read_informasi_type_cuti($r->type_cuti_id);
                                  if(!is_null($type_cuti)){
                                    $type_name = $type_cuti[0]->type_name;
                                  } else {
                                    $type_name = '--';	
                                  }
                                  $perusahaan = $this->Umb_model->read_info_perusahaan($r->perusahaan_id);
                                  if(!is_null($perusahaan)){
                                    $prshn_nama = $perusahaan[0]->name;
                                  } else {
                                    $prshn_nama = '--';	
                                  }
                                  $datetime1 = new DateTime($r->from_date);
                                  $datetime2 = new DateTime($r->to_date);
                                  $interval = $datetime1->diff($datetime2);
                                  if(strtotime($r->from_date) == strtotime($r->to_date)){
                                    $no_of_days =1;
                                  } else {
                                    $no_of_days = $interval->format('%a') + 1;
                                  }
                                  $applied_on = $this->Umb_model->set_date_format($r->applied_on);
                                  if($r->is_half_day == 1){
                                   $duration = $this->Umb_model->set_date_format($r->from_date).' '.$this->lang->line('dashboard_to').' '.$this->Umb_model->set_date_format($r->to_date).'<br>'.$this->lang->line('umb_hrastral_total_hari').': '.$this->lang->line('umb_hr_cuti_setenga_hari');
                                 } else {
                                  $duration = $this->Umb_model->set_date_format($r->from_date).' '.$this->lang->line('dashboard_to').' '.$this->Umb_model->set_date_format($r->to_date).'<br>'.$this->lang->line('umb_hrastral_total_hari').': '.$no_of_days;
                                }
                                if($r->status==1): 
                                  $status = '<span class="badge bg-orange">'.$this->lang->line('umb_pending').'</span>';
                                elseif($r->status==2): 
                                  $status = '<span class="badge bg-green">'.$this->lang->line('umb_approved').'</span>';
                                elseif($r->status==4): 
                                  $status = '<span class="badge bg-green">'.$this->lang->line('umb_role_first_level_approved').'</span>';
                                else: 
                                  $status = '<span class="badge bg-red">'.$this->lang->line('umb_rejected').'</span>'; 
                                endif;
                                if(in_array('290',$role_resources_ids)) {
                                  $view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_view_details').'"><a href="'.site_url().'admin/timesheet/details_cuti/id/'.$r->cuti_id.'/" target="_blank"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span>';
                                } else {
                                  $view = '';
                                }
                                $combhr = $view;
                                $itype_name = $type_name.'<br><small class="text-muted"><i>'.$this->lang->line('umb_alasan').': '.$r->reason.'<i></i></i></small><br><small class="text-muted"><i>'.$status.'<i></i></i></small><br><small class="text-muted"><i>'.$this->lang->line('left_perusahaan').': '.$prshn_nama.'<i></i></i></small>';
                                ?>
                                <tr>
                                  <td><?php echo $combhr;?></td>
                                  <td><?php echo $itype_name;?></td>
                                  <td><?php echo $nama_department;?></td>
                                  <td>
                                    <i class="fa fa-calendar"></i> 
                                    <?php echo $duration;?>
                                  </td>
                                  <td>
                                    <i class="fa fa-calendar"></i> 
                                    <?php echo $applied_on;?>
                                  </td>
                                </tr>
                              <?php } ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div id="smartwizard-2-step-4" class="animated fadeIn tab-pane step-content mt-3" style="display: none;">
            <div class="cards-body">
              <div class="card overflow-hidden">
                <div class="row no-gutters row-bordered row-border-light">
                  <div class="col-md-3 pt-0">
                    <div class="list-group list-group-flush account-settings-links"> 
                      <a class="list-group-item list-group-item-action active" data-toggle="list" href="#account-awards"> 
                        <i class="lnr lnr-strikethrough text-lightest"></i> &nbsp; <?php echo $this->lang->line('left_awards');?>
                      </a> 
                      <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-perjalanans"> 
                        <i class="lnr lnr-car text-lightest"></i> &nbsp; <?php echo $this->lang->line('left_perjalanans');?>
                      </a> 
                      <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-training"> 
                        <i class="lnr lnr-graduation-hat text-lightest"></i> &nbsp; <?php echo $this->lang->line('left_training');?>
                      </a> 
                      <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-tickets"> 
                        <i class="lnr lnr-location text-lightest"></i> &nbsp; <?php echo $this->lang->line('left_tickets');?>
                      </a> 
                      <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-transfers"> 
                        <i class="lnr lnr-store text-lightest"></i> &nbsp; <?php echo $this->lang->line('left_transfers');?>
                      </a> 
                      <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-promotions"> 
                        <i class="lnr lnr-tag text-lightest"></i> &nbsp; <?php echo $this->lang->line('left_promotions');?>
                      </a> 
                      <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-keluhans"> 
                        <i class="lnr lnr-file-add text-lightest"></i> &nbsp; <?php echo $this->lang->line('left_keluhans');?>
                      </a> 
                      <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-peringatans"> 
                        <i class="lnr lnr-paw text-lightest"></i> &nbsp; <?php echo $this->lang->line('left_peringatans');?>
                      </a> 
                    </div>
                  </div>
                  <div class="col-md-9">
                    <div class="tab-content">
                      <div class="tab-pane fade show active" id="account-awards">
                        <div class="card">
                          <div class="card-header with-elements"> 
                            <span class="card-header-title mr-2"> 
                              <strong> <?php echo $this->lang->line('umb_list_all');?></strong> 
                              <?php echo $this->lang->line('left_awards');?> 
                            </span> 
                          </div>
                          <?php $award = $this->Awards_model->get_awards_karyawan($user_id); ?>
                          <div class="card-body">
                            <div class="box-datatable table-responsive">
                              <table class="datatables-demo table table-striped table-bordered umb_hrastral_table" id="umb_hr_table">
                                <thead>
                                  <tr>
                                    <th style="width:100px;"><?php echo $this->lang->line('umb_view');?></th>
                                    <th width="300">
                                      <i class="fa fa-trophy"></i> 
                                      <?php echo $this->lang->line('umb_nama_award');?>
                                    </th>
                                    <th>
                                      <i class="fa fa-gift"></i> 
                                      <?php echo $this->lang->line('umb_gift');?></th>
                                      <th>
                                        <i class="fa fa-calendar"></i> 
                                        <?php echo $this->lang->line('umb_bulan_tahun_penghargaan');?>
                                      </th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php foreach($award->result() as $r) { ?>
                                      <?php

                                      $user = $this->Umb_model->read_user_info($r->karyawan_id);

                                      if(!is_null($user)){
                                        $full_name = $user[0]->first_name.' '.$user[0]->last_name;
                                      } else {
                                        $full_name = '--';	
                                      }
                                      $type_award = $this->Awards_model->read_informasi_type_award($r->type_award_id);
                                      if(!is_null($type_award)){
                                        $type_award = $type_award[0]->type_award;
                                      } else {
                                        $type_award = '--';	
                                      }
                                      $d = explode('-',$r->bulan_tahun_award);
                                      $get_month = date('F', mktime(0, 0, 0, $d[1], 10));
                                      $tanggal_award = $get_month.', '.$d[0];
                                      if($r->cash_price == '') {
                                        $currency = $this->Umb_model->currency_sign(0);
                                      } else {
                                        $currency = $this->Umb_model->currency_sign($r->cash_price);
                                      }		
                                      $perusahaan = $this->Umb_model->read_info_perusahaan($r->perusahaan_id);
                                      if(!is_null($perusahaan)){
                                        $prshn_nama = $perusahaan[0]->name;
                                      } else {
                                        $prshn_nama = '--';	
                                      }
                                      if(in_array('232',$role_resources_ids)) { //view
                                        $view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target="#modals-slide" data-xfield_id="'. $r->award_id . '" data-field_type="awards"><span class="fa fa-eye"></span></button></span>';
                                      } else {
                                        $view = '';
                                      }
                                      $info_award = $type_award.'<br><small class="text-muted"><i>'.$r->description.'<i></i></i></small><br><small class="text-muted"><i>'.$this->lang->line('umb_cash_price').': '.$currency.'<i></i></i></small>';
                                      $combhr = $view;
                                      ?>
                                      <tr>
                                        <td><?php echo $combhr;?></td>
                                        <td><?php echo $info_award;?></td>
                                        <td><?php echo $r->gift_item;?></td>
                                        <td><?php echo $tanggal_award;?></td>
                                      </tr>
                                    <?php } ?>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="tab-pane fade" id="account-perjalanans">
                          <div class="card">
                            <div class="card-header with-elements"> 
                              <span class="card-header-title mr-2"> 
                                <strong> <?php echo $this->lang->line('umb_list_all');?></strong> 
                                <?php echo $this->lang->line('umb_perjalanan');?> 
                              </span> 
                            </div>
                            <?php $perjalanan = $this->Perjalanan_model->get_karyawan_perjalanan($user_id); ?>
                            <div class="card-body">
                              <div class="box-datatable table-responsive">
                                <table class="datatables-demo table table-striped table-bordered umb_hrastral_table">
                                  <thead>
                                    <tr>
                                      <th><?php echo $this->lang->line('umb_view');?></th>
                                      <th><?php echo $this->lang->line('umb_summary');?></th>
                                      <th><?php echo $this->lang->line('umb_visit_place');?></th>
                                      <th>
                                        <i class="fa fa-calendar"></i> 
                                        <?php echo $this->lang->line('umb_start_date');?>
                                      </th>
                                      <th>
                                        <i class="fa fa-calendar"></i>
                                        <?php echo $this->lang->line('umb_end_date');?>
                                      </th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php foreach($perjalanan->result() as $r) { ?>
                                      <?php
                                      $start_date = $this->Umb_model->set_date_format($r->start_date);
                                      $end_date = $this->Umb_model->set_date_format($r->end_date);
                                      $perusahaan = $this->Umb_model->read_info_perusahaan($r->perusahaan_id);
                                      if(!is_null($perusahaan)){
                                        $prshn_nama = $perusahaan[0]->name;
                                      } else {
                                        $prshn_nama = '--';	
                                      }
                                      //if($r->status==0): $status = $this->lang->line('umb_pending');
                                      //elseif($r->status==1): $status = $this->lang->line('umb_accepted'); else: $status = $this->lang->line('umb_rejected'); endif;
                                      if($r->status==0): 
                                        $status = '<span class="badge bg-orange">'.$this->lang->line('umb_pending').'</span>';
                                      elseif($r->status==1): 
                                        $status = '<span class="badge bg-green">'.$this->lang->line('umb_accepted').'</span>';
                                      else: 
                                        $status = '<span class="badge bg-red">'.$this->lang->line('umb_rejected');
                                      endif;
                                      if(in_array('235',$role_resources_ids)) {
                                        $view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target="#modals-slide" data-xfield_id="'. $r->perjalanan_id . '" data-field_type="perjalanan"><span class="fa fa-eye"></span></button></span>';
                                      } else {
                                        $view = '';
                                      }
                                      $combhr = $view;
                                      $expected_budget = $this->Umb_model->currency_sign($r->expected_budget);
                                      $actual_budget = $this->Umb_model->currency_sign($r->actual_budget);
                                      $inama_karyawan = $r->visit_purpose.'<br><small class="text-muted"><i>'.$this->lang->line('umb_expected_perjalanan_budget').': '.$expected_budget.'<i></i></i></small><br><small class="text-muted"><i>'.$this->lang->line('umb_actual_perjalanan_budget').': '.$actual_budget.'<i></i></i></small><br><small class="text-muted"><i>'.$status.'<i></i></i></small>';
                                      ?>
                                      <tr>
                                        <td><?php echo $combhr;?></td>
                                        <td><?php echo $inama_karyawan;?></td>
                                        <td><?php echo $r->visit_place;?></td>
                                        <td><?php echo $start_date;?></td>
                                        <td><?php echo $end_date;?></td>
                                      </tr>
                                    <?php } ?>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="tab-pane fade" id="account-training">
                          <div class="card">
                            <div class="card-header with-elements"> 
                              <span class="card-header-title mr-2"> 
                                <strong> <?php echo $this->lang->line('umb_list_all');?></strong> 
                                <?php echo $this->lang->line('left_training');?> 
                              </span> 
                            </div>
                            <?php $training = $this->Training_model->get_karyawan_training($user_id); ?>
                            <div class="card-body">
                              <div class="box-datatable table-responsive">
                                <table class="datatables-demo table table-striped table-bordered umb_hrastral_table">
                                  <thead>
                                    <tr>
                                      <th><?php echo $this->lang->line('umb_view');?></th>
                                      <th><?php echo $this->lang->line('left_type_training');?></th>
                                      <th><?php echo $this->lang->line('umb_trainer');?></th>
                                      <th>
                                        <i class="fa fa-calendar"></i> 
                                        <?php echo $this->lang->line('umb_durasi_training');?>
                                      </th>
                                      <th>
                                        <i class="fa fa-dollar"></i> 
                                        <?php echo $this->lang->line('umb_cost');?>
                                      </th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php foreach($training->result() as $r) { ?>
                                      <?php
                                      $aim = explode(',',$r->karyawan_id);
                                      $type = $this->Training_model->read_informasi_type_training($r->type_training_id);
                                      if(!is_null($type)){
                                        $itype = $type[0]->type;
                                      } else {
                                        $itype = '--';	
                                      }
                                      $trainer = $this->Trainers_model->read_informasi_trainer($r->trainer_id);
                                      if(!is_null($trainer)){
                                        $nama_trainer = $trainer[0]->first_name.' '.$trainer[0]->last_name;
                                      } else {
                                        $nama_trainer = '--';	
                                      }
                                      $start_date = $this->Umb_model->set_date_format($r->start_date);
                                      $finish_date = $this->Umb_model->set_date_format($r->finish_date);
                                      $tanggal_training = $start_date.' '.$this->lang->line('dashboard_to').' '.$finish_date;
                                      $biaya_training = $this->Umb_model->currency_sign($r->biaya_training);
                                      if($r->karyawan_id == '') {
                                        $ol = '--';
                                      } else {
                                        $ol = '<ol class="nl">';
                                        foreach(explode(',',$r->karyawan_id) as $uid) {
                                          $user = $this->Umb_model->read_user_info($uid);
                                          if(!is_null($user)){
                                            $ol .= '<li>'.$user[0]->first_name.' '.$user[0]->last_name.'</li>';
                                          } else {
                                            $ol .= '--';
                                          }
                                        }
                                        $ol .= '</ol>';
                                      }
                                      //if($r->status_training==0): $status = $this->lang->line('umb_pending');
                                      //elseif($r->status_training==1): $status = $this->lang->line('umb_started'); elseif($r->status_training==2): $status = $this->lang->line('umb_completed');
                                      //else: $status = $this->lang->line('umb_terminated'); endif;
                                      if($r->status_training==0): 
                                        $status = '<span class="badge bg-orange">'.$this->lang->line('umb_pending').'</span>';
                                      elseif($r->status_training==1): 
                                        $status = '<span class="badge bg-teal">'.$this->lang->line('umb_started').'</span>'; 
                                      elseif($r->status_training==2): 
                                        $status = '<span class="badge bg-green">'.$this->lang->line('umb_completed').'</span>';
                                      else: 
                                        $status = '<span class="badge bg-red">'.$this->lang->line('umb_terminated').'</span>'; 
                                      endif;
                                      $perusahaan = $this->Umb_model->read_info_perusahaan($r->perusahaan_id);
                                      if(!is_null($perusahaan)){
                                        $prshn_nama = $perusahaan[0]->name;
                                      } else {
                                        $prshn_nama = '--';	
                                      }
                                      if(in_array('344',$role_resources_ids)) {
                                        $view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_view_details').'"><a href="'.site_url().'admin/training/details/'.$r->training_id.'" target="_blank"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span>';
                                      } else {
                                        $view = '';
                                      }
                                      $combhr = $view;
                                      $iitype = $itype.'<br><small class="text-muted"><i>'.$status.'<i></i></i></small>';
                                      ?>
                                      <tr>
                                        <td><?php echo $combhr;?></td>
                                        <td><?php echo $iitype;?></td>
                                        <td><?php echo $nama_trainer;?></td>
                                        <td><?php echo $tanggal_training;?></td>
                                        <td><?php echo $biaya_training;?></td>
                                      </tr>
                                    <?php } ?>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="tab-pane fade" id="account-tickets">
                          <div class="card">
                            <div class="card-header with-elements"> 
                              <span class="card-header-title mr-2"> 
                                <strong> <?php echo $this->lang->line('umb_list_all');?></strong> 
                                <?php echo $this->lang->line('left_tickets');?> 
                              </span> 
                            </div>
                            <?php $ticket = $this->Tickets_model->get_tickets_karyawans($user_id);?>
                            <div class="card-body">
                              <div class="box-datatable table-responsive">
                                <table class="datatables-demo table table-striped table-bordered umb_hrastral_table">
                                  <thead>
                                    <tr class="umb-bg-dark">
                                      <th><?php echo $this->lang->line('umb_view');?></th>
                                      <th><?php echo $this->lang->line('umb_kode_ticket');?></th>
                                      <th><?php echo $this->lang->line('umb_subject');?></th>
                                      <th><?php echo $this->lang->line('umb_p_priority');?></th>
                                      <th>
                                        <i class="fa fa-calendar"></i> 
                                        <?php echo $this->lang->line('umb_e_details_tanggal');?>
                                      </th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php foreach($ticket->result() as $r) { ?>
                                      <?php		
                                      if($r->ticket_priority==1): 
                                        $priority = $this->lang->line('umb_low'); 
                                      elseif($r->ticket_priority==2): 
                                        $priority = $this->lang->line('umb_medium'); 
                                      elseif($r->ticket_priority==3): 
                                        $priority = $this->lang->line('umb_high'); 
                                      elseif($r->ticket_priority==4): 
                                        $priority = $this->lang->line('umb_critical');  
                                      endif;
                                      //if($r->status_ticket==1): $status = $this->lang->line('umb_open'); elseif($r->status_ticket==2): $status = $this->lang->line('umb_closed'); endif;
                                      if($r->status_ticket==1): 
                                        $status = '<span class="badge bg-orange">'.$this->lang->line('umb_open').'</span>';
                                      else: 
                                        $status = '<span class="badge bg-green">'.$this->lang->line('umb_closed').'</span>';
                                      endif;
                                      $created_at = date('h:i A', strtotime($r->created_at));
                                      $_date = explode(' ',$r->created_at);
                                      $edate = $this->Umb_model->set_date_format($_date[0]);
                                      $_created_at = $edate. ' '. $created_at;
                                      $view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_view_details').'"><a href="'.site_url().'admin/tickets/details/'.$r->ticket_id.'" target="_blank"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span>';
                                      $combhr = $view;
                                      $ikode_ticket = $r->kode_ticket.'<br><small class="text-muted"><i>'.$status.'<i></i></i></small>';
                                      ?>
                                      <tr>
                                        <td><?php echo $combhr;?></td>
                                        <td><?php echo $ikode_ticket;?></td>
                                        <td><?php echo $r->subject;?></td>
                                        <td><?php echo $priority;?></td>
                                        <td><?php echo $_created_at;?></td>
                                      </tr>
                                    <?php } ?>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="tab-pane fade" id="account-transfers">
                          <div class="card">
                            <div class="card-header with-elements"> 
                              <span class="card-header-title mr-2"> 
                                <strong> <?php echo $this->lang->line('umb_list_all');?></strong> 
                                <?php echo $this->lang->line('left_transfers');?> 
                              </span> 
                            </div>
                            <?php $transfer = $this->Transfers_model->get_karyawan_transfers($user_id); ?>
                            <div class="card-body">
                              <div class="box-datatable table-responsive">
                                <table class="datatables-demo table table-striped table-bordered umb_hrastral_table">
                                  <thead>
                                    <tr>
                                      <th><?php echo $this->lang->line('umb_view');?></th>
                                      <th><?php echo $this->lang->line('umb_summary');?></th>
                                      <th><?php echo $this->lang->line('left_perusahaan');?></th>
                                      <th>
                                        <i class="fa fa-calendar"></i> 
                                        <?php echo $this->lang->line('umb_tanggal_transfer');?>
                                      </th>
                                      <th><?php echo $this->lang->line('dashboard_umb_status');?></th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php foreach($transfer->result() as $r) { ?>
                                      <?php
                                      $tanggal_transfer = $this->Umb_model->set_date_format($r->tanggal_transfer);
                                      $department = $this->Department_model->read_informasi_department($r->transfer_department);
                                      if(!is_null($department)){
                                        $nama_department = $department[0]->nama_department;
                                      } else {
                                        $nama_department = '--';	
                                      }
                                      $location = $this->Location_model->read_informasi_location($r->transfer_location);
                                      if(!is_null($location)){
                                        $nama_location = $location[0]->nama_location;
                                      } else {
                                        $nama_location = '--';	
                                      }
                                      if($r->status==0): 
                                        $status = '<span class="badge bg-orange">'.$this->lang->line('umb_pending').'</span>';
                                      elseif($r->status==1): 
                                        $status = '<span class="badge bg-green">'.$this->lang->line('umb_accepted').'</span>';
                                      else: 
                                        $status = '<span class="badge bg-red">'.$this->lang->line('umb_rejected').'</span>'; 
                                      endif;
                                      $perusahaan = $this->Umb_model->read_info_perusahaan($r->perusahaan_id);
                                      if(!is_null($perusahaan)){
                                        $prshn_nama = $perusahaan[0]->name;
                                      } else {
                                        $prshn_nama = '--';	
                                      }
                                      if(in_array('233',$role_resources_ids)) {
                                        $view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target="#modals-slide" data-xfield_id="'. $r->transfer_id . '" data-field_type="transfers"><span class="fa fa-eye"></span></button></span>';
                                      } else {
                                        $view = '';
                                      }
                                      $combhr = $view;
                                      $xinfo = $this->lang->line('umb_transfer_to_department').': '.$nama_department.'<i></i></i></small><br><small class="text-muted"><i>'.$this->lang->line('umb_transfer_to_location').': '.$nama_location.'<i></i></i></small>';
                                      ?>
                                      <tr>
                                        <td><?php echo $combhr;?></td>
                                        <td><?php echo $xinfo;?></td>
                                        <td><?php echo $prshn_nama;?></td>
                                        <td><?php echo $tanggal_transfer;?></td>
                                        <td><?php echo $status;?></td>
                                      </tr>
                                    <?php } ?>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="tab-pane fade" id="account-promotions">
                          <div class="card">
                            <div class="card-header with-elements"> 
                              <span class="card-header-title mr-2"> 
                                <strong> <?php echo $this->lang->line('umb_list_all');?></strong> 
                                <?php echo $this->lang->line('left_promotions');?> 
                              </span> 
                            </div>
                            <?php $promotion = $this->Promotion_model->get_karyawan_promotions($user_id); ?>
                            <div class="card-body">
                              <div class="box-datatable table-responsive">
                                <table class="datatables-demo table table-striped table-bordered umb_hrastral_table">
                                  <thead>
                                    <tr>
                                      <th><?php echo $this->lang->line('umb_view');?></th>
                                      <th><?php echo $this->lang->line('umb_title_promotion');?></th>
                                      <th>
                                        <i class="fa fa-calendar"></i> 
                                        <?php echo $this->lang->line('umb_e_details_tanggal');?>
                                      </th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php foreach($promotion->result() as $r) { ?>
                                      <?php
                                      $perusahaan = $this->Umb_model->read_info_perusahaan($r->perusahaan_id);
                                      if(!is_null($perusahaan)){
                                        $prshn_nama = $perusahaan[0]->name;
                                      } else {
                                        $prshn_nama = '--';	
                                      }
                                      $tanggal_promotion = $this->Umb_model->set_date_format($r->tanggal_promotion);
                                      if(in_array('236',$role_resources_ids)) {
                                        $view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target="#modals-slide" data-xfield_id="'. $r->promotion_id . '" data-field_type="promotion"><span class="fa fa-eye"></span></button></span>';
                                      } else {
                                        $view = '';
                                      }
                                      $combhr = $view;
                                      $pro_desc = $r->title.'<br><small class="text-muted"><i>'.$this->lang->line('umb_description').': '.$r->description.'<i></i></i></small>';
                                      ?>
                                      <tr>
                                        <td><?php echo $combhr;?></td>
                                        <td><?php echo $pro_desc;?></td>
                                        <td><?php echo $tanggal_promotion;?></td>
                                      </tr>
                                    <?php } ?>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="tab-pane fade" id="account-keluhans">
                          <div class="card">
                            <div class="card-header with-elements"> 
                              <span class="card-header-title mr-2"> 
                                <strong> <?php echo $this->lang->line('umb_list_all');?></strong> 
                                <?php echo $this->lang->line('left_keluhans');?> 
                              </span> 
                            </div>
                            <?php $keluhan = $this->Keluhans_model->get_karyawan_keluhans($user_id); ?>
                            <div class="card-body">
                              <div class="box-datatable table-responsive">
                                <table class="datatables-demo table table-striped table-bordered umb_hrastral_table">
                                  <thead>
                                    <tr>
                                      <th><?php echo $this->lang->line('umb_view');?></th>
                                      <th width="200">
                                        <i class="fa fa-user"></i> 
                                        <?php echo $this->lang->line('umb_keluhan_dari');?>
                                      </th>
                                      <th>
                                        <i class="fa fa-users"></i> 
                                        <?php echo $this->lang->line('umb_keluhan_terhadap');?>
                                      </th>
                                      <th><?php echo $this->lang->line('umb_title_keluhan');?></th>
                                      <th>
                                        <i class="fa fa-calendar"></i> 
                                        <?php echo $this->lang->line('umb_tanggal_keluhan');?>
                                      </th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php foreach($keluhan->result() as $r) { ?>
                                      <?php
                                      $user = $this->Umb_model->read_user_info($r->keluhan_dari);
                                      if(!is_null($user)){
                                        $keluhan_dari = $user[0]->first_name.' '.$user[0]->last_name;
                                      } else {
                                        $keluhan_dari = '--';	
                                      }
                                      if($r->keluhan_terhadap == '') {
                                        $ol = '--';
                                      } else {
                                        $ol = '<ol class="nl">';
                                        foreach(explode(',',$r->keluhan_terhadap) as $tunjuk_id) {
                                          $_prshn_nama = $this->Umb_model->read_user_info($tunjuk_id);
                                          if(!is_null($_prshn_nama)){
                                            $ol .= '<li>'.$_prshn_nama[0]->first_name.' '.$_prshn_nama[0]->last_name.'</li>';
                                          } else {
                                            $ol .= '';
                                          }
                                        }
                                        $ol .= '</ol>';
                                      }
                                      $tanggal_keluhan = $this->Umb_model->set_date_format($r->tanggal_keluhan);

                                      if(in_array('237',$role_resources_ids)) {
                                        $view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target="#modals-slide" data-xfield_id="'. $r->keluhan_id . '" data-field_type="keluhans"><span class="fa fa-eye"></span></button></span>';
                                      } else {
                                        $view = '';
                                      }
                                      $perusahaan = $this->Umb_model->read_info_perusahaan($r->perusahaan_id);
                                      if(!is_null($perusahaan)){
                                        $prshn_nama = $perusahaan[0]->name;
                                      } else {
                                        $prshn_nama = '--';	
                                      }
                                      if($r->status==0): 
                                        $status = '<span class="badge bg-red">'.$this->lang->line('umb_pending').'</span>';
                                      elseif($r->status==1): 
                                        $status = '<span class="badge bg-green">'.$this->lang->line('umb_accepted').'</span>'; 
                                      else: 
                                        $status = '<span class="badge bg-red">'.$this->lang->line('umb_rejected').'</span>';
                                      endif;
                                      $ikeluhan_dari = $keluhan_dari.'<br><small class="text-muted"><i>'.$this->lang->line('umb_description').': '.$r->description.'<i></i></i></small><br><small class="text-muted"><i>'.$status.'<i></i></i></small>';
                                      $combhr = $view;
                                      ?>
                                      <tr>
                                        <td><?php echo $combhr;?></td>
                                        <td><?php echo $ikeluhan_dari;?></td>
                                        <td><?php echo $ol;?></td>
                                        <td><?php echo $r->title;?></td>
                                        <td><?php echo $tanggal_keluhan;?></td>
                                      </tr>
                                    <?php } ?>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="tab-pane fade" id="account-peringatans">
                          <div class="card">
                            <div class="card-header with-elements"> 
                              <span class="card-header-title mr-2"> 
                                <strong> <?php echo $this->lang->line('umb_list_all');?></strong> 
                                <?php echo $this->lang->line('left_peringatans');?> 
                              </span> 
                            </div>
                            <?php $peringatan = $this->Peringatan_model->get_peringatan_karyawan($user_id); ?>
                            <div class="card-body">
                              <div class="box-datatable table-responsive">
                                <table class="datatables-demo table table-striped table-bordered umb_hrastral_table">
                                  <thead>
                                    <tr>
                                      <th><?php echo $this->lang->line('umb_view');?></th>
                                      <th><?php echo $this->lang->line('umb_subject');?></th>
                                      <th>
                                        <i class="fa fa-calendar"></i> 
                                        <?php echo $this->lang->line('umb_tanggal_peringatan');?>
                                      </th>
                                      <th>
                                        <i class="fa fa-user"></i> 
                                        <?php echo $this->lang->line('umb_peringatan_oleh');?>
                                      </th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php foreach($peringatan->result() as $r) { ?>
                                      <?php
                                      $user = $this->Umb_model->read_user_info($r->peringatan_ke);
                                      if(!is_null($user)){
                                        $peringatan_ke = $user[0]->first_name.' '.$user[0]->last_name;
                                      } else {
                                        $peringatan_ke = '--';	
                                      }
                                      $user_by = $this->Umb_model->read_user_info($r->peringatan_oleh);

                                      if(!is_null($user_by)){
                                        $peringatan_oleh = $user_by[0]->first_name.' '.$user_by[0]->last_name;
                                      } else {
                                        $peringatan_oleh = '--';	
                                      }
                                      $tanggal_peringatan = $this->Umb_model->set_date_format($r->tanggal_peringatan);
                                      if($r->status==0): 
                                        $status = $this->lang->line('umb_pending');
                                      elseif($r->status==1): 
                                        $status = $this->lang->line('umb_accepted'); 
                                      else: 
                                        $status = $this->lang->line('umb_rejected'); 
                                      endif;
                                      $type_peringatan = $this->Peringatan_model->read_informasi_type_peringatan($r->type_peringatan_id);
                                      if(!is_null($type_peringatan)){
                                        $wtype = $type_peringatan[0]->type;
                                      } else {
                                        $wtype = '--';	
                                      }
                                      $perusahaan = $this->Umb_model->read_info_perusahaan($r->perusahaan_id);
                                      if(!is_null($perusahaan)){
                                        $prshn_nama = $perusahaan[0]->name;
                                      } else {
                                        $prshn_nama = '--';	
                                      }

                                      if(in_array('238',$role_resources_ids)) {
                                        $view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target="#modals-slide" data-xfield_id="'. $r->peringatan_id . '" data-field_type="warning"><span class="fa fa-eye"></span></button></span>';
                                      } else {
                                        $view = '';
                                      }
                                      if($r->status==0): 
                                        $status = '<span class="badge bg-orange">'.$this->lang->line('umb_pending').'</span>';
                                      elseif($r->status==1): 
                                        $status = '<span class="badge bg-green">'.$this->lang->line('umb_accepted').'</span>';
                                      else: 
                                        $status = '<span class="badge bg-red">'.$this->lang->line('umb_rejected').'</span>'; 
                                      endif;
                                      $combhr = $view;
                                      $iperingatan_ke = $peringatan_ke.'<br><small class="text-muted"><i>'.$wtype.'<i></i></i></small><br><small class="text-muted"><i>'.$status.'<i></i></i></small>';
                                      ?>
                                      <tr>
                                        <td><?php echo $combhr;?></td>
                                        <td><?php echo $r->subject;?></td>
                                        <td><?php echo $tanggal_peringatan;?></td>
                                        <td><?php echo $peringatan_oleh;?></td>
                                      </tr>
                                    <?php } ?>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div id="smartwizard-2-step-5" class="animated fadeIn tab-pane step-content mt-3" style="display: none;">
              <div class="cards-body">
                <div class="card overflow-hidden">
                  <div class="row no-gutters row-bordered row-border-light">
                    <div class="col-md-3 pt-0">
                      <div class="list-group list-group-flush account-settings-links"> 
                        <a class="list-group-item list-group-item-action active" data-toggle="list" href="#account-projects"> 
                          <i class="lnr lnr-layers text-lightest"></i> &nbsp; <?php echo $this->lang->line('left_projects');?>
                        </a> 
                        <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-tugass"> 
                          <i class="lnr lnr-dice text-lightest"></i> &nbsp; <?php echo $this->lang->line('left_tugass');?>
                        </a> 
                      </div>
                    </div>
                    <div class="col-md-9">
                      <div class="tab-content">
                        <div class="tab-pane fade show active" id="account-projects">
                          <div class="card">
                            <div class="card-header with-elements"> 
                              <span class="card-header-title mr-2"> 
                                <strong> <?php echo $this->lang->line('umb_list_all');?></strong> 
                                <?php echo $this->lang->line('left_projects');?> 
                              </span> 
                            </div>
                            <?php $project = $this->Project_model->get_projects_karyawan($user_id); ?>
                            <div class="card-body">
                              <div class="box-datatable table-responsive">
                                <table class="datatables-demo table table-striped table-bordered umb_hrastral_table" id="umb_hr_table">
                                  <thead>
                                    <tr>
                                      <th width="230"><?php echo $this->lang->line('umb_ringkasan_project');?></th>
                                      <th><?php echo $this->lang->line('umb_p_priority');?></th>
                                      <th>
                                        <i class="fa fa-user"></i> 
                                        <?php echo $this->lang->line('umb_project_users');?>
                                      </th>
                                      <th>
                                        <i class="fa fa-calendar"></i> 
                                        <?php echo $this->lang->line('umb_p_enddate');?>
                                      </th>
                                      <th><?php echo $this->lang->line('dashboard_umb_progress');?></th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php foreach($project->result() as $r) { ?>
                                      <?php
                                      $aim = explode(',',$r->assigned_to);
                                      $user = $this->Umb_model->read_user_info($r->added_by);
                                      if(!is_null($user)){
                                        $full_name = $user[0]->first_name.' '.$user[0]->last_name;
                                      } else {
                                        $full_name = '--';	
                                      }
                                      $pdate = '<i class="fa fa-calendar position-left"></i> '.$this->Umb_model->set_date_format($r->end_date);
                                      if($r->progress_project <= 20) {
                                        $progress_class = 'progress-danger';
                                      } else if($r->progress_project > 20 && $r->progress_project <= 50){
                                        $progress_class = 'progress-warning';
                                      } else if($r->progress_project > 50 && $r->progress_project <= 75){
                                        $progress_class = 'progress-info';
                                      } else {
                                        $progress_class = 'progress-success';
                                      }
                                      $pbar = '<p class="m-b-0-5">'.$this->lang->line('umb_completed').' <span class="pull-xs-right">'.$r->progress_project.'%</span></p><progress class="progress '.$progress_class.' progress-sm" value="'.$r->progress_project.'" max="100">'.$r->progress_project.'%</progress>';
                                      if($r->status == 0) {
                                        $status = $this->lang->line('umb_not_started');
                                      } else if($r->status ==1){
                                        $status = $this->lang->line('umb_in_progress');
                                      } else if($r->status ==2){
                                        $status = $this->lang->line('umb_completed');
                                      } else {
                                        $status = $this->lang->line('umb_deffered');
                                      }
                                      if($r->priority == 1) {
                                        $priority = '<span class="label label-danger">'.$this->lang->line('umb_highest').'</span>';
                                      } else if($r->priority ==2){
                                        $priority = '<span class="label label-danger">'.$this->lang->line('umb_high').'</span>';
                                      } else if($r->priority ==3){
                                        $priority = '<span class="label label-primary">'.$this->lang->line('umb_normal').'</span>';
                                      } else {
                                        $priority = '<span class="label label-success">'.$this->lang->line('umb_low').'</span>';
                                      }
                                      if($r->assigned_to == '') {
                                        $ol = $this->lang->line('umb_not_assigned');
                                      } else {
                                        $ol = '';
                                        foreach(explode(',',$r->assigned_to) as $tunjuk_id) {
                                          $assigned_to = $this->Umb_model->read_user_info($tunjuk_id);
                                          if(!is_null($assigned_to)){
                                            $assigned_name = $assigned_to[0]->first_name.' '.$assigned_to[0]->last_name;
                                            if($assigned_to[0]->profile_picture!='' && $assigned_to[0]->profile_picture!='no file') {
                                              $ol .= '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.base_url().'uploads/profile/'.$assigned_to[0]->profile_picture.'" class="ui-w-30 rounded-circle" alt=""></span></a>';
                                            } else {
                                              if($assigned_to[0]->jenis_kelamin=='Pria') { 
                                                $de_file = base_url().'uploads/profile/default_male.jpg';
                                              } else {
                                                $de_file = base_url().'uploads/profile/default_female.jpg';
                                              }
                                              $ol .= '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.$de_file.'" class="ui-w-30 rounded-circle" alt=""></span></a>';
                                            }
                                          }
                                          else {
                                            $ol .= '';
                                          }
                                        }
                                        $ol .= '';
                                      }
                                      $ringkasan_project = '<div class="text-semibold"><a href="'.site_url().'admin/project/detail/'.$r->project_id . '" target="_blank">'.$r->title.'</a></div><div class="text-muted">'.$r->summary.'</div>';
                                      ?>
                                      <tr>
                                        <td><?php echo $ringkasan_project;?></td>
                                        <td><?php echo $priority;?></td>
                                        <td><?php echo $ol;?></td>
                                        <td><?php echo $pdate;?></td>
                                        <td><?php echo $pbar;?></td>
                                      </tr>
                                    <?php } ?>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="tab-pane fade" id="account-tugass">
                          <div class="card">
                            <div class="card-header with-elements"> 
                              <span class="card-header-title mr-2"> 
                                <strong> <?php echo $this->lang->line('umb_list_all');?></strong> 
                                <?php echo $this->lang->line('left_tugass');?> 
                              </span> 
                            </div>
                            <?php $tugas = $this->Timesheet_model->get_tugass_karyawan($user_id); ?>
                            <div class="card-body">
                              <div class="box-datatable table-responsive">
                                <table class="datatables-demo table table-striped table-bordered umb_hrastral_table">
                                  <thead>
                                    <tr>
                                      <th><?php echo $this->lang->line('umb_view');?></th>
                                      <th><?php echo $this->lang->line('dashboard_umb_title');?></th>
                                      <th><?php echo $this->lang->line('umb_end_date');?></th>
                                      <th><?php echo $this->lang->line('dashboard_umb_status');?></th>
                                      <th><?php echo $this->lang->line('umb_assigned_to');?></th>
                                      <th><?php echo $this->lang->line('dashboard_umb_progress');?></th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php foreach($tugas->result() as $r) { ?>
                                      <?php
                                      $aim = explode(',',$r->assigned_to);
                                      if($r->assigned_to == '' || $r->assigned_to == 'None') {
                                        $ol = 'None';
                                      } else {
                                        $ol = '<ol class="nl">';
                                        foreach(explode(',',$r->assigned_to) as $uid) {
                                          //$user = $this->Umb_model->read_user_info($uid);
                                          $assigned_to = $this->Umb_model->read_user_info($uid);
                                          if(!is_null($assigned_to)){
                                            $assigned_name = $assigned_to[0]->first_name.' '.$assigned_to[0]->last_name;
                                            if($assigned_to[0]->profile_picture!='' && $assigned_to[0]->profile_picture!='no file') {
                                              $ol .= '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.base_url().'uploads/profile/'.$assigned_to[0]->profile_picture.'" class="ui-w-30 rounded-circle" alt=""></span></a>';
                                            } else {
                                              if($assigned_to[0]->jenis_kelamin=='Pria') { 
                                                $de_file = base_url().'uploads/profile/default_male.jpg';
                                              } else {
                                                $de_file = base_url().'uploads/profile/default_female.jpg';
                                              }
                                              $ol .= '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.$de_file.'" class="ui-w-30 rounded-circle" alt=""></span></a>';
                                            }
                                          }
                                        }
                                        $ol .= '</ol>';
                                      }							
                                      $prj_tugas = $this->Project_model->read_informasi_project($r->project_id);
                                      if(!is_null($prj_tugas)){
                                        $nama_prj = $prj_tugas[0]->title;
                                      } else {
                                        $nama_prj = '--';
                                      }
                                      if($r->progress_tugas=='' || $r->progress_tugas==0): $progress = 0; else: $progress = $r->progress_tugas; endif;				
                                      if($r->progress_tugas <= 20) {
                                        $progress_class = 'progress-danger';
                                      } else if($r->progress_tugas > 20 && $r->progress_tugas <= 50){
                                        $progress_class = 'progress-warning';
                                      } else if($r->progress_tugas > 50 && $r->progress_tugas <= 75){
                                        $progress_class = 'progress-info';
                                      } else {
                                        $progress_class = 'progress-success';
                                      }
                                      $progress_bar = '<p class="m-b-0-5">'.$this->lang->line('umb_completed').' <span class="pull-xs-right">'.$r->progress_tugas.'%</span></p><progress class="progress '.$progress_class.' progress-sm" value="'.$r->progress_tugas.'" max="100">'.$r->progress_tugas.'%</progress>';
                                      $tdate = $this->Umb_model->set_date_format($r->end_date);							
                                      if($r->status_tugas == 0) {
                                        $status = $this->lang->line('umb_not_started');
                                      } else if($r->status_tugas ==1){
                                        $status = $this->lang->line('umb_in_progress');
                                      } else if($r->status_tugas ==2){
                                        $status = $this->lang->line('umb_completed');
                                      } else {
                                        $status = $this->lang->line('umb_deffered');
                                      }
                                      if(in_array('322',$role_resources_ids)) {
                                        $view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_view_details').'"><a href="'.site_url().'admin/timesheet/details_tugas/id/'.$r->tugas_id.'/" target="_blank"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span>';
                                      } else {
                                        $view = '';
                                      }
                                      $combhr = $view;
                                      $nama_tugas = $r->nama_tugas.'<br>'.$this->lang->line('umb_project').': <a href="'.site_url().'admin/project/detail/'.$r->project_id.'" target="_blank">'.$nama_prj.'</a>';
                                      ?>
                                      <tr>
                                        <td><?php echo $combhr;?></td>
                                        <td><?php echo $nama_tugas;?></td>
                                        <td><?php echo $tdate;?></td>
                                        <td><?php echo $status;?></td>
                                        <td><?php echo $ol;?></td>
                                        <td><?php echo $progress_bar;?></td>
                                      </tr>
                                    <?php } ?>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div id="smartwizard-2-step-6" class="card animated fadeIn tab-pane step-content mt-3" style="display: none;">
              <div class="card">
                <div class="card-header with-elements"> 
                  <span class="card-header-title mr-2"> 
                    <strong> <?php echo $this->lang->line('umb_list_all');?></strong> 
                    <?php echo $this->lang->line('left_history_pembayaran');?> 
                  </span> 
                </div>
                <?php $history = $this->Payroll_model->get_payroll_slip($user_id); ?>
                <div class="card-body">
                  <div class="box-datatable table-responsive">
                    <table class="datatables-demo table table-striped table-bordered umb_hrastral_table" id="umb_hr_table">
                      <thead>
                        <tr>
                          <th><?php echo $this->lang->line('umb_action');?></th>
                          <th><?php echo $this->lang->line('umb_payroll_net_payable');?></th>
                          <th><?php echo $this->lang->line('umb_gaji_bulan');?></th>
                          <th>
                            <i class="fa fa-calendar"></i> 
                            <?php echo $this->lang->line('umb_payroll_date_title');?>
                          </th>
                          <th><?php echo $this->lang->line('dashboard_umb_status');?></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach($history->result() as $r) { ?>
                          <?php
                          $user = $this->Umb_model->read_user_info($r->karyawan_id);
                          if(!is_null($user)){
                            $full_name = $user[0]->first_name.' '.$user[0]->last_name;
                            $link_krywn = $user[0]->karyawan_id;			  		  
                            $month_payment = date("F, Y", strtotime($r->gaji_bulan));
                            $p_jumlah = $this->Umb_model->currency_sign($r->gaji_bersih);
                            $created_at = $this->Umb_model->set_date_format($r->created_at);
                            $penunjukan = $this->Penunjukan_model->read_informasi_penunjukan($user[0]->penunjukan_id);
                            if(!is_null($penunjukan)){
                              $nama_penunjukan = $penunjukan[0]->nama_penunjukan;
                            } else {
                              $nama_penunjukan = '--';	
                            }
                            $department = $this->Department_model->read_informasi_department($user[0]->department_id);
                            if(!is_null($department)){
                              $nama_department = $department[0]->nama_department;
                            } else {
                              $nama_department = '--';	
                            }
                            $department_penunjukan = $nama_penunjukan.' ('.$nama_department.')';
                            $perusahaan = $this->Umb_model->read_info_perusahaan($user[0]->perusahaan_id);
                            if(!is_null($perusahaan)){
                              $prshn_nama = $perusahaan[0]->name;
                            } else {
                              $prshn_nama = '--';	
                            }
                            $bank_account = $this->Karyawans_model->get_karyawan_bank_account_terakhir($user[0]->user_id);
                            if(!is_null($bank_account)){
                              $nomor_account = $bank_account[0]->nomor_account;
                            } else {
                              $nomor_account = '--';	
                            }
                            $slipgaji = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_view').'"><a href="'.site_url().'admin/payroll/slipgaji/id/'.$r->slipgaji_key.'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span><span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('umb_download').'"><a href="'.site_url().'admin/payroll/pdf_create/p/'.$r->slipgaji_key.'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="oi oi-cloud-download"></span></button></a></span>';
                            $ifull_name = nl2br ($full_name."\r\n <small class='text-muted'><i>".$this->lang->line('umb_karyawans_id').': '.$link_krywn."<i></i></i></small>\r\n <small class='text-muted'><i>".$department_penunjukan.'<i></i></i></small>');
                            ?>
                            <tr>
                              <td><?php echo $slipgaji;?></td>
                              <td><?php echo $p_jumlah;?></td>
                              <td><?php echo $month_payment;?></td>
                              <td><?php echo $created_at;?></td>
                              <td><?php echo $this->lang->line('umb_payroll_bayar');?></td>
                            </tr>
                          <?php } 
                        } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
