<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['advance_gaji_id']) && $_GET['data']=='advance_gaji'){
?>

<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_edit_advance_gaji');?></h4>
</div>
<?php $attributes = array('name' => 'update_advance_gaji', 'id' => 'update_advance_gaji', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $advance_gaji_id, 'ext_name' => $advance_gaji_id);?>
<?php echo form_open('admin/payroll/update_advance_gaji/'.$advance_gaji_id, $attributes, $hidden);?>
  <div class="modal-body">
    
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
            <label for="nama_perusahaan"><?php echo $this->lang->line('module_title_perusahaan');?></label>
            <select class="form-control" name="perusahaan" id="ajx_perusahaan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_title_perusahaan');?>">
              <option value=""><?php echo $this->lang->line('umb_select_one');?></option>
              <?php foreach($get_all_perusahaans as $perusahaan) {?>
              <option value="<?php echo $perusahaan->perusahaan_id;?>" <?php if($perusahaan->perusahaan_id==$perusahaan_id):?> selected="selected"<?php endif; ?>> <?php echo $perusahaan->name;?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group" id="ajx_karyawan">
          <?php $result = $this->Department_model->ajax_info_perusahaan_karyawan($perusahaan_id);?>
  <label for="karyawan"><?php echo $this->lang->line('dashboard_single_karyawan');?></label>
      <select name="karyawan_id" id="karyawan_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_choose_an_karyawan');?>">
        <option value=""></option>
        <?php foreach($result as $karyawan) {?>
        <option value="<?php echo $karyawan->user_id;?>" <?php if($karyawan->user_id==$karyawan_id):?> selected="selected"<?php endif; ?>> <?php echo $karyawan->first_name.' '.$karyawan->last_name;?></option>
        <?php } ?>
      </select>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
               <label for="month_year"><?php echo $this->lang->line('umb_bulan_tahun_penghargaan');?></label>
              <input class="form-control d_month_year" placeholder="<?php echo $this->lang->line('umb_bulan_tahun_penghargaan');?>" readonly name="month_year" type="text" value="<?php echo $month_year;?>">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="end_date"><?php echo $this->lang->line('umb_jumlah');?></label>
              <input class="form-control" placeholder="<?php echo $this->lang->line('umb_jumlah');?>" name="jumlah" type="text" value="<?php echo $advance_jumlah;?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="edu_role"><?php echo $this->lang->line('umb_pengurangan_satu_kali');?></label>
            	<select name="pengurangan_satu_kali" class="select2 m_pengurangan_satu_kali" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_pengurangan_satu_kali');?>">
                
                <option value="1" <?php if($pengurangan_satu_kali==1):?> selected="selected"<?php endif; ?>><?php echo $this->lang->line('umb_yes');?></option><option value="0" <?php if($pengurangan_satu_kali==0):?> selected="selected"<?php endif; ?>><?php echo $this->lang->line('umb_no');?></option>
              </select>            
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="edu_role"><?php echo $this->lang->line('umb_emi_gaji');?></label>
              <input class="form-control" placeholder="<?php echo $this->lang->line('umb_karyawan_angsuran_bulanan');?>" name="angsuran_bulanan" type="text" id="m_angsuran_bulanan" <?php if($pengurangan_satu_kali==1):?>disabled="disabled"<?php endif;?> value="<?php echo $angsuran_bulanan;?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="is_publish"><?php echo $this->lang->line('dashboard_umb_status');?></label>
              <select name="status" class="select2" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_choose_status');?>">
                <option value="0" <?php if($status==0):?> selected="selected"<?php endif; ?>><?php echo $this->lang->line('umb_pending');?></option>
                <option value="1" <?php if($status==1):?> selected="selected"<?php endif; ?>><?php echo $this->lang->line('umb_accepted');?></option>
                <option value="2" <?php if($status==2):?> selected="selected"<?php endif; ?>><?php echo $this->lang->line('umb_rejected');?></option>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="description"><?php echo $this->lang->line('umb_alasan');?></label>
              <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('umb_alasan');?>" name="reason" rows="5" id="reason2"><?php echo $reason;?></textarea>
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
					
		jQuery("#ajx_perusahaan").change(function(){
			jQuery.get(base_url+"/get_advance_karyawans/"+jQuery(this).val(), function(data, status){
				jQuery('#ajx_karyawan').html(data);
			});
		});
		Ladda.bind('button[type=submit]');
		$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
		$('[data-plugin="select_hrm"]').select2({ width:'100%' });	 
			
		$(".m_pengurangan_satu_kali").change(function(){
			if($(this).val()==1){
				$('#m_angsuran_bulanan').attr('disabled',true);
				$('#angsuran_bulanan').val(0);
			} else {
				$('#m_angsuran_bulanan').attr('disabled',false);
			}
		});
				
		// award Month & Year
		$('.d_month_year').datepicker({
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,
		dateFormat:'yy-mm',
		yearRange: '1900:' + (new Date().getFullYear() + 15),
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

		/* Edit data */
		$("#update_advance_gaji").submit(function(e){
		e.preventDefault();
			var obj = $(this), action = obj.attr('name');
			$('.save').prop('disabled', true);
			$.ajax({
				type: "POST",
				url: e.target.action,
				data: obj.serialize()+"&is_ajax=1&edit_type=advance_gaji&form="+action,
				cache: false,
				success: function (JSON) {
					if (JSON.error != '') {
						toastr.error(JSON.error);
						$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
						$('.save').prop('disabled', false);
						Ladda.stopAll();
					} else {
						// On page load: datatable
						var umb_table = $('#umb_table').dataTable({
						"bDestroy": true,
						"ajax": {
							url : "<?php echo site_url("admin/payroll/list_advance_gaji") ?>",
							type : 'GET'
						},
						"fnDrawCallback": function(settings){
						$('[data-toggle="tooltip"]').tooltip();          
						}
						});
						umb_table.api().ajax.reload(function(){ 
							toastr.success(JSON.result);
							Ladda.stopAll();
						}, true);
						$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
						$('.edit-modal-data').modal('toggle');
						$('.save').prop('disabled', false);
					}
				}
			});
		});
	});	
  </script>
<?php } else if(isset($_GET['jd']) && isset($_GET['advance_gaji_id']) && $_GET['data']=='view_advance_gaji'){
?>

<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_view_advance_gaji');?></h4>
</div>
  <div class="modal-body">
  <div class="table-responsive" data-pattern="priority-columns">
    <table class="footable-details table table-striped table-hover toggle-circle">
      <tbody>
        <tr>
          <th><?php echo $this->lang->line('module_title_perusahaan');?></th>
          <td style="display: table-cell;"><?php foreach($get_all_perusahaans as $perusahaan) {?>
            <?php if($perusahaan_id==$perusahaan->perusahaan_id):?>
            <?php echo $perusahaan->name;?>
            <?php endif;?>
            <?php } ?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('dashboard_single_karyawan');?></th>
          <td style="display: table-cell;"><?php foreach($all_karyawans as $karyawan) {?>
            <?php if($karyawan_id==$karyawan->user_id):?>
            <?php echo $karyawan->first_name.' '.$karyawan->last_name;?>
            <?php endif;?>
            <?php } ?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('umb_bulan_tahun_penghargaan');?></th>
          <td style="display: table-cell;"><?php echo $month_year;?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('umb_jumlah');?></th>
          <td style="display: table-cell;"><?php echo $this->Umb_model->currency_sign($advance_jumlah);?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('umb_pengurangan_satu_kali');?></th>
          <td style="display: table-cell;"><?php if($pengurangan_satu_kali==1): echo $onetime = $this->lang->line('umb_yes'); else: echo $onetime = $this->lang->line('umb_no'); endif;?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('umb_emi_gaji');?></th>
          <td style="display: table-cell;"><?php echo $this->Umb_model->currency_sign($angsuran_bulanan);?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('dashboard_umb_status');?></th>
          <td style="display: table-cell;"><?php if($status==0): echo $status = $this->lang->line('umb_pending'); elseif($status==1): echo $status = $this->lang->line('umb_accepted'); else: echo $status = $this->lang->line('umb_rejected'); endif;?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('umb_created_at');?></th>
          <td style="display: table-cell;"><?php echo $this->Umb_model->set_date_format($created_at);?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('umb_alasan');?></th>
          <td style="display: table-cell;"><?php echo html_entity_decode($reason);?></td>
        </tr>
      </tbody>
    </table>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('umb_close');?></button>
  </div>
<?php } else if(isset($_GET['jd']) && isset($_GET['karyawan_id']) && $_GET['data']=='view_laporan_advance_gaji'){
?>

<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('umb_view_laporan_advance_gaji');?></h4>
</div>
  <div class="modal-body">
    <div class="table-responsive" data-pattern="priority-columns">
    <table class="footable-details table table-striped table-hover toggle-circle">
      <tbody>
        <tr>
          <th><?php echo $this->lang->line('module_title_perusahaan');?></th>
          <td style="display: table-cell;"><?php foreach($get_all_perusahaans as $perusahaan) {?>
            <?php if($perusahaan_id==$perusahaan->perusahaan_id):?>
            <?php echo $perusahaan->name;?>
            <?php endif;?>
            <?php } ?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('dashboard_single_karyawan');?></th>
          <td style="display: table-cell;"><?php foreach($all_karyawans as $karyawan) {?>
            <?php if($karyawan_id==$karyawan->user_id):?>
            <?php echo $karyawan->first_name.' '.$karyawan->last_name;?>
            <?php endif;?>
            <?php } ?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('umb_jumlah_total');?></th>
          <td style="display: table-cell;"><?php echo $this->Umb_model->currency_sign($advance_jumlah);?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('umb_total_yang_dibayarkan_jumlah');?></th>
          <td style="display: table-cell;"><?php echo $this->Umb_model->currency_sign($total_yang_dibayarkan);?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('umb_pengurangan_satu_kali');?></th>
          <td style="display: table-cell;">
		  <?php
			$remainig_jumlah = $advance_jumlah - $total_yang_dibayarkan;
			$rjumlah = $this->Umb_model->currency_sign($remainig_jumlah);
			?>
		  <?php echo $rjumlah;?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('dashboard_umb_status');?></th>
          <td style="display: table-cell;">
			<?php
            if($advance_jumlah == $total_yang_dibayarkan){
            	$all_dibayar = '<span class="tag tag-success">'.$this->lang->line('umb_all_dibayar').'</span>';
            } else {
           		$all_dibayar = '<span class="tag tag-warning">'.$this->lang->line('umb_remaining').'</span>';
            }
            ?>
		  <?php echo $all_dibayar;?></td>
        </tr>
        <tr>
          <th colspan="2" style="text-align:center;"><?php echo $this->lang->line('umb_rquested_date_details');?></th>
        </tr>        
      </tbody>
    </table>
    </div>
    <div class="table-responsive" data-pattern="priority-columns">
    <table class="footable-details table table-striped table-hover toggle-circle">
    	<tr>
          <th><?php echo $this->lang->line('umb_jumlah');?></th>
          <th><?php echo $this->lang->line('umb_bulan_tahun_penghargaan');?></th>
          <th><?php echo $this->lang->line('umb_pengurangan_satu_kali');?></th>
          <th><?php echo $this->lang->line('umb_emi_gaji');?></th>
          <th><?php echo $this->lang->line('umb_created_at');?></th>
        </tr>
        <?php $requested_date = $this->Payroll_model->requested_date_details($karyawan_id);?>
        <?php foreach($requested_date->result() as $r):?>
        <?php
		$d = explode('-',$r->month_year);
		$get_month = date('F', mktime(0, 0, 0, $d[1], 10));
		$month_year = $get_month.', '.$d[0];
		// get onetime potongan value
		if($r->pengurangan_satu_kali==1): $onetime = $this->lang->line('umb_yes'); else: $onetime = $this->lang->line('umb_no'); endif;
		?>
        <tr>
          <td><?php echo $this->Umb_model->currency_sign($r->advance_jumlah)?></td>
          <td><?php echo $month_year;?></td>
          <td><?php echo $onetime;?></td>
          <td><?php echo $this->Umb_model->currency_sign($r->angsuran_bulanan);?></td>
          <td><?php echo '<i class="fa fa-calendar position-left"></i> '.$this->Umb_model->set_date_format($r->created_at);?></td>
        </tr>
        <?php endforeach;?>
    </table>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('umb_close');?></button>
  </div>
<?php }
?>
