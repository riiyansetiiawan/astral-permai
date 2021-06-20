<?php
$session = $this->session->userdata('username');
$system = $this->Umb_model->read_setting_info(1);
$info_perusahaan = $this->Umb_model->read_info_setting_perusahaan(1);
$user = $this->Umb_model->read_info_karyawan($session['user_id']);
$theme = $this->Umb_model->read_theme_info(1);
?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>

<div class="row">
	<div class="col-md-12">
		<div class="box <?php echo $get_animate;?>">
			<div class="box-header with-border">
				<h3 class="box-title"> <?php echo $this->lang->line('umb_last_5_project_data');?> </h3>
			</div>
			<!-- Custom Tabs -->
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#projects" data-toggle="tab">Projects</a></li>
					<li><a href="#tugass" data-toggle="tab">Tugas</a></li>
					<li><a href="#invoices" data-toggle="tab">Invoices</a></li>
					<li><a href="#estimates" data-toggle="tab">Estimates</a></li>
					<li><a href="#pembayarans_invoice" data-toggle="tab">Invoice Pembayaran</a></li>
					<li><a href="#clients" data-toggle="tab">Clients</a></li>
					<li><a href="#leads" data-toggle="tab">Leads</a></li>
					<li><a href="#quoted_projects" data-toggle="tab">Quoted Projects</a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="projects">
						<div class="box-body">
							<div class="box-datatable table-responsive">
								<table class="datatables-demo table table-striped table-bordered" id="umb_dashboard_projects_table">
									<thead>
										<tr>
											<th><?php echo $this->lang->line('umb_project');?>#</th>
											<th><?php echo $this->lang->line('umb_phase_no');?></th>
											<th width="180"><?php echo $this->lang->line('umb_ringkasan_project');?></th>
											<th><?php echo $this->lang->line('umb_p_priority');?></th>
											<th><i class="fa fa-user"></i> <?php echo $this->lang->line('umb_project_users');?></th>
											<th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('umb_e_details_tanggal');?></th>
											<th><?php echo $this->lang->line('dashboard_umb_progress');?></th>
										</tr>
										<?php foreach(total_projects_terakhir() as $ls_projects):?>
											<?php
											$aim = explode(',',$ls_projects->assigned_to);
											
											$user = $this->Umb_model->read_user_info($ls_projects->added_by);
											
											if(!is_null($user)){
												$full_name = $user[0]->first_name.' '.$user[0]->last_name;
											} else {
												$full_name = '--';	
											}
							// get date
											$psdate = $this->Umb_model->set_date_format($ls_projects->start_date);
											$pedate = $this->Umb_model->set_date_format($ls_projects->end_date);
											
							//progress_project
											if($ls_projects->progress_project <= 20) {
												$progress_class = 'progress-bar-danger';
											} else if($ls_projects->progress_project > 20 && $ls_projects->progress_project <= 50){
												$progress_class = 'progress-bar-warning';
											} else if($ls_projects->progress_project > 50 && $ls_projects->progress_project <= 75){
												$progress_class = 'progress-bar-info';
											} else {
												$progress_class = 'progress-bar-success';
											}
											
							// progress
											$pbar = '<p class="m-b-0-5">'.$this->lang->line('umb_completed').' <span class="pull-xs-right">'.$ls_projects->progress_project.'%</span>
											<div class="progress progress-xs"><div class="progress-bar '.$progress_class.' progress-bar-striped" role="progressbar" aria-valuenow="'.$ls_projects->progress_project.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$ls_projects->progress_project.'%"></div></div></p>';
											
											
							//status
											if($ls_projects->status == 0) {
												$status = '<span class="label label-warning">'.$this->lang->line('umb_not_started').'</span>';
											} else if($ls_projects->status ==1){
												$status = '<span class="label label-primary">'.$this->lang->line('umb_in_progress').'</span>';
											} else if($ls_projects->status ==2){
												$status = '<span class="label label-success">'.$this->lang->line('umb_completed').'</span>';
											} else if($ls_projects->status ==3){
												$status = '<span class="label label-danger">'.$this->lang->line('umb_project_cancelled').'</span>';
											} else {
												$status = '<span class="label label-danger">'.$this->lang->line('umb_project_hold').'</span>';
											}
											
							// priority
											if($ls_projects->priority == 1) {
												$priority = '<span class="label label-danger">'.$this->lang->line('umb_highest').'</span>';
											} else if($ls_projects->priority ==2){
												$priority = '<span class="label label-danger">'.$this->lang->line('umb_high').'</span>';
											} else if($ls_projects->priority ==3){
												$priority = '<span class="label label-primary">'.$this->lang->line('umb_normal').'</span>';
											} else {
												$priority = '<span class="label label-success">'.$this->lang->line('umb_low').'</span>';
											}
											
							//assigned user
											if($ls_projects->assigned_to == '') {
												$ol = $this->lang->line('umb_not_assigned');
											} else {
												$ol = '';
												foreach(explode(',',$ls_projects->assigned_to) as $tunjuk_id) {
													$assigned_to = $this->Umb_model->read_user_info($tunjuk_id);
													if(!is_null($assigned_to)){
														
														$assigned_name = $assigned_to[0]->first_name.' '.$assigned_to[0]->last_name;
														if($assigned_to[0]->profile_picture!='' && $assigned_to[0]->profile_picture!='no file') {
															$ol .= '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.base_url().'uploads/profile/'.$assigned_to[0]->profile_picture.'" class="user-image-hr" alt=""></span></a>';
														} else {
															if($assigned_to[0]->jenis_kelamin=='Pria') { 
																$de_file = base_url().'uploads/profile/default_male.jpg';
															} else {
																$de_file = base_url().'uploads/profile/default_female.jpg';
															}
															$ol .= '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.$de_file.'" class="user-image-hr" alt=""></span></a>';
														}
									} ////
									else {
										$ol .= '';
									}
								}
								$ol .= '';
							}
							$client = $this->Clients_model->read_info_client($ls_projects->client_id);
							if(!is_null($client)) {
								$name_client = $client[0]->name;
							} else {
								$name_client = '--';
							}
							
							$new_time = $this->Umb_model->actual_hours_timelog($ls_projects->project_id);
							$ringkasan_project = '<a href="'.site_url().'admin/project/detail/'.$ls_projects->project_id . '">'.$ls_projects->title.'</a><br><small>'.$this->lang->line('umb_project_client').': '.$name_client.'</small><br><small>'.$this->lang->line('umb_project_budget_hrs').': '.$ls_projects->jam_anggaran.'</small><br><small>'.$this->lang->line('umb_project_actual_hrs').': '.$new_time.'</small>';
							
							$tanggal_project = $this->lang->line('umb_start_date').': '.$psdate.'<br>'.$this->lang->line('umb_end_date').': '.$pedate;
							// progress
							$progress_project = $pbar.$status;
							$no_project = '<a href="'.site_url().'admin/project/detail/'.$ls_projects->project_id . '">'.$ls_projects->no_project.'</a>';
							?>
							<tr>
								<td><?php echo $no_project;?></td>
								<td><?php echo $ls_projects->phase_no;?></td>
								<th width="180"><?php echo $ringkasan_project;?></td>
									<td><?php echo $priority;?></td>
									<td><?php echo $ol;?></td>
									<td><?php echo $tanggal_project;?></td>
									<td><?php echo $progress_project;?></td>
								</tr>
							<?php endforeach;?>
						</thead>
					</table>
				</div>
			</div>
		</div>
		<div class="tab-pane" id="tugass">
			<div class="box-body">
				<div class="box-datatable table-responsive">
					<table class="datatables-demo table table-striped table-bordered" id="umb_dashboard_projects_table">
						<thead>
							<tr>
								<th><?php echo $this->lang->line('dashboard_umb_title');?></th>
								<th><?php echo $this->lang->line('umb_assigned_to');?></th>
								<th><?php echo $this->lang->line('umb_e_details_tanggal');?></th>
								<th><?php echo $this->lang->line('dashboard_umb_status');?></th>
								<th><?php echo $this->lang->line('umb_created_by');?></th>
								<th><?php echo $this->lang->line('dashboard_umb_progress');?></th>
							</tr>
							<?php foreach(total_tugass_terakhir() as $ls_tugass):?>
								<?php
								$aim = explode(',',$ls_tugass->assigned_to);
								
								if($ls_tugass->assigned_to == '' || $ls_tugass->assigned_to == 'None') {
									$ol = 'None';
								} else {
									$ol = '';
									foreach(explode(',',$ls_tugass->assigned_to) as $uid) {
										//$user = $this->Umb_model->read_user_info($uid);
										$assigned_to = $this->Umb_model->read_user_info($uid);
										if(!is_null($assigned_to)){
											
											$assigned_name = $assigned_to[0]->first_name.' '.$assigned_to[0]->last_name;
											if($assigned_to[0]->profile_picture!='' && $assigned_to[0]->profile_picture!='no file') {
												$ol .= '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.base_url().'uploads/profile/'.$assigned_to[0]->profile_picture.'" class="user-image-hr" alt=""></span></a>';
											} else {
												if($assigned_to[0]->jenis_kelamin=='Pria') { 
													$de_file = base_url().'uploads/profile/default_male.jpg';
												} else {
													$de_file = base_url().'uploads/profile/default_female.jpg';
												}
												$ol .= '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.$de_file.'" class="user-image-hr" alt=""></span></a>';
											}
										}
									}
									$ol .= '';
								}
								//$ol = 'A';
								/* get User info*/
								$u_created = $this->Umb_model->read_user_info($ls_tugass->created_by);
								if(!is_null($u_created)){
									$f_name = $u_created[0]->first_name.' '.$u_created[0]->last_name;
								} else {
									$f_name = '--';	
								}
								
								// tugas project
								$prj_tugas = $this->Project_model->read_informasi_project($ls_tugass->project_id);
								if(!is_null($prj_tugas)){
									$nama_prj = $prj_tugas[0]->title;
								} else {
									$nama_prj = '--';
								}
								// tugas category
								$tugas_cat = $this->Project_model->read_informasi_kategori_tugas($ls_tugass->nama_tugas);
								if(!is_null($tugas_cat)){
									$catnama_tugas = $tugas_cat[0]->nama_kategori;
								} else {
									$catnama_tugas = '--';
								}
								
								/// set tugas progress
								if($ls_tugass->progress_tugas=='' || $ls_tugass->progress_tugas==0): $progress = 0; else: $progress = $ls_tugass->progress_tugas; endif;				
								// tugas progress
								if($ls_tugass->progress_tugas <= 20) {
									$progress_class = 'progress-bar-danger';
								} else if($ls_tugass->progress_tugas > 20 && $ls_tugass->progress_tugas <= 50){
									$progress_class = 'progress-bar-warning';
								} else if($ls_tugass->progress_tugas > 50 && $ls_tugass->progress_tugas <= 75){
									$progress_class = 'progress-bar-info';
								} else {
									$progress_class = 'progress-bar-success';
								}
								
								$progress_bar = '<p class="m-b-0-5">'.$this->lang->line('umb_completed').' <span class="pull-xs-right">'.$ls_tugass->progress_tugas.'%</span>
								<div class="progress progress-xs"><div class="progress-bar '.$progress_class.' progress-bar-striped" role="progressbar" aria-valuenow="'.$ls_tugass->progress_tugas.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$ls_tugass->progress_tugas.'%"></div></div></p>';
								// tugas status			
								if($ls_tugass->status_tugas == 0) {
									$status = '<span class="label label-warning">'.$this->lang->line('umb_not_started').'</span>';
								} else if($ls_tugass->status_tugas ==1){
									$status = '<span class="label label-primary">'.$this->lang->line('umb_in_progress').'</span>';
								} else if($ls_tugass->status_tugas ==2){
									$status = '<span class="label label-success">'.$this->lang->line('umb_completed').'</span>';
								} else if($ls_tugass->status_tugas ==3){
									$status = '<span class="label label-danger">'.$this->lang->line('umb_project_cancelled').'</span>';
								} else {
									$status = '<span class="label label-danger">'.$this->lang->line('umb_project_hold').'</span>';
								}
								// tugas start/end date
								$psdate = $this->Umb_model->set_date_format($ls_tugass->start_date);
								$pedate = $this->Umb_model->set_date_format($ls_tugass->end_date);
								$ttugas_date = $this->lang->line('umb_start_date').': '.$psdate.'<br>'.$this->lang->line('umb_end_date').': '.$pedate;	
								?>
								<tr>
									<td><?php echo $catnama_tugas.'<br>'.$this->lang->line('umb_project').': <a href="'.site_url().'admin/project/detail/'.$ls_tugass->project_id.'">'.$nama_prj.'</a><br>'.$this->lang->line('umb_hours').': '.$ls_tugass->jam_tugas;?></td>
									<td><?php echo $ol;?></td>
									<td><?php echo $ttugas_date;?></td>
									<td><?php echo $status;?></td>
									<td><?php echo $f_name;?></td>
									<td><?php echo $progress_bar;?></td>
								</tr>
							<?php endforeach;?>
						</thead>
					</table>
				</div>
			</div>
		</div>
		<div class="tab-pane" id="invoices">
			<div class="box-body">
				<div class="box-datatable table-responsive">
					<table class="datatables-demo table table-striped table-bordered" id="umb_dashboard_projects_table">
						<thead>
							<tr>
								<th><?php echo $this->lang->line('umb_invoice_no');?></th>
								<th><?php echo $this->lang->line('umb_project');?></th>
								<th><?php echo $this->lang->line('umb_acc_total');?></th>
								<th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('umb_tanggal_invoice');?></th>
								<th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('umb_tanggal_jatoh_tempo_invoice');?></th>
								<th><?php echo $this->lang->line('kpi_status');?></th>
							</tr>
							<?php $role_resources_ids = $this->Umb_model->user_role_resource(); foreach(total_invoices_terakhir() as $ls_invoices):?>
							<?php
							
							$grand_total = $this->Umb_model->currency_sign($ls_invoices->grand_total);
							$project = $this->Project_model->read_informasi_project($ls_invoices->project_id); 
							if(!is_null($project)){
								$nama_project = $project[0]->title;
							} else {
								$nama_project = '--';	
							}
							$tanggal_invoice = '<i class="far fa-calendar-alt position-left"></i> '.$this->Umb_model->set_date_format($ls_invoices->tanggal_invoice);
							$tanggal_jatoh_tempo_invoice = '<i class="far fa-calendar-alt position-left"></i> '.$this->Umb_model->set_date_format($ls_invoices->tanggal_jatoh_tempo_invoice);
							  //nomor_invoice
							$nomor_invoice = '';
								if(in_array('330',$role_resources_ids)) { //view
									$nomor_invoice = '<a href="'.site_url().'admin/invoices/view/'.$ls_invoices->invoice_id.'/">'.$ls_invoices->nomor_invoice.'</a>';
								} else {
									$nomor_invoice = $ls_invoices->nomor_invoice;
								}
								if($ls_invoices->status == 0){
									$status = '<span class="label label-danger">'.$this->lang->line('umb_payroll_belum_dibayar').'</span>';
								} else if($ls_invoices->status == 1) {
									$status = '<span class="label label-success">'.$this->lang->line('umb_payment_bayar').'</span>';
								} else {
									$status = '<span class="label label-info">'.$this->lang->line('umb_acc_inv_cancelled').'</span>';
								}
								?>
								<tr>
									<td><?php echo $nomor_invoice;?></td>
									<td><?php echo $nama_project;?></td>
									<td><?php echo $grand_total;?></td>
									<td><?php echo $tanggal_invoice;?></td>
									<td><?php echo $tanggal_jatoh_tempo_invoice;?></td>
									<td><?php echo $status;?></td>
								</tr>
							<?php endforeach;?>
						</thead>
					</table>
				</div>
			</div>
		</div>
		<div class="tab-pane" id="estimates">
			<div class="box-body">
				<div class="box-datatable table-responsive">
					<table class="datatables-demo table table-striped table-bordered" id="umb_dashboard_projects_table">
						<thead>
							<tr>
								<th><?php echo $this->lang->line('umb_title_quote_hash');?></th>
								<th><?php echo $this->lang->line('umb_project_title');?></th>
								<th><?php echo $this->lang->line('umb_acc_total');?></th>
								<th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('umb_quote_tanggal');?></th>
								<th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('umb_tanggal_jatoh_tempo_invoice');?></th>
								<th><?php echo $this->lang->line('dashboard_umb_status');?></th>
							</tr>
							<?php $role_resources_ids = $this->Umb_model->user_role_resource(); foreach(total_last_estimates() as $ls_estimates):?>
							<?php
						 	 /// get country
							$info_perusahaan = $this->Perusahaan_model->read_informasi_perusahaan($ls_estimates->perusahaan_id);
							if(!is_null($info_perusahaan)){
								$grand_total = $this->Umb_model->perusahaan_currency_sign($ls_estimates->grand_total,$ls_estimates->perusahaan_id);	
							} else {
								$grand_total = $this->Umb_model->currency_sign($ls_estimates->grand_total);
							}
							
							
							   // get project
							$project = $this->Project_model->read_informasi_project($ls_estimates->project_id); 
							if(!is_null($project)){
								$nama_project = $project[0]->title;
							} else {
								$nama_project = '--';	
							}
							$quote_tanggal = '<i class="far fa-calendar-alt position-left"></i> '.$this->Umb_model->set_date_format($ls_estimates->quote_tanggal);
							$quote_due_date = '<i class="far fa-calendar-alt position-left"></i> '.$this->Umb_model->set_date_format($ls_estimates->quote_due_date);
							$quote_number = '';
							if(in_array('330',$role_resources_ids)) { //view
								$quote_number = '<a href="'.site_url().'admin/quotes/view/'.$ls_estimates->quote_id.'/">'.$ls_estimates->quote_number.'</a>';
							} else {
								$quote_number = $ls_estimates->quote_number;
							}
							if($ls_estimates->status == 0){
								$status = '<span class="label label-warning">'.$this->lang->line('umb_quoted_title').'</span>';
							} else {
								$status = '<span class="label label-success">'.$this->lang->line('umb_quote_invoiced').'</span>';
							}
							$record_convert_quote = $this->Quotes_model->read_info_converted_quote($ls_estimates->quote_id);
							?>
							<tr>
								<td><?php echo $quote_number;?></td>
								<td><?php echo $nama_project;?></td>
								<td><?php echo $grand_total;?></td>
								<td><?php echo $quote_tanggal;?></td>
								<td><?php echo $quote_due_date;?></td>
								<td><?php echo $status;?></td>
							</tr>
						<?php endforeach;?>
					</thead>
				</table>
			</div>
		</div>
	</div>
	<div class="tab-pane" id="pembayarans_invoice">
		<div class="box-body">
			<div class="box-datatable table-responsive">
				<table class="datatables-demo table table-striped table-bordered" id="umb_dashboard_projects_table">
					<thead>
						<tr>
							<th><?php echo $this->lang->line('umb_invoice_no');?></th>
							<th><?php echo $this->lang->line('umb_nama_klien');?></th>
							<th><?php echo $this->lang->line('umb_e_details_tanggal');?></th>
							<th><?php echo $this->lang->line('umb_jumlah');?></th>
							<th><?php echo $this->lang->line('umb_payment_method');?></th>
							<th><?php echo $this->lang->line('umb_description');?></th>
						</tr>
						<?php $role_resources_ids = $this->Umb_model->user_role_resource(); foreach(total_5_pembayarans_invoice_terakhir() as $ls_pembayarans_invoice):?>
						<?php
						
						$tanggal_transaksi = $this->Umb_model->set_date_format($ls_pembayarans_invoice->tanggal_transaksi);
						
						$jumlah_total = $this->Umb_model->currency_sign($ls_pembayarans_invoice->jumlah);
							// credit
						$cr_dr = $ls_pembayarans_invoice->dr_cr=="dr" ? "Debit" : "Credit";
						
						$info_invoice = $this->Invoices_model->read_info_invoice($ls_pembayarans_invoice->invoice_id);
						if(!is_null($info_invoice)){
							$no_inv = $info_invoice[0]->nomor_invoice;
						} else {
							$no_inv = '--';	
						}
							// payment method 
						$payment_method = $this->Umb_model->read_payment_method($ls_pembayarans_invoice->payment_method_id);
						if(!is_null($payment_method)){
							$method_name = $payment_method[0]->method_name;
						} else {
							$method_name = '--';	
						}	
							// payment method 
						$clientinfo = $this->Clients_model->read_info_client($ls_pembayarans_invoice->client_id);
						if(!is_null($clientinfo)){
							$name_name = $clientinfo[0]->name;
						} else {
							$name_name = '--';	
						}
						
						$nomor_invoice = '<a href="'.site_url().'admin/invoices/view/'.$ls_pembayarans_invoice->invoice_id.'/">'.$no_inv.'</a>';
						?>
						<tr>
							<td><?php echo $nomor_invoice;?></td>
							<td><?php echo $name_name;?></td>
							<td><?php echo $tanggal_transaksi;?></td>
							<td><?php echo $jumlah_total;?></td>
							<td><?php echo $method_name;?></td>
							<td><?php echo $ls_pembayarans_invoice->description;?></td>
						</tr>
					<?php endforeach;?>
				</thead>
			</table>
		</div>
	</div>
