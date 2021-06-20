<?php
// Edit Quote Page

$system_setting = $this->Umb_model->read_setting_info(1);
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Umb_model->get_content_animate();?>
<?php $user_info = $this->Umb_model->read_user_info($session['user_id']);?>

<div class="row <?php echo $get_animate;?>">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('umb_edit_estimates');?> #<?php echo $quote_number;?></strong></span> </div>
      <div class="card-body" aria-expanded="true" style="">
        <div class="row m-b-1">
          <div class="col-md-12">
            <?php $attributes = array('name' => 'edit_quote', 'id' => 'umb-form', 'autocomplete' => 'off', 'class' => 'form');?>
            <?php $hidden = array('user_id' => 0);?>
            <?php echo form_open('admin/quotes/update_quote/'.$quote_id, $attributes, $hidden);?>
            <div class="bg-white">
              <div class="box-block">
                <div class="row">
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="quote_number"><?php echo $this->lang->line('umb_title_quote_number');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('umb_title_quote_number');?>" name="quote_number" type="text" readonly="readonly" value="<?php echo $quote_number;?>">
                    </div>
                  </div>
                  <div class="col-md-3">
                  <div class="form-group">
                    <label for="first_name"><?php echo $this->lang->line('left_perusahaan');?></label>
                    <select class="form-control" name="perusahaan_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_perusahaan');?>">
                      <option value=""></option>
                      <?php foreach($all_perusahaans as $perusahaan) {?>
                      <?php if($eperusahaan_id == $perusahaan->perusahaan_id):?>
                          <option value="<?php echo $perusahaan->perusahaan_id?>" <?php if($eperusahaan_id == $perusahaan->perusahaan_id):?> selected="selected"<?php endif;?>><?php echo $perusahaan->name?></option>
                          <?php endif;?>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                  <?php $c_clients = $this->Umb_model->get_perusahaan_clients($eperusahaan_id)?>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="client_id"><?php echo $this->lang->line('umb_project_client');?></label>
                      <select name="client_id" id="aj_client_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_project_client');?>">
                        <option value=""></option>
                        <?php foreach($c_clients as $client) {?>
                        <?php $clientInfo = $this->Clients_model->read_info_client($client->client_id);?>
                        <?php if(!is_null($clientInfo)):?>
                        <option value="<?php echo $clientInfo[0]->client_id;?>" <?php if($eclient_id == $clientInfo[0]->client_id):?> selected="selected"<?php endif;?>> <?php echo $clientInfo[0]->name;?></option>
                        <?php endif;?>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group" id="ajax_project">
                     <?php $eall_projects = $this->Umb_model->get_panel_projects_client($eclient_id);?>
                      <label for="project"><?php echo $this->lang->line('umb_project');?></label>
                      <select class="form-control" name="project" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('umb_project');?>">
                        <?php foreach($eall_projects as $project) {?>
                        <option value="<?php echo $project->project_id?>" <?php if($project_id == $project->project_id):?> selected="selected"<?php endif;?>><?php echo $project->title?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="quote_tanggal"><?php echo $this->lang->line('umb_quote_tanggal');?></label>
                      <input class="form-control date" placeholder="<?php echo $this->lang->line('umb_quote_tanggal');?>" readonly="readonly" name="quote_tanggal" type="text" value="<?php echo $quote_tanggal;?>">
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="quote_due_date"><?php echo $this->lang->line('umb_project_start_date');?></label>
                      <input class="form-control date" placeholder="<?php echo $this->lang->line('umb_project_start_date');?>" readonly="readonly" name="quote_due_date" type="text" value="<?php echo $quote_due_date;?>">
                    </div>
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <div class="hrastral-item-values">
                        <div data-repeater-list="items">
                          <div data-repeater-item="">
                            <?php $prod = array(); foreach($this->Quotes_model->get_quote_items($quote_id) as $_item):?>
                            <div class="row item-row">
                              <div class="form-group mb-1 col-sm-12 col-md-3">
                                <input type="hidden" name="item[<?php echo $_item->quote_item_id;?>]" value="<?php echo $_item->quote_item_id;?>" />
                                <label for="item_name"><?php echo $this->lang->line('umb_title_item');?></label>
                                <br>
                                <input type="text" class="form-control item_name" name="eitem_name[<?php echo $_item->quote_item_id;?>]" id="item_name" placeholder="Nama Item" value="<?php echo htmlentities($_item->item_name);?><?php //echo $_item->item_name;?>">
                              </div>
                              <div class="form-group mb-1 col-sm-12 col-md-2">
                                <label for="type_pajak"><?php echo $this->lang->line('umb_invoice_type_pajak');?></label>
                                <br>
                                <select class="form-control type_pajak" name="etype_pajak[<?php echo $_item->quote_item_id;?>]" id="type_pajak">
                                  <?php foreach($all_pajaks as $_pajak){?>
                                  <?php
										if($_pajak->type=='percentage') {
											$_type_pajak = $_pajak->rate.'%';
										} else {
											$_type_pajak = $this->Umb_model->perusahaan_currency_sign($_pajak->rate,$eperusahaan_id);
										}
									?>
                                  <option pajak-type="<?php echo $_pajak->type;?>" pajak-rate="<?php echo $_pajak->rate;?>" value="<?php echo $_pajak->pajak_id;?>" <?php if($_item->item_type_pajak==$_pajak->pajak_id):?> selected="selected"<?php endif;?>> <?php echo $_pajak->name;?> (<?php echo $_type_pajak;?>)</option>
                                  <?php } ?>
                                </select>
                              </div>
                              <div class="form-group mb-1 col-sm-12 col-md-1">
                                <label for="umb_title_nilai_pajak"><?php echo $this->lang->line('umb_title_nilai_pajak');?></label>
                                <br>
                                <input type="text" readonly="readonly" class="form-control pajak-nilai-item" name="enilai_pajak_item[<?php echo $_item->quote_item_id;?>]" value="<?php echo $_item->item_nilai_pajak;?>" />
                              </div>
                              <div class="form-group mb-1 col-sm-12 col-md-1">
                                <label for="qty_hrs" class="cursor-pointer"><?php echo $this->lang->line('umb_title_qty_hrs');?></label>
                                <br>
                                <input type="text" class="form-control qty_hrs" name="eqty_hrs[<?php echo $_item->quote_item_id;?>]" id="qty_hrs" value="<?php echo $_item->item_qty;?>">
                              </div>
                              <div class="skin skin-flat form-group mb-1 col-sm-12 col-md-2">
                                <label for="unit_price"><?php echo $this->lang->line('umb_title_unit_price');?></label>
                                <br>
                                <input class="form-control unit_price" type="text" name="eunit_price[<?php echo $_item->quote_item_id;?>]" value="<?php echo $_item->item_unit_price;?>" id="unit_price" />
                              </div>
                              <div class="form-group mb-1 col-sm-12 col-md-2">
                                <label for="profession"><?php echo $this->lang->line('umb_title_sub_total');?></label>
                                <input type="text" class="form-control sub-total-item" readonly="readonly" name="esub_total_item[<?php echo $_item->quote_item_id;?>]" value="<?php echo $_item->item_sub_total;?>" />
                                <!-- <br>-->
                                <p style="display:none" class="form-control-static"><span class="jumlah-html">0</span></p>
                              </div>
                              <div class="form-group col-sm-12 col-md-1 text-xs-center mt-2">
                                <label for="profession">&nbsp;</label>
                                <br>
                                <button type="button" class="btn icon-btn btn-xs btn-danger waves-effect waves-light eremove-item" data-repeater-delete="" data-record-id="<?php echo $_item->quote_item_id;?>" data-invoice-id="<?php echo $quote_id;?>"> <span class="fa fa-trash"></span></button>
                              </div>
                            </div>
                            <?php endforeach;?>
                          </div>
                        </div>
                      </div>
                      <div id="item-list"></div>
                      <div class="form-group overflow-hidden1">
                        <div class="col-xs-12">
                          <button type="button" data-repeater-create="" class="btn btn-primary" id="add-invoice-item"> <i class="fa fa-plus"></i> Add Item</button>
                        </div>
                      </div>
                      <?php
						$info_perusahaan = $this->Perusahaan_model->read_informasi_perusahaan($eperusahaan_id);
						if(!is_null($info_perusahaan)){
							$default_currency = $info_perusahaan[0]->default_currency;
							$ar_sc = explode('- ',$default_currency);
							$sc_show = $ar_sc[1];	
						} else {
							$ar_sc = explode('- ',$system_setting[0]->default_currency_symbol);
							$sc_show = $ar_sc[1];	
						}
						
						
						?>
                      <input type="hidden" class="items-sub-total" name="items_sub_total" value="<?php echo $sub_jumlah_total;?>" />
                      <input type="hidden" class="items-pajak-total" name="items_pajak_total" value="<?php echo $total_pajak;?>" />
                      <div class="row">
                        <div class="col-md-7 col-sm-12 text-xs-center text-md-left">&nbsp; </div>
                        <div class="col-md-5 col-sm-12">
                          <div class="table-responsive">
                            <table class="table">
                              <tbody>
                                <tr>
                                  <td><?php echo $this->lang->line('umb_title_sub_total2');?></td>
                                  <td class="text-xs-right"><?php echo $sc_show;?> <span class="sub_total"><?php echo $sub_jumlah_total;?></span></td>
                                </tr>
                                <tr>
                                  <td><?php echo $this->lang->line('umb_title_pajak_c');?></td>
                                  <td class="text-xs-right"><?php echo $sc_show;?> <span class="pajak_total"><?php echo $total_pajak;?></span></td>
                                </tr>
                                <tr>
                                  <td colspan="2" style="border-bottom:1px solid #dddddd; padding:0px !important; text-align:left"><table class="table table-bordered">
                                      <tbody>
                                        <tr>
                                          <td width="30%" style="border-bottom:1px solid #dddddd; text-align:left"><strong><?php echo $this->lang->line('umb_type_discount');?></strong></td>
                                          <td style="border-bottom:1px solid #dddddd; text-align:center"><strong><?php echo $this->lang->line('umb_discount');?></strong></td>
                                          <td style="border-bottom:1px solid #dddddd; text-align:left"><strong><?php echo $this->lang->line('umb_jumlah_discount');?></strong></td>
                                        </tr>
                                        <tr>
                                          <td><div class="form-group">
                                              <select name="type_discount" class="form-control type_discount">
                                                <option value="1" <?php if($type_discount==1):?> selected="selected"<?php endif;?>> <?php echo $this->lang->line('umb_flat');?></option>
                                                <option value="2" <?php if($type_discount==2):?> selected="selected"<?php endif;?>> <?php echo $this->lang->line('umb_percent');?></option>
                                              </select>
                                            </div></td>
                                          <td align="right"><div class="form-group">
                                              <input style="text-align:right" type="text" name="angka_discount" class="form-control angka_discount" value="<?php echo $angka_discount;?>" data-valid-num="required">
                                            </div></td>
                                          <td align="right"><div class="form-group">
                                              <input type="text" style="text-align:right" readonly="" name="jumlah_discount" value="<?php echo $total_discount;?>" class="jumlah_discount form-control">
                                            </div></td>
                                        </tr>
                                      </tbody>
                                    </table></td>
                                </tr>
                              <input type="hidden" class="fgrand_total" name="fgrand_total" value="<?php echo $grand_total;?>" />
                              <tr>
                                <td><?php echo $this->lang->line('umb_grand_total');?></td>
                                <td class="text-xs-right"><?php echo $sc_show;?> <span class="grand_total"><?php echo $grand_total;?></span></td>
                              </tr>
                                </tbody>
                              
                            </table>
                          </div>
                        </div>
                      </div>
                      <div class="form-group col-xs-12 mb-2 file-repeaters"> </div>
                      <div class="row">
                        <div class="col-lg-12">
                          <label for="quote_note"><?php echo $this->lang->line('umb_quote_note');?></label>
                          <textarea name="quote_note" class="form-control"><?php echo $quote_note;?></textarea>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div id="invoice-footer">
                  <div class="row">
                    <div class="col-md-7 col-sm-12">&nbsp;
                    </div>
                    <div class="col-md-5 col-sm-12 text-xs-center">
                      <button type="submit" name="invoice_submit" class="btn btn-primary pull-right my-1" style="margin-right: 5px;"><i class="fas fa-check-square"></i> <?php echo $this->lang->line('umb_submit_estimates');?></button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php echo form_close(); ?> </div>
        </div>
      </div>
    </div>
  </div>
</div>
