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
use Snitches\Model\Variant;

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

		$driver = new Driver($this->settings());
		$svc = new Product($driver, $this->log());

		$variants = array();
		$position = 1;
		foreach ($options as $productOption) {
			if ($position == sizeof($options) + 1) {
				break;
			}
			foreach ($productOption as $variantOption) {
				$combos = array_slice($options, $position);
				$combos = array_pop($combos);
				if (!is_array($combos)) {
					break;
				}
				foreach ($combos as $variantCombo) {
					$variantOptions = array();
					$variantOptions[1] = $variantOption;
					$variantOptions[2] = $variantCombo;
					$variants[] = $variantOptions;
				}
			}
			$position++;
		}
		foreach ($products as $product) {
			$properties = array(
				'name' => $product,
				'vendor' => 'Weyermann',
				'type' => 'Malt'
			);
			$id = $svc->createProduct($properties);
			$position = 1;
			foreach ($variants as $options) {
				$variant = array('position' => $position, 'options' => $options);
				$svc->createVariant($id, $variant);
				$position++;
			}
		}

		$crystalOptions = array(
			'20L',
			'40L',
			'60L',
			'120L'
		);
		$crystalProperties = array('name' => 'Crystal Malt', 'vendor' => 'Rahr', 'type' => 'Malt');
		$crystalId = $svc->createProduct($crystalProperties);
		$position = 1;
		foreach ($crystalOptions as $crystalOption) {
			foreach ($variants as $options) {
				$options[3] = $crystalOption;
				$variant = array('position' => $position, 'options' => $options);
				$svc->createVariant($id, $variant);
				$position++;
			}
		}
		$response = $this->response();
		$response->redirect('/');
		return $response;
	}


	/**
	 * POST /api/variants/:id/stock
	 */
	public function updateStock($params) {
		$variantId = $params['id'];
		$request = $this->request();
		$driver = new Driver($this->settings());
		$svc = new Sync($driver, $this->log());
		$model = new Variant($driver, $this->log());
		$model->load($variantId);
		$obj = array(
			"variant" => array(
				"id" => $model->_shopifyId,
				"inventory_quantity" => $request->query('quantity')
			)
		);
		$json = json_encode($obj);
		$result = $svc->updateVariantStock($this->settings(), $variantId, $json);

		$response = $this->response();
		$response->redirect('/');
		return $response;
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
