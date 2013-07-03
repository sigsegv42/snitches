<?php
/**
 * (c) Josh Farr <j.wgasa@gmail.com>
 * 
 */
namespace Snitches\Query\Table;

use BT\Query\Db;
use BT\Query\Table;

class Combo extends Table {
	/**
	 * Default constructor
	 * 
	 * @param Db $db
	 */
	public function __construct(Db $db) {
		parent::__construct($db, 'combo');
	}


	/**
	 * Get the combo_uuid table column definition
	 * 
	 * @return Column
	 */
	public function id() {
		return $this->column('combo_uuid');
	}


	/**
	 * Get the variant_uuid table column definition
	 * 
	 * @return Column
	 */
	public function variantUuid() {
		return $this->column('variant_uuid');
	}

}