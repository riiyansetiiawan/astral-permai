<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['meeting_id']) && $_GET['data']=='view_meeting'){
  ?>
  <form class="m-b-1">
    <div class="modal-body">
      <p class="text-center text-big mb-4"><strong><?php echo $this->lang->line('umb_hr_view_meeting');?></strong></p>
      <table class="footable-details table table-striped table-hover toggle-circle">
        <tbody>
          <tr>
            <th><?php echo $this->lang->line('module_title_perusahaan');?></th>
            <td style="display: table-cell;"><?php foreach($get_all_perusahaans as $perusahaan) {?>
              <?php if($perusahaan_id==$perusahaan->perusahaan_id):?>
                <?php echo $perusahaan->name;?>
              <?php endif;?>
              <?php } ?></td>
            </tr>
            <tr>
              <th><?php echo $this->lang->line('dashboard_single_karyawan');?></th>
              <td style="display: table-cell;"><?php foreach(explode(',',$karyawan_id) as $tunjuk_id) {?>
                <?php $assigned_to = $this->Umb_model->read_user_info($tunjuk_id);?>
                <?php echo $assigned_to[0]->first_name.' '.$assigned_to[0]->last_name.'<br>';?>
                <?php //endif;?>
                <?php } ?></td>
              </tr>
              <tr>
                <th><?php echo $this->lang->line('umb_hr_title_meeting');?></th>
                <td style="display: table-cell;"><?php echo $title_meeting;?></td>
              </tr>
              <tr>
                <th><?php echo $this->lang->line('umb_hr_tanggal_meeting');?></th>
                <td style="display: table-cell;"><?php echo $this->Umb_model->set_date_format($tanggal_meeting);?></td>
              </tr>
              <?php $waktu_meeting = new DateTime($waktu_meeting);?>
              <tr>
                <th><?php echo $this->lang->line('umb_hr_waktu_meeting');?></th>
                <td style="display: table-cell;"><?php echo $waktu_meeting->format('h:i a');?></td>
              </tr>
              <tr>
                <th><?php echo $this->lang->line('umb_meeting_room');?></th>
                <td style="display: table-cell;"><?php echo $meeting_room;?></td>
              </tr>
              <tr>
                <th><?php echo $this->lang->line('umb_hr_meeting_note');?></th>
                <td style="display: table-cell;"><?php echo html_entity_decode($meeting_note);?></td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('umb_close');?></button>
        </div>
        <?php echo form_close(); ?>
      <?php } else if(isset($_GET['jd']) && isset($_GET['meeting_id']) && $_GET['data']=='meeting'){
        ?>
        <?php $session = $this->session->userdata('username');?>
        <?php $user_info = $this->Umb_model->read_user_info($session['user_id']);?>
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
          <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_hr_edit_meeting');?></h4>
        </div>
        <?php $attributes = array('name' => 'edit_meeting', 'id' => 'edit_meeting', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
        <?php $hidden = array('_method' => 'EDIT', '_token' => $meeting_id, 'ext_name' => $meeting_id);?>
        <?php echo form_open('admin/meetings/edit_meeting/'.$meeting_id, $attributes, $hidden);?>
        <div class="modal-body">
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="title"><?php echo $this->lang->line('umb_hr_title_meeting');?></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('umb_hr_title_meeting');?>" name="title_meeting" type="text" value="<?php echo $title_meeting;?>">
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="start_date"><?php echo $this->lang->line('umb_hr_tanggal_meeting');?></label>
                    <input class="form-control mdate" name="tanggal_meeting" readonly="true" type="text" value="<?php echo $tanggal_meeting;?>">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="end_date"><?php echo $this->lang->line('umb_hr_waktu_meeting');?></label>
                    <input class="form-control mtimepicker" name="waktu_meeting" readonly="true" type="text" value="<?php echo $waktu_meeting;?>">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="meeting_room"><?php echo $this->lang->line('umb_meeting_room');?></label>
                    <input type="text" class="form-control" name="meeting_room" placeholder="<?php echo $this->lang->line('umb_meeting_room');?>" value="<?php echo $meeting_room;?>">
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="description"><?php echo $this->lang->line('umb_hr_meeting_note');?></label>
                <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('umb_hr_meeting_note');?>" name="meeting_note" cols="30" rows="5" id="meeting_note2"><?php echo $meeting_note;?></textarea>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="meeting_color"><?php echo $this->lang->line('umb_meeting_color');?></label>
                <input type="text" class="form-control md-minicolors-brightness" value="<?php echo $meeting_color;?>" name="meeting_color" readonly="readonly">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('umb_close');?></button>
          <button type="submit" class="btn btn-primary"><?php echo $this->lang->line('umb_update');?></button>
        </div>
        <?php echo form_close(); ?>
        <script type="text/javascript">
         $(document).ready(function(){
           
           $('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
           $('[data-plugin="select_hrm"]').select2({ width:'100%' });	 
           Ladda.bind('button[type=submit]');
           var isRtl = $('body').attr('dir') === 'rtl' || $('html').attr('dir') === 'rtl';
           $('.md-minicolors-brightness').minicolors({
            control:  'brightness',
            position: 'top ' + (isRtl ? 'right' : 'left'),
          });
	// Date
	$('.mdate').bootstrapMaterialDatePicker({
		weekStart: 0,
		time: false,
		clearButton: false,
		format: 'YYYY-MM-DD'
	});
	$('.mtimepicker').bootstrapMaterialDatePicker({
		date: false,
		shortTime: true,
		format: 'HH:mm'
	});
	jQuery("#aj_perusahaanx").change(function(){
		jQuery.get(base_url+"/get_karyawans/"+jQuery(this).val(), function(data, status){
			jQuery('#ajaxx_karyawan').html(data);
		});
	});
	/* Edit*/
	$("#edit_meeting").submit(function(e){
   
   e.preventDefault();
   var obj = $(this), action = obj.attr('name');
   $('.save').prop('disabled', true);
   $.ajax({
     type: "POST",
     url: e.target.action,
     data: obj.serialize()+"&is_ajax=2&edit_type=meeting&form="+action,
     cache: false,
     success: function (JSON) {
      if (JSON.error != '') {
       toastr.error(JSON.error);
       $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
       $('.save').prop('disabled', false);
       Ladda.stopAll();
     } else {
       $('.edit-modal-data').modal('toggle');
       var umb_table = $('#umb_table').dataTable({
        "bDestroy": true,
        "ajax": {
         url : "<?php echo site_url("admin/meetings/list_meetings") ?>",
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
});	
</script>
<?php } ?>
