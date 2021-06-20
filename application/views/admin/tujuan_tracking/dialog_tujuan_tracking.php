<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['tracking_id']) && $_GET['data']=='tracking'){

  ?>
  <?php $session = $this->session->userdata('username');?>
  <?php $user_info = $this->Umb_model->read_user_info($session['user_id']);?>
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
    <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_hr_edit_tujuan_title');?></h4>
  </div>
  <?php $attributes = array('name' => 'edit_tujuan', 'id' => 'edit_tujuan', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
  <?php $hidden = array('_method' => 'EDIT', '_token' => $tracking_id, 'ext_name' => $tracking_id);?>
  <?php echo form_open('admin/tujuan_tracking/update_tujuan/'.$tracking_id, $attributes, $hidden);?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-6">
        <?php if($user_info[0]->user_role_id==1){ ?>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="nama_perusahaan"><?php echo $this->lang->line('module_title_perusahaan');?></label>
                <select class="form-control" name="perusahaan" id="ajx_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_title_perusahaan');?>">
                  <option value=""><?php echo $this->lang->line('umb_select_one');?></option>
                  <?php foreach($all_perusahaans as $perusahaan) {?>
                    <option value="<?php echo $perusahaan->perusahaan_id;?>" <?php if($perusahaan_id==$perusahaan->perusahaan_id):?> selected="selected" <?php endif;?>> <?php echo $perusahaan->name;?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div>
        <?php } else {?>
          <?php $eperusahaan_id = $user_info[0]->perusahaan_id;?>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="nama_perusahaan"><?php echo $this->lang->line('module_title_perusahaan');?></label>
                <select class="form-control" name="perusahaan" id="ajx_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_title_perusahaan');?>">
                  <option value=""><?php echo $this->lang->line('umb_select_one');?></option>
                  <?php foreach($all_perusahaans as $perusahaan) {?>
                    <?php if($eperusahaan_id == $perusahaan->perusahaan_id):?>
                      <option value="<?php echo $perusahaan->perusahaan_id;?>" <?php if($perusahaan_id==$perusahaan->perusahaan_id):?> selected="selected" <?php endif;?>> <?php echo $perusahaan->name;?></option>
                    <?php endif;?>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div>
        <?php } ?>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="type_tracking"><?php echo $this->lang->line('umb_hr_type_tujuan_tracking_se');?></label>
              <select class="form-control" name="type_tracking" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_hr_type_tujuan_tracking_se');?>">
                <option value=""></option>
                <?php foreach($all_types_tracking as $type_tracking) {?>
                  <option value="<?php echo $type_tracking->type_tracking_id?>" <?php if($type_tracking_id==$type_tracking->type_tracking_id):?> selected="selected" <?php endif;?>><?php echo $type_tracking->type_name;?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="subject"><?php echo $this->lang->line('umb_subject');?></label>
              <input class="form-control" placeholder="<?php echo $this->lang->line('umb_subject');?>" name="subject" type="text" value="<?php echo $subject;?>">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="target_achiement"><?php echo $this->lang->line('umb_hr_target_achiement');?></label>
              <input class="form-control" placeholder="<?php echo $this->lang->line('umb_hr_target_achiement');?>" name="target_achiement" type="text" value="<?php echo $target_achiement;?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="start_date"><?php echo $this->lang->line('umb_start_date');?></label>
              <input class="form-control d_date" placeholder="<?php echo $this->lang->line('umb_start_date');?>" readonly="true" name="start_date" type="text" value="<?php echo $start_date;?>">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="end_date"><?php echo $this->lang->line('umb_end_date');?></label>
              <input class="form-control d_date" placeholder="<?php echo $this->lang->line('umb_end_date');?>" readonly="true" name="end_date" type="text" value="<?php echo $end_date;?>">
            </div>
          </div>
        </div>
        
      </div>
      <div class="col-md-6">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="description"><?php echo $this->lang->line('umb_description');?></label>
              <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('umb_description');?>" name="description" rows="5" id="description2"><?php echo $description;?></textarea>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
            	<input type="hidden" id="progres_val" name="progres_val" value="<?php echo $tujuan_progress;?>">
              <label for="progress"><?php echo $this->lang->line('dashboard_umb_progress');?></label>
              <input type="text" id="range_grid">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="status"><?php echo $this->lang->line('dashboard_umb_status');?></label>
              <select name="status" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_choose_status');?>...">
                <option value="0" <?php if($tujuan_status=='0'):?> selected <?php endif; ?>><?php echo $this->lang->line('umb_not_started');?></option>
                <option value="1" <?php if($tujuan_status=='1'):?> selected <?php endif; ?>><?php echo $this->lang->line('umb_in_progress');?></option>
                <option value="2" <?php if($tujuan_status=='2'):?> selected <?php endif; ?>><?php echo $this->lang->line('umb_completed');?></option>
              </select>
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
      
     $('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
     $('[data-plugin="select_hrm"]').select2({ width:'100%' });	 	 
     Ladda.bind('button[type=submit]');

	//$('#description2').trumbowyg();
	$('.d_date').bootstrapMaterialDatePicker({
		weekStart: 0,
		time: false,
		clearButton: false,
		format: 'YYYY-MM-DD'
	});

	/* Edit data */
	$("#edit_tujuan").submit(function(e){
   e.preventDefault();
   var obj = $(this), action = obj.attr('name');
   $('.save').prop('disabled', true);
   $.ajax({
     type: "POST",
     url: e.target.action,
     data: obj.serialize()+"&is_ajax=1&edit_type=tracking&form="+action,
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
            url : "<?php echo site_url("admin/tujuan_tracking/list_tujuan_tracking") ?>",
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
					$('.edit-modal-data').modal('toggle');
					$('.save').prop('disabled', false);
					Ladda.stopAll();
				}
			}
		});
 });
});	
</script>
<script type="text/javascript">
  $(document).ready(function(){	
   $("#range_grid").ionRangeSlider({
    type: "single",
    min: 0,
    max: 100,
    from: '<?php echo $tujuan_progress;?>',
    grid: true,
    force_edges: true,
    onChange: function (data) {
     $('#progres_val').val(data.from);
   }
 });
 });
</script>
<?php } else if(isset($_GET['jd']) && isset($_GET['tracking_id']) && $_GET['data']=='view_tracking'){
  ?>

  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  </div>
  <form class="m-b-1">
    <div class="modal-body">
      <h4 class="text-center text-big mb-4"><strong><?php echo $this->lang->line('umb_hr_view_tujuan_title');?></strong></h4>
      <div class="table-responsive" data-pattern="priority-columns">
        <table class="footable-details table table-striped table-hover toggle-circle">
          <tbody>
            <tr>
              <th><?php echo $this->lang->line('module_title_perusahaan');?></th>
              <td style="display: table-cell;"><?php foreach($all_perusahaans as $perusahaan) {?><?php if($perusahaan->perusahaan_id==$perusahaan_id):?> <?php echo $perusahaan->name?> <?php endif;?><?php } ?></td>
            </tr>
            <?php
	// get tracking type
            $type = $this->Tujuan_tracking_model->read_informasi_type_tracking($type_tracking_id);
            if(!is_null($type)){
             $itype = $type[0]->type_name;
           } else {
             $itype = '--';	
           }
           ?>
           <tr>
            <th><?php echo $this->lang->line('umb_hr_type_tujuan_tracking_se');?></th>
            <td style="display: table-cell;"><?php echo $itype;?></td>
          </tr>
          <tr>
            <th><?php echo $this->lang->line('umb_subject');?></th>
            <td style="display: table-cell;"><?php echo $subject;?></td>
          </tr>
          <tr>
            <th><?php echo $this->lang->line('umb_hr_target_achiement');?></th>
            <td style="display: table-cell;"><?php echo $target_achiement;?></td>
          </tr>
          <tr>
            <th><?php echo $this->lang->line('umb_start_date');?></th>
            <td style="display: table-cell;"><?php echo $start_date;?></td>
          </tr>
          <tr>
            <th><?php echo $this->lang->line('umb_end_date');?></th>
            <td style="display: table-cell;"><?php echo $end_date;?></td>
          </tr>
          <?php
	  //progress_project
          if($tujuan_progress <= 20) {
           $progress_class = 'bg-danger';
         } else if($tujuan_progress > 20 && $tujuan_progress <= 50){
           $progress_class = 'bg-warning';
         } else if($tujuan_progress > 50 && $tujuan_progress <= 75){
           $progress_class = 'bg-info';
         } else {
           $progress_class = 'bg-success';
         }
         
		// progress
         $pbar = '<p class="m-b-0-5">'.$this->lang->line('umb_completed').'</p><div class="progress"><div class="progress-bar '.$progress_class.' progress-sm" style="width: '.$tujuan_progress.'%;">'.$tujuan_progress.'%</div></div>';
         
		//$pbar = '<p class="m-b-0-5">'.$this->lang->line('umb_completed').' <span class="pull-xs-right">'.$tujuan_progress.'%</span></p><progress class="progress '.$progress_class.' progress-sm" value="'.$tujuan_progress.'" max="100">'.$tujuan_progress.'%</progress>';
         ?>
         <?php 
         if($tujuan_status=='0'): $status = $this->lang->line('umb_not_started');
          elseif($tujuan_status=='1'): $status = $this->lang->line('umb_in_progress');
            else: $tujuan_status = $this->lang->line('umb_completed');
            endif; ?>
            <tr>
              <th><?php echo $this->lang->line('dashboard_umb_status');?></th>
              <td style="display: table-cell;"><?php echo $status;?></td>
            </tr>
            <tr>
              <th><?php echo $this->lang->line('dashboard_umb_progress');?></th>
              <td style="display: table-cell;"><?php echo $pbar;?></td>
            </tr>
            <tr>
              <th><?php echo $this->lang->line('umb_description');?></th>
              <td style="display: table-cell;"><?php echo html_entity_decode($description);?></td>
            </tr>
          </tbody>
        </table>   
      </div> 
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('umb_close');?></button>
    </div>
    <?php echo form_close(); ?>
  <?php }
  ?>
