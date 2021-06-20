<?php
$session = $this->session->userdata('username');
$system = $this->Umb_model->read_setting_info(1);
$info_perusahaan = $this->Umb_model->read_info_setting_perusahaan(1);
$user = $this->Umb_model->read_info_karyawan($session['user_id']);
$theme = $this->Umb_model->read_theme_info(1);
$role_resources_ids = $this->Umb_model->user_role_resource();
?>
<div class="container-fluid flex-grow-1 container-p-y">
  <h3 class="text-center font-weight-bold py-1 mb-2">
    <?php echo $this->lang->line('header_notifications');?></h3>
    <hr class="container-m-nx border-light my-0">
  </div>
  <div class="card messages-card">
    <div class="row no-gutters">

      <!-- Messages sidebox -->
      <div class="messages-sidebox messages-scroll col">

        <div class="card-body py-3">
          <div class="media align-items-center">
            <div class="media-body">
              <button type="button" class="btn btn-primary btn-block"><?php echo $this->lang->line('header_notifications');?></button>
            </div>
            <a href="javascript:void(0)" class="messages-sidebox-toggler d-lg-none d-block text-muted text-large font-weight-light pl-4">&times;</a>
          </div>
        </div>
        <hr class="border-light m-0">

        <div class="card-body pt-3">      

          <!-- Notification boxes -->
          <?php  if(in_array('46',$role_resources_ids)) { ?>
            <a href="javascript:void(0)" class="d-flex justify-content-between align-items-center text-muted py-2">
              <div>
                <i class="ion ion-ios-filing"></i> &nbsp; <?php echo $this->lang->line('umb_e_details_cuti');?>
              </div>
              <div class="badge badge-primary"><?php echo $this->Umb_model->hrastral_notifications_count('leave',$session['user_id']);?></div>
            </a>
          <?php } ?>
          <?php  if(in_array('44',$role_resources_ids)) { ?>
            <a href="javascript:void(0)" class="d-flex justify-content-between align-items-center text-muted py-2">
              <div>
                <i class="ion ion-logo-buffer"></i> &nbsp; <?php echo $this->lang->line('umb_projects');?>
              </div>
              <div class="badge badge-primary"><?php echo $this->Umb_model->hrastral_notifications_count('projects',$session['user_id']);?></div>
            </a>
          <?php } ?>
          <?php  if(in_array('45',$role_resources_ids)) { ?>
            <a href="javascript:void(0)" class="d-flex justify-content-between align-items-center text-muted py-2">
              <div>
                <i class="fab fa-fantasy-flight-games"></i> &nbsp; <?php echo $this->lang->line('umb_tugass');?>
              </div>
              <div class="badge badge-primary"><?php echo $this->Umb_model->hrastral_notifications_count('tugass',$session['user_id']);?></div>
            </a>
          <?php } ?>
          <?php  if(in_array('11',$role_resources_ids)) { ?>
            <a href="javascript:void(0)" class="d-flex justify-content-between align-items-center text-muted py-2">
              <div>
                <i class="ion ion-md-megaphone"></i> &nbsp; <?php echo $this->lang->line('dashboard_pengumumans');?>
              </div>
              <div class="badge badge-primary"><?php echo $this->Umb_model->hrastral_notifications_count('pengumuman',$session['user_id']);?></div>
            </a>
          <?php } ?>
          <?php if($system[0]->module_inquiry=='true'){?>
            <?php  if(in_array('43',$role_resources_ids)) { ?>
              <a href="javascript:void(0)" class="d-flex justify-content-between align-items-center text-muted py-2">
                <div>
                  <i class="fab fa-critical-role"></i> &nbsp; <?php echo $this->lang->line('left_tickets');?>
                </div>
                <div class="badge badge-primary"><?php echo $this->Umb_model->hrastral_notifications_count('tickets',$session['user_id']);?></div>
              </a>
            <?php } ?>
          <?php } ?>
          <?php  if(in_array('25',$role_resources_ids)) { ?>
            <a href="javascript:void(0)" class="d-flex justify-content-between align-items-center text-muted py-2">
              <div>
                <i class="ion ion-md-today"></i> &nbsp; <?php echo $this->lang->line('umb_assets');?>
              </div>
              <div class="badge badge-primary"><?php echo $this->Umb_model->hrastral_notifications_count('asset',$session['user_id']);?></div>
            </a>
          <?php } ?>
          <?php  if(in_array('14',$role_resources_ids)) { ?>
            <a href="javascript:void(0)" class="d-flex justify-content-between align-items-center text-muted py-2">
              <div>
                <i class="fas fa-trophy"></i> &nbsp; <?php echo $this->lang->line('left_awards');?>
              </div>
              <div class="badge badge-primary"><?php echo $this->Umb_model->hrastral_notifications_count('awards',$session['user_id']);?></div>
            </a>
          <?php } ?>
          <!-- / Mail boxes -->
          <hr class="border-light my-4">
        </div>

      </div>
      <!-- / Messages sidebox -->
      <?php
      $fcount = 0; $proj_count = 0; $cuti_count = 0; $tgs_count = 0;
      $pgnmmn_count = 0; $tkt_count = 0; $asset_count = 0; $award_count = 0;
      if(in_array('46',$role_resources_ids)) {
       $cuti_count = $this->Umb_model->hrastral_notifications_count('leave',$session['user_id']);
     }
     if(in_array('44',$role_resources_ids)) {
       $proj_count = $this->Umb_model->hrastral_notifications_count('projects',$session['user_id']);
     }
     if(in_array('45',$role_resources_ids)) {
       $tgs_count = $this->Umb_model->hrastral_notifications_count('tugass',$session['user_id']);
     }
     if(in_array('11',$role_resources_ids)) {
       $pgnmmn_count = $this->Umb_model->hrastral_notifications_count('pengumuman',$session['user_id']);
     }
     if($system[0]->module_inquiry=='true'){
       if(in_array('43',$role_resources_ids)) {
        $tkt_count = $this->Umb_model->hrastral_notifications_count('tickets',$session['user_id']);
      }
    }
    if(in_array('25',$role_resources_ids)) {
     $asset_count = $this->Umb_model->hrastral_notifications_count('asset',$session['user_id']);
   }
   if(in_array('14',$role_resources_ids)) {
     $award_count = $this->Umb_model->hrastral_notifications_count('awards',$session['user_id']);
   }
		// count);
   $fcount = $proj_count + $cuti_count + $tgs_count + $pgnmmn_count + $tkt_count + $asset_count + $award_count;
   ?>
   <!-- Messages list -->
   <div class="col">
     <?php if($fcount > 0) {?>
      <hr class="border-light m-0">
      <!-- / Controls -->
      <ul class="list-group messages-list">
        <?php  if(in_array('46',$role_resources_ids)) { ?>
          <?php foreach($this->Umb_model->hrastral_notifications('leave',$session['user_id']) as $cuti_notify) {?>
            <?php
            $info_cuti = $this->Timesheet_model->read_informasi_cuti($cuti_notify->module_id);
            if(!is_null($info_cuti)){
             $type_cuti = $this->Timesheet_model->read_informasi_type_cuti($info_cuti[0]->type_cuti_id);
             $karyawan_info = $this->Umb_model->read_user_info($info_cuti[0]->karyawan_id);
			// get leave types
             if(!is_null($type_cuti)){
              $type_name = $type_cuti[0]->type_name;
            } else {
              $type_name = '--';	
            }
            if(!is_null($karyawan_info)){
              $nama_krywn = $karyawan_info[0]->first_name. ' '.$karyawan_info[0]->last_name;
            } else {
              $nama_krywn = '--';	
            }
          } else {
           $type_name = '--';
           $nama_krywn = '--';
         }
         ?>
         <li class="list-group-item px-4">
          <a href="javascript:void(0)" class="message-sender flex-shrink-1 d-block text-body">
            <?php echo $this->lang->line('umb_e_details_cuti');?>
          </a>
          <a href="<?php echo site_url('admin/timesheet/details_cuti/id')?>/<?php echo $cuti_notify->module_id;?>/" class="message-subject flex-shrink-1 d-block text-body font-weight-bold">
            <?php echo $nama_krywn;?> <?php echo $this->lang->line('header_has_applied_for_cuti').': '.$type_name;?>
          </a>
          <div class="message-date text-muted"><i class="fa fa-calendar"></i> <?php echo $this->Umb_model->set_date_format($cuti_notify->created_at);?></div>
        </li>
      <?php } ?>
    <?php } ?>
    <?php  if(in_array('44',$role_resources_ids)) { ?>  
      <?php foreach($this->Umb_model->hrastral_notifications('projects',$session['user_id']) as $nprj) {?>
        <?php $project_info = $result = $this->Project_model->read_informasi_project($nprj->module_id);?>
        <?php
        if(!is_null($project_info)){
         $iproject = $project_info[0]->title;
       } else {
         $iproject = '--';	
       }
       ?>
       <li class="list-group-item px-4">
        <a href="javascript:void(0)" class="message-sender flex-shrink-1 d-block text-body">
          <?php echo $this->lang->line('umb_projects');?>
        </a>
        <a href="<?php echo site_url('admin/project/detail')?>/<?php echo $nprj->module_id;?>/" class="message-subject flex-shrink-1 d-block text-body font-weight-bold">
          <?php echo $iproject;?>
        </a>
        <div class="message-date text-muted"><i class="fa fa-calendar"></i> <?php echo $this->Umb_model->set_date_format($nprj->created_at);?></div>
      </li>  
    <?php } ?> 
  <?php } ?>
  <?php  if(in_array('45',$role_resources_ids)) { ?>
   <?php foreach($this->Umb_model->hrastral_notifications('tugass',$session['user_id']) as $ntgs) {?>
     <?php $tugas_info = $this->Timesheet_model->read_informasi_tugas($ntgs->module_id);?>
     <?php
     if(!is_null($tugas_info)){
       $nama_tugas = $tugas_info[0]->nama_tugas;
     } else {
       $nama_tugas = '--';	
     }
     ?> 
     <li class="list-group-item px-4">
      <a href="javascript:void(0)" class="message-sender flex-shrink-1 d-block text-body">
        <?php echo $this->lang->line('umb_tugass');?>
      </a>
      <a href="<?php echo site_url('admin/timesheet/details_tugas')?>/id/<?php echo $ntgs->module_id;?>/" class="message-subject flex-shrink-1 d-block text-body font-weight-bold">
        <?php echo $nama_tugas;?>
      </a>
      <div class="message-date text-muted"><i class="fa fa-calendar"></i> <?php echo $this->Umb_model->set_date_format($ntgs->created_at);?></div>
    </li>
  <?php } ?>  
<?php } ?>
<?php  if(in_array('11',$role_resources_ids)) { ?>
 <?php foreach($this->Umb_model->hrastral_notifications('pengumuman',$session['user_id']) as $n_pngmn) {?>
   <?php $annc_info = $this->Pengumuman_model->read_informasi_pengumuman($n_pngmn->module_id);?>
   <?php
   if(!is_null($annc_info)){
     $annc_title = $annc_info[0]->title;
   } else {
     $annc_title = '--';	
   }
   ?>
   <li class="list-group-item px-4">
    <a href="javascript:void(0)" class="message-sender flex-shrink-1 d-block text-body">
      <?php echo $this->lang->line('dashboard_pengumumans');?>
    </a>
    <a href="<?php echo site_url('admin/pengumuman/index').'/'.$n_pngmn->module_id;?>" class="message-subject flex-shrink-1 d-block text-body font-weight-bold">
      <?php echo $annc_title;?>
    </a>
    <div class="message-date text-muted"><i class="fa fa-calendar"></i> <?php echo $this->Umb_model->set_date_format($n_pngmn->created_at);?></div>
  </li>
<?php } ?>  
<?php } ?>
<?php if($system[0]->module_inquiry=='true'){?>
  <?php  if(in_array('43',$role_resources_ids)) { ?>
   <?php foreach($this->Umb_model->hrastral_notifications('tickets',$session['user_id']) as $n_ticket) {?>
     <?php $ticket_info = $this->Tickets_model->read_informasi_ticket($n_ticket->module_id);?>
     <?php
     if(!is_null($ticket_info)){
       $subject = $ticket_info[0]->subject;
     } else {
       $subject = '--';	
     }
     ?>
     <li class="list-group-item px-4">
      <a href="javascript:void(0)" class="message-sender flex-shrink-1 d-block text-body">
        <?php echo $this->lang->line('left_tickets');?>
      </a>
      <a href="<?php echo site_url('admin/tickets/details')?>/<?php echo $n_ticket->module_id;?>" class="message-subject flex-shrink-1 d-block text-body font-weight-bold">
        <?php echo $subject;?>
      </a>
      <div class="message-date text-muted"><i class="fa fa-calendar"></i> <?php echo $this->Umb_model->set_date_format($n_ticket->created_at);?></div>
    </li>
  <?php } ?> 
<?php } ?>
<?php } ?>
<?php  if(in_array('25',$role_resources_ids)) { ?>
  <?php foreach($this->Umb_model->hrastral_notifications('asset',$session['user_id']) as $n_asset) {?>
   <?php $asset_info = $this->Assets_model->read_info_assets($n_asset->module_id);?>
   <?php
   if(!is_null($asset_info)){
     $nama_asset = $asset_info[0]->name;
   } else {
     $nama_asset = '--';	
   }
   ?>
   <li class="list-group-item px-4">
    <a href="javascript:void(0)" class="message-sender flex-shrink-1 d-block text-body">
      <?php echo $this->lang->line('umb_assets');?>
    </a>
    <a href="<?php echo site_url('admin/assets/index')?>/<?php echo $n_asset->module_id;?>" class="message-subject flex-shrink-1 d-block text-body font-weight-bold">
      <?php echo $nama_asset;?>
    </a>
    <div class="message-date text-muted"><i class="fa fa-calendar"></i> <?php echo $this->Umb_model->set_date_format($n_asset->created_at);?></div>
  </li>
<?php } ?>
<?php } ?>
<?php  if(in_array('14',$role_resources_ids)) { ?>
  <?php foreach($this->Umb_model->hrastral_notifications('awards',$session['user_id']) as $n_award) {?>
   <?php
   $info_award = $this->Awards_model->read_informasi_award($n_award->module_id);
   if(!is_null($info_award)){
			// get award type
     $type_award = $this->Awards_model->read_informasi_type_award($info_award[0]->type_award_id);
     if(!is_null($type_award)){
      $type_award = $type_award[0]->type_award;
    } else {
      $type_award = '--';	
    }
  } else {
   $type_award = '--';	
 }
 ?>
 <li class="list-group-item px-4">
  <a href="javascript:void(0)" class="message-sender flex-shrink-1 d-block text-body">
    <?php echo $this->lang->line('left_awards');?>
  </a>
  <a href="<?php echo site_url('admin/awards/index')?>/<?php echo $n_award->module_id;?>" class="message-subject flex-shrink-1 d-block text-body font-weight-bold">
    <?php echo $type_award;?>
  </a>
  <div class="message-date text-muted"><i class="fa fa-calendar"></i> <?php echo $this->Umb_model->set_date_format($n_award->created_at);?></div>
</li>
<?php } ?>
<?php } ?>
</ul>
<?php } else {?>
 <span class="mb-3 ml-5 text-center"><?php echo $this->lang->line('umb_no_nofitication_found');?></span>
 <hr class="border-light m-0">
<?php } ?>
</div>
<!-- / Messages list -->

</div><!-- / .row -->
</div><!-- / .card -->