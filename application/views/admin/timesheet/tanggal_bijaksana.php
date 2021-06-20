<?php $session = $this->session->userdata('username');?>
<?php $role_resources_ids = $this->Umb_model->user_role_resource(); ?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>
<?php $user = $this->Umb_model->read_user_info($session['user_id']);?>
<div class="box mb-4 <?php echo $get_animate;?>">
  <div class="box-body">
    <div class="row">
      <div class="col-md-12">
        <?php $attributes = array('name' => 'laporan_tanggalbijaksana_kehadiran', 'id' => 'laporan_tanggalbijaksana_kehadiran', 'autocomplete' => 'off', 'class' => 'add form-hrm');?>
        <?php $hidden = array('euser_id' => $session['user_id']);?>
        <?php echo form_open('admin/timesheet/list_tanggalbijaksana_kehadiran', $attributes, $hidden);?>
        <?php
        $data = array(
          'type'        => 'hidden',
          'name'        => 'user_id',
          'id'          => 'user_id',
          'value'       => $session['user_id'],
          'class'       => 'form-control',
        );
        echo form_input($data);
        ?>
        <div class="row">
          <div class="col-md-5">
            <div class="form-group">
              <label for="umb_start_date"><?php echo $this->lang->line('umb_start_date');?></label>
              <input class="form-control tanggal_kehadiran" placeholder="<?php echo $this->lang->line('umb_select_date');?>" readonly id="start_date" name="start_date" type="text" value="<?php echo date('Y-m-d');?>">
            </div>
          </div>
          <div class="col-md-5">
            <div class="form-group">
              <label for="umb_end_date"><?php echo $this->lang->line('umb_end_date');?></label>
              <input class="form-control tanggal_kehadiran" placeholder="<?php echo $this->lang->line('umb_select_date');?>" readonly id="end_date" name="end_date" type="text" value="<?php echo date('Y-m-d');?>">
            </div>
          </div>
          <?php if(!in_array('381',$role_resources_ids) && $user[0]->user_role_id!=1) {?>
            <div class="col-md-2">
              <div class="form-group"><label for="umb_start_date">&nbsp;</label><br />
                <button type="submit" class="btn btn-primary save"><?php echo $this->lang->line('umb_get');?></button>
              </div>
            </div>
          <?php } ?>
        </div>
        <?php /*?><?php if(in_array('381',$role_resources_ids) && $user[0]->user_role_id!=1) {?>
        <?php $result = $this->Department_model->ajax_info_perusahaan_karyawan($user[0]->perusahaan_id);?>
        <input type="hidden" name="perusahaan_id" value="<?php echo $user[0]->perusahaan_id?>" />
        <div class="row">
          <div class="col-md-5">
            <div class="form-group" id="ajax_karyawan">
              <select name="karyawan_id" id="karyawan_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_choose_an_karyawan');?>" required>
                <?php foreach($result as $karyawan) {?>
                <option value=""></option>
                <option value="<?php echo $karyawan->user_id;?>"> <?php echo $karyawan->first_name.' '.$karyawan->last_name;?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group"> &nbsp;
              <button type="submit" class="btn btn-primary save"><?php echo $this->lang->line('umb_get');?></button>
            </div>
          </div>
        </div>
      <?php } ?><?php */?>
      <?php if($user[0]->user_role_id==1 || in_array('381',$role_resources_ids)) {?>
        <div class="row">
          <div class="col-md-5">
            <?php if($user[0]->user_role_id==1){?>
              <div class="form-group">
                <select class="form-control" name="perusahaan_id" id="aj_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_perusahaan');?>">
                  <option value=""></option>
                  <?php foreach($get_all_perusahaans as $perusahaan) {?>
                    <option value="<?php echo $perusahaan->perusahaan_id?>"><?php echo $perusahaan->name?></option>
                  <?php } ?>
                </select>
              </div>
            <?php } else {?>
              <div class="form-group">
                <select class="form-control" name="perusahaan_id" id="aj_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_perusahaan');?>">
                  <option value=""></option>
                  <?php foreach($get_all_perusahaans as $perusahaan) {?>
                   <?php if($user[0]->perusahaan_id == $perusahaan->perusahaan_id):?>
                    <option value="<?php echo $perusahaan->perusahaan_id?>"><?php echo $perusahaan->name?></option>
                  <?php endif;?>
                <?php } ?>
              </select>
            </div>
          <?php } ?>
        </div>
        <div class="col-md-5">
          <div class="form-group" id="ajax_karyawan">
            <select name="karyawan_id" id="karyawan_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_choose_an_karyawan');?>" required>
              <option value="">All</option>
            </select>
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group"> &nbsp;
            <button type="submit" class="btn btn-primary save"><?php echo $this->lang->line('umb_get');?></button>
          </div>
        </div>
      </div>
    <?php } ?>
    <?php echo form_close(); ?> </div>
  </div>
</div>
</div>
<div class="box <?php echo $get_animate;?>">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $this->lang->line('dashboard_kehadiran');?></h3>
  </div>
  <div class="box-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="umb_table">
        <thead>
          <tr>
            <th colspan="3"><?php echo $this->lang->line('umb_hr_info');?></th>
            <th colspan="9"><?php echo $this->lang->line('umb_kehadiran_report');?></th>
          </tr>
          <tr>
            <th style="width:120px;"><?php echo $this->lang->line('umb_karyawan');?></th>
            <th style="width:120px;"><?php echo $this->lang->line('dashboard_karyawan_id');?></th>
            <th style="width:100px;"><?php echo $this->lang->line('left_perusahaan');?></th>
            <th style="width:120px;"><?php echo $this->lang->line('dashboard_umb_status');?></th>
            <th style="width:120px;"><?php echo $this->lang->line('umb_e_details_tanggal');?></th>
            <th style="width:120px;"><?php echo $this->lang->line('dashboard_clock_in');?></th>
            <th style="width:120px;"><?php echo $this->lang->line('dashboard_clock_out');?></th>
            <th style="width:120px;"><?php echo $this->lang->line('dashboard_late');?></th>
            <th style="width:120px;"><?php echo $this->lang->line('dashboard_early_leaving');?></th>
            <th style="width:120px;"><?php echo $this->lang->line('dashboard_lembur');?></th>
            <th style="width:120px;"><?php echo $this->lang->line('dashboard_total_kerja');?></th>
            <th style="width:120px;"><?php echo $this->lang->line('dashboard_total_istirahat');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
