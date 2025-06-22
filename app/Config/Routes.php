<?php

use CodeIgniter\Router\RouteCollection;

$routes->get('/', 'Pages::home');
$routes->get('about-us', 'Pages::about');
$routes->get('services', 'Pages::services');
$routes->get('contact-us', 'Pages::contact');

service('auth')->routes($routes);

