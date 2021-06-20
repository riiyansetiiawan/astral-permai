<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['perusahaan_id']) && $_GET['data']=='perusahaan'){
  ?>

  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
    <h4 class="modal-title" id="edit-modal-data"><i class="icon-pencil7"></i> <?php echo $this->lang->line('umb_edit_perusahaan');?></h4>
  </div>
  <?php $attributes = array('name' => 'edit_perusahaan', 'id' => 'edit_perusahaan', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
  <?php $hidden = array('_method' => 'EDIT', '_token' => $_GET['perusahaan_id'], 'ext_name' => $name);?>
  <?php echo form_open_multipart('admin/perusahaan/update/'.$perusahaan_id, $attributes, $hidden);?>
  <div class="modal-body">
    <div class="row">
      <div class="col-sm-6">
        <div class="form-group">
          <label for="nama_perusahaan"><?php echo $this->lang->line('umb_nama_perusahaan');?></label>
          <input class="form-control" placeholder="<?php echo $this->lang->line('umb_nama_perusahaan');?>" name="name" type="text" value="<?php echo $name;?>">
        </div>
        <div class="form-group">
          <div class="row">
            <div class="col-md-6">
              <label for="email"><?php echo $this->lang->line('umb_type_perusahaan');?></label>
              <select class="form-control" name="type_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_type_perusahaan');?>">
                <option value=""><?php echo $this->lang->line('umb_select_one');?></option>
                <?php foreach($get_types_perusahaan as $ctype) {?>
                  <option value="<?php echo $ctype->type_id;?>" <?php if($type_id==$ctype->type_id){?> selected="selected" <?php } ?>> <?php echo $ctype->name;?></option>
                <?php } ?>
              </select>
            </div>
            <div class="col-md-6">
              <label for="nama_trading"><?php echo $this->lang->line('umb_perusahaan_trading');?></label>
              <input class="form-control" placeholder="<?php echo $this->lang->line('umb_perusahaan_trading');?>" name="nama_trading" type="text" value="<?php echo $nama_trading;?>">
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">
            <div class="col-md-6">
              <label for="registration_no"><?php echo $this->lang->line('umb_perusahaan_registration');?></label>
              <input class="form-control" placeholder="<?php echo $this->lang->line('umb_perusahaan_registration');?>" name="registration_no" type="text" value="<?php echo $registration_no;?>">
            </div>
            <div class="col-md-6">
              <label for="nomor_kontak"><?php echo $this->lang->line('umb_nomor_kontak');?></label>
              <input class="form-control" placeholder="<?php echo $this->lang->line('umb_nomor_kontak');?>" name="nomor_kontak" type="text" value="<?php echo $nomor_kontak;?>">
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">
            <div class="col-md-6">
              <label for="email"><?php echo $this->lang->line('umb_email');?></label>
              <input class="form-control" placeholder="<?php echo $this->lang->line('umb_email');?>" name="email" type="email" value="<?php echo $email;?>">
            </div>
            <div class="col-md-6">
              <label for="website"><?php echo $this->lang->line('umb_website');?></label>
              <input class="form-control" placeholder="<?php echo $this->lang->line('umb_website_url');?>" name="website" value="<?php echo $website_url;?>" type="text">
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="form-group">
          <label for="umb_pjkprmth"><?php echo $this->lang->line('umb_pjkprmth');?></label>
          <input class="form-control" placeholder="<?php echo $this->lang->line('umb_pjkprmth');?>" name="umb_pjkprmth" value="<?php echo $pajak_pemerintah;?>" type="text">
        </div>
        <div class="form-group">
          <label for="alamat"><?php echo $this->lang->line('umb_alamat');?></label>
          <input class="form-control" placeholder="<?php echo $this->lang->line('umb_alamat_1');?>" name="alamat_1" type="text" value="<?php echo $alamat_1;?>">
          <br>
          <input class="form-control" placeholder="<?php echo $this->lang->line('umb_alamat_2');?>" name="alamat_2" type="text" value="<?php echo $alamat_2;?>">
          <br>
          <div class="row">
            <div class="col-xs-4">
              <input class="form-control" placeholder="<?php echo $this->lang->line('umb_kota');?>" name="kota" type="text" value="<?php echo $kota;?>">
            </div>
            <div class="col-xs-4">
              <input class="form-control" placeholder="<?php echo $this->lang->line('umb_provinsi');?>" name="provinsi" type="text" value="<?php echo $provinsi;?>">
            </div>
            <div class="col-xs-4">
              <input class="form-control" placeholder="<?php echo $this->lang->line('umb_kode_pos');?>" name="kode_pos" type="text" value="<?php echo $kode_pos;?>">
            </div>
          </div>
          <br>
          <select class="form-control" name="negara" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_negara');?>">
            <option value=""><?php echo $this->lang->line('umb_select_one');?></option>
            <?php foreach($all_negaraa as $negara) {?>
              <option value="<?php echo $negara->negara_id;?>" <?php if($negaraid==$negara->negara_id):?> selected="selected"<?php endif;?>> <?php echo $negara->nama_negara;?></option>
            <?php } ?>
          </select>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        <label for="email"><?php echo $this->lang->line('dashboard_username');?></label>
        <input class="form-control" placeholder="<?php echo $this->lang->line('dashboard_username');?>" name="username" type="text" value="<?php echo $username;?>">
      </div>
      <div class="col-md-5">
        <fieldset class="form-group">
          <label for="logo"><?php echo $this->lang->line('umb_logo_perusahaan');?></label>
          <small><?php echo $this->lang->line('umb_perusahaan_file_type');?></small> 
          <input type="file" class="form-control-file" id="logo" name="logo">
        </fieldset>
        
      </div>
      <div class="col-md-3">
        <?php if($logo!='' || $logo!='no-file'){?>
         <span class="avatar box-48 mr-0-5"> <img class="d-block ui-w-100 rounded-circle" width="50" src="<?php echo base_url();?>uploads/perusahaan/<?php echo $logo;?>" alt=""> </span>
       <?php } ?>    
     </div>
   </div>
   <div class="row">
    <div class="col-md-4">
      <div class="form-group">
        <label for="email"><?php echo $this->lang->line('umb_invoice_currency');?></label>
        <select class="form-control" name="default_currency" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_invoice_currency');?>">
          <option value=""><?php echo $this->lang->line('umb_select_one');?></option>
          <?php foreach($this->Umb_model->get_currencies() as $currency){?>
            <?php $_currency = $currency->code.' - '.$currency->symbol;?>
            <option value="<?php echo $_currency;?>" <?php if($idefault_currency==$_currency):?> selected <?php endif;?>> <?php echo $_currency;?></option>
          <?php } ?>
        </select>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <label for="phone"><?php echo $this->lang->line('umb_setting_timezone');?></label>
        <select class="form-control" name="default_timezone" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_setting_timezone');?>">
          <option value=""><?php echo $this->lang->line('umb_select_one');?></option>
          <?php foreach($this->Umb_model->all_timezones() as $tval=>$labels):?>
            <option value="<?php echo $tval;?>" <?php if($idefault_timezone==$tval):?> selected <?php endif;?>><?php echo $labels;?></option>
          <?php endforeach;?>
        </select>
      </div>
    </div>
  </div>
  <?php $count_module_attributes = $this->Custom_fields_model->count_perusahaan_module_attributes();?>
  <?php $module_attributes = $this->Custom_fields_model->perusahaan_hrastral_module_attributes();?>
  <div class="row">
    <?php foreach($module_attributes as $mattribute):?>
      <?php $attribute_info = $this->Custom_fields_model->get_data_custom_karyawan($perusahaan_id,$mattribute->custom_field_id);?>
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
  <button type="submit" class="btn btn-primary save"><?php echo $this->lang->line('umb_update');?></button>
</div>
<?php echo form_close(); ?>
<script type="text/javascript">
 $(document).ready(function(){
   
  $('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
  $('[data-plugin="select_hrm"]').select2({ width:'100%' });	
  $('.d_date').bootstrapMaterialDatePicker({
   weekStart: 0,
   time: false,
   clearButton: false,
   format: 'YYYY-MM-DD'
 }); 
  
  Ladda.bind('button[type=submit]');
  /* Edit data */
  $("#edit_perusahaan").submit(function(e){
   var fd = new FormData(this);
   var obj = $(this), action = obj.attr('name');
   fd.append("is_ajax", 2);
   fd.append("edit_type", 'perusahaan');
   fd.append("form", action);
   e.preventDefault();
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
      Ladda.stopAll();
    } else {
						// On page load: datatable
						var umb_table = $('#umb_table').dataTable({
							"bDestroy": true,
							"ajax": {
								url : "<?php echo site_url("admin/perusahaans/list_perusahaan") ?>",
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
				},
				error: function() 
				{
					toastr.error(JSON.error);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
					Ladda.stopAll();
				} 	        
     });
 });
});	
</script>
<?php } else if(isset($_GET['jd']) && $_GET['data']=='view_perusahaan' && isset($_GET['perusahaan_id']) ){
  ?>

  <form class="m-b-1">
    <div class="modal-body">
      <p class="text-center text-big mb-4"><strong><?php echo $this->lang->line('umb_view_perusahaan');?></strong></p>
      <div class="table-responsive" data-pattern="priority-columns">
        <table class="footable-details table table-striped table-hover toggle-circle">
          <tbody>
            <tr>
              <th><?php echo $this->lang->line('umb_nama_perusahaan');?></th>
              <td style="display: table-cell;"><?php echo $name;?></td>
            </tr>
            <tr>
              <th><?php echo $this->lang->line('umb_type_perusahaan');?></th>
              <td style="display: table-cell;"><?php foreach($get_types_perusahaan as $ctype) {?>
                <?php if($type_id==$ctype->type_id){?>
                  <?php echo $ctype->name;?>
                  <?php } } ?></td>
                </tr>
                <tr>
                  <th><?php echo $this->lang->line('umb_perusahaan_trading');?></th>
                  <td style="display: table-cell;"><?php echo $nama_trading;?></td>
                </tr>
                <tr>
                  <th><?php echo $this->lang->line('umb_perusahaan_registration');?></th>
                  <td style="display: table-cell;"><?php echo $registration_no;?></span></td>
                </tr>
                <tr>
                  <th><?php echo $this->lang->line('dashboard_username');?></th>
                  <td style="display: table-cell;"><?php echo $username;?></span></td>
                </tr>
                <tr>
                  <th><?php echo $this->lang->line('umb_nomor_kontak');?></th>
                  <td style="display: table-cell;"><?php echo $nomor_kontak;?></span></td>
                </tr>
                <tr>
                  <th><?php echo $this->lang->line('umb_email');?></th>
                  <td style="display: table-cell;"><?php echo $email;?></span></td>
                </tr>
                <tr>
                  <th><?php echo $this->lang->line('umb_website');?></th>
                  <td style="display: table-cell;"><?php echo $website_url;?></span></td>
                </tr>
                <tr>
                  <th><?php echo $this->lang->line('umb_pjkprmth');?></th>
                  <td style="display: table-cell;"><?php echo $pajak_pemerintah;?></span></td>
                </tr>
                <tr>
                  <th><?php echo $this->lang->line('umb_invoice_currency');?></th>
                  <td style="display: table-cell;"><?php echo $idefault_currency;?></span></td>
                </tr>
                <tr>
                  <th><?php echo $this->lang->line('umb_setting_timezone');?></th>
                  <td style="display: table-cell;"><?php echo $idefault_timezone;?></span></td>
                </tr>
                <tr>
                  <th><?php echo $this->lang->line('umb_alamat');?></th>
                  <td style="display: table-cell;"><?php echo $alamat_1;?></span></td>
                </tr>
                <?php if($alamat_2!='') { ?>
                  <tr>
                    <th>&nbsp;</th>
                    <td style="display: table-cell;"><?php echo $alamat_2;?></span></td>
                  </tr>
                <?php } ?>
                <tr>
                  <th><?php echo $this->lang->line('umb_kota');?></th>
                  <td style="display: table-cell;"><?php echo $kota;?></span></td>
                </tr>
                <tr>
                  <th><?php echo $this->lang->line('umb_provinsi');?></th>
                  <td style="display: table-cell;"><?php echo $provinsi;?></span></td>
                </tr>
                <tr>
                  <th><?php echo $this->lang->line('umb_kode_pos');?></th>
                  <td style="display: table-cell;"><?php echo $kode_pos;?></span></td>
                </tr>
                <tr>
                  <th><?php echo $this->lang->line('umb_negara');?></th>
                  <td style="display: table-cell;"><?php foreach($all_negaraa as $negara) {?>
                    <?php if($negaraid==$negara->negara_id):?>
                      <?php echo $negara->nama_negara;?>
                    <?php endif;?>
                    <?php } ?></td>
                  </tr>
                  <tr>
                    <th><?php echo $this->lang->line('umb_logo_perusahaan');?></th>
                    <td style="display: table-cell;"><?php if($logo!='' || $logo!='no-file'){?>
                      <div class="avatar box-48 mr-0-5"> <img class="d-block ui-w-100 rounded-circle" src="<?php echo base_url();?>uploads/perusahaan/<?php echo $logo;?>" alt="" width="50"></a> </div>
                      <?php } ?></td>
                    </tr>
                    <?php $count_module_attributes = $this->Custom_fields_model->count_perusahaan_module_attributes();?>
                    <?php $module_attributes = $this->Custom_fields_model->perusahaan_hrastral_module_attributes();?>
                    <?php foreach($module_attributes as $mattribute):?>
                      <?php $attribute_info = $this->Custom_fields_model->get_data_custom_karyawan($perusahaan_id,$mattribute->custom_field_id);?>
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
                </table></div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('umb_close');?></button>
              </div>
              <?php echo form_close(); ?>
            <?php }
            ?>
