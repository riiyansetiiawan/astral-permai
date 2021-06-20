<?php 
$session = $this->session->userdata('username');
$user_info = $this->Eumb_model->read_user_info($session['user_id']);
$theme = $this->Umb_model->read_theme_info(1);
if($user_info[0]->profile_picture!='' && $user_info[0]->profile_picture!='no file') {
	$lde_file = base_url().'uploads/profile/'.$user_info[0]->profile_picture;
} else { 
	if($user_info[0]->jenis_kelamin=='Pria') {  
		$lde_file = base_url().'uploads/profile/default_male.jpg'; 
	} else {  
		$lde_file = base_url().'uploads/profile/default_female.jpg';
	}
}
$terakhir_login =  new DateTime($user_info[0]->tanggal_terakhir_login);
$penunjukan = $this->Penunjukan_model->read_informasi_penunjukan($user_info[0]->penunjukan_id);
if(!is_null($penunjukan)){
	$nama_penunjukan = $penunjukan[0]->nama_penunjukan;
} else {
	$nama_penunjukan = '--';	
}
$role_user = $this->Umb_model->read_user_role_info($user_info[0]->user_role_id);
if(!is_null($role_user)){
	$role_resources_ids = explode(',',$role_user[0]->role_resources);
} else {
	$role_resources_ids = explode(',',0);	
}
?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>
<?php $system = $this->Umb_model->read_setting_info(1);?>
<?php $pengumuman = $this->Pengumuman_model->get_pengumuman_barus();?>
<?php foreach($pengumuman as $pengumuman_baru):?>
  <?php
  $current_date = strtotime(date('Y-m-d'));
  $tanggal_akhir_pengumuman = strtotime($pengumuman_baru->end_date);
  if($current_date <= $tanggal_akhir_pengumuman) {
    ?>
    <div class="alert alert-success alert-dismissible fade in mb-1" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"> 
        <span aria-hidden="true">×</span> 
      </button>
      <strong><?php echo $pengumuman_baru->title;?>:</strong> 
      <?php echo $pengumuman_baru->summary;?>
      <a href="#" class="alert-link" data-toggle="modal" data-target=".view-modal-pengumuman" data-pengumuman_id="<?php echo $pengumuman_baru->pengumuman_id;?>"><?php echo $this->lang->line('umb_view');?></a> 
    </div>
  <?php } ?>
