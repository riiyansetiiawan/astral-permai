<?php $result = $this->Department_model->ajax_info_perusahaan_karyawan($perusahaan_id);?>
<div class="form-group">
	<label for="umb_department_head"><?php echo $this->lang->line('umb_promotion_untuk');?></label>
	<select name="karyawan_id" id="karyawan_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_choose_an_karyawan');?>">
		<option value=""></option>
		<?php foreach($result as $karyawan) {?>
			<option value="<?php echo $karyawan->user_id;?>"> <?php echo $karyawan->first_name.' '.$karyawan->last_name;?></option>
		<?php } ?>
	</select>             
</div>
<?php
//}
?>
<script type="text/javascript">
	$(document).ready(function(){
		$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
		$('[data-plugin="select_hrm"]').select2({ width:'100%' });
		jQuery("#karyawan_id").change(function(){
			jQuery.get(base_url+"/get_karyawan_penunjukans/"+jQuery(this).val(), function(data, status){
				jQuery('#ajx_penunjukan').html(data);
			});
		});
	});
</script>