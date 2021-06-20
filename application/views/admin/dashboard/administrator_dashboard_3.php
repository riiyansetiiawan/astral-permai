<?php
$session = $this->session->userdata('username');
$system = $this->Umb_model->read_setting_info(1);
$info_perusahaan = $this->Umb_model->read_info_setting_perusahaan(1);
$user = $this->Umb_model->read_info_karyawan($session['user_id']);
$theme = $this->Umb_model->read_theme_info(1);
?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>
<?php $role_resources_ids = $this->Umb_model->user_role_resource(); ?>
<h4 class="font-weight-bold pys-3 mb-4"> <?php echo $this->lang->line('umb_title_wcb');?>, <?php echo $user[0]->first_name.' '.$user[0]->last_name;?>!
  <div class="text-muted text-tiny mt-1">
    <small class="font-weight-normal"><?php echo $this->lang->line('umb_title_today_is');?> <?php echo date('l, j F Y');?></small>
  </div>
</h4>
<div class="row">
  <div class="d-flex col-xl-6 align-items-stretch">
    <div class="card d-flex w-100 mb-4">
      <div class="row no-gutters row-bordered h-100">
        <?php if(in_array('13',$role_resources_ids)) { ?>
          <div class="d-flex col-sm-6 col-md-4 col-lg-6 align-items-center">
            <a href="javascript:void(0)" class="card-body media align-items-center text-body">
              <i class="ion ion-ios-contacts display-4 d-block text-primary"></i>
              <span class="media-body d-block ml-3">
                <span class="text-big font-weight-bolder"><?php echo $this->Karyawans_model->get_total_karyawans();?></span><br>
                <small class="text-muted"><?php echo $this->lang->line('umb_people');?></small>
              </span>
            </a>
          </div>
        <?php } ?>
        <?php if(in_array('76',$role_resources_ids)) { ?>
          <div class="d-flex col-sm-6 col-md-4 col-lg-6 align-items-center">
            <a href="javascript:void(0)" class="card-body media align-items-center text-body">
              <i class="ion ion-ios-cash display-4 d-block text-primary"></i>
              <span class="media-body d-block ml-3">
                <span class="text-big font-weight-bolder"><?php echo $this->Umb_model->currency_sign(dashboard_total_biaya());?></span><br>
                <small class="text-muted"><?php echo $this->lang->line('umb_total_biayaa');?></small>
              </span>
            </a>
          </div>
        <?php } ?>
        <?php if(in_array('46',$role_resources_ids)) { ?>
          <div class="d-flex col-sm-6 col-md-4 col-lg-6 align-items-center">
            <a href="javascript:void(0)" class="card-body media align-items-center text-body">
              <i class="ion ion-md-calendar display-4 d-block text-primary"></i>
              <span class="media-body d-block ml-3">
                <span class="text-big font-weight-bolder"><?php echo karyawan_permintaan_cutii();?></span><br>
                <small class="text-muted"><?php echo $this->lang->line('umb_kehadiran_total_cuti');?></small>
              </span>
            </a>
          </div>
        <?php } ?>
        <?php if(in_array('36',$role_resources_ids)) { ?>
          <div class="d-flex col-sm-6 col-md-4 col-lg-6 align-items-center">
            <a href="javascript:void(0)" class="card-body media align-items-center text-body">
              <i class="ion ion-ios-calculator display-4 d-block text-primary"></i>
              <span class="media-body d-block ml-3">
                <span class="text-big font-weight-bolder"><?php echo $this->Umb_model->currency_sign(total_bayar_gajii());?></span><br>
                <small class="text-muted"><?php echo $this->lang->line('dashboard_total_gajii');?></small>
              </span>
            </a>

          </div>
        <?php } ?>
      </div>
    </div>
  </div>
  <div class="d-flex col-xl-6 align-items-stretch">
    <div class="card w-100 mb-4">
      <div class="card-body">
        <div class="text-big"><?php echo $this->lang->line('left_payroll');?></div>
      </div>
      <div class="px-2">
        <div class="w-100" style="height: 120px;">
          <canvas id="hrastral_payroll" style="display: block; height: 210px; width: 754px;" width="942" height="262"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>
