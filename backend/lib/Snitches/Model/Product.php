<?php
/**
 * (c) Josh Farr <j.wgasa@gmail.com>
 */


namespace Snitches\Model;


use BT\Core\UUID;
use BT\Query\Query;

use Snitches\Query\Db\Snitches as Db;


class Product extends Model {
	public $_uuid = null;
	public $_shopifyId = null;
	public $_body = '';
	public $_updated = null;
	public $_created = null;
	public $_handle = '';
	public $_type = null;
	public $_scope = '';
	public $_tags = '';
	public $_suffix = null;
	public $_title = '';
	public $_vendor = null;
	public $_dirty = false;
	public $_images = array();
	public $_variants = array();
	public $_options = array();


	/**
	 * Hydrate the model's properties from a stdClass
	 *
	 * @param stdClass $obj object containing model properties
	 */
	public function hydrate($obj) {
		$this->_body = $obj->body_html;
		$this->_shopifyId = $obj->id;
		$this->_handle = $obj->handle;
		$this->_type = $obj->product_type;
		$this->_suffix = $obj->template_suffix;
		$this->_title = $obj->title;
		$this->_scope = $obj->published_scope;
		$this->_tags = $obj->tags;
		$this->_vendor = $obj->vendor;
		$this->_updated = new \DateTime($obj->updated_at);
		$this->_created = new \DateTime($obj->created_at);
		$this->_dirty = true;
		foreach ($obj->options as $option) {
			$this->_options[$option->position] = array('name' => $option->name);
		}
	}


	/**
	 * Convert the model into a json representation
	 *
	 * @return string
	 */
	public function dehydrate() {
		$obj = new stdClass();
		$obj->title = $this->_title;
		$obj->body_html = $this->_body;
		$obj->vendor = $this->_vendor;
		$obj->product_type = $this->_type;
		$obj->tags = $this->_tags;
		$product = new stdClass();
		$product->product = $obj;
		$json = json_encode($product);
		return $json;
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
		$table = $db->table(Db::TABLE_PRODUCT);

		$query->
			column($table->bodyHtml())->
			column($table->shopifyId())->
			column($table->handle())->
			column($table->productType())->
			column($table->templateSuffix())->
			column($table->title())->
			column($table->publishedScope())->
			column($table->tags())->
			column($table->vendor())->
			column($table->dateCreatedTimestamp())->
			column($table->dateUpdatedTimestamp())->
			column($table->dirty())->
			into($table);

		$values = array(
			$this->_body,
			$this->_shopifyId,
			$this->_handle,
			$this->_type,
			$this->_suffix,
			$this->_title,
			$this->_scope,
			$this->_tags,
			$this->_vendor,
			$this->_created->format('U'),
			$this->_updated->format('U'),
		);
		if ($this->_dirty) {
			$values[] = 1;
		}
		else {
			$values[] = 0;
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

		// save product options
		$query = new Query();
		$table = $db->table(Db::TABLE_PRODUCT_OPTION);
		$matches = array();
		if ($insert !== true) {
			$query->
				column($table->id())->
				column($table->name())->
				column($table->position())->
				from($table)->
				where($query->expr()->eq($table->productUuid(), $query->param()->string($this->_uuid)));
			$sql = $query->select();
			$result = $this->_driver->query($sql);
			foreach ($result as $record) {
				if (array_key_exists($record['position'], $this->_options)) {
					$this->_options[$record['position']]['id'] = $record['product_option_uuid'];
					if ($this->_options[$record['position']]['name'] != $record['name']) {
						$query = new Query();
						$query->
							column($table->name())->
							into($table)->
							where($query->expr()->eq($table->id(), $query->param()->string($record['product_option_uuid'])));
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
					column($table->name())->
					column($table->position())->
					column($table->id())->
					column($table->productUuid())->
					into($table);
				$sql = $query->insert();
				$values = array(
					$option['name'],
					$slot,
					$optionId,
					$this->_uuid
				);
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
		$table = $db->table(Db::TABLE_PRODUCT);

		$query->
			column($table->bodyHtml())->
			column($table->shopifyId())->
			column($table->handle())->
			column($table->productType())->
			column($table->templateSuffix())->
			column($table->title())->
			column($table->publishedScope())->
			column($table->tags())->
			column($table->vendor())->
			column($table->dirty())->
			column($table->dateCreatedTimestamp())->
			column($table->dateUpdatedTimestamp())->
			column($table->id())->
			from($table)->
			where($query->expr()->eq($table->id(), $query->param()->string($this->_uuid)));
		$sql = $query->select();
		$result = $this->_driver->query($sql);
		if (sizeof($result) == 0) {
			return;
		}
		$result = $result[0];

		$this->_body = $result['body_html'];
		$this->_shopifyId = $result['shopify_id'];
		$this->_handle = $result['handle'];
		$this->_type = $result['product_type'];
		$this->_suffix = $result['template_suffix'];
		$this->_title = $result['title'];
		$this->_scope = $result['published_scope'];
		$this->_tags = $result['tags'];
		$this->_vendor = $result['vendor'];
		$this->_created = new \DateTime();
		$this->_created->setTimestamp($result['date_created_timestamp']);
		$this->_updated = new \DateTime();
		$this->_updated->setTimestamp($result['date_updated_timestamp']);
		if ($result['dirty'] == 1) {
			$this->_dirty = true;
		}
		else {
			$this->_dirty = false;
		}
		$this->_uuid = $result['product_uuid'];
	}
}
