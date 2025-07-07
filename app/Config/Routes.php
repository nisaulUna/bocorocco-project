<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'MainPageController::index');
$routes->get('/main', 'MainPageController::index');
$routes->get('/products/mens', 'MainPageController::men');
$routes->get('/products/womens', 'MainPageController::women');

$routes->get('/search', 'SearchController::index');

$routes->get('product/(:num)/(:segment)', 'ProductController::detail/$1/$2');

$routes->get('/cart', 'CartController::index');
$routes->post('/product/add-to-cart', 'CartController::addToCart');
$routes->get('/cart/delete/(:num)/(:segment)/(:segment)', 'CartController::delete/$1/$2/$3');

$routes->get('/cart/add/(:num)/(:segment)/(:segment)', 'CartController::increase/$1/$2/$3');
$routes->get('/cart/delete/(:num)/(:segment)/(:segment)', 'CartController::delete/$1/$2/$3');
$routes->get('/cart/update/(:num)/(:segment)/(:segment)/(:segment)', 'CartController::updateQuantity/$1/$2/$3/$4');

$routes->get('/checkout', 'CheckoutController::index');
$routes->post('/checkout/apply-promo', 'CheckoutController::applyPromo');
$routes->post('/checkout/pay', 'CheckoutController::pay');