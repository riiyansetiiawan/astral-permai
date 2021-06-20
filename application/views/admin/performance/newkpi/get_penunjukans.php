<?php $result = $this->Penunjukan_model->ajax_perusahaan_info_penunjukan($perusahaan_id);?>

<?php

?>



<div class="form-group">

	<select class="form-control" name="penunjukan_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_select_penunjukan');?>">

		<option value=""></option>

		<?php foreach($result as $penunjukan) {?>

			<option value="<?php echo $penunjukan->penunjukan_id?>"><?php echo $penunjukan->nama_penunjukan?></option>

		<?php } ?>

	</select>

</div>

<?php

//}

?>

<script type="text/javascript">

	$(document).ready(function(){	

		$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));

		$('[data-plugin="select_hrm"]').select2({ width:'100%' });

	});

</script>