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
                      <a href="<?php echo base_url('useraccount/add-organisation').'.html'?>"><img src="<?php echo base_url() ?>themes/useraccount/images/plus.png"> Add Organisation</a>
                  </div>
                  
                </div>
              </div>
            </div>
          		<table>
          			<thead>
          				<tr>
          					<th>Organisation Name</th>
          					<th>Organization ID</th>
          					<th>Created Date</th>
          				</tr>
          			</thead>
          			<tbody>
                                        <?php foreach($organisation as $list){
                                        ?>
          				<tr>	
          					
                                                <td><strong><?php echo $list->org_name;?></strong></td>
          					<td><?php echo $list->company_code;?></td>
                                                <td>
          						<?php echo date('d/m/Y',strtotime($list->added_at));?>
          					</td>
          				</tr>
                                    <?php 
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
