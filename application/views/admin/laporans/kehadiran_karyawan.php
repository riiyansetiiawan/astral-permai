<?php
/* Date Wise kehadiran Report > karyawans view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>
<?php $user_info = $this->Umb_model->read_user_info($session['user_id']);?>
<div class="row">
    <div class="col-md-12 <?php echo $get_animate;?>">
        <div class="ui-bordered px-4 pt-4 mb-4">
        <input type="hidden" id="user_id" value="0" />
        <?php $attributes = array('name' => 'laporan_tanggalbijaksana_kehadiran', 'id' => 'laporan_tanggalbijaksana_kehadiran', 'autocomplete' => 'off', 'class' => 'add form-hrm');?>
		<?php $hidden = array('euser_id' => $session['user_id']);?>
        <?php echo form_open('admin/laporans/kehadiran_umb', $attributes, $hidden);?>
        <?php
            $data = array(
              'name'        => 'user_id',
              'id'          => 'user_id',
              'value'       => $session['user_id'],
              'type'   		=> 'hidden',
              'class'       => 'form-control',
            );
            
            echo form_input($data);
            ?>
          <div class="form-row">
          <div class="col-md mb-3">
              <label class="form-label"><?php echo $this->lang->line('umb_select_date');?></label>
              <input class="form-control date" placeholder="<?php echo $this->lang->line('umb_select_date');?>" readonly id="start_date" name="start_date" type="text" value="<?php echo date('Y-m-d');?>">
            </div>
            <div class="col-md mb-3">
              <label class="form-label"><?php echo $this->lang->line('umb_select_date');?></label>
              <input class="form-control date" placeholder="<?php echo $this->lang->line('umb_select_date');?>" readonly id="end_date" name="end_date" type="text" value="<?php echo date('Y-m-d');?>">
            </div>
          <?php if($user_info[0]->user_role_id==1){ ?>
            <div class="col-md mb-3">
              <label class="form-label"><?php echo $this->lang->line('module_title_perusahaan');?></label>
              <select class="form-control" name="perusahaan_id" id="aj_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_perusahaan');?>" required>
                <option value=""></option>
                <?php foreach($get_all_perusahaans as $perusahaan) {?>
                <option value="<?php echo $perusahaan->perusahaan_id?>" <?php /*?><?php if($perusahaan_id==$perusahaan->perusahaan_id):?> selected 
                    <?php endif;?><?php */?>><?php echo $perusahaan->name?></option>
                <?php } ?>
              </select>
            </div>
            <?php } else {?>
            <?php $eperusahaan_id = $user_info[0]->perusahaan_id;?>
            <div class="col-md mb-3">
              <select class="form-control" name="perusahaan_id" id="aj_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_perusahaan');?>" required>
                <option value=""></option>
                <?php foreach($get_all_perusahaans as $perusahaan) {?>
                <?php if($eperusahaan_id == $perusahaan->perusahaan_id):?>
                <option value="<?php echo $perusahaan->perusahaan_id?>"><?php echo $perusahaan->name?></option>
                <?php endif;?>
                <?php } ?>
              </select>
            </div>
             <?php } ?>
            <div class="col-md mb-3">
            <div class="form-group" id="ajax_karyawan">
                <label class="form-label"><?php echo $this->lang->line('umb_choose_an_karyawan');?></label>
                <select name="karyawan_id" id="karyawan_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_choose_an_karyawan');?>" required>
                    <option value="">All</option>
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
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_hr_laporans_kehadiran_karyawan');?></strong></span> </div>
      <div class="card-body">
        <div class="box-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="umb_table">
            <thead>
              <tr>
                <th colspan="2"><?php echo $this->lang->line('umb_hr_info');?></th>
                <th colspan="9"><?php echo $this->lang->line('umb_kehadiran_report');?></th>
              </tr>
              <tr>
                <th style="width:120px;"><?php echo $this->lang->line('umb_karyawan');?></th>
                <th style="width:100px;"><?php echo $this->lang->line('left_perusahaan');?></th>
                <th style="width:120px;"><?php echo $this->lang->line('dashboard_umb_status');?></th>
                <th style="width:120px;"><?php echo $this->lang->line('umb_e_details_tanggal');?></th>
                <th style="width:120px;"><?php echo $this->lang->line('dashboard_clock_in');?></th>
                <th style="width:120px;"><?php echo $this->lang->line('dashboard_clock_out');?></th>
                <th style="width:120px;"><?php echo $this->lang->line('dashboard_total_kerja');?></th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
