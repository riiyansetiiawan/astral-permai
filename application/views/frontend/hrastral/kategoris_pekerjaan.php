<div id="kategoris"> 
  <div class="kategoris-group">
    <div class="container">
      <div class="four columns">
        <h4>Job kategoris</h4>
      </div>
      <?php foreach (array_chunk($all_kategoris_pekerjaan, 20) as $row) { ?>
        <div class="four columns">
          <ul>
            <?php $count= 1; foreach($row as $kategori_pekerjaan) {?>
              <li><a href="<?php echo site_url().'pekerjaans/search/kategori/'.$kategori_pekerjaan->kategori_url;?>"><?php echo $kategori_pekerjaan->nama_kategori;?> (<?php echo $this->Recruitment_model->record_count_kategori_pekerjaan($kategori_pekerjaan->kategori_url);?>)</a></li>
              <?php $count++;}?>
            </ul>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
  <div class="margin-top-50"></div>
  <?php $this->load->view('frontend/hrastral/footer-block');?>