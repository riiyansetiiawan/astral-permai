<?php
$session = $this->session->userdata('username');
$user_info = $this->Umb_model->read_user_info($session['user_id']);
$role_user = $this->Umb_model->read_user_role_info($user_info[0]->user_role_id);
if(!is_null($role_user)){
	$role_resources_ids = explode(',',$role_user[0]->role_resources);
} else {
	$role_resources_ids = explode(',',0);	
}
$iuser = $this->Umb_model->read_user_info($session['user_id']);
$system = $this->Umb_model->read_setting_info(1);
$get_animate = $this->Umb_model->get_content_animate();
$month_year = $this->input->post('month_year');
if($user_info[0]->user_role_id==1){
	
	$karyawan_id = $this->input->post('karyawan_id');
	$perusahaan_id = $this->input->post('perusahaan_id');
	//if(isset($perusahaan_id)){
	$date = strtotime(date("Y-m-d"));
	if(!isset($month_year)){
		$day = date('d', $date);
		$month = date('m', $date);
		$year = date('Y', $date);
	} else {
		$imonth_year = explode('-',$month_year);
		$day = date('d', $date);
		$month = date($imonth_year[1], $date);
		$year = date($imonth_year[0], $date);
	}
	if($karyawan_id == ''){
		$r = $this->Umb_model->read_user_info($session['user_id']);
	} else {
		$r = $this->Umb_model->read_user_info($karyawan_id);
	}
} else {
	$date = strtotime(date("Y-m-d"));
	if(!isset($month_year)){
		$day = date('d', $date);
		$month = date('m', $date);
		$year = date('Y', $date);
		$month_year = date('Y-m');
	} else {
		$imonth_year = explode('-',$month_year);
		$day = date('d', $date);
		$month = date($imonth_year[1], $date);
		$year = date($imonth_year[0], $date);
		$month_year = $month_year;
	}
	$r = $this->Umb_model->read_user_info($session['user_id']);
}
?>
<?php
$penunjukan = $this->Penunjukan_model->read_informasi_penunjukan($r[0]->penunjukan_id);
if(!is_null($penunjukan)){
	$nama_penunjukan = $penunjukan[0]->nama_penunjukan;
} else {
	$nama_penunjukan = '--';	
}
$department = $this->Department_model->read_informasi_department($r[0]->department_id);
if(!is_null($department)){
  $nama_department = $department[0]->nama_department;
} else {
  $nama_department = '--';	
}
$perusahaan = $this->Umb_model->read_info_perusahaan($r[0]->perusahaan_id);
if(!is_null($perusahaan)){
	$prshn_nama = $perusahaan[0]->name;
} else {
	$prshn_nama = '--';	
}
$daysInMonth =  date('t');
$imonth = date('F', $date);
$pcount = 0;
$acount = 0;
$lcount = 0;
for($i = 1; $i <= $daysInMonth; $i++):
	$i = str_pad($i, 2, 0, STR_PAD_LEFT);
	$tanggal_kehadiran = $year.'-'.$month.'-'.$i;
	$get_day = strtotime($tanggal_kehadiran);
	$day = date('l', $get_day);
	$user_id = $r[0]->user_id;
	$shift_kantor_id = $r[0]->shift_kantor_id;
	$status_kehadiran = '';
	$chck_tanggal_lbr = $this->Timesheet_model->check_tanggal_libur($tanggal_kehadiran);
	$libur_arr = array();
	if($chck_tanggal_lbr->num_rows() == 1){
		$h_date = $this->Timesheet_model->tanggal_libur($tanggal_kehadiran);
		$begin = new DateTime( $h_date[0]->start_date );
		$end = new DateTime( $h_date[0]->end_date);
		$end = $end->modify( '+1 day' ); 
		$interval = new DateInterval('P1D');
		$daterange = new DatePeriod($begin, $interval ,$end);
		foreach($daterange as $date){
			$libur_arr[] =  $date->format("Y-m-d");
		}
	} else {
		$libur_arr[] = '99-99-99';
	}
	$chck_tanggal_cuti = $this->Timesheet_model->chcek_tanggal_cuti($user_id,$tanggal_kehadiran);
	$cuti_arr = array();
	if($chck_tanggal_cuti->num_rows() == 1){
		$tanggal_cuti = $this->Timesheet_model->tanggal_cuti($user_id,$tanggal_kehadiran);
		$begin1 = new DateTime( $tanggal_cuti[0]->from_date );
		$end1 = new DateTime( $tanggal_cuti[0]->to_date);
		$end1 = $end1->modify( '+1 day' ); 
		$interval1 = new DateInterval('P1D');
		$daterange1 = new DatePeriod($begin1, $interval1 ,$end1);
		foreach($daterange1 as $date1){
			$cuti_arr[] =  $date1->format("Y-m-d");
		}
	} else {
		$cuti_arr[] = '99-99-99';
	}
	$shift_kantor = $this->Timesheet_model->read_informasi_shift_kantor($shift_kantor_id);
	$check = $this->Timesheet_model->check_kehadiran_pertama_masuk($user_id,$tanggal_kehadiran);
	if($shift_kantor[0]->senen_waktu_masuk == '' && $day == 'Monday') {
		$status = 'H';	
		$pcount += 0;
		//$acount += 0;
	} else if($shift_kantor[0]->selasa_waktu_masuk == '' && $day == 'Tuesday') {
		$status = 'H';
		$pcount += 0;
		//$acount += 0;
	} else if($shift_kantor[0]->rabu_waktu_masuk == '' && $day == 'Wednesday') {
		$status = 'H';
		$pcount += 0;
		//$acount += 0;
	} else if($shift_kantor[0]->kamis_waktu_masuk == '' && $day == 'Thursday') {
		$status = 'H';
		$pcount += 0;
		//$acount += 0;
	} else if($shift_kantor[0]->jumat_waktu_masuk == '' && $day == 'Friday') {
		$status = 'H';
		$pcount += 0;
		//$acount += 0;
	} else if($shift_kantor[0]->sabtu_waktu_masuk == '' && $day == 'Saturday') {
		$status = 'H';
		$pcount += 0;
		//$acount -= 1;
	} else if($shift_kantor[0]->minggu_waktu_masuk == '' && $day == 'Sunday') {
		$status = 'H';
		$pcount += 0;
		//$acount -= 1;
	} else if(in_array($tanggal_kehadiran,$libur_arr)) {
		$status = 'H';
		$pcount += 0;
		//$acount += 0;
	} else if(in_array($tanggal_kehadiran,$cuti_arr)) {
		$status = 'L';
		$pcount += 0;
		$lcount += 1;
	//	$acount += 0;
	} else if($check->num_rows() > 0){
		$pcount += 1;
		//$acount -= 1;
	}	else {
		$status = 'A';
		//$acount += 1;
		$pcount += 0;
		$itanggal_kehadiran = strtotime($tanggal_kehadiran);
		$icurrent_date = strtotime(date('Y-m-d'));
		if($itanggal_kehadiran <= $icurrent_date){
			$acount += 1;
		} else {
			$acount += 0;
		}
	}