<?php endforeach;?>
<div class="row <?php echo $get_animate;?>">
  <?php if(in_array('14',$role_resources_ids)) { ?>
    <?php if($system[0]->module_awards=='true'){?>
      <div class="col-xl-6 col-md-3 col-12 hr-mini-state"> 
        <a class="text-muted" href="<?php echo site_url('admin/awards/');?>">
          <div class="info-box hrsalle-mini-stat"> 
            <span class="info-box-icon bg-primary">
              <i class="fa fa-trophy"></i>
            </span>
            <div class="info-box-content">
              <span class="info-box-number"><?php echo $this->Eumb_model->dash_total_awards_karyawan();?> <?php echo $this->lang->line('left_awards');?></span> 
              <span class="info-box-text">
                <span class=""> <?php echo $this->lang->line('umb_view');?> </span>
              </span>
            </div>
          </div>
        </a>
      </div>
    <?php } else {?>
      <div class="col-xl-6 col-md-3 col-12 hr-mini-state"> 
        <a class="text-muted" href="<?php echo site_url('admin/timesheet/kehadiran/');?>">
          <div class="info-box hrsalle-mini-stat"> 
            <span class="info-box-icon bg-primary">
              <i class="fa fa-clock-o"></i>
            </span>
            <div class="info-box-content"> 
              <span class="info-box-number"><?php echo $this->lang->line('dashboard_kehadiran');?></span> 
              <span class="info-box-text"><?php echo $this->lang->line('umb_view');?></span> 
            </div>
          </div>
        </a> 
      </div>
    <?php } ?>
  <?php } ?>
  <?php if(in_array('37',$role_resources_ids)) { ?>
    <div class="col-xl-6 col-md-3 col-12 hr-mini-state"> 
      <a class="text-muted" href="<?php echo site_url('admin/payroll/history_pembayaran/');?>">
        <div class="info-box hrsalle-mini-stat"> 
          <span class="info-box-icon bg-red">
            <i class="fa fa-money"></i>
          </span>
          <div class="info-box-content"> 
            <span class="info-box-number"><?php echo $this->lang->line('left_slipgajii');?> <?php echo $this->lang->line('umb_view');?></span>
          </div>
        </div>
      </a> 
    </div>
  <?php } ?>
  <?php if(in_array('46',$role_resources_ids)) { ?>
    <div class="clearfix visible-sm-block"></div>
    <div class="col-xl-6 col-md-3 col-12 hr-mini-state"> 
      <a class="text-muted" href="<?php echo site_url('admin/timesheet/cuti/');?>">
        <div class="info-box hrsalle-mini-stat"> 
          <span class="info-box-icon bg-purple">
            <i class="fa fa-calendar"></i>
          </span>
          <div class="info-box-content"> 
            <span class="info-box-number"><?php echo $this->lang->line('umb_performance_management');?> <?php echo $this->lang->line('left_cuti');?></span>
          </div> 
        </div>
      </a> 
    </div>
  <?php } ?>
  <?php if($system[0]->module_perjalanan=='true'){?>
    <?php if(in_array('17',$role_resources_ids)) { ?>
      <div class="col-xl-6 col-md-3 col-12 hr-mini-state"> <a class="text-muted" href="<?php echo site_url('admin/perjalanan/');?>">
        <div class="info-box hrsalle-mini-stat"> 
          <span class="info-box-icon bg-red">
            <i class="fa fa-plane"></i>
          </span>
          <div class="info-box-content"> 
            <span class="info-box-number"><?php echo $this->lang->line('umb_perjalanan');?> <?php echo $this->lang->line('umb_requests');?></span>
          </div>
        </div>
      </a> 
    </div>  
  <?php } ?>
<?php } ?>
</div>
<?php
$hadir_tanggal =  date('d-M-Y');
$tanggal_kehadiran = date('d-M-Y');
$get_day = strtotime($hadir_tanggal);
$day = date('l', $get_day);
$strtotime = strtotime($tanggal_kehadiran);
$new_date = date('d-M-Y', $strtotime);
$u_shift = $this->Timesheet_model->read_informasi_shift_kantor($user_info[0]->shift_kantor_id);
if($day == 'Monday') {
	if($u_shift[0]->senen_waktu_masuk==''){
		$shift_kantor = $this->lang->line('dashboard_shift_hari_senen');
	} else {
		$in_time =  new DateTime($u_shift[0]->senen_waktu_masuk. ' ' .$tanggal_kehadiran);
		$out_time =  new DateTime($u_shift[0]->senen_waktu_pulang. ' ' .$tanggal_kehadiran);
		$clock_in = $in_time->format('h:i a');
		$clock_out = $out_time->format('h:i a');
		$shift_kantor = $this->lang->line('dashboard_shift_kantor').': '.$clock_in.' '.$this->lang->line('dashboard_to').' '.$clock_out;
	}
} else if($day == 'Tuesday') {
	if($u_shift[0]->selasa_waktu_masuk==''){
		$shift_kantor = $this->lang->line('dashboard_shift_hari_selasa');
	} else {
		$in_time =  new DateTime($u_shift[0]->selasa_waktu_masuk. ' ' .$tanggal_kehadiran);
		$out_time =  new DateTime($u_shift[0]->selasa_waktu_pulang. ' ' .$tanggal_kehadiran);
		$clock_in = $in_time->format('h:i a');
		$clock_out = $out_time->format('h:i a');
		$shift_kantor = $this->lang->line('dashboard_shift_kantor').': '.$clock_in.' '.$this->lang->line('dashboard_to').' '.$clock_out;
	}
} else if($day == 'Wednesday') {
	if($u_shift[0]->rabu_waktu_masuk==''){
		$shift_kantor = $this->lang->line('dashboard_shift_hari_rabu');
	} else {
		$in_time =  new DateTime($u_shift[0]->rabu_waktu_masuk. ' ' .$tanggal_kehadiran);
		$out_time =  new DateTime($u_shift[0]->rabu_waktu_pulang. ' ' .$tanggal_kehadiran);
		$clock_in = $in_time->format('h:i a');
		$clock_out = $out_time->format('h:i a');
		$shift_kantor = $this->lang->line('dashboard_shift_kantor').': '.$clock_in.' '.$this->lang->line('dashboard_to').' '.$clock_out;
	}
} else if($day == 'Thursday') {
	if($u_shift[0]->kamis_waktu_masuk==''){
		$shift_kantor = $this->lang->line('dashboard_shift_hari_kamis');
	} else {
		$in_time =  new DateTime($u_shift[0]->kamis_waktu_masuk. ' ' .$tanggal_kehadiran);
		$out_time =  new DateTime($u_shift[0]->kamis_waktu_pulang. ' ' .$tanggal_kehadiran);
		$clock_in = $in_time->format('h:i a');
		$clock_out = $out_time->format('h:i a');
		$shift_kantor = $this->lang->line('dashboard_shift_kantor').': '.$clock_in.' '.$this->lang->line('dashboard_to').' '.$clock_out;
	}
} else if($day == 'Friday') {
	if($u_shift[0]->jumat_waktu_masuk==''){
		$shift_kantor = $this->lang->line('dashboard_shift_hari_jumat');
	} else {
		$in_time =  new DateTime($u_shift[0]->jumat_waktu_masuk. ' ' .$tanggal_kehadiran);
		$out_time =  new DateTime($u_shift[0]->jumat_waktu_pulang. ' ' .$tanggal_kehadiran);
		$clock_in = $in_time->format('h:i a');
		$clock_out = $out_time->format('h:i a');
		$shift_kantor = $this->lang->line('dashboard_shift_kantor').': '.$clock_in.' '.$this->lang->line('dashboard_to').' '.$clock_out;
	}
} else if($day == 'Saturday') {
	if($u_shift[0]->sabtu_waktu_masuk==''){
		$shift_kantor = $this->lang->line('dashboard_shift_hari_sabtu');
	} else {
		$in_time =  new DateTime($u_shift[0]->sabtu_waktu_masuk. ' ' .$tanggal_kehadiran);
		$out_time =  new DateTime($u_shift[0]->sabtu_waktu_pulang. ' ' .$tanggal_kehadiran);
		$clock_in = $in_time->format('h:i a');
		$clock_out = $out_time->format('h:i a');
		$shift_kantor = $this->lang->line('dashboard_shift_kantor').': '.$clock_in.' '.$this->lang->line('dashboard_to').' '.$clock_out;
	}
} else if($day == 'Sunday') {
	if($u_shift[0]->minggu_waktu_masuk==''){
		$shift_kantor = $this->lang->line('dashboard_shift_hari_minggu');
	} else {
		$in_time =  new DateTime($u_shift[0]->minggu_waktu_masuk. ' ' .$tanggal_kehadiran);
		$out_time =  new DateTime($u_shift[0]->minggu_waktu_pulang. ' ' .$tanggal_kehadiran);
		$clock_in = $in_time->format('h:i a');
		$clock_out = $out_time->format('h:i a');
		$shift_kantor = $this->lang->line('dashboard_shift_kantor').': '.$clock_in.' '.$this->lang->line('dashboard_to').' '.$clock_out;
	}
}
?>
<?php $sys_arr = explode(',',$system[0]->system_ip_address); ?>
<?php $kehairans = $this->Timesheet_model->checks_waktu_kehadiran($user_info[0]->user_id); $dat = $kehairans->result();?>
<?php
$bgatt = 'bg-success';
if($kehairans->num_rows() < 1) {
	$bgatt = 'bg-success';
} else {
	$bgatt = 'bg-danger';
}
?>
<div class="row <?php echo $get_animate;?>">
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="box box-body bg-hr-primary">
      <div class="flexbox"> 
        <span class="fa fa-life-bouy text-primary font-size-50"></span> 
        <span class="font-size-40 font-weight-400"><?php echo cr_quote_quoted();?></span> 
      </div>
      <div class="text-right"><?php echo $this->lang->line('umb_quoted_title');?></div>
    </div>
  </div>
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="box box-body bg-hr-danger">
      <div class="flexbox"> 
        <span class="fa fa-server text-danger font-size-50"></span> 
        <span class="font-size-40 font-weight-400"><?php echo cr_quote_project_created();?></span> 
      </div>
      <div class="text-right"><?php echo $this->lang->line('umb_q_project_created');?></div>
    </div>
  </div>
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="box box-body bg-hr-success">
      <div class="flexbox"> 
        <span class="ion ion-thumbsup text-success font-size-50"></span> 
        <span class="font-size-40 font-weight-400"><?php echo cr_quote_inprogress();?></span> 
      </div>
      <div class="text-right"><?php echo $this->lang->line('umb_in_progress');?></div>
    </div>
  </div>
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="box box-body bg-hr-yellow">
      <div class="flexbox"> 
        <span class="fa fa-cube text-yellow font-size-50"></span> 
        <span class="font-size-40 font-weight-400"><?php echo cr_quote_project_completed();?></span> 
      </div>
      <div class="text-right"><?php echo $this->lang->line('umb_q_project_completed');?></div>
    </div>
  </div>
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="box box-body bg-hr-yellow">
      <div class="flexbox"> 
        <span class="ion ion-thumbsup text-danger font-size-50"></span> 
        <span class="font-size-40 font-weight-400"><?php echo cr_quote_invoiced();?></span> 
      </div>
      <div class="text-right"><?php echo $this->lang->line('umb_quote_invoiced');?></div>
    </div>
  </div>
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="box box-body bg-hr-yellow">
      <div class="flexbox"> 
        <span class="fa fa-cube text-yellow font-size-50"></span> 
        <span class="font-size-40 font-weight-400"><?php echo cr_quote_bayar();?></span> 
      </div>
      <div class="text-right"><?php echo $this->lang->line('umb_payment_bayar');?></div>
    </div>
  </div>
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="box box-body bg-hr-yellow">
      <div class="flexbox"> 
        <span class="fa fa-server text-success font-size-50"></span> 
        <span class="font-size-40 font-weight-400"><?php echo cr_quote_deffered();?></span> 
      </div>
      <div class="text-right"><?php echo $this->lang->line('umb_quote_deffered');?></div>
    </div>
  </div>
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="box box-body bg-hr-green">
      <div class="flexbox"> 
        <span class="fa fa-cube text-yellow font-size-50"></span> 
        <span class="font-size-40 font-weight-400"><?php echo cr_quote_project_completed();?></span> 
      </div>
      <div class="text-right"><?php echo $this->lang->line('umb_q_project_completed');?></div>
    </div>
  </div>
