<!doctype html>
<html lang="en">
<?php $this->load->view('ecommerce/partial/header_script'); ?>
    <style>
        .range-wrap {
  position: relative;
  margin: 0 auto 3rem;
}
.range {
  width: 100%;
}
.bubble {
  background: red;
  color: white;
  padding: 4px 12px;
  position: absolute;
  border-radius: 4px;
  left: 50%;
  transform: translateX(-50%);
  margin-top: 20px;
}
.bubble::after {
  content: "";
  position: absolute;
  width: 2px;
  height: 2px;
  background: red;
  top: -1px;
  left: 50%;
}
    </style>
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
			<div class="dropdown cat-drop">
			  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			    <span  class="menu-icon"></span> 
                            <?php if(isset($category_id) && $category_id !=''){
                                echo $category_title;
                            }else{?>
                                All Categories
                            <?php }?>
                            
			  </button>
			  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                              <?php if(isset($category_id) && $category_id !=''){?>
                                <a class="dropdown-item" href="<?php echo base_url($domain_name.'/product-list').'.html';?>"><i class="icofont-users"></i> All Categories</a>
                                <?php }?>
			    <?php foreach($all_sub_category['result'] as $list){
                                if(isset($category_id) && $category_id ==$list->product_category_id){
                                    continue;
                                }
                                ?>
                              <a class="dropdown-item" href="<?php echo base_url($domain_name.'/products-by-category/'.$list->product_category_id.'/'.str_replace(' ', '-', $list->category_name)).'.html';?>"><i class="icofont-users"></i> <?php echo $list->category_name?></a>
                            <?php }?>
			  </div>
			</div>
			<div class="result-txt">
				Showing 1 - <?php echo $all_products['total'];?> of <?php echo $all_products['total'];?> Items
			</div>
		</div>
		<div class="row">
			<div class="col-md-4">
				<div class="filter-sidebar">
					<h2>Product Filters</h2>
					<div class="filter-body">
						<div class="filter-box">
							<h3>Price</h3>
							<div class="pricer-flt-btn">
                                                            <a href="javascript:;" onclick="orderByPrice('ASC')" <?php echo (isset($order_by) && $order_by=='ASC')?'class="active"':'';?>>Low to High</a>
								<a href="javascript:;" onclick="orderByPrice('DESC')" <?php echo (isset($order_by) && $order_by=='DESC')?'class="active"':'';?>>High to Low</a>
							</div>
						</div>
						<div class="filter-box">
							<h3>Price Range</h3>
                                                        <form class="multi-range-field my-5 pb-5" id="price-range-form">
                                                        <div class="range-wrap">
            <input type="range" class="range" min="1" max="1000" onchange="priceRange()">
            <output class="bubble"></output>
          </div>
                                                            </form>
                                                        
						</div>
						<div class="filter-box">
							<h3>Customer Ratings</h3>
							<div class="rating-box">
                                                            <label> <input type="checkbox" id="checkbox1" value="4" <?php echo (isset($rating) && $rating=='4')?'checked="checked"':'';?>> 4 <img src="<?php echo base_url(); ?>themes/ecommerce/images/star.png" alt=""> & above</label>
							</div>
							<div class="rating-box">
								<label> <input type="checkbox" id="checkbox2" value="3" <?php echo (isset($rating) && $rating=='3')?'checked="checked"':'';?>> 3 <img src="<?php echo base_url(); ?>themes/ecommerce/images/star.png" alt=""> & above</label>
							</div>
							<div class="rating-box">
								<label> <input type="checkbox" id="checkbox3" value="2" <?php echo (isset($rating) && $rating=='2')?'checked="checked"':'';?>> 2 <img src="<?php echo base_url(); ?>themes/ecommerce/images/star.png" alt=""> & above</label>
							</div>
							<div class="rating-box">
								<label> <input type="checkbox" id="checkbox4" value="1" <?php echo (isset($rating) && $rating=='1')?'checked="checked"':'';?>> 1 <img src="<?php echo base_url(); ?>themes/ecommerce/images/star.png" alt=""> & above</label>
							</div>
						</div>
