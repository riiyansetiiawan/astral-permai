<?php
/* karyawans report view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $_tugass = $this->Timesheet_model->get_tugass();?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>
<?php $user_info = $this->Umb_model->read_user_info($session['user_id']);?>
<div class="row">
  <div class="col-md-12 <?php echo $get_animate;?>">
    <div class="ui-bordered px-4 pt-4 mb-4">
      <input type="hidden" id="user_id" value="0" />
      <?php $attributes = array('name' => 'laporans_karyawan', 'id' => 'laporans_karyawan', 'autocomplete' => 'off', 'class' => 'add form-hrm');?>
      <?php $hidden = array('euser_id' => $session['user_id']);?>
      <?php echo form_open('admin/laporans/laporans_karyawan', $attributes, $hidden);?>
      <?php
      $data = array(
        'name'        => 'user_id',
        'id'          => 'user_id',
        'type'        => 'hidden',
        'value'   	   => $session['user_id'],
        'class'       => 'form-control',
      );
      echo form_input($data);
      ?> 
      <div class="form-row">
        <?php if($user_info[0]->user_role_id==1){ ?>
          <div class="col-md mb-3">
            <label class="form-label"><?php echo $this->lang->line('left_perusahaan');?></label>
            <select class="form-control" name="perusahaan_id" id="aj_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_perusahaan');?>">
              <option value="0"><?php echo $this->lang->line('umb_acc_all');?></option>
              <?php foreach($all_perusahaans as $perusahaan) {?>
                <option value="<?php echo $perusahaan->perusahaan_id?>"><?php echo $perusahaan->name?></option>
              <?php } ?>
            </select>
          </div>
        <?php } else {?>
          <?php $eperusahaan_id = $user_info[0]->perusahaan_id;?>
          <div class="col-md mb-3">
            <label class="form-label"><?php echo $this->lang->line('left_perusahaan');?></label>
            <select class="form-control" name="perusahaan_id" id="aj_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_perusahaan');?>">
              <option value=""><?php echo $this->lang->line('left_perusahaan');?></option>
              <?php foreach($all_perusahaans as $perusahaan) {?>
                <?php if($eperusahaan_id == $perusahaan->perusahaan_id):?>
                  <option value="<?php echo $perusahaan->perusahaan_id?>"><?php echo $perusahaan->name?></option>
                <?php endif;?>
              <?php } ?>
            </select>
          </div>
        <?php } ?>
        <div class="col-md mb-3">
          <div class="form-group" id="department_ajax">
            <label class="form-label"><?php echo $this->lang->line('umb_karyawan_department');?></label>
            <select disabled="disabled" class="form-control" name="department_id" id="department_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_karyawan_department');?>">
              <option value="0"><?php echo $this->lang->line('umb_acc_all');?></option>
            </select>
          </div>   
        </div>
        <div class="col-md-3" id="penunjukan_ajax">
          <div class="form-group">
            <label for="penunjukan"><?php echo $this->lang->line('umb_penunjukan');?></label>
            <select disabled="disabled" class="form-control" id="penunjukan_id" name="penunjukan_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_penunjukan');?>">
              <option value="0"><?php echo $this->lang->line('umb_acc_all');?></option>
            </select>
          </div>
        </div>         
        <div class="col-md col-xl-2 mb-4">
          <label class="form-label d-none d-md-block">&nbsp;</label>
          <button type="submit" class="btn btn-secondary btn-block"><?php echo $this->lang->line('umb_get');?></button>
        </div>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>
<div class="row m-b-1 <?php echo $get_animate;?>">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_hr_laporan_karyawans');?></strong></span> </div>
      <div class="card-body">
        <div class="box-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="umb_table">
            <thead>
              <tr>
                <th><?php echo $this->lang->line('umb_karyawans_id');?></th>
                <th><?php echo $this->lang->line('umb_karyawans_full_name');?></th>
                <th><?php echo $this->lang->line('left_perusahaan');?></th>
                <th><?php echo $this->lang->line('dashboard_email');?></th>
                <th><?php echo $this->lang->line('umb_karyawan_department');?></th>
                <th><?php echo $this->lang->line('umb_penunjukan');?></th>
                <th><?php echo $this->lang->line('dashboard_umb_status');?></th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
