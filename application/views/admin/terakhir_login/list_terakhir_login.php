<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>
<?php $user_info = $this->Umb_model->read_user_info($session['user_id']);?>
<?php if($user_info[0]->user_role_id==1){ ?>
  <div id="filter_hrastral" class="collapse add-formd <?php echo $get_animate;?>" data-parent="#accordion" style="">
    <div class="box mb-4 <?php echo $get_animate;?>">
      <div class="box-header  with-border">
        <h3 class="box-title"><?php echo $this->lang->line('umb_filter');?></h3>
        <div class="box-tools pull-right"> 
          <a class="text-dark collapsed" data-toggle="collapse" href="#filter_hrastral" aria-expanded="false">
            <button type="button" class="btn btn-xs btn-primary"> 
              <span class="fa fa-minus"></span> 
              <?php echo $this->lang->line('umb_hide');?>
            </button>
          </a> 
        </div>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <?php $attributes = array('name' => 'ihr_report', 'id' => 'ihr_report', 'autocomplete' => 'off', 'class' => 'add form-hrm');?>
            <?php $hidden = array('user_id' => $session['user_id']);?>
            <?php echo form_open('admin/karyawans/list_karyawans', $attributes, $hidden);?>
            <?php
            $data = array(
              'type'        => 'hidden',
              'name'        => 'date_format',
              'id'          => 'date_format',
              'value'       => $this->Umb_model->set_date_format(date('Y-m-d')),
              'class'       => 'form-control',
            );
            echo form_input($data);
            ?>
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="first_name"><?php echo $this->lang->line('left_perusahaan');?></label>
                  <select class="form-control" name="perusahaan_id" id="filter_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_perusahaan');?>">
                    <option value="0"><?php echo $this->lang->line('umb_acc_all');?></option>
                    <?php foreach($get_all_perusahaans as $perusahaan) {?>
                      <option value="<?php echo $perusahaan->perusahaan_id?>"><?php echo $perusahaan->name?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-3" id="ajax_flt_location">
                <div class="form-group">
                  <label for="name"><?php echo $this->lang->line('left_location');?></label>
                  <select name="location_id" id="filter_location" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_location');?>">
                    <option value="0"><?php echo $this->lang->line('umb_acc_all');?></option>
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group" id="department_ajaxflt">
                  <label for="department"><?php echo $this->lang->line('left_department');?></label>
                  <select class="form-control" id="filter_department" name="department_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_department');?>" >
                    <option value="0"><?php echo $this->lang->line('umb_acc_all');?></option>
                  </select>
                </div>
              </div>
              <div class="col-md-2" id="penunjukan_ajaxflt">
                <div class="form-group">
                  <label for="penunjukan"><?php echo $this->lang->line('umb_penunjukan');?></label>
                  <select class="form-control" name="penunjukan_id" data-plugin="select_hrm"  id="filter_penunjukan" data-placeholder="<?php echo $this->lang->line('umb_penunjukan');?>">
                    <option value="0"><?php echo $this->lang->line('umb_acc_all');?></option>
                  </select>
                </div>
              </div>
              <div class="col-md-1">
                <label for="penunjukan">&nbsp;</label><?php echo form_button(array('name' => 'hrastral_form', 'type' => 'submit', 'class' => $this->Umb_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('umb_get'))); ?>
              </div>
            </div>
            <!--<div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrastral_form', 'type' => 'submit', 'class' => $this->Umb_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('umb_get'))); ?> </div>-->
            <?php echo form_close(); ?> 
          </div>
        </div>
      </div>
    </div>
  </div>
<?php } ?>
<div class="card <?php echo $get_animate;?>">
  <div class="card-header with-elements"> 
    <span class="card-header-title mr-2">
      <strong><?php echo $this->lang->line('left_karyawans_terakhir_login');?></strong>
    </span> 
  </div>
  <div class="card-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="umb_table">
        <thead>
          <tr>
            <th><?php echo $this->lang->line('umb_karyawans_full_name');?></th>
            <th><?php echo $this->lang->line('dashboard_username');?></th>
            <th><?php echo $this->lang->line('left_perusahaan');?></th>
            <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('dashboard_terakhir_login');?> </th>
            <th><?php echo $this->lang->line('umb_karyawan_role');?></th>
            <th><?php echo $this->lang->line('dashboard_umb_status');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
