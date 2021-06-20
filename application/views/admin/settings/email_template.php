<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>
<div id="smarsdstwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/settings/');?>" data-link-data="<?php echo site_url('admin/settings/');?>" class="mb-3 nav-link hrastral-link"><span class="sw-icon fas fa-cog"></span> <?php echo $this->lang->line('umb_system');?>
    <div class="text-muted small"><?php echo $this->lang->line('header_configuration');?></div>
  </a> </li>
  <li class="nav-item clickable"> <a href="<?php echo site_url('admin/settings/constants/');?>" data-link-data="<?php echo site_url('admin/settings/constants/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon fas fa-adjust"></span> <?php echo $this->lang->line('left_constants');?>
  <div class="text-muted small"><?php echo $this->lang->line('umb_set_up_all_types');?></div>
</a> </li>
<li class="nav-item clickable"> <a href="<?php echo site_url('admin/settings/modules/');?>" data-link-data="<?php echo site_url('admin/settings/modules/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon fas fa-life-ring"></span> <?php echo $this->lang->line('umb_setup_modules');?>
<div class="text-muted small"><?php echo $this->lang->line('umb_enable_disable_modules');?></div>
</a> </li>
<li class="nav-item clickable"> <a href="<?php echo site_url('admin/settings/database_backup/');?>" data-link-data="<?php echo site_url('admin/settings/database_backup/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon fa fa-database"></span> <?php echo $this->lang->line('header_db_log');?>
<div class="text-muted small"><?php echo $this->lang->line('umb_database_backup_restore');?></div>
</a> </li>
<li class="nav-item active"> <a href="<?php echo site_url('admin/settings/email_template/');?>" data-link-data="<?php echo site_url('admin/settings/email_template/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon fas fa-envelope"></span> <?php echo $this->lang->line('left_email_templates');?>
<div class="text-muted small"><?php echo $this->lang->line('umb_set_up');?> <?php echo $this->lang->line('left_email_templates');?></div>
</a> </li>
</ul>
</div>   
<hr class="border-light m-0">
<div class="card <?php echo $get_animate;?> mt-3">
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_list_all');?></strong> <?php echo $this->lang->line('left_email_templates');?></span> </div>
  <div class="card-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="umb_table">
        <thead>
          <tr>
            <th><?php echo $this->lang->line('umb_action');?></th>
            <th><?php echo $this->lang->line('dashboard_umb_status');?></th>
            <th><?php echo $this->lang->line('umb_template_name');?></th>
            <th><?php echo $this->lang->line('umb_subject');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
