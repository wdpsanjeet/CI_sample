<!doctype html>
<html lang="en">
  <?php $this->load->view('partial/header_script'); ?>
  <body>
<div class="body_sec">
      <?php $this->load->view('partial/left_menu'); ?>
      <div class="rgt_sidebar">
        <div class="rgt_tophead">
        	<?php $this->load->view('partial/top_header'); ?>

          <div class="dash-tbl">
          		<div class="row">
              <div class="col-md-8">
                
              </div>
              <div class="col-md-4">
                <div class="dash-topbar-right d-flex">
                  <div class="topbar-right-btn">
                      
                      <?php 
                      if($access_level[MODULE_ACCESS_TYPE_ADD]){
                      ?>
                      <a href="<?php echo base_url('useraccount/addStaff').'.html'?>"><img src="<?php echo base_url() ?>themes/useraccount/images/plus.png"> Add Staff</a>
                      <?php }?>
                  </div>
                  
                </div>
              </div>
            </div>
          		<table>
          			<thead>
          				<tr>
          					<th>Name</th>
                                                <th>Phone</th>
                                                <th>Role</th>
          				</tr>
          			</thead>
          			<tbody>
                                    <?php if($staffs['total']>0){
//                                        if($accessType=='staff'){
//                                            $edit_access = $this->all_function->permission_access_view_add_edit_delete($this->session->userdata('org_id'),$role_id,$privilege_module,'edit');
//                                        }
                                        foreach($staffs['result'] as $list){
                                        ?>
          				<tr>	
          					
                                                <td><strong><?php echo $list->username;?></strong></td>
                                                <td><strong><?php echo $list->phone;?></strong></td>
                                                <td><strong><?php echo $list->role_name;?></strong></td>
          				</tr>
                                    <?php 
                                        }
                                        }?>
          			</tbody>
          		</table>
          	</div>

        </div>
      </div>
    </div>
    <?php $this->load->view('partial/footer_script'); ?>  
       
  </body>
</html>
