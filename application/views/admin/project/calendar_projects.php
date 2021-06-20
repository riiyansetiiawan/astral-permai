<?php $session = $this->session->userdata('username');?>
<?php $role_resources_ids = $this->Umb_model->user_role_resource(); ?>
<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('312',$role_resources_ids)) { ?>
      <li class="nav-item done"> <a href="<?php echo site_url('admin/project/dashboard_projects/');?>" data-link-data="<?php echo site_url('admin/project/dashboard_projects/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon ion ion-md-speedometer"></span> <?php echo $this->lang->line('dashboard_title');?>
      <div class="text-muted small"><?php echo $this->lang->line('umb_overview');?></div>
    </a> </li>
  <?php } ?>
  <?php if(in_array('44',$role_resources_ids)) { ?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/project/');?>" data-link-data="<?php echo site_url('admin/project/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon ion ion-logo-buffer"></span> <?php echo $this->lang->line('left_projects');?>
    <div class="text-muted small"><?php echo $this->lang->line('umb_role_add');?> <?php echo $this->lang->line('left_projects');?></div>
  </a> </li>
<?php } ?>
<?php if(in_array('119',$role_resources_ids)) { ?>
  <li class="nav-item done"> <a href="<?php echo site_url('admin/clients/');?>" data-link-data="<?php echo site_url('admin/clients/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon fas fa-user-check"></span> <?php echo $this->lang->line('umb_project_clients');?>
  <div class="text-muted small"><?php echo $this->lang->line('umb_role_add');?> <?php echo $this->lang->line('umb_project_clients');?></div>
</a> </li>
<?php } ?>
<?php if(in_array('94',$role_resources_ids)) { ?>
  <li class="nav-item done"> <a href="<?php echo site_url('admin/project/timelogs/');?>" data-link-data="<?php echo site_url('admin/project/timelogs/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon fas fa-user-clock"></span> <?php echo $this->lang->line('umb_project_timelogs');?>
  <div class="text-muted small"><?php echo $this->lang->line('umb_role_add');?> <?php echo $this->lang->line('umb_project_timelogs');?></div>
</a> </li>
<?php } ?>
<?php if(in_array('424',$role_resources_ids)) { ?>
  <li class="nav-item active"> <a href="<?php echo site_url('admin/project/calendar_projects/');?>" data-link-data="<?php echo site_url('admin/project/calendar_projects/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon fas fa-calendar-alt"></span> <?php echo $this->lang->line('umb_acc_calendar');?>
  <div class="text-muted small"><?php echo $this->lang->line('umb_view');?> <?php echo $this->lang->line('umb_acc_calendar');?></div>
</a> </li>
<?php } ?>
<?php if(in_array('425',$role_resources_ids)) { ?>
  <li class="nav-item done"> <a href="<?php echo site_url('admin/project/scrum_board_projects/');?>" data-link-data="<?php echo site_url('admin/project/scrum_board_projects/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon fas fa-clipboard-list"></span> <?php echo $this->lang->line('umb_projects_scrm_board');?>
  <div class="text-muted small"><?php echo $this->lang->line('umb_view');?> <?php echo $this->lang->line('umb_projects_scrm_board');?></div>
</a> </li>
<?php } ?>
</ul>
</div>
<hr class="border-light m-0 mb-3">
<div class="row">
  <div class="col-md-3">
    <div class="card">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_hr_calendar_options');?></strong></span> </div>
      <div class="list-group" id="list_group">
        <span class="list-group-item calendar-options text-green hrastral-drag-option" data-record="0"> <i class="ion ion-md-done-all text-success"></i> &nbsp; <?php echo $this->lang->line('umb_completed');?></span>
        <span class="list-group-item calendar-options text-aqua hrastral-drag-option" data-record="0"> <i class="ion ion-ios-list text-primary"></i> &nbsp; <?php echo $this->lang->line('umb_in_progress');?></span>
        <span class="list-group-item calendar-options text-purple hrastral-drag-option" data-record="0"> <i class="ion ion-md-football text-info"></i> &nbsp; <?php echo $this->lang->line('umb_not_started');?></span>
        <span class="list-group-item calendar-options text-red hrastral-drag-option" data-record="0"> <i class="ion ion-md-close-circle-outline text-danger"></i> &nbsp; <?php echo $this->lang->line('umb_project_cancelled');?></span>
        <span class="list-group-item calendar-options text-yellow hrastral-drag-option" data-record="0"> <i class="ion ion-md-flash-off text-warning"></i> &nbsp; <?php echo $this->lang->line('umb_project_hold');?></span>
      </div>  
      <div class="card-body">
        <?php $attributes = array('name' => 'hr_calendar_option', 'id' => 'umb-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open('', $attributes, $hidden);?>
        <input type="hidden" id="exact_date" value="" />
        <div class="form-body">
          <div class="form-group">
            <label for="set_date"><?php echo $this->lang->line('umb_set_date');?></label>
            <input class="form-control set_date" placeholder="<?php echo $this->lang->line('umb_select_date');?>" readonly id="set_date" name="set_date" type="text" value="<?php if(isset($_POST['set_date'])){ echo $_POST['set_date']; } else { echo date('Y-m-d'); }?>">
          </div>
        </div>
        <div class="form-actions right">
          <button type="submit" class="btn btn-primary save"><?php echo $this->lang->line('umb_get');?></button>
        </div>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
  <div class="col-md-9">
    <div class="card">
      <div class="card-body">
        <div id='calendar_hr'></div>
      </div>
    </div>
  </div>
</div>