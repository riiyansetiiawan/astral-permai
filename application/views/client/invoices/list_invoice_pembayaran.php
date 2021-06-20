<?php
/*
* All Transactions - View
*/
$session = $this->session->userdata('client_username');
$currency = $this->Umb_model->currency_sign(0);
?>
<?php $system = $this->Umb_model->read_setting_info(1);?>
<?php //$transaksi = $this->Keuangan_model->get_transaksi();?>
<?php
$saldo2 = 0; $jumlah_total = 0; $transaksi_credit = 0; $transaksi_debit = 0;
?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>
<div class="card <?php echo $get_animate;?>">
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_acc_inv_payments');?></strong></span> </div>
  <div class="card-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="umb_table">
        <input type="hidden" id="current_currency" value="<?php //$curr = explode('0',$currency); echo $curr[0];?>" />
        <thead>
          <tr>
            <th><?php echo $this->lang->line('umb_invoice_no');?></th>
            <th><?php echo $this->lang->line('umb_e_details_tanggal');?></th>
            <th><?php echo $this->lang->line('umb_jumlah');?></th>
            <th><?php echo $this->lang->line('umb_payment_method');?></th>
            <th><?php echo $this->lang->line('umb_description');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>