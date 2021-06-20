<?php $theme = $this->Umb_model->read_theme_info(1);?>
<?php $perusahaan = $this->Umb_model->read_info_setting_perusahaan(1);?>
<link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/orgchart/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/orgchart/css/jquery.orgchart.css">
<link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/orgchart/css/style.css">
<style type="text/css">
	.orgchart {
		background: #fff;
	}
	#chart-container {
		<?php if($theme[0]->org_chart_layout=='t2b' || $theme[0]->org_chart_layout=='b2t'):?>  text-align: center !important;
		<?php elseif($theme[0]->org_chart_layout=='l2r'):?>  text-align: left !important;
		<?php elseif($theme[0]->org_chart_layout=='r2l'):?>  text-align: right !important;
	<?php endif;
	?>
}
</style>
<script type="text/javascript" src="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/orgchart/js/html2canvas.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>skin/hrastral_vendor/assets/vendor/orgchart/js/jquery.orgchart.js"></script>
<?php $main_perusahaans = get_main_chart_perusahaans();?>
<script type="text/javascript">
	$(function() {
		var datascource = {
			'name': '<?php echo $perusahaan[0]->nama_perusahaan;?>',
			'title': '<?php echo $this->lang->line('umb_administrator_perusahaan');?>',
			'children': [
			<?php foreach($main_perusahaans as $cr){ ?>
				<?php
				$ctype = $this->Perusahaan_model->read_type_perusahaan($cr->type_id);
				if(!is_null($ctype)){
					$type_name = $ctype[0]->name;
				} else {
					$type_name = '--';	
				}
				?>
				{ 'name': '<?php echo $cr->name;?>', 'title': '<?php echo $type_name;?>',
				<?php $location_chart = get_main_chart_location_perusahaans($cr->perusahaan_id);?>

				'children': [
				<?php foreach($location_chart as $lchart){ ?>
					<?php $location_user = $this->Umb_model->read_user_info($lchart->location_head);
					if(!is_null($location_user)){
						$location_head = $location_user[0]->first_name.' '.$location_user[0]->last_name;
					} else {
						$location_head = '';
					}
					?>
					{ 'name': '<?php echo $location_head;?>', 'title': '<?php echo $lchart->nama_location;?>',
					<?php $ldepartment = get_location_head_departments_karyawans($lchart->location_id);?>
					'children': [
					<?php foreach($ldepartment as $r){ ?>
						<?php $user = $this->Umb_model->read_user_info($r->karyawan_id);
						if(!is_null($user)){
							$department_head = $user[0]->first_name.' '.$user[0]->last_name;
						} else {
							$department_head = '';
						}
						?>
						{ 'name': '<?php echo $department_head;?>', 'title': '<?php echo $r->nama_department;?>',
						<?php $subpenunjuk = get_departments_penunjukans($r->department_id,$r->karyawan_id);?>
						'children': [
						<?php foreach($subpenunjuk as $spenunjuk){ ?>
							{ 'name': '<?php echo $spenunjuk->first_name.' '.$spenunjuk->last_name;?>', 'title': '<?php echo $spenunjuk->nama_penunjukan;?>',
						},
						
					<?php }?>
					]
				},
			<?php }?>
			]
		},
	<?php }?>
	]
},
<?php }?>
]

};

$('#chart-container').orgchart({
	'data' : datascource,
	'visibleLevel': 5,
	'nodeContent': 'title',
	'exportButton': <?php echo $theme[0]->export_orgchart;?>,
	'exportFilename': '<?php echo $theme[0]->export_file_title;?>',
	'pan': <?php echo $theme[0]->org_chart_pan;?>,
	'zoom': <?php echo $theme[0]->org_chart_zoom;?>,
	'direction': '<?php echo $theme[0]->org_chart_layout;?>'
});

});
</script>
