<?php
/* slipgaji view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $system = $this->Umb_model->read_setting_info(1);?>
<?php
$user_info = $this->Umb_model->read_user_info($session['user_id']);
$role_resources_ids = $this->Umb_model->user_role_resource();

if($user_info[0]->user_role_id==1 || in_array('404',$role_resources_ids) || in_array('405',$role_resources_ids)){
	$cmdp_1st = 'col-md-9';
	$cmdp_2nd = 'col-md-3';
} else {
	$cmdp_1st = 'col-md-12';
	$cmdp_2nd = '';
}
?>
<div class="row">
  <div class="<?php echo $cmdp_1st;?>">
    <div class="card mb-4">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_slipgaji');?> - </strong> <?php echo date("F, Y", strtotime($payment_date));?></span>
      <div class="card-header-elements ml-md-auto"> <a class="text-dark" href="<?php echo site_url();?>admin/payroll/pdf_create/p/<?php echo $slipgaji_key;?>/" data-toggle="tooltip" data-placement="top" data-state="primary" title="" data-original-title="<?php echo $this->lang->line('umb_payroll_download_slipgaji');?>">
        <i class="oi oi-cloud-download text-primary"></i>
        </a> </div>
    </div>
      <div class="card-body">
        <div class="table-responsive" data-pattern="priority-columns">
          <table class="datatables-demo table table-striped table-bordered dataTable no-footer">
            <tbody>
              <tr>
                <td><strong class="help-split"><?php echo $this->lang->line('dashboard_karyawan_id');?>: </strong>#<?php echo $karyawan_id;?></td>
                <td><strong class="help-split"><?php echo $this->lang->line('umb_nama_karyawan');?>: </strong><?php echo $first_name.' '.$last_name;?></td>
                <td><strong class="help-split"><?php echo $this->lang->line('umb_slipgaji_number');?>: </strong><?php echo $melakukan_pembayaran_id;?></td>
              </tr>
              <tr>
                <td><strong class="help-split"><?php echo $this->lang->line('umb_phone');?>: </strong><?php echo $no_kontak;?></td>
                <td><strong class="help-split"><?php echo $this->lang->line('umb_joining_date');?>: </strong><?php echo $this->Umb_model->set_date_format($tanggal_bergabung);?></td>
              </tr>
              <tr>
                <td><strong class="help-split"><?php echo $this->lang->line('left_department');?>: </strong><?php echo $nama_department;?></td>
                <td><strong class="help-split"><?php echo $this->lang->line('left_penunjukan');?>: </strong><?php echo $nama_penunjukan;?></td>
                <td><strong class="help-split">&nbsp;</strong></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <?php if($user_info[0]->user_role_id==1 || in_array('404',$role_resources_ids) || in_array('405',$role_resources_ids)){?>
  <div class="<?php echo $cmdp_2nd;?>">
    <div class="card">
      <div class="card-body">
        <div class="form-group">
        
          <?php $attributes2 = array('name' => 'update_status', 'id' => 'update_status', 'autocomplete' => 'off');?>
          <?php $hidden2 = array('user_id' => $session['user_id']);?>
          <?php echo form_open('admin/payroll/update_status_payroll', $attributes2, $hidden2);?>
          <?php
			$data2 = array(
			  'name'        => 'payroll_id',
			  'id'          => 'payroll_id',
			  'type'        => 'hidden',
			  'value'   	   => $this->uri->segment(5),
			  'class'       => 'form-control',
			);
		
			echo form_input($data2);
			?>
            
          <label for="status"><?php echo $this->lang->line('dashboard_umb_status');?></label>
          <?php if($user_info[0]->user_role_id==1){?>
          <select class="form-control" name="status" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('dashboard_umb_status');?>">
            
            <option value=""><?php echo $this->lang->line('dashboard_umb_status');?></option>
            <option value="0" <?php if($approval_status=='0'):?> selected <?php endif; ?>><?php echo $this->lang->line('umb_not_approve_payroll_title');?></option>
            <option value="1" <?php if($approval_status=='1'):?> selected <?php endif; ?>><?php echo $this->lang->line('umb_role_first_level_approval');?></option>
            <option value="2" <?php if($approval_status=='2'):?> selected <?php endif; ?>> <?php echo $this->lang->line('umb_second_level_payroll_approver_title');?></option>
            
          </select>
          <?php } else if(in_array('404',$role_resources_ids)){?>
          
          <select class="form-control" name="status" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('dashboard_umb_status');?>">
            <option value=""><?php echo $this->lang->line('dashboard_umb_status');?></option>
            <option value="1" <?php if($approval_status=='1'):?> selected <?php endif; ?>><?php echo $this->lang->line('umb_role_first_level_approval');?></option>
            </select>
            <?php } else if(in_array('405',$role_resources_ids)){?>
            
            <select class="form-control" name="status" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('dashboard_umb_status');?>">
            <option value=""><?php echo $this->lang->line('dashboard_umb_status');?></option>
            <option value="2" <?php if($approval_status=='2'):?> selected <?php endif; ?>> <?php echo $this->lang->line('umb_second_level_payroll_approver_title');?></option>
            </select>
            <?php } ?>
        </div>
        <div class="form-actions box-footer">
          <button type="submit" class="btn btn-primary"> <i class="fas fa-check-square"></i> <?php echo $this->lang->line('umb_save');?> </button>
        </div>
        <?php echo form_close(); ?> 
        </div>
    </div>
  </div>
  <?php }
        ?>
</div>
<?php $user_id = $karyawan_id;?>
<?php $pcount = $jam_bekerja;?>
<div class="row m-b-1">
  <div class="col-md-6">
    <div class="card">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_payment_details');?></strong></span> </div>
      <div class="card-body">
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
                      <tr>
                        <td><strong><?php echo $this->lang->line('umb_payroll_total_jam_bekerja');?>:</strong> <span class="pull-right"><?php echo $pcount;?></span></td>
                      </tr>
                      <?php $etotal_count = $pcount * $gaji_pokok;?>
                      <tr>
                        <td><strong><?php echo $this->lang->line('umb_acc_total');?>:</strong> <span class="pull-right"><?php echo $this->Umb_model->currency_sign($etotal_count);?></span></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <?php $count_tunjanagans = $this->Karyawans_model->count_karyawan_tunjanagans_slipgaji($melakukan_pembayaran_id);?>
          <?php $tunjanagans = $this->Karyawans_model->set_tunjanagans_karyawan_slipgaji($melakukan_pembayaran_id);?>
          <?php if($count_tunjanagans > 0):?>
          <div class="card hrastral-slipgaji">
            <div class="card-header"> <a class="text-dark collapsed" data-toggle="collapse" href="#set_tunjanagans" aria-expanded="false"> <strong><?php echo $this->lang->line('umb_karyawan_set_tunjanagans');?></strong> </a> </div>
            <div id="set_tunjanagans" class="collapse" data-parent="#accordion" style="">
              <div class="box-body ml-3 mr-3">
                <div class="table-responsive" data-pattern="priority-columns">
                  <table class="datatables-demo table table-striped table-bordered dataTable no-footer">
                    <tbody>
                      <?php $jumlah_tunjanagan = 0; foreach($tunjanagans->result() as $sl_tunjanagans) { ?>
					  <?php
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
					  ?>
                      <tr>
                        <td><strong><?php echo $sl_tunjanagans->title_tunjanagan;?> (<?php echo $jumlah_tunjanagan_opt;?>) (<?php echo $tunjanagan_opt;?>):</strong> <span class="pull-right"><?php echo $this->Umb_model->currency_sign($sl_tunjanagans->jumlah_tunjanagan);?></span></td>
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
          <?php $count_komissi = $this->Karyawans_model->count_karyawan_komissi_slipgaji($melakukan_pembayaran_id);?>
          <?php $komissi = $this->Karyawans_model->set_komissi_karyawan_slipgaji($melakukan_pembayaran_id);?>
          <?php if($count_komissi > 0):?>
          <div class="card hrastral-slipgaji">
            <div class="card-header"> <a class="text-dark collapsed" data-toggle="collapse" href="#set_komissi" aria-expanded="false"> <strong><?php echo $this->lang->line('umb_hr_komissi');?></strong> </a> </div>
            <div id="set_komissi" class="collapse" data-parent="#accordion" style="">
              <div class="box-body ml-3 mr-3">
                <div class="table-responsive" data-pattern="priority-columns">
                  <table class="datatables-demo table table-striped table-bordered dataTable no-footer">
                    <tbody>
                      <?php $jumlah_komissi = 0; foreach($komissi->result() as $sl_komissi) { ?>
					  <?php
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
                      <tr>
                        <td><strong><?php echo $sl_komissi->komisi_title;?> (<?php echo $opt_jumlah_komisi;?>) (<?php echo $opt_komisi;?>):</strong> <span class="pull-right"><?php echo $this->Umb_model->currency_sign($sl_komissi->jumlah_komisi);?></span></td>
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
          <?php else:?>
          <?php $jumlah_komissi = 0;?>
          <?php endif;?>
          <?php $count_pinjaman = $this->Karyawans_model->count_karyawan_potongans_slipgaji($melakukan_pembayaran_id);?>
          <?php $loan = $this->Karyawans_model->set_potongans_karyawan_slipgaji($melakukan_pembayaran_id);?>
          <?php if($count_pinjaman > 0):?>
          <div class="card hrastral-slipgaji">
            <div class="card-header"> <a class="text-dark collapsed" data-toggle="collapse" href="#set_pinjaman_potongans" aria-expanded="false"> <strong><?php echo $this->lang->line('umb_karyawan_set_pinjaman_potongans');?></strong> </a> </div>
            <div id="set_pinjaman_potongans" class="collapse" data-parent="#accordion" style="">
              <div class="box-body ml-3 mr-3">
                <div class="table-responsive" data-pattern="priority-columns">
                  <table class="datatables-demo table table-striped table-bordered dataTable no-footer">
                    <tbody>
                      <?php $jumlah_ptng_pinjaman = 0; foreach($loan->result() as $r_pinjaman) { ?>
					  <?php $jumlah_ptng_pinjaman += $r_pinjaman->pinjaman_jumlah;?>
                      <tr>
                        <td><strong><?php echo $r_pinjaman->pinjaman_title;?>:</strong> <span class="pull-right"><?php echo $this->Umb_model->currency_sign($r_pinjaman->pinjaman_jumlah);?></span></td>
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
          <?php else:?>
          <?php $jumlah_ptng_pinjaman = 0;?>
          <?php endif;?>
          <?php $count_statutory_potongans = $this->Karyawans_model->count_karyawan_statutory_potongans_slipgaji($melakukan_pembayaran_id);?>
          <?php $statutory_potongans = $this->Karyawans_model->set_karyawan_statutory_potongans_slipgaji($melakukan_pembayaran_id);?>
          <?php if($count_statutory_potongans > 0):?>
          <div class="card hrastral-slipgaji">
            <div class="card-header"> <a class="text-dark collapsed" data-toggle="collapse" href="#set_statutory_potongans" aria-expanded="false"> <strong><?php echo $this->lang->line('umb_karyawan_set_statutory_potongans');?></strong> </a> </div>
            <div id="set_statutory_potongans" class="collapse" data-parent="#accordion" style="">
              <div class="box-body ml-3 mr-3">
                <div class="table-responsive" data-pattern="priority-columns">
                  <table class="datatables-demo table table-striped table-bordered dataTable no-footer">
                    <tbody>
						<?php $jumlah_statutory_potongans = 0; foreach($statutory_potongans->result() as $sl_statutory_potongans) { ?>
                        <?php
					   	  if($sl_statutory_potongans->statutory_options == 0) {
							  $single_sd = $sl_statutory_potongans->jumlah_potongan;
						  } else {
							  $single_sd = $gaji_pokok / 100 * $sl_statutory_potongans->jumlah_potongan;
						  }
						  $jumlah_statutory_potongans += $single_sd;
						  
                        if($sl_statutory_potongans->statutory_options==0){
							$opt_jumlah_sd = $this->lang->line('umb_title_fixed_pajak');
						} else {
							$opt_jumlah_sd = $this->lang->line('umb_title_percent_pajak');
						}
                        ?>                     
                      <tr>
                        <td><strong><?php echo $sl_statutory_potongans->title_potongan;?> (<?php echo $opt_jumlah_sd;?>):</strong> <span class="pull-right"><?php echo $this->Umb_model->currency_sign($single_sd);?></span></td>
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
          <?php else:?>
          <?php $jumlah_statutory_potongans = 0;?>
          <?php endif;?>
          <?php $count_pembayarans_lainnya = $this->Karyawans_model->count_karyawan_pembayarans_lainnya_slipgaji($melakukan_pembayaran_id);?>
          <?php $pembayarans_lainnya = $this->Karyawans_model->set_karyawan_pembayarans_lainnya_slipgaji($melakukan_pembayaran_id);?>
          <?php if($count_pembayarans_lainnya > 0):?>
          <div class="card hrastral-slipgaji">
            <div class="card-header"> <a class="text-dark collapsed" data-toggle="collapse" href="#set_pembayarans_lainnya" aria-expanded="false"> <strong><?php echo $this->lang->line('umb_karyawan_set_pembayaran_lainnya');?></strong> </a> </div>
            <div id="set_pembayarans_lainnya" class="collapse" data-parent="#accordion" style="">
              <div class="box-body ml-3 mr-3">
                <div class="table-responsive" data-pattern="priority-columns">
                  <table class="datatables-demo table table-striped table-bordered dataTable no-footer">
                    <tbody>
                      <?php $jumlah_pembayarans_lainnya = 0; foreach($pembayarans_lainnya->result() as $sl_pembayarans_lainnya) { ?>
					  <?php
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
                        <td><strong><?php echo $sl_pembayarans_lainnya->title_pembayarans;?> (<?php echo $opt_jumlah_lainnya;?>) (<?php echo $other_opt;?>):</strong> <span class="pull-right"><?php echo $this->Umb_model->currency_sign($sl_pembayarans_lainnya->jumlah_pembayarans);?></span></td>
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
          <?php else:?>
          <?php $jumlah_pembayarans_lainnya = 0;?>
          <?php endif;?>
          <?php $count_lembur = $this->Karyawans_model->count_karyawan_lembur_slipgaji($melakukan_pembayaran_id);?>
          <?php $lembur = $this->Karyawans_model->set_karyawan_lembur_slipgaji($melakukan_pembayaran_id);?>
          <?php if($count_lembur > 0):?>
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
						$total_lembur = $r_lembur->jam_lembur * $r_lembur->nilai_lembur;
						$jumlah_lembur += $total_lembur;
						?>
                      <tr>
                        <th scope="row"><?php echo $i;?></th>
                        <td><?php echo $r_lembur->title_lembur;?></td>
                        <td><?php echo $r_lembur->lembur_no_of_days;?></td>
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
          <?php else:?>
          <?php $jumlah_lembur = 0;?>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_slipgaji_earning');?></strong></span> </div>
          <div class="card-body">
            <div class="table-responsive" data-pattern="priority-columns">
              <table class="datatables-demo table table-striped table-bordered dataTable no-footer">
                <tbody>
                  <tr>
                    <td><strong><?php echo $this->lang->line('umb_karyawan_upahh_harian');?>:</strong> <span class="pull-right"><?php echo $this->Umb_model->currency_sign($etotal_count);?></span></td>
                  </tr>
                  <?php if($total_tunjanagans!=0 || $total_tunjanagans!=''):?>
                  <tr>
                    <td><strong><?php echo $this->lang->line('umb_payroll_total_tunjanagan');?>:</strong> <span class="pull-right"><?php echo $this->Umb_model->currency_sign($total_tunjanagans);?></span></td>
                  </tr>
                  <?php endif;?>
                  <?php if($jumlah_komissi!=0 || $jumlah_komissi!=''):?>
                  <tr>
                    <td><strong><?php echo $this->lang->line('umb_hr_komissi');?>:</strong> <span class="pull-right"><?php echo $this->Umb_model->currency_sign($jumlah_komissi);?></span></td>
                  </tr>
                  <?php endif;?>
                  <?php if($total_pinjaman!=0 || $total_pinjaman!=''):?>
                  <tr>
                    <td><strong><?php echo $this->lang->line('umb_payroll_total_pinjaman');?>:</strong> <span class="pull-right"><?php echo $this->Umb_model->currency_sign(number_format($total_pinjaman, 2, '.', ','));?></span></td>
                  </tr>
                  <?php endif;?>
                  <?php if($total_lembur!=0 || $total_lembur!=''):?>
                  <tr>
                    <td><strong><?php echo $this->lang->line('umb_payroll_total_lembur');?>:</strong> <span class="pull-right"><?php echo $this->Umb_model->currency_sign($total_lembur);?></span></td>
                  </tr>
                  <?php endif;?>
                  <?php if($jumlah_statutory_potongans!=0 || $jumlah_statutory_potongans!=''):?>
                  <tr>
                    <td><strong><?php echo $this->lang->line('umb_karyawan_set_statutory_potongans');?>:</strong> <span class="pull-right"><?php echo $this->Umb_model->currency_sign($jumlah_statutory_potongans);?></span></td>
                  </tr>
                  <?php endif;?>
                  <?php if($jumlah_pembayarans_lainnya!=0 || $jumlah_pembayarans_lainnya!=''):?>
                  <tr>
                    <td><strong><?php echo $this->lang->line('umb_karyawan_set_pembayaran_lainnya');?>:</strong> <span class="pull-right"><?php echo $this->Umb_model->currency_sign($jumlah_pembayarans_lainnya);?></span></td>
                  </tr>
                  <?php endif;?>
                  <?php if($is_potong_advance_gaji==1):?>
                  <tr>
                    <td><strong><?php echo $this->lang->line('umb_potongan_advance_gaji');?>:</strong> <span class="pull-right"><?php echo $this->Umb_model->currency_sign($jumlah_advance_gaji);?></span></td>
                  </tr>
                  <?php $advance_gaji_tkn = $jumlah_advance_gaji;?>
                  <?php else: ?>
                  <?php $advance_gaji_tkn = 0;?>
                  <?php endif;?>
                  <?php if($jumlah_asuransi != 0):?>
                  <?php $asuransi = $jumlah_asuransi;?>
                  <tr>
                    <td><strong><?php echo $this->lang->line('umb_title_asuransi').' '.$asuransi_percent.'%';?>:</strong> <span class="pull-right"><?php echo $this->Umb_model->currency_sign($jumlah_asuransi);?></span></td>
                  </tr>
                  <?php else: $asuransi = 0;?>
                  <?php endif;?>
                  <?php if($gaji_bersih!=0 || $gaji_bersih!=''):?>
                  <?php
					$total_earning = $total_tunjanagans + $jumlah_lembur + $jumlah_komissi + $jumlah_pembayarans_lainnya + $asuransi;
					$total_potongan = $jumlah_ptng_pinjaman + $jumlah_statutory_potongans;
					$total_gaji_bersih = $total_earning - $total_potongan;
					$total_gaji_bersih = $total_gaji_bersih - $advance_gaji_tkn;
					if($pcount > 0){
						$total_count = $pcount * $gaji_pokok;
						$fgaji = $total_count + $total_gaji_bersih;
					} else {
						$fgaji = $pcount;
					}
					$fgaji = $fgaji;
				  ?>
                  <tr>
                    <td><strong><?php echo $this->lang->line('umb_bayar_jumlah');?>:</strong> <span class="pull-right"> <?php echo $this->Umb_model->currency_sign($fgaji);?></span></td>
                  </tr>
                  <?php endif;?>
                  <?php /*?><?php if($payment_method):?>
                  <tr>
                    <td><strong><?php echo $this->lang->line('umb_payment_method');?>:</strong> <span class="pull-right"><?php echo $payment_method;?></span></td>
                  </tr>
                  <?php endif;?>
                  <?php if($gaji_bersih!=0 || $gaji_bersih!=''):?>
                  <tr>
                    <td><strong><?php echo $this->lang->line('umb_payment_comment');?>:</strong> <span class="pull-right"><?php echo $pay_comments;?></span></td>
                  </tr>
                  <?php endif;?><?php */?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>