<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['trainer_id']) && $_GET['data']=='trainer'){
  ?>
  <?php $session = $this->session->userdata('username');?>
  <?php $user_info = $this->Umb_model->read_user_info($session['user_id']);?>
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
    <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_edit_trainer');?></h4>
  </div>
  <?php $attributes = array('name' => 'edit_trainer', 'id' => 'edit_trainer', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
  <?php $hidden = array('_method' => 'EDIT', '_token' => $trainer_id, 'ext_name' => $trainer_id);?>
  <?php echo form_open('admin/trainers/update/'.$trainer_id, $attributes, $hidden);?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-6">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="first_name"><?php echo $this->lang->line('umb_karyawan_first_name');?></label>
              <input class="form-control" placeholder="<?php echo $this->lang->line('umb_karyawan_first_name');?>" name="first_name" type="text" value="<?php echo $first_name;?>">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="last_name" class="control-label"><?php echo $this->lang->line('umb_karyawan_last_name');?></label>
              <input class="form-control" placeholder="<?php echo $this->lang->line('umb_karyawan_last_name');?>" name="last_name" type="text" value="<?php echo $last_name;?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="nomor_kontak"><?php echo $this->lang->line('umb_nomor_kontak');?></label>
              <input class="form-control" placeholder="<?php echo $this->lang->line('umb_nomor_kontak');?>" name="nomor_kontak" type="text" value="<?php echo $nomor_kontak;?>">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="email" class="control-label"><?php echo $this->lang->line('dashboard_email');?></label>
              <input class="form-control" placeholder="<?php echo $this->lang->line('dashboard_email');?>" name="email" type="text" value="<?php echo $email;?>">
            </div>
          </div>
        </div>
        <?php if($user_info[0]->user_role_id==1){ ?>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="penunjukan"><?php echo $this->lang->line('module_title_perusahaan');?></label>
                <select class="form-control" name="perusahaan" id="aj_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_title_perusahaan');?>">
                  <option value=""></option>
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
                <label for="penunjukan"><?php echo $this->lang->line('module_title_perusahaan');?></label>
                <select class="form-control" name="perusahaan" id="aj_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_title_perusahaan');?>">
                  <option value=""></option>
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
      </div>
      <div class="col-md-6">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="expertise"><?php echo $this->lang->line('umb_expertise');?></label>
              <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('umb_expertise');?>" name="expertise" cols="30" rows="5" id="expertise2"><?php echo $expertise;?></textarea>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="form-group">
      <label for="alamat"><?php echo $this->lang->line('umb_alamat');?></label>
      <textarea class="form-control" placeholder="<?php echo $this->lang->line('umb_alamat');?>" name="alamat" cols="30" rows="3" id="alamat"><?php echo $alamat;?></textarea>
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
     
	//$('#expertise2').trumbowyg();
	/* Edit data */
	$("#edit_trainer").submit(function(e){
   e.preventDefault();
   var obj = $(this), action = obj.attr('name');
   $('.save').prop('disabled', true);
   $.ajax({
     type: "POST",
     url: e.target.action,
     data: obj.serialize()+"&is_ajax=1&edit_type=trainer&form="+action,
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
							url : "<?php echo site_url("admin/trainers/list_trainer") ?>",
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
<?php } else if(isset($_GET['jd']) && isset($_GET['trainer_id']) && $_GET['data']=='view_trainer'){
  ?>
  <form class="m-b-1">
    <div class="modal-body">
      <p class="text-center text-big mb-4"><strong><?php echo $this->lang->line('umb_view_trainer');?></strong></p>
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
              <th><?php echo $this->lang->line('umb_karyawan_first_name');?></th>
              <td style="display: table-cell;"><?php echo $first_name;?></td>
            </tr>
            <tr>
              <th><?php echo $this->lang->line('umb_karyawan_last_name');?></th>
              <td style="display: table-cell;"><?php echo $last_name;?></td>
            </tr>
            <tr>
              <th><?php echo $this->lang->line('umb_nomor_kontak');?></th>
              <td style="display: table-cell;"><?php echo $nomor_kontak;?></td>
            </tr>
            <tr>
              <th><?php echo $this->lang->line('dashboard_email');?></th>
              <td style="display: table-cell;"><?php echo $email;?></td>
            </tr>
            <tr>
              <th><?php echo $this->lang->line('umb_expertise');?></th>
              <td style="display: table-cell;"><?php echo html_entity_decode($expertise);?></td>
            </tr>
            <tr>
              <th><?php echo $this->lang->line('umb_alamat');?></th>
              <td style="display: table-cell;"><?php echo html_entity_decode($alamat);?></td>
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
