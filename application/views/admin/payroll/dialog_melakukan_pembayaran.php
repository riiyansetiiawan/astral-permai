<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['karyawan_id']) && $_GET['data']=='payment' && $_GET['type']=='monthly_payment'){ ?>
	<?php
	$system = $this->Umb_model->read_setting_info(1);
	$payment_month = strtotime($this->input->get('pay_date'));
	$p_month = date('F Y',$payment_month);
	if($type_upahh==1){
		if($system[0]->is_half_monthly==1){
		//if($potong_setengah_bulan==2){
			$gaji_pokok = $gaji_pokok / 2;
		//} else {
			//$gaji_pokok = $gaji_pokok;
		//}
		} else {
			$gaji_pokok = $gaji_pokok;
		}
	} else {
		$gaji_pokok = $upahh_harian;
	}
	?>
	<?php
	$gaji_tunjanagans = $this->Karyawans_model->read_gaji_tunjanagans($user_id);
	$count_tunjanagans = $this->Karyawans_model->count_karyawan_tunjanagans($user_id);
	$jumlah_tunjanagan = 0;
	$ejumlah_tunjanagan = 0;
	$ijumlah_tunjanagan = 0;
	if($count_tunjanagans > 0) {
		foreach($gaji_tunjanagans as $sl_tunjanagans){
		//$jumlah_tunjanagan += $sl_tunjanagans->jumlah_tunjanagan;
			if($system[0]->is_half_monthly==1){
				if($system[0]->potong_setengah_bulan==2){
					$ejumlah_tunjanagan = $sl_tunjanagans->jumlah_tunjanagan/2;
				} else {
					$ejumlah_tunjanagan = $sl_tunjanagans->jumlah_tunjanagan;
				}
				$jumlah_tunjanagan += $ejumlah_tunjanagan;
			} else {
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
			
		}
	} else {
		$jumlah_tunjanagan = 0;
	}
// 3: all loan/potongans
	$gaji_pinjaman_potongan = $this->Karyawans_model->read_gaji_pinjaman_potongans($user_id);
	$count_pinjaman_potongan = $this->Karyawans_model->count_karyawan_potongans($user_id);
	$jumlah_ptng_pinjaman = 0;
	if($count_pinjaman_potongan > 0) {
		foreach($gaji_pinjaman_potongan as $sl_gaji_pinjaman_potongan){
			if($system[0]->is_half_monthly==1){
				if($system[0]->potong_setengah_bulan==2){
					$er_pinjaman = $sl_gaji_pinjaman_potongan->pinjaman_jumlah_potongan/2;
				} else {
					$er_pinjaman = $sl_gaji_pinjaman_potongan->pinjaman_jumlah_potongan;
				}
			} else {
				$er_pinjaman = $sl_gaji_pinjaman_potongan->pinjaman_jumlah_potongan;
			}
			$jumlah_ptng_pinjaman += $er_pinjaman;
		}
	} else {
		$jumlah_ptng_pinjaman = 0;
	}
// 4: other payment
	$pembayarans_lainnya = $this->Karyawans_model->set_karyawan_pembayarans_lainnya($user_id);
	$jumlah_pembayarans_lainnya = 0;
	if(!is_null($pembayarans_lainnya)):
		foreach($pembayarans_lainnya->result() as $sl_pembayarans_lainnya) {
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
			
		}
	endif;
// all other payment
	$all_pembayaran_lainnya = $jumlah_pembayarans_lainnya;
// 5: komissi
	$komissi = $this->Karyawans_model->set_komissi_karyawan($user_id);
	if(!is_null($komissi)):
		$jumlah_komissi = 0;
		foreach($komissi->result() as $sl_komissi) {
			if($system[0]->is_half_monthly==1){
				if($system[0]->potong_setengah_bulan==2){
					$ejumlah_komissi = $sl_komissi->jumlah_komisi/2;
				} else {
					$ejumlah_komissi = $sl_komissi->jumlah_komisi;
				}
				$jumlah_komissi += $ejumlah_komissi;
			} else {
			  //$ejumlah_komissi = $sl_komissi->jumlah_komisi;
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
		  //$jumlah_komissi += $ejumlah_komissi;
		  //$jumlah_komissi += $sl_komissi->jumlah_komisi;
		}
	endif;
// 6: statutory potongans
	$statutory_potongans = $this->Karyawans_model->set_karyawan_statutory_potongans($user_id);
	$jumlah_statutory_potongans = 0;
	if(!is_null($statutory_potongans)):
		$jumlah_statutory_potongans = 0;
		foreach($statutory_potongans->result() as $sl_statutory_potongans) {
			if($system[0]->is_half_monthly==1){
				if($system[0]->potong_setengah_bulan==2){
					$single_sd = $sl_statutory_potongans->jumlah_potongan/2;
				} else {
					$single_sd = $sl_statutory_potongans->jumlah_potongan;
				}
				$jumlah_statutory_potongans += $single_sd;
			} else {
			  //$single_sd = $sl_statutory_potongans->jumlah_potongan;
				if($sl_statutory_potongans->statutory_options == 0) {
					$single_sd = $sl_statutory_potongans->jumlah_potongan;
				} else {
					$single_sd = $gaji_pokok / 100 * $sl_statutory_potongans->jumlah_potongan;
				}
				$jumlah_statutory_potongans += $single_sd; 
			}
		//$jumlah_statutory_potongans += $single_sd;
		}
	endif;

// 7: lembur
	$gaji_lembur = $this->Karyawans_model->read_gaji_lembur($user_id);
	$count_lembur = $this->Karyawans_model->count_karyawan_lembur($user_id);
	$jumlah_lembur = 0;
	if($count_lembur > 0) {
		foreach($gaji_lembur as $sl_lembur){
			if($system[0]->is_half_monthly==1){
				if($system[0]->potong_setengah_bulan==2){
					$ejam_lembur = $sl_lembur->jam_lembur/2;
					$enilai_lembur = $sl_lembur->nilai_lembur/2;
				} else {
					$ejam_lembur = $sl_lembur->jam_lembur;
					$enilai_lembur = $sl_lembur->nilai_lembur;
				}
			} else {
				$ejam_lembur = $sl_lembur->jam_lembur;
				$enilai_lembur = $sl_lembur->nilai_lembur;
			}
			$jumlah_lembur += $ejam_lembur * $enilai_lembur;
		//$total_lembur = $sl_lembur->jam_lembur * $sl_lembur->nilai_lembur;
		//$jumlah_lembur += $total_lembur;
		}
	} else {
		$jumlah_lembur = 0;
	}

// saudi gosi
	if($system[0]->enable_asuransi != 0){
		$jml_asuransi = $gaji_pokok + $jumlah_tunjanagan;
		$enable_asuransi = $jml_asuransi / 100 * $system[0]->enable_asuransi;
		$asuransi = $enable_asuransi;
	} else {
		$asuransi = 0;
	}
// add amount
	$add_gaji = $jumlah_tunjanagan + $gaji_pokok + $jumlah_lembur + $all_pembayaran_lainnya + $jumlah_komissi + $asuransi;
// add amount
	$gaji_bersih_default = $add_gaji - $jumlah_ptng_pinjaman - $jumlah_statutory_potongans;
	$sta_gaji = $jumlah_tunjanagan + $gaji_pokok;

	$estatutory_potongans = $jumlah_statutory_potongans;
// net gaji + statutory potongans
	$gaji_bersih = $gaji_bersih_default;
	$gaji_bersih = number_format((float)$gaji_bersih, 2, '.', '');
// check
	$half_title = '1';
	if($system[0]->is_half_monthly==1){
		$check_pembayaran = $this->Payroll_model->read_melakukan_pembayaran_slipgaji_half_month_check($user_id,$this->input->get('pay_date'));
		if($check_pembayaran->num_rows() > 1) {
			$half_title = '';
		} else if($check_pembayaran->num_rows() > 0){
			$half_title = '('.$this->lang->line('umb_title_second_half').')';
		} else {
			$half_title = '('.$this->lang->line('umb_title_first_half').')';
		}
		$half_title = $half_title;
	} else {
		$half_title = '';
	}
// get advance gaji
	$advance_gaji = $this->Payroll_model->advance_gaji_melalui_karyawan_id($user_id);
	$krywn_value = $this->Payroll_model->get_bayar_gaji_melalui_karyawan_id($user_id);

	if(!is_null($advance_gaji)){
		$angsuran_bulanan = $advance_gaji[0]->angsuran_bulanan;
		$advance_jumlah = $advance_gaji[0]->advance_jumlah;
		$total_yang_dibayarkan = $advance_gaji[0]->total_yang_dibayarkan;
	//check ifpaid
		$em_advance_jumlah = $advance_gaji[0]->advance_jumlah;
		$em_total_yang_dibayarkan = $advance_gaji[0]->total_yang_dibayarkan;
		
		if($em_advance_jumlah > $em_total_yang_dibayarkan){
			if($angsuran_bulanan=='' || $angsuran_bulanan==0) {
				
				$ntotal_yang_dibayarkan = $krywn_value[0]->total_yang_dibayarkan;
				$nadvance = $krywn_value[0]->advance_jumlah;
				$total_gaji_bersih = $nadvance - $ntotal_yang_dibayarkan;
				$pay_jumlah = $gaji_bersih - $total_gaji_bersih;
				$advance_jumlah = $total_gaji_bersih;
			} else {
			//
				$re_jumlah = $em_advance_jumlah - $em_total_yang_dibayarkan;
				if($angsuran_bulanan > $re_jumlah){
					$advance_jumlah = $re_jumlah;
					$total_gaji_bersih = $gaji_bersih - $re_jumlah;
					$pay_jumlah = $gaji_bersih - $re_jumlah;
				} else {
					$advance_jumlah = $angsuran_bulanan;
					$total_gaji_bersih = $gaji_bersih - $angsuran_bulanan;
					$pay_jumlah = $gaji_bersih - $angsuran_bulanan;
				}
			}
			
		} else {
			$total_gaji_bersih = $gaji_bersih - 0;
			$pay_jumlah = $gaji_bersih - 0;
			$advance_jumlah = 0;
		}
	} else {
		$pay_jumlah = $gaji_bersih - 0;
		$total_gaji_bersih = $gaji_bersih - 0;	
		$advance_jumlah = 0;
	}
	$gaji_bersih = $gaji_bersih - $advance_jumlah;
	?>
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
		<h4 class="modal-title" id="edit-modal-data"><strong><?php echo $this->lang->line('umb_payment_for');?></strong> <?php echo $half_title;?> <?php echo $p_month;?></h4>
	</div>
	<div class="modal-body" style="overflow:auto; height:530px;">
		<?php $attributes = array('name' => 'pay_monthly', 'id' => 'pay_monthly', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
		<?php $hidden = array('_method' => 'ADD');?>
		<?php echo form_open('admin/payroll/add_pay_monthly/', $attributes, $hidden);?>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<input type="hidden" name="department_id" value="<?php echo $department_id;?>" />
					<input type="hidden" name="penunjukan_id" value="<?php echo $penunjukan_id;?>" />
					<input type="hidden" name="perusahaan_id" value="<?php echo $perusahaan_id;?>" />
					<input type="hidden" name="location_id" value="<?php echo $location_id;?>" />
					<label for="name"><?php echo $this->lang->line('umb_payroll_gaji_pokok');?></label>
					<input type="text" name="gross_gaji" class="form-control" value="<?php echo $gaji_pokok;?>">
					<input type="hidden" id="krywn_id" value="<?php echo $user_id?>" name="krywn_id">
					<input type="hidden" value="<?php echo $user_id;?>" name="u_id">
					<input type="hidden" value="<?php echo $gaji_pokok;?>" name="gaji_pokok">
					<input type="hidden" value="<?php echo $type_upahh;?>" name="type_upahh">
					<input type="hidden" value="<?php echo $this->input->get('pay_date');?>" name="pay_date" id="pay_date">
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label for="name"><?php echo $this->lang->line('umb_payroll_total_tunjanagan');?></label>
					<input type="text" name="total_tunjanagans" class="form-control" value="<?php echo $jumlah_tunjanagan;?>" readonly="readonly">
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label for="name"><?php echo $this->lang->line('umb_hr_komissi');?></label>
					<input type="text" name="total_komissi" class="form-control" value="<?php echo $jumlah_komissi;?>" readonly="readonly">
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label for="name"><?php echo $this->lang->line('umb_payroll_total_pinjaman');?></label>
					<input type="text" name="total_pinjaman" class="form-control" value="<?php echo $jumlah_ptng_pinjaman;?>" readonly="readonly">
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label for="name"><?php echo $this->lang->line('umb_payroll_total_lembur');?></label>
					<input type="text" name="total_lembur" class="form-control" value="<?php echo $jumlah_lembur;?>" readonly="readonly">
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label for="name"><?php echo $this->lang->line('umb_karyawan_set_statutory_potongans');?></label>
					<input type="text" name="total_statutory_potongans" class="form-control" value="<?php echo $estatutory_potongans;?>" readonly="readonly">
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label for="name"><?php echo $this->lang->line('umb_karyawan_set_pembayaran_lainnya');?></label>
					<input type="text" name="total_pembayarans_lainnya" class="form-control" value="<?php echo $all_pembayaran_lainnya;?>" readonly="readonly">
				</div>
			</div>
		</div>
		<div class="row">
			<?php if($system[0]->enable_asuransi != 0){ ?>
				<div class="col-md-4">
					<div class="form-group">
						<label for="name"><?php echo $this->lang->line('umb_title_asuransi');?></label>
						<input type="text" readonly="readonly" name="jumlah_asuransi" class="form-control" value="<?php echo $asuransi;?>">
						<input type="hidden" readonly="readonly" name="asuransi_percent" value="<?php echo $system[0]->enable_asuransi;?>">
					</div>
				</div>
			<?php } else {?>
				<input type="hidden" name="jumlah_asuransi" value="0" />
				<input type="hidden" name="asuransi_percent" value="0" />
			<?php } ?>
			<?php if($advance_jumlah!=0):?>
				<div class="col-md-4">
					<div class="form-group">
						<label for="name"><?php echo $this->lang->line('umb_potongan_advance_gaji');?></label>
						<input type="text" class="form-control" name="advance_jumlah" value="<?php echo $advance_jumlah;?>" readonly>
					</div>
				</div>
				<?php else:?>  
					<input type="hidden" name="advance_jumlah" value="0" />
				<?php endif;?>
				<div class="col-md-4">
					<div class="form-group">
						<label for="name"><?php echo $this->lang->line('umb_payroll_gaji_bersih');?></label>
						<input type="text" readonly="readonly" name="gaji_bersih" class="form-control" value="<?php echo $gaji_bersih;?>">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label for="name"><?php echo $this->lang->line('umb_payroll_jumlah_pembayaran');?></label>
						<input type="text" readonly="readonly" name="jumlah_pembayaran" class="form-control" value="<?php echo $gaji_bersih;?>">
					</div>
				</div>
			</div>   
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<span><strong>NOTE:</strong> <?php echo $this->lang->line('umb_payroll_total_tunjanagan');?>,<?php echo $this->lang->line('umb_hr_komissi');?>,<?php echo $this->lang->line('umb_payroll_total_pinjaman');?>,<?php echo $this->lang->line('umb_payroll_total_lembur');?>,<?php echo $this->lang->line('umb_karyawan_set_statutory_potongans');?>,<?php echo $this->lang->line('umb_karyawan_set_pembayaran_lainnya');?> are not editable.</span>
					</div>
				</div>
			</div> 
			<div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrastral_form', 'type' => 'submit', 'class' => $this->Umb_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('umb_pay'))); ?> </div>
			<?php echo form_close(); ?>
		</div>
	</div>
	<script type="text/javascript">
		$(document).ready(function(){
			$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
			$('[data-plugin="select_hrm"]').select2({ width:'100%' });
			
	// On page load: datatable					
	$("#pay_monthly").submit(function(e){
		
		
		e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		//$('.save').prop('disabled', true);
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=11&data=monthly&add_type=add_monthly_payment&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
				} else {
					$('.emo_monthly_pay').modal('toggle');
					var umb_table = $('#umb_table').dataTable({
						"bDestroy": true,
						"ajax": {
							url : "<?php echo site_url("admin/payroll/list_slipgaji") ?>?karyawan_id=0&perusahaan_id=<?php echo $perusahaan_id;?>&month_year=<?php echo $this->input->get('pay_date');?>",
							type : 'GET'
						},
						"fnDrawCallback": function(settings){
							$('[data-toggle="tooltip"]').tooltip();          
						}
					});
					umb_table.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
				}
			}
		});
	});
});	
</script>
<?php } else if(isset($_GET['jd']) && isset($_GET['karyawan_id']) && $_GET['data']=='hourly_payment' && $_GET['type']=='fhourly_payment'){ ?>
	<?php
	$system = $this->Umb_model->read_setting_info(1);
	$payment_month = strtotime($this->input->get('pay_date'));
	$p_month = date('F Y',$payment_month);
	$gaji_pokok = $gaji_pokok;
	?>
	<?php
	$gaji_tunjanagans = $this->Karyawans_model->read_gaji_tunjanagans($user_id);
	$count_tunjanagans = $this->Karyawans_model->count_karyawan_tunjanagans($user_id);
	$jumlah_tunjanagan = 0;
	if($count_tunjanagans > 0) {
		foreach($gaji_tunjanagans as $sl_tunjanagans){
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
		  //$jumlah_tunjanagan += $sl_tunjanagans->jumlah_tunjanagan;
		}
	} else {
		$jumlah_tunjanagan = 0;
	}
// 3: all loan/potongans
	$gaji_pinjaman_potongan = $this->Karyawans_model->read_gaji_pinjaman_potongans($user_id);
	$count_pinjaman_potongan = $this->Karyawans_model->count_karyawan_potongans($user_id);
	$jumlah_ptng_pinjaman = 0;
	if($count_pinjaman_potongan > 0) {
		foreach($gaji_pinjaman_potongan as $sl_gaji_pinjaman_potongan){
			$jumlah_ptng_pinjaman += $sl_gaji_pinjaman_potongan->pinjaman_jumlah_potongan;
		}
	} else {
		$jumlah_ptng_pinjaman = 0;
	}
// 4: other payment
	$pembayarans_lainnya = $this->Karyawans_model->set_karyawan_pembayarans_lainnya($user_id);
	$jumlah_pembayarans_lainnya = 0;
	if(!is_null($pembayarans_lainnya)):
		foreach($pembayarans_lainnya->result() as $sl_pembayarans_lainnya) {
		//$jumlah_pembayarans_lainnya += $sl_pembayarans_lainnya->jumlah_pembayarans;
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
	endif;
// all other payment
	$all_pembayaran_lainnya = $jumlah_pembayarans_lainnya;
// 5: komissi
	$komissi = $this->Karyawans_model->set_komissi_karyawan($user_id);
	if(!is_null($komissi)):
		$jumlah_komissi = 0;
		foreach($komissi->result() as $sl_komissi) {
		//$jumlah_komissi += $sl_komissi->jumlah_komisi;
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
	endif;
// 6: statutory potongans
	$statutory_potongans = $this->Karyawans_model->set_karyawan_statutory_potongans($user_id);
	if(!is_null($statutory_potongans)):
		$jumlah_statutory_potongans = 0;
		foreach($statutory_potongans->result() as $sl_statutory_potongans) {
		/*if($system[0]->statutory_fixed!='yes'):
			$sta_gaji = $gaji_pokok;
			$st_jumlah = $sta_gaji / 100 * $sl_statutory_potongans->jumlah_potongan;
			$jumlah_statutory_potongans += $st_jumlah;
		else:
			$jumlah_statutory_potongans += $sl_statutory_potongans->jumlah_potongan;
		endif;*/
		if($sl_statutory_potongans->statutory_options == 0) {
			$single_sd = $sl_statutory_potongans->jumlah_potongan;
		} else {
			$single_sd = $gaji_pokok / 100 * $sl_statutory_potongans->jumlah_potongan;
		}
		$jumlah_statutory_potongans += $single_sd; 
	}
endif;

// 7: lembur
$gaji_lembur = $this->Karyawans_model->read_gaji_lembur($user_id);
$count_lembur = $this->Karyawans_model->count_karyawan_lembur($user_id);
$jumlah_lembur = 0;
if($count_lembur > 0) {
	foreach($gaji_lembur as $sl_lembur){
		$total_lembur = $sl_lembur->jam_lembur * $sl_lembur->nilai_lembur;
		$jumlah_lembur += $total_lembur;
	}
} else {
	$jumlah_lembur = 0;
}

//lembur request
$lembur_count = $this->Permintaan_lembur_model->get_count_permintaan_lembur($euser_id,$this->input->get('pay_date'));
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
// saudi gosi
if($system[0]->enable_asuransi != 0){
	$jml_asuransi = $gaji_pokok + $jumlah_tunjanagan;
	$enable_asuransi = $jml_asuransi / 100 * $system[0]->enable_asuransi;
	$asuransi = $enable_asuransi;
} else {
	$asuransi = 0;
}
// add amount
$add_gaji = $jumlah_tunjanagan + $jumlah_lembur + $all_pembayaran_lainnya + $jumlah_komissi + $asuransi;
// add amount
$gaji_bersih_default = $add_gaji - $jumlah_ptng_pinjaman - $jumlah_statutory_potongans;
$sta_gaji = $jumlah_tunjanagan + $gaji_pokok;

$estatutory_potongans = $jumlah_statutory_potongans;
// net gaji + statutory potongans
$pay_date = $_GET['pay_date'];
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
if($pcount > 0){
	$total_count = $pcount * $gaji_pokok;
	$fgaji = $total_count + $gaji_bersih_default;
} else {
	$fgaji = $pcount;
}
$gaji_bersih = $fgaji;
$gaji_bersih = number_format((float)$gaji_bersih, 2, '.', '');
?>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
	<h4 class="modal-title" id="edit-modal-data"><strong><?php echo $this->lang->line('umb_payment_for');?></strong> <?php echo $p_month;?></h4>
</div>
<div class="modal-body" style="overflow:auto; height:530px;">
	<?php $attributes = array('name' => 'pay_hourly', 'id' => 'pay_hourly', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
	<?php $hidden = array('_method' => 'ADD');?>
	<?php echo form_open('admin/payroll/add_pay_hourly/', $attributes, $hidden);?>
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<input type="hidden" name="department_id" value="<?php echo $department_id;?>" />
				<input type="hidden" name="penunjukan_id" value="<?php echo $penunjukan_id;?>" />
				<input type="hidden" name="perusahaan_id" value="<?php echo $perusahaan_id;?>" />
				<input type="hidden" name="location_id" value="<?php echo $location_id;?>" />
				<label for="name"><?php echo $this->lang->line('umb_payroll_nilai_perjam');?></label>
				<input type="text" name="gross_gaji" class="form-control" value="<?php echo $gaji_pokok;?>">
				<input type="hidden" id="krywn_id" value="<?php echo $user_id?>" name="krywn_id">
				<input type="hidden" value="<?php echo $user_id;?>" name="u_id">
				<input type="hidden" value="<?php echo $gaji_pokok;?>" name="gaji_pokok">
				<input type="hidden" value="<?php echo $type_upahh;?>" name="type_upahh">
				<input type="hidden" value="<?php echo $this->input->get('pay_date');?>" name="pay_date" id="pay_date">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="name"><?php echo $this->lang->line('umb_payroll_total_jam_bekerja');?></label>
				<input type="text" readonly="readonly" name="jam_bekerja" class="form-control" value="<?php echo $pcount;?>">
			</div>
		</div>
	</div>
	<?php
	
	?>
	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
				<label for="name"><?php echo $this->lang->line('umb_payroll_total_tunjanagan');?></label>
				<input type="text" name="total_tunjanagans" class="form-control" value="<?php echo $jumlah_tunjanagan;?>" readonly="readonly">
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label for="name"><?php echo $this->lang->line('umb_hr_komissi');?></label>
				<input type="text" name="total_komissi" class="form-control" value="<?php echo $jumlah_komissi;?>" readonly="readonly">
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label for="name"><?php echo $this->lang->line('umb_payroll_total_pinjaman');?></label>
				<input type="text" name="total_pinjaman" class="form-control" value="<?php echo $jumlah_ptng_pinjaman;?>" readonly="readonly">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
				<label for="name"><?php echo $this->lang->line('umb_payroll_total_lembur');?></label>
				<input type="text" name="total_lembur" class="form-control" value="<?php echo $jumlah_lembur;?>" readonly="readonly">
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label for="name"><?php echo $this->lang->line('umb_karyawan_set_statutory_potongans');?></label>
				<input type="text" name="total_statutory_potongans" class="form-control" value="<?php echo $estatutory_potongans;?>" readonly="readonly">
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label for="name"><?php echo $this->lang->line('umb_karyawan_set_pembayaran_lainnya');?></label>
				<input type="text" name="total_pembayarans_lainnya" class="form-control" value="<?php echo $all_pembayaran_lainnya;?>" readonly="readonly">
			</div>
		</div>
	</div>
	<div class="row">
		<?php if($system[0]->enable_asuransi != 0){ ?>
			<div class="col-md-4">
				<div class="form-group">
					<label for="name"><?php echo $this->lang->line('umb_title_asuransi');?></label>
					<input type="text" readonly="readonly" name="jumlah_asuransi" class="form-control" value="<?php echo $asuransi;?>">
					<input type="hidden" readonly="readonly" name="asuransi_percent" value="<?php echo $system[0]->enable_asuransi;?>">
				</div>
			</div>
		<?php } else {?>
			<input type="hidden" name="jumlah_asuransi" value="0" />
			<input type="hidden" name="asuransi_percent" value="0" />
		<?php } ?>
		<div class="col-md-6">
			<div class="form-group">
				<label for="name"><?php echo $this->lang->line('umb_payroll_gaji_bersih');?></label>
				<input type="text" readonly="readonly" name="gaji_bersih" class="form-control" value="<?php echo $gaji_bersih;?>">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="name"><?php echo $this->lang->line('umb_payroll_jumlah_pembayaran');?></label>
				<input type="text" readonly="readonly" name="jumlah_pembayaran" class="form-control" value="<?php echo $gaji_bersih;?>">
			</div>
		</div>
	</div>   
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<span><strong>NOTE:</strong> <?php echo $this->lang->line('umb_payroll_total_tunjanagan');?>,<?php echo $this->lang->line('umb_hr_komissi');?>,<?php echo $this->lang->line('umb_payroll_total_pinjaman');?>,<?php echo $this->lang->line('umb_payroll_total_lembur');?>,<?php echo $this->lang->line('umb_karyawan_set_statutory_potongans');?>,<?php echo $this->lang->line('umb_karyawan_set_pembayaran_lainnya');?> are not editable.</span>
			</div>
		</div>
	</div> 
	<div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrastral_form', 'type' => 'submit', 'class' => $this->Umb_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('umb_pay'))); ?> </div>
	<?php echo form_close(); ?>
</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
		$('[data-plugin="select_hrm"]').select2({ width:'100%' });
		
	// On page load: datatable					
	$("#pay_hourly").submit(function(e){
		
		
		e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		//$('.save').prop('disabled', true);
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=11&data=hourly&add_type=add_pay_hourly&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
				} else {
					$('.emo_hourly_pay').modal('toggle');
					var umb_table = $('#umb_table').dataTable({
						"bDestroy": true,
						"ajax": {
							url : "<?php echo site_url("admin/payroll/list_slipgaji") ?>?karyawan_id=0&perusahaan_id=<?php echo $perusahaan_id;?>&month_year=<?php echo $this->input->get('pay_date');?>",
							type : 'GET'
						},
						"fnDrawCallback": function(settings){
							$('[data-toggle="tooltip"]').tooltip();          
						}
					});
					umb_table.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
				}
			}
		});
	});
});	
</script>
<?php }?>
