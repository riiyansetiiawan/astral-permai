<?php
/* Performance Appraisal view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>
<?php $role_resources_ids = $this->Umb_model->user_role_resource(); ?>
<?php $system = $this->Umb_model->read_setting_info(1); ?>
<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('42',$role_resources_ids)) {?>
      <li class="nav-item active">
        <a href="<?php echo site_url('admin/performance_appraisal/');?>" data-link-data="<?php echo site_url('admin/performance_appraisal/');?>" class="mb-3 nav-link hrastral-link">
          <span class="sw-icon oi oi-aperture"></span>
          <?php echo $this->lang->line('left_performance_xappraisal');?>
          <div class="text-muted small"><?php echo $this->lang->line('umb_set_up');?> <?php echo $this->lang->line('left_performance_xappraisal');?></div>
        </a>
      </li>
    <?php } ?>
    <?php if(in_array('41',$role_resources_ids)) {?>
      <li class="nav-item done">
        <a href="<?php echo site_url('admin/performance_indicator/');?>" data-link-data="<?php echo site_url('admin/performance_indicator/');?>" class="mb-3 nav-link hrastral-link">
          <span class="sw-icon ion ion-ios-contract"></span>
          <?php echo $this->lang->line('umb_indicator');?>
          <div class="text-muted small"><?php echo $this->lang->line('umb_set_up');?> <?php echo $this->lang->line('umb_indicator');?></div>
        </a>
      </li>
    <?php } ?>
    <?php if($system[0]->performance_option == 'both') {?>
      <?php if(in_array('107',$role_resources_ids)) {?>
        <li class="nav-item done"> <a href="<?php echo site_url('admin/tujuan_tracking/');?>" data-link-data="<?php echo site_url('admin/tujuan_tracking/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon fas fa-cube"></span> <?php echo $this->lang->line('umb_hr_tujuan_tracking');?>
        <div class="text-muted small"><?php echo $this->lang->line('umb_set_up');?> <?php echo $this->lang->line('umb_hr_tujuan_tracking');?></div>
      </a> </li>
    <?php } ?>  
    <?php if(in_array('108',$role_resources_ids)) {?>
      <li class="nav-item done"> <a href="<?php echo site_url('admin/tujuan_tracking/type/');?>" data-link-data="<?php echo site_url('admin/tujuan_tracking/type/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon fab fa-typo3"></span> <?php echo $this->lang->line('umb_hr_type_tujuan_tracking_se');?>
      <div class="text-muted small"><?php echo $this->lang->line('umb_role_add');?> <?php echo $this->lang->line('umb_hr_type_tujuan_tracking_se');?></div>
    </a> </li>
  <?php } ?> 
<?php } ?>
</ul>
<hr class="border-light m-0 mb-3">
</div>  
<?php if(in_array('302',$role_resources_ids)) {?>
  <?php $user_info = $this->Umb_model->read_user_info($session['user_id']);?>
  <div class="card mb-4 <?php echo $get_animate;?>">
    <div id="accordion">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_give_performance_appraisal');?></strong></span>
        <div class="card-header-elements ml-md-auto"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
          <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('umb_add_new');?></button>
        </a> </div>
      </div>
      <div id="add_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
        <div class="card-body">
          <?php $attributes = array('name' => 'add_appraisal', 'id' => 'umb-form', 'autocomplete' => 'off');?>
          <?php $hidden = array('user_id' => $session['user_id']);?>
          <?php echo form_open('admin/performance_appraisal/add_appraisal', $attributes, $hidden);?>
          <div class="row m-b-1">
            <div class="col-md-12">
              <div class="bg-white">
                <div class="row">
                  <div class="col-md-12">
                    <?php if($user_info[0]->user_role_id==1){ ?>
                      <div class="row">
                        <div class="col-md-3 control-label">
                          <div class="form-group">
                            <label for="karyawan"><?php echo $this->lang->line('left_perusahaan');?></label>
                          </div>
                        </div>
                        <div class="col-md-5">
                          <div class="form-group">
                            <select class="form-control" name="perusahaan_id" id="aj_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_perusahaan');?>">
                              <option value=""></option>
                              <?php foreach($get_all_perusahaans as $perusahaan) {?>
                                <option value="<?php echo $perusahaan->perusahaan_id?>"><?php echo $perusahaan->name?></option>
                              <?php } ?>
                            </select>
                          </div>
                        </div>
                      </div>
                    <?php } else { ?>
                      <?php $eperusahaan_id = $user_info[0]->perusahaan_id;?>
                      <div class="row">
                        <div class="col-md-3 control-label">
                          <div class="form-group">
                            <label for="karyawan"><?php echo $this->lang->line('left_perusahaan');?></label>
                          </div>
                        </div>
                        <div class="col-md-5">
                          <div class="form-group">
                            <select class="form-control" name="perusahaan_id" id="aj_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_perusahaan');?>">
                              <option value=""></option>
                              <?php foreach($get_all_perusahaans as $perusahaan) {?>
                               <?php if($eperusahaan_id == $perusahaan->perusahaan_id):?>
                                <option value="<?php echo $perusahaan->perusahaan_id?>"><?php echo $perusahaan->name?></option>
                              <?php endif;?>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                    </div>
                  <?php } ?>
                  <div class="row">
                    <div class="col-md-3 control-label">
                      <div class="form-group">
                        <label for="karyawan"><?php echo $this->lang->line('dashboard_single_karyawan');?></label>
                      </div>
                    </div>
                    <div class="col-md-5">
                      <div class="form-group" id="ajax_karyawan">
                        <select class="select2" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_choose_an_karyawan');?>" name="karyawan_id" id="karyawan_id">
                          <option value=""></option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-3 control-label">
                      <div class="form-group">
                        <label for="month_year"><?php echo $this->lang->line('umb_select_month');?></label>
                      </div>
                    </div>
                    <div class="col-md-5">
                      <div class="form-group">
                        <input class="form-control month_year" placeholder="<?php echo $this->lang->line('umb_select_month');?>" readonly id="month_year" name="month_year" type="text">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row m-b-1">
              <div class="col-md-6">
                <div class="bg-white">
                  <table class="table table-grey-head m-md-b-0">
                    <thead>
                      <tr>
                        <th colspan="5"><?php echo $this->lang->line('umb_performance_technical_competencies');?></th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th colspan="2"><?php echo $this->lang->line('umb_indicator');?></th>
                        <th><?php echo $this->lang->line('umb_set_value');?></th>
                      </tr>
                      <?php $itechnical_competencies = explode(',',$system[0]->technical_competencies);?>
                      <?php foreach($itechnical_competencies as $itech_comp):?>
                        <tr>
                          <td scope="row" colspan="2"><?php echo $itech_comp;?></td>
                          <td><select name="technical_competencies_value[]" class="form-control">
                            <option value="0"><?php echo $this->lang->line('umb_performance_none');?></option>
                            <option value="1"> <?php echo $this->lang->line('umb_performance_beginner');?></option>
                            <option value="2"> <?php echo $this->lang->line('umb_performance_intermediate');?></option>
                            <option value="3"> <?php echo $this->lang->line('umb_performance_advanced');?></option>
                            <option value="4"> <?php echo $this->lang->line('umb_performance_expert');?></option>
                          </select></td>
                        </tr>
                      <?php endforeach;?>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="col-md-6">
                <div class="bg-white">
                  <table class="table table-grey-head m-md-b-0">
                    <thead>
                      <tr>
                        <th colspan="5"><?php echo $this->lang->line('umb_performance_behv_technical_competencies');?></th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th colspan="2"><?php echo $this->lang->line('umb_indicator');?></th>
                        <th><?php echo $this->lang->line('umb_set_value');?></th>
                      </tr>
                      <?php $iorganizational_competencies = explode(',',$system[0]->organizational_competencies);?>
                      <?php foreach($iorganizational_competencies as $iorg_comp):?>
                        <tr>
                          <td scope="row" colspan="2"><?php echo $iorg_comp;?></td>
                          <td><select name="organizational_competencies_value[]" class="form-control">
                            <option value="5"><?php echo $this->lang->line('umb_performance_none');?></option>
                            <option value="6"> <?php echo $this->lang->line('umb_performance_beginner');?></option>
                            <option value="7"> <?php echo $this->lang->line('umb_performance_intermediate');?></option>
                            <option value="8"> <?php echo $this->lang->line('umb_performance_advanced');?></option>
                          </select></td>
                        </tr>
                      <?php endforeach;?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="m-b-1">
            <div class="col-md-12">
              <div class="bg-white">
                <div class="form-group">
                  <label for="remarks"><?php echo $this->lang->line('umb_keterangan');?></label>
                  <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('umb_keterangan');?>" name="remarks" id="remarks"></textarea>
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <div class="form-actions box-footer">
                  <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('umb_save');?> </button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php echo form_close(); ?> </div>
      </div>
    </div>
  </div>
<?php } ?>
<div class="card <?php echo $get_animate;?>">
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_list_all');?></strong> <?php echo $this->lang->line('umb_performance_apps');?></span> </div>
  <div class="card-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="umb_table">
        <thead>
          <tr>
            <th><?php echo $this->lang->line('umb_action');?></th>
            <th><?php echo $this->lang->line('left_perusahaan');?></th>
            <th><i class="fa fa-user"></i> <?php echo $this->lang->line('dashboard_single_karyawan');?></th>
            <th><?php echo $this->lang->line('left_department');?></th>
            <th><?php echo $this->lang->line('dashboard_penunjukan');?></th>
            <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('umb_performance_app_date');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
<style type="text/css">
  .hide-calendar .ui-datepicker-calendar { display:none !important; }
  .hide-calendar .ui-priority-secondary { display:none !important; }
</style>
