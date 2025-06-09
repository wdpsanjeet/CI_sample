<!doctype html>
<html lang="en">
<?php $this->load->view('ecommerce/partial/header_script'); ?>
<body>

<section class="inner-body login-account loginform_page p-5">
    <div class="container">
      <div class="row no-gutters shadow-lg">
        <div class="col-md-7 bg-white left_col">
            <div class="form_sec"> 
              <div class="logo_form"><img src="<?php echo $this->all_function->get_cms_by_page_section_type($org_id,'Home-Page', 'Logo','image'); ?>" onError="this.onerror=null;this.src='<?php echo base_url(); ?>themes/frontend/img/Vlogo.png';" alt=""></div>
              <h3 class="subheading">
                <?php 
                  $timeOfDay = date('a');
    if($timeOfDay == 'am'){
        echo  'Good Morning';
    }else{
        echo  'Good Afternoon';
    }
                  ?>
              </h3>
              <div class="small_head">
                This day will be great
              </div>
              <div class="form-style">
                  <form action="<?php echo base_url($domain_name.'/ecomm-do-signup').'.html';?>" method="post" id="do-signup">
                      <div class="form-group pb-2" id="mobile_number_div">    
                        <input type="text" placeholder="Mobile Number" class="form-control" name="client_mobile" id="client_mobile" aria-describedby="emailHelp">   
                        <span class="text-danger"></span>
                      </div>
                      <div class="form-group pb-2" id="otp_verify_div" style="display:none">    
                        <input type="text" placeholder="Enter OTP" class="form-control" name="otp" id="otp" aria-describedby="emailHelp"> 
                        <span class="text-success"></span>
                        <div id="some_div"></div>
                        <a href="javascript:;" onclick="reSendOTP()" id="resendLink" style="display:none" class="resentotpcls">Resent OTP</a>
                    </div>
                    <div class="row align-items-center">
                      <div class="col-sm-6">
                        <button type="submit" class="signup_btn">SignUp</button>
                      </div>
<!--                      <div class="col-sm-6 text-right">
                        <a href="#" class="forgot_pass">Forgot Password?</a>
                      </div>-->
                    </div>
                </form>            
              </div>
            </div>
            <div class="login-link">
              Already have an account? <strong><a href="<?php echo base_url($domain_name.'/ecomm-login').'.html'?>">Login</a></strong>  or <strong><a href="<?php echo base_url($domain_name.'/index').'.html'?>">Back to Home</a></strong>
            </div>
        </div>
        <div class="col-md-5 d-none d-md-block form-right-part">
            <img src="<?php echo base_url(); ?>themes/ecommerce/images/g1.png" class="img-fluid" style="min-height:100%; object-fit: cover;" />
            <div class="middle-part">
              <div class="border-left-long"> 
              </div>
              <div class="haed_text"><?php echo $this->all_function->get_cms_by_page_section_type('Signup-Page', 'Signup-Page-right-side-title'); ?></div>
              <div class="para">
                <?php echo $this->all_function->get_cms_by_page_section_type('Signup-Page', 'Signup-Page-right-side-description'); ?>
              </div>
            </div>
            <div class="address">
              <i class="fa fa-map-marker" aria-hidden="true"></i>
              <div class="address_text">
                <?php echo $this->all_function->get_cms_by_page_section_type('Signup-Page', 'Signup-Page-right-side-address-text'); ?>
                
              </div>
            </div>
        </div>        
      </div>
   </div>
  </section>
<?php $this->load->view('ecommerce/partial/footer_script'); ?>
    <script>
        var timeLeft = 2;
var elem = document.getElementById('some_div');
var timerId = setInterval(countdown, 1000);

function countdown() {
    $("#resendLink").hide();
    if (timeLeft == -1) {
        clearTimeout(timerId);
        elem.innerHTML='';
        doSomething();
    } else {
        elem.innerHTML = timeLeft + ' seconds remaining';
        timeLeft--;
    }
}

function doSomething() {
    $("#resendLink").show();
}
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
                    $("#mobile_number_div").hide();
                    $("#otp_verify_div").show();
                    $(".signup_btn").text('Verify-OTP');
                    $.each(resp.message, function (key, val) {
                        $('#do-signup').find('[name="' + key + '"]').closest('.form-group').find('.text-success').html(val);
                    });
                    $("#do-signup").attr('action','<?php echo base_url($domain_name.'/ecomm-verify-otp').'.html'?>');
                } else if(resp.status === 300){
                //location.reload();
                window.location = '<?php echo base_url($domain_name.'/ecomm-update-company-information').'.html';?>';
                } else if(resp.status === 100){
                //location.reload();
                window.location = '<?php echo base_url();?>';
                }else {
                    $.each(resp.message, function (key, val) {
                        $('#do-signup').find('[name="' + key + '"]').closest('.form-group').find('.text-danger').html(val);
                    });
                }
            }
        }).fail(function () {
        });
    });
    function reSendOTP(){
          timeLeft = 60;
          timerId = setInterval(countdown, 1000);
          var url = '<?php echo base_url($domain_name).'/ecomm-resendotp.html'?>';
        var data = new FormData();
        data.append("client_mobile", $("input[name*='client_mobile']").val());
        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            processData: false,
            contentType: false,
            data: data,
            success: function (resp) {
                if (resp.status === 200) {
                        clearTimeout(timerId);
                        timeLeft = 60;
                        timerId = setInterval(countdown, 1000);
                } else {
                    $.each(resp.message, function (key, val) {
                        $('#login-form').find('[name="' + key + '"]').closest('.pb-2').find('.text-danger').html(val);
                    });
                }
            }
        }).fail(function () {
        });
      }
    </script>
</body>
</html>