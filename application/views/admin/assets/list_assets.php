<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>
<?php $role_resources_ids = $this->Umb_model->user_role_resource(); ?>
<?php $user_info = $this->Umb_model->read_user_info($session['user_id']);?>

<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('25',$role_resources_ids)) {?>
      <li class="nav-item active">
        <a href="<?php echo site_url('admin/assets/');?>" data-link-data="<?php echo site_url('admin/assets/');?>" class="mb-3 nav-link hrastral-link">
          <span class="sw-icon ion ion-md-today"></span>
          <?php echo $this->lang->line('umb_assets');?>
          <div class="text-muted small"><?php echo $this->lang->line('umb_set_up');?> <?php echo $this->lang->line('umb_assets');?></div>
        </a>
      </li>
    <?php } ?>
    <?php if(in_array('26',$role_resources_ids)) {?>
      <li class="nav-item done">
        <a href="<?php echo site_url('admin/assets/kategori/');?>" data-link-data="<?php echo site_url('admin/assets/kategori/');?>" class="mb-3 nav-link hrastral-link">
          <span class="sw-icon fab fa-typo3"></span>
          <?php echo $this->lang->line('umb_acc_kategori');?>
          <div class="text-muted small"><?php echo $this->lang->line('umb_set_up');?> <?php echo $this->lang->line('umb_acc_kategori');?></div>
        </a>
      </li>
    <?php } ?>
  </ul>
