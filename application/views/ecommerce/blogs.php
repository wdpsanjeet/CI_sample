<!doctype html>
<html lang="en">
<?php $this->load->view('ecommerce/partial/header_script'); ?>
<body>
<?php $this->load->view('ecommerce/partial/withoutmenu_header'); ?>
    
<section class="inner-body pt-5">
	<div class="container">
		<div class="row">
			<div class="col-lg-4 col-md-12 col-sm-12 col-12">
				
				<div class="blog-sidebar">
					<div class="search-sec pb-5">
                                            <form action="" method="get">
                                                <input type="text" name="title" value="<?php echo (isset($title))?$title:''?>">
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
			<div class="col-lg-8 col-md-12 col-sm-12 col-12 blog-col">
                            <?php foreach($all_blogs['result'] as $list){?>
				<div class="blog-box">
					<div class="blog-thum">
						<img src="<?php echo base_url(); ?>uploads/blogs/original/<?php echo $list->thumbnail?>">
					</div>
					<div class="blog-cat"><?php echo $list->tag_name?></div>
					<div class="blog-info">
						<span>By:<b><?php echo $list->added_by?></b></span>
						<span><i class="fa fa-calendar" aria-hidden="true"></i> <?php echo date('M d / Y',strtotime($list->added_date));?></span>
						<span><i class="fa fa-clock-o" aria-hidden="true"></i><?php echo date('g:iA',strtotime($list->added_date));?></span>
					</div>
					<div class="blog-title"><?php echo $list->title?></div>
					<div class="blog-des">
						<?php echo $list->description?>
					</div>
					<div class="blog-btn">
                                            <a href="<?php echo base_url($domain_name.'/ecomm-blog-detail/'.$list->blogs_id.'/'.str_replace(' ', '-', $list->title)).'.html';?>">Read More <i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
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
    
    function makeItFavorite(product_id){
        var url = '<?php echo base_url($domain_name,'make-it-favorite');?>';
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
    function addToCart(product_id){
                var data = new FormData();
                data.append("quantity", '1');
                data.append("product_id", product_id);
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