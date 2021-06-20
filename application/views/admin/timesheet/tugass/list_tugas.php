<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>
<?php $role_resources_ids = $this->Umb_model->user_role_resource(); ?>
<?php $user_info = $this->Umb_model->read_user_info($session['user_id']);?>
<?php $system = $this->Umb_model->read_setting_info(1); ?>
<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('45',$role_resources_ids)) { ?>
      <li class="nav-item active"> <a href="<?php echo site_url('admin/timesheet/tugass/');?>" data-link-data="<?php echo site_url('admin/timesheet/tugass/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon fab fa-fantasy-flight-games"></span> <?php echo $this->lang->line('left_tugass');?>
      <div class="text-muted small"><?php echo $this->lang->line('umb_set_up');?> <?php echo $this->lang->line('left_tugass');?></div>
    </a> </li>
  <?php } ?>
  <?php if(in_array('90',$role_resources_ids)) { ?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/project/calendar_tugass/');?>" data-link-data="<?php echo site_url('admin/project/calendar_tugass/');?>" class="mb-3 nav-link hrastral-link">
      <span class="sw-icon fas fa-calendar-alt"></span> <?php echo $this->lang->line('umb_calendar_tugass');?>
      <div class="text-muted small"><?php echo $this->lang->line('umb_view');?> <?php echo $this->lang->line('umb_calendar_tugass');?></div>
    </a> </li>
  <?php } ?>
  <?php if(in_array('91',$role_resources_ids)) { ?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/project/scrum_board_tugass/');?>" data-link-data="<?php echo site_url('admin/project/scrum_board_tugass/');?>" class="mb-3 nav-link hrastral-link">
      <span class="sw-icon fas fa-clipboard-list"></span> <?php echo $this->lang->line('umb_tugass_sboard');?>
      <div class="text-muted small"><?php echo $this->lang->line('umb_view');?> <?php echo $this->lang->line('umb_tugass_sboard');?></div>
    </a> </li>
  <?php } ?>
