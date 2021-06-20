<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['asset_id']) && $_GET['data']=='eassets'){ ?>
  <?php $session = $this->session->userdata('username');?>
  <?php $user_info = $this->Umb_model->read_user_info($session['user_id']);?>
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
    <h4 class="modal-title" id="edit-modal-data"><i class="icon-pencil7"></i> <?php echo $this->lang->line('umb_edit_asset');?></h4>
  </div>
  <form class="m-b-1" action="<?php echo site_url("admin/assets/update_asset").'/'.$assets_id; ?>" method="post" name="update_asset" id="update_asset">
    <input type="hidden" name="_method" value="EDIT">
    <input type="hidden" name="ext_name" value="<?php echo $name;?>">
    <div class="modal-body">
      <div class="row">
        <div class="col-md-6">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="first_name"><?php echo $this->lang->line('umb_acc_kategori');?></label>
                <select class="form-control" name="kategori_id" id="kategori_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_perusahaan');?>">
                  <option value=""></option>
                  <?php foreach($all_kategoris_assets as $kategori_assets) {?>
                    <option value="<?php echo $kategori_assets->kategori_assets_id?>" <?php if($kategori_assets_id==$kategori_assets->kategori_assets_id):?> selected="selected" <?php endif;?>><?php echo $kategori_assets->nama_kategori?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="nama_asset" class="control-label"><?php echo $this->lang->line('umb_nama_asset');?></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('umb_nama_asset');?>" name="nama_asset" type="text" value="<?php echo $name?>">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <?php if($user_info[0]->user_role_id==1){ ?>
                <div class="form-group">
                  <label for="perusahaan_id"><?php echo $this->lang->line('left_perusahaan');?></label>
                  <select class="form-control" name="perusahaan_id" id="ajx_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_perusahaan');?>">
                    <option value=""></option>
                    <?php foreach($all_perusahaans as $perusahaan) {?>
                      <option value="<?php echo $perusahaan->perusahaan_id?>" <?php if($perusahaan_id==$perusahaan->perusahaan_id):?> selected="selected" <?php endif;?>><?php echo $perusahaan->name?></option>
                    <?php } ?>
                  </select>
                </div>
              <?php } else {?>
                <?php $eperusahaan_id = $user_info[0]->perusahaan_id;?>
                <div class="form-group">
                  <label for="perusahaan_id"><?php echo $this->lang->line('left_perusahaan');?></label>
                  <select class="form-control" name="perusahaan_id" id="ajx_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_perusahaan');?>">
                    <option value=""></option>
                    <?php foreach($all_perusahaans as $perusahaan) {?>
                      <?php if($eperusahaan_id == $perusahaan->perusahaan_id):?>
                        <option value="<?php echo $perusahaan->perusahaan_id?>" <?php if($perusahaan_id==$perusahaan->perusahaan_id):?> selected="selected" <?php endif;?>><?php echo $perusahaan->name?></option>
                      <?php endif;?>
                    <?php } ?>
                  </select>
                </div>
              <?php } ?>
            </div>
            <div class="col-md-6">
              <?php $result = $this->Department_model->ajax_info_perusahaan_karyawan($perusahaan_id);?>
              <div class="form-group" id="ajx_karyawan">
                <label for="first_name"><?php echo $this->lang->line('dashboard_single_karyawan');?></label>
                <select class="form-control" name="karyawan_id" id="karyawan_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_choose_an_karyawan');?>">
                  <option value=""></option>
                  <?php foreach($result as $karyawan) {?>
                    <option value="<?php echo $karyawan->user_id?>" <?php if($karyawan_id==$karyawan->user_id):?> selected="selected" <?php endif;?>><?php echo $karyawan->first_name.' '.$karyawan->last_name;?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="manufacturer"><?php echo $this->lang->line('umb_manufacturer');?></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('umb_manufacturer');?>" name="manufacturer" type="text" value="<?php echo $manufacturer?>">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="umb_serial_number" class="control-label"><?php echo $this->lang->line('umb_serial_number');?></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('umb_serial_number');?>" name="serial_number" type="text" value="<?php echo $serial_number?>">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <fieldset class="form-group">
                  <label for="asset_image"><?php echo $this->lang->line('umb_asset_image');?></label>
                  <input type="file" class="form-control-file" id="asset_image" name="asset_image">
                  <small><?php echo $this->lang->line('umb_asset_allowed_image_formats');?></small>
                </fieldset>
              </div>
            </div>
            <div class="col-md-6">
              <div class='form-group'>
                <label for="kode_asset_perusahaan">&nbsp;</label>
                <?php if($asset_image!='' && $asset_image!='no file') {?>
                  <img src="<?php echo base_url().'uploads/asset_image/'.$asset_image;?>" width="70px" id="u_file"> <a href="<?php echo site_url()?>admin/download?type=asset_image&filename=<?php echo $asset_image;?>"><?php echo $this->lang->line('umb_download');?></a>
                <?php } else {?>
                  <p>&nbsp;</p>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="kode_asset_perusahaan"><?php echo $this->lang->line('umb_kode_asset_perusahaan');?></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('umb_kode_asset_perusahaan');?>" name="kode_asset_perusahaan" type="text" value="<?php echo $kode_asset_perusahaan?>">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="sedang_bekerja" class="control-label"><?php echo $this->lang->line('umb_sedang_bekerja');?></label>
                <select class="form-control" name="sedang_bekerja" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_sedang_bekerja');?>">
                  <option value="1" <?php if($sedang_bekerja==1):?> selected="selected" <?php endif;?>><?php echo $this->lang->line('umb_yes');?></option>
                  <option value="0" <?php if($sedang_bekerja==0):?> selected="selected" <?php endif;?>><?php echo $this->lang->line('umb_no');?></option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="tanggal_pembelian"><?php echo $this->lang->line('umb_tanggal_pembelian');?></label>
                <input class="form-control tanggal_d_assets" placeholder="<?php echo $this->lang->line('umb_tanggal_pembelian');?>" name="tanggal_pembelian" type="text" value="<?php echo $tanggal_pembelian?>">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="role"><?php echo $this->lang->line('umb_nomor_invoice');?></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('umb_nomor_invoice');?>" name="nomor_invoice" type="text" value="<?php echo $nomor_invoice?>">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="tanggal_akhir_garansi" class="control-label"><?php echo $this->lang->line('umb_tanggal_akhir_garansi');?></label>
                <input class="form-control tanggal_d_assets" placeholder="<?php echo $this->lang->line('umb_tanggal_akhir_garansi');?>" name="tanggal_akhir_garansi" type="text" value="<?php echo $tanggal_akhir_garansi?>">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="informasi_award"><?php echo $this->lang->line('umb_asset_note');?></label>
                <textarea class="form-control" placeholder="<?php echo $this->lang->line('umb_asset_note');?>" name="asset_note" cols="30" rows="3" id="asset_note"><?php echo $asset_note?></textarea>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-success " data-dismiss="modal"><?php echo $this->lang->line('umb_close');?></button>
      <button type="submit" class="btn btn-primary save"><?php echo $this->lang->line('umb_update');?></button>
    </div>
    <?php echo form_close(); ?>
    <script type="text/javascript">
      $(document).ready(function(){
        $('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
        $('[data-plugin="select_hrm"]').select2({ width:'100%' });
        jQuery("#ajx_perusahaan").change(function(){
          jQuery.get(base_url+"/get_karyawans/"+jQuery(this).val(), function(data, status){
            jQuery('#ajx_karyawan').html(data);
          });
        }); 
        $('.tanggal_d_assets').datepicker({
          changeMonth: true,
          changeYear: true,
          dateFormat:'yy-mm-dd',
          yearRange: '1900:' + (new Date().getFullYear() + 15),
          beforeShow: function(input) {
            $(input).datepicker("widget").show();
          }
        });
        $("#update_asset").submit(function(e){
          var fd = new FormData(this);
          var obj = $(this), action = obj.attr('name');
          fd.append("is_ajax", 2);
          fd.append("edit_type", 'update_asset');
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
                $('.save').prop('disabled', false);
              } else {
                var umb_table = $('#umb_table').dataTable({
                  "bDestroy": true,
                  "ajax": {
                   url : "<?php echo site_url("admin/assets/list_assets"); ?>",
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
                $('.edit-modal-data').modal('toggle');
                $('.save').prop('disabled', false);
              }
            },
            error: function() {
              toastr.error(JSON.error);
              $('.save').prop('disabled', false);
            } 	        
          });
        });
      });	
    </script>
  <?php } if(isset($_GET['jd']) && isset($_GET['type']) && $_GET['data']=='view_asset'){ ?>
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"> 
        <span aria-hidden="true">×</span> 
      </button>
      <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_view_asset');?></h4>
    </div>
    <form class="m-b-1">
      <div class="modal-body">
        <table class="footable-details table table-striped table-hover toggle-circle">
          <tbody>
            <tr>
              <th><?php echo $this->lang->line('umb_nama_asset');?></th>
              <td style="display: table-cell;"><?php echo $name;?></td>
            </tr>
            <tr>
              <th><?php echo $this->lang->line('umb_acc_kategori');?></th>
              <td style="display: table-cell;">
                <?php foreach($all_kategoris_assets as $kategori_assets) {?>
                  <?php if($kategori_assets_id==$kategori_assets->kategori_assets_id):?>
                    <?php echo $kategori_assets->nama_kategori;?>
                  <?php endif;?>
                <?php } ?>
              </td>
            </tr>
            <tr>
              <th><?php echo $this->lang->line('umb_kode_asset_perusahaan');?></th>
              <td style="display: table-cell;"><?php echo $kode_asset_perusahaan;?></td>
            </tr>
            <tr>
              <th><?php echo $this->lang->line('module_title_perusahaan');?></th>
              <td style="display: table-cell;">
                <?php foreach($all_perusahaans as $perusahaan) {?>
                  <?php if($perusahaan_id==$perusahaan->perusahaan_id):?>
                    <?php echo $perusahaan->name;?>
                  <?php endif;?>
                <?php } ?>
              </td>
            </tr>
            <tr>
              <th><?php echo $this->lang->line('dashboard_single_karyawan');?></th>
              <td style="display: table-cell;">
                <?php foreach($all_karyawans as $karyawan) {?>
                  <?php if($karyawan_id==$karyawan->user_id):?>
                    <?php echo $karyawan->first_name.' '.$karyawan->last_name;?>
                  <?php endif;?>
                <?php } ?>
              </td>
            </tr>
            <tr>
              <th><?php echo $this->lang->line('umb_sedang_bekerja');?></th>
              <td style="display: table-cell;">
                <?php
                if($sedang_bekerja==1){
                  echo $bekerja = $this->lang->line('umb_yes');
                } else {
                  echo $bekerja = $this->lang->line('umb_no');
                }
                ?>
              </td>
            </tr>
            <tr>
              <th><?php echo $this->lang->line('umb_tanggal_pembelian');?></th>
              <td style="display: table-cell;"><?php echo $this->Umb_model->set_date_format($tanggal_pembelian);?></td>
            </tr>
            <tr>
              <th><?php echo $this->lang->line('umb_nomor_invoice');?></th>
              <td style="display: table-cell;"><?php echo $nomor_invoice;?></td>
            </tr>
            <tr>
              <th><?php echo $this->lang->line('umb_manufacturer');?></th>
              <td style="display: table-cell;"><?php echo $manufacturer;?></td>
            </tr>
            <tr>
              <th><?php echo $this->lang->line('umb_serial_number');?></th>
              <td style="display: table-cell;"><?php echo $serial_number;?></td>
            </tr>
            <tr>
              <th><?php echo $this->lang->line('umb_tanggal_akhir_garansi');?></th>
              <td style="display: table-cell;"><?php echo $this->Umb_model->set_date_format($tanggal_akhir_garansi);?></td>
            </tr>
            <tr>
              <th><?php echo $this->lang->line('umb_asset_note');?></th>
              <td style="display: table-cell;"><?php echo html_entity_decode($asset_note);?></td>
            </tr>
            <tr>
              <th><?php echo $this->lang->line('umb_asset_image');?></th>
              <td style="display: table-cell;"><?php if($asset_image!='' && $asset_image!='no file') {?>
                <img src="<?php echo base_url().'uploads/asset_image/'.$asset_image;?>" width="70px" id="u_file">&nbsp; <a href="<?php echo site_url()?>admin/download?type=asset_image&filename=<?php echo $asset_image;?>"><?php echo $this->lang->line('umb_download');?></a>
              <?php } ?>
            </td>
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
  ?>