<?php if(in_array('3',$role_resources_ids) || in_array('4',$role_resources_ids)) { ?>
  <div class="row">
    <?php if(in_array('3',$role_resources_ids)) { ?>
      <div class="col-md-6">
        <div class="card mb-4">
          <h6 class="card-header with-elements border-0 pr-0 pb-0">
            <div class="card-header-title"><?php echo $this->lang->line('umb_karyawan_department_txt');?></div>
          </h6>
          <div class="row">
            <div class="col-md-6">
              <div id="overflow-scrolls" class="overflow-scrolls py-4 px-3 " style="overflow:auto; height:200px;">
                <div class="table-responsive">
                  <table class="table mb-0 table-dashboard">
                    <tbody>
                      <?php $c_color = array('#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b');?>
                      <?php $j=0; foreach($this->Department_model->all_departments() as $department) { ?>
                        <?php
                        $condition = "department_id =" . "'" . $department->department_id . "'";
                        $this->db->select('*');
                        $this->db->from('umb_karyawans');
                        $this->db->where($condition);
                        $query = $this->db->get();
                        if ($query->num_rows() > 0) {
                          ?>
                          <tr>
                            <td style="vertical-align: inherit;">
                              <div style="width:4px;border:5px solid <?php echo $c_color[$j];?>;"></div>
                            </td>
                            <td><?php echo htmlspecialchars_decode($department->nama_department);?> (<?php echo $query->num_rows();?>)</td>
                          </tr>
                          <?php $j++; 
                        } ?>
                      <?php  } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="col-md-5">
              <div style="height:150px;">
                <canvas id="karyawan_department" height="250" width="270" style="display: block; height: 150px; width:300px;"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php  } ?>
    <?php if(in_array('4',$role_resources_ids)) { ?>
      <div class="col-md-6">
        <div class="card mb-4">
          <h6 class="card-header with-elements border-0 pr-0 pb-0">
            <div class="card-header-title"><?php echo $this->lang->line('umb_karyawan_penunjukan_txt');?></div>
          </h6>
          <div class="row">
            <div class="col-md-6">
              <div id="overflow-scrolls2" class="py-4 px-3 " style="overflow:auto; height:200px;">
                <div class="table-responsive">
                  <table class="table mb-0 table-dashboard">
                    <tbody>
                      <?php $c_color2 = array('#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b');?>
                      <?php $k=0;foreach($this->Penunjukan_model->all_penunjukans() as $penunjukan) { ?>
                        <?php
                        $condition1 = "penunjukan_id =" . "'" . $penunjukan->penunjukan_id . "'";
                        $this->db->select('*');
                        $this->db->from('umb_karyawans');
                        $this->db->where($condition1);
                        $query1 = $this->db->get();
                        if ($query1->num_rows() > 0) {
                          ?>
                          <tr>
                            <td style="vertical-align: inherit;">
                              <div style="width:4px;border:5px solid <?php echo $c_color2[$k];?>;"></div>
                            </td>
                            <td><?php echo htmlspecialchars_decode($penunjukan->nama_penunjukan);?> (<?php echo $query1->num_rows();?>)</td>
                          </tr>
                          <?php $k++; 
                        } ?>
                      <?php  } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="col-md-5">
              <div style="height:150px;">
                <canvas id="karyawan_penunjukan" height="250" width="270" style="display: block; height: 150px; width:300px;"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php  } ?>
  </div>
<?php  } ?>
<?php if(in_array('44',$role_resources_ids) || in_array('45',$role_resources_ids) || in_array('75',$role_resources_ids) || in_array('330',$role_resources_ids)) { ?>
  <div class="row">
    <div class="d-flex col-xl-12 align-items-stretch"> 
      <div class="card d-flex w-100 mb-4">
        <div class="row no-gutters row-bordered h-100">
          <?php if(in_array('44',$role_resources_ids)) { ?>
            <div class="d-flex col-sm-6 col-md-3 col-lg-3 align-items-center"> 
              <a href="javascript:void(0)" class="card-body media align-items-center text-body"> 
                <i class="ion ion-logo-buffer display-4 d-block text-primary"></i> 
                <span class="media-body d-block ml-3"> 
                  <span class="text-big">
                    <span class="font-weight-bolder"><?php echo total_completed_projects();?></span> 
                    <?php echo $this->lang->line('left_projects');?>
                  </span><br>
                  <small class="text-muted"><?php echo $this->lang->line('dashboard_completed');?></small>
                </span> 
              </a> 
            </div>
          <?php  } ?>
          <?php if(in_array('45',$role_resources_ids)) { ?>
            <div class="d-flex col-sm-6 col-md-3 col-lg-3 align-items-center"> 
              <a href="javascript:void(0)" class="card-body media align-items-center text-body"> 
                <i class="fab fa-fantasy-flight-games display-4 d-block text-primary"></i> 
                <span class="media-body d-block ml-3"> 
                  <span class="text-big">
                    <span class="font-weight-bolder"><?php echo total_completed_tugass();?></span> 
                    <?php echo $this->lang->line('left_tugass');?>
                  </span><br>
                  <small class="text-muted"><?php echo $this->lang->line('dashboard_completed');?></small>
                </span> 
              </a> 
            </div>
          <?php  } ?>
          <?php if(in_array('75',$role_resources_ids)) { ?>
            <div class="d-flex col-sm-6 col-md-3 col-lg-3 align-items-center"> 
              <a href="javascript:void(0)" class="card-body media align-items-center text-body"> 
                <i class="ion ion-logo-usd display-4 d-block text-primary"></i>
                <span class="media-body d-block ml-3"> 
                  <span class="text-big font-weight-bolder"><?php echo $this->Umb_model->currency_sign(dashboard_total_sales());?></span><br>
                  <small class="text-muted"><?php echo $this->lang->line('umb_total_deposit');?></small> 
                </span> 
              </a> 
            </div>
          <?php  } ?>
          <?php if(in_array('330',$role_resources_ids)) { ?>
            <div class="d-flex col-sm-6 col-md-3 col-lg-3 align-items-center"> 
              <a href="javascript:void(0)" class="card-body media align-items-center text-body"> 
                <i class="ion ion-ios-paper display-4 d-block text-primary"></i> 
                <span class="media-body d-block ml-3"> 
                  <span class="text-big font-weight-bolder"><?php echo $this->Umb_model->currency_sign(total_invoices_bayar());?></span><br>
                  <small class="text-muted"><?php echo $this->lang->line('umb_acc_pembayarans_invoice');?></small> 
                </span> 
              </a> 
            </div>
          <?php  } ?>
        </div>
      </div>
    </div>
  </div>
<?php  } ?>
<?php if(in_array('44',$role_resources_ids) || in_array('76',$role_resources_ids) || in_array('75',$role_resources_ids) || in_array('13',$role_resources_ids)) { ?>
  <?php
  $current_month = date('Y-m-d');
  $bekerja = $this->Umb_model->current_hari_bulan_kehadiran($current_month);
  $query = $this->Umb_model->all_status_karyawans();
  $total = $query->num_rows();
  $abs = $total - $bekerja;
  ?>
  <?php
  $krywn_abs = $abs / $total * 100;
  $krywn_kerja = $bekerja / $total * 100;
  ?>
  <?php
  $krywn_abs = $abs / $total * 100;
  $krywn_kerja = $bekerja / $total * 100;
  ?>
  <div class="row"> 
    <?php if(in_array('44',$role_resources_ids)) { ?>
      <div class="col-sm-6 col-xl-4">
        <div class="card mb-4">
          <div class="card-body pb-0">
            <div class="small">
              <div class="btn-group">
                <button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown"><?php echo $this->lang->line('umb_status_projects');?></button>
                <div class="dropdown-menu">
                  <?php $dc_color = array('#647c8a','#2196f3','#02bc77','#d3733b','#673AB7');?>
                  <?php $dj=0;$projects = get_status_projects(); foreach($projects->result() as $eproject) { ?>
                    <?php
                    $row = total_status_projects($eproject->status);
                    if($eproject->status==0){
                      $csname = htmlspecialchars_decode($this->lang->line('umb_not_started'));
                    } else if($eproject->status==1){
                      $csname = htmlspecialchars_decode($this->lang->line('umb_in_progress'));
                    } else if($eproject->status==2){
                      $csname = htmlspecialchars_decode($this->lang->line('umb_completed'));
                    } else if($eproject->status==3){
                      $csname = htmlspecialchars_decode($this->lang->line('umb_project_cancelled'));
                    } else if($eproject->status==4){
                      $csname = htmlspecialchars_decode($this->lang->line('umb_project_hold'));
                    }
                    ?>
                    <a class="dropdown-item" href="javascript:void(0)">
                      <span class="" style="background-color:<?php echo $dc_color[$dj];?>; padding-left:6px; padding-right:6px;">&nbsp;</span> 
                      <span><?php echo htmlspecialchars_decode($csname);?> (<?php echo $row;?>)</span>
                    </a>
                    <?php $dj++; 
                  } ?>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="my-1" style="height: 116px;">
                  <canvas id="hrastral_chart_projects" width="460" height="146" style="display: block; height: 117px; width: 368px;"></canvas>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer"> <?php echo $this->lang->line('umb_status_projects');?> </div>
        </div>
      </div>
    <?php  } ?>
    <?php if(in_array('76',$role_resources_ids) && in_array('75',$role_resources_ids)) { ?>
      <div class="col-sm-6 col-xl-4">
        <div class="card mb-4">
          <div class="card-body pb-0">
            <div class="small">
              <button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown"><?php echo $this->lang->line('umb_deposit_vs_biaya');?></button>
              <div class="dropdown-menu">
                <?php $dc_color = array('#647c8a','#2196f3','#02bc77','#d3733b','#673AB7');?>
                <a class="dropdown-item" href="javascript:void(0)">
                  <span class="" style="background-color:#647c8a; padding-left:6px; padding-right:6px;">&nbsp;</span> 
                  <span><?php echo $this->lang->line('umb_total_deposit');?></span>
                </a> 
                <a class="dropdown-item" href="javascript:void(0)">
                  <span class="" style="background-color:#2196f3; padding-left:6px; padding-right:6px;">&nbsp;</span> 
                  <span><?php echo $this->lang->line('umb_total_biayaa');?></span>
                </a> 
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="my-1" style="height: 116px;">
                  <canvas id="hrastral_biaya_deposit" width="460" height="146" style="display: block; height: 117px; width: 368px;"></canvas>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer"> <?php echo $this->lang->line('umb_deposit_vs_biaya');?> </div>
        </div>
      </div>
    <?php  } ?>
    <?php if(in_array('13',$role_resources_ids)) { ?>
      <div class="col-sm-6 col-xl-4">
        <div class="card pt-2 mb-4">
          <div class="d-flex align-items-center position-relative mt-4" style="height:51px;">
            <div class="w-100 position-absolute" style="height:110px;top:0;"> </div>
            <div class="w-100 text-center text-large"><?php echo $this->Karyawans_model->get_total_karyawans();?></div>
          </div>
          <div class="text-center pb-2 my-3"> <?php echo $this->lang->line('umb_people');?> </div>
          <div class="card-footer text-center py-3">
            <div class="row">
              <div class="col">
                <div class="text-muted small"><?php echo $this->lang->line('umb_absent');?></div>
                <strong class="text-big"><?php echo $this->Umb_model->set_percentage($krywn_abs);?>%</strong> 
              </div>
              <div class="col">
                <div class="text-muted small"><?php echo $this->lang->line('umb_krywn_bekerja');?></div>
                <strong class="text-big"><?php echo $this->Umb_model->set_percentage($krywn_kerja);?>%</strong> 
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php  } ?>
  </div>
<?php  } ?>
<?php if($theme[0]->dashboard_calendar == 'true'):?>
  <?php $this->load->view('admin/calendar/calendar_hr');?>
  <?php endif; ?>