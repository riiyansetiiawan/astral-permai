<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>
<?php
$user_info = $this->Umb_model->read_user_info($session['user_id']);
$role_resources_ids = $this->Umb_model->user_role_resource();
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
$daysInMonth = date('t');
$imonth = date('F', $date);
?>

<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
	<ul class="nav nav-tabs step-anchor">
		<?php if(in_array('423',$role_resources_ids)) { ?>
			<li class="nav-item clickable"> <a href="<?php echo site_url('admin/timesheet/dashboard_kehadiran/');?>" data-link-data="<?php echo site_url('admin/timesheet/dashboard_kehadiran/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon ion ion-md-speedometer"></span> <?php echo $this->lang->line('dashboard_title');?>
			<div class="text-muted small"><?php echo $this->lang->line('hr_title_dashboard_timesheet');?></div>
		</a> </li>
	<?php } ?>
	<?php if(in_array('28',$role_resources_ids)) { ?>
		<li class="nav-item clickable"> <a href="<?php echo site_url('admin/timesheet/kehadiran/');?>" data-link-data="<?php echo site_url('admin/timesheet/kehadiran/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon ion ion-md-clock"></span> <?php echo $this->lang->line('left_kehadiran');?>
		<div class="text-muted small"><?php echo $this->lang->line('left_kehadiran');?> <?php echo $this->lang->line('umb_list_role');?></div>
	</a> </li>
<?php } ?>
<?php if(in_array('30',$role_resources_ids)) { ?>
	<li class="nav-item clickable"> <a href="<?php echo site_url('admin/timesheet/update_kehadiran');?>" data-link-data="<?php echo site_url('admin/timesheet/update_kehadiran');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon fas fa-pencil-alt"></span> <?php echo $this->lang->line('left_update_kehadiran');?>
	<div class="text-muted small"><?php echo $this->lang->line('umb_add_edit_info');?> <?php echo $this->lang->line('left_kehadiran');?></div>
</a> </li>
<?php } ?>
<?php if(in_array('10',$role_resources_ids)) { ?>
	<li class="nav-item active"> <a href="<?php echo site_url('admin/timesheet/');?>" data-link-data="<?php echo site_url('admin/timesheet/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon fas fa-calendar-alt"></span> <?php echo $this->lang->line('umb_month_timesheet_title');?>
	<div class="text-muted small"><?php echo $this->lang->line('umb_view_all');?></div>
</a> </li>
<?php } ?>
<?php if(in_array('261',$role_resources_ids)) { ?>
	<li class="nav-item clickable"> <a href="<?php echo site_url('admin/timesheet/timecalendar/');?>" data-link-data="<?php echo site_url('admin/timesheet/timecalendar/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon ion ion-md-calendar"></span> <?php echo $this->lang->line('umb_acc_calendar');?>
	<div class="text-muted small"><?php echo $this->lang->line('umb_view');?> <?php echo $this->lang->line('umb_acc_calendar');?></div>
</a> </li>
<?php } ?>
<?php if(in_array('401',$role_resources_ids)) { ?>
	<li class="nav-item clickable"> <a href="<?php echo site_url('admin/permintaan_lembur/');?>" data-link-data="<?php echo site_url('admin/permintaan_lembur/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon ion ion-md-timer"></span> <?php echo $this->lang->line('umb_permintaan_lembur');?>
	<div class="text-muted small"><?php echo $this->lang->line('umb_role_add');?> <?php echo $this->lang->line('umb_permintaan_lembur');?></div>
</a> </li>
<?php } ?>
</ul>
</div>
<hr class="border-light m-0 mb-3">
<div class="ui-bordered px-4 pt-4 mb-4">
	<?php $attributes = array('name' => 'umb-form', 'id' => 'umb-form', 'autocomplete' => 'off');?>
	<?php $hidden = array('_user' => $session['user_id']);?>
	<?php echo form_open('admin/timesheet/', $attributes, $hidden);?>
	<div class="form-row">
		<div class="col-md mb-4">
			<label class="form-label"><?php echo $this->lang->line('umb_e_details_tanggal');?></label>
			<input class="form-control hr_month_year" value="<?php if(!isset($month_year)): echo date('Y-m'); else: echo $month_year; endif;?>" name="month_year" type="text">
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
		<?php echo form_close(); ?> </div>
		<div class="card <?php echo $get_animate;?>"> </div>
		<div class="card">
			<div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_karyawans_monthly_timesheet');?></strong> A: Absent, P: Present, H: libur, L: Leave </span> </div>
			<div class="card-body">
				<div id="calendar"></div>
			</div>
		</div>
