<?php
/* Policy view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>
<?php
$role_resources_ids = $this->Umb_model->user_role_resource();
$user_info = $this->Umb_model->read_user_info($session['user_id']);
if($user_info[0]->user_role_id==1){
	$kebijakan = $this->Kebijakan_model->get_kebijakans();
} else {
	$kebijakan = $this->Kebijakan_model->get_kebijakans_perusahaan($user_info[0]->perusahaan_id);
}
$data = array();
?>

<div class="container-fluid flex-grow-1 container-p-y">
  <h3 class="text-center font-weight-bold py-1 mb-2">
    <?php echo $this->lang->line('umb_kebijakans');?>
    <?php if(in_array('258',$role_resources_ids)) {?>
      <a class="text-dark" href="<?php echo site_url('admin/kebijakan/');?>"><button type="button" class="btn btn-primary rounded-pill d-block"><span class="ion ion-md-add"></span>&nbsp; <?php echo $this->lang->line('umb_add_new');?> <?php echo $this->lang->line('umb_kebijakan');?></button></a><?php } ?>
    </h3>
    <hr class="container-m-nx border-light my-0">
  </div>

  <div id="smartwizard-4" class="smartwizard-vertical-left smartwizard-example sw-main sw-theme-default">
    <ul class="nav nav-tabs step-anchor">
      <?php $i=1;foreach($kebijakan->result() as $r) { ?>
        <?php
        // get perusahaan
        if($r->perusahaan_id=='0'){
          $perusahaan = $this->lang->line('umb_all_perusahaans');
        } else {
          $p_perusahaan = $this->Umb_model->read_info_perusahaan($r->perusahaan_id);
          if(!is_null($p_perusahaan)){
            $perusahaan = $p_perusahaan[0]->name;
          } else {
            $perusahaan = '--';	
          }
        }
        ?>
        <li class="nav-item <?php if($i==1):?>active<?php else:?>done<?php endif;?>">
          <a href="#kebijakan_<?php echo $r->kebijakan_id;?>" class="text-nowrap mb-3 nav-link">
            <span class="sw-done-icon ion ion-md-checkmark"></span>
            <span class="sw-icon ion ion-ios-keypad"></span>
            <div class=""><?php echo $r->title;?></div>
            <div class="small"><?php echo $perusahaan;?></div>
          </a>
        </li>
        <?php $i++;}?>
      </ul>

      <div class="mb-3 sw-container tab-content">
       <?php $j=1;foreach($kebijakan->result() as $r) { ?>
        <div id="kebijakan_<?php echo $r->kebijakan_id;?>" class="card animated fadeIn mb-3 tab-pane step-content" <?php if($j==1):?>style="display: block;"<?php else:?>style="display: none;"<?php endif;?>>
          <div class="card-body">
            <h4 class="media align-items-center my-3">
              <div class="ion ion-ios-keypad ui-w-40 text-large"></div>
              <div class="media-body ml-1">
                <?php echo $r->title;?>
                <div class="text-muted text-tiny font-weight-light"><?php echo $perusahaan;?></div>
              </div>
            </h4>
            <?php echo html_entity_decode($r->description);?>
          </div>
        </div>
        <?php $j++;}?>                
      </div>
    </div>
