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
  <?php $attributes = array('name' => 'add_tugas', 'id' => 'umb-form', 'autocomplete' => 'off', 'class' => 'm-b-1');?>
  <?php $hidden = array('user_id' => $session['user_id']);?>
  <?php echo form_open('admin/timesheet/add_tugas', $attributes, $hidden);?>
  <div class="modal-body">
    <h4 class="text-center text-big mb-4">
      <strong><?php echo $this->lang->line('umb_add_new');?> <?php echo $this->lang->line('umb_tugas');?></strong>
    </h4>
    <div class="bg-white">
      <div class="box-block">
        <div class="row">
          <div class="col-md-6">
            <?php if($user_info[0]->user_role_id==1){ ?>
              <div class="form-group">
                <label for="nama_perusahaan"><?php echo $this->lang->line('module_title_perusahaan');?></label>
                <select class="form-control" name="perusahaan_id" id="aj_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_title_perusahaan');?>">
                  <option value=""><?php echo $this->lang->line('umb_select_one');?></option>
                  <?php foreach($all_perusahaans as $perusahaan) {?>
                    <option value="<?php echo $perusahaan->perusahaan_id;?>"> <?php echo $perusahaan->name;?></option>
                  <?php } ?>
                </select>
              </div>
            <?php } else {?>
             <?php $eperusahaan_id = $user_info[0]->perusahaan_id;?>
             <div class="form-group">
              <label for="perusahaan_id"><?php echo $this->lang->line('module_title_perusahaan');?></label>
              <select name="perusahaan_id" id="aj_perusahaan" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_title_perusahaan');?>">
                <option value=""></option>
                <?php foreach($all_perusahaans as $perusahaan) {?>
                  <?php if($eperusahaan_id == $perusahaan->perusahaan_id):?>
                    <option value="<?php echo $perusahaan->perusahaan_id;?>"> <?php echo $perusahaan->name;?></option>
                  <?php endif;?>
                <?php } ?>
              </select>
            </div>
          <?php } ?>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="start_date"><?php echo $this->lang->line('umb_start_date');?></label>
                <input class="form-control edate" placeholder="<?php echo $this->lang->line('umb_start_date');?>" readonly name="start_date" type="text" value="<?php echo $_GET['event_date'];?>" id="start_date">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="end_date"><?php echo $this->lang->line('umb_end_date');?></label>
                <input class="form-control edate" placeholder="<?php echo $this->lang->line('umb_end_date');?>" readonly name="end_date" type="text" value="<?php echo $_GET['event_date'];?>" id="end_date">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group" id="ajax_project">
                <label for="ajax_project" class="control-label"><?php echo $this->lang->line('umb_project');?></label>
                <select class="form-control" name="project_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_project');?>">
                  <option value=""></option>
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="nama_tugas"><?php echo $this->lang->line('dashboard_umb_title');?></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('dashboard_umb_title');?>" name="nama_tugas" type="text" value="">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="jam_tugas" class="control-label"><?php echo $this->lang->line('umb_estimated_hour');?></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('umb_estimated_hour');?>" name="jam_tugas" type="text" value="">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group" id="ajax_karyawan">
                <label for="karyawans" class="control-label"><?php echo $this->lang->line('umb_assigned_to');?></label>
                <select multiple class="form-control" name="assigned_to[]" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('dashboard_single_karyawan');?>">
                  <option value=""></option>
                </select>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
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
    $('.edate').bootstrapMaterialDatePicker({
      weekStart: 0,
      time: false,
      clearButton: false,
      format: 'YYYY-MM-DD'
    });
    Ladda.bind('button[type=submit]');
    jQuery("#aj_perusahaan").change(function(){
      jQuery.get(site_url+"timesheet/get_project_perusahaan/"+jQuery(this).val(), function(data, status){
        jQuery('#ajax_project').html(data);
      });
      jQuery.get(site_url+"timesheet/get_perusahaan_karyawans/"+jQuery(this).val(), function(data, status){
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
        data: obj.serialize()+"&is_ajax=1&add_type=tugas&form="+action,
        cache: false,
        success: function (JSON) {
          if (JSON.error != '') {
            toastr.error(JSON.error);
            $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
            $('.save').prop('disabled', false);
            Ladda.stopAll();
          } else {
            toastr.success(JSON.result);
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
