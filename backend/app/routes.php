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
	->get('/api/products/:id/variants',	'Index::getVariants')
	->get('/',							'Index::index')
	->post('/generate',					'Index::generateProducts')

	->get('/api/products/:id/images',	'Index::getImages')
	->get('/api/products',				'Index::getProducts')
	->get('/api/combos',				'Combos::getCombos')

	->post('/api/combos/:id',			'Combos::createCombos')
	->post('/api/sync/download',		'Index::syncDownload')
	->post('/api/sync/upload',			'Index::syncUpload')
	->post('/api/variants/stock/:id',	'Variants::updateStock')
;

return $routes;