<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['client_id']) && $_GET['data']=='client'){
  ?>

  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> 
      <span aria-hidden="true">×</span> 
    </button>
    <h4 class="modal-title" id="edit-modal-data">
      <i class="icon-pencil7"></i> 
      <?php echo $this->lang->line('umb_project_edit_client');?>
    </h4>
  </div>
  <?php $attributes = array('name' => 'edit_client', 'id' => 'edit_client', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
  <?php $hidden = array('_method' => 'EDIT', '_token' => $client_id, 'ext_name' => $name);?>
  <?php echo form_open('admin/clients/update/'.$client_id, $attributes, $hidden);?>
  <div class="modal-body">
    <div class="row">
      <div class="col-sm-6">
        <div class="form-group">
          <label for="nama_perusahaan"><?php echo $this->lang->line('umb_nama_perusahaan');?></label>
          <input class="form-control" placeholder="<?php echo $this->lang->line('umb_nama_perusahaan');?>" name="nama_perusahaan" type="text" value="<?php echo $nama_perusahaan;?>">
        </div>
        <div class="form-group">
          <div class="row">
            <div class="col-md-6">
              <label for="nama_perusahaan"><?php echo $this->lang->line('umb_clkontak_person');?></label>
              <input class="form-control" placeholder="<?php echo $this->lang->line('umb_clkontak_person');?>" name="name" type="text" value="<?php echo $name;?>">          
            </div>
            <div class="col-md-6">
              <label for="nomor_kontak"><?php echo $this->lang->line('umb_nomor_kontak');?></label>
              <input class="form-control" placeholder="<?php echo $this->lang->line('umb_nomor_kontak');?>" name="nomor_kontak" type="text" value="<?php echo $nomor_kontak;?>">
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">
            <div class="col-md-6">
              <label for="email"><?php echo $this->lang->line('umb_email');?></label>
              <input class="form-control" placeholder="<?php echo $this->lang->line('umb_email');?>" name="email" type="email" value="<?php echo $email;?>">
            </div>
            <div class="col-md-6">
              <label for="website"><?php echo $this->lang->line('umb_website');?></label>
              <input class="form-control" placeholder="<?php echo $this->lang->line('umb_website_url');?>" name="website" value="<?php echo $website_url;?>" type="text">
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
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
              <option value="<?php echo $negara->negara_id;?>" <?php if($negaraid==$negara->negara_id):?> selected="selected"<?php endif;?>> <?php echo $negara->nama_negara;?></option>
            <?php } ?>
          </select>
        </div>
      </div>
    </div>
    <div class="row">
      <!--<div class="col-md-3">
        <label for="email"><?php echo $this->lang->line('dashboard_username');?></label>
        <input class="form-control" placeholder="<?php echo $this->lang->line('dashboard_username');?>" name="username" type="text" value="<?php echo $client_username;?>">
      </div>-->
      <div class="col-md-3">
        <label for="status" class="control-label"><?php echo $this->lang->line('dashboard_umb_status');?></label>
        <select class="form-control" name="status" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('dashboard_umb_status');?>">
          <option value="0" <?php if($is_active=='0'):?> selected <?php endif; ?>><?php echo $this->lang->line('umb_karyawans_inactive');?></option>
          <option value="1" <?php if($is_active=='1'):?> selected <?php endif; ?>><?php echo $this->lang->line('umb_karyawans_active');?></option>
        </select>
      </div>
      <div class="col-md-3">
        <fieldset class="form-group">
          <label for="logo"><?php echo $this->lang->line('umb_project_photo_client');?></label>
          <small><?php echo $this->lang->line('umb_perusahaan_file_type');?></small> 
          <input type="file" class="form-control-file" id="photo_client" name="photo_client">
        </fieldset>
        <?php if($profile_client!='' || $profile_client!='no-file'){?>
          <span class="avatar box-48 mr-0-5"> <img class="user-image-hr46 ui-w-100 rounded-circle" src="<?php echo base_url();?>uploads/clients/<?php echo $profile_client;?>" alt=""> </span>
        <?php } ?>    
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
      $('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
      $('[data-plugin="select_hrm"]').select2({ width:'100%' });	 
      Ladda.bind('button[type=submit]');
      $("#edit_client").submit(function(e){
        var fd = new FormData(this);
        var obj = $(this), action = obj.attr('name');
        fd.append("is_ajax", 2);
        fd.append("edit_type", 'client');
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
          success: function(JSON) {
            if (JSON.error != '') {
              toastr.error(JSON.error);
              $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
              $('.save').prop('disabled', false);
              Ladda.stopAll();
            } else {
              var umb_table = $('#umb_table').dataTable({
               "bDestroy": true,
               "ajax": {
                url : "<?php echo site_url("admin/clients/list_clients") ?>",
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
<?php } else if(isset($_GET['jd']) && $_GET['data']=='view_client' && isset($_GET['client_id']) ){
  ?>
  <form class="m-b-1">
    <div class="modal-body">
      <p class="text-center text-big mb-4">
        <strong><?php echo $this->lang->line('umb_project_view_client');?></strong>
      </p>
      <div class="table-responsive" data-pattern="priority-columns">
        <table class="footable-details table table-striped table-hover toggle-circle">
          <tbody>
            <tr>
              <th><?php echo $this->lang->line('umb_nama_perusahaan');?></th>
              <td style="display: table-cell;"><?php echo $nama_perusahaan;?></td>
            </tr>
            <tr>
              <th><?php echo $this->lang->line('umb_clkontak_person');?></th>
              <td style="display: table-cell;"><?php echo $name;?></td>
            </tr>
            <tr>
              <th><?php echo $this->lang->line('umb_nomor_kontak');?></th>
              <td style="display: table-cell;"><?php echo $nomor_kontak;?></span></td>
            </tr>
            <tr>
              <th><?php echo $this->lang->line('umb_email');?></th>
              <td style="display: table-cell;"><?php echo $email;?></span></td>
            </tr>
            <tr>
              <th><?php echo $this->lang->line('umb_website');?></th>
              <td style="display: table-cell;"><?php echo $website_url;?></span></td>
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
              <td style="display: table-cell;">
                <?php foreach($all_negaraa as $negara) {?>
                  <?php if($negaraid==$negara->negara_id):?>
                    <?php echo $negara->nama_negara;?>
                  <?php endif;?>
                <?php } ?>
              </td>
            </tr>
            <tr>
              <th><?php echo $this->lang->line('umb_project_photo_client');?></th>
              <td style="display: table-cell;">
                <?php if($profile_client!='' || $profile_client!='no-file'){?>
                  <div class="avatar box-48 mr-0-5"> 
                    <img src="<?php echo base_url();?>uploads/clients/<?php echo $profile_client;?>" alt="" class="user-image-hr46 ui-w-100 rounded-circle"></a> 
                  </div>
                <?php } ?>
              </td>
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
