<?php $session = $this->session->userdata('username');?>
<?php $user_info = $this->Umb_model->read_user_info($session['user_id']);?>
<?php $role_resources_ids = $this->Umb_model->user_role_resource(); ?>

<div class="card mb-4">
  <div id="accordion">
    <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_request');?></strong> <?php echo $this->lang->line('umb_advance_gaji');?></span>
      <div class="card-header-elements ml-md-auto"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-outline-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('umb_add_new');?></button>
      </a> </div>
    </div>
    <div id="add_form" class="collapse add-form" data-parent="#accordion" style="">
      <div class="card-body">
        <?php $attributes = array('name' => 'add_advance_gaji', 'id' => 'umb-form', 'autocomplete' => 'off', 'class' => 'm-b-1');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open('admin/payroll/add_advance_gaji', $attributes, $hidden);?>
        <div class="bg-white">
          <div class="box-block">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="nama_perusahaan"><?php echo $this->lang->line('module_title_perusahaan');?></label>
                  <select class="form-control" name="perusahaan" id="aj_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_title_perusahaan');?>">
                    <option value=""><?php echo $this->lang->line('umb_select_one');?></option>
                    <?php foreach($all_perusahaans as $perusahaan) {?>
                      <option value="<?php echo $perusahaan->perusahaan_id;?>"> <?php echo $perusahaan->name;?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group" id="ajax_karyawan">
                  <label for="karyawan"><?php echo $this->lang->line('dashboard_single_karyawan');?></label>
                  <select name="karyawan_id" id="karyawan_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_choose_an_karyawan');?>">
                    <option value=""></option>
                  </select>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="month_year"><?php echo $this->lang->line('umb_bulan_tahun_penghargaan');?></label>
                      <input class="form-control month_year" placeholder="<?php echo $this->lang->line('umb_bulan_tahun_penghargaan');?>" readonly name="month_year" type="text">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="end_date"><?php echo $this->lang->line('umb_jumlah');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('umb_jumlah');?>" name="jumlah" type="text">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="edu_role"><?php echo $this->lang->line('umb_pengurangan_satu_kali');?></label>
                      <select name="pengurangan_satu_kali" class="select2 pengurangan_satu_kali" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_pengurangan_satu_kali');?>">
                        <option value="1"><?php echo $this->lang->line('umb_yes');?></option>
                        <option value="0"><?php echo $this->lang->line('umb_no');?></option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="edu_role"><?php echo $this->lang->line('umb_emi_gaji');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('umb_karyawan_angsuran_bulanan');?>" name="angsuran_bulanan" type="text" id="angsuran_bulanan" disabled="disabled">
                    </div>
                  </div>
                </div>
                
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="description"><?php echo $this->lang->line('umb_alasan');?></label>
                  <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('umb_alasan');?>" name="reason" rows="5"></textarea>
                </div>
              </div>
            </div>
            <div class="form-actions">
              <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('umb_save');?> </button>
            </div>
          </div>
        </div>
        <?php echo form_close(); ?> </div>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_list_all');?></strong> <?php echo $this->lang->line('umb_advance_gajii');?></span>
      <?php if(in_array('468',$role_resources_ids)) { ?>
        <div class="card-header-elements ml-md-auto"> <a class="text-dark collapsed" href="<?php echo site_url('admin/payroll/laporan_advance_gaji');?>">
          <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('umb_laporan_advance_gaji');?></button>
        </a> </div>
      <?php } ?>
    </div>
    
    <div class="card-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="umb_table">
        <thead>
          <tr>
            <th style="width:97px;"><?php echo $this->lang->line('umb_action');?></th>
            <th><?php echo $this->lang->line('left_perusahaan');?></th>
            <th><?php echo $this->lang->line('dashboard_single_karyawan');?></th>
            <th><?php echo $this->lang->line('umb_jumlah');?></th>
            <th><?php echo $this->lang->line('umb_bulan_tahun_penghargaan');?></th>
            <th><?php echo $this->lang->line('umb_pengurangan_satu_kali');?></th>
            <th><?php echo $this->lang->line('umb_emi_gaji');?></th>
            <th><?php echo $this->lang->line('umb_created_at');?></th>
            <th><?php echo $this->lang->line('dashboard_umb_status');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
  <style type="text/css">
    .hide-calendar .ui-datepicker-calendar { display:none !important; }
    .hide-calendar .ui-priority-secondary { display:none !important; }
  </style>
