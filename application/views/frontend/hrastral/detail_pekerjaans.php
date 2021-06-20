<?php
$session = $this->session->userdata('c_user_id');
$kategori_pekerjaan = $this->Recruitment_model->read_info_kategori($kategori_id);?>
<?php
if(!is_null($kategori_pekerjaan)){
	$nama_kategori = $kategori_pekerjaan[0]->nama_kategori;
} else {
	$nama_kategori = '--';	
}
?>
<?php $jtype = $this->Post_pekerjaan_model->read_informasi_type_pekerjaan($type_pekerjaan_id); ?>
<?php
if(!is_null($jtype)){
	$jt_type = $jtype[0]->type;
	if($jt_type == 'Freelance'):
		$clS = 'freelance';
	elseif($jt_type == 'Internship'):
		$clS = 'internship';
	elseif($jt_type == 'Part Time'):
		$clS = 'part-time';
	elseif($jt_type == 'Full Time'):
		$clS = 'full-time';
	else:		
		$clS = 'full-time';		
	endif;
} else {
	$jt_type = '--';	
}
?>
<?php $time_ago = $this->Recruitment_model->timeAgo($created_at);?>  
  <!-- Titlebar
  	================================================== -->
  	<div id="titlebar" class="photo-bg" style="background: url(<?php echo base_url();?>skin/pekerjaans/hrastral/images/all-kategoris-photo.jpg)">
  		<div class="container">
  			<div class="ten columns">
  				<span style="color:#fff;"><?php echo $nama_kategori;?></span>
  				<h2><?php echo $title_pekerjaan;?> <span class="<?php echo $clS;?>"><?php echo $jt_type;?></span></h2>
  			</div>

  		</div>
  	</div>


