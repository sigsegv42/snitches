<?php
/**
 * (c) Josh Farr <j.wgasa@gmail.com>
 * 
 */
namespace Snitches\Query\Table;

use BT\Query\Db;
use BT\Query\Table;

class AttributeValue extends Table {
	/**
	 * Default constructor
	 * 
	 * @param Db $db
	 */
	public function __construct(Db $db) {
		parent::__construct($db, 'attribute_value');
	}


	/**
	 * Get the attribute_value_uuid table column definition
	 * 
	 * @return Column
	 */
	public function id() {
		return $this->column('attribute_value_uuid');
	}


	/**
	 * Get the attribute_kind_uuid table column definition
	 * 
	 * @return Column
	 */
	public function attributeKindUuid() {
		return $this->column('attribute_kind_uuid');
	}


	/**
	 * Get the t_value table column definition
	 * 
	 * @return Column
	 */
	public function tValue() {
		return $this->column('t_value');
	}


	/**
	 * Get the n_value table column definition
	 * 
	 * @return Column
	 */
	public function nValue() {
		return $this->column('n_value');
	}


	/**
	 * Get the b_value table column definition
	 * 
	 * @return Column
	 */
	public function bValue() {
		return $this->column('b_value');
	}


	/**
	 * Get the f_value table column definition
	 * 
	 * @return Column
	 */
	public function fValue() {
		return $this->column('f_value');
	}

}