<?php $session = $this->session->userdata('client_username'); ?>
<?php $clientinfo = $this->Clients_model->read_info_client($session['client_id']); ?>

<h4 class="font-weight-bold pys-3 mb-4"> <?php echo $this->lang->line('umb_title_wcb');?>, <?php echo $clientinfo[0]->name;?>!
  <div class="text-muted text-tiny mt-1"><small class="font-weight-normal"><?php echo $this->lang->line('umb_title_today_is');?> <?php echo date('l, j F Y');?></small></div>
</h4>
<div class="row">
  <div class="col-sm-6 col-xl-3"> <a href="<?php echo site_url('client/invoices/');?>">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="lnr lnr-cart display-4 text-success"></div>
          <div class="ml-3">
            <div class="text-muted small"><?php echo $this->lang->line('umb_invoice_bayar_client');?></div>
            <div class="text-large"><?php echo clients_count_bayar_invoice($session['client_id']);?></div>
          </div>
        </div>
      </div>
    </div>
  </a> </div>
  <div class="col-sm-6 col-xl-3"> <a href="<?php echo site_url('client/invoices/');?>">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="lnr lnr-earth display-4 text-info"></div>
          <div class="ml-3">
            <div class="text-muted small"><?php echo $this->lang->line('umb_invoice_belum_dibayar_client');?></div>
            <div class="text-large"><?php echo count_invoice_clients_belum_dibayar($session['client_id']);?></div>
          </div>
        </div>
      </div>
    </div>
  </a> </div>
  <div class="col-sm-6 col-xl-3"> <a href="<?php echo site_url('client/projects/');?>">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="lnr lnr-gift display-4 text-danger"></div>
          <div class="ml-3">
            <div class="text-muted small"><?php echo $this->lang->line('umb_completed').' '.$this->lang->line('umb_project');?></div>
            <div class="text-large"><?php echo clients_project_completed($session['client_id']);?></div>
          </div>
        </div>
      </div>
    </div>
  </a> </div>
  <div class="col-sm-6 col-xl-3"> <a href="<?php echo site_url('client/projects/');?>">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="lnr lnr-users display-4 text-warning"></div>
          <div class="ml-3">
            <div class="text-muted small"><?php echo $this->lang->line('umb_in_progress').' '.$this->lang->line('umb_project');?></div>
            <div class="text-large"><?php echo clients_project_inprogress($session['client_id']);?></div>
          </div>
        </div>
      </div>
    </div>
  </a> </div>
</div>
<div class="row">
  <div class="col-sm-6 col-xl-3"> <a href="<?php echo site_url('client/invoices/');?>">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="lnr lnr-cart display-4 text-success"></div>
          <div class="ml-3">
            <div class="text-muted small"><?php echo $this->lang->line('umb_bayar_jumlah');?></div>
            <div class="text-large"><?php echo $this->Umb_model->currency_sign(clients_jumlah_bayar_invoice($session['client_id']));?></div>
          </div>
        </div>
      </div>
    </div>
  </a> </div>
  <div class="col-sm-6 col-xl-3"> <a href="<?php echo site_url('client/invoices/');?>">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="lnr lnr-earth display-4 text-info"></div>
          <div class="ml-3">
            <div class="text-muted small"><?php echo $this->lang->line('umb_invoice_due_jumlah');?></div>
            <div class="text-large"><?php echo $this->Umb_model->currency_sign(clients_jumlah_invoice_belum_dibayar($session['client_id']));?></div>
          </div>
        </div>
      </div>
    </div>
  </a> </div>
  <div class="col-sm-6 col-xl-3"> <a href="<?php echo site_url('client/projects/');?>">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="lnr lnr-gift display-4 text-danger"></div>
          <div class="ml-3">
            <div class="text-muted small"><?php echo $this->lang->line('umb_not_started').' '.$this->lang->line('umb_project');?></div>
            <div class="text-large"><?php echo clients_project_belum_mulai($session['client_id']);?></div>
          </div>
        </div>
      </div>
    </div>
  </a> </div>
  <div class="col-sm-6 col-xl-3"> <a href="<?php echo site_url('client/projects/');?>">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="lnr lnr-users display-4 text-warning"></div>
          <div class="ml-3">
            <div class="text-muted small"><?php echo $this->lang->line('umb_deffered').' '.$this->lang->line('umb_project');?></div>
            <div class="text-large"><?php echo clients_project_deffered($session['client_id']);?></div>
          </div>
        </div>
      </div>
    </div>
  </a> </div>
