<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['karyawan_id']) && $_GET['type']=='status_cuti'){
	if($_GET['opt_cuti'] == 'Approved'){
		$cuti = $this->Laporans_model->get_pending_list_cuti($_GET['karyawan_id'],2);
	} else if($_GET['opt_cuti'] == 'Pending'){
		$cuti = $this->Laporans_model->get_pending_list_cuti($_GET['karyawan_id'],1);
	} else if($_GET['opt_cuti'] == 'Upcoming'){
		$cuti = $this->Laporans_model->get_pending_list_cuti($_GET['karyawan_id'],4);
	} else if($_GET['opt_cuti'] == 'Rejected'){
		$cuti = $this->Laporans_model->get_pending_list_cuti($_GET['karyawan_id'],3);
	}
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $_GET['opt_cuti'].' '.$this->lang->line('umb_cuti_detail');?></h4>
</div>
<form class="m-b-1">
<div class="modal-body" >
  <div class="box-datatable table-responsive">
        <table class="datatables-demo table table-striped table-bordered" id="umb_table">
          <thead>
            <tr>
              <th><?php echo $this->lang->line('umb_type_cuti');?></th>
              <th><?php echo $this->lang->line('umb_e_details_frm_date');?></th>
              <th><?php echo $this->lang->line('dashboard_umb_end_date');?></th>
              <th><?php echo $this->lang->line('umb_alasan_cuti');?></th>
            </tr>
          </thead>
          <tbody>
          <?php foreach($cuti->result() as $r) { ?>
          <?php
		  // get leave type
			$type_cuti = $this->Timesheet_model->read_informasi_type_cuti($r->type_cuti_id);
			if(!is_null($type_cuti)){
				$type_name = $type_cuti[0]->type_name;
			} else {
				$type_name = '--';	
			}
			$from_date = $this->Umb_model->set_date_format($r->from_date);
			$end_date = $this->Umb_model->set_date_format($r->to_date);
			?>
              <tr role="row" class="odd">
                <td class="sorting_1"><?php echo $type_name;?></td>
                <td><?php echo $from_date;?></td>
                <td><?php echo $end_date;?></td>
                <td><?php echo $r->reason;?></td>
              </tr>
           <?php } ?>   
          </tbody>
        </table>
      </div>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('umb_close');?></button>
</div>
<?php echo form_close(); ?>
<?php } ?>
