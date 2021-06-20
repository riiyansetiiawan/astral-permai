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
  <?php $attributes = array('name' => 'add_meeting', 'id' => 'umb-form', 'autocomplete' => 'off', 'class' => 'm-b-1');?>
  <?php $hidden = array('user_id' => $session['user_id']);?>
  <?php echo form_open('admin/meetings/add_meeting', $attributes, $hidden);?>
  <div class="modal-body">
    <h4 class="text-center text-big mb-4">
      <strong><?php echo $this->lang->line('umb_add_new');?> <?php echo $this->lang->line('umb_hr_meeting');?></strong>
    </h4>
    <div class="row">
      <?php if($user_info[0]->user_role_id==1){ ?>
        <div class="col-md-6">
          <div class="form-group">
            <label for="first_name"><?php echo $this->lang->line('left_perusahaan');?></label>
            <select class="form-control" name="perusahaan_id" id="aj_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_perusahaan');?>">
              <option value=""></option>
              <?php foreach($get_all_perusahaans as $perusahaan) {?>
                <option value="<?php echo $perusahaan->perusahaan_id?>"><?php echo $perusahaan->name?></option>
              <?php } ?>
            </select>
          </div>
        </div>
      <?php } else {?>
       <?php $eperusahaan_id = $user_info[0]->perusahaan_id;?>
       <div class="col-md-6">
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
      </div>
    <?php } ?>
    <div class="col-md-6">
      <div class="form-group" id="ajax_karyawan">
        <label for="first_name"><?php echo $this->lang->line('dashboard_single_karyawan');?></label>
        <select class="form-control" name="karyawan_id" id="karyawan_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_choose_an_karyawan');?>">
          <option value=""></option>
        </select>
      </div>
    </div>
  </div>
  
  <div class="row">
    <div class="col-md-12">
      <div class="form-group">
        <label for="title_meeting"><?php echo $this->lang->line('umb_hr_title_meeting');?></label>
        <input type="text" class="form-control" name="title_meeting" id="title_meeting" placeholder="<?php echo $this->lang->line('umb_hr_title_meeting');?>">
        <input type="hidden" value="#605ca8" name="meeting_color" readonly="readonly">
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="tanggal_meeting"><?php echo $this->lang->line('umb_hr_tanggal_meeting');?></label>
        <input class="form-control edate" placeholder="<?php echo $this->lang->line('umb_hr_tanggal_meeting');?>" readonly name="tanggal_meeting" type="text" value="<?php echo $_GET['event_date'];?>" id="m_tanggal_meeting" />
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="waktu_meeting"><?php echo $this->lang->line('umb_hr_waktu_meeting');?></label>
        <input class="form-control etimepicker" placeholder="<?php echo $this->lang->line('umb_hr_waktu_meeting');?>" readonly name="waktu_meeting" type="text" id="m_waktu_meeting">
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="form-group">
        <label for="meeting_room"><?php echo $this->lang->line('umb_meeting_room');?></label>
        <input type="text" class="form-control" name="meeting_room" placeholder="<?php echo $this->lang->line('umb_meeting_room');?>">
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="form-group">
        <label for="event_note"><?php echo $this->lang->line('umb_hr_meeting_note');?></label>
        <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('umb_hr_meeting_note');?>" name="meeting_note" id="meeting_note"></textarea>
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
    $('.etimepicker').bootstrapMaterialDatePicker({
      date: false,
      shortTime: true,
      format: 'HH:mm'
    });
    Ladda.bind('button[type=submit]');
    jQuery("#aj_perusahaan").change(function(){
      jQuery.get(site_url +"events/get_karyawans/"+jQuery(this).val(), function(data, status){
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
       data: obj.serialize()+"&is_ajax=1&add_type=meeting&form="+action,
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
          $('.view-modal-data').modal('toggle');
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
