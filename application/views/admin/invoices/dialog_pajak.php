<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(isset($_GET['jd']) && isset($_GET['pajak_id']) && $_GET['data']=='pajak'){ ?>

	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
		<h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_title_pajak_edit');?></h4>
	</div>
	<?php $attributes = array('name' => 'edit_pajak', 'id' => 'edit_pajak', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
	<?php $hidden = array('_method' => 'EDIT', '_token' => $pajak_id);?>
	<?php echo form_open('admin/invoices/update_pajak/'.$pajak_id, $attributes, $hidden);?>
	<div class="modal-body">
		<div class="form-group">
			<label for="nama_pajak"><?php echo $this->lang->line('umb_title_nama_pajak');?></label>
			<input type="text" class="form-control" name="nama_pajak" placeholder="<?php echo $this->lang->line('umb_title_nama_pajak');?>" value="<?php echo $name;?>">
		</div>
		<div class="form-group">
			<label for="nilai_pajak"><?php echo $this->lang->line('umb_title_nilai_pajak');?></label>
			<input type="text" class="form-control" name="nilai_pajak" placeholder="<?php echo $this->lang->line('umb_title_nilai_pajak');?>" value="<?php echo $rate;?>">
		</div>
		<div class="form-group">
			<label for="type_pajak"><?php echo $this->lang->line('umb_invoice_type_pajak');?></label>
			<select class="form-control" name="type_pajak" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_invoice_type_pajak');?>">
				<option value=""></option>
				<option value="fixed" <?php if($type=='fixed'){?> selected="selected"<?php } ?>><?php echo $this->lang->line('umb_title_fixed_pajak');?></option>
				<option value="percentage" <?php if($type=='percentage'){?> selected="selected"<?php } ?>><?php echo $this->lang->line('umb_title_percent_pajak');?></option>
			</select>
		</div>
		<div class="form-group">
			<label for="message"><?php echo $this->lang->line('umb_description');?></label>
			<textarea class="form-control" placeholder="<?php echo $this->lang->line('umb_description');?>" name="description" id="description2"><?php echo $description;?></textarea>
		</div>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('umb_close');?></button>
		<button type="submit" class="btn btn-primary"><?php echo $this->lang->line('umb_update');?></button>
	</div>
	<?php echo form_close(); ?> 
	<script type="text/javascript">
		$(document).ready(function(){

			var umb_table = $('#umb_table').dataTable({
				"bDestroy": true,
				"ajax": {
					url : "<?php echo site_url("admin/invoices/list_pajaks") ?>",
					type : 'GET'
				},
				"fnDrawCallback": function(settings){
					$('[data-toggle="tooltip"]').tooltip();          
				}
			});
			
			$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
			$('[data-plugin="select_hrm"]').select2({ width:'100%' });	 
			
			$("#edit_pajak").submit(function(e){

				e.preventDefault();
				var obj = $(this), action = obj.attr('name');
				$('.save').prop('disabled', true);
				$.ajax({
					type: "POST",
					url: e.target.action,
					data: obj.serialize()+"&is_ajax=2&edit_type=pajak&form="+action,
					cache: false,
					success: function (JSON) {
						if (JSON.error != '') {
							toastr.error(JSON.error);
							$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
							$('.save').prop('disabled', false);
						} else {
							$('.edit-modal-data').modal('toggle');
							umb_table.api().ajax.reload(function(){ 
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
<?php }
?>
