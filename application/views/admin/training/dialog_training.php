<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['training_id']) && $_GET['data']=='view_training'){
  ?>

  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  </div>
  <form class="m-b-1">
    <div class="modal-body">
      <h4 class="text-center text-big mb-4"><strong><?php echo $this->lang->line('umb_view');?> <?php echo $this->lang->line('left_training');?></strong></h4>
      <table class="footable-details table table-striped table-hover toggle-circle">
        <tbody>
          <tr>
            <th><?php echo $this->lang->line('module_title_perusahaan');?></th>
            <td style="display: table-cell;"><?php foreach($all_perusahaans as $perusahaan) {?>
              <?php if($perusahaan_id==$perusahaan->perusahaan_id):?>
                <?php echo $perusahaan->name;?>
              <?php endif;?>
              <?php } ?></td>
            </tr>
            <tr>
              <th><?php echo $this->lang->line('left_type_training');?></th>
              <td style="display: table-cell;"><?php foreach($all_types_training as $type_training) {?>
                <?php if($type_training_id==$type_training->type_training_id):?>
                  <?php echo $type_training->type?>
                <?php endif;?>
                <?php } ?></td>
              </tr>
              <?php
              if($trainer_option == 2){
			// get trainer
               $trainer = $this->Trainers_model->read_informasi_trainer($trainer_id);
			// trainer full name
               if(!is_null($trainer)){
                $nama_trainer = $trainer[0]->first_name.' '.$trainer[0]->last_name;
              } else {
                $nama_trainer = '--';	
              }
            } elseif($trainer_option == 1){
			// get user > karyawan_
             $trainer = $this->Umb_model->read_user_info($trainer_id);
			// karyawan full name
             if(!is_null($trainer)){
              $nama_trainer = $trainer[0]->first_name.' '.$trainer[0]->last_name;
            } else {
              $nama_trainer = '--';	
            }
          } else {
           $nama_trainer = '--';
         }
         ?>
         <tr>
          <th><?php echo $this->lang->line('umb_trainer');?></th>
          <td style="display: table-cell;"><?php echo $nama_trainer; ?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('umb_biaya_training');?></th>
          <td style="display: table-cell;"><?php echo $biaya_training;?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('umb_start_date');?></th>
          <td style="display: table-cell;"><?php echo $this->Umb_model->set_date_format($start_date);?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('umb_end_date');?></th>
          <td style="display: table-cell;"><?php echo $this->Umb_model->set_date_format($finish_date);?></td>
        </tr>
        <?php $assigned_ids = explode(',',$karyawan_id); ?>
        <tr>
          <th><?php echo $this->lang->line('umb_karyawan');?></th>
          <td style="display: table-cell;"><ol>
            <?php foreach($all_karyawans as $karyawan) {?>
              <?php if(in_array($karyawan->user_id,$assigned_ids)):?>
                <li> <?php echo $karyawan->first_name.' '.$karyawan->last_name;?></li>
              <?php endif; ?>
            <?php } ?>
          </ol></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('umb_description');?></th>
          <td style="display: table-cell;"><?php echo html_entity_decode($description);?></td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('umb_close');?></button>
  </div>
  <?php echo form_close(); ?>
<?php } else if(isset($_GET['jd']) && isset($_GET['training_id']) && $_GET['data']=='training'){
	$assigned_ids = explode(',',$karyawan_id);
  ?>
  <?php $session = $this->session->userdata('username');?>
  <?php $user_info = $this->Umb_model->read_user_info($session['user_id']);?>
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
    <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_edit_training');?></h4>
  </div>
  <?php $attributes = array('name' => 'edit_training', 'id' => 'edit_training', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
  <?php $hidden = array('_method' => 'EDIT', '_token' => $training_id, 'ext_name' => $training_id);?>
  <?php echo form_open('admin/training/update/'.$training_id, $attributes, $hidden);?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-6">
        <div class="row">
          <div class="col-md-12">
            <?php if($user_info[0]->user_role_id==1){ ?>
              <div class="form-group">
                <label for="nama_perusahaan"><?php echo $this->lang->line('module_title_perusahaan');?></label>
                <select class="form-control" name="perusahaan" id="ajx_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_title_perusahaan');?>">
                  <option value=""><?php echo $this->lang->line('umb_select_one');?></option>
                  <?php foreach($all_perusahaans as $perusahaan) {?>
                    <option value="<?php echo $perusahaan->perusahaan_id;?>" <?php if($perusahaan_id==$perusahaan->perusahaan_id):?> selected="selected" <?php endif;?>> <?php echo $perusahaan->name;?></option>
                  <?php } ?>
                </select>
              </div>
            <?php } else {?>
              <?php $eperusahaan_id = $user_info[0]->perusahaan_id;?>
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
            <?php } ?>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="type_training"><?php echo $this->lang->line('left_type_training');?></label>
              <select class="form-control" name="type_training" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_type_training');?>">
                <option value=""></option>
                <?php foreach($all_types_training as $type_training) {?>
                  <option value="<?php echo $type_training->type_training_id?>" <?php if($type_training_id==$type_training->type_training_id):?> selected="selected" <?php endif;?>><?php echo $type_training->type?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
        <?php $result = $this->Department_model->ajax_info_perusahaan_karyawan($perusahaan_id);?>
        <div class="row">
          <div class="col-md-6">
            <?php if($trainer_option==2){?>
              <div class="form-group">
                <label for="trainer"><?php echo $this->lang->line('umb_trainer');?></label>
                <select class="form-control" name="trainer" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_trainer');?>">
                  <option value=""></option>
                  <?php foreach($all_trainers as $trainer) {?>
                    <option value="<?php echo $trainer->trainer_id?>" <?php if($trainer_id==$trainer->trainer_id):?> selected="selected" <?php endif;?>><?php echo $trainer->first_name.' '.$trainer->last_name;?></option>
                  <?php } ?>
                </select>
              </div>
            <?php } else {?>
              <div class="form-group" id="xtrainers_data">
                <label for="trainer"><?php echo $this->lang->line('umb_trainer');?></label>
                <select class="form-control" name="trainer" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_trainer');?>">
                  <option value=""></option>
                  <?php foreach($result as $karyawan) {?>
                    <option value="<?php echo $karyawan->user_id;?>" <?php if($karyawan->user_id==$trainer_id):?> selected <?php endif; ?>><?php echo $karyawan->first_name.' '.$karyawan->last_name;?></option>
                  <?php } ?>
                </select>
              </div>
            <?php } ?>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="biaya_training"><?php echo $this->lang->line('umb_biaya_training');?></label>
              <input class="form-control" placeholder="<?php echo $this->lang->line('umb_biaya_training');?>" name="biaya_training" type="text" value="<?php echo $biaya_training;?>">
            </div>
          </div>
        </div>
        <div class="row">
          
          <div class="col-md-12">
            <div class="form-group" id="ajx_karyawan">
              <label for="karyawan" class="control-label"><?php echo $this->lang->line('umb_karyawan');?></label>
              <select multiple class="form-control" name="karyawan_id[]" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_karyawan');?>">
                <option value=""></option>
                <?php foreach($result as $karyawan) {?>
                  <option value="<?php echo $karyawan->user_id;?>" <?php if(in_array($karyawan->user_id,$assigned_ids)):?> selected <?php endif; ?>><?php echo $karyawan->first_name.' '.$karyawan->last_name;?></option>
                <?php } ?>
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
              <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('umb_description');?>" name="description" rows="5" id="description2"><?php echo $description;?></textarea>
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
              <input class="form-control d_date" placeholder="<?php echo $this->lang->line('umb_end_date');?>" readonly="true" name="end_date" type="text" value="<?php echo $finish_date;?>">
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php $count_module_attributes = $this->Custom_fields_model->count_training_module_attributes();?>
    <?php $module_attributes = $this->Custom_fields_model->training_hrastral_module_attributes();?>
    <div class="row">
      <?php foreach($module_attributes as $mattribute):?>
        <?php $attribute_info = $this->Custom_fields_model->get_data_custom_karyawan($training_id,$mattribute->custom_field_id);?>
        <?php
        if(!is_null($attribute_info)){
          $attr_val = $attribute_info->attribute_value;
        } else {
          $attr_val = '';
        }
        ?>
        <?php if($mattribute->attribute_type == 'date'){?>
          <div class="col-md-4">
            <div class="form-group">
              <label for="<?php echo $mattribute->attribute;?>"><?php echo $mattribute->attribute_label;?></label>
              <input class="form-control d_date" placeholder="<?php echo $mattribute->attribute_label;?>" name="<?php echo $mattribute->attribute;?>" type="text" value="<?php echo $attr_val;?>">
            </div>
          </div>
        <?php } else if($mattribute->attribute_type == 'select'){?>
          <div class="col-md-4">
            <?php $iselc_val = $this->Custom_fields_model->get_attribute_selection_values($mattribute->custom_field_id);?>
            <div class="form-group">
              <label for="<?php echo $mattribute->attribute;?>"><?php echo $mattribute->attribute_label;?></label>
              <select class="form-control" name="<?php echo $mattribute->attribute;?>" data-plugin="select_hrm" data-placeholder="<?php echo $mattribute->attribute_label;?>">
                <?php foreach($iselc_val as $selc_val) {?>
                  <option value="<?php echo $selc_val->attributes_select_value_id?>" <?php if($attr_val==$selc_val->attributes_select_value_id):?> selected="selected"<?php endif;?>><?php echo $selc_val->select_label?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        <?php } else if($mattribute->attribute_type == 'multiselect'){?>
          <?php $multiselect_values = explode(',',$attr_val);?>
          <div class="col-md-4">
            <?php $imulti_selc_val = $this->Custom_fields_model->get_attribute_selection_values($mattribute->custom_field_id);?>
            <div class="form-group">
              <label for="<?php echo $mattribute->attribute;?>"><?php echo $mattribute->attribute_label;?></label>
              <select multiple="multiple" class="form-control" name="<?php echo $mattribute->attribute;?>[]" data-plugin="select_hrm" data-placeholder="<?php echo $mattribute->attribute_label;?>">
                <?php foreach($imulti_selc_val as $multi_selc_val) {?>
                  <option value="<?php echo $multi_selc_val->attributes_select_value_id?>" <?php if(in_array($multi_selc_val->attributes_select_value_id,$multiselect_values)):?> selected <?php endif;?>><?php echo $multi_selc_val->select_label?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        <?php } else if($mattribute->attribute_type == 'textarea'){?>
          <div class="col-md-8">
            <div class="form-group">
              <label for="<?php echo $mattribute->attribute;?>"><?php echo $mattribute->attribute_label;?></label>
              <input class="form-control" placeholder="<?php echo $mattribute->attribute_label;?>" name="<?php echo $mattribute->attribute;?>" type="text" value="<?php echo $attr_val;?>">
            </div>
          </div>
        <?php } else if($mattribute->attribute_type == 'fileupload'){?>
          <div class="col-md-4">
            <div class="form-group">
              <label for="<?php echo $mattribute->attribute;?>"><?php echo $mattribute->attribute_label;?>
              <?php if($attr_val!=''):?>
                <a href="<?php echo site_url('admin/download');?>?type=custom_files&filename=<?php echo $attr_val;?>"><?php echo $this->lang->line('umb_download');?></a>
              <?php endif;?>
            </label>
            <input class="form-control-file" name="<?php echo $mattribute->attribute;?>" type="file">
          </div>
        </div>
      <?php } else { ?>
        <div class="col-md-4">
          <div class="form-group">
            <label for="<?php echo $mattribute->attribute;?>"><?php echo $mattribute->attribute_label;?></label>
            <input class="form-control" placeholder="<?php echo $mattribute->attribute_label;?>" name="<?php echo $mattribute->attribute;?>" type="text" value="<?php echo $attr_val;?>">
          </div>
        </div>
      <?php }	?>
    <?php endforeach;?>
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
   jQuery("#ajx_perusahaan").change(function(){
    jQuery.get(base_url+"/get_karyawans/"+jQuery(this).val(), function(data, status){
     jQuery('#ajx_karyawan').html(data);
   });
    jQuery.get(base_url+"/get_internal_karyawan/"+jQuery(this).val(), function(data, status){
     jQuery('#xtrainers_data').html(data);
   });
  });
	//$('#description2').trumbowyg();
	$('.d_date').bootstrapMaterialDatePicker({
		weekStart: 0,
		time: false,
		clearButton: false,
		format: 'YYYY-MM-DD'
	});
	
	/* Edit data */
	$("#edit_training").submit(function(e){
		var fd = new FormData(this);
		var obj = $(this), action = obj.attr('name');
		fd.append("is_ajax", 1);
		fd.append("edit_type", 'training');
		fd.append("form", action);
		e.preventDefault();
		$('.icon-spinner3').show();
		$('.save').prop('disabled', true);
		$.ajax({
			url: e.target.action,
			type: "POST",
			data:  fd,
			contentType: false,
			cache: false,
			processData:false,
			success: function(JSON)
			{
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
          $('.save').prop('disabled', false);
          $('.icon-spinner3').hide();
          Ladda.stopAll();
        } else {
					// On page load: datatable
					var umb_table = $('#umb_table').dataTable({
						"bDestroy": true,
						"ajax": {
							url : "<?php echo site_url("admin/training/list_training") ?>",
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
					$('.icon-spinner3').hide();
					$('.edit-modal-data').modal('toggle');
					$('.save').prop('disabled', false);
					Ladda.stopAll();
				}
			},
			error: function() 
			{
				toastr.error(JSON.error);
				$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
				$('.icon-spinner3').hide();
				$('.save').prop('disabled', false);
				Ladda.stopAll();
			} 	        
    });
	});
});	
</script>
<?php }
?>
