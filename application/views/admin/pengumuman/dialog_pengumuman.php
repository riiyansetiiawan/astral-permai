<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['pengumuman_id']) && $_GET['data']=='pengumuman'){
  ?>
  <?php $session = $this->session->userdata('username');?>
  <?php $user_info = $this->Umb_model->read_user_info($session['user_id']);?>
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
    <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_edit_pengumuman');?></h4>
  </div>
  <?php $attributes = array('name' => 'edit_pengumuman', 'id' => 'edit_pengumuman', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
  <?php $hidden = array('_method' => 'EDIT', '_token' => $pengumuman_id, 'ext_name' => $title);?>
  <?php echo form_open_multipart('admin/pengumuman/update/'.$pengumuman_id, $attributes, $hidden);?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="title"><?php echo $this->lang->line('umb_title');?></label>
          <input class="form-control" placeholder="<?php echo $this->lang->line('umb_title');?>" name="title" type="text" value="<?php echo $title;?>">
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="start_date"><?php echo $this->lang->line('umb_start_date');?></label>
              <input class="form-control d_date" name="start_date_modal" readonly="true" type="text" value="<?php echo $start_date;?>">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="end_date"><?php echo $this->lang->line('umb_end_date');?></label>
              <input class="form-control d_date" name="end_date_modal" readonly="true" type="text" value="<?php echo $end_date;?>">
            </div>
          </div>
        </div>
        
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="description"><?php echo $this->lang->line('umb_description');?></label>
          <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('umb_description');?>" name="description" cols="30" rows="6" id="description2"><?php echo $description;?></textarea>
        </div>
      </div>
    </div>
    <div class="form-group">
      <label for="summary"><?php echo $this->lang->line('umb_summary');?></label>
      <textarea class="form-control" placeholder="<?php echo $this->lang->line('umb_summary');?>" name="summary" cols="30" rows="3" id="summary"><?php echo $summary;?></textarea>
    </div>
    <?php $count_module_attributes = $this->Custom_fields_model->count_pengumumans_module_attributes();?>
    <?php $module_attributes = $this->Custom_fields_model->pengumumans_hrastral_module_attributes();?>
    <div class="row">
      <?php foreach($module_attributes as $mattribute):?>
        <?php $attribute_info = $this->Custom_fields_model->get_data_custom_karyawan($pengumuman_id,$mattribute->custom_field_id);?>
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
   
		//$('#description2').trumbowyg();
		
		$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
		$('[data-plugin="select_hrm"]').select2({ width:'100%' });
		
		jQuery("#ajx_perusahaan").change(function(){
			/*jQuery.get(base_url+"/get_departments/"+jQuery(this).val(), function(data, status){
				jQuery('#department_ajx').html(data);
			});*/
			jQuery.get(escapeHtmlSecure(base_url+"/get_perusahaan_dialog_elocations/"+jQuery(this).val()), function(data, status){
				jQuery('#ajx_location').html(data);
			});
		});	 
		jQuery("#aj_location_idx").change(function(){
			jQuery.get(base_url+"/get_dialog_location_departments/"+jQuery(this).val(), function(data, status){
				jQuery('#department_ajx').html(data);
			});
		});	 
   Ladda.bind('button[type=submit]');
   
   $('.d_date').bootstrapMaterialDatePicker({
     weekStart: 0,
     time: false,
     clearButton: false,
     format: 'YYYY-MM-DD'
   });

   /* Edit data */
   $("#edit_pengumuman").submit(function(e){
    var fd = new FormData(this);
    var obj = $(this), action = obj.attr('name');
    fd.append("is_ajax", 1);
    fd.append("edit_type", 'pengumuman');
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
							url : "<?php echo site_url("admin/pengumuman/list_pengumuman") ?>",
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
<?php } else if(isset($_GET['jd']) && isset($_GET['pengumuman_id']) && $_GET['data']=='view_pengumuman'){
  ?>
  <form class="m-b-1">
    <div class="modal-body">
      <p class="text-center text-big mb-4"><strong><?php echo $this->lang->line('umb_view_pengumuman');?></strong></p>
      <div class="table-responsive" data-pattern="priority-columns">
        <table class="footable-details table table-striped table-hover toggle-circle">
          <tbody>
            <tr>
              <th><?php echo $this->lang->line('umb_title');?></th>
              <td style="display: table-cell;"><?php echo $title;?></td>
            </tr>
            <tr>
              <th><?php echo $this->lang->line('umb_start_date');?></th>
              <td style="display: table-cell;"><?php echo $start_date;?></td>
            </tr>
            <tr>
              <th><?php echo $this->lang->line('umb_end_date');?></th>
              <td style="display: table-cell;"><?php echo $end_date;?></td>
            </tr>
            <tr>
              <th><?php echo $this->lang->line('module_title_perusahaan');?></th>
              <td style="display: table-cell;"><?php foreach($get_all_perusahaans as $perusahaan) {?>
                <?php if($perusahaan->perusahaan_id==$perusahaan_id):?>
                  <?php echo $perusahaan->name?>
                <?php endif;?>
                <?php } ?></td>
              </tr>
              <tr>
                <th><?php echo $this->lang->line('umb_department');?></th>
                <td style="display: table-cell;"><?php foreach($all_departments as $department) {?>
                  <?php if($department->department_id==$department_id):?>
                    <?php echo $department->nama_department?>
                  <?php endif;?>
                  <?php } ?></td>
                </tr>
                <tr>
                  <th><?php echo $this->lang->line('umb_summary');?></th>
                  <td style="display: table-cell;"><?php echo html_entity_decode($summary);?></td>
                </tr>
                <tr>
                  <th><?php echo $this->lang->line('umb_description');?></th>
                  <td style="display: table-cell;"><?php echo html_entity_decode($description);?></td>
                </tr>
                <?php $count_module_attributes = $this->Custom_fields_model->count_pengumumans_module_attributes();?>
                <?php $module_attributes = $this->Custom_fields_model->pengumumans_hrastral_module_attributes();?>
                <?php foreach($module_attributes as $mattribute):?>
                  <?php $attribute_info = $this->Custom_fields_model->get_data_custom_karyawan($pengumuman_id,$mattribute->custom_field_id);?>
                  <?php
                  if(!is_null($attribute_info)){
                    $attr_val = $attribute_info->attribute_value;
                  } else {
                    $attr_val = '';
                  }
                  ?>
                  <?php if($mattribute->attribute_type == 'date'){?>
                   <tr>
                    <th><?php echo $mattribute->attribute_label;?></th>
                    <td style="display: table-cell;"><?php echo $attr_val;?></td>
                  </tr>
                <?php } else if($mattribute->attribute_type == 'select'){?>
                  <?php $iselc_val = $this->Custom_fields_model->get_attribute_selection_values($mattribute->custom_field_id);?>
                  <tr>
                    <th><?php echo $mattribute->attribute_label;?></th>
                    <td style="display: table-cell;"><?php foreach($iselc_val as $selc_val) {?> <?php if($attr_val==$selc_val->attributes_select_value_id):?> <?php echo $selc_val->select_label?> <?php endif;?><?php } ?></td>
                  </tr>
                <?php } else if($mattribute->attribute_type == 'multiselect'){?>
                  <?php $multiselect_values = explode(',',$attr_val);?>
                  <?php $imulti_selc_val = $this->Custom_fields_model->get_attribute_selection_values($mattribute->custom_field_id);?>
                  <tr>
                    <th><?php echo $mattribute->attribute_label;?></th>
                    <td style="display: table-cell;"><?php foreach($imulti_selc_val as $multi_selc_val) {?> <?php if(in_array($multi_selc_val->attributes_select_value_id,$multiselect_values)):?><br /> <?php echo $multi_selc_val->select_label?> <?php endif;?><?php } ?></td>
                  </tr>
                <?php } else if($mattribute->attribute_type == 'textarea'){?>
                  <tr>
                    <th><?php echo $mattribute->attribute_label;?></th>
                    <td style="display: table-cell;"><?php echo $attr_val;?></td>
                  </tr>
                <?php } else if($mattribute->attribute_type == 'fileupload'){?>
                  <tr>
                    <th><?php echo $mattribute->attribute_label;?></th>
                    <td style="display: table-cell;"><?php if($attr_val!='' && $attr_val!='no file') {?>
                      <img src="<?php echo base_url().'uploads/custom_files/'.$attr_val;?>" width="70px" id="u_file">&nbsp; <a href="<?php echo site_url('admin/download');?>?type=custom_files&filename=<?php echo $attr_val;?>"><?php echo $this->lang->line('umb_download');?></a>
                      <?php } ?></td>
                    </tr>
                  <?php } else { ?>
                    <tr>
                      <th><?php echo $mattribute->attribute_label;?></th>
                      <td style="display: table-cell;"><?php echo $attr_val;?></td>
                    </tr>
                  <?php } ?>
                  
                <?php endforeach;?>
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
