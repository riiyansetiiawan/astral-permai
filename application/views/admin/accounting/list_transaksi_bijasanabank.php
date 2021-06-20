<?php
$session = $this->session->userdata('username');
$currency = $this->Umb_model->currency_sign(0);
?>
<?php $system = $this->Umb_model->read_setting_info(1);?>
<?php
$ac_id = $this->uri->segment(3);
$transaksii = $this->Keuangan_model->get_transaksii_bijaksanabank($ac_id);
?>
<?php
$saldo2 = 0; $jumlah_total = 0; $transaksi_credit = 0; $transaksi_debit = 0;
foreach($transaksii->result() as $r) {
	if($r->transaksi_debit == 0) {
		$saldo2 = $saldo2 - $r->transaksi_credit;
	} else {
		$saldo2 = $saldo2 + $r->transaksi_debit;
	}
	$jumlah_total += $r->jumlah_total;
	$transaksi_credit += $r->transaksi_credit;
	$transaksi_debit += $r->transaksi_debit;
}
?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>
<div class="box <?php echo $get_animate;?>">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $this->lang->line('umb_list_all');?> <?php echo $this->lang->line('umb_acc_transaksii');?></h3>
  </div>
  <div class="box-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="umb_table">
        <input type="hidden" id="current_currency" value="<?php $curr = explode('0',$currency); echo $curr[0];?>" />
        <thead>
          <tr>
            <th><?php echo $this->lang->line('umb_e_details_tanggal');?></th>
            <th><?php echo $this->lang->line('umb_acc_accounts');?></th>
            <th><?php echo $this->lang->line('umb_type');?></th>
            <th><?php echo $this->lang->line('umb_jumlah');?></th>
            <th><?php echo $this->lang->line('umb_acc_credit');?></th>
            <th><?php echo $this->lang->line('umb_acc_debit');?></th>
            <th><?php echo $this->lang->line('umb_acc_saldo');?></th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th colspan="3">&nbsp;</th>
            <th><?php echo $this->lang->line('umb_jumlah_total');?>: <?php echo $this->Umb_model->currency_sign($jumlah_total);?></th>
            <th><?php echo $this->lang->line('umb_acc_credit');?>: <?php echo $this->Umb_model->currency_sign($transaksi_credit);?></th>
            <th><?php echo $this->lang->line('umb_acc_debit');?>: <?php echo $this->Umb_model->currency_sign($transaksi_debit);?></th>
            <th><?php echo $this->lang->line('umb_acc_saldo');?>: <?php echo $this->Umb_model->currency_sign($saldo2);?></th>
          </tr>
        </tfoot>
      </table>
      <input type="hidden" value="<?php echo $this->uri->segment(3);?>" id="current_segment" />
    </div>
  </div>
</div>
