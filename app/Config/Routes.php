<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ========================================
// PUBLIC / AUTH ROUTES
// ========================================

$routes->get('/', 'AuthController::login');

$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::attemptLogin');

// Admin login
$routes->get('admin/login', 'AuthController::login');
$routes->post('admin/login', 'AuthController::attemptLogin');

// Student login
$routes->get('student/login', 'AuthController::login');
$routes->post('student/login', 'AuthController::attemptLogin');

// Logout
$routes->get('logout', 'AuthController::logout');

// ========================================
// ADMIN ROUTES
// ========================================

$routes->group('admin', ['filter' => 'role:admin'], function($routes) {

    // Dashboard
    $routes->get('dashboard', 'Admin\Dashboard::index');


    // -----------------------------
    // Student Management
    // -----------------------------

    $routes->group('students', function($routes) {

        $routes->get('/', 'Admin\Students::index');
        $routes->get('add', 'Admin\Students::add');
        $routes->post('store', 'Admin\Students::store');

        $routes->get('edit/(:num)', 'Admin\Students::edit/$1');
        $routes->post('update/(:num)', 'Admin\Students::update/$1');

        $routes->get('delete/(:num)', 'Admin\Students::delete/$1');
    });


    // -----------------------------
    // KYC Management
    // -----------------------------

    $routes->group('kyc', function($routes) {

        $routes->get('/', 'Admin\Kyc::index');
        $routes->get('view/(:num)', 'Admin\Kyc::view/$1');

        $routes->get('approve/(:num)', 'Admin\Kyc::approve/$1');
        $routes->post('approve/(:num)', 'Admin\Kyc::approve/$1');
        $routes->post('reject/(:num)', 'Admin\Kyc::reject/$1');
    });


    // -----------------------------
    // Menu Management
    // -----------------------------

    $routes->group('menus', function($routes) {

        $routes->get('/', 'Admin\Menus::index');
        $routes->get('add', 'Admin\Menus::add');
        $routes->post('store', 'Admin\Menus::store');

        $routes->get('edit/(:num)', 'Admin\Menus::edit/$1');
        $routes->post('update/(:num)', 'Admin\Menus::update/$1');
        $routes->get('delete/(:num)', 'Admin\Menus::delete/$1');
    });


    // -----------------------------
    // Holiday Management
    // -----------------------------

    $routes->group('holidays', function($routes) {

        $routes->get('/', 'Admin\Holidays::index');
        $routes->get('add', 'Admin\Holidays::add');
        $routes->post('store', 'Admin\Holidays::store');

        $routes->get('edit/(:num)', 'Admin\Holidays::edit/$1');
        $routes->post('update/(:num)', 'Admin\Holidays::update/$1');
        $routes->get('delete/(:num)', 'Admin\Holidays::delete/$1');
    });


    // -----------------------------
    // Extra Meals
    // -----------------------------

    $routes->group('extra-meals', function($routes) {

        $routes->get('/', 'Admin\ExtraMeals::index');
        $routes->get('approve/(:num)', 'Admin\ExtraMeals::approve/$1');
        $routes->post('approve/(:num)', 'Admin\ExtraMeals::approve/$1');
        $routes->get('reject/(:num)', 'Admin\ExtraMeals::reject/$1');
        $routes->post('reject/(:num)', 'Admin\ExtraMeals::reject/$1');
    });


    $routes->group('payments', function($routes) {

        $routes->get('/', 'Admin\Payments::index');
        $routes->post('record/(:num)', 'Admin\Payments::record/$1');
    });


    // -----------------------------
    // Reports
    // -----------------------------

    $routes->group('reports', function($routes) {

        $routes->get('/', 'Admin\Reports::index');
    });

});


// ========================================
// STUDENT ROUTES
// ========================================

$routes->group('student', ['filter' => 'role:student'], function($routes) {

    // Dashboard
    $routes->get('dashboard', 'Student\Dashboard::index');


    // -----------------------------
    // Profile
    // -----------------------------

    $routes->group('profile', function($routes) {

        $routes->get('/', 'Student\Profile::index');
        $routes->get('edit', 'Student\Profile::edit');
        $routes->post('update', 'Student\Profile::update');
    });


    // -----------------------------
    // Menu
    // -----------------------------

    $routes->group('menu', function($routes) {

        $routes->get('/', 'Student\Menu::index');
    });


    // -----------------------------
    // Extra Meals
    // -----------------------------

    $routes->group('extra-meals', function($routes) {

        $routes->get('/', 'Student\ExtraMeals::index');
        $routes->post('request', 'Student\ExtraMeals::request');
    });


    // -----------------------------
    // Payments
    // -----------------------------

    $routes->group('payments', function($routes) {

        $routes->get('/', 'Student\Payments::index');
    });

});

