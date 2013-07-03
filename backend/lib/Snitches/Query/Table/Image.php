<?php
/**
 * (c) Josh Farr <j.wgasa@gmail.com>
 * 
 */
namespace Snitches\Query\Table;

use BT\Query\Db;
use BT\Query\Table;

class Image extends Table {
	/**
	 * Default constructor
	 * 
	 * @param Db $db
	 */
	public function __construct(Db $db) {
		parent::__construct($db, 'image');
	}


	/**
	 * Get the image_uuid table column definition
	 * 
	 * @return Column
	 */
	public function id() {
		return $this->column('image_uuid');
	}


	/**
	 * Get the product_uuid table column definition
	 * 
	 * @return Column
	 */
	public function productUuid() {
		return $this->column('product_uuid');
	}


	/**
	 * Get the shopify_id table column definition
	 * 
	 * @return Column
	 */
	public function shopifyId() {
		return $this->column('shopify_id');
	}


	/**
	 * Get the date_created_timestamp table column definition
	 * 
	 * @return Column
	 */
	public function dateCreatedTimestamp() {
		return $this->column('date_created_timestamp');
	}


	/**
	 * Get the date_updated_timestamp table column definition
	 * 
	 * @return Column
	 */
	public function dateUpdatedTimestamp() {
		return $this->column('date_updated_timestamp');
	}


	/**
	 * Get the position table column definition
	 * 
	 * @return Column
	 */
	public function position() {
		return $this->column('position');
	}


	/**
	 * Get the src table column definition
	 * 
	 * @return Column
	 */
	public function src() {
		return $this->column('src');
	}

}