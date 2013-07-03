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


class Product extends Service {
	public function createProduct($properties) {
		$query = new Query();
		$db = new Db();
		$table = $db->table(Db::TABLE_PRODUCT);
		$query->
			column($table->id())->
			column($table->title())->
			column($table->productType())->
			column($table->vendor())->
			into($table);
		$uuid = new UUID();
		$productId = $uuid->v4();
		$values = array(
			$productId,
			$properties['name'],
			$properties['type'],
			$properties['vendor']
		);
		$sql = $query->insert();
		$this->_driver->prepare($sql);
		$result = $this->_driver->exec($values);
		return $productId;
	}


	public function getProducts() {
		$query = new Query();
		$db = new Db();
		$table = $db->table(Db::TABLE_PRODUCT);
		$query->
			column($table->shopifyId())->
			column($table->id())->
			column($table->bodyHtml())->
			column($table->dateCreatedTimestamp())->
			column($table->dateUpdatedTimestamp())->
			column($table->handle())->
			column($table->productType())->
			column($table->publishedScope())->
			column($table->tags())->
			column($table->templateSuffix())->
			column($table->title())->
			column($table->vendor())->
			from($table);
		$sql = $query->select();
		$result = $this->_driver->query($sql);
		return $result;
	}

	public function createVariant($productId, $properties) {
		$query = new Query();
		$db = new Db();
		$table = $db->table(Db::TABLE_VARIANT);
		$query->
			column($table->id())->
			column($table->productUuid())->
			column($table->position())->
			into($table);
		$sql = $query->insert();
		$this->_driver->prepare($sql);
		$uuid = new UUID();
		$variantId = $uuid->v4();
		$values = array(
			$variantId,
			$productId,
			$properties['position']
		);
		$result = $this->_driver->exec($values);
		$table = $db->table(Db::TABLE_VARIANT_OPTION);
		foreach ($properties['options'] as $position => $option) {
			$optionId = $uuid->v4();
			$query = new Query();
			$query->
				column($table->id())->
				column($table->variantUuid())->
				column($table->name())->
				column($table->position())->
				into($table);
			$values = array(
				$optionId,
				$variantId,
				$option,
				$position
			);
			$sql = $query->insert();
			$this->_driver->prepare($sql);
			$result = $this->_driver->exec($values);
		}
		return $variantId;
	}


	public function getVariants($productId) {
		$query = new Query();
		$db = new Db();
		$table = $db->table(Db::TABLE_VARIANT);
		$query->
			column($table->id())->
			column($table->productUuid())->
			column($table->shopifyId())->
			column($table->dateCreatedTimestamp())->
			column($table->dateUpdatedTimestamp())->
			column($table->compareAtPrice())->
			column($table->fulfillmentService())->
			column($table->grams())->
			column($table->inventoryManagement())->
			column($table->inventoryPolicy())->
			column($table->inventoryQuantity())->
			column($table->position())->
			column($table->price())->
			column($table->requiresShipping())->
			column($table->sku())->
			column($table->taxable())->
			column($table->title())->
			from($table)->
			where(
				$query->expr()->eq($table->productUuid(), $query->param()->string($productId))
			);
		$sql = $query->select();
		$result = $this->_driver->query($sql);

		$optionTable = $db->table(Db::TABLE_VARIANT_OPTION);
		$variants = array();
		foreach ($result as $variant) {
			$query = new Query();
			$query->
				column($optionTable->name())->
				column($optionTable->position())->
				from($optionTable)->
				where($query->expr()->eq($optionTable->variantUuid(), $query->param()->string($variant['variant_uuid'])));
			$sql = $query->select();
			$result = $this->_driver->query($sql);
			foreach ($result as $option) {
				$key = 'option' . $option['position'];
				$variant[$key] = $option['name'];
			}
			$variants[] = $variant;
		}
		return $variants;
	}


	public function getImages($productId) {
		$query = new Query();
		$db = new Db();
		$table = $db->table(Db::TABLE_IMAGE);
		$query->
			column($table->id())->
			column($table->productUuid())->
			column($table->shopifyId())->
			column($table->dateCreatedTimestamp())->
			column($table->dateUpdatedTimestamp())->
			column($table->position())->
			column($table->src())->
			from($table)->
			where($query->expr()->eq($table->productUuid(), $query->param()->string($productId)));
		$sql = $query->select();
		$result = $this->_driver->query($sql);
		return $result;
	}
}