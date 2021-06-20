<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>
<?php $role_resources_ids = $this->Umb_model->user_role_resource(); ?>
<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php  if(in_array('80',$role_resources_ids)) {?>
      <li class="nav-item done"> 
        <a href="<?php echo site_url('admin/accounting/penerima_pembayarans/');?>" data-link-data="<?php echo site_url('admin/accounting/penerima_pembayarans/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon fas fa-user-check"></span> 
          <?php echo $this->lang->line('umb_acc_penerima_pembayarans');?>
          <div class="text-muted small"><?php echo $this->lang->line('umb_set_up');?> <?php echo $this->lang->line('umb_acc_penerima_pembayarans');?></div>
        </a> 
      </li>
    <?php } ?>
    <?php  if(in_array('81',$role_resources_ids)) {?>
      <li class="nav-item active"> 
        <a href="<?php echo site_url('admin/accounting/pembayars/');?>" data-link-data="<?php echo site_url('admin/accounting/pembayars/');?>" class="mb-3 nav-link hrastral-link"> 
          <span class="sw-icon fas fa-user-plus"></span> 
          <?php echo $this->lang->line('umb_acc_pembayars');?>
          <div class="text-muted small"><?php echo $this->lang->line('umb_set_up');?> <?php echo $this->lang->line('umb_acc_pembayars');?></div>
        </a> 
      </li>
    <?php } ?> 
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<div class="row m-b-1 <?php echo $get_animate;?>">
  <?php if(in_array('367',$role_resources_ids)) {?>
    <div class="col-md-4">
      <div class="card">
        <div class="card-header with-elements"> 
          <span class="card-header-title mr-2">
            <strong><?php echo $this->lang->line('umb_add_new');?></strong> 
            <?php echo $this->lang->line('umb_acc_pembayar');?>
          </span> 
        </div>
        <div class="card-body">
          <?php $attributes = array('name' => 'add_pembayar', 'id' => 'umb-form', 'autocomplete' => 'off');?>
          <?php $hidden = array('user_id' => $session['user_id']);?>
          <?php echo form_open('admin/accounting/add_pembayar', $attributes, $hidden);?>
          <div class="form-group">
            <label for="nama_account"><?php echo $this->lang->line('umb_acc_pembayar');?></label>
            <input type="text" class="form-control" name="nama_pembayar" placeholder="<?php echo $this->lang->line('umb_acc_nama_pembayar');?>">
          </div>
          <div class="form-group">
            <label for="saldo_account"><?php echo $this->lang->line('umb_nomor_kontak');?></label>
            <input type="text" class="form-control" name="nomor_kontak" placeholder="<?php echo $this->lang->line('umb_nomor_kontak');?>">
          </div>
          <div class="form-actions box-footer">
            <button type="submit" class="btn btn-primary"> 
              <i class="fa fa-check-square-o"></i> 
              <?php echo $this->lang->line('umb_save');?> 
            </button>
          </div>
          <?php echo form_close(); ?> 
        </div>
      </div>
    </div>
    <?php $colmdval = 'col-md-8';?>
  <?php } else {?>
    <?php $colmdval = 'col-md-12';?>
  <?php } ?>
  <div class="<?php echo $colmdval;?>">
    <div class="card">
      <div class="card-header with-elements"> 
        <span class="card-header-title mr-2">
          <strong><?php echo $this->lang->line('umb_list_all');?></strong> 
          <?php echo $this->lang->line('umb_acc_pembayars');?>
        </span> 
      </div>
      <div class="card-body">
        <div class="box-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="umb_table">
            <thead>
              <tr>
                <th><?php echo $this->lang->line('umb_action');?></th>
                <th><?php echo $this->lang->line('umb_acc_pembayar');?></th>
                <th><?php echo $this->lang->line('umb_nomor_kontak');?></th>
                <th><?php echo $this->lang->line('umb_acc_created_at');?></th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
