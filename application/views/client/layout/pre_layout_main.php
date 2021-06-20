<?php
$session = $this->session->userdata('client_username');
$system = $this->Umb_model->read_setting_info(1);
$layout = $this->Umb_model->system_layout();
$info_perusahaan = $this->Umb_model->read_info_setting_perusahaan(1);
$user_info = $this->Clients_model->read_info_client($session['client_id']);
?>
<?php $this->load->view('client/components/htmlheader');?>
<?php echo $subview;?>
<?php $this->load->view('client/components/htmlfooter');?>
          