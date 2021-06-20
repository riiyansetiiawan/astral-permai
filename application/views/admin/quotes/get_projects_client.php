<?php $result = $this->Umb_model->get_panel_projects_client($client_id);?>
<div class="form-group">
  <label for="umb_project"><?php echo $this->lang->line('umb_project');?></label>
   <select name="project" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_project');?>">
    <option value=""></option>
    <?php foreach($result as $project) {?>
    <option value="<?php echo $project->project_id;?>"> <?php echo $project->title;?></option>
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