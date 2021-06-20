<?php
/* Departments view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>
<?php $role_resources_ids = $this->Umb_model->user_role_resource(); ?>
<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('5',$role_resources_ids)) { ?>
      <li class="nav-item clickable"> <a href="<?php echo site_url('admin/perusahaan/');?>" data-link-data="<?php echo site_url('admin/perusahaan/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon ion ion-md-business"></span> <?php echo $this->lang->line('left_perusahaan');?>
      <div class="text-muted small"><?php echo $this->lang->line('umb_set_up');?> <?php echo $this->lang->line('umb_perusahaans');?></div>
    </a> </li>
  <?php } ?>
  <?php if(in_array('6',$role_resources_ids)) { ?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/location/');?>" data-link-data="<?php echo site_url('admin/location/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon fas fa-location-arrow"></span> <?php echo $this->lang->line('left_location');?>
    <div class="text-muted small"><?php echo $this->lang->line('umb_set_up');?> <?php echo $this->lang->line('umb_locations');?></div>
  </a> </li>
<?php } ?>
<?php if(in_array('3',$role_resources_ids)) { ?>
  <li class="nav-item active"> <a href="<?php echo site_url('admin/department/');?>" data-link-data="<?php echo site_url('admin/department/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon fab fa-codepen"></span> <?php echo $this->lang->line('left_department');?>
  <div class="text-muted small"><?php echo $this->lang->line('umb_add_new');?> <?php echo $this->lang->line('left_department');?></div>
</a> </li>
<?php } ?>
<?php if(in_array('4',$role_resources_ids)) { ?>
  <li class="nav-item clickable"> <a href="<?php echo site_url('admin/penunjukan/');?>" data-link-data="<?php echo site_url('admin/penunjukan/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon fab fa-dev"></span> <?php echo $this->lang->line('left_penunjukan');?>
  <div class="text-muted small"><?php echo $this->lang->line('umb_add_new');?> <?php echo $this->lang->line('left_penunjukan');?></div>
</a> </li>
<?php } ?>
<?php if(in_array('11',$role_resources_ids)) { ?>
  <li class="nav-item clickable"> <a href="<?php echo site_url('admin/pengumuman/');?>" data-link-data="<?php echo site_url('admin/pengumuman/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon ion ion-md-megaphone"></span> <?php echo $this->lang->line('left_pengumumans');?>
  <div class="text-muted small"><?php echo $this->lang->line('umb_set_up');?> <?php echo $this->lang->line('left_pengumumans');?></div>
</a> </li>
<?php } ?>    
<?php if(in_array('9',$role_resources_ids)) { ?>
 <li class="nav-item clickable"> <a href="<?php echo site_url('admin/kebijakan/');?>" data-link-data="<?php echo site_url('admin/kebijakan/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon fab fa-yelp"></span> <?php echo $this->lang->line('left_kebijakans');?>
 <div class="text-muted small"><?php echo $this->lang->line('umb_set_up');?> <?php echo $this->lang->line('header_kebijakans');?></div>
</a> </li>
<?php } ?>
</ul>
</div>
<hr class="border-light m-0 mb-3">
<div class="row m-b-1 <?php echo $get_animate;?>">
  <?php $role_resources_ids = $this->Umb_model->user_role_resource(); ?>
  <?php if(in_array('240',$role_resources_ids)) {?>
    <div class="col-md-4">
      <div class="card">
        <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_add_new');?></strong> <?php echo $this->lang->line('umb_department');?></span>
        </div>
        <div class="card-body">
          <?php $attributes = array('name' => 'add_department', 'id' => 'umb-form', 'autocomplete' => 'off');?>
          <?php $hidden = array('user_id' => $session['user_id']);?>
          <?php echo form_open('admin/department/add_department', $attributes, $hidden);?>
          <div class="form-group">
            <label for="name"><?php echo $this->lang->line('umb_name');?></label>
            <?php
            $data = array(
             'name'        => 'nama_department',
             'id'          => 'nama_department',
             'value'       => '',
             'placeholder'   => $this->lang->line('umb_name'),
             'class'       => 'form-control',
           );
            
            echo form_input($data);
            ?>
          </div>
          <div class="form-group">
            <label for="first_name"><?php echo $this->lang->line('left_perusahaan');?></label>
            <select class=" form-control" name="perusahaan_id" id="aj_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_perusahaan');?>">
              <option value=""></option>
              <?php foreach($get_all_perusahaans as $perusahaan) {?>
                <option value="<?php echo $perusahaan->perusahaan_id?>"><?php echo $perusahaan->name?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group" id="ajax_location">
            <label for="name"><?php echo $this->lang->line('left_location');?></label>
            <select disabled="disabled" name="location_id" id="location_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_location');?>">
              <option value=""></option>
            </select>
          </div>
          <div class="form-group" id="ajax_karyawan">
            <label for="name"><?php echo $this->lang->line('umb_department_head');?></label>
            <select disabled="disabled" name="karyawan_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_department_head');?>">
              <option value=""></option>
            </select>
          </div>
          <div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrastral_form', 'type' => 'submit', 'class' => $this->Umb_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('umb_save'))); ?> </div>
          <?php echo form_close(); ?> </div>
        </div>
      </div>
      <?php $colmdval = 'col-md-8';?>
    <?php } else {?>
      <?php $colmdval = 'col-md-12';?>
    <?php } ?>
    <div class="<?php echo $colmdval;?>">
      <div class="card">
        <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_list_all');?></strong> <?php echo $this->lang->line('umb_departments');?></span> </div>
        <div class="card-body">
          <div class="box-datatable table-responsive">
            <table class="datatables-demo table table-striped table-bordered" id="umb_table">
              <thead>
                <tr>
                  <th><?php echo $this->lang->line('umb_action');?></th>
                  <th><?php echo $this->lang->line('umb_nama_department');?></th>
                  <th><i class="fa fa-building-o"></i> <?php echo $this->lang->line('left_location');?></th>
                  <th><?php echo $this->lang->line('left_perusahaan');?></th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
