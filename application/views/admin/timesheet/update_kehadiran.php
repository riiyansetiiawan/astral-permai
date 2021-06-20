<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>
<?php $user_info = $this->Umb_model->read_user_info($session['user_id']);?>
<?php $role_resources_ids = $this->Umb_model->user_role_resource(); ?>

<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('423',$role_resources_ids)) { ?>
      <li class="nav-item clickable"> <a href="<?php echo site_url('admin/timesheet/dashboard_kehadiran/');?>" data-link-data="<?php echo site_url('admin/timesheet/dashboard_kehadiran/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon ion ion-md-speedometer"></span> <?php echo $this->lang->line('dashboard_title');?>
      <div class="text-muted small"><?php echo $this->lang->line('hr_title_dashboard_timesheet');?></div>
    </a> </li>
  <?php } ?>
  <?php if(in_array('28',$role_resources_ids)) { ?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/timesheet/kehadiran/');?>" data-link-data="<?php echo site_url('admin/timesheet/kehadiran/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon ion ion-md-clock"></span> <?php echo $this->lang->line('left_kehadiran');?>
    <div class="text-muted small"><?php echo $this->lang->line('left_kehadiran');?> <?php echo $this->lang->line('umb_list_role');?></div>
  </a> </li>
<?php } ?>
<?php if(in_array('30',$role_resources_ids)) { ?>
  <li class="nav-item active"> <a href="<?php echo site_url('admin/timesheet/update_kehadiran');?>" data-link-data="<?php echo site_url('admin/timesheet/update_kehadiran');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon fas fa-pencil-alt"></span> <?php echo $this->lang->line('left_update_kehadiran');?>
  <div class="text-muted small"><?php echo $this->lang->line('umb_add_edit_info');?> <?php echo $this->lang->line('left_kehadiran');?></div>
</a> </li>
<?php } ?>
<?php if(in_array('10',$role_resources_ids)) { ?>
  <li class="nav-item clickable"> <a href="<?php echo site_url('admin/timesheet/');?>" data-link-data="<?php echo site_url('admin/timesheet/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon fas fa-calendar-alt"></span> <?php echo $this->lang->line('umb_month_timesheet_title');?>
  <div class="text-muted small"><?php echo $this->lang->line('umb_view_all');?></div>
</a> </li>
<?php } ?>
<?php if(in_array('261',$role_resources_ids)) { ?>
  <li class="nav-item clickable"> <a href="<?php echo site_url('admin/timesheet/timecalendar/');?>" data-link-data="<?php echo site_url('admin/timesheet/timecalendar/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon ion ion-md-calendar"></span> <?php echo $this->lang->line('umb_acc_calendar');?>
  <div class="text-muted small"><?php echo $this->lang->line('umb_view');?> <?php echo $this->lang->line('umb_acc_calendar');?></div>
</a> </li>
<?php } ?>
<?php if(in_array('401',$role_resources_ids)) { ?>
  <li class="nav-item clickable"> <a href="<?php echo site_url('admin/permintaan_lembur/');?>" data-link-data="<?php echo site_url('admin/permintaan_lembur/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon ion ion-md-timer"></span> <?php echo $this->lang->line('umb_permintaan_lembur');?>
  <div class="text-muted small"><?php echo $this->lang->line('umb_role_add');?> <?php echo $this->lang->line('umb_permintaan_lembur');?></div>
</a> </li>
<?php } ?>
</ul>
</div>
<hr class="border-light m-0 mb-3">
<div class="row m-b-1">
  <div class="col-md-4">
    <div class="card">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('left_update_kehadiran');?></strong></span> </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-12">
            <?php $attributes = array('name' => 'update_kehadiran_report', 'id' => 'update_kehadiran_report', 'autocomplete' => 'off');?>
            <?php $hidden = array('user_id' => $session['user_id']);?>
            <?php echo form_open('admin/timesheet/update_kehadiran', $attributes, $hidden);?>
            <?php
            $data = array(
              'name'        => 'krywn_id',
              'id'          => 'krywn_id',
              'value'       => $session['user_id'],
              'type'   		=> 'hidden',
              'class'       => 'form-control',
            );
            
            echo form_input($data);
            ?>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="date"><?php echo $this->lang->line('umb_e_details_tanggal');?></label>
                  <input class="form-control date" placeholder="<?php echo $this->lang->line('umb_e_details_tanggal');?>" readonly id="tanggal_kehadiran" name="tanggal_kehadiran" type="text" value="<?php echo date('Y-m-d');?>">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <?php if($user_info[0]->user_role_id==1){ ?>
                  <div class="form-group">
                    <label for="first_name"><?php echo $this->lang->line('left_perusahaan');?></label>
                    <select class="form-control" name="perusahaan_id" id="aj_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_perusahaan');?>" required>
                      <option value=""></option>
                      <?php foreach($get_all_perusahaans as $perusahaan) {?>
                        <option value="<?php echo $perusahaan->perusahaan_id?>"><?php echo $perusahaan->name?></option>
                      <?php } ?>
                    </select>
                  </div>
                <?php } else if(in_array('310',$role_resources_ids)) {?>
                  <?php $eperusahaan_id = $user_info[0]->perusahaan_id;?>
                  <div class="form-group">
                    <label for="first_name"><?php echo $this->lang->line('left_perusahaan');?></label>
                    <select class="form-control" name="perusahaan_id" id="aj_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_perusahaan');?>" required>
                      <option value=""></option>
                      <?php foreach($get_all_perusahaans as $perusahaan) {?>
                        <?php if($eperusahaan_id == $perusahaan->perusahaan_id):?>
                          <option value="<?php echo $perusahaan->perusahaan_id?>"><?php echo $perusahaan->name?></option>
                        <?php endif;?>
                      <?php } ?>
                    </select>
                  </div>
                <?php } ?>
                <?php if($user_info[0]->user_role_id==1 || in_array('310',$role_resources_ids)){ ?>
                  <div class="form-group" id="ajax_karyawan">
                    <label for="karyawan"><?php echo $this->lang->line('umb_karyawan');?></label>
                    <select disabled="disabled" name="karyawan_id" id="up_karyawan_id" class="form-control karyawan-data" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_choose_an_karyawan');?>" required>
                    </select>
                  </div>
                <?php } else {?>
                  <input type="hidden" name="karyawan_id" id="up_karyawan_id" value="<?php echo $session['user_id'];?>" />
                <?php }?>
                <div class="form-actions box-footer">
                  <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('umb_get');?> </button>
                </div>
              </div>
            </div>
            <?php echo form_close(); ?> </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-8">
      <div class="card mb-4">
        <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('left_update_kehadiran');?></strong></span>
          <div class="card-header-elements ml-md-auto">
            <?php $role_resources_ids = $this->Umb_model->user_role_resource(); ?>
            <?php if(in_array('277',$role_resources_ids)) {?>
              <button type="button" class="btn btn-xs btn-primary" id="add_kehadiran_btn" data-toggle="modal" style="display:none;" data-target=".add-modal-data"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('umb_add_new');?></button>
            <?php } else {?>
              <span id="add_kehadiran_btn" style="display:none;">&nbsp;</span>
            <?php } ?>
          </div>
        </div>
        <div class="card-body">
          <div class="box-datatable table-responsive">
            <table class="datatables-demo table table-striped table-bordered" id="umb_table">
              <thead>
                <tr>
                  <th><?php echo $this->lang->line('umb_action');?></th>
                  <th><?php echo $this->lang->line('umb_in_time');?></th>
                  <th><?php echo $this->lang->line('umb_out_time');?></th>
                  <th><?php echo $this->lang->line('dashboard_total_kerja');?></th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
