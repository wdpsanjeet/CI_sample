<?php
$ci_class = $this->router->fetch_class();
$ci_method = $this->router->fetch_method();
$selected_menu = '';
if (isset($_GET['tab'])) {
    $selected_menu = $_GET['tab'];
}
$userdata = $this->session->userdata();
//print_r($userdata);exit;
?>

<div id="pcoded" class="pcoded">
    <div class="pcoded-overlay-box"></div>
    <div class="pcoded-container navbar-wrapper">

        <nav class="navbar header-navbar pcoded-header">
            <div class="navbar-wrapper">

                <div class="navbar-logo">
                    <a class="mobile-menu" id="mobile-collapse" href="#!">
                        <i class="ti-menu"></i>
                    </a>
                    <a class="mobile-search morphsearch-search" href="#">
                        <i class="ti-search"></i>
                    </a>
                    <a href="<?php echo base_url('index.php/admin/dashboard'); ?>">
                        <h5>Brandket</h5>
                    </a>
                    <a class="mobile-options">
                        <i class="ti-more"></i>
                    </a>
                </div>

                <div class="navbar-container container-fluid">
                    <ul class="nav-left">
                        <li>
                            <div class="sidebar_toggle"><a href="javascript:void(0)"><i class="ti-menu"></i></a></div>
                        </li>

                        <li>
                            <a href="#!" onclick="javascript:toggleFullScreen()">
                                <i class="ti-fullscreen"></i>
                            </a>
                        </li>
                    </ul>

                </div>
            </div>
        </nav>

        <div class="pcoded-main-container">
            <div class="pcoded-wrapper">
                <nav class="pcoded-navbar">
                    <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
                    <div class="pcoded-inner-navbar main-menu">
                        <div class="">
                            <div class="main-menu-header">
                                <span><?php echo ($this->session->userdata('admin_name') != '') ? $this->session->userdata('admin_name') : 'User'; ?></span>
                            </div>
                            <div class="main-menu-content">
                                <ul>
                                    <li class="more-details" style="display:list-item">
                                        <a href="<?php echo base_url('index.php/admin/editProfile') ?>"><i class="ti-user"></i>Edit Profile</a>
                                    </li>
                                    <li class="more-details"  style="display:list-item">
                                        <a href="<?php echo base_url('index.php/admin/logout') ?>"><i class="ti-layout-sidebar-left"></i>Logout</a>
                                    </li>
                                </ul>

                            </div>


                        </div>

                        <div class="pcoded-navigatio-lavel" data-i18n="nav.category.navigation">Navigation</div>
                        <ul class="pcoded-item pcoded-left-item" style="display:none">
                            <?php if($userdata['admin_role']==0):?>
                            <li class="">
                                    <a href="<?php echo base_url('index.php/admin/user') ?>">
                                        <span class="pcoded-micon"><i class="ti-home"></i><b>D</b></span>
                                        <span class="pcoded-mtext" data-i18n="nav.dash.main">User Management</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>   
                                <li class="">
                                    <a href="<?php echo base_url('index.php/admin/masterproducts') ?>">
                                        <span class="pcoded-micon"><i class="ti-home"></i><b>D</b></span>
                                        <span class="pcoded-mtext" data-i18n="nav.dash.main">Master Products</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
<!--                                <li class="">
                                    <a href="<?php echo base_url('admin/drivers') ?>">
                                        <span class="pcoded-micon"><i class="ti-home"></i><b>D</b></span>
                                        <span class="pcoded-mtext" data-i18n="nav.dash.main">Driver Management</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li> -->
                                
                                <?php endif;?>
                                
                                <?php if($userdata['admin_role']==0):?>
                                
<!--                            <li class="">
                                    <a href="<?php echo base_url('admin/cms') ?>">
                                        <span class="pcoded-micon"><i class="ti-home"></i><b>D</b></span>
                                        <span class="pcoded-mtext" data-i18n="nav.dash.main">CMS Management</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>-->
<!--                                <li class="">
                                    <a href="<?php echo base_url('admin/products') ?>">
                                        <span class="pcoded-micon"><i class="ti-home"></i><b>D</b></span>
                                        <span class="pcoded-mtext" data-i18n="nav.dash.main">Products Management</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>-->
<!--                                <li class="">
                                    <a href="<?php echo base_url('admin/blogs') ?>">
                                        <span class="pcoded-micon"><i class="ti-home"></i><b>D</b></span>
                                        <span class="pcoded-mtext" data-i18n="nav.dash.main">Blogs Management</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>-->
                                
                                
<!--                                <li class="">
                                    <a href="<?php echo base_url('admin/settings') ?>">
                                        <span class="pcoded-micon"><i class="ti-home"></i><b>D</b></span>
                                        <span class="pcoded-mtext" data-i18n="nav.dash.main">Global Settings</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>-->
<!--                                <li class="">
                                    <a href="<?php echo base_url('admin/contactus') ?>">
                                        <span class="pcoded-micon"><i class="ti-home"></i><b>D</b></span>
                                        <span class="pcoded-mtext" data-i18n="nav.dash.main">Contact Us</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>-->
                                <?php endif;?>
                        </ul>


                    </div>
                </nav>
                <div class="pcoded-content">
                    <div class="pcoded-inner-content">
                        <div class="main-body">
                            <div class="page-wrapper">