<?php $session = $this->session->userdata('username'); ?>
<?php $perusahaan = $this->Umb_model->read_info_setting_perusahaan(1);?>
<?php $user = $this->Umb_model->read_user_info($session['user_id']); ?>
<?php $system = $this->Umb_model->read_setting_info(1);?>
<?php $theme = $this->Umb_model->read_theme_info(1);?>
<?php $this->load->view('admin/components/vendors/del_dialog');?>
<script src="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/js/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/libs/jquery-ui/jquery-ui.min.js"></script>
<script src="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/libs/popper/popper.js"></script>
<script src="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/js/bootstrap.js"></script>
<script src="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/js/sidenav.js"></script>
<script src="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/js/dropdown-hover.js"></script>
<script src="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/libs/bootstrap-menu/bootstrap-menu.js"></script>
<script src="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/libs/moment/moment.js"></script>
<script src="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/libs/bootstrap-material-datetimepicker/bootstrap-material-datetimepicker.js"></script>
<script src="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/libs/timepicker/timepicker.js"></script>
<script src="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
<?php if($this->router->fetch_method() =='kehadiran' || $this->router->fetch_method() =='tanggal_bijaksana_kehadiran' || $this->router->fetch_method() =='update_kehadiran'){?>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=<?php echo $system[0]->google_maps_api_key;?>&sensor=false"></script>
<?php } ?>
<script src="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/libs/datatables/datatables.js"></script>
<?php if($this->router->fetch_class() =='laporans'  || $this->router->fetch_method() =='history_pembayaran' || $this->router->fetch_method() =='accounts_ledger'){?>
	<script src="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/datatable_export/dataTables.buttons.min.js"></script>

	<script src="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/datatable_export/jszip.min.js"></script>
	<script src="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/datatable_export/pdfmake.min.js"></script>
	<script src="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/datatable_export/vfs_fonts.js"></script>
	<script src="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/datatable_export/buttons.html5.min.js"></script>
	<script src="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/datatable_export/buttons.print.min.js"></script>
	<link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/datatable_export/buttons.dataTables.min.css">
<?php }?>
<?php if($this->router->fetch_class() =='settings'){?>
	<link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/libs/bootstrap-duallistbox/bootstrap-duallistbox.css">
	<script src="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/libs/bootstrap-duallistbox/bootstrap-duallistbox.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#duallistbox-example').bootstrapDualListbox({
				nonSelectedListLabel: '<?php echo $this->lang->line('umb_top_menu');?>',
				selectedListLabel: '<?php echo $this->lang->line('umb_moved_to_left_menu');?>',
				preserveSelectionOnMove: 'moved',
				moveOnSelect: true
			});
		});
	</script>
