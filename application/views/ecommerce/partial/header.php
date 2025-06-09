<div class="bodyOverlay"></div>
<div class="responsive_nav"></div>
<?php
$r_cls = $this->router->fetch_class();
$r_meth = $this->router->fetch_method();
$client_id = $this->session->userdata('client_id');
?>
<header class="site-header">
	<div class="container">
		<div class="top-header d-flex">
			<div class="logo-section">
                            <a href="<?php echo base_url($domain_name.'/index').'.html';?>"><img style="height: 80px;" src="<?php echo $this->all_function->get_cms_by_page_section_type($org_id,'Home-Page', 'Logo','image'); ?>" onError="this.onerror=null;this.src='<?php echo base_url(); ?>themes/frontend/img/Vlogo.png';" alt=""></a>
			</div>
			<div class="menu-section">
				<nav class="navbar navbar-expand-md">
				  <button class="navbar-toggler menu_toggle" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
				    <span class="navbar-toggler-icon"></span>
				  </button>
				 <div class="nav-sup collapse navbar-collapse" id="navbarSupportedContent">
				        <ul>
				        	<li <?php echo ($r_cls=='ecommerce' && $r_meth=='index')?'class="active"':'';?>><a href="<?php echo base_url($domain_name.'/index').'.html';?>">Home</a></li>
				        	<li <?php echo ($r_cls=='ecommerce' && $r_meth=='about_us')?'class="active"':'';?>><a href="<?php echo base_url($domain_name.'/ecomm-about-us').'.html'?>">About Us</a></li>
				        	<li <?php echo ($r_cls=='ecommerce' && $r_meth=='blogs')?'class="active"':'';?>><a href="<?php echo base_url($domain_name.'/ecomm-blogs').'.html'?>">Blog</a></li>
				        	<li <?php echo ($r_cls=='ecommerce' && $r_meth=='contact_us')?'class="active"':'';?>><a href="<?php echo base_url($domain_name.'/ecomm-contact-us').'.html'?>">Contact Us</a></li>
                                                <?php if($client_id==''){?>
				        	<li <?php echo ($r_cls=='ecommerce' && $r_meth=='login')?'class="active"':'';?>><a href="<?php echo base_url($domain_name.'/ecomm-login').'.html'?>">Login</a></li>
                                                <?php }?>
				      	</ul>
				      </div>
 					<span class="responsive_btn"><span></span></span>
				</nav>
			</div>
			<div class="search-sec">
                            <form action="<?php echo base_url($domain_name.'/product-list').'.html';?>" method="get">
                                <input type="text" name="product_title" value="<?php echo (isset($product_title))?$product_title:'';?>">
					<button type="submit"><i class="icofont-search"></i></button>
				</form>
			</div>
			<div class="top-info-sec">
				<ul>
                                    <?php if($client_id!=''){?>
        <li class="nav-item dropdown">
        <a class="menu_icons dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="icofont-user-alt-3"></i>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="<?php echo base_url($domain_name.'/ecomm-order-list').'.html'?>">Your Orders</a>
<!--          <a class="dropdown-item" href="#">Buy Again</a>-->
          <a class="dropdown-item" href="<?php echo base_url($domain_name.'/ecomm-wish-list').'.html'?>">Your Wish List</a>
          <a class="dropdown-item" href="<?php echo base_url($domain_name.'/your-account').'.html'?>">Your Account</a>
          <a class="dropdown-item" href="<?php echo base_url($domain_name.'/ecomm-logout').'.html'?>">Log Out</a>
        </div>
                                            
                                        </li>
                                    <?php }else{?>
                                        <li><a class="menu_icons" href="<?php echo base_url($domain_name.'/ecomm-login').'.html'?>"><i class="icofont-user-alt-3"></i></a></li>
                                        <?php }?>
                                        <li><a class="menu_icons" href="<?php echo base_url($domain_name.'/ecomm-cart').'.html'?>"><i class="icofont-cart"></i></a></li>
				</ul>
			</div>
		</div>
		<div class="dropdown mt-5 cat-drop">
		  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		    <span  class="menu-icon"></span> All Categories
		  </button>
		  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <?php foreach($all_sub_category['result'] as $list){?>
                            <a class="dropdown-item" href="<?php echo base_url($domain_name.'/products-by-category/'.$list->product_category_id.'/'.str_replace(' ', '-', $list->category_name)).'.html';?>"><i class="icofont-users"></i> <?php echo $list->category_name?></a>
                            <?php }?>
			    
		  </div>
		</div>
            <div class="alert alert-success" role="alert" id="global_alternate_succmsg" style="display: none;">
                <button type="button" class="close glbclose" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Success! </strong><span id="alternate_success_msg"></span>
            </div>
	</div>
</header>