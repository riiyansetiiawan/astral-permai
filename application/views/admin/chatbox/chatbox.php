<?php $session = $this->session->userdata('username');?>
<?php $fuser_info = $this->Umb_model->read_user_info($session['user_id']); ?>
<?php $location = $this->Location_model->read_informasi_location($fuser_info[0]->location_id);
if(!is_null($location)){
	$nama_location = $location[0]->nama_location;
} else {
	$nama_location = '--';
}
$department = $this->Department_model->read_informasi_department($fuser_info[0]->department_id);
if(!is_null($department)){
	$_nama_department = $department[0]->nama_department;
} else {
	$_nama_department = '';
}

if($fuser_info[0]->online_status==1):
	$stgm = 'avatar-online';
	$status_title = $this->lang->line('umb_iamavailable_title');
elseif($fuser_info[0]->online_status==3):
	$stgm = 'avatar-busy';
	$status_title = $this->lang->line('umb_iambusy_title');
else:
	$stgm = 'avatar-away';
	$status_title = $this->lang->line('umb_iamaway_title');
endif;
$all_active_karyawans = $this->Umb_model->all_active_karyawans();
?>
<?php $perusahaan = $this->Umb_model->read_info_setting_perusahaan(1);?>
<?php $system = $this->Umb_model->read_setting_info(1);?>

