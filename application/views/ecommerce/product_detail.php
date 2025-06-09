<!doctype html>
<html lang="en">
<?php $this->load->view('ecommerce/partial/header_script'); ?>
<body>
<?php $this->load->view('ecommerce/partial/withoutmenu_header'); ?>
<main>
    
	<section class="dtls_top">
		<div class="container">
                    <div class="alert alert-success" role="alert" id="favorite_add_cart_succmsg" style="display: none;">
                                        <button type="button" class="close glbclose" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <strong>Success! </strong><span id="favrate_add_cart_msg"> added successfully!</span>
                                    </div>
                    <div class="alert alert-error" role="alert" id="favorite_add_cart_errormsg" style="display: none;">
                                        <button type="button" class="close glbclose" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <strong>Error! </strong><span id="favrate_add_cart_errmsg"> added successfully!</span>
                                    </div>
			<div class="row">
				<div class="col-md-6">
					<div id="big" class="owl-carousel owl-theme">
                                            
                      <div class="item"><figure><img src="<?php echo base_url(); ?>uploads/varthak_product/<?php echo $productDetail->product_image;?>"></figure></div> 
                      <div class="item"><figure><img src="<?php echo base_url(); ?>uploads/varthak_product/<?php echo $productDetail->product_image;?>"></figure></div>
                      <div class="item"><figure><img src="<?php echo base_url(); ?>uploads/varthak_product/<?php echo $productDetail->product_image;?>"></figure></div> 
                      <div class="item"><figure><img src="<?php echo base_url(); ?>uploads/varthak_product/<?php echo $productDetail->product_image;?>"></figure></div>
                    </div>
					<div id="thumbs" class="owl-carousel owl-theme">
					  <div class="item"><figure><img src="<?php echo base_url(); ?>uploads/varthak_product/<?php echo $productDetail->product_image;?>"></figure></div> 
					  <div class="item"><figure><img src="<?php echo base_url(); ?>uploads/varthak_product/<?php echo $productDetail->product_image;?>"></figure></div>
					  <div class="item"><figure><img src="<?php echo base_url(); ?>uploads/varthak_product/<?php echo $productDetail->product_image;?>"></figure></div> 
                      <div class="item"><figure><img src="<?php echo base_url(); ?>uploads/varthak_product/<?php echo $productDetail->product_image;?>"></figure></div>
					</div>
				</div>
				<div class="col-md-6 dtls-right-content">
					<h2 class="subhead">
						<?php echo $productDetail->product_name;?>
					</h2>
					<div class="price">
						INR <?php echo $productDetail->price;?> <del>INR <?php echo $productDetail->price + ($productDetail->price*0.1);?></del>
					</div>
					<div class="small_text mt-3 mb-3">Price Per <?php echo $productDetail->quantity_val;?><?php echo $productDetail->quantity_unit;?></div>
					<div class="Availability mb-4">
						Availability: <strong>Only 80kg left</strong> 
					</div>
					<div class="quantity">
					    <span class="quantity-add quantity-button"></span>
                                            <input name="quantity" id="quantity" type="number" step="1" min="1" value="1">
                                            <input name="product_id" id="product_id" type="hidden" value="<?php echo $productDetail->product_id;?>">
						  <span class="quantity-remove quantity-button"></span>
					 </div> 
					 <div class="d-flex align-items-center mt-5 mb-5">
                                             <a class="big_btn" href="javascript:;" onclick="addToCart()">Add to Cart <i class="fa fa-shopping-cart" aria-hidden="true"></i></a>
					 	<a class="heart" href="javascript:;" onclick="makeItFavorite('<?php echo $productDetail->product_id;?>')"><i class="fa fa-heart-o" aria-hidden="true"></i></a>
					 	<a class="share" href="#"><i class="fa fa-share-alt" aria-hidden="true"></i></a>
					 </div>
					 <div class="listing">
					 	<span>Category: </span> <strong><?php echo $productDetail->category_name;?></strong>
					 </div>
					 <div class="listing">
					 	<span>Tags: </span> <strong>Berries, Farm Production, Fresh</strong>
					 </div>
					 <div class="last_para">
					 	<!--<p><?php echo $productDetail->small_note;?></p>-->
					 	<div class="subhead"><?php echo $productDetail->small_note;?></div>
					 </div>
				</div>
				<div class="col-sm-12">
					<div class="tab_part">
						<nav>
							<ul>
								<li>Description</li>
							</ul>
						</nav>
						<div class="tab_desc">
							<div class="row">
								<div class="col-md-6">
									<p><?php echo $productDetail->product_description;?></p>
									<ul>
										<li>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </li>
										<li>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </li>
									</ul>
									<h2 class="subhead">Minimum Order Quantity 50 KG (MCQ)</h2>
								</div>
								<div class="col-md-6">
									<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since.</p>
									<div class="listing">
									 	<span>Category: </span> <strong><?php echo $productDetail->category_name;?></strong>
									 </div>
									 <div class="listing">
									 	<span>Tags: </span> <strong>Berries, Farm Production, Fresh</strong>
									 </div>
									 <div class="price">
										INR <?php echo $productDetail->price;?> <del>INR <?php echo $productDetail->price + ($productDetail->price*0.1);?></del>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div> 
			</div> 
		</div>
	</section>
	<section class="ReviewsFeedback">
		<div class="container">
			<h2>Reviews & Feedback</h2> 
                        <?php foreach($product_comments['result'] as $list){?>
			<div class="rlist"> 
				<div class="rbox">
					<figure><img src="<?php echo base_url(); ?>uploads/profile_img/original/<?php echo $list->image?>" onerror="this.src='<?php echo base_url(); ?>uploads/profile_img/original/profile_image.png';"></figure>
					<div class="rtext">
						<h3 class="subhead d-flex align-items-center"><?php echo $list->name;?> <div class="d-flex star">
                                                        <?php for($i=1;$i<=$list->rating;$i++){?>
                                                           <i class="fa fa-star" aria-hidden="true"></i> 
                                                        <?php }?>
                                                        <?php for($i=$list->rating;$i<5;$i++){?>
                                                           <i class="fa fa-star" style="color: #606060" aria-hidden="true"></i> 
                                                        <?php }?>
                                                        </div></h3>
						<div class="date"><span><i class="fa fa-calendar" aria-hidden="true"></i> <?php echo date('M d / Y',strtotime($list->added_at));?></span> <span><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo date('g:iA',strtotime($list->added_at));?></span></div>
						<div class="rpara">
							Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since.
						</div>
					</div>
				</div>  
			</div>
                        <?php }?>
			

			<h2>Leave a comment</h2>
			<div class="cm-flx d-flex align-items-center">
				<div class="subhead">Rate Product:</div>
                                <div class="star" id="rate_div"><i class="fa fa-star" aria-hidden="true" onclick="selectRating('1');"></i><i class="fa fa-star" aria-hidden="true" onclick="selectRating('2');"></i><i class="fa fa-star" aria-hidden="true" onclick="selectRating('3');"></i><i class="fa fa-star" aria-hidden="true" onclick="selectRating('4');"></i><i class="fa fa-star" aria-hidden="true" onclick="selectRating('5');"></i></div>
			</div>
			<div class="com_para">
				<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since.</p>
			</div>
			<div class="comt_form loginform_page">
				<form  action="<?php echo base_url('do-product-comment').'.html';?>" method="post" id="do-product-comment">
                                    <input type="hidden" name="product_id" value="<?php echo $productDetail->product_id;?>" />
                                    <input type="hidden" name="rating" id="rating" value="" />
                                    <div class="alert alert-success" role="alert" id="global_succmsg" style="display:none">
                                        <button type="button" class="close glbclose" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <strong>Success! </strong><span id="success_msg"> Your comment has been submitted!</span>
                                    </div>
					<div class="row">
						<div class="col-md-6">
                                                    <input type="email" name="email_id" placeholder="Email">
                                                    <span class="text-danger"></span>
						</div>
						<div class="col-md-6">
							<input type="text" name="name" placeholder="Name">
                                                        <span class="text-danger"></span>
						</div>
						<div class="col-md-12">
							<textarea name="comment" placeholder="Your message here"></textarea>
                                                        <span class="text-danger"></span>
						</div>
						<div class="col-sm-12">
                                                    <a href="javascript:;" onclick="submitReview()" style="max-width: 260px;" class="Checkoutbtn">Leave a review</a> 
						</div>
					</div>
				</form>
			</div>
		</div>
	</section>
	
