<!doctype html>
<html lang="en">
<?php $this->load->view('ecommerce/partial/header_script'); ?>
<body>
<?php $this->load->view('ecommerce/partial/withoutmenu_header'); ?>
<section class="inner-body product-details mt-5 order-dt">
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-lg-12">
				<div class="product-list-box">
					<div class="media-list">
						<div class="media-left"><?php $first_item_image = $orderItems[0]->product_image;?>
							<img src="<?php echo base_url(); ?>uploads/varthak_product/<?php echo $first_item_image;?>" alt="">
						</div>
						<div class="media-body">
                                                    
<!--							<h2>Orange</h2>							-->
<p>Products: <strong>
                                                            <?php 
                                                            $products = '';
                                $first_item_image = $orderItems[0]->product_image;
                                foreach($orderItems as $items){
                                    $products .=$items->product_name.', ';
                                }
                                $products = rtrim($products,', ');
                                echo $products;
                                                            ?>
    </strong></p>
    <div class="table-responsive">
    <table class="table table-borderless table-condensed table-hover">
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Quantity</th>
                                                            <th>Price</th>
                                                            <th>GST</th>
                                                            <th>Total</th>
                                                        </tr>
                                                        <?php foreach($orderItems as $items){?>
                                                        <tr>
                                                            <td><?php echo $items->product_name?></td>
                                                            <td><?php echo $items->quantity?></td>
                                                            <td>INR <?php echo number_format($items->product_price,2,'.','')?></td>
                                                            <td>INR <?php echo number_format($items->gst_price,2,'.','')?></td>
                                                            <td>INR <?php echo number_format($items->total_price,2,'.','')?></td>
                                                        </tr>
                                                        <?php }?>
</table>
</div>
							<div class="product-dt">
								<p>Ordered on <strong><?php echo date('d M Y',strtotime($orderDetail->added_at));?></strong></p>
								<p>Delivered on <strong><?php echo ($orderDetail->delivery_date=='0000-00-00')?'Not yet confirmed':date('d M Y',strtotime($orderDetail->delivery_date));?></strong></p>
							</div>
							<div class="cart-btn">
                                                            <?php 
                                                    if($orderDetail->order_status=='4'){?>
                                                                <a href="javascript:;" class="m-0">Cancelled</a>
                                                    <?php }elseif($orderDetail->order_status=='1'){?>
                                                        <a href="javascript:;" onclick="cancelOrder('<?php echo $orderDetail->order_id;?>')" class="m-0">Cancel</a>
                                                    <?php }?>
                                                                <a href="<?php echo base_url($domain_name.'/ecomm-order-list').'.html';?>" class="m-0">Back</a>
								<div class="pro-price p-0">	<em>Order Total:</em> INR <?php echo number_format($orderDetail->total_price,2,'.','');?> </div>
							</div>
						</div>
					</div>
					<div class="order-status">
						<h4>Status of the Order</h4>
						<ol class="progtrckr" data-progtrckr-steps="5">
                                                    <?php 
                                                    if($orderDetail->order_status=='1'){?>
                                                        <li class="progtrckr-done"><span>Order Placed</span></li>
							<li class="progtrckr-todo"><span>Processing</span></li>
							<li class="progtrckr-todo"><span>Shipped</span></li>
							<li class="progtrckr-todo"><span>Delivered</span></li>
                                                    <?php }elseif($orderDetail->order_status=='1'){?>
                                                        <li class="progtrckr-done"><span>Order Placed</span></li>
							<li class="progtrckr-done"><span>Processing</span></li>
							<li class="progtrckr-done"><span>Shipped</span></li>
							<li class="progtrckr-todo"><span>Delivered</span></li>
                                                   <?php }
                                                    ?>
							
						</ol>
						<div class="order-listcont">
							<h3>Order Placed <span><?php echo date('D, d M Y',strtotime($orderDetail->added_at));?></span></h3>
							<p><strong>Your order has been placed.</strong></p>
							<p><?php echo date('D, d M Y - h:i A',strtotime($orderDetail->added_at));?></p>
						</div>
                                                <?php 
                                                    if($orderDetail->order_status=='4'){?>
                                                                <div class="order-listcont">
							<h3>Order cancelled</h3>
							<p><strong>You cancelled your order.</strong></p>
							<p><?php echo ($orderDetail->updated_at=='0000-00-00')?'Not yet confirmed':date('D, d M Y - h:i A',strtotime($orderDetail->updated_at));?></p>
						</div>
						
                                                    <?php }else{?>
                                                        <div class="order-listcont">
							<h3>Processing</h3>
							<p><strong>Seller has processed your order.</strong></p>
							<p><?php echo ($orderDetail->delivery_date=='0000-00-00')?'Not yet confirmed':date('D, d M Y - h:i A',strtotime($orderDetail->delivery_date));?></p>
						</div>
						<div class="order-listcont">
							<h3>Shipped</h3>
							<p><strong>Ekart logistics - FM565655855</strong></p>
							<p>Your item has been shipped</p>
							<p><?php echo ($orderDetail->delivery_date=='0000-00-00')?'Not yet shipped':date('D, d M Y - h:i A',strtotime($orderDetail->delivery_date));?></p>
						</div>
						<div class="order-listcont">
							<h3>Out For Delivery</h3>
							<p><strong>Your item is out for delivery</strong></p>
							<p><?php echo ($orderDetail->delivery_date=='0000-00-00')?'Not yet start delivery':date('D, d M Y - h:i A',strtotime($orderDetail->delivery_date));?></p>
						</div>
						<div class="order-listcont">
							<h3>Delivered</h3>
							<p><strong>Your item has been delivery</strong></p>
							<p><?php echo ($orderDetail->delivery_date=='0000-00-00')?'Not yet delivered':date('D, d M Y - h:i A',strtotime($orderDetail->delivery_date));?></p>
						</div>
                                                    <?php }?>
						
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
    
            function cancelOrder(order_id){
                var data = new FormData();
                data.append("order_id", order_id);
                $.ajax({
                    url: '<?php echo base_url($domain_name.'/ecomm-cancel-order') ?>',
                    type: 'POST',
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    data: data,
                    success: function (resp) {
                        if (resp.status === 200) {
                            location.reload();
                        } else {
                        }
                    }
                }).fail(function () {
                });
                
            }
            
    </script>
</body>
</html>