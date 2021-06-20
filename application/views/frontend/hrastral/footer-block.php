<?php $session = $this->session->userdata('c_user_id');?>
<div class="infobox margin-bottom-0">
	<div class="container">
		<?php if(!$session):?>
            <div class="sixteen columns">Mulai Bangun Pekerjaan Anda Sendiri Sekarang
                <a href="<?php echo site_url('employer/signup');?>">Memulai</a>
            </div>
        <?php else:?>
            <div class="sixteen columns">Mulai Bangun Pekerjaan Anda Sendiri Sekarang 
                <a href="<?php echo site_url('employer/post_pekerjaan');?>">Posting Pekerjaan</a>
            </div>
        <?php endif;?>
    </div>
</div>