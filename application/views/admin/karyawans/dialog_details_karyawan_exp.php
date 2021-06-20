<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['field_id']) && $_GET['data']=='krywn_document' && $_GET['type']=='krywn_document'){
	?>
	<div class="modal-header"> <?php echo form_button(array('aria-label' => 'Close', 'data-dismiss' => 'modal', 'type' => 'button', 'class' => 'close', 'content' => '<span aria-hidden="true">×</span>')); ?>
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
				<label for="tanggal_kadaluarsa" class="control-label">
					<?php echo $this->lang->line('umb_e_details_doe');?>
					<i class="hrastral-asterisk">*</i>
				</label>
				<input class="form-control e_date" readonly placeholder="<?php echo $this->lang->line('umb_e_details_doe');?>" name="tanggal_kadaluarsa" type="text" value="<?php echo $tanggal_kadaluarsa;?>">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label for="title" class="control-label">
					<?php echo $this->lang->line('umb_e_details_dtitle');?>
					<i class="hrastral-asterisk">*</i>
				</label>
				<input class="form-control" placeholder="<?php echo $this->lang->line('umb_e_details_dtitle');?>" name="title" type="text" value="<?php echo $title;?>">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="email" class="control-label">
					<?php echo $this->lang->line('umb_e_details_notifyemail');?>
					<i class="hrastral-asterisk">*</i>
				</label>
				<input class="form-control" placeholder="<?php echo $this->lang->line('umb_e_details_notifyemail');?>" name="email" type="email" value="<?php echo $notification_email;?>">
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
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label for="send_mail"><?php echo $this->lang->line('umb_e_details_send_notifyemail');?></label>
				<select name="send_mail" id="send_mail" class="form-control" data-plugin="select_hrm">
					<option value="1" <?php if($is_alert=='1') {?> selected="selected" <?php } ?>><?php echo $this->lang->line('umb_yes');?></option>
					<option value="2" <?php if($is_alert=='2') {?> selected="selected" <?php } ?>><?php echo $this->lang->line('umb_no');?></option>
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
		$('.e_date').bootstrapMaterialDatePicker({
			weekStart: 0,
			time: false,
			clearButton: false,
			format: 'YYYY-MM-DD'
		})
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
				success: function(JSON)
				{
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
								url : "<?php echo site_url("admin/karyawans/list_documents_kadaluarsa") ?>/"+$('#user_id').val(),
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
<?php } else if(isset($_GET['jd']) && isset($_GET['field_id']) && $_GET['data']=='e_imgdocument' && $_GET['type']=='e_imgdocument'){ ?>
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
					<label for="relation">
						<?php echo $this->lang->line('umb_e_details_document');?>
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
						<?php if($document_file!='' && $document_file!='no file') {?>
							<br />
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
					success: function(JSON)
					{
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
									url : "<?php echo site_url("admin/karyawans/list_immigration_kadaluarsa") ?>/"+$('#user_id').val(),
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
<?php } else if(isset($_GET['jd']) && isset($_GET['field_id']) && $_GET['data']=='edocument_id' && $_GET['type']=='edocument_id'){
	?>
	<?php $session = $this->session->userdata('username');?>
	<?php $user_info = $this->Umb_model->read_user_info($session['user_id']);?>
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"> 
			<span aria-hidden="true">×</span> 
		</button>
		<h4 class="modal-title" id="edit-modal-data">
			<i class="icon-pencil7"></i> 
			<?php echo $this->lang->line('umb_edit_perusahaan');?>
		</h4>
	</div>
	<?php $attributes = array('name' => 'edit_document', 'id' => 'edit_document', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
	<?php $hidden = array('_method' => 'EDIT', '_token' => $_GET['field_id'], 'ext_name' => $nama_license);?>
	<?php echo form_open_multipart('admin/perusahaan/update_document_resmi/'.$document_id, $attributes, $hidden);?>
	<div class="modal-body">
		<div class="form-body">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="nama_license">
							<?php echo $this->lang->line('umb_hr_official_nama_license');?><i class="hrastral-asterisk">*</i></label>
							<input class="form-control" placeholder="<?php echo $this->lang->line('umb_hr_official_nama_license');?>" name="nama_license" type="text" value="<?php echo $nama_license;?>">
						</div>
						<div class="form-group">
							<div class="row">
								<?php if($user_info[0]->user_role_id==1){ ?>
									<div class="col-md-6">
										<label for="perusahaan_id">
											<?php echo $this->lang->line('left_perusahaan');?>
											<i class="hrastral-asterisk">*</i>
										</label>
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
										<label for="perusahaan_id">
											<?php echo $this->lang->line('left_perusahaan');?>
											<i class="hrastral-asterisk">*</i>
										</label>
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
									<label for="tanggal_kaaluarsa">
										<?php echo $this->lang->line('umb_tanggal_kaaluarsa');?>
										<i class="hrastral-asterisk">*</i>
									</label>
									<input class="form-control ddate" placeholder="<?php echo $this->lang->line('umb_tanggal_kaaluarsa');?>" name="tanggal_kaaluarsa" type="text" value="<?php echo $tanggal_kaaluarsa;?>">
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<fieldset class="form-group">
											<label for="scan_file">
												<?php echo $this->lang->line('umb_hr_official_license_scan');?>
												<i class="hrastral-asterisk">*</i>
											</label>
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
						<div class="form-group">
							<label for="nomor_license">
								<?php echo $this->lang->line('umb_hr_official_nomor_license');?>
								<i class="hrastral-asterisk">*</i>
							</label>
							<input class="form-control" placeholder="<?php echo $this->lang->line('umb_hr_official_nomor_license');?>" name="nomor_license" type="text" value="<?php echo $nomor_license;?>">
						</div>
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
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('umb_close');?>asd</button>
			<button type="submit" class="btn btn-primary save"><?php echo $this->lang->line('umb_update');?></button>
		</div>
		<?php echo form_close(); ?>
		<script type="text/javascript">
			$(document).ready(function(){

				$('[data-plugin="umb_select"]').select2($(this).attr('data-options'));
				$('[data-plugin="umb_select"]').select2({ width:'100%' });	 
				Ladda.bind('button[type=submit]');
				$('.ddate').bootstrapMaterialDatePicker({
					weekStart: 0,
					time: false,
					clearButton: false,
					format: 'YYYY-MM-DD'
				});
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
								var xumb_table = $('#umb_table_perusahaan_license').dataTable({
									"bDestroy": true,
									"ajax": {
										url : "<?php echo site_url("admin/karyawans/list_licence_perusahaan_exp") ?>",
										type : 'GET'
									},
									"fnDrawCallback": function(settings){
										$('[data-toggle="tooltip"]').tooltip();          
									}
								});
								xumb_table.api().ajax.reload(function(){ 
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
	<?php } else if(isset($_GET['jd']) && isset($_GET['field_id']) && $_GET['data']=='eassets_warranty' && $_GET['type']=='eassets_warranty'){ ?>
		<?php $session = $this->session->userdata('username');?>
		<?php $user_info = $this->Umb_model->read_user_info($session['user_id']);?>
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"> 
				<span aria-hidden="true">×</span> 
			</button>
			<h4 class="modal-title" id="edit-modal-data">
				<i class="icon-pencil7"></i> 
				<?php echo $this->lang->line('umb_edit_asset');?>
			</h4>
		</div>
		<?php $attributes = array('name' => 'update_asset', 'id' => 'update_asset', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
		<?php $hidden = array('_method' => 'EDIT', '_token' => $assets_id, 'ext_name' => $name);?>
		<?php echo form_open_multipart('admin/assets/update_asset/'.$assets_id, $attributes, $hidden);?>
		<div class="modal-body">
			<div class="row">
				<div class="col-md-6">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="first_name">
									<?php echo $this->lang->line('umb_acc_kategori');?>
									<i class="hrastral-asterisk">*</i>
								</label>
								<select class="form-control" name="kategori_id" id="kategori_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_perusahaan');?>">
									<option value=""></option>
									<?php foreach($all_kategoris_assets as $kategori_assets) {?>
										<option value="<?php echo $kategori_assets->kategori_assets_id?>" <?php if($kategori_assets_id==$kategori_assets->kategori_assets_id):?> selected="selected" <?php endif;?>><?php echo $kategori_assets->nama_kategori?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="nama_asset" class="control-label">
									<?php echo $this->lang->line('umb_nama_asset');?>
									<i class="hrastral-asterisk">*</i>
								</label>
								<input class="form-control" placeholder="<?php echo $this->lang->line('umb_nama_asset');?>" name="nama_asset" type="text" value="<?php echo $name?>">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<?php if($user_info[0]->user_role_id==1){ ?>
								<div class="form-group">
									<label for="perusahaan_id">
										<?php echo $this->lang->line('left_perusahaan');?>
										<i class="hrastral-asterisk">*</i>
									</label>
									<select class="form-control" name="perusahaan_id" id="ajx_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_perusahaan');?>">
										<option value=""></option>
										<?php foreach($all_perusahaans as $perusahaan) {?>
											<option value="<?php echo $perusahaan->perusahaan_id?>" <?php if($perusahaan_id==$perusahaan->perusahaan_id):?> selected="selected" <?php endif;?>><?php echo $perusahaan->name?></option>
										<?php } ?>
									</select>
								</div>
							<?php } else {?>
								<?php $eperusahaan_id = $user_info[0]->perusahaan_id;?>
								<div class="form-group">
									<label for="perusahaan_id">
										<?php echo $this->lang->line('left_perusahaan');?>
										<i class="hrastral-asterisk">*</i>
									</label>
									<select class="form-control" name="perusahaan_id" id="ajx_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_perusahaan');?>">
										<option value=""></option>
										<?php foreach($all_perusahaans as $perusahaan) {?>
											<?php if($eperusahaan_id == $perusahaan->perusahaan_id):?>
												<option value="<?php echo $perusahaan->perusahaan_id?>" <?php if($perusahaan_id==$perusahaan->perusahaan_id):?> selected="selected" <?php endif;?>><?php echo $perusahaan->name?></option>
											<?php endif;?>
										<?php } ?>
									</select>
								</div>
							<?php } ?>
						</div>
						<div class="col-md-6">
							<?php $result = $this->Department_model->ajax_info_perusahaan_karyawan($perusahaan_id);?>
							<div class="form-group" id="ajx_karyawan">
								<label for="first_name">
									<?php echo $this->lang->line('umb_assets_assign_to');?>
									<i class="hrastral-asterisk">*</i>
								</label>
								<select class="form-control" name="karyawan_id" id="karyawan_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_choose_an_karyawan');?>">
									<option value=""></option>
									<?php foreach($result as $karyawan) {?>
										<option value="<?php echo $karyawan->user_id?>" <?php if($karyawan_id==$karyawan->user_id):?> selected="selected" <?php endif;?>><?php echo $karyawan->first_name.' '.$karyawan->last_name;?></option>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="manufacturer"><?php echo $this->lang->line('umb_manufacturer');?></label>
								<input class="form-control" placeholder="<?php echo $this->lang->line('umb_manufacturer');?>" name="manufacturer" type="text" value="<?php echo $manufacturer?>">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="umb_serial_number" class="control-label"><?php echo $this->lang->line('umb_serial_number');?></label>
								<input class="form-control" placeholder="<?php echo $this->lang->line('umb_serial_number');?>" name="serial_number" type="text" value="<?php echo $serial_number?>">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<fieldset class="form-group">
									<label for="asset_image">
										<?php echo $this->lang->line('umb_asset_image');?>
										<i class="hrastral-asterisk">*</i>
									</label>
									<input type="file" class="form-control-file" id="asset_image" name="asset_image">
									<small><?php echo $this->lang->line('umb_asset_allowed_image_formats');?></small>
								</fieldset>
							</div>
						</div>
						<div class="col-md-6">
							<div class='form-group'>
								<label for="kode_asset_perusahaan">&nbsp;</label>
								<?php if($asset_image!='' && $asset_image!='no file') {?>
									<img src="<?php echo base_url().'uploads/asset_image/'.$asset_image;?>" width="70px" id="u_file"> 
									<a href="<?php echo site_url()?>admin/download?type=asset_image&filename=<?php echo $asset_image;?>"><?php echo $this->lang->line('umb_download');?></a>
								<?php } else {?>
									<p>&nbsp;</p>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="kode_asset_perusahaan"><?php echo $this->lang->line('umb_kode_asset_perusahaan');?></label>
								<input class="form-control" placeholder="<?php echo $this->lang->line('umb_kode_asset_perusahaan');?>" name="kode_asset_perusahaan" type="text" value="<?php echo $kode_asset_perusahaan?>">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="sedang_bekerja" class="control-label"><?php echo $this->lang->line('umb_sedang_bekerja');?></label>
								<select class="form-control" name="sedang_bekerja" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_sedang_bekerja');?>">
									<option value="1" <?php if($sedang_bekerja==1):?> selected="selected" <?php endif;?>><?php echo $this->lang->line('umb_yes');?></option>
									<option value="0" <?php if($sedang_bekerja==0):?> selected="selected" <?php endif;?>><?php echo $this->lang->line('umb_no');?></option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="tanggal_pembelian"><?php echo $this->lang->line('umb_tanggal_pembelian');?></label>
								<input class="form-control tanggal_d_assets" placeholder="<?php echo $this->lang->line('umb_tanggal_pembelian');?>" name="tanggal_pembelian" type="text" value="<?php echo $tanggal_pembelian?>">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="role"><?php echo $this->lang->line('umb_nomor_invoice');?></label>
								<input class="form-control" placeholder="<?php echo $this->lang->line('umb_nomor_invoice');?>" name="nomor_invoice" type="text" value="<?php echo $nomor_invoice?>">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="tanggal_akhir_garansi" class="control-label"><?php echo $this->lang->line('umb_tanggal_akhir_garansi');?></label>
								<input class="form-control tanggal_d_assets" placeholder="<?php echo $this->lang->line('umb_tanggal_akhir_garansi');?>" name="tanggal_akhir_garansi" type="text" value="<?php echo $tanggal_akhir_garansi?>">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="informasi_award"><?php echo $this->lang->line('umb_asset_note');?></label>
								<textarea class="form-control" placeholder="<?php echo $this->lang->line('umb_asset_note');?>" name="asset_note" cols="30" rows="3" id="asset_note"><?php echo $asset_note?></textarea>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php $count_module_attributes = $this->Custom_fields_model->count_assets_module_attributes();?>
			<?php $module_attributes = $this->Custom_fields_model->assets_hrastral_module_attributes();?>
			<div class="row">
				<?php foreach($module_attributes as $mattribute):?>
					<?php $attribute_info = $this->Custom_fields_model->get_data_custom_karyawan($assets_id,$mattribute->custom_field_id);?>
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
								<input class="form-control tanggal_d_assets" placeholder="<?php echo $mattribute->attribute_label;?>" name="<?php echo $mattribute->attribute;?>" type="text" value="<?php echo $attr_val;?>">
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
		<button type="button" class="btn btn-success " data-dismiss="modal"><?php echo $this->lang->line('umb_close');?></button>
		<button type="submit" class="btn btn-primary save"><?php echo $this->lang->line('umb_update');?></button>
	</div>
	<?php echo form_close(); ?>
	<script type="text/javascript">
		$(document).ready(function(){
			$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
			$('[data-plugin="select_hrm"]').select2({ width:'100%' });
			jQuery("#ajx_perusahaan").change(function(){
				jQuery.get(base_url+"/get_karyawans/"+jQuery(this).val(), function(data, status){
					jQuery('#ajx_karyawan').html(data);
				});
			}); 	 
			Ladda.bind('button[type=submit]');
			$('.tanggal_d_assets').bootstrapMaterialDatePicker({
				weekStart: 0,
				time: false,
				clearButton: false,
				format: 'YYYY-MM-DD'
			});
			$("#update_asset").submit(function(e){
				var fd = new FormData(this);
				var obj = $(this), action = obj.attr('name');
				fd.append("is_ajax", 2);
				fd.append("edit_type", 'update_asset');
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
							var umb_table = $('#umb_table_assets_warranty').dataTable({
								"bDestroy": true,
								"ajax": {
									url : "<?php echo site_url("admin/karyawans/list_garansi_assets"); ?>",
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
<?php }?>
