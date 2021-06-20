<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['type_tracking_id']) && $_GET['data']=='type_tracking'){
?>

<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_hr_edit_type_tujuan_tracking');?></h4>
</div>
<?php $attributes = array('name' => 'edit_type', 'id' => 'edit_type', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $type_tracking_id, 'ext_name' => $type_tracking_id);?>
<?php echo form_open('admin/tujuan_tracking/update_type/'.$type_tracking_id, $attributes, $hidden);?>
  <div class="modal-body">
    <div class="form-group">
      <label for="type_name" class="form-control-label"><?php echo $this->lang->line('umb_hr_type_tujuan_tracking_se');?></label>
      <input type="text" class="form-control" name="type_name" value="<?php echo $type_name?>" placeholder="<?php echo $this->lang->line('umb_hr_type_tujuan_tracking_se');?>">
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
	/* Edit data */
	$("#edit_type").submit(function(e){
	
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=2&edit_type=type_tracking&edit=1&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
					Ladda.stopAll();
				} else {
					$('.edit-modal-data').modal('toggle');
					// On page load: datatable
					var umb_table = $('#umb_table').dataTable({
						"bDestroy": true,
						"ajax": {
							url : "<?php echo site_url("admin/tujuan_tracking/list_type") ?>",
							type : 'GET'
						},
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
<?php }
?>
