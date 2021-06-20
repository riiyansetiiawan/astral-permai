<?php $transfer = $this->Keuangan_model->get_search_transfer($from_date,$to_date);?>
<?php
$jumlah_total = 0;
foreach($transfer->result() as $r) {
	$jumlah_total += $r->jumlah;
}
?>

<tr>
	<th colspan="5">&nbsp;</th>
	<th><?php echo $this->lang->line('umb_acc_total');?>: <?php echo $this->Umb_model->currency_sign($jumlah_total);?></th>
</tr>
