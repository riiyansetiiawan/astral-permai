<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>
<?php $role_resources_ids = $this->Umb_model->user_role_resource(); ?>
<?php if(in_array('310',$role_resources_ids)) {?>
  <div class="box mb-4 <?php echo $get_animate;?>">
    <div id="accordion">
      <div class="box-header with-border">
        <h3 class="box-title"><?php echo $this->lang->line('umb_add_new');?> <?php echo $this->lang->line('umb_biaya');?></h3>
        <div class="box-tools pull-right"> 
          <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
            <button type="button" class="btn btn-xs btn-primary"> 
              <span class="ion ion-md-add"></span> 
              <?php echo $this->lang->line('umb_add_new');?>
            </button>
          </a> 
        </div>
      </div>
      <div id="add_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
        <div class="box-body">
          <?php $attributes = array('name' => 'add_biaya', 'id' => 'umb-form', 'autocomplete' => 'off');?>
          <?php $hidden = array('user_id' => $session['user_id']);?>
          <?php echo form_open_multipart('admin/biaya/add_biaya', $attributes, $hidden);?>
          <div class="form-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="type_biaya"><?php echo $this->lang->line('umb_type_biaya');?></label>
                  <select name="type_biaya" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_choose_type_biaya');?>...">
                    <option value=""></option>
                    <?php foreach($all_types_biaya as $type_biaya) {?>
                      <option value="<?php echo $type_biaya->type_biaya_id;?>"><?php echo $type_biaya->name;?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="tanggal_pembelian"><?php echo $this->lang->line('umb_tanggal_pembelian');?></label>
                      <input class="form-control date" placeholder="<?php echo $this->lang->line('umb_tanggal_pembelian');?>" readonly name="tanggal_pembelian" type="text" value="">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="jumlah"><?php echo $this->lang->line('umb_jumlah');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('umb_jumlah');?>" name="jumlah" type="number" value="">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="first_name"><?php echo $this->lang->line('left_perusahaan');?></label>
                      <select class="form-control" name="perusahaan_id" id="aj_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_perusahaan');?>">
                        <option value=""></option>
                        <?php foreach($get_all_perusahaans as $perusahaan) {?>
                          <option value="<?php echo $perusahaan->perusahaan_id?>"><?php echo $perusahaan->name?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group" id="ajax_karyawan">
                      <label for="gift"><?php echo $this->lang->line('umb_dibeli_oleh');?></label>
                      <select name="karyawan_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_choose_an_karyawan');?>">
                        <option value=""></option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="add_billycopy_fields"></div>
              </div>
              <div class="col-md-6">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="description"><?php echo $this->lang->line('umb_keterangan');?></label>
                      <textarea class="form-control textarea" name="remarks" cols="25" rows="5" id="description"></textarea>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="col-md-6">
                      <fieldset class="form-group">
                        <label for="logo"><?php echo $this->lang->line('umb_bill_copy');?></label>
                        <input type="file" class="form-control-file" id="bill_copy" name="bill_copy">
                        <small><?php echo $this->lang->line('umb_unggah_files_biaya');?></small>
                      </fieldset>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-actions box-footer">
              <button type="submit" class="btn btn-primary"> 
                <i class="fa fa-check-square-o"></i> 
                <?php echo $this->lang->line('umb_save');?> 
              </button>
            </div>
          </div>
          <?php echo form_close(); ?> 
        </div>
      </div>
    </div>
  </div>
<?php } ?>
<div class="box <?php echo $get_animate;?>">
  <div class="box-header with-border">
    <h3 class="box-title"> <?php echo $this->lang->line('umb_list_all');?> <?php echo $this->lang->line('umb_biayaa');?> </h3>
  </div>
  <div class="box-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="umb_table">
        <thead>
          <tr>
            <th width="110"><?php echo $this->lang->line('umb_action');?></th>
            <th><?php echo $this->lang->line('umb_biaya');?></th>
            <th><?php echo $this->lang->line('left_perusahaan');?></th>
            <th><i class="fa fa-dollar"></i> <?php echo $this->lang->line('umb_jumlah');?></th>
            <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('umb_tanggal_pembelian');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
