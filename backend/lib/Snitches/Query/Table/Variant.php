<?php
/**
 * (c) Josh Farr <j.wgasa@gmail.com>
 * 
 */
namespace Snitches\Query\Table;

use BT\Query\Db;
use BT\Query\Table;

class Variant extends Table {
	/**
	 * Default constructor
	 * 
	 * @param Db $db
	 */
	public function __construct(Db $db) {
		parent::__construct($db, 'variant');
	}


	/**
	 * Get the variant_uuid table column definition
	 * 
	 * @return Column
	 */
	public function id() {
		return $this->column('variant_uuid');
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
	 * Get the compare_at_price table column definition
	 * 
	 * @return Column
	 */
	public function compareAtPrice() {
		return $this->column('compare_at_price');
	}


	/**
	 * Get the fulfillment_service table column definition
	 * 
	 * @return Column
	 */
	public function fulfillmentService() {
		return $this->column('fulfillment_service');
	}


	/**
	 * Get the grams table column definition
	 * 
	 * @return Column
	 */
	public function grams() {
		return $this->column('grams');
	}


	/**
	 * Get the inventory_management table column definition
	 * 
	 * @return Column
	 */
	public function inventoryManagement() {
		return $this->column('inventory_management');
	}


	/**
	 * Get the inventory_policy table column definition
	 * 
	 * @return Column
	 */
	public function inventoryPolicy() {
		return $this->column('inventory_policy');
	}


	/**
	 * Get the inventory_quantity table column definition
	 * 
	 * @return Column
	 */
	public function inventoryQuantity() {
		return $this->column('inventory_quantity');
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
	 * Get the price table column definition
	 * 
	 * @return Column
	 */
	public function price() {
		return $this->column('price');
	}


	/**
	 * Get the requires_shipping table column definition
	 * 
	 * @return Column
	 */
	public function requiresShipping() {
		return $this->column('requires_shipping');
	}


	/**
	 * Get the sku table column definition
	 * 
	 * @return Column
	 */
	public function sku() {
		return $this->column('sku');
	}


	/**
	 * Get the taxable table column definition
	 * 
	 * @return Column
	 */
	public function taxable() {
		return $this->column('taxable');
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
	 * Get the dirty table column definition
	 * 
	 * @return Column
	 */
	public function dirty() {
		return $this->column('dirty');
	}

}