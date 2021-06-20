<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['is_ajax']) && $_GET['data']=='event'){
  $session = $this->session->userdata('username');
  ?>
  <?php $user_info = $this->Umb_model->read_user_info($session['user_id']);?>
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> 
      <span aria-hidden="true">×</span> 
    </button>
  </div>
  <?php $attributes = array('name' => 'add_perjalanan', 'id' => 'umb-form', 'autocomplete' => 'off', 'class' => 'm-b-1');?>
  <?php $hidden = array('user_id' => $session['user_id']);?>
  <?php echo form_open('admin/perjalanan/add_perjalanan', $attributes, $hidden);?>
  <div class="modal-body">
    <h4 class="text-center text-big mb-4">
      <strong><?php echo $this->lang->line('umb_add_new');?> <?php echo $this->lang->line('umb_perjalanan');?></strong>
    </h4>
    <div class="bg-white">
      <div class="box-block">
        <div class="row">
          <div class="col-md-6">
            <?php if($user_info[0]->user_role_id==1){?>
              <div class="form-group">
                <label for="first_name"><?php echo $this->lang->line('left_perusahaan');?></label>
                <select class="form-control" name="perusahaan_id" id="aj_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_perusahaan');?>">
                  <option value=""></option>
                  <?php foreach($all_perusahaans as $perusahaan) {?>
                    <option value="<?php echo $perusahaan->perusahaan_id?>"><?php echo $perusahaan->name?></option>
                  <?php } ?>
                </select>
              </div>
            <?php } ?>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="start_date"><?php echo $this->lang->line('umb_start_date');?></label>
                  <input class="form-control edate" placeholder="<?php echo $this->lang->line('umb_start_date');?>" readonly name="start_date" type="text" id="start_date" value="<?php echo $_GET['event_date'];?>">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="end_date"><?php echo $this->lang->line('umb_end_date');?></label>
                  <input class="form-control edate" placeholder="<?php echo $this->lang->line('umb_end_date');?>" readonly name="end_date" type="text" id="end_date" value="<?php echo $_GET['event_date'];?>">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="perjalanan_mode"><?php echo $this->lang->line('umb_perjalanan_mode');?></label>
                  <select class="select2" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_perjalanan_mode');?>" name="perjalanan_mode">
                    <option value="1"><?php echo $this->lang->line('umb_by_bus');?></option>
                    <option value="2"><?php echo $this->lang->line('umb_by_train');?></option>
                    <option value="3"><?php echo $this->lang->line('umb_by_plane');?></option>
                    <option value="4"><?php echo $this->lang->line('umb_by_taxi');?></option>
                    <option value="5"><?php echo $this->lang->line('umb_by_rental_car');?></option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="expected_budget"><?php echo $this->lang->line('umb_expected_perjalanan_budget');?></label>
                  <input class="form-control" placeholder="<?php echo $this->lang->line('umb_expected_perjalanan_budget');?>" name="expected_budget" type="text">
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <?php if($user_info[0]->user_role_id==1){?>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group" id="ajax_karyawan">
                    <label for="karyawan_id"><?php echo $this->lang->line('dashboard_single_karyawan');?></label>
                    <select name="karyawan_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_choose_an_karyawan');?>">
                      <option value=""></option>
                    </select>
                  </div>
                </div>
              </div>
            <?php } else {?>
              <input type="hidden" name="karyawan_id" id="karyawan_id" value="<?php echo $session['user_id'];?>" />
              <input type="hidden" name="perusahaan_id" id="perusahaan_id" value="<?php echo $user_info[0]->perusahaan_id;?>" />
            <?php } ?>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="visit_purpose"><?php echo $this->lang->line('umb_tujuan_kunjungan');?></label>
                  <input class="form-control" placeholder="<?php echo $this->lang->line('umb_tujuan_kunjungan');?>" name="visit_purpose" type="text" id="visit_purpose">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="arrangement_type"><?php echo $this->lang->line('umb_arragement_type');?></label>
                  <select class="select2" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_arragement_type');?>" name="arrangement_type">
                    <?php foreach($types_pengaturan_perjalanan as $type_pngtrn_perjalanan) {?>
                      <option value="<?php echo $type_pngtrn_perjalanan->type_pengaturan_id;?>"> <?php echo $type_pngtrn_perjalanan->type;?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="actual_budget"><?php echo $this->lang->line('umb_actual_perjalanan_budget');?></label>
                  <input class="form-control" placeholder="<?php echo $this->lang->line('umb_actual_perjalanan_budget');?>" name="actual_budget" type="text">
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label for="visit_place"><?php echo $this->lang->line('umb_visit_place');?></label>
              <input class="form-control" placeholder="<?php echo $this->lang->line('umb_visit_place');?>" name="visit_place" type="text">
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label for="description"><?php echo $this->lang->line('umb_description');?></label>
              <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('umb_description');?>" name="description" id="description"></textarea>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('umb_close');?></button>
    <button type="submit" class="btn btn-primary"> 
      <i class="fa fa-check-square-o"></i> 
      <?php echo $this->lang->line('umb_save');?> 
    </button>
  </div>
  <?php echo form_close(); ?>
  <script type="application/javascript">
    $(document).ready(function() {
      $('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
      $('[data-plugin="select_hrm"]').select2({ width:'100%' });
      Ladda.bind('button[type=submit]');
      $('.edate').bootstrapMaterialDatePicker({
        weekStart: 0,
        time: false,
        clearButton: false,
        format: 'YYYY-MM-DD'
      });
      jQuery("#aj_perusahaan").change(function(){
        jQuery.get(site_url+"perjalanan/get_karyawans/"+jQuery(this).val(), function(data, status){
          jQuery('#ajax_karyawan').html(data);
        });
      });
      $("#umb-form").submit(function(e){
        e.preventDefault();
        var obj = $(this), action = obj.attr('name');
        $('.save').prop('disabled', true);
        $.ajax({
          type: "POST",
          url: e.target.action,
          data: obj.serialize()+"&is_ajax=1&add_type=perjalanan&form="+action,
          cache: false,
          success: function (JSON) {
            if (JSON.error != '') {
              toastr.error(JSON.error);
              $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
              $('.save').prop('disabled', false);
              Ladda.stopAll();
            } else {
              $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
              $('.modal-slide').modal('hide');
              $('#module-opt').hide();
              Ladda.stopAll();
              window.location = '';
            }
          }
        });
      });
    });
  </script>
<?php } ?>
