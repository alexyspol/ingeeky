<?php

use CodeIgniter\Router\RouteCollection;

$routes->get('/', 'PagesController::home');
$routes->get('about-us', 'PagesController::about');
$routes->get('services', 'PagesController::services');
$routes->get('contact-us', 'PagesController::contact');

service('auth')->routes($routes);

$routes->resource('tickets', ['controller' => 'TicketsController', 'filter' => 'session']);
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
$routes->group('profile', ['filter' => 'session'], static function ($routes) {
    $routes->get('edit', 'ProfileController::edit', ['as' => 'profile.edit']);
    $routes->post('update', 'ProfileController::update', ['as' => 'profile.update']);
});

$routes->group('admin', ['filter' => 'group:admin'], static function ($routes) {
    $routes->get('users', 'Admin\UserController::index', ['as' => 'admin.users.index']);
    $routes->get('users/new', 'Admin\UserController::new', ['as' => 'admin.user.new']);
    $routes->post('users/create', 'Admin\UserController::create', ['as' => 'admin.user.create']);
    $routes->get('users/edit/(:num)', 'Admin\UserController::edit/$1', ['as' => 'admin.user.edit']);
    $routes->post('users/update/(:num)', 'Admin\UserController::update/$1', ['as' => 'admin.user.update']);
    $routes->post('users/delete/(:num)', 'Admin\UserController::delete/$1', ['as' => 'admin.user.delete']);
});
