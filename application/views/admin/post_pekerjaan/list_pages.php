<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>
<?php $role_resources_ids = $this->Umb_model->user_role_resource(); ?>
<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('49',$role_resources_ids)) { ?>
      <li class="nav-item done"> 
        <a href="<?php echo site_url('admin/post_pekerjaan/');?>" data-link-data="<?php echo site_url('admin/post_pekerjaan/');?>" class="mb-3 nav-link hrastral-link"> 
          <span class="sw-icon fas fa-newspaper"></span> 
          <?php echo $this->lang->line('left_post_pekerjaan');?>
          <div class="text-muted small"><?php echo $this->lang->line('umb_role_create');?> <?php echo $this->lang->line('header_frontend_apply_pekerjaans');?></div>
        </a> 
      </li>
    <?php } ?>  
    <?php if(in_array('51',$role_resources_ids)) { ?>
      <li class="nav-item done"> 
        <a href="<?php echo site_url('admin/kandidats_pekerjaan/');?>" data-link-data="<?php echo site_url('admin/kandidats_pekerjaan/');?>" class="mb-3 nav-link hrastral-link"> 
          <span class="sw-icon fas fa-user-friends"></span> 
          <?php echo $this->lang->line('left_kandidats_pekerjaan');?>
          <div class="text-muted small"><?php echo $this->lang->line('umb_view');?> <?php echo $this->lang->line('left_kandidats_pekerjaan');?></div>
        </a> 
      </li>
    <?php } ?>  
    <?php if(in_array('52',$role_resources_ids)) { ?>
      <li class="nav-item done"> 
        <a href="<?php echo site_url('admin/post_pekerjaan/employer/');?>" data-link-data="<?php echo site_url('admin/post_pekerjaan/employer/');?>" class="mb-3 nav-link hrastral-link"> 
          <span class="sw-icon fas fa-user-ninja"></span> 
          <?php echo $this->lang->line('umb_employer_pekerjaans');?>
          <div class="text-muted small"><?php echo $this->lang->line('umb_role_add');?> <?php echo $this->lang->line('umb_employer_pekerjaans');?></div>
        </a> 
      </li>
    <?php } ?>  
    <?php if(in_array('296',$role_resources_ids)) { ?>
      <li class="nav-item active"> 
        <a href="<?php echo site_url('admin/post_pekerjaan/pages/');?>" data-link-data="<?php echo site_url('admin/post_pekerjaan/pages/');?>" class="mb-3 nav-link hrastral-link"> 
          <span class="sw-icon ion ion-ios-paper"></span> 
          <?php echo $this->lang->line('umb_cms_pages_pekerjaans');?>
          <div class="text-muted small"><?php echo $this->lang->line('umb_update');?> <?php echo $this->lang->line('umb_cms_pages_pekerjaans');?></div>
        </a> 
      </li>
    <?php } ?> 
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<div class="card <?php echo $get_animate;?>">
  <div class="card-header with-elements"> 
    <span class="card-header-title mr-2">
      <strong><?php echo $this->lang->line('umb_list_all');?></strong> 
      <?php echo $this->lang->line('umb_cms_pages_pekerjaans');?>
    </span> 
  </div>
  <div class="card-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="umb_table">
        <thead>
          <tr>
            <th><?php echo $this->lang->line('umb_action');?></th>
            <th><?php echo $this->lang->line('dashboard_umb_title');?></th>
            <th><?php echo $this->lang->line('umb_pekerjaans_page_url');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
