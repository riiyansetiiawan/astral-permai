<?php $session = $this->session->userdata('username');?>
<?php $user = $this->Umb_model->read_user_info($session['user_id']);?>
<?php $result = $this->Timesheet_model->read_informasi_tugas($tugas_id);?>
<?php if($result[0]->assigned_to!='') { $assigned_to = explode(',',$result[0]->assigned_to);?>

<ul class="list-group list-group-flush">
  <?php foreach($assigned_to as $assign_id) {?>
    <?php $e_name = $this->Umb_model->read_user_info($assign_id);?>
    <?php if(!is_null($e_name)){ ?>
      <?php $_penunjukan = $this->Penunjukan_model->read_informasi_penunjukan($e_name[0]->penunjukan_id);?>
      <?php
      if(!is_null($_penunjukan)){
        $nama_penunjukan = $_penunjukan[0]->nama_penunjukan;
      } else {
        $nama_penunjukan = '--';	
      }
      ?>
      <?php
      if($e_name[0]->profile_picture!='' && $e_name[0]->profile_picture!='no file') {
        $u_file = base_url().'uploads/profile/'.$e_name[0]->profile_picture;
      } else {
        if($e_name[0]->jenis_kelamin=='Pria') { 
          $u_file = base_url().'uploads/profile/default_male.jpg';
        } else {
          $u_file = base_url().'uploads/profile/default_female.jpg';
        }
      } ?>
      <div class="il-item">
        <li class="list-group-item" style="border:0px;">
          <div class="media align-items-center"> <img src="<?php echo $u_file;?>" class="d-block ui-w-30 rounded-circle" alt="">
            <div class="media-body px-2">
              <?php if($user[0]->user_role_id==1):?>
                <a href="<?php echo site_url()?>admin/karyawans/detail/<?php echo $e_name[0]->user_id;?>" class="text-dark">
                <?php endif;?>
                <?php echo $e_name[0]->first_name.' '.$e_name[0]->last_name;?>
                <?php if($user[0]->user_role_id==1):?>
                </a>
              <?php endif;?>
              <br>
              <p class="font-small-2 mb-0 text-muted"><?php echo $nama_penunjukan;?></p>
            </div>
          </div>
        </li>
      </div>
    <?php } } ?>
  <?php } else { ?>
    <li class="list-group-item" style="border:0px;">&nbsp;</li>
  <?php } ?>
</ul>
<script type="text/javascript">
  $(document).ready(function(){	
   $('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
   $('[data-plugin="select_hrm"]').select2({ width:'100%' });
 });
</script>