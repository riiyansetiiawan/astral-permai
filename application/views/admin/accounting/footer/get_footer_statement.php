<?php $account_statement = $this->Keuangan_model->search_account_statement($from_date,$to_date,$account_id);?>
<?php
$crd_total = 0; $deb_total = 0;$saldo=0; $saldo2 = 0;
$acc_bal = $this->Keuangan_model->read_informasi_bankcash($account_id);
foreach($account_statement->result() as $r) {
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
}
?>
<tr>
	<th colspan="3">&nbsp;</th>
	<th><?php echo $this->lang->line('umb_acc_credit');?>: <?php echo $this->Umb_model->currency_sign($crd_total);?></th>
	<th><?php echo $this->lang->line('umb_acc_debit');?>: <?php echo $this->Umb_model->currency_sign($deb_total);?></th>
</tr>