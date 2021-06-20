<?php $theme = $this->Umb_model->read_theme_info(1);?>
<?php $perusahaan = $this->Umb_model->read_info_setting_perusahaan(1);?>
<link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_assets/vendor/orgchart/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_assets/vendor/orgchart/css/jquery.orgchart.css">
<link rel="stylesheet" href="<?php echo base_url();?>skin/hrastral_assets/vendor/orgchart/css/style.css">
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
<script type="text/javascript" src="<?php echo base_url();?>skin/hrastral_assets/vendor/orgchart/js/html2canvas.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>skin/hrastral_assets/vendor/orgchart/js/jquery.orgchart.js"></script>
<?php $department = get_main_head_departments_karyawans();?>
<script type="text/javascript">
	$(function() {
    <?php /*?>var datascource = {
      'name': '<?php echo $perusahaan[0]->nama_perusahaan;?>',
      'title': '<?php echo $this->lang->line('umb_administrator_perusahaan');?>',
      'children': [
	  <?php foreach($department as $r){ ?>
		{ 'name': '<?php echo $r->first_name.' '.$r->last_name;?>', 'title': '<?php echo $r->nama_department;?>',
		<?php $subdepartment = get_sub_departments_karyawans($r->department_id,$r->karyawan_id);?>
		'children': [
			<?php foreach($subdepartment as $sr){ ?>
			{ 'name': '<?php echo $sr->first_name.' '.$sr->last_name;?>', 'title': '<?php echo $sr->nama_department;?>',
				<?php $subpenunjuk = get_sub_departments_penunjukans($sr->penunjukan_id,$sr->karyawan_id,$r->karyawan_id);?>
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
	  
	};<?php */?>
	var datascource = {
		'name': '<?php echo $perusahaan[0]->nama_perusahaan;?>',
		'title': '<?php echo $this->lang->line('umb_administrator_perusahaan');?>',
		'children': [
		<?php foreach($department as $r){ ?>
			<?php $user = $this->Umb_model->read_user_info($r->karyawan_id);
			if(!is_null($user)){
				$department_head = $user[0]->first_name.' '.$user[0]->last_name;
			} else {
				$department_head = '';
			}
			?>
			{ 'name': '<?php echo $department_head;?>', 'title': '<?php echo $r->nama_department;?>',
		<?php /*?><?php $subdepartment = get_sub_departments_karyawans($r->department_id,$r->karyawan_id);?>
		'children': [
			<?php foreach($subdepartment as $sr){ ?>
				{ 'name': '<?php echo $sr->first_name.' '.$sr->last_name;?>', 'title': '<?php echo $sr->nama_department;?>',<?php */?>
				<?php $subpenunjuk = get_departments_penunjukans($r->department_id,$r->karyawan_id);?>
				'children': [
				<?php foreach($subpenunjuk as $spenunjuk){ ?>
					<?php //if($r->karyawan_id!=$spenunjuk->karyawan_id):?>
					{ 'name': '<?php echo $spenunjuk->first_name.' '.$spenunjuk->last_name;?>', 'title': '<?php echo $spenunjuk->nama_penunjukan;?>',
				},
				<?php //endif;?>
			<?php }?>
			]
			<?php /*?>},
			<?php }?>
		]<?php */?>
	},
<?php }?>
]

};

$('#chart-container').orgchart({
	'data' : datascource,
	'visibleLevel': 4,
	'nodeContent': 'title',
	'exportButton': <?php echo $theme[0]->export_orgchart;?>,
	'exportFilename': '<?php echo $theme[0]->export_file_title;?>',
	'pan': <?php echo $theme[0]->org_chart_pan;?>,
	'zoom': <?php echo $theme[0]->org_chart_zoom;?>,
	'direction': '<?php echo $theme[0]->org_chart_layout;?>'
});

});
</script>
