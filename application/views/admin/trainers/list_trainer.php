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
    <li class="nav-item active"> <a href="<?php echo site_url('admin/trainers/');?>" data-link-data="<?php echo site_url('admin/trainers/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon fas fa-user-graduate"></span> <?php echo $this->lang->line('left_list_trainers');?>
    <div class="text-muted small"><?php echo $this->lang->line('umb_role_add');?> <?php echo $this->lang->line('left_list_trainers');?></div>
  </a> </li>
<?php } ?>  
<?php  if(in_array('55',$role_resources_ids)) {?>
  <li class="nav-item done"> <a href="<?php echo site_url('admin/type_training/');?>" data-link-data="<?php echo site_url('admin/type_training/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon fab fa-typo3"></span> <?php echo $this->lang->line('left_type_training');?>
  <div class="text-muted small"><?php echo $this->lang->line('umb_role_add');?> <?php echo $this->lang->line('left_type_training');?></div>
</a> </li>
<?php } ?>  
</ul>
</div>
<hr class="border-light m-0 mb-3">
<?php if(in_array('348',$role_resources_ids)) {?>
  <?php $user_info = $this->Umb_model->read_user_info($session['user_id']);?>
  <div class="card mb-4">
    <div id="accordion">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_add_new');?></strong> <?php echo $this->lang->line('umb_trainer');?></span>
        <div class="card-header-elements ml-md-auto"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_trainer_form" aria-expanded="false">
          <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('umb_add_new');?></button>
        </a> </div>
      </div>
      <div id="add_trainer_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
        <div class="card-body">
          <?php $attributes = array('name' => 'add_trainer', 'id' => 'umb-form', 'autocomplete' => 'off');?>
          <?php $hidden = array('user_id' => $session['user_id']);?>
          <?php echo form_open('admin/trainers/add_trainer', $attributes, $hidden);?>
          <div class="bg-white">
            <div class="box-block">
              <div class="row">
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="first_name"><?php echo $this->lang->line('umb_karyawan_first_name');?></label>
                        <input class="form-control" placeholder="<?php echo $this->lang->line('umb_karyawan_first_name');?>" name="first_name" type="text" value="">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="last_name" class="control-label"><?php echo $this->lang->line('umb_karyawan_last_name');?></label>
                        <input class="form-control" placeholder="<?php echo $this->lang->line('umb_karyawan_last_name');?>" name="last_name" type="text" value="">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="nomor_kontak"><?php echo $this->lang->line('umb_nomor_kontak');?></label>
                        <input class="form-control" placeholder="<?php echo $this->lang->line('umb_nomor_kontak');?>" name="nomor_kontak" type="text" value="">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="email" class="control-label"><?php echo $this->lang->line('dashboard_email');?></label>
                        <input class="form-control" placeholder="<?php echo $this->lang->line('dashboard_email');?>" name="email" type="text" value="">
                      </div>
                    </div>
                  </div>
                  <?php if($user_info[0]->user_role_id==1){ ?>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="nama_perusahaan"><?php echo $this->lang->line('module_title_perusahaan');?></label>
                          <select class="form-control" name="perusahaan" id="aj_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_title_perusahaan');?>">
                            <option value=""><?php echo $this->lang->line('umb_select_one');?></option>
                            <?php foreach($all_perusahaans as $perusahaan) {?>
                              <option value="<?php echo $perusahaan->perusahaan_id;?>"> <?php echo $perusahaan->name;?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                    </div>
                  <?php } else {?>
                    <?php $eperusahaan_id = $user_info[0]->perusahaan_id;?>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="nama_perusahaan"><?php echo $this->lang->line('module_title_perusahaan');?></label>
                          <select class="form-control" name="perusahaan" id="aj_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_title_perusahaan');?>">
                            <option value=""><?php echo $this->lang->line('umb_select_one');?></option>
                            <?php foreach($all_perusahaans as $perusahaan) {?>
                              <?php if($eperusahaan_id == $perusahaan->perusahaan_id):?>
                                <option value="<?php echo $perusahaan->perusahaan_id;?>"> <?php echo $perusahaan->name;?></option>
                              <?php endif;?>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                    </div>
                  <?php } ?>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="expertise"><?php echo $this->lang->line('umb_expertise');?></label>
                    <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('umb_expertise');?>" name="expertise" cols="30" rows="5" id="expertise"></textarea>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="alamat"><?php echo $this->lang->line('umb_alamat');?></label>
                <textarea class="form-control" placeholder="<?php echo $this->lang->line('umb_alamat');?>" name="alamat" cols="30" rows="3" id="alamat"></textarea>
              </div>
              <div class="form-actions box-footer">
                <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('umb_save');?> </button>
              </div>
            </div>
          </div>
          <?php echo form_close(); ?> </div>
        </div>
      </div>
    </div>
  <?php } ?>
  <div class="card">
    <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_list_all');?></strong> <?php echo $this->lang->line('umb_trainers');?></span> </div>
    <div class="card-body">
      <div class="box-datatable table-responsive">
        <table class="datatables-demo table table-striped table-bordered" id="umb_table">
          <thead>
            <tr>
              <th><?php echo $this->lang->line('umb_action');?></th>
              <th width="350"><i class="fa fa-user"></i> <?php echo $this->lang->line('dashboard_fullname');?></th>
              <th><?php echo $this->lang->line('left_perusahaan');?></th>
              <th><i class="fa fa-phone"></i> <?php echo $this->lang->line('umb_nomor_kontak');?></th>
              <th><i class="fa fa-envelope"></i> <?php echo $this->lang->line('dashboard_email');?></th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
