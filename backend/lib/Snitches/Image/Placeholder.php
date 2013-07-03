<?php
/**
 * (c) Josh Farr <j.wgasa@gmail.com>
 * 
 */

namespace Snitches\Image;

use BT\Core\Log;
use BT\Rest\Client;

/**
 * Download a placeholder image using http://placehold.it/
 */
class Placeholder {
	protected $_log = null;
	protected $_outdir = null;

	/**
	 * Default constructor
	 *
	 * @param Log $log logger instance
	 * @param string $outdir output directory
	 */
	public function __construct(Log $log, $outdir) {
		$this->_log = $log;
		$this->_outdir = $outdir;
		if (substr($outdir, -1) != '/') {
			$this->_outdir .= '/';
		}
	}


	/**
	 * Fetch a placeholder image
	 *
	 * @param integer $width image width
	 * @param integer $height image height
	 * @param string $filename output filename
	 * @param string $text optional text to display in placeholder image
	 * @param string $background optional background hex color code
	 * @param string $foreground optional text hex color code
	 *
	 * @return boolean 
	 */
	public function fetch($width, $height, $filename, $text = null, $background = null, $foreground = null) {
		$url = 'http://placehold.it/' . $width . 'x' . $height;
		if ($background !== null) {
			$url .= '/' . $background;
		}
		if ($foreground !== null) {
			$url .= '/' . $foreground;
		}
		if ($text !== null) {
			$url .= '&text=' . $text;
		}
		$client = new Client($this->_log);
		$response = $client->request($url);
		$ret = file_put_contents($this->_outdir . $filename, $response['body']);
		if ($ret === false) {
			return false;
		}
		return true;
	}
}