</ul>
</div>
<hr class="border-light m-0 mb-3">
<?php if(in_array('319',$role_resources_ids)) {?>
  <?php $user_info = $this->Umb_model->read_user_info($session['user_id']);?>
  <div class="card mb-4 <?php echo $get_animate;?>">
    <div id="accordion">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_add_new');?></strong> <?php echo $this->lang->line('umb_tugas');?></span>
        <div class="card-header-elements ml-md-auto"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
          <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('umb_add_new');?></button>
        </a> </div>
      </div>
      <div id="add_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
        <div class="card-body">
          <?php $attributes = array('name' => 'add_tugas', 'id' => 'umb-form', 'autocomplete' => 'off');?>
          <?php $hidden = array('user_id' => $session['user_id']);?>
          <?php echo form_open('admin/timesheet/add_tugas', $attributes, $hidden);?>
          <div class="bg-white">
            <div class="box-block">
              <div class="row">
                <div class="col-md-6">
                  <?php if($user_info[0]->user_role_id==1){ ?>
                    <div class="form-group">
                      <label for="nama_perusahaan"><?php echo $this->lang->line('module_title_perusahaan');?></label>
                      <select class="form-control" name="perusahaan_id" id="aj_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_title_perusahaan');?>">
                        <option value=""><?php echo $this->lang->line('umb_select_one');?></option>
                        <?php foreach($all_perusahaans as $perusahaan) {?>
                          <option value="<?php echo $perusahaan->perusahaan_id;?>"> <?php echo $perusahaan->name;?></option>
                        <?php } ?>
                      </select>
                    </div>
                  <?php } else {?>
                    <?php $eperusahaan_id = $user_info[0]->perusahaan_id;?>
                    <div class="form-group">
                      <label for="nama_perusahaan"><?php echo $this->lang->line('module_title_perusahaan');?></label>
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
                  
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="start_date"><?php echo $this->lang->line('umb_start_date');?></label>
                        <input class="form-control date" placeholder="<?php echo $this->lang->line('umb_start_date');?>" readonly name="start_date" type="text" value="">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="end_date"><?php echo $this->lang->line('umb_end_date');?></label>
                        <input class="form-control date" placeholder="<?php echo $this->lang->line('umb_end_date');?>" readonly name="end_date" type="text" value="">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group" id="ajax_karyawan">
                        <label for="karyawans" class="control-label"><?php echo $this->lang->line('umb_assigned_to');?></label>
                        <select multiple class="form-control" name="assigned_to[]" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('dashboard_single_karyawan');?>">
                          <option value=""></option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="nama_tugas"><?php echo $this->lang->line('dashboard_umb_title');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('dashboard_umb_title');?>" name="nama_tugas" type="text" value="">
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="jam_tugas" class="control-label"><?php echo $this->lang->line('umb_estimated_hour');?></label>
                        <input class="form-control" placeholder="<?php echo $this->lang->line('umb_estimated_hour');?>" name="jam_tugas" type="text" value="">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group" id="ajax_project">
                        <label for="ajax_project" class="control-label"><?php echo $this->lang->line('umb_project');?></label>
                        <select class="form-control" name="project_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_project');?>">
                          <option value=""></option>
                        </select>
                      </div>
                    </div>
                  </div>
                  
                </div>
              </div>
              <div class="form-group">
                <label for="description"><?php echo $this->lang->line('umb_description');?></label>
                <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('umb_description');?>" name="description" id="description"></textarea>
              </div>
              <div class="form-actions box-footer">
                <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('umb_save');?> </button>
              </div>
            </div>
          </div>
          <?php echo form_close(); ?> </div>
        </div>
      </div>
    </div>
  <?php } ?>
  <?php if($system[0]->show_projects=='0'){ ?>
    <div class="card <?php echo $get_animate;?>">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_list_all');?></strong> <?php echo $this->lang->line('umb_worksheets');?></span> </div>
      <div class="card-body">
        <div class="box-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="umb_table">
            <thead>
              <tr>
                <th><?php echo $this->lang->line('umb_action');?></th>
                <th><?php echo $this->lang->line('dashboard_umb_title');?></th>
                <th><?php echo $this->lang->line('umb_assigned_to');?></th>
                <th><?php echo $this->lang->line('umb_e_details_tanggal');?></th>
                <th><?php echo $this->lang->line('dashboard_umb_status');?></th>
                <th><?php echo $this->lang->line('umb_created_by');?></th>
                <th><?php echo $this->lang->line('dashboard_umb_progress');?></th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  <?php } else {?>
    <?php if($user_info[0]->user_role_id==1){
     $tugas = $this->Timesheet_model->get_tugass();
   } else {
     if(in_array('322',$role_resources_ids)) {
      $tugas = $this->Timesheet_model->get_tugass_perusahaan($user_info[0]->perusahaan_id);
    } else {
      $tugas = $this->Timesheet_model->get_tugass_karyawan($session['user_id']);
    }
  }
  $data = array();
  ?>
  <div class="row">
    <?php
    foreach($tugas->result() as $r) {
     $aim = explode(',',$r->assigned_to);
     
     if($r->assigned_to == '' || $r->assigned_to == 'None') {
       $ol = 'None';
     } else {
       $ol = '';
       foreach(explode(',',$r->assigned_to) as $uid) {
				//$user = $this->Umb_model->read_user_info($uid);
        $assigned_to = $this->Umb_model->read_user_info($uid);
        if(!is_null($assigned_to)){
         
          $assigned_name = $assigned_to[0]->first_name.' '.$assigned_to[0]->last_name;
          if($assigned_to[0]->profile_picture!='' && $assigned_to[0]->profile_picture!='no file') {
           $ol .= '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.base_url().'uploads/profile/'.$assigned_to[0]->profile_picture.'" class="ui-w-30 rounded-circle" alt=""></span></a>';
         } else {
           if($assigned_to[0]->jenis_kelamin=='Pria') { 
            $de_file = base_url().'uploads/profile/default_male.jpg';
          } else {
            $de_file = base_url().'uploads/profile/default_female.jpg';
          }
          $ol .= '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.$de_file.'" class="ui-w-30 rounded-circle" alt=""></span></a>';
        }
      }
    }
    $ol .= '';
  }
		//$ol = 'A';
  /* get User info*/
  $u_created = $this->Umb_model->read_user_info($r->created_by);
  if(!is_null($u_created)){
   $f_name = $u_created[0]->first_name.' '.$u_created[0]->last_name;
 } else {
   $f_name = '--';	
 }
 
		// tugas project
 $prj_tugas = $this->Project_model->read_informasi_project($r->project_id);
 if(!is_null($prj_tugas)){
   $nama_prj = $prj_tugas[0]->title;
 } else {
   $nama_prj = '--';
 }
 $catnama_tugas = $r->nama_tugas;
 
		/// set tugas progress
 if($r->progress_tugas=='' || $r->progress_tugas==0): $progress = 0; else: $progress = $r->progress_tugas; endif;				
		// tugas progress
 if($r->progress_tugas <= 20) {
  $progress_class = 'bg-danger';
} else if($r->progress_tugas > 20 && $r->progress_tugas <= 50){
  $progress_class = 'bg-warning';
} else if($r->progress_tugas > 50 && $r->progress_tugas <= 75){
  $progress_class = 'bg-info';
} else {
  $progress_class = 'bg-success';
}
		// tugas status			
if($r->status_tugas == 0) {
 $status = '<span class="badge badge-warning">'.$this->lang->line('umb_not_started').'</span>';
} else if($r->status_tugas ==1){
 $status = '<span class="badge badge-primary">'.$this->lang->line('umb_in_progress').'</span>';
} else if($r->status_tugas ==2){
 $status = '<span class="badge badge-success">'.$this->lang->line('umb_completed').'</span>';
} else if($r->status_tugas ==3){
 $status = '<span class="badge badge-danger">'.$this->lang->line('umb_project_cancelled').'</span>';
} else {
 $status = '<span class="badge badge-danger">'.$this->lang->line('umb_project_hold').'</span>';
}

		if(in_array('320',$role_resources_ids)) { //edit
			$edit = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light edit-data" data-toggle="modal" data-target=".edit-modal-data" data-tugas_id="'. $r->tugas_id.'" data-mname="admin"><span class="fas fa-pencil-alt"></span></button></span>';
			$add_users = '<button type="button" class="btn icon-btn btn-xs btn-outline-primary borderless" data-toggle="modal" data-target=".edit-modal-data"  data-tugas_id="'. $r->tugas_id . '"><span class="fa fa-plus"></span></button>';
		} else {
			$edit = '';
			$add_users = '';
		}
   ?>
   <div class="col-sm-6 col-xl-4">

    <div class="card mb-4">
      <div class="card-body d-flex justify-content-between align-items-start pb-3">
        <div>
          <a href="javascript:void(0)" class="text-body text-big font-weight-semibold"><?php echo $catnama_tugas;?></a>
          <?php if($r->status_tugas == 0) {
            $status = '<span class="badge badge-warning align-text-bottom ml-1">'.$this->lang->line('umb_not_started').'</span>';
          } else if($r->status_tugas ==1){
            $status = '<span class="badge badge-primary align-text-bottom ml-1">'.$this->lang->line('umb_in_progress').'</span>';
          } else if($r->status_tugas ==2){
            $status = '<span class="badge badge-success align-text-bottom ml-1">'.$this->lang->line('umb_completed').'</span>';
          } else if($r->status_tugas ==3){
            $status = '<span class="badge badge-danger align-text-bottom ml-1">'.$this->lang->line('umb_project_cancelled').'</span>';
          } else {
            $status = '<span class="badge badge-danger align-text-bottom ml-1">'.$this->lang->line('umb_project_hold').'</span>';
          }
          ?>	
          <?php echo $status;?>
          <div class="text-muted small mt-1"><?php echo $this->lang->line('umb_project');?>#: <?php echo $nama_prj;?></div>
        </div>
        <div class="btn-group project-actions">
          <button type="button" class="btn btn-sm btn-default icon-btn borderless rounded-pill md-btn-flat dropdown-toggle hide-arrow" data-toggle="dropdown">
            <i class="ion ion-ios-more"></i>
          </button>
          <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="<?php echo site_url().'admin/timesheet/details_tugas/id/'.$r->tugas_id;?>">View</a>
            <?php if(in_array('320',$role_resources_ids)) { // Edit ?>
              <a class="dropdown-item" href="javascript:void(0)"  data-toggle="modal" data-target=".edit-modal-data" data-tugas_id="<?php echo $r->tugas_id;?>"><?php echo $this->lang->line('umb_edit');?></a>
            <?php } ?>
            <?php if(in_array('322',$role_resources_ids)) { // delete ?>
              <a class="dropdown-item delete" href="javascript:void(0)" data-toggle="modal" data-target=".delete-modal" data-record-id="<?php echo $r->tugas_id;?>"><?php echo $this->lang->line('umb_delete');?></a>
            <?php } ?>
          </div>
        </div>
      </div>
      <div class="progress rounded-0" style="height: 3px;">
        <div class="progress-bar <?php echo $progress_class;?>" style="width: <?php echo $r->progress_tugas;?>%;"></div>
      </div>
      <div class="card-body small pt-2 pb-0">
        <strong><?php echo $r->progress_tugas;?>%</strong> <?php echo $this->lang->line('umb_completed');?>
      </div>
      <div class="card-body pb-3">
        <?php echo $r->description;?>
      </div>
      <div class="card-body pt-0">
        <div class="row">
          <div class="col">
            <div class="text-muted small"><?php echo $this->lang->line('umb_start_date');?></div>
            <div class="font-weight-bold"><?php echo $this->Umb_model->set_date_format($r->start_date);?></div>
          </div>
          <div class="col">
            <div class="text-muted small"><?php echo $this->lang->line('umb_end_date');?></div>
            <div class="font-weight-bold"><?php echo $this->Umb_model->set_date_format($r->end_date);?></div>
          </div>
        </div>
      </div>
      <hr class="m-0">
      <div class="card-body">
        <div class="text-muted small"><?php echo $this->lang->line('umb_hours');?></div>
        <div class="mb-3"><a href="javascript:void(0)" class="text-body font-weight-semibold"><?php echo $r->jam_tugas;?></a></div>
        
        
        
      </div>
      <hr class="m-0">
      <div class="card-body py-3">
        <div class="text-muted small mb-2"><?php echo $this->lang->line('umb_team');?></div>
        <div class="d-flex flex-wrap">
          <?php echo $ol; ?>
        </div>
      </div>
    </div>
  </div>
<?php }?>
</div>
<?php } ?>
