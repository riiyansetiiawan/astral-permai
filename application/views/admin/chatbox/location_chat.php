<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$session = $this->session->userdata('username');
if(empty($session)){ 
	redirect('admin/');
}
if(isset($_GET['jd']) && isset($_GET['from_id']) && isset($_GET['group_location_chat_id']) && $_GET['data']=='chat'){
	$fid = $this->input->get('from_id');
	$group_location_chat_id = $this->input->get('group_location_chat_id');
	$user = $this->Umb_model->read_user_info($session['user_id']);
	$location = $this->Location_model->read_informasi_location($group_location_chat_id);
	if(!is_null($location)){
		$nama_location = $location[0]->nama_location;
	} else {
		$nama_location = '--';
	}
	?> 
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
		<h6 class="modal-title" id="myModalLabel8">Chat With <?php echo $this->lang->line('left_location');?> (<?php echo $nama_location;?>)</h6>
	</div>
	<div class="modal-body" >
		<div class="content-body">
			<section class="chat-app-window">
				<div class="chats chat-app-window1" id="mlocation_chatbox" style="overflow:auto; height:450px;">
					<?php
					foreach($this->Chat_model->get_location_messages($user[0]->location_id) as $msgs){
						if($session['user_id']!=$msgs->from_id){
							$user_info = $this->Umb_model->read_user_info($msgs->from_id);
							if($user_info[0]->profile_picture!='' && $user_info[0]->profile_picture!='no file') {
								$de_file = base_url().'uploads/profile/'.$user_info[0]->profile_picture;
							} else {
								if($user_info[0]->jenis_kelamin=='Pria') { 
									$de_file = base_url().'uploads/profile/default_male.jpg';
								} else { 
									$de_file = base_url().'uploads/profile/default_female.jpg';
								} 
							}
							$data = array(
								'is_read' => 1,
							);
							$result = $this->Chat_model->update_status_chat($data,$msgs->from_id,$session['user_id'] );
							$chat_terakhir = $this->Chat_model->location_user_message_terakhir($msgs->from_id);
							$tanggal_chat_terakhir = $this->Chat_model->timeAgo($chat_terakhir[0]->message_date);
							$f_name = $user_info[0]->first_name.' '.$user_info[0]->last_name;
							?>
							<div class="chat-message-left mb-4">
								<div>
									<img src="<?php echo $de_file;?>" class="ui-w-40 rounded-circle" alt="">
									<div class="text-muted small text-nowrap mt-2"><?php echo $tanggal_chat_terakhir;?></div>
								</div>
								<div class="flex-shrink-1 bg-lighter rounded py-2 px-3 mr-3">
									<div class="font-weight-semibold mb-1"><?php echo $f_name;?></div>
									<?php echo $msgs->message_content;?>
								</div>
							</div>
							<?php
						} else {
							$fuser_info = $this->Umb_model->read_user_info($msgs->from_id);
							if($fuser_info[0]->profile_picture!='' && $fuser_info[0]->profile_picture!='no file') {
								$fde_file = base_url().'uploads/profile/'.$fuser_info[0]->profile_picture;
							} else {
								if($fuser_info[0]->jenis_kelamin=='Pria') { 
									$fde_file = base_url().'uploads/profile/default_male.jpg';
								} else { 
									$fde_file = base_url().'uploads/profile/default_female.jpg';
								} 
							}
							$chat_terakhir = $this->Chat_model->location_user_message_terakhir($msgs->from_id);
							$tanggal_chat_terakhir = $this->Chat_model->timeAgo($chat_terakhir[0]->message_date);
							?>
							<div class="chat-message-right mb-4">
								<div>
									<img src="<?php echo $fde_file;?>" class="ui-w-40 rounded-circle" alt="">
									<div class="text-muted small text-nowrap mt-2"><?php echo $tanggal_chat_terakhir;?></div>
								</div>
								<div class="flex-shrink-1 bg-lighter rounded py-2 px-3 ml-3">
									<div class="font-weight-semibold mb-1">You</div>
									<?php echo $msgs->message_content;?>
								</div>
							</div>
							<?php
						}
					}
					?>
				</div>
			</section>
			<section class="chat-app-form">
				<div class="box-footer">
					<?php $attributes = array('name' => 'send_chat', 'id' => 'umb-location-form', 'autocomplete' => 'off', 'class'=>'chat-app-input');?>
					<?php $hidden = array('_method' => 'EDIT', '_token' => $group_location_chat_id, 'ext_name' => $fid);?>
					<?php echo form_open('admin/chat/send_location_chat/', $attributes, $hidden);?>
					
					<?php
					$data1 = array(
						'type'        => 'hidden',
						'name'        => 'group_location_chat_id',
						'id'          => 'mtid',
						'value'       => $group_location_chat_id,
						'class'       => 'form-control',
					);
					
					echo form_input($data1);
					?>
					<?php
					$data2 = array(
						'type'        => 'hidden',
						'name'        => 'from_id',
						'id'          => 'mfid',
						'value'       => $fid,
						'class'       => 'form-control',
					);
					
					echo form_input($data2);
					?>
					<?php
					$data3 = array(
						'type'        => 'hidden',
						'name'        => 'message_frm',
						'id'          => 'mfid',
						'value'       => $group_location_chat_id,
						'class'       => 'form-control',
					);
					echo form_input($data3);
					?>
					<div class="input-group">
						<input type="text" name="message_content" class="form-control" id="content_location_message" placeholder="Type your message">
						<div class="input-group-addon" style="padding: 0;">
							<div class="align-self-end gap-items">
								<span class="publisher-btn file-group">
									<button type="submit" class="btn btn-primary">
										<i class="fa fa-paper-plane-o hidden-lg-up"></i> 
										<span class="hidden-md-down">Send</span>
									</button>
								</span>
							</div>
						</div>
					</div>
					<?php echo form_close(); ?>
				</div>
				<audio id="chatAudioSent">
					<source src="
					<?php echo base_url().'uploads/chat_sound/button_tiny.ogg';?>" type="audio/ogg"><source src="
					<?php echo base_url().'uploads/chat_sound/button_tiny.mp3';?>" type="audio/mpeg"><source src="
					<?php echo base_url().'uploads/chat_sound/button_tiny.wav';?>" type="audio/wav">
				</audio>
			</section>
		</div>
	</div>
	<script type="text/javascript">
		var first_run = 0;
		function mrefreshMessages() {
			var rfromId = $('#mfid').val();
			var rtoId = $('#mtid').val();
			$('.chat-application').removeClass('pace-done');
			$('.chat-application').removeClass('pace-running');
			$('.pace').removeClass('pace-inactive');
			if(rfromId!='' && rtoId!='') {
				$.ajax({
					url: "<?php echo site_url('admin/chat/refresh_location_chatbox');?>?from_id=<?php echo $fid;?>&location_id=<?php echo $group_location_chat_id;?>",
					type: 'GET',
					dataType: 'html',
					success: function(data) {
						$('.chat-application').removeClass('pace-done');
						$('.chat-application').removeClass('pace-running');
						$('.pace').removeClass('pace-inactive');

						prev_chat = $("#mlocation_chatbox").html();
							// $('input[name="csrf_hrastral"]').val(data.csrf_hash);	  
							jQuery('#mlocation_chatbox').html(data);
							curr_chat = $("#mlocation_chatbox").html();
							setTimeout(mrefreshMessages, 3000);
							$('.chat-application').removeClass('pace-done');
							$('.chat-application').removeClass('pace-running');
							$('.pace').removeClass('pace-inactive');
							if(curr_chat != prev_chat) {
								prev_chat = curr_chat;
								if(first_run===0) {
									first_run = 1;
								} else {
									if(prev_chat!='<div class="chats" id="mlocation_chatbox"></div>' ) {
										$('#chatAudio')[0].play();
										jQuery(".chat-app-window1").animate({ scrollTop: $(".chat-app-window1").prop("scrollHeight")}, 0);
									}
								}
							}

						},
						error: function() {
						}
					});
			}
		}
		$(document).ready(function(){
			setTimeout(mrefreshMessages, 5000);
		});
		$(document).ready(function(){
			$("#umb-location-form").submit(function(e){
				var fd = new FormData(this);
				var text = $("#content_location_message").val();
				if(text.length == 0){
					return false;
				}			
				var obj = $(this), action = obj.attr("name");
				fd.append("is_ajax", 2);
				fd.append("form", action);
				e.preventDefault();
				$(".save").prop("disabled", true);
				$.ajax({
					url: e.target.action,
					type: "POST",
					data:  fd,
					contentType: false,
					cache: false,
					processData:false,
					success: function(JSON) {
						$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
						var siteUrl = "<?php echo site_url('admin/chat/refresh_location_chatbox');?>?from_id=<?php echo $fid;?>&location_id=<?php echo $group_location_chat_id;?>";
						$.get(siteUrl, function(data, status){
							jQuery("#mlocation_chatbox").html(data);

							$("#content_location_message").val("");
							$("#content_location_message").focus();
							$("#chatAudioSent")[0].play();
							jQuery(".chat-app-window1").animate({ scrollTop: $(".chat-app-window1").prop("scrollHeight")}, 0);
						});
					},
					error: function() {
						$(".save").prop("disabled", false);
						$('input[name="csrf_hrastral"]').val(data.csrf_hash);
					} 	        
				});
			});
		});	
	</script>
<?php }
?>
<style type="text/css">
	.right .direct-chat-text {
		margin-left: 120px !important;
	}
	.left-text {
		margin-right: 120px !important;
	}
	.time-left {
		margin-left: 120px !important;
	}
	.time-right {
		margin-right: 120px !important;
	}
	.chat-application .chat-app-form {
		position: relative;
		padding: 20px 10px;
		background-color: #edeef0;
		overflow: hidden;
	}
	.chat-application .content-body {
		height: 100%;
	}
</style>
