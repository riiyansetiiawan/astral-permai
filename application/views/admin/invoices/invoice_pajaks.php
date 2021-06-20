<?php
/* Catalog > Product Tax view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>
<?php $role_resources_ids = $this->Umb_model->user_role_resource(); ?>
<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('121',$role_resources_ids)) { ?>
      <li class="nav-item done"> <a href="<?php echo site_url('admin/invoices/');?>" data-link-data="<?php echo site_url('admin/invoices/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon fas fa-file-invoice-dollar"></span> <?php echo $this->lang->line('umb_invoices_title');?>
      <div class="text-muted small"><?php echo $this->lang->line('umb_set_up');?> <?php echo $this->lang->line('umb_invoices_title');?></div>
    </a> </li>
  <?php } ?>  
  <?php if(in_array('426',$role_resources_ids)) { ?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/invoices/calendar_invoice/');?>" data-link-data="<?php echo site_url('admin/invoices/calendar_invoice/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon fas fa-calendar-alt"></span> <?php echo $this->lang->line('umb_calendar_invoice');?>
    <div class="text-muted small"><?php echo $this->lang->line('umb_view');?> <?php echo $this->lang->line('umb_acc_calendar');?></div>
  </a> </li>
<?php } ?>
<?php if(in_array('330',$role_resources_ids)) { ?>
  <li class="nav-item done"> <a href="<?php echo site_url('admin/invoices/history_pembayarans/');?>" data-link-data="<?php echo site_url('admin/invoices/history_pembayarans/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon fas fa-file-invoice"></span> <?php echo $this->lang->line('umb_acc_pembayarans_invoice');?>
  <div class="text-muted small"><?php echo $this->lang->line('umb_view');?> <?php echo $this->lang->line('umb_acc_pembayarans_invoice');?></div>
</a> </li>
<?php } ?>
<?php if(in_array('122',$role_resources_ids)) { ?>
  <li class="nav-item active"> <a href="<?php echo site_url('admin/invoices/pajaks/');?>" data-link-data="<?php echo site_url('admin/invoices/pajaks/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon fab fa-typo3"></span> <?php echo $this->lang->line('umb_invoice_type_pajak');?>
  <div class="text-muted small"><?php echo $this->lang->line('umb_add_new');?> <?php echo $this->lang->line('umb_invoice_type_pajak');?></div>
</a> </li>
<?php } ?>
</ul>
</div>
<hr class="border-light m-0 mb-3">
<div class="row m-b-1 <?php echo $get_animate;?>">
  <?php $role_resources_ids = $this->Umb_model->user_role_resource(); ?>
  <?php if(in_array('331',$role_resources_ids)) {?>
    <div class="col-md-4">
      <div class="card">
        <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_add_new');?></strong> <?php echo $this->lang->line('umb_title_pajak');?></span> </div>
        <div class="card-body">
          <?php $attributes = array('name' => 'add_pajak', 'id' => 'umb-form', 'autocomplete' => 'off');?>
          <?php $hidden = array('user_id' => $session['user_id']);?>
          <?php echo form_open('admin/invoices/add_pajak', $attributes, $hidden);?>
          <div class="form-group">
            <label for="nama_pajak"><?php echo $this->lang->line('umb_title_nama_pajak');?></label>
            <input type="text" class="form-control" name="nama_pajak" placeholder="<?php echo $this->lang->line('umb_title_nama_pajak');?>">
          </div>
          <div class="form-group">
            <label for="nilai_pajak"><?php echo $this->lang->line('umb_title_nilai_pajak');?></label>
            <input type="text" class="form-control" name="nilai_pajak" placeholder="<?php echo $this->lang->line('umb_title_nilai_pajak');?>">
          </div>
          <div class="form-group">
            <label for="type_pajak"><?php echo $this->lang->line('umb_invoice_type_pajak');?></label>
            <select class="form-control" name="type_pajak" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_invoice_type_pajak');?>">
              <option value=""></option>
              <option value="fixed"><?php echo $this->lang->line('umb_title_fixed_pajak');?></option>
              <option value="percentage"><?php echo $this->lang->line('umb_title_percent_pajak');?></option>
            </select>
          </div>
          <div class="form-group">
            <label for="description"><?php echo $this->lang->line('umb_description');?></label>
            <textarea class="form-control" placeholder="Description<?php echo $this->lang->line('umb_description');?>" name="description" id="description"></textarea>
          </div>
          <div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrastral_form', 'type' => 'submit', 'class' => $this->Umb_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('umb_save'))); ?> </div>
          <?php echo form_close(); ?> </div>
        </div>
      </div>
      <?php $colmdval = 'col-md-8';?>
    <?php } else {?>
      <?php $colmdval = 'col-md-12';?>
    <?php } ?>
    <div class="<?php echo $colmdval;?>">
      <div class="card">
        <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_list_all');?></strong> <?php echo $this->lang->line('umb_title_pajaks');?></span> </div>
        <div class="card-body">
          <div class="card-datatable table-responsive">
            <table class="datatables-demo table table-striped table-bordered" id="umb_table">
              <thead>
                <tr>
                  <th><?php echo $this->lang->line('umb_action');?></th>
                  <th><?php echo $this->lang->line('umb_title_nama_pajak');?></th>
                  <th><?php echo $this->lang->line('umb_title_nilai_pajak');?></th>
                  <th><?php echo $this->lang->line('umb_invoice_type_pajak');?></th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
        <!-- responsive --> 
      </div>
    </div>
  </div>
