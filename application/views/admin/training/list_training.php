<?php
/* Training view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>
<?php $role_resources_ids = $this->Umb_model->user_role_resource(); ?>
<?php $user_info = $this->Umb_model->read_user_info($session['user_id']);?>

<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php  if(in_array('54',$role_resources_ids)) {?>
      <li class="nav-item active"> <a href="<?php echo site_url('admin/training/');?>" data-link-data="<?php echo site_url('admin/training/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon fas fa-portrait"></span> <?php echo $this->lang->line('left_training');?>
      <div class="text-muted small"><?php echo $this->lang->line('umb_set_up');?> <?php echo $this->lang->line('left_training');?></div>
    </a> </li>
  <?php } ?>  
  <?php  if(in_array('56',$role_resources_ids)) {?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/trainers/');?>" data-link-data="<?php echo site_url('admin/trainers/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon fas fa-user-graduate"></span> <?php echo $this->lang->line('left_list_trainers');?>
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
<?php if(in_array('341',$role_resources_ids)) {?>
  <div class="card mb-4">
    <div id="accordion">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_add_new');?></strong> <?php echo $this->lang->line('left_training');?></span>
        <div class="card-header-elements ml-md-auto"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
          <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('umb_add_new');?></button>
        </a> </div>
      </div>
      <div id="add_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
        <div class="card-body">
          <?php $attributes = array('name' => 'add_training', 'id' => 'umb-form', 'autocomplete' => 'off');?>
          <?php $hidden = array('_user' => $session['user_id']);?>
          <?php echo form_open('admin/training/add_training', $attributes, $hidden);?>
          <div class="bg-white">
            <div class="box-block">
              <div class="row">
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-12">
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
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="trainer_option"><?php echo $this->lang->line('umb_trainer_opt_title');?></label>
                        <select disabled="disabled" class="form-control" name="trainer_option" id="trainer_option" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_trainer_opt_title');?>">
                          <option value=""></option>
                          <option value="1"><?php echo $this->lang->line('umb_internal_title');?></option>
                          <option value="2"><?php echo $this->lang->line('umb_external_title');?></option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="type_training"><?php echo $this->lang->line('left_type_training');?></label>
                        <select class="form-control" name="type_training" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_type_training');?>">
                          <option value=""></option>
                          <?php foreach($all_types_training as $type_training) {?>
                            <option value="<?php echo $type_training->type_training_id?>"><?php echo $type_training->type?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group" id="trainers_data">
                        <label for="trainer"><?php echo $this->lang->line('umb_trainer');?></label>
                        <select disabled="disabled" class="form-control" name="trainer" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_trainer');?>">
                          <option value=""></option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="biaya_training"><?php echo $this->lang->line('umb_biaya_training');?></label>
                        <input class="form-control" placeholder="<?php echo $this->lang->line('umb_biaya_training');?>" name="biaya_training" type="text" value="">
                      </div>
                    </div>
                  </div>
                  <?php if($user_info[0]->user_role_id==1){?>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group" id="ajax_karyawan">
                          <label for="karyawan" class="control-label"><?php echo $this->lang->line('umb_karyawan');?></label>
                          <select multiple class="form-control" name="karyawan_id[]" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_karyawan');?>">
                            <option value=""></option>
                          </select>
                        </div>
                      </div>
                    </div>
                  <?php } else {?>
                    <input type="hidden" name="karyawan_id[]" id="karyawan_id" value="<?php echo $session['user_id'];?>" />
                    <input type="hidden" name="perusahaan" id="perusahaan_id" value="<?php echo $user_info[0]->perusahaan_id;?>" />
                  <?php } ?>
                </div>
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="description"><?php echo $this->lang->line('umb_description');?></label>
                        <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('umb_description');?>" name="description" rows="5" id="description"></textarea>
                      </div>
                    </div>
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
                </div>
              </div>
              <?php $count_module_attributes = $this->Custom_fields_model->count_training_module_attributes();?>
              <?php if($count_module_attributes > 0):?>
                <div class="row">
                  <?php $module_attributes = $this->Custom_fields_model->training_hrastral_module_attributes();?>
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
            </div>
          </div>
          <?php echo form_close(); ?> </div>
        </div>
      </div>
    </div>
  <?php } ?>
  <div class="card">
    <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_list_all');?></strong> <?php echo $this->lang->line('left_training');?></span> </div>
    <div class="card-body">
      <div class="box-datatable table-responsive">
        <table class="datatables-demo table table-striped table-bordered" id="umb_table">
          <thead>
            <tr>
              <th><?php echo $this->lang->line('umb_action');?></th>
              <th><?php echo $this->lang->line('left_type_training');?></th>
              <th><i class="fa fa-users"></i> <?php echo $this->lang->line('umb_karyawan');?></th>
              <th><?php echo $this->lang->line('left_perusahaan');?></th>
              <th><?php echo $this->lang->line('umb_trainer');?></th>
              <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('umb_durasi_training');?></th>
              <th><i class="fa fa-dollar"></i> <?php echo $this->lang->line('umb_cost');?></th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
