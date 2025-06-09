<!doctype html>
<html lang="en">
<?php $this->load->view('partial/header_script'); ?>
<body>
<?php $this->load->view('partial/withoutmenu_header'); ?>
<section class="inner-body my-account mt-5">
	<div class="container">
		<div class="row">
		<div class="col-md-12 col-lg-12">
				<div class="my-account-sec">
					<div class="account-box">
						<h3>Your Account</h3>
						<div class="form">
							<div class="company-logo">
							  <img src="<?php echo base_url(); ?>themes/frontend/images/p3.png" alt=""></a>
							</div>
                                                    <form class="login-form" method="post" action="<?php echo base_url('client-mobile-get-otp').'.html'?>" id="client-mobile-get-otp">
                                                        <div>
							  <input type="text" placeholder="Mobile Number" name="client_mobile" required value=""/>
                                                          <span class="text-danger" id="error_client_mobile"></span>
                                                        </div>
							  <input type="submit" value="GET OTP">
							</form>
						  </div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="gallery-sec d-flex">
	<div class="gallery-img"><img src="<?php echo base_url(); ?>themes/frontend/images/g1.png" alt="/"></div>
	<div class="gallery-img"><img src="<?php echo base_url(); ?>themes/frontend/images/g2.png" alt="/"></div>
	<div class="gallery-img"><img src="<?php echo base_url(); ?>themes/frontend/images/g3.png" alt="/"></div>
	<div class="gallery-img"><img src="<?php echo base_url(); ?>themes/frontend/images/g4.png" alt="/"></div>
</section>
<?php $this->load->view('partial/footer'); ?>
<?php $this->load->view('partial/footer_script'); ?>
    <script>
    $(document).on('submit', '#client-mobile-get-otp', function (event) {
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
                    window.location='<?php echo base_url('verify-change-password').'.html'?>';
                }else {
                    $.each(resp.message, function (key, val) {
                        $('#client-mobile-get-otp').find('[name="' + key + '"]').parent().find('#error_' + key).html(val);
                    });
                }
            }
        }).fail(function () {
        });
    });
    </script>
</body>
</html>