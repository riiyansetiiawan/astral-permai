<div class="container">
	
	<!-- Submit Page -->
	<div class="sixteen columns">
		<div class="submit-page">
			<?php $attributes = array('name' => 'add_pekerjaan', 'id' => 'umb-form', 'class' => 'add_pekerjaan', 'autocomplete' => 'off');?>
			<?php $hidden = array('add_pekerjaan' => '1');?>
			<?php echo form_open('employer/add_pekerjaan/', $attributes, $hidden);?>
			<!-- Title -->
			<div class="form">
				<h5>Judul Pekerjaan</h5>
				<input class="search-field" type="text" name="title_pekerjaan" placeholder="" value=""/>
			</div>

			<!-- Job Type -->
			<div class="form">
				<h5>Type Pekerjaan</h5>
				<select data-placeholder="Type Pekerjaan" name="type_pekerjaan" class="chosen-select-no-single">
					<option value=""></option>
					<?php foreach($all_types_pekerjaan->result() as $type_pekerjaan) {?>
						<option value="<?php echo $type_pekerjaan->type_pekerjaan_id?>"><?php echo $type_pekerjaan->type?></option>
					<?php } ?>
				</select>
			</div>


			<!-- Choose Category -->
			<div class="form">
				<div class="select">
					<h5>Kategori</h5>
					<select id="kategori_id" name="kategori_id" data-placeholder="Pilih Kategori" class="chosen-select">
						<option value=""></option>
						<?php foreach($all_kategoris_pekerjaan as $kategori):?>
							<option value="<?php echo $kategori->kategori_id;?>"><?php echo $kategori->nama_kategori;?></option>
						<?php endforeach;?>
					</select>
				</div>
			</div>

			<!-- Description -->
			<div class="form">
				<h5>Short Description</h5>
				<textarea class="" name="short_description" cols="40" rows="1" id="short_description" spellcheck="true"></textarea>
			</div>
			
			<!-- Description -->
			<div class="form">
				<h5>Deskripsi</h5>
				<textarea class="" name="long_description" cols="40" rows="3" id="long_description" spellcheck="true"></textarea>
			</div>
			
			<!-- Vacancy -->
			<div class="form">
				<h5>Posisi Nomor</h5>
				<input type="text" name="vacancy" placeholder="Enter the job vacancy">
			</div>

			<!-- TClosing Date -->
			<div class="form">
				<h5>Tanggal Penutupan</h5>
				<input class="date" type="text" name="tanggal_penutupan" placeholder="yyyy-mm-dd">
			</div>

			<!-- Gender -->
			<div class="form">
				<h5>Jenis Kelamin</h5>
				<select data-placeholder="Jenis Kelamin" name="jenis_kelamin" class="chosen-select-no-single">
					<option value="0"><?php echo $this->lang->line('umb_jenis_kelamin_pria');?></option>
					<option value="1"><?php echo $this->lang->line('umb_jenis_kelamin_perempuan');?></option>
					<option value="2"><?php echo $this->lang->line('umb_pekerjaan_no_preference');?></option>
				</select>
			</div>
			
			<!-- Experience -->
			<div class="form">
				<h5>Minimum Pengalaman</h5>
				<select data-placeholder="Minimum Pengalaman" name="pengalaman" class="chosen-select-no-single">
					<option value="0"><?php echo $this->lang->line('umb_fresh_pekerjaan');?></option>
					<option value="1"><?php echo $this->lang->line('umb_pengalaman_pekerjaan_define_1year');?></option>
					<option value="2"><?php echo $this->lang->line('umb_pengalaman_pekerjaan_define_2years');?></option>
					<option value="3"><?php echo $this->lang->line('umb_pengalaman_pekerjaan_define_3years');?></option>
					<option value="4"><?php echo $this->lang->line('umb_pengalaman_pekerjaan_define_4years');?></option>
					<option value="5"><?php echo $this->lang->line('umb_pengalaman_pekerjaan_define_5years');?></option>
					<option value="6"><?php echo $this->lang->line('umb_pengalaman_pekerjaan_define_6years');?></option>
					<option value="7"><?php echo $this->lang->line('umb_pengalaman_pekerjaan_define_7years');?></option>
					<option value="8"><?php echo $this->lang->line('umb_pengalaman_pekerjaan_define_8years');?></option>
					<option value="9"><?php echo $this->lang->line('umb_pengalaman_pekerjaan_define_9years');?></option>
					<option value="10"><?php echo $this->lang->line('umb_pengalaman_pekerjaan_define_10years');?></option>
					<option value="11"><?php echo $this->lang->line('umb_pengalaman_pekerjaan_define_plus_10years');?></option>
				</select>
			</div>
			<!-- Status -->
			

			<div class="divider margin-top-0"></div>
			<button type="submit" class="button big border fw margin-top-10" name="login" />
			<i class="fa fa-arrow-circle-right"></i> Submit</button>

		</form>
	</div>
</div>

</div>
<div class="margin-top-60"></div>