<?php

defined('BASEPATH') OR exit('No direct script access allowed');

if(isset($_GET['jd']) && isset($_GET['performance_appraisal_id']) && $_GET['data']=='appraisal'){

  ?>



  <div class="modal-header">

    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>

    <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_edit_performance_appraisal');?></h4>

  </div>

  <?php $attributes = array('name' => 'edit_appraisal', 'id' => 'edit_appraisal', 'autocomplete' => 'off', 'class'=>'m-b-1');?>

  <?php $hidden = array('_method' => 'EDIT', '_token' => $performance_appraisal_id, 'ext_name' => $performance_appraisal_id);?>

  <?php echo form_open('admin/performance_appraisal/update/'.$performance_appraisal_id, $attributes, $hidden);?>

  <div class="modal-body">

    <div class="row m-b-1">

      <div class="col-md-12">

        <div class="box box-block bg-white">

          <div class="row">

            <div class="col-md-12">

              <div class="row">

                <div class="col-md-3 control-label">

                  <div class="form-group">

                    <label for="karyawan"><?php echo $this->lang->line('left_perusahaan');?></label>

                  </div>

                </div>

                <div class="col-md-5">

                  <div class="form-group">

                    <select class="form-control" name="perusahaan_id" id="ajx_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_perusahaan');?>">

                      <option value=""></option>

                      <?php foreach($get_all_perusahaans as $perusahaan) {?>

                        <option value="<?php echo $perusahaan->perusahaan_id?>" <?php if($perusahaan_id==$perusahaan->perusahaan_id):?> selected="selected" <?php endif;?>><?php echo $perusahaan->name?></option>

                      <?php } ?>

                    </select>

                  </div>

                </div>

              </div>

              <div class="row">

                <div class="col-md-3 control-label">

                  <div class="form-group">

                    <label for="karyawan"><?php echo $this->lang->line('dashboard_single_karyawan');?></label>

                    <input type="hidden" name="krywn_id" value="<?php echo $karyawan_id;?>">

                    <input type="hidden" name="cur_date" value="<?php echo $appraisal_year_month;?>">

                  </div>

                </div>

                <div class="col-md-5">

                  <div class="form-group" id="ajx_karyawan">

                   <?php $result = $this->Department_model->ajax_info_perusahaan_karyawan($perusahaan_id);?>

                   <select class="select2" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_choose_an_karyawan');?>" name="karyawan_id" id="karyawan_id">

                    <option value=""></option>

                    <?php foreach($result as $karyawan) {?>

                      <option value="<?php echo $karyawan->user_id;?>" <?php if($karyawan_id==$karyawan->user_id):?> selected="selected" <?php endif;?>><?php echo $karyawan->first_name.' '.$karyawan->last_name;?></option>

                    <?php } ?>

                  </select>

                </div>

              </div>

            </div>

            <div class="row">

              <div class="col-md-3 control-label">

                <div class="form-group">

                  <label for="month_year"><?php echo $this->lang->line('umb_select_month');?></label>

                </div>

              </div>

              <div class="col-md-5">

                <div class="form-group">

                  <input class="form-control e_month_year" placeholder="<?php echo $this->lang->line('umb_select_month');?>" readonly id="month_year" name="month_year" type="text" value="<?php echo $appraisal_year_month;?>">

                </div>

              </div>

            </div>

          </div>

        </div>

      </div>

      <div class="row m-b-1">

        <div class="col-md-6">

          <div class="box bg-white">

            <table class="table table-grey-head m-md-b-0">

              <thead>

                <tr>

                  <th colspan="5"><?php echo $this->lang->line('umb_performance_technical_competencies');?></th>

                </tr>

              </thead>

              <tbody>

                <tr>

                  <th colspan="2"><?php echo $this->lang->line('umb_indicator');?></th>

                  <th colspan="2"><?php echo $this->lang->line('umb_expected_value');?></th>

                  <th><?php echo $this->lang->line('umb_set_value');?></th>

                </tr>

                <tr>

                  <td scope="row" colspan="2"><?php echo $this->lang->line('umb_performance_customer_pengalaman');?></td>

                  <td colspan="2"><?php echo $this->lang->line('umb_performance_intermediate');?></td>

                  <td><select name="customer_pengalaman" class="form-control">

                    <option value=""><?php echo $this->lang->line('umb_performance_none');?></option>

                    <option value="1" <?php if($customer_pengalaman=='1'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('umb_performance_beginner');?></option>

                    <option value="2" <?php if($customer_pengalaman=='2'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('umb_performance_intermediate');?></option>

                    <option value="3" <?php if($customer_pengalaman=='3'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('umb_performance_advanced');?></option>

                    <option value="4" <?php if($customer_pengalaman=='4'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('umb_performance_expert');?></option>

                  </select></td>

                </tr>

                <tr>

                  <td scope="row" colspan="2"><?php echo $this->lang->line('umb_performance_marketing');?></td>

                  <td colspan="2"><?php echo $this->lang->line('umb_performance_advanced');?></td>

                  <td><select name="marketing" class="form-control">

                    <option value=""><?php echo $this->lang->line('umb_performance_none');?></option>

                    <option value="1" <?php if($marketing=='1'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('umb_performance_beginner');?></option>

                    <option value="2" <?php if($marketing=='2'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('umb_performance_intermediate');?></option>

                    <option value="3" <?php if($marketing=='3'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('umb_performance_advanced');?></option>

                    <option value="4" <?php if($marketing=='4'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('umb_performance_expert');?></option>

                  </select></td>

                </tr>

                <tr>

                  <td scope="row" colspan="2"><?php echo $this->lang->line('umb_performance_management');?></td>

                  <td colspan="2"><?php echo $this->lang->line('umb_performance_advanced');?></td>

                  <td><select name="management" class="form-control">

                    <option value=""><?php echo $this->lang->line('umb_performance_none');?></option>

                    <option value="1" <?php if($management=='1'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('umb_performance_beginner');?></option>

                    <option value="2" <?php if($management=='2'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('umb_performance_intermediate');?></option>

                    <option value="3" <?php if($management=='3'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('umb_performance_advanced');?></option>

                    <option value="4" <?php if($management=='4'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('umb_performance_expert');?></option>

                  </select></td>

                </tr>

                <tr>

                  <td scope="row" colspan="2"><?php echo $this->lang->line('umb_performance_administration');?></td>

                  <td colspan="2"><?php echo $this->lang->line('umb_performance_advanced');?></td>

                  <td><select name="administration" class="form-control">

                    <option value=""><?php echo $this->lang->line('umb_performance_none');?></option>

                    <option value="1" <?php if($administration=='1'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('umb_performance_beginner');?></option>

                    <option value="2" <?php if($administration=='2'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('umb_performance_intermediate');?></option>

                    <option value="3" <?php if($administration=='3'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('umb_performance_advanced');?></option>

                    <option value="4" <?php if($administration=='4'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('umb_performance_expert');?></option>

                  </select></td>

                </tr>

                <tr>

                  <td scope="row" colspan="2"><?php echo $this->lang->line('umb_performance_present_skill');?></td>

                  <td colspan="2"><?php echo $this->lang->line('umb_performance_expert');?></td>

                  <td><select name="presentation_skill" class="form-control">

                    <option value=""><?php echo $this->lang->line('umb_performance_none');?></option>

                    <option value="1" <?php if($presentation_skill=='1'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('umb_performance_beginner');?></option>

                    <option value="2" <?php if($presentation_skill=='2'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('umb_performance_intermediate');?></option>

                    <option value="3" <?php if($presentation_skill=='3'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('umb_performance_advanced');?></option>

                    <option value="4" <?php if($presentation_skill=='4'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('umb_performance_expert');?></option>

                  </select></td>

                </tr>

                <tr>

                  <td scope="row" colspan="2"><?php echo $this->lang->line('umb_performance_quality_work');?></td>

                  <td colspan="2"><?php echo $this->lang->line('umb_performance_expert');?></td>

                  <td><select name="quality_of_work" class="form-control">

                    <option value=""><?php echo $this->lang->line('umb_performance_none');?></option>

                    <option value="1" <?php if($quality_of_work=='1'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('umb_performance_beginner');?></option>

                    <option value="2" <?php if($quality_of_work=='2'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('umb_performance_intermediate');?></option>

                    <option value="3" <?php if($quality_of_work=='3'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('umb_performance_advanced');?></option>

                    <option value="4" <?php if($quality_of_work=='4'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('umb_performance_expert');?></option>

                  </select></td>

                </tr>

                <tr>

                  <td scope="row" colspan="2"><?php echo $this->lang->line('umb_performance_efficiency');?></td>

                  <td colspan="2"><?php echo $this->lang->line('umb_performance_expert');?></td>

                  <td><select name="efficiency" class="form-control">

                    <option value=""><?php echo $this->lang->line('umb_performance_none');?></option>

                    <option value="1" <?php if($efficiency=='1'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('umb_performance_beginner');?></option>

                    <option value="2" <?php if($efficiency=='2'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('umb_performance_intermediate');?></option>

                    <option value="3" <?php if($efficiency=='3'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('umb_performance_advanced');?></option>

                    <option value="4" <?php if($efficiency=='4'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('umb_performance_expert');?></option>

                  </select></td>

                </tr>

              </tbody>

            </table>

          </div>

        </div>

        <div class="col-md-6">

          <div class="box bg-white">

            <table class="table table-grey-head m-md-b-0">

              <thead>

                <tr>

                  <th colspan="5"><?php echo $this->lang->line('umb_performance_behv_technical_competencies');?></th>

                </tr>

              </thead>

              <tbody>

                <tr>

                  <th colspan="2"><?php echo $this->lang->line('umb_indicator');?></th>

                  <th colspan="2"><?php echo $this->lang->line('umb_expected_value');?></th>

                  <th><?php echo $this->lang->line('umb_set_value');?></th>

                </tr>

                <tr>

                  <td scope="row" colspan="2"><?php echo $this->lang->line('umb_performance_integrity');?></td>

                  <td colspan="2"><?php echo $this->lang->line('umb_performance_beginner');?></td>

                  <td><select name="integrity" class="form-control">

                    <option value=""><?php echo $this->lang->line('umb_performance_none');?></option>

                    <option value="1" <?php if($integrity=='1'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('umb_performance_beginner');?></option>

                    <option value="2" <?php if($integrity=='2'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('umb_performance_intermediate');?></option>

                    <option value="3" <?php if($integrity=='3'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('umb_performance_advanced');?></option>

                  </select></td>

                </tr>

                <tr>

                  <td scope="row" colspan="2"><?php echo $this->lang->line('umb_performance_professionalism');?></td>

                  <td colspan="2"><?php echo $this->lang->line('umb_performance_beginner');?></td>

                  <td><select name="professionalism" class="form-control">

                    <option value=""><?php echo $this->lang->line('umb_performance_none');?></option>

                    <option value="1" <?php if($professionalism=='1'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('umb_performance_beginner');?></option>

                    <option value="2" <?php if($professionalism=='2'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('umb_performance_intermediate');?></option>

                    <option value="3" <?php if($professionalism=='3'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('umb_performance_advanced');?></option>

                  </select></td>

                </tr>

                <tr>

                  <td scope="row" colspan="2"><?php echo $this->lang->line('umb_performance_team_work');?></td>

                  <td colspan="2"><?php echo $this->lang->line('umb_performance_intermediate');?></td>

                  <td><select name="team_work" class="form-control">

                    <option value=""><?php echo $this->lang->line('umb_performance_none');?></option>

                    <option value="1" <?php if($team_work=='1'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('umb_performance_beginner');?></option>

                    <option value="2" <?php if($team_work=='2'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('umb_performance_intermediate');?></option>

                    <option value="3" <?php if($team_work=='3'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('umb_performance_advanced');?></option>

                  </select></td>

                </tr>

                <tr>

                  <td scope="row" colspan="2"><?php echo $this->lang->line('umb_performance_critical_think');?></td>

                  <td colspan="2"><?php echo $this->lang->line('umb_performance_advanced');?></td>

                  <td><select name="critical_thinking" class="form-control">

                    <option value=""><?php echo $this->lang->line('umb_performance_none');?></option>

                    <option value="1" <?php if($critical_thinking=='1'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('umb_performance_beginner');?></option>

                    <option value="2" <?php if($critical_thinking=='2'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('umb_performance_intermediate');?></option>

                    <option value="3" <?php if($critical_thinking=='3'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('umb_performance_advanced');?></option>

                  </select></td>

                </tr>

                <tr>

                  <td scope="row" colspan="2"><?php echo $this->lang->line('umb_performance_conflict_manage');?></td>

                  <td colspan="2"><?php echo $this->lang->line('umb_performance_intermediate');?></td>

                  <td><select name="conflict_management" class="form-control">

                    <option value=""><?php echo $this->lang->line('umb_performance_none');?></option>

                    <option value="1" <?php if($conflict_management=='1'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('umb_performance_beginner');?></option>

                    <option value="2" <?php if($conflict_management=='2'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('umb_performance_intermediate');?></option>

                    <option value="3" <?php if($conflict_management=='3'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('umb_performance_advanced');?></option>

                  </select></td>

                </tr>

                <tr>

                  <td scope="row" colspan="2"><?php echo $this->lang->line('umb_performance_kehadiran');?></td>

                  <td colspan="2"><?php echo $this->lang->line('umb_performance_intermediate');?></td>

                  <td><select name="kehadiran" class="form-control">

                    <option value=""><?php echo $this->lang->line('umb_performance_none');?></option>

                    <option value="1" <?php if($kehadiran=='1'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('umb_performance_beginner');?></option>

                    <option value="2" <?php if($kehadiran=='2'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('umb_performance_intermediate');?></option>

                    <option value="3" <?php if($kehadiran=='3'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('umb_performance_advanced');?></option>

                  </select></td>

                </tr>

                <tr>

                  <td scope="row" colspan="2"><?php echo $this->lang->line('umb_performance_meet_deadline');?></td>

                  <td colspan="2"><?php echo $this->lang->line('umb_performance_advanced');?></td>

                  <td><select name="ability_to_meet_deadline" class="form-control">

                    <option value=""><?php echo $this->lang->line('umb_performance_none');?></option>

                    <option value="1" <?php if($ability_to_meet_deadline=='1'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('umb_performance_beginner');?></option>

                    <option value="2" <?php if($ability_to_meet_deadline=='2'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('umb_performance_intermediate');?></option>

                    <option value="3" <?php if($ability_to_meet_deadline=='3'):?> selected="selected" <?php endif;?>> <?php echo $this->lang->line('umb_performance_advanced');?></option>

                  </select></td>

                </tr>

              </tbody>

            </table>

          </div>

        </div>

      </div>

    </div>

    <div class="m-b-1">

      <div class="col-md-12">

        <div class="box box-block bg-white">

          <div class="form-group">

            <label for="remarks"><?php echo $this->lang->line('umb_keterangan');?></label>

            <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('umb_keterangan');?>" name="remarks" cols="30" rows="15" id="remarks2"><?php echo $remarks;?></textarea>

          </div>

        </div>

      </div>

    </div>

  </div>

</div>

<div class="modal-footer">

  <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('umb_close');?></button>

  <button type="submit" class="btn btn-primary"><?php echo $this->lang->line('umb_update');?></button>

</div>

<?php echo form_close(); ?>

<script type="text/javascript">

 $(document).ready(function(){

  

		// Month & Year

		$('.e_month_year').datepicker({

      changeMonth: true,

      changeYear: true,

      showButtonPanel: true,

      dateFormat:'yy-mm',

      yearRange: '1970:' + new Date().getFullYear(),

      beforeShow: function(input) {

       $(input).datepicker("widget").addClass('hide-calendar');

     },

     onClose: function(dateText, inst) {

       var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();

       var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();

       $(this).datepicker('setDate', new Date(year, month, 1));

       $(this).datepicker('widget').removeClass('hide-calendar');

       $(this).datepicker('widget').hide();

     }

     

   });

		

		$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));

		$('[data-plugin="select_hrm"]').select2({ width:'100%' });	

		jQuery("#ajx_perusahaan").change(function(){

			jQuery.get(base_url+"/get_karyawans/"+jQuery(this).val(), function(data, status){

				jQuery('#ajx_karyawan').html(data);

			});

		});

		$('#remarks2').trumbowyg();

		

		/* Edit data */

		$("#edit_appraisal").submit(function(e){

      e.preventDefault();

      var obj = $(this), action = obj.attr('name');

      $('.save').prop('disabled', true);

      

      $.ajax({

        type: "POST",

        url: e.target.action,

        data: obj.serialize()+"&is_ajax=1&edit_type=appraisal&form="+action,

        cache: false,

        success: function (JSON) {

         if (JSON.error != '') {

          toastr.error(JSON.error);

          $('.save').prop('disabled', false);

        } else {

						// On page load: datatable

						var umb_table = $('#umb_table').dataTable({

              "bDestroy": true,

              "ajax": {

               url : "<?php echo site_url("admin/performance_appraisal/list_appraisal") ?>",

               type : 'GET'

             },

             dom: 'lBfrtip',

             "buttons": ['csv', 'excel', 'pdf', 'print'], 

             "fnDrawCallback": function(settings){

              $('[data-toggle="tooltip"]').tooltip();          

            }

          });

						umb_table.api().ajax.reload(function(){ 

							toastr.success(JSON.result);

						}, true);

						$('.edit-modal-data').modal('toggle');

						$('.save').prop('disabled', false);

					}

				}

			});

    });

	});	

</script>

<?php } else if(isset($_GET['jd']) && isset($_GET['performance_appraisal_id']) && $_GET['data']=='view_appraisal' && $_GET['type']=='view_appraisal'){

  ?>

  <div class="modal-header">

    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>

    <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_view_performance_appraisal');?></h4>

  </div>

  <div class="modal-body">

    <div class="row m-b-1">

      <div class="col-md-12">

        <div class="box box-block bg-white">

          <div class="row">

            <div class="col-md-12">

              <div class="row">

                <div class="col-md-3 control-label">

                  <div class="form-group">

                    <label for="karyawan"><?php echo $this->lang->line('left_perusahaan');?>: </label>

                  </div>

                </div>

                <div class="col-md-5">

                  <div class="form-group">

                    <?php foreach($get_all_perusahaans as $perusahaan) {?>

                      <?php if($perusahaan_id==$perusahaan->perusahaan_id):?>

                        <?php echo $perusahaan->name;?>

                      <?php endif;?>

                    <?php } ?>

                  </div>

                </div>

              </div>

              <div class="row">

                <div class="col-md-3 control-label">

                  <div class="form-group">

                    <label for="karyawan"><?php echo $this->lang->line('dashboard_single_karyawan');?>: </label>

                  </div>

                </div>

                <div class="col-md-5">

                  <div class="form-group">

                    <?php foreach($all_karyawans as $karyawan) {?>

                      <?php if($karyawan_id==$karyawan->user_id):?>

                        <?php echo $karyawan->first_name.' '.$karyawan->last_name;?>

                      <?php endif; } ?>

                    </div>

                  </div>

                </div>

                <div class="row">

                  <div class="col-md-3 control-label">

                    <div class="form-group">

                      <label for="month_year"><?php echo $this->lang->line('umb_performance_app_date');?>: </label>

                    </div>

                  </div>

                  <div class="col-md-5">

                    <div class="form-group"> <?php echo date("F, Y", strtotime($appraisal_year_month));?> </div>

                  </div>

                </div>

              </div>

            </div>

          </div>

          <div class="row m-b-1">

            <div class="col-md-6">

              <div class="box bg-white">

                <div class="table-responsive" data-pattern="priority-columns">

                  <table class="table table-grey-head m-md-b-0">

                    <thead>

                      <tr>

                        <th colspan="5"><?php echo $this->lang->line('umb_performance_behv_technical_competencies');?></th>

                      </tr>

                    </thead>

                    <tbody>

                      <tr>

                        <th colspan="2"><?php echo $this->lang->line('umb_indicator');?></th>

                        <th colspan="2"><?php echo $this->lang->line('umb_expected_value');?></th>

                        <th><?php echo $this->lang->line('umb_set_value');?></th>

                      </tr>

                      <tr>

                        <td scope="row" colspan="2"><?php echo $this->lang->line('umb_performance_customer_pengalaman');?></td>

                        <td colspan="2"><?php echo $this->lang->line('umb_performance_intermediate');?></td>

                        <td><?php if($customer_pengalaman=='1'):?>

                        <?php echo $this->lang->line('umb_performance_beginner');?>

                        <?php elseif($customer_pengalaman=='2'):?>

                          <?php echo $this->lang->line('umb_performance_intermediate');?>

                          <?php elseif($customer_pengalaman=='3'):?>

                            <?php echo $this->lang->line('umb_performance_advanced');?>

                            <?php elseif($customer_pengalaman=='4'):?>

                              <?php echo $this->lang->line('umb_performance_expert');?>

                              <?php else:?>

                                <span style="color:red;font - style: italic;line - height:2.4;"> <?php echo $this->lang->line('umb_not_set_value');?> </span>

                                <?php endif;?></td>

                              </tr>

                              <tr>

                                <td scope="row" colspan="2"><?php echo $this->lang->line('umb_performance_marketing');?></td>

                                <td colspan="2"><?php echo $this->lang->line('umb_performance_advanced');?></td>

                                <td><?php if($marketing=='1'):?>

                                <?php echo $this->lang->line('umb_performance_beginner');?>

                                <?php elseif($marketing=='2'):?>

                                  <?php echo $this->lang->line('umb_performance_intermediate');?>

                                  <?php elseif($marketing=='3'):?>

                                    <?php echo $this->lang->line('umb_performance_advanced');?>

                                    <?php elseif($marketing=='4'):?>

                                      <?php echo $this->lang->line('umb_performance_expert');?>

                                      <?php else:?>

                                        <span style="color:red;font - style: italic;line - height:2.4;"> <?php echo $this->lang->line('umb_not_set_value');?> </span>

                                        <?php endif;?></td>

                                      </tr>

                                      <tr>

                                        <td scope="row" colspan="2"><?php echo $this->lang->line('umb_performance_management');?></td>

                                        <td colspan="2"><?php echo $this->lang->line('umb_performance_advanced');?></td>

                                        <td><?php if($management=='1'):?>

                                        <?php echo $this->lang->line('umb_performance_beginner');?>

                                        <?php elseif($management=='2'):?>

                                          <?php echo $this->lang->line('umb_performance_intermediate');?>

                                          <?php elseif($management=='3'):?>

                                            <?php echo $this->lang->line('umb_performance_advanced');?>

                                            <?php elseif($management=='4'):?>

                                              <?php echo $this->lang->line('umb_performance_expert');?>

                                              <?php else:?>

                                                <span style="color:red;font - style: italic;line - height:2.4;"> <?php echo $this->lang->line('umb_not_set_value');?> </span>

                                                <?php endif;?></td>

                                              </tr>

                                              <tr>

                                                <td scope="row" colspan="2"><?php echo $this->lang->line('umb_performance_administration');?></td>

                                                <td colspan="2"><?php echo $this->lang->line('umb_performance_advanced');?></td>

                                                <td><?php if($administration=='1'):?>

                                                <?php echo $this->lang->line('umb_performance_beginner');?>

                                                <?php elseif($administration=='2'):?>

                                                  <?php echo $this->lang->line('umb_performance_intermediate');?>

                                                  <?php elseif($administration=='3'):?>

                                                    <?php echo $this->lang->line('umb_performance_advanced');?>

                                                    <?php elseif($administration=='4'):?>

                                                      <?php echo $this->lang->line('umb_performance_expert');?>

                                                      <?php else:?>

                                                        <span style="color:red;font - style: italic;line - height:2.4;"> <?php echo $this->lang->line('umb_not_set_value');?> </span>

                                                        <?php endif;?></td>

                                                      </tr>

                                                      <tr>

                                                        <td scope="row" colspan="2"><?php echo $this->lang->line('umb_performance_present_skill');?></td>

                                                        <td colspan="2"><?php echo $this->lang->line('umb_performance_expert');?></td>

                                                        <td><?php if($presentation_skill=='1'):?>

                                                        <?php echo $this->lang->line('umb_performance_beginner');?>

                                                        <?php elseif($presentation_skill=='2'):?>

                                                          <?php echo $this->lang->line('umb_performance_intermediate');?>

                                                          <?php elseif($presentation_skill=='3'):?>

                                                            <?php echo $this->lang->line('umb_performance_advanced');?>

                                                            <?php elseif($presentation_skill=='4'):?>

                                                              <?php echo $this->lang->line('umb_performance_expert');?>

                                                              <?php else:?>

                                                                <span style="color:red;font - style: italic;line - height:2.4;"> <?php echo $this->lang->line('umb_not_set_value');?> </span>

                                                                <?php endif;?></td>

                                                              </tr>

                                                              <tr>

                                                                <td scope="row" colspan="2"><?php echo $this->lang->line('umb_performance_quality_work');?></td>

                                                                <td colspan="2"><?php echo $this->lang->line('umb_performance_expert');?></td>

                                                                <td><?php if($quality_of_work=='1'):?>

                                                                <?php echo $this->lang->line('umb_performance_beginner');?>

                                                                <?php elseif($quality_of_work=='2'):?>

                                                                  <?php echo $this->lang->line('umb_performance_intermediate');?>

                                                                  <?php elseif($quality_of_work=='3'):?>

                                                                    <?php echo $this->lang->line('umb_performance_advanced');?>

                                                                    <?php elseif($quality_of_work=='4'):?>

                                                                      <?php echo $this->lang->line('umb_performance_expert');?>

                                                                      <?php else:?>

                                                                        <span style="color:red;font - style: italic;line - height:2.4;"> <?php echo $this->lang->line('umb_not_set_value');?> </span>

                                                                        <?php endif;?></td>

                                                                      </tr>

                                                                      <tr>

                                                                        <td scope="row" colspan="2"><?php echo $this->lang->line('umb_performance_efficiency');?></td>

                                                                        <td colspan="2"><?php echo $this->lang->line('umb_performance_expert');?></td>

                                                                        <td><?php if($efficiency=='1'):?>

                                                                        <?php echo $this->lang->line('umb_performance_beginner');?>

                                                                        <?php elseif($efficiency=='2'):?>

                                                                          <?php echo $this->lang->line('umb_performance_intermediate');?>

                                                                          <?php elseif($efficiency=='3'):?>

                                                                            <?php echo $this->lang->line('umb_performance_advanced');?>

                                                                            <?php elseif($efficiency=='4'):?>

                                                                              <?php echo $this->lang->line('umb_performance_expert');?>

                                                                              <?php else:?>

                                                                                <span style="color:red;font - style: italic;line - height:2.4;"> <?php echo $this->lang->line('umb_not_set_value');?> </span>

                                                                                <?php endif;?></td>

                                                                              </tr>

                                                                            </tbody>

                                                                          </table>

                                                                        </div>

                                                                      </div>

                                                                    </div>

                                                                    <div class="col-md-6">

                                                                      <div class="box bg-white">

                                                                        <div class="table-responsive" data-pattern="priority-columns">

                                                                          <table class="table table-grey-head m-md-b-0">

                                                                            <thead>

                                                                              <tr>

                                                                                <th colspan="5"><?php echo $this->lang->line('umb_performance_behv_technical_competencies');?></th>

                                                                              </tr>

                                                                            </thead>

                                                                            <tbody>

                                                                              <tr>

                                                                                <th colspan="2"><?php echo $this->lang->line('umb_indicator');?></th>

                                                                                <th colspan="2"><?php echo $this->lang->line('umb_expected_value');?></th>

                                                                                <th><?php echo $this->lang->line('umb_set_value');?></th>

                                                                              </tr>

                                                                              <tr>

                                                                                <td scope="row" colspan="2"><?php echo $this->lang->line('umb_performance_integrity');?></td>

                                                                                <td colspan="2"><?php echo $this->lang->line('umb_performance_beginner');?></td>

                                                                                <td><?php if($integrity=='1'):?>

                                                                                <?php echo $this->lang->line('umb_performance_beginner');?>

                                                                                <?php elseif($integrity=='2'):?>

                                                                                  <?php echo $this->lang->line('umb_performance_intermediate');?>

                                                                                  <?php elseif($integrity=='3'):?>

                                                                                    <?php echo $this->lang->line('umb_performance_advanced');?>

                                                                                    <?php else:?>

                                                                                      <span style="color:red;font - style: italic;line - height:2.4;"><?php echo $this->lang->line('umb_not_set_value');?></span>

                                                                                      <?php endif;?></td>

                                                                                    </tr>

                                                                                    <tr>

                                                                                      <td scope="row" colspan="2"><?php echo $this->lang->line('umb_performance_professionalism');?></td>

                                                                                      <td colspan="2"><?php echo $this->lang->line('umb_performance_beginner');?></td>

                                                                                      <td><?php if($professionalism=='1'):?>

                                                                                      <?php echo $this->lang->line('umb_performance_beginner');?>

                                                                                      <?php elseif($professionalism=='2'):?>

                                                                                        <?php echo $this->lang->line('umb_performance_intermediate');?>

                                                                                        <?php elseif($professionalism=='3'):?>

                                                                                          <?php echo $this->lang->line('umb_performance_advanced');?>

                                                                                          <?php else:?>

                                                                                            <span style="color:red;font - style: italic;line - height:2.4;"><?php echo $this->lang->line('umb_not_set_value');?></span>

                                                                                            <?php endif;?></td>

                                                                                          </tr>

                                                                                          <tr>

                                                                                            <td scope="row" colspan="2"><?php echo $this->lang->line('umb_performance_team_work');?></td>

                                                                                            <td colspan="2"><?php echo $this->lang->line('umb_performance_intermediate');?></td>

                                                                                            <td><?php if($team_work=='1'):?>

                                                                                            <?php echo $this->lang->line('umb_performance_beginner');?>

                                                                                            <?php elseif($team_work=='2'):?>

                                                                                              <?php echo $this->lang->line('umb_performance_intermediate');?>

                                                                                              <?php elseif($team_work=='3'):?>

                                                                                                <?php echo $this->lang->line('umb_performance_advanced');?>

                                                                                                <?php else:?>

                                                                                                  <span style="color:red;font - style: italic;line - height:2.4;"><?php echo $this->lang->line('umb_not_set_value');?></span>

                                                                                                  <?php endif;?></td>

                                                                                                </tr>

                                                                                                <tr>

                                                                                                  <td scope="row" colspan="2"><?php echo $this->lang->line('umb_performance_critical_think');?></td>

                                                                                                  <td colspan="2"><?php echo $this->lang->line('umb_performance_advanced');?></td>

                                                                                                  <td><?php if($critical_thinking=='1'):?>

                                                                                                  <?php echo $this->lang->line('umb_performance_beginner');?>

                                                                                                  <?php elseif($critical_thinking=='2'):?>

                                                                                                    <?php echo $this->lang->line('umb_performance_intermediate');?>

                                                                                                    <?php elseif($critical_thinking=='3'):?>

                                                                                                      <?php echo $this->lang->line('umb_performance_advanced');?>

                                                                                                      <?php else:?>

                                                                                                        <span style="color:red;font - style: italic;line - height:2.4;"><?php echo $this->lang->line('umb_not_set_value');?></span>

                                                                                                        <?php endif;?></td>

                                                                                                      </tr>

                                                                                                      <tr>

                                                                                                        <td scope="row" colspan="2"><?php echo $this->lang->line('umb_performance_conflict_manage');?></td>

                                                                                                        <td colspan="2"><?php echo $this->lang->line('umb_performance_intermediate');?></td>

                                                                                                        <td><?php if($conflict_management=='1'):?>

                                                                                                        <?php echo $this->lang->line('umb_performance_beginner');?>

                                                                                                        <?php elseif($conflict_management=='2'):?>

                                                                                                          <?php echo $this->lang->line('umb_performance_intermediate');?>

                                                                                                          <?php elseif($conflict_management=='3'):?>

                                                                                                            <?php echo $this->lang->line('umb_performance_advanced');?>

                                                                                                            <?php else:?>

                                                                                                              <span style="color:red;font - style: italic;line - height:2.4;"><?php echo $this->lang->line('umb_not_set_value');?></span>

                                                                                                              <?php endif;?></td>

                                                                                                            </tr>

                                                                                                            <tr>

                                                                                                              <td scope="row" colspan="2"><?php echo $this->lang->line('umb_performance_kehadiran');?></td>

                                                                                                              <td colspan="2"><?php echo $this->lang->line('umb_performance_intermediate');?></td>

                                                                                                              <td><?php if($kehadiran=='1'):?>

                                                                                                              <?php echo $this->lang->line('umb_performance_beginner');?>

                                                                                                              <?php elseif($kehadiran=='2'):?>

                                                                                                                <?php echo $this->lang->line('umb_performance_intermediate');?>

                                                                                                                <?php elseif($kehadiran=='3'):?>

                                                                                                                  <?php echo $this->lang->line('umb_performance_advanced');?>

                                                                                                                  <?php else:?>

                                                                                                                    <span style="color:red;font - style: italic;line - height:2.4;"><?php echo $this->lang->line('umb_not_set_value');?></span>

                                                                                                                    <?php endif;?></td>

                                                                                                                  </tr>

                                                                                                                  <tr>

                                                                                                                    <td scope="row" colspan="2"><?php echo $this->lang->line('umb_performance_meet_deadline');?></td>

                                                                                                                    <td colspan="2"><?php echo $this->lang->line('umb_performance_advanced');?></td>

                                                                                                                    <td><?php if($ability_to_meet_deadline=='1'):?>

                                                                                                                    <?php echo $this->lang->line('umb_performance_beginner');?>

                                                                                                                    <?php elseif($ability_to_meet_deadline=='2'):?>

                                                                                                                      <?php echo $this->lang->line('umb_performance_intermediate');?>

                                                                                                                      <?php elseif($ability_to_meet_deadline=='3'):?>

                                                                                                                        <?php echo $this->lang->line('umb_performance_advanced');?>

                                                                                                                        <?php else:?>

                                                                                                                          <span style="color:red;font - style: italic;line - height:2.4;"><?php echo $this->lang->line('umb_not_set_value');?></span>

                                                                                                                          <?php endif;?></td>

                                                                                                                        </tr>

                                                                                                                      </tbody>

                                                                                                                    </table>

                                                                                                                  </div>

                                                                                                                </div>

                                                                                                              </div>

                                                                                                            </div>

                                                                                                          </div>

                                                                                                          <div class="m-b-1">

                                                                                                            <div class="col-md-12">

                                                                                                              <div class="box box-block bg-white">

                                                                                                                <div class="form-group">

                                                                                                                  <label for="remarks"><strong><?php echo $this->lang->line('umb_keterangan');?></strong></label>

                                                                                                                  <?php echo htmlspecialchars_decode($remarks);?> </div>

                                                                                                                </div>

                                                                                                              </div>

                                                                                                            </div>

                                                                                                          </div>

                                                                                                        </div>

                                                                                                        <div class="modal-footer">

                                                                                                          <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('umb_close');?></button>

                                                                                                        </div>

                                                                                                      <?php }

                                                                                                      ?>

