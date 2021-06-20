<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>
<?php $role_resources_ids = $this->Umb_model->user_role_resource();?>
<?php $user_info = $this->Umb_model->read_user_info($session['user_id']);?>

<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('423',$role_resources_ids)) { ?>
      <li class="nav-item clickable"> <a href="<?php echo site_url('admin/timesheet/dashboard_kehadiran/');?>" data-link-data="<?php echo site_url('admin/timesheet/dashboard_kehadiran/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon ion ion-md-speedometer"></span> <?php echo $this->lang->line('dashboard_title');?>
      <div class="text-muted small"><?php echo $this->lang->line('hr_title_dashboard_timesheet');?></div>
    </a> </li>
  <?php } ?>
  <?php if(in_array('28',$role_resources_ids)) { ?>
    <li class="nav-item active"> <a href="<?php echo site_url('admin/timesheet/kehadiran/');?>" data-link-data="<?php echo site_url('admin/timesheet/kehadiran/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon ion ion-md-clock"></span> <?php echo $this->lang->line('left_kehadiran');?>
    <div class="text-muted small"><?php echo $this->lang->line('left_kehadiran');?> <?php echo $this->lang->line('umb_list_role');?></div>
  </a> </li>
<?php } ?>
<?php if(in_array('30',$role_resources_ids)) { ?>
  <li class="nav-item clickable"> <a href="<?php echo site_url('admin/timesheet/update_kehadiran');?>" data-link-data="<?php echo site_url('admin/timesheet/update_kehadiran');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon fas fa-pencil-alt"></span> <?php echo $this->lang->line('left_update_kehadiran');?>
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
<div class="ui-bordered px-4 pt-4 mb-4">
  <?php $attributes = array('name' => 'kehadiran_daily_report', 'id' => 'kehadiran_daily_report', 'autocomplete' => 'off', 'class' => 'add form-hrm');?>
  <?php $hidden = array('user_id' => $session['user_id']);?>
  <?php echo form_open('admin/timesheet/list_kehadiran', $attributes, $hidden);?>
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
    <?php if($user_info[0]->user_role_id==1){ ?>
      <div class="col-md mb-4">
        <label class="form-label"><?php echo $this->lang->line('left_location');?></label>
        <select name="location_id" id="location_id" class="form-control custom-select" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_location');?>">
          <option value="0"><?php echo $this->lang->line('umb_acc_all');?></option>
          <?php foreach($all_shifts_kantor as $elocation) {?>
            <option value="<?php echo $elocation->location_id?>"><?php echo $elocation->nama_location?></option>
          <?php } ?>
        </select>
      </div>
    <?php } else {?>
      <input type="hidden" value="0" name="location_id" id="location_id" />
    <?php } ?>
    <div class="col-md mb-4">
      <label class="form-label"><?php echo $this->lang->line('umb_e_details_tanggal');?></label>
      <input class="form-control date" placeholder="<?php echo $this->lang->line('umb_select_date');?>" readonly id="tanggal_kehadiran" name="tanggal_kehadiran" type="text" value="<?php echo date('Y-m-d');?>">
    </div>
    <div class="col-md col-xl-2 mb-4">
      <label class="form-label d-none d-md-block">&nbsp;</label>
      <button type="submit" class="btn btn-secondary btn-block save"><?php echo $this->lang->line('umb_get');?></button>
    </div>
  </div>
  <?php echo form_close(); ?> </div>
  <?php if(in_array('29',$role_resources_ids)) { ?>
    <div id="tanggal_bijaksana_kehadiran" class="collapse add-formd <?php echo $get_animate;?>" data-parent="#accordion" style="">
      <div class="ui-bordered px-4 pt-4 mb-4">
        <?php $attributes = array('name' => 'laporan_tanggalbijaksana_kehadiran', 'id' => 'laporan_tanggalbijaksana_kehadiran', 'autocomplete' => 'off', 'class' => 'add form-hrm');?>
        <?php $hidden = array('euser_id' => $session['user_id']);?>
        <?php echo form_open('admin/timesheet/list_tanggalbijaksana_kehadiran', $attributes, $hidden);?>
        <?php
        $data = array(
          'type'        => 'hidden',
          'name'        => 'user_id',
          'id'          => 'user_id',
          'value'       => $session['user_id'],
          'class'       => 'form-control',
        );
        echo form_input($data);
        ?>
        <div class="form-row">
          <div class="col-md mb-4">
            <label class="form-label"><?php echo $this->lang->line('umb_start_date');?></label>
            <input class="form-control date" placeholder="<?php echo $this->lang->line('umb_select_date');?>" readonly id="start_date" name="start_date" type="text" value="<?php echo date('Y-m-d');?>">
          </div>
          <div class="col-md mb-4">
            <label class="form-label"><?php echo $this->lang->line('umb_end_date');?></label>
            <input class="form-control date" placeholder="<?php echo $this->lang->line('umb_select_date');?>" readonly id="end_date" name="end_date" type="text" value="<?php echo date('Y-m-d');?>">
          </div>
          <?php if(!in_array('381',$role_resources_ids) && $user[0]->user_role_id!=1) {?>
            <div class="col-md col-xl-2 mb-4">
              <label class="form-label d-none d-md-block">&nbsp;</label>
              <button type="submit" class="btn btn-secondary btn-block"><?php echo $this->lang->line('umb_get');?></button>
            </div>
          <?php } ?>
          <?php if($user_info[0]->user_role_id==1 || in_array('381',$role_resources_ids)) {?>
            <div class="col-md mb-4">
              <?php if($user_info[0]->user_role_id==1){?>
                <label class="form-label"><?php echo $this->lang->line('left_perusahaan');?></label>
                <select class="form-control custom-select" name="perusahaan_id" id="aj_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_perusahaan');?>">
                  <option value=""></option>
                  <?php foreach($get_all_perusahaans as $perusahaan) {?>
                    <option value="<?php echo $perusahaan->perusahaan_id?>"><?php echo $perusahaan->name?></option>
                  <?php } ?>
                </select>
              <?php } else {?>
                <label class="form-label"><?php echo $this->lang->line('left_perusahaan');?></label>
                <select class="form-control custom-select" name="perusahaan_id" id="aj_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_perusahaan');?>">
                  <option value=""></option>
                  <?php foreach($get_all_perusahaans as $perusahaan) {?>
                    <?php if($user_info[0]->perusahaan_id == $perusahaan->perusahaan_id):?>
                      <option value="<?php echo $perusahaan->perusahaan_id?>"><?php echo $perusahaan->name?></option>
                    <?php endif;?>
                  <?php } ?>
                </select>
              <?php } ?>
            </div>
            <div class="col-md mb-3" id="ajax_karyawan">
              <label class="form-label"><?php echo $this->lang->line('umb_karyawan');?></label>
              <select name="karyawan_id" id="karyawan_id" class="form-control custom-select" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_choose_an_karyawan');?>" required>
                <option value="">All</option>
              </select>
            </div>
            <div class="col-md col-xl-2 mb-4">
              <label class="form-label d-none d-md-block">&nbsp;</label>
              <button type="submit" class="btn btn-secondary btn-block"><?php echo $this->lang->line('umb_get');?></button>
            </div>
          <?php } ?>
        </div>
        <?php echo form_close(); ?> </div>
      </div>
    <?php } ?>
    <div class="card">
      <div id="accordion">
        <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_daily_kehadiran_report');?></strong></span>
          <?php if(in_array('29',$role_resources_ids)) { ?>
            <div class="card-header-elements ml-md-auto"> <a class="text-dark collapsed" data-toggle="collapse" href="#tanggal_bijaksana_kehadiran" aria-expanded="false">
              <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('left_tanggal_bijaksana_kehadiran');?></button>
            </a> </div>
          <?php } ?>
        </div>
      </div>
      <div class="card-body">
        <div class="box-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="umb_table">
            <thead>
              <tr>
                <th colspan="3"><?php echo $this->lang->line('umb_hr_info');?></th>
                <th colspan="9"><?php echo $this->lang->line('umb_kehadiran_report');?></th>
              </tr>
              <tr>
                <th style="width:120px;"><?php echo $this->lang->line('umb_karyawan');?></th>
                <th style="width:120px;"><?php echo $this->lang->line('dashboard_karyawan_id');?></th>
                <th style="width:100px;"><?php echo $this->lang->line('left_perusahaan');?></th>
                <th style="width:100px;"><?php echo $this->lang->line('umb_e_details_tanggal');?></th>
                <th style="width:100px;"><?php echo $this->lang->line('dashboard_umb_status');?></th>
                <th style="width:100px;"><?php echo $this->lang->line('dashboard_clock_in');?></th>
                <th style="width:100px;"><?php echo $this->lang->line('dashboard_clock_out');?></th>
                <th style="width:100px;"><?php echo $this->lang->line('dashboard_late');?></th>
                <th style="width:100px;"><?php echo $this->lang->line('dashboard_early_leaving');?></th>
                <th style="width:100px;"><?php echo $this->lang->line('dashboard_lembur');?></th>
                <th style="width:100px;"><?php echo $this->lang->line('dashboard_total_kerja');?></th>
                <th style="width:100px;"><?php echo $this->lang->line('dashboard_total_istirahat');?></th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>