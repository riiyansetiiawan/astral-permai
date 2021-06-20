<?php $session = $this->session->userdata('username');?>

<div class="row match-height">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title" id="basic-layout-tooltip"><?php echo $this->lang->line('umb_add_new');?> <?php echo $this->lang->line('umb_user');?></h4>
        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
        <div class="heading-elements">
          <ul class="list-inline mb-0">
            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
            <li><a data-action="close"><i class="ft-x"></i></a></li>
          </ul>
        </div>
      </div>
      <div class="card-body add-form collapse">
        <div class="card-block">
          <form class="form" method="post" name="add_perusahaan" id="umb-form" enctype="multipart/form-data" action="<?php echo site_url('admin/users/add_user');?>">
            <input type="hidden" name="user_id" value="<?php echo $session['user_id'];?>">
            <div class="form-body">
              <div class="row">
                <div class="col-md-6">
                 <div class="form-group">
                  <label for="first_name"><?php echo $this->lang->line('umb_karyawan_first_name');?></label>
                  <input class="form-control" placeholder="<?php echo $this->lang->line('umb_karyawan_first_name');?>" name="first_name" type="text" value="">
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-12">
                      <label for="email"><?php echo $this->lang->line('umb_email');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('umb_email');?>" name="email" type="email">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  
                  <div class="row">
                    <div class="col-md-6">
                      <label for="email"><?php echo $this->lang->line('dashboard_username');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('dashboard_username');?>" name="username" type="text">
                    </div>
                    <div class="col-md-6">
                      <label for="website"><?php echo $this->lang->line('umb_password_karyawan');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('umb_password_karyawan');?>" name="password" type="text">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <label for="nomor_kontak"><?php echo $this->lang->line('umb_nomor_kontak');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('umb_nomor_kontak');?>" name="nomor_kontak" type="number">
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="jenis_kelamin" class="control-label"><?php echo $this->lang->line('umb_jenis_kelamin_karyawan');?></label>
                      <select class="form-control" name="jenis_kelamin" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_jenis_kelamin_karyawan');?>">
                        <option value="Pria"><?php echo $this->lang->line('umb_jenis_kelamin_pria');?></option>
                        <option value="Perempuan"><?php echo $this->lang->line('umb_jenis_kelamin_perempuan');?></option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <fieldset class="form-group">
                      <label for="photo"><?php echo $this->lang->line('umb_user_photo');?></label>
                      <input type="file" class="form-control-file" id="photo" name="photo">
                      <small><?php echo $this->lang->line('umb_perusahaan_file_type');?></small>
                    </fieldset>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="last_name" class="control-label"><?php echo $this->lang->line('umb_karyawan_last_name');?></label>
                  <input class="form-control" placeholder="<?php echo $this->lang->line('umb_karyawan_last_name');?>" name="last_name" type="text" value="">
                </div>
                <div class="form-group">
                  <label for="alamat"><?php echo $this->lang->line('umb_alamat');?></label>
                  <input class="form-control" placeholder="<?php echo $this->lang->line('umb_alamat_1');?>" name="alamat_1" type="text">
                  <br>
                  <input class="form-control" placeholder="<?php echo $this->lang->line('umb_alamat_2');?>" name="alamat_2" type="text">
                  <br>
                  <div class="row">
                    <div class="col-md-4">
                      <input class="form-control" placeholder="<?php echo $this->lang->line('umb_kota');?>" name="kota" type="text">
                    </div>
                    <div class="col-md-4">
                      <input class="form-control" placeholder="<?php echo $this->lang->line('umb_provinsi');?>" name="provinsi" type="text">
                    </div>
                    <div class="col-md-4">
                      <input class="form-control" placeholder="<?php echo $this->lang->line('umb_kode_pos');?>" name="kode_pos" type="text">
                    </div>
                  </div>
                  <br>
                  <select class="form-control" name="negara" data-plugin="umb_select" data-placeholder="<?php echo $this->lang->line('umb_negara');?>">
                    <option value=""><?php echo $this->lang->line('umb_select_one');?></option>
                    <?php foreach($all_negaraa as $negara) {?>
                      <option value="<?php echo $negara->negara_id;?>"> <?php echo $negara->nama_negara;?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="form-actions">
            <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('umb_save');?> </button>
          </div>
          <?php echo form_close(); ?>
        </div>
      </div>
    </div>
  </div>
</div>
<section id="decimal">
  <div class="row">
    <div class="col-xs-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title"><?php echo $this->lang->line('umb_list_all');?> <?php echo $this->lang->line('umb_users');?></h4>
          <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
          <div class="heading-elements">
            <ul class="list-inline mb-0">
              <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
              <li><a data-action="close"><i class="ft-x"></i></a></li>
            </ul>
          </div>
        </div>
        <div class="card-body collapse in">
          <div class="card-block card-dashboard">
            <div class="table-responsive" data-pattern="priority-columns">
              <table class="table table-striped table-bordered dataTable" id="umb_table" style="width:100%;">
                <thead>
                  <tr>
                    <th><?php echo $this->lang->line('umb_action');?></th>
                    <th><?php echo $this->lang->line('umb_name');?></th>
                    <th><?php echo $this->lang->line('umb_email');?></th>
                    <th><?php echo $this->lang->line('dashboard_username');?></th>
                    <th><?php echo $this->lang->line('umb_password_karyawan');?></th>
                    <th><?php echo $this->lang->line('umb_negara');?></th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
