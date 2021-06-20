<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>
<?php $role_resources_ids = $this->Umb_model->user_role_resource();?>
<?php $user_info = $this->Umb_model->read_user_info($session['user_id']);?>
<?php
$month_year = $this->input->post('month_year');
if($user_info[0]->user_role_id==1){
	$karyawan_id = $this->input->post('karyawan_id');
	$perusahaan_id = $this->input->post('perusahaan_id');
	/* Set the date */
	$date = strtotime(date("Y-m-d"));
	// get month and year
	if(!isset($month_year)){
		$day = date('d', $date);
		$month = date('m', $date);
		$year = date('Y', $date);
		$umb_karyawans = $this->Timesheet_model->get_umb_karyawans();
	} else {
		$imonth_year = explode('-',$month_year);
		$day = date('d', $date);
		$month = date($imonth_year[1], $date);
		$year = date($imonth_year[0], $date);
		if($this->input->post('karyawan_id')==0){
			$umb_karyawans = $this->Timesheet_model->get_umb_karyawans();
		} else {
			$umb_karyawans = $this->Umb_model->read_user_info($this->input->post('karyawan_id'));
		}
	}
} else if(in_array('10',$role_resources_ids)) {
	$karyawan_id = $this->input->post('karyawan_id');
	$perusahaan_id = $this->input->post('perusahaan_id');
	/* Set the date */
	$date = strtotime(date("Y-m-d"));
	// get month and year
	if(!isset($month_year)){
		$day = date('d', $date);
		$month = date('m', $date);
		$year = date('Y', $date);
		$umb_karyawans = $this->Timesheet_model->get_umb_karyawans();
	} else {
		$imonth_year = explode('-',$month_year);
		$day = date('d', $date);
		$month = date($imonth_year[1], $date);
		$year = date($imonth_year[0], $date);
		if($this->input->post('karyawan_id')==0){
			$umb_karyawans = $this->Timesheet_model->get_umb_karyawans();
		} else {
			$umb_karyawans = $this->Umb_model->read_user_info($this->input->post('karyawan_id'));
		}
	}
} else {
	$date = strtotime(date("Y-m-d"));
	/* Set the date */
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
	$umb_karyawans = $this->Umb_model->read_user_info($session['user_id']);
}
// total days in month
$daysInMonth =  date('t');
$imonth = date('F', $date);
?>
<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <li class="nav-item active">
      <a href="<?php echo site_url('admin/timesheet/');?>" data-link-data="<?php echo site_url('admin/timesheet/');?>" class="mb-3 nav-link hrastral-link">
        <span class="sw-icon ion ion-md-speedometer"></span>
        <?php echo $this->lang->line('dashboard_title');?>
        <div class="text-muted small">Set up shortcuts</div>
      </a>
    </li>
    <li class="nav-item clickable">
      <a href="<?php echo site_url('admin/timesheet/kehadiran/');?>" data-link-data="<?php echo site_url('admin/timesheet/kehadiran/');?>" class="mb-3 nav-link hrastral-link">
        <span class="sw-icon ion ion-md-clock"></span>
        <?php echo $this->lang->line('left_kehadiran');?>
        <div class="text-muted small">Add effects</div>
      </a>
    </li>
    <li class="nav-item clickable">
      <a href="<?php echo site_url('admin/timesheet/update_kehadiran');?>" data-link-data="<?php echo site_url('admin/timesheet/update_kehadiran');?>" class="mb-3 nav-link hrastral-link">
        <span class="sw-icon fas fa-pencil-alt"></span>
        <?php echo $this->lang->line('left_update_kehadiran');?>
        <div class="text-muted small">Set up notifications</div>
      </a>
    </li>
    <li class="nav-item clickable">
      <a href="<?php echo site_url('admin/timesheet/');?>" data-link-data="<?php echo site_url('admin/timesheet/');?>" class="mb-3 nav-link hrastral-link">
        <span class="sw-icon fas fa-calendar-alt"></span>
        <?php echo $this->lang->line('umb_month_timesheet_title');?>
        <div class="text-muted small">Set up notifications</div>
      </a>
    </li>
    <li class="nav-item clickable">
      <a href="<?php echo site_url('admin/timesheet/timecalendar/');?>" data-link-data="<?php echo site_url('admin/timesheet/timecalendar/');?>" class="mb-3 nav-link hrastral-link">
        <span class="sw-icon ion ion-md-calendar"></span>
        <?php echo $this->lang->line('umb_acc_calendar');?>
        <div class="text-muted small">Set up notifications</div>
      </a>
    </li>
    <li class="nav-item clickable">
      <a href="<?php echo site_url('admin/permintaan_lembur/');?>" data-link-data="<?php echo site_url('admin/permintaan_lembur/');?>" class="mb-3 nav-link hrastral-link">
        <span class="sw-icon ion ion-md-timer"></span>
        <?php echo $this->lang->line('umb_permintaan_lembur');?>
        <div class="text-muted small">Set up notifications</div>
      </a>
    </li>
  </ul>
