<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>
<?php $role_resources_ids = $this->Umb_model->user_role_resource(); ?>
<?php $user_info = $this->Umb_model->read_user_info($session['user_id']);?>
<?php
// reports to 
$laporans_to = get_data_laporans_team($session['user_id']); ?>
<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('422',$role_resources_ids) && $user_info[0]->user_role_id==1) {?>
      <li class="nav-item clickable"> <a href="<?php echo site_url('admin/karyawans/dashboard_staff/');?>" data-link-data="<?php echo site_url('admin/karyawans/dashboard_staff/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-done-icon ion ion-md-speedometer"></span> <span class="sw-icon ion ion-md-speedometer"></span> <?php echo $this->lang->line('hr_title_dashboard_staff');?>
      <div class="text-muted small"><?php echo $this->lang->line('hr_title_dashboard_staff');?></div>
    </a> </li>
  <?php } ?>
  <?php if(in_array('13',$role_resources_ids) || $laporans_to>0) {?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/karyawans/');?>" data-link-data="<?php echo site_url('admin/karyawans/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-done-icon fas fa-user-friends"></span> <span class="sw-icon fas fa-user-friends"></span> <?php echo $this->lang->line('dashboard_karyawans');?>
    <div class="text-muted small"><?php echo $this->lang->line('umb_set_up');?> <?php echo $this->lang->line('dashboard_karyawans');?></div>
  </a> </li>
<?php } ?>
<?php if($user_info[0]->user_role_id==1) {?>
  <li class="nav-item clickable"> <a href="<?php echo site_url('admin/roles/');?>" class="mb-3 nav-link hrastral-link" data-link-data="<?php echo site_url('admin/roles/');?>"> <span class="sw-icon ion ion-md-unlock"></span> <?php echo $this->lang->line('umb_role_urole');?>
  <div class="text-muted small"><?php echo $this->lang->line('left_set_roles');?></div>
</a> </li>
<?php } ?>
<?php if(in_array('7',$role_resources_ids)) { ?>
  <li class="nav-item active"> <a href="<?php echo site_url('admin/timesheet/shift_kantor/');?>" data-link-data="<?php echo site_url('admin/timesheet/shift_kantor/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon ion ion-md-clock"></span> <?php echo $this->lang->line('left_shifts_kantor');?>
  <div class="text-muted small"><?php echo $this->lang->line('umb_role_create');?> <?php echo $this->lang->line('left_shifts_kantor');?></div>
</a> </li>
<?php } ?>
</ul>
</div>
<hr class="border-light m-0 mb-3">
<?php if(in_array('280',$role_resources_ids)) {?>
  <?php $user_info = $this->Umb_model->read_user_info($session['user_id']);?>
  <div class="card mb-4 <?php echo $get_animate;?>">
    <div id="accordion">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_add_new');?></strong> <?php echo $this->lang->line('left_shift_kantor');?></span>
        <div class="card-header-elements ml-md-auto"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_shift_form" aria-expanded="false">
          <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('umb_add_new');?></button>
        </a> </div>
      </div>
      <div id="add_shift_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
        <div class="card-body">
          <?php $attributes = array('name' => 'add_shift_kantor', 'id' => 'umb-form', 'autocomplete' => 'off');?>
          <?php $hidden = array('user_id' => $session['user_id']);?>
          <?php echo form_open('admin/timesheet/add_shift_kantor', $attributes, $hidden);?>
          <div class="bg-white">
            <div class="box-block">
              <div class="row">
                <div class="col-md-10">
                  <?php if($user_info[0]->user_role_id==1){ ?>
                    <div class="form-group row">
                      <label for="time" class="col-md-2"><?php echo $this->lang->line('left_perusahaan');?></label>
                      <div class="col-md-4">
                        <select class="form-control" name="perusahaan_id" id="aj_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_perusahaan');?>">
                          <option value=""></option>
                          <?php foreach($get_all_perusahaans as $perusahaan) {?>
                            <option value="<?php echo $perusahaan->perusahaan_id?>"><?php echo $perusahaan->name?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                  <?php } else {?>
                    <?php $eperusahaan_id = $user_info[0]->perusahaan_id;?>
                    <div class="form-group row">
                      <label for="time" class="col-md-2"><?php echo $this->lang->line('left_perusahaan');?></label>
                      <div class="col-md-4">
                        <select class="form-control" name="perusahaan_id" id="aj_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_perusahaan');?>">
                          <option value=""></option>
                          <?php foreach($get_all_perusahaans as $perusahaan) {?>
                            <?php if($eperusahaan_id == $perusahaan->perusahaan_id):?>
                              <option value="<?php echo $perusahaan->perusahaan_id?>"><?php echo $perusahaan->name?></option>
                            <?php endif;?>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                  <?php } ?>
                  <div class="form-group row">
                    <label for="time" class="col-md-2"><?php echo $this->lang->line('umb_nama_shift');?></label>
                    <div class="col-md-4">
                      <input class="form-control" placeholder="<?php echo $this->lang->line('umb_nama_shift');?>" name="nama_shift" type="text" value="" id="name">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="time" class="col-md-2"><?php echo $this->lang->line('umb_monday');?></label>
                    <div class="col-md-4">
                      <input class="form-control timepicker clear-1" placeholder="<?php echo $this->lang->line('umb_in_time');?>" readonly name="senen_waktu_masuk" type="text" value="">
                    </div>
                    <div class="col-md-4">
                      <input class="form-control timepicker clear-1" placeholder="<?php echo $this->lang->line('umb_out_time');?>" readonly name="senen_waktu_pulang" type="text" value="">
                    </div>
                    <div class="col-md-2">
                      <button type="button" class="btn btn-primary clear-time" data-clear-id="1"><?php echo $this->lang->line('umb_clear');?></button>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="time" class="col-md-2"><?php echo $this->lang->line('umb_tuesday');?></label>
                    <div class="col-md-4">
                      <input class="form-control timepicker clear-2" placeholder="<?php echo $this->lang->line('umb_in_time');?>" readonly name="selasa_waktu_masuk" type="text" value="">
                    </div>
                    <div class="col-md-4">
                      <input class="form-control timepicker clear-2" placeholder="<?php echo $this->lang->line('umb_out_time');?>" readonly name="selasa_waktu_pulang" type="text" value="">
                    </div>
                    <div class="col-md-2">
                      <button type="button" class="btn btn-primary clear-time" data-clear-id="2"><?php echo $this->lang->line('umb_clear');?></button>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="time" class="col-md-2"><?php echo $this->lang->line('umb_wednesday');?></label>
                    <div class="col-md-4">
                      <input class="form-control timepicker clear-3" placeholder="<?php echo $this->lang->line('umb_in_time');?>" readonly name="rabu_waktu_masuk" type="text" value="">
                    </div>
                    <div class="col-md-4">
                      <input class="form-control timepicker clear-3" placeholder="<?php echo $this->lang->line('umb_out_time');?>" readonly name="rabu_waktu_pulang" type="text" value="">
                    </div>
                    <div class="col-md-2">
                      <button type="button" class="btn btn-primary clear-time" data-clear-id="3"><?php echo $this->lang->line('umb_clear');?></button>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="time" class="col-md-2"><?php echo $this->lang->line('umb_thursday');?></label>
                    <div class="col-md-4">
                      <input class="form-control timepicker clear-4" placeholder="<?php echo $this->lang->line('umb_in_time');?>" readonly name="kamis_waktu_masuk" type="text" value="">
                    </div>
                    <div class="col-md-4">
                      <input class="form-control timepicker clear-4" placeholder="<?php echo $this->lang->line('umb_out_time');?>" readonly name="kamis_waktu_pulang" type="text" value="">
                    </div>
                    <div class="col-md-2">
                      <button type="button" class="btn btn-primary clear-time" data-clear-id="4"><?php echo $this->lang->line('umb_clear');?></button>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="time" class="col-md-2"><?php echo $this->lang->line('umb_friday');?></label>
                    <div class="col-md-4">
                      <input class="form-control timepicker clear-5" placeholder="<?php echo $this->lang->line('umb_in_time');?>" readonly name="jumat_waktu_masuk" type="text" value="">
                    </div>
                    <div class="col-md-4">
                      <input class="form-control timepicker clear-5" placeholder="<?php echo $this->lang->line('umb_out_time');?>" readonly name="jumat_waktu_pulang" type="text" value="">
                    </div>
                    <div class="col-md-2">
                      <button type="button" class="btn btn-primary clear-time" data-clear-id="5"><?php echo $this->lang->line('umb_clear');?></button>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="time" class="col-md-2"><?php echo $this->lang->line('umb_saturday');?></label>
                    <div class="col-md-4">
                      <input class="form-control timepicker clear-6" placeholder="<?php echo $this->lang->line('umb_in_time');?>" readonly name="sabtu_waktu_masuk" type="text" value="">
                    </div>
                    <div class="col-md-4">
                      <input class="form-control timepicker clear-6" placeholder="<?php echo $this->lang->line('umb_out_time');?>" readonly name="sabtu_waktu_pulang" type="text" value="">
                    </div>
                    <div class="col-md-2">
                      <button type="button" class="btn btn-primary clear-time" data-clear-id="6"><?php echo $this->lang->line('umb_clear');?></button>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="time" class="col-md-2"><?php echo $this->lang->line('umb_sunday');?></label>
                    <div class="col-md-4">
                      <input class="form-control timepicker clear-7" placeholder="<?php echo $this->lang->line('umb_in_time');?>" readonly name="minggu_waktu_masuk" type="text" value="">
                    </div>
                    <div class="col-md-4">
                      <input class="form-control timepicker clear-7" placeholder="<?php echo $this->lang->line('umb_out_time');?>" readonly name="minggu_waktu_pulang" type="text" value="">
                    </div>
                    <div class="col-md-2">
                      <button type="button" class="btn btn-primary clear-time" data-clear-id="7"><?php echo $this->lang->line('umb_clear');?></button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-actions box-footer">
                <button type="submit" class="btn btn-primary"> <i class="fas fa-check-square"></i> <?php echo $this->lang->line('umb_save');?> </button>
              </div>
            </div>
          </div>
          <?php echo form_close(); ?> </div>
        </div>
      </div>
    </div>
  <?php } ?>
  <div class="card <?php echo $get_animate;?>">
    <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_list_all');?></strong> <?php echo $this->lang->line('left_shift_kantor');?></span> </div>
    <div class="card-body">
      <div class="box-datatable table-responsive">
        <table class="datatables-demo table table-striped table-bordered" id="umb_table">
          <thead>
            <tr>
              <th width="60"><?php echo $this->lang->line('umb_option');?></th>
              <th><?php echo $this->lang->line('left_perusahaan');?></th>
              <th><?php echo $this->lang->line('umb_day');?></th>
              <th><?php echo $this->lang->line('umb_monday');?></th>
              <th><?php echo $this->lang->line('umb_tuesday');?></th>
              <th><?php echo $this->lang->line('umb_wednesday');?></th>
              <th><?php echo $this->lang->line('umb_thursday');?></th>
              <th><?php echo $this->lang->line('umb_friday');?></th>
              <th><?php echo $this->lang->line('umb_saturday');?></th>
              <th><?php echo $this->lang->line('umb_sunday');?></th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
