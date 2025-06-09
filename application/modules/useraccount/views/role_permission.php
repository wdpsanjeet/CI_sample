<!doctype html>
<html lang="en">
  <?php $this->load->view('partial/header_script'); ?>
  <body>
<div class="body_sec">
      <?php $this->load->view('partial/left_menu'); ?>
      <div class="rgt_sidebar">
        <div class="rgt_tophead">
        	<?php $this->load->view('partial/top_header'); ?>

          <div class="dash-tbl dash-frm-wrap">
          		<div class="row">
              <div class="col-md-8">
                
              </div>
              <div class="col-md-4">
                <div class="dash-topbar-right d-flex">
                  <div class="topbar-right-btn">
                  </div>
                  
                </div>
              </div>
            </div>
              <form action="<?php echo base_url('useraccount/do-add-permission')?>" id="do-add-permission-form" method="post">
                  <input type="hidden" name="role_id" value="<?php echo $role_id;?>" />
          		<table>
          			<thead>
          				<tr>
          					<th>Module</th>
                                                <th style="text-align: center;">View</th>
                                                <th style="text-align: center;">Add</th>
                                                <th style="text-align: center;">Edit</th>
                                                <th style="text-align: center;">Delete</th>
          				</tr>
          			</thead>
          			<tbody>
                                    <?php if($privilege_module['total']>0){
                                        foreach($privilege_module['result'] as $list){
                                            $access_selected = $this->all_function->permission_assigned_by_org_id_role_id_module_id($this->session->userdata('org_id'),$role_id,$list->module_id);
                                            //print_r($access_selected);exit;
                                        ?>
                                <input type="hidden" name="module_id[]" value="<?php echo $list->module_id?>" />
          				<tr>	
          					
                                                <td><strong><?php echo $list->type;?></strong></td>
                                                <td>
                                                    <input type="checkbox" class="form-control" name="module_view[<?php echo $list->module_id;?>]" value="1" <?php echo (isset($access_selected->view_status) && $access_selected->view_status=='1')?'checked="checked"':'';?> />
          					</td>
                                                <td>
                                                    <input type="checkbox" class="form-control" name="module_add[<?php echo $list->module_id;?>]" value="1" <?php echo (isset($access_selected->add_status) && $access_selected->add_status=='1')?'checked="checked"':'';?> />
          					</td>
                                                <td>
                                                    <input type="checkbox" class="form-control" name="module_edit[<?php echo $list->module_id;?>]" value="1" <?php echo (isset($access_selected->edit_status) && $access_selected->edit_status=='1')?'checked="checked"':'';?> />
          					</td>
                                                <td>
                                                    <input type="checkbox" class="form-control" name="module_delete[<?php echo $list->module_id;?>]" value="1" <?php echo (isset($access_selected->delete_status) && $access_selected->delete_status=='1')?'checked="checked"':'';?> />
          					</td>
          				</tr>
                                    <?php 
                                        }
                                        }?>
          			</tbody>
          		</table>
              <div class="form-group mt-3">
                  <button type="submit">Save Permission</button>
                </div>
              </form>
          	</div>

        </div>
      </div>
    </div>
    <?php $this->load->view('partial/footer_script'); ?>  
       <script>
    $(document).ready(function () {
    $(document).on('submit', '#do-add-permission-form', function (event) {
        event.preventDefault();
        $('.text-danger').html('');
        var url = $(this).attr('action');
        
        var data = new FormData($(this)[0]);
        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            processData: false,
            contentType: false,
            data: data,
            success: function (resp) {
                if (resp.status === 200) {
                    window.location='<?php echo base_url('useraccount/roles');?>';
                } else {
                    $.each(resp.message, function (key, val) {
                        
                        $('#do-add-product-form').find('[name="' + key + '"]').closest('.form-group').find('.text-danger').html(val);
                    });
                }
            }
        }).fail(function () {
        });
    });
    });
    
    </script>
  </body>
</html>
