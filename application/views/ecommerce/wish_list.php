<!doctype html>
<html lang="en">
<?php $this->load->view('ecommerce/partial/header_script'); ?>
<body>
<?php $this->load->view('ecommerce/partial/withoutmenu_header'); ?>
<section class="inner-body">
	<div class="container">
            <div class="alert alert-success" role="alert" id="global_succmsg" style="display: none;">
                <button type="button" class="close glbclose" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Success! </strong><span id="success_msg"> Please signin before any activaty!</span>
            </div>
            <div class="alert alert-danger" role="alert" id="global_errmsg" style="display: none;">
                <button type="button" class="close glbclose" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Error! </strong><span id="error_msg"> Please signin before any activaty!</span>
            </div>
		<div class="d-flex justify-content-between align-items-center mt-3 mb-5">
<!--			<div class="dropdown cat-drop">
			  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			    <span  class="menu-icon"></span> All Categories
			  </button>
			  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
			    <a class="dropdown-item active" href="#"><i class="icofont-users"></i> Fruits & vegetables</a>
			    <a class="dropdown-item" href="#"><i class="icofont-users"></i> Oils & Sauces</a>
			    <a class="dropdown-item" href="#"><i class="icofont-users"></i> Herbs & Spices</a>
			    <a class="dropdown-item" href="#"><i class="icofont-users"></i> Snacks & Canned Goods	</a>
			    <a class="dropdown-item" href="#"><i class="icofont-users"></i> Coffee & Tea</a>
			    <a class="dropdown-item" href="#"><i class="icofont-users"></i> Cereal & Bakery</a>
			    <a class="dropdown-item" href="#"><i class="icofont-users"></i> Farm Products</a>
			  </div>
			</div>-->
<div>&nbsp;</div>
			<div class="result-txt">
				Showing 1 - <?php echo $all_favorites['total'];?> of <?php echo $all_favorites['total'];?>  Items
			</div>
		</div>
		<div class="row">
			
			<div class="col-md-12">
                            <?php foreach($all_favorites['result'] as $list){?>
				<div class="product-list-box">
					<div class="media-list">
						<div class="media-left">
                                                    <a href="<?php echo base_url($domain_name.'/product-detail/'.$list->product_id.'/').$list->product_name.'.html'?>"><img src="<?php echo base_url(); ?>uploads/varthak_product/<?php echo $list->product_image;?>" alt=""></a>
						</div>
						<div class="media-body">
							<h2><?php echo $list->product_name;?></h2>
							<div class="pro-price">	INR <?php echo $list->price;?><span>INR <?php echo $list->price + ($list->price*0.1);?></span></div>
							<p><?php echo $list->product_description;?></p>
							<div class="d-flex align-items-center mt-5 mb-5">
                                                            <div class="cart-btn"><a href="javascript:;" onclick="addToCart('<?php echo $list->product_id;?>')">Add to Cart <span><img src="<?php echo base_url(); ?>themes/ecommerce/images/mini-cart.png" alt="/"></span></a></div>
                                                            <a class="wishlist_delete" href="javascript:;" onclick="removeItFavorite(this,'<?php echo $list->product_id;?>')"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                        </div>
						</div>
					</div>
				</div>
                            <?php }?>
				
<!--				<div class="list-pagination d-flex justify-content-end align-items-center">
					<span>1</span>
					<a href="#">2</a>
					<a href="#">3</a>
					<a href="#"><i class="icofont-double-right"></i></a>
				</div>-->
			</div>
		</div>
	</div>
</section>
    <section class="offer-sec">
	<div class="container">
		<div class="offer-wrap">
			<div class="row align-items-center">
				<div class="col-md-7">
					<div class="offer-cont">
						<h3>Weekly Discounts</h3>
						<h2>Upto 70% Offer</h2>
						<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since.</p>
						<div class="def-btn"><a href="#">Shop All</a></div>
					</div>
				</div>
				<div class="col-md-5">
					<img src="<?php echo base_url(); ?>themes/ecommerce/images/pro5.png" alt="/">
				</div>
			</div>
		</div>
	</div>
</section>


<section class="sub-prod-sec">
	<div class="container">
		<div class="row">
			<?php foreach($featured_category['result'] as $list){
                        $featuredItems = $this->all_function->get_featured_category_items($list->product_category_id);
                        ?>
			<div class="col-md-4">
				<h2><?php echo $list->category_name;?></h2>
                                <?php foreach($featuredItems as $item){?>
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
                                <?php }?>
				
			</div>
                    <?php }?>
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
						<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since.</p>
						<div class="def-btn"><a href="#">Call +91 9956683685</a></div>
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
    
    function removeItFavorite(obj,product_id){
        var url = '<?php echo base_url($domain_name.'/ecomm-remove-it-favorite');?>';
        var data = new FormData();
        var $removeBox= $(obj);
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
                    $removeBox.parent().parent().parent().parent().remove();
                } else {
                    $("#error_msg").html(resp.message);
                    $("#global_errmsg").show();
                }
            }
        }).fail(function () {
        });
    }
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
                            $("#success_msg").html(resp.message);
                            $("#global_succmsg").show();
                        } else {
                            $("#error_msg").html(resp.message);
                            $("#global_errmsg").show();
                        }
                        $([document.documentElement, document.body]).animate({
                                scrollTop: $("#global_succmsg").offset().top
                            }, 2000);
                    }
                }).fail(function () {
                });
                
            }
    </script>
</body>
</html>