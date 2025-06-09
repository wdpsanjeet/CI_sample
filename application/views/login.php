<!doctype html>
<html lang="en">
<?php $this->load->view('partial/header_script'); ?>
<body>
<?php $this->load->view('partial/header'); ?>
    <div class="body_wrapper">
        <?php $this->load->view('partial/header_menu'); ?>
<section class="breadcrumb_area">
            <img class="breadcrumb_shap" src="<?php echo base_url().'themes/frontend/'?>img/breadcrumb/banner_bg.png" alt="">
            <div class="container">
                <div class="breadcrumb_content text-center">
                    <h1 class="f_p f_700 f_size_50 w_color l_height50 mb_20">Sign In</h1>
                    <p class="f_400 w_color f_size_16 l_height26">Enter your phone and OTP to sign in to your Varthak Account.</p>
                </div>
            </div>
        </section>
        <section class="sign_in_area bg_color sec_pad">
            <div class="container">
                <div class="sign_info">
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="sign_info_content">
                                <h3 class="f_p f_600 f_size_24 t_color3 mb_40">First time here?</h3>
                                <h2 class="f_p f_400 f_size_30 mb-30">Try our Varthak account<br> to enhance your  <br> business today!</h2>
                                <ul class="list-unstyled mb-0">
                                    <li><i class="ti-check"></i> Free Based</li>
                                    <li><i class="ti-check"></i> Saas-Based</li>
                                    <li><i class="ti-check"></i> Unlimited User Accounts</li>
                                </ul>
                                <a href="<?php echo base_url().'signup.html'?>" class="btn_three sign_btn_transparent">Sign Up</a>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="login_info">
                                <h2 class="f_p f_600 f_size_24 t_color3 mb_40">Sign In</h2>
                                <form action="<?php echo base_url('do-login')?>" class="login-form sign-in-form" id="do-login-form">
                                    <?php $success_msg = $this->session->userdata('success_msg');
                                    $flash_message = $this->session->flashdata('flash_success');
                                    if($success_msg!=''){
                                        $success = $success_msg;
                                    }else{
                                        $success = $flash_message;
                                    }
                                    ?>
                                    <div class="alert alert-success" role="alert" id="global_succmsg" <?php echo ($success=='')?'style="display:none;z-index: 999;margin-top:5px;"':'';?>>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <strong>Success!</strong> <?php echo $success;?>
                                    <?php $this->session->set_userdata('success_msg','');?>
                                    </div>
                                    <div class="form-group text_box" id="phone_div">
                                        <label class="f_p text_c f_400">Phone</label>
                                        <input type="text" name="phone" placeholder="94xxxxxx98">
                                        <span class="text-danger"></span>
                                    </div>
                                    <div class="form-group text_box" style="display:none" id="otp_box">
                                        <label class="f_p text_c f_400">Verify OTP</label>
                                        <p class="text-success" id="success_otp"></p>
                                        <input type="text" name="otp" placeholder="******">
                                        <span class="text-danger"></span>
                                        <div id="some_div"></div>
                                        <a href="javascript:;" onclick="reSendOTP()" id="resendLink" style="display:none" class="resentotpcls">Resent OTP</a>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <button type="submit" class="btn_three" id="submit_btn">Send OTP</button>
                                        <div class="social_text d-flex ">
<!--                                            <div class="lead-text">Are you Staff ? <a href="<?php echo base_url('staff-login');?>">Login here</a></div>
                                            <ul class="list-unstyled social_tag mb-0">
                                                <li><a href="#"><i class="ti-facebook"></i></a></li>
                                                <li><a href="#"><i class="ti-twitter-alt"></i></a></li>
                                                <li><a href="#"><i class="ti-google"></i></a></li>
                                            </ul>-->
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
<?php $this->load->view('partial/footer'); ?>
</div>
<?php $this->load->view('partial/footer_script'); ?>
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
    //alert("Hi");
    $("#resendLink").show();
}
      function reSendOTP(){
          timeLeft = 60;
          timerId = setInterval(countdown, 1000);
          var url = '<?php echo base_url().'resendotp'?>';
        var data = new FormData();
        data.append("phone", $("input[name*='phone']").val());
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
                        $('#login-form').find('[name="' + key + '"]').closest('.mb-3').find('.text-danger').html(val);
                    });
                }
            }
        }).fail(function () {
        });
      }
      
    $(document).ready(function () {
    $(document).on('submit', '#do-login-form', function (event) {
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
                    if(resp.otp_verification=='0'){
                        clearTimeout(timerId);
                        timeLeft = 60;
                        timerId = setInterval(countdown, 1000);
                        $("#phone_div").hide();
                        $("#otp_box").show();
                        $("#submit_btn").html('Verify OTP');
                        $("#success_otp").html(resp.message);
                        $("#do-login-form").attr('action','<?php echo base_url('verify-otp').'.html'?>');
                    }else if(resp.otp_verification=='1'){
                        if(resp.subdomain!=''){
                            var data_subdomain = new FormData();
                            data_subdomain.append("email", resp.email);
                            data_subdomain.append("password", resp.password);
                               $.ajax({
                                url: resp.subdomain_login,
                                type: 'POST',
                                dataType: 'json',
                                processData: false,
                                contentType: false,
                                data: data_subdomain,
                                success: function (subdomainresp) {
                                    if (subdomainresp.status === 200) {
                                        if (subdomainresp.message) {
                                            //alert(resp.subdomain+'/useraccount/dashboard.html');
                                            window.location.href = resp.subdomain+'/useraccount/dashboard.html';
                                        }
                                    } 
                                }
                            }).fail(function () {
                            });
                        }else{
                            window.location.href = "<?php echo base_url('useraccount/dashboard').'.html'?>";
                        }
                    }
                    
                } else {
                
                    $.each(resp.message, function (key, val) {
                        $('#do-login-form').find('[name="' + key + '"]').closest('.form-group').find('.text-danger').html(val);
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