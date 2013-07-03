<?php
/**
 * (c) Josh Farr <j.wgasa@gmail.com>
 */

namespace Snitches\Service;

use BT\Core\UUID;
use BT\Query\Query;
use BT\Query\Column;
use BT\Query\Driver;
use BT\Service\Service;
use BT\Core\Settings;

use Snitches\Query\Db\Snitches as Db;
use Snitches\Shopify\Client;
use Snitches\Model\Image;
use Snitches\Model\Product;
use Snitches\Model\Variant;

class Sync extends Service {
	public function download(Settings $settings) {
		$client = new Client($this->_log, $settings);
		$products = $client->getProducts();
		$models = array();
		foreach ($products as $product) {
			$this->_log->log('Processing product [' . $product->title . ']');
			$model = new Product($this->_driver, $this->_log);
			$model->hydrate($product);
			foreach ($product->variants as $variant) {
				$variantModel = new Variant($this->_driver, $this->_log);
				$variantModel->hydrate($variant);
				$model->_variants[$variantModel->_shopifyId] = $variantModel;
			}
			$images = $client->getImages($model->_shopifyId);
			foreach ($images as $image) {
				$imageModel = new Image($this->_driver, $this->_log);
				$imageModel->hydrate($image);
				$model->_images[$imageModel->_shopifyId] = $imageModel;
			}
			$models[$model->_shopifyId] = $model;
		}

		$query = new Query();
		$db = new Db();
		$table = $db->table(Db::TABLE_PRODUCT);

		$query->
			column($table->shopifyId())->
			column($table->id())->
			from($table);
		$sql = $query->select();
		$result = $this->_driver->query($sql);
		foreach ($result as $record) {
			if (array_key_exists($record['shopify_id'], $models)) {
				$models[$record['shopify_id']]->_uuid = $record['product_uuid'];
			}
			$query = new Query();
			$table = $db->table(DB::TABLE_VARIANT);
			$query->
				column($table->shopifyId())->
				column($table->id())->
				from($table)->
				where($query->expr()->eq($table->productUuid(), $query->param()->string($record['product_uuid'])));
			$sql = $query->select();
			$variantRecords = $this->_driver->query($sql);
			foreach ($variantRecords as $variantRecord) {
				if (array_key_exists($variantRecord['shopify_id'], $models[$record['shopify_id']]->_variants)) {
					$models[$record['shopify_id']]->_variants[$variantRecord['shopify_id']]->_uuid = $variantRecord['variant_uuid'];
				}
			}

			$query = new Query();
			$table = $db->table(DB::TABLE_IMAGE);
			$query->
				column($table->shopifyId())->
				column($table->id())->
				from($table)->
				where($query->expr()->eq($table->productUuid(), $query->param()->string($record['product_uuid'])));
			$sql = $query->select();
			$imageRecords = $this->_driver->query($sql);
			foreach ($imageRecords as $imageRecord) {
				if (array_key_exists($imageRecord['shopify_id'], $models[$record['shopify_id']]->_images)) {
					$models[$record['shopify_id']]->_images[$imageRecord['shopify_id']]->_uuid = $imageRecord['image_uuid'];
				}
			}

		}


		foreach ($models as $model) {
			$model->save();
			foreach ($model->_variants as $variant) {
				$variant->_productId = $model->_uuid;
				$variant->save();
			}
			foreach ($model->_images as $image) {
				$image->_productId = $model->_uuid;
				$image->save();
			}
		}
	}


	public function upload(Settings $settings) {

	}
}