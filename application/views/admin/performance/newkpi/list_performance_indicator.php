<?php

/* Performance Indicator view

*/

?>

<?php $session = $this->session->userdata('username');?>



<div class="row match-height">

  <div class="col-md-12">

    <div class="card">

      <div class="card-header">

        <h4 class="card-title" id="basic-layout-tooltip"><?php echo $this->lang->line('umb_role_set');?> <?php echo $this->lang->line('umb_indicator');?></h4>

        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>

        <div class="heading-elements">

          <ul class="list-inline mb-0">

            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>

            <li><a data-action="close"><i class="ft-x"></i></a></li>

          </ul>

        </div>

      </div>

      <div class="card-body add-form collapse">

        <div class="card-block">

          <?php $attributes = array('name' => 'add_performance_indicator', 'id' => 'umb-form', 'autocomplete' => 'off', 'class' => 'form-hrm');?>

          <?php $hidden = array('user_id' => $session['user_id']);?>

          <?php echo form_open('admin/performance_indicator/add_indicator', $attributes, $hidden);?>

          <div class="bg-white">

            <div class="box-block">

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

              <div class="col-md-6">

                <h4 class="form-section"><?php echo $this->lang->line('umb_performance_technical_competencies');?></h4>

                <div class="row">

                  <div class="col-md-6 control-label">

                    <div class="form-group">

                      <label><?php echo $this->lang->line('umb_performance_customer_pengalaman');?></label>

                    </div>

                  </div>

                  <div class="col-md-5">

                    <div class="form-group">

                      <select name="customer_pengalaman" class="form-control">

                        <option value=""><?php echo $this->lang->line('umb_performance_none');?></option>

                        <option value="1"><?php echo $this->lang->line('umb_performance_beginner');?></option>

                        <option value="2"> <?php echo $this->lang->line('umb_performance_intermediate');?></option>

                        <option value="3"> <?php echo $this->lang->line('umb_performance_advanced');?></option>

                        <option value="4"> <?php echo $this->lang->line('umb_performance_expert');?></option>

                      </select>

                    </div>

                  </div>

                </div>

                <div class="row">

                  <div class="col-md-6 control-label">

                    <div class="form-group">

                      <label><?php echo $this->lang->line('umb_performance_marketing');?> </label>

                    </div>

                  </div>

                  <div class="col-md-5">

                    <div class="form-group">

                      <select name="marketing" class="form-control">

                        <option value=""><?php echo $this->lang->line('umb_performance_none');?></option>

                        <option value="1"> <?php echo $this->lang->line('umb_performance_beginner');?></option>

                        <option value="2"> <?php echo $this->lang->line('umb_performance_intermediate');?></option>

                        <option value="3"> <?php echo $this->lang->line('umb_performance_advanced');?></option>

                        <option value="4"> <?php echo $this->lang->line('umb_performance_expert');?></option>

                      </select>

                    </div>

                  </div>

                </div>

                <div class="row">

                  <div class="col-md-6 control-label">

                    <div class="form-group">

                      <label><?php echo $this->lang->line('umb_performance_management');?></label>

                    </div>

                  </div>

                  <div class="col-md-5">

                    <div class="form-group">

                      <select name="management" class="form-control">

                        <option value=""><?php echo $this->lang->line('umb_performance_none');?></option>

                        <option value="1"> <?php echo $this->lang->line('umb_performance_beginner');?></option>

                        <option value="2"> <?php echo $this->lang->line('umb_performance_intermediate');?></option>

                        <option value="3"> <?php echo $this->lang->line('umb_performance_advanced');?></option>

                        <option value="4"> <?php echo $this->lang->line('umb_performance_expert');?></option>

                      </select>

                    </div>

                  </div>

                </div>

                <div class="row">

                  <div class="col-md-6 control-label">

                    <div class="form-group">

                      <label><?php echo $this->lang->line('umb_performance_administration');?></label>

                    </div>

                  </div>

                  <div class="col-md-5">

                    <div class="form-group">

                      <select name="administration" class="form-control">

                        <option value=""><?php echo $this->lang->line('umb_performance_none');?></option>

                        <option value="1"> <?php echo $this->lang->line('umb_performance_beginner');?></option>

                        <option value="2"> <?php echo $this->lang->line('umb_performance_intermediate');?></option>

                        <option value="3"> <?php echo $this->lang->line('umb_performance_advanced');?></option>

                        <option value="4"> <?php echo $this->lang->line('umb_performance_expert');?></option>

                      </select>

                    </div>

                  </div>

                </div>

                <div class="row">

                  <div class="col-md-6 control-label">

                    <div class="form-group">

                      <label><?php echo $this->lang->line('umb_performance_present_skill');?></label>

                    </div>

                  </div>

                  <div class="col-md-5">

                    <div class="form-group">

                      <select name="presentation_skill" class="form-control">

                        <option value=""><?php echo $this->lang->line('umb_performance_none');?></option>

                        <option value="1"> <?php echo $this->lang->line('umb_performance_beginner');?></option>

                        <option value="2"> <?php echo $this->lang->line('umb_performance_intermediate');?></option>

                        <option value="3"> <?php echo $this->lang->line('umb_performance_advanced');?></option>

                        <option value="4"> <?php echo $this->lang->line('umb_performance_expert');?></option>

                      </select>

                    </div>

                  </div>

                </div>

                <div class="row">

                  <div class="col-md-6 control-label">

                    <div class="form-group">

                      <label><?php echo $this->lang->line('umb_performance_quality_work');?></label>

                    </div>

                  </div>

                  <div class="col-md-5">

                    <div class="form-group">

                      <select name="quality_of_work" class="form-control">

                        <option value=""><?php echo $this->lang->line('umb_performance_none');?></option>

                        <option value="1"> <?php echo $this->lang->line('umb_performance_beginner');?></option>

                        <option value="2"> <?php echo $this->lang->line('umb_performance_intermediate');?></option>

                        <option value="3"> <?php echo $this->lang->line('umb_performance_advanced');?></option>

                        <option value="4"> <?php echo $this->lang->line('umb_performance_expert');?></option>

                      </select>

                    </div>

                  </div>

                </div>

                <div class="row">

                  <div class="col-md-6 control-label">

                    <div class="form-group">

                      <label><?php echo $this->lang->line('umb_performance_efficiency');?></label>

                    </div>

                  </div>

                  <div class="col-md-5">

                    <div class="form-group">

                      <select name="efficiency" class="form-control">

                        <option value=""><?php echo $this->lang->line('umb_performance_none');?></option>

                        <option value="1"> <?php echo $this->lang->line('umb_performance_beginner');?></option>

                        <option value="2"> <?php echo $this->lang->line('umb_performance_intermediate');?></option>

                        <option value="3"> <?php echo $this->lang->line('umb_performance_advanced');?></option>

                        <option value="4"> <?php echo $this->lang->line('umb_performance_expert');?></option>

                      </select>

                    </div>

                  </div>

                </div>

              </div>

              <div class="col-md-6">

                <h4 class="form-section"><?php echo $this->lang->line('umb_performance_behv_technical_competencies');?></h4>

                <div class="row">

                  <div class="col-md-6 control-label">

                    <div class="form-group">

                      <label><?php echo $this->lang->line('umb_performance_integrity');?></label>

                    </div>

                  </div>

                  <div class="col-md-5">

                    <div class="form-group">

                      <select name="integrity" class="form-control">

                        <option value=""><?php echo $this->lang->line('umb_performance_none');?></option>

                        <option value="1"> <?php echo $this->lang->line('umb_performance_beginner');?></option>

                        <option value="2"> <?php echo $this->lang->line('umb_performance_intermediate');?></option>

                        <option value="3"> <?php echo $this->lang->line('umb_performance_advanced');?></option>

                      </select>

                    </div>

                  </div>

                </div>

                <div class="row">

                  <div class="col-md-6 control-label">

                    <div class="form-group">

                      <label><?php echo $this->lang->line('umb_performance_professionalism');?></label>

                    </div>

                  </div>

                  <div class="col-md-5">

                    <div class="form-group">

                      <select name="professionalism" class="form-control">

                        <option value=""><?php echo $this->lang->line('umb_performance_none');?></option>

                        <option value="1"> <?php echo $this->lang->line('umb_performance_beginner');?></option>

                        <option value="2"> <?php echo $this->lang->line('umb_performance_intermediate');?></option>

                        <option value="3"> <?php echo $this->lang->line('umb_performance_advanced');?></option>

                      </select>

                    </div>

                  </div>

                </div>

                <div class="row">

                  <div class="col-md-6 control-label">

                    <div class="form-group">

                      <label><?php echo $this->lang->line('umb_performance_team_work');?></label>

                    </div>

                  </div>

                  <div class="col-md-5">

                    <div class="form-group">

                      <select name="team_work" class="form-control">

                        <option value=""><?php echo $this->lang->line('umb_performance_none');?></option>

                        <option value="1"> <?php echo $this->lang->line('umb_performance_beginner');?></option>

                        <option value="2"> <?php echo $this->lang->line('umb_performance_intermediate');?></option>

                        <option value="3"> <?php echo $this->lang->line('umb_performance_advanced');?></option>

                      </select>

                    </div>

                  </div>

                </div>

                <div class="row">

                  <div class="col-md-6 control-label">

                    <div class="form-group">

                      <label><?php echo $this->lang->line('umb_performance_critical_think');?></label>

                    </div>

                  </div>

                  <div class="col-md-5">

                    <div class="form-group">

                      <select name="critical_thinking" class="form-control">

                        <option value=""><?php echo $this->lang->line('umb_performance_none');?></option>

                        <option value="1"> <?php echo $this->lang->line('umb_performance_beginner');?></option>

                        <option value="2"> <?php echo $this->lang->line('umb_performance_intermediate');?></option>

                        <option value="3"> <?php echo $this->lang->line('umb_performance_advanced');?></option>

                      </select>

                    </div>

                  </div>

                </div>

                <div class="row">

                  <div class="col-md-6 control-label">

                    <div class="form-group">

                      <label><?php echo $this->lang->line('umb_performance_conflict_manage');?></label>

                    </div>

                  </div>

                  <div class="col-md-5">

                    <div class="form-group">

                      <select name="conflict_management" class="form-control">

                        <option value=""><?php echo $this->lang->line('umb_performance_none');?></option>

                        <option value="1"> <?php echo $this->lang->line('umb_performance_beginner');?></option>

                        <option value="2"> <?php echo $this->lang->line('umb_performance_intermediate');?></option>

                        <option value="3"> <?php echo $this->lang->line('umb_performance_advanced');?></option>

                      </select>

                    </div>

                  </div>

                </div>

                <div class="row">

                  <div class="col-md-6 control-label">

                    <div class="form-group">

                      <label><?php echo $this->lang->line('umb_performance_kehadiran');?></label>

                    </div>

                  </div>

                  <div class="col-md-5">

                    <div class="form-group">

                      <select name="kehadiran" class="form-control">

                        <option value=""><?php echo $this->lang->line('umb_performance_none');?></option>

                        <option value="1"> <?php echo $this->lang->line('umb_performance_beginner');?></option>

                        <option value="2"> <?php echo $this->lang->line('umb_performance_intermediate');?></option>

                        <option value="3"> <?php echo $this->lang->line('umb_performance_advanced');?></option>

                      </select>

                    </div>

                  </div>

                </div>

                <div class="row">

                  <div class="col-md-6 control-label">

                    <div class="form-group">

                      <label><?php echo $this->lang->line('umb_performance_meet_deadline');?></label>

                    </div>

                  </div>

                  <div class="col-md-5">

                    <div class="form-group">

                      <select name="ability_to_meet_deadline" class="form-control">

                        <option value=""><?php echo $this->lang->line('umb_performance_none');?></option>

                        <option value="1"> <?php echo $this->lang->line('umb_performance_beginner');?></option>

                        <option value="2"> <?php echo $this->lang->line('umb_performance_intermediate');?></option>

                        <option value="3"> <?php echo $this->lang->line('umb_performance_advanced');?></option>

                      </select>

                    </div>

                  </div>

                </div>

              </div>

              <div class="row">

                <div class="col-md-12">

                  <div class="form-group">

                    <div class="form-actions">

                      <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('umb_save');?> </button>

                    </div>

                  </div>

                </div>

              </div>

            </div>

          </div>

          <?php echo form_close(); ?>

        </div>

      </div>

    </div>

  </div>

