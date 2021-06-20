<?php
/* Date Wise kehadiran Report > karyawans view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>
<?php $user_info = $this->Umb_model->read_user_info($session['user_id']);?>
<?php $role_resources_ids = $this->Umb_model->user_role_resource(); ?>
<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('46',$role_resources_ids)) { ?>
    <li class="nav-item clickable">
      <a  href="<?php echo site_url('admin/timesheet/cuti/');?>" data-link-data="<?php echo site_url('admin/timesheet/cuti/');?>" class="mb-3 nav-link hrastral-link">
        <span class="sw-icon oi oi-calculator"></span>
        <?php echo $this->lang->line('umb_manage_cutii');?>
        <div class="text-muted small"><?php echo $this->lang->line('umb_hr_calendar_permintaan_cti');?></div>
      </a>
    </li>
    <?php } ?>
    <?php if(in_array('409',$role_resources_ids)) { ?>
    <li class="nav-item active">
      <a  href="<?php echo site_url('admin/laporans/karyawan_cuti/');?>" data-link-data="<?php echo site_url('admin/laporans/karyawan_cuti/');?>" class="mb-3 nav-link hrastral-link">
        <span class="sw-icon fas fa-chalkboard-teacher"></span>
        <?php echo $this->lang->line('umb_status_cuti');?>
        <div class="text-muted small"><?php echo $this->lang->line('umb_view');?> <?php echo $this->lang->line('umb_status_cuti');?></div>
      </a>
    </li>
    <?php } ?>
  </ul>
</div>  
<hr class="border-light m-0 mb-3">
<div class="row m-b-1 <?php echo $get_animate;?>">
  <div class="col-md-3">
    <div class="card">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_hr_report_filters');?></strong></span>
    </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-12">
            <?php $attributes = array('name' => 'training_report', 'id' => 'training_report', 'autocomplete' => 'off', 'class' => 'add form-hrm');?>
            <?php $hidden = array('euser_id' => $session['user_id']);?>
            <?php echo form_open('admin/laporans/training_report', $attributes, $hidden);?>
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
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <input class="form-control date" placeholder="<?php echo $this->lang->line('umb_select_date');?>" readonly id="start_date" name="start_date" type="text" value="<?php echo date('Y-m-d');?>">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <input class="form-control date" placeholder="<?php echo $this->lang->line('umb_select_date');?>" readonly id="end_date" name="end_date" type="text" value="<?php echo date('Y-m-d');?>">
                </div>
              </div>
            </div>
            <?php if($user_info[0]->user_role_id==1){ ?>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <select class="form-control" name="perusahaan_id" id="aj_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_perusahaan');?>" required>
                    <option value=""></option>
                    <?php foreach($get_all_perusahaans as $perusahaan) {?>
                    <option value="<?php echo $perusahaan->perusahaan_id?>" <?php /*?><?php if($perusahaan_id==$perusahaan->perusahaan_id):?> selected 
						<?php endif;?><?php */?>><?php echo $perusahaan->name?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
            <?php } else {?>
            <?php $eperusahaan_id = $user_info[0]->perusahaan_id;?>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <select class="form-control" name="perusahaan_id" id="aj_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_perusahaan');?>" required>
                    <option value=""></option>
                    <?php foreach($get_all_perusahaans as $perusahaan) {?>
						<?php if($eperusahaan_id == $perusahaan->perusahaan_id):?>
                        <option value="<?php echo $perusahaan->perusahaan_id?>"><?php echo $perusahaan->name?></option>
                        <?php endif;?>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
            <?php } ?>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group" id="ajax_karyawan">
                  <select name="karyawan_id" id="karyawan_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_choose_an_karyawan');?>" required>
                    <option value="">All</option>
                    <!--<?php foreach($result as $karyawan) {?>
                        <option value="<?php echo $karyawan->user_id;?>" <?php if($session['user_id']==$karyawan->user_id):?> selected <?php endif;?>> <?php echo $karyawan->first_name.' '.$karyawan->last_name;?></option>
                        <?php } ?>-->
                  </select>
                </div>
              </div>
            </div>
            <div class="form-actions box-footer">
              <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('umb_get');?> </button>
            </div>
            <?php echo form_close(); ?> </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-9">
    <div class="card">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_view');?></strong> <?php echo $this->lang->line('umb_status_cuti');?></span> </div>
      <div class="card-body">
      <div class="box-datatable table-responsive">
        <table class="datatables-demo table table-striped table-bordered" id="umb_table">
          <thead>
            <tr>
              <th><?php echo $this->lang->line('left_perusahaan');?></th>
              <th><?php echo $this->lang->line('umb_karyawan');?></th>
              <th><?php echo $this->lang->line('umb_approved');?></th>
              <th><?php echo $this->lang->line('umb_pending');?></th>
              <th><?php echo $this->lang->line('umb_upcoming_cuti');?></th>
              <th><?php echo $this->lang->line('umb_rejected');?></th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>
</div>