<?php
/* Policy view
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
  <li class="nav-item clickable"> <a href="<?php echo site_url('admin/department/');?>" data-link-data="<?php echo site_url('admin/department/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon fab fa-codepen"></span> <?php echo $this->lang->line('left_department');?>
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
 <li class="nav-item active"> <a href="<?php echo site_url('admin/kebijakan/');?>" data-link-data="<?php echo site_url('admin/kebijakan/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon fab fa-yelp"></span> <?php echo $this->lang->line('left_kebijakans');?>
 <div class="text-muted small"><?php echo $this->lang->line('umb_set_up');?> <?php echo $this->lang->line('header_kebijakans');?></div>
</a> </li>
<?php } ?>
</ul>
</div>
<hr class="border-light m-0 mb-3">
<div class="row m-b-1 <?php echo $get_animate;?>">
  <?php $role_resources_ids = $this->Umb_model->user_role_resource(); ?>
  <?php if(in_array('258',$role_resources_ids)) {?>
    <?php $user_info = $this->Umb_model->read_user_info($session['user_id']);?>
    <div class="col-md-4">
      <div class="card">
        <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_add_new');?></strong> <?php echo $this->lang->line('umb_kebijakan');?></span>
        </div>
        <div class="card-body">
          <?php $attributes = array('name' => 'add_kebijakan', 'id' => 'umb-form', 'autocomplete' => 'off');?>
          <?php $hidden = array('user_id' => $session['user_id']);?>
          <?php echo form_open('admin/kebijakan/add_kebijakan', $attributes, $hidden);?>
          <?php if($user_info[0]->user_role_id==1){ ?>
            <div class="form-group">
              <input type="hidden" name="user_id" value="<?php echo $session['user_id'];?>">
              <label for="perusahaan"><?php echo $this->lang->line('module_title_perusahaan');?></label>
              <select class="select2" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_select_perusahaan');?>..." name="perusahaan">
                <option value=""></option>
                <?php foreach($all_perusahaans as $perusahaan) {?>
                  <option value="<?php echo $perusahaan->perusahaan_id;?>"> <?php echo $perusahaan->name;?></option>
                <?php } ?>
              </select>
            </div>
          <?php } else {?>
            <?php $eperusahaan_id = $user_info[0]->perusahaan_id;?>
            <div class="form-group">
              <input type="hidden" name="user_id" value="<?php echo $session['user_id'];?>">
              <label for="perusahaan"><?php echo $this->lang->line('module_title_perusahaan');?></label>
              <select class="select2" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_select_perusahaan');?>..." name="perusahaan">
                <option value=""></option>
                <?php foreach($all_perusahaans as $perusahaan) {?>
                  <?php if($eperusahaan_id == $perusahaan->perusahaan_id):?>
                    <option value="<?php echo $perusahaan->perusahaan_id;?>"> <?php echo $perusahaan->name;?></option>
                  <?php endif;?>
                <?php } ?>
              </select>
            </div>
          <?php } ?>
          <div class="form-group">
            <label for="title"><?php echo $this->lang->line('umb_title');?></label>
            <input type="text" class="form-control" name="title" placeholder="<?php echo $this->lang->line('umb_title');?>">
          </div>
          <div class="form-group">
            <label for="message"><?php echo $this->lang->line('umb_description');?></label>
            <textarea class="form-control" placeholder="<?php echo $this->lang->line('umb_description');?>" name="description" id="description"></textarea>
          </div>
          <div class="form-group">
            <fieldset class="form-group">
              <label for="attachment"><?php echo $this->lang->line('umb_attachment');?></label>
              <input type="file" class="form-control-file" id="attachment" name="attachment">
              <small><?php echo $this->lang->line('umb_perusahaan_file_type');?></small>
            </fieldset>
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
        <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_list_all');?></strong> <?php echo $this->lang->line('umb_kebijakans');?></span>
          <div class="card-header-elements ml-md-auto"> <a class="text-dark" href="<?php echo site_url('admin/kebijakan/view_all');?>">
            <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-ios-eye"></span> <?php echo $this->lang->line('umb_view_kebijakans');?></button>
          </a> </div>
        </div>
        <div class="card-body">
          <div class="box-datatable table-responsive">
            <table class="datatables-demo table table-striped table-bordered" id="umb_table">
              <thead>
                <tr>
                  <th style="width:100px;"><?php echo $this->lang->line('umb_action');?></th>
                  <th width="230"><?php echo $this->lang->line('umb_title');?></th>
                  <th><i class="fa fa-user"></i> <?php echo $this->lang->line('umb_created_at');?></th>
                  <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('umb_ditambahkan_oleh');?></th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <style type="text/css">
    .trumbowyg-editor { min-height:110px !important; }
  </style>