</div>  
<hr class="border-light m-0">
<div class="row mt-3">
  <div class="col-md-6">
    <div class="card mb-4">
      <h6 class="card-header with-elements border-0 pr-0 pb-0">
        <div class="card-header-title">kehadiran Status</div>
      </h6>
      <div class="row">
        <div class="col-md-6">
          <div class="overflow-scrolls py-4 px-3" style="overflow:auto; height:200px;">
            <div class="table-responsive">
              <table class="table mb-0 table-dashboard">
                <tbody>
                  
                  <tr>
                    <td style="vertical-align: inherit;"><div style="width:4px;border:5px solid #d9534f;"></div></td>
                    <td><?php echo $this->lang->line('umb_absent');?></td>
                  </tr>
                  <tr>
                    <td style="vertical-align: inherit;"><div style="width:4px;border:5px solid #009688;"></div></td>
                    <td><?php echo $this->lang->line('umb_krywn_bekerja');?></td>
                  </tr>
                  
                </tbody>
              </table>
            </div>
          </div>
        </div>    
        <div class="col-md-5">
          <div style="height:120px;">
            <canvas id="status_kehadiran"  style="display: block; height: 150px; width:300px;"></canvas>
          </div>
        </div>
      </div>
    </div>
    
  </div>
  
  <div class="col-md-6">
    
    <div class="card mb-4">
      <h6 class="card-header with-elements border-0 pr-0 pb-0">
        <div class="card-header-title">lembur Request Status</div>
      </h6>
      <div class="row">
        <div class="col-md-6">
          <div class="overflow-scrolls py-4 px-3" style="overflow:auto; height:200px;">
            <div class="table-responsive">
              <table class="table mb-0 table-dashboard">
                <tbody>
                  <tr>
                    <td style="vertical-align: inherit;"><div style="width:4px;border:5px solid #009688;"></div></td>
                    <td><?php echo $this->lang->line('umb_approved');?></td>
                  </tr>
                  <tr>
                    <td style="vertical-align: inherit;"><div style="width:4px;border:5px solid #FFD950;"></div></td>
                    <td><?php echo $this->lang->line('umb_pending');?></td>
                  </tr>
                  <tr>
                    <td style="vertical-align: inherit;"><div style="width:4px;border:5px solid #d9534f;"></div></td>
                    <td><?php echo $this->lang->line('umb_rejected');?></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-md-5">
          <div style="height:120px;">
            <canvas id="hrastral_permintaan_lembur" style="display: block; height: 150px; width:300px;"></canvas>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
