<?php 
$session = $this->session->userdata('username');
$user_info = $this->Umb_model->read_user_info($session['user_id']);
$theme = $this->Umb_model->read_theme_info(1);
?>
<?php
if($user_info[0]->user_role_id==1):
	if($theme[0]->dashboard_option == 'dashboard_1') {
		$this->load->view('admin/dashboard/administrator_dashboard_1');
	} else if($theme[0]->dashboard_option == 'dashboard_light_2') {
		$this->load->view('admin/dashboard/administrator_dashboard_light_2');
	} else if($theme[0]->dashboard_option == 'dashboard_dark_2') {
		$this->load->view('admin/dashboard/administrator_dashboard_dark_2');
	} else if($theme[0]->dashboard_option == 'dashboard_3') {
		$this->load->view('admin/dashboard/administrator_dashboard_3');
	} else {
		$this->load->view('admin/dashboard/administrator_dashboard_1');
	}
/*elseif($user_info[0]->user_role_id==3):
	$this->load->view('admin/dashboard/management_dashboard');*/
else:
	$this->load->view('admin/dashboard/dashboard_karyawan');
endif;?>