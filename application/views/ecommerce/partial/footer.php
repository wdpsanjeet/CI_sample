<footer class="site-footer">
	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<div class="f-info-wrap">
					<div class="f-logo"><a href="#"><img src="<?php echo $this->all_function->get_cms_by_page_section_type($org_id,'Home-Page', 'Logo','image'); ?>" alt=""></a></div>
					<div class="f-info-txt" style="color:green">
						<B> Gather --- Grow --- Produce --- Supply >>> </B>
					</div>
					<div class="footer-info">
						<div class="ftr-fld">
							<span><i class="icofont-google-map"></i></span> <?php echo $this->all_function->get_cms_by_page_section_type($org_id,'Global-Setting', 'shop=address'); ?>
						</div>
						<div class="ftr-fld">
							<span><i class="icofont-ui-call"></i></span> <?php echo $this->all_function->get_cms_by_page_section_type($org_id,'Global-Setting', 'contact-number'); ?>
						</div>
						<br/>

					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="f-menu">
					<ul>
						<li><a href="<?php echo base_url($domain_name.'/ecomm-about-us').'.html'?>">About</a></li>
						<li><a href="<?php echo base_url($domain_name.'/ecomm-blogs').'.html'?>">Blog</a></li>
						<li><a href="<?php echo base_url($domain_name.'/ecomm-contact-us').'.html'?>">Contact Us</a></li>
                                                <?php $client_id = $this->session->userdata('client_id');
                                                if($client_id==''){?>
						<li><a href="<?php echo base_url($domain_name.'/ecomm-login').'.html'?>">Login</a></li>
                                                <?php }?>

					</ul>
				</div>
				<div class="f-social mt-5">
					<a href="<?php echo $this->all_function->get_cms_by_page_section_type($org_id,'Global-Setting', 'facebook-page'); ?>" target="_blank"><i class="icofont-facebook"></i></a>
					<a href="<?php echo $this->all_function->get_cms_by_page_section_type($org_id,'Global-Setting', 'instagram-page'); ?>" target="_blank"><i class="icofont-instagram"></i></a>
					<a href="<?php echo $this->all_function->get_cms_by_page_section_type($org_id,'Global-Setting', 'twitter-page'); ?>" target="_blank"><i class="icofont-twitter"></i></a>
					<a href="https://api.whatsapp.com/send?phone=<?php echo $this->all_function->get_cms_by_page_section_type($org_id,'Global-Setting', 'whatsapp-number'); ?>&app=facebook&entry_point=page_cta&fbclid=IwAR2dKYeXMMoH9GqitEQ26UMeUovHmR-8RG0dS0Ny6tgqyqdpXOV6iqO39x8" target="_blank"><i class="icofont-brand-whatsapp"></i></a>
				</div>
			</div>
		</div>
	</div>

	<div class="container-fluid copyright">
		<div class="container">
			<div class="copyright-txt">©  <?php echo date('Y');?> Green Arrow. All Rights Reserved.</div>
		</div>
	</div>

</footer>