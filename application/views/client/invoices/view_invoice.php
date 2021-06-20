<?php
/* Invoice view
*/
?>
<?php $session = $this->session->userdata('client_username');?>
<?php $system_setting = $this->Umb_model->read_setting_info(1);?>
<?php
$name_client = $name;
$client_nomor_kontak = $nomor_kontak;
$nama_perusahaan_client = $nama_perusahaan_client;
$client_website_url = $website_url;
$client_alamat_1 = $alamat_1;
$client_alamat_2 = $alamat_2;
//$negara_client = $negaraid;
$client_kota = $kota;
$client_kode_pos = $kode_pos;
$negara = $this->Umb_model->read_info_negara($negaraid);
if(!is_null($negara)){
$negara_client = $negara[0]->nama_negara;
} else {
$negara_client = '--';	
}
?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>
<?php $inv_record = get_record_transaksi_invoice($invoice_id);?>
<div class="card">    
<div class="card-header with-elements"> <span class="card-header-title mr-2">&nbsp;</span>
      <div class="card-header-elements ml-md-auto">
      <a href="<?php echo site_url('client/invoices/preview/'.$invoice_id);?>" class="btn btn-flickr btn-sm" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i> <?php echo $this->lang->line('umb_acc_inv_preview');?>
      <div class="ripple-wrapper"></div>
      </a>
      <?php if ($inv_record->num_rows() < 1) { ?>
      <a href="<?php echo site_url('client/invoices/preview/'.$invoice_id);?>" class="btn btn-sm btn-outline-primary waves-effect waves-light" target="_blank"><span class="fa fa-credit-card"></span> <?php echo $this->lang->line('umb_acc_pay_now');?></a>
      <?php } ?> 
      </div>
    </div>
   
  <div class="card-body p-5" id="print_invoice_hr">
    <div class="row">
      <div class="col-sm-6 pb-4">

        <div class="media align-items-center mb-2">
          <div class="media-body text-big font-weight-bold ml-1">
            <?php echo $nama_perusahaan;?>
          </div>
        </div>

        <div class="mb-0"><?php echo $alamat_perusahaan;?></div>
        <div class="mb-0"><?php echo $kode_pos_perusahaan;?>, <?php echo $kota_perusahaan;?>, <?php echo $negara_perusahaan;?></div>
        <div><?php echo $this->lang->line('umb_phone');?>: <?php echo $phone_perusahaan;?></div>
        <div><strong>Attn:</strong> <?php echo $name;?></div>
        <div><strong><?php echo $this->lang->line('umb_project');?>:</strong> <?php echo $nama_project;?></div>
      </div>

      <div class="col-sm-6 text-right pb-4">

        <h6 class="text-big text-large font-weight-bold mb-3">
        <span style="text-transform:uppercase;"><?php echo $this->lang->line('umb_invoice_no');?></span> <?php echo $nomor_invoice;?></h6>
        <div class="mb-1"><?php echo $this->lang->line('umb_e_details_tanggal');?>: <strong class="font-weight-semibold"><?php echo $this->Umb_model->set_date_format($tanggal_invoice);?></strong></div>
        <div><?php echo $this->lang->line('umb_payment_due');?>: <strong class="font-weight-semibold"><?php echo $this->Umb_model->set_date_format($tanggal_jatoh_tempo_invoice);?></strong></div>
        <div>
        <?php
		if($status == 0){
			$_status = '<span class="badge badge-danger">'.$this->lang->line('umb_payroll_belum_dibayar').'</span>';
		} else if($status == 1) {
			$_status = '<span class="badge badge-success">'.$this->lang->line('umb_payment_bayar').'</span>';
		} else {
			$_status = '<span class="badge badge-info">'.$this->lang->line('umb_acc_inv_cancelled').'</span>';
		}
		echo $_status;
		?>
        </div>

      </div>
    </div>

    <hr class="mb-4">

    <div class="row">
      <div class="col-sm-6 mb-4">

        <div class="font-weight-bold mb-2"><?php echo $this->lang->line('umb_invoice_to');?>:</div>
        <div><?php echo $name_client;?></div>
        <div><?php echo $nama_perusahaan_client;?></div>
        <div><?php echo $client_alamat_1.' '.$client_alamat_2.' '.$client_kota;?></div>
        <div><?php echo $client_nomor_kontak;?></div>
        <div><?php echo $email;?></div>

      </div>
      <div class="col-sm-6 mb-4">

        <div class="font-weight-bold mb-2"><?php echo $this->lang->line('umb_payment_details');?>:</div>
        <table>
          <tbody>
            <tr>
              <td class="pr-3"><?php echo $this->lang->line('umb_total_due');?>:</td>
              <td><strong><?php echo $this->Umb_model->currency_sign($grand_total);?></strong></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div class="table-responsive mb-4">
      <table class="table m-0">
        <thead>
          <tr>
              <th class="py-3"> # </th>
              <th class="py-3" width="300px"> <?php echo $this->lang->line('umb_title_item');?> </th>
              <th class="py-3"> <?php echo $this->lang->line('umb_title_nilai_pajak');?> </th>
              <th class="py-3"> <?php echo $this->lang->line('umb_title_qty_hrs');?> </th>
              <th class="py-3"> <?php echo $this->lang->line('umb_title_unit_price');?> </th>
              <th class="py-3"> <?php echo $this->lang->line('umb_title_sub_total');?> </th>
            </tr>
        </thead>
        <tbody>
          <?php
			$ar_sc = explode('- ',$system_setting[0]->default_currency_symbol);
			$sc_show = $ar_sc[1];
			?>
            <?php $prod = array(); $i=1; foreach($this->Invoices_model->get_invoice_items($invoice_id) as $_item):?>
            <tr>
              <td class="py-3"><div class="font-weight-semibold"><?php echo $i;?></div></td>
              <td class="py-3" style="width:"><div class="font-weight-semibold"><?php echo $_item->item_name;?></div></td>
              <td class="py-3"><strong><?php echo $this->Umb_model->currency_sign($_item->item_nilai_pajak);?></strong></td>
              <td class="py-3"><strong><?php echo $_item->item_qty;?></strong></td>
              <td class="py-3"><strong><?php echo $this->Umb_model->currency_sign($_item->item_unit_price);?></strong></td>
              <td class="py-3"><strong><?php echo $this->Umb_model->currency_sign($_item->item_sub_total);?></strong></td>
            </tr>
            <?php endforeach;?>
            <tr>
                <td colspan="5" class="text-right py-3">
                  Subtotal:<br>
                  Tax:<br>
                  Discount:<br>
                  <span class="d-block text-big mt-2">Total:</span>
                </td>
                <td class="py-3">
                  <strong><?php echo $this->Umb_model->currency_sign($sub_jumlah_total);?></strong><br>
                  <strong><?php echo $this->Umb_model->currency_sign($total_pajak);?></strong><br>
                  <strong><?php echo $this->Umb_model->currency_sign($total_discount);?></strong><br>
                  <strong class="d-block text-big mt-2"><?php echo $this->Umb_model->currency_sign($grand_total);?></strong>
                </td>
              </tr>
        </tbody>
      </table>
    </div>
    <?php if($catatan_invoice != ''):?>
    <div class="text-muted">
      <strong><?php echo $this->lang->line('umb_note');?>:</strong> <?php echo $catatan_invoice;?>
    </div>
   <?php endif;?> 
  </div>
  <div class="card-footer text-right">
    <a href="javascript:void(0);" class="btn btn-default print-invoice"><i class="ion ion-md-print"></i>&nbsp; <?php echo $this->lang->line('umb_print');?></a>
  </div>
</div>