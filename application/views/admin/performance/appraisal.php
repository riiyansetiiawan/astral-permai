<?php
/* Appraisal
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $user = $this->Umb_model->read_user_info($session['user_id']);?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>
<?php $role_resources_ids = $this->Umb_model->user_role_resource(); ?>
<?php $system = $this->Umb_model->read_setting_info(1); ?>
<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <li class="nav-item active">
      <a href="#smartwizard-2-step-1" class="mb-3 nav-link">
        <span class="sw-done-icon ion ion-md-checkmark"></span>
        <span class="sw-icon ion ion-ios-keypad"></span>
        <?php echo $this->lang->line('left_performance_xappraisal');?>
        <div class="text-muted small">Set up shortcuts</div>
      </a>
    </li>
    <li class="nav-item done">
      <a href="#smartwizard-2-step-2" class="mb-3 nav-link">
        <span class="sw-done-icon ion ion-md-checkmark"></span>
        <span class="sw-icon ion ion-ios-color-wand"></span>
        <?php echo $this->lang->line('umb_indicator');?>
        <div class="text-muted small">Add effects</div>
      </a>
    </li>
  </ul>
  <hr class="border-light m-0">
  <div class="mb-3 sw-container tab-content">
    <div id="smartwizard-2-step-1" class="animated fadeIn tab-pane step-content mt-3" style="display: block;">
      <?php if(in_array('302',$role_resources_ids)) {?>
        <div class="card mb-4">
          <div id="accordion">
            <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_give_performance_appraisal');?></strong></span>
              <div class="card-header-elements ml-md-auto">
                <a class="text-dark collapsed" data-toggle="collapse" href="#add_appraisal_form" aria-expanded="false">
                  <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('umb_add_new');?></button>
                </a> </div>
              </div>
              <div id="add_appraisal_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
                <div class="card-body">
                  <?php $attributes = array('name' => 'add_appraisal', 'id' => 'umb-form', 'autocomplete' => 'off');?>
                  <?php $hidden = array('user_id' => $session['user_id']);?>
                  <?php echo form_open('admin/performance_appraisal/add_appraisal', $attributes, $hidden);?>
                  <div class="row m-b-1">
                    <div class="col-md-12">
                      <div class="bg-white">
                        <div class="row">
                          <div class="col-md-12">
                            <?php if($user[0]->user_role_id==1){ ?>
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
                              <?php $eperusahaan_id = $user[0]->perusahaan_id;?>
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
          <div class="card">
            <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_list_all');?></strong> <?php echo $this->lang->line('umb_performance_apps');?></span>
            </div>
            <div class="card-body">
              <div class="box-datatable table-responsive">
                <table class="datatables-demo table table-striped table-bordered" id="umb_appraisal_table">
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
        </div>
        <div id="smartwizard-2-step-2" class="animated fadeIn tab-pane step-content mt-3">
          <?php if(in_array('298',$role_resources_ids)) {?>
            <div class="card mb-4>">
              <div id="accordion">
                <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_role_set');?></strong> <?php echo $this->lang->line('umb_indicator');?></span>
                  <div class="card-header-elements ml-md-auto">
                    <a class="text-dark collapsed" data-toggle="collapse" href="#add_indicator_form" aria-expanded="false">
                      <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('umb_add_new');?></button>
                    </a> </div>
                  </div>
                  <div id="add_indicator_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
                    <div class="card-body">
                      <?php $attributes = array('name' => 'add_performance_indicator', 'id' => 'umb-form', 'autocomplete' => 'off', 'class' => 'form-hrm');?>
                      <?php $hidden = array('user_id' => $session['user_id']);?>
                      <?php echo form_open('admin/performance_indicator/add_indicator', $attributes, $hidden);?>
                      <div class="bg-white">
                        <div class="box-block">
                          <?php if($user[0]->user_role_id==1){ ?>
                            <div class="row">
                              <div class="col-md-3 control-label">
                                <div class="form-group">
                                  <label for="left_perusahaan"><?php echo $this->lang->line('left_perusahaan');?></label>
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
                          <?php } else {?>
                            <?php $eperusahaan_id = $user[0]->perusahaan_id;?>
                            <div class="row">
                              <div class="col-md-3 control-label">
                                <div class="form-group">
                                  <label for="left_perusahaan"><?php echo $this->lang->line('left_perusahaan');?></label>
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
                                <label for="penunjukan"><?php echo $this->lang->line('dashboard_penunjukan');?></label>
                              </div>
                            </div>
                            <div class="col-md-5">
                              <div class="form-group" id="penunjukan_ajax">
                                <select class="select2" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_select_penunjukan');?>" name="penunjukan_id">
                                  <option value=""></option>
                                </select>
                              </div>
                            </div>
                          </div>
                          
                          <div class="row">
                            <div class="col-md-6">
                              <h4 class="form-section"><?php echo $this->lang->line('umb_performance_technical_competencies');?></h4>
                              <?php $itechnical_competencies = explode(',',$system[0]->technical_competencies);?>
                              <?php foreach($itechnical_competencies as $itech_comp):?>
                                <div class="row">
                                  <div class="col-md-6 control-label">
                                    <div class="form-group">
                                      <p><?php echo $itech_comp;?></p>
                                    </div>
                                  </div>
                                  <div class="col-md-5">
                                    <div class="form-group">
                                      <select name="technical_competencies_value[]" class="form-control">
                                        <option value="0"><?php echo $this->lang->line('umb_performance_none');?></option>
                                        <option value="1"> <?php echo $this->lang->line('umb_performance_beginner');?></option>
                                        <option value="2"> <?php echo $this->lang->line('umb_performance_intermediate');?></option>
                                        <option value="3"> <?php echo $this->lang->line('umb_performance_advanced');?></option>
                                        <option value="4"> <?php echo $this->lang->line('umb_performance_expert');?></option>
                                      </select>
                                    </div>
                                  </div>
                                </div>
                              <?php endforeach;?>
                            </div>
                            <div class="col-md-6">
                              <h4 class="form-section"><?php echo $this->lang->line('umb_performance_behv_technical_competencies');?></h4>
                              <?php $iorganizational_competencies = explode(',',$system[0]->organizational_competencies);?>
                              <?php foreach($iorganizational_competencies as $iorg_comp):?>
                                <div class="row">
                                  <div class="col-md-6 control-label">
                                    <div class="form-group">
                                      <p><?php echo $iorg_comp;?></p>
                                    </div>
                                  </div>
                                  <div class="col-md-5">
                                    <div class="form-group">
                                      <select name="organizational_competencies_value[]" class="form-control">
                                        <option value="5"><?php echo $this->lang->line('umb_performance_none');?></option>
                                        <option value="6"> <?php echo $this->lang->line('umb_performance_beginner');?></option>
                                        <option value="7"> <?php echo $this->lang->line('umb_performance_intermediate');?></option>
                                        <option value="8"> <?php echo $this->lang->line('umb_performance_advanced');?></option>
                                      </select>
                                    </div>
                                  </div>
                                </div>
                              <?php endforeach;?>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-12">
                              <div class="form-group">
                                <div class="form-actions box-footer">
                                  <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('umb_save');?> </button>
                                </div>
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
              <div class="card">
                <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_list_all');?></strong> <?php echo $this->lang->line('umb_performance_indicators');?></span>
                </div>
                <div class="card-body">
                  <div class="box-datatable table-responsive">
                    <table class="datatables-demo table table-striped table-bordered" id="umb_indicator_table">
                      <thead>
                        <tr>
                          <th><?php echo $this->lang->line('umb_action');?></th>
                          <th><?php echo $this->lang->line('dashboard_penunjukan');?></th>
                          <th><?php echo $this->lang->line('left_perusahaan');?></th>
                          <th><?php echo $this->lang->line('left_department');?></th>
                          <th><i class="fa fa-user"></i> <?php echo $this->lang->line('umb_ditambahkan_oleh');?></th>
                          <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('umb_created_at');?></th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
            </div>    
          </div>
        </div>