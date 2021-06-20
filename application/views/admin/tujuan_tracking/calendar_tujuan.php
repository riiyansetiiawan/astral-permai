<?php $system = $this->Umb_model->read_setting_info(1); ?>
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title"><?php echo $this->lang->line('umb_hr_calendar_options');?></h4>
        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
        <div class="heading-elements">
          <ul class="list-inline mb-0">
            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
          </ul>
        </div>
      </div>
      <div class="card-body collapse in">
        <div class="card-block">
          <div class="row">
            <div class="col-md-3">
              <div class="row">
                <div class="col-md-12">
                  <div id='external-events'>
                    <div class="fc-events-container">
                      <div class='fc-event' data-color='#48CFAE'><?php echo $this->lang->line('umb_hr_completed_tujuans');?></div>
                      <div class='fc-event' data-color='#F6BB42'><?php echo $this->lang->line('umb_hr_inprogress_tujuans');?></div>
                      <div class='fc-event' data-color='#ED5564'><?php echo $this->lang->line('umb_hr_not_started_tujuans');?></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="card">
                  <div class="card-body">
                    <div class="card-block">
                      <form class="add form-hrm" method="post" name="calendar_date" action="">
                        <div class="form-body">
                          <div class="form-group">
                            <label for="tanggal_kehadiran" class=""><?php echo $this->lang->line('umb_hr_event_month_year');?></label>
                            <input class="form-control event_date" placeholder="<?php echo $this->lang->line('umb_select_date');?>" readonly id="calendar_tanggal_tujuan" name="calendar_tanggal_tujuan" type="text" value="<?php if(isset($_POST['calendar_tanggal_tujuan'])){ echo $_POST['calendar_tanggal_tujuan']; } else { echo date('Y-m'); }?>">
                          </div>
                        </div>
                        <div class="form-actions right">
                          <button type="submit" class="btn btn-primary save"><?php echo $this->lang->line('umb_hr_get_event');?></button>
                        </div>
                      <?php echo form_close(); ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-9">
              <div id='calendar_hr'></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