</main>

<section class="gallery-sec d-flex">
	<div class="gallery-img"><img src="<?php echo $this->all_function->get_cms_by_page_section_type($org_id,'Footer-Gallary', 'slide-1','image'); ?>" onError="this.onerror=null;this.src='<?php echo base_url(); ?>themes/ecommerce/images/g1.png';" alt="/"></div>
	<div class="gallery-img"><img src="<?php echo $this->all_function->get_cms_by_page_section_type($org_id,'Footer-Gallary', 'slide-2','image'); ?>" onError="this.onerror=null;this.src='<?php echo base_url(); ?>themes/ecommerce/images/g2.png';" alt="/"></div>
	<div class="gallery-img"><img src="<?php echo $this->all_function->get_cms_by_page_section_type($org_id,'Footer-Gallary', 'slide-3','image'); ?>" onError="this.onerror=null;this.src='<?php echo base_url(); ?>themes/ecommerce/images/g3.png';" alt="/"></div>
	<div class="gallery-img"><img src="<?php echo $this->all_function->get_cms_by_page_section_type($org_id,'Footer-Gallary', 'slide-4','image'); ?>" onError="this.onerror=null;this.src='<?php echo base_url(); ?>themes/ecommerce/images/g4.png';" alt="/"></div>
</section>
<?php $this->load->view('ecommerce/partial/footer'); ?>
<?php $this->load->view('ecommerce/partial/footer_script'); ?>
    <script>
        function selectRating(rate){
            $("#rating").val(rate);
            $('#rate_div .fa-star').removeAttr('style');
            $('#rate_div .fa-star').each(function(index, value){
                if(index<rate){
                $(this).css('color','#FEC740');
            }
            });
        }
            function submitReview(){
                var url = $("#do-product-comment").attr('action');
                var data = new FormData($("#do-product-comment")[0]);
                $.ajax({
                    url: url,
                    type: 'POST',
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    data: data,
                    success: function (resp) {
                        if (resp.status === 200) {
                            $("#global_succmsg").show();
                        } else {
                            $.each(resp.message, function (key, val) {
                                $('#do-product-comment').find('[name="' + key + '"]').closest('.form-group').find('.text-danger').html(val);
                            });
                        }
                    }
                }).fail(function () {
                });
            }
            function addToCart(){
                $("#favorite_add_cart_errormsg").hide();
                $("#favorite_add_cart_succmsg").hide();
                var data = new FormData();
                data.append("quantity", $("#quantity").val());
                data.append("product_id", $("#product_id").val());
                $.ajax({
                    url: '<?php echo base_url($domain_name.'/ecomm-add-to-cart') ?>',
                    type: 'POST',
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    data: data,
                    success: function (resp) {
                        if (resp.status === 200) {
                            $("#favrate_add_cart_msg").html(resp.message);
                            $("#favorite_add_cart_succmsg").show();
                            //window.location.href='<?php echo base_url($domain_name.'/ecomm-cart')?>'+'.html'
                        } else {
                        }
                    }
                }).fail(function () {
                });
                
            }
            function makeItFavorite(product_id){
            $("#favorite_add_cart_errormsg").hide();
            $("#favorite_add_cart_succmsg").hide();
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
                    $("#favrate_add_cart_msg").html(resp.message);
                    $("#favorite_add_cart_succmsg").show();
                } else {
                    $("#favrate_add_cart_errmsg").html(resp.message);
                    $("#favorite_add_cart_errormsg").show();
                }
            }
        }).fail(function () {
        });
    }
            </script>
</body>
</html>