<?php $session = $this->session->userdata('c_user_id');?>

<div id="banner" style="background-image: url(<?php echo base_url();?>skin/vendor/pekerjaans/hrastral/images/banner-home-01.jpg)" class="parallax background" data-img-width="2000" data-img-height="1330" data-diff="400">
	<div class="container">
		<div class="two columns">
			&nbsp;
		</div>
		<div class="twelve columns">

			<div class="search-container">

				<!-- Form -->
				<h2>Find job</h2>
				<form method="get" name="search-pekerjaan" action="<?php echo site_url('pekerjaans/');?>" accept-charset="utf-8">
					<input type="text" name="search" class="ico-01" placeholder="Enter job title..." value=""/>
					<button type="submit"><i class="fa fa-search"></i></button>
				</form>

				<!-- Browse Jobs -->
				<div class="browse-pekerjaans">
					Telusuri tawaran pekerjaan menurut <a href="<?php echo site_url('pekerjaans/kategoris');?>"> Kategori</a>
				</div>

				<!-- Announce -->
				<div class="announce">
					Kami sudah selesai <strong><?php echo $this->Post_pekerjaan_model->all_active_pekerjaans();?></strong> Tawaran pekerjaan untukmu!
				</div>

			</div>

		</div>
	</div>
</div>
<!-- Icon Boxes -->
<div class="section-background top-0">
	<div class="container">

		<div class="one-third column">
			<div class="icon-box rounded alt">
				<i class="ln ln-icon-Folder-Add"></i>
				<h4>Add Resume</h4>
				<p>Pellentesque habitant morbi tristique senectus netus ante et malesuada fames ac turpis egestas maximus neque.</p>
			</div>
		</div>

		<div class="one-third column">
			<div class="icon-box rounded alt">
				<i class="ln ln-icon-Search-onCloud"></i>
				<h4>Pencarian untuk Pekerjan</h4>
				<p>Pellentesque habitant morbi tristique senectus netus ante et malesuada fames ac turpis egestas maximus neque.</p>
			</div>
		</div>

		<div class="one-third column">
			<div class="icon-box rounded alt">
				<i class="ln ln-icon-Business-ManWoman"></i>
				<h4>Find Crew</h4>
				<p>Pellentesque habitant morbi tristique senectus netus ante et malesuada fames ac turpis egestas maximus neque.</p>
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
					<!-- Listing -->
					<a href="<?php echo site_url('pekerjaans/detail/').$pekerjaan->url_pekerjaan;?>" class="listing <?php echo $clS;?> <?php echo $fCls;?>">
						<div class="listing-logo">
							<img src="<?php echo base_url().'uploads/employers/'.$employer[0]->logo_perusahaan;?>" alt="">
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

			<a href="<?php echo site_url('pekerjaans');?>" class="button centered"><i class="fa fa-plus-circle"></i> Show More Jobs</a>
			<div class="margin-bottom-55"></div>
		</div>
	</div>

	<!-- Job Spotlight -->
	<div class="five columns">
		<h3 class="margin-bottom-5">Featured Jobs</h3>

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
							<li>
								<div class="spotlight-pekerjaan">
									<a href="<?php echo site_url('pekerjaans/detail/').$pekerjaan->url_pekerjaan;?>"><h4><?php echo $pekerjaan->title_pekerjaan;?> <span class="<?php echo $clS;?>"><?php echo $jt_type;?></span></h4></a>
									<span><i class="ln ln-icon-Clock-Back"></i> <?php echo $time_ago?></span>
									<p><?php echo htmlspecialchars_decode($pekerjaan->short_description);?></p>
									<a href="<?php echo site_url('pekerjaans/detail/').$pekerjaan->pekerjaan_id;?>" class="button">Apply For This Job</a>
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
<?php if(is_null($session)){?>
	<!-- Infobox -->
	<div class="infobox">
		<div class="container">
			<div class="sixteen columns">Start Building Your Own Job Board Now <a href="<?php echo site_url('user/sign_in');?>">Get Started</a></div>
		</div>
	</div>
<?php } ?>

<!-- Clients Carousel -->
<h3 class="centered-headline">Clients Who Have Trusted Us <span>The list of clients who have put their trust in us includes:</span></h3>
<div class="clearfix"></div>

<div class="container">

	<div class="sixteen columns">

		<!-- Navigation / Left -->
		<div class="one carousel column"><div id="showbiz_left_2" class="sb-navigation-left-2"><i class="fa fa-angle-left"></i></div></div>

		<!-- ShowBiz Carousel -->
		<div id="our-clients" class="showbiz-container fourteen carousel columns" >

			<!-- Portfolio Entries -->
			<div class="showbiz our-clients" data-left="#showbiz_left_2" data-right="#showbiz_right_2">
				<div class="overflowholder">

					<ul>
						<!-- Item -->
						<li><img src="<?php echo base_url();?>skin/vendor/pekerjaans/hrastral/images/logo-01.png" alt="" /></li>
						<li><img src="<?php echo base_url();?>skin/vendor/pekerjaans/hrastral/images/logo-02.png" alt="" /></li>
						<li><img src="<?php echo base_url();?>skin/vendor/pekerjaans/hrastral/images/logo-03.png" alt="" /></li>
						<li><img src="<?php echo base_url();?>skin/vendor/pekerjaans/hrastral/images/logo-04.png" alt="" /></li>
						<li><img src="<?php echo base_url();?>skin/vendor/pekerjaans/hrastral/images/logo-05.png" alt="" /></li>
						<li><img src="<?php echo base_url();?>skin/vendor/pekerjaans/hrastral/images/logo-06.png" alt="" /></li>
						<li><img src="<?php echo base_url();?>skin/vendor/pekerjaans/hrastral/images/logo-07.png" alt="" /></li>
					</ul>
					<div class="clearfix"></div>

				</div>
				<div class="clearfix"></div>

			</div>
		</div>

		<!-- Navigation / Right -->
		<div class="one carousel column"><div id="showbiz_right_2" class="sb-navigation-right-2"><i class="fa fa-angle-right"></i></div></div>

	</div>

</div>
<!-- Container / End -->