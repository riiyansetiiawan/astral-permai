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
    <small class="font-weight-normal"><?php echo $this->lang->line('umb_title_today_is');?> 
    <?php echo date('l, j F Y');?></small>
  </div>
</h4>
<?php if($theme[0]->statistics_cards=='4' || $theme[0]->statistics_cards=='8'){?>
  <div class="row <?php echo $get_animate;?>">
    <?php if(in_array('13',$role_resources_ids)) { ?>
      <div class="col-sm-6 col-xl-3"> 
        <a href="<?php echo site_url('admin/karyawans');?>" class="text-body">
          <div class="card mb-4">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="ion ion-ios-contacts display-4 text-primary"></div>
                <div class="ml-3">
                  <div class="text-muted small"><?php echo $this->lang->line('umb_people');?></div>
                  <div class="text-big"><?php echo $this->Karyawans_model->get_total_karyawans();?></div>
                </div>
              </div>
            </div>
          </div>
        </a> 
      </div>
    <?php } ?>  
    <div class="col-sm-6 col-xl-3"> 
      <a href="<?php echo site_url('admin/roles');?>" class="text-body">
        <div class="card mb-4">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="ion ion-ios-lock display-4 text-primary"></div>
              <div class="ml-3">
                <div class="text-muted small"><?php echo $this->lang->line('umb_roles');?></div>
                <div class="text-big"><?php echo $this->lang->line('umb_permission');?></div>
              </div>
            </div>
          </div>
        </div>
      </a> 
    </div>
    <?php if(in_array('46',$role_resources_ids)) { ?>  
      <div class="col-sm-6 col-xl-3"> 
        <a href="<?php echo site_url('admin/timesheet/cuti');?>" class="text-body">
          <div class="card mb-4">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="ion ion-md-calendar display-4 text-primary"></div>
                <div class="ml-3">
                  <div class="text-muted small"><?php echo $this->lang->line('left_cuti');?></div>
                  <div class="text-big"><?php echo $this->lang->line('umb_performance_management');?></div>
                </div>
              </div>
            </div>
          </div>
        </a> 
      </div>
    <?php } ?>
    <?php if(in_array('36',$role_resources_ids)) { ?>   
      <div class="col-sm-6 col-xl-3"> 
        <a href="<?php echo site_url('admin/payroll/generate_slipgaji');?>" class="text-body">
          <div class="card mb-4">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="ion ion-ios-calculator display-4 text-primary"></div>
                <div class="ml-3">
                  <div class="text-muted small"><?php echo $this->lang->line('dashboard_total_gajii');?></div>
                  <div class="text-big"><?php echo $this->Umb_model->currency_sign(total_bayar_gajii());?></div>
                </div>
              </div>
            </div>
          </div>
        </a> 
      </div>
    <?php } ?>  
  </div>
<?php } ?>
<?php if($theme[0]->statistics_cards=='8'){?>
  <div class="row <?php echo $get_animate;?>">
    <?php if($system[0]->module_files=='true'){?>
      <?php if(in_array('47',$role_resources_ids)) { ?>
        <div class="col-sm-6 col-xl-3"> 
          <a href="<?php echo site_url('admin/files');?>" class="text-body">
            <div class="card mb-4">
              <div class="card-body">
                <div class="d-flex align-items-center">
                  <div class="ion ion-ios-paper display-4 text-primary"></div>
                  <div class="ml-3">
                    <div class="text-muted small"><?php echo $this->lang->line('umb_e_details_document');?></div>
                    <div class="text-big"><?php echo $this->lang->line('umb_performance_management');?></div>
                  </div>
                </div>
              </div>
            </div>
          </a> 
        </div>
      <?php } ?>  
    <?php } ?>
    <?php if(in_array('93',$role_resources_ids)) { ?>
      <div class="col-sm-6 col-xl-3"> 
        <a href="<?php echo site_url('admin/settings/modules');?>" class="text-body">
          <div class="card mb-4">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="fas fa-life-ring display-4 text-primary"></div>
                <div class="ml-3">
                  <div class="text-muted small"><?php echo $this->lang->line('umb_configure_hr');?></div>
                  <div class="text-big"><?php echo $this->lang->line('umb_modules');?></div>
                </div>
              </div>
            </div>
          </div>
        </a> 
      </div>
    <?php } ?>  
    <?php if($system[0]->module_projects_tugass=='true'){?>
      <?php if(in_array('44',$role_resources_ids)) { ?>
        <div class="col-sm-6 col-xl-3"> 
          <a href="<?php echo site_url('admin/project');?>" class="text-body">
            <div class="card mb-4">
              <div class="card-body">
                <div class="d-flex align-items-center">
                  <div class="ion ion-logo-buffer display-4 text-primary"></div>
                  <div class="ml-3">
                    <div class="text-muted small"><?php echo $this->lang->line('dashboard_projects');?></div>
                    <div class="text-big"><?php echo $this->Umb_model->get_all_projects();?></div>
                  </div>
                </div>
              </div>
            </div>
          </a> 
        </div>
      <?php } ?>
      <?php if(in_array('45',$role_resources_ids)) { ?>
        <div class="col-sm-6 col-xl-3"> 
          <a href="<?php echo site_url('admin/timesheet/tugass');?>" class="text-body">
            <div class="card mb-4">
              <div class="card-body">
                <div class="d-flex align-items-center">
                  <div class="fab fa-fantasy-flight-games display-4 text-primary"></div>
                  <div class="ml-3">
                    <div class="text-muted small"><?php echo $this->lang->line('umb_tugass');?></div>
                    <div class="text-big"><?php echo completed_tugass();?></div>
                  </div>
                </div>
              </div>
            </div>
          </a> 
        </div> 
      <?php } ?> 
    <?php } ?>
  </div>
<?php } ?>
<div class="row <?php echo $get_animate;?>">
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
                  <?php $j=0;foreach($this->Department_model->all_departments() as $department) { ?>
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
</div>
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
<div class="row row-card-no-pd mt--2 <?php echo $get_animate;?>">
  <div class="col-12 col-sm-6 col-md-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between">
          <div>
            <h5>
              <span><?php echo $this->lang->line('umb_hrastral_absent_today');?></span>
            </h5>
            <p class="text-muted"><?php echo $this->lang->line('umb_absent');?></p>
          </div>
          <h3 class="text-info fw-bold"><?php echo $abs;?></h3>
        </div>
        <div class="progress progress-sm">
          <div class="progress-bar progress-bar-info w-75" role="progressbar" aria-valuenow="<?php echo $this->Umb_model->set_percentage($krywn_abs);?>" aria-valuemin="8" aria-valuemax="100" style="width: <?php echo $this->Umb_model->set_percentage($krywn_abs);?>%"></div>
        </div>
        <div class="d-flex justify-content-between mt-2">
          <p class="text-muted mb-0"><?php echo $this->lang->line('umb_hrastral_absent_status');?></p>
          <p class="text-muted mb-0"><?php echo $this->Umb_model->set_percentage($krywn_abs);?>%</p>
        </div>
      </div>
    </div>
  </div>
  <div class="col-12 col-sm-6 col-md-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between">
          <div>
            <h5>
              <span><?php echo $this->lang->line('umb_hrastral_present_today');?></span>
            </h5>
            <p class="text-muted"><?php echo $this->lang->line('umb_krywn_bekerja');?></p>
          </div>
          <h3 class="text-info fw-bold"><?php echo $bekerja;?></h3>
        </div>
        <div class="progress progress-sm">
          <div class="progress-bar progress-bar-info w-75" role="progressbar" aria-valuenow="<?php echo $this->Umb_model->set_percentage($krywn_kerja);?>" aria-valuemin="8" aria-valuemax="100" style="width: <?php echo $this->Umb_model->set_percentage($krywn_kerja);?>%"></div>
        </div>
        <div class="d-flex justify-content-between mt-2">
          <p class="text-muted mb-0"><?php echo $this->lang->line('umb_hrastral_present_status');?></p>
          <p class="text-muted mb-0"><?php echo $this->Umb_model->set_percentage($krywn_kerja);?>%</p>
        </div>
      </div>
    </div>
  </div>
  <div class="col-12 col-sm-6 col-md-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between">
          <div>
            <h5>
              <span><?php echo $this->lang->line('dashboard_projects');?></span>
            </h5>
            <p class="text-muted"><?php echo $this->lang->line('umb_hrastral_project_status');?></p>
          </div>
          <?php $completed_proj = $this->Project_model->complete_projects();?>
          <?php $proj = $this->Umb_model->get_all_projects();
          if($proj < 1) {
            $proj_percnt = 0;
          } else {
            $proj_percnt = $completed_proj / $proj * 100;
          }
          ?>
          <h3 class="text-info fw-bold">
            <a class="text-card-mduted" href="<?php echo site_url('admin/project');?>"><?php echo $this->Umb_model->get_all_projects();?></a>
          </h3>
        </div>
        <div class="progress progress-sm">
          <div class="progress-bar progress-bar-info w-75" role="progressbar" aria-valuenow="<?php echo $this->Umb_model->set_percentage($proj_percnt);?>" aria-valuemin="8" aria-valuemax="100" style="width: <?php echo $this->Umb_model->set_percentage($proj_percnt);?>%"></div>
        </div>
        <div class="d-flex justify-content-between mt-2">
          <p class="text-muted mb-0"><?php echo $this->lang->line('umb_completed');?></p>
          <p class="text-muted mb-0"><?php echo $this->Umb_model->set_percentage($proj_percnt);?>%</p>
        </div>
      </div>
    </div>
  </div>
  <div class="col-12 col-sm-6 col-md-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between">
          <div>
            <h5>
              <span><?php echo $this->lang->line('umb_tugass');?></span>
            </h5>
            <p class="text-muted"><?php echo $this->lang->line('umb_hrastral_status_tugas');?></p>
          </div>
          <?php $completed_tugass = completed_tugass();?>
          <?php $tugas_all = $this->Umb_model->get_all_tugass();
          if($tugas_all < 1) {
            $tugas_percnt = 0;
          } else {
            $tugas_percnt = $completed_tugass / $tugas_all * 100;
          }
          ?>
          <h3 class="text-info fw-bold">
            <a class="text-card-mduted" href="<?php echo site_url('admin/timesheet/tugass');?>"><?php echo $this->Umb_model->get_all_tugass();?></a>
          </h3>
        </div>
        <div class="progress progress-sm">
          <div class="progress-bar progress-bar-info w-75" role="progressbar" aria-valuenow="<?php echo $this->Umb_model->set_percentage($tugas_percnt);?>" aria-valuemin="8" aria-valuemax="100" style="width: <?php echo $this->Umb_model->set_percentage($tugas_percnt);?>%"></div>
        </div>
        <div class="d-flex justify-content-between mt-2">
          <p class="text-muted mb-0"><?php echo $this->lang->line('umb_completed');?></p>
          <p class="text-muted mb-0"><?php echo $this->Umb_model->set_percentage($tugas_percnt);?>%</p>
        </div>
      </div>
    </div>
  </div>
</div>
<?php if($system[0]->module_inquiry=='true'){?>
  <div class="row mt-4">
    <div class="d-flex col-xl-12 align-items-stretch">
      <div class="card d-flex w-100 mb-4">
        <div class="row no-gutters row-bordered h-100">
          <div class="d-flex col-sm-4 col-md-4 col-lg-4 align-items-center">
            <a href="javascript:void(0)" class="card-body media align-items-center text-body">
              <i class="fab fa-critical-role display-4 d-block text-primary"></i>
              <span class="media-body d-block ml-3">
                <span class="text-big font-weight-bolder"><?php echo total_tickets();?></span><br>
                <small class="text-muted"><?php echo $this->lang->line('umb_hr_total_tickets');?></small>
              </span>
            </a>
          </div>
          <div class="d-flex col-sm-4 col-md-4 col-lg-4 align-items-center">
            <a href="javascript:void(0)" class="card-body media align-items-center text-body">
              <i class="lnr lnr-chart-bars display-4 d-block text-primary"></i>
              <span class="media-body d-block ml-3">
                <span class="text-big"><?php echo total_open_tickets();?></span><br>
                <small class="text-muted"><?php echo $this->lang->line('umb_hr_total_open_tickets');?></small>
              </span>
            </a>
          </div>
          <div class="d-flex col-sm-4 col-md-4 col-lg-4 align-items-center">
            <a href="javascript:void(0)" class="card-body media align-items-center text-body">
              <i class="lnr lnr-checkmark-circle display-4 d-block text-primary"></i>
              <span class="media-body d-block ml-3">
                <span class="text-big"><?php echo total_closed_tickets();?></span><br>
                <small class="text-muted"><?php echo $this->lang->line('umb_hr_total_closed_tickets');?></small>
              </span>
            </a>
          </div>
        </div>
      </div>
    </div>  
  </div>
<?php } ?>
<?php if($theme[0]->dashboard_calendar == 'true'):?>
  <?php $this->load->view('admin/calendar/calendar_hr');?>
  <?php endif; ?>