<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['peringatan_id']) && $_GET['data']=='peringatan'){
  ?>
  <?php $session = $this->session->userdata('username');?>
  <?php $user_info = $this->Umb_model->read_user_info($session['user_id']);?>
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
    <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_peringatan_edit');?></h4>
  </div>
  <?php $attributes = array('name' => 'edit_peringatan', 'id' => 'edit_peringatan', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
  <?php $hidden = array('_method' => 'EDIT', '_token' => $peringatan_id, 'ext_name' => $peringatan_id);?>
  <?php echo form_open('admin/peringatan/update/'.$peringatan_id, $attributes, $hidden);?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-6">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="type"><?php echo $this->lang->line('umb_type_peringatan');?></label>
              <select class="select2" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_type_peringatan');?>" name="type">
                <option value=""></option>
                <?php foreach($all_types_peringatan as $type_peringatan) {?>
                  <option value="<?php echo $type_peringatan->type_peringatan_id?>" <?php if($type_peringatan->type_peringatan_id==$type_peringatan_id):?> selected="selected"<?php endif;?>><?php echo $type_peringatan->type;?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="subject"><?php echo $this->lang->line('umb_subject');?></label>
              <input class="form-control" placeholder="<?php echo $this->lang->line('umb_subject');?>" name="subject" type="text" value="<?php echo $subject;?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="tanggal_peringatan"><?php echo $this->lang->line('umb_tanggal_peringatan');?></label>
              <input class="form-control d_date" placeholder="<?php echo $this->lang->line('umb_tanggal_peringatan');?>" readonly name="tanggal_peringatan" type="text" value="<?php echo $tanggal_peringatan;?>">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="status"><?php echo $this->lang->line('dashboard_umb_status');?></label>
              <select name="status" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('dashboard_umb_status');?>">
                <option value="0" <?php if($status=='0'):?> selected <?php endif; ?>><?php echo $this->lang->line('umb_pending');?></option>
                <option value="1" <?php if($status=='1'):?> selected <?php endif; ?>><?php echo $this->lang->line('umb_accepted');?></option>
                <option value="2" <?php if($status=='2'):?> selected <?php endif; ?>><?php echo $this->lang->line('umb_rejected');?></option>
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
     
     jQuery("#ajx_perusahaan").change(function(){
      jQuery.get(base_url+"/get_karyawans/"+jQuery(this).val(), function(data, status){
       jQuery('#ajx_karyawan').html(data);
     });
      jQuery.get(base_url+"/get_peringatan_karyawans/"+jQuery(this).val(), function(data, status){
       jQuery('#peringatan_ajx_karyawan').html(data);
     });
    });
     
     Ladda.bind('button[type=submit]');
     
     $('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
     $('[data-plugin="select_hrm"]').select2({ width:'100%' });	 
     
	//$('#description2').trumbowyg();	
	
	$('.d_date').bootstrapMaterialDatePicker({
		weekStart: 0,
		time: false,
		clearButton: false,
		format: 'YYYY-MM-DD'
	});
	
	/* Edit data */
	$("#edit_peringatan").submit(function(e){
   e.preventDefault();
   var obj = $(this), action = obj.attr('name');
   $('.save').prop('disabled', true);
   $.ajax({
     type: "POST",
     url: e.target.action,
     data: obj.serialize()+"&is_ajax=1&edit_type=warning&form="+action,
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
            url : "<?php echo site_url("admin/peringatan/list_peringatan") ?>",
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
					$('.edit-modal-data').modal('toggle');
					$('.save').prop('disabled', false);
					Ladda.stopAll();
				}
			}
		});
 });
});	
</script>
<?php } else if(isset($_GET['jd']) && isset($_GET['peringatan_id']) && $_GET['data']=='view_peringatan'){
  ?>
  <form class="m-b-1">
    <div class="modal-body">
      <p class="text-center text-big mb-4"><strong><?php echo $this->lang->line('umb_peringatan_view');?></strong></p>
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
            <tr>
              <th><?php echo $this->lang->line('umb_peringatan_ke');?></th>
              <td style="display: table-cell;"><?php foreach($all_karyawans as $karyawan) {?>
                <?php if($peringatan_ke==$karyawan->user_id):?>
                  <?php echo $karyawan->first_name.' '.$karyawan->last_name;?>
                <?php endif;?>
                <?php } ?></td>
              </tr>
              <tr>
                <th><?php echo $this->lang->line('umb_type_peringatan');?></th>
                <td style="display: table-cell;"><?php foreach($all_types_peringatan as $type_peringatan) {?>
                  <?php if($type_peringatan_id==$type_peringatan->type_peringatan_id):?>
                    <?php echo $type_peringatan->type;?>
                  <?php endif;?>
                  <?php } ?></td>
                </tr>
                <tr>
                  <th><?php echo $this->lang->line('umb_subject');?></th>
                  <td style="display: table-cell;"><?php echo $subject;?></td>
                </tr>
                <tr>
                  <th><?php echo $this->lang->line('umb_peringatan_oleh');?></th>
                  <td style="display: table-cell;"><?php foreach($all_karyawans as $karyawan) {?>
                    <?php if($peringatan_oleh==$karyawan->user_id):?>
                      <?php echo $karyawan->first_name.' '.$karyawan->last_name;?>
                    <?php endif;?>
                    <?php } ?></td>
                  </tr>
                  <tr>
                    <th><?php echo $this->lang->line('umb_tanggal_peringatan');?></th>
                    <td style="display: table-cell;"><?php echo $this->Umb_model->set_date_format($tanggal_peringatan);?></td>
                  </tr>
                  <tr>
                    <th><?php echo $this->lang->line('dashboard_umb_status');?></th>
                    <td style="display: table-cell;"><?php if($status=='0'): $w_status = $this->lang->line('umb_pending');?>
                  <?php endif; ?>
                  <?php if($status=='1'): $w_status = $this->lang->line('umb_accepted');?>
                  <?php endif; ?>
                  <?php if($status=='2'): $w_status = $this->lang->line('umb_rejected');?>
                  <?php endif; ?>
                  <?php echo $w_status;?></td>
                </tr>
                <tr>
                  <th><?php echo $this->lang->line('umb_attachment');?></th>
                  <td style="display: table-cell;"><?php if($attachment!='' && $attachment!='no file') {?>
                    <img src="<?php echo base_url().'uploads/warning/'.$attachment;?>" width="70px" id="u_file">&nbsp; <a href="<?php echo site_url()?>admin/download?type=warning&filename=<?php echo $attachment;?>"><?php echo $this->lang->line('umb_download');?></a>
                    <?php } ?></td>
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
          <?php }
          ?>
