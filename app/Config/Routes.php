<?php

use CodeIgniter\Router\RouteCollection;

$routes->get('/', 'PagesController::home', ['as' => 'pages.home']);
$routes->get('about-us', 'PagesController::about', ['as' => 'pages.about']);
$routes->get('services', 'PagesController::services', ['as' => 'pages.services']);
$routes->get('contact-us', 'PagesController::contact', ['as' => 'pages.contact']);

// ------------------------------------------------------------------------------------------------
// HTTP Method  URI Pattern                 Controller Action                   Named Route (Alias)
// ------------------------------------------------------------------------------------------------
// GET          /login                      AuthController::loginView           login
// POST         /login                      AuthController::loginAction         login
// GET          /logout                     AuthController::logoutAction        logout
// GET          /register                   AuthController::registerView        register
// POST         /register                   AuthController::registerAction      register
// GET          /forgot                     PasswordController::forgotView      forgot
// POST         /forgot                     PasswordController::forgotAction    forgot
// GET          /reset-password             PasswordController::resetView       reset-password
// POST         /reset-password             PasswordController::resetAction     reset-password
// GET          /activate-account           AuthController::activateView        activate-account
// GET          /resend-activate-account    AuthController::resendActivateView  resend-activate-account
service('auth')->routes($routes);

$routes->group('tickets', ['filter' => 'session'], function($routes) {
    $routes->get('/', 'TicketsController::index', ['as' => 'tickets.index']);
    $routes->post('/', 'TicketsController::create', ['as' => 'tickets.create']);
    $routes->get('new', 'TicketsController::new', ['as' => 'tickets.new']);
    $routes->get('(:num)', 'TicketsController::show/$1', ['as' => 'tickets.show']);
    $routes->get('(:num)/edit', 'TicketsController::edit/$1', ['as' => 'tickets.edit', 'filter' => 'permission:admin.access']);
    $routes->patch('(:num)', 'TicketsController::update/$1', ['as' => 'tickets.update', 'filter' => 'permission:admin.access']);
    $routes->delete('(:num)', 'TicketsController::delete/$1', ['as' => 'tickets.delete']);

    $routes->post('(:num)/reply', 'TicketsController::reply/$1', ['as' => 'tickets.reply']);
    $routes->patch('(:num)/close', 'TicketsController::close/$1', ['as' => 'tickets.close']);
});

$routes->get('dashboard', 'DashboardController::index', ['as' => 'dashboard', 'filter' => 'isEmployee']);

// Profile Management Routes
$routes->group('profiles', ['filter' => 'session'], static function ($routes) {
    $routes->get('edit', 'ProfilesController::edit', ['as' => 'profiles.edit']);
    $routes->post('update', 'ProfilesController::update', ['as' => 'profiles.update']);
});

$routes->group('users', ['filter' => 'permission:admin.access'], function ($routes) {
    $routes->get('/', 'UsersController::index', ['as' => 'users.index']);
    $routes->post('/', 'UsersController::create', ['as' => 'users.create']);
    $routes->get('new', 'UsersController::new', ['as' => 'users.new']);
    $routes->get('(:num)', 'UsersController::show/$1', ['as' => 'users.show']);
    $routes->get('(:num)/edit', 'UsersController::edit/$1', ['as' => 'users.edit']);
    $routes->patch('(:num)', 'UsersController::update/$1', ['as' => 'users.update']);
    $routes->delete('(:num)', 'UsersController::delete/$1', ['as' => 'users.delete']);
});
