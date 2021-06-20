<!-- Container -->

<div class="container">
  <form method="post" class="register" enctype="multipart/form-data" action="<?php echo site_url('user/update');?>" id="umb-form">
    <div class="eight columns">
      <p class="form-row form-row-wide">
        <label for="first_name">Nama Depan
          <input type="text" class="input-text" name="first_name" id="first_name" value="<?php echo $first_name;?>" />
        </label>
      </p>
      <p class="form-row form-row-wide">
        <label for="email2">Alamat Email
          <input type="text" class="input-text" name="email" id="email2" value="<?php echo $email;?>" />
        </label>
      </p>
      <p class="form-row form-row-wide">
        <label for="nomor_kontak">Nomor Kontak
          <input type="text" class="input-text" name="nomor_kontak" id="nomor_kontak" value="<?php echo $nomor_kontak;?>" />
        </label>
      </p>
      <p class="form-row">
        <div class="select">
          <label for="jenis_kelamin">Jenis Kelamin
            <select data-placeholder="Pilih Jenis Kelamin" name="jenis_kelamin" class="chosen-select">
              <option value=""></option>
              <option value="Pria" <?php if($jenis_kelamin=='Pria'):?> selected="selected"<?php endif;?>>Pria</option>
              <option value="Perempuan" <?php if($jenis_kelamin=='Perempuan'):?> selected="selected"<?php endif;?>>Female</option>
            </select>
          </label> 
        </div>
      </p>
      <p class="form-row">
        <h5>User Photo</h5>
        <label class="upload-btn">
          <input type="file" id="photo" name="photo" />
          <i class="fa fa-upload"></i> Browse
        </label>
        <img src="<?php echo base_url('uploads/users/').$profile_photo;?>" width="80" height="80" />
      </p>
    </div>
    <div class="eight columns">
      <p class="form-row form-row-wide">
        <label for="last_name">Nama Belakang
          <input type="text" class="input-text" name="last_name" id="last_name" value="<?php echo $last_name;?>" />
        </label>
      </p>
      <p class="form-row form-row-wide">
        <label for="username2">Alamat
          <input type="text" class="input-text" placeholder="Alamat Line 1" name="alamat_1" id="alamat_1" value="<?php echo $alamat_1;?>" />
          <br /><input type="text" class="input-text" placeholder="Alamat Line 2" name="alamat_2" id="alamat_2" value="<?php echo $alamat_2;?>" />
        </label>
      </p>
      <p class="form-row form-row-wide">
        <input type="text" class="input-text" name="kota" id="kota" placeholder="Kota" value="<?php echo $kota;?>"/><br />
        <input type="text" class="input-text" name="provinsi" id="provinsi" placeholder="Provinsi" value="<?php echo $provinsi;?>" /><br />
        <input type="text" class="input-text" name="kode_pos" id="kode_pos" placeholder="Kode Pos" value="<?php echo $kode_pos;?>" />
      </p>
      <p class="form-row">
        <div class="select">
          <label for="negara">Negara
            <select data-placeholder="Pilih Negara" id="negara" name="negara" class="chosen-select">
              <option value=""></option>
              <?php foreach($all_negaraa as $negara) {?>
                <option value="<?php echo $negara->negara_id;?>" <?php if($negara->negara_id==$inegara):?> selected="selected" <?php endif;?>><?php echo $negara->nama_negara;?></option>
              <?php } ?>
            </select>
          </label> 
        </div>
      </p>
      <p class="form-row1">
        <input type="submit" class="button border fw margin-top-10" name="update" value="Update" />
      </p>
    </div>
  </form>
</div>
