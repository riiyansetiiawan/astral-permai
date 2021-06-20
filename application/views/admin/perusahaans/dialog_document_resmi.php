<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['document_id']) && $_GET['data']=='document'){
	?>
	<?php $session = $this->session->userdata('username');?>
	<?php $user_info = $this->Umb_model->read_user_info($session['user_id']);?>
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
		<h4 class="modal-title" id="edit-modal-data"><i class="icon-pencil7"></i> <?php echo $this->lang->line('umb_edit_perusahaan');?></h4>
	</div>
	<?php $attributes = array('name' => 'edit_document', 'id' => 'edit_document', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
	<?php $hidden = array('_method' => 'EDIT', '_token' => $_GET['document_id'], 'ext_name' => $nama_license);?>
	<?php echo form_open_multipart('admin/perusahaan/update_document_resmi/'.$document_id, $attributes, $hidden);?>
	<div class="modal-body">
		<div class="form-body">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="nama_license"><?php echo $this->lang->line('umb_hr_official_nama_license');?></label>
						<input class="form-control" placeholder="<?php echo $this->lang->line('umb_hr_official_nama_license');?>" name="nama_license" type="text" value="<?php echo $nama_license;?>">
					</div>
					<div class="form-group">
						<div class="row">
							<?php if($user_info[0]->user_role_id==1){ ?>
								<div class="col-md-6">
									<label for="perusahaan_id"><?php echo $this->lang->line('left_perusahaan');?></label>
									<select class="form-control" name="perusahaan_id" data-plugin="umb_select" data-placeholder="<?php echo $this->lang->line('left_perusahaan');?>">
										<option value=""></option>
										<?php foreach($get_all_perusahaans as $perusahaan) {?>
											<option value="<?php echo $perusahaan->perusahaan_id?>" <?php if($perusahaan->perusahaan_id==$perusahaan_id):?> selected="selected"<?php endif?>><?php echo $perusahaan->name?></option>
										<?php } ?>
									</select>
								</div>
							<?php } else {?>
								<?php $eperusahaan_id = $user_info[0]->perusahaan_id;?>
								<div class="col-md-6">
									<label for="perusahaan_id"><?php echo $this->lang->line('left_perusahaan');?></label>
									<select class="form-control" name="perusahaan_id" data-plugin="umb_select" data-placeholder="<?php echo $this->lang->line('left_perusahaan');?>">
										<option value=""></option>
										<?php foreach($get_all_perusahaans as $perusahaan) {?>
											<?php if($eperusahaan_id == $perusahaan->perusahaan_id):?>
												<option value="<?php echo $perusahaan->perusahaan_id?>" <?php if($perusahaan->perusahaan_id==$perusahaan_id):?> selected="selected"<?php endif?>><?php echo $perusahaan->name?></option>
											<?php endif;?>
										<?php } ?>
									</select>
								</div>
							<?php } ?>
							<div class="col-md-6">
								<label for="tanggal_kaaluarsa"><?php echo $this->lang->line('umb_tanggal_kaaluarsa');?></label>
								<input class="form-control ddate" placeholder="<?php echo $this->lang->line('umb_tanggal_kaaluarsa');?>" id="tanggal_kaaluarsa" name="tanggal_kaaluarsa" type="text" value="<?php echo $tanggal_kaaluarsa;?>">
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<fieldset class="form-group">
										<label for="scan_file"><?php echo $this->lang->line('umb_hr_official_license_scan');?></label>
										<input type="file" class="form-control-file" id="scan_file" name="scan_file">
										<small><?php echo $this->lang->line('umb_perusahaan_file_type');?></small>
									</fieldset>
									<?php echo $doc_view='<a href="'.site_url('admin/download?type=perusahaan/documents_resmi&filename=').$document.'">'.$this->lang->line('umb_view').'</a>';?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="relation"><?php echo $this->lang->line('umb_e_details_dtype');?></label>
								<select name="type_document_id" id="type_document_id" class="form-control" data-plugin="umb_select" data-placeholder="<?php echo $this->lang->line('umb_e_details_choose_dtype');?>">
									<option value=""></option>
									<?php foreach($all_types_document as $type_document) {?>
										<option value="<?php echo $type_document->type_document_id;?>" <?php if($type_document_id==$type_document->type_document_id):?> selected="selected"<?php endif?>> <?php echo $type_document->type_document;?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="nomor_license"><?php echo $this->lang->line('umb_hr_official_nomor_license');?></label>
								<input class="form-control" placeholder="<?php echo $this->lang->line('umb_hr_official_nomor_license');?>" name="nomor_license" type="text" value="<?php echo $nomor_license;?>">
							</div>
						</div>
					</div>
					<!---->
					<div class="form-group">
						<label for="umb_pjkprmth"><?php echo $this->lang->line('umb_hr_official_license_alarm');?></label>
						<select class="form-control" name="license_notification" data-plugin="umb_select" data-placeholder="<?php echo $this->lang->line('umb_hr_official_license_alarm');?>">
							<option value="0" <?php if(0==$license_notification):?> selected="selected"<?php endif?>><?php echo $this->lang->line('umb_hr_license_no_alarm');?></option>
							<option value="1" <?php if(1==$license_notification):?> selected="selected"<?php endif?>><?php echo $this->lang->line('umb_hr_license_alarm_1');?></option>
							<option value="3" <?php if(3==$license_notification):?> selected="selected"<?php endif?>><?php echo $this->lang->line('umb_hr_license_alarm_3');?></option>
							<option value="6" <?php if(6==$license_notification):?> selected="selected"<?php endif?>><?php echo $this->lang->line('umb_hr_license_alarm_6');?></option>
						</select>
					</div>
				</div>
			</div>
			</div
			></div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('umb_close');?></button>
				<button type="submit" class="btn btn-primary save"><?php echo $this->lang->line('umb_update');?></button>
			</div>
			<?php echo form_close(); ?>
			<style type="text/css">
				.datepicker {
					z-index: 100000 !important;
					display: block;
				}
			</style>
			<script type="text/javascript">
				$(document).ready(function(){
					
					$('[data-plugin="umb_select"]').select2($(this).attr('data-options'));
					$('[data-plugin="umb_select"]').select2({ width:'100%' });
					
		// Expiry Date
		$('.ddate').bootstrapMaterialDatePicker({
			weekStart: 0,
			time: false,
			clearButton: true,
			format: 'YYYY-MM-DD'
		});	 
		Ladda.bind('button[type=submit]');
		/* Edit data */
		$("#edit_document").submit(function(e){
			var fd = new FormData(this);
			var obj = $(this), action = obj.attr('name');
			fd.append("is_ajax", 2);
			fd.append("edit_type", 'document');
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
						var umb_documents_resmi_table = $('#umb_table').dataTable({
							"bDestroy": true,
							"ajax": {
								url : "<?php echo site_url("admin/perusahaan/list_document") ?>",
								type : 'GET'
							},
							"fnDrawCallback": function(settings){
								$('[data-toggle="tooltip"]').tooltip();          
							}
						});
						umb_documents_resmi_table.api().ajax.reload(function(){ 
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
<?php } else if(isset($_GET['jd']) && $_GET['data']=='view_document' && isset($_GET['document_id']) ){
	?>
	<form class="m-b-1">
		<div class="modal-body">
			<p class="text-center text-big mb-4"><strong><?php echo $this->lang->line('umb_hr_document_resmi_view');?></strong></p>
			<div class="table-responsive" data-pattern="priority-columns">
				<table class="footable-details table table-striped table-hover toggle-circle">
					<tbody>                    
						<tr>
							<th><?php echo $this->lang->line('umb_e_details_dtype');?></th>
							<td style="display: table-cell;"><?php foreach($all_types_document as $type_document) {?>
								<?php if($type_document_id==$type_document->type_document_id):?><?php echo $type_document->type_document;?><?php endif?><?php } ?></td>
							</tr>
							<tr>
								<th><?php echo $this->lang->line('umb_hr_official_nama_license');?></th>
								<td style="display: table-cell;"><?php echo $nama_license;?></td>
							</tr>
							<tr>
								<th><?php echo $this->lang->line('left_perusahaan');?></th>
								<td style="display: table-cell;"><?php foreach($get_all_perusahaans as $perusahaan) {?>
									<?php if($perusahaan_id==$perusahaan->perusahaan_id){?>
										<?php echo $perusahaan->name;?>
										<?php } } ?></td>
									</tr>
									<tr>
										<th><?php echo $this->lang->line('umb_tanggal_kaaluarsa');?></th>
										<td style="display: table-cell;"><?php echo $tanggal_kaaluarsa;?></td>
									</tr>
									<tr>
										<th><?php echo $this->lang->line('umb_hr_official_nomor_license');?></th>
										<td style="display: table-cell;"><?php echo $nomor_license;?></span></td>
									</tr>
									<tr>
										<th><?php echo $this->lang->line('umb_hr_official_license_alarm');?></th>
										<td style="display: table-cell;"><?php
										if($license_notification==0){
											echo $notification = $this->lang->line('umb_hr_license_no_alarm');
										} else if($license_notification==1){
											echo $notification = $this->lang->line('umb_hr_license_alarm_1');
										} else if($license_notification==2){
											echo $notification = $this->lang->line('umb_hr_license_alarm_3');
										} else {
											echo $notification = $this->lang->line('umb_hr_license_alarm_6');
										}
										?></span></td>
									</tr>
									<tr>
										<th><?php echo $this->lang->line('umb_hr_official_license_scan');?></th>
										<td style="display: table-cell;"><?php if($document!='' || $document!='no-file'){?>
											<div class="avatar box-48 mr-0-5"> <?php echo $doc = '<a href="'.site_url('admin/download?type=perusahaan/documents_resmi&filename=').$document.'">'.$this->lang->line('umb_view').'</a>';?> </div>
											<?php } ?></td>
										</tr>
									</tbody>
								</table></div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('umb_close');?></button>
							</div>
							<?php echo form_close(); ?>
						<?php }
						?>
