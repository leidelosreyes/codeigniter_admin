<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

// home page (if app has frontend)
//$routes->get('/', 'Home::index');
//$routes->get('home' , 'Home::index');

// home page (if app has no frontend)
//$routes->get('/', 'Login::index');
//$routes->get('home' , 'Login::index');

// registration
//$routes->get('registration', 'Registration::index');
//$routes->post('registration', 'Registration::index');

// login
$routes->get('xoy75hZUKrBPCe2', 'Login::index');
$routes->post('xoy75hZUKrBPCe2', 'Login::index');

$routes->get('logout', 'Login::logout');
$routes->get('logstatus', 'Login::logstatus');

/**
 * Filter authguard only restricts access via login.
 * filter permguard restricts access via login and permission
 */

// dashboard
$routes->get('dashboard', 'Admin\Dashboard::index', ['filter' => 'authGuard']);

// my profile
$routes->get('myprofile', 'Admin\MyProfile::index', ['filter' => 'authGuard']);
$routes->post('myprofile/save_data', 'Admin\MyProfile::save_data', ['filter' => 'authGuard']);

// user management
$routes->get('usermanagement', 'Admin\UserManagement::index', ['filter' => 'permGuard']);
$routes->post('usermanagement/datatable', 'Admin\UserManagement::datatable', ['filter' => 'authGuard']);
$routes->get('usermanagement/getGAuth','Admin\UserManagement::getGAuth', ['filter' => 'authGuard']);
$routes->post('usermanagement/getGAuthImg','Admin\UserManagement::getGAuthImg', ['filter' => 'authGuard']);
$routes->post('usermanagement/save_data', 'Admin\UserManagement::save_data', ['filter' => 'permGuard']);
$routes->post('usermanagement/delete_data', 'Admin\UserManagement::delete_data', ['filter' => 'permGuard']);

// permission management
$routes->get('permissionmanagement', 'Admin\PermissionManagement::index', ['filter' => 'permGuard']);
$routes->post('permissionmanagement/datatable', 'Admin\PermissionManagement::datatable', ['filter' => 'authGuard']);
$routes->post('permissionmanagement/save_data', 'Admin\PermissionManagement::save_data', ['filter' => 'permGuard']);
$routes->post('permissionmanagement/delete_data', 'Admin\PermissionManagement::delete_data', ['filter' => 'permGuard']);

// role management
$routes->get('rolemanagement', 'Admin\RoleManagement::index', ['filter' => 'permGuard']);
$routes->post('rolemanagement/datatable', 'Admin\RoleManagement::datatable', ['filter' => 'authGuard']);
$routes->post('rolemanagement/save_data', 'Admin\RoleManagement::save_data', ['filter' => 'permGuard']);
$routes->post('rolemanagement/delete_data', 'Admin\RoleManagement::delete_data', ['filter' => 'permGuard']);

// sysconfig
$routes->get('sysconfig', 'Admin\SysConfig::index', ['filter' => 'permGuard']);
$routes->post('sysconfig/datatable', 'Admin\SysConfig::datatable', ['filter' => 'authGuard']);
$routes->post('sysconfig/save_data', 'Admin\SysConfig::save_data', ['filter' => 'permGuard']);
$routes->post('sysconfig/delete_data', 'Admin\SysConfig::delete_data', ['filter' => 'permGuard']);


//message
$routes->get('message','Chat\Message::index',['filter' => 'authGuard']);
$routes->post('message/datatable','Chat\Message::datatable',['filter' => 'authGuard']);
$routes->post('message/save_data_csv','Chat\Message::save_data_csv',['filter' => 'authGuard']);

//movies
$routes->get('home','Movies\MovieController::index');
$routes->get('home/(:num)','Movies\MovieController::index/$1');
$routes->get('movie/show/(:num)', 'Movies\MovieController::showDetails/$1');
$routes->get('movie/play/(:num)', 'Movies\MovieController::videoPlay/$1');
$routes->post('movie/play2', 'Movies\MovieController::play');

//SYSTEM MODULES

// Public API
$routes->get('getsysconfig/(:alphanum)', 'PublicApi\GetSysConfig::index/$1');


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
