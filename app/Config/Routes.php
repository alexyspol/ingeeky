<?php

use CodeIgniter\Router\RouteCollection;

$routes->get('/', 'PagesController::home');
$routes->get('about-us', 'PagesController::about');
$routes->get('services', 'PagesController::services');
$routes->get('contact-us', 'PagesController::contact');

service('auth')->routes($routes);

$routes->resource('tickets', ['controller' => 'TicketsController']);
