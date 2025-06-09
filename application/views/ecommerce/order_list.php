<!doctype html>
<html lang="en">
<?php $this->load->view('ecommerce/partial/header_script'); ?>
<body>
<?php $this->load->view('ecommerce/partial/withoutmenu_header'); ?>
<section class="inner-body product-details">
	<div class="container">
		<div class="d-flex justify-content-end align-items-center mt-3 mb-5">
			<div class="result-txt">
				Showing 1 - <?php echo $orders['total'];?> of <?php echo $orders['total'];?> Items
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 col-lg-12">
                            <?php foreach($orders['result'] as $list){
                                $orderItemsObj = $this->all_function->get_order_items($list->order_id);
                                $products = '';
                                $first_item_image = $orderItemsObj[0]->product_image;
                                foreach($orderItemsObj as $items){
                                    $products .=$items->product_name.', ';
                                }
                                $products = rtrim($products,', ');
                                ?>
				<div class="product-list-box">
					<div class="media-list">
						<div class="media-left">
                                                    <a href="<?php echo base_url($domain_name.'/ecomm-order-detail').'.html'?>"><img src="<?php echo base_url(); ?>uploads/varthak_product/<?php echo $first_item_image;?>" alt=""></a>
						</div>
						<div class="media-body">
<!--							<h2>Orange</h2>							-->
							<p>Products: <strong><?php echo $products;?></strong></p>
							<div class="product-dt">
								<p>Ordered on <strong><?php echo date('d M Y',strtotime($list->added_at));?></strong></p>
								<p>Delivered on <strong><?php echo ($list->delivery_date=='0000-00-00')?'Not yet confirmed':date('d M Y',strtotime($list->delivery_date));?></strong></p>
							</div>
							<div class="cart-btn">
								<?php 
                                                    if($list->order_status=='4'){?>
                                                                <a href="javascript:;" class="m-0">Cancelled</a>
                                                    <?php }elseif($list->order_status=='1'){?>
                                                        <a href="javascript:;" onclick="cancelOrder(this,'<?php echo $list->order_id;?>')" class="m-0">Cancel</a>
                                                    <?php }?>
                                                                <a href="<?php echo base_url($domain_name.'/ecomm-order-detail/').$list->order_id;?>" class="m-0">Detail</a>
								<div class="pro-price p-0">	<em>Order Total:</em> INR <?php echo $list->total_price;?> <span>INR <?php echo $list->total_price+ ($list->total_price*0.1);?></span></div>
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
<?php $this->load->view('ecommerce/partial/footer'); ?>
<?php $this->load->view('ecommerce/partial/footer_script'); ?>
    <script>
    
            function cancelOrder(obj,order_id){
                var data = new FormData();
                var $orderBox=$(obj);
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
                            $orderBox.text('Cancelled');
                            $orderBox.removeAttr('onclick');
                        } else {
                        }
                    }
                }).fail(function () {
                });
                
            }
            
    </script>
</body>
</html>