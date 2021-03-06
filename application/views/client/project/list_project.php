<?php
/* Projects List view
*/
?>
<?php $session = $this->session->userdata('client_username');?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>

<div class="card <?php echo $get_animate;?>">
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_list_all');?></strong> <?php echo $this->lang->line('umb_projects');?></span> </div>
  <div class="card-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="umb_table_project">
        <thead>
          <tr>
            <th><?php echo $this->lang->line('umb_ringkasan_project');?></th>
            <th><?php echo $this->lang->line('umb_p_priority');?></th>
            <th><?php echo $this->lang->line('umb_p_enddate');?></th>
            <th><?php echo $this->lang->line('dashboard_umb_progress');?></th>
            <th><?php echo $this->lang->line('umb_project_users');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
<style type="text/css">
  .info-box-number {
    font-size:16px !important;
    font-weight:300 !important;
  }
</style>