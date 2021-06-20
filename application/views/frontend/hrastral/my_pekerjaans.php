<?php 
$session = $this->session->userdata('c_user_id');
$iuser = $this->Umb_model->read_user_info($session['c_user_id']);?>
<div class="container">
	
	<!-- Table -->
	<div class="sixteen columns">

		<p class="margin-bottom-25">Pekerjaan Terbaru yang Anda terapkan ditunjukkan pada tabel di bawah ini.</p>

		<table class="manage-table responsive-table">

			<tr>
				<th><i class="fa fa-file-text"></i> Judul</th>
				<th><i class="fa fa-check-square-o"></i> Type PEkerjaan</th>
				<th><i class="fa fa-calendar"></i> Tanggal Pembukaan</th>
				<th><i class="fa fa-calendar"></i> Tanggal Penutupan</th>
				<th><i class="fa fa-user"></i> Resume</th>
				<th></th>
			</tr>
			<?php $my_pekerjaans = $this->Post_pekerjaan_model->get_user_applied_pekerjaans($session['c_user_id']);?>   
			<?php foreach($my_pekerjaans->result() as $pekerjaans):?>
				<?php $result = $this->Post_pekerjaan_model->read_informasi_pekerjaan($pekerjaans->pekerjaan_id);?>
				<?php $jtype = $this->Post_pekerjaan_model->read_informasi_type_pekerjaan($result[0]->type_pekerjaan); ?>
				<?php
				if(!is_null($jtype)){
					$jt_type = $jtype[0]->type;
					if($jt_type == 'Freelance'):
						$clS = 'freelance';
					elseif($jt_type == 'Internship'):
						$clS = 'internship';
					elseif($jt_type == 'Part Time'):
						$clS = 'part-time';
					elseif($jt_type == 'Full Time'):
						$clS = 'full-time';
					else:		
						$clS = 'full-time';		
					endif;
				} else {
					$jt_type = '--';	
				}
				?>
				<!-- Item #1 -->
				<tr>
					<td class="title"><a href="<?php echo site_url('pekerjaans/detail/').$pekerjaans->url_pekerjaan;?>" target="_blank"><?php echo $result[0]->title_pekerjaan;?></a></td>
					<td class="centered"><?php echo $jt_type;?></td>
					<td><?php echo $this->Umb_model->set_date_format($pekerjaans->created_at);?></td>
					<td><?php echo $this->Umb_model->set_date_format($result[0]->tanggal_penutupan);?></td>
					<td class="action">
						<a href="<?php echo site_url('download').'?type=resume&filename='.$pekerjaans->pekerjaan_resume;?>" class="delete"><i class="ln ln-icon-File-Download"></i> Download</a>
					</td>
					<td>&nbsp;</td>
				</tr>
			<?php endforeach;?>  
		</table>

	</div>

</div>


