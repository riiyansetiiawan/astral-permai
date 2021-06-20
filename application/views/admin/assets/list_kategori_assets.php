<?php $session = $this->session->userdata('username');?>
<?php $role_resources_ids = $this->Umb_model->user_role_resource(); ?>
<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('25',$role_resources_ids)) {?>
      <li class="nav-item active">
        <a href="<?php echo site_url('admin/assets/');?>" data-link-data="<?php echo site_url('admin/assets/');?>" class="mb-3 nav-link hrastral-link">
          <span class="sw-icon ion ion-md-today"></span>
          <?php echo $this->lang->line('umb_assets');?>
          <div class="text-muted small"><?php echo $this->lang->line('umb_set_up');?> <?php echo $this->lang->line('umb_assets');?></div>
        </a>
      </li>
    <?php } ?>
    <?php if(in_array('26',$role_resources_ids)) {?>
      <li class="nav-item done">
        <a href="<?php echo site_url('admin/assets/kategori/');?>" data-link-data="<?php echo site_url('admin/assets/kategori/');?>" class="mb-3 nav-link hrastral-link">
          <span class="sw-icon fab fa-typo3"></span>
          <?php echo $this->lang->line('umb_acc_kategori');?>
          <div class="text-muted small"><?php echo $this->lang->line('umb_set_up');?> <?php echo $this->lang->line('umb_acc_kategori');?></div>
        </a>
      </li>
    <?php } ?>
  </ul>
</div> 
<hr class="border-light m-0 mb-3">
<div class="row m-b-1 animated fadeInRight">
  <?php if(in_array('266',$role_resources_ids)) {?>
    <div class="col-md-4">
      <div class="card">
        <div class="card-header with-elements"> 
          <span class="card-header-title mr-2">
            <strong><?php echo $this->lang->line('umb_add_new');?></strong> 
            <?php echo $this->lang->line('umb_acc_kategori');?>
          </span>
        </div>
        <div class="card-body">
          <?php $attributes = array('name' => 'add_asset_kategori', 'id' => 'umb-form', 'autocomplete' => 'off');?>
          <?php $hidden = array('user_id' => $session['user_id']);?>
          <?php echo form_open('admin/assets/add_kategori', $attributes, $hidden);?>
          <div class="form-group">
            <label for="name"><?php echo $this->lang->line('umb_name');?></label>
            <input type="text" class="form-control" name="name" placeholder="<?php echo $this->lang->line('umb_name');?>">
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
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_list_all');?></strong> <?php echo $this->lang->line('umb_kategoris');?></span>
      </div>
      <div class="card-body">
        <div class="box-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="umb_table">
            <thead>
              <tr>
                <th style="width:100px;"><?php echo $this->lang->line('umb_action');?></th>
                <th><?php echo $this->lang->line('umb_name');?></th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
