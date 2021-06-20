<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>
<?php $xuser_info = $this->Umb_model->read_user_info($session['user_id']);?>
<?php $role_resources_ids = $this->Umb_model->user_role_resource();?>
<?php if($xuser_info[0]->user_role_id==1){ ?>
  <div class="ui-bordered px-4 pt-4 mb-4 mt-3">
    <?php $attributes = array('name' => 'ihr_report', 'id' => 'ihr_report', 'class' => 'm-b-1 add form-hrm');?>
    <?php $hidden = array('user_id' => $session['user_id']);?>
    <?php echo form_open('admin/timesheet/list_liburan', $attributes, $hidden);?>
    <div class="form-row">
      <div class="col-md mb-3">
        <label for="department"><?php echo $this->lang->line('module_title_perusahaan');?></label>
        <select class="form-control" name="perusahaan" id="aj_perusahaanf" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_title_perusahaan');?>" required>
          <option value="0"><?php echo $this->lang->line('umb_all_perusahaans');?></option>
          <?php foreach($get_all_perusahaans as $perusahaan) {?>
            <option value="<?php echo $perusahaan->perusahaan_id;?>"> <?php echo $perusahaan->name;?></option>
          <?php } ?>
        </select>
      </div>
      <div class="col-md mb-3" id="ajax_flt_location">
        <label for="status"><?php echo $this->lang->line('dashboard_umb_status');?></label>
        <select class="form-control" name="status" id="status" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('dashboard_umb_status');?>">
          <option value="all" ><?php echo $this->lang->line('umb_acc_all');?></option>
          <option value="1"><?php echo $this->lang->line('umb_published');?></option>
          <option value="0"><?php echo $this->lang->line('umb_unpublished');?></option>
        </select>
      </div>
      <div class="col-md col-xl-2 mb-4">
        <label class="form-label d-none d-md-block">&nbsp;</label>
        <?php echo form_button(array('name' => 'hrastral_form', 'type' => 'submit', 'class' => 'btn btn-secondary btn-block', 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('umb_get'))); ?> </div>
      </div>
      <?php echo form_close(); ?> </div>
    <?php } ?>
    <div class="row m-b-1 <?php echo $get_animate;?>">
      <?php $role_resources_ids = $this->Umb_model->user_role_resource(); ?>
      <?php if(in_array('283',$role_resources_ids)) {?>
        <?php $user_info = $this->Umb_model->read_user_info($session['user_id']);?>
        <div class="col-md-4">
          <div class="card">
            <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_add_new');?></strong> <?php echo $this->lang->line('umb_libur');?></span> </div>
            <div class="card-body">
              <?php $attributes = array('name' => 'add_libur', 'id' => 'umb-form', 'autocomplete' => 'off');?>
              <?php $hidden = array('user_id' => $session['user_id']);?>
              <?php echo form_open('admin/timesheet/add_libur', $attributes, $hidden);?>
              <div class="row">
                <div class="col-md-12">
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
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="name"><?php echo $this->lang->line('umb_event_name');?></label>
                  <input type="text" class="form-control" name="event_name" placeholder="<?php echo $this->lang->line('umb_event_name');?>">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="start_date"><?php echo $this->lang->line('umb_start_date');?></label>
                  <input class="form-control date" placeholder="<?php echo $this->lang->line('umb_start_date');?>" readonly name="start_date" type="text">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="end_date"><?php echo $this->lang->line('umb_end_date');?></label>
                  <input class="form-control date" placeholder="<?php echo $this->lang->line('umb_end_date');?>" readonly name="end_date" type="text">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="description"><?php echo $this->lang->line('umb_description');?></label>
                  <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('umb_description');?>" name="description" id="description"></textarea>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="is_publish"><?php echo $this->lang->line('dashboard_umb_status');?></label>
                  <select name="is_publish" class="select2" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_choose_status');?>">
                    <option value="1"><?php echo $this->lang->line('umb_published');?></option>
                    <option value="0"><?php echo $this->lang->line('umb_unpublished');?></option>
                  </select>
                </div>
              </div>
            </div>
            <div class="form-actions box-footer">
              <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('umb_save');?> </button>
            </div>
            <?php echo form_close(); ?> </div>
          </div>
        </div>
        <?php $colmdval = 'col-md-8';?>
      <?php } else {?>
        <?php $colmdval = 'col-md-12';?>
      <?php } ?>
      <div class="<?php echo $colmdval;?>">
        <div class="card">
          <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_list_all');?></strong> <?php echo $this->lang->line('left_liburan');?></span> </div>
          <div class="card-body">
            <div class="box-datatable table-responsive">
              <table class="datatables-demo table table-striped table-bordered" id="umb_table">
                <thead>
                  <tr>
                    <th style="width:100px;"><?php echo $this->lang->line('umb_action');?></th>
                    <th width="250"><?php echo $this->lang->line('umb_event_name');?></th>
                    <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('umb_start_date');?></th>
                    <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('umb_end_date');?></th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <style type="text/css">
      .trumbowyg-editor { min-height:110px !important; }
    </style>
