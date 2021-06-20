<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['biaya_id']) && $_GET['data']=='biaya'){?>

  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> 
      <span aria-hidden="true">×</span> 
    </button>
    <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_edit_biaya');?></h4>
  </div>
  <?php $attributes = array('name' => 'edit_biaya', 'id' => 'edit_biaya', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
  <?php $hidden = array('_method' => 'EDIT', '_token' => $biaya_id, 'ext_name' => $biaya_id);?>
  <?php echo form_open('admin/biaya/update/'.$biaya_id, $attributes, $hidden);?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="karyawan"><?php echo $this->lang->line('umb_type_biaya');?></label>
          <select name="type_biaya" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_choose_type_biaya');?>...">
            <option value=""></option>
            <?php foreach($all_types_biaya as $type_biaya) {?>
              <option value="<?php echo $type_biaya->type_biaya_id;?>" <?php if($type_biaya->type_biaya_id==$type_biaya_id):?> selected <?php endif; ?>><?php echo $type_biaya->name;?></option>
            <?php } ?>
          </select>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="tanggal_pembelian"><?php echo $this->lang->line('umb_tanggal_pembelian');?></label>
              <input class="form-control edate" placeholder="<?php echo $this->lang->line('umb_tanggal_pembelian');?>" readonly="true" name="tanggal_pembelian" type="text" value="<?php echo $tanggal_pembelian;?>">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="jumlah"><?php echo $this->lang->line('umb_jumlah');?></label>
              <input class="form-control" placeholder="<?php echo $this->lang->line('umb_jumlah');?>" name="jumlah" type="number" value="<?php echo $jumlah;?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="first_name"><?php echo $this->lang->line('left_perusahaan');?></label>
              <select class="form-control" name="perusahaan_id" id="ajx_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_perusahaan');?>">
                <option value=""></option>
                <?php foreach($get_all_perusahaans as $perusahaan) {?>
                  <option value="<?php echo $perusahaan->perusahaan_id?>" <?php if($perusahaan->perusahaan_id==$perusahaan_id):?> selected <?php endif; ?>><?php echo $perusahaan->name?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group" id="ajx_karyawan">
              <?php $result = $this->Department_model->ajax_info_perusahaan_karyawan($perusahaan_id);?>
              <label for="gift"><?php echo $this->lang->line('umb_dibeli_oleh');?></label>
              <select name="karyawan_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_choose_an_karyawan');?>...">
                <option value=""></option>
                <?php foreach($result as $karyawan) {?>
                  <option value="<?php echo $karyawan->user_id;?>" <?php if($karyawan->user_id==$karyawan_id):?> selected <?php endif; ?>> <?php echo $karyawan->first_name.' '.$karyawan->last_name;?></option>
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
              <label for="description"><?php echo $this->lang->line('umb_keterangan');?></label>
              <textarea class="form-control textarea" name="remarks" cols="25" rows="5" id="description2"><?php echo $remarks;?></textarea>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="status"><?php echo $this->lang->line('dashboard_umb_status');?></label>
              <select name="status" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('dashboard_umb_status');?>...">
                <option value="0" <?php if($status=='0'):?> selected <?php endif; ?>><?php echo $this->lang->line('umb_pending');?></option>
                <option value="1" <?php if($status=='1'):?> selected <?php endif; ?>><?php echo $this->lang->line('umb_approved');?></option>
                <option value="2" <?php if($status=='2'):?> selected <?php endif; ?> ><?php echo $this->lang->line('umb_cancel');?></option>
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class='form-group'>
              <fieldset class="form-group">
                <label for="logo"><?php echo $this->lang->line('umb_bill_copy');?></label>
                <input type="file" class="form-control-file" id="bill_copy" name="bill_copy">
                <small><?php echo $this->lang->line('umb_unggah_files_biaya');?></small>
              </fieldset>
              <?php if($billcopy_file!='' && $billcopy_file!='no file') {?>
                <br />
                <a href="<?php echo site_url("hr/download?type=biaya&filename=".$billcopy_file."") ?>"><?php echo $this->lang->line('umb_download_file');?></a>
              <?php } ?>
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
    $('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
    $('[data-plugin="select_hrm"]').select2({ width:'100%' });	 
		//$('#description2').trumbowyg();
		jQuery("#ajx_perusahaan").change(function(){
			jQuery.get(base_url+"/get_karyawans/"+jQuery(this).val(), function(data, status){
				jQuery('#ajx_karyawan').html(data);
			});
		});
		$('.edate').datepicker({
      changeMonth: true,
      changeYear: true,
      dateFormat:'yy-mm-dd',
      yearRange: '1900:' + (new Date().getFullYear() + 10),
      beforeShow: function(input) {
        $(input).datepicker("widget").show();
      }
    });

		$("#edit_biaya").submit(function(e){
			var fd = new FormData(this);
			var obj = $(this), action = obj.attr('name');
			fd.append("is_ajax", 2);
			fd.append("edit_type", 'biaya');
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
					} else {
						var umb_table = $('#umb_table').dataTable({
							"bDestroy": true,
							"ajax": {
								url : "<?php echo site_url("admin/biaya/list_biaya") ?>",
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
					}
				},
				error: function() {
					toastr.error(JSON.error);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
				} 	        
     });
		});
	});	
</script>
<?php } else if(isset($_GET['jd']) && isset($_GET['biaya_id']) && $_GET['data']=='view_biaya'){
  ?>
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> 
      <span aria-hidden="true">×</span> 
    </button>
    <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_view_biaya');?></h4>
  </div>
  <form class="m-b-1">
    <div class="modal-body">
      <div class="table-responsive" data-pattern="priority-columns">
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
              <th><?php echo $this->lang->line('umb_type_biaya');?></th>
              <td style="display: table-cell;">
                <?php foreach($all_types_biaya as $type_biaya) {?>
                  <?php if($type_biaya_id==$type_biaya->type_biaya_id):?>
                    <?php echo $type_biaya->name;?>
                  <?php endif;?>
                <?php } ?>
              </td>
            </tr>
            <tr>
              <th><?php echo $this->lang->line('umb_tanggal_pembelian');?></th>
              <td style="display: table-cell;"><?php echo $tanggal_pembelian;?></td>
            </tr>
            <tr>
              <th><?php echo $this->lang->line('umb_jumlah');?></th>
              <td style="display: table-cell;"><?php echo $this->Umb_model->currency_sign($jumlah);?></td>
            </tr>
            <tr>
              <th><?php echo $this->lang->line('umb_dibeli_oleh');?></th>
              <td style="display: table-cell;">
                <?php foreach($all_karyawans as $karyawan) {?>
                  <?php if($karyawan_id==$karyawan->user_id):?>
                    <?php echo $karyawan->first_name.' '.$karyawan->last_name;?>
                  <?php endif;?>
                <?php } ?>
              </td>
            </tr>
            <tr>
              <th><?php echo $this->lang->line('dashboard_umb_status');?></th>
              <td style="display: table-cell;">
                <?php if($status=='0'): $e_status = $this->lang->line('umb_pending'); ?>
                <?php endif; ?>
                <?php if($status=='1'): $e_status = $this->lang->line('umb_approved');?>
                <?php endif; ?>
                <?php if($status=='2'): $e_status = $this->lang->line('umb_cancel');?>
                <?php endif; ?>
                <?php echo $e_status;?>
              </td>
            </tr>
            <tr>
              <th><?php echo $this->lang->line('umb_bill_copy');?></th>
              <td style="display: table-cell;">
                <?php $role_resources_ids = $this->Umb_model->user_role_resource();?>
                <?php if(in_array('314',$role_resources_ids)) { //download?>
                  <?php if($billcopy_file!='' && $billcopy_file!='no file') {?>
                    <a href="<?php echo site_url("admin/download?type=biaya&filename=".$billcopy_file."") ?>"><?php echo $this->lang->line('umb_download_file');?></a>
                  <?php } ?>
                <?php } ?>
              </td>
            </tr>
            <tr>
              <th><?php echo $this->lang->line('umb_keterangan');?></th>
              <td style="display: table-cell;"><?php echo html_entity_decode($remarks);?></td>
            </tr>
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
