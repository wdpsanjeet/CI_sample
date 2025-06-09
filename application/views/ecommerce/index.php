<!doctype html>
<html lang="en">
<?php $this->load->view('ecommerce/partial/header_script'); ?>
<body class="home">
<?php $this->load->view('ecommerce/partial/header'); ?>
    
<section class="top-banner-sec">
    
	<div class="container-fluid p-0">
		<div class="d-flex var-row justify-content-between">
			
				<div class="banner-left">
					<div class="banner-caption">
						<h2><?php echo $this->all_function->get_cms_by_page_section_type($org_id,'Home-Page', 'Banner-Title'); ?></h2>
						<h3><?php echo $this->all_function->get_cms_by_page_section_type($org_id,'Home-Page', 'Banner-Title-Description'); ?></h3>
						<div class="def-btn">
							<a href="<?php echo base_url($domain_name.'/product-list').'.html'?>">View Sale</a>
							<a href="<?php echo base_url($domain_name.'/product-list').'.html'?>">Shop All</a>
						</div>
					</div>
				</div>
			
				<div class="banner-right">
					<img src="<?php echo $this->all_function->get_cms_by_page_section_type($org_id,'Home-Page', 'Banner','image'); ?>" onError="this.onerror=null;this.src='<?php echo base_url(); ?>themes/ecommerce/images/banner-img.png';" alt="">
				</div>
		</div>
	</div>

</section>

<section class="slide-sec">
	<div class="container">
	
		<div id="banner-slide" class="owl-carousel owl-theme">
                    <?php foreach($all_top_popular_product['result'] as $list){?>
			<div class="item">
				<div class="pro-box">
					<img src="<?php echo base_url(); ?>uploads/varthak_product/<?php echo $list->product_image;?>" alt="/">
                                        <div class="slider-price d-flex">
						<div class="price-left">
							<h2><?php echo $list->product_name;?></h2>
						</div>
						<div class="slider-price-right">
							<div class="sale-price">INR <?php echo $list->price + ($list->price*$list->gst_percentage/100);?></div>
							<div class="offer-price">INR <?php echo $list->price-($list->price*$list->discount_percentage/100)+($list->price*$list->gst_percentage/100);?></div>
						</div>
					</div>
				</div>
			</div>
                    <?php }?>
			
		</div>

	</div>
</section>

<section class="best-sell-sec">
	<div class="container">
		<div class="title-sec text-center">
			<h2>Why Choose Green Arrow</h2>
			<p><?php echo $this->all_function->get_cms_by_page_section_type($org_id,'Home-Page', 'Best-Seller-This-Week'); ?></p>
		</div>
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
								<img src="<?php echo base_url(); ?>themes/ecommerce/images/icon1.png" alt="/">
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

<section class="main-product-sec">
	<div class="container">
            <div class="alert alert-danger" role="alert" id="global_errmsg" style="display: none;">
                <button type="button" class="close glbclose" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Error! </strong><span id="error_msg"> Please signin before any activaty!</span>
            </div>
		<div class="row">
			<div class="col-md-3">
				<div class="product-outer">
					<h2>This week’s hot offer</h2>
					<div class="product-box">
                                            <?php 
                                            if($all_hotoffer['total']>0){
                                            $random_hotoffer = (rand(0,($all_hotoffer['total']-1)));?>
						<div class="product-thum">
							<img src="<?php echo base_url(); ?>uploads/varthak_product/<?php echo $all_hotoffer['result'][$random_hotoffer]->product_image;?>" alt="/">
						</div>
						<div class="product-info">
							<h3><?php echo $all_hotoffer['result'][$random_hotoffer]->product_name;?></h3>
							<div class="pro-price">
								INR <?php echo $all_hotoffer['result'][$random_hotoffer]->price-($all_hotoffer['result'][$random_hotoffer]->price*$all_hotoffer['result'][$random_hotoffer]->discount_percentage/100)+($all_hotoffer['result'][$random_hotoffer]->price*$all_hotoffer['result'][$random_hotoffer]->gst_percentage/100);?> <span>INR <?php echo $all_hotoffer['result'][$random_hotoffer]->price + ($all_hotoffer['result'][$random_hotoffer]->price*$all_hotoffer['result'][$random_hotoffer]->gst_percentage/100);?></span>
							</div>
							<p><?php echo $all_hotoffer['result'][$random_hotoffer]->small_note;?></p>
							<div class="cart-btn"><a href="javascript:;" onclick="addToCart('<?php echo $all_hotoffer['result'][$random_hotoffer]->product_id;?>')">Add to Cart <span><img src="<?php echo base_url(); ?>themes/ecommerce/images/mini-cart.png" alt="/"></span></a></div>
						</div>
                                            <?php }?>
					</div>
				</div>
			</div>
			<div class="col-md-9">
				<div class="product-outer right">
					<h2>This week’s hot offer</h2>
					<div class="row">
                                            <?php 
                                            if($all_hotoffer['total']>0){
                                            foreach($all_hotoffer['result'] as $list){?>
						<div class="col-md-4">
							<div class="product-outer">
								<div class="product-box">
									<div class="product-thum">
										<img src="<?php echo base_url(); ?>uploads/varthak_product/<?php echo $list->product_image;?>" alt="/">
										<h3><?php echo $list->product_name;?></h3>
										<a href="javascript:;" onclick="makeItFavorite('<?php echo $list->product_id;?>')" class="wish"><i class="fa fa-heart-o" aria-hidden="true"></i></a>
									</div>
									<div class="product-info">
										
										<div class="pro-price">
												INR <?php echo $list->price-($list->price*$list->discount_percentage/100)+($list->price*$list->gst_percentage/100);?> <span>INR <?php echo $list->price + ($list->price*$list->gst_percentage/100);?></span>
										</div>
										<div class="cart-btn"><a href="javascript:;" onclick="addToCart('<?php echo $list->product_id;?>')">Add to Cart <span><img src="<?php echo base_url(); ?>themes/ecommerce/images/mini-cart.png" alt="/"></span></a></div>
									</div>
								</div>
							</div>
						</div>
                                            <?php }
                                            }?>
						
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="offer-sec">
	<div class="container">
