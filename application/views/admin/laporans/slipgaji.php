<?php
/* Hourly Wage/Rate view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>
<?php $user_info = $this->Umb_model->read_user_info($session['user_id']);?>
<div class="row">
  <div class="col-md-12 <?php echo $get_animate;?>">
    <div class="ui-bordered px-4 pt-4 mb-4">
      <input type="hidden" id="user_id" value="0" />
      <?php $attributes = array('name' => 'laporan_slipgaji', 'id' => 'umb-form', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
      <?php $hidden = array('user_id' => $session['user_id']);?>
      <?php echo form_open('admin/laporans/laporan_slipgaji', $attributes, $hidden);?>
      <div class="form-row">
        <?php if($user_info[0]->user_role_id==1){ ?>
          <div class="col-md mb-4">
            <label class="form-label"><?php echo $this->lang->line('module_title_perusahaan');?></label>
            <select class="form-control" name="perusahaan_id" id="aj_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_title_perusahaan');?>">
              <option value=""><?php echo $this->lang->line('umb_select_one');?></option>
              <?php foreach($all_perusahaans as $perusahaan) {?>
                <option value="<?php echo $perusahaan->perusahaan_id;?>"> <?php echo $perusahaan->name;?></option>
              <?php } ?>
            </select>
          </div>
        <?php } else {?>
          <?php $eperusahaan_id = $user_info[0]->perusahaan_id;?>
          <div class="col-md mb-4">
            <label class="form-label"><?php echo $this->lang->line('module_title_perusahaan');?></label>
            <select class="form-control" name="perusahaan_id" id="aj_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_title_perusahaan');?>">
              <option value=""><?php echo $this->lang->line('umb_select_one');?></option>
              <?php foreach($all_perusahaans as $perusahaan) {?>
                <?php if($eperusahaan_id == $perusahaan->perusahaan_id):?>
                  <option value="<?php echo $perusahaan->perusahaan_id;?>"> <?php echo $perusahaan->name;?></option>
                <?php endif;?>
              <?php } ?>
            </select>
          </div>
        <?php } ?>
        <div class="col-md mb-4">
          <div class="form-group" id="ajax_karyawan">
            <label class="form-label"><?php echo $this->lang->line('dashboard_single_karyawan');?></label>
            <select name="karyawan_id" id="karyawan_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_choose_an_karyawan');?>">
              <option value=""></option>
            </select>
          </div>
        </div>
        
        <div class="col-md mb-4">
          <label class="form-label"><?php echo $this->lang->line('umb_bulan_tahun_penghargaan');?></label>
          <input class="form-control month_year" placeholder="<?php echo $this->lang->line('umb_bulan_tahun_penghargaan');?>" readonly name="month_year" id="month_year" type="text">
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
<div class="row">
  <div class="col-md-12 <?php echo $get_animate;?>">
    <div class="card">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_view');?></strong> <?php echo $this->lang->line('umb_hr_laporans_slipgaji');?></span> </div>
      <div class="card-body">
        <div class="box-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="umb_table">
            <thead>
              <tr>
                <th><?php echo $this->lang->line('dashboard_karyawan_id');?></th>
                <th><?php echo $this->lang->line('umb_nama_karyawan');?></th>
                <th><?php echo $this->lang->line('umb_bayar_jumlah');?></th>
                <th><?php echo $this->lang->line('umb_payment_month');?></th>
                <th><?php echo $this->lang->line('umb_payment_date');?></th>
                <th><?php echo $this->lang->line('umb_karyawan_type_wages');?></th>
              </tr>
            </thead>
          </table>
        </div>
        <!-- responsive --> 
      </div>
    </div>
  </div>
</div>
</div>
<style type="text/css">
  .hide-calendar .ui-datepicker-calendar { display:none !important; }
  .hide-calendar .ui-priority-secondary { display:none !important; }
</style>