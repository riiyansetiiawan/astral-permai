<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['shift_kantor_id']) && $_GET['data']=='shift'){
  ?>
  <?php $session = $this->session->userdata('username');?>
  <?php $user_info = $this->Umb_model->read_user_info($session['user_id']);?>
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
    <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_edit_shift_kantor');?></h4>
  </div>
  <?php $attributes = array('name' => 'edit_shift_kantor', 'id' => 'edit_shift_kantor', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
  <?php $hidden = array('_method' => 'EDIT', '_token' => $shift_kantor_id, 'ext_name' => $shift_kantor_id);?>
  <?php echo form_open('admin/timesheet/edit_shift_kantor/'.$shift_kantor_id, $attributes, $hidden);?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-12">
        <?php if($user_info[0]->user_role_id==1){ ?>
          <div class="form-group row">
            <label for="time" class="col-md-2"><?php echo $this->lang->line('left_perusahaan');?></label>
            <div class="col-md-4">
              <select class="form-control" name="perusahaan_id" id="aj_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_perusahaan');?>">
                <option value=""></option>
                <?php foreach($get_all_perusahaans as $perusahaan) {?>
                  <option value="<?php echo $perusahaan->perusahaan_id?>" <?php if($perusahaan->perusahaan_id==$perusahaan_id):?> selected="selected"<?php endif;?>><?php echo $perusahaan->name?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        <?php } else {?>
          <?php $eperusahaan_id = $user_info[0]->perusahaan_id;?>
          <div class="form-group row">
            <label for="time" class="col-md-2"><?php echo $this->lang->line('left_perusahaan');?></label>
            <div class="col-md-4">
              <select class="form-control" name="perusahaan_id" id="aj_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_perusahaan');?>">
                <option value=""></option>
                <?php foreach($get_all_perusahaans as $perusahaan) {?>
                  <?php if($eperusahaan_id == $perusahaan->perusahaan_id):?>
                    <option value="<?php echo $perusahaan->perusahaan_id?>" <?php if($perusahaan->perusahaan_id==$perusahaan_id):?> selected="selected"<?php endif;?>><?php echo $perusahaan->name?></option>
                  <?php endif;?>
                <?php } ?>
              </select>
            </div>
          </div>
        <?php } ?>
        <div class="form-group row">
          <label for="time" class="col-md-2"><?php echo $this->lang->line('umb_nama_shift');?></label>
          <div class="col-md-4">
            <input class="form-control" placeholder="<?php echo $this->lang->line('umb_nama_shift');?>" name="nama_shift" type="text" id="name" value="<?php echo $nama_shift;?>">
          </div>
        </div>
        <div class="form-group row">
          <label for="time" class="col-md-2"><?php echo $this->lang->line('umb_monday');?></label>
          <div class="col-md-4">
            <input class="form-control etimepicker clear-1" placeholder="<?php echo $this->lang->line('umb_in_time');?>" readonly="1" name="senen_waktu_masuk" type="text" value="<?php echo $senen_waktu_masuk;?>">
          </div>
          <div class="col-md-4">
            <input class="form-control etimepicker clear-1" placeholder="<?php echo $this->lang->line('umb_out_time');?>" readonly="1" name="senen_waktu_pulang" type="text" value="<?php echo $senen_waktu_pulang;?>">
          </div>
          <div class="col-md-1">
            <button type="button" class="btn btn-primary clear-time" data-clear-id="1"><?php echo $this->lang->line('umb_clear');?></button>
          </div>
        </div>
        <div class="form-group row">
          <label for="time" class="col-md-2"><?php echo $this->lang->line('umb_tuesday');?></label>
          <div class="col-md-4">
            <input class="form-control etimepicker clear-2" placeholder="<?php echo $this->lang->line('umb_in_time');?>" readonly="1" name="selasa_waktu_masuk" type="text" value="<?php echo $selasa_waktu_masuk;?>">
          </div>
          <div class="col-md-4">
            <input class="form-control etimepicker clear-2" placeholder="<?php echo $this->lang->line('umb_out_time');?>" readonly="1" name="selasa_waktu_pulang" type="text" value="<?php echo $selasa_waktu_pulang;?>">
          </div>
          <div class="col-md-1">
            <button type="button" class="btn btn-primary clear-time" data-clear-id="2"><?php echo $this->lang->line('umb_clear');?></button>
          </div>
        </div>
        <div class="form-group row">
          <label for="time" class="col-md-2"><?php echo $this->lang->line('umb_wednesday');?></label>
          <div class="col-md-4">
            <input class="form-control etimepicker clear-3" placeholder="<?php echo $this->lang->line('umb_in_time');?>" readonly="1" name="rabu_waktu_masuk" type="text" value="<?php echo $rabu_waktu_masuk;?>">
          </div>
          <div class="col-md-4">
            <input class="form-control etimepicker clear-3" placeholder="<?php echo $this->lang->line('umb_out_time');?>" readonly="1" name="rabu_waktu_pulang" type="text" value="<?php echo $rabu_waktu_pulang;?>">
          </div>
          <div class="col-md-1">
            <button type="button" class="btn btn-primary clear-time" data-clear-id="3"><?php echo $this->lang->line('umb_clear');?></button>
          </div>
        </div>
        <div class="form-group row">
          <label for="time" class="col-md-2"><?php echo $this->lang->line('umb_thursday');?></label>
          <div class="col-md-4">
            <input class="form-control etimepicker clear-4" placeholder="<?php echo $this->lang->line('umb_in_time');?>" readonly="1" name="kamis_waktu_masuk" type="text" value="<?php echo $kamis_waktu_masuk;?>">
          </div>
          <div class="col-md-4">
            <input class="form-control etimepicker clear-4" placeholder="<?php echo $this->lang->line('umb_out_time');?>" readonly="1" name="kamis_waktu_pulang" type="text" value="<?php echo $kamis_waktu_pulang;?>">
          </div>
          <div class="col-md-1">
            <button type="button" class="btn btn-primary clear-time" data-clear-id="4"><?php echo $this->lang->line('umb_clear');?></button>
          </div>
        </div>
        <div class="form-group row">
          <label for="time" class="col-md-2"><?php echo $this->lang->line('umb_friday');?></label>
          <div class="col-md-4">
            <input class="form-control etimepicker clear-5" placeholder="<?php echo $this->lang->line('umb_in_time');?>" readonly="1" name="jumat_waktu_masuk" type="text" value="<?php echo $jumat_waktu_masuk;?>">
          </div>
          <div class="col-md-4">
            <input class="form-control etimepicker clear-5" placeholder="<?php echo $this->lang->line('umb_out_time');?>" readonly="1" name="jumat_waktu_pulang" type="text" value="<?php echo $jumat_waktu_pulang;?>">
          </div>
          <div class="col-md-1">
            <button type="button" class="btn btn-primary clear-time" data-clear-id="5"><?php echo $this->lang->line('umb_clear');?></button>
          </div>
        </div>
        <div class="form-group row">
          <label for="time" class="col-md-2"><?php echo $this->lang->line('umb_saturday');?></label>
          <div class="col-md-4">
            <input class="form-control etimepicker clear-6" placeholder="<?php echo $this->lang->line('umb_in_time');?>" readonly="1" name="sabtu_waktu_masuk" type="text" value="<?php echo $sabtu_waktu_masuk;?>">
          </div>
          <div class="col-md-4">
            <input class="form-control etimepicker clear-6" placeholder="<?php echo $this->lang->line('umb_out_time');?>" readonly="1" name="sabtu_waktu_pulang" type="text" value="<?php echo $sabtu_waktu_pulang;?>">
          </div>
          <div class="col-md-1">
            <button type="button" class="btn btn-primary clear-time" data-clear-id="6"><?php echo $this->lang->line('umb_clear');?></button>
          </div>
        </div>
        <div class="form-group row">
          <label for="time" class="col-md-2"><?php echo $this->lang->line('umb_sunday');?></label>
          <div class="col-md-4">
            <input class="form-control etimepicker clear-7" placeholder="<?php echo $this->lang->line('umb_in_time');?>" readonly="1" name="minggu_waktu_masuk" type="text" value="<?php echo $minggu_waktu_masuk;?>">
          </div>
          <div class="col-md-4">
            <input class="form-control etimepicker clear-7" placeholder="<?php echo $this->lang->line('umb_out_time');?>" readonly="1" name="minggu_waktu_pulang" type="text" value="<?php echo $minggu_waktu_pulang;?>">
          </div>
          <div class="col-md-1">
            <button type="button" class="btn btn-primary clear-time" data-clear-id="7"><?php echo $this->lang->line('umb_clear');?></button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-check-square"></i> <?php echo $this->lang->line('umb_close');?></button>
    <button type="submit" class="btn btn-primary"><i class="fas fa-check-square"></i> <?php echo $this->lang->line('umb_update');?></button>
  </div>
  <?php echo form_close(); ?>
  <script type="text/javascript">
   $(document).ready(function(){
    
	// Clock
	$('.etimepicker').bootstrapMaterialDatePicker({
		date: false,
		shortTime: true,
		format: 'HH:mm'
	});
	Ladda.bind('button[type=submit]');
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
	/* Edit data */
	$("#edit_shift_kantor").submit(function(e){
		
		e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=3&edit_type=shift&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					Ladda.stopAll();
					toastr.error(JSON.error);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
				} else {
					$('.edit-modal-data').modal('toggle');
          var umb_table = $('#umb_table').dataTable({
           "bDestroy": true,
           "ajax": {
            url : "<?php echo site_url("admin/timesheet/list_shift_kantor") ?>",
            type : 'GET'
          },
          dom: 'lBfrtip',
							"buttons": ['csv', 'excel', 'pdf', 'print'], 
							"fnDrawCallback": function(settings){
               $('[data-toggle="tooltip"]').tooltip();          
             }
           });
          umb_table.api().ajax.reload(function(){ 
           toastr.success(JSON.result);
         }, true);
          $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
          $('.save').prop('disabled', false);
          Ladda.stopAll();
        }
      }
    });
	});
	$(".clear-time").click(function(){
		var clear_id  = $(this).data('clear-id');
		$(".clear-"+clear_id).val('');
	});
});	
</script>
<?php } ?>
