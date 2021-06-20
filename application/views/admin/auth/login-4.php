<?php $system = $this->Umb_model->read_setting_info(1);?>
<?php $perusahaan = $this->Umb_model->read_info_setting_perusahaan(1);?>
<?php $site_lang = $this->load->helper('language');?>
<?php $wz_lang = $site_lang->session->userdata('site_lang');?>
<?php $favicon = base_url().'uploads/logo/favicon/'.$perusahaan[0]->favicon;?>
<?php
$session = $this->session->userdata('username');
if(!empty($session)){ 
	redirect('admin/dashboard/');
}
?>
<?php
$session = $this->session->userdata('username');
if(empty($wz_lang)):
	$flg_icn = '<img src="'.base_url().'uploads/languages_flag/gb.gif">';
elseif($wz_lang == 'english'):
	$lang_code = $this->Umb_model->get_info_language($wz_lang);
	$flg_icn = $lang_code[0]->language_flag;
	$flg_icn = '<img src="'.base_url().'uploads/languages_flag/'.$flg_icn.'">';
else:
	$lang_code = $this->Umb_model->get_info_language($wz_lang);
	$flg_icn = $lang_code[0]->language_flag;
	$flg_icn = '<img src="'.base_url().'uploads/languages_flag/'.$flg_icn.'">';
endif;
if($system[0]->enable_auth_background!='yes'):
	$auth_bg = 'style="background-image: none;"';
else:
	$auth_bg = '';	
