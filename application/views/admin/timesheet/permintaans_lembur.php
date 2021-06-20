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
  <li class="nav-item active"> <a href="<?php echo site_url('admin/permintaan_lembur/');?>" data-link-data="<?php echo site_url('admin/permintaan_lembur/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon ion ion-md-timer"></span> <?php echo $this->lang->line('umb_permintaan_lembur');?>
  <div class="text-muted small"><?php echo $this->lang->line('umb_role_add');?> <?php echo $this->lang->line('umb_permintaan_lembur');?></div>
</a> </li>
<?php } ?>
</ul>
</div>
<hr class="border-light m-0 mb-3">
<div class="row m-b-1 <?php echo $get_animate;?>">
  <div class="col-md-12">
    <div class="card mb-4">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_permintaan_lembur');?></strong></span>
        <div class="card-header-elements ml-md-auto"> 
          <button type="button" class="btn btn-xs btn-primary" id="add_kehadiran_btn" data-toggle="modal" data-target=".add-modal-data"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('umb_add_new');?></button>
        </div>
      </div>
      <div class="card-body">
        <div class="box-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="umb_table">
            <thead>
              <tr>
                <th><?php echo $this->lang->line('umb_action');?></th>
                <th><?php echo $this->lang->line('umb_karyawan');?></th>
                <th><?php echo $this->lang->line('umb_no_project');?></th>
                <th><?php echo $this->lang->line('umb_phase_no');?></th>
                <th><?php echo $this->lang->line('umb_e_details_tanggal');?></th>
                <th><?php echo $this->lang->line('umb_in_time');?></th>
                <th><?php echo $this->lang->line('umb_out_time');?></th>
                <th><?php echo $this->lang->line('umb_lembur_thours');?></th>
                <th><?php echo $this->lang->line('dashboard_umb_status');?></th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
