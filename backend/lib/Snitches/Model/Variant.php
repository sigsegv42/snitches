<?php
/**
 * (c) Josh Farr <j.wgasa@gmail.com>
 */


namespace Snitches\Model;

use BT\Core\UUID;
use BT\Query\Query;

use Snitches\Query\Db\Snitches as Db;

class Variant extends Model {
	public $_uuid = null;
	public $_productId = null;
	public $_shopifyId = null;
	public $_created = null;
	public $_updated = null;
	public $_compareAtPrice = null;
	public $_fulfillmentService = null;
	public $_grams = 0;
	public $_inventoryManagement = null;
	public $_inventoryPolicy = null;
	public $_quantity = 1;
	public $_position = 1;
	public $_price = 0.00;
	public $_requiresShipping = null;
	public $_sku = null;
	public $_taxable = true;
	public $_title = '';
	public $_dirty = false;
	public $_product = null;
	public $_options = array();

	/**
	 * Hydrate the model's properties from a stdClass
	 *
	 * @param stdClass $obj object containing model properties
	 */
	public function hydrate($obj) {
		$this->_productId = $obj->product_id;
		$this->_shopifyId = $obj->id;
		$this->_created = new \DateTime($obj->created_at);
		$this->_updated = new \DateTime($obj->updated_at);
		$this->_compareAtPrice = $obj->compare_at_price;
		$this->_fulfillmentService = $obj->fulfillment_service;
		$this->_grams = $obj->grams;
		$this->_inventoryManagement = $obj->inventory_management;
		$this->_inventoryPolicy = $obj->inventory_policy;
		$this->_quantity = $obj->inventory_quantity;
		$this->_position = $obj->position;
		for ($i = 0; $i < 3; $i++) {
			$slot = 'option' . $i;
			$arr = get_object_vars($obj);
			if (array_key_exists($slot, $arr) && strlen($arr[$slot]) > 0) {
				$this->_options[$i] = array('name' => $arr[$slot]);
			}
		}
		$this->_price = $obj->price;
		$this->_requiresShipping = $obj->requires_shipping;
		$this->_sku = $obj->sku;
		if ($obj->taxable == 1) {
			$this->_taxable = true;
		}
		else {
			$this->_taxable = false;
		}
		$this->_title = $obj->title;
		$this->_dirty = true;
	}


	/**
	 * Convert the model into a json representation
	 *
	 * @return string
	 */
	public function dehydrate() {

	}


	/**
	 * Save the model to the local database
	 */
	public function save() {
		$insert = false;
		if ($this->_uuid === null) {
			$insert = true;
			$uuid = new UUID();
			$this->_uuid = $uuid->v4();
		}

		$query = new Query();
		$db = new Db();
		$table = $db->table(Db::TABLE_VARIANT);

		$query->
			column($table->shopifyId())->
			column($table->fulfillmentService())->
			column($table->grams())->
			column($table->inventoryPolicy())->
			column($table->inventoryQuantity())->
			column($table->position())->
			column($table->price())->
			column($table->requiresShipping())->
			column($table->sku())->
			column($table->dateCreatedTimestamp())->
			column($table->dateUpdatedTimestamp())->
			column($table->productUuid())->
			into($table);

		$values = array(
			$this->_shopifyId,
			$this->_fulfillmentService,
			$this->_grams,
			$this->_inventoryPolicy,
			$this->_quantity,
			$this->_position,
			$this->_price,
			$this->_requiresShipping,
			$this->_sku,
			$this->_created->format('U'),
			$this->_updated->format('U'),
			$this->_productId
		);
		if ($this->_compareAtPrice) {
			$query->column($table->compareAtPrice());
			$values[] = $this->_compareAtPrice;
		}
		if ($this->_inventoryManagement) {
			$query->column($table->inventoryManagement());
			$values[] = $this->_inventoryManagement;
		}

		$sql = null;
		if ($insert === true) {
			$query->column($table->id());
			$values[] = $this->_uuid;
			$sql = $query->insert();
		}
		else {
			$query->where($query->expr()->eq($table->id(), $query->param()->string($this->_uuid)));
			$sql = $query->update();
		}
		$this->_driver->prepare($sql);
		$result = $this->_driver->exec($values);
		$this->_dirty = false;

		$table = $db->table(Db::TABLE_VARIANT_OPTION);
		// save variant options
		$query = new Query();
		$matches = array();
		if ($insert !== true) {
			$query->
				column($table->id())->
				column($table->name())->
				column($table->position())->
				from($table)->
				where($query->expr()->eq($table->variantUuid(), $query->param()->string($this->_uuid)));
			$sql = $query->select();
			$result = $this->_driver->query($sql);
			foreach ($result as $record) {
				if (array_key_exists($record['position'], $this->_options)) {
					$this->_options[$record['position']]['id'] = $record['variant_option_uuid'];
					if ($this->_options[$record['position']]['name'] != $record['name']) {
						$query = new Query();
						$query->
							column($table->name())->
							into($table)->
							where($query->expr()->eq($table->id(), $query->param()->string($record['variant_option_uuid'])));
							$values = array(
								$this->_options[$record['position']]['name']
							);
							$sql = $query->update();
							$this->_driver->prepare($sql);
							$result = $this->_driver->exec($values);
					}
					$matches[] = $record['position'];
				}
			}
		}

		foreach ($this->_options as $slot => $option) {
			if (!in_array($slot, $matches)) {
				$uuid = new UUID();
				$optionId = $uuid->v4();
				$query = new Query();
				$query->
					column($table->id())->
					column($table->position())->
					column($table->name())->
					column($table->variantUuid())->
					into($table);
				$values = array(
					$optionId,
					$slot,
					$option['name'],
					$this->_uuid
				);
				$sql = $query->insert();

				$this->_driver->prepare($sql);
				$result = $this->_driver->exec($values);					
				$this->_options[$slot]['id'] = $optionId;
			}
		}
	}


	/**
	 * Load the model properties from the local database
	 *
	 * @param string $id the UUID id field of the model's db record
	 */
	public function load($id) {
		$query = new Query();
		$db = new Db();
		$table = $db->table(Db::TABLE_VARIANT);

		$query->
			column($table->shopifyId())->
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
			column($table->dateCreatedTimestamp())->
			column($table->dateUpdatedTimestamp())->
			column($table->id())->
			column($table->productUuid())->
			column($table->dirty())->
			from($table)->
			where($query->expr()->eq($table->id(), $query->param()->string($id)));
		$sql = $query->select();
		$result = $this->_driver->query($sql);
		if (sizeof($result) == 0) {
			return;
		}
		$result = $result[0];

		$this->_shopifyId = $result['shopify_id'];
		$this->_compareAtPrice = $result['compare_at_price'];
		$this->_fulfillmentService = $result['fulfillment_service'];
		$this->_grams = $result['grams'];
		$this->_inventoryManagement = $result['inventory_management'];
		$this->_inventoryPolicy = $result['inventory_policy'];
		$this->_quantity = $result['inventory_quantity'];
		$this->_position = $result['position'];
		$this->_price = $result['price'];
		$this->_requiresShipping = $result['requires_shipping'];
		$this->_sku = $result['sku'];
		$this->_created = new \DateTime();
		$this->_created->setTimestamp($result['date_created_timestamp']);
		$this->_updated = new \DateTime();
		$this->_updated->setTimestamp($result['date_updated_timestamp']);
		$this->_uuid = $result['variant_uuid'];
		$this->_productId = $result['product_uuid'];

		if ($result['dirty'] == 1) {
			$this->_dirty = true;
		}
		else {
			$this->_dirty = false;
		}
	}
}