endif;
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $title; ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="icon" type="image/x-icon" href="<?php echo $favicon;?>">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_assets/theme_assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_assets/theme_assets/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_assets/theme_assets/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_assets/theme_assets/dist/css/AdminLTE.min.css">
  <!-- toastr -->
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_assets/vendor/toastr/toastr.min.css">
  <!-- animate -->
  <link media="all" type="text/css" rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_assets/css/hrastral/animate.css">
  <link media="all" type="text/css" rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_assets/css/hrastral/umb_login_3.css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body <?php echo $auth_bg;?>>
  <img id="hrload-img" src="<?php echo base_url()?>skin/img/loading.gif" style="">
  <style type="text/css">
    #hrload-img {
      display: none;
      z-index: 87896969;
      float: right;
      margin-right: 25px;
      margin-top: 0px;
    }
  </style>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-7 col-lg-8 authfy-panel-right hidden-xs hidden-sm">
        <div class="hero-heading">
          <div class="headline">
            <h3><?php echo $this->lang->line('umb_hrastral_welcome');?> <?php echo $perusahaan[0]->nama_perusahaan;?></h3>
            <p><?php echo $this->lang->line('umb_hrastral_panel_login_system_hr');?></p>
            <p><strong>Detail Login Super Admin:</strong><br>
              Username: riyansetiawan <br>
              Password: riyansetiawan$$##
            </p>
            <p><strong>Detail Login Karyawan:</strong><br>
              Username: hermansutrisno<br>
              Password: hermansutrisno$$##
            </p>
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-7 col-md-5 col-lg-4 authfy-panel-left">
        <div class="brand-logo text-center">
          <img src="<?php echo base_url();?>uploads/logo/signin/<?php echo $perusahaan[0]->sign_in_logo;?>" alt="hrastral-logo">
        </div>
        <!-- login start -->
        <div class="authfy-login">
          <!-- panel-login start -->
          <?php if($this->session->flashdata('reset_password_success')):?>
            <div class="alert alert-success alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <?php echo $this->lang->line('umb_reset_password_sukses_sent_email');?> </div>
            <?php endif;?>
            <div class="authfy-panel panel-login text-center active">
              <div class="authfy-heading">
                <h3 class="auth-title"><?php echo $this->lang->line('umb_hrastral_login_ke_account_anda');?></h3>
              </div>
              <div class="row">
                <div class="col-xs-12 col-sm-12">
                  <?php $attributes = array('class' => 'form-hrastral', 'name' => 'hrm-form', 'id' => 'hrm-form', 'data-redirect' => 'dashboard',
                  'data-form-table' => 'login', 'data-is-redirect' => '1', 'autocomplete' => 'off');?>
                  <?php $hidden = array('user_id' => 0);?>
                  <?php echo form_open('admin/auth/login', $attributes, $hidden);?>
                  <?php
                  if($system[0]->login_karyawan_id=='username'):
                   $login_txt = $this->lang->line('umb_login_username');
                   $login_title = $this->lang->line('dashboard_username');
                   $ilogn_info = 'riyansetiawan';
                   $ilogn_info2 = 'hermansutrisno';
                 else:
                   $login_txt = $this->lang->line('umb_login_email');
                   $login_title = $this->lang->line('dashboard_email');
                   $ilogn_info = 'administrator@hrastral.com';
                   $ilogn_info2 = 'hermansutrisno@hrastral.com';
                 endif;?>
                 <div class="form-group">
                  <input type="text" id="iusername" name="iusername" class="form-control" placeholder="<?php echo $login_txt;?>" autocomplete="off">
                </div>
                <div class="form-group">
                  <div class="pwdMask">
                    <input type="password" class="form-control" id="ipassword" name="ipassword" placeholder="Enter Password" autocomplete="off">
                  </div>
                </div>
                <div class="row remember-row">
                  <div class="col-xs-6 col-sm-6">
                    &nbsp;
                  </div>
                  <div class="col-xs-6 col-sm-6">
                    <p class="forgotPwd">
                      <a href="<?php echo site_url('admin/auth/forgot_password');?>" class="lnk-toggler"><?php echo $this->lang->line('umb_link_forgot_password');?></a>
                    </p>
                  </div>
                </div>
                <div class="form-group">
                  <?php echo form_button(array('name' => 'hrastral_form', 'type' => 'submit', 'class' => 'btn btn-primary btn-block btn-lg save', 'content' => '<i class="fa fa-lock"></i> '.$this->lang->line('umb_login'))); ?>
                </div>
                <?php echo form_close(); ?>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="btn-group">
                  <button type="button" class="btn bg-purple btn-flat btn-sm" data-toggle="dropdown" aria-expanded="false">Login sebagai</button>
                  <button type="button" class="btn bg-purple btn-flat btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> 
                    <span class="caret"></span> 
                    <span class="sr-only">Login sebgai</span> 
                  </button>
                  <ul class="dropdown-menu" role="menu">
                    <li><a class="dropdown-item login-as" href="javascript:void(0);" data-username="<?php echo $ilogn_info;?>" data-password="riyansetiawan$$##">Super Admin</a></li>
                    <li><a class="dropdown-item login-as" href="javascript:void(0);" data-username="<?php echo $ilogn_info2;?>" data-password="hermansutrisno$$##">Karyawan</a></li>
                  </ul>
                </div>
              </div>
              <!-- /.col -->
              <div class="col-md-4">
                <a target="_blank" href="<?php echo site_url('/');?>" class="btn btn-warning btn-block btn-flat btn-sm">Pekerjaan Terbaru</a>
              </div>
              <div class="col-md-4">
                <a target="_blank" href="<?php echo site_url('client/');?>" class="btn btn-danger btn-block btn-flat btn-sm">Panel Client </a>
              </div>
            </div>
          </div>
        </div> 
      </div>
    </div> 
  </div>
  <!-- jQuery 3 --> 
  <script src="<?php echo base_url();?>skin/hrastral_assets/theme_assets/bower_components/jquery/dist/jquery.min.js"></script> 
  <!-- Bootstrap 3.3.7 --> 
  <script src="<?php echo base_url();?>skin/hrastral_assets/theme_assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script> 
  <script type="text/javascript" src="<?php echo base_url();?>skin/hrastral_assets/vendor/jquery/jquery-3.2.1.min.js"></script> 
  <script type="text/javascript" src="<?php echo base_url();?>skin/hrastral_assets/vendor/toastr/toastr.min.js"></script> 
  <script type="text/javascript">
    $(document).ready(function(){
      toastr.options.closeButton = <?php echo $system[0]->notification_close_btn;?>;
      toastr.options.progressBar = <?php echo $system[0]->notification_bar;?>;
      toastr.options.timeOut = 3000;
      toastr.options.preventDuplicates = true;
      toastr.options.positionClass = "<?php echo $system[0]->notification_position;?>";
      var site_url = '<?php echo site_url(); ?>';
    });
  </script> 
  <script type="text/javascript">
    var site_url = '<?php echo base_url(); ?>';
    var processing_request = '<?php echo $this->lang->line('umb_permiuntaan_sedang_diproses');?>';
  </script> 
  <script type="text/javascript" src="<?php echo base_url();?>skin/hrastral_assets/hrastral_scripts/umb_login.js"></script> 
  <script type="text/javascript">
    $(document).ready(function(){
      $(".login-as").click(function(){
        var uname = jQuery(this).data('username');
        var password = jQuery(this).data('password');
        jQuery('#iusername').val(uname);
        jQuery('#ipassword').val(password);
      });
    });	
  </script>
</body>
</html>