</div>
<div class="tab-pane" id="clients">
	<div class="box-body">
		<div class="box-datatable table-responsive">
			<table class="datatables-demo table table-striped table-bordered" id="umb_dashboard_projects_table">
				<thead>
					<tr>
						<th><?php echo $this->lang->line('umb_nama_klien');?></th>
						<th><?php echo $this->lang->line('module_title_perusahaan');?></th>
						<th><?php echo $this->lang->line('umb_email');?></th>
						<th><?php echo $this->lang->line('umb_website');?></th>
						<th><?php echo $this->lang->line('umb_negara');?></th>
					</tr>
					<?php $role_resources_ids = $this->Umb_model->user_role_resource(); foreach(total_clients_terakhir() as $ls_clients):?>
					<?php
						 	 // get country
					$negara = $this->Umb_model->read_info_negara($ls_clients->negara);
					if(!is_null($negara)){
						$c_name = $negara[0]->nama_negara;
					} else {
						$c_name = '--';	
					}
					?>
					<tr>
						<td><?php echo $ls_clients->name;?></td>
						<td><?php echo $ls_clients->nama_perusahaan;?></td>
						<td><?php echo $ls_clients->email;?></td>
						<td><?php echo $ls_clients->website_url;?></td>
						<td><?php echo $c_name;?></td>
					</tr>
				<?php endforeach;?>
			</thead>
		</table>
	</div>
