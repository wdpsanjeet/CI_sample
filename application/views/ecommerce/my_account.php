<!doctype html>
<html lang="en">
<?php $this->load->view('ecommerce/partial/header_script'); ?>
<body>
<?php $this->load->view('ecommerce/partial/withoutmenu_header'); ?>
<section class="inner-body my-account mt-5">
	<div class="container">
		<div class="row">
		<div class="col-md-12 col-lg-12">
				<div class="my-account-sec">
					<div class="account-box">
						<h3>Your Account</h3>
						<div class="form">
							<div class="company-logo">
							  <img src="<?php echo base_url(); ?>themes/ecommerce/images/p3.png" alt=""></a>
							</div>
							<form action="<?php echo base_url($domain_name.'/ecomm-update-account').'.html';?>" method="post" id="update-account">
                                                            <div class="alert alert-success" role="alert" id="global_succmsg" style="display:none">
                                                                <button type="button" class="close glbclose" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                <strong>Success! </strong><span id="success_msg"> Account has been updated!</span>
                                                            </div>
                                                            <div id="phone_div">
                                                            <input type="text" placeholder="Phone Number" name="client_mobile" required value="<?php echo $userDetail->client_mobile;?>"/>
                                                          <span class="text-danger" id="error_client_mobile"></span>
                                                            </div>
                                                            <div id="email_div">
                                                          <input type="email" placeholder="Email Address" name="client_email" required value="<?php echo $userDetail->client_email;?>"/>
                                                          <span class="text-danger" id="error_client_email"></span>
                                                          </div>
                                                            <div id="otp" style="display:none">
                                                            <input type="text" placeholder="OTP" name="otp" value=""/>
                                                            <span class="text-danger" id="error_otp"></span>
                                                            <span class="text-success" id="succ_otp"></span>
                                                            </div>
							  <input type="submit" value="EDIT ACCOUNT">
							</form>
						  </div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="gallery-sec d-flex">
	<div class="gallery-img"><img src="<?php echo $this->all_function->get_cms_by_page_section_type($org_id,'Footer-Gallary', 'slide-1','image'); ?>" onError="this.onerror=null;this.src='<?php echo base_url(); ?>themes/ecommerce/images/g1.png';" alt="/"></div>
	<div class="gallery-img"><img src="<?php echo $this->all_function->get_cms_by_page_section_type($org_id,'Footer-Gallary', 'slide-2','image'); ?>" onError="this.onerror=null;this.src='<?php echo base_url(); ?>themes/ecommerce/images/g2.png';" alt="/"></div>
	<div class="gallery-img"><img src="<?php echo $this->all_function->get_cms_by_page_section_type($org_id,'Footer-Gallary', 'slide-3','image'); ?>" onError="this.onerror=null;this.src='<?php echo base_url(); ?>themes/ecommerce/images/g3.png';" alt="/"></div>
	<div class="gallery-img"><img src="<?php echo $this->all_function->get_cms_by_page_section_type($org_id,'Footer-Gallary', 'slide-4','image'); ?>" onError="this.onerror=null;this.src='<?php echo base_url(); ?>themes/ecommerce/images/g4.png';" alt="/"></div>
</section>
<?php $this->load->view('ecommerce/partial/footer'); ?>
<?php $this->load->view('ecommerce/partial/footer_script'); ?>
    <script>
    $(document).on('submit', '#update-account', function (event) {
        event.preventDefault();
        var url = $(this).attr('action');
        var data = new FormData($(this)[0]);
        $(".text-danger").html('');
        $(".text-success").html('');
        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            processData: false,
            contentType: false,
            data: data,
            success: function (resp) {
                if (resp.status === 200) {
                    $("#global_succmsg").show();
                    $("#phone_div").show();
                    $("#email_div").show();
                    $("#otp").val('').hide();
                }else if(resp.status === 400){
                    $("#phone_div").hide();
                    $("#email_div").hide();
                    $.each(resp.message, function (key, val) {
                        $('#update-account').find('[name="' + key + '"]').parent().find('#succ_otp').html(val);
                    });
                    $("#otp").show();
                }else {
                    $.each(resp.message, function (key, val) {
                        $('#update-account').find('[name="' + key + '"]').parent().find('#error_' + key).html(val);
                    });
                }
            }
        }).fail(function () {
        });
    });
    </script>
</body>
</html>