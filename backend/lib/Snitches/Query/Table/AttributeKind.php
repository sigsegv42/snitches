<?php
/**
 * (c) Josh Farr <j.wgasa@gmail.com>
 * 
 */
namespace Snitches\Query\Table;

use BT\Query\Db;
use BT\Query\Table;

class AttributeKind extends Table {
	/**
	 * Default constructor
	 * 
	 * @param Db $db
	 */
	public function __construct(Db $db) {
		parent::__construct($db, 'attribute_kind');
	}


	/**
	 * Get the attribute_kind_uuid table column definition
	 * 
	 * @return Column
	 */
	public function id() {
		return $this->column('attribute_kind_uuid');
	}


	/**
	 * Get the abbreviation table column definition
	 * 
	 * @return Column
	 */
	public function abbreviation() {
		return $this->column('abbreviation');
	}


	/**
	 * Get the description table column definition
	 * 
	 * @return Column
	 */
	public function description() {
		return $this->column('description');
	}


	/**
	 * Get the value_type table column definition
	 * 
	 * @return Column
	 */
	public function valueType() {
		return $this->column('value_type');
	}

}