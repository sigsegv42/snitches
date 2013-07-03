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
			where($query->expr()->eq($table->productUuid(), $query->param()->string($productId)));
		$sql = $query->select();
		$result = $this->_driver->query($sql);
		return $result;
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