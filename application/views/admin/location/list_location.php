<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>
<?php $role_resources_ids = $this->Umb_model->user_role_resource(); ?>
<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <li class="nav-item clickable"> 
      <a href="<?php echo site_url('admin/perusahaan/');?>" data-link-data="<?php echo site_url('admin/perusahaan/');?>" class="mb-3 nav-link hrastral-link"> 
        <span class="sw-icon ion ion-md-business"></span> 
        <?php echo $this->lang->line('left_perusahaan');?>
        <div class="text-muted small"><?php echo $this->lang->line('umb_set_up');?> <?php echo $this->lang->line('umb_perusahaans');?></div>
      </a> 
    </li>
    <li class="nav-item active"> 
      <a href="<?php echo site_url('admin/location/');?>" data-link-data="<?php echo site_url('admin/location/');?>" class="mb-3 nav-link hrastral-link"> 
        <span class="sw-icon fas fa-location-arrow"></span> 
        <?php echo $this->lang->line('left_location');?>
        <div class="text-muted small"><?php echo $this->lang->line('umb_set_up');?> <?php echo $this->lang->line('umb_locations');?></div>
      </a> 
    </li>
    <li class="nav-item clickable"> 
      <a href="<?php echo site_url('admin/department/');?>" data-link-data="<?php echo site_url('admin/department/');?>" class="mb-3 nav-link hrastral-link"> 
        <span class="sw-icon fab fa-codepen"></span> 
        <?php echo $this->lang->line('left_department');?>
        <div class="text-muted small"><?php echo $this->lang->line('umb_add_new');?> <?php echo $this->lang->line('left_department');?></div>
      </a> 
    </li>
    <li class="nav-item clickable"> 
      <a href="<?php echo site_url('admin/penunjukan/');?>" data-link-data="<?php echo site_url('admin/penunjukan/');?>" class="mb-3 nav-link hrastral-link"> 
        <span class="sw-icon fab fa-dev"></span> 
        <?php echo $this->lang->line('left_penunjukan');?>
        <div class="text-muted small"><?php echo $this->lang->line('umb_add_new');?> <?php echo $this->lang->line('left_penunjukan');?></div>
      </a> 
    </li>
    <li class="nav-item clickable"> 
      <a href="<?php echo site_url('admin/pengumuman/');?>" data-link-data="<?php echo site_url('admin/pengumuman/');?>" class="mb-3 nav-link hrastral-link"> 
        <span class="sw-icon ion ion-md-megaphone"></span> 
        <?php echo $this->lang->line('left_pengumumans');?>
        <div class="text-muted small"><?php echo $this->lang->line('umb_set_up');?> <?php echo $this->lang->line('left_pengumumans');?></div>
      </a> 
    </li>
    <li class="nav-item clickable"> 
      <a href="<?php echo site_url('admin/kebijakan/');?>" data-link-data="<?php echo site_url('admin/kebijakan/');?>" class="mb-3 nav-link hrastral-link"> 
        <span class="sw-icon fab fa-yelp"></span> 
        <?php echo $this->lang->line('left_kebijakans');?>
        <div class="text-muted small"><?php echo $this->lang->line('umb_set_up');?> <?php echo $this->lang->line('header_kebijakans');?></div>
      </a> 
    </li>
  </ul>
