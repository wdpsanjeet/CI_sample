<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//********************API Routes**********************
$route['apiclient/registration'] = 'apiclient/index/registration';
$route['apiclient/otpVarified'] = 'apiclient/index/otp_verification';
$route['apiclient/login'] = 'apiclient/index/login';
$route['apiclient/updateProfile'] = 'apiclient/index/update_profile';
$route['apiclient/updateProfilepicture'] = 'apiclient/index/update_profilepicture';
$route['apiclient/resendOtp'] = 'apiclient/index/resend_otp';
$route['apiclient/getShopType'] = 'apiclient/index/shop_type';
$route['apiclient/clientShopUpdate'] = 'apiclient/index/shop_update';
$route['apiclient/getProductCategoryType'] = 'apiclient/index/category_type';
$route['apiclient/getProductByCategoryID'] = 'apiclient/index/product_by_category';
$route['apiclient/getProductByName'] = 'apiclient/index/product_by_name';
$route['apiclient/getTopItems'] = 'apiclient/index/get_top_items';
$route['apiclient/getPopularItems'] = 'apiclient/index/get_popular_products';
$route['apiclient/addUpdateCart'] = 'apiclient/index/add_cart';
$route['apiclient/removeItemFromCart'] = 'apiclient/index/remove_cart';
$route['apiclient/getCart'] = 'apiclient/index/get_cart';
$route['apiclient/submitOrder'] = 'apiclient/index/submit_order';
$route['apiclient/updateOrder'] = 'apiclient/index/update_order';
$route['apiclient/getOrder'] = 'apiclient/index/get_orders';
$route['apiclient/getOrderDetailByID'] = 'apiclient/index/get_order_detail';
$route['apiclient/getOrderInvoiceByOrderID'] = 'apiclient/index/get_order_invoice';

$route['apiclient/getFeaturedCategory'] = 'apiclient/index/category_featured_type';

$route['apiclient/getNotifications'] = 'apiclient/index/notification';
$route['apiclient/getUserAddressDetail'] = 'apiclient/index/user_shipping_detail';
$route['apiclient/updateUserShippingDetail'] = 'apiclient/index/update_user_shipping_detail';

?>