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
                  <div class="col-md-2"> 
                      <div class="dash-box" style="margin-left: 0px;">
          			<div class="media">
          				<div class="media-body">
                                            <p style="margin: 0px;">Support</p>
          				</div>
          			</div>
          		</div>
                  </div>  
                  <div class="col-md-10">
                      
                  </div>  
              </div>
            <div class="dash-frm-wrap" style="margin-bottom: 50px;">
              <form action="<?php echo base_url('useraccount/do-support')?>" id="do-support-form" method="post">
                  <div class="row"><span class="alert alert-success" style="display:none;width:95%"></span></div>
                <div class="row">
                  <div class="col-md-7">
                      <div class="row">
                  <div class="col-md-6"> 
                  <div class="form-group">
                      <input type="text" name="email_id" value="<?php echo $user_detail->email;?>" class="form-control" placeholder="Enter Email Address">
                      <span class="text-danger"></span>
                    </div>
                  </div>  
                  <div class="col-md-6">
                      
                  </div>  
              </div>
                    <div class="row">
                  <div class="col-md-6"> 
                  <div class="form-group">
                      <input type="text" name="ticket_subject" class="form-control" placeholder="Raise tickets">
                      <span class="text-danger"></span>
                    </div>
                  </div>  
                  <div class="col-md-6">
                      
                  </div>  
              </div>
                      
                    
                    <div class="form-group">
                        <textarea class="form-control" name="comment" style="height: 360px" placeholder="Write your problem"></textarea>
                        <span class="text-danger"></span>
                    </div>
                    

                  </div>
                  <div class="col-md-5">
                    
                    <div class="frm-map">
                      <img src="<?php echo base_url() ?>themes/useraccount/images/XMLID_2_.png">
                    </div>
                  </div>
                </div>
                <div class="form-group mt-3">
                  <button type="submit">SUBMIT</button>
                </div>
              </form>
            </div>
          </div>


        </div>
      </div>
    </div>
    <?php $this->load->view('partial/footer_script'); ?>  
      <script>
    $(document).ready(function () {
    $(document).on('submit', '#do-support-form', function (event) {
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
                    if (resp.message) {
                        $('#do-support-form').find('.alert-success').html(resp.message).show();
                        $('#do-support-form').trigger("reset");
                    }
                } else {
                    $.each(resp.message, function (key, val) {
                        $('#do-support-form').find('[name="' + key + '"]').closest('.form-group').find('.text-danger').html(val);
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
