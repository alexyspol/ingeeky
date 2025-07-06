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
