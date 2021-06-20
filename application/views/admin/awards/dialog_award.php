<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['award_id']) && $_GET['data']=='award'){
  ?>
  <?php $session = $this->session->userdata('username');?>
  <?php $user_info = $this->Umb_model->read_user_info($session['user_id']);?>

  <div class="modal-header"> 
    <?php echo form_button(array('aria-label' => 'Close', 'data-dismiss' => 'modal', 'type' => 'button', 'class' => 'close', 'content' => '<span aria-hidden="true">×</span>')); ?>
    <h6 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_edit_award');?></h6>
  </div>
  <?php $attributes = array('name' => 'edit_award', 'id' => 'edit_award', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
  <?php $hidden = array('_method' => 'EDIT', '_token' => $award_id, 'ext_name' => $type_award_id);?>
  <?php echo form_open('admin/awards/update/'.$award_id, $attributes, $hidden);?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-6">      
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="type_award"><?php echo $this->lang->line('umb_type_award');?></label>
              <select name="type_award_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_type_award');?>">
                <option value=""></option>
                <?php foreach($all_types_award as $type_award) {?>
                  <option value="<?php echo $type_award->type_award_id;?>" <?php if($type_award->type_award_id==$type_award_id):?> selected <?php endif; ?>><?php echo $type_award->type_award;?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="tanggal_award"><?php echo $this->lang->line('umb_e_details_tanggal');?></label>
              <input class="form-control d_tanggal_award" placeholder="<?php echo $this->lang->line('umb_tanggal_penghargaan');?>" readonly="true" name="tanggal_award" type="text" value="<?php echo $created_at;?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="gift"><?php echo $this->lang->line('umb_gift');?></label>
              <input class="form-control" placeholder="<?php echo $this->lang->line('umb_gift');?>" name="gift" type="text" value="<?php echo $gift_item;?>">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="cash"><?php echo $this->lang->line('umb_cash');?></label>
              <input class="form-control" placeholder="<?php echo $this->lang->line('umb_cash');?>" name="cash" type="text" value="<?php echo $cash_price;?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <fieldset class="form-group">
                <label for="logo"><?php echo $this->lang->line('umb_photo_award');?></label>
                <input type="file" class="form-control-file" id="picture_award" name="picture_award">
                <small><?php echo $this->lang->line('umb_perusahaan_file_type');?></small>
              </fieldset>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="month_year"><?php echo $this->lang->line('umb_bulan_tahun_penghargaan');?></label>
              <input class="form-control d_month_year" data-language='id' data-min-view="months" data-view="months" data-date-format="M yyyy" placeholder="<?php echo $this->lang->line('umb_bulan_tahun_penghargaan');?>" readonly="true" name="month_year" type="text" value="<?php echo $bulan_tahun_award;?>">
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
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class='form-group'>
              <?php if($photo_award!='' && $photo_award!='no file') {?>
                <img src="<?php echo base_url().'uploads/award/'.$photo_award;?>" width="70px" id="u_file"> 
                <a href="<?php echo site_url()?>admin/download?type=award&filename=<?php echo $photo_award;?>"><?php echo $this->lang->line('umb_download');?></a>
              <?php } else {?>
                <p>&nbsp;</p>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          <label for="informasi_award"><?php echo $this->lang->line('umb_info_award');?></label>
          <textarea class="form-control" placeholder="<?php echo $this->lang->line('umb_info_award');?>" name="informasi_award" cols="30" rows="3" id="informasi_award"><?php echo $informasi_award;?></textarea>
        </div>
      </div>
    </div>
    <?php $count_module_attributes = $this->Custom_fields_model->count_awards_module_attributes();?>
    <?php $module_attributes = $this->Custom_fields_model->awards_hrastral_module_attributes();?>
    <div class="row">
      <?php foreach($module_attributes as $mattribute):?>
        <?php $attribute_info = $this->Custom_fields_model->get_data_custom_karyawan($award_id,$mattribute->custom_field_id);?>
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
              <input class="form-control d_tanggal_award" placeholder="<?php echo $mattribute->attribute_label;?>" name="<?php echo $mattribute->attribute;?>" type="text" value="<?php echo $attr_val;?>">
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
<div class="modal-footer"> <?php echo form_button(array('data-dismiss' => 'modal', 'type' => 'button', 'class' => 'btn btn-secondary', 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('umb_close'))); ?> <?php echo form_button(array('name' => 'hrastral_form', 'type' => 'submit', 'class' => $this->Umb_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('umb_update'))); ?> </div>
<?php echo form_close(); ?> 
<style type="text/css">
  .hide-calendar .ui-datepicker-calendar { display:none !important; }
  .hide-calendar .ui-priority-secondary { display:none !important; }
  .ui-datepicker-div { top:500px !important; }
</style>
<script type="text/javascript">
 $(document).ready(function(){	
  jQuery("#ajx_perusahaan").change(function(){
    jQuery.get(base_url+"/get_karyawans/"+jQuery(this).val(), function(data, status){
      jQuery('#ajx_karyawan').html(data);
    });
  });
  Ladda.bind('button[type=submit]');
  $('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
  $('[data-plugin="select_hrm"]').select2({ width:'100%' });	 
  $('.d_tanggal_award').bootstrapMaterialDatePicker({
   weekStart: 0,
   time: false,
   clearButton: false,
   format: 'YYYY-MM-DD'
 });
  $('.d_month_year').datepicker({
   changeMonth: true,
   changeYear: true,
   showButtonPanel: true,
   dateFormat:'yy-mm',
   yearRange: '1900:' + (new Date().getFullYear() + 15),
   beforeShow: function(input) {
    $(input).datepicker("widget").addClass('hide-calendar');
  },
  onClose: function(dateText, inst) {
    var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
    var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
    $(this).datepicker('setDate', new Date(year, month, 1));
    $(this).datepicker('widget').removeClass('hide-calendar');
    $(this).datepicker('widget').hide();
  }
});		
  $("#edit_award").submit(function(e){
    var fd = new FormData(this);
    var obj = $(this), action = obj.attr('name');
    fd.append("is_ajax", 1);
    fd.append("edit_type", 'award');
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
          var umb_table = $('#umb_table').dataTable({
            "bDestroy": true,
            "ajax": {
              url : "<?php echo site_url("admin/awards/list_award") ?>",
              type : 'GET'
            },
            dom: 'lBfrtip',
            "buttons": ['csv', 'excel', 'pdf', 'print'], 
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
<?php } else if(isset($_GET['jd']) && isset($_GET['award_id']) && $_GET['data']=='view_award'){
  ?>
  <form class="m-b-1">
    <div class="modal-body">
      <p class="text-center text-big mb-4">
        <strong><?php echo $this->lang->line('umb_view_award');?></strong>
      </p>
      <table class="footable-details table table-striped table-hover toggle-circle">
        <tbody>
          <tr>
            <th><?php echo $this->lang->line('module_title_perusahaan');?></th>
            <td style="display: table-cell;">
              <?php foreach($get_all_perusahaans as $perusahaan) {?>
                <?php if($perusahaan_id==$perusahaan->perusahaan_id):?>
                  <?php echo $perusahaan->name;?>
                <?php endif;?>
              <?php } ?>
            </td>
          </tr>
          <tr>
            <th><?php echo $this->lang->line('dashboard_single_karyawan');?></th>
            <td style="display: table-cell;">
              <?php foreach($all_karyawans as $karyawan) {?>
                <?php if($karyawan_id==$karyawan->user_id):?>
                  <?php echo $karyawan->first_name.' '.$karyawan->last_name;?>
                <?php endif;?>
              <?php } ?>
            </td>
          </tr>
          <tr>
            <th><?php echo $this->lang->line('umb_type_award');?></th>
            <td style="display: table-cell;">
              <?php foreach($all_types_award as $type_award) {?>
                <?php if($type_award_id==$type_award->type_award_id):?>
                  <?php echo $type_award->type_award;?>
                <?php endif;?>
              <?php } ?>
            </td>
          </tr>
          <tr>
            <th><?php echo $this->lang->line('umb_e_details_tanggal');?></th>
            <td style="display: table-cell;"><?php echo $this->Umb_model->set_date_format($created_at);?></td>
          </tr>
          <tr>
            <th><?php echo $this->lang->line('umb_bulan_tahun_penghargaan');?></th>
            <td style="display: table-cell;"><?php echo $bulan_tahun_award;?></td>
          </tr>
          <tr>
            <th><?php echo $this->lang->line('umb_gift');?></th>
            <td style="display: table-cell;"><?php echo $gift_item;?></td>
          </tr>
          <tr>
            <th><?php echo $this->lang->line('umb_cash');?></th>
            <td style="display: table-cell;"><?php echo $this->Umb_model->currency_sign($cash_price);?></td>
          </tr>
          <tr>
            <th><?php echo $this->lang->line('umb_photo_award');?></th>
            <td style="display: table-cell;">
              <?php if($photo_award!='' && $photo_award!='no file') {?>
                <img src="<?php echo base_url().'uploads/award/'.$photo_award;?>" width="70px" id="u_file">&nbsp; 
                <a href="<?php echo site_url()?>admin/download?type=award&filename=<?php echo $photo_award;?>"><?php echo $this->lang->line('umb_download');?></a>
              <?php } ?>
            </td>
          </tr>
          <tr>
            <th><?php echo $this->lang->line('umb_info_award');?></th>
            <td style="display: table-cell;"><?php echo html_entity_decode($informasi_award);?></td>
          </tr>
          <tr>
            <th><?php echo $this->lang->line('umb_description');?></th>
            <td style="display: table-cell;"><?php echo html_entity_decode($description);?></td>
          </tr>
          <?php $count_module_attributes = $this->Custom_fields_model->count_awards_module_attributes();?>
          <?php $module_attributes = $this->Custom_fields_model->awards_hrastral_module_attributes();?>
          <?php foreach($module_attributes as $mattribute):?>
            <?php $attribute_info = $this->Custom_fields_model->get_data_custom_karyawan($award_id,$mattribute->custom_field_id);?>
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
              <td style="display: table-cell;">
                <?php if($attr_val!='' && $attr_val!='no file') {?>
                  <img src="<?php echo base_url().'uploads/custom_files/'.$attr_val;?>" width="70px" id="u_file">&nbsp; 
                  <a href="<?php echo site_url('admin/download');?>?type=custom_files&filename=<?php echo $attr_val;?>"><?php echo $this->lang->line('umb_download');?></a>
                <?php } ?>
              </td>
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
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('umb_close');?></button>
  </div>
  <?php echo form_close(); ?>
<?php }
?>