<!-- Content
	================================================== -->
	<div class="container">
		
		<!-- Recent Jobs -->
		<div class="eleven columns">
			<div class="padding-right">
				
				<!-- perusahaan Info -->
				<div class="perusahaan-info">
					<div class="content">
						<h5><?php echo htmlspecialchars_decode($short_description);?></h5>
						<span><a href="#"><i class="ln ln-icon-Clock-Back"></i> <?php echo $time_ago?></a></span>
						<span><a href="#"><i class="ln ln-icon-Male"></i> <?php if($jenis_kelamin=='0'):?>
						<?php echo $this->lang->line('umb_jenis_kelamin_pria');?>
					<?php endif;?>
					<?php if($jenis_kelamin=='1'):?>
						<?php echo $this->lang->line('umb_jenis_kelamin_perempuan');?>
					<?php endif;?>
					<?php if($jenis_kelamin=='2'):?>
						<?php echo $this->lang->line('umb_pekerjaan_no_preference');?>
						<?php endif;?></a></span>
					</div>
					<div class="clearfix"></div>
				</div>

				<?php echo htmlspecialchars_decode($long_description);?>
			</div>
		</div>


		<!-- Widgets -->
		<div class="five columns">

			<!-- Sort by -->
			<div class="widget">
				<h4>Liat Semua</h4>

				<div class="overview-pekerjaan">
					
					<ul>
						<li>
							<i class="ln ln-icon-ID-3"></i>
							<div>
								<strong>Job Title:</strong>
								<span><?php echo $title_pekerjaan?></span>
							</div>
						</li>
						<li>
							<i class="ln ln-icon-Professor"></i>
							<div>
								<strong>Pengalaman:</strong>
								<span><?php if($minimum_pengalaman=='0'):?>
								<?php echo $this->lang->line('umb_fresh_pekerjaan');?>
							<?php endif;?>
							<?php if($minimum_pengalaman=='1'):?>
								<?php echo $this->lang->line('umb_pengalaman_pekerjaan_define_1year');?>
							<?php endif;?>
							<?php if($minimum_pengalaman=='2'):?>
								<?php echo $this->lang->line('umb_pengalaman_pekerjaan_define_2years');?>
							<?php endif;?>
							<?php if($minimum_pengalaman=='3'):?>
								<?php echo $this->lang->line('umb_pengalaman_pekerjaan_define_3years');?>
							<?php endif;?>
							<?php if($minimum_pengalaman=='4'):?>
								<?php echo $this->lang->line('umb_pengalaman_pekerjaan_define_4years');?>
							<?php endif;?>
							<?php if($minimum_pengalaman=='5'):?>
								<?php echo $this->lang->line('umb_pengalaman_pekerjaan_define_5years');?>
							<?php endif;?>
							<?php if($minimum_pengalaman=='6'):?>
								<?php echo $this->lang->line('umb_pengalaman_pekerjaan_define_6years');?>
							<?php endif;?>
							<?php if($minimum_pengalaman=='7'):?>
								<?php echo $this->lang->line('umb_pengalaman_pekerjaan_define_7years');?>
							<?php endif;?>
							<?php if($minimum_pengalaman=='8'):?>
								<?php echo $this->lang->line('umb_pengalaman_pekerjaan_define_8years');?>
							<?php endif;?>
							<?php if($minimum_pengalaman=='9'):?>
								<?php echo $this->lang->line('umb_pengalaman_pekerjaan_define_9years');?>
							<?php endif;?>
							<?php if($minimum_pengalaman=='10'):?>
								<?php echo $this->lang->line('umb_pengalaman_pekerjaan_define_10years');?>
							<?php endif;?>
							<?php if($minimum_pengalaman=='11'):?>
								<?php echo $this->lang->line('umb_pengalaman_pekerjaan_define_plus_10years');?>
								<?php endif;?></span>
							</div>
						</li>
						<li>
							<i class="ln ln-icon-Blackboard"></i>
							<div>
								<strong>Lowongan:</strong>
								<span><?php echo $lowongan_pekerjaan;?></span>
							</div>
						</li>
						<li>
							<i class="ln ln-icon-Calendar"></i>
							<div>
								<strong>Tanggal Posting:</strong>
								<span><?php echo $this->Umb_model->set_date_format($created_at);?></span>
							</div>
						</li>
						<li>
							<i class="ln ln-icon-Calendar-4"></i>
							<div>
								<strong>Apply Sebelumnya:</strong>
								<span><?php echo $this->Umb_model->set_date_format($tanggal_penutupan);?></span>
							</div>
						</li>
					</ul>
					<a href="#small-dialog" class="popup-with-zoom-anim button">Lamar Pekerjaan Ini</a>
					
					<div id="small-dialog" class="zoom-anim-dialog mfp-hide apply-popup">
						<div class="small-dialog-headline">
							<h2>Lamar Pekerjaan Ini</h2>
						</div>

						<div class="small-dialog-content">
							<?php $attributes = array('name' => 'apply_pekerjaan', 'id' => 'apply', 'class' => 'login', 'autocomplete' => 'on');?>
							<?php $hidden = array('apply_pekerjaan' => '1');?>
							<?php echo form_open('pekerjaans/apply_pekerjaan/1', $attributes, $hidden);?>
							<input type="text" placeholder="Nama Lengkap" name="full_name" value=""/>
							<input type="text" placeholder="Email Address" name="email" value=""/>
							<textarea placeholder="Your message / cover letter" name="message"  id="cover_letter"></textarea>
							<input type="hidden" name="pekerjaan_id" value="<?php echo $pekerjaan_id;?>">
							<input type="hidden" name="user_id" value="0">

							<!-- Upload CV -->
							<div class="upload-info">
								<strong>Unggah CV Anda</strong> 
								<span>Max. file size: 5MB</span>
							</div>
							<div class="clearfix"></div>

							<label class="upload-btn">
								<input type="file" id="resume" name="resume" />
								<i class="fa fa-upload"></i> Browse
							</label>
							<div class="divider"></div>

							<button type="submit" class="send">Kirin Lamaran</button>
						</form> 
					</div>
					
				</div>
			</div>

		</div>

	</div>
	<!-- Widgets / End -->
</div>
<div class="margin-top-50"></div>
<?php $this->load->view('frontend/hrastral/footer-block');?>