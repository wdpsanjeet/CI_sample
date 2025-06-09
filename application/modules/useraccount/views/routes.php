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
          			<div class="dash-tbl-topbar d-flex">
          			<div class="select-wrap">
          				<label>Date:</label>
          				<div class="dropdown">
						  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						    Enabled
						  </button>
						  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
						    <a class="dropdown-item" href="#">Enabled</a>
						    <a class="dropdown-item" href="#">Disabled</a>
						  </div>
						</div>
          			</div>
          			<div class="select-wrap">
          				<label>Payment:</label>
          				<div class="dropdown">
						  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						    Paid
						  </button>
						  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
						    <a class="dropdown-item" href="#">Paid</a>
						    <a class="dropdown-item" href="#">Unpaid</a>
						  </div>
						</div>
          			</div>
          			<div class="select-wrap">
          				<label>Status:</label>
          				<div class="dropdown">
						  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						    Yes
						  </button>
						  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
						    <a class="dropdown-item" href="#">Yes</a>
						    <a class="dropdown-item" href="#">No</a>
						  </div>
						</div>
          			</div>
          		</div>
          		</div>
          		<table>
          			<thead>
          				<tr>
          					<th>Client Name</th>
          					<th>Driver Name</th>
          					<th>Address</th>
                                                <th>Location</th>
                                                <th>Route</th>
          					<th>Start</th>
          					<th>End</th>
          					<th>Kms</th>
                                                <th>Amount</th>
                                                <th>Payment</th>
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
                                                    $location_address = $list->client_address;
                                                }else{
                                                    $location_name = $list->customer_name;
                                                    $location_address = $list->address;
                                                }
                                                
                                                if($list->trip_status=='0'){
                                                    $status_text='Pending';
                                                    $status_class='btn-warning';
                                                }else{
                                                    $status_text='Completed';
                                                    $status_class='btn-success';
                                                }
                                                $is_trip_payment = $this->all_function->is_trip_payment_done_by_assigned_trip_id($list->assigned_trip_id);
                                                if($is_trip_payment){
                                                    $paid_text_html='<div class="link-btn"><a href="javascript:;" class="" >Paid</a></div>';
                                                }else{
                                                    $paid_text_html = '<div class="link-btn"><a href="javascript:;" class="gray" >Pending</a></div>';
                                                }
                                                $is_trip_completed = $this->all_function->is_trip_completed_by_assigned_trip_id($list->assigned_trip_id);
                                                if($is_trip_completed){
                                                    $trip_completed_html='<button type="button" class="btn btn-success">Completed</button>';
                                                }else{
                                                    $trip_completed_html = '<button type="button" class="btn btn-warning">Pending</button>';
                                                }
                                            ?>
          				<tr>	
          					
          					<td><?php echo $location_name?></td>
          					<td><?php echo $list->driver_name?></td>
          					<td><?php echo $location_address?></td>
          					<td><?php echo $list->order_list?></td>
          					
          					<td><?php echo $list->route_name?></td>
                                                <td><?php echo date('d/M/Y', strtotime($list->trip_start_time))?><br><?php echo date('h:i:s a', strtotime($list->trip_start_time))?></td>
                                                <td><?php echo date('d/M/Y', strtotime($list->trip_end_time))?><br><?php echo date('h:i:s a', strtotime($list->trip_end_time))?></td>
                                                <td><?php echo $list->distance?>Km</td>
                                                <td><?php echo 2*$list->distance;?> INR</td>
          					<td>
          						<?php echo $paid_text_html;?>
          					</td>
                                                <td>
          						<?php echo $trip_completed_html;?>
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
