<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['kategori_tugas_id']) && $_GET['data']=='kategori_tugas'){
	?>

	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
		<h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_edit_kategori_tugas');?></h4>
	</div>
	<?php $attributes = array('name' => 'edit_type', 'id' => 'edit_type', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
	<?php $hidden = array('_method' => 'EDIT', '_token' => $kategori_tugas_id, 'ext_name' => $kategori_tugas_id);?>
	<?php echo form_open('admin/project/update_kategori_tugas/'.$kategori_tugas_id, $attributes, $hidden);?>
	<div class="modal-body">
		<div class="form-group">
			<label for="nama_kategori" class="form-control-label"><?php echo $this->lang->line('umb_kategori_tugas');?></label>
			<input type="text" class="form-control" name="nama_kategori" value="<?php echo $nama_kategori?>" placeholder="<?php echo $this->lang->line('umb_kategori_tugas');?>">
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
			/* Edit data */
			$("#edit_type").submit(function(e){
				
				e.preventDefault();
				var obj = $(this), action = obj.attr('name');
				$('.save').prop('disabled', true);
				$.ajax({
					type: "POST",
					url: e.target.action,
					data: obj.serialize()+"&is_ajax=2&edit_type=kategori_tugas&edit=1&form="+action,
					cache: false,
					success: function (JSON) {
						if (JSON.error != '') {
							toastr.error(JSON.error);
							$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
							$('.save').prop('disabled', false);
						} else {
							$('.edit-modal-data').modal('toggle');
					// On page load: datatable
					var umb_table = $('#umb_table').dataTable({
						"bDestroy": true,
						"ajax": {
							url : "<?php echo site_url("admin/project/list_kategoris_tugas") ?>",
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
					$('.save').prop('disabled', false);				
				}
			}
		});
			});
		});	
	</script>
<?php }
?>
