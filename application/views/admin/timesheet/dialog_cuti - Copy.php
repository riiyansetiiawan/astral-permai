<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['cuti_id']) && $_GET['data']=='cuti'){
  ?>

  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
    <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_edit_cuti');?></h4>
  </div>
  <?php $attributes = array('name' => 'edit_cuti', 'id' => 'edit_cuti', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
  <?php $hidden = array('_method' => 'EDIT', '_token' => $cuti_id, 'ext_name' => $cuti_id);?>
  <?php echo form_open('admin/timesheet/edit_cuti/'.$cuti_id, $attributes, $hidden);?>
  <?php $session = $this->session->userdata('username');?>
  <?php $user = $this->Umb_model->read_info_karyawan($session['user_id']);?>
  <?php $kategoris_cuti = $user[0]->kategoris_cuti;?>
  <?php $leaave_cat = get_kategori_karyawan_cuti($kategoris_cuti,$session['user_id']);?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="type_cuti" class="control-label"><?php echo $this->lang->line('umb_type_cuti');?></label>
          <select class="form-control" name="type_cuti" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_type_cuti');?>">
            <option value=""></option>
            <?php foreach($leaave_cat as $type) {?>
              <option value="<?php echo $type->type_cuti_id?>" <?php if($type->type_cuti_id==$type_cuti_id):?> selected <?php endif;?>> <?php echo $type->type_name;?></option>
            <?php } ?>
          </select>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="start_date"><?php echo $this->lang->line('umb_start_date');?></label>
              <input class="form-control e_date" placeholder="<?php echo $this->lang->line('umb_start_date');?>" readonly="true" name="start_date" type="text" value="<?php echo $from_date;?>">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="end_date"><?php echo $this->lang->line('umb_end_date');?></label>
              <input class="form-control e_date" placeholder="<?php echo $this->lang->line('umb_end_date');?>" readonly="true" name="end_date" type="text" value="<?php echo $to_date;?>">
            </div>
          </div>
        </div>
        <?php $role_resources_ids = $this->Umb_model->user_role_resource();
        if(!in_array('383',$role_resources_ids)) { ?>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="first_name"><?php echo $this->lang->line('left_perusahaan');?></label>
                <select class="form-control" name="perusahaan_id" id="ajx_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_perusahaan');?>">
                  <option value=""></option>
                  <?php foreach($get_all_perusahaans as $perusahaan) {?>
                    <option value="<?php echo $perusahaan->perusahaan_id?>" <?php if($perusahaan->perusahaan_id==$perusahaan_id):?> selected <?php endif;?>><?php echo $perusahaan->name?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group" id="ajx_karyawan">
               <?php $result = $this->Department_model->ajax_info_perusahaan_karyawan($perusahaan_id);?>
               <label for="karyawans" class="control-label"><?php echo $this->lang->line('umb_karyawan');?></label>
               <select class="form-control" name="karyawan_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_choose_an_karyawan');?>">
                <option value=""></option>
                <?php foreach($result as $karyawan) {?>
                  <option value="<?php echo $karyawan->user_id?>" <?php if($karyawan->user_id==$karyawan_id):?> selected <?php endif;?>> <?php echo $karyawan->first_name.' '.$karyawan->last_name;?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
      <?php } else {?>
        
        <input type="hidden" name="karyawan_id" id="karyawan_id" value="<?php echo $session['user_id'];?>" />
        <input type="hidden" name="perusahaan_id" id="perusahaan_id" value="<?php echo $user[0]->perusahaan_id;?>" />
      <?php } ?>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="description"><?php echo $this->lang->line('umb_keterangan');?></label>
        <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('umb_keterangan');?>" name="remarks" rows="5"><?php echo $remarks;?></textarea>
      </div>
    </div>
  </div>
  <div class="form-group">
    <label for="reason"><?php echo $this->lang->line('umb_alasan_cuti');?></label>
    <textarea class="form-control" placeholder="<?php echo $this->lang->line('umb_alasan_cuti');?>" name="reason" cols="30" rows="3" id="reason"><?php echo $reason;?></textarea>
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
   jQuery("#ajx_perusahaan").change(function(){
    jQuery.get(base_url+"/get_update_karyawans/"+jQuery(this).val(), function(data, status){
     jQuery('#ajx_karyawan').html(data);
   });
  });
   $('#remarks2').trumbowyg();	
	// Date
	$('.e_date').datepicker({
   changeMonth: true,
   changeYear: true,
   dateFormat:'yy-mm-dd',
   yearRange: '1900:' + (new Date().getFullYear() + 15),
 });
	/* Edit*/
	$("#edit_cuti").submit(function(e){
   
   e.preventDefault();
   var obj = $(this), action = obj.attr('name');
   $('.save').prop('disabled', true);
   $.ajax({
     type: "POST",
     url: e.target.action,
     data: obj.serialize()+"&is_ajax=2&edit_type=cuti&form="+action,
     cache: false,
     success: function (JSON) {
      if (JSON.error != '') {
       toastr.error(JSON.error);
       $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
       $('.save').prop('disabled', false);
     } else {
       $('.edit-modal-data').modal('toggle');
       var umb_table = $('#umb_table').dataTable({
        "bDestroy": true,
        "ajax": {
         url : "<?php echo site_url("admin/timesheet/list_cuti") ?>",
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
       $('.save').prop('disabled', false);
     }
   }
 });
 });
});	
</script>
<?php } else if(isset($_GET['jd']) && isset($_GET['cuti_id']) && $_GET['data']=='view_cuti'){
  ?>
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
    <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_view');?> <?php echo $this->lang->line('left_cuti');?></h4>
  </div>
  <form class="m-b-1">
    <div class="modal-body">
      <table class="footable-details table table-striped table-hover toggle-circle">
        <tbody>
          <tr>
            <th><?php echo $this->lang->line('module_title_perusahaan');?></th>
            <td style="display: table-cell;"><?php foreach($get_all_perusahaans as $perusahaan) {?>
              <?php if($perusahaan_id==$perusahaan->perusahaan_id):?>
                <?php echo $perusahaan->name;?>
              <?php endif;?>
              <?php } ?></td>
            </tr>
            <?php $karyawan = $this->Umb_model->read_user_info($karyawan_id); ?>
            <?php if(!is_null($karyawan)):?><?php $eName = $karyawan[0]->first_name. ' '.$karyawan[0]->last_name;?>
             <?php else:?><?php $eName='';?><?php endif;?>
             <tr>
              <th><?php echo $this->lang->line('umb_karyawan');?></th>
              <td style="display: table-cell;"><?php echo $eName;?></td>
            </tr>    
            <tr>
              <th><?php echo $this->lang->line('umb_type_cuti');?></th>
              <td style="display: table-cell;"><?php foreach($all_types_cuti as $type) {?>
                <?php if($type->type_cuti_id==$type_cuti_id):?> <?php echo $type->type_name;?> <?php endif;?>
                <?php } ?></td>
              </tr>
              <tr>
                <th><?php echo $this->lang->line('umb_start_date');?></th>
                <td style="display: table-cell;"><?php echo $this->Umb_model->set_date_format($from_date);?></td>
              </tr>
              <tr>
                <th><?php echo $this->lang->line('umb_end_date');?></th>
                <td style="display: table-cell;"><?php echo $this->Umb_model->set_date_format($to_date);?></td>
              </tr>
              <tr>
                <th><?php echo $this->lang->line('umb_keterangan');?></th>
                <td style="display: table-cell;"><?php echo html_entity_decode($remarks);?></td>
              </tr>
              <tr>
                <th><?php echo $this->lang->line('umb_alasan_cuti');?></th>
                <td style="display: table-cell;"><?php echo html_entity_decode($reason);?></td>
              </tr>
              <?php if($status=='1'):?> <?php $status_lv = $this->lang->line('umb_pending');?> <?php endif; ?>
              <?php if($status=='2'):?> <?php $status_lv = $this->lang->line('umb_approved');?> <?php endif; ?>
              <?php if($status=='3'):?> <?php $status_lv = $this->lang->line('umb_rejected');?> <?php endif; ?>
              <tr>
                <th><?php echo $this->lang->line('dashboard_umb_status');?></th>
                <td style="display: table-cell;"><?php echo $status_lv;?></td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('umb_close');?></button>
        </div>
        <?php echo form_close(); ?>
      <?php }?>
