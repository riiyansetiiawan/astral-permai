<?php $session = $this->session->userdata('c_user_id'); ?>
<?php $url_pekerjaan = $this->uri->segment(3);?>
<?php $result = $this->Post_pekerjaan_model->read_info_pekerjaan_melalui_url($url_pekerjaan);?>
<?php
if(is_null($result)){
	redirect('employer/manage_pekerjaans');
}
?>
<div class="container">
	<!-- Table -->
	<div class="sixteen columns">

		<p class="margin-bottom-25" style="float: left;">Lamaran pekerjaan untuk <strong><a href="<?php echo site_url('pekerjaans/detail/').$result[0]->url_pekerjaan;?>"><?php echo $result[0]->title_pekerjaan?></a></strong> tercantum di bawah ini.</p>
	</div>
	<!-- Applications -->
	<div class="sixteen columns">
		
		<?php $kandidats = $this->Recruitment_model->get_applied_kandidats_pekerjaans($url_pekerjaan);?>
		<?php foreach($kandidats->result() as $r) {?>
			<?php $created_at = $this->Umb_model->set_date_format($r->created_at);?>
			<?php
			$pekerjaan = $this->Post_pekerjaan_model->read_informasi_pekerjaan($r->pekerjaan_id);
			if(!is_null($pekerjaan)){
				$title_pekerjaan = $pekerjaan[0]->title_pekerjaan;
			} else {
				$title_pekerjaan = '--';	
			}
			?>
			<div class="application">
				<div class="app-content">
					<!-- Name / -->
					<div class="info">
						<span><?php echo $r->full_name;?></span>
						<ul>
							<li><a href="<?php echo site_url('download/')?>?type=resume&filename=<?php echo $r->pekerjaan_resume;?>"><i class="fa fa-file-text"></i> Download CV</a></li>
						</ul>
					</div>

					<!-- Buttons -->
					<div class="buttons">
						<a href="#three-1" class="button gray app-link"><i class="fa fa-plus-circle"></i>Detail</a>
					</div>
					<div class="clearfix"></div>

				</div>

				<!--  Hidden Tabs -->
				<div class="app-tabs">

					<a href="#" class="close-tab button gray"><i class="fa fa-close"></i></a>
					<!-- Third Tab -->
					<div class="app-tab-content"  id="three-1">
						<i>Nama Lengkap:</i>
						<span><?php echo $r->full_name;?></span>

						<i>Email:</i>
						<span><?php echo $r->email;?></span>

						<i>Pesan:</i>
						<span><?php echo $r->message;?> </span>
					</div>

				</div>

				<!-- Footer -->
				<div class="app-footer">
					<ul>
						<li><i class="fa fa-file-text-o"></i> Baru</li>
						<li><i class="fa fa-calendar"></i> <?php echo $created_at;?></li>
					</ul>
					<div class="clearfix"></div>

				</div>
			</div>
		<?php } ?>
	</div>
</div>
<div class="margin-top-60"></div>