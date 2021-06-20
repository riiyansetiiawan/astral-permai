<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['field_id']) && $_GET['data']=='emp_kontak' && $_GET['type']=='emp_kontak'){
  ?>
  <div class="modal-header"> 
    <?php echo form_button(array('aria-label' => 'Close', 'data-dismiss' => 'modal', 'type' => 'button', 'class' => 'close', 'content' => '<span aria-hidden="true">×</span>')); ?>
    <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_e_details_edit_kontak');?></h4>
  </div>
  <?php $attributes = array('name' => 'e_info_kontak', 'id' => 'e_info_kontak', 'autocomplete' => 'off');?>
  <?php $hidden = array('u_basic_info' => 'UPDATE');?>
  <?php echo form_open('admin/karyawans/e_info_kontak', $attributes, $hidden);?>
  <?php
  $edata_usr1 = array(
    'type'  => 'hidden',
    'id'  => 'user_id',
    'name'  => 'user_id',
    'value' => $karyawan_id,
  );
  echo form_input($edata_usr1);
  ?>
  <?php
  $edata_usr2 = array(
    'type'  => 'hidden',
    'id'  => 'e_field_id',
    'name'  => 'e_field_id',
    'value' => $kontak_id,
  );
  echo form_input($edata_usr2);
  ?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-5">
        <div class="form-group">
          <label for="relation">
            <?php echo $this->lang->line('umb_e_details_relation');?>
            <i class="hrastral-asterisk">*</i>
          </label>
          <select class="form-control" name="relation" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_select_one');?>">
            <option value=""><?php echo $this->lang->line('umb_select_one');?></option>
            <option value="Self" <?php if($relation=='Self'){?> selected="selected" <?php }?>><?php echo $this->lang->line('umb_self');?></option>
            <option value="Parent" <?php if($relation=='Parent'){?> selected="selected" <?php }?>><?php echo $this->lang->line('umb_parent');?></option>
            <option value="Spouse" <?php if($relation=='Spouse'){?> selected="selected" <?php }?>><?php echo $this->lang->line('umb_spouse');?></option>
            <option value="Child" <?php if($relation=='Child'){?> selected="selected" <?php }?>><?php echo $this->lang->line('umb_child');?></option>
            <option value="Sibling" <?php if($relation=='Sibling'){?> selected="selected" <?php }?>><?php echo $this->lang->line('umb_sibling');?></option>
            <option value="In Laws" <?php if($relation=='In Laws'){?> selected="selected" <?php }?>><?php echo $this->lang->line('umb_in_laws');?></option>
          </select>
        </div>
      </div>
      <div class="col-md-7">
        <div class="form-group">
          <label for="email_kerja" class="control-label">
            <?php echo $this->lang->line('dashboard_email');?>
            <i class="hrastral-asterisk">*</i>
          </label>
          <input class="form-control" placeholder="<?php echo $this->lang->line('umb_e_details_work');?>" name="email_kerja" type="text" value="<?php echo $email_kerja;?>">
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-5">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="is_primary" value="1" name="is_primary" <?php if($is_primary=='1'){?> checked="checked" <?php }?>>
                <span class="custom-control-label"><?php echo $this->lang->line('umb_e_details_pcontact');?></span> 
              </label>
            </div>
          </div>
          <div class="col-md-6">
            <label class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" id="is_dependent" value="2" name="is_dependent" <?php if($is_dependent=='2'){?> checked="checked"<?php }?>>
              <span class="custom-control-label"><?php echo $this->lang->line('umb_e_details_dependent');?></span> 
            </label>
          </div>
        </div>
      </div>
      <div class="col-md-7">
        <div class="form-group">
          <input class="form-control" placeholder="<?php echo $this->lang->line('umb_e_details_personal');?>" name="email_pribadi" type="text" value="<?php echo $email_pribadi;?>">
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-5">
        <div class="form-group">
          <label for="name" class="control-label">
            <?php echo $this->lang->line('umb_name');?>
            <i class="hrastral-asterisk">*</i>
          </label>
          <input class="form-control" placeholder="<?php echo $this->lang->line('umb_name');?>" name="kontak_name" type="text" value="<?php echo $kontak_name;?>">
        </div>
      </div>
      <div class="col-md-7">
        <div class="form-group" id="penunjukan_ajax">
          <label for="alamat_1" class="control-label"><?php echo $this->lang->line('umb_alamat');?></label>
          <input class="form-control" placeholder="<?php echo $this->lang->line('umb_alamat_1');?>" name="alamat_1" type="text" value="<?php echo $alamat_1;?>">
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-5">
        <div class="form-group">
          <label for="phone_kerja">
            <?php echo $this->lang->line('umb_phone');?>
            <i class="hrastral-asterisk">*</i>
          </label>
          <div class="row">
            <div class="col-md-8">
              <input class="form-control" placeholder="<?php echo $this->lang->line('umb_e_details_work');?>" name="phone_kerja" type="text" value="<?php echo $phone_kerja;?>">
            </div>
            <div class="col-md-4">
              <input class="form-control" placeholder="<?php echo $this->lang->line('umb_e_details_phone_ext');?>" name="extension_phone_kerja" type="text" value="<?php echo $extension_phone_kerja;?>">
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-7">
        <div class="form-group">
          <input class="form-control" placeholder="<?php echo $this->lang->line('umb_alamat_2');?>" name="alamat_2" type="text" value="<?php echo $alamat_2;?>">
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-5">
        <div class="form-group">
          <input class="form-control" placeholder="<?php echo $this->lang->line('umb_e_details_mobile');?>" name="mobile_phone" type="text" value="<?php echo $mobile_phone;?>">
        </div>
      </div>
      <div class="col-md-7">
        <div class="form-group">
          <div class="row">
            <div class="col-md-5">
              <input class="form-control" placeholder="<?php echo $this->lang->line('umb_kota');?>" name="kota" type="text" value="<?php echo $kota;?>">
            </div>
            <div class="col-md-4">
              <input class="form-control" placeholder="<?php echo $this->lang->line('umb_provinsi');?>" name="provinsi" type="text" value="<?php echo $provinsi;?>">
            </div>
            <div class="col-md-3">
              <input class="form-control" placeholder="<?php echo $this->lang->line('umb_kode_pos');?>" name="kode_pos" type="text" value="<?php echo $kode_pos;?>">
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-5">
        <div class="form-group">
          <input class="form-control" placeholder="<?php echo $this->lang->line('umb_e_details_home');?>" name="home_phone" type="text" value="<?php echo $home_phone;?>">
        </div>
      </div>
      <div class="col-md-7">
        <div class="form-group">
          <select name="negara" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_negara');?>">
            <option value=""></option>
            <?php foreach($all_negaraa as $negara) {?>
              <option value="<?php echo $negara->negara_id;?>" <?php if($negara->negara_id==$inegara){?> selected="selected" <?php }?>> <?php echo $negara->nama_negara;?></option>
            <?php } ?>
          </select>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer"> <?php echo form_button(array('data-dismiss' => 'modal', 'type' => 'button', 'class' => 'btn btn-secondary', 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('umb_close'))); ?> <?php echo form_button(array('name' => 'hrastral_form', 'type' => 'submit', 'class' => $this->Umb_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('umb_update'))); ?> </div>
  <?php echo form_close(); ?> 
  <script type="text/javascript">
    $(document).ready(function(){
      $('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
      $('[data-plugin="select_hrm"]').select2({ width:'100%' });
      Ladda.bind('button[type=submit]');
      /* Update contact info */
      $("#e_info_kontak").submit(function(e){
        e.preventDefault();
        var obj = $(this), action = obj.attr('name');
        $('.save').prop('disabled', true);
        $.ajax({
          type: "POST",
          url: e.target.action,
          data: obj.serialize()+"&is_ajax=5&data=e_info_kontak&type=e_info_kontak&form="+action,
          cache: false,
          success: function (JSON) {
            if (JSON.error != '') {
              toastr.error(JSON.error);
              $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
              $('.save').prop('disabled', false);
              Ladda.stopAll();
            } else {
              $('.edit-modal-data').modal('toggle');
              var umb_table_kontak = $('#umb_table_kontak').dataTable({
                "bDestroy": true,
                "ajax": {
                  url : "<?php echo site_url("admin/karyawans/kontaks") ?>/"+$('#user_id').val(),
                  type : 'GET'
                },
                "fnDrawCallback": function(settings){
                  $('[data-toggle="tooltip"]').tooltip();          
                }
              });
              umb_table_kontak.api().ajax.reload(function(){ 
                toastr.success(JSON.result);
                $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
              }, true);
              $('.save').prop('disabled', false);
              Ladda.stopAll();
            }
          }
        });
      });
    });	
  </script>
<?php } else if(isset($_GET['jd']) && isset($_GET['field_id']) && $_GET['data']=='krywn_document' && $_GET['type']=='krywn_document'){
  ?>
  <div class="modal-header"> 
    <?php echo form_button(array('aria-label' => 'Close', 'data-dismiss' => 'modal', 'type' => 'button', 'class' => 'close', 'content' => '<span aria-hidden="true">×</span>')); ?>
    <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_e_details_edit_document');?></h4>
  </div>
  <?php $attributes = array('name' => 'e_info_document', 'id' => 'e_info_document', 'autocomplete' => 'off');?>
  <?php $hidden = array('u_document_info' => 'UPDATE');?>
  <?php echo form_open_multipart('admin/karyawans/e_info_document', $attributes, $hidden);?>
  <?php
  $edata_usr3 = array(
    'type'  => 'hidden',
    'id'  => 'user_id',
    'name'  => 'user_id',
    'value' => $d_karyawan_id,
  );
  echo form_input($edata_usr3);
  ?>
  <?php
  $edata_usr4 = array(
    'type'  => 'hidden',
    'id'  => 'e_field_id',
    'name'  => 'e_field_id',
    'value' => $document_id,
  );
  echo form_input($edata_usr4);
  ?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="relation">
            <?php echo $this->lang->line('umb_e_details_dtype');?>
            <i class="hrastral-asterisk">*</i>
          </label>
          <select name="type_document_id" id="type_document_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_e_details_choose_dtype');?>">
            <option value=""></option>
            <?php foreach($all_types_document as $type_document) {?>
              <option value="<?php echo $type_document->type_document_id;?>" <?php if($type_document->type_document_id==$type_document_id) {?> selected="selected" <?php } ?>> <?php echo $type_document->type_document;?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="tanggal_kadaluarsa" class="control-label"><?php echo $this->lang->line('umb_e_details_doe');?></label>
          <input class="form-control e_date" readonly placeholder="<?php echo $this->lang->line('umb_e_details_doe');?>" name="tanggal_kadaluarsa" type="text" value="<?php echo $tanggal_kadaluarsa;?>">
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          <label for="title" class="control-label">
            <?php echo $this->lang->line('umb_e_details_dtitle');?>
            <i class="hrastral-asterisk">*</i>
          </label>
          <input class="form-control" placeholder="<?php echo $this->lang->line('umb_e_details_dtitle');?>" name="title" type="text" value="<?php echo $title;?>">
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="description" class="control-label"><?php echo $this->lang->line('umb_description');?></label>
          <textarea class="form-control" placeholder="<?php echo $this->lang->line('umb_description');?>" data-show-counter="1" data-limit="300" name="description" cols="30" rows="3" id="d_description"><?php echo $description;?></textarea>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <fieldset class="form-group">
            <label for="logo"><?php echo $this->lang->line('umb_e_details_document_file');?></label>
            <input type="file" class="form-control-file" id="document_file" name="document_file">
            <small><?php echo $this->lang->line('umb_e_details_d_type_file');?></small>
            <?php if($document_file!='' && $document_file!='no file') {?>
              <br />
              <a href="<?php echo site_url('admin/download/');?>?type=document&filename=<?php echo $document_file;?>"><?php echo $document_file;?></a>
            <?php } ?>
          </fieldset>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer"> <?php echo form_button(array('data-dismiss' => 'modal', 'type' => 'button', 'class' => 'btn btn-secondary', 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('umb_close'))); ?> <?php echo form_button(array('name' => 'hrastral_form', 'type' => 'submit', 'class' => $this->Umb_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('umb_update'))); ?> </div>
  <?php echo form_close(); ?> 
  <script type="text/javascript">
    $(document).ready(function(){	
      $('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
      $('[data-plugin="select_hrm"]').select2({ width:'100%' });
      Ladda.bind('button[type=submit]');
      $('.e_date').bootstrapMaterialDatePicker({
        weekStart: 0,
        time: false,
        clearButton: false,
        format: 'YYYY-MM-DD'
      });
      $("#e_info_document").submit(function(e){
        var fd = new FormData(this);
        var obj = $(this), action = obj.attr('name');
        fd.append("is_ajax", 9);
        fd.append("type", 'e_info_document');
        fd.append("data", 'e_info_document');
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
          success: function(JSON) {
            if (JSON.error != '') {
              toastr.error(JSON.error);
              $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
              $('.save').prop('disabled', false);
              Ladda.stopAll();
            } else {
              $('.edit-modal-data').modal('toggle');
              var umb_table_document = $('#umb_table_document').dataTable({
                "bDestroy": true,
                "ajax": {
                  url : "<?php echo site_url("admin/karyawans/documents") ?>/"+$('#user_id').val(),
                  type : 'GET'
                },
                "fnDrawCallback": function(settings){
                  $('[data-toggle="tooltip"]').tooltip();          
                }
              });
              umb_table_document.api().ajax.reload(function(){ 
                toastr.success(JSON.result);
                $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
              }, true);
              $('.save').prop('disabled', false);
              Ladda.stopAll();
            }
          },
          error: function() {
            toastr.error(JSON.error);
            $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
            $('.save').prop('disabled', false);
            Ladda.stopAll();
          } 	        
        });
      });
    });	
  </script>
<?php } else if(isset($_GET['jd']) && isset($_GET['field_id']) && $_GET['data']=='e_imgdocument' && $_GET['type']=='e_imgdocument'){
  ?>
  <div class="modal-header"> 
    <?php echo form_button(array('aria-label' => 'Close', 'data-dismiss' => 'modal', 'type' => 'button', 'class' => 'close', 'content' => '<span aria-hidden="true">×</span>')); ?>
    <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_edit_immigration');?></h4>
  </div>
  <?php $attributes = array('name' => 'e_imgdocument_info', 'id' => 'e_imgdocument_info', 'autocomplete' => 'off');?>
  <?php $hidden = array('u_document_info' => 'UPDATE');?>
  <?php echo form_open_multipart('admin/karyawans/e_info_immigration', $attributes, $hidden);?>
  <?php
  $edata_usr5 = array(
    'type'  => 'hidden',
    'id'  => 'user_id',
    'name'  => 'user_id',
    'value' => $d_karyawan_id,
  );
  echo form_input($edata_usr5);
  ?>
  <?php
  $edata_usr6 = array(
    'type'  => 'hidden',
    'id'  => 'e_field_id',
    'name'  => 'e_field_id',
    'value' => $immigration_id,
  );
  echo form_input($edata_usr6);
  ?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="relation"><?php echo $this->lang->line('umb_e_details_document');?></label>
          <select name="type_document_id" id="type_document_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_e_details_choose_dtype');?>">
            <option value=""></option>
            <?php foreach($all_types_document as $type_document) {?>
              <option value="<?php echo $type_document->type_document_id;?>" <?php if($type_document->type_document_id==$type_document_id) {?> selected="selected" <?php } ?>> <?php echo $type_document->type_document;?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="nomor_document" class="control-label">
            <?php echo $this->lang->line('umb_karyawan_nomor_document');?>
            <i class="hrastral-asterisk">*</i>
          </label>
          <input class="form-control" placeholder="<?php echo $this->lang->line('umb_karyawan_nomor_document');?>" name="nomor_document" type="text" value="<?php echo $nomor_document;?>">
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-3">
        <div class="form-group">
          <label for="tanggal_terbit" class="control-label">
            <?php echo $this->lang->line('umb_tanggal_terbit');?>
            <i class="hrastral-asterisk">*</i>
          </label>
          <input class="form-control e_date" readonly="readonly" placeholder="<?php echo $this->lang->line('umb_tanggal_terbit');?>" name="tanggal_terbit" type="text" value="<?php echo $tanggal_terbit;?>">
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label for="tanggal_kaaluarsa" class="control-label">
            <?php echo $this->lang->line('umb_tanggal_kaaluarsa');?>
            <i class="hrastral-asterisk">*</i>
          </label>
          <input class="form-control e_date" readonly="readonly" placeholder="<?php echo $this->lang->line('umb_tanggal_kaaluarsa');?>" name="tanggal_kaaluarsa" type="text" value="<?php echo $tanggal_kaaluarsa;?>">
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <fieldset class="form-group">
            <label for="logo">
              <?php echo $this->lang->line('umb_e_details_document_file');?>
              <i class="hrastral-asterisk">*</i>
            </label>
            <input type="file" class="form-control-file" id="p_file2" name="document_file">
            <small><?php echo $this->lang->line('umb_e_details_d_type_file');?></small>
            <?php if($document_file!='' && $document_file!='no file') {?> <br />
            <a href="<?php echo site_url('admin/download/');?>?type=document/immigration&filename=<?php echo $document_file;?>"><?php echo $document_file;?></a>
          <?php } ?>
        </fieldset>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="tanggal_tinjauan_yang_memenuhi_syarat" class="control-label"><?php echo $this->lang->line('umb_tanggal_tinjauan_yang_memenuhi_syarat');?></label>
        <input class="form-control e_date" readonly="readonly" placeholder="<?php echo $this->lang->line('umb_tanggal_tinjauan_yang_memenuhi_syarat');?>" name="tanggal_tinjauan_yang_memenuhi_syarat" type="text" value="<?php echo $tanggal_tinjauan_yang_memenuhi_syarat;?>">
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="send_mail"><?php echo $this->lang->line('umb_negara');?></label>
        <select class="form-control" name="negara" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_negara');?>">
          <option value=""><?php echo $this->lang->line('umb_select_one');?></option>
          <?php foreach($all_negaraa as $snegara) {?>
            <option value="<?php echo $snegara->negara_id;?>" <?php if($snegara->negara_id==$negara_id) {?> selected="selected" <?php } ?>> <?php echo $snegara->nama_negara;?></option>
          <?php } ?>
        </select>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('umb_close');?></button>
    <button type="submit" class="btn btn-primary"><?php echo $this->lang->line('umb_update');?></button>
  </div>
</div>
<?php echo form_close(); ?> 
<script type="text/javascript">
  $(document).ready(function(){
    $('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
    $('[data-plugin="select_hrm"]').select2({ width:'100%' });
    Ladda.bind('button[type=submit]');
    $('.e_date').bootstrapMaterialDatePicker({
      weekStart: 0,
      time: false,
      clearButton: false,
      format: 'YYYY-MM-DD'
    });
    $("#e_imgdocument_info").submit(function(e){
      var fd = new FormData(this);
      var obj = $(this), action = obj.attr('name');
      fd.append("is_ajax", 9);
      fd.append("type", 'e_info_immigration');
      fd.append("data", 'e_info_immigration');
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
        success: function(JSON) {
          if (JSON.error != '') {
            toastr.error(JSON.error);
            $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
            $('.save').prop('disabled', false);
            Ladda.stopAll();
          } else {
            $('.edit-modal-data').modal('toggle');
            var umb_table_immigration = $('#umb_table_imgdocument').dataTable({
              "bDestroy": true,
              "ajax": {
                url : "<?php echo site_url("admin/karyawans/immigration") ?>/"+$('#user_id').val(),
                type : 'GET'
              },
              "fnDrawCallback": function(settings){
                $('[data-toggle="tooltip"]').tooltip();          
              }
            });
            umb_table_immigration.api().ajax.reload(function(){ 
              toastr.success(JSON.result);
              $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
            }, true);
            $('.save').prop('disabled', false);
            Ladda.stopAll();
          }
        },
        error: function() {
          toastr.error(JSON.error);
          $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
          $('.save').prop('disabled', false);
          Ladda.stopAll();
        } 	        
      });
    });
  });	
</script>
<?php } else if(isset($_GET['jd']) && isset($_GET['field_id']) && $_GET['data']=='emp_qualification' && $_GET['type']=='emp_qualification'){
  ?>
  <div class="modal-header"> 
    <?php echo form_button(array('aria-label' => 'Close', 'data-dismiss' => 'modal', 'type' => 'button', 'class' => 'close', 'content' => '<span aria-hidden="true">×</span>')); ?>
    <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_e_details_edit_qualification');?></h4>
  </div>
  <?php $attributes = array('name' => 'e_info_qualification', 'id' => 'e_info_qualification', 'autocomplete' => 'off');?>
  <?php $hidden = array('u_basic_info' => 'UPDATE');?>
  <?php echo form_open('admin/karyawans/e_info_qualification', $attributes, $hidden);?>
  <?php
  $edata_usr7 = array(
    'type'  => 'hidden',
    'id'  => 'user_id',
    'name'  => 'user_id',
    'value' => $karyawan_id,
  );
  echo form_input($edata_usr7);
  ?>
  <?php
  $edata_usr8 = array(
    'type'  => 'hidden',
    'id'  => 'e_field_id',
    'name'  => 'e_field_id',
    'value' => $qualification_id,
  );
  echo form_input($edata_usr8);
  ?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="name">
            <?php echo $this->lang->line('umb_e_details_inst_name');?>
            <i class="hrastral-asterisk">*</i>
          </label>
          <input class="form-control" placeholder="<?php echo $this->lang->line('umb_e_details_inst_name');?>" name="name" type="text" value="<?php echo $name;?>">
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="tingkat_pendidikan" class="control-label"><?php echo $this->lang->line('umb_e_details_edu_level');?></label>
          <select class="form-control" name="tingkat_pendidikan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_e_details_edu_level');?>">
            <?php foreach($all_tingkat_pendidikan as $tingkat_pendidikan) {?>
              <option value="<?php echo $tingkat_pendidikan->tingkat_pendidikan_id;?>" <?php if($tingkat_pendidikan->tingkat_pendidikan_id==$tingkat_pendidikan_id) {?> selected="selected" <?php } ?>> <?php echo $tingkat_pendidikan->name;?></option>
            <?php } ?>
          </select>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="from_year" class="control-label">
            <?php echo $this->lang->line('umb_e_details_timeperiod');?>
            <i class="hrastral-asterisk">*</i>
          </label>
          <div class="row">
            <div class="col-md-6">
              <input class="form-control edate" readonly="readonly" value="<?php echo $from_year;?>" placeholder="<?php echo $this->lang->line('umb_e_details_from');?>" name="from_year" type="text">
            </div>
            <div class="col-md-6">
              <input class="form-control edate" readonly="readonly" value="<?php echo $to_year;?>" placeholder="<?php echo $this->lang->line('dashboard_to');?>" name="to_year" type="text">
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="language" class="control-label"><?php echo $this->lang->line('umb_e_details_language');?></label>
          <select class="form-control" name="language" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_e_details_language');?>">
            <?php foreach($all_qualification_language as $qualification_language) {?>
              <option value="<?php echo $qualification_language->language_id;?>" <?php if($qualification_language->language_id==$language_id) {?> selected="selected" <?php } ?>> <?php echo $qualification_language->name;?></option>
            <?php } ?>
          </select>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="skill" class="control-label"><?php echo $this->lang->line('umb_e_details_skill');?></label>
          <select class="form-control" name="skill" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_e_details_skill');?>">
            <?php foreach($all_qualification_skill as $qualification_skill) {?>
              <option value="<?php echo $qualification_skill->skill_id?>" <?php if($qualification_skill->skill_id==$skill_id) {?> selected="selected" <?php } ?>><?php echo $qualification_skill->name?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="to_year" class="control-label"><?php echo $this->lang->line('umb_description');?></label>
          <textarea class="form-control" placeholder="<?php echo $this->lang->line('umb_description');?>" data-show-counter="1" data-limit="300" name="description" cols="30" rows="3" id="d_description"><?php echo $description;?></textarea>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer"> <?php echo form_button(array('data-dismiss' => 'modal', 'type' => 'button', 'class' => 'btn btn-secondary', 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('umb_close'))); ?> <?php echo form_button(array('name' => 'hrastral_form', 'type' => 'submit', 'class' => $this->Umb_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('umb_update'))); ?> </div>
  <?php echo form_close(); ?> 
  <script type="text/javascript">
    $(document).ready(function(){	
      $('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
      $('[data-plugin="select_hrm"]').select2({ width:'100%' });
      Ladda.bind('button[type=submit]');
      $('.edate').bootstrapMaterialDatePicker({
        weekStart: 0,
        time: false,
        clearButton: false,
        format: 'YYYY-MM-DD'
      });
      $("#e_info_qualification").submit(function(e){
        e.preventDefault();
        var obj = $(this), action = obj.attr('name');
        $('.save').prop('disabled', true);
        $.ajax({
          type: "POST",
          url: e.target.action,
          data: obj.serialize()+"&is_ajax=11&data=e_info_qualification&type=e_info_qualification&form="+action,
          cache: false,
          success: function (JSON) {
            if (JSON.error != '') {
              toastr.error(JSON.error);
              $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
              $('.save').prop('disabled', false);
              Ladda.stopAll();
            } else {
              $('.edit-modal-data').modal('toggle');
              var umb_table_qualification = $('#umb_table_qualification').dataTable({
                "bDestroy": true,
                "ajax": {
                  url : "<?php echo site_url("admin/karyawans/qualification") ?>/"+$('#user_id').val(),
                  type : 'GET'
                },
                "fnDrawCallback": function(settings){
                  $('[data-toggle="tooltip"]').tooltip();          
                }
              });
              umb_table_qualification.api().ajax.reload(function(){
                toastr.success(JSON.result);
                $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
              }, true);
              $('.save').prop('disabled', false);
              Ladda.stopAll();
            }
          }
        });
      });
    });	
  </script>
<?php } else if(isset($_GET['jd']) && isset($_GET['field_id']) && $_GET['data']=='emp_pengalaman_kerja' && $_GET['type']=='emp_pengalaman_kerja'){
  ?>
  <div class="modal-header"> 
    <?php echo form_button(array('aria-label' => 'Close', 'data-dismiss' => 'modal', 'type' => 'button', 'class' => 'close', 'content' => '<span aria-hidden="true">×</span>')); ?>
    <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_e_details_edit_wexp');?></h4>
  </div>
  <?php $attributes = array('name' => 'e_info_pengalaman_kerja', 'id' => 'e_info_pengalaman_kerja', 'autocomplete' => 'off');?>
  <?php $hidden = array('u_basic_info' => 'UPDATE');?>
  <?php echo form_open('admin/karyawans/e_info_pengalaman_kerja', $attributes, $hidden);?>
  <?php
  $edata_usr7 = array(
    'type'  => 'hidden',
    'id'  => 'user_id',
    'name'  => 'user_id',
    'value' => $karyawan_id,
  );
  echo form_input($edata_usr7);
  ?>
  <?php
  $edata_usr8 = array(
    'type'  => 'hidden',
    'id'  => 'e_field_id',
    'name'  => 'e_field_id',
    'value' => $pengalaman_kerja_id,
  );
  echo form_input($edata_usr8);
  ?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="nama_perusahaan">
            <?php echo $this->lang->line('umb_nama_perusahaan');?>
            <i class="hrastral-asterisk">*</i>
          </label>
          <input class="form-control" placeholder="<?php echo $this->lang->line('umb_nama_perusahaan');?>" name="nama_perusahaan" type="text" value="<?php echo $nama_perusahaan;?>" id="nama_perusahaan">
        </div>
        <div class="form-group">
          <label for="from_date">
            <?php echo $this->lang->line('umb_e_details_frm_date');?>
            <i class="hrastral-asterisk">*</i>
          </label>
          <input type="text" class="form-control edate" id="e_from_date" name="from_date" placeholder="<?php echo $this->lang->line('umb_e_details_frm_date');?>" readonly value="<?php echo $from_date;?>">
        </div>
        <div class="form-group">
          <label for="to_date">
            <?php echo $this->lang->line('umb_e_details_to_date');?>
            <i class="hrastral-asterisk">*</i>
          </label>
          <input type="text" class="form-control edate" id="e_to_date" name="to_date" placeholder="<?php echo $this->lang->line('umb_e_details_to_date');?>" readonly value="<?php echo $to_date;?>">
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="post">
            <?php echo $this->lang->line('umb_e_details_post');?>
            <i class="hrastral-asterisk">*</i>
          </label>
          <input class="form-control" placeholder="<?php echo $this->lang->line('umb_e_details_post');?>" name="post" type="text" value="<?php echo $post;?>" id="post">
        </div>
        <div class="form-group">
          <label for="description"><?php echo $this->lang->line('umb_description');?></label>
          <textarea class="form-control" placeholder="<?php echo $this->lang->line('umb_description');?>" data-show-counter="1" data-limit="300" name="description" cols="30" rows="4" id="description"><?php echo $description;?></textarea>
          <span class="countdown"></span> 
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer"> <?php echo form_button(array('data-dismiss' => 'modal', 'type' => 'button', 'class' => 'btn btn-secondary', 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('umb_close'))); ?> <?php echo form_button(array('name' => 'hrastral_form', 'type' => 'submit', 'class' => $this->Umb_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('umb_update'))); ?> </div>
  <?php echo form_close(); ?> 
  <script type="text/javascript">
    $(document).ready(function(){
      $('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
      $('[data-plugin="select_hrm"]').select2({ width:'100%' });
      Ladda.bind('button[type=submit]');
      $('.edate').bootstrapMaterialDatePicker({
        weekStart: 0,
        time: false,
        clearButton: false,
        format: 'YYYY-MM-DD'
      });
      $("#e_info_pengalaman_kerja").submit(function(e){
        e.preventDefault();
        var obj = $(this), action = obj.attr('name');
        $('.save').prop('disabled', true);
        $.ajax({
          type: "POST",
          url: e.target.action,
          data: obj.serialize()+"&is_ajax=14&data=e_info_pengalaman_kerja&type=e_info_pengalaman_kerja&form="+action,
          cache: false,
          success: function (JSON) {
            if (JSON.error != '') {
              toastr.error(JSON.error);
              $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
              $('.save').prop('disabled', false);
              Ladda.stopAll();
            } else {
              $('.edit-modal-data').modal('toggle');
              var umb_table_pengalaman_kerja = $('#umb_table_pengalaman_kerja').dataTable({
                "bDestroy": true,
                "ajax": {
                  url : "<?php echo site_url("admin/karyawans/pengalaman") ?>/"+$('#user_id').val(),
                  type : 'GET'
                },
                "fnDrawCallback": function(settings){
                  $('[data-toggle="tooltip"]').tooltip();          
                }
              });
              umb_table_pengalaman_kerja.api().ajax.reload(function(){ 
                toastr.success(JSON.result);
                $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
              }, true);
              $('.save').prop('disabled', false);
              Ladda.stopAll();
            }
          }
        });
      });
    });	
  </script>
<?php } else if(isset($_GET['jd']) && isset($_GET['field_id']) && $_GET['data']=='emp_bank_account' && $_GET['type']=='emp_bank_account'){
  ?>
  <div class="modal-header"> 
    <?php echo form_button(array('aria-label' => 'Close', 'data-dismiss' => 'modal', 'type' => 'button', 'class' => 'close', 'content' => '<span aria-hidden="true">×</span>')); ?>
    <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_e_details_edit_baccount');?></h4>
  </div>
  <?php $attributes = array('name' => 'e_info_bank_account', 'id' => 'e_info_bank_account', 'autocomplete' => 'off');?>
  <?php $hidden = array('u_basic_info' => 'UPDATE');?>
  <?php echo form_open('admin/karyawans/e_info_bank_account', $attributes, $hidden);?>
  <?php
  $edata_usr7 = array(
    'type'  => 'hidden',
    'id'  => 'user_id',
    'name'  => 'user_id',
    'value' => $karyawan_id,
  );
  echo form_input($edata_usr7);
  ?>
  <?php
  $edata_usr8 = array(
    'type'  => 'hidden',
    'id'  => 'e_field_id',
    'name'  => 'e_field_id',
    'value' => $bankaccount_id,
  );
  echo form_input($edata_usr8);
  ?>
  <div class="modal-body">
    <div class="row">
      <div class="col-sm-6">
        <div class="form-group">
          <label for="account_title">
            <?php echo $this->lang->line('umb_e_details_acc_title');?>
            <i class="hrastral-asterisk">*</i>
          </label>
          <input class="form-control" placeholder="<?php echo $this->lang->line('umb_e_details_acc_title');?>" name="account_title" type="text" value="<?php echo $account_title;?>" id="nama_account">
        </div>
        <div class="form-group">
          <label for="nomor_account">
            <?php echo $this->lang->line('umb_e_details_acc_number');?>
            <i class="hrastral-asterisk">*</i>
          </label>
          <input class="form-control" placeholder="<?php echo $this->lang->line('umb_e_details_acc_number');?>" name="nomor_account" type="text" value="<?php echo $nomor_account;?>" id="nomor_account">
        </div>
      </div>
      <div class="col-sm-6">
        <div class="form-group">
          <label for="nama_bank">
            <?php echo $this->lang->line('umb_e_details_nama_bank');?>
            <i class="hrastral-asterisk">*</i>
          </label>
          <input class="form-control" placeholder="<?php echo $this->lang->line('umb_e_details_nama_bank');?>" name="nama_bank" type="text" value="<?php echo $nama_bank;?>" id="nama_bank">
        </div>
        <div class="form-group">
          <label for="kode_bank">
            <?php echo $this->lang->line('umb_e_details_kode_bank');?>
            <i class="hrastral-asterisk">*</i>
          </label>
          <input class="form-control" placeholder="<?php echo $this->lang->line('umb_e_details_kode_bank');?>" name="kode_bank" type="text" value="<?php echo $kode_bank;?>" id="kode_bank">
        </div>
      </div>
      <div class="col-sm-12">
        <div class="form-group">
          <label for="cabang_bank"><?php echo $this->lang->line('umb_e_details_cabang_bank');?></label>
          <input class="form-control" placeholder="<?php echo $this->lang->line('umb_e_details_cabang_bank');?>" name="cabang_bank" type="text" value="<?php echo $cabang_bank;?>" id="cabang_bank">
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer"> <?php echo form_button(array('data-dismiss' => 'modal', 'type' => 'button', 'class' => 'btn btn-secondary', 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('umb_close'))); ?> <?php echo form_button(array('name' => 'hrastral_form', 'type' => 'submit', 'class' => $this->Umb_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('umb_update'))); ?> </div>
  <?php echo form_close(); ?> 
  <script type="text/javascript">
    $(document).ready(function(){
      Ladda.bind('button[type=submit]');
      /* Update bank acount info */
      $("#e_info_bank_account").submit(function(e){
        e.preventDefault();
        var obj = $(this), action = obj.attr('name');
        $('.save').prop('disabled', true);
        $.ajax({
          type: "POST",
          url: e.target.action,
          data: obj.serialize()+"&is_ajax=17&data=e_info_bank_account&type=e_info_bank_account&form="+action,
          cache: false,
          success: function (JSON) {
            if (JSON.error != '') {
              toastr.error(JSON.error);
              $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
              $('.save').prop('disabled', false);
              Ladda.stopAll();
            } else {
              $('.edit-modal-data').modal('toggle');
              var umb_table_bank_account = $('#umb_table_bank_account').dataTable({
                "bDestroy": true,
                "ajax": {
                  url : "<?php echo site_url("admin/karyawans/bank_account") ?>/"+$('#user_id').val(),
                  type : 'GET'
                },
                "fnDrawCallback": function(settings){
                  $('[data-toggle="tooltip"]').tooltip();          
                }
              });
              umb_table_bank_account.api().ajax.reload(function(){ 
                toastr.success(JSON.result);
                $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
              }, true);
              $('.save').prop('disabled', false);
              Ladda.stopAll();
            }
          }
        });
      });
    });	
  </script>
<?php } else if(isset($_GET['jd']) && isset($_GET['field_id']) && $_GET['data']=='einfo_security_level' && $_GET['type']=='einfo_security_level'){
  ?>
  <div class="modal-header"> 
    <?php echo form_button(array('aria-label' => 'Close', 'data-dismiss' => 'modal', 'type' => 'button', 'class' => 'close', 'content' => '<span aria-hidden="true">×</span>')); ?>
    <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_edit_krywn_security_level');?></h4>
  </div>
  <?php $attributes = array('name' => 'e_info_security_level', 'id' => 'e_info_security_level', 'autocomplete' => 'off');?>
  <?php $hidden = array('u_basic_info' => 'UPDATE');?>
  <?php echo form_open('admin/karyawans/e_info_security_level', $attributes, $hidden);?>
  <?php
  $edata_usr7 = array(
    'type'  => 'hidden',
    'id'  => 'user_id',
    'name'  => 'user_id',
    'value' => $karyawan_id,
  );
  echo form_input($edata_usr7);
  ?>
  <?php
  $edata_usr8 = array(
    'type'  => 'hidden',
    'id'  => 'e_field_id',
    'name'  => 'e_field_id',
    'value' => $security_level_id,
  );
  echo form_input($edata_usr8);
  ?>
  <?php $list_security_level = $this->Umb_model->get_type_security_level();?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <label for="account_title">
            <?php echo $this->lang->line('umb_esecurity_level_title');?>
            <i class="hrastral-asterisk">*</i>
          </label>
          <select class="form-control" name="security_level" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_esecurity_level_title');?>">
            <option value=""><?php echo $this->lang->line('umb_esecurity_level_title');?></option>
            <?php foreach($list_security_level->result() as $sc_level) {?>
              <option value="<?php echo $sc_level->type_id?>" <?php if($security_type==$sc_level->type_id):?> selected="selected"<?php endif;?>><?php echo $sc_level->name?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label for="nomor_account"><?php echo $this->lang->line('umb_e_details_doe');?></label>
          <input class="form-control ee_date" placeholder="<?php echo $this->lang->line('umb_e_details_doe');?>" name="tanggal_kaaluarsa" type="text" value="<?php echo $tanggal_kaaluarsa;?>" >
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label for="nomor_account"><?php echo $this->lang->line('umb_e_details_do_clearance');?></label>
          <input class="form-control ee_date" placeholder="<?php echo $this->lang->line('umb_e_details_do_clearance');?>" name="date_of_clearance" type="text" value="<?php echo $date_of_clearance;?>" >
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer"> <?php echo form_button(array('data-dismiss' => 'modal', 'type' => 'button', 'class' => 'btn btn-secondary', 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('umb_close'))); ?> <?php echo form_button(array('name' => 'hrastral_form', 'type' => 'submit', 'class' => $this->Umb_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('umb_update'))); ?> </div>
  <?php echo form_close(); ?> 
  <script type="text/javascript">
    $(document).ready(function(){
      $('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
      $('[data-plugin="select_hrm"]').select2({ width:'100%' });	
      Ladda.bind('button[type=submit]');
      $('.ee_date').bootstrapMaterialDatePicker({
        weekStart: 0,
        time: false,
        clearButton: false,
        format: 'YYYY-MM-DD'
      });
      $("#e_info_security_level").submit(function(e){
        e.preventDefault();
        var obj = $(this), action = obj.attr('name');
        $('.save').prop('disabled', true);
        $.ajax({
          type: "POST",
          url: e.target.action,
          data: obj.serialize()+"&is_ajax=17&data=e_info_security_level&type=e_info_security_level&form="+action,
          cache: false,
          success: function (JSON) {
            if (JSON.error != '') {
              toastr.error(JSON.error);
              $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
              $('.save').prop('disabled', false);
              Ladda.stopAll();
            } else {
              $('.edit-modal-data').modal('toggle');
              var eumb_table_security_level = $('#umb_table_security_level').dataTable({
                "bDestroy": true,
                "ajax": {
                  url : "<?php echo site_url("admin/karyawans/list_security_level") ?>/"+$('#user_id').val(),
                  type : 'GET'
                },
                "fnDrawCallback": function(settings){
                  $('[data-toggle="tooltip"]').tooltip();          
                }
              });
              eumb_table_security_level.api().ajax.reload(function(){ 
                toastr.success(JSON.result);
                $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
              }, true);
              $('.save').prop('disabled', false);
              Ladda.stopAll();
            }
          }
        });
      });
    });	
  </script>
<?php } else if(isset($_GET['jd']) && isset($_GET['field_id']) && $_GET['data']=='emp_kontrak' && $_GET['type']=='emp_kontrak'){?>
  <div class="modal-header"> 
    <?php echo form_button(array('aria-label' => 'Close', 'data-dismiss' => 'modal', 'type' => 'button', 'class' => 'close', 'content' => '<span aria-hidden="true">×</span>')); ?>
    <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_e_details_edit_kontrak');?></h4>
  </div>
  <?php $attributes = array('name' => 'e_info_kontrak', 'id' => 'e_info_kontrak', 'autocomplete' => 'off');?>
  <?php $hidden = array('u_basic_info' => 'UPDATE');?>
  <?php echo form_open('admin/karyawans/e_info_kontrak', $attributes, $hidden);?>
  <?php
  $edata_usr7 = array(
    'type'  => 'hidden',
    'id'  => 'user_id',
    'name'  => 'user_id',
    'value' => $karyawan_id,
  );
  echo form_input($edata_usr7);
  ?>
  <?php
  $edata_usr8 = array(
    'type'  => 'hidden',
    'id'  => 'e_field_id',
    'name'  => 'e_field_id',
    'value' => $kontrak_id,
  );
  echo form_input($edata_usr8);
  ?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="type_kontrak_id" class=""><?php echo $this->lang->line('umb_e_details_type_kontrak');?></label>
          <select class="form-control" name="type_kontrak_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_select_one');?>">
            <option value=""><?php echo $this->lang->line('umb_select_one');?></option>
            <?php foreach($all_types_kontrak as $type_kontrak) {?>
              <option value="<?php echo $type_kontrak->type_kontrak_id;?>" <?php if($type_kontrak->type_kontrak_id==$type_kontrak_id) {?> selected="selected" <?php } ?>> <?php echo $type_kontrak->name;?></option>
            <?php } ?>
          </select>
        </div>
        <div class="form-group">
          <label class="" for="from_date"><?php echo $this->lang->line('umb_e_details_frm_date');?></label>
          <input type="text" class="form-control e_cont_date" name="from_date" placeholder="<?php echo $this->lang->line('umb_e_details_frm_date');?>" readonly value="<?php echo $from_date;?>">
        </div>
        <div class="form-group">
          <label for="penunjukan_id" class=""><?php echo $this->lang->line('dashboard_penunjukan');?></label>
          <select class="form-control" name="penunjukan_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_select_one');?>">
            <option value=""><?php echo $this->lang->line('umb_select_one');?></option>
            <?php foreach($all_penunjukans as $penunjukan) {?>
              <?php if($penunjukan_id==$penunjukan->penunjukan_id):?>
                <option value="<?php echo $penunjukan->penunjukan_id?>" <?php if($penunjukan_id==$penunjukan->penunjukan_id):?> selected <?php endif;?>><?php echo $penunjukan->nama_penunjukan?></option>
              <?php endif;?>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="title" class=""><?php echo $this->lang->line('umb_e_details_kontrak_title');?></label>
          <input class="form-control" placeholder="<?php echo $this->lang->line('umb_e_details_kontrak_title');?>" name="title" type="text" value="<?php echo $title;?>" id="title">
        </div>
        <div class="form-group">
          <label for="to_date"><?php echo $this->lang->line('umb_e_details_to_date');?></label>
          <input type="text" class="form-control e_cont_date" name="to_date" placeholder="<?php echo $this->lang->line('umb_e_details_to_date');?>" readonly value="<?php echo $to_date;?>">
        </div>
        <div class="form-group">
          <label for="description"><?php echo $this->lang->line('umb_description');?></label>
          <textarea class="form-control" placeholder="<?php echo $this->lang->line('umb_description');?>" data-show-counter="1" data-limit="300" name="description" cols="30" rows="3" id="description"><?php echo $description;?></textarea>
          <span class="countdown"></span> 
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer"> <?php echo form_button(array('data-dismiss' => 'modal', 'type' => 'button', 'class' => 'btn btn-secondary', 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('umb_close'))); ?> <?php echo form_button(array('name' => 'hrastral_form', 'type' => 'submit', 'class' => $this->Umb_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('umb_update'))); ?> </div>
  <?php echo form_close(); ?> 
  <script type="text/javascript">
    $(document).ready(function(){
      $('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
      $('[data-plugin="select_hrm"]').select2({ width:'100%' });	
      Ladda.bind('button[type=submit]');
      $('.e_cont_date').bootstrapMaterialDatePicker({
        weekStart: 0,
        time: false,
        clearButton: false,
        format: 'YYYY-MM-DD'
      });			
      $("#e_info_kontrak").submit(function(e){
        e.preventDefault();
        var obj = $(this), action = obj.attr('name');
        $('.save').prop('disabled', true);
        $.ajax({
          type: "POST",
          url: e.target.action,
          data: obj.serialize()+"&is_ajax=20&data=e_info_kontrak&type=e_info_kontrak&form="+action,
          cache: false,
          success: function (JSON) {
            if (JSON.error != '') {
              toastr.error(JSON.error);
              $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
              $('.save').prop('disabled', false);
              Ladda.stopAll();
            } else {
              $('.edit-modal-data').modal('toggle');
              var umb_table_kontrak = $('#umb_table_kontrak').dataTable({
                "bDestroy": true,
                "ajax": {
                  url : "<?php echo site_url("admin/karyawans/contract") ?>/"+$('#user_id').val(),
                  type : 'GET'
                },
                "fnDrawCallback": function(settings){
                  $('[data-toggle="tooltip"]').tooltip();          
                }
              });
              umb_table_kontrak.api().ajax.reload(function(){ 
                toastr.success(JSON.result);
                $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
              }, true);
              $('.save').prop('disabled', false);
              Ladda.stopAll();
            }
          }
        });
      });
    });	
  </script>
<?php } else if(isset($_GET['jd']) && isset($_GET['field_id']) && $_GET['data']=='emp_cuti' && $_GET['type']=='emp_cuti'){
  ?>
  <div class="modal-header"> 
    <?php echo form_button(array('aria-label' => 'Close', 'data-dismiss' => 'modal', 'type' => 'button', 'class' => 'close', 'content' => '<span aria-hidden="true">×</span>')); ?>
    <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_e_details_edit_cuti');?></h4>
  </div>
  <?php $attributes = array('name' => 'e_info_cuti', 'id' => 'e_info_cuti', 'autocomplete' => 'off');?>
  <?php $hidden = array('u_basic_info' => 'UPDATE');?>
  <?php echo form_open('admin/karyawans/e_info_cuti', $attributes, $hidden);?>
  <?php
  $edata_usr7 = array(
    'type'  => 'hidden',
    'id'  => 'user_id',
    'name'  => 'user_id',
    'value' => $karyawan_id,
  );
  echo form_input($edata_usr7);
  ?>
  <?php
  $edata_usr8 = array(
    'type'  => 'hidden',
    'id'  => 'e_field_id',
    'name'  => 'e_field_id',
    'value' => $cuti_id,
  );
  echo form_input($edata_usr8);
  ?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-5">
        <div class="form-group">
          <label for="casual_cuti" class="control-label"><?php echo $this->lang->line('umb_e_details_casual_cuti');?></label>
          <input class="form-control" placeholder="<?php echo $this->lang->line('umb_e_details_casual_cuti');?>" name="casual_cuti" type="text" value="<?php echo $casual_cuti;?>">
        </div>
      </div>
      <div class="col-md-7">
        <div class="form-group">
          <label for="medical_cuti" class="control-label"><?php echo $this->lang->line('umb_e_details_medical_cuti');?></label>
          <input class="form-control" placeholder="<?php echo $this->lang->line('umb_e_details_medical_cuti');?>" name="medical_cuti" type="text" value="<?php echo $medical_cuti;?>">
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer"> <?php echo form_button(array('data-dismiss' => 'modal', 'type' => 'button', 'class' => 'btn btn-secondary', 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('umb_close'))); ?> <?php echo form_button(array('name' => 'hrastral_form', 'type' => 'submit', 'class' => $this->Umb_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('umb_update'))); ?> </div>
  <?php echo form_close(); ?> 
  <script type="text/javascript">
    $(document).ready(function(){
      $('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
      $('[data-plugin="select_hrm"]').select2({ width:'100%' });	
      $("#e_info_cuti").submit(function(e){
        e.preventDefault();
        var obj = $(this), action = obj.attr('name');
        $('.save').prop('disabled', true);
        $.ajax({
          type: "POST",
          url: e.target.action,
          data: obj.serialize()+"&is_ajax=23&data=e_info_cuti&type=e_info_cuti&form="+action,
          cache: false,
          success: function (JSON) {
            if (JSON.error != '') {
              toastr.error(JSON.error);
              $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
              $('.save').prop('disabled', false);
            } else {
              $('.edit-modal-data').modal('toggle');
              var umb_table_cuti = $('#umb_table_cuti').dataTable({
                "bDestroy": true,
                "ajax": {
                  url : "<?php echo site_url("admin/karyawans/cuti") ?>/"+$('#user_id').val(),
                  type : 'GET'
                },
                "fnDrawCallback": function(settings){
                  $('[data-toggle="tooltip"]').tooltip();          
                }
              });
              umb_table_cuti.api().ajax.reload(function(){ 
                toastr.success(JSON.result);
                $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
              }, true);
              $('.save').prop('disabled', false);
            }
          }
        });
      });
    });	
  </script>
<?php } else if(isset($_GET['jd']) && isset($_GET['field_id']) && $_GET['data']=='emp_shift' && $_GET['type']=='emp_shift'){
  ?>
  <div class="modal-header"> 
    <?php echo form_button(array('aria-label' => 'Close', 'data-dismiss' => 'modal', 'type' => 'button', 'class' => 'close', 'content' => '<span aria-hidden="true">×</span>')); ?>
    <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_e_details_edit_shift');?></h4>
  </div>
  <?php $attributes = array('name' => 'e_info_shift', 'id' => 'e_info_shift', 'autocomplete' => 'off');?>
  <?php $hidden = array('u_basic_info' => 'UPDATE');?>
  <?php echo form_open('admin/karyawans/e_info_shift', $attributes, $hidden);?>
  <?php
  $edata_usr7 = array(
    'type'  => 'hidden',
    'id'  => 'user_id',
    'name'  => 'user_id',
    'value' => $karyawan_id,
  );
  echo form_input($edata_usr7);
  ?>
  <?php
  $edata_usr8 = array(
    'type'  => 'hidden',
    'id'  => 'e_field_id',
    'name'  => 'e_field_id',
    'value' => $krywn_shift_id,
  );
  echo form_input($edata_usr8);
  ?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="from_date"><?php echo $this->lang->line('umb_e_details_frm_date');?></label>
          <input class="form-control es_date" readonly placeholder="<?php echo $this->lang->line('umb_e_details_frm_date');?>" name="from_date" type="text" value="<?php echo $from_date;?>">
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="to_date" class="control-label"><?php echo $this->lang->line('umb_e_details_to_date');?></label>
          <input class="form-control es_date" readonly placeholder="<?php echo $this->lang->line('umb_e_details_to_date');?>" name="to_date" type="text" value="<?php echo $to_date;?>">
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer"> <?php echo form_button(array('data-dismiss' => 'modal', 'type' => 'button', 'class' => 'btn btn-secondary', 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('umb_close'))); ?> <?php echo form_button(array('name' => 'hrastral_form', 'type' => 'submit', 'class' => $this->Umb_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('umb_update'))); ?> </div>
  <?php echo form_close(); ?> 
  <script type="text/javascript">
    $(document).ready(function(){	
      $('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
      $('[data-plugin="select_hrm"]').select2({ width:'100%' });
      $('.es_date').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat:'yy-mm-dd',
        yearRange: '1950:' + new Date().getFullYear()
      });
      $("#e_info_shift").submit(function(e){
        e.preventDefault();
        var obj = $(this), action = obj.attr('name');
        $('.save').prop('disabled', true);
        $.ajax({
          type: "POST",
          url: e.target.action,
          data: obj.serialize()+"&is_ajax=26&data=e_info_shift&type=e_info_shift&form="+action,
          cache: false,
          success: function (JSON) {
            if (JSON.error != '') {
              toastr.error(JSON.error);
              $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
              $('.save').prop('disabled', false);
            } else {
              $('.edit-modal-data').modal('toggle');
              var umb_table_shift = $('#umb_table_shift').dataTable({
                "bDestroy": true,
                "ajax": {
                  url : "<?php echo site_url("admin/karyawans/shift") ?>/"+$('#user_id').val(),
                  type : 'GET'
                },
                "fnDrawCallback": function(settings){
                  $('[data-toggle="tooltip"]').tooltip();          
                }
              });
              umb_table_shift.api().ajax.reload(function(){ 
                toastr.success(JSON.result);
                $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
              }, true);
              $('.save').prop('disabled', false);
            }
          }
        });
      });
    });	
  </script>
<?php } else if(isset($_GET['jd']) && isset($_GET['field_id']) && $_GET['data']=='emp_location' && $_GET['type']=='emp_location'){
  ?>
  <div class="modal-header"> 
    <?php echo form_button(array('aria-label' => 'Close', 'data-dismiss' => 'modal', 'type' => 'button', 'class' => 'close', 'content' => '<span aria-hidden="true">×</span>')); ?>
    <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_edit_location');?></h4>
  </div>
  <?php $attributes = array('name' => 'e_info_location', 'id' => 'e_info_location', 'autocomplete' => 'off');?>
  <?php $hidden = array('u_basic_info' => 'UPDATE');?>
  <?php echo form_open('admin/karyawans/e_info_location', $attributes, $hidden);?>
  <?php
  $edata_usr7 = array(
    'type'  => 'hidden',
    'id'  => 'user_id',
    'name'  => 'user_id',
    'value' => $karyawan_id,
  );
  echo form_input($edata_usr7);
  ?>
  <?php
  $edata_usr8 = array(
    'type'  => 'hidden',
    'id'  => 'e_field_id',
    'name'  => 'e_field_id',
    'value' => $location_kantor_id,
  );
  echo form_input($edata_usr8);
  ?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="from_date"><?php echo $this->lang->line('umb_e_details_frm_date');?></label>
          <input class="form-control es_date" readonly placeholder="<?php echo $this->lang->line('umb_e_details_frm_date');?>" name="from_date" type="text" value="<?php echo $from_date;?>">
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="to_date" class="control-label"><?php echo $this->lang->line('umb_e_details_to_date');?></label>
          <input class="form-control es_date" readonly placeholder="<?php echo $this->lang->line('umb_e_details_to_date');?>" name="to_date" type="text" value="<?php echo $to_date;?>">
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer"> <?php echo form_button(array('data-dismiss' => 'modal', 'type' => 'button', 'class' => 'btn btn-secondary', 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('umb_close'))); ?> <?php echo form_button(array('name' => 'hrastral_form', 'type' => 'submit', 'class' => $this->Umb_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('umb_update'))); ?> </div>
  <?php echo form_close(); ?> 
  <script type="text/javascript">
    $(document).ready(function(){
      Ladda.bind('button[type=submit]');
      $('.es_date').bootstrapMaterialDatePicker({
        weekStart: 0,
        time: false,
        clearButton: false,
        format: 'YYYY-MM-DD'
      });
      $("#e_info_location").submit(function(e){
        e.preventDefault();
        var obj = $(this), action = obj.attr('name');
        $('.save').prop('disabled', true);
        $.ajax({
          type: "POST",
          url: e.target.action,
          data: obj.serialize()+"&is_ajax=29&data=e_info_location&type=e_info_location&form="+action,
          cache: false,
          success: function (JSON) {
            if (JSON.error != '') {
              toastr.error(JSON.error);
              $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
              $('.save').prop('disabled', false);
              Ladda.stopAll();
            } else {
              $('.edit-modal-data').modal('toggle');
              var umb_table_location = $('#umb_table_location').dataTable({
                "bDestroy": true,
                "ajax": {
                  url : "<?php echo site_url("admin/karyawans/location") ?>/"+$('#user_id').val(),
                  type : 'GET'
                },
                "fnDrawCallback": function(settings){
                  $('[data-toggle="tooltip"]').tooltip();          
                }
              });
              umb_table_location.api().ajax.reload(function(){ 
                toastr.success(JSON.result);
                $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
              }, true);
              $('.save').prop('disabled', false);
              Ladda.stopAll();
            }
          }
        });
      });
    });	
  </script>
<?php } else if(isset($_GET['jd']) && isset($_GET['field_id']) && $_GET['data']=='e_gaji_tunjanagan' && $_GET['type']=='e_gaji_tunjanagan'){
  ?>
  <div class="modal-header"> 
    <?php echo form_button(array('aria-label' => 'Close', 'data-dismiss' => 'modal', 'type' => 'button', 'class' => 'close', 'content' => '<span aria-hidden="true">×</span>')); ?>
    <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_karyawan_edit_tunjanagan');?></h4>
  </div>
  <?php $attributes = array('name' => 'e_info_tunjanagan', 'id' => 'e_info_tunjanagan', 'autocomplete' => 'off');?>
  <?php $hidden = array('u_basic_info' => 'UPDATE');?>
  <?php echo form_open('admin/karyawans/info_update_tunjanagan', $attributes, $hidden);?>
  <?php
  $edata_usr7 = array(
    'type'  => 'hidden',
    'id'  => 'user_id',
    'name'  => 'user_id',
    'value' => $karyawan_id,
  );
  echo form_input($edata_usr7);
  ?>
  <?php
  $edata_usr8 = array(
    'type'  => 'hidden',
    'id'  => 'e_field_id',
    'name'  => 'e_field_id',
    'value' => $tunjanagan_id,
  );
  echo form_input($edata_usr8);
  ?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-3">
        <div class="form-group">
          <label for="is_tunjanagan_kena_pajak">
            <?php echo $this->lang->line('umb_gaji_tunjanagan_options');?>
            <i class="hrastral-asterisk">*</i>
          </label>
          <select name="is_tunjanagan_kena_pajak" id="is_tunjanagan_kena_pajak" class="form-control" data-plugin="select_hrm">
            <option value="0" <?php if($is_tunjanagan_kena_pajak==0):?> selected="selected" <?php endif;?>><?php echo $this->lang->line('umb_gaji_tunjanagan_todak_kena_pajak');?></option>
            <option value="1" <?php if($is_tunjanagan_kena_pajak==1):?> selected="selected" <?php endif;?>><?php echo $this->lang->line('umb_fully_kena_pajak');?></option>
            <option value="2" <?php if($is_tunjanagan_kena_pajak==2):?> selected="selected" <?php endif;?>><?php echo $this->lang->line('umb_partially_kena_pajak');?></option>
          </select>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label for="jumlah_option">
            <?php echo $this->lang->line('umb_jumlah_option');?>
            <i class="hrastral-asterisk">*</i>
          </label>
          <select name="jumlah_option" class="form-control" data-plugin="select_hrm">
            <option value="0" <?php if($jumlah_option==0):?> selected="selected" <?php endif;?>><?php echo $this->lang->line('umb_title_fixed_pajak');?></option>
            <option value="1" <?php if($jumlah_option==1):?> selected="selected" <?php endif;?>><?php echo $this->lang->line('umb_title_percent_pajak');?></option>
          </select>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label for="title_tunjanagan">
            <?php echo $this->lang->line('dashboard_umb_title');?>
            <i class="hrastral-asterisk">*</i>
          </label>
          <input class="form-control" placeholder="<?php echo $this->lang->line('dashboard_umb_title');?>" name="title_tunjanagan" type="text" value="<?php echo $title_tunjanagan;?>">
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <label for="jumlah_tunjanagan" class="control-label">
            <?php echo $this->lang->line('umb_jumlah');?>
            <i class="hrastral-asterisk">*</i>
          </label>
          <input class="form-control" placeholder="<?php echo $this->lang->line('umb_jumlah');?>" name="jumlah_tunjanagan" type="text" value="<?php echo $jumlah_tunjanagan;?>">
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer"> <?php echo form_button(array('data-dismiss' => 'modal', 'type' => 'button', 'class' => 'btn btn-secondary', 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('umb_close'))); ?> <?php echo form_button(array('name' => 'hrastral_form', 'type' => 'submit', 'class' => $this->Umb_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('umb_update'))); ?> </div>
  <?php echo form_close(); ?> 
  <script type="text/javascript">
    $(document).ready(function(){
      Ladda.bind('button[type=submit]');
      $('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
      $('[data-plugin="select_hrm"]').select2({ width:'100%' });
      $("#e_info_tunjanagan").submit(function(e){
        e.preventDefault();
        var obj = $(this), action = obj.attr('name');
        $('.save').prop('disabled', true);
        $.ajax({
          type: "POST",
          url: e.target.action,
          data: obj.serialize()+"&is_ajax=29&data=e_info_tunjanagan&type=e_info_tunjanagan&form="+action,
          cache: false,
          success: function (JSON) {
            if (JSON.error != '') {
              toastr.error(JSON.error);
              $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
              $('.save').prop('disabled', false);
              Ladda.stopAll();
            } else {
              $('.edit-modal-data').modal('toggle');
              var umb_table_all_tunjanagans = $('#umb_table_all_tunjanagans').dataTable({
                "bDestroy": true,
                "ajax": {
                  url : "<?php echo site_url("admin/karyawans/gaji_all_tunjanagans") ?>/"+$('#user_id').val(),
                  type : 'GET'
                },
                "fnDrawCallback": function(settings){
                  $('[data-toggle="tooltip"]').tooltip();          
                }
              });
              umb_table_all_tunjanagans.api().ajax.reload(function(){ 
                toastr.success(JSON.result);
                $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
              }, true);
              $('.save').prop('disabled', false);
              Ladda.stopAll();
            }
          }
        });
      });
    });	
  </script>
<?php } else if(isset($_GET['jd']) && isset($_GET['field_id']) && $_GET['data']=='e_gaji_pinjaman' && $_GET['type']=='e_gaji_pinjaman'){
  ?>
  <div class="modal-header"> 
    <?php echo form_button(array('aria-label' => 'Close', 'data-dismiss' => 'modal', 'type' => 'button', 'class' => 'close', 'content' => '<span aria-hidden="true">×</span>')); ?>
    <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_karyawan_edit_pinjaman_title');?></h4>
  </div>
  <?php $attributes = array('name' => 'e_gaji_pinjaman_info', 'id' => 'e_gaji_pinjaman_info', 'autocomplete' => 'off');?>
  <?php $hidden = array('u_basic_info' => 'UPDATE');?>
  <?php echo form_open('admin/karyawans/info_update_pinjaman', $attributes, $hidden);?>
  <?php
  $edata_usr7 = array(
    'type'  => 'hidden',
    'id'  => 'user_id',
    'name'  => 'user_id',
    'value' => $karyawan_id,
  );
  echo form_input($edata_usr7);
  ?>
  <?php
  $edata_usr8 = array(
    'type'  => 'hidden',
    'id'  => 'e_field_id',
    'name'  => 'e_field_id',
    'value' => $potongan_pinjaman_id,
  );
  echo form_input($edata_usr8);
  ?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="options_pinjaman">
                <?php echo $this->lang->line('umb_gaji_options_pinjaman');?>
                <i class="hrastral-asterisk">*</i>
              </label>
              <select name="options_pinjaman" id="options_pinjaman" class="form-control" data-plugin="select_hrm">
                <option value="1"<?php if($options_pinjaman==1):?> selected="selected" <?php endif;?>><?php echo $this->lang->line('umb_pinjaman_ssc_title');?></option>
                <option value="2"<?php if($options_pinjaman==2):?> selected="selected" <?php endif;?>><?php echo $this->lang->line('umb_pinjaman_hdmf_title');?></option>
                <option value="0"<?php if($options_pinjaman==0):?> selected="selected" <?php endif;?>><?php echo $this->lang->line('umb_pinjaman_other_sd_title');?></option>
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="month_year">
                <?php echo $this->lang->line('dashboard_umb_title');?>
                <i class="hrastral-asterisk">*</i>
              </label>
              <input class="form-control" placeholder="<?php echo $this->lang->line('dashboard_umb_title');?>" name="title_potongan_pinjaman" type="text" value="<?php echo $title_potongan_pinjaman;?>">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="edu_role">
                <?php echo $this->lang->line('umb_karyawan_angsuran_bulanan_title');?>
                <i class="hrastral-asterisk">*</i>
              </label>
              <input class="form-control" placeholder="<?php echo $this->lang->line('umb_karyawan_angsuran_bulanan_title');?>" name="angsuran_bulanan" type="text" id="m_angsuran_bulanan" value="<?php echo $angsuran_bulanan;?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="month_year">
                <?php echo $this->lang->line('umb_start_date');?>
                <i class="hrastral-asterisk">*</i>
              </label>
              <input class="form-control d_month_year" placeholder="<?php echo $this->lang->line('umb_start_date');?>" readonly="readonly" name="start_date" type="text" value="<?php echo $start_date;?>">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="end_date">
                <?php echo $this->lang->line('umb_end_date');?>
                <i class="hrastral-asterisk">*</i>
              </label>
              <input class="form-control d_month_year" readonly="readonly" placeholder="<?php echo $this->lang->line('umb_end_date');?>" name="end_date" type="text" value="<?php echo $end_date;?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="description"><?php echo $this->lang->line('umb_alasan');?></label>
              <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('umb_alasan');?>" name="reason" cols="30" rows="2" id="reason2"><?php echo $reason;?></textarea>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer"> <?php echo form_button(array('data-dismiss' => 'modal', 'type' => 'button', 'class' => 'btn btn-secondary', 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('umb_close'))); ?> <?php echo form_button(array('name' => 'hrastral_form', 'type' => 'submit', 'class' => $this->Umb_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('umb_update'))); ?> </div>
  <?php echo form_close(); ?> 
  <script type="text/javascript">
    $(document).ready(function(){
      $('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
      $('[data-plugin="select_hrm"]').select2({ width:'100%' });
      Ladda.bind('button[type=submit]');
      $('.d_month_year').bootstrapMaterialDatePicker({
        weekStart: 0,
        time: false,
        clearButton: false,
        format: 'YYYY-MM-DD'
      });				
      /* Update location info */
      $("#e_gaji_pinjaman_info").submit(function(e){
        e.preventDefault();
        var obj = $(this), action = obj.attr('name');
        $('.save').prop('disabled', true);
        $.ajax({
          type: "POST",
          url: e.target.action,
          data: obj.serialize()+"&is_ajax=29&data=pinjaman_info&type=pinjaman_info&form="+action,
          cache: false,
          success: function (JSON) {
            if (JSON.error != '') {
              toastr.error(JSON.error);
              $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
              $('.save').prop('disabled', false);
              Ladda.stopAll();
            } else {
              $('.edit-modal-data').modal('toggle');
              var umb_table_all_potongans = $('#umb_table_all_potongans').dataTable({
                "bDestroy": true,
                "ajax": {
                  url : "<?php echo site_url("admin/karyawans/gaji_all_potongans").'/'.$karyawan_id; ?>/",
                  type : 'GET'
                },
                "fnDrawCallback": function(settings){
                  $('[data-toggle="tooltip"]').tooltip();          
                }
              });
              umb_table_all_potongans.api().ajax.reload(function(){ 
                toastr.success(JSON.result);
              }, true);
              $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
              $('.save').prop('disabled', false);
              Ladda.stopAll();
            }
          }
        });
      });
    });	
  </script>
<?php } else if(isset($_GET['jd']) && isset($_GET['field_id']) && $_GET['data']=='krywn_info_lembur' && $_GET['type']=='krywn_info_lembur'){
  ?>
  <div class="modal-header"> 
    <?php echo form_button(array('aria-label' => 'Close', 'data-dismiss' => 'modal', 'type' => 'button', 'class' => 'close', 'content' => '<span aria-hidden="true">×</span>')); ?>
    <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_karyawan_edit_tunjanagan');?></h4>
  </div>
  <?php $attributes = array('name' => 'e_lembur_info', 'id' => 'e_lembur_info', 'autocomplete' => 'off');?>
  <?php $hidden = array('u_basic_info' => 'UPDATE');?>
  <?php echo form_open('admin/karyawans/update_info_lembur', $attributes, $hidden);?>
  <?php
  $edata_usr7 = array(
    'type'  => 'hidden',
    'id'  => 'user_id',
    'name'  => 'user_id',
    'value' => $karyawan_id,
  );
  echo form_input($edata_usr7);
  ?>
  <?php
  $edata_usr8 = array(
    'type'  => 'hidden',
    'id'  => 'e_field_id',
    'name'  => 'e_field_id',
    'value' => $gaji_lembur_id,
  );
  echo form_input($edata_usr8);
  ?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-3">
        <div class="form-group">
          <label for="type_lembur">
            <?php echo $this->lang->line('umb_karyawan_title_lembur');?>
            <i class="hrastral-asterisk">*</i>
          </label>
          <input class="form-control" placeholder="<?php echo $this->lang->line('umb_karyawan_title_lembur');?>" name="type_lembur" type="text" value="<?php echo $type_lembur;?>" id="type_lembur">
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label for="no_of_days">
            <?php echo $this->lang->line('umb_karyawan_lembur_no_of_days');?>
            <i class="hrastral-asterisk">*</i>
          </label>
          <input class="form-control" placeholder="<?php echo $this->lang->line('umb_karyawan_lembur_no_of_days');?>" name="no_of_days" type="text" value="<?php echo $no_of_days;?>" id="no_of_days">
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label for="jam_lembur">
            <?php echo $this->lang->line('umb_karyawan_jam_lembur');?>
            <i class="hrastral-asterisk">*</i>
          </label>
          <input class="form-control" placeholder="<?php echo $this->lang->line('umb_karyawan_jam_lembur');?>" name="jam_lembur" type="text" value="<?php echo $jam_lembur;?>" id="jam_lembur">
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label for="nilai_lembur">
            <?php echo $this->lang->line('umb_karyawan_nilai_lembur');?>
            <i class="hrastral-asterisk">*</i>
          </label>
          <input class="form-control" placeholder="<?php echo $this->lang->line('umb_karyawan_nilai_lembur');?>" name="nilai_lembur" type="text" value="<?php echo $nilai_lembur;?>" id="nilai_lembur">
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer"> <?php echo form_button(array('data-dismiss' => 'modal', 'type' => 'button', 'class' => 'btn btn-secondary', 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('umb_close'))); ?> <?php echo form_button(array('name' => 'hrastral_form', 'type' => 'submit', 'class' => $this->Umb_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('umb_update'))); ?> </div>
  <?php echo form_close(); ?> 
  <script type="text/javascript">
    $(document).ready(function(){
      Ladda.bind('button[type=submit]');
      $("#e_lembur_info").submit(function(e){
        e.preventDefault();
        var obj = $(this), action = obj.attr('name');
        $('.save').prop('disabled', true);
        $.ajax({
          type: "POST",
          url: e.target.action,
          data: obj.serialize()+"&is_ajax=29&data=e_lembur_info&type=e_lembur_info&form="+action,
          cache: false,
          success: function (JSON) {
            if (JSON.error != '') {
              toastr.error(JSON.error);
              $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
              $('.save').prop('disabled', false);
              Ladda.stopAll();
            } else {
              $('.edit-modal-data').modal('toggle');
              var umb_table_krywn_lembur = $('#umb_table_krywn_lembur').dataTable({
                "bDestroy": true,
                "ajax": {
                  url : "<?php echo site_url("admin/karyawans/gaji_lembur") ?>/"+$('#user_id').val(),
                  type : 'GET'
                },
                "fnDrawCallback": function(settings){
                  $('[data-toggle="tooltip"]').tooltip();          
                }
              });
              umb_table_krywn_lembur.api().ajax.reload(function(){ 
                toastr.success(JSON.result);
                $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
              }, true);
              $('.save').prop('disabled', false);
              Ladda.stopAll();
            }
          }
        });
      });
    });	
  </script>
<?php } else if(isset($_GET['jd']) && isset($_GET['field_id']) && $_GET['data']=='gaji_info_komissi' && $_GET['type']=='gaji_info_komissi'){
  ?>
  <div class="modal-header"> 
    <?php echo form_button(array('aria-label' => 'Close', 'data-dismiss' => 'modal', 'type' => 'button', 'class' => 'close', 'content' => '<span aria-hidden="true">×</span>')); ?>
    <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_karyawan_edit_tunjanagan');?></h4>
  </div>
  <?php $attributes = array('name' => 'e_gaji_info_komissi', 'id' => 'e_gaji_info_komissi', 'autocomplete' => 'off');?>
  <?php $hidden = array('u_basic_info' => 'UPDATE');?>
  <?php echo form_open('admin/karyawans/info_update_komissi', $attributes, $hidden);?>
  <?php
  $edata_usr7 = array(
    'type'  => 'hidden',
    'id'  => 'user_id',
    'name'  => 'user_id',
    'value' => $karyawan_id,
  );
  echo form_input($edata_usr7);
  ?>
  <?php
  $edata_usr8 = array(
    'type'  => 'hidden',
    'id'  => 'e_field_id',
    'name'  => 'e_field_id',
    'value' => $gaji_komissi_id,
  );
  echo form_input($edata_usr8);
  ?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-3">
        <div class="form-group">
          <label for="is_komisi_kena_pajak">
            <?php echo $this->lang->line('umb_gaji_opt_komisiions');?>
            <i class="hrastral-asterisk">*</i>
          </label>
          <select name="is_komisi_kena_pajak" class="form-control" data-plugin="select_hrm">
            <option value="0" <?php if($is_komisi_kena_pajak==0):?> selected="selected" <?php endif;?>><?php echo $this->lang->line('umb_gaji_tunjanagan_todak_kena_pajak');?></option>
            <option value="1" <?php if($is_komisi_kena_pajak==1):?> selected="selected" <?php endif;?>><?php echo $this->lang->line('umb_fully_kena_pajak');?></option>
            <option value="2" <?php if($is_komisi_kena_pajak==2):?> selected="selected" <?php endif;?>><?php echo $this->lang->line('umb_partially_kena_pajak');?></option>
          </select>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label for="jumlah_option"><?php echo $this->lang->line('umb_jumlah_option');?><i class="hrastral-asterisk">*</i></label>
          <select name="jumlah_option" class="form-control" data-plugin="select_hrm">
            <option value="0" <?php if($jumlah_option==0):?> selected="selected" <?php endif;?>><?php echo $this->lang->line('umb_title_fixed_pajak');?></option>
            <option value="1" <?php if($jumlah_option==1):?> selected="selected" <?php endif;?>><?php echo $this->lang->line('umb_title_percent_pajak');?></option>
          </select>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label for="title"><?php echo $this->lang->line('dashboard_umb_title');?><i class="hrastral-asterisk">*</i></label>
          <input class="form-control" placeholder="<?php echo $this->lang->line('dashboard_umb_title');?>" name="title" type="text" value="<?php echo $komisi_title;?>">
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <label for="jumlah" class="control-label">
            <?php echo $this->lang->line('umb_jumlah');?>
            <i class="hrastral-asterisk">*</i>
          </label>
          <input class="form-control" placeholder="<?php echo $this->lang->line('umb_jumlah');?>" name="jumlah" type="text" value="<?php echo $jumlah_komisi;?>">
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer"> <?php echo form_button(array('data-dismiss' => 'modal', 'type' => 'button', 'class' => 'btn btn-secondary', 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('umb_close'))); ?> <?php echo form_button(array('name' => 'hrastral_form', 'type' => 'submit', 'class' => $this->Umb_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('umb_update'))); ?> </div>
  <?php echo form_close(); ?> 
  <script type="text/javascript">
    $(document).ready(function(){
      Ladda.bind('button[type=submit]');
      $('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
      $('[data-plugin="select_hrm"]').select2({ width:'100%' });
      /* Update location info */
      $("#e_gaji_info_komissi").submit(function(e){
        e.preventDefault();
        var obj = $(this), action = obj.attr('name');
        $('.save').prop('disabled', true);
        $.ajax({
          type: "POST",
          url: e.target.action,
          data: obj.serialize()+"&is_ajax=29&data=e_gaji_info_komissi&type=e_gaji_info_komissi&form="+action,
          cache: false,
          success: function (JSON) {
            if (JSON.error != '') {
              toastr.error(JSON.error);
              $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
              $('.save').prop('disabled', false);
              Ladda.stopAll();
            } else {
              $('.edit-modal-data').modal('toggle');
              var umb_table_all_komissi = $('#umb_table_all_komissi').dataTable({
                "bDestroy": true,
                "ajax": {
                  url : "<?php echo site_url("admin/karyawans/gaji_all_komissi") ?>/"+$('#user_id').val(),
                  type : 'GET'
                },
                "fnDrawCallback": function(settings){
                  $('[data-toggle="tooltip"]').tooltip();          
                }
              });
              umb_table_all_komissi.api().ajax.reload(function(){ 
                toastr.success(JSON.result);
                $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
              }, true);
              $('.save').prop('disabled', false);
              Ladda.stopAll();
            }
          }
        });
      });
    });	
  </script>
<?php } else if(isset($_GET['jd']) && isset($_GET['field_id']) && $_GET['data']=='gaji_info_statutory_potongans' && $_GET['type']=='gaji_info_statutory_potongans'){
  ?>
  <div class="modal-header"> 
    <?php echo form_button(array('aria-label' => 'Close', 'data-dismiss' => 'modal', 'type' => 'button', 'class' => 'close', 'content' => '<span aria-hidden="true">×</span>')); ?>
    <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_karyawan_edit_tunjanagan');?></h4>
  </div>
  <?php $attributes = array('name' => 'e_gaji_info_statutory_potongans', 'id' => 'e_gaji_info_statutory_potongans', 'autocomplete' => 'off');?>
  <?php $hidden = array('u_basic_info' => 'UPDATE');?>
  <?php echo form_open('admin/karyawans/update_info_statutory_potongans', $attributes, $hidden);?>
  <?php
  $edata_usr7 = array(
    'type'  => 'hidden',
    'id'  => 'user_id',
    'name'  => 'user_id',
    'value' => $karyawan_id,
  );
  echo form_input($edata_usr7);
  ?>
  <?php
  $edata_usr8 = array(
    'type'  => 'hidden',
    'id'  => 'e_field_id',
    'name'  => 'e_field_id',
    'value' => $statutory_potongans_id,
  );
  echo form_input($edata_usr8);
  ?>
  <?php $system = $this->Umb_model->read_setting_info(1);?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <label for="statutory_options">
            <?php echo $this->lang->line('umb_gaji_sd_options');?>
            <i class="hrastral-asterisk">*</i>
          </label>
          <select name="statutory_options" class="form-control" data-plugin="select_hrm">
            <option value="0" <?php if($statutory_options==0):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('umb_title_fixed_pajak');?></option>
            <option value="1" <?php if($statutory_options==1):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('umb_title_percent_pajak');?></option>
          </select>
        </div>
      </div>
      <div class="col-md-5">
        <div class="form-group">
          <label for="title">
            <?php echo $this->lang->line('dashboard_umb_title');?>
            <i class="hrastral-asterisk">*</i>
          </label>
          <input class="form-control" placeholder="<?php echo $this->lang->line('dashboard_umb_title');?>" name="title" type="text" value="<?php echo $title_potongan;?>">
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label for="jumlah" class="control-label">
            <?php echo $this->lang->line('umb_jumlah');?>
            <i class="hrastral-asterisk">*</i>
          </label>
          <input class="form-control" placeholder="<?php echo $this->lang->line('umb_jumlah');?>" name="jumlah" type="text" value="<?php echo $jumlah_potongan;?>">
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer"> <?php echo form_button(array('data-dismiss' => 'modal', 'type' => 'button', 'class' => 'btn btn-secondary', 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('umb_close'))); ?> <?php echo form_button(array('name' => 'hrastral_form', 'type' => 'submit', 'class' => $this->Umb_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('umb_update'))); ?> </div>
  <?php echo form_close(); ?> 
  <script type="text/javascript">
    $(document).ready(function(){
      Ladda.bind('button[type=submit]');
      $('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
      $('[data-plugin="select_hrm"]').select2({ width:'100%' });
      /* Update location info */
      $("#e_gaji_info_statutory_potongans").submit(function(e){
        e.preventDefault();
        var obj = $(this), action = obj.attr('name');
        $('.save').prop('disabled', true);
        $.ajax({
          type: "POST",
          url: e.target.action,
          data: obj.serialize()+"&is_ajax=29&data=e_gaji_info_statutory_potongans&type=e_gaji_info_statutory_potongans&form="+action,
          cache: false,
          success: function (JSON) {
            if (JSON.error != '') {
              toastr.error(JSON.error);
              $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
              $('.save').prop('disabled', false);
              Ladda.stopAll();
            } else {
              $('.edit-modal-data').modal('toggle');
              var umb_table_all_statutory_potongans = $('#umb_table_all_statutory_potongans').dataTable({
                "bDestroy": true,
                "ajax": {
                  url : "<?php echo site_url("admin/karyawans/gaji_all_statutory_potongans") ?>/"+$('#user_id').val(),
                  type : 'GET'
                },
                "fnDrawCallback": function(settings){
                  $('[data-toggle="tooltip"]').tooltip();          
                }
              });
              umb_table_all_statutory_potongans.api().ajax.reload(function(){ 
                toastr.success(JSON.result);
                $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
              }, true);
              $('.save').prop('disabled', false);
              Ladda.stopAll();
            }
          }
        });
      });
    });	
  </script>
<?php } else if(isset($_GET['jd']) && isset($_GET['field_id']) && $_GET['data']=='gaji_info_pembayarans_lainnya' && $_GET['type']=='gaji_info_pembayarans_lainnya'){
  ?>
  <div class="modal-header"> 
    <?php echo form_button(array('aria-label' => 'Close', 'data-dismiss' => 'modal', 'type' => 'button', 'class' => 'close', 'content' => '<span aria-hidden="true">×</span>')); ?>
    <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_edit').' '.$this->lang->line('umb_karyawan_set_pembayaran_lainnya');?></h4>
  </div>
  <?php $attributes = array('name' => 'e_gaji_info_pembayarans_lainnya', 'id' => 'e_gaji_info_pembayarans_lainnya', 'autocomplete' => 'off');?>
  <?php $hidden = array('u_basic_info' => 'UPDATE');?>
  <?php echo form_open('admin/karyawans/update_info_pembayaran_lainnya', $attributes, $hidden);?>
  <?php
  $edata_usr7 = array(
    'type'  => 'hidden',
    'id'  => 'user_id',
    'name'  => 'user_id',
    'value' => $karyawan_id,
  );
  echo form_input($edata_usr7);
  ?>
  <?php
  $edata_usr8 = array(
    'type'  => 'hidden',
    'id'  => 'e_field_id',
    'name'  => 'e_field_id',
    'value' => $pembayarans_lainnya_id,
  );
  echo form_input($edata_usr8);
  ?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-3">
        <div class="form-group">
          <label for="ia_pembayaranlainnya_kena_pajak">
            <?php echo $this->lang->line('umb_gaji_otherpayment_options');?>
            <i class="hrastral-asterisk">*</i>
          </label>
          <select name="ia_pembayaranlainnya_kena_pajak" class="form-control" data-plugin="select_hrm">
            <option value="0" <?php if($ia_pembayaranlainnya_kena_pajak==0):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('umb_gaji_tunjanagan_todak_kena_pajak');?></option>
            <option value="1" <?php if($ia_pembayaranlainnya_kena_pajak==1):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('umb_fully_kena_pajak');?></option>
            <option value="2" <?php if($ia_pembayaranlainnya_kena_pajak==2):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('umb_partially_kena_pajak');?></option>
          </select>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label for="jumlah_option">
            <?php echo $this->lang->line('umb_jumlah_option');?>
            <i class="hrastral-asterisk">*</i>
          </label>
          <select name="jumlah_option" class="form-control" data-plugin="select_hrm">
            <option value="0" <?php if($jumlah_option==0):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('umb_title_fixed_pajak');?></option>
            <option value="1" <?php if($jumlah_option==1):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('umb_title_percent_pajak');?></option>
          </select>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label for="title">
            <?php echo $this->lang->line('dashboard_umb_title');?>
            <i class="hrastral-asterisk">*</i>
          </label>
          <input class="form-control" placeholder="<?php echo $this->lang->line('dashboard_umb_title');?>" name="title" type="text" value="<?php echo $title_pembayarans;?>">
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <label for="jumlah" class="control-label">
            <?php echo $this->lang->line('umb_jumlah');?>
            <i class="hrastral-asterisk">*</i>
          </label>
          <input class="form-control" placeholder="<?php echo $this->lang->line('umb_jumlah');?>" name="jumlah" type="text" value="<?php echo $jumlah_pembayarans;?>">
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer"> <?php echo form_button(array('data-dismiss' => 'modal', 'type' => 'button', 'class' => 'btn btn-secondary', 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('umb_close'))); ?> <?php echo form_button(array('name' => 'hrastral_form', 'type' => 'submit', 'class' => $this->Umb_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('umb_update'))); ?> </div>
  <?php echo form_close(); ?> 
  <script type="text/javascript">
    $(document).ready(function(){	
      Ladda.bind('button[type=submit]');
      $('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
      $('[data-plugin="select_hrm"]').select2({ width:'100%' });
      $("#e_gaji_info_pembayarans_lainnya").submit(function(e){
        e.preventDefault();
        var obj = $(this), action = obj.attr('name');
        $('.save').prop('disabled', true);
        $.ajax({
          type: "POST",
          url: e.target.action,
          data: obj.serialize()+"&is_ajax=29&data=e_gaji_info_pembayarans_lainnya&type=e_gaji_info_pembayarans_lainnya&form="+action,
          cache: false,
          success: function (JSON) {
            if (JSON.error != '') {
              toastr.error(JSON.error);
              $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
              $('.save').prop('disabled', false);
              Ladda.stopAll();
            } else {
              $('.edit-modal-data').modal('toggle');
              var umb_table_all_pembayarans_lainnya = $('#umb_table_all_pembayarans_lainnya').dataTable({
                "bDestroy": true,
                "ajax": {
                  url : "<?php echo site_url("admin/karyawans/gaji_all_pembayarans_lainnya") ?>/"+$('#user_id').val(),
                  type : 'GET'
                },
                "fnDrawCallback": function(settings){
                  $('[data-toggle="tooltip"]').tooltip();          
                }
              });
              umb_table_all_pembayarans_lainnya.api().ajax.reload(function(){ 
                toastr.success(JSON.result);
                $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
              }, true);
              $('.save').prop('disabled', false);
              Ladda.stopAll();
            }
          }
        });
      });
    });	
  </script>
<?php }
?>
