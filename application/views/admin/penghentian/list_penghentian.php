<?php
/* penghentian view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>
<?php $role_resources_ids = $this->Umb_model->user_role_resource(); ?>
<?php if(in_array('228',$role_resources_ids)) {?>
<?php $user_info = $this->Umb_model->read_user_info($session['user_id']);?>
<div class="card mb-4 <?php echo $get_animate;?>">
  <div id="accordion">
    <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_add_new');?></strong> <?php echo $this->lang->line('umb_penghentian');?></span>
      <div class="card-header-elements ml-md-auto"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('umb_add_new');?></button>
        </a> </div>
    </div>
    <div id="add_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
      <div class="card-body">
        <?php $attributes = array('name' => 'add_penghentian', 'id' => 'umb-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open('admin/penghentian/add_penghentian', $attributes, $hidden);?>
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
                  <label for="karyawan"><?php echo $this->lang->line('umb_karyawan_terminated');?></label>
                  <select name="karyawan_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_choose_an_karyawan');?>">
                    <option value=""></option>
                  </select>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="tangggal_pemberitahuan"><?php echo $this->lang->line('umb_tangggal_pemberitahuan');?></label>
                      <input class="form-control date" placeholder="<?php echo $this->lang->line('umb_tangggal_pemberitahuan');?>" readonly name="tangggal_pemberitahuan" type="text">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="tanggal_penghentian"><?php echo $this->lang->line('umb_tanggal_penghentian');?></label>
                      <input class="form-control date" placeholder="<?php echo $this->lang->line('umb_tanggal_penghentian');?>" readonly name="tanggal_penghentian" type="text">
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
                      <label for="type"><?php echo $this->lang->line('umb_type_penghentian');?></label>
                      <select class="select2" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_type_penghentian_select');?>" name="type">
                        <option value=""></option>
                        <?php foreach($all_types_penghentian as $type_penghentian) {?>
                        <option value="<?php echo $type_penghentian->type_penghentian_id?>"><?php echo $type_penghentian->type;?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                  <fieldset class="form-group">
                    <label for="attachment"><?php echo $this->lang->line('umb_attachment');?></label>
                    <input type="file" class="form-control-file" id="attachment" name="attachment">
                    <small><?php echo $this->lang->line('umb_perusahaan_file_type');?></small>
                  </fieldset>
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
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_list_all');?></strong> <?php echo $this->lang->line('left_penghentians');?></span> </div>
  <div class="card-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="umb_table">
        <thead>
          <tr>
            <th><?php echo $this->lang->line('umb_action');?></th>
            <th><i class="fa fa-user"></i> <?php echo $this->lang->line('dashboard_single_karyawan');?></th>
            <th><?php echo $this->lang->line('left_perusahaan');?></th>
            <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('umb_tangggal_pemberitahuan');?></th>
            <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('umb_tanggal_penghentian');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
