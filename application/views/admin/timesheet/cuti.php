<?php $session = $this->session->userdata('username');?>
<?php $user = $this->Umb_model->read_info_karyawan($session['user_id']);?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>
<?php $xuser_info = $this->Umb_model->read_user_info($session['user_id']);?>
<?php $role_resources_ids = $this->Umb_model->user_role_resource();?>
<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
	<ul class="nav nav-tabs step-anchor">
		<?php if(in_array('46',$role_resources_ids)) { ?>
			<li class="nav-item active">
				<a  href="<?php echo site_url('admin/timesheet/cuti/');?>" data-link-data="<?php echo site_url('admin/timesheet/cuti/');?>" class="mb-3 nav-link hrastral-link">
					<span class="sw-icon oi oi-calculator"></span>
					<?php echo $this->lang->line('umb_manage_cutii');?>
					<div class="text-muted small"><?php echo $this->lang->line('umb_hr_calendar_permintaan_cti');?></div>
				</a>
			</li>
		<?php } ?>
		<?php if(in_array('409',$role_resources_ids)) { ?>
			<li class="nav-item clickable">
				<a  href="<?php echo site_url('admin/laporans/karyawan_cuti/');?>" data-link-data="<?php echo site_url('admin/laporans/karyawan_cuti/');?>" class="mb-3 nav-link hrastral-link">
					<span class="sw-icon fas fa-chalkboard-teacher"></span>
					<?php echo $this->lang->line('umb_status_cuti');?>
					<div class="text-muted small"><?php echo $this->lang->line('umb_view');?> <?php echo $this->lang->line('umb_status_cuti');?></div>
				</a>
			</li>
		<?php } ?>
	</ul>
</div>  
<hr class="border-light m-0 mb-3">
<?php
	// reports to 
