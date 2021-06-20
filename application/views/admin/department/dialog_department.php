<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['department_id']) && $_GET['data']=='department'){
	?>

	<div class="modal-header"> <?php echo form_button(array('aria-label' => 'Close', 'data-dismiss' => 'modal', 'type' => 'button', 'class' => 'close', 'content' => '<span aria-hidden="true">×</span>')); ?>
	<h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_department_edit');?></h4>
</div>
<?php $attributes = array('name' => 'edit_department', 'id' => 'edit_department', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $department_id, 'ext_name' => $nama_department);?>
<?php echo form_open('admin/department/update/'.$department_id, $attributes, $hidden);?>
<div class="modal-body">
	<div class="form-group">
		<label for="department-name" class="form-control-label"><?php echo $this->lang->line('umb_name');?>:</label>
		<input type="text" class="form-control" name="nama_department" value="<?php echo $nama_department?>">
	</div>
	<div class="form-group">
		<label for="first_name"><?php echo $this->lang->line('left_perusahaan');?></label>
		<select class="form-control" name="perusahaan_id" id="ajx_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_perusahaan');?>">
			<option value=""></option>
			<?php foreach($get_all_perusahaans as $perusahaan) {?>
				<option value="<?php echo $perusahaan->perusahaan_id?>"<?php if($perusahaan_id==$perusahaan->perusahaan_id):?> selected="selected"<?php endif;?>><?php echo $perusahaan->name?></option>
			<?php } ?>
		</select>
	</div>
	<?php $result2 = $this->Department_model->ajax_informasi_location($perusahaan_id);?>
	<div class="form-group" id="ajaxx_location">
		<label for="name"><?php echo $this->lang->line('left_location');?></label>
		<select name="location_id" id="location_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_location');?>">
			<?php foreach($result2 as $location) {?>
				<option value="<?php echo $location->location_id?>" <?php if($location_id==$location->location_id):?> selected="selected"<?php endif;?>><?php echo $location->nama_location?></option>
			<?php } ?>
		</select>
	</div>
	<div class="form-group" id="ajx_karyawan">
		<label for="name"><?php echo $this->lang->line('umb_department_head');?></label>
		<select name="karyawan_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_department_head');?>">
			<option value=""></option>
			<?php $result = $this->Department_model->ajax_info_perusahaan_karyawan($perusahaan_id);?>
			<?php foreach($result as $karyawan) {?>
				<option value="<?php echo $karyawan->user_id;?>" <?php if($karyawan_id==$karyawan->user_id):?> selected="selected"<?php endif;?>> <?php echo $karyawan->first_name.' '.$karyawan->last_name;?></option>
			<?php } ?>
		</select>
	</div>
</div>
<div class="modal-footer"> <?php echo form_button(array('data-dismiss' => 'modal', 'type' => 'button', 'class' => 'btn btn-secondary', 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('umb_close'))); ?> <?php echo form_button(array('name' => 'hrastral_form', 'type' => 'submit', 'class' => $this->Umb_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('umb_update'))); ?> </div>
<?php echo form_close(); ?> 
<script type="text/javascript">
	$(document).ready(function(){
		
		$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
		$('[data-plugin="select_hrm"]').select2({ width:'100%' });	 
		
		jQuery("#ajx_perusahaan").change(function(){
			jQuery.get(base_url+"/get_karyawans/"+jQuery(this).val(), function(data, status){
				jQuery('#ajx_karyawan').html(data);
			});
			jQuery.get(base_url+"/get_locations_perusahaan/"+jQuery(this).val(), function(data, status){
				jQuery('#ajaxx_location').html(data);
			});
		});	 
		Ladda.bind('button[type=submit]');
		/*jQuery("#aj_perusahaan").change(function(){
		jQuery.get(escapeHtmlSecure(base_url+"/get_locations_perusahaan/"+jQuery(this).val()), function(data, status){
			jQuery('#ajax_location').html(data);
		});
	});*/
	/* Edit data */
	$("#edit_department").submit(function(e){
		e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=1&edit_type=department&form="+action,
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
								url : "<?php echo htmlspecialchars(site_url("admin/department/list_department")); ?>",
								type : 'GET'
							},
							"fnDrawCallback": function(settings){
								$('[data-toggle="tooltip"]').tooltip();          
							}
						});
						umb_table.api().ajax.reload(function(){ 
							toastr.success(JSON.result);
							$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
						}, true);
						$('.edit-modal-data').modal('toggle');
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
