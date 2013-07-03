<?php
/**
 * (c) Josh Farr <j.wgasa@gmail.com>
 * 
 */

use BT\Controller\Page;
use BT\Validate\NotEmpty;
use BT\Query\Driver;

use Snitches\Shopify\Client;

class IndexController extends Page {
	/**
	 * GET /
	 */
	public function index() {
		$response = $this->response();
		$response->render('index');
		return $response;
	}


	/**
	 * POST /api/sync
	 */
	public function sync() {
		$client = new Client($this->_log, $this->_settings);
		$products = $client->getProducts();
		die(print_r($products, true));

		$response = $this->response();
		$response->redirect('/');
		return $response;
	}
}
