<?php $session = $this->session->userdata('c_user_id');?>
<?php $employer = $this->Recruitment_model->read_info_employer($session['c_user_id']);?>
<div class="container">
  <div class="sixteen columns">
    <h2 class="my-acc-h2">Hello <strong><?php echo $employer[0]->first_name.' '.$employer[0]->last_name;?></strong></h2>
    <p class="woocommerce-dashboard-welcome"> Anda dapat melihat lamaran pekerjaan Anda</a>, manage your <a href="<?php echo site_url('employer/manage_pekerjaans');?>">Pekerjaan</a> Dan <a href="<?php echo site_url('employer/account');?>">edit password dan detail akun anda</a>.</p>
    <p> Untuk memeriksa Daftar Pekerjaan dan Lamaran Anda, kunjungi <a href="<?php echo site_url('employer/manage_pekerjaans');?>">Pekerjaan Terbaru</a>.<br>
    </p>
    <br>
    <a href="<?php echo site_url('employer/post_pekerjaan');?>" class="button">Add a Job</a> </div>
  </div>
  <div class="margin-top-50"></div>