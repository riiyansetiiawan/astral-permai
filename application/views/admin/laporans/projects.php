<?php
/* Project view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $_project = $this->Project_model->get_projects();?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>
<div class="row">
  <div class="col-md-12 <?php echo $get_animate;?>">
    <div class="ui-bordered px-4 pt-4 mb-4">
      <input type="hidden" id="user_id" value="0" />
      <?php $attributes = array('name' => 'laporans_projects', 'id' => 'laporans_projects', 'autocomplete' => 'off', 'class' => 'add form-hrm');?>
      <?php $hidden = array('euser_id' => $session['user_id']);?>
      <?php echo form_open('admin/laporans/laporans_projects', $attributes, $hidden);?>
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
        $eproject = $_project->result();
      } else {
        $iproject = $this->Project_model->get_projects_karyawan($session['user_id']);
        $eproject = $iproject->result();
      }
      ?> 
      <div class="form-row">
        <div class="col-md mb-3">
          <label class="form-label"><?php echo $this->lang->line('left_projects');?></label>
          <select class="form-control" name="project_id" id="project_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_projects');?>" required>
            <option value="0"><?php echo $this->lang->line('umb_hr_laporans_projects_all');?></option>
            <?php foreach($eproject as $projects) {?>
              <option value="<?php echo $projects->project_id?>"><?php echo $projects->title?></option>
            <?php } ?>
          </select>
        </div>
        <div class="col-md mb-3">
          <label class="form-label"><?php echo $this->lang->line('dashboard_umb_status');?></label>
          <select name="status" id="status" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('dashboard_umb_status');?>">
            <option value="all"><?php echo $this->lang->line('umb_acc_all');?></option>
            <option value="0"><?php echo $this->lang->line('umb_not_started');?></option>
            <option value="1"><?php echo $this->lang->line('umb_in_progress');?></option>
            <option value="2"><?php echo $this->lang->line('umb_completed');?></option>
            <option value="3"><?php echo $this->lang->line('umb_project_cancelled');?></option>
            <option value="4"><?php echo $this->lang->line('umb_project_hold');?></option>
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
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_hr_laporans_projects');?></strong></span> </div>
      <div class="card-body">
        <div class="box-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="umb_table">
            <thead>
              <tr>
                <th><?php echo $this->lang->line('umb_project_title');?></th>
                <th><?php echo $this->lang->line('umb_p_priority');?></th>
                <th><?php echo $this->lang->line('umb_start_date');?></th>
                <th><?php echo $this->lang->line('umb_p_enddate');?></th>
                <th><?php echo $this->lang->line('dashboard_umb_status');?></th>
                <th><?php echo $this->lang->line('dashboard_umb_progress');?></th>
                <th><?php echo $this->lang->line('umb_project_users');?></th>
                <th><?php echo $this->lang->line('umb_project_budget_hrs');?></th>
                <th><?php echo $this->lang->line('umb_project_actual_hrs');?></th>
                <!--<th><?php echo $this->lang->line('umb_project_vo_no');?></th>
                  <th><?php echo $this->lang->line('umb_project_vo_hrs');?></th>-->
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
