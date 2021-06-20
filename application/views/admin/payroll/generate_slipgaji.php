<?php
/* Generate slipgaji view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $user_info = $this->Umb_model->read_user_info($session['user_id']);?>
<?php $role_resources_ids = $this->Umb_model->user_role_resource();?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>
<?php $system = $this->Umb_model->read_setting_info(1);?>
<?php
$is_half_col = '5';
if($system[0]->is_half_monthly==1){
	$bulk_form_url = 'admin/payroll/add_half_pay_to_all';
	$is_half_col = '12';
} else {
	$bulk_form_url = 'admin/payroll/add_pay_to_all';
	$is_half_col = '5';
}
?>
<?php $role_resources_ids = $this->Umb_model->user_role_resource(); ?>
<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('36',$role_resources_ids)) { ?>
      <li class="nav-item active"> <a href="<?php echo site_url('admin/payroll/generate_slipgaji/');?>" data-link-data="<?php echo site_url('admin/payroll/generate_slipgaji/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon fa fa-calculator"></span> <?php echo $this->lang->line('left_payroll');?>
      <div class="text-muted small"><?php echo $this->lang->line('left_generate_slipgaji');?></div>
    </a> </li>
  <?php } ?>  
  <?php if(in_array('37',$role_resources_ids)) { ?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/payroll/history_pembayaran/');?>" data-link-data="<?php echo site_url('admin/payroll/history_pembayaran/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon ion ion-ios-cash"></span> <?php echo $this->lang->line('umb_history_slipgaji');?>
    <div class="text-muted small"><?php echo $this->lang->line('umb_view');?> <?php echo $this->lang->line('umb_history_slipgaji');?></div>
  </a> </li>
<?php } ?>
<?php if(in_array('467',$role_resources_ids)) { ?>
  <li class="nav-item clickable"> <a href="<?php echo site_url('admin/payroll/advance_gaji/');?>" data-link-data="<?php echo site_url('admin/payroll/advance_gaji/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon ion ion-ios-cash"></span> <?php echo $this->lang->line('umb_advance_gaji');?>
  <div class="text-muted small"><?php echo $this->lang->line('umb_setup');?> <?php echo $this->lang->line('umb_advance_gaji');?></div>
</a> </li>
<?php } ?>
</ul>
</div>
<hr class="border-light m-0 mb-3">
<div class="ui-bordered px-4 pt-4 mb-4">
  <?php $attributes = array('name' => 'set_gaji_details', 'id' => 'set_gaji_details', 'class' => 'm-b-1 add form-hrm');?>
  <?php $hidden = array('user_id' => $session['user_id']);?>
  <?php echo form_open('admin/payroll/set_gaji_details', $attributes, $hidden);?>
  <div class="form-row">
    <?php if($user_info[0]->user_role_id==1 || in_array('314',$role_resources_ids)){ ?>
      <div class="col-md mb-4">
        <?php if($user_info[0]->user_role_id==1){ ?>
          <label class="form-label"><?php echo $this->lang->line('module_title_perusahaan');?></label>
          <select class="form-control" name="perusahaan" id="aj_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_title_perusahaan');?>" required>
            <option value="0"><?php echo $this->lang->line('umb_all_perusahaans');?></option>
            <?php foreach($all_perusahaans as $perusahaan) {?>
              <option value="<?php echo $perusahaan->perusahaan_id;?>"> <?php echo $perusahaan->name;?></option>
            <?php } ?>
          </select>
        <?php } else {?>
          <?php $eperusahaan_id = $user_info[0]->perusahaan_id;?>
          <label class="form-label"><?php echo $this->lang->line('module_title_perusahaan');?></label>
          <select class="form-control" name="perusahaan" id="aj_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_title_perusahaan');?>" required>
            <option value=""><?php echo $this->lang->line('module_title_perusahaan');?></option>
            <?php foreach($all_perusahaans as $perusahaan) {?>
              <?php if($eperusahaan_id == $perusahaan->perusahaan_id):?>
                <option value="<?php echo $perusahaan->perusahaan_id;?>"> <?php echo $perusahaan->name;?></option>
              <?php endif;?>
            <?php } ?>
          </select>
        <?php } ?>
      </div>
      <div class="col-md mb-4" id="ajax_karyawan">
        <label class="form-label"><?php echo $this->lang->line('dashboard_single_karyawan');?></label>
        <select id="karyawan_id" name="karyawan_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_choose_an_karyawan');?>">
          <option value="0"><?php echo $this->lang->line('umb_all_karyawans');?></option>
        </select>
      </div>
    <?php } else {?>
      <input type="hidden" name="karyawan_id" id="karyawan_id" value="<?php echo $session['user_id'];?>" />
    <?php } ?>
    <div class="col-md mb-4">
      <label class="form-label"><?php echo $this->lang->line('umb_select_month');?></label>
      <input class="form-control hr_month_year" placeholder="<?php echo $this->lang->line('umb_select_month');?>" id="month_year" name="month_year" type="text" value="<?php echo date('Y-m');?>">
    </div>
    <div class="col-md col-xl-2 mb-4">
      <label class="form-label d-none d-md-block">&nbsp;</label>
      <button type="submit" class="btn btn-secondary btn-block"> <i class="fas fa-check-square"></i> <?php echo $this->lang->line('umb_search');?> </button>
    </div>
  </div>
  <?php echo form_close(); ?> </div>
  <?php if($system[0]->is_half_monthly!=1){?>
    <?php if($user_info[0]->user_role_id==1 || in_array('314',$role_resources_ids)){ ?>
      <div id="bulk_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
        <div class="ui-bordered px-4 pt-4 mb-4">
          <?php $attributes = array('name' => 'bulk_payment', 'id' => 'bulk_payment', 'class' => 'm-b-1 add form-hrm');?>
          <?php $hidden = array('user_id' => $session['user_id']);?>
          <?php echo form_open($bulk_form_url, $attributes, $hidden);?>
          <div class="form-row">
            <div class="col-md mb-4">
              <label class="form-label"><?php echo $this->lang->line('left_perusahaan');?></label>
              <select class="form-control" name="perusahaan_id" id="aj_perusahaanx" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_perusahaan');?>">
                <option value="0"><?php echo $this->lang->line('umb_acc_all');?></option>
                <?php foreach($all_perusahaans as $perusahaan) {?>
                  <option value="<?php echo $perusahaan->perusahaan_id;?>"> <?php echo $perusahaan->name;?></option>
                <?php } ?>
              </select>
            </div>
            <div class="col-md mb-4" id="ajax_location">
              <label class="form-label"><?php echo $this->lang->line('left_location');?></label>
              <select name="location_id" id="aj_location_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_location');?>">
                <option value="0"><?php echo $this->lang->line('umb_acc_all');?></option>
              </select>
            </div>
            <div class="col-md mb-4" id="department_ajax">
              <label class="form-label"><?php echo $this->lang->line('left_department');?></label>
              <select class="form-control" id="aj_subdepartments" name="department_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_department');?>">
                <option value="0"><?php echo $this->lang->line('umb_acc_all');?></option>
              </select>
            </div>
            <div class="col-md mb-4">
              <label class="form-label"><?php echo $this->lang->line('umb_select_month');?></label>
              <input class="form-control hr_month_year" placeholder="<?php echo $this->lang->line('umb_select_month');?>" id="month_year" name="month_year" type="text" value="<?php echo date('Y-m');?>">
            </div>
            <div class="col-md col-xl-2 mb-4">
              <label class="form-label d-none d-md-block">&nbsp;</label>
              <button type="submit" class="btn btn-secondary btn-block"> <i class="fas fa-check-square"></i> <?php echo $this->lang->line('umb_payroll_bulk_payment');?> </button>
            </div>
          </div>
          <?php echo form_close(); ?> </div>
        </div>
      <?php } ?>
    <?php } ?>
    <div class="card <?php echo $get_animate;?>">
      <div class="box-header with-border">
        <div id="accordion">
          <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_payment_info_for');?></strong> <span id="payroll_date"><?php echo date('Y-m');?></span></span>
            <div class="card-header-elements ml-md-auto"> <a class="text-dark collapsed" data-toggle="collapse" href="#bulk_form" aria-expanded="false">
              <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('umb_payroll_bulk_payment');?></button>
            </a> </div>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="box-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="umb_table">
            <thead>
              <tr>
                <th width="80"><?php echo $this->lang->line('umb_action');?></th>
                <th><?php echo $this->lang->line('umb_name');?></th>
                <th><?php echo $this->lang->line('umb_name');?></th>
                <th><?php echo $this->lang->line('umb_gaji_type');?></th>
                <th><?php echo $this->lang->line('umb_gaji_title');?></th>
                <th><?php echo $this->lang->line('umb_payroll_gaji_bersih');?></th>
                <th><?php echo $this->lang->line('dashboard_umb_status');?></th>
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