</div>
</div>
<div class="tab-pane" id="leads">
	<div class="box-body">
		<div class="box-datatable table-responsive">
			<table class="datatables-demo table table-striped table-bordered" id="umb_dashboard_projects_table">
				<thead>
					<tr>
						<th><?php echo $this->lang->line('umb_nama_klien');?></th>
						<th><?php echo $this->lang->line('module_title_perusahaan');?></th>
						<th><?php echo $this->lang->line('umb_email');?></th>
						<th><?php echo $this->lang->line('umb_website');?></th>
						<th><?php echo $this->lang->line('umb_negara');?></th>
					</tr>
					<?php $role_resources_ids = $this->Umb_model->user_role_resource(); foreach(total_leads_terakhir() as $ls_leads):?>
					<?php
						 	// get country
					$negara = $this->Umb_model->read_info_negara($ls_leads->negara);
					if(!is_null($negara)){
						$c_name = $negara[0]->nama_negara;
					} else {
						$c_name = '--';	
					}	
					$lead_flup = $this->Clients_model->get_total_lead_followup($ls_leads->client_id);
							// change to client
					if($ls_leads->is_changed == '0'){
						$opt = '<span class="badge bg-purple">'.$this->lang->line('umb_lead').'</span>';
					} else {
						$opt = '<span class="badge bg-green">'.$this->lang->line('umb_kontak_person').'</span>';
					}
					if($lead_flup > 0){
						if($ls_leads->is_changed == '0'){
							$ldflp_opt = '<span class="badge bg-red">'.$this->lang->line('umb_lead_followup').'</span>';
						} else {
							$ldflp_opt = '';
						}
					} else {
						$ldflp_opt = '';
					}
					
					if($ls_leads->is_changed == 0){
						$dview = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_lead_add_followup').'"><a href="'.site_url().'admin/leads/followup/'.$ls_leads->client_id.'"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span>';
					} else {
						$dview = '';
					}
					?>
					<tr>
						<td><?php echo $ls_leads->name.'<br>'.$opt.'<br>'.$ldflp_opt;?></td>
						<td><?php echo $ls_leads->nama_perusahaan;?></td>
						<td><?php echo $ls_leads->email;?></td>
						<td><?php echo $ls_leads->website_url;?></td>
						<td><?php echo $c_name;?></td>
					</tr>
				<?php endforeach;?>
			</thead>
		</table>
	</div>
