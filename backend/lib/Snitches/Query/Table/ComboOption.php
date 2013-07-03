<?php
/**
 * (c) Josh Farr <j.wgasa@gmail.com>
 * 
 */
namespace Snitches\Query\Table;

use BT\Query\Db;
use BT\Query\Table;

class ComboOption extends Table {
	/**
	 * Default constructor
	 * 
	 * @param Db $db
	 */
	public function __construct(Db $db) {
		parent::__construct($db, 'combo_option');
	}


	/**
	 * Get the combo_option_uuid table column definition
	 * 
	 * @return Column
	 */
	public function id() {
		return $this->column('combo_option_uuid');
	}


	/**
	 * Get the combo_uuid table column definition
	 * 
	 * @return Column
	 */
	public function comboUuid() {
		return $this->column('combo_uuid');
	}


	/**
	 * Get the product_option_uuid table column definition
	 * 
	 * @return Column
	 */
	public function productOptionUuid() {
		return $this->column('product_option_uuid');
	}

}