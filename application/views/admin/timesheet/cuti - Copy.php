<?php $session = $this->session->userdata('username');?>
<?php $user = $this->Umb_model->read_info_karyawan($session['user_id']);?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>
<?php $role_resources_ids = $this->Umb_model->user_role_resource(); ?>
<?php if(in_array('287',$role_resources_ids)) {?>
  <?php $kategoris_cuti = $user[0]->kategoris_cuti;?>
  <div class="box mb-4 <?php echo $get_animate;?>">
    <div id="accordion">
      <div class="box-header with-border">
        <h3 class="box-title"><?php echo $this->lang->line('umb_add_cuti');?></h3>
        <div class="box-tools pull-right"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
          <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('umb_add_new');?></button>
        </a> </div>
      </div>
      <div id="add_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
        <div class="box-body">
          <?php $attributes = array('name' => 'add_cuti', 'id' => 'umb-form', 'autocomplete' => 'off');?>
          <?php $hidden = array('_user' => $session['user_id']);?>
          <?php echo form_open('admin/timesheet/add_cuti', $attributes, $hidden);?>
          <?php $leaave_cat = get_kategori_karyawan_cuti($kategoris_cuti,$session['user_id']);?>
          <div class="bg-white">
            <div class="box-block">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="type_cuti" class="control-label"><?php echo $this->lang->line('umb_type_cuti');?></label>
                    <select class="form-control" id="type_cuti" name="type_cuti" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_type_cuti');?>">
                      <option value=""></option>
                      <?php foreach($leaave_cat as $type) {?>
                        <option value="<?php echo $type->type_cuti_id;?>"> <?php echo $type->type_name;?></option>
                      <?php } ?>
                    </select>
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
                  <?php $role_resources_ids = $this->Umb_model->user_role_resource();
                  if(!in_array('383',$role_resources_ids)) { ?>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="first_name"><?php echo $this->lang->line('left_perusahaan');?></label>
                          <select class="form-control" name="perusahaan_id" id="aj_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_perusahaan');?>">
                            <option value=""></option>
                            <?php foreach($get_all_perusahaans as $perusahaan) {?>
                              <option value="<?php echo $perusahaan->perusahaan_id?>"><?php echo $perusahaan->name?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group" id="ajax_karyawan">
                          <label for="karyawans" class="control-label"><?php echo $this->lang->line('umb_karyawan');?></label>
                          <select disabled="disabled" class="form-control" name="karyawan_id" id="karyawan_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_choose_an_karyawan');?>">
                            <option value=""></option>
                          </select>
                        </div>
                      </div>
                    </div>
                  <?php } else {?>
                    <input type="hidden" name="karyawan_id" id="karyawan_id" value="<?php echo $session['user_id'];?>" />
                    <input type="hidden" name="perusahaan_id" id="perusahaan_id" value="<?php echo $user[0]->perusahaan_id;?>" />
                  <?php } ?>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="description"><?php echo $this->lang->line('umb_keterangan');?></label>
                    <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('umb_keterangan');?>" name="remarks" rows="5"></textarea>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="summary"><?php echo $this->lang->line('umb_alasan_cuti');?></label>
                <textarea class="form-control" placeholder="<?php echo $this->lang->line('umb_alasan_cuti');?>" name="reason" cols="30" rows="3" id="reason"></textarea>
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
  <div class="box <?php echo $get_animate;?>">
    <div class="box-header with-border">
      <h3 class="box-title"><?php echo $this->lang->line('umb_list_all');?> <?php echo $this->lang->line('left_cuti');?></h3>
    </div>
    <div class="box-body">
      <div class="box-datatable table-responsive">
        <table class="datatables-demo table table-striped table-bordered" id="umb_table">
          <thead>
            <tr>
              <th><?php echo $this->lang->line('umb_action');?></th>
              <th><?php echo $this->lang->line('umb_karyawan');?></th>
              <th><?php echo $this->lang->line('umb_type_cuti');?></th>
              <th><?php echo $this->lang->line('umb_cuti_duration');?></th>
              <th><?php echo $this->lang->line('umb_applied_on');?></th>
              <th><?php echo $this->lang->line('umb_alasan');?></th>
              <th><?php echo $this->lang->line('dashboard_umb_status');?></th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
