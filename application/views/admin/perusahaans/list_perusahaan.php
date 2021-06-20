<?php
/* perusahaan view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>
<?php $role_resources_ids = $this->Umb_model->user_role_resource(); ?>
<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('5',$role_resources_ids)) { ?>
      <li class="nav-item active"> <a href="<?php echo site_url('admin/perusahaan/');?>" data-link-data="<?php echo site_url('admin/perusahaan/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon ion ion-md-business"></span> <?php echo $this->lang->line('left_perusahaan');?>
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
 <li class="nav-item clickable"> <a href="<?php echo site_url('admin/kebijakan/');?>" data-link-data="<?php echo site_url('admin/kebijakan/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon fab fa-yelp"></span> <?php echo $this->lang->line('left_kebijakans');?>
 <div class="text-muted small"><?php echo $this->lang->line('umb_set_up');?> <?php echo $this->lang->line('header_kebijakans');?></div>
</a> </li>
<?php } ?>
</ul>
</div>
<hr class="border-light m-0 mb-3">

<?php if(in_array('246',$role_resources_ids)) {?>

  <div class="card mb-4 <?php echo $get_animate;?>">
    <div id="accordion">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_add_new');?></strong> <?php echo $this->lang->line('module_title_perusahaan');?></span>
        <div class="card-header-elements ml-md-auto"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
          <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('umb_add_new');?></button>
        </a> </div>
      </div>
      <div id="add_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
        <div class="card-body">
          <?php $attributes = array('name' => 'add_perusahaan', 'id' => 'umb-form', 'autocomplete' => 'off');?>
          <?php $hidden = array('user_id' => $session['user_id']);?>
          <?php echo form_open_multipart('admin/perusahaan/add_perusahaan', $attributes, $hidden);?>
          <div class="form-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="nama_perusahaan"><?php echo $this->lang->line('umb_nama_perusahaan');?></label>
                  <input class="form-control" placeholder="<?php echo $this->lang->line('umb_nama_perusahaan');?>" name="name" type="text">
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-6">
                      <label for="email"><?php echo $this->lang->line('umb_type_perusahaan');?></label>
                      <select class="form-control" name="type_perusahaan" data-plugin="umb_select" data-placeholder="<?php echo $this->lang->line('umb_type_perusahaan');?>">
                        <option value=""><?php echo $this->lang->line('umb_select_one');?></option>
                        <?php foreach($get_types_perusahaan as $ctype) {?>
                          <option value="<?php echo $ctype->type_id;?>"> <?php echo $ctype->name;?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="col-md-6">
                      <label for="nama_trading"><?php echo $this->lang->line('umb_perusahaan_trading');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('umb_perusahaan_trading');?>" name="nama_trading" type="text">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-6">
                      <label for="registration_no"><?php echo $this->lang->line('umb_perusahaan_registration');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('umb_perusahaan_registration');?>" name="registration_no" type="text">
                    </div>
                    <div class="col-md-6">
                      <label for="nomor_kontak"><?php echo $this->lang->line('umb_nomor_kontak');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('umb_nomor_kontak');?>" name="nomor_kontak" type="text">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-6">
                      <label for="email"><?php echo $this->lang->line('umb_email');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('umb_email');?>" name="email" type="email">
                    </div>
                    <div class="col-md-6">
                      <label for="website"><?php echo $this->lang->line('umb_website');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('umb_website_url');?>" name="website" type="text">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="umb_pjkprmth"><?php echo $this->lang->line('umb_pjkprmth');?></label>
                  <input class="form-control" placeholder="<?php echo $this->lang->line('umb_pjkprmth');?>" name="umb_pjkprmth" type="text">
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
                  <select class="form-control" name="negara" data-plugin="umb_select" data-placeholder="<?php echo $this->lang->line('umb_negara');?>">
                    <option value=""><?php echo $this->lang->line('umb_select_one');?></option>
                    <?php foreach($all_negaraa as $negara) {?>
                      <option value="<?php echo $negara->negara_id;?>"> <?php echo $negara->nama_negara;?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3">
                <label for="email"><?php echo $this->lang->line('dashboard_username');?></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('dashboard_username');?>" name="username" type="text">
              </div>
              <div class="col-md-3">
                <label for="website"><?php echo $this->lang->line('umb_password_karyawan');?></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('umb_password_karyawan');?>" name="password" type="text">
              </div>
              <div class="col-md-6">
                <fieldset class="form-group">
                  <label for="logo"><?php echo $this->lang->line('umb_logo_perusahaan');?></label>
                  <input type="file" class="form-control-file" id="logo" name="logo">
                  <small><?php echo $this->lang->line('umb_perusahaan_file_type');?></small>
                </fieldset>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="email"><?php echo $this->lang->line('umb_invoice_currency');?></label>
                  <select class="form-control" name="default_currency" data-plugin="umb_select" data-placeholder="<?php echo $this->lang->line('umb_invoice_currency');?>">
                    <option value=""><?php echo $this->lang->line('umb_select_one');?></option>
                    <?php foreach($this->Umb_model->get_currencies() as $currency){?>
                      <?php $_currency = $currency->code.' - '.$currency->symbol;?>
                      <option value="<?php echo $_currency;?>"> <?php echo $_currency;?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="phone"><?php echo $this->lang->line('umb_setting_timezone');?></label>
                  <select class="form-control" name="default_timezone" data-plugin="umb_select" data-placeholder="<?php echo $this->lang->line('umb_setting_timezone');?>">
                    <option value=""><?php echo $this->lang->line('umb_select_one');?></option>
                    <?php foreach($this->Umb_model->all_timezones() as $tval=>$labels):?>
                      <option value="<?php echo $tval;?>"><?php echo $labels;?></option>
                    <?php endforeach;?>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <?php $count_module_attributes = $this->Custom_fields_model->count_perusahaan_module_attributes();?>
          <?php if($count_module_attributes > 0):?>
            <div class="row">
              <?php $module_attributes = $this->Custom_fields_model->perusahaan_hrastral_module_attributes();?>
              <?php foreach($module_attributes as $mattribute):?>
                <?php if($mattribute->attribute_type == 'date'){?>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="<?php echo $mattribute->attribute;?>"><?php echo $mattribute->attribute_label;?></label>
                      <input class="form-control date" placeholder="<?php echo $mattribute->attribute_label;?>" name="<?php echo $mattribute->attribute;?>" type="text">
                    </div>
                  </div>
                <?php } else if($mattribute->attribute_type == 'select'){?>
                  <div class="col-md-4">
                    <?php $iselc_val = $this->Custom_fields_model->get_attribute_selection_values($mattribute->custom_field_id);?>
                    <div class="form-group">
                      <label for="<?php echo $mattribute->attribute;?>"><?php echo $mattribute->attribute_label;?></label>
                      <select class="form-control" name="<?php echo $mattribute->attribute;?>" data-plugin="select_hrm" data-placeholder="<?php echo $mattribute->attribute_label;?>">
                        <?php foreach($iselc_val as $selc_val) {?>
                          <option value="<?php echo $selc_val->attributes_select_value_id?>"><?php echo $selc_val->select_label?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                <?php } else if($mattribute->attribute_type == 'multiselect'){?>
                  <div class="col-md-4">
                    <?php $imulti_selc_val = $this->Custom_fields_model->get_attribute_selection_values($mattribute->custom_field_id);?>
                    <div class="form-group">
                      <label for="<?php echo $mattribute->attribute;?>"><?php echo $mattribute->attribute_label;?></label>
                      <select multiple="multiple" class="form-control" name="<?php echo $mattribute->attribute;?>[]" data-plugin="select_hrm" data-placeholder="<?php echo $mattribute->attribute_label;?>">
                        <?php foreach($imulti_selc_val as $multi_selc_val) {?>
                          <option value="<?php echo $multi_selc_val->attributes_select_value_id?>"><?php echo $multi_selc_val->select_label?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                <?php } else if($mattribute->attribute_type == 'textarea'){?>
                  <div class="col-md-8">
                    <div class="form-group">
                      <label for="<?php echo $mattribute->attribute;?>"><?php echo $mattribute->attribute_label;?></label>
                      <input class="form-control" placeholder="<?php echo $mattribute->attribute_label;?>" name="<?php echo $mattribute->attribute;?>" type="text">
                    </div>
                  </div>
                <?php } else if($mattribute->attribute_type == 'fileupload'){?>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="<?php echo $mattribute->attribute;?>"><?php echo $mattribute->attribute_label;?></label>
                      <input class="form-control-file" name="<?php echo $mattribute->attribute;?>" type="file">
                    </div>
                  </div>
                <?php } else { ?>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="<?php echo $mattribute->attribute;?>"><?php echo $mattribute->attribute_label;?></label>
                      <input class="form-control" placeholder="<?php echo $mattribute->attribute_label;?>" name="<?php echo $mattribute->attribute;?>" type="text">
                    </div>
                  </div>
                <?php }	?>
              <?php endforeach;?>
            </div>
          <?php endif;?>
          <div class="form-actions box-footer">
            <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('umb_save');?> </button>
          </div>
          <?php echo form_close(); ?> 
        </div>
      </div>
    </div>
  </div>
<?php } ?>
<div class="card <?php echo $get_animate;?>">
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_list_all');?></strong> <?php echo $this->lang->line('umb_perusahaans');?></span> 
  </div>
  <div class="card-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="umb_table">
        <thead>
          <tr>
            <th><?php echo $this->lang->line('umb_action');?></th>
            <th><?php echo $this->lang->line('module_title_perusahaan');?></th>
            <th><i class="fa fa-envelope"></i> <?php echo $this->lang->line('umb_email');?></th>
            <th><?php echo $this->lang->line('umb_kota');?></th>
            <th><?php echo $this->lang->line('umb_negara');?></th>
            <th><?php echo $this->lang->line('umb_invoice_currency');?></th>
            <th><?php echo $this->lang->line('umb_setting_timezone');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
