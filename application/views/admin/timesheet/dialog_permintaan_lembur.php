<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['karyawan_id']) && $_GET['data']=='add_kehadiran'){
	// get addd by > template
  $session = $this->session->userdata('username');
  $user = $this->Umb_model->read_user_info($session['user_id']);
  $ful_name = $user[0]->first_name. ' '.$user[0]->last_name;
  ?>

  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
    <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_add_permintaan_kehadiran_for');?> <?php echo $ful_name; ?></h4>
  </div>
  <?php $attributes = array('name' => 'add_kehadiran', 'id' => 'add_kehadiran', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
  <?php $hidden = array('_method' => 'ADD');?>
  <?php echo form_open('admin/permintaan_lembur/add_permintaan_kehadiran/', $attributes, $hidden);?>
  <?php
  $data = array(
   'name'        => 'karyawan_id_m',
   'id'          => 'karyawan_id_m',
   'value'       => $session['user_id'],
   'type'  		=> 'hidden',
   'class'       => 'form-control',
 );

  echo form_input($data);
  ?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-12">
        <div class="form-group"> </div>
        <?php if($user[0]->user_role_id==1){ ?>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="first_name"><?php echo $this->lang->line('left_perusahaan');?></label>
                <select class="form-control" name="perusahaan_id" id="ajx_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_perusahaan');?>">
                  <option value=""></option>
                  <?php foreach($get_all_perusahaans as $perusahaan) {?>
                    <option value="<?php echo $perusahaan->perusahaan_id?>"><?php echo $perusahaan->name?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group" id="ajax_j_karyawan">
                <label for="karyawan"><?php echo $this->lang->line('umb_karyawan');?></label>
                <select disabled="disabled" name="karyawan_id" id="karyawan_id" class="form-control karyawan-data" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_choose_an_karyawan');?>">
                </select>
              </div>
            </div>    
          </div> 
        <?php } else {?>
          <input type="hidden" name="karyawan_id" value="<?php echo $session['user_id'];?>" />
          <input type="hidden" name="perusahaan_id" value="<?php echo $user[0]->perusahaan_id;?>" />
        <?php } ?> 
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="date"><?php echo $this->lang->line('umb_e_details_tanggal');?></label>
              <input class="form-control prmtan_tanggal_kehadiran" placeholder="<?php echo $this->lang->line('umb_e_details_tanggal');?>" readonly="true" id="prmtan_tanggal_kehadiran" name="prmtan_tanggal_kehadiran" type="text">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="no_project"><?php echo $this->lang->line('umb_no_project');?></label>
              <input class="form-control" placeholder="<?php echo $this->lang->line('umb_no_project');?>" name="no_project" type="text" value="">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="no_project"><?php echo $this->lang->line('umb_phase_no');?></label>
              <input class="form-control" placeholder="<?php echo $this->lang->line('umb_phase_no');?>" name="no_pembelian" type="text" value="">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="clock_in"><?php echo $this->lang->line('umb_in_time');?></label>
              <input class="form-control timepicker_m" placeholder="<?php echo $this->lang->line('umb_in_time');?>" readonly="true" id="clock_in_m" name="clock_in_m" type="text">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="clock_out"><?php echo $this->lang->line('umb_out_time');?></label>
              <input class="form-control timepicker_m" placeholder="<?php echo $this->lang->line('umb_out_time');?>" readonly="true" id="clock_out_m" name="clock_out_m" type="text">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="nama_tugas"><?php echo $this->lang->line('umb_tugas');?></label>
              <input class="form-control" placeholder="<?php echo $this->lang->line('umb_tugas');?>" name="nama_tugas" type="text">
            </div>
          </div>
        </div>     
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="clock_in"><?php echo $this->lang->line('umb_alasan');?></label>
              <textarea class="form-control" placeholder="<?php echo $this->lang->line('umb_alasan');?>" rows="3" id="umb_alasan" name="umb_alasan" type="text"></textarea>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('umb_close');?></button>
    <button type="submit" class="btn btn-primary"><?php echo $this->lang->line('umb_save');?></button>
  </div>
  <?php echo form_close(); ?>
  <script type="text/javascript">
   $(document).ready(function(){

		// Clock
		$('.timepicker_m').bootstrapMaterialDatePicker({
			date: false,
			shortTime: true,
			format: 'HH:mm'
		});
		jQuery("#ajx_perusahaan").change(function(){
			jQuery.get(base_url+"/get_update_karyawans/"+jQuery(this).val(), function(data, status){
				jQuery('#ajax_j_karyawan').html(data);
			});
		});
		$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
		$('[data-plugin="select_hrm"]').select2({ width:'100%' }); 
		// Tanggal Kehadiran
		$('.prmtan_tanggal_kehadiran').bootstrapMaterialDatePicker({
			weekStart: 0,
			time: false,
			clearButton: false,
			format: 'YYYY-MM-DD'
		});	 
		Ladda.bind('button[type=submit]');

		/* Add kehadiran*/
		$("#add_kehadiran").submit(function(e){
			var prmtan_tanggal_kehadiran = $("#prmtan_tanggal_kehadiran").val();
			var krywn_id = $("#karyawan_id_m").val();
			var clock_in_m = $("#clock_in_m").val();
			var clock_out_m = $("#clock_out_m").val();
			

      e.preventDefault();
      var obj = $(this), action = obj.attr('name');
      $('.save').prop('disabled', true);
      $.ajax({
        type: "POST",
        url: e.target.action,
        data: obj.serialize()+"&is_ajax=4&add_type=kehadiran&form="+action,
        cache: false,
        success: function (JSON) {
         if (JSON.error != '') {
          toastr.error(JSON.error);
          $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
          $('.save').prop('disabled', false);
          Ladda.stopAll();
        } else {
         if(prmtan_tanggal_kehadiran!='' && krywn_id!='' && clock_in_m!='' && clock_out_m!='') {
          var umb_table = $('#umb_table').dataTable({
            "bDestroy": true,
            "ajax": {
             url : "<?php echo site_url("admin/permintaan_lembur/list_permintaan_lembur") ?>?karyawan_id="+krywn_id+"&tanggal_kehadiran="+prmtan_tanggal_kehadiran,
             type : 'GET'
           },
           "fnDrawCallback": function(settings){
            $('[data-toggle="tooltip"]').tooltip();          
          }
        });
        }
        umb_table.api().ajax.reload(function(){ 
          toastr.success(JSON.result);
        }, true);
        $('.add-modal-data').modal('toggle');
        
        $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
        $('.save').prop('disabled', false);
        Ladda.stopAll();
      }
    }
  });
    });
	});	
</script>
<?php } else if(isset($_GET['jd']) && isset($_GET['permintaan_waktu_id']) && $_GET['type']=='kehadiran' && $_GET['data']=='kehadiran'){?>
  <?php $session = $this->session->userdata('username');?>
  <?php $user = $this->Umb_model->read_user_info($session['user_id']);?>
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
    <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_edit_permintaan_kehadiranfor');?> <?php echo $full_name;?></h4>
  </div>
  <?php $attributes = array('name' => 'edit_kehadiran', 'id' => 'edit_kehadiran', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
  <?php $hidden = array('_method' => 'EDIT', '_token' => $_GET['permintaan_waktu_id']);?>
  <?php echo form_open('admin/permintaan_lembur/edit_kehadiran/'.$permintaan_waktu_id, $attributes, $hidden);?>
  <?php
  $data = array(
   'name'        => 'emp_att',
   'id'          => 'emp_att',
   'value'       => $karyawan_id,
   'type'  		=> 'hidden',
   'class'       => 'form-control',
 );

  echo form_input($data);
  ?>
  <div class="modal-body">
    <?php if($user[0]->user_role_id==1){ ?>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="first_name"><?php echo $this->lang->line('left_perusahaan');?></label>
            <select class="form-control" name="perusahaan_id" id="aj_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_perusahaan');?>">
              <option value=""></option>
              <?php foreach($get_all_perusahaans as $perusahaan) {?>
                <option value="<?php echo $perusahaan->perusahaan_id?>" <?php if($perusahaan->perusahaan_id==$perusahaan_id):?> selected="selected" <?php endif;?>><?php echo $perusahaan->name?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="col-md-6">
          <?php $result = $this->Department_model->ajax_info_perusahaan_karyawan($perusahaan_id);?>
          <div class="form-group" id="ajax_karyawan">
            <label for="karyawan"><?php echo $this->lang->line('umb_karyawan');?></label>
            <select name="karyawan_id" id="karyawan_id" class="form-control karyawan-data" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_choose_an_karyawan');?>">
             <?php foreach($result as $karyawan) {?>
              <option value="<?php echo $karyawan->user_id;?>" <?php if($karyawan->user_id==$karyawan_id):?> selected="selected"<?php endif;?>> <?php echo $karyawan->first_name.' '.$karyawan->last_name;?></option>
            <?php } ?>
          </select>
        </div>
      </div>    
    </div> 
  <?php } else {?>
    <input type="hidden" name="karyawan_id" value="<?php echo $karyawan_id;?>" />
    <input type="hidden" name="perusahaan_id" value="<?php echo $perusahaan_id;?>" />
  <?php } ?> 
  <div class="row">
    <div class="col-md-12">
      <div class="form-group">
        <label for="date"><?php echo $this->lang->line('umb_e_details_tanggal');?></label>
        <input class="form-control tanggal_kehadiran_e" placeholder="<?php echo $this->lang->line('umb_e_details_tanggal');?>" readonly="true" id="tanggal_kehadiran_e" name="tanggal_kehadiran_e" type="text" value="<?php echo $tanggal_permintaan;?>">
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="clock_in"><?php echo $this->lang->line('umb_in_time');?></label>
            <input class="form-control timepicker" placeholder="<?php echo $this->lang->line('umb_in_time');?>" readonly="true" name="clock_in" type="text" value="<?php echo $request_clock_in;?>">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="clock_out"><?php echo $this->lang->line('umb_out_time');?></label>
            <input class="form-control timepicker" placeholder="<?php echo $this->lang->line('umb_out_time');?>" readonly="true" name="clock_out" type="text" value="<?php echo $request_clock_out;?>">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label for="clock_in"><?php echo $this->lang->line('umb_alasan');?></label>
            <textarea class="form-control" placeholder="<?php echo $this->lang->line('umb_alasan');?>" rows="3" id="umb_alasan" name="umb_alasan" type="text"><?php echo $alasan_permintaan;?></textarea>
          </div>
        </div>
      </div>
      <?php if($user[0]->user_role_id == 1) {?>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="status"><?php echo $this->lang->line('dashboard_umb_status');?></label>
              <select class="form-control" name="status" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('dashboard_umb_status');?>">
                <option value="1" <?php if($is_approved=='1'):?> selected <?php endif; ?>><?php echo $this->lang->line('umb_pending');?></option>
                <option value="2" <?php if($is_approved=='2'):?> selected <?php endif; ?>><?php echo $this->lang->line('umb_approved');?></option>
                v<option value="3" <?php if($is_approved=='3'):?> selected <?php endif; ?>><?php echo $this->lang->line('umb_rejected');?></option>
              </select>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('umb_close');?></button>
  <button type="submit" class="btn btn-primary save"><?php echo $this->lang->line('umb_update');?></button>
</div>
<?php echo form_close(); ?>
<script type="text/javascript">
  $(document).ready(function(){
	// Clock
	$('.timepicker').bootstrapMaterialDatePicker({
		date: false,
		shortTime: true,
		format: 'HH:mm'
	});
	jQuery("#aj_perusahaan").change(function(){
		jQuery.get(base_url+"/get_update_karyawans/"+jQuery(this).val(), function(data, status){
			jQuery('#ajax_karyawan').html(data);
		});
	});	 
	Ladda.bind('button[type=submit]');
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' }); 
	// Tanggal Kehadiran
	$('.tanggal_kehadiran_e').bootstrapMaterialDatePicker({
		weekStart: 0,
		time: false,
		clearButton: false,
		format: 'YYYY-MM-DD'
	});  
	/* Edit kehadiran*/
	$("#edit_kehadiran").submit(function(e){
   var tanggal_kehadiran_e = $("#tanggal_kehadiran_e").val();
   var emp_att = $("#emp_att").val();
   var umb_table2 = $('#umb_table').dataTable({
    "bDestroy": true,
    "ajax": {
     url : "<?php echo site_url("admin/permintaan_lembur/list_permintaan_lembur") ?>?karyawan_id="+emp_att+"&tanggal_kehadiran="+tanggal_kehadiran_e,
     type : 'GET'
   },
   "fnDrawCallback": function(settings){
    $('[data-toggle="tooltip"]').tooltip();          
  }
});
   
   e.preventDefault();
   var obj = $(this), action = obj.attr('name');
   $('.save').prop('disabled', true);
   $.ajax({
     type: "POST",
     url: e.target.action,
     data: obj.serialize()+"&is_ajax=3&edit_type=kehadiran&form="+action,
     cache: false,
     success: function (JSON) {
      if (JSON.error != '') {
       toastr.error(JSON.error);
       $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
       $('.save').prop('disabled', false);
       Ladda.stopAll();
     } else {
       $('.edit-modal-data').modal('toggle');
       umb_table2.api().ajax.reload(function(){ 
        toastr.success(JSON.result);
      }, true);
       $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
       $('.save').prop('disabled', false);
       Ladda.stopAll();
     }
   }
 });
 });
});	
</script>
<?php }
?>
