<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Interviews_pekerjaan extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		
		$this->load->model("Post_pekerjaan_model");
		$this->load->model("Umb_model");
		$this->load->model("Penunjukan_model");
	}
	
	public function output($Return=array()){
		
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		
		exit(json_encode($Return));
	}
	
	public function index() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$system = $this->Umb_model->read_setting_info(1);
		if($system[0]->module_recruitment!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('left_interviews_pekerjaan').' | '.$this->Umb_model->site_title();
		$data['all_karyawans'] = $this->Umb_model->all_karyawans();
		$data['all_interview_pekerjaans'] = $this->Post_pekerjaan_model->all_interview_pekerjaans();
		$data['breadcrumbs'] = $this->lang->line('left_interviews_pekerjaan');
		$data['path_url'] = 'interviews_pekerjaan';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('52',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/post_pekerjaan/interviews_pekerjaan", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); 
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}	  
	}

	public function list_interview() {

		$data['title'] = $this->Umb_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/post_pekerjaan/interviews_pekerjaan", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$role_resources_ids = $this->Umb_model->user_role_resource();
		$interview = $this->Post_pekerjaan_model->all_interviews();
		
		$data = array();

		foreach($interview->result() as $r) {
			if(in_array('388',$role_resources_ids)) {
				$aim = explode(',',$r->interviewees_id);
				foreach($aim as $dIds) {
					if($session['user_id'] == $dIds) {

						$pekerjaan = $this->Post_pekerjaan_model->read_informasi_pekerjaan($r->pekerjaan_id);
						if(!is_null($pekerjaan)){
							$title_pekerjaan = $pekerjaan[0]->title_pekerjaan;
						} else {
							$title_pekerjaan = '--';	
						}

						$tanggal_interview = $this->Umb_model->set_date_format($r->tanggal_interview);			
						$waktu_interview = $r->tanggal_interview.' '.$r->waktu_interview;
						$interview_ex_waktu =  new DateTime($waktu_interview);
						$int_time = $interview_ex_waktu->format('h:i a');

						$interview_d_t = $tanggal_interview.' '.$int_time;
						$u_ditambahkan = $this->Umb_model->read_user_info($r->added_by);

						if(!is_null($u_ditambahkan)){
							$int_ditambahkan_oleh = $u_ditambahkan[0]->first_name. ' '.$u_ditambahkan[0]->last_name;
						} else {
							$int_ditambahkan_oleh = '--';	
						}

						$description = html_entity_decode($r->description);
						$data[] = array(
							'<a href="'.site_url().'frontend/pekerjaans/detail/'.$r->pekerjaan_id.'/" target="_blank" data-toggle="tooltip" data-placement="top" title="" data-original-title="View"><button type="button" class="btn icon-btn btn-sm btn-outline-info waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a>',
							$title_pekerjaan,
							$description,
							$r->tempat_interview,
							$interview_d_t,
							$int_ditambahkan_oleh
						);
					}
				}
			} else {
				$pekerjaan = $this->Post_pekerjaan_model->read_informasi_pekerjaan($r->pekerjaan_id);
				if(!is_null($pekerjaan)){
					$title_pekerjaan = $pekerjaan[0]->title_pekerjaan;
				} else {
					$title_pekerjaan = '--';	
				}

				$tanggal_interview = $this->Umb_model->set_date_format($r->tanggal_interview);		

				if($r->interviewees_id == '') {
					$interviewees = '-';
				} else {
					$interviewees = '<ol class="nl">';
					foreach(explode(',',$r->interviewees_id) as $interviewees_id) {
						$user_intwee = $this->Umb_model->read_user_info($interviewees_id);
						if(!is_null($user_intwee)){
							$interviewees .= '<li>'.$user_intwee[0]->first_name. ' '.$user_intwee[0]->last_name.'</li>';
						} else {
							$interviewees .= '';	
						}
					}
					$interviewees .= '</ol>';
				}

				if($r->interviewers_id == '') {
					$interviewers = '-';
				} else {
					$interviewers = '<ol class="nl">';
					foreach(explode(',',$r->interviewers_id) as $interviewers_id) {
						$user_intwer = $this->Umb_model->read_user_info($interviewers_id);
						if(!is_null($user_intwer)){
							$interviewers .= '<li>'.$user_intwer[0]->first_name. ' '.$user_intwer[0]->last_name.'</li>';
						} else {
							$interviewers .= '';	
						}
					}
					$interviewers .= '</ol>';
				}


				$waktu_interview = $r->tanggal_interview.' '.$r->waktu_interview;
				$interview_ex_waktu =  new DateTime($waktu_interview);
				$int_time = $interview_ex_waktu->format('h:i a');

				$interview_d_t = $tanggal_interview.' '.$int_time;
				$u_ditambahkan = $this->Umb_model->read_user_info($r->added_by);

				if(!is_null($u_ditambahkan)){
					$int_ditambahkan_oleh = $u_ditambahkan[0]->first_name. ' '.$u_ditambahkan[0]->last_name;
				} else {
					$int_ditambahkan_oleh = '--';	
				}		

				if(in_array('297',$role_resources_ids)) {
					$delete = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->pekerjaan_interview_id . '"><span class="fas fa-trash-restore"></span></button></span>';
				} else {
					$delete = '';
				}
				
				$data[] = array(
					$delete,
					$title_pekerjaan,
					$interviewees,
					$r->tempat_interview,
					$interview_d_t,
					$interviewers,
					$int_ditambahkan_oleh
				);
			}

		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $interview->num_rows(),
			"recordsFiltered" => $interview->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	
	public function add_interview() {

		if($this->input->post('add_type')=='interview') {		

			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			

			$description = $this->input->post('description');	
			$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);

			if($this->input->post('pekerjaan_id')==='') {
				$Return['error'] = $this->lang->line('umb_posts_interview_pekerjaan');
			} else if($this->input->post('tanggal_interview')==='') {
				$Return['error'] = $this->lang->line('umb_interview_pekerjaan_tanggal_interview');
			} else if($this->input->post('interviewees')==='') {
				$Return['error'] = $this->lang->line('umb_interview_kandidat_pekerjaan');
			} else if($this->input->post('tempat_interview')==='') {
				$Return['error'] = $this->lang->line('umb_interview_pekerjaan_tempat_interview');
			} else if($this->input->post('waktu_interview')==='') {
				$Return['error'] = $this->lang->line('umb_interview_pekerjaan_waktu_interview');
			} else if($this->input->post('interviewers')==='') {
				$Return['error'] = $this->lang->line('umb_interview_pekerjaan_interviewers');
			}

			if($Return['error']!=''){
				$this->output($Return);
			}

			if($this->input->post('interviewees')!=='') {
				$interviewees_ids = implode(',',$this->input->post('interviewees'));
			} else {
				$interviewees_ids = '';
			}

			if($this->input->post('interviewers')!=='') {
				$interviewers_ids = implode(',',$this->input->post('interviewers'));
			} else {
				$interviewers_ids = '';
			}

			$data = array(
				'pekerjaan_id' => $this->input->post('pekerjaan_id'),
				'tanggal_interview' => $this->input->post('tanggal_interview'),
				'interviewees_id' => $interviewees_ids,
				'description' => $qt_description,
				'tempat_interview' => $this->input->post('tempat_interview'),
				'waktu_interview' => $this->input->post('waktu_interview'),
				'interviewers_id' => $interviewers_ids,
				'added_by' => $this->input->post('user_id'),
				'created_at' => date('Y-m-d h:i:s')		
			);

			$result = $this->Post_pekerjaan_model->add_interview($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('umb_interview_pekerjaan_ditambahkan');
			} else {
				$Return['error'] = $this->lang->line('umb_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}	
	
	public function get_karyawans() {

		$data['title'] = $this->Umb_model->site_title();
		$id = $this->uri->segment(4);
		$data = array(
			'pekerjaan_id' => $id,
			'all_karyawans' => $this->Umb_model->all_karyawans(),
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/post_pekerjaan/get_pekerjaan_karyawans", $data);
		} else {
			redirect('admin/');
		}
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}
	
	public function delete() {
		
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		$result = $this->Post_pekerjaan_model->delete_record_interview($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('umb_interview_pekerjaan_dihapus');
		} else {
			$Return['error'] = $this->lang->line('umb_error_msg');
		}
		$this->output($Return);
	}
}
