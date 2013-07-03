<?php
/**
 * (c) Josh Farr <j.wgasa@gmail.com>
 * 
 */
namespace Snitches\Query\Table;

use BT\Query\Db;
use BT\Query\Table;

class ProductOption extends Table {
	/**
	 * Default constructor
	 * 
	 * @param Db $db
	 */
	public function __construct(Db $db) {
		parent::__construct($db, 'product_option');
	}


	/**
	 * Get the product_option_uuid table column definition
	 * 
	 * @return Column
	 */
	public function id() {
		return $this->column('product_option_uuid');
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
	 * Get the name table column definition
	 * 
	 * @return Column
	 */
	public function name() {
		return $this->column('name');
	}


	/**
	 * Get the title table column definition
	 * 
	 * @return Column
	 */
	public function title() {
		return $this->column('title');
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