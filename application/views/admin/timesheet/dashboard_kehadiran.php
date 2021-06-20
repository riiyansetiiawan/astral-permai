<?php
$session = $this->session->userdata('username');
$system = $this->Umb_model->read_setting_info(1);
$info_perusahaan = $this->Umb_model->read_info_setting_perusahaan(1);
$user = $this->Umb_model->read_info_karyawan($session['user_id']);
$theme = $this->Umb_model->read_theme_info(1);
?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>
<?php $role_resources_ids = $this->Umb_model->user_role_resource(); ?>

<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('423',$role_resources_ids)) { ?>
    <li class="nav-item active"> <a href="<?php echo site_url('admin/timesheet/dashboard_kehadiran/');?>" data-link-data="<?php echo site_url('admin/timesheet/dashboard_kehadiran/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon ion ion-md-speedometer"></span> <?php echo $this->lang->line('dashboard_title');?>
      <div class="text-muted small"><?php echo $this->lang->line('hr_title_dashboard_timesheet');?></div>
      </a> </li>
      <?php } ?>
    <?php if(in_array('28',$role_resources_ids)) { ?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/timesheet/kehadiran/');?>" data-link-data="<?php echo site_url('admin/timesheet/kehadiran/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon ion ion-md-clock"></span> <?php echo $this->lang->line('left_kehadiran');?>
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
<?php if(in_array('28',$role_resources_ids) || in_array('401',$role_resources_ids)) { ?>
<hr class="border-light m-0 mb-3">
<div class="row">
<?php if(in_array('28',$role_resources_ids)) { ?>
  <div class="col-md-6">
    <div class="card mb-4">
      <h6 class="card-header with-elements border-0 pr-0 pb-0">
        <div class="card-header-title">kehadiran Status</div>
      </h6>
      <div class="row">
        <div class="col-md-6">
          <div class="overflow-scrolls py-4 px-3" style="overflow:auto; height:200px;">
            <div class="table-responsive">
              <table class="table mb-0 table-dashboard">
                <tbody>
                  <tr>
                    <td style="vertical-align: inherit;"><div style="width:4px;border:5px solid #d9534f;"></div></td>
                    <td><?php echo $this->lang->line('umb_absent');?></td>
                  </tr>
                  <tr>
                    <td style="vertical-align: inherit;"><div style="width:4px;border:5px solid #009688;"></div></td>
                    <td><?php echo $this->lang->line('umb_krywn_bekerja');?></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-md-5">
          <div style="height:120px;">
            <canvas id="status_kehadiran"  style="display: block; height: 150px; width:300px;"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php } ?>
  <?php if(in_array('401',$role_resources_ids)) { ?>
  <div class="col-md-6">
    <div class="card mb-4">
      <h6 class="card-header with-elements border-0 pr-0 pb-0">
        <div class="card-header-title">lembur Request Status</div>
      </h6>
      <div class="row">
        <div class="col-md-6">
          <div class="overflow-scrolls py-4 px-3" style="overflow:auto; height:200px;">
            <div class="table-responsive">
              <table class="table mb-0 table-dashboard">
                <tbody>
                  <tr>
                    <td style="vertical-align: inherit;"><div style="width:4px;border:5px solid #009688;"></div></td>
                    <td><?php echo $this->lang->line('umb_approved');?></td>
                  </tr>
                  <tr>
                    <td style="vertical-align: inherit;"><div style="width:4px;border:5px solid #FFD950;"></div></td>
                    <td><?php echo $this->lang->line('umb_pending');?></td>
                  </tr>
                  <tr>
                    <td style="vertical-align: inherit;"><div style="width:4px;border:5px solid #d9534f;"></div></td>
                    <td><?php echo $this->lang->line('umb_rejected');?></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-md-5">
          <div style="height:120px;">
            <canvas id="hrastral_permintaan_lembur" style="display: block; height: 150px; width:300px;"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php } ?>
</div>
<?php } ?>