<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Performance_maingoals extends MY_Controller {
	
	public function __construct() 
	{
        Parent::__construct();
        
        $this->load->model('Umb_model');
        $this->load->model('Performance_maingoals_model');
        $this->load->model('Department_model');
        $this->load->model('Karyawans_model');
    }
    
    
    
    public function output($Return=array()){
      
      header("Access-Control-Allow-Origin: *");
      header("Content-Type: application/json; charset=UTF-8");
      
      exit(json_encode($Return));
  }

  public function index()
  {
      $session = $this->session->userdata('username');
      if(empty($session)){ 
       redirect('admin/');
   }
   $system = $this->Umb_model->read_setting_info(1);
   if($system[0]->module_performance!='true'){
       redirect('admin/dashboard');
   }
   $data['title'] = $this->lang->line('left_performance_kpi');
   $data['breadcrumbs'] = $this->lang->line('left_performance_kpi');
   $data['path_url'] = 'performance_maingoals';
   $is_head_department = $this->Department_model->is_head_department($session['user_id']);
   $data['is_head_department'] = $is_head_department;
   $user = $this->Umb_model->read_user_info($session['user_id']);

        //admin and department head
   if ($is_head_department && $user[0]->user_role_id == 1) {
    $data['karyawans'] = $this->Umb_model->all_karyawans();
}

        //admin only
if ($user[0]->user_role_id == 1 && !$is_head_department) {
  $data['karyawans'] = $this->Umb_model->all_karyawans();
}

        // department head only
if ($is_head_department && $user[0]->user_role_id == 2) {
    $data['karyawans'] = $this->Karyawans_model->get_karyawan_by_department($is_head_department[0]->department_id);
}

$role_resources_ids = $this->Umb_model->user_role_resource();
if(in_array('119',$role_resources_ids)) {
   if(!empty($session)){ 
    $data['subview'] = $this->load->view("admin/performance/performance_appraisal_kpi", $data, TRUE);
    $this->load->view('admin/layout/layout_main', $data); 
} else {
    redirect('admin/');
}
} else {
   redirect('admin/dashboard');
}
}

public function add_maingoals_kpi ()
{
 if($this->input->post('add_type')=='kpi_maingoals') {
  $Return = array('result'=>'', 'error'=>'');
  if($this->input->post('kpi_main_tujuans')==='') {
      $Return['error'] = $this->lang->line('umb_error_kpi_maingoals_field');
  }

  if($Return['error']!=''){
      $this->output($Return);
  }

	    	//add to db goes here
  $data = array(
    'user_id' => $this->input->post('_user'),
    'main_kpi' => $this->input->post('kpi_main_tujuans'),
    'status' => 1,
    'year_created' => date('Y'),
    'created_at' => date('Y-m-d H:i:s'),
    'updated_at' => date('Y-m-d H:i:s')
);
  $result = $this->Performance_maingoals_model->add($data);

  if ($result == TRUE) {
   $Return['result'] = $this->lang->line('umb_sukses_kpi_maingoals_ditambahkan');
}

$this->output($Return);
exit;	
}
}

public function list_maingoals ()
{
  $data['title'] = $this->Umb_model->site_title();
  $session = $this->session->userdata('username');
		// if(!empty($session)){ 
		// 	$this->load->view("admin/performance_kpi", $data);
		// } else {
		// 	redirect('');
		// }
  
  $draw = intval($this->input->get("draw"));
  $start = intval($this->input->get("start"));
  $length = intval($this->input->get("length"));

  $user_id = $this->uri->segment(4);

  if (isset($user_id)) {
    $maingoals = $this->Performance_maingoals_model->get_kpi_maingoals($user_id);
} else {
    $maingoals = $this->Performance_maingoals_model->get_kpi_maingoals($session['user_id']);
}

$data = array();

foreach($maingoals->result() as $r) {
    $created_at = $this->Umb_model->set_date_time_format($r->created_at);
    $updated_at = $this->Umb_model->set_date_time_format($r->updated_at);

    if ($r->user_id != $session['user_id']) {
        $action = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-maingoals-data" data-maingoals_id="'. $r->id . '"><i class="fa fa-pencil-square-o"></i></button></span>';
    } else {
                //$action = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-maingoals-data" data-maingoals_id="'. $r->id . '"><i class="fa fa-pencil-square-o"></i></button></span>';
        $action = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-maingoals-data" data-maingoals_id="'. $r->id . '"><i class="fa fa-pencil-square-o"></i></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn btn-danger btn-sm m-b-0-0 waves-effect waves-light delete-maingoals" data-toggle="modal" data-target=".delete-modal-maingoals" data-record-id="'. $r->id . '"><i class="fa fa-trash-o"></i></button></span>';
    }
    
    if ($session['user_id'] == $r->user_id) {
        $kpi_status = ucfirst($r->approve_status);
    }

    if ($r->approve_status == 'pending' && $session['user_id'] != $r->user_id) {
        $kpi_status = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('kpi_approve').'"><button type="button" class="btn btn-success btn-sm m-b-0-0 waves-effect waves-light approve-maingoals" data-toggle="modal" data-target=".approve-modal-maingoals-kpi" data-kpi_id="'. $r->id . '" data-record-id="'. $r->id . '"><i class="fa fa-check"></i></button></span>';
    } else {
        $kpi_status = ucfirst($r->approve_status);
    }

    $data[] = array(
        $action,
        $r->main_kpi,
        $r->q1,
        $r->q2,
        $r->q3,
        $r->q4,
        $r->status,
        $r->feedback,
        $created_at,
        $updated_at,
    );
}

$output = array(
 "draw" => $draw,
 "recordsTotal" => $maingoals->num_rows(),
 "recordsFiltered" => $maingoals->num_rows(),
 "data" => $data
);
echo json_encode($output);
exit();
}

public function delete_maingoals() {
    if($this->input->post('type')=='delete') {
            // Define return | here result is used to return user data and error for error message 
        $Return = array('result'=>'', 'error'=>'');
        $id = $this->uri->segment(4);
        $result = $this->Performance_maingoals_model->delete_record_maingoals($id);
        if(isset($id)) {
            $Return['result'] = $this->lang->line('kpi_maingoals_dihapus_successful');
        } else {
            $Return['error'] = $this->lang->line('umb_error_msg');
        }
        $this->output($Return);
    }
}

    // get record of maingoals
public function read_record_maingoals()
{
    $data['title'] = $this->Umb_model->site_title();
    $maingoals_id = $this->input->get('maingoals_id');
    $result = $this->Performance_maingoals_model->read_informasi_maingoals($maingoals_id);
    
    $data = array(
        'maingoals_id' => $result[0]->id,
        'user_id' => $result[0]->user_id,
        'main_kpi' => $result[0]->main_kpi,
        'q1' => $result[0]->q1,
        'q2' => $result[0]->q2,
        'q3' => $result[0]->q3,
        'q4' => $result[0]->q4,
        'status' => $result[0]->status,
        'feedback' => $result[0]->feedback,
        'approve_status' => $result[0]->approve_status,
    );
    $session = $this->session->userdata('username');
    if(!empty($session)){ 
        $this->load->view('admin/performance/dialog_maingoals', $data);
    } else {
        redirect('admin/');
    }
}


public function edit_maingoals() {
    
    if($this->input->post('edit_type')=='maingoals') {
        
        $id = $this->uri->segment(4);   
        $Return = array('result'=>'', 'error'=>''); 
        
        
        if($this->input->post('main_kpi')==='') {
            $Return['error'] = $this->lang->line('umb_error_kpi_maingoals_field');
        }
        
        if($Return['error']!=''){
            $this->output($Return);
        }
        
        $data = array(
            'main_kpi' => $this->input->post('main_kpi'),
            'q1' => $this->input->post('q1'),
            'q2' => $this->input->post('q2'),
            'q3' => $this->input->post('q3'),
            'q4' => $this->input->post('q4'),
            'status' => $this->input->post('status'),
            'feedback' => $this->input->post('feedback'),
            'updated_at' => date('Y-m-d H:i:s')
        );

        $result = $this->Performance_maingoals_model->update_record_maingoals($data,$id);
        
        if ($result == TRUE) {
            $Return['result'] = $this->lang->line('umb_sukses_kpi_maingoals_diperbarui');
        } else {
            $Return['error'] = $this->lang->line('umb_error_msg');
        }
        $this->output($Return);
        exit;
    }
}

public function approve_maingoals() {
    if($this->input->post('type')=='approve') {
            // Define return | here result is used to return user data and error for error message 
        $Return = array('result'=>'', 'error'=>'');
        $id = $this->uri->segment(4);
        $result = $this->Performance_maingoals_model->approve_maingoals($id);
        if(isset($id)) {
            $Return['result'] = $this->lang->line('kpi_approve_maingoals_success');
        } else {
            $Return['error'] = $this->lang->line('umb_error_msg');
        }
        $this->output($Return);
    }
}

public function maingoals_by_year ()
{
    $data['title'] = $this->Umb_model->site_title();
    $session = $this->session->userdata('username');
        // if(!empty($session)){ 
        //  $this->load->view("admin/performance_kpi", $data);
        // } else {
        //  redirect('');
        // }
    
    $draw = intval($this->input->get("draw"));
    $start = intval($this->input->get("start"));
    $length = intval($this->input->get("length"));

    $year = $this->uri->segment(4);
    $user_id = $this->uri->segment(5);

    $maingoals = $this->Performance_maingoals_model->get_kpi_maingoals_by_year($year, $user_id);
    
    $data = array();

    foreach($maingoals->result() as $r) {
        $created_at = $this->Umb_model->set_date_time_format($r->created_at);
        $updated_at = $this->Umb_model->set_date_time_format($r->updated_at);
        if ($r->user_id != $session['user_id']) {
            $action = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-maingoals-data" data-maingoals_id="'. $r->id . '"><i class="fa fa-pencil-square-o"></i></button></span>';
        } else {
            $action = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-maingoals-data" data-maingoals_id="'. $r->id . '"><i class="fa fa-pencil-square-o"></i></button></span>';
                //$action = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_edit').'"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-maingoals-data" data-maingoals_id="'. $r->id . '"><i class="fa fa-pencil-square-o"></i></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('umb_delete').'"><button type="button" class="btn btn-danger btn-sm m-b-0-0 waves-effect waves-light delete-maingoals" data-toggle="modal" data-target=".delete-modal-maingoals" data-record-id="'. $r->id . '"><i class="fa fa-trash-o"></i></button></span>';
        }
        
        if ($session['user_id'] == $r->user_id) {
            $kpi_status = ucfirst($r->approve_status);
        }

        if ($r->approve_status == 'pending' && $session['user_id'] != $r->user_id) {
            $kpi_status = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('kpi_approve').'"><button type="button" class="btn btn-success btn-sm m-b-0-0 waves-effect waves-light approve-maingoals" data-toggle="modal" data-target=".approve-modal-maingoals-kpi" data-kpi_id="'. $r->id . '" data-record-id="'. $r->id . '"><i class="fa fa-check"></i></button></span>';
        } else {
            $kpi_status = ucfirst($r->approve_status);
        }

        $data[] = array(
            $action,
            $r->main_kpi,
            $r->q1,
            $r->q2,
            $r->q3,
            $r->q4,
            $r->status,
            $r->feedback,
            $created_at,
            $updated_at,
        );
    }

    $output = array(
       "draw" => $draw,
       "recordsTotal" => $maingoals->num_rows(),
       "recordsFiltered" => $maingoals->num_rows(),
       "data" => $data
   );
    echo json_encode($output);
    exit();
}
}