</div>

<section id="decimal">

  <div class="row">

    <div class="col-xs-12">

      <div class="card">

        <div class="card-header">

          <h4 class="card-title"><?php echo $this->lang->line('umb_list_all');?> <?php echo $this->lang->line('umb_performance_indicators');?></h4>

          <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>

          <div class="heading-elements">

            <ul class="list-inline mb-0">

              <li><a data-action="collapse"><i class="ft-minus"></i></a></li>

              <li><a data-action="close"><i class="ft-x"></i></a></li>

            </ul>

          </div>

        </div>

        <div class="card-body collapse in">

          <div class="card-block card-dashboard">

            <div class="table-responsive" data-pattern="priority-columns">

              <table class="table table-striped table-bordered dataTable" id="umb_table">

                <thead>

                  <tr>

                    <th><?php echo $this->lang->line('umb_action');?></th>

                    <th><?php echo $this->lang->line('dashboard_penunjukan');?></th>

                    <th><?php echo $this->lang->line('left_perusahaan');?></th>

                    <th><?php echo $this->lang->line('left_department');?></th>

                    <th><?php echo $this->lang->line('umb_ditambahkan_oleh');?></th>

                    <th><?php echo $this->lang->line('umb_created_at');?></th>

                  </tr>

                </thead>

              </table>

            </div>

          </div>

        </div>

      </div>

    </div>

  </div>

</section>

