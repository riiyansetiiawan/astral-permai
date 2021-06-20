<?php $perusahaan = $this->Umb_model->read_info_setting_perusahaan(1);?>
<div class="margin-top-0"></div>
<div id="footer">
	<!-- Main -->
	<div class="container">

		<div class="seven columns">
			<h4>Tetnatang Kami</h4>
			<p>Perusahaan yang bergerak dibidang Pengelolaan Fasilitas Gedung (Facility Management Services) dan didukung oleh sumber daya manusia yang kompeten dan ahli dibidangnya dan fokus melayani pelanggan dibidang pengelolaan fasilitas gedung dengan beberapa spesialisasi antara lain : Engineering Services, Cleaning Services, Office Management, Oprator Telepon, dan lainnya.</p>
			<?php $session = $this->session->userdata('c_user_id');?>
		</div>

		<div class="three columns">
			<h4>Perusahaan</h4>
			<ul class="footer-links">
				<li><a href="<?php echo site_url('page/view/');?>xl9wkRy7tqOehBo6YCDjFG2JTucpKI4gMNsn8Zdf">Tentang Kami</a></li>
				<li><a href="<?php echo site_url('page/view/');?>5uk4EUc3V9FYTbBQz7PWgKM6qCajfAipvhOJnZHl">Organisasi</a></li>
				<li><a href="<?php echo site_url('page/view/');?>5r6OCsUoHQFiRwI17W0eT38jbvpxEGuLhzgmt9lZ">Visi Dan Misi</a></li>
				<li><a href="<?php echo site_url('page/view/');?>QrfbMOUWpdYNxjLFz8G1m6t3wi0X2RKEZVC9ySka">Karir</a></li>
				<li><a href="<?php echo site_url('page/view/');?>rjHKhmsNezT2OJBAoQq0yU1tL5F34MCwgIiZEc7x">Kebijakan Perusahaan</a></li>
				<li><a href="<?php echo site_url('page/view/');?>gZbBVMxnfzYLlC2AOk609Q7yWpaSjmJHuRXosr58">Info</a></li>
			</ul>
		</div>	

		<div class="three columns">
			<h4>Kontak Kami</h4>
			<p>ALAMAT</p>
			<p>Jl. Srengseng Raya No.40 RT.002 RW.006 Kembangan Jakarta Barat</p>
			<p>
				Phone : 021-5446099<br/>
				Email : astral@gmail.com<br/>
			</p>
		</div>

	</div>

	<!-- Bottom -->
	<div class="container">
		<div class="footer-bottom">
			<div class="sixteen columns">
				<h4>Follow Us</h4>
				<ul class="social-icons">
					<li><a class="facebook" href="#"><i class="icon-facebook"></i></a></li>
					<li><a class="twitter" href="#"><i class="icon-twitter"></i></a></li>
					<li><a class="gplus" href="#"><i class="icon-gplus"></i></a></li>
					<li><a class="linkedin" href="#"><i class="icon-linkedin"></i></a></li>
				</ul>
				<div class="copyrights">©  Copyright <?php echo date('Y');?> by <?php echo $perusahaan[0]->nama_perusahaan;?>. All Rights Reserved.</div>
			</div>
		</div>
	</div>

</div>
<!-- Back To Top Button -->
<div id="backtotop"><a href="#"></a></div>

</div>