endfor;
//}
?>
<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('423',$role_resources_ids)) { ?>
      <li class="nav-item clickable"> 
        <a href="<?php echo site_url('admin/timesheet/dashboard_kehadiran/');?>" data-link-data="<?php echo site_url('admin/timesheet/dashboard_kehadiran/');?>" class="mb-3 nav-link hrastral-link"> 
          <span class="sw-icon ion ion-md-speedometer"></span> 
          <?php echo $this->lang->line('dashboard_title');?>
          <div class="text-muted small"><?php echo $this->lang->line('hr_title_dashboard_timesheet');?></div>
        </a> 
      </li>
    <?php } ?>
    <?php if(in_array('28',$role_resources_ids)) { ?>
      <li class="nav-item clickable"> 
        <a href="<?php echo site_url('admin/timesheet/kehadiran/');?>" data-link-data="<?php echo site_url('admin/timesheet/kehadiran/');?>" class="mb-3 nav-link hrastral-link"> 
          <span class="sw-icon ion ion-md-clock"></span> 
          <?php echo $this->lang->line('left_kehadiran');?>
          <div class="text-muted small"><?php echo $this->lang->line('left_kehadiran');?> <?php echo $this->lang->line('umb_list_role');?></div>
        </a> 
      </li>
    <?php } ?>
    <?php if(in_array('30',$role_resources_ids)) { ?>
      <li class="nav-item clickable"> 
        <a href="<?php echo site_url('admin/timesheet/update_kehadiran');?>" data-link-data="<?php echo site_url('admin/timesheet/update_kehadiran');?>" class="mb-3 nav-link hrastral-link"> 
          <span class="sw-icon fas fa-pencil-alt"></span> 
          <?php echo $this->lang->line('left_update_kehadiran');?>
          <div class="text-muted small"><?php echo $this->lang->line('umb_add_edit_info');?> <?php echo $this->lang->line('left_kehadiran');?></div>
        </a> 
      </li>
    <?php } ?>
    <?php if(in_array('10',$role_resources_ids)) { ?>
      <li class="nav-item clickable"> 
        <a href="<?php echo site_url('admin/timesheet/');?>" data-link-data="<?php echo site_url('admin/timesheet/');?>" class="mb-3 nav-link hrastral-link"> 
          <span class="sw-icon fas fa-calendar-alt"></span> 
          <?php echo $this->lang->line('umb_month_timesheet_title');?>
          <div class="text-muted small"><?php echo $this->lang->line('umb_view_all');?></div>
        </a> 
      </li>
    <?php } ?>
    <?php if(in_array('261',$role_resources_ids)) { ?>
      <li class="nav-item active"> 
        <a href="<?php echo site_url('admin/timesheet/timecalendar/');?>" data-link-data="<?php echo site_url('admin/timesheet/timecalendar/');?>" class="mb-3 nav-link hrastral-link"> 
          <span class="sw-icon ion ion-md-calendar"></span> 
          <?php echo $this->lang->line('umb_acc_calendar');?>
          <div class="text-muted small"><?php echo $this->lang->line('umb_view');?> <?php echo $this->lang->line('umb_acc_calendar');?></div>
        </a> 
      </li>
    <?php } ?>
    <?php if(in_array('401',$role_resources_ids)) { ?>
      <li class="nav-item clickable"> 
        <a href="<?php echo site_url('admin/permintaan_lembur/');?>" data-link-data="<?php echo site_url('admin/permintaan_lembur/');?>" class="mb-3 nav-link hrastral-link">
          <span class="sw-icon ion ion-md-timer"></span> 
          <?php echo $this->lang->line('umb_permintaan_lembur');?>
          <div class="text-muted small"><?php echo $this->lang->line('umb_role_add');?> <?php echo $this->lang->line('umb_permintaan_lembur');?></div>
        </a> 
      </li>
    <?php } ?>
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<div class="ui-bordered px-4 pt-4 mb-4">
  <?php $attributes = array('name' => 'umb-form', 'id' => 'umb-form', 'autocomplete' => 'off');?>
  <?php $hidden = array('_user' => $session['user_id']);?>
  <?php echo form_open('admin/timesheet/timecalendar/', $attributes, $hidden);?>
  <div class="form-row">
    <div class="col-md mb-4">
      <label class="form-label"><?php echo $this->lang->line('umb_e_details_tanggal');?></label>
      <input class="form-control hr_month_year" value="<?php if(!isset($month_year)): echo date('Y-m'); else: echo $month_year; endif;?>" name="month_year" type="text">
    </div>
    <?php if($user_info[0]->user_role_id==1){?>
      <div class="col-md mb-4">
        <label class="form-label"><?php echo $this->lang->line('left_perusahaan');?></label>
        <select class="form-control" name="perusahaan_id" id="aj_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_perusahaan');?>" required>
          <option value=""></option>
          <?php foreach($get_all_perusahaans as $perusahaan) {?>
            <option value="<?php echo $perusahaan->perusahaan_id?>" <?php if(isset($karyawan_id)): if($perusahaan->perusahaan_id==$perusahaan_id): ?> selected="selected" <?php endif; endif;?>><?php echo $perusahaan->name?></option>
          <?php } ?>
        </select>
      </div>
      <div class="col-md mb-3" id="ajax_karyawan">
        <label class="form-label"><?php echo $this->lang->line('umb_karyawan');?></label>
        <select name="karyawan_id" id="karyawan_id" class="form-control karyawan-data" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_choose_an_karyawan');?>" required>
          <?php if(isset($karyawan_id)): ?>
            <?php $result = $this->Department_model->ajax_info_perusahaan_karyawan($perusahaan_id); ?>
            <option value="0">All</option>
            <?php foreach($result as $karyawan) {?>
              <option value="<?php echo $karyawan->user_id;?>" <?php if($karyawan->user_id==$karyawan_id): ?> selected="selected" <?php endif;?>> <?php echo $karyawan->first_name.' '.$karyawan->last_name;?></option>
            <?php } ?>
          <?php endif;?>
        </select>
      </div>
    <?php } ?>
    <div class="col-md col-xl-2 mb-4">
      <label class="form-label d-none d-md-block">&nbsp;</label>
      <button type="submit" class="btn btn-secondary btn-block"><?php echo $this->lang->line('umb_get');?></button>
    </div>
  </div>
  <?php echo form_close(); ?> 