<div class="mb-3 sw-container tab-content">
  
  <div id="smartwizard-2-step-3" class="animated fadeIn tab-pane step-content mt-3">
   <div class="ui-bordered px-4 pt-4 mb-4">
    <?php $attributes = array('name' => 'update_kehadiran_report', 'id' => 'update_kehadiran_report', 'autocomplete' => 'off');?>
    <?php $hidden = array('user_id' => $session['user_id']);?>
    <?php echo form_open('admin/timesheet/update_kehadiran', $attributes, $hidden);?>
    <?php
    $data = array(
      'name'        => 'krywn_id',
      'id'          => 'krywn_id',
      'value'       => $session['user_id'],
      'type'   		=> 'hidden',
      'class'       => 'form-control',
    );
    
    echo form_input($data);
    ?>
    <div class="form-row">
      <div class="col-md mb-4">
        <label class="form-label"><?php echo $this->lang->line('umb_e_details_tanggal');?></label>
        <input class="form-control date" placeholder="<?php echo $this->lang->line('umb_e_details_tanggal');?>" readonly id="mn_tanggal_kehadiran" name="mn_tanggal_kehadiran" type="text" value="<?php echo date('Y-m-d');?>">
      </div>
      <div class="col-md mb-4">
        <?php if($user_info[0]->user_role_id==1){ ?>
          <label class="form-label"><?php echo $this->lang->line('left_perusahaan');?></label>
          <select class="form-control custom-select" name="perusahaan_id" id="up_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_perusahaan');?>" required>
            <option value=""></option>
            <?php foreach($get_all_perusahaans as $perusahaan) {?>
              <option value="<?php echo $perusahaan->perusahaan_id?>"><?php echo $perusahaan->name?></option>
            <?php } ?>
          </select>
        <?php } else if(in_array('310',$role_resources_ids)) {?>
          <?php $eperusahaan_id = $user_info[0]->perusahaan_id;?>
          <select class="form-control custom-select" name="perusahaan_id" id="up_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_perusahaan');?>" required>
            <option value=""></option>
            <?php foreach($get_all_perusahaans as $perusahaan) {?>
              <?php if($eperusahaan_id == $perusahaan->perusahaan_id):?>
                <option value="<?php echo $perusahaan->perusahaan_id?>"><?php echo $perusahaan->name?></option>
              <?php endif;?>
            <?php } ?>
          </select>
        <?php } ?>
      </div>
      <?php if($user_info[0]->user_role_id==1 || in_array('310',$role_resources_ids)){ ?>
        <div class="col-md mb-4" id="ajax_up_karyawan">
          <label class="form-label"><?php echo $this->lang->line('umb_karyawan');?></label>
          <select disabled="disabled" name="karyawan_id" id="up_karyawan_id" class="form-control karyawan-data" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_choose_an_karyawan');?>" required>
          </select>
        </div>
      <?php } else {?>
        <input type="hidden" name="karyawan_id" id="up_karyawan_id" value="<?php echo $session['user_id'];?>" />
      <?php }?>
      <div class="col-md col-xl-2 mb-4">
        <label class="form-label d-none d-md-block">&nbsp;</label>
        <button type="submit" class="btn btn-secondary btn-block"><?php echo $this->lang->line('umb_get');?></button>
      </div>
    </div>
    <?php echo form_close(); ?>
  </div>
  <div class="card mb-4">
    <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('left_update_kehadiran');?></strong></span>
      <?php if(in_array('277',$role_resources_ids)) {?>
        <div class="card-header-elements ml-md-auto" id="add_kehadiran_btn" style="display:none;">
          <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target=".add-modal-data"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('umb_add_new');?></button>
        </div>
      <?php } ?>  
    </div>
    <div class="card-body">
      <div class="box-datatable table-responsive">
        <table class="datatables-demo table table-striped table-bordered" id="umb_update_kehadiran_table">
          <thead>
            <tr>
              <th><?php echo $this->lang->line('umb_action');?></th>
              <th><?php echo $this->lang->line('umb_in_time');?></th>
              <th><?php echo $this->lang->line('umb_out_time');?></th>
              <th><?php echo $this->lang->line('dashboard_total_kerja');?></th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>
