<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['user_id']) && $_GET['data']=='employer'){
?>

<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><i class="icon-pencil7"></i> <?php echo $this->lang->line('umb_edit_perusahaan');?></h4>
</div>
<?php $attributes = array('name' => 'edit_employer', 'id' => 'edit_employer', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $_GET['user_id'], 'ext_name' => $nama_perusahaan);?>
<?php echo form_open_multipart('admin/post_pekerjaan/update_employer/'.$user_id, $attributes, $hidden);?>
  <div class="modal-body">
    <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="nama_perusahaan"><?php echo $this->lang->line('umb_nama_perusahaan');?></label>
        <input class="form-control" placeholder="<?php echo $this->lang->line('umb_nama_perusahaan');?>" name="nama_perusahaan" type="text" value="<?php echo $nama_perusahaan;?>">
      </div>
      <div class="form-group">
        <div class="row">
          <div class="col-md-6">
            <label for="email"><?php echo $this->lang->line('umb_email');?></label>
            <input class="form-control" placeholder="<?php echo $this->lang->line('umb_email');?>" name="email" type="email" value="<?php echo $email;?>">
          </div>
          <div class="col-md-6">
            <label for="nomor_kontak"><?php echo $this->lang->line('umb_nomor_kontak');?></label>
            <input class="form-control" placeholder="<?php echo $this->lang->line('umb_nomor_kontak');?>" name="nomor_kontak" type="text" value="<?php echo $nomor_kontak;?>">
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
            <label for="email"><?php echo $this->lang->line('umb_karyawan_first_name');?></label>
            <input class="form-control" placeholder="<?php echo $this->lang->line('umb_karyawan_first_name');?>" name="first_name" type="text" value="<?php echo $first_name;?>">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
            <label for="nama_trading"><?php echo $this->lang->line('umb_karyawan_last_name');?></label>
            <input class="form-control" placeholder="<?php echo $this->lang->line('umb_karyawan_last_name');?>" name="last_name" type="text" value="<?php echo $last_name;?>">
            </div>
          </div>
        </div>
        <div class="row">
        <div class="col-md-6">
            <div class="form-group">
              <label for="is_active" class="control-label"><?php echo $this->lang->line('umb_karyawans_active');?></label>
              <select class="form-control" name="is_active" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_karyawans_active');?>">
                <option value="1" <?php if($is_active==1):?> selected="selected" <?php endif;?>><?php echo $this->lang->line('umb_yes');?></option>
                <option value="0" <?php if($is_active==0):?> selected="selected" <?php endif;?>><?php echo $this->lang->line('umb_no');?></option>
              </select>
            </div>
          </div>
          <div class="col-md-6">
          <div class="form-group">
          <fieldset class="form-group">
            <label for="logo"><?php echo $this->lang->line('umb_logo');?></label>
            <input type="file" class="form-control-file" id="logo_perusahaan" name="logo_perusahaan">
            <small><?php echo $this->lang->line('umb_perusahaan_file_type');?></small>
          </fieldset>
          </div>
        </div>
      </div>
      </div>
    </div>
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
		 Ladda.bind('button[type=submit]'); 

		/* Edit data */
		$("#edit_employer").submit(function(e){
			var fd = new FormData(this);
			var obj = $(this), action = obj.attr('name');
			fd.append("is_ajax", 2);
			fd.append("edit_type", 'employer');
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
								url : "<?php echo site_url("admin/post_pekerjaan/list_employer") ?>",
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
<?php } ?>
