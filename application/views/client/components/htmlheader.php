<?php $perusahaan = $this->Umb_model->read_info_setting_perusahaan(1);?>
<?php $favicon = base_url().'uploads/logo/favicon/'.$perusahaan[0]->favicon;?>
<?php $theme = $this->Umb_model->read_theme_info(1);?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $title;?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="icon" type="image/x-icon" href="<?php echo $favicon;?>">

  <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900" rel="stylesheet">

  <!-- Icon fonts -->
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/fonts/fontawesome.css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/fonts/ionicons.css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/fonts/linearicons.css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/fonts/open-iconic.css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/fonts/pe-icon-7-stroke.css">

  <!-- Core stylesheets -->
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/css/rtl/bootstrap.css" class="theme-settings-bootstrap-css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/css/rtl/appwork.css" class="theme-settings-appwork-css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/css/rtl/theme-corporate.css" class="theme-settings-theme-css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/css/rtl/colors.css" class="theme-settings-colors-css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/css/rtl/uikit.css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_vendor/assets/css/demo.css">
  <script src="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/js/polyfills.js"></script>
  <script src="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/js/material-ripple.js"></script>
  <script src="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/js/layout-helpers.js"></script>

  <!-- Theme settings -->
  <script src="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/js/theme-settings.js"></script>
  <script>
    window.themeSettings = new ThemeSettings({
      cssPath: '<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/css/rtl/',
      themesPath: '<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/css/rtl/'
    });
  </script>
  <!-- Core scripts -->
  <script src="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/js/pace.js"></script>
  <!-- Libs -->
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css">
  <!-- hrastral vendor -->
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/toastr/toastr.min.css">
  <link media="all" type="text/css" rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_vendor/assets/css/animate.css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/libs/datatables/datatables.css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/Trumbowyg/dist/ui/trumbowyg.css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/libs/select2/select2.css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/libs/bootstrap-tagsinput/bootstrap-tagsinput.css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/libs/smartwizard/smartwizard.css">
  <!-- Picker -->
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/libs/flatpickr/flatpickr.css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/libs/bootstrap-material-datetimepicker/bootstrap-material-datetimepicker.css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/libs/timepicker/timepicker.css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/css/pages/kontaks.css">
  <!-- Conditions-->
  <?php if($this->router->fetch_class() =='roles') { ?>
    <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/kendo/kendo.common.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/kendo/kendo.default.min.css">
  <?php } ?>
  <?php if($this->router->fetch_class() =='laporans' ) { ?>
    <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/css/pages/file-manager.css">
  <?php } ?>
  <?php if($this->router->fetch_class() =='chat') { ?>
    <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/css/pages/chat.css">
  <?php } ?>
  <?php if($this->router->fetch_class() =='calendar' || $this->router->fetch_class() =='timesheet' || $this->router->fetch_class() =='dashboard' || $this->router->fetch_method() =='timecalendar' || $this->router->fetch_method() =='calendar_projects' || $this->router->fetch_method() =='calendar_tugass' || $this->router->fetch_method() =='quote_calendar' || $this->router->fetch_method() =='calendar_invoice' || $this->router->fetch_method() =='dashboard_projects' || $this->router->fetch_method() =='calendar'){?>
   <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/libs/fullcalendar/dist/fullcalendar.css">
   <link href="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/libs/fullcalendar/dist/scheduler.min.css" rel="stylesheet">
 <?php } ?>
 <?php if($this->router->fetch_method() =='scrum_board_tugass' || $this->router->fetch_method() =='scrum_board_projects') { ?>
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/libs/dragula/dragula.css">
<?php } ?>
<?php if($this->router->fetch_class() =='events' || $this->router->fetch_class() =='meetings'){?>
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/libs/minicolors/minicolors.css">
<?php } ?>
<?php if($this->router->fetch_class() =='tujuan_tracking' || $this->router->fetch_method() =='details_tugas' || $this->router->fetch_class() =='project' || $this->router->fetch_class() =='quoted_projects' || $this->router->fetch_method() =='details_project'){?>
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/ion.rangeSlider/css/ion.rangeSlider.css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/ion.rangeSlider/css/ion.rangeSlider.skinFlat.css">
<?php } ?>
</head>
<?php /*?><!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $title;?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="icon" type="image/x-icon" href="<?php echo $favicon;?>">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_assets/theme_assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_assets/theme_assets/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_assets/theme_assets/bower_components/Ionicons/css/ionicons.min.css">
  
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_assets/theme_assets/dist/css/skins/_all-skins.min.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_assets/theme_assets/bower_components/morris.js/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_assets/theme_assets/bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_assets/theme_assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_assets/theme_assets/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_assets/theme_assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <!--<link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_assets/vendor/select2/select2.css">-->
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_assets/theme_assets/plugins/iCheck/all.css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_assets/theme_assets/bower_components/select2/dist/css/select2.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_assets/theme_assets/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_assets/vendor/jquery-ui/jquery-ui.css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_assets/vendor/toastr/toastr.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_assets/vendor/kendo/kendo.common.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_assets/vendor/kendo/kendo.default.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_assets/vendor/Trumbowyg/dist/ui/trumbowyg.css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_assets/vendor/clockpicker/dist/bootstrap-clockpicker.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_assets/css/hrastral/animate.css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_assets/css/hrastral/umb_custom.css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_assets/css/hrastral/umb_hrastral.css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_assets/css/hrastral/umb_ihrastral.css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_assets/vendor/libs/bootstrap-tagsinput/bootstrap-tagsinput.css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_assets/theme_assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  
</head><?php */?>