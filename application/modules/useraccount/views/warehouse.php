<!doctype html>
<html lang="en">
  <?php $this->load->view('partial/header_script'); ?>
  <body>
<div class="body_sec">
      <?php $this->load->view('partial/left_menu'); ?>
      <div class="rgt_sidebar">
        <div class="rgt_tophead">
        	<?php $this->load->view('partial/top_header'); ?>


<!--          <div class="rgt-sidebar-body">
              <div class="block-title">
                            <a href="<?php echo base_url('admin/blogs/add'); ?>" class="btn pull-right">
                                <i class="fa fa-plus-circle"></i> Add Client</a>
                        </div>
              <div></div>
          </div>-->
          <div class="dash-tbl">
          		<div class="row">
              <div class="col-md-8">
                
              </div>
              <div class="col-md-4">
                <div class="dash-topbar-right d-flex">
                  <div class="topbar-right-btn">
                      <a href="<?php echo base_url('useraccount/add-warehouse').'.html'?>"><img src="<?php echo base_url() ?>themes/useraccount/images/plus.png"> Add Warehouse</a>
                  </div>
<!--                  <div class="dropdown ml-2">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Category
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                      <a class="dropdown-item" href="#">Supermarket</a>
                      <a class="dropdown-item" href="#">Restaurant</a>
                      <a class="dropdown-item" href="#">Other</a>
                    </div>
                  </div>-->
                </div>
              </div>
            </div>
          		<table>
          			<thead>
          				<tr>
          					<th>Warehouse Name</th>
          					<th>Address</th>
          					<th></th>
          				</tr>
          			</thead>
          			<tbody>
                                    <?php if($clients['total']>0){
                                        foreach($clients['result'] as $list){
                                        ?>
          				<tr>	
          					
                                                <td><strong><?php echo $list->warehouse_name;?></strong></td>
          					<td><?php echo $list->warehouse_address;?></td>
                                                <td style="min-width: 70px;">
          						<a href="<?php echo base_url('useraccount/edit-warehouse/').$list->warehouse_id.'.html'?>" class="edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
          					</td>
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
