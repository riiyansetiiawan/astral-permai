<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['perjalanan_id']) && $_GET['data']=='perjalanan'){
  ?>
  <?php $session = $this->session->userdata('username');?>
  <?php $role_resources_ids = $this->Umb_model->user_role_resource(); ?>
  <?php $user_info = $this->Umb_model->read_info_karyawan($session['user_id']);?>
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
    <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_edit_perjalanan');?></h4>
  </div>
  <?php $attributes = array('name' => 'edit_perjalanan', 'id' => 'edit_perjalanan', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
  <?php if($user_info[0]->user_role_id==1){ ?>
    <?php $hidden = array('user_id' => $session['user_id'],'_method' => 'EDIT', '_token' => $perjalanan_id, 'ext_name' => $perjalanan_id);?>
  <?php } else { ?>
    <?php $hidden = array('user_id' => $session['user_id'],'perusahaan_id' => $user_info[0]->perusahaan_id,'karyawan_id' => $session['user_id'],'_method' => 'EDIT', '_token' => $perjalanan_id, 'ext_name' => $perjalanan_id);?>
  <?php } ?>
  <?php echo form_open('admin/perjalanan/update/'.$perjalanan_id, $attributes, $hidden);?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-6">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="start_date"><?php echo $this->lang->line('umb_start_date');?></label>
              <input class="form-control d_date" placeholder="<?php echo $this->lang->line('umb_start_date');?>" readonly name="start_date" type="text" value="<?php echo $start_date;?>">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="end_date"><?php echo $this->lang->line('umb_end_date');?></label>
              <input class="form-control d_date" placeholder="<?php echo $this->lang->line('umb_end_date');?>" readonly name="end_date" type="text" value="<?php echo $end_date;?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="visit_purpose"><?php echo $this->lang->line('umb_tujuan_kunjungan');?></label>
              <input class="form-control" placeholder="<?php echo $this->lang->line('umb_tujuan_kunjungan');?>" name="visit_purpose" type="text" value="<?php echo $visit_purpose;?>">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="visit_place"><?php echo $this->lang->line('umb_visit_place');?></label>
              <input class="form-control" placeholder="<?php echo $this->lang->line('umb_visit_place');?>" name="visit_place" type="text" value="<?php echo $visit_place;?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="expected_budget"><?php echo $this->lang->line('umb_expected_perjalanan_budget');?></label>
              <input class="form-control" placeholder="<?php echo $this->lang->line('umb_expected_perjalanan_budget');?>" name="expected_budget" type="text" value="<?php echo $expected_budget;?>">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="actual_budget"><?php echo $this->lang->line('umb_actual_perjalanan_budget');?></label>
              <input class="form-control" placeholder="<?php echo $this->lang->line('umb_actual_perjalanan_budget');?>" name="actual_budget" type="text" value="<?php echo $actual_budget;?>">
            </div>
          </div>
        </div>
        
        <?php if($user_info[0]->user_role_id!=1){ ?>      
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="perjalanan_mode"><?php echo $this->lang->line('umb_perjalanan_mode');?></label>
                <select class="select2" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_perjalanan_mode');?>" name="perjalanan_mode">
                  <option value="1" <?php if(1==$perjalanan_mode):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('umb_by_bus');?></option>
                  <option value="2" <?php if(2==$perjalanan_mode):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('umb_by_train');?></option>
                  <option value="3" <?php if(3==$perjalanan_mode):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('umb_by_plane');?></option>
                  <option value="4" <?php if(4==$perjalanan_mode):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('umb_by_taxi');?></option>
                  <option value="5" <?php if(5==$perjalanan_mode):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('umb_by_rental_car');?></option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="arrangement_type"><?php echo $this->lang->line('umb_arragement_type');?></label>
                <select class="select2" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_arragement_type');?>" name="arrangement_type">
                  <?php foreach($types_pengaturan_perjalanan as $type_pngtrn_perjalanan) {?>
                    <option value="<?php echo $type_pngtrn_perjalanan->type_pengaturan_id;?>" <?php if($type_pngtrn_perjalanan->type_pengaturan_id==$arrangement_type):?> selected="selected"<?php endif;?>> <?php echo $type_pngtrn_perjalanan->type;?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div>
        <?php } else {?>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="status"><?php echo $this->lang->line('dashboard_umb_status');?></label>
                <select name="status" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('dashboard_umb_status');?>">
                  <option value="0" <?php if($status=='0'):?> selected <?php endif; ?>><?php echo $this->lang->line('umb_pending');?></option>
                  <option value="1" <?php if($status=='1'):?> selected <?php endif; ?>><?php echo $this->lang->line('umb_accepted');?></option>
                  <option value="2" <?php if($status=='2'):?> selected <?php endif; ?>><?php echo $this->lang->line('umb_rejected');?></option>
                </select>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
      <div class="col-md-6">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="description"><?php echo $this->lang->line('umb_description');?></label>
              <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('umb_description');?>" name="description" cols="30" rows="5" id="description2"><?php echo $description;?></textarea>
            </div>
          </div>
        </div>
        <?php if($user_info[0]->user_role_id==1){ ?>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="perjalanan_mode"><?php echo $this->lang->line('umb_perjalanan_mode');?></label>
                <select class="select2" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_perjalanan_mode');?>" name="perjalanan_mode">
                  <option value="1" <?php if(1==$perjalanan_mode):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('umb_by_bus');?></option>
                  <option value="2" <?php if(2==$perjalanan_mode):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('umb_by_train');?></option>
                  <option value="3" <?php if(3==$perjalanan_mode):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('umb_by_plane');?></option>
                  <option value="4" <?php if(4==$perjalanan_mode):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('umb_by_taxi');?></option>
                  <option value="5" <?php if(5==$perjalanan_mode):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('umb_by_rental_car');?></option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="arrangement_type"><?php echo $this->lang->line('umb_arragement_type');?></label>
                <select class="select2" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_arragement_type');?>" name="arrangement_type">
                  <?php foreach($types_pengaturan_perjalanan as $type_pngtrn_perjalanan) {?>
                    <option value="<?php echo $type_pngtrn_perjalanan->type_pengaturan_id;?>" <?php if($type_pngtrn_perjalanan->type_pengaturan_id==$arrangement_type):?> selected="selected"<?php endif;?>> <?php echo $type_pngtrn_perjalanan->type;?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div>
        <?php } ?>
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
     
    jQuery("#ajx_perusahaan").change(function(){
     jQuery.get(base_url+"/get_karyawans/"+jQuery(this).val(), function(data, status){
      jQuery('#ajx_karyawan').html(data);
    });
   });
    
    $('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
    $('[data-plugin="select_hrm"]').select2({ width:'100%' });	 
    Ladda.bind('button[type=submit]');
		//$('#description2').trumbowyg();
		$('.d_date').bootstrapMaterialDatePicker({
			weekStart: 0,
			time: false,
			clearButton: false,
			format: 'YYYY-MM-DD'
		});
		/* Edit data */
		$("#edit_perjalanan").submit(function(e){
      e.preventDefault();
      var obj = $(this), action = obj.attr('name');
      $('.save').prop('disabled', true);
      $.ajax({
        type: "POST",
        url: e.target.action,
        data: obj.serialize()+"&is_ajax=1&edit_type=perjalanan&form="+action,
        cache: false,
        success: function (JSON) {
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
               url : "<?php echo site_url("admin/perjalanan/list_perjalanan") ?>",
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
				}
			});
    });
	});	
</script>
<?php } else if(isset($_GET['jd']) && isset($_GET['perjalanan_id']) && $_GET['data']=='view_perjalanan'){
  ?>
  <form class="m-b-1">
    <div class="modal-body">
      <p class="text-center text-big mb-4"><strong><?php echo $this->lang->line('umb_view_perjalanan');?></strong></p>
      <table class="footable-details table table-striped table-hover toggle-circle">
        <tbody>
          <tr>
            <th><?php echo $this->lang->line('module_title_perusahaan');?></th>
            <td style="display: table-cell;"><?php foreach($get_all_perusahaans as $perusahaan) {?>
              <?php if($perusahaan_id==$perusahaan->perusahaan_id):?>
                <?php echo $perusahaan->name;?>
              <?php endif;?>
              <?php } ?></td>
            </tr>
            <tr>
              <th><?php echo $this->lang->line('dashboard_single_karyawan');?></th>
              <td style="display: table-cell;"><?php foreach($all_karyawans as $karyawan) {?>
                <?php if($karyawan_id==$karyawan->user_id):?>
                  <?php echo $karyawan->first_name.' '.$karyawan->last_name;?>
                <?php endif;?>
                <?php } ?></td>
              </tr>
              <tr>
                <th><?php echo $this->lang->line('umb_start_date');?></th>
                <td style="display: table-cell;"><?php echo $this->Umb_model->set_date_format($start_date);?></td>
              </tr>
              <tr>
                <th><?php echo $this->lang->line('umb_end_date');?></th>
                <td style="display: table-cell;"><?php echo $this->Umb_model->set_date_format($end_date);?></td>
              </tr>
              <tr>
                <th><?php echo $this->lang->line('umb_tujuan_kunjungan');?></th>
                <td style="display: table-cell;"><?php echo $visit_purpose;?></td>
              </tr>
              <tr>
                <th><?php echo $this->lang->line('umb_visit_place');?></th>
                <td style="display: table-cell;"><?php echo $visit_place;?></td>
              </tr>
              <tr>
                <th><?php echo $this->lang->line('umb_perjalanan_mode');?></th>
                <td style="display: table-cell;"><?php if(1==$perjalanan_mode): $tmode = $this->lang->line('umb_by_bus');?>
              <?php endif;?>
              <?php if(2==$perjalanan_mode): $tmode = $this->lang->line('umb_by_train');?>
              <?php endif;?>
              <?php if(3==$perjalanan_mode): $tmode = $this->lang->line('umb_by_plane');?>
              <?php endif;?>
              <?php if(4==$perjalanan_mode): $tmode = $this->lang->line('umb_by_taxi');?>
              <?php endif;?>
              <?php if(5==$perjalanan_mode): $tmode = $this->lang->line('umb_by_rental_car');?>
              <?php endif;?>
              <?php echo $tmode;?></td>
            </tr>
            <tr>
              <th><?php echo $this->lang->line('umb_arragement_type');?></th>
              <td style="display: table-cell;"><?php foreach($types_pengaturan_perjalanan as $type_pngtrn_perjalanan) {?>
                <?php if($arrangement_type==$type_pngtrn_perjalanan->type_pengaturan_id):?>
                  <?php echo $type_pngtrn_perjalanan->type;?>
                <?php endif;?>
                <?php } ?></td>
              </tr>
              <tr>
                <th><?php echo $this->lang->line('umb_expected_perjalanan_budget');?></th>
                <td style="display: table-cell;"><?php echo $this->Umb_model->currency_sign($expected_budget);?></td>
              </tr>
              <tr>
                <th><?php echo $this->lang->line('umb_actual_perjalanan_budget');?></th>
                <td style="display: table-cell;"><?php echo $this->Umb_model->currency_sign($expected_budget);?></td>
              </tr>
              <tr>
                <th><?php echo $this->lang->line('dashboard_umb_status');?></th>
                <td style="display: table-cell;"><?php if(0==$status): $tstatus = $this->lang->line('umb_pending');?>
              <?php endif;?>
              <?php if(1==$status): $tstatus = $this->lang->line('umb_accepted');?>
              <?php endif;?>
              <?php if(2==$status): $tstatus = $this->lang->line('umb_rejected');?>
              <?php endif;?>
              <?php echo $tstatus;?></td>
            </tr>
            <tr>
              <th><?php echo $this->lang->line('umb_description');?></th>
              <td style="display: table-cell;"><?php echo html_entity_decode($description);?></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('umb_close');?></button>
      </div>
      <?php echo form_close(); ?>
    <?php }
    ?>