</div> 
<hr class="border-light m-0 mb-3">
<?php if(in_array('262',$role_resources_ids)) {?>
  <div class="card mb-4 <?php echo $get_animate;?>">
    <div id="accordion">
      <div class="card-header with-elements"> 
        <span class="card-header-title mr-2">
          <strong><?php echo $this->lang->line('umb_add_new');?></strong> 
          <?php echo $this->lang->line('umb_asset');?>
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
          <?php $attributes = array('name' => 'add_assets', 'id' => 'umb-form', 'autocomplete' => 'off', 'class' => 'form');?>
          <?php $hidden = array('user_id' => $session['user_id']);?>
          <?php echo form_open_multipart('admin/assets/add_asset', $attributes, $hidden);?>
          <div class="form-body">
            <div class="row">
              <div class="col-md-6">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="first_name"><?php echo $this->lang->line('umb_acc_kategori');?></label>
                      <select class="form-control" name="kategori_id" id="kategori_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_acc_kategori');?>">
                        <option value=""></option>
                        <?php foreach($all_kategoris_assets as $kategori_assets) {?>
                          <option value="<?php echo $kategori_assets->kategori_assets_id?>"><?php echo $kategori_assets->nama_kategori?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="nama_asset" class="control-label"><?php echo $this->lang->line('umb_nama_asset');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('umb_nama_asset');?>" name="nama_asset" type="text" value="">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <?php if($user_info[0]->user_role_id==1){ ?>
                      <div class="form-group">
                        <label for="perusahaan_id"><?php echo $this->lang->line('left_perusahaan');?></label>
                        <select class="form-control" name="perusahaan_id" id="aj_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_perusahaan');?>">
                          <option value=""></option>
                          <?php foreach($all_perusahaans as $perusahaan) {?>
                            <option value="<?php echo $perusahaan->perusahaan_id?>"><?php echo $perusahaan->name?></option>
                          <?php } ?>
                        </select>
                      </div>
                    <?php } else {?>
                      <?php $eperusahaan_id = $user_info[0]->perusahaan_id;?>
                      <div class="form-group">
                        <label for="perusahaan_id"><?php echo $this->lang->line('left_perusahaan');?></label>
                        <select class="form-control" name="perusahaan_id" id="aj_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_perusahaan');?>">
                          <option value=""></option>
                          <?php foreach($all_perusahaans as $perusahaan) {?>
                            <?php if($eperusahaan_id == $perusahaan->perusahaan_id):?>
                              <option value="<?php echo $perusahaan->perusahaan_id?>"><?php echo $perusahaan->name?></option>
                            <?php endif;?>
                          <?php } ?>
                        </select>
                      </div>
                    <?php } ?>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group" id="ajax_karyawan">
                      <label for="first_name"><?php echo $this->lang->line('umb_assets_assign_to');?></label>
                      <select class="form-control" name="karyawan_id" id="karyawan_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_choose_an_karyawan');?>">
                        <option value=""></option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="manufacturer"><?php echo $this->lang->line('umb_manufacturer');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('umb_manufacturer');?>" name="manufacturer" type="text" value="">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="umb_serial_number" class="control-label"><?php echo $this->lang->line('umb_serial_number');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('umb_serial_number');?>" name="serial_number" type="text" value="">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="kode_asset_perusahaan"><?php echo $this->lang->line('umb_kode_asset_perusahaan');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('umb_kode_asset_perusahaan');?>" name="kode_asset_perusahaan" type="text" value="">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="sedang_bekerja" class="control-label"><?php echo $this->lang->line('umb_sedang_bekerja');?></label>
                      <select class="form-control" name="sedang_bekerja" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_sedang_bekerja');?>">
                        <option value="1"><?php echo $this->lang->line('umb_yes');?></option>
                        <option value="0"><?php echo $this->lang->line('umb_no');?></option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="tanggal_pembelian"><?php echo $this->lang->line('umb_tanggal_pembelian');?></label>
                      <input class="form-control date" placeholder="<?php echo $this->lang->line('umb_tanggal_pembelian');?>" name="tanggal_pembelian" type="text" value="">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="role"><?php echo $this->lang->line('umb_nomor_invoice');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('umb_nomor_invoice');?>" name="nomor_invoice" type="text" value="">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="tanggal_akhir_garansi" class="control-label"><?php echo $this->lang->line('umb_tanggal_akhir_garansi');?></label>
                      <input class="form-control date" placeholder="<?php echo $this->lang->line('umb_tanggal_akhir_garansi');?>" name="tanggal_akhir_garansi" type="text" value="">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <fieldset class="form-group">
                        <label for="asset_image"><?php echo $this->lang->line('umb_asset_image');?></label>
                        <input type="file" class="form-control-file" id="asset_image" name="asset_image">
                        <small><?php echo $this->lang->line('umb_asset_allowed_image_formats');?></small>
                      </fieldset>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="informasi_award"><?php echo $this->lang->line('umb_asset_note');?></label>
              <textarea class="form-control" placeholder="<?php echo $this->lang->line('umb_asset_note');?>" name="asset_note" cols="30" rows="3" id="asset_note"></textarea>
            </div>
          </div>
          <?php $count_module_attributes = $this->Custom_fields_model->count_assets_module_attributes();?>
          <?php if($count_module_attributes > 0):?>
            <div class="row">
              <?php $module_attributes = $this->Custom_fields_model->assets_hrastral_module_attributes();?>
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
<div class="card">
  <div class="card-header with-elements"> 
    <span class="card-header-title mr-2">
      <strong><?php echo $this->lang->line('umb_list_all');?></strong> 
      <?php echo $this->lang->line('umb_assets');?>
    </span>
  </div>
  <div class="card-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="umb_table">
        <thead>
          <tr>
            <th><?php echo $this->lang->line('umb_action');?></th>
            <th><i class="fa fa-flask"></i> <?php echo $this->lang->line('umb_nama_asset');?></th>
            <th><?php echo $this->lang->line('umb_acc_kategori');?></th>
            <th><?php echo $this->lang->line('umb_kode_asset_perusahaan');?></th>
            <th><?php echo $this->lang->line('umb_sedang_bekerja');?></th>
            <th><i class="fa fa-user"></i> <?php echo $this->lang->line('umb_assets_assign_to');?></th>
            <th><?php echo $this->lang->line('left_perusahaan');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>    