<!--						<div class="filter-box">
							<h3>GST Invoice Available</h3>
							<div class="rating-box">
                                                            <label> <input type="checkbox" value="1" <?php echo (isset($gst_status) && $gst_status=='1')?'checked="checked"':'';?>> GST Invoice Available</label>
							</div>
						</div>-->
					</div>
				</div>
			</div>
			<div class="col-md-8">
                            <?php foreach($all_products['result'] as $list){?>
				<div class="product-list-box">
					<div class="media-list">
						<div class="media-left">
                                                    <a href="<?php echo base_url($domain_name.'/product-detail/'.$list->product_id.'/').$list->product_name.'.html'?>"><img src="<?php echo base_url(); ?>uploads/varthak_product/<?php echo $list->product_image;?>" alt=""></a>
						</div>
						<div class="media-body">
							<h2><?php echo $list->product_name;?></h2>
							<div class="pro-price">	INR <?php echo $list->price-($list->price*$list->discount_percentage/100)+($list->price*$list->gst_percentage/100);?> <span>INR <?php echo $list->price + ($list->price*$list->gst_percentage/100);?></span></div>
							<p><?php echo $list->product_description;?></p>
                                                        <div class="d-flex align-items-center mt-5 mb-5">
                                                            <div class="cart-btn"><a href="javascript:;" onclick="addToCart('<?php echo $list->product_id;?>')">Add to Cart <span><img src="<?php echo base_url(); ?>themes/ecommerce/images/mini-cart.png" alt="/"></span></a></div>
                                                            <a class="small-heart" href="javascript:;" onclick="makeItFavorite('<?php echo $list->product_id;?>')"><i class="fa fa-heart-o" aria-hidden="true"></i></a>
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
<div class="row">
          <div class="col-lg-12 text-right">
            <?php if (isset($all_products) && is_array($all_products)) echo $page_links; ?>
          </div>
        </div>
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
						<h2><?php echo $this->all_function->get_cms_by_page_section_type($org_id,'Home-Page', 'Weekly-Discounts-Title'); ?></h2>
						<p><?php echo $this->all_function->get_cms_by_page_section_type($org_id,'Home-Page', 'Weekly-Discounts-Title-Description'); ?></p>
                                                <div class="def-btn"><a href="<?php echo base_url($domain_name.'/product-list').'.html';?>">Shop All</a></div>
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
    <form id="filter_form" action="">
        <input type="hidden" name="order_by" id="order_by" value="<?php echo (isset($order_by))?$order_by:'ASC';?>" />
        <input type="hidden" name="order_column" id="order_column" value="price" />
        <input type="hidden" name="min_price" id="min_price" value="0" />
        <input type="hidden" name="max_price" id="max_price" value="<?php echo (isset($max_price))?$max_price:'1000';?>" />
        <input type="hidden" name="rating" id="rating" value="<?php echo (isset($rating))?$rating:'0';?>" />
        <input type="hidden" name="gst_status" id="gst_status" value="1" />
    </form>
<?php $this->load->view('ecommerce/partial/footer'); ?>
<?php $this->load->view('ecommerce/partial/footer_script'); ?>
    <script>
    function filterProducts(){
        $("#filter_form").submit();
    }
    function orderByPrice(order_by){
        $("#order_by").val(order_by);
        filterProducts();
    }
    function priceRange(){
        $("#max_price").val($("#multi9").val());
        filterProducts();
    }
    $(document).ready(function() {
    //set initial state.
        //$('#textbox1').val(this.checked);

        $('#checkbox1').change(function() {
            if(this.checked) {
                $("#rating").val($(this).val());
                filterProducts();
            }else{
                $("#rating").val('0');
                filterProducts();
            }
        });
        $('#checkbox2').change(function() {
            if(this.checked) {
                $("#rating").val($(this).val());
                filterProducts();
            }else{
                $("#rating").val('0');
                filterProducts();
            }
        });
        $('#checkbox3').change(function() {
            if(this.checked) {
                $("#rating").val($(this).val());
                filterProducts();
            }else{
                $("#rating").val('0');
                filterProducts();
            }
        });
        $('#checkbox4').change(function() {
            if(this.checked) {
                $("#rating").val($(this).val());
                filterProducts();
            }else{
                $("#rating").val('0');
                filterProducts();
            }
        });
    });
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
                $([document.documentElement, document.body]).animate({
                                scrollTop: $("#global_succmsg").offset().top
                            }, 2000);
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
            const allRanges = document.querySelectorAll(".range-wrap");
allRanges.forEach(wrap => {
  const range = wrap.querySelector(".range");
  const bubble = wrap.querySelector(".bubble");

  range.addEventListener("input", () => {
    setBubble(range, bubble);
  });
  setBubble(range, bubble);
});

function setBubble(range, bubble) {
  const val = range.value;
  const min = range.min ? range.min : 0;
  const max = range.max ? range.max : 100;
  const newVal = Number(((val - min) * 100) / (max - min));
  bubble.innerHTML = val;

  // Sorta magic numbers based on size of the native UI thumb
  bubble.style.left = `calc(${newVal}% + (${8 - newVal * 0.15}px))`;
}
    </script>
</body>
</html>