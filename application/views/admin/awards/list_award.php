<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>
<?php $role_resources_ids = $this->Umb_model->user_role_resource(); ?>
<?php if(in_array('207',$role_resources_ids)) {?>
  <?php $user_info = $this->Umb_model->read_user_info($session['user_id']);?>
  <div class="card mb-4 <?php echo $get_animate;?>">
    <div id="accordion">
      <div class="card-header with-elements"> 
        <span class="card-header-title mr-2">
          <strong><?php echo $this->lang->line('umb_add_new');?></strong> 
          <?php echo $this->lang->line('umb_award');?>
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
          <?php $attributes = array('name' => 'add_award', 'id' => 'umb-form', 'autocomplete' => 'off');?>
          <?php $hidden = array('_user' => $session['user_id']);?>
          <?php echo form_open('admin/awards/add_award', $attributes, $hidden);?>
          <div class="bg-white">
            <div class="box-block">
              <div class="row">
                <div class="col-md-6">
                  <?php if($user_info[0]->user_role_id==1){ ?>
                    <div class="form-group">
                      <label for="first_name"><?php echo $this->lang->line('left_perusahaan');?></label>
                      <select class="form-control" name="perusahaan_id" id="aj_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_perusahaan');?>">
                        <option value=""></option>
                        <?php foreach($get_all_perusahaans as $perusahaan) {?>
                          <option value="<?php echo $perusahaan->perusahaan_id?>"><?php echo $perusahaan->name?></option>
                        <?php } ?>
                      </select>
                    </div>
                  <?php } else {?>
                    <?php $eperusahaan_id = $user_info[0]->perusahaan_id;?>
                    <div class="form-group">
                      <label for="first_name"><?php echo $this->lang->line('left_perusahaan');?></label>
                      <select class="form-control" name="perusahaan_id" id="aj_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_perusahaan');?>">
                        <option value=""></option>
                        <?php foreach($get_all_perusahaans as $perusahaan) {?>
                          <?php if($eperusahaan_id == $perusahaan->perusahaan_id):?>
                            <option value="<?php echo $perusahaan->perusahaan_id?>"><?php echo $perusahaan->name?></option>
                          <?php endif;?>
                        <?php } ?>
                      </select>
                    </div>
                  <?php } ?>
                  <div class="form-group" id="ajax_karyawan">
                    <label for="karyawan"><?php echo $this->lang->line('dashboard_single_karyawan');?></label>
                    <select name="karyawan_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_choose_an_karyawan');?>">
                      <option value=""></option>
                    </select>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="type_award"><?php echo $this->lang->line('umb_type_award');?></label>
                        <select name="type_award_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_type_award');?>">
                          <option value=""></option>
                          <?php foreach($all_types_award as $type_award) {?>
                            <option value="<?php echo $type_award->type_award_id;?>"><?php echo $type_award->type_award;?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="tanggal_award"><?php echo $this->lang->line('umb_e_details_tanggal');?></label>
                        <input class="form-control date" placeholder="<?php echo $this->lang->line('umb_tanggal_penghargaan');?>" readonly name="tanggal_award" type="text" value="">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="description"><?php echo $this->lang->line('umb_description');?></label>
                        <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('umb_description');?>" name="description" cols="30" rows="5" id="description"></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="month_year"><?php echo $this->lang->line('umb_bulan_tahun_penghargaan');?></label>
                        <input class="form-control hr_month_year" placeholder="<?php echo $this->lang->line('umb_bulan_tahun_penghargaan');?>" readonly name="month_year" type="text">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="gift"><?php echo $this->lang->line('umb_gift');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('umb_gift');?>" name="gift" type="text">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="cash"><?php echo $this->lang->line('umb_cash');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('umb_cash');?>" name="cash" type="text">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <fieldset class="form-group">
                      <label for="logo"><?php echo $this->lang->line('umb_photo_award');?></label>
                      <input type="file" class="form-control-file" id="picture_award" name="picture_award">
                      <small><?php echo $this->lang->line('umb_perusahaan_file_type');?></small>
                    </fieldset>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="informasi_award"><?php echo $this->lang->line('umb_info_award');?></label>
                    <textarea class="form-control" placeholder="<?php echo $this->lang->line('umb_info_award');?>" name="informasi_award" cols="30" rows="3" id="informasi_award"></textarea>
                  </div>
                </div>
              </div>
              <?php $count_module_attributes = $this->Custom_fields_model->count_awards_module_attributes();?>
              <?php if($count_module_attributes > 0):?>
                <div class="row">
                  <?php $module_attributes = $this->Custom_fields_model->awards_hrastral_module_attributes();?>
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
              <div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrastral_form', 'type' => 'submit', 'class' => $this->Umb_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('umb_save'))); ?> </div>
            </div>
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
      <?php echo $this->lang->line('left_awards');?>
    </span> 
  </div>
  <div class="card-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="umb_table">
        <thead>
          <tr>
            <th style="width:120px;"><?php echo $this->lang->line('umb_action');?></th>
            <th width="350">
              <i class="fa fa-trophy"></i> 
              <?php echo $this->lang->line('umb_nama_award');?>
            </th>
            <th>
              <i class="fa fa-user"></i> 
              <?php echo $this->lang->line('umb_karyawans_full_name');?>
            </th>
            <th><?php echo $this->lang->line('left_perusahaan');?></th>
            <th>
              <i class="fa fa-gift"></i> 
              <?php echo $this->lang->line('umb_gift');?>
            </th>
            <th>
              <i class="fa fa-calendar"></i> 
              <?php echo $this->lang->line('umb_bulan_tahun_penghargaan');?>
            </th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
<style type="text/css">
  .hide-calendar .ui-datepicker-calendar { display:none !important; }
  .hide-calendar .ui-priority-secondary { display:none !important; }
</style>