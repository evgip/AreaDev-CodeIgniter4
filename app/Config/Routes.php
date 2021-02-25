<?php

namespace Config;

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


// Route Definitions
$routes->get('/', 'Home::index');

// Documentation pages
$routes->get('/info', 'Info::index');
$routes->get('/info/stats', 'Info::stats');
$routes->get('/info/rules', 'Info::rules');

// Auth Routes
$routes->match(['get', 'post'], 'login', 'Auth::login'); 
$routes->match(['get', 'post'], 'register', 'Auth::register');
$routes->match(['get', 'post'], 'forgotpassword', 'Auth::forgotPassword'); 
$routes->match(['get', 'post'], 'activate/(:num)/(:any)', 'Auth::activateUser/$1/$2'); 
$routes->match(['get', 'post'], 'resetpassword/(:num)/(:any)', 'Auth::resetPassword/$1/$2'); 
$routes->match(['get', 'post'], 'updatepassword/(:num)', 'Auth::updatepassword/$1'); 
$routes->match(['get', 'post'], 'lockscreen', 'Auth::lockscreen'); 
$routes->get('logout', 'Auth::logout'); 

$routes->add('users/(:alphanum)', 'Profile::user'); 
//, ['as' => 'users']
// admin - Role 1
$routes->group('admin', ['filter' => 'auth:Role,1'], function ($routes) {
 
	$routes->get('profile', 'Profile::index'); 
	$routes->match(['get', 'post'], 'setting', 'Auth::setting');
    $routes->get('admin', 'Admin::index'); // ADMIN
 
});

//  Role 2
$routes->group('', ['filter' => 'auth:Role,2'], function ($routes){
    
	$routes->get('profile', 'Profile::index'); 
	$routes->match(['get', 'post'], 'setting', 'Auth::setting');
    
    $routes->post('setting/color/(:num)', 'Auth::color/$1');
    
});


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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
