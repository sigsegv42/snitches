<?php
/**
 * (c) Josh Farr <j.wgasa@gmail.com>
 * 
 */

use BT\Controller\Page;
use BT\Validate\NotEmpty;
use BT\Query\Driver;

use Snitches\Service\Sync;
use Snitches\Service\Product;

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
	 * GET /api/products
	 */
	public function getProducts() {
		$driver = new Driver($this->settings());
		$svc = new Product($driver, $this->log());
		$records = $svc->getProducts();
		$obj = new stdClass();
		$obj->products = $records;
		$response = $this->response();
		$response->json($obj);
		return $response;
	}


	/**
	 * GET /api/products/:id/variants
	 */
	public function getVariants($params) {
		$driver = new Driver($this->settings());
		$svc = new Product($driver, $this->log());
		$records = $svc->getVariants($params['id']);
		$obj = new stdClass();
		$obj->variants = $records;
		$response = $this->response();
		$response->json($obj);
		return $response;
	}

	/**
	 * GET /api/products/:id/images
	 */
	public function getImages($params) {
		$driver = new Driver($this->settings());
		$svc = new Product($driver, $this->log());
		$records = $svc->getImages($params['id']);
		$obj = new stdClass();
		$obj->images = $records;
		$response = $this->response();
		$response->json($obj);
		return $response;
	}


	/**
	 * POST /generate
	 */
	public function generateProducts() {
		$options = array(
			'Process' => array(
				'milled',
				'unmilled'
			),
			'Weight' => array(
				'2oz',
				'4oz',
				'8oz',
				'1lb',
				'5lb',
				'10lb'
			)
		);
		$products = array(
			'2-Row Malt',
			'Biscuit Malt',
			'Maris Otter Malt',
			'Victory Malt',
			'Carapils Malt',
			'Acidulated Malt',
			'Munich Malt',
			'Vienna Malt',
			'Pilsner Malt',
			'Special B Malt',
			'Chocolate Malt',
			'Melanoidin Malt',
			'Caramunich Malt',
			'Black Patent Malt',
			'Carafa Special II Malt',
			'Carafa Special III Malt',
			'Black Roasted Barley Malt',
			'Torrified Wheat Malt',
			'Honey Malt',
			'Rauch Malt',
			'Rye Malt',
			'Flaked Maize',
			'Rice Hulls',
			'Flaked Barley',
			'Flaked Oats'
		);

		foreach ($products as $product) {

		}

		$crystalOptions = array(
			'20L',
			'40L',
			'60L',
			'120L'
		);

	}


	/**
	 * POST /api/sync/download
	 */
	public function syncDownload() {
		$driver = new Driver($this->settings());
		$svc = new Sync($driver, $this->log());
		$svc->download($this->_settings);

		$response = $this->response();
		$response->redirect('/');
		return $response;
	}


	/**
	 * POST /api/sync/upload
	 */
	public function syncUpload() {
		$driver = new Driver($this->settings());
		$svc = new Sync($driver, $this->log());
		$svc->upload($this->_settings);

		$response = $this->response();
		$response->redirect('/');
		return $response;
	}
}
