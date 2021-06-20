<?php
/* Sub Departments view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>

<div class="row m-b-1 <?php echo $get_animate;?>">
  <?php $role_resources_ids = $this->Umb_model->user_role_resource(); ?>
  <?php if(in_array('240',$role_resources_ids)) {?>
  <div class="col-md-4">
    <div class="card">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_add_new');?></strong> <?php echo $this->lang->line('umb_hr_sub_department');?></span>
    </div>
      <div class="card-body">
        <?php $attributes = array('name' => 'add_sub_department', 'id' => 'umb-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open('admin/department/add_sub_department', $attributes, $hidden);?>
        <div class="form-group">
        <label for="name"><?php echo $this->lang->line('umb_name');?></label>
          <?php
			$data = array(
			  'name'        => 'nama_department',
			  'id'          => 'nama_department',
			  'value'       => '',
			  'placeholder'   => $this->lang->line('umb_name'),
			  'class'       => 'form-control',
			);
		echo form_input($data);
		?>
        </div>
        <div class="form-group">
          <label for="penunjukan"><?php echo $this->lang->line('umb_hr_main_department');?></label>
          <select class="select2" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_select_department');?>" name="department_id">
            <option value=""></option>
            <?php foreach($all_departments as $deparment) {?>
            <option value="<?php echo $deparment->department_id;?>"><?php echo $deparment->nama_department;?></option>
            <?php } ?>
          </select>
        </div>
        <div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrastral_form', 'type' => 'submit', 'class' => $this->Umb_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('umb_save'))); ?> </div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
  <?php $colmdval = 'col-md-8';?>
  <?php } else {?>
  <?php $colmdval = 'col-md-12';?>
  <?php } ?>
  <div class="<?php echo $colmdval;?>">
    <div class="card">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_list_all');?></strong> <?php echo $this->lang->line('umb_hr_sub_departments');?></span> </div>
      <div class="card-body">
        <div class="box-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="umb_table">
            <thead>
              <tr>
                <th><?php echo $this->lang->line('umb_action');?></th>
                <th><?php echo $this->lang->line('umb_name');?></th>
                <th><?php echo $this->lang->line('umb_hr_main_department');?></th>
                <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('umb_created_at');?></th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
