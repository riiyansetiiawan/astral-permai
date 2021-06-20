<div class="container">

	<div class="my-account">

		<div class="tabs-container">
			<!-- Register -->
			<div class="tab-content" id="tab2">

				<?php $attributes = array('id' => 'umb-form', 'class' => 'register', 'autocomplete' => 'on');?>
				<?php $hidden = array('register' => '1');?>
				<?php echo form_open('employer/create_account/', $attributes, $hidden);?>					
				<p class="form-row form-row-wide">
					<label for="first_name">Nama Lengkap:
						<i class="ln ln-icon-Male"></i>
						<input type="text" class="input-text" name="nama_perusahaan" id="nama_perusahaan1" value="" />
					</label>
				</p>

				<p class="form-row form-row-wide">
					<label for="first_name">Nama Depan:
						<i class="ln ln-icon-Male"></i>
						<input type="text" class="input-text" name="first_name" id="first_name1" value="" />
					</label>
				</p>
				<input type="hidden" name="hrastral_view" value="1" />
				<p class="form-row form-row-wide">
					<label for="last_name">Nama Belakang:
						<i class="ln ln-icon-Male"></i>
						<input type="text" class="input-text" name="last_name" id="last_name1" value="" />
					</label>
				</p>	
				<p class="form-row form-row-wide">
					<label for="email2">Alamat Email:
						<i class="ln ln-icon-Mail"></i>
						<input type="text" class="input-text" name="email" id="email1" value="" />
					</label>
				</p>

				<p class="form-row form-row-wide">
					<label for="password1">Password:
						<i class="ln ln-icon-Lock-2"></i>
						<input class="input-text" type="password" name="password" id="password1"/>
					</label>
				</p>
				<p class="form-row form-row-wide">
					<label for="nomor_kontak">Nomor Kontak:
						<i class="ln ln-icon-Phone-2"></i>
						<input type="text" class="input-text" name="nomor_kontak" id="nomor_kontak1" value="" />
					</label>
				</p>
				<p class="form-row">
					<h5>Foto Profile</h5>
					<label class="upload-btn">
						<input type="file" id="logo_perusahaan" name="logo_perusahaan" />
						Browse
					</label>
				</p>
				<p class="form-row">
					<input type="submit" class="button border fw margin-top-10" name="register" value="Register" />
				</p>

			</form>
		</div>
	</div>
</div>
</div>

<!-- Container -->