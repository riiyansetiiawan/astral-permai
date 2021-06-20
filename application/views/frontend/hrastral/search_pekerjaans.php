<div class="container">
	<!-- Recent Jobs -->
	<div class="eleven columns">
		<div class="padding-right">

			<div class="listings-container">
				<?php if($count_search_pekerjaans > 0) {?>
					<?php foreach($results as $pekerjaan) {?>
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
				<?php } else {?>
					<h3 class="headline with-border margin-top-20 margin-bottom-35">No job found..</mark></span></h3>
				<?php } ?>  
			</div>
			<div class="clearfix"></div>

			<div class="pagination-container">
				<nav class="pagination">
					<!--<ul>-->
						<?php foreach ($links as $link) { ?>
							<?php echo $link;?>
						<?php } ?>
						<!--</ul>-->
					</nav>
				</div>

			</div>
		</div>


		<!-- Widgets -->
		<div class="five columns">        
			<!-- Category -->
			<div class="widget">
				<h4>Category</h4>

				<ul class="footer-links search-kategoris">
					<?php foreach($all_kategoris_pekerjaan as $kategori):?>
						<?php $count_cpekerjaans = $this->Recruitment_model->record_count_kategori_pekerjaan($kategori->kategori_url);?>
						<?php if($count_cpekerjaans > 0){?>
							<li><a href="<?php echo site_url('pekerjaans/search/kategori/').$kategori->kategori_url;?>"><?php echo $kategori->nama_kategori;?> (<?php echo $this->Recruitment_model->record_count_kategori_pekerjaan($kategori->kategori_url);?>)</a></li>
						<?php } ?>
					<?php endforeach;?>
				</ul>

			</div>
			<!-- Job Type -->
			<div class="widget">
				<h4>Type Pekerjaan</h4>

				<ul class="footer-links search-kategoris">
					<?php foreach($all_types_pekerjaan->result() as $itype_pekerjaan):?>
						<?php $count_pekerjaans = $this->Recruitment_model->record_count_type_pekerjaan($itype_pekerjaan->type_url);?>
						<?php if($count_pekerjaans > 0){?>
							<li><a href="<?php echo site_url('pekerjaans/search/type/').$itype_pekerjaan->type_url;?>"><?php echo $itype_pekerjaan->type;?> (<?php echo $this->Recruitment_model->record_count_type_pekerjaan($itype_pekerjaan->type_url);?>)</a></li>
						<?php } ?>
					<?php endforeach;?>
				</ul>
			</div>
		</div>	
		<!-- Widgets / End -->
	</div>
	<div class="margin-top-50"></div>
	<?php $this->load->view('frontend/hrastral/footer-block');?>