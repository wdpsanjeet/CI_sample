<!doctype html>
<html lang="en">
<?php $this->load->view('ecommerce/partial/header_script'); ?>
<body>
<?php $this->load->view('ecommerce/partial/withoutmenu_header'); ?>
<main>
	<section class="product-cash-dtls">
		<div class="container">
			<div class="cash-dtls-wrap">
				<div class="cash-dtls-row row">
					<div class="col-md-9 dtls-left-col">
						<div class="dtls-left">
							<h2>
								Shopping Cart
							</h2>
							<ul class="row">
                                                            <?php $total_price=0;foreach($cart_items['result'] as $list){?>
								<li class="col-md-12 plist">
									<div class="product_box">
										<div class="row align-items-center">
											<div class="col-md-3">
												<figure class="product_img"><img src="<?php echo base_url(); ?>uploads/varthak_product/<?php echo $list->product_image;?>"></figure>
											</div>
											<div class="col-md-4">
												<h3><?php echo $list->product_name;?></h3>
												<span class="price">INR <?php echo number_format(($list->price-($list->price*$list->discount_percentage/100)+($list->price*$list->gst_percentage/100)),2,'.','');?> <del>INR <?php echo number_format(($list->price + ($list->price*$list->gst_percentage/100)),2,'.','');?></del></span>
											</div>
											<div class="col-md-3">
												<div class="quantity">
                                                                                                    <span class="quantity-add quantity-button" onclick="addToCart(this,'<?php echo $list->product_id;?>','add')"></span>
												  <input type="number" name="quantity" step="1" min="1" value="<?php echo $list->quantity;?>">
												  <span class="quantity-remove quantity-button" onclick="addToCart(this,'<?php echo $list->product_id;?>','remove')"></span>
											  </div> 
											</div>
											<div class="col-md-2 text-center">  
												<span class="price item_total_price">INR <?php echo $item_total_price = number_format(($list->price*$list->quantity-($list->price*$list->quantity*$list->discount_percentage/100)+($list->price*$list->quantity*$list->gst_percentage/100)),2,'.','');$total_price +=$item_total_price;?></span> 
											</div>   
										</div>
                                                                            <a class="delete" href="javascript:;" onclick="removeToCart(this,'<?php echo $list->product_id;?>')"><i class="fa fa-trash" aria-hidden="true"></i></a> 
									</div>
								</li>
                                                            <?php }?>
								
							</ul>
						</div>
						<div class="bottom_head mt-5">
							<div class="head1">Spend Over 500 Rs for Free Shipping</div>
							<div class="head2">Service & Delivery Terms</div>

						</div>
					</div>
					<div class="col-md-3 dtls-right-col">
						<div class="dtls-right">
							<h3>There are <?php echo $cart_items['total'];?> Items in Your Cart</h3>
							<div class="row align-items-center mb-2">
								<div class="col-md-6">
									<h2 class="total_right">Total:</h2>
								</div>
								<div class="col-md-6">
									<div class="price" id="cart_tot_price">INR <?php echo $total_price;?></div>
								</div>
							</div>
							<div class="row align-items-center">
								<div class="col-md-6">
									<h2 class="left_shipping">Shipping:</h2>
								</div>
								<div class="col-md-6">
                                                                    <div class="right_text" id="shipping_price">INR <?php echo ($total_price>500)?'0':50;?></div>
								</div>
							</div>
                                                        <hr />
                                                        <div class="row align-items-center mb-2">
								<div class="col-md-6">
									<h2 class="total_right">Total:</h2>
								</div>
								<div class="col-md-6">
									<div class="price" id="order_amount">INR <?php echo ($total_price+(($total_price>500)?'0':50));?></div>
								</div>
							</div>
						</div>
                                            <a class="Checkoutbtn mt-4" href="javascript:;" onclick="placeOrder()">Place your order</a>
					</div>
				</div>
			</div>
		</div>
	</section>
