<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
// $routes->get('/', 'Home::index');

$routes->add('/', 'Home::login');

$routes->add('login', 'Home::login');

$routes->add('dashboard', 'Home::dashboard');

$routes->add('profile', 'User::index');


$routes->add('configuration/edit', 'Config::edit');

$routes->add('user/create', 'User::create');

$routes->add('user/list', 'User::list');

$routes->add('user/associate_office', 'User::associateOffice');


$routes->add('orders/create', 'Orders::create');

$routes->add('orders/list', 'Orders::list');



$routes->add('services/user/validation', 'User::validation');

$routes->add('services/user/update', 'User::edit');

$routes->add('services/user/create', 'User::save');

$routes->add('services/user/office/update', 'Office::update');

$routes->add('services/orders/search', 'Orders::search');

$routes->add('services/orders/save', 'Orders::save');

$routes->add('services/orders/send', 'Orders::send');

$routes->add('services/orders/update', 'Orders::edit');

$routes->add('services/orders/get_products', 'Orders::getProducts');

$routes->add('services/configuration/update', 'Config::update');


$routes->add('logout', 'User::logout');


/**
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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
