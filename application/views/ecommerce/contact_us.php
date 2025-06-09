<!doctype html>
<html lang="en">
<?php $this->load->view('ecommerce/partial/header_script'); ?>
<body>
<?php $this->load->view('ecommerce/partial/withoutmenu_header'); ?>
<section class="contact-banner">
	<img src="<?php echo $this->all_function->get_cms_by_page_section_type($org_id,'Contactus-Page', 'Contactus-banner-image','image'); ?>" onError="this.onerror=null;this.src='<?php echo base_url(); ?>themes/ecommerce/images/contact-banner.png';" alt="">
</section>

<section class="slide-sec">
	<div class="container">
	
		<div class="contact-wrap d-flex">
			<div class="contact-info">
				<div class="blog-cat">Contact US</div>
				<p><?php echo $this->all_function->get_cms_by_page_section_type($org_id,'Contactus-Page', 'Contactus-title-description'); ?></p>
				<div class="blog-social">
<!--					<a href="<?php echo $this->all_function->get_cms_by_page_section_type($org_id,'Global-Setting', 'facebook-page'); ?>" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
					<a href="<?php echo $this->all_function->get_cms_by_page_section_type($org_id,'Global-Setting', 'instagram-page'); ?>" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>
					<a href="<?php echo $this->all_function->get_cms_by_page_section_type($org_id,'Global-Setting', 'twitter-page'); ?>" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>
					<a href="https://api.whatsapp.com/send?phone=<?php echo $this->all_function->get_cms_by_page_section_type($org_id,'Global-Setting', 'whatsapp-number'); ?>&app=facebook&entry_point=page_cta&fbclid=IwAR2dKYeXMMoH9GqitEQ26UMeUovHmR-8RG0dS0Ny6tgqyqdpXOV6iqO39x8" target="_blank"><i class="fa fa-whatsapp" aria-hidden="true"></i></a>-->
				</div>
				<div class="c-info-box d-flex">
					<div class="c-info-box-left"><img src="<?php echo base_url(); ?>themes/ecommerce/images/map-marker.png" alt=""></div>
					<div class="c-info-right">
						<h3><?php echo $this->all_function->get_cms_by_page_section_type($org_id,'Global-Setting', 'shop=address'); ?></h3>
					</div>
				</div>
				<div class="c-info-box d-flex">
					<div class="c-info-box-left"><img src="<?php echo base_url(); ?>themes/ecommerce/images/c-call.png" alt=""></div>
					<div class="c-info-right">
						<h4><?php echo $this->all_function->get_cms_by_page_section_type($org_id,'Global-Setting', 'contact-number'); ?></h4>
<!--						<h3>+ 91 6965965893</h3>-->
					</div>
				</div>
			</div>
			<div class="contact-map">
				<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15548.113357660754!2d77.5539222!3d13.0338673!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x8f003a25161f943a!2sGREEN%20OBJECT%20AGRO%20INDIA!5e0!3m2!1sen!2sin!4v1640760424615!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
			</div>
		</div>

	</div>
</section>

<section class="best-sell-sec">
	<div class="container">
		
		<div class="pro-info">
			<div class="row">
				<div class="col-md-4">
					<div class="pro-info-box">
						<div class="media">
							<div class="media-left">
								<img src="<?php echo base_url(); ?>themes/ecommerce/images/icon1.png" alt="/">
							</div>
							<div class="media-body">
								<h2>Free Delivery</h2>
								<p><?php echo $this->all_function->get_cms_by_page_section_type($org_id,'Home-Page', 'Free-Delivery'); ?></p>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="pro-info-box">
						<div class="media">
							<div class="media-left">
								<img src="<?php echo base_url(); ?>themes/ecommerce/images/icon2.png" alt="/">
							</div>
							<div class="media-body">
								<h2>Opening Hours</h2>
								<p><?php echo $this->all_function->get_cms_by_page_section_type($org_id,'Home-Page', 'Opening-Hours'); ?></p>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="pro-info-box">
						<div class="media">
							<div class="media-left">
								<img src="<?php echo base_url(); ?>themes/ecommerce/images/icon3.png" alt="/">
							</div>
							<div class="media-body">
								<h2>Eco-Friendly</h2>
								<p><?php echo $this->all_function->get_cms_by_page_section_type($org_id,'Home-Page', 'Eco-Friendly'); ?></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>


<section class="contact-content">
	<div class="container">
<!--		<div class="row">
			<div class="col-md-6">
				<div class="blog-cat">Contact US</div>
				<p>
					<?php echo $this->all_function->get_cms_by_page_section_type($org_id,'Contactus-Page', 'Contactus-bottom-description'); ?>
				</p>
				<ul>
					<li>
						Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy.
					</li>
					<li>
						Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy.
					</li>
				</ul>
			</div>
			<div class="col-md-6">
				<div class="blog-cat">License Permits</div>
				<p>
					<?php echo $this->all_function->get_cms_by_page_section_type($org_id,'Contactus-Page', 'Contactus-bottom-license-permits'); ?>
				</p>
				<ul>
					<li>
						Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy.
					</li>
					<li>
						Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy.
					</li>
				</ul>
			</div>
		</div>-->
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
    
</body>
</html>