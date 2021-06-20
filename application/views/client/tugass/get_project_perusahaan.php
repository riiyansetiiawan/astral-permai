<?php $result = $this->Project_model->ajax_perusahaan_projects($perusahaan_id);?>
<div class="form-group" id="ajax_project">
	<label for="ajax_project" class="control-label"><?php echo $this->lang->line('umb_project');?></label>
	<select class="form-control" name="project_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_project');?>">
		<option value=""></option>
		<?php foreach($result as $project) {?>
			<option value="<?php echo $project->project_id?>"> <?php echo $project->title;?></option>
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
	});
</script>