</div>
<hr class="border-light m-0">
<?php if(in_array('250',$role_resources_ids)) {?>
  <?php $user_info = $this->Umb_model->read_user_info($session['user_id']);?>
  <div class="card mb-4 <?php echo $get_animate;?> mt-3">
    <div id="accordion">
      <div class="card-header with-elements"> 
        <span class="card-header-title mr-2">
          <strong><?php echo $this->lang->line('umb_add_new');?></strong> 
          <?php echo $this->lang->line('umb_e_details_location');?>
        </span>
        <div class="card-header-elements ml-md-auto"> 
          <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
            <button type="button" class="btn btn-xs btn-primary"> 
              <span class="ion ion-md-add"></span> 
              <?php echo $this->lang->line('umb_add_new');?>
            </button>
          </a> 
        </div>
      </div>
      <div id="add_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
        <div class="card-body">
          <?php $attributes = array('name' => 'add_location', 'id' => 'umb-form', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
          <?php $hidden = array('user_id' => $session['user_id']);?>
          <?php echo form_open('admin/location/add_location', $attributes, $hidden);?>
          <div class="form-body">
            <div class="row">
              <div class="col-sm-6">
                <?php if($user_info[0]->user_role_id==1){ ?>
                  <div class="form-group">
                    <label for="nama_perusahaan"><?php echo $this->lang->line('module_title_perusahaan');?></label>
                    <select class="form-control" name="perusahaan" id="aj_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_title_perusahaan');?>">
                      <option value=""><?php echo $this->lang->line('umb_select_one');?></option>
                      <?php foreach($all_perusahaans as $perusahaan) {?>
                        <option value="<?php echo $perusahaan->perusahaan_id;?>"> <?php echo $perusahaan->name;?></option>
                      <?php } ?>
                    </select>
                  </div>
                <?php } else {?>
                  <?php $eperusahaan_id = $user_info[0]->perusahaan_id;?>
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
                <?php } ?>
                <div class="form-group">
                  <label for="name"><?php echo $this->lang->line('umb_nama_location');?></label>
                  <input class="form-control" placeholder="<?php echo $this->lang->line('umb_nama_location');?>" name="name" type="text">
                </div>
                <div class="form-group">
                  <label for="email"><?php echo $this->lang->line('umb_email');?></label>
                  <input class="form-control" placeholder="<?php echo $this->lang->line('umb_email');?>" name="email" type="email">
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-6">
                      <label for="phone"><?php echo $this->lang->line('umb_phone');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('umb_phone');?>" name="phone" type="text">
                    </div>
                    <div class="col-md-6">
                      <label for="umb_faxn"><?php echo $this->lang->line('umb_faxn');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('umb_faxn');?>" name="fax" type="text">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group" id="ajax_karyawan">
                  <div class="row">
                    <div class="col-md-12">
                      <label for="email"><?php echo $this->lang->line('umb_view_locationhead');?></label>
                      <select class="form-control" name="location_head" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_view_locationhead');?>">
                        <option value=""><?php echo $this->lang->line('umb_select_one');?></option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="alamat"><?php echo $this->lang->line('umb_alamat');?></label>
                  <input class="form-control" placeholder="<?php echo $this->lang->line('umb_alamat_1');?>" name="alamat_1" type="text">
                  <br>
                  <input class="form-control" placeholder="<?php echo $this->lang->line('umb_alamat_2');?>" name="alamat_2" type="text">
                  <br>
                  <div class="row">
                    <div class="col-md-4">
                      <input class="form-control" placeholder="<?php echo $this->lang->line('umb_kota');?>" name="kota" type="text">
                    </div>
                    <div class="col-md-4">
                      <input class="form-control" placeholder="<?php echo $this->lang->line('umb_provinsi');?>" name="provinsi" type="text">
                    </div>
                    <div class="col-md-4">
                      <input class="form-control" placeholder="<?php echo $this->lang->line('umb_kode_pos');?>" name="kode_pos" type="text">
                    </div>
                  </div>
                  <br>
                  <select class="form-control" name="negara" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_negara');?>">
                    <option value=""><?php echo $this->lang->line('umb_select_one');?></option>
                    <?php foreach($all_negaraa as $negara) {?>
                      <option value="<?php echo $negara->negara_id;?>"> <?php echo $negara->nama_negara;?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="form-actions box-footer">
            <button type="submit" class="btn btn-primary"> 
              <i class="fa fa-check-square-o"></i> 
              <?php echo $this->lang->line('umb_save');?> 
            </button>
          </div>
          <?php echo form_close(); ?> 
        </div>
      </div>
    </div>
  </div>
<?php } ?>
<div class="card <?php echo $get_animate;?>">
  <div class="card-header with-elements"> 
    <span class="card-header-title mr-2">
      <strong><?php echo $this->lang->line('umb_list_all');?></strong> 
      <?php echo $this->lang->line('umb_locations');?>
    </span> 
  </div>
  <div class="card-body">
    <div class="card-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="umb_table">
        <thead>
          <tr>
            <th><?php echo $this->lang->line('umb_action');?></th>
            <th><?php echo $this->lang->line('umb_nama_location');?></th>
            <th>
              <i class="fa fa-user"></i> 
              <?php echo $this->lang->line('umb_view_locationhead');?>
            </th>
            <th><?php echo $this->lang->line('umb_kota');?></th>
            <th><?php echo $this->lang->line('umb_negara');?></th>
            <th>
              <i class="fa fa-user"></i> 
              <?php echo $this->lang->line('umb_ditambahkan_oleh');?>
            </th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