</div>
<div class="row"> 
  <!-- Left col -->
  <div class="col-md-6"> 
    <!-- TABLE: LATEST ORDERS -->
    <div class="card box-info">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('dashboard_projects_saya');?></strong></span> </div>
      <!-- /.box-header -->
      <div class="card-body">
        <div class="table-responsive">
          <table class="table no-margin">
            <thead>
              <tr>
                <th><?php echo $this->lang->line('umb_ringkasan_project');?></th>
                <th><?php echo $this->lang->line('umb_p_priority');?></th>
                <th><?php echo $this->lang->line('umb_p_enddate');?></th>
                <th><?php echo $this->lang->line('dashboard_umb_progress');?></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($this->Umb_model->lima_projects_client_terakhir($session['client_id']) as $_project) {?>
                <?php
                if($_project->priority == 1) {
                 $priority = '<span class="badge badge-danger">'.$this->lang->line('umb_highest').'</span>';
               } else if($_project->priority ==2){
                 $priority = '<span class="badge badge-danger">'.$this->lang->line('umb_high').'</span>';
               } else if($_project->priority ==3){
                 $priority = '<span class="badge badge-primary">'.$this->lang->line('umb_normal').'</span>';
               } else {
                 $priority = '<span class="badge badge-success">'.$this->lang->line('umb_low').'</span>';
               }
               $pdate = '<i class="far fa-calendar-alt position-left"></i> '.$this->Umb_model->set_date_format($_project->end_date);
					//progress_project
               if($_project->progress_project <= 20) {
                $progress_class = 'progress-danger';
              } else if($_project->progress_project > 20 && $_project->progress_project <= 50){
                $progress_class = 'progress-warning';
              } else if($_project->progress_project > 50 && $_project->progress_project <= 75){
                $progress_class = 'progress-info';
              } else {
                $progress_class = 'progress-success';
              }
					// progress
              $pbar = '<p class="m-b-0-5">'.$this->lang->line('umb_completed').' <span class="pull-xs-right">'.$_project->progress_project.'%</span></p><progress class="progress '.$progress_class.' progress-sm" value="'.$_project->progress_project.'" max="100">'.$_project->progress_project.'%</progress>';
              ?>
              <tr>
                <td><a href="<?php echo site_url().'client/projects/detail/'.$_project->project_id;?>"><?php echo $_project->title;?></a></td>
                <td><?php echo $priority;?></td>
                <td><?php echo $pdate;?></td>
                <td><?php echo $pbar;?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
      <!-- /.table-responsive --> 
    </div>
    <!-- /.box-body -->
    <div class="box-footer clearfix"> <a href="<?php echo site_url('client/projects/');?>" class="btn btn-sm btn-info btn-flat pull-left"><?php echo $this->lang->line('dashboard_projects_saya');?></a> </div>
    <!-- /.box-footer --> 
  </div>
  <!-- /.box --> 
</div>
<div class="col-md-6"> 
  <!-- TABLE: LATEST ORDERS -->
  <div class="card box-info">
    <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_list_all');?></strong> <?php echo $this->lang->line('umb_invoices_title');?></span> </div>
    <!-- /.box-header -->
    <div class="card-body">
      <div class="table-responsive">
        <table class="table no-margin">
          <thead>
            <tr>
              <th>Invoice#
                <?php //echo $this->lang->line('umb_nama_klien');?></th>
                <th><?php echo $this->lang->line('umb_project');?></th>
                <th>Total
                  <?php //echo $this->lang->line('umb_email');?></th>
                  <th>Invoice Date
                    <?php //echo $this->lang->line('umb_website');?></th>
                    <th>Due Date
                      <?php //echo $this->lang->line('umb_kota');?></th>
                      <th>Status
                        <?php //echo $this->lang->line('umb_negara');?></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php //$client = lima_invoices_clent_terakhir_info($session['client_id']);?>
                      <?php foreach($this->Invoices_model->lima_invoices_clent_terakhir($session['client_id']) as $r) {?>
                        <?php
                        $grand_total = $this->Umb_model->currency_sign($r->grand_total);
                        $project = $this->Project_model->read_informasi_project($r->project_id); 
                        if(!is_null($project)){
                          $nama_project = $project[0]->title;
                        } else {
                          $nama_project = '--';
                        }
                        // if($project[0]->client_id==$session['client_id']) {
                        $tanggal_invoice = '<i class="far fa-calendar-alt position-left"></i> '.$this->Umb_model->set_date_format($r->tanggal_invoice);
                        $tanggal_jatoh_tempo_invoice = '<i class="far fa-calendar-alt position-left"></i> '.$this->Umb_model->set_date_format($r->tanggal_jatoh_tempo_invoice);
                        $nomor_invoice = '<a href="'.site_url().'client/invoices/view/'.$r->invoice_id.'/">'.$r->nomor_invoice.'</a>';
                        if($r->status == 0){
                          $istatus = $this->lang->line('umb_payroll_belum_dibayar');
                        } else {
                          $istatus = $this->lang->line('umb_payment_bayar');
                        }
                        ?>
                        <tr>
                          <td><?php echo $nomor_invoice;?></td>
                          <td><?php echo $nama_project;?></td>
                          <td><?php echo $grand_total;?></td>
                          <td><?php echo $tanggal_invoice;?></td>
                          <td><?php echo $tanggal_jatoh_tempo_invoice;?></td>
                          <td><?php echo $istatus;?></td>
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
                <!-- /.table-responsive --> 
              </div>
              <!-- /.box-body -->
              <div class="box-footer clearfix"> <a href="<?php echo site_url('client/invoices/');?>" class="btn btn-sm btn-info btn-flat pull-left"><?php echo $this->lang->line('umb_invoices_all');?></a> </div>
              <!-- /.box-footer --> 
            </div>
            <!-- /.box --> 
          </div>
          <!-- /.col --> 
        </div>
        <style type="text/css">
        .box-body {
          padding: 0 !important;
        }
        .info-box-number {
         font-size:16px !important;
         font-weight:300 !important;
       }
     </style>