<!--	<section class="Offers">
		<div class="container">
			<div class="title-sec text-center">
				<h2>This Week Hot Offers</h2>
				<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since.</p>
			</div>
			<div class="ofr_list">
				<div class="row">
					<div class="col-md-3">
						<a class="ofr-box" href="#">
							<figure><img src="<?php echo base_url(); ?>themes/ecommerce/images/p1.png"></figure>
							<div class="ofr_text">
						      <h3>Orange</h3>
						      <div class="price">$ 56.68 <del>$ 56.68</del></div>
							</div>
						</a>
					</div>
					<div class="col-md-3">
						<a class="ofr-box" href="#">
							<figure><img src="<?php echo base_url(); ?>themes/ecommerce/images/p1.png"></figure>
							<div class="ofr_text">
						      <h3>Orange</h3>
						      <div class="price">$ 56.68 <del>$ 56.68</del></div>
							</div>
						</a>
					</div>
					<div class="col-md-3">
						<a class="ofr-box" href="#">
							<figure><img src="<?php echo base_url(); ?>themes/ecommerce/images/p1.png"></figure>
							<div class="ofr_text">
						      <h3>Orange</h3>
						      <div class="price">$ 56.68 <del>$ 56.68</del></div>
							</div>
						</a>
					</div>
					<div class="col-md-3">
						<a class="ofr-box" href="#">
							<figure><img src="<?php echo base_url(); ?>themes/ecommerce/images/p1.png"></figure>
							<div class="ofr_text">
						      <h3>Orange</h3>
						      <div class="price">$ 56.68 <del>$ 56.68</del></div>
							</div>
						</a>
					</div>
				</div>
			</div>
		</div>
	</section>-->
<section class="gallery-sec d-flex">
	<div class="gallery-img"><img src="<?php echo $this->all_function->get_cms_by_page_section_type($org_id,'Footer-Gallary', 'slide-1','image'); ?>" onError="this.onerror=null;this.src='<?php echo base_url(); ?>themes/ecommerce/images/g1.png';" alt="/"></div>
	<div class="gallery-img"><img src="<?php echo $this->all_function->get_cms_by_page_section_type($org_id,'Footer-Gallary', 'slide-2','image'); ?>" onError="this.onerror=null;this.src='<?php echo base_url(); ?>themes/ecommerce/images/g2.png';" alt="/"></div>
	<div class="gallery-img"><img src="<?php echo $this->all_function->get_cms_by_page_section_type($org_id,'Footer-Gallary', 'slide-3','image'); ?>" onError="this.onerror=null;this.src='<?php echo base_url(); ?>themes/ecommerce/images/g3.png';" alt="/"></div>
	<div class="gallery-img"><img src="<?php echo $this->all_function->get_cms_by_page_section_type($org_id,'Footer-Gallary', 'slide-4','image'); ?>" onError="this.onerror=null;this.src='<?php echo base_url(); ?>themes/ecommerce/images/g4.png';" alt="/"></div>
</section>
</main>
<?php $this->load->view('ecommerce/partial/footer'); ?>
<?php $this->load->view('ecommerce/partial/footer_script'); ?>
    <script>
    function addToCart(obj,product_id,action){
                var data = new FormData();
                if(action=='remove'){
                    data.append("quantity", parseInt($(obj).parent().find("input[name='quantity']").val())-1);
                }else if(action=='add'){
                    data.append("quantity", parseInt($(obj).parent().find("input[name='quantity']").val())+1);
                }
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
                            $(obj).parent().parent().parent().find(".item_total_price").html(resp.item_total_price);
                            $("#cart_tot_price").text('INR '+resp.cart_tot_price);
                            $("#shipping_price").text('INR '+resp.shipping_charges);
                            $("#order_amount").text('INR '+resp.order_amount);
                        } else {
                        }
                    }
                }).fail(function () {
                });
                
            }
            function removeToCart(obj,product_id){
                var data = new FormData();
                var $itemBox=$(obj);
                data.append("product_id", product_id);
                $.ajax({
                    url: '<?php echo base_url($domain_name.'/ecomm-remove-to-cart') ?>',
                    type: 'POST',
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    data: data,
                    success: function (resp) {
                        if (resp.status === 200) {
                           $itemBox.parent().parent().remove();
                           $("#cart_tot_price").text('INR '+resp.cart_tot_price);
                           $("#shipping_price").text('INR '+resp.shipping_charges);
                           $("#order_amount").text('INR '+resp.order_amount);
                        } else {
                        }
                    }
                }).fail(function () {
                });
                
            }
            function placeOrder(){
                $.ajax({
                    url: '<?php echo base_url($domain_name.'/ecomm-place-cart-order') ?>',
                    type: 'POST',
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    success: function (resp) {
                        if (resp.status === 200) {
                           window.location.href='<?php echo base_url($domain_name.'/ecomm-cart')?>'+'.html';
                        } else {
                        }
                    }
                }).fail(function () {
                });
            }
    </script>
</body>
</html>