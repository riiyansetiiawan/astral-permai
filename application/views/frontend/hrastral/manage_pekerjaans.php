<?php $session = $this->session->userdata('c_user_id'); ?>
<?php $pekerjaans = $this->Post_pekerjaan_model->get_employer_pekerjaans($session['c_user_id']);?>

<!--<div class="container">
  <p class="margin-bottom-25">Your listings are shown in the table below.</p>
  <table id="umb_table" class="display hover manage-table responsive-table" style="width:100%">
    <thead>
      <tr>
        <th width="80">Action</th>
        <th>Title</th>
        <th>Category</th>
        <th>Job Type</th>
        <th>Vacancies</th>
        <th>Closing Date</th>
      </tr>
    </thead>
  </table>
</div>-->
<div class="container">
	<!-- Table -->
	<div class="sixteen columns">

		<p class="margin-bottom-25">Daftar Anda ditunjukkan pada tabel di bawah ini.</p>

		<table class="manage-table responsive-table">

			<tr>
				<th><i class="fa fa-file-text"></i> Judul</th>
				<th><i class="fa fa-check-square-o"></i> Kategori</th>
				<th><i class="fa fa-life-bouy"></i>Type Pekerjaan</th>
				<th><i class="fa fa-calendar"></i> Tanggal Posting</th>
				<th><i class="fa fa-user"></i> Aplikasi lamaran</th>
				<th></th>
			</tr>
			
			<?php foreach($pekerjaans->result() as $r) { ?>
				<?php
				$kategori = $this->Post_pekerjaan_model->read_info_kategori_pekerjaan($r->kategori_id);
				if(!is_null($kategori)){
					$nama_kategori = $kategori[0]->nama_kategori;
				} else {
					$nama_kategori = '-';
				}
				$type_pekerjaan = $this->Post_pekerjaan_model->read_informasi_type_pekerjaan($r->type_pekerjaan);
				if(!is_null($type_pekerjaan)){
					$jtype = $type_pekerjaan[0]->type;
				} else {
					$jtype = '-';
				}
				$tanggal_penutupan = $this->Umb_model->set_date_format($r->tanggal_penutupan);
				$created_at = $this->Umb_model->set_date_format($r->created_at);
				if($r->status==1): $status = $this->lang->line('umb_published'); elseif($r->status==2): $status = $this->lang->line('umb_unpublished'); endif;
				$employer = $this->Recruitment_model->read_info_employer($r->employer_id);
				if(!is_null($employer)){
					$nama_employer = $employer[0]->nama_perusahaan;
				} else {
					$nama_employer = '-';	
				}
				?>
				<tr>
					<td class="title"><a href="<?php echo site_url('pekerjaans/detail/').$r->url_pekerjaan;?>"><?php echo $r->title_pekerjaan;?> <span class="pending">(<?php echo $status;?>)</span></a></td>
					<td class="centered"><?php echo $nama_kategori;?></td>
					<td><?php echo $jtype;?></td>
					<td><?php echo $created_at;?></td>
					<td class="centered">
						<?php $chk_pekerjaan = $this->Recruitment_model->check_applications_pekerjaans($r->pekerjaan_id);?>
						<?php if($chk_pekerjaan > 0):?>
							<a href="<?php echo site_url('employer/manage_applications/').$r->url_pekerjaan;?>" class="button">Show (<?php echo $chk_pekerjaan;?>)</a>
							<?php else:?>-
						<?php endif;?>
					</td>
					<td class="action">
						<a href="<?php echo site_url('employer/edit_pekerjaan/').$r->url_pekerjaan;?>"><i class="fa fa-pencil"></i> Edit</a>
						<a href="#" class="delete" data-toggle="modal" data-target=".delete-modal" data-record-id="<?php echo $r->pekerjaan_id;?>"><i class="fa fa-remove"></i> Hapus</a>
					</td>
				</tr>
			<?php  } ?>
		</table>

		<br>
		<a href="<?php echo site_url('employer/post_pekerjaan');?>" class="button">Tambah Pekerjaan</a>

	</div>

</div>
<div class="margin-top-60"></div>
