<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
//App\Controllers
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
//$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
//$routes->get('/', 'Home::index');

// $routes->get('/', 'Auth::index',['filter' => 'authenticated']);

//$routes->get('/', 'Auth::index', ['filter' => 'authenticated']);

$routes->get('/', 'Home');

// $routes->group('/admin', ['filter'=>'authenticate'], static function($routes){
//     $routes->match(['post'], '/login', 'index::index');
// });

$routes->group('admin', static function ($routes) {
    $routes->match(['post'], 'dashboard', 'Index::index');
    $routes->match(['post'], 'savenewroles', 'Index::savenewroles');
    $routes->match(['post'], 'editnewroles', 'Index::editnewroles');
    $routes->get('Admindashboard', 'Index::dashboard');
    $routes->get('adminlogout', 'Auth::logout');
    $routes->get('addrole', 'Index::addrole');
    $routes->get('addNew', 'Index::addNew');
    $routes->get('addnewroles', 'Index::addnewroles');
    $routes->get('user_rolesedit/(:segment)', 'Index::user_rolesedit/$1/$2');
    $routes->get('user_delete/(:any)', 'Index::user_delete/$1');
    $routes->get('addemployee', 'Index::addemployee');
    $routes->get('user_edit/(:any)', 'Index::user_edit/$1/$2');
    $routes->get('access/(:any)', 'Index::access/$1');
    $routes->get('permission/(:any)', 'Index::permission/$1');
    $routes->get('guest_list', 'Index::guest_list');
    $routes->match(['post'], 'editnewuser', 'Index::editnewuser/$1');
    $routes->match(['post'], 'addnewusers', 'Index::addnewuser/$1');
    $routes->match(['post'], 'saveaccess', 'Index::saveaccess');
    $routes->match(['post'], 'savepermission', 'Index::savepermission');
    $routes->get('guestlist', 'Index::guestlist');
    $routes->get('guestimport', 'EcxelController::index');
    $routes->get('exportexcel', 'EcxelController::export');
    $routes->match(['get', 'post'], 'EcxelController/upload', 'EcxelController::upload');
    $routes->match(['get', 'post'], 'addguestlist', 'Index::addguestlist');
    $routes->match(['get', 'post'], 'guest_edit/(:any)', 'Index::guest_edit/$1');
    $routes->get('guest_delete/(:any)', 'Index::guest_delete/$1');


});

// $routes->get("list-user", "Main::addCity", ["as" => "users"]); // Named route

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
