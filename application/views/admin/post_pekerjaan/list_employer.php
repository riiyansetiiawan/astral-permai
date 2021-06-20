<?php
/* perusahaan view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>
<?php $role_resources_ids = $this->Umb_model->user_role_resource(); ?>
<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('49',$role_resources_ids)) { ?>
      <li class="nav-item done"> <a href="<?php echo site_url('admin/post_pekerjaan/');?>" data-link-data="<?php echo site_url('admin/post_pekerjaan/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon fas fa-newspaper"></span> <?php echo $this->lang->line('left_post_pekerjaan');?>
      <div class="text-muted small"><?php echo $this->lang->line('umb_role_create');?> <?php echo $this->lang->line('header_frontend_apply_pekerjaans');?></div>
    </a> </li>
  <?php } ?>  
  <?php if(in_array('51',$role_resources_ids)) { ?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/kandidats_pekerjaan/');?>" data-link-data="<?php echo site_url('admin/kandidats_pekerjaan/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon fas fa-user-friends"></span> <?php echo $this->lang->line('left_kandidats_pekerjaan');?>
    <div class="text-muted small"><?php echo $this->lang->line('umb_view');?> <?php echo $this->lang->line('left_kandidats_pekerjaan');?></div>
  </a> </li>
<?php } ?>  
<?php if(in_array('52',$role_resources_ids)) { ?>
  <li class="nav-item active"> <a href="<?php echo site_url('admin/post_pekerjaan/employer/');?>" data-link-data="<?php echo site_url('admin/post_pekerjaan/employer/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon fas fa-user-ninja"></span> <?php echo $this->lang->line('umb_employer_pekerjaans');?>
  <div class="text-muted small"><?php echo $this->lang->line('umb_role_add');?> <?php echo $this->lang->line('umb_employer_pekerjaans');?></div>
</a> </li>
<?php } ?>  
<?php if(in_array('296',$role_resources_ids)) { ?>
  <li class="nav-item done"> <a href="<?php echo site_url('admin/post_pekerjaan/pages/');?>" data-link-data="<?php echo site_url('admin/post_pekerjaan/pages/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon ion ion-ios-paper"></span> <?php echo $this->lang->line('umb_cms_pages_pekerjaans');?>
  <div class="text-muted small"><?php echo $this->lang->line('umb_update');?> <?php echo $this->lang->line('umb_cms_pages_pekerjaans');?></div>
</a> </li>
<?php } ?> 
</ul>
</div>
<hr class="border-light m-0 mb-3">
<?php if(in_array('246',$role_resources_ids)) {?>

  <div class="card mb-4 <?php echo $get_animate;?>">
    <div id="accordion">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_add_new');?></strong> <?php echo $this->lang->line('umb_employer_pekerjaans');?></span>
        <div class="card-header-elements ml-md-auto"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
          <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('umb_add_new');?></button>
        </a> </div>
      </div>
      <div id="add_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
        <div class="card-body">
          <?php $attributes = array('name' => 'add_employer', 'id' => 'umb-form', 'autocomplete' => 'off');?>
          <?php $hidden = array('user_id' => $session['user_id']);?>
          <?php echo form_open_multipart('admin/post_pekerjaan/add_employer', $attributes, $hidden);?>
          <div class="form-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="nama_perusahaan"><?php echo $this->lang->line('umb_nama_perusahaan');?></label>
                  <input class="form-control" placeholder="<?php echo $this->lang->line('umb_nama_perusahaan');?>" name="nama_perusahaan" type="text">
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-6">
                      <label for="email"><?php echo $this->lang->line('umb_email');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('umb_email');?>" name="email" type="email">
                    </div>
                    <div class="col-md-6">
                      <label for="nomor_kontak"><?php echo $this->lang->line('umb_nomor_kontak');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('umb_nomor_kontak');?>" name="nomor_kontak" type="text">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-6">
                     <div class="form-group">
                      <label for="email"><?php echo $this->lang->line('umb_karyawan_first_name');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('umb_karyawan_first_name');?>" name="first_name" type="text">
                    </div>
                  </div>
                  <div class="col-md-6">
                  	<div class="form-group">
                      <label for="nama_trading"><?php echo $this->lang->line('umb_karyawan_last_name');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('umb_karyawan_last_name');?>" name="last_name" type="text">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="website"><?php echo $this->lang->line('umb_password_karyawan');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('umb_password_karyawan');?>" name="password" type="text">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <fieldset class="form-group">
                        <label for="logo"><?php echo $this->lang->line('umb_logo');?></label>
                        <input type="file" class="form-control-file" id="logo_perusahaan" name="logo_perusahaan">
                        <small><?php echo $this->lang->line('umb_perusahaan_file_type');?></small>
                      </fieldset>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="form-actions box-footer">
          <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('umb_save');?> </button>
        </div>
        <?php echo form_close(); ?> </div>
      </div>
    </div>
  </div>
<?php } ?>
<div class="card <?php echo $get_animate;?>">
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_list_all');?></strong> <?php echo $this->lang->line('umb_employers_pekerjaans');?></span> </div>
  <div class="card-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="umb_table">
        <thead>
          <tr>
            <th><?php echo $this->lang->line('umb_action');?></th>
            <th><i class="fa fa-user"></i> <?php echo $this->lang->line('dashboard_fullname');?></th>
            <th><i class="fa fa-building-o"></i> <?php echo $this->lang->line('umb_nama_perusahaan');?></th>
            <th><i class="fa fa-envelope"></i> <?php echo $this->lang->line('umb_email');?></th>
            <th><?php echo $this->lang->line('umb_e_details_kontak');?>#</th>
            <th><?php echo $this->lang->line('umb_title_applicants_pekerjaan');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
