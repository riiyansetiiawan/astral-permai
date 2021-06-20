<?php $acc_ledger = $this->Keuangan_model->get_ledger_accounts($this->input->get('from_date'),$this->input->get('to_date'));?>
<?php
$crd_total = 0; $deb_total = 0;$saldo=0; $saldo2 = 0;
foreach($acc_ledger->result() as $r) {
	
	$tanggal_transaksi = $this->Umb_model->set_date_format($r->tanggal_transaksi);
	$jumlah_total = $this->Umb_model->currency_sign($r->jumlah);
	$acc_type = $this->Keuangan_model->read_informasi_bankcash($r->account_id);
	if(!is_null($acc_type)){
		$saldo_account = $acc_type[0]->pembukanaan_saldo_account;
	} else {
		$saldo_account = 0;	
	}
	if($r->dr_cr == 'cr') {
		$saldo2 = $saldo2 - $r->jumlah;
	} else {
		$saldo2 = $saldo2 + $r->jumlah;
	}
	if($r->credit!=0):
		$crd = $r->credit;
		$crd_total += $crd;
	else:
		$crd = 0;	
		$crd_total += $crd;
	endif;
	if($r->debit!=0):
		$deb = $r->debit;
		$deb_total += $deb;
	else:
		$deb = 0;	
		$deb_total += $deb;
	endif;
	$fsaldo = $saldo_account + $saldo2;
}
?>
<tr>
	<th colspan="3">&nbsp;</th>
	<th><?php echo $this->lang->line('umb_acc_credit');?>: <?php echo $this->Umb_model->currency_sign($crd_total);?></th>
	<th><?php echo $this->lang->line('umb_acc_debit');?>: <?php echo $this->Umb_model->currency_sign($deb_total);?></th>
	<th><?php echo $this->lang->line('umb_acc_saldo');?>: <?php echo $this->Umb_model->currency_sign($fsaldo);?></th>
</tr>