<?php }?>
<script type="text/javascript" src="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/Trumbowyg/dist/trumbowyg.min.js"></script>
<script src="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/libs/select2/select2.js"></script>
<script src="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/libs/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>
<script src="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/libs/validate/validate.js"></script>
<script src="<?php echo base_url();?>skin/hrastral_vendor/assets/js/ui_tooltips.js"></script>
<?php if(($this->router->fetch_class() =='karyawans' && $this->router->fetch_method() =='detail') || $this->router->fetch_class() =='import' || $this->router->fetch_class() =='profile' || $this->router->fetch_method() =='view_all') { ?>
	<script src="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/libs/smartwizard/smartwizard.js"></script>
	<script src="<?php echo base_url();?>skin/hrastral_vendor/assets/js/forms_wizard.js"></script>
<?php } ?>
<link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/libs/ladda/ladda.css">
<script src="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/libs/spin/spin.js"></script>
<script src="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/libs/ladda/ladda.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/toastr/toastr.min.js"></script> 
<script type="text/javascript">
	$(document).ready(function(){
		$('.date').bootstrapMaterialDatePicker({
			weekStart: 0,
			time: false,
			clearButton: false,
			format: 'YYYY-MM-DD'
		});
		$('.month_year').datepicker({
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
		$('.hr_month_year').datepicker({
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
		$('.timepicker').bootstrapMaterialDatePicker({
			date: false,
			shortTime: true,
			format: 'HH:mm'
		});
		$('.hrastral-link').click(function(){
			var ilink = $(this).data('link-data');
			window.location = ilink;
		});
		toastr.options.closeButton = <?php echo $system[0]->notification_close_btn;?>;
		toastr.options.progressBar = <?php echo $system[0]->notification_bar;?>;
		toastr.options.timeOut = 3000;
		toastr.options.preventDuplicates = true;
		toastr.options.positionClass = "<?php echo $system[0]->notification_position;?>";
		var site_url = '<?php echo site_url(); ?>';
		Ladda.bind('button[type=submit]');
		function escapeHtmlSecure(str) {
			var map =
			{
				'alert': '&lt;',
				'313': '&lt;',
				'bzps': '&lt;',
				'<': '&lt;',
				'>': '&gt;',
				'script': '&lt;',
				'html': '&lt;',
				'php': '&lt;',
			};
			return str.replace(/[<>]/g, function(m) {
				return map[m];
			});
		}
	});
</script>
<?php if($this->router->fetch_class() =='karyawans' || $this->router->fetch_class() =='dashboard' || $this->router->fetch_method() =='dashboard_accounting' || $this->router->fetch_method() =='dashboard_kehadiran' || $this->router->fetch_class() =='project') { ?>
	<script src="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/libs/chartjs/chartjs.js"></script>
<?php } ?>
<?php if($this->router->fetch_class() =='events' || $this->router->fetch_class() =='meetings'){?>
	<script src="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/libs/minicolors/minicolors.js"></script>
<?php } ?>
<script type="text/javascript">var user_role = '<?php //echo $user[0]->user_role_id;?>';</script>
<script type="text/javascript">var user_session_id = '<?php echo $session['user_id'];?>';</script>
<script type="text/javascript">var js_date_format = '<?php echo $this->Umb_model->set_date_format_js();?>';</script>
<script type="text/javascript">var site_url = '<?php echo site_url(); ?>admin/';</script>
<script type="text/javascript">var base_url = '<?php echo site_url().'admin/'.$this->router->fetch_class(); ?>';</script>
<script type="text/javascript">var processing_request = '<?php echo $this->lang->line('umb_permiuntaan_sedang_diproses');?>';</script>
<script type="text/javascript">var request_submitted = '<?php echo $this->lang->line('umb_hr_permintaan_submitted');?>';</script>
<?php if($this->router->fetch_class() =='project'){?>
	<?php if($system[0]->show_projects=='0'){?>
		<script type="text/javascript">var show_projects = 'list';</script>
	<?php } else {?>   
		<script type="text/javascript">var show_projects = 'grid';</script> 
	<?php } ?>
<?php } ?>
<?php if($this->router->fetch_method() =='tugass'){?>
	<?php if($system[0]->show_tugass=='0'){?>
		<script type="text/javascript">var show_tugass = 'list';</script>
	<?php } else {?>   
		<script type="text/javascript">var show_tugass = 'grid';</script> 
	<?php } ?>
<?php } ?>
<script type="text/javascript" src="<?php echo base_url().'skin/hrastral_vendor/hrastral_scripts/'.$path_url.'.js'; ?>"></script>
<?php if($this->router->fetch_class() =='dashboard') { ?>
	<?php if($user[0]->user_role_id!=1): ?>
		<?php if($system[0]->is_ssl_available=='yes'){?>
			<script src="<?php echo base_url();?>skin/hrastral_vendor/hrastral_scripts/user/set_clocking_ssl.js"></script>
		<?php } else {?>
			<script src="<?php echo base_url();?>skin/hrastral_vendor/hrastral_scripts/user/set_clocking_non_ssl.js"></script>
		<?php } ?>
	<?php endif;?>
<?php } ?>
<?php if($this->router->fetch_class() =='roles') { ?>
	<script type="text/javascript" src="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/kendo/kendo.all.min.js"></script>
	<?php $this->load->view('admin/roles/role_values');?>
<?php } ?>
<script src="<?php echo base_url();?>skin/hrastral_vendor/assets/js/pages_kontaks.js"></script>
<script src="<?php echo base_url();?>skin/hrastral_vendor/assets/js/demo.js"></script>
<script src="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/js/dropdown-hover.js"></script>
<script src="<?php echo base_url();?>skin/hrastral_vendor/assets/js/ui_navbar.js"></script>
<script src="<?php echo base_url();?>skin/hrastral_vendor/assets/js/ui_dropdowns.js"></script>
<?php if($this->router->fetch_class() =='dashboard') { ?>
	<script src="<?php echo base_url();?>skin/hrastral_vendor/hrastral_scripts/hrastral_charts/hrastral_payroll.js"></script>
	<?php if($user[0]->user_role_id==1): ?>
		<script src="<?php echo base_url();?>skin/hrastral_vendor/hrastral_scripts/hrastral_charts/karyawan_department.js"></script>
		<script src="<?php echo base_url();?>skin/hrastral_vendor/hrastral_scripts/hrastral_charts/karyawan_penunjukan.js"></script>
		<script src="<?php echo base_url();?>skin/hrastral_vendor/hrastral_scripts/hrastral_charts/hrastral_projects.js"></script>
		<script src="<?php echo base_url();?>skin/hrastral_vendor/hrastral_scripts/hrastral_charts/hrastral_biaya_deposit.js"></script>
		<?php else:?>
			<script src="<?php echo base_url();?>skin/hrastral_vendor/hrastral_scripts/hrastral_charts/hrastral_projects.js"></script>
			<script src="<?php echo base_url();?>skin/hrastral_vendor/hrastral_scripts/hrastral_charts/hrastral_tugass.js"></script>
		<?php endif; ?>
	<?php } ?>
	<?php if($this->router->fetch_class() =='karyawans') { ?>
		<script src="<?php echo base_url();?>skin/hrastral_vendor/hrastral_scripts/hrastral_charts/hrastral_roles.js"></script>
		<script src="<?php echo base_url();?>skin/hrastral_vendor/hrastral_scripts/hrastral_charts/hrastral_shifts_kantor.js"></script>
		<script src="<?php echo base_url();?>skin/hrastral_vendor/hrastral_scripts/hrastral_charts/karyawan_perusahaan.js"></script>
		<script src="<?php echo base_url();?>skin/hrastral_vendor/hrastral_scripts/hrastral_charts/location_karyawan.js"></script>
	<?php } ?>
	<?php if($this->router->fetch_method() =='dashboard_accounting') { ?>
		<script src="<?php echo base_url();?>skin/hrastral_vendor/hrastral_scripts/hrastral_charts/hrastral_biaya_deposit.js"></script>
		<script src="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/libs/knob/knob.js"></script>
		<script type="text/javascript">
			$(function () {
				$(".knob").knob({});
			});
		</script>
	<?php } ?>
	<?php if($this->router->fetch_method() =='dashboard_kehadiran') { ?>
		<script src="<?php echo base_url();?>skin/hrastral_vendor/hrastral_scripts/hrastral_charts/status_kerja_karyawan.js"></script>
		<script src="<?php echo base_url();?>skin/hrastral_vendor/hrastral_scripts/hrastral_charts/hrastral_permintaan_lembur.js"></script>
	<?php } ?>
	<?php if($this->router->fetch_method() =='dashboard_projects') { ?>
		<script src="<?php echo base_url();?>skin/hrastral_vendor/hrastral_scripts/hrastral_charts/hrastral_projects.js"></script>
		<script src="<?php echo base_url();?>skin/hrastral_vendor/hrastral_scripts/hrastral_charts/hrastral_tugass.js"></script>
		<script src="<?php echo base_url();?>skin/hrastral_vendor/hrastral_scripts/hrastral_charts/hrastral_clients_leads.js"></script>
		<script src="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/libs/flot/flot.js"></script>
	<?php } ?>
	<?php if($this->router->fetch_class() =='laporans' ) { ?>
		<script src="<?php echo base_url();?>skin/hrastral_vendor/assets/js/pages_file-manager.js"></script>
	<?php } ?>
	<?php if($this->router->fetch_class() =='chat') { ?>
		<script src="<?php echo base_url();?>skin/hrastral_vendor/assets/js/pages_chat.js"></script>
	<?php } ?>
	<?php if($this->router->fetch_class() =='organization' && $this->router->fetch_method() =='chart') { ?>
		<?php $this->load->view('admin/components/vendors/organization_chart');?>
	<?php } ?>
	<?php if($this->router->fetch_class() =='calendar' || $this->router->fetch_class() =='timesheet' || $this->router->fetch_class() =='dashboard' || $this->router->fetch_method() =='timecalendar' || $this->router->fetch_method() =='calendar_projects' || $this->router->fetch_method() =='calendar_tugass' || $this->router->fetch_method() =='quote_calendar' || $this->router->fetch_method() =='calendar_invoice' || $this->router->fetch_method() =='dashboard_projects' || $this->router->fetch_method() =='dashboard_accounting' || $this->router->fetch_method() =='calendar'){?>
		<script src="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/libs/fullcalendar/dist/fullcalendar.js"></script>
		<script src="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/libs/fullcalendar/dist/scheduler.min.js"></script>
	<?php }?>
	<?php if($this->router->fetch_method() =='scrum_board_tugass' || $this->router->fetch_method() =='scrum_board_projects') { ?>
		<script src="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/dragula/dragula.js"></script>
	<?php } ?>
	<?php if($this->router->fetch_class() =='calendar' || $this->router->fetch_class() =='dashboard'){?>
		<?php if($user[0]->user_role_id==1): ?>
			<?php $this->load->view('admin/components/vendors/full_calendar');?>
			<?php else:?>
				<?php $this->load->view('admin/components/vendors/half_calendar');?>
			<?php endif; ?>
		<?php }?>
		<?php if($this->router->fetch_class() =='tujuan_tracking' || $this->router->fetch_method() =='details_tugas' || $this->router->fetch_class() =='project' || $this->router->fetch_method() =='details_project' || $this->router->fetch_class() =='quoted_projects'){?>
			<script type="text/javascript" src="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/ion.rangeSlider/js/ion-rangeSlider/ion.rangeSlider.min.js"></script>
		<?php }?>
		<?php if($this->router->fetch_method() =='details_tugas' || $this->router->fetch_method() =='details_project' || ($this->router->fetch_class() =='project' && $this->router->fetch_method() !='calendar_projects') || ($this->router->fetch_class() =='quoted_projects' && $this->router->fetch_method() =='detail')){?>
			<script type="text/javascript">
				$(document).ready(function(){	
					$("#range_grid").ionRangeSlider({
						type: "single",
						min: 0,
						max: 100,
						from: '<?php echo $progress;?>',
						grid: true,
						force_edges: true,
						onChange: function (data) {
							$('#progres_val').val(data.from);
						}
					});
				});
			</script>
		<?php } ?>
		<?php if($this->router->fetch_class() =='timesheet' && $this->router->fetch_method() =='index') { ?>
			<?php $this->load->view('admin/components/vendors/hrastral_calendar_bulanan');?>
		<?php } ?>
		<?php if($this->router->fetch_class() =='timesheet' && $this->router->fetch_method() =='timecalendar') { ?>
			<?php $this->load->view('admin/components/vendors/calendar_time');?>
		<?php } ?>
		<?php if($this->router->fetch_method() =='calendar_tugass'){?>
			<?php $this->load->view('admin/components/vendors/calendar_tugass');?>
		<?php }?>
		<?php if($this->router->fetch_method() =='calendar_projects'){?>
			<?php $this->load->view('admin/components/vendors/calendar_project');?>
		<?php }?>
		<?php if($this->router->fetch_method() =='calendar_invoice'){?>
			<?php $this->load->view('admin/components/vendors/calendar_invoice');?>
		<?php }?>
		<?php if($this->router->fetch_method() =='quote_calendar'){?>
			<?php $this->load->view('admin/components/vendors/quote_calendar');?>
		<?php }?>
		<?php if($this->router->fetch_class() =='events' && $this->router->fetch_method() =='calendar'){?>
			<?php $this->load->view('admin/components/vendors/calendar_events');?>
		<?php }?>
		<?php if($this->router->fetch_class() =='meetings' && $this->router->fetch_method() =='calendar'){?>
			<?php $this->load->view('admin/components/vendors/calendar_meetings');?>
		<?php }?>
		<?php if($this->router->fetch_class() =='invoices' || $this->router->fetch_class() =='quotes' && ($this->router->fetch_method() =='create' || $this->router->fetch_method() =='edit')) { ?>
			<script type="text/javascript">
				$(document).ready(function(){
					$('#add-invoice-item').click(function () {
						var invoice_items = '<div class="row item-row">'
						+'<hr>'
						+'<div class="form-group mb-1 col-sm-12 col-md-3">'
						+'<label for="item_name"><?php echo $this->lang->line('umb_title_item');?></label>'
						+'<br>'
						+'<input type="text" class="form-control item_name" name="item_name[]" id="item_name" placeholder="Nama Item">'
						+'</div>'
						+'<div class="form-group mb-1 col-sm-12 col-md-2">'
						+'<label for="type_pajak"><?php echo $this->lang->line('umb_invoice_type_pajak');?></label>'
						+'<br>'
						+'<select class="form-control type_pajak" name="type_pajak[]" id="type_pajak">'
						<?php foreach($all_pajaks as $_pajak){?>
							<?php
							if($_pajak->type=='percentage') {
								$_type_pajak = $_pajak->rate.'%';
							} else {
								$_type_pajak = $this->Umb_model->currency_sign($_pajak->rate);
							}
							?>
							+'<option pajak-type="<?php echo $_pajak->type;?>" pajak-rate="<?php echo $_pajak->rate;?>" value="<?php echo $_pajak->pajak_id;?>"> <?php echo $_pajak->name;?> (<?php echo $_type_pajak;?>)</option>'
						<?php } ?>
						+'</select>'
						+'</div>' 
						+'<div class="form-group mb-1 col-sm-12 col-md-1">'
						+'<label for="type_pajak"><?php echo $this->lang->line('umb_title_nilai_pajak');?></label>'
						+'<br>'
						+'<input type="text" readonly="readonly" class="form-control pajak-nilai-item" name="nilai_pajak_item[]" value="0" />'
						+'</div>'
						+'<div class="form-group mb-1 col-sm-12 col-md-1">'
						+'<label for="qty_hrs" class="cursor-pointer"><?php echo $this->lang->line('umb_title_qty_hrs');?></label>'
						+'<br>'
						+'<input type="text" class="form-control qty_hrs" name="qty_hrs[]" id="qty_hrs" value="1">'
						+'</div>'
						+'<div class="skin skin-flat form-group mb-1 col-sm-12 col-md-2">'
						+'<label for="unit_price"><?php echo $this->lang->line('umb_title_unit_price');?></label>'
						+'<br>'
						+'<input class="form-control unit_price" type="text" name="unit_price[]" value="0" id="unit_price" />'
						+'</div>'
						+'<div class="form-group mb-1 col-sm-12 col-md-2">'
						+'<label for="profession"><?php echo $this->lang->line('umb_title_sub_total');?></label>'
						+'<input type="text" class="form-control sub-total-item" readonly="readonly" name="sub_total_item[]" value="0" />'
						+'<p style="display:none" class="form-control-static"><span class="jumlah-html">0</span></p>'
						+'</div>'
						+'<div class="form-group col-sm-12 col-md-1 text-xs-center mt-2">'
						+'<label for="profession">&nbsp;</label><br><button type="button" class="btn icon-btn btn-xs btn-danger waves-effect waves-light remove-invoice-item" data-repeater-delete=""> <span class="fa fa-trash"></span></button>'
						+'</div>'
						+'</div>'
						$('#item-list').append(invoice_items).fadeIn(500);
					});
				});
			</script>
		<?php } ?>
		<?php if($this->router->fetch_class() =='invoices' || $this->router->fetch_class() =='quotes' && $this->router->fetch_method() =='view') { ?>
			<script type="text/javascript" src="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/printThis.js"></script>
			<script type="text/javascript">
				$(document).ready(function(){
					$('.print-invoice').click(function () {
						$("#print_invoice_hr").printThis();
					});	
				});
			</script>
		<?php } ?>


