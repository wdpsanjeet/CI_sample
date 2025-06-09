<!doctype html>
<html lang="en">
<?php $this->load->view('ecommerce/partial/header_script'); ?>
<body>
<?php $this->load->view('ecommerce/partial/withoutmenu_header'); ?>
<section class="inner-body blog-details pt-5">
	<div class="container">
		<div class="row">
			<div class="col-md-4">
				
				<div class="blog-sidebar">
					<div class="search-sec pb-5">
                                            <form action="<?php echo base_url($domain_name.'/ecomm-blogs').'.html';?>" method="get">
                                                <input type="text" name="title" value="">
							<button type="submit"><i class="icofont-search"></i></button>
						</form>
					</div>
					<div class="sidebar-box">
						<h2>Recent Posts</h2>
						<?php foreach($recent_blogs['result'] as $list){?>
						<div class="recent-box">
							<div class="media">
								<div class="media-left">
									<img src="<?php echo base_url(); ?>uploads/blogs/original/<?php echo $list->thumbnail?>">
								</div>
								<div class="media-body">
									<p><?php echo $list->title?></p>
									<div class="auth">By: <span><?php echo $list->added_by?></span></div>
									<div class="blog-date-time">
										<span><i class="fa fa-calendar" aria-hidden="true"></i> <?php echo date('M d / Y',strtotime($list->added_date));?></span>
										<span><i class="fa fa-clock-o" aria-hidden="true"></i><?php echo date('g:iA',strtotime($list->added_date));?></span>
									</div>
								</div>
							</div>
						</div>
                                                <?php }?>
					</div>
					<div class="sidebar-box">
						<h2>Blog Tags</h2>
						<div class="blog-tag">
							<ul>
								<?php foreach($all_tags['result'] as $list){?>
								<li><a <?php echo (isset($tag_id) && $list->tag_id==$tag_id)?'class="active"':'';?> href="<?php echo base_url($domain_name.'/ecomm-blog-tag/'.$list->tag_id.'/'.str_replace(' ', '-', $list->tag_name)).'.html';?>"><?php echo $list->tag_name;?></a></li>
                                                                <?php }?>
							</ul>
						</div>
					</div>	
				</div>

			</div>
			<div class="col-md-8 blog-col">
				<div class="blog-box">
					<div class="blog-cat"><?php echo $blog_detail->tag_name?></div>
					<div class="blog-info">
						<span>By:<b><?php echo $blog_detail->added_by?></b></span>
						<span><i class="fa fa-calendar" aria-hidden="true"></i> <?php echo date('M d / Y',strtotime($blog_detail->added_date));?></span>
						<span><i class="fa fa-clock-o" aria-hidden="true"></i><?php echo date('g:iA',strtotime($blog_detail->added_date));?></span>
					</div>
					<div class="blog-thum">
						<img src="<?php echo base_url(); ?>uploads/blogs/original/<?php echo $blog_detail->thumbnail?>">
					</div>
					
					<div class="blog-des">
						<?php echo $blog_detail->description?>
					</div>

<!--					<div class="row">
						<div class="col-md-6">
							<div class="blog-thum">
								<img src="<?php echo base_url(); ?>themes/frontend/images/img2.png">
							</div>
						</div>
						<div class="col-md-6">
							<div class="blog-thum">
								<img src="<?php echo base_url(); ?>themes/frontend/images/img2.png">
							</div>
						</div>
					</div>-->

<!--					<div class="blog-des">
						<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since.Lorem Ipsum is simply dummy text of Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
						<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since.Lorem Ipsum is simply dummy text of Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
					</div>-->

