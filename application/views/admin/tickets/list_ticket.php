<?php
$session = $this->session->userdata('username');
?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>
<?php $role_resources_ids = $this->Umb_model->user_role_resource(); ?>
<?php $user_info = $this->Umb_model->read_info_karyawan($session['user_id']);?>
<?php if(in_array('306',$role_resources_ids)) {?>
  <div class="card mb-4 <?php echo $get_animate;?>">
    <div id="accordion">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_create_new_ticket');?></strong></span>
        <div class="card-header-elements ml-md-auto">
          <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
            <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('umb_add_new');?></button>
          </a> </div>
        </div>
        <div id="add_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
          <div class="card-body">
            <?php $attributes = array('name' => 'add_ticket', 'id' => 'umb-form', 'autocomplete' => 'off');?>
            <?php $hidden = array('user_id' => $session['user_id']);?>
            <?php echo form_open('admin/tickets/add_ticket', $attributes, $hidden);?>
            <div class="bg-white">
              <div class="box-block">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="nama_perusahaan"><?php echo $this->lang->line('module_title_perusahaan');?></label>
                      <?php if(!in_array('384',$role_resources_ids)) { ?>
                        <select class="form-control" name="perusahaan" id="aj_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_title_perusahaan');?>">
                          <option value=""><?php echo $this->lang->line('umb_select_one');?></option>
                          <?php foreach($all_perusahaans as $perusahaan) {?>
                            <option value="<?php echo $perusahaan->perusahaan_id;?>"> <?php echo $perusahaan->name;?></option>
                          <?php } ?>
                        </select>
                      <?php } else {?>
                        <select disabled="disabled" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_title_perusahaan');?>">
                          <option value=""><?php echo $this->lang->line('umb_select_one');?></option>
                          <?php foreach($all_perusahaans as $perusahaan) {?>
                            <option value="<?php echo $perusahaan->perusahaan_id;?>" <?php if($user_info[0]->perusahaan_id==$perusahaan->perusahaan_id):?> selected="selected" <?php endif;?>> <?php echo $perusahaan->name;?></option>
                          <?php } ?>
                        </select>
                        <input type="hidden" name="perusahaan" value="<?php foreach($all_perusahaans as $perusahaan) {?><?php if($user_info[0]->perusahaan_id==$perusahaan->perusahaan_id):?><?php echo $perusahaan->perusahaan_id;?><?php endif;?><?php } ?>" />
                      <?php } ?>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="nama_tugas"><?php echo $this->lang->line('umb_subject');?></label>
                          <input class="form-control" placeholder="<?php echo $this->lang->line('umb_subject');?>" name="subject" type="text" value="">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group" id="department_ajaxflt">
                          <label for="department"><?php echo $this->lang->line('left_department');?></label>
                          <select class="form-control" name="department_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_karyawan_department');?>" disabled="disabled">
                            <option value=""></option>
                          </select>
                        </div>
                      </div>
                    </div>
                    
                    <div class="row">
                      <?php $colmd = 'col-md-6';?>
                      <?php if(!in_array('384',$role_resources_ids)) { ?>
                        <?php $colmd = 'col-md-6';?>
                        <div class="col-md-6">
                          <div class="form-group" id="ajax_karyawan">
                            <label for="karyawans"><?php echo $this->lang->line('umb_ticket_for_karyawan');?></label>
                            <select class="form-control" name="karyawan_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('dashboard_single_karyawan');?>">
                              <option value=""></option>
                            </select>
                          </div>
                        </div>
                      <?php } else {?>
                        <?php $colmd = 'col-md-12'; ?>
                        <input type="hidden" name="karyawan_id" value="<?php echo $session['user_id'];?>" />
                      <?php } ?>
                      <div class="<?php echo $colmd;?>">
                        <div class="form-group">
                          <label for="ticket_priority" class="control-label"><?php echo $this->lang->line('umb_p_priority');?></label>
                          <select name="ticket_priority" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_select_priority');?>">
                            <option value=""></option>
                            <option value="1"><?php echo $this->lang->line('umb_low');?></option>
                            <option value="2"><?php echo $this->lang->line('umb_medium');?></option>
                            <option value="3"><?php echo $this->lang->line('umb_high');?></option>
                            <option value="4"><?php echo $this->lang->line('umb_critical');?></option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="end_date"><?php echo $this->lang->line('umb_end_date');?></label>
                          <input class="form-control date" placeholder="<?php echo $this->lang->line('umb_end_date');?>" name="end_date" type="text" value="">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="attachment"><?php echo $this->lang->line('umb_attachment');?></label>
                          <input type="file" name="attachment" id="attachment" />
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="description"><?php echo $this->lang->line('umb_ticket_description');?></label>
                      <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('umb_ticket_description');?>" name="description" cols="30" rows="5" id="description"></textarea>
                    </div>
                  </div>
                </div>
                <?php $count_module_attributes = $this->Custom_fields_model->count_tickets_module_attributes();?>
                <?php if($count_module_attributes > 0):?>
                  <div class="row">
                    <?php $module_attributes = $this->Custom_fields_model->tickets_hrastral_module_attributes();?>
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
    <div class="card <?php echo $get_animate;?>">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_list_all');?></strong> <?php echo $this->lang->line('left_tickets');?></span>
      </div>
      <div class="card-body">
        <div class="box-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="umb_table">
            <thead>
              <tr class="umb-bg-dark">
                <th><?php echo $this->lang->line('umb_action');?></th>
                <th><?php echo $this->lang->line('umb_kode_ticket');?></th>
                <th><i class="fa fa-user"></i> <?php echo $this->lang->line('dashboard_single_karyawan');?></th>
                <th><?php echo $this->lang->line('umb_subject');?></th>
                <th><?php echo $this->lang->line('umb_p_priority');?></th>
                <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('umb_e_details_tanggal');?></th>
                <th><i class="fa fa-user"></i> <?php echo $this->lang->line('umb_created_by');?></th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
