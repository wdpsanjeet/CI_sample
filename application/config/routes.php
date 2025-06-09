<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
  | -------------------------------------------------------------------------
  | URI ROUTING
  | -------------------------------------------------------------------------
  | This file lets you re-map URI requests to specific controller functions.
  |
  | Typically there is a one-to-one relationship between a URL string
  | and its corresponding controller class/method. The segments in a
  | URL normally follow this pattern:
  |
  |	example.com/class/method/id/
  |
  | In some instances, however, you may want to remap this relationship
  | so that a different class/function is called than the one
  | corresponding to the URL.
  |
  | Please see the user guide for complete details:
  |
  |	https://codeigniter.com/user_guide/general/routing.html
  |
  | -------------------------------------------------------------------------
  | RESERVED ROUTES
  | -------------------------------------------------------------------------
  |
  | There are three reserved routes:
  |
  |	$route['default_controller'] = 'welcome';
  |
  | This route indicates which controller class should be loaded if the
  | URI contains no data. In the above example, the "welcome" class
  | would be loaded.
  |
  |	$route['404_override'] = 'errors/page_missing';
  |
  | This route will tell the Router which controller/method to use if those
  | provided in the URL cannot be matched to a valid route.
  |
  |	$route['translate_uri_dashes'] = FALSE;
  |
  | This is not exactly a route, but allows you to automatically route
  | controller and method names that contain dashes. '-' isn't a valid
  | class or method name character, so it requires translation.
  | When you set this option to TRUE, it will replace ALL dashes in the
  | controller and method URI segments.
  |
  | Examples:	my-controller/index	-> my_controller/index
  |		my-controller/my-method	-> my_controller/my_method
 */
$route['default_controller'] = 'index';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

//Static pages
$route['varthakpolicy'] = 'index/policy';
$route['about-us'] = 'index/about_us';
//$route['products'] = 'index/products';
$route['pricing'] = 'index/pricing';

//Dynamic pages
//$route['blogs'] = 'index/blogs';
$route['contact-us'] = 'index/contact_us';
$route['contact-form'] = 'index/contact_form_store';
$route['news-subscription-form'] = 'index/news_subscription_form';
//$route['demo'] = 'index/demo';
//$route['demo-form'] = 'index/demo_form_store';
$route['login'] = 'index/login';
$route['resendotp'] = 'index/resend_otp';
$route['verify-otp'] = 'index/otp_verification';
$route['do-login'] = 'index/dologin';
$route['logout'] = 'index/logout';
$route['signup'] = 'index/signup';
$route['do-signup'] = 'index/dosignup';
$route['signup-verify-otp'] = 'index/signupotp_verification';
$route['create-organisation'] = 'index/create_company_at_registration';
$route['verify-email'] = 'index/verify_email';

//$route['checkout/(:any)'] = 'index/checkout/$1';
//$route['initiate-subscription'] = 'index/subscription_initiate';
//$route['checkout-verify'] = 'index/verify';
//$route['checkout-notify'] = 'index/notify';
//$route['checkout-success'] = 'index/success';
//$route['checkout-failed'] = 'index/paymentFailed';
//$route['dummy-records/(:any)'] = 'index/dummy_apps_records/$1';
$route['text-mail'] = 'index/test_mail_template';
$route['simple-mail'] = 'index/simple_mail';

/************* dynamic ecommerce website pages**********/
//Static pages
$route['(:any)/index'] = 'ecommerce/index/$1';
$route['(:any)/ecomm-about-us'] = 'ecommerce/about_us/$1';
$route['(:any)/ecomm-blogs'] = 'ecommerce/blogs/$1';
$route['(:any)/ecomm-blog-detail/(:any)/(:any)'] = 'ecommerce/blog_details/$1/$2/$3';
$route['(:any)/ecomm-blog-tag/(:any)/(:any)'] = 'ecommerce/blog_tags/$1/$2/$3';
$route['(:any)/ecomm-contact-us'] = 'ecommerce/contact_us/$1';
$route['(:any)/ecomm-login'] = 'ecommerce/login/$1';
$route['(:any)/ecomm-logout'] = 'ecommerce/logout/$1';
$route['(:any)/your-account'] = 'ecommerce/my_account/$1';
$route['(:any)/ecomm-update-account'] = 'ecommerce/update_account/$1';
$route['(:any)/ecomm-signup'] = 'ecommerce/signup/$1';
$route['(:any)/ecomm-do-signup'] = 'ecommerce/dosignup/$1';
$route['(:any)/ecomm-verify-otp'] = 'ecommerce/verify_otp/$1';
$route['(:any)/ecomm-resendotp'] = 'ecommerce/resend_otp/$1';
$route['(:any)/ecomm-update-company-information'] = 'ecommerce/updatecompanyinfo/$1';
$route['(:any)/ecomm-city-list-by-state'] = 'ecommerce/get_city_list/$1';
$route['(:any)/ecomm-do-update-company-information'] = 'ecommerce/doupdatecompanyinfo/$1';
$route['(:any)/ecomm-cart'] = 'ecommerce/cart/$1';

$route['(:any)/ecomm-add-to-cart'] = 'ecommerce/add_to_cart/$1';
$route['(:any)/ecomm-remove-to-cart'] = 'ecommerce/remove_to_cart/$1';
$route['(:any)/ecomm-place-cart-order'] = 'ecommerce/place_cart_order/$1';

$route['(:any)/product-list'] = 'ecommerce/products/$1';
$route['(:any)/products/(:any)'] = 'ecommerce/products/$1/$2';
$route['(:any)/products-by-category/(:any)/(:any)'] = 'ecommerce/products_by_category/$1/$2/$3';
$route['(:any)/products-by-category/(:any)/(:any)/(:any)'] = 'ecommerce/products_by_category/$1/$2/$3/$4';
$route['(:any)/product-detail/(:any)/(:any)'] = 'ecommerce/product_detail/$1/$2/$3';
$route['(:any)/do-product-comment'] = 'ecommerce/doproductcomment/$1';
$route['(:any)/ecomm-order-list'] = 'ecommerce/order_list/$1';
$route['(:any)/ecomm-order-detail/(:any)'] = 'ecommerce/order_detail/$1/$2';
$route['(:any)/ecomm-cancel-order'] = 'ecommerce/cancel_order/$1';
$route['(:any)/ecomm-wish-list'] = 'ecommerce/wish_list/$1';
$route['(:any)/ecomm-make-it-favorite'] = 'ecommerce/makeitfavorite/$1';
$route['(:any)/ecomm-remove-it-favorite'] = 'ecommerce/removeitfavorite/$1';

$route['(:any)/do-login-ecomm'] = 'ecommerce/dologin/$1';
$route['(:any)/ecomm-login-verify-otp'] = 'ecommerce/login_verify_otp/$1';

/************* dynamic pages**********/

//Load Modules route 
if (file_exists(APPPATH . 'modules')) {
    $modulesPath = APPPATH . 'modules/';
    $modules = array_diff(scandir($modulesPath), array('..', '.'));
    foreach ($modules as $module):
        if (is_dir($modulesPath) . '/' . $module) {
            $routePath = $modulesPath . $module . '/config/routes.php';
            if (file_exists($routePath)) {
                require $routePath;
            }
        }
    endforeach;
}