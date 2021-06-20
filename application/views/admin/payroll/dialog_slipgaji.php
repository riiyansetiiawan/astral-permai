<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['krywn_id']) && $_GET['data']=='pay_payment' && $_GET['type']=='pay_payment'){ ?>
<?php
$grade_template = $this->Payroll_model->read_template_information($monthly_grade_id);
$hourly_template = $this->Payroll_model->read_informasi_upah_perjam($hourly_grade_id);
$payment_month = strtotime($payment_date);
$p_month = date('F Y',$payment_month);
if($payment_method==1){
  $p_method = 'Online';
} else if($payment_method==2){
  $p_method = 'PayPal';
} else if($payment_method==3) {
  $p_method = 'Payoneer';
} else if($payment_method==4){
  $p_method = 'Bank Transfer';
} else if($payment_method==5) {
  $p_method = 'Cheque';
} else {
  $p_method = 'Cash';
}
?>
<?php
if($profile_picture!='' && $profile_picture!='no file') {
	$u_file = base_url().'uploads/profile/'.$profile_picture;
} else {
	if($jenis_kelamin=='Pria') { 
		$u_file = base_url().'uploads/profile/default_male.jpg';
	} else {
		$u_file = base_url().'uploads/profile/default_female.jpg';
	}
} ?>

<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_gaji_details_of');?> <?php echo $p_month;?></h4>
</div>
<div class="modal-body">
  <div class="row row-md">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header text-uppercase"><b><?php echo $first_name.' '.$last_name;?></b></div>
        <div class="bg-white product-view">
          <div class="box-block">
            <div class="row">
              <div class="col-md-4 col-sm-5">
                <div class="pv-images mb-sm-0"> <img class="img-fluid" src="<?php echo $u_file;?>" alt=""> </div>
              </div>
              <div class="col-md-8 col-sm-7">
                <div class="pv-content">
                  <div class="table-responsive" data-pattern="priority-columns">
                    <table class="table-hover">
                      <tbody>
                        <tr>
                          <td><strong><?php echo $this->lang->line('umb_krywn_id');?></strong>:</td>
                          <td>&nbsp;&nbsp;&nbsp;</td>
                          <td><?php echo $karyawan_id;?></td>
                        </tr>
                        <tr>
                          <td><strong><?php echo $this->lang->line('left_department');?></strong>:</td>
                          <td>&nbsp;&nbsp;&nbsp;</td>
                          <td><?php echo $nama_department;?></td>
                        </tr>
                        <tr>
                          <td><strong><?php echo $this->lang->line('left_penunjukan');?></strong>:</td>
                          <td>&nbsp;&nbsp;&nbsp;</td>
                          <td><?php echo $nama_penunjukan;?></td>
                        </tr>
                        <tr>
                          <td><strong><?php echo $this->lang->line('umb_joining_date');?></strong>:</td>
                          <td>&nbsp;&nbsp;&nbsp;</td>
                          <td><?php echo $tanggal_bergabung;?></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row mb-1">
    <div class="col-sm-12 col-xs-12">
      <div class="card">
        <div class="card-header text-uppercase"><b><?php echo $this->lang->line('umb_payroll_gaji_details');?></b></div>
        <div class="card-block">
          <div class="row m-b-1">
            <div class="col-md-12">
              <div class="f">
                <label for="name" class="control-label" style="text-align:right;"><strong><?php echo $this->lang->line('umb_gaji_bulan');?>: </strong></label>
                <?php echo $p_month;?> </div>
            </div>
            <?php if($gross_gaji):?>
            <div class="col-md-12">
              <div class="f">
                <label for="name" class="control-label" style="text-align:right;"><strong><?php echo $this->lang->line('umb_payroll_gross_gaji');?>: </strong></label>
                <?php echo $this->Umb_model->currency_sign($gross_gaji);?> </div>
            </div>
            <?php endif;?>
            <?php if($nilai_lembur!=0 || $nilai_lembur!=''):?>
            <div class="col-md-12">
              <div class="f">
                <label for="name" class="control-label" style="text-align:right;"><strong><?php echo $this->lang->line('umb_lembur_per_hour');?>: </strong></label>
                <?php echo $this->Umb_model->currency_sign($nilai_lembur);?> </div>
            </div>
            <?php endif;?>
            <?php if($nilai_perjam):?>
            <div class="col-md-12">
              <div class="f">
                <label for="name" class="control-label" style="text-align:right;"><strong><?php echo $this->lang->line('umb_payroll_nilai_perjam');?>: </strong></label>
                <?php echo $this->Umb_model->currency_sign($nilai_perjam);?> </div>
            </div>
            <?php endif;?>
            <?php if($total_jam_kerja):?>
            <div class="col-md-12">
              <div class="f">
                <label for="name" class="control-label" style="text-align:right;"><strong><?php echo $this->lang->line('umb_total_jam_bekerja');?>: </strong></label>
                <?php echo $total_jam_kerja;?></div>
            </div>
            <?php endif;?>
            <?php if($is_payment==1):?>
            <div class="col-md-12">
              <div class="f">
                <label for="name" class="control-label" style="text-align:right;"><strong><?php echo $this->lang->line('dashboard_umb_status');?>: </strong></label>
                <span class="tag tag-success"><?php echo $this->lang->line('umb_payment_bayar');?></span></div>
            </div>
            <?php endif;?>
          </div>
        </div>
      </div>
    </div>
    <?php if($tunjangan_sewa_rumah!='' || $tunjangan_kesehatan!='' || $tunjangan_perjalanan!='' || $tunjangan_jabatan!=''): ?>
    <div class="col-sm-12 col-xs-12">
      <div class="card">
        <div class="card-header text-uppercase"><b> <?php echo $this->lang->line('umb_payroll_tunjanagans');?></b> </div>
        <div class="card-block">
          <blockquote class="card-blockquote">
            <div class="row m-b-1">
              <?php if($tunjangan_sewa_rumah!='' || $tunjangan_sewa_rumah!=0): ?>
              <div class="col-md-12">
                <div class="f">
                  <label for="name"><strong><?php echo $this->lang->line('umb_payroll_tunjangan_sewa_rumah');?>: </strong></label>
                  <?php echo $this->Umb_model->currency_sign($tunjangan_sewa_rumah);?> </div>
              </div>
              <?php endif;?>
              <?php if($tunjangan_kesehatan!='' || $tunjangan_kesehatan!=0): ?>
              <div class="col-md-12">
                <div class="f">
                  <label for="name"><strong><?php echo $this->lang->line('umb_payroll_tunjangan_kesehatan');?>: </strong></label>
                  <?php echo $this->Umb_model->currency_sign($tunjangan_kesehatan);?> </div>
              </div>
              <?php endif;?>
              <?php if($tunjangan_perjalanan!='' || $tunjangan_perjalanan!=0): ?>
              <div class="col-md-12">
                <div class="f">
                  <label for="name"><strong><?php echo $this->lang->line('umb_payroll_perjalanan_tunjanagan');?>: </strong></label>
                  <?php echo $this->Umb_model->currency_sign($tunjangan_perjalanan);?> </div>
              </div>
              <?php endif;?>
              <?php if($tunjangan_jabatan!='' || $tunjangan_jabatan!=0): ?>
              <div class="col-md-12">
                <div class="f">
                  <label for="name"><strong><?php echo $this->lang->line('umb_payroll_tunjangan_jabatan');?>: </strong></label>
                  <?php echo $this->Umb_model->currency_sign($tunjangan_jabatan);?> </div>
              </div>
              <?php endif;?>
            </div>
          </blockquote>
        </div>
      </div>
    </div>
    <?php endif;?>
    <?php if($dana_yang_diberikan!='' || $potongan_pajak!='' || $security_deposit!=''): ?>
    <div class="col-sm-12 col-xs-12">
      <div class="card">
        <div class="card-header text-uppercase"><b> <?php echo $this->lang->line('umb_potongans');?></b></div>
        <div class="card-block">
          <div class="row m-b-1">
            <?php if($dana_yang_diberikan!='' || $dana_yang_diberikan!=0): ?>
            <div class="col-md-12">
              <div class="f">
                <label for="name"><strong><?php echo $this->lang->line('umb_payroll_dana_yang_diberikan_de');?>: </strong></label>
                <?php echo $this->Umb_model->currency_sign($dana_yang_diberikan);?> </div>
            </div>
            <?php endif;?>
            <?php if($potongan_pajak!='' || $potongan_pajak!=0): ?>
            <div class="col-md-12">
              <div class="f">
                <label for="name"><strong><?php echo $this->lang->line('umb_payroll_potongan_pajak_de');?>: </strong></label>
                <?php echo $this->Umb_model->currency_sign($potongan_pajak);?> </div>
            </div>
            <?php endif;?>
            <?php if($security_deposit!='' || $security_deposit!=0): ?>
            <div class="col-md-12">
              <div class="f">
                <label for="name"><strong><?php echo $this->lang->line('umb_payroll_security_deposit');?>: </strong></label>
                <?php echo $this->Umb_model->currency_sign($security_deposit);?> </div>
            </div>
            <?php endif;?>
          </div>
        </div>
      </div>
    </div>
    <?php endif;?>
    <?php if(($tunjangan_sewa_rumah!='' || $tunjangan_kesehatan!='' || $tunjangan_perjalanan!='' || $tunjangan_jabatan!='') && ($dana_yang_diberikan!='' || $potongan_pajak!='' || $security_deposit!='')){
		$col_sm = 'col-sm-12';
		$offset = 'offset-2md-3';
	} else {
		$col_sm = 'col-sm-12';
		$offset = '';
	}?>
    <div class="<?php echo $col_sm;?> col-xs-12 <?php echo $offset;?>">
      <div class="card">
        <div class="card-header text-uppercase"><b> <?php echo $this->lang->line('umb_payroll_total_gaji_details');?></b></div>
        <div class="card-block">
          <div class="row m-b-1">
            <?php if($gross_gaji): ?>
            <div class="col-md-12">
              <div class="f">
                <label for="name"><strong><?php echo $this->lang->line('umb_payroll_gross_gaji');?>: </strong></label>
                <?php echo $this->Umb_model->currency_sign($gross_gaji);?> </div>
            </div>
            <?php endif;?>
            <?php if($total_tunjanagans): ?>
            <div class="col-md-12">
              <div class="f">
                <label for="name"><strong><?php echo $this->lang->line('umb_payroll_total_tunjanagan');?>: </strong></label>
                <?php echo $this->Umb_model->currency_sign($total_tunjanagans);?> </div>
            </div>
            <?php endif;?>
            <?php if($total_potongans!=''): ?>
            <div class="col-md-12">
              <div class="f">
                <label for="name"><strong><?php echo $this->lang->line('umb_payroll_total_potongan');?>: </strong></label>
                <?php echo $this->Umb_model->currency_sign($total_potongans);?> </div>
            </div>
            <?php endif;?>
            <?php if($gaji_bersih!=''): ?>
            <div class="col-md-12">
              <div class="f">
                <label for="name"><strong><?php echo $this->lang->line('umb_payroll_gaji_bersih');?>: </strong></label>
                <?php echo $this->Umb_model->currency_sign($gaji_bersih);?> </div>
            </div>
            <?php endif;?>
            <?php if($is_potong_advance_gaji==1): ?>
            <div class="col-md-12">
              <div class="f">
                <label for="name"><strong><?php echo $this->lang->line('umb_potongan_advance_gaji');?>: </strong></label>
                <?php echo $this->Umb_model->currency_sign($jumlah_advance_gaji);?> </div>
            </div>
            <?php endif;?>
            <?php if($gaji_bersih!=''): ?>
            <div class="col-md-12">
              <div class="f">
                <label for="name"><strong><?php echo $this->lang->line('umb_bayar_jumlah');?>: </strong></label>
                <?php if($is_potong_advance_gaji==1): ?>
                <?php $re_bayar_jumlah = $gaji_bersih - $jumlah_advance_gaji;?>
                <?php else:?>
                <?php $re_bayar_jumlah = $gaji_bersih;?>
                <?php endif;?>
                <?php echo $this->Umb_model->currency_sign($jumlah_pembayaran);?> </div>
            </div>
            <?php endif;?>
            <?php if($total_jam_kerja): ?>
            <div class="col-md-12">
              <div class="f">
                <label for="name"><strong><?php echo $this->lang->line('umb_payroll_gross_gaji');?>: </strong></label>
                <?php 
				$ggaji = $total_jam_kerja * $nilai_perjam;
				echo $this->Umb_model->currency_sign($ggaji);?>
              </div>
            </div>
            <?php endif;?>
            <?php if($total_jam_kerja): ?>
            <div class="col-md-12">
              <div class="f">
                <label for="name"><strong><?php echo $this->lang->line('umb_payroll_gaji_bersih');?>: </strong></label>
                <?php 
				$hrs_gaji = $total_jam_kerja * $nilai_perjam;
				echo $this->Umb_model->currency_sign($hrs_gaji);?>
              </div>
            </div>
            <?php endif;?>
            <?php if($total_jam_kerja): ?>
            <div class="col-md-12">
              <div class="f">
                <label for="name"><strong><?php echo $this->lang->line('umb_bayar_jumlah');?>: </strong></label>
                <?php 
				$hrs_sal = $total_jam_kerja * $nilai_perjam;
				echo $this->Umb_model->currency_sign($hrs_sal);?>
              </div>
            </div>
            <?php endif;?>
            <?php if($gaji_bersih): ?>
            <div class="col-md-12">
              <div class="f">
                <label for="name"><strong><?php echo $this->lang->line('umb_payment_method');?>: </strong></label>
                <?php echo $p_method;?></div>
            </div>
            <?php endif;?>
            <?php if($gaji_bersih!=''): ?>
            <div class="col-md-12">
              <div class="f">
                <label for="name"><strong><?php echo $this->lang->line('umb_payment_comment');?>: </strong></label>
                <?php echo $comments;?></div>
            </div>
            <?php endif;?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php }


