<?php $deposit = $this->Keuangan_model->get_search_deposit($from_date,$to_date,$type_id);?>
<?php
$jumlah_total = 0;
foreach($deposit->result() as $r) {
	$jumlah_total += $r->jumlah;
}
?>
<tr>
	<th colspan="3">&nbsp;</th>
	<th style="float:right;"><?php echo $this->lang->line('umb_acc_total');?></th>
	<th><?php echo $this->Umb_model->currency_sign($jumlah_total);?></th>
</tr>
