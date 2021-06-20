<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['tugas_id']) && $_GET['data']=='view_tugas'){
  ?>
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
    <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_view');?> <?php echo $this->lang->line('umb_tugas');?></h4>
  </div>
  <form class="m-b-1">
    <div class="modal-body">
      <table class="footable-details table table-striped table-hover toggle-circle">
        <tbody>
          <tr>
            <th><?php echo $this->lang->line('dashboard_umb_title');?></th>
            <td style="display: table-cell;"><?php echo $nama_tugas;?></td>
          </tr>
          <tr>
            <th><?php echo $this->lang->line('umb_estimated_hour');?></th>
            <td style="display: table-cell;"><?php echo $jam_tugas;?></td>
          </tr>
          <tr>
            <th><?php echo $this->lang->line('umb_start_date');?></th>
            <td style="display: table-cell;"><?php echo $this->Umb_model->set_date_format($start_date);?></td>
          </tr>
          <tr>
            <th><?php echo $this->lang->line('umb_end_date');?></th>
            <td style="display: table-cell;"><?php echo $this->Umb_model->set_date_format($end_date);?></td>
          </tr>
          <tr>
            <th><?php echo $this->lang->line('dashboard_umb_progress');?></th>
            <td style="display: table-cell;"><?php echo $this->lang->line('umb_completed').' '.$progress_tugas;?>%</td>
          </tr>
          <?php if($status_tugas=='0'):?> <?php $tugasstatus = $this->lang->line('umb_not_started');?>
            <?php elseif($status_tugas=='1'):?> <?php $tugasstatus = $this->lang->line('umb_in_progress');?>
              <?php elseif($status_tugas=='2'):?> <?php $tugasstatus = $this->lang->line('umb_completed');?>
                <?php elseif($status_tugas=='3'):?> <?php $tugasstatus = $this->lang->line('umb_deffered');?> <?php endif; ?>
                <tr>
                  <th><?php echo $this->lang->line('dashboard_umb_status');?></th>
                  <td style="display: table-cell;"><?php echo $tugasstatus;?></td>
                </tr>
                <?php $assigned_ids = explode(',',$assigned_to); ?>
                <tr>
                  <th><?php echo $this->lang->line('umb_assigned_to');?></th>
                  <td style="display: table-cell;"><ol><?php foreach($all_karyawans as $karyawan) {?>
                    <?php if(in_array($karyawan->user_id,$assigned_ids)):?> <li><?php echo $karyawan->first_name.' '.$karyawan->last_name;?> </li>
                  <?php endif;?>
                  <?php } ?></ol></td>
                </tr>
                <tr>
                  <th><?php echo $this->lang->line('umb_description');?> <?php echo str_word_count($description);?></th>
                  <td style="display: table-cell;">
                    <?php if(str_word_count($description) > 65) { ?>
                      <div style="overflow:auto; height:200px;"><?php echo html_entity_decode($description);?></div>
                      <?php } else { ?> <?php echo html_entity_decode($description);?> <?php } ?></td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('umb_close');?></button>
              </div>
              <?php echo form_close(); ?>
            <?php } else if(isset($_GET['jd']) && isset($_GET['tugas_id']) && $_GET['data']=='tugas'){
             $assigned_ids = explode(',',$assigned_to);
             ?>
             <?php $session = $this->session->userdata('username');?>
             <?php $user_info = $this->Umb_model->read_user_info($session['user_id']);?>
             <?php $system = $this->Umb_model->read_setting_info(1); ?>
             <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
              <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_edit_tugas');?></h4>
            </div>
            <?php $attributes = array('name' => 'edit_tugas', 'id' => 'edit_tugas', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
            <?php $hidden = array('_method' => 'EDIT', '_token' => $tugas_id, 'ext_name' => $tugas_id);?>
            <?php echo form_open('admin/timesheet/edit_tugas/'.$tugas_id, $attributes, $hidden);?>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                   <?php $kategoris_tugas = $this->Project_model->get_kategoris_tugas(); ?>
                   <label for="nama_tugas"><?php echo $this->lang->line('dashboard_umb_title');?></label>
                   <input class="form-control" placeholder="<?php echo $this->lang->line('dashboard_umb_title');?>" name="nama_tugas" type="text" value="<?php echo $nama_tugas;?>">
                 </div>
                 <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="start_date"><?php echo $this->lang->line('umb_start_date');?></label>
                      <input class="form-control edate" placeholder="<?php echo $this->lang->line('umb_start_date');?>" readonly="true" name="start_date" type="text" value="<?php echo $start_date;?>">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="end_date"><?php echo $this->lang->line('umb_end_date');?></label>
                      <input class="form-control edate" placeholder="<?php echo $this->lang->line('umb_end_date');?>" readonly="true" name="end_date" type="text" value="<?php echo $end_date;?>">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="jam_tugas" class="control-label"><?php echo $this->lang->line('umb_estimated_hour');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('umb_estimated_hour');?>" name="jam_tugas" type="text" value="<?php echo $jam_tugas;?>">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="karyawans" class="control-label"><?php echo $this->lang->line('umb_project');?></label>
                      <select class="form-control" name="project_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_project');?>">
                        <option value=""></option>
                        <?php foreach($all_projects as $project) {?>
                          <option value="<?php echo $project->project_id;?>" <?php if($projectid==$project->project_id):?> selected="selected"<?php endif;?>> <?php echo $project->title;?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <?php if($user_info[0]->user_role_id==1){ ?>
                   <?php $all_karyawans = $all_karyawans;?>
                 <?php } else {?>
                   <?php $result = $this->Department_model->ajax_info_perusahaan_karyawan($perusahaan_id);?>
                   <?php $all_karyawans = $result;?>
                 <?php } ?>
                 <div class="col-md-12">
                  <div class="form-group">
                    <label for="karyawans" class="control-label"><?php echo $this->lang->line('umb_assigned_to');?></label>
                    <select multiple class="form-control" name="assigned_to[]" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('dashboard_single_karyawan');?>">
                      <option value=""></option>
                      <?php foreach($all_karyawans as $karyawan) {?>
                        <option value="<?php echo $karyawan->user_id?>" <?php if(in_array($karyawan->user_id,$assigned_ids)):?> selected 
                          <?php endif;?>> <?php echo $karyawan->first_name.' '.$karyawan->last_name;?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="description"><?php echo $this->lang->line('umb_description');?></label>
                  <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('umb_description');?>" name="description"  id="description2"><?php echo $description;?></textarea>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('umb_close');?></button>
            <button type="submit" class="btn btn-primary"><?php echo $this->lang->line('umb_update');?></button>
          </div>
          <?php echo form_close(); ?>
          <style type="text/css">.trumbowyg-box, .trumbowyg-editor { min-height: 105px; }</style>
          <script type="text/javascript">var site_url = '<?php //echo site_url().$_GET['mname']; ?>/';</script>
          <script type="text/javascript">
           $(document).ready(function(){
             
            $('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
            $('[data-plugin="select_hrm"]').select2({ width:'100%' });	 
            
		//$('#description2').trumbowyg();
		// Date
		$('.edate').bootstrapMaterialDatePicker({
			weekStart: 0,
			time: false,
			clearButton: false,
			format: 'YYYY-MM-DD'
		});
		Ladda.bind('button[type=submit]');

		/* Edit data */
		$("#edit_tugas").submit(function(e){
      e.preventDefault();
      var obj = $(this), action = obj.attr('name');
      $('.save').prop('disabled', true);
      $.ajax({
        type: "POST",
        url: e.target.action,
        data: obj.serialize()+"&is_ajax=1&edit_type=tugas&form="+action,
        cache: false,
        success: function (JSON) {
         if (JSON.error != '') {
          toastr.error(JSON.error);
          $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
          $('.save').prop('disabled', false);
          Ladda.stopAll();
        } else {
          <?php if($system[0]->show_tugass=='0'){?>
						// On page load: datatable
						var umb_table = $('#umb_table').dataTable({
              "bDestroy": true,
              "ajax": {
               url : "<?php echo site_url('admin/timesheet/list_tugas/');?>",
               type : 'GET'
             },
             "fnDrawCallback": function(settings){
              $('[data-toggle="tooltip"]').tooltip();          
            }
          });
						umb_table.api().ajax.reload(function(){ 
							toastr.success(JSON.result);
						}, true);
          <?php } else {?>
           toastr.success(JSON.result);
           window.location = '';
         <?php } ?>
         $('.edit-modal-data').modal('toggle');
         $('.save').prop('disabled', false);
         $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
         Ladda.stopAll();
       }
     }
   });
    });
	});	
</script>
<?php } else if(isset($_GET['jd']) && isset($_GET['tugas_id']) && $_GET['data']=='project_tugas'){
	$assigned_ids = explode(',',$assigned_to);
  ?>
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
    <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_edit_tugas');?></h4>
  </div>
  <?php $attributes = array('name' => 'edit_tugas', 'id' => 'edit_tugas', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
  <?php $hidden = array('_method' => 'EDIT', '_token' => $tugas_id, 'ext_name' => $tugas_id);?>
  <?php echo form_open('admin/timesheet/edit_tugas/'.$tugas_id, $attributes, $hidden);?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="nama_tugas"><?php echo $this->lang->line('dashboard_umb_title');?></label>
          <input class="form-control" placeholder="<?php echo $this->lang->line('dashboard_umb_title');?>" name="nama_tugas" type="text" value="<?php echo $nama_tugas;?>">
        </div>
        <div class="row">
          <div class="col-md-6">
            <input type="hidden" name="project_id" id="tproject_id" value="<?php echo $project_id;?>" />
            <div class="form-group">
              <label for="start_date"><?php echo $this->lang->line('umb_start_date');?></label>
              <input class="form-control edate" placeholder="<?php echo $this->lang->line('umb_start_date');?>" readonly="true" name="start_date" type="text" value="<?php echo $start_date;?>">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="end_date"><?php echo $this->lang->line('umb_end_date');?></label>
              <input class="form-control edate" placeholder="<?php echo $this->lang->line('umb_end_date');?>" readonly="true" name="end_date" type="text" value="<?php echo $end_date;?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="jam_tugas" class="control-label"><?php echo $this->lang->line('umb_estimated_hour');?></label>
              <input class="form-control" placeholder="<?php echo $this->lang->line('umb_estimated_hour');?>" name="jam_tugas" type="text" value="<?php echo $jam_tugas;?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="karyawans" class="control-label"><?php echo $this->lang->line('umb_assigned_to');?></label>
              <select multiple class="form-control" name="assigned_to[]" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('dashboard_single_karyawan');?>">
                <option value=""></option>
                <?php foreach($all_karyawans as $karyawan) {?>
                  <option value="<?php echo $karyawan->user_id?>" <?php if(in_array($karyawan->user_id,$assigned_ids)):?> selected 
                    <?php endif;?>> <?php echo $karyawan->first_name.' '.$karyawan->last_name;?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="description"><?php echo $this->lang->line('umb_description');?></label>
            <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('umb_description');?>" name="description"  id="description2"><?php echo $description;?></textarea>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('umb_close');?></button>
      <button type="submit" class="btn btn-primary"><?php echo $this->lang->line('umb_update');?></button>
    </div>
    <?php echo form_close(); ?>
    <style type="text/css">.trumbowyg-box, .trumbowyg-editor { min-height: 105px; }</style>
    <script type="text/javascript">var site_url = '<?php echo site_url().'admin/'; ?>';</script>
    <script type="text/javascript">
     $(document).ready(function(){
       
		// On page load: datatable		
		$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
		$('[data-plugin="select_hrm"]').select2({ width:'100%' });	 
		
		//$('#description2').trumbowyg();
		Ladda.bind('button[type=submit]');
		// Date
		$('.edate').bootstrapMaterialDatePicker({
			weekStart: 0,
			time: false,
			clearButton: false,
			format: 'YYYY-MM-DD'
		});
		/* Edit data */
		$("#edit_tugas").submit(function(e){
      e.preventDefault();
      var obj = $(this), action = obj.attr('name');
      $('.save').prop('disabled', true);
      $.ajax({
        type: "POST",
        url: e.target.action,
        data: obj.serialize()+"&is_ajax=1&edit_type=tugas&form="+action,
        cache: false,
        success: function (JSON) {
         if (JSON.error != '') {
          toastr.error(JSON.error);
          $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
          $('.save').prop('disabled', false);
          Ladda.stopAll();
        } else {
          var umb_table = $('#umb_table').dataTable({
            "bDestroy": true,
            "ajax": {
             url : "<?php echo site_url('admin/timesheet/list_project_tugas');?>/"+$('#tproject_id').val(),
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
<?php } else if(isset($_GET['jd']) && isset($_GET['variasi_id']) && $_GET['data']=='project_variation'){
	$assigned_ids = explode(',',$assigned_to);
  ?>
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
    <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_project_edit_variasi');?></h4>
  </div>
  <?php $attributes = array('name' => 'edit_variasi', 'id' => 'edit_variasi', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
  <?php $hidden = array('_method' => 'EDIT', '_token' => $variasi_id, 'ext_name' => $variasi_id);?>
  <?php echo form_open('admin/timesheet/edit_variasi/'.$variasi_id, $attributes, $hidden);?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-6">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <?php $kategoris_tugas = $this->Project_model->get_kategoris_tugas(); ?>
              <label for="nama_tugas"><?php echo $this->lang->line('dashboard_umb_title');?></label>
              <select class="form-control" name="nama_variasi" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('dashboard_umb_title');?>">
                <option value=""><?php echo $this->lang->line('umb_select_one');?></option>
                <?php foreach($kategoris_tugas->result() as $tugas_cat) {?>
                  <option value="<?php echo $tugas_cat->kategori_tugas_id;?>" <?php if($nama_variasi == $tugas_cat->kategori_tugas_id):?> selected="selected"<?php endif;?>> <?php echo $tugas_cat->nama_kategori;?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="no_variasii" class="control-label"><?php echo $this->lang->line('umb_project_no_variasii');?></label>
              <input class="form-control" placeholder="<?php echo $this->lang->line('umb_project_no_variasii');?>" name="no_variasii" type="text" value="<?php echo $no_variasii;?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <input type="hidden" name="project_id" id="tproject_id" value="<?php echo $project_id;?>" />
            <div class="form-group">
              <label for="start_date"><?php echo $this->lang->line('umb_start_date');?></label>
              <input class="form-control edate" placeholder="<?php echo $this->lang->line('umb_start_date');?>" readonly="true" name="start_date" type="text" value="<?php echo $start_date;?>">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="end_date"><?php echo $this->lang->line('umb_end_date');?></label>
              <input class="form-control edate" placeholder="<?php echo $this->lang->line('umb_end_date');?>" readonly="true" name="end_date" type="text" value="<?php echo $end_date;?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="status"><?php echo $this->lang->line('dashboard_umb_status');?></label>
              <select class="form-control" name="status" data-plugin="select_hrm" data-placeholder="Status">
                <option value="0" <?php if($status_variasi=='0'):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('umb_not_started');?></option>
                <option value="1" <?php if($status_variasi=='1'):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('umb_in_progress');?></option>
                <option value="2" <?php if($status_variasi=='2'):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('umb_completed');?></option>
                <option value="3" <?php if($status_variasi=='3'):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('umb_project_cancelled');?></option>
                <option value="4" <?php if($status_variasi=='4'):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('umb_project_hold');?></option>
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="jam_variasi" class="control-label"><?php echo $this->lang->line('umb_project_variation_hrs');?></label>
              <input class="form-control" placeholder="<?php echo $this->lang->line('umb_project_variation_hrs');?>" name="jam_variasi" type="text" value="<?php echo $jam_variasi;?>">
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="description"><?php echo $this->lang->line('umb_description');?></label>
          <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('umb_description');?>" name="description" cols="30" rows="5" id="description2"><?php echo $description;?></textarea>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-3">
        <div class="form-group">
          <label for="client_approval"><?php echo $this->lang->line('umb_client_approval');?></label>
          <select class="form-control" name="client_approval" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_client_approval');?>">
            <option value="0" <?php if($client_approval=='0'):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('umb_client_approval_unclaimed');?></option>
            <option value="1" <?php if($client_approval=='1'):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('umb_client_approval_claimed');?></option>
          </select>
        </div>
      </div>
      <div class="col-md-9">
        <div class="form-group">
          <label for="karyawans" class="control-label"><?php echo $this->lang->line('umb_assigned_to');?></label>
          <select multiple class="form-control" name="assigned_to[]" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('dashboard_single_karyawan');?>">
            <option value=""></option>
            <?php foreach($all_karyawans as $karyawan) {?>
              <option value="<?php echo $karyawan->user_id?>" <?php if(in_array($karyawan->user_id,$assigned_ids)):?> selected 
                <?php endif;?>> <?php echo $karyawan->first_name.' '.$karyawan->last_name;?></option>
              <?php } ?>
            </select>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('umb_close');?></button>
      <button type="submit" class="btn btn-primary"><?php echo $this->lang->line('umb_update');?></button>
    </div>
    <?php echo form_close(); ?>
    <style type="text/css">.trumbowyg-box, .trumbowyg-editor { min-height: 105px; }</style>
    <script type="text/javascript">var site_url = '<?php echo site_url().'admin/';?>';</script>
    <script type="text/javascript">
     $(document).ready(function(){
       
		// On page load: datatable		
		$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
		$('[data-plugin="select_hrm"]').select2({ width:'100%' });	 
		
		$('#description2').trumbowyg();
		// Date
		$('.edate').datepicker({
      changeMonth: true,
      changeYear: true,
      dateFormat:'yy-mm-dd',
      yearRange: '1900:' + (new Date().getFullYear() + 10)
    });

		/* Edit data */
		$("#edit_variasi").submit(function(e){
      e.preventDefault();
      var obj = $(this), action = obj.attr('name');
      $('.save').prop('disabled', true);
      $.ajax({
        type: "POST",
        url: e.target.action,
        data: obj.serialize()+"&is_ajax=1&edit_type=variation&form="+action,
        cache: false,
        success: function (JSON) {
         if (JSON.error != '') {
          toastr.error(JSON.error);
          $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
          $('.save').prop('disabled', false);
        } else {
          var umb_variation_table = $('#umb_variation_table').dataTable({
            "bDestroy": true,
            "ajax": {
             url : "<?php echo site_url('admin/timesheet/get_variasi_project');?>/"+$('#tproject_id').val(),
             type : 'GET'
           },
           "fnDrawCallback": function(settings){
            $('[data-toggle="tooltip"]').tooltip();          
          }
        });
          umb_variation_table.api().ajax.reload(function(){ 
           toastr.success(JSON.result);
         }, true);
          $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
          $('.edit-modal-data-variasi').modal('toggle');
          $('.save').prop('disabled', false);
        }
      }
    });
    });
	});	
</script>
<?php }
?>