<div class="chat-wrapper container-p-x container-p-y">
  <div class="card flex-grow-1 position-relative overflow-hidden">
    <div class="row no-gutters h-100">
      <div class="chat-sidebox col">
        <div class="flex-grow-0 px-4">
          <div class="media align-items-center">
            <div class="media-body my-3">
              <?php $f_name = $fuser_info[0]->first_name.' '.$fuser_info[0]->last_name;?>
              <div class="media align-items-center">
                <?php  if($fuser_info[0]->profile_picture!='' && $fuser_info[0]->profile_picture!='no file') {?>
                  <img src="<?php  echo base_url().'uploads/profile/'.$fuser_info[0]->profile_picture;?>" class="d-block ui-w-40 rounded-circle" alt="">
                <?php } else {?>
                  <?php  if($fuser_info[0]->jenis_kelamin=='Pria') { ?>
                    <?php 	$de_file = base_url().'uploads/profile/default_male.jpg';?>
                  <?php } else { ?>
                    <?php 	$de_file = base_url().'uploads/profile/default_female.jpg';?>
                  <?php } ?>
                  <img src="<?php  echo $de_file;?>" class="d-block ui-w-40 rounded-circle" alt="">
                <?php  } ?>
                <div class="media-body flex-basis-auto pl-3">
                  <div><div class="btn-group show">
                    <a class="user-status dropdown-toggle" data-toggle="dropdown" aria-expanded="true"><?php echo $f_name;?></a>
                    <div class="dropdown-menu" x-placement="top-start" style="position: absolute; will-change: top, left; top: -177px; left: 0px;">
                      <a class="dropdown-item online-status" href="#" data-status-id="1" data-status-title="<?php echo $this->lang->line('umb_iamavailable_title');?>" data-avatar-status="avatar-online"><?php echo $this->lang->line('umb_available_title');?></a>
                      <a class="dropdown-item online-status" href="#" data-status-id="2" data-status-title="<?php echo $this->lang->line('umb_iamaway_title');?>" data-avatar-status="avatar-away"><?php echo $this->lang->line('umb_away_title');?></a>
                      <a class="dropdown-item online-status" href="#" data-status-id="3" data-status-title="<?php echo $this->lang->line('umb_iambusy_title');?>" data-avatar-status="avatar-busy"><?php echo $this->lang->line('umb_busy_title');?></a>
                    </div>
                  </div>
                </div>
                <div class="text-muted small" id="hr_status"><?php echo $status_title;?></div>
              </div>
            </div>
          </div>
          <a href="javascript:void(0)" class="chat-sidebox-toggler d-lg-none d-block text-muted text-large font-weight-light pl-3">&times;</a>
        </div>
        <hr class="border-light m-0">
      </div>
      <h6 class="card-header"><?php echo $this->lang->line('umb_chatgroup_title');?></h6>
      <button href="#" class="list-group-item list-group-item-action media no-border" id="set_department-groupbox_<?php echo $fuser_info[0]->department_id;?>" data-from-id="<?php echo $session['user_id'];?>" data-chat_group_department_id="<?php echo $fuser_info[0]->department_id;?>" data-toggle="modal" data-target="#chatbox-group-department">
       <?php echo $this->lang->line('left_department');?> (<?php echo $_nama_department;?>)
     </button>
     <button href="#" class="list-group-item list-group-item-action media no-border" id="set_location-groupbox_<?php echo $fuser_info[0]->location_id;?>" data-from-id="<?php echo $session['user_id'];?>" data-group_location_chat_id="<?php echo $fuser_info[0]->location_id;?>" data-toggle="modal" data-target="#chatbox-location-group">
      <?php echo $this->lang->line('left_location');?> (<?php echo $nama_location;?>)
    </button>
    <h6 class="card-header"><?php echo $this->lang->line('umb_privatechat_title');?></h6>
    <div class="flex-grow-1 position-relative">
      <div class="chat-kontaks list-group chat-scroll py-3 ps ps--active-y" id="chat_users">
        <?php foreach($all_active_karyawans as $active_karyawans):?>
          <?php if ($active_karyawans->is_logged_in == 0):?>
            <?php $bgm = 'offline';?>
            <?php $bgmTxt = 'Offline';?>
          <?php else:
            if($active_karyawans->online_status==1):
              $bgm = 'online';
              $bgmTxt = 'Online';
            elseif($active_karyawans->online_status==3):
              $bgm = 'offline';
              $bgmTxt = 'Offline';
            else:
              $bgm = 'offline';
              $bgmTxt = 'Offline';
            endif;	
            ?>
          <?php endif;?>
          <button class="all-users list-group-item list-group-item-action media no-border <?php echo $bgm;?>" id="set_box_<?php echo $active_karyawans->user_id;?>" data-from-id="<?php echo $session['user_id'];?>" data-to-id="<?php echo $active_karyawans->user_id;?>" data-toggle="modal" data-target="#chatbox-single">
            <!--<a href="javascript:void(0)" class="list-group-item list-group-item-action online">-->
              <?php  if($active_karyawans->profile_picture!='' && $active_karyawans->profile_picture!='no file') {?>
                <img src="<?php echo base_url().'uploads/profile/'.$active_karyawans->profile_picture;?>" class="d-block ui-w-40 rounded-circle" alt="">
              <?php } else {?>
                <?php  if($active_karyawans->jenis_kelamin=='Pria') { ?>
                  <?php 	$de_file = base_url().'uploads/profile/default_male.jpg';?>
                <?php } else { ?>
                  <?php 	$de_file = base_url().'uploads/profile/default_female.jpg';?>
                <?php } ?>
                <img src="<?php echo $de_file;?>" class="d-block ui-w-40 rounded-circle" alt="">
              <?php  } ?>
              <?php $fname = $active_karyawans->first_name.' '.$active_karyawans->last_name;?>
              <?php $unread_msgs = $this->Chat_model->get_unread_message($active_karyawans->user_id,$session['user_id']);?>  
              <?php $chat_terakhir = $this->Chat_model->last_user_message($active_karyawans->user_id,$session['user_id']);?>
              <?php 
              if(!is_null($chat_terakhir)){
                $tanggal_chat_terakhir = $this->Chat_model->timeAgo($chat_terakhir[0]->message_date);
                $message_content = $chat_terakhir[0]->message_content;
              } else {
                $tanggal_chat_terakhir = '--';
                $message_content = 'No Message.';
              }
              ?>
              <div class="media-body ml-3">
                <?php echo $fname;?>
                <div class="chat-status small">
                  <span class="badge badge-dot"></span>&nbsp; <?php echo $bgmTxt;?>
                </div>
              </div>
              <?php
              if($unread_msgs > 0) { ?>
                <div class="badge badge-outline-success">
                  <?php echo $unread_msgs;?>
                </div>
              <?php } else {
              }
              ?>
            </button>
          <?php endforeach;?>
        </div>
      </div>
    </div>
    <div class="d-flex col flex-column">
      <div class="flex-grow-0 py-3 pr-4 pl-lg-4">
        <div class="media align-items-center">
          <a href="javascript:void(0)" class="chat-sidebox-toggler d-lg-none d-block text-muted text-large px-4 mr-2">
            <i class="ion ion-md-more"></i>
          </a>
          <div class="media-body pl-3">
            <img src="<?php echo base_url();?>uploads/logo/signin/<?php echo $perusahaan[0]->sign_in_logo;?>" class="ui-w-120" />
          </div>
        </div>

      </div>
      <hr class="flex-grow-0 border-light m-0">
      <div class="flex-grow-1 position-relative">
        <div class="chat-messages chat-scroll p-4">
          <div class="chat-message-left mb-4">
            <div class="flex-shrink-1 rounded py-2 px-3 ml-1">
              <div class="font-weight-semibold mb-1">Selamat Datang <?php echo $perusahaan[0]->nama_perusahaan;?> Aplikasi Chat</div>
              <p><?php echo $perusahaan[0]->nama_perusahaan;?> Aplikasi Obrolan cukup bagus dan mudah digunakan untuk komunikasi internal, saat ini hanya mengirimkan pesan pribadi.</p>
              <p>Untuk memulai, pilih pengguna dari tab kiri.</p>
              <p>Ngobrol segera setelah Anda memulai hari kerja. Anda dapat menggunakan pesan pribadi untuk komunikasi langsung satu lawan satu</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<div class="modal modal-slide fade" id="chatbox-single" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" id="chat_modal"></div>
  </div>
</div>
<div class="modal modal-slide fade" id="chatbox-group-department" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" id="chatgroup_department_modal"></div>
  </div>
</div>
<div class="modal modal-slide fade" id="chatbox-location-group" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" id="chatgroup_location_modal"></div>
  </div>
</div>
<style type="text/css">
  .user-status, .all-users { cursor:pointer; }
</style>