<div id="smartwizard-2-step-4" class="animated fadeIn tab-pane step-content mt-3" <?php echo $mnfact;?>>
  <div class="ui-bordered px-4 pt-4 mb-4">
   <?php $attributes = array('name' => 'umb-form', 'id' => 'umb-form', 'autocomplete' => 'off');?>
   <?php $hidden = array('_user' => $session['user_id']);?>
   <?php echo form_open('admin/timesheet/', $attributes, $hidden);?>
   <div class="form-row">
    <div class="col-md mb-4">
      <label class="form-label"><?php echo $this->lang->line('umb_e_details_tanggal');?></label>
      <input class="form-control d_month_year" value="<?php if(!isset($month_year)): echo date('Y-m'); else: echo $month_year; endif;?>" name="month_year" type="text">
    </div>
    <?php if($user_info[0]->user_role_id==1){?>
      <div class="col-md mb-4">
        <label class="form-label"><?php echo $this->lang->line('left_perusahaan');?></label>
        <select class="form-control" name="perusahaan_id" id="aj_perusahaan_mn" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_perusahaan');?>" required>
          <option value=""></option>
          <?php foreach($get_all_perusahaans as $perusahaan) {?>
            <option value="<?php echo $perusahaan->perusahaan_id?>" 
             <?php if(isset($karyawan_id)): if($perusahaan->perusahaan_id==$perusahaan_id): ?> selected="selected" <?php endif; endif;?>><?php echo $perusahaan->name?></option>
           <?php } ?>
         </select>
       </div>
       <div class="col-md mb-3" id="ajax_mn_karyawan">
        <label class="form-label"><?php echo $this->lang->line('umb_karyawan');?></label>
        <select name="karyawan_id" id="m_karyawan_id" class="form-control karyawan-data" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_choose_an_karyawan');?>" required>
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
<div class="card <?php echo $get_animate;?>">
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_karyawans_monthly_timesheet');?></strong> <?php echo $this->lang->line('umb_for_the_month_of');?> <?php if(isset($month_year)): echo date('F Y', strtotime($month_year)); else: echo date('F Y'); endif;?></span>
    <div class="card-header-elements ml-md-auto">
    A: Absent, P: Present, H: libur, L: Leave </div>
  </div>
  <div class="card-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="umb_monthly_timsheet_table">
        <thead>
          <tr>
            <th><?php echo $this->lang->line('umb_karyawan');?></th>
            <?php for($i = 1; $i <= $daysInMonth; $i++): ?>
              <?php $i = str_pad($i, 2, 0, STR_PAD_LEFT); ?>
              <?php
              $tdate = $year.'-'.$month.'-'.$i;
                    //Convert the date string into a unix timestamp.
              $unixTimestamp = strtotime($tdate);
                    //Get the day of the week
              $dayOfWeek = date("D", $unixTimestamp);
              ?>
              <th><strong><?php echo '<div>'.$i.' </div><span style="text-decoration:underline;">'.$dayOfWeek.'</span>';?></strong></th>
            <?php endfor; ?>
            <th width="100px"><?php echo $this->lang->line('umb_timesheet_workdays');?></th>
          </tr>
        </thead>
        <tbody>
          <?php $j=0;foreach($umb_karyawans as $r):?>
          <?php
          
          $full_name = $r->first_name.' '.$r->last_name;
                    // get designation
          $penunjukan = $this->Penunjukan_model->read_informasi_penunjukan($r->penunjukan_id);
          if(!is_null($penunjukan)){
            $nama_penunjukan = $penunjukan[0]->nama_penunjukan;
          } else {
            $nama_penunjukan = '--';	
          }
                    // department
          $department = $this->Department_model->read_informasi_department($r->department_id);
          if(!is_null($department)){
            $nama_department = $department[0]->nama_department;
          } else {
            $nama_department = '--';	
          }
          $department_penunjukan = $nama_penunjukan.' ('.$nama_department.')';$pcount=0;
          ?>
          <?php $nama_karyawan = $full_name.'<br><small class="text-muted"><i>'.$department_penunjukan.'<i></i></i></small><br><small class="text-muted"><i>'.$this->lang->line('umb_karyawans_id').': '.$r->karyawan_id.'<i></i></i></small>';?>
          <tr>
            <td style="width:200px;"><?php echo $nama_karyawan;?></td>
            <?php
            for($i = 1; $i <= $daysInMonth; $i++):
              $i = str_pad($i, 2, 0, STR_PAD_LEFT);
                    // get date <
              $tanggal_kehadiran = $year.'-'.$month.'-'.$i;
              $get_day = strtotime($tanggal_kehadiran);
              $day = date('l', $get_day);
              $user_id = $r->user_id;
                    // office shift
              $shift_kantor = $this->Timesheet_model->read_informasi_shift_kantor($r->shift_kantor_id);
                    // get libur
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
                    //echo '<pre>'; print_r($libur_arr);
                    // get cuti/karyawan
              $chck_tanggal_cuti = $this->Timesheet_model->chcek_tanggal_cuti($r->user_id,$tanggal_kehadiran);
              $cuti_arr = array();
              if($chck_tanggal_cuti->num_rows() == 1){
                $tanggal_cuti = $this->Timesheet_model->tanggal_cuti($r->user_id,$tanggal_kehadiran);
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
              $status_kehadiran = '';
              $check = $this->Timesheet_model->check_kehadiran_pertama_masuk($r->user_id,$tanggal_kehadiran);
              if($shift_kantor[0]->senen_waktu_masuk == '' && $day == 'Monday') {
                $status = 'H';	
              } else if($shift_kantor[0]->selasa_waktu_masuk == '' && $day == 'Tuesday') {
                $status = 'H';
              } else if($shift_kantor[0]->rabu_waktu_masuk == '' && $day == 'Wednesday') {
                $status = 'H';
              } else if($shift_kantor[0]->kamis_waktu_masuk == '' && $day == 'Thursday') {
                $status = 'H';
              } else if($shift_kantor[0]->jumat_waktu_masuk == '' && $day == 'Friday') {
                $status = 'H';
              } else if($shift_kantor[0]->sabtu_waktu_masuk == '' && $day == 'Saturday') {
                $status = 'H';
              } else if($shift_kantor[0]->minggu_waktu_masuk == '' && $day == 'Sunday') {
                $status = 'H';
                    } else if(in_array($tanggal_kehadiran,$libur_arr)) { // libur
                      $status = 'H';
                    } else if(in_array($tanggal_kehadiran,$cuti_arr)) { // on leave
                      $status = 'L';
                    } else if($check->num_rows() > 0){
                      $kehadiran = $this->Timesheet_model->kehadiran_pertama_masuk($r->user_id,$tanggal_kehadiran);
                    $status = 'P';//$kehadiran[0]->status_kehadiran;
                    
                  } else {
                    
                   
                    $status = 'A';
                        //$pcount += 0;
                  }
                  $pcount += $check->num_rows();
                    // set to present date
                  $itanggal_kehadiran = strtotime($tanggal_kehadiran);
                  $icurrent_date = strtotime(date('Y-m-d'));
                  if($itanggal_kehadiran <= $icurrent_date){
                    $status = $status;
                  } else {
                    $status = '';
                  }
                  $itanggal_bergabung = strtotime($r->tanggal_bergabung);
                  if($itanggal_bergabung < $itanggal_kehadiran){
                    $status = $status;
                  } else {
                    $status = '';
                  }
                  
                  ?>
                  <td><?php echo $status; ?></td>
                <?php endfor; ?>
                <td><?php echo $pcount;?></td>
              </tr>
            <?php endforeach;?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<div id="smartwizard-2-step-5" class="animated fadeIn tab-pane step-content mt-3">
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
   /* Set the date */
			//if(isset($perusahaan_id)){
   $date = strtotime(date("Y-m-d"));
   /* Set the date */
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
 /* Set the date */
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
		// get designation
$penunjukan = $this->Penunjukan_model->read_informasi_penunjukan($r[0]->penunjukan_id);
if(!is_null($penunjukan)){
 $nama_penunjukan = $penunjukan[0]->nama_penunjukan;
} else {
 $nama_penunjukan = '--';	
}
		// department
$department = $this->Department_model->read_informasi_department($r[0]->department_id);
if(!is_null($department)){
  $nama_department = $department[0]->nama_department;
} else {
  $nama_department = '--';	
}
		// get perusahaan
$perusahaan = $this->Umb_model->read_info_perusahaan($r[0]->perusahaan_id);
if(!is_null($perusahaan)){
 $prshn_nama = $perusahaan[0]->name;
} else {
 $prshn_nama = '--';	
}
		// total days in month
$daysInMonth =  date('t');
$imonth = date('F', $date);
$pcount = 0;
$acount = 0;
$lcount = 0;
for($i = 1; $i <= $daysInMonth; $i++):
 $i = str_pad($i, 2, 0, STR_PAD_LEFT);
			// get date <
 $tanggal_kehadiran = $year.'-'.$month.'-'.$i;
 $get_day = strtotime($tanggal_kehadiran);
 $day = date('l', $get_day);
 $user_id = $r[0]->user_id;
 $shift_kantor_id = $r[0]->shift_kantor_id;
 $status_kehadiran = '';
			// get libur
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
			// get cuti/karyawan
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
			// get libur>events
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
			} else if(in_array($tanggal_kehadiran,$libur_arr)) { // libur
				$status = 'H';
				$pcount += 0;
				//$acount += 0;
			} else if(in_array($tanggal_kehadiran,$cuti_arr)) { // on leave
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
				// set to present date
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
    <div class="ui-bordered px-4 pt-4 mb-4">
      <?php $attributes = array('name' => 'umb-form', 'id' => 'umb-form', 'autocomplete' => 'off');?>
      <?php $hidden = array('_user' => $session['user_id']);?>
      <?php echo form_open('admin/timesheet/timecalendar/', $attributes, $hidden);?>
      <div class="form-row">
        <div class="col-md mb-4">
          <label class="form-label"><?php echo $this->lang->line('umb_e_details_tanggal');?></label>
          <input class="form-control d_month_year" value="<?php if(!isset($month_year)): echo date('Y-m'); else: echo $month_year; endif;?>" name="month_year" type="text">
        </div>
        <?php if($user_info[0]->user_role_id==1){?>
          
          <div class="col-md mb-4">
            <label class="form-label"><?php echo $this->lang->line('left_perusahaan');?></label>
            <select class="form-control custom-select" name="perusahaan_id" id="cal_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_perusahaan');?>" required>
              <option value=""></option>
              <?php foreach($get_all_perusahaans as $perusahaan) {?>
                <option value="<?php echo $perusahaan->perusahaan_id?>" 
                 <?php if(isset($karyawan_id)): if($perusahaan->perusahaan_id==$r[0]->perusahaan_id): ?> selected="selected" <?php endif; endif;?>><?php echo $perusahaan->name?></option>
               <?php } ?>
             </select>
           </div>
           <div class="col-md mb-4" id="karyawan_cal_ajx">
            <label class="form-label"><?php echo $this->lang->line('umb_karyawan');?></label>
            <select name="karyawan_id" id="cal_karyawan_id" class="form-control karyawan-data  custom-select" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_choose_an_karyawan');?>" required>
              <?php if(isset($karyawan_id)): ?>
                <?php $result = $this->Department_model->ajax_info_perusahaan_karyawan($perusahaan_id); ?>
                <option value=""></option>
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
           <div class="box-header with-border">
            <h3 class="box-title"> <?php echo $r[0]->first_name.' '.$r[0]->last_name;?> - <?php echo date('F Y',strtotime($month_year));?></h3>
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
                <tr>
                  <th scope="row"><?php echo $this->lang->line('umb_kehadiran_total_cuti');?></th>
                  <td class="text-right"><?php echo $lcount;?></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-8">
     <div class="box">
       <div class="box-body">
        <div id='calendar_hr'></div>
      </div>
    </div>
  </div>
</div>
<?php } ?>
</div>
<div id="smartwizard-2-step-6" class="animated fadeIn tab-pane step-content mt-3">
  <div class="card m-b-1 <?php echo $get_animate;?>">
    <div class="col-md-12">
      <div class="box mb-4">
        
        <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_permintaan_lembur');?></strong></span>
          <div class="card-header-elements ml-md-auto">
            <button type="button" class="btn btn-xs btn-primary" id="add_kehadiran_btn" data-toggle="modal" data-target=".add-modal-data"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('umb_add_new');?></button>
          </div>
        </div>
        <div class="card-body">
          <div class="box-datatable table-responsive">
            <table class="datatables-demo table table-striped table-bordered" id="umb_table">
              <thead>
                <tr>
                  <th><?php echo $this->lang->line('umb_action');?></th>
                  <th><?php echo $this->lang->line('umb_karyawan');?></th>
                  <th><?php echo $this->lang->line('umb_no_project');?></th>
                  <th><?php echo $this->lang->line('umb_phase_no');?></th>
                  <th><?php echo $this->lang->line('umb_e_details_tanggal');?></th>
                  <th><?php echo $this->lang->line('umb_in_time');?></th>
                  <th><?php echo $this->lang->line('umb_out_time');?></th>
                  <th><?php echo $this->lang->line('umb_lembur_thours');?></th>
                  <th><?php echo $this->lang->line('dashboard_umb_status');?></th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
</div>
</div>

