<?php
/* karyawan Exit view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>
<?php $role_resources_ids = $this->Umb_model->user_role_resource(); ?>
<?php $xuser_info = $this->Umb_model->read_user_info($session['user_id']);?>
<?php if($xuser_info[0]->user_role_id==1){ ?>
  <div id="filter_hrastral" class="collapse add-formd <?php echo $get_animate;?>" data-parent="#accordion" style="">
    <div class="row">
      <div class="col-md-12">
        <div class="box mb-4">
          <div class="box-header  with-border">
            <h3 class="box-title"><?php echo $this->lang->line('umb_filter');?></h3>
            <div class="box-tools pull-right"> <a class="text-dark collapsed" data-toggle="collapse" href="#filter_hrastral" aria-expanded="false">
              <button type="button" class="btn btn-xs btn-primary"> <span class="fa fa-minus"></span> <?php echo $this->lang->line('umb_hide');?></button>
            </a> </div>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <?php $attributes = array('name' => 'ihr_report', 'id' => 'ihr_report', 'class' => 'm-b-1 add form-hrm');?>
                <?php $hidden = array('user_id' => $session['user_id']);?>
                <?php echo form_open('admin/karyawan_exit/list_exit', $attributes, $hidden);?>
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="department"><?php echo $this->lang->line('module_title_perusahaan');?></label>
                      <select class="form-control" name="perusahaan" id="aj_perusahaanf" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_title_perusahaan');?>" required>
                        <option value="0"><?php echo $this->lang->line('umb_all_perusahaans');?></option>
                        <?php foreach($get_all_perusahaans as $perusahaan) {?>
                          <option value="<?php echo $perusahaan->perusahaan_id;?>"> <?php echo $perusahaan->name;?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group" id="ajax_f_karyawan">
                      <label for="department"><?php echo $this->lang->line('dashboard_single_karyawan');?></label>
                      <select id="karyawan_id" name="karyawan_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_choose_an_karyawan');?>">
                        <option value="0"><?php echo $this->lang->line('umb_all_karyawans');?></option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="status"><?php echo $this->lang->line('umb_exit_interview');?></label>
                      <select class="form-control" name="status" id="status" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('dashboard_umb_status');?>">
                        <option value="all" ><?php echo $this->lang->line('umb_acc_all');?></option>
                        <option value="1"><?php echo $this->lang->line('umb_yes');?></option>
                        <option value="0"><?php echo $this->lang->line('umb_no');?></option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-1"><label for="umb_get">&nbsp;</label><button name="hrastral_form" type="submit" class="btn btn-primary"><i class="fas fa-check-square"></i> <?php echo $this->lang->line('umb_get');?></button>
                  </div>
                </div>
                
                <?php echo form_close(); ?> </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php } ?>
  <?php if(in_array('204',$role_resources_ids)) {?>
    <?php $user_info = $this->Umb_model->read_user_info($session['user_id']);?>
    <div class="card mb-4 <?php echo $get_animate;?>">
      <div id="accordion">
        <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_add_new');?></strong> <?php echo $this->lang->line('umb_karyawan_exit');?></span>
          <div class="card-header-elements ml-md-auto"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
            <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('umb_add_new');?></button>
          </a> </div>
        </div>
        <div id="add_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
          <div class="card-body">
            <?php $attributes = array('name' => 'add_exit', 'id' => 'umb-form', 'autocomplete' => 'off');?>
            <?php $hidden = array('user_id' => $session['user_id']);?>
            <?php echo form_open('admin/karyawan_exit/add_exit', $attributes, $hidden);?>
            <div class="bg-white">
              <div class="box-block">
                <div class="row">
                  <div class="col-md-6">
                    <?php if($user_info[0]->user_role_id==1){ ?>
                      <div class="form-group">
                        <label for="first_name"><?php echo $this->lang->line('left_perusahaan');?><i class="hrastral-asterisk">*</i></label>
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
                        <label for="first_name"><?php echo $this->lang->line('left_perusahaan');?><i class="hrastral-asterisk">*</i></label>
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
                      <label for="karyawan"><?php echo $this->lang->line('umb_karyawan_to_exit');?><i class="hrastral-asterisk">*</i></label>
                      <select disabled="disabled" name="karyawan_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_choose_an_karyawan');?>">
                        <option value=""></option>
                      </select>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="exit_tanggal"><?php echo $this->lang->line('umb_exit_tanggal');?><i class="hrastral-asterisk">*</i></label>
                          <input class="form-control date" placeholder="<?php echo $this->lang->line('umb_exit_tanggal');?>" readonly name="exit_tanggal" type="text">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="type"><?php echo $this->lang->line('umb_type_of_exit');?><i class="hrastral-asterisk">*</i></label>
                          <select class="select2" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_type_of_exit');?>" name="type">
                            <option value=""></option>
                            <?php foreach($all_types_exit as $type_exit) {?>
                              <option value="<?php echo $type_exit->type_exit_id?>"><?php echo $type_exit->type;?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="description"><?php echo $this->lang->line('umb_description');?></label>
                          <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('umb_description');?>" name="reason" rows="5" id="reason"></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="exit_interview"><?php echo $this->lang->line('umb_exit_interview');?><i class="hrastral-asterisk">*</i></label>
                          <select class="select2" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_exit_interview');?>" name="exit_interview">
                            <option value="1"><?php echo $this->lang->line('umb_yes');?></option>
                            <option value="0"><?php echo $this->lang->line('umb_no');?></option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="is_inactivate_account"><?php echo $this->lang->line('umb_exit_inactive_karyawan_account');?><i class="hrastral-asterisk">*</i></label>
                          <select class="select2" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_exit_inactive_karyawan_account');?>" name="is_inactivate_account">
                            <option value="1"><?php echo $this->lang->line('umb_yes');?></option>
                            <option value="0"><?php echo $this->lang->line('umb_no');?></option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
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
    <div class="card <?php echo $get_animate;?>">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_list_all');?></strong> <?php echo $this->lang->line('umb_karyawan_exit');?></span> </div>
      <div class="card-body">
        <div class="card-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="umb_table">
            <thead>
              <tr>
                <th style="width:96px;"><?php echo $this->lang->line('umb_action');?></th>
                <th width="380"><i class="fa fa-user"></i> <?php echo $this->lang->line('dashboard_single_karyawan');?></th>
                <th><?php echo $this->lang->line('left_perusahaan');?></th>
                <th><?php echo $this->lang->line('umb_type_exit');?></th>
                <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('umb_exit_tanggal');?></th>
                <th><?php echo $this->lang->line('umb_exit_interview');?></th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
