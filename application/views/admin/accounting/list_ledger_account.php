<?php
$session = $this->session->userdata('username');
$currency = $this->Umb_model->currency_sign(0);
?>
<?php $system = $this->Umb_model->read_setting_info(1);?>
<?php
$ac_id = $this->uri->segment(4);
$transaksii = $this->Keuangan_model->get_transaksii_bijaksanabank($ac_id);
$acc_bal = $this->Keuangan_model->read_informasi_bankcash($ac_id);
?>
<?php
$saldo2 = 0;
foreach($transaksii->result() as $r) {
	$saldo2 = $r->jumlah;
}
?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>
<div class="card <?php echo $get_animate;?>">
  <div class="card-header with-elements"> 
    <span class="card-header-title mr-2">
      <strong><?php echo $this->lang->line('umb_acc_ledger_account_of');?></strong> 
      <?php echo $acc_bal[0]->nama_account;?>
    </span>
  </div>
  <div class="card-body">
    <div class="card-subtitle text-muted mb-3">Opening Saldo: <?php echo $this->Umb_model->currency_sign($acc_bal[0]->pembukanaan_saldo_account);?></div>
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="umb_table">
        <input type="hidden" id="current_currency" value="<?php $curr = explode('0',$currency); echo $curr[0];?>" />
        <thead>
          <tr>
            <th><?php echo $this->lang->line('umb_e_details_tanggal');?></th>
            <th><?php echo $this->lang->line('umb_type');?></th>
            <th><?php echo $this->lang->line('umb_description');?></th>
            <th><?php echo $this->lang->line('umb_acc_credit');?></th>
            <th><?php echo $this->lang->line('umb_acc_debit');?></th>
            <th><?php echo $this->lang->line('umb_acc_saldo');?></th>
          </tr>
      <!--<tr>
          <th colspan="3" class="text-right">Opening Balance</th>
          <th>&nbsp;</th><th>&nbsp;</th>
          <th><?php echo $this->Umb_model->currency_sign($acc_bal[0]->pembukanaan_saldo_account);?></td>
          </tr>-->
        </thead>
        <tbody>
          <?php $crd_total = 0; $deb_total = 0;$saldo=0; $saldo2 = 0;
          foreach($transaksii->result() as $r) { ?>
            <?php
            $tanggal_transaksi = $this->Umb_model->set_date_format($r->tanggal_transaksi);
            $jumlah_total = $this->Umb_model->currency_sign($r->jumlah);
            $acc_type = $this->Keuangan_model->read_informasi_bankcash($r->account_id);
            $saldo_account = 0;
            if(!is_null($acc_type)){
              $saldo_account = str_replace(',','',$acc_type[0]->pembukanaan_saldo_account);
            } else {
              $saldo_account = 0;	
            }
            if($r->dr_cr == 'cr') {
              $saldo2 += $saldo2 - $r->jumlah;
            } else {
              $saldo2 += $saldo2 + $r->jumlah;
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
            if($saldo_account == ''){
              $saldo_account = 0;
            } else {
              $saldo_account = $saldo_account;
            }
            $fsaldo = 0;
            ?>
            <tr>
              <td><?php echo $tanggal_transaksi;?></td>
              <td><?php echo $r->type_transaksi;?></td>
              <td><?php echo $r->description;?></td>
              <td><?php echo $this->Umb_model->currency_sign($crd); ?></td>
              <td><?php echo $this->Umb_model->currency_sign($deb); ?></td>
              <td><?php echo $this->Umb_model->currency_sign($fsaldo);?></td>
            </tr>
          <?php } ?> 
        </tbody>
        <tfoot>
          <tr>
            <th colspan="3">&nbsp;</th>
            <th><?php echo $this->lang->line('umb_acc_credit');?>: <?php echo $this->Umb_model->currency_sign($crd_total);?></th>
            <th><?php echo $this->lang->line('umb_acc_debit');?>: <?php echo $this->Umb_model->currency_sign($deb_total);?></th>
            <th><?php echo $this->lang->line('umb_acc_saldo');?>: <?php echo $this->Umb_model->currency_sign($acc_bal[0]->saldo_account);?></th>
          </tr>
        </tfoot>
      </table>
      <input type="hidden" value="<?php echo $ac_id;?>" id="current_segment" />
    </div>
  </div>
</div>
