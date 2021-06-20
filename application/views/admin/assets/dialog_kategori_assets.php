<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(isset($_GET['jd']) && isset($_GET['kategori_assets_id']) && $_GET['data']=='kategori_assets'){ ?>
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"> 
			<span aria-hidden="true">×</span> 
		</button>
		<h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_edit_kategori_assets');?></h4>
	</div>
	<?php $attributes = array('name' => 'update_kategori_assets', 'id' => 'update_kategori_assets', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
	<?php $hidden = array('_method' => 'EDIT', '_token' => $kategori_assets_id, 'ext_name' => $nama_kategori);?>
	<?php echo form_open('admin/assets/update_kategori_assets/'.$kategori_assets_id, $attributes, $hidden);?>
	<div class="modal-body">
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label for="name"><?php echo $this->lang->line('umb_name');?></label>
					<input type="text" class="form-control" name="name" placeholder="<?php echo $this->lang->line('umb_name');?>" value="<?php echo $nama_kategori;?>">
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
			Ladda.bind('button[type=submit]');
			$("#update_kategori_assets").submit(function(e){
				e.preventDefault();
				var obj = $(this), action = obj.attr('name');
				$('.save').prop('disabled', true);
				$.ajax({
					type: "POST",
					url: e.target.action,
					data: obj.serialize()+"&is_ajax=1&edit_type=kategori_assets&form="+action,
					cache: false,
					success: function (JSON) {
						if (JSON.error != '') {
							toastr.error(JSON.error);
							$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
							$('.save').prop('disabled', false);
							Ladda.stopAll();
						} else {
							var umb_table = $('#umb_table').dataTable({
								"bDestroy": true,
								"ajax": {
									url : "<?php echo site_url("admin/assets/list_kategori") ?>",
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
<?php }
?>
