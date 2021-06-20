<div class="container">
	
	<!-- Submit Page -->
	<div class="sixteen columns">
		<div class="submit-page">
			<?php $attributes = array('name' => 'add_pekerjaan', 'id' => 'umb-form', 'class' => 'add_pekerjaan', 'autocomplete' => 'on');?>
			<?php $hidden = array('add_pekerjaan' => '1');?>
			<?php echo form_open('employer/update_pekerjaan/', $attributes, $hidden);?>
			<!-- Title -->
			<div class="form">
				<h5>Job Title</h5>
				<input class="search-field" type="text" name="title_pekerjaan" placeholder="" value="<?php echo $title_pekerjaan;?>"/>
			</div>

			<!-- Job Type -->
			<div class="form">
				<h5>Jenis Pekerjaan</h5>
				<select data-placeholder="Type Pekerjaan" name="type_pekerjaan" class="chosen-select-no-single">
					<option value=""></option>
					<?php foreach($all_types_pekerjaan->result() as $type_pekerjaan) {?>
						<option value="<?php echo $type_pekerjaan->type_pekerjaan_id?>" <?php if($type_pekerjaan_id==$type_pekerjaan->type_pekerjaan_id):?> selected="selected"<?php endif;?>><?php echo $type_pekerjaan->type?></option>
					<?php } ?>
				</select>
			</div>
			<input type="hidden" name="jbid" value="<?php echo $pekerjaan_id;?>" />
			<!-- Choose Category -->
			<div class="form">
				<div class="select">
					<h5>Kategori</h5>
					<select id="kategori_id" name="kategori_id" data-placeholder="Choose Category" class="chosen-select">
						<option value=""></option>
						<?php foreach($all_kategoris_pekerjaan as $kategori):?>
							<option value="<?php echo $kategori->kategori_id;?>" <?php if($kategori_id==$kategori->kategori_id):?> selected="selected"<?php endif;?>><?php echo $kategori->nama_kategori;?></option>
						<?php endforeach;?>
					</select>
				</div>
			</div>

			<!-- Description -->
			<div class="form">
				<h5>Deskripsi Pendek</h5>
				<textarea class="" name="short_description" cols="40" rows="1" id="short_description" spellcheck="true"><?php echo $short_description;?></textarea>
			</div>
			
			<!-- Description -->
			<div class="form">
				<h5>Deskipsi</h5>
				<textarea class="" name="long_description" cols="40" rows="3" id="" spellcheck="true"><?php echo $long_description;?></textarea>
			</div>
			
			<!-- Vacancy -->
			<div class="form">
				<h5>Number of Positions</h5>
				<input type="text" name="vacancy" placeholder="Enter the job vacancy" value="<?php echo $lowongan_pekerjaan;?>">
			</div>

			<!-- TClosing Date -->
			<div class="form">
				<h5>Tanggal Penutupan <span>(optional)</span></h5>
				<input class="date" type="text" name="tanggal_penutupan" placeholder="yyyy-mm-dd" value="<?php echo $tanggal_penutupan;?>">
				<p class="note">Deadline for new applicants.</p>
			</div>

			<!-- Gender -->
			<div class="form">
				<h5>Jenis Kelamin</h5>
				<select data-placeholder="Gender" name="jenis_kelamin" class="chosen-select-no-single">
					<option value="0" <?php if($kategori_id==$kategori->kategori_id):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('umb_jenis_kelamin_pria');?></option>
					<option value="1" <?php if($kategori_id==$kategori->kategori_id):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('umb_jenis_kelamin_perempuan');?></option>
					<option value="2" <?php if($kategori_id==$kategori->kategori_id):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('umb_pekerjaan_no_preference');?></option>
				</select>
			</div>
			
			<!-- Experience -->
			<div class="form">
				<h5>Minimum Experience</h5>
				<select data-placeholder="Minimum Experience" name="pengalaman" class="chosen-select-no-single">
					<option value="0" <?php if($minimum_pengalaman==0):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('umb_fresh_pekerjaan');?></option>
					<option value="1" <?php if($minimum_pengalaman==1):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('umb_pengalaman_pekerjaan_define_1year');?></option>
					<option value="2" <?php if($minimum_pengalaman==2):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('umb_pengalaman_pekerjaan_define_2years');?></option>
					<option value="3" <?php if($minimum_pengalaman==3):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('umb_pengalaman_pekerjaan_define_3years');?></option>
					<option value="4" <?php if($minimum_pengalaman==4):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('umb_pengalaman_pekerjaan_define_4years');?></option>
					<option value="5" <?php if($minimum_pengalaman==5):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('umb_pengalaman_pekerjaan_define_5years');?></option>
					<option value="6" <?php if($minimum_pengalaman==6):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('umb_pengalaman_pekerjaan_define_6years');?></option>
					<option value="7" <?php if($minimum_pengalaman==7):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('umb_pengalaman_pekerjaan_define_7years');?></option>
					<option value="8" <?php if($minimum_pengalaman==8):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('umb_pengalaman_pekerjaan_define_8years');?></option>
					<option value="9" <?php if($minimum_pengalaman==9):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('umb_pengalaman_pekerjaan_define_9years');?></option>
					<option value="10" <?php if($minimum_pengalaman==10):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('umb_pengalaman_pekerjaan_define_10years');?></option>
					<option value="11" <?php if($minimum_pengalaman==11):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('umb_pengalaman_pekerjaan_define_plus_10years');?></option>
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