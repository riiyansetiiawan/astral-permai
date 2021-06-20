<?php
/* perusahaan view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>
<?php $role_resources_ids = $this->Umb_model->user_role_resource(); ?>

<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('246',$role_resources_ids)) {?>
      <li class="nav-item done"> <a href="<?php echo site_url('admin/files/');?>" data-link-data="<?php echo site_url('admin/files/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon fas fa-file-signature"></span> <?php echo $this->lang->line('umb_files_manager');?>
      <div class="text-muted small"><?php echo $this->lang->line('umb_department_upload_files');?></div>
    </a> </li>
  <?php } ?> 
  <?php if(in_array('442',$role_resources_ids)) {?>
    <li class="nav-item active"> <a href="<?php echo site_url('admin/perusahaan/documents_resmi/');?>" data-link-data="<?php echo site_url('admin/perusahaan/documents_resmi/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon fas fa-file-word"></span> <?php echo $this->lang->line('umb_hr_documents_resmi');?>
    <div class="text-muted small"><?php echo $this->lang->line('umb_hr_documents_resmi_setup');?></div>
  </a> </li>
<?php } ?>
<?php if(in_array('400',$role_resources_ids)) {?>
  <li class="nav-item done"> <a href="<?php echo site_url('admin/karyawans/documents_kadaluarsa/');?>" data-link-data="<?php echo site_url('admin/karyawans/documents_kadaluarsa/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon fas fa-file-export"></span> <?php echo $this->lang->line('umb_e_details_exp_documents');?>
  <div class="text-muted small"><?php echo $this->lang->line('umb_e_list_exp_documents');?></div>
</a> </li>
<?php } ?>  
</ul>
<hr class="border-light m-0 mb-3">
</div>
<?php if(in_array('246',$role_resources_ids)) {?>
  <?php $user_info = $this->Umb_model->read_user_info($session['user_id']);?>
  <div class="card mb-4">
    <div id="accordion">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_add_new');?></strong> <?php echo $this->lang->line('umb_e_details_document');?></span>
        <div class="card-header-elements ml-md-auto"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
          <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('umb_add_new');?></button>
        </a> </div>
      </div>
      <div id="add_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
        <div class="card-body">
          <?php $attributes = array('name' => 'add_document_resmi', 'id' => 'umb-form', 'autocomplete' => 'off');?>
          <?php $hidden = array('user_id' => $session['user_id']);?>
          <?php echo form_open_multipart('admin/perusahaan/add_document_resmi', $attributes, $hidden);?>
          <div class="form-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="nama_license"><?php echo $this->lang->line('umb_hr_official_nama_license');?></label>
                  <input class="form-control" placeholder="<?php echo $this->lang->line('umb_hr_official_nama_license');?>" name="nama_license" type="text">
                </div>
                <div class="form-group">
                  <div class="row">
                    <?php if($user_info[0]->user_role_id==1){ ?>
                      <div class="col-md-6">
                        <label for="perusahaan_id"><?php echo $this->lang->line('left_perusahaan');?></label>
                        <select class="form-control" name="perusahaan_id" data-plugin="umb_select" data-placeholder="<?php echo $this->lang->line('left_perusahaan');?>">
                          <option value=""><?php echo $this->lang->line('left_perusahaan');?></option>
                          <?php foreach($get_all_perusahaans as $perusahaan) {?>
                            <option value="<?php echo $perusahaan->perusahaan_id?>"><?php echo $perusahaan->name?></option>
                          <?php } ?>
                        </select>
                      </div>
                    <?php } else {?>
                      <?php $eperusahaan_id = $user_info[0]->perusahaan_id;?>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="perusahaan_id"><?php echo $this->lang->line('left_perusahaan');?></label>
                          <select class="form-control" name="perusahaan_id" data-plugin="umb_select" data-placeholder="<?php echo $this->lang->line('left_perusahaan');?>">
                            <option value=""><?php echo $this->lang->line('left_perusahaan');?></option>
                            <?php foreach($get_all_perusahaans as $perusahaan) {?>
                              <?php if($eperusahaan_id == $perusahaan->perusahaan_id):?>
                                <option value="<?php echo $perusahaan->perusahaan_id?>"><?php echo $perusahaan->name?></option>
                              <?php endif;?>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                    <?php } ?>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="tanggal_kaaluarsa"><?php echo $this->lang->line('umb_tanggal_kaaluarsa');?></label>
                        <input class="form-control date" placeholder="<?php echo $this->lang->line('umb_tanggal_kaaluarsa');?>" name="tanggal_kaaluarsa" type="text">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="scan_file"><?php echo $this->lang->line('umb_hr_official_license_scan');?></label>
                        <fieldset class="form-group">
                          <input type="file" class="form-control-file" id="scan_file" name="scan_file">
                          <small><?php echo $this->lang->line('umb_perusahaan_file_type');?></small>
                        </fieldset>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="relation"><?php echo $this->lang->line('umb_e_details_dtype');?></label>
                      <select name="type_document_id" id="type_document_id" class="form-control" data-plugin="umb_select" data-placeholder="<?php echo $this->lang->line('umb_e_details_choose_dtype');?>">
                        <option value=""><?php echo $this->lang->line('umb_e_details_choose_dtype');?></option>
                        <?php foreach($all_types_document as $type_document) {?>
                          <option value="<?php echo $type_document->type_document_id;?>"> <?php echo $type_document->type_document;?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="nomor_license"><?php echo $this->lang->line('umb_hr_official_nomor_license');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('umb_hr_official_nomor_license');?>" name="nomor_license" type="text">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="umb_pjkprmth"><?php echo $this->lang->line('umb_hr_official_license_alarm');?></label>
                  <select class="form-control" name="license_notification" data-plugin="umb_select" data-placeholder="<?php echo $this->lang->line('umb_hr_official_license_alarm');?>">
                    <option value="0"><?php echo $this->lang->line('umb_hr_license_no_alarm');?></option>
                    <option value="1"><?php echo $this->lang->line('umb_hr_license_alarm_1');?></option>
                    <option value="3"><?php echo $this->lang->line('umb_hr_license_alarm_3');?></option>
                    <option value="6"><?php echo $this->lang->line('umb_hr_license_alarm_6');?></option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="form-actions box-footer">
            <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('umb_save');?> </button>
          </div>
          <?php echo form_close(); ?> </div>
        </div>
      </div>
    </div>
  <?php } ?>
  <div class="card">
    <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('umb_list_all');?></strong> <?php echo $this->lang->line('umb_hr_documents_resmi');?> </span> </div>
    <div class="card-body">
      <div class="box-datatable table-responsive">
        <table class="datatables-demo table table-striped table-bordered" id="umb_table">
          <thead>
            <tr>
              <th width="100px;"><?php echo $this->lang->line('umb_action');?></th>
              <th><?php echo $this->lang->line('umb_e_details_dtype');?></th>
              <th><?php echo $this->lang->line('dashboard_umb_title');?></th>
              <th><?php echo $this->lang->line('left_perusahaan');?></th>
              <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('umb_tanggal_kaaluarsa');?></th>
              <th><i class="fa fa-bell"></i> <?php echo $this->lang->line('header_notifications');?></th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