</div>
<?php if(isset($perusahaan_id) || $user_info[0]->user_role_id!=1){?>
  <div class="row <?php echo $get_animate;?>">
    <div class="col-md-4">
      <div class="card">
        <div class="card-header with-elements"> 
          <span class="card-header-title mr-2">
            <strong><?php echo $r[0]->first_name.' '.$r[0]->last_name;?> - <?php echo date('F Y',strtotime($month_year));?></strong>
          </span> 
        </div>
        <div class="card-body">
          <div class="table-responsive" data-pattern="priority-columns">
            <table class="table table-striped m-md-b-0">
              <tbody>
                <tr>
                  <th scope="row"><?php echo $this->lang->line('left_perusahaan');?></th>
                  <td class="text-right"><?php echo $prshn_nama;?></td>
                </tr>
                <tr>
                  <th scope="row" style="border-top:0px;"><?php echo $this->lang->line('left_department');?></th>
                  <td class="text-right"><?php echo $nama_department;?></td>
                </tr>
                <tr>
                  <th scope="row" style="border-top:0px;"><?php echo $this->lang->line('left_penunjukan');?></th>
                  <td class="text-right"><?php echo $nama_penunjukan;?></td>
                </tr>
                <tr>
                  <th scope="row"><?php echo $this->lang->line('dashboard_karyawan_id');?></th>
                  <td class="text-right"><?php echo $r[0]->karyawan_id;?></td>
                </tr>
                <tr>
                  <th scope="row"><?php echo $this->lang->line('umb_kehadiran_total_present');?></th>
                  <td class="text-right"><?php echo $pcount;?></td>
                </tr>
                <tr>
                  <th scope="row"><?php echo $this->lang->line('umb_kehadiran_total_absent');?></th>
                  <td class="text-right"><?php echo $acount;?></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-8">
      <div class="card">
        <div class="card-body">
          <div id='calendar_hr'></div>
        </div>
      </div>
    </div>
  </div>
  <style type="text/css">
  .popoverTitleCalendar{
    width: 100%;
    height: 100%;
    padding: 15px 15px;
    font-family: Roboto;
    font-size: 13px;
    border-radius: 5px 5px 0 0;
  }
  .popoverInfoCalendar i{
    font-size: 14px;
    margin-right: 10px;
    line-height: inherit;
    color: #d3d4da;
  }
  .popoverInfoCalendar p{
    margin-bottom: 1px;
  }
  .popoverDescCalendar{
    margin-top: 12px;
    padding-top: 12px;
    border-top: 1px solid #E3E3E3;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
  }
  .popover-title {
    background: transparent;
    font-weight: 600;
    padding: 0 !important;
    border: none;
  }
  .popover-content {
    padding: 15px 15px;
    font-family: Roboto;
    font-size: 13px;
  }
  .fc-center h2{
    text-transform: uppercase;
    font-size: 18px;
    font-family: Roboto;
    font-weight: 500;
    color: #505363;
    line-height: 32px;
  }
  .fc-toolbar.fc-header-toolbar {
    margin-bottom: 22px;
    padding-top: 22px;
  }
  .fc-agenda-view .fc-day-grid .fc-row .fc-content-skeleton {
    padding-bottom: 1em;
    padding-top: 1em;
  }
  .fc-day{
    transition: all 0.2s linear;
  }
  .fc-day:hover{
    background:#EEF7FF;
    cursor: pointer;
    transition: all 0.2s linear;
  }
  .fc-highlight {
    background: #EEF7FF;
    opacity: 0.7;
  }
  .fc-time-grid-event.fc-short .fc-time:before {
    content: attr(data-start);
    display: none;
  }
  .fc-time-grid-event.fc-short .fc-time span {
    display: inline-block;
  }
  .fc-time-grid-event.fc-short .fc-avatar-image {
    display: none;
    transition: all 0.3s linear;
  }
  .fc-time-grid .fc-bgevent, .fc-time-grid .fc-event {
    border: 1px solid #fff !important;
  }
  .fc-time-grid-event.fc-short .fc-content {
    padding: 4px 20px 10px 22px !important;
  }
  .fc-time-grid-event .fc-avatar-image{
    top: 9px;
  }
  .fc-event-vert {
    min-height: 22px;
  }
  .fc .fc-axis {
    vertical-align: middle;
    padding: 0 4px;
    white-space: nowrap;
    font-size: 10px;
    color: #505362;
    text-transform: uppercase;
    text-align: center !important;
    background-color: #fafafa;
  }
  .fc-unthemed .fc-event .fc-content, .fc-unthemed .fc-event-dot .fc-content {
    padding: 10px 20px 10px 22px;
    font-family: 'Roboto', sans-serif;
    margin-left: -1px;
    height: 100%;
  }
  .fc-event{
    border: none !important;
  }
  .fc-day-grid-event .fc-time {
    font-weight: 700;
    text-transform: uppercase;
  }
  .fc-unthemed .fc-day-grid td:not(.fc-axis).fc-event-container {
    padding: 0.2rem 0.5rem;
  }
  .fc-unthemed .fc-content, .fc-unthemed .fc-divider, .fc-unthemed .fc-list-heading td, .fc-unthemed .fc-list-view, .fc-unthemed .fc-popover, .fc-unthemed .fc-row, .fc-unthemed tbody, .fc-unthemed td, .fc-unthemed th, .fc-unthemed thead {
    border-color: #DADFEA;
  }
  .fc-ltr .fc-h-event .fc-end-resizer, .fc-ltr .fc-h-event .fc-end-resizer:before, .fc-ltr .fc-h-event .fc-end-resizer:after, .fc-rtl .fc-h-event .fc-start-resizer, .fc-rtl .fc-h-event .fc-start-resizer:before, .fc-rtl .fc-h-event .fc-start-resizer:after {
    left: auto;
    cursor: e-resize;
    background: none;
  }
  .colorAppointment :before {
    background-color: #9F4AFF;
    border-right: 1px solid rgba(255, 255, 255, 0.6);
    display: block;
    content: " ";
    position: absolute;
    height: 100%;
    width: 8px;
    border-radius: 3px 0 0 3px;
    top: 0;
    left: -1px;
  }
  .colorCheck-in :before {
    background-color: #ff4747;
    border-right: 1px solid rgba(255, 255, 255, 0.6);
    display: block;
    content: " ";
    position: absolute;
    height: 100%;
    width: 8px;
    border-radius: 3px 0 0 3px;
    top: 0;
    left: -1px;
  }
  .colorCheckout :before {
    background-color: #FFC400;
    border-right: 1px solid rgba(255, 255, 255, 0.6);
    display: block;
    content: " ";
    position: absolute;
    height: 100%;
    width: 8px;
    border-radius: 3px 0 0 3px;
    top: 0;
    left: -1px;
  }
  .colorInventory :before {
    background-color: #FE56F2;
    border-right: 1px solid rgba(255, 255, 255, 0.6);
    display: block;
    content: " ";
    position: absolute;
    height: 100%;
    width: 8px;
    border-radius: 3px 0 0 3px;
    top: 0;
    left: -1px;
  }
  .colorValuation :before {
    background-color: #0DE882;
    border-right: 1px solid rgba(255, 255, 255, 0.6);
    display: block;
    content: " ";
    position: absolute;
    height: 100%;
    width: 8px;
    border-radius: 3px 0 0 3px;
    top: 0;
    left: -1px;
  }
  .colorViewing :before {
    background-color: #26CBFF;
    border-right: 1px solid rgba(255, 255, 255, 0.6);
    display: block;
    content: " ";
    position: absolute;
    height: 100%;
    width: 8px;
    border-radius: 3px 0 0 3px;
    top: 0;
    left: -1px;
  }
  select.filter{
    width: 500px !important;
  }

  .popover  {
    background: #fff !important;
    color: #2E2F34;
    border: none;
    margin-bottom: 10px;
  }
  .popover-title{
    background: #F7F7FC;
    font-weight: 600;
    padding: 15px 15px 11px ;
    border: none;
  }

  .popover.top .arrow:after {
    border-top-color: #fff;
  }

  .popover.right .arrow:after {
    border-right-color: #fff;
  }

  .popover.bottom .arrow:after {
    border-bottom-color: #fff;
  }

  .popover.left .arrow:after {
    border-left-color: #fff;
  }

  .popover.bottom .arrow:after {
    border-bottom-color: #fff;
  }
  .material-icons {
    font-family: 'Material Icons';
    font-weight: normal;
    font-style: normal;
    font-size: 24px;
    display: inline-block;
    line-height: 1;
    text-transform: none;
    letter-spacing: normal;
    word-wrap: normal;
    white-space: nowrap;
    direction: ltr;
    -webkit-font-smoothing: antialiased;
    text-rendering: optimizeLegibility;
    -moz-osx-font-smoothing: grayscale;
    font-feature-settings: 'liga';
  }
  .fc-icon-print::before{
    font-family: 'Material Icons';
    content: "\e8ad";
    font-size: 24px;
  }
  .fc-printButton-button{
    padding: 0 3px !important;
  }

  @media print {
    .print-visible  { display: inherit !important; }
    .hidden-print   { display: none !important; }
  }
</style>
<?php } ?>
<style type="text/css">
.calendar-options { padding: .3rem 0.4rem !important;}
.hide-calendar .ui-datepicker-calendar { display:none !important; }
.hide-calendar .ui-priority-secondary { display:none !important; }
</style>
