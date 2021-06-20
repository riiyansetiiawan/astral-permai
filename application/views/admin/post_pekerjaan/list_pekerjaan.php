<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>
<?php $role_resources_ids = $this->Umb_model->user_role_resource(); ?>
<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('49',$role_resources_ids)) { ?>
      <li class="nav-item active"> <a href="<?php echo site_url('admin/post_pekerjaan/');?>" data-link-data="<?php echo site_url('admin/post_pekerjaan/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon fas fa-newspaper"></span> <?php echo $this->lang->line('left_post_pekerjaan');?>
      <div class="text-muted small"><?php echo $this->lang->line('umb_role_create');?> <?php echo $this->lang->line('header_frontend_apply_pekerjaans');?></div>
    </a> </li>
  <?php } ?>  
  <?php if(in_array('51',$role_resources_ids)) { ?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/kandidats_pekerjaan/');?>" data-link-data="<?php echo site_url('admin/kandidats_pekerjaan/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon fas fa-user-friends"></span> <?php echo $this->lang->line('left_kandidats_pekerjaan');?>
    <div class="text-muted small"><?php echo $this->lang->line('umb_view');?> <?php echo $this->lang->line('left_kandidats_pekerjaan');?></div>
  </a> </li>
<?php } ?>  
<?php if(in_array('52',$role_resources_ids)) { ?>
  <li class="nav-item done"> <a href="<?php echo site_url('admin/post_pekerjaan/employer/');?>" data-link-data="<?php echo site_url('admin/post_pekerjaan/employer/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon fas fa-user-ninja"></span> <?php echo $this->lang->line('umb_employer_pekerjaans');?>
  <div class="text-muted small"><?php echo $this->lang->line('umb_role_add');?> <?php echo $this->lang->line('umb_employer_pekerjaans');?></div>
</a> </li>
<?php } ?>  
<?php if(in_array('296',$role_resources_ids)) { ?>
  <li class="nav-item done"> <a href="<?php echo site_url('admin/post_pekerjaan/pages/');?>" data-link-data="<?php echo site_url('admin/post_pekerjaan/pages/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon ion ion-ios-paper"></span> <?php echo $this->lang->line('umb_cms_pages_pekerjaans');?>
  <div class="text-muted small"><?php echo $this->lang->line('umb_update');?> <?php echo $this->lang->line('umb_cms_pages_pekerjaans');?></div>
</a> </li>
<?php } ?> 
</ul>
</div>
<hr class="border-light m-0 mb-3">
<?php if(in_array('291',$role_resources_ids)) {?>
  <?php
  $all_employers = $this->Recruitment_model->get_all_employers();
  $all_types_pekerjaan = $this->Umb_model->get_type_pekerjaan();
  $all_kategoris_pekerjaan = $this->Recruitment_model->all_kategoris_pekerjaan();
  ?>
  <div class="card mb-4 <?php echo $get_animate;?>">
    <div id="accordion">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_add_new');?></strong> <?php echo $this->lang->line('umb_pekerjaan');?></span>
        <div class="card-header-elements ml-md-auto"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
          <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('umb_add_new');?></button>
        </a> </div>
      </div>
      <div id="add_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
        <div class="card-body">
          <?php $attributes = array('name' => 'add_pekerjaan', 'id' => 'umb-form', 'autocomplete' => 'off');?>
          <?php $hidden = array('_user' => $session['user_id']);?>
          <?php echo form_open('admin/post_pekerjaan/add_pekerjaan', $attributes, $hidden);?>
          <div class="bg-white">
            <div class="box-block">
              <div class="row">
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="nama_perusahaan"><?php echo $this->lang->line('umb_employer_pekerjaans');?></label>
                        <select class="form-control" name="user_id" id="user_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_employer_pekerjaans');?>">
                          <option value=""><?php echo $this->lang->line('umb_select_one');?></option>
                          <?php foreach($all_employers as $employer) {?>
                            <option value="<?php echo $employer->user_id;?>"> <?php echo $employer->first_name.' '.$employer->last_name;?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="title"><?php echo $this->lang->line('umb_e_details_jtitle');?></label>
                        <input class="form-control" placeholder="<?php echo $this->lang->line('umb_e_details_jtitle');?>" name="title_pekerjaan" type="text" value="">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="type_pekerjaan"><?php echo $this->lang->line('umb_type_pekerjaan');?></label>
                        <select class="form-control" name="type_pekerjaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_type_pekerjaan');?>">
                          <option value=""></option>
                          <?php foreach($all_types_pekerjaan->result() as $itype_pekerjaan) {?>
                            <option value="<?php echo $itype_pekerjaan->type_pekerjaan_id;?>"><?php echo $itype_pekerjaan->type;?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="penunjukan"><?php echo $this->lang->line('umb_acc_kategori');?></label>
                        <select class="form-control" name="kategori_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_acc_kategori');?>">
                          <option value=""></option>
                          <?php foreach($all_kategoris_pekerjaan as $kategori):?>
                            <option value="<?php echo $kategori->kategori_id;?>"><?php echo $kategori->nama_kategori;?></option>
                          <?php endforeach;?>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="vacancy"><?php echo $this->lang->line('umb_number_of_positions');?></label>
                        <input class="form-control" placeholder="<?php echo $this->lang->line('umb_number_of_positions');?>" name="vacancy" type="text" value="">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="is_featured"><?php echo $this->lang->line('umb_pekerjaan_is_featured');?></label>
                        <select class="form-control" name="is_featured" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_pekerjaan_is_featured');?>">
                          <option value="1"><?php echo $this->lang->line('umb_yes');?></option>
                          <option value="0"><?php echo $this->lang->line('umb_no');?></option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="status"><?php echo $this->lang->line('dashboard_umb_status');?></label>
                        <select class="form-control" name="status" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('dashboard_umb_status');?>">
                          <option value="1"><?php echo $this->lang->line('umb_published');?></option>
                          <option value="2"><?php echo $this->lang->line('umb_unpublished');?></option>
                        </select>
                      </div>
                    </div>
                    
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="tanggal_penutupan" class="control-label"><?php echo $this->lang->line('umb_tanggal_penutupan');?></label>
                        <input class="form-control date" placeholder="<?php echo $this->lang->line('umb_tanggal_penutupan');?>" readonly name="tanggal_penutupan" type="text" value="">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="jenis_kelamin"><?php echo $this->lang->line('umb_jenis_kelamin_karyawan');?></label>
                        <select class="form-control" name="jenis_kelamin" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_jenis_kelamin_karyawan');?>">
                          <option value="0"><?php echo $this->lang->line('umb_jenis_kelamin_pria');?></option>
                          <option value="1"><?php echo $this->lang->line('umb_jenis_kelamin_perempuan');?></option>
                          <option value="2"><?php echo $this->lang->line('umb_pekerjaan_no_preference');?></option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="pengalaman" class="control-label"><?php echo $this->lang->line('umb_pekerjaan_minimum_pengalaman');?></label>
                        <select class="form-control" name="pengalaman" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_pekerjaan_minimum_pengalaman');?>">
                          <option value="0"><?php echo $this->lang->line('umb_fresh_pekerjaan');?></option>
                          <option value="1"><?php echo $this->lang->line('umb_pengalaman_pekerjaan_define_1year');?></option>
                          <option value="2"><?php echo $this->lang->line('umb_pengalaman_pekerjaan_define_2years');?></option>
                          <option value="3"><?php echo $this->lang->line('umb_pengalaman_pekerjaan_define_3years');?></option>
                          <option value="4"><?php echo $this->lang->line('umb_pengalaman_pekerjaan_define_4years');?></option>
                          <option value="5"><?php echo $this->lang->line('umb_pengalaman_pekerjaan_define_5years');?></option>
                          <option value="6"><?php echo $this->lang->line('umb_pengalaman_pekerjaan_define_6years');?></option>
                          <option value="7"><?php echo $this->lang->line('umb_pengalaman_pekerjaan_define_7years');?></option>
                          <option value="8"><?php echo $this->lang->line('umb_pengalaman_pekerjaan_define_8years');?></option>
                          <option value="9"><?php echo $this->lang->line('umb_pengalaman_pekerjaan_define_9years');?></option>
                          <option value="10"><?php echo $this->lang->line('umb_pengalaman_pekerjaan_define_10years');?></option>
                          <option value="11"><?php echo $this->lang->line('umb_pengalaman_pekerjaan_define_plus_10years');?></option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="long_description"><?php echo $this->lang->line('umb_long_description');?></label>
                    <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('umb_long_description');?>" name="long_description" cols="" rows="10" id="long_description"></textarea>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="short_description"><?php echo $this->lang->line('umb_short_description');?></label>
                <textarea class="form-control" placeholder="<?php echo $this->lang->line('umb_short_description');?>" name="short_description" cols="30" rows="3"></textarea>
              </div>
              <div class="form-actions box-footer">
                <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('umb_save');?> </button>
              </div>
            </div>
          </div>
          <?php echo form_close(); ?> </div>
        </div>
      </div>
    </div>
  <?php } ?>
  <div class="card <?php echo $get_animate;?>">
    <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_list_all');?></strong> <?php echo $this->lang->line('umb_pekerjaans');?></span>
      <div class="card-header-elements ml-md-auto"> <a class="text-dark" href="<?php echo site_url('pekerjaans');?>" target="_blank">
        <button type="button" class="btn btn-xs btn-primary"> <span class="fa fa-eye"></span> <?php echo $this->lang->line('left_pekerjaans_terbaru');?></button>
      </a> </div>
    </div>
    <div class="card-body">
      <div class="box-datatable table-responsive">
        <table class="datatables-demo table table-striped table-bordered" id="umb_table">
          <thead>
            <tr>
              <th><?php echo $this->lang->line('umb_action');?></th>
              <th ><?php echo $this->lang->line('dashboard_position');?></th>
              <th><?php echo $this->lang->line('umb_employer_pekerjaans');?></th>
              <th><?php echo $this->lang->line('umb_tanggal_posting');?></th>
              <th><?php echo $this->lang->line('dashboard_umb_status');?></th>
              <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('umb_closing_date');?></th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
  <style type="text/css">.trumbowyg-box, .trumbowyg-editor { min-height: 175px; }</style>