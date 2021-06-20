<?php
/* Job Interview view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>
<?php $role_resources_ids = $this->Umb_model->user_role_resource(); ?>
<?php if(in_array('296',$role_resources_ids)) {?>
  <div class="box mb-4 <?php echo $get_animate;?>">
    <div id="accordion">
      <div class="box-header with-border">
        <h3 class="box-title"><?php echo $this->lang->line('umb_add_new');?> <?php echo $this->lang->line('left_pekerjaan_interview');?></h3>
        <div class="box-tools pull-right"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
          <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('umb_add_new');?></button>
        </a> </div>
      </div>
      <div id="add_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
        <div class="box-body">
          <?php $attributes = array('name' => 'add_interview', 'id' => 'umb-form', 'autocomplete' => 'off');?>
          <?php $hidden = array('user_id' => $session['user_id']);?>
          <?php echo form_open('admin/interviews_pekerjaan/add_interview', $attributes, $hidden);?>
          <div class="bg-white">
            <div class="box-block">
              <div class="row">
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="post_pekerjaan"><?php echo $this->lang->line('umb_e_details_jtitle');?></label>
                        <select class="form-control" id="pekerjaan_id" name="pekerjaan_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_e_details_jtitle');?>">
                          <option value=""></option>
                          <?php foreach($all_interview_pekerjaans as $pekerjaans):?>
                            <option value="<?php echo $pekerjaans->pekerjaan_id;?>"><?php echo $pekerjaans->title_pekerjaan;?></option>
                          <?php endforeach?>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="tanggal_interview"><?php echo $this->lang->line('umb_tanggal_interview');?></label>
                        <input class="form-control date" placeholder="<?php echo $this->lang->line('umb_tanggal_interview');?>" readonly name="tanggal_interview" type="text" value="">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group" id="interviewees_ajax">
                        <label for="interviewees"><?php echo $this->lang->line('umb_interviewees_kandidats_selected');?></label>
                        <select class="form-control" name="interviewees[]" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_kandidats');?>">
                          <option value=""></option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="tempat_interview"><?php echo $this->lang->line('umb_place_of_interview');?></label>
                        <input class="form-control" placeholder="<?php echo $this->lang->line('umb_place_of_interview');?>" name="tempat_interview" type="text" value="">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="waktu_interview" class="control-label"><?php echo $this->lang->line('umb_waktu_interview');?></label>
                        <input class="form-control timepicker" placeholder="<?php echo $this->lang->line('umb_waktu_interview');?>" readonly name="waktu_interview" type="text" value="">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="interviewers"><?php echo $this->lang->line('umb_interviewers_karyawans');?></label>
                        <select multiple class="form-control" name="interviewers[]" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('dashboard_karyawans');?>">
                          <option value=""></option>
                          <?php foreach($all_karyawans as $karyawan) {?>
                            <option value="<?php echo $karyawan->user_id;?>"><?php echo $karyawan->first_name. ' ' .$karyawan->last_name;?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="description"><?php echo $this->lang->line('umb_pekerjaan_interview_description');?></label>
                    <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('umb_pekerjaan_interview_description');?>" name="description" cols="30" rows="5" id="description"></textarea>
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
  <div class="box <?php echo $get_animate;?>">
    <div class="box-header with-border">
      <h3 class="box-title"> <?php echo $this->lang->line('umb_list_all');?> <?php echo $this->lang->line('left_interviews_pekerjaan');?> </h3>
    </div>
    <div class="box-body">
      <div class="box-datatable table-responsive">
        <table class="datatables-demo table table-striped table-bordered" id="umb_table">
          <thead>
            <tr>
              <?php if(in_array('388',$role_resources_ids)) {?>
                <th><?php echo $this->lang->line('umb_action');?></th>
                <th><?php echo $this->lang->line('umb_e_details_jtitle');?></th>
                <th><?php echo $this->lang->line('umb_message');?></th>
                <th><?php echo $this->lang->line('umb_tempat_interview');?></th>
                <th><?php echo $this->lang->line('umb_tanggal_waktu_interview');?></th>
                <th><?php echo $this->lang->line('umb_ditambahkan_oleh');?></th>
              <?php } else { ?>
                <th><?php echo $this->lang->line('umb_action');?></th>
                <th><?php echo $this->lang->line('umb_e_details_jtitle');?></th>
                <th><?php echo $this->lang->line('umb_selected_kandidats');?></th>
                <th><?php echo $this->lang->line('umb_tempat_interview');?></th>
                <th><?php echo $this->lang->line('umb_tanggal_waktu_interview');?></th>
                <th><?php echo $this->lang->line('umb_interviewers');?></th>
                <th><?php echo $this->lang->line('umb_ditambahkan_oleh');?></th>
              <?php } ?>

            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
  <style type="text/css">.trumbowyg-box, .trumbowyg-editor { min-height: 175px; }</style>