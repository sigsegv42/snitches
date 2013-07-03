<?php
/**
 * (c) Josh Farr <j.wgasa@gmail.com>
 * 
 */
namespace Snitches\Query\Table;

use BT\Query\Db;
use BT\Query\Table;

class VariantOption extends Table {
	/**
	 * Default constructor
	 * 
	 * @param Db $db
	 */
	public function __construct(Db $db) {
		parent::__construct($db, 'variant_option');
	}


	/**
	 * Get the variant_option_uuid table column definition
	 * 
	 * @return Column
	 */
	public function id() {
		return $this->column('variant_option_uuid');
	}


	/**
	 * Get the product_option_uuid table column definition
	 * 
	 * @return Column
	 */
	public function productOptionUuid() {
		return $this->column('product_option_uuid');
	}


	/**
	 * Get the position table column definition
	 * 
	 * @return Column
	 */
	public function position() {
		return $this->column('position');
	}

}