<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>
<div class="row">
  <div class="col-md-12 <?php echo $get_animate;?>">
    <div class="ui-bordered px-4 pt-4 mb-4">
      <input type="hidden" id="user_id" value="0" />
      <?php $attributes = array('name' => 'laporan_account_statement', 'id' => 'hrm-form', 'autocomplete' => 'off');?>
      <?php $hidden = array('re_user_id' => $session['user_id']);?>
      <?php echo form_open('admin/accounting/list_laporan_statement', $attributes, $hidden);?>
      <?php
      $data = array(
        'name'        => 'user_id',
        'id'          => 'user_id',
        'type'        => 'hidden',
        'value'       => $session['user_id'],
        'class'       => 'form-control',
      );

      echo form_input($data);
      ?> 
      <div class="form-row">
        <div class="col-md mb-3">
          <label class="form-label"><?php echo $this->lang->line('umb_acc_select_account');?></label>
          <select name="account_id" id="account_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_acc_select_account');?>">
            <option value="0"><?php echo $this->lang->line('umb_acc_select_account');?></option>
            <?php foreach($all_bank_cash as $bank_cash) {?>
              <option value="<?php echo $bank_cash->bankcash_id;?>"> <?php echo $bank_cash->nama_account;?></option>
            <?php } ?>
          </select>
        </div>
        <div class="col-md mb-3">
          <div class="form-group">
            <label class="form-label"><?php echo $this->lang->line('umb_e_details_frm_date');?></label>
            <input class="form-control date" placeholder="<?php echo $this->lang->line('umb_e_details_frm_date');?>" readonly id="from_date" name="from_date" type="text" value="<?php echo date('Y-m-d')?>">
          </div>   
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="penunjukan"><?php echo $this->lang->line('umb_e_details_to_date');?></label>
            <input class="form-control date" placeholder="<?php echo $this->lang->line('umb_e_details_to_date');?>" readonly id="to_date" name="to_date" type="text" value="<?php echo date('Y-m-d')?>">
          </div>
        </div>       
        <div class="col-md col-xl-2 mb-4">
          <label class="form-label d-none d-md-block">&nbsp;</label>
          <button type="submit" class="btn btn-secondary btn-block"><?php echo $this->lang->line('umb_get');?></button>
        </div>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>
<div class="card <?php echo $get_animate;?>">
  <div class="card-header with-elements"> 
    <span class="card-header-title mr-2">
      <strong><?php echo $this->lang->line('umb_acc_account_statement');?></strong>
    </span> 
  </div>
  <div class="card-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="umb_table">
        <thead>
          <tr>
            <th><?php echo $this->lang->line('umb_e_details_tanggal');?></th>
            <th><?php echo $this->lang->line('umb_type');?></th>
            <th><?php echo $this->lang->line('umb_description');?></th>
            <th><?php echo $this->lang->line('umb_acc_credit');?></th>
            <th><?php echo $this->lang->line('umb_acc_debit');?></th>
          </tr>
        </thead>
        <tbody>
          <tr class="odd">
            <td valign="top" colspan="6" class="dataTables_empty">Tak ada data yang tersedia pada tabel ini</td>
          </tr>
        </tbody>
        <tfoot id="get_footer">
        </tfoot>
      </table>
    </div>
  </div>
</div>