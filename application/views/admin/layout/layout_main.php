<?php
$session = $this->session->userdata('username');
$system = $this->Umb_model->read_setting_info(1);
$info_perusahaan = $this->Umb_model->read_info_setting_perusahaan(1);
$layout = $this->Umb_model->system_layout();
$user_info = $this->Umb_model->read_user_info($session['user_id']);
$theme = $this->Umb_model->read_theme_info(1);
if($user_info[0]->fixed_header=='fixed_layout_hrastral') {
	$fixed_header = 'fixed';
} else {
	$fixed_header = '';
}
if($user_info[0]->boxed_wrapper=='boxed_layout_hrastral') {
	$boxed_wrapper = 'layout-boxed';
} else {
	$boxed_wrapper = '';
}
if($user_info[0]->compact_sidebar=='sidebar_layout_hrastral') {
	$compact_sidebar = 'sidebar-collapse';
} else {
	$compact_sidebar = '';
}
/*
if($this->router->fetch_class() =='chat'){
	$chat_app = 'chat-application';
} else {
	$chat_app = '';
}*/
$role_user = $this->Umb_model->read_user_role_info($user_info[0]->user_role_id);
if(!is_null($role_user)){
	$role_resources_ids = explode(',',$role_user[0]->role_resources);
} else {
	$role_resources_ids = explode(',',0);	
}
?>
<?php $this->load->view('admin/components/htmlheader');?>
<body>
  <div class="page-loader">
    <div class="bg-primary"></div>
  </div>
  <div class="layout-wrapper layout-2">
    <div class="layout-inner">
      <div id="layout-sidenav" class="layout-sidenav sidenav sidenav-vertical bg-dark">
        <div class="app-brand demo">
          <span class="app-brand-logo demo bg-primary">
            <img alt="<?php echo $system[0]->application_name;?>" src="<?php echo base_url();?>uploads/logo/<?php echo $info_perusahaan[0]->logo;?>" class="brand-logo" style="width:32px;">
          </span>
          <a href="<?php echo site_url('admin/dashboard');?>" class="app-brand-text demo sidenav-text font-weight-normal ml-2"><?php echo $system[0]->application_name;?></a>
          <a href="javascript:void(0)" class="layout-sidenav-toggle sidenav-link text-large ml-auto">
            <i class="ion ion-md-menu align-middle"></i>
          </a>
        </div>
        <div class="sidenav-divider mt-0"></div>
        <?php $this->load->view('admin/components/left_menu');?>
      </div>
      <div class="layout-container">
        <?php $this->load->view('admin/components/header');?>
        <div class="layout-content">
          <?php if($this->router->fetch_class() !='chat'){?>
            <?php $val_container = 'container-fluid flex-grow-1 container-p-y'; ?>
          <?php } else {?>
          	<?php $val_container = 'container-fluid d-flex align-items-stretch flex-grow-1 p-0'; ?>
          <?php } ?>
          <div class="<?php echo $val_container;?>">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <?php if($this->router->fetch_class() !='dashboard' && $this->router->fetch_class() !='chat' && $this->router->fetch_method() !='view_all'){?>
                <div>
                  <h4 class="font-weight-bold mt-3"><?php echo $breadcrumbs;?></h4>
                </div>
                <a href="<?php echo site_url('admin/logout');?>">
                  <button class="btn btn-lg btn-default">
                    <i class="ion ion-md-power text-danger"></i>&nbsp;
                    <?php echo $this->lang->line('header_sign_out');?>
                  </button>
                </a>
              <?php } ?>
            </div>
            <?php if($this->router->fetch_class() !='dashboard' && $this->router->fetch_class() !='chat' && $this->router->fetch_class() !='calendar'){?>
              <?php /*?><h4 class="font-weight-bold py-3 mb-4">
                <span class="text-muted font-weight-light">
                <!--<a class="text-muted font-weight-light" href="<?php echo site_url('admin/dashboard/');?>"><?php echo $this->lang->line('umb_e_details_home');?></a> /--></span> <?php echo $breadcrumbs;?>
                </h4><?php */?>
              <?php } ?>
              <?php // get the required layout..?>
              <?php echo $subview;?>
            </div>
            <?php $this->load->view('admin/components/footer');?>
          </div>
        </div>
      </div>
      <div class="layout-overlay layout-sidenav-toggle"></div>
    </div>
    <?php $this->load->view('admin/components/htmlfooter');?>
  </body>
  </html>