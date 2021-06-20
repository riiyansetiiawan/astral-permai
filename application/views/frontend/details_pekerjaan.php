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
  <title><?php echo $title_pekerjaan?></title>
  <!-- Custom css -->
  <link rel="stylesheet" href="<?php echo base_url();?>skin/vendor/pekerjaans/assets/css/app.css">
  <!-- Favicon -->
  <link rel="Shortcut Icon"  href="<?php echo $favicon;?>"  type="image/x-icon">
  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
    <script src="<?php echo base_url();?>skin/vendor/pekerjaans/assets/js/html5shiv.min.js"></script>
    <script src="<?php echo base_url();?>skin/vendor/pekerjaans/assets/js/respond.min.js"></script>
  <![endif]-->
    <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_assets/vendor/toastr/toastr.min.css">
  </head>
  <body>
    <div class="page-loader"></div>
    <header class="main-header"> 
      <nav class="navbar">
        <div class="container"> 
          <a href="<?php echo site_url('frontend/pekerjaans');?>" class="navbar-brand">
            <img src="<?php echo base_url();?>uploads/logo/pekerjaan/<?php echo $system[0]->logo_pekerjaan;?>"> </a> 

            <div class="navs"> 
              <ul class="nav navbar-nav account">
                <li><?php if(!empty($esession)):?>
                <a href="<?php echo site_url('hr/logout');?>"><i class="md-lock-open m-r-10"></i><?php echo $this->lang->line('left_logout');?></a>
              <?php else:?>
                <a href="<?php echo site_url('admin/logout');?>"><i class="md-lock-open m-r-10"></i><?php echo $this->lang->line('left_logout');?></a>
                <?php endif;?></li>
              </ul>
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
      <?php $pekerjaan_penunjukan = $this->Penunjukan_model->read_informasi_penunjukan($penunjukan_id);?>
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
     <section class="page-header lighten-4" style="background: url(<?php echo base_url();?>skin/vendor/pekerjaans/assets/images/cover-1.jpg)">
      <div class="container">
        <h2><?php echo $title_pekerjaan?></h2>
        <div class="row m-t-b-30">
          <div class="col-sm-12 col-lg-4 col-xl-2 col-sm-offset-4"> <a href="#" class="btn btn-primary btn-block btn-lg" data-toggle="modal" data-target=".apply-pekerjaan" data-pekerjaan_id="<?php echo $pekerjaan_id;?>"><?php echo $this->lang->line('umb_apply_for_this_pekerjaan');?></a> </div>
        </div>
        <div><?php echo $nama_penunjukan;?> (<?php echo $nama_department;?>)</div>
      </div>
    </section>
    <section class="bg-white">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <ul class="row simple">
              <li class="col-sm-2 col-xs-6">
                <h5 class="m-b-5"><i class="md-long-arrow-right m-r-10"></i><?php echo $this->lang->line('umb_penunjukan');?></h5>
                <span><?php echo $nama_penunjukan;?></span> </li>
                <li class="col-sm-2 col-xs-6">
                  <h5 class="m-b-5"><i class="md-long-arrow-right m-r-10"></i><?php echo $this->lang->line('umb_jenis_kelamin_karyawan');?></h5>
                  <span>
                    <?php if($jenis_kelamin=='0'):?>
                      <?php echo $this->lang->line('umb_jenis_kelamin_pria');?>
                    <?php endif;?>
                    <?php if($jenis_kelamin=='1'):?>
                      <?php echo $this->lang->line('umb_jenis_kelamin_perempuan');?>
                    <?php endif;?>
                    <?php if($jenis_kelamin=='2'):?>
                      <?php echo $this->lang->line('umb_pekerjaan_no_preference');?>
                    <?php endif;?>
                  </span> </li>
                  <li class="col-sm-2 col-xs-6">
                    <h5 class="m-b-5"><i class="md-long-arrow-right m-r-10"></i><?php echo $this->lang->line('umb_pengalaman');?></h5>
                    <span>
                      <?php if($minimum_pengalaman=='0'):?>
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
                      <?php endif;?>
                    </span> </li>
                    <li class="col-sm-2 col-xs-6">
                      <h5 class="m-b-5"><i class="md-long-arrow-right m-r-10"></i><?php echo $this->lang->line('umb_lowongan');?></h5>
                      <span><?php echo $lowongan_pekerjaan;?></span> </li>
                      <li class="col-sm-2 col-xs-6">
                        <h5 class="m-b-5"><i class="md-long-arrow-right m-r-10"></i><?php echo $this->lang->line('umb_apply_before');?></h5>
                        <span><?php echo date('M d, Y', strtotime($tanggal_penutupan));?></span> </li>
                        <li class="col-sm-2 col-xs-6">
                          <h5 class="m-b-5"><i class="md-long-arrow-right m-r-10"></i><?php echo $this->lang->line('umb_tanggal_posting');?></h5>
                          <span><?php echo date('M d, Y', strtotime($created_at));?></span> </li>
                        </ul>
                        <hr class="sm">
                        <article>
                          <div class="content-row"> <?php echo htmlspecialchars_decode($long_description);?> </div>
                        </article>
                      </div>
                    </div>
                  </div>
                </section>
                <!-- Footer start -->
                <div class="modal fade apply-pekerjaan" id="apply-pekerjaan" tabindex="-1" role="dialog" aria-labelledby="apply-pekerjaan" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content" id="ajax_modal"></div>
                  </div>
                </div>
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
                  <!--<script type="text/javascript" src="<?php echo base_url();?>skin/vendor/jquery/jquery-1.12.3.min.js"></script> --> 
                  <script src="<?php echo base_url();?>skin/vendor/pekerjaans/assets/js/jquery/jquery.min.js"></script> 
                  <!-- Jquery ui --> 
                  <script src="<?php echo base_url();?>skin/vendor/pekerjaans/assets/js/jquery/jquery-ui.min.js"></script> 
                  <!-- Bootstrap --> 
                  <script src="<?php echo base_url();?>skin/vendor/pekerjaans/assets/js/bootstrap/bootstrap.min.js"></script> 
                  <!-- Bootstrap slider --> 
                  <!--<script src="<?php echo base_url();?>skin/vendor/pekerjaans/assets/js/bootstrap-slider/bootstrap-slider.min.js"></script> -->
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
                  <script type="text/javascript" src="<?php echo base_url();?>skin/hrastral_assets/vendor/toastr/toastr.min.js"></script> 
                  <script type="text/javascript">
                    $(document).ready(function(){
                     toastr.options.closeButton = true;
                     toastr.options.progressBar = false;
                     toastr.options.timeOut = 3000;
                     toastr.options.positionClass = "toast-bottom-right";

                     $("#apply_pekerjaan").submit(function(e){
                      var fd = new FormData(this);
                      var obj = $(this), action = obj.attr('name');
                      fd.append("is_ajax", 6);
                      fd.append("type", 'apply_pekerjaan');
                      fd.append("data", 'apply_pekerjaan');
                      fd.append("form", action);
                      e.preventDefault();
                      $('.save').prop('disabled', true);
                      $.ajax({
                       url: e.target.action,
                       type: "POST",
                       data:  fd,
                       contentType: false,
                       cache: false,
                       processData:false,
                       success: function(JSON)
                       {
                        if (JSON.error != '') {
                         toastr.error(JSON.error);
                         $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
                         $('.save').prop('disabled', false);
                       } else {
                         toastr.success(JSON.result);
                         $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
                         $('.apply-form').fadeOut('slow');
                         $('#apply_pekerjaan')[0].reset(); 
                         $('.save').prop('disabled', false);
                       }
                     },
                     error: function() 
                     {
                      toastr.error(JSON.error);
                      $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
                      $('.save').prop('disabled', false);
                    } 	        
                  });
                    });


                     $('.apply-pekerjaan').on('show.bs.modal', function (event) {
                      var button = $(event.relatedTarget);
                      var pekerjaan_id = button.data('pekerjaan_id');
                      var modal = $(this);
                      $.ajax({
                        url : "<?php echo site_url("frontend/pekerjaans/apply") ?>",
                        type: "GET",
                        data: 'jd=1&is_ajax=app_pekerjaan&mode=modal&data=apply_pekerjaan&type=apply_pekerjaan&pekerjaan_id='+pekerjaan_id,
                        success: function (response) {
                         if(response) {
                          $("#ajax_modal").html(response);
                        }
                      }
                    });
                    });
                   });
                 </script>
               </body>
               </html>