<?php
/* Projects List view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>
<?php $role_resources_ids = $this->Umb_model->user_role_resource(); ?>
<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('415',$role_resources_ids)) { ?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/quotes/');?>" data-link-data="<?php echo site_url('admin/quotes/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon fa fa-tasks"></span> <?php echo $this->lang->line('umb_estimates');?>
      <div class="text-muted small"><?php echo $this->lang->line('umb_create_quote');?></div>
      </a> </li>
    <?php } ?>  
    <?php if(in_array('427',$role_resources_ids)) { ?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/quoted_projects/quote_calendar/');?>" data-link-data="<?php echo site_url('admin/quoted_projects/quote_calendar/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon fas fa-calendar-alt"></span> <?php echo $this->lang->line('umb_quote_calendar');?>
      <div class="text-muted small"><?php echo $this->lang->line('umb_view');?> <?php echo $this->lang->line('umb_quote_calendar');?></div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('429',$role_resources_ids)) { ?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/leads/');?>" data-link-data="<?php echo site_url('admin/leads/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon fas fa-user-check"></span> <?php echo $this->lang->line('umb_leads');?>
      <div class="text-muted small"><?php echo $this->lang->line('umb_role_add');?> <?php echo $this->lang->line('umb_leads');?></div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('430',$role_resources_ids)) { ?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/quoted_projects/timelogs/');?>" data-link-data="<?php echo site_url('admin/quoted_projects/timelogs/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon fas fa-user-clock"></span> <?php echo $this->lang->line('umb_project_timelogs');?>
      <div class="text-muted small"><?php echo $this->lang->line('umb_role_add');?> <?php echo $this->lang->line('umb_project_timelogs');?></div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('428',$role_resources_ids)) { ?>
    <li class="nav-item active"> <a href="<?php echo site_url('admin/quoted_projects/');?>" data-link-data="<?php echo site_url('admin/quoted_projects/');?>" class="mb-3 nav-link hrastral-link"> <span class="sw-icon ion ion-logo-buffer"></span> <?php echo $this->lang->line('umb_quoted_projects');?>
      <div class="text-muted small"><?php echo $this->lang->line('umb_role_add');?> <?php echo $this->lang->line('umb_quoted_projects');?></div>
      </a> </li>
    <?php } ?>
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<?php $role_resources_ids = $this->Umb_model->user_role_resource(); ?>
<?php if(in_array('315',$role_resources_ids)) {?>
<?php $user_info = $this->Umb_model->read_user_info($session['user_id']);?>
<?php $no_project = $this->Umb_model->generate_random_string();?>
<div class="card mb-4 <?php echo $get_animate;?>">
  <div id="accordion">
    <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_add_new');?></strong> <?php echo $this->lang->line('umb_project');?></span>
      <div class="card-header-elements ml-md-auto"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('umb_add_new');?></button>
        </a> </div>
    </div>
    <div id="add_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
      <div class="card-body">
        <?php $attributes = array('name' => 'add_project', 'id' => 'umb-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open('admin/quoted_project/add_project', $attributes, $hidden);?>
        <div class="bg-white">
          <div class="box-block">
            <div class="row">
              <div class="col-md-6">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                          <label for="title"><?php echo $this->lang->line('umb_title');?></label>
                          <input class="form-control" placeholder="<?php echo $this->lang->line('umb_title');?>" name="title" type="text">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                          <label for="no_project"><?php echo $this->lang->line('umb_quoted_no_project');?></label>
                          <input class="form-control" placeholder="<?php echo $this->lang->line('umb_quoted_no_project');?>" name="no_project" type="text" value="<?php echo $no_project;?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="client_id"><?php echo $this->lang->line('umb_project_client');?></label>
                      <select name="client_id" id="client_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_project_client');?>">
                        <option value=""></option>
                        <?php foreach($all_clients as $client) {?>
                        <option value="<?php echo $client->client_id;?>"> <?php echo $client->name;?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <?php if($user_info[0]->user_role_id==1){ ?>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="perusahaan_id"><?php echo $this->lang->line('module_title_perusahaan');?></label>
                      <select multiple="multiple" name="perusahaan_id[]" id="aj_perusahaan" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_title_perusahaan');?>">
                        <option value=""><?php echo $this->lang->line('module_title_perusahaan');?></option>
                        <?php foreach($all_perusahaans as $perusahaan) {?>
                        <option value="<?php echo $perusahaan->perusahaan_id;?>"> <?php echo $perusahaan->name;?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <?php } else {?>
                  <?php $eperusahaan_id = $user_info[0]->perusahaan_id;?>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="perusahaan_id"><?php echo $this->lang->line('module_title_perusahaan');?></label>
                      <select multiple="multiple" name="perusahaan_id[]" id="aj_perusahaan" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_title_perusahaan');?>">
                        <option value=""><?php echo $this->lang->line('module_title_perusahaan');?></option>
                        <?php foreach($all_perusahaans as $perusahaan) {?>
                        <?php if($eperusahaan_id == $perusahaan->perusahaan_id):?>
                        <option value="<?php echo $perusahaan->perusahaan_id;?>"> <?php echo $perusahaan->name;?></option>
                        <?php endif;?>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <?php } ?>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="estimate_date"><?php echo $this->lang->line('umb_quote_tanggal');?></label>
                      <input class="form-control date" placeholder="<?php echo $this->lang->line('umb_quote_tanggal');?>" readonly name="estimate_date" type="text">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="estimate_hrs"><?php echo $this->lang->line('umb_estimate_hrs');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('umb_estimate_hrs');?>" name="estimate_hrs" type="text">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="karyawan"><?php echo $this->lang->line('umb_p_priority');?></label>
                      <select name="priority" class="form-control select-border-color border-warning" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_p_priority');?>">
                        <option value="1"><?php echo $this->lang->line('umb_highest');?></option>
                        <option value="2"><?php echo $this->lang->line('umb_high');?></option>
                        <option value="3"><?php echo $this->lang->line('umb_normal');?></option>
                        <option value="4"><?php echo $this->lang->line('umb_low');?></option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="description"><?php echo $this->lang->line('umb_description');?></label>
                  <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('umb_description');?>" name="description" cols="30" rows="15" id="description"></textarea>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group" id="ajax_karyawan">
                  <label for="karyawan"><?php echo $this->lang->line('umb_project_manager');?></label>
                  <select multiple name="assigned_to[]" class="form-control select-border-color border-warning" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_project_manager');?>">
                    <option value=""></option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="summary"><?php echo $this->lang->line('umb_summary');?></label>
                  <textarea class="form-control" placeholder="<?php echo $this->lang->line('umb_summary');?>" name="summary" cols="30" rows="1" id="summary"></textarea>
                </div>
              </div>
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
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_list_all');?></strong> <?php echo $this->lang->line('umb_quoted_projects');?></span> </div>
  <div class="card-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="umb_table">
        <thead>
          <tr>
            <th><?php echo $this->lang->line('umb_action');?></th>
            <th><?php echo $this->lang->line('umb_project');?>#</th>
            <!--<th><?php echo $this->lang->line('umb_phase_no');?></th>-->
            <th width="180"><?php echo $this->lang->line('umb_ringkasan_project');?></th>
            <?php //if(!in_array('386',$role_resources_ids)) {?>
            <th><?php echo $this->lang->line('umb_p_priority');?></th>
            <?php //} ?>
            <th><i class="fa fa-user"></i> <?php echo $this->lang->line('umb_project_users');?></th>
            <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('umb_quote_tanggal');?></th>
            <th><?php echo $this->lang->line('dashboard_umb_progress');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
