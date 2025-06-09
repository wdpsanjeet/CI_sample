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
          		<div class="dash-tbl-topbar d-flex">
          			
          		</div>
          		<table>
          			<thead>
          				<tr>
          					<th>Client Name</th>
          					<th>Driver</th>
          					<th>Mobile No</th>
          					<th>Address</th>
          					<th>Date</th>
          					<th>Time</th>
          					<th>Route</th>
          					<th>Status</th>
          				</tr>
          			</thead>
          			<tbody>
                                    <?php if($deliveries['total']>0){
                                        foreach($deliveries['result'] as $list){
                                                $location_name = '';
                                                $location_mobile = '';
                                                $location_address = '';
                                                if($list->type==0){
                                                    $location_name = $list->company_name;
                                                    $location_mobile = $list->client_mobile;
                                                    $location_address = $list->client_address;
                                                }else{
                                                    $location_name = $list->customer_name;
                                                    $location_mobile = $list->mobile_number;
                                                    $location_address = $list->address;
                                                }
                                                
                                                if($list->trip_status=='0'){
                                                    $status_text='Pending';
                                                    $status_class='btn-warning';
                                                }else{
                                                    $status_text='Completed';
                                                    $status_class='btn-success';
                                                }
                                                ?>
          				<tr>	
          					
          					<td><?php echo $location_name?></td>
          					<td><?php echo $list->driver_name?></td>
          					<td><?php echo $location_mobile?></td>
          					<td><?php echo $location_address?></td>
          					<td><?php echo date('d/M/Y', strtotime($list->delivered_at))?> </td>
          					<td><?php echo date('h:i:s a', strtotime($list->delivered_at))?></td>
          					<td><?php echo $list->route_name?></td>
          					<td>
          						<button type="button" class="btn <?php echo $status_class;?>"><?php echo $status_text;?></button>
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
