<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chat extends MY_Controller {


	public function output($Return=array()){

		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");

		exit(json_encode($Return));
	}

	public function __construct() {

		parent::__construct();

		$this->load->model('Perusahaan_model');
		$this->load->model('Umb_model');
		$this->load->model('Chat_model');
		$this->load->model('Karyawans_model');
		$this->load->model('Location_model');
		$this->load->model('Department_model');
	}

	public function index() {

		$system = $this->Umb_model->read_setting_info(1);
		if($system[0]->module_chat_box!='true'){
			redirect('admin/dashboard');
		}

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('umb_hr_chat_box').' | '.$this->Umb_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('umb_hr_chat_box');
		$data['path_url'] = 'chatbox';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		$data['subview'] = $this->load->view("admin/chatbox/chatbox", $data, TRUE);
		$this->load->view('admin/layout/layout_main', $data); 
	}
	
	public function chat_read() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/chatbox/single_chat', $data);
		} else {
			redirect('admin/');
		}
	}

	public function read_department_chat() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/chatbox/department_chat', $data);
		} else {
			redirect('admin/');
		}
	}
	public function read_location_chat() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/chatbox/location_chat', $data);
		} else {
			redirect('admin/');
		}
	}

	public function refresh_chatbox(){
		
		$fid = $this->input->get('from_id');
		$tid = $this->input->get('to_id');
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		if($this->input->get('from_id')) {
			foreach($this->Chat_model->get_messages() as $msgs){
				if(($tid==$msgs->to_id && $msgs->from_id==$fid) || ($fid==$msgs->to_id && $msgs->from_id==$tid)) {
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
						$tofname = $user_info[0]->first_name.' '.$user_info[0]->last_name;
						$chat_terakhir = $this->Chat_model->last_user_message($msgs->from_id,$session['user_id']);
						$tanggal_chat_terakhir = $this->Chat_model->timeAgo($msgs->message_date);
						echo '<div class="chat-message-left mb-4">
						<div>
						<img src="'.$de_file.'" class="ui-w-40 rounded-circle" alt="">
						<div class="text-muted small text-nowrap mt-2">'.$tanggal_chat_terakhir.'</div>
						</div>
						<div class="flex-shrink-1 bg-lighter rounded py-2 px-3 mr-3">
						<div class="font-weight-semibold mb-1">'.$tofname.'</div>
						'.$msgs->message_content.'
						</div>
						</div>';
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
						$chat_terakhir = $this->Chat_model->last_user_message($session['user_id'],$tid);
						$tanggal_chat_terakhir = $this->Chat_model->timeAgo($msgs->message_date);
						echo '<div class="chat-message-right mb-4">
						<div>
						<img src="'.$fde_file.'" class="ui-w-40 rounded-circle" alt="">
						<div class="text-muted small text-nowrap mt-2">'.$tanggal_chat_terakhir.'</div>
						</div>
						<div class="flex-shrink-1 bg-lighter rounded py-2 px-3 ml-3">
						<div class="font-weight-semibold mb-1">You</div>
						'.$msgs->message_content.'
						</div>
						</div>';
					}
				}
			}
		}
	}
	
	public function refresh_chatbox_department(){
		
		$fid = $this->input->get('from_id');
		$department_id = $this->input->get('department_id');
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		if($this->input->get('from_id')) {
			
			foreach($this->Chat_model->get_department_messages($department_id) as $msgs){
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
					$tofname = $user_info[0]->first_name.' '.$user_info[0]->last_name;
					$chat_terakhir = $this->Chat_model->last_department_user_message($msgs->from_id);
					$tanggal_chat_terakhir = $this->Chat_model->timeAgo($msgs->message_date);
					echo '<div class="chat-message-left mb-4">
					<div>
					<img src="'.$de_file.'" class="ui-w-40 rounded-circle" alt="">
					<div class="text-muted small text-nowrap mt-2">'.$tanggal_chat_terakhir.'</div>
					</div>
					<div class="flex-shrink-1 bg-lighter rounded py-2 px-3 mr-3">
					<div class="font-weight-semibold mb-1">'.$tofname.'</div>
					'.$msgs->message_content.'
					</div>
					</div>';
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
					$chat_terakhir = $this->Chat_model->last_department_user_message($msgs->from_id);
					$tanggal_chat_terakhir = $this->Chat_model->timeAgo($msgs->message_date);
					echo '<div class="chat-message-right mb-4">
					<div>
					<img src="'.$fde_file.'" class="ui-w-40 rounded-circle" alt="">
					<div class="text-muted small text-nowrap mt-2">'.$tanggal_chat_terakhir.'</div>
					</div>
					<div class="flex-shrink-1 bg-lighter rounded py-2 px-3 ml-3">
					<div class="font-weight-semibold mb-1">You</div>
					'.$msgs->message_content.'
					</div>
					</div>';
				}
			}
		}
	}

	public function refresh_location_chatbox(){
		
		$fid = $this->input->get('from_id');
		$location_id = $this->input->get('location_id');
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		if($this->input->get('from_id')) {
			
			foreach($this->Chat_model->get_location_messages($location_id) as $msgs){
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
					$tofname = $user_info[0]->first_name.' '.$user_info[0]->last_name;
					$chat_terakhir = $this->Chat_model->location_user_message_terakhir($msgs->from_id);
					$tanggal_chat_terakhir = $this->Chat_model->timeAgo($msgs->message_date);
					echo '<div class="chat-message-left mb-4">
					<div>
					<img src="'.$de_file.'" class="ui-w-40 rounded-circle" alt="">
					<div class="text-muted small text-nowrap mt-2">'.$tanggal_chat_terakhir.'</div>
					</div>
					<div class="flex-shrink-1 bg-lighter rounded py-2 px-3 mr-3">
					<div class="font-weight-semibold mb-1">'.$tofname.'</div>
					'.$msgs->message_content.'
					</div>
					</div>';
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
					$tanggal_chat_terakhir = $this->Chat_model->timeAgo($msgs->message_date);
					echo '<div class="chat-message-right mb-4">
					<div>
					<img src="'.$fde_file.'" class="ui-w-40 rounded-circle" alt="">
					<div class="text-muted small text-nowrap mt-2">'.$tanggal_chat_terakhir.'</div>
					</div>
					<div class="flex-shrink-1 bg-lighter rounded py-2 px-3 ml-3">
					<div class="font-weight-semibold mb-1">You</div>
					'.$msgs->message_content.'
					</div>
					</div>';
				}
			}
		}
	}
	
	public function refresh_chat_users_msg() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$unread_msgs = $this->Umb_model->get_single_unread_message($session['user_id']);
		if($unread_msgs > 0) {
			echo $unread_msgs;
		} else {
			echo '';
		}
	}
	
	public function refresh_chat_users() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$fuser_info = $this->Umb_model->read_user_info($session['user_id']);
		$all_active_karyawans = $this->Umb_model->all_active_karyawans();
		foreach($all_active_karyawans as $active_karyawans):
			if ($active_karyawans->is_logged_in == 0):
				$bgm = 'offline';
				$bgmTxt = 'Offline';
			else:
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
				
			endif;
			if($active_karyawans->user_id!=$session['user_id']):
				
				echo '<button class="all-users list-group-item list-group-item-action media no-border '.$bgm.'" id="set_box_'.$active_karyawans->user_id.'" data-from-id="'.$session['user_id'].'" data-to-id="'.$active_karyawans->user_id.'" data-toggle="modal" data-target="#chatbox-single">';
				
				if($active_karyawans->profile_picture!='' && $active_karyawans->profile_picture!='no file') {
					echo '<img class="ui-w-40 rounded-circle" src="'.base_url()."uploads/profile/".$active_karyawans->profile_picture.'" alt=""> <i></i>';
				} else {
					if($active_karyawans->jenis_kelamin=='Pria') { 
						$de_file = base_url().'uploads/profile/default_male.jpg';
					} else {
						$de_file = base_url().'uploads/profile/default_female.jpg';
					} 
					echo '<img class="ui-w-40 rounded-circle" src="'.$de_file.'" alt=""> <i></i>';
				} 
				$fname = $active_karyawans->first_name.' '.$active_karyawans->last_name; 
				$unread_msgs = $this->Chat_model->get_unread_message($active_karyawans->user_id,$session['user_id']);
				$chat_terakhir = $this->Chat_model->last_user_message($active_karyawans->user_id,$session['user_id']);
				if(!is_null($chat_terakhir)){
					$tanggal_chat_terakhir = $this->Chat_model->timeAgo($chat_terakhir[0]->message_date);
					$message_content = $chat_terakhir[0]->message_content;
				} else {
					$tanggal_chat_terakhir = '--';
					$message_content = 'No Message.';
				}
				echo '</div><div class="media-body ml-3">'.$fname.'<div class="chat-status small">
				<span class="badge badge-dot"></span>&nbsp; '.$bgmTxt.'</div>
				</div>';
				if($unread_msgs > 0) {
					echo '<div class="badge badge-outline-success">'.$unread_msgs.'</div>';
				} else {
				} echo '';
				echo '
				
				</button>';
			endif;
		endforeach;
	}
	
	public function send_chat() {
		
		if($this->input->post('from_id') && $this->input->post('to_id')) {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			
			$this->form_validation->set_rules('message_content', 'Message', 'trim|required|xss_clean');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();	
			$message = $this->input->post('message_content');
			$qt_message = htmlspecialchars(addslashes($message), ENT_QUOTES);
			if($this->input->post('message_content')==='') {
				return false;
			}
			$data = array(
				'message_content' => $qt_message,
				'from_id' => $this->input->post('from_id'),
				'to_id' => $this->input->post('to_id'),
				'location_id' => 0,
				'department_id' => 0,
				'message_frm' => $this->input->post('message_frm'),
				'message_date' => date('Y-m-d H:i:s'),
			);
			$result = $this->Chat_model->add_chat($data);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();	
			$this->output($Return);
			exit;
		}
	}

	public function kirim_chat_department() {
		
		if($this->input->post('from_id') && $this->input->post('chat_group_department_id')) {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			
			$this->form_validation->set_rules('message_content', 'Message', 'trim|required|xss_clean');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();	
			$message = $this->input->post('message_content');
			$qt_message = htmlspecialchars(addslashes($message), ENT_QUOTES);
			if($this->input->post('message_content')==='') {
				return false;
			}
			$data = array(
				'message_content' => $qt_message,
				'from_id' => $this->input->post('from_id'),
				'to_id' => '0',
				'location_id' => '0',
				'department_id' => $this->input->post('chat_group_department_id'),
				'message_frm' => $this->input->post('message_frm'),
				'message_date' => date('Y-m-d H:i:s'),
			);
			$result = $this->Chat_model->add_chat($data);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();	
			$this->output($Return);
			exit;
		}
	}
	
	public function send_location_chat() {
		
		if($this->input->post('from_id') && $this->input->post('group_location_chat_id')) {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			
			$this->form_validation->set_rules('message_content', 'Message', 'trim|required|xss_clean');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();	
			$message = $this->input->post('message_content');
			$qt_message = htmlspecialchars(addslashes($message), ENT_QUOTES);
			if($this->input->post('message_content')==='') {
				return false;
			}
			
			$data = array(
				'message_content' => $qt_message,
				'from_id' => $this->input->post('from_id'),
				'to_id' => '0',
				'department_id' => '0',
				'location_id' => $this->input->post('group_location_chat_id'),
				'message_frm' => $this->input->post('message_frm'),
				'message_date' => date('Y-m-d H:i:s'),
			);
			$result = $this->Chat_model->add_chat($data);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();	
			$this->output($Return);
			exit;
		}
	}
	
	public function change_status() {
		
		if($this->input->get('status_id')) {		
			
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = $this->session->userdata('username');					
			$status_id = $this->input->get('status_id');
			$id = $session['user_id'];
			$data = array(
				'online_status' => $status_id,
			);
			$result = $this->Chat_model->update_online_status($data,$id);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_karyawan_basic_info_diperbarui');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
}
?>