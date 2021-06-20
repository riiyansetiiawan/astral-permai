<?php $system = $this->Umb_model->read_setting_info(1);?>
<?php $perusahaan = $this->Umb_model->read_info_setting_perusahaan(1);?>
<?php $favicon = base_url().'uploads/logo/favicon/'.$perusahaan[0]->favicon;?>
<?php $session = $this->session->userdata('c_user_id'); ?>
<!DOCTYPE html>
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
	<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->

		<head>

<!-- Basic Page Needs
	================================================== -->
	<meta charset="utf-8">
	<title><?php echo $title;?></title>

<!-- Mobile Specific Metas
	================================================== -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="icon" type="image/x-icon" href="<?php echo $favicon;?>">
<!-- CSS
	================================================== -->
	<link rel="stylesheet" href="<?php echo base_url();?>skin/pekerjaans/hrastral/css/style.css">
	<link rel="stylesheet" href="<?php echo base_url();?>skin/pekerjaans/hrastral/css/colors/green.css" id="colors">
	<link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/toastr/toastr.min.css">
	<link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/libs/jquery-ui/jquery-ui.css">
	<link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/Trumbowyg/dist/ui/trumbowyg.css">
	<link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css">
	<link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/libs/flatpickr/flatpickr.css">
	<link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css">
	<link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/libs/bootstrap-material-datetimepicker/bootstrap-material-datetimepicker.css">
	<!--<link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_assets/css/hrastral/umb_hrastral.css">-->
<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
</head>

<body>

