<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['is_ajax']) && $_GET['data']=='event'){
  $session = $this->session->userdata('username');
  ?>
  <?php $user_info = $this->Umb_model->read_user_info($session['user_id']);?>
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  </div>
  <?php $no_project = $this->Umb_model->generate_random_string();?>
  <?php $attributes = array('name' => 'add_project', 'id' => 'umb-form', 'autocomplete' => 'off', 'class' => 'm-b-1');?>
  <?php $hidden = array('user_id' => $session['user_id']);?>
  <?php echo form_open('admin/project/add_project', $attributes, $hidden);?>
  <div class="modal-body">
    <h4 class="text-center text-big mb-4">
      <strong><?php echo $this->lang->line('umb_add_new');?> <?php echo $this->lang->line('umb_project');?></strong>
    </h4>
    <div class="bg-white">
      <div class="box-block">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="title"><?php echo $this->lang->line('umb_title');?></label>
              <input class="form-control" placeholder="<?php echo $this->lang->line('umb_title');?>" id="title" name="title" type="text">
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="no_pembelian"><?php echo $this->lang->line('umb_po_no');?></label>
                  <input class="form-control" placeholder="<?php echo $this->lang->line('umb_po_no');?>" name="no_pembelian" type="text" value="">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="phase_no"><?php echo $this->lang->line('umb_phase_no');?></label>
                  <input class="form-control" placeholder="<?php echo $this->lang->line('umb_phase_no');?>" name="phase_no" type="text" value="">
                </div>
              </div>
            </div>
            <div class="row">
              <?php if($user_info[0]->user_role_id==1){ ?>
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="tanggal_award"><?php echo $this->lang->line('module_title_perusahaan');?></label>
                    <select multiple="multiple" name="perusahaan_id[]" id="aj_perusahaan" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_title_perusahaan');?>">
                      <option value=""></option>
                      <?php foreach($all_perusahaans as $perusahaan) {?>
                        <option value="<?php echo $perusahaan->perusahaan_id;?>"> <?php echo $perusahaan->name;?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              <?php } else {?>
               <?php $eperusahaan_id = $user_info[0]->perusahaan_id;?>
               <div class="col-md-12">
                <div class="form-group">
                  <label for="perusahaan_id"><?php echo $this->lang->line('module_title_perusahaan');?></label>
                  <select multiple="multiple" name="perusahaan_id[]" id="aj_perusahaan" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_title_perusahaan');?>">
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
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="jam_anggaran"><?php echo $this->lang->line('umb_project_budget_hrs');?></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('umb_project_budget_hrs');?>" name="jam_anggaran" type="text">
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
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="no_project"><?php echo $this->lang->line('umb_no_project');?></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('umb_no_project');?>" name="no_project" type="text" value="<?php echo $no_project;?>">
              </div>
            </div>
          </div>
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
              <div class="form-group" id="ajax_karyawan">
                <label for="karyawan"><?php echo $this->lang->line('umb_project_manager');?></label>
                <select multiple name="assigned_to[]" class="form-control select-border-color border-warning" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_project_manager');?>">
                  <option value=""></option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <?php $all_clientsx = $this->Clients_model->get_all_clients();?>
                <label for="name_client"><?php echo $this->lang->line('umb_nama_klien');?></label>
                <select name="client_id" id="name_client" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_project_client');?>">
                  <option value=""></option>
                  <?php foreach($all_clientsx as $client) {?>
                    <option value="<?php echo $client->client_id;?>"> <?php echo $client->name;?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label for="summary"><?php echo $this->lang->line('umb_summary');?></label>
            <textarea class="form-control" placeholder="<?php echo $this->lang->line('umb_summary');?>" name="summary" cols="30" rows="1" id="summary"></textarea>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label for="description"><?php echo $this->lang->line('umb_description');?></label>
            <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('umb_description');?>" name="description" id="description" rows="4"></textarea>
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
      jQuery.get(site_url+"project/get_karyawans/?cid="+jQuery(this).val(), function(data, status){
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
       data: obj.serialize()+"&is_ajax=1&add_type=project&form="+action,
       cache: false,
       success: function (JSON) {
        if (JSON.error != '') {
          toastr.error(JSON.error);
          $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
          $('.save').prop('disabled', false);
        } else {
          toastr.success(JSON.result);
          $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
          $('.modal-slide').modal('hide');
          $('#module-opt').hide();
          window.location = '';
        }
      }
    });
   });
  });
</script>
<?php } ?>
