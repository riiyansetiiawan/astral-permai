<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>
<?php $role_resources_ids = $this->Umb_model->user_role_resource(); ?>
<?php
$user_info = $this->Umb_model->read_user_info($session['user_id']);
$role_user = $this->Umb_model->read_user_role_info($user_info[0]->user_role_id);
if(!is_null($role_user)){
	$role_resources_ids = explode(',',$role_user[0]->role_resources);
} else {
	$role_resources_ids = explode(',',0);	
}
?>
<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('246',$role_resources_ids)) {?>
      <li class="nav-item done"> 
        <a href="<?php echo site_url('admin/files/');?>" data-link-data="<?php echo site_url('admin/files/');?>" class="mb-3 nav-link hrastral-link"> 
          <span class="sw-icon fas fa-file-signature"></span> 
          <?php echo $this->lang->line('umb_files_manager');?>
          <div class="text-muted small"><?php echo $this->lang->line('umb_department_upload_files');?></div>
        </a> 
      </li>
    <?php } ?> 
    <?php if(in_array('442',$role_resources_ids)) {?>
      <li class="nav-item done"> 
        <a href="<?php echo site_url('admin/perusahaan/documents_resmi/');?>" data-link-data="<?php echo site_url('admin/perusahaan/documents_resmi/');?>" class="mb-3 nav-link hrastral-link"> 
          <span class="sw-icon fas fa-file-word"></span> 
          <?php echo $this->lang->line('umb_hr_documents_resmi');?>
          <div class="text-muted small"><?php echo $this->lang->line('umb_hr_documents_resmi_setup');?></div>
        </a> 
      </li>
    <?php } ?>
    <?php if(in_array('400',$role_resources_ids)) {?>
      <li class="nav-item active"> 
        <a href="<?php echo site_url('admin/karyawans/documents_kadaluarsa/');?>" data-link-data="<?php echo site_url('admin/karyawans/documents_kadaluarsa/');?>" class="mb-3 nav-link hrastral-link"> 
          <span class="sw-icon fas fa-file-export"></span> 
          <?php echo $this->lang->line('umb_e_details_exp_documents');?>
          <div class="text-muted small"><?php echo $this->lang->line('umb_e_list_exp_documents');?></div>
        </a> 
      </li>
    <?php } ?>  
  </ul>
  <hr class="border-light m-0 mb-3">
</div>
<div class="card overflow-hidden">
  <div class="row no-gutters row-bordered row-border-light">
    <div class="col-md-3 pt-0">
      <div class="list-group list-group-flush account-settings-links">
        <a class="list-group-item list-group-item-action active" data-toggle="list" href="#account-exp_documents"><?php echo $this->lang->line('umb_e_details_exp_documents');?></a>
        <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-karyawan_immigration"><?php echo $this->lang->line('umb_karyawan_immigration');?></a>
        <?php if(in_array('5',$role_resources_ids)) { ?>
          <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-documents_resmi"><?php echo $this->lang->line('umb_hr_documents_resmi');?></a>
        <?php } ?>
        <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-assets_warranty"><?php echo $this->lang->line('umb_assets_warranty');?></a>
      </div>
    </div>
    <div class="col-md-9">
      <div class="tab-content">
        <div class="tab-pane fade active show" id="account-exp_documents">
          <div class="box">
            <div class="card-header with-elements"> 
              <span class="card-header-title mr-2"> 
                <strong> <?php echo $this->lang->line('umb_list_all');?></strong> 
                <?php echo $this->lang->line('umb_e_details_exp_documents');?> 
              </span> 
            </div>
            <div class="card-body">
              <div class="box-datatable table-responsive">
                <table class="datatables-demo table table-striped table-bordered" id="umb_table_document" style="width:100%;">
                  <thead>
                    <tr>
                      <th><?php echo $this->lang->line('umb_action');?></th>
                      <th><?php echo $this->lang->line('dashboard_single_karyawan');?></th>
                      <th><?php echo $this->lang->line('umb_e_details_dtype');?></th>
                      <th><?php echo $this->lang->line('dashboard_umb_title');?></th>
                      <th>
                        <i class="fa fa-calendar"></i> 
                        <?php echo $this->lang->line('umb_e_details_doe');?>
                      </th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane fade" id="account-karyawan_immigration">
          <div class="box">
            <div class="card-header with-elements"> 
              <span class="card-header-title mr-2"> 
                <strong> <?php echo $this->lang->line('umb_list_all');?></strong> 
                <?php echo $this->lang->line('umb_karyawan_immigration');?> 
              </span> 
            </div>
            <div class="card-body">
              <div class="box-datatable table-responsive">
                <table class="datatables-demo table table-striped table-bordered" id="umb_table_imgdocument" style="width:100%;">
                  <thead>
                    <tr>
                      <th><?php echo $this->lang->line('umb_action');?></th>
                      <th><?php echo $this->lang->line('dashboard_single_karyawan');?></th>
                      <th><?php echo $this->lang->line('umb_e_details_document');?></th>
                      <th>
                        <i class="fa fa-calendar"></i> 
                        <?php echo $this->lang->line('umb_tanggal_terbit');?>
                      </th>
                      <th>
                        <i class="fa fa-calendar"></i> 
                        <?php echo $this->lang->line('umb_tanggal_kaaluarsa');?>
                      </th>
                      <th><?php echo $this->lang->line('umb_issued_by');?></th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
          </div>
        </div>
        <?php if(in_array('5',$role_resources_ids)) { ?>
          <div class="tab-pane fade" id="account-documents_resmi">
            <div class="box">
              <div class="card-header with-elements"> 
                <span class="card-header-title mr-2"> 
                  <strong> <?php echo $this->lang->line('umb_list_all');?></strong> 
                  <?php echo $this->lang->line('umb_hr_documents_resmi');?> 
                </span> 
              </div>
              <div class="card-body">
                <div class="box-datatable table-responsive">
                  <table class="datatables-demo table table-striped table-bordered" id="umb_table_perusahaan_license" style="width:100%;">
                    <thead>
                      <tr>
                        <th width="100px;"><?php echo $this->lang->line('umb_action');?></th>
                        <th><?php echo $this->lang->line('dashboard_umb_title');?></th>
                        <th><?php echo $this->lang->line('left_perusahaan');?></th>
                        <th>
                          <i class="fa fa-calendar"></i> 
                          <?php echo $this->lang->line('umb_tanggal_kaaluarsa');?>
                        </th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>
        <div class="tab-pane fade" id="account-assets_warranty">
          <div class="box">
            <div class="card-header with-elements"> 
              <span class="card-header-title mr-2"> 
                <strong> <?php echo $this->lang->line('umb_list_all');?></strong> 
                <?php echo $this->lang->line('umb_assets_warranty');?> 
              </span> 
            </div>
            <div class="card-body">
              <div class="box-datatable table-responsive">
                <table class="datatables-demo table table-striped table-bordered" id="umb_table_assets_warranty" style="width:100%;">
                  <thead>
                    <tr>
                      <th><?php echo $this->lang->line('umb_action');?></th>
                      <th>
                        <i class="fa fa-flask"></i> 
                        <?php echo $this->lang->line('umb_nama_asset');?>
                      </th>
                      <th><?php echo $this->lang->line('umb_acc_kategori');?></th>
                      <th><?php echo $this->lang->line('umb_kode_asset_perusahaan');?></th>
                      <th><?php echo $this->lang->line('umb_sedang_bekerja');?></th>
                      <th>
                        <i class="fa fa-user"></i> 
                        <?php echo $this->lang->line('umb_assets_assign_to');?>
                      </th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>