<?php
$session = $this->session->userdata('username');
$currency = $this->Umb_model->currency_sign(0);
?>
<?php $system = $this->Umb_model->read_setting_info(1);?>
<?php $bankcash = $this->Keuangan_model->get_bankcash();?>
<?php
$saldo_account = 0;;
foreach($bankcash->result() as $r) {
	$saldo_account += $r->saldo_account;
}
?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>
<div class="card <?php echo $get_animate;?>">
  <div class="card-header with-elements"> 
    <span class="card-header-title mr-2">
      <strong><?php echo $this->lang->line('umb_add_new');?></strong> 
      <?php echo $this->lang->line('umb_acc_saldo_accounts');?>
    </span>
  </div>
  <div class="card-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="umb_table">
        <input type="hidden" id="current_currency" value="<?php $curr = explode('0',$currency); echo $curr[0];?>" />
        <thead>
          <tr>
            <th><?php echo $this->lang->line('umb_acc_account');?></th>
            <th><?php echo $this->lang->line('umb_acc_saldo');?></th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th colspan="1" style="text-align:right"><?php echo $this->lang->line('umb_acc_total');?>:</th>
            <th><?php echo $this->Umb_model->currency_sign($saldo_account);?></th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
</div>
