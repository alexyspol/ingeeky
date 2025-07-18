<?php

use CodeIgniter\Router\RouteCollection;

$routes->get('/', 'PagesController::home');
$routes->get('about-us', 'PagesController::about');
$routes->get('services', 'PagesController::services');
$routes->get('contact-us', 'PagesController::contact');

service('auth')->routes($routes);

$routes->resource('tickets', ['controller' => 'TicketsController', 'filter' => 'session']);
// Customer Routes (Protected by session/auth.session filter)
$routes->group('tickets', ['filter' => 'session'], function($routes) {
    $routes->get('/', 'TicketsController::index');
    $routes->get('new', 'TicketsController::new');
    $routes->post('/', 'TicketsController::create');
    $routes->get('(:num)', 'TicketsController::show/$1');
    // Add customer-specific routes like replying if they are not editing the ticket itself
    $routes->post('(:num)/reply', 'TicketsController::reply/$1'); // If you add a reply method to customer controller
});

$routes->post('ticket-messages', 'TicketMessagesController::create');

$routes->group('products', ['namespace' => 'App\Controllers'], function ($routes) {
    $routes->get('/', 'ProductsController::index', ['as' => 'products.index', 'filter' => 'session']);

    // Employee-only routes
    $routes->get('new', 'ProductsController::new', ['as' => 'products.new', 'filter' => 'isEmployee']);
    $routes->post('/', 'ProductsController::create', ['as' => 'products.create', 'filter' => 'isEmployee']);
    $routes->get('(:num)/edit', 'ProductsController::edit/$1', ['as' => 'products.edit', 'filter' => 'isEmployee']);
    $routes->put('(:num)', 'ProductsController::update/$1', ['as' => 'products.update', 'filter' => 'isEmployee']);
    $routes->delete('(:num)', 'ProductsController::delete/$1', ['as' => 'products.delete', 'filter' => 'isEmployee']);
});

$routes->get('dashboard', 'DashboardController::index', ['as' => 'dashboard', 'filter' => 'isEmployee']);

// Profile Management Routes
$routes->group('profiles', ['filter' => 'session'], static function ($routes) {
    $routes->get('edit', 'ProfilesController::edit', ['as' => 'profile.edit']);
    $routes->post('update', 'ProfilesController::update', ['as' => 'profile.update']);
});

$routes->group('admin', ['filter' => 'group:admin'], static function ($routes) {
    $routes->group('users', static function ($routes) {
        $routes->get('/', 'Admin\UsersController::index', ['as' => 'admin.users.index']);
        $routes->get('new', 'Admin\UsersController::new', ['as' => 'admin.user.new']);
        $routes->post('create', 'Admin\UsersController::create', ['as' => 'admin.user.create']);
        $routes->get('edit/(:num)', 'Admin\UsersController::edit/$1', ['as' => 'admin.user.edit']);
        $routes->post('update/(:num)', 'Admin\UsersController::update/$1', ['as' => 'admin.user.update']);
        $routes->post('delete/(:num)', 'Admin\UsersController::delete/$1', ['as' => 'admin.user.delete']);
    });

    $routes->group('tickets', function($routes) {
        $routes->get('/', 'Admin\TicketsController::index');
        $routes->get('new', 'Admin\TicketsController::new');
        $routes->post('/', 'Admin\TicketsController::create');
        $routes->get('(:num)', 'Admin\TicketsController::show/$1');
        $routes->get('(:num)/edit', 'Admin\TicketsController::edit/$1');
        $routes->put('(:num)', 'Admin\TicketsController::update/$1');
        $routes->patch('(:num)', 'Admin\TicketsController::update/$1');
        $routes->delete('(:num)', 'Admin\TicketsController::delete/$1');
        $routes->post('(:num)/reply', 'Admin\TicketsController::reply/$1');
    });
});
