<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['exit_id']) && $_GET['data']=='exit'){
  ?>
  <?php $session = $this->session->userdata('username');?>
  <?php $user_info = $this->Umb_model->read_user_info($session['user_id']);?>
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
    <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_edit_karyawan_exit');?></h4>
  </div>
  <?php $attributes = array('name' => 'edit_exit', 'id' => 'edit_exit', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
  <?php $hidden = array('_method' => 'EDIT', '_token' => $exit_id, 'ext_name' => $exit_id);?>
  <?php echo form_open('admin/karyawan_exit/update/'.$exit_id, $attributes, $hidden);?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-6">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="exit_tanggal"><?php echo $this->lang->line('umb_exit_tanggal');?><i class="hrastral-asterisk">*</i></label>
              <input class="form-control d_date" placeholder="<?php echo $this->lang->line('umb_exit_tanggal');?>" readonly name="exit_tanggal" type="text" value="<?php echo $exit_tanggal;?>">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="type"><?php echo $this->lang->line('umb_type_of_exit');?><i class="hrastral-asterisk">*</i></label>
              <select class="select2" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_type_of_exit');?>" name="type">
                <option value=""></option>
                <?php foreach($all_types_exit as $type_exit) {?>
                  <option value="<?php echo $type_exit->type_exit_id?>" <?php if($type_exit->type_exit_id==$type_exit_id):?> selected="selected"<?php endif;?>><?php echo $type_exit->type;?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
        <input type="hidden" name="karyawan_id" value="<?php echo $karyawan_id;?>" />
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="exit_interview"><?php echo $this->lang->line('umb_exit_interview');?><i class="hrastral-asterisk">*</i></label>
              <select class="select2" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_exit_interview');?><" name="exit_interview">
                <option value="1" <?php if(1==$exit_interview):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('umb_yes');?></option>
                <option value="0" <?php if(0==$exit_interview):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('umb_no');?></option>
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="is_inactivate_account"><?php echo $this->lang->line('umb_exit_inactive_karyawan_account');?><i class="hrastral-asterisk">*</i></label>
              <select class="select2" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_exit_inactive_karyawan_account');?>" name="is_inactivate_account">
                <option value="1" <?php if(1==$is_inactivate_account):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('umb_yes');?></option>
                <option value="0" <?php if(0==$is_inactivate_account):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('umb_no');?></option>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="description"><?php echo $this->lang->line('umb_description');?></label>
              <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('umb_description');?>" name="reason" cols="30" rows="5" id="reason2"><?php echo $reason;?></textarea>
            </div>
          </div>
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
      
     jQuery("#ajx_perusahaan").change(function(){
      jQuery.get(base_url+"/get_karyawans/"+jQuery(this).val(), function(data, status){
       jQuery('#ajx_karyawan').html(data);
     });
    });
     
     $('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
     $('[data-plugin="select_hrm"]').select2({ width:'100%' });	 
     
	//$('#reason2').trumbowyg();	 
	Ladda.bind('button[type=submit]');
	
	$('.d_date').bootstrapMaterialDatePicker({
		weekStart: 0,
		time: false,
		clearButton: false,
		format: 'YYYY-MM-DD'
	});

	/* Edit data */
	$("#edit_exit").submit(function(e){
   e.preventDefault();
   var obj = $(this), action = obj.attr('name');
   $('.save').prop('disabled', true);
   $.ajax({
     type: "POST",
     url: e.target.action,
     data: obj.serialize()+"&is_ajax=1&edit_type=exit&form="+action,
     cache: false,
     success: function (JSON) {
      if (JSON.error != '') {
       toastr.error(JSON.error);
       $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
       $('.save').prop('disabled', false);
       Ladda.stopAll();
     } else {
					// On page load: datatable
					var umb_table = $('#umb_table').dataTable({
           "bDestroy": true,
           "ajax": {
            url : "<?php echo site_url("admin/karyawan_exit/list_exit") ?>",
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
					$('.edit-modal-data').modal('toggle');
					$('.save').prop('disabled', false);
					Ladda.stopAll();
				}
			}
		});
 });
});	
</script>
<?php } else if(isset($_GET['jd']) && isset($_GET['exit_id']) && $_GET['data']=='view_exit'){
  ?>
  <form class="m-b-1">
    <div class="modal-body">
      <p class="text-center text-big mb-4"><strong><?php echo $this->lang->line('umb_view_karyawan_exit');?></strong></p>
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
              <th><?php echo $this->lang->line('umb_karyawan_to_exit');?></th>
              <td style="display: table-cell;"><?php foreach($all_karyawans as $karyawan) {?>
                <?php if($karyawan_id==$karyawan->user_id):?>
                  <?php echo $karyawan->first_name.' '.$karyawan->last_name;?>
                <?php endif;?>
                <?php } ?></td>
              </tr>
              <tr>
                <th><?php echo $this->lang->line('umb_exit_tanggal');?></th>
                <td style="display: table-cell;"><?php echo $this->Umb_model->set_date_format($exit_tanggal);?></td>
              </tr>
              <tr>
                <th><?php echo $this->lang->line('umb_type_of_exit');?></th>
                <td style="display: table-cell;"><?php foreach($all_types_exit as $type_exit) {?>
                  <?php if($type_exit_id==$type_exit->type_exit_id):?>
                    <?php echo $type_exit->type;?>
                  <?php endif;?>
                  <?php } ?></td>
                </tr>
                <tr>
                  <th><?php echo $this->lang->line('umb_exit_interview');?></th>
                  <td style="display: table-cell;"><?php if($is_inactivate_account=='1'): $in_active = $this->lang->line('umb_yes');?>
                <?php endif; ?>
                <?php if($is_inactivate_account=='0'): $in_active = $this->lang->line('umb_no');?>
                <?php endif; ?>
                <?php echo $in_active;?></td>
              </tr>
              <tr>
                <th><?php echo $this->lang->line('umb_exit_inactive_karyawan_account');?></th>
                <td style="display: table-cell;"><?php if($is_inactivate_account=='1'): $account = $this->lang->line('umb_yes');?>
              <?php endif; ?>
              <?php if($is_inactivate_account=='0'): $account = $this->lang->line('umb_no');?>
              <?php endif; ?>
              <?php echo $account;?></td>
            </tr>
            <tr>
              <th><?php echo $this->lang->line('umb_description');?></th>
              <td style="display: table-cell;"><?php echo html_entity_decode($reason);?></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('umb_close');?></button>
      </div>
      <?php echo form_close(); ?>
    <?php }
    ?>
