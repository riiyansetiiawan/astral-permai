<?php
/* Profile view
*/
?>
<?php $session = $this->session->userdata('client_username');?>
<?php $user = $this->Clients_model->read_info_client($session['client_id']);?>
<?php $system = $this->Umb_model->read_setting_info(1);?>
<?php if($profile_client!='' && $profile_client!='no file') {?>
  <?php $de_file = base_url().'uploads/clients/'.$profile_client;?>
<?php } else {?>
  <?php if($jenis_kelamin=='Pria') { ?>
    <?php $de_file = base_url().'uploads/clients/default_male.jpg';?>
  <?php } else { ?>
    <?php $de_file = base_url().'uploads/clients/default_female.jpg';?>
  <?php } ?>
<?php } ?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>

<div class="card overflow-hidden">
  <div class="row no-gutters row-bordered row-border-light">
    <div class="col-md-3 pt-0">
      <div class="list-group list-group-flush account-settings-links">
        <a class="list-group-item list-group-item-action active" data-toggle="list" href="#account-general"><?php echo $this->lang->line('umb_e_details_basic');?></a>
        <a class="list-group-item list-group-item-action" data-toggle="list" href="#change_password"><?php echo $this->lang->line('umb_e_details_cpassword');?></a>
      </div>
    </div>
    <div class="col-md-9">
      <div class="tab-content">
        <div class="tab-pane fade show active" id="account-general">

          <div class="card-body media align-items-center">
            <img src="<?php echo $de_file;?>" alt="<?php echo $user[0]->name;?>" class="d-block ui-w-80">
          </div>
          <hr class="border-light m-0">

          <div class="card-block">
            <div class="card-body">
              <?php $attributes = array('name' => 'edit_client', 'id' => 'edit_client', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
              <?php $hidden = array('_method' => 'EDIT', '_token' => $client_id, 'ext_name' => $name);?>
              <?php echo form_open('client/profile/update/'.$client_id, $attributes, $hidden);?>
              <div class="form-body">
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="nama_perusahaan"><?php echo $this->lang->line('umb_nama_klien');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('umb_nama_klien');?>" name="name" type="text" value="<?php echo $name;?>">
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-6">
                          <label for="nama_perusahaan"><?php echo $this->lang->line('umb_nama_perusahaan');?></label>
                          <input class="form-control" placeholder="<?php echo $this->lang->line('umb_nama_perusahaan');?>" name="nama_perusahaan" type="text" value="<?php echo $nama_perusahaan;?>">
                        </div>
                        <div class="col-md-6">
                          <label for="nomor_kontak"><?php echo $this->lang->line('umb_nomor_kontak');?></label>
                          <input class="form-control" placeholder="<?php echo $this->lang->line('umb_nomor_kontak');?>" name="nomor_kontak" type="number" value="<?php echo $nomor_kontak;?>">
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
                  <div class="col-md-6">
                    <fieldset class="form-group">
                      <label for="logo"><?php echo $this->lang->line('umb_project_photo_client');?></label>
                      <input type="file" class="form-control-file" id="photo_client" name="photo_client">
                      <br />
                      <small><?php echo $this->lang->line('umb_perusahaan_file_type');?></small>
                    </fieldset>
                  </div>
                  <div class="col-md-6">
                    <?php if($profile_client!='' || $profile_client!='no-file'){?>
                      <span class="avatar box-48 mr-0-5"> <img class="d-block ui-w-40 rounded-circle" src="<?php echo base_url();?>uploads/clients/<?php echo $profile_client;?>" alt="" width="50px"> </span>
                    <?php } ?>
                  </div>
                </div>
              </div>
              <div class="form-actions"> <?php echo form_button(array('name' => 'hrastral_form', 'type' => 'submit', 'class' => $this->Umb_model->form_button_class(), 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('umb_save'))); ?> </div>
              <?php echo form_close(); ?> </div>
            </div> 
          </div>
          <div class="tab-pane fade" id="change_password">
            <div class="card-body pb-2">
              <?php $attributes = array('name' => 'e_change_password', 'id' => 'e_change_password', 'autocomplete' => 'off');?>
              <?php $hidden = array('u_basic_info' => 'UPDATE');?>
              <?php echo form_open('client/profile/change_password/', $attributes, $hidden);?>
              <?php
              $data_usr11 = array(
                'type'  => 'hidden',
                'name'  => 'client_id',
                'value' => $session['client_id'],
              );
              echo form_input($data_usr11);
              ?>
              <?php if($this->input->get('change_password')):?>
                <input type="hidden" id="change_pass" value="<?php echo $this->input->get('change_password');?>" />
              <?php endif;?>
              <div class="form-group">
                <label class="form-label"><?php echo $this->lang->line('umb_e_details_enpassword');?></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('umb_e_details_enpassword');?>" name="new_password" type="text">
              </div>

              <div class="form-group">
                <label class="form-label"><?php echo $this->lang->line('umb_e_details_ecnpassword');?></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('umb_e_details_ecnpassword');?>" name="new_password_confirm" type="text">
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <div class="form-actions"> <?php echo form_button(array('name' => 'hrastral_form', 'type' => 'submit', 'class' => $this->Umb_model->form_button_class(), 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('umb_save'))); ?> </div>
                  </div>
                </div>
              </div>
              <?php echo form_close(); ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
