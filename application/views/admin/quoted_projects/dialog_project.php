<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['project_id']) && $_GET['data']=='project'){
	$assigned_ids = explode(',',$assigned_to);
	$perusahaan_ids = explode(',',$perusahaan_id);
?>
<?php $session = $this->session->userdata('username');?>
<?php $user_info = $this->Umb_model->read_user_info($session['user_id']);?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_edit_project');?></h4>
</div>
<?php $attributes = array('name' => 'edit_project', 'id' => 'edit_project', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $project_id, 'ext_name' => $title);?>
<?php echo form_open('admin/quoted_projects/update/'.$project_id, $attributes, $hidden);?>
<div class="modal-body">
  <div class="row">
    <div class="col-md-6">
      <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                <label for="title"><?php echo $this->lang->line('umb_title');?></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('umb_title');?>" name="title" type="text" value="<?php echo $title;?>">
              </div>
          </div>
          <div class="col-md-6">
                <div class="form-group">
                <label for="umb_quoted_no_project"><?php echo $this->lang->line('umb_quoted_no_project');?></label>
                <input class="form-control" name="no_project" type="text" value="<?php echo $no_project;?>">
              </div>
          </div>
      </div>
       <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="client_id"><?php echo $this->lang->line('umb_project_client');?></label>
          <select name="client_id" id="client_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_project_client');?>">
            <option value=""></option>
            <?php foreach($all_clients as $client) {?>
            <option value="<?php echo $client->client_id;?>" <?php if($client_id==$client->client_id):?> selected <?php endif; ?>> <?php echo $client->name;?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="col-md-6">
          <div class="form-group">
            <label for="karyawan"><?php echo $this->lang->line('umb_p_priority');?></label>
            <select name="priority" class="form-control select-border-color border-warning" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_p_priority');?>">
              <option value="1" <?php if($priority==1):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('umb_highest');?></option>
              <option value="2" <?php if($priority==2):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('umb_high');?></option>
              <option value="3" <?php if($priority==3):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('umb_normal');?></option>
              <option value="4" <?php if($priority==4):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('umb_low');?></option>
            </select>
          </div>
        </div>
    </div>    
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label for="umb_quote_tanggal"><?php echo $this->lang->line('umb_quote_tanggal');?></label>
            <input class="form-control edate" placeholder="<?php echo $this->lang->line('umb_quote_tanggal');?>" readonly name="estimate_date" type="text" value="<?php echo $estimate_date;?>">
          </div>
        </div>
      </div>
      <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="jam_anggaran"><?php echo $this->lang->line('umb_estimate_hrs');?></label>
          <input class="form-control" placeholder="<?php echo $this->lang->line('umb_estimate_hrs');?>" name="estimate_hrs" type="text" value="<?php echo $estimate_hrs;?>">
        </div>
      </div>
      <div class="col-md-6">
          <div class="form-group">
            <label for="status"><?php echo $this->lang->line('dashboard_umb_status');?></label>
            <select name="status" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_choose_status');?>...">
              <option value="0" <?php if($status=='0'):?> selected <?php endif; ?>><?php echo $this->lang->line('umb_not_started');?></option>
              <option value="1" <?php if($status=='1'):?> selected <?php endif; ?>><?php echo $this->lang->line('umb_in_progress');?></option>
              <option value="2" <?php if($status=='2'):?> selected <?php endif; ?>><?php echo $this->lang->line('umb_completed');?></option>
              <option value="3" <?php if($status=='3'):?> selected <?php endif; ?>><?php echo $this->lang->line('umb_project_cancelled');?></option>
              <option value="4" <?php if($status=='4'):?> selected <?php endif; ?>><?php echo $this->lang->line('umb_project_hold');?></option>
            </select>
            <input type="hidden" id="progres_val" name="progres_val" value="<?php echo $progress_project;?>">
          </div>
        </div>
      </div>
      <div class="row">
    <?php if($user_info[0]->user_role_id==1){ ?>
          <div class="col-md-12">
            <div class="form-group">
              <label for="perusahaan_id"><?php echo $this->lang->line('module_title_perusahaan');?></label>
              <select multiple="multiple" name="perusahaan_id[]" id="aj_perusahaanx" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_title_perusahaan');?>">
                <option value=""></option>
                <?php foreach($all_perusahaans as $perusahaan) {?>
                <option value="<?php echo $perusahaan->perusahaan_id;?>" <?php if(isset($_GET)) { if(in_array($perusahaan->perusahaan_id,$perusahaan_ids)):?> selected <?php endif; }?>> <?php echo $perusahaan->name;?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <?php } else {?>
          <?php $eperusahaan_id = $user_info[0]->perusahaan_id;?>
          <div class="col-md-12">
            <div class="form-group">
              <label for="perusahaan_id"><?php echo $this->lang->line('module_title_perusahaan');?></label>
              <select name="perusahaan_id[]" id="aj_perusahaanx" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_title_perusahaan');?>">
                <option value=""></option>
                <?php foreach($all_perusahaans as $perusahaan) {?>
                <?php if($eperusahaan_id == $perusahaan->perusahaan_id):?>
                <option value="<?php echo $perusahaan->perusahaan_id;?>" <?php if(isset($_GET)) { if(in_array($perusahaan->perusahaan_id,$perusahaan_ids)):?> selected <?php endif; }?>> <?php echo $perusahaan->name;?></option>
                <?php endif;?>
                <?php } ?>
              </select>
            </div>
          </div>
          <?php } ?>
        </div>  
      <div class="row">
    <div class="col-md-12">
      <div class="form-group" id="ajx_m_karyawan">
        <?php $perusahaan_ids = explode(',',$perusahaan_id); ?>
        <label for="karyawan"><?php echo $this->lang->line('umb_project_manager');?></label>
        <select multiple name="assigned_to[]" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_project_manager');?>">
          <option value=""></option>
          <?php foreach($perusahaan_ids as $cid) {?>
		<?php $result = $this->Umb_model->get_multi_perusahaan_karyawans($cid); ?>
        <?php foreach($result as $re) {?>
        <option value="<?php echo $re->user_id;?>" <?php if(isset($_GET)) { if(in_array($re->user_id,$assigned_ids)):?> selected <?php endif; }?>> <?php echo $re->first_name.' '.$re->last_name;?></option>
        <?php } ?>
        <?php } ?>
    
    <!--<?php foreach($result as $karyawan) {?>
          <option value="<?php echo $karyawan->user_id?>" <?php if(isset($_GET)) { if(in_array($karyawan->user_id,$assigned_ids)):?> selected <?php endif; }?>> <?php echo $karyawan->first_name.' '.$karyawan->last_name;?></option>
          <?php } ?>-->
        </select>
      </div>
    </div>
  </div>
    </div>
    <div class="col-md-6">
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label for="description"><?php echo $this->lang->line('umb_description');?></label>
            <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('umb_description');?>" name="description" cols="30" rows="5" id="description2"><?php echo $description;?></textarea>
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group">
            <label for="progress"><?php echo $this->lang->line('dashboard_umb_progress');?></label>
            <input type="text" id="prange_grid">
          </div>
        </div>
        <div class="col-md-12">
      <div class="form-group">
        <label for="summary"><?php echo $this->lang->line('umb_summary');?></label>
        <textarea class="form-control" placeholder="<?php echo $this->lang->line('umb_summary');?>" name="summary" cols="30" rows="4" id="summary"><?php echo $summary;?></textarea>
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
<style type="text/css">
.trumbowyg-box, .trumbowyg-editor { min-height: 185px; }
</style>
<script type="text/javascript">
 $(document).ready(function(){
						 
		 Ladda.bind('button[type=submit]');
		 jQuery("#aj_perusahaanx").change(function(){
			jQuery.get(base_url+"/get_karyawans/?cid="+jQuery(this).val(), function(data, status){
				jQuery('#ajx_m_karyawan').html(data);
			});
		});
		$('#description2').trumbowyg();
		
		$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
		$('[data-plugin="select_hrm"]').select2({ width:'100%' });	 
		
		$('.edate').bootstrapMaterialDatePicker({
			weekStart: 0,
			time: false,
			clearButton: false,
			format: 'YYYY-MM-DD'
		});
		/* Edit data */
		$("#edit_project").submit(function(e){
		e.preventDefault();
			var obj = $(this), action = obj.attr('name');
			$('.save').prop('disabled', true);
			$.ajax({
				type: "POST",
				url: e.target.action,
				data: obj.serialize()+"&is_ajax=1&edit_type=project&form="+action,
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
								url : "<?php echo site_url("admin/quoted_projects/list_project") ?>",
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
	$("#prange_grid").ionRangeSlider({
		type: "single",
		min: 0,
		max: 100,
		from: '<?php echo $progress_project;?>',
		grid: true,
		force_edges: true,
		onChange: function (data) {
			$('#progres_val').val(data.from);
		}
	});
});
</script>
<?php }
?>
