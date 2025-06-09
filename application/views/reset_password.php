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
                    <h1 class="f_p f_700 f_size_50 w_color l_height50 mb_20">Reset your password</h1>
                    <p class="f_400 w_color f_size_16 l_height26">Reset your password here to sign in to your Varthak Account.</p>
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
                                <a href="<?php echo base_url().'login.html'?>" class="btn_three sign_btn_transparent">Sign In</a>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="login_info">
                                <h2 class="f_p f_600 f_size_24 t_color3 mb_40">Reset your password</h2>
                                <form action="<?php echo base_url('do-reset-password')?>" class="login-form sign-in-form" id="do-reset-password-form" method="post">
                                    <input type="hidden" name="id" value="<?php echo $id;?>">
                                    <div class="row"><span class="alert alert-success" style="display:none;width:95%"></span></div>
                                    <div class="form-group text_box">
                                        <label class="f_p text_c f_400">New Password</label>
                                        <input type="password" name="password" placeholder="xxxxxxx">
                                        <span class="text-danger"></span>
                                    </div>
                                    <div class="form-group text_box">
                                        <label class="f_p text_c f_400">Confirm Password</label>
                                        <input type="password" name="confirm_password" placeholder="xxxxxxx">
                                        <span class="text-danger"></span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <button type="submit" class="btn_three">Reset Password</button>
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
    $(document).ready(function () {
    $(document).on('submit', '#do-reset-password-form', function (event) {
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
                        window.location.href = "<?php echo base_url('login').'.html'?>";
                    }
                } else {
                    $.each(resp.message, function (key, val) {
                        $('#do-reset-password-form').find('[name="' + key + '"]').closest('.form-group').find('.text-danger').html(val);
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