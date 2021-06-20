<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['pengunduran_diri_id']) && $_GET['data']=='pengunduran_diri'){
  ?>
  <?php $session = $this->session->userdata('username');?>
  <?php
  $role_resources_ids = $this->Umb_model->user_role_resource();
  $user_info = $this->Umb_model->read_user_info($session['user_id']);?>
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
    <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_edit_pengunduran_diri');?></h4>
  </div>
  <?php $attributes = array('name' => 'edit_pengunduran_diri', 'id' => 'edit_pengunduran_diri', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
  <?php $hidden = array('_method' => 'EDIT', '_token' => $pengunduran_diri_id, 'ext_name' => $pengunduran_diri_id);?>
  <?php echo form_open('admin/pengunduran_diri/update/'.$pengunduran_diri_id, $attributes, $hidden);?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-6">      
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="tangggal_pemberitahuan"><?php echo $this->lang->line('umb_tangggal_pemberitahuan');?></label>
              <input class="form-control d_date" placeholder="<?php echo $this->lang->line('umb_tangggal_pemberitahuan');?>" readonly name="tangggal_pemberitahuan" type="text" value="<?php echo $tangggal_pemberitahuan;?>">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="tanggal_pengunduran_diri"><?php echo $this->lang->line('umb_tanggal_pengunduran_diri');?></label>
              <input class="form-control d_date" placeholder="<?php echo $this->lang->line('umb_tanggal_pengunduran_diri');?>" readonly name="tanggal_pengunduran_diri" type="text" value="<?php echo $tanggal_pengunduran_diri;?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="tangggal_pemberitahuan"><?php echo $this->lang->line('dashboard_umb_status');?></label>
              <select class="form-control" name="status" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('dashboard_umb_status');?>">
                <option value=""><?php echo $this->lang->line('dashboard_umb_status');?></option>
                <option value="0" <?php if($approval_status=='0'):?> selected <?php endif; ?>><?php echo $this->lang->line('umb_not_approve_payroll_title');?></option>
                <?php if($user_info[0]->user_role_id==1 || in_array('406',$role_resources_ids)){?>
                  <option value="1" <?php if($approval_status=='1'):?> selected <?php endif; ?>><?php echo $this->lang->line('umb_manager_level_title');?></option>
                <?php } ?>
                <?php if($user_info[0]->user_role_id==1 || in_array('407',$role_resources_ids)){?>
                  <option value="2" <?php if($approval_status=='2'):?> selected <?php endif; ?>> <?php echo $this->lang->line('umb_hrd_level_title');?></option>
                <?php } ?>
                <?php if($user_info[0]->user_role_id==1 || in_array('408',$role_resources_ids)){?>
                  <option value="3" <?php if($approval_status=='3'):?> selected <?php endif; ?>> <?php echo $this->lang->line('umb_gm_om_level_title');?></option>
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
              <label for="reason"><?php echo $this->lang->line('umb_pengunduran_diri_reason');?></label>
              <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('umb_pengunduran_diri_reason');?>" name="reason" cols="30" rows="5" id="reason2"><?php echo $reason;?></textarea>
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

      jQuery("#ajx_perusahaan").change(function(){
        jQuery.get(base_url+"/get_karyawans/"+jQuery(this).val(), function(data, status){
          jQuery('#ajx_karyawan').html(data);
        });
      });
      $('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
      $('[data-plugin="select_hrm"]').select2({ width:'100%' });	 
      Ladda.bind('button[type=submit]');		
      $('.d_date').bootstrapMaterialDatePicker({
        weekStart: 0,
        time: false,
        clearButton: false,
        format: 'YYYY-MM-DD'
      });
      $("#edit_pengunduran_diri").submit(function(e){
        e.preventDefault();
        var obj = $(this), action = obj.attr('name');
        $('.save').prop('disabled', true);
        $.ajax({
          type: "POST",
          url: e.target.action,
          data: obj.serialize()+"&is_ajax=1&edit_type=pengunduran_diri&form="+action,
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
               url : "<?php echo site_url("admin/pengunduran_diri/list_pengunduran_diri") ?>",
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
<?php } else if(isset($_GET['jd']) && isset($_GET['pengunduran_diri_id']) && $_GET['data']=='view_pengunduran_diri'){
	if($approval_status == 0){
		$app_status = $this->lang->line('umb_not_approve_payroll_title');
	} else if($approval_status == 1){
		$app_status = $this->lang->line('umb_manager_level_title');
	} else if($approval_status == 2){
		$app_status = $this->lang->line('umb_hrd_level_title');
	} else if($approval_status == 3){
		$app_status = $this->lang->line('umb_gm_om_level_title');
	} else {
		$app_status = $this->lang->line('umb_not_approve_payroll_title');
	}
  ?>
  <form class="m-b-1">
    <div class="modal-body">
      <p class="text-center text-big mb-4"><strong><?php echo $this->lang->line('umb_view_pengunduran_diri');?></strong></p>
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
              <th><?php echo $this->lang->line('umb_resignin_karyawan');?></th>
              <td style="display: table-cell;"><?php foreach($all_karyawans as $karyawan) {?>
                <?php if($karyawan_id==$karyawan->user_id):?>
                  <?php echo $karyawan->first_name.' '.$karyawan->last_name;?>
                <?php endif;?>
                <?php } ?></td>
              </tr>
              <tr>
                <th><?php echo $this->lang->line('umb_tangggal_pemberitahuan');?></th>
                <td style="display: table-cell;"><?php echo $this->Umb_model->set_date_format($tangggal_pemberitahuan);?></td>
              </tr>
              <tr>
                <th><?php echo $this->lang->line('umb_tanggal_pengunduran_diri');?></th>
                <td style="display: table-cell;"><?php echo $this->Umb_model->set_date_format($tanggal_pengunduran_diri);?></td>
              </tr>
              <tr>
                <th><?php echo $this->lang->line('dashboard_umb_status');?></th>
                <td style="display: table-cell;"><?php echo $app_status;?></td>
              </tr>
              <tr>
                <th><?php echo $this->lang->line('umb_pengunduran_diri_reason');?></th>
                <td style="display: table-cell;"><?php echo html_entity_decode($reason);?></td>
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
