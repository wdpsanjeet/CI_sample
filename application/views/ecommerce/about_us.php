<!doctype html>
<html lang="en">
<?php $this->load->view('ecommerce/partial/header_script'); ?>
<body>
<?php $this->load->view('ecommerce/partial/withoutmenu_header'); ?>
<section class="contact-banner inn-banner">
	<img src="<?php echo $this->all_function->get_cms_by_page_section_type($org_id,'Aboutus-Page', 'Aboutus-banner-image','image'); ?>" onError="this.onerror=null;this.src='<?php echo base_url(); ?>themes/ecommerce/images/about-banner.png';" alt="">
	<div class="inn-banner-caption">
		<h2>About us</h2>
	</div>
</section>


<div class="about-wrap">
	<div class="container">
		<div class="row align-items-center pt-5 pb-5 abtf">
			<div class="col-md-12 col-sm-12 col-12 col-lg-6">
				<div class="about-cont">
					<div class="blog-cat"><?php echo $this->all_function->get_cms_by_page_section_type($org_id,'Aboutus-Page', 'Aboutus-author-title-one'); ?></div>
					<p><?php echo $this->all_function->get_cms_by_page_section_type($org_id,'Aboutus-Page', 'Aboutus-author-title-one-description'); ?></p>
<!--					<div class="about-info">
						<h3><?php echo $this->all_function->get_cms_by_page_section_type($org_id,'Aboutus-Page', 'Aboutus-author-name'); ?></h3>
						<p>Owner and Co Founder</p>
					</div>-->
				</div>
			</div>
			<div class="col-md-12 col-sm-12 col-12 col-lg-6">
				<div class="about-pic">
					<img src="<?php echo $this->all_function->get_cms_by_page_section_type($org_id,'Aboutus-Page', 'Aboutus-author-title-one-image','image'); ?>" onError="this.onerror=null;this.src='<?php echo base_url(); ?>themes/ecommerce/images/img1.png';" alt="">
				</div>
			</div>
		</div>
		<div class="row align-items-center pt-5 pb-5">
			<div class="col-md-12 col-sm-12 col-12 col-lg-6">
				<div class="about-pic">
					<img src="<?php echo $this->all_function->get_cms_by_page_section_type($org_id,'Aboutus-Page', 'Aboutus-author-title-two-image','image'); ?>" onError="this.onerror=null;this.src='<?php echo base_url(); ?>themes/ecommerce/images/img1.png';" alt="">
				</div>
			</div>
			<div class="col-md-12 col-sm-12 col-12 col-lg-6">
				<div class="about-cont">
					<div class="blog-cat"><?php echo $this->all_function->get_cms_by_page_section_type($org_id,'Aboutus-Page', 'Aboutus-author-title-two'); ?></div>
					<p><?php echo $this->all_function->get_cms_by_page_section_type($org_id,'Aboutus-Page', 'Aboutus-author-title-two-description'); ?></p>
				</div>
			</div>
		</div>
	</div>
</div>


<div class="about-info-section mb-5">
	<div class="container">
		<div class="row">
                    
			<div class="col-md-12 col-sm-12 col-12 col-lg-4">
				<div class="about-info-box">
					<div class="about-info-icon"><img src="<?php echo base_url(); ?>themes/ecommerce/images/IMG-20211229-WA0024.jpg" alt=""></div>
					<h2>Mission</h2>
					<p>With an extensive family background in trading & farming, our organizational mission is to build relationships with farmers to provide extensive research based services from farming incubation to farm-produce marketing as a one stop hand holding support to farmers.</p>
				</div>
			</div>
			<div class="col-md-12 col-sm-12 col-12 col-lg-4">
				<div class="about-info-box">
					<div class="about-info-icon"><img src="<?php echo base_url(); ?>themes/ecommerce/images/IMG-20211229-WA0026.jpg" alt=""></div>
					<h2>Vission</h2>
					<p>With pure focus on Hygiene, Safety & Quality – we aim to efficiently manage and channelagricultural output to various industrial, FMCG, export, HORECA and consumer segments to get maximum value addition with least wastage via meticulously planned business activity reap maximum profit for everybody involved in our proprietary “Farm-2-Consumer” Initiative.</p>
				</div>
			</div>
			<div class="col-md-12 col-sm-12 col-12 col-lg-4">
				<div class="about-info-box">
					<div class="about-info-icon"><img src="<?php echo base_url(); ?>themes/ecommerce/images/IMG-20211229-WA0025.jpg" alt=""></div>
					<h2>Values</h2>
					<p>We believe in building and maintaining long term ethical business relationships with everyone involved in our “Farm-2-Consumer” initiative. As steadfast believers in team work in every stage and aspect of our activities we respect everyone’s values and commitment in this noble venture, hence we are proud to give back to the society with thankfulness and gratitude to the sacrifices of our nation’s farmers.</p>
				</div>
			</div>
		</div>
	</div>