<!--					<div class="blog-social">
						<a href="#" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
						<a href="#" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>
						<a href="#" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>
						<a href="#" target="_blank"><i class="fa fa-whatsapp" aria-hidden="true"></i></a>
					</div>

					<div class="author-box">
						<div class="media">
							<div class="media-left">
								<div class="author-pic"><img src="<?php echo base_url(); ?>themes/frontend/images/user1.png"></div>
								<div class="author-title">Author</div>
							</div>
							<div class="media-body">
								<div class="blog-cat">Elizabeth Norton</div>
								<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since.</p>
								<div class="blog-social">
									<a href="#" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
									<a href="#" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>
									<a href="#" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>
									<a href="#" target="_blank"><i class="fa fa-whatsapp" aria-hidden="true"></i></a>
								</div>
							</div>
						</div>
					</div>-->

					<div class="related-blog-slide">
						<div id="blog-slider" class="owl-carousel owl-theme">
							<div class="item">
								<div class="blog-slide-box">
									<div class="slide-pic"><img src="<?php echo base_url(); ?>themes/frontend/images/img2.png"></div>
									<div class="slide-cont">
										Lorem Ipsum is simply dummy text of the. Lorem Lorem Ipsum is
									</div>
								</div>
							</div>
							<div class="item">
								<div class="blog-slide-box">
									<div class="slide-pic"><img src="<?php echo base_url(); ?>themes/frontend/images/img2.png"></div>
									<div class="slide-cont">
										Lorem Ipsum is simply dummy text of the. Lorem Lorem Ipsum is
									</div>
								</div>
							</div>
							<div class="item">
								<div class="blog-slide-box">
									<div class="slide-pic"><img src="<?php echo base_url(); ?>themes/frontend/images/img2.png"></div>
									<div class="slide-cont">
										Lorem Ipsum is simply dummy text of the. Lorem Lorem Ipsum is
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="comment-sec">
						<div class="blog-cat">Comments</div>
                                                <?php foreach($all_comments['result'] as $list){?>
						<div class="comment-box">
							<div class="media">
								<div class="media-left">
                                                                    <div class="author-pic"><img src="<?php echo base_url(); ?>uploads/profile_img/original/<?php echo $list->image?>" onerror="this.src='<?php echo base_url(); ?>uploads/profile_img/original/profile_image.png';"></div>
								</div>
								<div class="media-body">
									<div class="comment-title d-flex align-items-center">
										<span class="title"><?php echo $list->name?></span>
										<div class="blog-info">
											<span><i class="fa fa-calendar" aria-hidden="true"></i> <?php echo date('M d / Y',strtotime($list->added_at));?></span>
											<span><i class="fa fa-clock-o" aria-hidden="true"></i><?php echo date('g:iA',strtotime($list->added_at));?></span>
										</div>
									</div>
									<p><?php echo $list->comment?></p>
								</div>
							</div>
						</div>
                                                <?php }?>
						
					</div>


					<div class="comment-frm">
						<div class="blog-cat">Leave a comment</div>
						<div class="comment-frm-wrap">
							<form  action="<?php echo base_url($domain_name.'/do-comment').'.html';?>" method="post" id="do-comment">
                                                            <input type="hidden" name="blogs_id" value="<?php echo $blog_detail->blogs_id;?>" />
                                                            <div class="alert alert-success" role="alert" id="global_succmsg" style="display:none">
                                                                <button type="button" class="close glbclose" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                <strong>Success! </strong><span id="success_msg"> Your comment has been submitted, after review it will publish here!</span>
                                                            </div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
                                                                                    <input type="email" name="email_id" class="form-control" placeholder="Email">
                                                                                        <span class="text-danger"></span>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
                                                                                    <input type="text" name="name" class="form-control" placeholder="Name">
                                                                                        <span class="text-danger"></span>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
                                                                                    <textarea class="form-control" name="comment" placeholder="Your message here"></textarea>
                                                                                        <span class="text-danger"></span>
										</div>
									</div>
								</div>
								<button type="submit">Leave a review</button>
							</form>
						</div>
					</div>


					
				</div>
			</div>
		</div>

<div class="blog-cat-section">
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
					<a href="<?php echo base_url($domain_name.'/ecomm-blog-detail/'.$list->blogs_id.'/'.str_replace(' ', '-', $list->title)).'.html';?>">Read More <i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
				</div>
			</div>
		</div>
            <?php }?>
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
        $(document).on('submit', '#do-comment', function (event) {
        event.preventDefault();
        var url = $(this).attr('action');
        var data = new FormData($(this)[0]);
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
                        $('#do-comment').find('[name="' + key + '"]').closest('.form-group').find('.text-danger').html(val);
                    });
                }
            }
        }).fail(function () {
        });
    });
            function addToCart(){
                var data = new FormData();
                data.append("quantity", $("#quantity").val());
                data.append("product_id", $("#product_id").val());
                $.ajax({
                    url: '<?php echo base_url($domain_name.'/add-to-cart') ?>',
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
            </script>
</body>
</html>