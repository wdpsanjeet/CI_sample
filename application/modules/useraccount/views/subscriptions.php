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
              <div class="row">
                  <div class="col-md-3"> 
                  <div class="dash-box">
          			<div class="media">
          				<div class="media-body">
          					<h2>Subscriptions management</h2>
          				</div>
          			</div>
          		</div>
                  </div>  
                  <div class="col-md-9">
                      
                  </div>  
              </div>
           
            <div class="dash-frm-wrap" style="margin-bottom: 50px;">
                <div class="row">
                  <div class="col-md-8">
                    <div class="row">
                      <div class="col-md-7">
                        <div class="dash-box">
          			<div class="media">
                                    <span class="subsmgmplan_lbl"><?php echo $user_exist_plan->plan_name;?></span>
          				<div class="media-body">
          					<h2>Plan</h2>
          				</div>
                                    <div class="media-price-right"><span class="dollar"><?php echo $user_exist_plan->plan_price;?></span></div>
                                    
          			</div>
                            <p class="totUsr">12 of 20 User</p>
                            <div class="media">
                                
                                    <div class="progress" style="height:10px;width: 60%;">
                                        <div class="progress-bar"
                                             style="width:80%;height:30px;background-color: #fa00ab;">
                                        </div>
                                    </div>
                                <div class="media-price-right"><div class="upgrade-btn text-right" style=""><a href="<?php echo base_url('useraccount/updateSubscriptions').'.html';?>"> Upgrade Plan <img src="<?php echo base_url();?>themes/useraccount/images/right_arrow.png"></a></div></div>
                                    
          			</div>
                            
                            
          		</div>
                      </div>
                      <div class="col-md-5">
                        <div class="dash-box">
          			<div class="media">
                                    <p style="margin-top: 35px;">Next Payment</p>
          			</div>
                            <div class="media">
                                <p><strong>on <?php echo date('M d, Y',strtotime($user_detail->expired_date));?></strong></p>
          			</div>
                            <div class="media">
                                
                                    <div class="manage-btn text-right" style=""><a href="#"> Manage Payments</a></div>
                                    
          			</div>
                            
                            
          		</div>
                      </div>
                    </div>
                    
                    <div class="single-thread">
                      <div class="option-box">
						1. Lorem Ipsum has been the industry's standard dummy text ever <img src="<?php echo base_url() ?>themes/useraccount/images/dwncircle.png">
					</div>
                    </div>
                      <div class="single-thread">
                      <div class="option-box">
						1. Lorem Ipsum has been the industry's standard dummy text ever <img src="<?php echo base_url() ?>themes/useraccount/images/dwncircle.png">
					</div>
                    </div>
                      <div class="single-thread">
                      <div class="option-box">
						1. Lorem Ipsum has been the industry's standard dummy text ever <img src="<?php echo base_url() ?>themes/useraccount/images/dwncircle.png">
					</div>
                    </div>
                      <div class="single-thread">
                      <div class="option-box">
						1. Lorem Ipsum has been the industry's standard dummy text ever <img src="<?php echo base_url() ?>themes/useraccount/images/dwncircle.png">
					</div>
                    </div>
                      <div class="single-thread">
                      <div class="option-box">
						1. Lorem Ipsum has been the industry's standard dummy text ever <img src="<?php echo base_url() ?>themes/useraccount/images/dwncircle.png">
					</div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      
                    </div>
                    <div class="frm-map">
                      <img src="<?php echo base_url() ?>themes/useraccount/images/subscription_mgm.png">
                    </div>
                  </div>
                </div>
                
            </div>
          </div>


        </div>
      </div>
    </div>
    <?php $this->load->view('partial/footer_script'); ?>  
      
  </body>
</html>
