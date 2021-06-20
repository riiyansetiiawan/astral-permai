<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['location_id']) && $_GET['data']=='location'){
  ?>
  <?php $session = $this->session->userdata('username');?>
  <?php $user_info = $this->Umb_model->read_user_info($session['user_id']);?>
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> 
      <span aria-hidden="true">×</span> 
    </button>
    <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_edit_location');?></h4>
  </div>
  <?php $attributes = array('name' => 'edit_location', 'id' => 'edit_location', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
  <?php $hidden = array('_method' => 'EDIT', '_token' => $perusahaan_id, 'ext_name' => $nama_location);?>
  <?php echo form_open('admin/location/update/'.$location_id, $attributes, $hidden);?>
  <div class="modal-body">
    <div class="row">
      <div class="col-sm-6">
        <?php if($user_info[0]->user_role_id==1){ ?>
          <div class="form-group">
            <label for="nama_perusahaan"><?php echo $this->lang->line('umb_edit_perusahaan');?></label>
            <select class="form-control" name="perusahaan" id="ajx_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_edit_perusahaan');?>">
              <option value=""><?php echo $this->lang->line('umb_edit_perusahaan');?></option>
              <?php foreach($all_perusahaans as $perusahaan) {?>
                <option value="<?php echo $perusahaan->perusahaan_id;?>" <?php if($perusahaan_id==$perusahaan->perusahaan_id):?> selected <?php endif;?>> <?php echo $perusahaan->name;?></option>
              <?php } ?>
            </select>
          </div>
        <?php } else {?>
          <?php $eperusahaan_id = $user_info[0]->perusahaan_id;?>
          <div class="form-group">
            <label for="nama_perusahaan"><?php echo $this->lang->line('umb_edit_perusahaan');?></label>
            <select class="form-control" name="perusahaan" id="ajx_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_edit_perusahaan');?>">
              <option value=""><?php echo $this->lang->line('umb_edit_perusahaan');?></option>
              <?php foreach($all_perusahaans as $perusahaan) {?>
                <?php if($eperusahaan_id == $perusahaan->perusahaan_id):?>
                  <option value="<?php echo $perusahaan->perusahaan_id;?>" <?php if($perusahaan_id==$perusahaan->perusahaan_id):?> selected <?php endif;?>> <?php echo $perusahaan->name;?></option>
                <?php endif;?>
              <?php } ?>
            </select>
          </div>
        <?php } ?>
        <div class="form-group">
          <label for="name"><?php echo $this->lang->line('umb_nama_location');?></label>
          <input class="form-control" placeholder="<?php echo $this->lang->line('umb_nama_location');?>" name="name" type="text" value="<?php echo $nama_location;?>">
        </div>
        <div class="form-group">
          <label for="email"><?php echo $this->lang->line('umb_email');?></label>
          <input class="form-control" placeholder="<?php echo $this->lang->line('umb_email');?>" name="email" type="email" value="<?php echo $email;?>">
        </div>
        <div class="form-group">
          <div class="row">
            <div class="col-md-6">
              <label for="phone"><?php echo $this->lang->line('umb_phone');?></label>
              <input class="form-control" placeholder="<?php echo $this->lang->line('umb_phone');?>" name="phone" type="text" value="<?php echo $phone;?>">
            </div>
            <div class="col-md-6">
              <label for="umb_faxn"><?php echo $this->lang->line('umb_faxn');?></label>
              <input class="form-control" placeholder="<?php echo $this->lang->line('umb_faxn');?>" name="fax" type="text" value="<?php echo $fax;?>">
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="form-group" id="ajx_karyawan">
          <div class="row">
            <div class="col-md-12">
              <?php $result = $this->Department_model->ajax_info_perusahaan_karyawan($perusahaan_id);?>
              <label for="email"><?php echo $this->lang->line('umb_view_locationhead');?></label>
              <select class="form-control" name="location_head" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_view_locationhead');?>">
                <option value=""><?php echo $this->lang->line('umb_select_one');?></option>
                <?php foreach($result as $karyawan) {?>
                  <option value="<?php echo $karyawan->user_id;?>" <?php if($location_head==$karyawan->user_id):?> selected <?php endif;?>> <?php echo $karyawan->first_name.' '.$karyawan->last_name;?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="alamat"><?php echo $this->lang->line('umb_alamat');?></label>
          <input class="form-control" placeholder="<?php echo $this->lang->line('umb_alamat_1');?>" name="alamat_1" type="text" value="<?php echo $alamat_1;?>">
          <br>
          <input class="form-control" placeholder="<?php echo $this->lang->line('umb_alamat_2');?>" name="alamat_2" type="text" value="<?php echo $alamat_2;?>">
          <br>
          <div class="row">
            <div class="col-md-4">
              <input class="form-control" placeholder="<?php echo $this->lang->line('umb_kota');?>" name="kota" type="text" value="<?php echo $kota;?>">
            </div>
            <div class="col-md-4">
              <input class="form-control" placeholder="<?php echo $this->lang->line('umb_provinsi');?>" name="provinsi" type="text" value="<?php echo $provinsi;?>">
            </div>
            <div class="col-md-4">
              <input class="form-control" placeholder="<?php echo $this->lang->line('umb_kode_pos');?>" name="kode_pos" type="text" value="<?php echo $kode_pos;?>">
            </div>
          </div>
          <br>
          <select class="form-control" name="negara" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_negara');?>">
            <option value=""><?php echo $this->lang->line('umb_select_one');?></option>
            <?php foreach($all_negaraa as $negara) {?>
              <option value="<?php echo $negara->negara_id;?>" <?php if($negaraid==$negara->negara_id):?> selected <?php endif;?>> <?php echo $negara->nama_negara;?></option>
            <?php } ?>
          </select>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('umb_close');?></button>
    <button type="submit" class="btn btn-primary save"><?php echo $this->lang->line('umb_update');?></button>
  </div>
  <?php echo form_close(); ?>
  <link rel="stylesheet" href="<?php echo base_url();?>skin/vendor/select2/dist/css/select2.min.css">
  <script type="text/javascript" src="<?php echo base_url();?>skin/vendor/select2/dist/js/select2.min.js"></script> 
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
      $("#edit_location").submit(function(e){
        e.preventDefault();
        var obj = $(this), action = obj.attr('name');
        $('.save').prop('disabled', true);
        $.ajax({
          type: "POST",
          url: e.target.action,
          data: obj.serialize()+"&is_ajax=1&edit_type=location&form="+action,
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
                url : "<?php echo site_url("admin/location/list_location") ?>",
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
<?php } else if(isset($_GET['jd']) && isset($_GET['location_id']) && $_GET['data']=='view_location'){
  ?>
  <form class="m-b-1">
    <div class="modal-body">
      <p class="text-center text-big mb-4"><strong><?php echo $this->lang->line('umb_view_location');?></strong></p>
      <div class="table-responsive" data-pattern="priority-columns">
        <table class="footable-details table table-striped table-hover toggle-circle">
          <tbody>
            <tr>
              <th><?php echo $this->lang->line('module_title_perusahaan');?></th>
              <td style="display: table-cell;"><?php foreach($all_perusahaans as $perusahaan) {?>
                <?php if($perusahaan_id==$perusahaan->perusahaan_id):?>
                  <?php echo $perusahaan->name;?>
                <?php endif;?>
                <?php } ?></td>
              </tr>
              <tr>
                <th><?php echo $this->lang->line('umb_nama_location');?></th>
                <td style="display: table-cell;"><?php echo $nama_location;?></td>
              </tr>
              <tr>
                <th><?php echo $this->lang->line('umb_view_locationhead');?></th>
                <td style="display: table-cell;"><?php foreach($all_karyawans as $karyawan) {?>
                  <?php if($location_head==$karyawan->user_id):?>
                    <?php echo $karyawan->first_name.' '.$karyawan->last_name;?>
                  <?php endif;?>
                <?php } ?>
              </span></td>
            </tr>
            <tr>
              <th><?php echo $this->lang->line('umb_email');?></th>
              <td style="display: table-cell;"><?php echo $email;?></td>
            </tr>
            <tr>
              <th><?php echo $this->lang->line('umb_phone');?></th>
              <td style="display: table-cell;"><?php echo $phone;?></span></td>
            </tr>
            <tr>
              <th><?php echo $this->lang->line('umb_faxn');?></th>
              <td style="display: table-cell;"><?php echo $fax;?></span></td>
            </tr>
            <tr>
              <th><?php echo $this->lang->line('umb_alamat');?></th>
              <td style="display: table-cell;"><?php echo $alamat_1;?></span></td>
            </tr>
            <?php if($alamat_2!='') { ?>
              <tr>
                <th>&nbsp;</th>
                <td style="display: table-cell;"><?php echo $alamat_2;?></span></td>
              </tr>
            <?php } ?>
            <tr>
              <th><?php echo $this->lang->line('umb_kota');?></th>
              <td style="display: table-cell;"><?php echo $kota;?></span></td>
            </tr>
            <tr>
              <th><?php echo $this->lang->line('umb_provinsi');?></th>
              <td style="display: table-cell;"><?php echo $provinsi;?></span></td>
            </tr>
            <tr>
              <th><?php echo $this->lang->line('umb_kode_pos');?></th>
              <td style="display: table-cell;"><?php echo $kode_pos;?></span></td>
            </tr>
            <tr>
              <th><?php echo $this->lang->line('umb_negara');?></th>
              <td style="display: table-cell;"><?php foreach($all_negaraa as $negara) {?>
                <?php if($negaraid==$negara->negara_id):?>
                  <?php echo $negara->nama_negara;?>
                <?php endif;?>
              <?php } ?>
            </span></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('umb_close');?></button>
  </div>
  <?php echo form_close(); ?>
<?php }
?>
