<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['karyawan_id']) && $_GET['data']=='add_kehadiran'){
	// get addd by > template
	$user = $this->Umb_model->read_user_info($_GET['karyawan_id']);
	$ful_name = $user[0]->first_name. ' '.$user[0]->last_name;
	?>

	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
		<h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_add_kehadiran_for');?> <?php echo $ful_name; ?></h4>
	</div>
	<?php $attributes = array('name' => 'add_kehadiran', 'id' => 'add_kehadiran', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
	<?php $hidden = array('_method' => 'ADD');?>
	<?php echo form_open('admin/timesheet/add_kehadiran/', $attributes, $hidden);?>
	<?php
	$data = array(
		'name'        => 'karyawan_id_m',
		'id'          => 'karyawan_id_m',
		'value'       => $_GET['karyawan_id'],
		'type'  		=> 'hidden',
		'class'       => 'form-control',
	);

	echo form_input($data);
	?>
	<div class="modal-body">
		<div class="row">
			<div class="col-md-12">
				<div class="form-group"> </div>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="date"><?php echo $this->lang->line('umb_tanggal_kehadiran');?></label>
							<input class="form-control prmtan_tanggal_kehadiran" placeholder="<?php echo $this->lang->line('umb_tanggal_kehadiran');?>" readonly="true" id="prmtan_tanggal_kehadiran" name="prmtan_tanggal_kehadiran" type="text">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="clock_in"><?php echo $this->lang->line('umb_office_in_time');?></label>
							<input class="form-control timepicker_m" placeholder="<?php echo $this->lang->line('umb_office_in_time');?>" readonly="true" id="clock_in_m" name="clock_in_m" type="text">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="clock_out"><?php echo $this->lang->line('umb_office_out_time');?></label>
							<input class="form-control timepicker_m" placeholder="<?php echo $this->lang->line('umb_office_out_time');?>" readonly="true" id="clock_out_m" name="clock_out_m" type="text">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('umb_close');?></button>
		<button type="submit" class="btn btn-primary"><?php echo $this->lang->line('umb_save');?></button>
	</div>
	<?php echo form_close(); ?>
	<script type="text/javascript">
		$(document).ready(function(){
			
		// Clock
		$('.timepicker_m').bootstrapMaterialDatePicker({
			date: false,
			format: 'HH:mm'
		});	 
		Ladda.bind('button[type=submit]');
		// Tanggal Kehadiran
		$('.prmtan_tanggal_kehadiran').bootstrapMaterialDatePicker({
			weekStart: 0,
			time: false,
			clearButton: true,
			format: 'YYYY-MM-DD'
		});	 
		
		/* Add kehadiran*/
		$("#add_kehadiran").submit(function(e){
			var prmtan_tanggal_kehadiran = $("#prmtan_tanggal_kehadiran").val();
			var krywn_id = $("#karyawan_id_m").val();
			var clock_in_m = $("#clock_in_m").val();
			var clock_out_m = $("#clock_out_m").val();
			if(prmtan_tanggal_kehadiran!='' && krywn_id!='' && clock_in_m!='' && clock_out_m!='') {
				var umb_table = $('#umb_table').dataTable({
					"bDestroy": true,
					"ajax": {
						url : "<?php echo site_url("admin/timesheet/list_update_kehadiran") ?>?karyawan_id="+krywn_id+"&tanggal_kehadiran="+prmtan_tanggal_kehadiran,
						type : 'GET'
					},
					"fnDrawCallback": function(settings){
						$('[data-toggle="tooltip"]').tooltip();          
					}
				});
			}
			
			e.preventDefault();
			var obj = $(this), action = obj.attr('name');
			$('.save').prop('disabled', true);
			$.ajax({
				type: "POST",
				url: e.target.action,
				data: obj.serialize()+"&is_ajax=4&add_type=kehadiran&form="+action,
				cache: false,
				success: function (JSON) {
					if (JSON.error != '') {
						toastr.error(JSON.error);
						$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
						$('.save').prop('disabled', false);
						Ladda.stopAll();
					} else {
						$('.add-modal-data').modal('toggle');
						umb_table.api().ajax.reload(function(){ 
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
<?php } else if(isset($_GET['jd']) && isset($_GET['kehadiran_id']) && $_GET['type']=='kehadiran' && $_GET['data']=='kehadiran'){?>
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
		<h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_edit_kehadiran_for');?> <?php echo $full_name;?></h4>
	</div>
	<?php $attributes = array('name' => 'edit_kehadiran', 'id' => 'edit_kehadiran', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
	<?php $hidden = array('_method' => 'EDIT', '_token' => $_GET['kehadiran_id']);?>
	<?php echo form_open('admin/timesheet/edit_kehadiran/'.$waktu_kehadiran_id, $attributes, $hidden);?>
	<?php
	$data = array(
		'name'        => 'emp_att',
		'id'          => 'emp_att',
		'value'       => $karyawan_id,
		'type'  		=> 'hidden',
		'class'       => 'form-control',
	);

	echo form_input($data);
	?>
	<div class="modal-body">
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label for="date"><?php echo $this->lang->line('umb_tanggal_kehadiran');?></label>
					<input class="form-control tanggal_kehadiran_e" placeholder="<?php echo $this->lang->line('umb_tanggal_kehadiran');?>" readonly="true" id="tanggal_kehadiran_e" name="tanggal_kehadiran_e" type="text" value="<?php echo $tanggal_kehadiran;?>">
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="clock_in"><?php echo $this->lang->line('umb_office_in_time');?></label>
							<input class="form-control timepicker" placeholder="<?php echo $this->lang->line('umb_office_in_time');?>" readonly="true" name="clock_in" type="text" value="<?php echo $clock_in;?>">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="clock_out"><?php echo $this->lang->line('umb_office_out_time');?></label>
							<input class="form-control timepicker" placeholder="<?php echo $this->lang->line('umb_office_out_time');?>" readonly="true" name="clock_out" type="text" value="<?php echo $clock_out;?>">
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
			
	// Clock	
	// Tanggal Kehadiran
	$('.tanggal_kehadiran_e').bootstrapMaterialDatePicker({
		weekStart: 0,
		time: false,
		clearButton: true,
		format: 'YYYY-MM-DD'
	});	 
	Ladda.bind('button[type=submit]'); 
	$('.timepicker').bootstrapMaterialDatePicker({
		date: false,
		format: 'HH:mm'
	});
	
	/* Edit kehadiran*/
	$("#edit_kehadiran").submit(function(e){
		var tanggal_kehadiran_e = $("#tanggal_kehadiran_e").val();
		var emp_att = $("#emp_att").val();
		var umb_table2 = $('#umb_table').dataTable({
			"bDestroy": true,
			"ajax": {
				url : "<?php echo site_url("admin/timesheet/list_update_kehadiran") ?>?karyawan_id="+emp_att+"&tanggal_kehadiran="+tanggal_kehadiran_e,
				type : 'GET'
			},
			"fnDrawCallback": function(settings){
				$('[data-toggle="tooltip"]').tooltip();          
			}
		});
		
		e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=3&edit_type=kehadiran&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
					Ladda.stopAll();
				} else {
					$('.edit-modal-data').modal('toggle');
					umb_table2.api().ajax.reload(function(){ 
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
<?php }
?>
