<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['karyawan_id']) && $_GET['data']=='payroll_approve' && $_GET['type']=='payroll_approve'){ ?>
	<div class="modal-header animated fadeInRight">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
		<h4 class="modal-title" id="edit-modal-data">Approve Payroll</h4>
	</div>
	<div class="modal-body animated fadeInRight">
		Testt...
	</div>
<?php }
if(isset($_GET['jd']) && isset($_GET['karyawan_id']) && $_GET['data']=='payroll_template' && $_GET['type']=='payroll_template'){ ?>
	<?php
	$system = $this->Umb_model->read_setting_info(1);
	$gaji_tunjanagans = $this->Karyawans_model->read_gaji_tunjanagans($karyawan_id);
	$count_tunjanagans = $this->Karyawans_model->count_karyawan_tunjanagans($karyawan_id);
	$jumlah_tunjanagan = 0;
	if($count_tunjanagans > 0) {
		foreach($gaji_tunjanagans as $sl_tunjanagans){
			$jumlah_tunjanagan += $sl_tunjanagans->jumlah_tunjanagan;
		}
	} else {
		$jumlah_tunjanagan = 0;
	}
	$sta_gaji = $jumlah_tunjanagan + $gaji_pokok;
	?>
	<?php
	if($profile_picture!='' && $profile_picture!='no file') {
		$u_file = 'uploads/profile/'.$profile_picture;
	} else {
		if($jenis_kelamin=='Pria') { 
			$u_file = 'uploads/profile/default_male.jpg';
		} else {
			$u_file = 'uploads/profile/default_female.jpg';
		}
	}
	?>
	<div class="modal-body">
		<h4 class="text-center font-weight-bol"><?php echo $this->lang->line('umb_payroll_karyawan_gaji_details');?></h4>
		<div class="container-m-nx container-m-ny ml-1">
			<div class="media col-md-12 col-lg-8 col-xl-12 py-5 mx-auto">
				<img src="<?php echo base_url().$u_file;?>" alt="<?php echo $first_name.' '.$last_name;?>" class="d-block ui-w-100 rounded-circle">
				<div class="media-body ml-3">
					<h4 class="font-weight-bold mb-1"><?php echo $first_name.' '.$last_name;?></h4>
					<div class="text-muted mb-4">
						<?php echo $nama_penunjukan;?>
					</div>
					<a href="javascript:void(0)" class="d-inline-block text-body">
						<strong><?php echo $this->lang->line('umb_krywn_id');?>: &nbsp;<span class="pull-right"><?php echo $karyawan_id;?></span></strong>
					</a>
					<a href="javascript:void(0)" class="d-inline-block text-body">
						<strong><?php echo $this->lang->line('umb_joining_date');?>: &nbsp;<span class="pull-right"><?php echo $tanggal_bergabung;?></span></strong>
					</a>
				</div>
			</div>
		</div>
		<div class="row mb-1">
			<div class="col-sm-12 col-xs-12 col-xl-12">
				<div class="card-header text-uppercase"><b><?php echo $this->lang->line('umb_payroll_gaji_details');?></b></div>
				<div class="card-block">
					<div id="accordion">
						<div class="card hrastral-slipgaji">
							<div class="card-header"> <a class="text-dark collapsed" data-toggle="collapse" href="#gaji_pokok" aria-expanded="false"> <strong><?php echo $this->lang->line('umb_payroll_gaji_pokok');?></strong> </a> </div>
							<div id="gaji_pokok" class="collapse" data-parent="#accordion" style="">
								<div class="box-body ml-3 mr-3">
									<div class="table-responsive" data-pattern="priority-columns">
										<?php
										if($system[0]->is_half_monthly==1){
					//if($potong_setengah_bulan==2){
											$gaji_pokok = $gaji_pokok / 2;
					//} else {
						//$gaji_pokok = $gaji_pokok;
					//}
										} else {
											$gaji_pokok = $gaji_pokok;
										}
										?>
										<table class="datatables-demo table table-striped table-bordered dataTable no-footer">
											<tbody>
												<tr>
													<td><strong><?php echo $this->lang->line('umb_payroll_gaji_pokok');?>:</strong> <span class="pull-right"><?php echo $this->Umb_model->currency_sign($gaji_pokok);?></span></td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
						<?php $tunjanagans = $this->Karyawans_model->set_tunjanagans_karyawan($user_id);?>
						<?php if(!is_null($tunjanagans)):?>
							<div class="card hrastral-slipgaji">
								<div class="card-header"> <a class="text-dark collapsed" data-toggle="collapse" href="#set_tunjanagans" aria-expanded="false"> <strong><?php echo $this->lang->line('umb_karyawan_set_tunjanagans');?></strong> </a> </div>
								<div id="set_tunjanagans" class="collapse" data-parent="#accordion" style="">
									<div class="box-body ml-3 mr-3">
										<div class="table-responsive" data-pattern="priority-columns">
											<table class="datatables-demo table table-striped table-bordered dataTable no-footer">
												<tbody>
													<?php $jumlah_tunjanagan = 0; foreach($tunjanagans->result() as $sl_tunjanagans) { ?>
														<?php 
														$pg_jumlah_tunjanagan = $sl_tunjanagans->jumlah_tunjanagan;
														if($sl_tunjanagans->jumlah_option==0){
															$jumlah_tunjanagan_opt = $this->lang->line('umb_title_fixed_pajak');
														} else {
															$jumlah_tunjanagan_opt = $this->lang->line('umb_title_percent_pajak');
														}
														if($sl_tunjanagans->is_tunjanagan_kena_pajak==0){
															$tunjanagan_opt = $this->lang->line('umb_gaji_tunjanagan_todak_kena_pajak');
														} else if($sl_tunjanagans->is_tunjanagan_kena_pajak==1){
															$tunjanagan_opt = $this->lang->line('umb_fully_kena_pajak');
														} else {
															$tunjanagan_opt = $this->lang->line('umb_partially_kena_pajak');
														}
														if($system[0]->is_half_monthly==1){
															if($system[0]->potong_setengah_bulan==2){
																$ijumlah_tunjanagan = $sl_tunjanagans->jumlah_tunjanagan/2;
															} else {
																$ijumlah_tunjanagan = $sl_tunjanagans->jumlah_tunjanagan;
															}
															$jumlah_tunjanagan += $ijumlah_tunjanagan;
														} else {
						  //$ejumlah_tunjanagan = $sl_tunjanagans->jumlah_tunjanagan;
															if($sl_tunjanagans->is_tunjanagan_kena_pajak == 1) {
																if($sl_tunjanagans->jumlah_option == 0) {
																	$ijumlah_tunjanagan = $sl_tunjanagans->jumlah_tunjanagan;
																} else {
																	$ijumlah_tunjanagan = $gaji_pokok / 100 * $sl_tunjanagans->jumlah_tunjanagan;
																}
																$jumlah_tunjanagan -= $ijumlah_tunjanagan; 
															} else if($sl_tunjanagans->is_tunjanagan_kena_pajak == 2) {
																if($sl_tunjanagans->jumlah_option == 0) {
																	$ijumlah_tunjanagan = $sl_tunjanagans->jumlah_tunjanagan / 2;
																} else {
																	$ijumlah_tunjanagan = ($gaji_pokok / 100) / 2 * $sl_tunjanagans->jumlah_tunjanagan;
																}
																$jumlah_tunjanagan -= $ijumlah_tunjanagan; 
															} else {
																if($sl_tunjanagans->jumlah_option == 0) {
																	$ijumlah_tunjanagan = $sl_tunjanagans->jumlah_tunjanagan;
																} else {
																	$ijumlah_tunjanagan = $gaji_pokok / 100 * $sl_tunjanagans->jumlah_tunjanagan;
																}
																$jumlah_tunjanagan += $ijumlah_tunjanagan;
															}
														}
														
					 // $jumlah_tunjanagan += $ejumlah_tunjanagan;
														?>
														<tr>
															<td><strong><?php echo $sl_tunjanagans->title_tunjanagan;?> (<?php echo $jumlah_tunjanagan_opt;?>) (<?php echo $tunjanagan_opt;?>):</strong> <span class="pull-right"><?php echo $this->Umb_model->currency_sign($jumlah_tunjanagan);?></span></td>
														</tr>
													<?php } ?>
													<tr>
														<td><strong><?php echo $this->lang->line('umb_acc_total');?>:</strong> <span class="pull-right"><?php echo $this->Umb_model->currency_sign($jumlah_tunjanagan);?></span></td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						<?php endif;?>
						<?php $komissi = $this->Karyawans_model->set_komissi_karyawan($user_id);?>
						<?php if(!is_null($komissi)):?>
							<div class="card hrastral-slipgaji">
								<div class="card-header"> <a class="text-dark collapsed" data-toggle="collapse" href="#set_komissi" aria-expanded="false"> <strong><?php echo $this->lang->line('umb_hr_komissi');?></strong> </a> </div>
								<div id="set_komissi" class="collapse" data-parent="#accordion" style="">
									<div class="box-body ml-3 mr-3">
										<div class="table-responsive" data-pattern="priority-columns">
											<table class="datatables-demo table table-striped table-bordered dataTable no-footer">
												<tbody>
													<?php $jumlah_komissi = 0; foreach($komissi->result() as $sl_komissi) { ?>
														<?php 
														$pg_jumlah_komissi = $sl_komissi->jumlah_komisi;
														if($system[0]->is_half_monthly==1){
															if($system[0]->potong_setengah_bulan==2){
																$ejumlah_komissi = $sl_komissi->jumlah_komisi/2;
															} else {
																$ejumlah_komissi = $sl_komissi->jumlah_komisi;
															}
															$jumlah_komissi += $ejumlah_komissi;
														} else {
						 // $ejumlah_komissi = $sl_komissi->jumlah_komisi;
															if($sl_komissi->is_komisi_kena_pajak == 1) {
																if($sl_komissi->jumlah_option == 0) {
																	$ejumlah_komissi = $sl_komissi->jumlah_komisi;
																} else {
																	$ejumlah_komissi = $gaji_pokok / 100 * $sl_komissi->jumlah_komisi;
																}
																$jumlah_komissi -= $ejumlah_komissi; 
															} else if($sl_komissi->is_komisi_kena_pajak == 2) {
																if($sl_komissi->jumlah_option == 0) {
																	$ejumlah_komissi = $sl_komissi->jumlah_komisi / 2;
																} else {
																	$ejumlah_komissi = ($gaji_pokok / 100) / 2 * $sl_komissi->jumlah_komisi;
																}
																$jumlah_komissi -= $ejumlah_komissi; 
															} else {
																if($sl_komissi->jumlah_option == 0) {
																	$ejumlah_komissi = $sl_komissi->jumlah_komisi;
																} else {
																	$ejumlah_komissi = $gaji_pokok / 100 * $sl_komissi->jumlah_komisi;
																}
																$jumlah_komissi += $ejumlah_komissi;
															}
														}
														if($sl_komissi->jumlah_option==0){
															$opt_jumlah_komisi = $this->lang->line('umb_title_fixed_pajak');
														} else {
															$opt_jumlah_komisi = $this->lang->line('umb_title_percent_pajak');
														}
														if($sl_komissi->is_komisi_kena_pajak==0){
															$opt_komisi = $this->lang->line('umb_gaji_tunjanagan_todak_kena_pajak');
														} else if($sl_komissi->is_komisi_kena_pajak==1){
															$opt_komisi = $this->lang->line('umb_fully_kena_pajak');
														} else {
															$opt_komisi = $this->lang->line('umb_partially_kena_pajak');
														}
														
														?>
														<?php //$jumlah_komissi += $sl_komissi->jumlah_komisi;?>
														<tr>
															<td><strong><?php echo $sl_komissi->komisi_title;?> (<?php echo $opt_jumlah_komisi;?>) (<?php echo $opt_komisi;?>):</strong> <span class="pull-right"><?php echo $this->Umb_model->currency_sign($ejumlah_komissi);?></span></td>
														</tr>
													<?php } ?>
													<tr>
														<td><strong><?php echo $this->lang->line('umb_acc_total');?>:</strong> <span class="pull-right"><?php echo $this->Umb_model->currency_sign($jumlah_komissi);?></span></td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						<?php endif;?>
						<?php $statutory_potongans = $this->Karyawans_model->set_karyawan_statutory_potongans($user_id);?>
						<?php if(!is_null($statutory_potongans)):?>
							<div class="card hrastral-slipgaji">
								<div class="card-header"> <a class="text-dark collapsed" data-toggle="collapse" href="#statutory_potongans" aria-expanded="false"> <strong><?php echo $this->lang->line('umb_karyawan_set_statutory_potongans');?></strong> </a> </div>
								<div id="statutory_potongans" class="collapse" data-parent="#accordion" style="">
									<div class="box-body ml-3 mr-3">
										<div class="table-responsive" data-pattern="priority-columns">
											<table class="datatables-demo table table-striped table-bordered dataTable no-footer">
												<tbody>
													<?php $jumlah_statutory_potongans = 0; foreach($statutory_potongans->result() as $sl_statutory_potongans) { ?>
														<?php
														$sta_gaji = $gaji_pokok;
														$st_jumlah = $sta_gaji / 100 * $sl_statutory_potongans->jumlah_potongan;
														if($system[0]->is_half_monthly==1){
															if($system[0]->potong_setengah_bulan==2){
																$single_sd = $st_jumlah/2;
															} else {
																$single_sd = $st_jumlah;
															}
															$jumlah_statutory_potongans += $single_sd;
														} else {
															
															if($sl_statutory_potongans->statutory_options == 0) {
																$single_sd = $sl_statutory_potongans->jumlah_potongan;
															} else {
																$single_sd = $gaji_pokok / 100 * $sl_statutory_potongans->jumlah_potongan;
															}
															$jumlah_statutory_potongans += $single_sd;
														}
														if($sl_statutory_potongans->statutory_options==0){
															$opt_jumlah_sd = $this->lang->line('umb_title_fixed_pajak');
														} else {
															$opt_jumlah_sd = $this->lang->line('umb_title_percent_pajak');
														}
														
														?>
														<tr>
															<td><strong><?php echo $sl_statutory_potongans->title_potongan;?> (<?php echo $opt_jumlah_sd;?>): </strong> <span class="pull-right"><?php echo $this->Umb_model->currency_sign($single_sd);?></span></td>
														</tr>
													<?php } ?>
													<tr>
														<td><strong><?php echo $this->lang->line('umb_acc_total');?>:</strong> <span class="pull-right"><?php echo $this->Umb_model->currency_sign($jumlah_statutory_potongans);?></span></td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						<?php endif;?>
						
						<?php $pembayarans_lainnya = $this->Karyawans_model->set_karyawan_pembayarans_lainnya($user_id);?>
						<?php if(!is_null($pembayarans_lainnya)):?>
							<div class="card hrastral-slipgaji">
								<div class="card-header"> <a class="text-dark collapsed" data-toggle="collapse" href="#set_pembayarans_lainnya" aria-expanded="false"> <strong><?php echo $this->lang->line('umb_karyawan_set_pembayaran_lainnya');?></strong> </a> </div>
								<div id="set_pembayarans_lainnya" class="collapse" data-parent="#accordion" style="">
									<div class="box-body ml-3 mr-3">
										<div class="table-responsive" data-pattern="priority-columns">
											<table class="datatables-demo table table-striped table-bordered dataTable no-footer">
												<tbody>
													<?php $jumlah_pembayarans_lainnya = 0; foreach($pembayarans_lainnya->result() as $sl_pembayarans_lainnya) { ?>
														<?php
														if($system[0]->is_half_monthly==1){
															if($system[0]->potong_setengah_bulan==2){
																$ejumlah_pembayarans = $sl_pembayarans_lainnya->jumlah_pembayarans/2;
															} else {
																$ejumlah_pembayarans = $sl_pembayarans_lainnya->jumlah_pembayarans;
															}
															$jumlah_pembayarans_lainnya += $ejumlah_pembayarans;
														} else {
						  //$ejumlah_pembayarans = $sl_pembayarans_lainnya->jumlah_pembayarans;
															if($sl_pembayarans_lainnya->ia_pembayaranlainnya_kena_pajak == 1) {
																if($sl_pembayarans_lainnya->jumlah_option == 0) {
																	$ejumlah_pembayarans = $sl_pembayarans_lainnya->jumlah_pembayarans;
																} else {
																	$ejumlah_pembayarans = $gaji_pokok / 100 * $sl_pembayarans_lainnya->jumlah_pembayarans;
																}
																$jumlah_pembayarans_lainnya -= $ejumlah_pembayarans; 
															} else if($sl_pembayarans_lainnya->ia_pembayaranlainnya_kena_pajak == 2) {
																if($sl_pembayarans_lainnya->jumlah_option == 0) {
																	$ejumlah_pembayarans = $sl_pembayarans_lainnya->jumlah_pembayarans / 2;
																} else {
																	$ejumlah_pembayarans = ($gaji_pokok / 100) / 2 * $sl_pembayarans_lainnya->jumlah_pembayarans;
																}
																$jumlah_pembayarans_lainnya -= $ejumlah_pembayarans; 
															} else {
																if($sl_pembayarans_lainnya->jumlah_option == 0) {
																	$ejumlah_pembayarans = $sl_pembayarans_lainnya->jumlah_pembayarans;
																} else {
																	$ejumlah_pembayarans = $gaji_pokok / 100 * $sl_pembayarans_lainnya->jumlah_pembayarans;
																}
																$jumlah_pembayarans_lainnya += $ejumlah_pembayarans;
															}
														}
														if($sl_pembayarans_lainnya->jumlah_option==0){
															$opt_jumlah_lainnya = $this->lang->line('umb_title_fixed_pajak');
														} else {
															$opt_jumlah_lainnya = $this->lang->line('umb_title_percent_pajak');
														}
														if($sl_pembayarans_lainnya->ia_pembayaranlainnya_kena_pajak==0){
															$other_opt = $this->lang->line('umb_gaji_tunjanagan_todak_kena_pajak');
														} else if($sl_pembayarans_lainnya->ia_pembayaranlainnya_kena_pajak==1){
															$other_opt = $this->lang->line('umb_fully_kena_pajak');
														} else {
															$other_opt = $this->lang->line('umb_partially_kena_pajak');
														}
														?>
														<tr>
															<td><strong><?php echo $sl_pembayarans_lainnya->title_pembayarans;?> (<?php echo $opt_jumlah_lainnya;?>) (<?php echo $other_opt;?>):</strong> <span class="pull-right"><?php echo $this->Umb_model->currency_sign($ejumlah_pembayarans);?></span></td>
														</tr>
													<?php } ?>
													<tr>
														<td><strong><?php echo $this->lang->line('umb_acc_total');?>:</strong> <span class="pull-right"><?php echo $this->Umb_model->currency_sign($jumlah_pembayarans_lainnya);?></span></td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						<?php endif;?>
						<?php $loan = $this->Karyawans_model->set_potongans_karyawan($user_id);?>
						<?php if(!is_null($loan)):?>
							<div class="card hrastral-slipgaji">
								<div class="card-header"> <a class="text-dark collapsed" data-toggle="collapse" href="#set_pinjaman_potongans" aria-expanded="false"> <strong><?php echo $this->lang->line('umb_karyawan_set_pinjaman_potongans');?></strong> </a> </div>
								<div id="set_pinjaman_potongans" class="collapse" data-parent="#accordion" style="">
									<div class="box-body ml-3 mr-3">
										<div class="table-responsive" data-pattern="priority-columns">
											<table class="datatables-demo table table-striped table-bordered dataTable no-footer">
												<tbody>
													<?php $jumlah_ptng_pinjaman = 0; foreach($loan->result() as $r_pinjaman) { ?>
														<?php 
														$pg_r_pinjaman = $r_pinjaman->pinjaman_jumlah_potongan;
														if($system[0]->is_half_monthly==1){
															if($system[0]->potong_setengah_bulan==2){
																$er_pinjaman = $r_pinjaman->pinjaman_jumlah_potongan/2;
															} else {
																$er_pinjaman = $r_pinjaman->pinjaman_jumlah_potongan;
															}
														} else {
															$er_pinjaman = $r_pinjaman->pinjaman_jumlah_potongan;
														}
														$jumlah_ptng_pinjaman += $er_pinjaman;
														?>
														<?php //$jumlah_ptng_pinjaman += $r_pinjaman->pinjaman_jumlah_potongan;?>
														<tr>
															<td><strong><?php echo $r_pinjaman->title_potongan_pinjaman;?>:</strong> <span class="pull-right"><?php echo $this->Umb_model->currency_sign($er_pinjaman);?></span></td>
														</tr>
													<?php } ?>
													<tr>
														<td><strong><?php echo $this->lang->line('umb_acc_total');?>:</strong> <span class="pull-right"><?php echo $this->Umb_model->currency_sign($jumlah_ptng_pinjaman);?></span></td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						<?php endif;?>
						
						
						<?php $lembur = $this->Karyawans_model->set_karyawan_lembur($user_id);?>
						<?php if(!is_null($lembur)):?>
							<div class="card hrastral-slipgaji">
								<div class="card-header"> <a class="text-dark collapsed" data-toggle="collapse" href="#lembur" aria-expanded="false"> <strong><?php echo $this->lang->line('dashboard_lembur');?></strong> </a> </div>
								<div id="lembur" class="collapse" data-parent="#accordion" style="">
									<div class="box-body ml-3 mr-3">
										<div class="table-responsive">
											<table class="table table-bordered mb-0">
												<thead>
													<tr>
														<th>#</th>
														<th><?php echo $this->lang->line('umb_karyawan_title_lembur');?></th>
														<th><?php echo $this->lang->line('umb_karyawan_lembur_no_of_days');?></th>
														<th><?php echo $this->lang->line('umb_karyawan_jam_lembur');?></th>
														<th><?php echo $this->lang->line('umb_karyawan_nilai_lembur');?></th>
													</tr>
												</thead>
												<tbody>
													<?php $i=1; $jumlah_lembur = 0; foreach($lembur->result() as $r_lembur) { ?>
														<?php
														
														if($system[0]->is_half_monthly==1){
															if($system[0]->potong_setengah_bulan==2){
																$ejam_lembur = $r_lembur->jam_lembur/2;
																$enilai_lembur = $r_lembur->nilai_lembur/2;
															} else {
																$ejam_lembur = $r_lembur->jam_lembur;
																$enilai_lembur = $r_lembur->nilai_lembur;
															}
														} else {
															$ejam_lembur = $r_lembur->jam_lembur;
															$enilai_lembur = $r_lembur->nilai_lembur;
														}
						//$jumlah_pembayarans_lainnya += $etotal_lembur;
														$jumlah_lembur += $ejam_lembur * $enilai_lembur;
														?>
														<tr>
															<th scope="row"><?php echo $i;?></th>
															<td><?php echo $r_lembur->type_lembur;?></td>
															<td><?php echo $r_lembur->no_of_days;?></td>
															<td><?php echo $ejam_lembur;?></td>
															<td><?php echo $enilai_lembur;?></td>
														</tr>
														<?php $i++; } ?>
													</tbody>
													<tfoot>
														<tr>
															<td colspan="4" align="right"><strong><?php echo $this->lang->line('umb_acc_total');?>:</strong></td>
															<td><?php echo $this->Umb_model->currency_sign($jumlah_lembur);?></td>
														</tr>
													</tfoot>
												</table>
											</div>
										</div>
									</div>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
			
		</div>
		<div class="modal-footer mt-1">
			<button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('umb_close');?></button>
		</div>
	<?php } else if(isset($_GET['jd']) && isset($_GET['karyawan_id']) && $_GET['data']=='slipgaji_perjam' && $_GET['type']=='read_hourly_payment'){ ?>
		<?php
		$system = $this->Umb_model->read_setting_info(1);
		$gaji_tunjanagans = $this->Karyawans_model->read_gaji_tunjanagans($karyawan_id);
		$count_tunjanagans = $this->Karyawans_model->count_karyawan_tunjanagans($karyawan_id);
		$jumlah_tunjanagan = 0;
		if($count_tunjanagans > 0) {
			foreach($gaji_tunjanagans as $sl_tunjanagans){
				$jumlah_tunjanagan += $sl_tunjanagans->jumlah_tunjanagan;
			}
		} else {
			$jumlah_tunjanagan = 0;
		}
		$sta_gaji = $jumlah_tunjanagan + $gaji_pokok;
		?>
		<?php
		if($profile_picture!='' && $profile_picture!='no file') {
			$u_file = 'uploads/profile/'.$profile_picture;
		} else {
			if($jenis_kelamin=='Pria') { 
				$u_file = 'uploads/profile/default_male.jpg';
			} else {
				$u_file = 'uploads/profile/default_female.jpg';
			}
		} ?>
		<div class="modal-body animated fadeInRight">
			<h4 class="text-center font-weight-bol"><?php echo $this->lang->line('umb_payroll_karyawan_gaji_details');?></h4>
			<div class="container-m-nx container-m-ny ml-1">
				<div class="media col-md-12 col-lg-8 col-xl-12 py-5 mx-auto">
					<img src="<?php echo base_url().$u_file;?>" alt="<?php echo $first_name.' '.$last_name;?>" class="d-block ui-w-100 rounded-circle">
					<div class="media-body ml-3">
						<h4 class="font-weight-bold mb-1"><?php echo $first_name.' '.$last_name;?></h4>
						<div class="text-muted mb-4">
							<?php echo $nama_penunjukan;?>
						</div>

						<a href="javascript:void(0)" class="d-inline-block text-body">
							<strong><?php echo $this->lang->line('umb_krywn_id');?>: &nbsp;<span class="pull-right"><?php echo $karyawan_id;?></span></strong>
						</a>
						<a href="javascript:void(0)" class="d-inline-block text-body">
							<strong><?php echo $this->lang->line('umb_joining_date');?>: &nbsp;<span class="pull-right"><?php echo $tanggal_bergabung;?></span></strong>
						</a>
					</div>
				</div>
			</div>
			<div class="row mb-1">
				<div class="col-sm-12 col-xs-12 col-xl-12">
					<div class="card-header text-uppercase"><b><?php echo $this->lang->line('umb_payroll_gaji_details');?></b></div>
					<div class="card-block">
						<div id="accordion">
							<div class="card hrastral-slipgaji">
								<div class="card-header"> <a class="text-dark collapsed" data-toggle="collapse" href="#gaji_pokok" aria-expanded="false"> <strong><?php echo $this->lang->line('umb_karyawan_upahh_harian');?></strong> </a> </div>
								<div id="gaji_pokok" class="collapse" data-parent="#accordion" style="">
									<div class="box-body ml-3 mr-3">
										<div class="table-responsive" data-pattern="priority-columns">
											<table class="datatables-demo table table-striped table-bordered dataTable no-footer">
												<tbody>
													<tr>
														<td><strong><?php echo $this->lang->line('umb_payroll_nilai_perjam');?>:</strong> <span class="pull-right"><?php echo $this->Umb_model->currency_sign($gaji_pokok);?></span></td>
													</tr>
													<?php
													$pay_date = $_GET['pay_date'];
						//lembur request
													$lembur_count = $this->Permintaan_lembur_model->get_count_permintaan_lembur($euser_id,$pay_date);
													$re_hrs_old_int1 = 0;
													$re_hrs_old_seconds =0;
													$re_pcount = 0;
													foreach ($lembur_count as $lembur_hr){
							// total work			
														$request_clock_in =  new DateTime($lembur_hr->request_clock_in);
														$request_clock_out =  new DateTime($lembur_hr->request_clock_out);
														$re_interval_late = $request_clock_in->diff($request_clock_out);
														$re_hours_r  = $re_interval_late->format('%h');
														$re_minutes_r = $re_interval_late->format('%i');			
														$re_total_time = $re_hours_r .":".$re_minutes_r.":".'00';
														
														$re_str_time = $re_total_time;
														
														$re_str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $re_str_time);
														
														sscanf($re_str_time, "%d:%d:%d", $hours, $minutes, $seconds);
														
														$re_hrs_old_seconds = $hours * 3600 + $minutes * 60 + $seconds;
														
														$re_hrs_old_int1 += $re_hrs_old_seconds;
														
														$re_pcount = gmdate("H", $re_hrs_old_int1);			
													}
													$result = $this->Payroll_model->total_jam_bekerja($euser_id,$pay_date);
													$hrs_old_int1 = 0;
													$pcount = 0;
													$Tistrahat = 0;
													$total_time_rs = 0;
													$hrs_old_int_res1 = 0;
													foreach ($result->result() as $jam_kerja){
							// total work			
														$clock_in =  new DateTime($jam_kerja->clock_in);
														$clock_out =  new DateTime($jam_kerja->clock_out);
														$interval_late = $clock_in->diff($clock_out);
														$hours_r  = $interval_late->format('%h');
														$minutes_r = $interval_late->format('%i');			
														$total_time = $hours_r .":".$minutes_r.":".'00';
														
														$str_time = $total_time;
														
														$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);
														
														sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
														
														$hrs_old_seconds = $hours * 3600 + $minutes * 60 + $seconds;
														
														$hrs_old_int1 += $hrs_old_seconds;
														
														$pcount = gmdate("H", $hrs_old_int1);			
													}
													$pcount = $pcount + $re_pcount;
													?>
													<tr>
														<td><strong><?php echo $this->lang->line('umb_payroll_total_jam_bekerja');?>:</strong> <span class="pull-right"><?php echo $pcount;?></span></td>
													</tr>
													<?php $total_count = $pcount * $gaji_pokok;?>
													<tr>
														<td><strong><?php echo $this->lang->line('umb_acc_total');?>:</strong> <span class="pull-right"><?php echo $this->Umb_model->currency_sign($total_count);?></span></td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
							<?php $tunjanagans = $this->Karyawans_model->set_tunjanagans_karyawan($user_id);?>
							<?php if(!is_null($tunjanagans)):?>
								<div class="card hrastral-slipgaji">
									<div class="card-header"> <a class="text-dark collapsed" data-toggle="collapse" href="#set_tunjanagans" aria-expanded="false"> <strong><?php echo $this->lang->line('umb_karyawan_set_tunjanagans');?></strong> </a> </div>
									<div id="set_tunjanagans" class="collapse" data-parent="#accordion" style="">
										<div class="box-body ml-3 mr-3">
											<div class="table-responsive" data-pattern="priority-columns">
												<table class="datatables-demo table table-striped table-bordered dataTable no-footer">
													<tbody>
														<?php $jumlah_tunjanagan = 0; foreach($tunjanagans->result() as $sl_tunjanagans) { ?>
															<?php $jumlah_tunjanagan += $sl_tunjanagans->jumlah_tunjanagan;?>
															<tr>
																<td><strong><?php echo $sl_tunjanagans->title_tunjanagan;?>:</strong> <span class="pull-right"><?php echo $this->Umb_model->currency_sign($sl_tunjanagans->jumlah_tunjanagan);?></span></td>
															</tr>
														<?php } ?>
														<tr>
															<td><strong><?php echo $this->lang->line('umb_acc_total');?>:</strong> <span class="pull-right"><?php echo $this->Umb_model->currency_sign($jumlah_tunjanagan);?></span></td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							<?php endif;?>
							<?php $komissi = $this->Karyawans_model->set_komissi_karyawan($user_id);?>
							<?php if(!is_null($komissi)):?>
								<div class="card hrastral-slipgaji">
									<div class="card-header"> <a class="text-dark collapsed" data-toggle="collapse" href="#set_komissi" aria-expanded="false"> <strong><?php echo $this->lang->line('umb_hr_komissi');?></strong> </a> </div>
									<div id="set_komissi" class="collapse" data-parent="#accordion" style="">
										<div class="box-body ml-3 mr-3">
											<div class="table-responsive" data-pattern="priority-columns">
												<table class="datatables-demo table table-striped table-bordered dataTable no-footer">
													<tbody>
														<?php $jumlah_komissi = 0; foreach($komissi->result() as $sl_komissi) { ?>
															<?php $jumlah_komissi += $sl_komissi->jumlah_komisi;?>
															<tr>
																<td><strong><?php echo $sl_komissi->komisi_title;?>:</strong> <span class="pull-right"><?php echo $this->Umb_model->currency_sign($sl_komissi->jumlah_komisi);?></span></td>
															</tr>
														<?php } ?>
														<tr>
															<td><strong><?php echo $this->lang->line('umb_acc_total');?>:</strong> <span class="pull-right"><?php echo $this->Umb_model->currency_sign($jumlah_komissi);?></span></td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							<?php endif;?>
							<?php $loan = $this->Karyawans_model->set_potongans_karyawan($user_id);?>
							<?php if(!is_null($loan)):?>
								<div class="card hrastral-slipgaji">
									<div class="card-header"> <a class="text-dark collapsed" data-toggle="collapse" href="#set_pinjaman_potongans" aria-expanded="false"> <strong><?php echo $this->lang->line('umb_karyawan_set_pinjaman_potongans');?></strong> </a> </div>
									<div id="set_pinjaman_potongans" class="collapse" data-parent="#accordion" style="">
										<div class="box-body ml-3 mr-3">
											<div class="table-responsive" data-pattern="priority-columns">
												<table class="datatables-demo table table-striped table-bordered dataTable no-footer">
													<tbody>
														<?php $jumlah_ptng_pinjaman = 0; foreach($loan->result() as $r_pinjaman) { ?>
															<?php $jumlah_ptng_pinjaman += $r_pinjaman->pinjaman_jumlah_potongan;?>
															<tr>
																<td><strong><?php echo $r_pinjaman->title_potongan_pinjaman;?>:</strong> <span class="pull-right"><?php echo $this->Umb_model->currency_sign($r_pinjaman->pinjaman_jumlah_potongan);?></span></td>
															</tr>
														<?php } ?>
														<tr>
															<td><strong><?php echo $this->lang->line('umb_acc_total');?>:</strong> <span class="pull-right"><?php echo $this->Umb_model->currency_sign($jumlah_ptng_pinjaman);?></span></td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							<?php endif;?>
							<?php $statutory_potongans = $this->Karyawans_model->set_karyawan_statutory_potongans($user_id);?>
							<?php if(!is_null($statutory_potongans)):?>
								<div class="card hrastral-slipgaji">
									<div class="card-header"> <a class="text-dark collapsed" data-toggle="collapse" href="#statutory_potongans" aria-expanded="false"> <strong><?php echo $this->lang->line('umb_karyawan_set_statutory_potongans');?></strong> </a> </div>
									<div id="statutory_potongans" class="collapse" data-parent="#accordion" style="">
										<div class="box-body ml-3 mr-3">
											<div class="table-responsive" data-pattern="priority-columns">
												<table class="datatables-demo table table-striped table-bordered dataTable no-footer">
													<tbody>
														<?php $jumlah_statutory_potongans = 0; foreach($statutory_potongans->result() as $sl_statutory_potongans) { ?>
															<?php
															if($system[0]->statutory_fixed!='yes'):
																$sta_gaji = $gaji_pokok;
																$st_jumlah = $sta_gaji / 100 * $sl_statutory_potongans->jumlah_potongan;
																$jumlah_statutory_potongans += $st_jumlah;
																$single_sd = $st_jumlah;
															else:
																$jumlah_statutory_potongans += $sl_statutory_potongans->jumlah_potongan;
																$st_jumlah = $jumlah_statutory_potongans;
																$single_sd = $sl_statutory_potongans->jumlah_potongan;
															endif;
															?>
															<tr>
																<td><strong><?php echo $sl_statutory_potongans->title_potongan;?>: </strong> <span class="pull-right"><?php echo $this->Umb_model->currency_sign($single_sd);?></span></td>
															</tr>
														<?php } ?>
														<tr>
															<td><strong><?php echo $this->lang->line('umb_acc_total');?>:</strong> <span class="pull-right"><?php echo $this->Umb_model->currency_sign($jumlah_statutory_potongans);?></span></td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							<?php endif;?>
							
							<?php $pembayarans_lainnya = $this->Karyawans_model->set_karyawan_pembayarans_lainnya($user_id);?>
							<?php if(!is_null($pembayarans_lainnya)):?>
								<div class="card hrastral-slipgaji">
									<div class="card-header"> <a class="text-dark collapsed" data-toggle="collapse" href="#set_pembayarans_lainnya" aria-expanded="false"> <strong><?php echo $this->lang->line('umb_karyawan_set_pembayaran_lainnya');?></strong> </a> </div>
									<div id="set_pembayarans_lainnya" class="collapse" data-parent="#accordion" style="">
										<div class="box-body ml-3 mr-3">
											<div class="table-responsive" data-pattern="priority-columns">
												<table class="datatables-demo table table-striped table-bordered dataTable no-footer">
													<tbody>
														<?php $jumlah_pembayarans_lainnya = 0; foreach($pembayarans_lainnya->result() as $sl_pembayarans_lainnya) { ?>
															<?php $jumlah_pembayarans_lainnya += $sl_pembayarans_lainnya->jumlah_pembayarans;?>
															<tr>
																<td><strong><?php echo $sl_pembayarans_lainnya->title_pembayarans;?>:</strong> <span class="pull-right"><?php echo $this->Umb_model->currency_sign($sl_pembayarans_lainnya->jumlah_pembayarans);?></span></td>
															</tr>
														<?php } ?>
														<tr>
															<td><strong><?php echo $this->lang->line('umb_acc_total');?>:</strong> <span class="pull-right"><?php echo $this->Umb_model->currency_sign($jumlah_pembayarans_lainnya);?></span></td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							<?php endif;?>
							
							<?php $lembur = $this->Karyawans_model->set_karyawan_lembur($user_id);?>
							<?php if(!is_null($lembur)):?>
								<div class="card hrastral-slipgaji">
									<div class="card-header"> <a class="text-dark collapsed" data-toggle="collapse" href="#lembur" aria-expanded="false"> <strong><?php echo $this->lang->line('dashboard_lembur');?></strong> </a> </div>
									<div id="lembur" class="collapse" data-parent="#accordion" style="">
										<div class="card-body">
											<div class="table-responsive">
												<table class="table table-bordered mb-0">
													<thead>
														<tr>
															<th>#</th>
															<th><?php echo $this->lang->line('umb_karyawan_title_lembur');?></th>
															<th><?php echo $this->lang->line('umb_karyawan_lembur_no_of_days');?></th>
															<th><?php echo $this->lang->line('umb_karyawan_jam_lembur');?></th>
															<th><?php echo $this->lang->line('umb_karyawan_nilai_lembur');?></th>
														</tr>
													</thead>
													<tbody>
														<?php $i=1; $jumlah_lembur = 0; foreach($lembur->result() as $r_lembur) { ?>
															<?php
															$total_lembur = $r_lembur->jam_lembur * $r_lembur->nilai_lembur;
															$jumlah_lembur += $total_lembur;
															?>
															<tr>
																<th scope="row"><?php echo $i;?></th>
																<td><?php echo $r_lembur->type_lembur;?></td>
																<td><?php echo $r_lembur->no_of_days;?></td>
																<td><?php echo $r_lembur->jam_lembur;?></td>
																<td><?php echo $r_lembur->nilai_lembur;?></td>
															</tr>
															<?php $i++; } ?>
														</tbody>
														<tfoot>
															<tr>
																<td colspan="4" align="right"><strong><?php echo $this->lang->line('umb_acc_total');?>:</strong></td>
																<td><?php echo $this->Umb_model->currency_sign($jumlah_lembur);?></td>
															</tr>
														</tfoot>
													</table>
												</div>
											</div>
										</div>
									</div>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer mt-1">
				<button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('umb_close');?></button>
			</div>
		<?php }
		?>
