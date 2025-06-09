<!doctype html>
<html lang="en">
<?php $this->load->view('partial/header_script'); ?>
    <link rel="stylesheet" href="<?php echo base_url().'themes/frontend/css/'?>jquery.datetimepicker.min.css" >
<body>

<section class="inner-body login-account loginform_page p-5">
    <div class="container">
      <div class="row no-gutters shadow-lg">
        <div class="col-md-12 bg-white left_col">
            <div class="form_update_comp"> 
              <div class="logo_form"><img src="<?php echo base_url(); ?>themes/frontend/images/logo.png" alt=""></div>
              
              <div class="form-style">
                  <form action="<?php echo base_url('do-update-shop-information').'.html';?>" method="post" id="do-signup">
                      <div class="row">
                          <div class="col-md-6">
                              <div class="form-group pb-2">    
                                  <input type="text" placeholder="Enter Your Shop Name" class="form-control" name="shop_name" id="company_name" aria-describedby="emailHelp"> 
                                  <span class="text-danger"></span>
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="form-group pb-2">    
                                  <input type="text" placeholder="Enter Your Shop Address" class="form-control" name="shop_address" id="manager_name" aria-describedby="emailHelp">  
                                  <span class="text-danger"></span>
                              </div>
                          </div>
                      </div>
                      
                      <div class="row">
                          
                          <div class="col-md-6">
                              <div class="form-group pb-2">
                                  <select class="form-control" name="shop_type">
                                      <option value="">Shop Type</option>
                                      <?php foreach($shop_type as $list){?>
                                      <option value="<?php echo $list->shop_type;?>"><?php echo $list->type_name;?></option>
                                      <?php }?>
                                  </select>
                                  <span class="text-danger"></span>
                              </div>
                          </div>
                          <div class="col-md-3">
                              <div class="form-group pb-2">
                                  <input type="text" placeholder="Delivery start time" class="form-control" name="delivery_start_time" id="delivery_start_time" aria-describedby="emailHelp">
                                  <span class="text-danger"></span>
                              </div>
                          </div>
                          <div class="col-md-3">
                              <div class="form-group pb-2">
                                  <input type="text" placeholder="Delivery end time" class="form-control" name="delivery_end_time" id="delivery_end_time" aria-describedby="emailHelp">
                                  <span class="text-danger"></span>
                              </div>
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-md-6">
                              <div class="form-group pb-2">    
                                  <input type="text" placeholder="City" class="form-control" name="shop_city" id="client_city" aria-describedby="emailHelp">   
                                  <span class="text-danger"></span>
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="form-group pb-2">    
                                  <input type="text" placeholder="State" class="form-control" name="shop_state" id="client_state" aria-describedby="emailHelp"> 
                                  <span class="text-danger"></span>
                              </div>
                          </div>
                          
                      </div>
                      <div class="row">
                          <div class="col-md-6">
                              <div class="form-group pb-2">    
                                  <input type="text" placeholder="Pincode" class="form-control" name="shop_pincode" id="client_pincode" aria-describedby="emailHelp"> 
                                  <span class="text-danger"></span>
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="form-group pb-2">    
                                  <input type="text" placeholder="Enter Your GST Number" class="form-control" name="gst_number" id="gst_number" aria-describedby="emailHelp"> 
                                  <span class="text-danger"></span>
                              </div>
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-md-6">
                              <div class="form-group pb-2">    
                                  <div class="form-check">
                                      <input type="checkbox" class="form-check-input" id="whatappCheck" name="is_whatapp_yes" value="1">
                                    <label class="form-check-label" for="whatappCheck">I want to receive communications from Brandket on Whastapp</label>
                                  </div>
                                  <span class="text-danger"></span>
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="form-group pb-2">    
                                  <div class="form-check">
                                      <input type="checkbox" class="form-check-input" id="TCCheck" name="tc_check">
                                    <label class="form-check-label" for="TCCheck">I agree to Brandket Terms& Condition</label>
                                  </div>
                                  <span class="text-danger"></span>
                              </div>
                          </div>
                      </div>
                    <div class="row align-items-center">
                      <div class="col-sm-6">
                        <button type="submit" class="signup_btn">Submit</button>
                      </div>
<!--                      <div class="col-sm-6 text-right">
                        <a href="#" class="forgot_pass">Forgot Password?</a>
                      </div>-->
                    </div>
                </form>            
              </div>
            </div>
            
        </div>
                
      </div>
   </div>
  </section>
<?php $this->load->view('partial/footer_script'); ?>
    <script src="<?php echo base_url().'themes/frontend/js/';?>jquery.datetimepicker.full.min.js"></script>
    <script>
        $.datetimepicker.setLocale('en');
        $('#delivery_start_time').datetimepicker({
	datepicker:false,
	format:'H:i'
});
$('#delivery_end_time').datetimepicker({
	datepicker:false,
	format:'H:i'
});
    $(document).ready(function () {
    $(document).on('submit', '#do-signup', function (event) {
        event.preventDefault();
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
                    window.location = '<?php echo base_url();?>';
                } else {
                    $.each(resp.message, function (key, val) {
                        $('#do-signup').find('[name="' + key + '"]').closest('.form-group').find('.text-danger').html(val);
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