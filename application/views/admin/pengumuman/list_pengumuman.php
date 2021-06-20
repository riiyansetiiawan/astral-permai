<?php
/* pengumuman view
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
  <li class="nav-item active"> <a href="<?php echo site_url('admin/pengumuman/');?>" data-link-data="<?php echo site_url('admin/pengumuman/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon ion ion-md-megaphone"></span> <?php echo $this->lang->line('left_pengumumans');?>
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
<?php if(in_array('254',$role_resources_ids)) {?>
  <?php $user_info = $this->Umb_model->read_user_info($session['user_id']);?>
  <div class="card mb-4 <?php echo $get_animate;?>">
    <div id="accordion">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_add_new');?></strong> <?php echo $this->lang->line('umb_pengumuman');?></span>
        <div class="card-header-elements ml-md-auto"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
          <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('umb_add_new');?></button>
        </a> </div>
      </div>
      <div id="add_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
        <div class="card-body">
          <?php $attributes = array('name' => 'add_pengumuman', 'id' => 'umb-form', 'autocomplete' => 'off');?>
          <?php $hidden = array('user_id' => $session['user_id']);?>
          <?php echo form_open('admin/pengumuman/add_pengumuman', $attributes, $hidden);?>
          <div class="form-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="title"><?php echo $this->lang->line('umb_title');?></label>
                  <input class="form-control" placeholder="<?php echo $this->lang->line('umb_title');?>" name="title" type="text" value="">
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="start_date"><?php echo $this->lang->line('umb_start_date');?></label>
                      <input class="form-control date" placeholder="<?php echo $this->lang->line('umb_start_date');?>" readonly name="start_date" type="text" value="">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="end_date"><?php echo $this->lang->line('umb_end_date');?></label>
                      <input class="form-control date" placeholder="<?php echo $this->lang->line('umb_end_date');?>" readonly name="end_date" type="text" value="">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <?php if($user_info[0]->user_role_id==1){ ?>
                      <div class="form-group">
                        <label for="penunjukan" class="control-label"><?php echo $this->lang->line('module_title_perusahaan');?></label>
                        <select class="form-control" name="perusahaan_id" id="aj_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_title_perusahaan');?>">
                          <option value=""></option>
                          <?php foreach($get_all_perusahaans as $perusahaan) {?>
                            <option value="<?php echo $perusahaan->perusahaan_id?>"><?php echo $perusahaan->name?></option>
                          <?php } ?>
                        </select>
                      </div>
                    <?php } else {?>
                      <?php $eperusahaan_id = $user_info[0]->perusahaan_id;?>
                      <div class="form-group">
                        <label for="penunjukan" class="control-label"><?php echo $this->lang->line('module_title_perusahaan');?></label>
                        <select class="form-control" name="perusahaan_id" id="aj_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_title_perusahaan');?>">
                          <option value=""></option>
                          <?php foreach($get_all_perusahaans as $perusahaan) {?>
                            <?php if($eperusahaan_id == $perusahaan->perusahaan_id):?>
                              <option value="<?php echo $perusahaan->perusahaan_id?>"><?php echo $perusahaan->name?></option>
                            <?php endif;?>
                          <?php } ?>
                        </select>
                      </div>
                    <?php }?>
                  </div>
                  <div class="col-md-6" id="ajax_location">
                    <div class="form-group">
                      <label for="name"><?php echo $this->lang->line('left_location');?></label>
                      <select disabled="disabled" name="location_id" id="location_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_location');?>">
                        <option value=""></option>
                      </select>
                    </div>
                  </div>
                <!--<div class="col-md-6">
                  <div class="form-group" id="department_ajax">
                    <label for="department" class="control-label"><?php echo $this->lang->line('umb_department');?></label>
                    <select class="form-control" name="department_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_department');?>">
                      <option value=""></option>
                    </select>
                  </div>
                </div>-->
              </div>
            </div>
            <div class="col-md-6">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="description"><?php echo $this->lang->line('umb_description');?></label>
                    <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('umb_description');?>" name="description" cols="8" rows="5" id="description"></textarea>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <div class="form-group" id="department_ajax">
                <label for="department" class="control-label"><?php echo $this->lang->line('umb_department');?></label>
                <select class="form-control" name="department_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_department');?>">
                  <option value=""></option>
                </select>
              </div>
            </div>
            <div class="col-md-8">
              <div class="form-group">
                <label for="summary"><?php echo $this->lang->line('umb_summary');?></label>
                <input type="text" class="form-control" placeholder="<?php echo $this->lang->line('umb_summary');?>" name="summary" id="summary">
              </div>
            </div></div>
            <?php $count_module_attributes = $this->Custom_fields_model->count_pengumumans_module_attributes();?>
            <?php if($count_module_attributes > 0):?>
              <div class="row">
                <?php $module_attributes = $this->Custom_fields_model->pengumumans_hrastral_module_attributes();?>
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
            <div class="form-actions">
              <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('umb_save');?> </button>
            </div>
            <?php echo form_close(); ?> </div>
          </div>
        </div>
      </div>
    </div>
  <?php } ?>
  <div class="card <?php echo $get_animate;?>">
    <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_list_all');?></strong> <?php echo $this->lang->line('umb_pengumumans');?></span> </div>
    <div class="card-body">
      <div class="box-datatable table-responsive">
        <table class="datatables-demo table table-striped table-bordered" id="umb_table">
          <thead>
            <tr>
              <th><?php echo $this->lang->line('umb_action');?></th>
              <th width="380"><?php echo $this->lang->line('umb_title');?></th>
              <th><?php echo $this->lang->line('left_perusahaan');?></th>
              <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('umb_start_date');?></th>
              <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('umb_end_date');?></th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
  <script type="text/javascript">var pengumuman_url = '<?php echo site_url("pengumuman") ?>';</script>