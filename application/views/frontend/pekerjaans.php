<?php $session = $this->session->userdata('username');?>
<?php $esession = $this->session->userdata('karyawan_id');?>
<?php $system = $this->Umb_model->read_setting_info(1);?>
<?php $perusahaan = $this->Umb_model->read_info_setting_perusahaan(1);?>
<?php $favicon = base_url().'uploads/logo/favicon/'.$perusahaan[0]->favicon;?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $title;?></title>
  <!-- Custom css -->
  <link rel="stylesheet" href="<?php echo base_url();?>skin/vendor/pekerjaans/assets/css/app.css">
  <!-- Favicon -->
  <link rel="Shortcut Icon"  href="<?php echo $favicon;?>"  type="image/x-icon">
  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
    <script src="assets/js/html5shiv.min.js"></script>
    <script src="assets/js/respond.min.js"></script>
  <![endif]-->
</head>
<body>
  <!-- Page loader start -->
  <div class="page-loader"></div>
  <!-- Page loader end --> 
  <!-- Header start -->
  <header class="main-header"> 
    <!-- Navbar start -->
    <nav class="navbar">
      <div class="container"> 
        <!-- Logo start --> 
        <a href="<?php echo site_url('frontend/pekerjaans');?>" class="navbar-brand">
          <img src="<?php echo base_url();?>uploads/logo/pekerjaan/<?php echo $system[0]->logo_pekerjaan;?>"></a> 
          <!-- Logo end --> 
          <!-- Navs start -->
          <div class="navs">
            <ul class="nav navbar-nav account">
              <li>
                <?php if(!empty($esession)):?>
                  <a href="<?php echo site_url('hr/logout');?>"><i class="md-lock-open m-r-10"></i><?php echo $this->lang->line('left_logout');?></a>
                  <?php else:?>
                    <a href="<?php echo site_url('admin/logout');?>"><i class="md-lock-open m-r-10"></i><?php echo $this->lang->line('left_logout');?></a>
                  <?php endif;?>
                </li>
              </ul>
              <!-- Main nav start -->
              <ul class="nav navbar-nav">
                <?php if(!empty($esession)):?>
                  <li> <a href="<?php echo site_url('hr/dashboard');?>"><?php echo $this->lang->line('umb_my_dashboard');?></a> </li>
                  <li> <a href="<?php echo site_url('hr/user/applied_pekerjaans');?>"><?php echo $this->lang->line('left_applied_pekerjaans');?></a> </li>
                  <li> <a href="<?php echo site_url('frontend/pekerjaans');?>"><?php echo $this->lang->line('umb_list_pekerjaans');?></a> </li>
                  <?php else:?>
                    <li> <a href="<?php echo site_url('admin/dashboard');?>"><?php echo $this->lang->line('umb_my_dashboard');?></a> </li>
                    <li> <a href="<?php echo site_url('frontend/pekerjaans');?>"><?php echo $this->lang->line('umb_list_pekerjaans');?></a> </li>
                  <?php endif;?>
                </ul>
                <!-- Main nav end --> 
              </div>
              <!-- Navs end --> 
              <!-- Responsive nav button start -->
              <ul class="nav navbar-nav responsive-btn">
                <li><a href="#"><i class="md-menu m-r-10"></i></a></li>
              </ul>
              <!-- Responsive nav button end --> 
            </div>
          </nav>
          <!-- Navbar end --> 
        </header>
        <!-- Header end -->
        <section class="page-header lighten-4" style="background: url(<?php echo base_url();?>skin/vendor/pekerjaans/assets/images/cover-2.jpg)">
          <div class="container">
            <h1> <span data-plugin="typed-js" data-plugin-string='["find the job you love","start now"]'></span> </h1>
          </div>
        </section>
        <section>
          <div class="container">
            <header class="section-header">
              <h3><?php echo $this->lang->line('umb_available_pekerjaans');?> <small>(
                <?php $pekerjaans = $this->Post_pekerjaan_model->get_pekerjaans(); echo $pekerjaans->num_rows()?>
              )</small></h3>
              <p><?php echo $this->lang->line('umb_newly_created_pekerjaans');?></p>
            </header>
            <div class="card">
              <div class="card-body">
                <?php foreach($all_pekerjaans as $pekerjaan) {?>
                  <?php $jtype = $this->Post_pekerjaan_model->read_informasi_type_pekerjaan($pekerjaan->type_pekerjaan); ?>
                  <?php
                  if(!is_null($jtype)){
                    $jt_type = $jtype[0]->type;
                  } else {
                    $jt_type = '--';	
                  }
                  ?>
                  <?php $pekerjaan_penunjukan = $this->Penunjukan_model->read_informasi_penunjukan($pekerjaan->penunjukan_id);?>
                  <?php
                  if(!is_null($pekerjaan_penunjukan)){
                    $nama_penunjukan = $pekerjaan_penunjukan[0]->nama_penunjukan;
                  } else {
                    $nama_penunjukan = '--';	
                  }
                  ?>
                  <?php $department = $this->Department_model->read_informasi_department($pekerjaan_penunjukan[0]->department_id);?>
                  <?php
                  if(!is_null($department)){
                    $nama_department = $department[0]->nama_department;
                  } else {
                    $nama_department = '--';	
                  }
                  ?>
                  <div class="item-postpekerjaan">
                    <div class="row">
                      <div class="col-md-5">
                        <h5> <a href="<?php echo site_url();?>frontend/pekerjaans/detail/<?php echo $pekerjaan->pekerjaan_id;?>/"> <?php echo $pekerjaan->title_pekerjaan;?></a> </h5>
                        <ul class="list-inline">
                          <li><?php echo date("j", strtotime($pekerjaan->created_at));?> <span><?php echo date("M", strtotime($pekerjaan->created_at));?></span></li>
                          <li>
                            <label class="label bg-green lighten-1"><?php echo $jt_type;?></label>
                          </li>
                        </ul>
                      </div>
                      <div class="col-md-5 postpekerjaan-location"> <span><?php echo $nama_penunjukan;?> > <?php echo $nama_department;?></span> </div>
                      <div class="col-md-2 postpekerjaan-apply-btn"> <a href="<?php echo site_url();?>frontend/pekerjaans/detail/<?php echo $pekerjaan->pekerjaan_id;?>/" class="btn btn-primary btn-block btn-outline btn-sm"><?php echo $this->lang->line('umb_apply_for_this_pekerjaan');?> <i class="md-long-arrow-right m-l-10"></i></a> </div>
                    </div>
                  </div>
                <?php } ?>
              </div>
            </div>
          </div>
        </section>
        <!-- Footer start -->
        <footer>
          <div class="container">
            <div class="row">
              <div class="col-md-12 col-xs-12">
                <p>
                  <?php if($system[0]->enable_current_year=='yes'):?>
                    <?php echo date('Y');?>
                  <?php endif;?>
                  © <?php echo $system[0]->footer_text;?></p>
                </div>
              </div>
            </div>
          </footer>
          <!-- Footer end --> 
          <!-- ================= Script files ================= --> 
          <!-- Jquery --> 
          <script src="<?php echo base_url();?>skin/vendor/pekerjaans/assets/js/jquery/jquery.min.js"></script> 
          <!-- Jquery ui --> 
          <script src="<?php echo base_url();?>skin/vendor/pekerjaans/assets/js/jquery/jquery-ui.min.js"></script> 
          <!-- Bootstrap --> 
          <script src="<?php echo base_url();?>skin/vendor/pekerjaans/assets/js/bootstrap/bootstrap.min.js"></script> 
          <!-- Bootstrap slider --> 
          <script src="<?php echo base_url();?>skin/vendor/pekerjaans/assets/js/bootstrap-slider/bootstrap-slider.min.js"></script> 
          <!-- Waves effect --> 
          <script src="<?php echo base_url();?>skin/vendor/pekerjaans/assets/js/waves/waves.min.js"></script> 
          <!-- Scroll animate effect --> 
          <script src="<?php echo base_url();?>skin/vendor/pekerjaans/assets/js/scroll.js"></script> 
          <!-- Owl carousel --> 
          <script src="<?php echo base_url();?>skin/vendor/pekerjaans/assets/js/owl-carousel/owl.carousel.min.js"></script> 
          <!-- Summernote editor --> 
          <script src="<?php echo base_url();?>skin/vendor/pekerjaans/assets/js/summernote/summernote.min.js"></script> 
          <!-- Typed.js --> 
          <script src="<?php echo base_url();?>skin/vendor/pekerjaans/assets/js/typed.min.js"></script> 
          <!-- Custom --> 
          <script src="<?php echo base_url();?>skin/vendor/pekerjaans/assets/js/app.js"></script>
        </body>
        </html>