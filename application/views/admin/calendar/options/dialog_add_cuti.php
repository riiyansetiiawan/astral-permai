<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['is_ajax']) && $_GET['data']=='event'){
  $session = $this->session->userdata('username');
  ?>
  <?php $user = $this->Umb_model->read_info_karyawan($session['user_id']);?>
  <?php $kategoris_cuti = $user[0]->kategoris_cuti;?>
  <?php $user_info = $this->Umb_model->read_user_info($session['user_id']);?>
  <?php $leaave_cat = get_kategori_karyawan_cuti($kategoris_cuti,$session['user_id']);?>
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  </div>
  <?php $attributes = array('name' => 'add_cuti', 'id' => 'umb-form', 'autocomplete' => 'off', 'class' => 'm-b-1');?>
  <?php $hidden = array('user_id' => $session['user_id']);?>
  <?php echo form_open('admin/timesheet/add_cuti', $attributes, $hidden);?>
  <div class="modal-body">
    <h4 class="text-center text-big mb-4">
      <strong><?php echo $this->lang->line('umb_add_new');?> <?php echo $this->lang->line('left_cuti');?></strong>
    </h4>
    <div class="bg-white">
      <div class="box-block">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="type_cuti" class="control-label"><?php echo $this->lang->line('umb_type_cuti');?></label>
              <select class="form-control" name="type_cuti" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_type_cuti');?>">
                <option value=""></option>
                <?php foreach($all_types_cuti as $type) {?>
                  <option value="<?php echo $type->type_cuti_id;?>"> <?php echo $type->type_name;?></option>
                <?php } ?>
              </select>
            </div>
            <?php if($user_info[0]->user_role_id==1){?>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="first_name"><?php echo $this->lang->line('left_perusahaan');?></label>
                    <select class="form-control" name="perusahaan_id" id="aj_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_perusahaan');?>">
                      <option value=""></option>
                      <?php foreach($all_perusahaans as $perusahaan) {?>
                        <option value="<?php echo $perusahaan->perusahaan_id?>"><?php echo $perusahaan->name?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
            <?php } ?>
          </div>
          <div class="col-md-6">
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
            <?php if($user_info[0]->user_role_id==1){?>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group" id="ajax_karyawan">
                    <label for="karyawans" class="control-label"><?php echo $this->lang->line('umb_karyawan');?></label>
                    <select class="form-control" name="karyawan_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_choose_an_karyawan');?>">
                      <option value=""></option>
                    </select>
                  </div>
                </div>
              </div>
            <?php } else {?>
              <input type="hidden" name="karyawan_id" id="karyawan_id" value="<?php echo $session['user_id'];?>" />
              <input type="hidden" name="perusahaan_id" id="perusahaan_id" value="<?php echo $user[0]->perusahaan_id;?>" />
            <?php } ?>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <fieldset class="form-group">
                <label for="attachment"><?php echo $this->lang->line('umb_attachment');?></label>
                <input type="file" class="form-control-file" id="attachment" name="attachment">
                <small><?php echo $this->lang->line('umb_type_file_cuti');?></small>
              </fieldset>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="attachment"><?php echo $this->lang->line('umb_hr_cuti_setenga_hari');?></label><br />
              <input type="checkbox" class="minimal" value="1" id="cuti_setengah_hari" name="cuti_setengah_hari">
              <?php echo $this->lang->line('umb_hr_cuti_setenga_hari');?></span>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="description"><?php echo $this->lang->line('umb_keterangan');?></label>
          <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('umb_keterangan');?>" name="remarks" id="remarks"></textarea>
        </div>
        <div class="form-group">
          <label for="summary"><?php echo $this->lang->line('umb_alasan_cuti');?></label>
          <textarea class="form-control" placeholder="<?php echo $this->lang->line('umb_alasan_cuti');?>" name="reason" cols="30" rows="2" id="reason"></textarea>
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
      jQuery("#aj_perusahaan").change(function(){
        jQuery.get(site_url+"timesheet/get_update_karyawans/"+jQuery(this).val(), function(data, status){
          jQuery('#ajax_karyawan').html(data);
        });
      });
      $('.edate').bootstrapMaterialDatePicker({
        weekStart: 0,
        time: false,
        clearButton: false,
        format: 'YYYY-MM-DD'
      });
      Ladda.bind('button[type=submit]');

      $("#umb-form").submit(function(e){
        var fd = new FormData(this);
        var obj = $(this), action = obj.attr('name');
        fd.append("is_ajax", 1);
        fd.append("add_type", 'cuti');
        fd.append("form", action);
        e.preventDefault();
        $('.icon-spinner3').show();
        $('.save').prop('disabled', true);
        $.ajax({
          url: e.target.action,
          type: "POST",
          data:  fd,
          contentType: false,
          cache: false,
          processData:false,
          success: function(JSON) {
            if (JSON.error != '') {
              toastr.error(JSON.error);
              $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
              $('.save').prop('disabled', false);
              $('.icon-spinner3').hide();
              Ladda.stopAll();
            } else {
              toastr.success(JSON.result);
              $('.icon-spinner3').hide();
              $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
              Ladda.stopAll();
              window.location = '';
            }
          },
          error: function() {
            toastr.error(JSON.error);
            $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
            $('.modal-slide').modal('hide');
            $('.icon-spinner3').hide();
            $('.save').prop('disabled', false);
            Ladda.stopAll();
          } 	        
        });
      });
      $("#umb-form11").submit(function(e){
        e.preventDefault();
        var obj = $(this), action = obj.attr('name');
        $('.save').prop('disabled', true);
        $.ajax({
          type: "POST",
          url: e.target.action,
          data: obj.serialize()+"&is_ajax=1&add_type=cuti&form="+action,
          cache: false,
          success: function (JSON) {
            if (JSON.error != '') {
              toastr.error(JSON.error);
              $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
              $('.save').prop('disabled', false);
            } else {
              $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
              $('.modal-slide').modal('toggle');
              $('#module-opt').hide();
              window.location = '';
            }
          }
        });
      });
    });
  </script>
<?php } ?>
