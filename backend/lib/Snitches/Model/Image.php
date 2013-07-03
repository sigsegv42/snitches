<?php
/**
 * (c) Josh Farr <j.wgasa@gmail.com>
 */


namespace Snitches\Model;

use BT\Core\UUID;
use BT\Query\Query;

use Snitches\Query\Db\Snitches as Db;

class Image extends Model {
	public $_uuid = null;
	public $_created = null;
	public $_updated = null;
	public $_position = 1;
	public $_source = '';
	public $_productId = null;
	public $_shopifyId = null;
	public $_dirty = false;


	/**
	 * Hydrate the model's properties from a stdClass
	 *
	 * @param stdClass $obj object containing model properties
	 */
	public function hydrate($obj) {
		$this->_created = new \DateTime($obj->created_at);
		$this->_updated = new \DateTime($obj->updated_at);
		$this->_position = $obj->position;
		$this->_source = $obj->src;
		$this->_shopifyId = $obj->id;
		$this->_dirty = true;
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
		$table = $db->table(Db::TABLE_IMAGE);

		$query->
			column($table->position())->
			column($table->shopifyId())->
			column($table->src())->
			column($table->dateCreatedTimestamp())->
			column($table->dateUpdatedTimestamp())->
			column($table->productUuid())->
			into($table);

		$values = array(
			$this->_position,
			$this->_shopifyId,
			$this->_source,
			$this->_created->format('U'),
			$this->_updated->format('U'),
			$this->_productId
		);

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
	}


	/**
	 * Load the model properties from the local database
	 *
	 * @param string $id the UUID id field of the model's db record
	 */
	public function load($id) {
		$query = new Query();
		$db = new Db();
		$table = $db->table(Db::TABLE_IMAGE);

		$query->
			column($table->position())->
			column($table->src())->
			column($table->shopifyId())->
			column($table->dateCreatedTimestamp())->
			column($table->dateUpdatedTimestamp())->
			column($table->id())->
			column($table->productUuid())->
			from($table)->
			where($query->expr()->eq($table->id(), $query->param()->string($this->_uuid)));
		$sql = $query->select();
		$result = $this->_driver->query($sql);
		if (sizeof($result) == 0) {
			return;
		}
		$result = $result[0];

		$this->_position = $result['position'];
		$this->_source = $result['src'];
		$this->_shopifyId = $result['shopify_id'];
		$this->_created = new \DateTime();
		$this->_created->setTimestamp($result['date_created_timestamp']);
		$this->_updated = new \DateTime();
		$this->_updated->setTimestamp($result['date_updated_timestamp']);
		$this->_uuid = $result['image_uuid'];
		$this->_productId = $result['product_uuid'];
	}
}