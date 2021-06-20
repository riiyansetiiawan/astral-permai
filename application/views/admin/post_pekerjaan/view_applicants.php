<?php
/* Job kandidats view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>
<input type="hidden" id="pekerjaan_id" value="<?php echo $this->uri->segment(4);?>" />
<div class="box <?php echo $get_animate;?>">
  <div class="box-header with-border">
    <h3 class="box-title"> <?php echo $this->lang->line('umb_list_all');?> <?php echo $this->lang->line('umb_title_applicants_pekerjaan');?> </h3>
  </div>
  <div class="box-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="umb_table">
        <thead>
          <tr>
            <th><?php echo $this->lang->line('umb_action');?></th>
            <th><?php echo $this->lang->line('umb_candidate_name');?></th>
            <th><?php echo $this->lang->line('dashboard_email');?></th>
            <th><?php echo $this->lang->line('dashboard_umb_status');?></th>
            <th><?php echo $this->lang->line('umb_pekerjaans_cover_letter');?></th>
            <th><?php echo $this->lang->line('umb_apply_date');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
