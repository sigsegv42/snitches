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
	->get('/api/combos',				'Index::getCombos')

	->post('/api/combos/:id',			'Index::createCombos')
	->post('/api/sync/download',		'Index::syncDownload')
	->post('/api/sync/upload',			'Index::syncUpload')
	->post('/api/variants/:id/stock',	'Index::updateStock')
;

return $routes;