</div>









<div class="blog-cat-section pb-5">
	<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-6">
			<div class="cat-top">
				<h2>From the Blog</h2>
				<!--<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since.</p>-->
			</div>
		</div>
	</div>
	<div class="row">
            <?php foreach($recent_blogs['result'] as $list){?>
		<div class="col-md-12 col-sm-12 col-12 col-lg-4">
			<div class="blog-cat-box">
				<div class="blog-cat-pic"><img src="<?php echo base_url(); ?>uploads/blogs/original/<?php echo $list->thumbnail?>"></div>
				<div class="blog-cat"><?php echo $list->tag_name?></div>
				<div class="auth">By: <span><?php echo $list->added_by?></span></div>
				<div class="blog-date-time">
					<span><i class="fa fa-calendar" aria-hidden="true"></i> <?php echo date('M d / Y',strtotime($list->added_date));?></span>
					<span><i class="fa fa-clock-o" aria-hidden="true"></i><?php echo date('g:iA',strtotime($list->added_date));?></span>
				</div>
				<h3><?php echo $list->title?></h3>
				<p><?php echo $list->description?></p>
				<div class="blog-btn">
					<a href="<?php echo base_url('ecomm-blog-detail/'.$list->blogs_id.'/'.str_replace(' ', '-', $list->title)).'.html';?>">Read More <i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
				</div>
			</div>
		</div>
            <?php }?>
		
	</div>
</div>
</div>



<section class="gallery-sec d-flex">
	<div class="gallery-img"><img src="<?php echo $this->all_function->get_cms_by_page_section_type($org_id,'Footer-Gallary', 'slide-1','image'); ?>" onError="this.onerror=null;this.src='<?php echo base_url(); ?>themes/ecommerce/images/g1.png';" alt="/"></div>
	<div class="gallery-img"><img src="<?php echo $this->all_function->get_cms_by_page_section_type($org_id,'Footer-Gallary', 'slide-2','image'); ?>" onError="this.onerror=null;this.src='<?php echo base_url(); ?>themes/ecommerce/images/g2.png';" alt="/"></div>
	<div class="gallery-img"><img src="<?php echo $this->all_function->get_cms_by_page_section_type($org_id,'Footer-Gallary', 'slide-3','image'); ?>" onError="this.onerror=null;this.src='<?php echo base_url(); ?>themes/ecommerce/images/g3.png';" alt="/"></div>
	<div class="gallery-img"><img src="<?php echo $this->all_function->get_cms_by_page_section_type($org_id,'Footer-Gallary', 'slide-4','image'); ?>" onError="this.onerror=null;this.src='<?php echo base_url(); ?>themes/ecommerce/images/g4.png';" alt="/"></div>
</section>
<?php $this->load->view('ecommerce/partial/footer'); ?>
<?php $this->load->view('ecommerce/partial/footer_script'); ?>
    <script>
    function addToCart(product_id){
                var data = new FormData();
                data.append("quantity", '1');
                data.append("product_id", product_id);
                $.ajax({
                    url: '<?php echo base_url('add-to-cart') ?>',
                    type: 'POST',
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    data: data,
                    success: function (resp) {
                        if (resp.status === 200) {
                            window.location.href='<?php echo base_url($domain_name.'/ecomm-cart')?>'+'.html'
                        } else {
                        }
                    }
                }).fail(function () {
                });
                
            }
            function makeItFavorite(product_id){
        var url = '<?php echo base_url('make-it-favorite');?>';
        var data = new FormData();
        data.append('product_id',product_id);
        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            processData: false,
            contentType: false,
            data: data,
            success: function (resp) {
                if (resp.status === 200) {
                    $("#success_msg").html(resp.message);
                    $("#global_succmsg").show();
                } else {
                    $("#error_msg").html(resp.message);
                    $("#global_errmsg").show();
                }
            }
        }).fail(function () {
        });
    }
    </script>
</body>
</html>