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
          					<h2>status of delivery</h2>
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
                    <?php if($notification['total']>0){
                                        foreach($notification['result'] as $list){?>
                    <div class="single-thread">
                      <div class="option-box">
						<?php echo $list->notification;?>
					</div>
                    </div>
                      <?php 
                                        }
                                        }?>
                      
                      
                      
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      
                    </div>
                    <div class="frm-map">
                      <img src="<?php echo base_url() ?>themes/useraccount/images/notification_art.png">
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
