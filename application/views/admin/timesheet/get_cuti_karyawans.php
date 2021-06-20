<?php $session = $this->session->userdata('username');?>
<?php $user = $this->Umb_model->read_info_karyawan($session['user_id']); ?>
<?php if($user[0]->user_role_id==1) {?>
	<?php $result = $this->Department_model->ajax_info_perusahaan_karyawan($perusahaan_id);?>
<?php } else {?>
	<?php $dep_data = $this->Umb_model->get_perusahaan_department_karyawans($perusahaan_id);?>
	<?php $result = $this->Umb_model->get_department_karyawans($user[0]->department_id);?>
<?php } ?>
<div class="form-group">
	<label for="karyawan"><?php echo $this->lang->line('umb_karyawan');?></label>
	<select name="karyawan_id" id="karyawan_idx" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_choose_an_karyawan');?>" required>
		<option value=""></option>
		<?php foreach($result as $karyawan) {?>
			<option value="<?php echo $karyawan->user_id;?>"> <?php echo $karyawan->first_name.' '.$karyawan->last_name;?></option>
		<?php } ?>
	</select>  
	<span id="sisa_cuti" style="display:none; font-weight:600; color:#F00;">&nbsp;</span>           
</div>
<?php
//}
?>
<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
		jQuery('[data-plugin="select_hrm"]').select2({ width:'100%' });
		jQuery("#karyawan_idx").change(function(){
			var karyawan_id = jQuery(this).val();
			jQuery.get(base_url+"/get_karyawan_tetapkan_types_cuti/"+karyawan_id, function(data, status){
				jQuery('#get_types_cuti').html(data);
			});		
		});
		
	/*jQuery("#type_cuti").change(function(){
		var karyawan_id = jQuery('#karyawan_id').val();
		var type_cuti_id = jQuery(this).val();
		if(type_cuti_id == '' || type_cuti_id == 0) {
			jQuery('#sisa_cuti').show();
			jQuery('#sisa_cuti').html('<?php echo $this->lang->line('umb_error_type_cuti_field');?>');
		} else {
			jQuery.get(base_url+"/get_karyawans_cuti/"+type_cuti_id+"/"+karyawan_id, function(data, status){
				jQuery('#sisa_cuti').show();
				jQuery('#sisa_cuti').html(data);
			});
		}
		alert(karyawan_id + ' - - '+type_cuti_id);
		
	});*/
});
</script>