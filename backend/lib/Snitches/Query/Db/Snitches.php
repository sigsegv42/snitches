<?php
/**
 * (c) Josh Farr <j.wgasa@gmail.com>
 * 
 */

namespace Snitches\Query\Db;

use BT\Query\Db;

class Brewtheory implements Db {
	/**
	 * Get the physical name of the database
	 * 
	 * @return string
	 */
	public function name() {
		return 'snitches';
	}


	/**
	 * Get the DSN of the database (name used by zend db)
	 * 
	 * @return string
	 */
	public function dsn() {
		return 'snitches';
	}

	const TABLE_ATTRIBUTE_KIND = 'attribute_kind';
	const TABLE_ATTRIBUTE_VALUE = 'attribute_value';
	const TABLE_IMAGE = 'image';
	const TABLE_PRODUCT = 'product';
	const TABLE_PRODUCT_OPTION = 'product_option';
	const TABLE_VARIANT = 'variant';
	const TABLE_VARIANT_OPTION = 'variant_option';

	/**
	 * Get a reference to a table in this database
	 * 
	 * @param string $table a TABLE_* constant representing the table name
	 * 
	 * @return Table
	 */
	public function table($table) {
		$allTables = array(
			self::TABLE_ATTRIBUTE_KIND,
			self::TABLE_ATTRIBUTE_VALUE,
			self::TABLE_IMAGE,
			self::TABLE_PRODUCT,
			self::TABLE_PRODUCT_OPTION,
			self::TABLE_VARIANT,
			self::TABLE_VARIANT_OPTION,
		);
		if (!in_array($table, $allTables)) {
			throw new \InvalidArgumentException(sprintf('Expected table const type but received "%s" instead.', $table));
		}
		$tableInstance = null;
		switch ($table) {
			case self::TABLE_ATTRIBUTE_KIND:
				$tableInstance = new Table\AttributeKind($this);
				break;
			case self::TABLE_ATTRIBUTE_VALUE:
				$tableInstance = new Table\AttributeValue($this);
				break;
			case self::TABLE_IMAGE:
				$tableInstance = new Table\Image($this);
				break;
			case self::TABLE_PRODUCT:
				$tableInstance = new Table\Product($this);
				break;
			case self::TABLE_PRODUCT_OPTION:
				$tableInstance = new Table\ProductOption($this);
				break;
			case self::TABLE_VARIANT:
				$tableInstance = new Table\Variant($this);
				break;
			case self::TABLE_VARIANT_OPTION:
				$tableInstance = new Table\VariantOption($this);
				break;
		}
		return $tableInstance;
	}
}