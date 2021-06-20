<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>
<?php $role_resources_ids = $this->Umb_model->user_role_resource(); ?>
<?php $user_info = $this->Umb_model->read_user_info($session['user_id']);?>
<?php $system = $this->Umb_model->read_setting_info(1);?>
<?php $laporans_to = get_data_laporans_team($session['user_id']); ?>

<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('422',$role_resources_ids) && $user_info[0]->user_role_id==1) {?>
      <li class="nav-item active"> 
        <a href="<?php echo site_url('admin/karyawans/dashboard_staff/');?>" data-link-data="<?php echo site_url('admin/karyawans/dashboard_staff/');?>" class="mb-3 nav-link hrastral-link"> 
          <span class="sw-done-icon ion ion-md-speedometer"></span> 
          <span class="sw-icon ion ion-md-speedometer"></span> 
          <?php echo $this->lang->line('hr_title_dashboard_staff');?>
          <div class="text-muted small"><?php echo $this->lang->line('hr_title_dashboard_staff');?></div>
        </a> 
      </li>
    <?php } ?>
    <?php if(in_array('13',$role_resources_ids) || $laporans_to>0) {?>
      <li class="nav-item clickable"> 
        <a href="<?php echo site_url('admin/karyawans/');?>" data-link-data="<?php echo site_url('admin/karyawans/');?>" class="mb-3 nav-link hrastral-link"> 
          <span class="sw-done-icon fas fa-user-friends"></span> 
          <span class="sw-icon fas fa-user-friends"></span> 
          <?php echo $this->lang->line('dashboard_karyawans');?>
          <div class="text-muted small"><?php echo $this->lang->line('umb_set_up');?> <?php echo $this->lang->line('dashboard_karyawans');?></div>
        </a> 
      </li>
    <?php } ?>
    <?php if($user_info[0]->user_role_id==1) {?>
      <li class="nav-item clickable"> 
        <a href="<?php echo site_url('admin/roles/');?>" class="mb-3 nav-link hrastral-link" data-link-data="<?php echo site_url('admin/roles/');?>"> 
          <span class="sw-icon ion ion-md-unlock"></span> 
          <?php echo $this->lang->line('umb_role_urole');?>
          <div class="text-muted small"><?php echo $this->lang->line('left_set_roles');?></div>
        </a> 
      </li>
    <?php } ?>
    <?php if(in_array('7',$role_resources_ids)) { ?>
      <li class="nav-item clickable"> 
        <a href="<?php echo site_url('admin/timesheet/shift_kantor/');?>" data-link-data="<?php echo site_url('admin/timesheet/shift_kantor/');?>" class="mb-3 nav-link hrastral-link"> 
          <span class="sw-icon ion ion-md-clock"></span> 
          <?php echo $this->lang->line('left_shifts_kantor');?>
          <div class="text-muted small"><?php echo $this->lang->line('umb_role_create');?> <?php echo $this->lang->line('left_shifts_kantor');?></div>
        </a> 
      </li>
    <?php } ?>
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<?php if(in_array('13',$role_resources_ids) || in_array('36',$role_resources_ids) || in_array('14',$role_resources_ids) || in_array('46',$role_resources_ids)) { ?>
  <div class="row">
    <?php if(in_array('13',$role_resources_ids)) { ?>
      <div class="col-sm-6 col-xl-3">
        <div class="card mb-4">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="ion ion-ios-contacts display-4 text-success"></div>
              <div class="ml-3">
                <div class="text-muted small"><?php echo $this->lang->line('dashboard_karyawans');?></div>
                <div class="text-large"><?php echo $this->Karyawans_model->get_total_karyawans();?></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php  } ?>
    <?php if(in_array('36',$role_resources_ids)) { ?>
      <div class="col-sm-6 col-xl-3">
        <div class="card mb-4">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="ion ion-ios-calculator display-4 text-info"></div>
              <div class="ml-3">
                <div class="text-muted small"><?php echo $this->lang->line('dashboard_total_gajii');?></div>
                <div class="text-large"><?php echo $this->Umb_model->currency_sign(total_bayar_gajii());?></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php  } ?>
    <?php if(in_array('14',$role_resources_ids)) { ?>
      <div class="col-sm-6 col-xl-3">
        <div class="card mb-4">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="ion ion-ios-trophy display-4 text-danger"></div>
              <div class="ml-3">
                <div class="text-muted small"><?php echo $this->lang->line('left_awards');?></div>
                <div class="text-large"><?php echo $this->Eumb_model->dash_total_awards_karyawan();?></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php  } ?>
    <?php if(in_array('46',$role_resources_ids)) { ?>
      <div class="col-sm-6 col-xl-3">
        <div class="card mb-4">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="ion ion-md-calendar display-4 text-warning"></div>
              <div class="ml-3">
                <div class="text-muted small"><?php echo $this->lang->line('umb_cuti_request');?></div>
                <div class="text-large"><?php echo karyawan_permintaan_cutii();?></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php  } ?>
  </div>
<?php  } ?>
<?php if(in_array('7',$role_resources_ids) || $user_info[0]->user_role_id==1) { ?>
  <div class="row">
    <?php if(in_array('7',$role_resources_ids)) { ?>
      <div class="col-xl-6 col-md-6 align-items-strdetch">
        <div class="card mb-4">
          <h6 class="card-header with-elements border-0 pr-0 pb-0">
            <div class="card-header-title"><?php echo $this->lang->line('left_shifts_kantor');?></div>
          </h6>
          <div class="row">
            <div class="col-md-6">
              <div class="overflow-scrolls py-4 px-3" style="overflow:auto; height:200px;">
                <div class="table-responsive">
                  <table class="table mb-0 table-dashboard">
                    <tbody>
                      <?php $c_color = array('#647c8a','#2196f3','#02bc77','#d3733b','#673AB7','#66456e','#b26fc2','#a98852','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e');?>
                      <?php $j=0;foreach(hrastral_shift_kantor() as $hr_shift_kantor) { ?>
                        <?php
                        $condition = "shift_kantor_id =" . "'" . $hr_shift_kantor->shift_kantor_id . "'";
                        $this->db->select('*');
                        $this->db->from('umb_karyawans');
                        $this->db->where($condition);
                        $query = $this->db->get();
                        $r_row = $query->num_rows();
                        ?>
                        <tr>
                          <td style="vertical-align: inherit;">
                            <div style="width:4px;border:5px solid <?php echo $c_color[$j];?>;"></div>
                          </td>
                          <td><?php echo htmlspecialchars_decode($hr_shift_kantor->nama_shift);?> (<?php echo $r_row;?>)</td>
                        </tr>
                        <?php $j++; 
                      } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div style="height:120px;">
                <canvas id="hrastral_shifts_kantor"  style="display: block; height: 150px; width:300px;"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php  } ?>
    <?php if($user_info[0]->user_role_id==1) { ?>
      <div class="col-xl-6 col-md-6 align-items-strdetch"> 
        <div class="card mb-4">
          <h6 class="card-header with-elements border-0 pr-0 pb-0">
            <div class="card-header-title"><?php echo $this->lang->line('umb_roles');?></div>
          </h6>
          <div class="row">
            <div class="col-md-6">
              <div class="overflow-scrolls py-4 px-3" style="overflow:auto; height:200px;">
                <div class="table-responsive">
                  <table class="table mb-0 table-dashboard">
                    <tbody>
                      <?php $c_color = array('#66456e','#b26fc2','#a98852','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e');?>
                      <?php $j=0;foreach(hrastral_roles() as $hr_roles) { ?>
                        <?php
                        $condition = "user_role_id =" . "'" . $hr_roles->role_id . "'";
                        $this->db->select('*');
                        $this->db->from('umb_karyawans');
                        $this->db->where($condition);
                        $query = $this->db->get();
                        $r_row = $query->num_rows();
                        ?>
                        <tr>
                          <td style="vertical-align: inherit;">
                            <div style="width:4px;border:5px solid <?php echo $c_color[$j];?>;"></div>
                          </td>
                          <td><?php echo htmlspecialchars_decode($hr_roles->role_name);?> (<?php echo $r_row;?>)</td>
                        </tr>
                        <?php $j++; 
                      } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div style="height:120px;">
                <canvas id="hrastral_roles"  style="display: block; height: 150px; width:300px;"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php  } ?>
  </div>
<?php  } ?>
<?php if(in_array('13',$role_resources_ids) || in_array('13',$role_resources_ids) || in_array('44',$role_resources_ids) || in_array('45',$role_resources_ids)) { ?>
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
    <div class="d-flex col-xl-12 align-items-stretch"> 
      <div class="card d-flex w-100 mb-4">
        <div class="row no-gutters row-bordered h-100">
          <?php if(in_array('13',$role_resources_ids)) { ?>
            <div class="d-flex col-sm-6 col-md-3 col-lg-3 align-items-center"> 
              <a href="javascript:void(0)" class="card-body media align-items-center text-body"> 
                <i class="ion ion-md-close display-4 d-block text-primary"></i> 
                <span class="media-body d-block ml-3"> 
                  <span class="text-big font-weight-bolder"><?php echo $this->Umb_model->set_percentage($krywn_abs);?>%</span><br>
                  <small class="text-muted"><?php echo $this->lang->line('umb_hrastral_absent_today');?></small> 
                </span> 
              </a> 
            </div>
          <?php  } ?>
          <?php if(in_array('13',$role_resources_ids)) { ?>
            <div class="d-flex col-sm-6 col-md-3 col-lg-3 align-items-center"> 
              <a href="javascript:void(0)" class="card-body media align-items-center text-body"> 
                <i class="ion ion-md-checkbox-outline display-4 d-block text-primary"></i> 
                <span class="media-body d-block ml-3"> 
                  <span class="text-big font-weight-bolder"><?php echo $this->Umb_model->set_percentage($krywn_kerja);?>%</span><br>
                  <small class="text-muted"><?php echo $this->lang->line('umb_hrastral_present_today');?></small> 
                </span> 
              </a> 
            </div>
          <?php  } ?>
          <?php if(in_array('44',$role_resources_ids)) { ?>
            <div class="d-flex col-sm-6 col-md-3 col-lg-3 align-items-center">
              <?php $completed_proj = $this->Project_model->complete_projects();?>
              <?php $proj = $this->Umb_model->get_all_projects();
              if($proj < 1) {
                $proj_percnt = 0;
              } else {
                $proj_percnt = $completed_proj / $proj * 100;
              }
              ?>
              <a href="javascript:void(0)" class="card-body media align-items-center text-body"> 
                <i class="ion ion-logo-buffer display-4 d-block text-primary"></i> 
                <span class="media-body d-block ml-3"> 
                  <span class="text-big font-weight-bolder"><?php echo $this->Umb_model->set_percentage($proj_percnt);?>%</span><br>
                  <small class="text-muted"><?php echo $this->lang->line('umb_hrastral_project_status');?></small> 
                </span> 
              </a> 
            </div>
          <?php  } ?>
          <?php if(in_array('45',$role_resources_ids)) { ?>
            <div class="d-flex col-sm-6 col-md-3 col-lg-3 align-items-center">
              <?php $completed_tugass = completed_tugass();?>
              <?php $tugas_all = $this->Umb_model->get_all_tugass();
              if($tugas_all < 1) {
                $tugas_percnt = 0;
              } else {
                $tugas_percnt = $completed_tugass / $tugas_all * 100;
              }
              ?>
              <a href="javascript:void(0)" class="card-body media align-items-center text-body"> 
                <i class="lnr lnr-database display-4 d-block text-primary"></i> 
                <span class="media-body d-block ml-3"> 
                  <span class="text-big font-weight-bolder"><?php echo $this->Umb_model->set_percentage($tugas_percnt);?>%</span><br>
                  <small class="text-muted"><?php echo $this->lang->line('umb_hrastral_status_tugas');?></small> 
                </span> 
              </a> 
            </div>
          <?php  } ?>
        </div>
      </div>
    </div>
  </div>
<?php  } ?>
<?php if(in_array('13',$role_resources_ids)) { ?>
  <div class="row">
    <?php if(in_array('13',$role_resources_ids)) { ?>
      <div class="col-md-6">
        <div class="card mb-4">
          <h6 class="card-header with-elements border-0 pr-0 pb-0">
            <div class="card-header-title"><?php echo $this->lang->line('umb_location_karyawan_txt');?></div>
          </h6>
          <div class="row">
            <div class="col-md-6">
              <div class="overflow-scrolls py-4 px-3" style="overflow:auto; height:200px;">
                <div class="table-responsive">
                  <table class="table mb-0 table-dashboard">
                    <tbody>
                      <?php $c_color3 = array('#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b');?>
                      <?php $lj=0;foreach($this->Umb_model->all_locations() as $location) { ?>
                        <?php
                        $lcondition = "location_id =" . "'" . $location->location_id . "'";
                        $this->db->select('*');
                        $this->db->from('umb_karyawans');
                        $this->db->where($lcondition);
                        $lquery = $this->db->get();
                        if ($lquery->num_rows() > 0) {
                         ?>
                         <tr>
                          <td style="vertical-align: inherit;">
                            <div style="width:4px;border:5px solid <?php echo $c_color3[$lj];?>;"></div>
                          </td>
                          <td><?php echo htmlspecialchars_decode($location->nama_location);?> (<?php echo $lquery->num_rows();?>)</td>
                        </tr>
                        <?php $lj++; 
                      } ?>
                    <?php  } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="col-md-5">
            <div style="height:120px;">
              <canvas id="location_karyawan"  style="display: block; height: 150px; width:300px;"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php  } ?>
  <?php if(in_array('13',$role_resources_ids)) { ?>
    <div class="col-md-6">
      <div class="card mb-4">
        <h6 class="card-header with-elements border-0 pr-0 pb-0">
          <div class="card-header-title"><?php echo $this->lang->line('umb_karyawan_perusahaan_txt');?></div>
        </h6>
        <div class="row">
          <div class="col-md-6">
            <div class="overflow-scrolls" style="overflow:auto; height:200px;">
              <div class="table-responsive">
                <table class="table mb-0 table-dashboard">
                  <tbody>
                    <?php $c_color4 = array('#975df3','#001f3f','#39cccc','#3c8dbc','#006400','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b');?>
                    <?php $ck=0;foreach($this->Umb_model->dash_all_perusahaans() as $eperusahaan) { ?>
                      <?php
                      $conditione = "perusahaan_id =" . "'" . $eperusahaan->perusahaan_id . "'";
                      $this->db->select('*');
                      $this->db->from('umb_karyawans');
                      $this->db->where($conditione);
                      $cquery1 = $this->db->get();
                      if ($cquery1->num_rows() > 0) {
                       ?>
                       <tr>
                        <td style="vertical-align: inherit;">
                          <div style="width:4px;border:5px solid <?php echo $c_color4[$ck];?>;"></div>
                        </td>
                        <td><?php echo htmlspecialchars_decode($eperusahaan->name);?> (<?php echo $cquery1->num_rows();?>)</td>
                      </tr>
                      <?php $ck++; 
                    } ?>
                  <?php  } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-md-5">
          <div style="height:120px;">
            <canvas id="karyawan_perusahaan" style="display: block; height: 150px; width:300px;"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php  } ?>
</div>
<?php  } ?>
