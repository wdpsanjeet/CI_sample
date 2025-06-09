<!doctype html>
<html lang="en">
  <?php $this->load->view('partial/header_script'); ?>
  <body>
<div class="body_sec">
      <?php $this->load->view('partial/left_menu'); ?>
      <div class="rgt_sidebar">
        <div class="rgt_tophead">
        	<?php $this->load->view('partial/top_header'); ?>


          <div class="rgt-sidebar-body">

            <div class="dash-frm-wrap" style="margin-bottom: 50px;">
                <div class="row">
                    <div class="col-md-7" style="background-color: #ffebf9;">

                    <div class="row mt-3">
                      <div class="col-md-3">
                          <strong>Name:</strong>
                      </div>
                      <div class="col-md-6">
                        <strong><?php echo $model->name;?></strong>
                      </div>
                        <div class="col-md-3 viewclientprofile text-right">
                            <img src="<?php echo base_url();?>uploads/profile_img/original/<?php echo $model->personal_pic;?>" class="userimg">
                      </div>
                    </div>
                    
                    
                      <div class="row mt-3">
                      <div class="col-md-3">
                        <strong>Mob No:</strong>
                      </div>
                      <div class="col-md-9">
                        <strong><?php echo $model->phone;?></strong>
                      </div>
                    </div>
                     
                        <div class="row mt-3">
                      <div class="col-md-3">
                        <strong>Vehicle Number:</strong>
                      </div>
                      <div class="col-md-9">
                        <strong><?php echo $model->truck_number;?></strong>
                      </div>
                    </div>
                      <div class="row mt-3">
                      <div class="col-md-3">
                        <strong>Last Delivery Date and Time:</strong>
                      </div>
                      <div class="col-md-9">
                        <strong><?php echo (isset($LastDeliveryDate->assigned_date))?date('d/M/Y',strtotime($LastDeliveryDate->assigned_date)):'No Last Delivery Yet';?></strong>
                      </div>
                    </div>
                      <div class="row mt-3">
                      <div class="col-md-3">
                        <strong>Total Trips:</strong>
                      </div>
                      <div class="col-md-9">
                        <strong><?php 
                        $total_driven_trip = $this->all_function->get_driver_total_driven_trip($driver_id);
                        ?><?php echo ($total_driven_trip!='')?$total_driven_trip:'0';?></strong>
                      </div>
                    </div>
                        <div class="row mt-3">
                      <div class="col-md-3">
                        <strong>Total Deliveries:</strong>
                      </div>
                      <div class="col-md-9">
                        <strong><?php 
                        $driver_total_deliveries = $this->all_function->get_driver_total_deliveries($driver_id);
                        ?><?php echo ($driver_total_deliveries!='')?$driver_total_deliveries:'0';?></strong>
                      </div>
                    </div>
                        <div class="row mt-3">
                      <div class="col-md-3">
                      </div>
                      <div class="col-md-9">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-5">
                    
                  </div>
                </div>
                <div class="form-group mt-3 def-btn">
                    <a href="<?php echo base_url('useraccount/routes/').$driver_id.'.html'?>">View Trips</a>
                </div>
            </div>
          </div>


        </div>
      </div>
    </div>
    <?php $this->load->view('partial/footer_script'); ?>  
      
  </body>
</html>
