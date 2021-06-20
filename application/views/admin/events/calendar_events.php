<?php $system = $this->Umb_model->read_setting_info(1); ?>
<?php $role_resources_ids = $this->Umb_model->user_role_resource(); ?>
<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php  if(in_array('98',$role_resources_ids)) {?>
    <li class="nav-item done">
      <a href="<?php echo site_url('admin/events/');?>" data-link-data="<?php echo site_url('admin/events/');?>" class="mb-3 nav-link hrastral-link">
        <span class="sw-icon fas fa-calendar-alt"></span>
        <?php echo $this->lang->line('umb_hr_events');?>
        <div class="text-muted small"><?php echo $this->lang->line('umb_set_up');?> <?php echo $this->lang->line('umb_hr_events');?></div>
      </a>
    </li>
    <?php } ?>
    <?php  if(in_array('98',$role_resources_ids)) {?>
    <li class="nav-item active">
      <a href="<?php echo site_url('admin/events/calendar');?>" data-link-data="<?php echo site_url('admin/events/');?>" class="mb-3 nav-link hrastral-link">
        <span class="sw-icon fas fa-calendar-check"></span>
        <?php echo $this->lang->line('umb_hrastral_calendar_events');?>
        <div class="text-muted small"><?php echo $this->lang->line('umb_view');?> <?php echo $this->lang->line('umb_hrastral_calendar_events');?></div>
      </a>
    </li>
    <?php } ?>
    <?php  if(in_array('99',$role_resources_ids)) {?>
    <li class="nav-item done">
      <a href="<?php echo site_url('admin/meetings/');?>" data-link-data="<?php echo site_url('admin/meetings/');?>" class="mb-3 nav-link hrastral-link">
        <span class="sw-icon fas fa-users"></span>
        <?php echo $this->lang->line('umb_hr_meetings');?>
        <div class="text-muted small"><?php echo $this->lang->line('umb_set_up');?> <?php echo $this->lang->line('umb_hr_meetings');?></div>
      </a>
    </li>
    <?php } ?>
    <?php  if(in_array('99',$role_resources_ids)) {?>
    <li class="nav-item done">
      <a href="<?php echo site_url('admin/meetings/calendar');?>" data-link-data="<?php echo site_url('admin/events/');?>" class="mb-3 nav-link hrastral-link">
        <span class="sw-icon far fa-calendar-check"></span>
        <?php echo $this->lang->line('umb_hrastral_calendar_meetings');?>
        <div class="text-muted small"><?php echo $this->lang->line('umb_view');?> <?php echo $this->lang->line('umb_hrastral_calendar_meetings');?></div>
      </a>
    </li>
   <?php } ?> 
  </ul>
 </div>
<hr class="border-light m-0 mb-3">
<div class="card">
  <div class="card-body">
    <div class="card-block">
      <div class="row">
        <div class="col-md-12">
          <div id='calendar_hr'></div>
        </div>
      </div>
    </div>
  </div>
</div>
