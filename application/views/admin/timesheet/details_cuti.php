<?php $session = $this->session->userdata('username');?>
<?php $user = $this->Umb_model->read_user_info($session['user_id']);?>
<?php
$datetime1 = new DateTime($from_date);
$datetime2 = new DateTime($to_date);
$interval = $datetime1->diff($datetime2);

if(strtotime($from_date) == strtotime($to_date)){
	$no_of_days =1;
} else {
	$no_of_days = $interval->format('%a') +1;
}
$cuti_user = $this->Umb_model->read_user_info($karyawan_id);

//department head
$department = $this->Department_model->read_informasi_department($user[0]->department_id);
?>
<?php $role_resources_ids = $this->Umb_model->user_role_resource(); ?>
<div class="row m-b-1">
  <div class="col-md-4">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_cuti_detail');?></strong></span> </div>
          <div class="card-body">
            <div class="table-responsive" data-pattern="priority-columns">
              <table class="table table-striped m-md-b-0">
                <tbody>
                  <tr>
                    <th scope="row" style="border-top:0px;"><?php echo $this->lang->line('umb_karyawan');?></th>
                    <td class="text-right"><?php echo $full_name;?></td>
                  </tr>
                  <tr>
                    <th scope="row" style="border-top:0px;"><?php echo $this->lang->line('left_department');?></th>
                    <td class="text-right"><?php echo $nama_department;?></td>
                  </tr>
                  <tr>
                    <th scope="row"><?php echo $this->lang->line('umb_type_cuti');?></th>
                    <td class="text-right"><?php echo $type;?></td>
                  </tr>
                  <tr>
                    <th scope="row"><?php echo $this->lang->line('umb_applied_on');?></th>
                    <td class="text-right"><?php echo $this->Umb_model->set_date_format($created_at);?></td>
                  </tr>
                  <tr>
                    <th scope="row"><?php echo $this->lang->line('umb_start_date');?></th>
                    <td class="text-right"><?php echo $this->Umb_model->set_date_format($from_date);?></td>
                  </tr>
                  <tr>
                    <th scope="row"><?php echo $this->lang->line('umb_end_date');?></th>
                    <td class="text-right"><?php echo $this->Umb_model->set_date_format($to_date);?></td>
                  </tr>
                  <tr>
                    <th scope="row"><?php echo $this->lang->line('umb_attachment');?></th>
                    <td class="text-right">
                      <?php if($attachment_cuti!='' && $attachment_cuti!='NULL'):?>
                        <a href="<?php echo site_url()?>admin/download?type=cuti&filename=<?php echo $attachment_cuti;?>"><?php echo $this->lang->line('umb_download');?></a>
                      <?php else:?>
                        
                        <?php endif;?></td>
                      </tr>
                      <tr>
                        <th scope="row"><?php echo $this->lang->line('umb_hrastral_total_hari');?></th>
                        <td class="text-right">
                          <?php 
                          if($is_half_day == 1){
                           $cuti_day_info = $this->lang->line('umb_hr_cuti_setenga_hari');
                         } else {
                           $cuti_day_info = $no_of_days;
                         }
                         echo $cuti_day_info;?>
                       </td>
                     </tr>
                   </tbody>
                 </table>
                 <div class="bs-callout-success callout-border-left callout-square callout-transparent mt-1 p-1"> <?php echo $reason;?> </div>
               </div>
             </div>
           </div>
         </div>
       </div>
     </div>
     <?php 
  // reports to 
     $laporans_to = get_data_laporans_team($session['user_id']);
     if(($user[0]->user_role_id == 1 || $laporans_to > 0) && ($ekaryawan_id!=$session['user_id'])) {?>
      <div class="col-md-4">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_update_status');?></strong></span> </div>
              <div class="card-body">
                <?php $attributes = array('name' => 'update_status', 'id' => 'update_status', 'autocomplete' => 'off');?>
                <?php $hidden = array('user_id' => $session['user_id'], '_token_status' => $cuti_id);?>
                <?php echo form_open('admin/timesheet/update_status_cuti/'.$cuti_id, $attributes, $hidden);?>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="status"><?php echo $this->lang->line('dashboard_umb_status');?></label>
                      <select class="form-control" name="status" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('dashboard_umb_status');?>">
                        <option value="1" <?php if($status=='1'):?> selected <?php endif; ?>><?php echo $this->lang->line('umb_pending');?></option>
                        <option value="2" <?php if($status=='2'):?> selected <?php endif; ?>><?php echo $this->lang->line('umb_approved');?></option>
                        <option value="3" <?php if($status=='3'):?> selected <?php endif; ?>><?php echo $this->lang->line('umb_rejected');?></option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="remarks"><?php echo $this->lang->line('umb_keterangan');?></label>
                      <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('umb_keterangan');?>" name="remarks" id="remarks"><?php echo $remarks;?></textarea>
                    </div>
                  </div>
                </div>
                <div class="form-actions box-footer">
                  <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('umb_save');?> </button>
                </div>
                <?php echo form_close(); ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php } ?>
    <div class="col-md-4">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_last_taken_cuti_title');?></strong></span> </div>
            <div class="card-body">
              <div class="box-block card-dashboard">
                <div class="table-responsive" data-pattern="priority-columns">
                  <table class="table table-striped m-md-b-0">
                    <tbody>
                      <?php $show_last_cuti = $this->Timesheet_model->show_karyawan_cuti_terakhir($karyawan_id,$cuti_id); ?>
                      <?php foreach($show_last_cuti as $last_cuti) {?>   
                        <?php
                            // get leave types
                        $type = $this->Timesheet_model->read_informasi_type_cuti($last_cuti->type_cuti_id);
                        if(!is_null($type)){
                          $type_name = $type[0]->type_name;
                        } else {
                          $type_name = '--';	
                        }
                        $datetime1 = new DateTime($last_cuti->from_date);
                        $datetime2 = new DateTime($last_cuti->to_date);
                        $interval = $datetime1->diff($datetime2);
                        
                        if(strtotime($last_cuti->from_date) == strtotime($last_cuti->to_date)){
                          $last_cuti_no_of_days =1;
                        } else {
                          $last_cuti_no_of_days = $interval->format('%a') +1;
                        }
                        if($last_cuti->is_half_day == 1){
                          $last_cuti_day_info = $this->lang->line('umb_hr_cuti_setenga_hari');
                        } else {
                          $last_cuti_day_info = $last_cuti_no_of_days;
                        }
                        ?>            
                        <tr>
                          <th scope="row"><?php echo $this->lang->line('umb_type_cuti');?></th>
                          <td class="text-right"><?php echo $type_name;?></td>
                        </tr>
                        <tr>
                          <th scope="row"><?php echo $this->lang->line('umb_applied_on');?></th>
                          <td class="text-right"><?php echo $this->Umb_model->set_date_format($last_cuti->created_at);?></td>
                        </tr>
                        <tr>
                          <th scope="row"><?php echo $this->lang->line('umb_hrastral_total_hari');?></th>
                          <td class="text-right"><?php echo $last_cuti_day_info;?></td>
                        </tr>                
                      <?php }?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_cuti_statistics');?></strong></span> </div>
            <div class="card-body">
              <div class="box-block card-dashboard">
                <?php $kategoris_cuti_ids = explode(',',$cuti_user[0]->kategoris_cuti); ?>
                <?php foreach($all_types_cuti as $type) {
                 if(in_array($type->type_cuti_id,$kategoris_cuti_ids)){?>
                  <?php
                  $hlfcount =0;
					//$count_l =0;
                  $cal_cuti_setengahari = karyawan_cal_cuti_setengahari($type->type_cuti_id,$karyawan_id);
                  foreach($cal_cuti_setengahari as $lhalfday):
                    $hlfcount += 0.5;
                  endforeach;
                  $count_l = count_info_cutii($type->type_cuti_id,$karyawan_id);
                  $count_l = $count_l - $hlfcount;
                  ?>
                  <?php
                  $edays_per_year = $type->days_per_year;
                  
                  if($count_l == 0){
                    $progress_class = '';
                    $count_data = 0;
                  } else {
                    if($edays_per_year > 0){
                     $count_data = $count_l / $edays_per_year * 100;
                   } else {
                     $count_data = 0;
                   }
						// progress
                   if($count_data <= 20) {
                     $progress_class = 'progress-success';
                   } else if($count_data > 20 && $count_data <= 50){
                     $progress_class = 'progress-info';
                   } else if($count_data > 50 && $count_data <= 75){
                     $progress_class = 'progress-warning';
                   } else {
                     $progress_class = 'progress-danger';
                   }
                 }
                 ?>
                 <p><strong><?php echo $type->type_name;?> (<?php echo $count_l;?>/<?php echo $edays_per_year;?>)</strong></p>
                 <div class="progress mb-2">
                   <div class="progress-bar" style="width: <?php echo $count_data;?>%;"></div>
                 </div>
               <?php } }?>
               
             </div>
           </div>
         </div>
       </div>
     </div>
   </div>
 </div>