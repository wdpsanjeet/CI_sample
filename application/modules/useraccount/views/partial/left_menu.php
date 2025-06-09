<?php
$ci_class = $this->router->fetch_class();
$ci_method = $this->router->fetch_method();
?>
<div class="lft_sidebar">
        <nav class="bd_navbar">
            <a class="navbar-brand" href="<?php echo base_url();?>">
                <img src="<?php echo base_url() ?>themes/useraccount/images/Vlogo.png" style="max-width: 275px;">
            <h1><span>Organization ID - <?php echo $this->session->userdata('company_code');?></span></h1>
          </a>
          <ul class="navbar-nav">
            <li class="nav-item <?php echo ($ci_method=='index')?'active':'';?>">
                <a class="nav-link" href="<?php echo base_url('useraccount/dashboard').'.html';?>"><i class="fa fa-home" aria-hidden="true"></i><span>Dashboard</span></a>
            </li>
            <?php if(isset($menu[MODULE_PRODUCT_ID]) && $menu[MODULE_PRODUCT_ID]){?>
            <li class="nav-item <?php echo ($ci_method=='products' || $ci_method=='add_product' || $ci_method=='edit_product')?'active':'';?>">
              <a class="nav-link" href="<?php echo base_url('useraccount/products').'.html';?>"><i class="fa fa-shopping-basket" aria-hidden="true"></i><span>Products</span></a>
            </li>
            <?php }?>
            <?php if(isset($menu[MODULE_CMSMANAGEMENT_ID]) && $menu[MODULE_CMSMANAGEMENT_ID]){?>
            <li class="nav-item <?php echo ($ci_method=='cms_mgm')?'active':'';?>">
              <a class="nav-link" href="<?php echo base_url('useraccount/cms').'.html';?>"><i class="fa fa-home" aria-hidden="true"></i><span>CMS Management</span></a>
            </li>
            <?php }?>
            <?php if(isset($menu[MODULE_BLOGS_ID]) && $menu[MODULE_BLOGS_ID]){?>
            <li class="nav-item <?php echo ($ci_method=='blogs')?'active':'';?>">
              <a class="nav-link" href="<?php echo base_url('useraccount/blogs').'.html';?>"><i class="fa fa-home" aria-hidden="true"></i><span>Blogs</span></a>
            </li>
            <?php }?>
            <?php if(isset($menu[MODULE_ORDERMANAGEMENT_ID]) && $menu[MODULE_ORDERMANAGEMENT_ID]){?>
            <li class="nav-item <?php echo ($ci_method=='order_mgm')?'active':'';?>">
              <a class="nav-link" href="<?php echo base_url('useraccount/orders').'.html';?>"><i class="fa fa-home" aria-hidden="true"></i><span>Order Management</span></a>
            </li>
            <?php }?>
            <?php if(isset($menu[MODULE_SALES_ID]) && $menu[MODULE_SALES_ID]){?>
            <li class="nav-item <?php echo ($ci_method=='sales')?'active':'';?>">
              <a class="nav-link" href="<?php echo base_url('useraccount/sales').'.html';?>"><i class="fa fa-shopping-cart" aria-hidden="true"></i><span>Sales</span></a>
            </li>
            <?php }?>
            <?php if(isset($menu[MODULE_PURCHASE_ID]) && $menu[MODULE_PURCHASE_ID]){?>
            <li class="nav-item <?php echo ($ci_method=='purchase')?'active':'';?>">
              <a class="nav-link" href="<?php echo base_url('useraccount/purchase').'.html';?>"><i class="fa fa-briefcase" aria-hidden="true"></i><span>Purchase</span></a>
            </li>
            <?php }?>
            <?php if(isset($menu[MODULE_STAFF_ID]) && $menu[MODULE_STAFF_ID]){?>
            <li class="nav-item <?php echo ($ci_method=='get_staff')?'active':'';?>">
              <a class="nav-link" href="<?php echo base_url('useraccount/getStaff').'.html';?>"><i class="fa fa-users" aria-hidden="true"></i><span>Staffs</span></a>
            </li>
            <?php }?>
            <?php if(isset($menu[MODULE_ROLEPERMISSION_ID]) && $menu[MODULE_ROLEPERMISSION_ID]){?>
            <li class="nav-item <?php echo ($ci_method=='roles')?'active':'';?>">
              <a class="nav-link" href="<?php echo base_url('useraccount/roles').'.html';?>"><i class="fa fa-key" aria-hidden="true"></i><span>Roles Permissions</span></a>
            </li>
            <?php }?>
            <?php if(isset($menu[MODULE_REPORT_ID]) && $menu[MODULE_REPORT_ID]){?>
            <li class="nav-item <?php echo ($ci_method=='editProfile')?'active':'';?>">
              <a class="nav-link" href="#"><i class="fa fa-line-chart" aria-hidden="true"></i><span>Report</span></a>
            </li>
            <?php }?>
            <?php if(isset($menu[MODULE_SUPPORT_ID]) && $menu[MODULE_SUPPORT_ID]){?>
            <li class="nav-item <?php echo ($ci_method=='support')?'active':'';?>">
              <a class="nav-link" href="<?php echo base_url('useraccount/support').'.html';?>"><i class="fa fa-comment-o" aria-hidden="true"></i><span>Support</span></a>
            </li>
            <?php }?>
            <?php if($userDetailInfo->plan_id=='2'){?>
            <li class="nav-item <?php echo ($ci_method=='warehouse')?'active':'';?>">
              <a class="nav-link" href="<?php echo base_url('useraccount/warehouse').'.html';?>"><i class="fa fa-home" aria-hidden="true"></i><span>Warehouse</span></a>
            </li>
            <li class="nav-item <?php echo ($ci_method=='drivers')?'active':'';?>">
              <a class="nav-link" href="<?php echo base_url('useraccount/drivers').'.html';?>"><i class="fa fa-car" aria-hidden="true"></i><span>Drivers</span></a>
            </li>
            <li class="nav-item <?php echo ($ci_method=='trips')?'active':'';?>">
              <a class="nav-link" href="<?php echo base_url('useraccount/trips').'.html';?>"><i class="fa fa-map-pin" aria-hidden="true"></i><span>Trips</span></a>
            </li>
            <li class="nav-item <?php echo ($ci_method=='clients')?'active':'';?>">
              <a class="nav-link" href="<?php echo base_url('useraccount/clients').'.html';?>"><i class="fa fa-users" aria-hidden="true"></i><span>Clients</span></a>
            </li>
            <li class="nav-item <?php echo ($ci_method=='live_tracking')?'active':'';?>">
              <a class="nav-link" href="<?php echo base_url('useraccount/live-tracking').'.html';?>"><i class="fa fa-life-ring" aria-hidden="true"></i><span>Live Tracking</span></a>
            </li>
            <?php }?>
            <div class="def-btn"><a href="<?php echo base_url('useraccount/subscriptions').'.html';?>">Upgrade</a></div>
          </ul>
        </nav>
      </div>