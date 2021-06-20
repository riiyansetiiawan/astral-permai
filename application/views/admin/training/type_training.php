<?php
/* Training Type view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>
<?php $role_resources_ids = $this->Umb_model->user_role_resource(); ?>

<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php  if(in_array('54',$role_resources_ids)) {?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/training/');?>" data-link-data="<?php echo site_url('admin/training/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon fas fa-portrait"></span> <?php echo $this->lang->line('left_training');?>
      <div class="text-muted small"><?php echo $this->lang->line('umb_set_up');?> <?php echo $this->lang->line('left_training');?></div>
      </a> </li>
    <?php } ?>  
    <?php  if(in_array('56',$role_resources_ids)) {?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/trainers/');?>" data-link-data="<?php echo site_url('admin/trainers/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon fas fa-user-graduate"></span> <?php echo $this->lang->line('left_list_trainers');?>
      <div class="text-muted small"><?php echo $this->lang->line('umb_role_add');?> <?php echo $this->lang->line('left_list_trainers');?></div>
      </a> </li>
    <?php } ?>  
    <?php  if(in_array('55',$role_resources_ids)) {?>
    <li class="nav-item active"> <a href="<?php echo site_url('admin/type_training/');?>" data-link-data="<?php echo site_url('admin/type_training/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon fab fa-typo3"></span> <?php echo $this->lang->line('left_type_training');?>
      <div class="text-muted small"><?php echo $this->lang->line('umb_role_add');?> <?php echo $this->lang->line('left_type_training');?></div>
      </a> </li>
    <?php } ?>  
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<div class="row m-b-1 <?php echo $get_animate;?>">
  <?php if(in_array('345',$role_resources_ids)) {?>
  <div class="col-md-4">
    <div class="card">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_add_new');?></strong> <?php echo $this->lang->line('umb_type');?></span> </div>
      <div class="card-body">
        <?php $attributes = array('name' => 'add_type', 'id' => 'umb-form', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open('admin/type_training/add_type', $attributes, $hidden);?>
        <div class="form-group">
          <label for="type_name"><?php echo $this->lang->line('left_type_training');?></label>
          <input type="text" class="form-control" name="type_name" placeholder="<?php echo $this->lang->line('left_type_training');?>">
        </div>
        <div class="form-actions box-footer">
          <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('umb_save');?> </button>
        </div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
  <?php $colmdval = 'col-md-8';?>
  <?php } else {?>
  <?php $colmdval = 'col-md-12';?>
  <?php } ?>
  <div class="<?php echo $colmdval;?>">
    <div class="card">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_list_all');?></strong> <?php echo $this->lang->line('umb_types_training');?></span> </div>
      <div class="card-body">
        <div class="box-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="umb_table">
            <thead>
              <tr>
                <th><?php echo $this->lang->line('umb_action');?></th>
                <th><?php echo $this->lang->line('umb_type');?></th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
