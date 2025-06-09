<?php

defined('BASEPATH') OR exit('No direct script access allowed');

//********************Admin Routes**********************
$route['useraccount/edit-profile'] = 'useraccount/dashboard/editProfile';
$route['useraccount/dashboard'] = 'useraccount/dashboard/index';
$route['useraccount/notifications'] = 'useraccount/dashboard/notifications';
$route['useraccount/support'] = 'useraccount/dashboard/support';
$route['useraccount/do-support'] = 'useraccount/dashboard/dosupport';

$route['useraccount/add-fav-customer'] = 'useraccount/dashboard/addFavCustomer';
$route['useraccount/sales'] = 'useraccount/dashboard/sales';
$route['useraccount/add-sales'] = 'useraccount/dashboard/add_sales';
$route['useraccount/do-add-sales'] = 'useraccount/dashboard/doaddsales';
$route['useraccount/edit-sales/(:any)'] = 'useraccount/dashboard/edit_sales/$1';
$route['useraccount/confirmSales'] = 'useraccount/dashboard/confirmSales';
$route['useraccount/receivables-list'] = 'useraccount/dashboard/get_receivables';
$route['useraccount/get-client-by-orgid'] = 'useraccount/dashboard/getclientbyorgid';
$route['useraccount/get-product-detail-by-id'] = 'useraccount/dashboard/getproductdetailbyid';
$route['useraccount/purchase'] = 'useraccount/dashboard/purchase';
$route['useraccount/add-purchase'] = 'useraccount/dashboard/add_purchase';
$route['useraccount/edit-purchase/(:any)'] = 'useraccount/dashboard/edit_purchase/$1';
$route['useraccount/do-add-purchase'] = 'useraccount/dashboard/doaddpurchase';
$route['useraccount/confirmPurchase'] = 'useraccount/dashboard/confirmPurchase';
$route['useraccount/add-payment'] = 'useraccount/dashboard/addPayment';
$route['useraccount/payment-list'] = 'useraccount/dashboard/get_payments';
$route['useraccount/confirm-payment'] = 'useraccount/dashboard/confirmPayment';


$route['useraccount/organisation-list'] = 'useraccount/dashboard/organisationlist';
$route['useraccount/add-organisation'] = 'useraccount/dashboard/add_organisation';
$route['useraccount/do-add-organisation'] = 'useraccount/dashboard/doaddorganisation';
$route['useraccount/reset-0rganisation'] = 'useraccount/dashboard/reset0rganisation';

$route['useraccount/products'] = 'useraccount/dashboard/products';
$route['useraccount/add-product'] = 'useraccount/dashboard/add_product';
$route['useraccount/search-product-by-category-id'] = 'useraccount/dashboard/searchproductbycategoryid';
$route['useraccount/do-add-product'] = 'useraccount/dashboard/doaddproduct';
$route['useraccount/do-add-master-product'] = 'useraccount/dashboard/doaddmasterproduct';
$route['useraccount/edit-product/(:any)'] = 'useraccount/dashboard/edit_product/$1';

$route['useraccount/products-is-popular-update'] = 'useraccount/dashboard/products_popular_status_update';
$route['useraccount/products-is-topitem-update'] = 'useraccount/dashboard/products_topitem_status_update';
$route['useraccount/products-is-hotitem-update'] = 'useraccount/dashboard/products_hotitem_status_update';

$route['useraccount/addStaff'] = 'useraccount/dashboard/add_staff';
$route['useraccount/editStaff/(:any)'] = 'useraccount/dashboard/edit_staff/$1';
$route['useraccount/do-add-staff'] = 'useraccount/dashboard/doaddstaff';
$route['useraccount/getStaff'] = 'useraccount/dashboard/get_staff';
$route['useraccount/deleteStaff'] = 'useraccount/dashboard/delete_staff';

$route['useraccount/roles'] = 'useraccount/dashboard/roles';
$route['useraccount/roles/permission/(:any)'] = 'useraccount/dashboard/role_permission/$1';
$route['useraccount/do-add-permission'] = 'useraccount/dashboard/doaddpermission';

$route['useraccount/orders'] = 'useraccount/dashboard/order_mgm';
$route['useraccount/edit-order/(:any)'] = 'useraccount/dashboard/edit_order/$1';
$route['useraccount/do-add-order'] = 'useraccount/dashboard/doaddorder';

