<?php $session = $this->session->userdata('username');?>
<?php $user_info = $this->Umb_model->read_user_info($session['user_id']);?>
<?php $role_resources_ids = $this->Umb_model->user_role_resource(); ?>
<?php
if($user_info[0]->user_role_id == '1'){
	$completed_tugas = $this->Project_model->calendar_complete_tugass();
	$cancelled_tugas = $this->Project_model->calendar_cancelled_tugass();
	$inprogress_tugas = $this->Project_model->calendar_inprogress_tugass();
	$not_started_tugas = $this->Project_model->calendar_not_started_tugass();
	$hold_tugas = $this->Project_model->calendar_hold_tugass();
} else {
	$completed_tugas = $this->Project_model->calendar_user_complete_tugass($session['user_id']);
	$cancelled_tugas = $this->Project_model->calendar_user_cancelled_tugass($session['user_id']);
	$inprogress_tugas = $this->Project_model->calendar_user_inprogress_tugass($session['user_id']);
	$not_started_tugas = $this->Project_model->calendar_user_not_started_tugass($session['user_id']);
	$hold_tugas = $this->Project_model->calendar_user_hold_tugass($session['user_id']);
}
$tugas = $this->Timesheet_model->get_tugass();
if($tugas->num_rows() > 0) {
?>
<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('45',$role_resources_ids)) { ?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/timesheet/tugass/');?>" data-link-data="<?php echo site_url('admin/timesheet/tugass/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon fab fa-fantasy-flight-games"></span> <?php echo $this->lang->line('left_tugass');?>
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
    <li class="nav-item active"> <a href="<?php echo site_url('admin/project/scrum_board_tugass/');?>" data-link-data="<?php echo site_url('admin/project/scrum_board_tugass/');?>" class="mb-3 nav-link hrastral-link">
    <span class="sw-icon fas fa-clipboard-list"></span> <?php echo $this->lang->line('umb_tugass_sboard');?>
      <div class="text-muted small"><?php echo $this->lang->line('umb_view');?> <?php echo $this->lang->line('umb_tugass_sboard');?></div>
      </a> </li>
    <?php } ?>
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<div class="form-row">
<div class="col-md">

    <div class="card mb-3">
      <h6 class="card-header"><i class="ion ion-md-football text-info"></i> &nbsp; <?php echo $this->lang->line('umb_not_started');?></h6>
      <div class="kanban-box first-notstarted px-2 pt-2" id="first-notstarted" data-status="0">
      <?php foreach($not_started_tugas as $hltugas) {?>
       <?php
		$ol = '';
		$cc = count(explode(',',$hltugas->assigned_to));
		$iuser = 0;
		foreach(explode(',',$hltugas->assigned_to) as $uid) {
			//$user = $this->Umb_model->read_user_info($uid);
			if($iuser < 5) {
				$assigned_to = $this->Umb_model->read_user_info($uid);
				if(!is_null($assigned_to)){
					
				$assigned_name = $assigned_to[0]->first_name.' '.$assigned_to[0]->last_name;
				 if($assigned_to[0]->profile_picture!='' && $assigned_to[0]->profile_picture!='no file') {
					$ol .= '<a href="javascript:void(0);" class=""d-block mb-1" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><img src="'.base_url().'uploads/profile/'.$assigned_to[0]->profile_picture.'" class="ui-w-30 rounded-circle" alt=""></a>';
					} else {
					if($assigned_to[0]->jenis_kelamin=='Pria') { 
						$de_file = base_url().'uploads/profile/default_male.jpg';
					 } else {
						$de_file = base_url().'uploads/profile/default_female.jpg';
					 }
					$ol .= '<a href="javascript:void(0);" class=""d-block mb-1" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><img src="'.$de_file.'" class="ui-w-30 rounded-circle" alt=""></a>';
					}
				}
			}
			$iuser++;
		 }
		 $ol .= '';
		$pedate = $this->Umb_model->set_date_format($hltugas->end_date);
		if($hltugas->progress_tugas <= 20) {
			$progress_class = 'bg-danger';
		} else if($hltugas->progress_tugas > 20 && $hltugas->progress_tugas <= 50){
			$progress_class = 'bg-warning';
		} else if($hltugas->progress_tugas > 50 && $hltugas->progress_tugas <= 75){
			$progress_class = 'bg-info';
		} else {
			$progress_class = 'bg-success';
		}
		?>
        <div class="ui-bordered notstarted_<?php echo $hltugas->tugas_id;?> p-2 mb-2" data-id="<?php echo $hltugas->tugas_id;?>" data-status="0" id="notstarted">
          <a href="<?php echo site_url('admin/timesheet/details_tugas/id/').$hltugas->tugas_id;?>"><?php echo $hltugas->nama_tugas;?></a>
          <div><small class="text-muted"><?php echo $this->lang->line('umb_completed');?> <?php echo $hltugas->progress_tugas;?>%</small></div>
          <div class="progress">
            <div class="progress-bar progress-bar-striped progress-bar-animated <?php echo $progress_class;?>" style="width: <?php echo $hltugas->progress_tugas;?>%"></div>
          </div>
          <div class="text-muted small mb-1 mt-2"><?php echo $this->lang->line('umb_team');?></div>
          <div class="d-flex flex-wrap mt-1">
             <?php echo $ol;?>
            </div>
        </div>
        <?php } ?>
      </div>
      <div class="card-footer text-center py-2">
        <a href="javascript:void(0)" class="edit-data add-tugas" data-toggle="modal" data-target=".edit-modal-data" data-status_tugas="0"><i class="ion ion-md-add"></i>&nbsp; <?php echo $this->lang->line('umb_add_tugas');?></a>
      </div>
    </div>

  </div>
  <div class="col-md">

    <div class="card mb-3">
      <h6 class="card-header"><i class="ion ion-ios-list text-primary"></i> &nbsp; <?php echo $this->lang->line('umb_in_progress');?></h6>
      <div class="kanban-box first-inprogress px-2 pt-2" data-status="1" id="first-inprogress">
      <?php foreach($inprogress_tugas as $hltugas) {?>
       <?php
		$ol = '';
		$cc = count(explode(',',$hltugas->assigned_to));
		$iuser = 0;
		foreach(explode(',',$hltugas->assigned_to) as $uid) {
			//$user = $this->Umb_model->read_user_info($uid);
			if($iuser < 5) {
				$assigned_to = $this->Umb_model->read_user_info($uid);
				if(!is_null($assigned_to)){
					
				$assigned_name = $assigned_to[0]->first_name.' '.$assigned_to[0]->last_name;
				 if($assigned_to[0]->profile_picture!='' && $assigned_to[0]->profile_picture!='no file') {
					$ol .= '<a href="javascript:void(0);" class=""d-block mb-1" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><img src="'.base_url().'uploads/profile/'.$assigned_to[0]->profile_picture.'" class="ui-w-30 rounded-circle" alt=""></a>';
					} else {
					if($assigned_to[0]->jenis_kelamin=='Pria') { 
						$de_file = base_url().'uploads/profile/default_male.jpg';
					 } else {
						$de_file = base_url().'uploads/profile/default_female.jpg';
					 }
					$ol .= '<a href="javascript:void(0);" class=""d-block mb-1" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><img src="'.$de_file.'" class="ui-w-30 rounded-circle" alt=""></a>';
					}
				}
			}
			$iuser++;
		 }
		 $ol .= '';
		$pedate = $this->Umb_model->set_date_format($hltugas->end_date);
		if($hltugas->progress_tugas <= 20) {
			$progress_class = 'bg-danger';
		} else if($hltugas->progress_tugas > 20 && $hltugas->progress_tugas <= 50){
			$progress_class = 'bg-warning';
		} else if($hltugas->progress_tugas > 50 && $hltugas->progress_tugas <= 75){
			$progress_class = 'bg-info';
		} else {
			$progress_class = 'bg-success';
		}
		?>
        <div class="ui-bordered in-progress_<?php echo $hltugas->tugas_id;?> p-2 mb-2" data-id="<?php echo $hltugas->tugas_id;?>" data-status="1" id="in-progress">
          <a href="<?php echo site_url('admin/timesheet/details_tugas/id/').$hltugas->tugas_id;?>"><?php echo $hltugas->nama_tugas;?></a>
          <div><small class="text-muted"><?php echo $this->lang->line('umb_completed');?> <?php echo $hltugas->progress_tugas;?>%</small></div>
          <div class="progress">
            <div class="progress-bar progress-bar-striped progress-bar-animated <?php echo $progress_class;?>" style="width: <?php echo $hltugas->progress_tugas;?>%"></div>
          </div>
          <div class="text-muted small mb-1 mt-2"><?php echo $this->lang->line('umb_team');?></div>
          <div class="d-flex flex-wrap mt-1">
             <?php echo $ol;?>
            </div>
        </div>
        <?php } ?>
      </div>
    </div>

  </div>
  <div class="col-md">

    <div class="card border-info mb-3">
      <h6 class="card-header"><i class="ion ion-md-done-all text-success"></i> &nbsp; <?php echo $this->lang->line('umb_completed');?></h6>
      <div class="kanban-box first-completed px-2 pt-2" data-status="2" id="first-completed">
        <?php foreach($completed_tugas as $hltugas) {?>
       <?php
		$ol = '';
		$cc = count(explode(',',$hltugas->assigned_to));
		$iuser = 0;
		foreach(explode(',',$hltugas->assigned_to) as $uid) {
			//$user = $this->Umb_model->read_user_info($uid);
			if($iuser < 5) {
				$assigned_to = $this->Umb_model->read_user_info($uid);
				if(!is_null($assigned_to)){
					
				$assigned_name = $assigned_to[0]->first_name.' '.$assigned_to[0]->last_name;
				 if($assigned_to[0]->profile_picture!='' && $assigned_to[0]->profile_picture!='no file') {
					$ol .= '<a href="javascript:void(0);" class=""d-block mb-1" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><img src="'.base_url().'uploads/profile/'.$assigned_to[0]->profile_picture.'" class="ui-w-30 rounded-circle" alt=""></a>';
					} else {
					if($assigned_to[0]->jenis_kelamin=='Pria') { 
						$de_file = base_url().'uploads/profile/default_male.jpg';
					 } else {
						$de_file = base_url().'uploads/profile/default_female.jpg';
					 }
					$ol .= '<a href="javascript:void(0);" class=""d-block mb-1" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><img src="'.$de_file.'" class="ui-w-30 rounded-circle" alt=""></a>';
					}
				}
			}
			$iuser++;
		 }
		 $ol .= '';
		$pedate = $this->Umb_model->set_date_format($hltugas->end_date);
		if($hltugas->progress_tugas <= 20) {
			$progress_class = 'bg-danger';
		} else if($hltugas->progress_tugas > 20 && $hltugas->progress_tugas <= 50){
			$progress_class = 'bg-warning';
		} else if($hltugas->progress_tugas > 50 && $hltugas->progress_tugas <= 75){
			$progress_class = 'bg-info';
		} else {
			$progress_class = 'bg-success';
		}
		?>
        <div class="ui-bordered complete_<?php echo $hltugas->tugas_id;?> p-2 mb-2" data-id="<?php echo $hltugas->tugas_id;?>" data-status="2" id="complete">
          <a href="<?php echo site_url('admin/timesheet/details_tugas/id/').$hltugas->tugas_id;?>"><?php echo $hltugas->nama_tugas;?></a>
          <div><small class="text-muted"><?php echo $this->lang->line('umb_completed');?> <?php echo $hltugas->progress_tugas;?>%</small></div>
          <div class="progress">
            <div class="progress-bar progress-bar-striped progress-bar-animated <?php echo $progress_class;?>" style="width: <?php echo $hltugas->progress_tugas;?>%"></div>
          </div>
          <div class="text-muted small mb-1 mt-2"><?php echo $this->lang->line('umb_team');?></div>
          <div class="d-flex flex-wrap mt-1">
             <?php echo $ol;?>
            </div>
        </div>
        <?php } ?>
      </div>
    </div>

  </div>
  <div class="col-md">

    <div class="card border-warning mb-3">
      <h6 class="card-header"><i class="ion ion-md-close-circle-outline text-danger"></i> &nbsp; <?php echo $this->lang->line('umb_project_cancelled');?></h6>
      <div class="kanban-box first-cancelled px-2 pt-2" data-status="3" id="first-cancelled">
        <?php foreach($cancelled_tugas as $hltugas) {?>
       <?php
		$ol = '';
		$cc = count(explode(',',$hltugas->assigned_to));
		$iuser = 0;
		foreach(explode(',',$hltugas->assigned_to) as $uid) {
			//$user = $this->Umb_model->read_user_info($uid);
			if($iuser < 5) {
				$assigned_to = $this->Umb_model->read_user_info($uid);
				if(!is_null($assigned_to)){
					
				$assigned_name = $assigned_to[0]->first_name.' '.$assigned_to[0]->last_name;
				 if($assigned_to[0]->profile_picture!='' && $assigned_to[0]->profile_picture!='no file') {
					$ol .= '<a href="javascript:void(0);" class=""d-block mb-1" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><img src="'.base_url().'uploads/profile/'.$assigned_to[0]->profile_picture.'" class="ui-w-30 rounded-circle" alt=""></a>';
					} else {
					if($assigned_to[0]->jenis_kelamin=='Pria') { 
						$de_file = base_url().'uploads/profile/default_male.jpg';
					 } else {
						$de_file = base_url().'uploads/profile/default_female.jpg';
					 }
					$ol .= '<a href="javascript:void(0);" class=""d-block mb-1" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><img src="'.$de_file.'" class="ui-w-30 rounded-circle" alt=""></a>';
					}
				}
			}
			$iuser++;
		 }
		 $ol .= '';
		$pedate = $this->Umb_model->set_date_format($hltugas->end_date);
		if($hltugas->progress_tugas <= 20) {
			$progress_class = 'bg-danger';
		} else if($hltugas->progress_tugas > 20 && $hltugas->progress_tugas <= 50){
			$progress_class = 'bg-warning';
		} else if($hltugas->progress_tugas > 50 && $hltugas->progress_tugas <= 75){
			$progress_class = 'bg-info';
		} else {
			$progress_class = 'bg-success';
		}
		?>
        <div class="ui-bordered cancelled_<?php echo $hltugas->tugas_id;?> p-2 mb-2" data-id="<?php echo $hltugas->tugas_id;?>" data-status="3" id="cancelled">
          <a href="<?php echo site_url('admin/timesheet/details_tugas/id/').$hltugas->tugas_id;?>"><?php echo $hltugas->nama_tugas;?></a>
          <div><small class="text-muted"><?php echo $this->lang->line('umb_completed');?> <?php echo $hltugas->progress_tugas;?>%</small></div>
          <div class="progress">
            <div class="progress-bar progress-bar-striped progress-bar-animated <?php echo $progress_class;?>" style="width: <?php echo $hltugas->progress_tugas;?>%"></div>
          </div>
          <div class="text-muted small mb-1 mt-2"><?php echo $this->lang->line('umb_team');?></div>
          <div class="d-flex flex-wrap mt-1">
             <?php echo $ol;?>
            </div>
        </div>
        <?php } ?>
      </div>
    </div>

  </div>
  <div class="col-md">

    <div class="card border-success mb-3">
      <h6 class="card-header"><i class="ion ion-md-flash-off text-warning"></i> &nbsp; <?php echo $this->lang->line('umb_project_hold');?></h6>
      <div class="kanban-box first-hold px-2 pt-2"  data-status="4" id="first-hold">
        <?php foreach($hold_tugas as $hltugas) {?>
       <?php
		$ol = '';
		$cc = count(explode(',',$hltugas->assigned_to));
		$iuser = 0;
		foreach(explode(',',$hltugas->assigned_to) as $uid) {
			//$user = $this->Umb_model->read_user_info($uid);
			if($iuser < 5) {
				$assigned_to = $this->Umb_model->read_user_info($uid);
				if(!is_null($assigned_to)){
					
				$assigned_name = $assigned_to[0]->first_name.' '.$assigned_to[0]->last_name;
				 if($assigned_to[0]->profile_picture!='' && $assigned_to[0]->profile_picture!='no file') {
					$ol .= '<a href="javascript:void(0);" class=""d-block mb-1" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><img src="'.base_url().'uploads/profile/'.$assigned_to[0]->profile_picture.'" class="ui-w-30 rounded-circle" alt=""></a>';
					} else {
					if($assigned_to[0]->jenis_kelamin=='Pria') { 
						$de_file = base_url().'uploads/profile/default_male.jpg';
					 } else {
						$de_file = base_url().'uploads/profile/default_female.jpg';
					 }
					$ol .= '<a href="javascript:void(0);" class=""d-block mb-1" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><img src="'.$de_file.'" class="ui-w-30 rounded-circle" alt=""></a>';
					}
				}
			}
			$iuser++;
		 }
		 $ol .= '';
		$pedate = $this->Umb_model->set_date_format($hltugas->end_date);
		if($hltugas->progress_tugas <= 20) {
			$progress_class = 'bg-danger';
		} else if($hltugas->progress_tugas > 20 && $hltugas->progress_tugas <= 50){
			$progress_class = 'bg-warning';
		} else if($hltugas->progress_tugas > 50 && $hltugas->progress_tugas <= 75){
			$progress_class = 'bg-info';
		} else {
			$progress_class = 'bg-success';
		}
		?>
        <div class="ui-bordered hold_<?php echo $hltugas->tugas_id;?> p-2 mb-2" data-id="<?php echo $hltugas->tugas_id;?>" data-status="4" id="hold">
          <a href="<?php echo site_url('admin/timesheet/details_tugas/id/').$hltugas->tugas_id;?>"><?php echo $hltugas->nama_tugas;?></a>
          <div><small class="text-muted"><?php echo $this->lang->line('umb_completed');?> <?php echo $hltugas->progress_tugas;?>%</small></div>
          <div class="progress">
            <div class="progress-bar progress-bar-striped progress-bar-animated <?php echo $progress_class;?>" style="width: <?php echo $hltugas->progress_tugas;?>%"></div>
          </div>
          <div class="text-muted small mb-1 mt-2"><?php echo $this->lang->line('umb_team');?></div>
          <div class="d-flex flex-wrap mt-1">
             <?php echo $ol;?>
            </div>
        </div>
        <?php } ?>
      </div>
    </div>

  </div>
</div>
<?php } else {?>
<div class="row">
    <div class="col-md-7 col-md-offset-3">
    <img src="<?php echo base_url();?>skin/img/no-record-found.png" />
    </div>
</div>
<?php } ?>