<!-- Header
	================================================== -->
	<header class="sticky-header">
		<div class="container">
			<div class="sixteen columns">

				<!-- Logo -->
				<div id="logo">
					<h1><a href="<?php echo site_url('');?>"><img src="<?php echo base_url();?>uploads/logo/pekerjaan/<?php echo $system[0]->logo_pekerjaan;?>" alt="<?php echo $title;?>" /></a></h1>
				</div>

				<!-- Menu -->
				<nav id="navigation" class="menu">
					<ul id="responsive">
						<li><a href="<?php echo site_url('');?>">Home</a><li>

							<li><a href="<?php echo site_url('pekerjaans');?>">Search Pekerjaan</a></li>
							<li><a href="<?php echo site_url('pekerjaans/kategoris');?>">Kategori Pekerjaan</a></li>
							<li><a href="<?php echo site_url('page/view/');?>xl9wkRy7tqOehBo6YCDjFG2JTucpKI4gMNsn8Zdf">Tentang Kami</a></li>
							<li><a href="<?php echo site_url('kontak_kami');?>">Kontak Kami</a></li>
							<?php if(!empty($session)){ ?>
								<li><a href="#"><i class="fa fa-user"></i> Profil Perusahaan</a>
									<ul>
										<li><a href="<?php echo site_url('employer/dashboard');?>">Dashboard</a></li>
										<li><a href="<?php echo site_url('employer/account');?>">Account Settings</a></li>
										<li><a href="<?php echo site_url('employer/post_pekerjaan');?>">Post Pekerjaan</a></li>
										<li><a href="<?php echo site_url('employer/manage_pekerjaans');?>">Manage Pekerjaan</a></li>
										<li><a href="<?php echo site_url('employer/change_password');?>">Change Password</a></li>
										<li><a href="<?php echo site_url('employer/logout');?>">Logout</a></li>
									</ul>
								</li>
							<?php }else {?>
								<li><a href="<?php echo site_url('employer/signup/');?>"><i class="fa fa-user"></i> Sign Up</a><li>
									<li><a href="<?php echo site_url('employer/sign_in/');?>"><i class="fa fa-lock"></i> Log In</a></li>
								<?php } ?>
							</li>
						</ul>
					</nav>

					<!-- Navigation -->
					<div id="mobile-navigation">
						<a href="#menu" class="menu-trigger"><i class="fa fa-reorder"></i> Menu</a>
					</div>

				</div>
			</div>
		</header>
		<div class="clearfix"></div>

		<?php if($this->router->fetch_class()!='welcome' && $this->router->fetch_class()!='pekerjaans') { ?>
			<?php
			if($this->router->fetch_class() == 'employer' && $this->router->fetch_method()=='post_pekerjaan'){
				$adJb = 'single submit-page';
			} else {
				$adJb = 'single';
			}
			?>
			<div id="titlebar" class="single">
				<div class="container">

					<div class="ten columns">
						<h2><?php echo $title;?></h2>
						<nav id="breadcrumbs">
							<ul>
								<li>Kamu di sini:</li>
								<li><a href="<?php echo site_url('');?>">Home</a></li>
								<li><?php echo $title;?></li>
							</ul>
						</nav>
					</div>
					<?php if($this->router->fetch_class()=='employer' && $this->router->fetch_method()=='account') { ?>
						<div class="six columns">
							<a href="<?php echo site_url('employer/post_pekerjaan');?>" class="button"><i class="fa fa-plus-circle"></i> Post Pekerjan</a>
						</div>
					<?php } ?>
					<?php if($this->router->fetch_method()=='manage_pekerjaans') { ?>
						<div class="six columns">
							<a href="<?php echo site_url('employer/post_pekerjaan');?>" class="button"><i class="fa fa-plus-circle"></i> Post Pekerjaan</a>
						</div>
					<?php } ?>
					<?php if($this->router->fetch_method()=='post_pekerjaan') { ?>
						<div class="six columns">
							<a href="<?php echo site_url('employer/manage_pekerjaans');?>" class="button"><i class="fa fa-arrow-circle-right"></i> Manage Pekerjaan</a>
						</div>
					<?php } ?>
					<?php if($this->router->fetch_method()=='edit_pekerjaan') { ?>
						<div class="six columns">
							<a href="<?php echo site_url('employer/manage_pekerjaans');?>" class="button"><i class="fa fa-arrow-circle-right"></i> Manage Pekerjaan</a>
						</div>
					<?php } ?>
					<?php if($this->router->fetch_method()=='sign_in') { ?>
						<div class="six columns">
							<a href="<?php echo site_url('employer/signup');?>" class="button">Register, It’s Free!</a>
						</div>
					<?php } ?>
				</div>
			</div>
		<?php } ?>
		<?php if($this->router->fetch_class()=='pekerjaans' && $this->router->fetch_method()!='detail') { ?>
			<div id="titlebar">
				<div class="container">
					<div class="ten columns">
						<?php if($this->router->fetch_method()=='kategoris') { ?>
							<h2>Semua Kategori</h2>
						<?php } else {?>
							<?php if($this->uri->segment(3)=='kategori') {?>
								<?php
								$csql = "SELECT * FROM umb_kategoris_pekerjaan WHERE kategori_url = '".$this->uri->segment(4)."'";
								$cquery = $this->db->query($csql);
								$kategori_info = $cquery->result();
								?>
								<span>We found <?php echo $count_search_pekerjaans;?> pencocokan pekerjaan:</span>
								<h2><?php echo ucwords(str_replace('-',' ',$kategori_info[0]->nama_kategori));?></h2>
							<?php } else if($this->uri->segment(3)=='type') {
								$csql = "SELECT * FROM umb_type_pekerjaan WHERE type_url = '".$this->uri->segment(4)."'";
								$cquery = $this->db->query($csql);
								$type_info = $cquery->result();
								?>
								<span>We found <?php echo $count_search_pekerjaans;?> pencocokan pekerjaan:</span>
								<h2><?php echo ucwords(str_replace('-',' ',$type_info[0]->type));?></h2>
							<?php } else {?>
								<?php if($this->input->get("search")) {?>
									<h2>We found <?php echo $count_search_pekerjaans;?> Pekerjaan Active</h2>
								<?php } else {?>
									<h2>We found <?php echo $this->Post_pekerjaan_model->all_active_pekerjaans();?> pekerjaan active</h2>
								<?php } ?>
							<?php } ?>
						<?php } ?>
						<div class="six columns">
							<a href="<?php echo site_url('employer/post_pekerjaan');?>" class="button">posting Pekerjaan!</a>
						</div>
					</div>

				</div>
			</div>
		<?php } ?>
		<!-- Container -->
		<?php echo $subview;?>
		<!-- Container / End -->

<!-- Footer
	================================================== -->
	<!--<div class="margin-top-20"></div>-->

	<?php $this->load->view('frontend/hrastral/components_pekerjaan/jfooter');?>
	<!-- Back To Top Button -->
<!--<div id="backtotop"><a href="#"></a></div>

</div>-->
<!-- Wrapper / End -->
<?php $this->load->view('frontend/hrastral/components_pekerjaan/html_jfooter');?>




</body>
</html>