$route['useraccount/cms'] = 'useraccount/dashboard/cms_mgm';
$route['useraccount/edit-cms/(:any)'] = 'useraccount/dashboard/edit_cms/$1';
$route['useraccount/do-add-cms'] = 'useraccount/dashboard/doaddcms';

$route['useraccount/blogs'] = 'useraccount/dashboard/blogs';
$route['useraccount/add-blogs'] = 'useraccount/dashboard/add_blogs';
$route['useraccount/do-add-blogs'] = 'useraccount/dashboard/doaddblogs';
$route['useraccount/edit-blogs/(:any)'] = 'useraccount/dashboard/edit_blogs/$1';

$route['useraccount/varthakproductimport'] = 'useraccount/dashboard/varthakproductimport';

$route['useraccount/subscriptions'] = 'useraccount/dashboard/subscriptions';
$route['useraccount/updateSubscriptions'] = 'useraccount/dashboard/update_subscriptions';

$route['useraccount/warehouse'] = 'useraccount/dashboard/warehouse';
$route['useraccount/add-warehouse'] = 'useraccount/dashboard/add_warehouse';
$route['useraccount/do-add-warehouse'] = 'useraccount/dashboard/doaddwarehouse';
$route['useraccount/edit-warehouse/(:any)'] = 'useraccount/dashboard/edit_warehouse/$1';
$route['useraccount/do-add-deliveries-warehouse'] = 'useraccount/dashboard/deliverieswarehouseallocation';
$route['useraccount/update-warehouse-return'] = 'useraccount/dashboard/updatewarehousereturn';

$route['useraccount/do-add-route'] = 'useraccount/dashboard/doaddroute';
$route['useraccount/assign-deleiveries-route'] = 'useraccount/dashboard/assigndeleiveriesroute';
$route['useraccount/delete-route-deliveries'] = 'useraccount/dashboard/deleteroutedeliveries';
$route['useraccount/delete-route'] = 'useraccount/dashboard/deleteroute';
$route['useraccount/show-map-route'] = 'useraccount/dashboard/show_route_map_by_routeid';
$route['useraccount/show-map-deliveries'] = 'useraccount/dashboard/show_route_map_by_deliveries';
$route['useraccount/show-map-livetracking'] = 'useraccount/dashboard/show_route_map_for_livetracking';
$route['useraccount/routes/(:any)'] = 'useraccount/dashboard/routes/$1';
$route['useraccount/show-route-map'] = 'useraccount/dashboard/show_map_route';

$route['useraccount/drivers'] = 'useraccount/dashboard/drivers';
$route['useraccount/add-driver'] = 'useraccount/dashboard/add_driver';
$route['useraccount/do-add-driver'] = 'useraccount/dashboard/doadddriver';
$route['useraccount/edit-driver/(:any)'] = 'useraccount/dashboard/edit_driver/$1';
$route['useraccount/drivers-status-update'] = 'useraccount/dashboard/drivers_status_update';
$route['useraccount/view-driver/(:any)'] = 'useraccount/dashboard/view_driver/$1';
$route['useraccount/do-add-driver-search'] = 'useraccount/dashboard/doadddriver_search';
$route['useraccount/do-add-deliveries-driver'] = 'useraccount/dashboard/deliveriesdriverallocation';

$route['useraccount/trips'] = 'useraccount/dashboard/trips';
$route['useraccount/do-add-hoc'] = 'useraccount/dashboard/doaddhoc';
$route['useraccount/do-import-customer-order'] = 'useraccount/dashboard/doimportcustomerorder';
$route['useraccount/do-add-deliveries'] = 'useraccount/dashboard/doadddeliveries';
$route['useraccount/do-add-deliveries-search'] = 'useraccount/dashboard/doadddeliveries_search';
$route['useraccount/do-confirm-plan'] = 'useraccount/dashboard/confirmplan';
$route['useraccount/live-tracking'] = 'useraccount/dashboard/live_tracking';

$route['useraccount/clients'] = 'useraccount/dashboard/clients';
$route['useraccount/add-client'] = 'useraccount/dashboard/add_client';
$route['useraccount/do-add-client'] = 'useraccount/dashboard/doaddclient';
$route['useraccount/edit-client/(:any)'] = 'useraccount/dashboard/edit_client/$1';
$route['useraccount/clients-status-update'] = 'useraccount/dashboard/clients_status_update';
$route['useraccount/view-client/(:any)'] = 'useraccount/dashboard/view_client/$1';
$route['useraccount/deliveries/(:any)'] = 'useraccount/dashboard/deliveries/$1';

