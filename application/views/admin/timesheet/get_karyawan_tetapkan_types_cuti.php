<?php $session = $this->session->userdata('username');?>
<?php $user = $this->Umb_model->read_user_info($karyawan_id); ?>
<?php $kategoris_cuti = explode(',',$user[0]->kategoris_cuti);?>
<div class="form-group">
	<label for="karyawan"><?php echo $this->lang->line('umb_type_cuti');?></label>
	<select class="form-control" id="type_cuti" name="type_cuti" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_type_cuti');?>">
		<option value=""></option>
		<?php foreach($kategoris_cuti as $cuti_cat) {?>
			<?php if($cuti_cat!=0):?>
				<?php
				$sisa_cuti = $this->Timesheet_model->count_total_karyawan_cutii($cuti_cat,$karyawan_id);
				$type = $this->Timesheet_model->read_informasi_type_cuti($cuti_cat);
				if(!is_null($type)){
					$type_name = $type[0]->type_name;
					$total = $type[0]->days_per_year;
					$total_sisa_cuti = $total - $sisa_cuti;	
					?>
					<option value="<?php echo $cuti_cat;?>"> <?php echo $type_name.' ('.$total_sisa_cuti.' '.$this->lang->line('umb_remaining').')';?></option>
				<?php }  endif;?>
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