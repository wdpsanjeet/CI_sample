<?php

defined('BASEPATH') or exit('No direct script access allowed');

/*
  |--------------------------------------------------------------------------
  | Display Debug backtrace
  |--------------------------------------------------------------------------
  |
  | If set to TRUE, a backtrace will be displayed along with php errors. If
  | error_reporting is disabled, the backtrace will not display, regardless
  | of this setting
  |
 */
defined('SHOW_DEBUG_BACKTRACE') or define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
  |--------------------------------------------------------------------------
  | File and Directory Modes
  |--------------------------------------------------------------------------
  |
  | These prefs are used when checking and setting modes when working
  | with the file system.  The defaults are fine on servers with proper
  | security, but you may wish (or even need) to change the values in
  | certain environments (Apache running a separate process for each
  | user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
  | always be used to set the mode correctly.
  |
 */
defined('FILE_READ_MODE') or define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') or define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE') or define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE') or define('DIR_WRITE_MODE', 0755);

/*
  |--------------------------------------------------------------------------
  | File Stream Modes
  |--------------------------------------------------------------------------
  |
  | These modes are used when working with fopen()/popen()
  |
 */
defined('FOPEN_READ') or define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE') or define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE') or define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE') or define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE') or define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE') or define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT') or define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT') or define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
  |--------------------------------------------------------------------------
  | Exit Status Codes
  |--------------------------------------------------------------------------
  |
  | Used to indicate the conditions under which the script is exit()ing.
  | While there is no universal standard for error codes, there are some
  | broad conventions.  Three such conventions are mentioned below, for
  | those who wish to make use of them.  The CodeIgniter defaults were
  | chosen for the least overlap with these conventions, while still
  | leaving room for others to be defined in future versions and user
  | applications.
  |
  | The three main conventions used for determining exit status codes
  | are as follows:
  |
  |    Standard C/C++ Library (stdlibc):
  |       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
  |       (This link also contains other GNU-specific conventions)
  |    BSD sysexits.h:
  |       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
  |    Bash scripting:
  |       http://tldp.org/LDP/abs/html/exitcodes.html
  |
 */
defined('EXIT_SUCCESS') or define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR') or define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG') or define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE') or define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS') or define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') or define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT') or define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE') or define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN') or define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX') or define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code
define('COOKIES_EXPIRE', time() + 60 * 60 * 24 * 365 * 10);

