<?php $session = $this->session->userdata('c_user_id');?>
<?php $system = $this->Umb_model->read_setting_info(1);?>
<?php $perusahaan = $this->Umb_model->read_info_setting_perusahaan(1);?>
<div class="fullwidthbanner-container">
	<div class="fullwidthbanner">
		<ul>
			<li data-fstransition="fade" data-transition="fade" data-slotamount="10" data-masterspeed="300">
				<img src="<?php echo base_url();?>skin/pekerjaans/hrastral/images/banner-02.jpg" alt="">

				<div class="caption title sfb" data-x="center" data-y="195" data-speed="400" data-start="800"  data-easing="easeOutExpo">
					<h2>Astral Permai</h2>
				</div>

				<div class="caption text align-center sfb" data-x="center" data-y="270" data-speed="400" data-start="1200" data-easing="easeOutExpo">
					<p><?php echo $perusahaan[0]->nama_perusahaan;?> adalah fokus melayani pelanggan dibidang pengelolaan fasilitas gedung dengan beberapa spesialisasi antara lain : Building Operation & Maintenance  Management Services, Engineering Services, Cleaning Services, Office Management, Outsourcing dan lainnya.</p>
				</div>

				<div class="caption sfb" data-x="center" data-y="400" data-speed="400" data-start="1600" data-easing="easeOutExpo">
					<a href="<?php echo site_url('employer/post_pekerjaan');?>" class="slider-button">Post a Job</a>
				</div>
			</li>
		</ul>
	</div>
</div>
<!-- Icon Boxes -->
<div class="section-background top-0">
	<div class="container">

		<div class="one-third column">
			<div class="icon-box rounded alt">
				<i class="ln ln-icon-Folder-Add"></i>
				<h4>Pekerjaan</h4>
				<p>Perusahaan kami fokus melayani pelanggan dibidang pengelolaan fasilitas gedung dengan beberapa spesialisasi antara lain : Building Operation & Maintenance  Management Services, Engineering Services, Cleaning Services, Office Management, Outsourcing dan lainnya.</p>
			</div>
		</div>

		<div class="one-third column">
			<div class="icon-box rounded alt">
				<i class="ln ln-icon-Search-onCloud"></i>
				<h4>Search Resumes</h4>
				<p>Pellentesque habitant morbi tristique senectus netus ante et malesuada fames ac turpis egestas maximus neque.</p>
			</div>
		</div>

		<div class="one-third column">
			<div class="icon-box rounded alt">
				<i class="ln ln-icon-Business-ManWoman"></i>
				<h4>Kandidat Karyawan</h4>
				<p>Kandidat karyawan perusahaan kami sudah memiliki standar kerja yang baik dalm segi pekerjaaan maupu n etitud dan kandidat yang di berikan untuk mengisi ruang lingkup perusahaan client adalah kandidat yang sudah perefesional dari segi pekerjaan.</p>
			</div>
		</div>

	</div>
