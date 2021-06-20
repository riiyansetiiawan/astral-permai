<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['bankcash_id']) && $_GET['data']=='bankcash'){
  ?>
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> 
      <span aria-hidden="true">×</span> 
    </button>
    <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_acc_edit_account');?></h4>
  </div>
  <?php $attributes = array('name' => 'update_bankcash', 'id' => 'update_bankcash', 'autocomplete' => 'off');?>
  <?php $hidden = array('_method' => 'EDIT', '_token' => $bankcash_id, 'ext_name' => $nama_account);?>
  <?php echo form_open('admin/accounting/update_bankcash/'.$bankcash_id, $attributes, $hidden);?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="nama_account"><?php echo $this->lang->line('umb_acc_nama_account');?></label>
          <input type="text" class="form-control" name="nama_account" placeholder="<?php echo $this->lang->line('umb_acc_nama_account');?>" value="<?php echo $nama_account;?>">
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="saldo_account"><?php echo $this->lang->line('umb_acc_initial_saldo');?></label>
              <input type="text" class="form-control" name="saldo_account" placeholder="<?php echo $this->lang->line('umb_acc_initial_saldo');?>" value="<?php echo $saldo_account;?>">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="nomor_account"><?php echo $this->lang->line('umb_e_details_acc_number');?></label>
              <input type="text" class="form-control" name="nomor_account" placeholder="<?php echo $this->lang->line('umb_e_details_acc_number');?>" value="<?php echo $nomor_account;?>">
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="kode_cabang"><?php echo $this->lang->line('umb_acc_kode_cabang');?></label>
          <input type="text" class="form-control" name="kode_cabang" placeholder="<?php echo $this->lang->line('umb_acc_kode_cabang');?>" value="<?php echo $kode_cabang;?>">
        </div>
      </div>
      <div class="col-md-6">
        <label for="description"><?php echo $this->lang->line('umb_e_details_cabang_bank');?></label>
        <textarea class="form-control" name="cabang_bank" placeholder="<?php echo $this->lang->line('umb_e_details_cabang_bank');?>" rows="5"><?php echo $cabang_bank;?></textarea>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">
      <i class="fas fa-check-square"></i> 
      <?php echo $this->lang->line('umb_close');?>
    </button>
    <button type="submit" class="btn btn-primary">
      <i class="fas fa-check-square"></i> 
      <?php echo $this->lang->line('umb_update');?>
    </button>
  </div>
  <?php echo form_close(); ?> 
  <script type="text/javascript">
    $(document).ready(function(){ 
      Ladda.bind('button[type=submit]');
      $("#update_bankcash").submit(function(e){
        e.preventDefault();
        var obj = $(this), action = obj.attr('name');
        $('.save').prop('disabled', true);
        $.ajax({
          type: "POST",
          url: e.target.action,
          data: obj.serialize()+"&is_ajax=1&edit_type=bankcash&form="+action,
          cache: false,
          success: function (JSON) {
            if (JSON.error != '') {
              toastr.error(JSON.error);
              $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
              $('.save').prop('disabled', false);
              Ladda.stopAll();
            } else {
              var umb_table = $('#umb_table').dataTable({
                "bDestroy": true,
                "ajax": {
                  url : "<?php echo site_url("admin/accounting/list_bank_cash") ?>",
                  type : 'GET'
                },
                "fnDrawCallback": function(settings){
                  $('[data-toggle="tooltip"]').tooltip();          
                }
              });
              umb_table.api().ajax.reload(function(){ 
                toastr.success(JSON.result);
              }, true);
              $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
              $('.edit-modal-data').modal('toggle');
              $('.save').prop('disabled', false);
              Ladda.stopAll();
            }
          }
        });
      });
    });	
  </script>
<?php } else if(isset($_GET['jd']) && isset($_GET['invoice_id']) && $_GET['is_ajax']=='1'){
  ?>
  <?php if($_GET['data']=='customer'):?>
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"> 
        <span aria-hidden="true">×</span> 
      </button>
      <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_invoice_no').' '.$nomor_invoice;?></h4>
    </div>
    <?php $attributes = array('name' => 'add_payment', 'id' => 'add_payment', 'autocomplete' => 'off');?>
    <?php $hidden = array('_method' => 'EDIT', '_token' => $invoice_id, 'invoice_id' => $invoice_id);?>
    <?php echo form_open('admin/accounting/add_invoice_pembayaran/'.$invoice_id, $attributes, $hidden);?>
    <?php else:?>
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> 
          <span aria-hidden="true">×</span> 
        </button>
        <h4 class="modal-title" id="edit-modal-data">Direct <?php echo $this->lang->line('umb_invoice_no').' '.$nomor_invoice;?></h4>
      </div>
      <?php $attributes = array('name' => 'add_payment', 'id' => 'add_payment', 'autocomplete' => 'off');?>
      <?php $hidden = array('_method' => 'EDIT', '_token' => $invoice_id, 'invoice_id' => $invoice_id);?>
      <?php echo form_open('admin/accounting/add_direct_invoice_pembayaran/'.$invoice_id, $attributes, $hidden);?>
    <?php endif;?>
    <div class="modal-body">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="type_award"><?php echo $this->lang->line('umb_acc_account');?></label>
            <select name="bank_cash_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_acc_choose_account_type');?>">
              <option value=""></option>
              <?php foreach($all_bank_cash as $bank_cash) {?>
                <option value="<?php echo $bank_cash->bankcash_id;?>"><?php echo $bank_cash->nama_account;?></option>
              <?php } ?>
            </select>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="month_year"><?php echo $this->lang->line('umb_jumlah');?></label>
                <input class="form-control" name="jumlah" type="text" value="<?php echo $grand_total;?>">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="deposit_tanggal"><?php echo $this->lang->line('umb_e_details_tanggal');?></label>
                <input class="form-control d_date" placeholder="<?php echo date('Y-m-d');?>" readonly name="add_invoice_tanggal" type="text" value="">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="karyawan"><?php echo $this->lang->line('umb_acc_kategori');?></label>
                <select name="kategori_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_acc_choose_kategori');?>">
                  <option value=""></option>
                  <?php foreach($all_list_kategoris_pendapatan as $kategori_pendapatan) {?>
                    <option value="<?php echo $kategori_pendapatan->kategori_id;?>"> <?php echo $kategori_pendapatan->name;?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="karyawan"><?php echo $this->lang->line('umb_acc_pembayar');?></label>
                <select name="pembayar_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_acc_pembayar');?>">
                  <option value=""></option>
                  <?php foreach($all_pembayars as $pembayar) {?>
                    <option value="<?php echo $pembayar->customer_id;?>"> <?php echo $pembayar->name;?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="description"><?php echo $this->lang->line('umb_description');?></label>
            <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('umb_description');?>" name="description" cols="30" rows="5" id="description2"></textarea>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="payment_method"><?php echo $this->lang->line('umb_payment_method');?></label>
                <select name="payment_method" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_payment_method');?>">
                  <option value=""></option>
                  <?php foreach($get_all_payment_method as $payment_method) {?>
                    <option value="<?php echo $payment_method->payment_method_id;?>"> <?php echo $payment_method->method_name;?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="karyawan"><?php echo $this->lang->line('umb_acc_ref_no');?></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('umb_acc_ref_example');?>" name="reference" type="text" value="">
                <br />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">
        <i class="fas fa-check-square"></i> 
        <?php echo $this->lang->line('umb_close');?>
      </button>
      <button type="submit" class="btn btn-primary">
        <i class="fas fa-check-square"></i> 
        <?php echo $this->lang->line('umb_update');?>
      </button>
    </div>
    <?php echo form_close(); ?> 
    <script type="text/javascript">
      $(document).ready(function(){ 
        $('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
        $('[data-plugin="select_hrm"]').select2({ width:'100%' });
        Ladda.bind('button[type=submit]');		
        $('.d_date').datepicker({
          changeMonth: true,
          changeYear: true,
          dateFormat:'yy-mm-dd',
          yearRange: '1900:' + (new Date().getFullYear() + 15),
          beforeShow: function(input) {
            $(input).datepicker("widget").show();
          }
        });
        $("#add_payment").submit(function(e){
          var fd = new FormData(this);
          var obj = $(this), action = obj.attr('name');
          fd.append("is_ajax", 1);
          fd.append("add_type", 'invoice_pembayaran');
          fd.append("form", action);
          e.preventDefault();
          $('.icon-spinner3').show();
          $('.save').prop('disabled', true);
          $.ajax({
            url: e.target.action,
            type: "POST",
            data:  fd,
            contentType: false,
            cache: false,
            processData:false,
            success: function(JSON) {
              if (JSON.error != '') {
                toastr.error(JSON.error);
                $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
                $('.save').prop('disabled', false);
                $('.icon-spinner3').hide();
                Ladda.stopAll();
              } else {
                toastr.success(JSON.result);
                $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
                $('.icon-spinner3').hide();
                window.location = '';
                $('.save').prop('disabled', false);
                Ladda.stopAll();
              }
            },
            error: function() {
              toastr.error(JSON.error);
              $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
              $('.icon-spinner3').hide();
              $('.save').prop('disabled', false);
              Ladda.stopAll();
            } 	        
          });
        });
      });	
    </script>
  <?php } else if(isset($_GET['jd']) && isset($_GET['deposit_id']) && $_GET['data']=='transaksi_deposit'){
    ?>
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"> 
        <span aria-hidden="true">×</span> 
      </button>
      <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_acc_edit_deposit');?></h4>
    </div>
    <?php $attributes = array('name' => 'update_deposit', 'id' => 'update_deposit', 'autocomplete' => 'off');?>
    <?php $hidden = array('_method' => 'EDIT', '_token' => $deposit_id, 'ext_name' => $deposit_id);?>
    <?php echo form_open('admin/accounting/update_transaksi/'.$deposit_id, $attributes, $hidden);?>
    <div class="modal-body">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="type_award"><?php echo $this->lang->line('umb_acc_account');?></label>
            <select name="bank_cash_id" disabled="disabled" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_acc_choose_account_type');?>">
              <option value=""></option>
              <?php foreach($all_bank_cash as $bank_cash) {?>
                <option value="<?php echo $bank_cash->bankcash_id;?>" <?php if($type_account_id==$bank_cash->bankcash_id):?> selected="selected"<?php endif;?>><?php echo $bank_cash->nama_account;?></option>
              <?php } ?>
            </select>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="month_year"><?php echo $this->lang->line('umb_jumlah');?></label>
                <input class="form-control" name="jumlah" type="text" value="<?php echo $jumlah;?>" readonly="readonly">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="deposit_tanggal"><?php echo $this->lang->line('umb_e_details_tanggal');?></label>
                <input class="form-control d_date" placeholder="<?php echo date('Y-m-d');?>" readonly name="deposit_tanggal" type="text" value="<?php echo $deposit_tanggal;?>">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="karyawan"><?php echo $this->lang->line('umb_acc_kategori');?></label>
                <select name="kategori_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_acc_choose_kategori');?>">
                  <option value=""></option>
                  <?php foreach($all_list_kategoris_pendapatan as $kategori_pendapatan) {?>
                    <option value="<?php echo $kategori_pendapatan->kategori_id;?>" <?php if($kategoriid==$kategori_pendapatan->kategori_id):?> selected="selected"<?php endif;?>> <?php echo $kategori_pendapatan->name;?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="karyawan"><?php echo $this->lang->line('umb_acc_pembayar');?></label>
                <select name="pembayar_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_acc_pembayar');?>">
                  <option value=""></option>
                  <?php foreach($all_pembayars as $pembayar) {?>
                    <option value="<?php echo $pembayar->customer_id;?>" <?php if($pembayar_id==$pembayar->customer_id):?> selected="selected"<?php endif;?>> <?php echo $pembayar->name;?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="description"><?php echo $this->lang->line('umb_description');?></label>
            <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('umb_description');?>" name="description" cols="30" rows="5" id="description2"><?php echo $description;?></textarea>
          </div>
          <div class='form-group'>
            <div>
              <label for="photo"><?php echo $this->lang->line('umb_acc_attach_file');?></label>
            </div>
            <span class="btn btn-primary btn-file"> <?php echo $this->lang->line('umb_browse');?>
            <input type="file" name="file_deposit" id="file_deposit">
          </span>
          <?php if($file_deposit!='' && $file_deposit!='no_file'):?>
            <br>
            <a href="<?php echo site_url('admin/download')?>?type=accounting/deposit&filename=<?php echo $file_deposit;?>"><?php echo $this->lang->line('umb_download');?></a>
          <?php endif;?>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-3">
        <div class="form-group">
          <label for="payment_method"><?php echo $this->lang->line('umb_payment_method');?></label>
          <select name="payment_method" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_payment_method');?>">
            <option value=""></option>
            <?php foreach($get_all_payment_method as $payment_method) {?>
              <option value="<?php echo $payment_method->payment_method_id;?>" <?php if($payment_method_id==$payment_method->payment_method_id):?> selected="selected"<?php endif;?>> <?php echo $payment_method->method_name;?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label for="karyawan"><?php echo $this->lang->line('umb_acc_ref_no');?></label>
          <input class="form-control" placeholder="<?php echo $this->lang->line('umb_acc_ref_example');?>" name="reference_deposit" type="text" value="<?php echo $reference_deposit;?>">
          <br />
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">
      <i class="fas fa-check-square"></i> 
      <?php echo $this->lang->line('umb_close');?>
    </button>
    <button type="submit" class="btn btn-primary">
      <i class="fas fa-check-square"></i> 
      <?php echo $this->lang->line('umb_update');?>
    </button>
  </div>
  <?php echo form_close(); ?> 
  <script type="text/javascript">
    $(document).ready(function(){ 
      $('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
      $('[data-plugin="select_hrm"]').select2({ width:'100%' });	 
      Ladda.bind('button[type=submit]');
      $('.d_date').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat:'yy-mm-dd',
        yearRange: '1900:' + (new Date().getFullYear() + 15),
        beforeShow: function(input) {
          $(input).datepicker("widget").show();
        }
      });
      $("#update_deposit").submit(function(e){
        var fd = new FormData(this);
        var obj = $(this), action = obj.attr('name');
        fd.append("is_ajax", 1);
        fd.append("edit_type", 'deposit');
        fd.append("form", action);
        e.preventDefault();
        $('.icon-spinner3').show();
        $('.save').prop('disabled', true);
        $.ajax({
          url: e.target.action,
          type: "POST",
          data:  fd,
          contentType: false,
          cache: false,
          processData:false,
          success: function(JSON) {
            if (JSON.error != '') {
              toastr.error(JSON.error);
              $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
              $('.save').prop('disabled', false);
              Ladda.stopAll();
            } else {
              var umb_table = $('#umb_table').dataTable({
                "bDestroy": true,
                "ajax": { 
                  url : "<?php if($_GET['inv']==0){ echo site_url("admin/accounting/list_transaksi");} else { echo site_url("admin/invoices/list_invoice_pembayaran"); } ?>",
                  type : 'GET'
                },
                "fnDrawCallback": function(settings){
                  $('[data-toggle="tooltip"]').tooltip();          
                }
              });
              umb_table.api().ajax.reload(function(){ 
                toastr.success(JSON.result);
              }, true);
              $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
              $('.icon-spinner3').hide();
              $('.view-modal-data-bg').modal('toggle');
              $('.save').prop('disabled', false);
              Ladda.stopAll();
            }
          },
          error: function() {
            toastr.error(JSON.error);
            $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
            $('.icon-spinner3').hide();
            $('.save').prop('disabled', false);
            Ladda.stopAll();
          } 	        
        });
      });
    });	
  </script>
<?php } else if(isset($_GET['jd']) && isset($_GET['deposit_id']) && $_GET['data']=='deposit'){
  ?>
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
    <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_acc_edit_deposit');?></h4>
  </div>
  <?php $attributes = array('name' => 'update_deposit', 'id' => 'update_deposit', 'autocomplete' => 'off');?>
  <?php $hidden = array('_method' => 'EDIT', '_token' => $deposit_id, 'ext_name' => $deposit_id);?>
  <?php echo form_open('admin/accounting/update_deposit/'.$deposit_id, $attributes, $hidden);?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="type_award"><?php echo $this->lang->line('umb_acc_account');?></label>
          <select name="bank_cash_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_acc_choose_account_type');?>">
            <option value=""></option>
            <?php foreach($all_bank_cash as $bank_cash) {?>
              <option value="<?php echo $bank_cash->bankcash_id;?>" <?php if($type_account_id==$bank_cash->bankcash_id):?> selected="selected"<?php endif;?>><?php echo $bank_cash->nama_account;?></option>
            <?php } ?>
          </select>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="month_year"><?php echo $this->lang->line('umb_jumlah');?></label>
              <input class="form-control" name="jumlah" type="text" value="<?php echo $jumlah;?>">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="deposit_tanggal"><?php echo $this->lang->line('umb_e_details_tanggal');?></label>
              <input class="form-control d_date" placeholder="<?php echo date('Y-m-d');?>" readonly name="deposit_tanggal" type="text" value="<?php echo $deposit_tanggal;?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="karyawan"><?php echo $this->lang->line('umb_acc_kategori');?></label>
              <select name="kategori_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_acc_choose_kategori');?>">
                <option value=""></option>
                <?php foreach($all_list_kategoris_pendapatan as $kategori_pendapatan) {?>
                  <option value="<?php echo $kategori_pendapatan->kategori_id;?>" <?php if($kategoriid==$kategori_pendapatan->kategori_id):?> selected="selected"<?php endif;?>> <?php echo $kategori_pendapatan->name;?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="karyawan"><?php echo $this->lang->line('umb_acc_pembayar');?></label>
              <select name="pembayar_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_acc_pembayar');?>">
                <option value=""></option>
                <?php foreach($all_pembayars as $pembayar) {?>
                  <option value="<?php echo $pembayar->pembayar_id;?>" <?php if($pembayar_id==$pembayar->pembayar_id):?> selected="selected"<?php endif;?>> <?php echo $pembayar->nama_pembayar;?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="description"><?php echo $this->lang->line('umb_description');?></label>
          <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('umb_description');?>" name="description" cols="30" rows="5" id="description2"><?php echo $description;?></textarea>
        </div>
        <div class='form-group'>
          <div>
            <label for="photo"><?php echo $this->lang->line('umb_acc_attach_file');?></label>
          </div>
          <span class="btn btn-file"> <?php echo $this->lang->line('umb_browse');?>
          <input type="file" name="file_deposit" id="file_deposit">
        </span>
        <?php if($file_deposit!='' && $file_deposit!='no_file'):?>
          <br>
          <a href="<?php echo site_url('admin/download')?>?type=accounting/deposit&filename=<?php echo $file_deposit;?>"><?php echo $this->lang->line('umb_download');?></a>
        <?php endif;?>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-3">
      <div class="form-group">
        <label for="payment_method">
          <?php echo $this->lang->line('umb_payment_method');?></label>
          <select name="payment_method" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_payment_method');?>">
            <option value=""></option>
            <?php foreach($get_all_payment_method as $payment_method) {?>
              <option value="<?php echo $payment_method->payment_method_id;?>" <?php if($payment_method_id==$payment_method->payment_method_id):?> selected="selected"<?php endif;?>> <?php echo $payment_method->method_name;?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label for="karyawan"><?php echo $this->lang->line('umb_acc_ref_no');?></label>
          <input class="form-control" placeholder="<?php echo $this->lang->line('umb_acc_ref_example');?>" name="reference_deposit" type="text" value="<?php echo $reference_deposit;?>">
          <br />
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">
      <i class="fas fa-check-square"></i> 
      <?php echo $this->lang->line('umb_close');?>
    </button>
    <button type="submit" class="btn btn-primary">
      <i class="fas fa-check-square"></i> 
      <?php echo $this->lang->line('umb_update');?>
    </button>
  </div>
  <?php echo form_close(); ?> 
  <script type="text/javascript">
    $(document).ready(function(){ 
      $('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
      $('[data-plugin="select_hrm"]').select2({ width:'100%' });	 
      $('.d_date').bootstrapMaterialDatePicker({
       weekStart: 0,
       time: false,
       clearButton: false,
       format: 'YYYY-MM-DD'
     });
      Ladda.bind('button[type=submit]');
      $("#update_deposit").submit(function(e){
        var fd = new FormData(this);
        var obj = $(this), action = obj.attr('name');
        fd.append("is_ajax", 1);
        fd.append("edit_type", 'deposit');
        fd.append("form", action);
        e.preventDefault();
        $('.icon-spinner3').show();
        $('.save').prop('disabled', true);
        $.ajax({
          url: e.target.action,
          type: "POST",
          data:  fd,
          contentType: false,
          cache: false,
          processData:false,
          success: function(JSON){
            if (JSON.error != '') {
              toastr.error(JSON.error);
              $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
              $('.save').prop('disabled', false);
              Ladda.stopAll();
            } else {
              var umb_table = $('#umb_table').dataTable({
                "bDestroy": true,
                "ajax": {
                  url : "<?php echo site_url("admin/accounting/list_deposit") ?>",
                  type : 'GET'
                },
                "fnDrawCallback": function(settings){
                  $('[data-toggle="tooltip"]').tooltip();          
                }
              });
              umb_table.api().ajax.reload(function(){ 
                toastr.success(JSON.result);
              }, true);
              $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
              $('.icon-spinner3').hide();
              $('.edit-modal-data').modal('toggle');
              $('.save').prop('disabled', false);
              Ladda.stopAll();
            }
          },
          error: function() {
            toastr.error(JSON.error);
            $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
            $('.icon-spinner3').hide();
            $('.save').prop('disabled', false);
            Ladda.stopAll();
          } 	        
        });
      });
    });	
  </script>
<?php } else if(isset($_GET['jd']) && isset($_GET['biaya_id']) && $_GET['data']=='biaya'){?>
  <?php $role_resources_ids = $this->Umb_model->user_role_resource(); ?>
  <?php $session = $this->session->userdata('username');?>
  <?php $user_info = $this->Umb_model->read_user_info($session['user_id']);?>
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
    <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_edit_biaya');?></h4>
  </div>
  <?php $attributes = array('name' => 'update_biaya', 'id' => 'update_biaya', 'autocomplete' => 'off');?>
  <?php $hidden = array('_method' => 'EDIT', '_token' => $biaya_id, 'ext_name' => $biaya_id);?>
  <?php echo form_open('admin/accounting/update_biaya/'.$biaya_id, $attributes, $hidden);?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-7">
        <div class="form-group">
          <label for="type_award"><?php echo $this->lang->line('umb_acc_account');?></label>
          <select name="bank_cash_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_acc_choose_account_type');?>">
            <option value=""></option>
            <?php foreach($all_bank_cash as $bank_cash) {?>
              <option value="<?php echo $bank_cash->bankcash_id;?>" <?php if($type_account_id==$bank_cash->bankcash_id):?> selected="selected"<?php endif;?>><?php echo $bank_cash->nama_account;?></option>
            <?php } ?>
          </select>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="month_year"><?php echo $this->lang->line('umb_jumlah');?></label>
              <input class="form-control" name="jumlah" type="text" value="<?php echo $jumlah;?>">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="deposit_tanggal"><?php echo $this->lang->line('umb_e_details_tanggal');?></label>
              <input class="form-control d_date" placeholder="<?php echo date('Y-m-d');?>" readonly name="tanggal_biaya" type="text" value="<?php echo $tanggal_biaya;?>">
            </div>
          </div>
        </div>
        <div class="row">
          <?php if($user_info[0]->user_role_id==1 || in_array('314',$role_resources_ids)){ ?>
            <div class="col-md-4">
              <?php if($user_info[0]->user_role_id==1){ ?>
                <div class="form-group">
                  <label for="department"><?php echo $this->lang->line('module_title_perusahaan');?></label>
                  <select class="form-control" name="perusahaan" id="aj_perusahaanx" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_title_perusahaan');?>" required>
                    <option value=""><?php echo $this->lang->line('module_title_perusahaan');?></option>
                    <?php foreach($all_perusahaans as $perusahaan) {?>
                      <option value="<?php echo $perusahaan->perusahaan_id;?>" <?php if($perusahaan_id==$perusahaan->perusahaan_id):?> selected="selected"<?php endif;?>> <?php echo $perusahaan->name;?></option>
                    <?php } ?>
                  </select>
                </div>
              <?php } else {?>
                <?php $eperusahaan_id = $user_info[0]->perusahaan_id;?>
                <div class="form-group">
                  <label for="department"><?php echo $this->lang->line('module_title_perusahaan');?></label>
                  <select class="form-control" name="perusahaan" id="aj_perusahaanx" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_title_perusahaan');?>" required>
                    <option value=""><?php echo $this->lang->line('module_title_perusahaan');?></option>
                    <?php foreach($all_perusahaans as $perusahaan) {?>
                      <?php if($eperusahaan_id == $perusahaan->perusahaan_id):?>
                        <option value="<?php echo $perusahaan->perusahaan_id;?>" <?php if($perusahaan_id==$perusahaan->perusahaan_id):?> selected="selected"<?php endif;?>> <?php echo $perusahaan->name;?></option>
                      <?php endif;?>
                    <?php } ?>
                  </select>
                </div>
              <?php } ?>
            </div>
            <div class="col-md-4">
             <?php $result = $this->Department_model->ajax_info_perusahaan_karyawan($perusahaan_id); ?>
             <?php if($option_penerima_pembayaran==1){?>
              <div class="form-group" id="ajaxx_karyawan">
                <label for="department"><?php echo $this->lang->line('umb_acc_penerima_pembayaran');?></label>
                <select id="penerima_pembayaran_id" name="penerima_pembayaran_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_acc_choose_a_penerima_pembayaran');?>">
                  <?php foreach($result as $karyawan) {?>
                    <option value="<?php echo $karyawan->user_id;?>" <?php if($penerima_pembayaran_id==$karyawan->user_id):?> selected="selected"<?php endif;?>> <?php echo $karyawan->first_name.' '.$karyawan->last_name;?></option>
                  <?php } ?>
                </select>
              </div>
            <?php } else {?>
            	<?php $penerima_pembayaran = $this->Keuangan_model->get_penerima_pembayarans();?>
              <div class="form-group" id="penerima_pembayaran_id">
                <label for="penerima_pembayaran_id"><?php echo $this->lang->line('umb_acc_penerima_pembayaran');?></label>
                <select class="form-control" name="penerima_pembayaran_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_acc_penerima_pembayaran');?>">
                  <option value=""></option>
                  <?php foreach($penerima_pembayaran->result() as $paye) {?>
                    <option value="<?php echo $paye->penerima_pembayaran_id?>" <?php if($paye->penerima_pembayaran_id==$penerima_pembayaran_id):?> selected <?php endif; ?>><?php echo $paye->nama_penerima_pembayaran;?></option>
                  <?php } ?>
                </select>
              </div>
            <?php } ?>
          </div>
        <?php } else {?>
          <input type="hidden" name="penerima_pembayaran_id" id="penerima_pembayaran_id" value="<?php echo $session['user_id'];?>" />
        <?php } ?>
        <?php $types_biaya = $this->Keuangan_model->ajax_info_types_biaya_perusahaan($perusahaan_id);?>
        <div class="col-md-4">
          <div class="form-group" id="ajaxx_kategori">
            <label for="karyawan"><?php echo $this->lang->line('umb_acc_kategori');?></label>
            <select name="kategori_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_acc_choose_kategori');?>">
              <option value=""></option>
              <?php foreach($types_biaya as $type_biaya) {?>
                <option value="<?php echo $type_biaya->type_biaya_id;?>" <?php if($kategoriid==$type_biaya->type_biaya_id):?> selected="selected"<?php endif;?>> <?php echo $type_biaya->name;?></option>
              <?php } ?>
            </select>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-5">
      <div class="form-group">
        <label for="description"><?php echo $this->lang->line('umb_description');?></label>
        <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('umb_description');?>" name="description" cols="30" rows="5" id="description2"><?php echo $description;?></textarea>
      </div>
      <div class='form-group'>
        <div>
          <label for="photo"><?php echo $this->lang->line('umb_acc_attach_file');?></label>
        </div>
        <span class="btn btn-file"> <?php echo $this->lang->line('umb_browse');?>
        <input type="file" name="file_biaya" id="file_biaya">
      </span>
      <?php if($file_biaya!='' && $file_biaya!='no_file'):?>
        <br>
        <a href="<?php echo site_url('admin/download')?>?type=accounting/biaya&filename=<?php echo $file_biaya;?>"><?php echo $this->lang->line('umb_download');?></a>
      <?php endif;?>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-3">
    <div class="form-group">
      <label for="payment_method"><?php echo $this->lang->line('umb_payment_method');?></label>
      <select name="payment_method" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_choose_payment_method');?>">
        <option value=""></option>
        <?php foreach($get_all_payment_method as $payment_method) {?>
          <option value="<?php echo $payment_method->payment_method_id;?>" <?php if($payment_method_id==$payment_method->payment_method_id):?> selected="selected"<?php endif;?>> <?php echo $payment_method->method_name;?></option>
        <?php } ?>
      </select>
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label for="reference_biaya"><?php echo $this->lang->line('umb_acc_ref_no');?></label>
      <input class="form-control" placeholder="<?php echo $this->lang->line('umb_acc_ref_example');?>" name="reference_biaya" type="text" value="<?php echo $reference_biaya;?>">
      <br />
    </div>
  </div>
</div>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-secondary" data-dismiss="modal">
    <i class="fas fa-check-square"></i> 
    <?php echo $this->lang->line('umb_close');?>
  </button>
  <button type="submit" class="btn btn-primary">
    <i class="fas fa-check-square"></i> 
    <?php echo $this->lang->line('umb_update');?>
  </button>
</div>
<?php echo form_close(); ?> 
<script type="text/javascript">
  $(document).ready(function(){ 
    $('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
    $('[data-plugin="select_hrm"]').select2({ width:'100%' });	 
    $('.d_date').bootstrapMaterialDatePicker({
      weekStart: 0,
      time: false,
      clearButton: false,
      format: 'YYYY-MM-DD'
    });
    Ladda.bind('button[type=submit]');
    jQuery("#aj_perusahaanx").change(function(){
      jQuery.get(base_url+"/get_perusahaan_types_biaya/"+jQuery(this).val(), function(data, status){
        jQuery('#ajaxx_kategori').html(data);
      });
      jQuery.get(base_url+"/get_karyawans/"+jQuery(this).val(), function(data, status){
        jQuery('#ajaxx_karyawan').html(data);
      });
    });
    $("#update_biaya").submit(function(e){
      var fd = new FormData(this);
      var obj = $(this), action = obj.attr('name');
      fd.append("is_ajax", 1);
      fd.append("edit_type", 'biaya');
      fd.append("form", action);
      e.preventDefault();
      $('.icon-spinner3').show();
      $('.save').prop('disabled', true);
      $.ajax({
        url: e.target.action,
        type: "POST",
        data:  fd,
        contentType: false,
        cache: false,
        processData:false,
        success: function(JSON)
        {
          if (JSON.error != '') {
            toastr.error(JSON.error);
            $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
            $('.save').prop('disabled', false);
            Ladda.stopAll();
          } else {
            var umb_table = $('#umb_table').dataTable({
              "bDestroy": true,
              "ajax": {
                url : "<?php echo site_url("admin/accounting/list_biaya") ?>",
                type : 'GET'
              },
              "fnDrawCallback": function(settings){
                $('[data-toggle="tooltip"]').tooltip();          
              }
            });
            umb_table.api().ajax.reload(function(){ 
              toastr.success(JSON.result);
            }, true);
            $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
            $('.icon-spinner3').hide();
            $('.edit-modal-data').modal('toggle');
            $('.save').prop('disabled', false);
            Ladda.stopAll();
          }
        },
        error: function() {
          toastr.error(JSON.error);
          $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
          $('.icon-spinner3').hide();
          $('.save').prop('disabled', false);
          Ladda.stopAll();
        } 	        
      });
    });
  });	
</script>
<?php } else if(isset($_GET['jd']) && isset($_GET['biaya_id']) && $_GET['data']=='transaksi_biaya'){
  ?>
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
    <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_edit_biaya');?></h4>
  </div>
  <?php $attributes = array('name' => 'update_biaya', 'id' => 'update_biaya', 'autocomplete' => 'off');?>
  <?php $hidden = array('_method' => 'EDIT', '_token' => $biaya_id, 'ext_name' => $biaya_id);?>
  <?php echo form_open('admin/accounting/update_biaya/'.$biaya_id, $attributes, $hidden);?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="type_award"><?php echo $this->lang->line('umb_acc_account');?></label>
          <select name="bank_cash_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_acc_choose_account_type');?>">
            <option value=""></option>
            <?php foreach($all_bank_cash as $bank_cash) {?>
              <option value="<?php echo $bank_cash->bankcash_id;?>" <?php if($type_account_id==$bank_cash->bankcash_id):?> selected="selected"<?php endif;?>><?php echo $bank_cash->nama_account;?></option>
            <?php } ?>
          </select>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="month_year"><?php echo $this->lang->line('umb_jumlah');?></label>
              <input class="form-control" name="jumlah" type="text" value="<?php echo $jumlah;?>">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="deposit_tanggal"><?php echo $this->lang->line('umb_e_details_tanggal');?></label>
              <input class="form-control d_date" placeholder="<?php echo date('Y-m-d');?>" readonly name="tanggal_biaya" type="text" value="<?php echo $tanggal_biaya;?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="karyawan"><?php echo $this->lang->line('umb_acc_kategori');?></label>
              <select name="kategori_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_acc_choose_kategori');?>">
                <option value=""></option>
                <?php foreach($all_types_biaya as $type_biaya) {?>
                  <option value="<?php echo $type_biaya->type_biaya_id;?>" <?php if($kategoriid==$type_biaya->type_biaya_id):?> selected="selected"<?php endif;?>> <?php echo $type_biaya->name;?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="karyawan"><?php echo $this->lang->line('umb_acc_penerima_pembayaran');?></label>
              <select name="penerima_pembayaran_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_acc_penerima_pembayaran');?>">
                <option value=""></option>
                <?php foreach($all_penerima_pembayarans as $penerima_pembayaran) {?>
                  <option value="<?php echo $penerima_pembayaran->customer_id;?>" <?php if($penerima_pembayaran_id==$penerima_pembayaran->customer_id):?> selected="selected"<?php endif;?>> <?php echo $penerima_pembayaran->name;?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="description"><?php echo $this->lang->line('umb_description');?></label>
          <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('umb_description');?>" name="description" cols="30" rows="5" id="description2"><?php echo $description;?></textarea>
        </div>
        <div class='form-group'>
          <div>
            <label for="photo"><?php echo $this->lang->line('umb_acc_attach_file');?></label>
          </div>
          <span class="btn btn-primary btn-file"> <?php echo $this->lang->line('umb_browse');?>
          <input type="file" name="file_biaya" id="file_biaya">
        </span>
        <?php if($file_biaya!='' && $file_biaya!='no_file'):?>
          <br>
          <a href="<?php echo site_url('admin/download')?>?type=accounting/biaya&filename=<?php echo $file_biaya;?>"><?php echo $this->lang->line('umb_download');?></a>
        <?php endif;?>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-3">
      <div class="form-group">
        <label for="payment_method"><?php echo $this->lang->line('umb_payment_method');?></label>
        <select name="payment_method" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_choose_payment_method');?>">
          <option value=""></option>
          <?php foreach($get_all_payment_method as $payment_method) {?>
            <option value="<?php echo $payment_method->payment_method_id;?>" <?php if($payment_method_id==$payment_method->payment_method_id):?> selected="selected"<?php endif;?>> <?php echo $payment_method->method_name;?></option>
          <?php } ?>
        </select>
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <label for="reference_biaya"><?php echo $this->lang->line('umb_acc_ref_no');?></label>
        <input class="form-control" placeholder="<?php echo $this->lang->line('umb_acc_ref_example');?>" name="reference_biaya" type="text" value="<?php echo $reference_biaya;?>">
        <br />
      </div>
    </div>
  </div>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-check-square"></i> <?php echo $this->lang->line('umb_close');?></button>
  <button type="submit" class="btn btn-primary"><i class="fas fa-check-square"></i> <?php echo $this->lang->line('umb_update');?></button>
</div>
<?php echo form_close(); ?> 
<script type="text/javascript">
  $(document).ready(function(){ 
    $('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
    $('[data-plugin="select_hrm"]').select2({ width:'100%' });	 
    Ladda.bind('button[type=submit]');
    $('.d_date').datepicker({
      changeMonth: true,
      changeYear: true,
      dateFormat:'yy-mm-dd',
      yearRange: '1900:' + (new Date().getFullYear() + 15),
      beforeShow: function(input) {
        $(input).datepicker("widget").show();
      }
    });
    $("#update_biaya").submit(function(e){
      var fd = new FormData(this);
      var obj = $(this), action = obj.attr('name');
      fd.append("is_ajax", 1);
      fd.append("edit_type", 'biaya');
      fd.append("form", action);
      e.preventDefault();
      $('.icon-spinner3').show();
      $('.save').prop('disabled', true);
      $.ajax({
        url: e.target.action,
        type: "POST",
        data:  fd,
        contentType: false,
        cache: false,
        processData:false,
        success: function(JSON){
          if (JSON.error != '') {
            toastr.error(JSON.error);
            $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
            $('.save').prop('disabled', false);
            Ladda.stopAll();
          } else {
            var umb_table = $('#umb_table').dataTable({
              "bDestroy": true,
              "ajax": {
                url : "<?php echo site_url("admin/accounting/list_transaksi") ?>",
                type : 'GET'
              },
              "fnDrawCallback": function(settings){
                $('[data-toggle="tooltip"]').tooltip();          
              }
            });
            umb_table.api().ajax.reload(function(){ 
              toastr.success(JSON.result);
            }, true);
            $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
            $('.icon-spinner3').hide();
            $('.edit-modal-data').modal('toggle');
            $('.save').prop('disabled', false);
            Ladda.stopAll();
          }
        },
        error: function() {
          toastr.error(JSON.error);
          $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
          $('.icon-spinner3').hide();
          $('.save').prop('disabled', false);
        } 	        
      });
    });
  });	
</script>
<?php } else if(isset($_GET['jd']) && isset($_GET['transfer_id']) && $_GET['data']=='transfer'){
  ?>
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> 
      <span aria-hidden="true">×</span> 
    </button>
    <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_edit_transfer');?></h4>
  </div>
  <?php $attributes = array('name' => 'update_transfer', 'id' => 'update_transfer', 'autocomplete' => 'off');?>
  <?php $hidden = array('_method' => 'EDIT', '_token' => $transfer_id, 'ext_name' => $transfer_id);?>
  <?php echo form_open('admin/accounting/update_transfer/'.$transfer_id, $attributes, $hidden);?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-3">
        <div class="form-group">
          <label for="bank_cash_id"><?php echo $this->lang->line('umb_acc_from_account');?></label>
          <select disabled="disabled" name="from_bank_cash_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_acc_choose_account_type');?>">
            <option value=""></option>
            <?php foreach($all_bank_cash as $bank_cash) {?>
              <option value="<?php echo $bank_cash->bankcash_id;?>" <?php if($from_account_id==$bank_cash->bankcash_id):?> selected="selected"<?php endif;?>><?php echo $bank_cash->nama_account;?></option>
            <?php } ?>
          </select>
        </div>
        <div class="form-group">
          <label for="tanggal_transfer"><?php echo $this->lang->line('umb_e_details_tanggal');?></label>
          <input class="form-control d_date" placeholder="<?php echo date('Y-m-d');?>" readonly name="tanggal_transfer" type="text" value="<?php echo $tanggal_transfer;?>">
        </div>
        <div class="form-group">
          <label for="payment_method"><?php echo $this->lang->line('umb_payment_method');?></label>
          <select name="payment_method" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_choose_payment_method');?>">
            <option value=""></option>
            <?php foreach($get_all_payment_method as $payment_method) {?>
              <option value="<?php echo $payment_method->payment_method_id;?>" <?php if($payment_method_id==$payment_method->payment_method_id):?> selected="selected"<?php endif;?>> <?php echo $payment_method->method_name;?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label for="bank_cash_id"><?php echo $this->lang->line('umb_acc_to_account');?></label>
          <select disabled="disabled" name="to_bank_cash_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_acc_choose_account_type');?>">
            <option value=""></option>
            <?php foreach($all_bank_cash as $bank_cash) {?>
              <option value="<?php echo $bank_cash->bankcash_id;?>" <?php if($to_account_id==$bank_cash->bankcash_id):?> selected="selected"<?php endif;?>><?php echo $bank_cash->nama_account;?></option>
            <?php } ?>
          </select>
        </div>
        <div class="form-group">
          <label for="month_year"><?php echo $this->lang->line('umb_jumlah');?></label>
          <input disabled="disabled" class="form-control" name="jumlah" type="text" value="<?php echo $jumlah_transfer;?>">
        </div>
        <div class="form-group">
          <label for="reference_transfer"><?php echo $this->lang->line('umb_acc_ref_no');?></label>
          <input class="form-control" placeholder="<?php echo $this->lang->line('umb_acc_ref_example');?>" name="reference_transfer" type="text" value="<?php echo $reference_transfer;?>">
          <br />
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="description"><?php echo $this->lang->line('umb_description');?></label>
          <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('umb_description');?>" name="description" cols="30" rows="15" id="description2"><?php echo $description;?></textarea>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-check-square"></i> <?php echo $this->lang->line('umb_close');?></button>
    <button type="submit" class="btn btn-primary"><i class="fas fa-check-square"></i> <?php echo $this->lang->line('umb_update');?></button>
  </div>
  <?php echo form_close(); ?> 
  <script type="text/javascript">
    $(document).ready(function(){ 
      $('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
      $('[data-plugin="select_hrm"]').select2({ width:'100%' });	 
      $('#description2').trumbowyg();
      Ladda.bind('button[type=submit]');
      $('.d_date').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat:'yy-mm-dd',
        yearRange: '1900:' + (new Date().getFullYear() + 15),
        beforeShow: function(input) {
          $(input).datepicker("widget").show();
        }
      });
      $("#update_transfer").submit(function(e){
        e.preventDefault();
        var obj = $(this), action = obj.attr('name');
        $('.save').prop('disabled', true);
        $.ajax({
          type: "POST",
          url: e.target.action,
          data: obj.serialize()+"&is_ajax=1&edit_type=transfer&form="+action,
          cache: false,
          success: function (JSON) {
            if (JSON.error != '') {
              toastr.error(JSON.error);
              $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
              $('.save').prop('disabled', false);
              Ladda.stopAll();
            } else {
              var umb_table = $('#umb_table').dataTable({
                "bDestroy": true,
                "ajax": {
                  url : "<?php echo site_url("admin/accounting/list_transfer") ?>",
                  type : 'GET'
                },
                "fnDrawCallback": function(settings){
                  $('[data-toggle="tooltip"]').tooltip();          
                }
              });
              umb_table.api().ajax.reload(function(){ 
                toastr.success(JSON.result);
              }, true);
              $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
              $('.edit-modal-data').modal('toggle');
              $('.save').prop('disabled', false);
              Ladda.stopAll();
            }
          }
        });
      });
    });	
  </script>
<?php } else if(isset($_GET['jd']) && isset($_GET['pembayar_id']) && $_GET['data']=='pembayar'){
  ?>
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
    <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_acc_edit_pembayar');?></h4>
  </div>
  <?php $attributes = array('name' => 'update_pembayar', 'id' => 'update_pembayar', 'autocomplete' => 'off');?>
  <?php $hidden = array('_method' => 'EDIT', '_token' => $pembayar_id, 'ext_name' => $nama_pembayar);?>
  <?php echo form_open('admin/accounting/update_pembayar/'.$pembayar_id, $attributes, $hidden);?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          <label for="nama_pembayar"><?php echo $this->lang->line('umb_acc_pembayar');?></label>
          <input type="text" class="form-control" name="nama_pembayar" placeholder="<?php echo $this->lang->line('umb_acc_nama_pembayar');?>" value="<?php echo $nama_pembayar;?>">
        </div>
        <div class="form-group">
          <label for="nomor_kontak"><?php echo $this->lang->line('umb_nomor_kontak');?></label>
          <input type="text" class="form-control" name="nomor_kontak" placeholder="<?php echo $this->lang->line('umb_nomor_kontak');?>" value="<?php echo $nomor_kontak;?>">
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-check-square"></i> <?php echo $this->lang->line('umb_close');?></button>
    <button type="submit" class="btn btn-primary"><i class="fas fa-check-square"></i> <?php echo $this->lang->line('umb_update');?></button>
  </div>
  <?php echo form_close(); ?> 
  <script type="text/javascript">
    $(document).ready(function(){ 
      Ladda.bind('button[type=submit]');
      $("#update_pembayar").submit(function(e){
        e.preventDefault();
        var obj = $(this), action = obj.attr('name');
        $('.save').prop('disabled', true);
        $.ajax({
          type: "POST",
          url: e.target.action,
          data: obj.serialize()+"&is_ajax=1&edit_type=pembayar&form="+action,
          cache: false,
          success: function (JSON) {
            if (JSON.error != '') {
              toastr.error(JSON.error);
              $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
              $('.save').prop('disabled', false);
              Ladda.stopAll();
            } else {
              var umb_table = $('#umb_table').dataTable({
                "bDestroy": true,
                "ajax": {
                  url : "<?php echo site_url("admin/accounting/list_pembayars") ?>",
                  type : 'GET'
                },
                "fnDrawCallback": function(settings){
                  $('[data-toggle="tooltip"]').tooltip();          
                }
              });
              umb_table.api().ajax.reload(function(){ 
                toastr.success(JSON.result);
              }, true);
              $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
              $('.add-modal-data').modal('toggle');
              $('.save').prop('disabled', false);
              Ladda.stopAll();
            }
          }
        });
      });
    });	
  </script>
<?php } else if(isset($_GET['jd']) && isset($_GET['penerima_pembayaran_id']) && $_GET['data']=='penerima_pembayaran'){
  ?>
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
    <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_acc_edit_penerima_pembayaran');?></h4>
  </div>
  <?php $attributes = array('name' => 'update_penerima_pembayaran', 'id' => 'update_penerima_pembayaran', 'autocomplete' => 'off');?>
  <?php $hidden = array('_method' => 'EDIT', '_token' => $penerima_pembayaran_id, 'ext_name' => $nama_penerima_pembayaran);?>
  <?php echo form_open('admin/accounting/update_penerima_pembayaran/'.$penerima_pembayaran_id, $attributes, $hidden);?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          <label for="nama_penerima_pembayaran"><?php echo $this->lang->line('umb_acc_penerima_pembayaran');?></label>
          <input type="text" class="form-control" name="nama_penerima_pembayaran" placeholder="<?php echo $this->lang->line('umb_acc_nama_penerima_pembayaran');?>" value="<?php echo $nama_penerima_pembayaran;?>">
        </div>
        <div class="form-group">
          <label for="nomor_kontak"><?php echo $this->lang->line('umb_nomor_kontak');?></label>
          <input type="number" class="form-control" name="nomor_kontak" placeholder="<?php echo $this->lang->line('umb_nomor_kontak');?>" value="<?php echo $nomor_kontak;?>">
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-check-square"></i> <?php echo $this->lang->line('umb_close');?></button>
    <button type="submit" class="btn btn-primary"><i class="fas fa-check-square"></i> <?php echo $this->lang->line('umb_update');?></button>
  </div>
  <?php echo form_close(); ?> 
  <script type="text/javascript">
    $(document).ready(function(){ 
      Ladda.bind('button[type=submit]');
      $("#update_penerima_pembayaran").submit(function(e){
        e.preventDefault();
        var obj = $(this), action = obj.attr('name');
        $('.save').prop('disabled', true);
        $.ajax({
          type: "POST",
          url: e.target.action,
          data: obj.serialize()+"&is_ajax=1&edit_type=penerima_pembayaran&form="+action,
          cache: false,
          success: function (JSON) {
            if (JSON.error != '') {
              toastr.error(JSON.error);
              $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
              $('.save').prop('disabled', false);
              Ladda.stopAll();
            } else {
              var umb_table = $('#umb_table').dataTable({
                "bDestroy": true,
                "ajax": {
                  url : "<?php echo site_url("admin/accounting/list_penerima_pembayarans") ?>",
                  type : 'GET'
                },
                "fnDrawCallback": function(settings){
                  $('[data-toggle="tooltip"]').tooltip();          
                }
              });
              umb_table.api().ajax.reload(function(){ 
                toastr.success(JSON.result);
              }, true);
              $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
              $('.add-modal-data').modal('toggle');
              $('.save').prop('disabled', false);
              Ladda.stopAll();
            }
          }
        });
      });
    });	
  </script>
<?php }
?>