$laporans_to = get_data_laporans_team($session['user_id']); ?>
<?php if($xuser_info[0]->user_role_id==1){ ?>
	<div id="filter_hrastral" class="collapse add-formd <?php echo $get_animate;?>" data-parent="#accordion" style="">
		<div class="row">
			<div class="col-md-12">
				<div class="box mb-4">
					<div class="box-header  with-border">
						<h3 class="box-title"><?php echo $this->lang->line('umb_filter');?></h3>
						<div class="box-tools pull-right"> <a class="text-dark collapsed" data-toggle="collapse" href="#filter_hrastral" aria-expanded="false">
							<button type="button" class="btn btn-xs btn-primary"> <span class="fa fa-minus"></span> <?php echo $this->lang->line('umb_hide');?></button>
						</a> </div>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-12">
								<?php $attributes = array('name' => 'ihr_report', 'id' => 'ihr_report', 'class' => 'm-b-1 add form-hrm');?>
								<?php $hidden = array('user_id' => $session['user_id']);?>
								<?php echo form_open('admin/timesheet/list_cuti', $attributes, $hidden);?>
								<div class="row">
									<div class="col-md-3">
										<div class="form-group">
											<label for="department"><?php echo $this->lang->line('module_title_perusahaan');?></label>
											<select class="form-control" name="perusahaan" id="aj_perusahaanf" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_title_perusahaan');?>" required>
												<option value="0"><?php echo $this->lang->line('umb_all_perusahaans');?></option>
												<?php foreach($get_all_perusahaans as $perusahaan) {?>
													<option value="<?php echo $perusahaan->perusahaan_id;?>"> <?php echo $perusahaan->name;?></option>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group" id="ajax_f_karyawan">
											<label for="department"><?php echo $this->lang->line('dashboard_single_karyawan');?></label>
											<select id="karyawan_id" name="karyawan_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_choose_an_karyawan');?>">
												<option value="0"><?php echo $this->lang->line('umb_all_karyawans');?></option>
											</select>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label for="status"><?php echo $this->lang->line('dashboard_umb_status');?></label>
											<select class="form-control" name="status" id="status" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('dashboard_umb_status');?>">
												<option value="0" ><?php echo $this->lang->line('umb_acc_all');?></option>
												<option value="1" ><?php echo $this->lang->line('umb_pending');?></option>
												<option value="2" ><?php echo $this->lang->line('umb_approved');?></option>
												<option value="3" ><?php echo $this->lang->line('umb_rejected');?></option>
											</select>
										</div>
									</div>
									<div class="col-md-1"><label for="umb_get">&nbsp;</label><button name="hrastral_form" type="submit" class="btn btn-primary"><i class="fas fa-check-square"></i> <?php echo $this->lang->line('umb_get');?></button>
									</div>
								</div>
								
								<?php echo form_close(); ?> </div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>
	<?php if(in_array('287',$role_resources_ids)) {?>
		<?php $kategoris_cuti = $user[0]->kategoris_cuti;?>
		<?php $user_info = $this->Umb_model->read_user_info($session['user_id']);?>
		<?php $leaave_cat = get_kategori_karyawan_cuti($kategoris_cuti,$session['user_id']);?>
		<div class="card mb-4 <?php echo $get_animate;?> mt-3">
			<div id="accordion">
				<div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_add_new');?></strong> <?php echo $this->lang->line('left_cuti');?></span>
					<div class="card-header-elements ml-md-auto">
						<a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
							<button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('umb_add_new');?></button>
						</a> </div>
					</div>
					<div id="add_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
						<div class="card-body">
							<?php $attributes = array('name' => 'add_cuti', 'id' => 'umb-form', 'autocomplete' => 'off');?>
							<?php $hidden = array('_user' => $session['user_id']);?>
							<?php echo form_open('admin/timesheet/add_cuti', $attributes, $hidden);?>
							<?php $leaave_cat = get_kategori_karyawan_cuti($kategoris_cuti,$session['user_id']);?>
							<div class="bg-white">
								<div class="box-block">
									<div class="row">
										<div class="col-md-6">
											<?php $role_resources_ids = $this->Umb_model->user_role_resource();
											if($user_info[0]->user_role_id==1){ ?>
												<div class="row">
													<div class="col-md-6">
														
														<div class="form-group">
															<label for="first_name"><?php echo $this->lang->line('left_perusahaan');?></label>
															<select class="form-control" name="perusahaan_id" id="aj_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_perusahaan');?>">
																<option value=""></option>
																<?php foreach($get_all_perusahaans as $perusahaan) {?>
																	<option value="<?php echo $perusahaan->perusahaan_id?>"><?php echo $perusahaan->name?></option>
																<?php } ?>
															</select>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group" id="ajax_karyawan">
															<label for="karyawans" class="control-label"><?php echo $this->lang->line('umb_karyawan');?></label>
															<select disabled="disabled" class="form-control" name="karyawan_id" id="karyawan_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_choose_an_karyawan');?>">
																<option value=""></option>
															</select>
														</div>
													</div>
												</div>
											<?php } else {?>
												<input type="hidden" name="karyawan_id" id="karyawan_id" value="<?php echo $session['user_id'];?>" />
												<input type="hidden" name="perusahaan_id" id="perusahaan_id" value="<?php echo $user[0]->perusahaan_id;?>" />
											<?php } ?>
											<div class="form-group" id="get_types_cuti">
												<label for="type_cuti" class="control-label"><?php echo $this->lang->line('umb_type_cuti');?></label>
												<select class="form-control" id="type_cuti" name="type_cuti" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_type_cuti');?>">
													<option value=""></option>
													<?php if($user_info[0]->user_role_id!=1){?>
														<?php foreach($leaave_cat as $type) {?>
															<?php $sisa_cuti = $this->Timesheet_model->count_total_karyawan_cutii($type->type_cuti_id,$session['user_id']);?>
															<?php $total = $type->days_per_year;?>
															<?php $total_sisa_cuti = $total - $sisa_cuti;?>
															<option value="<?php echo $type->type_cuti_id;?>"><?php echo $type->type_name.' ('.$total_sisa_cuti.' '.$this->lang->line('umb_remaining').')';?></option>
														<?php } ?>
													<?php } ?>
												</select>
											</div>
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
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="description"><?php echo $this->lang->line('umb_keterangan');?></label>
												<textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('umb_keterangan');?>" name="remarks" rows="5"></textarea>
											</div>
											<div class="form-group">
												<label>
													<input type="checkbox" class="minimal" value="1" id="cuti_setengah_hari" name="cuti_setengah_hari">
													<?php echo $this->lang->line('umb_hr_cuti_setenga_hari');?></span> </label>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<fieldset class="form-group">
														<label for="attachment"><?php echo $this->lang->line('umb_attachment');?></label>
														<input type="file" class="form-control-file" id="attachment" name="attachment">
														<small><?php echo $this->lang->line('umb_type_file_cuti');?></small>
													</fieldset>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label for="summary"><?php echo $this->lang->line('umb_alasan_cuti');?></label>
											<textarea class="form-control" placeholder="<?php echo $this->lang->line('umb_alasan_cuti');?>" name="reason" cols="30" rows="3" id="reason"></textarea>
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
				<?php if($xuser_info[0]->user_role_id==1){ ?>
					<div class="card <?php echo $get_animate;?>">
						<div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_list_all');?></strong> <?php echo $this->lang->line('left_cuti');?></span>
							<?php if($xuser_info[0]->user_role_id==1){ ?>
								<div class="card-header-elements ml-md-auto">
									<a class="text-dark collapsed" data-toggle="collapse" href="#filter_hrastral" aria-expanded="false">
										<button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('umb_filter');?></button>
									</a> </div>
								</div>
							<?php } ?>
							
							<div class="card-body">
								<div class="box-datatable table-responsive">
									<table class="datatables-demo table table-striped table-bordered" id="umb_table">
										<thead>
											<tr>
												<th><?php echo $this->lang->line('umb_action');?></th>
												<th width="300"><?php echo $this->lang->line('umb_type_cuti');?></th>
												<th><?php echo $this->lang->line('left_department');?></th>
												<th><?php echo $this->lang->line('umb_karyawan');?></th>
												<th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('umb_cuti_duration');?></th>
												<th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('umb_applied_on');?></th>
											</tr>
										</thead>
									</table>
								</div>
							</div>
						</div>
					<?php } else {?>
						<div class="row">
							<div class="col-md-12"> 
								<!-- Custom Tabs (Pulled to the right) -->
								<div class="nav-tabs-custom">
									<ul class="nav nav-tabs">
										<li class="nav-item active"><a class="nav-link active" href="#tab_1-1" data-toggle="tab"><?php echo $this->lang->line('umb_list_all');?> <?php echo $this->lang->line('umb_my_cuti');?></a></li>
										<?php if($laporans_to > 0) { ?>
											<li class="nav-item"><a class="nav-link" href="#tab_2-2" data-toggle="tab"><?php echo $this->lang->line('umb_my_team');?> <?php echo $this->lang->line('left_cuti');?></a></li>
										<?php } ?>
									</ul>
									<div class="tab-content">
										<div class="tab-pane active" id="tab_1-1">
											<div class="card <?php echo $get_animate;?>">
												<div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_list_all');?></strong> <?php echo $this->lang->line('left_cuti');?></span>
												</div>
												<div class="card-body">
													<div class="box-datatable table-responsive">
														<table class="datatables-demo table table-striped table-bordered" id="umb_table">
															<thead>
																<tr>
																	<th><?php echo $this->lang->line('umb_action');?></th>
																	<th width="300"><?php echo $this->lang->line('umb_type_cuti');?></th>
																	<th><?php echo $this->lang->line('left_department');?></th>
																	<th><?php echo $this->lang->line('umb_karyawan');?></th>
																	<th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('umb_cuti_duration');?></th>
																	<th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('umb_applied_on');?></th>
																</tr>
															</thead>
														</table>
													</div>
												</div>
											</div>
										</div>
										<!-- /.tab-pane -->
										<div class="tab-pane" id="tab_2-2">
											<div class="card <?php echo $get_animate;?>">
												<div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_my_team');?></strong> <?php echo $this->lang->line('left_cuti');?></span>
												</div>
												<div class="card-body">
													<div class="box-datatable table-responsive">
														<table class="datatables-demo table table-striped table-bordered" id="umb_my_team_table" style="width:100%;">
															<thead>
																<tr>
																	<th><?php echo $this->lang->line('umb_action');?></th>
																	<th width="300"><?php echo $this->lang->line('umb_type_cuti');?></th>
																	<th><?php echo $this->lang->line('left_department');?></th>
																	<th><?php echo $this->lang->line('umb_karyawan');?></th>
																	<th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('umb_cuti_duration');?></th>
																	<th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('umb_applied_on');?></th>
																</tr>
															</thead>
														</table>
													</div>
												</div>
											</div>
										</div>  
										<!-- /.tab-pane --> 
									</div>
									<!-- /.tab-content --> 
								</div>
								<!-- nav-tabs-custom --> 
							</div>
							<!-- /.col --> 
						</div>
					<?php } ?>
