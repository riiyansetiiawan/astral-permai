<?php
if(isset($_GET['jd']) && isset($_GET['field_id']) && $_GET['data']=='ed_type_document' && $_GET['type']=='ed_type_document'){
	$row = $this->Umb_model->read_type_document($_GET['field_id']);
	?>

	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
		<h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_edit_type_document');?></h4>
	</div>
	<?php $attributes = array('name' => 'ed_info_type_document', 'id' => 'ed_info_type_document', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
	<?php $hidden = array('_method' => 'EDIT', '_token' => $row[0]->type_document_id, 'ext_name' => $row[0]->type_document);?>
	<?php echo form_open('admin/settings/update_type_document/'.$row[0]->type_document_id, $attributes, $hidden);?>
	<div class="modal-body">
		
		<div class="form-group">
			<label for="name" class="form-control-label"><?php echo $this->lang->line('umb_e_details_dtype');?>:</label>
			<input type="text" class="form-control" name="name" placeholder="<?php echo $this->lang->line('umb_e_details_dtype');?>" value="<?php echo $row[0]->type_document;?>">
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
			/* Edit data */
			$("#ed_info_type_document").submit(function(e){
				
				e.preventDefault();
				var obj = $(this), action = obj.attr('name');
				$('.save').prop('disabled', true);
				$.ajax({
					type: "POST",
					url: e.target.action,
					data: obj.serialize()+"&is_ajax=21&type=edit_record&data=ed_info_type_document&form="+action,
					cache: false,
					success: function (JSON) {
						if (JSON.error != '') {
							toastr.error(JSON.error);
							$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
							$('.save').prop('disabled', false);
							Ladda.stopAll();
						} else {
							$('.edit_setting_datail').modal('toggle');
					// On page load: datatable
					var umb_table_type_document = $('#umb_table_type_document').dataTable({
						"bDestroy": true,
						"bFilter": false,
						"iDisplayLength": 5,
						"aLengthMenu": [[5, 10, 30, 50, 100, -1], [5, 10, 30, 50, 100, "All"]],
						"ajax": {
							url : "<?php echo site_url("admin/settings/list_type_document") ?>",
							type : 'GET'
						},
						"fnDrawCallback": function(settings){
							$('[data-toggle="tooltip"]').tooltip();          
						}			
					});
					umb_table_type_document.api().ajax.reload(function(){ 
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
<?php } else if(isset($_GET['jd']) && isset($_GET['field_id']) && $_GET['data']=='ed_type_kontrak' && $_GET['type']=='ed_type_kontrak'){
	$row = $this->Umb_model->read_type_kontrak($_GET['field_id']);
	?>
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
		<h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_edit_type_kontrak');?></h4>
	</div>
	<?php $attributes = array('name' => 'ed_info_type_kontrak', 'id' => 'ed_info_type_kontrak', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
	<?php $hidden = array('_method' => 'EDIT', '_token' => $row[0]->type_kontrak_id, 'ext_name' => $row[0]->name);?>
	<?php echo form_open('admin/settings/update_type_kontrak/'.$row[0]->type_kontrak_id, $attributes, $hidden);?>
	<div class="modal-body">
		
		<div class="form-group">
			<label for="name" class="form-control-label"><?php echo $this->lang->line('umb_e_details_type_kontrak');?>:</label>
			<input type="text" class="form-control" name="name" placeholder="<?php echo $this->lang->line('umb_e_details_type_kontrak');?>" value="<?php echo $row[0]->name?>">
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
			/* Edit data */
			$("#ed_info_type_kontrak").submit(function(e){
				
				e.preventDefault();
				var obj = $(this), action = obj.attr('name');
				$('.save').prop('disabled', true);
				$.ajax({
					type: "POST",
					url: e.target.action,
					data: obj.serialize()+"&is_ajax=22&type=edit_record&data=ed_info_type_kontrak&form="+action,
					cache: false,
					success: function (JSON) {
						if (JSON.error != '') {
							toastr.error(JSON.error);
							$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
							$('.save').prop('disabled', false);
							Ladda.stopAll();
						} else {
							$('.edit_setting_datail').modal('toggle');
					// On page load: datatable
					var umb_table_type_kontrak = $('#umb_table_type_kontrak').dataTable({
						"bDestroy": true,
						"bFilter": false,
						"iDisplayLength": 5,
						"aLengthMenu": [[5, 10, 30, 50, 100, -1], [5, 10, 30, 50, 100, "All"]],
						"ajax": {
							url : "<?php echo site_url("admin/settings/list_type_kontrak") ?>",
							type : 'GET'
						},
						"fnDrawCallback": function(settings){
							$('[data-toggle="tooltip"]').tooltip();          
						}			
					});	
					umb_table_type_kontrak.api().ajax.reload(function(){ 
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
<?php } else if(isset($_GET['jd']) && isset($_GET['field_id']) && $_GET['data']=='ed_payment_method' && $_GET['type']=='ed_payment_method'){
	$row = $this->Umb_model->read_payment_method($_GET['field_id']);
	?>
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
		<h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_edit_payment_method');?></h4>
	</div>
	<?php $attributes = array('name' => 'ed_info_payment_method', 'id' => 'ed_info_payment_method', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
	<?php $hidden = array('_method' => 'EDIT', '_token' => $row[0]->payment_method_id, 'ext_name' => $row[0]->method_name);?>
	<?php echo form_open('admin/settings/update_payment_method/'.$row[0]->payment_method_id, $attributes, $hidden);?>
	<div class="modal-body">
		
		<div class="form-group">
			<label for="name" class="form-control-label"><?php echo $this->lang->line('umb_payment_method');?>:</label>
			<input type="text" class="form-control" name="name" placeholder="Enter <?php echo $this->lang->line('umb_payment_method');?>" value="<?php echo $row[0]->method_name;?>">
		</div>
		<div class="form-group">
			<label for="payment_percentage" class="form-control-label"><?php echo $this->lang->line('umb_payroll_pdf_pay_percent');?>:</label>
			<input type="text" class="form-control" name="payment_percentage" placeholder="Enter <?php echo $this->lang->line('umb_payroll_pdf_pay_percent');?>" value="<?php echo $row[0]->payment_percentage;?>">
		</div>
		<div class="form-group">
			<label for="nomor_account" class="form-control-label"><?php echo $this->lang->line('umb_payroll_pdf_acc_number');?>:</label>
			<input type="text" class="form-control" name="nomor_account" placeholder="Enter <?php echo $this->lang->line('umb_payroll_pdf_acc_number');?>" value="<?php echo $row[0]->nomor_account;?>">
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
			/* Edit data */
			$("#ed_info_payment_method").submit(function(e){
				
				e.preventDefault();
				var obj = $(this), action = obj.attr('name');
				$('.save').prop('disabled', true);
				$.ajax({
					type: "POST",
					url: e.target.action,
					data: obj.serialize()+"&is_ajax=23&type=edit_record&data=ed_info_payment_method&form="+action,
					cache: false,
					success: function (JSON) {
						if (JSON.error != '') {
							toastr.error(JSON.error);
							$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
							$('.save').prop('disabled', false);
							Ladda.stopAll();
						} else {
							$('.edit_setting_datail').modal('toggle');
					// On page load: datatable
					var umb_table_payment_method = $('#umb_table_payment_method').dataTable({
						"bDestroy": true,
						"bFilter": false,
						"iDisplayLength": 5,
						"aLengthMenu": [[5, 10, 30, 50, 100, -1], [5, 10, 30, 50, 100, "All"]],
						"ajax": {
							url : "<?php echo site_url("admin/settings/list_payment_method") ?>",
							type : 'GET'
						},
						"fnDrawCallback": function(settings){
							$('[data-toggle="tooltip"]').tooltip();          
						}			
					});
					umb_table_payment_method.api().ajax.reload(function(){ 
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
<?php } else if(isset($_GET['jd']) && isset($_GET['field_id']) && $_GET['data']=='ed_tingkat_pendidikan' && $_GET['type']=='ed_tingkat_pendidikan'){
	$row = $this->Umb_model->read_tingkat_pendidikan($_GET['field_id']);
	?>
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
		<h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_edit_tingkat_pendidikan');?></h4>
	</div>
	<?php $attributes = array('name' => 'ed_tingkat_pendidikan_info', 'id' => 'ed_tingkat_pendidikan_info', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
	<?php $hidden = array('_method' => 'EDIT', '_token' => $row[0]->tingkat_pendidikan_id, 'ext_name' => $row[0]->name);?>
	<?php echo form_open('admin/settings/update_tingkat_pendidikan/'.$row[0]->tingkat_pendidikan_id, $attributes, $hidden);?>
	<div class="modal-body">
		
		<div class="form-group">
			<label for="name" class="form-control-label"><?php echo $this->lang->line('umb_e_details_edu_level');?>:</label>
			<input type="text" class="form-control" name="name" placeholder="<?php echo $this->lang->line('umb_e_details_edu_level');?>" value="<?php echo $row[0]->name;?>">
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
			/* Edit data */
			$("#ed_tingkat_pendidikan_info").submit(function(e){
				
				e.preventDefault();
				var obj = $(this), action = obj.attr('name');
				$('.save').prop('disabled', true);
				$.ajax({
					type: "POST",
					url: e.target.action,
					data: obj.serialize()+"&is_ajax=24&type=edit_record&data=ed_tingkat_pendidikan_info&form="+action,
					cache: false,
					success: function (JSON) {
						if (JSON.error != '') {
							toastr.error(JSON.error);
							$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
							$('.save').prop('disabled', false);
							Ladda.stopAll();
						} else {
							$('.edit_setting_datail').modal('toggle');
					// On page load: datatable
					var umb_table_tingkat_pendidikan = $('#umb_table_tingkat_pendidikan').dataTable({
						"bDestroy": true,
						"bFilter": false,
						"iDisplayLength": 5,
						"aLengthMenu": [[5, 10, 30, 50, 100, -1], [5, 10, 30, 50, 100, "All"]],
						"ajax": {
							url : "<?php echo site_url("admin/settings/list_tingkat_pendidikan") ?>",
							type : 'GET'
						},
						"fnDrawCallback": function(settings){
							$('[data-toggle="tooltip"]').tooltip();          
						}			
					});
					umb_table_tingkat_pendidikan.api().ajax.reload(function(){ 
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
<?php } else if(isset($_GET['jd']) && isset($_GET['field_id']) && $_GET['data']=='ed_qualification_language' && $_GET['type']=='ed_qualification_language'){
	$row = $this->Umb_model->read_qualification_language($_GET['field_id']);
	?>
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
		<h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_edit_language');?></h4>
	</div>
	<?php $attributes = array('name' => 'ed_qualification_language_info', 'id' => 'ed_qualification_language_info', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
	<?php $hidden = array('_method' => 'EDIT', '_token' => $row[0]->language_id, 'ext_name' => $row[0]->name);?>
	<?php echo form_open('admin/settings/update_qualification_language/'.$row[0]->language_id, $attributes, $hidden);?>
	<div class="modal-body">
		
		<div class="form-group">
			<label for="name" class="form-control-label"><?php echo $this->lang->line('umb_e_details_language');?>:</label>
			<input type="text" class="form-control" name="name" placeholder="<?php echo $this->lang->line('umb_e_details_language');?>" value="<?php echo $row[0]->name;?>">
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
			/* Edit data */
			$("#ed_qualification_language_info").submit(function(e){
				
				e.preventDefault();
				var obj = $(this), action = obj.attr('name');
				$('.save').prop('disabled', true);
				$.ajax({
					type: "POST",
					url: e.target.action,
					data: obj.serialize()+"&is_ajax=25&type=edit_record&data=ed_qualification_language_info&form="+action,
					cache: false,
					success: function (JSON) {
						if (JSON.error != '') {
							toastr.error(JSON.error);
							$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
							$('.save').prop('disabled', false);
							Ladda.stopAll();
						} else {
							$('.edit_setting_datail').modal('toggle');
					// On page load: datatable
					var umb_table_qualification_language = $('#umb_table_qualification_language').dataTable({
						"bDestroy": true,
						"bFilter": false,
						"iDisplayLength": 5,
						"aLengthMenu": [[5, 10, 30, 50, 100, -1], [5, 10, 30, 50, 100, "All"]],
						"ajax": {
							url : "<?php echo site_url("admin/settings/list_qualification_language") ?>",
							type : 'GET'
						},
						"fnDrawCallback": function(settings){
							$('[data-toggle="tooltip"]').tooltip();          
						}			
					});
					umb_table_qualification_language.api().ajax.reload(function(){ 
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
<?php } else if(isset($_GET['jd']) && isset($_GET['field_id']) && $_GET['data']=='ed_qualification_skill' && $_GET['type']=='ed_qualification_skill'){
	$row = $this->Umb_model->read_qualification_skill($_GET['field_id']);
	?>
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
		<h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_edit_skill');?></h4>
	</div>
	<?php $attributes = array('name' => 'ed_qualification_skill_info', 'id' => 'ed_qualification_skill_info', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
	<?php $hidden = array('_method' => 'EDIT', '_token' => $row[0]->skill_id, 'ext_name' => $row[0]->name);?>
	<?php echo form_open('admin/settings/update_qualification_skill/'.$row[0]->skill_id, $attributes, $hidden);?>
	<div class="modal-body">
		
		<div class="form-group">
			<label for="name" class="form-control-label"><?php echo $this->lang->line('umb_skill');?>:</label>
			<input type="text" class="form-control" name="name" placeholder="<?php echo $this->lang->line('umb_skill');?>" value="<?php echo $row[0]->name;?>">
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
			/* Edit data */
			$("#ed_qualification_skill_info").submit(function(e){
				
				e.preventDefault();
				var obj = $(this), action = obj.attr('name');
				$('.save').prop('disabled', true);
				$.ajax({
					type: "POST",
					url: e.target.action,
					data: obj.serialize()+"&is_ajax=26&type=edit_record&data=ed_qualification_skill_info&form="+action,
					cache: false,
					success: function (JSON) {
						if (JSON.error != '') {
							toastr.error(JSON.error);
							$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
							$('.save').prop('disabled', false);
							Ladda.stopAll();
						} else {
							$('.edit_setting_datail').modal('toggle');
					// On page load: datatable
					var umb_table_qualification_skill = $('#umb_table_qualification_skill').dataTable({
						"bDestroy": true,
						"bFilter": false,
						"iDisplayLength": 5,
						"aLengthMenu": [[5, 10, 30, 50, 100, -1], [5, 10, 30, 50, 100, "All"]],
						"ajax": {
							url : "<?php echo site_url("admin/settings/list_qualification_skill") ?>",
							type : 'GET'
						},
						"fnDrawCallback": function(settings){
							$('[data-toggle="tooltip"]').tooltip();          
						}			
					});
					umb_table_qualification_skill.api().ajax.reload(function(){ 
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
<?php } else if(isset($_GET['jd']) && isset($_GET['field_id']) && $_GET['data']=='ed_type_award' && $_GET['type']=='ed_type_award'){
	$row = $this->Umb_model->read_type_award($_GET['field_id']);
	?>
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
		<h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_edit_type_award');?></h4>
	</div>
	<?php $attributes = array('name' => 'ed_info_type_award', 'id' => 'ed_info_type_award', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
	<?php $hidden = array('_method' => 'EDIT', '_token' => $row[0]->type_award_id, 'ext_name' => $row[0]->type_award);?>
	<?php echo form_open('admin/settings/update_type_award/'.$row[0]->type_award_id, $attributes, $hidden);?>
	<div class="modal-body">
		
		<div class="form-group">
			<label for="name" class="form-control-label"><?php echo $this->lang->line('umb_type_award');?>:</label>
			<input type="text" class="form-control" name="name" placeholder="<?php echo $this->lang->line('umb_type_award');?>" value="<?php echo $row[0]->type_award;?>">
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
			/* Edit data */
			$("#ed_info_type_award").submit(function(e){
				
				e.preventDefault();
				var obj = $(this), action = obj.attr('name');
				$('.save').prop('disabled', true);
				$.ajax({
					type: "POST",
					url: e.target.action,
					data: obj.serialize()+"&is_ajax=38&type=edit_record&data=ed_info_type_award&form="+action,
					cache: false,
					success: function (JSON) {
						if (JSON.error != '') {
							toastr.error(JSON.error);
							$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
							$('.save').prop('disabled', false);
							Ladda.stopAll();
						} else {
							$('.edit_setting_datail').modal('toggle');
					// On page load: datatable
					var umb_table_type_award = $('#umb_table_type_award').dataTable({
						"bDestroy": true,
						"bFilter": false,
						"iDisplayLength": 5,
						"aLengthMenu": [[5, 10, 30, 50, 100, -1], [5, 10, 30, 50, 100, "All"]],
						"ajax": {
							url : "<?php echo site_url("admin/settings/list_type_award") ?>",
							type : 'GET'
						},
						"fnDrawCallback": function(settings){
							$('[data-toggle="tooltip"]').tooltip();          
						}			
					}); 
					umb_table_type_award.api().ajax.reload(function(){ 
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
<?php } else if(isset($_GET['jd']) && isset($_GET['field_id']) && $_GET['data']=='ed_type_cuti' && $_GET['type']=='ed_type_cuti'){
	$row = $this->Umb_model->read_type_cuti($_GET['field_id']);
	?>
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
		<h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_edit_type_cuti');?></h4>
	</div>
	<?php $attributes = array('name' => 'ed_info_type_cuti', 'id' => 'ed_info_type_cuti', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
	<?php $hidden = array('_method' => 'EDIT', '_token' => $row[0]->type_cuti_id, 'ext_name' => $row[0]->type_name);?>
	<?php echo form_open('admin/settings/update_type_cuti/'.$row[0]->type_cuti_id, $attributes, $hidden);?>
	<div class="modal-body">
		
		<div class="form-group">
			<label for="name" class="form-control-label"><?php echo $this->lang->line('umb_type_cuti');?>:</label>
			<input type="text" class="form-control" name="name" placeholder="<?php echo $this->lang->line('umb_type_cuti');?>" value="<?php echo $row[0]->type_name;?>">
		</div>
		<div class="form-group">
			<label for="days_per_year" class="form-control-label"><?php echo $this->lang->line('umb_days_per_year');?>:</label>
			<input type="text" class="form-control" name="days_per_year" placeholder="<?php echo $this->lang->line('umb_days_per_year');?>" value="<?php echo $row[0]->days_per_year?>">
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
			/* Edit data */
			$("#ed_info_type_cuti").submit(function(e){
				
				e.preventDefault();
				var obj = $(this), action = obj.attr('name');
				$('.save').prop('disabled', true);
				$.ajax({
					type: "POST",
					url: e.target.action,
					data: obj.serialize()+"&is_ajax=39&type=edit_record&data=ed_info_type_cuti&form="+action,
					cache: false,
					success: function (JSON) {
						if (JSON.error != '') {
							toastr.error(JSON.error);
							$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
							$('.save').prop('disabled', false);
							Ladda.stopAll();
						} else {
							$('.edit_setting_datail').modal('toggle');
					// On page load: datatable
					var umb_table_type_cuti = $('#umb_table_type_cuti').dataTable({
						"bDestroy": true,
						"bFilter": false,
						"iDisplayLength": 5,
						"aLengthMenu": [[5, 10, 30, 50, 100, -1], [5, 10, 30, 50, 100, "All"]],
						"ajax": {
							url : "<?php echo site_url("admin/settings/list_type_cuti") ?>",
							type : 'GET'
						},
						"fnDrawCallback": function(settings){
							$('[data-toggle="tooltip"]').tooltip();          
						}			
					});
					umb_table_type_cuti.api().ajax.reload(function(){ 
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
<?php } else if(isset($_GET['jd']) && isset($_GET['field_id']) && $_GET['data']=='ed_type_peringatan' && $_GET['type']=='ed_type_peringatan'){
	$row = $this->Umb_model->read_type_peringatan($_GET['field_id']);
	?>
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
		<h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_edit_type_peringatan');?></h4>
	</div>
	<?php $attributes = array('name' => 'ed_info_type_peringatan', 'id' => 'ed_info_type_peringatan', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
	<?php $hidden = array('_method' => 'EDIT', '_token' => $row[0]->type_peringatan_id, 'ext_name' => $row[0]->type);?>
	<?php echo form_open('admin/settings/update_type_peringatan/'.$row[0]->type_peringatan_id, $attributes, $hidden);?>
	<div class="modal-body">
		
		<div class="form-group">
			<label for="name" class="form-control-label"><?php echo $this->lang->line('umb_type_peringatan');?>:</label>
			<input type="text" class="form-control" name="name" placeholder="<?php echo $this->lang->line('umb_type_peringatan');?>" value="<?php echo $row[0]->type;?>">
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
			/* Edit data */
			$("#ed_info_type_peringatan").submit(function(e){
				
				e.preventDefault();
				var obj = $(this), action = obj.attr('name');
				$('.save').prop('disabled', true);
				$.ajax({
					type: "POST",
					url: e.target.action,
					data: obj.serialize()+"&is_ajax=40&type=edit_record&data=ed_info_type_peringatan&form="+action,
					cache: false,
					success: function (JSON) {
						if (JSON.error != '') {
							toastr.error(JSON.error);
							$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
							$('.save').prop('disabled', false);
							Ladda.stopAll();
						} else {
							$('.edit_setting_datail').modal('toggle');
					// On page load: datatable
					var umb_table_type_peringatan = $('#umb_table_type_peringatan').dataTable({
						"bDestroy": true,
						"bFilter": false,
						"iDisplayLength": 5,
						"aLengthMenu": [[5, 10, 30, 50, 100, -1], [5, 10, 30, 50, 100, "All"]],
						"ajax": {
							url : "<?php echo site_url("admin/settings/list_type_peringatan") ?>",
							type : 'GET'
						},
						"fnDrawCallback": function(settings){
							$('[data-toggle="tooltip"]').tooltip();          
						}			
					});
					umb_table_type_peringatan.api().ajax.reload(function(){ 
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
<?php } else if(isset($_GET['jd']) && isset($_GET['field_id']) && $_GET['data']=='ed_type_penghentian' && $_GET['type']=='ed_type_penghentian'){
	$row = $this->Umb_model->read_type_penghentian($_GET['field_id']);
	?>
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
		<h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_edit_type_penghentian');?></h4>
	</div>
	<?php $attributes = array('name' => 'ed_info_type_penghentian', 'id' => 'ed_info_type_penghentian', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
	<?php $hidden = array('_method' => 'EDIT', '_token' => $row[0]->type_penghentian_id, 'ext_name' => $row[0]->type);?>
	<?php echo form_open('admin/settings/update_type_penghentian/'.$row[0]->type_penghentian_id, $attributes, $hidden);?>
	<div class="modal-body">
		
		<div class="form-group">
			<label for="name" class="form-control-label"><?php echo $this->lang->line('umb_type_penghentian');?>:</label>
			<input type="text" class="form-control" name="name" placeholder="<?php echo $this->lang->line('umb_type_penghentian');?>" value="<?php echo $row[0]->type;?>">
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
			/* Edit data */
			$("#ed_info_type_penghentian").submit(function(e){
				
				e.preventDefault();
				var obj = $(this), action = obj.attr('name');
				$('.save').prop('disabled', true);
				$.ajax({
					type: "POST",
					url: e.target.action,
					data: obj.serialize()+"&is_ajax=41&type=edit_record&data=ed_info_type_penghentian&form="+action,
					cache: false,
					success: function (JSON) {
						if (JSON.error != '') {
							toastr.error(JSON.error);
							$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
							$('.save').prop('disabled', false);
							Ladda.stopAll();
						} else {
							$('.edit_setting_datail').modal('toggle');
					// On page load: datatable
					var umb_table_type_penghentian = $('#umb_table_type_penghentian').dataTable({
						"bDestroy": true,
						"bFilter": false,
						"iDisplayLength": 5,
						"aLengthMenu": [[5, 10, 30, 50, 100, -1], [5, 10, 30, 50, 100, "All"]],
						"ajax": {
							url : "<?php echo site_url("admin/settings/list_type_penghentian") ?>",
							type : 'GET'
						},
						"fnDrawCallback": function(settings){
							$('[data-toggle="tooltip"]').tooltip();          
						}			
					}); 
					umb_table_type_penghentian.api().ajax.reload(function(){ 
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
<?php } else if(isset($_GET['jd']) && isset($_GET['field_id']) && $_GET['data']=='ed_type_biaya' && $_GET['type']=='ed_type_biaya'){
	$row = $this->Umb_model->read_type_biaya($_GET['field_id']);
	?>
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
		<h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_edit_type_biaya');?></h4>
	</div>
	<?php $attributes = array('name' => 'ed_info_type_biaya', 'id' => 'ed_info_type_biaya', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
	<?php $hidden = array('_method' => 'EDIT', '_token' => $row[0]->type_biaya_id, 'ext_name' => $row[0]->name);?>
	<?php echo form_open('admin/settings/update_type_biaya/'.$row[0]->type_biaya_id, $attributes, $hidden);?>
	<div class="modal-body">
		<div class="form-group">
			<label for="nama_perusahaan"><?php echo $this->lang->line('module_title_perusahaan');?></label>
			<select class="form-control" name="perusahaan" id="aj_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_title_perusahaan');?>">
				<option value=""><?php echo $this->lang->line('umb_select_one');?></option>
				<?php foreach($this->Umb_model->get_perusahaans() as $perusahaan) {?>
					<option value="<?php echo $perusahaan->perusahaan_id;?>" <?php if($perusahaan->perusahaan_id==$row[0]->perusahaan_id):?> selected="selected"<?php endif;?>> <?php echo $perusahaan->name;?></option>
				<?php } ?>
			</select>
		</div>
		<div class="form-group">
			<label for="name" class="form-control-label"><?php echo $this->lang->line('umb_type_biaya');?>:</label>
			<input type="text" class="form-control" name="name" placeholder="<?php echo $this->lang->line('umb_type_biaya');?>" value="<?php echo $row[0]->name;?>">
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
			/* Edit data */
			$("#ed_info_type_biaya").submit(function(e){
				
				e.preventDefault();
				var obj = $(this), action = obj.attr('name');
				$('.save').prop('disabled', true);
				$.ajax({
					type: "POST",
					url: e.target.action,
					data: obj.serialize()+"&is_ajax=42&type=edit_record&data=ed_info_type_biaya&form="+action,
					cache: false,
					success: function (JSON) {
						if (JSON.error != '') {
							toastr.error(JSON.error);
							$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
							$('.save').prop('disabled', false);
							Ladda.stopAll();
						} else {
							$('.edit_setting_datail').modal('toggle');
					// On page load: datatable
					var umb_table_type_biaya = $('#umb_table_type_biaya').dataTable({
						"bDestroy": true,
						"bFilter": false,
						"iDisplayLength": 5,
						"aLengthMenu": [[5, 10, 30, 50, 100, -1], [5, 10, 30, 50, 100, "All"]],
						"ajax": {
							url : "<?php echo site_url("admin/settings/list_type_biaya") ?>",
							type : 'GET'
						},
						"fnDrawCallback": function(settings){
							$('[data-toggle="tooltip"]').tooltip();          
						}			
					});
					umb_table_type_biaya.api().ajax.reload(function(){ 
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
<?php } else if(isset($_GET['jd']) && isset($_GET['field_id']) && $_GET['data']=='ed_type_pekerjaan' && $_GET['type']=='ed_type_pekerjaan'){
	$row = $this->Umb_model->read_type_pekerjaan($_GET['field_id']);
	?>
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
		<h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_edit_type_pekerjaan');?></h4>
	</div>
	<?php $attributes = array('name' => 'ed_info_type_pekerjaan', 'id' => 'ed_info_type_pekerjaan', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
	<?php $hidden = array('_method' => 'EDIT', '_token' => $row[0]->type_pekerjaan_id, 'ext_name' => $row[0]->type);?>
	<?php echo form_open('admin/settings/update_type_pekerjaan/'.$row[0]->type_pekerjaan_id, $attributes, $hidden);?>
	<div class="modal-body">
		
		<div class="form-group">
			<label for="name" class="form-control-label"><?php echo $this->lang->line('umb_type_pekerjaan');?>:</label>
			<input type="text" class="form-control" name="name" placeholder="<?php echo $this->lang->line('umb_type_pekerjaan');?>" value="<?php echo $row[0]->type;?>">
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
			/* Edit data */
			$("#ed_info_type_pekerjaan").submit(function(e){
				
				e.preventDefault();
				var obj = $(this), action = obj.attr('name');
				$('.save').prop('disabled', true);
				$.ajax({
					type: "POST",
					url: e.target.action,
					data: obj.serialize()+"&is_ajax=43&type=edit_record&data=ed_info_type_pekerjaan&form="+action,
					cache: false,
					success: function (JSON) {
						if (JSON.error != '') {
							toastr.error(JSON.error);
							$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
							$('.save').prop('disabled', false);
							Ladda.stopAll();
						} else {
							$('.edit_setting_datail').modal('toggle');
					// On page load: datatable
					var umb_table_type_pekerjaan = $('#umb_table_type_pekerjaan').dataTable({
						"bDestroy": true,
						"bFilter": false,
						"iDisplayLength": 5,
						"aLengthMenu": [[5, 10, 30, 50, 100, -1], [5, 10, 30, 50, 100, "All"]],
						"ajax": {
							url : "<?php echo site_url("admin/settings/list_type_pekerjaan") ?>",
							type : 'GET'
						},
						"fnDrawCallback": function(settings){
							$('[data-toggle="tooltip"]').tooltip();          
						}			
					});
					umb_table_type_pekerjaan.api().ajax.reload(function(){ 
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
<?php } else if(isset($_GET['jd']) && isset($_GET['field_id']) && $_GET['data']=='ed_kategori_pekerjaan' && $_GET['type']=='ed_kategori_pekerjaan'){
	$row = $this->Umb_model->read_kategori_pekerjaan($_GET['field_id']);
	?>
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
		<h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_rec_edit_kategori_pekerjaan');?></h4>
	</div>
	<?php $attributes = array('name' => 'ed_info_kategori_pekerjaan', 'id' => 'ed_info_kategori_pekerjaan', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
	<?php $hidden = array('_method' => 'EDIT', '_token' => $row[0]->kategori_id, 'ext_name' => $row[0]->nama_kategori);?>
	<?php echo form_open('admin/settings/update_kategori_pekerjaan/'.$row[0]->kategori_id, $attributes, $hidden);?>
	<div class="modal-body">
		
		<div class="form-group">
			<label for="kategori_pekerjaan" class="form-control-label"><?php echo $this->lang->line('umb_rec_kategori_pekerjaan');?>:</label>
			<input type="text" class="form-control" name="kategori_pekerjaan" placeholder="<?php echo $this->lang->line('umb_rec_kategori_pekerjaan');?>" value="<?php echo $row[0]->nama_kategori;?>">
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
			/* Edit data */
			$("#ed_info_kategori_pekerjaan").submit(function(e){
				
				e.preventDefault();
				var obj = $(this), action = obj.attr('name');
				$('.save').prop('disabled', true);
				$.ajax({
					type: "POST",
					url: e.target.action,
					data: obj.serialize()+"&is_ajax=43&type=edit_record&data=ed_info_kategori_pekerjaan&form="+action,
					cache: false,
					success: function (JSON) {
						if (JSON.error != '') {
							toastr.error(JSON.error);
							$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
							$('.save').prop('disabled', false);
							Ladda.stopAll();
						} else {
							$('.edit_setting_datail').modal('toggle');
					// On page load: datatable
					var umb_table_kategori_pekerjaan = $('#umb_table_kategori_pekerjaan').dataTable({
						"bDestroy": true,
						"bFilter": false,
						"iDisplayLength": 15,
						"aLengthMenu": [[15, 30, 50, 75, 100, -1], [15, 30, 50,75, 100, "All"]],
						"ajax": {
							url : "<?php echo site_url("admin/settings/list_kategori_pekerjaan") ?>",
							type : 'GET'
						},
						"fnDrawCallback": function(settings){
							$('[data-toggle="tooltip"]').tooltip();          
						}			
					});
					umb_table_kategori_pekerjaan.api().ajax.reload(function(){ 
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
<?php } else if(isset($_GET['jd']) && isset($_GET['field_id']) && $_GET['data']=='ed_type_exit' && $_GET['type']=='ed_type_exit'){
	$row = $this->Umb_model->read_type_exit($_GET['field_id']);
	?>
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
		<h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_edit_karyawan_type_exit');?></h4>
	</div>
	<?php $attributes = array('name' => 'ed_info_type_exit', 'id' => 'ed_info_type_exit', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
	<?php $hidden = array('_method' => 'EDIT', '_token' => $row[0]->type_exit_id, 'ext_name' => $row[0]->type);?>
	<?php echo form_open('admin/settings/update_type_exit/'.$row[0]->type_exit_id, $attributes, $hidden);?>
	<div class="modal-body">
		
		<div class="form-group">
			<label for="name" class="form-control-label"><?php echo $this->lang->line('umb_karyawan_type_exit');?>:</label>
			<input type="text" class="form-control" name="name" placeholder="<?php echo $this->lang->line('umb_karyawan_type_exit');?>" value="<?php echo $row[0]->type;?>">
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
			/* Edit data */
			$("#ed_info_type_exit").submit(function(e){
				
				e.preventDefault();
				var obj = $(this), action = obj.attr('name');
				$('.save').prop('disabled', true);
				$.ajax({
					type: "POST",
					url: e.target.action,
					data: obj.serialize()+"&is_ajax=44&type=edit_record&data=ed_info_type_exit&form="+action,
					cache: false,
					success: function (JSON) {
						if (JSON.error != '') {
							toastr.error(JSON.error);
							$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
							$('.save').prop('disabled', false);
							Ladda.stopAll();
						} else {
							$('.edit_setting_datail').modal('toggle');
					// On page load: datatable
					var umb_table_type_exit = $('#umb_table_type_exit').dataTable({
						"bDestroy": true,
						"bFilter": false,
						"iDisplayLength": 5,
						"aLengthMenu": [[5, 10, 30, 50, 100, -1], [5, 10, 30, 50, 100, "All"]],
						"ajax": {
							url : "<?php echo site_url("admin/settings/list_type_exit") ?>",
							type : 'GET'
						},
						"fnDrawCallback": function(settings){
							$('[data-toggle="tooltip"]').tooltip();          
						}			
					});
					umb_table_type_exit.api().ajax.reload(function(){ 
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
<?php } else if(isset($_GET['jd']) && isset($_GET['field_id']) && $_GET['data']=='ed_type_pngtrn_perjalanan' && $_GET['type']=='ed_type_pngtrn_perjalanan'){
	$row = $this->Umb_model->read_type_pngtrn_perjalanan($_GET['field_id']);
	?>
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
		<h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_type_pngtrn_perjalanan');?></h4>
	</div>
	<?php $attributes = array('name' => 'ed_info_type_pngtrn_perjalanan', 'id' => 'ed_info_type_pngtrn_perjalanan', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
	<?php $hidden = array('_method' => 'EDIT', '_token' => $row[0]->type_pengaturan_id, 'ext_name' => $row[0]->type);?>
	<?php echo form_open('admin/settings/update_type_pngtrn_perjalanan/'.$row[0]->type_pengaturan_id, $attributes, $hidden);?>
	<div class="modal-body">
		
		<div class="form-group">
			<label for="name" class="form-control-label"><?php echo $this->lang->line('umb_type_pengaturan_perjalanan');?>:</label>
			<input type="text" class="form-control" name="name" placeholder="<?php echo $this->lang->line('umb_type_pengaturan_perjalanan');?>" value="<?php echo $row[0]->type;?>">
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
			/* Edit data */
			$("#ed_info_type_pngtrn_perjalanan").submit(function(e){
				
				e.preventDefault();
				var obj = $(this), action = obj.attr('name');
				$('.save').prop('disabled', true);
				$.ajax({
					type: "POST",
					url: e.target.action,
					data: obj.serialize()+"&is_ajax=46&type=edit_record&data=ed_info_type_pngtrn_perjalanan&form="+action,
					cache: false,
					success: function (JSON) {
						if (JSON.error != '') {
							toastr.error(JSON.error);
							$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
							$('.save').prop('disabled', false);
							Ladda.stopAll();
						} else {
							$('.edit_setting_datail').modal('toggle');
					// On page load: datatable
					var umb_table_type_pngtrn_perjalanan = $('#umb_table_type_pngtrn_perjalanan').dataTable({
						"bDestroy": true,
						"bFilter": false,
						"iDisplayLength": 5,
						"aLengthMenu": [[5, 10, 30, 50, 100, -1], [5, 10, 30, 50, 100, "All"]],
						"ajax": {
							url : "<?php echo site_url("admin/settings/list_type_pngtrn_perjalanan") ?>",
							type : 'GET'
						},
						"fnDrawCallback": function(settings){
							$('[data-toggle="tooltip"]').tooltip();          
						}			
					});
					umb_table_type_pngtrn_perjalanan.api().ajax.reload(function(){ 
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
<?php } else if(isset($_GET['jd']) && isset($_GET['field_id']) && $_GET['data']=='ed_type_currency' && $_GET['type']=='ed_type_currency'){
	$row = $this->Umb_model->read_types_currency($_GET['field_id']);
	?>
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
		<h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_edit_type_currency');?></h4>
	</div>
	<?php $attributes = array('name' => 'ed_info_type_currency', 'id' => 'ed_info_type_currency', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
	<?php $hidden = array('_method' => 'EDIT', '_token' => $row[0]->currency_id, 'ext_name' => $row[0]->name);?>
	<?php echo form_open('admin/settings/update_type_currency/'.$row[0]->currency_id, $attributes, $hidden);?>
	<div class="modal-body">
		
		<div class="form-group">
			<label for="name"><?php echo $this->lang->line('umb_currency_name');?></label>
			<input type="text" class="form-control" name="name" placeholder="<?php echo $this->lang->line('umb_currency_name');?>" value="<?php echo $row[0]->name;?>">
		</div>
		<div class="form-group">
			<label for="name"><?php echo $this->lang->line('umb_currency_code');?></label>
			<input type="text" class="form-control" name="code" placeholder="<?php echo $this->lang->line('umb_currency_code');?>" value="<?php echo $row[0]->code;?>">
		</div>
		<div class="form-group">
			<label for="name"><?php echo $this->lang->line('umb_currency_symbol');?></label>
			<input type="text" class="form-control" name="symbol" placeholder="<?php echo $this->lang->line('umb_currency_symbol');?>" value="<?php echo $row[0]->symbol;?>">
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
			/* Edit data */
			$("#ed_info_type_currency").submit(function(e){
				
				e.preventDefault();
				var obj = $(this), action = obj.attr('name');
				$('.save').prop('disabled', true);
				$.ajax({
					type: "POST",
					url: e.target.action,
					data: obj.serialize()+"&is_ajax=46&type=edit_record&data=ed_info_type_currency&form="+action,
					cache: false,
					success: function (JSON) {
						if (JSON.error != '') {
							toastr.error(JSON.error);
							$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
							$('.save').prop('disabled', false);
							Ladda.stopAll();
						} else {
							$('.edit_setting_datail').modal('toggle');
					// On page load: datatable
					var umb_table_type_currency = $('#umb_table_type_currency').dataTable({
						"bDestroy": true,
						"bFilter": false,
						"iDisplayLength": 5,
						"aLengthMenu": [[5, 10, 30, 50, 100, -1], [5, 10, 30, 50, 100, "All"]],
						"ajax": {
							url : "<?php echo site_url("admin/settings/list_type_currency") ?>",
							type : 'GET'
						},
						"fnDrawCallback": function(settings){
							$('[data-toggle="tooltip"]').tooltip();          
						}			
					});
					umb_table_type_currency.api().ajax.reload(function(){ 
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
<?php } else if(isset($_GET['jd']) && isset($_GET['field_id']) && $_GET['data']=='ed_type_perusahaan' && $_GET['type']=='ed_type_perusahaan'){
	$row = $this->Umb_model->read_type_perusahaan($_GET['field_id']);
	?>
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
		<h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_edit_type_perusahaan');?></h4>
	</div>
	<?php $attributes = array('name' => 'ed_info_type_perusahaan', 'id' => 'ed_info_type_perusahaan', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
	<?php $hidden = array('_method' => 'EDIT', '_token' => $row[0]->type_id, 'ext_name' => $row[0]->name);?>
	<?php echo form_open('admin/settings/update_type_perusahaan/'.$row[0]->type_id, $attributes, $hidden);?>
	<div class="modal-body">
		<div class="form-group">
			<label for="name" class="form-control-label"><?php echo $this->lang->line('umb_type_perusahaan');?>:</label>
			<input type="text" class="form-control" name="name" placeholder="<?php echo $this->lang->line('umb_type_perusahaan');?>" value="<?php echo $row[0]->name;?>">
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
			/* Edit data */
			$("#ed_info_type_perusahaan").submit(function(e){
				
				e.preventDefault();
				var obj = $(this), action = obj.attr('name');
				$('.save').prop('disabled', true);
				$.ajax({
					type: "POST",
					url: e.target.action,
					data: obj.serialize()+"&is_ajax=46&type=edit_record&data=ed_info_type_perusahaan&form="+action,
					cache: false,
					success: function (JSON) {
						if (JSON.error != '') {
							toastr.error(JSON.error);
							$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
							$('.save').prop('disabled', false);
							Ladda.stopAll();
						} else {
							$('.edit_setting_datail').modal('toggle');
					// On page load: datatable
					var umb_table_type_perusahaan = $('#umb_table_type_perusahaan').dataTable({
						"bDestroy": true,
						"bFilter": false,
						"iDisplayLength": 5,
						"aLengthMenu": [[5, 10, 30, 50, 100, -1], [5, 10, 30, 50, 100, "All"]],
						"ajax": {
							url : "<?php echo site_url("admin/settings/list_type_perusahaan") ?>",
							type : 'GET'
						},
						"fnDrawCallback": function(settings){
							$('[data-toggle="tooltip"]').tooltip();          
						}			
					});
					umb_table_type_perusahaan.api().ajax.reload(function(){ 
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
<?php } else if(isset($_GET['jd']) && isset($_GET['field_id']) && $_GET['data']=='ed_security_level' && $_GET['type']=='ed_security_level'){
	$row = $this->Umb_model->read_security_level($_GET['field_id']);
	?>
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
		<h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_edit_security_level');?></h4>
	</div>
	<?php $attributes = array('name' => 'ed_info_security_level', 'id' => 'ed_info_security_level', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
	<?php $hidden = array('_method' => 'EDIT', '_token' => $row[0]->type_id, 'ext_name' => $row[0]->name);?>
	<?php echo form_open('admin/settings/update_security_level/'.$row[0]->type_id, $attributes, $hidden);?>
	<div class="modal-body">
		<div class="form-group">
			<label for="name" class="form-control-label"><?php echo $this->lang->line('umb_security_level');?>:</label>
			<input type="text" class="form-control" name="security_level" placeholder="<?php echo $this->lang->line('umb_security_level');?>" value="<?php echo $row[0]->name;?>">
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
			/* Edit data */
			$("#ed_info_security_level").submit(function(e){
				
				e.preventDefault();
				var obj = $(this), action = obj.attr('name');
				$('.save').prop('disabled', true);
				$.ajax({
					type: "POST",
					url: e.target.action,
					data: obj.serialize()+"&is_ajax=46&type=edit_record&data=ed_info_security_level&form="+action,
					cache: false,
					success: function (JSON) {
						if (JSON.error != '') {
							toastr.error(JSON.error);
							$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
							$('.save').prop('disabled', false);
							Ladda.stopAll();
						} else {
							$('.edit_setting_datail').modal('toggle');
					// On page load: datatable
					var eumb_table_security_level = $('#umb_table_security_level').dataTable({
						"bDestroy": true,
						"bFilter": false,
						"iDisplayLength": 5,
						"aLengthMenu": [[5, 10, 30, 50, 100, -1], [5, 10, 30, 50, 100, "All"]],
						"ajax": {
							url : "<?php echo site_url("admin/settings/list_security_level") ?>",
							type : 'GET'
						},
						"fnDrawCallback": function(settings){
							$('[data-toggle="tooltip"]').tooltip();          
						}			
					});
					eumb_table_security_level.api().ajax.reload(function(){ 
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
<?php } else if(isset($_GET['jd']) && isset($_GET['user_id']) && $_GET['data']=='password' && $_GET['type']=='password'){?>
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
		<h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('header_change_password');?></h4>
	</div>
	<?php $attributes = array('name' => 'e_change_password', 'id' => 'profile_password', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
	<?php $hidden = array('_method' => 'EDIT', 'user_id' => $_GET['user_id']);?>
	<?php echo form_open('admin/karyawans/change_password/'.$row[0]->currency_id, $attributes, $hidden);?>
	<div class="modal-body">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="new_password"><?php echo $this->lang->line('umb_e_details_enpassword');?></label>
					<input class="form-control" placeholder="<?php echo $this->lang->line('umb_e_details_enpassword');?>" name="new_password" type="text">
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="new_password_confirm" class="control-label"><?php echo $this->lang->line('umb_e_details_ecnpassword');?></label>
					<input class="form-control" placeholder="<?php echo $this->lang->line('umb_e_details_ecnpassword');?>" name="new_password_confirm" type="text">
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
			
			Ladda.bind('button[type=submit]');
			/* change password */
			jQuery("#profile_password").submit(function(e){
				
				e.preventDefault();
				var obj = jQuery(this), action = obj.attr('name');
				jQuery('.save').prop('disabled', true);
				jQuery.ajax({
					type: "POST",
					url: e.target.action,
					data: obj.serialize()+"&is_ajax=31&data=e_change_password&type=change_password&form="+action,
					cache: false,
					success: function (JSON) {
						if (JSON.error != '') {
							toastr.error(JSON.error);
							$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
							jQuery('.save').prop('disabled', false);
							Ladda.stopAll();
						} else {
							$('.pro_change_password').modal('toggle');
							toastr.success(JSON.result);
							$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
							jQuery('#profile_password')[0].reset(); 
							jQuery('.save').prop('disabled', false);
							Ladda.stopAll();
						}
					}
				});
			});
		});	
	</script>
<?php } else if(isset($_GET['jd']) && isset($_GET['field_id']) && $_GET['data']=='ed_type_sukubangsa' && $_GET['type']=='ed_type_sukubangsa'){
	$row = $this->Umb_model->read_type_sukubangsa($_GET['field_id']);
	?>
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
		<h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_edit_type_sukubangsa');?></h4>
	</div>
	<?php $attributes = array('name' => 'ed_info_type_sukubangsa', 'id' => 'ed_info_type_sukubangsa', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
	<?php $hidden = array('_method' => 'EDIT', '_token' => $row[0]->type_sukubangsa_id, 'ext_name' => $row[0]->type);?>
	<?php echo form_open('admin/settings/update_type_sukubangsa/'.$row[0]->type_sukubangsa_id, $attributes, $hidden);?>
	<div class="modal-body">
		
		<div class="form-group">
			<label for="name" class="form-control-label"><?php echo $this->lang->line('umb_type_sukubangsa_title');?>:</label>
			<input type="text" class="form-control" name="type_sukubangsa" placeholder="<?php echo $this->lang->line('umb_type_sukubangsa_title');?>" value="<?php echo $row[0]->type?>">
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
			/* Edit data */
			$("#ed_info_type_sukubangsa").submit(function(e){
				
				e.preventDefault();
				var obj = $(this), action = obj.attr('name');
				$('.save').prop('disabled', true);
				$.ajax({
					type: "POST",
					url: e.target.action,
					data: obj.serialize()+"&is_ajax=22&type=edit_record&data=ed_info_type_sukubangsa&form="+action,
					cache: false,
					success: function (JSON) {
						if (JSON.error != '') {
							toastr.error(JSON.error);
							$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
							$('.save').prop('disabled', false);
							Ladda.stopAll();
						} else {
							$('.edit_setting_datail').modal('toggle');
					// On page load: datatable
					var umb_table_type_sukubangsa = $('#umb_table_type_sukubangsa').dataTable({
						"bDestroy": true,
						"bFilter": false,
						"iDisplayLength": 5,
						"aLengthMenu": [[5, 10, 30, 50, 100, -1], [5, 10, 30, 50, 100, "All"]],
						"ajax": {
							url : "<?php echo site_url("admin/settings/list_type_sukubangsa") ?>",
							type : 'GET'
						},
						"fnDrawCallback": function(settings){
							$('[data-toggle="tooltip"]').tooltip();          
						}			
					});	
					umb_table_type_sukubangsa.api().ajax.reload(function(){ 
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
<?php } else if(isset($_GET['jd']) && isset($_GET['field_id']) && $_GET['data']=='ed_type_pendapatan' && $_GET['type']=='ed_type_pendapatan'){
	$row = $this->Umb_model->read_type_pendapatan($_GET['field_id']);
	?>
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
		<h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_edit_type_pendapatan');?></h4>
	</div>
	<?php $attributes = array('name' => 'ed_info_type_pendapatan', 'id' => 'ed_info_type_pendapatan', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
	<?php $hidden = array('_method' => 'EDIT', '_token' => $row[0]->kategori_id, 'ext_name' => $row[0]->name);?>
	<?php echo form_open('admin/settings/update_type_pendapatan/'.$row[0]->kategori_id, $attributes, $hidden);?>
	<div class="modal-body">
		
		<div class="form-group">
			<label for="type_pendapatan" class="form-control-label"><?php echo $this->lang->line('umb_type_pendapatan');?>:</label>
			<input type="text" class="form-control" name="type_pendapatan" placeholder="<?php echo $this->lang->line('umb_type_pendapatan');?>" value="<?php echo $row[0]->name?>">
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
			/* Edit data */
			$("#ed_info_type_pendapatan").submit(function(e){
				
				e.preventDefault();
				var obj = $(this), action = obj.attr('name');
				$('.save').prop('disabled', true);
				$.ajax({
					type: "POST",
					url: e.target.action,
					data: obj.serialize()+"&is_ajax=22&type=edit_record&data=ed_info_type_pendapatan&form="+action,
					cache: false,
					success: function (JSON) {
						if (JSON.error != '') {
							toastr.error(JSON.error);
							$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
							$('.save').prop('disabled', false);
							Ladda.stopAll();
						} else {
							$('.edit_setting_datail').modal('toggle');
					// On page load: datatable
					var umb_table_type_pendapatan = $('#umb_table_type_pendapatan').dataTable({
						"bDestroy": true,
						"bFilter": false,
						"iDisplayLength": 5,
						"aLengthMenu": [[5, 10, 30, 50, 100, -1], [5, 10, 30, 50, 100, "All"]],
						"ajax": {
							url : "<?php echo site_url("admin/settings/list_type_pendapatan") ?>",
							type : 'GET'
						},
						"fnDrawCallback": function(settings){
							$('[data-toggle="tooltip"]').tooltip();          
						}			
					});	
					umb_table_type_pendapatan.api().ajax.reload(function(){ 
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
<?php } else if(isset($_GET['jd']) && isset($_GET['p']) && $_GET['data']=='kebijakan' && $_GET['type']=='kebijakan'){
	?>
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
		<h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_kebijakan_perusahaan');?></h4>
	</div>
	<div class="modal-body">
		<div class="form-group">
			<div id="accordion" role="tablist" aria-multiselectable="true">
				<?php foreach($this->Umb_model->all_kebijakans() as $_kebijakan):?>
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingOne">
							<h4 class="panel-title"> <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $_kebijakan->kebijakan_id;?>" aria-expanded="true" aria-controls="collapseOne">
								<?php
								if($_kebijakan->perusahaan_id==0){
									$cname = $this->lang->line('umb_all_perusahaans');
								} else {
									$perusahaan = $this->Umb_model->read_info_perusahaan($_kebijakan->perusahaan_id);
									if(!is_null($perusahaan)){
										$cname = $perusahaan[0]->name;
									} else {
										$cname = '--';
									}
								}
								?>
								<?php echo $_kebijakan->title;?> (<?php echo $cname;?>) </a> </h4>
							</div>
							<div id="collapse<?php echo $_kebijakan->kebijakan_id;?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne" style="margin:10px;"> <?php echo html_entity_decode($_kebijakan->description);?> </div>
						</div>
					<?php endforeach;?>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('umb_close');?></button>
		</div>
	<?php }
	?>