///////////////////Tables////////////////////////////////////
define('TBL_ADMIN', 'admins');
define('TBL_ADDRESSES', 'addresses');
define('TBL_CMS', 'cms_mgm');
define('TBL_CMSDEFAULTGLOBAL', 'cms_default_setup');
define('TBL_BLOGS', 'blogs_mgm');
define('TBL_BLOGTAG', 'blog_tags');
define('TBL_BLOGCOMMENT', 'blog_comment');
define('TBL_PRODUCTCOMMENT', 'product_comment');
define('TBL_SETTINGS', 'settings');
define('TBL_CONTACTUS', 'contact_us');
define('TBL_DEMOREQUEST', 'demo_request');
define('TBL_USER_MASTER', 'user_master');
define('TBL_DRIVERS', 'driver_master');
define('TBL_DRIVERASSIGNEDTRIP', 'driver_assigned_trip');
define('TBL_DELIVERIESMASTER', 'deliveries_master');
define('TBL_CLIENTROUTE', 'client_route');
define('TBL_PRODUCTCATEGORY', 'product_category');
define('TBL_PRODUCTMASTER', 'product_master');
define('TBL_CLIENTMASTER', 'client_master');
define('TBL_CLIENTCARTMASTER', 'client_cart_master');
define('TBL_CLIENTFAVORITE', 'client_favorite');
define('TBL_SHOPTYPE', 'shop_type');
define('TBL_CITIES', 'cities');
define('TBL_ORDERMASTER', 'order_master');
define('TBL_ORDERDETAIL', 'order_detail');
define('TBL_DRIVERTRIPCLIENT', 'driver_trip_clients');
define('TBL_TRIPPAYMENT', 'trip_payment');
define('TBL_PRICINGPLAN', 'pricing_plan');
define('TBL_DRIVERNOTIFICATION', 'driver_notification');
define('TBL_BANKMASTER', 'bank_master');
define('TBL_SUBSCRIPTIONHISTORY', 'subscription_history');
define('TBL_DRIVERREQUEST', 'driver_request');
define('TBL_TICKETMASTER', 'ticket_master');
define('TBL_WAREHOUSE', 'user_warehouse');
define('TBL_USERNOTIFICATION', 'user_notification');
define('TBL_CUSTOMERIMPORT', 'customer_importorder');
define('TBL_SALESMASTER', 'sales_master');
define('TBL_SALESDETAIL', 'sales_detail');
define('TBL_PURCHASEMASTER', 'purchase_master');
define('TBL_PURCHASEDETAIL', 'purchase_detail');
define('TBL_ORGANISATIONMASTER', 'organisation_master');
define('TBL_VARTHAKPRODUCT', 'varthak_product');
define('TBL_VARTHAKPRODUCTCATEGORY', 'varthak_product_category');
define('TBL_ORGANISATIONUSER', 'organisation_users');
define('TBL_NEWSSUBSCRIPTION', 'news_subscription');
define('TBL_LANGUAGEMASTER', 'language_master');
define('TBL_CARTMASTER', 'cart_master');
define('TBL_STORECARTMASTER', 'store_cart_master');
define('TBL_PAYMENT', 'payment');
define('TBL_RECEIVABLE', 'receivable');
define('TBL_ORGANISATIONCONTACTS', 'organisation_contacts');
define('TBL_ROLEMASTER', 'role_master');
define('TBL_PRIVILAGEMODULE', 'privilege_module');
define('TBL_ASSIGNPERMISSION', 'assign_permission');
define('TBL_ASSIGNPERMISSIONDEFAULT', 'assign_permission_default');

define('MODULE_SALES_ID', '1');
define('MODULE_PURCHASE_ID', '2');
define('MODULE_STAFF_ID', '3');
define('MODULE_ROLEPERMISSION_ID', '4');
define('MODULE_REPORT_ID', '5');
define('MODULE_SUPPORT_ID', '6');
define('MODULE_PRODUCT_ID', '7');
define('MODULE_CMSMANAGEMENT_ID', '8');
define('MODULE_BLOGS_ID', '9');
define('MODULE_ORDERMANAGEMENT_ID', '10');
define('MODULE_DRIVERS_ID', '11');
define('MODULE_ACCESS_TYPE_VIEW', 'view');
define('MODULE_ACCESS_TYPE_ADD', 'add');
define('MODULE_ACCESS_TYPE_EDIT', 'edit');
define('MODULE_ACCESS_TYPE_DELETE', 'delete');

define('GOGGLE_MAP_KEY', 'AIzaSyAg2Yum9U-hDbMoGePfXxFyQzZhNtozXhI');
define('DELETE_STATUS', -1);
define("HTTP_NOT_FOUND", 404);
define("HTTP_BAD_REQUEST", 400);
define("HTTP_DUPLICATE", 409);
define("HTTP_OK_RESPONSE", 200);

define("PAYMENT_CREATED", 0);
define("PAYMENT_APPROVAL_REQUIRED", 2);
define("PAYMENT_EDIT_APPROVAL_REQUIRED", 3);
define("PAYMENT_APPROVED", 1);
define("PAYMENT_REJECTED", -1);

define("ORDER_CREATED", '0');
define("ORDER_EDIT_APPROVAL_NOTIFY", '2');
define("ORDER_REJECT_EDIT_APPROVAL_NOTIFY", '3');
define("ORDER_MERGE_APPROVAL_NOTIFY", '4');
define("ORDER_APPROVED", '1');
define("ORDER_REJECTED", '-1');
define("ORDER_REJECT_ON_EDIT", '-2');
define("ORDER_EDIT_ON_REJECT", '-3');
define("ORDER_MERGE_ON_REJECT", '-4');

define('INVOICE_ENABLE', 1);
define('INVOICE_DISABLE', 0);
