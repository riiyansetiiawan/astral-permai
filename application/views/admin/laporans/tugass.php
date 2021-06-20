<?php
/* tugass report view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $_tugass = $this->Timesheet_model->get_tugass();?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>
<div class="row">
  <div class="col-md-12 <?php echo $get_animate;?>">
    <div class="ui-bordered px-4 pt-4 mb-4">
      <input type="hidden" id="user_id" value="0" />
      <?php $attributes = array('name' => 'laporans_tugas', 'id' => 'laporans_tugas', 'autocomplete' => 'off', 'class' => 'add form-hrm');?>
      <?php $hidden = array('euser_id' => $session['user_id']);?>
      <?php echo form_open('admin/laporans/laporans_tugas', $attributes, $hidden);?>
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
      <?php
      $user_info = $this->Umb_model->read_user_info($session['user_id']);
      if($user_info[0]->user_role_id==1){
        $etugas = $_tugass->result();
      } else {
        $itugas = $this->Timesheet_model->get_tugass_karyawan($session['user_id']);
        $etugas = $itugas->result();
      }
      ?> 
      <div class="form-row">
        <div class="col-md mb-3">
          <label class="form-label"><?php echo $this->lang->line('left_tugass');?></label>
          <select class="form-control" name="project_id" id="project_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_projects');?>" required>
            <option value="0"><?php echo $this->lang->line('umb_hr_laporans_tugass_all');?></option>
            <?php foreach($etugas as $tugass) {?>
              <option value="<?php echo $tugass->tugas_id?>"><?php echo $tugass->nama_tugas?></option>
            <?php } ?>
          </select>
        </div>
        <div class="col-md mb-3">
          <label class="form-label"><?php echo $this->lang->line('dashboard_umb_status');?></label>
          <select name="status" id="status" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('dashboard_umb_status');?>">
            <option value="4"><?php echo $this->lang->line('umb_acc_all');?></option>
            <option value="0"><?php echo $this->lang->line('umb_not_started');?></option>
            <option value="1"><?php echo $this->lang->line('umb_in_progress');?></option>
            <option value="2"><?php echo $this->lang->line('umb_completed');?></option>
            <option value="3"><?php echo $this->lang->line('umb_deffered');?></option>
          </select>
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
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_hr_laporans_tugass');?></strong></span> </div>
      <div class="card-body">
        <div class="box-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="umb_table">
            <thead>
              <tr>
                <th><?php echo $this->lang->line('dashboard_umb_title');?></th>
                <th><?php echo $this->lang->line('umb_start_date');?></th>
                <th><?php echo $this->lang->line('umb_end_date');?></th>
                <th><?php echo $this->lang->line('umb_assigned_to');?></th>
                <th><?php echo $this->lang->line('dashboard_umb_status');?></th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
