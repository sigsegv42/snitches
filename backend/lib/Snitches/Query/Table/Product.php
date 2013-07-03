<?php
/**
 * (c) Josh Farr <j.wgasa@gmail.com>
 * 
 */
namespace Snitches\Query\Table;

use BT\Query\Db;
use BT\Query\Table;

class Product extends Table {
	/**
	 * Default constructor
	 * 
	 * @param Db $db
	 */
	public function __construct(Db $db) {
		parent::__construct($db, 'product');
	}


	/**
	 * Get the product_uuid table column definition
	 * 
	 * @return Column
	 */
	public function id() {
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
	 * Get the body_html table column definition
	 * 
	 * @return Column
	 */
	public function bodyHtml() {
		return $this->column('body_html');
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
	 * Get the handle table column definition
	 * 
	 * @return Column
	 */
	public function handle() {
		return $this->column('handle');
	}


	/**
	 * Get the product_type table column definition
	 * 
	 * @return Column
	 */
	public function productType() {
		return $this->column('product_type');
	}


	/**
	 * Get the published_scope table column definition
	 * 
	 * @return Column
	 */
	public function publishedScope() {
		return $this->column('published_scope');
	}


	/**
	 * Get the tags table column definition
	 * 
	 * @return Column
	 */
	public function tags() {
		return $this->column('tags');
	}


	/**
	 * Get the template_suffix table column definition
	 * 
	 * @return Column
	 */
	public function templateSuffix() {
		return $this->column('template_suffix');
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
	 * Get the vendor table column definition
	 * 
	 * @return Column
	 */
	public function vendor() {
		return $this->column('vendor');
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