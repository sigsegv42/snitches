<?php
/**
 * (c) Josh Farr <j.wgasa@gmail.com>
 * 
 */

namespace Snitches\Shopify;

use BT\Core\Log;
use BT\Rest\Client as RestClient;
use BT\Core\Settings;


/**
 * Shopify API client
 */
class Client {
	protected $_log = null;
	protected $_key = null;
	protected $_password = null;
	protected $_domain = null;

	/**
	 * Default constructor
	 *
	 * @param Log $log logger instance
	 * @param Settings $settings application settings
	 */
	public function __construct(Log $log, Settings $settings) {
		$this->_log = $log;
		$params = $settings->get('shopify');
		$this->_key = $params['api_key'];
		$this->_password = $params['password'];
		$this->_domain = $params['domain'];
	}


	/**
	 * Create the standard API REST client
	 *
	 * @return RestClient
	 */
	protected function createClient() {
		$client = new RestClient($this->_log);
		$auth = base64_encode($this->_key . ':' . $this->_password);
		$client->header('Authorization', 'Basic ' . $auth);
		return $client;		
	}


	/**
	 * Get an array of all products
	 *
	 * @param array
	 */
	public function getProducts() {
		$client = $this->createClient();
		$url = 'https://' . $this->_domain . '/admin/products.json';
		$response = $client->request($url);
		$products = json_decode($response['body']);
		return $products->products;
	}


	public function createProduct(Model $model) {
		$client = $this->createClient();
		$url = 'https://' . $this->_domain . '/admin/products.json';
		$product = $model->dehydrate();
		$response = $client->request($url, 'POST', $product);

	}


	/**
	 * Get a single product
	 *
	 * @param integer $id shopify product id
	 */
	public function getProduct($id) {
		$client = $this->createClient();
		$url = 'https://' . $this->_domain . '/admin/products/' . $id . '.json';
		$response = $client->request($url);
		$product = json_decode($response['body']);
		return $product;
	}



	/**
	 * Get the images for a product
	 *
	 * @param integer $id shopify product id
	 */
	public function getImages($id) {
		$client = $this->createClient();
		$url = 'https://' . $this->_domain . '/admin/products/' . $id . '/images.json';
		$response = $client->request($url);
		$images = json_decode($response['body']);
		return $images->images;
	}
}