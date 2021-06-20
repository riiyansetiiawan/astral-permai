<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['pekerjaan_id']) && $_GET['data']=='pekerjaan'){
?>
<?php
$all_employers = $this->Recruitment_model->get_all_employers();
$all_types_pekerjaan = $this->Umb_model->get_type_pekerjaan();
$all_kategoris_pekerjaan = $this->Recruitment_model->all_kategoris_pekerjaan();
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_edit_pekerjaan');?></h4>
</div>
<?php $attributes = array('name' => 'edit_pekerjaan', 'id' => 'edit_pekerjaan', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $pekerjaan_id, 'ext_name' => $title_pekerjaan);?>
<?php echo form_open('admin/post_pekerjaan/update/'.$pekerjaan_id, $attributes, $hidden);?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-6">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="nama_perusahaan"><?php echo $this->lang->line('umb_employer_pekerjaans');?></label>
              <select class="form-control" name="user_id" id="user_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_employer_pekerjaans');?>">
                <option value=""><?php echo $this->lang->line('umb_select_one');?></option>
                <?php foreach($all_employers as $employer) {?>
                <option value="<?php echo $employer->user_id;?>" <?php if($employer->user_id==$employer_id):?> selected="selected"<?php endif;?>> <?php echo $employer->first_name.' '.$employer->last_name;?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="title"><?php echo $this->lang->line('umb_e_details_jtitle');?></label>
              <input class="form-control" placeholder="<?php echo $this->lang->line('umb_e_details_jtitle');?>" name="title_pekerjaan" type="text" value="<?php echo $title_pekerjaan;?>">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="type_pekerjaan"><?php echo $this->lang->line('umb_type_pekerjaan');?></label>
              <select class="form-control" name="type_pekerjaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_type_pekerjaan');?>">
                <option value=""></option>
                <?php foreach($all_types_pekerjaan->result() as $type_pekerjaan) {?>
                <option value="<?php echo $type_pekerjaan->type_pekerjaan_id?>" <?php if($type_pekerjaan_id==$type_pekerjaan->type_pekerjaan_id):?> selected="selected" <?php endif;?>><?php echo $type_pekerjaan->type;?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group" id="penunjukan_ajx">
              <label for="penunjukan"><?php echo $this->lang->line('umb_acc_kategori');?></label>
              <select class="form-control" name="kategori_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_acc_kategori');?>">
                <option value=""></option>
                <?php foreach($all_kategoris_pekerjaan as $kategori) {?>
                <option value="<?php echo $kategori->kategori_id?>" <?php if($kategori_id==$kategori->kategori_id):?> selected="selected" <?php endif;?>><?php echo $kategori->nama_kategori?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="vacancy"><?php echo $this->lang->line('umb_number_of_positions');?></label>
              <input class="form-control" placeholder="<?php echo $this->lang->line('umb_number_of_positions');?>" name="vacancy" type="text" value="<?php echo $lowongan_pekerjaan;?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="is_featured"><?php echo $this->lang->line('umb_pekerjaan_is_featured');?></label>
              <select class="form-control" name="is_featured" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_pekerjaan_is_featured');?>">
                <option value="1" <?php if($is_featured=='1'):?> selected <?php endif;?>><?php echo $this->lang->line('umb_yes');?></option>
                <option value="0" <?php if($is_featured=='0'):?> selected <?php endif;?>><?php echo $this->lang->line('umb_no');?></option>
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="status"><?php echo $this->lang->line('dashboard_umb_status');?></label>
              <select class="form-control" name="status" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('dashboard_umb_status');?>">
                <option value="1" <?php if($status=='1'):?> selected <?php endif;?>><?php echo $this->lang->line('umb_published');?></option>
                <option value="2" <?php if($status=='2'):?> selected <?php endif;?>><?php echo $this->lang->line('umb_unpublished');?></option>
              </select>
            </div>
          </div>
          
          <div class="col-md-4">
            <div class="form-group">
              <label for="tanggal_penutupan" class="control-label"><?php echo $this->lang->line('umb_tanggal_penutupan');?></label>
              <input class="form-control e_date" placeholder="<?php echo $this->lang->line('umb_tanggal_penutupan');?>" readonly="true" name="tanggal_penutupan" type="text" value="<?php echo $tanggal_penutupan;?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="jenis_kelamin"><?php echo $this->lang->line('umb_jenis_kelamin_karyawan');?></label>
              <select class="form-control" name="jenis_kelamin" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_jenis_kelamin_karyawan');?>">
                <option value="0" <?php if($jenis_kelamin=='0'):?> selected <?php endif;?>><?php echo $this->lang->line('umb_jenis_kelamin_pria');?></option>
                <option value="1" <?php if($jenis_kelamin=='1'):?> selected <?php endif;?>><?php echo $this->lang->line('umb_jenis_kelamin_perempuan');?></option>
                <option value="2" <?php if($jenis_kelamin=='2'):?> selected <?php endif;?>><?php echo $this->lang->line('umb_pekerjaan_no_preference');?></option>
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="pengalaman" class="control-label"><?php echo $this->lang->line('umb_pekerjaan_minimum_pengalaman');?></label>
              <select class="form-control" name="pengalaman" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_pekerjaan_minimum_pengalaman');?>">
                <option value="0" <?php if($minimum_pengalaman=='0'):?> selected <?php endif;?>> <?php echo $this->lang->line('umb_fresh_pekerjaan');?></option>
                <option value="1" <?php if($minimum_pengalaman=='1'):?> selected <?php endif;?>> <?php echo $this->lang->line('umb_pengalaman_pekerjaan_define_1year');?></option>
                <option value="2" <?php if($minimum_pengalaman=='2'):?> selected <?php endif;?>> <?php echo $this->lang->line('umb_pengalaman_pekerjaan_define_2years');?></option>
                <option value="3" <?php if($minimum_pengalaman=='3'):?> selected <?php endif;?>> <?php echo $this->lang->line('umb_pengalaman_pekerjaan_define_3years');?></option>
                <option value="4" <?php if($minimum_pengalaman=='4'):?> selected <?php endif;?>> <?php echo $this->lang->line('umb_pengalaman_pekerjaan_define_4years');?></option>
                <option value="5" <?php if($minimum_pengalaman=='5'):?> selected <?php endif;?>> <?php echo $this->lang->line('umb_pengalaman_pekerjaan_define_5years');?></option>
                <option value="6" <?php if($minimum_pengalaman=='6'):?> selected <?php endif;?>> <?php echo $this->lang->line('umb_pengalaman_pekerjaan_define_6years');?></option>
                <option value="7" <?php if($minimum_pengalaman=='7'):?> selected <?php endif;?>> <?php echo $this->lang->line('umb_pengalaman_pekerjaan_define_7years');?></option>
                <option value="8" <?php if($minimum_pengalaman=='8'):?> selected <?php endif;?>> <?php echo $this->lang->line('umb_pengalaman_pekerjaan_define_8years');?></option>
                <option value="9" <?php if($minimum_pengalaman=='9'):?> selected <?php endif;?>> <?php echo $this->lang->line('umb_pengalaman_pekerjaan_define_9years');?></option>
                <option value="10" <?php if($minimum_pengalaman=='10'):?> selected <?php endif;?>> <?php echo $this->lang->line('umb_pengalaman_pekerjaan_define_10years');?></option>
                <option value="11" <?php if($minimum_pengalaman=='11'):?> selected <?php endif;?>> <?php echo $this->lang->line('umb_pengalaman_pekerjaan_define_plus_10years');?></option>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="long_description"><?php echo $this->lang->line('umb_long_description');?></label>
          <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('umb_long_description');?>" name="long_description" cols="30" rows="5" id="long_description2"><?php echo $long_description;?></textarea>
        </div>
      </div>
    </div>
    <div class="form-group">
      <label for="short_description"><?php echo $this->lang->line('umb_short_description');?></label>
      <textarea class="form-control" placeholder="<?php echo $this->lang->line('umb_short_description');?>" name="short_description" cols="30" rows="3"><?php echo $short_description;?></textarea>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('umb_close');?></button>
    <button type="submit" class="btn btn-primary"><?php echo $this->lang->line('umb_update');?></button>
  </div>
<?php echo form_close(); ?>
<style type="text/css">.trumbowyg-box, .trumbowyg-editor { min-height: 175px; }</style>
<script type="text/javascript">
 $(document).ready(function(){
					
		jQuery("#ajx_perusahaan").change(function(){
			jQuery.get(base_url+"/get_penunjukans/"+jQuery(this).val(), function(data, status){
				jQuery('#penunjukan_ajx').html(data);
			});
		});
		$('#long_description2').trumbowyg();	 
		 Ladda.bind('button[type=submit]');

		// On page load: datatable
		var umb_table = $('#umb_table').dataTable({
			"bDestroy": true,
			"ajax": {
				url : "<?php echo site_url("admin/post_pekerjaan/list_pekerjaan") ?>",
				type : 'GET'
			},
			"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();          
			}
		});
		
		$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
		$('[data-plugin="select_hrm"]').select2({ width:'100%' });	 
		
		$('.e_date').bootstrapMaterialDatePicker({
			weekStart: 0,
			time: false,
			clearButton: false,
			format: 'YYYY-MM-DD'
		});

		/* Edit data */
		$("#edit_pekerjaan").submit(function(e){
		e.preventDefault();
			var obj = $(this), action = obj.attr('name');
			$('.save').prop('disabled', true);
			$.ajax({
				type: "POST",
				url: e.target.action,
				data: obj.serialize()+"&is_ajax=1&edit_type=pekerjaan&form="+action,
				cache: false,
				success: function (JSON) {
					if (JSON.error != '') {
						toastr.error(JSON.error);
						$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
						$('.save').prop('disabled', false);
						Ladda.stopAll();
					} else {
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
