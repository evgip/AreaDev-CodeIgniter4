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
$routes->setDefaultController('PostsController');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);


// Documentation pages
$routes->get('info', 'InfoController::index');
$routes->get('info/stats', 'InfoController::stats');
$routes->get('info/rules', 'InfoController::rules');
$routes->get('info/about', 'InfoController::about');
$routes->get('info/privacy', 'InfoController::privacy');

// Auth Routes
$routes->match(['get', 'post'], 'login', 'AuthController::login'); 
$routes->match(['get', 'post'], 'register', 'AuthController::register');
$routes->match(['get', 'post'], 'forgotpassword', 'AuthController::forgotPassword'); 
$routes->match(['get', 'post'], 'activate/(:num)/(:any)', 'AuthController::activateUser/$1/$2'); 
$routes->match(['get', 'post'], 'resetpassword/(:num)/(:any)', 'AuthController::resetPassword/$1/$2'); 
$routes->match(['get', 'post'], 'updatepassword/(:num)', 'AuthController::updatepassword/$1'); 
$routes->match(['get', 'post'], 'lockscreen', 'AuthController::lockscreen'); 
$routes->get('logout', 'AuthController::logout'); 

$routes->post('users/color/(:num)', 'UsersController::color/$1'); 

$routes->add('users', 'UsersController::index');
$routes->get('users/(:any)', 'UsersController::usersProfile'); 
 
// admin - Role 1
$routes->group('admin', ['filter' => 'auth:Role,1'], function ($routes) {
	$routes->match(['get', 'post'], 'setting', 'AuthController::setting');
    $routes->get('admin', 'AdminController::index');
});

// Role 2
$routes->group('', ['filter' => 'auth:Role,2'], function ($routes){
     $routes->match(['get', 'post'], 'posts/create', 'PostsController::create');
	$routes->match(['get', 'post'], 'setting', 'AuthController::setting');
     
     $routes->match(['get', 'post'], 'comment/add', 'CommentsController::create');
});
  
 
$routes->get('posts/(:segment)', 'PostsController::view/$1');

// Главная страница
$routes->get('posts', 'PostsController::index');
 
 
// Страница комментарий
$routes->get('comments', 'CommentsController::index');
 

 
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
