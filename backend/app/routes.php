<?php
/**
 * BrewTheory Application
 *  
 * (c) Josh Farr <j.wgasa@gmail.com>
 * 
 */

use BT\Router\Router;

$routes = new Router();

$routes
	->get('/',						'Index::index')

	->get('/api/products',			'Products::getProducts')
	->get('/api/variants',			'Variants::getVariants')
	->get('/api/images',			'Images::getImages')
	->get('/api/combos',			'Combos::getCombos')

	->post('/api/combos/:id',			'Combos::createCombos')
	->post('/api/sync',					'Index::sync')
	->post('/api/variants/stock/:id',	'Variants::updateStock')
;

return $routes;