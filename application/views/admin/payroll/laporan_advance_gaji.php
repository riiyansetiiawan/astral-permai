<?php
/* Payroll > Advance gaji Report view
*/
?>
<?php $session = $this->session->userdata('username');?>

<div class="card">
  <h6 class="card-header"> <?php echo $this->lang->line('umb_advance_gaji');?> <?php echo $this->lang->line('umb_report');?> </h6>
  <div class="card-datatable table-responsive">
    <table class="datatables-demo table table-striped table-bordered" id="umb_table_report">
      <thead>
        <tr>
          <th><?php echo $this->lang->line('umb_action');?></th>
          <th><?php echo $this->lang->line('left_perusahaan');?></th>
          <th><?php echo $this->lang->line('dashboard_single_karyawan');?></th>
          <th><?php echo $this->lang->line('umb_jumlah_total');?></th>
          <th><?php echo $this->lang->line('umb_total_yang_dibayarkan_jumlah');?></th>
          <th><?php echo $this->lang->line('umb_remaining_jumlah');?></th>
          <th><?php echo $this->lang->line('dashboard_umb_status');?></th>
        </tr>
      </thead>
    </table>
  </div>
</div>
<style type="text/css">
.hide-calendar .ui-datepicker-calendar { display:none !important; }
.hide-calendar .ui-priority-secondary { display:none !important; }
</style>