</div>
</div>
<div class="tab-pane" id="quoted_projects">
	<div class="box-body">
		<div class="box-datatable table-responsive">
			<table class="datatables-demo table table-striped table-bordered" id="umb_dashboard_projects_table">
				<thead>
					<tr>
						<th><?php echo $this->lang->line('umb_project');?>#</th>
						<th width="180"><?php echo $this->lang->line('umb_ringkasan_project');?></th>
						<th><?php echo $this->lang->line('umb_p_priority');?></th>
						<th><i class="fa fa-user"></i> <?php echo $this->lang->line('umb_project_users');?></th>
						<th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('umb_quote_tanggal');?></th>
						<th><?php echo $this->lang->line('dashboard_umb_progress');?></th>
					</tr>
					<?php $role_resources_ids = $this->Umb_model->user_role_resource(); foreach(total_5_qprojects_terakhir() as $ls_qprojects):?>
					<?php
					$aim = explode(',',$ls_qprojects->assigned_to);
					
					$user = $this->Umb_model->read_user_info($ls_qprojects->added_by);
					
					if(!is_null($user)){
						$full_name = $user[0]->first_name.' '.$user[0]->last_name;
					} else {
						$full_name = '--';	
					}
							// get date
					$estimate_date = $this->Umb_model->set_date_format($ls_qprojects->estimate_date);			
							//progress_project
					if($ls_qprojects->progress_project <= 20) {
						$progress_class = 'progress-bar-danger';
					} else if($ls_qprojects->progress_project > 20 && $ls_qprojects->progress_project <= 50){
						$progress_class = 'progress-bar-warning';
					} else if($ls_qprojects->progress_project > 50 && $ls_qprojects->progress_project <= 75){
						$progress_class = 'progress-bar-info';
					} else {
						$progress_class = 'progress-bar-success';
					}
					
							// progress
					$pbar = '<p class="m-b-0-5">'.$this->lang->line('umb_completed').' <span class="pull-xs-right">'.$ls_qprojects->progress_project.'%</span>
					<div class="progress progress-xs"><div class="progress-bar '.$progress_class.' progress-bar-striped" role="progressbar" aria-valuenow="'.$ls_qprojects->progress_project.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$ls_qprojects->progress_project.'%"></div></div></p>';
					
					
							//status
					if($ls_qprojects->status == 0) {
						$status = '<span class="label label-warning">'.$this->lang->line('umb_not_started').'</span>';
					} else if($ls_qprojects->status ==1){
						$status = '<span class="label label-primary">'.$this->lang->line('umb_in_progress').'</span>';
					} else if($ls_qprojects->status ==2){
						$status = '<span class="label label-success">'.$this->lang->line('umb_completed').'</span>';
					} else if($ls_qprojects->status ==3){
						$status = '<span class="label label-danger">'.$this->lang->line('umb_project_cancelled').'</span>';
					} else {
						$status = '<span class="label label-danger">'.$this->lang->line('umb_project_hold').'</span>';
					}
					
							// priority
					if($ls_qprojects->priority == 1) {
						$priority = '<span class="label label-danger">'.$this->lang->line('umb_highest').'</span>';
					} else if($ls_qprojects->priority ==2){
						$priority = '<span class="label label-danger">'.$this->lang->line('umb_high').'</span>';
					} else if($ls_qprojects->priority ==3){
						$priority = '<span class="label label-primary">'.$this->lang->line('umb_normal').'</span>';
					} else {
						$priority = '<span class="label label-success">'.$this->lang->line('umb_low').'</span>';
					}
					
							//assigned user
					if($ls_qprojects->assigned_to == '') {
						$ol = $this->lang->line('umb_not_assigned');
					} else {
						$ol = '';
						foreach(explode(',',$ls_qprojects->assigned_to) as $tunjuk_id) {
							$assigned_to = $this->Umb_model->read_user_info($tunjuk_id);
							if(!is_null($assigned_to)){
								
								$assigned_name = $assigned_to[0]->first_name.' '.$assigned_to[0]->last_name;
								if($assigned_to[0]->profile_picture!='' && $assigned_to[0]->profile_picture!='no file') {
									$ol .= '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.base_url().'uploads/profile/'.$assigned_to[0]->profile_picture.'" class="user-image-hr" alt=""></span></a>';
								} else {
									if($assigned_to[0]->jenis_kelamin=='Pria') { 
										$de_file = base_url().'uploads/profile/default_male.jpg';
									} else {
										$de_file = base_url().'uploads/profile/default_female.jpg';
									}
									$ol .= '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.$de_file.'" class="user-image-hr" alt=""></span></a>';
								}
									} ////
									else {
										$ol .= '';
									}
								}
								$ol .= '';
							}
							
							$client = $this->Clients_model->read_info_client($ls_qprojects->client_id);
							if(!is_null($client)) {
								$name_client = $client[0]->name;
							} else {
								$name_client = '--';
							}
							
							//$new_time = $this->Umb_model->actual_hours_timelog($ls_qprojects->project_id);
							$ringkasan_project = '<a href="'.site_url().'admin/quoted_projects/detail/'.$ls_qprojects->project_id . '">'.$ls_qprojects->title.'</a><br><small>'.$this->lang->line('umb_project_client').': '.$name_client.'</small><br><small>'.$this->lang->line('umb_estimate_hrs').': '.$ls_qprojects->estimate_hrs.'</small>';
							
							// progress
							$progress_project = $pbar.$status;
							$no_project = '<a href="'.site_url().'admin/quoted_projects/detail/'.$ls_qprojects->project_id . '">'.$ls_qprojects->no_project.'</a>';
							?>
							<tr>
								<td><?php echo $no_project;?></td>
								<td><?php echo $ringkasan_project;?></td>
								<td><?php echo $priority;?></td>
								<td><?php echo $ol;?></td>
								<td><?php echo $estimate_date;?></td>
								<td><?php echo $progress_project;?></td>
							</tr>
						<?php endforeach;?>
					</thead>
				</table>
			</div>
		</div>
	</div>
</div>
<!-- /.tab-content -->
</div>
<!-- nav-tabs-custom -->
</div>
<!-- /.col -->
</div>
</div>