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
							<form class="login-form">
                                                            <input type="text" placeholder="Enter OTP" name="otp" required value=""/>
							  <input type="password" placeholder="Password" required value=""/>
                                                          <input type="password" placeholder="Confirm Password" required value=""/>
							  <input type="submit" value="UPDATE">
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
</body>
</html>