</div>
<?php if(in_array('44',$role_resources_ids)) { ?>
  <div class="row match-height">
    <?php if($system[0]->module_projects_tugass=='true'){?>
      <div class="col-xl-8 col-lg-8">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title"><?php echo $this->lang->line('dashboard_projects_saya');?></h3>
          </div>
          <div class="box-body">
            <div class="box-block">
              <p>
                <?php echo $this->lang->line('umb_my_assigned_projects');?> 
                <span class="float-xs-right">
                  <a href="<?php echo site_url('admin/project');?>">
                    <?php echo $this->lang->line('umb_more_projects');?> 
                    <i class="ft-arrow-right"></i>
                  </a>
                </span>
              </p>
            </div>
            <div class="table-responsive" style="height:250px;">
              <table id="recent-orderss" class="table table-hover mb-0 ps-container ps-theme-default">
                <thead>
                  <tr>
                    <th><?php echo $this->lang->line('dashboard_umb_title');?></th>
                    <th><?php echo $this->lang->line('umb_p_priority');?></th>
                    <th><?php echo $this->lang->line('dashboard_tanggal_project');?></th>
                    <th><?php echo $this->lang->line('dashboard_umb_status');?></th>
                    <th><?php echo $this->lang->line('dashboard_umb_progress');?></th>
                  </tr>
                </thead>
                <tbody>
                  <?php $project = $this->Project_model->get_projects();?>
                  <?php $dId = array(); $i=1; foreach($project->result() as $pj):
                  // $aw_name = $hrm->e_type_award($emp_award->type_award_id);
                  $asd = array($pj->assigned_to);
                  $aim = explode(',',$pj->assigned_to);
                  foreach($aim as $dIds) {
                   if($session['user_id'] === $dIds) {
                    $dId[] = $session['user_id'];
                    $pdate = $this->Umb_model->set_date_format($pj->end_date);
                    if($pj->progress_project <= 20) {
                      $progress_class = 'progress-danger';
                    } else if($pj->progress_project > 20 && $pj->progress_project <= 50){
                      $progress_class = 'progress-warning';
                    } else if($pj->progress_project > 50 && $pj->progress_project <= 75){
                      $progress_class = 'progress-info';
                    } else {
                      $progress_class = 'progress-success';
                    }
                    if($pj->status == 0) {
                      $status = $this->lang->line('umb_not_started');
                    } else if($pj->status ==1){
                      $status = $this->lang->line('umb_in_progress');
                    } else if($pj->status ==2){
                      $status = $this->lang->line('umb_completed');
                    } else {
                      $status = $this->lang->line('umb_deffered');
                    }
                    if($pj->priority == 1) {
                      $priority = '<span class="tag tag-danger">'.$this->lang->line('umb_highest').'</span>';
                    } else if($pj->priority ==2){
                      $priority = '<span class="tag tag-danger">'.$this->lang->line('umb_high').'</span>';
                    } else if($pj->priority ==3){
                      $priority = '<span class="tag tag-primary">'.$this->lang->line('umb_normal').'</span>';
                    } else {
                      $priority = '<span class="tag tag-success">'.$this->lang->line('umb_low').'</span>';
                    }
                    ?>
                    <tr>
                      <td class="text-truncate">
                        <a href="<?php echo site_url();?>admin/project/detail/<?php echo $pj->project_id;?>/"><?php echo $pj->title;?></a>
                      </td>
                      <td class="text-truncate"><?php echo $priority;?></td>
                      <td class="text-truncate">
                        <i class="fa fa-calendar position-left"></i> 
                        <?php echo $pdate;?>
                      </td>
                      <td class="text-truncate"><?php echo $status;?></td>
                      <td class="text-truncate">
                        <p class="m-b-0-5">
                          <?php echo $this->lang->line('dashboard_completed');?> 
                          <span class="pull-xs-right"><?php echo $pj->progress_project;?>%</span>
                        </p>
                        <progress class="progress <?php echo $progress_class;?> progress-sm d-inline-block mb-0" value="<?php echo $pj->progress_project;?>" max="100"><?php echo $pj->progress_project;?>%</progress>
                      </td>
                    </tr>
                  <?php }
                } ?>
                <?php $i++; endforeach;?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <?php //} else {?>
      <div class="col-xl-4 col-lg-4">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title"><?php echo $this->lang->line('dashboard_recruitment');?> <?php echo $this->lang->line('dashboard_timeline');?></h3>
          </div>
          <div class="box-body px-1">
            <div id="recent-buyers" class="list-group scrollable-container height-300 position-relative">
              <?php foreach($all_pekerjaans as $pekerjaan):?>
                <?php $jtype = $this->Post_pekerjaan_model->read_informasi_type_pekerjaan($pekerjaan->type_pekerjaan); ?>
                <?php
                if(!is_null($jtype)){
                  $jt_type = $jtype[0]->type;
                } else {
                  $jt_type = '--';	
                }
                ?>
                <a href="<?php echo site_url('frontend/pekerjaans/detail/').$pekerjaan->pekerjaan_id;?>/" class="list-group-item list-group-item-action media no-border">
                  <div class="media-body">
                    <h6 class="list-group-item-heading">
                      <?php echo $pekerjaan->title_pekerjaan;?> 
                      <span class="float-xs-right pt-1">
                        <span class="tag tag-warning ml-1"><?php echo $jt_type;?></span>
                      </span>
                    </h6>
                  </div>
                </a>
              <?php endforeach;?>
            </div>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>
<?php } ?>
<?php if($theme[0]->dashboard_calendar == 'true'):?>
  <?php $this->load->view('admin/calendar/calendar_hr');?>
<?php endif; ?>
<style type="text/css">
  .btn-group {
   margin-top:5px !important;
 }
</style>