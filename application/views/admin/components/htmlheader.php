<?php $perusahaan = $this->Umb_model->read_info_setting_perusahaan(1);?>
<?php $favicon = base_url().'uploads/logo/favicon/'.$perusahaan[0]->favicon;?>
<?php $theme = $this->Umb_model->read_theme_info(1);?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $title;?></title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="icon" type="image/x-icon" href="<?php echo $favicon;?>">
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/fonts/fontawesome.css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/fonts/ionicons.css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/fonts/linearicons.css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/fonts/open-iconic.css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/fonts/pe-icon-7-stroke.css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/css/rtl/bootstrap.css" class="theme-settings-bootstrap-css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/css/rtl/appwork.css" class="theme-settings-appwork-css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/css/rtl/theme-corporate.css" class="theme-settings-theme-css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/css/rtl/colors.css" class="theme-settings-colors-css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/css/rtl/uikit.css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_vendor/assets/css/demo.css">
  <script src="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/js/polyfills.js"></script>
  <script src="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/js/material-ripple.js"></script>
  <script src="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/js/layout-helpers.js"></script>
  <!-- Theme settings-->
  <script src="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/js/theme-settings.js"></script> 
  <script>
    window.themeSettings = new ThemeSettings({
      cssPath: '<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/css/rtl/',
      themesPath: '<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/css/rtl/'
    });
  </script>
  <script src="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/js/pace.js"></script>
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css">
  <!-- hrastral vendor -->
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/toastr/toastr.min.css">
  <link media="all" type="text/css" rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_vendor/assets/css/animate.css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/libs/datatables/datatables.css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/Trumbowyg/dist/ui/trumbowyg.css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/libs/select2/select2.css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/libs/bootstrap-tagsinput/bootstrap-tagsinput.css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/libs/smartwizard/smartwizard.css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/libs/jquery-ui/jquery-ui.css">
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
<?php if($this->router->fetch_method() =='notifications') { ?>
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/css/pages/messages.css">
<?php } ?>
</head>