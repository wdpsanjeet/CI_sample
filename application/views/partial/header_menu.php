<?php
$r_cls = $this->router->fetch_class();
$r_meth = $this->router->fetch_method();
?>
<header class="header_area">
            <nav class="navbar navbar-expand-lg menu_one menu_four">
                <div class="container">
                    <a class="navbar-brand sticky_logo" href="<?php echo base_url();?>"><img src="<?php echo base_url().'themes/frontend/'?>img/Vlogo.png" 
                            alt="logo"><img src="<?php echo base_url().'themes/frontend/'?>img/Vlogo.png"  alt=""></a>
                    <button class="navbar-toggler collapsed" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="menu_toggle">
                            <span class="hamburger">
                                <span></span>
                                <span></span>
                                <span></span>
                            </span>
                            <span class="hamburger-cross">
                                <span></span>
                                <span></span>
                            </span>
                        </span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav menu w_menu ml-auto">
                            <li class="nav-item dropdown submenu mega_menu mega_menu_two <?php echo ($r_cls=='index' && $r_meth=='index')?'active':'';?>">
                                <a class="nav-link dropdown-toggle" href="<?php echo base_url();?>" role="button" data-toggle="click"
                                    aria-haspopup="true" aria-expanded="false">
                                    Home
                                </a>
                            </li>
                            <li class="nav-item dropdown submenu mega_menu <?php echo ($r_cls=='index' && $r_meth=='pricing')?'active':'';?>">
                                <a class="nav-link dropdown-toggle" href="<?php echo base_url();?>pricing.html" role="button" data-toggle="click"
                                    aria-haspopup="true" aria-expanded="false">
                                    Pricing Plan
                                </a>                             
                            </li>
                            <li class="nav-item dropdown submenu mega_menu <?php echo ($r_cls=='index' && $r_meth=='policy')?'active':'';?>">
                                <a class="nav-link dropdown-toggle" href="<?php echo base_url();?>varthakpolicy.html" role="button" data-toggle="click"
                                    aria-haspopup="true" aria-expanded="false">
                                    Privacy Policy
                                </a>                             
                            </li>
                            <li class="nav-item dropdown submenu <?php echo ($r_cls=='index' && $r_meth=='about_us')?'active':'';?>">
                                <a class="nav-link dropdown-toggle" href="<?php echo base_url();?>about-us.html" role="button" data-toggle="click"
                                    aria-haspopup="true" aria-expanded="false">
                                    About us
                                </a>
                            </li>
                            <li class="nav-item dropdown submenu <?php echo ($r_cls=='index' && $r_meth=='contact_us')?'active':'';?>">
                                <a class="nav-link dropdown-toggle" href="<?php echo base_url();?>contact-us.html" role="button" data-toggle="click"
                                    aria-haspopup="true" aria-expanded="false">
                                    Contact us
                                </a>
                            </li>
                            
                            
                        </ul>
                       
                    </div>
                </div>
                
            </nav>
    
        </header>
