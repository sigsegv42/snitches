<?php
/**
 * (c) Josh Farr <j.wgasa@gmail.com>
 */

namespace Snitches\Model;

use BT\Query\Driver;
use BT\Core\Log;

/**
 * An abstract base for domain models
 */
abstract class Model {
	protected $_driver = null;
	protected $_log = null;

	/**
	 * Default constructor
	 *
	 * @param Driver $driver database driver
	 * @param Log $log log instance
	 */
	public function __construct(Driver $driver, Log $log) {
		$this->_driver = $driver;
		$this->_log = $log;
	}


	/**
	 * Hydrate a model's properties from a stdClass
	 *
	 * @param stdClass $obj object containing model properties
	 */
	abstract public function hydrate($obj);


	/**
	 * Convert the model into a json representation
	 *
	 * @return string
	 */
	abstract public function dehydrate();


	/**
	 * Save the model to the local database
	 */
	abstract public function save();


	/**
	 * Load the model properties from the local database
	 *
	 * @param string $id the UUID id field of the model's db record
	 */
	abstract public function load($id);
}