<!--		<div class="offer-wrap">
			<div class="row align-items-center">
				<div class="col-md-7">
					<div class="offer-cont">
						<h3>Weekly Discounts</h3>
						<h2><?php echo $this->all_function->get_cms_by_page_section_type($org_id,'Home-Page', 'Weekly-Discounts-Title'); ?></h2>
						<p><?php echo $this->all_function->get_cms_by_page_section_type($org_id,'Home-Page', 'Weekly-Discounts-Title-Description'); ?></p>
						<div class="def-btn"><a href="<?php echo base_url('products').'.html';?>">Shop All</a></div>
					</div>
				</div>
				<div class="col-md-5">
					<img src="<?php echo base_url(); ?>themes/ecommerce/images/pro5.png" alt="/">
				</div>
			</div>
		</div>-->
	</div>
</section>


<section class="sub-prod-sec">
	<div class="container">
		<div class="row">
                    <?php 
                    if($featured_category['total']>0){
                    foreach($featured_category['result'] as $list){
                        $featuredItems = $this->all_function->get_featured_category_items($list->product_category_id);
                        ?>
			<div class="col-md-4">
				<h2><?php echo $list->category_name;?></h2>
                                <?php 
                                if(count($featuredItems)>0){
                                foreach($featuredItems as $item){?>
				<div class="mini-pro-box">
					<div class="media">
						<div class="media-left">
							<img src="<?php echo base_url(); ?>uploads/varthak_product/<?php echo $item->product_image;?>" alt="/">
						</div>
						<div class="media-body">
							<h3><?php echo $item->product_name;?></h3>
							<div class="pro-price">
								INR <?php echo $item->price;?> <span>INR <?php echo $item->price + ($item->price*0.1);?></span>
							</div>
							<div class="btn-wish">
								<a href="javascript:;" onclick="addToCart('<?php echo $item->product_id;?>')">Add to Cart <span><i class="fa fa-heart-o" aria-hidden="true"  onclick="makeItFavorite('<?php echo $item->product_id;?>')"></i></span></a>
							</div>
						</div>
					</div>
				</div>
                                <?php 
                                }
                                }?>
				
			</div>
                    <?php }
                    }?>
			
		</div>
	</div>
</section>

<section class="offer-sec">
	<div class="container">
		<div class="offer-wrap">
			<div class="row align-items-center">
				<div class="col-md-7">
					<div class="offer-cont">
						<h4>Order Home Delivery of Groceries</h4>
						<p><?php echo $this->all_function->get_cms_by_page_section_type($org_id,'Home-Page', 'Order-Home-Delivery-of-Groceries-Description'); ?></p>
						<div class="def-btn"><a href="tel:+<?php echo $this->all_function->get_cms_by_page_section_type($org_id,'Global-Setting', 'whatsapp-number'); ?>">Call +<?php echo $this->all_function->get_cms_by_page_section_type($org_id,'Global-Setting', 'whatsapp-number'); ?></a></div>
					</div>
				</div>
				<div class="col-md-5">
					<div class="delivary-img"><img src="<?php echo $this->all_function->get_cms_by_page_section_type($org_id,'Home-Page', 'Order-Home-Delivery-of-Groceries-Image','image'); ?>" onError="this.onerror=null;this.src='<?php echo base_url(); ?>themes/ecommerce/images/pro6.png';" alt="/"></div>
				</div>
			</div>
		</div>
	</div>
</section>


<!--<section class="brandr-sec">
	<div class="container">
		<div class="brand-logo-wrap d-flex">
			<div class="brand-logo"><img src="<?php echo base_url(); ?>themes/ecommerce/images/brand1.png" alt="/"></div>
			<div class="brand-logo"><img src="<?php echo base_url(); ?>themes/ecommerce/images/brand2.png" alt="/"></div>
			<div class="brand-logo"><img src="<?php echo base_url(); ?>themes/ecommerce/images/brand3.png" alt="/"></div>
			<div class="brand-logo"><img src="<?php echo base_url(); ?>themes/ecommerce/images/brand1.png" alt="/"></div>
		</div>
	</div>
</section>-->


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
                    url: '<?php echo base_url($domain_name.'/ecomm-add-to-cart') ?>',
                    type: 'POST',
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    data: data,
                    success: function (resp) {
                        if (resp.status === 200) {
                            $("#global_alternate_succmsg").show();
                            $("#alternate_success_msg").html(resp.message);
                            $([document.documentElement, document.body]).animate({
                                scrollTop: $("#global_alternate_succmsg").offset().top
                            }, 2000);
                            //window.location.href='<?php echo base_url($domain_name.'/ecomm-cart')?>'+'.html'
                        } else {
                            $("#error_msg").html(resp.message);
                            $("#global_errmsg").show();
                            $([document.documentElement, document.body]).animate({
                                scrollTop: $("#global_errmsg").offset().top
                            }, 2000);
                        }
                    }
                }).fail(function () {
                });
                
            }
            function makeItFavorite(product_id){
        var url = '<?php echo base_url($domain_name.'/ecomm-make-it-favorite');?>';
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