</div>
<div class="container">
	
	<!-- Recent Jobs -->
	<div class="eleven columns">
		<div class="padding-right">
			<h3 class="margin-bottom-25">Recent Jobs</h3>
			<div class="listings-container">
				<?php foreach($all_pekerjaans as $pekerjaan) {?>
					<?php $jtype = $this->Post_pekerjaan_model->read_informasi_type_pekerjaan($pekerjaan->type_pekerjaan); ?>
					<?php $employer = $this->Recruitment_model->read_info_employer($pekerjaan->employer_id);?>
					<?php
					if(!is_null($employer)){
						$employer_logo = $employer[0]->logo_perusahaan;
					} else {
						$employer_logo = '';
					}
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
						$clS = 'full-time';	
					}
					?>
					<?php
					if($pekerjaan->is_featured==1):
						$fCls = 'featured';
					else:
						$fCls = '';
					endif;
					?>  
					<!-- Listing -->
					<?php $time_ago = $this->Recruitment_model->timeAgo($pekerjaan->created_at);?>
					<!-- Listing -->
					<a href="<?php echo site_url('pekerjaans/detail/').$pekerjaan->url_pekerjaan;?>" class="listing <?php echo $clS;?> <?php echo $fCls;?>">
						<div class="listing-logo">
							<img src="<?php echo base_url().'uploads/employers/'.$employer_logo;?>" alt="">
						</div>
						<div class="listing-title">
							<h4><?php echo $pekerjaan->title_pekerjaan;?> <span class="listing-type"><?php echo $jt_type;?></span></h4>
							<ul class="listing-icons">
								<li><i class="ln ln-icon-Male"></i> <?php if($pekerjaan->jenis_kelamin=='0'):?>
								<?php echo $this->lang->line('umb_jenis_kelamin_pria');?>
							<?php endif;?>
							<?php if($pekerjaan->jenis_kelamin=='1'):?>
								<?php echo $this->lang->line('umb_jenis_kelamin_perempuan');?>
							<?php endif;?>
							<?php if($pekerjaan->jenis_kelamin=='2'):?>
								<?php echo $this->lang->line('umb_pekerjaan_no_preference');?>
								<?php endif;?></li>
								<li><i class="ln ln-icon-Professor"></i> <?php if($pekerjaan->minimum_pengalaman=='0'):?>
								<?php echo $this->lang->line('umb_fresh_pekerjaan');?>
							<?php endif;?>
							<?php if($pekerjaan->minimum_pengalaman=='1'):?>
								<?php echo $this->lang->line('umb_pengalaman_pekerjaan_define_1year');?>
							<?php endif;?>
							<?php if($pekerjaan->minimum_pengalaman=='2'):?>
								<?php echo $this->lang->line('umb_pengalaman_pekerjaan_define_2years');?>
							<?php endif;?>
							<?php if($pekerjaan->minimum_pengalaman=='3'):?>
								<?php echo $this->lang->line('umb_pengalaman_pekerjaan_define_3years');?>
							<?php endif;?>
							<?php if($pekerjaan->minimum_pengalaman=='4'):?>
								<?php echo $this->lang->line('umb_pengalaman_pekerjaan_define_4years');?>
							<?php endif;?>
							<?php if($pekerjaan->minimum_pengalaman=='5'):?>
								<?php echo $this->lang->line('umb_pengalaman_pekerjaan_define_5years');?>
							<?php endif;?>
							<?php if($pekerjaan->minimum_pengalaman=='6'):?>
								<?php echo $this->lang->line('umb_pengalaman_pekerjaan_define_6years');?>
							<?php endif;?>
							<?php if($pekerjaan->minimum_pengalaman=='7'):?>
								<?php echo $this->lang->line('umb_pengalaman_pekerjaan_define_7years');?>
							<?php endif;?>
							<?php if($pekerjaan->minimum_pengalaman=='8'):?>
								<?php echo $this->lang->line('umb_pengalaman_pekerjaan_define_8years');?>
							<?php endif;?>
							<?php if($pekerjaan->minimum_pengalaman=='9'):?>
								<?php echo $this->lang->line('umb_pengalaman_pekerjaan_define_9years');?>
							<?php endif;?>
							<?php if($pekerjaan->minimum_pengalaman=='10'):?>
								<?php echo $this->lang->line('umb_pengalaman_pekerjaan_define_10years');?>
							<?php endif;?>
							<?php if($pekerjaan->minimum_pengalaman=='11'):?>
								<?php echo $this->lang->line('umb_pengalaman_pekerjaan_define_plus_10years');?>
								<?php endif;?></li>
								<li><div class="listing-date"><?php echo $time_ago?></div></li>
							</ul>
						</div>
					</a>
				<?php } ?> 
			</div>

			<a href="<?php echo site_url('pekerjaans');?>" class="button centered"><i class="fa fa-plus-circle"></i> Tampilkan Lebih Banyak Pekerjaan</a>
			<div class="margin-bottom-55"></div>
		</div>
	</div>

	<!-- Job Spotlight -->
	<div class="five columns">
		<h3 class="margin-bottom-5">Fitur Pekerjaan</h3>

		<!-- Navigation -->
		<div class="showbiz-navigation">
			<div id="showbiz_left_1" class="sb-navigation-left"><i class="fa fa-angle-left"></i></div>
			<div id="showbiz_right_1" class="sb-navigation-right"><i class="fa fa-angle-right"></i></div>
		</div>
		<div class="clearfix"></div>
		
		<!-- Showbiz Container -->
		<div id="spotlight-pekerjaan" class="showbiz-container">
			<div class="showbiz" data-left="#showbiz_left_1" data-right="#showbiz_right_1" data-play="#showbiz_play_1" >
				<div class="overflowholder">

					<ul>

						<?php foreach($all_featured_pekerjaans as $pekerjaan) {?>
							<?php $jtype = $this->Post_pekerjaan_model->read_informasi_type_pekerjaan($pekerjaan->type_pekerjaan); ?>
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
							<?php
							if($pekerjaan->is_featured==1):
								$fCls = 'featured';
							else:
								$fCls = '';
							endif;
							?>  
							<!-- Listing -->
							<?php $time_ago = $this->Recruitment_model->timeAgo($pekerjaan->created_at);?>
							<li>
								<div class="spotlight-pekerjaan">
									<a href="<?php echo site_url('pekerjaans/detail/').$pekerjaan->url_pekerjaan;?>"><h4><?php echo $pekerjaan->title_pekerjaan;?> <span class="<?php echo $clS;?>"><?php echo $jt_type;?></span></h4></a>
									<span><i class="ln ln-icon-Clock-Back"></i> <?php echo $time_ago?></span>
									<p><?php echo htmlspecialchars_decode($pekerjaan->short_description);?></p>
									<a href="<?php echo site_url('pekerjaans/detail/').$pekerjaan->url_pekerjaan;?>" class="button">Apply For This Job</a>
								</div>
							</li>
						<?php } ?> 
					</ul>
					<div class="clearfix"></div>

				</div>
				<div class="clearfix"></div>
			</div>
		</div>

	</div>
</div>
<?php $this->load->view('frontend/hrastral/testimonials-block');?>
<?php $this->load->view('frontend/hrastral/footer-block');?>