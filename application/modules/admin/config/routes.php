<?php

defined('BASEPATH') OR exit('No direct script access allowed');

//********************Admin Routes**********************
$route['admin/login'] = 'admin/admin/index';
$route['admin/logout'] = 'admin/logout/index';
$route['admin/forgot-password'] = 'admin/admin/forgot_password';
$route['admin/dasboard'] = 'admin/dashboard/index';
$route['admin/editProfile'] = 'admin/dashboard/editProfile';

$route['admin/cms'] = 'admin/cms/index';
$route['admin/cms/edit/(:any)'] = 'admin/cms/edit_cms/$1';



$route['admin/user'] = 'admin/user/index';
$route['admin/user/add'] = 'admin/user/add_user';
$route['admin/user/edit/(:any)'] = 'admin/user/edit_user/$1';
$route['admin/user/delete/(:any)'] = 'admin/user/delete_user/$1';



/* start at 15th July, 2021*/
$route['admin/masterproducts'] = 'admin/masterproducts/index';
$route['admin/masterproducts/edit/(:any)'] = 'admin/masterproducts/edit_masterproducts/$1';
$route['admin/masterproducts/add'] = 'admin/masterproducts/add_masterproducts';
$route['admin/masterproducts/do-masterproducts'] = 'admin/masterproducts/domasterproducts';
$route['admin/masterproducts/delete/(:any)'] = 'admin/masterproducts/delete_masterproducts/$1';

$route['admin/blogs'] = 'admin/blogs/index';
$route['admin/blogs/edit/(:any)'] = 'admin/blogs/edit_blogs/$1';
$route['admin/blogs/add'] = 'admin/blogs/add_blogs';
$route['admin/blogs/delete/(:any)'] = 'admin/blogs/delete_blogs/$1';

$route['admin/products'] = 'admin/products/index';
$route['admin/products/edit/(:any)'] = 'admin/products/edit_products/$1';
$route['admin/products/add'] = 'admin/products/add_products';
$route['admin/products/delete/(:any)'] = 'admin/products/delete_products/$1';
